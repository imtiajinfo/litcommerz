@extends('web.layouts.master')

@section('title', $meta_title)
@section('meta_title', $meta_title)
@section('meta_description', $meta_description)
@section('meta_keywords', $meta_keywords)
@section('meta_og_image', $meta_og_image)
@section('meta_og_alt', $meta_og_alt)
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
              @php
                  $mainCategory = $product->categories->first();
                  $subCategory = $mainCategory && $mainCategory->pivot->subcategory_id
                      ? \App\Models\SubCategory::find($mainCategory->pivot->subcategory_id)
                      : null;
              @endphp

                <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="/">Home</a></li>
                    @if(@$mainCategory)
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{url('category/'.$mainCategory->slug)}}">{{ @$mainCategory->category_name }}</a></li>
                    @endif                    
                    @if(@$subCategory)
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{url('sub-category/'.$subCategory->slug)}}">{{ @$subCategory->subcategory_name }}</a></li>
                    @endif
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{ $product->product_name }}</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb -->
    </div>
</div>
<!-- End breadcrumb -->
<div class="container-fluid">
    <!-- Single Product Body -->
    <div class="mb-xl-14">
        <div class="row">
            <div class="col-xl-3 col-lg-3">
                <div class="borders-radius-6 border border-1 pr-2 sidebar-category-phone-not-show">

                    <!-- List -->
                    <ul class="u-header-collapse__nav">
                        <li>
                            <div class="dropdown-title u-header-collapse__nav-link" style="margin-left: 30px"><b>All Categories</b></div>
                        </li>
                    </ul>
                    @include('web.layouts.category_sidebar')
                    <!-- End List -->
    
                </div>
            </div>
            <div class="col-xl-9 col-lg-9">
                <div class="row">
                  <div class="col-md-6 mb-4 mb-md-0">
                      <div id="sliderSyncingNav" class="js-slick-carousel u-slick mb-2"
                          data-infinite="true"
                          data-arrows-classes="d-none d-lg-inline-block u-slick__arrow-classic u-slick__arrow-centered--y rounded-circle"
                          data-arrow-left-classes="fas fa-arrow-left u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left ml-lg-2 ml-xl-4"
                          data-arrow-right-classes="fas fa-arrow-right u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right mr-lg-2 mr-xl-4"
                          data-nav-for="#sliderSyncingThumb">
                          @foreach ($product->product_images as $img)
                              <div class="js-slide">
                                  <img class="img-fluid" src="{{asset('frontend/images/product/'.$img->image)}}" alt="{{$product->product_name}}">
                              </div>
                          @endforeach
      
                      </div>
      
                      <div id="sliderSyncingThumb" class="js-slick-carousel u-slick u-slick--slider-syncing u-slick--slider-syncing-size u-slick--gutters-1 u-slick--transform-off" data-infinite="true" data-slides-show="5" data-is-thumbs="true" data-nav-for="#sliderSyncingNav">
                          @foreach ($product->product_images as $img)
                              <div class="js-slide" style="cursor: pointer;">
                                  <img class="img-fluid" src="{{asset('frontend/images/product/'.$img->image)}}" alt="{{$product->product_name}}">
                              </div>
                          @endforeach
      
                      </div>
                      <div>
                          @if($product->note)
                          <div class="mt-2">
                              <b>Note :</b> {{$product->note}}
                          </div>
                          @endif
                      </div>
                  </div>
                  <div class="col-md-6 mb-md-6 mb-lg-0">
                      <div class="mb-2">
                          <div class="border-bottom mb-3 pb-md-1 pb-3">
                              <a href="#" class="font-size-12 text-gray-5 mb-2 d-inline-block"></a>
                              <h2 class="font-size-25 text-lh-1dot2">{{$product->product_name}}</h2>
                              <div class="mb-2">
                                  <a class="d-inline-flex align-items-center small font-size-15 text-lh-1">
                                      <div class="text-warning mr-2">
                                          @for ($i = 1; $i < 6; $i++)
                                              @if($i <= $rating)
                                                  <small class="fas fa-star"></small>
                                              @else
                                                  <small class="far fa-star text-muted"></small>
                                              @endif
                                          @endfor
                                      </div>
                                      <span class="text-secondary font-size-13">({{$total_rating}} customer reviews)</span>
                                  </a>
                              </div>
                              <div class="d-md-flex align-items-center">
                                  <div class="ml-md-3 text-gray-9 font-size-14"><span class="@if($product->available_stock >0)text-green @else text-red @endif  font-weight-bold">@if($product->available_stock >0)in stock @else{{"Out of Stock"}}@endif</span></div>
                              </div>
                          </div>
                          <div class="flex-horizontal-center flex-wrap mb-4">
                              @if(in_array($product->id, @Helper::wishlist_pro_ids()))
                                  <a href="#" class="text-primary font-size-13 mr-2 add-wishlist" get-id={{$product->id}}><i class="fa fa-heart mr-1 font-size-15"></i> Wishlist</a>
                              @else
                                  <a href="/wishlist/store1?id={{$product->id}}" class="text-gray-6 font-size-13 mr-2" get-id={{$product->id}}><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
                              @endif
                              
                          </div>
      
                          <div class="mb-4">
                              <div class="d-flex align-items-baseline">
                                  <ins class="font-size-36 text-decoration-none"> @if($product->offer_amount >0)<del><small>{{$setting->currency_icon}}{{number_format(($product->sell_price ),2)}}</small></del>@endif
                                      <span class="text-danger">{{$setting->currency_icon}}{{number_format(($product->sell_price - $product->offer_amount),2)}}</span>
                                  </ins>
                              </div>
                          </div>
                          <div>
                              @if(@$product->units->short_name || $product->weight)
                              <ul class="pl-0">
                                  <li><b> Net weight :</b> {{$product->weight??'1'}} {{@$product->units->short_name}}</li>
                              </ul>
                              @endif
                          </div>

                          <div>
                              <ul class="pl-0">
                                  @if(@$product->brands->brand_name)
                                      <li><b>&#x2022; Brand :</b> {{$product->brands->brand_name}}</li>
                                  @endif
                              </ul>
                              {!! $product->short_description !!}
                          </div>
      
                          <div class="d-md-flex align-items-end mb-3">
                              <div class="max-width-150 mb-4 mb-md-0">
                                  <h6 class="font-size-14">Quantity</h6>
                                  <!-- Quantity -->
                                  <div class="border rounded-pill py-2 px-3 border-color-1">
                                      <div class="js-quantity row align-items-center">
                                          <div class="col">
                                              <input id="cart-input-change" class="js-result form-control h-auto border-0 rounded p-0 shadow-none cart-input-change" index="@if(Helper::cart_single_product($product->id)){{(Helper::cart_single_product_index($product->id))}}@endif" type="text" value="@if(Helper::cart_single_product($product->id)){{Helper::cart_single_product($product->id)['qty']}}@else{{'1'}}@endif">
                                          </div>
                                          <div class="col-auto pr-1">
                                              <a class="js-minus btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0 details-cart-minus" index="@if(Helper::cart_single_product($product->id)){{((Helper::cart_single_product_index($product->id)))}}@endif" href="javascript:;">
                                                  <small class="fas fa-minus btn-icon__inner"></small>
                                              </a>
                                              <a class="js-plus btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0 details-cart-plus" index="@if(Helper::cart_single_product($product->id)){{((Helper::cart_single_product_index($product->id)))}}@endif" href="javascript:;">
                                                  <small class="fas fa-plus btn-icon__inner"></small>
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                                  <!-- End Quantity -->
                              </div>
                              <div class="ml-md-3">
                                  @if($product->available_stock > 0)
                                      @if(in_array($product->id, $carts))
                                          <a href="{{ url('details-buy-now-cart/'.$product->id) }}" class="btn px-5 btn-primary-dark transition-3d-hover details-add-to-cart" get-id={{$product->id}}><i class="ec ec-add-to-cart mr-2 font-size-20"></i> Cart Added</a>
                                      @else
                                          <a href="{{ url('details-buy-now-cart/'.$product->id) }}" class="btn px-5 btn-primary-dark transition-3d-hover details-add-to-cart" get-id={{$product->id}}><i class="ec ec-add-to-cart mr-2 font-size-20"></i> Add to Cart</a>
                                      @endif
                                  @else
                                      <a class="btn px-5 btn-danger transition-3d-hover">Out of stock</a>
                                  @endif
                              </div>
                          </div>
                          <div class="col-md-12">
                              @if($product->available_stock > 0)
                                  <a href="{{ url('details-buy-now-cart/'.$product->id) }}" status=1 class="btn px-5 btn-secondary transition-3d-hover details-add-to-cart">Buy Now</a>
                              @endif
                          </div>
                      </div>
                  </div>
                </div>

                <div class="row mt-5">
                  <div class="col-12">
                    <div class="position-relative position-md-static px-md-6">
                        <ul class="nav nav-classic nav-tab nav-tab-lg justify-content-xl-center flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble border-0 pb-1 pb-xl-0 mb-n1 mb-xl-0" id="pills-tab-8" role="tablist">

                            <li class="nav-item flex-shrink-0 flex-xl-shrink-1 z-index-2">
                                <a class="nav-link active" id="Jpills-two-example1-tab" data-toggle="pill" href="#Jpills-two-example1" role="tab" aria-controls="Jpills-two-example1" aria-selected="false">Description</a>
                            </li>
                            <li class="nav-item flex-shrink-0 flex-xl-shrink-1 z-index-2">
                                <a class="nav-link" id="Jpills-four-example1-tab" data-toggle="pill" href="#Jpills-four-example1" role="tab" aria-controls="Jpills-four-example1" aria-selected="false">Reviews</a>
                            </li>

                        </ul>
                    </div>
                    <!-- Tab Content -->
                    <div class="borders-radius-17 border p-4 mt-4 mt-md-0 px-lg-10 py-lg-9">
                        <div class="tab-content" id="Jpills-tabContent">
                            
                            <div class="tab-pane fade active show" id="Jpills-two-example1" role="tabpanel" aria-labelledby="Jpills-two-example1-tab">
                                {!! $product->description !!}
                            </div>

                            <div class="tab-pane fade" id="Jpills-four-example1" role="tabpanel" aria-labelledby="Jpills-four-example1-tab">
                                <div class="row">
                                    <div class="col-12">
                                        {{-- review start  --}}
                                        @if(Auth::check() 
                                        // && @(count($user_review)==0)
                                        )
                                            <div class="reviewAdd">
                                                <h4 class="heading">Add a review</h4>
                                                <form action="{{route('reviewSubmit')}}" method="post" id="reviewForm">
                                                    @csrf
                                                    <input type="hidden" id="product-id" name="product_id" value="{{$product->id}}">
              
                                                    <div class="rating">
                                                        <span id="rating">0</span>/5
                                                    </div>
                                                    <div class="stars" id="stars">
                                                        <span class="star" data-value="1">★</span>
                                                        <span class="star" data-value="2">★</span>
                                                        <span class="star" data-value="3">★</span>
                                                        <span class="star" data-value="4">★</span>
                                                        <span class="star" data-value="5">★</span>
                                                    </div>
                                                    <p>Share your review:</p>
                                                    <textarea id="review" rows="4" placeholder="Write your review here"></textarea>
                                                    <br>
                                                    <input type="submit" id="submit" class="btn btn-primary mt-2">
              
                                                </form>
                                            </div>
                                        @endif
                                        @if(!Auth::check())
                                            <a href="/login" style="margin-left: 43%" class="btn btn-info">Add Review</a>
                                        @endif

                                        <br><br>
                                        <div>
                                            @forelse ($reviews as $item)
                                                                                    
                                                <div class="border-bottom border-color-1 pb-4 mb-4">
                                                    <!-- Review Rating -->
                                                    <div class="d-flex justify-content-between align-items-center text-secondary font-size-1 mb-2">
                                                        <div class="text-warning text-ls-n2 font-size-16" style="width: 80px;">
                                                            @for ($i = 1; $i < 6; $i++)
                                                                <small class="fas fa-star @if($i > $item->rating) text-muted @endif"></small>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <!-- End Review Rating -->

                                                    <p class="text-gray-90">{{$item->review}}</p>

                                                    <!-- Reviewer -->
                                                    <div class="mb-2">
                                                        <strong>{{$item->user->name}}</strong>
                                                        <span class="font-size-13 text-gray-23">- {{ date('M d Y', strtotime($item->created_at)) }}</span>
                                                    </div>
                                                    <!-- End Reviewer -->
                                                </div>

                                            @empty
                                                <h5 class="text-center">No Reviews</h5>
                                            @endforelse
                                            @php
                                                $paginate = $reviews;
                                            @endphp
                                            @include('components.admin.pagination')

                                        </div>

                                    </div>

                                    {{-- review end  --}}
                                </div>
                              
                            </div>

                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Single Product Tab -->
    <!-- Related products -->
    <div class="mb-6">
        <div class="position-relative">
            <div class="border-bottom border-color-1 mb-2">
                <h3 class="section-title mb-0 pb-2 font-size-22">RELATED PRODUCTS</h3>
            </div>
            <div class="js-slick-carousel u-slick position-static overflow-hidden u-slick-overflow-visble pb-7 pt-2 px-1"
                data-pagi-classes="text-center right-0 bottom-1 left-0 u-slick__pagination u-slick__pagination--long mb-0 z-index-n1 mt-3 mt-md-0"
                data-slides-show="7" data-slides-scroll="1"
                data-arrows-classes="position-absolute top-0 font-size-17 u-slick__arrow-normal top-10"
                data-arrow-left-classes="fa fa-angle-left right-1" data-arrow-right-classes="fa fa-angle-right right-0"
                data-responsive='[{
                      "breakpoint": 1400,
                      "settings": {
                        "slidesToShow": 6
                      }
                    }, {
                        "breakpoint": 1200,
                        "settings": {
                          "slidesToShow": 4
                        }
                    }, {
                      "breakpoint": 992,
                      "settings": {
                        "slidesToShow": 3
                      }
                    }, {
                      "breakpoint": 768,
                      "settings": {
                        "slidesToShow": 2
                      }
                    }, {
                      "breakpoint": 554,
                      "settings": {
                        "slidesToShow": 2
                      }
                    }]'>
                    @foreach ($products as $product)
                    
                        @include('web.product.single_product_carousel')

                    @endforeach
            </div>
        </div>
    </div>

    <!-- End Related products -->

</div>

<style>
.rating {
    font-size: 20px;
    margin: 10px 0;
}
 
.stars {
    font-size: 30px;
    margin: 10px 0;
}
 
.star {
    cursor: pointer;
    margin: 0 5px;
}
 
.one {
    color: rgb(255, 0, 0);
}
 
.two {
    color: rgb(255, 106, 0);
}
 
.three {
    color: rgb(196 201 45);
}
 
.four {
    color: rgb(255, 255, 0);
}
 
.five {
    color: rgb(24, 159, 14);
}
 
textarea {
    width: 90%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
 
.reviews {
    margin-top: 20px;
    text-align: left;
}
 
.review {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 10px;
    margin: 10px 0;
}
 
.review p {
    margin: 0;
}
.usr_star {
    font-size: x-large;
}
@media (max-width: 768px) {
    .sidebar-category-phone-not-show{
        display: none;
    }
}
</style>

@endsection
