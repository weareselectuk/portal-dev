<?php
if ( ! class_exists( 'ub_remove_dashboard_link' ) ) {
	class ub_remove_dashboard_link {
		public function __construct() {
			add_action( 'user_admin_menu', array( $this, 'remove' ) );
		}
		public function remove() {
			$user_blogs = get_blogs_of_user( get_current_user_id() );
			if ( count( $user_blogs ) == 0 ) {
				remove_menu_page( 'index.php' );
				$current_url = $this->get_admin_current_page_url();
				if ( preg_match( '/user\//', $current_url ) && ! preg_match( '/profile.php/', $current_url ) ) {
					wp_redirect( 'profile.php' );
				}
			}
		}
		private function get_admin_current_page_url() {
			$pageURL = 'http';
			if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ) {
				$pageURL .= 's';
			}
			$pageURL .= '://';
			if ( isset( $_SERVER['SERVER_PORT'] ) && $_SERVER['SERVER_PORT'] != '80' ) {
				$pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
			} else {
				$pageURL .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			}
			return $pageURL;
		}
	}
}
new ub_remove_dashboard_link();
