jQuery(function () {
    jQuery("#email_support_tab").on("change", "#auto_send_creation_email", function (e) {
        e.preventDefault();
        jQuery("#email_auto_role_display").toggle();
    }).change();
    jQuery("#email_support_tab").on("change", "#send_agent_reply_mail", function (e) {
        e.preventDefault();
        jQuery("#email_auto_send_agent_reply").toggle();
    }).change();
    //Change Breadcrump Text while switching tab
    jQuery(".nav-pills").on("click", "a", function (e) {
        e.preventDefault();
        switch (jQuery(this).prop("class"))
        {
            case 'oauth_setup':
                jQuery('#breadcrump_section').html(js_obj.Google_OAuth_Setup);
                break;
            case 'imap_setup':
                jQuery('#breadcrump_section').html(js_obj.IMAP_EMail_Setup);
                break;
            case 'email_support':
                jQuery('#breadcrump_section').html(js_obj.Support_Email);
                break;
            case 'filter_block':
                jQuery('#breadcrump_section').html(js_obj.EMail_Filter_Block);
                break;
        }
    });
    jQuery("#oauth_setup_tab").on("click", "#activate_oauth", function (e) {
        e.preventDefault();
        var client_id = jQuery("#oauth_client_id").val();
        var client_secret = jQuery("#oauth_client_secret").val();
        if(client_id != "" && client_secret != "")
        {
            var btn = jQuery(this);
            btn.prop("disabled","disabled");
            jQuery("#oauth_client_id").css("border", "1px solid #ddd");
            jQuery("#oauth_client_secret").css("border", "1px solid #ddd;");
            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_activate_oauth',
                    client_id: client_id,
                    client_secret : client_secret
                },
                success: function (data) {
                    window.location.href = data;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
        else
        {
            if(client_id == "")
            {
                jQuery("#oauth_client_id").css("border", "1px solid red");
            }
            if(client_secret == "")
            {
                jQuery("#oauth_client_secret").css("border", "1px solid red");
            }
        }
    });
    
    jQuery("#imap_setup_tab").on("click", "#activate_imap", function (e) {
        e.preventDefault();
        var server_url = jQuery("#server_url").val();
        var server_port = jQuery("#server_port").val();
        var email = jQuery("#server_email").val();
        var email_pwd = jQuery("#server_email_pwd").val();
        var delete_email = '';
        if(jQuery("#delete_email:checked").val() !== undefined)
        {
            delete_email  = jQuery("#delete_email").val();
        }
        if(server_url != "" && server_port != "" && email != "" && email_pwd != "")
        {
            var btn = jQuery(this);
            btn.prop("disabled","disabled");
            jQuery("#server_url").css("border", "1px solid #ddd");
            jQuery("#server_port").css("border", "1px solid #ddd;");
            jQuery("#server_email").css("border", "1px solid #ddd");
            jQuery("#server_email_pwd").css("border", "1px solid #ddd;");
            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_activate_email_protocol',
                    server_url: server_url,
                    server_port : server_port,
                    email : email,
                    email_pwd : email_pwd,
                    delete_email : delete_email
                },
                success: function (data) {
                    btn.removeProp("disabled");
                    var parse = JSON.parse(data);
                    if(parse.status == 'success')
                    {
                        jQuery(".alert-success").css("display", "block");
                        jQuery(".alert-success").css("opacity", "1");
                        jQuery("#success_alert_text").html("<strong>"+js_obj.IMAP_EMail_Setup+"</strong><br>"+parse.message+"!");
                        window.setTimeout(function () {
                            jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                jQuery(this).css("display", "none");
                            });
                        }, 4000);
                        jQuery("#imap_setup_tab").html(parse.content);
                    }
                    else
                    {
                        jQuery(".alert-danger").css("display", "block");
                        jQuery(".alert-danger").css("opacity", "1");
                        jQuery("#danger_alert_text").html("<strong>"+js_obj.IMAP_EMail_Setup+"</strong><br>"+parse.message+"!");
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
        }
        else
        {
            if(server_url == "")
            {
                jQuery("#server_url").css("border", "1px solid red");
            }
            if(server_port == "")
            {
                jQuery("#server_port").css("border", "1px solid red");
            }
            if(email == "")
            {
                jQuery("#server_email").css("border", "1px solid red");
            }
            if(email_pwd == "")
            {
                jQuery("#server_email_pwd").css("border", "1px solid red");
            }
        }
    });
    jQuery("#oauth_setup_tab").on("click", "#deactivate_oauth", function (e) {
        e.preventDefault();
        var btn = jQuery(this);
        btn.prop("disabled","disabled");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_deactivate_oauth'
            },
            success: function (data) {
                btn.removeProp("disabled");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Google_OAuth_Setup+"</strong><br>"+js_obj.Google_OAuth_Revoked+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#oauth_setup_tab").html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#imap_setup_tab").on("click", "#deactivate_imap", function (e) {
        e.preventDefault();
        var btn = jQuery(this);
        btn.prop("disabled","disabled");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_deactivate_email_protocol'
            },
            success: function (data) {
                btn.removeProp("disabled");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.IMAP_EMail_Setup+"</strong><br>"+js_obj.IMAP_EMail_Deactivated+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#imap_setup_tab").html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    
    jQuery("#email_support_tab").on("click", "#save_email_support", function (e) {
        e.preventDefault();
        jQuery(".loader").css("display", "block");
        var support_email_name  = jQuery("#support_reply_email_name").val();
        var support_email       = jQuery("#support_reply_email").val();
        var new_ticket          = jQuery("#support_email_new_ticket_text").val();
        var reply_ticket        = jQuery("#support_email_reply_text").val();
        var auto_send_notif = '';
        var  send_agent_reply_mail = '';
        if(jQuery("input[name='auto_send_creation_email']:checked").val() !== undefined)
        {
            auto_send_notif = jQuery("input[name='auto_send_creation_email']:checked").val();
        }
        if(jQuery("input[name='send_agent_reply_mail']:checked").val() !== undefined)
        {
            send_agent_reply_mail = jQuery("input[name='send_agent_reply_mail']:checked").val();
        }
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_email_support_save',
                support_email_name : support_email_name,
                support_email : support_email,
                new_ticket_text : new_ticket,
                reply_ticket_text : reply_ticket,
                auto_send_notif : auto_send_notif,
                send_agent_reply_mail: send_agent_reply_mail
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Support_Email+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
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
    });
    jQuery("#filter_block_tab").on("click", "#save_email_filter_block", function (e) {
        e.preventDefault();
        var new_block = {};
        if (jQuery("#add_block_address_yes").val() === "yes")
        {
            if(jQuery("#block_address_add_email").val() === "")
            {
                jQuery(".loader").css("display", "none");
                if(jQuery("#block_address_add_email").val() === "")
                {
                    jQuery("#block_address_add_email").css("border","1px solid red");
                }
                jQuery(".alert-danger").css("display", "block");
                jQuery(".alert-danger").css("opacity", "1");
                jQuery("#danger_alert_text").html("<strong>"+js_obj.Add_Email_Block+"</strong><br>"+js_obj.Enter_Email_for_the_Block+"!");
                window.setTimeout(function () {
                    jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery('html, body').animate({
                    scrollTop: jQuery("#filter_block_tab").offset().top
                }, 1000);
                return false;
            }
            new_block['email'] = jQuery("#block_address_add_email").val();
            new_block['type'] = getValue_checkbox_values('add_block_rights');
        }
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_email_block_filter',
                new_block: JSON.stringify(new_block)
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Add_Email_Block+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#filter_block_tab").html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#filter_block_tab").on("click", "#save_subject_filter_block", function (e) {
        e.preventDefault();
        var new_block = {};
        if (jQuery("#add_block_subject_yes").val() === "yes")
        {
            if(jQuery("#block_subject_add_subject").val() === "")
            {
                jQuery(".loader").css("display", "none");
                if(jQuery("#block_subject_add_subject").val() === "")
                {
                    jQuery("#block_subject_add_subject").css("border","1px solid red");
                }
                jQuery(".alert-danger").css("display", "block");
                jQuery(".alert-danger").css("opacity", "1");
                jQuery("#danger_alert_text").html("<strong>"+js_obj.Add_Subject_Block+"</strong><br>"+js_obj.Enter_Subject_for_the_Block+"!");
                window.setTimeout(function () {
                    jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery('html, body').animate({
                    scrollTop: jQuery("#filter_block_tab").offset().top
                }, 1000);
                return false;
            }
            new_block['subject'] = jQuery("#block_subject_add_subject").val();
            new_block['type'] = getValue_checkbox_values('add_block_type');
        }
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_subject_block_filter',
                new_block: JSON.stringify(new_block)
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.Add_Subject_Block+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                jQuery("#filter_block_tab").html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#filter_block_tab").on("click", ".block_email_delete_type", function (e) {
        var filter_id = jQuery(this).prop("id");
        BootstrapDialog.show({
            title: "WSDesk Alert",
            message: 'Do you want to delete the filter?',
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
                                action: 'eh_crm_email_block_delete',
                                block_remove: filter_id
                            },
                            success: function (data) {
                                jQuery(".loader").css("display", "none");
                                jQuery(".alert-success").css("display", "block");
                                jQuery(".alert-success").css("opacity", "1");
                                jQuery("#success_alert_text").html("<strong>"+js_obj.Add_Email_Block+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                                window.setTimeout(function () {
                                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                        jQuery(this).css("display", "none");
                                    });
                                }, 4000);
                                jQuery("#filter_block_tab").html(data);
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
    jQuery("#filter_block_tab").on("click", ".block_subject_delete_type", function (e) {
        var filter_id = jQuery(this).prop("id");
        BootstrapDialog.show({
            title: "WSDesk Alert",
            message: 'Do you want to delete the filter?',
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
                                action: 'eh_crm_subject_block_delete',
                                block_remove: filter_id
                            },
                            success: function (data) {
                                jQuery(".loader").css("display", "none");
                                jQuery(".alert-success").css("display", "block");
                                jQuery(".alert-success").css("opacity", "1");
                                jQuery("#success_alert_text").html("<strong>"+js_obj.Add_Email_Block+"</strong><br>"+js_obj.Updated_and_Saved_Successfully+"!");
                                window.setTimeout(function () {
                                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                        jQuery(this).css("display", "none");
                                    });
                                }, 4000);
                                jQuery("#filter_block_tab").html(data);
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
    jQuery("#filter_block_tab").on("click", "#block_email_add_button", function (e) {
        e.preventDefault();
        jQuery("#block_email_add_display").slideDown(10).show();
        jQuery("#add_block_address_yes").val("yes");
    });
    jQuery("#filter_block_tab").on("click", "#block_subject_add_button", function (e) {
        e.preventDefault();
        jQuery("#block_subject_add_display").slideDown(10).show();
        jQuery("#add_block_subject_yes").val("yes");
    });
    jQuery("#filter_block_tab").on("click", "#block_email_cancel_add_button", function (e) {
        e.preventDefault();
        jQuery("#block_email_add_display").slideUp(10).hide();
        jQuery("#add_block_address_yes").val("no");
    });
    jQuery("#filter_block_tab").on("click", "#block_subject_cancel_add_button", function (e) {
        e.preventDefault();
        jQuery("#block_subject_add_display").slideUp(10).hide();
        jQuery("#add_block_subject_yes").val("no");
    });
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
});
