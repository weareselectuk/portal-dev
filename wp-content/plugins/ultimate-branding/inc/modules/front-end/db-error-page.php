<?php
/**
 * Class that handles DB error page.
 *
 * @package Branda
 * @subpackage DB Error Page
 */

if ( ! class_exists( 'Branda_DB_Error_Page' ) ) {

	/**
	 * Class Branda_DB_Error_Page
	 */
	class Branda_DB_Error_Page extends Branda_Helper {

		/**
		 * Module option name.
		 *
		 * @var string
		 */
		protected $option_name = 'ub_db_error_page';

		/**
		 * Is module ready?
		 *
		 * @var bool
		 */
		private $is_ready = false;

		/**
		 * Is directory ready?
		 *
		 * @var bool
		 */
		private $is_ready_dir = false;

		/**
		 * Is the file ready?
		 *
		 * @var bool
		 */
		private $is_ready_file = false;

		/**
		 * Error display file.
		 *
		 * @var string
		 */
		private $db_error_file;

		/**
		 * DB error directory.
		 *
		 * @var string
		 */
		private $db_error_dir;

		/**
		 * Current file.
		 *
		 * @var string
		 */
		protected $file = __FILE__;

		/**
		 * Branda_DB_Error_Page constructor.
		 */
		public function __construct() {
			parent::__construct();
			// Check if files and directories are writable.
			$this->check();
			$this->set_options();
			// Register hooks for module.
			add_filter( 'ultimatebranding_settings_db_error_page', array( $this, 'admin_options_page' ) );
			// If module ready, register hooks.
			if ( $this->is_ready ) {
				add_filter( 'ultimatebranding_settings_db_error_page_process', array( $this, 'update' ) );
			}
			/**
			 * Regenerate `db-error.php` file after value update.
			 *
			 * @since 3.1.0
			 */
			add_action( 'update_option_'.$this->option_name, array( $this, 'update_option_action' ), 10, 3 );
			add_action( 'update_site_option_'.$this->option_name, array( $this, 'update_site_option_action' ), 10, 4 );
			/**
			 * Add related config.
			 *
			 * @since 2.3.0
			 */
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_background' ) );
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_logo' ) );
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_social_media_settings' ) );
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_social_media' ) );
			add_action( 'init', array( $this, 'upgrade_options' ) );
			add_filter( 'ultimatebranding_settings_db_error_page_preserve', array( $this, 'add_preserve_fields' ) );
		}

		/**
		 * Upgrade options to new structure.
		 *
		 * @since 3.0.0
		 */
		public function upgrade_options() {
			$value = $this->get_value();
			if ( empty( $value ) ) {
				return;
			}
			if ( isset( $value['design'] ) ) {
				return;
			}
			if ( isset( $value['plugin_version'] ) ) {
				return;
			}
			// Get default options.
			$data = $this->get_default_options();
			// Document.
			if ( isset( $value['document'] ) ) {
				$v = $value['document'];
				if ( isset( $v['title'] ) ) {
					$data['content']['content_title'] = $v['title'];
				}
				if ( isset( $v['content'] ) ) {
					$data['content']['content_content'] = $v['content'];
					if ( isset( $v['content_meta'] ) ) {
						$data['content']['content_content_meta'] = $v['content_meta'];
					}
				}
				if ( isset( $v['color'] ) ) {
					$data['colors']['document_color'] = $v['color'];
				}
				if ( isset( $v['background'] ) ) {
					$data['colors']['document_background'] = $v['background'];
				}
				if ( isset( $v['width'] ) ) {
					$data['design']['document_width'] = $v['width'];
				}
			}
			// Logo.
			if ( isset( $value['logo'] ) ) {
				$v = $value['logo'];
				if ( isset( $v['show'] ) ) {
					$data['content']['logo_show'] = $v['show'];
				}
				if ( isset( $v['url'] ) ) {
					$data['content']['logo_url'] = $v['url'];
				}
				if ( isset( $v['alt'] ) ) {
					$data['content']['logo_alt'] = $v['alt'];
				}
				if ( isset( $v['image'] ) ) {
					$data['content']['logo_image'] = $v['image'];
					if ( isset( $v['image_meta'] ) ) {
						$data['content']['logo_image_meta'] = $v['image_meta'];
					}
				}
				if ( isset( $v['width'] ) ) {
					$data['design']['logo_width'] = $v['width'];
				}
				if ( isset( $v['position'] ) ) {
					$data['design']['logo_position'] = $v['position'];
				}
				if ( isset( $v['transparency'] ) ) {
					$data['design']['logo_opacity'] = $v['transparency'];
				}
				if ( isset( $v['rounded'] ) ) {
					$data['design']['logo_rounded'] = $v['rounded'];
				}
				if ( isset( $v['margin_bottom'] ) ) {
					$data['design']['logo_margin_bottom'] = $v['margin_bottom'];
				}
			}
			// Background.
			if ( isset( $value['background'] ) ) {
				$v = $value['background'];
				if ( isset( $v['image'] ) ) {
					$data['content']['content_background'] = $v['image'];
				}
				if ( isset( $v['color'] ) ) {
					$data['colors']['document_background'] = $v['color'];
				}
				if ( isset( $v['mode'] ) ) {
					$data['design']['background_mode'] = $v['mode'];
				}
				if ( isset( $v['duration'] ) ) {
					$data['design']['background_duration'] = $v['duration'];
				}
			}
			// Email.
			if ( isset( $value['mail'] ) ) {
				$data['mail'] = $value['mail'];
			}
			// Social_media_settings.
			if ( isset( $value['social_media_settings'] ) ) {
				$v = $value['social_media_settings'];
				if ( isset( $v['colors'] ) ) {
					$data['design']['social_media_colors'] = 'on' === $v['colors'] ? 'color' : 'monochrome';
				}
				if ( isset( $v['social_media_link_in_new_tab'] ) ) {
					$data['design']['social_media_target'] = 'on' === $v['social_media_link_in_new_tab'] ? '_blank' : '_self';
				}
			}
			// Social_media.
			if ( isset( $value['social_media'] ) && is_array( $value['social_media'] ) ) {
				foreach ( $value['social_media'] as $key => $v ) {
					$data['content'][ 'social_media_' . $key ] = $v;
				}
			}
			/**
			 * Social Media order.
			 */
			if ( isset( $value['_social_media_sortable'] ) ) {
				$data['settings'] = array(
					'social_media_order' => $value['_social_media_sortable'],
				);
			}
			$this->update_value( $data );
		}

		/**
		 * Add settings sections to prevent delete on save.
		 *
		 * Add settings sections (virtual options not included in
		 * "set_options()" function to avoid delete during update.
		 *
		 * @since 3.0.0
		 */
		public function add_preserve_fields() {
			return array(
				'settings' => array(
					'social_media_order',
				),
			);
		}

		/**
		 * Regenerate file after value update for single site.
		 *
		 * @since 3.1.0
		 */
		public function update_option_action( $old_value, $value, $option_name ) {
			$this->update_file( $value );
		}

		/**
		 * Regenerate file after value update for multisite.
		 *
		 * @since 3.1.0
		 */
		public function update_site_option_action( $option_name, $value, $old_value, $network_id ) {
			$this->update_file( $value );
		}

		/**
		 * Create or update `wp-content/db-error.php` is possible.
		 *
		 * @param bool $state Current state.
		 *
		 * @since 2.0.0
		 *
		 * @return bool
		 */
		private function update_file( $value ) {
			$this->data = $value;
			$javascript = $php = $css = $head = $logo = '';
			// Set data.
			$template = $this->get_template();
			$body_classes = array( 'ultimate-branding-settings-db-error-page' );
			/**
			 * Title
			 */
			$title = $this->get_value( 'content', 'content_title', null );
			if ( empty( $title ) ) {
				$title = __( 'We&rsquo;ll be back soon!', 'ub' );
			}
			/**
			 * Content
			 */
			$content = $this->get_value( 'content', 'content_content_meta', null );
			if ( empty( $content ) ) {
				$content = $this->get_value( 'content', 'content_content', null );
			}
			if ( empty( $content ) ) {
				$content = wpautop( __( 'We\'re currently experiencing technical issues &mdash; Please check back soon...', 'ub' ) );	  			   			   	 	 	
			}
			$content = $this->html_background_common( false ) . $content;
			// Template.
			$php = '<?php';
			$php .= PHP_EOL;
			$php .= 'header(\'HTTP/1.1 503 Service Temporarily Unavailable\');';
			$php .= PHP_EOL;
			$php .= 'header(\'Status: 503 Service Temporarily Unavailable\');';
			$php .= PHP_EOL;
			$php .= 'header(\'Retry-After: 3600\');';
			$php .= PHP_EOL;
			$send_email = $this->get_value( 'mail', 'send' );
			if ( 'on' === $send_email ) {
				$email = $this->get_value( 'mail', 'to' );
				if ( ! empty( $email ) ) {
					$mail_content = esc_html__( 'There is a problem with the database!', 'ub' );
					$mail_content .= PHP_EOL;
					$mail_content .= PHP_EOL;
					$mail_content .= sprintf( _x( 'Site URL: %s', 'DB Error module: mail', 'ub' ), home_url() );
					$mail_content .= PHP_EOL;
					$mail_content .= sprintf( _x( 'Site Name: %s', 'DB Error module: mail', 'ub' ), get_bloginfo( 'name' ) );
					$php .= sprintf(
						"mail('%s', '%s', '%s', 'From: \"%s\" <%s>');",
						esc_attr( $email ),
						esc_html__( 'Database Error', 'ub' ),
						$mail_content,
						apply_filters( 'wp_mail_from_name', get_bloginfo( 'name' ) ),
						apply_filters( 'wp_mail_from', get_bloginfo( 'admin_email' ) )
					);
					$php .= PHP_EOL;
				}
			}
			$php .= '?>';
			// Common: Logo.
			$logo = '';
			ob_start();
			$this->css_logo_common( '#logo' );
			$logo_css = ob_get_contents();
			ob_end_clean();
			if ( ! empty( $logo_css ) ) {
				$logo = '<div id="logo">';
				$url = $this->get_value( 'content', 'logo_url' );
				if ( empty( $url ) ) {
					$logo_css = preg_replace( '/#logo a/', '#logo', $logo_css );
				} else {
					$alt = $this->get_value( 'content', 'logo_alt', '' );
					$logo .= sprintf(
						'<a href="%s" title="%s">%s</a>',
						esc_url( $url ),
						esc_attr( $alt ),
						esc_html( $alt )
					);
				}
				$logo .= '</div>';
				$css .= $logo_css;
			}
			// Common: Social Media.
			$result = $this->common_options_social_media();
			$social_media = $result['social_media'];
			$body_classes = array_merge( $body_classes, $result['body_classes'] );
			$head .= $result['head'];
			// Page.
			$css .= '.page{';
			$value = $this->get_value( 'colors', 'content_background' );
			$css .= $this->css_background_color( $value );
			$value = $this->get_value( 'design', 'content_width', false );
			$units = $this->get_value( 'design', 'content_width_units', 'px' );
			$css .= $this->css_width( $value, $units );
			$value = $this->get_value( 'design', 'content_radius' );
			$css .= $this->css_radius( $value );
			$css .= '}';
			// Page Content: title.
			$css .= '.page h1 {';
			$value = $this->get_value( 'colors', 'content_title' );
			$css .= $this->css_color( $value );
			$css .= '}';
			// Page Content: content.
			$css .= '.page .content {';
			$value = $this->get_value( 'colors', 'content_content' );
			$css .= $this->css_color( $value );
			/**
			 * Text align
			 */
			$value = $this->get_value( 'design', 'text_aligment', false );
			if ( ! empty( $value ) ) {
				$css .= sprintf( 'text-align:%s', $value );
			}
			$css .= '}';
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
			 * Common Background
			 *
			 * @since 2.3.0
			 */
			ob_start();
			$this->css_background_common();
			$head .= ob_get_contents();
			ob_end_flush();
			$head .= $this->enqueue( 'css/db-error-page.css' );
			$args = array(
				'language' => get_bloginfo( 'language' ),
				'title' => $title,
				'content' => $content,
				'social_media' => $social_media,
				'body_class' => implode( ' ', $body_classes ),
				'head' => $head,
				'logo' => $logo,
				'css' => $css,
				'php' => $php,
				'javascript' => $javascript,
			);
			$template = '/admin/modules/db-error-page/template';
			$template = $this->render( $template, $args, true );
			$result = file_put_contents( $this->db_error_file, $template );
		}

		/**
		 * Check that create od file is possible.
		 *
		 * @since 2.0.0
		 */
		private function check() {
			$this->db_error_dir = dirname( get_theme_root() );
			$this->db_error_file = $this->db_error_dir . '/db-error.php';
			if ( ! is_dir( $this->db_error_dir ) || ! is_writable( $this->db_error_dir ) ) {
				return;
			}
			$this->is_ready_dir = true;
			if ( is_file( $this->db_error_file ) && ! is_writable( $this->db_error_file ) ) {
				return;
			}
			$this->is_ready_file = true;
			$this->is_ready = true;
		}

		/**
		 * Set options for the admin page.
		 *
		 * @since 2.0.0
		 */
		protected function set_options() {
			$this->module = 'db-error-page';
			if ( ! $this->is_ready ) {
				$uba = ub_get_uba_object();
				$value = __( 'Whoops! Something went wrong.', 'ub' );
				if ( false == $this->is_ready_dir ) {
					$value = sprintf(
						__( 'Directory %s is not writable, we are unable to create db-error.php file.', 'ub' ),
						sprintf( '<code>%s</code>', $this->db_error_dir )
					);
				} else if ( false === $this->is_ready_file ) {
					$value = sprintf(
						__( 'File %s is not writable, we are unable to change it.', 'ub' ),
						sprintf( '<code>%s</code>', $this->db_error_file )
					);
				}
				$options = array(
					'settings' => array(
						'fields' => array(
							'message' => array(
								'hide-th' => true,
								'type' => 'description',
								'value' => $uba->get_inline_sui_notice( $value, 'error' ),
							),
						),
					),
				);
				$this->options = $options;
				return;
			}
			// Defaults.
			$defaults = array(
				'error_message' => array(
					'content_title' => __( '503 Service Temporarily Unavailable', 'ub' ),
					'content_content' => wpautop( __( 'We\'re currently experiencing technical issues connecting to the database. Please check back soon.', 'ub' ) ),
				),
			);
			$current_user = wp_get_current_user();
			// Options.
			$options = array(
				'preview' => array(
					'title' => __( 'Preview', 'ub' ),
					'description' => __( 'You can preview your custom error page here. Note that the preview keeps updating as you save your changes.', 'ub' ),
					'fields' => array(
						'preview' => array(
							'type' => 'link',
							'href' => content_url( 'db-error.php' ),
							'value' => __( 'Preview', 'ub' ),
							'icon' => 'eye',
							'classes' => array(
								'sui-button',
								$this->get_name( 'preview' ),
							),
							'target' => $this->get_name( 'preview' ),
						),
					),
				),
				'content' => array(
					'title' => __( 'Content', 'ub' ),
					'description' => __( 'Choose the behaviour when a visitor encounters DB Error while browsing your website.', 'ub' ),
					'show-as' => 'accordion',
					'fields' => $this->get_options_fields(
						'content',
						array( 'logo', 'error_message', 'social', 'reset' ),
						$defaults
					),
				),
				'design' => array(
					'title' => __( 'Design', 'ub' ),
					'description' => __( 'Customize the design of each element of your DB Error screen.', 'ub' ),
					'show-as' => 'accordion',
					'fields' => $this->get_options_fields(
						'design',
						array( 'logo', 'background', 'error_message', 'social', 'document', 'reset' )
					),
				),
				'colors' => array(
					'title' => __( 'Colors', 'ub' ),
					'description' => __( 'Adjust the default colour combinations as per your liking.', 'ub' ),
					'show-as' => 'accordion',
					'fields' => $this->get_options_fields(
						'colors',
						array( 'logo', 'error_message', 'document', 'reset' )
					),
				),
				/**
				 * Custom CSS
				 *
				 * @since 3.0.0
				 */
				'css' => $this->get_custom_css_array(
					array(
						'ace_selectors' => $this->get_ace_selectors(),
					)
				),
				/**
				 * Settings
				 */
				'mail' => array(
					'title' => __( 'Behaviour', 'ub' ),
					'description' => __( 'Choose the behaviour when a visitor encounters DB Error while browsing your website.', 'ub' ),
					'fields' => array(
						'to' => array(
							'label' => __( 'Email address', 'ub' ),
							'display' => 'sui-tab-content',
							'master' => $this->get_name( 'send' ),
							'master-value' => 'on',
							'default' => $current_user->user_email,
						),
						'send' => array(
							'type' => 'sui-tab',
							'label' => __( 'Send alert email', 'ub' ),
							'description' => __( 'Send an alert email regarding the occurrence of db error on the website.', 'ub' ),
							'options' => array(
								'off' => __( 'Disable', 'ub' ),
								'on' => __( 'Enable', 'ub' ),
							),
							'default' => 'off',
							'slave-class' => $this->get_name( 'send' ),
						),
					),
				),
			);
			/**
			 * Check db-error.php exists
			 */

			$file = WP_CONTENT_DIR . '/db-error.php';
			if ( ! is_file( $file ) || ! is_readable( $file ) ) {
				$options['preview']['fields']['preview'] = array(
					'type' => 'description',
					'value' => __( 'Preview is not availability. Save settings first!', 'ub' ),
					'classes' => array(
						'sui-notice',
						'inline',
					),
				);
			}
			$this->options = $options;
		}

		/**
		 * Options: Design -> Error Message.
		 *
		 * @param array $defaults Default values.
		 *
		 * @since 3.0.0
		 *
		 * @return array
		 */
		public function get_options_fields_design_error_message( $defaults = array() ) {
			$data = array(
				'text_aligment' => array(
					'type' => 'sui-tab-icon',
					'label' => __( 'Title text alignment', 'ub' ),
					'options' => array(
						'left' => 'align-left',
						'center' => 'align-center',
						'right' => 'align-right',
					),
					'default' => is_rtl() ? 'right' : 'left',
					'accordion' => array(
						'begin' => true,
						'title' => __( 'Error Message', 'ub' ),
						'end' => true,
					),
					'group' => array(
						'begin' => true,
						'end' => true,
					),
				),
			);
			/**
			 * Allow to change content logo fields.
			 *
			 * @since 3.0.0
			 *
			 * @param array  $data logo options data.
			 * @param array  $defaults Default values from function.
			 * @param string $this->module Current module name.
			 */
			return apply_filters( 'branda_' . __FUNCTION__, $data, $defaults, $this->module );
		}

		/**
		 * Options: Colors -> Error Message.
		 *
		 * @param array $defaults Default values.
		 *
		 * @since 3.0.0
		 *
		 * @return array
		 */
		public function get_options_fields_colors_error_message( $defaults = array() ) {
			$data = array(
				'content_title' => array(
					'type' => 'color',
					'label' => __( 'Title', 'ub' ),
					'default' => '#000',
					'accordion' => array(
						'begin' => true,
						'title' => __( 'Error Message', 'ub' ),
					),
					'group' => array(
						'begin' => true,
					),
				),
				'content_content' => array(
					'type' => 'color',
					'label' => __( 'Description', 'ub' ),
					'default' => '#888',
					'accordion' => array(
						'end' => true,
					),
					'group' => array(
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
			return apply_filters( 'branda_' . __FUNCTION__, $data, $defaults, $this->module );
		}

		/**
		 * Get ACE editor buttons
		 *
		 * @since 3.0.0
		 */
		private function get_ace_selectors() {
			$selectors = array(
				'general' => array(
						'selectors' => array(
							'.overall' => __( 'Overall', 'ub' ),
							'.page' => __( 'Page', 'ub' ),
							'.content' => __( 'Content', 'ub' ),
							'#social' => __( 'Social Media', 'ub' ),
							'#logo' => __( 'Logo', 'ub' ),
						),
				),
			);
			return $selectors;
		}
	}
}
new Branda_DB_Error_Page;