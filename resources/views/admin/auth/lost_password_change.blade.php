@extends('web.layouts.master')

@section('title', 'Change Password - My Daily Shop')

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/logo/'.Helper::setting()->meta_logo)}}">

@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-xl-6">
            <div class="card m-5 p-5 shadow-lg mb-5 bg-white rounded">
                <div class="login-userheading">
                    <h3 class="p-3"><b>Change Password</b> </h3>
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
                <form action="{{ route('lost_password_token_post') }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{$token}}">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">New Password</label>
                      <input name="password" type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="New Password">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                      <input type="password" name="confirmed" class="form-control" id="exampleInputPassword1" placeholder="Confirm password">
                    </div>


                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                    
                </form>
            </div>
        </div>


    </div>
</div>

@endsection
