<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-graduation-cap me-2"></i>Dushal CTO <span class="small">Admin</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link @if(Request::routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-chart-line me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Request::routeIs('admin.users.*')) active @endif" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users me-1"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('courses') }}">
                        <i class="fas fa-book me-1"></i> Courses
                    </a>
                </li>
                <li class="nav-item d-flex align-items-center">
                    <form action="{{ route('logout') }}" method="POST" class="mb-0">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-decoration-none text-light p-0 border-0 bg-transparent">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
