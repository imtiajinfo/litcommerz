<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use Helper;
use Auth;

class ProductController extends Controller
{
    public function pro_details($pro_slug){
        $data['product'] = $product = Product::where('slug',$pro_slug)->first();
        $data['meta_title']       = $product->meta_title ?? '';
        $data['meta_description'] = $product->meta_description ?? '';
        $data['meta_keywords']    = $product->meta_keywords ?? '';
        $data['meta_og_image']    = $product->meta_og_image ? asset('frontend/images/product/og/'.$product->meta_og_image) : '';
        $data['meta_og_alt']      = $product->meta_og_alt ?? '';

        $data['products'] = Product::where([
            ['status', 1],
            ['category_id', $product->category_id]
        ])
        ->orderByRaw("CASE WHEN products.sl = 0 THEN 1 ELSE 0 END, products.sl ASC")
        ->limit(20)
        ->get();

        if(session()->has('carts')){
            $data['carts'] = array_column(session()->get('carts'), 'product_id');
        }else{
            $data['carts'] = [];
        }

        $data['reviews'] = Review::where('product_id', $product->id)->orderBy('id', 'desc')->where('status', 1)->paginate(5);
        $data['user_review'] = Review::where('user_id', @Auth::id())->where('product_id', $product->id)->orderBy('id', 'desc')->paginate(5);
        $data['rating'] = round(($product->reviews)->avg('rating'), 1) ?? 5;
        $data['total_rating'] = @($product->reviews)->where('status', 1)->count('id') ?? 5;

        return view('web.product.details',$data);
    }
}
