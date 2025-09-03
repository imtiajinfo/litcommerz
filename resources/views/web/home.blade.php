@extends('web.layouts.master')

@section('title', 'My Daily Shop | Best Halal Shop in Japan')

@section('main')
@php
    $setting = Helper::setting();
@endphp

<!-- Slider Section -->
<div id="carouselExampleIndicators" class="carousel slide mb-2 mt-1" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        @foreach ($home_banners as $key => $item)
            <div class="carousel-item @if($key==0) active @endif">
                <a href="{{ $item->link }}" class="banner">
                    <img src="{{asset('frontend/images/banner/'.$item->image)}}" class="d-block w-100" alt="{{$item->image}}">
                </a>
            </div>
        @endforeach
    </div>
    
  </div>

{{-- side bar  --}}
<div class="container-fluid">
    <div class="row mb-2">
        <div class="d-none d-xl-block col-xl-3 col-wd-2gdot5">
            <div class="mb-6 borders-radius-6">

                <!-- List -->
                <ul class="u-header-collapse__nav">
                    <li>
                        <a class="u-header-collapse__nav-link text-danger mt-3 mb-3" style="margin-left: 30px;font-size:1rem;animation: shake 5s infinite;" href="{{url('coupon-offers')}}" role="button"> <i class="fa fa-certificate"></i> &nbsp;Coupon Offers</a>
                    </li>
                    
                </ul>
                @include('web.layouts.category_sidebar')
                <!-- End List -->

            </div>

        </div>
        <div class="col-xl-9 col-wd-9gdot5">
            <!-- Recommended Products -->
            <div class="d-xl-block">
                <div class="position-relative">
                    <div class="mb-2">
                        <div class="mb-1 mt-3">
                            <div class="row">

                                @foreach ($home_categories as $category)

                                <div class="col-md-3 col-xl-25 col-lg-3 col-sm-4 col-4">
                                    <a href="{{url('category/'.$category->slug)}}" class="d-black text-gray-90">
                                        <div class="p-1 row min-height-132">
                                            <div class="col-12 align-items-center home-category-d-flex">
                                                <img class="img-fluid home-category-img"
                                                    src="{{ asset('frontend/images/category/'.$category->image) }}"
                                                    alt="{{ $category->category_name }}">
                                            </div>
                                            <div class="col-12">
                                                <p class="text-center pt-1">{{ $category->category_name }}</p>
                                            </div>

                                        </div>
                                    </a>
                                </div>

                                @endforeach

                            </div>
                            <div class="row d-none">
                                <div class="col-12">

                                    {{-- SPECIAL Offers  --}}
                                    <div class="">
                                        <div class="position-relative">
                                            <div class="js-slick-carousel u-slick position-static overflow-hidden u-slick-overflow-visble pt-2 px-1"
                                                data-pagi-classes="text-center right-0 bottom-1 left-0 u-slick__pagination u-slick__pagination--long mb-0 z-index-n1 mt-3 mt-md-0"
                                                data-slides-show="7" data-slides-scroll="1"
                                                data-arrows-classes="position-absolute top-0 font-size-17 u-slick__arrow-normal top-10"
                                                data-arrow-left-classes="fa fa-angle-left right-1" data-arrow-right-classes="fa fa-angle-right right-0"
                                                data-responsive='[{
                                                    "breakpoint": 1800,
                                                    "settings": {
                                                      "slidesToShow": 4
                                                    }
                                                  },{
                                                    "breakpoint": 1400,
                                                    "settings": {
                                                      "slidesToShow": 4
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
                                                @foreach ($offers as $offer)
                                                    
                                                    <div class="js-slide products-group">
                                                        <div class="product-item1">
                                                            <div class="product-item__outer h-100">
                                                                <div class="product-item__inner px-wd-4 p-2 p-md-3" style="
                                                                border: 1px solid #ccc;
                                                                margin: 15px;
                                                            ">
    
                                                                    <div class="product-item__body pb-xl-2">
                                                                        <h5 class="mb-1 product-item__title"><a href="{{url('spcial-offers/'.$offer->slug)}}" class="text-blue font-weight-bold">{{$offer->name}}</a></h5>
                                                                        <div class="mb-2">
                                                                            <a href="{{url('spcial-offers/'.$offer->slug)}}" class="d-block text-center">
                                                                                <div style="display: flex;justify-content:center"><img style="max-width: 65% !important;" class="img-fluid home-category-img"  src="{{asset('frontend/images/offer/'.$offer->banner)}}" alt="Image Description"></div></a>
                                                                        </div>
                                                                        <div class="flex-center-between mb-1">
          
                                                                        </div>
                                                                    </div>
    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                @endforeach
    
    
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                
                                
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- End Recommended Products -->
            <!-- End Shop Pagination -->
        </div>
    </div>

</div>
<!-- End Slider Section -->


<style>
  .count-box {
    background: #ff2d5d;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    text-align: center;
    min-width: 50px;
}
.count-box span:first-child {
    display: block;
    font-size: 20px;
    font-weight: bold;
}

</style>

<!-- End Products-4-1-4 -->
<div class="container">

    @foreach($offers as $offer)
    <div class="offer-section border p-3 mb-5 rounded">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
            <h3 class="section-title mb-0 font-size-22">{{ $offer->name }}</h3>
            <div class="countdown d-flex" 
                data-end-date="{{ $offer->formatted_end_date }}">
                <div class="count-box">
                    <span class="days">00</span>
                    <span>Days</span>
                </div>
                <span class="mx-1">:</span>
                <div class="count-box">
                    <span class="hours">00</span>
                    <span>Hours</span>
                </div>
                <span class="mx-1">:</span>
                <div class="count-box">
                    <span class="minutes">00</span>
                    <span>Mins</span>
                </div>
                <span class="mx-1">:</span>
                <div class="count-box">
                    <span class="seconds">00</span>
                    <span>Secs</span>
                </div>
            </div>
            
            <a href="{{ url('/spcial-offers/'.$offer->slug) }}" class="btn btn-primary">View All <i class="fas fa-arrow-right ms-1"></i></a>
        </div>

        {{-- Carousel --}}
        <div class="js-slick-carousel u-slick position-static overflow-hidden pt-2 px-1"
            data-pagi-classes="text-center right-0 bottom-1 left-0 u-slick__pagination u-slick__pagination--long mb-0"
            data-slides-show="7" data-slides-scroll="1"
            data-arrows-classes="position-absolute top-0 font-size-17 u-slick__arrow-normal top-10"
            data-arrow-left-classes="fa fa-angle-left right-1" data-arrow-right-classes="fa fa-angle-right right-0"
            data-responsive='[{"breakpoint": 1400, "settings": {"slidesToShow": 6}}, {"breakpoint": 1200, "settings": {"slidesToShow": 4}}, {"breakpoint": 992, "settings": {"slidesToShow": 3}}, {"breakpoint": 768, "settings": {"slidesToShow": 2}}, {"breakpoint": 554, "settings": {"slidesToShow": 2}}]'>
            @foreach($offer->offerProducts as $offerProduct)
                @if($offerProduct->product)
                    @include('web.product.single_product_carousel', ['product' => $offerProduct->product])
                @endif
            @endforeach
        </div>
    </div>
    @endforeach

    <script>
      function updateCountdown(timerElement) {
          // Get end date from data attribute
          const endDate = new Date(timerElement.dataset.endDate).getTime();
          
          // Get elements
          const daysEl = timerElement.querySelector('.days');
          const hoursEl = timerElement.querySelector('.hours');
          const minsEl = timerElement.querySelector('.minutes');
          const secsEl = timerElement.querySelector('.seconds');

          // Update function
          function update() {
              const now = new Date().getTime();
              const diff = endDate - now;

              if (diff <= 0) {
                  // Offer has expired
                  daysEl.textContent = hoursEl.textContent = 
                  minsEl.textContent = secsEl.textContent = "00";
                  
                  // Optional: Add expired class
                  timerElement.classList.add('expired');
                  return;
              }

              // Calculate time units
              const days = Math.floor(diff / (1000 * 60 * 60 * 24));
              const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
              const seconds = Math.floor((diff % (1000 * 60)) / 1000);

              // Update DOM
              daysEl.textContent = days.toString().padStart(2, '0');
              hoursEl.textContent = hours.toString().padStart(2, '0');
              minsEl.textContent = minutes.toString().padStart(2, '0');
              secsEl.textContent = seconds.toString().padStart(2, '0');
          }

          // Initial update
          update();

          // Update every second
          return setInterval(update, 1000);
      }

      // Initialize all countdowns when document is ready
      document.addEventListener('DOMContentLoaded', function() {
          const countdowns = document.querySelectorAll('.countdown');
          
          countdowns.forEach(timer => {
              updateCountdown(timer);
          });
      });
    </script>

    <!-- special offers -->
    <div class="mb-6 d-none">
        <div class="position-relative">
            <div class="border-bottom border-color-1 mb-2">
                <h3 class="section-title mb-0 pb-2 font-size-22">SPECIAL OFFERS</h3>
            </div>
            <div class="js-slick-carousel u-slick position-static overflow-hidden u-slick-overflow-visble  pt-2 px-1"
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
                    @foreach ($special_products as $product)
                    
                        @include('web.product.single_product_carousel')

                    @endforeach
            </div>
        </div>
    </div>
    <!-- End special offers -->

    {{-- middle banner  --}}

    <div class="mb-8">
        <div class="row">
            @foreach ($middel_banners as $item)
                <div class="col-md-6 mb-3 mb-md-0">
                    <a href="{{ $item->link }}">
                        <img class="img-fluid" src="{{asset('frontend/images/banner/'.$item->image)}}" alt="Category Banner">
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- HOT ITEMS -->
    <div class="mb-6">
        <div class="position-relative">
            <div class="d-flex align-items-center border-bottom border-color-1 mb-2">
                <h3 class="section-title mb-0 pb-2 font-size-22">HOT ITEMS</h3>
                <a href="{{ url('/hot-items') }}" class="btn btn-primary btn-sm ml-3">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="js-slick-carousel u-slick position-static overflow-hidden u-slick-overflow-visble  pt-2 px-1"
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
                @foreach ($hot_products as $product)
                    
                    @include('web.product.single_product_carousel')

                @endforeach


            </div>
        </div>
    </div>
    <!-- End HOT ITEMS -->
    <!-- new arrivals -->
    <div class="mb-6">
        <div class="position-relative">
            <div class="d-flex align-items-center border-bottom border-color-1 mb-2">
                <h3 class="section-title mb-0 pb-2 font-size-22">NEW ARRIVALS</h3>
                <a href="{{ url('/new-arrivals') }}" class="btn btn-primary btn-sm ml-3">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="js-slick-carousel u-slick position-static overflow-hidden u-slick-overflow-visble  pt-2 px-1"
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
                    @foreach ($new_arrivals_products as $product)
                    
                        @include('web.product.single_product_carousel')

                    @endforeach
            </div>
        </div>
    </div>
    <!-- End new arrivals -->



    <!-- new Blogs -->
    <div class="mb-6">
        <div class="position-relative">
            <div class="border-bottom border-color-1 mb-2">
                <h3 class="section-title mb-0 pb-2 font-size-22">Blogs</h3>
            </div>

            <div class="js-slick-carousel u-slick position-static overflow-hidden u-slick-overflow-visble  pt-2 px-1"
                data-pagi-classes="text-center right-0 bottom-1 left-0 u-slick__pagination u-slick__pagination--long mb-0 z-index-n1 mt-3 mt-md-0"
                data-slides-show="7" data-slides-scroll="1"
                data-arrows-classes="position-absolute top-0 font-size-17 u-slick__arrow-normal top-10"
                data-arrow-left-classes="fa fa-angle-left right-1" data-arrow-right-classes="fa fa-angle-right right-0"
                data-responsive='[{
                      "breakpoint": 1400,
                      "settings": {
                        "slidesToShow": 5
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
                    @foreach ($blogs as $blog)
                    
                    <div class="js-slide products-group">
                        <div class="product-item">
                            <div class="product-item__outer h-100">
                                <div class="product-item__inner px-xl-4 p-3 mb-4">
                    
                                    <div class="product-item__body pb-xl-2">
                                        <div class="mb-2">
                                            <a style="font-size: 0.74987rem;
                                            font-family: 'circular';color:#403636 !important" href="{{ url('blog/'.$blog->slug) }}" class="font-size-12 text-gray-5">{{ Str::limit($blog->title, 40) }}</a>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <a href="{{ url('blog/'.$blog->slug) }}" class="d-block text-center"><img class="img-fluid"  src="{{ asset('frontend/images/blog/'.$blog->image) }}" alt="{{ Str::limit($blog->title, 30) }}"></a>
                                        </div>
                                        <div class="mb-1">

                                            <a href="{{ url('blog/'.$blog->slug) }}" class="text-gray"><small>Author by Admin</small> </a>
                                        </div>
                                    </div>
                        
                                    <div class="">
                                        <a href="{{ url('blog/'.$blog->slug) }}" class="text-gray-6 font-size-13 btn btn-primary text-white float-right ">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
            </div>

        </div>
    </div>
    <!-- End Blogs -->



    <!-- Brand Carousel -->
    <div class="mb-8">
        <div class="py-2 border-top border-bottom">
            <div class="js-slick-carousel u-slick my-1" data-slides-show="5" data-slides-scroll="1"
                data-arrows-classes="d-none d-lg-inline-block u-slick__arrow-normal u-slick__arrow-centered--y"
                data-arrow-left-classes="fa fa-angle-left u-slick__arrow-classic-inner--left z-index-9"
                data-arrow-right-classes="fa fa-angle-right u-slick__arrow-classic-inner--right" data-responsive='[{
                        "breakpoint": 992,
                        "settings": {
                            "slidesToShow": 2
                        }
                    }, {
                        "breakpoint": 768,
                        "settings": {
                            "slidesToShow": 1
                        }
                    }, {
                        "breakpoint": 554,
                        "settings": {
                            "slidesToShow": 1
                        }
                    }]'>
                @foreach ($brands as $brand)
                    <div class="js-slide">
                        <a href="#" class="product-item__outer">
                            <img class="img-fluid m-auto max-height-50" src="{{ asset('frontend/images/brand/'.$brand->image) }}" alt="{{$brand->brand_name}}">
                        </a>
                    </div>
                @endforeach
                
            </div>
        </div>
    </div>
    <!-- End Brand Carousel -->
</div>

<style>
    .js-slide{
        background-size: contain !important;
    }
    @media screen and (min-width: 1200px) and (max-width: 900px) {
        #hamburgerTriggerMenu {
            display: none
        }
    }
    @media screen and (min-width: 1200px) and (max-width: 2100px) {
        .banner .js-slide div {
            height: 18rem !important;
            min-height: 18rem !important;
        }
    }

    @media screen and (min-width: 1100px) and (max-width: 1200px) {
        .bg-img-hero-center div {
            min-height: 12rem !important;
        }
    }
    @media screen and (min-width: 1000px) and (max-width: 1100px) {
        .banner .js-slide div {
            height: 10rem !important;
            min-height: 10rem !important;
        }
    }
    
    @media screen and (min-width: 900px) and (max-width: 1000px) {
        .banner .js-slide div {
            height: 9rem !important;
            min-height: 9rem !important;
        }
    }
    @media screen and (min-width: 800px) and (max-width: 900px) {
        .banner .js-slide div {
            height: 8rem !important;
            min-height: 8rem !important;
        }
        .bg-img-hero div{
            min-height: 7rem !important;
        }
    }
    @media screen and (min-width: 700px) and (max-width: 800px){
        .banner .js-slide div{
            min-height: 8rem !important;
        }
        .bg-img-hero div{
            min-height: 7rem !important;
        }
    }
    @media screen and (min-width: 300px) and (max-width: 700px) {
        .banner .js-slide div{
            min-height: 7rem !important;
        }
        .bg-img-hero div{
            min-height: 6rem !important;
        }
    }

    @media (max-width: 768px) {
        .carousel-item{
            width: 150% !important;
        }
    }

    .modal {
      position: fixed;
      z-index: 9999;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .modal-dialog {
      max-width: 600px;
      width: 100%;
    }
    
</style>
@endsection