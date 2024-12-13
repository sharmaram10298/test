@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Item Details</h1>
    <ul class="list-group">
        <li class="list-group-item"><strong>Name:</strong> {{ $item->name }}</li>
        <li class="list-group-item"><strong>Age:</strong> {{ $item->age }}</li>
        <li class="list-group-item"><strong>Gender:</strong> {{ $item->gender }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $item->email }}</li>
        <li class="list-group-item"><strong>Phone:</strong> {{ $item->phone }}</li>
        <li class="list-group-item"><strong>Address:</strong> {{ $item->address }}</li>
        <li class="list-group-item"><strong>City:</strong> {{ $item->city }}</li>
        <li class="list-group-item"><strong>State:</strong> {{ $item->state }}</li>
    </ul>
    <a href="{{ route('items.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
