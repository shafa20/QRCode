@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('User Details') }}</div>
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text">Email: {{ $user->email }}</p>
            <p class="card-text">Password: {{ $user->password }}</p>
            <a href="{{ route('user.download.pdf', $user->id) }}" class="btn btn-primary">Download</a>
        </div>
    </div>
</div>
@endsection
