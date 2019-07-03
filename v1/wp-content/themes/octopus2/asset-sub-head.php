<div class="container-fluid">
	
<div class="col-md-12">
      <div class="panel with-nav-tabs panel-orange-top">
			<div style="padding:4px; background-color:#d8931f;">
			<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
			<div class="table-responsive">
								<table class="table table-borderless">
  
																	  <tbody>
																	   <tr>
																	      <th scope="row"><strong>Client:</strong></th>
																	    <td bgcolor="#EBA124"><?php $client_id = get_post_meta( get_the_id(), 'client', true );?><a href="<?php echo get_permalink($client_id);?>" class="text-default"><?php echo get_the_title($client_id);?></a></td>
																	      
																	    </tr>
																	    <tr>
																	      <th scope="row"><strong>Site:</strong></th>
																	      <td bgcolor="#EBA124"><?php $site_id = get_post_meta( get_the_id(), 'site', true );?><a href="<?php echo get_permalink($site_id);?>" class="text-default"><?php echo get_the_title($site_id);?></a></td>
																	    </tr>
																		 <tr>
																	      <th scope="row"><strong>Asset Status:</strong></th>
																	      <td bgcolor="#EBA124"><?php $meta_key = 'asset_status'; $id = get_the_id(); ?><a data-title="Asset Status" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		  <tr>
																	      <th scope="row"><strong>Asset ID:</strong></th>
																	      <td bgcolor="#EBA124"><?php $meta_key = 'asset_id'; $id = get_the_id(); ?><a data-title="Asset ID" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		 <tr>
																	      <th scope="row"><strong>Device Class:</strong></th>
																	      <td bgcolor="#EBA124"><?php echo get_post_meta( get_the_id(), 'device_class', true );?></td>
																	    </tr>
																		  <tr>
																	      <th scope="row"><strong>Netbios Name:</strong></th>
																	    <td bgcolor="#EBA124"><?php $meta_key = 'netbios_name'; $id = get_the_id(); ?><a data-title="Netbios Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
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
																	      <th scope="row"><strong>User:</strong></th>
																	      <td bgcolor="#EBA124"><?php $user_id = get_post_meta( get_the_id(), 'user', true );?><a href="<?php echo get_permalink($user_id);?>" class="list-group-item"><?php echo get_the_title($user_id);?></a></td>
																	      
																	    </tr>
																	    <tr>
																	      <th scope="row"><strong>Email:</strong></th>
																	      <td bgcolor="#EBA124"><?php $meta_key = 'email_address'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Email Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $user_id, 'email_address', true );?></a></td>
																	    </tr>
																		 
																		  <tr>
																	      <th scope="row"><strong>Telephone:</strong></th>
																	      <td bgcolor="#EBA124"><?php $meta_key = 'telephone'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $user_id, 'telephone', true );?></a></td>
																	    </tr>
																		 <tr>
																	      <th scope="row"><strong>Ext:</strong></th>
																	      <td bgcolor="#EBA124"><?php $meta_key = 'ext'; $id = get_post_meta( get_the_id(), 'user', true );?><a class="link-unstyled" data-title="Extension" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $user_id, 'ext', true );?></></td>
																	    </tr>
																		  <tr>
																	      <th scope="row"><strong>Mobile:</strong></th>
																	      <td bgcolor="#EBA124"><?php $meta_key = 'mobile'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Mobile" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $user_id, 'mobile', true );?></a></td>
																	    </tr>
																				<tr>
																	      <th scope="row"></th>
																	      <td bgcolor="#EBA124"></td>
																	    
																	  </tbody>
																	</table>
							</div>
		
		</div>
		<div class="col-md-4">
			<h1>Asset ID: <?php echo get_post_meta( get_the_id(), 'asset_id', true );?> <i class="fas fa-arrow-down"></i></h1>
		</div>
	</div>
</div>
     
			</div>
		</div>