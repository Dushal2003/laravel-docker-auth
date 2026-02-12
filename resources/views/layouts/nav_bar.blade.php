{{-- Enhanced Navbar Blade Template --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top stylish-navbar">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('home') }}">
            <i class="fas fa-graduation-cap me-2"></i>Dushal CTO
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                {{-- Home Link --}}
                <li class="nav-item">
                    <a class="nav-link @if(Request::routeIs('home')) active @endif" href="{{ route('home') }}" @if(Request::routeIs('home')) aria-current="page" @endif>Home</a>
                </li>
                {{-- About Us Link --}}
                <li class="nav-item">
                    <a class="nav-link @if(Request::routeIs('about.us')) active @endif" href="{{ route('about.us') }}" @if(Request::routeIs('about.us')) aria-current="page" @endif>About Us</a>
                </li>
                {{-- Courses Link --}}
                <li class="nav-item">
                    <a class="nav-link @if(Request::routeIs('courses')) active @endif" href="{{ route('courses') }}" @if(Request::routeIs('courses')) aria-current="page" @endif>Courses</a>
                </li>
                {{-- Products Link --}}
                <li class="nav-item">
                    <a class="nav-link @if(Request::routeIs('products.index')) active @endif" href="{{ route('products.index') }}" @if(Request::routeIs('products.index')) aria-current="page" @endif>Products</a>
                </li>

                {{-- Authentication Links --}}
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name ?? 'User' }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item btn btn-link text-decoration-none p-0 border-0 bg-transparent">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
              @else
    <li class="nav-item">
        <a class="nav-link @if(Request::routeIs('login.form')) active @endif"
           href="{{ route('login.form') }}">
            <i class="fas fa-sign-in-alt me-1"></i>Login
        </a>
    </li>

    <li class="nav-item ms-2">
        <a class="btn btn-outline-light btn-sm mt-1"
           href="{{ route('google.login') }}">
            <i class="fab fa-google me-1"></i> Google
        </a>
    </li>
@endauth

            </ul>
        </div>
    </div>
</nav>