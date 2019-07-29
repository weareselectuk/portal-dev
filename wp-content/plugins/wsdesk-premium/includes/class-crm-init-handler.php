<?php

if (!defined('ABSPATH')) {
    exit;
}

class EH_CRM_Init_Handler {

    private $settings;

    function __construct() {
        add_action('admin_menu', array($this, 'eh_crm_menu_add'), 1);
        add_action('admin_init', array($this, 'eh_register_styles_scripts'),10);
        add_action('admin_head', array($this, 'tickets_order_count'));
        add_action('wp_ajax_eh_crm_search_post', array("CRM_Ajax", 'eh_crm_search_post'));
        add_action('wp_ajax_nopriv_eh_crm_search_post', array("CRM_Ajax", 'eh_crm_search_post'));
        add_action('wp_ajax_eh_crm_search_tags', array("CRM_Ajax", 'eh_crm_search_tags'));
        add_action('wp_ajax_eh_crm_ticket_general', array("CRM_Ajax", "eh_crm_ticket_general"));
        add_action('wp_ajax_eh_crm_ticket_appearance', array("CRM_Ajax", "eh_crm_ticket_appearance"));
        add_action('wp_ajax_eh_crm_settings_initiate_ticket', array("CRM_Ajax", "eh_crm_settings_initiate_ticket"));
        add_action('wp_ajax_eh_crm_settings_empty_trash', array("CRM_Ajax", "eh_crm_settings_empty_trash"));
        add_action('wp_ajax_eh_crm_settings_restore_trash', array("CRM_Ajax", "eh_crm_settings_restore_trash"));
        add_action('wp_ajax_eh_crm_refresh_tickets_count', array("CRM_Ajax", "eh_crm_refresh_tickets_count"));
        add_action('wp_ajax_eh_crm_woocommerce_settings', array("CRM_Ajax", "eh_crm_woocommerce_settings"));
        add_action('wp_ajax_eh_crm_ticket_field', array("CRM_Ajax", "eh_crm_ticket_field"));
        add_action('wp_ajax_eh_crm_ticket_field_delete', array("CRM_Ajax", "eh_crm_ticket_field_delete"));
        add_action('wp_ajax_eh_crm_ticket_field_activate_deactivate', array("CRM_Ajax", "eh_crm_ticket_field_activate_deactivate"));
        add_action('wp_ajax_eh_crm_ticket_field_edit', array("CRM_Ajax", "eh_crm_ticket_field_edit"));
        add_action('wp_ajax_eh_crm_ticket_label', array("CRM_Ajax", "eh_crm_ticket_label"));
        add_action('wp_ajax_eh_crm_ticket_label_delete', array("CRM_Ajax", "eh_crm_ticket_label_delete"));
        add_action('wp_ajax_eh_crm_ticket_label_edit', array("CRM_Ajax", "eh_crm_ticket_label_edit"));
        add_action('wp_ajax_eh_crm_ticket_tag', array("CRM_Ajax", "eh_crm_ticket_tag"));
        add_action('wp_ajax_eh_crm_ticket_tag_delete', array("CRM_Ajax", "eh_crm_ticket_tag_delete"));
        add_action('wp_ajax_eh_crm_ticket_tag_edit', array("CRM_Ajax", "eh_crm_ticket_tag_edit"));
        add_action('wp_ajax_eh_crm_ticket_view', array("CRM_Ajax", "eh_crm_ticket_view"));
        add_action('wp_ajax_eh_crm_ticket_view_edit', array("CRM_Ajax", "eh_crm_ticket_view_edit"));
        add_action('wp_ajax_eh_crm_ticket_view_delete', array("CRM_Ajax", "eh_crm_ticket_view_delete"));
        add_action('wp_ajax_eh_crm_ticket_view_activate_deactivate', array("CRM_Ajax", "eh_crm_ticket_view_activate_deactivate"));
        add_action('wp_ajax_eh_crm_trigger', array("CRM_Ajax", "eh_crm_trigger"));
        add_action('wp_ajax_eh_crm_ticket_trigger_delete', array("CRM_Ajax", "eh_crm_ticket_trigger_delete"));
        add_action('wp_ajax_eh_crm_ticket_trigger_activate_deactivate', array("CRM_Ajax", "eh_crm_ticket_trigger_activate_deactivate"));
        add_action('wp_ajax_eh_crm_trigger_edit', array("CRM_Ajax", "eh_crm_trigger_edit"));
        add_action('wp_ajax_eh_crm_agent_add', array("CRM_Ajax", "eh_crm_agent_add"));
        add_action('wp_ajax_eh_crm_agent_add_user', array("CRM_Ajax", "eh_crm_agent_add_user"));
        add_action('wp_ajax_eh_crm_edit_agent_html', array("CRM_Ajax", "eh_crm_edit_agent_html"));
        add_action('wp_ajax_eh_crm_edit_agent', array("CRM_Ajax", "eh_crm_edit_agent"));
        add_action('wp_ajax_eh_crm_remove_agent', array("CRM_Ajax", "eh_crm_remove_agent"));
        add_action('wp_ajax_eh_crm_new_ticket_post', array("CRM_Ajax", "eh_crm_new_ticket_post"));
        add_action('wp_ajax_nopriv_eh_crm_new_ticket_post', array("CRM_Ajax", "eh_crm_new_ticket_post"));
        add_action('wp_ajax_eh_crm_new_ticket_form', array("CRM_Ajax", "eh_crm_new_ticket_form"));
        add_action('wp_ajax_nopriv_eh_crm_new_ticket_form', array("CRM_Ajax", "eh_crm_new_ticket_form"));
        add_action('wp_ajax_eh_crm_ticket_single_view', array("CRM_Ajax", "eh_crm_ticket_single_view"));
        add_action('wp_ajax_eh_crm_ticket_single_save_props', array("CRM_Ajax", "eh_crm_ticket_single_save_props"));
        add_action('wp_ajax_eh_crm_ticket_single_delete', array("CRM_Ajax", "eh_crm_ticket_single_delete"));
        add_action('wp_ajax_eh_crm_ticket_multiple_delete', array("CRM_Ajax", "eh_crm_ticket_multiple_delete"));
        add_action('wp_ajax_eh_crm_ticket_refresh_left_bar', array("CRM_Ajax", "eh_crm_ticket_refresh_left_bar"));
        add_action('wp_ajax_eh_crm_ticket_refresh_right_bar', array("CRM_Ajax", "eh_crm_ticket_refresh_right_bar"));
        add_action('wp_ajax_eh_crm_ticket_reply_agent', array("CRM_Ajax", "eh_crm_ticket_reply_agent"));
        add_action('wp_ajax_eh_crm_ticket_single_ticket_action', array("CRM_Ajax", "eh_crm_ticket_single_ticket_action"));
        add_action('wp_ajax_eh_crm_ticket_single_ticket_priority', array("CRM_Ajax", "eh_crm_ticket_single_ticket_priority"));
        add_action('wp_ajax_eh_crm_ticket_single_ticket_site', array("CRM_Ajax", "eh_crm_ticket_single_ticket_site"));
        add_action('wp_ajax_eh_crm_ticket_single_ticket_asset', array("CRM_Ajax", "eh_crm_ticket_single_ticket_asset"));
        add_action('wp_ajax_eh_crm_ticket_single_ticket_client', array("CRM_Ajax", "eh_crm_ticket_single_ticket_client"));
        add_action('wp_ajax_eh_crm_ticket_single_ticket_user', array("CRM_Ajax", "eh_crm_ticket_single_ticket_user"));
        add_action('wp_ajax_eh_crm_ticket_multiple_ticket_action', array("CRM_Ajax", "eh_crm_ticket_multiple_ticket_action"));
        add_action('wp_ajax_eh_crm_ticket_search', array("CRM_Ajax", "eh_crm_ticket_search"));
        add_action('wp_ajax_eh_crm_ticket_add_new', array("CRM_Ajax", "eh_crm_ticket_add_new"));
        add_action('wp_ajax_eh_crm_ticket_new_submit', array("CRM_Ajax", "eh_crm_ticket_new_submit"));
        add_action('wp_ajax_eh_crm_check_ticket_request', array("CRM_Ajax", "eh_crm_check_ticket_request"));
        add_action('wp_ajax_nopriv_eh_crm_check_ticket_request', array("CRM_Ajax", "eh_crm_check_ticket_request"));
        add_action('wp_ajax_eh_crm_ticket_single_view_client', array("CRM_Ajax", "eh_crm_ticket_single_view_client"));
        add_action('wp_ajax_eh_crm_ticket_reply_raiser', array("CRM_Ajax", "eh_crm_ticket_reply_raiser"));
        add_action('wp_ajax_eh_crm_ticket_client_section_load', array("CRM_Ajax", "eh_crm_ticket_client_section_load"));
        add_action('wp_ajax_eh_crm_activate_oauth', array("CRM_Ajax", "eh_crm_activate_oauth"));
        add_action('wp_ajax_eh_crm_email_block_filter', array("CRM_Ajax", "eh_crm_email_block_filter"));
        add_action('wp_ajax_eh_crm_subject_block_filter', array("CRM_Ajax", "eh_crm_subject_block_filter"));
        add_action('wp_ajax_eh_crm_email_block_delete', array("CRM_Ajax", "eh_crm_email_block_delete"));
        add_action('wp_ajax_eh_crm_subject_block_delete', array("CRM_Ajax", "eh_crm_subject_block_delete"));
        add_action('wp_ajax_eh_crm_deactivate_oauth', array("CRM_Ajax", "eh_crm_deactivate_oauth"));
        add_action('wp_ajax_eh_crm_activate_email_protocol', array("CRM_Ajax", "eh_crm_activate_email_protocol"));
        add_action('wp_ajax_eh_crm_deactivate_email_protocol', array("CRM_Ajax", "eh_crm_deactivate_email_protocol"));
        add_action('wp_ajax_eh_crm_email_support_save', array("CRM_Ajax", "eh_crm_email_support_save"));
        add_action('wp_ajax_eh_crm_backup_data', array("CRM_Ajax", "eh_crm_backup_data"));
        add_action('wp_ajax_eh_crm_restore_data', array("CRM_Ajax", "eh_crm_restore_data"));
        add_action('wp_ajax_eh_crm_zendesk_library', array("CRM_Ajax", "eh_crm_zendesk_library"));
        add_action('wp_ajax_eh_crm_zendesk_pull_tickets', array("CRM_Ajax", "eh_crm_zendesk_pull_tickets"));
        add_action('wp_ajax_eh_crm_zendesk_stop_pull_tickets', array("CRM_Ajax", "eh_crm_zendesk_stop_pull_tickets"));
        add_action('wp_ajax_eh_crm_zendesk_save_data', array("CRM_Ajax", "eh_crm_zendesk_save_data"));
        add_action('wp_ajax_eh_crm_live_log', array("CRM_Ajax", "eh_crm_live_log"));
        add_action('wp_ajax_eh_crm_survey_ticket_form', array("CRM_Ajax", "eh_crm_survey_ticket_form"));
        add_action('wp_ajax_nopriv_eh_crm_survey_ticket_form', array("CRM_Ajax", "eh_crm_survey_ticket_form"));
        add_action('wp_ajax_eh_crm_woo_report_products', array("CRM_Ajax", "eh_crm_woo_report_products"));
        add_action('wp_ajax_eh_crm_woo_report_category', array("CRM_Ajax", "eh_crm_woo_report_category"));
        add_action('wp_ajax_eh_crm_ticket_new_template', array("CRM_Ajax", "eh_crm_ticket_new_template"));
        add_action('wp_ajax_eh_crm_ticket_template_delete', array("CRM_Ajax", "eh_crm_ticket_template_delete"));
        add_action('wp_ajax_eh_crm_ticket_template_search', array("CRM_Ajax", "eh_crm_ticket_template_search"));
        add_action('wp_ajax_eh_crm_ticket_template_search_single', array("CRM_Ajax", "eh_crm_ticket_template_search_single"));
        add_action('wp_ajax_eh_crm_ticket_update_template', array("CRM_Ajax", "eh_crm_ticket_update_template"));
        add_action('wp_ajax_eh_crm_ticket_preview_template', array("CRM_Ajax", "eh_crm_ticket_preview_template"));
        add_action('wp_ajax_eh_crm_ticket_multiple_template_send', array("CRM_Ajax", "eh_crm_ticket_multiple_template_send"));
        add_action('wp_ajax_eh_crm_ticket_edit_template_content', array("CRM_Ajax", "eh_crm_ticket_edit_template_content"));
        add_action('wp_ajax_eh_crm_get_settingsmeta_from_slug', array("CRM_Ajax", "eh_crm_get_settingsmeta_from_slug"));
        add_action('wp_ajax_wsdesk_api_create_ticket',array("CRM_Ajax","wsdesk_api_create_ticket"));
        add_action('wp_ajax_nopriv_wsdesk_api_create_ticket',array("CRM_Ajax","wsdesk_api_create_ticket"));
        add_action('wp_ajax_eh_crm_ticket_single_ticket_assignee',array("CRM_Ajax","eh_crm_ticket_single_ticket_assignee"));
        add_action('wp_ajax_eh_crm_bulk_edit',array("CRM_Ajax", "eh_crm_bulk_edit"));
        add_action('wp_ajax_eh_crm_ticket_change_label', array("CRM_Ajax", "eh_crm_ticket_change_label"));
        add_action('wp_ajax_eh_crm_verify_merge_tickets', array("CRM_Ajax", "eh_crm_verify_merge_tickets"));    
        add_action('wp_ajax_eh_crm_confirm_merge_tickets', array("CRM_Ajax", "eh_crm_confirm_merge_tickets"));
        add_action('wp_ajax_eh_crm_ticket_close_check_request', array("CRM_Ajax", "eh_crm_ticket_close_check_request"));
        add_action('wp_ajax_eh_crm_export_ticket_data', array("CRM_Ajax", "eh_crm_export_ticket_data"));
        add_action('wp_ajax_eh_crm_arrange_ticket_columns', array("CRM_Ajax", "eh_crm_arrange_ticket_columns"));
        add_action('wp_ajax_eh_crm_activate_deactivate_ticket_columns', array("CRM_Ajax", "eh_crm_activate_deactivate_ticket_columns"));
        
        if(EH_CRM_WOO_STATUS)
        {
            add_action('wp_ajax_eh_crm_get_woo_order_id', array("CRM_Ajax", "eh_crm_get_woo_order_id"));
            add_action('wp_ajax_eh_crm_woo_product_fetch', array("CRM_Ajax", "eh_crm_woo_product_fetch"));
            add_action('wp_ajax_eh_crm_woo_category_fetch', array("CRM_Ajax", "eh_crm_woo_category_fetch"));
            add_action('wp_ajax_eh_crm_woo_tags_fetch', array("CRM_Ajax", "eh_crm_woo_tags_fetch"));
            add_action('wp_ajax_eh_crm_woo_vendors_fetch', array("CRM_Ajax", "eh_crm_woo_vendors_fetch"));
        }
        if(EH_CRM_EDD_STATUS)
        {
            add_action('wp_ajax_eh_crm_get_edd_products', array("CRM_Ajax", "eh_crm_get_edd_products"));
        }
        $this->settings = new EH_CRM_Settings_Handler();
        add_shortcode('wsdesk_support', array($this, 'eh_crm_support_page'));
        add_shortcode('wsdesk_satisfaction', array($this, 'eh_crm_satisfaction_page'));
        add_action('wp_enqueue_scripts',array($this,'shortcode_scripts'));
        add_action( 'phpmailer_init', 'eh_crm_debug_error_log' );
        add_action( 'admin_footer', array( $this, 'deactivate_scripts' ) );
        add_action('wp_ajax_wsdesk_submit-uninstall-reason', array("CRM_Ajax", "uninstall_reason_submission"));
    }

    function eh_crm_menu_add() {
        $id = get_current_user_id();
        $user = new WP_User($id);
        $auth = FALSE;
        $user_role = $user->roles;
        $user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
        foreach($user_role as $value)
        {
            if(in_array($value, $user_roles_default))
            {
                $auth = TRUE;
            }
        }
        if($auth)
        {
            if(in_array("administrator", $user_role))
            {
                $cap = "administrator";
            }
            else
            {
                $cap = "crm_role";
            }
            add_menu_page(__('Tickets','wsdesk'), "WSDesk", $cap, "wsdesk_tickets", array($this->settings, "eh_crm_tickets_main_menu_callback"), "dashicons-tickets", 25);
            add_submenu_page('wsdesk_tickets', __('Tickets','wsdesk'), __('Tickets','wsdesk'), $cap, 'wsdesk_tickets', array($this->settings, 'eh_crm_tickets_main_menu_callback'));
            if($user->has_cap("settings_page") || in_array("administrator", $user_role))
            {
                add_submenu_page('wsdesk_tickets', __('Settings','wsdesk'), __('Settings','wsdesk'), $cap, 'wsdesk_settings', array($this->settings, 'eh_crm_settings_sub_menu_callback'));
            }
            if($user->has_cap("agents_page") || in_array("administrator", $user_role))
            {
                add_submenu_page('wsdesk_tickets', __('Agents','wsdesk'), __('Agents','wsdesk'), $cap, 'wsdesk_agents', array($this->settings, 'eh_crm_agents_sub_menu_callback'));
            }
            add_submenu_page('wsdesk_tickets', __('Reports','wsdesk'), __('Reports','wsdesk'), $cap, 'wsdesk_reports', array($this->settings, 'eh_crm_reports_sub_menu_callback'));
            if($user->has_cap("email_page") || in_array("administrator", $user_role))
            {
                add_submenu_page('wsdesk_tickets', __('E-Mail','wsdesk'), __('E-Mail','wsdesk'), $cap, 'wsdesk_email', array($this->settings, 'eh_crm_email_sub_menu_callback'));
            }
            if($user->has_cap("import_page") || in_array("administrator", $user_role))
            {
                add_submenu_page('wsdesk_tickets', __('Import','wsdesk'), __('Import','wsdesk'), $cap, 'wsdesk_import', array($this->settings, 'eh_crm_import_sub_menu_callback'));
            }
        }
    }
    
    public function tickets_order_count() {
        global $menu;
        $default = eh_crm_get_settingsmeta(0, 'default_label');
        $label = eh_crm_get_settings(array("slug" => $default), array("settings_id"));
        $label_color = eh_crm_get_settingsmeta($label[0]['settings_id'], "label_color");
        foreach ($menu as $key=>$value) {
            if ($value[0]=='WSDesk') {
                if ( $ticket_count = eh_crm_get_ticketmeta_value_count("ticket_label",$default)) {
                    $menu[$key][0] = "WSDesk <span class='update-plugins' style='background-color:".$label_color." !important;'><span class='plugin-count' id='wsdesk_tickets_count'>".count($ticket_count)."</span></span>";
                }
            }
        }
        
    }
    

    function eh_register_styles_scripts() {
        $page = (isset($_GET['page']) ? $_GET['page'] : '');
        $include_page = array("wsdesk_tickets", "wsdesk_settings", "wsdesk_agents", "wsdesk_email","wsdesk_reports","wsdesk_import");
        if (in_array($page, $include_page)) {
            wp_dequeue_script('jquery-ui-tooltip');
            if ($page === 'wsdesk_settings') {
                wp_enqueue_script("crm_settings", EH_CRM_MAIN_JS . "crm_settings.js");
                $js_var = eh_crm_js_translation_obj('settings');
                wp_localize_script('crm_settings', 'js_obj', $js_var);
                wp_enqueue_style("crm_settings", EH_CRM_MAIN_CSS . "crm_settings.css");
                wp_enqueue_script("dragDrop", EH_CRM_MAIN_JS . "DragDrop.js");
                wp_enqueue_style("select2", EH_CRM_MAIN_CSS . "select2.css");
                wp_enqueue_script("select2", EH_CRM_MAIN_JS . "select2.js");
                wp_enqueue_script( 'jquery-ui-datepicker');
                wp_enqueue_style( 'jquery-ui' , EH_CRM_MAIN_CSS."jquery-ui.css");
            }
            wp_enqueue_script("wsdesk_bootstrap", EH_CRM_MAIN_JS . "bootstrap.js");
            wp_enqueue_style("wsdesk_bootstrap", EH_CRM_MAIN_CSS . "bootstrap.css");
            wp_enqueue_script("dialog", EH_CRM_MAIN_JS . "dialog.js");
            wp_enqueue_style("dialog", EH_CRM_MAIN_CSS . "dialog.css");
            wp_enqueue_style("boot", EH_CRM_MAIN_CSS . "boot.css");
            wp_enqueue_script("jquery");
            if ($page === 'wsdesk_tickets') {
                wp_enqueue_script("cookie", EH_CRM_MAIN_JS . "wsdesk-cookie.js");
                wp_enqueue_script('quill', EH_CRM_MAIN_JS . "quill.min.js");
                wp_localize_script('quill', 'wsdesk_data', array
                    (
                    'url' => EH_CRM_MAIN_URL,
                    'ticket_admin_url' => admin_url("admin.php?page=wsdesk_tickets")
                    )
                );
                wp_enqueue_style("quill", EH_CRM_MAIN_CSS . "quill.snow.css");
                wp_enqueue_script("crm_tickets", EH_CRM_MAIN_JS . "crm_tickets.js");
                $js_var = eh_crm_js_translation_obj('tickets');
                wp_localize_script('crm_tickets', 'js_obj', $js_var);
                wp_enqueue_style("crm_tickets", EH_CRM_MAIN_CSS . "crm_tickets.css");
                wp_enqueue_style("select2", EH_CRM_MAIN_CSS . "select2.css");
                wp_enqueue_script("select2", EH_CRM_MAIN_JS . "select2.js");
                wp_enqueue_style("slider", EH_CRM_MAIN_CSS . "slider.css");
                wp_enqueue_style("new-admin-style", EH_CRM_MAIN_CSS . "new-admin-styles.css");
                wp_enqueue_script( 'jquery-ui-datepicker');
                wp_enqueue_style( 'jquery-ui' , EH_CRM_MAIN_CSS."jquery-ui.css");
            }
            if ($page === 'wsdesk_agents') {
                wp_enqueue_script("crm_agents", EH_CRM_MAIN_JS . "crm_agents.js");
                $js_var = eh_crm_js_translation_obj('agents');
                wp_localize_script('crm_agents', 'js_obj', $js_var);
                wp_enqueue_style("crm_agents", EH_CRM_MAIN_CSS . "crm_agents.css");
                wp_enqueue_style("select2", EH_CRM_MAIN_CSS . "select2.css");
                wp_enqueue_script("select2", EH_CRM_MAIN_JS . "select2.js");
            }
            if ($page === 'wsdesk_email') {
                wp_enqueue_style("select2", EH_CRM_MAIN_CSS . "select2.css");
                wp_enqueue_script("select2", EH_CRM_MAIN_JS . "select2.js");
                wp_enqueue_script("crm_email", EH_CRM_MAIN_JS . "crm_email.js");
                $js_var = eh_crm_js_translation_obj('email');
                wp_localize_script('crm_email', 'js_obj', $js_var);
                wp_enqueue_style("crm_email", EH_CRM_MAIN_CSS . "crm_email.css");
            }
            if($page === "wsdesk_reports")
            {
                wp_enqueue_style("select2", EH_CRM_MAIN_CSS . "select2.css");
                wp_enqueue_script("select2", EH_CRM_MAIN_JS . "select2.js");
                wp_enqueue_script("raphael", EH_CRM_MAIN_JS . "raphael.js");
                wp_enqueue_script("morris", EH_CRM_MAIN_JS . "morris.js");
                wp_enqueue_script("crm_reports", EH_CRM_MAIN_JS . "crm_reports.js");
                $js_var = eh_crm_js_translation_obj('reports');
                wp_localize_script('crm_reports', 'js_obj', $js_var);
                wp_enqueue_style("crm_reports", EH_CRM_MAIN_CSS . "crm_reports.css");
            }
            if ($page === 'wsdesk_import') {
                wp_enqueue_script("jquery-ui-sortable");
                wp_enqueue_style("select2", EH_CRM_MAIN_CSS . "select2.css");
                wp_enqueue_script("select2", EH_CRM_MAIN_JS . "select2.js");
                wp_enqueue_script("crm_import", EH_CRM_MAIN_JS . "crm_import.js");
                $js_var = eh_crm_js_translation_obj('import');
                wp_localize_script('crm_import', 'js_obj', $js_var);
                wp_enqueue_style("crm_import", EH_CRM_MAIN_CSS . "crm_import.css");
            }
        }
    }

    function eh_crm_support_page($atts) {
        $display = '';
        if(isset($atts['display']))
        {
            $display = $atts['display'];
            $cus_fields = (isset($atts['fields'])?(explode(',', $atts['fields'])):array());
            switch ($display) {
                case "form":
                case "form_only":
                    return include(EH_CRM_MAIN_VIEWS."shortcodes/crm_support_new.php");
                case "check_request":
                    return include(EH_CRM_MAIN_VIEWS."shortcodes/crm_support_check_request.php");
                case "form_support_request_table":
                    return include(EH_CRM_MAIN_VIEWS."shortcodes/crm_support_form_Support_Request_table.php"); 
                default:
                    return include(EH_CRM_MAIN_VIEWS."shortcodes/crm_support_page.php");
            }
        }
        else 
        {
            return include(EH_CRM_MAIN_VIEWS."shortcodes/crm_support_page.php");
        }
    }
    function eh_crm_satisfaction_page() {
        if(isset($_GET['id']) && isset($_GET['wsdesk_author']))
        {
            return include(EH_CRM_MAIN_VIEWS."shortcodes/crm_satisfaction_page.php");
        }
        else
        {
            return '<center><div class="satisfaction-div wsdesk_wrapper"><h1>Oops!</h1><h4>'.__('Access Denied!','wsdesk').'</h4></div></center>';
        }
    }
    
    function shortcode_scripts() {
        global $post;
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'wsdesk_support')) {
            wp_enqueue_script( 'jquery' );
            $handle = 'bootstrap.min.js';
            $handle1 = 'bootstrap.js';
            $handle2 = 'bootstrap.css';
            $list = 'enqueued';
            if (!wp_script_is( $handle, $list ) && !wp_script_is( $handle1, $list ) && !defined('WSDESK_UNLOAD_BOOT_JS')) {
                wp_enqueue_script("wsdesk_bootstrap", EH_CRM_MAIN_JS . "bootstrap.js");
            }
            if (!wp_style_is( $handle2, $list ) && !defined('WSDESK_UNLOAD_BOOT_CSS')) {
                wp_enqueue_style("wsdesk_bootstrap", EH_CRM_MAIN_CSS . "bootstrap.css");
            }
            wp_enqueue_script('support_scripts',EH_CRM_MAIN_JS . "crm_support.js");
            wp_enqueue_style("slider", EH_CRM_MAIN_CSS . "slider.css");
            wp_enqueue_style("support_styles", EH_CRM_MAIN_CSS . "crm_support.css");
            wp_enqueue_style("new_styles", EH_CRM_MAIN_CSS . "new-style.css");
            wp_enqueue_script( 'jquery-ui-datepicker');
            wp_enqueue_style( 'jquery-ui' , EH_CRM_MAIN_CSS."jquery-ui.css");
            $selected = eh_crm_get_settingsmeta(0, 'selected_fields');
            if(empty($selected))
            {
                $selected =array();
            }
            if(in_array("google_captcha", $selected))
            {
                wp_enqueue_script('captcha_scripts',"https://www.google.com/recaptcha/api.js");
            }
            wp_localize_script( 'support_scripts', 'support_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' )));
        }
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'wsdesk_satisfaction')) {
            wp_enqueue_script( 'jquery' );
            $handle = 'bootstrap.min.js';
            $handle1 = 'bootstrap.js';
            $handle2 = 'bootstrap.css';
            $list = 'enqueued';
            if (!wp_script_is( $handle, $list ) && !wp_script_is( $handle1, $list )) {
                wp_enqueue_script("wsdesk_bootstrap", EH_CRM_MAIN_JS . "bootstrap.js");
            }
            if (!wp_style_is( $handle2, $list )) {
                wp_enqueue_style("wsdesk_bootstrap", EH_CRM_MAIN_CSS . "bootstrap.css");
            }
            wp_enqueue_script('satisfaction_scripts',EH_CRM_MAIN_JS . "crm_satisfaction.js");
            wp_enqueue_style("satisfaction_styles", EH_CRM_MAIN_CSS . "crm_satisfaction.css");
            wp_localize_script( 'satisfaction_scripts', 'satisfaction_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' )));
        }
    }
    
    private function get_uninstall_reasons() {
        $reasons = array(
            array(
                'id'          => 'could-not-understand',
                'text'        => __('I couldn\'t understand how to make it work','wsdesk'),
                'type'        => 'textarea',
                'placeholder' => __('Would you like us to assist you?','wsdesk')
            ),
            array(
                'id'          => 'found-better-plugin',
                'text'        => __('I found a better plugin','wsdesk'),
                'type'        => 'text',
                'placeholder' => __('Which plugin?','wsdesk')
            ),
            array(
                'id'          => 'not-have-that-feature',
                'text'        => __('The plugin is great, but I need specific feature that you don\'t support','wsdesk'),
                'type'        => 'textarea',
                'placeholder' => __('Could you tell us more about that feature?','wsdesk')
            ),
            array(
                'id'          => 'is-not-working',
                'text'        => __('The plugin is not working','wsdesk'),
                'type'        => 'textarea',
                'placeholder' => __('Could you tell us a bit more whats not working?','wsdesk')
            ),
            array(
                'id'          => 'looking-for-other',
                'text'        => __('It\'s not what I was looking for','wsdesk'),
                'type'        => '',
                'placeholder' => ''
            ),
            array(
                'id'          => 'did-not-work-as-expected',
                'text'        => __('The plugin didn\'t work as expected','wsdesk'),
                'type'        => 'textarea',
                'placeholder' => __('What did you expect?','wsdesk')
            ),
            array(
                'id'          => 'other',
                'text'        => __('Other','wsdesk'),
                'type'        => 'textarea',
                'placeholder' => __('Could you tell us a bit more?','wsdesk')
            ),
        );

        return $reasons;
    }
    public function deactivate_scripts() {
        global $pagenow;

        if ( 'plugins.php' != $pagenow ) {
            return;
        }

        $reasons = $this->get_uninstall_reasons();
        $current_user = wp_get_current_user();
        $user_email = $current_user->user_email;
        ?>

        <div class="wsdesk-modal" id="wsdesk-wsdesk-modal">
            <div class="wsdesk-modal-wrap">
                <div class="wsdesk-modal-header">
                    <h3><?php _e( 'If you have a moment, please let us know why you are deactivating:', 'wsdesk' ); ?></h3>
                </div>

                <div class="wsdesk-modal-body">
                    <ul class="reasons">
                        <?php foreach ($reasons as $reason) { ?>
                            <li data-type="<?php echo esc_attr( $reason['type'] ); ?>" data-placeholder="<?php echo esc_attr( $reason['placeholder'] ); ?>">
                                <label><input type="radio" name="selected-reason" value="<?php echo $reason['id']; ?>"> <?php echo $reason['text']; ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                    <br>
                    <input type="checkbox" name="allow_contacting" value="1" id="allow_contacting">
                    <label>
                        <strong><?php _e('Contact me back','wsdesk');?></strong>
                        <br>
                        <?php _e('Check this box to let us collect your email along with your feedback, so that we can contact you back to address your concern.','wsdesk');?>
                    </label>
                    <br>
                    <input type="text" name="email" id="email" value="<?php echo $user_email;?>" style="display: none;">
                    <br>
                    <label>
                        <?php _e('You can also contact us through the 
                        <a href="https://elextensions.com/support/">support page.</a>','wsdesk');?>
                    </label>
                </div>

                <div class="wsdesk-modal-footer">
                    <a href="#" class="dont-bother-me"><?php _e( 'I rather wouldn\'t say', 'wsdesk' ); ?></a>
                    <button class="button-primary wsdesk-model-submit"><?php _e( 'Submit & Deactivate', 'wsdesk' ); ?></button>
                    <button class="button-secondary wsdesk-model-cancel"><?php _e( 'Cancel', 'wsdesk' ); ?></button>
                </div>
            </div>
        </div>

        <style type="text/css">
            .wsdesk-modal {
                position: fixed;
                z-index: 99999;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                background: rgba(0,0,0,0.5);
                display: none;
            }

            .wsdesk-modal.modal-active {
                display: block;
            }

            .wsdesk-modal-wrap {
                width: 50%;
                position: relative;
                margin: 10% auto;
                background: #fff;
            }

            .wsdesk-modal-header {
                border-bottom: 1px solid #eee;
                padding: 8px 20px;
            }

            .wsdesk-modal-header h3 {
                line-height: 150%;
                margin: 0;
            }

            .wsdesk-modal-body {
                padding: 5px 20px 20px 20px;
            }
            .wsdesk-modal-body .input-text,.wsdesk-modal-body textarea {
                width:75%;
            }
            .wsdesk-modal-body .reason-input {
                margin-top: 5px;
                margin-left: 20px;
            }
            .wsdesk-modal-footer {
                border-top: 1px solid #eee;
                padding: 12px 20px;
                text-align: right;
            }
        </style>

        <script type="text/javascript">
            (function($) {
                $(function() {
                    var modal = $( '#wsdesk-wsdesk-modal' );
                    var deactivateLink = '';

                    $( '#the-list' ).on('click', 'a.wsdesk-deactivate-link', function(e) {
                        e.preventDefault();

                        modal.addClass('modal-active');
                        deactivateLink = $(this).attr('href');
                        modal.find('a.dont-bother-me').attr('href', deactivateLink).css('float', 'left');
                    });

                    modal.on('click', 'button.wsdesk-model-cancel', function(e) {
                        e.preventDefault();

                        modal.removeClass('modal-active');
                    });

                    modal.on('click', 'input[type="radio"]', function () {
                        var parent = $(this).parents('li:first');

                        modal.find('.reason-input').remove();

                        var inputType = parent.data('type'),
                            inputPlaceholder = parent.data('placeholder'),
                            reasonInputHtml = '<div class="reason-input">' + ( ( 'text' === inputType ) ? '<input type="text" class="input-text" size="40" />' : '<textarea rows="5" cols="45"></textarea>' ) + '</div>';

                        if ( inputType !== '' ) {
                            parent.append( $(reasonInputHtml) );
                            parent.find('input, textarea').attr('placeholder', inputPlaceholder).focus();
                        }
                    });

                    modal.on('click', 'button.wsdesk-model-submit', function(e) {
                        e.preventDefault();

                        var button = $(this);

                        if ( button.hasClass('disabled') ) {
                            return;
                        }

                        var $radio = $( 'input[type="radio"]:checked', modal );

                        var $selected_reason = $radio.parents('li:first'),
                            $input = $selected_reason.find('textarea, input[type="text"]');

                        var allow_contacting =  $('#allow_contacting:checkbox:checked').length;

                        var email = $("#email").val();

                        $.ajax({
                            url: ajaxurl,
                            type: 'POST',
                            data: {
                                action: 'wsdesk_submit-uninstall-reason',
                                reason_id: ( 0 === $radio.length ) ? 'none' : $radio.val(),
                                reason_info: ( 0 !== $input.length ) ? $input.val().trim() : '',
                                allow_contacting: allow_contacting,
                                email: email
                            },
                            beforeSend: function() {
                                button.addClass('disabled');
                                button.text('Processing...');
                            },
                            complete: function() {
                                window.location.href = deactivateLink;
                            }
                        });
                    });
                    modal.on('click', '#allow_contacting',function(e){
                        if($('#allow_contacting:checkbox:checked').length > 0)
                        {
                            $("#email").show();
                        }
                        else
                        {
                            $("#email").hide();
                        }
                    });
                });
            }(jQuery));
        </script>

        <?php
    }
    Public static function factory_reset()
    {

        if(isset($_GET['page']) && $_GET['page']==='wsdesk_factory_reset')
        {
            $ticket_ids=eh_crm_get_all_tickets();
            if(!empty($ticket_ids))
            {
                for($i=0;$i<count($ticket_ids);$i++)
                {
                    $attachments=eh_crm_get_ticketmeta($ticket_ids[$i]['ticket_id'],'ticket_attachment_path');
                    if(!empty($attachments))
                    {
                        foreach ($attachments as $key => $value) {
                            unlink($value);
                        }
                    }
                }

            }
            if(!function_exists('wp_get_current_user')) {
                include(ABSPATH . "wp-includes/pluggable.php"); 
            }
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            global $wpdb;
            $postid = get_option("wsdesk_support_page");
                wp_delete_post( $postid, true);
            $table_prefix = $wpdb->prefix;
            $wpdb->suppress_errors();
            $sql_settings = "DROP TABLE ".$table_prefix."wsdesk_tickets";
            if(!$wpdb->query($sql_settings))
            {
                echo "<script>alert('Factory reset was unsuccessfull. You may not have DROP privilige.');window.location='".admin_url('plugins.php')."';</script>";
                exit;
            }
            else
            {
                $sql_settings = "DROP TABLE ".$table_prefix."wsdesk_ticketsmeta";
                $wpdb->query($sql_settings);
                $sql_settings = "DROP TABLE ".$table_prefix."wsdesk_settings";
                $wpdb->query($sql_settings);
                $sql_settings = "DROP TABLE ".$table_prefix."wsdesk_settingsmeta;";
                $wpdb->query($sql_settings);
                $sql_settings = "DELETE FROM ".$table_prefix."options WHERE `option_name` LIKE '%wsdesk%';";
                $wpdb->query($sql_settings);
                return true;
            }
            
        }
        return false;
    }
}
