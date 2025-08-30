<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\StockLedger;
use App\Models\PurchaseMaster;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\StockSummery;
use App\Models\ProductSection;
use App\Models\Unit;
use Validator;
use Str;
use DB;
use Auth;
use App\Models\Review;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? null;
        $category_id = $data['category_id'] = $request->category_id ?? null;
        $sub_category_id = $data['sub_category_id'] = $request->sub_category_id ?? null;

        if($sub_category_id || $category_id){
            if(!$category_id){
                $checkSubC = SubCategory::find($sub_category_id);
                $category_id = $data['category_id'] = $checkSubC->category_id;
            }
            $data['subcategories'] = SubCategory::where('category_id', $category_id)->get();
        }else{
            $data['subcategories'] = SubCategory::all();
        }
        $data['categories'] = Category::all();
        $data['all_subcategories'] = SubCategory::all()->keyBy('id');

        $query = Product::with('categories')
            ->leftJoin('categories', 'categories.id', 'products.category_id')
            ->leftJoin('sub_categories', 'sub_categories.id', 'products.subcategory_id')
            ->leftJoin('brands', 'brands.id', 'products.brand')
            ->leftJoin('offers', 'offers.id', 'products.offer_category_id')
            ->leftJoin('units', 'units.id', 'products.unit')
            ->orderByRaw("CASE WHEN products.sl = 0 THEN 1 ELSE 0 END, products.sl ASC")
            ->orderBy('products.sl', 'desc')
            ->select('products.*', 'categories.category_name', 'sub_categories.subcategory_name', 'brands.brand_name', 'offers.name as offer_category', 'units.short_name as unit_name');

        if($search){
            $query->where(function ($q) use ($search){
                $q->where('products.product_name', 'like', '%'.$search.'%')
                    ->orWhere('categories.category_name', 'like', '%'.$search.'%');
            });
        }

        if($category_id){
            $query->where(function ($q) use ($category_id){
                $q->where('products.category_id', $category_id)
                    ->orWhereHas('categories', function ($q2) use ($category_id){
                        $q2->where('category_id', $category_id);
                    });
            });
        }

        if($sub_category_id){
            $query->where(function ($q) use ($sub_category_id){
                $q->where('products.subcategory_id', $sub_category_id)
                    ->orWhereHas('categories', function ($q2) use ($sub_category_id){
                        $q2->where('subcategory_id', $sub_category_id);
                    });
            });
        }

        $data['products'] = $query->paginate($perpage);

        return view('admin.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['categories'] = Category::all();
        $data['brands'] = Brand::all();
        $data['offers'] = Offer::where('status', 1)->get();
        $data['units'] = Unit::get();
        return view('admin.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'product_name'   => 'required',
            'buy_price'    => 'required|numeric|min:1',
            'sell_price'    => 'required|numeric|min:1',
            'available_stock'    => 'required|numeric|min:0',
            'category_ids'     => 'required|array|min:1',
            'category_ids.0'   => 'required|numeric',  // first category required
            'subcategory_ids'  => 'nullable|array',
            'subcategory_ids.0'=> 'nullable|numeric',
            'images.*'       => 'required|image|mimes:jpeg,png,jpg|dimensions:width=600,height=600',
            'status'         => 'required|numeric',
        ]);
        if ($validator->passes()) {

            DB::beginTransaction();

            $product = new Product();
            $product->product_name      = $request->product_name;
            $product->slug              = Str::slug($request->product_name);
            $product->buy_price         = $request->buy_price;
            $product->sell_price        = $request->sell_price;
            $product->available_stock   = $request->available_stock;
            $product->category_id       = $request->category_ids[0];
            $product->subcategory_id    = $request->subcategory_ids[0] ?? 0;
            $product->description       = $request->description;
            $product->short_description = $request->short_description;
            $product->status            = $request->status;
            $product->brand             = $request->brand ?? 0;
            $product->offer_category_id = $request->offer_id ?? 0;
            $product->offer_amount      = $request->offer_amount ?? 0;
            $product->unit              = $request->unit ?? 0;
            $product->weight            = $request->weight;
            $product->note              = $request->note;
            $product->save();

            
            $product_id = DB::getPdo()->lastInsertId();

            if($request->special_offer){
                ProductSection::create([
                    'section' => 1,
                    'product_id' => $product_id
                ]);
            }
            if($request->hot_item){
                ProductSection::create([
                    'section' => 2,
                    'product_id' => $product_id
                ]);
            }
            if($request->new_arrival){
                ProductSection::create([
                    'section' => 3,
                    'product_id' => $product_id
                ]);
            }

            $stock_ledger = StockLedger::create([
                'user_id'    => Auth::id(),
                'order_id'   => 0,
                'product_id' => $product_id,
                'type'       => 1,
                'qty'        => $request->available_stock,
            ]);

            StockSummery::create([
                'stock_id' => $stock_ledger->id,
                'product_id' => $product_id,
                'quantity' => $request->available_stock,
                'amount' => $request->buy_price,
            ]);

            if($request->images){
                foreach($request->images as $key => $image){
                    if($request->images[$key]){ 
                        
                        $imageName = Str::slug($request->product_name).'-'.$key.'-'.date('d.m.Y.h.s').'.'.$request->images[$key]->extension();  
                        $request->images[$key]->move(public_path('frontend/images/product/'), $imageName);
    
                        $image = new ProductImages();
                        $image->product_id = $product_id;
                        $image->image = $product_id;
                        $image->image = $imageName;
                        $image->save();
                    }
                }
            }else{
                return response()->json(['error' => true, 'mgs' => 'Image Field is Required']);
            }


            $total_price = ($request->buy_price * $request->available_stock);

            PurchaseMaster::create([
                'user_id'    => Auth::id(),
                'product_id' => $product_id,
                'quantity'   => $request->available_stock,
                'amount'     => $total_price,
            ]);

            if ($request->category_ids) {
                $syncData = [];
                foreach ($request->category_ids as $index => $cat_id) {
                    $subcat_id = $request->subcategory_ids[$index] ?? null;
                    $sl = $request->sl[$index] ?? 0;

                    $syncData[$cat_id] = [
                        'subcategory_id' => $subcat_id,
                        'sl' => $sl,
                    ];
                }
                $product->categories()->sync($syncData);
            }

            DB::commit();

            return response()->json(['success' => true, 'mgs' => 'Product Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['images'] = ProductImages::where('product_id', $id)->get();
        return view('admin.product.product_images', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['offers'] = Offer::where('status', 1)->get();
        $data['brands'] = Brand::all();
        $data['categories'] = Category::all();
        $data['product'] = $product = Product::with(['categories' => function($query) {
            $query->withPivot('subcategory_id');
        }])->findOrFail($id);
        
        $data['product_images'] = ProductImages::where('product_id', $id)->get();

        $data['special_offer'] = ProductSection::where('section', 1)->where('product_id', $id)->first();
        $data['hot_item'] = ProductSection::where('section', 2)->where('product_id', $id)->first();
        $data['new_arrival'] = ProductSection::where('section', 3)->where('product_id', $id)->first();
        $data['units'] = Unit::get();
        
        return view('admin.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
      // return response()->json($request->all());
        $validator =  Validator::make($request->all(), [
            'product_name'   => 'required',
            'status'         => 'required',
            'category_ids'     => 'required|array|min:1',
            'category_ids.0'   => 'required|numeric',
            'subcategory_ids'  => 'nullable|array',
            'subcategory_ids.0'=> 'nullable|numeric',
        ]);
        if ($validator->passes()) {

            DB::beginTransaction();

            $product = Product::find($id);
            $product->product_name      = $request->product_name;
            $product->slug              = Str::slug($request->product_name);
            $product->buy_price         = $request->buy_price;
            $product->sell_price        = $request->sell_price;
            $product->category_id       = $request->category_ids[0];
            $product->description       = $request->description;
            $product->short_description = $request->short_description;
            $product->subcategory_id    = $request->subcategory_ids[0] ?? 0;
            $product->status            = $request->status;
            $product->brand             = $request->brand ?? 0;
            $product->offer_category_id = $request->offer_id ?? 0;
            $product->offer_amount      = $request->offer_amount ?? 0;
            $product->unit              = $request->unit ?? 0;
            $product->weight            = $request->weight;
            $product->note              = $request->note;
            $product->available_stock   = $request->available_stock;
            $product->save();

            $special_offer = ProductSection::where('section', 1)->where('product_id', $id)->first();
            $hot_item = ProductSection::where('section', 2)->where('product_id', $id)->first();
            $new_arrival = ProductSection::where('section', 3)->where('product_id', $id)->first();

            if(isset($special_offer)){
                if(!$request->special_offer){
                    ProductSection::where('section', 1)->where('product_id', $id)->delete();
                }
            }else{
                if($request->special_offer){
                    ProductSection::create([
                        'section' => 1,
                        'product_id' => $id
                    ]);
                }
            }
            if(isset($hot_item)){
                if(!$request->hot_item){
                    ProductSection::where('section', 2)->where('product_id', $id)->delete();
                }
            }else{
                if($request->hot_item){
                    ProductSection::create([
                        'section' => 2,
                        'product_id' => $id
                    ]);
                }
            }
            if(isset($new_arrival)){
                if(!$request->new_arrival){
                    ProductSection::where('section', 3)->where('product_id', $id)->delete();
                }
            }else{
                if($request->new_arrival){
                    ProductSection::create([
                        'section' => 3,
                        'product_id' => $id
                    ]);
                }
            }

            $syncData = [];

            $product->categories()->detach();
            foreach ($request->category_ids as $i => $cat_id) {
                $product->categories()->attach($cat_id, [
                    'subcategory_id' => $request->subcategory_ids[$i] ?? null,
                    'sl' => $request->sl[$i] ?? 0,
                ]);
            }

            if($request->images){

                if($request->old_images){

                    $urls = explode(',',$request->old_images);
                    
                    $filenames = array_map(function ($url) {
                        return pathinfo($url, PATHINFO_BASENAME);
                    }, $urls);
                    
                    $remove_product_images = ProductImages::where('product_id', $id)->whereNotIn('image', $filenames)->get();
        
                    if(count($remove_product_images)>0){
                        $remove_product_imagesids = $remove_product_images->pluck('id')->toArray();
                        ProductImages::whereIn('id', $remove_product_imagesids)->delete();
                        foreach($remove_product_images as $img){
                            @unlink('frontend/images/product/'.$img->image);
                        }
                    }
                }

                if ($request->old_images) {
                    $urls = explode(',', $request->old_images);
                    $filenames = array_map(fn($url) => pathinfo($url, PATHINFO_BASENAME), $urls);

                    $remove_product_images = ProductImages::where('product_id', $id)
                        ->whereNotIn('image', $filenames)
                        ->get();

                    if ($remove_product_images->count() > 0) {
                        $remove_ids = $remove_product_images->pluck('id')->toArray();
                        ProductImages::whereIn('id', $remove_ids)->delete();

                        foreach ($remove_product_images as $img) {
                            $path = public_path('frontend/images/product/' . $img->image);
                            if (file_exists($path)) {
                                @unlink($path);
                            }
                        }
                    }
                } else {
                    $remove_product_images = ProductImages::where('product_id', $id)->get();
                    foreach ($remove_product_images as $img) {
                        $path = public_path('frontend/images/product/' . $img->image);
                        if (file_exists($path)) {
                            @unlink($path);
                        }
                        $img->delete();
                    }
                }

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $key => $image) {
                        if ($image && !$image->isValid()) continue;

                        $validator = Validator::make($request->all(), [
                            "images.$key" => 'image|mimes:jpeg,png,jpg,png|dimensions:width=600,height=600',
                        ]);
                        if ($validator->fails()) continue;

                        $imageName = Str::slug($request->product_name) . '-' . $key . '-' . date('d.m.Y.h.s') . '.' . $image->extension();
                        $image->move(public_path('frontend/images/product/'), $imageName);

                        ProductImages::create([
                            'product_id' => $id,
                            'image' => $imageName,
                        ]);
                    }
                }

            }

            DB::commit();

            return response()->json(['success' => true, 'mgs' => 'Product Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id){
            Product::find($id)->delete();
            $product_images = ProductImages::where('product_id', $id)->get();
            ProductImages::where('product_id', $id)->delete();
            foreach($product_images as $img){
                @unlink('frontend/images/product/'.$img->image);
            }
            return response()->json(['success' => true, 'mgs' => 'Product Successfully Deleted']);
        }
    }

    public function reviews($id)
    {
        $data['product'] = Product::findOrFail($id);
        $data['reviews'] = Review::where('product_id', $id)->get();
        return view('admin.product.reviews', $data);
    }

    public function updateStatus($id , Request $request)
    {
          $review = Review::findOrFail($id);
          $review->status = $request->input('status', 0);
          $review->save();

        return response()->json(['success' => true, 'mgs' => 'Status Successfully Updated']);
    }

    public function export()
    {
        $products = Product::with(['categories', 'units'])->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Product Name');
        $sheet->setCellValue('B1', 'Categories');
        $sheet->setCellValue('C1', 'Subcategories');
        $sheet->setCellValue('D1', 'Sell Price');
        $sheet->setCellValue('E1', 'Weight & Unit');

        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $subcategories = \App\Models\SubCategory::all()->keyBy('id');

        $row = 2;
        foreach ($products as $product) {
            $categoryNames = [];
            $subcategoryNames = [];

            foreach ($product->categories as $category) {
                $categoryNames[] = $category->category_name;

                $subId = $category->pivot->subcategory_id;
                if ($subId && isset($subcategories[$subId])) {
                    $subcategoryNames[] = $subcategories[$subId]->subcategory_name;
                }
            }

            $weightUnit = trim($product->weight . ' ' . ($product->units->unit_name ?? ''));

            $sheet->setCellValue('A' . $row, $product->product_name);
            $sheet->setCellValue('B' . $row, implode(', ', $categoryNames));
            $sheet->setCellValue('C' . $row, implode(', ', $subcategoryNames));
            $sheet->setCellValue('D' . $row, $product->sell_price);
            $sheet->setCellValue('E' . $row, $weightUnit);

            $row++;
        }

        $fileName = 'products_' . date('Ymd_His') . '.xlsx';
        $tempPath = storage_path('app/public/' . $fileName);
        (new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet))->save($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
