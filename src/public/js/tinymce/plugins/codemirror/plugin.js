tinymce.PluginManager.add('codemirror', function (editor, url) {
    function showSourceEditor() {
        editor.focus()
        editor.selection.collapse(true)

        // Insert caret marker
        editor.selection.setContent('<span style="display: none;" class="CmCaReT">&#x0;</span>')

        var buttonsConfig = [
            {
                type: 'custom',
                text: 'Ok',
                name: 'codemirrorOk',
                primary: true
            },
            {
                type: 'cancel',
                text: 'Cancel',
                name: 'codemirrorCancel'
            }
        ];

        var config = {
            title: 'Source code',
            url: url + '/source.html',
            width: Math.round(window.innerWidth * 0.8),
            height: Math.round(window.innerHeight * 0.8),
            resizable: true,
            maximizable: true,
            fullScreen: false,
            saveCursorPosition: true,
            buttons: buttonsConfig
        }

        config.onAction = function (dialogApi, actionData) {
            if (actionData.name === 'codemirrorOk') {
                var doc = document.querySelectorAll('.tox-dialog__body-iframe iframe')[0]
                doc.contentWindow.submit()

                // Callback
                if(typeof editor.settings.code_change_callback === 'function') {
                    editor.settings.code_change_callback(editor);
                }

                win.close()
            }
        }

        var win = editor.windowManager.openUrl(config)
    }

    editor.ui.registry.addButton('code', {
        icon: 'sourcecode',
        title: 'Source code',
        tooltip: 'Source code',
        onAction: showSourceEditor
    })

    editor.ui.registry.addMenuItem('code', {
        icon: 'sourcecode',
        text: 'Source code',
        onAction: showSourceEditor,
        context: 'tools'
    })
})
