<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $current_user,$wpsupportplus,$wpdb,$wpspcompany;

if( !$wpsupportplus->functions->is_staff($current_user) ){
    //check supervisor

    $comp_users=array($current_user->ID);

    $get_company=$wpdb->get_results("select * from {$wpdb->prefix}wpsp_company_users where userid='".$current_user->ID."'");
    foreach ($get_company as $comp){

        if($comp->supervisor){
					
            $get_company_users=$wpdb->get_results("select * from {$wpdb->prefix}wpsp_company_users where cid='".$comp->cid."'");
            foreach ($get_company_users as $user){
                $comp_users[]=$user->userid;
            }
        }

    }

    $comp_users=array_unique($comp_users);
    $user_emails=array();
    foreach ($comp_users as $us => $value){
				if($value > 0){
					  $user_obj=get_user_by('id', $value);
		        $user_emails[]="'".$user_obj->user_email."'";
				}else{
						$wpsp_user_session = $wpsupportplus->functions->get_current_user_session();
						$user_emails[] = "'".$wpsp_user_session['email']."'";
				}
    }

    $ticket_restrict_rules[] = "t.guest_email IN (".implode(',', $user_emails).") ";
}
