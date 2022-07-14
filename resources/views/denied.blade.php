@extends('layouts.app')
@section('title') Page Not Found | 550MCh Lab @endsection
@section('content')
    <!-- 404 Start -->
    <div class="container">
        <div class="row my-3 bg-secondary align-items-center justify-content-center mx-0">
            <div class="col-md-6 text-center p-4">
                <img src="{{ asset('image/404.png') }}" class="w-100" alt="">
                <h1 class="mb-4">Page Not Found</h1>
                <p class="mb-4">We’re sorry, the page you have looked for does not exist in our website!
                    Maybe go to our home page.</p>
                <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('index') }}">Go Back To Home</a>
            </div>
        </div>
    </div>
    <!-- 404 End -->
@stop
