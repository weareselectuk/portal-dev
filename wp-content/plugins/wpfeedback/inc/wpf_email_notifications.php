<?php
function wpf_send_email_notification($task_id = 0, $comment_id = 0, $send_to_cs, $type)
{
    $wpf_more_emails = get_option('wpf_more_emails');
    $send_to_fullnames_arr = array();
    $send_to_emails_arr = array();

    $send_to_arr = explode(',', $send_to_cs);
    foreach ($send_to_arr as $send_to) {
        $temp_notif_user = get_userdata($send_to);
        if ($type == 'new_task') {
            $add_user = get_user_meta($temp_notif_user->data->ID, 'wpf_every_new_task', true);
        }
        if ($type == 'new_reply') {
            $add_user = get_user_meta($temp_notif_user->data->ID, 'wpf_every_new_comment', true);
        }
        if ($type == 'task_completed') {
            $add_user = get_user_meta($temp_notif_user->data->ID, 'wpf_every_new_complete', true);
        }
        if ($type == 'task_status_changed') {
            $add_user = get_user_meta($temp_notif_user->data->ID, 'wpf_every_status_change', true);
        }

        if ($add_user == 'yes') {
            $send_to_fullnames_arr[] = $temp_notif_user->display_name;
            $send_to_emails_arr[] = $temp_notif_user->user_email;
        }
    }
    $send_to_fullnames = implode(',', $send_to_fullnames_arr);

    $email_vars['wpf-website-name'] = get_bloginfo('name');

    if ($task_id != 0) {
        $post_data = get_post($task_id);
        $post_author = get_userdata($post_data->post_author);

        $task_priority = get_the_terms($task_id, 'task_priority');
        $task_status = get_the_terms($task_id, 'task_status');

        $task_page_url = get_post_meta($task_id, 'task_page_url', true);
        $task_comment_id = get_post_meta($task_id, 'task_comment_id', true);

        $task_type = get_post_meta($task_id, 'task_type', true);
        if($task_type=='general'){
            $task_reply_url = $task_page_url . '?wpf_general_taskid=' . $task_id;
        }
        else{
            $task_reply_url = $task_page_url . '?wpf_taskid=' . $task_comment_id;
        }


        $email_vars['wpf-task-by-first-and-last-name'] = $post_author->display_name;
        $email_vars['wpf-task-posted-time'] = $post_data->post_date;
        $email_vars['wpf-task-title'] = get_the_title($task_id);
        $email_vars['wpf-task-reply-url'] = $task_reply_url;
        $email_vars['wpf-task-assigned-user-fullnames'] = $send_to_fullnames;
        $email_vars['wpf-task-priority'] = $task_priority[0]->name;
        $email_vars['wpf-task-status'] = $task_status[0]->name;
        $email_vars['wpf-task-html-element'] = get_post_meta($task_id, 'task_element_html', true);
        $email_vars['wpf-task-page'] = get_post_meta($task_id, 'task_page_title', true);
        $email_vars['wpf-task-screen-resolution'] = get_post_meta($task_id, 'task_config_author_resX', true) . ' x ' . get_post_meta($task_id, 'task_config_author_resY', true) . ' px';
        $email_vars['wpf-task-browser'] = get_post_meta($task_id, 'task_config_author_browser', true) . ' ' . get_post_meta($task_id, 'task_config_author_browserVersion', true);
        $email_vars['wpf-user-ip'] = get_post_meta($task_id, 'task_config_author_ipaddress', true);
        $email_vars['wpf-task-id'] = $task_id;
        $email_vars['wpf-powered-by'] = 'https://wpfeedback.co/powered/?from=' . $email_vars['wpf-website-name'];
    }

    switch ($type) {
        case 'new_task':
            $subject = 'You have a new task on ' . $email_vars['wpf-website-name'];
            $body = file_get_contents(WPF_PLUGIN_DIR . 'inc/email_templates/You_have_a_new_task.html');
            break;

        case 'new_reply':
            $subject = 'You have a new reply on ' . $email_vars['wpf-website-name'];
            // $comment_details = get_comment( $comment_id );
            // $email_vars['wpf-task-latest-reply']=$comment_details->comment_content;
            $all_comments = list_wpf_comment_notif_func($task_id);
            $all_comments = '<ul style="list-style-type: none;">' . $all_comments . '</ul>';

            $email_vars['wpf-task-latest-reply'] = $all_comments;
            $body = file_get_contents(WPF_PLUGIN_DIR . 'inc/email_templates/You_have_a_new_reply.html');
            break;

        case 'task_completed':
            $subject = 'Your task on ' . $email_vars['wpf-website-name'] . ' is marked as complete';
            $body = file_get_contents(WPF_PLUGIN_DIR . 'inc/email_templates/Your_task_is_marked_as_complete.html');
            break;

        case 'task_status_changed':
            $subject = 'Your task status on ' . $email_vars['wpf-website-name'] . ' changed';
            $body = file_get_contents(WPF_PLUGIN_DIR . 'inc/email_templates/Your_task_status_changed.html');
            break;

        case 'daily_report':
        case 'weekly_report':
            if ($type == 'daily_report') {
                $subject = 'Your tasks summary for the day';
                $body = file_get_contents(WPF_PLUGIN_DIR . 'inc/email_templates/Your_task_summary_for_the_day.html');
                $args_today = array(
                    'post_type' => 'wpfeedback',
                    'post_status' => 'publish',
                    'date_query' => array(
                        'column' => 'post_date',
                        'after' => '- 1 days'
                    )
                );
                $args_completed = array(
                    'post_type' => 'wpfeedback',
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'task_status',
                            'field' => 'slug',
                            'terms' => array('complete')
                        )
                    ),
                    'date_query' => array(
                        'column' => 'post_date',
                        'after' => '- 1 days'
                    )
                );
            } else {
                $subject = 'Weekly Report';
                $args_today = array(
                    'post_type' => 'wpfeedback',
                    'post_status' => 'publish',
                    'date_query' => array(
                        'column' => 'post_date',
                        'after' => '- 7 days'
                    )
                );
                $args_completed = array(
                    'post_type' => 'wpfeedback',
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'task_status',
                            'field' => 'slug',
                            'terms' => array('complete')
                        )
                    ),
                    'date_query' => array(
                        'column' => 'post_date',
                        'after' => '- 7 days'
                    )
                );
            }

            $todays_posts = get_posts($args_today);
            $todays_posts_html = '';
            foreach ($todays_posts as $todays_post) {
                $temp_task_id = $todays_post->ID;
                $temp_task_priority = get_the_terms($temp_task_id, 'task_priority');
                $temp_task_status = get_the_terms($temp_task_id, 'task_status');
                $temp_task_priority = $temp_task_priority[0]->name;
                $temp_task_status = $temp_task_status[0]->name;
                $temp_task_page = get_post_meta($temp_task_id, 'task_page_title', true);
                $task_page_url = get_post_meta($temp_task_id, 'task_page_url', true);
                $task_comment_id = get_post_meta($temp_task_id, 'task_comment_id', true);
                $task_reply_url = $task_page_url . '?wpf_taskid=' . $task_comment_id;

                $todays_posts_html .= '<tr class="kmTableRow">
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;width:45%;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $todays_post->post_title . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;width:20%;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $temp_task_page . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $temp_task_priority . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $temp_task_status . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;border-right:none;text-align:left;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        <a href="' . $task_reply_url . '"
                                           style="word-wrap:break-word;max-width:100%;color:#15C;font-weight:normal;text-decoration:underline"><strong>Open</strong></a>
                                    </td>
                                </tr>';
            }
            $email_vars['wpf-task-added-today'] = $todays_posts_html;
            wp_reset_postdata();

            $completed_posts = get_posts($args_completed);
            $completed_posts_html = '';
            foreach ($completed_posts as $completed_post) {
                $temp_task_id = $completed_post->ID;
                $temp_task_priority = get_the_terms($temp_task_id, 'task_priority');
                $temp_task_status = get_the_terms($temp_task_id, 'task_status');
                $temp_task_priority = $temp_task_priority[0]->name;
                $temp_task_status = $temp_task_status[0]->name;
                $temp_task_page = get_post_meta($temp_task_id, 'task_page_title', true);
                $task_page_url = get_post_meta($temp_task_id, 'task_page_url', true);
                $task_comment_id = get_post_meta($temp_task_id, 'task_comment_id', true);
                $task_reply_url = $task_page_url . '?wpf_taskid=' . $task_comment_id;

                $completed_posts_html .= '<tr class="kmTableRow">
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;width:45%;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $completed_post->post_title . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;width:20%;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $temp_task_page . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $temp_task_priority . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $temp_task_status . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;border-right:none;text-align:left;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        <a href="' . $task_reply_url . '"
                                           style="word-wrap:break-word;max-width:100%;color:#15C;font-weight:normal;text-decoration:underline"><strong>Open</strong></a>
                                    </td>
                                </tr>';
            }
            $email_vars['wpf-task-completed-today'] = $completed_posts_html;
            wp_reset_postdata();

            break;
    }

    $wpf_powered_by = get_option('wpf_powered_by');
    if($wpf_powered_by=='yes'){
        $wpf_color = get_option('wpf_color');
        $body = str_replace('#002157', '#'.$wpf_color, $body);
        $body = wpf_remove_powered_from_email(array('wpf_powered_by_table'),$body);
    }
    foreach ($email_vars as $key => $value) {
        $temp_key = '{' . $key . '}';
        $body = str_replace($temp_key, $email_vars[$key], $body);
    }

    $temp_emails = explode(',', $wpf_more_emails);
    $send_to_emails_arr = array_merge($send_to_emails_arr, $temp_emails);
    $send_to_emails_arr = array_filter(array_unique($send_to_emails_arr));

    $wpf_from_email = get_option('wpf_from_email');
    if($wpf_from_email==''){
        $wpf_from_email = get_option('admin_email');
    }

    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: WP Feedback <'.$wpf_from_email.'>';

    $to = $send_to_emails_arr[0];
    unset($send_to_emails_arr[0]);

    foreach ($send_to_emails_arr as $to_email) {
        $headers[] = 'Bcc: ' . $to_email;
    }
    $subject = stripslashes(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
    wp_mail($to, $subject, $body, $headers);
}

function wpf_send_email_report()
{
    $type = $_REQUEST['type'];
    $forced = $_REQUEST['forced'];

    if ($type == 'weekly_report') {
        $wpf_weekly_report = get_option('wpf_weekly_report');
        if ($wpf_weekly_report != 'yes') {
            echo 1;
            exit;
        }
    } else {
        $wpf_daily_report = get_option('wpf_daily_report');
        if ($wpf_daily_report != 'yes') {
            echo 1;
            exit;
        }
    }

    /*if ($type == 'weekly_report') {
        $to_day = date('D');
        if ($to_day == 'Fri') {
        } else {
            echo 1;
            exit;
        }
    }*/
    $email_vars['wpf-website-name'] = get_bloginfo('name');
    $email_vars['wpf-powered-by'] = 'https://wpfeedback.co/powered/?from=' . $email_vars['wpf-website-name'];
    $notif_user_emails = array();

    if ($type == 'daily_report') {
        $subject = 'Your tasks summary for the day for ' . $email_vars['wpf-website-name'];
        $args_today = array(
            'post_type' => 'wpfeedback',
            'post_status' => 'publish',
            'date_query' => array(
                'column' => 'post_date',
                'after' => '- 1 days'
            )
        );
        $args_completed = array(
            'post_type' => 'wpfeedback',
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'task_status',
                    'field' => 'slug',
                    'terms' => array('complete')
                )
            ),
            'date_query' => array(
                'column' => 'post_date',
                'after' => '- 1 days'
            )
        );
    } else {
        $subject = 'Weekly Report for ' . $email_vars['wpf-website-name'];
        $args_today = array(
            'post_type' => 'wpfeedback',
            'post_status' => 'publish',
            'date_query' => array(
                'column' => 'post_date',
                'after' => '- 7 days'
            )
        );
        $args_completed = array(
            'post_type' => 'wpfeedback',
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'task_status',
                    'field' => 'slug',
                    'terms' => array('complete')
                )
            ),
            'date_query' => array(
                'column' => 'post_date',
                'after' => '- 7 days'
            )
        );
    }

    $todays_posts = get_posts($args_today);
    $completed_posts = get_posts($args_completed);

    foreach ($todays_posts as $todays_post) {
        $temp_task_id = $todays_post->ID;
        $temp_task_priority = get_the_terms($temp_task_id, 'task_priority');
        $temp_task_status = get_the_terms($temp_task_id, 'task_status');
        $temp_task_priority = $temp_task_priority[0]->name;
        $temp_task_status = $temp_task_status[0]->name;
        $temp_task_page = get_post_meta($temp_task_id, 'task_page_title', true);
        $task_page_url = get_post_meta($temp_task_id, 'task_page_url', true);
        $task_comment_id = get_post_meta($temp_task_id, 'task_comment_id', true);
        $task_reply_url = $task_page_url . '?wpf_taskid=' . $task_comment_id;

        $todays_posts_html = '<tr class="kmTableRow">
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;width:45%;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $todays_post->post_title . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;width:20%;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $temp_task_page . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $temp_task_priority . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $temp_task_status . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;border-right:none;text-align:left;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        <a href="' . $task_reply_url . '"
                                           style="word-wrap:break-word;max-width:100%;color:#15C;font-weight:normal;text-decoration:underline"><strong>Open</strong></a>
                                    </td>
                                </tr>';

        $post_notif_user_str = get_post_meta($todays_post->ID, 'task_notify_users', true);
        $post_notif_users_arr = explode(',', $post_notif_user_str);
        foreach ($post_notif_users_arr as $post_notif_users) {
            $notif_user_emails[$post_notif_users]['todays_notify'][] = $todays_post->ID;
            $notif_user_emails[$post_notif_users]['todays_html'][] = $todays_posts_html;
        }
    }

    foreach ($completed_posts as $completed_post) {
        $temp_task_id = $completed_post->ID;
        $temp_task_priority = get_the_terms($temp_task_id, 'task_priority');
        $temp_task_status = get_the_terms($temp_task_id, 'task_status');
        $temp_task_priority = $temp_task_priority[0]->name;
        $temp_task_status = $temp_task_status[0]->name;
        $temp_task_page = get_post_meta($temp_task_id, 'task_page_title', true);
        $task_page_url = get_post_meta($temp_task_id, 'task_page_url', true);
        $task_comment_id = get_post_meta($temp_task_id, 'task_comment_id', true);
        $task_reply_url = $task_page_url . '?wpf_taskid=' . $task_comment_id;

        $completed_posts_html = '<tr class="kmTableRow">
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;width:45%;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $completed_post->post_title . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;width:20%;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $temp_task_page . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $temp_task_priority . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;text-align:left;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        ' . $temp_task_status . '
                                    </td>
                                    <td valign="top" class="kmTextContent"
                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;border-right:none;text-align:left;font-size:12px;;border-top-style:solid;padding-bottom:4px;padding-right:0px;padding-left:0px;padding-top:4px;border-top-color:#DEE2E6;border-top-width:1px;">
                                        <a href="' . $task_reply_url . '"
                                           style="word-wrap:break-word;max-width:100%;color:#15C;font-weight:normal;text-decoration:underline"><strong>Open</strong></a>
                                    </td>
                                </tr>';

        $post_notif_user_str = get_post_meta($completed_post->ID, 'task_notify_users', true);
        $post_notif_users_arr = explode(',', $post_notif_user_str);
        foreach ($post_notif_users_arr as $post_notif_users) {
            $notif_user_emails[$post_notif_users]['completed_notify'][] = $completed_post->ID;
            $notif_user_emails[$post_notif_users]['completed_html'][] = $completed_posts_html;
        }
    }

    foreach ($notif_user_emails as $key => $notif_user) {
        if ($type == 'daily_report') {
            $body = file_get_contents(WPF_PLUGIN_DIR . 'inc/email_templates/Your_task_summary_for_the_day.html');
        } else {
            $body = file_get_contents(WPF_PLUGIN_DIR . 'inc/email_templates/Weekly_report.html');
        }
        $user_info = get_userdata($key);
        $todays_posts_html = implode('', $notif_user['todays_html']);
        $completed_posts_html = implode('', $notif_user['completed_html']);

        $email_vars['wpf-task-added'] = $todays_posts_html;
        $email_vars['wpf-task-completed'] = $completed_posts_html;

        $wpf_powered_by = get_option('wpf_powered_by');
        if($wpf_powered_by=='yes'){
            $wpf_color = get_option('wpf_color');
            $body = str_replace('#002157', '#'.$wpf_color, $body);
            $body = wpf_remove_powered_from_email(array('wpf_powered_by_table'),$body);
        }
        foreach ($email_vars as $key => $value) {
            $temp_key = '{' . $key . '}';
            $body = str_replace($temp_key, $email_vars[$key], $body);
        }

        $wpf_from_email = get_option('wpf_from_email');
        if($wpf_from_email==''){
            $wpf_from_email = get_option('admin_email');
        }

        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'From: WP Feedback <'.$wpf_from_email.'>';

        if ($type == 'daily_report') {
            // $add_user = get_user_meta($user_info->ID, 'wpf_daily_report', true);
            $add_user = get_user_meta($user_info->ID, 'wpf_auto_daily_report', true);
        }
        else{
            // $add_user = get_user_meta($user_info->ID, 'wpf_weekly_report', true);
            $add_user = get_user_meta($user_info->ID, 'wpf_auto_weekly_report', true);
        }
        if($add_user=='yes' || $forced=='yes'){
            $to = $user_info->user_email;
            $subject = stripslashes(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
            wp_mail($to, $subject, $body, $headers);
        }
    }
    exit;
}
add_action('wp_ajax_wpf_send_email_report','wpf_send_email_report');
add_action('wp_ajax_nopriv_wpf_send_email_report','wpf_send_email_report');

function wpf_remove_powered_from_email($array_of_id_or_class, $text)
{
    $name = implode('|', $array_of_id_or_class);
    $regex = '#<(\w+)\s[^>]*(class|id)\s*=\s*[\'"](' . $name .
        ')[\'"][^>]*>.*</\\1>#isU';
    return(preg_replace($regex, '', $text));
}