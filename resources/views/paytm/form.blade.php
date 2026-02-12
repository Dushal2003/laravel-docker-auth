@extends('layouts.app') {{-- or 'layouts.app' depending on your app structure --}}
@section('title','Paytm Payment')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>Pay with Paytm (Sandbox)</h3>
            <form method="POST" action="{{ route('paytm.initiate') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Amount (INR)</label>
                    <input type="number" name="amount" class="form-control" step="0.01" min="1" required value="100">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email (optional)</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mobile (optional)</label>
                    <input type="text" name="mobile" class="form-control">
                </div>
                <button class="btn btn-primary">Pay with Paytm</button>
            </form>
        </div>
    </div>
</div>
@endsection
