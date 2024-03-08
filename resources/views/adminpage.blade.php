@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    {{ __('You are logged in!') }}
                    <h1>Welcome, {{ auth()->user()->name }}</h1>
                    <div class="card-body d-flex justify-content-center align-items-center flex-column">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" alt="QR Code"
                            style="height: 200px; width: 200px;">
                        <p style="padding-top:20px;">*Note: Scan the QR Code with your phone to see details. You also get details url from there if you enter that Details URL  in your browser you can also details.</p>
                        <form action="{{ route('admin.qr.code') }}" method="GET">
                            <input type="hidden" name="qr_code_data" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-primary">See Details By Click(Alternative Way)</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
