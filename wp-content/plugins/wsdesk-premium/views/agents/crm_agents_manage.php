<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$users = get_users(array("role__in" => array("WSDesk_Agents", "WSDesk_Supervisor","administrator")));
$users_data = array();
for ($i = 0; $i < count($users); $i++) {
    $current = $users[$i];
    $id = $current->ID;
    $user = new WP_User($id);
    $users_data[$i]['id'] = $id;
    $users_data[$i]['name'] = $user->display_name;
    $users_data[$i]['email'] = $user->user_email;
    $users_data[$i]['avatar'] = get_avatar_url($id);
    $users_data[$i]['role'] = $user->roles;
    $users_data[$i]['caps'] = $user->caps;
    $users_data[$i]['tags'] = get_user_meta($id, "wsdesk_tags", true);
}
?>
<div class="panel-group" id="manage_role" style="margin-bottom: 0px !important">
    <?php
    if(count($users_data)!==0)
    {
        $flag=0;
        $current_user_id=wp_get_current_user()->ID;
        foreach(wp_get_current_user()->roles as $role)
        {
            if($flag==0)
            {
                $current_user_access= $role;$flag=1;
            }
        }
        for ($i = 0; $i < count($users_data); $i++) {
            $id = $users_data[$i]['id'];
            if (in_array("WSDesk_Agents", $users_data[$i]['role'])) {
                $role = 'WSDesk Agents';
            } elseif (in_array("WSDesk_Supervisor", $users_data[$i]['role'])) {
                $role = 'WSDesk Supervisor';
            } elseif (in_array("administrator", $users_data[$i]['role'])) {
                $role = 'Administrator';
            }
            $enabledisable='';
            if($role=='Administrator' || $role=='WSDesk Supervisor')
            {
                if($current_user_access!='administrator')
                {
                    $enabledisable='disabled';
                    if($id==$current_user_id)
                        $enabledisable='';
                }
                if($current_user_access == 'administrator')
                {
                    if($role=='Administrator')
                    {
                        $enabledisable='disabled';
                    }
                }
            }
            
            $roles_temp = $users_data[$i]['role'];
            $roles = array();
            foreach ($roles_temp as $value) {
                $current_role = $value;
                array_push($roles,ucfirst(str_replace("_", " ", $current_role)));
            }
            $caps_temp = array_keys($users_data[$i]['caps']);
            $caps = '';
            for ($j = 0; $j < count($caps_temp); $j++) {
                switch ($caps_temp[$j]) {
                    case "reply_tickets":
                        $caps .= '<span class="tags">'.__("Reply Tickets", 'wsdesk').'</span> ';
                        break;
                    case "delete_tickets":
                        $caps .= '<span class="tags">'.__("Delete Tickets", 'wsdesk').'</span> ';
                        break;
                    case "manage_tickets":
                        $caps .= '<span class="tags">'.__("Manage Tickets", 'wsdesk').'</span> ';
                        break;
                    case "manage_templates":
                        $caps .= '<span class="tags">'.__("Manage Templates", 'wsdesk').'</span> ';
                        break;
                    case "settings_page":
                        $caps .= '<span class="tags">'.__("Settings Manage", 'wsdesk').'</span> ';
                        break;
                    case "agents_page":
                        $caps .= '<span class="tags">'.__("Agents Manage", 'wsdesk').'</span> ';
                        break;
                    case "import_page":
                        $caps .= '<span class="tags">'.__("Import Manage", 'wsdesk').'</span> ';
                        break;
                    case "email_page":
                        $caps .= '<span class="tags">'.__("Email Manage", 'wsdesk').'</span> ';
                        break;
                    case "merge_tickets":
                        $caps .= '<span class="tags">'.__("Merge Tickets", 'wsdesk').'</span> ';
                }
            }
            if($caps === '')
            {
               if($role=='Administrator')
                {
                    $caps .= '<span class="tags">'.__("Reply Tickets", 'wsdesk').'</span> ';
                    $caps .= '<span class="tags">'.__("Delete Tickets", 'wsdesk').'</span> ';
                    $caps .= '<span class="tags">'.__("Manage Tickets", 'wsdesk').'</span> ';
                    $caps .= '<span class="tags">'.__("Merge Tickets", 'wsdesk').'</span> ';
                    $caps .= '<span class="tags">'.__("Manage Templates", 'wsdesk').'</span> ';
                    $caps .= '<span class="tags">'.__("Settings Manage", 'wsdesk').'</span> ';
                    $caps .= '<span class="tags">'.__("Agents Manage", 'wsdesk').'</span> ';
                    $caps .= '<span class="tags">'.__("Import Manage", 'wsdesk').'</span> ';
                    $caps .= '<span class="tags">'.__("Email Manage", 'wsdesk').'</span> ';
                }
                else
                    $caps.=__("No Capabilities Assigned", 'wsdesk');
            }
            $tags_temp = $users_data[$i]['tags'];
            $tags = '';
            if(!empty($tags_temp))
            {
                for ($j = 0; $j < count($tags_temp); $j++) {
                    $tag = eh_crm_get_settings(array("slug" => $tags_temp[$j], "type" => "tag"), array("title"));
                    if(!empty($tag))
                    {
                        $tags .= '<span class="tags">' . $tag[0]['title'] . '</span>';
                    }
                }
            }
            else
            {
                $tags.= __('No Tags Mapped', 'wsdesk');
            }
            if($tags=="")
            {
                $tags.= __('No Tags Mapped', 'wsdesk');
            }
            $overall_replies = eh_crm_get_ticket_value_count("ticket_parent", 0,TRUE,"ticket_author",$users_data[$i]['id']);
            $overall_assigned = eh_crm_get_ticketmeta_value_count("ticket_assignee",$users_data[$i]['id']);
            $good = 0;
            $bad = 0;
            $all = 0;
            for($o=0;$o<count($overall_assigned);$o++)
            {
                $current_meta = eh_crm_get_ticketmeta($overall_assigned[$o]['ticket_id']);
                if(isset($current_meta['ticket_rating']))
                {
                    if($current_meta['ticket_rating'] === "great")
                    {
                        $good++;
                    }
                    else
                    {
                        $bad++;
                    }
                    $all++;
                }
            }
            if($all !== 0)
            {
                $rating = ($good/($all/100))-($bad/($all/100));
            }
            else
            {
                $rating = "None";
            }
            echo '<div class="panel panel-default">
                        <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#manage_role" data-target="#content_' . $id . '">
                            <span class ="manage-role-toggle"></span>
                            <h4 class="panel-title">
                                    ' . $users_data[$i]['name'] . ' ( ' . $role . ' )
                            </h4>
                        </div>
                        <div id="content_' . $id . '" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <center>
                                        <div class="well profile">
                                           <div class="col-sm-12">
                                               <div class="col-xs-12 col-sm-9">
                                                   <h2>' . $users_data[$i]['name'] . '</h2>
                                                   <p><strong>'.__('Roles', 'wsdesk').': </strong> ' . implode(', ', $roles) . ' </p>
                                                   <p><strong>'.__('Email', 'wsdesk').': </strong> ' . $users_data[$i]['email'] . ' </p>
                                                   <p><strong>'.__('Capability', 'wsdesk').': </strong>
                                                       <span style="line-height:1.75"> ' . $caps . ' </span>
                                                   </p>
                                               </div>             
                                               <div class="col-xs-12 col-sm-3 text-center">
                                                    <center>
                                                        <figure>
                                                            <img src="' . $users_data[$i]['avatar'] . '" alt="" class="img-circle img-responsive">
                                                            <figcaption class="ratings">
                                                                <p style="line-height:1.75"><strong>'.__('Tags', 'wsdesk').': </strong>
                                                                    ' . $tags . '
                                                                </p>
                                                            </figcaption>
                                                        </figure>
                                                    </center>
                                               </div>
                                           </div>            
                                           <div class="col-xs-12 divider text-center">
                                               <div class="col-xs-12 col-sm-4 emphasis">
                                                   <h2><strong> '.count($overall_replies).' </strong></h2>                    
                                                   <p><small>'.__('Overall Replies', 'wsdesk').'</small></p>
                                                   <button class="btn btn-success btn-block edit_user" id="user_edit_' . $id . '" '.$enabledisable.'><span class="glyphicon glyphicon-edit"></span> '.__('Edit Profile', 'wsdesk').'</button>
                                               </div>
                                               <div class="col-xs-12 col-sm-4 emphasis">
                                                   <h2><strong> '.count($overall_assigned).' </strong></h2>
                                                   <p><small>'.__('Tickets Assigned', 'wsdesk').'</small></p>
                                                   <a class="btn btn-info btn-block" target="_blank" href="'. admin_url("admin.php?page=wsdesk_reports&user=".$id).'" ><span class="glyphicon glyphicon-signal"></span> '.__('View Reports', 'wsdesk').' </a>
                                               </div>
                                               <div class="col-xs-12 col-sm-4 emphasis">
                                                   <h2><strong> '.$rating.' </strong></h2>                    
                                                   <p><small>'.__('Support Rating', 'wsdesk').'</small></p>
                                                   <div class="btn-group dropup btn-block">
                                                        <button type="button" class="btn btn-primary dropdown-toggle" '.$enabledisable.' style="width:100% !important" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="glyphicon glyphicon-user"></span> '.__('Actions', 'wsdesk').' <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                          <li><span class="user_actions user_actions_remove" id="user_actions_remove_' . $id . '"><span class="glyphicon glyphicon-remove pull-right"></span>'.__('Remove WSDesk Role', 'wsdesk').'</span></li>
                                                        </ul>
                                                    </div>
                                               </div>
                                           </div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                            <div id="user_content_change_' . $id . '">
                            </div>
                        </div>                    
                    </div>';
        }
    }
    else
    {
        ?>
        <div style="text-align: center">
            <h1><span class="glyphicon glyphicon-screenshot" style="font-size: 2em;color: lightgrey;"></span></h1><br>
            <?php
                _e('No WSDesk role assigned to any users / No Agents added', 'wsdesk');
            ?>
        </div>
        <?php
    }
    ?>
</div>
<?php
return ob_get_clean();