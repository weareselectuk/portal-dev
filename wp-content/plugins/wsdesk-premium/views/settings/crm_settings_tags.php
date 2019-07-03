<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$args = array("type" => "tag");
$fields = array("slug","title","settings_id");
$avail_tags = eh_crm_get_settings($args,$fields);
?>
<div class="crm-form-element">
    <div class="col-md-12">
        <div style="vertical-align: middle">
            <label for="ticket_tags" style="padding-right:1em !important;"><?php _e('Ticket Tags','wsdesk'); ?></label> 
            <button type="button" id="ticket_tag_add_button" class="btn btn-primary btn-xs pull-right"> <span class="glyphicon glyphicon-plus"></span> <?php _e('Add Tag','wsdesk'); ?></button>
        </div>
        <ul class="list-group list-group-sortable-connected list-group-tag-data">
            <?php
                if(!empty($avail_tags))
                {
                    for($i=0;$i<count($avail_tags);$i++)
                    {
                        $tag_posts = eh_crm_get_settingsmeta($avail_tags[$i]['settings_id'], "tag_posts");
                        if(empty($tag_posts))
                        {
                            $tag_posts=array();
                        }
                        echo '<li class="list-group-item list-group-item-success" style="padding: 10px 10px !important;" id="'.$avail_tags[$i]['slug'].'"> '.$avail_tags[$i]['title'].' <span class="badge" style="background-color:#337ab7 !important;">'.count($tag_posts).' '.__('tagged post','wsdesk').'</span><span class="pull-right">';
                        echo '<span class="glyphicon glyphicon-trash ticket_tag_delete_type" id="'.$avail_tags[$i]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Delete Tag','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span> ';
                        echo '<span class="glyphicon glyphicon-pencil ticket_tag_edit_type" id="'.$avail_tags[$i]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Edit Tag','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span> ';
                        echo '</span></li>';
                        
                    }
                }
                else
                {
                    echo '<li class="list-group-item list-group-item-info">'.__('There are no Tags! Create One Tag','wsdesk').'.</li>';
                }
            ?>
        </ul>
    </div>
    <div id="ticket_tag_add_display" style="display: none;">
        <span class="crm-divider"></span>
        <div class="crm-form-element">
            <div class="col-md-12">
                <div style="vertical-align: middle">
                    <label style="padding-right:1em !important;"><?php _e('Add Tag','wsdesk'); ?></label> 
                    <button type="button" id="ticket_tag_cancel_add_button" class="btn btn-primary btn-xs pull-right"> <span class="glyphicon glyphicon-remove"></span> <?php _e('Cancel','wsdesk'); ?></button>
                </div>
                <span style="vertical-align: middle;" id="ticket_tag_add_section">
                    <input type="hidden" value="" id="add_new_tag_yes">
                    <span style="vertical-align: middle;;" id="ticket_tag_add_section">
                        <span class="help-block"><?php _e('Enter Details for New Tag','wsdesk'); ?> </span>
                        <input type="text" id="ticket_tag_add_title" placeholder="<?php _e('Enter Title', 'wsdesk');?>" class="form-control crm-form-element-input">
                        <span class="help-block"><?php _e('Select the Post which should be Tagged if required','wsdesk'); ?> </span>
                        <select class="ticket_tag_add_posts form-control crm-form-element-input" multiple="multiple">
                        </select>
                        <span class="help-block"><?php _e('Want to use this Tag to Filter Tickets?','wsdesk'); ?> </span>
                        <input type="radio" style="margin-top: 0;"  id="ticket_tag_add_filter" checked class="form-control" name="ticket_tag_add_filter" value="yes"> <?php _e('Yes! I will use it to Filter','wsdesk'); ?><br>
                        <input type="radio" style="margin-top: 0;" id="ticket_tag_add_filter" class="form-control" name="ticket_tag_add_filter" value="no"> <?php _e('No! Just for Information','wsdesk'); ?>
                    </span>
                </span>
            </div>
        </div>
    </div>
    <div id="ticket_tag_edit_display" style="display: none;">
        <span class="crm-divider"></span>
        <div class="crm-form-element">
            <div class="col-md-12">
                <div style="vertical-align: middle">
                    <label style="padding-right:1em !important;"><?php _e('Edit Tag','wsdesk'); ?></label>
                    <button type="button" id="ticket_tag_cancel_edit_button" class="btn btn-primary btn-xs pull-right"> <span class="glyphicon glyphicon-remove"></span> <?php _e('Cancel','wsdesk'); ?></button>
                </div>
                <input type="hidden" value="" id="ticket_tag_edit_type">
                <span style="vertical-align: middle;" id="ticket_tag_edit_append"></span>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <button type="button" id="save_ticket_tags" class="btn btn-primary btn-sm"> <span class="glyphicon glyphicon-ok"></span> <?php _e('Save Changes','wsdesk'); ?></button>
    </div>
</div>
<?php
return ob_get_clean();
