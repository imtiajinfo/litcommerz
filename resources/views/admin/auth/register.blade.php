@extends('web.layouts.master')

@section('title', 'Register - My Daily Shop')

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/logo/'.Helper::setting()->meta_logo)}}">

    {{-- <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}"> --}}

@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-xl-6">
            <div class="card m-5 p-5 shadow-lg mb-5 bg-white rounded">
                <div class="login-userheading">
                    <h3 class="p-3"><b>Sign Up</b> </h3>
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
                <form action="{{ route('admin.register.action') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <div class="form-addons">
                            <input class="form-control" type="text" name="name" placeholder="Enter your Name">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Email <small >(Duplicate emails are not allowed)</small>
                        </label>
                        <div class="form-addons">
                            <input class="form-control" type="text" name="email" placeholder="Enter your email address">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <small >(At least 6 characters)</small></label>
                        <div class="pass-group">
                            <input class="form-control" name="password" type="password" class="pass-input" placeholder="Enter your password">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password </label>
                        <div class="pass-group">
                            <input class="form-control" name="confirmed" type="password" class="pass-input" placeholder="Enter your password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Register</button>
                    
                    <div class="mb-3">
                        <div class="mt-3">
                            <b><a href="/login" class="text-black">Already Account? <span class="text-bold text-primary">Login</span> </a></b>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>


    </div>
</div>

@endsection
