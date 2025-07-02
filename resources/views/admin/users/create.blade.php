@extends('layouts.app')

@section('title', 'Create New User')

@section('navbar')
    @include('layouts.admin_nav')
@endsection

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Add New User</h2>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" value="{{ old('name') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">User Type</label>
            <select name="user_type" class="form-select" required>
                <option value="user" {{ old('user_type') === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('user_type') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection
