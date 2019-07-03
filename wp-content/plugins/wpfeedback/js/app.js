var box = '', comments=false, browser='', device_type='', resolution = window.screen.width+' x '+window.screen.height, new_task = [], task_screenshot=[], rightArrowParents = [], current_html_element='', relative_location={}, html_element_location={}, html_element_height=0, html_element_width=0, tasks_on_page = [], onload_wpfb_tasks = [], all_page_tasks_loaded=0, wpf_tasks_loaded=false, wpf_clean_dom_elem_path='', temp_tasks = [], wpf_tab_permission = {'user':false,'status':false,'priority':false,'screenshot':false,'information':false,'delete_task':'no'};
// var comment_count=1;

switch (wpf_current_role) {
    case 'advisor':
        wpf_tab_permission.user=true;
        wpf_tab_permission.priority=true;
        wpf_tab_permission.status=true;
        wpf_tab_permission.screenshot=true;
        wpf_tab_permission.information=true;
        wpf_tab_permission.delete_task='all';
        break;

    case 'king':
        wpf_tab_permission.user=true;
        wpf_tab_permission.priority=true;
        wpf_tab_permission.screenshot=true;
        wpf_tab_permission.information=true;
        wpf_tab_permission.delete_task='own';
        break;

    case 'council':
        wpf_tab_permission.user=true;
        wpf_tab_permission.screenshot=true;
        wpf_tab_permission.information=true;
        wpf_tab_permission.delete_task='own';
        break;

    default:
        wpf_tab_permission.screenshot=true;
        wpf_tab_permission.information=true;
        wpf_tab_permission.delete_task='own';
}

function enable_comment(){
    comments = true;
    jQuery("#wpf_enable_comment").show();

    var wpf_tmp_show_task_checkbox_obj = jQuery("#wpfb_display_tasks");
    if(wpf_tmp_show_task_checkbox_obj.prop('checked')==false){
        wpf_tmp_show_task_checkbox_obj.prop('checked',true);
    }
    wpf_display_tasks(wpf_tmp_show_task_checkbox_obj);

    jQuery("a").each(function(){
        if(this.id!='disable_comment_a'){
            jQuery(this).addClass('active_comment');
        }
    });
    jQuery('input[type="button"]').each(function(){
        if(this.id!='disable_comment_a'){
            jQuery(this).addClass('active_comment');
        }
    });
    jQuery('form').each(function(){
        if(this.id!='disable_comment_a'){
            jQuery(this).addClass('active_comment');
        }
    });
    jQuery('body').addClass('active_comment');
    jQuery('body').css('cursor','crosshair');
    jQuery('a').css('cursor','crosshair');

    box = new Overlay(200, 200, 400, 20);

    jQuery("body").mouseover(function(e){
        if(comments==true){
            var el = jQuery(e.target);
            var offset = el.offset();
            box.render(el.outerWidth(), el.outerHeight(), offset.left, offset.top);
        }
    });
    if(comments==true){
        jQuery(this).addClass('wpf_enable_comment');
        jQuery(document).on('keyup',function(evt) {
            if (evt.keyCode == 27) {
                jQuery('#disable_comment_a').trigger('click');
            }
        });
    }
}

function disable_comment() {
    comments = false;
    // alert('commenting disabled');
    jQuery("#wpf_enable_comment").hide();
    jQuery("a").each(function(){
        jQuery(this).removeClass('active_comment');
    });
    jQuery('body').removeClass('active_comment');
    jQuery('body').css('cursor','default');
    jQuery('a').css('cursor','pointer');
    box = {};
}

function screenshot(id){
    const rollSound = new Audio(wpf_screenshot_sound);
    if(tasks_on_page[id] > 0){
        rollSound.play();

        html2canvas(document.body,{
            x: window.scrollX,
            y: window.scrollY,
            width: window.innerWidth,
            height: window.innerHeight,
    		useCORS: true,
            logging: true,}).then(function(canvas) {
            /*document.body.appendChild(canvas);*/

            var base64URL = canvas.toDataURL('image/jpeg',1);

            task_screenshot['post_id']=tasks_on_page[id];
            task_screenshot['task_config_author_name']=current_user_name;
            task_screenshot['task_config_author_id']=current_user_id;
            var new_task_screenshot_obj = jQuery.extend({}, task_screenshot);
                jQuery('body').addClass('wpfb_screenshot_class');
                setTimeout(function(){
                    jQuery('body').removeClass('wpfb_screenshot_class');
                }, 500);

                jQuery.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {action:'wpfb_save_screenshot', task_screenshot:new_task_screenshot_obj, image: base64URL},
                    beforeSend: function(){
             			jQuery('.wpf_loader_'+id).show();
           			},
                    success: function(data){
                        jQuery('.wpf_loader_'+id).hide();
                        console.log('Upload successfully');
                        var comment_html = '<li class="wpf_author"><level class="task-author">'+current_user_name+'</level><div class="meassage_area_main"><img src="'+data+'" /></div></li>';
                        jQuery('#task_comments_'+id).append(comment_html);
                        jQuery('#task_comments_'+id).animate({scrollTop: jQuery('#task_comments_'+id).prop("scrollHeight")}, 2000);
                    }
                });
        });
    }
    else{
        jQuery('#wpf_error_'+id).hide();
        jQuery('#wpf_task_error_'+id).show();
        }
}

jQuery(document).ready(function(){
    load_wpfb_tasks();

    jQuery('a').click(function(e) {
        if(jQuery(this).hasClass("active_comment")){
            e.preventDefault();
        }
        else{
        }
    });
	
	jQuery('a img').click(function(e) {
        if(jQuery(this).parent().hasClass("active_comment")){
            e.preventDefault();
        }
        else{
        }
    });

    jQuery('input[type="button"]').click(function(e) {
        if(jQuery(this).hasClass("active_comment")){
            e.preventDefault();
            return false;
        }
        else{
        }
    });

    jQuery("form").submit(function(e){
        if(comments==true){
            e.preventDefault();
        }
    });

    jQuery('.wpf_general_task_close').on('click',function () {
        jQuery('#wpf_general_comment_tabs').html('');
        jQuery('#wpf_general_comment').hide();
    });

    jQuery('*').on('click', function(event) {
        var no_of_elements = jQuery(this).parents().addBack().not('html').length-1, temp_count = 0;
        if(this.id!="disable_comment_a"){
            if(comments==true){
                rightArrowParents = [];
                if ( jQuery( this ).hasClass( "wpfb_task_bubble" )) {
                    jQuery('#wpf_already_comment').show().delay(5000).fadeOut();
                    jQuery('#disable_comment_a').trigger('click');
                    jQuery('[rel="popover-'+jQuery(this).data('task_id')+'"]').trigger('click');
                    return false;
                }
                if(jQuery(this).attr('id')=='wpf_launcher' || jQuery( this ).hasClass( "fa-plus" ) || jQuery( this ).hasClass( "wpf_start_comment" )){
                    jQuery('#disable_comment_a').trigger('click');
                    return false;
                }
                if (jQuery( this ).hasClass( "wpf_none_comment" ) ) {
                    alert('Task cannot be created for this element');
                    return false;
                }
                temp_tasks[comment_count] = [];
                curr_browser_temp = get_browser();
                browser = curr_browser_temp['name']+' '+curr_browser_temp['version'];
                relative_location = mousePositionElement(event);
                temp_tasks[comment_count]['relative_location']=relative_location;
                html_element_location = getOffset(this);
                temp_tasks[comment_count]['html_element_location']=html_element_location;
                html_element_width = jQuery(this).width();
                temp_tasks[comment_count]['html_element_width']=html_element_width;
                html_element_height = jQuery(this).height();
                temp_tasks[comment_count]['html_element_height']=html_element_height;

                dompath = getDomPath(this);
                wpf_clean_dom_elem_path = dompath.join(' > ');
                temp_tasks[comment_count]['wpf_clean_dom_elem_path']=wpf_clean_dom_elem_path;

                jQuery(this).parents().addBack().not('html').each(function() {
                    var entry = this.tagName.toLowerCase();
                    if(entry!='body'){
                        if (this.className) {
                            this.className = jQuery.trim(this.className);

                            var wpf_temp_classname = this.className.replace(/\s+/g, '.');
                            var wpf_class_arr = this.className.split(" ");
                            var wpf_class_format = /[ !@#$%^&*()+\=\[\]{};':"\\|,<>\/?]/;
                            for(var i=0;i<wpf_class_arr.length;i++){
                                if(wpf_class_format.test(wpf_class_arr[i])==true){
                                    wpf_class_arr[i]='';
                                }
                            }
                            var wpf_new_classname = jQuery.trim(wpf_class_arr.join(' '));
                            wpf_new_classname = wpf_new_classname.replace(/\s+/g, '.');
                            entry += "." + wpf_new_classname;
                        }
                    }
                    current_html_element = entry;
                    temp_tasks[comment_count]['current_html_element']=current_html_element;

                    if(temp_count==no_of_elements){
                        
                        var temp_element = rightArrowParents.join(" > ");
                        temp_element = temp_element+' > '+entry;
                        var temp_index = jQuery(this).index(temp_element);
                        rightArrowParents.push(entry+':eq('+temp_index+')');
                    }
                    else{
                        rightArrowParents.push(entry);
                    }
                    temp_count++;
                });
                temp_tasks[comment_count]['rightArrowParents']=rightArrowParents;

                var wpfb_users_arr = JSON.parse(wpfb_users);
                var wpfb_users_html = '<ul class="wp_feedback_filter_checkbox user">';

                for (var key in wpfb_users_arr) {
                    if (wpfb_users_arr.hasOwnProperty(key)) {
                        /*console.log(key + " -> " + wpfb_users_arr[key]);*/
                        if(current_user_id==key || wpf_website_builder==key){
                            wpfb_users_html+='<li><input type="checkbox" name="author_list_'+comment_count+'" value="'+key+'" class="wp_feedback_task wpfbtasknotifyusers" data-elemid="'+comment_count+'" id="author_list_'+comment_count+'_'+key+'" checked><label for="author_list_'+comment_count+'_'+key+'">'+wpfb_users_arr[key]+'</label></li>';
                        }
                        else{
                            wpfb_users_html+='<li><input type="checkbox" name="author_list_'+comment_count+'" value="'+key+'" class="wp_feedback_task wpfbtasknotifyusers" data-elemid="'+comment_count+'" id="author_list_'+comment_count+'_'+key+'"><label for="author_list_'+comment_count+'_'+key+'">'+wpfb_users_arr[key]+'</label></li>';
                        }
                    }
                }
                wpfb_users_html+='</ul>';

                var element_center = getelementcenter(rightArrowParents.join(" > "));
                element_center['left']=element_center['left']-25;
                element_center['top']=element_center['top']-25;
                jQuery(rightArrowParents.join(" > ")).addClass('wpfb_task_bubble');
                jQuery(rightArrowParents.join(" > ")).attr('data-task_id', comment_count);
                var wpf_popover_html = wpf_task_popover_html(1,comment_count,0,'',wpfb_users_html,'','','');

                jQuery('#wpf_launcher').after(wpf_popover_html);

                init_custom_popover(comment_count);
                tasks_on_page[comment_count]=0;
                comment_count++;
                event.preventDefault();
            }
        }
        if(comments==true){
            disable_comment();
            event.stopPropagation();
        }
    });
});

jQuery("#wpfb_display_completed_tasks").change(function() {
    if(this.checked) {
        jQuery('.wpfb-point').each(function(){
            if(jQuery(this).hasClass('complete')){
                jQuery(this).show();
            }
        });
    }
    else{
        jQuery('.wpfb-point').each(function(){
            if(jQuery(this).hasClass('complete')){
                jQuery(this).hide();
            }
        });
    }
});

jQuery("#wpfb_display_tasks").change(function() {
    wpf_display_tasks(this);

});

function wpf_display_tasks(obj) {
    if(document.getElementById('wpfb_display_tasks').checked) {
        jQuery('.wpfb-point').each(function(){
            jQuery(this).removeClass('wpf_hide');
        });
    }
    else{
        jQuery('.wpfb-point').each(function(){
            jQuery(this).addClass('wpf_hide');
        });
    }
}

function set_task_prioirty(id){
    var task_info = [];
    var task_priority = jQuery('input[name=wpfbpriority'+id+']:checked').val();
    

    task_info['task_id'] = tasks_on_page[id];
    task_info['task_priority']=task_priority;

    var task_info_obj = jQuery.extend({}, task_info);
    jQuery.ajax({
        method : "POST",
        url : ajaxurl,
        data : {action: "wpfb_set_task_priority",task_info:task_info_obj},
        beforeSend: function(){
     		jQuery('.wpf_loader_'+id).show();
   		},
        success : function(data){
        	jQuery('.wpf_loader_'+id).hide();
            // console.log(data);
        }
    });
}

function set_task_status(id){
    var task_info = [];
    var task_status = jQuery('input[name=wpfbtaskstatus'+id+']:checked').val();

    var task_notify_users = [];
    var task_comment = jQuery('#comment-'+id).val();
    jQuery.each(jQuery('input[name=author_list_'+id+']:checked'), function(){
        task_notify_users.push(jQuery(this).val());
    });
    task_notify_users =task_notify_users.join(",");

    task_info['task_id'] = tasks_on_page[id];
    task_info['task_status']=task_status;
    task_info['task_notify_users']=task_notify_users;

    var task_info_obj = jQuery.extend({}, task_info);

    jQuery.ajax({
        method : "POST",
        url : ajaxurl,
        data : {action: "wpfb_set_task_status",task_info:task_info_obj},
        beforeSend: function(){
     		jQuery('.wpf_loader_'+id).show();
   		},
        success : function(data){
        	jQuery('.wpf_loader_'+id).hide();
            if(task_status == 'complete'){
                jQuery(document).find("#wpf_thispage [data-taskid='" + id + "']").addClass('complete');
                jQuery(document).find("#wpf_thispage [data-taskid='" + id + "'] .wpf_task_number").html('<i class="fa fa-check"></i>');
                jQuery('#bubble-'+id).html('<i class="fa fa-check"></i>');
                jQuery('#bubble-'+id).addClass('complete');
                jQuery('#bubble-'+id).css('display',"block");

            }else{
                jQuery('#bubble-'+id).removeClass('complete');
                jQuery('#bubble-'+id).html(id);
                jQuery(document).find("#wpf_thispage [data-taskid='" + id + "'] .wpf_task_number").html(id);
                jQuery(document).find("#wpf_thispage [data-taskid='" + id + "']").removeClass('complete');
            }
        }
    });
}

function set_task_notify_users(id) {
    var task_info = [];
    var task_notify_users = [];

    jQuery.each(jQuery('input[name=author_list_'+id+']:checked'), function(){
        task_notify_users.push(jQuery(this).val());
    });
    task_notify_users =task_notify_users.join(",");

    task_info['task_id'] = tasks_on_page[id];
    task_info['task_notify_users']=task_notify_users;

    var task_info_obj = jQuery.extend({}, task_info);

    jQuery.ajax({
        method : "POST",
        url : ajaxurl,
        data : {action: "wpfb_set_task_notify_users",task_info:task_info_obj},
        beforeSend: function(){
            jQuery('.wpf_loader_'+id).show();
        },
        success : function(data){
            jQuery('.wpf_loader_'+id).hide();
        }
    });
}

function expand_sidebar(){
	 if(jQuery('#wpf_launcher .wpf_sidebar_container').hasClass('active')) {
    
	 	jQuery('#wpf_launcher .wpf_sidebar_container').css({"opacity": "0","margin-right": "-300px"});
    
        jQuery('#wpf_launcher .wpf_sidebar_container').removeClass('active');
    } else {
         var wpf_tmp_show_task_checkbox_obj = jQuery("#wpfb_display_tasks");
         if(wpf_tmp_show_task_checkbox_obj.prop('checked')==false){
             wpf_tmp_show_task_checkbox_obj.prop('checked',true);
         }
         wpf_display_tasks(wpf_tmp_show_task_checkbox_obj);

    	jQuery('#wpf_launcher .wpf_sidebar_container').css({"display": "inline-block","opacity": "1","margin-right": ""});
    
        jQuery('#wpf_launcher .wpf_sidebar_container').addClass('active');
    }
}

function new_comment(id){
    if(jQuery.trim(jQuery('#comment-'+id).val()).length==0){
        jQuery('#comment-'+id).attr('style','border: 1px solid red;');
        jQuery('#comment-'+id).focus();
        jQuery('#wpf_task_error_'+id).hide();
        jQuery('#wpf_error_'+id).show();
        return false;
    }
    else{
        if(jQuery('input[name="author_list_'+id+'"]:checked').length > 0){
        }
        else{
            jQuery('#wpfbuser-tab-'+id).click();
            jQuery('#wpf_task_error_'+id).hide();
            jQuery('#wpf_error_'+id).show();
            return false;
        }
    }
    if(tasks_on_page[id]==0){
        generate_task(id);
    }
    else{
        generate_comment(id);
    }
}

function generate_task(id){
    if(typeof temp_tasks[id]!='undefined'){
        var task_element_path = temp_tasks[id]['rightArrowParents'].join(" > ");
    }
    var curr_browser = get_browser();
    var new_task = Array();
    var task_priority = jQuery('input[name=wpfbpriority'+id+']:checked').val();
    var task_status = jQuery('input[name=wpfbtaskstatus'+id+']:checked').val();
    var task_notify_users = [];
    var task_comment = jQuery('#comment-'+id).val();
    jQuery.each(jQuery('input[name=author_list_'+id+']:checked'), function(){            
        task_notify_users.push(jQuery(this).val());
    });
    task_notify_users =task_notify_users.join(",");
    new_task['task_number']=id;
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
    new_task['task_page_url']=current_page_url;
    new_task['task_page_title']=current_page_title;
    new_task['current_page_id']=current_page_id;
    new_task['task_comment_message']=task_comment;
    new_task['task_notify_users']=task_notify_users;

    if(typeof temp_tasks[id]!='undefined'){
        new_task['task_element_path']=task_element_path;
        new_task['task_clean_dom_elem_path']=temp_tasks[id]['wpf_clean_dom_elem_path'];
        new_task['task_element_html']=temp_tasks[id]['current_html_element'];
        new_task['task_X']=temp_tasks[id]['relative_location'].x;
        new_task['task_Y']=temp_tasks[id]['relative_location'].y;
        new_task['task_elementX']=temp_tasks[id]['html_element_location'].x;
        new_task['task_elementY']=temp_tasks[id]['html_element_location'].y;
        new_task['task_relativeX']='';
        new_task['task_relativeY']='';
        new_task['task_element_height']=temp_tasks[id]['html_element_height'];
        new_task['task_element_width']=temp_tasks[id]['html_element_width'];
        new_task['task_type']='element';
    }
    else{
        new_task['task_type']='general';
       /* wpf_general_task_label = '<span>General</span>';
        wpf_general_task_class= 'current_page_general_task';*/
    }

    var new_task_obj = jQuery.extend({}, new_task);
    jQuery.ajax({
        method : "POST",
        url : ajaxurl,
        data : {action: "wpf_add_new_task",new_task:new_task_obj},
        beforeSend: function(){
    		jQuery('.wpf_loader_'+id).show();
		},
        success : function(data){   	
            jQuery('#wpf_error_'+id).hide();
			jQuery('.wpf_loader_'+id).hide();
            if(data!=0){
                tasks_on_page[id]=data;
                jQuery('#wpfbsysinfo_task_id-'+id).html(tasks_on_page[id]);
                if(new_task['task_type']=='general'){

                    jQuery(document).find("#wpf_delete_container_"+id).on("click",".wpf_task_delete_btn",function(e) {
                    var btn_elemid = jQuery(this).data('btn_elemid');
                    jQuery('.wpfbsysinfo_delete_task_id_'+btn_elemid).show();
                    });
                    jQuery(document).find("#wpf_delete_container_"+id).on("click",".wpf_task_delete",function(e) {
                    var elemid = jQuery(this).data('elemid');
                    var task_id = jQuery(this).data('taskid');
                    wpf_delete_task(elemid,task_id);
                    jQuery('#wpf_general_comment .wpf_general_task_close').trigger('click');
                    comment_count--;
                    });
                    jQuery('#wpf_thispage_container').prepend('<li class="current_page_general_task open" data-taskid="'+id+'" data-postid="'+tasks_on_page[id]+'"><div class="wpf_task_number">'+id+'</div><div class="wpf_task_sum"><level class="task-author">'+current_user_name+' just now <span>General</span></level><div class="current_page_task_list">'+task_comment+'</div></div></li>');
                }else{
                    jQuery('#wpf_thispage_container').prepend('<li class="current_page_task open" data-taskid="'+id+'"><div class="wpf_task_number">'+id+'</div><div class="wpf_task_sum"><level class="task-author">'+current_user_name+' just now </level><div class="current_page_task_list">'+task_comment+'</div></div></li>');
                }
                var comment_html = '<li class="wpf_author"><level class="task-author">'+current_user_name+' just now</level><div class="meassage_area_main"><p class="chat_text">'+task_comment+'</p></div></li>';
                jQuery('#task_comments_'+id).append(comment_html);

                jQuery('#wpf_delete_container_'+id).html('<span class="wpfbsysinfo_delete_btn_task_id_'+id+'"><a href="javascript:void(0)" class="wpf_task_delete_btn" data-btn_elemid="'+data+'" style="color:red;"><i class="fa fa-trash" aria-hidden="true"></i> Delete Ticket</a></span><p class="wpfbsysinfo_delete_task_id_'+data+' wpf_hide" ><b>Better to change the status to complete.</b><br>Are you sure you want to delete? <a href="javascript:void(0)" class="wpf_task_delete" data-taskid="'+data+'" data-elemid="'+id+'" style="color:red;">Yes</a></p>');
                jQuery('#comment-'+id).val('');
                jQuery('.wpfbpriority').click(function(){
                    set_task_prioirty(id);
                });
                jQuery('.wpfbtaskstatus').click(function(){
                    set_task_status(id);
                });
                jQuery('.wpfbtasknotifyusers').click(function(){
                    set_task_notify_users(id);
                });
                /*jQuery('.wpf_current_chat_box').animate({scrollTop: jQuery(".wpf_current_chat_box li").last().offset().top},2000);*/
                jQuery('#task_comments_'+id).animate({scrollTop: jQuery('#task_comments_'+id).prop("scrollHeight")}, 2000);
            }
        }
    });
}

function generate_comment(id){
    var new_task = Array();
    var task_priority = jQuery('input[name=wpfbpriority'+id+']:checked').val();
    var task_status = jQuery('input[name=wpfbtaskstatus'+id+']:checked').val();
    var task_comment = jQuery('#comment-'+id).val();
    var task_notify_users = [];
    jQuery.each(jQuery('input[name=author_list_'+id+']:checked'), function(){            
        task_notify_users.push(jQuery(this).val());
    });
    task_notify_users =task_notify_users.join(",");

    new_task['post_id']=tasks_on_page[id];
    new_task['task_config_author_name']=current_user_name;
    new_task['task_config_author_id']=current_user_id;
    new_task['task_priority']=task_priority;
    new_task['task_status']=task_status;
    new_task['task_comment_message']=task_comment;
    new_task['task_notify_users']=task_notify_users;
    var new_task_obj = jQuery.extend({}, new_task);

    jQuery.ajax({
        method:"POST",
        url: ajaxurl,
        data: {action:'wpfb_add_comment',new_task:new_task_obj},
         beforeSend: function(){
    		jQuery('.wpf_loader_'+id).show();
		},
        success: function(data){
            jQuery('#wpf_error_'+id).hide();
        	jQuery('.wpf_loader_'+id).hide();
            var comment_html = '<li class="wpf_author"><level class="task-author">'+current_user_name+' just now</level><div class="meassage_area_main"><p class="chat_text">'+task_comment+'</p></div></li>';
            jQuery('#task_comments_'+id).append(comment_html);
            jQuery('#comment-'+id).val('');
            /*jQuery('.wpf_current_chat_box').animate({scrollTop: jQuery(".wpf_current_chat_box li").last().offset().top},2000);*/
            jQuery('#task_comments_'+id).animate({scrollTop: jQuery('#task_comments_'+id).prop("scrollHeight")}, 2000);
        }
    });
}

function load_wpfb_tasks(){
    jQuery.ajax({
        method:"POST",
        url: ajaxurl,
        data: {action:'load_wpfb_tasks',current_page_id:current_page_id},
        success: function(data){
            wpf_tasks_loaded = true;
            onload_wpfb_tasks = JSON.parse(data);
            const k = Object.keys(onload_wpfb_tasks).sort(timeSort);
            comment_count_initial = Object.keys(onload_wpfb_tasks).length;

            jQuery.each(k,function (index, value) {
                tasks_on_page[onload_wpfb_tasks[value].task_comment_id]=value;
                generate_wpfb_task_html(value,onload_wpfb_tasks[value]);
                comment_count_initial--;
            });

            jQuery('.wpfbpriority').click(function(){
                var elemid = jQuery(this).attr('data-elemid'); 
                set_task_prioirty(elemid);
            });
            jQuery('.wpfbtaskstatus').click(function(){
                var elemid = jQuery(this).attr('data-elemid'); 
                set_task_status(elemid);
            });
            jQuery('.wpfbtasknotifyusers').click(function(){
                var elemid = jQuery(this).attr('data-elemid');
                set_task_notify_users(elemid);
            });
            jQuery('.close').click(function(e) {
                jQuery(this).parents('.popover').popover('hide');
            });
            jQuery('.wpf_task_delete_btn').click(function(){
                var btn_taskid = jQuery(this).data('btn_taskid'); 
                jQuery('.wpfbsysinfo_delete_task_id_'+btn_taskid).show();
            });
            jQuery('.wpf_task_delete').click(function(){
                var elemid = jQuery(this).data('elemid'); 
                var task_id = jQuery(this).data('taskid'); 
                wpf_delete_task(elemid,task_id);
            });
            jQuery(document).find("#wpf_thispage").on("click","li.current_page_task",function(e) {
                var wpf_tmp_show_task_checkbox_obj = jQuery("#wpfb_display_tasks");
                if(wpf_tmp_show_task_checkbox_obj.prop('checked')==false){
                    wpf_tmp_show_task_checkbox_obj.prop('checked',true);
                }
                wpf_display_tasks(wpf_tmp_show_task_checkbox_obj);
                var taskid = jQuery(this).data('taskid');
                jQuery('[rel="popover-'+taskid+'"]').trigger('click');
                jQuery('html, body').animate({
                    scrollTop: jQuery("#bubble-"+taskid).offset().top - 200
                }, 1000);
            });
            jQuery(document).find("#wpf_thispage").on("click","li.current_page_general_task",function(e) {
                var taskid = jQuery(this).data('postid');
                wpf_load_general_task(taskid);
            });

			jQuery(document).find("#wpf_allpages_container").on("click","li.current_page_task",function(e) {
                var task_url = jQuery(this).attr('data-task_url');
                window.location.assign(task_url);
            });

            jQuery(document).find("#wpf_allpages_container").on("click","li.current_page_general_task",function(e) {
                var taskid = jQuery(this).data('postid');
                wpf_load_general_task(taskid);
            });
            trigger_bubble_label();
        }
    });
}

function timeSort(a, b) {
    return b.localeCompare(a)
}

function generate_wpfb_task_html(wpfb_task_id,wpfb_metas){
    var notify_users = wpfb_metas.task_notify_users.split(',');
    var wpfb_users_arr = JSON.parse(wpfb_users);
    var comment_count = wpfb_metas.task_comment_id;

    if(wpfb_metas.task_status=='complete'){
        var bubble_label = '<i class="fa fa-check"></i>';
    }
    else{
        var bubble_label = comment_count;
    }

    if(wpfb_metas.task_type=='general'){
        var wpfb_current_page_task_list_html = '<li class="current_page_general_task '+wpfb_metas.task_status+'" data-taskid="'+comment_count+'" data-postid="'+wpfb_task_id+'"><div class="wpf_task_number">'+bubble_label+'</div><div class="wpf_task_sum"><level class="task-author">'+wpfb_metas.task_config_author_name+' '+wpfb_metas.task_time+' <span>General</span></level><div class="current_page_task_list">'+wpfb_metas.task_title+'</div></div></li>';
        jQuery("#wpf_thispage_container").append(wpfb_current_page_task_list_html);
    }
    else{
        var wpfb_users_html = '<ul class="wp_feedback_filter_checkbox user">';
        for (var key in wpfb_users_arr) {
            if (wpfb_users_arr.hasOwnProperty(key)) {
                if(notify_users.includes(key)){
                    wpfb_users_html+='<li><input type="checkbox" name="author_list_'+comment_count+'" value="'+key+'" class="wp_feedback_task wpfbtasknotifyusers" data-elemid="'+comment_count+'" id="author_list_'+comment_count+'_'+key+'" checked><label for="author_list_'+comment_count+'_'+key+'">'+wpfb_users_arr[key]+'</label></li>';
                }
                else{
                    wpfb_users_html+='<li><input type="checkbox" name="author_list_'+comment_count+'" value="'+key+'" class="wp_feedback_task wpfbtasknotifyusers" data-elemid="'+comment_count+'" id="author_list_'+comment_count+'_'+key+'"><label for="author_list_'+comment_count+'_'+key+'">'+wpfb_users_arr[key]+'</label></li>';
                }
            }
        }
        wpfb_users_html+='</ul>';

        var temp_task_priority_low=temp_task_priority_medium=temp_task_priority_high=temp_task_priority_critical='';
        if(wpfb_metas.task_priority=='low'){temp_task_priority_low='checked';}
        else if(wpfb_metas.task_priority=='medium'){temp_task_priority_medium='checked';}
        else if(wpfb_metas.task_priority=='high'){temp_task_priority_high='checked';}
        else{temp_task_priority_critical='checked';}

        var wpfb_task_priority_html='<input id="priority_low-'+comment_count+'" type="radio" name="wpfbpriority'+comment_count+'" data-elemid="'+comment_count+'" value="low" class="wpfbpriority" '+temp_task_priority_low+'><label for="priority_low-'+comment_count+'">Low</label><input id="priority_medium-'+comment_count+'" type="radio" name="wpfbpriority'+comment_count+'" data-elemid="'+comment_count+'" value="medium" class="wpfbpriority" '+temp_task_priority_medium+'><label for="priority_medium-'+comment_count+'">Medium</label><input id="priority_high-'+comment_count+'" type="radio" name="wpfbpriority'+comment_count+'" data-elemid="'+comment_count+'" value="high" class="wpfbpriority" '+temp_task_priority_high+'><label for="priority_high-'+comment_count+'">High</label><input id="priority_critical-'+comment_count+'" type="radio" name="wpfbpriority'+comment_count+'" data-elemid="'+comment_count+'" value="critical" class="wpfbpriority" '+temp_task_priority_critical+'><label for="priority_critical-'+comment_count+'">Critical</label>';

        var temp_task_status_open=temp_task_status_inprogress=temp_task_status_pending_review=temp_task_status_complete='';
        if(wpfb_metas.task_status=='open'){temp_task_status_open='checked';}
        else if(wpfb_metas.task_status=='in-progress'){temp_task_status_inprogress='checked';}
        else if(wpfb_metas.task_status=='pending-review'){temp_task_status_pending_review='checked';}
        else{temp_task_status_complete='checked';}
        var wpfb_task_status_html='<input id="status_open-'+comment_count+'" type="radio" name="wpfbtaskstatus'+comment_count+'" value="open" data-elemid="'+comment_count+'" class="wpfbtaskstatus" '+temp_task_status_open+'><label for="status_open-'+comment_count+'">Open Task</label><input id="status_progress-'+comment_count+'" type="radio" name="wpfbtaskstatus'+comment_count+'" value="in-progress" data-elemid="'+comment_count+'" class="wpfbtaskstatus" '+temp_task_status_inprogress+' ><label for="status_progress-'+comment_count+'">In Progress</label><input id="status_pending-'+comment_count+'" type="radio" name="wpfbtaskstatus'+comment_count+'" value="pending-review" data-elemid="'+comment_count+'" class="wpfbtaskstatus" '+temp_task_status_pending_review+' ><label for="status_pending-'+comment_count+'">Pending Review</label><input id="status_complete-'+comment_count+'" type="radio" name="wpfbtaskstatus'+comment_count+'" value="complete" data-elemid="'+comment_count+'" class="wpfbtaskstatus" '+temp_task_status_complete+'><label for="status_complete-'+comment_count+'">Complete</label>';

        var wpfb_messages_html='';
        for (var key in wpfb_metas.comments) {
            if(wpfb_metas.comments[key].user_id==wpfb_metas.current_user_id){
                var task_author = "wpf_author";
            }
            else{
                var task_author = "wpf_other";
            }
            if(wpfb_metas.comments[key].comment_type==0){
                wpfb_messages_html += '<li class="'+task_author+'"><level class="task-author">'+wpfb_metas.comments[key].author+' '+wpfb_metas.comments[key].time+'</level><div class="meassage_area_main"><p class="chat_text">'+wpfb_metas.comments[key].message+'</p></div></li>';
            }
            else if (wpfb_metas.comments[key].comment_type==1) {
                wpfb_messages_html += '<li class="'+task_author+'"><level class="task-author">'+wpfb_metas.comments[key].author+' '+wpfb_metas.comments[key].time+'</level><div class="meassage_area_main"><img src="'+wpfb_metas.comments[key].message+'" class="wpf_task_uploaded_image" /></div></li>';
            }
            else{
                var wpf_download_file  = wpfb_metas.comments[key].message.split("/").pop();
                wpfb_messages_html += '<li class="'+task_author+'"><level class="task-author">'+wpfb_metas.comments[key].author+' '+wpfb_metas.comments[key].time+'</level><div class="meassage_area_main"><a href="'+wpfb_metas.comments[key].message+'" download="'+wpf_download_file+'" "><i class="fa fa-download" aria-hidden="true"></i> '+ wpf_download_file+'</a></div></li>';
            }
            jQuery('#task_comments_'+comment_count).append(wpfb_messages_html);

        }

        var wpfb_current_page_task_list_html = '<li class="current_page_task '+wpfb_metas.task_status+'" data-taskid="'+comment_count+'"><div class="wpf_task_number">'+bubble_label+'</div><div class="wpf_task_sum"><level class="task-author">'+wpfb_metas.task_config_author_name+' '+wpfb_metas.task_time+'</level><div class="current_page_task_list">'+wpfb_metas.task_title+'</div></div></li>';
        jQuery("#wpf_thispage_container").append(wpfb_current_page_task_list_html);

        response_html_new = wpf_task_popover_html(0,comment_count,wpfb_task_id,wpfb_metas,wpfb_users_html,wpfb_task_priority_html,wpfb_task_status_html,wpfb_messages_html);
        jQuery('#wpf_launcher').after(response_html_new);

        wpf_bubble_tracker(comment_count,wpfb_metas.task_clean_dom_elem_path);
        init_custom_popover_first(comment_count);
    }
}

function wpf_generate_general_task_html(wpfb_task_id,wpfb_metas){
    var notify_users = wpfb_metas.task_notify_users.split(',');
    var wpfb_users_arr = JSON.parse(wpfb_users);
    var comment_count = wpfb_metas.task_comment_id;

    var wpfb_users_html = '<ul class="wp_feedback_filter_checkbox user">';
    for (var key in wpfb_users_arr) {
        if (wpfb_users_arr.hasOwnProperty(key)) {
            if(notify_users.includes(key)){
                wpfb_users_html+='<li><input type="checkbox" name="author_list_'+comment_count+'" value="'+key+'" class="wp_feedback_task wpfbtasknotifyusers" data-elemid="'+comment_count+'" id="author_list_'+comment_count+'_'+key+'" checked><label for="author_list_'+comment_count+'_'+key+'">'+wpfb_users_arr[key]+'</label></li>';
            }
            else{
                wpfb_users_html+='<li><input type="checkbox" name="author_list_'+comment_count+'" value="'+key+'" class="wp_feedback_task wpfbtasknotifyusers" data-elemid="'+comment_count+'" id="author_list_'+comment_count+'_'+key+'"><label for="author_list_'+comment_count+'_'+key+'">'+wpfb_users_arr[key]+'</label></li>';
            }
        }
    }
    wpfb_users_html+='</ul>';

    var temp_task_priority_low=temp_task_priority_medium=temp_task_priority_high=temp_task_priority_critical='';
    if(wpfb_metas.task_priority=='low'){temp_task_priority_low='checked';}
    else if(wpfb_metas.task_priority=='medium'){temp_task_priority_medium='checked';}
    else if(wpfb_metas.task_priority=='high'){temp_task_priority_high='checked';}
    else{temp_task_priority_critical='checked';}

    var wpfb_task_priority_html='<input id="priority_low-'+comment_count+'" type="radio" name="wpfbpriority'+comment_count+'" data-elemid="'+comment_count+'" value="low" class="wpfbpriority" '+temp_task_priority_low+'><label for="priority_low-'+comment_count+'">Low</label><input id="priority_medium-'+comment_count+'" type="radio" name="wpfbpriority'+comment_count+'" data-elemid="'+comment_count+'" value="medium" class="wpfbpriority" '+temp_task_priority_medium+'><label for="priority_medium-'+comment_count+'">Medium</label><input id="priority_high-'+comment_count+'" type="radio" name="wpfbpriority'+comment_count+'" data-elemid="'+comment_count+'" value="high" class="wpfbpriority" '+temp_task_priority_high+'><label for="priority_high-'+comment_count+'">High</label><input id="priority_critical-'+comment_count+'" type="radio" name="wpfbpriority'+comment_count+'" data-elemid="'+comment_count+'" value="critical" class="wpfbpriority" '+temp_task_priority_critical+'><label for="priority_critical-'+comment_count+'">Critical</label>';

    var temp_task_status_open=temp_task_status_inprogress=temp_task_status_pending_review=temp_task_status_complete='';
    if(wpfb_metas.task_status=='open'){temp_task_status_open='checked';}
    else if(wpfb_metas.task_status=='in-progress'){temp_task_status_inprogress='checked';}
    else if(wpfb_metas.task_status=='pending-review'){temp_task_status_pending_review='checked';}
    else{temp_task_status_complete='checked';}
    var wpfb_task_status_html='<input id="status_open-'+comment_count+'" type="radio" name="wpfbtaskstatus'+comment_count+'" value="open" data-elemid="'+comment_count+'" class="wpfbtaskstatus" '+temp_task_status_open+'><label for="status_open-'+comment_count+'">Open Task</label><input id="status_progress-'+comment_count+'" type="radio" name="wpfbtaskstatus'+comment_count+'" value="in-progress" data-elemid="'+comment_count+'" class="wpfbtaskstatus" '+temp_task_status_inprogress+' ><label for="status_progress-'+comment_count+'">In Progress</label><input id="status_pending-'+comment_count+'" type="radio" name="wpfbtaskstatus'+comment_count+'" value="pending-review" data-elemid="'+comment_count+'" class="wpfbtaskstatus" '+temp_task_status_pending_review+' ><label for="status_pending-'+comment_count+'">Pending Review</label><input id="status_complete-'+comment_count+'" type="radio" name="wpfbtaskstatus'+comment_count+'" value="complete" data-elemid="'+comment_count+'" class="wpfbtaskstatus" '+temp_task_status_complete+'><label for="status_complete-'+comment_count+'">Complete</label>';

    var wpfb_messages_html='';
    for (var key in wpfb_metas.comments) {
        if(wpfb_metas.comments[key].user_id==wpfb_metas.current_user_id){
            var task_author = "wpf_author";
        }
        else{
            var task_author = "wpf_other";
        }
        if(wpfb_metas.comments[key].comment_type==0){
            wpfb_messages_html += '<li class="'+task_author+'"><level class="task-author">'+wpfb_metas.comments[key].author+' '+wpfb_metas.comments[key].time+'</level><div class="meassage_area_main"><p class="chat_text">'+wpfb_metas.comments[key].message+'</p></div></li>';
        }
        else if (wpfb_metas.comments[key].comment_type==1) {
            wpfb_messages_html += '<li class="'+task_author+'"><level class="task-author">'+wpfb_metas.comments[key].author+' '+wpfb_metas.comments[key].time+'</level><div class="meassage_area_main"><img src="'+wpfb_metas.comments[key].message+'" class="wpf_task_uploaded_image" /></div></li>';
        }
        else{
            var wpf_download_file  = wpfb_metas.comments[key].message.split("/").pop();
            wpfb_messages_html += '<li class="'+task_author+'"><level class="task-author">'+wpfb_metas.comments[key].author+' '+wpfb_metas.comments[key].time+'</level><div class="meassage_area_main"><a href="'+wpfb_metas.comments[key].message+'" download="'+wpf_download_file+'" "><i class="fa fa-download" aria-hidden="true"></i> '+ wpf_download_file+'</a></div></li>';
        }
        jQuery('#task_comments_'+comment_count).append(wpfb_messages_html);

    }

    var wpf_tmp_general_response_html = wpf_task_popover_html(3,comment_count,wpfb_task_id,wpfb_metas,wpfb_users_html,wpfb_task_priority_html,wpfb_task_status_html,wpfb_messages_html);
    jQuery('#wpf_general_comment_tabs').html(wpf_tmp_general_response_html);
}

function wpf_task_popover_html(wpf_task_type,comment_count,wpfb_task_id,wpfb_metas,wpfb_users_html,wpfb_task_priority_html,wpfb_task_status_html,wpfb_messages_html) {
    if(wpf_task_type==2 || wpf_task_type==3){
        curr_browser_temp = get_browser();
        browser = curr_browser_temp['name']+' '+curr_browser_temp['version'];
        var wpf_config_resolution = resolution;
        var wpf_config_browser = browser;
        var wpf_config_author_name = current_user_name;
        var wpf_config_ip_address = ipaddress;
        var wpf_config_task_id = '';
    }
    else if(wpf_task_type==1){
        var wpf_config_resolution = resolution;
        var wpf_config_browser = browser;
        var wpf_config_author_name = current_user_name;
        var wpf_config_ip_address = ipaddress;
        var wpf_config_task_id = '';
        var element_center = getelementcenter(rightArrowParents.join(" > "));
        element_center['left']=element_center['left']-25;
        element_center['top']=element_center['top']-25;
    }
    else{
        var wpf_config_resolution = wpfb_metas.task_config_author_resX+' x '+wpfb_metas.task_config_author_resY;
        var wpf_config_browser = wpfb_metas.task_config_author_browser;
        var wpf_config_author_name = wpfb_metas.task_config_author_name;
        var wpf_config_ip_address = wpfb_metas.task_config_author_ipaddress;
        var wpf_config_task_id = wpfb_task_id;
        var element_center = getelementcenter(wpfb_metas.wpfb_task_bubble);
    }

    if(wpf_task_type==2 || wpf_task_type==3){
        var button_html ='';
    }
    else{
        if(wpfb_metas.task_status!='complete'){
            jQuery(wpfb_metas.task_element_path).addClass('wpfb_task_bubble');
            jQuery(wpfb_metas.task_element_path).attr('data-task_id', wpfb_metas.task_comment_id);
        }

        if(element_center['left']==0 && element_center['top']==0){
            var x_per = 100*(wpfb_metas.task_elementX/wpfb_metas.task_config_author_resX);
            var y_per = 100*(wpfb_metas.task_elementY/wpfb_metas.task_config_author_resY);
            element_center['left']=(x_per*window.screen.width)/100;
            element_center['top']=(y_per*window.screen.height)/100;
        }
        else{
            element_center['left']=element_center['left']-25;
            element_center['top']=element_center['top']-25;
        }

        if(wpfb_metas.task_status=='complete'){
            var bubble_label = '<i class="fa fa-check"></i>';
        }
        else{
            var bubble_label = comment_count;
        }

        if(wpf_task_type==1){
            var button_html = '<a id="bubble-'+comment_count+'" data-html2canvas-ignore="true" href="javascript:void(0)" rel="popover-'+comment_count+'" data-html="true" data-trigger="focus" data-popover-content="#popover-content-c'+comment_count+'" class="wpfb-point" style="top:'+element_center['top']+'px;left:'+element_center['left']+'px;" data-toggle="popover">'+comment_count+'</a>';
        }
        else{
            if(wpf_show_front_stikers=='yes'){
                var wpf_hide_class = '';
            }
            else{
                var wpf_hide_class = 'wpf_hide';
            }
            var button_html = '<a id="bubble-'+comment_count+'" data-html2canvas-ignore="true" href="javascript:void(0)" rel="popover-'+comment_count+'" data-html="true" data-trigger="focus" data-popover-content="#popover-content-c'+comment_count+'" class="wpfb-point '+wpfb_metas.task_status+' '+wpf_hide_class+'" style="top:'+element_center['top']+'px;left:'+element_center['left']+'px;" data-toggle="popover">'+bubble_label+'</a>';
        }
    }

    if(wpf_task_type==2 || wpf_task_type==3){
        var popover_container = '<div class=""><div data-html2canvas-ignore="true" id="popover-content-c'+comment_count+'"><div class="wpf_loader wpf_loader_'+comment_count+' wpf_hide"></div>';
    }
    else{
        var popover_container = '<div class=""><div data-html2canvas-ignore="true" id="popover-content-c'+comment_count+'" class="hide"><div class="wpf_loader wpf_loader_'+comment_count+' wpf_hide"></div><a href="javascript:void(0)" class="close" data-dismiss="alert">&times;</a>';
    }

    var tab_nav_html = '<ul class="nav nav-tabs" id="myTab-'+comment_count+'" role="tablist">';
    if(wpf_tab_permission.user==true){
        tab_nav_html+='<li class="nav-item"><a class="nav-link wpf_user_tab" id="wpfbuser-tab-'+comment_count+'" data-toggle="tab" href="#wpfbuser-'+comment_count+'" role="tab" aria-controls="wpfbuser" aria-selected="false"><i class="fa fa-user"></i></a></li>';
    }
    if(wpf_tab_permission.priority==true){
        tab_nav_html+='<li class="nav-item"><a class="nav-link wpf_prio_tab" id="wpfbpriority-tab-'+comment_count+'" data-toggle="tab" href="#wpfbpriority-'+comment_count+'" role="tab" aria-controls="wpfbpriority" aria-selected="false"><i class="fa fa-exclamation-circle"></i></a></li>';
    }
    if(wpf_tab_permission.status==true){
        tab_nav_html+='<li class="nav-item"><a class="nav-link wpf_stat_tab" id="wpfbtaskstatus-tab-'+comment_count+'" data-toggle="tab" href="#wpfbtaskstatus-'+comment_count+'" role="tab" aria-controls="wpfbtaskstatus" aria-selected="false"><i class="fa fa-thermometer-half"></i></a></li>';
    }
    if(wpf_tab_permission.screenshot==true){
        tab_nav_html+='<li class="nav-item"><a class="nav-link wpf_scrn_tab" id="wpfbscreenshot-tab-'+comment_count+'" data-toggle="tab" href="#wpfbscreenshot-'+comment_count+'" role="tab" aria-controls="wpfbscreenshot" aria-selected="false"><i class="fa fa-camera"></i></a></li>';
    }
    if(wpf_tab_permission.information==true){
        tab_nav_html+='<li class="nav-item"><a class="nav-link wpf_deta_tab" id="wpfbsysinfo-tab-'+comment_count+'" data-toggle="tab" href="#wpfbsysinfo-'+comment_count+'" role="tab" aria-controls="wpfbsysinfo" aria-selected="false"><i class="fa fa-compass"></i></a></li>';
    }
    tab_nav_html+='</ul>';

    var tabs_html = '<div class="tab-content" id="myTabContent-'+comment_count+'">';

    tabs_html+='<div class="tab-pane" id="wpfbsysinfo-'+comment_count+'" role="tabpanel" aria-labelledby="wpfbsysinfo-tab"><ul><li><b>Resolution:</b> <span id="wpfbsysinfo_resolution-'+comment_count+'">'+wpf_config_resolution+'</span></li><li><b>Browser:</b> <span id="wpfbsysinfo_browser-'+comment_count+'">'+wpf_config_browser+'</span></li><li><b>User Name:</b> <span id="wpfbsysinfo_user_name-'+comment_count+'">'+wpf_config_author_name+'</span></li><li><b>User IP:</b> <span id="wpfbsysinfo_user_ip-'+comment_count+'">'+wpf_config_ip_address+'</span></li><li><b>Task ID:</b> <span id="wpfbsysinfo_task_id-'+comment_count+'">'+wpf_config_task_id+'</span></li>';

    if(wpf_task_type==1 || wpf_task_type==2){
        tabs_html+='<li id="wpf_delete_container_'+comment_count+'"><span class="wpfbsysinfo_temp_delete_btn_task_id_'+comment_count+'"><a href="javascript:void(0)" class="wpf_task_temp_delete_btn" style="color:red;" data-btn_elemid="'+comment_count+'"  ><i class="fa fa-trash" aria-hidden="true"></i> Delete Ticket</a></span><p class="wpfbsysinfo_temp_delete_task_id_'+comment_count+' wpf_hide" >Better to change the status to complete. Are you sure you want to delete?<a href="javascript:void(0)" class="wpf_task_temp_delete" data-elemid="'+comment_count+'" style="color:red;"> Yes</a></p></li>';
    }
    else{
        if(wpf_tab_permission.delete_task=='all'){
            tabs_html+='<li><span class="wpfbsysinfo_delete_btn_task_id_'+comment_count+'"><a href="javascript:void(0)" class="wpf_task_delete_btn" data-btn_taskid="'+wpfb_task_id+'" style="color:red;"><i class="fa fa-trash" aria-hidden="true"></i> Delete ticket</a></span><p class="wpfbsysinfo_delete_task_id_'+wpfb_task_id+' wpf_hide" ><b>Better to change the status to complete.</b><br>Are you sure you want to delete? <a href="javascript:void(0)" class="wpf_task_delete" data-taskid="'+wpfb_task_id+'" data-elemid="'+comment_count+'" style="color:red;"><b>Yes</b></a></p></li>';
        }
        else if(wpf_tab_permission.delete_task=='own'){
            if(wpfb_metas.task_config_author_id==current_user_id){
                tabs_html+='<li><span class="wpfbsysinfo_delete_btn_task_id_'+comment_count+'"><a href="javascript:void(0)" class="wpf_task_delete_btn" data-btn_taskid="'+wpfb_task_id+'" style="color:red;"><i class="fa fa-trash" aria-hidden="true"></i> Delete ticket</a></span><p class="wpfbsysinfo_delete_task_id_'+wpfb_task_id+' wpf_hide" ><b>Better to change the status to complete.</b><br>Are you sure you want to delete? <a href="javascript:void(0)" class="wpf_task_delete" data-taskid="'+wpfb_task_id+'" data-elemid="'+comment_count+'" style="color:red;"><b>Yes</b></a></p></li>';
            }
        }
    }

    tabs_html+='</ul></div>';

    tabs_html+='<div class="tab-pane" id="wpfbuser-'+comment_count+'" role="tabpanel" aria-labelledby="home-tab">'+wpfb_users_html+'</div>';

    if(wpf_task_type==1 || wpf_task_type==2){
        tabs_html+='<div class="tab-pane" id="wpfbpriority-'+comment_count+'" role="tabpanel" aria-labelledby="wpfbpriority-tab"><div class="anim-slider"><input id="priority_low-'+comment_count+'" type="radio" name="wpfbpriority'+comment_count+'" data-elemid="'+comment_count+'" value="low" class="wpfbpriority" checked><label for="priority_low-'+comment_count+'">Low</label><input id="priority_medium-'+comment_count+'" type="radio" name="wpfbpriority'+comment_count+'" data-elemid="'+comment_count+'" value="medium" class="wpfbpriority"><label for="priority_medium-'+comment_count+'">Medium</label><input id="priority_high-'+comment_count+'" type="radio" name="wpfbpriority'+comment_count+'" data-elemid="'+comment_count+'" value="high" class="wpfbpriority"><label for="priority_high-'+comment_count+'">High</label><input id="priority_critical-'+comment_count+'" type="radio" name="wpfbpriority'+comment_count+'" data-elemid="'+comment_count+'" value="critical" class="wpfbpriority"><label for="priority_critical-'+comment_count+'">Critical</label></div></div>';
        tabs_html+='<div class="tab-pane" id="wpfbtaskstatus-'+comment_count+'" role="tabpanel" aria-labelledby="wpfbtaskstatus-tab"><div class="anim-slider"><input id="status_open-'+comment_count+'" type="radio" name="wpfbtaskstatus'+comment_count+'" value="open" data-elemid="'+comment_count+'" class="wpfbtaskstatus" checked><label for="status_open-'+comment_count+'">Open Task</label><input id="status_progress-'+comment_count+'" type="radio" name="wpfbtaskstatus'+comment_count+'" value="in-progress" data-elemid="'+comment_count+'" class="wpfbtaskstatus" ><label for="status_progress-'+comment_count+'">In Progress</label><input id="status_pending-'+comment_count+'" type="radio" name="wpfbtaskstatus'+comment_count+'" value="pending-review" data-elemid="'+comment_count+'" class="wpfbtaskstatus" ><label for="status_pending-'+comment_count+'">Pending Review</label><input id="status_complete-'+comment_count+'" type="radio" name="wpfbtaskstatus'+comment_count+'" value="complete" data-elemid="'+comment_count+'" class="wpfbtaskstatus" ><label for="status_complete-'+comment_count+'">Complete</label></div></div>';
        tabs_html+='<div class="tab-pane" id="wpfbscreenshot-'+comment_count+'" role="tabpanel" aria-labelledby="wpfbscreenshot-tab"><a href="javascript:void(0)" onclick="screenshot('+comment_count+');"><div class="wpf_screenshot_button">Screenshot The Current View</div></a><img src="" id="screenshot_img_'+comment_count+'" style="display:none; margin-top:10px; border:2px solid;" /></div><div  id="task_comments_section_'+comment_count+'"><ul class="wpf_current_chat_box" id="task_comments_'+comment_count+'"></ul></div>';
    }
    else{
        tabs_html+='<div class="tab-pane" id="wpfbpriority-'+comment_count+'" role="tabpanel" aria-labelledby="wpfbpriority-tab"><div class="anim-slider">'+wpfb_task_priority_html+'</div></div>';
        tabs_html+='<div class="tab-pane" id="wpfbtaskstatus-'+comment_count+'" role="tabpanel" aria-labelledby="wpfbtaskstatus-tab"><div class="anim-slider">'+wpfb_task_status_html+'</div></div>';
        tabs_html+='<div class="tab-pane" id="wpfbscreenshot-'+comment_count+'" role="tabpanel" aria-labelledby="wpfbscreenshot-tab"><a href="javascript:void(0)" onclick="screenshot('+comment_count+');"><div class="wpf_screenshot_button">Screenshot The Current View</div></a><img src="" id="screenshot_img_'+comment_count+'" style="display:none; margin-top:10px; border:2px solid;" /></div><div id="task_comments_section_'+comment_count+'"><ul class="wpf_current_chat_box" id="task_comments_'+comment_count+'">'+wpfb_messages_html+'</ul></div>';
    }

    tabs_html+='</div>';

    var comment_html = '<div class="form-group"><textarea class="form-control" id="comment-'+comment_count+'" placeholder="Leave a comment..."></textarea><span id="wpf_error_'+comment_count+'" class="wpf_hide">A user must be selected to post a comment</span><span id="wpf_task_error_'+comment_count+'" class="wpf_hide">Please enter a comment before perform this action</span><button onclick="new_comment('+comment_count+')">Add comment</button><button class="wpf_upload_button"><input type="file" name="wpf_uploadfile_'+comment_count+'" id="wpf_uploadfile_'+comment_count+'" data-elemid="'+comment_count+'" class="wpf_uploadfile"> <i class="fa fa-upload" aria-hidden="true"></i></button><p id="wpf_upload_error_'+comment_count+'" class="wpf_hide">You are trying to upload an invalid filetype </br> Allowd File Types: JPG, PNG, GIF, PDF, DOC, DOCX and XLSX</p></div></div></div>';

    var response_html = button_html+popover_container+tab_nav_html+tabs_html+comment_html;

    return response_html;
}

function openWPFTab(wpfTab) {
    if(wpfTab == 'wpf_allpages'){
        jQuery('.wpf_sidebar_content').find('#wpf_thispage').hide(); 
        jQuery('.wpf_sidebar_content').find('#wpf_allpages').show(); 
        jQuery('button.wpf_tab_sidebar').removeClass('wpf_active');
        jQuery('button.wpf_tab_sidebar.'+wpfTab).addClass('wpf_active');
        if(all_page_tasks_loaded==0){
            all_page_tasks_loaded=1;
            load_all_page_tasks();
        }
    }
    else{
       jQuery('.wpf_sidebar_content').find('#wpf_allpages').hide(); 
       jQuery('.wpf_sidebar_content').find('#wpf_thispage').show(); 
       jQuery('button.wpf_tab_sidebar').removeClass('wpf_active');
       jQuery('button.wpf_tab_sidebar.'+wpfTab).addClass('wpf_active');
    }
}

function load_all_page_tasks(){
    jQuery.ajax({
        method:"POST",
        url: ajaxurl,
        data: {action:'load_wpfb_tasks'},
        beforeSend: function(){
    		jQuery('.wpf_sidebar_loader').show();
		},
        success: function(data){
        	jQuery('.wpf_sidebar_loader').hide();
            var onload_wpfb_tasks = JSON.parse(data);

            const k = Object.keys(onload_wpfb_tasks).sort(timeSort);

            comment_count_initial = Object.keys(onload_wpfb_tasks).length;

            var wpfb_all_page_task_list_html = '';
            jQuery.each(k,function (index, value) {
                var general_tag = '';
                tasks_on_page[comment_count_initial]=value;
                if(onload_wpfb_tasks[value].task_status=='complete'){
                    var bubble_label = '<i class="fa fa-check"></i>';
                }
                else{
                    var bubble_label = onload_wpfb_tasks[value].task_comment_id;

                }
                if(onload_wpfb_tasks[value].task_type=='general'){
                    general_tag = '<span>General</span>';
                    wpfb_all_page_task_list_html += '<li class="current_page_task ' +onload_wpfb_tasks[value].task_status+'" data-taskid="'+onload_wpfb_tasks[value].task_comment_id+'" data-postid="'+value+'" data-task_url="'+onload_wpfb_tasks[value].task_page_url+'?wpf_general_taskid='+value+'"><div class="wpf_task_number">'+bubble_label+'</div><div class="wpf_task_sum"><level class="task-author">'+onload_wpfb_tasks[value].task_config_author_name+' '+onload_wpfb_tasks[value].task_time+' '+general_tag+'</level><div class="wpf_task_pagename">'+onload_wpfb_tasks[value].task_page_title+'</div><div class="current_page_task_list">'+onload_wpfb_tasks[value].task_title+'</div></div></li>';
                }
                else{
                    wpfb_all_page_task_list_html += '<li class="current_page_task ' +onload_wpfb_tasks[value].task_status+'" data-taskid="'+onload_wpfb_tasks[value].task_comment_id+'" data-task_url="'+onload_wpfb_tasks[value].task_page_url+'?wpf_taskid='+onload_wpfb_tasks[value].task_comment_id+'"><div class="wpf_task_number">'+bubble_label+'</div><div class="wpf_task_sum"><level class="task-author">'+onload_wpfb_tasks[value].task_config_author_name+' '+onload_wpfb_tasks[value].task_time+' '+general_tag+'</level><div class="wpf_task_pagename">'+onload_wpfb_tasks[value].task_page_title+'</div><div class="current_page_task_list">'+onload_wpfb_tasks[value].task_title+'</div></div></li>';
                }

                comment_count_initial--;
            });

            jQuery("#wpf_allpages_container").html(wpfb_all_page_task_list_html);
        }
    });
}

function getDomPath(el) {
    var stack = [];
    while ( el.parentNode != null ) {
        var sibCount = 0;
        var sibIndex = 0;
        for ( var i = 0; i < el.parentNode.childNodes.length; i++ ) {
            var sib = el.parentNode.childNodes[i];
            if ( sib.nodeName == el.nodeName ) {
                if ( sib === el ) {
                    sibIndex = sibCount;
                }
                sibCount++;
            }
        }
        if ( el.hasAttribute('id') && el.id != '' ) {
            stack.unshift(el.nodeName.toLowerCase() + '#' + el.id);
        } else if ( sibCount > 1 ) {
            stack.unshift(el.nodeName.toLowerCase() + ':eq(' + sibIndex + ')');
        } else {
            stack.unshift(el.nodeName.toLowerCase());
        }
        el = el.parentNode;
    }

    return stack.slice(1); /*removes the html element*/
}

jQuery.fn.onPositionChanged = function (trigger, millis) {
    if (millis == null) millis = 100;
    var o = jQuery(this[0]); /*our jquery object*/
    if (o.length < 1) return o;

    var lastPos = null;
    var lastOff = null;
    setInterval(function () {
        if (o == null || o.length < 1) return o; /*abort if element is non existend eny more*/
        if (lastPos == null) lastPos = o.position();
        if (lastOff == null) lastOff = o.offset();
        var newPos = o.position();
        var newOff = o.offset();
        if (lastPos.top != newPos.top || lastPos.left != newPos.left) {
            jQuery(this).trigger('onPositionChanged', { lastPos: lastPos, newPos: newPos });
            if (typeof (trigger) == "function") trigger(lastPos, newPos);
            lastPos = o.position();
        }
        if (lastOff.top != newOff.top || lastOff.left != newOff.left) {
            jQuery(this).trigger('onOffsetChanged', { lastOff: lastOff, newOff: newOff});
            if (typeof (trigger) == "function") trigger(lastOff, newOff);
            lastOff= o.offset();
        }
    }, millis);

    return o;
};

function wpf_bubble_tracker(comment_count,task_clean_dom_elem_path) {
    jQuery(task_clean_dom_elem_path).onPositionChanged(function(){
        setTimeout(function() {
            var element_center = getelementcenter(task_clean_dom_elem_path);
            element_center['left']=element_center['left']-25;
            element_center['top']=element_center['top']-25;
            jQuery('#bubble-'+comment_count).attr('style','top:'+element_center['top']+'px; left:'+element_center['left']+'px;')
        }, 0);

    });
}

function trigger_bubble_label(){
    var wpf_page_value = getParameterByName('wpf_taskid');
    if(wpf_page_value != ''){
        var wpf_tmp_show_task_checkbox_obj = jQuery("#wpfb_display_tasks");
        if(wpf_tmp_show_task_checkbox_obj.prop('checked')==false){
            wpf_tmp_show_task_checkbox_obj.prop('checked',true);
        }
        wpf_display_tasks(wpf_tmp_show_task_checkbox_obj);

        setTimeout(function() { jQuery('body').find('#bubble-'+wpf_page_value).trigger('click')},20);

        jQuery('html, body').animate({
            scrollTop: jQuery("#bubble-"+wpf_page_value).offset().top - 200
        }, 1000);
    }

    var wpf_general_taskid_value = getParameterByName('wpf_general_taskid');
    if(wpf_general_taskid_value != ''){
        wpf_load_general_task(wpf_general_taskid_value);
    }
}

function getParameterByName( name ){
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( window.location.href );
    if( results == null )
        return "";
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function wpf_delete_task(id,task_id){
    var task_info = [];
    task_info['task_id'] = task_id;
    task_info['task_no']=id;
    var task_info_obj = jQuery.extend({}, task_info);
    jQuery.ajax({
        method : "POST",
        url : ajaxurl,
        data : {action: "wpfb_delete_task",task_info:task_info_obj},
        beforeSend: function(){
            jQuery('.wpf_loader_'+id).show();
        },
        success : function(data){
            jQuery('#bubble-'+id).trigger('click');
            jQuery('.wpf_general_task_close').trigger('click');
            jQuery('#bubble-'+id).remove();
            jQuery('.wpf_loader_'+id).hide();
            jQuery('#wpf_thispage_container [data-taskid="'+id+'"]').remove();
            jQuery('#wpf_allpages_container [data-taskid="'+id+'"]').remove();
            jQuery(onload_wpfb_tasks[task_id].task_element_path).removeClass('wpfb_task_bubble');
        }
    });
}

function wpf_send_report(type) {
    jQuery.ajax({
        method: "POST",
        url: ajaxurl,
        data: {action: "wpf_send_email_report", type:type},
        beforeSend: function(){
            jQuery('.wpf_sidebar_loader').show();
        },
        success: function (data) {
            jQuery('.wpf_sidebar_loader').hide();
            jQuery('#wpf_front_report_sent_span').show();
            setTimeout(function() {
                jQuery('#wpf_front_report_sent_span').hide();
            }, 3000);
        }
    });
}

function wpf_upload_file(obj){
    var elemid = jQuery(obj).attr('data-elemid'), task_info=[];
    var wpf_file = jQuery('#wpf_uploadfile_'+elemid)[0].files[0];
    var wpf_taskid = tasks_on_page[elemid];
    var wpf_comment = '';
    var wpf_upload_form = new FormData();
    wpf_upload_form.append('action', 'wpf_upload_file');
    wpf_upload_form.append("wpf_taskid", wpf_taskid);
    wpf_upload_form.append("wpf_upload_file", wpf_file);
    wpf_upload_form.append('task_config_author_name', current_user_name);
    if(wpf_taskid > 0){
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: wpf_upload_form,
            contentType: false,
            processData: false,
            beforeSend: function(){
                jQuery('.wpf_loader_'+elemid).show();
            },
            success: function (data) {
                var response = JSON.parse(data);
                jQuery('.wpf_loader_'+elemid).hide();

                if(response.status==1){
                    jQuery("input[name=wpf_uploadfile_"+elemid+"]").val('');

                    if(response.type==1){
                        var comment_html = '<li class="wpf_author"><level class="task-author">'+current_user_name+'</level><div class="meassage_area_main"><img src="'+response.message+'" /></div></li>';
                    }
                    else{
                        var wpf_download_file  = response.message.split("/").pop();
                        var comment_html = '<li class="wpf_author"><level class="task-author">'+current_user_name+' just now</level><div class="meassage_area_main"><a href="'+response.message+'" download="'+wpf_download_file+'"><i class="fa fa-download" aria-hidden="true"></i> '+ wpf_download_file+'</a></div></li>';
                    }

                    jQuery('#task_comments_'+elemid).append(comment_html);
                    jQuery('#task_comments_'+elemid).animate({scrollTop: jQuery('#task_comments_'+elemid).prop("scrollHeight")}, 2000);
                }
                else{
                    jQuery('#wpf_upload_error_'+elemid).show();
                    setTimeout(function() {
                        jQuery('#wpf_upload_error_'+elemid).hide();
                    }, 5000);
                }
            }
        });
    }else{
        jQuery('#wpf_error_'+elemid).hide();
        jQuery('#wpf_task_error_'+elemid).show();
    }
}

/*FRONTEND ACTICATION WIZARD / ONBOARDING*/
jQuery(document).ready(function () {
    /*STEP 1 BUTTONS*/
    jQuery('input[name="wpf_user_type"]').on('click',function () {
        var wpf_user_type = jQuery('input[name="wpf_user_type"]:checked').val();
        jQuery.ajax({
            method: 'POST',
            url:ajaxurl,
            data:{action: 'wpf_update_current_user_first_step',current_user_id:current_user_id,wpf_user_type:wpf_user_type},
            beforeSend: function(){
                jQuery('.wpf_loader_wizard').show();
            },
            success: function (data) {
                jQuery('.wpf_loader_wizard').hide();
                if(data==1){
                    jQuery('#wpf_wizard_notifications').show();
                    jQuery('#wpf_wizard_role').hide();
                }
            }
        });
        return false;
    });
    /*STEP 2 BUTTONS*/
    jQuery('#wpf_wizard_notifications_button').on('click',function (e) {
        var wpf_every_new_task = jQuery('#wpf_every_new_task:checkbox:checked').val();
        var wpf_every_new_comment = jQuery('#wpf_every_new_comment:checkbox:checked').val();
        var wpf_every_new_complete = jQuery('#wpf_every_new_complete:checkbox:checked').val();
        var wpf_every_status_change = jQuery('#wpf_every_status_change:checkbox:checked').val();
        var wpf_daily_report = jQuery('#wpf_daily_report:checkbox:checked').val();
        var wpf_weekly_report = jQuery('#wpf_weekly_report:checkbox:checked').val();
        jQuery.ajax({
            url:ajaxurl,
            method: 'POST',
            data:{action: 'wpf_update_current_user_first_step',current_user_id:current_user_id,wpf_every_new_task:wpf_every_new_task,wpf_every_new_comment:wpf_every_new_comment,wpf_every_new_complete:wpf_every_new_complete,wpf_every_status_change:wpf_every_status_change,wpf_daily_report:wpf_daily_report,wpf_weekly_report:wpf_weekly_report},
            beforeSend: function(){
                jQuery('.wpf_loader_wizard').show();
            },
            success: function (data) {
                jQuery('#wpf_wizard_role,#wpf_wizard_notifications').hide();
                jQuery('#wpf_wizard_final').show();
                jQuery('.wpf_loader_wizard').hide();
                if(data==1){

                }
            }
        });
        return false;
    });
    /*STEP 2 BUTTONS*/
    jQuery('#wpf_wizard_done_button').on('click',function (e) {
        lets_start = '';
        jQuery.ajax({
            url:ajaxurl,
            method: 'POST',
            data:{action: 'wpf_update_current_user_sec_step',current_user_id:current_user_id,lets_start:1},
            beforeSend: function(){
                jQuery('.wpf_loader_wizard').show();
            },
            success: function (data) {
                location.reload(true);
            }
        });
        return false;
    });
});

function wpf_new_general_task(id) {
    disable_comment();
    if(id==0){
        tasks_on_page[comment_count]=0;
        var wpfb_users_arr = JSON.parse(wpfb_users);
        var wpfb_users_html = '<ul class="wp_feedback_filter_checkbox user">';

        for (var key in wpfb_users_arr) {
            if (wpfb_users_arr.hasOwnProperty(key)) {
                if(current_user_id==key || wpf_website_builder==key){
                    wpfb_users_html+='<li><input type="checkbox" name="author_list_'+comment_count+'" value="'+key+'" class="wp_feedback_task wpfbtasknotifyusers" data-elemid="'+comment_count+'" id="author_list_'+comment_count+'_'+key+'" checked><label for="author_list_'+comment_count+'_'+key+'">'+wpfb_users_arr[key]+'</label></li>';
                }
                else{
                    wpfb_users_html+='<li><input type="checkbox" name="author_list_'+comment_count+'" value="'+key+'" class="wp_feedback_task wpfbtasknotifyusers" data-elemid="'+comment_count+'" id="author_list_'+comment_count+'_'+key+'"><label for="author_list_'+comment_count+'_'+key+'">'+wpfb_users_arr[key]+'</label></li>';
                }
            }
        }
        wpfb_users_html+='</ul>';
        var wpf_popover_html = wpf_task_popover_html(2,comment_count,0,'',wpfb_users_html,'','','');
        jQuery('#wpf_general_comment_tabs').html(wpf_popover_html);
        jQuery('#wpf_general_comment').show();
        jQuery("#wpf_uploadfile_"+comment_count).change(function () {
            wpf_upload_file(this);
        });

        jQuery('.wpf_task_temp_delete_btn').click(function(){
            var btn_taskid = jQuery(this).data('btn_elemid');
            jQuery('.wpfbsysinfo_temp_delete_task_id_'+btn_taskid).show();
        });

        jQuery('.wpf_task_temp_delete').click(function(){
            var elemid = jQuery(this).data('elemid');
            jQuery('#wpf_general_comment .wpf_general_task_close').trigger('click');
        });

    }
}

function wpf_load_general_task(id) {
    jQuery.ajax({
        url:ajaxurl,
        method:'POST',
        data:{action:'load_wpfb_tasks',task_id:id},
        beforeSend: function(){
            jQuery('.wpf_sidebar_loader').show();
        },
        success: function (data) {
            jQuery('.wpf_sidebar_loader').hide();
            var task_info = JSON.parse(data);
            var task_id = Object.keys(task_info)[0];
            var task_meta = task_info[task_id];
            wpf_generate_general_task_html(task_id,task_meta);
            jQuery('#wpf_general_comment').show();
            jQuery("#wpf_uploadfile_"+task_meta.task_comment_id).change(function () {
                wpf_upload_file(this);
            });
            wpf_initiate_task_features();
        }
    });
}

function wpf_initiate_task_features(){
    jQuery('.wpfbpriority').click(function(){
        var elemid = jQuery(this).attr('data-elemid');
        set_task_prioirty(elemid);
    });
    jQuery('.wpfbtaskstatus').click(function(){
        var elemid = jQuery(this).attr('data-elemid');
        set_task_status(elemid);
    });
    jQuery('.wpfbtasknotifyusers').click(function(){
        var elemid = jQuery(this).attr('data-elemid');
        set_task_notify_users(elemid);
    });
    jQuery('.wpf_task_delete_btn').click(function(){
        var btn_taskid = jQuery(this).data('btn_taskid');
        jQuery('.wpfbsysinfo_delete_task_id_'+btn_taskid).show();
    });
    jQuery('.wpf_task_delete').click(function(){
        var elemid = jQuery(this).data('elemid');
        var task_id = jQuery(this).data('taskid');
        wpf_delete_task(elemid,task_id);
    });
}