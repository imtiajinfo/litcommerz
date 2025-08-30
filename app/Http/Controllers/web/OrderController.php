<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    public function index(Request $request){
        $search = $request->search;
        $data['orders'] = Order::where(function ($query) use ($search){
                if($search){
                    $query->where('id', 'like', '%'.$search.'%');
                }
            })
            ->latest()
            ->where('user_id', Auth::id())
            ->paginate(10);

        return view('web.order.index', $data);
    }
    public function invoice($id){
        $data['invoice'] = $order = Order::find($id);
        // if($order->user_type == 1){
        //     return redirect('/login');
        // }

        $data['products'] = Order::join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('units', 'units.id', '=', 'products.unit')
            ->where('orders.id', $id)
            ->select('orders.id', 'products.product_name', 'order_details.quantity', 'order_details.product_price', 'orders.created_at', 'order_details.product_id', 'orders.coupon', 'order_details.discount', 'products.weight', 'units.short_name')
            ->get();
            
        return view('web.order.invoice1', $data);
    }
    public function order_success($id){
        return view('web.order.success', compact('id'));
    }
}
