<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
						<div class="panel-heading">
							<h5 class="panel-title">Firewall Dashboard for asset: <strong><?php echo get_post_meta( get_the_id(), 'asset_id', true );?></strong></h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                	<li><a data-action="collapse"></a></li>
			                   <li><a data-action="close"></a></li>
							   <li><i class="glyphicon glyphicon-print"></i></li>
			                	</ul>
		                	</div>
						</div>
			
				<div class="panel-body">
					<div class="table-responsive">
          															<table class="table table-striped">
  
																	  <tbody>
																	  	

																	    <tr>
																	      <th scope="row">Host</th>
																	      <td><?php $meta_key = 'manufacturer'; $id = get_the_id();?><a data-title="Manufacturer" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">FTP Port</td>
																	      <td><?php $meta_key = 'local_admin_username'; $id = get_the_id();?><a data-title="Local Admin Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">cPanel Username:</th>
																	      <td><?php $meta_key = 'model'; $id = get_the_id();?><a data-title="Model" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">cPanel Password:</td>
																	      <td><?php $meta_key = 'admin_url'; $id = get_the_id();?><a data-title="Admin URL" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Package:</th>
																	      <td><?php $meta_key = 'serial_number'; $id = get_the_id();?><a data-title="Serial No" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Server:</td>
																	      <td><?php $meta_key = 'service_tag_serial_number'; $id = get_the_id();?><a data-title="Service Tag" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    
																	    <tr>
																	      <th scope="row">Hosting Status:</th>
																	  	<td><?php $meta_key = 'lan_ip'; $id = get_the_id();?><a data-title="LAN IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    <th scope="row">cPanel Login URL:</th>
																	      <td><?php $meta_key = 'wan_ip'; $id = get_the_id();?><a data-title="WAN IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		</tr>
																		<th scope="row">Username:</th>
																	  	<td><?php $meta_key = 'username'; $id = get_the_id();?><a data-title="Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    <th scope="row">Password:</th>
																	      <td><?php $meta_key = 'password'; $id = get_the_id();?><a data-title="Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		</tr>
																	  </tbody>
																	</table>
          
        														</div>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h5 class="panel-title">Asset Overview</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                			<li><a data-action="collapse"></a></li>
			                   <li><a data-action="close"></a></li>
																						<li><i class="glyphicon glyphicon-print"></i></li>
			                	</ul>
		                	</div>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped">
  
																	  <tbody>
																	  	

																	    <tr>
																	      <th scope="row">Client:</th>
																	      <td><?php $client_id = get_post_meta( get_the_id(), 'client', true );?><a href="<?php echo get_permalink($client_id);?>" class="text-default"><?php echo get_the_title($client_id);?></a></td>
																	      
																	    </tr>
																	    <tr>
																	      <th scope="row">Site:</th>
																	      <td><?php $site_id = get_post_meta( get_the_id(), 'site', true );?><a href="<?php echo get_permalink($site_id);?>" class="text-default"><?php echo get_the_title($site_id);?></a></td>
																	    </tr>
																		 <tr>
																	      <th scope="row">Asset Status:</th>
																	      <td><?php $meta_key = 'asset_status'; $id = get_the_id(); ?><a data-title="Asset Status" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		  <tr>
																	      <th scope="row">Asset ID:</th>
																	      <td><?php $meta_key = 'asset_id'; $id = get_the_id(); ?><a data-title="Asset ID" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		 <tr>
																	      <th scope="row">Device Class:</th>
																	      <td><?php echo get_post_meta( get_the_id(), 'device_class', true );?></td>
																	    </tr>
																		  <tr>
																	      <th scope="row">Netbios Name:</th>
																	    <td><?php $meta_key = 'netbios_name'; $id = get_the_id(); ?><a data-title="Netbios Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    
																	  </tbody>
																	</table>
									
						    	
					    	</div>
						</div>
						
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h5 class="panel-title">Assigned To User</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                			<li><a data-action="collapse"></a></li>
			                   <li><a data-action="close"></a></li>
																						<li><i class="glyphicon glyphicon-print"></i></li>
			                	</ul>
		                	</div>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped">
  
																	  <tbody>
																	  	

																	    <tr>
																	      <th scope="row">User:</th>
																	      <td><?php $user_id = get_post_meta( get_the_id(), 'user', true );?><a href="<?php echo get_permalink($user_id);?>" class="list-group-item"><?php echo get_the_title($user_id);?></a></td>
																	      
																	    </tr>
																	    <tr>
																	      <th scope="row">Email:</th>
																	      <td><?php $meta_key = 'email_address'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Email Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $user_id, 'email_address', true );?></a></td>
																	    </tr>
																		 
																		  <tr>
																	      <th scope="row">Telephone:</th>
																	      <td><?php $meta_key = 'telephone'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $user_id, 'telephone', true );?></a></td>
																	    </tr>
																		 <tr>
																	      <th scope="row">Ext:</th>
																	      <td><?php $meta_key = 'ext'; $id = get_post_meta( get_the_id(), 'user', true );?><a class="link-unstyled" data-title="Extension" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $user_id, 'ext', true );?></></td>
																	    </tr>
																		  <tr>
																	      <th scope="row">Mobile:</th>
																	      <td><?php $meta_key = 'mobile'; $id = get_post_meta( get_the_id(), 'user', true );?><a data-title="Mobile" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $user_id, 'mobile', true );?></a></td>
																	    </tr>
																	    
																	  </tbody>
																	</table>
							</div>
						</div>
						
			</div>
		</div>
	</div>
</div>

<?php get_template_part('footer', 'simple');?>

     

<?php get_footer(); ?>