<div class="container-fluid">
	
<div class="col-md-12">
      <div class="panel with-nav-tabs panel-orange-top" style="padding:20px 30px 20px 30px">
			<div style="padding:0px; background-color:#6f4a0d;">
			<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
			<div class="table-responsive">
								<table class="table table-borderless">
  
																	  <tbody>
																	   <tr>
																	      <th scope="row"><i class="far fa-address-card" style="color: #EBA125;"></i><strong style="color: #EBA125;"> Client:</strong></th>
																	    <td bgcolor="#c5861d"><?php $client_id = get_post_meta( get_the_id(), 'client', true );?><a href="<?php echo get_permalink($client_id);?>" class="text-white"><?php echo get_the_title($client_id);?></a></td>
																	      
																	    </tr>
																	    <tr>
																	      <th scope="row"><i class="far fa-building" style="color: #EBA125;"></i><strong style="color: #EBA125;"> Site:</strong></th>
																	      <td bgcolor="#c5861d"><?php $site_id = get_post_meta( get_the_id(), 'site', true );?><a href="<?php echo get_permalink($site_id);?>" class="text-white"><?php echo get_the_title($site_id);?></a></td>
																	    </tr>
																		 <tr>
																	      <th scope="row"><i class="fas fa-ambulance" style="color: #EBA125;"></i><strong style="color: #EBA125;"> Asset Status:</strong></th>
																	      <td bgcolor="#c5861d"><?php $meta_key = 'asset_status'; $id = get_the_id(); ?><a data-title="Asset Status" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		  <tr>
																	      <th scope="row"><i class="fas fa-code-branch" style="color: #EBA125;"></i><strong style="color: #EBA125;"> Asset ID:</strong></th>
																	      <td bgcolor="#c5861d"><?php $meta_key = 'asset_id'; $id = get_the_id(); ?><a data-title="Asset ID" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white editable"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		 <tr>
																	      <th scope="row"><i class="fas fa-laptop" style="color: #EBA125;"></i><strong style="color: #EBA125;"> Device Class:</strong></th>
																	      <td bgcolor="#c5861d"><?php $meta_key = 'device_class'; $id = get_the_id(); ?><a data-title="Device Class" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white editable"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		  <tr>
																	      <th scope="row"><i class="fab fa-connectdevelop" style="color: #EBA125;"></i><strong style="color: #EBA125;"> Netbios Name:</strong></th>
																	    <td bgcolor="#c5861d"><?php $meta_key = 'netbios_name'; $id = get_the_id(); ?><a data-title="Netbios Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white editable"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
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
																	      <th scope="row"><i class="far fa-user" style="color: #EBA125;"></i><strong style="color: #EBA125;"> User:</strong></th>
																	      <td bgcolor="#c5861d"><?php $user_id = get_post_meta( get_the_id(), 'user', true );?><a href="<?php echo get_permalink($user_id);?>" class="text-white editable"><?php echo get_the_title($user_id);?></a></td>
																	      
																	    </tr>
																	    <tr>
																	      <th scope="row"><i class="far fa-envelope" style="color: #EBA125;"></i><strong style="color: #EBA125;"> Email:</strong></th>
																	      <td bgcolor="#c5861d"><?php $meta_key = 'email_address'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Email Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white editable"><?php echo get_post_meta( $user_id, 'email_address', true );?></a></td>
																	    </tr>
																		 
																		  <tr>
																	      <th scope="row"><i class="fas fa-phone-square" style="color: #EBA125;"></i><strong style="color: #EBA125;"> Telephone:</strong></th>
																	      <td bgcolor="#c5861d"><?php $meta_key = 'telephone'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white editable"><?php echo get_post_meta( $user_id, 'telephone', true );?></a></td>
																	    </tr>
																		 <tr>
																	      <th scope="row"><i class="fas fa-list-ol" style="color: #EBA125;"></i><strong style="color: #EBA125;"> Ext:</strong></th>
																	      <td bgcolor="#c5861d"><?php $meta_key = 'ext'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Extension" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white editable"><?php echo get_post_meta( $user_id, 'ext', true );?></a></td>
																	    </tr>
																		  <tr>
																	      <th scope="row"><i class="fas fa-mobile-alt" style="color: #EBA125;"></i><strong style="color: #EBA125;"> Mobile:</strong></th>
																	      <td bgcolor="#c5861d"><?php $meta_key = 'mobile'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Mobile" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-white editable"><?php echo get_post_meta( $user_id, 'mobile', true );?></a></td>
																	    </tr>
																				<tr>
																	      <th scope="row"></th>
																	      <td bgcolor="#c5861d">&nbsp;</td>
																	    
																	  </tbody>
																	</table>
							</div>
		
		</div>
		
	</div>
</div>
     
			</div>
		</div>