<?php
if ( ! class_exists( 'UltimateBrandingBase' ) ) {
	include_once dirname( __FILE__ ).'/class-ub-loader.php';
	class UltimateBrandingBase extends UB_Loader {
		/**
		 * base URL
		 *
		 * @since 2.1.0
		 */
		protected $base_url = null;

		protected $debug = false;
		protected $build = 0;
		protected $modules = array();
		protected $configuration = array();

		/**
		 * related modules
		 *
		 * @since 2.3.0
		 */
		protected $related = array();

		public function __construct() {
			parent::__construct();
			ub_set_ub_version();
			global $ub_version;
			$this->build = $ub_version;
			/**
			 * Always add this toolbar item, also on front-end.
			 *
			 * @since 1.9.1
			 */
			add_action( 'admin_bar_menu', array( $this, 'setup_toolbar' ), 999 );
		}

		/**
		 * Add link to Branding to the WP toolbar; only for multisite
		 * networks
		 *
		 *
		 * @since 1.9.1
		 * @param  WP_Admin_Bar $wp_admin_bar The toolbar handler object.
		 */
		public function setup_toolbar( $wp_admin_bar ) {
			if ( is_multisite() ) {
				$args = array(
					'id' => 'network-admin-branding',
					'title' => __( 'Branding', 'ub' ),
					'href' => add_query_arg( 'page', 'branding', network_admin_url( 'admin.php' ) ),
					'parent' => 'network-admin',
				);
				$wp_admin_bar->add_node( $args );
			}
		}

		/**
		 * get configuration array
		 *
		 * @since 2.3.0
		 */
		public function get_configuration() {
			return $this->configuration;
		}

		/**
		 * get related array
		 *
		 * @since 2.3.0
		 */
		public function get_related() {
			return $this->related;
		}
	}
}