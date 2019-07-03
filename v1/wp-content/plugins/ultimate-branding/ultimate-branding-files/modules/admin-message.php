<?php
if ( ! class_exists( 'ub_admin_message' ) ) {
	class ub_admin_message extends ub_helper {

		protected $option_name = 'admin_message';

		public function __construct() {
			parent::__construct();
			$this->set_options();
			/**
			 * UB admin actions
			 */
			add_action( 'ultimatebranding_settings_admin_message', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_admin_message_process', array( $this, 'update' ) );
			add_action( 'init', array( $this, 'upgrade_options' ) );
			/**
			 * Render module's output for admin pages
			 */
			add_action( 'admin_notices', array( $this, 'admin_message_output' ) );
			/**
			 * Render module's output for network admin pages
			 */
			add_action( 'network_admin_notices', array( $this, 'admin_message_output' ) );
		}

		/**
		 * set options
		 *
		 * @since 2.2.0
		 */
		protected function set_options() {
			$this->module = 'admin-message';
			$this->options = array(
				'admin' => array(
					'title' => __( 'Message', 'ub' ),
					'fields' => array(
						'message' => array(
							'type' => 'wp_editor',
							'hide-th' => true,
						),
					),
				),
			);
		}

		/**
		 * Upgrade option
		 *
		 * @since 2.2.0
		 */
		public function upgrade_options() {
			$v = $this->get_value();
			if ( empty( $v ) || is_array( $v ) ) {
				return;
			}
			$data = array(
				'admin' => array(
					'message' => $v,
				),
			);
			$this->update_value( $data );
		}


		/**
		 * Renders the admin message
		 *
		 * @since 1.8
		 */
		public function admin_message_output() {
			$v = $this->get_value( 'admin' );
			if ( empty( $v ) || ! is_array( $v ) ) {
				return;
			}
			$admin_message = '';

			if ( isset( $v['message_meta'] ) ) {
				$admin_message = $v['message_meta'];
			} else if ( isset( $v['message'] ) ) {
				$admin_message = $v['message'];
			}
			if ( empty( $admin_message ) ) {
				return;
			}
			printf(
				'<div id="ub-message" class="updated"><p>%s</p></div>',
				stripslashes( $admin_message )
			);
		}
	}
}

/**
 * Kick start the module
 */
new ub_admin_message;

