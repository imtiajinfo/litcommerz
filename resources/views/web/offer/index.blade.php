@extends('web.layouts.master')

@section('title', 'Offer - My Daily Shop')

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
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{@$category->category_name}}</li>
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
                    <span class="irs js-irs-0 u-range-slider u-range-slider-indicator u-range-slider-grid"><span class="irs"><span class="irs-line" tabindex="0"><span class="irs-line-left"></span><span class="irs-line-mid"></span><span class="irs-line-right"></span></span><span class="irs-min" style="display: none;">0</span><span class="irs-max" style="display: none;">1</span><span class="irs-from" style="display: none; left: 0%;">0</span><span class="irs-to" style="display: none; left: 0%;">0</span><span class="irs-single" style="display: none; left: 0%;">0</span></span><span class="irs-grid"></span><span class="irs-bar" style="left: 2.96296%; width: 94.0741%;"></span><span class="irs-shadow shadow-from" style="display: none;"></span><span class="irs-shadow shadow-to" style="display: none;"></span><span class="irs-slider from" style="left: 0%;"></span><span class="irs-slider to" style="left: 94.0741%;"></span></span><input class="js-range-slider irs-hidden-input" type="text" data-extra-classes="u-range-slider u-range-slider-indicator u-range-slider-grid" data-type="double" data-grid="false" data-hide-from-to="true" data-prefix="$" data-min="0" data-max="3456" data-from="0" data-to="3456" data-result-min="#rangeSliderExample3MinResult" data-result-max="#rangeSliderExample3MaxResult" tabindex="-1" readonly="">
                    <!-- End Range Slider -->
                    <div class="mt-1 text-gray-111 d-flex mb-4">
                        <span class="mr-0dot5">Price: </span>
                        <span>$</span>
                        <span id="rangeSliderExample3MinResult" class="">0</span>
                        <span class="mx-0dot5"> — </span>
                        <span>$</span>
                        <span id="rangeSliderExample3MaxResult" class="">3456</span>
                    </div>
                    <button type="submit" class="btn px-4 btn-primary-dark-w py-2 rounded-lg">Filter</button>
                </div>
            </div>
            {{-- <div class="mb-8">
                <div class="border-bottom border-color-1 mb-5">
                    <h3 class="section-title section-title__sm mb-0 pb-2 font-size-18">Latest Products</h3>
                </div>
                <ul class="list-unstyled">
                    <li class="mb-4">
                        <div class="row">
                            <div class="col-auto">
                                <a href="../shop/single-product-fullwidth.html" class="d-block width-75">
                                    <img class="img-fluid" src="https://transvelo.github.io/electro-html/2.0/assets/img/212X200/img9.jpg" alt="Image Description">
                                </a>
                            </div>
                            <div class="col">
                                <h3 class="text-lh-1dot2 font-size-14 mb-0"><a href="../shop/single-product-fullwidth.html">Notebook Black Spire V Nitro VN7-591G</a></h3>
                                <div class="text-warning text-ls-n2 font-size-16 mb-1" style="width: 80px;">
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="far fa-star text-muted"></small>
                                </div>
                                <div class="font-weight-bold">
                                    <del class="font-size-11 text-gray-9 d-block">$2299.00</del>
                                    <ins class="font-size-15 text-red text-decoration-none d-block">$1999.00</ins>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="mb-4">
                        <div class="row">
                            <div class="col-auto">
                                <a href="../shop/single-product-fullwidth.html" class="d-block width-75">
                                    <img class="img-fluid" src="../../assets/img/300X300/img3.jpg" alt="Image Description">
                                </a>
                            </div>
                            <div class="col">
                                <h3 class="text-lh-1dot2 font-size-14 mb-0"><a href="../shop/single-product-fullwidth.html">Notebook Black Spire V Nitro VN7-591G</a></h3>
                                <div class="text-warning text-ls-n2 font-size-16 mb-1" style="width: 80px;">
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="far fa-star text-muted"></small>
                                </div>
                                <div class="font-weight-bold font-size-15">
                                    $499.00
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="mb-4">
                        <div class="row">
                            <div class="col-auto">
                                <a href="../shop/single-product-fullwidth.html" class="d-block width-75">
                                    <img class="img-fluid" src="../../assets/img/300X300/img5.jpg" alt="Image Description">
                                </a>
                            </div>
                            <div class="col">
                                <h3 class="text-lh-1dot2 font-size-14 mb-0"><a href="../shop/single-product-fullwidth.html">Tablet Thin EliteBook Revolve 810 G6</a></h3>
                                <div class="text-warning text-ls-n2 font-size-16 mb-1" style="width: 80px;">
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="far fa-star text-muted"></small>
                                </div>
                                <div class="font-weight-bold font-size-15">
                                    $100.00
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="mb-4">
                        <div class="row">
                            <div class="col-auto">
                                <a href="../shop/single-product-fullwidth.html" class="d-block width-75">
                                    <img class="img-fluid" src="../../assets/img/300X300/img6.jpg" alt="Image Description">
                                </a>
                            </div>
                            <div class="col">
                                <h3 class="text-lh-1dot2 font-size-14 mb-0"><a href="../shop/single-product-fullwidth.html">Notebook Purple G952VX-T7008T</a></h3>
                                <div class="text-warning text-ls-n2 font-size-16 mb-1" style="width: 80px;">
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="far fa-star text-muted"></small>
                                </div>
                                <div class="font-weight-bold">
                                    <del class="font-size-11 text-gray-9 d-block">$2299.00</del>
                                    <ins class="font-size-15 text-red text-decoration-none d-block">$1999.00</ins>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="mb-4">
                        <div class="row">
                            <div class="col-auto">
                                <a href="../shop/single-product-fullwidth.html" class="d-block width-75">
                                    <img class="img-fluid" src="../../assets/img/300X300/img10.png" alt="Image Description">
                                </a>
                            </div>
                            <div class="col">
                                <h3 class="text-lh-1dot2 font-size-14 mb-0"><a href="../shop/single-product-fullwidth.html">Laptop Yoga 21 80JH0035GE W8.1</a></h3>
                                <div class="text-warning text-ls-n2 font-size-16 mb-1" style="width: 80px;">
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="far fa-star text-muted"></small>
                                </div>
                                <div class="font-weight-bold font-size-15">
                                    $1200.00
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div> --}}
        </div>
        <div class="col-xl-9 col-wd-9gdot5">
            <!-- Shop-control-bar Title -->
            <div class="d-block d-md-flex flex-center-between mb-3">
                <h3 class="font-size-25 mb-2 mb-md-0">{{@$category->category_name}}</h3>
                {{-- <p class="font-size-14 text-gray-90 mb-0">Showing 1–25 of 56 results</p> --}}
            </div>
            <!-- End shop-control-bar Title -->
            <!-- Shop-control-bar -->
            <div class="bg-gray-1 flex-center-between borders-radius-9 py-1">
                {{-- <div class="d-xl-none">
                    <!-- Account Sidebar Toggle Button -->
                    <a id="sidebarNavToggler1" class="btn btn-sm py-1 font-weight-normal target-of-invoker-has-unfolds" href="javascript:;" role="button" aria-controls="sidebarContent1" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent1" data-unfold-type="css-animation" data-unfold-animation-in="fadeInLeft" data-unfold-animation-out="fadeOutLeft" data-unfold-duration="500">
                        <i class="fas fa-sliders-h"></i> <span class="ml-1">Filters</span>
                    </a>
                    <!-- End Account Sidebar Toggle Button -->
                </div> --}}
                {{-- <div class="px-3 d-none d-xl-block p-3">
                    <ul class="nav nav-tab-shop" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-one-example1-tab" data-toggle="pill" href="#pills-one-example1" role="tab" aria-controls="pills-one-example1" aria-selected="false">
                                <div class="d-md-flex justify-content-md-center align-items-md-center">
                                    <i class="fa fa-th"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-two-example1-tab" data-toggle="pill" href="#pills-two-example1" role="tab" aria-controls="pills-two-example1" aria-selected="false">
                                <div class="d-md-flex justify-content-md-center align-items-md-center">
                                    <i class="fa fa-align-justify"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-three-example1-tab" data-toggle="pill" href="#pills-three-example1" role="tab" aria-controls="pills-three-example1" aria-selected="true">
                                <div class="d-md-flex justify-content-md-center align-items-md-center">
                                    <i class="fa fa-list"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-four-example1-tab" data-toggle="pill" href="#pills-four-example1" role="tab" aria-controls="pills-four-example1" aria-selected="true">
                                <div class="d-md-flex justify-content-md-center align-items-md-center">
                                    <i class="fa fa-th-list"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div> --}}
                {{-- <div class="d-flex">
                    <form method="get">
                        <!-- Select -->
                        <div class="dropdown bootstrap-select js-select dropdown-select max-width-200 max-width-160-sm right-dropdown-0 px-2 px-xl-0"><select class="js-select selectpicker dropdown-select max-width-200 max-width-160-sm right-dropdown-0 px-2 px-xl-0" data-style="btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0" tabindex="-98">
                            <option value="one" selected="">Default sorting</option>
                            <option value="two">Sort by popularity</option>
                            <option value="three">Sort by average rating</option>
                            <option value="four">Sort by latest</option>
                            <option value="five">Sort by price: low to high</option>
                            <option value="six">Sort by price: high to low</option>
                        </select><button type="button" class="btn dropdown-toggle btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0" data-toggle="dropdown" role="button" title="Default sorting"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">Default sorting</div></div> </div></button><div class="dropdown-menu " role="combobox"><div class="inner show" role="listbox" aria-expanded="false" tabindex="-1"><ul class="dropdown-menu inner show"></ul></div></div></div>
                        <!-- End Select -->
                    </form>
                    <form method="POST" class="ml-2 d-none d-xl-block">
                        <!-- Select -->
                        <div class="dropdown bootstrap-select js-select dropdown-select max-width-120"><select class="js-select selectpicker dropdown-select max-width-120" data-style="btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0" tabindex="-98">
                            <option value="one" selected="">Show 20</option>
                            <option value="two">Show 40</option>
                            <option value="three">Show All</option>
                        </select><button type="button" class="btn dropdown-toggle btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0" data-toggle="dropdown" role="button" title="Show 20"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">Show 20</div></div> </div></button><div class="dropdown-menu " role="combobox"><div class="inner show" role="listbox" aria-expanded="false" tabindex="-1"><ul class="dropdown-menu inner show"></ul></div></div></div>
                        <!-- End Select -->
                    </form>
                </div>
                <nav class="px-3 flex-horizontal-center text-gray-20 d-none d-xl-flex">
                    <form method="post" class="min-width-50 mr-1">
                        <input size="2" min="1" max="3" step="1" type="number" class="form-control text-center px-2 height-35" value="1">
                    </form> of 3
                    <a class="text-gray-30 font-size-20 ml-2" href="#">→</a>
                </nav> --}}
            </div>
            <!-- End Shop-control-bar -->
            <!-- Shop Body -->
            <!-- Tab Content -->
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade pt-2 show active" id="pills-one-example1" role="tabpanel" aria-labelledby="pills-one-example1-tab" data-target-group="groups">
                    <ul class="row list-unstyled products-group no-gutters">
                        @foreach ($products as $product)
                            
                            <li class="col-6 col-md-3 col-wd-2gdot4 product-item  mb-2">
                                <div class="product-item__outer h-100">
                                    <div class="product-item__inner px-xl-4 p-3">
                                        <div class="product-item__body pb-xl-2">
                                            <div class="mb-2"><a href="#" class="font-size-12 text-gray-5">{{@$product->category->category_name}}</a></div>
                                            <h5 class="mb-1 product-item__title"><a href="{{ url('product/'.$product->slug) }}" class="text-blue font-weight-bold">{{ $product->product_name }}</a></h5>
                                            <div class="mb-2">
                                                <a href="{{ url('product/'.$product->slug) }}" class="d-block text-center"><img class="img-fluid" src="{{ asset('frontend/images/product/'.$product->first_img->image) }}" alt="Image Description"></a>
                                            </div>
                                            <div class="flex-center-between mb-1">
                                                <div class="prodcut-price">
                                                    <div class="text-gray-100">{{$setting->currency_icon}} {{number_format($product->sell_price,2)}}</div>
                                                </div>
                                                <div class="d-none d-xl-block prodcut-add-cart">
                                                    @if(in_array($product->id, $carts))
                                                        <a href="#" get-id={{$product->id}} class="btn-add-cart btn-primary transition-3d-hover">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                                                    @else
                                                        <a href="#" get-id={{$product->id}} class="btn-add-cart btn-primary transition-3d-hover add-to-cart cart-{{$product->id}}">
                                                            <i class="ec ec-add-to-cart"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-item__footer">
                                            <div class="border-top pt-2 flex-center-between flex-wrap">
                                                <a href="{{ url('buy-now-cart/'.$product->id) }}" class="text-gray-6 font-size-13"><i class="ec ec-shopping-bag mr-1 font-size-15"></i> Buy Now</a>
                                                @if(Auth::check())
                                                    @if(in_array($product->id, $wishlist_pro_ids))
                                                        <a href="#" class="text-primary -6 font-size-13 add-wishlist" get-id={{$product->id}}><i class="fa fa-heart" aria-hidden="true"></i> Wishlist</a>
                                                    @else
                                                        <a href="#" class="text-gray-6 font-size-13 add-wishlist" get-id={{$product->id}}><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
                                                    @endif
                                                @else
                                                    <a href="/login" class="text-gray-6 font-size-13"><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
                                                @endif
                                            </div>
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
                <div class="text-center text-md-left mb-3 mb-md-0">Showing {{$products->firstItem()}}-{{$products->lastItem()}} of {{$products->total()}} results</div>
                <ul class="pagination mb-0 pagination-shop justify-content-center justify-content-md-start">
                    {!! $products->links() !!}
                </ul>
            </nav>
            <!-- End Shop Pagination -->
        </div>
    </div>
    
</div>

@endsection
