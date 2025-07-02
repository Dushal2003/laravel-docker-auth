@extends('layouts.app')



@section('navbar')
    @include('layouts.admin_nav')
@endsection

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Users</h5>
                    <h2>{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">New Users Today</h5>
                    <h2>{{ $newUsers }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Admins</h5>
                    <h2>{{ $admins }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
