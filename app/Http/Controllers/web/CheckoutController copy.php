<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentTemp;
use App\Models\PaymentInfo;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\StockLedger;
use App\Models\Product;
use App\Models\ShippingInfo;
use App\Models\StockSummery;
use App\Models\Coupon;
use App\Models\UserPoint;
use App\Models\UserDetails;
use App\Models\User;
use Validator;
use Auth;
use Str;
use Helper;
use DB;
use Hash;
use App\Models\Region;
use App\Models\DeliveryCharge;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function index()
    {
        $profile = UserDetails::where('user_id', Auth::id())->first();

        $prefectures = DB::table('regions')
        ->select('id', 'name', 'delivery_charge')
        ->get()
        ->map(function ($prefecture) {
            return [
                'id' => $prefecture->id,
                'name' => $prefecture->name,
                'charge' => $prefecture->delivery_charge,
            ];
        });
        return view('web.checkout.index', compact('profile', 'prefectures'));
    }

    public function store(Request $request)
    {
      // return response()->json($request->all());
        if(!session()->has('carts')){
            return response()->json(['error' => 1, 'mgs' => 'Your cart is empty!']);
        }

        $carts = session()->get('carts');
        $userData = $this->handleUser($request); // returns ['user_id'=>..,'user_type'=>..]

        // Validation
        $this->validateCheckout($request);

        // Coupon & Points
        $couponData = $this->getCouponData();
        $pointsData = $this->getPointsData($request, $userData['user_id']);

        // Generate transaction
        $tran_id = uniqid();
        $cart_products = Helper::cart_products();
        $cart_total = Helper::cart_total();
        $shipping = $request->calculated_shipping ?? 0;

        // Save temp payment
        PaymentTemp::create([
            'user_id' => $userData['user_id'],
            'train_id' => $tran_id,
            'details' => json_encode($request->all()),
            'products' => json_encode($cart_products),
        ]);

        // Dynamic Payment Gateway
        if ($request->payment_type == 'stripe') {
            session(['payment_data' => [
                'formData' => $request->all(),
                'netAmount' => $cart_total + $shipping - $pointsData['points_discount']
            ]]);

            $session = $this->initiateStripePayment($cart_total + $shipping - $pointsData['points_discount']);
            return $session; // JSON with redirectUrl
        }

    }

    private function handleUser(Request $request)
    {
        if($request->checkout_type == 1){
            if(Auth::check()) return ['user_id'=>Auth::id(),'user_type'=>1];

            $validator = Validator::make($request->all(), [
                'name'=>'required|max:255',
                'email'=>'required|email|max:255|unique:users',
                'password'=>'required|min:6',
                'confirmed'=>'required_with:password|same:password|min:6'
            ]);

            if($validator->fails()) response()->json(['errors'=>$validator->errors()]);

            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'verification_code'=>uniqid(),
                'verified'=>1
            ]);
            Auth::loginUsingId($user->id);
            return ['user_id'=>$user->id,'user_type'=>1];
        }

        return ['user_id'=>0,'user_type'=>2]; // Guest checkout
    }

    private function validateCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
            'address'=>'required|max:255',
            'prefecture'=>'required',
            'postcode'=>'required',
            'payment_type'=>'required',
            'shipping_option'=>'required|in:same,different',
            'terms_conditions'=>'required'
        ]);

        if($request->shipping_option == 'different'){
            $validator->addRules([
                'shipping_name'=>'required',
                'shipping_email'=>'required|email',
                'shipping_address'=>'required|max:255',
                'shipping_prefecture'=>'required',
                'shipping_postcode'=>'required',
            ]);
        }

        if($validator->fails()){
            response()->json(['error'=>true,'message'=>'Validation failed','errors'=>$validator->errors()],422)->send();
            exit;
        }
    }

    private function getCouponData()
    {
        $coupon_amount = session('coupons.amount',0);
        $coupon_id = 0;
        if(session()->has('coupons')){
            $couponCode = session('coupons.coupon_code');
            $coupon_id = Coupon::where('coupon_code',$couponCode)->first()->id ?? 0;
        }
        return ['coupon_amount'=>$coupon_amount,'coupon_id'=>$coupon_id];
    }

    private function getPointsData(Request $request, $user_id)
    {
        if($request->use_points && $request->points_used>0 && $user_id){
            $points_used = min($request->points_used, Helper::userPoints());
            return ['points_used'=>$points_used,'points_discount'=>$points_used];
        }
        return ['points_used'=>0,'points_discount'=>0];
    }

    private function processOrder($request, $cart_products, $carts, $userData, $tran_id, $shipping, $couponData, $pointsData)
    {
        DB::beginTransaction();
        try {
            // Order creation
            $order = Order::create([
                'train_id'=>$tran_id,
                'user_id'=>$userData['user_id'],
                'user_type'=>$userData['user_type'],
                'total_product'=>count($carts),
                'payment_status'=>0,
                'payeble_amount'=>$cart_total + $shipping - $pointsData['points_discount'],
                'total_amount'=>$cart_total + $shipping - $pointsData['points_discount'],
                'discount'=>0,
                'coupon'=>$couponData['coupon_amount'],
                'coupon_id'=>$couponData['coupon_id'],
                'points_used'=>$pointsData['points_used'],
                'shipping_amount'=>$shipping,
                'collect_amount'=>$cart_total + $shipping - $pointsData['points_discount'],
                'due_amount'=>$cart_total + $shipping - $pointsData['points_discount'],
                'is_shipping'=>($request->shipping_option=='different')?1:0,
                'notes'=>$request->order_note,
            ]);

            $user_order_info = json_encode([
                'name'=>$request->name,
                'email'=>$request->email,
                'address'=>$request->address,
                'apt_suite'=>$request->apt_suite,
                'prefecture'=>Region::find($request->prefecture)?->name ?? '',
                'city'=>$request->city ?? '',
                'postcode'=>$request->postcode,
                'phone'=>$request->phone,
            ]);

            $shipping_info = ($request->shipping_option=='same') ? $user_order_info : json_encode([
                'name'=>$request->shipping_name,
                'email'=>$request->shipping_email,
                'address'=>$request->shipping_address,
                'apt_suite'=>$request->shipping_apt_suite,
                'prefecture'=>Region::find($request->shipping_prefecture)?->name ?? '',
                'city'=>$request->shipping_city ?? '',
                'postcode'=>$request->shipping_postcode,
                'phone'=>$request->shipping_phone,
            ]);

            ShippingInfo::create([
                'user_id'=>$userData['user_id'],
                'order_id'=>$order->id,
                'user_info'=>$user_order_info,
                'shipping_info'=>$shipping_info
            ]);

            if($pointsData['points_used']>0){
                UserPoint::create(['user_id'=>$userData['user_id'],'order_id'=>$order->id,'point'=>-$pointsData['points_used']]);
            }

            // Process each product
            foreach($cart_products as $product){
                $qty = $carts[Helper::cart_single_product_index($product->id)]['qty'] ?? 1;

                OrderDetails::create([
                    'user_id'=>$userData['user_id'],
                    'order_id'=>$order->id,
                    'product_id'=>$product->id,
                    'product_price'=>$product->sell_price,
                    'discount'=>$product->offer_amount,
                    'quantity'=>$qty
                ]);

                $stock_ledger = StockLedger::create([
                    'user_id'=>$userData['user_id'],
                    'order_id'=>$order->id,
                    'product_id'=>$product->id,
                    'type'=>2,
                    'qty'=>$qty
                ]);

                StockSummery::create([
                    'stock_id'=>$stock_ledger->id,
                    'product_id'=>$product->id,
                    'quantity'=>$qty,
                    'amount'=>$product->sell_price
                ]);

                $product->decrement('available_stock',$qty);
            }

            session()->forget('carts');
            session()->forget('coupons');

            DB::commit();
            return response()->json(['success'=>1,'mgs'=>'Order Placed Successfully','order_id'=>$order->id]);
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error'=>1,'mgs'=>'Something went wrong: '.$e->getMessage()]);
        }
    }

    private function initiateStripePayment($amount)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

      $session = StripeSession::create([
          'payment_method_types' => ['card'],
          'line_items' => [[
              'price_data' => [
                  'currency' => 'bdt', // <-- use lowercase 'bdt'
                  'product_data' => ['name' => 'Order Payment'],
                  'unit_amount' => intval($amount * 100), // amount in paisa (1 BDT = 100 paisa)
              ],
              'quantity' => 1,
          ]],
          'mode' => 'payment',
          'success_url' => route('stripe.resumeOrderFlow'),
          'cancel_url' => route('payment.cancel'),
      ]);


        // return the URL in JSON
        return response()->json(['success' => true, 'redirectUrl' => $session->url]);
    }

    public function resumeOrderFlow(Request $request)
    {
        // Retrieve payment data stored in session
        $paymentData = session('payment_data');
        if(!$paymentData){
            return redirect()->route('checkout.index')->with('error', 'Payment session expired.');
        }

        $formData = $paymentData['formData'];
        $netAmount = $paymentData['netAmount'];

        // Get carts, products, user info
        $carts = session('carts', []);
        $cart_products = Helper::cart_products();
        $userData = $this->handleUser(new Request($formData));

        $shipping = $formData['calculated_shipping'] ?? 0;
        $couponData = $this->getCouponData();
        $pointsData = $this->getPointsData(new Request($formData), $userData['user_id']);
        $tran_id = uniqid(); // or you can persist it in session if you want the same ID

        // Process the order
        return $this->processOrder(
            new Request($formData),
            $cart_products,
            $carts,
            $userData,
            $tran_id,
            $shipping,
            $couponData,
            $pointsData
        );
    }

    public function paymentCancel()
    {
        // Optionally, clear Stripe session data
        session()->forget('payment_data');

        // Redirect back to cart with message
        return redirect()->route('checkout.index')->with('error', 'Payment was cancelled.');
    }


    // public function store(Request $request)
    // {
    //     if(session()->has('carts')){
    //         $carts = session()->get('carts');
    //     }else{
    //         return response()->json(['error' => 1, 'mgs' => 'Sorry! You have no cart! please select product and order.']);
    //     }

    //     if($request->checkout_type == 1){
    //         if(Auth::check()){
    //             $user_id = Auth::id();
    //             $user_type = 1;
    //         }else{
    //             $validator = Validator::make($request->all(), [
    //                 'name' => 'required|max:255',
    //                 'email' => 'required|email|max:255|unique:users',
    //                 'password' => 'required|min:6',
    //                 'confirmed' => 'required_with:password|same:password|min:6'
    //             ]);
                
    //             if ($validator->passes()) {
    //                 $token = uniqid();
    //                 $user = User::create([
    //                     'name' => $request->name,
    //                     'email' => $request->email,
    //                     'password' => Hash::make($request->password),
    //                     'verification_code' => $token,
    //                     'verified' => 1
    //                 ]);
    //                 Auth::loginUsingId($user->id);
    //                 $user_id = Auth::id();
    //                 $user_type = 1;
    //             }else{
    //                 return response()->json(['errors' => $validator->errors()]);
    //             }
    //         }
    //     }else{
    //         $user_id = 0;
    //         $user_type = 2;
    //     }

    //       $validator = Validator::make($request->all(), [
    //           'name' => 'required',
    //           'email' => 'required|email',
    //           'address' => 'required|max:255',
    //           'prefecture' => 'required',
    //           'city' => 'nullable',
    //           'postcode' => 'required',
    //           'phone' => 'nullable',
    //           'terms_conditions' => 'required',
    //           'payment_type' => 'required',
    //           'payment_type' => 'required',
    //           'shipping_option' => 'required|in:same,different',
    //       ]);

    //     if ($request->shipping_option == 'different') {
    //         $validator->addRules([
    //             'shipping_name' => 'required',
    //             'shipping_email' => 'required|email',
    //             'shipping_address' => 'required|max:255',
    //             'shipping_prefecture' => 'required',
    //             'shipping_city' => 'nullable',
    //             'shipping_postcode' => 'required',
    //             'shipping_phone' => 'nullable',
    //         ]);
    //     }

    //     if ($validator->fails()) {
    //           return response()->json([
    //             'error'   => true,
    //             'message' => 'Validation failed',
    //             'errors'  => $validator->errors()
    //         ], 422);
    //     }

    //     // $coupon_amount = $this->couponCheck();
    //     $coupon_amount = session('coupons.amount', 0);
    //     $coupon_id = 0;
        
    //     if(session()->has('coupons')){
    //         $couponCode = (session()->get('coupons'))['coupon_code'];
    //         $coupon = Coupon::where('coupon_code', $couponCode)->first();
    //         $coupon_id = $coupon->id ?? 0;
    //     }

    //     $points_used = 0;
    //     $points_discount = 0;
    //     if ($request->use_points && $request->points_used > 0 && $user_id != 0) {
    //         $points_used = min($request->points_used, Helper::userPoints());
    //         $points_discount = $points_used;
    //     }

    //     $tran_id = uniqid();
    //     $cart_products = Helper::cart_products();
    //     $cart_total = Helper::cart_total();
    //     $shipping = $request->calculated_shipping ?? 0;

    //     $data = json_encode([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'postcode' => $request->postcode,
    //         'payment_type' => $request->payment_type,
    //         'total_product' => count($carts),
    //         'points_used' => $points_used,
    //     ]);

    //     $user_order_info = json_encode([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'address' => $request->address,
    //         'apt_suite' => $request->apt_suite,
    //         'prefecture' => Region::find($request->prefecture)?->name ?? '',
    //         'city' => $request->city ?? '',
    //         'postcode' => $request->postcode,
    //         'phone' => $request->phone,
    //     ]);

    //     if ($request->shipping_option == 'same') {
    //         $shipping_info = $user_order_info;
    //     } else {
    //         $shipping_info = json_encode([
    //             'name' => $request->shipping_name,
    //             'email' => $request->shipping_email,
    //             'address' => $request->shipping_address,
    //             'apt_suite' => $request->shipping_apt_suite,
    //             'prefecture' => Region::find($request->shipping_prefecture)?->name ?? '',
    //             'city' => $request->shipping_city ?? '',
    //             'postcode' => $request->shipping_postcode,
    //             'phone' => $request->shipping_phone,
    //         ]);
    //     }

    //     PaymentTemp::create([
    //         'user_id' => $user_id,
    //         'train_id' => $tran_id,
    //         'details' => $data,
    //         'products' => json_encode($cart_products),
    //     ]);

    //     // Process cash on delivery
    //     if($request->payment_type == 'cash_on_delivary'){
    //         DB::beginTransaction();

    //         try {
    //             $order = Order::create([
    //                 'train_id' => $tran_id,
    //                 'user_id' => $user_id,
    //                 'user_type' => $user_type,
    //                 'total_product' => count($carts),
    //                 'payment_status' => 0,
    //                 'payeble_amount' => $cart_total + $shipping - $points_discount,
    //                 'total_amount' => $cart_total + $shipping - $points_discount,
    //                 'discount' => 0,
    //                 'coupon' => $coupon_amount,
    //                 'coupon_id' => $coupon_id,
    //                 'points_used' => $points_used,
    //                 'shipping_amount' => $shipping,
    //                 'collect_amount' => $cart_total + $shipping - $points_discount,
    //                 'due_amount' => $cart_total + $shipping - $points_discount,
    //                 'is_shipping' => ($request->shipping_option == 'different') ? 1 : 0,
    //                 'notes' => $request->order_note,
    //             ]);

    //             ShippingInfo::create([
    //                 'user_id' => $user_id,
    //                 'order_id' => $order->id,
    //                 'user_info' => $user_order_info,
    //                 'shipping_info' => $shipping_info,
    //             ]);

    //             if ($points_used > 0) {
    //                 UserPoint::create([
    //                     'user_id' => $user_id,
    //                     'order_id' => $order->id,
    //                     'point' => -$points_used
    //                 ]);
    //             }

    //             // Process each product in cart
    //             foreach($cart_products as $product) {
    //                 $qty = $carts[(Helper::cart_single_product_index($product->id))]['qty'];

    //                 OrderDetails::create([
    //                     'user_id' => $user_id,
    //                     'order_id' => $order->id,
    //                     'product_id' => $product->id,
    //                     'product_price' => $product->sell_price,
    //                     'discount' => $product->offer_amount,
    //                     'quantity' => $qty,
    //                 ]);

    //                 $stock_ledger = StockLedger::create([
    //                     'user_id' => $user_id,
    //                     'order_id' => $order->id,
    //                     'product_id' => $product->id,
    //                     'type' => 2, // Assuming 2 means outbound
    //                     'qty' => $qty,
    //                 ]);

    //                 StockSummery::create([
    //                     'stock_id' => $stock_ledger->id,
    //                     'product_id' => $product->id,
    //                     'quantity' => $qty,
    //                     'amount' => $product->sell_price,
    //                 ]);

    //                 // Update product stock
    //                 $product->decrement('available_stock', $qty);
    //             }

    //             // Clear session data
    //             session()->forget('carts');
    //             session()->forget('coupons');
                
    //             DB::commit();
                
    //             return response()->json([
    //                 'success' => 1, 
    //                 'mgs' => 'Order Placed Successfully', 
    //                 'order_id' => $order->id
    //             ]);

    //         } catch (\Exception $e) {
    //             DB::rollBack();
    //             return response()->json([
    //                 'error' => 1, 
    //                 'mgs' => 'Something went wrong: '.$e->getMessage()
    //             ]);
    //         }
    //     }

    //     return response()->json(['error' => 1, 'mgs' => 'Something Went wrong!.']);
    // }

    private function couponCheck(){
        if(session()->has('coupons')){
            $couponCode = (session()->get('coupons'))['coupon_code'];

            $coupon = Coupon::where([['coupon_code', $couponCode],['status', 1]])->first();

            if($coupon){
                
                $date_check = Coupon::where([['coupon_code', $couponCode],['status', 1]])->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->count();

                if($date_check > 0){
                    $total_amount = Helper::cart_total();

                    if($coupon->minimum_sale_amount <= $total_amount){
                        return $coupon->type == 2 ? round(($total_amount * $coupon->amount) / 100) : $coupon->amount;
                    }else{
                        return 0;
                    }

                }else{
                    return 0;
                }

            }else{
                return 0;
            }

        }else{
            return 0;
        }
    }
}
