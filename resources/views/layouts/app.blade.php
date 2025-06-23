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

    @yield('styles')
</head>

<body>
    <audio id="notificationSound" src="{{ asset('sounds/notification.mp3') }}" preload="auto"></audio>

    @vite(['resources/static/js/initTheme.js'])
    <div id="app">
        <div id="sidebar">
            <x-sidebar />
        </div>
      <div id="main" class="layout-navbar">

                @include('layouts.navbar')
            @if (session()->has('success'))
            <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
                {{ session()->get('success') }}
            </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-light-danger color-danger" role="alert"><i class="bi bi-exclamation-circle"></i> {{ session()->get('error') }}
                </div>
            @endif


            <div id="main-content">
            @yield('content')
            </div>

            @include('layouts.footer')
        </div>
    </div>

@if(auth()->check())
<script>

function appendNotificationToNavbar(notification) {
    const dropdown = document.querySelector('.notification-dropdown');
    if (!dropdown) return;
    let title, url, type;


    if (notification.type === 'ticket.created') {
        type = notification.view_type;
        title = notification.title ||  `New Ticket #${notification.ticket_id}`;
        url = notification.url || `tickets/${notification.ticket_id}`;
    }
    else if (notification.type === 'ticket.reply') {
        type = notification.view_type;
        title = notification.title || `New Reply on Ticket #${notification.ticket_id}`;
        url = notification.url || `/tickets/${notification.ticket_id}`;
    }
    else {
        type = notification.view_type || 'New';
        title = notification.title || 'Notification';
        url = notification.url || '#';
    }

    if (notification.id && notification.url) {
        url = `/notifications/read/${notification.id}`;
    } else {
        url = notification.url || '#';
    }

    const li = document.createElement('li');
    li.classList.add('dropdown-item', 'notification-item');
    li.innerHTML = `
        <a href="${url}">
            <div class="notification-text ms-4">
                <p class="notification-title font-bold">${type}: ${title}</p>
                <span class="notification-subtitle font-thin text-sm">just now</span>
            </div>
        </a>
    `;

   const maxItems = 5;
    const notificationItems = dropdown.querySelectorAll('.notification-item');

    if (notificationItems.length >= maxItems) {
        notificationItems[notificationItems.length - 1].remove();
    }

    const header = dropdown.querySelector('.dropdown-header');
    if (header) {
        header.insertAdjacentElement('afterend', li);
    } else {
        dropdown.prepend(li);
    }


    const badge = document.querySelector('.badge-notification');
    if (badge) {
        let count = parseInt(badge.textContent) || 0;
        badge.textContent = Math.min(count + 1, 99);
        badge.classList.remove('d-none');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const user = @json(auth()->user());
    if (!user) return;

    const playSound = () => new Audio('/sounds/notification.mp3').play();

    window.Echo.private(`tickets.${user.id}`)
        .listen('.ticket.created', e => {
            playSound();
            appendNotificationToNavbar(e);
        })
        .listen('.ticket.reply', e => {
            playSound();
            appendNotificationToNavbar(e);
        });
});
</script>
@endif



    @vite([
        'resources/static/js/components/dark.js'
        ])

        @env('local', 'development')
        @vite(['resources/js/app.js'])
        @else
            @vite(['public/build/assets/app.js'])
        @endenv

    @yield('js')
</body>

</html>
