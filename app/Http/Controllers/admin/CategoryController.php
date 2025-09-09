<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Category;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';
        $data['categories'] = Category::orderByRaw("CASE WHEN categories.sl = 0 THEN 1 ELSE 0 END, categories.sl ASC")
            ->orderBy('sl', 'asc')
            ->where(function ($query) use ($search){
                $query->where('category_name', 'like', '%'.$search.'%');
            })
            ->paginate($perpage);

        return view('admin.category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Auto-generate slug if not provided
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->category_name);

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:categories',
            'slug'          => 'required|unique:categories,slug',
            'image'         => 'required|image|mimes:jpeg,png,jpg|dimensions:width=600,height=600',
            'status'        => 'required',
            'meta_og_image' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=1200,height=630',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }

        // Upload Category Image
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->category_name) . '-' . date('d.m.Y.h.s') . '.' . $request->image->extension();
            $request->image->move(public_path('frontend/images/category/'), $imageName);
        }

        // Upload OG Image
        $ogImageName = null;
        if ($request->hasFile('meta_og_image')) {
            $ogImageName = Str::slug($request->category_name) . '-og-' . date('d.m.Y.h.s') . '.' . $request->meta_og_image->extension();
            $request->meta_og_image->move(public_path('frontend/images/category/og/'), $ogImageName);
        }

        // Save Category
        $category = new Category();
        $category->category_name   = $request->category_name;
        $category->slug            = $slug;
        $category->image           = $imageName;
        $category->image_alt       = $request->image_alt;
        $category->status          = $request->status;
        $category->home_show       = $request->home_show;

        // SEO fields
        $category->meta_title       = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords    = $request->meta_keywords;
        $category->meta_og_image    = $ogImageName;
        $category->meta_og_alt      = $request->meta_og_alt;

        $category->save();

        return response()->json(['success' => true, 'mgs' => 'Category Successfully Created']);
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
        $data['category'] = Category::findOrFail($id);
        return view('admin.category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        // Auto-generate slug if empty
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->category_name);

        $rules = [
            'category_name' => 'required',
            'slug'          => 'required|unique:categories,slug,' . $id, // exclude current record
            'status'        => 'required',
        ];

        if ($request->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpeg,png,jpg|dimensions:width=600,height=600';
        }

        if ($request->hasFile('meta_og_image')) {
            $rules['meta_og_image'] = 'image|mimes:jpeg,png,jpg|dimensions:width=1200,height=630';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }

        // Handle main image
        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->category_name) . '-' . date('d.m.Y.h.s') . '.' . $request->image->extension();
            $request->image->move(public_path('frontend/images/category/'), $imageName);
            if ($category->image) @unlink(public_path('frontend/images/category/'.$category->image));
            $category->image = $imageName;
        }

        // Handle OG image
        if ($request->hasFile('meta_og_image')) {
            $ogImageName = Str::slug($request->category_name) . '-og-' . date('d.m.Y.h.s') . '.' . $request->meta_og_image->extension();
            $request->meta_og_image->move(public_path('frontend/images/category/og/'), $ogImageName);
            if ($category->meta_og_image) @unlink(public_path('frontend/images/category/og/'.$category->meta_og_image));
            $category->meta_og_image = $ogImageName;
        }

        // Update all fields
        $category->category_name   = $request->category_name;
        $category->slug            = $slug;
        $category->image_alt       = $request->image_alt;
        $category->status          = $request->status;
        $category->home_show       = $request->home_show;
        $category->meta_title       = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords    = $request->meta_keywords;
        $category->meta_og_alt      = $request->meta_og_alt;

        $category->save();

        return response()->json(['success' => true, 'mgs' => 'Category Successfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id){
            Category::find($id)->delete();
            return response()->json(['success' => true, 'mgs' => 'Category Successfully Deleted']);
        }
    }

    public function category_sorting(Request $request){
        if($request->type == 'store'){

            if(isset($request->category_ids)){
                foreach ($request->category_ids as $key => $id) {
                    Category::find($id)->update(['sl'=>$key+1]);
                }
            }
            return response()->json(['success' => true, 'mgs' => 'Category Successfully Sorted']);

        }else{
            $data['categories'] = Category::orderBy('sl', 'asc')->get();
            return view('admin.category.sorting', $data);
        }
    }
}
