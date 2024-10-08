@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Welcome To') }} Difference-Shading System</div>

                <div class="card-body text-center">                    
                    <h3>
                    @guest
                        @if (Route::has('login'))
                        <a href="{{route('login')}}" class="btn btn-outline-secondary">Login</a>
                        @endif | 
                        @if (Route::has('register'))
                        <a href="{{route('register')}}" class="btn btn-outline-secondary">Register</a></h3>
                        @endif
                    @endguest
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection