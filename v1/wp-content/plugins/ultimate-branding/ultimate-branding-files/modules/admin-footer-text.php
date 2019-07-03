<?php
if ( ! class_exists( 'ub_admin_footer_text' ) ) {
	class ub_admin_footer_text extends ub_helper {
		protected $option_name = 'admin_footer_text';

		public function __construct() {
			parent::__construct();
			$this->set_options();
			add_action( 'ultimatebranding_settings_footer', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_footer_process', array( $this, 'update' ), 10, 1 );
			// remove all the remaining filters for the admin footer so that they don't mess the footer up
			remove_all_filters( 'admin_footer_text' );
			add_filter( 'admin_footer_text', array( $this, 'output' ), 1, 1 );
			add_filter( 'update_footer' , '__return_empty_string', 99 );
			add_action( 'admin_head', array( $this, 'add_css_for_footer' ) );
			add_action( 'init', array( $this, 'upgrade_options' ) );
		}

		/**
		 * Chamge #wpfooter position to static.
		 *
		 * @since 1.9.9
		 */
		public function add_css_for_footer() {
			$admin_footer_text = ub_get_option( 'admin_footer_text' );
			if ( empty( $admin_footer_text ) ) {
				return;
			}
			echo '<style type="text/css">#wpfooter {position:static}</style>';
		}

		public function output( $footer_text ) {
			$value = $this->get_value( 'footer', 'content', '' );
			return do_shortcode( $value );
		}

		/**
		 * set options
		 *
		 * @since 2.1.0
		 */
		protected function set_options() {
			$this->options = array(
				'footer' => array(
					'title' => __( 'Admin Dashboard Footer Text', 'ub' ),
					'hide-reset' => true,
					'fields' => array(
						'content' => array(
							'type' => 'wp_editor',
							'label' => __( 'Text', 'ub' ),
						),
					),
				),
			);
		}

		/**
		 * Upgrade option
		 *
		 * @since 2.1.0
		 */
		public function upgrade_options() {
			$v = $this->get_value();
			if ( is_array( $v ) ) {
				return;
			}
			$data = array(
				'footer' => array(
					'content' => $v,
				),
			);
			$this->update_value( $data );
		}
	}
}

new ub_admin_footer_text;
