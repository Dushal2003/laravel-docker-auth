@extends('app')
@section('title','Payment Failed')
@section('content')
<div class="container py-5">
    <div class="alert alert-danger">
        <h4>Payment Failed</h4>
        @if(isset($message)) <p>{{ $message }}</p> @endif
        <p>Order ID: {{ $payment->order_id }}</p>
        <p>Status: {{ $payment->status }}</p>
        <pre>{{ json_encode($response, JSON_PRETTY_PRINT) }}</pre>
    </div>
</div>
@endsection
