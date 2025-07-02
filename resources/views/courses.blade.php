@extends('layouts.app')

@section('title','Course')

@section('style')
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

<section class="hero-section text-center py-5">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Unlock Your Potential</h1>
        <p class="lead mb-4">High-quality courses taught by industry experts</p>
        <div class="d-flex justify-content-center gap-3"></div>
    </div>
</section> 
      <!-- Course Categories -->
     <div class="mb-5">
    <ul class="nav nav-pills justify-content-center mb-4">
        <li class="nav-item"><a class="nav-link active" href="#" data-filter="all">All Courses</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-filter="web">Web Development</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-filter="data">Data Science</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-filter="mobile">Mobile Development</a></li>
    </ul>
</div>
      

<!-- Courses Grid -->
<div class="row g-4">
    <!-- Web Development Bootcamp -->
    <div class="col-lg-4 col-md-6" data-category="web">
        <div class="card course-card h-100">
            <img src="https://media.istockphoto.com/id/1201246567/vector/people-and-interfaces-flat-background.jpg?s=612x612&w=0&k=20&c=TaMQ3xoynZrdwUl2mF9JhtRoNXY5I2GnAnzb5acgN3o=" class="card-img-top" alt="Web Development">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-primary">Bestseller</span>
                    <span class="text-muted"><i class="fas fa-star text-warning"></i> 4.9 (1.2k)</span>
                </div>
                <h5 class="card-title">Web Development Bootcamp</h5>
                <p class="card-text text-muted">Master HTML, CSS, JavaScript, Node.js, and more in this comprehensive course.</p>
                <ul class="list-unstyled mb-3">
                    <li><i class="fas fa-check text-success me-2"></i> 50+ hours of content</li>
                    <li><i class="fas fa-check text-success me-2"></i> 10 real-world projects</li>
                    <li><i class="fas fa-check text-success me-2"></i> Certificate of completion</li>
                </ul>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <span class="price-tag h4 mb-0">₹1,999</span>
                    @auth
                     <a href="{{ route('courses.buy', ['course' => 'web-development']) }}" class="btn btn-primary">Enroll Now</a>
                    @else
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Enroll Now</button>
                    @endauth
                </div>
            </div>
        </div>
    </div>

        <!-- Python for Data Science -->
        <div class="col-lg-4 col-md-6" data-category="data">
          <div class="card course-card h-100">
            <img src="https://media.istockphoto.com/id/1405728317/vector/global-network-connection-world-map-point-and-line-composition-concept-of-global-business.jpg?s=612x612&w=0&k=20&c=u_DZ9MwU6DFC0-TVD4qnZFmHDu2PoWYhDzppUaijv-c=" class="card-img-top" alt="Data Science">
            <div class="card-body d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge bg-success">New</span>
                <span class="text-muted"><i class="fas fa-star text-warning"></i> 4.8 (850)</span>
              </div>
              <h5 class="card-title">Python for Data Science</h5>
              <p class="card-text text-muted">Learn Python, Pandas, NumPy, Matplotlib, and Machine Learning fundamentals.</p>
              <ul class="list-unstyled mb-3">
                <li><i class="fas fa-check text-success me-2"></i> 40+ hours of content</li>
                <li><i class="fas fa-check text-success me-2"></i> Hands-on projects</li>
                <li><i class="fas fa-check text-success me-2"></i> Jupyter Notebook exercises</li>
              </ul>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <span class="price-tag h4 mb-0">₹2,999</span>
                    @auth
                     <a href="{{ route('courses.buy', ['course' => 'web-development']) }}" class="btn btn-primary">Enroll Now</a>
                    @else
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Enroll Now</button>
                    @endauth
                </div>
            </div>
          </div>
        </div>

        <!-- Full Stack JavaScript -->
        <div class="col-lg-4 col-md-6" data-category="web">
          <div class="card course-card h-100">
            <img src="https://media.istockphoto.com/id/1395523535/vector/projection-of-a-credit-card-on-background-of-a-billboard-money-and-payment-target-page-for.jpg?s=612x612&w=0&k=20&c=6KOmtlXkg8De-FAUgavU6dcm-6KQ78jQG_DzIfxSOSg=" class="card-img-top" alt="JavaScript">
            <div class="card-body d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge bg-info">Popular</span>
                <span class="text-muted"><i class="fas fa-star text-warning"></i> 4.7 (1.5k)</span>
              </div>
              <h5 class="card-title">Full Stack JavaScript</h5>
              <p class="card-text text-muted">Build modern web applications with React, Node.js, Express, and MongoDB.</p>
              <ul class="list-unstyled mb-3">
                <li><i class="fas fa-check text-success me-2"></i> 60+ hours of content</li>
                <li><i class="fas fa-check text-success me-2"></i> Full-stack projects</li>
                <li><i class="fas fa-check text-success me-2"></i> REST API development</li>
              </ul>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <span class="price-tag h4 mb-0">₹3,999</span>
                    @auth
                     <a href="{{ route('courses.buy', ['course' => 'web-development']) }}" class="btn btn-primary">Enroll Now</a>
                    @else
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Enroll Now</button>
                    @endauth
                </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Testimonials Section -->
  <section class="bg-light py-5">
    <div class="container">
      <h2 class="text-center mb-5">What Our Students Say</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="mb-3">
                <i class="fas fa-quote-left text-muted fs-1"></i>
              </div>
              <p class="card-text">"The Web Development Bootcamp helped me transition into a full-time developer role. The projects were incredibly practical."</p>
              <div class="d-flex align-items-center mt-4">
                <img src="https://randomuser.me/api/portraits/women/32.jpg" class="rounded-circle me-3" width="50" alt="Student">
                <div>
                  <h6 class="mb-0">Priya Sharma</h6>
                  <small class="text-muted">Web Developer at TechSolutions</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="mb-3">
                <i class="fas fa-quote-left text-muted fs-1"></i>
              </div>
              <p class="card-text">"The Python course gave me the skills to analyze data effectively at my job. The instructors are top-notch."</p>
              <div class="d-flex align-items-center mt-4">
                <img src="https://randomuser.me/api/portraits/men/45.jpg" class="rounded-circle me-3" width="50" alt="Student">
                <div>
                  <h6 class="mb-0">Rahul Patel</h6>
                  <small class="text-muted">Data Analyst at FinCorp</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="mb-3">
                <i class="fas fa-quote-left text-muted fs-1"></i>
              </div>
              <p class="card-text">"I built my first full-stack application after completing the JavaScript course. The curriculum is well-structured."</p>
              <div class="d-flex align-items-center mt-4">
                <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle me-3" width="50" alt="Student">
                <div>
                  <h6 class="mb-0">Ananya Gupta</h6>
                  <small class="text-muted">Freelance Developer</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>




    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>You need to be logged in to enroll in a course.</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('login.form') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register.form') }}" class="btn btn-outline-primary">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>



  </section>
@endsection