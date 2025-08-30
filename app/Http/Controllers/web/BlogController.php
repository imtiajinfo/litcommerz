<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index(){
        $data['blogs'] = Blog::paginate(10);
        return view('web.blog.index', $data);
    }

    public function single_blog($slug){
        $blog = Blog::where('slug', $slug)->first();
        return view('web.blog.blog_details', compact('blog'));
    }
}
