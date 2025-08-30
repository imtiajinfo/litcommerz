@extends('web.layouts.master')

@section('title', 'Forget Password - My Daily Shop')

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/logo/'.Helper::setting()->meta_logo)}}">

    {{-- <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}"> --}}

@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-xl-6">
            <div class="card m-5 p-5 shadow-lg mb-5 bg-white rounded">
                <div class="login-userheading">
                    <h3 class="p-3"><b>Forget Password</b> </h3>
                    {{-- <h4>Please login to your account</h4> --}}
                </div>
    
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('lost_password_verify_code') }}" method="post">
                    @csrf
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Enter Your Email/Username</label>
                      <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email">
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                    
                </form>
            </div>
        </div>


    </div>
</div>

@endsection
