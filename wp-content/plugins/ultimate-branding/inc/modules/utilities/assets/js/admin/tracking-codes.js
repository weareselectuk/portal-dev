;jQuery( document ).ready( function( $ ) {
    $('.wp-list-table.tracking-codes span.delete a').on( 'click', function() {
        return window.confirm( ub_tracking_codes.delete );
    });
    $('.tab-tracking-codes .button.action').on( 'click', function() {
        var value = $('select', $(this).parent()).val();
        if ( '-1' === value ) {
            return false;
        }
        if ( 'delete' === value ) {
            return window.confirm( ub_tracking_codes.bulk_delete );
        }
        return true;
    });
    /**
     * save code
     */
    $( 'button.branda-tracking-codes-save' ).on( 'click', function() {
        var dialog = $(this).closest( '.sui-dialog' );
        var data = {
            action: 'branda_tracking_codes_save',
            _wpnonce: $(this).data('nonce'),
        };
        $('input, select, textarea', dialog ).each( function() {
            if ( undefined === $(this).attr( 'name' ) ) {
                return;
            }
            if ( 'radio' === $(this).attr( 'type' ) ) {
                if ( $(this).is(':checked' ) ) {
                    data[$(this).attr('name')] = $(this).val();
                }
            } else {
                data[$(this).attr('name')] = $(this).val();
            }
        });
        var i= 0;
        var editor = $('.branda-general-code label', dialog ).attr( 'for' );
        data['branda[code]'] = SUI.editors[ editor ].getValue();
        $.post( ajaxurl, data, function( response ) {
            if ( response.success ) {
                window.location.reload();
            } else {
                window.ub_sui_notice( response.data.message, 'error' );
            }
        });
    });
    /**
     * reset
     */
    $( '.branda-tracking-codes-reset' ).on( 'click', function() {
        var id = $(this).data( 'id' );
        var dialog = $( '#branda-tracking-codes-' + id );
        var args = {
            action: 'branda_admin_panel_tips_reset',
            id: id,
            _wpnonce: $(this).data( 'nonce' )
        };
        $.post(
            ajaxurl,
            args,
            function ( response ) {
                if (
                    'undefined' !== typeof response.success &&
                    response.success &&
                    'undefined' !== typeof response.data
                ) {
                    var data = response.data;
                    if ( 'undefined' !== typeof data.active ) {
                        $('.branda-general-active input[value='+data.active+']', dialog ).click();
                    }
                    if ( 'undefined' !== typeof data.title ) {
                        $('[name="branda[title]"]', dialog ).val( data.title );
                    }
                    if ( 'undefined' !== typeof data.code ) {
                        var editor_id = 'branda-general-code-' + id;
                        var all = document.querySelectorAll('.ace_editor');
                        for (var i = 0; i < all.length; i++) {
                            if (
                                all[i].env &&
                                all[i].env.editor &&
                                all[i].env.textarea &&
                                all[i].env.textarea.id &&
                                editor_id === all[i].env.textarea.id
                            ) {
                                all[i].env.editor.setValue( data.code );
                            }
                        }
                    }
                    if ( 'undefined' !== typeof data.place ) {
                        $('.branda-location-place input[value='+data.place+']', dialog ).click();
                    }
                    if ( 'undefined' !== typeof data.filter ) {
                        $('.branda-location-filter input[value='+data.filter+']', dialog ).click();
                    }
                    if ( 'undefined' !== typeof data.users ) {
                        $('select[name="branda[users]"]', dialog ).SUIselect2( 'val', [ data.users ] );
                    }
                    if ( 'undefined' !== typeof data.authors ) {
                        $('select[name="branda[authors]"]', dialog ).SUIselect2( 'val', [ data.authors ] );
                    }
                    if ( 'undefined' !== typeof data.archives ) {
                        $('select[name="branda[archives]"]', dialog ).SUIselect2( 'val', [ data.archives ] );
                    }
                }
            }
        );
    });
    /**
     * delete item/bulk
     */
    $( '.branda-tracking-codes-delete' ).on( 'click', function() {
        var id = $(this).data('id');
        var action = 'branda_tracking_codes_delete';
        var ids = [];
        if ( 'bulk' === id ) {
            action = 'branda_tracking_codes_bulk_delete';
            $('tbody .check-column input:checked').each( function() {
                ids.push( $(this).val() );
            });
        }
        var data = {
            action: action,
            id: $(this).data('id' ),
            ids: ids,
            _wpnonce: $(this).data('nonce'),
        };
        $.post( ajaxurl, data, function( response ) {
            if ( response.success ) {
                window.location.reload();
            } else {
                window.ub_sui_notice( response.data.message, 'error' );
            }
        });
    });
});
