<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function shop(Request $request){
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
            ->where(function ($query) use ($search){
                $query->where('products.product_name', 'like', '%'.$search.'%');
            })
            ->where(function ($q) use ($min_price, $max_price){
                if($min_price && $max_price){
                    $q->whereBetween('products.sell_price', [$min_price, $max_price]);
                }
            })
            // ->orderByRaw("CASE WHEN products.sl = 0 THEN 1 ELSE 0 END, products.sl ASC")
            ->orderBy($orderField, $order)
            ->paginate($perPage);

        if(session()->has('carts')){
            $data['carts'] = array_column(session()->get('carts'), 'product_id');
        }else{
            $data['carts'] = [];
        }
        $data['categories'] = Category::where('status', 1)->get();

        return view('web.product.shop', $data);
    }

    public function category_product(Request $request, $category_slug)
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
                $order = null;
                $orderField = null;
                break;
        }

        if ($orderBy == 'asc') {
            $data['headTitle'] = 'All Products';
        } elseif ($orderBy == 'desc') {
            $data['headTitle'] = 'New Collections';
        } else {
            $data['headTitle'] = 'Shop Products';
        }

        $data['category_slug'] = $category_slug;

        $query = Product::with('categories')
            ->whereHas('categories', function ($q) use ($category_slug) {
                $q->where('slug', $category_slug);
            })
            ->where('status', 1);

        if ($search) {
            $query->where('product_name', 'like', '%' . $search . '%');
        }

        if ($min_price !== null) {
            $query->where('sell_price', '>=', $min_price);
        }

        if ($max_price !== null) {
            $query->where('sell_price', '<=', $max_price);
        }

        if (!$orderBy && !$search && $min_price === null && $max_price === null) {
            $query->join('category_products', 'products.id', '=', 'category_products.product_id')
                ->where('category_products.category_id', function ($subquery) use ($category_slug) {
                    $subquery->select('id')->from('categories')->where('slug', $category_slug)->limit(1);
                })
                // Treat sl=0 as highest number so it sorts after others (starting from 1)
                ->orderByRaw('CASE WHEN category_products.sl = 0 THEN 99999 ELSE category_products.sl END ASC')
                ->orderBy('products.product_name', 'asc')
                ->select('products.*');
        } else {
            $query->orderBy($orderField, $order);
        }

        $data['products'] = $query->paginate($perPage);

        $data['category'] = $category = Category::where('slug', $category_slug)->first();

        if (session()->has('carts')) {
            $data['carts'] = array_column(session()->get('carts'), 'product_id');
        } else {
            $data['carts'] = [];
        }

        $data['categories'] = Category::where('status', 1)->get();
        $data['sub_categories'] = SubCategory::where('category_id', @$category->id)->get();

        return view('web.product.shop', $data);
    }

    public function subcategory_product(Request $request, $subcategory_slug)
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
                $order = null;
                $orderField = null;
                break;
        }

        if ($orderBy == 'asc') {
            $data['headTitle'] = 'All Products';
        } elseif ($orderBy == 'desc') {
            $data['headTitle'] = 'New Collections';
        } else {
            $data['headTitle'] = 'Shop Products';
        }

        $data['subcategory_slug'] = $subcategory_slug;
        $sub_id = SubCategory::where('slug', $subcategory_slug)->value('id');

        if (!$orderBy && !$search && $min_price === null && $max_price === null) {
            $data['products'] = Product::whereHas('categories', function ($q) use ($sub_id) {
                    $q->whereExists(function ($query) use ($sub_id) {
                        $query->select(DB::raw(1))
                            ->from('category_products')
                            ->whereColumn('category_products.category_id', 'categories.id')
                            ->where('category_products.subcategory_id', $sub_id)
                            ->whereColumn('category_products.product_id', 'products.id');
                    });
                })
                ->join('category_products', function ($join) use ($sub_id) {
                    $join->on('products.id', '=', 'category_products.product_id')
                        ->where('category_products.subcategory_id', $sub_id);
                })
                ->where('products.status', 1)
                ->orderByRaw('CASE WHEN category_products.sl = 0 THEN 99999 ELSE category_products.sl END ASC')
                ->orderBy('products.product_name', 'asc')
                ->select('products.*')
                ->paginate($perPage);
        } else {
            $data['products'] = Product::with('subcategory')
                ->whereHas('categories', function ($q) use ($sub_id) {
                    $q->whereExists(function ($query) use ($sub_id) {
                        $query->select(DB::raw(1))
                            ->from('category_products')
                            ->whereColumn('category_products.category_id', 'categories.id')
                            ->where('category_products.subcategory_id', $sub_id)
                            ->whereColumn('category_products.product_id', 'products.id');
                    });
                })
                ->where('status', 1)
                ->when($search, function ($q) use ($search) {
                    $q->where('product_name', 'like', '%' . $search . '%');
                })
                ->when($min_price !== null, function ($q) use ($min_price) {
                    $q->where('sell_price', '>=', $min_price);
                })
                ->when($max_price !== null, function ($q) use ($max_price) {
                    $q->where('sell_price', '<=', $max_price);
                })
                ->orderBy($orderField, $order)
                ->paginate($perPage);
        }

        $data['subcategory'] = $subcategory = SubCategory::where('slug', $subcategory_slug)->first();
        $data['category'] = Category::where('id', $subcategory->category_id)->first();

        $data['carts'] = session()->has('carts') ? array_column(session()->get('carts'), 'product_id') : [];

        $data['subcategories'] = SubCategory::where('status', 1)->get();

        return view('web.product.sub_category_product', $data);
    }

    public function shop_ajax(Request $request){
        $search = $data['search'] = $request->search;
        $min_price = $data['min_price'] = $request->min;
        $max_price = $data['max_price'] = $request->max;
        $perPage = $data['perPage'] = $request->perPage??10;
        $orderBy = $data['orderBy'] = $request->orderBy;
        $loaded = $request->loaded ? explode(',', $request->loaded) : [];

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
        $category_slug = $request->category_slug;
        $subcategory_slug = $request->subcategory_slug;
        $offer_id = $request->offer_id;

        if($category_slug){

            $data['products'] = Product::where('status', 1)

                ->when(!empty($loaded), function ($q) use ($loaded) {
                    $q->whereNotIn('products.id', $loaded);
                })
                ->where(function ($query) use ($search){
                    if($search){
                        $query->where('products.product_name', 'like', '%'.$search.'%');
                    }
                })
                ->whereHas('categories', function ($q) use ($category_slug) {
                    if ($category_slug) {
                        $q->where('slug', $category_slug);
                    }
                })
                ->where(function ($q) use ($min_price, $max_price){
                    if($min_price && $max_price){
                        $q->whereBetween('products.sell_price', [$min_price, $max_price]);
                    }
                })
                ->where(function ($offer) use ($offer_id){
                    if($offer_id){
                        $offer->where('offer_category_id', $offer_id);
                    }
                })
                // ->orderByRaw("CASE WHEN products.sl = 0 THEN 1 ELSE 0 END, products.sl ASC")
                ->orderBy($orderField, $order)
                ->paginate($perPage);
                
        }elseif($subcategory_slug){

            $data['products'] = Product::where('status', 1)

                ->when(!empty($loaded), function ($q) use ($loaded) {
                    $q->whereNotIn('products.id', $loaded);
                })
                ->where(function ($query) use ($search){
                    if($search){
                        $query->where('products.product_name', 'like', '%'.$search.'%');
                    }
                })
                ->whereHas('categories', function ($q) use ($subcategory_slug) {
                    if ($subcategory_slug) {
                        $sub_id = \App\Models\SubCategory::where('slug', $subcategory_slug)->value('id');
                        $q->whereExists(function ($query) use ($sub_id) {
                            $query->select(\DB::raw(1))
                                  ->from('category_products')
                                  ->whereColumn('category_products.category_id', 'categories.id')
                                  ->where('category_products.subcategory_id', $sub_id)
                                  ->whereColumn('category_products.product_id', 'products.id');
                        });
                    }
                })
                ->where(function ($q) use ($min_price, $max_price){
                    if($min_price && $max_price){
                        $q->whereBetween('products.sell_price', [$min_price, $max_price]);
                    }
                })
                ->where(function ($offer) use ($offer_id){
                    if($offer_id){
                        $offer->where('offer_category_id', $offer_id);
                    }
                })
                // ->orderByRaw("CASE WHEN products.sl = 0 THEN 1 ELSE 0 END, products.sl ASC")
                ->orderBy($orderField, $order)
                ->paginate($perPage);
        }else{
            $data['products'] = Product::where('status', 1)

                ->when(!empty($loaded), function ($q) use ($loaded) {
                    $q->whereNotIn('products.id', $loaded);
                })
                ->where(function ($query) use ($search){
                    if($search){
                        $query->where('products.product_name', 'like', '%'.$search.'%');
                    }
                })
                ->where(function ($q) use ($min_price, $max_price){
                    if($min_price && $max_price){
                        $q->whereBetween('products.sell_price', [$min_price, $max_price]);
                    }
                })
                ->where(function ($offer) use ($offer_id){
                    if($offer_id){
                        $offer->where('offer_category_id', $offer_id);
                    }
                })
                // ->orderByRaw("CASE WHEN products.sl = 0 THEN 1 ELSE 0 END, products.sl ASC")
                ->orderBy($orderField, $order)
                ->paginate($perPage);
        }

        if(session()->has('carts')){
            $data['carts'] = array_column(session()->get('carts'), 'product_id');
        }else{
            $data['carts'] = [];
        }

        return view('web.product.single_product_shop_ajax', $data);
    }

}
