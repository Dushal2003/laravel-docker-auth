@extends('layouts.app')

@section('title', 'Add Task')

@section('content')
    <h2>Add Task</h2>

    {{-- Only include the form once --}}
    @include('form', ['task' => null])
@endsection
