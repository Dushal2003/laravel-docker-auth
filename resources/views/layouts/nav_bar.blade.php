<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
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

                {{-- Authentication Links --}}
              @auth
    <li class="nav-item d-flex align-items-center">
        <form action="{{ route('logout') }}" method="POST" class="mb-0">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-decoration-none text-light p-0 border-0 bg-transparent">
                Logout
            </button>
        </form>
    </li>
@else
    <li class="nav-item">
        <a class="nav-link @if(Request::routeIs('login.form')) active @endif" href="{{ route('login.form') }}">
            Login
        </a>
    </li>
@endauth

            </ul>
        </div>
    </div>
</nav>