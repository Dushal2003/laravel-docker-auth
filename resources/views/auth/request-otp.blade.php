@extends('layouts.app')

@section('title', 'Request Login OTP')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            {{-- success flash from OtpController --}}
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- global validation / throttle errors --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Request One-Time Password</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('otp.request') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input  id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    required
                                    autofocus>
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Send OTP
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


