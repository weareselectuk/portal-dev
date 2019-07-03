<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb, $wpsupportplus, $current_user;



$ticket_id= isset($_POST['ticket_id']) ? sanitize_text_field($_POST['ticket_id']) : '';
$nonce      = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '' ;

/**
 * Check nonce
 */

if( !wp_verify_nonce( $nonce ) ){  
    die(__('Cheating huh?', 'wp-support-plus-responsive-ticket-system'));
}

$modal_title = __('Delete Tickets','wp-support-plus-responsive-ticket-system');

ob_start();

?>

<form id="frm_delete_bulk_ticket">
    
    <div class="form-group">
        <p><?php _e('Are you sure to delete these tickets?','wp-support-plus-responsive-ticket-system');?></p>
    </div>
    
    <input type="hidden" name="action" value="wpsp_set_delete_bulk_ticket" />
    <input type="hidden" name="ticket_id" value="<?php echo $ticket_id?>" />
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce()?>" />
    
</form>
<style>
    .ui-autocomplete{
        position:absolute;
        cursor:default;
        z-index:9999999999 !important
    }
</style>
<script>
jQuery(function () {
    
});
</script>

<?php

$modal_body = ob_get_clean();

ob_start();

?>
<div class="row">
    <div class="col-md-12" style="text-align: right;">
        <button type="button" class="btn btn-default" onclick="wpsp_ajax_modal_cancel();"><?php _e('Cancel','wp-support-plus-responsive-ticket-system');?></button>
        <button type="button" class="btn btn-primary" onclick="wpsp_set_delete_bulk_ticket();"><?php _e('Confirm','wp-support-plus-responsive-ticket-system');?></button>

    </div>
</div>

<?php

$modal_footer = ob_get_clean();

$response = array(
    'title'     => $modal_title,
    'body'      => $modal_body,
    'footer'    => $modal_footer
);

echo json_encode($response);
