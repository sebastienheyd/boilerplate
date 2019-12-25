$.fn.dataTable.render.moment = function ( to, from ) {
    if (typeof from === 'undefined') {
        // https://momentjs.com/docs/#/displaying/format/
        from = 'YYYY-MM-DD HH:mm:ss'
    }

    return function ( d, type, row ) {
        var m = window.moment(d, from);
        return m.format(type === 'sort' || type === 'type' ? 'x' : to);
    };
};

$.fn.dataTable.render.fromNow = function ( format ) {
    if (typeof format === 'undefined') {
        // https://momentjs.com/docs/#/displaying/format/
        format = 'YYYY-MM-DD HH:mm:ss'
    }

    return function ( d, type, row ) {
        var m = window.moment(d, format);
        if (type === 'sort') {
            return m.format('x');
        } else {
            return '<span title="'+m.format('LLLL')+'">'+m.fromNow()+'</span>';
        }
    };
};