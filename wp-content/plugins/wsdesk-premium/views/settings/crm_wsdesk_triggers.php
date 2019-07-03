<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$avail_triggers = eh_crm_get_settings(array("type" => "trigger"),array("slug","title","settings_id"));
$selected_triggers = eh_crm_get_settingsmeta("0", "selected_triggers");
$avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title", "settings_id"));
if(empty($selected_triggers))
{
    $selected_triggers = array();
}
if(!$avail_triggers && empty($avail_triggers))
{
    $avail_triggers = array();
}
$tscript    = eh_crm_get_trigger_data();
$tascript   = eh_crm_get_trigger_action_data();
$toptions   = $tscript['options'];
$taoptions  = $tascript['options'];
unset($tscript['options']);
unset($tascript['options']);
?>
<div class="crm-form-element">
    <div class="col-md-12">
        <div style="vertical-align: middle">
            <label for="ticket_triggers" style="padding-right:1em !important;"><?php _e('Triggers & Automations','wsdesk'); ?></label>
            <button type="button" id="ticket_trigger_add_button" class="btn btn-primary btn-xs pull-right"> <span class="glyphicon glyphicon-plus"></span> <?php _e('Add Trigger','wsdesk'); ?></button>
        </div>
        <div class="panel panel-default crm-panel" style="margin-top: 15px !important;margin-bottom: 0px !important;">
            <div class="panel-body" style="padding: 5px !important;">
                <div class="col-sm-6" style="padding-right: 5px !important;padding-left: 5px !important;">
                    <span class="col-md-12" style="text-align: center;padding: 5px 0px;"><?php _e('Inactive Trigger','wsdesk'); ?></span><br>
                    <ul class="list-group">
                    <?php
                            if((count($avail_triggers) == 0) || (count($avail_triggers) == count($selected_triggers)) )
                            {
                                echo '<li class="list-group-item list-group-item-info">'.__('No inactive trigger','wsdesk').'</li>';
                            }
                            else
                            {
                                for($i=0;$i<count($avail_triggers);$i++)
                                {
                                    if(!in_array($avail_triggers[$i]['slug'], $selected_triggers))
                                    {
                                        echo '<li class="list-group-item list-group-item-info" id="'.$avail_triggers[$i]['slug'].'"> '.$avail_triggers[$i]['title'].' <span class="pull-right">';
                                        echo '<span style="margin-right:5px; cursor:pointer; text-decoration:underline" class="ticket_trigger_activate" id="'.$avail_triggers[$i]['slug'].'">'.__('Activate','wsdesk').'</span> ';
                                        echo '<span class="glyphicon glyphicon-trash ticket_trigger_delete_type" id="'.$avail_triggers[$i]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Delete Trigger','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span> ';
                                        echo '<span class="glyphicon glyphicon-pencil ticket_trigger_edit_type" id="'.$avail_triggers[$i]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Edit Trigger','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span> ';
                                        echo '</span></li>';
                                    }
                                }
                            }
                    ?>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <span class="col-md-12" style="text-align: center;padding: 5px 0px;"><?php _e('Active Trigger','wsdesk'); ?></span><br>
                    <ul class="list-group list-group-sortable-connected list-group-trigger-data list-border-settings">
                    <?php
                        if(count($selected_triggers) == 0)
                        {
                            echo '<li class="list-group-item list-group-item-success">'.__('No active Trigger','wsdesk').'</li>';
                        }
                        else
                        {
                            for($i=0;$i<count($selected_triggers);$i++)
                            {
                                for($j=0;$j<count($avail_triggers);$j++)
                                {
                                    if($avail_triggers[$j]['slug'] === $selected_triggers[$i])
                                    {
                                        echo '<li class="list-group-item list-group-item-success" style="padding: 10px 10px !important;" id="'.$avail_triggers[$j]['slug'].'">'.$avail_triggers[$j]['title'].' <span class="pull-right">';
                                        echo '<span style="margin-right:5px; cursor:pointer; text-decoration:underline" class="ticket_trigger_deactivate" id="'.$avail_triggers[$j]['slug'].'">'.__('Deactivate','wsdesk').'</span> ';
                                        echo '<span class="glyphicon glyphicon-trash ticket_trigger_delete_type" id="'.$avail_triggers[$j]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Delete Trigger','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span> ';
                                        echo '<span class="glyphicon glyphicon-pencil ticket_trigger_edit_type" id="'.$avail_triggers[$j]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Edit Trigger','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span> ';
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
<div id="ticket_trigger_add_display" style="display: none;">
    <span class="crm-divider"></span>
    <div class="crm-form-element">
        <div class="col-md-12">
            <div style="vertical-align: middle">
                <label for="trigger_add" style="padding-right:1em !important;"><?php _e('Add Trigger','wsdesk'); ?></label>
                <button type="button" id="ticket_trigger_cancel_add_button" class="btn btn-primary btn-xs pull-right"> <span class="glyphicon glyphicon-remove"></span> <?php _e('Cancel','wsdesk'); ?></button>
            </div>
            <span style="vertical-align: middle;" id="trigger_add_section">
                <input type="hidden" value="" id="add_new_trigger_yes">
                <span class="help-block"><?php _e('Enter Details for New Trigger','wsdesk'); ?> </span>
                <input type="text" id="trigger_add_title" placeholder="<?php _e('Enter Title','wsdesk'); ?>" class="form-control crm-form-element-input">
                <span class="crm-divider"></span>
                <span><b><?php _e('Match Triggers Conditions','wsdesk'); ?></b></span>
                <span class="crm-divider"></span>
                <span class="help-block"><?php _e('Specify the Conditions Format.','wsdesk'); ?></span>
                <select id="trigger_add_format" style="width: 100% !important;display: inline !important" class="form-control trigger_add_format clickable" aria-describedby="helpBlock">
                    <option value="and"><?php _e('AND Condition','wsdesk'); ?></option>
                    <option value="or"><?php _e('OR Condition','wsdesk'); ?></option>
                </select>
                <span class="help-block"><?php _e('Specify the Trigger Conditions.','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title='<?php _e("\"Changed To\" condition works only for immediate schedules.", 'wsdesk'); ?>' data-container="body"></span></span>
                <div id="tconditions_all">
                    <div id="tconditions_1" class="specify_tconditions">
                        <span class="tcondition_title_span"><?php _e('Condition','wsdesk'); ?> 1</span>
                        <select id="tconditions_1_type" title="<?php _e('Trigger condition field','wsdesk'); ?>" style="width: 100% !important;display: inline !important" class="form-control tconditions_type clickable" aria-describedby="helpBlock">
                            <?php echo $toptions; ?>
                        </select>
                        <div id="tconditions_1_append"></div>
                    </div>
                </div>
                <div style="background-color: #ddd;padding: 10px;margin-top: 5px;">
                    <u><?php _e('Trigger Condition','wsdesk'); ?></u> : <br>
                    <span id="trigger_formula"></span>
                </div>
                <button class="button" id="trigger_add_tconditions_add" title="<?php _e('Add New Condition','wsdesk'); ?>" style="vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-plus"></span> <?php _e('Add Condition','wsdesk'); ?></button>
                <button class="button" id="trigger_add_tconditions_group_and" title="<?php _e('Group those with AND Condition','wsdesk'); ?>" style="background-color:skyblue; vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-link"></span> <?php _e('Group with AND','wsdesk'); ?></button>
                <button class="button" id="trigger_add_tconditions_group_or" title="<?php _e('Group those with OR Condition','wsdesk'); ?>" style="background-color:darkseagreen;vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-resize-horizontal"></span> <?php _e('Group with OR','wsdesk'); ?></button>
                <button class="button" id="trigger_add_tconditions_group_clear" title="<?php _e('Clear Groups','wsdesk'); ?>" style="background-color:orange;vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-remove"></span> <?php _e('Clear Groups','wsdesk'); ?></button>
                <span class="crm-divider"></span>
                <span><b><?php _e('Perform Triggers Actions','wsdesk'); ?></b></span>
                <span class="crm-divider"></span>
                <span class="help-block"><?php _e('Specify the Trigger Actions.','wsdesk'); ?></span>
                <div id="tactions_all">
                    <div id="tactions_1" class="specify_tactions">
                        <span class="taction_title_span"><?php _e('Action','wsdesk'); ?> 1</span>
                        <select id="tactions_1_type" title="<?php _e('Trigger Action field','wsdesk'); ?>" style="width: 100% !important;display: inline !important;margin:10px 0px;" class="form-control tactions_type clickable" aria-describedby="helpBlock">
                            <?php echo $taoptions; ?>
                        </select>
                        <div id="tactions_1_append"></div>
                    </div>
                </div>
                <button class="button" id="trigger_add_tactions_add" title="<?php _e('Add New Action','wsdesk'); ?>" style="vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-plus"></span> <?php _e('Add Action','wsdesk'); ?></button>
                <span class="crm-divider"></span>
                <span class="help-block"><?php _e('Specify the Triggering Period.','wsdesk'); ?></span>
                <select id="trigger_add_schedule" style="width: 100% !important;display: inline !important" class="form-control trigger_add_schedule clickable" aria-describedby="helpBlock">
                    <option value=""><?php _e('Immediate Schedule','wsdesk'); ?></option>
                    <option value="min"><?php _e('Minute Schedule','wsdesk'); ?></option>
                    <option value="hour"><?php _e('Hour Schedule','wsdesk'); ?></option>
                    <option value="day"><?php _e('Day Schedule','wsdesk'); ?></option>
                    <option value="week"><?php _e('Week Schedule','wsdesk'); ?></option>
                    <option value="month"><?php _e('Month Schedule','wsdesk'); ?></option>
                    <option value="year"><?php _e('Year Schedule','wsdesk'); ?></option>
                </select>
                <span id="trigger_schedule_append"></span>
            </span>
            <script type="text/javascript">
                <?php
                    $selected_fields = eh_crm_get_settingsmeta(0, "selected_fields");
                    if(empty($selected_fields))
                    {
                        $selected_fields = array();
                    }
                    $print = array();
                    foreach ($avail_fields as $field) {
                        if($field['slug'] === 'google_captcha' || !in_array($field['slug'], $selected_fields))
                        {
                            continue;
                        }
                        $field_type = eh_crm_get_settingsmeta($field['settings_id'], 'field_type');
                        $print['['.$field['slug'].']'] = ($field_type == 'file')?__('(Attachment) ', 'wsdesk'): '';
                        $print['['.$field['slug'].']'] .=__("To insert ", 'wsdesk').' '.$field['title'].' '.__("field value in the template", 'wsdesk');
                    }
                ?>
                var shortvalues = <?php echo json_encode($print); ?>;
                var tvalues = <?php echo json_encode($tscript); ?>;
                jQuery("#triggers_tab").on("change",".tconditions_type",function(){
                    if(jQuery(this).val() !== "")
                    {
                        triggers_condition_maker(tvalues[jQuery(this).val()],jQuery(this).parent().prop("id"));
                    }
                    else
                    {
                        var parent_id = jQuery(this).parent().prop("id");
                        jQuery("#"+parent_id+"_append").empty();
                    }
                });
                var tavalues = <?php echo json_encode($tascript); ?>;
                jQuery("#triggers_tab").on("change",".tactions_type",function(){
                    if(jQuery(this).val() !== "")
                    {
                        triggers_action_maker(tavalues[jQuery(this).val()],jQuery(this).parent().prop("id"));
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
<div id="ticket_trigger_edit_display" style="display: none;">
    <span class="crm-divider"></span>
    <div class="crm-form-element">
        <div class="col-md-12">
            <div style="vertical-align: middle">
                <label for="trigger_edit" style="padding-right:1em !important;"><?php _e('Edit Trigger','wsdesk'); ?></label>
                <button type="button" id="ticket_trigger_cancel_edit_button" class="btn btn-primary btn-xs pull-right"> <span class="glyphicon glyphicon-remove"></span> <?php _e('Cancel','wsdesk'); ?></button>
            </div>
            <input type="hidden" value="" id="trigger_edit_type">
            <span style="vertical-align: middle;" id="trigger_edit_append"></span>
        </div>
    </div>
</div>
<div class="crm-form-element">
    <div class="col-md-12">
        <button type="button" id="save_triggers" class="btn btn-primary btn-sm"> <span class="glyphicon glyphicon-ok"></span> <?php _e('Save Changes','wsdesk'); ?></button>
    </div>
</div>
<?php
return ob_get_clean();
