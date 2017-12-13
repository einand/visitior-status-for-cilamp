(function( $ ) {

    "use strict";

    $(document).ready(function($) {

        var data = {
            'action': 'cilamp_ajax_action',
        };

        $.post(cilamp_ajax.ajax_url, data, function(response) {
            console.log('Got this from the server: ' + response);
        });
    });
})(jQuery);
