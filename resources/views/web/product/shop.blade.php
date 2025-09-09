@extends('web.layouts.master')

@section('title', @$meta_title)
@section('meta_title', @$meta_title)
@section('meta_description', @$meta_description)
@section('meta_keywords', @$meta_keywords)
@section('meta_og_image', @$meta_og_image)
@section('meta_og_alt', @$meta_og_alt)
@php
$setting = Helper::setting();
if(Auth::check()){
$wishlist_pro_ids = Helper::wishlist_pro_ids();
}else{
$wishlist_pro_ids = [];
}
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
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">
                        {{@$category->category_name}}</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb -->
    </div>
</div>
<!-- End breadcrumb -->

<div class="container">
    <div class="row mb-8">
        <div class="d-none d-xl-block col-xl-3 col-wd-2gdot5">
            <div class="mb-8 p-3 border border-1">
                <!-- List -->
                @include('web.layouts.category_sidebar')
                <!-- End List -->
            </div>
            <div class="mb-6">
                <div class="border-bottom border-color-1 mb-5">
                    <h3 class="section-title section-title__sm mb-0 pb-2 font-size-18">Filters</h3>
                </div>

                <div class="range-slider">
                    <h4 class="font-size-14 mb-3 font-weight-bold">Price</h4>
                    <!-- Range Slider -->
                    <form action="/shop" method="get" id="price-slider-submit-form">

                        @include('web.layouts.price_ranger')
                        <br>

                        <button type="submit" id="price-slider-submit-btn"
                            class="btn px-4 btn-primary-dark-w py-2 rounded-lg">Filter</button>

                    </form>
                </div>

            </div>

        </div>
        <div class="col-xl-9 col-wd-9gdot5">
            <!-- Shop-control-bar Title -->
            <div class="d-block d-md-flex flex-center-between mb-3">
                <h4 class="font-size-25 mb-2 mb-md-0">{{@$category->category_name??@$headTitle}}</h4>
                <p class="font-size-14 text-gray-90 mb-0">
                  Showing {{ @$products->total() }} Products
                  {{-- results of 
                  {{ ($products->currentPage() - 1) * $perPage + 1 }}–
                  <span id="lastTotalCount">{{ $products->currentPage() * $perPage }}</span> --}}
              </p>

            </div>

            {{-- product bar start --}}
            <div class="bg-gray-1 flex-center-between borders-radius-9 py-1 mb-2">
                <div class="d-xl-none">
                    <!-- Account Sidebar Toggle Button -->
                    <a id="sidebarNavToggler1" class="btn btn-sm py-1 font-weight-normal target-of-invoker-has-unfolds"
                        href="javascript:;" role="button" aria-controls="sidebarContent1" aria-haspopup="true"
                        aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false"
                        data-unfold-target="#sidebarContent1" data-unfold-type="css-animation"
                        data-unfold-animation-in="fadeInLeft" data-unfold-animation-out="fadeOutLeft"
                        data-unfold-duration="500">
                        <i class="fas fa-sliders-h"></i> <span class="ml-1">Filters</span>
                    </a>
                    <!-- End Account Sidebar Toggle Button -->
                </div>
                <div class="px-3 d-none d-xl-block">
                    <ul class="nav nav-tab-shop d-none" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-one-example1-tab" data-toggle="pill"
                                href="#pills-one-example1" role="tab" aria-controls="pills-one-example1"
                                aria-selected="true">
                                <div class="d-md-flex justify-content-md-center align-items-md-center">
                                    <i class="fa fa-th"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-two-example1-tab" data-toggle="pill"
                                href="#pills-two-example1" role="tab" aria-controls="pills-two-example1"
                                aria-selected="false">
                                <div class="d-md-flex justify-content-md-center align-items-md-center">
                                    <i class="fa fa-align-justify"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-four-example1-tab" data-toggle="pill"
                                href="#pills-four-example1" role="tab" aria-controls="pills-four-example1"
                                aria-selected="false">
                                <div class="d-md-flex justify-content-md-center align-items-md-center">
                                    <i class="fa fa-th-list"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <style>
                    .dropdown-menu{
                        z-index: 10000 !important;
                    }
                </style>
                <div class="d-flex">
                    <form method="get" id="searchForm">

                        <input type="hidden" value="{{ @$search }}" name="search">
                        <input type="hidden" value="{{ @$min_price }}" name="min_price">
                        <input type="hidden" value="{{ @$max_price }}" name="max_price">
                        <input type="hidden" id="perPageData" value="{{ @$perPage }}" name="perPage">

                        <!-- Select -->
                        <div class="max-width-200 max-width-160-sm right-dropdown-0 px-2 px-xl-0" style="z-index: 1000">
                            <select class="searchDropdown js-select selectpicker dropdown-select max-width-200 max-width-160-sm right-dropdown-0 px-2 px-xl-0" data-style="btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0" tabindex="-98" name="orderBy">
                                <option value="" @if(@$orderBy == ''){{ 'selected' }}@endif>Default sorting</option>
                                <option value="desc" @if(@$orderBy == 'desc'){{ 'selected' }}@endif>Sort by latest</option>
                                <option @if(@$orderBy == 'low-price'){{ 'selected' }}@endif value="low-price">Sort by price: low to high</option>
                                <option @if(@$orderBy == 'high-price'){{ 'selected' }}@endif value="high-price">Sort by price: high to low</option>
                                {{-- <option @if(@$orderBy == 'a-z'){{ 'selected' }}@endif value="a-z">Sort by Name: a-z</option>
                                <option @if(@$orderBy == 'z-a'){{ 'selected' }}@endif value="z-a">Sort by Name: z-a</option> --}}
                            </select> 
                        </div>
                        <!-- End Select -->
                    </form>
                    <form method="get" id="searchForm1">

                        <input type="hidden" value="{{ @$search }}" name="search">
                        <input type="hidden" value="{{ @$min_price }}" name="min_price">
                        <input type="hidden" value="{{ @$max_price }}" name="max_price">
                        <input type="hidden" value="{{ @$orderBy }}" name="orderBy">

                        <div class="dropdown bootstrap-select js-select dropdown-select max-width-120 dropup">
                            <select class="searchDropdown1 js-select selectpicker dropdown-select max-width-120" data-style="btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0" tabindex="-98" name="perPage">
                                <option @if(@$perPage == 10){{ 'selected' }}@endif value="10" selected="">Show 10</option>
                                <option @if(@$perPage == 20){{ 'selected' }}@endif value="20">Show 20</option>
                                <option @if(@$perPage == 40){{ 'selected' }}@endif value="40">Show 40</option>
                                <option @if(@$perPage == 60){{ 'selected' }}@endif value="60">Show 60</option>
                                <option @if(@$perPage == 80){{ 'selected' }}@endif value="80">Show 80</option>
                            </select>
                        </div>
                        <!-- End Select -->
                    </form>
                </div>
            </div>
            {{-- product bar end --}}


            <!-- End shop-control-bar Title -->
            <!-- Shop-control-bar -->
            @if(!empty($sub_categories))
            <div class="borders-radius-9 py-1 row border border-1">
                @foreach ($sub_categories as $category)

                <div class="col-md-3 col-xl-2 col-lg-3 col-sm-4 col-4">
                    <a href="{{url('sub-category/'.$category->slug)}}" class="d-black text-gray-90">
                        <div class="p-1 row min-height-132">
                            <div class="col-12 align-items-center home-category-d-flex">
                                <img class="img-fluid"
                                    src="{{ asset('frontend/images/subcategory/'.$category->image) }}"
                                    alt="{{ $category->subcategory_name }}">
                            </div>
                            <div class="col-12">
                                <p class="text-center pt-1">{{ $category->subcategory_name }}</p>
                            </div>

                        </div>
                    </a>
                </div>

                @endforeach
            </div>
            @endif
            <!-- End Shop-control-bar -->
            <!-- Shop Body -->
            <!-- Tab Content -->
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade pt-2 show active" id="pills-one-example1" role="tabpanel"
                    aria-labelledby="pills-one-example1-tab" data-target-group="groups">
                    <ul class="row list-unstyled products-group no-gutters" id="product-view-section">
                        @foreach ($products as $product)

                        @include('web.product.single_product_shop')

                        @endforeach
                    </ul>
                </div>

            </div>
            <div class="col-12">
                <div id="product-view-section-nomoreproduct" style="display: none">
                    <h6 class="text-center">No More Product!</h6>
                </div>
            </div>

            @php
            $otherurl_html = '';
            if(@$orderBy){
            $otherurl_html .= "&orderBy=$orderBy";
            }
            if(@$category_slug){
            $otherurl_html .= "&category_slug=$category_slug";
            }
            if(@$min_price){
            $otherurl_html .= "&min=$min_price";
            }
            if(@$max_price){
            $otherurl_html .= "&max=$max_price";
            }
            if(@$search){
            $otherurl_html .= "&search=$search";
            }
            if(@$subcategory_slug){
            $otherurl_html .= "&subcategory_slug=$subcategory_slug";
            }
            if(@$perPage){
            $otherurl_html .= "&perPage=$perPage";
            }
            @endphp

            <input type="hidden" id="others-url" value="{{$otherurl_html}}">

            <nav class="d-md-flex justify-content-center align-items-center border-top pt-3"
                aria-label="Page navigation example">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center product-loader" id="product-loader" style="display: none">
                        <div class="spinner-grow text-warning" role="status">
                        </div>
                        <div class="spinner-grow text-warning" role="status">
                        </div>
                        <div class="spinner-grow text-warning" role="status">
                        </div>
                    </div>
                </div>
            </nav>

        </div>
    </div>


</div>

@endsection
