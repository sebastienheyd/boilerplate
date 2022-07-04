window.toastr.options = {}

window.growl = (message, type) => {
    types = ['info', 'error', 'warning', 'success'];

    if (typeof type === "undefined" || !types.includes(type)) {
        type = 'info';
    }
    window.toastr[type](message);
}

window.intervals = [];
window.loadedAssets = [];

window.registerAsset = function(name, callback) {
    if(! loadedAssets.includes(name)) {
        loadedAssets.push(name);
        if (typeof callback === 'function') {
            callback()
        }
    }
}

window.loadScript = function(src, callback) {
    if(loadedAssets.includes(src)) {
        return;
    }

    if (document.querySelector('script[src="' + src + '"]')) {
        registerAsset(src, callback);
        return;
    }

    if(! loadedAssets.includes(src)) {
        let script = document.createElement('script');
        script.onload = () => {
            registerAsset(src, callback);
        };
        script.src = src;
        document.body.appendChild(script);
    }
}

window.loadStylesheet = function(src, callback) {
    if(loadedAssets.includes(src)) {
        return;
    }

    if(document.querySelector('link[rel="stylesheet"][href="'+src+'"]')) {
        registerAsset(src, callback);
        return;
    }

    let link = document.createElement('link');
    link.onload = () => {
        registerAsset(src, callback);
    };
    link.href = src;
    link.rel = 'stylesheet';
    document.querySelector('title').appendChild(link);
}

window.whenAssetIsLoaded = function(src, callback) {
    let uid = getIntervalUid();
    intervals[uid] = setInterval(function() {
        if(loadedAssets.includes(src)){
            clearInterval(intervals[uid]);
            callback();
        }
    });
}

window.whenIsLoaded = function(src, callback) {
    return window.whenAssetIsLoaded(src, callback);
}

window.getIntervalUid = function() {
    return String.fromCharCode(Math.floor(Math.random() * 11)) + Math.floor(Math.random() * 1000000);
}

$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
        e.stopImmediatePropagation();
    }
});

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

    let editors = [];
    tinymce.editors.forEach((e, i) => {
        if($('#'+e.settings.id).length === 1) {
            e.settings.skin = skin;
            e.settings.content_css = css;
            editors.push(e.settings);
        }
    });

    tinymce.remove();
    editors.forEach((e) => {
        $('#'+e.id).tinymce(e);
    });
}

$(() => {
    $(document).tooltip({
        container: 'body',
        selector: '[data-toggle="tooltip"]',
        delay: {"show": 500, "hide": 100},
        html: true,
        trigger: 'hover',
    })

    if(typeof session !== 'undefined') {
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
    }

    $('[data-widget="darkmode"]').on('click', function(e) {
        e.preventDefault();
        if($('body').hasClass('dark-mode')) {
            $(this).html('<i class="far fa-fw fa-moon"></i>');
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

    $('.sidebar-toggle').on('click', function(e) {
        e.preventDefault();
        storeSetting('sidebar-collapsed', !$('body').hasClass('sidebar-collapse'));
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

    $('#impersonate-user').on('select2:select', function() {
        $.ajax({
            url: $(this).data('route'),
            type: 'post',
            data: {id:$(this).val()},
            success: function(){
                window.location.reload();
            }
        });
    }).on('select2:clear', function() {
        $.ajax({
            url: $(this).data('clear'),
            type: 'get',
            success: function(){
                window.location.reload();
            }
        });
    });

    $('[data-toggle=password]').on('click', function(e) {
        e.preventDefault();
        $(this).children().toggleClass('fa-eye fa-eye-slash');
        let p = $(this).closest('.input-group').find('input');
        p.attr('type', p.attr('type') === 'text' ? 'password' : 'text');
    });
})

$(document).on('keyup', '.input-clearable input', function() {
    $(this).parent().find('.fa').hide();

    if ($(this).val() !== '') {
        $(this).parent().find('.fa').show();
    }
});

$(document).on('click', '.input-clearable .fa', function() {
    let input = $(this).parent().find('input');
    input.val('').trigger('keyup');
});