// Feather icons are used on some pages
// Replace() replaces [data-feather] elements with icons

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    withCredentials: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Authorization': `Bearer ${localStorage.getItem('auth_token') || ''}`
        }
    }
});



import $ from 'jquery';
window.$ = window.jQuery = $;

import 'datatables.net';
import 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';


import flatpickr from "flatpickr";
import { Arabic } from "flatpickr/dist/l10n/ar.js";

const isArabic = document.documentElement.lang === 'ar';

flatpickr("#dateFrom", {
  locale: isArabic ? Arabic : 'default',
  dateFormat: "Y-m-d",
});

flatpickr("#dateTo", {
  locale: isArabic ? Arabic : 'default',
  dateFormat: "Y-m-d",
});

import Chart from 'chart.js/auto';
window.Chart = Chart;



import PerfectScrollbar from 'perfect-scrollbar';

document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector('.sidebar-wrapper');
    if (sidebar) {
        new PerfectScrollbar(sidebar, {
            wheelSpeed: 2,
            wheelPropagation: true,
            minScrollbarLength: 20
        });
    }
});

import featherIcons from "feather-icons"
featherIcons.replace()

// Mazer internal JS. Include this in your project to get
// the sidebar running.
import "./mazer"

