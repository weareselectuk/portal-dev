<?php
if ( ! class_exists( 'ub_footer_content' ) ) {
	class ub_footer_content extends ub_helper {
		protected $option_name = 'ub_global_footer_content';

		public function __construct() {
			parent::__construct();
			$this->set_options();
			add_action( 'ultimatebranding_settings_footer', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_footer_process', array( $this, 'update' ), 10, 1 );
			add_action( 'wp_footer', array( $this, 'output' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'init', array( $this, 'upgrade_options' ) );
			add_filter( 'ultimate_branding_options_names', array( $this, 'add_legacy_options_names' ) );
		}

		/**
		 * Add legacy option names to delete
		 *
		 * @since 2.1.0
		 */
		public function add_legacy_options_names( $options ) {
			$keys = array( 'content', 'bgcolor', 'fixedheight', 'themefooter', 'shortcodes' );
			foreach ( $keys as $key ) {
				$options[] = 'global_footer_'.$key;
				$options[] = 'global_footer_main_'.$key;
			}
			return $options;
		}

		/**
		 * Upgrade option
		 *
		 * @since 2.1.0
		 */
		public function upgrade_options() {
			$v = $this->get_value();
			if ( ! empty( $v ) ) {
				return;
			}
			$data = array(
				'subsites' => array(
					'content' => ub_get_option( 'global_footer_content', '' ),
					'bg_color' => ub_get_option( 'global_footer_bgcolor', '' ),
					'height' => intval( ub_get_option( 'global_footer_fixedheight', '' ) ),
					'theme_footer' => ub_get_option( 'global_footer_themefooter', '' )? 'on':'off',
					'shortcodes' => ub_get_option( 'global_footer_shortcodes', '' )? 'on':'off',
				),
				'main' => array(
					'content' => ub_get_option( 'global_footer_main_content', '' ),
					'bg_color' => ub_get_option( 'global_footer_main_bgcolor', '' ),
					'height' => intval( ub_get_option( 'global_footer_main_fixedheight', '' ) ),
					'theme_footer' => ub_get_option( 'global_footer_main_themefooter', '' )? 'on':'off',
					'shortcodes' => ub_get_option( 'global_footer_main_shortcodes', '' )? 'on':'off',
				),
			);
			$this->update_value( $data );
		}

		/**
		 * Set options
		 *
		 * @since 2.1.0
		 */
		protected function set_options() {
			$this->module = 'footer';
			global $UB_network;
			$data = array(
				'subsites' => array(
					'title' => __( 'Footer Content For Subsites', 'ub' ),
					'fields' => array(
						'content' => array(
							'label' => __( 'Content', 'ub' ),
							'type' => 'wp_editor',
							'description' => __( 'What is added here will be shown on every blog or site in your network. You can add tracking code, embeds, terms of service links, etc.'. 'ub' ),
						),
						'bg_color' => array(
							'label' => __( 'Background Color', 'ub' ),
							'type' => 'color',
							'description' => __( 'Click on "Clear" button to make background transparent.', 'ub' ),
						),
						'height' => array(
							'label' => __( 'Fixed height', 'ub' ),
							'type' => 'number',
							'description' => __( 'Choose height of footer. Leave "0" to fit height to content.', 'ub' ),
							'default' => 0,
						),
						'theme_footer' => array(
							'type' => 'checkbox',
							'label' => __( 'Integrate in theme footer', 'ub' ),
							'description' => __( 'If selected, the plugin will try to place the footer content block inside the theme footer element.', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
						),
						'shortcodes' => array(
							'type' => 'checkbox',
							'label' => __( 'Proceed shortcodes', 'ub' ),
							'description' => __( 'Be careful it can break compatibility with themes with UI builders.', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'classes' => array( 'switch-button' ),
							'default' => 'off',
						),
					),
				),
				'main' => array(
					'title' => __( 'Footer Content For Main Site', 'ub' ),
					'fields' => array(
						'content' => array(
							'label' => __( 'Content', 'ub' ),
							'type' => 'wp_editor',
							'description' => __( 'What is added here will be shown on every blog or site in your network. You can add tracking code, embeds, terms of service links, etc.'. 'ub' ),
						),
						'bg_color' => array(
							'label' => __( 'Background Color', 'ub' ),
							'type' => 'color',
							'description' => __( 'Click on "Clear" button to make background transparent.', 'ub' ),
						),
						'height' => array(
							'label' => __( 'Fixed height', 'ub' ),
							'type' => 'number',
							'description' => __( 'Choose height of footer. Leave "0" to fit height to content.', 'ub' ),
							'default' => 0,
						),
						'theme_footer' => array(
							'type' => 'checkbox',
							'label' => __( 'Integrate in theme footer', 'ub' ),
							'description' => __( 'If selected, the plugin will try to place the footer content block inside the theme footer element.', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
						),
						'shortcodes' => array(
							'type' => 'checkbox',
							'label' => __( 'Proceed shortcodes', 'ub' ),
							'description' => __( 'Be careful it can break compatibility with themes with UI builders.', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'classes' => array( 'switch-button' ),
							'default' => 'off',
						),
					),
				),
			);
			if ( ! $UB_network ) {
				unset( $data['subsites'] );
				$data['main']['title'] = __( 'Footer Content', 'ub' );
			}
			$this->options = $data;
		}

		public function enqueue_scripts() {
			$root = 'modules/global-footer-content/global-footer-content.';
			wp_enqueue_style( __CLASS__, ub_files_url( $root.'css' )  . '', false, $this->build );
			wp_enqueue_script( __CLASS__, ub_files_url( $root.'js' ), array(), $this->build, true );
		}

		/**
		 * output common helper
		 *
		 * @since 2.1.0
		 */
		private function _output( $key ) {
			$v = $this->get_value( $key );
			$content = '';
			/**
			 * try content meta
			 */
			if ( isset( $v['content_meta'] ) && ! empty( $v['content_meta'] ) ) {
				$content = $v['content_meta'];
			}
			/**
			 * try content
			 */
			if ( empty( $content ) && isset( $v['content'] ) && ! empty( $v['content'] ) ) {
				$content = $v['content'];
				if ( ! empty( $content ) ) {
					$filters = array( 'wptexturize', 'convert_smilies', 'convert_chars', 'wpautop' );
					foreach ( $filters as $filter ) {
						$content = apply_filters( $filter, $content );
					}
				}
			}
			/**
			 * at least - check
			 */
			if ( empty( $content ) ) {
				return;
			}
			/**
			 * shortcodes
			 */
			if ( isset( $v['shortcodes'] ) && 'on' === $v['shortcodes'] ) {
				$content = do_shortcode( $content );
			}
			/**
			 * style
			 */
			$style = '';
			if ( isset( $v['bg_color'] ) ) {
				$style .= $this->css_background_color( $v['bg_color'] );
			}
			if ( isset( $v['height'] ) ) {
				$style .= $this->css_height( $v['height'] );
			}
			/**
			 * use theme footer
			 */
			$class = '';
			if ( isset( $v['theme_footer'] ) && 'on' === $v['theme_footer'] ) {
				$class = 'inside';
			}
			/**
			 * show
			 */
			printf(
				'<div id="ub_footer_content" style="%s" class="%s">%s</div>',
				esc_attr( $style ),
				esc_attr( $class ),
				$content
			);
		}

		/**
		 * output
		 *
		 * @since 2.0.0
		 */
		public function output() {
			/**
			 * main site footer
			 */
			if ( is_main_site() ) {
				$this->_output( 'main' );
				return;
			}
			$this->_output( 'subsites' );
		}
	}
}

new ub_footer_content();
