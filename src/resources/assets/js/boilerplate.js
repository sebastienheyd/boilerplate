window.toastr.options = {}

window.growl = function (message, type) {
    types = ['info', 'error', 'warning', 'success'];

    if (typeof type === "undefined" || !types.includes(type)) {
        type = 'info';
    }
    window.toastr[type](message);
}

$('.sidebar-toggle').on('click', function (event) {
    event.preventDefault();
    if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
        sessionStorage.setItem('sidebar-toggle-collapsed', '');
    } else {
        sessionStorage.setItem('sidebar-toggle-collapsed', '1');
    }
});

$(function () {
    $(document).tooltip({
        container: 'body',
        selector: '[data-toggle="tooltip"]',
        delay: { "show": 500, "hide": 100 },
        html: true,
        trigger: 'hover',
    })

    setInterval(function () {
        var timestamp = Math.round(+new Date() / 1000);
        if (Math.round(+new Date() / 1000) === (session.expire - 10)) {
            session.expire = timestamp + session.lifetime;
            $.ajax({
                url: session.keepalive,
                type: 'post',
                data: {id: session.id}
            })
        }
    }, 1000)
})

$('.logout').click(function (e) {
    e.preventDefault();
    if (bootbox.confirm($(this).attr('data-question'), function (e) {
        if (e === false) {
            return;
        }
        $('#logout-form').submit();
    })) {
    }
});

(function () {
    if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
        var body = document.getElementsByTagName('body')[0];
        body.className = body.className + ' sidebar-collapse';
    }
})();
