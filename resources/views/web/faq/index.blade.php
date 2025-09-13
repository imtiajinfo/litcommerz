@extends('web.layouts.master')

@section('title', @$meta_title ?? 'FAQ')
@section('meta_title', @$meta_title)
@section('meta_description', @$meta_description)
@section('meta_keywords', @$meta_keywords)
@section('meta_og_image', @$meta_og_image ? asset($meta_og_image) : '')
@section('meta_og_alt', @$meta_og_alt)

@section('main')

<!-- breadcrumb -->
<div class="bg-gray-13 bg-md-transparent">
    <div class="container">
        <!-- breadcrumb -->
        <div class="my-md-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="/">Home</a></li>
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">FAQ</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb -->
    </div>
</div>
<!-- End breadcrumb -->

<div class="container">
    <div class="mb-12 text-center">
              {!!@$data !!}
    </div>
    

    
</div>

@endsection
