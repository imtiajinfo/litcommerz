@extends('web.layouts.master')

@section('title', 'Blog - My Daily Shop')

@php
    $setting = Helper::setting();
@endphp

@section('main')

    <!-- breadcrumb -->
    <div class="bg-gray-13 bg-md-transparent">
        <div class="container">
            <!-- breadcrumb -->
            <div class="my-md-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="/">Home</a></li>
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="/blogs">Blog</a></li>
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{ Str::limit($blog->title, 30)}}</li>
                    </ol>
                </nav>
            </div>
            <!-- End breadcrumb -->
        </div>
    </div>
    <!-- End breadcrumb -->

    <div class="container mt-5 mb-5">
        <h4 class="text-center text-bold title mb-5">{{$blog->title}}</h4>
        <div class="row">
            <div class="col-xl-6 col-wd">
                <div class="min-width-1100-wd">
                    
                    <article class="card mb-8 border-0">
                        <img style="height: 60vh;width:auto" class="img-fluid" src="{{asset('frontend/images/blog/'.$blog->image)}}" alt="Image Description">
                    </article>
                </div>
            </div>
            <div class="col-xl-5 col-wd">
                <aside class="mb-6">
                    
                    <div class="border-bottom border-color-1 mb-5">
                        <h3 class="section-title section-title__sm mb-0 pb-2 font-size-18">About Blog</h3>
                    </div>
                    <p class="text-gray-90 mb-0">{{$blog->short_description}}</p>
                </aside>
            </div>
            <div class="col-12">
                <div class="media-body">
                    <h3 class="font-size-18 mb-3"><a href="#"></a></h3>
                    <p class="mb-0">{!!$blog->long_description!!}</p>
                </div>
            </div>
        </div>
    </div>

@endsection
