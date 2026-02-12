@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Profile</h2>
    <p>Name: {{ auth()->user()->name }}</p>
    <p>Email: {{ auth()->user()->email }}</p>
</div>
@endsection
