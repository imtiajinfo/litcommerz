@extends('web.layouts.master')

@section('title', 'Login - My Daily Shop')

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/logo/'.Helper::setting()->meta_logo)}}">

    {{-- <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}"> --}}

@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-xl-6">
            <div class="card m-5 p-5 shadow-lg mb-5 bg-white rounded">
                <div class="login-userheading">
                    <h3 class="p-3"><b>Sign In</b> </h3>
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
                <form action="{{ route('admin.login.action') }}" method="post">
                    @csrf
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Email address</label>
                      <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email address" required value="{{ old('email') }}" autofocus>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter your password">
                    </div>

                    <div class="form-login">
                        <div class="alreadyuser m-2">
                            <a href="/forget-password" class="hover-a mb-2">Forgot Password?</a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <div class="form-login">
                        <div class="mt-3">
                            <b><a href="/register" class="text-black">Don't have and Account? <span class="text-bold text-primary">Register Now</span> </a></b>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>


    </div>
</div>

@endsection
