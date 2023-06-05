/** global: gpt */
import jQuery from "jquery";
window.$ = window.jQuery = jQuery;

import toastr from "toastr";
window.toastr = toastr;
window.toastr.options = {}

window.growl = (message, type) => {
    let types = ['info', 'error', 'warning', 'success'];

    if (typeof type === "undefined" || !types.includes(type)) {
        type = 'info';
    }
    window.toastr[type](message);
}

var eventSource;
var content = parent.tinymce.activeEditor.selection.getContent({format : 'html'});
var prepend;
var append;

$(function() {
    if (content !== '') {
        $('.original-content').val($("<textarea/>").html(content).text());
    }

    $(document).on('change', '#rewrite-type', function() {
        $('[data-show-when]').hide().prop('disabled', true);

        if ($(this).val() === 'translate') {
            $('[data-show-when="translate"]').prop('disabled', false).show();
        }

        if ($(this).val() === 'rewrite') {
            $('[data-show-when="rewrite"]').prop('disabled', false).show();
        }
    });

    $('[name="topic"]').focus();

    $(document).on('click', 'button[type="submit"]', function(e) {
        e.preventDefault();

        $.ajax({
            url: gpt.route,
            type: 'post',
            data: $(this).closest('form').serialize(),
            success: function(json){
                $('.error-bubble').remove();
                $('.is-invalid').removeClass('is-invalid');
                if(json.success === false) {
                    $('#'+json.tab).html(json.html);
                    $('#'+json.tab+' input:visible:first-child').focus();
                } else {
                    $('#form, #buttons').hide();
                    $('#content, #stop').show();
                    $('#gpt-result').html('');
                    prepend = json.prepend;
                    append = json.append;

                    eventSource = new EventSource(gpt.stream + '?id=' + json.id);

                    eventSource.onmessage = function (e) {
                        if (e.data == "[DONE]") {
                            $('#stop').hide();
                            $('#buttons, #copy, #confirm').show();
                            eventSource.close();
                        } else {
                            let txt = JSON.parse(e.data).choices[0].delta.content
                            if (txt !== undefined) {
                                txt = txt.replace(/(?:\r\n|\r|\n)/g, '<br>');
                                txt = txt.replace(/"/g, '')
                                $('#gpt-result').append(txt);
                            }
                        }
                    };

                    eventSource.onerror = function (e) {
                        eventSource.close();
                        growl(gpt.error, 'error');
                        $('#stop, #copy, #confirm').hide();
                        $('#buttons').show();
                    };
                }
            },
            error: function() {
                $(this).closest('form').append('<div class="alert alert-danger" id="gpterror">'+gpt.error+'</div>');
            }
        });
    })

    $(document).on('click', '#stop', function() {
        $('#stop').hide();
        $('#buttons, #copy, #confirm').show();
        eventSource.close();
    })

    $(document).on('click', '#copy', function() {
        navigator.clipboard.writeText(parseContent()).then(function() {
            growl(gpt.copy);
        }, function() {
            growl(gpt.copyerror);
        });
    })

    $(document).on('click', '#undo', function() {
        $('#form').show();
        $('#content').hide();
    })

    $(document).on('click', '#close', function() {
        window.parent.tinyMCE.activeEditor.windowManager.close();
    })

    $(document).on('click', '#confirm', function() {
        window.parent.postMessage({
            mceAction: 'confirmGPTContent',
            content: parseContent(),
            prepend: prepend,
            append: append,
        }, '*');
    })

    let parseContent = function() {
        content = '<p>' + $('#gpt-result').html() + '</p>';
        content = content.replace(/<br[^>]*>/gi, '</p><p>')
        content = content.replace(/<p><\/p>/gi, '');
        return content;
    }
});