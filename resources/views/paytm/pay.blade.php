@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Pay with Paytm</h2>
    <a href="{{ url('/paytm-payment') }}" class="btn btn-primary">Pay ₹10</a>
</div>
@endsection
