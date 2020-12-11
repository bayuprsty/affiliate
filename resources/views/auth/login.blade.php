@extends('layouts.auth')

@section('title')
    <title>Login</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-9">
            @if (session('verified'))
                <div class="col-md-12">
                    <div class="alert alert-success">
                        {{ session('verified') }}
                    </div>
                </div>
            @endif
            <div class="card-group py-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <h1>Login</h1>
                        <p class="text-muted">Sign In to your account</p>

                      	<form action="{{ route('auth.login') }}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                              
                              	<input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                    type="text" 
                                    name="username"
                                    placeholder="Username/Email Address" 
                                    value="{{ old('username') }}" 
                                    autofocus 
                                    required>
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </div>
                                <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                    type="password" 
                                    name="password"
                                    placeholder="Password" 
                                    required>
                            </div>
                            <div class="row">
                                @if (session('error'))
                                <div class="col-md-12">
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                </div>
                                @endif

                                <div class="col-6">
                                    <button class="btn btn-dark px-4">Login</button>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('forgot.password') }}" class="btn btn-link px-0" type="button">Forgot password?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card o-hidden border-0 shadow-lg my-5 bg-dark text-white">
                    <div class="card-body text-center p-5">
                        <div class="py-2">
                            <h2>Sign Up</h2>
                            <a href="{{ route('register') }}" class="btn btn-lg btn-outline-light mt-3 my-3">Register Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection