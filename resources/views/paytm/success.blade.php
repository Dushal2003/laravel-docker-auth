@extends('app')
@section('title','Payment Success')
@section('content')
<div class="container py-5">
    <div class="alert alert-success">
        <h4>Payment Successful</h4>
        <p>Order ID: {{ $payment->order_id }}</p>
        <p>Txn ID: {{ $payment->txn_id }}</p>
        <p>Amount: ₹{{ $payment->amount }}</p>
        <pre>{{ json_encode($response, JSON_PRETTY_PRINT) }}</pre>
    </div>
</div>
@endsection
