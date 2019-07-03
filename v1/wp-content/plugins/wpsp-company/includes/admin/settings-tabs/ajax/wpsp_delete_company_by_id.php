<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $wpdb;

$comp_id=sanitize_text_field($_POST['company_id']);

$wpdb->delete( $wpdb->prefix.'wpsp_companies', array('id'=>$comp_id) );
$wpdb->delete( $wpdb->prefix.'wpsp_company_users', array('cid'=>$comp_id) );
