<?php
if ( ! class_exists( 'UltimateBrandingPublic' ) ) {
	require_once dirname( __FILE__ ).'/ubbase.php';
	class UltimateBrandingPublic extends UltimateBrandingBase {
		/**
		 * The modules in the public class are only those that need to be
		 * loaded on the public side of the site as well
		 */
		protected $modules = array(
			'admin-bar-logo.php' => 'admin-bar-logo.php',
			'author-box/author-box.php' => 'author-box/author-box.php',
			'comments-control.php' => 'comments-control.php',
			'cookie-notice/cookie-notice.php' => 'cookie-notice/cookie-notice.php',
			'custom-admin-bar.php' => 'custom-admin-bar.php',
			'custom-email-from.php' => 'custom-email-from/custom-email-from.php',
			'custom-login-screen.php' => 'custom-login-screen.php',
			'custom-ms-register-emails.php' => 'custom-ms-register-emails.php',
			'document.php' => 'document.php',
			'favicons.php' => 'favicons.php',
			'global-footer-content.php' => 'global-footer-content/global-footer-content.php',
			'global-header-content.php' => 'global-header-content/global-header-content.php',
			'htmlemail.php' => 'htmlemail.php',
			'image-upload-size.php' => 'image-upload-size.php',
			'maintenance/maintenance.php' => 'maintenance/maintenance.php',
			'rebranded-meta-widget.php' => 'rebranded-meta-widget/rebranded-meta-widget.php',
			'signup-blog-description.php' => 'signup-blog-description.php',
			'site-generator-replacement.php' => 'site-generator-replacement/site-generator-replacement.php',
			'site-wide-text-change.php' => 'site-wide-text-change/site-wide-text-change.php',
			'smtp/smtp.php' => 'smtp/smtp.php',
			'tracking-codes/tracking-codes.php' => 'tracking-codes/tracking-codes.php',
			'ultimate-color-schemes.php' => 'ultimate-color-schemes.php',
		);
		var $plugin_msg = array();

		/**
		 * Class constructor
		 */
		public function __construct() {
			parent::__construct();
			add_action( 'plugins_loaded', array( $this, 'load_modules' ) );
		}

		/**
		 * 	Check plugins those will be used if they are active or not
		 */
		public function load_modules() {
			// Load our remaining modules here
			foreach ( $this->configuration as $module => $plugin ) {
				/**
				 * is a public module?
				 */
				if ( ! isset( $plugin['public'] ) || ! $plugin['public'] ) {
					continue;
				}
				if ( ub_is_active_module( $module ) ) {
					if ( $this->should_be_module_off( $module ) ) {
						continue;
					}
					ub_load_single_module( $module );
				}
			}
		}
	}
}