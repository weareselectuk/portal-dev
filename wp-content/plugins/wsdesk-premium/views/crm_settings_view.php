<?php
echo '<div class="wsdesk_wrapper">';
$plugin_name = 'wsdesk';
$mail = get_option($plugin_name . '_email');
$licence_key = get_option($plugin_name . '_licence_key');
$instance = get_option($plugin_name . '_instance_id');
$status = get_option($plugin_name . '_activation_status');
$show_activation = (!empty($status) && $status != 'inactive' ) ? 'hidden' : '';
$show_deactivation = ( empty($status) || $status == 'inactive' ) ? 'hidden' : '';
if($status=="inactive" || empty($status))
{
    ?>
    <div class="row" id="alert_for_activation">
        <div class="col-md-12">
            <div class="alert alert-danger aw_wsdesk_activate_alert" role="alert">
                <?php _e('Activate your WSDesk. Check','wsdesk');?> <a href="https://elextensions.com/my-account/my-api-keys/" style="text-decoration: underline !important;" target="_blank" class="alert-link"><?php _e('My Account','wsdesk');?></a> <?php _e('for API Keys.','wsdesk');?>
            </div>
        </div>
    </div>
    <?php
}
?>
<div id="result" class="aw-result-box">WSDesk Activate Msg</div>
<div class="container">
    <div class="row">
        <ol class="breadcrumb crm-panel-right" style="margin-left: 0 !important;">
            <li><?php _e('Settings','wsdesk');?></li>
            <li id="breadcrump_section" class="active"><?php _e('General','wsdesk');?></li>
        </ol>
        <div class="col-md-3 crm-panel-left">
            <div class="panel panel-default crm-panel">
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked" role="tablist">
                        <li class="active">
                            <a href="#general_tab" data-toggle="tab" class="general"><?php _e('General','wsdesk');?></a>
                        </li>
                        <li>
                            <a href="#ticket_fields_tab" data-toggle="tab" class="ticket_fields"><?php _e('Ticket Fields','wsdesk');?></a>
                        </li>
                        <li>
                            <a href="#ticket_labels_tab" data-toggle="tab" class="ticket_labels"><?php _e('Ticket Status','wsdesk');?></a>
                        </li>
                        <li>
                            <a href="#ticket_tags_tab" data-toggle="tab" class="ticket_tags"><?php _e('Ticket Tags','wsdesk');?></a>
                        </li>
                        <li>
                            <a href="#ticket_views_tab" data-toggle="tab" class="ticket_views"><?php _e('Ticket Views','wsdesk');?></a>
                        </li>
                        <li>
                            <a href="#ticket_page_tab" data-toggle="tab" class="ticket_page"><?php _e('Ticket Page','wsdesk');?></a>
                        </li>
                        <li>
                            <a href="#triggers_tab" data-toggle="tab" class="wsdesk_triggers"><?php _e('Triggers & Automation','wsdesk');?></a>
                        </li>
                        <?php
                            if(EH_CRM_WOO_STATUS)
                            {
                                ?>
                                <li>
                                    <a href="#woocommerce_tab" data-toggle="tab" class="woocommerce_settings"><?php _e('WooCommerce','wsdesk');?></a>
                                </li>
                                <?php
                            }
                        ?>
                        <li>
                            <a href="#appearance_tab" data-toggle="tab" class="appearance"><?php _e('Form Settings','wsdesk');?></a>
                        </li>
                        <li>
                            <a href="#backup_restore_tab" data-toggle="tab" class="backup_restore"><?php _e('Backup & Restore','wsdesk');?></a>
                        </li>
                        <li>
                            <a href="#export_tab" data-toggle="tab" class="export"><?php _e('Export Data (CSV)','wsdesk');?></a>
                        </li>
                        <li>
                            <a href="#activation_wsdesk_tab" data-toggle="tab" class="activation_wsdesk <?php echo (($show_activation!="hidden")?"not_activated":"get_activated"); ?> btn-danger">
                                <?php _e('Activate WSDesk','wsdesk');?> <span id="aw_wsdesk_status"><?php echo (($show_activation!="hidden")?__("( Not Activated )",'wsdesk'):__("( Activated )",'wsdesk')); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="alert alert-success" style="display: none" role="alert">
                <div id="success_alert_text"></div>
            </div>
            <div class="alert alert-danger" style="display: none" role="alert">
                <div id="danger_alert_text"></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default crm-panel">
                <div class="panel-body" style="padding: 5px !important">
                    <div class="tab-content">
                        <div class="loader"></div>
                        <div class="tab-pane active" id="general_tab">
                            <?php echo include(EH_CRM_MAIN_VIEWS."settings/crm_settings_general.php"); ?>
                        </div>
                        <div class="tab-pane" id="ticket_fields_tab">
                            <?php echo include(EH_CRM_MAIN_VIEWS."settings/crm_settings_fields.php"); ?>
                        </div>
                        <div class="tab-pane" id="ticket_labels_tab">
                            <?php echo include(EH_CRM_MAIN_VIEWS."settings/crm_settings_labels.php"); ?>
                        </div>
                        <div class="tab-pane" id="ticket_tags_tab">
                            <?php echo include(EH_CRM_MAIN_VIEWS."settings/crm_settings_tags.php"); ?>
                        </div>
                        <div class="tab-pane" id="ticket_views_tab">
                            <?php echo include(EH_CRM_MAIN_VIEWS."settings/crm_settings_views.php"); ?>
                        </div>
                        <div class="tab-pane" id="ticket_page_tab">
                            <?php echo include(EH_CRM_MAIN_VIEWS."settings/crm_settings_page.php"); ?>
                        </div>
                        <div class="tab-pane" id="triggers_tab">
                            <?php echo include(EH_CRM_MAIN_VIEWS."settings/crm_wsdesk_triggers.php"); ?>
                        </div>
                        <?php
                            if(EH_CRM_WOO_STATUS)
                            {
                                ?>
                                <div class="tab-pane" id="woocommerce_tab">
                                    <?php echo include(EH_CRM_MAIN_VIEWS."settings/crm_woocommerce_settings.php"); ?>
                                </div>
                                <?php
                            }
                        ?>
                        <div class="tab-pane" id="appearance_tab">
                            <?php echo include(EH_CRM_MAIN_VIEWS."settings/crm_settings_appearance.php"); ?>
                        </div>
                        <div class="tab-pane" id="backup_restore_tab">
                            <?php echo include(EH_CRM_MAIN_VIEWS."settings/crm_settings_backup_restore.php"); ?>
                        </div>
                        <div class="tab-pane" id="export_tab">
                            <?php echo include(EH_CRM_MAIN_VIEWS."settings/crm_settings_export.php"); ?>
                        </div>
                        <div class="tab-pane" id="activation_wsdesk_tab">
                            <?php 
                                include(EH_CRM_MAIN_PATH.'includes/wf_api_manager/html/html-wf-activation-window.php' );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>