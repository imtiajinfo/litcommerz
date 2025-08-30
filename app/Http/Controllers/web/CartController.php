<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Coupon;
use Helper;
use Validator;

class CartController extends Controller
{
    public function index(){
        $coupon = [];
        if(session()->has('coupons')){
            $coupon = session()->get('coupons');
        }
        return view('web.carts.index', compact('coupon'));
    }

    public function cart_add(Request $request){
        if($request->id){
            $product = Product::find($request->id);
            if(!empty($product) && ($product->available_stock > 0)){

                $total_cart = 0;
                $total_cart_price = 0;

                if(session()->has('carts')){
                    $carts = session()->get('carts');
                    if(!in_array($request->id, array_column($carts, 'product_id'))){
                        array_push($carts, array('product_id'=>$request->id, 'qty'=>1));
                    }else{
                        $index = array_search($request->id, array_column($carts, 'product_id'));

                        if ($index !== false) {
                            $carts[$index]['qty'] += 1;
                        }
                    }
                    session()->put('carts', $carts);
                }else{
                    $carts = [array('product_id'=>$request->id, 'qty'=>1)];
                    session()->put('carts', $carts);
                }

                $total_cart = count($carts);
                $total_cart_price = Helper::cart_total();
                $shipping = $total_cart_price;

                return response()->json(['success'=>1, 'mgs'=>'Product Added Successfully', 'total_cart' => $total_cart, 'total_cart_price' => ((Helper::setting())->currency_icon.number_format($total_cart_price,2)), 'shipping' => ((Helper::setting())->currency_icon.number_format($shipping,2))]);

            }else{
                return response()->json(['error'=>1, 'mgs'=>'Product has out of stock!']);
            }
        }else{
            return response()->json(['error'=>1, 'mgs'=>'Product Not Found!']);
        }
    }

    public function cart_destroy(){
        session()->forget('carts');
        return redirect('/');
    }

    public function ajax_cart_view(){
        return view('web.carts.ajax_view');
    }

    public function buy_now_cart($id){
        if($id){
            $product = Product::find($id);
            if(!empty($product) && ($product->available_stock > 0)){

                $total_cart = 0;
                $total_cart_price = 0;

                if(session()->has('carts')){
                    $carts = session()->get('carts');
                    if(!in_array($id, array_column($carts, 'product_id'))){
                        array_push($carts, array('product_id'=>$id, 'qty'=>1));
                    }
                    session()->put('carts', $carts);
                }else{
                    $carts = [array('product_id'=>$id, 'qty'=>1)];
                    session()->put('carts', $carts);
                }

                $total_cart = count($carts);
                $total_cart_price = Helper::cart_total();

                return redirect('/checkout')->with(['success'=>1, 'mgs'=>'Product Added Successfully']);

            }else{
                return back()->with(['error'=>1, 'mgs'=>'Product has out of stock!']);
            }
        }else{
            return back()->with(['error'=>1, 'mgs'=>'Product Not Found!']);
        }
    }

    public function details_buy_now_cart(Request $request, $id){
        if($id){
            $product = Product::find($id);
            if(!empty($product) && ($product->available_stock > 0)){

                $total_cart = 0;
                $total_cart_price = 0;

                $qty = $request->qty > 0 ? $request->qty : 1;

                if(session()->has('carts')){
                    $carts = session()->get('carts');
                    if(!in_array($id, array_column($carts, 'product_id'))){
                        array_push($carts, array('product_id'=>$id, 'qty'=>$qty));
                    }
                    session()->put('carts', $carts);
                }else{
                    $carts = [array('product_id'=>$id, 'qty'=>$qty)];
                    session()->put('carts', $carts);
                }

                $total_cart = count($carts);
                $total_cart_price = Helper::cart_total();
                if($request->status == 1){
                    return redirect('/checkout')->with(['success'=>1, 'mgs'=>'Product Added Successfully']);;
                }
                return redirect()->back()->with(['success'=>1, 'mgs'=>'Product Added Successfully']);;

            }else{
                return back()->with(['error'=>1, 'mgs'=>'Product has out of stock!']);
            }
        }else{
            return back()->with(['error'=>1, 'mgs'=>'Product Not Found!']);
        }
    }

    public function single_cart_destroy($index){
        $carts = session()->get('carts');
        unset($carts[$index]);
        $carts = array_values($carts);
        session()->put('carts', $carts);
        return redirect()->back()->with(['success'=>1, 'mgs'=>'Product Successfully Removed!']);
    }
    
    public function cart_remove_ajax(Request $request){
        $carts = session()->get('carts');
        unset($carts[$request->index]);
        $carts = array_values($carts);
        session()->put('carts', $carts);
        return response()->json(['success'=>1, 'mgs'=>'Product Successfully Removed!']);
    }

    public function cart_plus(Request $request){
        $carts = session()->get('carts');
        $carts[$request->index]['qty'] += 1;
        session()->put('carts', $carts);

        $product = Product::find($carts[$request->index]['product_id']);
        $product_price = $product->sell_price - $product->offer_amount;
        $total_price = $carts[$request->index]['qty'] * $product_price;

        $cart_total = Helper::cart_total();
        $before_discount = number_format(Helper::cart_before_discount_total(), 2);
        $shipping = 0;
        $sub_total = number_format($cart_total, 2);
        $grand_total = number_format($cart_total + $shipping, 2);

        return response()->json([
            'qty' => $carts[$request->index]['qty'],
            'price' => $total_price,
            'sub_total' => $sub_total,
            'shipping' => number_format($shipping, 2),
            'grand_total' => $grand_total,
            'before_discount' => $before_discount
        ]);
    }
    public function cart_minus(Request $request){
        $carts = session()->get('carts');
        if($carts[$request->index]['qty'] > 1){
            $carts[$request->index]['qty'] -= 1;
            session()->put('carts', $carts);
        }

        $product = Product::find($carts[$request->index]['product_id']);
        $product_price = $product->sell_price - $product->offer_amount;
        $total_price = $carts[$request->index]['qty'] * $product_price;

        $cart_total = Helper::cart_total();
        $shipping = 0;
        $before_discount = number_format(Helper::cart_before_discount_total(), 2);
        $sub_total = number_format($cart_total, 2);
        $grand_total = number_format($cart_total + $shipping, 2);

        return response()->json([
            'qty' => $carts[$request->index]['qty'],
            'price' => $total_price,
            'sub_total' => $sub_total,
            'shipping' => number_format($shipping, 2),
            'grand_total' => $grand_total,
            'before_discount' => $before_discount
        ]);
    }
    public function cart_qty_change(Request $request){
        $carts = session()->get('carts');
        if($request->qty > 0){
            $carts[$request->index]['qty'] = $request->qty;
            session()->put('carts', $carts);
        }else{
            $carts[$request->index]['qty'] = 1;
            session()->put('carts', $carts);
        }

        $product = Product::find($carts[$request->index]['product_id']);
        $product_price = $product->sell_price - $product->offer_amount;

        $total_price = $carts[$request->index]['qty'] * $product_price;

        $sub_total = number_format(Helper::cart_total(),2);

        return response()->json(['qty'=>$carts[$request->index]['qty'], 'price'=>number_format($total_price,2), 'sub_total'=>$sub_total]);
    }

    public function coupon_apply(Request $request){
        $validator =  Validator::make($request->all(), [
            'coupon_code' => 'required',
        ]);
        if ($validator->passes()) {
            $coupon = Coupon::where([['coupon_code', $request->coupon_code],['status', 1]])->first();

            if($coupon){
                
                $date_check = Coupon::where([['coupon_code', $request->coupon_code],['status', 1]])->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->count();

                if($date_check > 0){
                    $total_amount = Helper::cart_total();

                    if($coupon->minimum_sale_amount <= $total_amount){
                        $discountAmount = $coupon->type == 2 ? round(($total_amount * $coupon->amount) / 100) : $coupon->amount;
                        session()->put('coupons', [
                            'coupon_code' => $request->coupon_code,
                            'amount'      => $discountAmount
                        ]);

                        return redirect()->back()->with(['success' => 1, 'mgs' => 'Coupon Applied Successfully.']);
                    }else{
                        return redirect()->back()->with(['error' => 1, 'mgs' => 'Sorry! Your Amount less than Offer Amount!.']);
                    }

                }else{
                    return redirect()->back()->with(['error' => 1, 'mgs' => 'Coupon Date is Invalid!.']);
                }

            }else{
                return redirect()->back()->with(['error' => 1, 'mgs' => 'Coupon Code Invalid!.']);
            }
        }else{
            return response()->json([$validator->errors()]);
        }
    }
}
