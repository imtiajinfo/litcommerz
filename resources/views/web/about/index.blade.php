@extends('web.layouts.master')

@section('title', @$meta_title ?? 'About')
@section('meta_title', @$meta_title)
@section('meta_description', @$meta_description)
@section('meta_keywords', @$meta_keywords)
@section('meta_og_image', @$meta_og_image ? asset($meta_og_image) : '')
@section('meta_og_alt', @$meta_og_alt)

@section('main')

<div class="bg-img-hero mb-14">
    <div class="container">
        <div class="pt-5 mt-5 flex-column mx-auto">
            <h1 class="h1 font-weight-bold">About Us</h1>
            {!!@$data !!}
        </div>
    </div>
</div>

@endsection
