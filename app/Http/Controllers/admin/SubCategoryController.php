<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\SubCategory;
use App\Models\Category;
use Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? null;
        $category_id = $data['category_id'] = $request->category_id ?? null;

        $data['subcategories'] = SubCategory::join('categories', 'categories.id', 'sub_categories.category_id')
            ->orderByRaw("CASE WHEN sub_categories.sl = 0 THEN 1 ELSE 0 END, sub_categories.sl ASC")
            ->orderBy('sub_categories.id', 'desc')
            ->where(function ($query) use ($search){
                $query->where('sub_categories.subcategory_name', 'like', '%'.$search.'%')
                        ->orWhere('categories.category_name', 'like', '%'.$search.'%');
            })
            ->where(function ($query) use ($category_id){
                if($category_id){
                    $query->where('sub_categories.category_id', $category_id);
                }
            })
            ->select('sub_categories.*', 'categories.category_name')
            ->paginate($perpage);

        $data['categories'] = Category::all();

        return view('admin.subcategory.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['categories'] = Category::all();
        return view('admin.subcategory.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Auto-generate slug
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->subcategory_name);

        $validator = Validator::make($request->all(), [
            'subcategory_name' => 'required|unique:sub_categories,subcategory_name',
            'slug'             => 'nullable|unique:sub_categories,slug', // validate slug
            'category_id'      => 'required',
            'status'           => 'required',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=600,height=600',
            'meta_og_image'    => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=1200,height=630',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }

        // Main Image
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $slug . '-' . date('d.m.Y.h.s') . '.' . $request->image->extension();
            $request->image->move(public_path('frontend/images/subcategory/'), $imageName);
        }

        // OG Image
        $ogImageName = null;
        if ($request->hasFile('meta_og_image')) {
            $ogImageName = $slug . '-og-' . date('d.m.Y.h.s') . '.' . $request->meta_og_image->extension();
            $request->meta_og_image->move(public_path('frontend/images/subcategory/og/'), $ogImageName);
        }

        // Save SubCategory
        $subcategory = new SubCategory();
        $subcategory->category_id       = $request->category_id;
        $subcategory->subcategory_name  = $request->subcategory_name;
        $subcategory->slug              = $slug;
        $subcategory->image             = $imageName;
        $subcategory->image_alt         = $request->image_alt;
        $subcategory->status            = $request->status;
        $subcategory->sl                = $request->sl;
        $subcategory->meta_title        = $request->meta_title;
        $subcategory->meta_description  = $request->meta_description;
        $subcategory->meta_keywords     = $request->meta_keywords;
        $subcategory->meta_og_image     = $ogImageName;
        $subcategory->meta_og_alt       = $request->meta_og_alt;
        $subcategory->save();

        return response()->json(['success' => true, 'mgs' => 'SubCategory Successfully Created']);
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
        $data['categories'] = Category::all();
        $data['subcategory'] = SubCategory::findOrFail($id);
        return view('admin.subcategory.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subcategory = SubCategory::findOrFail($id);

        // Auto-generate slug
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->subcategory_name);

        $validator = Validator::make($request->all(), [
            'subcategory_name' => 'required|unique:sub_categories,subcategory_name,' . $id,
            // 'slug'             => 'required|unique:sub_categories,slug,' . $id, // unique slug
            'category_id'      => 'required',
            'status'           => 'required',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=600,height=600',
            'meta_og_image'    => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=1200,height=630',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }

        // Main Image
        if ($request->hasFile('image')) {
            if ($subcategory->image && file_exists(public_path('frontend/images/subcategory/' . $subcategory->image))) {
                @unlink(public_path('frontend/images/subcategory/' . $subcategory->image));
            }
            $imageName = $slug . '-' . date('d.m.Y.h.s') . '.' . $request->image->extension();
            $request->image->move(public_path('frontend/images/subcategory/'), $imageName);
            $subcategory->image = $imageName;
        }

        // OG Image
        if ($request->hasFile('meta_og_image')) {
            if ($subcategory->meta_og_image && file_exists(public_path('frontend/images/subcategory/og/' . $subcategory->meta_og_image))) {
                @unlink(public_path('frontend/images/subcategory/og/' . $subcategory->meta_og_image));
            }
            $ogImageName = $slug . '-og-' . date('d.m.Y.h.s') . '.' . $request->meta_og_image->extension();
            $request->meta_og_image->move(public_path('frontend/images/subcategory/og/'), $ogImageName);
            $subcategory->meta_og_image = $ogImageName;
        }

        // Update fields
        $subcategory->subcategory_name  = $request->subcategory_name;
        $subcategory->slug               = $slug;
        $subcategory->category_id        = $request->category_id;
        $subcategory->image_alt          = $request->image_alt;
        $subcategory->status             = $request->status;
        $subcategory->sl                 = $request->sl;
        $subcategory->meta_title         = $request->meta_title;
        $subcategory->meta_description   = $request->meta_description;
        $subcategory->meta_keywords      = $request->meta_keywords;
        $subcategory->meta_og_alt        = $request->meta_og_alt;

        $subcategory->save();

        return response()->json(['success' => true, 'mgs' => 'SubCategory Successfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id){
            SubCategory::find($id)->delete();
            return response()->json(['success' => true, 'mgs' => 'subCategory Successfully Deleted']);
        }
    }
}
