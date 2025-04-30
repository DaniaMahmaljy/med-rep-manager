import { initDataTable } from '../pages/datatables.js';


let representativesTable;
const isSupervisor = window.currentUser?.isSupervisor;
let currentGroupBy = isSupervisor ? 'municipal' : 'supervisor';




function initializeTable() {
    const translations = window.dataTableTranslations;
    const isSupervisor = window.currentUser?.isSupervisor;

    const columns = [
        { data: 'name', title: translations.headers.name, className: 'text-start group-header' },
        ...(!isSupervisor ? [{ data: 'supervisor', title: translations.headers.supervisor, className: 'text-start group-header' }] : []),
        { data: 'municipal', title: translations.headers.municipal, className: 'text-start group-header' },
        { data: 'action', title: translations.headers.action, orderable: false, searchable: false, className: 'text-center' }
    ];

    representativesTable = initDataTable('#representative_table', '/representatives', columns, {
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
            searchPlaceholder: translations.ui.searchPlaceholder.reps
        },

        rowGroup: {
            dataSrc: () => currentGroupBy
        },
    });

    $('#representative_table thead').on('click', '.group-header', function () {
        const columnIndex = $(this).index();
        $('.group-header').removeClass('active-group');

        if (!isSupervisor) {
            if (columnIndex === 1) {
                currentGroupBy = 'supervisor';
            } else if (columnIndex === 2) {
                currentGroupBy = 'municipal';
            }
        } else {
            if (columnIndex === 1) {
                currentGroupBy = 'municipal';
            }
        }

        $(this).addClass('active-group');
        representativesTable.destroy();
        $('#representative_table').empty();
        initializeTable();
    });

    $('.group-header:first').addClass('active-group');
}

$(document).ready(function () {
    initializeTable();
});
