define(
    ['jquery'],
    function(jQuery) {
        "use strict";

        var submit = '[data-submit]',
            Submitter = function(e) {
                $($(e).data('submit')).submit();
            };

        // NEED THIS TO BE AUTOMATIC
        $('body').on('click.submit.data-api', submit, Submitter);
    }
);