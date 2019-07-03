<?php
global $current_user;
if ($current_user->display_name == '') {
    $wpf_user_name = $current_user->user_nicename;
} else {
    $wpf_user_name = $current_user->display_name;
}
?>
<div class="wpf_backend_initial_setup">
    <div class="wpf_logo_wizard">
        <img src="<?php echo get_wpf_logo(); ?>" alt="WP Feedback">
    </div>
    <div class="wpf_backend_initial_setup_inner">
        <div class="wpf_loader_admin wpf_hide"></div>
        <form method="post" action="admin-post.php">
            <div id="wpf_initial_settings_first_step" class="wpf_initial_container">
                <div class="wpf_title_wizard">Let's get you up and running 🚀</div>
                <p>Good to have you here <?php echo $wpf_user_name; ?>! There are only 5 steps.</p>
                <input type="hidden" name="action" value="save_wpfeedback_options"/>
                <?php wp_nonce_field('wpfeedback'); ?>

                <div class="wpf_title">1. Add your license key.</div>
                <p>Found on your purchase confirmation email or within <a href="https://wpfeedback.co/my-account"
                                                                          target="_blank">your account.</a></p>
                <div class="wpfeedback_licence_key_field">
                    <input type="text" name="wpfeedback_licence_key"
                           value="<?php echo get_option('wpf_license_key'); ?>"/>
                    <?php if (get_option('wpf_license') == 'valid') {
                        echo '<b><span class="dashicons dashicons-yes" id="wpf_license_key_valid" style="display:inline-block; font-size:40px; width:40px; height:40px; color: green;"></span></b>';
                        echo '<b><span class="dashicons dashicons-no-alt" id="wpf_license_key_invalid" style="display:none; font-size:40px; width:40px; height:40px; color: red;"></span></b>';
                    } else {
                        echo '<b><span class="dashicons dashicons-yes" id="wpf_license_key_valid" style="display:none; font-size:40px; width:40px; height:40px; color: green;"></span></b>';
                        echo '<b><span class="dashicons dashicons-no-alt" id="wpf_license_key_invalid" style="display:inline-block; font-size:40px; width:40px; height:40px; color: red;"></span></b>';
                    } ?>
                </div>
                <p><?php _e("Don't have a valid license? <a href='https://wpfeedback.co/' target='_blank'>Click here.</a>", 'wpfeedback'); ?></p>

                <div class="wpf_title">2. Link this domain.</div>
                <p>Do that by clicking the "Manage Domains" link within <a href="https://wpfeedback.co/my-account"
                                                                           target="_blank">your account.</a></p>
                <btn href="javascript:void(0);" class="wpf_button" id="wpf_initial_setup_first_step_button">Validate
                    Domain
                </btn>
                <p id="wpf_license_validation_error" style="color: red; display: none;">Your domain is not validated,
                    please visit your account on our website.</p>
                <p>The plugin will not work until you complete this step.</p>
            </div>

            <div id="wpf_initial_settings_second_step" class="wpf_initial_container wpf_hide">
                <div class="wpf_title_wizard">3. Who should comment?</div>
                <p>The user roles that are allowed to create tickets and give feedback.</p>
                <?php
                $editable_roles = get_editable_roles();
                echo '<ul class="wp_feedback_filter_checkbox user">';
                foreach ($editable_roles as $role => $details) {
                    $name = translate_user_role($details['name']);
                    echo '<li><input type="checkbox" name="roles_list" value="' . esc_attr($role) . '" class="wp_feedback_task" id="' . esc_attr($role) . '" /><label for="' . esc_attr($role) . '">' . esc_html($name) . '</label></li>';
                }
                echo '</ul>';
                ?>
                <hr>
                <div class="wpf_checkbox">
                    <p><input type="checkbox" name="wpf_allow_guest" value="yes"
                              id="wpf_allow_guest" <?php if (get_option('wpf_allow_guest') == 'yes') {
                            echo 'checked';
                        } ?>/>
                        <label for="wpf_allow_guest"><b><?php _e('Allow guests to create tickets, without the need to log in to the site.', 'wpfeedback'); ?></b></label>
                    </p>
                    <p>This is great for staging sites or during the build, but not ideal for live websites. The real
                        magic is getting your clients used to using WordPress by encouraging them to log in to their own
                        website.</p>
                </div>
                <hr>
                <br>
                <div class="wpf_wizard_footer">
                    <a href="javascript:void(0);" id="wpf_initial_setup_second_step_prev_button"><< Back</a>
                    <btn href="javascript:void(0);" class="wpf_button wpf_next"
                         id="wpf_initial_setup_second_step_button">Next >>
                    </btn>
                </div>
            </div>

            <div id="wpf_initial_settings_third_step" class="wpf_initial_container wpf_hide">
                <div class="wpf_title_wizard">4. Choose notifications</div>
                <p>
                    <b>Which notifications would you like the plugin to send out?</b><br>
					These are global settings. Each user can then choose their own notifications out of the options selected here.
                </p>
                <div class="wpf_checkbox">
                    <input type="checkbox" name="wpf_every_new_task" value="yes"
                           id="wpf_every_new_task" checked />
                    <label for="wpf_every_new_task"><?php _e('Send email notification for every new task', 'wpfeedback'); ?></label>
                </div>
                <div class="wpf_checkbox">
                    <input type="checkbox" name="wpf_every_new_comment" value="yes"
                           id="wpf_every_new_comment" checked />
                    <label for="wpf_every_new_comment"><?php _e('Send email notification for every new comment', 'wpfeedback'); ?></label>
                </div>
                <div class="wpf_checkbox">
                    <input type="checkbox" name="wpf_every_new_complete" value="yes"
                           id="wpf_every_new_complete" checked />
                    <label for="wpf_every_new_complete"><?php _e('Send email notification when a task is marked as complete', 'wpfeedback'); ?></label>
                </div>
                <div class="wpf_checkbox">
                    <input type="checkbox" name="wpf_every_status_change" value="yes"
                           id="wpf_every_status_change" checked />
                    <label for="wpf_every_status_change"><?php _e('Send email notification for every status change', 'wpfeedback'); ?></label>
                </div>
                <div class="wpf_checkbox">
                    <input type="checkbox" name="wpf_daily_report" value="yes"
                           id="wpf_daily_report" checked />
                    <label for="wpf_daily_report"><?php _e('Send email notification for last 24 hours report', 'wpfeedback'); ?></label>
                </div>
                <div class="wpf_checkbox">
                    <input type="checkbox" name="wpf_weekly_report" value="yes"
                           id="wpf_weekly_report" checked />
                    <label for="wpf_weekly_report"><?php _e('Send email notification for last 7 days report', 'wpfeedback'); ?></label>
                </div>
                <div class="wpf_checkbox">
                    <input type="checkbox" name="wpf_auto_daily_report" value="yes"
                           id="wpf_auto_daily_report" checked />
                    <label for="wpf_auto_daily_report"><?php _e('Auto send email notification for daily report', 'wpfeedback'); ?></label>
                </div>
                <div class="wpf_checkbox">
                    <input type="checkbox" name="wpf_auto_weekly_report" value="yes"
                           id="wpf_auto_weekly_report" checked />
                    <label for="wpf_auto_weekly_report"><?php _e('Auto send email notification for weekly report', 'wpfeedback'); ?></label>
                </div>
                <br>
                <hr>
                <br>
                <div class="wpf_wizard_footer">
                    <a href="javascript:void(0);" id="wpf_initial_setup_third_step_prev_button"><< Back</a>
                    <btn href="javascript:void(0);" class="wpf_button wpf_next"
                         id="wpf_initial_setup_third_step_button">Next >>
                    </btn>
                </div>
            </div>
            <div id="wpf_initial_settings_fourth_step" class="wpf_initial_container wpf_hide">
                <div class="wpf_title_wizard">5. All done! 👏👏👏</div>
                <p>Watch this short video to show you how to use WP Feedback to its full potential, saving you loaaaads
                    of time and getting your client to love you even more.</p>
                <script src="https://fast.wistia.com/embed/medias/po8gy5uygu.jsonp" async></script>
                <script src="https://fast.wistia.com/assets/external/E-v1.js" async></script>
                <div class="wistia_responsive_padding" style="padding:50.63% 0 0 0;position:relative;">
                    <div class="wistia_responsive_wrapper"
                         style="height:100%;left:0;position:absolute;top:0;width:100%;"><span
                                class="wistia_embed wistia_async_po8gy5uygu popover=true popoverAnimateThumbnail=true videoFoam=true"
                                style="display:inline-block;height:100%;position:relative;width:100%">&nbsp;</span>
                    </div>
                </div>
                <br><br>
                <btn class="wpf_button" onclick="wpf_initial_setup_done()">Let's rock 🤘</btn>
            </div>
        </form>
    </div>
    <div class="wpf_skip_wizard"><a href="javascript:wpf_initial_setup_done()">Skip Wizard</a></div>
</div>