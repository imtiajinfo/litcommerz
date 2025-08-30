@extends('web.layouts.master')

@section('title', 'Coupon Offers - My Daily Shop')

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
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Coupon Offers
                    </li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb -->
    </div>
</div>
<!-- End breadcrumb -->


<div class="container">

    @foreach ($coupons as $item) 
    
        <div class="row mb-10 justify-content-center" style="border: 3px solid #1ec30a;border-style: dashed;">
            <div class="col-md-10 col-xl-10">
                <div class="mr-xl-12">
                    <div class="elementor-container elementor-column-gap-default">
                        <div class="elementor-row">
                            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-38ff5ee"
                                data-id="38ff5ee" data-element_type="column">
                                <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-widget-wrap">

                                        <div class="elementor-element elementor-element-ed31ee5 elementor-widget elementor-widget-heading"
                                            data-id="ed31ee5" data-element_type="widget" data-widget_type="heading.default">
                                            <div class="elementor-widget-container">
                                                <h3 class="elementor-heading-title elementor-size-default">{{$item->name}}</h3>
                                            </div>
                                        </div>

                                        <div class="elementor-element elementor-element-cc6f763 elementor-widget elementor-widget-image">
                                            <div class="elementor-widget-container">
                                                <div class="elementor-image">
                                                    <img width="100%" height="auto" src="{{asset('frontend/images/coupon/'.$item->banner)}}" class="attachment-large size-large wp-image-42372 entered lazyloaded" alt=""> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="elementor-element elementor-element-49f3f4d elementor-widget elementor-widget-text-editor">
                                            <div class="elementor-widget-container">
                                                <div class="elementor-text-editor elementor-clearfix">
                                                    <h5><b>Use Coupon Code:</b>&nbsp;<span style="color: #7928c2">“<strong>{{$item->coupon_code}}″</strong></span></h5>
                                                    <p><span style="text-decoration: underline">Conditions:</span></p>
                                                    <ul>
                                                        <li>Minimum Spend {{$setting->currency_icon}}{{number_format($item->minimum_sale_amount, 0)}}.</li>
                                                        <li>
                                                          Minimum Discount 
                                                          @if($item->type == 2)
                                                            {{ $item->amount }}% ({{ $setting->currency_icon }}{{ number_format(($item->minimum_sale_amount * $item->amount) / 100, 0) }}+)
                                                          @else
                                                            {{ $setting->currency_icon }}{{ number_format($item->amount, 0) }}
                                                          @endif
                                                          .
                                                        </li>
                                                        <li>Customers are allowed to use only 1 coupon for each order.</li>
                                                        <li>Use this coupon <b>“{{$item->coupon_code}}”</b> on the checkout page.</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    @endforeach


    <div class="row mb-10 justify-content-center" style="border: 3px solid #1ec30a;border-style: dashed;">
        <div class="col-md-10 col-xl-10">
            <div class="mr-xl-12">
                <div class="elementor-container elementor-column-gap-default">
                    <div class="elementor-row">
                        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-38ff5ee"
                            data-id="38ff5ee" data-element_type="column">
                            <div class="elementor-column-wrap elementor-element-populated">
                                <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-ed31ee5 elementor-widget elementor-widget-heading"
                                        data-id="ed31ee5" data-element_type="widget" data-widget_type="heading.default">
                                        <div class="elementor-widget-container">
                                            <h3 class="elementor-heading-title elementor-size-default">500 Points on 1st Order</h3>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-cc6f763 elementor-widget elementor-widget-image" data-id="cc6f763" data-element_type="widget" data-widget_type="image.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-image">
                                                <img width="100%"  height="auto" src="{{ asset('images/first_order.png') }}" class="attachment-large size-large wp-image-42372 entered lazyloaded" alt="" ></div>
                                        </div>
                                    </div>
                                    <div class="elementor-element  elementor-element-ea62b30 elementor-widget elementor-widget-text-editor" data-id="ea62b30"  data-element_type="widget"  data-widget_type="text-editor.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-text-editor elementor-clearfix">
                                                <p><span style="text-decoration: underline;color: #000000"><span style="font-family: var(--font-primary);letter-spacing: 0px;background-color: var(--color-background)">Conditions:</span></span>
                                                </p>
                                                <ul>
                                                    <li>500 points on 1st order.</li>
                                                    <li>No minimum spending is required.</li>
                                                    <li>Earn points on every&nbsp;<span style="letter-spacing: -0.1px">{{$setting->currency_icon}}</span>100
                                                        spent.</li>
                                                    <li>1 Point =&nbsp;<span style="letter-spacing: -0.1px">{{$setting->currency_icon}}</span>1.</li>
                                                    <li>Check your points on your Account page.</li>
                                                    <li>Use these points on the checkout page.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <br><br>

</div>


@endsection
