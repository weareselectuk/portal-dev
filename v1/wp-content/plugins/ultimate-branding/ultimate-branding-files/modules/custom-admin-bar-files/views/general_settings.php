<?php
/**
 * Renders general setting box
 */

$boxes = array();
$settings = get_user_meta( get_current_user_id(), 'closedpostboxes_ultimate_branding', true );
if ( isset( $settings['adminbar'] ) ) {
	$boxes = $settings['adminbar'];
}
$id = 'general';
if ( ! isset( $boxes[ $id ] ) ) {
	$boxes[ $id ] = 'open';
}
?>
<div class="postbox-container">
    <div class="meta-box-sortables not-sortable simple-options">
        <div class="postbox <?php echo esc_attr( $boxes[ $id ] ); ?>" id="<?php echo esc_attr( $id ); ?>">
            <button type="button" class="handlediv button-link" aria-expanded="true">
                <span class="screen-reader-text"><?php printf( __( 'Toggle panel: %s', 'ub' ), __( 'General Settings', 'ub' ) ); ?></span>
                <span class="toggle-indicator" aria-hidden="true"></span>
            </button>
            <h3 class="hndle"><?php _e( 'General Settings','ub' ); ?></h3>
            <div class="inside">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <?php _e( 'Custom entry', 'ub' ) ?>
                        </td>
                        <td>
                            <?php UB_Admin_Bar_Forms::create_enabled_box() ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e( 'The Toolbar visibility', 'ub' ) ?>
                        </td>
                        <td>
                            <?php UB_Admin_Bar_Forms::create_show_box() ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
                    <?php if ( $enable_hiding_default_bars ) :


						$id = 'hide';
						if ( ! isset( $boxes[ $id ] ) ) {
							$boxes[ $id ] = 'open';
						}

?>
<div class="postbox-container">
    <div class="meta-box-sortables not-sortable simple-options">
        <div class="postbox <?php echo esc_attr( $boxes[ $id ] ); ?>" id="<?php echo esc_attr( $id ); ?>">
            <button type="button" class="handlediv button-link" aria-expanded="true">
                <span class="screen-reader-text"><?php printf( __( 'Toggle panel: %s', 'ub' ), __( 'Hide WordPress Menu Items', 'ub' ) ); ?></span>
                <span class="toggle-indicator" aria-hidden="true"></span>
            </button>
            <h3 class="hndle"><?php _e( 'Hide WordPress Menu Items','ub' ); ?></h3>
            <div class="inside">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <?php  _e( 'Menu Items', 'ub' ) ?>
                        </th>
                        <td>
                            <?php UB_Admin_Bar_Forms::create_disable_box() ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e( 'Select User Roles affected by above', 'ub' ) ?>
                        </th>
                        <td>
                            <?php UB_Admin_Bar_Forms::create_roles_box( 'wp_menu_roles' ) ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
                    <?php endif;



$id = 'advance';
if ( ! isset( $boxes[ $id ] ) ) {
	$boxes[ $id ] = 'open';
}
?>
<div class="postbox-container">
    <div class="meta-box-sortables not-sortable simple-options">
        <div class="postbox <?php echo esc_attr( $boxes[ $id ] ); ?>" id="<?php echo esc_attr( $id ); ?>">
            <button type="button" class="handlediv button-link" aria-expanded="true">
                <span class="screen-reader-text"><?php printf( __( 'Toggle panel: %s', 'ub' ), __( 'Advance Settings', 'ub' ) ); ?></span>
                <span class="toggle-indicator" aria-hidden="true"></span>
            </button>
            <h3 class="hndle" style='cursor:auto;'>
                <span><?php _e( 'Advance Settings','ub' ); ?></span>
            </h3>
            <div class="inside">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <?php  _e( 'Reorder Admin Bar Menus', 'ub' ) ?>
                        </th>
                        <td>
                            <form method="post">
                                <button id="ub_admin_bar_start_ordering" class="button-secondary"><?php _e( 'Reorder Menus', 'ub' ); ?></button>
                                <button type="submit" class="button-secondary" name="ub_admin_bar_restore_default_order"><?php _e( 'Restore Default Order', 'ub' ); ?></button>
                            </form>
                            <p class="description">
                                <?php _e( "Select 'Reorder Menus' then drag and drop to reorder your menu items. 'Restore Default Order' reverts them back to their original order, overriding any ordering you have set up.", 'ub' ); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php  _e( 'Custom CSS', 'ub' ) ?>
                        </th>
                        <td>
                            <textarea class="ub_css_editor" name="ub_admin_bar_style" id="ub_admin_bar_style_input"><?php echo UB_Admin_Bar::styles( true );  ?></textarea>
                            <p class="description">
                                <?php _e( "Styles defined here only apply to the admin bar, no other part of WordPress will be affected. Leave empty if no change to the default style is being made. Please don't use more than one selector for each set of rules.", 'ub' ); ?>
                            </p>
                            <p class="description">
                                <?php _e( 'Style <code>.ab-item .dashicons</code> to change styling of images in the admin bar.', 'ub' ); ?>
                            </p>
                            <p class="description">
                                <?php _e( 'Style <code>#wpadminbar</code> to change color or other styling of the admin bar.', 'ub' ); ?>
                            </p>
                            <p class="description">
                                <?php _e( 'Style <code>.ab-item</code> to change font  or other styling of the links in admin bar.', 'ub' ); ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
