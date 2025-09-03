@extends('web.layouts.master')

@section('title', 'Contact - My Daily Shop')

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
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb -->
    </div>
</div>
<!-- End breadcrumb -->

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <div class="row mb-10">
        <div class="col-md-8 col-xl-9">
            <div class="mr-xl-6 pt-3">
                <div class="border-bottom border-color-1 mb-5">
                    <h3 class="section-title mb-0 pb-2 font-size-25">Contact Message</h3>
                </div>
                <form action="{{route('contact.store')}}" method="post" class="js-validate" novalidate="novalidate">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-4">
                                <label class="form-label">
                                    First name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="first_name" placeholder="" aria-label="" required="" data-msg="Please enter your frist name." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-4">
                                <label class="form-label">
                                    Last name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="last_name" placeholder="" aria-label="" required="" data-msg="Please enter your last name." data-error-class="u-has-error" data-success-class="u-has-success">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-12">
                            <!-- Input -->
                            <div class="js-form-message mb-4">
                                <label class="form-label">
                                    Subject
                                </label>
                                <input type="text" required class="form-control" name="subject" placeholder="" aria-label="" data-msg="Please enter subject." data-error-class="u-has-error" data-success-class="u-has-success">
                            </div>
                            <!-- End Input -->
                        </div>
                        <div class="col-md-12">
                            <div class="js-form-message mb-4">
                                <label class="form-label">
                                    Your Message
                                </label>

                                <div class="input-group">
                                    <textarea required class="form-control p-5" rows="4" name="text" placeholder=""></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary-dark-w px-5">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4 col-xl-3">
            <div class="border-bottom border-color-1 mb-5">
                <h3 class="section-title mb-0 pb-2 font-size-25">Contact US</h3>
            </div>
            <div class="mr-xl-6">

              @php
                $contact = \App\Models\KeyValueSetting::where('key', 'contact_us')->first();
              @endphp
              {!! $contact->value !!}

            </div>
        </div>
    </div>
    
</div>


@endsection
