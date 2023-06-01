/** global: gpt */
var eventSource;
var content = parent.tinymce.activeEditor.selection.getContent({format : 'html'});
var prepend;

$(function() {
    if (content !== '') {
        $('#nav-gpt-rewrite').show();
        $('.original-content').val($("<textarea/>").html(content).text());
    }

    $(document).on('change', '#rewrite-type', function() {
        $('#rewrite-options').show();

        if ($(this).val() === 'translate') {
            $('#rewrite-options').hide();
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
                        growl('Error', 'error');
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
        navigator.clipboard.writeText($('#gpt-result').html()).then(function() {
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
            content: $('#gpt-result').html(),
            prepend: prepend
        }, '*');
    })
});