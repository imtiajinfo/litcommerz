@extends('web.layouts.master')

@section('title', 'Blogs - My Daily Shop')

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
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Blogs</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb -->
    </div>
</div>
<!-- End breadcrumb -->

<div class="container">
    <div class="row mb-8">
        
        <div class="col-xl-9 col-wd-9gdot5">
            <!-- Tab Content -->
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade pt-2 show active" id="pills-one-example1" role="tabpanel" aria-labelledby="pills-one-example1-tab" data-target-group="groups">
                    <ul class="row list-unstyled products-group no-gutters">
                        @foreach ($blogs as $blog)
                            
                            <li class="col-6 col-md-3 col-wd-2gdot4 product-item  mb-2">
                                <div class="product-item__outer h-100">
                                    <div class="product-item__inner px-xl-4 p-3">
                                        <div class="product-item__body pb-xl-2">
                                       
                                            <div class="product-item__body pb-xl-2">
                                                <div class="mb-2">
                                                    <a style="font-size: 0.74987rem;
                                                    font-family: sans-serif;color:black" href="{{ url('blog/'.$blog->slug) }}" class="font-size-12">{{ Str::limit($blog->title, 40) }}</a>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <a href="{{ url('blog/'.$blog->slug) }}" class="d-block text-center"><img class="img-fluid"  src="{{ asset('frontend/images/blog/'.$blog->image) }}" alt="{{ Str::limit($blog->title, 30) }}"></a>
                                                </div>
                                                <div class="mb-1">
        
                                                    <a href="{{ url('blog/'.$blog->slug) }}" class="text-gray"><small>Author by Admin</small> </a>
                                                </div>
                                            </div>
                                            <div>
                                                <a href="{{ url('blog/'.$blog->slug) }}" class="text-gray-6 font-size-13 btn btn-primary text-white mt-2 float-right ">Details</a>
                                            </div>
                                    </div>
                                </div>
                            </li>

                        @endforeach
                    </ul>
                </div>

            </div>
            <!-- End Tab Content -->
            <!-- End Shop Body -->
            <!-- Shop Pagination -->
            <nav class="d-md-flex justify-content-between align-items-center border-top pt-3" aria-label="Page navigation example">
                <div class="text-center text-md-left mb-3 mb-md-0">Showing {{$blogs->firstItem()}}-{{$blogs->lastItem()}} of {{$blogs->total()}} results</div>
                <ul class="pagination mb-0 pagination-shop justify-content-center justify-content-md-start">
                    {!! $blogs->links() !!}
                </ul>
            </nav>
            <!-- End Shop Pagination -->
        </div>
    </div>
    
</div>

@endsection
