<?php
if ( ! class_exists( 'ub_rwpwidgets' ) ) {
	class ub_rwpwidgets extends ub_helper {

		protected $option_name = 'ub_remove_wp_dashboard_widgets';
		private $positions  = array( 'normal', 'side', 'advanced' );
		private $priorities = array( 'core', 'low', 'high' );
		private $types = array( 'dashboard', 'dashboard-network' );

		public function __construct() {
			parent::__construct();
			$this->set_options();
			/**
			 * UB admin actions
			 */
			add_action( 'ultimatebranding_settings_widgets', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_widgets_process', array( $this, 'update' ), 10, 1 );
			/**
			 * remove widgets
			 */
			add_action( 'wp_dashboard_setup', array( $this, 'remove_wp_dashboard_widgets' ), PHP_INT_MAX );
			add_action( 'wp_network_dashboard_setup', array( $this, 'remove_wp_dashboard_widgets' ), PHP_INT_MAX );
			/**
			 * add options names
			 *
			 * @since 2.1.0
			 */
			add_filter( 'ultimate_branding_options_names', array( $this, 'add_options_names' ) );
			add_action( 'init', array( $this, 'upgrade_options' ) );
			/**
			 * save available boxes
			 *
			 * @since 2.1.0
			 */
			add_action( 'wp_dashboard_setup', array( $this, 'save_available_widgets' ), 1 );
			add_action( 'wp_network_dashboard_setup', array( $this, 'save_available_widgets' ), 1 );

		}

		/**
		 * save available boxes
		 *
		 * @since 2.1.0
		 */
		public function save_available_widgets() {
			global $wp_meta_boxes;
			$available_widgets = ub_get_option( 'ub_rwp_all_active_dashboard_widgets' );
			foreach ( $this->types as $type ) {
				if ( ! isset( $wp_meta_boxes[ $type ] ) ) {
					continue;
				}
				foreach ( $this->positions as $position ) {
					if ( ! isset( $wp_meta_boxes[ $type ][ $position ] ) ) {
						continue;
					}
					foreach ( $this->priorities as $priority ) {
						if ( ! isset( $wp_meta_boxes[ $type ][ $position ][ $priority ] ) ) {
							continue;
						}
						foreach ( $wp_meta_boxes[ $type ][ $position ][ $priority ] as $key => $box ) {
							$available_widgets[ $key ] = strip_tags( $box['title'] );
						}
					}
				}
			}
			asort( $available_widgets );
			ub_update_option( 'ub_rwp_all_active_dashboard_widgets', $available_widgets );
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
			$active = ub_get_option( 'rwp_active_dashboard_widgets', array() );
			if ( empty( $active ) ) {
				return;
			}
			$data = array(
				'remove_dashboard' => array(
					'wp_widgets' => $active,
				),
			);
			$this->update_value( $data );
		}

		/**
		 * Add option names
		 *
		 * @since 2.1.0
		 */
		public function add_options_names( $options ) {
			$options[] = 'rwp_active_dashboard_widgets';
			$options[] = 'ub_rwp_all_active_dashboard_widgets';
			return $options;
		}

		/**
		 * set options
		 *
		 * @since 2.1.0
		 */
		protected function set_options() {
			$available_widgets = ub_get_option( 'ub_rwp_all_active_dashboard_widgets' );
			$description = __( 'Select which widgets you want to remove from all dashboards on your network from the list below. If you do not see a desired widget on this list, please visit Dashboard page and come back on this page.', 'ub' );
			$this->options = array(
				'remove_dashboard' => array(
					'title' => __( 'Remove WordPress Dashboard Widgets', 'ub' ),
					'description' => $description,
					'hide-reset' => true,
					'fields' => array(
						'wp_widgets' => array(
							'label' => __( 'Remove Widgets', 'ub' ),
							'type' => 'checkboxes',
							'options' => $available_widgets,
						),
					),
				),
			);
		}

		public function remove_wp_dashboard_widgets() {
			global $wp_meta_boxes;
			$active = $this->get_value( 'remove_dashboard', 'wp_widgets', array() );
			foreach ( $active as $key => $value ) {
				foreach ( $this->types as $type ) {
					foreach ( $this->positions as $context ) {
						remove_meta_box( $key, $type, $context );
					}
				}
			}
		}
	}
}
new ub_rwpwidgets();