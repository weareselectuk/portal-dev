<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$input_width = eh_crm_get_settingsmeta('0', "input_width");
$main_ticket_form_title = eh_crm_get_settingsmeta('0', "main_ticket_form_title");
$new_ticket_form_title = eh_crm_get_settingsmeta('0', "new_ticket_form_title");
$existing_ticket_title = eh_crm_get_settingsmeta('0', "existing_ticket_title");
$submit_ticket_button = eh_crm_get_settingsmeta('0', "submit_ticket_button");
$reset_ticket_button = eh_crm_get_settingsmeta('0', "reset_ticket_button");
$existing_ticket_button = eh_crm_get_settingsmeta('0', "existing_ticket_button");


if(!$submit_ticket_button)$submit_ticket_button = 'Submit Request';
if(!$reset_ticket_button)$reset_ticket_button = 'Reset Request';
if(!$existing_ticket_button)$existing_ticket_button = 'Check your Existing Request';

?>
<div class="crm-form-element">
    <div class="col-md-9">
        <span class="help-block"><?php _e('Set custom width for form elements','wsdesk'); ?></span>
        <div class="input-group">
            <input type="number" class="form-control" id="input_elements_width" style="height: 32px;" value="<?php echo $input_width; ?>" placeholder="100" aria-describedby="basic-addon2">
            <span class="input-group-addon" id="basic-addon2">%</span>
        </div>
    </div>
</div>
<h4 style="padding-left: 15px;"><?php _e('Support Form Title','wsdesk'); ?></h4>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-8">
        <span class="help-block"><?php _e('Set custom title for the main support form','wsdesk'); ?>&nbsp; <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("This title would appear in the page with the short code [wsdesk_support].", 'wsdesk'); ?>" data-container="body"></span></span>

        <input type="text" class="form-control" id="main_ticket_form_title" value="<?php echo $main_ticket_form_title; ?>" placeholder="<?php _e('Contact Support', 'wsdesk');?>">
    </div>
</div>                          
<div class="crm-form-element">
    <div class="col-md-8">
        <span class="help-block"><?php _e('Set custom title for new support form','wsdesk'); ?>&nbsp; <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("This title would appear for any new form for both the short codes [wsdesk_support] and [wsdesk_support display=form].", 'wsdesk'); ?>" data-container="body"></span></span>
        <input type="text" class="form-control" id="new_ticket_form_title" value="<?php echo $new_ticket_form_title; ?>" placeholder="Report Issue">
    </div>
</div>
<div class="crm-form-element">
    <div class="col-md-8">
        <span class="help-block"><?php _e('Set custom title for the existing tickets','wsdesk'); ?>&nbsp; <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("This title would appear when you wish to display tickets in a separate page using the shortcode [wsdesk_support display=check_request].", 'wsdesk'); ?>" data-container="body"></span></span>
        <input type="text" class="form-control" id="existing_ticket_title" value="<?php echo $existing_ticket_title; ?>" placeholder="Your Tickets">
    </div>
</div>
<h4 style="padding-left: 15px;"><?php _e('Support Form Button','wsdesk'); ?></h4>
<span class="crm-divider"></span>                         
<div class="crm-form-element">
    <div class="col-md-8">
        <span class="help-block"><?php _e('Set custom text for the Submit Request button','wsdesk'); ?></span>
        <input type="text" class="form-control" id="submit_ticket_button" value="<?php echo $submit_ticket_button; ?>" placeholder="<?php echo $submit_ticket_button; ?>">
    </div>
</div>
<div class="crm-form-element">
    <div class="col-md-8">
        <span class="help-block"><?php _e('Set custom text for the Reset Request button','wsdesk'); ?></span>
        <input type="text" class="form-control" id="reset_ticket_button" value="<?php echo $reset_ticket_button; ?>" placeholder="<?php echo $reset_ticket_button; ?>">
    </div>
</div>
<div class="crm-form-element">
    <div class="col-md-8">
        <span class="help-block"><?php _e('Set custom text for the Check Existing Ticket button','wsdesk'); ?></span>
        <input type="text" class="form-control" id="existing_ticket_button" value="<?php echo $existing_ticket_button; ?>" placeholder="<?php echo $existing_ticket_button; ?>">
    </div>
</div>
<div class="crm-form-element">
    <div class="col-md-12">
    <button type="button" id="save_appearance" class="btn btn-primary btn-sm"> <span class="glyphicon glyphicon-ok"></span> <?php _e('Save Changes','wsdesk'); ?></button>
    </div>
</div>
<?php
return ob_get_clean();