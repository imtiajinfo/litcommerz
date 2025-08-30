<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSection;
use App\Models\Product;
use Validator;

class SpecialProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';

        $data['products'] = ProductSection::join('products', 'products.id', '=', 'product_sections.product_id')
            ->orderBy('products.id', 'desc')
            ->where('product_sections.section', 1)
            ->select('product_sections.*', 'products.product_name')
            ->paginate($perpage);

        return view('admin.special_product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pro_ids = ProductSection::where('section', 1)->pluck('product_id')->toArray();

        $data['products'] = Product::whereNotIn('id', $pro_ids)->get();

        return view('admin.special_product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if ($validator->passes()) {

            ProductSection::create([
                'section' => 1,
                'product_id' => $request->product_id
            ]);

            return response()->json(['success' => true, 'mgs' => 'Special Product Successfully Created']);
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
            ProductSection::find($id)->delete();
            return response()->json(['success' => true, 'mgs' => 'Special Product Successfully Deleted']);
        }
    }
}
