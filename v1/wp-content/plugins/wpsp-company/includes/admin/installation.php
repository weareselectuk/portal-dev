<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WPSP_Company_Install' ) ) :
	/**
	 * WPSP installation and updating class
	 */
	class WPSP_Company_Install {

			/**
			 * Constructor
			 */
			public function __construct() {

					register_activation_hook( WPSP_COMP_PLUGIN_FILE, array($this,'install') );
					register_deactivation_hook( WPSP_COMP_PLUGIN_FILE, array($this,'deactivate') );
					$this->check_version();
			}

			/**
			 * Check version of WPSP
			 */
			private function check_version(){

					$installed_version = get_option( 'wp_support_plus_company_version' );
					if( $installed_version != WPSP_COMP_VERSION ){
							$this->install();
					}

					// last version where upgrade check done
					$upgrade_version = get_option( 'wpsp_comp_upgrade_version' );
					if( $upgrade_version != WPSP_COMP_VERSION ){
							$this->upgrade();
							update_option( 'wpsp_comp_upgrade_version', WPSP_COMP_VERSION );
					}

			}

			/**
			 * Install WPSP
			 */
			function install(){

					$this->create_tables();
					update_option( 'wp_support_plus_company_version', WPSP_COMP_VERSION );
			}

			/**
			 * Deactivate WPSP actions
			 */
			public function deactivate() {

			}

			/**
			 * Create tables for WPSP
			 */
			function create_tables(){
					global $wpdb;

					require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
					
					$collate = '';

					if ( $wpdb->has_cap( 'collation' ) ) {
									$collate = $wpdb->get_charset_collate();
					}
					
					$tables ="
						CREATE TABLE {$wpdb->prefix}wpsp_companies (
	              id integer NOT NULL AUTO_INCREMENT,
	              name TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	              PRIMARY KEY  (id)
	          )$collate;
						CREATE TABLE {$wpdb->prefix}wpsp_company_users (
                id integer NOT NULL AUTO_INCREMENT,
                cid integer NOT NULL,
                userid integer NOT NULL,
                supervisor integer NOT NULL DEFAULT 1,
                PRIMARY KEY  (id)
            )$collate;
					";
					
					dbDelta( $tables );
			}


			/**
			 * Upgrade process begin
			 */
			function upgrade(){
					global $wpdb;
					$upgrade_version = get_option( 'wpsp_comp_upgrade_version' ) ? get_option( 'wpsp_comp_upgrade_version' ) : 0;

					//Version 2.0.0
					if( $upgrade_version < '2.0.0' ){
						
							$company = $wpdb->get_results( "select * from {$wpdb->prefix}wpsp_companies" );
							
							if(!empty($company)){
								foreach ($company as $comp) {
											if(!empty($comp->users)){
												
														$comp_users=explode(',', $comp->users);
														foreach ($comp_users as $uid) {
																$values=array(
																	'cid'				=>$comp->id,
																	'userid'		=>$uid,
																	'supervisor'=>1
																);
																$wpdb->insert($wpdb->prefix.'wpsp_company_users',$values);
														}
														
											}
									}
							}
					}
			}
}

endif;

new WPSP_Company_Install();
