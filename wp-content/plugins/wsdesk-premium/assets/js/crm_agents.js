jQuery(document).ready(function () {
    add_agents_tab_load();
});
function edit_select2(id)
{
    jQuery(".edit_agents_tags_" + id).select2({
        width: '100%',
        placeholder: js_obj.Search_Tags,
        ajax: {
            url: ajaxurl,
            dataType: 'json',
            type: 'post',
            delay: 250,
            data: function (params) {
                return {
                    action: 'eh_crm_search_tags',
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data, params) {
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
        minimumInputLength: 1,
        templateResult: formatResponse, // omitted for brevity, see the source of this page
        templateSelection: formatResponseSelection, // omitted for brevity, see the source of this page
        formatNoMatches: function () {
            return js_obj.No_Tags_Found;
        }
    });
}
function add_agents_tab_load()
{
    jQuery(".add_agents_select").select2({
        width: '100%',
        placeholder: js_obj.Select_User,
        templateResult: formatUser,
        formatNoMatches: function () {
            return js_obj.No_Users_Found;
        },
        language: {
            noResults: function (params) {
                return js_obj.No_Users_Found;
            }
        }
    });
    //Search Post for Tags
    jQuery(".add_agents_tags").select2({
        width: '100%',
        placeholder: js_obj.Search_Tags,
        ajax: {
            url: ajaxurl,
            dataType: 'json',
            type: 'post',
            delay: 250,
            data: function (params) {
                return {
                    action: 'eh_crm_search_tags',
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data, params) {
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
        minimumInputLength: 1,
        templateResult: formatResponse, // omitted for brevity, see the source of this page
        templateSelection: formatResponseSelection, // omitted for brevity, see the source of this page
        formatNoMatches: function () {
            return js_obj.No_Tags_Found;
        }
    });
}
function formatResponse(response) {
    if (response.loading)
        return response.title;
    var markup = "<div class=''>" + response.title + "<div class=''>" + response.posts + "</div></div>";
    return markup;
}

function formatResponseSelection(response) {
    var title = response.title;
    if (title.length > 15)
        return title.substr(0, 15) + '..';
    else
        return title;
}
function formatUser(user)
{
    if (!user.id) {
        return user.text;
    }
    var hash = jQuery("#user_key_hash").val();
    var user_hash = jQuery.parseJSON(hash);
    var key_value = user.element.value;
    var html = jQuery('<span><img src="http://0.gravatar.com/avatar/' + user_hash[key_value] + '?s=26&d=mm&r=g" class="img-flag" /> ' + user.text + '</span>');
    return html;
}
jQuery(function () {
    
    jQuery("#manage_agents_tab").on("click", ".edit_user", function (e) {
        e.preventDefault();
        var user_id = jQuery(this).attr('id').split("user_edit_").pop();
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_edit_agent_html',
                user_id: user_id
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery("#user_content_change_" + user_id).html(data);
                edit_select2(user_id);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    
    jQuery("#manage_agents_tab").on("click", ".save_edit_agents", function (e) {
        e.preventDefault();
        var user_id = jQuery(this).attr('id').split("save_edit_agents_").pop();
        var rights = getValue_checkbox_values('edit_agents_rights_'+user_id);
        var tags = jQuery(".edit_agents_tags_"+user_id).val();
        jQuery(".loader").css("display", "block");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_edit_agent',
                user_id: user_id,
                rights : rights,
                tags: (tags !== null) ? tags.join(",") : ""
            },
            success: function (data) {
                jQuery(".loader").css("display", "none");
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Agents+"</strong><br>"+js_obj.Agents_Updated_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                var response = jQuery.parseJSON(data);
                jQuery("#add_agents_tab").html(response.add);
                jQuery("#manage_agents_tab").html(response.manage);
                add_agents_tab_load();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    
    jQuery("#manage_agents_tab").on("click", ".cancel_edit_agents", function (e) {
        e.preventDefault();
        var user_id = jQuery(this).attr('id').split("cancel_edit_agents_").pop();
        jQuery("#user_content_change_"+user_id).empty();
    });
    
    jQuery("#manage_agents_tab").on("click", ".user_actions_remove", function (e) {
        e.preventDefault();
        var user_id = jQuery(this).attr('id').split("user_actions_remove_").pop();
        BootstrapDialog.show({
            message: 'Do You want to remove the WSDesk Role?',
            cssClass: 'wsdesk_wrapper',
            buttons: [{
                label: 'Yes! Remove',
                // no title as it is optional
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    jQuery(".loader").css("display", "block");
                    jQuery.ajax({
                        type: 'post',
                        url: ajaxurl,
                        data: {
                            action: 'eh_crm_remove_agent',
                            user_id: user_id
                        },
                        success: function (data) {
                            jQuery(".loader").css("display", "none");
                            jQuery(".alert-success").css("display", "block");
                            jQuery(".alert-success").css("opacity", "1");
                            jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Agents+"</strong><br>"+js_obj.Agents_Removed_Successfully+"!");
                            window.setTimeout(function () {
                                jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                    jQuery(this).css("display", "none");
                                });
                            }, 4000);
                            var response = jQuery.parseJSON(data);
                            jQuery("#add_agents_tab").html(response.add);
                            jQuery("#manage_agents_tab").html(response.manage);
                            add_agents_tab_load();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                    dialogItself.close();
                }
            }, {
                label: 'Close',
                action: function(dialogItself){
                    dialogItself.close();
                }
            }]
        });
        
    });
    
    function getValue_checkbox_values(name) {
        var chkArray = [];
        jQuery("input[name='" + name + "']:checked").each(function () {
            chkArray.push(jQuery(this).val());
        });
        if(chkArray.length === 0)
            return "";
        var selected;
        selected = chkArray.join(',') + ",";
        if (selected.length > 1) {
            return (selected.slice(0, -1));
        } else {
            return ("");
        }
    }
    
    jQuery("#add_agents_tab").on("click", "#save_add_agents", function (e) {
        e.preventDefault();
        if(jQuery("input[name='add_agent_create_user']").is(':checked'))
        {
            var email = jQuery("#user_email").val();
            var password = jQuery("#user_password").val();
            var role = jQuery("input[name='add_agents_role']:checked").val();
            var rights = getValue_checkbox_values('add_agents_rights');
            var tags = jQuery(".add_agents_tags").val();
            jQuery("#message_data").html('');
            if(email !== '' && password !=='')
            {
                if(isEmail(email))
                {
                    jQuery("#user_email").css("border", "1px solid #ddd");
                    jQuery("#user_password").css("border", "1px solid #ddd;");
                    jQuery(".loader").css("display", "block");
                    jQuery.ajax({
                        type: 'post',
                        url: ajaxurl,
                        data: {
                            action: 'eh_crm_agent_add_user',
                            email: email,
                            role: role,
                            rights:rights,
                            password: password,
                            tags:(tags !== null) ? tags.join(",") : ""
                        },
                        success: function (data) {
                            var response = jQuery.parseJSON(data);
                            if(response.code === 'success')
                            {
                                    jQuery(".alert-success").css("display", "block");
                                    jQuery(".alert-success").css("opacity", "1");
                                    jQuery("#success_alert_text").html("<strong>Add new user</strong><br>"+response.message);
                                    window.setTimeout(function () {
                                        jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                            jQuery(this).css("display", "none");
                                        });
                                    }, 4000);
                                    jQuery("#add_agents_tab").html(response.add);
                                    jQuery("#manage_agents_tab").html(response.manage);
                                    add_agents_tab_load();
                                    jQuery("#add_agents_tab").slideUp(10).hide();
                                    jQuery(".loader").css("display", "none");
                            }
                            else
                            {
                                jQuery("#message_data").html("<strong>Add new user - </strong>"+response.message);
                                jQuery(".loader").css("display", "none");
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                            jQuery(".loader").css("display", "none");
                        }
                    });
                }
                else
                {
                    jQuery("#message_data").html("<strong>Add new user - </strong> Invalid Email!");
                }
            }
            else
            {
                if(email === "")
                {
                    jQuery("#user_email").css("border", "1px solid red");
                }
                if(password === "")
                {
                    jQuery("#user_password").css("border", "1px solid red");
                }
            }
        }
        else
        {
            var users = jQuery(".add_agents_select").val();
            var role = jQuery("input[name='add_agents_role']:checked").val();
            var rights = getValue_checkbox_values('add_agents_rights');
            var tags = jQuery(".add_agents_tags").val();
            if(rights !== '' && users !== null)
            {
                jQuery(".loader").css("display", "block");
                jQuery.ajax({
                    type: 'post',
                    url: ajaxurl,
                    data: {
                        action: 'eh_crm_agent_add',
                        users: (users !== null) ? users.join(",") : "",
                        role: role,
                        rights: rights,
                        tags: (tags !== null) ? tags.join(",") : "",
                    },
                    success: function (data) {
                        jQuery(".loader").css("display", "none");
                        jQuery(".alert-success").css("display", "block");
                        jQuery(".alert-success").css("opacity", "1");
                        jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Agents+"</strong><br>"+js_obj.Agents_added_Successfully+"!");
                        window.setTimeout(function () {
                            jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                jQuery(this).css("display", "none");
                            });
                        }, 4000);
                        var response = jQuery.parseJSON(data);
                        jQuery("#add_agents_tab").html(response.add);
                        jQuery("#manage_agents_tab").html(response.manage);
                        add_agents_tab_load();
                        jQuery("#add_agents_tab").slideUp(10).hide();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        }
    });
    
    jQuery("#add_agents_tab").on("change", "#add_agents_role", function (e) {
        e.preventDefault();
        var supervisor_check = '<span id="add_agents_rights_supervisor">\
                                        <input type="checkbox" checked="checked" style="margin-top: 0;" class="form-control" name="add_agents_rights" id="add_agents_rights_merge" value="merge"> '+js_obj.Merge_Tickets+'<br>\
                                <input type="checkbox" checked="checked" style="margin-top: 0;" class="form-control" name="add_agents_rights" id="add_agents_rights_templates" value="templates"> '+js_obj.Manage_Templates+'<br>\
                                <input type="checkbox" checked="checked" style="margin-top: 0;" class="form-control" name="add_agents_rights" id="add_agents_rights_settings" value="settings"> '+js_obj.Show_Settings_Page+'<br>\
                                <input type="checkbox" checked="checked" style="margin-top: 0;" class="form-control" name="add_agents_rights" id="add_agents_rights_agents" value="agents"> '+js_obj.Show_Agents_Page+'<br>\
                                <input type="checkbox" checked="checked" style="margin-top: 0;" class="form-control" name="add_agents_rights" id="add_agents_rights_email" value="email"> '+js_obj.Show_Email_Page+'<br>\
                                <input type="checkbox" checked="checked" style="margin-top: 0;" class="form-control" name="add_agents_rights" id="add_agents_rights_import" value="import"> '+js_obj.Show_Import_Page+'<br>';
        if (jQuery(this).val() === "agents")
        {
            jQuery("#add_agents_rights_supervisor").remove();
        } else
        {
            jQuery("#add_agents_access_rights").append(supervisor_check);
        }
    }).change();
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    jQuery("#main_agent_settings").on("click", "#agent_add_button", function (e) {
        e.preventDefault();
        jQuery("#add_agents_tab").slideDown().show();
    });
    jQuery("#main_agent_settings").on("click", "#cancel_add_agents", function (e) {
        e.preventDefault();
        jQuery("#add_agents_tab").slideUp(10).hide();
    });
    jQuery("#add_agents_tab").on("change", "#add_agent_create_user", function (e) {
        e.preventDefault();
        jQuery("#add_agent_create_user_display").toggle();
        jQuery("#add_agents_select_display").toggle();
    });
});