<?php
if ( ! class_exists( 'ub_db_error_page' ) ) {

	class ub_db_error_page extends ub_helper {
		protected $option_name = 'ub_db_error_page';
		private $is_ready = false;
		private $is_ready_dir = false;
		private $is_ready_file = false;
		private $db_error_file;
		private $db_error_dir;
		protected $file = __FILE__;

		public function __construct() {
			parent::__construct();
			$this->check();
			$this->module = 'db_error_page';
			$this->set_options();
			/**
			 * hooks
			 */
			add_action( 'ultimatebranding_settings_db_error_page', array( $this, 'admin_options_page' ) );
			if ( $this->is_ready ) {
				add_filter( 'ultimatebranding_settings_db_error_page_process', array( $this, 'update' ), 10, 1 );
				add_filter( 'ultimatebranding_settings_db_error_page_process', array( $this, 'update_file' ), 999, 1 );
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
		 * Create or update `wp-content/db-error.php` is possible.
		 *
		 * @since 2.0.0
		 */
		public function update_file( $state ) {
			/**
			 * set data
			 */
			$template = $this->get_template();
			$body_classes = array( 'ultimate-branding-settings-db-error-page' );
			$javascript = $php = $css = $head = $logo = '';
			$this->set_data();
			/**
			 * Add defaults.
			 */
			if ( empty( $this->data['document']['title'] ) && empty( $this->data['document']['content'] ) ) {
				$this->data['document']['title'] = __( 'We&rsquo;ll be back soon!', 'ub' );
				$this->data['document']['content'] = wpautop( __( 'We\'re currently experiencing technical issues &mdash; Please check back soon...', 'ub' ) );
				$this->data['document']['content_meta'] = $this->data['document']['content'];
			}
			/**
			 * template
			 */
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
						'mail("%s", "%s", "%s", "From: %s");',
						esc_attr( $email ),
						esc_html__( 'Database Error', 'ub' ),
						$mail_content,
						get_bloginfo( 'name' )
					);
					$php .= PHP_EOL;
				}
			}
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
			/**
			 * Common: Document
			 */
			$css .= $this->common_css_document();
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
							case 'document':
								switch ( $name ) {
									case 'title':
										$show = $this->get_value( 'document', 'title_show' );
										if ( 'off' === $show ) {
											$value = '';
										} else {
											$value = sprintf( '<h1>%s</h1>', esc_html( $value ) );
										}
									break;
									case 'content_meta':
										$show = $this->get_value( 'document', 'content_show' );
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
				}
			}
			$template = preg_replace( '/{language}/', get_bloginfo( 'language' ), $template );
			$template = preg_replace( '/{social_media}/', $social_media, $template );
			$template = preg_replace( '/{title}/', get_bloginfo( 'name' ), $template );
			/**
			 * body classes
			 */
			$template = preg_replace( '/{body_class}/', implode( $body_classes, ' ' ), $template );
			/**
			 * head
			 */
			$head .= $this->enqueue( 'db-error-page.css' );
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
			$result = file_put_contents( $this->db_error_file, $template );
			if ( false === $result ) {
				return $result;
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
			if ( is_file( $this->db_error_file ) && ! is_writable( $this->db_error_file ) ) {
				return;
			}
			$this->is_ready_file = true;
			$this->is_ready = true;
		}

		/**
		 * Set options
		 *
		 * @since 2.0.0
		 */
		protected function set_options() {
			$this->module = 'db-error-page';
			if ( ! $this->is_ready ) {
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
						'hide-reset' => true,
						'title' => __( 'DB Error Page', 'ub' ),
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
				/**
				 * Common: Document
				 */
				'document' => $this->common_options_document(
					array(
						'fields' => array(
							'title' => array(
								'default' => __( '503 Service Temporarily Unavailable', 'ub' ),
							),
							'content' => array(
								'default' => wpautop( __( 'We\'re currently experiencing technical issues &mdash; Please check back soon...', 'ub' ) ),
							),
						),
					)
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
				'background' => $this->get_options_background( array( 'color' => '#210101' ) ),
				/**
				 * settings
				 */
				'mail' => array(
					'title' => __( 'Send Mail Settings', 'ub' ),
					'fields' => array(
						'send' => array(
							'type' => 'checkbox',
							'label' => __( 'Send Mail?', 'ub' ),
							'description' => __( 'Try to send mail when somebody enter a site and a db problem is occured.', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'send',
						),
						'to' => array(
							'label' => __( 'To', 'ub' ),
							'master' => 'send',
						),
					),
				),
				/**
				 * Common: Social Media Settings
				 */
				'social_media_settings' => $this->get_options_social_media_settings(),
				'social_media' => $this->get_options_social_media(),
				/**
				'delete' => array(
					'title' => __( 'Delete', 'ub' ),
					'hide-reset' => true,
					'fields' => array(
						'send' => array(
							'type' => 'button',
							'value' => __( 'Delete custom page', 'ub' ),
							'data' => array(
								'nonce' => wp_create_nonce( $this->module ),
							),
						),
					),
				),
				 */
			);
			$this->options = $options;
		}
	}
}
new ub_db_error_page();
