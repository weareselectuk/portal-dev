<?php
/**
 * Plugin Name: M2P Disable Custom Super Admin On Single Site
 * Description: On single site if a user has capability delete_users, WP see this user as a Super Admin. This MU plugin will remove this capability of this user if current page is not users.php.
 * Author: Thobk @ WPMUDEV
 * Author URI: https://premium.wpmudev.org/profile/tho2757
 * License: GPLv2 or later
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'plugins_loaded', 'wpmudev_ms_disable_custom_super_admin_single_site_func', 100 );

function wpmudev_ms_disable_custom_super_admin_single_site_func() {
	if ( ! is_multisite() && defined( 'MS_IS_PRO' ) && MS_IS_PRO && class_exists( 'MS_Model_Member' ) ) {
		add_filter( 'user_has_cap', 'wpmudev_ms_disabled_super_admin_user_custom_role', 10, 4 );

		function wpmudev_ms_disabled_super_admin_user_custom_role( $allcaps, $caps, $args, $wp_user ){
			global $pagenow;
			if( 'users.php' !== $pagenow && isset( $allcaps['delete_users'] ) && $allcaps['delete_users'] && ! ( isset( $allcaps['manage_options'] ) && $allcaps['manage_options'] ) ){
				unset( $allcaps['delete_users'] );
			}
			return $allcaps;
		}
	}else{
		add_action( 'admin_notices', function () {
			$class   = 'notice notice-warning';
			$required = is_multisite() ? __("Single site", 'membership2') : __('Membership2 Pro Plugin', 'membership2');
			$message = sprintf(__( '%s is required, deactiving MU Plugin "M2P Disable Custom Super Admin On Single Site"!', 'membership2' ), $required );

			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
		} );

		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
}