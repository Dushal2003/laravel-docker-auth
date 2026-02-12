@extends('layouts.app')

@section('title', 'User Login')

@section('content')
<div class="container py-5" style="max-width: 500px;">
    {{-- Show validation error block only if no session flash --}}
    @if ($errors->any() && !session('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>There were some problems:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
   <h1 class="text-center">Login Form</h1>

    <form method="POST" action="{{ route('login') }}" class="bg-white shadow-sm p-4 rounded">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                id="password"
                name="password"
                required
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success">Login</button>
        </div>

        <div class="mt-3 text-center">
            Don't have an account? <a href="{{ route('register.form') }}">Register here</a>
        </div>
        <a href="{{ route('google.login') }}" class="btn btn-danger w-100">
    <i class="fab fa-google me-1"></i> Continue with Google
</a>


    </form>
</div>
@endsection
