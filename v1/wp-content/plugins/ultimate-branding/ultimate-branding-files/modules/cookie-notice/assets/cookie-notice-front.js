( function ( $ ) {
    /**
     * bind
     */
    $( document ).ready( function () {
        $( '#ub-cookie-notice' ).on( 'click', '.ub-cn-set-cookie', function ( e ) {
            e.preventDefault();
            $( this ).setUBCookieNotice();
        } );
    } );

    /**
     * set Cookie Notice
     */
    $.fn.setUBCookieNotice = function () {
        var notice = $( '#ub-cookie-notice' );
        var expires = new Date();
        var value = parseInt( expires.getTime() );
        var cookie = '';

        /**
         * add time
         */
        value += parseInt( ub_cookie_notice.cookie.value ) * 1000;
        /**
         * add time zone
         */
        value += parseInt( ub_cookie_notice.cookie.timezone ) * 1000;
        /**
         * set time
         */
        expires.setTime( value + 2 * 24 * 60 * 60 * 1000 );
        /**
         * add cookie
         */
        cookie = ub_cookie_notice.cookie.name + '=' + value/1000 + ';';
        cookie += ' expires=' + expires.toUTCString() + ';';
        if ( ub_cookie_notice.cookie.domain ) {
            cookie += ' domain=' + ub_cookie_notice.cookie.domain + ';';
        }
        cookie += ' path=' + ub_cookie_notice.cookie.path + ';';
        if ( 'on' === ub_cookie_notice.cookie.secure ) {
            cookie += ' secure;'
        }
        document.cookie = cookie;
        /**
         * set user meta
         */
        if ( undefined !== ub_cookie_notice.logged && 'yes' === ub_cookie_notice.logged ) {
            var data = {
                'action': 'ub_cookie_notice',
                'user_id': ub_cookie_notice.user_id,
                'nonce': ub_cookie_notice.nonce
            };
            $.post( ub_cookie_notice.ajaxurl, data );
        }
        /**
         * reload
         */
        if ( undefined !== ub_cookie_notice.reloading && 'on' === ub_cookie_notice.reloading ) {
            document.location.reload( true );
            return;
        }
        /**
         * hide
         */
        var animation = undefined !== ub_cookie_notice.animation? ub_cookie_notice.animation:'none';
        switch( animation ) {
            case 'fade':
                notice.fadeOut( 400 );
                break;
            case 'slide':
                notice.slideUp( 400 );
                break;
            default:
                notice.hide();
        }
    };

} )( jQuery );
