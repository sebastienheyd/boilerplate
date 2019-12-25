/** global: avatar */

$(document).on('click', '.avatar-upload', function (e) {
    e.preventDefault()
    $(this).tooltip('hide')
    $('#avatar-file').trigger('click');
})

$(document).on('change', '#avatar-file', function (e) {

    let fd = new FormData();
    fd.append('avatar', e.target.files[0]);
    $('.avatar-progress').css('display', 'flex');
    $('.avatar-buttons').hide();

    $.ajax({
        url: $('.avatar-upload').data('link'),
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        xhr: function () {
            var xhr = new window.XMLHttpRequest();

            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                    $('.avatar-percent').text(percentComplete+'%');
                }
            }, false);

            return xhr;
        },
        success: function (res) {
            $('.avatar-percent').text('0%');
            $('.avatar-progress').hide();
            $('.avatar-buttons').css('display', 'flex');
            if (res.success) {
                refreshAvatar()
                growl(avatar.locales.upload.success)
            } else {
                console.log(res.message)
                growl(avatar.locales.upload.error, 'error')
            }
        }
    });
});

$(document).on('click', '.avatar-gravatar', function (e) {
    e.preventDefault()
    $(this).tooltip('hide')

    $.ajax({
        url: $(this).data('link'),
        type: 'post',
        success: function (json) {
            if (json.success) {
                refreshAvatar()
                $('.avatar-delete').removeClass('d-none');
                growl(avatar.locales.gravatar.success)
            } else {
                growl(avatar.locales.gravatar.error)
            }
        }
    });
})

$(document).on('click', '.avatar-delete', function (e) {
    e.preventDefault()
    $(this).tooltip('hide')

    $.ajax({
        url: $(this).data('link'),
        type: 'post',
        success: function () {
            refreshAvatar();
            $('.avatar-delete').addClass('d-none');
            growl(avatar.locales.delete)
        }
    });
})

function refreshAvatar()
{
    $.ajax({
        url: avatar.url,
        type: 'get',
        async: false,
        success: function (url) {
            $('.avatar-img').attr('src', url)
        }
    });
}