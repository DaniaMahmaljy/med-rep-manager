<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
    dir="{{ config('local.available_locales')[app()->getLocale()]['dir'] ?? 'ltr' }}">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    @yield('stylesfirst')

    @vite(['resources/scss/app.scss', 'resources/scss/themes/dark/app-dark.scss'])

    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/favicon.png') }}" type="image/png">

    @yield('styles')
</head>

<body>
    @vite(['resources/static/js/initTheme.js'])
    <div id="app">
        <div id="sidebar">
            <x-sidebar />
        </div>
      <div id="main">
        @if (session()->has('success'))
        <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
            {{ session()->get('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-light-danger color-danger" role="alert"><i class="bi bi-exclamation-circle"></i> {{ session()->get('error') }}
        </div>
    @endif

            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>

            </header>

            @yield('content')
            @include('layouts.footer')
        </div>
    </div>

    <script src=""></script>

    @vite([
        'resources/js/app.js',
        'resources/static/js/components/dark.js'
        ])

    {{-- @env
    <script src="assets/compiled/js/app.js"></script>
    @endenv --}}

    @yield('js')
</body>

</html>
