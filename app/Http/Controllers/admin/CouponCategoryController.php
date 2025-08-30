<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\CouponCategory;
use Str;

class CouponCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';
        $data['categories'] = CouponCategory::orderBy('id', 'desc')
            ->where(function ($query) use ($search){
                $query->where('category_name', 'like', '%'.$search.'%');
            })
            ->paginate($perpage);

        return view('admin.coupon_category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'category_name' => 'required|unique:coupon_categories',
            'image'         => 'required|image|mimes:jpeg,png,jpg|dimensions:width=600,height=600',
        ]);

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $imageName = Str::slug($request->input('category_name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/coupon/'), $imageName);
            }

            $category = new CouponCategory();
            $category->category_name = $request->category_name;
            $category->image = $imageName;
            $category->save();

            return response()->json(['success' => true, 'mgs' => 'Coupon Category Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['category'] = CouponCategory::findOrFail($id);
        return view('admin.coupon_category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator =  Validator::make($request->all(), [
            'category_name' => 'required',
        ]);

        if($request->image){
            $validator =  Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg|dimensions:width=600,height=600',
            ]);
        }

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $imageName = Str::slug($request->input('category_name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/coupon/'), $imageName);
            }

            $category = CouponCategory::findOrFail($id);
            $category->category_name = $request->category_name;
            if($request->image){
                if($category->image){
                    @unlink('frontend/images/category/'.$category->image);
                }
                $category->image = $imageName;
            }
            $category->save();

            return response()->json(['success' => true, 'mgs' => 'Coupon Category Successfully Updated']);
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
            CouponCategory::find($id)->delete();
            return response()->json(['success' => true, 'mgs' => 'Coupon Category Successfully Deleted']);
        }
    }
}
