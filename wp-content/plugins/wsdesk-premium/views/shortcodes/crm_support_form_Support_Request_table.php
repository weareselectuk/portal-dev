<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$title= eh_crm_get_settingsmeta(0, 'main_ticket_form_title');
$title = eh_crm_wpml_translations($title, "title", "title");
$selected_fields = eh_crm_get_settingsmeta(0, 'selected_fields');
$select_val = array();
if(is_array($selected_fields))
{
    if(isset($cus_fields) && !empty($cus_fields) && is_array($cus_fields))
    {
        $select_val = array_intersect($selected_fields, $cus_fields);
    }
}
if(isset($_GET['customer_ticket_num']) && is_user_logged_in())
{
    $ticket_id = $_GET['customer_ticket_num'];
    $ticket = eh_crm_get_ticket(array('ticket_id'=>$ticket_id), array('ticket_author', 'ticket_email'));
    $current_user = wp_get_current_user();
    if($ticket[0]['ticket_email'] == $current_user->user_email || $ticket[0]['ticket_author'] == $current_user->ID)
    {
        echo'<div class="eh_crm_support_main wsdesk_wrapper"> 
            <div class="loaderDirect"></div>
            <div class="eh_crm_support_main load_wsdesk_request_ticket_directly">
                <div class="ticket_table_wrapper">
                <div class="ticket_load_content"></div>
                </div>
            </div>
        </div>';
    }
}
else
{
?>
<div class="eh_crm_support_main wsdesk_wrapper">
    <input type= "hidden" id="custom_fields" value ="<?php echo htmlentities(json_encode($select_val))?>"/>
    <?php echo ($title!=='')?'<h3>'.$title.'</h3>':''; ?>
    <div class="wsdesk_wrapper"> 
    <div class="loaderDirect"></div>
    <div class="eh_crm_support_main load_wsdesk_request_directly wsdesk_new_ticket_view">
        <div class="ticket_table_wrapper"></div>
    </div>
    </div>
</div>
<?php
}
if(!defined('WSDESK_POWERED_SUPPORT'))
{
    echo '<div id="check_request_powered_wsdesk" class="powered_wsdesk"><span>'.__('Powered by', 'wsdesk'). '</span> <a href="https://elextensions.com/plugin/wsdesk-wordpress-support-desk-plugin/" target="_blank" rel="nofollow">WSDesk</a></div>';
}
return ob_get_clean();