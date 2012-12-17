define(
    ['jquery'],
    function(jQuery) {
        "use strict";

        var submit = '[data-submit]',
            Submitter = function(e) {
                return alert('Hello!');
                $($(e).data('submit')).submit();
            };

        $.fn.submit = function () {
            // define plugin so you can use below definition
        };

        $(function () {
            $('body').on('click.submit.data-api', submit, Submitter);
        });
    }
);