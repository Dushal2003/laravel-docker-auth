@extends('layouts.app')

@section('title', 'User Registration')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            {{-- ✅ Flash success --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong><br>
                    Please check your mailbox and click the link to verify your email.
                    <a href="{{ route('login.form') }}" class="btn btn-sm btn-outline-success mt-2">
                        Go to Login
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ❌ Global error (register / mail / any other) --}}
            @if($errors->any())
                @foreach (['register', 'mail'] as $key)
                    @if($errors->has($key))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $errors->first($key) }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                @endforeach
            @endif

            {{-- Registration Form --}}
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h4>User Registration</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="name">Full Name</label>
                            <input  id="name" type="text" name="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" required autofocus>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Email address</label>
                            <input  id="email" type="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror" required>
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input  id="password" type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                            <input  id="password_confirmation" type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror" required>
                            @error('password_confirmation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>

                        <div class="text-center mt-3">
                            Already have an account?
                            <a href="{{ route('login.form') }}">Login here</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
