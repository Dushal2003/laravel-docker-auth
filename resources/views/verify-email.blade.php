@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="alert alert-{{ $status }}">
                {{ $message }}
            </div>
            <a href="{{ url('/login') }}" class="btn btn-primary mt-3">Go to Login</a>
        </div>
    </div>
</div>
@endsection
