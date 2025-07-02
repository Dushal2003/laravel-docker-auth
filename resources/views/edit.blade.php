@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <h2>Edit Task</h2>

    {{-- Pass the $task correctly --}}
    @include('form', ['task' => $task])
@endsection
