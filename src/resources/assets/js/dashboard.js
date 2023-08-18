let dialog;
let editDialog;
let params = JSON.parse(document.currentScript.getAttribute('data-params'));

let buttons =
    '<div class="dashboard-buttons d-flex flex-column justify-content-between">' +
    '<button class="btn btn-outline-secondary btn-sm mb-2" data-action="select-widget"><i class="fa-solid fa-plus fa-fw"></i></button>' +
    '<button class="btn btn-outline-secondary btn-sm" data-action="dashboard-add-line"><i class="fa-solid fa-fw fa-rotate-180 fa-share"></i></i></button>' +
    '</div>'

let widgetTools =
    '<div class="dashboard-widget-tools d-flex flex-column justify-content-between">' +
    '<div class="d-flex justify-content-between">' +
    '<i class="fa fa-solid fa-square-plus" data-action="add-before"></i>' +
    '<i class="fa fa-solid fa-square-plus" data-action="add-after"></i>' +
    '</div>' +
    '<div class="d-flex justify-content-center">' +
    '<i class="fa-solid fa-wrench mr-3 d-none" data-action="settings"></i>' +
    '<i class="fa-solid fa-trash-can" data-action="remove"></i>' +
    '</div>' +
    '<div class="d-flex justify-content-between align-items-center">' +
    '<span>' +
    '<i class="fa-solid fa-square-caret-left" data-action="move-left"></i>&nbsp;' +
    '<i class="fa-solid fa-square-caret-right" data-action="move-right"></i>' +
    '</span>' +
    '<span>' +
    '<i class="fa-solid fa-share fa-rotate-180" data-action="new-line"></i>' +
    '</span>' +
    '</div>' +
    '</div>'

let newLineTools =
    '<div class="dashboard-widget-tools d-flex justify-content-center">' +
    '<i class="fa-solid fa-trash-can" data-action="line-remove"></i>' +
    '</div>'

let newLine = '<div class="d-line-break line-edit">' + newLineTools + '</div>'

let placeholder = '<div id="placeholder" class="d-none"></div'

let modal = function () {
    let widgets = [];
    $('[data-widget-name]').each((i, e) => widgets.push($(e).data('widget-name')))

    $.ajax({
        url: params.modal_route,
        type: 'post',
        data: {widgets: widgets},
        success: function (html) {
            dialog = bootbox.dialog({
                message: html,
                size: 'large',
                onHide: function () {
                    $('#placeholder').remove();
                }
            })
        }
    })
}

// Enabling dashboard edition
let enableDashboardEdition = function () {
    // Toggle lock icon
    $('#toggle-dashboard').data('status', 'unlocked').removeClass('btn-outline-secondary').addClass('btn-danger').html('<i class="fa-solid fa-lock-open fa-fw"></i>')

    // Add buttons at the end
    $('#dashboard-widgets').append(buttons)

    // Add edit button to lines
    $('.d-line-break').addClass('line-edit').html(newLineTools);

    // Add widget tools to all widgets
    $('.dashboard-widget').prepend(widgetTools);

    // Remove add new line button to widgets preceding a new line
    $('.d-line-break').prev('.dashboard-widget').find('[data-action="new-line"]').remove()

    // Remove buttons for the last widget
    $('.dashboard-buttons').prev('.dashboard-widget').find('[data-action="new-line"],[data-action="move-right"],[data-action="add-after"]').remove()

    // No widgets : cannot add a new line
    if ($('.dashboard-widget').length === 0) {
        $('[data-action="dashboard-add-line"]').addClass('d-none')
    }

    // Cannot add a line if the last item is a new line
    if ($('.dashboard-buttons').prev().hasClass('d-line-break')) {
        $('.dashboard-buttons [data-action="dashboard-add-line"]').remove()
    }

    // No move left for the first widget
    $('#dashboard-widgets .dashboard-widget:first-child').find('[data-action="move-left"]').remove()

    // No move right for the first child if the next item is a new line
    if ($('#dashboard-widgets .dashboard-widget:first-child').next().hasClass('d-line-break')) {
        $('#dashboard-widgets .dashboard-widget:first-child').find('[data-action="move-right"]').remove()
    }

    // Remove empty line if it is the first element
    if ($('#dashboard-widgets div:first-child').hasClass('d-line-break')) {
        $('#dashboard-widgets div:first-child').remove()
    }

    $('#dashboard-widgets .dashboard-widget[data-widget-edit="yes"]').find('[data-action="settings"]').removeClass('d-none')
}

// Disabling dashboard edition
let disableDashboardEdition = function () {
    $('#toggle-dashboard').data('status', 'locked').removeClass('btn-danger').addClass('btn-outline-secondary').html('<i class="fa-solid fa-lock fa-fw"></i>');
    $('.dashboard-widget-tools').remove();
    $('.d-line-break').removeClass('line-edit');
    $('.dashboard-buttons').remove()
}

let saveWidgets = function () {
    let widgets = []

    $('#dashboard-widgets > div.dashboard-widget, #dashboard-widgets > div.d-line-break').each(function (i, e) {
        let name = $(e).data('widget-name');

        if (name !== undefined) {
            let widgetParams = $(e).data('widget-parameters');
            let widget = {[name]: widgetParams ? JSON.parse(widgetParams) : {}};

            widgets.push(widget);
        } else {
            widgets.push({'line-break': {}});
        }
    });

    $.ajax({
        url: params.save_widgets,
        type: 'post',
        data: {widgets: JSON.stringify(widgets)}
    })
}

let refreshDashboardEdition = function () {
    disableDashboardEdition()
    enableDashboardEdition()
    saveWidgets()
}

// Toggle dashboard edition
$('#toggle-dashboard').on('click', function () {
    if ($(this).data('status') === 'locked') {
        enableDashboardEdition();
    } else {
        disableDashboardEdition();
    }
})

// Enable edition by default if enabled in configuration file
$(function () {
    if ($('#toggle-dashboard').data('status') === 'unlocked') {
        enableDashboardEdition();
    }
})

// Add widget before buttons
$(document).on('click', '[data-action="select-widget"]', function () {
    $('.dashboard-buttons').before(placeholder)
    modal()
})

// Add widget after current widget
$(document).on('click', '[data-action="add-after"]', function () {
    $(this).closest('.dashboard-widget').after(placeholder)
    modal()
})

// Add widget before current widget
$(document).on('click', '[data-action="add-before"]', function () {
    $(this).closest('.dashboard-widget').before(placeholder)
    modal()
})

// Add widget before current widget
$(document).on('click', '.dashboard-widget-tools [data-action="move-right"]', function () {
    let currentWidget = $(this).closest('.dashboard-widget');
    currentWidget.next().after(currentWidget)
    refreshDashboardEdition()
})

// Add widget before current widget
$(document).on('click', '.dashboard-widget-tools [data-action="move-left"]', function () {
    let currentWidget = $(this).closest('.dashboard-widget');
    currentWidget.prev().before(currentWidget)
    refreshDashboardEdition()
})

// Add a widget by replacing the placeholder
$(document).on('click', '[data-action="add-widget"]', function () {
    $.ajax({
        url: params.load_widget,
        type: 'post',
        data: {slug: $(this).attr('data-slug')},
        success: function (html) {
            $('#placeholder').replaceWith(html)
            refreshDashboardEdition()
            dialog.modal('hide')
        }
    })
})

$(document).on('click', '[data-action="settings"]', function() {
    $.ajax({
        url: params.edit_widget,
        type: 'post',
        data: {slug: $(this).closest('.dashboard-widget').attr('data-widget-name')},
        success: function (html) {
            editDialog = bootbox.dialog({
                message: html,
                size: 'large',
                closeButton: false,
            })
        }
    })
})

$(document).on('click', '[data-action="update-widget"]', function (e) {
    e.preventDefault();
    e.stopPropagation();

    $.ajax({
        url: params.update_widget,
        type: 'post',
        data: $(this).closest('form').serialize(),
        success: function () {

        }
    })
})
$(document).on('click', '[data-action="undo-update"]', function () {
    editDialog.modal('hide')
})

// Remove widget
$(document).on('click', '.dashboard-widget-tools [data-action="remove"]', function () {
    $(this).closest('.dashboard-widget').remove()
    refreshDashboardEdition()
})

$(document).on('click', '[data-action=remove-widget]', function () {
    $('[data-widget-name="' + $(this).data('slug') + '"]').remove()
    refreshDashboardEdition()
    dialog.modal('hide');
})

// Add a new line after current widget
$(document).on('click', '.dashboard-widget-tools [data-action="new-line"]', function () {
    $(this).closest('.dashboard-widget').after(newLine)
    refreshDashboardEdition()
})

// Add a line at the end
$(document).on('click', '[data-action="dashboard-add-line"]', function () {
    $('.dashboard-buttons').before(newLine)
    refreshDashboardEdition()
})

// Remove an empty line
$(document).on('click', '[data-action="line-remove"]', function () {
    $(this).closest('.d-line-break').remove()
    refreshDashboardEdition()
})

