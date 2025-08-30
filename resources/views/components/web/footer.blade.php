<div>
    @php
        $setting_footer = \App\Models\Setting::find(1);
    @endphp
    <!-- ========== FOOTER ========== -->
    <footer>
        <!-- Footer-newsletter -->
        {{-- <div class="bg-primary py-3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-md-3 mb-lg-0">
                        <div class="row align-items-center">
                            <div class="col-auto flex-horizontal-center" style="color:antiquewhite">
                                <i class="ec ec-newsletter font-size-40"></i>
                                <h2 class="font-size-20 mb-0 ml-3">Sign up to Newsletter</h2>
                            </div>
                            <div class="col my-4 my-md-0">
                                <h5 class="font-size-15 ml-4 mb-0"></strong></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <!-- Subscribe Form -->
                        <form class="js-validate js-form-message" action="#">
                            <label class="sr-only" for="subscribeSrEmail">Email address</label>
                            <div class="input-group input-group-pill">
                                <input type="email" class="form-control border-0 height-40" name="email"
                                    id="subscribeSrEmail" placeholder="Email address" aria-label="Email address"
                                    aria-describedby="subscribeButton" required
                                    data-msg="Please enter a valid email address.">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-dark btn-sm-wide height-40 py-2" id="subscribeButton">Sign Up</button>
                                </div>
                            </div>
                        </form>
                        <!-- End Subscribe Form -->
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- End Footer-newsletter -->
        <!-- Footer-bottom-widgets -->
        <div class="pt-8 pb-4 bg-gray-13 border border-top-1">
            <div class="container mt-1">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="mb-6">
                            <a class="d-inline-block">
                                
                                <img src="{{asset('frontend/logo/'.$setting_footer->logo)}}" alt="Logo">
                            </a>
                        </div>
                        <div class="mb-4">
                            <div class="row no-gutters">
                                <div class="col-auto">
                                    <i class="ec ec-support text-primary font-size-56"></i>
                                </div>
                                <div class="col pl-3">
                                    <div class="font-size-13 font-weight-light">Got questions? Call us 24/7!</div>
                                    <a class="font-size-20 text-gray-90">{{$setting_footer->phone}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="mb-1 font-weight-bold">Contact info</h6>
                           <div>Email : {{ $setting_footer->email}}</div>
                            <address class="pt-1">
                                Address : {{$setting_footer->address}}
                            </address>
                        </div>
                        <div class="my-4 my-md-4">
                            <ul class="list-inline mb-0 opacity-7">
                                <li class="list-inline-item mr-0">
                                    <a class="btn font-size-20 btn-icon btn-soft-dark btn-bg-transparent rounded-circle" href="{{$setting_footer->facebook}}">
                                        <span class="fab fa-facebook-f btn-icon__inner"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item mr-0 d-none">
                                    <a class="btn font-size-20 btn-icon btn-soft-dark btn-bg-transparent rounded-circle" href="{{$setting_footer->twitter}}">
                                        <span class="fab fa-twitter btn-icon__inner"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="row">

                            <div class="col-12 col-md mb-4 mb-md-0">
                                <h6 class="mb-3 font-weight-bold">QUICK LINKS</h6>
                                <!-- List Group -->
                                <ul class="list-group list-group-flush list-group-borderless mb-0 list-group-transparent">
                                    <li><a class="list-group-item list-group-item-action" href="/shop">Shop</a></li> 
                                    <li><a class="list-group-item list-group-item-action" href="/faq">FAQ</a></li> 
                                    <li><a class="list-group-item list-group-item-action" href="/shipping-details">Shipping Details</a></li> 
                                    <li><a class="list-group-item list-group-item-action" href="/blogs">Blogs</a></li> 
                                    <li><a class="list-group-item list-group-item-action" href="/orders">Orders</a></li> 
                                    <li><a class="list-group-item list-group-item-action" href="/terms-and-conditions">Terms & Condition</a></li> 
                                    <li><a class="list-group-item list-group-item-action" href="{{url('my-profile')}}?type=dashboard">My Account</a></li> 
                                </ul>
                                <!-- End List Group -->
                            </div>
                            <div class="col-12 col-md mb-4 mb-md-0">
                                <h6 class="mb-3 font-weight-bold">POPULAR CATEGROIES</h6>
                                <!-- List Group -->
                                <ul class="list-group list-group-flush list-group-borderless mb-0 list-group-transparent">
                                    @foreach (Helper::categories() as $key => $category)
                                        <li><a class="list-group-item list-group-item-action" href="{{ url('category/'.$category->slug) }}">{{$category->category_name}}</a></li>
                                    @endforeach
                                    
                                </ul>
                                <!-- End List Group -->
                            </div>
                            

                            <div class="col-12 col-md mb-4 mb-md-0">
                                <h6 class="mb-3 font-weight-bold">INFO</h6>
                                <!-- List Group -->
                                <ul
                                    class="list-group list-group-flush list-group-borderless mb-0 list-group-transparent">

                                    <li><a class="list-group-item list-group-item-action" href="/about">About Us</a></li>
                                    <li><a class="list-group-item list-group-item-action" href="/faq">FAQs</a></li>
                                    <li><a class="list-group-item list-group-item-action" href="/contact">Contact Us</a></li>
                                    <li><a class="list-group-item list-group-item-action" href="/orders">Track Your Order</a></li>
                                </ul>
                                <!-- End List Group -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer-bottom-widgets -->
        <!-- Footer-copy-right -->
        <div class="bg-gray-14 py-2">
            <div class="container">
                <div class="flex-center-between d-block d-md-flex">
                    <div class="mb-3 mb-md-0">© <a class="font-weight-bold text-gray-90">My Daily Shop</a> - All rights Reserved</div>
                    <div class="text-md-right">
                        <span class="d-inline-block bg-white border rounded p-1">
                            <img class="max-width-5" src="{{ asset('frontend/assets/img/100X60/img1.jpg') }}" alt="Image Description">
                        </span>
                        <span class="d-inline-block bg-white border rounded p-1">
                            <img class="max-width-5" src="{{ asset('frontend/assets/img/100X60/img2.jpg') }}" alt="Image Description">
                        </span>
                        <span class="d-inline-block bg-white border rounded p-1">
                            <img class="max-width-5" src="{{ asset('frontend/assets/img/100X60/img3.jpg') }}" alt="Image Description">
                        </span>
                        <span class="d-inline-block bg-white border rounded p-1">
                            <img class="max-width-5" src="{{ asset('frontend/assets/img/100X60/img4.jpg') }}" alt="Image Description">
                        </span>
                        <span class="d-inline-block bg-white border rounded p-1">
                            <img class="max-width-5" src="{{ asset('frontend/assets/img/100X60/img5.jpg') }}" alt="Image Description">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer-copy-right -->
    </footer>
    <!-- ========== END FOOTER ========== -->
</div>