/**
 * Rendering a date with the current locale format.
 *
 * @param to
 * @param from
 * @returns {(function(*=, *, *): (string|*|string))|*}
 */
$.fn.dataTable.render.moment = function (to, from) {
    if (typeof from === 'undefined') {
        // https://momentjs.com/docs/#/displaying/format/
        from = 'YYYY-MM-DD HH:mm:ss'
    }

    return function (d, type, row) {
        if (d === null) {
            return '-';
        }

        var m = window.moment(d, from);
        return m.format(type === 'sort' || type === 'type' ? 'x' : to);
    };
};

/**
 * Render a date to a "from now" format.
 *
 * @param format
 * @returns {(function(*=, *, *): (string|*|string|string))|*}
 */
$.fn.dataTable.render.fromNow = function (format) {
    if (typeof format === 'undefined') {
        // https://momentjs.com/docs/#/displaying/format/
        format = 'YYYY-MM-DD HH:mm:ss'
    }

    return function (d, type, row) {
        if (d === null) {
            return '-';
        }

        var m = window.moment(d, format);
        if (type === 'sort') {
            return m.format('x');
        } else {
            return '<span title="' + m.format('LLLL') + '">' + m.fromNow() + '</span>';
        }
    };
};

$.fn.dataTable.parseDatatableFilters = function (d, instance) {
    let id = instance.sTableId;

    $('#'+id+'_wrapper .filters .dt-filter-text').each(function (i, e) {
        d.columns[$(e).data('field')].search.value = $(e).val();
    });

    $('#'+id+'_wrapper .filters select').each(function (i, e) {
        d.columns[$(e).data('field')].search.value = $(e).find(':selected').val();
    });

    $('#'+id+'_wrapper .filters .dt-filter-daterange').each(function (i, e) {
        let name = $(e).attr('name').replace('[value]', '');
        d.columns[$(e).data('field')].search.date_start = $('#'+id+'_wrapper input[name="'+name+'[start]"]').val();
        d.columns[$(e).data('field')].search.date_end = $('#'+id+'_wrapper input[name="'+name+'[end]"]').val();
    });
}

/**
 * Show filters button
 */
$(document).on('click', '.dataTables_wrapper .show-filters', function () {
    $(this).closest('.dataTables_wrapper').find('.filters').toggle();
    $(this).children('span').toggleClass('fa-caret-down fa-caret-up');
});

$(document).on('keyup change', '.dataTables_wrapper .filters input[type=text]', function () {
    let id = '#' + $(this).closest('.dataTables_wrapper').find('table').attr('id');
    $(id).DataTable().ajax.reload();
})

$(document).on('change', '.dataTables_wrapper .filters select', function () {
    let id = '#' + $(this).closest('.dataTables_wrapper').find('table').attr('id');
    $(id).DataTable().ajax.reload();
})