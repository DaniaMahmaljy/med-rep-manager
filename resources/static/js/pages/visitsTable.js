import { initDataTable } from '../pages/datatables.js';


let currentGroupBy = 'representative';
let visitsTable;

// $.fn.dataTable.ext.errMode = 'none';

function initializeTable() {

 const translations = window.dataTableTranslations;

    visitsTable = initDataTable('#visit_table', '/visits', [
        { data: 'representative', title: translations.headers.representative, className: 'text-start group-header' },
        { data: 'doctor', title: translations.headers.doctor, className: 'text-start group-header' },
        { data: 'scheduled_at', title: translations.headers.scheduled_at, className: 'text-start group-header' },
        { data: 'status', title: translations.headers.status, className: 'text-start group-header'},
        { data: 'action', title: translations.headers.action, orderable: false, searchable: false, className: 'text-center' }
    ],

    {
        ajax: {
            data: function (d) {
                d.group_by = currentGroupBy;
                d.date_from = $('#dateFrom').val();
                d.date_to = $('#dateTo').val();
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

        language: translations.ui,

        rowGroup: {
            dataSrc: () => currentGroupBy
        },

        order: [[2, 'dsc']]
    });

    $('#visit_table thead').on('click', '.group-header', function () {
        const columnIndex = $(this).index();
        $('.group-header').removeClass('active-group');

        if (columnIndex === 0) {
            currentGroupBy = 'representative';
        } else if (columnIndex === 1) {
            currentGroupBy = 'doctor';
        } else if (columnIndex === 2) {
            currentGroupBy = 'scheduled_at';
        } else if (columnIndex === 3) {
            currentGroupBy = 'status';
        }

        $(this).addClass('active-group');
        visitsTable.destroy();
        $('#visit_table').empty();
        initializeTable();
    });

    $('.group-header:first').addClass('active-group');
}

$(document).ready(function () {
    initializeTable();

    $('#applyFilter').on('click', function () {
        $('#validationErrors').hide().html('');
        visitsTable.ajax.reload();
    });

    $('#resetFilter').on('click', function () {
        $('#validationErrors').hide().html('');
        $('#dateFrom').val('');
        $('#dateTo').val('');
        visitsTable.ajax.reload();
    });
});
