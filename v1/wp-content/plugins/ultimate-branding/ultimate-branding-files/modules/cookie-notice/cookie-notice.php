<?php
/**
 *
 * @since 2.2.0
 */
if ( ! class_exists( 'ub_cookie_notice' ) ) {
	class ub_cookie_notice extends ub_helper {

		protected $option_name  = __CLASS__;
		private $cookie_name    = __CLASS__;
		private $user_meta_name = __CLASS__;

		public function __construct() {
			parent::__construct();
			$this->set_options();
			/**
			 * UB admin actions
			 */
			add_action( 'ultimatebranding_settings_cookie_notice', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_cookie_notice_process', array( $this, 'update' ) );
			add_action( 'ultimatebranding_deactivate_plugin', array( $this, 'delete_user_data' ) );
			/**
			 * front end
			 */
			add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
			add_action( 'wp_footer', array( $this, 'add_cookie_notice' ), PHP_INT_MAX );
			add_action( 'wp_head', array( $this, 'add_cookie_notice_css' ), PHP_INT_MAX );
			add_action( 'wp_ajax_ub_cookie_notice', array( $this, 'save_user_meta' ) );
		}

		/**
		 * How it should look?
		 *
		 * @since 2.2.0
		 */
		public function add_cookie_notice_css() {
			printf( '<style type="text/css" id="%s">', esc_attr( __CLASS__ ) );
			/**
			 * #ub-cookie-notice
			 */
			$this->css_background_transparency( 'box', 'background_color', 'background_transparency', '#ub-cookie-notice' );
			$this->css_color_from_data( 'box', 'color', '#ub-cookie-notice' );
			/**
			 * #ub-cookie-notice button
			 */
			echo '#ub-cookie-notice .button {';
			echo $this->css_background_color( $this->get_value( 'button', 'background_color' ) );
			echo $this->css_color( $this->get_value( 'button', 'color' ) );
			echo $this->css_radius( $this->get_value( 'button', 'radius' ) );
			echo '}';
			echo '#ub-cookie-notice .button:hover {';
			echo $this->css_background_color( $this->get_value( 'button', 'background_color_hover' ) );
			echo $this->css_color( $this->get_value( 'button', 'color_hover' ) );
			echo '}';
			echo '</style>';
		}

		/**
		 * delete user data
		 *
		 * @since 2.2.0
		 */
		public function delete_user_data() {
			global $wpdb;
			$sql = $wpdb->prepare( "delete from {$wpdb->usermeta} where meta_key = %s", $this->user_meta_name );
			$wpdb->query( $sql );
		}

		/**
		 * set options
		 *
		 * @since 2.2.0
		 */
		protected function set_options() {
			$this->module = 'cookie-notice';
			$this->cookie_name = sprintf( '%s_%d', __CLASS__, $this->get_value( 'configuration', 'cookie_version' ) );
			$this->options = array(
				'configuration' => array(
					'title' => __( 'Configuration', 'ub' ),
					'fields' => array(
						'message' => array(
							'type' => 'wp_editor',
							'label' => __( 'Message', 'ub' ),
							'default' => __( 'We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it.', 'ub' ),
						),
						'button_text' => array(
							'label' => __( 'Button text', 'ub' ),
							'default' => __( 'OK', 'ub' ),
						),
						'reloading' => array(
							'type' => 'checkbox',
							'label' => __( 'Reloading', 'ub' ),
							'description' => __( 'Enable to reload the page after cookies are accepted.', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
						),
						'logged' => array(
							'type' => 'checkbox',
							'label' => __( 'Logged users', 'ub' ),
							'description' => __( 'Show for logged users?', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
						),
						'cookie_expiry' => array(
							'type' => 'select',
							'label' => __( 'Cookie expiry', 'ub' ),
							'options' => array(
								HOUR_IN_SECONDS => __( '1 hour', 'ub' ),
								DAY_IN_SECONDS => __( '1 day', 'ub' ),
								WEEK_IN_SECONDS => __( '1 week', 'ub' ),
								MONTH_IN_SECONDS => __( '1 month', 'ub' ),
								3 * MONTH_IN_SECONDS => __( '3 months', 'ub' ),
								6 * MONTH_IN_SECONDS => __( '6 months', 'ub' ),
								YEAR_IN_SECONDS => __( '1 year', 'ub' ),
							),
							'default' => MONTH_IN_SECONDS,
							'description' => __( 'The ammount of time that cookie should be stored for.', 'ub' ),
						),
						'cookie_version' => array(
							'type' => 'number',
							'label' => __( 'Cookie Version', 'ub' ),
							'min' => 1,
							'description' => __( 'A version number for the cookie - update this to invalidate the cookie and force all users to view the notification again.', 'ub' ),
							'default' => 1,
						),
					),
				),
				'privacy_policy' => array(
					'title' => __( 'Privacy Policy', 'ub' ),
					'fields' => array(
						'show' => array(
							'type' => 'checkbox',
							'label' => __( 'Privacy Policy', 'ub' ),
							'description' => __( 'Enable privacy policy link.', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'privacy-policy',
						),
						'text' => array(
							'description' => __( 'The text of the privacy policy button.', 'ub' ),
							'master' => 'privacy-policy',
							'default' => _x( 'Privacy Policy', 'Privacy Policy button text', 'ub' ),
						),
						'link_in_new_tab' => $this->get_options_link_in_new_tab( array( 'master' => 'privacy-policy' ) ),
					),
				),
				'box' => array(
					'title' => __( 'Box', 'ub' ),
					'fields' => array(
						'position' => array(
							'type' => 'radio',
							'label' => __( 'Position', 'ub' ),
							'options' => array(
								'top' => __( 'Top', 'ub' ),
								'bottom' => __( 'Bottom', 'ub' ),
							),
							'description' => __( 'Select location for your cookie notice.', 'ub' ),
							'default' => 'bottom',
						),
						/*
						'animation' => array(
							'type' => 'radio',
							'label' => __( 'Animation', 'ub' ),
							'options' => array(
								'none' => __( 'None', 'ub' ),
								'fade' => __( 'Fade', 'ub' ),
								'slide' => __( 'Slide', 'ub' ),
							),
							'description' => __( '', 'ub' ),
							'default' => 'none',
                        ),
                         */
						'color' => array(
							'type' => 'color',
							'label' => __( 'Color', 'ub' ),
							'default' => '#fafafa',
						),
						'background_color' => array(
							'type' => 'color',
							'label' => __( 'Background Color', 'ub' ),
							'default' => '#0085ba',
						),
						'background_transparency' => array(
							'type' => 'number',
							'label' => __( 'Background Transparency', 'ub' ),
							'min' => 0,
							'max' => 100,
							'default' => 100,
							'classes' => array( 'ui-slider' ),
							'after' => '%',
						),
					),
				),
				'button' => array(
					'title' => __( 'Buttons', 'ub' ),
					'fields' => array(
						'color' => array(
							'type' => 'color',
							'label' => __( 'Color', 'ub' ),
							'default' => '#ffffff',
						),
						'background_color' => array(
							'type' => 'color',
							'label' => __( 'Background Color', 'ub' ),
							'default' => '#222222',
						),
						'color_hover' => array(
							'type' => 'color',
							'label' => __( 'Color Hover', 'ub' ),
							'default' => '#ffffff',
						),
						'background_color_hover' => array(
							'type' => 'color',
							'label' => __( 'Background Color Hover', 'ub' ),
							'default' => '#444444',
						),
						'radius' => array(
							'type' => 'number',
							'label' => __( 'Buttons Radius', 'ub' ),
							'description' => __( 'How much would you like to round the border?', 'ub' ),
							'attributes' => array( 'placeholder' => '20' ),
							'default' => 5,
							'min' => 0,
							'classes' => array( 'ui-slider' ),
							'after' => __( 'px', 'ub' ),
						),
					),
				),
			);
			/**
			 * unset Privacy Policy Page if WP function does not exist.
			 */
			if ( ! function_exists( 'get_privacy_policy_url' ) ) {
				unset( $this->options['privacy_policy'] );
			}
		}

		/**
		 * Load scripts and styles - frontend.
		 *
		 * @since 2.2.0
		 */
		public function wp_enqueue_scripts() {
			/**
			 * javascript
			 */
			$file = ub_files_url( 'modules/cookie-notice/assets/cookie-notice-front.js' );
			wp_enqueue_script( __CLASS__, $file, array( 'jquery' ), $this->build, true );
			$value = intval( $this->get_value( 'configuration', 'cookie_expiry' ) );
			$data = array(
				'cookie' => array(
					'domain'   => defined( 'COOKIE_DOMAIN' ) && COOKIE_DOMAIN ? COOKIE_DOMAIN : '',
					'name'     => $this->cookie_name,
					'path'     => defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/',
					'secure'   => is_ssl()? 'on' : 'off',
					'timezone' => HOUR_IN_SECONDS * get_option( 'gmt_offset' ),
					'value'    => $value,
				),
				'reloading' => $this->get_value( 'configuration', 'reloading' ),
				'animation' => $this->get_value( 'box', 'animation' ),
				'ajaxurl'   => admin_url( 'admin-ajax.php' ),
				'logged'    => is_user_logged_in()? 'yes':'no',
				'user_id'   => get_current_user_id(),
				'nonce'     => wp_create_nonce( __CLASS__ ),
			);
			wp_localize_script( __CLASS__, __CLASS__, $data );
			/**
			 * CSS
			 */
			$file = ub_files_url( 'modules/cookie-notice/assets/cookie-notice.css' );
			wp_enqueue_style( __CLASS__, $file, array(), $this->build );
		}

		/**
		 * Cookie notice output.
		 *
		 * @since 2.2.0
		 */
		public function add_cookie_notice() {
			$show = $this->show_cookie_notice();
			if ( ! $show ) {
				return;
			}
			$classes = array(
				'ub-position-'.$this->get_value( 'box', 'position', 'bottom' ),
				'ub-style-'.$this->get_value( 'box', 'style', 'none' ),
			);
			$content = sprintf(
				'<div id="ub-cookie-notice" role="banner" class="%s">',
				implode( ' ', $classes )
			);
			$content .= sprintf(
				'<div class="cookie-notice-container"><span id="ub-cn-notice-text">%s</span>',
				$this->get_value( 'configuration', 'message' )
			);
			/**
			 * data
			 */
			$content .= sprintf(
				'<a href="#" class="button ub-cn-set-cookie">%s</a>',
				esc_html( $this->get_value( 'configuration', 'button_text' ) )
			);
			/**
			 * Privacy Policy
			 */
			if ( function_exists( 'get_privacy_policy_url' ) ) {
				$show = $this->get_value( 'privacy_policy', 'show' );
				if ( 'on' === $show ) {
					$link_in_new_tab = $this->get_value( 'privacy_policy', 'link_in_new_tab', 'off' );
					$target = ( 'on' === $link_in_new_tab )? ' target="_blank"':'';
					$link = get_privacy_policy_url();
					if ( ! empty( $link ) ) {
						$content .= sprintf(
							'<a href="%s" class="button ub-cn-privacy-policy"%s>%s</a>',
							$link,
							$target,
							$this->get_value( 'privacy_policy', 'text' )
						);
					}
				}
			}
			$content .= '</div>';
			$content .= '</div>';
			echo apply_filters( 'ultimate_branding_cookie_notice_output', $content, $this->get_value() );
		}

		private function get_now() {
			return current_time( 'timestamp' ) - HOUR_IN_SECONDS * get_option( 'gmt_offset' );
		}

		/**
		 * Show cookie notice?
		 *
		 * @since 2.2.0
		 */
		private function show_cookie_notice() {
			$time = filter_input( INPUT_COOKIE, $this->cookie_name, FILTER_SANITIZE_NUMBER_INT );
			if ( ! empty( $time ) ) {
				$now = $this->get_now();
				if ( $time > $now ) {
					return false;
				}
			}
			/**
			 * check settings for logged user
			 */
			if ( is_user_logged_in() ) {
				$show = $this->get_value( 'configuration', 'logged' );
				if ( 'off' === $show ) {
					return false;
				}
				$user_time = 0;
				$time = get_user_meta( get_current_user_id(), $this->user_meta_name, true );
				$key = $this->get_meta_key_name();
				if ( isset( $time[ $key ] ) ) {
					$user_time = intval( $time[ $key ] );
				}
				if ( 0 < $user_time ) {
					$now = $this->get_now();
					if ( $user_time > $now ) {
						return false;
					}
				}
			}
			return true;
		}

		private function get_meta_key_name( $blog_id = null ) {
			if ( empty( $blog_id ) ) {
				$blog_id = get_current_blog_id();
			}
			$key = sprintf(
				'blog_%d_version_%d',
				$blog_id,
				$this->get_value( 'configuration', 'cookie_version' )
			);
			return $key;
		}

		/**
		 * save user meta info about cookie
		 *
		 * @since 2.2.0
		 */
		public function save_user_meta() {
			if ( ! isset( $_POST['nonce'] ) ) {
				wp_send_json_error( 'missing nonce' );
			}
			if ( ! wp_verify_nonce( $_POST['nonce'], __CLASS__ ) ) {
				wp_send_json_error( 'wrong nonce' );
			}
			if ( ! isset( $_POST['user_id'] ) ) {
				wp_send_json_error( 'missing user ID' );
			}
			$value = $this->get_value( 'configuration', 'cookie_expiry' );
			$value = current_time( 'timestamp' ) + intval( $value );
			$user_id = filter_input( INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT );
			if ( 0 < $user_id ) {
				$time = get_user_meta( $user_id, $this->user_meta_name, true );
				if ( ! is_array( $time ) ) {
					$time = array();
				}
				$key = $this->get_meta_key_name();
				$time[ $key ] = $value;
				update_user_meta( $_POST['user_id'], $this->user_meta_name, $time );
			}
			wp_send_json_success();
		}
	}
}
/**
 * Kick start the module
 */
new ub_cookie_notice;