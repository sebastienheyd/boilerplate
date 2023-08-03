let dialog;
let params = JSON.parse(document.currentScript.getAttribute('data-params'));

let enableDashboardEdition = function() {
    $('#toggle-dashboard').data('status', 'unlocked').html('<i class="fa-solid fa-lock-open fa-fw"></i>')

    $('#dashboard-widgets .row[data-line]').each(function(i, e) {
        $(e).append('<div class="add-widget"><button class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-plus fa-fw"></i></button></div>')
    })
}

let disableDashboard = function() {
    $('#toggle-dashboard').data('status', 'locked').html('<i class="fa-solid fa-lock fa-fw"></i>');
    $('.add-widget').remove();
}

$('#toggle-dashboard').on('click', function() {
    if ($(this).data('status') === 'locked') {
        enableDashboardEdition();
    } else {
        disableDashboard();
    }
})

$(function () {
    if($('#toggle-dashboard').data('status') === 'unlocked') {
        enableDashboardEdition();
    }
})

$(document).on('click', '.add-widget button', function() {
    let line = $(this).closest('[data-line]');
    $.ajax({
        url: params.modal_route,
        type: 'get',
        success: function(html){
            line.attr('data-active-line', 1);
            dialog = bootbox.dialog({
                message: html,
                size: 'large',
                onHide: function () {
                    line.removeAttr('data-active-line');
                }
            })
        }
    })
})

$(document).on('click', '[data-action="add-widget"]', function(e) {
     $.ajax({
        url: params.load_widget,
        type: 'post',
        data: { slug: $(this).attr('data-slug') },
        success: function(html){
            $('[data-active-line]').find('.add-widget').before(html);
            dialog.modal('hide');
        }
    })
})