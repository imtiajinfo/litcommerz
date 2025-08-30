@php
    $setting = Helper::setting();
    if(Auth::check()){
        $wishlist_pro_ids = Helper::wishlist_pro_ids();
    }else{
        $wishlist_pro_ids = [];
    }
@endphp
@foreach ($products as $product)
    
<li class="col-6 col-md-3 col-wd-2gdot4 product-item  mb-2">
    <div class="product-item__outer h-100">
      <input type="hidden" class="product-id" value="{{ $product->id }}">
        <div class="product-item__inner px-xl-4 p-3 mb-4 @if($product->available_stock <= 0) disabled-div @endif">

            <div class="product-item__body pb-xl-2">
                <div class="mb-2">
                    {{-- <a href="#" class="font-size-12 text-gray-5">{{@$product->category->category_name}}</a> --}}
                    @if($product->offer_amount >0)
                        <div class="product-badges" style="right: 0.125rem;top: 1.5rem;left: unset;">
                                <span class="savebadge onsale">
                                <span>Save</span>
                                <span><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">{{$setting->currency_icon}}</span>{{$product->offer_amount}}</bdi></span></span>
                                </span>
                        </div>
                    @else
                        {{-- <div class="product-badges1" style="right: 0.5rem;top: 1.8rem;left: unset;">
                            <span class="savebadge1 onsale">
                            <span><a href="{{ url('product/'.$product->slug) }}"><i class="fa fa-arrows-alt font-size-22"></i></a></span>
                            </span>
                        </div> --}}
                    @endif
                    {{-- <div class="product-badges1" style="right: 0.5rem;top: 4.5rem;left: unset;">
                        <span class="savebadge1 onsale">
                        <span>
                            @if(Auth::check())
                                @if(in_array($product->id, Helper::wishlist_pro_ids()))
                                    <a class="add-wishlist" get-id={{$product->id}}><i class="fa fa-heart font-size-22"></i></a>
                                @else
                                    <a class="add-wishlist" get-id={{$product->id}}><i class="ec ec-favorites font-size-22"></i></a>
                                @endif
                            @else
                                <a href="/login"><i class="ec ec-favorites font-size-22"></i></a>
                            @endif
                        </span>
                        </span>
                    </div> --}}
                </div>
                
                <div class="mb-2">
                    <a href="{{ url('product/'.$product->slug) }}" class="d-block text-center"><img class="img-fluid"  src="{{ asset('frontend/images/product/'.$product->first_img->image) }}" alt="{{ $product->product_name }}"></a>
                </div>
                <div class="mb-1">
                    
                    <div class="prodcut-price text-center">
                        <div class="text-gray-100 sell-price">
                            <b>
                            @if($product->offer_amount >0)
                                <del class="text-muted">{{$setting->currency_icon}}{{number_format(($product->sell_price),2)}}</del>
                            @endif
                            <span class="text-danger">{{$setting->currency_icon}}{{number_format(($product->sell_price - $product->offer_amount),2)}}</span>
                            </b>
                        </div>
                    </div>
                    <h5 class="text-small text-center"><a href="{{ url('product/'.$product->slug) }}" class="font-weight-bold text-gray">{{ Str::limit($product->product_name, 40) }}</a></h5>
                    <div class="d-none d-xl-block prodcut-add-cart text-center">
                        <span class="text-gray text-bold">@if(@$product->units->short_name){{$product->weight??'1'}}{{@$product->units->short_name}}@endif</span>
                        <b>
                            @if($product->available_stock > 0)
                                <span style="color:#306f2a" class="text-small text-bold"> IN STOCK</span>
                            @else
                                <span class="text-small text-danger text-bold"> OUT OF STOCK</span>
                            @endif
                        </b>
                    </div>
                </div>
            </div>

            <div class="product-item__footer">
                <div class="border-top pt-2 flex-center-between flex-wrap">
                    {{-- <a href="{{ url('buy-now-cart/'.$product->id) }}" class="text-gray-6 font-size-13"><i class="ec ec-shopping-bag mr-1 font-size-15"></i> Buy Now</a>
                    @if(Auth::check())
                        @if(in_array($product->id, Helper::wishlist_pro_ids()))
                            <a href="#" class="text-primary -6 font-size-13 add-wishlist" get-id={{$product->id}}><i class="fa fa-heart" aria-hidden="true"></i> Wishlist</a>
                        @else
                            <a href="#" class="text-gray-6 font-size-13 add-wishlist" get-id={{$product->id}}><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
                        @endif
                    @else
                        <a href="/login" class="text-gray-6 font-size-13"><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
                    @endif --}}
                    @if($product->available_stock > 0)
                        @if(in_array($product->id, $carts))
                            <button get-id={{$product->id}} class="w-100 btn btn-danger btn-sm add-to-cart cart-{{$product->id}}">Added Cart</button>
                        @else
                            <button get-id={{$product->id}} class="w-100 btn btn-danger btn-sm add-to-cart cart-{{$product->id}}">Add to Cart</button>
                        @endif
                    @else
                        <a href="{{ url('product/'.$product->slug) }}" class="w-100 btn btn-danger btn-sm">Read More</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</li>

@endforeach