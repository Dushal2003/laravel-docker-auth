@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-md-4">
            <div class="card h-100">
                <a href="{{ route('products.show', $product->slug) }}">
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->title }}">
                </a>
                <div class="card-body">
                    <h5 class="card-title">{{ $product->title }}</h5>
                    <p class="card-text text-muted">{{ $product->category }}</p>
                    <p class="card-text">₹{{ number_format($product->price) }}</p>
                    @if($product->discount)
                        <span class="badge bg-success">{{ $product->discount }} Off</span>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary">See Info</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
