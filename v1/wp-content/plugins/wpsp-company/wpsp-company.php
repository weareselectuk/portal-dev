<?php
/**
 * Plugin Name: WP Support Plus Company/Usergroup Add-on
 * Plugin URI: https://www.wpsupportplus.com
 * Description: Users can see all tickets of their company/usergroup in WP Support Plus
 * Version: 2.0.4
 * Author: Pradeep Makone
 * Author URI: http://profiles.wordpress.org/pradeepmakone07/
 * Text Domain: wpsp-company
 * Domain Path: /lang
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( class_exists('WP_Support_Plus') ) {
    $GLOBALS['wpspcompany'] = new WPSP_COMPANY();
}

final class WPSP_COMPANY {

    /*
     * Constructor
     */
    public function __construct() {
        
				$this->define_constants();
        add_action( 'init', array($this,'load_textdomain') );
        
        $this->include_files();
				
				//plugin updator
        add_action('admin_init',array($this,'plugin_updator'));
				
    }

    function define_constants(){
        
				define( 'WPSP_COMP_PLUGIN_FILE', __FILE__ );
				define( 'WPSP_COMP_URL', plugin_dir_url( __FILE__ ) );
        define( 'WPSP_COMP_DIR', plugin_dir_path( __FILE__ ) );
				define( 'WPSP_COMP_VERSION', '2.0.4' );
				define( 'WPSP_COMP_STORE_ID', '1148' );
				
    }

		function load_textdomain(){
        
        $locale = apply_filters( 'plugin_locale', get_locale(), 'wpsp-company' );
        load_textdomain( 'wpsp-company', WP_LANG_DIR . '/wpsp/wpsp-company-' . $locale . '.mo' );
        load_plugin_textdomain( 'wpsp-company', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' );
    }

    function include_files(){
				
				include_once( WPSP_COMP_DIR.'includes/admin/installation.php' );
				
        include_once( WPSP_COMP_DIR.'includes/admin/wpsp_company_functions.php' );
        include_once( WPSP_COMP_DIR.'includes/admin/class-wpsp-company-ajax.php' );
				include_once( WPSP_COMP_DIR.'includes/admin/admin.php' );
				include_once( WPSP_COMP_DIR.'includes/frontend.php' );

				$backend  = new WPSPCompanyBackend();
				$frontend = new WPSPCompanyFrontend();

        $this->set_class_objects();

        if (is_admin()) {

						add_action( 'admin_enqueue_scripts', array( $backend, 'loadScripts') );
            add_filter( 'wpsp_addon_submenus_sections', array($backend, 'wpsp_addon_submenus_sections'), 10 , 1 );
            add_action( 'wpsp_setting_update', array($backend, 'wpsp_company_setting_update') );

            add_filter( 'wpsp_ticket_restrict_rules', array($backend, 'wpsp_ticket_restrict_rules'), 10, 1 );
						
						//email notification
						add_action( 'wpsp_en_after_edit_recipients', array($backend, 'wpsp_en_after_edit_recipients'),10,1);
						
						// License related actions
            add_filter( 'wpsp_addon_count', array( $backend, 'wpsp_addon_count') );
						add_action( 'wpsp_addon_license_setting', array( $backend, 'license_setting') );
						add_action( 'wpsp_setting_update', array( $backend, 'license_setting_update') );

        } else {

						add_filter( 'wpsp_ticket_cap_read', array($frontend, 'wpsp_ticket_cap_read'), 10, 2 );
            
        }
				add_filter( 'wpsp_en_mailer_emails', array($frontend, 'wpsp_en_mailer_emails'), 10 , 2 );
				add_filter( 'wpsp_ticket_cap_post_reply', array($frontend, 'wpsp_ticket_cap_post_reply'), 10, 2 );
				add_filter( 'wpsp_ticket_cap_close_ticket', array($frontend, 'wpsp_ticket_cap_close_ticket'), 10, 2 );
    }

    private function set_class_objects(){

        $this->functions=new WPSP_Company_Functions();
        $this->ajax = new WPSP_Company_Ajax();
    }
		
		function plugin_updator(){
				
				$license_key = get_option( 'wpsp_license_key_company' );
				if ($license_key) {
					$edd_updater = new EDD_SL_Plugin_Updater( WPSP_STORE_URL, __FILE__, array(
									'version' => WPSP_COMP_VERSION,
									'license' => $license_key,
									'item_id' => WPSP_COMP_STORE_ID,
									'author'  => 'Pradeep Makone',
									'url'     => site_url()
					) );
				}
				
    }
		
}

?>
