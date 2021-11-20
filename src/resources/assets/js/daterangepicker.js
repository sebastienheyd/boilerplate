$(document).on('click', '.clear-daterangepicker', function(e) {
    $(this).hide();
    let name = $(this).data('name');
    $('input[name="'+name+'[value]"]').data('daterangepicker').startDate = moment();
    $('input[name="'+name+'[value]"]').data('daterangepicker').endDate = moment();
    $('input[name="'+name+'[end]"]').val('');
    $('input[name="'+name+'[start]"]').val('');
    $('input[name="'+name+'[value]"]').val('');
    $('input[name="'+name+'[end]"]').trigger('change');
    $('input[name="'+name+'[start]"]').trigger('change');
    $('input[name="'+name+'[value]"]').trigger('change');
})

window.applyDateRangePicker = function(e, picker) {
    let name = $(this).attr('name').replace('[value]', '');
    $('.clear-daterangepicker[data-name="'+name+'"]').show();

    if(picker.timePicker) {
        $('input[name="'+name+'[end]"]').val(picker.endDate.format('YYYY-MM-DD HH:mm:ss')).trigger('change');
        $('input[name="'+name+'[start]"]').val(picker.startDate.format('YYYY-MM-DD HH:mm:ss')).trigger('change');
    } else {
        $('input[name="'+name+'[end]"]').val(picker.endDate.format('YYYY-MM-DD 23:59:59')).trigger('change');
        $('input[name="'+name+'[start]"]').val(picker.startDate.format('YYYY-MM-DD 00:00:00')).trigger('change');
    }

    $(this).val(picker.startDate.format(picker.locale.format) + ' - ' + picker.endDate.format(picker.locale.format)).trigger('change');
}