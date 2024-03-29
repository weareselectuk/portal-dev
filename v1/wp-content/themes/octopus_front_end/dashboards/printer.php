
 <?php get_template_part('asset', 'header');?>
	
		
      <div class="panel with-nav-tabs panel-default">
			<ul class="nav nav-tabs" id="interest_tabs">
        <!--top level tabs-->
        <li><a href="#general" data-toggle="tab">General</a></li>
        <li><a href="#guru" data-toggle="tab">Guru</a></li>
        <li><a href="#logins" data-toggle="tab">Logins</a></li>
        <li><a href="#spec" data-toggle="tab">Specifications</a></li>
        <li><a href="#asset_diary" data-toggle="tab">Asset Diary</a></li>
        
       
      </ul>

      <!--top level tab content-->
      <div class="tab-content">
        <!--all tab menu-->
        <div id="general" class="tab-pane">
          <ul class="nav nav-tabs" id="all_tabs" style="background-color:#232C3E;margin-top:-20px;">
            <li><a href="#overview_1" data-toggle="tab">Asset Overview </a></li>
            <li><a href="#purchasing_2" data-toggle="tab">Purchasing Information </a></li>
			       </ul>
        </div>

        <!--guru tab menu-->
        <div id="guru" class="tab-pane">
          <ul class="nav nav-tabs" id="brands_tabs" style="background-color:#232C3E;margin-top:-20px;">
            <li><a href="#guru_maintenance" data-toggle="tab">Maintenance Windows</a></li>
            <li><a href="#guru_security" data-toggle="tab">Security Manager</a></li>
            <li><a href="#guru_patch" data-toggle="tab">Patch Management</a></li>
			         <li><a href="#guru_backup" data-toggle="tab">Backup Management</a></li>
          </ul>
        </div>

        <!--logins tab menu-->
        <div id="logins" class="tab-pane">
          <ul class="nav nav-tabs" id="media_tabs" style="background-color:#232C3E;margin-top:-20px;">
            <li><a href="#logins_local" data-toggle="tab">Local Credentials</a></li>
            <li><a href="#logins_teamviewer" data-toggle="tab">Teamviewer Credentials</a></li>
            <li><a href="#logins_ex05" data-toggle="tab">Ex05</a></li>
												 <li><a href="#logins_vpn" data-toggle="tab">VPN</a></li>
         </ul>
        </div>

        <!--Spec tab menu-->
        <div id="spec" class="tab-pane">
          <ul class="nav nav-tabs" id="music_tabs" style="background-color:#232C3E;margin-top:-20px;">
            <li><a href="#music_popular" data-toggle="tab">Event 1</a></li>
            <li><a href="#music_unique" data-toggle="tab">Event 2</a></li>
          </ul>
        </div>
		
		<!--Asset Diary tab menu-->
        <div id="asset_diary" class="tab-pane">
          <ul class="nav nav-tabs" id="music_tabs" style="background-color:#232C3E;margin-top:-20px;">
            <li><a href="#music_popular" data-toggle="tab">Event 1</a></li>
            <li><a href="#music_unique" data-toggle="tab">Event 2</a></li>
          </ul>
        </div>
 </div>
	  
	  
<!--General tab content-->
      <div class="tab-content">
        <div id="overview_1" class="tab-pane">
          <div class="table-responsive">
          															<table class="table table-striped">
  
																	    <tbody>
																	  	  <tr>
																	      <th scope="row">Manufacturer:</th>
																	      <td><?php $meta_key = 'manufacturer'; $id = get_the_id();?><a data-title="Manufacturer" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Lan IP:</td>
																	      <td><?php $meta_key = 'lan_ip'; $id = get_the_id();?><a data-title="Lan IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Model:</th>
																	      <td><?php $meta_key = 'model'; $id = get_the_id();?><a data-title="Model" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">OS Version:</td>
																	      <td><?php $meta_key = 'os_version'; $id = get_the_id();?><a data-title="OS Version" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Serial No:</th>
																	      <td><?php $meta_key = 'serial_number'; $id = get_the_id();?><a data-title="Serial No" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Date Purchased:</td>
																	      <td><?php $meta_key = 'asset_date_purchased'; $id = get_the_id();?><a data-title="Date Purchased" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		   <tr>
																	      <th scope="row">Service Tag:</th>
																	  	<td><?php $meta_key = 'service_tag_serial_number'; $id = get_the_id();?><a data-title="Service Tag" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    <th scope="row">Ex05 Recovery Key:</th>
																	      <td><?php $meta_key = 'ex05_recovery_key'; $id = get_the_id();?><a data-title="Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		</tr>
																	    <th scope="row">TPN Chip:</th>
																	  	<td><?php $meta_key = 'tpn_chip'; $id = get_the_id();?><a data-title="TPN Chip" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    <th scope="row">WAN IP:</th>
																						<td><?php $meta_key = 'wan_ip'; $id = get_the_id();?><a data-title="WAN IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																					</tbody>
																	</table>
														
          
        														</div>
        </div>
        <div id="purchasing_2" class="tab-pane">
           <div class="table-responsive">
          															<table class="table table-striped">
                      <tbody>
																	  	  <tr>
																	      <th scope="row">Purchase Order No:</th>
																	      <td><?php $meta_key = 'purchase_order_no'; $id = get_the_id();?><a data-title="Purchase Order No" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Purchase Price:</td>
																	      <td><?php $meta_key = 'purchase_price'; $id = get_the_id();?><a data-title="Purchase price" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Purchase Date:</th>
																	      <td><?php $meta_key = 'purchase_date'; $id = get_the_id();?><a data-title="Purchase Date" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Purchase Supplier:</th>
																							<td><?php $meta_key = 'purchase_supplier'; $id = get_the_id();?><a data-title="Purchase Supplier" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																					
																	    </tbody>
																	</table>
															</div>
        </div>
		<div id="general_3" class="tab-pane">
          <i>General 3</i>
        </div>
		
      </div>

      <!--Guru tab content-->
      <div class="tab-content">
        <div id="general_1" class="tab-pane">
          <i>info 1</i>
        </div>
        <div id="general_2" class="tab-pane">
          <i>info 1</i>
        </div>
      </div>
	  
	  <!--Guru tab content-->
      <div class="tab-content">
        <div id="guru_maintenance" class="tab-pane">
          <div class="table-responsive">
          															<table class="table table-striped">
                      <tbody>
																	  	  <tr>
																	      <th scope="row">Patch Setting 1:</th>
																	      <td><?php $meta_key = 'patch_setting_1'; $id = get_the_id();?><a data-title="Patch Setting 1" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Patch Setting 2:</td>
																	      <td><?php $meta_key = 'patch_setting_2'; $id = get_the_id();?><a data-title="Patch Setting 2" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Patch Setting 3:</th>
																	      <td><?php $meta_key = 'patch_setting_3'; $id = get_the_id();?><a data-title="Patch Setting 3" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Patch Setting 4:</td>
																	      <td><?php $meta_key = 'patch_setting_4'; $id = get_the_id();?><a data-title="Patch Setting 4" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																					<tr>
																	      <th scope="row">AV Update:</th>
																	      <td><?php $meta_key = 'av_update'; $id = get_the_id();?><a data-title="AV Update" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">AV Quick Scan:</td>
																	      <td><?php $meta_key = 'AV_Quick_Scan'; $id = get_the_id();?><a data-title="AV Quick Scan" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      
																					</tr>
																					<tr>
																	      <th scope="row">AV Full Scan:</th>
																	      <td colspan="3"><?php $meta_key = 'av_full_scan'; $id = get_the_id();?><a data-title="AV Full Scan" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	     </tr>
																	    </tbody>
																	</table>
															</div>
        </div>
        <div id="guru_security" class="tab-pane">
         <div class="table-responsive">
          															<table class="table table-striped">
                      <tbody>
																	  	  <tr>
																	      <th scope="row">AV Installed:</th>
																	      <td><?php $meta_key = 'av_installed'; $id = get_the_id();?><a data-title="AV Installed" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">AV Profile - Desktops & Laptops:</td>
																	      <td><?php $meta_key = 'AV_Profile_Desktops_Laptops'; $id = get_the_id();?><a data-title="AV Profile - Desktops & Laptops" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">AV Profile - Servers:</th>
																	      <td colspan="3"><?php $meta_key = 'AV_Profile_Servers'; $id = get_the_id();?><a data-title="AV Profile - Servers" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	     
																	    </tr>
																					
																	    </tbody>
																	</table>
															</div>
        </div>
		<div id="guru_patch" class="tab-pane">
         <div class="table-responsive">
          															<table class="table table-striped">
                      <tbody>
																	  	  <tr>
																	      <th scope="row">Patch Installed:</th>
																	      <td><?php $meta_key = 'patch_installed'; $id = get_the_id();?><a data-title="Patch Installed" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Patch Laptops:</td>
																	      <td><?php $meta_key = 'patch_profile_Laptops'; $id = get_the_id();?><a data-title="Patch Laptops" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">3rd Party Patching:</th>
																	      <td colspan="3"><?php $meta_key = '3rd_Party_Patching'; $id = get_the_id();?><a data-title="3rd Party Patching" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	     
																	    </tr>
																					
																	    </tbody>
																	</table>
															</div>
        </div>
		<div id="guru_backup" class="tab-pane">
          <div class="table-responsive">
          															<table class="table table-striped">
                      <tbody>
																	  	  <tr>
																	      <th scope="row">MSP Backup Schedule:</th>
																	      <td><?php $meta_key = 'msp_backup_schedule'; $id = get_the_id();?><a data-title="MSP Backup Schedule" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Local Speed Vault UNC:</td>
																	      <td><?php $meta_key = 'local_speed_vault_unc'; $id = get_the_id();?><a data-title="Local Speed Vault UNC" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Days</th>
																	      <td colspan="3"><?php $meta_key = 'days'; $id = get_the_id();?><a data-title="Days" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	     
																	    </tr>
																					
																	    </tbody>
																	</table>
															</div>
        </div>
		
      </div>
	  
	  <!--Logins tab content-->
      <div class="tab-content">
        <div id="logins_local" class="tab-pane">
        <div class="table-responsive">
          															<table class="table table-striped">
                      <tbody>
																	  	  <tr>
																	      <th scope="row">Local Admin Username:</th>
																	      <td><?php $meta_key = 'local_admin_username'; $id = get_the_id();?><a data-title="Local Admin Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Local Username:</td>
																	      <td><?php $meta_key = 'local_username'; $id = get_the_id();?><a data-title="Local Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Local Admin Password:</th>
																	      <td><?php $meta_key = 'local_admin_password'; $id = get_the_id();?><a data-title="Local Admin Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Local Password:</td>
																	      <td><?php $meta_key = 'local_password'; $id = get_the_id();?><a data-title="Local Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																					<tr>
																	      <th scope="row">Bios Password</th>
																	      <td><?php $meta_key = 'bios_password'; $id = get_the_id();?><a data-title="BIOS Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Screensaver Password:</td>
																	      <td><?php $meta_key = 'local_password'; $id = get_the_id();?><a data-title="Screensaver Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	   
																	   </tbody>
																	</table>
															</div>
        </div>
        <div id="logins_teamviewer" class="tab-pane">
          <div class="table-responsive">
          															<table class="table table-striped">
    <tbody>
																	  	  <tr>
																	      <th scope="row">Teamviewer ID:</th>
																	      <td><?php $meta_key = 'teamviewer_id'; $id = get_the_id();?><a data-title="Teamviewer ID" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Teamviewer Password:</td>
																	      <td><?php $meta_key = 'teamviewer_password'; $id = get_the_id();?><a data-title="teamviewer Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	   </tbody>
																	</table>
															</div>
        </div>
		<div id="logins_ex05" class="tab-pane">
          <div class="table-responsive">
          															<table class="table table-striped">
                   <tbody>
																	  	  <tr>
																	      <th scope="row">Ex05 License:</th>
																	      <td><?php $meta_key = 'ex05_licence'; $id = get_the_id();?><a data-title="Ex05 License" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Ex05 PIN</td>
																	      <td><?php $meta_key = 'ex05_recovery_key'; $id = get_the_id();?><a data-title="Ex05 Recovery Key" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Ex05 Recovery Key:</th>
																	      <td><?php $meta_key = 'ex05_recovery_key'; $id = get_the_id();?><a data-title="Ex05 Recovery Key" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Local Password:</td>
																	      <td><?php $meta_key = 'local_password'; $id = get_the_id();?><a data-title="Local Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	   
																	   </tbody>
																	     </table>
															</div>
        </div>
		<div id="logins_vpn" class="tab-pane">
          <div class="table-responsive">
          															<table class="table table-striped">
    <tbody>
																	  	  <tr>
																	      <th scope="row">VPN Server:</th>
																	      <td><?php $meta_key = 'vpn_server'; $id = get_the_id();?><a data-title="VPN Server" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">VPN Domain:</td>
																	      <td><?php $meta_key = 'vpn_domain'; $id = get_the_id();?><a data-title="VPN Domain" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	   </tbody>
																	</table>
															</div>
        </div>
		
      </div>

  </div>
						
						
		</div>
		</div>



