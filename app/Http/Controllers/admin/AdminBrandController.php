<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Validator;
use Str;

class AdminBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';
        $data['brands'] = Brand::orderBy('id', 'desc')
            ->paginate($perpage);

        return view('admin.brand.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'brand_name' => 'required|unique:brands',
            'image'         => 'required|image|mimes:jpeg,png,jpg|dimensions:width=200,height=60',
            'status'        => 'required',
        ]);

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $imageName = Str::slug($request->input('brand_name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/brand/'), $imageName);
            }

            $brand = new Brand();
            $brand->brand_name = $request->brand_name;
            $brand->slug       = Str::slug($request->brand_name);
            $brand->image      = $imageName;
            $brand->status     = $request->status;
            $brand->save();

            return response()->json(['success' => true, 'mgs' => 'Brand Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['brand'] = Brand::findOrFail($id);
        return view('admin.brand.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator =  Validator::make($request->all(), [
            'brand_name' => 'required',
            'status'        => 'required',
        ]);

        if($request->image){
            $validator =  Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg|dimensions:width=200,height=60',
            ]);
        }

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $imageName = Str::slug($request->input('brand_name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/brand/'), $imageName);
            }

            $brand = Brand::findOrFail($id);
            $brand->brand_name = $request->brand_name;
            $brand->slug = Str::slug($request->brand_name);
            if($request->image){
                if($brand->image){
                    @unlink('frontend/images/brand/'.$brand->image);
                }
                $brand->image = $imageName;
            }
            $brand->status = $request->status;
            $brand->save();

            return response()->json(['success' => true, 'mgs' => 'Brand Successfully Updated']);
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
            Brand::find($id)->delete();
            return response()->json(['success' => true, 'mgs' => 'Brand Successfully Deleted']);
        }
    }
}
