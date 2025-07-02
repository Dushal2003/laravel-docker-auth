<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dushal CTO')</title>

    <!-- CSS 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @yield('style')
    @yield('styles')
</head>
<body>

    {{-- Use admin navbar if section is defined, otherwise default --}}
    @hasSection('navbar')
        @yield('navbar')
    @else
        @include('layouts.nav_bar') {{-- Public navbar --}}
    @endif

    @include('layouts._alerts')

    <main class="mt-0">
        @yield('content')
    </main>

    @include('layouts.footer')

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    @yield('scripts')

    <script>
        window.addEventListener('load', function () {
            const modal = document.getElementById('welcomeModal');
            if (modal) {
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            }
        });
    </script>
</body>
</html>
