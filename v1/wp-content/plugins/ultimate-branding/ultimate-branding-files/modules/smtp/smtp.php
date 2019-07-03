<?php
if ( ! class_exists( 'ub_smtp' ) ) {

	class ub_smtp extends ub_helper {
		protected $option_name = 'ub_smtp';
		private $is_ready = false;

		public function __construct() {
			parent::__construct();
			$this->check();
			$this->module = 'smtp';
			$this->set_options();
			/**
			 * hooks
			 */
			add_action( 'admin_notices', array( $this, 'configure_credentials_notice' ) );
			add_action( 'phpmailer_init', array( $this, 'init_smtp' ), 999 );
			add_action( 'ultimatebranding_settings_smtp', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_smtp_process', array( $this, 'update' ), 10, 1 );
			add_action( 'wp_ajax_ultimatebranding_smtp_test_email', array( $this, 'send_test_mail' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * enqueue_scripts
		 *
		 * @since 2.0.0
		 */
		public function enqueue_scripts() {
			$tab = get_query_var( 'ultimate_branding_tab' );
			if ( $this->module != $tab ) {
				return;
			}
			/**
			 * module js
			 */
			$file = ub_files_url( 'modules/smtp/assets/js/smtp-admin.js' );
			wp_register_script( __CLASS__, $file, array( 'jquery' ), $this->build, true );
			$localize = array(
				'messages' => array(
					'empty_smtp_to' => __( 'Field "To" can not be empty!', 'ub' ),
					'sending' => __( 'Sending message, please wait...', 'ub' ),
					'send' => __( 'The test message was send successful.', 'ub' ),
				),
			);
			wp_localize_script( __CLASS__, __CLASS__, $localize );
			wp_enqueue_script( __CLASS__ );
		}

		/**
		 * Send test email
		 *
		 * @since 2.0.0
		 */
		public function send_test_mail() {
			if ( ! isset( $_REQUEST['nonce'] ) || wp_verify_nonce( $_REQUEST['nonce'], __CLASS__ ) ) {
				wp_send_json_error( __( 'Security check fails.', 'ub' ) );
			}
			if ( is_wp_error( $this->is_ready ) ) {
				wp_send_json_error( $this->is_ready->get_error_message() );
			}
			if ( ! isset( $_REQUEST['to'] ) || empty( $_REQUEST['to'] ) ) {
				wp_send_json_error( __( 'You must provide at least one recipient email address.', 'ub' ) );
			}
			$to_email = sanitize_email( $_REQUEST['to'] );
			if ( ! is_email( $to_email ) ) {
				wp_send_json_error( __( 'You must provide valid email address.', 'ub' ) );
			}
			$errors = '';
			$config = $this->get_value();
			require_once( ABSPATH . WPINC . '/class-phpmailer.php' );
			$mail = new PHPMailer();
			$charset  = get_bloginfo( 'charset' );
			$mail->CharSet  = $charset;
			$from_name  = $this->get_value( 'settings', 'from_name' );
			$from_email  = $this->get_value( 'settings', 'from_email' );
			$mail->IsSMTP();
			// send plain text test email
			$mail->ContentType = 'text/plain';
			$mail->IsHTML( false );
			/* If using smtp auth, set the username & password */
			$use_auth = $this->get_value( 'settings', 'smtp_authentication' );
			if ( 'on' === $use_auth ) {
				$mail->SMTPAuth  = true;
				$mail->Username  = $this->get_value( 'settings', 'smtp_username' );
				$mail->Password  = $this->get_value( 'settings', 'smtp_password' );
			}
			/* Set the SMTPSecure value, if set to none, leave this blank */
			$type = $this->get_value( 'settings', 'smtp_type_encryption' );
			if ( 'none' !== $type ) {
				$mail->SMTPSecure = $type;
			}
			/* PHPMailer 5.2.10 introduced this option. However, this might cause issues if the server is advertising TLS with an invalid certificate. */
			$mail->SMTPAutoTLS = false;
			$insecure_ssl = $this->get_value( 'settings', 'smtp_insecure_ssl' );
			if ( 'on' === $insecure_ssl ) {
				// Insecure SSL option enabled
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer'   => false,
						'verify_peer_name'  => false,
						'allow_self_signed'  => true,
					),
				);
			}
			/* Set the other options */
			$mail->Host  = $this->get_value( 'settings', 'smtp_host' );
			$mail->Port  = $this->get_value( 'settings', 'smtp_port' );
			$mail->SetFrom( $from_email, $from_name );
			//This should set Return-Path header for servers that are not properly handling it, but needs testing first
			//$mail->Sender   = $mail->From;
			$mail->Subject   = sprintf( __( 'This is test email sent from "%s"', 'ub' ), get_bloginfo( 'name' ) );
			$mail->Body   = __( 'This is a test mail...', 'ub' );
			$mail->Body .= PHP_EOL;
			$mail->Body .= PHP_EOL;
			$mail->Body .= sprintf( __( 'Send date: %s.', 'ub' ), date( 'c' ) );
			$mail->Body .= PHP_EOL;
			$mail->Body .= PHP_EOL;
			$mail->Body .= '-- ';
			$mail->Body .= PHP_EOL;
			$mail->Body .= sprintf( __( 'Site: %s.', 'ub' ), get_bloginfo( 'url' ) );
			$mail->AddAddress( $to_email );
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				$mail->SMTPDebug = 1;
				ob_start();
			}
			/* Send mail and return result */
			if ( ! $mail->Send() ) {
				$errors = $mail->ErrorInfo;
			}
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				$debug = ob_get_contents();
				ob_end_clean();
				error_log( $debug );
			}
			$mail->ClearAddresses();
			$mail->ClearAllRecipients();
			if ( ! empty( $errors ) ) {
				wp_send_json_error( $errors );
			}
			wp_send_json_success( __( 'Test mail was sent.', 'ub' ) );
		}

		/**
		 * Check required credentials
		 *
		 * @since 2.0.0
		 */
		private function check() {
			$this->is_ready = new WP_Error( 'credentials', __( 'Please configure credentials first.', 'ub' ) );
			$config = $this->get_value();
			if ( empty( $config ) ) {
				return $this->is_ready;
			}
			if ( ! isset( $config['settings'] ) ) {
				return $this->is_ready;
			}
			$config = $config['settings'];
			if ( ! isset( $config['from_email'] ) || empty( $config['from_email'] ) ) {
				return $this->is_ready;
			}
			$this->is_ready = true;
			return $this->is_ready;
		}

		/**
		 * Init SMTP
		 *
		 * @since 2.0.0
		 */
		public function init_smtp( &$phpmailer ) {
			/**
			 * check if SMTP credentials have been configured.
			 */
			if ( is_wp_error( $this->is_ready ) ) {
				return $this->is_ready->get_error_message();
			}
			/* Set the mailer type as per config above, this overrides the already called isMail method */
			$phpmailer->IsSMTP();
			/**
			 * from name
			 */
			$from_name = $this->get_value( 'settings', 'from_name' );
			$force = $this->get_value( 'settings', 'from_name_force' );
			if ( 'off' === $force && ! empty( $phpmailer->FromName ) ) {
				$from_name = $phpmailer->FromName;
			}
			/**
			 * from email
			 */
			$from_email = $this->get_value( 'settings', 'from_email' );
			/**
			 * set PHPMailer
			 */
			$phpmailer->From  = $from_email;
			$phpmailer->FromName  = $from_name;
			$phpmailer->SetFrom( $phpmailer->From, $phpmailer->FromName );
			/* Set the SMTPSecure value */
			$type = $this->get_value( 'settings', 'smtp_type_encryption' );
			if ( 'none' !== $type  ) {
				$phpmailer->SMTPSecure = $type;
			}
			/* Set the other options */
			$phpmailer->Host  = $this->get_value( 'settings', 'smtp_host' );
			$phpmailer->Port  = $this->get_value( 'settings', 'smtp_port' );
			/* If we're using smtp auth, set the username & password */
			$use_auth = $this->get_value( 'settings', 'smtp_authentication' );
			if ( 'on' === $use_auth ) {
				$phpmailer->SMTPAuth  = true;
				$phpmailer->Username  = $this->get_value( 'settings', 'smtp_username' );
				$phpmailer->Password  = $this->get_value( 'settings', 'smtp_password' );
			}
			//PHPMailer 5.2.10 introduced this option. However, this might cause issues if the server is advertising TLS with an invalid certificate.
			$phpmailer->SMTPAutoTLS = false;
			/* Set the SMTPSecure value, if set to none, leave this blank */
			$insecure_ssl = $this->get_value( 'settings', 'smtp_insecure_ssl' );
			if ( 'on' === $insecure_ssl ) {
				$phpmailer->SMTPOptions = array(
					'ssl' => array(
						'verify_peer'   => false,
						'verify_peer_name'  => false,
						'allow_self_signed'  => true,
					),
				);
			}
		}

		/**
		 * modify option name
		 *
		 * @since 2.0.0
		 */
		public function get_module_option_name( $option_name, $module ) {
			if ( is_string( $module ) && $this->module == $module ) {
				return $this->option_name;
			}
			return $option_name;
		}

		/**
		 * Set options
		 *
		 * @since 2.0.0
		 */
		protected function set_options() {
			$options = array(
				'settings' => array(
					'title' => __( 'SMTP Configuration Settings', 'ub' ),
					'fields' => array(
						'from_email' => array(
							'label' => __( 'From email address', 'ub' ),
							'description' => __( 'This email address will be used in the "From" field.', 'ub' ),
						),
						'from_name_force' => array(
							'type' => 'checkbox',
							'label' => __( 'Force from name replacement', 'ub' ),
							'description' => __( 'When enabled, the plugin will set the above From Name for each email. Disable it if you\'re using contact form plugins, it will prevent the plugin from replacing form submitter\'s name when contact email is sent.  If email\'s From Name is empty, the plugin will set the above value regardless.', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'from-name',
						),
						'from_name' => array(
							'label' => __( 'From name', 'ub' ),
							'description' => __( 'This text will be used in the "FROM" field.', 'ub' ),
							'master' => 'from-name',
						),
						'smtp_host' => array(
							'label' => __( 'SMTP host', 'ub' ),
							'description' => __( 'Your mail server.', 'ub' ),
						),
						'smtp_type_encryption' => array(
							'type' => 'radio',
							'label' => __( 'Type of Encryption', 'ub' ),
							'options' => array(
								'none' => __( 'None', 'ub' ),
								'ssl' => __( 'SSL', 'ub' ),
								'tls' => __( 'TLS', 'ub' ),
							),
							'default' => 'ssl',
							'description' => __( 'For most servers SSL is the recommended option.', 'ub' ),
						),
						'smtp_port' => array(
							'type' => 'number',
							'label' => __( 'SMTP port', 'ub' ),
							'description' => __( 'The port to your mail server.', 'ub' ),
							'default' => 25,
							'min' => 1,
						),
						'smtp_authentication' => array(
							'type' => 'checkbox',
							'label' => __( 'SMTP Authentication', 'ub' ),
							'description' => __( 'This options should always be checked "On".', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
						),
						'smtp_username' => array(
							'label' => __( 'SMTP Username', 'ub' ),
							'description' => __( 'The username to login to your mail server.', 'ub' ),
						),
						'smtp_password' => array(
							'type' => 'password',
							'label' => __( 'SMTP Password', 'ub' ),
							'description' => __( 'The password to login to your mail server.', 'ub' ),
						),
						'smtp_insecure_ssl' => array(
							'type' => 'checkbox',
							'label' => __( 'Allow Insecure SSL Certificates', 'ub' ),
							'description' => __( 'Allows insecure and self-signed SSL certificates on SMTP server. It\'s highly recommended to keep this option disabled.', 'ub' ),
							'options' => array(
								'on' => __( 'Allow', 'ub' ),
								'off' => __( 'Disallow', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
						),
					),
				),
				'test' => array(
					'title' => __( 'Test Email', 'ub' ),
					'description' => __( 'You can use this section to send an email from your server using the above configured SMTP details to see if the email gets delivered.', 'ub' ),
					'hide-reset' => true,
					'fields' => array(
						'to' => array(
							'type' => 'email',
							'label' => __( 'To', 'ub' ),
							'description' => __( 'Enter the recipient\'s email address.', 'ub' ),
						),
						'send' => array(
							'type' => 'button',
							'value' => __( 'Send test email', 'ub' ),
							'data' => array(
								'nonce' => wp_create_nonce( $this->module ),
							),
						),
					),
				),
			);
			$this->options = $options;
		}

		/**
		 * Add admin notice about configuration.
		 *
		 * @since 2.0.0
		 */
		public function configure_credentials_notice() {
			if ( true === $this->is_ready ) {
				return;
			}
			/**
			 * do not show notice on SMTP settings page
			 */
			if (
				isset( $_REQUEST['page'] )
				&& 'branding' === $_REQUEST['page']
				&& isset( $_REQUEST['tab'] )
				&& 'smtp' === $_REQUEST['tab']
			) {
				return;
			}
			$settings_url = add_query_arg(
				array(
					'page' => 'branding',
					'tab' => $this->module,
				),
				admin_url( 'admin.php' )
			);
			echo '<div class="notice notice-error">';
			echo wpautop( sprintf( __( 'Please configure your SMTP credentials in the <a href="%s">settings menu</a> in order to send email using SMTP module.', 'ub' ), esc_url( $settings_url ) ) );
			echo '</div>';
		}
	}
}
new ub_smtp();
