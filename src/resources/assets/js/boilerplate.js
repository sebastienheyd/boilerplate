var growl = function (message, type) {
    if (typeof type === "undefined") {
        type = 'info';
    }
    $.notify({message: message}, {type: type, placement: {align: 'center'}, width: 'auto', allow_dismiss: false});
}

$('.sidebar-toggle').on('click', function (event) {
    event.preventDefault();
    if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
        sessionStorage.setItem('sidebar-toggle-collapsed', '');
    } else {
        sessionStorage.setItem('sidebar-toggle-collapsed', '1');
    }
});

(function () {
    if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
        var body = document.getElementsByTagName('body')[0];
        body.className = body.className + ' sidebar-collapse';
    }
})();
