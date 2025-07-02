{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin Dashboard')

{{-- Extra page–specific CSS ------------------------------------------------ --}}
@section('style')
<style>
    /* Simple “card“ look for the KPI tiles */
    .kpi-card {
        border-radius: .75rem;
        transition: transform .15s ease-in-out;
    }
    .kpi-card:hover { transform: translateY(-2px); }

    /* Icon helpers */
    .kpi-icon { font-size: 2.5rem; line-height: 1; }
</style>
@endsection

{{-- Main content ----------------------------------------------------------- --}}
@section('content')
<div class="container py-5">
    <h1 class="mb-4 fw-semibold">Welcome back, {{ session('username') }} 👋</h1>

    {{-- Quick-stats tiles --------------------------------------------------- --}}
    <div class="row g-4 mb-5">
        @php
            // Replace with real numbers in your controller
            $stats = [
                ['label' => 'Total Users',        'value' => 1280, 'icon' => 'fa-users',       'bg' => 'primary'],
                ['label' => 'New Orders',         'value' => 57,   'icon' => 'fa-bag-shopping','bg' => 'success'],
                ['label' => 'Open Support Tickets','value' => 8,   'icon' => 'fa-life-ring',   'bg' => 'warning'],
            ];
        @endphp

        @foreach ($stats as $tile)
            <div class="col-md-4">
                <div class="card shadow-sm kpi-card h-100">
                    <div class="card-body text-center">
                        <i class="fa-solid {{ $tile['icon'] }} text-{{ $tile['bg'] }} kpi-icon mb-3"></i>
                        <h2 class="fw-bold">{{ $tile['value'] }}</h2>
                        <p class="text-muted mb-0">{{ $tile['label'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Two-column section -------------------------------------------------- --}}
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-transparent fw-semibold">
                    Latest Users
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Loop recent users here --}}
                            @forelse ($recentUsers ?? [] as $u)
                                <tr>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $u->created_at->format('d-M-Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted">No data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-transparent fw-semibold">
                    Quick Actions
                </div>
                <div class="card-body d-grid gap-3">
                    <a href="{{ route('users.index') }}"
                       class="btn btn-outline-primary w-100">
                        <i class="fa-solid fa-user-plus me-2"></i>Manage Users
                    </a>
                    <a href="{{ route('orders.index') }}"
                       class="btn btn-outline-success w-100">
                        <i class="fa-solid fa-boxes-stacked me-2"></i>View Orders
                    </a>
                    <a href="{{ route('settings.index') }}"
                       class="btn btn-outline-secondary w-100">
                        <i class="fa-solid fa-gear me-2"></i>Site Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
