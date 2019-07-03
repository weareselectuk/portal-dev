<?php

if (!defined('ABSPATH')) {
    exit;
}

class EH_CRM_Cron_Setup {
    protected $triggers_schedule = array();
    function __construct() {
        add_action('init', array($this, 'crawler_schedule_init'));
        add_filter('cron_schedules', array($this, 'crawler_schedule_time'));
        add_action('crm_email_crawler', array($this, 'start_crm_email_crawler'));
        wp_schedule_single_event(time()+1,'start_scheduled_trigger_cron' );
        add_action( 'start_scheduled_trigger_cron', array($this, 'start_trigger_schedule') );
        $wsdesk_pack = get_option("wsdesk_pack");
        if(!empty($wsdesk_pack))
        {
            $trigger = eh_crm_get_settings(array("type" => "trigger"),array("slug","title","settings_id"));
            if($trigger == false)
            {
                $trigger = array();
            }
            $selected_triggers = eh_crm_get_settingsmeta(0, "selected_triggers");
            if(empty($selected_triggers))
            {
                $selected_triggers = array();
            }
            for($i=0;$i<count($trigger);$i++)
            {
                if(in_array($trigger[$i]['slug'],$selected_triggers))
                {
                    $trigger_meta = eh_crm_get_settingsmeta($trigger[$i]['settings_id']);
                    if(isset($trigger_meta['trigger_schedule']) && $trigger_meta['trigger_schedule'] !== "" )
                    {
                        add_action($trigger[$i]['slug'], array($this, 'start_trigger_action_cron'));
                        $this->triggers_schedule[$trigger[$i]['slug']] = $this->get_unixtime($trigger_meta['trigger_schedule'],$trigger_meta['trigger_period']);
                    }
                }
            }
        }
    }
    
    function get_unixtime($type,$period) {
        $val = 0;
        $min = 60;
        $hour = 3600;
        $day = 86400;
        $week = 604800;
        $month = 4.34524;
        $year = 52.1429;
        switch ($type) {
            case "min":
                $val = $min;
                break;
            case "hour":
                $val = $hour;
                break;
            case "day":
                $val = $day;
                break;
            case "week":
                $val = $week;
                break;
            case "month":
                $val = $month * $week;
                break;
            case "year":
                $val = $year * $week;
                break;
            default:
                break;
        }
        return ($val*$period);
    }
    
    function crawler_schedule_time($schedules) {
        $schedules['crm_crawler_interval'] = array(
            'interval' => 60,
            'display' => "Every 60 Seconds"
        );
        foreach ($this->triggers_schedule as $key => $value) {
            $schedules[$key] = array(
                'interval' => $value,
                'display' => "Every ".$value." Seconds"
            );
        }
        return $schedules;
    }

    
    function crawler_schedule_init() {
        if (!wp_next_scheduled('crm_email_crawler')) {
            wp_schedule_event(time(), 'crm_crawler_interval', 'crm_email_crawler');
        }
        foreach ($this->triggers_schedule as $key => $value) {
            if (!wp_next_scheduled($key)) {
                wp_schedule_event(time(),$key,$key);
            }
        }
    }
    
    function start_trigger_action_cron() {
        $trigger = current_action();
        $ticket_ids = eh_crm_get_trigger_tickets($trigger);
        /*eh_crm_trigger_perform_action($trigger, $ticket_ids);
        for($i=0;$i<count($ticket_ids);$i++)
        {
            eh_crm_update_ticketmeta($ticket_ids[$i]['ticket_id'], "trigger_status", "triggered",FALSE);
            eh_crm_update_ticketmeta($ticket_ids[$i]['ticket_id'], "trigger_changes", "none",FALSE);
        }*/
    }
    
function start_trigger_schedule()
    {
        $scheduled_triggers_array = get_option('wsdesk_scheduled_triggers');
        if(!$scheduled_triggers_array)
        {
            $scheduled_triggers_array = array();
        }
        foreach ($scheduled_triggers_array as $key => $value)
        {
            if($value['triggered']=='no')
            {
                $trigger       = eh_crm_get_settings(array("slug"=>$value['trigger_slug'],"type"=>"trigger"),array("slug","settings_id","title"));
                $trigger_meta  = eh_crm_get_settingsmeta($trigger[0]['settings_id']);
                $duration = time()-$value['action_time'];
                $schedule = $this->get_unixtime($trigger_meta['trigger_schedule'],$trigger_meta['trigger_period']);
                if($duration>=$schedule)
                {
                    $ids = eh_crm_get_trigger_tickets($value['trigger_slug']);
                    for($j=0;$j<count($ids);$j++)
                    {
                        if($ids[$j]['ticket_id'] == $value['ticket_id'])
                        {
                            eh_crm_update_ticketmeta($value['ticket_id'], "trigger_status","updated",false);
                            eh_crm_trigger_perform_action($value['trigger_slug'],array(array("ticket_id"=>$value['ticket_id'])));
                            $scheduled_trigger = array(
                                'ticket_id'=>$value['ticket_id'],
                                'trigger_slug'=>$value['trigger_slug'],
                                'action_time'=> $value['action_time'],
                                'triggered'=>'yes'
                            );
                            $scheduled_triggers_array[$key] = $scheduled_trigger;
                            eh_crm_update_ticketmeta($value['ticket_id'], "trigger_status","triggered",false);
                        }
                    }
                }
            }
        }
        update_option('wsdesk_scheduled_triggers',$scheduled_triggers_array);
        wp_clear_scheduled_hook( 'start_scheduled_trigger_cron' );
        wp_schedule_single_event( time()+60,'start_scheduled_trigger_cron' );
    }
    
    function start_crm_email_crawler() {
        ini_set('max_execution_time', 60);
        if (eh_crm_get_settingsmeta(0, "oauth_activation") == "activated") {
            $oauth = new EH_CRM_OAuth();
            if ($oauth->refresh_accesstoken()) {
                $this->message_search();
            }
        }
        if (eh_crm_get_settingsmeta(0, "imap_activation") == "activated") {
            $this->email_imap();
        }
    }
    
    function email_imap() {
        $server_url = eh_crm_get_settingsmeta('0', "imap_server_url");
        $server_port = eh_crm_get_settingsmeta('0', "imap_server_port");
        $server_email = eh_crm_get_settingsmeta('0', "imap_server_email");
        $server_email_pwd = eh_crm_get_settingsmeta('0', "imap_server_email_pwd");
        $delete_email = eh_crm_get_settingsmeta('0', 'delete_email');
        $support_reply_email = eh_crm_get_settingsmeta('0', 'support_reply_email');
        $upload = wp_upload_dir();
        $mailbox = new EH_CRM_PhpImap\EH_CRM_Mailbox("{".$server_url.":".$server_port."/imap/ssl/novalidate-cert}INBOX", $server_email, $server_email_pwd, $upload['path']);
        if($server_url=='outlook.office365.com' || $server_url == 'imap-mail.outlook.com')
            $mailsIds = $mailbox->searchMailbox('UNSEEN','US-ASCII');
        else
            $mailsIds = $mailbox->searchMailbox('UNSEEN');
        if($mailsIds) {
            foreach ($mailsIds as $key => $value) {
                $mail = $mailbox->getMail($mailsIds[$key]);
                $mailbox->markMailsAsRead($mailsIds); 
                $message_data = array();
                $replyToEmail=array_keys($mail->replyTo);
                if(isset($replyToEmail[0]) && !empty($replyToEmail[0]))
                {
                    $message_data['email'] = $replyToEmail[0];
                }
                else
                {
                    $message_data['email'] = $mail->fromAddress;
                }
                $to = array_keys($mail->to);
                if(!in_array($support_reply_email, $to))
                {
                    $message_data['forwarded'] = $to;
                }
                $message_data['cc'] = array_keys($mail->cc);
                $message_data['bcc'] = array_keys($mail->bcc);
                $message_data['subject'] = $mail->subject;
                $array = explode("\n", $mail->textPlain);
                if(empty($mail->textPlain))
                {
                    $array = $mail->textHtml;
                    $replaced = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $array);
                    $replaced = preg_replace('/<((script)[^>]*)>(.*)\<\/(script)>/Us', '&lt;$1&gt;$3&lt;/script&gt;', $array);
					$replaced = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $replaced);
                    $replaced = preg_replace('/<((style)[^>]*)>(.*)\<\/(style)>/Us', '&lt;$1&gt;$3&lt;/style&gt;', $array);
                    $replaced = preg_replace('/<((form)[^>]*)>(.*)\<\/(form)>/Us', '&lt;$1&gt;$3&lt;/form&gt;', $array);
					$parsed = strip_tags($replaced,'<p><a><br/><div>');
                    $array = explode("\n", $parsed);
                }
                $content_output = array();
                $i=0;
                $remove =0;
                foreach ($array as $arr) {
                    if (!(preg_match('/^>/', $arr)) && !(preg_match('/^On Mon,|^On Tue,|^On Wed,|^On Thu,|^On Fri,|^On Sat,|^On Sun,|^wrote:|^On|^drive /', $arr))) {
                        array_push($content_output, $arr);
                    }
                    else
                    {
                        $remove = $i;
                    }
                    $i++;
                }
                if($remove != 0)
                {
                    unset($content_output[$remove-1]);
                }
                $content = implode("\n", $content_output);
                $message_data['content'] = preg_replace('/\n(\s*\n){2,}/', "\n\n", $content);
                $mail_attachments = $mail->getAttachments();
                $attachment = array();
                if (!empty($mail_attachments)) {
                    foreach ($mail_attachments as $single) {
                        $temp_array = array
                        (
                            'path' => $upload['path'] . '/' . $single->name,
                            'url' => $upload['url'] . '/' . $single->name
                        );
                        array_push($attachment, $temp_array);
                    }
                    $message_data['attachments'] = $attachment;
                }
                if(eh_crm_validate_subject_block($message_data['subject']))
                {
                    if(eh_crm_validate_email_block($message_data['email'], 'receive'))
                    {
                        $this->match_insert($message_data);
                    }
                }
                if($delete_email == 'yes')
                {
                    $mailbox->deleteMail($mailsIds[$key]);
                }
            }
        }
    }
    
    function message_search() {
        $access_token = eh_crm_get_settingsmeta(0, "oauth_accesstoken");
        $search = 'after:' . eh_crm_get_settingsmeta(0, 'oauth_last_requested') . ' before:' . time();
        $url = 'https://www.googleapis.com/gmail/v1/users/me/messages?q=in:inbox ' . $search;
        $url .= '&v=2';
        $url .= '&oauth_token=' . $access_token;
        $response = wp_safe_remote_get($url);
        if(!is_wp_error($response))
        {
            $result = $response['response'];
            if ($result['code'] == 200 && $result['message'] == 'OK') {
                eh_crm_update_settingsmeta(0, "oauth_last_requested", time());
                $body = json_decode($response['body']);
                if ($body->resultSizeEstimate != 0) {
                    foreach ($body->messages as $key=>$message) {
                        $message_url = 'https://www.googleapis.com/gmail/v1/users/me/messages/' . $message->id;
                        $constant_url = '?v=2&oauth_token=' . $access_token;
                        $request_url = $message_url . $constant_url;
                        $req_res = wp_safe_remote_get($request_url);
                        $message_body = json_decode($req_res['body']);
                        $payload = $message_body->payload;
                        $header = $payload->headers;
                        $message_data = array();
                        foreach ($header as $single) {
                            if ($single->name == 'From') {
                                preg_match('~<(.*?)>~', $single->value, $output);
                                if(!isset($message_data['email']))
                                    $message_data['email'] = $output[1];
                            }
                            if ($single->name == 'Reply-To') {
                                $message_data['email'] = $single->value;
                            }
                            if ($single->name == 'Subject') {
                                $message_data['subject'] = strip_tags($single->value);
                            }
                            if ($single->name == 'Cc') {
                                $cc_ex = explode(",", $single->value);
                                $cc = array();
                                foreach ($cc_ex as $cc_value) {
                                    preg_match('~<(.*?)>~', $cc_value, $output);
                                    $cc_email = $output[1];
                                    array_push($cc,$cc_email);
                                }
                                $message_data['cc'] = $cc;
                            }
                            if ($single->name == 'Bcc') {
                                $bcc_ex = explode(",", $single->value);
                                $bcc = array();
                                foreach ($bcc_ex as $bcc_value) {
                                    preg_match('~<(.*?)>~', $bcc_value, $output);
                                    $bcc_email = $output[1];
                                    array_push($bcc,$bcc_email);
                                }
                                $message_data['bcc'] = $bcc;
                            }
                        }
                        $parsed = $this->parts_parser($payload, $message->id);
                        $array = explode("\n", $parsed['content']);
                        $content_output = array();
                        $i=0;
                        $remove =0;
                        foreach ($array as $arr) {
                            if (!(preg_match('/^>/', $arr)) && !(preg_match('/^On Mon,|^On Tue,|^On Wed,|^On Thu,|^On Fri,|^On Sat,|^On Sun,|^wrote:|^On|^drive /', $arr))) {
                                array_push($content_output, $arr);
                            }
                            else
                            {
                                $remove = $i;
                            }
                            $i++;
                        }
                        if($remove != 0)
                        {
                            unset($content_output[$remove-1]);
                        }
                        $content = implode("\n", $content_output);
                        $message_data['content'] = preg_replace('/\n(\s*\n){2,}/', "\n\n", $content);
                        if (isset($parsed['attachments'])) {
                            $message_data['attachments'] = $parsed['attachments'];
                        }
                        if(eh_crm_validate_subject_block($message_data['subject']))
                        {
                            if(eh_crm_validate_email_block($message_data['email'], 'receive'))
                            {
                                $this->match_insert($message_data);
                            }
                        }
                    }
                }
            }
        }
    }
    
    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) 
        {
            return '';
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    
    function match_insert($data) {
        $ticket_id = 'new';
        $support_reply_email = eh_crm_get_settingsmeta('0', 'support_reply_email');
        $send = eh_crm_get_settingsmeta('0', "auto_send_creation_email");
        if (preg_match('/Ticket \[(.*?)\] :/', $data['subject'], $output) == 1 || preg_match('/Re: Ticket \[(.*?)\] :/', $data['subject'], $output) == 1) {
            $ticket_id = $output[1];
        }
        else if(strpos($data['subject'], 'Re: ') === 0 )
        {
           $ticket = eh_crm_get_ticket(array('ticket_title' => substr($data['subject'], 4)), array('ticket_email', 'ticket_id'));
           if(!empty($ticket))
           {
                $ticket_id = $ticket[0]['ticket_id'];
                if(in_array($ticket[0]['ticket_email'], $data['cc']))
                {
                    $index = array_search($ticket[0]['ticket_email'], $data['cc']);
                }
                else
                {
                    $index = array_search($support_reply_email, $data['cc']);
                }
                $data['cc'][$index] = $data['email'];
                $data['email'] = $ticket[0]['ticket_email'];
           }
        }
        if ($ticket_id != 'new') {
            $email_validate = eh_crm_get_ticket_value_count("ticket_email", $data['email'], false, "ticket_id", $ticket_id);
            if(empty($email_validate))
            {
                $cc_emails = eh_crm_get_ticketmeta($ticket_id, 'ticket_cc');
                if(in_array($data['email'], $cc_emails))
                {
                    $ticket = eh_crm_get_ticket(array('ticket_id'=>$ticket_id), 'ticket_email');
                    if(in_array($ticket[0]['ticket_email'], $data['cc']))
                    {
                        $index = array_search($ticket[0]['ticket_email'], $data['cc']);
                    }
                    else
                    {
                        $index = array_search($support_reply_email, $data['cc']);
                    }
                    $data['cc'][$index] = $data['email'];
                    $data['email'] = $ticket[0]['ticket_email'];
                    $email_validate = array('not_empty'=>1);
                }
                else
                {
                    $email_validate = array();
                }
            }
            if (!empty($email_validate)) {
                $parent = eh_crm_get_ticket(array("ticket_id" => $ticket_id));
                $user = get_user_by("email", $data['email']);
                $author = 0;
                if($user)
                {
                    $author = $user->ID;
                }
                $category = 'raiser_reply';
                $child = array(
                    'ticket_author' => $author,
                    'ticket_email' => $data['email'],
                    'ticket_title' => $parent[0]['ticket_title'],
                    'ticket_content' => eh_crm_filter_email_content(str_replace("\n", '<br/>', $data['content'])),
                    'ticket_category' => $category,
                    'ticket_parent' => $ticket_id,
                    'ticket_vendor' => $parent[0]['ticket_vendor']
                    );
                if (isset($data['attachments'])) {
                    $child_meta = array();
                    $attach_path = array();
                    $attach_url = array();
                    foreach ($data['attachments'] as $attach) {
                        array_push($attach_url, $attach['url']);
                        array_push($attach_path, $attach['path']);
                    }
                    $child_meta["ticket_attachment"] = $attach_url;
                    $child_meta["ticket_attachment_path"] = $attach_path;
                    eh_crm_insert_ticket($child, $child_meta);
                } else {
                    eh_crm_insert_ticket($child);
                }
                if(in_array($support_reply_email, $data['cc']))
                {
                    $index = array_search($support_reply_email, $data['cc']);
                    $data['cc'][$index] = $data['forwarded'][0];
                }
                eh_crm_update_ticketmeta($ticket_id, "ticket_cc", ((isset($data['cc']))?$data['cc']:array()),false);
                eh_crm_update_ticketmeta($ticket_id, "ticket_bcc", ((isset($data['bcc']))?$data['bcc']:array()),false);
                $ticket_label = eh_crm_get_ticketmeta($ticket_id, "ticket_label");
                $submit = eh_crm_get_settingsmeta('0', "default_label");
                if($ticket_label==$submit) //if label is same
                    eh_crm_update_ticketmeta($ticket_id, "ticket_label", $submit,false); 
                else
                    eh_crm_update_ticketmeta($ticket_id, "ticket_label", $submit); //false removed to let "change to" cause a trigger when pulling e-mail from imap
            }
            else
            {
                $user = get_user_by("email", $data['email']);
                $author = 0;
                if($user)
                {
                    $author = $user->ID;
                }
                $email = $data['email'];
                $title = $data['subject'];
                $desc = str_replace("\n", '<br/>', $data['content']);
                $args = array(
                    'ticket_author' => $author,
                    'ticket_email' => $email,
                    'ticket_title' => $title,
                    'ticket_content' => eh_crm_filter_email_content($desc),
                    'ticket_category' => 'raiser_reply',
                    'ticket_vendor' => ''
                );
                $meta = array();
                $req_args = array("type" => "tag");
                $fields = array("slug", "title", "settings_id");
                $avail_tags = eh_crm_get_settings($req_args, $fields);
                $tagged = array();
                if(!empty($avail_tags))
                {
                    for ($i = 0, $j = 0; $i < count($avail_tags); $i++) {
                        if (preg_match('/' . strtolower($avail_tags[$i]['title']) . '/', strtolower($desc)) || preg_match('/' . strtolower($avail_tags[$i]['title']) . '/', strtolower($title))) {
                            $tagged[$j] = $avail_tags[$i]['slug'];
                            $j++;
                        }
                    }
                }
                $meta['ticket_tags'] = $tagged;
                $default_assignee = eh_crm_get_settingsmeta('0', "default_assignee");
                $assignee = array();
                switch ($default_assignee) {
                    case "ticket_tags":
                        $users = get_users(array("role__in" => array("WSDesk_Agents", "WSDesk_Supervisor")));
                        $user_tags = array();
                        for ($i = 0; $i < count($users); $i++) {
                            $current = $users[$i];
                            $id = $current->ID;
                            $user_tags[$id] = get_user_meta($id, "wsdesk_tags", true);
                        }
                        foreach ($user_tags as $key => $value) {
                            for($i=0;$i<count($value);$i++)
                            {
                                if(in_array($value[$i], $tagged))
                                {
                                    array_push($assignee, $key);
                                    break;
                                }
                            }
                        }
                        break;
                    case "no_assignee":
                        break;
                    default:
                        array_push($assignee, $default_assignee);
                        break;
                }
                $meta['ticket_assignee'] = $assignee;
                $default_label = eh_crm_get_settingsmeta('0', "default_label");
                if(eh_crm_get_settings(array('slug'=>$default_label)))
                {
                    $meta['ticket_label'] = $default_label;
                }
                if (isset($data['attachments'])) {
                    $attach_path = array();
                    $attach_url = array();
                    foreach ($data['attachments'] as $attach) {
                        array_push($attach_url, $attach['url']);
                        array_push($attach_path, $attach['path']);
                    }
                    $meta["ticket_attachment"] = $attach_url;
                    $meta["ticket_attachment_path"] = $attach_path;
                }
                $meta["ticket_cc"] = (isset($data['cc']))?$data['cc']:array();
                $meta["ticket_bcc"] = (isset($data['bcc']))?$data['bcc']:array();
                $meta['ticket_source'] = "EMail";
                $gen_id = eh_crm_insert_ticket($args, $meta);
                if($send == 'enable')
                {
                    CRM_Ajax::eh_crm_fire_email("new_ticket", $gen_id);
                }
            }
        } else {
            $user = get_user_by("email", $data['email']);
            $author = 0;
            if($user)
            {
                $author = $user->ID;
            }
            $email = $data['email'];
            $title = $data['subject'];
            $desc = str_replace("\n", '<br/>', $data['content']);
            $args = array(
                'ticket_author' => $author,
                'ticket_email' => $email,
                'ticket_title' => $title,
                'ticket_content' => eh_crm_filter_email_content($desc),
                'ticket_category' => 'raiser_reply',
                'ticket_vendor' => ''
            );
            $meta = array();
            $req_args = array("type" => "tag");
            $fields = array("slug", "title", "settings_id");
            $avail_tags = eh_crm_get_settings($req_args, $fields);
            $tagged = array();
            if(!empty($avail_tags))
            {
                for ($i = 0, $j = 0; $i < count($avail_tags); $i++) {
                    if (preg_match('/' . strtolower($avail_tags[$i]['title']) . '/', strtolower($desc)) || preg_match('/' . strtolower($avail_tags[$i]['title']) . '/', strtolower($title))) {
                        $tagged[$j] = $avail_tags[$i]['slug'];
                        $j++;
                    }
                }
            }
            $meta['ticket_tags'] = $tagged;
            $default_assignee = eh_crm_get_settingsmeta('0', "default_assignee");
            $assignee = array();
            switch ($default_assignee) {
                case "ticket_tags":
                    $users = get_users(array("role__in" => array("WSDesk_Agents", "WSDesk_Supervisor")));
                    $user_tags = array();
                    for ($i = 0; $i < count($users); $i++) {
                        $current = $users[$i];
                        $id = $current->ID;
                        $user_tags[$id] = get_user_meta($id, "wsdesk_tags", true);
                    }
                    foreach ($user_tags as $key => $value) {
                        for($i=0;$i<count($value);$i++)
                        {
                            if(in_array($value[$i], $tagged))
                            {
                                array_push($assignee, $key);
                                break;
                            }
                        }
                    }
                    break;
                case "no_assignee":
                    break;
                default:
                    array_push($assignee, $default_assignee);
                    break;
            }
            $meta['ticket_assignee'] = $assignee;
            $default_label = eh_crm_get_settingsmeta('0', "default_label");
            if(eh_crm_get_settings(array('slug'=>$default_label)))
            {
                $meta['ticket_label'] = $default_label;
            }
            if (isset($data['attachments'])) {
                $attach_path = array();
                $attach_url = array();
                foreach ($data['attachments'] as $attach) {
                    array_push($attach_url, $attach['url']);
                    array_push($attach_path, $attach['path']);
                }
                $meta["ticket_attachment"] = $attach_url;
                $meta["ticket_attachment_path"] = $attach_path;
            }
            if(isset($data['forwarded']))
            {
                $meta["ticket_forwarded"] = $data['forwarded'];
            }
            $meta["ticket_cc"] = (isset($data['cc']))?$data['cc']:array();
            $meta["ticket_bcc"] = (isset($data['bcc']))?$data['bcc']:array();
            $meta['ticket_source'] = "EMail";
            $gen_id = eh_crm_insert_ticket($args, $meta);
            if($send == 'enable')
            {
                CRM_Ajax::eh_crm_fire_email("new_ticket", $gen_id);
            }
        }
    }
    
    function recursive_parts_parser($parts,$message_id,&$attachment,&$parsed)
    {   
        if(is_array($parts))
        {
            foreach ($parts as $main_part) {
                $mineTypeMultipart = explode('/',$main_part->mimeType);
                $multi_main_type = $mineTypeMultipart[0];
                $multi_sec_type = $mineTypeMultipart[1];
                switch ($multi_main_type) {
                    case 'text':
                        $part_body = $main_part->body;
                        switch ($multi_sec_type) {
                            case 'html':
                                if(!isset($parsed['content']))
                                {
                                    $decoded = $this->decodeBody($part_body->data);
                                    $replaced = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $decoded);
                                    $replaced = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $replaced);
                                    $parsed['content'] = strip_tags($replaced,'<p><a><br/><div>');
                                }
                                break;
                            case 'plain':
                                if(isset($part_body->attachmentId))
                                {
                                    $part_body = $main_part->body;
                                    $ext = pathinfo($main_part->filename, PATHINFO_EXTENSION);
                                    if (!in_array($ext, array('php', 'exe', 'sh', 'js'))) {
                                        array_push($attachment, $this->get_attachment($message_id, $part_body->attachmentId, $main_part->filename));
                                    }
                                }
                                else
                                {
                                    $parsed['content'] = $this->decodeBody($part_body->data);
                                }
                                break;
                            default:
                                $part_body = $main_part->body;
                                $ext = pathinfo($main_part->filename, PATHINFO_EXTENSION);
                                if (!in_array($ext, array('php', 'exe', 'sh', 'js'))) {
                                    array_push($attachment, $this->get_attachment($message_id, $part_body->attachmentId, $main_part->filename));
                                }
                                break;
                        }
                        break;
                    case 'multipart':
                        $this->recursive_parts_parser($main_part->parts, $message_id, $attachment, $parsed);
                        break;
                    case 'application':
                    case 'image':
                        $part_body = $main_part->body;
                        $ext = pathinfo($main_part->filename, PATHINFO_EXTENSION);
                        if (!in_array($ext, array('php', 'exe', 'sh', 'js'))) {
                            array_push($attachment, $this->get_attachment($message_id, $part_body->attachmentId, $main_part->filename));
                        }
                        break;
                }
            }
        }
        else
        {
            $mineTypeMultipart = explode('/',$parts->mimeType);
            $multi_main_type = $mineTypeMultipart[0];
            $multi_sec_type = $mineTypeMultipart[1];
            switch ($multi_main_type) {
                case 'text':
                    $part_body = $parts->body;
                    switch ($multi_sec_type) {
                        case 'html':
                            if(!isset($parsed['content']))
                            {
                                $decoded = $this->decodeBody($part_body->data);
                                $replaced = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $decoded);
                                $replaced = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $replaced);
                                $parsed['content'] = strip_tags($replaced,'<p><a><br/><div>');
                            }
                            break;
                        case 'plain':
                            if(isset($part_body->attachmentId))
                            {
                                $part_body = $parts->body;
                                $ext = pathinfo($parts->filename, PATHINFO_EXTENSION);
                                if (!in_array($ext, array('php', 'exe', 'sh', 'js'))) {
                                    array_push($attachment, $this->get_attachment($message_id, $part_body->attachmentId, $parts->filename));
                                }
                            }
                            else
                            {
                                $parsed['content'] = $this->decodeBody($part_body->data);
                            }
                            break;
                        default:
                            $part_body = $parts->body;
                            $ext = pathinfo($parts->filename, PATHINFO_EXTENSION);
                            if (!in_array($ext, array('php', 'exe', 'sh', 'js'))) {
                                array_push($attachment, $this->get_attachment($message_id, $part_body->attachmentId, $parts->filename));
                            }
                            break;
                    }
                    break;
                case 'multipart':
                    $this->recursive_parts_parser($parts->parts, $message_id, $attachment, $parsed);
                    break;
                case 'application':
                case 'image':
                    $part_body = $parts->body;
                    $ext = pathinfo($parts->filename, PATHINFO_EXTENSION);
                    if (!in_array($ext, array('php', 'exe', 'sh', 'js'))) {
                        array_push($attachment, $this->get_attachment($message_id, $part_body->attachmentId, $parts->filename));
                    }
                    break;
            }
        }
    }
    
    function parts_parser($payload, $message_id) {
        $parsed = array();
        $attachment =array();
        $mineType = explode('/',$payload->mimeType);
        $main_type = $mineType[0];
        $sec_type = $mineType[1];
        switch ($main_type) {
            case 'text':
                $part_body = $payload->body;
                switch ($sec_type) {
                    case 'html':
                        if(!isset($parsed['content']))
                        {
                            $decoded = $this->decodeBody($part_body->data);
                            $replaced = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $decoded);
                            $replaced = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $replaced);
                            $parsed['content'] = strip_tags($replaced,'<p><a><br/><div>');
                        }
                        break;
                    case 'plain':
                        if(isset($part_body->attachmentId))
                        {
                            $part_body = $payload->body;
                            $ext = pathinfo($payload->filename, PATHINFO_EXTENSION);
                            if (!in_array($ext, array('php', 'exe', 'sh', 'js'))) {
                                array_push($attachment, $this->get_attachment($message_id, $part_body->attachmentId, $payload->filename));
                            }
                        }
                        else
                        {
                            $parsed['content'] = $this->decodeBody($part_body->data);
                        }
                        break;
                    default:
                        $part_body = $payload->body;
                        $ext = pathinfo($payload->filename, PATHINFO_EXTENSION);
                        if (!in_array($ext, array('php', 'exe', 'sh', 'js'))) {
                            array_push($attachment, $this->get_attachment($message_id, $part_body->attachmentId, $payload->filename));
                        }
                        break;
                }
                break;
            case 'multipart':
                $this->recursive_parts_parser($payload->parts, $message_id, $attachment, $parsed);
                break;
            case 'application':
            case 'image':
                $part_body = $payload->body;
                $ext = pathinfo($payload->filename, PATHINFO_EXTENSION);
                if (!in_array($ext, array('php', 'exe', 'sh', 'js'))) {
                    array_push($attachment, $this->get_attachment($message_id, $part_body->attachmentId, $payload->filename));
                }
                break;
        }
        if(!empty($attachment))
        {
            $parsed['attachments'] = $attachment;
        }
        return $parsed;
    }

    function get_attachment($message_id, $attachment_id, $filename) {
        $access_token = eh_crm_get_settingsmeta(0, "oauth_accesstoken");
        $message_url = 'https://www.googleapis.com/gmail/v1/users/me/messages/' . $message_id;
        $constant_url = '?v=2&oauth_token=' . $access_token;
        $request_url = $message_url . '/attachments/' . $attachment_id . $constant_url;
        $attdata = json_decode(file_get_contents($request_url));
        $attachment = $this->decodeBody($attdata->data);
        $upload = wp_upload_dir();
        $file = time() . '_' . $filename;
        $file_name = $upload['path'] . '/' . $file;
        $ifp = fopen($file_name, "w");
        fwrite($ifp, $attachment);
        fclose($ifp);
        $data = array
            (
            'path' => $upload['path'] . '/' . $file,
            'url' => $upload['url'] . '/' . $file
        );
        return $data;
    }

    function decodeBody($body) {
        $rawData = $body;
        $sanitizedData = strtr($rawData, '-_', '+/');
        $decodedMessage = base64_decode($sanitizedData);
        if (!$decodedMessage) {
            $decodedMessage = FALSE;
        }
        return $decodedMessage;
    }

    function crawler_schedule_terminate() {
        wp_clear_scheduled_hook('crm_email_crawler');
        $trigger = eh_crm_get_settings(array("type" => "trigger"),array("slug","title","settings_id"));
        if($trigger == false)
        {
            $trigger = array();
        }
        $selected_triggers = eh_crm_get_settingsmeta(0, "selected_triggers");
        if(empty($selected_triggers))
        {
            $selected_triggers = array();
        }
        for($i=0;$i<count($trigger);$i++)
        {
            if(in_array($trigger[$i]['slug'],$selected_triggers))
            {
                $trigger_meta = eh_crm_get_settingsmeta($trigger[$i]['settings_id']);
                if(isset($trigger_meta['trigger_schedule']) && $trigger_meta['trigger_schedule'] !== "" )
                {
                    wp_clear_scheduled_hook($trigger[$i]['slug']);
                }
            }
        }
    }
    
}
