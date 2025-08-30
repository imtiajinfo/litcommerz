@extends('web.layouts.master')

@section('title', 'Forget Password - My Daily Shop')

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/logo/'.Helper::setting()->meta_logo)}}">

@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-8">
            <div class="card m-5 p-5 shadow-lg mb-5 bg-white rounded">
                <div class="login-userheading">
                    <p class="justify-content-center d-flex"><i class="fa fa-envelope pt-3" style="font-size: 2rem"></i></p>
                    <h4 class="p-2 text-center alert"><b>Send Email Successfully</b> </h4>
                </div>

                <div class="col-12 pb-4">
                    <h4 class="text-center text-danger">Please Check Your Email & Verify</h4>
                    <h6 class="text-center text-danger">For Recover Your Account!</h6>
                </div>
            </div>
        </div>


    </div>
</div>

@endsection
