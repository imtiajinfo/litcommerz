<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSection;

class CouponOfferController extends Controller
{
    public function index(){
        $data['coupons'] = Coupon::where([['status', 1]])->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->get();

        return view('web.coupon_offer.index', $data);
    }
    public function special_offer($slug, Request $request){

        $offer = $data['offer'] = Offer::where([['status', 1], ['slug', $slug]])->firstOrFail();

        $search = $data['search'] = $request->search;
        $min_price = $data['min_price'] = $request->min;
        $max_price = $data['max_price'] = $request->max;
        $perPage = $data['perPage'] = $request->perPage??10;
        $orderBy = $data['orderBy'] = $request->orderBy;

        switch ($orderBy) {
            case 'asc':
                $order = 'asc';
                $orderField = 'products.id';
                break;
            case 'desc':
                $order = 'desc';
                $orderField = 'products.id';
                break;
            case 'low-price':
                $order = 'asc';
                $orderField = 'products.sell_price';
                break;
            case 'high-price':
                $order = 'desc';
                $orderField = 'products.sell_price';
                break;
            case 'a-z':
                $order = 'asc';
                $orderField = 'products.product_name';
                break;
            case 'z-a':
                $order = 'desc';
                $orderField = 'products.product_name';
                break;
            
            default:
                $order = 'asc';
                $orderField = 'id';
                break;
        }

        if($orderBy == 'asc'){
            $data['headTitle'] = 'All Products';
        }elseif($orderBy == 'desc'){
            $data['headTitle'] = 'New Collections';
        }else{
            $data['headTitle'] = 'Shop Products';
        }

        $data['products'] = Product::where('status', 1)
            ->whereHas('offerProduct', function($q) use ($offer) {
                $q->where('offer_id', $offer->id);
            })
            ->where(function ($query) use ($search){
                $query->where('products.product_name', 'like', '%'.$search.'%');
            })
            ->orderBy($orderField, $order)
            ->paginate($perPage);

        if(session()->has('carts')){
            $data['carts'] = array_column(session()->get('carts'), 'product_id');
        }else{
            $data['carts'] = [];
        }
        $data['categories'] = Category::where('status', 1)->get();

        return view('web.coupon_offer.special_offer', $data);
    }

    public function hot_items(Request $request)
    {
        $search = $data['search'] = $request->search;
        $min_price = $data['min_price'] = $request->min;
        $max_price = $data['max_price'] = $request->max;
        $perPage = $data['perPage'] = $request->perPage ?? 10;
        $orderBy = $data['orderBy'] = $request->orderBy;

        switch ($orderBy) {
            case 'asc':
                $order = 'asc';
                $orderField = 'products.id';
                break;
            case 'desc':
                $order = 'desc';
                $orderField = 'products.id';
                break;
            case 'low-price':
                $order = 'asc';
                $orderField = 'products.sell_price';
                break;
            case 'high-price':
                $order = 'desc';
                $orderField = 'products.sell_price';
                break;
            case 'a-z':
                $order = 'asc';
                $orderField = 'products.product_name';
                break;
            case 'z-a':
                $order = 'desc';
                $orderField = 'products.product_name';
                break;
            default:
                $order = 'asc';
                $orderField = 'id';
                break;
        }

        $data['headTitle'] = 'Hot Items';

        $data['products'] = Product::whereIn('id', ProductSection::where('section', 2)->pluck('product_id')->toArray())
            ->where('status', 1)
            ->where(function ($query) use ($search) {
                $query->where('products.product_name', 'like', '%'.$search.'%');
            })
            ->orderBy($orderField, $order)
            ->paginate($perPage);

        $data['carts'] = session()->has('carts') ? array_column(session()->get('carts'), 'product_id') : [];
        $data['categories'] = Category::where('status', 1)->get();

        return view('web.coupon_offer.special_offer', $data);
    }

    public function new_arrivals(Request $request)
    {
        $search = $data['search'] = $request->search;
        $min_price = $data['min_price'] = $request->min;
        $max_price = $data['max_price'] = $request->max;
        $perPage = $data['perPage'] = $request->perPage ?? 10;
        $orderBy = $data['orderBy'] = $request->orderBy;

        switch ($orderBy) {
            case 'asc':
                $order = 'asc';
                $orderField = 'products.id';
                break;
            case 'desc':
                $order = 'desc';
                $orderField = 'products.id';
                break;
            case 'low-price':
                $order = 'asc';
                $orderField = 'products.sell_price';
                break;
            case 'high-price':
                $order = 'desc';
                $orderField = 'products.sell_price';
                break;
            case 'a-z':
                $order = 'asc';
                $orderField = 'products.product_name';
                break;
            case 'z-a':
                $order = 'desc';
                $orderField = 'products.product_name';
                break;
            default:
                $order = 'asc';
                $orderField = 'id';
                break;
        }

        $data['headTitle'] = 'New Arrivals';

        $data['products'] = Product::whereIn('id', ProductSection::where('section', 3)->pluck('product_id')->toArray())
            ->where('status', 1)
            ->where(function ($query) use ($search) {
                $query->where('products.product_name', 'like', '%'.$search.'%');
            })
            ->orderBy($orderField, $order)
            ->paginate($perPage);

        $data['carts'] = session()->has('carts') ? array_column(session()->get('carts'), 'product_id') : [];
        $data['categories'] = Category::where('status', 1)->get();

        return view('web.coupon_offer.special_offer', $data);
    }

}
