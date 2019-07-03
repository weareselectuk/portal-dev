/*! Ultimate Branding - v2.3.0
 * https://premium.wpmudev.org/project/ultimate-branding/
 * Copyright (c) 2018; * Licensed GPLv2+ */
/* global window, jQuery  */

jQuery( window.document ).ready(function($){
    "use strict";
    $('.ub_color_picker').wpColorPicker();
});

/* global window, jQuery */

/**
 * close block
 */
/**
 * Simple Options: select2
 */
jQuery( window.document ).ready(function($){
    $('#UltimateBrandingAdmin-search-input').on( 'change keydown keyup blur reset copy paste cut input', function() {
        var search = $(this).val();
        var target = $('#the-list');
        var re;
        if ( '' === search ) {
            $('tr', target ).show();
            return;
        }
        re = new RegExp( search, 'i' );
        $('td.title', target).each( function() {
            var value = $(this).html();
            if ( value.match( re ) ) {
                $(this).parent().show();
            } else {
                $(this).parent().hide();
            }
        });
    });
});

/* global window, jQuery, ace */

jQuery( window.document ).ready(function($){
    "use strict";
    if ( $.fn.datepicker ) {
        $('.simple-option input.datepicker').each( function() {
            $(this).datepicker({
                altFormat: 'yy-mm-dd',
                altField: '#'+$(this).data('alt')
            });
        });
    }
});

/* global window, jQuery */

jQuery( window.document ).ready(function(){
    jQuery( 'form.tab-export-import #simple_options_import_file').on( 'change', function(e) {
        var target = jQuery( 'form.tab-export-import #simple_options_import_button');
        if ( '' === jQuery(this).val() ) {
            target.attr( 'disabled' );
        } else {
            var re = /json$/i;
            if ( re.test(jQuery(this).val()) ) {
                target.removeAttr( 'disabled' );
            }
        }
    });
});

/* global window, jQuery, wp, ajaxurl, wp_media_post_id */

jQuery( window.document ).ready(function($) {
    "use strict";
    var $main_fav_image = $("#ub_main_site_favicon"),
        $main_favicon = $('#wp_favicon'),
        $main_fav_id = $('#wp_favicon_id'),
        $main_fav_size = $('#wp_favicon_size'),
        $login_image = $('#wp_login_image'),
        $login_image_el = $('#wp_login_image_el'),
        $login_image_id = $('#wp_login_image_id'),
        $login_image_size = $('#wp_login_image_size'),
        $login_image_width = $('#wp_login_image_width'),
        $login_image_height = $('#wp_login_image_height'),
        $login_image_width_wrap = $('#wp_login_image_width_wrap'),
        $login_image_height_wrap = $('#wp_login_image_height_wrap')
        ;

    /**
     * If login image url is pasted
     */
    $login_image.on("paste", function(e){
        $login_image.unbind( "change" );
        $login_image.on("change", function(){
            var $this = $(this),
                temp = new window.Image(),
                $temp = $( temp ),
                $spinner = $(".spinner").first().clone()
                ;
            if( $.trim( $this.val() ) !== "" ){
                $login_image_el.prop("src", this.value );
                $login_image_id.val("");
                $login_image_size.val("");
                $login_image_width.val("");
                $login_image_height.val("");
            }

            temp.src = this.value;
            $temp.appendTo( "body" ).hide();
            $login_image_el.after( $spinner );
            $spinner.show();

            $login_image_height_wrap.after( $spinner );

            temp.onload = function(){
                $spinner.remove();
                $login_image_width_wrap.show();
                $login_image_height_wrap.show();
                $login_image_height.prop("type", "number").val( this.height );
                $login_image_width.prop("type", "number").val( this.width );
                $login_image_el.css({
                    height: this.height,
                    width: this.width
                });
            };

        });


    });

    $login_image_height.on("change", function(){
        $login_image_el.css("height", this.value);
    });

    $login_image_width.on("change", function(){
        $login_image_el.css("width", this.value);
    });

    $('#wp_login_image_button').click(function()
    {
        wp.media.editor.send.attachment = function(props, attachment)
        {
            var url = props.size && attachment.sizes[props.size] ? attachment.sizes[props.size].url : attachment.url;

            $login_image.val(url);
            $login_image_el.prop("src", url);
            $login_image_id.val(attachment.id);
            $login_image_size.val(props.size);
            $login_image_height_wrap.hide();
            $login_image_width_wrap.hide();
            $login_image_height.prop("type", "hidden");
            $login_image_width.prop("type", "hidden");

            $login_image_el.css({
               height: "auto",
               width: "auto"
            });
            var dimensions = props.size ?  attachment.sizes[ props.size ] : false;
            if( typeof dimensions !== 'undefined' && dimensions !== false ){
                $login_image_width.val( dimensions.width );
                $login_image_height.val( dimensions.height );
            }else{
                $login_image_width.val( "" );
                $login_image_height.val( "" );
            }
        };


        /**
         * Sets login image from Url
         *
         * @param props
         * @param attachment
         * @returns {*}
         */
        wp.media.string.props = function(props, attachment){
            var $spinner = $(".spinner").first().clone(),
                temp_image = new window.Image(),
                $temp_image = $(temp_image),
                $image = $('#wp_login_image_el'),
                $url = $('#wp_login_image')
                ;

            /**
             * Show loader until the image is fully loaded then place show the actual image
             */
            $temp_image.appendTo("body").hide();
            temp_image.src = props.url;

            if( !$image.find(".spinner").length ) {
                $image.before( $spinner.show() );
            }

            $image.hide();

            $temp_image.on("load", function(){
                $spinner.remove();
                $temp_image.remove();
                $image.prop("src", props.url).show();
            });

            $url.val(props.url);
            return props;
        };

        wp.media.editor.open();
        return false;
    });

    $('#wp_favicon_button').click(function(e)
    {
        e.preventDefault();

        /**
         * Sets favicon
         *
         * @param props
         * @param attachment
         */
        wp.media.editor.send.attachment = function(props, attachment)
        {
            $main_fav_image.prop("src", attachment.url);
            $main_favicon.val(attachment.url);
            $main_fav_id.val(attachment.id);
            $main_fav_size.val(props.size);
        };



        /**
         * Opens media browser
         */
        wp.media.editor.open();
    });

    /**
     * Update main favicon if url is changed via paste
     */
    $("#wp_favicon").on("change", function(e){
        $main_fav_image.prop("src", $(this).val());
        $main_favicon.val( $(this).val() );
        $main_fav_id.val("");
        $main_fav_size.val("full");
    });


    /**
     * Browses and sets the proper favicon for each sub-site
     *
     */
    $( window.document ).on("click", '.ub_favicons_browse', function(e)
    {
        e.preventDefault();

        var $this = $(this),
            $tr = $this.closest("tr"),
            $url = $tr.find(".ub_favicons_fav_url"),
            $id = $tr.find(".ub_favicons_fav_id"),
            $size = $tr.find(".ub_favicons_fav_size"),
            $image = $tr.find(".ub_favicons_fav");


        /**
         * Sets favicon from image gallery
         *
         * @param props
         * @param attachment
         */
        wp.media.editor.send.attachment = function(props, attachment)
        {
            $image.prop("src", attachment.url);
            $url.val(attachment.url);
            $id.val(attachment.id);
            $size.val(props.size);
        };

        /**
         * Sets favicon from Url
         *
         * @param props
         * @param attachment
         * @returns {*}
         */
        wp.media.string.props = function(props, attachment){
            var $spinner = $(".spinner").first().clone(),
                temp_image = new window.Image(),
                $temp_image = $(temp_image);

            /**
             * Show loader until the image is fully loaded then place show the actual image
             */
            $temp_image.appendTo("body").hide();
            temp_image.src = props.url;

            if( !$image.find(".spinner").length ) {
                $image.before( $spinner.show() );
            }

            $image.hide();

            $temp_image.on("load", function(){
                $spinner.remove();
                $temp_image.remove();
                $image.prop("src", props.url).show();
            });

            $url.val(props.url);
            return props;
        };

        // Opens media browser
        wp.media.editor.open();
    });

    $(".ub_favicons_fav_url").on("change", function(e){
        var $this = $(this),
            $tr = $this.closest("tr"),
            $id = $tr.find(".ub_favicons_fav_id"),
            $size = $tr.find(".ub_favicons_fav_size"),
            $image = $tr.find(".ub_favicons_fav"),
            val = $(this).val();

        if( val.length < 3 ) {
            val = $image.data("default");
        }

        $image.prop("src", val);
        $id.val("");
        $size.val("full");
    });

    /**
     * Save blogs favicon
     */
    $( window.document ).on("click",".ub_favicons_save", function(e) {
        var $this = $(this),
            $tr = $this.closest("tr"),
            $inputs = $tr.find("input"),
            $spinner = $tr.find(".spinner"),
            data = {action: "ub_save_favicon"};

        $inputs.each(function(){
           var $this = $(this);
           data[this.name] = $this.val();
        });

        e.preventDefault();
        $spinner.show();
        $.ajax({
            url : ajaxurl,
            type: "post",
            data: data,
            complete: function(){
                $spinner.hide();
            },
            success: function(){

            },
            error: function(){

            }
        });
    });

    /**
     * Reset blog's favicon
     */
    $( window.document ).on("click", ".ub_favicons_reset", function(e){
        var $this = $(this),
            $tr = $this.closest("tr"),
            $image = $tr.find(".ub_favicons_fav"),
            $url = $tr.find(".ub_favicons_fav_url"),
            $spinner = $tr.find(".spinner"),
            id = $this.data("id"),
            nonce = $("#ub_favicons_" + id +  "_reset").val(),
            data = {action: "ub_reset_favicon", id: id, nonce: nonce };

        e.preventDefault();
        $spinner.show();
        $.ajax({
            url : ajaxurl,
            type: "post",
            data: data,
            complete: function(){
                $spinner.hide();
            },
            success: function(res){
                if( res.success ){
                    $image.prop("src", res.data.fav);
                    $url.val("");
                }
            }
        });
    });
});

/**
 * universal media
 */

jQuery( window.document ).ready( function( $ ) {

    function ub_bind_reset_image( obj ) {
        var $this = jQuery( obj );
        var tr = $this.closest( 'tr' );
        if ( tr.hasClass( 'simple-option-gallery' ) ) {
            jQuery('.image-wrapper', tr ).detach();
        } else {
            $this.hide();
            jQuery('input[type=hidden]', tr ).val( null );
            jQuery('img', tr ).attr( 'src', null );
        }
    }

    function ub_media_bind( obj, event ) {
        var file_frame;
        var wp_media_post_id;
        var container = $(obj).closest('.image-wrapper');
        var set_to_post_id = $('.attachment-id', container ).val();

        event.preventDefault();
        // If the media frame already exists, reopen it.
        if ( file_frame ) {
            // Set the post ID to what we want
            file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
            // Open frame
            file_frame.open();
            return;
        } else {
            // Set the wp.media post id so the uploader grabs the ID we want when initialised
            wp.media.model.settings.post.id = set_to_post_id;
        }

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select a image to upload',
            button: {
                text: 'Use this image',
            },
            multiple: false	// Set to true to allow multiple files to be selected
        });

        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            var attachment = file_frame.state().get('selection').first().toJSON();

            // Do something with attachment.id and/or attachment.url here
            $('.image-preview', container ).attr( 'src', attachment.url ).css( 'width', 'auto' );
            $('.attachment-id', container ).val( attachment.id );
            $('.image-reset', container).removeClass('disabled').show();

            // Restore the main post ID
            wp.media.model.settings.post.id = wp_media_post_id;

            /**
             * add new
             */
            var target = container.closest( 'tr');
            if ( target.hasClass( 'simple-option-gallery' ) ) {
                if ( '' !== jQuery('.image-wrapper:last-child .attachment-id', target ).val() ) {
                    var ub_template = wp.template( 'simple-options-media' );
                    jQuery('.images', target).append( ub_template({
                        id: container.data('id'),
                        section_key: container.data('section_key'),
                        disabled: 'disabled'
                    }));
                    jQuery( ".image-wrapper:last-child .button-select-image", target ).on( 'click', function( event ) {
                        ub_media_bind( this, event );
                    });
                    jQuery( ".images .image-reset", target ).on( 'click', function() {
                        ub_bind_reset_image( this );
                        return false;
                    });
                }
            }

        });

        // Finally, open the modal
        file_frame.open();
    }

    jQuery(".simple-option-media .images, .simple-option-gallery .images").each( function() {
        var ub_template = wp.template( 'simple-options-media' );
        var target = jQuery( this );
        var data = window['_'+target.attr('id')];
        jQuery.each( data.images, function(){
            target.append( ub_template( this ) );
            jQuery( ".image-wrapper:last-child .button-select-image", target ).on( 'click', function( event ) {
                ub_media_bind( this, event );
            });
            jQuery( ".images .image-reset", target ).on( 'click', function() {
                ub_bind_reset_image( this );
                return false;
            });
        });
    });

    jQuery(".simple-option-media .image-reset").on("click", function(){
        ub_bind_reset_image( this );
        return false;
    });

    jQuery(".simple-option-gallery .image-reset").on("click", function( event ){
        jQuery(this).closest(".image-wrapper").detach();
        return false;
    });

    // Restore the main ID when the add media button is pressed
    jQuery( 'a.add_media' ).on( 'click', function() {
        wp.media.model.settings.post.id = wp_media_post_id;
    });
});

/* global window, jQuery */

jQuery( window.document ).ready(function() {
    "use strict";
    if ( window.ub_admin.current_menu_sub_item !== null) {
        jQuery('#adminmenu .wp-submenu li.current').removeClass("current");
        jQuery('a[href="admin.php?page=branding&tab=' + window.ub_admin.current_menu_sub_item + '"]').parent().addClass("current");
    }
});

/* global wp, window, wp_media_post_id, jQuery, ajaxurl, ace, switch_button */

/**
 * close block
 */
/**
 * Simple Options: select2
 */
jQuery( window.document ).ready(function($){
    function UltimateBrandingPublicFormat(site) {
        if (site.loading) {
            return site.text;
        }
        var markup = "<div class='select2-result-site clearfix'>";
        markup += "<div class='select2-result-title'>" + site.title + "</div>";
        if ( 'undefined' !== typeof site.subtitle ) {
            markup += "<div class='select2-result-subtitle'>" + site.subtitle + "</div>";
        }
        markup += "</div>";
        return markup;
    }
    function UltimateBrandingPublicFormatSelection (site) {
        return site.title || site.text;
    }
    if (jQuery.fn.select2) {
        $('.ub-select2').select2();
        $('.ub-select2-ajax').select2({
            ajax: {
                url: ajaxurl,
                dataType: 'json',
                delay: 250,
                data: function( params ) {
                    var query = {
                        user_id: $(this).data('user-id'),
                        _wpnonce: $(this).data('nonce'),
                        action: $(this).data('action'),
                        page: params.page,
                        q: params.term
                    };
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 1,
            escapeMarkup: function (markup) { return markup; },
            templateResult: UltimateBrandingPublicFormat,
            templateSelection: UltimateBrandingPublicFormatSelection
        });
    }
});

/* global window, jQuery, ajaxurl, ub_admin, wp */

jQuery( window.document ).ready(function($){
    "use strict";
    /**
     * Slider widget
     */
    if ( $.fn.slider ) {
        $('.simple-option div.ui-slider').each( function() {
            var id = $(this).data('target-id');
            if ( id ) {
                var target = $('#'+id);
                var value = target.val();
                var max = $(this).data('max') || 100;
                var min = $(this).data('min') || 0;
                $(this).slider({
                    value: value,
                    min: min,
                    max: max,
                    slide: function( event, ui ) {
                        target.val( ui.value );
                    }
                });
            }
        });
    }
    /**
     * sortable
     */
    $('table.sortable').sortable({
        items: 'tr'
    });
    /**
     * reset section
     */
    $('.simple-option-reset-section a').on('click', function() {
        var data = {
            'action': 'simple_option',
            'tab': $('#ub-tab').val(),
            'nonce': $(this).data('nonce'),
            'network': $(this).data('network'),
            'section': $(this).data('section')
        };
        if ( window.confirm( $(this).data('question') ) ) {
            jQuery.post(ajaxurl, data, function(response) {
                if ( response.success ) {
                    window.location.href = response.data.redirect;
                }
            });
        }
        return false;
    });
    /**
     * slave sections
     */
    $('.simple-options .postbox.section-is-slave').each( function() {
        var $this = $(this);
        var section = $this.data('master-section');
        var field = $this.data('master-field');
        var value = $this.data('master-value');
        $('[name="simple_options['+section+']['+field+']"]').on( 'change', function() {
            if ( 'checkbox' === $(this).attr('type') ) {
                if ( 'on' === value && $(this).is(":checked") ) {
                    $this.show();
                } else if ( 'off' === value && !$(this).is(":checked") ) {
                    $this.show();
                } else {
                    $this.hide();
                }
            } else {
                if ( $(this).val() === value ) {
                    $this.show();
                } else {
                    $this.hide();
                }
            }
        });
    });
    /**
     * close block
     */
    $( 'button.handlediv.button-link, .hndle', $('.simple-options, .ultimate-colors' ) ).on( 'click', function(e) {
        e.preventDefault();
        var target = $(this).parent();
        var form = $(this).closest('form');
        target.toggleClass( 'closed' );
        $.post(ajaxurl, {
            action: 'simple_option',
            close: target.hasClass( 'closed' ),
            target: target.attr('id'),
            nonce: $('[name=postboxes_nonce]', form).val(),
            tab: $('[name=tab]', form).val()
        });
    });
    /**
     * Field complex master
     */
    $( '.simple-option.simple-option-complex-master' ).each( function() {
        var $this = $(this);
        var section = $this.data('master-section');
        var field = $this.data('master-field');
        var value = $this.data('master-value');
        if ( "undefined" === typeof section || "undefined" === typeof field || "undefined" === typeof value) {
            return;
        }
        $( '[name="simple_options[' + section + '][' + field + ']' )
            .on( 'change', function() {
                window.console.log($(this));
                if ( $(this).val() === value ) {
                    $this.show();
                } else {
                    $this.hide();
                }
            });
    });
    /**
     * Copy section data
     */
    $( '.simple-options .ub-copy-section-settings a' ).on( 'click', function(e) {
        e.preventDefault();
        var parent = $(this).closest('div');
        var data = {
            'action': 'simple_option',
            'do': 'copy',
            'nonce': parent.data('nonce'),
            'module': parent.data('module'),
            'section': parent.data('section'),
            'from': $('select', parent).val()
        };
        if ( '-1' === data.from ) {
            window.alert( window.ub_admin.messages.copy.select_first );
            return false;
        }
        if ( window.confirm( window.ub_admin.messages.copy.confirm ) ) {
            jQuery.post(ajaxurl, data, function(response) {
                if ( response.success ) {
                    window.location.reload();
                } else {
                    if ( "undefined" === typeof response.data.message ) {
                        window.alert( window.ub_admin.messages.wrong );
                    } else {
                        window.alert( response.data.message );
                    }
                }
            });
        }
        return false;
    });
    /**
     * CSS editor
     */
    if ( 'false' !== ub_admin.editor_css ) {
        jQuery( '.ub_css_editor' ).each( function() {
            wp.codeEditor.initialize( $(this), ub_admin.editor_css );
        });
    }
    /**
     * HTML editor
     */
    if ( 'false' !== ub_admin.editor_html ) {
        jQuery( '.ub_html_editor' ).each( function() {
            wp.codeEditor.initialize( $(this), ub_admin.editor_html );
        });
    }
});

/* global window, jQuery, switch_button */

jQuery( window.document ).ready(function(){
    "use strict";
    if ( jQuery.fn.switchButton ) {
        var ultimate_branding_admin_check_slaves  = function() {
            jQuery('.simple-option .master-field' ).each( function() {
                var slave = jQuery(this).data('slave');
                if ( slave ) {
                    var slaves = jQuery( '.simple-option.' + slave );
                    var show = jQuery( '.switch-button-background', jQuery(this).closest('td') ).hasClass( 'checked' );
                    /**
                     * exception:
                     * module: Comments Control
                     */
                    if ( show && 'enabled-posts' === slave ) {
                        show = jQuery( '.switch-button-background', jQuery( '.simple-option .master-field[data-slave="enabled"]' ).closest( 'td' ) ).hasClass( 'checked' );
                    }
                    if ( show ) {
                        slaves.show();
                    } else {
                        slaves.hide();
                    }
                }
            });
        };
        jQuery('.simple-option .switch-button').each(function() {
            var options = {
                checked: jQuery(this).checked,
                on_label: jQuery(this).data('on') || switch_button.labels.label_on,
                off_label: jQuery(this).data('off') || switch_button.labels.label_off,
                on_callback: ultimate_branding_admin_check_slaves,
                off_callback: ultimate_branding_admin_check_slaves
            };
            jQuery(this).switchButton(options);
        });
    }
});


/* global window, jQuery, ub_admin */

jQuery( window.document ).ready(function($){
    "use strict";

    var container = $('.tabs');
    var primary = $('.ub-primary', container );
    var primaryItems = $('.ub-primary > li:not(.ub-more)', container);

    container.addClass('ub-jsfied');

    // insert "more" button and duplicate the list
    primary.append( '<li class="ub-more"><button type="button" class="ub-tab-more-button nav-tab" aria-haspopup="true" aria-expanded="false">'+ub_admin.tab_more+'</button><ul class="ub-secondary">'+primary.html()+'</ul></li>');

    var secondary = $('.ub-secondary', container);
    var secondaryItems = $('li', secondary );
    var allItems = $('li', container );
    var moreLi = $('.ub-more', primary );
    var moreBtn = $('button', moreLi );

    moreBtn.on( 'click', function() {
        container.toggleClass('ub-show-secondary');
        moreBtn.attr('aria-expanded', container.hasClass('ub-show-secondary'));
    });

    var stopWidth, hiddenItems, primaryWidth;

    function ub_tabs_recalculate() {
        /**
         * Show all items to allow calculate
         */
        allItems.removeClass( 'ub-hidden' );
        /**
         * calculate how much elements should be shown
         */
        stopWidth = moreBtn.width() + 40;
        hiddenItems = [];
        primaryWidth = primary.width();
        /**
         * hide/show
         */
        primaryItems.each( function( i ) {
            if(primaryWidth >= stopWidth + $(this).width()) {
                stopWidth += $(this).width();
            } else {
                $(this).addClass('ub-hidden');
                hiddenItems.push(i);
            }
        });

        /**
         * hide it
         */
        if( !hiddenItems.length ) {
            moreLi.addClass('ub-hidden');
            container.removeClass('ub-show-secondary');
            moreBtn.attr('aria-expanded', false);
        } else {
            secondaryItems.each( function( i ) {
                if(!hiddenItems.includes(i)) {
                    $(this).addClass('ub-hidden');
                }
            });
        }
    }

    ub_tabs_recalculate();

    $( window ).resize( function() {
        ub_tabs_recalculate();
    });

    /**
     * close more if click anywhere
     */
    $(window.document).on('click', function( e ) {
        var el = $(e.target);
        while( 1 === el.length ) {
            if ( el.hasClass( 'ub-tab-more-button' ) || el.hasClass( 'ub-secondary' ) ) {
                return;
            }
            el = el.parent();
        }
        container.removeClass('ub-show-secondary');
        moreBtn.attr('aria-expanded', false);
    });

});

/* global wp, window, wp_media_post_id, jQuery, ajaxurl, ace, switch_button */

/**
 * Modules control
 */
jQuery( window.document ).ready(function(){
    "use strict";
    if ( jQuery.fn.switchButton ) {
        jQuery( '#ultimate-branding-modules .switch-button').switchButton({
            on_label: jQuery(this).data('enable') || switch_button.labels.label_enable,
            off_label: jQuery(this).data('disable') || switch_button.labels.label_disable
        });
        jQuery( '#ultimate-branding-modules input.switch-button').on( 'change', function() {
            var checkbox = jQuery( this );
            var data = {
                action: 'ultimate_branding_toggle_module',
                module: checkbox.val(),
                nonce: checkbox.data('nonce'),
                state: checkbox.prop('checked')? 'on':'off'

            };
            jQuery.post(ajaxurl, data, function( response ) {
                if ( response.success ) {
                    window.location.reload();
                }
            });
        });
    }
} );
/**
 * reset login image
 */
jQuery( window.document ).ready(function($){
    var img = $('#login-screen-reset-image');
    img.on( 'click', function() {
        $('#wp_login_image_el')
            .attr( 'width', img.data('width') )
            .attr( 'src', img.data('src') )
            .attr( 'height', img.data('height') );
        $('#wp_login_image').val( img.data('src' ) );
        $('#wp_login_image_width').val( img.data('width' ) );
        $('#wp_login_image_height').val( img.data('height' ) );
        $('#wp_login_image_id').val( 'reset' );
        return false;
    });
});
/**
 * reset favicon main image
 */
jQuery( window.document ).ready(function($){
    var img = $('#favicon-reset-main-image');
    img.on( 'click', function() {
        $('#ub_main_site_favicon').attr( 'src', $('#wp_favicon').data('default' ) );
        $('#wp_favicon').val( $('#wp_favicon').data('default' ) );
        return false;
    });
});
