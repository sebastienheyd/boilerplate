import CodeMirror from "admin-lte/plugins/codemirror/codemirror";
window.CodeMirror = CodeMirror;

if(typeof jQuery !== 'undefined') {
    (function ($) {
        $.fn.codemirror = function (options) {

            if(typeof CodeMirror == 'undefined' && console) {
                console.error('CodeMirror must be instanciated');
                return;
            }

            var options = options || {};
            var result = [];

            this.each(function () {
                var CodeMirrorOptions = $.extend({}, $.fn.codemirror.defaults, options);
                result.push(CodeMirror.fromTextArea(this, CodeMirrorOptions));
            });

            if(result.length == 1) {
                return result[0];
            }

            return result;
        }

        $.fn.codemirror.defaults = {
            mode: 'htmlmixed',
            lineNumbers: true,
            indentWithTabs: false,
            matchBrackets: true,
            styleActiveLine: true,
            autoCloseTags: true,
            matchTags: true
        };

    })(jQuery);
}
