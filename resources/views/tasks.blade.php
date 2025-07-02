@extends('layouts.app')

@section('title', 'Task List')

@section('content')
<h2>Stored Tasks</h2>



<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Long Description</th>
            <th>Completed</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
        <tr>
            <td><a href="{{ route('edit.task', $task->id) }}">{{ $task->id }}</a></td>
            <td>{{ $task->title }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ $task->long_description }}</td>
            <td>{{ $task->completed ? 'Yes' : 'No' }}</td>
            <td><a href="{{ route('edit.task', $task->id) }}">Edit</a></td>
            <td>
                <form action="{{ route('delete.id', $task->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


{{-- Laravel Pagination Links --}}
<div style="margin-top: 20px;">
    {{ $tasks->links() }}
</div>
@endsection
