export function initDataTable(selector, ajaxUrl, columns, customOptions = {}) {
    return $(selector).DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: ajaxUrl,
            type: "GET"
        },
        columns: columns,
        pagingType: 'simple_numbers',
        language: window.dataTableLang ?? {},
        ...customOptions
    });
}

