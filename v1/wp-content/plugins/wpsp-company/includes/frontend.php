<?php
final class WPSPCompanyFrontend {

    public function wpsp_ticket_cap_read($flag, $ticket){

        global $wpsupportplus,$current_user;

        if( !$wpsupportplus->functions->is_staff($current_user) ){

            $flag=true;
        }

        return $flag;
    }

    public function wpsp_ticket_cap_close_ticket($flag, $ticket ){

        global $wpsupportplus,$current_user;

        if( !$wpsupportplus->functions->is_staff($current_user) ){

            $wpsp_settings_general= get_option('wpsp_settings_general');
            $allow_cust_close = isset($wpsp_settings_general['allow_cust_close']) ? $wpsp_settings_general['allow_cust_close'] : 0;
            if($allow_cust_close==1){
                $flag=true;
            }
        }

        return $flag;
    }

    public function wpsp_ticket_cap_post_reply($flag, $ticket){
      
        global $wpsupportplus,$current_user;

        if( !$wpsupportplus->functions->is_staff($current_user) ){

            $flag=true;
        }

        return $flag;
    }
    
    public function wpsp_en_mailer_emails( $emails, $mailer ){
        include WPSP_COMP_DIR . 'includes/admin/notifications/wpsp_en_mailer_emails.php';
        return $emails;
    }
}
?>
