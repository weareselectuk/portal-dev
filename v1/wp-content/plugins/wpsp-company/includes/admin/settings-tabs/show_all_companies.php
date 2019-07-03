<?php
if ( ! defined( 'ABSPATH' ) )
      exit; // Exit if accessed directly
?>

<div id="tab_container">

    <form method="post" action="">
        <?php
            $section_href='admin.php?page=wp-support-plus&setting=addons&section=company-settings&action=add';
            $section_href_update='admin.php?page=wp-support-plus&setting=addons&section=company-settings&action=edit';
            global $wpdb,$wpspcompany;
            $company=$wpspcompany->functions->get_all_companies();
        ?>

        <div style="clear: both; text-align: right;padding: 5px 0;">
            <a href="<?php echo $section_href;?>" class="button button-primary" type="button"> <?php _e('+ Add New Company','wpsp-company');?></a>
        </div>

        <table class="wp-list-table widefat fixed striped pages">

            <thead>
                <tr>
                    <th scope="row" style="width: 50px;"><?php _e('Sr. No','wpsp-company');?></th>
                    <th scope="row"><?php _e('Company / Usergroup Name','wpsp-company');?></th>
                    <th scope="row"><?php _e('Supervisor','wpsp-company');?></th>
                    <th scope="row" style="width: 100px;"><?php _e('Action','wpsp-company');?></th>
                </tr>
            </thead>

            <?php
            if($company){
                $count=0;
                foreach ($company as $comp){

                    ++$count;
                    $supervisor=$wpspcompany->functions->get_company_supervisors_name($comp->id);
                    $supervisor_list= implode(",", $supervisor);
                    ?>
                    <tr>
                        <td><?php echo $count;?></td>
                        <td><?php echo $comp->name; ?></td>
                        <td><?php echo $supervisor_list; ?></td>
                        <td>
                            <a href="<?php echo $section_href_update."&com=".$comp->id; ?>"> <span class="dashicons dashicons-edit wpsp_pointer" onclick=""></span></a>
                            <span class="dashicons dashicons-trash wpsp_pointer" onclick="wpsp_delete_company(<?php echo $comp->id; ?>);"></span>
                        </td>
                    </tr>
                    <?php
                }
            }else{
                echo '<tr><td colspan="4">No records found.</td></tr>';
            }
            ?>
          </table>

    </form>

</div>
