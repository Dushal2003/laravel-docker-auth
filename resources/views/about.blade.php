@extends('layouts.app')

@section('title','About us')

@section('style')
<style>
.hero-section {
    background: linear-gradient(135deg, #2563eb, #3b82f6); /* Brighter blue shades */
    color: #fff;
    padding: 6rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: none; /* Remove overlay */
}

.hero-section h1,
.hero-section p {
    position: relative;
    z-index: 1;
}

.list-group-item {
    background-color: transparent;
    border: none;
    font-weight: 500;
}
</style>
@endsection

@section('content')

<section class="hero-section">

    <div class="container py-5">
        <h1 class="display-4 fw-bold mb-4">About Dushal CTO</h1>
        <p class="lead mb-5">Empowering the next generation of developers through practical learning</p>
    </div>
</section>

<main class="container py-4">
    <div class="row g-5">
        <div class="col-md-6">
            <h3>Who We Are</h3>
            <p>Dushal CTO is a modern e-learning platform built by developers, for developers. We deliver high-quality, hands-on training in web development, Python, and full stack technologies.</p>
        </div>
        <div class="col-md-6">
            <h3>Our Mission</h3>
            <p>We aim to bridge the gap between learning and doing, helping learners become confident professionals with real-world skills.</p>
        </div>
    </div>

    <div class="mt-5">
        <h3>Why Choose Us?</h3>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">✔ Real industry projects and certifications</li>
            <li class="list-group-item">✔ Lifetime access to all content</li>
            <li class="list-group-item">✔ Supportive community and expert guidance</li>
        </ul>
    </div>
</main>

@endsection
