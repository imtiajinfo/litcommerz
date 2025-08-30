<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Product;
use App\Models\ProductSection;
use App\Models\Brand;
use App\Models\Blog;
use App\Models\Offer;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $data['home_categories'] = Category::where([
            ['categories.status', 1],
            ['categories.home_show', 1]
        ])
        ->distinct('categoires.name')
        ->orderBy('sl', 'asc')
        ->limit(15)
        ->get();

        $data['home_banners'] = Banner::where([
            ['status', 1],
            ['type', 1]
        ])
        ->get();

        $data['middel_banners'] = Banner::where([
            ['status', 1],
            ['type', 2]
        ])->get();

        $data['special_products'] = Product::whereIn('id', ProductSection::where('section', 1)->pluck('product_id')->toArray())
        ->where([
            ['status', 1],
        ])
        ->orderByRaw("CASE WHEN products.sl = 0 THEN 1 ELSE 0 END, products.sl ASC")
        ->limit(30)
        ->get();

        $data['hot_products'] = Product::whereIn('id', ProductSection::where('section', 2)->pluck('product_id')->toArray())
        ->where([
            ['status', 1],
        ])
        ->orderByRaw("CASE WHEN products.sl = 0 THEN 1 ELSE 0 END, products.sl ASC")
        ->limit(30)
        ->get();

        $data['new_arrivals_products'] = Product::whereIn('id', ProductSection::where('section', 3)->pluck('product_id')->toArray())
        ->where([
            ['status', 1],
        ])
        ->orderByRaw("CASE WHEN products.sl = 0 THEN 1 ELSE 0 END, products.sl ASC")
        ->limit(30)
        ->get();

        $data['blogs'] = Blog::where([
            ['status', 1],
        ])
        ->limit(20)
        ->get();
        $data['offers'] = Offer::with('offerProducts.product')
            ->where('status', 1)
            ->where('home_show', 1)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->whereHas('offerProducts.product')
            ->get()
            ->map(function($offer) {
                $endDate = Carbon::parse($offer->end_date);
                if ($endDate->isToday() || $endDate->isFuture()) {
                    $endDate = $endDate->endOfDay();
                }
                $offer->formatted_end_date = $endDate->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');

                return $offer;
            });

        $data['brands'] = Brand::where('status', 1)->get();

        if(session()->has('carts')){
            $data['carts'] = array_column(session()->get('carts'), 'product_id');
        }else{
            $data['carts'] = [];
        }

        return view('web.home', $data);
    }

}
