<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script> -->
    <!-- Fonts -->
     @stack('styles')
    <style>
        /* Styling for the navigation bar items */
        .navbar-nav .nav-item {
            position: relative;
        }

        /* Background color for normal state */
        .navbar-nav .nav-link {
            background-color: #fff;
            /* Light gray background */
            color: #000;
            /* Text color */
            padding: 5px 5px;
            border-radius: 10px;
            margin: 0 5px;
            transition: background-color 0.3s ease, color 0.3s ease;

        }

        /* Hover effect */
        .navbar-nav .nav-link:hover {
            background-color: #007bff; 
            /* Blue background on hover */
            color: #fff;
            /* White text on hover */
            text-decoration: solid;
        }

        /* Additional styling for active/current link */
        .navbar-nav .nav-link.active {
            background-color: #007bff;
            /* Blue for active link */
            color: #fff !important;
            /* White text for active link */
        } 
          
    </style>
    <!-- Scripts -->       
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])    
    <link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet">
</head>

<body>
    <div id="app" class="fs-6 text">
        
        <nav class="navbar navbar-expand-md  shadow-sm" role="navigation" style="background-color: #000; padding: 5px 0;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                   <img src="{{asset('logo.jpg') }}" width="100" height="35">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{route('home')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('newjob') ? 'active' : '' }}" href="{{route('newjob')}}">Add New Jobcard</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ Route::is('joblist') ? 'active' : '' }}" href="{{route('joblist')}}">Job list</a>                                                            
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                            <a href="{{route('login')}}" class="btn btn-outline-primary">Login here</a>
                        @endif
                        @else
                        
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   
    @stack('scripts')
</body>

</html>