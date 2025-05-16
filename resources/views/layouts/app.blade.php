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

    let title, url, icon;

    if (notification.type === 'ticket.created') {
        title = notification.title || `New Ticket #${notification.ticket_id}`;
        url = notification.url || `/tickets/${notification.ticket_id}`;
        icon = notification.icon || 'bi-ticket-detailed';
    }
    else if (notification.type === 'ticket.reply') {
        title = notification.title || `New Reply on Ticket #${notification.ticket_id}`;
        url = notification.url || `/tickets/${notification.ticket_id}`;
        icon = notification.icon || 'bi-reply';
    }
    else {
        title = notification.title || 'Notification';
        url = notification.url || '#';
        icon = notification.icon || 'bi-bell';
    }

    const li = document.createElement('li');
    li.classList.add('dropdown-item', 'notification-item');
    li.innerHTML = `
        <a href="${url}">
            <div class="notification-text ms-4">
                <p class="notification-title font-bold">${title}</p>
                <span class="notification-subtitle font-thin text-sm">just now</span>
            </div>
        </a>
    `;

    const header = dropdown.querySelector('.dropdown-header');
    if (header) {
        header.insertAdjacentElement('afterend', li);
    } else {
        dropdown.prepend(li);
    }

    const notificationItems = dropdown.querySelectorAll('.notification-item');
    const maxItems = 5;
    if (notificationItems.length > maxItems) {
        for (let i = maxItems; i < notificationItems.length; i++) {
            notificationItems[i].remove();
        }
    }

    const badge = document.querySelector('.badge-notification');
    if (badge) {
        let count = parseInt(badge.textContent) || 0;
        badge.textContent = Math.min(count + 1, 99);
        badge.classList.remove('d-none');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const userId = {{ auth()->id() }};
    const userType = @json(auth()->user()->userable_type);

    window.Echo.private(`App.Models.User.${userId}`)
        .notification((notification) => {
             const audio = new Audio('/sounds/notification.mp3');
             audio.play();
            appendNotificationToNavbar(notification);
        });

    if (userType === 'App\\Models\\Supervisor') {
        const supervisorId = {{ auth()->user()->userable_id }};

        window.Echo.private(`tickets.supervisor.${supervisorId}`)
            .listen('.ticket.created', (e) => {
                 const audio = new Audio('/sounds/notification.mp3');
                      audio.play();
                appendNotificationToNavbar({
                    ...e,
                    type: 'ticket.created'
                });
            })
            .listen('.ticket.reply', (e) => {
                 const audio = new Audio('/sounds/notification.mp3');
                audio.play();
                appendNotificationToNavbar({
                    ...e,
                    type: 'ticket.reply'
                });
            });
    }
});
</script>
@endif



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
