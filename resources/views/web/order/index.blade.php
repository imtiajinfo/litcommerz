@extends('web.layouts.master')

@section('title', 'Orders - My Daily Shop')

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
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="/">Home</a></li>
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Orders</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb -->
    </div>
</div>
<!-- End breadcrumb -->

<div class="container">
    <div class="my-6">
        <h1 class="text-center">My Orders</h1>
    </div>
    <div class="mb-16 wishlist-table">
        <form class="mb-4" action="#" method="post">
            <div class="table-responsive">
                <table class="table" cellspacing="0">
                    
                    <tbody>
                        <div id="accordion">

                            @forelse($orders as $order)

                                <div class="card">
                                    <div class="card-header text-white bg-primary p-3" id="headingOne">
                                        <h5 class="mb-0">

                                            <div class="container" data-toggle="collapse" data-target="#collapseOne-{{$order->id}}" aria-expanded="true" aria-controls="collapseOne-{{$order->id}}">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                    <b> Order #{{$order->id}}</b>&nbsp;&nbsp;&nbsp;<br>
                                                    <a target="_blank" class="btn btn-warning btn-sm mt-2" href="{{ url('invoice/'.$order->id) }}"><strong>Invoice </strong> </a>&nbsp;&nbsp;&nbsp;
                                                    </div>
                                                    <div class="col-lg-3">
                                                    <b> Total Amount : {{$setting->currency_icon}} {{$order->total_amount}}</b>&nbsp;&nbsp;&nbsp;<br>
                                                    <b> Coupon Amount : {{$setting->currency_icon}} {{$order->coupon}}</b>&nbsp;&nbsp;&nbsp;<br>
                                                    <b> Payable Amount : {{$setting->currency_icon}} {{$order->total_amount - $order->coupon}}</b>&nbsp;&nbsp;&nbsp;
                                                    </div>
                                                    
                                                    <div class="clo-lg-2">
                                                        <b>
                                                             Delivary Information :
                                                            @if($order->is_shipping == 1)
                                                                @php
                                                                    $ship = json_decode($order->shipping_info->shipping_info);
                                                                @endphp
                                                                {{$ship->address}}, {{$ship->apt_suite}},<br> {{$ship->city}}, {{$ship->postcode}}, {{$ship->phone}}
                                                            @else
                                                                @php
                                                                    $ship = json_decode($order->shipping_info->shipping_info);
                                                                    $ship = json_decode($order->shipping_info->user_info);
                                                                @endphp
                                                                {{$ship->address}}, {{$ship->apt_suite}},<br> {{$ship->city}}, {{$ship->postcode}}, {{$ship->phone}}
                                                            @endif
                                                        </b>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <b style="text-align: right">
                                                            <li> Delivary Status : <span class="text-bold text-success">@if($order->track_status==0){{"Pending"}}
                                                                @elseif($order->track_status==1){{"Confirm"}}
                                                                @elseif($order->track_status==2){{"Ready For Delivary"}}
                                                                @elseif($order->track_status==3){{"On The Way"}}
                                                                @elseif($order->track_status==4){{"Nearist"}}
                                                                @elseif($order->track_status==5){{"Delivered"}}
                                                                @elseif($order->track_status==6){{"Cancelled"}}@endif</li> 
                                                            </span>
                                                        </b>
                                                    </div>
                                                </div>
                                            </div>                                               
                                                
                                        </h5>
                                    </div>
                            
                                    <div id="collapseOne-{{$order->id}}" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div>

                                            @foreach($order->orderDetails as $item)
                                                <div class="m-2 card align-items-center shadow shadow-md " style="width: 14rem;float: left;">
                                                    <a target="_blank" href="{{ url('product/'.@$item->product->slug) }}"><img class="img-fluid max-width-100 p-1" src="{{ asset('frontend/images/product/'.@$item->product->first_img->image) }}" alt="{{@$item->product->product_name}}"></a>
                                                    <div class="card-body">
                                                        <p class="card-text"><a target="_blank" href="{{ url('product/'.@$item->product->slug) }}">{{Str::limit(@$item->product->product_name,30)}} @if(@$item->product->units->short_name)({{$item->product->weight??'1'}}{{@$item->product->units->short_name}})@endif</a></p>
                                                        <b> <span class="">{{$setting->currency_icon}}{{ number_format(@$item->product->sell_price - $item->discount,2) }} x {{$item->quantity}}</span> = <span class="">{{$setting->currency_icon}}{{ number_format(((@$item->product->sell_price - $item->discount)*$item->quantity),2) }}</span></b>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="6"><h5 class="text-center m-5">No Order</h5></td>
                                </tr>
                            @endforelse
                   
                          </div>

                          <!-- Shop Pagination -->
                            <nav class="d-md-flex justify-content-between align-items-center border-top pt-3" aria-label="Page navigation example">
                                <div class="text-center text-md-left mb-3 mb-md-0">Showing {{$orders->firstItem()}}-{{$orders->lastItem()}} of {{$orders->total()}} results</div>
                                <ul class="pagination mb-0 pagination-shop justify-content-center justify-content-md-start">
                                    {!! $orders->links() !!}
                                </ul>
                            </nav>
                            <!-- End Shop Pagination -->


                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<style>
    b{
        font-size: small
    }
</style>


@endsection


{{-- <section style="background-color: #eee;">
    <div class="container py-5">

      <div class="row justify-content-center mb-3">
        <div class="col-md-12 col-xl-10">
          <div class="card shadow-0 border rounded-3">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                  <div class="bg-image hover-zoom ripple rounded ripple-surface">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/img%20(4).webp"
                      class="w-100" />
                    <a href="#!">
                      <div class="hover-overlay">
                        <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6">
                  <h5>Quant trident shirts</h5>
                  <div class="d-flex flex-row">
                    <div class="text-danger mb-1 me-2">
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                    </div>
                    <span>310</span>
                  </div>
                  <div class="mt-1 mb-0 text-muted small">
                    <span>100% cotton</span>
                    <span class="text-primary"> • </span>
                    <span>Light weight</span>
                    <span class="text-primary"> • </span>
                    <span>Best finish<br /></span>
                  </div>
                  <div class="mb-2 text-muted small">
                    <span>Unique design</span>
                    <span class="text-primary"> • </span>
                    <span>For men</span>
                    <span class="text-primary"> • </span>
                    <span>Casual<br /></span>
                  </div>
                  <p class="text-truncate mb-4 mb-md-0">
                    There are many variations of passages of Lorem Ipsum available, but the
                    majority have suffered alteration in some form, by injected humour, or
                    randomised words which don't look even slightly believable.
                  </p>
                </div>
                <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                  <div class="d-flex flex-row align-items-center mb-1">
                    <h4 class="mb-1 me-1">$13.99</h4>
                    <span class="text-danger"><s>$20.99</s></span>
                  </div>
                  <h6 class="text-success">Free shipping</h6>
                  <div class="d-flex flex-column mt-4">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-sm" type="button">Details</button>
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary btn-sm mt-2" type="button">
                      Add to wishlist
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      

    </div>
</section> --}}