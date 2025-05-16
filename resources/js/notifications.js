function appendNotificationToNavbar(notification) {
    const dropdown = document.querySelector('.notification-dropdown');
    if (!dropdown) return;

    const notificationHtml = `
    <li class="dropdown-item notification-item">
        <a href="${notification.url}">
            <div class="notification-icon bg-success">
                <i class="bi ${notification.icon}"></i>
            </div>
            <div class="notification-text ms-4">
                <p class="notification-title font-bold">
                    New Ticket: ${notification.title}
                </p>
                <span class="text-xs text-muted">${notification.time}</span>
            </div>
        </a>
    </li>`;

    dropdown.insertAdjacentHTML('afterbegin', notificationHtml);

    const badge = document.querySelector('.badge-notification');
    if (badge) {
        const count = parseInt(badge.textContent || '0') + 1;
        badge.textContent = count;
        badge.classList.remove('d-none');
    }

    try {
        new Audio('/sounds/notification.mp3').play().catch(e => console.log('Sound play failed:', e));
    } catch (e) {
        console.log('Notification sound error:', e);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const userId = document.head.querySelector('meta[name="user-id"]')?.content;
    const userType = document.head.querySelector('meta[name="user-type"]')?.content;

    if (!window.Echo) {
        console.error('Echo not initialized');
        return;
    }

    window.Echo.connector.pusher.connection.bind('state_change', (state) => {
        console.log('Pusher state:', state.current);
    });

    window.Echo.connector.pusher.connection.bind('error', (err) => {
        console.error('Pusher error:', err);
    });

    if (userType === 'App\\Models\\Supervisor' && userId) {
        window.Echo.private(`tickets.supervisor.${userId}`)
            .listen('.ticket.created', (notification) => {
                console.log('Supervisor notification:', notification);
                appendNotificationToNavbar(notification);
            });
    }

    if (userId) {
        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                console.log('User notification:', notification);
                if (notification.type === 'ticket.created') {
                    appendNotificationToNavbar(notification);
                }
            });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.content);
    console.log('Auth Token:', localStorage.getItem('auth_token'));

    window.Echo.connector.pusher.connection.bind('error', function(err) {
        console.error('Pusher error details:', JSON.stringify(err, null, 2));
    });
});
