<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Validator;
use Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';
        $data['blogs'] = Blog::orderBy('id', 'desc')
            ->where(function ($query) use ($search){
                $query->where('title', 'like', '%'.$search.'%');
            })
            ->paginate($perpage);

        return view('admin.blog.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'blog_name' => 'required|unique:blogs,title',
            'image'         => 'required|image|mimes:jpeg,png,jpg|dimensions:width=600,height=600',
            'status'        => 'required',
        ]);

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $imageName = Str::slug($request->input('blog_name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/blog/'), $imageName);
            }

            $blog = new Blog();
            $blog->title             = $request->blog_name;
            $blog->slug              = Str::slug($request->blog_name);
            $blog->image             = $imageName;
            $blog->short_description = $request->short_description;
            $blog->long_description  = $request->long_description;
            $blog->status            = $request->status;
            $blog->save();

            return response()->json(['success' => true, 'mgs' => 'Blog Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['blog'] = Blog::findOrFail($id);
        return view('admin.blog.edit', $data);
    }
    public function show($id)
    {
        $data['blog'] = Blog::findOrFail($id);
        return view('admin.blog.show', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator =  Validator::make($request->all(), [
            'blog_name' => 'required|unique:blogs,title,'.$id,
            'status'        => 'required',
        ]);

        if($request->image){
            $validator =  Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg|dimensions:width=600,height=600',
            ]);
        }

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $imageName = Str::slug($request->input('blog_name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/blog/'), $imageName);
            }

            $blog = blog::findOrFail($id);
            if($request->image){
                if($blog->image){
                    @unlink('frontend/images/blog/'.$blog->image);
                }
                $blog->image = $imageName;
            }
            $blog->title             = $request->blog_name;
            $blog->slug              = Str::slug($request->blog_name);
            $blog->short_description = $request->short_description;
            $blog->long_description  = $request->long_description;
            $blog->status            = $request->status;
            $blog->save();

            return response()->json(['success' => true, 'mgs' => 'Blog Successfully Updated']);
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
            $blog = Blog::find($id);
            if($blog->image){
                @unlink('frontend/images/blog/'.$blog->image);
            }
            Blog::find($id)->delete();
            return response()->json(['success' => true, 'mgs' => 'Blog Successfully Deleted']);
        }
    }
}
