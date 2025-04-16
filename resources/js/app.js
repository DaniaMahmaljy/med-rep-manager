// Feather icons are used on some pages
// Replace() replaces [data-feather] elements with icons

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

