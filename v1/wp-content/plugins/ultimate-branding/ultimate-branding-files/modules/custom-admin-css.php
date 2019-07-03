<?php
if ( ! class_exists( 'ub_custom_admin_css' ) ) {
	class ub_custom_admin_css extends ub_helper {
		protected $option_name = 'global_admin_css';

		public function __construct() {
			parent::__construct();
			$this->set_options();
			add_action( 'ultimatebranding_settings_css', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_css_process', array( $this, 'update' ), 10, 1 );
			add_action( 'admin_head', array( $this, 'output' ) );
			add_action( 'init', array( $this, 'upgrade_options' ) );
		}

		/**
		 * Upgrade option
		 *
		 * @since 2.0.0
		 */
		public function upgrade_options() {
			$v = $this->get_value();
			if ( ! is_string( $v ) ) {
				return;
			}
			$v = array( 'admin' => array( 'css' => $v ) );
			$this->update_value( $v );
		}

		/**
		 * Set options
		 *
		 * @since 2.0.0
		 */
		protected function set_options() {
			$this->options = array(
				'admin' => array(
					'title' => __( 'Admin CSS', 'ub' ),
					'hide-th' => true,
					'hide-reset' => true,
					'fields' => array(
						'css' => array(
							'type' => 'css_editor',
							'label' => __( 'Cascading Style Sheets', 'ub' ),
							'description' => __( 'What is added here will be added to the header of every admin page for every site.', 'ub' ),
						),
					),
				),
			);
		}

		public function output() {
			$v = $this->get_value( 'admin', 'css' );
			if ( empty( $v ) ) {
				return;
			}
			printf(
				'<style id="%s" type="text/css">%s</style>',
				esc_attr( __CLASS__ ),
				esc_html( stripslashes( $v ) )
			);
		}
	}
}

new ub_custom_admin_css();