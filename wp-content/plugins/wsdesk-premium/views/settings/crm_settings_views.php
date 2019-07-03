<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$avail_views = eh_crm_get_settings(array("type" => "view"),array("slug","title","settings_id"));
$selected_views = eh_crm_get_settingsmeta("0", "selected_views");
if(empty($selected_views))
{
    $selected_views = array();
}
$vscript = eh_crm_get_view_data();
$options=$vscript['options'];
unset($vscript['options']);
$group_by = $vscript['group'];
unset($vscript['group']);
?>
<div class="crm-form-element">
    <div class="col-md-12">
        <div style="vertical-align: middle">
            <label for="ticket_views" style="padding-right:1em !important;"><?php _e('Ticket Views','wsdesk'); ?></label>
            <button type="button" id="ticket_view_add_button" class="btn btn-primary btn-xs pull-right"> <span class="glyphicon glyphicon-plus"></span> <?php _e('Add View','wsdesk'); ?></button>
        </div>
        <div class="panel panel-default crm-panel" style="margin-top: 15px !important;margin-bottom: 0px !important;">
            <div class="panel-body" style="padding: 5px !important;">
                <div class="col-sm-6" style="padding-right: 5px !important;padding-left: 5px !important;">
                    <span class="col-md-12" style="text-align: center;padding: 5px 0px;"><?php _e('Inactive View','wsdesk'); ?></span><br>
                    <ul class="list-group">
                    <?php
                            if((count($avail_views) == count($selected_views)) )
                            {
                                echo '<li class="list-group-item list-group-item-info">'.__('No inactive view','wsdesk').'</li>';
                            }
                            else
                            {
                                for($i=0;$i<count($avail_views);$i++)
                                {
                                    if(!in_array($avail_views[$i]['slug'], $selected_views))
                                    {
                                        echo '<li class="list-group-item list-group-item-info" id="'.$avail_views[$i]['slug'].'"> '.$avail_views[$i]['title'].' <span class="pull-right">';
                                        echo '<span style="margin-right:5px; cursor:pointer; text-decoration:underline" class="ticket_view_activate" id="'.$avail_views[$i]['slug'].'">'.__('Activate','wsdesk').'</span> ';
                                        if(!in_array($avail_views[$i]['slug'],array("labels_view","agents_view","tags_view","users_view")))
                                        {
                                            echo '<span class="glyphicon glyphicon-trash ticket_view_delete_type" id="'.$avail_views[$i]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Delete View','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span> ';
                                        }
                                        if(!in_array($avail_views[$i]['slug'],array("labels_view","agents_view","tags_view","users_view")))
                                        {
                                            echo '<span class="glyphicon glyphicon-pencil ticket_view_edit_type" id="'.$avail_views[$i]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Edit View','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span> ';
                                        }
                                        echo '</span></li>';
                                    }
                                }
                            }
                    ?>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <span class="col-md-12" style="text-align: center;padding: 5px 0px;"><?php _e('Active View','wsdesk'); ?></span><br>
                    <ul class="list-group list-group-sortable-connected list-group-view-data list-border-settings">
                    <?php
                        if(count($selected_views) == 0)
                        {
                            echo '<li class="list-group-item list-group-item-success">'.__('No active view','wsdesk').'</li>';
                        }
                        else
                        {
                            for($i=0;$i<count($selected_views);$i++)
                            {
                                for($j=0;$j<count($avail_views);$j++)
                                {
                                    if($avail_views[$j]['slug'] === $selected_views[$i])
                                    {
                                        echo '<li class="list-group-item list-group-item-success" style="padding: 10px 10px !important;" id="'.$avail_views[$j]['slug'].'"><span class="dashicons dashicons-menu" style="cursor:move;margin-right:5px;"></span> '.$avail_views[$j]['title'].' <span class="pull-right">';
                                        echo '<span style="margin-right:5px; cursor:pointer; text-decoration:underline" class="ticket_view_deactivate" id="'.$avail_views[$j]['slug'].'">'.__('Deactivate','wsdesk').'</span> ';
                                        if(!in_array($avail_views[$j]['slug'],array("labels_view","agents_view","tags_view","users_view")))
                                        {
                                            echo '<span class="glyphicon glyphicon-trash ticket_view_delete_type" id="'.$avail_views[$j]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Delete View','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span> ';
                                        }
                                        if(!in_array($avail_views[$j]['slug'],array("labels_view","agents_view","tags_view","users_view")))
                                        {
                                            echo '<span class="glyphicon glyphicon-pencil ticket_view_edit_type" id="'.$avail_views[$j]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Edit View','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span> ';
                                        }
                                        echo '</span></li>';
                                    }
                                }

                            }
                        }
                    ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="ticket_view_add_display" style="display: none;">
    <span class="crm-divider"></span>
    <div class="crm-form-element">
        <div class="col-md-12">
            <div style="vertical-align: middle">
                <label for="ticket_view_add" style="padding-right:1em !important;"><?php _e('Add Ticket View','wsdesk'); ?></label>
                <button type="button" id="ticket_view_cancel_add_button" class="btn btn-primary btn-xs pull-right"> <span class="glyphicon glyphicon-remove"></span> <?php _e('Cancel','wsdesk'); ?></button>
            </div>
            <span style="vertical-align: middle;" id="ticket_view_add_section">
                <input type="hidden" value="" id="add_new_view_yes">
                <span class="help-block"><?php _e('Enter Details for New View','wsdesk'); ?> </span>
                <input type="text" id="ticket_view_add_title" placeholder="Enter Title" class="form-control crm-form-element-input">
                <span class="help-block"><?php _e('Specify the Conditions Format','wsdesk'); ?></span>
                <select id="ticket_view_add_format" style="width: 100% !important;display: inline !important" class="form-control ticket_view_add_format clickable" aria-describedby="helpBlock">
                    <option value="and"><?php _e('AND Condition','wsdesk'); ?></option>
                    <option value="or"><?php _e('OR Condition','wsdesk'); ?></option>
                </select>
                <span class="help-block"><?php _e('Specify the View Conditions','wsdesk'); ?></span>
                <div id="conditions_all">
                    <div id="conditions_1" class="specify_conditions">
                        <span class="condition_title_span"><?php _e('Condition','wsdesk'); ?> 1</span>
                        <select id="conditions_1_type" title="<?php _e('View condition field','wsdesk'); ?>" style="width: 100% !important;display: inline !important" class="form-control conditions_type clickable" aria-describedby="helpBlock">
                            <?php echo $options; ?>
                        </select>
                        <div id="conditions_1_append"></div>
                    </div>
                </div>
                <div style="background-color: #ddd;padding: 10px;margin-top: 5px;">
                    <u><?php _e('View Condition','wsdesk'); ?></u> : <br>
                    <span id="ticket_view_formula"></span>
                </div>
                <button class="button" id="ticket_view_add_conditions_add" title="<?php _e('Add New Condition','wsdesk'); ?>" style="vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-plus"></span> <?php _e('Add Conditions','wsdesk'); ?></button>
                <button class="button" id="ticket_view_add_conditions_group_and" title="<?php _e('Group those with AND Condition','wsdesk'); ?>" style="background-color:skyblue; vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-link"></span> <?php _e('Group with AND','wsdesk'); ?></button>
                <button class="button" id="ticket_view_add_conditions_group_or" title="<?php _e('Group those with OR Condition','wsdesk'); ?>" style="background-color:darkseagreen;vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-resize-horizontal"></span> <?php _e('Group with OR','wsdesk'); ?></button>
                <button class="button" id="ticket_view_add_conditions_group_clear" title="<?php _e('Clear Groups','wsdesk'); ?>" style="background-color:orange;vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-remove"></span> <?php _e('Clear Groups','wsdesk'); ?></button>
                <span class="help-block"><?php _e('Group tickets by:','wsdesk'); ?></span>
                <select id="group_by_view_add" title="<?php _e('View Group By','wsdesk'); ?>" style="width: 100% !important;margin-bottom: 10px;display: inline !important" class="form-control group_by_view_add clickable" aria-describedby="helpBlock">
                    <?php echo $group_by; ?>
                </select>
                <span class="help-block"><?php _e('Display this view to:','wsdesk'); ?> </span>
                <input type="checkbox" style="margin-top: 0;"  id="ticket_view_display_control" checked class="form-control" name="ticket_view_display_control" value="administrator"> Administrator
                <input type="checkbox" style="margin-top: 0;" id="ticket_view_display_control" class="form-control" name="ticket_view_display_control" value="WSDesk_Agents"> WSDesk Agents
                <input type="checkbox" style="margin-top: 0;" id="ticket_view_display_control" class="form-control" name="ticket_view_display_control" value="WSDesk_Supervisor"> WSDesk Supervisors
            </span>
            <script type="text/javascript">
                var values = <?php echo json_encode($vscript); ?>;
                jQuery("#ticket_views_tab").on("change",".conditions_type",function(){
                    if(jQuery(this).val() !== "")
                    {
                        views_condition_maker(values[jQuery(this).val()],jQuery(this).parent().prop("id"));
                    }
                    else
                    {
                        var parent_id = jQuery(this).parent().prop("id");
                        jQuery("#"+parent_id+"_append").empty();
                    }
                });
            </script>
        </div>
    </div>
</div>
<div id="ticket_view_edit_display" style="display: none;">
    <span class="crm-divider"></span>
    <div class="crm-form-element">
        <div class="col-md-12">
            <div style="vertical-align: middle">
                <label style="padding-right:1em !important;"><?php _e('Edit Ticket View','wsdesk'); ?></label>
                <button type="button" id="ticket_view_cancel_edit_button" class="btn btn-primary btn-xs pull-right"> <span class="glyphicon glyphicon-remove"></span> <?php _e('Cancel','wsdesk'); ?></button>
            </div>
            <input type="hidden" value="" id="ticket_view_edit_type">
            <span style="vertical-align: middle;" id="ticket_view_edit_append"></span>
        </div>
    </div>
</div>
<div class="crm-form-element">
    <div class="col-md-12">
        <button type="button" id="save_ticket_views" class="btn btn-primary btn-sm"> <span class="glyphicon glyphicon-ok"></span> <?php _e('Save Changes','wsdesk'); ?></button>
    </div>
</div>
<?php
return ob_get_clean();
