<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'ub_signup_code' ) ) {

	class ub_signup_code extends ub_helper {

		protected $option_name = 'ub_signup_codes';

		public function __construct() {
			global $UB_network;
			parent::__construct();
			$this->set_options();
			add_action( 'ultimatebranding_settings_multisite', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_multisite_process', array( $this, 'update' ) );
			/**
			 * User Create Code
			 */
			add_action( 'register_form', array( $this, 'add_user_code' ) );
			add_action( 'signup_extra_fields', array( $this, 'add_user_code' ) );
			add_filter( 'registration_errors', array( $this, 'validate_user_signup_single' ) );
			add_filter( 'wpmu_validate_user_signup', array( $this, 'validate_user_signup' ) );
			/**
			 * Blog Create Code
			 */
			add_action( 'signup_blogform', array( $this, 'add_blog_code' ) );
			add_filter( 'wpmu_validate_blog_signup', array( $this, 'validate_blog_signup' ) );
			/**
			 * BuddyPress integration
			 */
			add_action( 'bp_account_details_fields', array( $this, 'add_user_code' ) );
			add_action( 'bp_blog_details_fields', array( $this, 'add_blog_code' ) );
		}

		/**
		 * Set options
		 *
		 * @since 2.3.0
		 */
		protected function set_options() {
			global $UB_network;
			$data = array(
				'settings' => array(
					'title' => __( 'Codes Settings', 'ub' ),
					'fields' => array(
						'user' => array(
							'type' => 'checkbox',
							'label' => __( 'Create user', 'ub' ),
							'options' => array(
								'on' => __( 'Yes', 'ub' ),
								'off' => __( 'No', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
						),
						'blog' => array(
							'type' => 'checkbox',
							'label' => __( 'Create blog', 'ub' ),
							'options' => array(
								'on' => __( 'Yes', 'ub' ),
								'off' => __( 'No', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
						),
					),
				),
				'user' => array(
					'title' => __( 'Create User Code', 'ub' ),
					'fields' => array(
						'code' => array(
							'type' => 'text',
							'label' => __( 'Code', 'ub' ),
							'description' => __( 'Users must enter this code in order to signup. Letters and numbers only.', 'ub' ),
						),
						'branding' => array(
							'type' => 'text',
							'label' => __( 'User Create Code Branding', 'ub' ),
							'description' => __( 'This is the text that will be displayed on the signup form. Ex: Invite Code', 'ub' ),
							'default' => __( 'User Create Code', 'ub' ),
						),
						'help' => array(
							'type' => 'text',
							'label' => __( 'Help Line', 'ub' ),
							'description' => __( 'This text will be displayed under code field.', 'ub' ),
							'default' => __( 'You need to enter the code to create a user.', 'ub' ),
						),
						'error' => array(
							'type' => 'text',
							'label' => __( 'Error Message', 'ub' ),
							'description' => __( 'Error message for invalid code.', 'ub' ),
							'default' => __( 'User create code is invalid.', 'ub' ),
						),
					),
					'master' => array(
						'section' => 'settings',
						'field' => 'user',
						'value' => 'on',
					),
				),
				'blog' => array(
					'title' => __( 'Create Blog Code', 'ub' ),
					'fields' => array(
						'code' => array(
							'type' => 'text',
							'label' => __( 'Code', 'ub' ),
							'description' => __( 'Users must enter this code in order to create blog on signup. Letters and numbers only.', 'ub' ),
						),
						'branding' => array(
							'type' => 'text',
							'label' => __( 'Blog Code Branding', 'ub' ),
							'description' => __( 'This is the text that will be displayed on the signup form. Ex: Invite Code', 'ub' ),
							'default' => __( 'Blog Create Code', 'ub' ),
						),
						'help' => array(
							'type' => 'text',
							'label' => __( 'Help Line', 'ub' ),
							'description' => __( 'This text will be displayed under code field.', 'ub' ),
							'default' => __( 'You need to enter the code to create a blog.', 'ub' ),
						),
						'error' => array(
							'type' => 'text',
							'label' => __( 'Error Message', 'ub' ),
							'description' => __( 'Error message for invalid code.', 'ub' ),
							'default' => __( 'Blog create code is invalid.', 'ub' ),
						),
					),
					'master' => array(
						'section' => 'settings',
						'field' => 'blog',
						'value' => 'on',
					),
				),
			);
			/**
			 * change settings for single site
			 */
			if ( $UB_network ) {
				/**
				 * handle settings
				 */
				$status = get_site_option( 'registration' );
				if ( 'none' === $status || 'blog' === $status ) {
					$info = array(
						'info' => array(
							'type' => 'description',
							'classes' => array( 'notice', 'notice-error', 'inline' ),
							'value' => __( 'User registration is disabled, settings below will not affect.', 'ub' ),
							'hide-th' => true,
						),
					);
					$data['user']['fields'] = $info + $data['user']['fields'];
					$data['settings']['fields']['user']['description'] = $info['info']['value'];
				}
				if ( 'none' === $status || 'user' === $status ) {
					$info = array(
						'info' => array(
							'type' => 'description',
							'classes' => array( 'notice', 'notice-error', 'inline' ),
							'value' => __( 'Blog creation is disabled, settings below will not affect.', 'ub' ),
							'hide-th' => true,
						),
					);
					$data['blog']['fields'] = $info + $data['blog']['fields'];
					$data['settings']['fields']['blog']['description'] = $info['info']['value'];
				}
			} else {
				$status = get_option( 'users_can_register' );
				if ( empty( $status ) ) {
					$info = array(
						'info' => array(
							'type' => 'description',
							'classes' => array( 'notice', 'notice-error', 'inline' ),
							'value' => __( 'User registration is disabled, settings below will not affect.', 'ub' ),
							'hide-th' => true,
						),
					);
					$data['user']['fields'] = $info + $data['user']['fields'];
				}
				unset( $data['blog'], $data['settings'], $data['user']['master'] );
			}
			$this->options = $data;
		}

		/**
		 * Print code field.
		 *
		 * @since 2.3.0
		 *
		 * @param string $id ID of field.
		 * @param array $value Configuration of field.
		 * @param WP_Error $errors WP_Error object.
		 */
		private function print_field( $id, $value, $errors ) {
			$html_id = 'ultimate_branding_'.$id;
			$name = $this->get_field_name( $id );
			if ( isset( $value['branding'] ) && ! empty( $value['branding'] ) ) {
				printf(
					'<label for="%s">%s</label>',
					esc_attr( $html_id ),
					esc_html( $value['branding'] )
				);
			}
			/**
			 * error message
			 */
			if ( is_a( $errors, 'WP_Error' ) && $errmsg = $errors->get_error_message( $name ) ) {
				printf( '<p class="error">%s</p>', $errmsg );
			}
			printf(
				'<input type="text" name="%s" id="%s" autocomplete="off" />',
				esc_attr( $name ),
				esc_attr( $html_id )
			);
			if ( isset( $value['help'] ) && ! empty( $value['help'] ) ) {
				echo '<p class="description">';
				echo esc_html( $value['help'] );
				echo '</p>';
			}
		}

		/**
		 * Check is User Create Code in use?
		 *
		 * @since 2.3.0
		 */
		private function check_user_code() {
			global $UB_network;
			if ( $UB_network ) {
				$show = $this->get_value( 'settings', 'user', 'off' );
				if ( 'on' === $show ) {
					$code = $this->get_value( 'user', 'code' );
					if ( empty( $code ) ) {
						return false;
					}
					return true;
				}
			} else {
				$code = $this->get_value( 'user', 'code' );
				if ( ! empty( $code ) ) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Add User Create Code to login form.
		 *
		 * @since 2.3.0
		 *
		 * @param WP_Error $errors WP_Error object.
		 */
		public function add_user_code( $errors ) {
			$show = $this->check_user_code();
			if ( ! $show ) {
				return;
			}
			/**
			 * get configuration
			 */
			$value = $this->get_value( 'user' );
			if ( ! isset( $value['branding'] ) || empty( $value['branding'] ) ) {
				$value['branding'] = __( 'User Create Code', 'ub' );
			}
			/**
			 * print
			 */
			$this->print_field( 'user_code', $value, $errors );
		}

		/**
		 * Validate User Create Code
		 *
		 * @since 2.3.0
		 *
		 * @param array $results Result of create accound form.
		 */
		public function validate_user_signup( $results ) {
			/**
			 * validate user signup
			 * check user code
			 */
			$show = $this->check_user_code();
			if ( $show ) {
				$code = $this->get_value( 'user', 'code' );
				$name = $this->get_field_name( 'user_code' );
				if ( ! isset( $_POST[ $name ] ) || $code != $_POST[ $name ] ) {
					$results['errors']->add( $name, $this->get_value( 'user', 'error' ) );
				}
			}
			/**
			 * return
			 */
			return $results;
		}

		/**
		 * Validate User Create Code on single site
		 *
		 * @since 2.3.0
		 *
		 * @param WP_Error $errors WP_Error object.
		 */
		public function validate_user_signup_single( $errors ) {
			$results = array(
				'errors' => $errors,
			);
			$results = $this->validate_user_signup( $results );
			return $results['errors'];
		}

		/**
		 * Validate Blog Code
		 *
		 * @since 2.3.0
		 *
		 * @param array $results Result of create accound form.
		 */
		public function validate_blog_signup( $results ) {
			$results = $this->validate_user_signup( $results );
			/**
			 * check blog create code
			 */
			$show = $this->check_blog_code();
			if ( $show ) {
				$code = $this->get_value( 'blog', 'code' );
				$name = $this->get_field_name( 'blog_code' );
				if ( ! isset( $_POST[ $name ] ) || $code != $_POST[ $name ] ) {
					$results['errors']->add( $name, $this->get_value( 'blog', 'error' ) );
				}
			}
			/**
			 * return
			 */
			return $results;
		}

		/**
		 * Check is Clog Create Code in use?
		 *
		 * @since 2.3.0
		 */
		private function check_blog_code() {
			$show = $this->get_value( 'settings', 'blog', 'off' );
			if ( 'on' === $show ) {
				$code = $this->get_value( 'blog', 'code' );
				if ( empty( $code ) ) {
					return false;
				}
				return true;
			}
			return false;
		}

		/**
		 * Adds an additional field for Blog description,
		 * on signup form for WordPress or Buddypress
		 * @param type $errors
		 */
		public function add_blog_code( $errors ) {
			$show = $this->check_user_code();
			if ( $show ) {
				$name = $this->get_field_name( 'user_code' );
				if ( isset( $_POST[ $name ] ) ) {
					printf(
						'<input type="hidden" name="%s" value="%s" />',
						esc_attr( $name ),
						esc_attr( $_POST[ $name ] )
					);
				} else {
					if (
						class_exists( 'ProSites_View_Front_Registration' )
						&& isset( $_GET['action'] )
						&& 'new_blog' === $_GET['action']
					) {
					} else {
						return $errors;
					}
				}
			}
			$show = $this->check_blog_code();
			if ( ! $show ) {
				return;
			}
			/**
			 * get configuration
			 */
			$value = $this->get_value( 'blog' );
			if ( ! isset( $value['branding'] ) || empty( $value['branding'] ) ) {
				$value['branding'] = __( 'Blog Create Code', 'ub' );
			}
			/**
			 * print
			 */
			$this->print_field( 'blog_code', $value, $errors );
		}

		private function get_field_name( $name ) {
			$name = sprintf(
				'ultimate_branding_%s_%s',
				__CLASS__,
				$name
			);
			$name = sanitize_title( $name );
			return $name;
		}

	}
}
new ub_signup_code;