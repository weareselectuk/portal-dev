<?php

if ( ! class_exists( 'UltimateBrandingAdmin' ) ) {
	require_once dirname( __FILE__ ) . '/ubbase.php';
	require_once dirname( __FILE__ ) . '/class-ub-admin-stats.php';
	class UltimateBrandingAdmin extends UltimateBrandingBase {

		var $modules = array();
		var $plugin_msg = array();
		// Holder for the help class
		var $help;

		/**
		 * Default messages.
		 *
		 * @since 1.8.5
		 */
		var $messages = array();

		/**
		 * tab
		 *
		 * @since 1.9.1
		 */
		private $tab = 'dashboard';

		/**
		 * Stats
		 *
		 * @since 2.3.0
		 */
		private $stats = null;

		public function __construct() {
			parent::__construct();
			$this->set_configuration();
			$this->stats = new UltimateBrandingAdminStats;
			/**
			 * debug only when WP_DEBUG && WPMUDEV_BETATEST
			 */
			$debug = defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'WPMUDEV_BETATEST' ) && WPMUDEV_BETATEST;
			$this->debug = apply_filters( 'ultimatebranding_debug', $debug );
			foreach ( $this->configuration as $key => $data ) {
				if ( ! is_multisite() && isset( $data['network-only'] ) && $data['network-only'] ) {
					continue;
				}
				if ( isset( $data['disabled'] ) && $data['disabled'] ) {
					continue;
				}
				$this->modules[ $key ] = $data['module'];
			}
			/**
			 * Filter allow to turn off available modules.
			 *
			 * @since 1.9.4
			 *
			 * @param array $modules available modules array.
			 */
			$this->modules = apply_filters( 'ultimatebranding_available_modules', $this->modules );
			add_action( 'plugins_loaded', array( $this, 'load_modules' ), 0 );
			add_action( 'plugins_loaded', array( $this, 'setup_translation' ) );
			add_action( 'init', array( $this, 'initialise_ub' ) );
			add_action( 'admin_notices', array( $this, 'show_messages' ) );
			add_action( 'network_admin_notices', array( $this, 'show_messages' ) );
			add_action( 'network_admin_menu', array( $this, 'network_admin_page' ) );
			add_action( 'wp_ajax_ultimate_branding_toggle_module', array( $this, 'toggle_module' ) );
			add_action( 'init', array( $this, 'modules_process_bulk_action' ), 1 );
			add_filter( 'admin_title', array( $this, 'admin_title' ), 10, 2 );
			/**
			 * default messages
			 */
			$this->messages = array();
			$this->messages['success'] = __( 'Success! Your changes were sucessfully saved!', 'ub' );
			$this->messages['fail'] = __( 'There was an error, please try again.', 'ub' );
			$this->messages['reset-section-success'] = __( 'Section was reset to defaults.', 'ub' );
			/**
			 * set and sanitize tab
			 *
			 * @since 1.9.1
			 */
			$this->set_and_sanitize_tab();
		}

		/**
		 * Add "Ultimate Branding" to admin title.
		 *
		 * @since 1.9.8
		 */
		public function admin_title( $admin_title, $title ) {
			$screen = get_current_screen();
			if ( is_a( $screen, 'WP_Screen' ) && preg_match( '/_page_branding$/', $screen->id ) ) {
				return sprintf( '%s%s%s',
					_x( 'Ultimate Branding', 'admin title', 'ub' ),
					_x( ' &lsaquo; ', 'admin title separator', 'ub' ),
					$admin_title
				);
			}
			return $admin_title;
		}

		public function transfer_old_settings() {
			$modules = ub_get_option( 'ultimatebranding_activated_modules', array() );
			global $UB_network;
			if ( $UB_network ) {
				// Check for the original settings and if there are none, but there are some in the old location then move them across
				if ( empty( $modules ) ) {
					// none in our settings
					$othermodules = get_option( 'ultimatebranding_activated_modules', array() );
					if ( ! empty( $othermodules ) ) {
						// We shall do a transfer across - first modules
						ub_update_option( 'ultimatebranding_activated_modules', $othermodules );
						// Next each set of settings for the activated modules
						foreach ( $othermodules as $key => $title ) {
							switch ( $key ) {
								case 'favicons.php': ub_update_option( 'ub_favicon_dir', get_option( 'ub_favicon_dir' ) );
									ub_update_option( 'ub_favicon_url', get_option( 'ub_favicon_url' ) );
								break;
								case 'image-upload-size.php':
									$roles = wp_roles()->get_names();
									foreach ( $roles as $role ) {
										ub_update_option( 'ub_img_upload_filesize_' . $role, get_option( 'ub_img_upload_filesize_' . $role ) );
									}
								break;
								case 'custom-admin-bar.php':
									ub_update_option( 'wdcab', get_option( 'wdcab' ) );
								break;
								case 'admin-help-content.php': ub_update_option( 'admin_help_content', get_option( 'admin_help_content' ) );
								break;
								case 'global-footer-content.php': ub_update_option( 'global_footer_content', get_option( 'global_footer_content' ) );
								break;
								case 'global-header-content.php': ub_update_option( 'global_header_content', get_option( 'global_header_content' ) );
								break;
								case 'admin-menu.php': ub_update_option( 'admin_menu', get_option( 'admin_menu' ) );
								break;
								case 'admin-footer-text.php': ub_update_option( 'admin_footer_text', get_option( 'admin_footer_text' ) );
								break;
								case 'remove-wp-dashboard-widgets.php': ub_update_option( 'rwp_active_dashboard_widgets', get_option( 'rwp_active_dashboard_widgets' ) );
								break;
								case 'site-generator-replacement.php': ub_update_option( 'site_generator_replacement', get_option( 'site_generator_replacement' ) );
									ub_update_option( 'site_generator_replacement_link', get_option( 'site_generator_replacement_link' ) );
								break;
								case 'site-wide-text-change.php': ub_update_option( 'translation_ops', get_option( 'translation_ops' ) );
									ub_update_option( 'translation_table', get_option( 'translation_table' ) );
								break;
								case 'custom-login-css.php': ub_update_option( 'global_login_css', get_option( 'global_login_css' ) );
								break;
								case 'custom-admin-css.php': ub_update_option( 'global_admin_css', get_option( 'global_admin_css' ) );
								break;
							}
						}
					}
				}
			}
			/**
			 * Transfer modules to settings
			 *
			 * @since 1.9.5
			 */
			if ( ! empty( $modules ) ) {
				/**
				 * Transfer "Signup Password" module.
				 */
				if ( isset( $modules['signup-password.php'] ) && 'yes' == $modules['signup-password.php'] ) {
					unset( $modules['signup-password.php'] );
					$modules['custom-login-screen.php'] = 'yes';
					$option = ub_get_option( 'global_login_screen', array() );
					if ( ! isset( $option['form'] ) ) {
						$option['form'] = array();
					}
					$option['form']['signup_password'] = 'on';
					ub_update_option( 'global_login_screen', $option );
					ub_update_option( 'ultimatebranding_activated_modules', $modules );
					$message = array(
						'class' => 'success',
						'message' => __( 'Module "Signup Password" was turned off and is no longer used. Now you can change it in "Login Screen" module in section "Form".', 'ub' ),
					);
					$this->add_message( $message );
				}
			}
		}

		/**
		 * Add message to show
		 */
		public function add_message( $message ) {
			$messages = ub_get_option( 'ultimatebranding_messages', array() );
			if ( ! in_array( $message, $messages ) ) {
				$messages[] = $message;
				ub_update_option( 'ultimatebranding_messages', $messages );
			}
		}

		/**
		 * Print admin notice from option.
		 *
		 * @since 1.9.5
		 */
		public function show_messages() {
			$screen = get_current_screen();
			if ( ! preg_match( '/^toplevel_page_branding/', $screen->id ) ) {
				return;
			}
			$messages = ub_get_option( 'ultimatebranding_messages', array() );
			if ( empty( $messages ) ) {
				return;
			}
			foreach ( $messages as $message ) {
				if ( ! isset( $message['message'] ) || empty( $message['message'] ) ) {
					continue;
				}
				printf(
					'<div class="notice notice-%s"><p>%s</p></div>',
					esc_attr( isset( $message['class'] )? $message['class']:'success' ),
					$message['message']
				);
			}
			ub_delete_option( 'ultimatebranding_messages' );
		}

		public function initialise_ub() {
			global $blog_id;
			// For this version only really - to bring settings across from the old storage locations
			$this->transfer_old_settings();
			if ( ! is_multisite() ) {
				if ( UB_HIDE_ADMIN_MENU != true ) {
					add_action( 'admin_menu', array( $this, 'network_admin_page' ) );
				}
			} else {
				global $UB_network;
				if ( $UB_network ) {
					$show_in_subsites = $this->check_show_in_subsites();
					if ( $show_in_subsites ) {
						add_action( 'admin_menu', array( $this, 'admin_page' ) );
					}
				} else {
					// Added to allow single site activation across a network
					if ( UB_HIDE_ADMIN_MENU != true && ! defined( 'UB_HIDE_ADMIN_MENU_' . $blog_id ) ) {
						add_action( 'admin_menu', array( $this, 'network_admin_page' ) );
					}
				}
			}
			// Header actions
			add_action( 'load-toplevel_page_branding', array( $this, 'add_admin_header_branding' ) );
			/**
			 * set ultimate_branding_tab
			 *
			 * @since 1.9.4
			 */
			set_query_var( 'ultimate_branding_tab', $this->tab );
		}

		public function setup_translation() {
			// Load up the localization file if we're using WordPress in a different language
			// Place it in this plugin's "languages" folder and name it "mp-[value in wp-config].mo"
			$dir = sprintf( '/%s/languages', basename( ub_dir( '' ) ) );
			load_plugin_textdomain( 'ub', false, $dir );
		}

		public function add_admin_header_core() {
			// Add in help pages
			$screen = get_current_screen();
			$this->help = new UB_Help( $screen );
			$this->help->attach();
			// Add in the core CSS file
			$file = sprintf( 'assets/css/ultimate-branding-admin%s.css', defined( 'WP_DEBUG' ) && WP_DEBUG ? '':'.min' );
			wp_enqueue_style( 'ultimate-branding-admin', ub_url( $file ), array(), $this->build );
			wp_enqueue_script( array(
				'jquery-ui-sortable',
			) );
			$file = sprintf( 'assets/js/ultimate-branding-admin%s.js', defined( 'WP_DEBUG' ) && WP_DEBUG ? '':'.min' );
			wp_enqueue_script( 'ub_admin', ub_url( $file ), array(), $this->build, true );
			wp_enqueue_script( 'jquery-effects-highlight' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			/**
			 * Code Editor for WP 4.9
			 *
			 * @since 3.2.0
			 */
			$settings_css = wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
			$settings_html = wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
			wp_localize_script('ub_admin', 'ub_admin', array(
				'current_menu_sub_item' => (isset( $_GET['tab'] ) ? $_GET['tab'] : ''),
				'tab_more' => _x( 'More &darr;', 'tab more text', 'ub' ),
				'editor_css' => wp_json_encode( $settings_css ),
				'editor_html' => wp_json_encode( $settings_html ),
				'messages' => array(
					'copy' => array(
						'confirm' => __( 'Are you sure to replace all section data?', 'ub' ),
						'select_first' => __( 'Please select a source module first.', 'ub' ),
					),
					'wrong' => __( 'Something went wrong!', 'ub' ),
				),
			));
		}

		public function add_admin_header_branding() {
			$this->add_admin_header_core();
			do_action( 'ultimatebranding_admin_header_global' );
			do_action( 'ultimatebranding_admin_header_' . $this->tab );
			$update = apply_filters( 'ultimatebranding_update_branding_page', true );
			if ( $update ) {
				$this->update_branding_page();
			}
		}

		/**
		 * 	Check plugins those will be used if they are active or not
		 */
		public function load_modules() {
			// Load our remaining modules here
			foreach ( $this->modules as $module => $plugin ) {
				if ( ub_is_active_module( $module ) ) {
					if ( $this->should_be_module_off( $module ) ) {
						continue;
					}
					ub_load_single_module( $module );
				}
			}
			/**
			 * set related
			 *
			 * @since 2.3.0
			 */
			$this->related = apply_filters( 'ultimate_branding_related_modules', $this->related );
		}

		public function check_active_plugins() {
			// We may be calling this function before admin files loaded, therefore let's be sure required file is loaded
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$plugins = get_plugins(); // All installed plugins
			foreach ( $plugins as $plugin_file => $plugin_data ) {
				if ( is_plugin_active( $plugin_file ) && in_array( $plugin_file, $this->modules ) ) {
					// Add the title to the message
					$this->plugin_msg[ $plugin_file ] = $plugin_data['Title'];
				}
			}
		}

		/**
		 * 	Warn admin to deactivate the duplicate plugins
		 */
		public function deactivate_plugin_msg() {
			echo '<div class="error"><p>' .
				sprintf( __( '<b>[Ultimate Branding]</b> Please deactivate the following plugin(s) to make Ultimate Branding work: %s', 'ub' ), implode( ', ', $this->plugin_msg ) ) .
				'</p></div>';
		}

		/**
		 * Bulk activate/deactivate modules
		 *
		 * Bulk activate/deactivate modules. It should be here, not in
		 * UB_Module_List_Table class, because we need to do that before
		 * create menu or tabs.
		 *
		 * @since
		 */
		public function modules_process_bulk_action() {
			/**
			 * check modules exists
			 */
			if ( ! isset( $_POST['module'] ) || ! is_array( $_POST['module'] ) ) {
				return;
			}
			/**
			 * check page
			 */
			if ( ! isset( $_POST['page'] ) || 'branding' != $_POST['page'] ) {
				return;
			}
			// security check!
			if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {
				$nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
				$action = 'bulk-modules';
				if ( ! wp_verify_nonce( $nonce, $action ) ) {
					wp_die( __( 'Nope! Security check failed!', 'ub' ) );
				}
			} else {
				return;
			}
			$action = '';
			if ( isset( $_POST['action'] ) && '-1' != $_POST['action'] ) {
				$action = $_POST['action'];
			} else if ( isset( $_POST['action2'] ) && '-1' != $_POST['action2'] ) {
				$action = $_POST['action2'];
			}
			if ( ! preg_match( '/^(de)?activate$/', $action ) ) {
				return;
			}
			$modules = array();
			foreach ( $_POST['module'] as $module ) {
				switch ( $action ) {
					case 'activate':
						$result = $this->activate_module( $module );
						if ( $result && isset( $this->configuration[ $module ] ) ) {
							$modules[] = $this->configuration[ $module ]['name'];
						}
					break;
					case 'deactivate':
						$result = $this->deactivate_module( $module );
						if ( $result && isset( $this->configuration[ $module ] ) ) {
							$modules[] = $this->configuration[ $module ]['name'];
						}
					break;
				}
			}
			$messages = ub_get_option( 'ultimatebranding_messages', array() );
			$message = array();
			if ( 'activate' === $action ) {
				$message = array(
					'class' => 'success',
					'message' => sprintf(
						_n(
							'Module %s was successfully activated.',
							'Modules %s was successfully activated.',
							count( $modules ),
							'ub'
						),
						implode( ', ', array_map( array( $this, 'bold' ), $modules ) )
					),
				);
			} else if ( 'deactivate' === $action ) {
				$message = array(
					'class' => 'success',
					'message' => sprintf(
						_n(
							'Module %s was deactivated without errors.',
							'Modules %s was deactivated without errors.',
							count( $modules ),
							'ub'
						),
						implode( ', ', array_map( array( $this, 'bold' ), $modules ) )
					),
				);
			} else {
				$message = array(
					'class' => 'success',
					'message' => $message,
				);
			}
			if ( ! empty( $message ) && ! in_array( $message, $messages ) ) {
				$messages[] = $message;
				ub_update_option( 'ultimatebranding_messages', $messages );
			}
		}

		/**
		 * add bold
		 *
		 * @since 2.1.0
		 */
		private function bold( $a ) {
			return sprintf( '"<b>%s</b>"', $a );
		}

		/**
		 * Add main menu
		 *
		 * @since 2.0.0
		 *
		 * @param string $capability Capability.
		 */
		private function menu( $capability ) {
			$image = 'PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNTAiIGhlaWdodD0iMTUwIj48ZyB0cmFuc2Zvcm09Im1hdHJpeCguMzAzMDMgMCAwIC0uMzAzMDMgLTc2LjUxNSAyNTAuNzYpIj48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzNjUsNzY1KSI+PHBhdGggZD0ibTAgMHYtMjM1YzAtNTUuMDU3IDMzLjEyOS0xMDIuNTIgODAuNS0xMjMuNTF2MzU4LjUxaC04MC41em0xMzUtNDAwYy05MC45ODEgMC0xNjUgNzQuMDE5LTE2NSAxNjV2MjY1aDE0MC41di0zOTcuNzdjNy45NDgtMS40NjMgMTYuMTM2LTIuMjI4IDI0LjUtMi4yMjggNzQuNDM5IDAgMTM1IDYwLjU2MSAxMzUgMTM1djI2NWgzMHYtMjY1YzAtOTAuOTgxLTc0LjAxOS0xNjUtMTY1LTE2NSIgZmlsbD0iIzViNWM3MiIvPjwvZz48L2c+PC9zdmc+Cg==';
			// Add in our menu page
			$hook = add_menu_page(
				__( 'Branding', 'ub' ),
				__( 'Branding', 'ub' ),
				$capability,
				'branding',
				array( $this, 'handle_main_page' ),
				'data:image/svg+xml;base64,'.$image
			);
			add_action( 'load-'.$hook, array( $this, 'screen_settings' ) );
		}

		/**
		 * Add Screen Options
		 *
		 * @since 2.2.0
		 */
		public function screen_settings() {
			if ( 'dashboard' === $this->tab ) {
				if ( is_multisite() ) {
					global $UB_network;
					if ( ! $UB_network ) {
						return;
					}
				}
				if (
					isset( $_POST['ub_delete'] )
					&& isset( $_POST['screenoptionnonce'] )
					&& wp_verify_nonce( $_POST['screenoptionnonce'], 'screen-options-nonce' )
				) {
					$value = $_POST['ub_delete'];
					if ( empty( $value ) || ! preg_match( '/^(delete|preserve)$/', $value ) ) {
						$value = 'delete';
					}
					ub_update_option( 'ultimate_branding_delete_settings', $value );
				}
				// add_action( 'screen_settings', array( $this, 'screen_settings_output' ), 10, 2 );
				add_filter( 'screen_options_show_submit', '__return_true' );
			}
		}

		/**
		 * Show content oc "Screen Options" tab.
		 *
		 * @since 2.2.0
		 */
		public function screen_settings_output( $settings, $screen ) {
			$value = ub_get_option( 'ultimate_branding_delete_settings', 'delete' );
			if ( empty( $value ) || ! preg_match( '/^(delete|preserve)$/', $value ) ) {
				$value = 'delete';
			}
			$settings .= '<fieldset class="ub-prefs">';
			$settings .= sprintf( '<legend>%s</legend>', esc_html__( 'Plugin settings', 'ub' ) );
			$settings .= sprintf( '<p class="description">%s</p>', esc_html__( 'What should we do with plugin configuration, when plugin is deleted?', 'ub' ) );
			$settings .= sprintf(
				'<label><input name="ub_delete" class="switch-button" type="radio" value="delete" %s /> %s</label>',
				checked( $value, 'delete', false ),
				esc_html__( 'Delete', 'ub' )
			);
			$settings .= sprintf(
				'<label><input name="ub_delete" class="switch-button" type="radio" value="preserve" %s /> %s</label>',
				checked( $value, 'preserve', false ),
				esc_html__( 'Preserve', 'ub' )
			);
			$settings .= '</fieldset>';
			/**
			 * Filter settings output
			 *
			 * @since 3.2.0
			 */
			$settings = apply_filters( 'ultimate_branding_screen_settings_output', $settings, $this->configuration );
			return $settings;
		}

		/**
		 * Add pages
		 */
		public function admin_page() {
			$this->menu( 'manage_options' );
		}

		/**
		 * Add pages
		 */
		public function network_admin_page() {
			$capability = 'manage_options';
			global $UB_network;
			if ( $UB_network ) {
				$capability = 'manage_network_options';
			}
			// Add in our menu page
			$this->menu( $capability );
			add_submenu_page(
				'branding',
				__( 'Dashboard', 'ub' ),
				__( 'Dashboard', 'ub' ),
				$capability,
				'branding',
				array( $this, 'handle_main_page' )
			);
			// Get the activated modules
			$modules = get_ub_activated_modules();
			$base_url = $this->get_base_url();
			// Add in the extensions
			foreach ( $modules as $key => $title ) {
				if ( isset( $this->configuration[ $key ] ) ) {
					$module = $this->configuration[ $key ];
					if ( ! is_network_admin() && isset( $module['hide-on-single-install'] ) && true === $module['hide-on-single-install'] ) {
						continue;
					}
					/**
					 * Turn off disabled modules
					 */
					if ( isset( $module['disabled'] ) && true === $module['disabled'] ) {
						continue;
					}
					if ( isset( $module['tab'] ) ) {
						$function = preg_replace( '/-/', '_', sprintf( 'handle_%s_panel', $module['tab'] ) );
						$menu_slug = sprintf( 'branding&amp;tab='.$module['tab'] );
						if ( method_exists( $this, $function ) ) {
							if ( ub_has_menu( $menu_slug ) ) {
								continue;
							}
							$page_title = isset( $module['page_title'] )? $module['page_title'] : $module['tab'];
							$menu_title = isset( $module['menu_title'] )? $module['menu_title'] : $page_title;
							add_submenu_page( 'branding', $page_title, $menu_title, $capability, $menu_slug, array( $this, $function ) );
							continue;
						} else if ( $this->debug ) {
							error_log( sprintf( 'UltimateBranding: missing module: %s, callback: %s', $key, $function ) );
						}
					} else if ( $this->debug ) {
						error_log( sprintf( 'UltimateBranding: missing module tab: %s', $key ) );
					}
				} else if ( $this->debug ) {
					error_log( sprintf( 'UltimateBranding: missing module configuration: %s', $key ) );
				}
			}
			do_action( 'ultimate_branding_add_menu_pages' );
			/**
			 * sort
			 */
			global $submenu;
			if ( isset( $submenu['branding'] ) ) {
				$items = $submenu['branding'];
				usort( $items, array( $this, 'sort_admin_menu' ) );
				$submenu['branding'] = $items;
			}
		}

		public function activate_module( $module ) {
			$modules = get_ub_activated_modules();
			if ( ! isset( $modules[ $module ] ) ) {
				$modules[ $module ] = 'yes';
				update_ub_activated_modules( $modules );
				return true;
			}
			return false;
		}

		public function deactivate_module( $module ) {
			$modules = get_ub_activated_modules();
			if ( isset( $modules[ $module ] ) ) {
				unset( $modules[ $module ] );
				update_ub_activated_modules( $modules );
				return true;
			}
			return false;
		}

		public function update_branding_page() {
			global $action, $page;
			wp_reset_vars( array( 'action', 'page' ) );
			if ( isset( $_REQUEST['action'] ) && ! empty( $_REQUEST['action'] ) ) {
				if ( 'dashboard' == $this->tab ) {
					if ( isset( $_GET['action'] ) && isset( $_GET['module'] ) ) {
						switch ( $_GET['action'] ) {
							case 'enable': check_admin_referer( 'enable-module-' . $_GET['module'] );
								if ( $this->activate_module( $_GET['module'] ) ) {
									wp_safe_redirect( UB_Help::remove_query_arg_raw( array( 'module', '_wpnonce', 'action' ), wp_get_referer() ) );
								} else {
									wp_safe_redirect( UB_Help::remove_query_arg_raw( array( 'module', '_wpnonce', 'action' ), wp_get_referer() ) );
								}
						break;
							case 'disable': check_admin_referer( 'disable-module-' . $_GET['module'] );
								if ( $this->deactivate_module( $_GET['module'] ) ) {
									wp_safe_redirect( UB_Help::remove_query_arg_raw( array( 'module', '_wpnonce', 'action' ), wp_get_referer() ) );
								} else {
									wp_safe_redirect( UB_Help::remove_query_arg_raw( array( 'module', '_wpnonce', 'action' ), wp_get_referer() ) );
								}
						break;
						}
					} elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'enableallmodules' ) {
						check_admin_referer( 'enable-all-modules' );
						foreach ( $this->modules as $module => $value ) {
							$this->activate_module( $module );
						}
						wp_safe_redirect( UB_Help::remove_query_arg_raw( array( 'module', '_wpnonce', 'action' ), wp_get_referer() ) );
					} elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'disableallmodules' ) {
						check_admin_referer( 'disable-all-modules' );
						foreach ( $this->modules as $module => $value ) {
							$this->deactivate_module( $module );
						}
						wp_safe_redirect( UB_Help::remove_query_arg_raw( array( 'module', '_wpnonce', 'action' ), wp_get_referer() ) );
					}
					return;
				}
				$t = preg_replace( '/-/', '_', $this->tab );
				/**
				 * check
				 */
				check_admin_referer( 'ultimatebranding_settings_'.$t );
				$msg = 'fail';
				$result = apply_filters( 'ultimatebranding_settings_'.$t.'_process', true );
				if ( $result ) {
					$msg = 'success';
				}
				wp_safe_redirect( UB_Help::add_query_arg_raw( 'msg', $msg, wp_get_referer() ) );
				do_action( 'ultimatebranding_settings_update_' . $this->tab );
			}
		}

		public function handle_main_page() {
			global $action, $page;
			wp_reset_vars( array( 'action', 'page' ) );
			echo '<div class="wrap nosubsub ultimate-branding">';
			printf( '<h1>%s</h1>', esc_html__( 'Ultimate Branding', 'ub' ) );
			echo '<nav class="tabs">';
			echo '<ul class="ub-primary">';
			$base_url = $this->get_base_url();
			/**
			 * dashboard link
			 */
			$classes = array(
				'nav-tab',
				'nav-tab-dashboard',
			);
			if ( 'dashboard' == $this->tab ) {
				$classes[] = 'nav-tab-active';
			}
			printf(
				'<li><a href="%s" class="%s">%s</a></li>',
				esc_url( $base_url ),
				esc_attr( implode( ' ', $classes ) ),
				esc_html__( 'Dashboard', 'ub' )
			);
			/**
			 * tabs
			 */
			$added = array();
			$tabs = $this->configuration;
			uasort( $tabs, array( $this, 'sort_modules_by_menu_title' ) );
			foreach ( $tabs as $key => $data ) {
				if ( ! isset( $data['tab'] ) ) {
					continue;
				}
				if ( isset( $added[ $data['tab'] ] ) ) {
					continue;
				}
				/**
				 * check is active
				 */
				$is_active = ub_is_active_module( $key );
				if ( ! $is_active ) {
					continue;
				}
				/**
				 * Turn off disabled modules
				 */
				if ( isset( $data['disabled'] ) && true === $data['disabled'] ) {
					continue;
				}
				/**
				 * avoid double add
				 */
				$added[ $data['tab'] ] = 1;
				$url = add_query_arg( 'tab', $data['tab'], $base_url );
				$classes = array(
					'nav-tab',
					'nav-tab-'.$data['tab'],
				);
				if ( $this->tab == $data['tab'] ) {
					$classes[] = 'nav-tab-active';
				}
				/**
				 * Allow to modify url in tab.
				 *
				 * @since 1.9.3
				 *
				 * @param string $url URL of a tab.
				 * @param array $data Module data.
				 */
				$url = apply_filters( 'ultimate_branding_module_url', $url, $data );
				/**
				 * echo
				 */
				printf(
					'<li><a href="%s" class="%s">%s</a></li>',
					esc_url( $url ),
					esc_attr( implode( ' ', $classes ) ),
					esc_html( isset( $data['menu_title'] )? $data['menu_title']:$data['page_title'] )
				);
			}
			echo '</ul></nav>';
			/**
			 * tab content
			 */
			if ( 'dashboard' == $this->tab ) {
				$this->show_dashboard_page();
			} else {
				$loaded_modules = array();
				$module_is_active = false;
				$modules = $this->get_modules_by_tab( $this->tab );
				foreach ( $modules as $module ) {
					if ( isset( $module['tab'] ) ) {
						$is_active = ub_is_active_module( $module['key'] );
						if ( $is_active  ) {
							/**
							 * Turn off disabled modules
							 */
							if ( isset( $module['disabled'] ) && true === $module['disabled'] ) {
								continue;
							}
							$loaded_modules[] = $module['key'];
							if ( ! $module_is_active ) {
								$this->panel( $module['tab'] );
								$module_is_active = true;
							}
						}
					}
				}
				if ( ! $module_is_active ) {
					$show_unknown_message = true;
					if ( 0 < count( $modules ) ) {
						foreach ( $modules as $module ) {
							if ( isset( $module['tab'] ) ) {
								/**
								 * Turn off disabled modules
								 */
								if ( isset( $module['disabled'] ) && true === $module['disabled'] ) {
									continue;
								}
								echo $this->module_is_not_active_message( $module );
								$show_unknown_message = false;
							}
						}
					}
					if ( $show_unknown_message ) {
						echo '<div class="ub-module-info ub-module-error">';
						printf( '<h2>%s</h2>', esc_html__( 'Unknown module', 'ub' ) );
						printf( '<p>%s</p>', esc_html__( 'Cheatin&#8217; uh?', 'ub' ) );
						echo '</div>';
					}
				}
				do_action( 'ultimate_branding_load_modules', $this->tab, $loaded_modules );
			}
			echo '</div> <!-- wrap -->';
		}

		public function show_dashboard_page() {
			global $action, $page;
			if ( isset( $_GET['msg'] ) && isset( $this->messages[ $_GET['msg'] ] ) ) {
				echo '<div id="message" class="updated fade"><p>' . $messages[ $_GET['msg'] ] . '</p></div>';
				$_SERVER['REQUEST_URI'] = UB_Help::remove_query_arg( array( 'msg' ), $_SERVER['REQUEST_URI'] );
			}
?>
        <form id="ultimate-branding-modules" method="post">
            <input type="hidden" name="page" value="branding" />
<?php
			require_once ub_files_dir( 'classes/class-ub-module-list-table.php' );
			$ub_module_list = new UB_Module_List_Table();
			$ub_module_list->set_modules( $this->modules );
			$ub_module_list->prepare_items();
			$ub_module_list->search_box( __( 'Search', 'ub' ), __CLASS__ );
			$ub_module_list->views();
			$ub_module_list->display();
?>
        </form>
<?php
			// See what plugins are active
			$this->check_active_plugins();
if ( ! empty( $this->plugin_msg ) ) {
?>
<div class="postbox " id="">
<h2 class="hndle"><span><?php _e( 'Notifications', 'ub' ); ?></span></h2>
<div class="inside">
<?php
	_e( 'Please deactivate the following plugin(s) to make Ultimate Branding to work:', 'ub' );
	echo '<ul><li><strong>' . implode( '</li><li>', $this->plugin_msg );
	echo '</strong></li></ul>';
?>
<br class="clear">
</div>
</div>
<?php
}
		}

		/**
		 * Renders $file and returns | prints content.
		 *
		 *
		 * @since 1.6.3
		 *
		 * @param $file file name without extension name
		 * @param array $params parameters to pass to the file
		 * @param bool $return on true rendered file will be returned | rendered file will be echoed out
		 * @return string
		 */
		public function render( $module_name, $file, $params = array(), $return = false ) {
			global $UB_dir;
			/**
			 * assign $file to a variable which is unlikely to be used by users of the method
			 */
			$UB_Rendered_To_Be_File_Name = $file;
			extract( $params, EXTR_OVERWRITE );
			if ( $return ) {
				ob_start();
			}
			include( $UB_dir . 'ultimate-branding-files/modules/' . $module_name . '-files/views/' . $UB_Rendered_To_Be_File_Name . '.php' );
			if ( $return ) {
				return ob_get_clean();
			}
			if ( ! empty( $params ) ) {
				foreach ( $params as $param ) {
					unset( $param );
				}
			}
		}

		public function handle_admin_message_panel() {
			$title = __( 'Admin Message', 'ub' );
			$this->panel( $title, 'admin_message', true );
			return;
			global $action, $page;
			$messages = array();
			$messages[1] = __( 'Settings saved.', 'ub' );
			$messages[2] = __( 'Settings cleared.', 'ub' );
			$messages[3] = __( 'Settings could not be saved.', 'ub' );
			$messages = apply_filters( 'ultimatebranding_settings_admin_message_messages', $messages );
?>
    <h2><?php _e( 'Admin Message', 'ub' ); ?></h2>
<?php
if ( isset( $_GET['msg'] ) && (int) $_GET['msg'] !== 3 ) {
?>
<div id="message" class="updated fade"><p><?php echo $messages[ (int) $_GET['msg'] ] ?></p></div>
<?php
} elseif ( isset( $_GET['msg'] ) && (int) $_GET['msg'] === 3 ) { ?>
                    <div class="error fade"><p><?php echo $messages[ (int) $_GET['msg'] ] ?></p></div>
<?php
}
?>
    <div id="poststuff" class="metabox-holder m-settings">
        <form action='' method="post">
            <input type='hidden' name='page' value='<?php echo $page; ?>' />
            <input type='hidden' name='action' value='process' />
<?php
			wp_nonce_field( 'ultimatebranding_settings_admin_message' );
			do_action( 'ultimatebranding_settings_admin_message' );
?>
<?php
if ( has_filter( 'ultimatebranding_settings_admin_message_process' ) ) {
?>
<p class="submit">
<input class="button button-primary" type="submit" name="Submit" value="<?php _e( 'Save Changes', 'admin_message' ) ?>" />
<input class="button button-secondary" type="submit" name="Reset" value="<?php _e( 'Reset', 'admin_message' ) ?>" />
</p>
<?php
}
?>
        </form>
    </div>
<?php
		}

		/**
		 * Custom MS e-mails
		 *
		 * @since 1.8.6
		 */
		public function handle_custom_ms_register_emails_panel() {
			$title = __( 'Custom MS Registered e-mails', 'ub' );
			$this->panel( $title, 'custom_ms_register_emails' );
		}

		/**
		 * Export & Import screen
		 *
		 * @since 1.8.6
		 */
		public function handle_export_import_panel() {
			$title = __( 'Export & Import Ultimate Branding configuration', 'ub' );
			$this->panel( $title, 'export_import', false );
		}

		/**
		 * Link Manager screen
		 *
		 * @since 1.8.6
		 */
		public function handle_link_manager_panel() {
			$title = __( 'Link Manager', 'ub' );
			$this->panel( $title, 'link_manager' );
		}

		/**
		 * Common!
		 *
		 * @since 1.8.6
		 */
		private function panel( $tab ) {
			global $page;
			$panel = preg_replace( '/-/', '_', 'ultimatebranding_settings_'.$tab );
			$modules = $this->get_modules_by_tab( $tab );
			$show = true;
			$inactive_modules = '';
			foreach ( $modules as $key => $module ) {
				$is_active = ub_is_active_module( $module['key'] );
				if ( $is_active ) {
					if ( $show ) {
						$action = preg_replace( '/-/', '_', 'ultimatebranding_settings_'.$module['tab'] );
						$messages = apply_filters( $action.'_messages', $this->messages );
						/**
						 * admin page title
						 */
						printf( '<h2>%s</h2>', esc_html( $module['page_title'] ) );
						do_action( 'ultimatebranding_settings_after_title' );
						do_action( $panel.'_after_title' );
						do_action( $module['module'].'_after_title' );
						/**
						 * message
						 */
						if ( isset( $_GET['msg'] ) ) {
							$msg = $_GET['msg'];
							$msg = isset( $messages[ $msg ] ) ? $msg : 'fail';
							echo '<div id="message" class="updated fade"><p>' . $messages[ $_GET['msg'] ] . '</p></div>';
							$_SERVER['REQUEST_URI'] = UB_Help::remove_query_arg( array( 'msg' ), $_SERVER['REQUEST_URI'] );
						}
						echo  '<div id="poststuff" class="metabox-holder m-settings">';
						/**
						 * Form encoding type
						 */
						$enctype = apply_filters( 'ultimatebranding_settings_form_enctype', 'multipart/form-data' );
						if ( ! empty( $enctype ) ) {
							$enctype = sprintf(
								' enctype="%s"',
								esc_attr( $enctype )
							);
						}
						printf(
							'<form action="" method="%s" class="tab-%s"%s>',
							apply_filters( 'ultimatebranding_settings_form_method', 'post' ),
							esc_attr( $tab ),
							$enctype
						);
						printf( '<input type="hidden" name="tab" value="%s" id="ub-tab"/>', esc_attr( $tab ) );
						printf( '<input type="hidden" name="page" value="%s" />', esc_attr( $page ) );
						if ( apply_filters( 'ultimatebranding_settings_form_add_fields', true ) ) {
							echo '<input type="hidden" name="action" value="process" />';
							wp_nonce_field( 'boxes', 'postboxes_nonce', false );
							/**
							 * nonce
							 */
							wp_nonce_field( $action );
						}
						do_action( $action );
						/**
						 * submit button
						 */
						$filter = $action.'_process';
						if (
							has_filter( $filter )
							&& apply_filters( 'ultimatebranding_settings_panel_show_submit', true )
						) {
							$this->button_save();
						}
						echo '</form></div>';
						$show = false;
					}
				} else {
					$inactive_modules .= $this->module_is_not_active_message( $module );
				}
			}
			echo $inactive_modules;
		}

		/**
		 * Print button save.
		 *
		 * @since 1.8.4
		 */
		public function button_save() {
			printf(
				'<p class="submit"><input type="submit" name="Submit" class="button-primary" value="%s" /></p>',
				esc_attr__( 'Save Changes', 'ub' )
			);
		}

		/**
		 * Print header
		 *
		 * @since 1.8.4
		 *
		 * @param string $title Title of the current admin page.
		 */
		public function header( $title ) {
		}

		/**
		 * Sort helper for menu.
		 *
		 * @since 1.8.6
		 */
		private function sort_admin_menu( $a, $b ) {
			if ( 'branding' == $b[2] ) {
				return 1;
			}
			if ( 'branding' == $a[2] ) {
				return -1;
			}
			return strcasecmp( $a[0], $b[0] );
		}

		/**
		 * Should I show menu in admin subsites?
		 *
		 * @since 1.8.6
		 */
		private function check_show_in_subsites() {
			if ( is_multisite() && is_network_admin() ) {
				return true;
			}
			$modules = get_ub_activated_modules();
			if ( empty( $modules ) ) {
				return false;
			}
			foreach ( $modules as $module => $state ) {
				if ( 'yes' != $state ) {
					continue;
				}
				if (
					isset( $this->configuration[ $module ] )
					&& isset( $this->configuration[ $module ]['show-on-single'] )
					&& $this->configuration[ $module ]['show-on-single']
				) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Get module by tab.
		 *
		 * @since 1.8.8
		 *
		 * @param string $tab Tab.
		 */
		private function get_modules_by_tab( $tab = null ) {
			if ( null == $tab ) {
				$tab = get_query_var( 'tab' );
			}
			$modules = array();
			$tab = preg_replace( '/_/', '-', $tab );
			foreach ( $this->configuration as $key => $module ) {
				if ( ! isset( $module['tab'] ) ) {
					continue;
				}
				if ( $tab == $module['tab'] ) {
					$modules[ $key ] = $module;
				}
			}
			return $modules;
		}

		/**
		 * get nonced url
		 *
		 * @since 1.8.8
		 */
		private function get_nonce_url( $module ) {
			global $page;
			$is_active = ub_is_active_module( $module );
			$url = add_query_arg(
				array(
					'page' => $page,
					'action' => $is_active? 'disable':'enable',
					'module' => $module,
				),
				is_network_admin()? network_admin_url( 'admin.php' ) : admin_url( 'admin.php' )
			);
			$nonce_action = sprintf( '%s-module-%s', $is_active? 'disable':'enable', $module );
			$url = wp_nonce_url( $url, $nonce_action );
			return $url;
		}

		/**
		 * get inactive module message
		 *
		 * @since 1.8.8
		 */
		private function module_is_not_active_message( $module ) {
			$content = '';
			$title = isset( $module['title'] )? $module['title']:$module['page_title'];
			$content .= sprintf( '<h1>%s</h1>', esc_html( $title ) );
			$content .= '<div class="ub-module-info">';
			$content .= sprintf( '<h2>%s</h2>', esc_html__( 'This module is not active!', 'ub' ) );
			$content .= '<p>';
			$content .= sprintf(
				__( 'Turn on %s module.', 'ub' ),
				sprintf(
					'<a href="%s">%s</a>',
					$this->get_nonce_url( $module['key'] ),
					esc_html( $title )
				)
			);
			$content .= '</p>';
			$content .= '</div>';
			return $content;
		}

		/**
		 * Get base url
		 *
		 * @since 1.8.8
		 */
		private function get_base_url() {
			if ( empty( $this->base_url ) ) {
				global $page;
				if ( empty( $page ) ) {
					if ( isset( $_REQUEST['page'] ) ) {
						$page = esc_html( $_REQUEST['page'] );
					}
				}
				$this->base_url = add_query_arg(
					array(
						'page' => $page,
					),
					is_network_admin()? network_admin_url( 'admin.php' ):admin_url( 'admin.php' )
				);
			}
			return $this->base_url;
		}

		/**
		 * fake functions to build admin submenu
		 */
		public function handle_adminbar_panel() {}
		public function handle_admin_menu_panel() {}
		public function handle_admin_panel_tips_panel() {}
		public function handle_author_box_panel() {}
		public function handle_comments_control_panel() {}
		public function handle_css_panel() {}
		public function handle_dashboard_feeds_panel() {}
		public function handle_dashboard_text_widgets_panel() {}
		public function handle_footer_panel() {}
		public function handle_from_email_panel() {}
		public function handle_header_panel() {}
		public function handle_help_panel() {}
		public function handle_htmlemail_panel() {}
		public function handle_images_panel() {}
		public function handle_login_screen_panel() {}
		public function handle_maintenance_panel() {}
		public function handle_multisite_panel() {}
		public function handle_permalinks_panel() {}
		public function handle_sitegenerator_panel() {}
		public function handle_textchange_panel() {}
		public function handle_ultimate_color_schemes_panel() {}
		public function handle_widgets_panel() {}
		public function handle_smtp_panel() {}
		public function handle_db_error_page_panel() {}
		public function handle_ms_site_check_panel() {}
		public function handle_cookie_notice_panel() {}
		public function handle_tracking_codes_panel() {}
		public function handle_document_panel() {}

		/**
		 * sanitize tab
		 *
		 * @since 1.9.1
		 */
		private function set_and_sanitize_tab() {
			$this->tab = 'dashboard';
			if ( ! isset( $_REQUEST['tab'] ) ) {
				return;
			}
			if ( 'dashboard' == $_REQUEST['tab'] ) {
				return;
			}
			foreach ( $this->configuration  as $module ) {
				if ( isset( $module['tab'] ) && $_REQUEST['tab'] == $module['tab'] ) {
					$this->tab = $module['tab'];
					return;
				}
			}
		}

		/**
		 * get tab
		 *
		 * @since 1.9.1
		 */
		public function get_current_tab() {
			return $this->tab;
		}

		/**
		 * Activate/deactivate single module AJAX action.
		 *
		 * @since 1.9.6
		 */
		public function toggle_module() {
			if (
				isset( $_POST['nonce'] )
				&& isset( $_POST['state'] )
				&& isset( $_POST['module'] )
				&& isset( $this->modules[ $_POST['module'] ] )
				&& wp_verify_nonce( $_POST['nonce'], $_POST['module'] )
			) {
				$result = false;
				$message = array(
					'class' => 'error',
					'message' => $this->messages['fail'],
				);
				/**
				 * Get plugin data
				 */
				$module_data = array(
					'name' => __( 'Unknown', 'ub' ),
				);
				if ( isset( $this->configuration[ $_POST['module'] ] ) ) {
					$module_data = $this->configuration[ $_POST['module'] ];
				}
				/**
				 * try to activate or deactivate
				 */
				if ( 'on' == $_POST['state'] ) {
					$result = $this->activate_module( $_POST['module'] );
					if ( $result ) {
						$message = array(
							'class' => 'success',
							'message' => sprintf(
								__( 'Module %s was activated successfully.', 'ub' ),
								$this->bold( $module_data['name'] )
							),
						);
					}
				} else {
					$result = $this->deactivate_module( $_POST['module'] );
					if ( $result ) {
						$message = array(
							'class' => 'success',
							'message' => sprintf(
								__( 'Module %s was deactivated without errors.', 'ub' ),
								$this->bold( $module_data['name'] )
							),
						);
					}
				}
				$this->add_message( $message );
				$data = array(
					'state' => $result,
					'module' => $_POST['module'],
				);
				wp_send_json_success( $data );
			}
			wp_send_json_error();
		}

		/**
		 * Sort module by menu_title or page_title.
		 *
		 * @since 2.0.0
		 */
		public function sort_modules_by_menu_title( $a, $b ) {
			$an = $bn = '';
			if ( isset( $a['menu_title'] ) ) {
				$an = $a['menu_title'];
			} else if ( isset( $a['page_title'] ) ) {
				$an = $a['page_title'];
			}
			if ( isset( $b['menu_title'] ) ) {
				$bn = $b['menu_title'];
			} else if ( isset( $b['page_title'] ) ) {
				$bn = $b['page_title'];
			}
			return strcmp( $an, $bn );
		}

		/**
		 * Get tab url
		 */
		public function get_tab_url( $tab ) {
			$base_url = $this->get_base_url();
			$url = add_query_arg( 'tab', $data['tab'], $base_url );
			return $url;
		}
	}
}