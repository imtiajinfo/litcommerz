<div>
    @php
        $setting = $setting_header = Helper::setting();
    @endphp
    <!-- ========== HEADER ========== -->
    <header id="header" class="u-header u-header-left-aligned-nav">
        <div class="u-header__section">
            <!-- Topbar -->
            <div class="u-header-topbar py-2 d-none d-xl-block">
                <div class="container">
                    <div class="d-flex align-items-center">
                        <div class="topbar-left">
                            <a href="#" class="text-gray-110 font-size-13 hover-on-dark"></a>
                        </div>
                        <div class="topbar-right ml-auto">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item mr-0 u-header-topbar__nav-item u-header-topbar__nav-item-border">
                                    <a class="u-header-topbar__nav-link">Customer Support: <span class="text-blue">{{$setting_header->phone}}</span></a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Topbar -->

            <!-- Logo-Search-header-icons -->
            <div class="py-2 py-xl-5 bg-primary-down-lg">
                <div class="container my-0dot5 my-xl-0">
                    <div class="row align-items-center">
                        <!-- Logo-offcanvas-menu -->
                        <div class="col-auto">
                            <!-- Nav -->
                            <nav
                                class="navbar navbar-expand u-header__navbar py-0 justify-content-xl-between max-width-270 min-width-270">
                                <!-- Logo -->
                                <a class="order-1 order-xl-0 navbar-brand u-header__navbar-brand u-header__navbar-brand-center" href="/" aria-label="My Daily Shop">
                                    <img src="{{asset('frontend/logo/'.$setting_header->logo)}}" alt="Logo">
                                </a>
                                <!-- End Logo -->
                                <button id="sidebarHeaderInvokerMenu" type="button" class="navbar-toggler d-block btn u-hamburger mr-3 mr-xl-0 target-of-invoker-has-unfolds" aria-controls="sidebarHeader" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarHeader1" data-unfold-type="css-animation" data-unfold-animation-in="fadeInLeft" data-unfold-animation-out="fadeOutLeft" data-unfold-duration="500">
                                    <span id="hamburgerTriggerMenu" class="u-hamburger__box">
                                        <span class="u-hamburger__inner"></span>
                                    </span>
                                </button>

                            </nav>
                            <!-- End Nav -->

                            <x-web.header_sidebar />

                        </div>
                        <!-- End Logo-offcanvas-menu -->
                        <!-- Search Bar -->
                        <div class="col d-none d-xl-block">
                            <form class="js-focus-state" action="{{route('shop.index')}}" type="get">
                                <label class="sr-only" for="searchproduct">Search</label>
                                <div class="input-group header-search-input-group">
                                    <input style="background-color: #e8e8e8fa;border:3px solid #e8e8e8fa;height:45px" type="text" class="form-control py-2 pl-5 font-size-15 border-right-0 height-40 border-width-2 rounded-left-pill" name="search" id="searchproduct-item" placeholder="Search for Products" aria-label="Search for Products" aria-describedby="searchProduct1" value="@if(@(request()->search)){{request()->search}}@endif">
                                    <div class="input-group-append">
                                        <!-- End Select -->
                                        <button style="height: 45px" class="btn btn-primary height-40 py-2 px-3 rounded-right-pill"  type="submit" id="searchProduct1"> <span class="ec ec-search font-size-24"></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- End Search Bar -->
                        <!-- Header Icons -->
                        <div class="col col-xl-auto text-right text-xl-left pl-0 pl-xl-3 position-static">
                            <div class="d-inline-flex">
                                <ul class="d-flex list-unstyled mb-0 align-items-center">
                                    <!-- Search -->
                                    <li class="col d-xl-none px-2 px-sm-3 position-static">
                                        <a id="searchClassicInvoker"
                                            class="font-size-22 text-gray-90 text-lh-1 btn-text-secondary"
                                            href="javascript:;" role="button" data-toggle="tooltip" data-placement="top"
                                            title="Search" aria-controls="searchClassic" aria-haspopup="true"
                                            aria-expanded="false" data-unfold-target="#searchClassic"
                                            data-unfold-type="css-animation" data-unfold-duration="300"
                                            data-unfold-delay="300" data-unfold-hide-on-scroll="true"
                                            data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                                            <span class="ec ec-search"></span>
                                        </a>

                                        <!-- Input -->
                                        <div id="searchClassic"
                                            class="dropdown-menu dropdown-unfold dropdown-menu-right left-0 mx-2"
                                            aria-labelledby="searchClassicInvoker">
                                            <form class="js-focus-state input-group px-3" action="{{route('shop.index')}}" type="get">
                                                <input value="@if(@(request()->search)){{request()->search}}@endif" name="search" class="form-control" type="search" placeholder="Search Product">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary px-3" type="submit"><i class="font-size-18 ec ec-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- End Input -->
                                    </li>
                                    <!-- End Search -->
                                    <li class="col  d-xl-block pr-0">
                                        <a href="/my-profile?type=points" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="Points & Gifts">
                                        <i class="font-size-22 fa fa-gift" style="padding: 8px;color: #565656;background-color: #eeffab;border-radius: 15%;width: 95%;"></i>
                                        </a>
                                    </li>
                                    <li class="col nav-item dropdown has-arrow main-drop">

                                        <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown" aria-expanded="true">
                                            <span class="user-img">
                                                @if(@Auth::user()->avatar)
                                                    <img style="height: 35px;border: 1px solid #ccc;border-radius: 50%;padding: 1px;" src="{{asset('frontend/images/profile/'.@(Auth::user()->avatar))}}" alt="">
                                                @else
                                                    <img style="height: 35px;border: 1px solid #ccc;border-radius: 50%;padding: 5px;" src="{{ asset('admin/assets/img/icons/users1.svg')}}" alt="img">
                                                @endif
                                            <span class="status online"></span></span>
                                        </a>
                                        <div class="dropdown-menu menu-drop-user p-1" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 62px);margin-top: -10px;" data-popper-placement="bottom-end">
                                            <div class="profilename">
                                                <div class="profileset d-flex p-2">
                                                    <span class="user-img">
                                                        @if(@Auth::user()->avatar)
                                                            <img style="height: 35px;border: 1px solid #ccc;border-radius: 50%;padding: 1px;" src="{{asset('frontend/images/profile/'.@(Auth::user()->avatar))}}" alt="">
                                                        @else
                                                            <img style="height: 35px;border: 1px solid #ccc;border-radius: 50%;padding: 5px;" src="{{ asset('admin/assets/img/icons/users1.svg')}}" alt="img">
                                                        @endif
                                                    <span class="status online"></span></span>
                                                    <div class="profilesets">
                                                        <span>&nbsp;&nbsp;{{@Auth::user()->name}}</span>
                                                        @if(Auth::check())<br>@endif
                                                        <span>
                                                            @if(@auth()->user()->role==0)
                                                                {{"User"}}
                                                            @else
                                                                {{@Auth::user()->role->role_name}}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <hr class="m-0">
                                                <a class="dropdown-item" href="/my-profile?type=profile"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user me-2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> My Profile</a>
                                                
                                                <hr class="m-0">
                                                @if(Auth::check())

                                                @if(Auth::user()->role != 7)
                                                <a class="dropdown-item logout pb-2" href="{{ url('admin-panel') }}">
                                                    <img style="height: 20px" src="https://cdn-icons-png.flaticon.com/512/8899/8899687.png" class="me-2" alt="img"> Admin Dashboard
                                                </a>
                                                @endif
                                                <a class="dropdown-item logout pb-2" href="{{ route('logout') }}">
                                                    <img src="https://mydailyshop.liliumit.com/admin/assets/img/icons/log-out.svg" class="me-2" alt="img"> Logout
                                                </a>
                                                
                                                @else
                                                    <a class="dropdown-item logout pb-2" href="{{ url('login') }}">
                                                        <img src="https://mydailyshop.liliumit.com/admin/assets/img/icons/log-out.svg" class="me-2" alt="img"> Login
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        
                                    </li>
                                    {{-- <li class="col d-xl-none px-2 px-sm-3"><a href="/my-profile?type=dashboard" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="My Account"><i class="font-size-22 ec ec-user"></i></a></li> --}}
                                    <li class="col pr-xl-0 px-2 px-sm-3 d-xl-none">
                                        <a href="/carts" class="text-gray-90 position-relative d-flex " data-toggle="tooltip"
                                            data-placement="top" title="Cart">
                                            <i class="font-size-22 ec ec-shopping-bag"></i>
                                            <span class="bg-lg-down-black width-22 height-22 bg-primary position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12 total-carts">{{count(Helper::cart_products())}}</span>
                                            <span class="d-none d-xl-block font-weight-bold font-size-16 text-white ml-3">{{$setting->currency_icon}}{{number_format(Helper::cart_total(),2)}}</span>
                                        </a>
                                    </li>
                                    <li class="col pr-xl-0 px-2 px-sm-3 d-none d-xl-block">
                                        <div id="basicDropdownHoverInvoker"
                                            class="text-gray-90 position-relative d-flex " data-toggle="tooltip"
                                            data-placement="top" title="Cart" aria-controls="basicDropdownHover"
                                            aria-haspopup="true" aria-expanded="false" data-unfold-event="click"
                                            data-unfold-target="#basicDropdownHover" data-unfold-type="css-animation"
                                            data-unfold-duration="300" data-unfold-delay="300"
                                            data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp"
                                            data-unfold-animation-out="fadeOut">
                                            <i class="font-size-22 ec ec-shopping-bag"></i>
                                            <span
                                                class="bg-lg-down-black width-22 height-22 bg-primary position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12 total-carts text-white">{{count(Helper::cart_products())}}</span>
                                            <span
                                                class="d-none d-xl-block font-weight-bold font-size-16 text-gray-90 ml-3 total_cart_price">{{$setting->currency_icon}}{{number_format(Helper::cart_total(),2)}}</span>
                                        </div>
                                        <div id="basicDropdownHover"
                                            class="cart-dropdown dropdown-menu dropdown-unfold border-top border-top-primary mt-3 border-width-2 border-left-0 border-right-0 border-bottom-0 left-auto right-0 ajax-cart-view"
                                            aria-labelledby="basicDropdownHoverInvoker">
                                            <ul class="list-unstyled px-3 pt-3" id="cart-view">
                                                @forelse (Helper::cart_products() as $key => $item)
                                                    <li class="border-bottom pb-3 mb-3">
                                                        <div class="">
                                                            <ul class="list-unstyled row mx-n2">
                                                                <li class="px-2 col-auto">
                                                                    <img style="height: 60px" src="{{ asset('frontend/images/product/'.@$item->first_img->image) }}" alt="{{Str::limit($item->product_name,50)}}">
                                                                </li>
                                                                <li class="px-2 col">
                                                                    <h5 class="text-blue font-size-14 font-weight-bold">
                                                                        {{Str::limit($item->product_name,50)}}
                                                                    </h5>
                                                                    <span class="font-size-14 total_cart_price">{{$setting->currency_icon}} {{ number_format($item->sell_price,2) }}</span>
                                                                </li>
                                                                <li class="px-2 col-auto">
                                                                    <a href="#" index={{$key}} class="text-gray-90 cart-remove"><i class="ec ec-close-remove"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    @empty
                                                    <li class="border-bottom pb-3 mb-3">
                                                        <div class="text-center">
                                                            <h6 class="text-center">No Carts</h6> 
                                                        </div>
                                                    </li>
                                                    @endforelse
                                                

                                            </ul>
                                            <div class="flex-center-between px-4 pt-2">
                                                @if(!empty(Helper::cart_products()))
                                                    <a href="{{route('cart.index')}}" class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5">View cart</a>
                                                    <a href="{{ route('checkout.index') }}" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5">Checkout</a>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Header Icons -->
                    </div>
                </div>
            </div>
            <!-- End Logo-Search-header-icons -->

            <!-- Vertical-and-secondary-menu -->
            <div class="d-none d-xl-block container-fluid">
                <div class="row pb-3" style="border-bottom: 1px solid #e3e4e6;">
                    <!-- Vertical Menu -->
                    <div class="col-md-auto d-none d-xl-block">
                        <div class="max-width-230 min-width-230">
                            <!-- Basics Accordion -->
                            <div id="basicsAccordion">
                                <!-- Card -->
                                <div class="card border-0">
                                    <!-- Fullscreen Toggle Button -->
                                    <button id="sidebarHeaderInvokerMenu" type="button" class="btn-link btn-remove-focus btn-block d-flex card-btn py-3 text-lh-1 px-4 shadow-none btn-primary rounded-top-lg border-0 font-weight-bold text-gray-90" aria-controls="sidebarHeader"  aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarHeader1"  data-unfold-type="css-animation"
                                    data-unfold-animation-in="fadeInLeft" data-unfold-animation-out="fadeOutLeft"
                                    data-unfold-duration="500">
                                        <span class="ml-0 text-white mr-2">
                                            <span class="fa fa-list-ul"></span>
                                        </span>
                                        <span class="pl-1 text-white">All Categories </span>
                                        <div class="text-white text-right w-20"><i class="fa fa-chevron-down"></i></div>
                                    </button>
                                    <!-- End Fullscreen Toggle Button -->
                                </div>
                                <!-- End Card -->
                            </div>
                            <!-- End Basics Accordion -->
                        </div>
                    </div>
                    <!-- End Vertical Menu -->
                    <!-- Secondary Menu -->
                    <div class="col">
                        <!-- Nav -->
                        <nav class="js-mega-menu navbar navbar-expand-md u-header__navbar u-header__navbar--no-space">
                            <!-- Navigation -->
                            <div id="navBar" class="collapse navbar-collapse u-header__navbar-collapse">
                                <ul class="navbar-nav u-header__navbar-nav">

                                    <li class="nav-item u-header__nav-item"><a class="nav-link u-header__nav-link {{ request()->is('/') ? 'text-primary active-header' : '' }}" href="/">Home</a></li>
                                    <li class="nav-item u-header__nav-item"><a class="nav-link u-header__nav-link {{ url()->full() == url('/').'/shop' ? 'text-primary active-header' : '' }}" href="/shop">All Products</a></li>
                                    <li class="nav-item u-header__nav-item"><a class="nav-link u-header__nav-link {{ url()->full() == url('/').'/shop?orderBy=desc' ? 'text-primary active-header' : '' }}" href="/shop?orderBy=desc">New Arrivals</a></li>

                                    <li class="nav-item hs-has-sub-menu u-header__nav-item {{ request()->is('carts') || request()->is('checkout') ? 'text-primary active-header' : '' }}"
                                        data-event="hover"
                                        data-animation-in="slideInUp"
                                        data-animation-out="fadeOut">
                                        <a id="blogMegaMenu" class="nav-link u-header__nav-link u-header__nav-link-toggle" href="/carts" aria-haspopup="true" aria-expanded="false" aria-labelledby="blogSubMenu">Cart</a>

                                        <!-- Blog - Submenu -->
                                        <ul id="blogSubMenu" class="hs-sub-menu u-header__sub-menu" aria-labelledby="blogMegaMenu" style="min-width: 230px;">
                                            <li><a class="nav-link u-header__sub-menu-nav-link {{ request()->is('checkout') ? 'text-primary' : '' }}" href="/checkout">Checkout</a></li>
                                        </ul>
                                        <!-- End Submenu -->
                                    </li>

                                    <li class="nav-item u-header__nav-item"><a class="nav-link u-header__nav-link {{ request()->is('shipping-details') ? 'text-primary active-header' : '' }}" href="/shipping-details">Shipping Details</a></li>
                                    <li class="nav-item u-header__nav-item"><a class="nav-link u-header__nav-link {{ request()->is('about') ? 'text-primary active-header' : '' }}" href="/about">About Us</a></li>
                                    <li class="nav-item u-header__nav-item"><a class="nav-link u-header__nav-link {{ request()->is('contact') ? 'text-primary active-header' : '' }}" href="/contact">Contact</a></li>

                                    <li class="nav-item hs-has-sub-menu u-header__nav-item {{ request()->is('faq') || request()->is('complain-form') ? 'text-primary active-header' : '' }}"
                                        data-event="hover"
                                        data-animation-in="slideInUp"
                                        data-animation-out="fadeOut">
                                        <a id="blogMegaMenu" class="nav-link u-header__nav-link u-header__nav-link-toggle" href="/faq" aria-haspopup="true" aria-expanded="false" aria-labelledby="blogSubMenu">FAQ</a>

                                        <!-- Blog - Submenu -->
                                        <ul id="blogSubMenu" class="hs-sub-menu u-header__sub-menu" aria-labelledby="blogMegaMenu" style="min-width: 230px;">
                                            <li><a class="nav-link u-header__sub-menu-nav-link {{ request()->is('complain-form') ? 'text-primary' : '' }}" href="/complain-form">Query/Comment Form</a></li>
                                        </ul>
                                        <!-- End Submenu -->
                                    </li>

                                    <li class="nav-item u-header__nav-item"><a class="nav-link u-header__nav-link {{ request()->is('blogs') ? 'text-primary active-header' : '' }}" href="/blogs">Blogs</a></li>

                                    <li class="nav-item hs-has-sub-menu u-header__nav-item {{ request()->is('physical-store') || request()->is('banner-gallery') ? 'text-primary active-header' : '' }}"
                                        data-event="hover"
                                        data-animation-in="slideInUp"
                                        data-animation-out="fadeOut">
                                        <a id="blogMegaMenu" class="nav-link u-header__nav-link u-header__nav-link-toggle" href="/physical-store" aria-haspopup="true" aria-expanded="false" aria-labelledby="blogSubMenu">Physical Store</a>

                                        <!-- Blog - Submenu -->
                                        <ul id="blogSubMenu" class="hs-sub-menu u-header__sub-menu" aria-labelledby="blogMegaMenu" style="min-width: 230px;">
                                            <li><a class="nav-link u-header__sub-menu-nav-link {{ request()->is('banner-gallery') ? 'text-primary' : '' }}" href="/banner-gallery">Banner Gallary</a></li>
                                        </ul>
                                        <!-- End Submenu -->
                                    </li>

                                    

                                    <!-- Button -->
                                    {{-- <li class="nav-item u-header__nav-last-item">
                                        <a class="text-gray-90" href="#">
                                            Free Shipping on Orders {{$setting->currency_icon}} 10,000+
                                        </a>
                                    </li> --}}
                                    <!-- End Button -->
                                </ul>
                            </div>
                            <!-- End Navigation -->
                        </nav>
                        <!-- End Nav -->
                    </div>
                    <!-- End Secondary Menu -->
                </div>
            </div>
            <!-- End Vertical-and-secondary-menu -->
        </div>
    </header>
    <!-- ========== END HEADER ========== -->
    
</div>


<style>
.sidebar-category-icon{
    margin-top: -30px !important;
    width: 10% !important;
    float: right;
}
.u-header-collapse__nav-pointer::after {
    font-size: 75% !important;
}
.dropdown-menu {
    display: none;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.dropdown:hover .dropdown-menu {
    display: block;
    opacity: 1;
    margin-top: 0; /* Adjusts alignment */
}
</style>