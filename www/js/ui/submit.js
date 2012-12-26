define(
    ['jquery', 'underscore', 'lib/bootbox/bootbox'],
    function(jQuery, _, Bootbox) {
        "use strict";

        var submit = '[data-submit]',
            Submitter = function(e) {
                e.preventDefault();
                
                this.$el = $(e.target);

                if(this.$el.data('confirm')) {
                    this.getConfirmation();
                } else {
                    this.submitForm();
                }
            };

        _.extend(Submitter.prototype, {
            getConfirmation: function() {
                var message = this.$el.data('confirm') || 'Are you sure?';

                Bootbox.confirm(message, function(c) {
                    if(c) this.submitForm();
                }.bind(this));
            },

            submitForm: function() {
                $(this.$el.data('submit')).submit();
            }
        });

        // NEED THIS TO BE AUTOMATIC
        $('body').on('click.submit.data-api', submit, function(e) {
            var s = new Submitter(e);
        });
    }
);