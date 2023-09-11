<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @stack('styles')
    <title>@yield('title')</title>
</head>
<body>
    <header class="shadow">
        <nav class="navbar navbar-light bg-light container">
            <div class="p-2">
              <span class="navbar-brand mb-0 h1">My Remote</span>
            </div>
        </nav>
    </header>

    <div class="content">
        @yield('content')
    </div>

    {{-- <footer>
        &copy; {{ date('Y') }} Your Website
    </footer> --}}
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/jquery-3.6.4.js')}}"></script>
    @stack('scripts')
</body>
</html>
