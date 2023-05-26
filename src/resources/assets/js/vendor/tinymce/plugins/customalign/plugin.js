(function () {
    'use strict';

    var global = tinymce.util.Tools.resolve('tinymce.PluginManager');

    var register = function (editor) {

        editor.ui.registry.addButton('customalignleft', {
            icon: 'align-left',
            onAction: function () {
                if(editor.selection.getNode().nodeName == 'IMG') {
                    editor.formatter.apply('alignleftimg')
                } else {
                    editor.formatter.apply('alignleft')
                }
            }
        });

        editor.ui.registry.addButton('customalignright', {
            icon: 'align-right',
            onAction: function () {
                if(editor.selection.getNode().nodeName == 'IMG') {
                    editor.formatter.apply('alignrightimg')
                } else {
                    editor.formatter.apply('alignright')
                }
            }
        });
    };
    var Buttons = { register: register };

    function Plugin () {
        global.add('customalign', function (editor) {
            editor.on('init', function () {
                editor.formatter.register('alignleftimg', {
                    selector: 'img',
                    'styles': { 'float' :'left', 'margin' : '0 1em .5em 0' }
                });

                editor.formatter.register('alignrightimg', {
                    selector: 'img',
                    'styles': { 'float' :'right', 'margin' : '0 0 .5em 1em' }
                });
            });

            Buttons.register(editor);
        });
    }

    Plugin();

}());
