@extends('layouts.app')

@section('navbar')
    @include('layouts.admin_nav')
@endsection

@section('title', 'Edit User')

@section('content')
<div class="container mt-5">
    <h2>Edit User</h2>
    
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Role:</label>
            <select name="user_type" class="form-control">
                <option value="user" {{ $user->user_type == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->user_type == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
