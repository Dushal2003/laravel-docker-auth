@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        @foreach($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->title }}">
                    <div class="card-body">
                        <h6>
                            <span class="badge bg-success">Bestseller</span>
                            <span class="text-warning">★ {{ $course->rating }} ({{ $course->reviews_count }} reviews)</span>
                        </h6>
                        <h5 class="card-title">{{ $course->title }}</h5>
                        <p class="text-muted">{{ Str::limit($course->description, 80) }}</p>
                        <ul class="list-unstyled">
                            <li>✔ {{ $course->hours }}+ hours of content</li>
                            <li>✔ {{ $course->projects }} real-world projects</li>
                            @if($course->certificate)
                                <li>✔ Certificate of completion</li>
                            @endif
                        </ul>
                        <h5 class="mt-3">₹{{ number_format($course->price) }}</h5>
                        <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-primary w-100">Enroll Now</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
