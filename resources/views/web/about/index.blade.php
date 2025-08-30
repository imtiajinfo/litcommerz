@extends('web.layouts.master')

@section('title', 'About - My Daily Shop')

@php
    $setting = Helper::setting();
@endphp

@section('main')

<div class="bg-img-hero mb-14">
    <div class="container">
        <div class="flex-content-center pt-5 mt-5 flex-column mx-auto text-center">
            <h1 class="h1 font-weight-bold">About Us</h1>
            {!! @$setting->about !!}
        </div>
    </div>
</div>

@endsection
