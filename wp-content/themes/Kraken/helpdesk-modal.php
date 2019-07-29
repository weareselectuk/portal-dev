<?php
/*
$ticketData = eh_crm_get_ticket_data($value->ticket_id);
$meta = eh_crm_get_ticketmeta($value->ticket_id);
$ticketData2 = eh_crm_get_ticket_data_with_note(2);
$ticket_tags = array();
$avail_tags_wf = eh_crm_get_settings(array("type" => "tag"), array("slug", "title", "settings_id"));*/
$ticket = $value->ticket_id;
ob_start();
$ticket = $value->ticket_id;
$search_page=(isset($_POST['cur']))?$_POST['cur']:1;
$active = isset($_POST['active'])?$_POST['active']:'all';
$order = isset($_POST['order'])?$_POST['order']:'DESC';
$order_by = isset($_POST['order_by'])?$_POST['order_by']:'ticket_updated';
$current_page_no = (isset($_POST['current_page']))?$_POST['current_page']:0;
$current_page_n = (isset($_POST['current_pa']))?$_POST['current_pa']:"$search_page";
$pagination = isset($_POST['pagination_type'])?$_POST['pagination_type']:'';
$avail_labels_wf = eh_crm_get_settings(array("type" => "label"), array("slug", "title", "settings_id"));
$avail_labels =eh_crm_get_settings(array("type" => "label", "filter" => "yes"), array("slug", "title", "settings_id"));
$avail_tags_wf = eh_crm_get_settings(array("type" => "tag"), array("slug", "title", "settings_id"));
$avail_tags = eh_crm_get_settings(array("type" => "tag", "filter" => "yes"), array("slug", "title", "settings_id"));
$avail_views = eh_crm_get_settings(array("type" => "view"), array("slug", "title", "settings_id"));
$user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
$clients = eh_crm_get_clients(array());
$client_value = '';
for($j=0;$j<count($clients);$j++)
{
    
        $client_value .= '<li id="'.$ticket.'"><a href="#" class="single_ticket_client" id="'.$clients[$j]['ID'].'">'.__("Mark as", 'wsdesk').' '.$clients[$j]['post_title'].'</a></li>';

} 
$users = get_users(array("role__in" => $user_roles_default));
$users_data = array();
$tickets_display = eh_crm_get_settingsmeta('0', "tickets_display");
for ($i = 0; $i < count($users); $i++) {
    $current = $users[$i];
    $id = $current->ID;
    $user = new WP_User($id);
    $users_data[$i]['id'] = $id;
    $users_data[$i]['name'] = $user->display_name;
    $users_data[$i]['caps'] = $user->caps;
    $users_data[$i]['email'] = $user->user_email;
}
$ticket_rows = eh_crm_get_settingsmeta(0, "ticket_rows");
 if($ticket_rows=="")
{
    $ticket_rows=25;
}
$current_page=$current_page_no;
$offset = ($current_page)* $ticket_rows; 
if($pagination != "")
{
    switch ($pagination) {
        case "current_page_n":
            if($current_page_n!="")
            {
                $current_page_n=$current_page_n-1;
                $total=count(eh_crm_get_ticket_value_count("ticket_parent",0));
                if($ticket_rows%2==0)
                {
                    if($current_page_n<=($total/$ticket_rows)-1)
                        {
                
                            $current_pa=$current_page_n*$ticket_rows;
                            $current_page=$current_page_n;
                            $offset=$current_pa;
                    

                            }
                    else
                    {
                        $last_page=($total/$ticket_rows);
                        if(is_float($last_page))
                        {
                            $last_page=$last_page+1;
                        }
                
                        $current_page=intval($last_page);
                        $current_page=$current_page-1;
                    
                        $offset=($current_page)*$ticket_rows;
                        break;
                        }
                }
                if($ticket_rows%2!=0)
                {
                    if($current_page_n<=intval($total/$ticket_rows)-1)
                        {
                            $current_pa=$current_page_n*$ticket_rows;
                            $current_page=$current_page_n;
                            $offset=$current_pa;
                        }
                    else
                    {
                        $last_page=$total/$ticket_rows;
                        $current_page=intval($last_page);
                        $current_page=$current_page;
                        $offset=($current_page)*$ticket_rows;
                        break;
                    }
                }
            }
            else
            {
               
                $offset=$current_page*$ticket_rows;
                $current_page=$current_page_no;
            }
                break;
        case "prev":
                $current_page = $current_page_no-1;
                $offset = ($current_page * $ticket_rows);
                break;
        case "next":

                $current_page = $current_page_no+1;
                $offset =($current_page * $ticket_rows);
                break;
    }
}

switch ($active) {
    case "all":
        $table_title = __("All Tickets", 'wsdesk');
        $total_count = count(eh_crm_get_ticket_value_count("ticket_parent",0));
        $section_tickets_id = eh_crm_get_ticket_value_count("ticket_parent",0,false,"","",$order_by,$order,$ticket_rows,$offset);
        $all_section_ids = eh_crm_get_ticket_value_count("ticket_parent",0,false,"","",$order_by,$order,"",0);
        break;
    case "registeredU":
        $table_title = __('Registered Users Tickets', 'wsdesk');
        $total_count = count(eh_crm_get_ticket_value_count("ticket_author",0,TRUE,"ticket_parent",0));
        $section_tickets_id = eh_crm_get_ticket_value_count("ticket_author",0,TRUE,"ticket_parent",0,$order_by,$order,$ticket_rows,$offset);
        $all_section_ids = eh_crm_get_ticket_value_count("ticket_author",0,TRUE,"ticket_parent",0,$order_by,$order,"",0);
        break;
    case "guestU":
        $table_title = __('Guest Users Tickets', 'wsdesk');
        $total_count = count(eh_crm_get_ticket_value_count("ticket_author",0,FALSE,"ticket_parent",0));
        $section_tickets_id = eh_crm_get_ticket_value_count("ticket_author",0,false,"ticket_parent",0,$order_by,$order,$ticket_rows,$offset);
        $all_section_ids = eh_crm_get_ticket_value_count("ticket_author",0,false,"ticket_parent",0,$order_by,$order,"",0);
        break;
    case "unassigned":
        $table_title = __('Unassigned Tickets', 'wsdesk');
        $total_count = count(eh_crm_get_ticketmeta_value_count("ticket_assignee",array(),"ticket_id"));
        $section_tickets_id = eh_crm_get_ticketmeta_value_count("ticket_assignee",array(),$order_by,$order,$ticket_rows,$offset);
        $all_section_ids = eh_crm_get_ticketmeta_value_count("ticket_assignee",array(),$order_by,$order,0,0);
        break;
    default:
        if (strpos($active, 'label_') !== false) 
        {
            for($i=0;$i<count($avail_labels);$i++)
            {
                if($avail_labels[$i]['slug'] == $active)
                {
                    $table_title = $avail_labels[$i]['title'];
                }
            }
            if(empty($table_title))
            {
                $table_title = "(Incorrect Deep Link)";
            }
            $table_title = $table_title . ' Tickets';
            $total_count = count(eh_crm_get_ticketmeta_value_count("ticket_label",$active,"ticket_id"));
            $section_tickets_id = eh_crm_get_ticketmeta_value_count("ticket_label",$active,$order_by,$order,$ticket_rows,$offset);
            $all_section_ids = eh_crm_get_ticketmeta_value_count("ticket_label",$active,$order_by,$order,0,0);
        } 
        elseif (strpos($active, 'tag_') !== false) 
        {
            for($i=0;$i<count($avail_tags);$i++)
            {
                if($avail_tags[$i]['slug'] == $active)
                {
                    $table_title = $avail_tags[$i]['title'];
                }
            }
            if(empty($table_title))
            {
                $table_title = "(Incorrect Deep Link)";
            }
            $table_title = $table_title . ' Tickets';
            $total_count = count(eh_crm_get_ticketmeta_value_count("ticket_tags",$active,"ticket_id"));
            $section_tickets_id = eh_crm_get_ticketmeta_value_count("ticket_tags",$active,$order_by,$order,$ticket_rows,$offset);
            $all_section_ids = eh_crm_get_ticketmeta_value_count("ticket_tags",$active,$order_by,$order,0,0);
        }
        elseif (strpos($active, 'view_') !== false) 
        {
            for($i=0;$i<count($avail_views);$i++)
            {
                if($avail_views[$i]['slug'] == $active)
                {
                    $table_title = $avail_views[$i]['title'];
                }
            }
            if(empty($table_title))
            {
                $table_title = "(Incorrect Deep Link)";
            }
            $table_title = $table_title . ' Tickets';
            $total_count = count(eh_crm_get_view_tickets($active));
            
            $section_tickets_id = eh_crm_get_view_tickets($active,$ticket_rows,$offset);
            $all_section_ids = eh_crm_get_view_tickets($active);
        }
        else 
        {
            for($i=0;$i<count($users_data);$i++)
            {
                if($users_data[$i]['id'] == $active)
                {
                    $table_title = $users_data[$i]['name'];
                }
            }
            if(empty($table_title))
            {
                $table_title = "(Incorrect Deep Link)";
            }
            $table_title = $table_title . ' Tickets';
            $total_count = count(eh_crm_get_ticketmeta_value_count("ticket_assignee",$active,"ticket_id"));
            $section_tickets_id = eh_crm_get_ticketmeta_value_count("ticket_assignee",$active,$order_by,$order,$ticket_rows,$offset);
            $all_section_ids = eh_crm_get_ticketmeta_value_count("ticket_assignee",$active,$order_by,$order,0,0);
        }
        break;
}
$avail_caps = array("reply_tickets","delete_tickets","manage_tickets");
$access = array();
$logged_user = wp_get_current_user();
$logged_user_caps = array_keys($logged_user->caps);
if(!in_array("administrator", $logged_user->roles))
{
    for($i=0;$i<count($logged_user_caps);$i++)
    {
        if(!in_array($logged_user_caps[$i], $avail_caps))
        {
            unset($logged_user_caps[$i]);
        }
    }
    $access = $logged_user_caps;
}
else
{
    $access = $avail_caps;
}
$pagination_ids = array();
foreach ($all_section_ids as $tic) {
    array_push($pagination_ids,$tic['ticket_id']);
}
$all_ticket_field_views = eh_crm_get_settingsmeta("0", "all_ticket_page_columns");
$custom_table_headers = array();
$default_columns = array('id', 'requestor', 'subject', 'requested', 'assignee', 'feedback');
if($all_ticket_field_views ===  false)
{
    $all_ticket_field_views =  $default_columns;
    eh_crm_update_settingsmeta("0", "all_ticket_page_columns", $default_columns);
}
if(!empty($all_ticket_field_views))
{
    foreach ($all_ticket_field_views as  $all_ticket_field) {
        if(in_array($all_ticket_field, $default_columns))
        {
            switch($all_ticket_field)
            {
                case 'id':
                    if($order_by == 'ticket_id')
                    {
                        if($order == 'ASC')
                        {
                             array_push($custom_table_headers, '<div class="row" style="margin-left: 0px; ">#'.'<span class="dashicons dashicons-arrow-up sort-icon" id="id" style="margin-left: 5px;"></span></div>');
                        }
                        else
                        {
                             array_push($custom_table_headers, '<div class="row" style="margin-left: 0px; ">#'.'<span class="dashicons dashicons-arrow-down sort-icon" id="id" style="margin-left: 5px;"></span></div>');
                        }
                    }
                    else
                    {
                        array_push($custom_table_headers, '<div class="row" style="margin-left: 0px; ">#'.'<span class="dashicons dashicons-sort sort-icon" id="id" style="margin-left: 5px;"></span></div>');
                    }
                    break;
                case 'subject':
                    if($order_by == 'ticket_title')
                    {
                        if($order == 'ASC')
                        {
                            array_push($custom_table_headers, '<div class="row">'.ucfirst($all_ticket_field).'<span class="dashicons dashicons-arrow-up sort-icon" id="subject" style="margin-left: 5px"></span></div>');
                        }
                        else{
                            array_push($custom_table_headers, '<div class="row">'.ucfirst($all_ticket_field).'<span class="dashicons dashicons-arrow-down sort-icon" id="subject" style="margin-left: 5px"></span></div>');
                        }   
                    }
                    else
                    {
                        array_push($custom_table_headers, '<div class="row">'.ucfirst($all_ticket_field).'<span class="dashicons dashicons-sort sort-icon" id="subject" style="margin-left: 5px"></span></div>');
                    }
                    break;
                default:
                     array_push($custom_table_headers, ucfirst($all_ticket_field));
            }
        }
        else
        {
            $fields = eh_crm_get_settings(array('slug' => $all_ticket_field), 'title');
            array_push($custom_table_headers, $fields[0]['title']);
        }
    }
    
}
$current = eh_crm_get_ticket(array("ticket_id"=>$ticket));
$current_meta = eh_crm_get_ticketmeta($ticket);
$priority = $current_meta['field_HN27'];
$action_value = '';
$assignee_value = '';
$eye_color='';
for($j=0;$j<count($avail_labels_wf);$j++)
{
    if(in_array("manage_tickets", $access))
    {
        $action_value .= '<li id="'.$current[0]['ticket_id'].'"><a href="#" class="single_ticket_action" id="'.$avail_labels_wf[$j]['slug'].'">'.__("Mark as", 'wsdesk').' '.$avail_labels_wf[$j]['title'].'</a></li>';

    }
    if($avail_labels_wf[$j]['slug'] == $current_meta['ticket_label'])
    {
        $ticket_label_slug = $avail_labels_wf[$j]['slug'];
        $ticket_label = $avail_labels_wf[$j]['title'];
        $eye_color = eh_crm_get_settingsmeta($avail_labels_wf[$j]['settings_id'], "label_color");
    }
}
for($j=0;$j<count($users);$j++)
{
    if(in_array("manage_tickets", $access))
    {
        $assignee_value.='<li id="'.$current[0]['ticket_id'].'"><a href="#" class="single_ticket_assignee" id="'.$users[$j]->ID.'">'.$users[$j]->display_name.'</a></li>';
    }
}
$ticket_raiser = $current[0]['ticket_email'];
if($current[0]['ticket_author'] != 0)
{
    $current_user = new WP_User($current[0]['ticket_author']);
    $ticket_raiser = $current_user->display_name;
}
$ticket_assignee_name =array();
$ticket_assignee_email = array();
if(isset($current_meta['ticket_assignee']))
{
    $current_assignee = $current_meta['ticket_assignee'];
    for($k=0;$k<count($current_assignee);$k++)
    {
        for($l=0;$l<count($users_data);$l++)
        {
            if($users_data[$l]['id'] == $current_assignee[$k])
            {
                array_push($ticket_assignee_name, $users_data[$l]['name']);
                array_push($ticket_assignee_email, $users_data[$l]['email']);
            }
        }
    }
}
$ticket_assignee_name = empty($ticket_assignee_name)?__("No Assignee", 'wsdesk'):implode(", ", $ticket_assignee_name);
$latest_reply_id = eh_crm_get_ticket_value_count("ticket_category","agent_note" ,true,"ticket_parent",$current[0]['ticket_id'],'ticket_id',$order,'1');
$latest_content = array();
$attach = "";
if(!empty($latest_reply_id))
{
    $latest_ticket_reply = eh_crm_get_ticket(array("ticket_id"=>$latest_reply_id[0]["ticket_id"]));
    $latest_content['content'] = html_entity_decode(stripslashes($latest_ticket_reply[0]['ticket_content']));
    $latest_content['author_email'] = $latest_ticket_reply[0]['ticket_email'];
    $latest_content['reply_date'] = $latest_ticket_reply[0]['ticket_date'];
    if($latest_ticket_reply[0]['ticket_author'] != 0)
    {
        $reply_user = new WP_User($latest_ticket_reply[0]['ticket_author']);
        $latest_content['author_name'] = $reply_user->display_name;
    }
    else
    {
        $latest_content['author_name'] = __("Guest", 'wsdesk');
    }
    $latest_reply_meta = eh_crm_get_ticketmeta($latest_reply_id[0]["ticket_id"]);
    if(isset($latest_reply_meta['ticket_attachment']))
    {
        $attach = ' | <small class="glyphicon glyphicon-pushpin"></small> <small style="opacity:0.7;"> '.count($latest_reply_meta['ticket_attachment']).' '.__("Attachment", 'wsdesk').'</small>';
    }
}
else
{
    $latest_content['content'] = html_entity_decode(stripslashes($current[0]['ticket_content']));
    $latest_content['author_email'] = $current[0]['ticket_email'];
    $latest_content['reply_date'] = $current[0]['ticket_date'];
    if($current[0]['ticket_author'] != 0)
    {
        $current_user = new WP_User($current[0]['ticket_author']);
        $latest_content['author_name'] = $current_user->display_name;
    }
    else
    {
        $latest_content['author_name'] = __("Guest", 'wsdesk');
    }
    if(isset($current_meta['ticket_attachment']))
    {
        $attach = ' | <small class="glyphicon glyphicon-pushpin"></small> <small style="opacity:0.7;"> '.count($current_meta['ticket_attachment']).' '.__("Attachment", 'wsdesk').'</small>';
    }
}
$ticket_tags = "";
if(!empty($avail_tags_wf))
{
    for($j=0;$j<count($avail_tags_wf);$j++)
    {
        $current_ticket_tags=(isset($current_meta['ticket_tags'])?$current_meta['ticket_tags']:array());
        for($k=0;$k<count($current_ticket_tags);$k++)
        {
            if($avail_tags_wf[$j]['slug'] == $current_ticket_tags[$k])
            {
                $ticket_tags .= '<span class="label label-info">#'.$avail_tags_wf[$j]['title'].'</span>';
            }
        }
    }
}

if(isset($current_meta['ticket_rating']))
{
    if($current_meta['ticket_rating'] == 'great')
    {
        $ticket_rating = '<span class="glyphicon glyphicon-thumbs-up" style="color: green"></span>';
    }
    else
    {
        $ticket_rating = '<span class="glyphicon glyphicon-thumbs-down" style="color: red"></span>';
    }
}
else
{
    $ticket_rating = '<span class="glyphicon glyphicon-time"></span>';
}
$raiser_voice = eh_crm_get_ticket_value_count("ticket_parent",$section_tickets_id[$i]['ticket_id'],false,"ticket_category","raiser_reply");
$agent_voice = eh_crm_get_ticket_value_count("ticket_parent",$section_tickets_id[$i]['ticket_id'],false,"ticket_category","agent_reply");
$input_data = ($tickets_display!="text")? html_entity_decode(stripslashes($latest_content['content'])):stripslashes($latest_content['content']);
$input_array[0] = '/<((html)[^>]*)>(.*)\<\/(html)>/Us';
$input_array[1] = '/<((head)[^>]*)>(.*)\<\/(head)>/Us';
$input_array[2] = '/<((style)[^>]*)>(.*)\<\/(style)>/Us';
$input_array[3] = '/<((body)[^>]*)>(.*)\<\/(body)>/Us';
$input_array[4] = '/<((form)[^>]*)>(.*)\<\/(form)>/Us';
$input_array[5] = '/<((input)[^>]*)>(.*)\<\/(input)>/Us';
$input_array[6] = '/<((input)[^>]*)>/Us';
$input_array[7] = '/<((button)[^>]*)>(.*)\<\/(button)>/Us';
$input_array[8] = '/<((iframe)[^>]*)>(.*)\<\/(iframe)>/Us';
$input_array[9] = '/<((script)[^>]*)>(.*)\<\/(script)>/Us';
$input_array[10] = '/<((ins)[^>]*)>(.*)\<\/(ins)>/Us';
$output_array[0] = '&lt;$1&gt;$3&lt;/html&gt;';
$output_array[1] = '&lt;$1&gt;$3&lt;/head&gt;';
$output_array[2] = '&lt;$1&gt;$3&lt;/style&gt;';
$output_array[3] = '&lt;$1&gt;$3&lt;/body&gt;';
$output_array[4] = '&lt;$1&gt;$3&lt;/form&gt;';
$output_array[5] = '&lt;$1&gt;$3&lt;/input&gt;';
$output_array[6] = '&lt;$1&gt;$3&lt;/input&gt;';
$output_array[7] = '&lt;$1&gt;$3&lt;/button&gt;';
$output_array[8] = '&lt;$1&gt;$3&lt;/iframe&gt;';
$output_array[9] = '&lt;$1&gt;$3&lt;/script&gt;';
$output_array[10] = '&lt;$1&gt;$3&lt;/ins&gt;';
$latest_content['content'] = preg_replace($input_array, $output_array, $input_data);
$latest_content['content'] = str_replace('<script>', '&lt;script&gt;', $latest_content['content']);
?>

<div class="modal fade" id="ticket_<?php echo $ticket;?>" tabindex="-1" role="dialog" aria-labelledby="helpdeskticket" aria-hidden="true">
<div class="tab-content">
<div class="helpdesk_container" style="background-color:#F7F7F7;height:100%;overflow:hidden;">
                  <div class="modal-dialog" role="document" style="height:98%;">
                    <div class="modal-content" style="background-color:white;width:140%;margin-left:-20%;height:98%;">
                      <div class="modal-header" style="border-bottom: 1px solid #99999F;padding-bottom: 5px;margin-bottom: 5px;">
<div class="helpdesk_top_selectors">

<div class="ticket_status" style="width:100%; height:36px;margin-right:15px;float:left;color:white;text-align:center;padding-top:8px;margin-top: -8px;margin-bottom: 8px;">
<?php echo '<tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button style="background-color:'.$eye_color.';color:white;" type="button" class="btn btn-default dropdown-toggle single_ticket_action_button_'.$current[0]['ticket_id'].'" data-toggle="dropdown">
                                                                    '.__($ticket_label, 'wsdesk').' <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    '.(($action_value != "")?$action_value:'<li style="padding: 3px 20px;">'.__("No Actions", 'wsdesk').'</li>').'
                                                                    <li class="divider"></li>
                                                                    <li class="text-center">
                                                                        <small class="text-muted">
                                                                            '.__("Select label to assign", 'wsdesk').'
                                                                        </small>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" style="background-color:#43A547;" class="btn btn-default dropdown-toggle single_ticket_client_button_'.$current[0]['ticket_id'].'" data-toggle="dropdown">
                                                                    '.__(get_the_title($current_meta['field_WC34']),'wsdesk').' <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    '.($client_value != "")?$client_value:'<li style="padding: 3px 20px;">'.__('No Client','wsdesk').'</li>'.'
                                                                    <li class="divider"></li>
                                                                    <li class="text-center">
                                                                        <small class="text-muted">
                                                                            '.__('Select Client','wsdesk').'
                                                                        </small>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button style="background-color:#76D5E3;color:white;" type="button" class="btn btn-default dropdown-toggle single_ticket_site_button_'.$current[0]['ticket_id'].'" data-toggle="dropdown">
                                                                    '.__(get_the_title($current_meta['field_MG53'], 'wsdesk').' <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    '.(($current_meta['field_MG53'] != "")?$current_meta['field_MG53']:'<li style="padding: 3px 20px;">'.__("No Site", 'wsdesk').'</li>').'
                                                                    <li class="divider"></li>
                                                                    <li class="text-center">
                                                                        <small class="text-muted">
                                                                            '.__("Select site to assign", 'wsdesk').'
                                                                        </small>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>                                                                                                                                                                   
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" style="background-color:#F23A30;" class="btn btn-default dropdown-toggle single_ticket_assignee_button_'.$current[0]['ticket_id'].'" data-toggle="dropdown">
                                                                    '.__('Assignee','wsdesk').' <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    '.($assignee_value != "")?$assignee_value:'<li style="padding: 3px 20px;">'.__('No Assignee','wsdesk').'</li>').'
                                                                    <li class="divider"></li>
                                                                    <li class="text-center">
                                                                        <small class="text-muted">
                                                                            '.__('Select assignee to assign','wsdesk').'
                                                                        </small>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button style="background-color:#268EEE;color:white;" type="button" class="btn btn-default dropdown-toggle single_ticket_asset_button_'.$current[0]['ticket_id'].'" data-toggle="dropdown">
                                                                    '.__($current_meta['field_KQ13'], 'wsdesk').' <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    '.(($current_meta['field_KQ13'] != "")?$current_meta['field_KQ13']:'<li style="padding: 3px 20px;">'.__("No Actions", 'wsdesk').'</li>').'
                                                                    <li class="divider"></li>
                                                                    <li class="text-center">
                                                                        <small class="text-muted">
                                                                            '.__("Select Asset to assign", 'wsdesk').'
                                                                        </small>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                ';
                                                ?>
                                                <div class="btn-group" style="border:1px solid #F51F1F;width:8%;height:36px;"><div class="id_title" style="color:#F51F1F;width:25%;float:left;height:36px;">ID</div><div class="id_number" style="background-color:#F51F1F;color:white;width:75%;float:left;height:36px;text-align:center;padding-top:8px;"><?php echo $ticket;?></div></div>
                                                <button type="button" style="float:right;color:black;" data-dismiss="modal" class="btn btn-secondary" >X</button>
                </div>
                
<div class="right_menu_items" style="float:right;">

    <div class="user_details"></div>
</div>


</div>
</div>

<div class="body_container" style="height:93%;overflow-y:auto;">
<div class="left_column_container" style="width:80%;float:left;">
    <div class="hd_ticket_container" style="margin-top:45px;margin-left:35px;">
    <div class="hd_ticket_title" style="font-weight:bold;text-transform:capitalize;font-size:30px; color:#99999F;"><?php echo $current[0]['ticket_title'];
					 ?></div>
        <div class="hd_ticket_subtitle" style="color:#99999F;"><?php echo $current[0]['ticket_content']
					 ?></div>
</div>

    <div class="attachments_container"> <div class="attachments_title" style="color:#F1852E; margin-left:35px;margin-top:30px;font-size:25px;">Attachments</div>
</div>
</div>
<div class="helpdesk_sidebar" style="float:left;width:15%;background-color: #F7F7F7;height: 60%;margin-top:35px;border: solid .5px #CCCCCC;">
<div class="assigned_agent_container" style="border: solid .5px #CCCCCC;height:10%;"><div class="ticket_assigned_agent" style="left: 20%;top:5%;position: relative;font-weight: bold;font-size: 17px;color: #A8A8AD;">
Assigned to<br><span><?php if(!empty($ticket_assignee_name)){$assigned_usert = get_userdata($current_assignee[0]); echo $assigned_usert->display_name;}else{echo '-';}?></span>
</div></div>
<div class="due_date_container" style="border: solid .5px #CCCCCC;height:10%;"><div class="due_date" style="left: 20%;top:20%;position: relative;font-weight: bold;font-size: 17px;color: #A8A8AD;"><i style="font-size: 30px !important;margin-left: -20px;margin-right: 20px;
}" class="fa fa-calendar"></i> Due Date <br> <?php if(!empty($current_meta['field_KZ90'])){echo $current_meta['field_KZ90'];}else{echo '-';}?>
</div></div>
<div class="ticket_status_container" style="border: solid .5px #CCCCCC;height:13%;display:flow-root;"><div class="ticket_status_sidebar" style="left: 20%;position: relative;font-weight: bold;font-size: 17px;color: #A8A8AD;">Status 
</div><div class="ticket_status" style="border-radius:3px;background-color: <?php echo $eye_color;?>; height: 36px; margin-left: 42px;float: left;color: white;text-align: center;padding-top: 8px; width: 45%;">
<?php echo $ticket_label; ?> </div></div>
<div class="ticket_priority_container" style="border: solid .5px #CCCCCC;height:13%;display:flow-root;"><div class="ticket_priority_sidebar" style="left: 20%;position: relative;font-weight: bold;font-size: 17px;color: #A8A8AD; width: 45%;">Priority
<button style="background-color:#8000ff;color:white;" type="button" class="btn btn-default dropdown-toggle single_ticket_priority_button_<?php echo $ticket ?>" data-toggle="dropdown" aria-expanded="false">
                                                                    <?php echo $priority ?><span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li id="<?php echo $ticket ?>"><a href="#" class="single_ticket_priority" id="low">Low</a></li>
                                                                    <li id="<?php echo $ticket ?>"><a href="#" class="single_ticket_priority" id="medium">Medium</a></li>
                                                                    <li id="<?php echo $ticket ?>"><a href="#" class="single_ticket_priority" id="high">High</a></li>
                                                                    <li class="divider"></li>
                                                                    <li class="text-center">
                                                                        <small class="text-muted">
                                                                            Select priority to assign
                                                                        </small>
                                                                    </li>
                                                                </ul>
                                                            </div></div>
<div class="ticket_tags_container" style="border: solid .5px #CCCCCC;height:13%;display:flow-root;"><div class="ticket_tags_sidebar" style="left: 20%;position: relative;font-weight: bold;font-size: 17px;color: #A8A8AD;">Tag
<div class="form-group">
                            <span class="help-block"><?php _e("Tags", 'wsdesk'); ?></span>
                            <select id="tags_ticket_<?php echo $ticket; ?>" class="form-control crm-form-element-input" multiple="multiple">
                                <?php
                                    $ticket_tags = (isset($current_meta['ticket_tags'])?$current_meta['ticket_tags']:array());
                                    if($ticket_tags!=="" && !empty($avail_tags))
                                    {
                                        for($i=0;$i<count($avail_tags);$i++)
                                        {
                                            if(in_array("manage_tickets", $access))
                                            {
                                                $selected = '';
                                                if(in_array($avail_tags[$i]['slug'], $ticket_tags))
                                                {
                                                    $selected = 'selected';
                                                }
                                                echo '<option value="' . $avail_tags[$i]['slug'] . '" ' . $selected . '>'.$avail_tags[$i]['title'].'</option>';
                                            }
                                            else
                                            {
                                                if (in_array($avail_tags[$i]['slug'], $ticket_tags)) {
                                                    echo '<option value="' . $avail_tags[$i]['slug'] . '" selected>'.$avail_tags[$i]['title'].'</option>';
                                                }
                                            }
                                            
                                        }
                                    }
                                ?>
                            </select>
                        </div></div></div>
  
<div class="ticket_watching_container" style="border: solid .5px #CCCCCC;height:15%;display:flow-root;"><div class="ticket_watching_sidebar" style="left: 20%;position: relative;font-weight: bold;font-size: 17px;color: #A8A8AD;">Watching
</div><div class="watching_status_1" style="background-color: #1FA3F5; height: 36px; margin-left: 42px;float: left;color: white;text-align: center;padding-top: 8px;width:17%">AW</div>
<div class="watching_status_2" style="background-color: #1FA3F5; height: 36px; margin-left: 10px;float: left;color: white;text-align: center;padding-top: 8px;width:17%">LT</div>
<div class="watching_status_3" style="background-color: #1FA3F5; height: 36px; margin-left: 10px;float: left;color: white;text-align: center;padding-top: 8px;width:17%">ET</div></div>
</div>
<div class="conversation_container" style="width:45%;float:left;margin-left:35px;">
<?php
$current_ticket = $ticket;
$convostr = "
SELECT *
FROM {$wpdb->prefix}wsdesk_tickets 
WHERE {$wpdb->prefix}wsdesk_tickets.ticket_parent = '{$current_ticket}'
ORDER BY {$wpdb->prefix}wsdesk_tickets.ticket_updated DESC
";
$conversations = $wpdb->get_results($convostr, OBJECT);




if ($conversations) : ?>
<div class="conversation_title" style="color:#F1852E;font-size:20px;">Conversation <a data-toggle="modal" data-target="#add_convo" style="color:#A5A8AC">
						<i class="fa fa-plus" style="color:#A5A8AC"></i>
					</a></div>
<?php foreach ($conversations as $key2 => $value2) {

$current_user = get_userdata($value2->ticket_author);
					 ?>
<div class="conversation_column <?php echo $value2->ticket_category;?>" style="width:88%;margin-top:13px;">
<div class="ticket_container <?php echo $value2->ticket_category;?>" style="background-color:#F2F2F2;">
        
    
    <div class="ticket_content <?php echo $value2->ticket_category;?>" style="font-size:14px; color:#99999F; margin-left: 0px; padding-top: 9px; background-color: #F2F2F2;"><?php echo $value2->ticket_content;?></div>
    
    <div class="bottom_container <?php echo $value2->ticket_category;?>" style="color: white; margin-bottom: 20px;background-color: #A5A8AC;margin-top: -2px;border-radius: 0px 0px 5px 5px;height: 20px;z-index: 1000;position: relative;left: 2px;margin-left: -2px;width:100%">
      <div class="hd_ticket_date" style="float:left;margin-right:20px;"><?php echo $value2->ticket_date;?> |</div><div class="hd_ticket_client" style="float:left;margin-right:20px;"> <?php echo $value2->ticket_category;?></div><div class="right_bottom" style="float:right;"><div class="hd_ticket_requester" style="float:left;margin-right:20px;">By: <?php echo $current_user->display_name?></div></div></div>
      </div>
      </div>
        <?php }; ?>
        <?php
  
  else :
  
    echo '<p>Client Has No Notes</p>'; ?>

    <?php endif;?>



</div>

<div class="asset_diary_container" style="width:45%;float:left;">
<?php if ($current_meta['field_KQ13']) : ?> 
<div class="title_asset_diary" style="color:#F1852E;font-size:20px; float:left;">Asset Diary <?php echo $current_meta['field_KQ13'];?>  <a data-toggle="modal" data-target="#diary_event" style="color:#A5A8AC">
						<i class="fa fa-plus" style="color:#A5A8AC"></i>
					</a></div>
<div class="asset_modals" style="float:left;margin-left:50px;"><a href="#assetstatus_<?php echo $current_meta['field_KQ13'];?>" data-toggle="modal" data-target="#assetstatus2_<?php echo $current_meta['field_KQ13'];?>"> <span class="fa fa-check-circle fa-lg " style="color:#50AE54" title="Asset Status"></span></a>
                     <a href="#assetprolicense_<?php echo $current_meta['field_KQ13'];?>" data-toggle="modal" data-target="#assetprolicense2_<?php echo $current_meta['field_KQ13'];?>"><span class="fab fa-product-hunt fa-lg " title="Guru License"></span></a>
                     <a href="#assetbackup_<?php echo $current_meta['field_KQ13'];?>" data-toggle="modal" data-target="#assetbackup2_<?php echo $current_meta['field_KQ13'];?>"><span class="fas fa-database fa-lg " title="Backup"></span></a>
                     <a href="#assetpatchmanagement_<?php echo $current_meta['field_KQ13'];?>" data-toggle="modal" data-target="#assetpatchmanagement2_<?php echo $current_meta['field_KQ13'];?>"> <span class="fas fa-tasks fa-lg " title="Patch Management"></span></a>
                     <a href="#assetlogins_<?php echo $current_meta['field_KQ13'];?>" data-toggle="modal" data-target="#assetlogins2_<?php echo $current_meta['field_KQ13'];?>"><span class="fas fa-sign-in-alt fa-lg " title="Asset Logins"></span></a>
                     <a href="#assetex05_<?php echo $current_meta['field_KQ13'];?>" data-toggle="modal" data-target="#assetex052_<?php echo $current_meta['field_KQ13'];?>"> <span class="fas fa-lock fa-lg false" title="Encryption"></span></a>
                     <a href="#assetsecurity_<?php echo $current_meta['field_KQ13'];?>" data-toggle="modal" data-target="#assetsecurity2_<?php echo $current_meta['field_KQ13'];?>"> <span class="fas fa-key fa-lg " title="Security Manager"></span></a>
                     <a href="#assetspecs_<?php echo $current_meta['field_KQ13'];?>" data-toggle="modal" data-target="#assetspecs2_<?php echo $current_meta['field_KQ13'];?>"><span class="fas fa-glasses fa-lg " title="Specifications"></span></a>
                     <a href="#assetwarranty_<?php echo $current_meta['field_KQ13'];?>" data-toggle="modal" data-target="#assetwarranty2_<?php echo $current_meta['field_KQ13'];?>"><span class="fas fa-pound-sign fa-lg " title="Purchasing &amp; Warranty Information"></span></a>                     
                    </div>
                    <div class="modalsloader"><?php
                     include get_template_directory() . '/assets-modal2.php'; ?></div> 
                    <?php

// get all associated services associated with this client

 $args = array(
        'post_type' => 'asset_diary_entries',
        'posts_per_page' => 999,
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => array(
          array(
            'key'     => 'asset_id',
            'value'   => $current_meta['field_KQ13'],
            'compare' => '=',
    ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) :  ?>
   
                    <div class="title_asset_diary" style="color:#F1852E;font-size:20px;float:left;margin-left:20px;"><?php $meta_key = 'netbios_name'; $id = $current_meta['field_KQ13'];?><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></div>
                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <div class="ticket_container" style="height:105px;border-radius:5px;margin:25px;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);background-color: #F2F2F2;width: 100%;left: -24px;position: relative;margin-bottom: 0px;">

<div class="ticket_top_container" style="background-color:#F2F2F2;">
        <div class="ticket_title" style="font-size:18px; color:#7B7C7E;font-weight:bold;margin-left:15px;margin-top:41px;border-bottom: 1px solid #99999F; margin-right: 19px;"><?php echo get_the_title() ?></div>
    </div>
    <div class="ticket_content" style="font-size:14px; color:#99999F;margin-left:15px;padding-top:9px;"><?php echo get_the_content() ?></div>
    </div>
    <div class="bottom_container" style="color: white;background-color: #A5A8AC;margin-top: -2px;border-radius: 0px 0px 5px 5px;height: 20px;z-index: 1000;position: relative;left: 2px;margin-left: -2px;">
        <div class="hd_ticket_id" style="float:left;margin-right:20px;">0013 |</div><div class="hd_ticket_date" style="float:left;margin-right:20px;">18/09/2018 |</div><div class="hd_ticket_time" style="float:left;margin-right:20px;">13:25 |</div><div class="hd_ticket_client" style="float:left;margin-right:20px;"> We Are Select</div><div class="right_bottom" style="float:right;"><div class="hd_ticket_engineer" style="float:left;margin-right:20px;">Engineer: Aaron Williams</div><div class="hd_ticket_requester" style="float:left;margin-right:20px;">Requester: Mike Smith</div></div></div>

<?php endwhile; ?>
<?php endif; ?>
    </div>
  <?php 
   else :
  
  echo '<p>Ticket Has No Asset</p>'; ?>

  <?php endif;?>

</div>
</div>
</div>
</div>
</div>
</div>