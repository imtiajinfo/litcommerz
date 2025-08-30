@extends('web.layouts.master')

@section('title', 'Wishlist - My Daily Shop')

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
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Wishlist</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb -->
    </div>
</div>
<!-- End breadcrumb -->

<div class="container">
    <div class="my-6">
        <h1 class="text-center">My wishlist</h1>
    </div>
    <div class="mb-16 wishlist-table">
        <form class="mb-4" action="#" method="post">
            <div class="table-responsive">
                <table class="table" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="product-remove">Sl</th>
                            <th class="product-thumbnail">Image</th>
                            <th class="product-name">Product</th>
                            <th class="product-price">Unit Price</th>
                            <th class="product-Stock w-lg-15">Stock Status</th>
                            <th class="product-subtotal min-width-200-md-lg">Cart</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($wishlists as $item)
                            
                            <tr>
                                <td class="text-center">
                                    <a href="/wishlist-destory/{{$item->id}}" class="text-gray-32 font-size-26">x</a>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <a href="#"><img class="img-fluid max-width-100 p-1 border border-color-1" src="{{ asset('frontend/images/product/'.$item->product->first_img->image) }}" alt="{{$item->product->product_name}}"></a>
                                </td>

                                <td data-title="Product">
                                    <a href="#" class="text-gray-90">{{$item->product->product_name}}</a>
                                </td>

                                <td data-title="Unit Price">
                                    <span class="">{{$setting->currency_icon}}{{ number_format($item->product->sell_price,2) }}</span>
                                </td>

                                <td data-title="Stock Status">
                                    @if($item->product->available_stock > 0)
                                        <span>In stock</span>
                                    @else
                                        <span>Out of stock</span>
                                    @endif
                                </td>

                                <td>
                                    @if(in_array($item->product->id, $carts))
                                        <button type="button" class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto">Added</button>
                                    @else
                                        <button type="button" class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto wishlist-add-to-cart" get-id={{$item->product->id}}>Add to Cart</button>
                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6"><h5 class="text-center m-5">No Wishlist</h5></td>
                            </tr>
                        
                        @endforelse

                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>




@endsection
