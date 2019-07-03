<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$args = array("type" => "label");
$fields = array("slug","title","settings_id");
$avail_labels= eh_crm_get_settings($args,$fields);
?>
<div class="crm-form-element">
    <div class="col-md-12">
        <div style="vertical-align: middle">
            <label for="ticket_status" style="padding-right:1em !important;"><?php _e('Ticket Status','wsdesk'); ?></label> 
            <button type="button" id="ticket_label_add_button" class="btn btn-primary btn-xs pull-right"> <span class="glyphicon glyphicon-plus"></span> <?php _e('Add Status','wsdesk'); ?></button>
        </div>
        <ul class="list-group list-group-sortable-connected list-group-label-data">
            <?php
                if(!empty($avail_labels))
                {
                    for($i=0;$i<count($avail_labels);$i++)
                    {
                        $label_color = eh_crm_get_settingsmeta($avail_labels[$i]['settings_id'], "label_color");
                        echo '<li class="list-group-item list-group-item-success" style="padding: 10px 10px !important;" id="'.$avail_labels[$i]['slug'].'"> '.$avail_labels[$i]['title'].' <span class="badge" style="background-color:'.$label_color.' !important;">'.$label_color.'</span><span class="pull-right">';
                        if(!in_array($avail_labels[$i]['slug'],array('label_LL01','label_LL02','label_LL03')))
                        {
                            echo '<span class="glyphicon glyphicon-trash ticket_label_delete_type" id="'.$avail_labels[$i]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Delete Status','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span> ';
                        }
                        echo '<span class="glyphicon glyphicon-pencil ticket_label_edit_type" id="'.$avail_labels[$i]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Edit Status','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span> ';
                        echo '</span></li>';
                    }
                }
                else
                {
                    echo '<li class="list-group-item list-group-item-info">'.__('There are no Labels! Create One Label','wsdesk').'</li>';
                }
            ?>
        </ul>
    </div>
    <div id="ticket_label_add_display" style="display: none;">
        <span class="crm-divider"></span>
        <div class="crm-form-element">
            <div class="col-md-12">
                <div style="vertical-align: middle">
                    <label style="padding-right:1em !important;"><?php _e('Add Status','wsdesk'); ?></label> 
                    <button type="button" id="ticket_label_cancel_add_button" class="btn btn-primary btn-xs pull-right"> <span class="glyphicon glyphicon-remove"></span> <?php _e('Cancel','wsdesk'); ?></button>
                </div>
                <span style="vertical-align: middle;" id="ticket_label_add_section">
                    <input type="hidden" value="" id="add_new_label_yes">
                    <span class="help-block"><?php _e('Enter Details for New Status','wsdesk'); ?> </span>
                    <input type="text" id="ticket_label_add_title" placeholder="<?php _e('Enter Title','wsdesk'); ?>" class="form-control crm-form-element-input">
                    <span class="help-block"><?php _e('Change ticket status color','wsdesk'); ?></span>
                    <span style="vertical-align: middle;">
                        <input type="color" id="ticket_label_add_color"/><span> <?php _e('Click and pick the color','wsdesk'); ?></span>
                    </span>
                    <span class="help-block"><?php _e('Do you want to use this status to Filter Tickets?','wsdesk'); ?> </span>
                    <input type="radio" style="margin-top: 0;" checked id="ticket_label_add_filter" class="form-control" name="ticket_label_add_filter" value="yes"> <?php _e('Yes! I will use it to Filter','wsdesk'); ?><br>
                    <input type="radio" style="margin-top: 0;" id="ticket_label_add_filter" class="form-control" name="ticket_label_add_filter" value="no"> <?php _e('No! Just for Information','wsdesk'); ?>
                </span>
            </div>
        </div>
    </div>
    <div id="ticket_label_edit_display" style="display: none;">
        <span class="crm-divider"></span>
        <div class="crm-form-element">
            <div class="col-md-12">
                <div style="vertical-align: middle">
                    <label style="padding-right:1em !important;"><?php _e('Edit Status','wsdesk'); ?></label>
                    <button type="button" id="ticket_label_cancel_edit_button" class="btn btn-primary btn-xs pull-right"> <span class="glyphicon glyphicon-remove"></span> <?php _e('Cancel','wsdesk'); ?></button>
                </div>
                <input type="hidden" value="" id="ticket_label_edit_type">
                <span style="vertical-align: middle;" id="ticket_label_edit_append"></span>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <button type="button" id="save_ticket_labels" class="btn btn-primary btn-sm"> <span class="glyphicon glyphicon-ok"></span> <?php _e('Save Changes','wsdesk'); ?></button>
    </div>
</div>
<?php
return ob_get_clean();