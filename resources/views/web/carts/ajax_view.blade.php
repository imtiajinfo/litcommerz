@php
    $setting = Helper::setting();
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
@if(count(Helper::cart_products())>0)
  <ul class="list-unstyled px-3 pt-3" id="cart-view">
        @forelse (Helper::cart_products() as $index => $item)
          @php
              $index = array_search($item->id, array_column(session()->get('carts'), 'product_id'));
              $qty = session()->get('carts')[$index]['qty'];
          @endphp
          <li class="border-bottom pb-3 mb-3">
              <div class="">
                  <ul class="list-unstyled row mx-n2">
                      <li class="px-2 col-auto">
                          <a href="{{ url('product/'.$item->slug) }}"><img style="height: 60px" src="{{ asset('frontend/images/product/'.@$item->first_img->image) }}" alt="{{Str::limit($item->product_name,50)}}"></a>
                      </li>
                      <li class="px-1 col border border-bottom">
                          <h5 class="text-blue font-size-14 font-weight-bold">
                              <a href="{{ url('product/'.$item->slug) }}">{{Str::limit($item->product_name,18)}}</a>
                          </h5>
                          
                          <span class="font-size-14 total_cart_price pb-4">{{$setting->currency_icon}}{{ number_format(($item->sell_price -$item->offer_amount),2) }} x <span class="sidebar-qty">{{$qty}}</span> @if(@$item->units->short_name)({{$item->weight??'1'}}{{@$item->units->short_name}})@endif</span>
                          <span style="float: right;">
                              <a href="#" index={{$index}} class="text-gray-90 cart-remove"><i class="ec ec-close-remove font-weight-bold"></i></a>
                          </span>
                          
                          <span>
                              <div class="input-group mb-1 mt-2">
                                  <button type="button" class="cart-pm-btn pl-2 pr-2 cart-minus-sidebar" style="background: #ffffb8" index={{$index}}>-</button>
                                  <input type="text" readonly class="form-control cart-input-change" style="height: 30px;text-align:center" value="{{$qty}}" index={{$index}}>
                                  <button style="background: #ffffb8" type="button" class="cart-pm-btn pl-2 pr-2 cart-plus-sidebar" index={{$index}}>+</button>
                                  <span>&nbsp;&nbsp;&nbsp;{{$setting->currency_icon}}<span class="sidebar-sub-total">{{ number_format((($item->sell_price -$item->offer_amount) *$qty),2) }}</span>&nbsp;&nbsp;</span>
                              </div>
                          </span>
                      </li>
                  </ul>
              </div>
          </li>
        @empty
        @endforelse
  </ul>
@endif
@if(count(Helper::cart_products())>0)
<div class="row mb-0">
    <div class="col-12">
        <p class="mb-2 text-center p-1 rounded" 
          style="background: linear-gradient(90deg, #ffecd2, #fcb69f); 
                  color: #222; 
                  font-weight: 600; 
                  font-size: 16px;">
            FREE delivery on orders over 
            <strong style="color:#d63384;">¥{{ rtrim(rtrim(Helper::setting()->free_shipping_limit, '0'), '.') }}</strong>.  
            <a href="{{ route('shipping-details') }}" 
              style="text-decoration: underline; font-weight: bold; color: #green;">
                Details
            </a>
        </p>
        <ol class="list-group list-group-numbered">
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <b>Subtotal :</b>
                </div>
                <span class="text-md rounded-pill"><b>{{$setting->currency_icon}}<span class="sub-total-price-sidebar">{{number_format(Helper::cart_total()+$coupon_amount,2)}}</span></b></span>
            </li>
        </ol>
    </div>
    <div class="col-6">
        <a href="#" class="btn btn-primary mt-2 continue-shopping w-100">Continue Shop</a>
    </div>
    <div class="col-6">
        <a href="/carts" class="btn btn-primary mt-2 view-cart w-100">View Cart</a>
    </div>
    <div class="col-12">
        <a href="/checkout" class="btn btn-warning w-100 mt-2">Checkout</a>
    </div>
</div>
@else
<div class="mt-2">
    <div class="cart-sidebar-body-empty">
        <p class="text-center cart-empty">Your Cart is empty</p>
        <a style="margin: auto" href="/shop" class="btn btn-primary btn-md text-center return-to-shop">Return to shop</a>
    </div>
</div>
@endif