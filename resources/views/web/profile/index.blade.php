@extends('web.layouts.master')

@section('title', 'My Profile - My Daily Shop')

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
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">My Profile</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb -->
    </div>
</div>
<!-- End breadcrumb -->

<div class="container">
    <div class="page-header m-3">
        <div class="page-title mb-3">
            <h6>Profile Setting</h6>
        </div>
    </div>

    <div class="m-5">
        <div class="row">
    
            @include('web.profile.sidebar')

            @switch($type)
                @case('dashboard')
                    @include('web.profile.dashboard')
                    @break
                @case('password')
                    @include('web.profile.password')
                    @break
                @case('address')
                    @include('web.profile.address')
                    @break
                @case('points')
                    @include('web.profile.points')
                    @break
                @case('profile')
                    @include('web.profile.profile')
                    @break
                @default
                    <h3 class="text-center text-danger">No Data Found!</h3>
                    
            @endswitch 


            </div>
    
            
        </div>                
    </div>


</div>


@endsection
