<?php
echo '<div class="wsdesk_wrapper">';
$plugin_name = 'wsdesk';
$status = get_option($plugin_name . '_activation_status');
if($status=="inactive" || empty($status))
{
    ?>
    <div class="row" id="alert_for_activation">
        <div class="col-md-12">
            <div class="alert alert-danger aw_wsdesk_activate_alert" role="alert">
                <?php _e('Activate your WSDesk. Check','wsdesk');?> <a href="https://elextensions.com/my-account/my-api-keys/" style="text-decoration: underline !important;" target="_blank" class="alert-link"><?php _e('My Account','wsdesk');?></a> <?php _e('for API Keys. If knew the API Key already please enter in','wsdesk');?> <a href="<?php echo admin_url("admin.php?page=wsdesk_settings");?>" style="text-decoration: underline !important;" target="_blank" class="alert-link"><?php _e('Settings','wsdesk');?></a> <?php _e('Page','wsdesk');?>
            </div>
        </div>
    </div>
    <?php
}
echo '<div class="loader"></div>';
echo include(EH_CRM_MAIN_VIEWS."agents/crm_agents_main.php");
echo '</div>';