<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WPSP_Company_Ajax' ) ) :

    /**
     * Ajax class for WPSP.
     * @class WPSP_Ajax
     */
    class WPSP_Company_Ajax {

        public function __construct(){
             $ajax_events = array(
                 'search_users_for_company' =>false,
                 'wpsp_delete_company_by_id'=>false
             );

             foreach ($ajax_events as $ajax_event => $nopriv) {
                add_action('wp_ajax_' . $ajax_event, array($this, $ajax_event));
                if ($nopriv) {
                    add_action('wp_ajax_nopriv_' . $ajax_event, array($this, $ajax_event));
                }
            }
        }

        function search_users_for_company(){

            include WPSP_COMP_DIR . 'includes/admin/settings-tabs/ajax/wpsp_search_users_for_company.php';
            die();
        }

        function wpsp_delete_company_by_id(){

            include WPSP_COMP_DIR . 'includes/admin/settings-tabs/ajax/wpsp_delete_company_by_id.php';
            die();
        }
    }

endif;
