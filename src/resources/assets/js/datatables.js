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

/**
 * Parse all filters data
 *
 * @param d
 * @param instance
 */
$.fn.dataTable.parseDatatableFilters = function (d, instance) {
    let id = instance.sTableId;

    $('#' + id + '_wrapper .filters .dt-filter-text').each(function (i, e) {
        d.columns[$(e).data('field')].search.value = $(e).val();
    });

    $('#' + id + '_wrapper .dt-filter-select').each(function (i, e) {
        d.columns[$(e).data('field')].search.value = $(e).find(':selected').val();
    });

    $('#' + id + '_wrapper .dt-filter-daterange').each(function (i, e) {
        let name = $(e).attr('name').replace('[value]', '');
        let start = $('#' + id + '_wrapper input[name="' + name + '[start]"]').val();
        let end = $('#' + id + '_wrapper input[name="' + name + '[end]"]').val();
        d.columns[$(e).data('field')].search.value = '';
        if (start !== '' && end !== '') {
            d.columns[$(e).data('field')].search.value = start + '|' + end;
        }
    });
}

/**
 * Save state of all filters
 *
 * @param instance
 * @param d
 */
$.fn.dataTable.saveFiltersState = function (instance, d) {
    let id = instance.sTableId;

    $('#' + id + '_wrapper .filters .dt-filter-text').each(function (i, e) {
        d.columns[$(e).data('field')].search.search = $(e).val();
    });

    $('#' + id + '_wrapper .filters select').each(function (i, e) {
        d.columns[$(e).data('field')].search.search = $(e).find(':selected').val();
    });

    $('#' + id + '_wrapper .filters .dt-filter-daterange').each(function (i, e) {
        let name = $(e).attr('name').replace('[value]', '');
        let start = $('#' + id + '_wrapper input[name="' + name + '[start]"]').val();
        let end = $('#' + id + '_wrapper input[name="' + name + '[end]"]').val();
        d.columns[$(e).data('field')].search.search = '';
        if (start !== '' && end !== '') {
            d.columns[$(e).data('field')].search.search = start + '|' + end;
        }
    });
}

/**
 * Load and set filters values from saved ones by stateSave.
 *
 * @param instance
 * @param d
 */
$.fn.dataTable.loadFiltersState = function(instance, d) {
    let id = instance.sTableId;
    let openFilters = false;

    $(d.columns).each(function(i, e) {
        if(e.search.search === '') {
            return;
        }

        let el = $('#'+id+' [data-field='+i+']');

        if(el.hasClass('dt-filter-daterange')) {
            let dates = e.search.search.split('|');
            $('#'+id+' [name="filter['+i+'][start]"]').val(dates[0]);
            $('#'+id+' [name="filter['+i+'][end]"]').val(dates[1]);

            whenAssetIsLoaded('daterangepicker', function() {
                el.parent().find('.clear-daterangepicker').show();
                let start = moment($('#'+id+' [name="filter['+i+'][start]"]').val());
                let end = moment($('#'+id+' [name="filter['+i+'][end]"]').val());
                let d = el.data('daterangepicker');
                el.val(start.format(d.locale.format)+d.locale.separator+end.format(d.locale.format));
                d.setStartDate(start);
                d.setEndDate(end);
            })
        }

        if(el.hasClass('dt-filter-select')) {
            whenAssetIsLoaded('select2', function() {
                el.val(e.search.search).trigger('change');
            });
        }

        if(el.hasClass('dt-filter-text')) {
            el.val(e.search.search);
        }

        openFilters = true
    });

    if(openFilters) {
        whenAssetIsLoaded(id, function() {
            $('#'+id+'_wrapper .show-filters').trigger('click');
        })
    }
}

/**
 * Show filters button
 */
$(document).on('click', '.dataTables_wrapper .show-filters', function () {
    $(this).closest('.dataTables_wrapper').find('.filters').toggle();
    $(this).children('span').toggleClass('fa-caret-down fa-caret-up');
});

$(document).on('keyup', '.dataTables_wrapper .dt-filter-text', function () {
    let id = '#' + $(this).closest('.dataTables_wrapper').find('table').attr('id');
    $(id).DataTable().ajax.reload();
})

$(document).on('change', '.dataTables_wrapper .dt-filter-daterange', function () {
    let id = '#' + $(this).closest('.dataTables_wrapper').find('table').attr('id');
    $(id).DataTable().ajax.reload();
})

$(document).on('change', '.dataTables_wrapper .dt-filter-select', function () {
    let id = '#' + $(this).closest('.dataTables_wrapper').find('table').attr('id');
    $(id).DataTable().ajax.reload();
})