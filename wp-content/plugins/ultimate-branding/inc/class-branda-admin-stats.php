<?php
/**
 * Collect admin usage stats
 *
 * @since 2.3.0
 */
if ( ! class_exists( 'Branda_Admin_Stats' ) ) {
	class Branda_Admin_Stats extends Branda_Base {
		/**
		 * Option name.
		 *
		 * @since 2.3.0
		 * @var string $option_name Option name.
		 */
		private $option_name = 'ub_stats';

		public function __construct() {
			parent::__construct();
			add_action( 'branda_after_module_form', array( $this, 'collect' ) );
			add_action( 'branda_admin_stats_write', array( $this, 'collect_write' ) );
			add_filter( 'ultimate_branding_options_names', array( $this, 'add_option_name' ) );
			/**
			 * Activate / Deactivate
			 *
			 * @since 3.0.0
			 */
			add_action( 'branda_module_activated', array( $this, 'module_activated' ) );
			add_action( 'branda_module_deactivated', array( $this, 'module_deactivated' ) );
			/**
			 * upgrade options
			 *
			 * @since 3.0.0
			 */
			add_action( 'init', array( $this, 'upgrade_options' ) );
		}

		/**
		 *
		 * Upgrade module options
		 *
		 * @since 3.0.0
		 */
		public function upgrade_options() {
			$old_name = 'ultimate_branding_stats';
			$value = ub_get_option( $old_name );
			if ( ! empty( $value ) ) {
				ub_update_option( $this->option_name, $value );
				ub_delete_option( $old_name );
			}
		}

		/**
		 * Get Statistics
		 *
		 * @since 3.0.0
		 */
		public function get_stats() {
			$stats = ub_get_option( $this->option_name, array() );
			if ( empty( $stats ) || ! is_array( $stats ) ) {
				$stats = array();
			}
			$keys = array( 'modules', 'groups', 'activites' );
			foreach ( $keys as $key ) {
				if ( ! isset( $stats[ $key ] ) ) {
					$stats[ $key ] = array();
				}
			}
			return $stats;
		}

		/**
		 * Collect write
		 *
		 * @since 2.3.0
		 *
		 * @param string $id Tab name.
		 * @param array $modules Active modules on tab.
		 *
		 */
		public function collect_write( $option_name ) {
			$exceptions = array(
				$this->option_name,
				'branda_db_version',
				'ultimatebranding_activated_modules',
				'ultimatebranding_messages',
			);
			if ( in_array( $option_name, $exceptions ) ) {
				return;
			}
			$key = null;
			switch ( $option_name ) {
				case 'import':
					$key = 'utilities/import.php';
				break;
				default:
					$uba = ub_get_uba_object();
					$module = $uba->get_module_by_option( $option_name );
					if ( ! is_wp_error( $module ) && is_array( $module ) && isset( $module['key'] ) ) {
						$key = $module['key'];
					}
			}
			if ( empty( $key ) ) {
				return;
			}
			$stats = $this->get_stats();
			if ( ! isset( $stats['modules'][ $key ] ) ) {
				$stats['modules'][ $key ] = array();
			}
			if ( ! isset( $stats['modules'][ $key ]['write'] ) ) {
				$stats['modules'][ $key ]['write'] = 0;
			}
			$stats['modules'][ $key ]['write']++;
			$stats['modules'][ $key ]['last_write'] = time();
			/**
			 * save
			 */
			ub_update_option( $this->option_name, $stats );
		}

		/**
		 * Collect stats.
		 *
		 * @since 2.3.0
		 *
		 * @param string $id Tab name.
		 * @param array $modules Active modules on tab.
		 *
		 */
		public function collect( $module ) {
			$id = $module['key'];
			$group = $module['group'];
			$stats = $this->get_stats();
			/**
			 * inrement groups
			 */
			if ( ! isset( $stats['groups'][ $group ] ) ) {
				$stats['groups'][ $group ] = 0;
			}
			$stats['groups'][ $group ]++;
			/**
			 * inrement modules
			 */
			if ( ! isset( $stats['modules'] ) ) {
				$stats['modules'] = array();
			}
			if ( ! isset( $stats['modules'][ $id ] ) ) {
				$stats['modules'][ $id ] = array();
			}
			if ( ! isset( $stats['modules'][ $id ]['write'] ) ) {
				$stats['modules'][ $id ]['write'] = 0;
			}
			if ( ! isset( $stats['modules'][ $id ]['read'] ) ) {
				$stats['modules'][ $id ]['read'] = 0;
			}
			$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );
			if ( 'process' !== $action ) {
				$stats['modules'][ $id ]['read']++;
				$stats['modules'][ $id ]['last_read'] = time();
			}
			/**
			 * save
			 */
			ub_update_option( $this->option_name, $stats );
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

		/**
		 * Collect stats: module activation
		 *
		 * @since 3.0.0
		 *
		 * @param array $module Activated module.
		 *
		 */
		public function module_activated( $module ) {
			$stats = $this->get_stats();
			$stats['activites']['activate'] = $module;
			/**
			 * save
			 */
			ub_update_option( $this->option_name, $stats );
		}

		/**
		 * Collect stats: module deactivation
		 *
		 * @since 3.0.0
		 *
		 * @param array $module deactivated module.
		 *
		 */
		public function module_deactivated( $module ) {
			$stats = $this->get_stats();
			$stats['activites']['deactivate'] = $module;
			/**
			 * save
			 */
			ub_update_option( $this->option_name, $stats );
		}

		/**
		 * Get frequently used modules
		 *
		 * @since 3.0.0
		 */
		public function get_frequently_used_modules() {
			$uba = ub_get_uba_object();
			$modules = $all = array();
			$stats = $this->get_stats();
			if ( isset( $stats['modules'] ) ) {
				$all = $stats['modules'];
				uasort( $modules, array( $this, 'sort_modules_by_stats' ) );
			}
			foreach ( $all as $key => $data ) {
				if ( ! isset( $this->configuration[ $key ] ) ) {
					continue;
				}
				$module = $this->configuration[ $key ];
				if (
					isset( $module['instant'] )
					&& 'on' === $module['instant']
				) {
					continue;
				}
				$modules[ $key ] = $data;
			}
			/**
			 * How much modules show on "Frequently Used" block.
			 *
			 * @since 3.0.0
			 *
			 * @param integer Number of modules to show
			 */
			$number_of_module_to_show = apply_filters( 'branda_admin_stats_number_od_modules_to_show', 5 );
			intval( $number_of_module_to_show );
			$modules = array_chunk( $modules, $number_of_module_to_show, true );
			if ( isset( $modules[0] ) ) {
				return $modules[0];
			}
			return false;
		}

		/**
		 * Sort helper for get_frequently_used_modules.
		 *
		 * @since 3.0.0
		 */
		private function sort_modules_by_stats( $a, $b ) {
			if ( isset( $a['write'] ) ) {
				if ( isset( $b['write'] ) ) {
					if ( $a['write'] < $b['write'] ) {
						return 1;
					}
					if ( $a['write'] > $b['write'] ) {
						return -1;
					}
					if ( isset( $a['read'] ) ) {
						if ( isset( $b['read'] ) ) {
							if ( $a['read'] < $b['read'] ) {
								return 1;
							}
							if ( $a['read'] > $b['read'] ) {
								return -1;
							}
						}
						return 1;
					}
				}
				return 1;
			}
			if ( isset( $b['write'] ) ) {
				return -1;
			}
			return 0;
		}

		/**
		 * Set last write
		 *
		 * @since 3.0.0
		 */
		public function set_last_write( $id ) {
			$stats = $this->get_stats();
			if ( ! isset( $stats['modules'][ $id ] ) ) {
				$stats['modules'][ $id ] = array();
			}
			$stats['modules'][ $id ]['last_write'] = time();
			/**
			 * save
			 */
			ub_update_option( $this->option_name, $stats );
		}

		/**
		 * return raw modules data
		 *
		 * @since 3.0.0
		 */
		public function get_modules_raw_data() {
			$format = sprintf(
				'%s @ %s',
				get_option( 'date_format' ),
				get_option( 'time_format' )
			);
			$stats = $this->get_stats();
			$stats = $stats['modules'];
			$keys = array( 'last_read', 'last_write' );
			foreach ( $stats as $key => $data ) {
				foreach ( $keys as $k ) {
					if ( isset( $data[ $k ] ) ) {
						$stats[ $key ][ $k.'_human' ] = date_i18n( $format, $data[ $k ] );
					}
				}
			}
			return $stats;
		}
	}
}