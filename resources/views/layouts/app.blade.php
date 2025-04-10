<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @yield('stylesfirst')

    @vite(['resources/scss/app.scss', 'resources/scss/themes/dark/app-dark.scss'])

    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/favicon.png') }}" type="image/png">

    @yield('styles')
</head>

<body>
    @vite('resources/static/js/initTheme.js')
    <div id="app">
        <div id="sidebar">
            <x-sidebar />
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            @yield('content')
            @include('layouts.footer')
        </div>
    </div>

    @vite([
        'resources/static/js/initTheme.js',
        'resources/static/js/components/dark.js',
        'resources/js/app.js'
    ])

    {{-- @env
    <script src="assets/compiled/js/app.js"></script>
    @endenv --}}

    @yield('js')
</body>

</html>
