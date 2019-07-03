<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;

if (!check_admin_referer('wpbdp_tab_general_section_general')) {
    exit;
}

$section_href='admin.php?page=wp-support-plus&setting=addons&section=company-settings';

if( isset($_REQUEST['update_setting']) && $_REQUEST['update_setting']=='wpsp_add_company') :
    /*
     * Create company
     */
    $values=array(
        'name'  =>sanitize_text_field($_POST['wpsp_company_name'])
    );

    $wpdb->insert( $wpdb->prefix.'wpsp_companies', $values );
    
    $comp_id = $wpdb->insert_id;
    
    $supervisors=$_POST['csupervisor'];
    
    $comp_users=$_POST['cuserid'];
    
    foreach ($comp_users as $user){
        $is_supervisor=0;
        if(in_array($user, $supervisors)){
            $is_supervisor=1;
        }
        $uservalues=array(
            'cid'           => $comp_id,
            'userid'        => $user,
            'supervisor'    => $is_supervisor
        );
        
        $wpdb->insert( $wpdb->prefix.'wpsp_company_users', $uservalues );
        
    }
    ?>
    <script type="text/javascript">
        window.location = "<?php echo $section_href;?>";
    </script> 
    <?php
    
endif;

if( isset($_REQUEST['update_setting']) && $_REQUEST['update_setting']=='wpsp_update_company') :
    /*
     * Update company
     */
    
    $comp_id=sanitize_text_field($_REQUEST['com']);
    
    //delete old users
    $wpdb->delete( $wpdb->prefix.'wpsp_company_users', array('cid'=>$comp_id) );
    
    
    $supervisors=$_POST['csupervisor'];
    $comp_users=$_POST['cuserid'];
    
    //add updated users
    foreach ($comp_users as $user){
        $is_supervisor=0;
        if(in_array($user, $supervisors)){
            $is_supervisor=1;
        }
        $uservalues=array(
            'cid'           => $comp_id,
            'userid'        => $user,
            'supervisor'    => $is_supervisor
        );
        
        $wpdb->insert( $wpdb->prefix.'wpsp_company_users', $uservalues );
    }
    
    //Update company table
    $values = array(
        'name'  =>sanitize_text_field($_POST['wpsp_company_name'])
    );
    $wpdb->update( $wpdb->prefix.'wpsp_companies', $values, array('id'=>$comp_id) );
    ?>
    
    <script type="text/javascript">
        window.location = "<?php echo $section_href;?>";
    </script> 
    
    <?php
    
endif;
?>  