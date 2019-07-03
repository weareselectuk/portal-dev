<div class="ms-account-wrapper">
        <?php if ( ms_is_user_logged_in() ) : ?>

                <?php if( ms_show_users_membership() ) : ?>
                <div id="account-membership">
                <h2>
                        <?php
                        echo get_ms_ac_title();

                        if ( show_membership_change_link() ) {
                                echo get_ms_ac_signup_modified_url();
                        }
                        ?>
                </h2>
                <?php
                /**
                 * Add custom content right before the memberships list.
                 *
                 * @since  1.0.0
                 */
                do_action( 'ms_view_account_memberships_top', get_ms_ac_member_obj(), get_ms_ac_account_obj() );

                if ( is_ms_admin_user() ) {
                        _e( 'You are an admin user and have access to all memberships', 'membership2' );
                } else {
                        if ( has_ms_ac_subscriptions() ) {
                                ?>
                                <table>
                                        <tr>
                                                <th class="ms-col-membership"><?php
                                                        _e( 'Membership name', 'membership2' );
                                                ?></th>
                                                <th class="ms-col-status"><?php
                                                        _e( 'Status', 'membership2' );
                                                ?></th>
                                                <th class="ms-col-expire-date"><?php
                                                        _e( 'Expire date', 'membership2' );
                                                ?></th>
                                        </tr>
                                        <?php
                                        $empty = true;
                                        $m2_subscriptions = get_ms_ac_subscriptions();
                                        foreach ( $m2_subscriptions as $subscription ) :
                                                $empty = false;
                                                ms_account_the_membership( $subscription );
                                                ?>
                                                <tr class="<?php echo get_ms_account_classes(); ?>">
                                                       <strong> <td class="ms-col-membership">:</strong><?php echo get_ms_account_membership_name(); ?></td>
                                                        <strong><td class="ms-col-status">:</strong> <?php echo get_ms_account_membership_status(); ?></td>
                                                        <strong><td class="ms-col-expire-date">:</strong><?php echo get_ms_account_expire_date(); ?></td>
                                                </tr>
                                        <?php
                                        endforeach;

                                        if ( $empty ) {
                                                echo get_ms_no_account_membership_status();
                                        }
                                        ?>
                                </table>
                        <?php
                        } else {
                                _e( 'No memberships', 'membership2' );
                        }
                }
                /**
                 * Add custom content right after the memberships list.
                 *
                 * @since  1.0.0
                 */
                do_action( 'ms_view_account_memberships_bottom', get_ms_ac_member_obj(), get_ms_ac_account_obj() );
                ?>
                </div>
                <?php endif; ?>


                <?php
                // ===================================================== PROFILE
                if ( is_ms_ac_show_profile() ) : ?>
                <div id="account-profile">
                <h2>
                        <?php
                        echo get_ms_ac_profile_title();

                        if ( is_ms_ac_show_profile_change() ) {
                                echo get_ms_ac_profile_change_link();
                        }
                        ?>
                </h2>
                <?php
                /**
                 * Add custom content right before the profile overview.
                 *
                 * @since  1.0.0
                 */
                do_action( 'ms_view_account_profile_top', get_ms_ac_member_obj(), get_ms_ac_account_obj() );
                ?>
                <table>
                        <?php $profile_fields = get_ms_ac_profile_fields(); ?>
                        <?php foreach ( $profile_fields as $field => $title ) : ?>
                                <tr>
                                        <th class="ms-label-title"><?php echo esc_html( $title ); ?>: </th>
                                        <td class="ms-label-field"><?php echo esc_html( get_ms_ac_profile_info( $field ) ); ?></td>
                                </tr>
                        <?php endforeach; ?>
                </table>
                <?php
                do_action( 'ms_view_account_profile_before_card', get_ms_ac_member_obj(), get_ms_ac_account_obj() );


                do_action( 'ms_view_shortcode_account_card_info', get_ms_ac_data() );

                /**
                 * Add custom content right after the profile overview.
                 *
                 * @since  1.0.0
                 */
                do_action( 'ms_view_account_profile_bottom', get_ms_ac_member_obj(), get_ms_ac_account_obj() );
                ?>
                </div>
                <?php
                endif;
                // END: if ( $show_profile )
                // =============================================================
                ?>

       <?php else :

                if ( ! has_ms_ac_login_form() ) {
                        echo get_ms_ac_login_form();
                }
        endif; ?>
</div>