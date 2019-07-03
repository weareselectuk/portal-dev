<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$support_email_name = eh_crm_get_settingsmeta('0', "support_reply_email_name");
$support_email = eh_crm_get_settingsmeta('0', "support_reply_email");
$support_email_new_ticket_text = eh_crm_get_settingsmeta('0', "support_email_new_ticket_text");
$avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title", "settings_id"));
if(!$support_email_new_ticket_text)
{
    $support_email_new_ticket_text = 'Your request (#[id]) has been received on [date] and is being reviewed by our support staff.

To add additional comments, reply to this email.

Your Issue:
[request_description]

Tags : [tags]

Regards,
Support';
}
$support_email_reply_text = eh_crm_get_settingsmeta('0', "support_email_reply_text");
if(!$support_email_reply_text)
{
    $support_email_reply_text = 'Your request (#[id]) has been updated. To add additional comments, reply to this email.

[conversation_history]';
}
?>
<div class="crm-form-element">
    <div class="col-md-12">
        <span class="help-block"><?php _e("Support Reply Email Name", 'wsdesk'); ?></span>
        <input type="text" id="support_reply_email_name" placeholder="<?php _e("Enter name", 'wsdesk'); ?>" value="<?php echo $support_email_name; ?>" class="form-control crm-form-element-input">
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-12">
        <span class="help-block"><?php _e("Support Reply Email", 'wsdesk'); ?></span>
        <input type="text" id="support_reply_email" placeholder="<?php _e("Enter Email", 'wsdesk'); ?>" value="<?php echo $support_email; ?>" class="form-control crm-form-element-input">
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-12">
        <span class="help-block"><?php _e('Send Auto E-Mail on Ticket Creation','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <?php 
                $auto_send_creation_email = eh_crm_get_settingsmeta('0', "auto_send_creation_email");
                $enable = '';
                $hide = '';
                switch ($auto_send_creation_email) {
                    case "enable":
                        $enable = 'checked';
                        break;
                    default:
                        $enable = '';
                        $hide = 'display:none;';
                        break;
                }
            ?>
            <input type="checkbox" style="margin-top: 0;" <?php echo $enable; ?> id="auto_send_creation_email" class="form-control" name="auto_send_creation_email" value="enable"> <?php _e('Enable','wsdesk');?><br>
        </span>
    </div>
</div>
<div id="email_auto_role_display" style="margin-top: 20px;<?php echo $hide; ?>">
    <div class="col-md-12">
        <div class="panel-group" id="email_auto_role" style="margin-bottom: 0px !important;cursor: pointer;">
            <div class="panel panel-default">
                <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#email_auto_role" data-target="#content_email_auto">
                    <span class ="email-reply-toggle"></span>
                    <h4 class="panel-title">
                        <?php _e("Code for Automated Reply", 'wsdesk'); ?>
                    </h4>
                </div>
                <div id="content_email_auto" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    [id]
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To Insert Ticket Number in the Reply", 'wsdesk'); ?>
                                </div>
                            </div>
                            <span class="crm-divider"></span>
                            <div class="row">
                                <div class="col-md-3">
                                    [assignee]
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To Insert Ticket Assignee in the Reply", 'wsdesk'); ?>
                                </div>
                            </div>
                            <span class="crm-divider"></span>
                            <div class="row">
                                <div class="col-md-3">
                                    [tags]
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To Insert Ticket Tags in the Reply", 'wsdesk'); ?>
                                </div>
                            </div>
                            <span class="crm-divider"></span>
                            <div class="row">
                                <div class="col-md-3">
                                    [date]
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To Insert Ticket Date and Time in the Reply", 'wsdesk'); ?>
                                </div>
                            </div>
                            <span class="crm-divider"></span>
                            <div class="row">
                                <div class="col-md-3">
                                    [request_description]
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To Insert Ticket Content in the Reply", 'wsdesk'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                    
            </div>
        </div>
    </div>
    <div class="crm-form-element">
        <div class="col-md-12">
            <span class="help-block"><?php _e("Enter your new ticket automated reply format", 'wsdesk'); ?></span>
            <?php
                wp_editor
                (
                    stripslashes($support_email_new_ticket_text),
                    "support_email_new_ticket_text",
                    array
                    (
                        'tinymce' => false,
                        "media_buttons" => false,
                        "default_editor"=> "html",
                        "editor_height" => "300px",
                    )
                );
            ?>
        </div>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-12">
        <span class="help-block"><?php _e('Send Auto E-Mail on Agent Reply','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("Disabling this will block any kind of outgoing E-Mails generated when agent replies.", 'wsdesk'); ?>" data-container="body"></span></span>
        <span style="vertical-align: middle;">
            <?php 
                $send_agent_reply_mail = eh_crm_get_settingsmeta('0', "send_agent_reply_mail");
                $enable = '';
                $hide = '';
                switch ($send_agent_reply_mail) {
                    case "disabled":
                        $enable = '';
                        $hide = 'display: none;';
                        break;
                    default:
                        $enable = 'checked';
                        break;
                }
            ?>
            <input type="checkbox" style="margin-top: 0;" <?php echo $enable; ?> id="send_agent_reply_mail" class="form-control" name="send_agent_reply_mail" value="enable"> <?php _e('Enable','wsdesk');?><br>
        </span>
    </div>
</div>
<div id="email_auto_send_agent_reply" style="margin-top: 20px;<?php echo $hide; ?>">
    <div class="col-md-12" style="margin-top: 20px;">
        <div class="panel-group" id="email_reply_role" style="margin-bottom: 0px !important;cursor: pointer;">
            <div class="panel panel-default">
                <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#email_reply_role" data-target="#content_reply_email">
                    <span class ="email-reply-toggle"></span>
                    <h4 class="panel-title">
                        <?php _e("Code for Agent Reply Email", 'wsdesk'); ?>
                    </h4>
                </div>
                <div id="content_reply_email" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    [id]
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To Insert Ticket Number in the Reply", 'wsdesk'); ?>
                                </div>
                            </div>
                            <span class="crm-divider"></span>
                            <div class="row">
                                <div class="col-md-3">
                                    [assignee]
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To Insert Ticket Assignee in the Reply", 'wsdesk'); ?>
                                </div>
                            </div>
                            <span class="crm-divider"></span>
                            <div class="row">
                                <div class="col-md-3">
                                    [tags]
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To Insert Ticket Tags in the Reply", 'wsdesk'); ?>
                                </div>
                            </div>
                            <span class="crm-divider"></span>
                            <div class="row">
                                <div class="col-md-3">
                                    [date]
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To Insert Ticket Date and Time in the Reply", 'wsdesk'); ?>
                                </div>
                            </div>
                            <span class="crm-divider"></span>
                            <div class="row">
                                <div class="col-md-3">
                                    [latest_reply]
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To Insert Latest Ticket Reply in the Reply", 'wsdesk'); ?>
                                </div>
                            </div>
                            <span class="crm-divider"></span>
                            <div class="row">
                                <div class="col-md-3">
                                    [agent_replied]
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To Insert Ticket Agent who replied in the Reply", 'wsdesk'); ?>
                                </div>
                            </div>
                            <span class="crm-divider"></span>
                            <div class="row">
                                <div class="col-md-3">
                                    [status]
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To Insert Ticket Status in the Reply", 'wsdesk'); ?>
                                </div>
                            </div>
                            <span class="crm-divider"></span>
                            <div class="row">
                                <div class="col-md-3">
                                    [conversation_history]
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To Insert Entire Conversation of the Ticket in the Reply", 'wsdesk'); ?>
                                </div>
                            </div>
                            <!--<span class="crm-divider"></span>
                            <div class="row">
                                <div class="col-md-3">
                                    [conversation_history_with_agent_note]
                                </div>
                                <div class="col-md-9">
                                    <?php //_e("To Insert Conversation History with agent note in the notification email", 'wsdesk'); ?>
                                </div>
                            </div>-->
    						<span class="crm-divider"></span>
                            <div class="row">
                                <div class="col-md-3">
                                    [ticket_link page='slug']
                                </div>
                                <div class="col-md-9">
                                    <?php _e("To insert the front end URL of the individual ticket. Replace Slug with the support page slug.", 'wsdesk'); ?>
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
    </div>
    <div class="crm-form-element">
        <div class="col-md-12">
            <span class="help-block"><?php _e("Enter your agent reply mail format", 'wsdesk'); ?></span>
            <?php
                wp_editor
                (
                    stripcslashes($support_email_reply_text), 
                    "support_email_reply_text", 
                    array
                    (
                        'tinymce' => false,
                        "media_buttons" => false,
                        "default_editor"=> "html",
                        "editor_height" => "300px",
                    )
                );
            ?>
        </div>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-12">
        <button type="button" id="save_email_support" class="btn btn-primary"> <span class="glyphicon glyphicon-ok"></span> Save Changes</button>
    </div>
</div>
<?php
return ob_get_clean();
