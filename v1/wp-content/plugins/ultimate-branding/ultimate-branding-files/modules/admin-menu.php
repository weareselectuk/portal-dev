<?php
class ub_admin_menu extends ub_helper {

	function __construct() {
		add_action( 'ultimatebranding_settings_admin_menu', array( &$this, 'admin_menu_site_admin_options' ) );
		add_filter( 'ultimatebranding_settings_admin_menu_process', array( &$this, 'update_admin_menu_options' ), 10, 1 );

		add_action( 'admin_menu', array( &$this, 'ub_check_admin_menus' ) );

		register_activation_hook( __FILE__, array( &$this, 'ub_admin_menu_install' ) );
		/**
		 * add options names
		 *
		 * @since 2.1.0
		 */
		add_filter( 'ultimate_branding_options_names', array( $this, 'add_options_names' ) );
	}

	/**
	 * Add option names
	 *
	 * @since 2.1.0
	 */
	public function add_options_names( $options ) {
		$options[] = 'ub_admin_menu';
		$options[] = 'ub_default_admin_menu';
		return $options;
	}

	function ub_is_admin_menu_set() {
		if ( ub_get_option( 'ub_admin_menu' ) ) {//&& !empty(ub_get_option('ub_admin_menu'))
			return true;
		} else {
			return false;
		}
	}

	function ub_is_default_admin_menu_set() {
		if ( ub_get_option( 'ub_default_admin_menu' ) ) {//&& !empty(ub_get_option('ub_admin_menu'))
			return true;
		} else {
			return false;
		}
	}

	function ub_check_admin_menus() {
		global $menu, $submenu, $user_identity, $wp_roles;

		$user_roles = array_keys( $wp_roles->roles );

		if ( ! $this->ub_is_default_admin_menu_set() ) {
			$this->ub_admin_menu_install();
		}

		foreach ( $user_roles as $role ) {
			$enabled_menu_[ $role ] = $this->ub_get_option_value( 'ub_enable_menu_' . $role );
			$enabled_submenu_[ $role ] = $this->ub_get_option_value( 'ub_enable_submenu_' . $role );
		}

		// set menu
		//if (isset($enabled_menu_['editor']) && '' != $enabled_menu_['editor']) {
		// set admin-menu
		foreach ( $user_roles as $role ) {
			$user = wp_get_current_user();

			if ( is_array( $user->roles ) && in_array( $role, $user->roles ) ) {
				if ( current_user_can( $role ) ) {
					$ub_admin_menu = $enabled_menu_[ $role ];
					$ub_admin_submenu = $enabled_submenu_[ $role ];
				}
			}
		}

		if ( isset( $menu ) && ! empty( $menu ) ) {

			foreach ( $menu as $index => $item ) {

				if ( 'index.php' === $item ) {
					continue; }

				if ( isset( $ub_admin_menu ) && ! in_array( $item[2], $ub_admin_menu ) ) {
					unset( $menu[ $index ] );
				}

				if ( isset( $submenu ) && ! empty( $submenu[ $item[2] ] ) ) {
					foreach ( $submenu[ $item[2] ] as $subindex => $subitem ) {
						if ( isset( $ub_admin_submenu ) && ! in_array( $subitem[2], $ub_admin_submenu ) ) {
							unset( $submenu[ $item[2] ][ $subindex ] ); }
					}
				}
			}
		}
		// }
	}

	function update_admin_menu_options() {
		global $wp_roles;
		$user_roles = array_keys( $wp_roles->roles );
		// menu update
		foreach ( $user_roles as $role ) {
			if ( isset( $_POST[ 'ub_enable_menu_' . $role ] ) ) {
				$ub_admin_menu_options[ 'ub_enable_menu_' . $role ] = $_POST[ 'ub_enable_menu_' . $role ];
			} else {
				$ub_admin_menu_options[ 'ub_enable_menu_' . $role ] = array();
			}
			if ( isset( $_POST[ 'ub_enable_submenu_' . $role ] ) ) {
				$ub_admin_menu_options[ 'ub_enable_submenu_' . $role ] = $_POST[ 'ub_enable_submenu_' . $role ];
			} else {
				$ub_admin_menu_options[ 'ub_enable_submenu_' . $role ] = array();
			}
		}
		ub_update_option( 'ub_admin_menu', $ub_admin_menu_options );
		return false;
	}

	function ub_admin_menu_install() {
		global $wp_roles, $menu, $submenu;
		if ( ! $this->ub_is_default_admin_menu_set() ) {
			ub_add_option( 'ub_default_admin_menu', $menu );
			ub_add_option( 'ub_default_admin_submenu', $submenu );
		}
	}

	function admin_menu_site_admin_options() {
		global $wp_roles, $menu, $submenu;

		$user_roles = array_keys( $wp_roles->roles );
		$user_roles_names = $wp_roles->get_names();
?>
        <table class="widefat admin-menu-table">
            <thead>
                <tr>
                    <th><?php _e( 'Show menu items for', 'ub' ); ?></th>
                    <?php foreach ( $user_roles_names as $user_role_name ) { ?>
                        <th class="th-center">
                            <?php echo $user_role_name; ?>
                        </th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
<?php
		$wp_admin_menu = ub_get_option( 'ub_default_admin_menu' );
		$wp_admin_submenu = ub_get_option( 'ub_default_admin_submenu' );

		//$wp_admin_menu = $menu;
		//$wp_admin_submenu = $submenu;

if ( ! isset( $wp_admin_menu ) || empty( $wp_admin_menu ) ) {
	$wp_admin_menu = $menu;
}

if ( ! isset( $wp_admin_submenu ) || empty( $wp_admin_submenu ) ) {
	$wp_admin_submenu = $submenu;
}

if ( isset( $wp_admin_menu ) && '' != $wp_admin_menu ) {

	$i = 0;
	$n = 0;
	$class = '';

	/*
	 * $item[0] = title
	 * $item[1] = required capability
	 * $item[2] = file/address
	 * $item[3] = page title
	 * $item[4] = class
	 * $item[5] = parent li id
	 * $item[6] = div | none | url to icon
	 */

	foreach ( $wp_admin_menu as $item ) {

		// don't check following item(s)
		if ( $item[2] == 'branding' ) {
			$hidden_menu_item = ' disabled';
		} else {
			$hidden_menu_item = '';
		}

		if ( $item[2] != '' ) {

			if ( preg_match( '/wp-menu-separator/', $item[4] ) ) {
				$item[0] = 'Separator';
			}

			$role_details = array();

			foreach ( $user_roles as $role ) {

				$enable_menu_[ $role ] = $this->ub_get_option_value( 'ub_enable_menu_' . $role );

				// check if for checked checkboxes
				if ( isset( $enable_menu_[ $role ] ) && in_array( $item[2], $enable_menu_[ $role ] ) ) {
					$checked_user_role_[ $role ] = ' checked="checked"';
				} else {
					$checked_user_role_[ $role ] = '';
				}

				if ( ! $this->ub_is_admin_menu_set() ) {
					$checked_user_role_[ $role ] = ' checked="checked"';
				}

				//Check if menu item is available for the role / capability)
				$role_details = get_role( $role );

				if ( array_key_exists( $item[1], $role_details->capabilities ) ) {
					$visible_user_role_[ $role ] = true;
				} else {
					$visible_user_role_[ $role ] = false;
				}

				$role_details = array();
			}
?>
					<tr class="form-invalid">
						<th><?php echo $item[0]; ?><!--<?php echo '<br />' . $item[1]; ?>--></th>
<?php
foreach ( $user_roles as $role ) {
?>
				<td class="num">
<?php
if ( $visible_user_role_[ $role ] ) {
?>
					<input id="check_menu<?php echo $role . $n; ?>" type="checkbox" <?php echo $hidden_menu_item . $checked_user_role_[ $role ]; ?> name="ub_enable_menu_<?php echo $role; ?>[]" value="<?php echo htmlentities( $item[2] ); ?>" />
<?php
}
?>
				</td>
<?php
}
?>
					</tr>
<?php
			$n++;

foreach ( $user_roles as $role ) {

	$enable_submenu_[ $role ] = $this->ub_get_option_value( 'ub_enable_submenu_' . $role );

	if ( isset( $enable_submenu_[ $role ] ) && in_array( $item[2], $enable_submenu_[ $role ] ) ) {
		$checked_user_role_[ $role ] = ' checked="checked"';
	} else {
		$checked_user_role_[ $role ] = '';
	}

	if ( ! $this->ub_is_admin_menu_set() ) {
		$checked_user_role_[ $role ] = ' checked="checked"';
	}
}

if ( ! isset( $wp_admin_submenu[ $item[2] ] ) ) {
	continue; }

			// submenu items
foreach ( $wp_admin_submenu[ $item[2] ] as $subitem ) {

	$class = ( ' class="alternate"' == $class ) ? '' : ' class="alternate"';

	$hidden_submenu_item = '';
?>
			<tr<?php echo $class; ?>>
<?php
foreach ( $user_roles as $role ) {
	if ( isset( $enable_submenu_[ $role ] ) ) {
		$checked_user_role_[ $role ] = ( in_array( $subitem[2], $enable_submenu_[ $role ] ) ) ? ' checked="checked"' : '';
	}
	if ( ! $this->ub_is_admin_menu_set() ) {
		$checked_user_role_[ $role ] = ' checked="checked"';
	}
}
?>
				<td class="admin-menu-submenu-item"><?php echo $subitem[0]; ?></td>
<?php
foreach ( $user_roles as $role ) {
?>

				<td class="num">
<?php
if ( $visible_user_role_[ $role ] ) {
?>
					<input id="check_menu<?php echo $role . $n; ?>" type="checkbox" <?php echo $hidden_submenu_item . $checked_user_role_[ $role ]; ?> name="ub_enable_submenu_<?php echo $role; ?>[]" value="<?php echo htmlentities( $subitem[2] ); ?>" />
				<?php } ?>
				</td>
<?php
}
?>
			</tr>
<?php
	$n++;
}
			$i++;
			$n++;
		}
	}
}
?>
            </tbody>
        </table>
<?php
	}


	function ub_get_option_value( $key ) {
		$ub_admin_menu_options = ub_get_option( 'ub_admin_menu' );

		if ( isset( $ub_admin_menu_options[ $key ] ) ) {
			return ( $ub_admin_menu_options[ $key ] );
		}
	}
}

$ub_admin_menu = new ub_admin_menu();