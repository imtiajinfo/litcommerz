@extends('web.layouts.master')

@section('title', 'Carts - My Daily Shop')

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
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb -->
    </div>
</div>
<!-- End breadcrumb -->

<div class="container-fluid">
    <div class="row">

        @if(!empty(count(Helper::cart_products())))
            <div class="col-lg-8 col-xl-8">
                <div class="mb-10 cart-table">
                    <form class="mb-4" action="{{route('coupon.apply')}}" method="post">
                        @csrf
                        <table class="table border border-1" cellspacing="0">
                            <thead>
                                
                                <tr class="border border-1">
                                    <th class="product-remove"><b>&nbsp;</b></th>
                                    <th class="product-thumbnail"><b>&nbsp;</b></th>
                                    <th class="product-name"><b>Product</b></th>
                                    <th class="product-price"><b>Price</b></th>
                                    <th class="product-price"><b>Discount</b></th>
                                    <th class="product-quantity w-lg-15"><b>Quantity</b></th>
                                    <th class="product-subtotal"><b>Total</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (Helper::cart_products() as $index => $item)
                            
                                    <tr class="border border-1">
                                        <td class="text-center">
                                            <a href="/cart-destroy/{{$index}}" class="text-gray-32 font-size-26">x</a>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <a href="{{ url('product/'.$item->slug) }}"><img class="img-fluid max-width-100 p-1 border border-color-1" src="{{asset('frontend/images/product/'.$item->first_img->image)}}" alt="{{$item->product_name}}"></a>
                                        </td>
            
                                        <td data-title="Product">
                                            <a href="{{ url('product/'.$item->slug) }}" class="text-gray-90">{{Str::limit($item->product_name,30)}} @if(@$item->units->short_name)({{$item->weight??'1'}}{{@$item->units->short_name}})@endif</a>
                                        </td>
            
                                        <td data-title="Price">
                                            <span class="">{{$setting->currency_icon}}{{ number_format($item->sell_price,2) }}</span>
                                        </td>
                                        <td data-title="Price">
                                            <span class="">{{$setting->currency_icon}}{{ number_format($item->offer_amount,2) }}</span>
                                        </td>
            
                                        <td data-title="Quantity">
                                            <span class="sr-only">Quantity</span>
                                            <!-- Quantity -->
                                            <div class="w-75 border-color-1">
                                                <div class="js-quantity row align-items-center">
                                                    @php
                                                        $index = array_search($item->id, array_column(session()->get('carts'), 'product_id'));
                                                        $qty = session()->get('carts')[$index]['qty'];
                                                    @endphp

                                                    <div class="input-group mb-1 mt-2">
                                                        <button type="button" class="cart-pm-btn pl-2 pr-2 cart-minus" style="background: #ffffb8" index={{$index}}>-</button>
                                                        <input type="text" readonly class="form-control cart-input-change" style="height: 30px;text-align:center" value="{{$qty}}" index={{$index}}>
                                                        <button style="background: #ffffb8" type="button" class="cart-pm-btn pl-2 pr-2 cart-plus" index={{$index}}>+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Quantity -->
                                        </td>
            
                                        <td data-title="Total">
                                            <span class="">{{$setting->currency_icon}}<span class="sub-total-price">{{ number_format((($item->sell_price - $item->offer_amount)*$qty),2) }}</span></span>
                                        </td>
                                    </tr>
            
                                @empty
                                    {{-- <tr>
                                        <td class="text-center" colspan="6"><h4> No Carts</h4></td>
                                    </tr> --}}
                                @endforelse
                                @if(!empty(count(Helper::cart_products())))
                                    <tr>
                                        <td colspan="6" class="border-top space-top-2 justify-content-center">
                                            <div>
                                                <div class="d-block d-md-flex flex-center-between">
                                                    <div class="mb-md-0 w-xl-40">
                                                        <!-- Apply coupon Form -->
                                                        
                                                            <label class="sr-only" for="subscribeSrEmailExample1">Coupon code</label>
                                                            <div class="input-group">
                                                                <input type="text" required class="form-control" name="coupon_code" id="subscribeSrEmailExample1" placeholder="Coupon code" aria-label="Coupon code" aria-describedby="subscribeButtonExample2" required="">
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-block btn-dark px-4" type="submit" id="subscribeButtonExample2">Apply coupon</button>
                                                                </div>
                                                            </div>
                                                        
                                                        <!-- End Apply coupon Form -->
                                                    </div>
                                                    <div class="d-md-flex">
                                                        {{-- <a href="/shop" class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto">Update cart</a> --}}
                                                        {{-- <a href="{{route('checkout.index')}}" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto d-none d-md-inline-block">Proceed to checkout</a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                
                            </tbody>
                        </table>
            
                    </form>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                @if(!empty(count(Helper::cart_products())))
                    <div class="card p-4">
                        <div class="mb-3">
                            <h3 class="d-inline-block section-title mb-3 pb-2 font-size-26 mt-5 pt-2">Cart totals</h3>
                        </div>
                        <table class="table mb-3 mb-md-0">
                            <tbody>
        
                                @php
                                    if(!empty($coupon)){
                                        $coupon_amount = $coupon['amount'];
                                    }else{
                                        $coupon_amount = 0;
                                    }
                                @endphp
                                
                                <tr class="cart-subtotal">
                                    <th>Subtotal</th>
                                    <td data-title="Subtotal"><span class="amount">{{$setting->currency_icon}}<span id="before-coupon-amount">{{number_format(Helper::cart_total()+$coupon_amount,2)}}</span></span></td>
                                </tr>

                                @php
                                    $subtotal = Helper::cart_total();
                                @endphp
                                
                                <tr class="shipping">
                                    <th>Coupon Amount</th>
                                    <td data-title="Shipping">
                                        <span class="amount">{{$setting->currency_icon}}{{number_format($coupon_amount, 2)}}</span>
                                        
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <th>Total</th>
                                    <td data-title="Total"><strong><span class="amount">{{$setting->currency_icon}}<span id="sub-total-price">{{ number_format($subtotal, 2) }}</span></span></strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="/checkout" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto mt-3 text-white">Proceed to checkout</a>
                    </div>
                @endif
            </div>
        @else
            <div class="col-12">
                <div class="cart-wrapper">
                    <div class="cart-empty-page">
                    <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 280.028 280.028" width="280.028" height="80.028">
                    <path class="text-danger" d="M35.004 0h210.02v78.758H35.004V0z" fill="#d07c40"></path>
                    <path class="c-02" d="M262.527 61.256v201.27c0 9.626-7.876 17.502-17.502 17.502H35.004c-9.626 0-17.502-7.876-17.502-17.502V61.256h245.025z" fill="#f4b459"></path>
                    <path class="c-03" d="M35.004 70.007h26.253V26.253L35.004 0v70.007zm183.767-43.754v43.754h26.253V0l-26.253 26.253z" fill="#f4b459"></path>
                    <path class="c-04" d="M61.257 61.256V26.253L17.503 61.256h43.754zm157.514-35.003v35.003h43.754l-43.754-35.003z" fill="#e3911c"></path>
                    <path class="c-05" d="M65.632 105.01c-5.251 0-8.751 3.5-8.751 8.751s3.5 8.751 8.751 8.751 8.751-3.5 8.751-8.751c0-5.25-3.5-8.751-8.751-8.751zm148.764 0c-5.251 0-8.751 3.5-8.751 8.751s3.5 8.751 8.751 8.751 8.751-3.5 8.751-8.751c.001-5.25-3.501-8.751-8.751-8.751z" fill="#cf984a"></path>
                    <path class="c-06" d="M65.632 121.637c5.251 0 6.126 6.126 6.126 6.126 0 39.379 29.753 70.882 68.257 70.882s68.257-31.503 68.257-70.882c0 0 .875-6.126 6.126-6.126s6.126 6.126 6.126 6.126c0 46.38-35.003 83.133-80.508 83.133s-80.508-37.629-80.508-83.133c-.001-.001.874-6.126 6.124-6.126z" fill="#cf984a"></path>
                    <path class="c-07" d="M65.632 112.886c5.251 0 6.126 6.126 6.126 6.126 0 39.379 29.753 70.882 68.257 70.882s68.257-31.503 68.257-70.882c0 0 .875-6.126 6.126-6.126s6.126 6.126 6.126 6.126c0 46.38-35.003 83.133-80.508 83.133s-80.508-37.629-80.508-83.133c-.001 0 .874-6.126 6.124-6.126z" fill="#fdfbf7"></path></svg>
                    </div>
                    <div class=""></div><p class="cart-empty text-danger">Your cart is currently empty.</p> <p class="return-to-shop">
                        <div class="justify-content-center d-flex align-items-center">
                            <a class="btn btn-primary rounded large button w-20" href="/shop"> Return to shop </a>
                        </div>
                    </p>
                    </div>
                    </div>
            </div>
        @endif

    </div>

    
</div>


@endsection
@if(empty(count(Helper::cart_products())))
<style>
.cart-empty-page {
    text-align: center;
    max-width: 760px;
    margin-top: 40px;
    margin-bottom: 40px;
    margin-left: auto;
    margin-right: auto;
}
.cart-empty-page .empty-icon {
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-box-align: end;
    -ms-flex-align: end;
    align-items: flex-end;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 10rem;
    height: 10rem;
    margin-bottom: 1.875rem;
}
.empty-icon {
    position: relative;
    text-align: center;
    width: 3.75rem;
    height: 3.75rem;
    border-radius: 50%;
    background-color: #eaecef;
    overflow: hidden;
}
.cart-empty-page .cart-empty {
    font-family: var(--font-secondary);
    font-size: 1.125rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--color-danger);
    margin-bottom: 1.25rem;
}
.cart-empty-page .cart-empty {
    font-family: var(--font-secondary);
    font-size: 1.125rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--color-danger);
    margin-bottom: 1.25rem;
}
.cart-empty {
    margin-top: 0vh !important;
}
#toast-container {
  z-index: 99999999 !important; /* Ensure it appears above most content */
}

#toast-container > .toast {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
@endif