<?php
/**
 * Branda Administrator Message class.
 *
 * @package Branda
 * @subpackage AdminArea
 */
if ( ! class_exists( 'Branda_Admin_Message' ) ) {
	class Branda_Admin_Message extends Branda_Helper {

		protected $option_name = 'ub_admin_message';

		public function __construct() {
			parent::__construct();
			$this->set_options();
			/**
			 * UB admin actions
			 */
			add_filter( 'ultimatebranding_settings_admin_message', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_admin_message_process', array( $this, 'update' ) );
			/**
			 * Render module's output for admin pages
			 */
			add_action( 'admin_notices', array( $this, 'output' ) );
			/**
			 * Render module's output for network admin pages
			 */
			add_action( 'network_admin_notices', array( $this, 'output' ) );
			/**
			 * upgrade option
			 */
			add_action( 'init', array( $this, 'upgrade_options' ) );
			/**
			 * css output
			 */
			add_action( 'admin_head', array( $this, 'css' ) );
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
					'description' => __( 'This message will appear on top of every admin page. You can use this to show notifications or important announcements.', 'ub' ),
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
			$value = $this->get_value();
			if ( ! empty( $value ) && ! is_array( $value ) ) {
				$data = array(
					'admin' => array(
						'message' => $value,
					),
				);
				$this->update_value( $data );
			}
			/**
			 * Change option name
			 *
			 * @since 3.0.0
			 */
			$old_name = 'admin_message';
			$value = ub_get_option( $old_name );
			if ( ! empty( $value ) ) {
				$this->update_value( $value );
				ub_delete_option( $old_name );
			}
		}

		/**
		 * Renders the admin message
		 *
		 * @since 1.8
		 */
		public function output() {
			$message = $this->get_message();
			if ( empty( $message ) ) {
				return;
			}
			$message = stripslashes( $message );
			$message = wpautop( $message );
			printf(
				'<div id="branda-message" class="updated"><div class="branda-content">%s</div></div>',
				$message
			);
		}

		/**
		 * Print CSS if there is some message.
		 *
		 * @since 3.0.6
		 */
		public function css() {
			$message = $this->get_message();
			if ( empty( $message ) ) {
				return;
			}
			printf( '<style type="text/css" id="%s">', esc_attr( $this->get_name() ) );
			echo '#branda-message .branda-content:after{content:"";display:block;clear:both}';
			echo '#branda-message .branda-content{padding:12px 0}';
			echo '#branda-message .branda-content p:first-child{margin-top:0}';
			echo '#branda-message .branda-content p:last-child{margin-bottom:0}';
			echo '</style>';
			echo PHP_EOL;
		}

		/**
		 * Get content common finction (DRY).
		 *
		 * @since 3.0.6
		 */
		private function get_message() {
			$value = $this->get_value( 'admin', 'message_meta' );
			if ( ! empty( $value ) ) {
				return $value;
			}
			return $this->get_value( 'admin', 'message' );
		}
	}
}
new Branda_Admin_Message;