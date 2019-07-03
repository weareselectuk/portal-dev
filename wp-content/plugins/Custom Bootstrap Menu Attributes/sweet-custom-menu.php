<?php
/*
Plugin Name: Bootstrap Menu Plugin
Plugin URL: http://chrismieloch.com
Description: Add in Menu Attributes
Version: 1
Author: Chris Mieloch
Author URI: http://chrismieloch.com
Contributors: Mieloch
Text Domain: rc_scm
Domain Path: languages
*/

class rc_sweet_custom_menu {

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {

		// load the plugin translation files
		add_action( 'init', array( $this, 'textdomain' ) );
		
		// add custom menu fields to menu
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'rc_scm_add_custom_nav_fields' ) );
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'rc_scm_add_custom_nav_fields2' ) );
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'rc_scm_add_custom_nav_fields3' ) );

		// save menu custom fields
		add_action( 'wp_update_nav_menu_item', array( $this, 'rc_scm_update_custom_nav_fields'), 10, 3 );
		
		// edit menu walker
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'rc_scm_edit_walker'), 10, 2 );

	} // end constructor
	
	
	/**
	 * Load the plugin's text domain
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function textdomain() {
		load_plugin_textdomain( 'rc_scm', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
	
	/**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function rc_scm_add_custom_nav_fields( $menu_item ) {
	
	   $menu_item->data_target = get_post_meta( $menu_item->ID, '_menu_item_data_target', true );
	    return $menu_item;
        	    
	}
	function rc_scm_add_custom_nav_fields2( $menu_item ) {
		
        $menu_item->data_toggle = get_post_meta( $menu_item->ID, '_menu_item_data_toggle', true );
	    return $menu_item;
      	    
	}
	function rc_scm_add_custom_nav_fields3( $menu_item ) {	
	   
        $menu_item->role = get_post_meta( $menu_item->ID, '_menu_item_role', true );
	    return $menu_item;
	    
	}
	
	/**
	 * Save menu custom fields
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function rc_scm_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
	
	    // Check if element is properly sent
	    if ( is_array( $_REQUEST['menu-item-data_target']) ) {
	       $data_target_value = $_REQUEST['menu-item-data_target'][$menu_item_db_id];
			update_post_meta( $menu_item_db_id, '_menu_item_data_target', $data_target_value );			
	    }
	    if ( is_array( $_REQUEST['menu-item-role']) ) {
	        $role_value = $_REQUEST['menu-item-role'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_role', $role_value );
	    }
         if ( is_array( $_REQUEST['menu-item-data_toggle']) ) {
	        $data_toggle_value = $_REQUEST['menu-item-data_toggle'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_data_toggle', $data_toggle_value );
	    }
	}
	
	/**
	 * Define new Walker edit
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function rc_scm_edit_walker($walker,$menu_id) {
	
	    return 'Walker_Nav_Menu_Edit_Custom';
	    
	}

}

// instantiate plugin's class
$GLOBALS['sweet_custom_menu'] = new rc_sweet_custom_menu();


include_once( 'edit_custom_walker.php' );
include_once( 'custom_walker.php' );