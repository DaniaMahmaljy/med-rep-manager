import { initDataTable } from '../pages/datatables.js';

let doctorTable;
let supervisorsList = window.supervisors || [];
const isSupervisor = window.currentUser?.isSupervisor ?? false;

let currentGroupBy = 'municipal';

function initializeTable() {
  const translations = window.dataTableTranslations || {};
  window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

  const columns = [
    { data: 'name', title: translations.headers?.name ?? 'Name', className: 'text-start group-header' },
    { data: 'specialty', title: translations.headers?.specialty ?? 'Specialty', className: 'text-start group-header' },
    { data: 'municipal', title: translations.headers?.municipal ?? 'Municipal', className: 'text-start group-header' },

    ...(!isSupervisor ? [{
      data: 'supervisors',
      title: translations.headers?.supervisor ?? 'Supervisors',
      orderable: false,
      className: 'text-start',
      render: function (data) {
        return Array.isArray(data) ? data.join(', ') : (data ?? '—');
      }
    }] : []),

    {
      data: 'action',
      title: translations.headers?.action ?? 'Action',
      orderable: false,
      searchable: false,
      className: 'text-center',
      render: function (data, type, row) {
        const showBtn = `
            <a href="${window.APP_BASE_URL || ''}/doctors/${row.id}" class="btn btn-sm btn-outline-info me-1" title="View">
                <i class="bi bi-eye"></i>
            </a>
            `;

        if (isSupervisor) return showBtn;

        const supervisorIds = JSON.stringify(row.supervisorIds ?? []);

        const editBtn = `
          <button
            class="btn btn-sm btn-outline-primary btn-edit"
            title="Edit"
            data-id="${row.id}"
            data-name="${row.name}"
            data-supervisors='${supervisorIds}'
          >
            <i class="bi bi-pencil-square"></i>
          </button>
        `;

        return showBtn + editBtn;
      }
    }
  ];

  doctorTable = initDataTable('#doctor_table', '/doctors', columns, {
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
      searchPlaceholder: translations.ui?.searchPlaceholder?.doctors ?? 'Search doctors'
    },
    rowGroup: {
      dataSrc: () => currentGroupBy
    }
  });

  $('#doctor_table thead').on('click', '.group-header', function () {
    const columnIndex = $(this).index();
    $('.group-header').removeClass('active-group');

    if (columnIndex === 1) currentGroupBy = 'specialty';
    if (columnIndex === 2) currentGroupBy = 'municipal';

    $(this).addClass('active-group');
    doctorTable.destroy();
    $('#doctor_table').empty();
    initializeTable();
  });

  $('.group-header:first').addClass('active-group');
}

$(document).ready(function () {
  initializeTable();

  const editModalEl = document.getElementById('editDoctorModal');
  const editModal = new bootstrap.Modal(editModalEl);

  function populateSupervisorOptions() {
    let options = '';
    supervisorsList.forEach(sup => {
      const fullName = sup.user?.full_name ?? `${sup.user?.first_name ?? ''} ${sup.user?.last_name ?? ''}`.trim();
      options += `<option value="${sup.id}">${fullName}</option>`;
    });
    $('#doctorSupervisorSelect').html(options);
  }

  populateSupervisorOptions();

  $('#doctor_table').on('click', '.btn-edit', function () {
    const doctorId = $(this).data('id');
    const doctorName = $(this).data('name');
    let supervisorIds = [];

    try {
      supervisorIds = JSON.parse($(this).attr('data-supervisors'));
    } catch (e) {
      supervisorIds = [];
    }

    $('#doctorId').val(doctorId);
    $('#modalDoctorName').text(doctorName);
    $('#doctorSupervisorSelect').val(supervisorIds).trigger('change');

    editModal.show();
  });

  $('#editDoctorForm').on('submit', function (e) {
    e.preventDefault();

    const doctorId = $('#doctorId').val();
    const supervisorIds = $('#doctorSupervisorSelect').val() || [];

    $.ajax({
      url: `${window.APP_BASE_URL || ''}/doctors/${doctorId}/assign-supervisors`,
      method: 'POST',
      data: {
        supervisor_ids: supervisorIds,
        _token: window.csrfToken
      },
      success: function () {
        editModal.hide();
        doctorTable.ajax.reload(null, false);
        alert('Doctor updated successfully');
      },
      error: function () {
        alert('Failed to update doctor. Please try again.');
      }
    });
  });
});
