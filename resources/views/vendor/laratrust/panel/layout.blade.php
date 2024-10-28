<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="/vendor/laratrust/img/logo.png">
  <title>Laratrust - @yield('title')</title>
  <link href="{{ mix('laratrust.css', 'vendor/laratrust') }}" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body>
  <div>
    <nav class="bg-gray-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-center h-16">
          <div class="flex items-center">
            <div class="hidden md:block">
              <div class="flex items-baseline">
                <a href="{{config('laratrust.panel.go_back_route')}}" class="nav-button">← Go Back</a>
                <a
                  href="{{ route('laratrust.roles-assignment.index') }}"
                  class="ml-4 {{ request()->is('*roles-assignment*') ? 'nav-button-active' : 'nav-button' }}">
                  Roles & Permissions Assignment
                </a>
                <a
                  href="{{route('laratrust.roles.index')}}"
                  class="ml-4 {{ request()->is('*roles') ? 'nav-button-active' : 'nav-button' }}">
                  Roles
                </a>
                <a
                  href="{{ route('laratrust.permissions.index') }}"
                  class="ml-4 {{ request()->is('*permissions*') ? 'nav-button-active' : 'nav-button' }}">
                  Permissions
                </a>
              </div>
            </div>
            <div class="ml-10 flex-shrink-0">
              Logo
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white">
              <!-- Menu open: "hidden", Menu closed: "block" -->
              <svg class="block h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <!-- Menu open: "block", Menu closed: "hidden" -->
              <svg class="hidden h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </nav>

    <header class="bg-white shadow">
      <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold leading-tight text-gray-900">
          @yield('title')
        </h1>
      </div>
    </header>
    <main>
      <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
        @foreach (['error', 'warning', 'success'] as $msg)
        @if(Session::has('laratrust-' . $msg))
        <div class="alert-{{ $msg }}" role="alert">
          <p>{{ Session::get('laratrust-' . $msg) }}</p>
        </div>
        @endif
        @endforeach
        <div class="px-4 py-6 sm:px-0">
          @yield('content')
        </div>
      </div>
    </main>
  </div>
</body>
</html>