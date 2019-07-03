<?php

if ( ! class_exists( 'ub_admin_bar_logo' ) ) {

	class ub_admin_bar_logo extends ub_helper {

		protected $option_name = 'admin_bar_logo';

		public function __construct() {
			parent::__construct();
			$this->set_options();
			add_action( 'ultimatebranding_settings_adminbar', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_adminbar_process', array( $this, 'update' ), 10, 1 );
			add_action( 'admin_print_styles', array( $this, 'output' ) );
			add_action( 'wp_head', array( $this, 'output' ) );
		}

		/**
		 * set options
		 *
		 * @since 1.8.8
		 */
		protected function set_options() {
			$this->options = array(
				'admin_bar_logo' => array(
					'title' => __( 'Admin Bar Logo', 'ub' ),
					'hide-reset' => true,
					'fields' => array(
						'logo_upload' => array(
							'type' => 'media',
							'label' => __( 'Logo image', 'ub' ),
							'description' => __( 'Upload your own logo.', 'ub' ),
						),
					),
				),
			);
		}

		/**
		 * output
		 *
		 * @since 1.8.8
		 */
		public function output() {
			$value = ub_get_option( $this->option_name );
			if ( $value == 'empty' ) {
				$value = '';
			}
			if ( empty( $value ) ) {
				return;
			}
			printf( '<style type="text/css" id="%s">', esc_attr( __CLASS__ ) );
			/**
			 * Logo
			 */
			if ( isset( $value['admin_bar_logo'] ) ) {
				$v = $value['admin_bar_logo'];
				if ( isset( $v['logo_upload_meta'] ) ) {
					$src = $v['logo_upload_meta'][0];
?>
body #wpadminbar #wp-admin-bar-wp-logo > .ab-item {
    background-image: url(<?php echo $src; ?>);
    background-repeat: no-repeat;
    background-position: 50%;
    background-size: 80%;
}
body #wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
    content: " ";
}
<?php
				}
			}
			echo '</style>';
		}
	}

}

new ub_admin_bar_logo();
