import { initDataTable } from '../pages/datatables.js';

const url = `/doctors/${window.doctorId}/doctors`;
let currentGroupBy = 'scheduled_at';
let doctorVisitsTable;



function initializeTable() {

 const translations = window.dataTableTranslations;

    doctorVisitsTable = initDataTable('#doctor-visits_table', url, [
        { data: 'representative', title: translations.headers.representative, className: 'text-start group-header' },
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

         language: {
            ...translations.ui,
            searchPlaceholder: translations.ui.searchPlaceholder.doctorVisits
        },

        rowGroup: {
            dataSrc: () => currentGroupBy
        },

        order: [[1, 'dsc']]
    });

    $('#doctor-visits_table thead').on('click', '.group-header', function () {
        const columnIndex = $(this).index();
        $('.group-header').removeClass('active-group');


          if (columnIndex === 0) {
            currentGroupBy = 'representative';
        } else if (columnIndex === 1) {
            currentGroupBy = 'scheduled_at';
        } else if (columnIndex === 2) {
            currentGroupBy = 'status';
        }

        $(this).addClass('active-group');
        doctorVisitsTable.destroy();
        $('#doctor-visits_table').empty();
        initializeTable();
    });

    $('.group-header:first').addClass('active-group');
}

$(document).ready(function () {
    initializeTable();

    $('#applyFilter').on('click', function () {
        $('#validationErrors').hide().html('');
       doctorVisitsTable.ajax.reload();
    });

    $('#resetFilter').on('click', function () {
        $('#validationErrors').hide().html('');
        $('#dateFrom').val('');
        $('#dateTo').val('');
        doctorVisitsTable.ajax.reload();
    });
});
