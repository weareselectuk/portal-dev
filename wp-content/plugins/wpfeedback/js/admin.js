/* global tippy */
(function ($) {

})(jQuery);

jQuery(document).ready(function () {
    jQuery("ul#all_wpf_list li.wpf_list a:first-child").first().trigger('click');
    jQuery("ul#all_wpf_list li.wpf_list a").first().parent().addClass('active');

    // STEP 1 BUTTON
    jQuery('#wpf_initial_setup_first_step_button').on('click',function (e) {
        if(jQuery('input[name="wpfeedback_licence_key"]').val()==''){
            jQuery('input[name="wpfeedback_licence_key"]').attr('style','border:1px solid red;');
            return false;
        }
        jQuery.ajax({
            url:ajaxurl,
            method: 'POST',
            data:{action: 'wpf_license_verify_and_store',wpf_license_key:jQuery('input[name="wpfeedback_licence_key"]').val()},
            beforeSend: function(){
                jQuery('.wpf_loader_admin').show();
            },
            success: function (data) {
                jQuery('.wpf_loader_admin').hide();
                if(data==1){
                    jQuery('#wpf_initial_settings_first_step').hide();
                    jQuery('#wpf_initial_settings_second_step').show();
                    jQuery('#wpf_license_key_valid').show();
                    jQuery('#wpf_license_key_invalid').hide();
                }
                else{
                    jQuery('#wpf_license_validation_error').show();
                    jQuery('#wpf_license_key_invalid').show();
                    jQuery('#wpf_license_key_valid').hide();
                }
            }
        });
       return false;
    });

    // STEP 2 BUTTONS
    jQuery('#wpf_initial_setup_second_step_button').on('click',function (e) {
        var task_notify_roles = [];
        jQuery.each(jQuery('input[name=roles_list]:checked'), function(){
            task_notify_roles.push(jQuery(this).val());
        });
        task_notify_roles =task_notify_roles.join(",");
        var wpf_allow_guest = jQuery('#wpf_allow_guest:checkbox:checked').length;
        jQuery.ajax({
            url:ajaxurl,
            method: 'POST',
            data:{action: 'wpf_update_roles',task_notify_roles:task_notify_roles,wpf_allow_guest:wpf_allow_guest},
            beforeSend: function(){
                jQuery('.wpf_loader_admin').show();
            },
            success: function (data) {
                jQuery('.wpf_loader_admin').hide();
                if(data==1){
                    jQuery('#wpf_initial_settings_second_step').hide();
                    jQuery('#wpf_initial_settings_third_step').show();
                }
            }
        });
        return false;
    });
    jQuery('#wpf_initial_setup_second_step_prev_button').on('click',function (e) {
        jQuery('#wpf_initial_settings_first_step').show();
        jQuery('#wpf_initial_settings_second_step').hide();
        return false;
    });

    // STEP 3 BUTTONS
    jQuery('#wpf_initial_setup_third_step_button').on('click',function (e) {
        var wpf_every_new_task = jQuery('#wpf_every_new_task:checkbox:checked').length;
        var wpf_every_new_comment = jQuery('#wpf_every_new_comment:checkbox:checked').length;
        var wpf_every_new_complete = jQuery('#wpf_every_new_complete:checkbox:checked').length;
        var wpf_every_status_change = jQuery('#wpf_every_status_change:checkbox:checked').length;
        var wpf_daily_report = jQuery('#wpf_daily_report:checkbox:checked').length;
        var wpf_weekly_report = jQuery('#wpf_weekly_report:checkbox:checked').length;
        var wpf_auto_daily_report = jQuery('#wpf_auto_daily_report:checkbox:checked').length;
        var wpf_auto_weekly_report = jQuery('#wpf_auto_weekly_report:checkbox:checked').length;
        
        jQuery.ajax({
            url:ajaxurl,
            method: 'POST',
            data:{action: 'wpf_update_notifications',wpf_every_new_task:wpf_every_new_task,wpf_every_new_comment:wpf_every_new_comment,wpf_every_new_complete:wpf_every_new_complete,wpf_every_status_change:wpf_every_status_change,wpf_daily_report:wpf_daily_report,wpf_weekly_report:wpf_weekly_report,wpf_auto_daily_report:wpf_auto_daily_report,wpf_auto_weekly_report:wpf_auto_weekly_report},
            beforeSend: function(){
                jQuery('.wpf_loader_admin').show();
            },
            success: function (data) {
                jQuery('.wpf_loader_admin').hide();
                if(data==1){
                    jQuery('#wpf_initial_settings_third_step').hide();
                    jQuery('#wpf_initial_settings_fourth_step').show();
                }
            }
        });
        return false;
    });
    jQuery('#wpf_initial_setup_third_step_prev_button').on('click',function (e) {
        jQuery('#wpf_initial_settings_second_step').show();
        jQuery('#wpf_initial_settings_third_step').hide();
        return false;
    });
    jQuery(document).find("#wpf_delete_task_container").on("click",".wpf_task_delete",function(e){
        var elemid = jQuery(this).data('elemid');
        var task_id = jQuery(this).data('taskid');
        wpf_admin_delete_task(elemid,task_id);
    });

    jQuery('#wpf_support_submit').on('click',function () {
        var errors = false;
        var wpf_support_subject = jQuery('#wpf_support_subject').val();
        var wpf_support_name = jQuery('#wpf_support_name').val();
        var wpf_support_email = jQuery('#wpf_support_email').val();
        var wpf_support_message = jQuery('#wpf_support_message').val();
        var wpf_support_site_health_info = jQuery('#wpf_support_site_health_info').val();
        if(wpf_support_subject==''){
            errors = true;
            jQuery('#wpf_support_subject').css('border-color', 'red');
        }
        if(wpf_support_name==''){
            errors = true;
            jQuery('#wpf_support_name').css('border-color', 'red');
        }
        if(wpf_support_email==''){
            errors = true;
            jQuery('#wpf_support_email').css('border-color', 'red');
        }
        if(wpf_support_message==''){
            errors = true;
            jQuery('#wpf_support_message').css('border-color', 'red');
        }
        if(errors==true){
            return false;
        }
        jQuery.ajax({
            url:ajaxurl,
            method: 'POST',
            data:{action: 'wpf_user_support',wpf_support_name:wpf_support_name,wpf_support_email:wpf_support_email,wpf_support_subject:wpf_support_subject,wpf_support_message:wpf_support_message,wpf_support_site_health_info:wpf_support_site_health_info},
            beforeSend: function(){
                jQuery('.wpf_loader_admin').show();
            },
            success: function (data) {
                jQuery('.wpf_loader_admin').hide();
                if(data==1){
                    jQuery('#wpf_user_support'). trigger("reset");
                    jQuery('#wpf_support_sent').show();
                }
                else{
                    jQuery('#wpf_support_submit_error').show();
                }

            }
        });
    });

    jQuery('#wpf_support_subject').on('change',function () {
        jQuery(this).css('border-color', '');
    });

    jQuery('#wpf_support_message').on('change',function () {
        jQuery(this).css('border-color', '');
    });

    jQuery(document).find("#wpf_attributes_content").on("click",".wpf_task_delete_btn",function(e) {
        jQuery('#wpf_task_delete').show();
    });
});

function wpf_initial_setup_done() {
    jQuery.ajax({
        url:ajaxurl,
        method: 'POST',
        data:{action: 'wpf_initial_setup_done'},
        beforeSend: function(){
            jQuery('.wpf_loader_admin').show();
        },
        success: function (data) {
            jQuery('.wpf_loader_admin').hide();
            if(data==1){
                window.location='admin.php?page=wpfeedback_page_tasks';
            }
        }
    });
}

function openWPFTab(wpfTab) {
    var i;
    var x = document.getElementsByClassName("wpf_container");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    document.getElementById(wpfTab).style.display = "block";
}

// Showing active tab
var btnContainer = document.getElementById("wpf_tabs_container");
if(btnContainer!=null){
    var btns = btnContainer.getElementsByClassName("wpf_tab_item");
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function () {
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
        });
    }
}

// Reset Setting
function wpfeedback_reset_setting() {
    jQuery.ajax({
        method: "POST",
        url: ajaxurl,
        data: {action: "wpfeedback_reset_setting"},
        success: function (data) {
            if (data == 1) {
                location.reload();
            }
        }
    });
}

function wpf_admin_delete_task(id,task_id){
    var task_info = [];
    task_info['task_id'] = task_id;
    task_info['task_no']=id;
    var task_info_obj = jQuery.extend({}, task_info);
    var wpf_task_num_top= jQuery('wpf_task_details .wpf_task_num_top').text();
    jQuery.ajax({
        method : "POST",
        url : ajaxurl,
        data : {action: "wpfb_delete_task",task_info:task_info_obj},
        beforeSend: function(){
            jQuery('.wpf_loader_admin').show();
        },
        success : function(data){
            /*console.log(jQuery('li.post_'+task_id));*/
            if(id == wpf_task_num_top){
                jQuery("#wpf_task_details #wpf_message_content,#wpf_task_details #wpf_message_form,#wpf_task_details .wpf_chat_top").hide();
            }
            jQuery('li.post_'+task_id).remove();
            jQuery('.wpf_loader_admin').hide();
            if(jQuery("ul#all_wpf_list li.wpf_list a:first-child").first().length==0){
                location.reload();
            }
            else{
                jQuery("ul#all_wpf_list li.wpf_list a:first-child").first().trigger('click');
                jQuery("ul#all_wpf_list li.wpf_list a").first().parent().addClass('active');
            }
        }
    });
}

function wpf_send_report(type) {
    jQuery.ajax({
        method: "POST",
        url: ajaxurl,
        data: {action: "wpf_send_email_report", type:type, forced: "yes"},
        beforeSend: function(){
            jQuery('.wpf_loader_admin').show();
        },
        success: function (data) {
            jQuery('.wpf_loader_admin').hide();
            jQuery('#wpf_back_report_sent_span').show();
            setTimeout(function() {
                jQuery('#wpf_back_report_sent_span').hide();
            }, 3000);
        }
    });
}

function wpf_upload_file_admin(wpf_taskid){
    /*console.log(wpf_taskid);
    console.log(jQuery(this)); return false;*/
    var elemid = jQuery(this).attr('data-elemid'), task_info=[];
    var wpf_file = jQuery('#wpf_uploadfile')[0].files[0];
    var wpf_comment = '';
    var wpf_upload_form = new FormData();
    wpf_upload_form.append('action', 'wpf_upload_file');
    wpf_upload_form.append("wpf_taskid", wpf_taskid);
    wpf_upload_form.append("wpf_upload_file", wpf_file);
    wpf_upload_form.append('task_config_author_name', current_user_name);
    if(wpf_file){
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: wpf_upload_form,
            contentType: false,
            processData: false,
            beforeSend: function(){
                jQuery('.wpf_loader_admin').show();
            },
            success: function (data) {
                var response = JSON.parse(data);
                jQuery('.wpf_loader_admin').hide();

                if(response.status==1){
                    jQuery("input[name=wpf_uploadfile]").val('');

                    if(response.type==1){
                        var comment_html = '<li class="chat_author"><level class="wpf-author">ME just now</level><p class="task_text"><a href="'+response.message+'" target="_blank"><div class="tag_img" style="width: 275px;height: 183px;"><img style="width: 100%;" class="wpfb_task_screenshot" src="'+response.message+'" /></div></a><p></li>';
                    }
                    else{
                        var wpf_download_file  = response.message.split("/").pop();
                        var comment_html = '<li class="chat_author"><level class="wpf-author">ME just now</level><p class="task_text"><a href="'+response.message+'" download="'+wpf_download_file+'"><div class="meassage_area_main"><i class="fa fa-download" aria-hidden="true"></i> '+ wpf_download_file+'</div></a></p></li>';
                    }
                    jQuery('ul#wpf_message_list').append(comment_html);
                    jQuery('#wpf_message_content').animate({scrollTop: jQuery('#wpf_message_content').prop("scrollHeight")}, 2000);
                }
                else{
                    jQuery('#wpf_upload_error').show();
                    setTimeout(function() {
                        jQuery('#wpf_upload_error').hide();
                    }, 5000);
                }
            }
        });
    }
}

function wpf_general_comment(){
    var wpf_all_info_array = JSON.parse(wpf_all_pages);
    var wpfb_all_pages_html = '<select class="wpf_page_list" id="wpf_page_list">';
    wpfb_all_pages_html+='<option value="">General Task: Choose a page/post to comment</option>';

    for (var key in wpf_all_info_array){

        if (wpf_all_info_array.hasOwnProperty(key)) {
            wpfb_all_pages_html+='<optgroup label="'+key+'">';
            for (var key_1 in wpf_all_info_array[key]){
                if (wpf_all_info_array[key].hasOwnProperty(key_1)) {
                    wpfb_all_pages_html+='<option value="'+key_1+'">'+ wpf_all_info_array[key][key_1] + '</option>';
                }
            }
            wpfb_all_pages_html+='</optgroup>';
        }

    }
    wpfb_all_pages_html+='</select>';

    var curr_browser = get_browser();
    html_element_width = window.screen.width;
    html_element_height = window.screen.height;

    var additional_info_html = '<p>Screen-size: ' + html_element_width + ' X ' +html_element_height+'</p><p>Browser: ' + curr_browser['name']+' '+curr_browser['version'] + '</p><p>Created by: ' + current_user_name + '</p><p>User IP: ' + ipaddress + '</p>';
    jQuery("div#wpf_attributes_content #additional_information").html(additional_info_html);

    jQuery("#wpf_task_details #send_chat").attr("onclick","wpf_generate_front_task()");
    jQuery('#task_task_status_attr').removeAttr("onchange");
    jQuery('#task_task_priority_attr').removeAttr("onchange");
    jQuery('#wpf_attributes_content input[name="author_list_task"]').removeAttr("onclick");
    jQuery('#wpfb_attr_task_page_link').removeAttr("href");
    jQuery('#wpf_delete_task_container .wpf_task_delete_btn').remove();
    jQuery('#wpf_attributes_content input[name=author_list_task]').attr('checked', false);
    jQuery('.wpf_upload_button.wpf_button').hide();

    jQuery('div#wpf_task_details .wpf_task_main_top .wpf_task_title_top').html('');
    jQuery('div#wpf_task_details .wpf_task_num_top').html('');
    jQuery('div#wpf_task_details #wpf_message_list').html('');
    jQuery("input[type=text],input[type=hidden], textarea").val("");
    jQuery("#task_task_priority_attr").val("low");
    jQuery("#task_task_status_attr").val("open");


    jQuery('div#wpf_task_details .wpf_task_main_top .wpf_task_title_top').html(wpfb_all_pages_html);
    jQuery('div#wpf_task_details .wpf_task_num_top').html(comment_count);
    jQuery('div#wpf_task_details .wpf_task_details_top').html('By '+current_user_name+' '+wpf_comment_time);
    
    jQuery('div#wpf_task_details #wpf_message_list').html('');
    jQuery("input[type=text],input[type=hidden], textarea").val("");
    jQuery("#task_task_priority_attr").val("low");
    jQuery("#task_task_status_attr").val("open");
}

function wpf_generate_front_task(){
    /*jQuery("#get_masg_loader").show();
    jQuery(".wpf_loader_admin").show();*/
    var wpf_comment = jQuery('#wpf_comment').val();
    var curr_browser = get_browser();
    var new_task = Array();
    var current_page_id = jQuery('#wpf_page_list').val();
    /*console.log(current_page_id);*/
    var task_priority = jQuery('#wpf_attributes_content #task_task_priority_attr').val();
    var task_status = jQuery('#wpf_attributes_content #task_task_status_attr').val();
    var task_notify_users = [];
    var task_comment = jQuery('#wpf_comment').val();
    jQuery.each(jQuery('#wpf_attributes_content input[name=author_list_task]:checked'), function(){
        task_notify_users.push(jQuery(this).val());
    });
    task_notify_users =task_notify_users.join(",");
    new_task['task_number']=comment_count;
    new_task['task_priority']=task_priority;
    new_task['task_status']=task_status;
    new_task['task_config_author_browser']=curr_browser['name'];
    new_task['task_config_author_browserVersion']=curr_browser['version'];
    new_task['task_config_author_browserOS']=curr_browser['OS'];
    new_task['task_config_author_ipaddress']=ipaddress;
    new_task['task_config_author_name']=current_user_name;
    new_task['task_config_author_id']=current_user_id;
    new_task['task_config_author_resX']=window.screen.width;
    new_task['task_config_author_resY']=window.screen.height;
    new_task['task_title']=task_comment;
    /*new_task['task_page_url']=current_page_url;
    new_task['task_page_title']=current_page_title;*/
    new_task['current_page_id']=current_page_id;
    new_task['task_comment_message']=task_comment;
    new_task['task_notify_users']=task_notify_users;
    new_task['task_type']='general';

    var new_task_obj = jQuery.extend({}, new_task);
    /*console.log(task_notify_users.length);*/
    /*console.log(new_task_obj);*/
     if (jQuery('#wpf_comment').val().trim().length > 0 && task_notify_users.length > 0 && jQuery('#wpf_page_list').val()) {
        jQuery.ajax({
            method : "POST",
            url : ajaxurl,
            data : {action: "wpf_add_new_task",new_task:new_task_obj},
            beforeSend: function(){
                jQuery('.wpf_loader_admin').show();
            },
            success : function(data){
                location.reload();
            }
        });
     }
    else {
        if(!jQuery('#wpf_page_list').val() ){
            jQuery("p.form-submit.chat_button #wpf_error_page").remove();
            jQuery("p.form-submit.chat_button #wpf_error").remove();
            jQuery("#wpf_page_list").css('border', '1px solid red');
            jQuery("p.form-submit.chat_button").append('<p id="wpf_error_page">Page/post must be selected to post a comment</span>');
        }
        else if(task_notify_users.length == 0){
            jQuery("#wpf_page_list").removeAttr('style');
            jQuery("p.form-submit.chat_button #wpf_error_page").remove();
            jQuery("p.form-submit.chat_button #wpf_error").remove();
            jQuery("p.form-submit.chat_button").append('<p id="wpf_error">A user must be selected to post a comment</span>');
        }else{
            jQuery("#wpf_page_list").removeAttr('style');
            jQuery("#wpf_comment").css('border', '1px solid red');
            jQuery("#wpf_comment").focus();
        }
        jQuery("#wpf_loader_admin").hide();
        jQuery("#get_masg_loader").hide();
        /*jQuery('ul#wpf_message_list').animate({scrollTop: jQuery("ul#wpf_message_list li").last().offset().top}, 1000);*/
    }
    
}