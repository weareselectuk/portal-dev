<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<?php
if($_REQUEST['section']=='company-settings'){
    $tab=(empty($_REQUEST['action']))?'list':$_REQUEST['action'];
    switch ($tab){
        case 'list':
            include WPSP_COMP_DIR.'includes/admin/settings-tabs/show_all_companies.php';
        break;
        case 'add':
            include WPSP_COMP_DIR.'includes/admin/settings-tabs/add_new_company.php';
        break;
        case 'edit':
            include WPSP_COMP_DIR.'includes/admin/settings-tabs/update_company.php';
        break;
    }
}
?>