<div class="wrap wpfeedback-settings">
    <?php 
    global $current_user;
    $wpf_user_name = $current_user->user_nicename;
    $wpf_user_email = $current_user->user_email;
    $wpfeedback_font_awesome_script = get_option('wpf_font_awesome_script');
    $wpf_user_type = wpf_user_type();
    if ($wpfeedback_font_awesome_script == 'yes') { ?>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
              integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
              crossorigin="anonymous">
    <?php } ?>
    <h1><?php //echo esc_html( get_admin_page_title() ); ?></h1>
    <div class="wpf_logo">
        <img src="<?php echo get_wpf_logo(); ?>" alt="WP Feedback">
    </div>

    <!-- ================= TOP TABS ================-->

    <div class="wpf_tabs_container" id="wpf_tabs_container">
        <button class="wpf_tab_item wpf_tasks active" onclick="openWPFTab('wpf_tasks')"
                style="background-color: #efefef;">Tasks
        </button>

        <?php if($wpf_user_type == 'advisor'){ ?>
            <button class="wpf_tab_item wpf_settings" onclick="openWPFTab('wpf_settings')"
                    style="background-color: #efefef;">Settings
            </button>
        <?php }
        if($wpf_user_type == 'advisor' || $wpf_user_type == 'king'){ ?>
            <button class="wpf_tab_item wpf_addons" onclick="openWPFTab('wpf_addons')" style="background-color: #efefef;">
                Integrate
            </button>
        <?php } if($wpf_user_type == 'advisor'){ ?>
            <button class="wpf_tab_item wpf_support" onclick="openWPFTab('wpf_support')" style="background-color: #efefef;">
                Support
            </button>
            <a href="https://wpfeedback.co/#start" target="_blank" class="wpf_tab_item" style="background-color: #efefef;">
                <button>Upgrade</button>
            </a>
        <?php } ?>
    </div>

    <!-- ================= TASKS PAGE ================-->
    <?php
        $wpf_daily_report = get_option('wpf_daily_report');
        $wpf_weekly_report = get_option('wpf_weekly_report');
    ?>
    <div id="wpf_tasks" class="wpf_container">
        <div class="wpf_section_title">
            Tasks Center
            <div class="wpf_report_buttons">
                <span id="wpf_back_report_sent_span" class="wpf_hide text-success">Your report was sent</span>
                <?php
                    if($wpf_daily_report=='yes') {
                        ?>
                        <a href="javascript:wpf_send_report('daily_report')"><i class="far fa-envelope"></i> Daily
                            Report</a>
                        <?php
                    }
                    if($wpf_weekly_report=='yes') {
                        ?>
                        <a href="javascript:wpf_send_report('weekly_report')"><i class="far fa-envelope"></i> Weekly
                            Report</a>
                        <?php
                    }
            	 ?>
			</div>
        </div>
        <div class="wpf_flex_wrap">
            <div class="wpf_filter_col wpf_gen_col">
                <div class="wpf_filter_status wpf_icon_box">
                    <div class="wpf_title">Filter Tasks</div>
                    <form method="post" action="<?php echo admin_url('admin.php'); ?>" id="wpf_filter_form">
                        <div class="wpf_task_status_title wpf_icon_title"><i class="fa fa-thermometer-half"></i>Task
                            Status
                        </div>
                        <input type="hidden" name="page" value="wpfeedback_page_settings">
                        <div><?php echo wp_feedback_get_texonomy('task_status'); ?></div>
                        <div class="wpf_task_priority_title wpf_icon_title"><i class="fa fa-exclamation-circle"></i>
                            Task Urgency
                        </div>
                        <div><?php echo wp_feedback_get_texonomy('task_priority'); ?></div>
                        <div class="wpf_user_title wpf_icon_title"><i class="fa fa-user"></i> By Users</div>
                        <div><?php echo do_shortcode('[wpf_user_list]'); ?></div>
                        <input type="button" name="wp_feedback_filter_btn" value="Filter" id="wp_feedback_filter_btn"
                               class="wpf_button" onclick="wp_feedback_cat_filter()">
                    </form>
                </div>
            </div>
            <div class="wpf_tasks_col wpf_gen_col">
				<div class="wpf_top_found"><div class="wpf_title">Tasks Found</div>
                <a href="javascript:wpf_general_comment();" title="Click to give your feedback!" data-placement="left" class="wpf_general_comment_btn"><i class="fas fa-plus-square"></i> General Task</a></div>
                <div class="wpf_tasks-list"><?php echo $tasks = wpfeedback_get_post_list(); ?></div>
            </div>
            <div class="wpf_chat_col wpf_gen_col" id="wpf_task_details">
                <div class="wpf_loader_admin hidden"></div>
                <div class="wpf_chat_top">
                    <div class="wpf_task_num_top"></div>
                    <div class="wpf_task_main_top">
                        <div class="wpf_task_title_top"></div>
                        <div class="wpf_task_details_top"></div>
                    </div>
                </div>
                <?php if($tasks=='No tasks found'){ ?>
                <div class="wpf_chat_box" id="wpf_message_content">
                    <p class="wpf_no_task_message"><b>No Tasks found.</b><br/>Please have a look at the video to understand the process.</p>
                    <script src="https://fast.wistia.com/embed/medias/cided37ieu.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding" style="padding:48.75% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><div class="wistia_embed wistia_async_cided37ieu videoFoam=true" style="height:100%;position:relative;width:100%">&nbsp;</div></div></div>
                </div>
                <?php } else{ ?>
                <div class="wpf_chat_box" id="wpf_message_content">
                    <ul id="wpf_message_list"></ul>
                </div>
                <?php } ?>
                <div class="wpf_chat_reply" id="wpf_message_form"></div>
            </div>
            <div class="wpf_attributes_col wpf_gen_col" id="wpf_attributes_content">
                <div class="wpf_task_attr wpf_task_title">
                    <div class="wpf_title">Task Attributes</div>
                    <a href="#" id="wpfb_attr_task_page_link" target="_blank" class="wpf_button">
                        <input type="button" name="wp_feedback_task_page" class="wpf_button" value="Open Task's Page"></a>
                </div>
                <div class="wpf_task_attr wpf_task_page">
                    <div class="wpf_icon_title"><i class="fa fa-compass"></i> Additional Information</div>
                    <div id="additional_information">
                    </div>
                </div>
                <div class="wpf_task_attr">
                    <?php if($wpf_user_type == 'advisor'){ ?>
                        <div class="wpf_task_status">
                            <div class="wpf_icon_title"><i class="fa fa-thermometer-half"></i> Task Status</div>
                            <?php echo wp_feedback_get_texonomy_selectbox('task_status'); ?>
                        </div>
                    <?php }
                    if($wpf_user_type == 'advisor' || $wpf_user_type == 'king'){ ?>
                        <div class="wpf_task_urgency">
                            <div class="wpf_icon_title"><i class="fa fa-exclamation-circle"></i> Task Urgency</div>
                            <?php echo wp_feedback_get_texonomy_selectbox('task_priority'); ?>
                        </div>
                    <?php } ?>
                    <div class="wpf_task_attr wpf_task_title" id="wpf_delete_task_container">
                    </div>
                </div>


                <div class="wpf_task_attr wpf_task_users">
                    <div class="wpf_icon_title"><i class="fa fa-user"></i> Notify Users</div>
                    <div class="wpf_checkbox">
                        <?php echo do_shortcode('[wpf_user_list_task]'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= SETTINGS PAGE ================-->
    <?php if($wpf_user_type == 'advisor'){ ?>
        <div id="wpf_settings" class="wpf_container" style="display:none">
            <div class="wpf_section_title">WP Feedback Settings</div>
            <form method="post" action="admin-post.php" >
                <div class="wpf_settings_ctt_wrap">
                    <div class="wpf_settings_col">
                        <input type="hidden" name="action" value="save_wpfeedback_options"/>
                        <?php wp_nonce_field('wpfeedback'); ?>
                        <div class="wpf_title_section">General Settings</div>
                        <div class="wpfeedback_licence_key">
                            <div class="wpf_title"><?php _e('Validate Your Installation', ''); ?></div>
                            <span><?php _e('The plugin will not work unless you insert a valid license key and <a href="https://wpfeedback.co/knowledge-base/faq/installation/" target="_blank">link the domain</a>.', 'wpfeedback'); ?></span>
                            <div class="wpfeedback_licence_key_field">
                                <input type="password" name="wpfeedback_licence_key"
                                       value="<?php echo get_option('wpf_license_key'); ?>" autocomplete="off"/><?php if (get_option('wpf_license') == 'valid') {
                                    echo '<b><span class="dashicons dashicons-yes" style="font-size:40px; width:40px; height:40px; color: green;"></span></b>';
                                } else {
                                    echo '<b><span class="dashicons dashicons-no-alt" style="font-size:40px; width:40px; height:40px; color: red;"></span></b>';
                                } ?>
                            </div>
                            <span><?php _e("If you don't have a valid license, <a href='https://wpfeedback.co/' target='_blank'>Please click here to get a new license key</a>", 'wpfeedback'); ?></span>
                        </div>
                        <div class="enabled_wpfeedback">
                            <div class="wpf_title">
                                <input type="checkbox" name="enabled_wpfeedback" value="yes"
                                       id="enabled_wpfeedback" <?php if (get_option('wpf_enabled') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="enabled_wpfeedback"><?php _e('Enable WP Feedback on this website', 'wpfeedback'); ?></label>
                            </div>
                        </div>
                        <div class="wpfeedback_user_role_list">
                            <div class="wpf_title"><?php _e('User roles allowed to create tasks', 'wpfeedback'); ?></div>
                            <span><?php _e("Hold down the CTRL key to choose multiple options", 'wpfeedback'); ?></span>
                            <select multiple="true" id="wpfeedback_user_role_list"
                                    name="wpfeedback_selcted_role[]"><?php echo wpfeedback_dropdown_roles(); ?></select>
                        </div>

                        <div class="wpfeedback_guest_allowed">
                            <div class="wpf_title">
                                <input type="checkbox" name="wpfeedback_guest_allowed" value="yes"
                                       id="wpfeedback_guest_allowed" <?php if (get_option('wpf_allow_guest') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpfeedback_guest_allowed"><?php _e('Guest allowed', 'wpfeedback'); ?></label>
                            </div>
                        </div>

                        <div class="wpf_show_front_stikers">
                            <div class="wpf_title">
                                <input type="checkbox" name="wpf_show_front_stikers" value="yes"
                                       id="wpf_show_front_stikers" <?php if (get_option('wpf_show_front_stikers') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_show_front_stikers"><?php _e('Show task stickers by default', 'wpfeedback'); ?></label>
                            </div>
                        </div>

                        <div class="wpfeedback_font_awesome_script">
                            <div class="wpf_title">
                                <input type="checkbox" name="wpfeedback_font_awesome_script" value="yes"
                                       id="wpfeedback_font_awesome_script" <?php if (get_option('wpf_font_awesome_script') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpfeedback_font_awesome_script"><?php _e('Remove Font-Awesome Script', 'wpfeedback'); ?></label>
                            </div>
                            <span><?php _e("ONLY if you already have the script running on all pages of the site ", 'wpfeedback'); ?></span>
                        </div>

                        <?php
                        $wpfb_users_json = do_shortcode('[wpf_user_list_front]');
                        $wpfb_users = json_decode($wpfb_users_json);
                        $wpf_website_client = get_option('wpf_website_client');
                        $wpf_website_developer = get_option('wpf_website_developer');
                        ?>


                    </div>
                    <div class="wpf_settings_col">
                        <div class="wpf_title_section">White Label</div>
                        <div class="wpfeedback_replace_logo">
                            <div class="wpf_title">Replace the WP Feedback logo</div>
                            <span>The new logo should be 180px width X 45px height</span>
                            <?php wp_enqueue_media(); ?>
                            <input id="upload_image_button" type="button" class="button"
                                   value="<?php _e('Upload image'); ?>"/>
                            <input type='hidden' name='wpfeedback_logo' id='image_attachment_id'
                                   value='<?php echo get_option('wpf_logo'); ?>'>
                            <div class='wpfeedback_image-preview-wrapper'>
                                <img id='wpfeedback_image-preview' src='<?php echo get_wpf_logo(); ?>' height='100'>
                            </div>
                        </div>
                        <div class="wpfeedback_main_color">
                            <div class="wpf_title">Change the main color</div>
                            <input type"text" name="wpfeedback_color" value="<?php echo get_option('wpf_color'); ?>"
                            class="jscolor" id="wpfeedback_color"/>
                            <span>Replace the WP Feedback blue with your own brand color</span>
                        </div>
                        <div class="wpfeedback_powered_by">
                            <div class="wpf_title">
                                <input type="checkbox" name="wpfeedback_powered_by" value="yes"
                                       id="wpfeedback_powered_by" <?php if (get_option('wpf_powered_by') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpfeedback_powered_by"><?php _e('Remove the “Powered by” link', 'wpfeedback'); ?></label>
                            </div>
                        </div>
                        <div class="wpfeedback_reset_setting">
                            <div class="wpf_title">
                                <input type="button" value="<?php _e('Reset plugin settings', 'wpfeedback'); ?>"
                                       class="wpf_button" onclick="wpfeedback_reset_setting()"/>
                            </div>
                        </div>
                        <div class="wpfeedback_customisations">
                            <div class="wpf_title_section">Customisations</div>
							<label><b>Client (Website Owner)</b><br>Can do everything except: Choose and change status, Access the settings, support and upgrade screens. Can only delete his own tickets.</label><br/><input type="text" class="wpf_customise_field" name="wpf_customisations_client" value="<?php echo get_option('wpf_customisations_client'); ?>"><br/>
                            <label><b>Webmaster</b><br>Super admin – he has full capabilities for all the plugin’s functions.</label><br/><input type="text" class="wpf_customise_field" name="wpf_customisations_webmaster" value="<?php echo get_option('wpf_customisations_webmaster'); ?>"><br/>
                            <label><b>Others</b><br>Can do everything except: Choose and change status and urgency, Access the settings, support, integration and upgrade screens. Can only delete his own tickets.</label><br/><input type="text" class="wpf_customise_field" name="wpf_customisations_others" value="<?php echo get_option('wpf_customisations_others'); ?>">
                        </div>
                    </div>
                    <div class="wpf_settings_col">
                        <div class="wpf_title_section">Notifications Settings</div>
                        <div class="wpfeedback_more_emails">
                            <?php
                                $wpf_from_email = get_option('wpf_from_email');
                                if($wpf_from_email==''){
                                    $wpf_from_email = get_option('admin_email');
                                }
                            ?>
                            <div class="wpf_title"><?php _e('Sent from email address', ''); ?></div>
                            <span><?php _e('Set a "From" email address to send all notifications.', 'wpfeedback'); ?></span><br>
                            <p><input type="email" name="wpf_from_email"
                                      value="<?php echo $wpf_from_email; ?>"/></p>
                        </div>
                        <div class="wpfeedback_more_emails">
                            <div class="wpf_title"><?php _e('Send email notifications to the following address', ''); ?></div>
                            <span><?php _e('This option is in addition to the user emails. Seperate with comma for multipe addresses.', 'wpfeedback'); ?></span><br>
                            <p><input type="text" name="wpfeedback_more_emails"
                                      value="<?php echo get_option('wpf_more_emails'); ?>"/></p>
                        </div>
                        <div class="wpfeedback_email_notifications">
                            <div class="wpf_title">Email notifications</div>
							<p>
								These are global notifications settings, then each user can choose the ones they would like to recieve (on the front end wizard or inside the WordPress user profile).
							</p>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_every_new_task" value="yes"
                                       id="wpf_every_new_task" <?php if (get_option('wpf_every_new_task') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_every_new_task"><?php _e('Send email notification for every new task', 'wpfeedback'); ?></label>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_every_new_comment" value="yes"
                                       id="wpf_every_new_comment" <?php if (get_option('wpf_every_new_comment') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_every_new_comment"><?php _e('Send email notification for every new comment', 'wpfeedback'); ?></label>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_every_new_complete" value="yes"
                                       id="wpf_every_new_complete" <?php if (get_option('wpf_every_new_complete') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_every_new_complete"><?php _e('Send email notification when a task is marked as complete', 'wpfeedback'); ?></label>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_every_status_change" value="yes"
                                       id="wpf_every_status_change" <?php if (get_option('wpf_every_status_change') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_every_status_change"><?php _e('Send email notification for every status change', 'wpfeedback'); ?></label>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_daily_report" value="yes"
                                       id="wpf_daily_report" <?php if (get_option('wpf_daily_report') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_daily_report"><?php _e('Send email notification for last 24 hours report', 'wpfeedback'); ?></label>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_weekly_report" value="yes"
                                       id="wpf_weekly_report" <?php if (get_option('wpf_weekly_report') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_weekly_report"><?php _e('Send email notification for last 7 days report', 'wpfeedback'); ?></label>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_auto_daily_report" value="yes"
                                       id="wpf_auto_daily_report" <?php if (get_option('wpf_auto_daily_report') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_auto_daily_report"><?php _e('Auto send email notification for daily report', 'wpfeedback'); ?></label>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_auto_weekly_report" value="yes"
                                       id="wpf_auto_weekly_report" <?php if (get_option('wpf_auto_weekly_report') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_auto_weekly_report"><?php _e('Auto send email notification for weekly report', 'wpfeedback'); ?></label>
                            </div>
                            <br>
                            <div class="wpf_title">Default users</div>
                            <div class="wpf_website_developer">
                                <label><b>The website builder</b>
								<br>The website builder will add this user to all tasks by default, allowing the client to skip the "choose a user" tab when creating a task.</label>
                                <select name="wpf_website_developer">
                                    <option value="0">select</option>
                                    <?php
                                    foreach ($wpfb_users as $key => $val) {
                                        ?>
                                        <option value="<?php echo $key; ?>" <?php if ($wpf_website_developer == $key) {
                                            echo "selected";
                                        } ?> ><?php echo $val; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="wpf_website_client">
                                <label><b>The client</b>
								<br>Create a user for the client and assign it here to allow the client to comment in guest mode but still be assigned to the tickets for replies and notifications.</label>
                                <select name="wpf_website_client">
                                    <option value="0">select</option>
                                    <?php
                                    foreach ($wpfb_users as $key => $val) {
                                        ?>
                                        <option value="<?php echo $key; ?>" <?php if ($wpf_website_client == $key) {
                                            echo "selected";
                                        } ?>><?php echo $val; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <input type="submit" value="<?php _e('Save Changes', 'wpfeedback'); ?>" class="wpf_button"
                               id="wpf_save_setting"/>
                    </div>
                </div>
            </form>
        </div>
    <?php } ?>
    <!-- ================= ADD-ONS PAGE ================-->
    <?php if($wpf_user_type == 'advisor' || $wpf_user_type == 'king'){ ?>
        <div id="wpf_addons" class="wpf_container" style="display:none">
            <div class="wpf_section_title">WPFeedback Integrations</div>
            <div class="wpf_inner_container">
                <a href="https://wpfeedback.co/knowledge-base/faq/integrate-wp-feedback-to-1500-apps-via-zapier/"
                   target="_blank"><img alt="WP Feedback and Zapier" class="wpf_integration_image"
                                        src="https://staging-wpfeedbackdemo.kinsta.cloud/wp-content/uploads/2019/04/integrations-image.png"/></a>
                <!-- <div class="wpf_intro">
    				<div class="wpf_title">Additional Add ons will be available soon.</div>
    				<p>Click the button on each of the add-ons below to let us know which ones you’re interested in so that we can expedite the built based on your requirements.</p>
    			</div>
    			<div class="wpf_addon_box_wrap">
    				<div class="wpf_addon_box">
    					<img src="http://wpfeedback.co/wp-content/uploads/2019/03/WPfeedback-Slack.png" alt="WP Feedback">
    					<div class="wpf_title">Slack Add-on</div>
    					<p>Get notified about new tasks and task updated directly to the right channel within your slack account.</p>
    					<input type="button" id="Slack" value="<?php _e('I want this add-on', 'wpfeedback'); ?>" class="wpf_button" onclick="wpf_add_ons_form('Slack')"/>
    				</div>
    				<div class="wpf_addon_box">
    					<img src="http://wpfeedback.co/wp-content/uploads/2019/03/WPfeedback-Zapier.png" alt="WP Feedback">
    					<div class="wpf_title">Zapier Add-on</div>
    					<p>Integrate hundreds of apps via Zapier to automate your workflow and systemise your support.</p>
    					<input type="button" id="Zapier" value="<?php _e('I want this add-on', 'wpfeedback'); ?>" class="wpf_button" onclick="wpf_add_ons_form('Zapier')"/>
    				</div>
    				<div class="wpf_addon_box">
    					<img src="http://wpfeedback.co/wp-content/uploads/2019/03/WPfeedback-Trello.png" alt="WP Feedback">
    					<div class="wpf_title">Trello Add-on</div>
    					<p>Create Trello tickets every time a new task is created. Move the Trello ticket as the status and priority of the task changes.</p>
    					<input type="button" id="Trello" value="<?php _e('I want this add-on', 'wpfeedback'); ?>" class="wpf_button" onclick="wpf_add_ons_form('Trello')"/>
    				</div>
    			</div>
    		</div> -->
            </div>
        </div>
    <?php }?>
    <!-- ================= SUPPORT PAGE ================-->
    <?php if($wpf_user_type == 'advisor'){ ?>
    <div id="wpf_support" class="wpf_container">
        <div class="wpf_section_title">Support From WP Feedback</div>
        <div id="wpf_user_support_container" class="">
            <div class="wpf_loader_admin wpf_hide"></div>
            <div class="wpf_support_col_left">
                <div class="wpf_facebook_group">
                    <div class="wpf_fb_icon"><i class="fab fa-facebook"></i></div>
                    <div class="wpf_fb_text">
                        <div class="wpf_title"><a href="#" target="_blank">Join the tribe on Facebook</a></div>
                        <p>
                            Get faster answers by leveraging the community, we're there too of course!
                        </p></div>
                </div>
                <div class="wpf_title">Video walkthrough</div>
                <p class="wpf_walk_video">
                    <script src="https://fast.wistia.com/embed/medias/po8gy5uygu.jsonp" async></script>
                    <script src="https://fast.wistia.com/assets/external/E-v1.js" async></script>
                <div class="wistia_responsive_padding" style="padding:50.63% 0 0 0;position:relative;">
                    <div class="wistia_responsive_wrapper"
                         style="height:100%;left:0;position:absolute;top:0;width:100%;">
                        <div class="wistia_embed wistia_async_po8gy5uygu videoFoam=true"
                             style="height:100%;position:relative;width:100%">
                            <div class="wistia_swatch"
                                 style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;">
                                <img src="https://fast.wistia.com/embed/medias/po8gy5uygu/swatch"
                                     style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt=""
                                     onload="this.parentNode.style.opacity=1;"/></div>
                        </div>
                    </div>
                </div>
                </p>
                <div class="wpf_title">These should help</div>
                <ul dir="ltr">
                    <li><strong><a href="https://wpfeedback.co/knowledge-base/faq/installation/" target="_blank">Licenses
                                and domains</a></strong><br/>
                        Can&#39;t validate the license? You probably didn&#39;t add the domain. Follow the steps above.
                    </li>
                    <li>
                        <strong><a href="https://wpfeedback.co/knowledge-base/faq/integrate-wp-feedback-to-1500-apps-via-zapier/"
                                   target="_blank">Zapier Integration</a></strong><br/>
                        Step by step guide to integrating WP Feedback to 1500+ apps - Connect your workflow.
                    </li>
                    <li><strong><a href="https://wpfeedback.co/knowledge-base/faq/task-notifications/" target="_blank">Notifications
                                issues</a>&nbsp;</strong><br/>
                        Can&#39;t send emails? Getting too many emails? Answers inside.
                    </li>
                    <li><strong><a href="https://wpfeedback.co/partner-with-us/" target="_blank">Partner with us</a>&nbsp;</strong><br/>
                        If you&#39;re talking about us and send some peeps over - We wanna pay you!
                    </li>
                    <li><a href="https://wpfeedback.co/roadmap" target="_blank"><strong>Public Roadmap</strong></a><br/>
                        If we&#39;re advocating for feedback we better lead by example. You&#39;re invited to request&nbsp;features.
                    </li>
                    <li><strong><a href="https://wpandup.org/" target="_blank">Feeling stressed?
                                (WP&amp;UP)</a></strong><br/>
                        Dealing with clients is hard(!) This amazing charity for the WP community is here to help you
                        grow and relax.
                    </li>
                </ul>
            </div>
            <div class="wpf_support_col_right">
                <div class="wpf_title">Create a support ticket</div>
                <p><b>We will reply via email in up to 24 hours (Weekdays)</b></p>
                <form name="wpf_user_support" id="wpf_user_support">
                    <p>
                        We collected your name, email, license key and domain so all you need to do, is tell us what's
                        up.
                    </p>
                    
                    <div class="wpf_field_label"><b>Subject</b></div>
                    <div class="wpf_field_input"><input type="text" name="wpf_support_subject" id="wpf_support_subject">
                    </div>
                    <div class="wpf_field_label"><b>Message</b></div>
                    <div class="wpf_field_input"><textarea name="wpf_support_message" id="wpf_support_message"></textarea></div>

                    <div class="wpf_support_name_email">
                        <div class="wpf_support_name">
                            <div class="wpf_field_label"><b>Name</b></div>
                            <div class="wpf_field_input"><input type="text" name="wpf_support_name" id="wpf_support_name" value="<?php  echo $wpf_user_name; ?>">
                            </div>
                        </div>
                        <div class="wpf_support_email">
                            <div class="wpf_field_label"><b>Email</b></div>
                            <div class="wpf_field_input"><input type="email" name="wpf_support_email" id="wpf_support_email" value="<?php  echo $wpf_user_email; ?>">
                            </div>
                        </div>
                    </div>

                    <?php
                    global $wp_version;
                    if ($wp_version >= 5.2) {
                        ?>
                        <div class="wpf_field_label"><b>Insert Site Health Info</b> (WP 5.2 and up)</div>
                        <div class="wpf_field_input"><textarea name="wpf_support_site_health_info"
                                                               id="wpf_support_site_health_info"></textarea></div>
                        <span class="wpf_health_check"><a
                                    href="<?php echo admin_url() . 'site-health.php?tab=debug'; ?>" target="_blank">Click here to get site health info</a></span>

                        <?php
                    }
                    ?>
                    <input type="button" class="wpf_button" name="wpf_support_submit" id="wpf_support_submit"
                           value="Request Support">
                    <span class="wpf_error wpf_hide" id="wpf_support_submit_error">Sorry! Your message was not sent, please try after some time.</span>
                    <span class="wpf_support_sent wpf_hide" id="wpf_support_sent">Your message was sent to the WP Feedback Team. Thanks for contacting us. We will reply to this email address shortly: <?php echo $current_user->user_email; ?></span>
                </form>
            </div>
        </div>
    </div>
<?php } ?>