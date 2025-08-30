@extends('web.layouts.master')

@section('title', 'Comment Form - My Daily Shop')

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
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Comment Form</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb -->
    </div>
</div>
<!-- End breadcrumb -->

<div class="container">
    <div class="row mb-10 justify-content-center">
        <div class="col-md-10 col-xl-10">
            <div class="mr-xl-6 pt-3">
                <div class="border-bottom border-color-1 mb-5">
                    <h3 class="pb-2 font-size-25 text-center">Comment Form</h3>
                </div>
                <form action="{{route('complain_form_store')}}" method="post" class="js-validate" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <!-- Input -->
                            <div class="js-form-message mb-4">
                                <label class="form-label">
                                    Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="name" placeholder="" aria-label="" required="" data-msg="Please enter your name." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off"
                                value="{{ old('name') }}">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-4">
                                <label class="form-label">
                                    Email
                                </label>
                                <input type="email" required class="form-control" name="email" placeholder="" aria-label="" data-msg="Please enter email." data-error-class="u-has-error" data-success-class="u-has-success"
                                value="{{ old('email') }}">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-4">
                                <label class="form-label">
                                    Order No
                                </label>
                                <input type="text" required class="form-control" name="order_no" placeholder="" aria-label="" data-msg="Please enter order no." data-error-class="u-has-error" data-success-class="u-has-success"
                                value="{{ old('order_no') }}">
                            </div>
                            <!-- End Input -->
                        </div>
                       
                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-4">
                                <label class="form-label">
                                    Phone
                                </label>
                                <input type="phone" required class="form-control" name="phone" placeholder="" aria-label="" data-msg="Please enter phone." data-error-class="u-has-error" data-success-class="u-has-success"
                                value="{{ old('phone') }}">
                            </div>
                            <!-- End Input -->
                        </div>
                        <div class="col-md-12">
                            <!-- Input -->
                            <div class="js-form-message mb-4">
                                <label class="form-label">
                                    Inquery Type
                                </label>
                                <input type="text" required class="form-control" name="inquery" placeholder="" aria-label="" data-msg="Please enter subject." data-error-class="u-has-error" data-success-class="u-has-success"
                                value="{{ old('inquery') }}">
                            </div>
                            <!-- End Input -->
                        </div>
                        <div class="col-md-12">
                            <div class="js-form-message mb-4">
                                <label class="form-label">
                                    Your Message
                                </label>

                                <div class="input-group">
                                    <textarea required class="form-control p-5" rows="4" name="message" placeholder="">{{ old('message') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <!-- Input -->
                            <div class="js-form-message mb-4">
                                <label class="form-label">
                                    File Upload
                                </label>
                                <input type="file" required class="form-control" name="image">
                            </div>
                            <!-- End Input -->
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary-dark-w px-5 text-white">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    
</div>

@endsection
