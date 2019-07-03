// Load Functions to set data
jQuery(document).ready(function () {
    general_tab_load();
    field_tab_load();
    tag_tab_load();
    view_tab_load();
    label_tab_load();
    trigger_tab_load();
    woocommerce_tab_load();
    backup_restore_tab_load();
    export_tab_load();
    page_tab_load();
});
function backup_restore_tab_load()
{
    jQuery("#backup_date_range_start").datepicker({
        maxDate:"d",
        defaultDate: "d",
        dateFormat: "M d, yy",
        beforeShow: function(input, inst) {
            var pick = jQuery('#ui-datepicker-div');
            if(!jQuery(pick).parent().hasClass('wsdesk_date'))
            {
                jQuery('#ui-datepicker-div').wrap('<div class="wsdesk_date"></div>');
            }
        }
    });
    jQuery("#backup_date_range_end").datepicker({
        maxDate:"d",
        defaultDate: "d",
        dateFormat: "M d, yy",
        beforeShow: function(input, inst) {
            var pick = jQuery('#ui-datepicker-div');
            if(!jQuery(pick).parent().hasClass('wsdesk_date'))
            {
                jQuery('#ui-datepicker-div').wrap('<div class="wsdesk_date"></div>');
            }
        }
    });
    jQuery("#export_start_date").datepicker({
        maxDate:"d",
        defaultDate: "d",
        dateFormat: "M d, yy",
        beforeShow: function(input, inst) {
            var pick = jQuery('#ui-datepicker-div');
            if(!jQuery(pick).parent().hasClass('wsdesk_date'))
            {
                jQuery('#ui-datepicker-div').wrap('<div class="wsdesk_date"></div>');
            }
        }
    });
    jQuery("#export_end_date").datepicker({
        maxDate:"d",
        defaultDate: "d",
        dateFormat: "M d, yy",
        beforeShow: function(input, inst) {
            var pick = jQuery('#ui-datepicker-div');
            if(!jQuery(pick).parent().hasClass('wsdesk_date'))
            {
                jQuery('#ui-datepicker-div').wrap('<div class="wsdesk_date"></div>');
            }
        }
    });
    jQuery("#backup_format").select2({
        minimumResultsForSearch: -1
    });
    jQuery("#restore_format").select2({
        minimumResultsForSearch: -1
    });
}
function export_tab_load()
{
    jQuery("#export_date_range_start").datepicker({
        maxDate:"d",
        defaultDate: "d",
        dateFormat: "M d, yy",
        beforeShow: function(input, inst) {
            var pick = jQuery('#ui-datepicker-div');
            if(!jQuery(pick).parent().hasClass('wsdesk_date'))
            {
                jQuery('#ui-datepicker-div').wrap('<div class="wsdesk_date"></div>');
            }
        }
    });
    jQuery("#export_date_range_end").datepicker({
        maxDate:"d",
        defaultDate: "d",
        dateFormat: "M d, yy",
        beforeShow: function(input, inst) {
            var pick = jQuery('#ui-datepicker-div');
            if(!jQuery(pick).parent().hasClass('wsdesk_date'))
            {
                jQuery('#ui-datepicker-div').wrap('<div class="wsdesk_date"></div>');
            }
        }
    });
}
function woocommerce_tab_load()
{
    jQuery("#vendor_roles").select2({
        width: '100%',
        allowClear: true,
        placeholder: js_obj.Choose_the_Vendors,
        formatNoMatches: function () {
            return js_obj.No_Vendors_Found;
        },
        language: {
            noResults: function (params) {
                return js_obj.No_Vendors_Found;
            }
        }
    });
}
function general_tab_load()
{
    jQuery("#default_assignee").select2({
        width: '100%',
        minimumResultsForSearch: -1
    });
    jQuery("#default_label").select2({
        width: '100%',
        minimumResultsForSearch: -1
    });
    jQuery("#file-extension-select").select2({
        width: '100%',
        minimumResultsForSearch: -1
    });
}
function field_tab_load()
{
    jQuery('.list-group-field-data').sortable({
        placeholderClass: 'list-group-item',
        connectWith: '.connected'
    });
    jQuery("#ticket_field_add_type").select2({
        width: '100%',
        minimumResultsForSearch: -1
    });
    jQuery('[data-toggle="wsdesk_tooltip"]').wstooltip({trigger : 'hover'});
}
function label_tab_load()
{
    jQuery('[data-toggle="wsdesk_tooltip"]').wstooltip({trigger : 'hover'});
}
function view_tab_load()
{
    jQuery('.list-group-view-data').sortable({
        placeholderClass: 'list-group-item',
        connectWith: '.connected'
    });
    jQuery('[data-toggle="wsdesk_tooltip"]').wstooltip({trigger : 'hover'});
}
function trigger_tab_load()
{
    jQuery('[data-toggle="wsdesk_tooltip"]').wstooltip({trigger : 'hover'});
    jQuery("#trigger_add_format").select2({
        width: '100%',
        minimumResultsForSearch: -1
    });
    jQuery("#trigger_add_schedule").select2({
        width: '100%',
        minimumResultsForSearch: -1
    });
}
function tag_tab_edit_load()
{
    //Search Post for Tags
    jQuery(".ticket_tag_edit_posts").select2({
        width: '100%',
        allowClear: true,
        closeOnSelect: false,
        placeholder: js_obj.Search_and_Choose,
        ajax: {
            url: ajaxurl,
            dataType: 'json',
            type: 'post',
            delay: 250,
            data: function (params) {
                return {
                    action: 'eh_crm_search_post',
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: false
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 3,
        templateResult: formatResponse, // omitted for brevity, see the source of this page
        templateSelection: formatResponseSelection, // omitted for brevity, see the source of this page
        formatNoMatches: function () {
            return js_obj.No_Posts_Found;
        }
    });
}
function tag_tab_load()
{
    //Search Post for Tags
    jQuery(".ticket_tag_add_posts").select2({
        width: '100%',
        allowClear: true,
        closeOnSelect: false,
        placeholder: js_obj.Search_and_Choose,
        ajax: {
            url: ajaxurl,
            dataType: 'json',
            type: 'post',
            delay: 250,
            data: function (params) {
                return {
                    action: 'eh_crm_search_post',
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: false
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 3,
        templateResult: formatResponse, // omitted for brevity, see the source of this page
        templateSelection: formatResponseSelection, // omitted for brevity, see the source of this page
        formatNoMatches: function () {
            return js_obj.No_Posts_Found;
        }
    });
    jQuery('[data-toggle="wsdesk_tooltip"]').wstooltip({trigger : 'hover'});
}
function page_tab_load()
{
    jQuery('.list-group-page-data').sortable({
        placeholderClass: 'list-group-item',
        connectWith: '.connected'
    });
}
function formatResponse(response) {
    if (response.loading)
        return response.title;
    var markup = "<div class=''>" + response.title + "<div class=''>" + response.type + "</div></div>";
    return markup;
}

function formatResponseSelection(response) {
    var title = response.title;
    if (title.length > 15)
        return title.substr(0, 15) + '..';
    else
        return title;
}
jQuery(function () {

    //Change Breadcrump Text while switching tab
    jQuery(".nav-pills").on("click", "a", function (e) {
        e.preventDefault();
        switch (jQuery(this).prop("class"))
        {
            case 'general':
                jQuery('#breadcrump_section').html(js_obj.General);
                break;
            case 'ticket_fields':
                jQuery('#breadcrump_section').html(js_obj.Ticket_Fields);
                break;
            case 'ticket_labels':
                jQuery('#breadcrump_section').html(js_obj.Ticket_labels);
                break;
            case 'ticket_tags':
                jQuery('#breadcrump_section').html(js_obj.Ticket_Tags);
                break;
            case 'ticket_views':
                jQuery('#breadcrump_section').html(js_obj.Ticket_Views);
                break;
            case 'wsdesk_triggers':
                jQuery('#breadcrump_section').html(js_obj.Triggers_Automation);
                break;
            case 'woocommerce_settings':
                jQuery('#breadcrump_section').html("WooCommerce");
                break;
            case 'appearance':
                jQuery('#breadcrump_section').html(js_obj.Appearance);
                break;
            case 'backup_restore':
                jQuery('#breadcrump_section').html(js_obj.Backup_Restore);
                break;
            default:
                if(jQuery(this).hasClass('activation_wsdesk'))
                {
                    jQuery('#breadcrump_section').html(js_obj.Activation_of_WSDesk);
                }
                break;
        }
    });

    // General Settings Section All Events
    //Save General Button Action
    jQuery("#general_tab").on("click", "#save_general", function (e) {
        e.preventDefault();
        jQuery(".loader").css("display", "block");
        var default_assignee = jQuery("#default_assignee").val();
        var default_label = jQuery("#default_label").val();
        var ticket_raiser = jQuery("input[name='ticket_raiser']:checked").val();
        var auto_assign = jQuery("input[name='auto_assign']:checked").val();
        var auto_suggestion = '';
        var show_excerpt_in_auto_suggestion = '';
        var ticket_rows = jQuery("#ticket_display_row").val();
        var custom_attachment = jQuery("input[name='custom_attachment']:checked").val();
        var custom_attachment_path = jQuery("#custom_attachment_path").val();        
        var tickets_display = jQuery("input[name='tickets_display']:checked").val();
        var enable_api = '';
        var default_deep_link = jQuery("#default_deep_link").val();
        var api_key = jQuery("#api_key_textbox").val();
        var auto_create_user = '';
        var close_tickets = 'disable';
        var max_file_size = jQuery('#max_file_size').val();
        var ext = jQuery('.file-extension').val();
        var debug_status = '';
        var login_redirect_url = jQuery("#login_redirect_url").val();
        var logout_redirect_url = jQuery("#logout_redirect_url").val();
        var register_redirect_url = jQuery("#register_redirect_url").val();
        var submit_ticket_redirect_url = jQuery("#submit_ticket_redirect_url").val();
        var wsdesk_powered_by_status = 'disable';
        var exisiting_tickets_login_label = jQuery("#exisiting_tickets_login_label").val();
        var exisiting_tickets_register_label = jQuery("#exisiting_tickets_register_label").val();
        var allow_agent_tickets = 'disable';
        var linkify_urls = '';
        if(jQuery("input[name='auto_suggestion']:checked").val() !== undefined)
        {
            auto_suggestion = jQuery("input[name='auto_suggestion']:checked").val();
        }
        if(jQuery("input[name='wsdesk_debug_email']:checked").val() !== undefined)
        {
            debug_status  = jQuery("input[name='wsdesk_debug_email']:checked").val();
        }
        if(jQuery("input[name='auto_create_user']:checked").val() !== undefined)
        {
            auto_create_user = jQuery("input[name='auto_create_user']:checked").val();
        }
        if(jQuery("input[name='enable_api']:checked").val()!==undefined)
        {
            enable_api = jQuery("input[name='enable_api']:checked").val();
        }
        if(jQuery("input[name='show_excerpt_in_auto_suggestion']:checked").val() !== undefined)
        {
            show_excerpt_in_auto_suggestion = jQuery("input[name='show_excerpt_in_auto_suggestion']:checked").val();
        }
        if(jQuery("input[name='close_tickets']:checked").val() !== undefined)
        {
            close_tickets = jQuery("input[name='close_tickets']:checked").val();
        }
        if(jQuery("input[name='wsdesk_powered_by_status']:checked").val() !== undefined)
        {
            wsdesk_powered_by_status = jQuery("input[name='wsdesk_powered_by_status']:checked").val();
        }
        if(jQuery("input[name='linkify_urls']:checked").val() !== undefined)
        {
            linkify_urls = jQuery("input[name='linkify_urls']:checked").val();
        }
        if(jQuery("input[name='allow_agent_tickets']:checked").val() !== undefined)
        {
            allow_agent_tickets = jQuery("input[name='allow_agent_tickets']:checked").val();
        }
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_general',
                default_assignee: default_assignee,
                allow_agent_tickets: allow_agent_tickets,
                default_label : default_label,
                ticket_raiser: ticket_raiser,
                auto_assign: auto_assign,
                auto_suggestion: auto_suggestion,
                show_excerpt_in_auto_suggestion: show_excerpt_in_auto_suggestion,
                ticket_rows:ticket_rows,
                custom_attachment:custom_attachment,
                custom_attachment_path:custom_attachment_path,
                auto_create_user:auto_create_user,
                enable_api: enable_api,
                default_deep_link: default_deep_link,
                close_tickets:close_tickets,
                api_key: api_key,
                debug_status: debug_status,
                tickets_display: tickets_display,
                max_file_size:max_file_size,
                ext: (ext!==null)?ext.join(","):"",
                login_redirect_url: login_redirect_url,
                logout_redirect_url: logout_redirect_url,
                register_redirect_url: register_redirect_url,
                submit_ticket_redirect_url: submit_ticket_redirect_url,
                wsdesk_powered_by_status: wsdesk_powered_by_status,
                exisiting_tickets_login_label: exisiting_tickets_login_label,
                exisiting_tickets_register_label: exisiting_tickets_register_label,
                linkify_urls: linkify_urls
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.General_Settings+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#general_tab").html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    // WooCommerce Settings Section All Events
    //Save WooCommerce Button Action
    jQuery("#woocommerce_tab").on("click", "#save_woocommerce", function (e) {
        e.preventDefault();
        jQuery(".loader").css("display", "block");
        var woo_order_tickets = jQuery("input[name='woo_order_tickets']:checked").val();
        var woo_order_price = jQuery("input[name='woo_order_price']:checked").val();
        var woo_order_access = getValue_checkbox_values("woo_order_access");
        var woo_vendor_roles = jQuery("#vendor_roles").val();
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_woocommerce_settings',
                woo_order_tickets: woo_order_tickets,
                woo_order_price : woo_order_price,
                woo_order_access: woo_order_access,
                woo_vendor_roles: (woo_vendor_roles !== null) ? woo_vendor_roles.join(",") : "",
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.WooCommerce_Settings+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#woocommerce_tab").html(data);
                woocommerce_tab_load();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    
    //Appearance Settings Section All Events
    //Save Appearance Button Action
    jQuery("#appearance_tab").on("click", "#save_appearance", function (e) {
        e.preventDefault();
        jQuery(".loader").css("display", "block");
        var input_elements_width    = jQuery("#input_elements_width").val();
        var main_ticket_form_title    = jQuery("#main_ticket_form_title").val();
        var new_ticket_form_title    = jQuery("#new_ticket_form_title").val();
        var existing_ticket_title    = jQuery("#existing_ticket_title").val();
        var submit_ticket_button    = jQuery("#submit_ticket_button").val();
        var reset_ticket_button    = jQuery("#reset_ticket_button").val();
        var existing_ticket_button    = jQuery("#existing_ticket_button").val();
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action      : 'eh_crm_ticket_appearance',
                input_width : input_elements_width,
                main_ticket_title       : main_ticket_form_title,
                new_ticket_title        : new_ticket_form_title,
                existing_ticket_title   : existing_ticket_title,
                submit_ticket_button    : submit_ticket_button,
                reset_ticket_button     : reset_ticket_button,
                existing_ticket_button  : existing_ticket_button
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Appearance_Settings+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#appearance_tab").html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    //Ticket Fields Settings Section All Events
    //Save Ticket Fields Action
    jQuery("#ticket_fields_tab").on("click", "#save_ticket_fields", function (e) {
        e.preventDefault();
        var selected_fields = jQuery(".list-group-field-data li[id]")
                .map(function () {
                    return this.id;
                })
                .get();
        var new_field = {};
        var edit_field = {};
        var all_tickets_view = [];
        if (jQuery("#add_new_field_yes").val() === "yes" && jQuery("#ticket_field_add_type").val() !== "") {
            new_field["type"] = jQuery("#ticket_field_add_type").val();
            if(jQuery("#ticket_field_add_title").val() === "")
            {
                jQuery(".loader").css("display", "none");
                jQuery("#ticket_field_add_title").css("border","1px solid red");
                jQuery(".alert-danger").css("display", "block");
                jQuery(".alert-danger").css("opacity", "1");
                jQuery("#danger_alert_text").html("<strong>"+js_obj.Add_Ticket_Field+"</strong><br>"+js_obj.Enter_title_for_the_Field+"!");
                window.setTimeout(function () {
                    jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery('html, body').animate({
                    scrollTop: jQuery("#ticket_fields_tab").offset().top
                }, 1000);
                return false;
            }
            new_field["title"] = jQuery("#ticket_field_add_title").val();
            new_field["required"] = "no";
            new_field["placeholder"] = "";
            new_field["default"] = "";
            new_field["values"] = "";
            new_field["description"] = jQuery("#ticket_field_add_description").val();
            switch (jQuery("#ticket_field_add_type").val())
            {
                case "text":
                case "number":
                case "email":
                case "password":
                case "phone":
                    new_field["default"] = jQuery("#ticket_field_add_default").val();
                    if(jQuery("input[name='ticket_field_add_require']:checked").val() !== undefined)
                    {
                        new_field["required"] = 'yes';
                    }
                    else
                    {
                        new_field["required"] = 'no';
                    }
                    if(jQuery("input[name='ticket_field_add_visible']:checked").val() !== undefined)
                    {
                        new_field["visible"] = 'yes';
                    }
                    else
                    {
                        new_field["visible"] = 'no';
                    }
                    if(jQuery("input[name='ticket_field_add_agent_require']:checked").val() !== undefined)
                    {
                        new_field["required_agent"] = 'yes';
                    }
                    else
                    {
                        new_field["required_agent"] = 'no';
                    }
                    new_field["placeholder"] = jQuery("#ticket_field_add_placeholder").val();
                    break;
                case "date":
                    if(jQuery("input[name='ticket_field_add_require']:checked").val() !== undefined)
                    {
                        new_field["required"] = 'yes';
                    }
                    else
                    {
                        new_field["required"] = 'no';
                    }
                    if(jQuery("input[name='ticket_field_add_visible']:checked").val() !== undefined)
                    {
                        new_field["visible"] = 'yes';
                    }
                    else
                    {
                        new_field["visible"] = 'no';
                    }
                    if(jQuery("input[name='ticket_field_add_agent_require']:checked").val() !== undefined)
                    {
                        new_field["required_agent"] = 'yes';
                    }
                    else
                    {
                        new_field["required_agent"] = 'no';
                    }
                    new_field["placeholder"] = jQuery("#ticket_field_add_placeholder").val();
                    break;
                case "radio":
                case "checkbox":
                case "select":
                    var values = [];
                    if(jQuery("input[name='ticket_field_add_require']:checked").val() !== undefined)
                    {
                        new_field["required"] = 'yes';
                    }
                    else
                    {
                        new_field["required"] = 'no';
                    }
                    if(jQuery("input[name='ticket_field_add_visible']:checked").val() !== undefined)
                    {
                        new_field["visible"] = 'yes';
                    }
                    else
                    {
                        new_field["visible"] = 'no';
                    }
                    if(jQuery("input[name='ticket_field_add_agent_require']:checked").val() !== undefined)
                    {
                        new_field["required_agent"] = 'yes';
                    }
                    else
                    {
                        new_field["required_agent"] = 'no';
                    }
                    if(jQuery("#ticket_field_add_type").val() === 'select')
                    {
                        new_field["placeholder"] = jQuery("#ticket_field_add_placeholder").val();
                    }
                    jQuery(".ticket_field_add_values").each(function () {
                        values.push(jQuery(this).val());
                    });
                    if (jQuery("#ticket_field_add_default").val() != '')
                    {
                        if (jQuery.inArray(jQuery("#ticket_field_add_default").val(), values) != '-1')
                        {
                            new_field["default"] = jQuery("#ticket_field_add_default").val();
                        } 
                        else
                        {
                            jQuery(".loader").css("display", "none");
                            jQuery(".alert-danger").css("display", "block");
                            jQuery(".alert-danger").css("opacity", "1");
                            jQuery("#danger_alert_text").html("<strong>"+js_obj.Ticket_Fields+"</strong><br>"+js_obj.Default_Value_is_not_Matched+"!");
                            window.setTimeout(function () {
                                jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                                    jQuery(this).css("display", "none");
                                });
                            }, 4000);
                            jQuery('html, body').animate({
                                scrollTop: jQuery("#ticket_fields_tab").offset().top
                            }, 1000);
                            return false;
                        }

                    }
                    new_field["values"] = values;
                    break;
                case "woo_product":
                case "woo_order_id":
                case "edd_products":
                case "woo_category":
                case "woo_tags":
                case "woo_vendors":
                    new_field["placeholder"] = jQuery("#ticket_field_add_placeholder").val();
                    if(jQuery("input[name='ticket_field_add_require']:checked").val() !== undefined)
                    {
                        new_field["required"] = 'yes';
                    }
                    else
                    {
                        new_field["required"] = 'no';
                    }
                    if(jQuery("input[name='ticket_field_add_visible']:checked").val() !== undefined)
                    {
                        new_field["visible"] = 'yes';
                    }
                    else
                    {
                        new_field["visible"] = 'no';
                    }
                    if(jQuery("input[name='ticket_field_add_agent_require']:checked").val() !== undefined)
                    {
                        new_field["required_agent"] = 'yes';
                    }
                    else
                    {
                        new_field["required_agent"] = 'no';
                    }
                    var values = {};
                    var def_check = [];
                    jQuery(".ticket_field_add_values").each(function () {
                        def_check.push(jQuery(this).val());
                        var id = jQuery(this).parent().children("input[type=hidden]").prop("id");
                        values[id] = jQuery(this).val();
                    });
                    if (jQuery("#ticket_field_add_default").val() != '')
                    {
                        if (jQuery.inArray(jQuery("#ticket_field_add_default").val(), def_check) != '-1')
                        {
                            new_field["default"] = jQuery("#ticket_field_add_default").val();
                        } else
                        {
                            jQuery(".loader").css("display", "none");
                            jQuery(".alert-danger").css("display", "block");
                            jQuery(".alert-danger").css("opacity", "1");
                            jQuery("#danger_alert_text").html("<strong>"+js_obj.Ticket_Fields+"</strong><br>"+js_obj.Default_Value_is_not_Matched+"!");
                            window.setTimeout(function () {
                                jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                                    jQuery(this).css("display", "none");
                                });
                            }, 4000);
                            jQuery('html, body').animate({
                                scrollTop: jQuery("#ticket_fields_tab").offset().top
                            }, 1000);
                            return false;
                        }
                    }
                    new_field["values"] = values;
                    break;
                case 'file':
                    if(jQuery("input[name='ticket_field_add_require']:checked").val() !== undefined)
                    {
                        new_field["required"] = 'yes';
                    }
                    else
                    {
                        new_field["required"] = 'no';
                    }
                    if(jQuery("input[name='ticket_field_add_visible']:checked").val() !== undefined)
                    {
                        new_field["visible"] = 'yes';
                    }
                    else
                    {
                        new_field["visible"] = 'no';
                    }
                    new_field["file_type"] = jQuery("input[name='ticket_field_add_file_type']:checked").val();
                    break;
                case 'textarea':
                    new_field["default"] = jQuery("#ticket_field_add_default").val();
                    if(jQuery("input[name='ticket_field_add_require']:checked").val() !== undefined)
                    {
                        new_field["required"] = 'yes';
                    }
                    else
                    {
                        new_field["required"] = 'no';
                    }
                    if(jQuery("input[name='ticket_field_add_visible']:checked").val() !== undefined)
                    {
                        new_field["visible"] = 'yes';
                    }
                    else
                    {
                        new_field["visible"] = 'no';
                    }
                    if(jQuery("input[name='ticket_field_add_agent_require']:checked").val() !== undefined)
                    {
                        new_field["required_agent"] = 'yes';
                    }
                    else
                    {
                        new_field["required_agent"] = 'no';
                    }
                    break;
                case 'google_captcha':
                        if (jQuery("#site_key").val()!=="" && jQuery("#secret_key").val()!=="")
                        {
                            new_field["site_key"] = jQuery("#site_key").val();
                            new_field["secret_key"] = jQuery("#secret_key").val();
                        } else
                        {
                            jQuery(".loader").css("display", "none");
                            jQuery(".alert-danger").css("display", "block");
                            jQuery(".alert-danger").css("opacity", "1");
                            jQuery("#danger_alert_text").html("<strong>"+js_obj.Ticket_Fields+"</strong><br>"+js_obj.Site_Key_and_Secret_Key_is_Required+"!");
                            window.setTimeout(function () {
                                jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                                    jQuery(this).css("display", "none");
                                });
                            }, 4000);
                            jQuery('html, body').animate({
                                scrollTop: jQuery("#ticket_fields_tab").offset().top
                            }, 1000);
                            return false;
                        }
                    break;
            }
        }
        var flag=1;
        if (jQuery("#ticket_field_edit_type").val() !== "")
        {   
            edit_field["slug"] = (jQuery("#ticket_field_edit_type").val() !== undefined) ? jQuery("#ticket_field_edit_type").val() : "";
            edit_field["title"] = (jQuery("#ticket_field_edit_title").val() !== undefined) ? jQuery("#ticket_field_edit_title").val() : "";
            switch (edit_field['slug'])
            {
                case 'request_email':
                    edit_field["required"] = 'yes';
                    break;
                case 'request_title':
                    edit_field["required"] = 'yes';
                    break
                case 'request_description':
                    edit_field["required"] = 'yes';
                    break;
                default:
                    edit_field["required"] = (jQuery("input[name='ticket_field_edit_require']:checked").val() !== undefined) ? jQuery("input[name='ticket_field_edit_require']:checked").val() : "no";
            }
            edit_field["visible"] = (jQuery("input[name='ticket_field_edit_visible']:checked").val() !== undefined) ? jQuery("input[name='ticket_field_edit_visible']:checked").val() : "no";
            edit_field["required_agent"] = (jQuery("input[name='ticket_field_edit_agent_require']:checked").val() !== undefined) ? jQuery("input[name='ticket_field_edit_agent_require']:checked").val() : "no";
            edit_field["file_type"] = (jQuery("input[name='ticket_field_edit_file_type']:checked").val() !== undefined) ? jQuery("input[name='ticket_field_edit_file_type']:checked").val() : "";
            edit_field["placeholder"] = (jQuery("#ticket_field_edit_placeholder").val() !== undefined) ? jQuery("#ticket_field_edit_placeholder").val() : '';
            edit_field["default"] = "";
            edit_field["values"] = "";
            edit_field["description"]=(jQuery("#ticket_field_edit_description").val() !== undefined) ? jQuery("#ticket_field_edit_description").val() : "";
            if(jQuery(".dropdown_options_order").html() != 'undefined')
            {
                var field_order = [];
                jQuery(".dropdown_options_order option").each(function(){
                    field_order.push(jQuery(this).val());
                });
                edit_field['field_order'] = field_order;
            }
            var values = {};
            var def_check = [];
            if (jQuery('.ticket_field_edit_values').length !== 0)
            {
                jQuery(".ticket_field_edit_values").each(function () {
                    def_check.push(jQuery(this).val());
                    var old_id = jQuery(this).parent().children("input[type=hidden]").prop("id");
                    values[old_id] = jQuery(this).val();
                });
                edit_field["values"] = values;
            }

            flag=0;
            var slug=jQuery("#ticket_field_edit_type").val();
            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_get_settingsmeta_from_slug',
                    slug: slug
                },
                success: function (data) {
                    var response=jQuery.parseJSON(data);
                    if(response!=undefined)
                        var field_type=response.field_type;
                    else
                        field_type=undefined;

                    if(field_type=='select')
                    {
                        if (jQuery("#ticket_field_edit_default").val() != '')
                        {
                            if (jQuery.inArray(jQuery("#ticket_field_edit_default").val(), def_check) == Number('-1'))
                            {
                                jQuery(".loader").css("display", "none");
                                jQuery(".alert-danger").css("display", "block");
                                jQuery(".alert-danger").css("opacity", "1");
                                jQuery("#danger_alert_text").html("<strong>"+js_obj.Edit_Ticket_Field+"</strong><br>"+js_obj.Default_Value_is_not_Matched+"!");
                                window.setTimeout(function () {
                                    jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                                        jQuery(this).css("display", "none");
                                    });
                                }, 4000);
                                jQuery('html, body').animate({
                                    scrollTop: jQuery("#ticket_fields_tab").offset().top
                                }, 1000);
                                return false;
                            }
                            else
                            {
                                edit_field["default"] = jQuery("#ticket_field_edit_default").val();                    
                            }
                        }
                    }
                    else
                    {
                        if(typeof jQuery("#ticket_field_edit_default").val()!= 'undefined')
                            edit_field["default"] = jQuery("#ticket_field_edit_default").val();
                        else
                            edit_field["default"] = "";
                    }
                    jQuery(".loader").css("display", "block");
                    jQuery.ajax({
                        type: 'post',
                        url: ajaxurl,
                        data: {
                            action: 'eh_crm_ticket_field',
                            selected_fields: (selected_fields !== null) ? selected_fields.join(",") : '',
                            new_field: JSON.stringify(new_field),
                            edit_field: JSON.stringify(edit_field),
                        },
                        success: function (data) {
                            var response = jQuery.parseJSON(data);
                            jQuery(".loader").css("display", "none");
                            jQuery(".alert-success").css("display", "block");
                            jQuery(".alert-success").css("opacity", "1");
                            jQuery("#success_alert_text").html("<strong>"+js_obj.Ticket_Fields+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                            window.setTimeout(function () {
                                jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                    jQuery(this).css("display", "none");
                                });
                            }, 4000);
                            jQuery("#ticket_fields_tab").html(response.fields);
                            field_tab_load();
                            jQuery("#ticket_views_tab").html(response.views);
                            view_tab_load();
                            jQuery("#triggers_tab").html(response.triggers);
                            trigger_tab_load();
                            jQuery('#ticket_page_tab').html(response.page);
                            page_tab_load();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
        if(flag==1)
        {
            jQuery(".loader").css("display", "block");
            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_ticket_field',
                    selected_fields: (selected_fields !== null) ? selected_fields.join(",") : '',
                    new_field: JSON.stringify(new_field),
                    edit_field: JSON.stringify(edit_field),
                },
                success: function (data) {
                    var response = jQuery.parseJSON(data);
                    jQuery(".loader").css("display", "none");
                    jQuery(".alert-success").css("display", "block");
                    jQuery(".alert-success").css("opacity", "1");
                    jQuery("#success_alert_text").html("<strong>"+js_obj.Ticket_Fields+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                    window.setTimeout(function () {
                        jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                            jQuery(this).css("display", "none");
                        });
                    }, 4000);
                    jQuery("#ticket_fields_tab").html(response.fields);
                    field_tab_load();
                    jQuery("#ticket_views_tab").html(response.views);
                    view_tab_load();
                    jQuery("#triggers_tab").html(response.triggers);
                    trigger_tab_load();
                    jQuery('#ticket_page_tab').html(response.page);
                    page_tab_load();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    });
    jQuery("#ticket_fields_tab").on("click", ".ticket_field_delete_type", function (e) {
        var field_id = jQuery(this).prop("id");
        BootstrapDialog.show({
            title: "WSDesk Alert",
            message: 'Do you want to delete the field?',
            cssClass: 'wsdesk_wrapper',
            buttons: [{
                    label: 'Yes! Delete',
                    // no title as it is optional
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        jQuery(".loader").css("display", "block");
                        jQuery.ajax({
                            type: 'post',
                            url: ajaxurl,
                            data: {
                                action: 'eh_crm_ticket_field_delete',
                                fields_remove: field_id,
                            },
                            success: function (data) {
                                var response = jQuery.parseJSON(data);
                                jQuery(".loader").css("display", "none");
                                jQuery(".alert-success").css("display", "block");
                                jQuery(".alert-success").css("opacity", "1");
                                jQuery("#success_alert_text").html("<strong>"+js_obj.Ticket_Fields+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                                window.setTimeout(function () {
                                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                        jQuery(this).css("display", "none");
                                    });
                                }, 4000);
                                jQuery("#ticket_fields_tab").html(response.fields);
                                field_tab_load();
                                jQuery("#ticket_views_tab").html(response.views);
                                view_tab_load();
                                jQuery("#triggers_tab").html(response.triggers);
                                trigger_tab_load();
                                jQuery('#ticket_page_tab').html(response.page);
                                page_tab_load();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
                        dialogItself.close();
                    }
                }, {
                    label: 'Close',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    });
    jQuery("#ticket_fields_tab").on("click", ".ticket_field_activate", function (e) {
        var field_id = jQuery(this).prop("id");
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_field_activate_deactivate',
                field_id: field_id,
                type:'activate',
            },
            success: function (data) {
                var response = jQuery.parseJSON(data);
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Ticket_Fields+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#ticket_fields_tab").html(response.fields);
                field_tab_load();
                jQuery("#ticket_views_tab").html(response.views);
                view_tab_load();
                jQuery("#triggers_tab").html(response.triggers);
                trigger_tab_load();
                jQuery('#ticket_page_tab').html(response.page);
                page_tab_load();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#ticket_fields_tab").on("click", ".ticket_field_deactivate", function (e) {
        var field_id = jQuery(this).prop("id");
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_field_activate_deactivate',
                field_id: field_id,
                type:'deactivate'
            },
            success: function (data) {
                var response = jQuery.parseJSON(data);
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Ticket_Fields+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#ticket_fields_tab").html(response.fields);
                field_tab_load();
                jQuery("#ticket_views_tab").html(response.views);
                view_tab_load();
                jQuery("#triggers_tab").html(response.triggers);
                trigger_tab_load();
                jQuery('#ticket_page_tab').html(response.page);
                page_tab_load();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    //Edit Ticket Fields Action
    jQuery("#ticket_fields_tab").on("click", ".ticket_field_edit_type", function (e) {
        e.preventDefault();
        var field = jQuery(this).prop("id");
        jQuery("#add_new_field_yes").val("no");
        jQuery("#ticket_field_edit_type").val(field);
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_field_edit',
                field: field
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery("#ticket_field_edit_display").slideDown().show();
                jQuery("#ticket_field_add_display").slideUp().hide();
                jQuery("#ticket_field_edit_append").empty();
                jQuery("#ticket_field_edit_append").html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    //Add New Ticket Fields Action
    jQuery("#ticket_fields_tab").on("click", "#ticket_field_add_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_field_edit_display").slideUp().hide();
        jQuery("#ticket_field_add_display").slideDown().show();
        jQuery("#add_new_field_yes").val("yes");
        jQuery("#ticket_field_edit_type").val("");
    });
    jQuery("#ticket_fields_tab").on("click", "#ticket_field_cancel_add_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_field_add_display").slideUp().hide();
        jQuery("#add_new_field_yes").val("no");
    });
    jQuery("#ticket_fields_tab").on("click", "#ticket_field_cancel_edit_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_field_edit_display").slideUp().hide();
        jQuery("#ticket_field_edit_type").val("");
    });

    //Add Type of Ticket Fields Action
    jQuery("#ticket_fields_tab").on("change", "#ticket_field_add_type", function (e) {
        e.preventDefault();
        var val = jQuery(this).val();
        var html = jQuery("#ticket_field_add_type option[value='" + val + "']").html();
        var add_value = '<button class="button" id="ticket_field_add_values_add" style="vertical-align: baseline;margin-bottom: 10px;">'+js_obj.Add_Value+'</button>';
        var input = '<span class="help-block">'+js_obj.Enter_Details_for_custom+' ' + html + ' </span>';
        input += '<input type="text" id="ticket_field_add_title" placeholder="'+js_obj.Enter_Title+'" class="form-control crm-form-element-input">';
        switch (val)
        {
            case '':
                break;
            case 'google_captcha':
                input += '<br>'+js_obj.Enter_Site_Key+'<input type="text" id="site_key" class="form-control crm-form-element-input">';
                input += js_obj.Enter_Secret_Key+'<input type="text" id="secret_key"class="form-control crm-form-element-input"><br>';
                input += '<a href="https://www.google.com/recaptcha/intro/" target="_blank">New Google reCAPTCHA</a>';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
            case 'woo_order_id':
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_visible" checked class="form-control" name="ticket_field_add_visible" value="yes"> '+js_obj.Yes_This_Field_is_Visible+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_require" checked class="form-control" name="ticket_field_add_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_End+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_agent_require" class="form-control" name="ticket_field_add_agent_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_Agents+'</span>';
                input += '<br>'+js_obj.Enter_Placeholder+'<input type="text" id="ticket_field_add_placeholder" class="form-control crm-form-element-input">';
                input += '<input type="hidden" id="ticket_field_add_default" class="form-control crm-form-element-input">';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
            case 'woo_product':
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_visible" checked class="form-control" name="ticket_field_add_visible" value="yes"> '+js_obj.Yes_This_Field_is_Visible+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_require" checked class="form-control" name="ticket_field_add_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_End+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_agent_require" class="form-control" name="ticket_field_add_agent_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_Agents+'</span>';
                input += '<br>'+js_obj.Enter_Placeholder+'<input type="text" id="ticket_field_add_placeholder" class="form-control crm-form-element-input">';
                var pull_woo = '<button class="button" id="ticket_woo_product_field_add_values_fill" style="margin:0px 10px; vertical-align: baseline;margin-bottom: 10px;">'+js_obj.Auto_fill_products+'</button>';
                input += '<span class="help-block">'+js_obj.Specify_the_Product_values+'! </span>';
                input += '<span class="ticket_field_add_values_span" id=""></span>'+add_value + pull_woo;
                input += '<br>'+js_obj.Enter_Default_Values+'<input type="text" id="ticket_field_add_default" class="form-control crm-form-element-input">';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
            case 'woo_category':
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_visible" checked class="form-control" name="ticket_field_add_visible" value="yes"> '+js_obj.Yes_This_Field_is_Visible+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_require" checked class="form-control" name="ticket_field_add_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_End+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_agent_require" class="form-control" name="ticket_field_add_agent_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_Agents+'</span>';
                input += '<br>'+js_obj.Enter_Placeholder+'<input type="text" id="ticket_field_add_placeholder" class="form-control crm-form-element-input">';
                var pull_woo = '<button class="button" id="ticket_woo_category_field_add_values_fill" style="margin:0px 10px; vertical-align: baseline;margin-bottom: 10px;">'+js_obj.Auto_fill_categories+'</button>';
                input += '<span class="help-block">'+js_obj.Specify_the_Category_values+'! </span>';
                input += '<span class="ticket_field_add_values_span" id=""></span>'+add_value + pull_woo;
                input += '<br>'+js_obj.Enter_Default_Values+'<input type="text" id="ticket_field_add_default" class="form-control crm-form-element-input">';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
            case 'woo_tags':
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_visible" checked class="form-control" name="ticket_field_add_visible" value="yes"> '+js_obj.Yes_This_Field_is_Visible+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_require" checked class="form-control" name="ticket_field_add_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_End+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_agent_require" class="form-control" name="ticket_field_add_agent_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_Agents+'</span>';
                input += '<br>'+js_obj.Enter_Placeholder+'<input type="text" id="ticket_field_add_placeholder" class="form-control crm-form-element-input">';
                var pull_woo = '<button class="button" id="ticket_woo_tags_field_add_values_fill" style="margin:0px 10px; vertical-align: baseline;margin-bottom: 10px;">'+js_obj.Auto_fill_tags+'</button>';
                input += '<span class="help-block">'+js_obj.Specify_the_Tag_values+'! </span>';
                input += '<span class="ticket_field_add_values_span" id=""></span>'+add_value + pull_woo;
                input += '<br>'+js_obj.Enter_Default_Values+'<input type="text" id="ticket_field_add_default" class="form-control crm-form-element-input">';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
            case 'edd_products':
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_visible" checked class="form-control" name="ticket_field_add_visible" value="yes"> '+js_obj.Yes_This_Field_is_Visible+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_require" checked class="form-control" name="ticket_field_add_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_End+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_agent_require" class="form-control" name="ticket_field_add_agent_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_Agents+'</span>';
                input += '<br>'+js_obj.Enter_Placeholder+'<input type="text" id="ticket_field_add_placeholder" class="form-control crm-form-element-input">';
                var pull_edd = '<button class="button" id="ticket_edd_product_field_add_values_fill" style="margin:0px 10px; vertical-align: baseline;margin-bottom: 10px;">'+js_obj.Auto_fill_products+'</button>';
                input += '<span class="help-block">'+js_obj.Specify_the_Product_values+'! </span>';
                input += '<span class="ticket_field_add_values_span" id=""></span>'+add_value + pull_edd;
                input += '<br>'+js_obj.Enter_Default_Values+'<input type="text" id="ticket_field_add_default" class="form-control crm-form-element-input">';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;   
            case 'woo_vendors':
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_visible" checked class="form-control" name="ticket_field_add_visible" value="yes"> '+js_obj.Yes_This_Field_is_Visible+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_require" checked class="form-control" name="ticket_field_add_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_End+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_agent_require" class="form-control" name="ticket_field_add_agent_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_Agents+'</span>';
                input += '<br>'+js_obj.Enter_Placeholder+'<input type="text" id="ticket_field_add_placeholder" class="form-control crm-form-element-input">';
                var pull_woo = '<button class="button" id="ticket_woo_vendors_field_add_values_fill" style="margin:0px 10px; vertical-align: baseline;margin-bottom: 10px;">'+js_obj.Auto_fill_Vendors+'</button>';
                input += '<span class="help-block">'+js_obj.Specify_the_Vendor+'! </span>';
                input += '<span class="ticket_field_add_values_span" id=""></span>'+pull_woo;
                input += '<br>'+js_obj.Enter_Default_Values+'<input type="text" id="ticket_field_add_default" class="form-control crm-form-element-input">';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
            case 'radio':
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_visible" checked class="form-control" name="ticket_field_add_visible" value="yes"> '+js_obj.Yes_This_Field_is_Visible+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_require" checked class="form-control" name="ticket_field_add_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_End+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_agent_require" class="form-control" name="ticket_field_add_agent_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_Agents+'</span>';
                input += '<span class="help-block">'+js_obj.Specify_the_Radio_values+'! </span>';
                input += '<span id="ticket_field_add_values_span_0" class="ticket_field_add_values_span"><input type="text" id="ticket_field_add_values[0]" placeholder="'+js_obj.Enter_first_value+'" class="form-control ticket_field_add_values crm-form-element-input"></span>' + add_value;
                input += '<br>'+js_obj.Enter_Default_Values+'<input type="text" id="ticket_field_add_default" class="form-control crm-form-element-input">';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
            case 'checkbox':
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_visible" checked class="form-control" name="ticket_field_add_visible" value="yes"> '+js_obj.Yes_This_Field_is_Visible+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_require" checked class="form-control" name="ticket_field_add_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_End+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_agent_require" class="form-control" name="ticket_field_add_agent_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_Agents+'</span>';
                input += '<span class="help-block">'+js_obj.Specify_the_Checkbox_values+'! </span>';
                input += '<span id="ticket_field_add_values_span_0" class="ticket_field_add_values_span"><input type="text" id="ticket_field_add_values[0]" placeholder="'+js_obj.Enter_first_value+'" class="form-control ticket_field_add_values crm-form-element-input"></span>' + add_value;
                input += '<br>'+js_obj.Enter_Default_Values+'<input type="text" id="ticket_field_add_default" class="form-control crm-form-element-input">';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
            case 'select':
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_visible" checked class="form-control" name="ticket_field_add_visible" value="yes"> '+js_obj.Yes_This_Field_is_Visible+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_require" checked class="form-control" name="ticket_field_add_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_End+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_agent_require" class="form-control" name="ticket_field_add_agent_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_Agents+'</span>';
                input += '<br>'+js_obj.Enter_Placeholder+'<input type="text" id="ticket_field_add_placeholder" class="form-control crm-form-element-input">';
                input += '<span class="help-block">'+js_obj.Specify_the_Dropdown_values+'! </span>';
                input += '<span id="ticket_field_add_values_span_0" class="ticket_field_add_values_span"><input type="text" id="ticket_field_add_values[0]" placeholder="'+js_obj.Enter_first_value+'" class="form-control ticket_field_add_values crm-form-element-input"></span>' + add_value;
                input += '<br>'+js_obj.Enter_Default_Values+'<input type="text" id="ticket_field_add_default" class="form-control crm-form-element-input">';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
            case 'textarea':
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_visible" checked class="form-control" name="ticket_field_add_visible" value="yes"> '+js_obj.Yes_This_Field_is_Visible+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_require" checked class="form-control" name="ticket_field_add_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_End+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_agent_require" class="form-control" name="ticket_field_add_agent_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_Agents+'</span>';
                input += '<br>'+js_obj.Enter_Default_Values+'<input type="text" id="ticket_field_add_default" class="form-control crm-form-element-input">';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
            case 'date':
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_visible" checked class="form-control" name="ticket_field_add_visible" value="yes"> '+js_obj.Yes_This_Field_is_Visible+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_require" checked class="form-control" name="ticket_field_add_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_End+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_agent_require" class="form-control" name="ticket_field_add_agent_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_Agents+'</span>';
                input += '<br>'+js_obj.Enter_Placeholder+'<input type="text" id="ticket_field_add_placeholder" class="form-control crm-form-element-input">';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
            case 'file':
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_visible" checked class="form-control" name="ticket_field_add_visible" value="yes"> '+js_obj.Yes_This_Field_is_Visible+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_require" checked class="form-control" name="ticket_field_add_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_End+'</span>';
                input += '<br><span class="help-block">Specify whether this Field is Single or Multiple Attachment </span><input type="radio" style="margin-top: 0;"  id="ticket_field_add_file_type" checked class="form-control" name="ticket_field_add_file_type" value="single"> Single Attachment <br><input type="radio" style="margin-top: 0;" id="ticket_field_add_file_type" class="form-control" name="ticket_field_add_file_type" value="multiple"> Multiple Attachment <br>';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
            case 'ip':
                input += '<span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
            default :
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_visible" checked class="form-control" name="ticket_field_add_visible" value="yes"> '+js_obj.Yes_This_Field_is_Visible+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_require" checked class="form-control" name="ticket_field_add_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_End+'</span>';
                input += '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_add_agent_require" class="form-control" name="ticket_field_add_agent_require" value="yes"> '+js_obj.Yes_This_Field_is_Mandatory_Agents+'</span>';
                input += '<br>'+js_obj.Enter_Placeholder+'<input type="text" id="ticket_field_add_placeholder" class="form-control crm-form-element-input">';
                input +=  js_obj.Enter_Default_Values+'<input type="text" id="ticket_field_add_default" class="form-control crm-form-element-input">';
                input += '<br><span class="help-block">'+js_obj.Want_to_give_some_description_to_this_field+' </span><textarea id="ticket_field_add_description" class="form-control crm-form-element-input" style="padding: 10px !important;"/>';
                break;
        }
        jQuery("#ticket_field_add_append").empty();
        if (val !== '')
        {
            jQuery("#ticket_field_add_append").html(input);
        }
    }).change();

    jQuery("#ticket_fields_tab").on("click", "#ticket_woo_product_field_add_values_fill", function (e) {
        e.preventDefault();
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_woo_product_fetch'
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                var parse = jQuery.parseJSON(data);
                var count = 0;
                jQuery('.ticket_field_add_values_span').each(function(){
                    var currentNum = parseInt(jQuery(this).attr('id').replace('ticket_field_add_values_span_', ''), 10);
                    if(currentNum > count) {
                        count = currentNum;
                    }
                });
                for(var p_id in parse)
                {
                    var html = '<span id="ticket_field_add_values_span_'+(count+1)+'" class="ticket_field_add_values_span"><input type="text" id="ticket_field_add_values[' + (count+1) + ']" placeholder="'+js_obj.Enter_next_value+'" class="form-control ticket_field_add_values crm-form-element-input" style="width:90% !important;" value="'+parse[p_id]+'"><input type="hidden" class="ticket_field_add_values['+(count+1)+']" id="'+p_id+'"><button class="btn btn-warning" title="'+js_obj.Remove_Values+'" id="ticket_field_add_values_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button></span>';
                    jQuery('.ticket_field_add_values_span').last().after(html);
                    count++;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
        jQuery(this).remove();
    });
    
    jQuery("#ticket_fields_tab").on("click", "#ticket_edd_product_field_add_values_fill", function (e) {
        e.preventDefault();
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_get_edd_products',
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                var parse = jQuery.parseJSON(data);
                var count = 0;
                jQuery('.ticket_field_add_values_span').each(function()
                {
                    var currentNum = parseInt(jQuery(this).attr('id').replace('ticket_field_add_values_span_', ''), 10);
                    if(currentNum > count) 
                    {
                        count = currentNum;
                    }
                });
                for(i=0;i<parse.length;i++)
                {
                    var html = '<span id="ticket_field_add_values_span_'+(count+1)+'" class="ticket_field_add_values_span"><input type="text" id="ticket_field_add_values[' + (count+1) + ']" placeholder="'+js_obj.Enter_next_value+'" class="form-control ticket_field_add_values crm-form-element-input" style="width:90% !important;" value="'+parse[i].title+'"><input type="hidden" class="ticket_field_add_values['+(count+1)+']" id="'+parse[i].id+'"><button class="btn btn-warning" title="'+js_obj.Remove_Values+'" id="ticket_field_add_values_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button></span>';
                    jQuery('.ticket_field_add_values_span').last().after(html);
                    count++;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
        jQuery(this).remove();
    });
    jQuery("#ticket_fields_tab").on("click", "#ticket_woo_category_field_add_values_fill", function (e) {
        e.preventDefault();
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_woo_category_fetch'
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                var parse = jQuery.parseJSON(data);
                var count = 0;
                jQuery('.ticket_field_add_values_span').each(function(){
                    var currentNum = parseInt(jQuery(this).attr('id').replace('ticket_field_add_values_span_', ''), 10);
                    if(currentNum > count) {
                        count = currentNum;
                    }
                });
                for(i=0;i<parse.length;i++)
                {
                    var html = '<span id="ticket_field_add_values_span_'+(count+1)+'" class="ticket_field_add_values_span"><input type="text" id="ticket_field_add_values[' + (count+1) + ']" placeholder="'+js_obj.Enter_next_value+'" class="form-control ticket_field_add_values crm-form-element-input" style="width:90% !important;" value="'+parse[i].title+'"><input type="hidden" class="ticket_field_add_values['+(count+1)+']" id="'+parse[i].id+'"><button class="btn btn-warning" title="'+js_obj.Remove_Values+'" id="ticket_field_add_values_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button></span>';
                    jQuery('.ticket_field_add_values_span').last().after(html);
                    count++;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
        jQuery(this).remove();
    });
    jQuery("#ticket_fields_tab").on("click", "#ticket_woo_tags_field_add_values_fill", function (e) {
        e.preventDefault();
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_woo_tags_fetch'
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                var parse = jQuery.parseJSON(data);
                var count = 0;
                jQuery('.ticket_field_add_values_span').each(function(){
                    var currentNum = parseInt(jQuery(this).attr('id').replace('ticket_field_add_values_span_', ''), 10);
                    if(currentNum > count) {
                        count = currentNum;
                    }
                });
                for(i=0;i<parse.length;i++)
                {
                    var html = '<span id="ticket_field_add_values_span_'+(count+1)+'" class="ticket_field_add_values_span"><input type="text" id="ticket_field_add_values[' + (count+1) + ']" placeholder="'+js_obj.Enter_next_value+'" class="form-control ticket_field_add_values crm-form-element-input" style="width:90% !important;" value="'+parse[i].title+'"><input type="hidden" class="ticket_field_add_values['+(count+1)+']" id="'+parse[i].id+'"><button class="btn btn-warning" title="'+js_obj.Remove_Values+'" id="ticket_field_add_values_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button></span>';
                    jQuery('.ticket_field_add_values_span').last().after(html);
                    count++;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
        jQuery(this).remove();
    });
    jQuery("#ticket_fields_tab").on("click", "#ticket_woo_vendors_field_add_values_fill", function (e) {
        e.preventDefault();
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_woo_vendors_fetch'
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                var response = jQuery.parseJSON(data);
                if(response.status === 'roles')
                {
                    parse = response.data;
                    var count = 0;
                    jQuery('.ticket_field_add_values_span').each(function(){
                        var currentNum = parseInt(jQuery(this).attr('id').replace('ticket_field_add_values_span_', ''), 10);
                        if(currentNum > count) {
                            count = currentNum;
                        }
                    });
                    for(i=0;i<parse.length;i++)
                    {
                        var html = '<span id="ticket_field_add_values_span_'+(count+1)+'" class="ticket_field_add_values_span"><input type="text" id="ticket_field_add_values[' + (count+1) + ']" placeholder="'+js_obj.Enter_next_value+'" class="form-control ticket_field_add_values crm-form-element-input" style="width:90% !important;" value="'+parse[i].title+'"><input type="hidden" class="ticket_field_add_values['+(count+1)+']" id="'+parse[i].id+'"><button class="btn btn-warning" title="'+js_obj.Remove_Values+'" id="ticket_field_add_values_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button></span>';
                        jQuery('.ticket_field_add_values_span').last().after(html);
                        count++;
                    }
                }
                else
                {
                    jQuery(".alert-danger").css("display", "block");
                    jQuery(".alert-danger").css("opacity", "1");
                    jQuery("#danger_alert_text").html("<strong>"+js_obj.Ticket_Fields+"</strong><br>"+response.data);
                    window.setTimeout(function () {
                        jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                            jQuery(this).css("display", "none");
                        });
                    }, 4000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
        jQuery(this).remove();
    });
    //Ticket Fields Add new Value for Dropdown Action
    jQuery("#ticket_fields_tab").on("click", "#ticket_field_add_values_add", function (e) {
        e.preventDefault();
        var count = 0;
        jQuery('.ticket_field_add_values_span').each(function(){
            var currentNum = parseInt(jQuery(this).attr('id').replace('ticket_field_add_values_span_', ''), 10);
            if(currentNum > count) {
                count = currentNum;
            }
        });
        var html = '<span id="ticket_field_add_values_span_'+(count+1)+'" class="ticket_field_add_values_span"><input type="text" id="ticket_field_add_values[' + (count+1) + ']" placeholder="'+js_obj.Enter_next_value+'" class="form-control ticket_field_add_values crm-form-element-input" style="width:90% !important;"><input type="hidden" class="ticket_field_add_values[' +(count+1)+ ']_old" id="new_add_' +(count+1)+ '"><button class="btn btn-warning" title="'+js_obj.Remove_Values+'" id="ticket_field_add_values_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button></span>';
        jQuery('.ticket_field_add_values_span').last().after(html);
    });

    //Ticket Fields removing last Value for Dropdown Action
    jQuery("#ticket_fields_tab").on("click", "#ticket_field_add_values_remove", function (e) {
        e.preventDefault();
        if (jQuery('.ticket_field_add_values_span').length !== 1)
        {
            jQuery(this).parent('span').remove();
        }
    });

    //Ticket Fields Edit new Value for Dropdown Action
    jQuery("#ticket_fields_tab").on("click", "#ticket_field_edit_values_add", function (e) {
        e.preventDefault();
        var count = 0;
        jQuery('.ticket_field_edit_values_span').each(function(){
            var currentNum = parseInt(jQuery(this).attr('id').replace('ticket_field_edit_values_span_', ''), 10);
            if(currentNum > count) {
                count = currentNum;
            }
        });
        var html = '<span id="ticket_field_edit_values_span_'+(count+1)+'" class="ticket_field_edit_values_span"><input type="text" id="ticket_field_edit_values[' + (count+1) + ']" placeholder="'+js_obj.Enter_next_value+'" class="form-control ticket_field_edit_values crm-form-element-input" style="width:90% !important;"><input type="hidden" class="ticket_field_edit_values[' +(count+1)+ ']_old" id="new_edit_' +(count+1)+ '"><button class="btn btn-warning" title="'+js_obj.Remove_Values+'" id="ticket_field_edit_values_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button></span>';
        jQuery('.ticket_field_edit_values_span').last().after(html);
    });

    //Ticket Fields EDit removing last Value for Dropdown Action
    jQuery("#ticket_fields_tab").on("click", "#ticket_field_edit_values_remove", function (e) {
        e.preventDefault();
        if (jQuery('.ticket_field_edit_values_span').length !== 1)
        {
            jQuery(this).parent('span').remove();
        }
    });

    //Ticket Labels Settings Section All Events
    //Save Ticket Labels Action
    jQuery("#ticket_labels_tab").on("click", "#save_ticket_labels", function (e) {
        e.preventDefault();
        var new_label = {};
        var edit_label = {};
        if (jQuery("#add_new_label_yes").val() === "yes")
        {
            if(jQuery("#ticket_label_add_title").val() === "")
            {
                jQuery(".loader").css("display", "none");
                jQuery("#ticket_label_add_title").css("border","1px solid red");
                jQuery(".alert-danger").css("display", "block");
                jQuery(".alert-danger").css("opacity", "1");
                jQuery("#danger_alert_text").html("<strong>"+js_obj.Add_Ticket_Label+"</strong><br>"+js_obj.Enter_title_for_the_Label+"!");
                window.setTimeout(function () {
                    jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery('html, body').animate({
                    scrollTop: jQuery("#ticket_labels_tab").offset().top
                }, 1000);
                return false;
            }
            new_label['title'] = jQuery("#ticket_label_add_title").val();
            new_label['color'] = jQuery("#ticket_label_add_color").val();
            new_label['filter'] = jQuery("input[name='ticket_label_add_filter']:checked").val();
        }
        if (jQuery("#ticket_label_edit_type").val() !== "")
        {
            edit_label['slug'] = jQuery("#ticket_label_edit_type").val();
            edit_label['title'] = jQuery("#ticket_label_edit_title").val();
            edit_label['color'] = jQuery("#ticket_label_edit_color").val();
            edit_label['filter'] = jQuery("input[name='ticket_label_edit_filter']:checked").val();
        }
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_label',
                new_label: JSON.stringify(new_label),
                edit_label: JSON.stringify(edit_label)
            },
            success: function (data) {
                var response = jQuery.parseJSON(data);
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Ticket_Label+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#ticket_labels_tab").html(response.labels);
                label_tab_load();
                jQuery("#ticket_views_tab").html(response.views);
                view_tab_load();
                jQuery("#triggers_tab").html(response.triggers);
                trigger_tab_load();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#ticket_labels_tab").on("click", ".ticket_label_delete_type", function (e) {
        var label_id = jQuery(this).prop("id");
        BootstrapDialog.show({
            title: "WSDesk Alert",
            message: 'Do you want to delete the status?',
            cssClass: 'wsdesk_wrapper',
            buttons: [{
                    label: 'Yes! Delete',
                    // no title as it is optional
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        jQuery(".loader").css("display", "block");
                        jQuery.ajax({
                            type: 'post',
                            url: ajaxurl,
                            data: {
                                action: 'eh_crm_ticket_label_delete',
                                label_remove: label_id
                            },
                            success: function (data) {
                                var response = jQuery.parseJSON(data);
                                jQuery(".loader").css("display", "none");
                                jQuery(".alert-success").css("display", "block");
                                jQuery(".alert-success").css("opacity", "1");
                                jQuery("#success_alert_text").html("<strong>Ticket Status</strong><br>Updated and Saved Successfully!");
                                window.setTimeout(function () {
                                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                        jQuery(this).css("display", "none");
                                    });
                                }, 4000);
                                jQuery("#ticket_labels_tab").html(response.labels);
                                label_tab_load();
                                jQuery("#ticket_views_tab").html(response.views);
                                view_tab_load();
                                jQuery("#triggers_tab").html(response.triggers);
                                trigger_tab_load();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
                        dialogItself.close();
                    }
                }, {
                    label: 'Close',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    });
    //Edit Ticket Label Action
    jQuery("#ticket_labels_tab").on("click", ".ticket_label_edit_type", function (e) {
        e.preventDefault();
        var label = jQuery(this).prop("id");
        jQuery("#add_new_label_yes").val("no");
        jQuery("#ticket_label_edit_type").val(label);
            jQuery(".loader").css("display", "block");
            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_ticket_label_edit',
                    label: label
                },
                success: function (data) {
                    jQuery(".loader").css("display", "none");
                jQuery("#ticket_label_edit_display").slideDown(10).show();
                jQuery("#ticket_label_add_display").slideUp(10).hide();
                    jQuery("#ticket_label_edit_append").empty();
                    jQuery("#ticket_label_edit_append").html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
    });
    //Add New Ticket Labels Action
    jQuery("#ticket_labels_tab").on("click", "#ticket_label_add_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_label_edit_display").slideUp(10).hide();
        jQuery("#ticket_label_add_display").slideDown(10).show();
        jQuery("#add_new_label_yes").val("yes");
        jQuery("#ticket_label_edit_type").val("");
    });
    jQuery("#ticket_labels_tab").on("click", "#ticket_label_cancel_add_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_label_add_display").slideUp().hide();
        jQuery("#add_new_label_yes").val("no");
    });
    jQuery("#ticket_labels_tab").on("click", "#ticket_label_cancel_edit_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_label_edit_display").slideUp().hide();
        jQuery("#ticket_label_edit_type").val("");
    });
    //Ticket Tags Settings Section All Events
    //Save Ticket Tags Action
    jQuery("#ticket_tags_tab").on("click", "#save_ticket_tags", function (e) {
        e.preventDefault();
        jQuery(".loader").css("display", "block");
        var new_tag = {};
        var edit_tag = {};
        if (jQuery("#add_new_tag_yes").val() === "yes") {
            if(jQuery("#ticket_tag_add_title").val() === "")
            {
                jQuery(".loader").css("display", "none");
                jQuery("#ticket_tag_add_title").css("border","1px solid red");
                jQuery(".alert-danger").css("display", "block");
                jQuery(".alert-danger").css("opacity", "1");
                jQuery("#danger_alert_text").html("<strong>"+js_obj.Add_Ticket_Tag+"</strong><br>"+js_obj.Enter_title_for_the_Tag+"!");
                window.setTimeout(function () {
                    jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery('html, body').animate({
                    scrollTop: jQuery("#ticket_tags_tab").offset().top
                }, 1000);
                return false;
            }
            new_tag["title"] = jQuery("#ticket_tag_add_title").val();
            new_tag["posts"] = jQuery(".ticket_tag_add_posts").val();
            new_tag["filter"] = jQuery("input[name='ticket_tag_add_filter']:checked").val()
        }
        if (jQuery("#ticket_tag_edit_type").val() !== "")
        {
            edit_tag['slug'] = jQuery("#ticket_tag_edit_type").val();
            edit_tag['title'] = jQuery("#ticket_tag_edit_title").val();
            edit_tag['posts'] = jQuery(".ticket_tag_edit_posts").val();
            edit_tag['filter'] = jQuery("input[name='ticket_tag_edit_filter']:checked").val();
        }
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_tag',
                new_tag: JSON.stringify(new_tag),
                edit_tag: JSON.stringify(edit_tag)
            },
            success: function (data) {
                var response = jQuery.parseJSON(data);
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Ticket_Tags+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#ticket_tags_tab").html(response.tags);
                tag_tab_load();
                jQuery("#ticket_views_tab").html(response.views);
                view_tab_load();
                jQuery("#triggers_tab").html(response.triggers);
                trigger_tab_load();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#ticket_tags_tab").on("click", ".ticket_tag_edit_type", function (e) {
        e.preventDefault();
        var tag = jQuery(this).prop("id");
        jQuery("#add_new_tag_yes").val("no");
        jQuery("#ticket_tag_edit_type").val(tag);
            jQuery(".loader").css("display", "block");
            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_ticket_tag_edit',
                    tag: tag
                },
                success: function (data) {
                    jQuery(".loader").css("display", "none");
                jQuery("#ticket_tag_edit_display").slideDown(10).show();
                jQuery("#ticket_tag_add_display").slideUp(10).hide();
                    jQuery("#ticket_tag_edit_append").empty();
                    jQuery("#ticket_tag_edit_append").html(data);
                    tag_tab_edit_load();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
    });

    jQuery("#ticket_tags_tab").on("click", "#ticket_tag_add_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_tag_edit_display").slideUp(10).hide();
        jQuery("#ticket_tag_add_display").slideDown(10).show();
        jQuery("#add_new_tag_yes").val("yes");
        jQuery("#ticket_tag_edit_type").val("");
    });
    jQuery("#ticket_tags_tab").on("click", "#ticket_tag_cancel_add_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_tag_add_display").slideUp().hide();
        jQuery("#add_new_tag_yes").val("no");
    });
    jQuery("#ticket_tags_tab").on("click", "#ticket_tag_cancel_edit_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_tag_edit_display").slideUp().hide();
        jQuery("#ticket_tag_edit_type").val("");
    });
    jQuery("#ticket_tags_tab").on("click", ".ticket_tag_delete_type", function (e) {
        var tag_id = jQuery(this).prop("id");
        BootstrapDialog.show({
            title: "WSDesk Alert",
            message: 'Do you want to delete the tag?',
            cssClass: 'wsdesk_wrapper',
            buttons: [{
                    label: 'Yes! Delete',
                    // no title as it is optional
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        jQuery(".loader").css("display", "block");
                        jQuery.ajax({
                            type: 'post',
                            url: ajaxurl,
                            data: {
                                action: 'eh_crm_ticket_tag_delete',
                                tag_remove: tag_id
                            },
                            success: function (data) {
                                var response = jQuery.parseJSON(data);
                                jQuery(".loader").css("display", "none");
                                jQuery(".alert-success").css("display", "block");
                                jQuery(".alert-success").css("opacity", "1");
                                jQuery("#success_alert_text").html("<strong>"+js_obj.Ticket_Tags+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                                window.setTimeout(function () {
                                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                        jQuery(this).css("display", "none");
                                    });
                                }, 4000);
                                jQuery("#ticket_tags_tab").html(response.tags);
                                tag_tab_load();
                                jQuery("#ticket_views_tab").html(response.views);
                                view_tab_load();
                                jQuery("#triggers_tab").html(response.triggers);
                                trigger_tab_load();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
                        dialogItself.close();
                    }
                }, {
                    label: 'Close',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    });
    
    //Add New Ticket View Conditions Action
    jQuery("#ticket_views_tab").on("click","#ticket_view_add_conditions_add",function(){
        var count = 0;
        jQuery('.specify_conditions').each(function(){
            var currentNum = parseInt(jQuery(this).attr('id').replace('conditions_', ''), 10);
            if(currentNum > count) {
                count = currentNum;
            }
        });
        var html = '<div id="conditions_'+(count+1)+'" class="specify_conditions">';
                html+= '<span class="condition_title_span">'+js_obj.Condition+' '+(count+1)+'</span>';
                html+= '<select id="conditions_'+(count+1)+'_type" title="'+js_obj.View_condition_field+'" style="width: 90% !important;display: inline !important" class="form-control conditions_type clickable" aria-describedby="helpBlock">';
                html+= jQuery("#conditions_1_type").html();
                html+= '</select>';
                html+= '<button class="btn btn-warning" title="'+js_obj.Remove_Condition+'" id="ticket_view_add_conditions_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button>';
                html+= '<div id="conditions_'+(count+1)+'_append"></div>';
            html+= '</div>';
        jQuery("#conditions_all").append(html);
        jQuery("#ticket_view_formula").html(get_view_formula());
    });
    
    //Remove New Ticket View Conditions Action
    jQuery("#ticket_views_tab").on("click","#ticket_view_add_conditions_remove",function(){
        jQuery(this).parent().remove();
        jQuery("#ticket_view_formula").html(get_view_formula());
    });
    
    //Group with And Conditions Action
    jQuery("#ticket_views_tab").on("click","#ticket_view_add_conditions_group_and",function(){
        jQuery(".specify_conditions").not(".grouped").each(function () {
            var id=jQuery(this).prop("id");
            if(jQuery(".and_grouped").length !== 0)
            {
                jQuery("#"+id).insertAfter(jQuery("#conditions_all > .and_grouped").last());
            }
            jQuery("#"+id).css("background-color","skyblue");
            jQuery(this).addClass("and_grouped");
            jQuery(this).addClass("grouped");
            jQuery("#ticket_view_formula").html(get_view_formula());
        });
    });
    
    //Group with OR Conditions Action
    jQuery("#ticket_views_tab").on("click","#ticket_view_add_conditions_group_or",function(){
        jQuery(".specify_conditions").not(".grouped").each(function () {
            var id=jQuery(this).prop("id");
            if(jQuery(".or_grouped").length !== 0)
            {
                jQuery("#"+id).insertAfter(jQuery("#conditions_all > .or_grouped").last());
            }
            jQuery("#"+id).css("background-color","darkseagreen");
            jQuery(this).addClass("or_grouped");
            jQuery(this).addClass("grouped");
            jQuery("#ticket_view_formula").html(get_view_formula());
        });
    });
    //Group with OR Conditions Action
    jQuery("#ticket_views_tab").on("click","#ticket_view_add_conditions_group_clear",function(){
        jQuery(".specify_conditions").each(function () {
            var id=jQuery(this).prop("id");
            jQuery("#"+id).css("background-color","");
            jQuery(this).removeClass("or_grouped");
            jQuery(this).removeClass("and_grouped");
            jQuery(this).removeClass("grouped");
            jQuery("#ticket_view_formula").html(get_view_formula());
        });
    });
    
    //Add New Ticket View Conditions Action
    jQuery("#ticket_views_tab").on("click","#ticket_view_edit_conditions_add",function(){
        var count = 0;
        jQuery('.edit_specify_conditions').each(function(){
            var currentNum = parseInt(jQuery(this).attr('id').replace('edit_conditions_', ''), 10);
            if(currentNum > count) {
                count = currentNum;
            }
        });
        var html = '<div id="edit_conditions_'+(count+1)+'" class="edit_specify_conditions">';
                html+= '<span class="edit_condition_title_span">'+js_obj.Condition+' '+(count+1)+'</span>';
                html+= '<select id="edit_conditions_'+(count+1)+'_type" title="'+js_obj.View_condition_field+'" style="width: 90% !important;display: inline !important" class="form-control edit_conditions_type clickable" aria-describedby="helpBlock">';
                html+= jQuery("#conditions_1_type").html();
                html+= '</select>';
                html+= '<button class="btn btn-warning" title="'+js_obj.Remove_Condition+'" id="ticket_view_edit_conditions_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button>';
                html+= '<div id="edit_conditions_'+(count+1)+'_append"></div>';
            html+= '</div>';
        jQuery("#edit_conditions_all").append(html);
    });
    
    //Remove New Ticket View Conditions Action
    jQuery("#ticket_views_tab").on("click","#ticket_view_edit_conditions_remove",function(){
        jQuery(this).parent().remove();
    });
    
    //Group with And Conditions Action
    jQuery("#ticket_views_tab").on("click","#ticket_view_edit_conditions_group_and",function(){
        jQuery(".edit_specify_conditions").not(".grouped").each(function () {
            var id=jQuery(this).prop("id");
            if(jQuery(".and_grouped").length !== 0)
            {
                jQuery("#"+id).insertAfter(jQuery("#edit_conditions_all > .and_grouped").last());
            }
            jQuery("#"+id).css("background-color","skyblue");
            jQuery(this).addClass("and_grouped");
            jQuery(this).addClass("grouped");
        });
    });
    
    //Group with OR Conditions Action
    jQuery("#ticket_views_tab").on("click","#ticket_view_edit_conditions_group_or",function(){
        jQuery(".edit_specify_conditions").not(".grouped").each(function () {
            var id=jQuery(this).prop("id");
            if(jQuery(".or_grouped").length !== 0)
            {
                jQuery("#"+id).insertAfter(jQuery("#edit_conditions_all > .or_grouped").last());
            }
            jQuery("#"+id).css("background-color","darkseagreen");
            jQuery(this).addClass("or_grouped");
            jQuery(this).addClass("grouped");
        });
    });
    //Group with OR Conditions Action
    jQuery("#ticket_views_tab").on("click","#ticket_view_edit_conditions_group_clear",function(){
        jQuery(".edit_specify_conditions").each(function () {
            var id=jQuery(this).prop("id");
            jQuery("#"+id).css("background-color","");
            jQuery(this).removeClass("or_grouped");
            jQuery(this).removeClass("and_grouped");
            jQuery(this).removeClass("grouped");
        });
    });
    
    //View Section all action
    //Add New Ticket View Action
    jQuery("#ticket_views_tab").on("click", "#ticket_view_add_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_view_edit_display").slideUp().hide();
        jQuery("#ticket_view_add_display").slideDown().show();
        jQuery("#add_new_view_yes").val("yes");
        jQuery("#ticket_view_edit_type").val("");
    });
    jQuery("#ticket_views_tab").on("click", "#ticket_view_cancel_add_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_view_add_display").slideUp().hide();
        jQuery("#add_new_view_yes").val("no");
    });
    jQuery("#ticket_views_tab").on("click", "#ticket_view_cancel_edit_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_view_edit_display").slideUp().hide();
        jQuery("#ticket_view_edit_type").val("");
    });
    //Save Ticket view Action
    jQuery("#ticket_views_tab").on("click", "#save_ticket_views", function (e) {
        e.preventDefault();
        var selected_views = jQuery(".list-group-view-data li[id]")
                .map(function () {
                    return this.id;
                }).get();
        var new_view = {};
        var edit_view = {};
        if (jQuery("#add_new_view_yes").val() === "yes") {
            if(jQuery("#ticket_view_add_title").val() === "")
            {
                jQuery(".loader").css("display", "none");
                jQuery("#ticket_view_add_title").css("border","1px solid red");
                jQuery(".alert-danger").css("display", "block");
                jQuery(".alert-danger").css("opacity", "1");
                jQuery("#danger_alert_text").html("<strong>Add Ticket View</strong><br>Enter title for the View!");
                window.setTimeout(function () {
                    jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery('html, body').animate({
                    scrollTop: jQuery("#ticket_views_tab").offset().top
                }, 1000);
                return false;
            }
            new_view["title"] = jQuery("#ticket_view_add_title").val();
            new_view["format"]= jQuery("#ticket_view_add_format").val();
            new_view["group"]= jQuery("#group_by_view_add").val();
            new_view["access"]= getValue_checkbox_values("ticket_view_display_control");
            var condi_val = {};
            var and = [];
            var or = [];
            var ungroup = [];
            jQuery(".specify_conditions").each(function () {
                var values = {};
                var div_id = jQuery(this).prop("id");
                if(jQuery(this).hasClass("grouped"))
                {
                    if(jQuery("#"+div_id+"_type").val()!=="")
                    {
                        values['type'] = jQuery("#"+div_id+"_type").val();
                        values['operator'] = jQuery("#"+div_id+"_operator").val();
                        values['value'] = jQuery("#"+div_id+"_value").val();
                        if(jQuery(this).hasClass("and_grouped"))
                        {
                            and.push(values);
                        }
                        if(jQuery(this).hasClass("or_grouped"))
                        {
                            or.push(values);
                        }
                    }
                }
                else
                {
                    if(jQuery("#"+div_id+"_type").val()!=="")
                    {
                        values['type'] = jQuery("#"+div_id+"_type").val();
                        values['operator'] = jQuery("#"+div_id+"_operator").val();
                        values['value'] = jQuery("#"+div_id+"_value").val();
                        ungroup.push(values);
                    }
                }
            });
            if(ungroup.length !== 0)
            {
                condi_val['ungroup'] = ungroup;
            }
            if(and.length !== 0)
            {
                condi_val['and'] = and;
            }
            if(or.length !== 0)
            {
                condi_val['or'] = or;
            }
            new_view['conditions'] = condi_val;
        }
        if (jQuery("#ticket_view_edit_type").val() !== "")
        {
            if(jQuery("#ticket_view_edit_title").val() === "")
            {
                jQuery(".loader").css("display", "none");
                jQuery("#ticket_view_edit_title").css("border","1px solid red");
                jQuery(".alert-danger").css("display", "block");
                jQuery(".alert-danger").css("opacity", "1");
                jQuery("#danger_alert_text").html("<strong>Edit Ticket View</strong><br>Enter title for the View!");
                window.setTimeout(function () {
                    jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery('html, body').animate({
                    scrollTop: jQuery("#ticket_views_tab").offset().top
                }, 1000);
                return false;
            }
            edit_view['slug'] = jQuery("#ticket_view_edit_type").val();
            edit_view["title"] = jQuery("#ticket_view_edit_title").val();
            edit_view["format"]= jQuery("#ticket_view_edit_format").val();
            edit_view["group"]= jQuery("#group_by_view_edit").val();
            edit_view["access"]= getValue_checkbox_values("ticket_view_display_control_edit");
            var condi_val = {};
            var and = [];
            var or = [];
            var ungroup = [];
            jQuery(".edit_specify_conditions").each(function () {
                var values = {};
                var div_id = jQuery(this).prop("id");
                if(jQuery(this).hasClass("grouped"))
                {
                    if(jQuery("#"+div_id+"_type").val()!=="")
                    {
                        values['type'] = jQuery("#"+div_id+"_type").val();
                        values['operator'] = jQuery("#"+div_id+"_operator").val();
                        values['value'] = jQuery("#"+div_id+"_value").val();
                        if(jQuery(this).hasClass("and_grouped"))
                        {
                            and.push(values);
                        }
                        if(jQuery(this).hasClass("or_grouped"))
                        {
                            or.push(values);
                        }
                    }
                }
                else
                {
                    if(jQuery("#"+div_id+"_type").val()!=="")
                    {
                        values['type'] = jQuery("#"+div_id+"_type").val();
                        values['operator'] = jQuery("#"+div_id+"_operator").val();
                        values['value'] = jQuery("#"+div_id+"_value").val();
                        ungroup.push(values);
                    }
                }
            });
            if(ungroup.length !== 0)
            {
                condi_val['ungroup'] = ungroup;
            }
            if(and.length !== 0)
            {
                condi_val['and'] = and;
            }
            if(or.length !== 0)
            {
                condi_val['or'] = or;
            }
            edit_view['conditions'] = condi_val;
        }
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_view',
                selected_views: (selected_views !== null) ? selected_views.join(",") : '',
                new_view: JSON.stringify(new_view),
                edit_view: JSON.stringify(edit_view)
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Ticket_Views+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#ticket_views_tab").html(data);
                view_tab_load();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#ticket_views_tab").on("click", ".ticket_view_edit_type", function (e) {
        e.preventDefault();
        var view = jQuery(this).prop("id");
        jQuery("#add_new_view_yes").val("no");
        jQuery("#ticket_view_edit_type").val(view);
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_view_edit',
                view: view
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery("#ticket_view_edit_display").slideDown().show();
                jQuery("#ticket_view_add_display").slideUp().hide();
                jQuery("#ticket_view_edit_append").empty();
                jQuery("#ticket_view_edit_append").html(data);
                jQuery(".trigger_select2").each(function () {
                    var id=jQuery(this).prop("id");
                    jQuery('#'+id).select2({
                        width: '100%',
                        allowClear: true,
                        placeholder: js_obj.Select_Condition_Values,
                        formatNoMatches: function () {
                            return js_obj.No_Values_Found;
                        },
                        language: {
                            noResults: function (params) {
                                return js_obj.No_Values_Found;
                            }
                        }
                    });
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#ticket_views_tab").on("click", ".ticket_view_delete_type", function (e) {
        var view_id = jQuery(this).prop("id");
        BootstrapDialog.show({
            title: "WSDesk Alert",
            message: 'Do you want to delete the view?',
            cssClass: 'wsdesk_wrapper',
            buttons: [{
                    label: 'Yes! Delete',
                    // no title as it is optional
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        jQuery(".loader").css("display", "block");
                        jQuery.ajax({
                            type: 'post',
                            url: ajaxurl,
                            data: {
                                action: 'eh_crm_ticket_view_delete',
                                view_remove: view_id
                            },
                            success: function (data) {
                                jQuery(".loader").css("display", "none");
                                jQuery(".alert-success").css("display", "block");
                                jQuery(".alert-success").css("opacity", "1");
                                jQuery("#success_alert_text").html("<strong>"+js_obj.Ticket_Views+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                                window.setTimeout(function () {
                                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                        jQuery(this).css("display", "none");
                                    });
                                }, 4000);
                                jQuery("#ticket_views_tab").html(data);
                                view_tab_edit_load();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
                        dialogItself.close();
                    }
                }, {
                    label: 'Close',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    });
    jQuery("#ticket_views_tab").on("click", ".ticket_view_activate", function (e) {
        var view_id = jQuery(this).prop("id");
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_view_activate_deactivate',
                view_id: view_id,
                type:'activate'
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Ticket_Views+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#ticket_views_tab").html(data);
                view_tab_load();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#ticket_views_tab").on("click", ".ticket_view_deactivate", function (e) {
        var view_id = jQuery(this).prop("id");
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_view_activate_deactivate',
                view_id: view_id,
                type:'deactivate'
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Ticket_Views+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#ticket_views_tab").html(data);
                view_tab_load();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    //Trigger Section all action
    //Add New Trigger Action
    jQuery("#triggers_tab").on("click", "#ticket_trigger_add_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_trigger_edit_display").slideUp().hide();
        jQuery("#ticket_trigger_add_display").slideDown().show();
        jQuery("#add_new_trigger_yes").val("yes");
        jQuery("#trigger_edit_type").val("");
    });
    jQuery("#triggers_tab").on("click", "#ticket_trigger_cancel_add_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_trigger_add_display").slideUp().hide();
        jQuery("#add_new_trigger_yes").val("no");
    });
    jQuery("#triggers_tab").on("click", "#ticket_trigger_cancel_edit_button", function (e) {
        e.preventDefault();
        jQuery("#ticket_trigger_edit_display").slideUp().hide();
        jQuery("#trigger_edit_type").val("");
    });
    jQuery("#triggers_tab").on("click", ".ticket_trigger_activate", function (e) {
        var trigger_id = jQuery(this).prop("id");
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_trigger_activate_deactivate',
                trigger_id: trigger_id,
                type:'activate'
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Triggers+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#triggers_tab").html(data);
                trigger_tab_load();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#triggers_tab").on("click", ".ticket_trigger_deactivate", function (e) {
        var trigger_id = jQuery(this).prop("id");
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_trigger_activate_deactivate',
                trigger_id: trigger_id,
                type:'deactivate'
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Triggers+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#triggers_tab").html(data);
                trigger_tab_load();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#triggers_tab").on("click", ".ticket_trigger_delete_type", function (e) {
        var trigger_id = jQuery(this).prop("id");
        BootstrapDialog.show({
            title: "WSDesk Alert",
            message: 'Do you want to delete the trigger?',
            cssClass: 'wsdesk_wrapper',
            buttons: [{
                    label: 'Yes! Delete',
                    // no title as it is optional
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        jQuery(".loader").css("display", "block");
                        jQuery.ajax({
                            type: 'post',
                            url: ajaxurl,
                            data: {
                                action: 'eh_crm_ticket_trigger_delete',
                                trigger_remove: trigger_id
                            },
                            success: function (data) {
                                jQuery(".loader").css("display", "none");
                                jQuery(".alert-success").css("display", "block");
                                jQuery(".alert-success").css("opacity", "1");
                                jQuery("#success_alert_text").html("<strong>"+js_obj.Triggers+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                                window.setTimeout(function () {
                                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                        jQuery(this).css("display", "none");
                                    });
                                }, 4000);
                                jQuery("#triggers_tab").html(data);
                                trigger_tab_load();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
                        dialogItself.close();
                    }
                }, {
                    label: 'Close',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    });
    //Add New Trigger Conditions Action
    jQuery("#triggers_tab").on("click","#trigger_add_tconditions_add",function(){
        var count = 0;
        jQuery('.specify_tconditions').each(function(){
            var currentNum = parseInt(jQuery(this).attr('id').replace('tconditions_', ''), 10);
            if(currentNum > count) {
                count = currentNum;
            }
        });
        var html = '<div id="tconditions_'+(count+1)+'" class="specify_tconditions">';
                html+= '<span class="tcondition_title_span">'+js_obj.Condition+' '+(count+1)+'</span>';
                html+= '<select id="tconditions_'+(count+1)+'_type" title="'+js_obj.Trigger_condition_field+'" style="width: 90% !important;display: inline !important" class="form-control tconditions_type clickable" aria-describedby="helpBlock">';
                html+= jQuery("#tconditions_1_type").html();
                html+= '</select>';
                html+= '<button class="btn btn-warning" title="'+js_obj.Remove_Condition+'" id="trigger_add_tconditions_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button>';
                html+= '<div id="tconditions_'+(count+1)+'_append"></div>';
            html+= '</div>';
        jQuery("#tconditions_all").append(html);
        jQuery("#trigger_formula").html(get_trigger_formula());
    });
    
    //Remove New Ticket Trigger Conditions Action
    jQuery("#triggers_tab").on("click","#trigger_add_tconditions_remove",function(){
        jQuery(this).parent().remove();
        jQuery("#trigger_formula").html(get_trigger_formula());
    });
    
    //Group with And Conditions Action
    jQuery("#triggers_tab").on("click","#trigger_add_tconditions_group_and",function(){
        jQuery(".specify_tconditions").not(".tgrouped").each(function () {
            var id=jQuery(this).prop("id");
            if(jQuery(".and_tgrouped").length !== 0)
            {
                jQuery("#"+id).insertAfter(jQuery("#tconditions_all > .and_tgrouped").last());
            }
            jQuery("#"+id).css("background-color","skyblue");
            jQuery(this).addClass("and_tgrouped");
            jQuery(this).addClass("tgrouped");
            jQuery("#trigger_formula").html(get_trigger_formula());
        });
    });
    
    //Group with OR Conditions Action
    jQuery("#triggers_tab").on("click","#trigger_add_tconditions_group_or",function(){
        jQuery(".specify_tconditions").not(".tgrouped").each(function () {
            var id=jQuery(this).prop("id");
            if(jQuery(".or_tgrouped").length !== 0)
            {
                jQuery("#"+id).insertAfter(jQuery("#tconditions_all > .or_tgrouped").last());
            }
            jQuery("#"+id).css("background-color","darkseagreen");
            jQuery(this).addClass("or_tgrouped");
            jQuery(this).addClass("tgrouped");
            jQuery("#trigger_formula").html(get_trigger_formula());
        });
    });
    //Group with OR Conditions Action
    jQuery("#triggers_tab").on("click","#trigger_add_tconditions_group_clear",function(){
        jQuery(".specify_tconditions").each(function () {
            var id=jQuery(this).prop("id");
            jQuery("#"+id).css("background-color","");
            jQuery(this).removeClass("or_tgrouped");
            jQuery(this).removeClass("and_tgrouped");
            jQuery(this).removeClass("tgrouped");
            jQuery("#trigger_formula").html(get_trigger_formula());
        });
    });
    
    jQuery("#triggers_tab").on("change", "#trigger_add_schedule", function (e) {
        e.preventDefault();
        if (jQuery(this).val()!=="") {
            var name = jQuery(this).val();
            var html = '<span class="help-block">'+js_obj.Enter_Period_for_New_Trigger+' </span><input type="number" id="trigger_add_period" placeholder="How much '+name+'" class="form-control crm-form-element-input" value="1">';
            jQuery("#trigger_schedule_append").html(html);
        } else {
            jQuery("#trigger_schedule_append").empty();
        }
    });
    
    jQuery("#triggers_tab").on("change", "#trigger_edit_schedule", function (e) {
        e.preventDefault();
        if (jQuery(this).val()!=="") {
            var name = jQuery(this).val();
            var html = '<span class="help-block">'+js_obj.Edit_Period_for_the_Trigger+' </span><input type="number" id="trigger_edit_period" placeholder="How much '+name+'" class="form-control crm-form-element-input" value="1">';
            jQuery("#trigger_schedule_append_edit").html(html);
        } else {
            jQuery("#trigger_schedule_append_edit").empty();
        }
    });
    //Edit Section of Trigger all actions
    //
    //
    //
    //Add New Ticket Trigger Conditions Action
    jQuery("#triggers_tab").on("click","#trigger_edit_tconditions_add",function(){
        var count = 0;
        jQuery('.edit_specify_tconditions').each(function(){
            var currentNum = parseInt(jQuery(this).attr('id').replace('edit_tconditions_', ''), 10);
            if(currentNum > count) {
                count = currentNum;
            }
        });
        var html = '<div id="edit_tconditions_'+(count+1)+'" class="edit_specify_tconditions">';
                html+= '<span class="edit_tcondition_title_span">'+js_obj.Condition+' '+(count+1)+'</span>';
                html+= '<select id="edit_tconditions_'+(count+1)+'_type" title="'+js_obj.Trigger_condition_field+'" style="width: 90% !important;display: inline !important" class="form-control edit_tconditions_type clickable" aria-describedby="helpBlock">';
                html+= jQuery("#tconditions_1_type").html();
                html+= '</select>';
                html+= '<button class="btn btn-warning" title="'+js_obj.Remove_Condition+'" id="trigger_edit_tconditions_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button>';
                html+= '<div id="edit_tconditions_'+(count+1)+'_append"></div>';
            html+= '</div>';
        jQuery("#edit_tconditions_all").append(html);
    });
    
    //Remove New Ticket Trigger Conditions Action
    jQuery("#triggers_tab").on("click","#trigger_edit_tconditions_remove",function(){
        jQuery(this).parent().remove();
    });
    
    //Group with And Conditions Action
    jQuery("#triggers_tab").on("click","#trigger_edit_tconditions_group_and",function(){
        jQuery(".edit_specify_tconditions").not(".tgrouped").each(function () {
            var id=jQuery(this).prop("id");
            if(jQuery(".and_tgrouped").length !== 0)
            {
                jQuery("#"+id).insertAfter(jQuery("#edit_tconditions_all > .and_tgrouped").last());
            }
            jQuery("#"+id).css("background-color","skyblue");
            jQuery(this).addClass("and_tgrouped");
            jQuery(this).addClass("tgrouped");
        });
    });
    
    //Group with OR Conditions Action
    jQuery("#triggers_tab").on("click","#trigger_edit_tconditions_group_or",function(){
        jQuery(".edit_specify_tconditions").not(".tgrouped").each(function () {
            var id=jQuery(this).prop("id");
            if(jQuery(".or_tgrouped").length !== 0)
            {
                jQuery("#"+id).insertAfter(jQuery("#edit_tconditions_all > .or_tgrouped").last());
            }
            jQuery("#"+id).css("background-color","darkseagreen");
            jQuery(this).addClass("or_tgrouped");
            jQuery(this).addClass("tgrouped");
        });
    });
    //Group with OR Conditions Action
    jQuery("#triggers_tab").on("click","#trigger_edit_tconditions_group_clear",function(){
        jQuery(".edit_specify_tconditions").each(function () {
            var id=jQuery(this).prop("id");
            jQuery("#"+id).css("background-color","");
            jQuery(this).removeClass("or_tgrouped");
            jQuery(this).removeClass("and_tgrouped");
            jQuery(this).removeClass("tgrouped");
        });
    });
    
    //Save Trigger Action
    jQuery("#triggers_tab").on("click", "#save_triggers", function (e) {
        e.preventDefault();
        var new_trigger = {};
        var edit_trigger = {};
        if (jQuery("#add_new_trigger_yes").val() === 'yes') {
            if(jQuery("#trigger_add_title").val() === "")
            {
                jQuery(".loader").css("display", "none");
                jQuery("#trigger_add_title").css("border","1px solid red");
                jQuery(".alert-danger").css("display", "block");
                jQuery(".alert-danger").css("opacity", "1");
                jQuery("#danger_alert_text").html("<strong>"+js_obj.Add_Trigger+"</strong><br>"+js_obj.Enter_title_for_the_Trigger+"!");
                window.setTimeout(function () {
                    jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery('html, body').animate({
                    scrollTop: jQuery("#triggers_tab").offset().top
                }, 1000);
                return false;
            }
            new_trigger["title"] = jQuery("#trigger_add_title").val();
            new_trigger["format"]= jQuery("#trigger_add_format").val();
            new_trigger["schedule"]= jQuery("#trigger_add_schedule").val();
            if(jQuery("#trigger_add_schedule").val() !== "")
            {
                new_trigger["period"] = jQuery("#trigger_add_period").val();
            }
            var condi_val = {};
            var and = [];
            var or = [];
            var ungroup = [];
            jQuery(".specify_tconditions").each(function () {
                var values = {};
                var div_id = jQuery(this).prop("id");
                if(jQuery(this).hasClass("tgrouped"))
                {
                    if(jQuery("#"+div_id+"_type").val()!=="")
                    {
                        values['type'] = jQuery("#"+div_id+"_type").val();
                        values['operator'] = jQuery("#"+div_id+"_operator").val();
                        values['value'] = jQuery("#"+div_id+"_value").val();
                        if(jQuery(this).hasClass("and_tgrouped"))
                        {
                            and.push(values);
                        }
                        if(jQuery(this).hasClass("or_tgrouped"))
                        {
                            or.push(values);
                        }
                    }
                }
                else
                {
                    if(jQuery("#"+div_id+"_type").val()!=="")
                    {
                        values['type'] = jQuery("#"+div_id+"_type").val();
                        values['operator'] = jQuery("#"+div_id+"_operator").val();
                        values['value'] = jQuery("#"+div_id+"_value").val();
                        ungroup.push(values);
                    }
                }
            });
            if(ungroup.length !== 0)
            {
                condi_val['ungroup'] = ungroup;
            }
            if(and.length !== 0)
            {
                condi_val['and'] = and;
            }
            if(or.length !== 0)
            {
                condi_val['or'] = or;
            }
            new_trigger['conditions'] = condi_val;
            var actions = [];
            jQuery(".specify_tactions").each(function () {
                var values = {};
                var div_id = jQuery(this).prop("id");
                if(jQuery("#"+div_id+"_type").val()!=="")
                {
                    if(jQuery("#"+div_id+"_type").val() !== "notify" && jQuery("#"+div_id+"_type").val() !== "sms")
                    {
                        values['type'] = jQuery("#"+div_id+"_type").val();
                        values['value'] = jQuery("#"+div_id+"_value").val();
                    }
                    else
                    {
                        values['type'] = jQuery("#"+div_id+"_type").val();
                        values['value'] = jQuery("#"+div_id+"_value").val();
                        values['subject'] = jQuery("#"+div_id+"_subject").val();
                        values['body'] = jQuery("#"+div_id+"_body").val().replace(/\r?\n/g,"<br>");
                    }
                    actions.push(values);
                }
            });
            if(actions.length === 0)
            {
                jQuery(".loader").css("display", "none");
                jQuery("#trigger_edit_title").css("border","1px solid red");
                jQuery(".alert-danger").css("display", "block");
                jQuery(".alert-danger").css("opacity", "1");
                jQuery("#danger_alert_text").html("<strong>"+js_obj.Add_Trigger+"</strong><br>"+js_obj.Specify_some_action_for_the_Trigger+"!");
                window.setTimeout(function () {
                    jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery('html, body').animate({
                    scrollTop: jQuery("#triggers_tab").offset().top
                }, 1000);
                return false;
            }
            new_trigger['actions'] = actions;
        }
        if (jQuery("#trigger_edit_type").val() !== "")
        {
            if(jQuery("#trigger_edit_title").val() === "")
            {
                jQuery(".loader").css("display", "none");
                jQuery("#trigger_edit_title").css("border","1px solid red");
                jQuery(".alert-danger").css("display", "block");
                jQuery(".alert-danger").css("opacity", "1");
                jQuery("#danger_alert_text").html("<strong>"+js_obj.Edit_Trigger+"</strong><br>"+js_obj.Enter_title_for_the_Trigger+"!");
                window.setTimeout(function () {
                    jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery('html, body').animate({
                    scrollTop: jQuery("#triggers_tab").offset().top
                }, 1000);
                return false;
            }
            edit_trigger['slug'] = jQuery("#trigger_edit_type").val();
            edit_trigger["title"] = jQuery("#trigger_edit_title").val();
            edit_trigger["format"]= jQuery("#trigger_edit_format").val();
            edit_trigger["schedule"]= jQuery("#trigger_edit_schedule").val();
            if(jQuery("#trigger_edit_schedule").val() !== "")
            {
                edit_trigger["period"] = jQuery("#trigger_edit_period").val();
            }
            var condi_val = {};
            var and = [];
            var or = [];
            var ungroup = [];
            jQuery(".edit_specify_tconditions").each(function () {
                var values = {};
                var div_id = jQuery(this).prop("id");
                if(jQuery(this).hasClass("tgrouped"))
                {
                    if(jQuery("#"+div_id+"_type").val()!=="")
                    {
                        values['type'] = jQuery("#"+div_id+"_type").val();
                        values['operator'] = jQuery("#"+div_id+"_operator").val();
                        values['value'] = jQuery("#"+div_id+"_value").val();
                        if(jQuery(this).hasClass("and_tgrouped"))
                        {
                            and.push(values);
                        }
                        if(jQuery(this).hasClass("or_tgrouped"))
                        {
                            or.push(values);
                        }
                    }
                }
                else
                {
                    if(jQuery("#"+div_id+"_type").val()!=="")
                    {
                        values['type'] = jQuery("#"+div_id+"_type").val();
                        values['operator'] = jQuery("#"+div_id+"_operator").val();
                        values['value'] = jQuery("#"+div_id+"_value").val();
                        ungroup.push(values);
                    }
                }
            });
            if(ungroup.length !== 0)
            {
                condi_val['ungroup'] = ungroup;
            }
            if(and.length !== 0)
            {
                condi_val['and'] = and;
            }
            if(or.length !== 0)
            {
                condi_val['or'] = or;
            }
            edit_trigger['conditions'] = condi_val;
            var actions = [];
            jQuery(".edit_specify_tactions").each(function () {
                var values = {};
                var div_id = jQuery(this).prop("id");
                if(jQuery("#"+div_id+"_type").val()!=="")
                {
                    if(jQuery("#"+div_id+"_type").val() !== "notify" && jQuery("#"+div_id+"_type").val() !== "sms")
                    {
                        values['type'] = jQuery("#"+div_id+"_type").val();
                        values['value'] = (jQuery("#"+div_id+"_value").val() !== null) ? jQuery("#"+div_id+"_value").val() : [];
                    }
                    else
                    {
                        values['type'] = jQuery("#"+div_id+"_type").val();
                        values['value'] = jQuery("#"+div_id+"_value").val();
                        values['subject'] = jQuery("#"+div_id+"_subject").val();
                        values['body'] = jQuery("#"+div_id+"_body").val().replace(/\r?\n/g,"<br>");
                    }
                    actions.push(values);
                }
            });
            if(actions.length === 0)
            {
                jQuery(".loader").css("display", "none");
                jQuery("#trigger_edit_title").css("border","1px solid red");
                jQuery(".alert-danger").css("display", "block");
                jQuery(".alert-danger").css("opacity", "1");
                jQuery("#danger_alert_text").html("<strong>"+js_obj.Edit_Trigger+"</strong><br>"+js_obj.Specify_some_action_for_the_Trigger+"!");
                window.setTimeout(function () {
                    jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery('html, body').animate({
                    scrollTop: jQuery("#triggers_tab").offset().top
                }, 1000);
                return false;
            }
            edit_trigger['actions'] = actions;
        }
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_trigger',
                new_trigger: JSON.stringify(new_trigger),
                edit_trigger: JSON.stringify(edit_trigger)
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Triggers+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#triggers_tab").html(data);
                trigger_tab_load();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#triggers_tab").on("click", ".ticket_trigger_edit_type", function (e) {
        e.preventDefault();
        var trigger = jQuery(this).prop("id");
        jQuery("#add_new_trigger_yes").val("no");
        jQuery("#trigger_edit_type").val(trigger);
            jQuery(".loader").css("display", "block");
            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_trigger_edit',
                    trigger: trigger
                },
                success: function (data) {
                    jQuery(".loader").css("display", "none");
                    jQuery("#ticket_trigger_edit_display").slideDown().show();
                    jQuery("#ticket_trigger_add_display").slideUp().hide();
                    jQuery("#trigger_edit_append").empty();
                    jQuery("#trigger_edit_append").html(data);
                    jQuery(".trigger_textarea_edit").each(function () {
                        this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                    }).on('input', function () {
                        this.style.height = 'auto';
                        this.style.height = (this.scrollHeight) + 'px';
                    });
                    jQuery(".trigger_tselect2_edit").each(function () {
                        var id=jQuery(this).prop("id");
                        jQuery('#'+id).select2({
                            width: '100%',
                            allowClear: true,
                            placeholder: js_obj.Select_Condition_Values,
                            formatNoMatches: function () {
                                return js_obj.No_Values_Found;
                            },
                            language: {
                                noResults: function (params) {
                                    return js_obj.No_Values_Found;
                                }
                            }
                        });
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
    });
    
    //Add New Trigger Action Action
    jQuery("#triggers_tab").on("click","#trigger_add_tactions_add",function(){
        var count = 0;
        jQuery('.specify_tactions').each(function(){
            var currentNum = parseInt(jQuery(this).attr('id').replace('tactions_', ''), 10);
            if(currentNum > count) {
                count = currentNum;
            }
        });
        var html = '<div id="tactions_'+(count+1)+'" class="specify_tactions">';
                html+= '<span class="taction_title_span">'+js_obj.Action+' '+(count+1)+'</span>';
                html+= '<select id="tactions_'+(count+1)+'_type" title="'+js_obj.Trigger_Action_field+'" style="width: 90% !important;display: inline !important;margin:10px 0px;" class="form-control tactions_type clickable" aria-describedby="helpBlock">';
                html+= jQuery("#tactions_1_type").html();
                html+= '</select>';
                html+= '<button class="btn btn-warning" title="'+js_obj.Remove_Action+'" id="trigger_add_tactions_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button>';
                html+= '<div id="tactions_'+(count+1)+'_append"></div>';
            html+= '</div>';
        jQuery("#tactions_all").append(html);
    });
    
    //Add New Trigger Action Action
    jQuery("#triggers_tab").on("click","#trigger_edit_tactions_add",function(){
        var count = 0;
        jQuery('.edit_specify_tactions').each(function(){
            var currentNum = parseInt(jQuery(this).attr('id').replace('edit_tactions_', ''), 10);
            if(currentNum > count) {
                count = currentNum;
            }
        });
        var html = '<div id="edit_tactions_'+(count+1)+'" class="edit_specify_tactions">';
                html+= '<span class="edit_taction_title_span">'+js_obj.Action+' '+(count+1)+'</span>';
                html+= '<select id="edit_tactions_'+(count+1)+'_type" title="'+js_obj.Trigger_Action_field+'" style="width: 90% !important;display: inline !important;margin:10px 0px;" class="form-control edit_tactions_type clickable" aria-describedby="helpBlock">';
                html+= jQuery("#tactions_1_type").html();
                html+= '</select>';
                html+= '<button class="btn btn-warning" title="'+js_obj.Remove_Action+'" id="trigger_edit_tactions_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button>';
                html+= '<div id="edit_tactions_'+(count+1)+'_append"></div>';
            html+= '</div>';
        jQuery("#edit_tactions_all").append(html);
    });
    
    //Remove New Ticket Trigger Action Action
    jQuery("#triggers_tab").on("click","#trigger_add_tactions_remove",function(){
        jQuery(this).parent().remove();
    });
    
    //Remove New Ticket Trigger Action Action
    jQuery("#triggers_tab").on("click","#trigger_edit_tactions_remove",function(){
        jQuery(this).parent().remove();
    });
    jQuery('#ticket_page_tab').on('click', '.ticket_page_column_activate', function(e){
        var slug = jQuery(this).attr('id');
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_activate_deactivate_ticket_columns',
                case: 'activate',
                slug: slug
            },
            success: function(data){
                jQuery("#ticket_page_tab").html(data);
                page_tab_load();
                jQuery(".loader").hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery('#ticket_page_tab').on('click', '.ticket_page_column_deactivate', function(e){
        var slug = jQuery(this).attr('id');
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_activate_deactivate_ticket_columns',
                case: 'deactivate',
                slug: slug
            },
            success: function(data){
                jQuery("#ticket_page_tab").html(data);
                page_tab_load();
                jQuery(".loader").hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
});

function get_view_formula()
{
    var html=' ( ';
    var and=0;
    var or=0;
    var ungrouped=0;
    var format=jQuery("#ticket_view_add_format").val();
    jQuery(".specify_conditions").each(function () {
        var div_id = jQuery(this).prop("id");
        div_id = div_id.replace("conditions"," Conditions");
        div_id = div_id.replace("_"," ");
        if(jQuery(this).hasClass("grouped"))
        {
            if(jQuery(this).hasClass("and_grouped"))
            {
                switch(and)
                {
                    case 0:
                        if(or!==0)
                        {
                            html = html.substring(0, html.length - 2);
                            html+= ' <b>]</b> ';
                            or = 0;
                            if(format==="and")
                            {
                                html+=" & ";
                            }
                            else
                            {
                                html+=" | ";
                            }
                        }
                        html+= ' <b>[</b> ';
                        html+= div_id+' & ';
                        and++;
                        break
                    default:
                        html+= div_id+' & ';
                        and++;
                        break;
                }
            }
            if(jQuery(this).hasClass("or_grouped"))
            {
                switch(or)
                {
                    case 0:
                        if(and!==0)
                        {
                            html = html.substring(0, html.length - 2);
                            html+= ' <b>]</b> ';
                            and = 0;
                            if(format==="and")
                            {
                                html+=" & ";
                            }
                            else
                            {
                                html+=" | ";
                            }
                        }
                        html+= ' <b>[</b> ';
                        html+= div_id+' | ';
                        or++;
                        break
                    default:
                        html+= div_id+' | ';
                        or++;
                        break;
                }
            }
        }
        else
        {
            switch(ungrouped)
            {
                case 0:
                    if(and!==0)
                    {
                        html = html.substring(0, html.length - 2);
                        html+= ' <b>]</b> ';
                        and = 0;
                        if(format==="and")
                        {
                            html+=" & ";
                        }
                        else
                        {
                            html+=" | ";
                        }
                    }
                    else if(or!==0)
                    {
                        html = html.substring(0, html.length - 2);
                        html+= ' <b>]</b> ';
                        or = 0;
                        if(format==="and")
                        {
                            html+=" & ";
                        }
                        else
                        {
                            html+=" | ";
                        }
                    }
                    html+= div_id + ((format==="and")?" & ":" | ");
                    ungrouped++;
                    break
                default:
                    html+= div_id + ((format==="and")?" & ":" | ");
                    ungrouped++;
                    break;
            }
        }
    });
    html = html.substring(0, html.length - 2);
    if(and !== 0 || or !== 0)
    {
        html+=" <b>]</b> ";
    }
    html+= ' ) ';
    return html;
}

function get_trigger_formula()
{
    var html=' ( ';
    var and=0;
    var or=0;
    var ungrouped=0;
    var format=jQuery("#trigger_add_format").val();
    jQuery(".specify_tconditions").each(function () {
        var div_id = jQuery(this).prop("id");
        div_id = div_id.replace("tconditions"," Conditions");
        div_id = div_id.replace("_"," ");
        if(jQuery(this).hasClass("tgrouped"))
        {
            if(jQuery(this).hasClass("and_tgrouped"))
            {
                switch(and)
                {
                    case 0:
                        if(or!==0)
                        {
                            html = html.substring(0, html.length - 2);
                            html+= ' <b>]</b> ';
                            or = 0;
                            if(format==="and")
                            {
                                html+=" & ";
                            }
                            else
                            {
                                html+=" | ";
                            }
                        }
                        html+= ' <b>[</b> ';
                        html+= div_id+' & ';
                        and++;
                        break
                    default:
                        html+= div_id+' & ';
                        and++;
                        break;
                }
            }
            if(jQuery(this).hasClass("or_tgrouped"))
            {
                switch(or)
                {
                    case 0:
                        if(and!==0)
                        {
                            html = html.substring(0, html.length - 2);
                            html+= ' <b>]</b> ';
                            and = 0;
                            if(format==="and")
                            {
                                html+=" & ";
                            }
                            else
                            {
                                html+=" | ";
                            }
                        }
                        html+= ' <b>[</b> ';
                        html+= div_id+' | ';
                        or++;
                        break
                    default:
                        html+= div_id+' | ';
                        or++;
                        break;
                }
            }
        }
        else
        {
            switch(ungrouped)
            {
                case 0:
                    if(and!==0)
                    {
                        html = html.substring(0, html.length - 2);
                        html+= ' <b>]</b> ';
                        and = 0;
                        if(format==="and")
                        {
                            html+=" & ";
                        }
                        else
                        {
                            html+=" | ";
                        }
                    }
                    else if(or!==0)
                    {
                        html = html.substring(0, html.length - 2);
                        html+= ' <b>]</b> ';
                        or = 0;
                        if(format==="and")
                        {
                            html+=" & ";
                        }
                        else
                        {
                            html+=" | ";
                        }
                    }
                    html+= div_id + ((format==="and")?" & ":" | ");
                    ungrouped++;
                    break
                default:
                    html+= div_id + ((format==="and")?" & ":" | ");
                    ungrouped++;
                    break;
            }
        }
    });
    html = html.substring(0, html.length - 2);
    if(and !== 0 || or !== 0)
    {
        html+=" <b>]</b> ";
    }
    html+= ' ) ';
    return html;
}

function getValue_checkbox_values(name) {
    var chkArray = [];
    jQuery("input[name='" + name + "']:checked").each(function () {
        chkArray.push(jQuery(this).val());
    });
    var selected;
    selected = chkArray.join(',') + ",";
    if (selected.length > 1) {
        return (selected.slice(0, -1));
    } else {
        return ("");
    }
}
jQuery(function () {
    jQuery("#backup_restore_tab").on("click", "#backup_data", function (e) {
        e.preventDefault();
        var form = jQuery("#backup_wsdesk");
        var data = [];
        jQuery('input[name="backup_data_values[]"]:checked').each(function () {
            data.push(jQuery(this).val());
        });
        if(data.length !== 0)
        {
            form.submit();
        }
        else
        {
            jQuery(".alert-danger").css("display", "block");
            jQuery(".alert-danger").css("opacity", "1");
            jQuery("#danger_alert_text").html("<strong>"+js_obj.Backup_Restore_Alert+"!</strong><br>"+js_obj.Choose_some_data_to_Backup+"!");
            window.setTimeout(function () {
                jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                    jQuery(this).css("display", "none");
                });
            }, 4000);
        }
    });
    jQuery("#backup_restore_tab").on("click", "#restore_data", function (e) {
        e.preventDefault();
        BootstrapDialog.show({
            title: js_obj.WSDesk_Restore_Alert,
            message: js_obj.Keep_Calm_while_Restoring_Data_Dont_Refresh_the_Page,
            cssClass: 'wsdesk_wrapper',
            buttons: [{
                    label: js_obj.Yes_I_Will_Wait,
                    // no title as it is optional
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        var fd = new FormData();
                        var file = jQuery("#restore_file");
                        jQuery.each(jQuery(file), function (i, obj) {
                            jQuery.each(obj.files, function (j, file) {
                                fd.append('file[' + j + ']', file);
                            });
                        });
                        fd.append('action', 'eh_crm_restore_data');
                        if(file.val()!=="")
                        {
                            var btn = jQuery("#restore_data");
                            btn.prop("disabled","disabled");
                            jQuery.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: fd,
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    btn.removeProp("disabled");
                                    jQuery(".alert-success").css("display", "block");
                                    jQuery(".alert-success").css("opacity", "1");
                                    jQuery("#success_alert_text").html("<strong>"+js_obj.Restore_Finished+"</strong><br>"+js_obj.Refresh_and_Hit_to_go+"!");
                                    window.setTimeout(function () {
                                        jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                            jQuery(this).css("display", "none");
                                        });
                                    }, 4000);
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown);
                                }
                            });
                        }
                        else
                        {
                            jQuery(".alert-danger").css("display", "block");
                            jQuery(".alert-danger").css("opacity", "1");
                            jQuery("#danger_alert_text").html("<strong>"+js_obj.Backup_Restore_Alert+"!</strong><br>"+js_obj.Select_a_Backup_File+"!");
                            window.setTimeout(function () {
                                jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                                    jQuery(this).css("display", "none");
                                });
                            }, 4000);
                        }
                        dialogItself.close();
                    }
                }, {
                    label: 'Close',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
        
    });
    jQuery("#backup_restore_tab").on("click", "#start_initiate_ticket", function (e) {
        e.preventDefault();
        if(jQuery("#initiate_number").val() != '')
        {
            BootstrapDialog.show({
                title: js_obj.Initiate_Ticket,
                message: js_obj.WSDesk_will_create_ticket_from_this_number,
                cssClass: 'wsdesk_wrapper',
                buttons: [{
                        label: js_obj.Okay_Set_number,
                        // no title as it is optional
                        cssClass: 'btn-primary',
                        action: function (dialogItself) {
                            var btn = jQuery("#start_initiate_ticket");
                            btn.prop("disabled","disabled");
                            jQuery.ajax({
                                type: 'post',
                                url: ajaxurl,
                                data: {
                                    action: 'eh_crm_settings_initiate_ticket',
                                    start_number: jQuery("#initiate_number").val()
                                },
                                success: function (data) {
                                    btn.removeProp("disabled");
                                    var response = jQuery.parseJSON(data);
                                    if(response.result == 'success')
                                    {
                                        jQuery(".alert-success").css("display", "block");
                                        jQuery(".alert-success").css("opacity", "1");
                                        jQuery("#success_alert_text").html("<strong>"+js_obj.Initiate_Ticket+"</strong><br>"+js_obj.Initiate_Ticket_Success+"!");
                                        window.setTimeout(function () {
                                            jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                                jQuery(this).css("display", "none");
                                            });
                                        }, 4000);
                                        jQuery("#initiate_number").val('');
                                    }
                                    else
                                    {
                                        BootstrapDialog.alert('Your initaiate ticket number should higher than #'+response.ai);
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown);
                                    btn.removeProp("disabled");
                                }
                            });
                            dialogItself.close();
                        }
                    }, {
                        label: 'Close',
                        action: function (dialogItself) {
                            dialogItself.close();
                        }
                    }]
            });
        }
        else
        {
            BootstrapDialog.alert('Enter number to make initiate!');
        }
    });
    jQuery("#backup_restore_tab").on("click", "#empty_trash", function (e) {
        e.preventDefault();
        BootstrapDialog.show({
            title: js_obj.Empty_Trash,
            message: js_obj.WSDesk_will_Delete_the_tickets_Permanently,
            cssClass: 'wsdesk_wrapper',
            buttons: [{
                    label: js_obj.Okay_Empty_it,
                    // no title as it is optional
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        var btn = jQuery("#empty_trash");
                        btn.prop("disabled","disabled");
                        jQuery.ajax({
                            type: 'post',
                            url: ajaxurl,
                            data: {
                                action: 'eh_crm_settings_empty_trash'
                            },
                            success: function (data) {
                                btn.removeProp("disabled");
                                var response = jQuery.parseJSON(data);
                                if(response.result == 'success')
                                {
                                    jQuery(".alert-success").css("display", "block");
                                    jQuery(".alert-success").css("opacity", "1");
                                    jQuery("#success_alert_text").html("<strong>"+js_obj.Empty_Trash+"</strong><br>"+js_obj.Empty_Ticket_Success+"!");
                                    window.setTimeout(function () {
                                        jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                            jQuery(this).css("display", "none");
                                        });
                                    }, 4000);
                                }
                                else
                                {
                                    BootstrapDialog.alert(response.alert);
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                                btn.removeProp("disabled");
                            }
                        });
                        dialogItself.close();
                    }
                }, {
                    label: 'Close',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    });
    jQuery("#backup_restore_tab").on("click", "#restore_trash", function (e) {
        e.preventDefault();
        BootstrapDialog.show({
            title: js_obj.Restore_Trash,
            message: js_obj.WSDesk_will_restore_the_trash_tickets,
            cssClass: 'wsdesk_wrapper',
            buttons: [{
                    label: js_obj.Okay_Restore_it,
                    // no title as it is optional
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        var btn = jQuery("#restore_trash");
                        btn.prop("disabled","disabled");
                        jQuery.ajax({
                            type: 'post',
                            url: ajaxurl,
                            data: {
                                action: 'eh_crm_settings_restore_trash'
                            },
                            success: function (data) {
                                btn.removeProp("disabled");
                                var response = jQuery.parseJSON(data);
                                if(response.result == 'success')
                                {
                                    jQuery(".alert-success").css("display", "block");
                                    jQuery(".alert-success").css("opacity", "1");
                                    jQuery("#success_alert_text").html("<strong>"+js_obj.Restore_Trash+"</strong><br>"+js_obj.Restore_Ticket_Success+"!");
                                    window.setTimeout(function () {
                                        jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                            jQuery(this).css("display", "none");
                                        });
                                    }, 4000);
                                }
                                else
                                {
                                    BootstrapDialog.alert(response.alert);
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                                btn.removeProp("disabled");
                            }
                        });
                        dialogItself.close();
                    }
                }, {
                    label: 'Close',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    });
    jQuery("#ticket_fields_tab").on("click", ".dropdown-order-up", function (e) {
        var slug = jQuery(this).attr('id');
        var value = jQuery("#dropdown_options_order_"+slug).val();
        var prev = '';
        jQuery(".dropdown_options_order option").each(function()
        {
            if(value == jQuery(this).val())
            {
                return false;
            }
            prev = jQuery(this).val()
        });
        if(prev != '')
            jQuery(".dropdown_options_order option[value="+value+"]").insertBefore(".dropdown_options_order option[value="+prev+"]")
    });
    jQuery("#ticket_fields_tab").on("click", ".dropdown-order-down", function (e) {
        var slug = jQuery(this).attr('id');
        var value = jQuery("#dropdown_options_order_"+slug).val();
        var next = '';
        var now = 0;
        jQuery(".dropdown_options_order option").each(function()
        {

            if(now)
            {
                next = jQuery(this).val();
                return false;
            }
            if(value == jQuery(this).val())
            {
                now = 1;
            }
        });
        if(next != '')
            jQuery(".dropdown_options_order option[value="+value+"]").insertAfter(".dropdown_options_order option[value="+next+"]")
    });
});

function views_condition_maker(data,parent)
{
    var html = '';
    var operator = data.operator;
    var type = data.type;
    html += '<select id="'+parent+'_operator" style="width: 100% !important; margin:10px 0px; display: inline !important" class="form-control '+parent+'_operator clickable" aria-describedby="helpBlock">';
    jQuery.each(operator, function( index, value ) {
        html+='<option value="'+index+'">'+value+'</option>';
    });
    html += '</select>';
    switch(type)
    {
        case "text":
            html += '<input type="text" id="'+parent+'_value" placeholder="'+js_obj.Enter_Value+'" class="form-control crm-form-element-input">';
            jQuery("#"+parent+"_append").html(html);
            break;
        case "select":
            var value = data.values;
            html += '<select id="'+parent+'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control '+parent+'_value clickable" aria-describedby="helpBlock">';
            jQuery.each(value, function( index, value ) {
                html+='<option value="'+index+'">'+value+'</option>';
            });
            html += '</select>';
            jQuery("#"+parent+"_append").html(html);
            break;
        case "multiselect":
            var value = data.values;
            html += '<select multiple id="'+parent+'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control '+parent+'_value" aria-describedby="helpBlock">';
            jQuery.each(value, function( index, value ) {
                html+='<option value="'+index+'">'+value+'</option>';
            });
            html += '</select>';
            jQuery("#"+parent+"_append").html(html);
            jQuery('#'+parent+'_value').select2({
                width: '100%',
                allowClear: true,
                placeholder: js_obj.Select_Condition_Values,
                formatNoMatches: function () {
                    return js_obj.No_Values_Found;
                },
                language: {
                    noResults: function (params) {
                        return js_obj.No_Values_Found;
                    }
                }
            });
            break;
    }
    
}

function triggers_condition_maker(data,parent)
{
    var html = '';
    var operator = data.operator;
    var type = data.type;
    if(operator !== undefined && operator !== null && operator !== "")
    {
        html += '<select id="'+parent+'_operator" style="width: 100% !important; margin:10px 0px; display: inline !important" class="form-control '+parent+'_operator clickable" aria-describedby="helpBlock">';
        jQuery.each(operator, function( index, value ) {
            html+='<option value="'+index+'">'+value+'</option>';
        });
        html += '</select>';
    }
    else
    {
        html += '<div style="margin:10px 0px;"/>';
    }
    switch(type)
    {
        case "text":
            html += '<input type="text" id="'+parent+'_value" placeholder="'+js_obj.Enter_Value+'" class="form-control crm-form-element-input">';
            jQuery("#"+parent+"_append").html(html);
            break;
        case "select":
            var value = data.values;
            html += '<select id="'+parent+'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control '+parent+'_value clickable" aria-describedby="helpBlock">';
            jQuery.each(value, function( index, value ) {
                html+='<option value="'+index+'">'+value+'</option>';
            });
            html += '</select>';
            jQuery("#"+parent+"_append").html(html);
            break;
        case "multiselect":
            var value = data.values;
            html += '<select multiple id="'+parent+'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control '+parent+'_value" aria-describedby="helpBlock">';
            jQuery.each(value, function( index, value ) {
                html+='<option value="'+index+'">'+value+'</option>';
            });
            html += '</select>';
            jQuery("#"+parent+"_append").html(html);
            jQuery('#'+parent+'_value').select2({
                width: '100%',
                allowClear: true,
                placeholder: js_obj.Select_Condition_Values,
                formatNoMatches: function () {
                    return js_obj.No_Values_Found;
                },
                language: {
                    noResults: function (params) {
                        return js_obj.No_Values_Found;
                    }
                }
            });
            break;
    }
    
}

function triggers_action_maker(data,parent)
{
    var html = '';
    var type = data.type;
    switch(type)
    {
        case "notification":
            var value = data.values;
            html += '<select multiple id="'+parent+'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control '+parent+'_value" aria-describedby="helpBlock">';
            jQuery.each(value, function( index, value ) {
                html+='<option value="'+index+'">'+value+'</option>';
            });
            html += '</select>';
            html += '<span class="help-block">'+js_obj.Specify_the_Mail_Subject+'</span>';
            html += '<div class="input-group"><span class="input-group-addon" id="basic-addon1">Ticket [id] : </span><input type="text" id="'+parent+'_subject" placeholder="'+js_obj.Enter_mail_subject+'" class="form-control crm-form-element-input" aria-describedby="helpBlock"></div>';
            html += '<span class="help-block">'+js_obj.Codes_for_Notification_EMail+'.<table style="text-indent: 10px;padding:5px;">';
            html += '<tr><td>[id] </td><td> => </td><td> '+js_obj.To_Insert_Ticket_Number_in_the_notification_email+'</td></tr>';
            html += '<tr><td>[assignee] </td><td> => </td><td> '+js_obj.To_Insert_Ticket_Assignee_in_the_notification_email+'</td></tr>';
            html += '<tr><td>[tags] </td><td> => </td><td> '+js_obj.To_Insert_Ticket_Tags_in_the_notification_mail+'</td></tr>';
            html += '<tr><td>[date] </td><td> => </td><td> '+js_obj.To_Insert_Ticket_Date_and_Time_in_the_notification_email+'</td></tr>';
            html += '<tr><td>[latest_reply] </td><td> => </td><td> '+js_obj.To_Insert_Latest_Ticket_Content_in_the_notification_email+'</td></tr>';
            html += '<tr><td>[latest_reply_with_notes] </td><td> => </td><td> '+js_obj.To_Insert_Ticket_Note_in_the_notification_email+'</td></tr>';
            html += '<tr><td>[conversation_history] </td><td> => </td><td> '+js_obj.To_Insert_Conversation_History_in_the_notification_email+'</td></tr>';
            //html += '<tr><td>[conversation_history_with_agent_note] </td><td> => </td><td> '+js_obj.To_Insert_Conversation_History_With_Note_in_the_notification_email+'</td></tr>';
            html += '<tr><td>[satisfaction_data] </td><td> => </td><td> '+js_obj.To_Insert_Satisfaction_URL_in_the_notification_email+'</td></tr>';
            jQuery.each(shortvalues, function( index, value ) {
                html += '<tr><td>'+index+'</td><td> => </td><td> '+value+'</td></tr>';
            });
            html += '</table></span>';
            html += '<span class="help-block">'+js_obj.Note_For_Satisfaction_Survey_place_the_shortcode_in_new_page+'  </span>';
            html += '<span class="help-block">'+js_obj.Specify_the_Mail_Body+'.</span>';
            html += '<textarea id="'+parent+'_body" class="form-control crm-form-element-input crm-input-textarea-body" placeholder="'+js_obj.Enter_mail_body+'"/>';
            jQuery("#"+parent+"_append").html(html);
            jQuery('#'+parent+'_body').each(function () {
                this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
            }).on('input', function () {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
            jQuery('#'+parent+'_value').select2({
                width: '100%',
                allowClear: true,
                placeholder: js_obj.Select_Action_Values,
                formatNoMatches: function () {
                    return js_obj.No_Values_Found;
                },
                language: {
                    noResults: function (params) {
                        return js_obj.No_Values_Found;
                    }
                }
            });
            break;
        case "text":
            html += '<input type="text" id="'+parent+'_value" placeholder="'+js_obj.Enter_Value+'" class="form-control crm-form-element-input">';
            jQuery("#"+parent+"_append").html(html);
            break;
        case "select":
            var value = data.values;
            html += '<select id="'+parent+'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control '+parent+'_value clickable" aria-describedby="helpBlock">';
            jQuery.each(value, function( index, value ) {
                html+='<option value="'+index+'">'+value+'</option>';
            });
            html += '</select>';
            jQuery("#"+parent+"_append").html(html);
            break;
        case "multiselect":
            var value = data.values;
            html += '<select multiple id="'+parent+'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control '+parent+'_value" aria-describedby="helpBlock">';
            jQuery.each(value, function( index, value ) {
                html+='<option value="'+index+'">'+value+'</option>';
            });
            html += '</select>';
            jQuery("#"+parent+"_append").html(html);
            jQuery('#'+parent+'_value').select2({
                width: '100%',
                allowClear: true,
                placeholder: js_obj.Select_Action_Values,
                formatNoMatches: function () {
                    return js_obj.No_Values_Found;
                },
                language: {
                    noResults: function (params) {
                        return js_obj.No_Values_Found;
                    }
                }
            });
            break;
        case "sms":
            var value = data.values;
            html += '<select multiple id="'+parent+'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control '+parent+'_value" aria-describedby="helpBlock">';
            jQuery.each(value, function( index, value ) {
                html+='<option value="'+index+'">'+value+'</option>';
            });
            html += '</select>';
            html += '<span class="help-block">'+js_obj.Codes_for_Notification_SMS+'.<table style="text-indent: 10px;padding:5px;">';
            html += '<tr><td>[id] </td><td> => </td><td> '+js_obj.To_Insert_Ticket_Number_in_the_notification_sms+'</td></tr>';
            html += '<tr><td>[assignee] </td><td> => </td><td> '+js_obj.To_Insert_Ticket_Assignee_in_the_notification_sms+'</td></tr>';
            html += '<tr><td>[tags] </td><td> => </td><td> '+js_obj.To_Insert_Ticket_Tags_in_the_notification_sms+'</td></tr>';
            html += '<tr><td>[date] </td><td> => </td><td> '+js_obj.To_Insert_Ticket_Date_and_Time_in_the_notification_sms+'</td></tr>';
            html += '<tr><td>[latest_reply] </td><td> => </td><td> '+js_obj.To_Insert_Latest_Ticket_Content_in_the_notification_sms+'</td></tr>';
            html += '<tr><td>[latest_reply_with_notes] </td><td> => </td><td> '+js_obj.To_Insert_Ticket_Note_in_the_notification_sms+'</td></tr>';
            html += '<tr><td>[satisfaction_data] </td><td> => </td><td> '+js_obj.To_Insert_Satisfaction_URL_in_the_notification_sms+'</td></tr>';
            jQuery.each(shortvalues, function( index, value ) {
                if(value.search("(Attachment)") !== 1)
                    html += '<tr><td>'+index+'</td><td> => </td><td> '+value+'</td></tr>';
            });
            html += '</table></span>';
            html += '<span class="help-block">'+js_obj.Note_For_Satisfaction_Survey_place_the_shortcode_in_new_page+'  </span>';
            html += '<span class="help-block">'+js_obj.Specify_the_Mail_Body+'.</span>';
            html += '<textarea id="'+parent+'_body" class="form-control crm-form-element-input crm-input-textarea-body" placeholder="'+js_obj.Enter_sms_body+'"/>';
            jQuery("#"+parent+"_append").html(html);
            jQuery('#'+parent+'_body').each(function () {
                this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
            }).on('input', function () {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
            jQuery('#'+parent+'_value').select2({
                width: '100%',
                allowClear: true,
                placeholder: js_obj.Select_Action_Values,
                formatNoMatches: function () {
                    return js_obj.No_Values_Found;
                },
                language: {
                    noResults: function (params) {
                        return js_obj.No_Values_Found;
                    }
                }
            });
            break;
    }
    
}
function drag_page_column(e)
{
    var columns = [];
    jQuery(".ticket_page_column_list").each(function(e){
        columns.push(jQuery(this).attr('id'));
    });
    jQuery.ajax({
        type: 'post',
        url: ajaxurl,
        data: {
            action: 'eh_crm_arrange_ticket_columns',
            columns: JSON.stringify(columns)
        },
        success: function(data){
            jQuery("#ticket_page_tab").html(data);
            page_tab_load();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}