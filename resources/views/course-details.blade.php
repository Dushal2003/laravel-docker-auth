@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-5">
            <img src="{{ $course->image }}" class="img-fluid rounded" alt="{{ $course->title }}">
        </div>
        <div class="col-md-7">
            <h1>{{ $course->title }}</h1>
            <span class="badge bg-success">Bestseller</span>
            <p class="text-muted"><i class="fas fa-star text-warning"></i> {{ $course->rating }} ({{ $course->reviews_count }})</p>
            <h3 class="text-success">₹{{ number_format($course->price) }}</h3>
            <p>{{ $course->description }}</p>
            <ul>
                <li>{{ $course->hours }}+ hours of content</li>
                <li>{{ $course->projects }} real-world projects</li>
                @if($course->certificate)
                    <li>Certificate of completion</li>
                @endif
            </ul>
            @auth
                <a href="{{ route('courses.buy', $course->slug) }}" class="btn btn-primary btn-lg">Buy Now</a>
            @else
                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#loginModal">Buy Now</button>
            @endauth
        </div>
    </div>
</div>
@endsection
