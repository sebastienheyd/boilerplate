/** global: gpt */
var eventSource;

$(function() {
    $('[name="topic"]').focus();

    $(document).on('click', 'button[type="submit"]', function(e) {
        e.preventDefault();

        $.ajax({
            url: gpt.route,
            type: 'post',
            data: $('form').serialize(),
            success: function(json){
                if(json.success === false) {
                    $('#gpt-compose').html(json.html);
                    $('[name="topic"]').focus();
                } else {
                    $('#form, #buttons').hide();
                    $('#content, #stop').show();
                    $('#gpt-result').html('');
                    eventSource = new EventSource(gpt.stream + '?id=' + json.id);
                    eventSource.onmessage = function (e) {
                        if (e.data == "[DONE]") {
                            $('#stop').hide();
                            $('#buttons').show();
                            eventSource.close();
                        } else {
                            let txt = JSON.parse(e.data).choices[0].delta.content
                            if (txt !== undefined) {
                                $('#gpt-result').append(txt.replace(/(?:\r\n|\r|\n)/g, '<br>'));
                            }
                        }
                    };
                }
            },
            error: function() {
                $('#disable, #loading').hide();
                $('#gpt-form').append('<div class="alert alert-danger" id="gpterror">gpt.error</div>');
            }
        });
    })

    $(document).on('click', '#stop', function() {
        $('#stop').hide();
        $('#buttons').show();
        eventSource.close();
    })

    $(document).on('click', '#undo', function() {
        $('#form').show();
        $('#disable, #loading, #content').hide();
    })

    $(document).on('click', '#close', function() {
        window.parent.tinyMCE.activeEditor.windowManager.close();
    })

    $(document).on('click', '#confirm', function() {
        window.parent.postMessage({
            mceAction: 'confirmGPTContent',
            content: $('#gpt-result').html()
        }, '*');
    })
});