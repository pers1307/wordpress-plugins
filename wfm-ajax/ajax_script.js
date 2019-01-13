jQuery(document).ready(function ($) {





    $('#wfm-form').submit(function () {
        // var formData = $('#wfm-form').serialize();

        $.ajax({
           type: 'post',
            data: {
                formData: $('#wfm_theme_options_body').val(),
                security: wfmajax.nonce,
                action: 'wfm_action'
            },
            url: ajaxurl,
            success: function (res) {

            },
            error: function () {

            }
        });



        // $.ajax({
        //    type: 'post',
        //     data: {'test': ''},
        //     url: 'http://wordpress.local/wp-content/plugins/wfm-ajax/index.php',
        //     success: function (res) {
        //
        //     },
        //     error: function () {
        //
        //     }
        // });
        return false;
    });
});
