<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$users_data = get_users(array("role__in"=>array("administrator","WSDesk_Agents","WSDesk_Supervisor")));
$users = array();
$select = array();
for($i=0;$i<count($users_data);$i++)
{
    $current = $users_data[$i];
    $temp = array();
    $roles = $current->roles;
    foreach ($roles as $value) {
        $current_role = $value;
        array_push($temp,ucfirst(str_replace("_", " ", $current_role)));
    }
    $users[implode(' & ', $temp)][$current->ID] = $current->data->display_name;
}
$args = array("type" => "label");
$fields = array("slug","title","settings_id");
$avail_labels= eh_crm_get_settings($args,$fields);
$ticket_rows = eh_crm_get_settingsmeta('0', "ticket_rows");
if($ticket_rows=="")
{
    $ticket_rows=25;
}
$avail_fields = eh_crm_get_settings(array("type" => "field"),array("slug","title","settings_id"));
$all_field_slug = array();
for($i=0;$i<count($avail_fields);$i++)
{
    array_push($all_field_slug,$avail_fields[$i]['slug']);
}
?>
<script>
    function custom_attachment()
    {
        if(document.getElementById('custom-attachment-folder-enable').checked)
            document.getElementById('custom-attachment-path').style.display="block";
        else
            document.getElementById('custom-attachment-path').style.display="none";
    }
    function enable_api_click()
    {
        if(document.getElementById('enable_api').checked)
            document.getElementById('api_key').style.display="block";
        else
            document.getElementById('api_key').style.display="none";
    };
</script>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="default_assignee" style="padding-right:1em !important;"><?php _e('Default Assignee','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Choose default assignee for new tickets','wsdesk'); ?></span>
        <select id="default_assignee" style="width: 100% !important;display: inline !important" class="form-control" aria-describedby="helpBlock">
            <?php 
                $assignee = eh_crm_get_settingsmeta('0', "default_assignee");
                $tag_selected = '';
                $no_assignee = '';
                $vendor_selected = '';
                switch($assignee)
                {
                    case 'ticket_tags':
                        $tag_selected = 'selected';
                        $no_assignee = '';
                        $vendor_selected = '';
                        break;
                    case 'no_assignee':
                        $tag_selected = '';
                        $no_assignee = 'selected';
                        $vendor_selected = '';
                        break;
                    case 'ticket_vendors':
                        $tag_selected = '';
                        $no_assignee = '';
                        $vendor_selected = 'selected';
                        break;
                }
                if(EH_CRM_WOO_STATUS)
                {
                    $vendor_roles = eh_crm_get_settingsmeta(0, "woo_vendor_roles");
                    if(!$vendor_roles)
                    {
                        $vendor_roles = array();
                    }
                    if(!in_array("woo_vendors", $all_field_slug) && !empty($vendor_roles))
                    {
                        echo '<option value="ticket_vendors" '.$vendor_selected.'>'.__('Depends on Vendors','wsdesk').'</option>';
                    }
                }
                echo '
                <option value="ticket_tags" '.$tag_selected.'>'.__('Depends on Ticket Tags','wsdesk').'</option>
                <option value="no_assignee" '.$no_assignee.'>'.__('No Assignee','wsdesk').'</option>';
                foreach ($users as $key => $value) {
                    echo '<optgroup label="'.$key.'">';
                    foreach ($value as $id => $name)
                    {
                        $selected = '';
                        if($assignee == $id)
                        {
                            $selected = 'selected';
                        }
                        echo '<option value="'.$id.'" '.$selected.'>'.$name.'</option>';
                    }
                    echo "</optgroup>";
                }
            ?>
        </select>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="default_label" style="padding-right:1em !important;"><?php _e('Default Status','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Choose default status for new tickets/raiser replies','wsdesk'); ?></span>
        <select id="default_label" style="width: 100% !important;display: inline !important" class="form-control" aria-describedby="helpBlock">
            <?php 
                $label= eh_crm_get_settingsmeta('0', "default_label");
                for($i=0;$i<count($avail_labels);$i++)
                {
                    $selected = '';
                    if($label === $avail_labels[$i]['slug'])
                    {
                        $selected = 'selected';
                    }
                    echo '<option value="'.$avail_labels[$i]['slug'].'" '.$selected.'>'.$avail_labels[$i]['title'].'</option>';
                }
            ?>
        </select>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="ticket_raiser" style="padding-right:1em !important;"><?php _e('Tickets Raisers','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Who can raise the tickets?','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $ticket_raiser = eh_crm_get_settingsmeta('0', "ticket_raiser");
                $all = '';
                $registered = '';
                $guest = '';
                switch ($ticket_raiser) {
                    case "all":
                        $all = 'checked';
                        $registered = '';
                        $guest = '';
                        break;
                    case "registered":
                        $all = '';
                        $registered = 'checked';
                        $guest = '';
                        break;
                    case "guest":
                        $all = '';
                        $registered = '';
                        $guest = 'checked';
                        break;
                }
            ?>
            <input type="radio" style="margin-top: 0;" id="ticket_raiser" class="form-control" name="ticket_raiser" <?php echo $all; ?> value="all"> <?php _e('All','wsdesk'); ?><br>
            <input type="radio" style="margin-top: 0;" id="ticket_raiser" class="form-control" name="ticket_raiser" <?php echo $registered; ?> value="registered"> <?php _e('Registered Users','wsdesk'); ?><br>
            <input type="radio" style="margin-top: 0;" id="ticket_raiser" class="form-control" name="ticket_raiser" <?php echo $guest; ?> value="guest"> <?php _e('Guest Users','wsdesk'); ?>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="agent_ticket_section" style="padding-right:1em !important;"><?php _e('Agents Ticket Section','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Allow an agent to see other agents tickets in the Tickets dashboard.','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $allow_agent_tickets = eh_crm_get_settingsmeta('0', "allow_agent_tickets");
                $enable = '';
                switch ($allow_agent_tickets) {
                    case "disable":
                        $enable = '';
                        break;
                    default:
                        $enable = 'checked';
                        break;
                }
            ?>
            <input type="checkbox" <?php echo $enable; ?> style="margin-top: 0;" id="allow_agent_tickets" class="form-control" name="allow_agent_tickets" value="enable"> <?php _e('Enable','wsdesk'); ?><br>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="ticket_display_row" style="padding-right:1em !important;"><?php _e('Tickets Row','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Number of tickets per page','wsdesk'); ?></span>
        <input type="text" id="ticket_display_row" placeholder="25" value="<?php echo $ticket_rows; ?>" class="form-control crm-form-element-input"  oninput="validity.valid||(value='');" pattern="[0-9]+">
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="auto_assign" style="padding-right:1em !important;"><?php _e('Auto Assign Tickets','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Want to auto assign tickets to the replier if the ticket is unassigned?','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $auto_assign = eh_crm_get_settingsmeta('0', "auto_assign");
                $enable = '';
                $disable = '';
                switch ($auto_assign) {
                    case "enable":
                        $enable = 'checked';
                        $disable = '';
                        break;
                    default:
                        $enable = '';
                        $disable = 'checked';
                        break;
                }
            ?>
            <input type="radio" <?php echo $enable; ?> style="margin-top: 0;" id="auto_assign" class="form-control" name="auto_assign" value="enable"> <?php _e('Enable','wsdesk'); ?><br>
            <input type="radio" <?php echo $disable; ?> style="margin-top: 0;" id="auto_assign" class="form-control" name="auto_assign" value="disable"> <?php _e('Disable','wsdesk'); ?><br>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="auto_suggestion" style="padding-right:1em !important;"><?php _e('Auto Suggestion','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Want to enable auto suggestion for agent and ticket raisers?','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $auto_suggestion = eh_crm_get_settingsmeta('0', "auto_suggestion");
                $enable = '';
                $disable = '';
                switch ($auto_suggestion) {
                    case "enable":
                        $enable = 'checked';
                        $disable = '';
                        break;
                    case "disable":
                        $enable = '';
                        $disable = 'checked';
                        break;
                }
            ?>
            <input type="radio" <?php echo $enable; ?> style="margin-top: 0;" id="auto_suggestion" class="form-control" name="auto_suggestion" value="enable"> <?php _e('Enable','wsdesk'); ?><br>
            <input type="radio" <?php echo $disable; ?> style="margin-top: 0;" id="auto_suggestion" class="form-control" name="auto_suggestion" value="disable"> <?php _e('Disable','wsdesk'); ?><br>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="excerpt_in_auto_suggestion" style="padding-right:1em !important;"><?php _e('Show Excerpt on Auto-Suggestion','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Enable this option to show excerpt instead of first sentence of the post while displaying auto-suggestion.','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
           <?php 
                $show_excerpt_in_auto_suggestion = eh_crm_get_settingsmeta('0', "show_excerpt_in_auto_suggestion");
                $enable = '';
                switch ($show_excerpt_in_auto_suggestion) {
                    case "enable":
                        $enable = 'checked';
                        break;
                    default:
                        $enable = '';
                        break;
                }
            ?>
            <input type="checkbox" <?php echo $enable; ?> style="margin-top: 0;" id="show_excerpt_in_auto_suggestion" class="form-control" name="show_excerpt_in_auto_suggestion" value="enable"> <?php _e('Enable','wsdesk'); ?><br>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="custom-attachment-folder" style="padding-right:1em !important;"><?php _e('Custom Attachment Folder','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Want to enable custom folder for attachments?','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $custom_attachment_enable = eh_crm_get_settingsmeta('0', "custom_attachment_folder_enable");
                $custom_attachment_path = eh_crm_get_settingsmeta('0', "custom_attachment_folder_path");
                $enable = '';
                $disable = '';
                switch ($custom_attachment_enable) {
                    case "yes":
                        $enable = 'checked';
                        $disable = '';
                        $path = 'block';
                        break;
                   default:
                        $enable = '';
                        $disable = 'checked';
                        $path = 'none';
                }
            ?>
            <input type="radio" <?php echo $enable; ?> style="margin-top: 0;" onclick="custom_attachment();" id="custom-attachment-folder-enable" class="form-control" name="custom_attachment" value="yes"> <?php _e('Enable','wsdesk'); ?><br>
            <input type="radio" <?php echo $disable; ?> style="margin-top: 0;" onclick="custom_attachment();" id="custom-attachment-folder-disable" class="form-control" name="custom_attachment" value="no"> <?php _e('Disable','wsdesk'); ?><br>
            <div id="custom-attachment-path" style="display: <?=$path?>">
                <span class="help-block"><?php _e('Path:','wsdesk'); ?></span> 
                <?=ABSPATH?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("Please make sure the location exists.", 'wsdesk'); ?>" data-container="body"></span><input type="text" id="custom_attachment_path" placeholder="wp-content/uploads" value="<?php echo $custom_attachment_path; ?>" class="form-control crm-form-element-input">
            </div>

        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <?php
    $max_file_size=eh_crm_get_settingsmeta('0','max_file_size');
    ?>
    <div class="col-md-3">
        <label for="custom-attachment-folder" style="padding-right:1em !important;"><?php _e('Maximum file size of attachments (MB)','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('You can set maximum size of the attachments','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("Default value: 1MB. Decimal values are allowed.", 'wsdesk'); ?>" data-container="body"></span></span>
        <input type="number" id="max_file_size" placeholder="1" min='0' value="<?=$max_file_size?>" class="form-control crm-form-element-input">
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="custom-attachment-folder" style="padding-right:1em !important;"><?php _e('Valid Attachment Extensions','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Select File Extensions','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("Select nothing to make all extensions valid.", 'wsdesk'); ?>" data-container="body"></span></span>
        <script>
            jQuery("#file-extension-select").select2({
                width: '100%',
                minimumResultsForSearch: -1
            });
        </script>
         <span style="vertical-align: middle;">
            <select class="file-extension" id='file-extension-select' name="ext[]" multiple="multiple">
                <?php
                    $valid_exts=eh_crm_get_settingsmeta('0', 'valid_file_extension');
                    $valid_exts=explode(',', $valid_exts);
                    $exts=array(
                        'jpg'  => 'JPG',
                        'jpeg' => 'JPEG',
                        'png'  => 'PNG',
                        'gif'  => 'GIF',
                        'pdf'  => 'PDF',
                        'docx' => 'DOCX',
                        'txt'  => 'TXT',
                        'zip'  => 'ZIP',
                        'xml'  => 'XML',
                        'csv'  => 'CSV',
                        'mp3'  => 'MP3',
                        'mp4'  => 'MP4',
                        'xlsx' => 'XLSX',
                        '3gp'  => '3GP',
                        'avi'  => 'AVI',
                        'wmv'  => 'WMV',
                        'mpg'  => 'MPG',
                        'mov'  => 'MOV',
                        'flv'  => 'FLV',
                        'syx'  => 'SYX',
                        'rtf'  => 'RTF'
                    );
                    foreach( $exts as $key=>$ext)
                    {

                        if(in_array($key, $valid_exts))
                        {
                            ?>
                            <option value="<?=$key?>" selected><?=$ext?></option>
                            <?php
                        }
                        else
                        {   
                            ?>
                            <option value="<?=$key?>"><?=$ext?></option>
                            <?php
                        }
                    }
                ?>
            </select>
         </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="auto_create_user" style="padding-right:1em !important;"><?php _e('Create WordPress User','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Create wordpress user while guest user submitting the tickets through the form','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $auto_create_user = eh_crm_get_settingsmeta('0', "auto_create_user");
                $enable = '';
                switch ($auto_create_user) {
                    case "enable":
                        $enable = 'checked';
                        break;
                    default:
                        $enable = '';
                        break;
                }
            ?>
            <input type="checkbox" <?php echo $enable; ?> style="margin-top: 0;" id="auto_create_user" class="form-control" name="auto_create_user" value="enable"> <?php _e('Enable','wsdesk'); ?><br>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="close_tickets" style="padding-right:1em !important;"><?php _e('Close Tickets','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Allow users to close the tickets they submitted','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $close_tickets = eh_crm_get_settingsmeta('0', "close_tickets");
                switch ($close_tickets) 
                {
                    case "disable":
                        $enable = '';
                        break;
                    default:
                        $enable = 'checked';
                        break;
                }
            ?>
            <input type="checkbox" <?php echo $enable; ?> style="margin-top: 0;" id="close_tickets" class="form-control" name="close_tickets" value="enable"> <?php _e('Enable','wsdesk'); ?><br>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="auto_assign" style="padding-right:1em !important;"><?php _e('Display Tickets As','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Enabling HTML option may lead to security issues. Resolving such issues are out of the scope of WSDesk plugin, hence we do not recommend this option.','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $tickets_display = eh_crm_get_settingsmeta('0', "tickets_display");
                $text = '';
                $html = '';
                switch ($tickets_display) {
                    case "text":
                        $text = 'checked';
                        break;
                    default:
                        $html = 'checked';
                        break;
                }
            ?>
            <input type="radio" <?php echo $html; ?> style="margin-top: 0;" id="tickets_display" class="form-control" name="tickets_display" value="html"> <?php _e('HTML','wsdesk'); ?><br>
            <input type="radio" <?php echo $text; ?> style="margin-top: 0;" id="tickets_display" class="form-control" name="tickets_display" value="text"> <?php _e('Text','wsdesk'); ?><br>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="auto_create_user" style="padding-right:1em !important;"><?php _e('WSDesk API','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Create tickets via API from any website','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php
                $api_key = eh_crm_get_settingsmeta('0', "api_key");
                if(empty($api_key))
                    $api_key=md5(time().EH_CRM_MAIN_URL);
                $auto_create_user = eh_crm_get_settingsmeta('0', "enable_api");
                $enable = '';
                switch ($auto_create_user) {
                    case "enable":
                        $enable = 'checked';
                        $path = 'block';
                        break;
                    default:
                        $enable = '';
                        $path = 'none';
                        break;
                }
            ?>
            <input type="checkbox" <?php echo $enable; ?> style="margin-top: 0;" id="enable_api" onclick="enable_api_click();" class="form-control" name="enable_api" value="enable"> <?php _e('Enable API','wsdesk'); ?><br>

            <div id="api_key" style="display: <?=$path?>">
                <span class="help-block"><?php _e('API Key:','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("Please share this API Key only with trusted sources.", 'wsdesk'); ?>" data-container="body"></span></span> 
                <input type="text" id="api_key_textbox" value="<?php echo $api_key; ?>" class="form-control crm-form-element-input">
            </div>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="custom-attachment-folder" style="padding-right:1em !important;"><?php _e('Default Deep Link','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <?php
        $default_deep_link = eh_crm_get_settingsmeta('0', 'default_deep_link');
        ?>
        <span class="help-block"><?php _e('Add a default deep link here','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <span class="help-block"><?php _e('Path: '.admin_url().'admin.php?page=wsdesk_tickets&','wsdesk'); ?></span> 
            <input type="text" id="default_deep_link" placeholder="view=all" value="<?php echo $default_deep_link; ?>" class="form-control crm-form-element-input">
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="custom-attachment-folder" style="padding-right:1em !important;"><?php _e('Debug Mode','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Enable this option to place debug logs in PHP error log file','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $wsdesk_debug_status = eh_crm_get_settingsmeta('0', "wsdesk_debug_status");
                $debug_enable = '';
                switch ($wsdesk_debug_status) {
                    case "enable":
                        $debug_enable = 'checked';
                        break;
                    default:
                        $debug_enable = '';
                        break;
                }
            ?>
            <input type="checkbox" <?php echo $debug_enable; ?> style="margin-top: 0;" id="wsdesk_debug_email" class="form-control" name="wsdesk_debug_email" value="enable"> <?php _e('Enable','wsdesk'); ?><br>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="custom-attachment-folder" style="padding-right:1em !important;"><?php _e('Redirect URLs','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span><?php _e('Redirect users to a particular URL after submitting a ticket or logging in or registering or logging out from WSDesk Support Page.','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $login_redirect_url = eh_crm_get_settingsmeta('0', "login_redirect_url");
                $logout_redirect_url = eh_crm_get_settingsmeta('0', "logout_redirect_url");
                $register_redirect_url = eh_crm_get_settingsmeta('0', "register_redirect_url");
                $submit_ticket_redirect_url = eh_crm_get_settingsmeta('0', "submit_ticket_redirect_url");
            ?>
            <span class="help-block"><?php _e('Login Redirect URL','wsdesk'); ?></span>
            <input type="text" id="login_redirect_url" class="form-control crm-form-element-input" value="<?php echo $login_redirect_url; ?>">
            <span class="help-block"><?php _e('Logout Redirect URL','wsdesk'); ?></span>
            <input type="text" id="logout_redirect_url" class="form-control crm-form-element-input" value="<?php echo $logout_redirect_url; ?>">
            <span class="help-block"><?php _e('Register Redirect URL','wsdesk'); ?></span>
            <input type="text" id="register_redirect_url" class="form-control crm-form-element-input" value="<?php echo $register_redirect_url; ?>">
             <span class="help-block"><?php _e('Submit Ticket Redirect URL','wsdesk'); ?></span>
            <input type="text" id="submit_ticket_redirect_url" class="form-control crm-form-element-input" value="<?php echo $submit_ticket_redirect_url; ?>">
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="existing-tickets-page-label" style="padding-right:1em !important;"><?php _e('Existing Tickets Page Labels','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('You can set the labels displayed to unregistered users when they visit exisiting tickets page here.','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $exisiting_tickets_login_label = eh_crm_get_settingsmeta('0', "exisiting_tickets_login_label");
                if(empty($exisiting_tickets_login_label))
                {
                    $exisiting_tickets_login_label = __('You must Login to Check your Existing Ticket', 'wsdesk');
                }
                $exisiting_tickets_register_label = eh_crm_get_settingsmeta('0', "exisiting_tickets_register_label");
                if(empty($exisiting_tickets_register_label))
                {
                    $exisiting_tickets_register_label = __('Need an Account?', 'wsdesk');
                }
            ?>
            <span class="help-block"><?php _e('Login Label','wsdesk'); ?></span>
            <input type="text" id="exisiting_tickets_login_label" class="form-control crm-form-element-input" value="<?php echo $exisiting_tickets_login_label; ?>">
            <span class="help-block"><?php _e('Register Label','wsdesk'); ?></span>
            <input type="text" id="exisiting_tickets_register_label" class="form-control crm-form-element-input" value="<?php echo $exisiting_tickets_register_label; ?>">
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="custom-attachment-folder" style="padding-right:1em !important;"><?php _e('Powered by WSDesk Tag','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Disabling this option will remove Powered by WSDesk Tag from front end and all support E-mails.','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $wsdesk_powered_by_status = eh_crm_get_settingsmeta('0', "wsdesk_powered_by_status");
                switch ($wsdesk_powered_by_status) {
                    case "disable":
                        $wsdesk_powered_by_status_checked = '';
                        break;
                    default:
                        $wsdesk_powered_by_status_checked = 'checked';
                        break;
                }
            ?>
            <input type="checkbox" <?php echo $wsdesk_powered_by_status_checked; ?> style="margin-top: 0;" id="wsdesk_powered_by_status" class="form-control" name="wsdesk_powered_by_status" value="enable"> <?php _e('Enable','wsdesk'); ?><br>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="linkify-url" style="padding-right:1em !important;"><?php _e('Convert URLs to Hyperlinks','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Enabling this option will convert all URLs in ticket conversation to hyperlinks. (BETA)','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $linkify_urls = eh_crm_get_settingsmeta('0', "linkify_urls");
                switch ($linkify_urls) {
                    case "enable":
                        $linkify_urls_checked = 'checked';
                        break;
                    default:
                        $linkify_urls_checked = '';
                        break;
                }
            ?>
            <input type="checkbox" <?php echo $linkify_urls_checked; ?> style="margin-top: 0;" id="linkify_urls" class="form-control" name="linkify_urls" value="enable"> <?php _e('Enable','wsdesk'); ?><br>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-12">
        <button type="button" id="save_general" class="btn btn-primary btn-sm"> <span class="glyphicon glyphicon-ok"></span> <?php _e('Save Changes','wsdesk'); ?></button>
    </div>
</div>
<?php
return ob_get_clean();