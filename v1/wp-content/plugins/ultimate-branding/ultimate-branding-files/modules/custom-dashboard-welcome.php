<?php
class UB_Custom_Dashboard_Welcome extends ub_helper{

	/**
	 * Custom welcome message
	 *
	 * @since 1.2
	 * @var mixed|void
	 */
	private $_message;

	protected $option_name = 'ub_custom_welcome_message';

	/**
	 * Kick start the module
	 *
	 * @since 1.2
	 */
	public function __construct() {
		parent::__construct();
		$this->set_options();
		add_filter( 'get_user_metadata', array( $this, 'ub_remove_dashboard_welcome' ) , 10, 4 );
		/**
		 * new standard
		 */
		add_action( 'ultimatebranding_settings_widgets', array( $this, 'admin_options_page' ) );
		add_filter( 'ultimatebranding_settings_widgets_process', array( $this, 'update' ) );
		$this->_message = $this->_get_message();
		if ( ! empty( $this->_message ) && is_string( $this->_message ) ) {
			add_action( 'welcome_panel', array( $this, 'render_custom_message' ) );
		}
	}

	/**
	 * Retrieves custom message from db
	 *
	 * @since 1.2
	 * @return mixed|void
	 */
	private function _get_message() {
		$value = $this->get_value( 'dashboard_widget', 'text' );
		if ( empty( $value ) ) {
			$value = ub_get_option( $this->option_name );
		}
		return $value;
	}

	/**
	 * Removes default welcome message from dashboard
	 *
	 * @param $value
	 * @param $object_id
	 * @param $meta_key
	 * @param $single
	 *
	 * @since 1.0
	 *
	 * @return bool
	 */
	public function ub_remove_dashboard_welcome( $value, $object_id, $meta_key, $single ) {
		global $wp_version;
		if ( version_compare( $wp_version, '3.5', '>=' ) ) {
			remove_action( 'welcome_panel', 'wp_welcome_panel' );
			return $value;
		} else {
			if ( $meta_key == 'show_welcome_panel' ) {
				return false;
			}
		}
		return $value;
	}

	/**
	 * Saves settings to db
	 *
	 * @since 1.2
	 * @return bool
	 */
	public function process( $status ) {
		$this->_save_message( $_POST['custom_admin_welcome_message'] );
		return $status && true;
	}

	/**
	 * Renders custom content
	 *
	 * @since 1.2
	 */
	public function render_custom_message() {
		$proceed_shortcodes = $this->get_value( 'dashboard_widget', 'shortocode' );
		$content = stripslashes( $this->_message );
		if ( 'on' == $proceed_shortcodes ) {
			$content = do_shortcode( $content );
		}
		echo wpautop( $content );
	}

	/**
	 * Set options
	 *
	 * @since 1.8.9
	 */
	protected function set_options() {
		$this->module = 'widgets';
		$this->options = array(
			'dashboard_widget' => array(
				'title' => __( 'Dashboard Welcome' ),
				'fields' => array(
					'text' => array(
						'hide-th' => true,
						'type' => 'wp_editor',
						'label' => __( 'Dashboard Welcome', 'ub' ),
						'description' => __( 'Leave empty to remove custom welcome widget', 'ub' ),
						'default' => '',
						'value' => $this->_get_message(),
					),
					'shortocode' => array(
						'type' => 'checkbox',
						'label' => __( 'Shortcodes', 'ub' ),
						'description' => __( 'Be careful it can break compatibility with themes with UI builders.', 'ub' ),
						'options' => array(
							'on' => __( 'Parse shortocodes', 'ub' ),
							'off' => __( 'Stop parsing', 'ub' ),
						),
						'default' => 'off',
						'classes' => array( 'switch-button' ),
					),
				),
			),
		);
	}
}

new UB_Custom_Dashboard_Welcome();