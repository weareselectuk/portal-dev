<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\Module\Audit\Model;

use Hammer\Helper\WP_Helper;

class Settings extends \Hammer\WP\Settings {

	private static $_instance;

	/**
	 * @var bool
	 */
	public $enabled = false;

	/**
	 * @var string
	 */
	public $frequency = '7';
	/**
	 * @var string
	 */
	public $day = 'sunday';
	/**
	 * @var string
	 */

	public $time = '0:0';
	/**
	 * Toggle notification on or off
	 * @var bool
	 */
	public $notification = true;

	/**
	 * @var array
	 */
	public $receipts = array();

	public $dummy = array();
	/**
	 * @var
	 */
	public $lastReportSent;

	/**
	 * @return array
	 */
	public function behaviors() {
		return array(
			'utils' => '\WP_Defender\Behavior\Utils'
		);
	}

	public function __construct( $id, $isMulti ) {
		if ( is_admin() || is_network_admin() && current_user_can( 'manage_options' ) ) {
			$user = wp_get_current_user();
			if ( is_object( $user ) ) {
				$this->receipts[] = array(
					'first_name' => $user->display_name,
					'email'      => $user->user_email
				);
			}
			$this->day = date( 'l' );
			$hour      = date( 'H', current_time( 'timestamp' ) );
			if ( $hour == '00' ) {
				$hour = 0;
			} else {
				$hour = ltrim( $hour, '0' );
			}
			$this->time = $hour . ':0';
		}
		parent::__construct( $id, $isMulti );
	}

	/**
	 * @return Settings
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			$class           = new Settings( 'wd_audit_settings', WP_Helper::is_network_activate( wp_defender()->plugin_slug ) );
			self::$_instance = $class;
		}

		return self::$_instance;
	}

	public function events() {
		$that = $this;

		return array(
			self::EVENT_BEFORE_SAVE => array(
				array(
					function () use ( $that ) {
						//need to turn off notification or report off if no recipients
						if ( isset( $_POST['receipts'] ) ) {
							$recipients = $_POST['receipts'];
							foreach ( $recipients as &$recipient ) {
								$recipient = array_map( 'wp_strip_all_tags', $recipient );
							}
							$this->receipts = $recipients;
						}
						$this->receipts = array_filter( $this->receipts );
						if ( count( $this->receipts ) == 0 ) {
							$this->notification = 0;
						}
					}
				)
			)
		);
	}
}