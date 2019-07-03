<div class="container-fluid">
	
<div class="col-md-12">
      <div class="panel with-nav-tabs panel-orange-top" style="padding:20px 30px 20px 30px">
			<div style="padding:0px; background-color:#bd5f0e;">
			<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
			<div class="table-responsive">
								<table class="table table-borderless">
  
																	  <tbody>
																	   <tr>
																	      <th scope="row"><i class="fa fa-address-card" style="color: #ffffff;"></i><strong style="color: #ffffff;"> Assigned To Client:</strong></th>
																	    <td bgcolor="#d56b10"> <?php $client_id = get_post_meta( get_the_id(), 'client', true );?>
                        <a href="<?php echo get_permalink($client_id);?>" class="text-default">
                          <?php echo get_the_title($client_id);?></td>
																	      
																	    </tr>
																	    <tr>
																	      <th scope="row"><i class="fa fa-building" style="color: #ffffff;"></i><strong style="color: #ffffff;"> Assigned To Site:</strong></th>
																	      <td bgcolor="#d56b10"> <?php $site_id = get_post_meta( get_the_id(), 'site', true );?>
                        <a href="<?php echo get_permalink($site_id);?>" class="text-default">
                          <?php echo get_the_title($site_id);?></td>
																	    </tr>
																		 <tr>
																	      <th scope="row"><i class="fa fa-ambulance" style="color: #ffffff;"></i><strong style="color: #ffffff;"> Asset Status:</strong></th>
																	      <td bgcolor="#d56b10"><?php $meta_key = 'asset_status'; $id = get_the_id(); ?><a data-title="Asset Status" href="#" id="asset-status" name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active',text:'Active'},{value:'Not Active',text:'Not Active'},{value:'',text:'Empty'}]" data-pk="<?php echo $id;?>"   class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>	
																	    </tr>
																		  <tr>
																	      <th scope="row"><i class="icon-box" style="color: #ffffff;"></i><strong style="color: #ffffff;"> Asset ID:</strong></th>
																	      <td bgcolor="#d56b10"><?php $meta_key = 'asset_id'; $id = get_the_id(); ?><a data-title="Asset ID" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white editable"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		 <tr>
																	      <th scope="row"><i class="fa fa-laptop" style="color: #ffffff;"></i><strong style="color: #ffffff;"> Device Class:</strong></th>
																	      <td bgcolor="#d56b10"><?php $meta_key = 'device_class'; $id = get_the_id(); ?><a data-title="Device Class" href="#" id="vpn" name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'windows-workstation',text:'Windows Workstation'},{value:'windows-laptop',text:'Windows Laptop'},{value:'laptop-mac',text:'Laptop Mac'},{value:'workstation-mac',text:'Workstation Mac'},{value:'server',text:'Server'},{value:'router',text:'Router'},{value:'printer',text:'Printer'},{value:'switch',text:'Switch'},{value:'storage',text:'Storage'},{value:'scanner-camera',text:'Scanner & Camera'}, {value:'peripheral',text:'Peripheral'}, {value:'access-point',text:'Access Point'}]" data-pk="<?php echo $id;?>"   class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		  <tr>
																	      <th scope="row"><i class="fa fa-connectdevelop" style="color: #ffffff;"></i><strong style="color: #ffffff;"> Netbios Name:</strong></th>
																	    <td bgcolor="#d56b10"><?php $meta_key = 'netbios_name'; $id = get_the_id(); ?><a data-title="Netbios Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white editable"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    
																	  </tbody>
																	</table>
									
						    	
					    	</div>
		</div>
		<div class="col-md-4">
			<div class="table-responsive">
								<table class="table table-borderless">
  
																	  <tbody>
																	  	

																	    <tr>
																	      <th scope="row"><i class="icon-user" style="color: #ffffff;"></i><strong style="color: #ffffff;"> Assigned To User:</strong></th>
																	      <td bgcolor="#d56b10"><?php $user_id = get_post_meta( get_the_id(), 'user', true );?><a href="<?php echo get_permalink($user_id);?>" class="text-white editable"><?php echo get_the_title($user_id);?></a></td>
																	      
																	    </tr>
																	    <tr>
																	      <th scope="row"><i class="fa fa-envelope" style="color: #ffffff;"></i><strong style="color: #ffffff;"> Email:</strong></th>
																	      <td bgcolor="#d56b10"><?php $meta_key = 'email_address'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Email Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white editable"><?php echo get_post_meta( $user_id, 'email_address', true );?></a></td>
																	    </tr>
																		 
																		  <tr>
																	      <th scope="row"><i class="fa fa-phone-square" style="color: #ffffff;"></i><strong style="color: #ffffff;"> Telephone:</strong></th>
																	      <td bgcolor="#d56b10"><?php $meta_key = 'telephone'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white editable"><?php echo get_post_meta( $user_id, 'telephone', true );?></a></td>
																	    </tr>
																		 <tr>
																	      <th scope="row"><i class="fa fa-list-ol" style="color: #ffffff;"></i><strong style="color: #ffffff;"> Ext:</strong></th>
																	      <td bgcolor="#d56b10"><?php $meta_key = 'ext'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Extension" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white editable"><?php echo get_post_meta( $user_id, 'ext', true );?></a></td>
																	    </tr>
																		  <tr>
																	      <th scope="row"><i class="fa fa-mobile" style="color: #ffffff;"></i><strong style="color: #ffffff;"> Mobile:</strong></th>
																	      <td bgcolor="#d56b10"><?php $meta_key = 'mobile'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Mobile" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white editable"><?php echo get_post_meta( $user_id, 'mobile', true );?></a></td>
																	    </tr>
																		  </tr>
																		  <tr>
																	      <th scope="row"></th>
																	      <td bgcolor="#d56b10"></td>
																	    </tr>
																		  <tr>
																	      <th scope="row"></th>
																	      <td bgcolor="#d56b10"></td>
																	    </tr>
																		 </tbody>
																	</table>
							</div>
		
		</div>
		
	</div>
</div>
     
			</div>
		</div>