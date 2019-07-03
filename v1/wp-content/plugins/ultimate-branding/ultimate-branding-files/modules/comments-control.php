<?php
if ( ! class_exists( 'ub_comments_control' ) ) {

	class ub_comments_control extends ub_helper {

		protected $option_name = 'ub_comments_control';
		/**
		 * module status, false will be not working
		 */
		private $status = false;
		private $remove_everywhere = false;
		private $post_types = array();
		private $option_name_cpt = 'ub_comments_control_cpt';

		public function __construct() {
			parent::__construct();
			$this->set_options();
			add_filter( 'comment_flood_filter', array( $this, 'limit_comments_flood_filter' ), 10, 3 );
			add_action( 'ultimatebranding_settings_comments_control', array( $this, 'admin_options_page' ) );
			add_action( 'ultimatebranding_settings_comments_control_process', array( $this, 'update' ) );
			$this->upgrade();
			add_action( 'init', array( $this, 'set' ), 11 );
			add_action( 'shutdown', array( $this, 'save_post_types' ) );
			add_filter( 'comments_open', array( $this, 'comments_open_check' ), 10, 2 );
		}

		/**
		 * Comments Open filter
		 *
		 * @since 2.2.0
		 */
		public function comments_open_check( $status, $post_id ) {
			if ( $this->remove_everywhere ) {
				return false;
			} else {
				$post_type = get_post_type( $post_id );
				$disabled = $this->get_value( 'settings', 'post_types', array() );
				if ( array_key_exists( $post_type, $disabled ) ) {
					return false;
				}
			}
			return $status;
		}

		/**
		 * apply rules
		 */
		public function set() {
			$settings = $this->get_value( 'settings' );
			if ( empty( $settings ) || ! is_array( $settings ) ) {
				return;
			}
			$this->status = isset( $settings['status'] ) && 'on' === $settings['status'];
			if ( false === $this->status ) {
				return;
			}
			$this->remove_everywhere = isset( $settings['by_post_type'] ) && 'off' === $settings['by_post_type'];
			/**
			 * off - disable everywhere
			 */
			if ( $this->remove_everywhere ) {
				add_action( 'widgets_init', array( $this, 'unregister_widgets' ) );
				add_filter( 'wp_headers', array( $this, 'filter_wp_headers' ) );
				add_action( 'template_redirect', array( $this, 'filter_query' ), 9 );

				// Admin bar filtering has to happen here since WP 3.6
				add_action( 'template_redirect', array( $this, 'filter_admin_bar' ) );
				add_action( 'admin_init', array( $this, 'filter_admin_bar' ) );
				add_action( 'admin_menu', array( $this, 'filter_admin_menu' ), PHP_INT_MAX );
				add_action( 'admin_print_styles-index.php', array( $this, 'admin_css' ) );
				add_action( 'admin_print_styles-profile.php', array( $this, 'admin_css' ) );
				add_action( 'wp_dashboard_setup', array( $this, 'filter_dashboard' ) );
				add_filter( 'pre_option_default_pingback_flag', '__return_zero' );
				add_filter( 'manage_posts_columns', array( $this, 'remove_column_comments' ) );
				add_filter( 'manage_pages_columns', array( $this, 'remove_column_comments' ) );
				add_filter( 'manage_media_columns', array( $this, 'remove_column_comments' ) );
				$post_types = $this->get_post_types();
				foreach ( $post_types as $type => $label ) {
					// we need to know what native support was for later
					if ( post_type_supports( $type, 'comments' ) ) {
						remove_post_type_support( $type, 'comments' );
						remove_post_type_support( $type, 'trackbacks' );
					}
				}
			} else {
				if ( isset( $settings['post_types'] ) && is_array( $settings['post_types'] ) ) {
					$this->post_types = $settings['post_types'];
				}
				if ( empty( $this->post_types ) ) {
					if ( is_admin() ) {
						add_action( 'all_admin_notices', array( $this, 'setup_notice' ) );
					}
				} else {
					foreach ( $this->post_types as $type => $label ) {
						// we need to know what native support was for later
						if ( post_type_supports( $type, 'comments' ) ) {
							remove_post_type_support( $type, 'comments' );
							remove_post_type_support( $type, 'trackbacks' );
						}
					}
					add_filter( 'comments_array', array( $this, 'filter_existing_comments' ), 20, 2 );
					add_filter( 'comments_open', array( $this, 'filter_comment_status' ), 20, 2 );
					add_filter( 'pings_open', array( $this, 'filter_comment_status' ), 20, 2 );
				}
			}
		}

		public function upgrade() {
			$value = ub_get_option( $this->option_name );
			if ( empty( $value ) ) {
				/**
				 * migrate data from plugin Comments Control
				 * https://premium.wpmudev.org/project/comments-control/
				 */
				$value['rules']['whitelist'] = ub_get_option( 'limit_comments_allowed_ips' );
				$value['rules']['blacklist'] = ub_get_option( 'limit_comments_denied_ips' );
				ub_update_option( $this->option_name, $value );
				ub_delete_option( 'limit_comments_allowed_ips' );
				ub_delete_option( 'limit_comments_denied_ips' );
			}
		}

		public function limit_comments_flood_filter( $flood_die, $time_lastcomment, $time_newcomment ) {
			global $user_id;
			if ( intval( $user_id ) > 0 ) {
				return false;
			}
			/**
			 * get settings
			 */
			$value = ub_get_option( $this->option_name, 'rules' );
			$whitelist = $blacklist = '';
			if ( isset( $value['rules'] ) ) {
				if ( isset( $value['rules']['whitelist'] ) ) {
					$whitelist = $value['rules']['whitelist'];
				}
				if ( isset( $value['rules']['blacklist'] ) ) {
					$blacklist = $value['rules']['blacklist'];
				}
			}
			if ( trim( $whitelist ) != '' || trim( $blacklist ) != '' ) {
				$_remote_addr = isset( $_SERVER['HTTP_X_FORWARDED_FOR'] )?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR'];
				$_remote_addr = preg_replace( '/\./', '\.', $_remote_addr );
				if ( preg_match( '/'.$_remote_addr.'/i', $whitelist ) > 0 ) {
					return false;
				}
				if ( preg_match( '/'.$_remote_addr.'/i', $blacklist ) > 0 ) {
					return true;
				}
			}
			return $flood_die;
		}

		/**
		 * Set options Configuration
		 *
		 * @since 1.8.6
		 */
		protected function set_options() {
			$this->module = 'comments-control';
			$this->options = array(
				'settings' => array(
					'title' => __( 'Disable Comments', 'ub' ),
					'fields' => array(
						'status' => array(
							'type' => 'checkbox',
							'label' => __( 'Status', 'ub' ),
							'description' => __( 'Would you like to disable comments? Warning: This option is global and will affect your entire site. Use it only if you want to disable comments everywhere.', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'enabled',
						),
						'by_post_type' => array(
							'type' => 'checkbox',
							'label' => __( 'Post Types', 'ub' ),
							'options' => array(
								'on' => __( 'Certain Post Types', 'ub' ),
								'off' => __( 'All', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'master' => 'enabled',
							'slave-class' => 'enabled-posts',
						),
						'post_types' => array(
							'label' => __( 'Certain Post Types', 'ub' ),
							'type' => 'checkboxes',
							'master' => 'enabled-posts',
							'options' => $this->get_post_types(),
						),
					),
				),
				'rules' => array(
					'title' => __( 'Allowed rules apply before denied rules', 'ub' ),
					'hide-reset' => true,
					'fields' => array(
						'whitelist' => array(
							'type' => 'textarea',
							'label' => __( 'IP Whitelist', 'ub' ),
							'description' => __( 'IPs for which comments will not be throttled. One IP per line or comma separated.', 'ub' ),
							'classes' => array( 'large-text' ),
						),
						'blacklist' => array(
							'type' => 'textarea',
							'label' => __( 'IP Blacklist', 'ub' ),
							'description' => __( 'IPs for which comments will be throttled. One IP per line or comma separated.', 'ub' ),
							'classes' => array( 'large-text' ),
						),
					),
					'master' => array(
						'section' => 'settings',
						'field' => 'status',
						'value' => 'on',
					),
				),
			);
		}

		/**
		 * get post types
		 *
		 * @since 2.2.0
		 */
		private function get_post_types() {
			$types = array();
			$args = array(
				'public' => true,
			);
			$t = get_post_types( $args, 'objects' );
			foreach ( $t as $key => $one ) {
				if ( isset( $one->labels->singular_name ) ) {
					$types[ $key ] = $one->labels->singular_name;
				} else if ( isset( $one->label ) ) {
					$types[ $key ] = $one->label;
				} else {
					$types[ $key ] = $key;
				}
			}
			/**
			 * get CPT registered by sites
			 */
			$t = ub_get_option( $this->option_name_cpt, array() );
			if ( is_array( $t ) && ! empty( $t ) ) {
				$types += $t;
			}
			asort( $types );
			return $types;
		}

		public function unregister_widgets() {
			unregister_widget( 'WP_Widget_Recent_Comments' );
		}

		/*
         * Remove the X-Pingback HTTP header
         */
		public function filter_wp_headers( $headers ) {
			unset( $headers['X-Pingback'] );
			return $headers;
		}

		/*
         * Issue a 403 for all comment feed requests.
         */
		public function filter_query() {
			if ( is_comment_feed() ) {
				wp_die( __( 'Comments are closed.' ), '', array( 'response' => 403 ) );
			}
		}

		/*
         * Remove comment links from the admin bar.
         */
		public function filter_admin_bar() {
			if ( is_admin_bar_showing() ) {
				// Remove comments links from admin bar
				remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
				if ( is_multisite() ) {
					add_action( 'admin_bar_menu', array( $this, 'remove_network_comment_links' ), 500 );
				}
			}
		}

		/*
         * Remove comment links from the admin bar in a multisite network.
         */
		public function remove_network_comment_links( $wp_admin_bar ) {
			if ( is_user_logged_in() ) {
				foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {
					$wp_admin_bar->remove_menu( 'blog-' . $blog->userblog_id . '-c' );
				}
			} else {
				// We have no way to know whether the plugin is active on other sites, so only remove this one
				$wp_admin_bar->remove_menu( 'blog-' . get_current_blog_id() . '-c' );
			}
		}

		public function filter_admin_menu() {
			global $pagenow;

			if ( $pagenow == 'comment.php' || $pagenow == 'edit-comments.php' || $pagenow == 'options-discussion.php' ) {
				wp_die( __( 'Comments are closed.' ), '', array( 'response' => 403 ) ); }

			remove_menu_page( 'edit-comments.php' );
			remove_submenu_page( 'options-general.php', 'options-discussion.php' );

			/**
			 * remove meta box
			 */
			$post_types = $this->get_post_types();
			$contexts = array( 'normal', 'advanced', 'side' );
			foreach ( $post_types as $post_type => $label ) {
				foreach ( $contexts as $context ) {
					remove_meta_box( 'commentstatusdiv', $post_type, $context );
					remove_meta_box( 'commentsdiv', $post_type, $context );
				}
			}
		}
		public function admin_css() {
			echo '<style id="ub-comments-control-admin" type="text/style">';
			echo '#dashboard_right_now .comment-count,';
			echo '#dashboard_right_now .comment-mod-count,';
			echo '#latest-comments,';
			echo '#welcome-panel .welcome-comments,';
			echo '.user-comment-shortcuts-wrap {';
			echo 'display: none !important;';
			echo '}';
			echo '</style>';
		}

		public function filter_dashboard() {
			remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		}

		public function remove_column_comments( $columns ) {
			if ( isset( $columns['comments'] ) ) {
				unset( $columns['comments'] );
			}
			return $columns;
		}

		public function save_post_types() {
			$post_types = get_post_types( array( '_builtin' => false ), 'objects' );
			if ( empty( $post_types ) ) {
				return;
			}
			$types = ub_get_option( $this->option_name_cpt );
			foreach ( $post_types as $key => $one ) {
				$support = post_type_supports( $key, 'comments' );
				if ( ! $support ) {
					continue;
				}
				if ( isset( $one->labels->singular_name ) ) {
					$types[ $key ] = $one->labels->singular_name;
				} else if ( isset( $one->label ) ) {
					$types[ $key ] = $one->label;
				} else {
					$types[ $key ] = $key;
				}
			}
			ub_update_option( $this->option_name_cpt, $types );
		}

		private function filter_by_post( $post ) {
			if ( true === $this->remove_everywhere ) {
				return true;
			}
			if ( ! is_a( $post, 'WP_Post' ) ) {
				$post = get_post( $post );
			}
			if ( ! is_a( $post, 'WP_Post' ) ) {
				return false;
			}
			if ( array_key_exists( $post->post_type, $this->post_types ) ) {
				return true;
			}
			return false;
		}

		public function filter_existing_comments( $comments, $post_id ) {
			$filter = $this->filter_by_post( $post_id );
			if ( $filter ) {
				return array();
			}
			return $comments;
		}

		public function filter_comment_status( $open, $post_id ) {
			$filter = $this->filter_by_post( $post_id );
			if ( $filter ) {
				return false;
			}
			return $open;
		}


		public function setup_notice() {
			$screen = get_current_screen();
			if ( ! preg_match( '/page_branding/', $screen->id ) ) {
				return;
			}
			if ( 'comments-control' === $this->tab ) {
				return;
			}
			$url = $this->get_base_url();
			$url = add_query_arg( 'tab', 'comments-control', $url );

			$message = sprintf( __( 'The <em>Comments Control</em> module is active, but is not properly configured. Visit the <a href="%s">configuration page</a> to choose which post types to disable comments on.', 'disable-comments' ), esc_url( $url ) );
			$this->notice( $message, 'error' );
		}
	}
}

new ub_comments_control();