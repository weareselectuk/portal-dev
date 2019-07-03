<?php
/**
 * Collect admin usage stats
 *
 * @since 2.3.0
 */
if ( ! class_exists( 'UltimateBrandingAdminStats' ) ) {
	class UltimateBrandingAdminStats {
		/**
		 * Option name.
		 *
		 * @since 2.3.0
		 * @var string $option_name Option name.
		 */
		private $option_name = 'ultimate_branding_stats';

		/**
		 * Ultimate Branding configuration.
		 *
		 * @since 2.3.0
		 * @var array $configuration Ultimate Branding configuration.
		 */
		private $configuration;

		public function __construct() {
			add_action( 'ultimate_branding_load_modules', array( $this, 'collect' ), 10, 2 );
			add_filter( 'ultimate_branding_options_names', array( $this, 'add_option_name' ) );
			add_action( 'ultimate_branding_screen_settings_output', array( $this, 'show' ), 10, 2 );
		}

		/**
		 * Show stats on UB Dashboard "Screen Options" tab.
		 *
		 * @since 2.3.0
		 *
		 * @param string $settings Current string for "Screen Options" tab.
		 * @param array $configuration Ultimate Branding configuration.
		 *
		 * @return string $settings
		 */
		public function show( $settings, $configuration ) {
			if (
				! defined( 'WP_DEBUG' )
				|| ! WP_DEBUG
				|| ! current_user_can( 'manage_options' )
			) {
				return $settings;
			}
			$stats = get_site_option( $this->option_name );
			if (
				empty( $stats )
				|| ! isset( $stats['modules'] )
				|| empty( $stats['modules'] )
			) {
				return $settings;
			}
			$this->configuration = $configuration;
			$content = '';
			foreach ( $stats['modules'] as $key => $data ) {
				$module_name = $this->get_name( $key );
				if ( empty( $module_name ) ) {
					continue;
				}
				$content .= sprintf(
					'<tr><td>%s</td><td>%d</td><td>%d</td>',
					esc_html( $module_name ),
					isset( $data['read'] )? $data['read']:0,
					isset( $data['write'] )? $data['write']:0
				);
			}
			if ( empty( $content ) ) {
				return $settings;
			}
			$settings .= '<fieldset class="ub-modules-statistics">';
			$settings .= sprintf( '<legend>%s</legend>', esc_html__( 'Modules Statistics', 'ub' ) );
			$settings .= '<table>';
			$settings .= '<thead><tr>';
			$settings .= sprintf( '<th>%s</th>', esc_html__( 'Module', 'ub' ) );
			$settings .= sprintf( '<th>%s</th>', esc_html__( 'Read', 'ub' ) );
			$settings .= sprintf( '<th>%s</th>', esc_html__( 'Write', 'ub' ) );
			$settings .= '</tr></thead>';
			$settings .= '<tbody>';
			$settings .= $content;
			$settings .= '</tbody>';
			$settings .= '</table>';
			$settings .= '</fieldset>';
			return $settings;
		}

		/**
		 * Collect stats.
		 *
		 * @since 2.3.0
		 *
		 * @param string $tab Tab name.
		 * @param array $modules Active modules on tab.
		 *
		 */
		public function collect( $tab, $modules ) {
			$stats = get_site_option( $this->option_name );
			if ( empty( $stats ) ) {
				$stats = array();
			}
			/**
			 * inrement tabs
			 */
			if ( ! isset( $stats['tabs'] ) ) {
				$stats['tabs'] = array();
			}
			if ( ! isset( $stats['tabs'][ $tab ] ) ) {
				$stats['tabs'][ $tab ] = 0;
			}
			$stats['tabs'][ $tab ]++;
			/**
			 * inrement modules
			 */
			if ( ! isset( $stats['modules'] ) ) {
				$stats['modules'] = array();
			}
			foreach ( $modules as $module ) {
				if ( ! isset( $stats['modules'][ $module ] ) ) {
					$stats['modules'][ $module ] = array();
				}
				if ( ! isset( $stats['modules'][ $module ]['write'] ) ) {
					$stats['modules'][ $module ]['write'] = 0;
				}
				if ( ! isset( $stats['modules'][ $module ]['read'] ) ) {
					$stats['modules'][ $module ]['read'] = 0;
				}
				if ( isset( $_POST['action'] ) && 'process' === $_POST['action'] ) {
					$stats['modules'][ $module ]['write']++;
				} else {
					$stats['modules'][ $module ]['read']++;
				}
			}
			/**
			 * save
			 */
			update_site_option( $this->option_name, $stats );
		}

		/**
		 * Add option_name to delete on uninstall hook.
		 *
		 * @param array $options Array of keys to remove.
		 *
		 * @return array $options
		 */
		public function add_option_name( $options ) {
			$options[] = $this->option_name;
			return $options;
		}

		/**
		 * Get module name from configuration.
		 *
		 * Helper to get module name from configuration based on module key.
		 *
		 * @since 2.3.0
		 *
		 * @param string $key Module key.
		 *
		 * @return string Module name.
		 */
		private function get_name( $key ) {
			foreach ( $this->configuration as $module ) {
				if ( isset( $module['key'] ) && $key === $module['key'] ) {
					return $module['name'];
				}
			}
		}
	}
}