<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$title = eh_crm_get_settingsmeta(0, 'main_ticket_form_title');
$title = eh_crm_wpml_translations($title, "title", "title");
$existing= eh_crm_get_settingsmeta(0, 'existing_ticket_button');
$existing = eh_crm_wpml_translations($existing, "existing", "existing");
$submit= eh_crm_get_settingsmeta(0, 'submit_ticket_button');
$submit = eh_crm_wpml_translations($submit, "submit", "submit");
if(!$submit)
{
    $submit = __('Submit Request', 'wsdesk');
}
if(!$existing)
{
    $existing = __('Check your Existing Request', 'wsdesk');
}
if(isset($_GET['customer_ticket_num']))
{
	
    echo'<div class="wsdesk_wrapper"> 
        <div class="loaderDirect"></div>
        <div class="eh_crm_support_main load_wsdesk_request_ticket_directly">
            <div class="ticket_table_wrapper">
			<div class="ticket_load_content"></div>
			</div>
        </div>
    </div>';
	die();
}

?>
<div class="eh_crm_support_main wsdesk_wrapper">
    <div class="support_option_choose">
        <?php echo ($title!=='')?'<h3>'.$title.'</h3>':''; ?>
        <button data-loading-text="<?php _e('Fetching Request Form...', 'wsdesk'); ?>" class="btn btn-primary eh_crm_new_request">
            <?php echo  $submit ?>
        </button>
        <br>
        <br>
        <a href='<?php echo eh_get_url_by_shortcode('[wsdesk_support display="check_request"'); ?>' target="_blank" data-loading-text="<?php _e('Loading your Request...', 'wsdesk'); ?>" class="btn btn-primary eh_crm_check_request" role="button">
            <?php echo $existing ?>
        </a>
    </div>
    <div class="ticket_table_wrapper">
    </div>
</div>
<?php
return ob_get_clean();