
      <div class="panel with-nav-tabs panel-default">
			<ul class="nav nav-tabs">
        <!--top level tabs-->
        <li class="active"><a href="#general" data-toggle="tab">General</a></li>
        <li><a href="#guru" data-toggle="tab">Guru</a></li>
        <li><a href="#logins" data-toggle="tab">Logins</a></li>
    </ul>

      <!--top level tab content-->
      <div class="tab-content">
        <!--all tab menu-->
        <div id="general" class="tab-pane fade active in">
         <ul class="nav nav-tabs" role="tablist" id="myTab" style="background-color:#232C3E;margin-top:-20px;">
          <!--<ul class="nav nav-tabs" style="background-color:#232C3E;margin-top:-20px;">-->
             <li class="active"><a href="#overview_1" role="tab" data-toggle="tab">Asset Overview </a></li>
            <li><a href="#purchasing_2" data-toggle="tab">Purchasing & Warranty Information</a></li>
			       </ul>
       	  
<!--General tab content-->
      <div class="tab-content">
        <div id="overview_1" class="tab-pane active">
          <div class="table-responsive">
          															<table class="table table-striped">
  
																	    <tbody>
																	  	  <tr>
																	      <th scope="row">Manufacturer:</th>
																	      <td><?php $meta_key = 'manufacturer'; $id = get_the_id();?><a data-title="Manufacturer" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Lan IP:</th>
																	      <td><?php $meta_key = 'lan_ip'; $id = get_the_id();?><a data-title="Lan IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Model:</th>
																	      <td><?php $meta_key = 'model'; $id = get_the_id();?><a data-title="Model" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">OS Version:</th>
																	      <td><?php $meta_key = 'os_version'; $id = get_the_id();?><a data-title="OS Version" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Serial No:</th>
																	      <td><?php $meta_key = 'serial_number'; $id = get_the_id();?><a data-title="Serial No" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">WAN IP:</th>
																	      <td><?php $meta_key = 'wan_ip'; $id = get_the_id();?><a data-title="WAN IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
                     <tr>
																	      <th scope="row">Service Tag:</th>
																	      <td><?php $meta_key = 'service_tag_serial_number'; $id = get_the_id();?><a data-title="Service Tag" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Ex05 Recovery Key:</th>
																	      <td><?php $meta_key = 'ex05_recovery_key'; $id = get_the_id();?><a data-title="WAN IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		   </tbody>
																	</table>
														
          
        														</div>
        </div>
      
        <div id="purchasing_2" class="tab-pane">
           <div class="table-responsive">
          															<table class="table table-striped">
                      <tbody>
																	  	  <tr>
																	      <th scope="row"><strong>Purchase Order No:</strong></th>
																	      <td><?php $meta_key = 'purchase_order_no'; $id = get_the_id();?><a data-title="Purchase Order No" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row"><strong>Purchase Price:</strong></th>
																	      <td><?php $meta_key = 'purchase_price'; $id = get_the_id();?><a data-title="Purchase price" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row"><strong>Purchase Date:</strong></th>
																	      <td><?php $meta_key = 'purchase_date'; $id = get_the_id();?><a data-title="Purchase Date" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row"><strong>Purchase Supplier:</strong></th>
																							<td><?php $meta_key = 'purchase_supplier'; $id = get_the_id();?><a data-title="Purchase Supplier" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
                     <tr>
																	      <th scope="row"><strong>Warranty Description:</strong></th>
																	      <td><?php $meta_key = 'warranty_description'; $id = get_the_id();?><a data-title="Warranty Description" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row"><strong>Warranty Expiry:</strong></th>
																							<td><?php $meta_key = 'warranty_expiry'; $id = get_the_id();?><a data-title="Warranty Expiry" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
                     <tr>
																	      <th scope="row"><strong>Warranty Reference:</strong></th>
																	      <td><?php $meta_key = 'warranty_reference'; $id = get_the_id();?><a data-title="Warranty Reference" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row"><strong>Warranty Registration:</strong></th>
																							<td><?php $meta_key = 'warrranty_registration'; $id = get_the_id();?><a data-title="Warranty Registration" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																					
																	    </tbody>
																	</table>
															</div>
        </div>
		
		
			</div>
			</div>
 <!--guru tab menu-->
 <div id="guru" class="tab-pane fade">
		<ul class="nav nav-tabs" style="background-color:#232C3E;margin-top:-20px;">
			<li style="active"><a href="#guru_maintenance" data-toggle="tab">Maintenance Windows</a></li>
			<li><a href="#guru_security" data-toggle="tab">Security Manager</a></li>
			<li><a href="#guru_patch" data-toggle="tab">Patch Management</a></li>
				 <li><a href="#guru_backup" data-toggle="tab">Backup Management</a></li>
		</ul>
	
      	  
	  <!--Guru tab content-->
      <div class="tab-content">
        <div id="guru_maintenance" class="tab-pane fade active in">
          <div class="table-responsive">
          															<table class="table table-striped">
                      <tbody>
																	  	  <tr>
																	      <td scope="row">Patch Setting 1:</td>
																	      <td><?php $meta_key = 'patch_setting_1'; $id = get_the_id();?><a data-title="Patch Setting 1" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">AV Quick Scan:</th>
                       <td><?php $meta_key = 'av_quick_scan'; $id = get_the_id();?><a data-title="AV Quick Scan" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <td scope="row">Patch Setting 2:</td>
																	      <td><?php $meta_key = 'patch_setting_2'; $id = get_the_id();?><a data-title="Patch Setting 2" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <td scope="row">AV Update:</td>
																	      <td><?php $meta_key = 'av_update'; $id = get_the_id();?><a data-title="AV Update" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																					<tr>
																	      <td scope="row">Patch Setting 3:</td>
																	      <td><?php $meta_key = 'patch_setting_3'; $id = get_the_id();?><a data-title="Patch Setting 3" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <td scope="row">AV Full Scan</td>
																	      <td><?php $meta_key = 'av_quick_scan'; $id = get_the_id();?><a data-title="AV Quick Scan" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      
																					</tr>
																					<tr>
                       <th scope="row">Patch Setting 4:</th>
																	      
																	      <td colspan="3"><?php $meta_key = 'patch_setting_4'; $id = get_the_id();?><a data-title="Patch Setting 4" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	     </tr>
																	    </tbody>
																	</table>
															</div>
        </div>
        <div id="guru_security" class="tab-pane fade">
         <div class="table-responsive">
          															<table class="table table-striped">
                      <tbody>
																	  	  <tr>
																	      <th scope="row">AV Installed:</th>
																	      <td><?php $meta_key = 'av_installed'; $id = get_the_id();?><a data-title="AV Installed" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">AV Profile - Desktops & Laptops:</th>
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
		<div id="guru_patch" class="tab-pane fade">
         <div class="table-responsive">
          															<table class="table table-striped">
                      <tbody>
																	  	  <tr>
																	      <th scope="row">Patch Installed:</th>
																	      <td><?php $meta_key = 'patch_installed'; $id = get_the_id();?><a data-title="Patch Installed" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Patch Laptops:</th>
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
		<div id="guru_backup" class="tab-pane fade">
          <div class="table-responsive">
          															<table class="table table-striped">
                      <tbody>
																	  	  <tr>
																	      <th scope="row">MSP Backup Schedule:</th>
																	      <td><?php $meta_key = 'msp_backup_schedule'; $id = get_the_id();?><a data-title="MSP Backup Schedule" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Local Speed Vault UNC:</th>
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
			</div>
		
				<!--logins tab menu-->
	<div id="logins" class="tab-pane fade">
			<ul class="nav nav-tabs" style="background-color:#232C3E;margin-top:-20px;">
				<li class="active"><a href="#logins_local" data-toggle="tab">Local Credentials</a></li>
				<li><a href="#logins_teamviewer" data-toggle="tab">Teamviewer Credentials</a></li>
				<li><a href="#logins_ex05" data-toggle="tab">Ex05</a></li>
										 <li><a href="#logins_vpn" data-toggle="tab">VPN</a></li>
		 </ul>
		
	  <!--Logins tab content-->
      <div class="tab-content">
        <div id="logins_local" class="tab-pane fade active in">
        <div class="table-responsive">
          															<table class="table table-striped">
                      <tbody>
																	  	  <tr>
																	      <th scope="row">Local Admin Username:</th>
																	      <td><?php $meta_key = 'local_admin_username'; $id = get_the_id();?><a data-title="Local Admin Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Local Username:</th>
																	      <td><?php $meta_key = 'local_username'; $id = get_the_id();?><a data-title="Local Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Local Admin Password:</th>
																	      <td><?php $meta_key = 'local_admin_password'; $id = get_the_id();?><a data-title="Local Admin Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Local Password:</th>
																	      <td><?php $meta_key = 'local_password'; $id = get_the_id();?><a data-title="Local Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																					<tr>
																	      <th scope="row">Bios Password</th>
																	      <td><?php $meta_key = 'bios_password'; $id = get_the_id();?><a data-title="BIOS Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Screensaver Password:</th>
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
																	      <th scope="row">Teamviewer Password:</th>
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
																	      <th scope="row">Ex05 PIN</th>
																	      <td><?php $meta_key = 'ex05_recovery_key'; $id = get_the_id();?><a data-title="Ex05 Recovery Key" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Ex05 Recovery Key:</th>
																	      <td><?php $meta_key = 'ex05_recovery_key'; $id = get_the_id();?><a data-title="Ex05 Recovery Key" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Local Password:</th>
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
																	      <th scope="row">VPN Domain:</th>
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