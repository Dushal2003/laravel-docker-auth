@extends('layouts.app')

@section('title','Users')

@section('navbar')
    @include('layouts.admin_nav')
@endsection

@section('content')
<div class="container py-4">
    <h2 class="mb-3">Users</h2>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">
        + New User
    </a>

    {{-- 🔍 Search & Sort --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <input  type="text"
                    name="q"
                    value="{{ $search ?? '' }}"
                    placeholder="Search name or email"
                    class="form-control">
        </div>

        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="desc" @selected(($sort ?? 'desc') === 'desc')>Newest first</option>
                <option value="asc"  @selected(($sort ?? 'desc') === 'asc')>Oldest first</option>
            </select>
        </div>

        <div class="col-md-2 d-grid">
            <button class="btn btn-secondary">Apply</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th style="width:120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>
                    <span class="badge bg-{{ $u->user_type==='admin' ? 'success':'secondary' }}">
                        {{ ucfirst($u->user_type) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.users.edit',$u) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="{{ route('admin.users.destroy',$u) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this user?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Del</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted">No users found.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{-- pagination keeps ?q= & ?sort= parameters thanks to ->appends() --}}
    {{ $users->links() }}
</div>
@endsection
