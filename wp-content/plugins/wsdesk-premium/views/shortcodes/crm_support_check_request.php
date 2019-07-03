<?php
if (!defined('ABSPATH')) 
{
    exit;
}
ob_start();
$selected_fields = eh_crm_get_settingsmeta(0, 'selected_fields');
$select_val = array();
if(is_array($selected_fields))
{
    if(isset($cus_fields) && !empty($cus_fields) && is_array($cus_fields))
    {
        $select_val = array_intersect($selected_fields, $cus_fields);
    }
}   
$title = eh_crm_get_settingsmeta(0, 'existing_ticket_title');
$title = eh_crm_wpml_translations($title, 'title', 'title');
$submit = eh_crm_get_settingsmeta(0, 'submit_ticket_button');
if(!$submit)
{
    $submit = __('Submit Request', 'wsdesk');
}
$submit = eh_crm_wpml_translations($submit, 'submit', 'submit');
$title = empty($title)?"<h3>$title</h3>":'';
if(empty($cus_fields))
{
	echo $title;
?>
<div class="wsdesk_wrapper">
	<div class="eh_crm_support_main load_wsdesk_request_directly">
		<input type= "hidden" id="custom_fields" value ="<?php echo htmlentities(json_encode($select_val))?>"/>
	    <div class="support_option_choose"> 
			<button data-loading-text="<?php _e('Fetching Request Form...', 'wsdesk'); ?>" class="btn btn-primary eh_crm_new_request eh_crm_new_request_check_request_page" onclick="jQuery('#check_request_powered_wsdesk').hide();">
		        <?php echo  $submit ?>
		    </button>
		    <br>
		    <br>
	    </div>
	    	<div class="ticket_table_wrapper"></div>
	</div>
    <div class="loaderDirect"></div>
    <!--<div class="eh_crm_support_main  l">-->
</div>
<?php
if(!defined('WSDESK_POWERED_SUPPORT'))
{
    echo '<div id="check_request_powered_wsdesk" class="powered_wsdesk"><span>'.__('Powered by', 'wsdesk'). '</span> <a href="https://elextensions.com/plugin/wsdesk-wordpress-support-desk-plugin/" target="_blank" rel="nofollow">WSDesk</a></div>';
}
}
?>
<?php if(isset($cus_fields) && !empty($cus_fields) && is_array($cus_fields)){?>
<div class="wsdesk_wrapper">
    <div class="eh_crm_support_main load_wsdesk_request_directly">
        <input type= "hidden" id="custom_fields" value ="<?php echo htmlentities(json_encode($select_val))?>"/>
        <div class="support_option_choose">
            <?php echo $title; ?>
            <button data-loading-text="<?php _e('Fetching Request Form...', 'wsdesk'); ?>" class="btn btn-primary eh_crm_new_request" " onclick="jQuery('#check_request_powered_wsdesk').hide();">
            <?php echo  $submit ?>
            </button>
            <br>
            <br>
        </div>
            <div class="ticket_table_wrapper"></div>
    </div>
    <div class="loaderDirect"></div>
</div>
<?php }
return ob_get_clean();
?>