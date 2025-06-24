import { initDataTable } from '../pages/datatables.js';

let sampleTable;
let currentGroupBy = 'brand';

function initializeTable() {
    const translations = window.dataTableTranslations;

    sampleTable = initDataTable('#sample_table', '/samples', [
       { data: 'name', title: translations.headers.name, className: 'text-start group-header' },
        { data: 'brand', title: translations.headers.brand, className: 'text-start group-header' },
        { data: 'sampleClass', title: translations.headers.sampleClass, className: 'text-start group-header' },
        {
      data: 'action',
      title: translations.headers?.action ?? 'Action',
      orderable: false,
      searchable: false,
      className: 'text-center',
      render: function (data, type, row) {
        const showBtn = `
            <a href="${window.APP_BASE_URL || ''}/samples/${row.id}" class="btn btn-sm btn-outline-info me-1" title="View">
                <i class="bi bi-eye"></i>
            </a>
            `;
        return showBtn;
      }
    }
    ], {
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

        order: [[1, 'desc']]
    });

    $('#sample_table thead').on('click', '.group-header', function () {
        const columnIndex = $(this).index();
        $('.group-header').removeClass('active-group');

        if (columnIndex === 1) {
            currentGroupBy = 'brand';
        } else if (columnIndex === 2) {
            currentGroupBy = 'sampleClass';
        }

        $(this).addClass('active-group');
        sampleTable.destroy();
        $('#sample_table').empty();
        initializeTable();
    });

    $('.group-header:first').addClass('active-group');
}

$(document).ready(function () {
    initializeTable();
});
