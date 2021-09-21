window.toastr.options = {}

window.growl = (message, type) => {
    types = ['info', 'error', 'warning', 'success'];

    if (typeof type === "undefined" || !types.includes(type)) {
        type = 'info';
    }
    window.toastr[type](message);
}

function storeSetting(settingName, settingValue) {
    $.ajax({
        url: bpRoutes.settings,
        type: 'post',
        data: {name: settingName, value: settingValue},
    });
}

function toggleTinyMceSkin(skin, css)
{
    if(typeof tinymce === 'undefined' || tinymce.get().length === 0) {
        return false;
    }

    //window.removeEventListener('scroll', () => {});

    tinymce.get().forEach(e => {
        e.settings.skin = skin;
        e.settings.content_css = css;
        $('#'+e.settings.id).tinymce().destroy(false);
        $('#'+e.settings.id).tinymce(e.settings);
    })
}

$('.sidebar-toggle').on('click', e => {
    e.preventDefault();
    storeSetting('sidebar-collapsed', !$('body').hasClass('sidebar-collapse'));
})

$(() => {
    $(document).tooltip({
        container: 'body',
        selector: '[data-toggle="tooltip"]',
        delay: {"show": 500, "hide": 100},
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
    }, 1000);

    $('[data-widget="darkmode"]').on('click', function(e) {
        e.preventDefault();
        if($('body').hasClass('dark-mode')) {
            $(this).html('<i class="far fa-moon"></i>');
            $('body').removeClass('dark-mode accent-light');
            $('nav.main-header').removeClass('navbar-dark').addClass('navbar-' + $('nav.main-header').data('type'));
            storeSetting('darkmode', false);
            toggleTinyMceSkin('oxide', null);
        } else {
            $(this).html('<i class="fas fa-fw fa-sun"></i>');
            $('body').addClass('dark-mode accent-light');
            $('nav.main-header').addClass('navbar-dark');
            storeSetting('darkmode', true);
            toggleTinyMceSkin('boilerplate-dark', 'boilerplate-dark');
        }
    });
})

$('.logout').click(function(e) {
    e.preventDefault();
    bootbox.confirm($(this).attr('data-question'), res => {
        if (res === false) {
            return;
        }
        $('#logout-form').submit();
    });
});
