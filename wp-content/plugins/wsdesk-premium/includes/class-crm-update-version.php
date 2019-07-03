<?php
if (!defined('ABSPATH')) {
    exit;
}

class EH_CRM_Update_Version
{
    function __construct() {
        $this->date_updated_check();
        $this->trash_updated_check();
        $this->role_updated_check();
        $this->update_settings_meta();
    }
    function date_updated_check()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'wsdesk_tickets';
        if ($wpdb->get_var("SHOW COLUMNS FROM $table LIKE 'ticket_updated'")) {
            return false;
        }
        $wpdb->query("ALTER TABLE $table ADD `ticket_updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `ticket_date`;");
    }
    function role_updated_check()
    {
        $role = get_role('WSDesk_Agents');
        if(in_array('view_admin_dashboard',$role->capabilities))
        {
            $role->add_cap('view_admin_dashboard',true);
        }
        $role = get_role('WSDesk_Supervisor');
        if(in_array('view_admin_dashboard',$role->capabilities))
        {
            $role->add_cap('view_admin_dashboard',true);
        }
    }
    function update_settings_meta()
    {
        if(eh_crm_get_settingsmeta(0, "auto_send_creation_email") === FALSE)
        {
            eh_crm_update_settingsmeta(0, "auto_send_creation_email", "enable");
        }
    }
    function trash_updated_check()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'wsdesk_tickets';
        if ($wpdb->get_var("SHOW COLUMNS FROM $table LIKE 'ticket_trash'")) {
            return false;
        }
        $wpdb->query("ALTER TABLE $table ADD `ticket_trash` INT NOT NULL DEFAULT 0 AFTER `ticket_vendor`;");
    }
}