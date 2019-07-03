<?php
function wp_feedback_get_texonomy($my_term){
	$terms = get_terms( array(
	    'taxonomy' => $my_term,
	    'hide_empty' => false,
	));
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	    echo '<ul class="wp_feedback_filter_checkbox">';
	    foreach ( $terms as $term ) {
	        echo '<li><input type="checkbox" name="'.$my_term.'" value="'.$term->slug.'" class="wp_feedback_task" id="'.$term->slug.'"/><label for="'.$term->slug.'">' . $term->name . '</label></li>';
	    }
	    echo '</ul>';
	}
}

add_shortcode('wpf_user_role_list','wp_feedback_get_user_role_list');
function wp_feedback_get_user_role_list(){
    $editable_roles = get_editable_roles();
    return $editable_roles;
}

add_shortcode('wpf_user_list','wp_feedback_get_user_list');
function wp_feedback_get_user_list(){
    $all_role_cs = get_option('wpf_selcted_role',true);
    $all_role_array = explode(",", $all_role_cs);
    if ( ! empty( $all_role_array ) && ! is_wp_error( $all_role_array ) ){
        $blogusers = get_users( [ 'role__in' => $all_role_array ] );
        // Array of WP_User objects.
        echo '<ul class="wp_feedback_filter_checkbox user">';
        foreach ( $blogusers as $user ) {
            echo '<li><input type="checkbox" name="author_list" value="'.$user->ID.'" class="wp_feedback_task" id="'.$user->ID.'" /><label for="'.$user->ID.'">' . esc_html( $user->display_name ) . '</label></li>';
        }
        echo '</ul>';
    }
}

add_shortcode('wpf_user_list_task','wp_feedback_get_user_list_task');
function wp_feedback_get_user_list_task(){
	$all_role_cs = get_option('wpf_selcted_role',true);
	$all_role_array = explode(",", $all_role_cs);
	if ( ! empty( $all_role_array ) && ! is_wp_error( $all_role_array ) ){
		$blogusers = get_users( [ 'role__in' => $all_role_array ] );
		// Array of WP_User objects.
		 echo '<ul class="wp_feedback_filter_checkbox user">';
	    foreach ( $blogusers as $user ) {
	        echo '<li><input type="checkbox" name="author_list_task" value="'.$user->ID.'" class="wp_feedback_task" id="'.$user->ID.'" onclick="update_notify_user('.$user->ID.')" /><label for="'.$user->ID.'">' . esc_html( $user->display_name ) . '</label></li>';
	    }
	    echo '</ul>';
	}
}

add_shortcode('wpf_user_list_front','wp_feedback_get_user_list_front');
function wp_feedback_get_user_list_front(){
	$response = array();
	$all_role_cs = get_option('wpf_selcted_role',true);
	$all_role_array = explode(",", $all_role_cs);
	if ( ! empty( $all_role_array ) && ! is_wp_error( $all_role_array ) ){
		$wpfb_users = get_users( [ 'role__in' => $all_role_array ] );
		foreach ( $wpfb_users as $user ) {
			$response[$user->ID]=htmlspecialchars($user->display_name, ENT_QUOTES, 'UTF-8');
	    }
	    return json_encode($response);
	}
}

function wpf_license_key_license_item($wpf_license_key){
	    $site_url = WPF_SITE_URL;
	    $cl = '';
	    $handle = curl_init();
	    $url = "https://wpfeedback.co/?edd_action=activate_license&item_id=".EDD_SL_ITEM_ID."&license=$wpf_license_key&url=$site_url";
        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        // Set the result output to be a string.
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($handle);
        curl_close($handle);
        $outputObject = json_decode($output);
        $response = array('license'=>$outputObject->license,'expires'=>$outputObject->expires);
        return $response;
}


add_action( 'admin_post_save_wpfeedback_options', 'process_wpfeedback_options' );
function process_wpfeedback_options() {
	global $wpdb;
	$wpfeedback_selected_roles ='';
    // Check that user has proper security level
    if ( !current_user_can( 'manage_options' ) )
        wp_die( 'Not allowed' );
    // Check that nonce field created in configuration form
    if(isset($_POST['action'])){
		update_option( 'wpf_enabled', $_POST['enabled_wpfeedback'],'no' );
		update_option( 'wpf_font_awesome_script', $_POST['wpfeedback_font_awesome_script'] ,'no');
        update_option( 'wpf_allow_guest', $_POST['wpfeedback_guest_allowed'],'no' );
        update_option( 'wpf_show_front_stikers', $_POST['wpf_show_front_stikers'],'no' );
		if(isset($_POST['wpfeedback_selcted_role'])){
			$wpfeedback_selected_roles = implode(',',$_POST['wpfeedback_selcted_role']);
		}
		update_option( 'wpf_selcted_role', $wpfeedback_selected_roles ,'no');
        update_option( 'wpf_from_email', $_POST['wpf_from_email'] ,'no');
		update_option( 'wpf_more_emails', $_POST['wpfeedback_more_emails'] ,'no');
		update_option( 'wpf_color', $_POST['wpfeedback_color'] ,'no');
		update_option( 'wpf_powered_by',$_POST['wpfeedback_powered_by'] ,'no');
        update_option( 'wpf_customisations_client',$_POST['wpf_customisations_client'] ,'no');
        update_option( 'wpf_customisations_webmaster',$_POST['wpf_customisations_webmaster'] ,'no');
        update_option( 'wpf_customisations_others',$_POST['wpf_customisations_others'] ,'no');
		update_option( 'wpf_every_new_task', $_POST['wpf_every_new_task'] ,'no');
		update_option( 'wpf_every_new_comment',$_POST['wpf_every_new_comment'] ,'no');
		update_option( 'wpf_every_new_complete', $_POST['wpf_every_new_complete'] ,'no');
		update_option( 'wpf_every_status_change',$_POST['wpf_every_status_change'] ,'no');
		update_option( 'wpf_daily_report',$_POST['wpf_daily_report'] ,'no');
        update_option( 'wpf_weekly_report',$_POST['wpf_weekly_report'] ,'no');
        update_option( 'wpf_auto_daily_report',$_POST['wpf_auto_daily_report'] ,'no');
        update_option( 'wpf_auto_weekly_report',$_POST['wpf_auto_weekly_report'] ,'no');
		update_option( 'wpf_logo',$_POST['wpfeedback_logo'] ,'no');
        update_option( 'wpf_website_client',$_POST['wpf_website_client'] ,'no');
        update_option( 'wpf_website_developer',$_POST['wpf_website_developer'] ,'no');

		if($_POST['wpfeedback_licence_key'] && isset($_POST['wpfeedback_licence_key'])){
	    		$wpf_license_key = $_POST['wpfeedback_licence_key'];
	    		$wpf_result  = wpf_license_key_license_item($wpf_license_key);
				if($wpf_result['license'] == 'valid'){
						update_option( 'wpf_license_key', $_POST['wpfeedback_licence_key'] ,'no');
						update_option('wpf_license',$wpf_result['license'],'no');
						update_option('wpf_license_expires',$wpf_result['expires'],'no');
				}
				else{
					update_option( 'wpf_license_key', $_POST['wpfeedback_licence_key'] ,'no');
					update_option('wpf_license',$wpf_result['license'],'no');
				}
		}

        $wpf_report_register_types = array();
        if($_POST['wpf_auto_daily_report']=='yes'){
            $wpf_report_register_types['daily']='yes';
        }
        else{
            $wpf_report_register_types['daily']='no';
        }
        if($_POST['wpf_auto_weekly_report']=='yes'){
            $wpf_report_register_types['weekly']='yes';
        }
        else{
            $wpf_report_register_types['weekly']='no';
        }
        wpf_register_auto_reports_cron($wpf_report_register_types);
	}
   // check_admin_referer( 'wpfeedback' );
    // Redirect the page to the configuration form that was
    wp_redirect( add_query_arg( 'page', 'wpfeedback_page_settings&wpf_setting=1', admin_url( 'admin.php' ) ) );
    exit;
}

function wpfeedback_dropdown_roles( $selected = false ) {
	$p = '';
	$r = '';
	$editable_roles = get_editable_roles();
	$selected_roles = get_option('wpf_selcted_role');
	// For backwards compatibility
	if ( is_string($selected_roles) ){
		$selected_roles = explode(',', $selected_roles);
		foreach ( $editable_roles as $role => $details ) {
			$name = translate_user_role($details['name'] );
			if (is_array($selected_roles) AND in_array($role,$selected_roles) ) // preselect specified role
				$p .= "\n\t<option selected='selected' value='" . esc_attr($role) . "'>$name</option>";
			else
				$r .= "\n\t<option value='" . esc_attr($role) . "'>$name</option>";
		}
	}
	return $p.$r;
}

function mytheme_customize_css(){
	$wpfeedback_font_awesome_script = get_option('wpf_font_awesome_script'); 
	if($wpfeedback_font_awesome_script != 'yes'){
		?>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<?php } ?>
		<style type="text/css">
		:root {
		  --main-wpf-color: #<?php echo get_option('wpf_color'); ?>;	
		  --seco-bg-color: #8cb54b;
		}
		</style>
	<?php
	//echo '<script type="text/javascript" src="'.WPF_PLUGIN_URL .'js/jscolor.js"></script>';
}
add_action('wp_print_scripts','mytheme_customize_css');


function wpf_get_page_title($post_id){
	$get_page_id = get_post_meta($post_id,'_wpf_page_id',true);
	$page_title = get_the_title($get_page_id);
	return $page_title;
}

add_action('wp_ajax_wpfeedback_get_post_list_ajax', 'wpfeedback_get_post_list_ajax');
add_action('wp_ajax_nopriv_wpfeedback_get_post_list_ajax', 'wpfeedback_get_post_list_ajax');
function wpfeedback_get_post_list_ajax(){
    global $wpdb;
    $allStatus = array('complete','open','pending-review','in-progress','critical','high','low','medium');
	if($_POST['task_status']!=''){
		$task_status = $_POST['task_status'];
		$task_status_array = explode(",",$task_status);
		$task_status = $task_status_array;
	}
	else{
		$task_status = array ('complete','open','pending-review','in-progress');
	}

	if($_POST['task_priority']!= ''){
		$task_priority = $_POST['task_priority'];
		$task_priority_array = explode(",",$task_priority);
		$task_priority = $task_priority_array;
	}
	else{
		$task_priority = array ('critical','high','low','medium');
	}

	if($_POST['author_list']!=''){
		$author_list = $_POST['author_list'];
		$author_list_array = explode(",",$author_list);
		$author_list = $author_list_array;
	}
	else{
		$author_list = array ();
	}

    $meta_query = '';
    $i=1;
    $count_author = count($author_list);
    foreach ($author_list as $key) {
        $meta_query .= "find_in_set($key,meta_value) <> 0";
        if($i < $count_author  ){
            $meta_query .= " OR ";

        }
        $i++;
    }
    $task_status_meta = "'" . implode ( "', '", $task_status ) . "'";
    $task_priority_meta = "'" . implode ( "', '", $task_priority ) . "'";
    $query = "SELECT DISTINCT p.ID, p.* FROM {$wpdb->prefix}posts as p JOIN {$wpdb->prefix}postmeta as pm on pm.post_id = p.ID JOIN {$wpdb->prefix}term_relationships as tr on tr.object_id = p.ID join {$wpdb->prefix}term_taxonomy as tt on tt.term_taxonomy_id = tr.term_taxonomy_id WHERE p.post_type = 'wpfeedback' AND pm.meta_key LIKE 'task_notify_users' AND tt.taxonomy in ('task_status', 'task_priority') AND tt.term_id in (SELECT term_id FROM `{$wpdb->prefix}terms` WHERE `slug` IN ($task_status_meta , $task_priority_meta)) AND $meta_query AND p.post_status = 'publish'";
    $comment_info = $wpdb->get_results($query,OBJECT);

	$args = array(
	  'numberposts'		=> -1, // -1 is for all
	  'post_type'		=> 'wpfeedback',
	  'orderby' 		=> 'title',
	  'order' 		=> 'DESC', // or 'DESC'
	  'author__in'  => $author_list,
	  'orderby'    => 'date',
	  'tax_query' => array(
	  	 'relation' => 'AND',
	        array(
	        'taxonomy' => 'task_status',
	        'field' => 'slug',
	        'terms' => $task_status,
	        ),
	         array(
	        'taxonomy' => 'task_priority',
	        'field' => 'slug',
	        'terms' => $task_priority,
	        )
	    )
	);
	// Get the posts
	$myposts = get_posts($args);

    $obj_merged = (object) array_merge((array) $comment_info, (array) $myposts);
    $new_tasks = array();
    $wpf_post_ids = array();
    foreach ($obj_merged as $key=>$wpf_post) {
        if(!in_array($wpf_post->ID, $wpf_post_ids)){
            $new_tasks[]=$wpf_post;
        }
        $wpf_post_ids[]=$wpf_post->ID;
    }

    $result = $new_tasks;
    $all_task = [];
    foreach ($result as $key => $val) {
        $all_task[$val->ID] = $val;
    }
    $myposts = $all_task;

	if($myposts):
  	// Loop the posts
	$i = count($myposts);
    $output ='';
	$output .= '<ul id="all_wpf_list" style="list-style-type: none; font-size:12px;">';
	foreach ($myposts as $mypost):
  	$post_id = $mypost->ID;
  	$author_id = $mypost->post_author;
  	$post_title = $mypost->post_title;
  	$get_post_date = $mypost->post_date;
  	$date = date_create($get_post_date);
  	$post_date = date_format($date,"d/m/Y H:i");
  	$task_page_url = get_post_meta($post_id,"task_page_url",true);
  	$task_page_title = get_post_meta($post_id,"task_page_title",true);
  	$task_config_author_name = get_post_meta($post_id,"task_config_author_name",true);
  	$task_notify_users = get_post_meta($post_id,"task_notify_users",true);
  	$task_config_author_resX = get_post_meta($post_id,"task_config_author_resX",true);
  	$task_config_author_resY= get_post_meta($post_id,"task_config_author_resY",true);
  	$task_config_author_browser= get_post_meta($post_id,"task_config_author_browser",true);
  	$task_config_author_browserVersion= get_post_meta($post_id,"task_config_author_browserVersion",true);
  	$task_config_author_ipaddress= get_post_meta($post_id,"task_config_author_ipaddress",true);
  	$task_comment_id = get_post_meta($post_id, 'task_comment_id', true);

  	$task_priority = get_the_terms( $post_id, 'task_priority' );
	$task_status = get_the_terms( $post_id, 'task_status' );

	$task_date1 = date_create($get_post_date); 
	$task_date2 = new DateTime('now'); 
	$curr_task_time = wpfb_time_difference($task_date1,$task_date2);

    $get_task_type = get_post_meta($post_id,"task_type",true);
    if($get_task_type == 'general'){
        $task_type = 'general';
        $general = '<span>General</span>';
    }else{
        $task_type = '';
        $general = '';
    }

	if($task_status[0]->slug=='complete'){
        $bubble_label = '<i class="fa fa-check"></i>';
    }
    else{
        $bubble_label = $task_comment_id;
    }

  	if($author_id){
		$author = get_the_author_meta('display_name',$author_id);
	}
	else{
		$author = 'Guest';
	}
  	$output .= '<li class="post_'.$post_id.' '.$task_status[0]->slug.' wpf_list"><a href="javascript:void(0)" id="wpf-task-'.$post_id.'"  data-task_type='.$task_type.' data-task_author_name='.$task_config_author_name.' data-task_config_author_ipaddress='.$task_config_author_ipaddress.' data-task_config_author_browserVersion='.$task_config_author_browserVersion.' data-task_config_author_res="'.$task_config_author_resX.' X '.$task_config_author_resY.'" data-task_config_author_browser="'.$task_config_author_browser.'" data-task_config_author_name="by '.$task_config_author_name." ".$post_date.'" data-task_notify_users="'.$task_notify_users.'" data-task_page_url="'.$task_page_url.'" data-task_page_title="'.$task_page_title.'"
  	data-task_priority="'.$task_priority[0]->slug.'" data-task_status="'.$task_status[0]->slug.'" onclick="get_wpf_chat(this,true)" data-postid="'.$post_id.'" data-uid="'.$author_id.'"  data-task_no='.$task_comment_id.'><div class="wpf_chat_top"><div class="wpf_task_num_top">'. $bubble_label.'</div><div class="wpf_task_main_top"><div class="wpf_task_details_top">By '.$author.' '.$curr_task_time['comment_time'].$general.'</div><div class="wpf_task_pagename">'.$task_page_title.' </div><div class="wpf_task_title_top">'.$post_title.'</div></div></div></a></li>';
	$i--;
	endforeach; wp_reset_postdata();
	$output .= '</ul>';
	endif;
	if($_POST['task_status'] || $_POST['task_priority'] || $_POST['author_list']){
		//Comment
		echo $output; exit;
	}
	else{
		//Comment
		echo $output;
		exit;
	}
}


function wpfeedback_get_post_list(){
	$output ='';
	$args = array( 
				'numberposts'		=> -1, 
				'post_type'		=> 'wpfeedback', 
				'orderby' 		=> 'title', 
				'orderby'    => 'date',
				'order'       => 'DESC' 
				);
	// Get the posts
	$myposts = get_posts($args);
	//echo count($myposts);
	if($myposts):
  	// Loop the posts
	$i = count($myposts);
	$output .= '<ul id="all_wpf_list" style="list-style-type: none; font-size:12px;">';
	foreach ($myposts as $mypost):
  	$post_id = $mypost->ID;
  	$author_id = $mypost->post_author;
  	$post_title = $mypost->post_title;
  	$get_post_date = $mypost->post_date;
  	$date = date_create($get_post_date);
  	$post_date = date_format($date,"d/m/Y H:i");
  	$task_page_url = get_post_meta($post_id,"task_page_url",true);
  	$task_page_title = get_post_meta($post_id,"task_page_title",true);
  	$task_config_author_name = get_post_meta($post_id,"task_config_author_name",true);
  	$task_notify_users = get_post_meta($post_id,"task_notify_users",true);
  	$task_config_author_resX = get_post_meta($post_id,"task_config_author_resX",true);
  	$task_config_author_resY= get_post_meta($post_id,"task_config_author_resY",true);

  	$get_task_type = get_post_meta($post_id,"task_type",true);
  	if($get_task_type == 'general'){
  		$task_type = 'general';
        $general = '<span>General</span>';
  	}else{
  		$task_type = '';
        $general = '';
  	}

  	$task_config_author_browser= get_post_meta($post_id,"task_config_author_browser",true);
  	$task_config_author_browserVersion= get_post_meta($post_id,"task_config_author_browserVersion",true);
  	$task_config_author_ipaddress= get_post_meta($post_id,"task_config_author_ipaddress",true);
  	$task_comment_id = get_post_meta($post_id, 'task_comment_id', true);
  	$task_priority = get_the_terms( $post_id, 'task_priority' );
	$task_status = get_the_terms( $post_id, 'task_status' );

	$task_date1 = date_create($get_post_date); 
	$task_date2 = new DateTime('now'); 
	$curr_task_time = wpfb_time_difference($task_date1,$task_date2);
	if($task_status[0]->slug=='complete'){
        $bubble_label = '<i class="fa fa-check"></i>';
    }
    else{
        $bubble_label =$task_comment_id;
    }
	if($author_id){
		$author = get_the_author_meta('display_name',$author_id);
	}
	else{
		$author = 'Guest';
	}


  	$output .= '<li class="post_'.$post_id.' '.$task_status[0]->slug.' wpf_list"><a href="javascript:void(0)" id="wpf-task-'.$post_id.'" data-task_type='.$task_type.' data-task_author_name='.$task_config_author_name.' data-task_config_author_ipaddress='.$task_config_author_ipaddress.' data-task_config_author_browserVersion='.$task_config_author_browserVersion.' data-task_config_author_res="'.$task_config_author_resX.' X '.$task_config_author_resY.'" data-task_config_author_browser="'.$task_config_author_browser.'" data-task_config_author_name="by '.$task_config_author_name." ".$post_date.'" data-task_notify_users="'.$task_notify_users.'" data-task_page_url="'.$task_page_url.'" data-task_page_title="'.$task_page_title.'"
  	data-task_priority="'.$task_priority[0]->slug.'" data-task_status="'.$task_status[0]->slug.'" onclick="get_wpf_chat(this,true)" data-postid="'.$post_id.'" data-uid="'.$author_id.'"  data-task_no='.$task_comment_id.'><div class="wpf_chat_top"><div class="wpf_task_num_top">'.$bubble_label.'</div><div class="wpf_task_main_top"><div class="wpf_task_details_top">By '.$author.' '.$curr_task_time['comment_time'].' '.$general.'</div><div class="wpf_task_pagename">'.$task_page_title.' </div><div class="wpf_task_title_top">'.$post_title.'</div></div></div></a></li>';
	$i--;
	endforeach; wp_reset_postdata();
	$output .= '</ul>';	
	else:
		$output='No tasks found';
	endif;
	return $output;
}

function list_wpf_comment_func(){
    global $wpdb,$current_user;
    $response = '';
    $comment = "";
    $post_id = $_POST['post_id'];
    $post_author_id = $_POST['post_author_id'];
    $click = $_POST['click'];
    $current_user_id = $current_user->ID;
    if($post_id){
        $post_id;
        $comment_info = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}comments WHERE comment_approved = 1 AND comment_post_ID =$post_id AND comment_type LIKE 'wp_feedback'  ORDER BY comment_ID ASC"); 
        // display the results
        if($comment_info){
            foreach($comment_info as $comment) {
                $comment_date = $comment->comment_date;
                $task_date1 = date_create($comment_date); 
				$task_date2 = new DateTime('now'); 
				$curr_comment_time = wpfb_time_difference($task_date1,$task_date2);
                $author_id = $comment->user_id;
				if($author_id){
					$author = get_the_author_meta('display_name',$comment->user_id);
				}
				else{
					$author = 'Guest';
				}

                if($current_user_id == $comment->user_id){ 
                    $class = "chat_author"; 
                }
                else{ 
                    $class = "not_chat_author"; 
                }

                $name = "<div class='wpf_initials'>".$author."</div>";
                if (strpos($comment->comment_content, 'wp-content/uploads') !== false) {
                	$temp_filetype = wp_check_filetype($comment->comment_content);
                	$file_name = preg_replace( '/\.[^.]+$/', '', basename( $comment->comment_content ));
                    if($temp_filetype['type']=='image/png' || $temp_filetype['type']=='image/gif' || $temp_filetype['type']=='image/jpeg'){
                        $comment ='<a href="'.$comment->comment_content.'" target=_blank><div class="tag_img" style="width: 275px;height: 183px;"><img src="'.$comment->comment_content.'" style="width: 100%;" class="wpfb_task_screenshot"></div></a>';
                    }
                    else{
                        $comment ='<a href="'.$comment->comment_content.'" download><div class="tag_img" style="width: 275px;height: 183px;"><i class="fa fa-download" aria-hidden="true"></i> '. $file_name.'</div></a>';
                    }
                }
                else{
                    $comment = $comment->comment_content;
                }
                $response.= '<li class='.$class.' title="'.$comment_date.'"><level class="wpf-author">'. $author .' '.$curr_comment_time['comment_time'].'</level><p class="task_text">'.nl2br($comment) .'</p></div></li>';
            }
        }
        else{
            $response = '<li id="wpf_not_found">No comments found</li>';
        }
    }
    else{
        $response = '<li id="wpf_not_found">No comments found</li>';
    }
    echo $response;
    die();
}
add_action('wp_ajax_list_wpf_comment_func', 'list_wpf_comment_func');
add_action('wp_ajax_nopriv_list_wpf_comment_func', 'list_wpf_comment_func');

function list_wpf_comment_notif_func($post_id){
    global $wpdb,$current_user;
    $response = '';
    $current_user_id = $current_user->ID;
    if($post_id){
        $post_id;
        $comment_info = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}comments WHERE comment_approved = 1 AND comment_post_ID =$post_id AND comment_type LIKE 'wp_feedback'  ORDER BY comment_ID ASC");
        if($comment_info){
            foreach($comment_info as $comment) {
                $author_id = $comment->user_id;
                if($author_id){
                    $author = get_the_author_meta('display_name',$comment->user_id);
                }
                else{
                    $author = 'Guest';
                }

                if($current_user_id == $comment->user_id){
                    $class = "chat_author";
                }
                else{
                    $class = "not_chat_author";
                }

                $name = "<div class='wpf_initials'>".$author."</div>";
                if (strpos($comment->comment_content, 'wp-content/uploads') !== false) {
                    $comment ='<a href="'.$comment->comment_content.'" target=_blank><div class="tag_img" style="width: 275px;height: 183px;"><img src="'.$comment->comment_content.'" style="width: 100%;" class="wpfb_task_screenshot"></div></a>';
                }
                else{
                    $comment = $comment->comment_content;
                }
                $response.= "<li><strong>$author: </strong>".nl2br($comment)."</li>";
            }
        }
        else{
            $response = '<li id="wpf_not_found">No comments found</li>';
        }
    }
    else{
        $response = '<li id="wpf_not_found">No comments found</li>';
    }
    return $response;
    die();

}

function insert_wpf_comment_func(){
    global $wpdb; 
    $wpf_comment = $_POST['wpf_comment'];
    $post_id = $_POST['post_id'];
    $author_id = $_POST['author_id'];
    $user_info = get_userdata($author_id);
    $blogtime = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
    $commentdata = array(
    'comment_post_ID' => $post_id, 
    'comment_author' =>  $user_info->first_name.' '.$user_info->last_name, 
    'comment_author_email' => $user_info->user_email,
    'comment_author_url' => '', 
    'comment_content' => stripslashes(html_entity_decode($wpf_comment, ENT_QUOTES, 'UTF-8')), 
    'comment_type' => 'wp_feedback', 
    'comment_parent' => 0, 
    'user_id' => $author_id, 
    'comment_date' => $blogtime,
);
    if($wpf_comment){
	    $wpdb->insert($wpdb->prefix.'comments', $commentdata);
	    $comment_id = $wpdb->insert_id;
        add_comment_meta( $comment_id, 'unseen', '1', true );
	    $sender_id = $author_id;
        $msg = $wpf_comment;
        //send_user_notification_for_msg($sender_id,$receiver_id,$msg);
	}
    if($comment_id){
        $comment_info = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}comments WHERE comment_ID =$comment_id AND comment_type LIKE 'wp_feedback' ORDER BY comment_ID ASC"); 
        // display the results
        foreach($comment_info as $info) {
            $class = "chat_author";
            $profile_image = "<div class='chat_initials'>ME</div>";
            echo '<li class='.$class.'><level class="chat-author">'. $profile_image .'</level><div class="meassage_area_main"><p class="chat_text">'. nl2br($info->comment_content) .'</p></div></li>'; 
        }
    }
    else{
        echo 'sorry this is duplicate msg.';
    }
    die();

}
add_action('wp_ajax_insert_wpf_comment_func', 'insert_wpf_comment_func');
add_action('wp_ajax_nopriv_insert_wpf_comment_func', 'insert_wpf_comment_func');

function insert_null_wpf_comment_func(){
    global $wpdb;
    $wpf_comment ='';
    $taskid = $_POST['taskid'];
    $author_id = $_POST['author_id'];
    $user_info = get_userdata($author_id);
    $blogtime = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
    $commentdata = array(
        'comment_post_ID' => $taskid,
        'comment_author' =>  $user_info->first_name.' &nbsp; '.$user_info->last_name,
        'comment_author_email' => $user_info->user_email,
        'comment_author_url' => '',
        'comment_content' => $wpf_comment,
        'comment_type' => 'wp_feedback',
        'comment_parent' => 0,
        'user_id' => $author_id,
        'comment_date' => $blogtime,
    );

//Insert new comment and get the comment ID
    $comment_id =  $wpdb->insert("{$wpdb->prefix}comments", $commentdata);
    $comment_id = $wpdb->insert_id;
    $msg = $wpf_comment;
    if($comment_id){
        echo $comment_id;
        die();
    }
    else{
        echo '';
    }
    die();

}
add_action('wp_ajax_insert_null_wpf_comment_func', 'insert_null_wpf_comment_func');
add_action('wp_ajax_nopriv_insert_null_wpf_comment_func', 'insert_null_wpf_comment_func');


function insert_wpf_comment_img_func(){
    //print_r($_POST);  exit;
    $task_comment_id = $_POST['wpf_taskid'];
    require_once(ABSPATH .'/wp-load.php');
    require_once( ABSPATH . 'wp-admin/includes/admin.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    if( ! empty( $_FILES ) ) {
        foreach( $_FILES as $file ) {
            if( is_array( $file ) ) {
                $uploadedfile = $file;
                $upload_overrides = array( 'test_form' => false );
                $file_return = wp_handle_upload( $uploadedfile, $upload_overrides );
                if( isset($file_return['error']) || isset($file_return['upload_error_handler']) ) {
                      echo "error";     
                      return false;
                } 
                else{
                      $filename = $file_return['file'];
                      $attachment = array(
                        'post_mime_type' => $file_return['type']
                      );
                      $attachment_id = wp_insert_attachment($attachment, $file_return['url'], $task_comment_id );
                      require_once(ABSPATH . 'wp-admin/includes/image.php');
                      $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
                      wp_update_attachment_metadata( $attachment_id, $attachment_data );
                      //echo $file_return['url']; exit;
                      if( 0 < intval( $attachment_id ) ) {
                         $attach_id = $attachment_id;
                          $commentarr = array();
                          $commentarr['comment_ID'] = $task_comment_id;
                          $commentarr['comment_content'] = $file_return['url'];
                          wp_update_comment( $commentarr );
                          add_comment_meta( $task_comment_id, 'chat_image', $file_return['url'], true );
                      }else{
                      	wp_delete_comment( $task_comment_id, true );
                      }
                }               
            }
        }
        $profile_image = "<div class='chat_initials'>ME</div>";
        if($file_return['url']){
            echo '<li class="chat_author"><level class="chat-author">'. $profile_image .'</level><div class="meassage_area_main"><p class="chat_text"><a href="'.$file_return['url'].'" target=_blank><div class="tag_img" style="width: 275px;height: 183px;"><img src="'.$file_return['url'].'" style="width: 100%;" class="tag_img_chat"></div></a></p></div></li>'; 
        }
    }
     die();
}
add_action('wp_ajax_insert_wpf_comment_img_func', 'insert_wpf_comment_img_func');

add_action('wp_ajax_wpf_notify_admin_add_ons_func', 'wpf_notify_admin_add_ons_func');
function wpf_notify_admin_add_ons_func(){
	$current_user_id = get_current_user_id(); 
	$user_info = get_userdata($current_user_id);
	echo $user_info->user_email;
	echo $add_ons_name = $_POST['add_ons'];
	exit;
}

add_action('wp_ajax_wpf_add_new_task','wpf_add_new_task');
add_action('wp_ajax_nopriv_wpf_add_new_task','wpf_add_new_task');
function wpf_add_new_task(){
	global $wpdb,$current_user;
	if($current_user->ID==0){
        $user_id = get_option( 'wpf_website_client');
    }
	else{
        $user_id = $current_user->ID;
    }

//    Old logic to count latest task bubble number, was changed after the delete task feature was introduced
//    $comment_count_obj = wp_count_posts('wpfeedback');
//    $comment_count = $comment_count_obj->publish+1;

//    New logic to count latest task bubble number
    $table =  $wpdb->prefix . 'postmeta';
    $latest_count = $wpdb->get_results("SELECT meta_value FROM $table WHERE meta_key = 'task_comment_id' ORDER BY meta_id DESC LIMIT 1 ");
    $comment_count = $latest_count[0]->meta_value + 1;

    $wpf_every_new_task = get_option('wpf_every_new_task');
	$task_data = $_POST['new_task'];
	if($task_data['task_page_title'] == ''){
		$task_data['task_page_title'] = get_the_title($task_data['current_page_id']);
	}
	if($task_data['task_page_url'] == ''){
		$task_data['task_page_url'] = $current_page_url = get_permalink($task_data['current_page_id']);
	}
	$new_task = array( 
					'post_content' => '', 
					'post_status' => 'publish', 
					'post_title' => stripslashes(html_entity_decode($task_data['task_title'], ENT_QUOTES, 'UTF-8')),
					'post_type' => 'wpfeedback', 
					'post_author' => $user_id,
					'post_parent' => $task_data['current_page_id']
				); 
	$task_id = wp_insert_post( $new_task);
	$task_data['task_element_path'] = str_replace(".active_comment","",$task_data['task_element_path']);
	$task_data['task_element_path'] = str_replace(".logged-in.admin-bar","",$task_data['task_element_path']);
	$task_data['task_element_path'] = str_replace(".no-customize-support","",$task_data['task_element_path']);
    $task_data['task_element_path'] = str_replace(".customize-support","",$task_data['task_element_path']);
    $task_data['task_element_path'] = str_replace(".gf_browser_chrome","",$task_data['task_element_path']);
    $task_data['task_element_path'] = str_replace(".gf_browser_gecko","",$task_data['task_element_path']);
    $task_data['task_element_path'] = str_replace(".wpfb_task_bubble","",$task_data['task_element_path']);
	add_post_meta($task_id,'task_config_author_browser',$task_data['task_config_author_browser']);
	add_post_meta($task_id,'task_config_author_browserVersion',$task_data['task_config_author_browserVersion']);
	add_post_meta($task_id,'task_config_author_browserOS',$task_data['task_config_author_browserOS']);
	add_post_meta($task_id,'task_config_author_ipaddress',$task_data['task_config_author_ipaddress']);
	add_post_meta($task_id,'task_config_author_name',$task_data['task_config_author_name']);
	add_post_meta($task_id,'task_config_author_id',$user_id);
	add_post_meta($task_id,'task_config_author_resX',$task_data['task_config_author_resX']);
	add_post_meta($task_id,'task_config_author_resY',$task_data['task_config_author_resY']);
	add_post_meta($task_id,'task_title',$task_data['task_title']);
	add_post_meta($task_id,'task_page_url',$task_data['task_page_url']);
	add_post_meta($task_id,'task_page_title',$task_data['task_page_title']);
	add_post_meta($task_id,'task_comment_message',$task_data['task_comment_message']);
	add_post_meta($task_id,'task_element_path',$task_data['task_element_path']);
    add_post_meta($task_id,'wpfb_task_bubble',$task_data['task_clean_dom_elem_path']);
	add_post_meta($task_id,'task_element_html',$task_data['task_element_html']);
	add_post_meta($task_id,'task_X',$task_data['task_X']);
	add_post_meta($task_id,'task_Y',$task_data['task_Y']);
	add_post_meta($task_id,'task_elementX',$task_data['task_elementX']);
	add_post_meta($task_id,'task_elementY',$task_data['task_elementY']);
	add_post_meta($task_id,'task_relativeX',$task_data['task_relativeX']);
	add_post_meta($task_id,'task_relativeY',$task_data['task_relativeY']);
	add_post_meta($task_id,'task_notify_users',$task_data['task_notify_users']);
	add_post_meta($task_id,'task_element_height',$task_data['task_element_height']);
	add_post_meta($task_id,'task_element_width',$task_data['task_element_width']);
	add_post_meta($task_id,'task_comment_id',$comment_count);
	add_post_meta($task_id,'task_type',$task_data['task_type']);


	wp_set_object_terms( $task_id, $task_data['task_status'], 'task_status',true );
	wp_set_object_terms( $task_id, $task_data['task_priority'], 'task_priority',true );

	$comment_time = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
    $commentdata = array(
	    'comment_post_ID' => $task_id,
	    'comment_author' => $task_data['task_config_author_name'],
	    'comment_author_email' => '',
	    'comment_author_url' => '',
	    'comment_content' => stripslashes(html_entity_decode($task_data['task_comment_message'], ENT_QUOTES, 'UTF-8')),
	    'comment_type' => 'wp_feedback',
	    'comment_parent' => 0,
	    'user_id' => $user_id,
	    'comment_date' => $comment_time
	);
    $comment_id =  $wpdb->insert("{$wpdb->prefix}comments", $commentdata);
    if($wpf_every_new_task == 'yes') {
        wpf_send_email_notification($task_id, $comment_id, $task_data['task_notify_users'], 'new_task');
    }
	ob_clean();
	echo $task_id;
	exit;
}
add_action('wp_ajax_wpfb_add_comment','wpfb_add_comment');
add_action('wp_ajax_nopriv_wpfb_add_comment','wpfb_add_comment');
function wpfb_add_comment(){
	global $wpdb;
    $wpf_every_new_comment = get_option('wpf_every_new_comment');
	$task_data = $_POST['new_task'];
	$task_id = $task_data['post_id'];
	$comment_time = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
    $commentdata = array(
	    'comment_post_ID' => $task_data['post_id'],
	    'comment_author' => $task_data['task_config_author_name'],
	    'comment_author_email' => '',
	    'comment_author_url' => '',
	    'comment_content' => stripslashes(html_entity_decode($task_data['task_comment_message'], ENT_QUOTES, 'UTF-8')),
	    'comment_type' => 'wp_feedback',
	    'comment_parent' => 0,
	    'user_id' => $task_data['task_config_author_id'],
	    'comment_date' => $comment_time
	);

    $comment_id =  $wpdb->insert("{$wpdb->prefix}comments", $commentdata);
    $comment_id = $wpdb->insert_id;
    if($wpf_every_new_comment == 'yes') {
        wpf_send_email_notification($task_data['post_id'], $comment_id, $task_data['task_notify_users'], 'new_reply');
    }
    ob_clean();
    echo $comment_id;
    exit;
}
add_action('wp_ajax_load_wpfb_tasks','load_wpfb_tasks');
add_action('wp_ajax_nopriv_load_wpfb_tasks','load_wpfb_tasks');
function load_wpfb_tasks(){
    ob_clean();
	global $wpdb,$current_user;
	$current_user_id = $current_user->ID;
    $comment = "";
	$response = array();
	if($_POST['current_page_id'] && $_POST['current_page_id']!=''){
		$args = array(
			'post_parent' => $_POST['current_page_id'],
			'post_type'   => 'wpfeedback', 
			'numberposts' => -1,
			'post_status' => 'any',
			'orderby'    => 'date',
			'order'       => 'DESC'
		);
		$wpfb_tasks = get_children( $args );
	}
	elseif ($_POST['task_id']){
        $args = array(
            'include'=>$_POST['task_id'],
            'post_type'=>'wpfeedback'
        );
        $wpfb_tasks = get_posts( $args );
    }
	else{
		$args = array(
			'post_type'   => 'wpfeedback', 
			'numberposts' => -1,
			'post_status' => 'any',
			'orderby'    => 'date',
			'order'       => 'DESC'   
		);
		$wpfb_tasks = get_posts( $args );
	}
	
	foreach ($wpfb_tasks as $wpfb_task) {
		$task_date = get_the_time( 'Y-m-d H:i:s', $wpfb_task->ID );
		$metas = get_post_meta($wpfb_task->ID);
		$task_priority = get_the_terms( $wpfb_task->ID, 'task_priority' );
		$task_status = get_the_terms( $wpfb_task->ID, 'task_status' );
		foreach ($metas as $key => $value) {
			$response[$wpfb_task->ID][$key]=$value[0];
			$response[$wpfb_task->ID]['task_priority']=$task_priority[0]->slug;
			$response[$wpfb_task->ID]['task_status']=$task_status[0]->slug;
			$response[$wpfb_task->ID]['current_user_id']=$current_user_id;
			
			$task_date1 = date_create($task_date);
//          Old Logic to get current time. Was creating issues when displaying message
//			$task_date2 = new DateTime('now');

//          New Logic to get current time.
            $wpf_wp_current_timestamp = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
            $task_date2 = date_create($wpf_wp_current_timestamp);


            $curr_comment_time = wpfb_time_difference($task_date1,$task_date2);
				
			$response[$wpfb_task->ID]['task_time']=$curr_comment_time['comment_time'];
		}

		$args = array(
				    'post_id' => $wpfb_task->ID,
				    'type' => 'wp_feedback'
				);
		$comments_info = get_comments( $args );

        if($comments_info){
        	 foreach($comments_info as $comment) {
        	 	$comment_type=0;
        	 	if (strpos($comment->comment_content, 'wp-content/uploads') !== false) {
//                    print_r(wp_check_filetype($comment->comment_content));
                    $temp_filetype = wp_check_filetype($comment->comment_content);
                    $response[$wpfb_task->ID]['comments'][$comment->comment_ID]['filetype']=$temp_filetype;
                    if($temp_filetype['type']=='image/png' || $temp_filetype['type']=='image/gif' || $temp_filetype['type']=='image/jpeg'){
                        $comment_type=1;
                    }
                    else{
                        $comment_type=2;
                    }

        	 	}
        	 	$response[$wpfb_task->ID]['comments'][$comment->comment_ID]['message']=$comment->comment_content;
        	 	$response[$wpfb_task->ID]['comments'][$comment->comment_ID]['comment_type']=$comment_type;
        	 	$response[$wpfb_task->ID]['comments'][$comment->comment_ID]['author']=$comment->comment_author;
        	 	
        	 	$datetime1 = date_create($comment->comment_date);

//        	 	Old Logic to get current time. Was creating issues when displaying message
//				$datetime2 = new DateTime('now');

//              New Logic to get current time.
				$wpf_wp_current_timestamp = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
				$datetime2 = date_create($wpf_wp_current_timestamp);

				$curr_comment_time = wpfb_time_difference($datetime1,$datetime2);

        	 	$response[$wpfb_task->ID]['comments'][$comment->comment_ID]['time']=$curr_comment_time['comment_time'];
        	 	$response[$wpfb_task->ID]['comments'][$comment->comment_ID]['time_full']=$curr_comment_time['interval'];
        	 	$response[$wpfb_task->ID]['comments'][$comment->comment_ID]['user_id']=$comment->user_id;
        	 }
        }
	}
    ob_end_clean();
	echo json_encode($response); 
	exit;
}

add_action('wp_ajax_wpfb_set_task_priority','wpfb_set_task_priority');
add_action('wp_ajax_nopriv_wpfb_set_task_priority','wpfb_set_task_priority');
function wpfb_set_task_priority(){
	$task_info=$_POST['task_info'];
	if(wp_set_object_terms( $task_info['task_id'], $task_info['task_priority'], 'task_priority',false )){
		echo 1;
	}
	else{
		echo 0;
	}
	exit;
}

add_action('wp_ajax_wpfb_set_task_status','wpfb_set_task_status');
add_action('wp_ajax_nopriv_wpfb_set_task_status','wpfb_set_task_status');
function wpfb_set_task_status(){
    $wpf_every_status_change = get_option('wpf_every_status_change');
    $wpf_every_new_complete = get_option('wpf_every_new_complete');
	$task_info=$_POST['task_info'];
	if(wp_set_object_terms( $task_info['task_id'], $task_info['task_status'], 'task_status',false )){
	    if($task_info['task_status']=='complete' && $wpf_every_new_complete == 'yes'){
            wpf_send_email_notification($task_info['task_id'],0,$task_info['task_notify_users'],'task_completed');
        }else{
	        if($wpf_every_status_change == 'yes'){
                wpf_send_email_notification($task_info['task_id'],0,$task_info['task_notify_users'],'task_status_changed');
            }
        }
		echo 1;
	}
	else{
		echo 0;
	}
	exit;
}

add_action('wp_ajax_wpfb_set_task_notify_users','wpfb_set_task_notify_users');
add_action('wp_ajax_nopriv_wpfb_set_task_notify_users','wpfb_set_task_notify_users');
function wpfb_set_task_notify_users(){
    if(update_post_meta($_POST['task_info']['task_id'],'task_notify_users',$_POST['task_info']['task_notify_users'])){
        echo 1;
    }
    else{
        echo 0;
    }
    exit;
}

/*
* Get Logo URL
*/
function get_wpf_logo(){

	$get_logoid = get_option( 'wpf_logo' );
	if($get_logoid !=''){
		$get_logo_url = wp_get_attachment_url( get_option( 'wpf_logo' ) ); 
	}
	else{

		$get_logo_url = esc_url( WPF_PLUGIN_URL.'images/Logo-WPFeedback.svg');
	}
	return $get_logo_url;
} 

/*
* Show notice after save setting
*/
function wpf_admin_notice_success() {
	if (isset($_GET['wpf_setting']) && $_GET['wpf_setting'] == 1 ) {
    	?>
	    <div class="notice notice-success is-dismissible">
	        <p><?php _e( 'Your settings have been saved!', 'wpfeedback' ); ?></p>
	    </div>
    <?php }

    if (isset($_GET['wpf_setting']) && $_GET['wpf_setting'] == 0 ) {
  		?>
  		<div class="error notice is-dismissible">
      		<p><?php _e('Your Settings not saved. ','wpfeedback');  ?></p>
  		</div>
  	<?php }
}
//add_action( 'admin_notices', 'wpf_admin_notice_success' );

function wpf_get_current_user_roles() {
	if( is_user_logged_in() ) {
		$user = wp_get_current_user();
		$roles = ( array ) $user->roles;
		return $roles[0];
	} 
	else {
		return 'Guest';
	}
}

function wpf_get_current_user_information() {
	$response = array();
	if( is_user_logged_in() == true ) {
		$user = wp_get_current_user();
		$user_details = ( array ) $user->data;
		$roles = ( array ) $user->roles;

		$response['display_name']=$user_details['display_name'];
		$response['user_id']=$user_details['ID'];
		$response['role']=$roles[0];

		return $response;
	} 
	else {
		$response['display_name']='Guest';
		$response['user_id']=0;
		$response['role']='Guest';

		return $response;
	}
}

add_action('wp_ajax_wpfb_save_screenshot','wpfb_save_screenshot_function');
add_action('wp_ajax_nopriv_wpfb_save_screenshot','wpfb_save_screenshot_function');

function wpfb_save_screenshot_function(){
    global $wpdb,$current_user;

    if($current_user->ID==0){
        $task_config_author_id = get_option( 'wpf_website_client');
    }
    else{
        $task_config_author_id = $current_user->ID;
    }
	$wpf_every_new_comment = get_option('wpf_every_new_comment');
	$upload_dir = wp_upload_dir();

	ini_set('display_errors', 1);

	$image = $_POST['image'];
	$task_screenshot = $_POST['task_screenshot'];
	$post_id = $task_screenshot['post_id'];
	$task_config_author_name = $task_screenshot['task_config_author_name'];
	//$task_config_author_id = $task_screenshot['task_config_author_id'];

	$post_notif_user_str = get_post_meta($post_id,'task_notify_users',true);
    //$post_notif_users_arr = explode(',',$post_notif_user_str);

	$location = $upload_dir['basedir']."/wpfb_screenshots/";
	if (!file_exists($location)) {
	    mkdir($location, 0777, true);
	}

	$image_parts = explode("base64,", $image);

    $invalid = wpf_verify_file_upload($_SERVER,$image_parts[1]);

	$image_base64 = base64_decode($image_parts[1]);

	$filename = "screenshot_".uniqid().'.jpg';

	$file = $location . $filename;

	if($invalid==0) {
        if (file_put_contents($file, $image_base64)) {
            // echo $file;
            $task_screenshot = $upload_dir['baseurl'] . "/wpfb_screenshots/" . $filename;

            $task_data = $_POST['new_task'];
            $comment_time = date('Y-m-d H:i:s', current_time('timestamp', 0));
            $commentdata = array(
                'comment_post_ID' => $post_id,
                'comment_author' => $task_config_author_name,
                'comment_author_email' => '',
                'comment_author_url' => '',
                'comment_content' => $task_screenshot,
                'comment_type' => 'wp_feedback',
                'comment_parent' => 0,
                'user_id' => $task_config_author_id,
                'comment_date' => $comment_time
            );
            // print_r($commentdata);
            $wpdb->insert("{$wpdb->prefix}comments", $commentdata);
            $comment_id = $wpdb->insert_id;
            if ($wpf_every_new_comment == 'yes' && $post_id > 0) {
                wpf_send_email_notification($post_id, $comment_id, $post_notif_user_str, 'new_reply');
            }
            ob_clean();
            echo $task_screenshot;
        } else {
            echo 0;
        }
    }
	else{
	    echo 1;
    }
	exit;
}

function wpfb_time_difference($datetime1,$datetime2){
	$response = array();
	$interval = date_diff($datetime1, $datetime2);
	if($interval->y==0){
		if($interval->m==0){
			if($interval->d==0){
				if($interval->h==0){
					if($interval->i==0){
						$comment_time=$interval->s.' seconds ago';
					}
					else{
						$comment_time=$interval->i.' minutes ago';
					}
				}
				else{
					$comment_time=$interval->h.' hours ago';
				}
			}
			else{
				$comment_time=$interval->d.' days ago';
			}
		}
		else{
			$comment_time=$interval->m.' months ago';
		}
	}
	else{
		$comment_time=$interval->y.' years ago';
	}
	$response['interval']=$interval;
	$response['comment_time']=$comment_time;
	return $response;
}

add_action('wp_ajax_wpfeedback_reset_setting', 'wpfeedback_reset_setting');
add_action('wp_ajax_nopriv_wpfeedback_reset_setting', 'wpfeedback_reset_setting');
function wpfeedback_reset_setting(){
	update_option( 'wpf_color', '002157','no' );
	delete_option('wpf_logo',true);
	echo 1;
	exit;
}

function wp_feedback_get_texonomy_selectbox($my_term){
	$terms = get_terms( array(
	    'taxonomy' => $my_term,
	    'hide_empty' => false,
	));
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	    echo '<select id="task_'.$my_term.'_attr" onchange="'.$my_term.'_changed(this);">';
	    foreach ( $terms as $term ) {
	        echo '<option name="'.$my_term.'" value="'.$term->slug.'" class="wpf_task" id="wpf_'.$term->slug.'"/>' . $term->name . '</option>';
	    }
	    echo '</select>';
	}
}

function wpf_check_if_enable(){
    $current_user_information = wpf_get_current_user_information();
    $current_role = $current_user_information['role'];
    $wpf_license = get_option('wpf_license');
    $wpf_enabled = get_option('wpf_enabled');
    $wpf_selcted_role = get_option('wpf_selcted_role');
    $wpf_allow_guest = get_option('wpf_allow_guest');
    $selected_roles = explode(',', $wpf_selcted_role);

    if($wpf_license =='valid' && $wpf_enabled=='yes' && (in_array($current_role,$selected_roles) || $wpf_allow_guest=='yes')){
        $wpf_access_output = 1;
    }else{
        $wpf_access_output = 0;
    }
    return $wpf_access_output;
}

function wpf_license_verify_and_store(){
    $response=0;
    $wpf_license_key = $_POST['wpf_license_key'];
    $wpf_license = get_option('wpf_license');
    if($wpf_license=='valid'){
        $response=1;
    }
    else{
        $outputObject = wpf_license_key_license_item($wpf_license_key);
        if ($outputObject['license'] == 'valid') {
            update_option('wpf_license_key',$wpf_license_key,'no');
            update_option('wpf_license', $outputObject['license'],'no');
            update_option('wpf_license_expires', $outputObject['expires'],'no');
            $response=1;
        } else {
            update_option('wpf_license', $outputObject['license'],'no');
        }
    }
    echo $response;
    exit;
}
add_action('wp_ajax_wpf_license_verify_and_store', 'wpf_license_verify_and_store');
add_action('wp_ajax_nopriv_wpf_license_verify_and_store', 'wpf_license_verify_and_store');

function wpf_update_roles(){
    $roles = $_POST['task_notify_roles'];
    $wpf_allow_guest = $_POST['wpf_allow_guest'];
    if($wpf_allow_guest==1){
        update_option('wpf_allow_guest','yes','no');
    }
    else{
        update_option('wpf_allow_guest','no','no');
    }

//    if(update_option('wpf_selcted_role',$roles,'no')){
//        echo 1;
//    }
//    else{
//        echo 0;
//    }

    update_option('wpf_selcted_role',$roles,'no');
    echo 1;
    exit;
}
add_action('wp_ajax_wpf_update_roles', 'wpf_update_roles');
add_action('wp_ajax_nopriv_wpf_update_roles', 'wpf_update_roles');

function wpf_update_notifications(){
    $wpf_every_new_task = $_POST['wpf_every_new_task'];
    if($wpf_every_new_task==1){
        update_option('wpf_every_new_task','yes','no');
    }
    $wpf_every_new_comment = $_POST['wpf_every_new_comment'];
    if($wpf_every_new_comment==1){
        update_option('wpf_every_new_comment','yes','no');
    }
    $wpf_every_new_complete = $_POST['wpf_every_new_complete'];
    if($wpf_every_new_complete==1){
        update_option('wpf_every_new_complete','yes','no');
    }
    $wpf_every_status_change = $_POST['wpf_every_status_change'];
    if($wpf_every_status_change==1){
        update_option('wpf_every_status_change','yes','no');
    }
    $wpf_daily_report = $_POST['wpf_daily_report'];
    if($wpf_daily_report==1){
        update_option('wpf_daily_report','yes','no');
    }
    $wpf_weekly_report = $_POST['wpf_weekly_report'];
    if($wpf_weekly_report==1){
        update_option('wpf_weekly_report','yes','no');
    }
    $wpf_auto_daily_report = $_POST['wpf_auto_daily_report'];
    if($wpf_auto_daily_report==1){
        update_option('wpf_auto_daily_report','yes','no');
    }
    $wpf_auto_weekly_report = $_POST['wpf_auto_weekly_report'];
    if($wpf_auto_weekly_report==1){
        update_option('wpf_auto_weekly_report','yes','no');
    }
    echo 1;
    exit;
}
add_action('wp_ajax_wpf_update_notifications', 'wpf_update_notifications');
add_action('wp_ajax_nopriv_wpf_update_notifications', 'wpf_update_notifications');

function wpf_initial_setup_done(){
    update_option('wpf_enabled','yes','no');
//    if(update_option('wpf_initial_setup','yes','no')){
//        echo 1;
//    }
//    else{
//        echo 0;
//    }
    update_option('wpf_initial_setup','yes','no');
    echo 1;
    exit;
}
add_action('wp_ajax_wpf_initial_setup_done', 'wpf_initial_setup_done');
add_action('wp_ajax_nopriv_wpf_initial_setup_done', 'wpf_initial_setup_done');


add_action('wp_ajax_wpfb_delete_task','wpfb_delete_task');
add_action('wp_ajax_nopriv_wpfb_delete_task','wpfb_delete_task');
function wpfb_delete_task(){
    $task_info=$_POST['task_info'];
    if(wp_delete_post($task_info['task_id'])){
        echo 1;
    }
    else{
        echo 0;
    }
    exit;
}

add_action( 'show_user_profile', 'wpf_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'wpf_show_extra_profile_fields' );

function wpf_show_extra_profile_fields( $user ) {
	$selected_roles = get_option('wpf_selcted_role');
    $selected_roles = explode(',', $selected_roles);
    if(in_array($user->roles[0], $selected_roles)){
    $notifications_html = wpf_get_allowed_notification_list($user->ID,'no');
    ?>
    <h3><?php esc_html_e( 'WP Feedback Information', 'wpfeedback' ); ?></h3>

    <table class="form-table">
        <tr>
            <?php $wpf_get_user_type =esc_attr( get_the_author_meta( 'wpf_user_type', $user->ID ) );
            ?>
            <th><label for="wpf_user_type"><?php _e("User Type"); ?></label></th>
            <td>
                <select id="wpf_user_type" name="wpf_user_type">
                    <option value="" <?php if($wpf_get_user_type == ''){ echo 'selected'; } ?>>Select</option>
                    <option value="king" <?php if($wpf_get_user_type == 'king'){ echo 'selected'; } ?>><?php echo get_option('wpf_customisations_client')?get_option('wpf_customisations_client'):'Client (Website Owner)'; ?></option>
                    <option value="advisor" <?php if($wpf_get_user_type == 'advisor'){ echo 'selected'; } ?>><?php echo get_option('wpf_customisations_webmaster')?get_option('wpf_customisations_webmaster'):'Webmaster'; ?></option>
                    <option value="council" <?php if($wpf_get_user_type == 'council'){ echo 'selected'; } ?>><?php echo get_option('wpf_customisations_others')?get_option('wpf_customisations_others'):'Others'; ?></option>
            </td>
        </tr>
        <tr>
            <th><label for="city"><?php _e("Email Notifications"); ?></label></th>
            <td>
                <?php echo $notifications_html; ?>
            </td>
        </tr>
    </table>
<?php }
	}

add_action( 'personal_options_update', 'wpf_save_user_profile_fields' );
add_action( 'edit_user_profile_update', 'wpf_save_user_profile_fields' );

function wpf_save_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    update_user_meta( $user_id, 'wpf_user_type', $_POST['wpf_user_type'] );
    update_user_meta( $user_id, 'wpf_every_new_task', $_POST['wpf_every_new_task'] );
    update_user_meta( $user_id, 'wpf_every_new_comment', $_POST['wpf_every_new_comment'] );
    update_user_meta( $user_id, 'wpf_every_new_complete', $_POST['wpf_every_new_complete'] );
    update_user_meta( $user_id, 'wpf_every_status_change', $_POST['wpf_every_status_change'] );
    update_user_meta( $user_id, 'wpf_daily_report', $_POST['wpf_daily_report'] );
    update_user_meta( $user_id, 'wpf_weekly_report', $_POST['wpf_weekly_report'] );
    update_user_meta( $user_id, 'wpf_auto_daily_report', $_POST['wpf_auto_daily_report'] );
    update_user_meta( $user_id, 'wpf_auto_weekly_report', $_POST['wpf_auto_weekly_report'] );
}

function wpf_update_current_user_first_step(){
    $user_id = $_POST['current_user_id'];
    $wpf_user_type = $_POST['wpf_user_type'];
    if($wpf_user_type){
        update_user_meta( $user_id, 'wpf_user_type', $wpf_user_type );
        update_user_meta( $user_id, 'wpf_user_initial_setup', 'yes' );
    }
    $wpf_every_new_task = $_POST['wpf_every_new_task'];
    if($wpf_every_new_task=='yes'){
        update_user_meta( $user_id, 'wpf_every_new_task', $_POST['wpf_every_new_task'] );
    }
    else{
        delete_user_meta($user_id,'wpf_every_new_task');
    }
    $wpf_every_new_comment = $_POST['wpf_every_new_comment'];
    if($wpf_every_new_comment=='yes'){
        update_user_meta( $user_id, 'wpf_every_new_comment', $_POST['wpf_every_new_comment'] );
    }
    else{
        delete_user_meta($user_id,'wpf_every_new_comment');
    }
    $wpf_every_new_complete = $_POST['wpf_every_new_complete'];
    if($wpf_every_new_complete=='yes'){
        update_user_meta( $user_id, 'wpf_every_new_complete', $_POST['wpf_every_new_complete'] );
    }
    else{
        delete_user_meta($user_id,'wpf_every_new_complete');
    }
    $wpf_every_status_change = $_POST['wpf_every_status_change'];
    if($wpf_every_status_change=='yes'){
        update_user_meta( $user_id, 'wpf_every_status_change', $_POST['wpf_every_status_change'] );
    }
    else{
        delete_user_meta($user_id,'wpf_every_status_change');
    }
    $wpf_daily_report = $_POST['wpf_daily_report'];
    if($wpf_daily_report=='yes'){
        update_user_meta( $user_id, 'wpf_daily_report', $_POST['wpf_daily_report'] );
    }
    else{
        delete_user_meta($user_id,'wpf_daily_report');
    }
    $wpf_weekly_report = $_POST['wpf_weekly_report'];
    if($wpf_weekly_report=='yes'){
        update_user_meta( $user_id, 'wpf_weekly_report', $_POST['wpf_weekly_report'] );
    }
    else{
        delete_user_meta($user_id,'wpf_weekly_report');
    }
    $wpf_auto_daily_report = $_POST['wpf_auto_daily_report'];
    if($wpf_auto_daily_report=='yes'){
    	update_user_meta( $user_id, 'wpf_auto_daily_report', $_POST['wpf_auto_daily_report'] );	
    }
    else{
        delete_user_meta($user_id,'wpf_auto_daily_report');
    }
    $wpf_auto_weekly_report = $_POST['wpf_auto_weekly_report'];
    if($wpf_auto_weekly_report=='yes'){
    	update_user_meta( $user_id, 'wpf_auto_weekly_report', $_POST['wpf_auto_weekly_report'] );
    }
    else{
        delete_user_meta($user_id,'wpf_auto_weekly_report');
    }
    update_user_meta( $user_id, 'wpf_user_initial_setup', 'yes' );
    echo 1;
    exit;
}
add_action('wp_ajax_wpf_update_current_user_first_step', 'wpf_update_current_user_first_step');
add_action('wp_ajax_nopriv_wpf_update_current_user_first_step', 'wpf_update_current_user_first_step');

function wpf_update_current_user_sec_step(){
    return 1;
    exit;
}
add_action('wp_ajax_wpf_update_current_user_sec_step', 'wpf_update_current_user_sec_step');
add_action('wp_ajax_wpf_nopriv_update_current_user_sec_step', 'wpf_update_current_user_sec_step');

function wpf_get_allowed_notification_list($userid,$default='no'){
    /*global $current_user;
    $user = $current_user;*/
    $response = '';
    $wpf_every_new_task = get_option('wpf_every_new_task');
    $wpf_every_new_comment = get_option('wpf_every_new_comment');
    $wpf_every_new_complete = get_option('wpf_every_new_complete');
    $wpf_every_status_change = get_option('wpf_every_status_change');
    $wpf_daily_report = get_option('wpf_daily_report');
    $wpf_weekly_report = get_option('wpf_weekly_report');
    $wpf_auto_daily_report = get_option('wpf_auto_daily_report');
    $wpf_auto_weekly_report = get_option('wpf_auto_weekly_report');
    

    if($wpf_every_new_task=='yes'){
        if(get_the_author_meta('wpf_every_new_task', $userid) == 'yes'){
            $checked='checked';
        }
        else{
            $checked='';
        }
        if($default=='yes'){
            $checked='checked';
        }
        $response.='<div class="wpf_checkbox"><input type="checkbox" name="wpf_every_new_task" value="yes"
                           id="wpf_every_new_task" '.$checked.' /><label for="wpf_every_new_task">'.__('Receive email notification for every new task', 'wpfeedback').'</label></div>';
    }
    if($wpf_every_new_comment=='yes'){
        if(get_the_author_meta('wpf_every_new_comment', $userid) == 'yes'){
            $checked='checked';
        }
        else{
            $checked='';
        }
        if($default=='yes'){
            $checked='checked';
        }
        $response.='<div class="wpf_checkbox"><input type="checkbox" name="wpf_every_new_comment" value="yes"
                           id="wpf_every_new_comment" '.$checked.' /><label for="wpf_every_new_comment">'.__('Receive email notification for every new comment', 'wpfeedback').'</label></div>';
    }
    if($wpf_every_new_complete=='yes'){
        if(get_the_author_meta('wpf_every_new_complete', $userid) == 'yes'){
            $checked='checked';
        }
        else{
            $checked='';
        }
        if($default=='yes'){
            $checked='checked';
        }
        $response.='<div class="wpf_checkbox"><input type="checkbox" name="wpf_every_new_complete" value="yes"
                           id="wpf_every_new_complete" '.$checked.' /><label for="wpf_every_new_complete">'.__('Receive email notification when a task is marked as complete', 'wpfeedback').'</label></div>';
    }
    if($wpf_every_status_change=='yes'){
        if(get_the_author_meta('wpf_every_status_change', $userid) == 'yes'){
            $checked='checked';
        }
        else{
            $checked='';
        }
        if($default=='yes'){
            $checked='checked';
        }
        $response.='<div class="wpf_checkbox"><input type="checkbox" name="wpf_every_status_change" value="yes"
                           id="wpf_every_status_change" '.$checked.' /><label for="wpf_every_status_change">'.__('Receive email notification for every status change', 'wpfeedback').'</label></div>';
    }
    /*if($wpf_daily_report=='yes'){
        if(get_the_author_meta('wpf_daily_report', $userid) == 'yes'){
            $checked='checked';
        }
        else{
            $checked='';
        }
        if($default=='yes'){
            $checked='checked';
        }
        $response.='<div class="wpf_checkbox"><input type="checkbox" name="wpf_daily_report" value="yes"
                           id="wpf_daily_report" '.$checked.' /><label for="wpf_daily_report">'.__('Receive email notification for  daily report', 'wpfeedback').'</label></div>';
    }
    if($wpf_weekly_report=='yes'){
        if(get_the_author_meta('wpf_weekly_report', $userid) == 'yes'){
            $checked='checked';
        }
        else{
            $checked='';
        }
        if($default=='yes'){
            $checked='checked';
        }
        $response.='<div class="wpf_checkbox"><input type="checkbox" name="wpf_weekly_report" value="yes"
                           id="wpf_weekly_report" '.$checked.' /><label for="wpf_weekly_report">'.__('Receive email notification for weekly report', 'wpfeedback').'</label></div>';
    }*/
    if($wpf_auto_daily_report=='yes'){
    	if(get_the_author_meta('wpf_auto_daily_report', $userid) == 'yes'){
            $checked='checked';
        }
        else{
            $checked='';
        }
        if($default=='yes'){
            $checked='checked';
        }
        $response.='<div class="wpf_checkbox"><input type="checkbox" name="wpf_auto_daily_report" value="yes"
                           id="wpf_auto_daily_report" '.$checked.' /><label for="wpf_auto_daily_report">'.__('Auto receive email notification for daily report', 'wpfeedback').'</label></div>';
    }
    if($wpf_auto_weekly_report=='yes'){
    	if(get_the_author_meta('wpf_auto_weekly_report', $userid) == 'yes'){
            $checked='checked';
        }
        else{
            $checked='';
        }
        if($default=='yes'){
            $checked='checked';
        }
        $response.='<div class="wpf_checkbox"><input type="checkbox" name="wpf_auto_weekly_report" value="yes"
                           id="wpf_auto_weekly_report" '.$checked.' /><label for="wpf_auto_weekly_report">'.__('Auto receive email notification for weekly report', 'wpfeedback').'</label></div>';
    }

    return $response;
}

function wpf_user_type(){
    global $current_user;
    $wpf_get_user_type = '';
    $wpf_get_user_type =esc_attr( get_the_author_meta( 'wpf_user_type', $current_user->ID ) );
    return $wpf_get_user_type;
}

function wpf_upload_file(){
    global $wpdb,$current_user;
    if($current_user->ID==0){
        $user_id = get_option( 'wpf_website_client');
    }
    else{
        $user_id = $current_user->ID;
    }

    $wpf_taskid = $_POST['wpf_taskid'];
    require_once(ABSPATH .'/wp-load.php');
    require_once( ABSPATH . 'wp-admin/includes/admin.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    if( ! empty( $_FILES ) ) {
        foreach( $_FILES as $file ) {
            if( is_array( $file ) ) {

                $data = file_get_contents($_FILES['wpf_upload_file']['tmp_name']);
                $data = base64_encode($data);
                $invalid = wpf_verify_file_upload($_SERVER,$data);

                if($invalid==0){
                    $uploadedfile = $file;
                    $upload_overrides = array( 'test_form' => false );
                    $file_return = wp_handle_upload( $uploadedfile, $upload_overrides );
                    if( isset($file_return['error']) || isset($file_return['upload_error_handler']) ) {
                        $response = array(
                                'status'=>0,
                                'message'=>'error'
                            );
                    }
                    else{
                        $filename = $file_return['file'];
                        if(in_array($file_return['type'],array('image/jpeg','image/png','image/gif'))){
                            $file_type=1;
                        }
                        else{
                            $file_type=2;
                        }
                        $attachment = array(
                            'post_title'=>preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                            'post_mime_type' => $file_return['type']
                        );
                        $attachment_id = wp_insert_attachment($attachment, $file_return['url'], $wpf_taskid );
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
                        wp_update_attachment_metadata( $attachment_id, $attachment_data );
                        if( 0 < intval( $attachment_id ) ) {
                            $attach_id = $attachment_id;
                            $comment_time = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
                            $commentdata = array(
                                'comment_post_ID' => $wpf_taskid,
                                'comment_author' => $_POST['task_config_author_name'],
                                'comment_author_email' => '',
                                'comment_author_url' => '',
                                'comment_content' => $file_return['url'],
                                'comment_type' => 'wp_feedback',
                                'comment_parent' => 0,
                                'user_id' => $user_id,
                                'comment_date' => $comment_time
                            );
                            $comment_id =  $wpdb->insert("{$wpdb->prefix}comments", $commentdata);
                            /*if($wpf_every_new_task == 'yes') {
                                wpf_send_email_notification($wpf_taskid, $comment_id, $_POST['task_notify_users'], 'new_comment');
                            }*/
                            $response = array(
                                'status'=>1,
                                'type'=>$file_type,
                                'message'=>$file_return['url']
                            );
                        }
                    }
                }
                else{
                    $response = array(
                        'status'=>0,
                        'message'=>'invalid'
                    );
                }

            }
        }
    }

    echo json_encode($response);
    die();
}
add_action('wp_ajax_wpf_upload_file', 'wpf_upload_file');
add_action('wp_ajax_nopriv_wpf_upload_file', 'wpf_upload_file');

function wpf_verify_file_upload($server,$file_data){
    $allowed_file_types = array('image/jpeg','image/png','image/gif','application/pdf','text/plain','application/octet-stream','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    if(!empty($server['HTTP_X_REQUESTED_WITH']) && strtolower($server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        if (function_exists('finfo_open')) {
            // $response=0;
            $imgdata = base64_decode($file_data);
            $f = finfo_open();

            $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);

            if (in_array($mime_type, $allowed_file_types)) {
                $response = 0;
            } else {
                $response = 1;
            }
        }else{
            $response = 0;
        }
    }
    else{
        $response=1;
    }

    

    return $response;
}

function wpf_get_page_list(){
    $response = array();

    $wpf_default_wp_post_types = array("page"=>"page","post"=>"post");

    $wpf_wp_cpts = get_post_types(array('public' => true,'exclude_from_search' => true,'_builtin' => false));
    $wpf_post_types = array_merge($wpf_default_wp_post_types,$wpf_wp_cpts);


    foreach ($wpf_post_types as $wpf_post_type){
        $objType = get_post_type_object($wpf_post_type);

        $wpf_temp_arg = array(
            'post_type' => $wpf_post_type
        );
        $posts = get_posts($wpf_temp_arg);
        $wpf_count_post = count($posts);
        if($wpf_count_post){
            foreach ( $posts as $post ) {
                $response[$objType->labels->singular_name][$post->ID]=htmlspecialchars($post->post_title, ENT_QUOTES, 'UTF-8');
            }
        }
    }
    return json_encode($response);
}