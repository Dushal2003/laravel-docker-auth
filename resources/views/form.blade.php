@extends('layouts.app')

@section('title', isset($task) ? 'Edit Task' : 'Add Task')

{{-- ✅ Move styles to the correct section --}}
@section('styles')
    <style> 
        .error-message {
            color: red;
            font-size: 0.8rem;
        }
    </style>
@endsection

@section('content')
    <h2>{{ isset($task) ? 'Edit Task' : 'Add Task' }}</h2>

    @if(session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ isset($task) ? route('update.task', $task->id) : route('add.task') }}">
        @csrf
        @if(isset($task))
            @method('PUT')
        @endif

        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $task->title ?? '') }}">
        @error('title')
            <p class="error-message">{{ $message }}</p>
        @enderror
        <br>

        <label for="description">Description</label>
        <textarea name="description" id="description">{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
            <p class="error-message">{{ $message }}</p>
        @enderror
        <br>

        <label for="long_description">Long Description</label>
        <textarea name="long_description" id="long_description">{{ old('long_description', $task->long_description ?? '') }}</textarea>
        @error('long_description')
            <p class="error-message">{{ $message }}</p>
        @enderror
        <br>

        <button type="submit">{{ isset($task) ? 'Update' : 'Create' }}</button>
        <a href="{{ route('tasks.list') }}">Cancel</a>
    </form>
@endsection
