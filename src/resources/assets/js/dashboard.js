let dialog;
let params = JSON.parse(document.currentScript.getAttribute('data-params'));

$('#add-a-widget').on('click', function() {
    $.ajax({
        url: params.modal_route,
        type: 'get',
        success: function(html){
            dialog = bootbox.dialog({
                message: html,
                size: 'large'
            })
        }
    })
})

$(document).on('click', '[data-action="add-widget"]', function(e) {
    dialog.modal('hide');

    $.ajax({
        url: params.load_widget,
        type: 'post',
        data: { slug: $(this).attr('data-slug') },
        success: function(html){
            $('#dashboard-widgets').append(html);
        }
    })

})