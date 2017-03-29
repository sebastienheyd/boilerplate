function growl(message, type) {
    if(typeof type === "undefined") type = 'info';
    $.notify({message: message}, { type: type, placement : { align : 'center'}, width: 'auto', allow_dismiss: false});
}