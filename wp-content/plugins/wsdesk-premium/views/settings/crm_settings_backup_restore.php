<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
?>
<center>
    <h3><?php _e('Initiate Ticket', 'wsdesk'); ?></h3>
    <div class="crm-form-element">
        <span class="help-block" style="text-align: center"><?php _e('Start ticket with specified number', 'wsdesk'); ?></span>
        <span style="display: inline-flex;">
            <input type="number" name="initiate_number" id="initiate_number" placeholder="Starting Number" class="form-control" style="height: auto;width: 100%;margin-right: 10px;padding: 5px;">
            <button type="button" id="start_initiate_ticket" class="btn btn-primary"><?php _e('Set Number', 'wsdesk'); ?></button>
        </span>
    </div>
    <span class="crm-divider"></span>
    <div class="col-md-12" style="margin-bottom: 20px;">
        <div class="col-md-6">
            <div class="crm-form-element">
                <span class="help-block" style="text-align: center"><?php _e('Delete all tickets in trash', 'wsdesk'); ?></span>
                <span style="display: inline-flex;">
                    <button type="button" id="empty_trash" class="btn btn-primary btn-lg"><?php _e('Empty Trash', 'wsdesk'); ?></button>
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="crm-form-element">
                <span class="help-block" style="text-align: center"><?php _e('Restore all tickets from trash', 'wsdesk'); ?></span>
                <span style="display: inline-flex;">
                    <button type="button" id="restore_trash" class="btn btn-primary btn-lg"><?php _e('Restore Trash', 'wsdesk'); ?></button>
                </span>
            </div>
        </div>
    </div>
    <span class="crm-divider"></span>
    <form id="backup_wsdesk" method="POST" action="<?php echo admin_url("admin-ajax.php"); ?>">
        <h3><?php _e('Backup Data (XML)', 'wsdesk'); ?></h3>
        <div class="crm-form-element">
            <div class="col-md-12">
                <span class="help-block"><?php _e('Specify the data to be Backup if needed?', 'wsdesk'); ?></span>
                <input type="checkbox" name="backup_data_values[]" id="backup_data_values" value="settings" checked=""> <?php _e('Settings', 'wsdesk'); ?>
                <input type="checkbox" name="backup_data_values[]" id="backup_data_values" value="tickets" checked=""> <?php _e('Tickets', 'wsdesk'); ?>
                <input type="hidden" name="action" value="eh_crm_backup_data">
            </div>
        </div>
        <div class="crm-form-element">
            <div class="col-md-12">
                <span class="help-block"><?php _e('Specify the date range for tickets Backup if needed?', 'wsdesk'); ?></span>
                <input type="text" id="backup_date_range_start" placeholder="Start Date" name="backup_date_range_start"> - 
                <input type="text" id="backup_date_range_end" placeholder="End Date" name="backup_date_range_end">
            </div>
        </div>
        <div class="crm-form-element">
            <div class="col-md-12" id="download_backup_button">
                <span class="help-block" style="text-align: center"><?php _e('Backing Up of WSDesk Data may require some time.', 'wsdesk'); ?></span>
                <span class="help-block" style="text-align: center"><?php _e('Please note that attachments cannot be taken as backup.', 'wsdesk'); ?></span>
                <button type="button" id="backup_data" data-loading-text="<?php _e('Preparing Data...', 'wsdesk'); ?>" class="btn btn-primary btn-lg"><?php _e('Start Backup', 'wsdesk'); ?></button>
            </div>
        </div>
    </form>
    <span class="crm-divider"></span>
    <h3><?php _e('Restore Data (XML)', 'wsdesk'); ?></h3>
    <div class="crm-form-element">
        <span class="help-block" style="text-align: center"><?php _e('WSDesk Restore Data File', 'wsdesk'); ?></span>
        <input type="file" name="restore_file" accept=".json" id="restore_file" class="form-control" style="height: auto;width: 50%;padding: 5px;">
    </div>
    <div class="crm-form-element">
        <div class="col-md-12">
            <span class="help-block" style="text-align: center"><?php _e('Restoring WSDesk Data may take some time.', 'wsdesk'); ?></span>
            <button type="button" id="restore_data" data-loading-text="<?php _e('Restoring Data...', 'wsdesk'); ?>" class="btn btn-primary btn-lg"><?php _e('Start Restore', 'wsdesk'); ?></button>
        </div>
    </div>

</center>
<?php
return ob_get_clean();
