@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            {{-- global validation or throttle errors --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4>Enter the 6-Digit Code</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('otp.verify') }}">
                        @csrf

                        {{-- keep the email hidden so controller knows which user --}}
                        <input type="hidden" name="email" value="{{ old('email', request('email')) }}">

                        <div class="mb-3">
                            <label for="otp" class="form-label">OTP</label>
                            <input  id="otp"
                                    type="text"
                                    name="otp"
                                    maxlength="6"
                                    pattern="\d{6}"
                                    class="form-control @error('otp') is-invalid @enderror"
                                    placeholder="123456"
                                    required>
                            @error('otp') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                Verify &nbsp; <i class="fas fa-check-circle"></i>
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('otp.request') }}">
                            Didn’t get the code? Send again
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
