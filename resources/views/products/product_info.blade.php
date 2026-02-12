@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="stylish-product-card card shadow-lg border-0 rounded-3 overflow-hidden">
                <div class="row g-0">
                    <!-- Product Image -->
                    <div class="col-md-5 d-flex align-items-center justify-content-center bg-light">
                        <img src="{{ $product->image }}" class="img-fluid rounded stylish-product-image" alt="{{ $product->title }}">
                    </div>
                    <!-- Product Details -->
                    <div class="col-md-7 p-4">
                        <h1 class="stylish-title fw-bold text-dark mb-2">{{ $product->title }}</h1>
                        <p class="text-muted mb-3 fs-5">{{ $product->category }}</p>
                        <div class="d-flex align-items-center mb-3">
                            <h3 class="text-success fw-bold me-3">₹{{ number_format($product->price) }}</h3>
                            @if($product->discount)
                                <span class="badge bg-success fs-6 px-3 py-2">{{ $product->discount }}% Off</span>
                            @endif
                        </div>
                        <p class="stylish-description text-secondary mb-4">{{ $product->description }}</p>
                        <button class="btn btn-lg btn-primary stylish-buy-btn px-4 py-2">
                            <i class="fas fa-shopping-cart me-2"></i>Buy Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection