jQuery(function () {
    jQuery("#zendesk_plan").select2({
        minimumResultsForSearch: -1
    });
    jQuery('[data-toggle="wsdesk_tooltip"]').wstooltip({trigger : 'hover'});
    jQuery(".nav-pills").on("click", "a", function (e) {
        e.preventDefault();
        switch (jQuery(this).prop("class"))
        {
            case 'zendesk_import':
                jQuery('#breadcrump_section').html(js_obj.From_Zendesk);
                break;
        }
    });
    jQuery("#zendesk_import_tab").on("click", "#activate_zendesk", function (e) {
        e.preventDefault();
        var btn = jQuery(this);
        btn.prop("disabled","disabled");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_zendesk_library'
            },
            success: function (data) {
                btn.removeProp("disabled");
                var parse = jQuery.parseJSON(data);
                if(parse.status == "success")
                {
                    jQuery("#zendesk_import_tab").html(parse.body);
                }
                else
                {
                    jQuery(".alert-danger").css("display", "block");
                    jQuery(".alert-danger").css("opacity", "1");
                    jQuery("#danger_alert_text").html("<strong>"+js_obj.Zendesk_Import+"</strong><br>"+parse.data+"!");
                    window.setTimeout(function () {
                        jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                            jQuery(this).css("display", "none");
                        });
                    }, 4000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                btn.removeProp("disabled");
                jQuery(".alert-danger").css("display", "block");
                jQuery(".alert-danger").css("opacity", "1");
                jQuery("#danger_alert_text").html("<strong>"+js_obj.Zendesk_Import+"</strong><br>"+errorThrown+"!");
                window.setTimeout(function () {
                    jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
            }
        });
    });
    
    jQuery("#zendesk_import_tab").on("click", "#zendesk_pull_tickets", function (e) {
        e.preventDefault();  
        var token       = jQuery("#zendesk_accesstoken").val();
        var subdomain   = jQuery("#zendesk_subdomain").val();
        var username    = jQuery("#zendesk_username").val();
        var attachment = jQuery("input[name='download_attachment']:checked").val();
        var plan = jQuery("#zendesk_plan").val();
        if(token !== "" && username !== "" && subdomain !== "")
        {
            var btn = jQuery("#zendesk_pull_tickets");
            btn.prop("disabled","disabled");
            jQuery("#zendesk_accesstoken").css("border", "1px solid #ddd");
            jQuery("#zendesk_subdomain").css("border", "1px solid #ddd");
            jQuery("#zendesk_username").css("border", "1px solid #ddd");
            jQuery("#blur_on_import").addClass("blur_import");
            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action      : 'eh_crm_zendesk_save_data',
                    token       : token,
                    subdomain   : subdomain,
                    username    : username
                },
                success: function (data) {
                    if(data == "success")
                    {
                        recursive_zendesk(1,attachment,plan);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    btn.removeProp("disabled");
                    jQuery(".alert-danger").css("display", "block");
                    jQuery(".alert-danger").css("opacity", "1");
                    jQuery("#danger_alert_text").html("<strong>"+js_obj.Zendesk_Import+"</strong><br>"+errorThrown+"!");
                    window.setTimeout(function () {
                        jQuery(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                            jQuery(this).css("display", "none");
                        });
                    }, 4000);
                }
            });
        }
        else
        {
            if(token === "")
            {
                jQuery("#zendesk_accesstoken").css("border", "1px solid red");
            }
            if(subdomain === "")
            {
                jQuery("#zendesk_subdomain").css("border", "1px solid red");
            }
            if(username === "")
            {
                jQuery("#zendesk_username").css("border", "1px solid red");
            }
        }
    });
    var timeout;
    var request;
    function live_log()
    {
        jQuery("#live_import_main").css("display","block");
        jQuery.get(ajaxurl+"?action=eh_crm_live_log", function(data) {
                jQuery('#live_import_log').append(data);
                jQuery("#live_import_log").animate({ scrollTop: jQuery('#live_import_log').prop("scrollHeight")}, 1000);
        });
        timeout = setTimeout(function(){live_log();}, 5000);
    }
    function recursive_zendesk(page,attachment,plan)
    {
        jQuery("#zendesk_progress_bar").css("display","block");
        var btn = jQuery("#zendesk_pull_tickets");
        live_log();
        request = jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action      : 'eh_crm_zendesk_pull_tickets',
                page        : page,
                attachment  : attachment,
                plan        : plan
            },
            success: function (data) {
                var parse = jQuery.parseJSON(data);
                switch(parse.status)
                {
                    case "failure":
                        jQuery("#blur_on_import").removeClass("blur_import");
                        clearTimeout(timeout);
                        request.abort();
                        window.setTimeout(function () {
                            jQuery("#zendesk_progress_bar").fadeTo(500, 0).slideUp(500, function () {
                                jQuery(this).css("display", "none");
                                jQuery("#live_import_main").css("display","none");
                                jQuery("#live_import_log").empty();
                            });
                        }, 2000);
                        btn.removeProp("disabled");
                        jQuery(".alert-danger").css("display", "block");
                        jQuery(".alert-danger").css("opacity", "1");
                        jQuery("#danger_alert_text").html("<strong>"+js_obj.Zendesk_Import+"</strong><br>"+parse.body+"!");
                        break;
                    case "continue":
                        jQuery("#zendesk_importing_width").css("width",parse.percentage+"%");
                        jQuery("#zendesl_per_progress").html(parse.percentage+"% Completed");
                        page = parse.next_page;
                        recursive_zendesk(page,attachment,plan);
                        break;
                    case "completed":
                        clearTimeout(timeout);
                        jQuery("#blur_on_import").removeClass("blur_import");
                        window.setTimeout(function () {
                            jQuery("#zendesk_progress_bar").fadeTo(500, 0).slideUp(500, function () {
                                jQuery(this).css("display", "none");
                                jQuery("#live_import_main").css("display","none");
                                jQuery("#live_import_log").empty();
                            });
                        }, 2000);
                        btn.removeProp("disabled");
                        jQuery(".alert-success").css("display", "block");
                        jQuery(".alert-success").css("opacity", "1");
                        jQuery("#success_alert_text").html("<strong>"+js_obj.Zendesk_Import+"</strong><br>"+parse.total+" "+js_obj.Tickets_Import_Successful+"!");
                        break;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                clearTimeout(timeout);
                request.abort();
                jQuery("#blur_on_import").removeClass("blur_import");
                window.setTimeout(function () {
                    jQuery("#zendesk_progress_bar").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                        jQuery("#live_import_main").css("display","none");
                        jQuery("#live_import_log").empty();
                    });
                }, 2000);
                btn.removeProp("disabled");
                jQuery(".alert-danger").css("display", "block");
                jQuery(".alert-danger").css("opacity", "1");
                jQuery("#danger_alert_text").html("<strong>"+js_obj.Zendesk_Import+"</strong><br>"+js_obj.Something_Went_Wrong+"!");
            }
        });
    }
    jQuery("#zendesk_import_tab").on("click", "#stop_pull_tickets", function (e) {
        e.preventDefault();  
        var stop_btn = jQuery(this);
        stop_btn.prop("disabled","disabled");
        request.abort();
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_zendesk_stop_pull_tickets'
            },
            success: function (data) {
                stop_btn.removeProp("disabled");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
        var btn = jQuery("#zendesk_pull_tickets");
        clearTimeout(timeout);
        jQuery("#zendesk_importing_width").css("width","100%");
        jQuery("#zendesl_per_progress").html("100% Completed");
        jQuery("#blur_on_import").removeClass("blur_import");
        window.setTimeout(function () {
            jQuery("#zendesk_progress_bar").fadeTo(500, 0).slideUp(500, function () {
                jQuery(this).css("display", "none");
                jQuery("#live_import_main").css("display","none");
                jQuery("#live_import_log").empty();
            });
        }, 2000);
        btn.removeProp("disabled");
        jQuery(".alert-danger").css("display", "block");
        jQuery(".alert-danger").css("opacity", "1");
        jQuery("#danger_alert_text").html("<strong>"+js_obj.Zendesk_Import+"</strong><br>"+js_obj.Import_Stopped_Manually+"!");
    });
});

