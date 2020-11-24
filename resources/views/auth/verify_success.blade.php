@extends('layouts.auth')

@section('title')
    <title>Verify Success</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-header bg-info">
                    <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Email Verified</span>
                </div>

                <div class="card-body">
                    <fieldset>
                        <span class="text-md">Thank You for verification your email, {{ $nama_lengkap }}</span><br/>
                        <span class="text-md">Now, you can login to Affiliate System</span>
                        <br/><br/>
                        <a href="{{ route('login') }}" class="btn btn-success btn-sm">Login</a>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
