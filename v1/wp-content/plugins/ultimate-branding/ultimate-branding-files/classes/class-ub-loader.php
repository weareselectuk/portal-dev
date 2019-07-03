<?php
/*
Class Name: UB_Loader
Class URI: http://iworks.pl/
Description: UB Modules table.
Version: 1.0.0
Author: Marcin Pietrzak
Author URI: http://iworks.pl/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2018 Incsub (http://incsub.com)

this program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
if ( ! class_exists( 'UB_Loader' ) ) {
	class UB_Loader {
		protected $configuration = array();
		protected $build = '';

		public function __construct() {
			ub_set_ub_version();
			global $ub_version;
			$this->build = $ub_version;
			$this->set_configuration();
		}

		/**
		 * Should moduel be off?
		 *
		 * @since 1.9.8
		 */
		protected function should_be_module_off( $module ) {
			global $wp_version;
			/**
			 * is module disabled by configuration?
			 *
			 * @since 2.3.0
			 */
			if (
				isset( $this->configuration[ $module ] )
				&& isset( $this->configuration[ $module ]['disabled'] )
				&& $this->configuration[ $module ]['disabled']
			) {
				return true;
			}
			/**
			 * is module allowed only for multisite?
			 */
			if (
				! is_multisite()
				&& isset( $this->configuration[ $module ] )
				&& isset( $this->configuration[ $module ]['network-only'] )
				&& $this->configuration[ $module ]['network-only']
			) {
				return true;
			}
			/**
			 * check WP version
			 */
			if (
				isset( $this->configuration[ $module ] )
				&& isset( $this->configuration[ $module ]['wp'] )
			) {
				$compare = version_compare( $wp_version, $this->configuration[ $module ]['wp'] );
				if ( 0 > $compare ) {
					return true;
				}
			}
			/**
			 * avoid to compare with development version
			 * for deprecated check
			 */
			if ( preg_match( '/^PLUGIN_VER/', $this->build ) ) {
				return false;
			}
			if (
				isset( $this->configuration[ $module ] )
				&& isset( $this->configuration[ $module ]['deprecated'] )
				&& $this->configuration[ $module ]['deprecated']
				&& isset( $this->configuration[ $module ]['deprecated_version'] )
			) {
				$compare = version_compare( $this->configuration[ $module ]['deprecated_version'], $this->build );
				if ( 1 > $compare ) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Set configuration
		 *
		 * @since 1.8.7
		 */
		protected function set_configuration() {
			$modules = ub_get_modules_list();
			$this->configuration = apply_filters( 'ultimatebranding_available_modules', $modules );
			/**
			 * add key to data
			 */
			foreach ( $this->configuration as $key => $data ) {
				/**
				 * check is module deprecated
				 */
				if ( $this->should_be_module_off( $key ) ) {
					unset( $this->configuration[ $key ] );
					continue;
				}
				/**
				 * turn off module for dependiences
				 */
				if (
					isset( $this->configuration[ $key ] )
					&& isset( $this->configuration[ $key ]['replaced_by'] )
				) {
					$is_active = ub_is_active_module( $key );
					if ( $is_active ) {
						$replace_by = $this->configuration[ $key ]['replaced_by'];
						$is_active = ub_is_active_module( $replace_by );
						if ( $is_active ) {
							$deactivate = $this->deactivate_module( $key );
							if ( $deactivate ) {
								$message = array(
									'class' => 'info',
									'message' => sprintf(
										__( 'Module "<b>%s</b>" was turned off because module "<b>%s</b>" is active.', 'ub' ),
										$data['title'],
										$this->configuration[ $replace_by ]['title']
									),
								);
								$this->add_message( $message );
							}
							unset( $this->configuration[ $key ] );
							continue;
						}
					}
				}
				/**
				 * fix menu_title
				 */
				$this->configuration[ $key ]['key'] = $key;
				if ( isset( $data['page_title'] ) && ! isset( $data['menu_title'] ) ) {
					$this->configuration[ $key ]['menu_title'] = $data['page_title'];
				}
			}
			/**
			 * check modules to off
			 */
			$this->configuration = apply_filters( 'ultimatebranding_available_modules', $this->configuration );
			/**
			 * sort
			 */
			uasort( $this->configuration, array( $this, 'sort_configuration' ) );
		}

		/**
		 * Sort helper for tab menu.
		 *
		 * @since 1.8.8
		 */
		private function sort_configuration( $a, $b ) {
			if ( isset( $a['menu_title'] ) && isset( $b['menu_title'] ) ) {
				return strcasecmp( $a['menu_title'], $b['menu_title'] );
			}
			return 0;
		}
	}
}