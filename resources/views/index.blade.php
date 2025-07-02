@extends('layouts.app')

@section('title', 'Home - Dushal CTO')

@section('styles')
<style>
.hero-section {
    background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
    color: white;
    padding: 6rem 0;
}

.stats-section {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    color: white;
    padding: 4rem 0;
}

.feature-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    transition: transform 0.3s ease;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.feature-card:hover {
    transform: translateY(-5px);
}

.icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: #60a5fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}
</style>
@endsection

@section('content')
@include('layouts.welcome')
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">Transform Your Career with Tech Skills</h1>
        <p class="lead mb-5">Learn from industry experts and join our community of 50,000+ successful learners</p>
        <a href="#" class="btn btn-light btn-lg px-5 py-3">Explore Courses</a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-wrapper"><i class="fas fa-laptop-code text-white fs-4"></i></div>
                    <h4>Project-Based Learning</h4>
                    <p>Build real-world projects and create a portfolio that stands out.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-wrapper"><i class="fas fa-chalkboard-teacher text-white fs-4"></i></div>
                    <h4>Expert Instructors</h4>
                    <p>Learn from industry professionals with years of experience.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-wrapper"><i class="fas fa-certificate text-white fs-4"></i></div>
                    <h4>Career Support</h4>
                    <p>Get interview prep and career guidance.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="stats-section text-center">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <h2 class="display-4 fw-bold">50K+</h2><p>Students Enrolled</p>
            </div>
            <div class="col-md-3">
                <h2 class="display-4 fw-bold">500+</h2><p>Hours of Content</p>
            </div>
            <div class="col-md-3">
                <h2 class="display-4 fw-bold">95%</h2><p>Completion Rate</p>
            </div>
            <div class="col-md-3">
                <h2 class="display-4 fw-bold">4.9</h2><p>Average Rating</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Featured Courses</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card">
                    <img src="https://picsum.photos/600/400?web,development" class="card-img-top">
                    <div class="card-body">
                        <h5>Full Stack Development</h5>
                        <span class="badge bg-primary">Bestseller</span>
                        <span class="float-end text-muted">₹1,999</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://picsum.photos/600/400?data,science" class="card-img-top">
                    <div class="card-body">
                        <h5>Data Science Fundamentals</h5>
                        <span class="badge bg-success">New</span>
                        <span class="float-end text-muted">₹2,499</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://picsum.photos/600/400?mobile,app" class="card-img-top">
                    <div class="card-body">
                        <h5>Mobile Development</h5>
                        <span class="badge bg-info">Popular</span>
                        <span class="float-end text-muted">₹2,199</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="#" class="btn btn-primary btn-lg px-5">View All Courses</a>
        </div>
    </div>
</section>
@endsection
