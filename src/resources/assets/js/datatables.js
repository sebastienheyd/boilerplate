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
 * Showing autocomplete on typing in search input.
 */
$(document).on('keyup', '.dt-search-input', function (e) {
    e.preventDefault();

    let id = $(this).closest('.dt-search').data('target');
    let wrapper = id + '_wrapper';

    if ($(this).val() === '') {
        $(wrapper + ' .dt-search-autocomplete').hide();
        return;
    }

    if (e.keyCode === 13) { // Enter key
        $(wrapper + ' .dt-search-autocomplete a.hover').trigger('click');
    } else if (e.keyCode === 38) { // Arrow up
        let current = $(wrapper + ' .dt-search-autocomplete a.hover')
        let prev = current.parent().prev().find('a');
        if (prev.length === 1) {
            current.removeClass('hover');
            prev.addClass('hover');
        }
    } else if (e.keyCode === 40) { // Arrow down
        let current = $(wrapper + ' .dt-search-autocomplete a.hover')
        let next = current.parent().next().find('a');
        if (next.length === 1) {
            current.removeClass('hover');
            next.addClass('hover');
        }
    } else {
        let fields = [];
        $(wrapper + ' .dt-search-facet').each(function (i, e) {
            fields.push($(e).data('field'));
        });

        $.ajax({
            url: $(id).data('options'),
            type: 'post',
            data: {
                id: id,
                q: $(this).val(),
                already: fields.toString()
            },
            success: function (options) {
                $(wrapper + ' .dt-search-autocomplete').html(options).show();
                $(wrapper + ' .dt-search-autocomplete a:first').addClass('hover');
            }
        });
    }
}).on('keydown', '.dt-search-input', function (e) {
    let id = $(this).closest('.dt-search').data('target');
    let wrapper = id + '_wrapper';

    // Backspace
    if (e.keyCode === 8 && $(wrapper + ' .dt-search-input').val() === '') {
        $(wrapper + ' .dt-search .dt-search-facet:last .dt-search-facet-remove').trigger('click');
    }
});

/**
 * Click on autocomplete link.
 */
$(document).on('click', '.dt-search-autocomplete a', function (e) {
    e.preventDefault();

    let ul = $(this).closest('ul');
    let wrapper = $(ul.data('id')+'_wrapper');
    let input = wrapper.find('.dt-search-input');
    let field = $(this).data('option');

    $.ajax({
        url: ul.data('facet'),
        type: 'post',
        data: {
            field: field,
            value: input.val(),
        },
        success: function(facet) {
            wrapper.find('.dt-search-facets').append(facet);
            //localStorage.setItem('search-facets', $('.search-facets').html());

            input.val('');
            wrapper.find('.dt-search-autocomplete').hide();
            $(ul.data('id')).DataTable().ajax.reload();
        }
    })
});

/**
 * Adding hover class when passing mouse over autocomplete link.
 */
$(document).on('mouseover', '.dt-search-autocomplete a', function () {
    $('.dt-search-autocomplete a').removeClass('hover');
    $(this).addClass('hover')
});

/**
 * Removing search facet
 */
$(document).on('click', '.dt-search-facet-remove', function () {
    let id = $(this).closest('.dt-search').data('target');
    let el = $(this).closest('.dt-search-facet');
    el.remove();

    // localStorage.setItem('search-facets', $('.search-facets').html());
    $(id).DataTable().ajax.reload();
});