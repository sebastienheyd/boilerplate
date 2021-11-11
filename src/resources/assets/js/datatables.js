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

$.fn.dataTable.initSearch = function (id) {
    $('#' + id + '_wrapper .row:first div:last').addClass('d-flex align-items-center justify-content-end').html(
        '<span class="mr-2">Rechercher : </span>' +
        '<div class="dt-search" data-target="#' + id + '">' +
        '<div class="dt-search-autocomplete" style="display: none"></div>' +
        '<div class="dt-search-facets d-flex"></div>' +
        '<input class="dt-search-input flex-grow-1" type="text" autocomplete="off" value="">' +
        '</div>'
    );
}

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
    if (e.keyCode === 8 && $(id + ' .dt-search-input').val() === '') {
        $(wrapper + ' .dt-search-facet:last .dt-search-facet-remove').trigger('click');
    }
});

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
            //pTable.ajax.reload();
        }
    })
});

// Hover filtre
$(document).on('mouseover', '.dt-search-autocomplete a', function () {
    $('.dt-search-autocomplete a').removeClass('hover');
    $(this).addClass('hover')
});

// Remove search facet
$(document).on('click', '.dt-search-facet-remove', function () {
    let el = $(this).closest('.dt-search-facet');

    el.remove();
    // localStorage.setItem('search-facets', $('.search-facets').html());
    // pTable.ajax.reload();
});
