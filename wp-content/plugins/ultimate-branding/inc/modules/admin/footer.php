<?php
/**
 * Branda Admin Footer class.
 *
 * Class to handle admin footer content.
 *
 * @package Branda
 * @subpackage AdminArea
 */
if ( ! class_exists( 'Branda_Admin_Footer' ) ) {

	/**
	 * Class Branda_Admin_Footer.
	 */
	class Branda_Admin_Footer extends Branda_Helper {

		/**
		 * Module option name.
		 *
		 * @var string $option_name
		 */
		protected $option_name = 'ub_admin_footer';

		/**
		 * constructor.
		 */
		public function __construct() {
			parent::__construct();
			$this->set_options();
			add_filter( 'ultimatebranding_settings_admin_footer_text', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_admin_footer_text_process', array( $this, 'update' ), 10, 1 );
			// Remove all the remaining filters for the admin footer so that they don't mess the footer up.
			remove_all_filters( 'admin_footer_text' );
			add_filter( 'admin_footer_text', array( $this, 'output' ), 1, 1 );
			add_filter( 'update_footer', '__return_empty_string', 99 );
			add_action( 'admin_head', array( $this, 'add_css_for_footer' ) );
			add_action( 'init', array( $this, 'upgrade_options' ) );
		}

		/**
		 * Change #wpfooter position to static.
		 *
		 * @since 1.9.9
		 */
		public function add_css_for_footer() {
			$admin_footer_text = $this->get_value( 'footer', 'content' );
			if ( empty( $admin_footer_text ) ) {
				return;
			}
			echo '<style type="text/css">#wpfooter {position:static}</style>';
		}

		/**
		 * Output the footer content to footer.
		 *
		 * @param string $footer_text Footer content.
		 *
		 * @return string
		 */
		public function output( $footer_text ) {
			$value = $this->get_value( 'footer', 'content_meta', $this->get_value( 'footer', 'content', '' ) );
			return do_shortcode( $value );
		}

		/**
		 * Set options for the module admin page.
		 *
		 * @since 2.1.0
		 */
		protected function set_options() {
			$options = array(
				'footer' => array(
					'title' => __( 'Admin Footer Text', 'ub' ),
					'description' => __( 'Display a custom text in the footer of every admin page.', 'ub' ),
					'fields' => array(
						'content' => array(
							'type' => 'wp_editor',
						),
					),
				),
			);
			$this->options = $options;
		}

		/**
		 * Upgrade options from old structure.
		 *
		 * @since 2.1.0
		 */
		public function upgrade_options() {
			$value = $this->get_value();
			if ( ! is_array( $value ) ) {
				$data = array(
					'footer' => array(
						'content' => $value,
					),
				);
				$this->update_value( $data );
			}
			$value = ub_get_option( 'admin_footer_text' );
			if ( ! empty( $value ) ) {
				$this->update_value( $value );
				ub_delete_option( 'admin_footer_text' );
			}
		}
	}
}
new Branda_Admin_Footer;