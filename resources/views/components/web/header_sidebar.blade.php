<div>
@php
    $setting = \App\Models\Setting::find(1);
@endphp
    <!-- ========== HEADER SIDEBAR ========== -->
    <aside id="sidebarHeader1" class="u-sidebar u-sidebar--left"
    aria-labelledby="sidebarHeaderInvoker">
        <div class="u-sidebar__scroller">
            <div class="u-sidebar__container">
                <div class="u-header-sidebar__footer-offset">
                    <!-- Toggle Button -->
                    <div class="position-absolute top-0 right-0 z-index-2 pt-4 pr-4 bg-white">
                        <button type="button" style="
                        background: #626262;
                        padding: 6px;
                        border-radius: 50%;
                        color: aliceblue;
                        font-size: small;
                    " class="close ml-auto"
                            aria-controls="sidebarHeader" aria-haspopup="true"
                            aria-expanded="false" data-unfold-event="click"
                            data-unfold-hide-on-scroll="false"
                            data-unfold-target="#sidebarHeader1"
                            data-unfold-type="css-animation"
                            data-unfold-animation-in="fadeInLeft"
                            data-unfold-animation-out="fadeOutLeft" data-unfold-duration="500">
                            <span aria-hidden="true"><i class="ec ec-close-remove  font-size-10"></i></span>
                        </button>
                    </div>
                    <!-- End Toggle Button -->

                    <!-- Content -->
                    <div class="js-scrollbar u-sidebar__body">
                        <div id="headerSidebarContent"
                            class="u-sidebar__content u-header-sidebar__content">
                            <!-- Logo -->
                            <a class="navbar-brand u-header__navbar-brand u-header__navbar-brand-center mb-3 pt-3 pb-3" href="/" aria-label="My Daily Shop">

                                <img src="{{asset('frontend/logo/'.$setting->logo)}}" alt="Logo">

                            </a>
                            <!-- End Logo -->

                            <button type="button" class="btn-link btn-remove-focus btn-block d-flex card-btn py-3 text-lh-1 px-4 shadow-none btn-primary rounded-top-lg border-0 font-weight-bold text-gray-90" id="header-sidebar-category-button">
                                <span class="ml-0 text-white mr-2">
                                    <span class="fa fa-list-ul"></span>
                                </span>
                                <span class="pl-1 text-white">All Categories </span>
                                <div class="text-white text-right w-40"><i class="fa fa-chevron-down"></i></div>
                            </button>

                            <div class="row" id="header-sidebar-category-section" style="display: none">
                                @include('web.layouts.category_sidebar')
                            </div>

                            <ul class="list-group list-group-flush mt-4 header-sidebar">
                                <li class="list-group-item">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/coupon-offers"><i class="fa fa-gift" aria-hidden="true"></i> &nbsp;&nbsp;Coupon Offers</a>
                                </li>
                                <li class="list-group-item">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/shipping-details"><i class="fa fa-truck"></i> &nbsp;&nbsp;Shipping Details</a>
                                </li>

                                <li class="list-group-item">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/faq"><i class="fa fa-question" aria-hidden="true"></i> &nbsp;&nbsp;FAQ</a>
                                </li>
                                <li class="list-group-item d-none">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/my-profile?type=profile"><i class="fa fa-gift" aria-hidden="true"></i> &nbsp;&nbsp;Points & Rewards</a>
                                </li>
                                <li class="list-group-item">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/carts"><i class="ec ec-add-to-cart" aria-hidden="true"></i> &nbsp;&nbsp;Cart</a>
                                </li>
                                <li class="list-group-item">
                                     <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/"><i class="fa fa-home" aria-hidden="true"></i> &nbsp;&nbsp;Home</a>
                                </li>
                                <li class="list-group-item">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/blogs"><i class="fa fa-blog"></i> &nbsp;&nbsp;Blogs</a>
                                </li>
                                <li class="list-group-item">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/about"><i class="fa fa-address-card"></i> &nbsp;&nbsp;About Us</a>
                                </li>
                                <li class="list-group-item">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/how-to-order"><i class="fa fa-file-export"></i> &nbsp;&nbsp;How to Order</a>
                                </li>
                                <li class="list-group-item">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/my-profile?type=profile"><i class="ec ec-user"></i> &nbsp;&nbsp;Account Details</a>
                                </li>
                                <li class="list-group-item">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/forget-password"><i class="fa fa-share"></i> &nbsp;&nbsp;Lost Password</a>
                                </li>
                                <li class="list-group-item">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/complain-form"><i class="fa fa-envelope"></i> &nbsp;&nbsp;Query/Comment Form</a>
                                </li>
                                {{-- <li class="list-group-item">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/staff-form"><i class="fa fa-home" aria-hidden="true"></i> &nbsp;&nbsp;Staff Form</a>
                                </li> --}}
                                
                                <li class="list-group-item">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/privacy-policy"> &nbsp;&nbsp;Privacy Policy</a>
                                </li>
                                
                                <li class="list-group-item">
                                    <a class="u-header-collapse__nav-link pb-2 pt-2 font-weight-bold" href="/terms-and-conditions">&nbsp;&nbsp;&nbsp;&nbsp;Terms & Conditions</a>
                                </li>
                              </ul>

                        </div>
                    </div>
                    <!-- End Content -->
                </div>
                <!-- Footer -->
                <footer id="SVGwaveWithDots" class="svg-preloader u-header-sidebar__footer">
                    <ul class="list-inline mb-0">
                        {{-- <li class="list-inline-item pr-3">
                            <a class="u-header-sidebar__footer-link text-gray-90"
                                href="#">Copyright 2020 © My Daily Shop. All rights reserved.</a>
                        </li> --}}
                    </ul>

                    <!-- SVG Background Shape -->
                    <div class="position-absolute right-0 bottom-0 left-0 z-index-n1">
                        <img class="js-svg-injector"  data-parent="#SVGwaveWithDots">
                    </div>
                    <!-- End SVG Background Shape -->
                </footer>
                <!-- End Footer -->
            </div>
        </div>
    </aside>
    <!-- ========== END HEADER SIDEBAR ========== -->
</div>