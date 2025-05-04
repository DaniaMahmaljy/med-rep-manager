import { initDataTable } from '../pages/datatables.js';

const url = `/representatives/${window.representativeId}/visits`;
let currentGroupBy = 'scheduled_at';
let repVisitsTable;


function initializeTable() {

 const translations = window.dataTableTranslations;

    repVisitsTable = initDataTable('#rep-visits_table', url, [
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

         language: {
            ...translations.ui,
            searchPlaceholder: translations.ui.searchPlaceholder.repsVisits
        },

        rowGroup: {
            dataSrc: () => currentGroupBy
        },

        order: [[1, 'dsc']]
    });

    $('#rep-visits_table thead').on('click', '.group-header', function () {
        const columnIndex = $(this).index();
        $('.group-header').removeClass('active-group');


          if (columnIndex === 0) {
            currentGroupBy = 'doctor';
        } else if (columnIndex === 1) {
            currentGroupBy = 'scheduled_at';
        } else if (columnIndex === 2) {
            currentGroupBy = 'status';
        }

        $(this).addClass('active-group');
        repVisitsTable.destroy();
        $('#rep-visits_table').empty();
        initializeTable();
    });

    $('.group-header:first').addClass('active-group');
}

$(document).ready(function () {
    initializeTable();

    $('#applyFilter').on('click', function () {
        $('#validationErrors').hide().html('');
        repVisitsTable.ajax.reload();
    });

    $('#resetFilter').on('click', function () {
        $('#validationErrors').hide().html('');
        $('#dateFrom').val('');
        $('#dateTo').val('');
        repVisitsTable.ajax.reload();
    });
});
