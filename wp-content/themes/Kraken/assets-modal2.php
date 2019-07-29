<!--

Modals for the client dashboard, under the asset tab

Last updated: 05/09/2018

-->
<!-- Asset Status -->
<div class="modal fade bd-example-modal-lg" id="assetstatus2_<?php echo $current_meta['field_KQ13'];?>"
  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Asset Status</h5>
        
          
       
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tbody>
                <tr>
                  <th scope="row"><strong>Asset Status:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'asset_status'; $id = get_the_id(); ?><a data-title="Asset Status" href="#" id="asset-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active',text:'Active'},{value:'Not Active',text:'Not Active'},{value:'None',text:'None'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>

<!-- Guru License -->

<div class="modal fade" id="assetprolicense2_<?php echo $current_meta['field_KQ13'];?>" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Guru License</h5>
        
          
       
      </div>
      <div class="modal-body">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <tbody>
                  <tr>
                    <th scope="row"><strong>NMC License Type:</strong></th>
                    <td>
                      <?php $meta_key = 'pro_license'; $id = get_the_id(); ?><a data-title="License Type" href="#" id="user-status"
                        name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Pro',text:'Pro'},{value:'Essentials',text:'Essentials'},{value:'None',text:'None'}]"
                        data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
       

      </div>
    </div>
  </div>
</div>
<!-- Asset Backup -->
<div class="modal fade bd-example-modal-lg" id="assetbackup2_<?php echo $current_meta['field_KQ13'];?>"
  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Asset Backup</h5>
        
          
       
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tbody>
                <tr>
                  <th scope="row"><strong>MSP Backup schedule:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'msp_backup_schedule'; $id = get_the_id();?>
                    <a data-title="MSP Backup Schedule" href="#" id="text-field" name="<?php echo $meta_key;?>"
                      data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Local Speed Vault UNC: </strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'local_speed_vault_unc'; $id = get_the_id();?>
                    <a data-title="Local Speed Vault UNC" href="#" id="text-field" name="<?php echo $meta_key;?>"
                      data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>

                <tr>
                  <th scope="row"><strong>Backup Source:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'backup_source'; $id = get_the_id(); ?>
                    <a data-title="Backup Sources" href="#" id="backup_source" name="<?php echo $meta_key;?>" data-type="checklist"
                      data-value="" data-source="[{value:'vmware' ,text:'VMware'},{value:'system_state',text:'System State'},{value:'ms_sql',text:'MS SQl'},{value:'network_shares',text:'Network Shares'},{value:'hyper_v',text:'Hyper V'}]"
                      data-pk="<?php echo $id;?>" url="/post" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Days:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'days'; $id = get_the_id();?>
                    <a data-title="Days" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>


              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
       

      </div>
    </div>
  </div>
</div>


<!-- Patch Management -->
<div class="modal fade" id="assetpatchmanagement2_<?php echo $current_meta['field_KQ13'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Patch Management</h5>
        
          
       
      </div>
      <div class="modal-body">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <tbody>
                  <tr>
                    <th scope="row"><strong>Patch Installed:</strong></th>
                    <td colspan="3">
                      <?php $meta_key = 'patch_installed'; $id = get_the_id();?>
                      <a data-title="Patch Installed" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                        data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row"><strong>Patch Profile:</strong></th>
                    <td colspan="3">
                      <?php $meta_key = '3rd_Party_Profile'; $id = get_the_id();?>
                      <a data-title="3rd Party Profile" href="#" id="text-field" name="<?php echo $meta_key;?>"
                        data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row"><strong>3rd Party Patching:</strong></th>
                    <td colspan="3">
                      <?php $meta_key = '3rd_Party_Patching'; $id = get_the_id();?>
                      <a data-title="3rd Party Patching" href="#" id="text-field" name="<?php echo $meta_key;?>"
                        data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                  </tr>

                  <tr>
                    <th scope="row"><strong>Patch Detection:</strong></th>
                    <td colspan="3">
                      <?php $meta_key = 'patch_setting_1'; $id = get_the_id();?>
                      <a data-title="Patch Detection" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                        data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row"><strong>Patch Pre Download:</strong></th>
                    <td colspan="3">
                      <?php $meta_key = 'patch_setting_2'; $id = get_the_id();?>
                      <a data-title="Patch Pre Download" href="#" id="text-field" name="<?php echo $meta_key;?>"
                        data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row"><strong>Patch Installation:</strong></th>
                    <td colspan="3">
                      <?php $meta_key = 'patch_setting_3'; $id = get_the_id();?>
                      <a data-title="Patch Installation" href="#" id="text-field" name="<?php echo $meta_key;?>"
                        data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row"><strong>Patch reboot:</strong></th>
                    <td colspan="3">
                      <?php $meta_key = 'patch_setting_4'; $id = get_the_id();?>
                      <a data-title="Patch reboot" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                        data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
       

      </div>
    </div>
  </div>
</div>



<!--logins -->

<div class="modal fade bd-example-modal-lg" id="assetlogins2_<?php echo $current_meta['field_KQ13'];?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Asset Logins</h5>
        
          
       
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tbody>
                <tr>
                  <th scope="row"><strong>Local Admin Username:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'local_admin_username'; $id = get_the_id();?>
                    <a data-title="Local Admin Username" href="#" id="text-field" name="<?php echo $meta_key;?>"
                      data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>

                </tr>
                <tr>
                  <th scope="row"><strong>Local Admin Password:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'local_admin_password'; $id = get_the_id();?>
                    <a data-title="Local Admin Password" href="#" id="text-field" name="<?php echo $meta_key;?>"
                      data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                <tr>
                  <th scope="row"><strong>Local Username:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'local_username'; $id = get_the_id();?>
                    <a data-title="Local Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Local Password:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'local_password'; $id = get_the_id();?>
                    <a data-title="Local Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>

                <tr>
                  <th scope="row"><strong>Bios Password:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'bios_password'; $id = get_the_id();?>
                    <a data-title="BIOS Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <th scope="row"><strong>Teamviewer ID:</strong></th>
                <td colspan="3">
                  <?php $meta_key = 'teamviewer_id'; $id = get_the_id();?>
                  <a data-title="Teamviewer ID" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                    data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                    <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                  </a>
                </td>
                </tr>
                <th scope="row"><strong>Teamviewer Password:</strong></th>
                <td colspan="3">
                  <?php $meta_key = 'teamviewer_password'; $id = get_the_id();?>
                  <a data-title="teamviewer Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                    data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                    <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                  </a>
                </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
       

      </div>
    </div>
  </div>
</div>

<!--Ex05-->

<div class="modal fade bd-example-modal-lg" id="assetex052_<?php echo $current_meta['field_KQ13'];?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Encryption</h5>
        
          
       
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tbody>
                <tr>
                  <th scope="row"><strong>EX05 License:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'ex05_licence'; $id = get_the_id();?>
                    <a data-title="Ex05 License" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>

                </tr>
                <tr>
                  <th scope="row"><strong>EX05 Recovery Key:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'ex05_recovery_key'; $id = get_the_id();?>
                    <a data-title="Ex05 Recovery Key" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>EX05 PIN:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'ex05_recovery_pin'; $id = get_the_id();?>
                    <a data-title="Ex05 Recovery Key" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>OSX FileVault Recovery Key:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'filevault_recovery_key'; $id = get_the_id();?>
                    <a data-title="FileVault Recovery Key" href="#" id="text-field" name="<?php echo $meta_key;?>"
                      data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>


              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
       

      </div>
    </div>
  </div>
</div>

<!--Security-->

<div class="modal fade bd-example-modal-lg" id="assetsecurity2_<?php echo $current_meta['field_KQ13'];?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Security Manager</h5>
        
          
       
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tbody>
                <tr>
                  <th scope="row"><strong>AV Installed:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'av_installed'; $id = get_the_id();?>
                    <a data-title="AV Installed" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>

                </tr>

                <tr>
                  <th scope="row"><strong>AV Profile:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'AV_Profile_Desktops'; $id = get_the_id();?>
                    <a data-title="AV Profile - Workstation" href="#" id="text-field" name="<?php echo $meta_key;?>"
                      data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>AV Full Scan:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'av_full_scan'; $id = get_the_id();?>
                    <a data-title="AV Full Scan" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>AV Quick Scan:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'AV_Quick_Scan'; $id = get_the_id();?>
                    <a data-title="AV Quick Scan" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>



              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
       

      </div>
    </div>
  </div>
</div>

<!--Specs-->

<div class="modal fade bd-example-modal-lg" id="assetspecs2_<?php echo $current_meta['field_KQ13'];?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Asset Specifications</h5>
        
          
       
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tbody>
                <tr>
                  <th scope="row"><strong>Manufacturer:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'manufacturer'; $id = get_the_id();?>
                    <a data-title="Manufacturer" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Model:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'model'; $id = get_the_id();?>
                    <a data-title="Model" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>OS Version:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'os_version'; $id = get_the_id();?>
                    <a data-title="OS Version" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Serial Number:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'serial_number'; $id = get_the_id();?>
                    <a data-title="Serial No" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Service Tag:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'service_tag_serial_number'; $id = get_the_id();?>
                    <a data-title="Service Tag" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>


                </tr>


              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
       

      </div>
    </div>
  </div>
</div>
<!--Warranty & Purchasing information-->

<div class="modal fade bd-example-modal-lg" id="assetwarranty2_<?php echo $current_meta['field_KQ13'];?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Warranty & Purchasing information</h5>
        
          
       
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tbody>
                <tr>
                  <th scope="row"><strong>Purchase Order No:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'purchase_order_no'; $id = get_the_id();?>
                    <a data-title="Purchase Order No" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Purchase Price:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'purchase_price'; $id = get_the_id();?>
                    <a data-title="Purchase price" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Purchase Date:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'purchase_date'; $id = get_the_id();?>
                    <a data-title="Purchase Date" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Purchase Supplier:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'purchase_supplier'; $id = get_the_id();?>
                    <a data-title="Purchase Supplier" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Warranty Description:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'warranty_description'; $id = get_the_id();?>
                    <a data-title="Warranty Description" href="#" id="text-field" name="<?php echo $meta_key;?>"
                      data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Warranty Expiry:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'warranty_expiry'; $id = get_the_id();?>
                    <a data-title="Warranty Expiry" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text"
                      data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Warranty Reference:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'warranty_reference'; $id = get_the_id();?>
                    <a data-title="Warranty Reference" href="#" id="text-field" name="<?php echo $meta_key;?>"
                      data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><strong>Warranty Registration:</strong>
                  </th>
                  <td>
                    <?php $meta_key = 'warrranty_registration'; $id = get_the_id();?>
                    <a data-title="Warranty Registration" href="#" id="text-field" name="<?php echo $meta_key;?>"
                      data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                </tr>


              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
       

      </div>
    </div>
  </div>
</div>


<!-- Asset Tickets -->
<div class="modal fade bd-example-modal-lg" id="assettickets2_<?php echo $current_meta['field_KQ13'];?>"
  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Asset Tickets</h5>
        
          
       
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tbody>
                <tr>
                  <th scope="row"><strong>Asset Status:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'asset_status'; $id = get_the_id(); ?><a data-title="Asset Status" href="#" id="asset-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active',text:'Active'},{value:'Not Active',text:'Not Active'},{value:'None',text:'None'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>

<!-- Asset Diary -->
<div class="modal fade bd-example-modal-lg" id="supportdiary2_<?php echo $current_meta['field_KQ13'];?>"
  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Asset Diary</h5>
        
          
       
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tbody>
                <tr>
                  <th scope="row"><strong>Asset Status:</strong></th>
                  <td colspan="3">
                    <?php $meta_key = 'asset_status'; $id = get_the_id(); ?><a data-title="Asset Status" href="#" id="asset-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active',text:'Active'},{value:'Not Active',text:'Not Active'},{value:'None',text:'None'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>