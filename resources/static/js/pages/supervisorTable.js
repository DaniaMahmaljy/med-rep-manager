import { initDataTable } from '../pages/datatables.js';


let supervisorTable;




function initializeTable() {
    const translations = window.dataTableTranslations;

    const columns = [
        { data: 'name', title: translations.headers.name, className: 'text-start group-header' },
        { data: 'username', title: translations.headers.username, className: 'text-start group-header' },
        { data: 'city', title: translations.headers.city, className: 'text-start group-header' },
    ];

    supervisorTable = initDataTable('#supervisor_table', '/supervisors', columns, {
        ajax: {
            error: function (xhr) {
                $('#validationErrors').hide().empty();
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    let messages = '';
                    const errors = xhr.responseJSON.errors;
                    for (const key in errors) {
                        messages += `<div>${errors[key][0]}</div>`;
                    }
                    $('#validationErrors').html(messages).show();
                }
            }
        },

        language: {
            ...translations.ui,
            searchPlaceholder: translations.ui.searchPlaceholder.search
        },

        rowGroup: {
            dataSrc: () => currentGroupBy
        },
    });
}

$(document).ready(function () {
    initializeTable();
});
