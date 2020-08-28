(function ($) {
    $.fn.fullCalendar = function (options = {}) {

        options = $.extend({}, options, $.fn.fullCalendar.options || {})

        this.each(function () {
            if (typeof this.fullCalendar === 'undefined') {
                this.fullCalendar = new FullCalendar.Calendar(this, options)
                this.fullCalendar.render();
            }
        });

        if ($(this).length === 1) {
            return this.get(0).fullCalendar;
        }

        return this;
    }
})(jQuery);
