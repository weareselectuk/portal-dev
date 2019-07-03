<?php

if (!defined('ABSPATH')) {
    exit;
}

class EH_CRM_Settings_Handler {

    function eh_crm_tickets_main_menu_callback() {
        include(EH_CRM_MAIN_VIEWS . "crm_tickets_view.php");
    }

    function eh_crm_settings_sub_menu_callback() {
        include(EH_CRM_MAIN_VIEWS . "crm_settings_view.php");
    }

    function eh_crm_agents_sub_menu_callback() {
        include(EH_CRM_MAIN_VIEWS . "crm_agents_view.php");
    }
    
    function eh_crm_reports_sub_menu_callback()
    {
        include(EH_CRM_MAIN_VIEWS . "crm_reports_view.php");
    }
    
    function eh_crm_email_sub_menu_callback() {
        if(isset($_GET['code']))
        {
            $code = $_GET['code'];
            $oauth_obj = new EH_CRM_OAuth();
            $oauth_obj->get_token_uri($code,"code");
        }
        include(EH_CRM_MAIN_VIEWS . "crm_email_view.php");
    }    
    
    function eh_crm_import_sub_menu_callback()
    {
        include(EH_CRM_MAIN_VIEWS . "crm_import_view.php");
    }
}
