<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$vendor_roles = eh_crm_get_settingsmeta(0, "woo_vendor_roles")?eh_crm_get_settingsmeta(0, "woo_vendor_roles"):array();
$merged_roles = array_merge(array("editor","contributor","author","shop_manager"),$vendor_roles);
$users_data = get_users(array("role__in"=>$merged_roles,"role__not_in"=>array("WSDesk_Agents","WSDesk_Supervisor")));
$users = array();
$select = array();
for($i=0;$i<count($users_data);$i++)
{
    $current = $users_data[$i];
    $temp = array();
    $roles = $current->roles;
    foreach ($roles as $value) {
        $current_role = $value;
        $temp[$i] = ucfirst(str_replace("_", " ", $current_role));
    }
    $users[implode(' & ', $temp)][$current->ID] = $current->data->display_name;
    $select[$current->ID] = md5($current->data->user_email);
}
?>
<input type="hidden" id="user_key_hash" value='<?php echo json_encode($select);?>'>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="add_agents_select" style="padding-right:1em !important;">Add Users</label>
    </div>
    <div class="col-md-9">
        <span style="vertical-align: middle;">
            <input type="checkbox" style="margin-top: 0;" id="add_agent_create_user" class="form-control" name="add_agent_create_user" value="enable"> <?php _e('Create new user','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("Please note that “Customer” & “Subscriber” role is not eligible for adding as an “Agent”", 'wsdesk'); ?>" data-container="body"></span><br>
        </span>
        <div id="add_agents_select_display">
            <br>
            <select class="add_agents_select" multiple="multiple">
                <?php 
                foreach ($users as $key => $value) {
                    echo "<optgroup label=\"$key\">\n";
                    foreach ($value as $id => $name)
                    {
                        echo "<option value=\"$id\">$name</option>\n";
                    }
                    echo "</optgroup>\n";
                  }
                ?>
            </select>
        </div>
        <div id="add_agent_create_user_display" style="display: none;">
            <br>
            <div class="form-group">
                <label for="user-email" class="control-label" style="font-size: 15px;margin-bottom: 5px;"><?php _e('User Email','wsdesk');?></label>&nbsp;<div id="message_data" style="color:red;"></div>
                <input type="email" class="form-control" id="user_email" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="user-password" class="control-label" style="font-size: 15px;margin-bottom: 5px;"><?php _e('Password','wsdesk');?></label>
              <input type="password" class="form-control" id="user_password" autocomplete="off"/>
            </div>
        </div>
    </div>
</div>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="add_agents_role" style="padding-right:1em !important;">WSDesk Role</label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Roles for the selected users','wsdesk');?></span>
        <span style="vertical-align: middle;">
            <input type="radio" style="margin-top: 0;" class="form-control" id="add_agents_role" name="add_agents_role" value="agents" checked> WSDesk Agents<br>
            <input type="radio" style="margin-top: 0;" class="form-control" id="add_agents_role" name="add_agents_role" value="supervisor"> WSDesk Supervisor<br>
        </span>
    </div>
</div>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="add_agents_rights" style="padding-right:1em !important;">WSDesk Rights</label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('User(s) are entitled to the following rights','wsdesk');?></span>
        <span style="vertical-align: middle;" id="add_agents_access_rights">
            <input type="checkbox" style="margin-top: 0;" checked="checked" class="form-control" name="add_agents_rights" id="add_agents_rights_reply" value="reply"> <?php _e('Reply to Tickets','wsdesk');?><br>
            <input type="checkbox" style="margin-top: 0;" checked="checked" class="form-control" name="add_agents_rights" id="add_agents_rights_delete" value="delete"> <?php _e('Delete Tickets','wsdesk');?><br>
            <input type="checkbox" style="margin-top: 0;" checked="checked" class="form-control" name="add_agents_rights" id="add_agents_rights_manage" value="manage"><?php _e('Manage Tickets','wsdesk');?><br>
        </span>
    </div>
</div>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="add_agents_tags" style="padding-right:1em !important;"><?php _e('Add tags','wsdesk');?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Depending on the tags, the tickets will be assigned automatically to the default assignee','wsdesk');?></span>
        <select class="add_agents_tags" multiple="multiple">
        </select>
    </div>
</div>

<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-12">
        <button type="button" id="save_add_agents" class="btn btn-primary"> <span class="glyphicon glyphicon-ok"></span><?php _e('Save Changes','wsdesk');?></button>
        <button type="button" id="cancel_add_agents" class="btn btn-deafult"> <span class="glyphicon glyphicon-remove"></span> <?php _e('Cancel','wsdesk');?></button>
    </div>
</div>
<?php
return ob_get_clean();