<?php
if (!defined('ABSPATH'))
{
    exit;
}
ob_start();
?>
<center>
    <form id="backup_wsdesk" method="POST" action="<?php echo admin_url("admin-ajax.php"); ?>">
        <h3><?php _e('Export Ticket Data (CSV)', 'wsdesk'); ?></h3>
        <div class="crm-form-element">
            <div class="col-md-12">
                <span class="help-block"><?php _e('Specify a date range for the ticket data to be exported if needed?', 'wsdesk'); ?></span>
                <input type="text" name="export_start_date" id="export_start_date" placeholder="Start Date" > - 
                <input type="text" name="export_end_date" id="export_end_date" placeholder="End Date" >
                <input type="hidden" name="action" value="eh_crm_export_ticket_data">
            </div>
        </div>
        <div class="crm-form-element">
            <div class="col-md-12" id="download_backup_button">
                <span class="help-block" style="text-align: center"><?php _e('Export may take a few minutes.', 'wsdesk'); ?></span>
                <button type="submit" id="export_data" data-loading-text="<?php _e('Preparing Data...', 'wsdesk'); ?>" class="btn btn-primary btn-lg"><?php _e('Start Export', 'wsdesk'); ?></button>
            </div>
        </div>
    </form>
</center>
<?php          
return ob_get_clean();?>