<?php

use App\Models\Setting;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\ProductImages;
use App\Models\Brand;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;

class Helper{

    public static function setting(){
        $setting = Setting::find(1);
        return $setting;
    }
    public static function categories(){
        $categories = Category::limit(8)->get();
        return $categories;
    }
    public static function brands(){
        $brands = Brand::limit(8)->get();
        return $brands;
    }
    public static function cart_products(){
        $products = [];
        if(session()->has('carts')){
            $product_ids = session()->get('carts');
            $products = Product::whereIn('id', array_column($product_ids, 'product_id'))->get();
        }
        return $products;
    }
    public static function cart_single_product($pro_id){
        $products = [];
        $result = null;
        if(session()->has('carts')){
            $carts = session()->get('carts');
            foreach ($carts as $index => $item) {
                if (@$item['product_id'] == $pro_id) {
                    $result = $item;
                    return $result;
                }
            }
            
        }
        return $result;
    }
    public static function cart_single_product_index($pro_id){
        $products = [];
        $result = null;
        if(session()->has('carts')){
            $carts = session()->get('carts');
            foreach ($carts as $index => $item) {
                if (@$item['product_id'] == $pro_id) {
                    return $index;
                }
            }
            
        }
        return $result;
    }

    public static function cart_total()
    {
        $cart_total = 0;

        if (session()->has('carts')) {
            $carts = session()->get('carts');

            $products = Product::whereIn('id', array_column($carts, 'product_id'))->get();

            foreach ($carts as $cart) {
                $product = $products->where('id', $cart['product_id'])->first();
                if ($product) {
                    $price = ($product->offer_amount > 0)
                        ? ($product->sell_price - $product->offer_amount)
                        : $product->sell_price;

                    $cart_total += $price * $cart['qty'];
                }
            }
        }

        $coupon_amount = 0;
        if (session()->has('coupons')) {
            $coupon = session()->get('coupons');
            $coupon_amount = $coupon['amount'] ?? 0;
        }

        return $cart_total - $coupon_amount;
    }

    public static function cart_before_discount_total() {
        $cart_total = 0;

        if(session()->has('carts')) {
            $carts = session()->get('carts');
            $products = Product::whereIn('id', array_column($carts, 'product_id'))->get();

            foreach($products as $key => $product){
                $cart_total += (($product->sell_price - $product->offer_amount) * $carts[$key]['qty']);
            }
        }

        return $cart_total;
    }

    public static function wishlist_pro_ids(){
        if(Auth::check()){

            $product_ids = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();

        }else{
            $product_ids = [];
        }
        return $product_ids;
    }
    public static function product_first_img($id){
        $img = ProductImages::where('product_id', $id)->first();
        return $img;
    }
    public static function sidebarCategories(){
        $categories = Category::where('status', 1)
                ->distinct('name')
                // ->limit(10)
                ->orderBy('sl', 'asc')
                ->get();
        return $categories;
    }
    public static function sidebarCategory_offers(){
        $category_offers = Offer::where('offers.status', 1)
        ->distinct('offers.name')
        // ->limit(8)
        ->orderBy('sl', 'asc')
        ->get();

        return $category_offers;
    }

    public static function singleProductInfo($id){
       $product = Product::find($id);

        return $product;
    }

    public static function userPoints()
    {
        if (Auth::check()) {
            return Auth::user()->points()->sum('point');
        }
        return 0;
    }
}