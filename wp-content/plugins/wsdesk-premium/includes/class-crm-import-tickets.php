<?php
class EH_CRM_Import_Tickets{
    protected $user_id;
    protected $plan;
    function zendesk_get_ticket($page,$attachment,$plan)
    {
        $this->plan=$plan;
        eh_crm_write_log("Start Fetching");
        include(EH_CRM_MAIN_VENDOR."zendesk/autoload.php");
        $subdomain = eh_crm_get_settingsmeta(0, "zendesk_subdomain");
        $username  = eh_crm_get_settingsmeta(0, "zendesk_username");
        $token     = eh_crm_get_settingsmeta(0, "zendesk_accesstoken");
        $client = new Zendesk\API\HttpClient($subdomain);
        $client->setAuth('basic', array('username' => $username, 'token' => $token));
        $next_page = 0;
        $total = 0;
        try
        {
            ini_set("max_execution_time",300);
            $fields = $client->ticketFields()->findAll();
            eh_crm_write_log("Fields Fetching");
            $fields_data = array();
            foreach ($fields->ticket_fields as $field) {
                $fields_data[$field->id] = $field->title;
            }
            $tickets = $client->tickets()->findAll(array('page' => $page));
            eh_crm_write_log("Tickets Fetching");
            if($tickets->next_page!=NULL)
            {
                $next_page = $this->zendesk_parse_url($tickets->next_page);
            }
            else
            {
                $next_page = 0;
            }
            $total = $tickets->count;
            $tt=1;
            foreach ($tickets->tickets as $ticket) {
                if(eh_crm_get_settingsmeta(0, "zendesk_tickets_import") === "started")
                {
                    ini_set("max_execution_time",300);
                    $data = array();
                    $id = $ticket->id;
                    $data['ticket_title'] = $ticket->subject;
                    $data['ticket_content'] = str_replace("\n",'<br/>',str_replace("\t", "",str_replace("\r", "", $ticket->description)));
                    $data['ticket_parent'] = 0;
                    $data['ticket_category'] = "raiser_reply";
                    $date = strtotime(str_replace("Z","",str_replace("T", " ", $ticket->created_at)));
                    $data['ticket_date'] = gmdate("M d, Y h:i:s A",$date);
                    $requester_id = $ticket->requester_id;
                    $data['ticket_email'] = $this->zendesk_user_email($client, $requester_id);
                    $data['ticket_author'] = $this->zendesk_user_id($data['ticket_email']);
                    $tags = $ticket->tags;
                    foreach ($tags as $key => $tag) {
                        $tags[$key] = ucwords(str_replace("_", " ", $tag));
                    }
                    $custom_fields = $ticket->custom_fields;
                    $custom = array();
                    foreach ($custom_fields as $custom_field) {
                        array_push($custom, $fields_data[$custom_field->id]." : ".ucwords(str_replace("_", " ", $custom_field->value)));
                    }
                    $data['ticket_content'].="<br/><br/>Zendesk Fields:<br> Tags:".(!empty($tags)?implode(",", $tags):"No Tags");
                    $data['ticket_content'].="<br/>".(!empty($custom)?implode("<br/>", $custom):"");
                    $data_meta = array();
                    switch ($ticket->status) {
                        case "closed":
                        case "solved":
                            $data_meta['ticket_label'] = "label_LL02";
                            break;
                        case "open":
                            $data_meta['ticket_label'] = "label_LL01";
                            break;
                        case "pending":
                            $data_meta['ticket_label'] = "label_LL03";
                            break;
                    }
                    $req_args = array("type" => "tag");
                    $fields = array("slug", "title", "settings_id");
                    $avail_tags = eh_crm_get_settings($req_args, $fields);
                    $tagged = array();
                    if(!empty($avail_tags))
                    {
                        for ($i = 0, $j = 0; $i < count($avail_tags); $i++) {
                            if (preg_match('/' . strtolower($avail_tags[$i]['title']) . '/', strtolower($data['ticket_title'])) || preg_match('/' . strtolower($avail_tags[$i]['title']) . '/', strtolower($data['ticket_content']))) {
                                $tagged[$j] = $avail_tags[$i]['slug'];
                                $j++;
                            }
                        }
                    }
                    $data_meta['ticket_tags'] = $tagged;
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
                    $data_meta['ticket_assignee'] = $assignee;
                    $data_meta['ticket_source'] = "Zendesk";
                    $gen_id = eh_crm_insert_ticket($data,$data_meta,TRUE);
                    $tt++;
                    $comments_next = 1;
                    $cc=0;
                    $upload = wp_upload_dir();
                    do
                    {
                        $comments = $this->zendesk_get_comments($client,$comments_next, $id);
                        if($cc==0)
                        {
                            if($attachment == "yes")
                            {
                                $attachments_data = array();
                                $first = $comments->comments[0];
                                $attach = $first->attachments;
                                foreach ($attach as $att) {
                                    $response = wp_remote_get($att->content_url,array("timeout"=>300));
                                    $body = $response['body'];
                                    $file = time().'_'.$att->file_name;
                                    $filepath = $upload['path']."/".$file;
                                    $fileurl = $upload['url']."/".$file;
                                    $fp = fopen($filepath, "w");
                                    fwrite($fp, $body);
                                    fclose($fp);
                                    $temp_array = array
                                    (
                                        'path' => $filepath,
                                        'url' => $fileurl
                                    );
                                    array_push($attachments_data, $temp_array);
                                }
                                $attach_path = array();
                                $attach_url = array();
                                foreach ($attachments_data as $attach) {
                                    array_push($attach_url, $attach['url']);
                                    array_push($attach_path, $attach['path']);
                                }
                                if(!empty($attach_path) && !empty($attach_url))
                                {
                                    eh_crm_update_settingsmeta($gen_id, "ticket_attachment", $attach_url);
                                    eh_crm_update_settingsmeta($gen_id, "ticket_attachment_path", $attach_path);
                                }
                            }
                            unset($comments->comments[0]);
                        }
                        foreach ($comments->comments as $comment) {
                            $cc_data = array();
                            $cc_data['ticket_title'] = $ticket->subject;
                            $cc_data['ticket_content'] = str_replace("\n",'<br/>',str_replace("\t", "",str_replace("\r", "", $comment->plain_body)));
                            $cc_data['ticket_parent'] = $gen_id;
                            $cc_date = strtotime(str_replace("Z","",str_replace("T", " ", $comment->created_at)));
                            $cc_data['ticket_date'] = gmdate("M d, Y h:i:s A",$cc_date);
                            $author_id = $comment->author_id;
                            if($requester_id == $author_id)
                            {
                                $cc_data['ticket_category'] = "raiser_reply";
                            }
                            else
                            {
                                $cc_data['ticket_category'] = "agent_reply";
                            }
                            $cc_data['ticket_email'] = $this->zendesk_user_email($client, $author_id);
                            $cc_data['ticket_author'] = $this->zendesk_user_id($cc_data['ticket_email']);
                            $cc_meta = array();
                            if($attachment == "yes")
                            {
                                $attachments_data = array();
                                $attach = $comment->attachments;
                                foreach ($attach as $att) {
                                    $response = wp_remote_get($att->content_url,array("timeout"=>300));
                                    $body = $response['body'];
                                    $file = time().'_'.$att->file_name;
                                    $filepath = $upload['path']."/".$file;
                                    $fileurl = $upload['url']."/".$file;
                                    $fp = fopen($filepath, "w");
                                    fwrite($fp, $body);
                                    fclose($fp);
                                    $temp_array = array
                                    (
                                        'path' => $filepath,
                                        'url' => $fileurl
                                    );
                                    array_push($attachments_data, $temp_array);
                                }
                                $attach_path = array();
                                $attach_url = array();
                                foreach ($attachments_data as $attach) {
                                    array_push($attach_url, $attach['url']);
                                    array_push($attach_path, $attach['path']);
                                }
                                $cc_meta["ticket_attachment"] = $attach_url;
                                $cc_meta["ticket_attachment_path"] = $attach_path;
                            }
                            eh_crm_insert_ticket($cc_data, $cc_meta,TRUE);
                        }
                        if($comments->next_page!=NULL)
                        {
                            $comments_next = $this->zendesk_parse_url($comments->next_page);
                        }
                        else
                        {
                            $comments_next = 0;
                        }
                    } while ($comments_next!=0);
                    eh_crm_write_log((($next_page-2)*100) + $tt." Tickets Inserted");
                }
                else
                {
                    return array("status"=>"failure","message"=>"User Aborted the Import");
                }
            }
            return array("status"=>"success","next"=>$next_page,"total"=>$total,"finished"=>$tt);
        } catch (\Zendesk\API\Exceptions\ApiResponseException $e) {
            return array("status"=>"failure","message"=>$e->getMessage());
        }
        
    }
    
    function zendesk_get_comments($client,$page,$ticket) {
        $comments = $client->tickets($ticket)->comments()->findAll(array('page' => $page));
        eh_crm_write_log("Comments Fetching");
        return $comments;
    }
    
    function zendesk_parse_url($url) {
        $parts = parse_url($url);
        parse_str($parts['query'], $query);
        return $query['page'];
    }
    
    function zendesk_user_email($client,$requester_id) {
        $email = "";
        if(!isset($this->user_id[$requester_id]))
        {
            switch ($this->plan) {
                case "essential":
                    sleep(20);
                    break;
                case "team":
                    sleep(5);
                    break;
                default:
                    break;
            }
            $requester = $client->users()->findMany(array("ids"=>array($requester_id)));
            eh_crm_write_log("User EMail Fetching");
            foreach ($requester->users as $user) {
                $email = $user->email;
            }
            $this->user_id[$requester_id]=$email;
            return $email;
        }
        else
        {
            return $this->user_id[$requester_id];
        }
    }
    
    function zendesk_user_id($email) {
        $user = get_user_by('email', $email);
        if($user)
        {
            return $user->ID;
        }
        else
        {
            return 0;
        }
    }
}