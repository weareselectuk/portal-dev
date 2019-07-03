<?php
/**
 * Branda Site Status Pages class.
 *
 * @package Branda
 * @subpackage Front-end
 */
if ( ! class_exists( 'Branda_Site_Status_Pages' ) ) {

	class Branda_Site_Status_Pages extends Branda_Helper {
		protected $option_name = 'ub_ms_site_check';
		private $is_ready = false;
		private $is_ready_dir = false;
		private $error_files = array(
			'deleted' => 'blog-deleted.php',
			// it do not works, WP do not set "deleted" to "2" (inactive).
			//'inactive' => 'blog-inactive.php',
			'suspended' => 'blog-suspended.php',
		);
		private $db_error_dir;
		protected $file = __FILE__;

		public function __construct() {
			parent::__construct();
			$this->check();
			$this->set_options();
			/**
			 * hooks
			 */
			add_filter( 'ultimatebranding_settings_ms_site_check', array( $this, 'admin_options_page' ) );
			if ( $this->is_ready ) {
				add_filter( 'ultimatebranding_settings_ms_site_check_process', array( $this, 'update' ), 10, 1 );
			}
			/**
			 * Regenerate file after value update.
			 *
			 * @since 3.1.0
			 */
			add_action( 'update_option_'.$this->option_name, array( $this, 'update_option_action' ), 10, 3 );
			add_action( 'update_site_option_'.$this->option_name, array( $this, 'update_site_option_action' ), 10, 4 );
			/**
			 * add related config
			 *
			 * @since 2.3.0
			 */
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_background' ) );
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_logo' ) );
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_social_media_settings' ) );
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_social_media' ) );
			/**
			 * upgrade options
			 *
			 * @since 3.0.0
			 */
			add_action( 'init', array( $this, 'upgrade_options' ) );
		}

		/**
		 * Upgrade option
		 *
		 * @since 3.0.0
		 */
		public function upgrade_options() {
			$value = $this->get_value();
			/**
			 * Check we have plugin_version in saved data
			 */
			if ( isset( $value['plugin_version'] ) ) {
				/**
				 * do not run again big upgrade if config was saved by Branda
				 */
				$version_compare = version_compare( $value['plugin_version'], '3.0.0' );
				if ( -1 < $version_compare ) {
					return;
				}
				return;
			}
			$data = array(
				'show' => array(),
				'content' => array(),
				'design' => array(),
				'colors' => array(),
			);
			if ( isset( $value['show'] ) ) {
				$data['show'] = $value['show'];
			}
			/**
			 * Common migration
			 */
			$data = $this->common_upgrade_options( $data, $value );
			/**
			 * document_suspended
			 */
			if ( isset( $value['document_suspended'] ) ) {
				$v = $value['document_suspended'];
				if ( isset( $v['title'] ) ) {
					$data['content']['suspended_title'] = $v['title'];
				}
				if ( isset( $v['content'] ) ) {
					$data['content']['suspended_content'] = $v['content'];
				}
				if ( isset( $v['content_meta'] ) ) {
					$data['content']['suspended_content_meta'] = $v['content_meta'];
				}
			}
			/**
			 * document_deleted
			 */
			if ( isset( $value['document_deleted'] ) ) {
				$v = $value['document_deleted'];
				if ( isset( $v['title'] ) ) {
					$data['content']['deleted_title'] = $v['title'];
				}
				if ( isset( $v['content'] ) ) {
					$data['content']['deleted_content'] = $v['content'];
				}
				if ( isset( $v['content_meta'] ) ) {
					$data['content']['deleted_content_meta'] = $v['content_meta'];
				}
			}
			$this->update_value( $data );
			$this->update_files( $data );
		}

		/**
		 * Regenerate file after value update for single site.
		 *
		 * @since 3.1.0
		 */
		public function update_option_action( $old_value, $value, $option_name ) {
			$this->update_files( $value );
		}

		/**
		 * Regenerate file after value update for multisite.
		 *
		 * @since 3.1.0
		 */
		public function update_site_option_action( $option_name, $value, $old_value, $network_id ) {
			$this->update_files( $value );
		}

		/**
		 * Create or update `wp-content/blog-?.php` is possible.
		 *
		 * @since 2.0.0
		 */
		private function update_files( $value ) {
			$this->data = $value;
			/**
			 * set data
			 */
			$template_master = $this->get_template();
			$classes = array( 'ultimate-branding-settings-ms-site-check' );
			foreach ( $this->error_files as $slug => $f ) {
				$file = $this->db_error_dir.'/'.$f;
				$value = $this->get_value( 'show', $slug );
				if ( 'on' !== $value ) {
					if ( is_file( $file ) && is_writable( $file ) ) {
						unlink( $file );
					}
					continue;
				}
				$javascript = $php = $css = $head = $logo = '';
				$template = $template_master;
				$body_classes = $classes;
				$body_classes[] = $slug;
				/**
				 * template
				 */
				$php = '<?php';
				$php .= PHP_EOL;
				$php .= 'header(\'HTTP/1.1 410 Gone\');';
				$php .= PHP_EOL;
				$php .= 'header(\'Status: 410 Gone\');';
				$php .= PHP_EOL;
				$php .= '?>';
				/**
				 * Common: Logo
				 */
				$logo = '';
				ob_start();
				$this->css_logo_common( '#logo' );
				$logo_css = ob_get_contents();
				ob_end_clean();
				if ( ! empty( $logo_css ) ) {
					$css .= $logo_css;
					$logo = '<div id="logo">';
					$url = $this->get_value( 'content', 'logo_url' );
					if ( ! empty( $url ) ) {
						$alt = $this->get_value( 'content', 'logo_alt', '' );
						$logo .= sprintf(
							'<a href="%s" title="%s">%s</a>',
							esc_url( $url ),
							esc_attr( $alt ),
							esc_html( $alt )
						);
					}
					$logo .= '</div>';
				}
				/**
				 * Common: Social Media
				 */
				$result = $this->common_options_social_media();
				$social_media = $result['social_media'];
				$body_classes = array_merge( $body_classes, $result['body_classes'] );
				$head .= $result['head'];
				$template = preg_replace( '/{social_media}/', $social_media, $template );
				/**
				 * BODY
				 */
				$css .= $this->common_body_css();
				/**
				 * .page
				 */
				$css .= $this->common_document_css( '.page' );
				/**
				 * h1
				 */
				$value = $this->get_value( 'colors', 'message_title' );
				$css .= sprintf( '.page h1{%s}', $this->css_color( $value ) );
				/**
				 * content
				 */
				$value = $this->get_value( 'colors', 'message_description' );
				$css .= sprintf( '.page .content{%s}', $this->css_color( $value ) );
				/**
				 * Custom CSS
				 *
				 * @since 3.0.0
				 */
				$value = $this->get_value( 'css', 'css', null );
				if ( ! empty( $value ) ) {
					$css .= $value;
				}
				/**
				 * replace
				 */
				foreach ( $this->data as $section => $data ) {
					if ( ! is_array( $data ) ) {
						continue;
					}
					foreach ( $data as $name => $value ) {
						if ( empty( $value ) ) {
							$value = '';
						}
						if ( ! is_string( $value ) ) {
							$value = '';
						}
						if ( ! empty( $value ) ) {
							switch ( $section ) {
								case 'content':
									switch ( $name ) {
										case 'suspended_title':
										case 'deleted_title':
											$value = sprintf( '<h1>%s</h1>', esc_html( $value ) );
											break;
										case 'suspended_content_meta':
										case 'deleted_content_meta':
											$value = sprintf( '<div class="content">%s</div>', $value );
											break;
										default:
											break;
									}
									break;
								default:
									break;
							}
						}
						$re = sprintf( '/{%s_%s}/', $section, $name );
						$template = preg_replace( $re, stripcslashes( $value ), $template );
						if ( 0 === strpos( $name, $slug ) ) {
							$s = preg_replace( '/(inactive|suspended|deleted)_/', '', $name );
							$re = sprintf( '/{document_%s}/', $s );
							$template = preg_replace( $re, stripcslashes( $value ), $template );
						}
					}
				}
				$template = preg_replace( '/{language}/', get_bloginfo( 'language' ), $template );
				if ( ! empty( $social_media ) ) {
					$social_media = sprintf( '<div id="social">%s</div>', $social_media );
				}
				$template = preg_replace( '/{social_media}/', $social_media, $template );
				$template = preg_replace( '/{title}/', get_bloginfo( 'name' ), $template );
				/**
				 * body classes
				 */
				$template = preg_replace( '/{body_class}/', implode( $body_classes, ' ' ), $template );
				/**
				 * head
				 */
				$head .= $this->enqueue( 'css/ms-site-check.css' );
				ob_start();
				$this->css_background_common( 'body' );
				$head .= ob_get_contents();
				ob_end_clean();
				$template = preg_replace( '/{head}/', $head, $template );
				/**
				 * replace css
				 */
				$template = preg_replace( '/{css}/', $css, $template );
				/**
				 * replace javascript
				 */
				$template = preg_replace( '/{javascript}/', $javascript, $template );
				/**
				 * logo
				 */
				$template = preg_replace( '/{logo}/', $logo, $template );
				/**
				 * replace php
				 */
				$template = preg_replace( '/{php}/', $php, $template );
				/**
				 * After body tag
				 */
				$content = $this->html_background_common( false );
				$template = preg_replace( '/{after_body_tag}/', $content, $template );
				/**
				 * write
				 */
				$result = file_put_contents( $file, $template );
			}
		}

		/**
		 * Check that create od file is possible.
		 *
		 * @since 2.0.0
		 */
		private function check() {
			$this->db_error_dir = dirname( get_theme_root() );
			$this->db_error_file = $this->db_error_dir .'/db-error.php';
			if ( ! is_dir( $this->db_error_dir ) || ! is_writable( $this->db_error_dir ) ) {
				return;
			}
			$this->is_ready_dir = true;
			$this->is_ready = true;
		}

		/**
		 * Set options
		 *
		 * @since 2.0.0
		 */
		protected function set_options() {
			$this->module = 'ms-site-check';
			if ( ! $this->is_ready ) {
				$value = __( 'Whoops! Something went wrong.', 'ub' );
				if ( false == $this->is_ready_dir ) {
					$value = sprintf(
						__( 'Directory %s is not writable, we are unable to create files.', 'ub' ),
						sprintf( '<code>%s</code>', $this->db_error_dir )
					);
				}
				$options = array(
					'settings' => array(
						'hide-reset' => true,
						'title' => __( 'Custom Sites Pages', 'ub' ),
						'fields' => array(
							'message' => array(
								'type' => 'description',
								'label' => __( 'Error', 'ub' ),
								'value' => $value,
								'classes' => array( 'message', 'message-error' ),
							),
						),
					),
				);
				$this->options = $options;
				return;
			}
			/**
			 * options
			 */
			$options = array(
				'show' => array(
					'title' => __( 'Modes', 'ub' ),
					'description' => __( 'Enable the custom error pages for sites on your multisite network that have been suspended or deleted.', 'ub' ),
					'fields' => array(
						'suspended' => array(
							'type' => 'sui-tab',
							'label' => __( 'Suspended/Archived', 'ub' ),
							'description' => __( 'Enable a custom error page for sites which have been suspended or archived on your network.', 'ub' ),
							'options' => array(
								'on' => __( 'Enable', 'ub' ),
								'off' => __( 'Disable', 'ub' ),
							),
							'default' => 'off',
						),
						'deleted' => array(
							'type' => 'sui-tab',
							'label' => __( 'Deleted', 'ub' ),
							'description' => __( 'Enable a custom error page for sites which have been deleted on your network.', 'ub' ),
							'options' => array(
								'on' => __( 'Enable', 'ub' ),
								'off' => __( 'Disable', 'ub' ),
							),
							'default' => 'off',
						),
					),
				),
				'content' => array(
					'title' => __( 'Content', 'ub' ),
					'description' => __( 'Adjust the default content of your error pages.', 'ub' ),
					'show-as' => 'accordion',
					'fields' => $this->get_options_fields( 'content', array( 'logo', 'content', 'social', 'reset' ) ),
				),
				'design' => array(
					'title' => __( 'Design', 'ub' ),
					'description' => __( 'Adjust the default content of your error pages.', 'ub' ),
					'show-as' => 'accordion',
					'fields' => $this->get_options_fields( 'design', array( 'logo', 'background', 'social', 'document', 'reset' ) ),
				),
				'colors' => array(
					'title' => __( 'Colors', 'ub' ),
					'description' => __( 'Adjust the default colour combinations as per your liking.', 'ub' ),
					'show-as' => 'accordion',
					'fields' => $this->get_options_fields( 'colors', array( 'logo', 'error_message', 'document', 'reset' ) ),
				),
				/**
				 * Custom CSS
				 *
				 * @since 3.0.0
				 */
				'css' => $this->get_custom_css_array(),
			);
			$this->options = $options;
		}

		/**
		 * Options: Content
		 *
		 * @since 3.0.0
		 */
		public function get_options_fields_content_content( $defaults = array() ) {
			$data = array(
				'suspended_title' => array(
					'label' => __( 'Title (optional)', 'ub' ),
					'default' => __( 'This site has been archived or suspended.', 'ub' ),
					'accordion' => array(
						'begin' => true,
						'title' => __( 'Error Message', 'ub' ),
						'item' => array(
							'classes' => array(
								$this->get_name( 'error_message' ),
							),
						),
					),
					'group' => array(
						'begin' => true,
					),
					'panes' => array(
						'begin' => true,
						'title' => __( 'Archived/Suspended', 'ub' ),
						'begin_pane' => true,
					),
				),
				'suspended_content' => array(
					'type' => 'wp_editor',
					'label' => __( 'Content (optional)', 'ub' ),
					'placeholder' => __( 'You can write description for the page here…', 'ub' ),
					'panes' => array(
						'end_pane' => true,
					),
				),
				'deleted_title' => array(
					'label' => __( 'Title (optional)', 'ub' ),
					'default' => __( 'This site has been archived or deleted.', 'ub' ),
					'panes' => array(
						'title' => __( 'Deleted', 'ub' ),
						'begin_pane' => true,
					),
				),
				'deleted_content' => array(
					'type' => 'wp_editor',
					'label' => __( 'Content (optional)', 'ub' ),
					'placeholder' => __( 'You can write description for the page here…', 'ub' ),
					'accordion' => array(
						'end' => true,
					),
					'group' => array(
						'end' => true,
					),
					'panes' => array(
						'end_pane' => true,
						'end' => true,
					),
				),
			);
			/**
			 * Allow to change content logo fields.
			 *
			 * @since 3.0.0
			 *
			 * @param array $data logo options data.
			 * @param array $defaults Default values from function.
			 * @param string Current module name.
			 */
			return apply_filters( 'branda_'.__FUNCTION__, $data, $defaults, $this->module );
		}

		/**
		 * Override Common Options: Colors -> Error Message
		 *
		 * @since 3.0.0
		 */
		protected function get_options_fields_colors_error_message( $defaults = array() ) {
			$data = array(
				'message_title' => array(
					'type' => 'color',
					'label' => __( 'Title', 'ub' ),
					'accordion' => array(
						'begin' => true,
						'title' => __( 'Error Message', 'ub' ),
					),
					'default' => esc_attr( isset( $defaults['document_color'] )? $defaults['document_color']:'#000000' ),
				),
				'message_description' => array(
					'type' => 'color',
					'label' => __( 'Content', 'ub' ),
					'accordion' => array(
						'end' => true,
					),
					'default' => esc_attr( isset( $defaults['document_background'] )? $defaults['document_background']:'#888888' ),
				),
			);
			/**
			 * Allow to change fields.
			 *
			 * @since 3.0.0
			 *
			 * @param array $data Options data.
			 * @param array $defaults Default values from function.
			 * @param string Current module name.
			 */
			return apply_filters( 'branda_'.__FUNCTION__, $data, $defaults, $this->module );
		}
	}
}
new Branda_Site_Status_Pages;