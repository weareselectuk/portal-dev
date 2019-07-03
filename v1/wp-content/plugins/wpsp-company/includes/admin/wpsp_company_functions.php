<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'WPSP_Company_Functions' ) ) :

    /**
     * Functions class for WPSP.
     * @class WPSP_Export_Functions
     */
    class WPSP_Company_Functions {

        function get_all_companies(){

            global $wpdb;
            $sql="select * from {$wpdb->prefix}wpsp_companies";
            $result=$wpdb->get_results($sql);

            return $result;
        }

        function get_company_supervisors( $comp_id ){

            global $wpdb;
            $sql="select userid from {$wpdb->prefix}wpsp_company_users where supervisor=1 and cid='".$comp_id."'";
            $result=$wpdb->get_results($sql);
            $supervisors=array();
            if($result){
                foreach ($result as $supervisor){
                    $supervisors[]=$supervisor->userid;
                }
            }

            return $supervisors;
        }

        function get_company_supervisors_name( $comp_id ){

            global $wpdb;
            $sql="select userid from {$wpdb->prefix}wpsp_company_users where supervisor=1 and cid='".$comp_id."'";
            $result=$wpdb->get_results($sql);
            $supervisors=array();
            if($result){
                foreach ($result as $supervisor){
                    $user_obj = get_user_by('id', $supervisor->userid);
                    $supervisors[]=$user_obj->display_name;
                }
            }

            return $supervisors;
        }

        function get_company_by_id( $comp_id ){

            global $wpdb;
            $sql="select * from {$wpdb->prefix}wpsp_companies where id='".$comp_id."'";
            $result=$wpdb->get_row($sql);

            return $result;
        }

        function get_company_users( $comp_id ){

            global $wpdb;
            $sql="select * from {$wpdb->prefix}wpsp_company_users where cid='".$comp_id."'";
            $result=$wpdb->get_results($sql);
            $comp_users=array();
            if($result){
                foreach ($result as $user){
                    $user_obj = get_user_by('id', $user->userid);
                    $comp_users[]=$user_obj;
                }
            }

            return $comp_users;
        }
    }

endif;
