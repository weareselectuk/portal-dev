<?php

include_once 'favicons/UB_Blog_Favicons.php';

if ( ! class_exists( 'ub_favicons' ) ) {

	class ub_favicons extends ub_helper {

		protected $option_name = 'ub_favicons';
		/**
		 * WP default fav
		 * @var string
		 *
		 * @since 1.8.1
		 */
		private $_default_fav = '';

		public function __construct() {
			$this->_default_fav = admin_url() . 'images/w-logo-blue.png';
			parent::__construct();
			$this->set_options();
			add_action( 'ultimatebranding_settings_images', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_images_process', array( $this, 'update' ) );
			if ( ! $this->_supports_site_icon() ) {
				add_action( 'admin_head', array( $this, 'admin_head' ) );
				add_action( 'admin_head', array( $this, 'global_head' ) );
				add_action( 'wp_head', array( $this, 'global_head' ) );
			} else {
				add_filter( 'get_site_icon_url', array( $this, 'site_icon_url' ), 10, 3 );
			}
			if ( $this->_override_site_icon()  ) {
				add_action( 'wp_before_admin_bar_render', array( $this, 'change_blavatar_icon' ) );
			}
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_filter( 'upload_mimes', array( $this, 'upload_mimes' ) );
			/**
			 * export
			 */
			add_filter( 'ultimate_branding_export_data', array( $this, 'export' ) );
			/**
			 * Favicons on Sites screen.
			 */
			add_filter( 'wpmu_blogs_columns', array( $this, 'wpmu_blogs_columns' ) );
			add_action( 'admin_head-sites.php', array( $this, 'wpmu_blogs_columns_css' ) );
			add_action( 'manage_sites_custom_column', array( $this, 'manage_sites_custom_column' ), 10, 2 );
			/**
			 * add options names
			 *
			 * @since 2.1.0
			 */
			add_filter( 'ultimate_branding_options_names', array( $this, 'add_options_names' ) );
			/**
			 * upgrade options
			 *
			 * @since 2.1.0
			 */
			add_action( 'init', array( $this, 'upgrade_options' ) );
		}

		/**
		 * Set options
		 *
		 * @since 2.1.0
		 */
		protected function set_options() {
			global $UB_network;
			$this->options = array(
				'global' => array(
					'title' => __( 'Favicons', 'ub' ),
					'fields' => array(
						'override' => array(
							'type' => 'checkbox',
							'label' => __( 'Allow override', 'ub' ),
							'description' => __( 'Allow favicon defined here to override the site icon defined in <strong>Appearance > Customization</strong> ', 'ub' ),
							'options' => array(
								'on' => __( 'Allow', 'ub' ),
								'off' => __( 'Disallow', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
						),
						'favicon' => array(
							'type' => 'media',
							'label' => $UB_network? __( 'Main site Favicons', 'ub' ):__( 'Site Favicon', 'ub' ),
							'description' => __( 'Upload your own logo.', 'ub' ),
							'default' => $this->_default_fav,
						),
					),
				),
			);
			/**
			 * multisite only
			 */
			if ( $UB_network && is_admin() && 'images' === $this->tab ) {
				$this->options['global']['fields']['use_as_default'] = array(
					'type' => 'checkbox',
					'label' => __( 'Default for subsites', 'ub' ),
					'description' => __( 'Use this as default favicon for all sub-sites.', 'ub' ),
					'options' => array(
						'on' => __( 'On', 'ub' ),
						'off' => __( 'Off', 'ub' ),
					),
					'default' => 'off',
					'classes' => array( 'switch-button' ),
				);
				if ( function_exists( 'get_sites' ) ) {
					$this->options['sites'] = array(
						'title' => __( 'Sub-sites', 'ub' ),
						'fields' => array(),
						'hide-reset' => true,
						'master' => array(
							'section' => 'global',
							'field' => 'use_as_default',
							'value' => 'off',
						),
					);
					$blog_id = ub_get_main_site_ID();
					$sites = get_sites( array( 'number' => 0 ) );
					foreach ( $sites as $site ) {

						if ( $blog_id == $site->blog_id ) {
							continue;
						}
						$details = get_blog_details( $site->blog_id );
						$label = sprintf(
							'<span class="ub-title">%s</span><br ><small><a href="%s" target="_blank">%s</a></small>',
							esc_html( $details->blogname ),
							esc_url( $details->siteurl ),
							esc_url( $details->siteurl )
						);
						$key = 'blog_id_'.$site->blog_id;
						$this->options['sites']['fields'][ $key ] = array(
							'type' => 'media',
							'label' => $label,
							'label_rich' => true,
							'description' => __( 'Upload your own logo.', 'ub' ),
						);
					}
				}
			}
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
				'global' => array(
					'dir' => ub_get_option( 'ub_favicon_dir', '' ),
					'favicon' => ub_get_option( 'ub_favicon', '' ),
					'id' => ub_get_option( 'ub_favicon_id', '' ),
					'override' => ub_get_option( 'ub_favicons_override_site_icon', '' )? 'on':'off',
					'size' => ub_get_option( 'ub_favicon_size', '' ),
					'url' => ub_get_option( 'ub_favicon_url', '' ),
					'use_as_default' => ub_get_option( 'ub_favicons_use_as_default', '' )? 'on':'off',
					'favicon_meta' => array(
						ub_get_option( 'ub_favicon', '' ),
					),
				),
				'sites' => array(),
			);
			/**
			 * multisite only
			 */
			if ( function_exists( 'get_sites' ) ) {
				$sites = get_sites( array( 'fields' => 'ids', 'number' => 0 ) );
				foreach ( $sites as $site_id ) {
					$key = 'ub_favicon'.$site_id;
					$v = ub_get_option( $key, false );
					if ( is_array( $v ) ) {
						$data['sites'][ 'blog_id_'.$site_id ] = $v['id'];
						$data['sites'][ 'blog_id_'.$site_id.'_meta' ] = array( $v['url'], 64, 64, null );
					}
				}
			}
			$this->update_value( $data );
		}
		/**
		 * Add option names
		 *
		 * @since 2.1.0
		 */
		public function add_options_names( $options ) {
			$options[] = 'ub_favicon';
			$options[] = 'ub_favicon_dir';
			$options[] = 'ub_favicon_id';
			$options[] = 'ub_favicon_size';
			$options[] = 'ub_favicons_override_site_icon';
			$options[] = 'ub_favicons_use_as_default';
			$options[] = 'ub_favicon_url';
			return $options;
		}

		public function admin_enqueue_scripts() {
			global $ub_version;
			wp_register_style( 'ub_favicons_style', ub_files_url( 'modules/favicons/css/admin.css' )  . '', false, $ub_version );
			wp_enqueue_style( 'ub_favicons_style' );
		}

		/**
		 * Front favicon size.
		 *
		 * @since 1.9.0
		 */
		public function enqueue_scripts() {
			if ( ! is_user_logged_in() ) {
				return;
			}
			global $ub_version;
			wp_register_style( 'favicons-front', ub_files_url( 'modules/favicons/css/front.css' )  . '', false, $ub_version );
			wp_enqueue_style( 'favicons-front' );
		}

		/**
		 * Returns valid schema
		 *
		 * @param $url
		 *
		 * @return mixed
		 */
		private function get_url_valid_shema( $url ) {
			$image = $url;
			$v_image_url = parse_url( $url );
			if ( isset( $v_image_url['scheme'] ) && $v_image_url['scheme'] == 'https' ) {
				// Allow http sites to load https favicons
			} else {
				if ( is_ssl() ) {
					$image = str_replace( 'http', 'https', $image );
				}
			}
			return $image;
		}

		public function admin_head() {
			$uploaddir = ub_wp_upload_dir();
			$uploadurl = ub_wp_upload_url();
			$uploadurl = preg_replace( array( '/http:/i', '/https:/i' ), '', $uploadurl );
			$favicon = ub_get_option( 'ub_favicon', false );
			if ( file_exists( $uploaddir . '/ultimate-branding/includes/favicon/favicon.png' ) || $favicon ) {
				if ( ! $favicon ) {
					$site_ico = $uploadurl . '/ultimate-branding/includes/favicon/favicon.png';
				} else {
					$site_ico = $this->get_url_valid_shema( $favicon );
				}
				echo '<style type="text/css">
                    #header-logo { background-image: url(' . $site_ico . '); }
                    #wp-admin-bar-wp-logo > .ab-item .ab-icon { background-image: url(' . $site_ico . '); background-position: 0; }
                    #wp-admin-bar-wp-logo:hover > .ab-item .ab-icon { background-image: url(' . $site_ico . '); background-position: 0 !Important; }
                    #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon { background-image: url(' . $site_ico . '); background-position: 0 !Important; }
                    </style>';
			}
		}

		public function global_head() {
			$favicon_dir = ub_get_option( 'ub_favicon_dir', false );
			$favicon = ub_get_option( 'ub_favicon', false );
			if ( $favicon_dir && file_exists( $favicon_dir ) || $favicon ) {
				echo '<link rel="shortcut icon" href="' . $this->get_favicon( get_current_blog_id() ) . '" />';
			}
		}

		/**
		 * Changes icons of the subnsites in the admin menus
		 *
		 *
		 */
		public function change_blavatar_icon() {
			global $wp_admin_bar;
			if ( ! isset( $wp_admin_bar->user, $wp_admin_bar->user->blogs ) ) { return; }
			foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {
				$blavatar = '<img src="' . $this->get_favicon( $blog->userblog_id ) . '" alt="' . esc_attr__( 'Blavatar' ) . '" width="16" height="16" class="blavatar"/>';
				$blogname = empty( $blog->blogname ) ? $blog->domain : $blog->blogname;
				$wp_admin_bar->add_menu(array(
					'parent' => 'my-sites-list',
					'id' => 'blog-' . $blog->userblog_id,
					'title' => $blavatar . $blogname,
					'href' => get_admin_url( $blog->userblog_id ),
				));
			}
		}

		/**
		 * Renders sub-sites favicon section
		 *
		 * @since 1.8.1
		 *
		 */
		public function _render_subsites_favicon() {
			if ( ! is_multisite() || wp_is_large_network() ) { return; }?>
        <p>
            <label for="ub_favicons_use_as_default">
                <input type="checkbox" id="ub_favicons_use_as_default" name="ub_favicons_use_as_default" <?php checked( $this->_use_as_default(), true ); ?>  />
                <?php _e( 'Use this as default favicon for all sub-sites', 'ub' ); ?>
            </label>
        </p>
        <h4><?php _e( 'Sub-site favicons', 'ub' ); ?></h4>
<?php
			$table = new UB_Blog_Favicons();
			$table->set_ub_favicons( $this );
			$table->prepare_items();
			$table->display();
		}

		/**
		 * Checks to see if blog has a favicon
		 *
		 * @param null $blog_id
		 *
		 * @since 1.8.1
		 *
		 * @return bool
		 */
		public function has_favicon( $blog_id = null ) {
			if ( empty( $blog_id ) ) {
				return false;
			}
			$value = $this->get_value( 'sites', $blog_id );
			if ( is_array( $value ) && isset( $value['url'] ) && ! empty( $value['url'] ) ) {
				return true;
			}
			return false;
		}

		/**
		 * Retrieves favicon based on blog_id
		 *
		 * @param string $blog_id
		 * @param bool $add_tail
		 *
		 * @since 1.8.1
		 *
		 * @return string
		 */
		public function get_favicon( $blog_id = null, $add_tail = false ) {
			/**
			 * If it's the main site return the main fav
			 */
			if ( empty( $blog_id ) || is_main_site( $blog_id ) ) {
				return $this->get_main_favicon( $add_tail );
			}
			/**
			 * if use default, do not proceder more
			 */
			if ( $this->_use_as_default() ) {
				return $this->get_main_favicon( $add_tail );
			}
			$tail = $add_tail ? '?' . md5( time() ) : '';
			/**
			 * get value
			 */
			$v = $this->get_value( 'sites', 'blog_id_'.$blog_id.'_meta' );
			if ( is_array( $v ) ) {
				$v = array_shift( $v );
				if ( ! empty( $v ) ) {
					return $this->get_url_valid_shema( $v ) . $tail;
				}
			}
			return $this->_default_fav . $tail;
		}

		/**
		 * Retrieves main favicon
		 *
		 * @param bool $add_tail
		 *
		 * @since 1.8.1
		 *
		 * @return string
		 */
		public function get_main_favicon( $add_tail = true ) {
			$url = $this->_default_fav;
			$favicon = $this->get_value( 'global', 'favicon_meta', false );
			if ( ! empty( $favicon ) && is_array( $favicon ) ) {
				$url = $this->get_url_valid_shema( $favicon[0] );
			} elseif ( is_string( $favicon ) ) {
				$url = $this->get_url_valid_shema( $favicon );
			} else {
				$favicon = $this->get_value( 'global', 'favicon', false );
				if ( is_string( $favicon ) ) {
					$url = $this->get_url_valid_shema( $favicon );
				}
			}
			if ( $add_tail ) {
				$tail = md5( time() );
				$url = add_query_arg( 'ub', $tail, $url );
			}
			return $url;
		}

		/**
		 * Returns use as default option
		 * If it's true it means that the main image is being used as default favicon for all sub-sites
		 *
		 * @since 1.8.1
		 *
		 * @return bool
		 */
		private function _use_as_default() {
			$value = $this->get_value( 'global', 'use_as_default', 'off' );
			if ( 'on' === $value ) {
				return true;
			}
			return false;
		}

		private function _override_site_icon() {
			if ( function_exists( 'has_site_icon' ) ) {
				$v = $this->get_value( 'global', 'override', 'off' );
				if ( 'on' === $v ) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Checks if current wp install supports site icon
		 *
		 * @return bool
		 */
		private function _supports_site_icon() {
			return function_exists( 'has_site_icon' );
		}

		/**
		 * Sets site url based on definitions
		 *
		 * @param $url
		 * @param $size
		 * @param $blog_id
		 * @return mixed
		 */
		public function site_icon_url( $url, $size, $blog_id ) {
			if ( ! $this->_override_site_icon() && ! empty( $url ) ) {
				return $url;
			}
			$blog_id = empty( $blog_id ) ? get_current_blog_id() : $blog_id;
			return $this->get_favicon( $blog_id );
		}

		/**
		 * Add ability to upload SVG and ICO files.
		 *
		 * @since 1.8.6
		 */
		public function upload_mimes( $mime_types ) {
			$mime_types['svg'] = 'image/svg+xml';
			$mime_types['ico'] = 'image/x-icon';
			return $mime_types;
		}

		/**
		 * Export data.
		 *
		 * @since 1.8.6
		 */
		public function export( $data ) {
			$options = $this->add_options_names( array() );
			foreach ( $options as $key ) {
				$data['modules'][ $key ] = ub_get_option( $key );
			}
			return $data;
		}

		/**
		 * Icons on sites list
		 *
		 * @since 1.8.8
		 */
		public function wpmu_blogs_columns( $columns ) {
			$new = array();
			foreach ( $columns as $key => $value ) {
				$new[ $key ] = $value;
				if ( 'blogname' == $key ) {
					$new[ __CLASS__ ] = __( 'Favicon', 'ub' );
				}
			}
			return $new;
		}

		/**
		 * Icons on sites list
		 *
		 * @since 1.8.8
		 */
		public function wpmu_blogs_columns_css() {
			echo '<style type="text/css">';
			echo '.column-ub_favicons { width: 10%; }';
			echo '.column-ub_favicons img {max-width: 16px; max-height: 16px;}';
			echo '</style>';
			echo PHP_EOL;
		}

		/**
		 * Icons on sites list
		 *
		 * @since 1.8.8
		 */
		public function manage_sites_custom_column( $column, $site_id ) {
			if ( 'ub_favicons' != $column ) {
				return;
			}
			$favicon = $this->get_favicon( $site_id );
			if ( empty( $favicon ) ) {
			}
			printf( '<img src="%s" />', esc_url( $favicon ) );
			$url = add_query_arg(
				array(
					'page' => 'branding',
					'tab' => 'images',
				),
				network_admin_url( 'admin.php' )
			);
			echo '<div class="row-actions">';
			printf(
				'<a href="%s">%s</a>',
				esc_url( $url ),
				esc_html__( 'Change', 'ub' )
			);
			echo '</div>';
		}

		/**
		 * modify option name
		 *
		 * @since 2.1.0
		 */
		public function get_module_option_name( $option_name, $module ) {
			if ( is_string( $module ) && 'images' == $module ) {
				return $this->option_name;
			}
			return $option_name;
		}
	}
}
new ub_favicons;