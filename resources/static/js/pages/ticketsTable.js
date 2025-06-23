import { initDataTable } from '../pages/datatables.js';

let currentGroupBy = 'created_at';
let ticketsTable;

function initializeTable() {
    const translations = window.dataTableTranslations;

    ticketsTable = initDataTable('#ticket_table', '/tickets', [
        { data: 'user', title: translations.headers.user, className: 'text-start group-header' },
        { data: 'title', title: translations.headers.title, className: 'text-start group-header' },
        { data: 'created_at', title: translations.headers.created_at, className: 'text-start group-header' },
        { data: 'status', title: translations.headers.status, className: 'text-start group-header' },
        { data: 'priority', title: translations.headers.priority, className: 'text-start group-header' },
        { data: 'action', title: translations.headers.action, orderable: false, searchable: false, className: 'text-center' }
    ], {
        serverSide: true,
        processing: true,

        ajax: {
           data: function(d) {
                return {
                    group_by: currentGroupBy,
                    date_from: $('#dateFrom').val(),
                    date_to: $('#dateTo').val(),
                    search: $('#searchInput').val(),
                    draw: d.draw,
                    start: d.start,
                    length: d.length,
                    order: d.order,
                    columns: d.columns
                };

            },
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
            searchPlaceholder: translations.ui.searchPlaceholder.tickets
        },

        rowGroup: {
            dataSrc: () => currentGroupBy
        },

        order: [[2, 'desc']]
    });

    $('#ticket_table thead').on('click', '.group-header', function () {
        const columnIndex = $(this).index();
        $('.group-header').removeClass('active-group');

        if (columnIndex === 0) {
            currentGroupBy = 'user';
        } else if (columnIndex === 2) {
            currentGroupBy = 'created_at';
        } else if (columnIndex === 3) {
            currentGroupBy = 'status';
        } else if (columnIndex === 4) {
            currentGroupBy = 'priority';
        }

        $(this).addClass('active-group');
        ticketsTable.destroy();
        $('#ticket_table').empty();
        initializeTable();
    });

    $('.group-header:first').addClass('active-group');
}

$(document).ready(function () {
    initializeTable();

    $('#applyFilter').on('click', function () {
        $('#validationErrors').hide().html('');
        ticketsTable.ajax.reload();
    });

    $('#resetFilter').on('click', function () {
        $('#validationErrors').hide().html('');
        $('#dateFrom').val('');
        $('#dateTo').val('');
        $('#searchInput').val('');
        ticketsTable.ajax.reload();
    });
});
