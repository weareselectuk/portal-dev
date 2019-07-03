jQuery( document ).ready( function( $ ) {
    $('#simple_options_test_send').on( 'click', function() {
        var button = $(this);
        var parent = button.closest( 'form' );
        var to = $('#simple_options_test_to', parent);
        if ( '' === to.val() ) {
            window.alert( ub_smtp.messages.empty_smtp_to );
            to.focus();
            return false;
        }
        var data = {
            'action': 'ultimatebranding_smtp_test_email',
            'nonce': button.data('nonce'),
            'to': to.val()
        };
        $('div.notice', button.parent()).detach();
        button.hide().before( '<div class="notice notice-info"><p>'+ub_smtp.messages.sending+'</p></div>' );
        $.post( ajaxurl, data, function(response){
            $('div.notice', button.parent()).detach();
            var notice_class = 'info';
            if ( response.success ) {
                notice_class = 'success';
            } else {
                notice_class = 'error';
            }
            button.show().before( '<div class="notice notice-'+notice_class+'"><p>'+response.data+'</p></div>' );
        });
    });
});
