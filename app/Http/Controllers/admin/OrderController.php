<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OldOrderRecord;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\StockSummery;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\StockLedger;
use Validator;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use App\Models\UserPoint;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';
        $status = $data['status'] = $request->status ?? '';

        $from_date = $data['from_date'] = $request->from_date;
        $to_date = $data['to_date'] = $request->to_date;


        switch ($status) {
            case 'pending':
                $order_status = 0;
                break;
            case 'confirmed':
                $order_status = 1;
                break;
            case 'ready':
                $order_status = 2;
                break;
            case 'near':
                $order_status = 4;
                break;
            case 'cancel':
                $order_status = 6;
                break;
            case 'complete':
                $order_status = 5;
                break;
            case 'on-the-way':
                $order_status = 3;
                break;
            case 'preparing':
                $order_status = 7;
                break;
            case 'verifying':
                $order_status = 8;
                break;
            
            default:
                $order_status = 'null';
                break;
        }

        $data['orders'] = Order::orderBy('id', 'desc')
            ->when($search, function ($query, $search) {
                $query->where('id', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                      });
            })
            ->where(function ($query) use ($order_status){
                if($order_status || $order_status == 0){
                    if($order_status != 'null' || $order_status == 0){
                        $query->where('track_status', $order_status);
                    }
                }
            })
            ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);
            })

            ->paginate($perpage);

            $totalSum = Order::when($search, function ($query) use ($search) {
                $query->where('id', 'like', '%'.$search.'%');
            })
            ->when($order_status || $order_status === 0, function ($query) use ($order_status) {
                if ($order_status !== 'null') {
                    $query->where('track_status', $order_status);
                }
            })
            ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);
            })
            ->sum('total_amount');

        $data['totalSum'] = $totalSum;

        return view('admin.order.index', $data);
    }

    public function invoice($id){
        if(Auth::check() && Auth::user()->status == 1){

            
            $data['status'] = 1;
            $data['invoice'] = $invoice = Order::find($id);

            if(Auth::user()->role != 1){
                if(Auth::id() != $invoice->user_id){
                    abort(403);
                    return false;
                }
            }
    
            $data['products'] = Order::join('order_details', 'order_details.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_details.product_id')
                ->where('orders.id', $id)
                ->select('orders.id', 'products.product_name', 'order_details.quantity', 'order_details.product_price', 'orders.created_at', 'order_details.product_id', 'order_details.discount')
                ->get();
                
            return view('web.order.invoice', $data);
        }else{
            return redirect('/');
        }
    }

    public function purchase_invoice($id){
        if(Auth::check() && Auth::user()->status == 1){

            
            $data['status'] = 1;
            $data['invoice'] = $invoice = Order::find($id);

            if(Auth::user()->role != 1){
                if(Auth::id() != $invoice->user_id){
                    abort(403);
                    return false;
                }
            }
    
            $data['products'] = Order::join('order_details', 'order_details.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_details.product_id')
                ->where('orders.id', $id)
                ->select('orders.id', 'products.product_name','products.buy_price', 'order_details.quantity', 'order_details.product_price', 'orders.created_at', 'order_details.product_id', 'order_details.discount')
                ->get();

            $data['type'] = 'pdf';
            
            $invoiceNo = $id;
            $date = date('dmY_his');

            $fileName = "PurchaseInvoiceNo_{$invoiceNo}_{$date}.pdf";

            $pdf = Pdf::loadView('web.order.purchase_invoice', $data)
                      ->setPaper('A4', 'portrait');

            return $pdf->download($fileName);
        }else{
            return redirect('/');
        }
    }

    public function invoice_pdf($id){
        if(Auth::check() && Auth::user()->status == 1){

            
            $data['status'] = 1;
            $data['invoice'] = $invoice = Order::find($id);

            if(Auth::user()->role != 1){
                if(Auth::id() != $invoice->user_id){
                    abort(403);
                    return false;
                }
            }
    
            $data['products'] = Order::join('order_details', 'order_details.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_details.product_id')
                ->where('orders.id', $id)
                ->select('orders.id', 'products.product_name', 'order_details.quantity', 'order_details.product_price', 'orders.created_at', 'order_details.product_id', 'order_details.discount')
                ->get();
                
            $data['type'] = 'pdf';

            $invoiceNo = $id;
            $date = date('dmY_his');

            $fileName = "InvoiceNo_{$invoiceNo}_{$date}.pdf";
                
            $pdf = Pdf::loadView('web.order.invoice', $data)->setPaper('A4', 'portrait');
 
            return $pdf->download($fileName);

        }else{
            return redirect('/login');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $data['order'] = Order::findOrFail($id);
        $data['products'] = Order::join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('units', 'units.id', '=', 'products.unit')
            ->where('orders.id', $id)
            ->select('orders.id', 'products.product_name', 'order_details.quantity', 'order_details.product_price', 'orders.created_at', 'order_details.product_id', 'order_details.discount', 'products.slug', 'products.weight', 'units.short_name')
            ->get();

        if($request->status == 1){
            return view('admin.order.shipping_info', $data);
        }elseif($request->status == 2){
            return view('admin.order.order_products', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['order'] = Order::findOrFail($id);

        return view('admin.order.order_status', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator =  Validator::make($request->all(), [
            'status'        => 'required',
        ]);

        if ($validator->passes()) {

            Order::find($id)->update(['track_status'=>$request->status]);

            if($request->status == 6){
                $order = Order::find($id);

                $stock_ledger = new StockLedger();
                $stock_ledger->user_id    = Auth::id();
                $stock_ledger->order_id   = $id;
                $stock_ledger->product_id = 0;
                $stock_ledger->type       = 2;
                $stock_ledger->qty        = $order->total_product;
                $stock_ledger->save();

            }
            if ($request->status == 5) {
                $order = Order::find($id);
                
                if ($order && $order->user_id != 0) {
                    $user_id = $order->user_id;

                    $order_amount = max(0, $order->total_amount - $order->shipping_amount - $order->coupon - $order->points_used);

                    $user_point_count = UserPoint::where('user_id', $user_id)->count();
                    $point = $user_point_count == 0 ? 500 : round($order_amount / 100);

                    if ($point > 0) {
                        UserPoint::create([
                            'user_id'  => $user_id,
                            'order_id' => $order->id,
                            'point'    => $point,
                        ]);
                    }
                }
            }

            return response()->json(['success' => true, 'mgs' => 'Track Status Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    public function order_edit(Request $request, $id){

        $data['oldOrderRecord'] = OldOrderRecord::where('order_id', $id)->first();

        $data['id'] = $id;
        $data['order'] = Order::findOrFail($id);
        $data['all_products'] = Product::with('first_img')->get();
        $data['products'] = Order::join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('units', 'units.id', '=', 'products.unit')
            ->where('orders.id', $id)
            ->select('orders.id', 'products.product_name', 'order_details.quantity', 'order_details.product_price', 'orders.created_at', 'order_details.product_id', 'order_details.discount', 'products.slug', 'products.weight', 'units.short_name')
            ->get();
        $data['subcategories'] = SubCategory::all();
        $data['categories'] = Category::all();
        $data['productList'] = Product::with('first_img')->latest()->get();

        return view('admin.order.edit', $data);
    }

    public function order_update(Request $request, $id){

        DB::beginTransaction();

            $old_order = Order::findOrFail($id);
            $old_order_record = OldOrderRecord::where('order_id', $id)->count();

            $cart_total = 0;
            foreach($request->product_price as $key => $orderPriceData){
                $cart_total += ($orderPriceData - $request->discount[$key]) * $request->quantity[$key]; 
            }

            $order = Order::find($id)->update([
                'shipping_amount' => $request->shipping_amount,
                'notes'            => $request->note,
                'total_product'   => count($request->product_id),
                'payment_status'  => 0,
                'payeble_amount'  => $cart_total - $old_order->coupon - $old_order->points_used + $request->shipping_amount,
                'total_amount'    => $cart_total - $old_order->coupon - $old_order->points_used + $request->shipping_amount,
                'due_amount'      => $cart_total - $old_order->coupon - $old_order->points_used + $request->shipping_amount,
                'collect_amount'  => $cart_total - $old_order->coupon - $old_order->points_used + $request->shipping_amount
            ]);

            $orderDetails = OrderDetails::where('order_id', $id)->get();

            if($old_order_record == 0){
                OldOrderRecord::create([
                    'order_id' => $id,
                    'value' => json_encode($orderDetails)
                ]);
            }

            foreach($orderDetails as $orderData){
                $product = Product::find($orderData->product_id);
                $product->update([
                    'available_stock' => $product->available_stock + $orderData->quantity,
                ]);
            }
            OrderDetails::where('order_id', $id)->delete();

            $stockLedger = StockLedger::where('order_id', $id)->get();
            foreach($stockLedger as $stockLedgerItem){
                StockSummery::where('stock_id', $stockLedgerItem->id)->delete();
            }

            StockLedger::where('order_id', $id)->delete();

            foreach($request->product_id as $key => $product_id){

                $qty = $request->quantity[$key];
                $sell_price = $request->product_price[$key];
                $offer_amount = $request->discount[$key];

                OrderDetails::create([
                    'user_id'       => $old_order->user_id,
                    'order_id'      => $id,
                    'product_id'    => $product_id,
                    'product_price' => $sell_price,
                    'discount'      => $offer_amount,
                    'quantity'      => $qty,
                ]);
                $stock_ledger = StockLedger::create([
                    'user_id'       => $old_order->user_id,
                    'order_id'      => $id,
                    'product_id'    => $product_id,
                    'type'          => 2,
                    'qty'           => $qty,
                ]);

                StockSummery::create([
                    'stock_id' => $stock_ledger->id,
                    'product_id' => $product_id,
                    'quantity' => $qty,
                    'amount' => $product->sell_price,
                ]);

                $product = Product::find($product->id);

                $product->update([
                    'available_stock' => $product->available_stock - $qty,
                ]);
                
            } 

        DB::commit();

        return response()->json(['success' => true, 'mgs' => 'Order Updated Successfully Updated']);
    }

    public function load_product(Request $request)
    {
        $category_id = $request->category_id;
        $sub_category_id = $request->sub_category_id;

        $products = Product::with('first_img')
            ->when($category_id, function ($query) use ($category_id) {
                $query->where('products.category_id', $category_id)
                      ->orWhereHas('categories', function ($q) use ($category_id) {
                          $q->where('category_id', $category_id);
                      });
            })
            ->when($sub_category_id, function ($query) use ($sub_category_id) {
                $query->where('products.subcategory_id', $sub_category_id)
                      ->orWhereHas('categories', function ($q) use ($sub_category_id) {
                          $q->where('subcategory_id', $sub_category_id);
                      });
            })
            ->get();

        return view('admin.product.load_product', compact('products'));
    }

}
