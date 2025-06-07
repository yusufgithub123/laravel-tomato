<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="user-authenticated" content="{{ Auth::check() ? 'true' : 'false' }}">
@if(Auth::check())
    <meta name="user-id" content="{{ Auth::id() }}">
    <meta name="user-name" content="{{ Auth::user()->name }}">
@endif

    <title>@yield('title', 'LeafGuard Tomato')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    @include('layouts.header')
    
    <main class="main-content">
        @yield('content')
    </main>
    
    @include('layouts.footer')
    
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>