 <?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$avail_labels_wf = eh_crm_get_settings(array("type" => "label"), array("slug", "title", "settings_id"));
$avail_labels_f = eh_crm_get_settings(array("type" => "label", "filter" => "yes"), array("slug", "title", "settings_id"));
$avail_tags_wf = eh_crm_get_settings(array("type" => "tag"), array("slug", "title", "settings_id"));
$avail_tags_f = eh_crm_get_settings(array("type" => "tag", "filter" => "yes"), array("slug", "title", "settings_id"));
$avail_templates = eh_crm_get_settings(array("type" => "template"), array("slug", "title", "settings_id"));
$avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title", "settings_id"));
$tickets_display = eh_crm_get_settingsmeta('0', "tickets_display");
if(!$avail_templates) $avail_templates = array();
$user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
$user_caps_default = array("reply_tickets","delete_tickets","manage_tickets");
$users = get_users(array("role__in" => $user_roles_default));
$users_data = array();
for ($i = 0; $i < count($users); $i++) {
    $current = $users[$i];
    $id = $current->ID;
    $user = new WP_User($id);
    $users_data[$i]['id'] = $id;
    $users_data[$i]['name'] = $user->display_name;
    $users_data[$i]['caps'] = $user->caps;
    $users_data[$i]['email'] = $user->user_email;
}
$table_title = 'All Tickets';
$ticket_rows = eh_crm_get_settingsmeta(0, "ticket_rows");
if($ticket_rows=="")
{
    $ticket_rows=25;
}

$section_tickets_id = eh_crm_get_ticket_value_count("ticket_parent",0,false,"","","ticket_updated","DESC",$ticket_rows,0);
$all_section_ids = eh_crm_get_ticket_value_count("ticket_parent",0,false,"","","ticket_updated","DESC","",0);
$pagination_ids = array();
foreach ($all_section_ids as $tic) {
    array_push($pagination_ids,$tic['ticket_id']);
}
$avail_caps = array("reply_tickets","delete_tickets","manage_tickets","manage_templates");
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
$current_page = 0;
if(!isset($_COOKIE['collapsed_views']))
{
    $collapsed_views = array();
}
else
{
    $collapsed_views = stripslashes($_COOKIE['collapsed_views']);
    $collapsed_views = str_replace('"', '', $collapsed_views);
    $collapsed_views = str_replace('[', '', $collapsed_views);
    $collapsed_views = str_replace(']', '', $collapsed_views);
    $collapsed_views = explode(",",$collapsed_views);
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
                    array_push($custom_table_headers, '<div class="row" style="margin-left: 0px; ">#'.'<span class="dashicons dashicons-sort sort-icon" id="id" style="margin-left: 5px;"></span></div>');
                    break;
                case 'subject':
                    array_push($custom_table_headers, '<div class="row">'.ucfirst($all_ticket_field).'<span class="dashicons dashicons-sort sort-icon" id="subject" style="margin-left: 5px"></span></div>');
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
?>

<div class="container">
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-3" id="left_bar_all_tickets" style="max-height: 100vh;overflow: auto;overflow-x: hidden;min-height: 100px;">
            <ul class="nav nav-pills nav-stacked side-bar-filter" id="all_section">
                <li class="active"><a href="#" id="all"><span class="badge pull-right"><?php echo count(eh_crm_get_ticket_value_count("ticket_parent",0)); ?></span> <?php _e('All Tickets','wsdesk');?> </a></li>
            </ul>
            <?php 
                $cus_view = 0;
                $view_html = "";
                $avail_views = eh_crm_get_settingsmeta(0, "selected_views");
                $avail_views = ($avail_views == FALSE)?array():$avail_views;
                foreach ($avail_views as $view) {
                    switch ($view) {
                        case "labels_view":
                            $labels_collapsed = false;
                            if(in_array('labels', $collapsed_views))
                                $labels_collapsed = true;
                            ?>
                            <hr>
                            <h4>
                                <?php _e('Status','wsdesk'); ?>
                                <span class="spinner_loader labels_loader">
                                    <span class="bounce1"></span>
                                    <span class="bounce2"></span>
                                    <span class="bounce3"></span>
                                </span>
                            <span id="labels_collapse" class="glyphicon glyphicon-chevron-up" style="float:right; <?php echo ($labels_collapsed)?'display: none;':'';?>" onclick="collapse('labels');"></span>
                            <span id="labels_drop" class="glyphicon glyphicon-chevron-down" style="float:right; <?php echo ($labels_collapsed)?'': 'display: none;';?>" onclick="drop('labels');"></span>
                            </h4>
                            
                            <ul class="nav nav-pills nav-stacked side-bar-filter" id="labels" <?php echo ($labels_collapsed)?"style='display: none;'":"";?> > 
                                <?php
                                    for ($i = 0; $i < count($avail_labels_f); $i++) {
                                        $label_color = eh_crm_get_settingsmeta($avail_labels_f[$i]['settings_id'], "label_color");
                                        $current_label_count=eh_crm_get_ticketmeta_value_count("ticket_label",$avail_labels_f[$i]['slug']);
                                        echo '<li><a href="#" id="'.$avail_labels_f[$i]['slug'].'"><span class="badge pull-right" style="background-color:' . $label_color . ' !important;">'.count($current_label_count).'</span> '.$avail_labels_f[$i]['title'].' </a></li>';
                                    }
                                ?>
                            </ul>
                            <?php
                            break;
                        case "agents_view":
                            if(!empty($users_data))
                            {
                                $agents_collapsed = false;
                                if(in_array('agents', $collapsed_views))
                                    $agents_collapsed = true;
                                ?>
                                <hr>
                                <h4>
                                    <?php _e('Agents','wsdesk'); ?>
                                    <span class="spinner_loader agents_loader">
                                        <span class="bounce1"></span>
                                        <span class="bounce2"></span>
                                        <span class="bounce3"></span>
                                    </span>
                                    <span id="agents_collapse" class="glyphicon glyphicon-chevron-up" style="float:right; <?php echo ($agents_collapsed)?'display: none;':'';?>" onclick="collapse('agents');"></span>
                                    <span id="agents_drop" class="glyphicon glyphicon-chevron-down" style="float:right; <?php echo ($agents_collapsed)?'': 'display: none;';?>" onclick="drop('agents');">
                                </h4>
                                <ul class="nav nav-pills nav-stacked side-bar-filter" id="agents" <?php echo ($agents_collapsed)?"style='display: none;'":"";?> >
                                    <?php
                                        $user_id_agent = get_current_user_id();
                                        $user_id_agent_details = get_user_by("ID", $user_id_agent);
                                        $user_id_agent_role = $user_id_agent_details->roles;
                                        $allow_agent_tickets = eh_crm_get_settingsmeta('0', "allow_agent_tickets");
                                        if($allow_agent_tickets != 'enable'){
                                            if(in_array("WSDesk_Agents", $user_id_agent_role))
                                            {
                                                for ($i = 0; $i < count($users_data); $i++) {
                                                    if($user_id_agent == $users_data[$i]['id']){
                                                       $current_agent_count=eh_crm_get_ticketmeta_value_count("ticket_assignee",$users_data[$i]['id']);
                                                        echo '<li><a href="#" id="'.$users_data[$i]['id'].'"><span class="badge pull-right">'.count($current_agent_count).'</span> '.$users_data[$i]['name'].' </a></li>'; 
                                                    }
                                                }
                                            }else{
                                                for ($i = 0; $i < count($users_data); $i++) {
                                                    $current_agent_count=eh_crm_get_ticketmeta_value_count("ticket_assignee",$users_data[$i]['id']);
                                                    echo '<li><a href="#" id="'.$users_data[$i]['id'].'"><span class="badge pull-right">'.count($current_agent_count).'</span> '.$users_data[$i]['name'].' </a></li>'; 
                                                }
                                            }
                                        }else{
                                            for ($i = 0; $i < count($users_data); $i++) {
                                                $current_agent_count=eh_crm_get_ticketmeta_value_count("ticket_assignee",$users_data[$i]['id']);
                                                echo '<li><a href="#" id="'.$users_data[$i]['id'].'"><span class="badge pull-right">'.count($current_agent_count).'</span> '.$users_data[$i]['name'].' </a></li>'; 
                                            }
                                        }
                                        
                                        $current_agent_count=eh_crm_get_ticketmeta_value_count("ticket_assignee",array());
                                    ?>
                                    <li><a href="#" id="unassigned"><span class="badge pull-right"><?php echo count($current_agent_count);?></span> <?php _e('Unassigned','wsdesk');?> </a></li>
                                </ul>
                                <?php 
                            }
                            break;
                        case "tags_view";
                            if(!empty($avail_tags_f))
                            {
                                $tags_collapsed = false;
                                if(in_array('tags', $collapsed_views))
                                    $tags_collapsed = true;
                                ?>
                                <hr>
                                <h4>
                                    <?php _e('Tags','wsdesk'); ?>
                                    <span class="spinner_loader tags_loader">
                                        <span class="bounce1"></span>
                                        <span class="bounce2"></span>
                                        <span class="bounce3"></span>
                                    </span>
                                    <span id="tags_collapse" class="glyphicon glyphicon-chevron-up" style="float:right; <?php echo ($tags_collapsed)?'display: none;':'';?>" onclick="collapse('tags');"></span>
                                    <span id="tags_drop" class="glyphicon glyphicon-chevron-down" style="float:right; <?php echo ($tags_collapsed)?'': 'display: none;';?>" onclick="drop('tags');">
                                </h4>
                                <ul class="nav nav-pills nav-stacked side-bar-filter" id="tags" <?php echo ($tags_collapsed)?"style='display: none;'":"";?> >
                                    <?php
                                        for ($i = 0; $i < count($avail_tags_f); $i++) {
                                            $current_tags_count=eh_crm_get_ticketmeta_value_count("ticket_tags",$avail_tags_f[$i]['slug']);
                                            echo '<li><a href="#" id="'.$avail_tags_f[$i]['slug'].'"><span class="badge pull-right">'.count($current_tags_count).'</span> '.$avail_tags_f[$i]['title'].' </a></li>';
                                        }
                                    ?>
                                </ul>
                                <?php 
                            }
                            break;
                        case "users_view":
                            $users_collapsed = false;
                            if(in_array('users', $collapsed_views))
                                $users_collapsed = true;
                            ?>
                            <hr>
                            <h4>
                                <?php _e('Users','wsdesk'); ?>
                                <span class="spinner_loader users_loader">
                                    <span class="bounce1"></span>
                                    <span class="bounce2"></span>
                                    <span class="bounce3"></span>
                                </span>
                                <span id="users_collapse" class="glyphicon glyphicon-chevron-up" style="float:right; <?php echo ($users_collapsed)?'display: none;':'';?>" onclick="collapse('users');"></span>
                                <span id="users_drop" class="glyphicon glyphicon-chevron-down" style="float:right; <?php echo ($users_collapsed)?'': 'display: none;';?>" onclick="drop('users');">
                                </h4>
                            </h4>
                            <ul class="nav nav-pills nav-stacked side-bar-filter" id="users" <?php echo ($users_collapsed)?"style='display: none;'":"";?> >
                                <?php
                                    $registered_count = eh_crm_get_ticket_value_count("ticket_author",0,true,"ticket_parent",0);
                                    echo '<li><a href="#" id="registeredU" class="user_section"><span class="badge pull-right">'.count($registered_count).'</span> '.__('Registered Users','wsdesk').' </a></li>';
                                    $guest_count = eh_crm_get_ticket_value_count("ticket_author",0,false,"ticket_parent",0);
                                    echo '<li><a href="#" id="guestU" class="user_section"><span class="badge pull-right">'.count($guest_count).'</span> '.__('Guest Users','wsdesk').' </a></li>';
                                ?>
                            </ul>
                            <?php
                            break;
                        case "";
                            break;
                        default:
                            $view_set = eh_crm_get_settings(array("slug"=>$view,"type"=>"view"),array("slug","settings_id","title"));
                            $view_set_meta = eh_crm_get_settingsmeta($view_set[0]['settings_id']);
                            $log_id   = get_current_user_id();
                            $log_user = get_user_by("ID", $log_id);
                            $log_role = $log_user->roles;
                            $current_role = "";
                            if(in_array("WSDesk_Agents", $log_role))
                            {
                                $current_role = "WSDesk_Agents";
                            }
                            if(in_array("WSDesk_Supervisor", $log_role))
                            {
                                $current_role = "WSDesk_Supervisor";
                            }
                            if(in_array("administrator", $log_role))
                            {
                                $current_role = "administrator";
                            }
                            if(in_array($current_role, $view_set_meta['view_access']))
                            {
                                $views_collapsed = false;
                                if(in_array('views', $collapsed_views))
                                    $views_collapsed = true;
                                
                                $view_count = eh_crm_get_view_tickets($view);
                                $view_html.='<ul class="nav nav-pills nav-stacked side-bar-filter" id="views"';
                                $view_html.=($views_collapsed)?' style="display: none;" ':"";
                                $view_html.='><li><a href="#" id="'.$view.'"><span class="badge pull-right">'.count($view_count).'</span> '.$view_set[0]['title'].' </a></li>
                                </ul>';
                                $cus_view++;
                            }
                            break;
                    }
                }
                if($cus_view !== 0)
                {
                    $views_collapsed = false;
                    if(in_array('views', $collapsed_views))
                        $views_collapsed = true;
                    ?>
                    <hr>
                    <h4>
                    <?php _e('Ticket Views','wsdesk');?>
                        <span class="spinner_loader views_loader">
                            <span class="bounce1"></span>
                            <span class="bounce2"></span>
                            <span class="bounce3"></span>
                        </span>
                        <span id="views_collapse" class="glyphicon glyphicon-chevron-up" style="float:right; <?php echo ($views_collapsed)?'display: none;':'';?>" onclick="collapse('views');"></span>
                        <span id="views_drop" class="glyphicon glyphicon-chevron-down" style="float:right; <?php echo ($views_collapsed)?'': 'display: none;';?>" onclick="drop('views');">
                    </h4>
                    <?php
                    echo $view_html;
                }
            ?>
        </div>

        <div class="col-md-9" style="padding-right:0px;">
            <div class="full_row filter_div" id="dev-table-action-bar" >
                <div class="filter-each"><input type="checkbox" class="ticket_select_all"></div>
                <div class="filter-each" id="refresh_tickets" style="cursor:pointer;">
                    <div  class="ticket-refresh-button" data-placement="top" data-toggle="wsdesk_tooltip" title="<?php _e('Refresh', 'wsdesk'); ?>">
                        <span class="glyphicon glyphicon-refresh"></span>
                    </div>
                </div>
                <div class="btn-group filter-each" style="padding: 0px; width: 100px; height: 35px;">
                    <button type="button" class="btn btn-default dropdown-toggle mulitple_ticket_action_button select-full select-btn" style="color: #333;" data-toggle="dropdown">
                        <?php _e('Actions', 'wsdesk'); ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <?php
                            if(in_array("manage_tickets", $access) || in_array("delete_tickets", $access))
                            {
                                if(in_array("manage_tickets", $access))
                                {
                                    for($j=0;$j<count($avail_labels_wf);$j++)
                                    {
                                        echo '<li><a href="#" class="multiple_ticket_action" id="'.$avail_labels_wf[$j]['slug'].'">'.__('Mark as','wsdesk').' '.$avail_labels_wf[$j]['title'].'</a></li>';
                                    }
                                }
                            }
                            else
                            {
                                echo '<li style="padding: 3px 20px;">'.__('No Actions', 'wsdesk').'</li>';
                            }
                        ?>
                    </ul>
                </div>
                <div class="btn-group filter-each ticket-template-btn" style="padding: 0px; min-width: 54px; height: 35px;">
                    <button type="button" class="btn btn-default dropdown-toggle mulitple_ticket_template_button select-full select-btn" style="color: #333;" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-envelope" style="margin-right:5px;"></span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu list-group" id="template_multiple_actions" style="min-width:250px" role="menu">
                        <li>
                            <div class="template_div asg">
                                <div style="visibility: visible;"></div>
                                <input type="text" id="search_template" placeholder="<?php _e('Search Template', 'wsdesk');?>">
                                <div class="A0"><span class="glyphicon glyphicon-search"></span></div>
                            </div>
                        </li>
                        <li role="separator" class="divider" style="margin:0px; margin-bottom:5px !important;margin-top: 5px !important;"></li>
                        <?php
                            if(!empty($avail_templates))
                            {
                                for($i=0;$i<count($avail_templates)&&$i<6;$i++)
                                {
                                    echo '<li class="list-group-item available_template '.$avail_templates[$i]['slug'].'_li" title="'.$avail_templates[$i]['title'].'"> <span class="truncate multiple_template_action '.$avail_templates[$i]['slug'].'_head" based="bulk" id="'.$avail_templates[$i]['slug'].'">'.$avail_templates[$i]['title'].'</span>';
                                    if(in_array("manage_templates", $access))
                                    {
                                        echo '<span class="pull-right"> <span class="glyphicon glyphicon-pencil ticket_template_edit_type" id="'.$avail_templates[$i]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Edit Template','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span></span>';
                                    }
                                    echo '</li>';
                                }
                                if($i==6)
                                {
                                    echo '<li role="separator" class="divider available_template" style="margin:0px; margin-bottom:5px !important;margin-top: 5px !important;"></li>';
                                    echo '<center><a href="#wsdesk-template-wsdesk-popup">'.(count($avail_templates)-6)." more template".((count($avail_templates)-6)==1? ' is':"s are")." there".'</a></center>';
                                }
                            }
                            if(in_array("manage_templates", $access))
                            {
                                echo '<li role="separator" class="divider" style="margin:0px; margin-bottom:5px !important;margin-top: 5px !important;"></li>';
                                echo '<li class="list-group-item" style="border:none;cursor:pointer;" data-toggle="modal" data-target="#new_template_model" title="'.__('Create new','wsdesk').'"><span> '.__('Create template', 'wsdesk').' </span></li>
                                ';
                            }
                        ?>
                    </ul>
                </div>
                <?php
                    if(in_array("delete_tickets", $access))
                    {
                        echo '<div class="filter-each ticket-delete-btn multiple_ticket_action" id="delete_tickets" style="display: none;"><div  class="ticket-delete-button" data-placement="top" data-toggle="wsdesk_tooltip" title="'.__('Delete Tickets','wsdesk').'"><span class="glyphicon glyphicon-trash"></span></div></div>';
                    }
                    if(in_array("manage_tickets", $access))
                    {
                        echo '<div class="filter-each ticket-edit-btn multiple_ticket_action" id="edit_tickets" style="display: none;"><div  class="ticket-edit-button" data-placement="top" data-toggle="wsdesk_tooltip" title="'.__('Edit Tickets','wsdesk').'"><span class="glyphicon glyphicon-edit"></span></div></div>';
                    }
                ?>
                
            </div>
        </div>
        <div class="modal fade" id="new_template_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php _e('New Template', 'wsdesk'); ?></h4>
              </div>
              <div class="modal-body">
                <p style="margin-top: 5px;font-size: 16px;">
                    <label for=""><small><?php _e('Template title to identify', 'wsdesk'); ?></small></label>
                    <input type="text" placeholder="<?php _e('Enter Title', 'wsdesk'); ?>" class="form-control template_title_editable" id="new_template_title">
                </p>
                <div class="panel-group" id="email_auto_role" style="margin-bottom: 10px !important;">
                    <div class="panel panel-default">
                        <div class="panel-heading collapsed" style="padding:10px;cursor: pointer;" data-toggle="collapse" data-parent="#email_auto_role" data-target="#content_email_auto">
                            <span class ="email-reply-toggle"></span>
                            <h4 class="panel-title">
                                <?php _e("Code for template", 'wsdesk'); ?>
                            </h4>
                        </div>
                        <div id="content_email_auto" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                           <?php _e("[name]",'wsdesk');?>
                                        </div>
                                        <div class="col-md-9">
                                            <?php _e("To insert ticket raiser name in the template", 'wsdesk'); ?>
                                        </div>
                                    </div>
                                    <span class="crm-divider"></span>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <?php _e("[id]",'wsdesk');?>
                                        </div>
                                        <div class="col-md-9">
                                            <?php _e("To insert ticket number in the template", 'wsdesk'); ?>
                                        </div>
                                    </div>
                                    <?php
                                        $selected_fields = eh_crm_get_settingsmeta(0, "selected_fields");
                                        if(empty($selected_fields))
                                        {
                                            $selected_fields = array();
                                        }
                                        foreach ($avail_fields as $field) {
                                            if($field['slug'] === 'google_captcha' || !in_array($field['slug'], $selected_fields))
                                            {
                                                continue;
                                            }
                                            echo '
                                                <span class="crm-divider"></span>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        ['.$field['slug'].']
                                                    </div>
                                                    <div class="col-md-9">
                                                       '.__("To insert ", 'wsdesk').' '.$field['title'].' '.__("field value in the template", 'wsdesk').'
                                                    </div>
                                                </div>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="textarea" style="height: 100px" id="new_template_content"></div> 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'wsdesk'); ?></button>
                <button type="button" class="btn btn-primary" id="create_new_template"><?php _e('Create', 'wsdesk');?></button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="edit_tickets_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="padding-left: 15px;"><?php _e('Edit','wsdesk');?> <span class="number_of_tickets"></span> <?php  _e('Ticket', 'wsdesk'); ?>(s)</h4>
                        <input type="hidden" name="ticket_ids" id="ticket_ids" value="">
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 left-modal-body">
                                <div class="row bulk-edit-row">
                                    <label class="edit_tickets_label"><?php _e('Assignee', 'wsdesk'); ?></label>
                                    <select id="assignee_ticket_edit" class="form-control" aria-describedby="helpBlock" multiple="multiple">
                                        <?php
                                            $options='';
                                            for($i=0;$i<count($users_data);$i++)
                                            {
                                                if(in_array('administrator',array_keys($users_data[$i]['caps'])))
                                                {
                                                    $options .= "<option value='".$users_data[$i]['id']."'>".$users_data[$i]['name'].' | Administrator'."</option>";
                                                }
                                                else if(in_array('WSDesk_Supervisor',array_keys($users_data[$i]['caps'])))
                                                {
                                                    $options .= "<option value='".$users_data[$i]['id']."'>".$users_data[$i]['name'].' | Supervisor'."</option>";
                                                }
                                                else if(in_array('WSDesk_Agents',array_keys($users_data[$i]['caps'])))
                                                {
                                                    $options .= "<option value='".$users_data[$i]['id']."'>".$users_data[$i]['name'].' | Agent'."</option>";
                                                }
                                            }
                                            echo $options;
                                        ?>
                                    </select>
                                </div>
                                <div class="row bulk-edit-row">
                                    <label class="edit_tickets_label"><?php _e('Labels', 'wdesk'); ?></label>
                                    <select id="label_ticket_edit" class="form-control" aria-describedby="helpBlock">
                                        <?php
                                            $options='';
                                            $options .= "<option value=0>". __('No Change', 'wsdesk') ."</option>";
                                            for($i=0;$i<count($avail_labels_f);$i++)
                                            {
                                                $options .= "<option value='".$avail_labels_f[$i]['slug']."'>".$avail_labels_f[$i]['title']."</option>";
                                            }
                                            echo $options;
                                        ?>
                                    </select>
                                </div>
                                <div class="row bulk-edit-row">
                                    <label class="edit_tickets_label"> <?php _e('Tags', 'wsdesk'); ?></label>
                                    <select id="tags_ticket_edit" class="form-control" aria-describedby="helpBlock" multiple="multiple">
                                        <?php
                                            $options='';
                                            for($i=0;$i<count($avail_tags_f);$i++)
                                            {
                                                $options .= "<option value='".$avail_tags_f[$i]['slug']."'>".$avail_tags_f[$i]['title']."</option>";
                                            }
                                            echo $options;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7 right-modal-body">
                                <div class="row bulk-edit-row">
                                    <label class="edit_tickets_label"><?php _e('Subject' , 'wsdesk'); ?></label>
                                    <input type="text" placeholder="<?php _e('No Change', 'wsdesk'); ?>" id="title_ticket_edit" class="form-control">
                                </div>
                                <div class="row bulk-edit-row">
                                    <label class="edit_tickets_label"><?php _e('Bulk Reply', 'wsdesk'); ?></label>
                                    <div class="textarea" style="width: 100% !important; height: 200px;" class="reply_textarea" id="reply_textarea_edit" name="reply_textarea_edit"></div> 
                                </div>
                                <div class="row bulk-edit-row">
                                    <span class="btn btn-primary fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span><?php _e("Attachment", 'wsdesk'); ?></span>
                                        <input type="file" name="files" id="files_edit" class="attachment_reply"  media="all" multiple="">
                                    </span>
                                    <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e('Text in the body of the reply is mandatory to submit attachemnts.', 'wsdesk'); ?>" data-container="body"></span>
                                </div>
                                <div class="row">
                                    <div class="upload_preview_edit"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'wsdesk'); ?></button>
                        <button type="button" class="btn btn-primary" id="bulk_edit_submit"><?php _e('Submit', 'wsdesk'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="update_template_model_display"></div>
        <div id="preview_template_model_display"></div>
        <div class="col-md-9" id="right_bar_all_tickets" style="overflow: scroll;padding-right: 0px;">
            <input type="hidden" id="pagination_ids_traverse" value="<?php echo htmlentities(json_encode($pagination_ids))?>">
            <div class="panel panel-default tickets_panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php _e("$table_title", "wsdesk");?>
                        <span class="spinner_loader table_loader">
                            <span class="bounce1"></span>
                            <span class="bounce2"></span>
                            <span class="bounce3"></span>
                        </span>
                    </h3>
                    <div class="pull-right">
                        <span class="clickable filter" data-toggle="wsdesk_tooltip" title="<?php _e('Tickets Filter','wsdesk');?>" data-container="body">
                            <i class="glyphicon glyphicon-filter"></i>
                        </span>
                    </div>
                    <div class="pull-right" style="margin: -25px 0px 0px 0px;">
                        <span class="text-muted"><b><?php $page_number=$current_page;echo (($current_page>0)&&($current_page*$ticket_rows)<=count(eh_crm_get_ticket_value_count("ticket_parent",0)))?((($current_page)*$ticket_rows)+1):"1"; ?></b>–<b><?php echo(($current_page>0)&&($current_page*$ticket_rows)<=count(eh_crm_get_ticket_value_count("ticket_parent",0)))?($current_page*$ticket_rows)+count($section_tickets_id):("$ticket_rows");?></b> of <b><?php echo count(eh_crm_get_ticket_value_count("ticket_parent",0)); ?></b></span>
                        <?php if($page_number>=0){
                            $page_number=$current_page+1;
                            
                            $current_page=$current_page;
                        }?>
                        <input type="number" name="cur" id="current_page_n" class="btn btn-default pagination_tic" placeholder="<?php _e("$page_number",'wsdesk')?>"min=1 title="<?php _e('Page Number', 'wsdesk');  ?> "
                        oninput="validity.valid||(value='');" style="width:65px;height:30px" />
                        <div class="btn-group btn-group-sm" style="margin:1px 0px 0px 0px;">
                            <?php
                                    if($current_page != 0)
                                    {
                                        ?>
                                            <button type="button"  class="btn btn-default pagination_tickets" id="prev" title="<?php _e('Previous', 'wsdesk'); ?> <?php echo $ticket_rows?>" data-container="body">
                                                <span class="glyphicon glyphicon-chevron-left"></span>
                                            </button>
                                        <?php
                                    }
                            ?>                
                            <?php
                                    if($current_page == 0)
                                    {
                                        ?>
                                            <button type="button"  class="btn btn-default pagination_tick" id="pre"  title="<?php _e('Beginning of the Page', 'wsdesk');  ?> "style="color:#AFAFAF; " data-container="body">
                                                <span class="glyphicon glyphicon-chevron-left"></span>
                                            </button>
                                        <?php
                                    }
                            ?>                       
                            <input type="hidden" id="current_page_no" value="<?php echo $current_page?>">
                            <?php 
                                    //To Hide the preview and next buttons for first and lastpages of tickets
                                    if((($current_page*$ticket_rows)+count($section_tickets_id)) != count(eh_crm_get_ticket_value_count("ticket_parent",0)))
                                    {
                                        ?>
                                            <button type="button"  class="btn btn-default pagination_tickets" id="next"  title="<?php _e('Next', 'wsdesk');?> <?php echo $ticket_rows?>" data-container="body">
                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                            </button>
                                        <?php
                                    }
                            ?>
                            <?php 
                                    if((($current_page*$ticket_rows)+count($section_tickets_id)) == count(eh_crm_get_ticket_value_count("ticket_parent",0)))
                                    {
                                        ?>
                                            <button type="button"  class="btn btn-default pagination_tick" id="nex" title="<?php _e('End of the Page', 'wsdesk'); ?> "style="color:#AFAFAF; " data-container="body">
                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                            </button>
                                        <?php
                                    }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="<?php _e('Filter Tickets','wsdesk');?>" />
                </div>  
                <table class="table table-hover" id="dev-table">
                    <thead>
                        <tr class="except_view">
                            <th style="width: 1%;"></th>
                            <th style="width: 2%;"><?php _e('View', 'wsdesk');?></th>
                            <?php
                                foreach ($custom_table_headers as  $value) {
                                    echo '<th>'.$value.'</th>';
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(empty($section_tickets_id))
                            {
                                echo '<tr class="except_view">
                                    <td colspan="12"> '.__('No Tickets','wsdesk').' </td></tr>';
                            }
                            else
                            {
                                for($i=0;$i<count($section_tickets_id);$i++)
                                {
                                    $current = eh_crm_get_ticket(array("ticket_id"=>$section_tickets_id[$i]['ticket_id']));
                                    $current_meta = eh_crm_get_ticketmeta($section_tickets_id[$i]['ticket_id']);
                                    $action_value = '';
                                    $assignee_value = '';
                                    $eye_color='';
                                    for($j=0;$j<count($avail_labels_wf);$j++)
                                    {
                                        if(in_array("manage_tickets", $access))
                                        {
                                            $action_value .= '<li id="'.$current[0]['ticket_id'].'"><a href="#" class="single_ticket_action" id="'.$avail_labels_wf[$j]['slug'].'">'.__('Mark as','wsdesk').' '.$avail_labels_wf[$j]['title'].'</a></li>';

                                        }
                                        if($avail_labels_wf[$j]['slug'] == $current_meta['ticket_label'])
                                        {
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
                                    $ticket_raiser_email = $current[0]['ticket_email'];
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
                                    $ticket_assignee_name = empty($ticket_assignee_name)?__('No Assignee','wsdesk'):implode(", ", $ticket_assignee_name);
                                    $latest_reply_id = eh_crm_get_ticket_value_count("ticket_category","agent_note" ,true,"ticket_parent",$current[0]['ticket_id'],'ticket_id','DESC','1');
                                    $latest_content = array();
                                    $attach = "";
                                    if(!empty($latest_reply_id))
                                    {
                                        $latest_ticket_reply = eh_crm_get_ticket(array("ticket_id"=>$latest_reply_id[0]["ticket_id"]));
                                        $latest_content['content'] = $latest_ticket_reply[0]['ticket_content'];
                                        $latest_content['author_email'] = $latest_ticket_reply[0]['ticket_email'];
                                        $latest_content['reply_date'] = $latest_ticket_reply[0]['ticket_date'];
                                        if($latest_ticket_reply[0]['ticket_author'] != 0)
                                        {
                                            $reply_user = new WP_User($latest_ticket_reply[0]['ticket_author']);
                                            $latest_content['author_name'] = $reply_user->display_name;
                                        }
                                        else
                                        {
                                            $latest_content['author_name'] = __('Guest','wsdesk');
                                        }
                                        $latest_reply_meta = eh_crm_get_ticketmeta($latest_reply_id[0]["ticket_id"]);
                                        if(isset($latest_reply_meta['ticket_attachment']))
                                        {
                                            $attach = ' | <small class="glyphicon glyphicon-pushpin"></small> <small style="opacity:0.7;"> '.count($latest_reply_meta['ticket_attachment']).' '.__('Attachment','wsdesk').'</small>';
                                        }
                                    }
                                    else
                                    {
                                        $latest_content['content'] = $current[0]['ticket_content'];
                                        $latest_content['author_email'] = $current[0]['ticket_email'];
                                        $latest_content['reply_date'] = $current[0]['ticket_date'];
                                        if($current[0]['ticket_author'] != 0)
                                        {
                                            $current_user = new WP_User($current[0]['ticket_author']);
                                            $latest_content['author_name'] = $current_user->display_name;
                                        }
                                        else
                                        {
                                            $latest_content['author_name'] = __('Guest','wsdesk');
                                        }
                                        if(isset($current_meta['ticket_attachment']))
                                        {
                                            $attach = ' | <small class="glyphicon glyphicon-pushpin"></small> <small style="opacity:0.7;"> '.count($current_meta['ticket_attachment']).' '.__('Attachment','wsdesk').'</small>';
                                        }
                                    }
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
                                    echo '
                                    <tr class="clickable ticket_row" id="'.$current[0]['ticket_id'].'">
                                        <td class="except_view"><input type="checkbox" class="ticket_select" id="ticket_select" value="'.$current[0]['ticket_id'].'"></td>
                                        <td class="except_view"><button class="btn btn-default btn-xs accordion-toggle quick_view_ticket" style="background-color: '.$eye_color.' !important" data-toggle="collapse" data-target="#expand_'.$current[0]['ticket_id'].'" ><span class="glyphicon glyphicon-eye-open"></span></button></td>';
                                    if(!empty($all_ticket_field_views))
                                    {
                                        foreach ($all_ticket_field_views as  $all_ticket_field)
                                        {
                                            switch ($all_ticket_field) {
                                                case 'id':
                                                    echo '<td>'.$current[0]['ticket_id'].'</td>';
                                                    break;
                                                case 'requestor':
                                                    echo '<td>'.$ticket_raiser.'</td>';
                                                    break;
                                                case 'subject':
                                                    echo '<td class="wrap_content" data-toggle="wsdesk_tooltip" title="'.$current[0]['ticket_title'].'" data-container="body">'.$current[0]['ticket_title'].'</td>';
                                                    break;
                                                case 'requested':
                                                    echo '<td>'.eh_crm_get_formatted_date($current[0]['ticket_date']).'</td>';
                                                    break;
                                                case 'assignee':
                                                    echo '<td>'.$ticket_assignee_name.'</td>';
                                                    break;
                                                case 'feedback':
                                                    echo '<td>'.$ticket_rating.'</td>';
                                                    break;
                                                default:
                                                    $current_settings_id = eh_crm_get_settings(array('slug' => $all_ticket_field), 'settings_id');
                                                    $current_settings_meta = eh_crm_get_settingsmeta($current_settings_id[0]['settings_id']);
                                                    if($current_settings_meta['field_type'] == 'select')
                                                    {
                                                        if($all_ticket_field == 'woo_order_id')
                                                        {
                                                           $current_settings_meta['field_type'] = 'text';
                                                        }
                                                    }
                                                    if($current_settings_meta['field_type'] != "file" && $current_settings_meta['field_type'] != "google_captcha")
                                                    {
                                                        switch ($current_settings_meta['field_type']) {
                                                            case 'select':
                                                            case 'radio':
                                                            case 'checkbox':
                                                                $field_values = $current_settings_meta['field_values'];
                                                                if(isset($current_meta[$all_ticket_field]))
                                                                    echo '<td>'.$field_values[$current_meta[$all_ticket_field]].'</td>';
                                                                else
                                                                    echo '<td>-</td>';
                                                                break;
                                                            default:
                                                                if(isset($current_meta[$all_ticket_field]))
                                                                    echo '<td>'.$current_meta[$all_ticket_field].'</td>';
                                                                else
                                                                    echo '<td>-</td>';
                                                                break;
                                                        }
                                                    }
                                                    break;
                                            }
                                        }
                                    }
                                    echo '</tr>
                                    <tr class="except_view">
                                        <td colspan="12" class="hiddenRow">
                                            <div class="accordian-body collapse" id="expand_'.$current[0]['ticket_id'].'">
                                                <table class="table table-striped" style="margin-bottom: 0px !important">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="12" style="white-space: normal;">
                                                            <div style="padding:5px 0px;">
                                                                <small class="glyphicon glyphicon-user"></small> <small style="opacity:0.7;">'.$latest_content['author_name'].'</small>
                                                                | <small class="glyphicon glyphicon-envelope"></small> <small style="opacity:0.7;">'.$latest_content['author_email'].'</small>
                                                                | <small class="glyphicon glyphicon-calendar"></small> <small style="opacity:0.7;">'. eh_crm_get_formatted_date($latest_content['reply_date']).'</small>
                                                                '.$attach.'
                                                            </div>
                                                            <hr>
                                                            <p>
                                                                '.stripslashes($latest_content['content']).'
                                                            </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>'.__('Actions','wsdesk').'</th>
                                                            <th>'.__('Assignee','wsdesk').'</th>
                                                            <th>'.__('Reply Requester','wsdesk').'</th>
                                                            <th>'.__('Raiser Voices','wsdesk').'</th>
                                                            <th>'.__('Agent Voices','wsdesk').'</th>
                                                            <th>'.__('Tags','wsdesk').'</th>
                                                            <th>'.__('Source','wsdesk').'</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-default dropdown-toggle single_ticket_action_button_'.$current[0]['ticket_id'].'" data-toggle="dropdown">
                                                                        '.__('Actions','wsdesk').' <span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">
                                                                        '.(($action_value != "")?$action_value:'<li style="padding: 3px 20px;">'.__('No Actions','wsdesk').'</li>').'
                                                                        <li class="divider"></li>
                                                                        <li class="text-center">
                                                                            <small class="text-muted">
                                                                                '.__('Select label to assign','wsdesk').'
                                                                            </small>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-default dropdown-toggle single_ticket_assignee_button_'.$current[0]['ticket_id'].'" data-toggle="dropdown">
                                                                        '.__('Assignee','wsdesk').' <span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">
                                                                        '.(($assignee_value != "")?$assignee_value:'<li style="padding: 3px 20px;">'.__('No Assignee','wsdesk').'</li>').'
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
                                                                <a href="#reply_'.$current[0]['ticket_id'].'" data-toggle="modal"  title="'.__('Compose Reply','wsdesk').'">
                                                                    '.$current[0]['ticket_email'].'
                                                                </a>
                                                            </td>
                                                            <td>'.count($raiser_voice).'</td>
                                                                <td>'.count($agent_voice).'</td>
                                                            <td>'.(($ticket_tags!="")?$ticket_tags:__("No Tags",'wsdesk')).'</td>
                                                            <td>'.((isset($current_meta['ticket_source']))?$current_meta['ticket_source']:__("Unknown",'wsdesk')).'</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- Modal -->
                                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="reply_'.$current[0]['ticket_id'].'" class="modal fade" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                <h4 class="modal-title">'.__('Ticket','wsdesk').' #'.$current[0]['ticket_id'].' '.__('Compose Reply','wsdesk').'</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p style="margin-top: 5px;font-size: 16px;">
                                                                ';  
                                                                if(in_array("manage_tickets", $access))
                                                                {
                                                                    echo '<input type="text" value="'.$current[0]['ticket_title'].'" id="direct_ticket_title_'.$current[0]['ticket_id'].'" class="ticket_title_editable">';
                                                                }
                                                                else
                                                                {
                                                                    echo $current[0]['ticket_title'];
                                                                }
                                                                if(in_array("reply_tickets",$access))
                                                                {
                                                                    ?>
                                                                    </p>
                                                                    <div class="row" style="margin-bottom: 20px;">
                                                                        <div class="col-md-12">
                                                                            <div class="widget-area no-padding blank">
                                                                                <div class="status-upload">
                                                                                    <div rows="10" cols="30" class="textarea form-control direct_reply_textarea" id="direct_reply_textarea_<?php echo $current[0]['ticket_id']; ?>" name="reply_textarea_<?php echo $current[0]['ticket_id']; ?>"></div> 
                                                                                    <div class="form-group">
                                                                                        <div class="input-group col-md-12">
                                                                                            <span class="btn btn-primary fileinput-button">
                                                                                                <i class="glyphicon glyphicon-plus"></i>
                                                                                                <span><?php _e('Attachment','wsdesk');?></span>
                                                                                                <input type="file" name="direct_files" id="direct_files_<?php echo $current[0]['ticket_id']; ?>" class="direct_attachment_reply" multiple="">
                                                                                            </span>
                                                                                            <div class="btn-group pull-right">
                                                                                                <button type="button" class="btn btn-primary dropdown-toggle direct_ticket_reply_action_button_<?php echo $current[0]['ticket_id']; ?>" data-toggle="dropdown" aria-haswsdesk-popup="true" aria-expanded="false">
                                                                                                  <?php _e('Submit as','wsdesk');?> <span class="caret"></span>
                                                                                                </button>
                                                                                                <ul class="dropdown-menu">
                                                                                                    <?php
                                                                                                        for($j=0;$j<count($avail_labels_wf);$j++)
                                                                                                        {
                                                                                                            echo '<li id="'.$current[0]['ticket_id'].'"><a href="#" class="direct_ticket_reply_action" id="'.$avail_labels_wf[$j]['slug'].'">'.__('Submit as','wsdesk').' '.$avail_labels_wf[$j]['title'].'</a></li>';
                                                                                                        }
                                                                                                    ?>
                                                                                                    <li role="separator" class="divider"></li>
                                                                                                    <li id="<?php echo $current[0]['ticket_id'];?>"><a href="#" class="direct_ticket_reply_action" id="note"><?php _e('Submit as Note','wsdesk');?></a></li>
                                                                                                    <li class="text-center"><small class="text-muted"><?php _e('Notes visible to Agents and Supervisors','wsdesk');?></small></li>
                                                                                                </ul>
                                                                                              </div>
                                                                                        </div>
                                                                                        <div class="direct_upload_preview_files_<?php echo $current[0]['ticket_id'];?>"></div>
                                                                                    </div>
                                                                                </div><!-- Status Upload  -->
                                                                            </div><!-- Widget Area -->
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    echo "<p>".__("You don't Have permisson to Reply this ticket",'wsdesk')."</p>";
                                                                }
                                                            echo'
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            </div>
                                        </td>
                                    </tr>
                                    ';
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>deepview();</script>
<div id="wsdesk-template-wsdesk-popup" class="wsdesk-overlay">
    <div class="wsdesk-popup">
        <h4>Available Templates</h4>
        <a class="close" href="#">&times;</a>
        <div class="content">
            <div class="wsdesk-overlay-success" style="display: none;">
                <?php _e('Template Added !','wsdesk');?>
            </div>
            <?php
                if(!empty($avail_templates))
                {
                    for($i=0;$i<count($avail_templates);$i++)
                    {
                        echo '<li class="list-group-item available_template '.$avail_templates[$i]['slug'].'_li" title="'.$avail_templates[$i]['title'].'"> <span class="truncate multiple_template_action '.$avail_templates[$i]['slug'].'_head" based="bulk" id="'.$avail_templates[$i]['slug'].'">'.$avail_templates[$i]['title'].'</span>';
                        if(in_array("manage_templates", $access))
                        {
                            echo '<span class="pull-right"> <span class="glyphicon glyphicon-pencil ticket_template_edit_type" id="'.$avail_templates[$i]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Edit Template','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span></span>';
                        }
                        echo '</li>';
                    }
                }?>
        </div>
    </div>
</div>
<?php
return ob_get_clean();