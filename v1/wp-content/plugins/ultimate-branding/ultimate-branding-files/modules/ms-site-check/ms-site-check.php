<?php
if ( ! class_exists( 'ub_ms_site_check' ) ) {

	class ub_ms_site_check extends ub_helper {
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
			$this->module = 'ms_site_check';
			$this->set_options();
			/**
			 * hooks
			 */
			add_action( 'ultimatebranding_settings_ms_site_check', array( $this, 'admin_options_page' ) );
			if ( $this->is_ready ) {
				add_filter( 'ultimatebranding_settings_ms_site_check_process', array( $this, 'update' ), 10, 1 );
				add_filter( 'ultimatebranding_settings_ms_site_check_process', array( $this, 'update_files' ), 999, 1 );
			}
			/**
			 * add related config
			 *
			 * @since 2.3.0
			 */
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_background' ) );
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_logo' ) );
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_social_media_settings' ) );
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_social_media' ) );
		}

		/**
		 * Create or update `wp-content/blog-?.php` is possible.
		 *
		 * @since 2.0.0
		 */
		public function update_files( $state ) {
			/**
			 * set data
			 */
			$template_master = $this->get_template();
			$classes = array( 'ultimate-branding-settings-ms-site-check' );
			$this->set_data();
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
					$url = $this->get_value( 'logo', 'url' );
					if ( ! empty( $url ) ) {
						$alt = $this->get_value( 'logo', 'alt', '' );
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
				 * page
				 */
				$css .= $this->css_background_transparency( 'document', 'background', 'background_transparency', '.page', false );
				$v = $this->get_value( 'document' );
				$css .= $this->css_color_from_data( 'document', 'color', '.page', false );
				$css .= '.page{';
				if ( isset( $v['width'] ) && ! empty( $v['width'] ) ) {
					$css .= $this->css_width( $v['width'] );
				} else {
					$css .= $this->css_width( 100, '%' );
				}
				$css .= '}';
				/**
				 * Common Background
				 *
				 * @since 2.3.0
				 */
				ob_start();
				$this->css_background_common();
				$head .= ob_get_contents();
				ob_end_flush();
				/**
				 * replace
				 */
				foreach ( $this->data as $section => $data ) {
					foreach ( $data as $name => $value ) {
						if ( empty( $value ) ) {
							$value = '';
						}
						if ( ! is_string( $value ) ) {
							$value = '';
						}
						if ( ! empty( $value ) ) {
							switch ( $section ) {
								case 'document_deleted':
									//case 'document_inactive':
								case 'document_suspended':
									switch ( $name ) {
										case 'title':
											$value = sprintf( '<h1>%s</h1>', esc_html( $value ) );
										break;
										case 'content_meta':
											$show = $this->get_value( $section, 'content_show' );
											if ( 'off' === $show ) {
												$value = '';
											} else {
												$value = sprintf( '<div class="content">%s</div>', $value );
											}
										break;
									}
								break;
							}
						}
						$re = sprintf( '/{%s_%s}/', $section, $name );
						$template = preg_replace( $re, stripcslashes( $value ), $template );
						if ( 9 === strpos( $section, $slug ) ) {
							$s = preg_replace( '/_(inactive|suspended|deleted)$/', '', $section );
							$re = sprintf( '/{%s_%s}/', $s, $name );
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
				$head .= $this->enqueue( 'ms-site-check.css' );
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
				 * write
				 */
				$result = file_put_contents( $file, $template );
			}
			return $state;
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
					'title' => __( 'Use', 'ub' ),
					'fields' => array(
						'suspended' => array(
							'type' => 'checkbox',
							'label' => __( 'Suspended', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'suspended',
						),
						'deleted' => array(
							'type' => 'checkbox',
							'label' => __( 'Deleted', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'deleted',
						),
					),
				),
				/**
				 * suspended
				 */
				'document_suspended' => array(
					'title' => __( 'Suspended', 'ub' ),
					'master' => array(
						'section' => 'show',
						'field' => 'suspended',
						'value' => 'on',
					),
					'fields' => array(
						'title' => array(
							'label' => __( 'Title', 'ub' ),
							'description' => __( 'Enter a headline for your page.', 'ub' ),
							'default' => __( 'This site has been archived or suspended.', 'ub' ),
							'master' => 'title',
						),
						'content_show' => array(
							'type' => 'checkbox',
							'label' => __( 'Show Content', 'ub' ),
							'description' => __( 'Would you like to show content?', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'content-suspended',
						),
						'content' => array(
							'type' => 'wp_editor',
							'label' => __( 'Content', 'ub' ),
							'master' => 'content-suspended',
						),
					),
				),
				/**
				 * deleted
				 */
				'document_deleted' => array(
					'title' => __( 'Deleted', 'ub' ),
					'master' => array(
						'section' => 'show',
						'field' => 'deleted',
						'value' => 'on',
					),
					'fields' => array(
						'title' => array(
							'label' => __( 'Title', 'ub' ),
							'description' => __( 'Enter a headline for your page.', 'ub' ),
							'default' => __( 'This site is no longer available.', 'ub' ),
							'master' => 'title',
						),
						'content_show' => array(
							'type' => 'checkbox',
							'label' => __( 'Show Content', 'ub' ),
							'description' => __( 'Would you like to show content?', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'content-deleted',
						),
						'content' => array(
							'type' => 'wp_editor',
							'label' => __( 'Content', 'ub' ),
							'master' => 'content-deleted',
						),
					),
				),
				'document' => array(
					'title' => __( 'Document settings', 'ub' ),
					'fields' => array(
						'color' => array(
							'type' => 'color',
							'label' => __( 'Color', 'ub' ),
							'default' => '#000000',
						),
						'background' => array(
							'type' => 'color',
							'label' => __( 'Background Color', 'ub' ),
							'default' => '#f1f1f1',
						),
						'background_transparency' => array(
							'type' => 'number',
							'label' => __( 'Background Transparency', 'ub' ),
							'min' => 0,
							'max' => 100,
							'default' => 0,
							'classes' => array( 'ui-slider' ),
							'after' => '%',
						),
						'width' => array(
							'type' => 'number',
							'label' => __( 'Width', 'ub' ),
							'default' => 600,
							'min' => 0,
							'max' => 2000,
							'classes' => array( 'ui-slider' ),
						),
					),
				),
				/**
				 * Common: Logo
				 */
				'logo' => $this->get_options_logo(
					array(
						'url' => '',
						'alt' => '',
						'margin_bottom' => 0,
					)
				),
				/**
				 * Common: Background
				 */
				'background' => $this->get_options_background(),
				/**
				 * Common: Social Media Settings
				 */
				'social_media_settings' => $this->get_options_social_media_settings(),
				'social_media' => $this->get_options_social_media(),
			);
			$this->options = $options;
		}
	}
}
new ub_ms_site_check();
