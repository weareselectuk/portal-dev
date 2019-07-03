<?php
// If we are on a campus install then we should be hiding some of the modules
if ( ! defined( 'UB_ON_CAMPUS' ) ) { define( 'UB_ON_CAMPUS', false ); }
// Allows the branding admin menus to be hidden on a single site install
if ( ! defined( 'UB_HIDE_ADMIN_MENU' ) ) { define( 'UB_HIDE_ADMIN_MENU', false ); }
// Allows the main blog to be changed from the default with an id of 1
if ( ! defined( 'UB_MAIN_BLOG_ID' ) ) { define( 'UB_MAIN_BLOG_ID', 1 ); }

/**
 * Modules list
 *
 * @since 1.9.4
 */
function ub_get_modules_list( $mode = 'full' ) {
	global $wp_version;
	$modules = array(
		/**
		 * Admin Menu Manager module do not work.
		 */
		'admin-menu.php' => array(
			'module' => 'admin-menu.php',
			'tab' => 'admin-menu',
			'page_title' => __( 'Admin Menu Manager', 'ub' ),
			'disabled' => true,
			'name' => __( 'Admin Menu Manager', 'ub' ),
			'description' => __( 'Show or hide admin menu items based on a user role (in development).', 'ub' ),
		),
		'admin-footer-text.php' => array(
			'module' => 'admin-footer-text/admin-footer-text.php',
			'tab' => 'footer',
			'page_title' => __( 'Footer Content', 'ub' ),
			'title' => __( 'Admin Footer Content', 'ub' ),
			'name' => __( 'Dashboard Footer Content', 'ub' ),
			'description' => __( 'Display text in admin dashboard footer.', 'ub' ),
		),
		'admin-help-content.php' => array(
			'module' => 'admin-help-content/admin-help-content.php',
			'tab' => 'help',
			'page_title' => __( 'Help Content', 'ub' ),
			'name' => __( 'Admin Help Content', 'ub' ),
			'description' => __( 'Change the "help content" that slides down all AJAXy.', 'ub' ),
		),
		'custom-admin-bar.php' => array(
			'module' => 'custom-admin-bar/custom-admin-bar.php',
			'tab' => 'adminbar',
			'page_title' => __( 'Admin Bar', 'ub' ),
			'name' => __( 'Admin Bar', 'ub' ),
			'description' => __( 'Adds a custom drop-down entry to your admin bar.', 'ub' ),
			'public' => true,
		),
		'admin-bar-logo.php' => array(
			'module' => 'admin-bar-logo.php',
			'tab' => 'adminbar',
			'page_title' => __( 'Admin Bar', 'ub' ),
			'title' => __( 'Admin Bar Logo', 'ub' ),
			'name' => __( 'Admin Bar Logo', 'ub' ),
			'description' => __( 'Allow to change admin bar logo.', 'ub' ),
			'public' => true,
		),
		'custom-dashboard-welcome.php' => array(
			'module' => 'custom-dashboard-welcome.php',
			'tab' => 'widgets',
			'page_title' => __( 'Widgets', 'ub' ),
			'title' => __( 'Dashboard Welcome', 'ub' ),
			'name' => __( 'Dashboard Welcome', 'ub' ),
			'description' => __( 'Allow to change the dashboard welcome message.', 'ub' ),
		),
		'custom-email-from.php' => array(
			'module' => 'custom-email-from/custom-email-from.php',
			'tab' => 'from-email',
			'page_title' => __( 'Email From', 'ub' ),
			'name' => __( 'Email From', 'ub' ),
			'description' => __( 'Allow to setup from email for WordPress outgoing mails.', 'ub' ),
			'public' => true,
		),
		'global-footer-content.php' => array(
			'module' => 'global-footer-content/global-footer-content.php',
			'tab' => 'footer',
			'page_title' => __( 'Footer Content', 'ub' ),
			'title' => __( 'Footer Content', 'ub' ),
			'network-only' => true,
			'name' => __( 'Footer Content', 'ub' ),
			'description' => __( 'Simply insert any code that you like into the footer of every blog.', 'ub' ),
			'public' => true,
		),
		'global-header-content.php' => array(
			'module' => 'global-header-content/global-header-content.php',
			'tab' => 'header',
			'page_title' => __( 'Header Content', 'ub' ),
			'title' => __( 'Header Content', 'ub' ),
			'network-only' => true,
			'name' => __( 'Header Content', 'ub' ),
			'description' => __( 'Simply insert any code that you like into the header of every blog.', 'ub' ),
			'public' => true,
		),
		'rebranded-meta-widget.php' => array(
			'module' => 'rebranded-meta-widget/rebranded-meta-widget.php',
			'tab' => 'widgets',
			'page_title' => __( 'Widgets', 'ub' ),
			'title' => __( 'Rebranded Meta Widget', 'ub' ),
			'name' => __( 'Rebranded Meta Widget', 'ub' ),
			'description' => __( 'Simply replaces the default Meta widget in all Multisite blogs with one that has the "Powered By" link branded for your site.', 'ub' ),
			'public' => true,
		),
		'remove-dashboard-link-for-users-without-site.php' => array(
			'module' => 'remove-dashboard-link-for-users-without-site.php',
			'name' => __( 'Remove WP Dashboard Link for users without site', 'ub' ),
			'description' => __( 'Removes "Dashboard" link from admin panel for users without site (in WP Multisite) and redirect page to the "Profile".', 'ub' ),
		),
		'remove-permalinks-menu-item.php' => array(
			'module' => 'remove-permalinks-menu-item/remove-permalinks-menu-item.php',
			'tab' => 'permalinks',
			'page_title' => __( 'Permalinks Menu', 'ub' ),
			'name' => __( 'Remove Permalinks Menu Item', 'ub' ),
			'description' => __( 'Removes the "Permalinks" Configuration Options.', 'ub' ),
		),
		'remove-wp-dashboard-widgets.php' => array(
			'module' => 'remove-wp-dashboard-widgets/remove-wp-dashboard-widgets.php',
			'tab' => 'widgets',
			'page_title' => __( 'Widgets', 'ub' ),
			'title' => __( 'Remove WP Dashboard Widgets', 'ub' ),
			'name' => __( 'Remove WP Dashboard Widgets', 'ub' ),
			'description' => __( 'Removes the WordPress dashboard widgets.', 'ub' ),
		),
		'site-generator-replacement.php' => array(
			'module' => 'site-generator-replacement/site-generator-replacement.php',
			'tab' => 'sitegenerator',
			'page_title' => __( 'Site Generator', 'ub' ),
			'name' => __( 'Site Generator Replacement', 'ub' ),
			'description' => __( 'Easily customize ALL "Site Generator" text and links. Edit under Site Admin "Options" menu.', 'ub' ),
			'public' => true,
		),
		'site-wide-text-change.php' => array(
			'module' => 'site-wide-text-change/site-wide-text-change.php',
			'tab' => 'textchange',
			'page_title' => __( 'Text Change', 'ub' ),
			'menu_title' => __( 'Text Change', 'ub' ),
			'name' => __( 'Text Change', 'ub' ),
			'description' => __( 'Would you like to be able to change any wording, anywhere in the entire admin area on your whole site? Without a single hack? Well, if that\'s the case then this plugin is for you!', 'ub' ),
			'public' => true,
		),
		'custom-admin-css.php' => array(
			'module' => 'custom-admin-css',
			'tab' => 'css',
			'menu_title' => __( 'CSS', 'ub' ),
			'page_title' => __( 'Cascading Style Sheets', 'ub' ),
			'name' => __( 'Admin CSS', 'ub' ),
			'description' => __( 'Add extra CSS to the admin panel.', 'ub' ),
		),
		'ultimate-color-schemes.php' => array(
			'module' => 'ultimate-color-schemes.php',
			'tab' => 'ultimate-color-schemes',
			'page_title' => __( 'Color Schemes', 'ub' ),
			'name' => __( 'Color Schemes', 'ub' ),
			'description' => __( 'Customize admin color schemes.', 'ub' ),
			'public' => true,
		),
		'admin-message.php' => array(
			'module' => 'admin-message.php',
			'tab' => 'admin-message',
			'page_title' => __( 'Admin Message', 'ub' ),
			'name' => __( 'Admin Message', 'ub' ),
			'description' => __( 'Display a message in admin dashboard.', 'ub' ),
		),
		/**
		 * Images
		 */
		'favicons.php' => array(
			'module' => 'favicons.php',
			'tab' => 'images',
			'page_title' => __( 'Images', 'ub' ),
			'title' => __( 'Favicons', 'ub' ),
			'name' => __( 'Favicons', 'ub' ),
			'description' => __( 'Change the Favicon.', 'ub' ),
			'public' => true,
		),
		/**
		 * Images: Image upload size
		 *
		 * @since 1.9.2
		 */
		'image-upload-size.php' => array(
			'module' => 'image-upload-size.php',
			'tab' => 'images',
			'page_title' => __( 'Images', 'ub' ),
			'title' => __( 'Limit Image Upload Filesize', 'ub' ),
			'name' => __( 'Image Upload Size', 'ub' ),
			'description' => __( 'Allows you to limit the filesize of uploaded images.', 'ub' ),
			'public' => true,
		),
		/**
		 * Email Template
		 *
		 * @since 1.8.4
		 */
		'htmlemail.php' => array(
			'module' => 'htmlemail',
			'tab' => 'htmlemail',
			'page_title' => __( 'Email Template', 'ub' ),
			'name' => __( 'Email Template', 'ub' ),
			'description' => __( 'Allows you to add HTML templates for all of the standard WordPress emails.', 'ub' ),
			'public' => true,
		),
		/**
		 * Custom Login Screen
		 *
		 * @since 1.8.5
		 */
		'custom-login-screen.php' => array(
			'module' => 'custom-login-screen.php',
			'tab' => 'login-screen',
			'page_title' => __( 'Login Screen', 'ub' ),
			'title' => __( 'Login Screen', 'ub' ),
			'wp' => '4.6',
			'name' => __( 'Login Screen', 'ub' ),
			'description' => __( 'Allow to customize login screen.', 'ub' ),
			'public' => true,
		),
		/**
		 * Custom MS email content
		 *
		 * @since 1.8.6
		 */
		'custom-ms-register-emails.php' => array(
			'module' => 'custom-ms-register-emails.php',
			'network-only' => true,
			'tab' => 'custom-ms-register-emails',
			'page_title' => __( 'MultiSite Registration Emails', 'ub' ),
			'menu_title' => __( 'Registration Emails', 'ub' ),
			'name' => __( 'MultiSite Registration Emails', 'ub' ),
			'description' => __( '', 'ub' ),
			'public' => true,
		),
		/**
		 * Export - Import
		 *
		 * @since 1.8.6
		 */
		'export-import.php' => array(
			'module' => 'export-import.php',
			'tab' => 'export-import',
			'page_title' => __( 'Export & Import Ultimate Branding Configuration', 'ub' ),
			'menu_title' => __( 'Export/Import', 'ub' ),
			'name' => __( 'Export & Import', 'ub' ),
			'description' => __( 'Module allow to export and import Ultimate Branding settings.', 'ub' ),
		),
		'admin-panel-tips/admin-panel-tips.php' => array(
			'module' => 'admin-panel-tip',
			'show-on-single' => true,
			'hide-on-single-install' => true,
			'tab' => 'admin-panel-tips',
			'page_title' => __( 'Admin Panel Tips', 'ub' ),
			'menu_title' => __( 'Tips', 'ub' ),
			'name' => __( 'Admin Panel Tips', 'ub' ),
			'description' => __( 'Provide your users with helpful random tips (or promotions/news) in their admin panels.', 'ub' ),
		),
		/**
		 * Comments Control
		 *
		 * @since 1.8.6
		 */
		'comments-control.php' => array(
			'module' => 'comments-control.php',
			'network-only' => true,
			'tab' => 'comments-control',
			'page_title' => __( 'Comments Control', 'ub' ),
			'name' => __( 'Comments Control', 'ub' ),
			'description' => __( 'Fine tune comment throttling.', 'ub' ),
			'wp' => '3.9',
			'public' => true,
		),
		/**
		 * Dashboard Feeds
		 *
		 * @since 1.8.6
		 */
		'dashboard-feeds/dashboard-feeds.php' => array(
			'module' => 'dashboard-feeds',
			'tab' => 'dashboard-feeds',
			'page_title' => __( 'Dashboard Feeds', 'ub' ),
			'name' => __( 'Dashboard Feeds', 'ub' ),
			'description' => __( 'Customize the dashboard for every user in a flash with this straightforward dashboard feed replacement widget... no more WP development news or Matt\'s latest photo set :)', 'ub' ),
		),
		/**
		 * Link Manager
		 *
		 * @since 1.8.6
		 */
		'link-manager.php' => array(
			'module' => 'link-manager',
			'tab' => 'link-manager',
			'page_title' => __( 'Link Manager', 'ub' ),
			'name' => __( 'Link Manager', 'ub' ),
			'description' => __( 'Enables the Link Manager that existed in WordPress until version 3.5.', 'ub' ),
			'wp' => '3.5',
		),
		/**
		 * Coming Soon Page & Maintenance Mode
		 *
		 * @since 1.9.1
		 */
		'maintenance/maintenance.php' => array(
			'module' => 'maintenance',
			'tab' => 'maintenance',
			'page_title' => __( 'Coming Soon Page & Maintenance Mode', 'ub' ),
			'menu_title' => __( 'Maintenance', 'ub' ),
			'wp' => '4.6',
			'since' => '1.9.1',
			'name' => __( 'Coming Soon Page & Maintenance Mode', 'ub' ),
			'description' => __( 'Customize the Maintenance Mode page and create Coming Soon Page.', 'ub' ),
			'public' => true,
		),
		/**
		 * Dashboard widgets
		 *
		 * @since 1.9.1
		 */
		'dashboard-text-widgets/dashboard-text-widgets.php' => array(
			'module' => 'dashboard-text-widgets',
			'tab' => 'dashboard-text-widgets',
			'page_title' => __( 'Dashboard Text Widgets', 'ub' ),
			'name' => __( 'Dashboard Text Widgets', 'ub' ),
			'description' => __( 'Enables the Dashboard text widgets.', 'ub' ),
		),
		/**
		 * Blog creation
		 *
		 * @since 1.9.6
		 */
		'signup-blog-description.php' => array(
			'module' => 'signup-blog-description',
			'network-only' => true,
			'tab' => 'multisite',
			'page_title' => __( 'Signup Form', 'ub' ),
			'menu_title' => __( 'Signup Form', 'ub' ),
			/**
			 * https://app.asana.com/0/47431170559378/582548491040986
			 */
			'disabled' => true,
			'name' => __( 'Blog Description on Blog Creation', 'ub' ),
			'description' => __( 'Allows new bloggers to be able to set their tagline when they create a blog in Multisite.', 'ub' ),
			'public' => true,
		),
		/**
		 * Author Box
		 *
		 * @since 1.9.1
		 */
		'author-box/author-box.php' => array(
			'module' => 'author-box',
			'tab' => 'author-box',
			'page_title' => __( 'Author Box', 'ub' ),
			'menu_title' => __( 'Author Box', 'ub' ),
			'name' => __( 'Author Box', 'ub' ),
			'description' => __( 'Adds a responsive author box at the end of your posts, showing the author name, author gravatar and author description and social profiles.', 'ub' ),
			'public' => true,
		),
		/**
		 * SMTP
		 *
		 * @since 2.0.0
		 */
		'smtp/smtp.php' => array(
			'module' => 'smtp',
			'tab' => 'smtp',
			'page_title' => __( 'SMTP', 'ub' ),
			'since' => '2.0.0',
			'name' => __( 'SMTP', 'ub' ),
			'description' => __( 'SMTP allows you to configure and send all outgoing emails via a SMTP server. This will prevent your emails from going into the junk/spam folder of the recipients.', 'ub' ),
			'public' => true,
		),
		/**
		 * db-error-page
		 *
		 * @since 2.0.0
		 */
		'db-error-page/db-error-page.php' => array(
			'module' => 'db-error-page',
			'tab' => 'db-error-page',
			'page_title' => __( 'DB Error Page', 'ub' ),
			'since' => '2.0.0',
			'name' => __( 'DB Error Page', 'ub' ),
			'description' => __( 'Allows to create a custom database error page.', 'ub' ),
		),
		/**
		 * ms-site-check
		 *
		 * @since 2.0.0
		 */
		'ms-site-check/ms-site-check.php' => array(
			'module' => 'ms-site-check',
			'tab' => 'ms-site-check',
			'page_title' => __( 'Site Status Pages', 'ub' ),
			'network-only' => true,
			'since' => '2.0.0',
			'name' => __( 'Sites Status Pages', 'ub' ),
			'description' => __( 'Allows to create custom pages for deleted, inactive, archived, or spammed blog.', 'ub' ),
		),
		/**
		 * Cookie Notice
		 *
		 * @since 2.2.0
		 */
		'cookie-notice/cookie-notice.php' => array(
			'module' => 'cookie-notice',
			'tab' => 'cookie-notice',
			'page_title' => __( 'Cookie Notice', 'ub' ),
			'since' => '2.2.0',
			'name' => __( 'Cookie Notice', 'ub' ),
			'description' => __( 'Cookie Notice allows you to elegantly inform users that your site uses cookies and to comply with the EU cookie law GDPR regulations.', 'ub' ),
			'public' => true,
		),
		/**
		 * Blog creation: signup code
		 *
		 * @since 2.3.0
		 */
		'signup-code.php' => array(
			'module' => 'signup-code',
			'tab' => 'multisite',
			'page_title' => __( 'Signup Form', 'ub' ),
			'menu_title' => __( 'Signup Form', 'ub' ),
			'name' => __( 'Signup Code', 'ub' ),
			'description' => __( 'Limit who can sign up for a blog or user account at your site by requiring a special code that you can easily configure yourself.', 'ub' ),
			'since' => '2.2.1',
			'public' => true,
		),
		/**
		 * Document
		 *
		 * @since 2.3.0
		 */
		'document.php' => array(
			'module' => 'document',
			'tab' => 'document',
			'page_title' => __( 'Document', 'ub' ),
			'since' => '2.3.0',
			'name' => __( 'Document', 'ub' ),
			'description' => __( 'Allow to change defults for entry display.', 'ub' ),
			'public' => true,
		),
		/**
		 * Tracking codes
		 *
		 * @since 2.3.0
		 */
		'tracking-codes/tracking-codes.php' => array(
			'module' => 'tracking-codes',
			'tab' => 'tracking-codes',
			'page_title' => __( 'Tracking Codes', 'ub' ),
			'since' => '2.3.0',
			'name' => __( 'Tracking Codes', 'ub' ),
			'description' => __( 'Tracking Code module give you the ability to manage your tracking code and scripts in one single page.', 'ub' ),
			'public' => true,
		),
	);
	/**
	 * filter by WP version
	 */
	foreach ( $modules as $slug => $data ) {
		if ( isset( $data['wp'] ) ) {
			$compare = version_compare( $wp_version, $data['wp'] );
			if ( 0 > $compare ) {
				unset( $modules[ $slug ] );
			}
		}
	}
	apply_filters( 'ultimatebranding_available_modules', $modules );
	if ( 'keys' == $mode ) {
		$modules = array_keys( $modules );
		sort( $modules );
	}
	return $modules;
}
