@extends('web.layouts.master')

@section('title', 'Checkout - My Daily Shop')

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
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="/">Home</a>
                    </li>
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb -->
    </div>
</div>
<!-- End breadcrumb -->

<div class="container">
    <div class="mb-5">
        <h1 class="text-center">Checkout</h1>
    </div>
    @if (!empty(Helper::cart_products()))

    <!-- Accordion -->
    <div id="shopCartAccordion1" class="accordion rounded mb-6">
        <!-- Card -->
        <div class="card border-0">
            <div id="shopCartHeadingTwo" class="alert alert-primary mb-0 text-white" role="alert"> Have a coupon? <a href="#"
                    class="alert-link text-white" data-toggle="collapse" data-target="#shopCartTwo" aria-expanded="false"
                    aria-controls="shopCartTwo">Click here to enter your code</a>
            </div>
            <div id="shopCartTwo" class="collapse border border-top-0" aria-labelledby="shopCartHeadingTwo"
                data-parent="#shopCartAccordion1">
                <form class="p-5" action="{{route('coupon.apply')}}" method="POST">
                    @csrf
                    <p class="w-100 text-gray-90">If you have a coupon code, please apply it below.</p>
                    <div class="input-group input-group-pill max-width-660-xl">
                        <input type="text" class="form-control" name="coupon_code" placeholder="Coupon code"
                            aria-label="Promo code">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-block btn-dark font-weight-normal btn-pill px-4">
                                <i class="fas fa-tags d-md-none"></i>
                                <span class="d-none d-md-inline">Apply coupon</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Accordion -->
    @if(count($errors) > 0 )
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul class="p-0 m-0" style="list-style: none;">
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(!Auth::check())

        <div class="panel panel-default">
            <div class="card">
                <div class="panel-body card-body mb-3">
                    <div class="row">
                        <div class="col-sm-6 mb-2">
                            <h6><u>Checkout Options:</u> </h6>
                            <div class="radio">
                                <label> <input checked="checked" class="checkout-option" type="radio" name="account" value="register" ><b> Login Account</b></label>
                            </div>
                            <div class="radio">
                                <label> <input class="checkout-option" type="radio" name="account" value="guest"> <b> Guest Checkout</b></label>
                            </div>
                            <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
                        </div>
                        <hr>
                        <div class="col-sm-6 login-section">
                            <h4 class="d-none">Returning Customer</h4>
                            <div>
                                {{-- Have Not an Account? <a style="cursor: pointer" class="text-blue register-cbtn">Register</a><br><br> --}}
                            </div>
                            <form action="{{route('login.checkout.action')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label" for="input-email">E-Mail</label>
                                    <input type="text" name="email" value="" placeholder="E-Mail" id="input-email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="input-password">Password</label>
                                    <input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control"><br>
                                    <a href="#" class="d-none">Forgotten Password</a><br>
                                    
                                </div>
                                <input type="submit" value="Login" id="button-login" data-loading-text="Loading..." class="btn btn-primary">
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div><br>

    @endif

    <form id="checkout-form-submit">
        @csrf

        <input type="hidden" name="checkout_type" @if(Auth::check())value="1"@else value="1" @endif id="checkout_type">
        <div class="row">

            <div class="col-lg-5 order-lg-2 order-2 mb-7 mb-lg-0">
                <div class="pl-lg-3 ">
                    <div class="bg-gray-1 rounded-lg">
                        <!-- Order Summary -->
                        <div class="p-4 mb-4 checkout-table">
                            <!-- Title -->
                            <div class="border-bottom border-color-1 mb-5">
                                <h3 class="section-title mb-0 pb-2 font-size-25">Your order</h3>
                            </div>
                            <!-- End Title -->

                            <!-- Product Content -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-name">Product</th>
                                        <th class="product-total">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Helper::cart_products() as $item)
                                    @php
                                    $index = array_search($item->id, array_column(session()->get('carts'),
                                    'product_id'));
                                    $qty = session()->get('carts')[$index]['qty'];
                                    @endphp
                                    <tr class="cart_item">
                                        <td>
                                            <a href="{{ url('product/'.$item->slug) }}"><img class="img-fluid max-width-100 p-1 border border-color-1"
                                                src="{{asset('frontend/images/product/'.$item->first_img->image)}}"
                                                alt="{{$item->product_name}}">
                                            {{Str::limit($item->product_name,25)}}&nbsp;@if(@$item->units->short_name)({{$item->weight??'1'}}{{@$item->units->short_name}})@endif</a><strong
                                                class="product-quantity">x {{$qty}}</strong>
                                        </td>
                                        <td>{{$setting->currency_icon}}{{ number_format(($item->sell_price - $item->offer_amount),2) }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                                @php
                                $coupon = [];
                                if(session()->has('coupons')){
                                $coupon = session()->get('coupons');
                                }
                                if(!empty($coupon)){
                                $coupon_amount = $coupon['amount'];
                                }else{
                                $coupon_amount = 0;
                                }
                                @endphp

                                @php
                                    $subtotal = Helper::cart_total();
                                    $shipping = 0.00;
                                    $finalTotal = $subtotal + $shipping;
                                @endphp
                                <tfoot>
                                    <tr>
                                        <th>Subtotal</th>
                                        <td>{{$setting->currency_icon}}{{number_format(Helper::cart_total() + $coupon_amount,2)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Coupon</th>
                                        <td>{{$setting->currency_icon}}{{number_format($coupon_amount, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                          Delivery Charge
                                        </th>
                                        <td id="shipping-amount">{{ $setting->currency_icon }}{{ number_format($shipping, 2) }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p class="my-2 text-center p-1 rounded"
                                              style="background: linear-gradient(90deg, #ffecd2, #fcb69f);
                                                      color: #222;
                                                      font-weight: 600;
                                                      font-size: 16px;">
                                                FREE delivery on orders over 
                                                <strong style="color:#d63384;">
                                                    {{ $setting->currency_icon }}{{ rtrim(rtrim(Helper::setting()->free_shipping_limit, '0'), '.') }}
                                                </strong>.
                                                <a href="{{ route('shipping-details') }}"
                                                  style="text-decoration: underline; font-weight: bold; color: green;">
                                                    Details
                                                </a>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td><strong id="final-total">{{ $setting->currency_icon }}{{ number_format($finalTotal, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>

                            @if(Auth::check() && $userPoints = Helper::userPoints())
                                <div class="border-bottom border-color-1 mb-5">
                                    <h3 class="section-title mb-0 pb-2 font-size-25">Points Redemption</h3>
                                </div>

                                <div class="form-group mb-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="usePoints" name="use_points">
                                        <label class="custom-control-label" for="usePoints">
                                            Use my points (You have {{ $userPoints }} points available)
                                        </label>
                                    </div>
                                    
                                    <div id="pointsContainer" class="mt-3" style="display: none;">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <label class="form-label">Points to use (1 point = 1 {{ $setting->currency_icon }})</label>
                                                <input type="number" class="form-control" name="points_used" id="pointsUsed" 
                                                      min="0" max="{{ $userPoints }}" value="0">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="alert alert-info mb-0">
                                                    <div>Points applied: <span id="pointsApplied">0</span> ({{ $setting->currency_icon }}<span id="pointsValue">0.00</span>)</div>
                                                    <div>Remaining points: <span id="remainingPoints">{{ $userPoints }}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            <!-- End Product Content -->

                            {{-- payment section start  --}}
                            <div class="">
                                <!-- Payment methods -->
                                <div class="border-top border-width-3 border-color-1 pt-3 mb-3">
                                    <!-- Basics Accordion -->
                                    <div id="basicsAccordion1">
                                        <!-- Card -->
                                        <div class="border-bottom border-color-1 border-dotted-bottom">
                                            <div class="p-3" id="basicsHeadingThree">
                                                <div class="custom-control custom-radio">
                                                    <input checked type="radio" class="custom-control-input"
                                                        id="sthirdstylishRadio1" name="payment_type"
                                                        value="cash_on_delivary">
                                                    <label class="custom-control-label form-label"
                                                        for="sthirdstylishRadio1" data-toggle="collapse"
                                                        data-target="#basicsCollapseThree" aria-expanded="false"
                                                        aria-controls="basicsCollapseThree">
                                                        Cash on delivery
                                                    </label>
                                                </div>
                                                <!-- Stripe Payment Option -->
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        id="stripePayment" name="payment_type"
                                                        value="stripe">
                                                    <label class="custom-control-label form-label"
                                                        for="stripePayment">
                                                        Credit/Debit Card (Stripe)
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Card -->
                                    </div>
                                    <!-- End Basics Accordion -->
                                </div>
                                
                                <!-- Terms checkbox -->
                                <div class="form-group d-flex align-items-center justify-content-between px-3 mb-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="termsCheck" name="terms_conditions" onchange="togglePlaceOrder(this)">
                                        I have read and agree to the website 
                                        <a href="{{ route('terms_conditions.index') }}" class="text-blue" target="_blank">terms and conditions</a>
                                        <span class="text-danger">*</span>
                                    </div>
                                </div>
                                
                                <!-- Place order button -->
                                <button type="submit"
                                    class="btn btn-primary-dark-w btn-block btn-pill font-size-20 mb-7 py-3 order-placed text-white" id="placeOrderBtn" disabled>Place order</button>
                            </div>
                            {{-- payment section end  --}}

                        </div>
                        <!-- End Order Summary -->
                    </div>
                </div>
            </div>

            <div class="col-lg-7 order-lg-1 order-1">
                <div class="pb-2 mb-2">
                    <!-- Title -->
                    <div class="border-bottom border-color-1 mb-5">
                        <h3 class="section-title mb-0 pb-2 font-size-25 billing-text">@if(Auth::check()) Billing Details @else Your Personal Information @endif</h3>
                    </div>
                    <!-- End Title -->

                    <!-- Billing Form -->
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="name" placeholder="Your Name"
                                    value="{{@(Auth::user()->name)}}" id="billing-name">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" value="{{@(Auth::user()->email)}}" name="email"
                                    placeholder="Your Email" id="billing-email">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-6">
                            <div class="js-form-message mb-6">
                                <label class="form-label">Prefecture <span class="text-danger">*</span></label>
                                <select name="prefecture" class="form-control" id="prefecture-select" required>
                                    @foreach ($prefectures as $prefecture)
                                        <option value="{{ $prefecture['id'] }}" data-charge="{{ $prefecture['charge'] }}">
                                            {{ $prefecture['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="js-form-message mb-6">
                              <label class="form-label">City</label>
                              <input type="text" class="form-control" name="city" value="{{@$profile->city}}" placeholder="City" id="billing-city">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Address
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="address" value="{{@$profile->street_address}}" placeholder="Address" id="billing-address">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-4">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Apt, suite, etc.
                                </label>
                                <input type="text" class="form-control" name="apt_suite" value="{{@$profile->apt_suite}}" id="billing-apt-suite">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Postcode/Zip
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="postcode" value="{{@$profile->post_code}}" placeholder="Post Code" id="billing-postcode">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Phone
                                </label>
                                <input type="text" class="form-control" name="phone" placeholder="Phone Number" value="{{@$profile->phone}}" id="billing-phone">
                            </div>
                            <!-- End Input -->
                        </div>

                        @if(!Auth::check())
                        <div class="col-12 row" id="password-section">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-password">Password*</label>
                                    <input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control"><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label" for="input-confirmed">Confirm Password*</label>
                                <input type="password" name="confirmed" value="" placeholder="Password" id="input-password" class="form-control"><br>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- End Billing Form -->

                    <!-- Shipping Address Section -->
                    <div class="border-bottom border-color-1 mb-5">
                        <h3 class="section-title mb-0 pb-2 font-size-25">Shipping Address</h3>
                    </div>

                    <div class="form-group mb-4">
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" class="custom-control-input" id="sameAsBilling" 
                                name="shipping_option" value="same" checked>
                            <label class="custom-control-label" for="sameAsBilling">
                                Same As Billing Address
                            </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="differentShipping" 
                                name="shipping_option" value="different">
                            <label class="custom-control-label" for="differentShipping">
                                Ship To Different Address
                            </label>
                        </div>
                    </div>

                    <div id="shippingAddressForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                        Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="shipping_name"
                                        placeholder="Shipping Name" id="shipping-name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                        Email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="shipping_email"
                                        placeholder="Shipping Email" id="shipping-email">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="js-form-message mb-6">
                                    <label class="form-label">Prefecture <span class="text-danger">*</span></label>
                                    <select name="shipping_prefecture" class="form-control select2" id="shipping-prefecture-select">
                                        @foreach ($prefectures as $prefecture)
                                            <option value="{{ $prefecture['id'] }}" data-charge="{{ $prefecture['charge'] }}">
                                                {{ $prefecture['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="js-form-message mb-6">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="shipping_city" placeholder="City" id="shipping-city">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                        Address
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="shipping_address" placeholder="Address" id="shipping-address">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                        Apt, suite, etc.
                                    </label>
                                    <input type="text" class="form-control" name="shipping_apt_suite" id="shipping-apt-suite">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                        Postcode/Zip
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="shipping_postcode" placeholder="Post Code" id="shipping-postcode">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                        Phone
                                    </label>
                                    <input type="text" class="form-control" name="shipping_phone" placeholder="Phone Number" id="shipping-phone">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="js-form-message mb-6">
                        <label class="form-label">
                            Order notes (optional)
                        </label>
                        <div class="input-group">
                            <textarea class="form-control p-5" rows="4" name="order_note"
                                placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                        </div>
                    </div>
                </div>
              
            </div>
            <input type="hidden" name="calculated_shipping" id="calculated-shipping" value="0">
    </form>
    @else
    <h4 class="text-center p-5 m-5">No Cart Data Found!</h4>
    @endif
</div>

  <style>
    .select2-container--default .select2-selection--single {
        border-radius: 20px;
        height: 42px !important;
    }
  </style>

@endsection

@section('script')
<script>

    function togglePlaceOrder(checkbox) {
        $('#placeOrderBtn').prop('disabled', !checkbox.checked);
    }
    
    $(document).ready(function () {
        // Initialize variables
        const userPoints = {{ Auth::check() ? Helper::userPoints() : 0 }};
        const currencyIcon = '{{ $setting->currency_icon }}';
        const freeShippingLimit = {{ $setting->free_shipping_limit }};
        const couponAmount = {{ session()->has('coupons') ? session()->get('coupons')['amount'] : 0 }};
        const subtotal = {{ Helper::cart_total() }};
        
        // Initialize select2
        $('#prefecture-select, #shipping-prefecture-select').select2({ width: '100%' });

        // Initial calculations
        updateShippingAndTotal();

        // Toggle points input visibility
        $('#usePoints').change(function() {
            if($(this).is(':checked')) {
                $('#pointsContainer').slideDown();
                // Set max points that can be used (not exceeding order total)
                const maxPoints = Math.min(userPoints, Math.floor(getCurrentTotal()));
                $('#pointsUsed').attr('max', maxPoints).val(maxPoints);
                updatePointsDisplay();
            } else {
                $('#pointsContainer').slideUp();
                $('#pointsUsed').val(0);
                updateOrderTotal(0);
            }
        });
        
        // Handle points input changes
        $('#pointsUsed').on('input', function() {
            updatePointsDisplay();
        });

        // Shipping option toggle
        $('input[name="shipping_option"]').on('change', function () {
            if (this.value === 'same') {
                syncShippingWithBilling();
            } else {
                enableShippingFields();
            }
            updateShippingAndTotal();
            updatePointsMaxAndDisplay();
        });

        // Initial check for same shipping address
        if ($('input[name="shipping_option"]:checked').val() === 'same') {
            syncShippingWithBilling();
        }

        // Sync billing to shipping when "same"
        $('[id^="billing-"]').on('input', function () {
            if ($('input[name="shipping_option"]:checked').val() === 'same') {
                const shippingField = $(`#${this.id.replace('billing-', 'shipping-')}`);
                if (shippingField.length) {
                    shippingField.val($(this).val());
                }
            }
        });

        // Prefecture change handlers
        $('#prefecture-select').on('change', function () {
            updateShippingAndTotal();
            if ($('input[name="shipping_option"]:checked').val() === 'same') {
                $('#shipping-prefecture-select')
                    .val($(this).val())
                    .trigger('change');
            }
            updatePointsMaxAndDisplay();
        });

        $('#shipping-prefecture-select').on('change', function() {
            updateShippingAndTotal();
            updatePointsMaxAndDisplay();
        });

        // Helper functions
        function getCurrentTotal() {
            const shipping = parseFloat($('#calculated-shipping').val()) || 0;
            return subtotal + shipping;
        }
        
        function updatePointsDisplay() {
            let pointsToUse = parseInt($('#pointsUsed').val()) || 0;
            const maxPoints = Math.min(userPoints, Math.floor(getCurrentTotal()));
            
            // Validate input
            if(pointsToUse > maxPoints) {
                pointsToUse = maxPoints;
                $('#pointsUsed').val(pointsToUse);
            }
            if(pointsToUse < 0) {
                pointsToUse = 0;
                $('#pointsUsed').val(pointsToUse);
            }
            
            // Update display
            $('#pointsApplied').text(pointsToUse);
            $('#pointsValue').text(pointsToUse.toFixed(2));
            $('#remainingPoints').text(userPoints - pointsToUse);
            
            // Update order total
            updateOrderTotal(pointsToUse);
        }
        
        function updateOrderTotal(pointsValue) {
            const shipping = parseFloat($('#calculated-shipping').val()) || 0;
            const totalBeforePoints = subtotal + shipping ;
            const finalTotal = totalBeforePoints - pointsValue;
            
            $('#final-total').text(currencyIcon + finalTotal.toFixed(2));
        }
        
        function updatePointsMaxAndDisplay() {
            if($('#usePoints').is(':checked')) {
                const maxPoints = Math.min(userPoints, Math.floor(getCurrentTotal()));
                const currentPoints = parseInt($('#pointsUsed').val()) || 0;
                
                if(currentPoints > maxPoints) {
                    $('#pointsUsed').val(maxPoints);
                }
                $('#pointsUsed').attr('max', maxPoints);
                updatePointsDisplay();
            }
        }

        function updateShippingAndTotal() {
            let charge = 0;
            const option = $('input[name="shipping_option"]:checked').val();
            const selectedOption = option === 'same'
                ? $('#prefecture-select option:selected')
                : $('#shipping-prefecture-select option:selected');

            charge = parseFloat(selectedOption.data('charge')) || 0;
            const shipping = subtotal >= freeShippingLimit ? 0 : charge;

            $('#shipping-amount').text(currencyIcon + shipping.toFixed(2));
            $('#calculated-shipping').val(shipping);

            updateOrderTotal($('#pointsUsed').val() || 0); // ✅ changed line
        }

        function syncShippingWithBilling() {
            const fields = ['name', 'email', 'city', 'address', 'apt-suite', 'postcode', 'phone'];
            fields.forEach(f => {
                $(`#shipping-${f}`).val($(`#billing-${f}`).val()).prop('readonly', true);
            });

            // Sync select2 value and disable it
            const selectedVal = $('#prefecture-select').val();
            $('#shipping-prefecture-select')
                .val(selectedVal)
                .trigger('change')
                .prop('disabled', true)
                .trigger('change.select2');
            
            // Disable all shipping inputs
            $('#shippingAddressForm input').prop('readonly', true);
            $('#shippingAddressForm select').prop('disabled', true).trigger('change.select2');
        }

        function enableShippingFields() {
            $('#shippingAddressForm input').prop('readonly', false);
            $('#shippingAddressForm select').prop('disabled', false).trigger('change.select2');
        }

        function togglePlaceOrder(checkbox) {
            $('#placeOrderBtn').prop('disabled', !checkbox.checked);
        }
    });
</script>
@endsection