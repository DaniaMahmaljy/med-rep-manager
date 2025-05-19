import { initDataTable } from '../pages/datatables.js';

let representativesTable;
let supervisorsList = window.supervisors || [];
let municipalsList = window.municipals || [];

const isSupervisor = window.currentUser?.isSupervisor;
let currentGroupBy = isSupervisor ? 'residingMunicipal' : 'supervisor';

function initializeTable() {
  const translations = window.dataTableTranslations || {};
  window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

  const columns = [
    { data: 'name', title: translations.headers?.name ?? 'Name', className: 'text-start group-header' },

   ...(!isSupervisor ? [{
    data: null,
    title: translations.headers?.supervisor ?? 'Supervisor',
    className: 'text-start group-header',
    render: function (data, type, row) {
        const fullName = row?.supervisor?.user?.full_name ||
                        `${row?.supervisor?.user?.first_name ?? ''} ${row?.supervisor?.user?.last_name ?? ''}`.trim() ||
                        '—';
        return fullName;
    }
    }] : []),

    { data: 'residingMunicipal', title: translations.headers?.residingMunicipal ?? 'Residing Municipal', className: 'text-start group-header' },

    {
      data: 'workingMunicipals',
      title: translations.headers?.workingMunicipals ?? 'Working Municipals',
      className: 'text-start',
      render: function (data) {
        return Array.isArray(data) ? data.join(', ') : (data ?? '');
      }
    },

    {
      data: 'action',
      title: translations.headers?.action ?? 'Action',
      orderable: false,
      searchable: false,
      className: 'text-center',
      render: function (data, type, row) {
        const showBtn = `
          <a href="/representatives/${row.id}" class="btn btn-sm btn-outline-info me-1" title="View">
            <i class="bi bi-eye"></i>
          </a>
        `;

        if (isSupervisor) return showBtn;

        const supervisorId = row.supervisor?.id ?? '';
        const workingMunicipalsIds = JSON.stringify(row.workingMunicipalsIds ?? []);

        const editBtn = `
          <button
            class="btn btn-sm btn-outline-primary btn-edit"
            title="Edit"
            data-id="${row.id}"
            data-name="${row.name}"
            data-supervisor-id="${supervisorId}"
            data-working-municipals='${workingMunicipalsIds}'
          >
            <i class="bi bi-pencil-square"></i>
          </button>
        `;

        return showBtn + editBtn;
      }
    }
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
      searchPlaceholder: translations.ui?.searchPlaceholder?.reps ?? 'Search representatives'
    },
    rowGroup: {
      dataSrc: () => currentGroupBy
    }
  });

  $('#representative_table thead').on('click', '.group-header', function () {
    const columnIndex = $(this).index();
    $('.group-header').removeClass('active-group');

    if (!isSupervisor) {
      if (columnIndex === 1) {
        currentGroupBy = 'supervisor';
      } else if (columnIndex === 2) {
        currentGroupBy = 'residingMunicipal';
      }
    } else {
      if (columnIndex === 1) {
        currentGroupBy = 'residingMunicipal';
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

  const editModalEl = document.getElementById('editRepModal');
  const editModal = new bootstrap.Modal(editModalEl);

  function populateSelectOptions() {
    let supervisorOptions = '<option value="">-- Select Supervisor --</option>';
    supervisorsList.forEach(sup => {
      const fullName = sup.user?.full_name ?? `${sup.user?.first_name ?? ''} ${sup.user?.last_name ?? ''}`;
      supervisorOptions += `<option value="${sup.id}">${fullName.trim()}</option>`;
    });
    $('#supervisorSelect').html(supervisorOptions);

    let municipalOptions = '';
    municipalsList.forEach(mun => {
      municipalOptions += `<option value="${mun.id}">${mun.name}</option>`;
    });
    $('#workingMunicipalsSelect').html(municipalOptions);
  }

  populateSelectOptions();

  $('#representative_table').on('click', '.btn-edit', function () {
    const repId = $(this).data('id');
    const repName = $(this).data('name');
    const supervisorId = $(this).data('supervisor-id');
    const workingMunicipals = $(this).data('working-municipals');

    $('#repId').val(repId);
    $('#modalRepName').text(repName);
    $('#supervisorSelect').val(supervisorId);
    $('#workingMunicipalsSelect').val(workingMunicipals).trigger('change');

    editModal.show();
  });

  $('#editRepForm').on('submit', function (e) {
    e.preventDefault();

    const repId = $('#repId').val();
    const supervisorId = $('#supervisorSelect').val();
    const workingMunicipals = $('#workingMunicipalsSelect').val() || [];

    $.ajax({
      url: `/representatives/${repId}/update-assignments`,
      method: 'POST',
      data: {
        supervisor_id: supervisorId,
        working_municipals: workingMunicipals,
        _token: window.csrfToken
      },
      success: function () {
        editModal.hide();
        representativesTable.ajax.reload(null, false);
        alert('Representative updated successfully');
      },
      error: function () {
        alert('Failed to update representative. Please try again.');
      }
    });
  });
});
