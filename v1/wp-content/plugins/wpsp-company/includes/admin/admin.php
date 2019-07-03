<?php
final class WPSPCompanyBackend {

    function loadScripts(){

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script('wpsp_company_admin', WPSP_COMP_URL . 'asset/js/admin.js?version='.WPSP_COMP_VERSION);
        wp_enqueue_style('wpsp_company_admin', WPSP_COMP_URL . 'asset/css/admin.css?version='.WPSP_COMP_VERSION);

        $localize_script_data=array(
            'wpsp_ajax_url'=>admin_url( 'admin-ajax.php' ),
            'insert_user'=>__('Please select user','wpsp-company'),
            'insert_name'=>__('Please enter required Name','wpsp-company'),
            'at_least_one_user'=>__('Please select atleast one user','wpsp-company'),
            'at_least_one_supervisor'=>__('Please select atleast one Supervisor','wpsp-company')
        );
        wp_localize_script( 'wpsp_company_admin', 'wpsp_company_data', $localize_script_data );

    }

    public function wpsp_addon_submenus_sections($addon_sections){

        $addon_sections['company-settings'] = array(
                'label' => __('Company / Usergroup','wpsp-company'),
                'file'  => WPSP_COMP_DIR . 'includes/admin/settings-tabs/wpsp_company_setting.php'
            );

        return $addon_sections;
    }

    public function wpsp_company_setting_update(){

        include WPSP_COMP_DIR . 'includes/admin/settings-tabs/wpsp_company_setting_update.php';
    }

    public function wpsp_ticket_restrict_rules($ticket_restrict_rules){

        include WPSP_COMP_DIR . 'includes/admin/wpsp_ticket_restrict_rules_users.php';
        return $ticket_restrict_rules;
    }

    public function wpsp_en_after_edit_recipients($recipients){

        include WPSP_COMP_DIR . 'includes/admin/notifications/wpsp_en_after_edit_recipients.php';
    }

    public function wpsp_addon_count($addon_count){
      
        return ++$addon_count;
      
    }
    
    public function license_setting(){
        
        include WPSP_COMP_DIR . 'includes/admin/license_setting.php';
        
    }
    
    public function license_setting_update(){
        
        $setting = sanitize_text_field( $_REQUEST['update_setting'] );
        
        if ( $setting === 'settings_addon_licenses' ){
            include WPSP_COMP_DIR . 'includes/admin/license_update.php';
        }
        
    }
    
}
?>
