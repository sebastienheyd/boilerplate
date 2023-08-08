let dialog;
let params = JSON.parse(document.currentScript.getAttribute('data-params'));

let widgetTools =
'<div class="dashboard-widget-tools d-flex flex-column justify-content-between">' +
'    <div class="d-flex justify-content-between">' +
'        <i class="fa fa-solid fa-square-plus" data-action="add-before"></i>' +
'        <i class="fa fa-solid fa-square-plus" data-action="add-after"></i>' +
'    </div>' +
'    <div class="d-flex justify-content-center">' +
'        <i class="fa-solid fa-trash-can" data-action="remove"></i>' +
'    </div>' +
'    <div class="d-flex justify-content-between align-items-center">' +
'        <span>' +
'            <i class="fa-solid fa-square-caret-left" data-action="move-left"></i>' +
'            <i class="fa-solid fa-square-caret-right" data-action="move-right"></i>' +
'        </span>' +
'        <span><i class="fa-solid fa-share fa-rotate-180" data-action="new-line"></i></span>' +
'    </div>' +
'</div>'

let newLine =
'<div class="d-line-break"></div>'

// Enabling dashboard edition
let enableDashboardEdition = function() {
    $('#toggle-dashboard').data('status', 'unlocked').removeClass('btn-outline-secondary').addClass('btn-danger').html('<i class="fa-solid fa-lock-open fa-fw"></i>')
    $('#dashboard-widgets').append('<div class="dashboard-buttons d-flex flex-column justify-content-between">' +
        '<button class="btn btn-outline-secondary btn-sm" data-action="select-widget"><i class="fa-solid fa-plus fa-fw"></i></button>' +
        '<button class="btn btn-outline-secondary btn-sm d-none" data-action="dashboard-add-line"><i class="fa-solid fa-fw fa-rotate-180 fa-share"></i></i></button>' +
        '</div>')
}

// Disabling dashboard edition
let disableDashboard = function() {
    $('#toggle-dashboard').data('status', 'locked').removeClass('btn-danger').addClass('btn-outline-secondary').html('<i class="fa-solid fa-lock fa-fw"></i>');

}

// Toggle dashboard edition
$('#toggle-dashboard').on('click', function() {
    if ($(this).data('status') === 'locked') {
        enableDashboardEdition();
    } else {
        disableDashboard();
    }
})

// Enable edition by default if enabled in configuration file
$(function () {
    if($('#toggle-dashboard').data('status') === 'unlocked') {
        enableDashboardEdition();
    }
})

// Show widget selection modal
$(document).on('click', '[data-action="select-widget"]', function() {
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

// Remove widget
$(document).on('click', '.dashboard-widget-tools [data-action="remove"]', function () {
    $(this).closest('.dashboard-widget').remove();
})

// Add a new line after current widget
$(document).on('click', '.dashboard-widget-tools [data-action="new-line"]', function () {
    $(this).closest('.dashboard-widget').after(newLine)
})

// Add a widget at the end of the line
$(document).on('click', '[data-action="add-widget"]', function () {
    let currentLine = $('[data-active-line]');

    $.ajax({
        url: params.load_widget,
        type: 'post',
        data: {slug: $(this).attr('data-slug')},
        success: function (html) {
            $('#dashboard-widgets').find('.dashboard-buttons').before(html);
            $('.dashboard-widget-tools').remove();
            $('.dashboard-widget').append(widgetTools);
            dialog.modal('hide');
            $('[data-action="dashboard-add-line"]').removeClass('d-none')
        }
    })
})

$(document).on('click', '[data-action="dashboard-add-line"]', function() {
    $('.dashboard-buttons').before(newLine)
    $('[data-action="dashboard-add-line"]').addClass('d-none')
})