<div class="row">
		<div class="col-md-4">
			<div class="panel panel-success">
						<div class="panel-heading">
							<h5 class="panel-title">Key Client Info</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                			<li><a data-action="collapse"></a></li>
			                   <li><a data-action="close"></a></li>
																				</ul>
		                	</div>
						</div>
				<div class="panel-body">
					<div class="table-responsive">
					<table class="table table-striped">
  
																	  <tbody>		  	

<tr>
  <th scope="row">Client Status:</th> <td> <?php $meta_key = 'client_status'; $id = get_the_id(); ?><a data-title="client_status" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>	
	 </tr>
<tr>																		  
  <th scope="row">Type:</th> <td><?php $meta_key = 'type'; $id = get_the_id(); ?><a data-title="Type" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
	<tr>
  <th scope="row">Key Sales Contact:</th> <td><?php $meta_key = 'sales_contact'; $id = get_the_id(); ?><a data-title="Key Sales Contact" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
<tr>
	<th scope="row">Key Tech Contact:</th> <td><?php $meta_key = 'tech_contact'; $id = get_the_id(); ?><a data-title="Key Technical Contact" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>


 
 <tr>
 <th scope="row">Account Manager:</th> <td><?php $meta_key = 'account_manager'; $id = get_the_id(); ?><a data-title="Account Manager" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
 
	</tr>
 
	</tr>
 </tbody>
					</table></div>
					</div>
				</div>
				
			</div>
		
		<div class="col-md-4">
			<div class="panel panel-success">
						<div class="panel-heading">
							<h5 class="panel-title">Domain & TCPIP Setup</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                			<li><a data-action="collapse"></a></li>
			                   <li><a data-action="close"></a></li>
																						
			                	</ul>
		                	</div>
						</div>
			
				<div class="panel-body">
					<div class="table-responsive">
					<table class="table table-striped">
  
																	  <tbody>		  	

  <tr>
  <th scope="row">Domain Setup:</th> <td><?php $meta_key = 'domain_setup'; $id = get_the_id(); ?><a data-title="Domain Setup" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
	<tr>
		<th scope="row">Primary Domain Suffix:</th> <td><?php $meta_key = 'primary_domain_suffix'; $id = get_the_id(); ?><a data-title="Primary Domain Suffix" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td></tr>
<tr>
 <th scope="row">SSO Setup:</th> <td> <?php $meta_key = 'sso_setup'; $id = get_the_id(); ?><a data-title="SSO Setup" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
            

	</tr>
 <tr>
 <th scope="row">DHCP Server:</th><td><?php $meta_key = 'dhcp_server'; $id = get_the_id(); ?><a data-title="DHCP Server" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
  
	</tr>
 <tr>
  <th scope="row">Lan IP Address:</th> <td><?php $meta_key = 'lan_ip'; $id = get_the_id(); ?><a data-title="Lan IP Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
 <tr>
  <th scope="row">Gateway IP Address:</th> <td><?php $meta_key = 'gateway_ip_address'; $id = get_the_id(); ?><a data-title="gateway IP Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
 <tr>
  <th scope="row">Subnet Mask:</th> <td><?php $meta_key = 'subnet_mask'; $id = get_the_id(); ?><a data-title="Subnet Mask" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
 <tr>
  <th scope="row">Primary DNS:</th> <td><?php $meta_key = 'primary_dns'; $id = get_the_id(); ?><a data-title="Primary DNS" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
 <tr>
  <th scope="row">Secondary DNS:</th> <td><?php $meta_key = 'secondary_dns'; $id = get_the_id(); ?><a data-title="Secondary DNS" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
 <tr>
  <th scope="row">WAN IP Address:</th> <td><?php $meta_key = 'wan_ip_address'; $id = get_the_id(); ?><a data-title="WAN IP Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
 </tbody>
																	</table>
				</div>
				</div>
				
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-success">
						<div class="panel-heading">
							<h5 class="panel-title">Email Setup</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                			<li><a data-action="collapse"></a></li>
			                   <li><a data-action="close"></a></li>
																				
			                	</ul>
		                	</div>
						</div>
				
				<div class="panel-body">
					<div class="table-responsive">
					<table class="table table-striped">
  
																	  <tbody>		  	

 <tr>
  <th scope="row">Email Provider:</th> <td><?php $meta_key = 'email_provider'; $id = get_the_id(); ?><a data-title="Email Provider" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
	<tr>
		<th scope="row">Email Admin Login:</th> <td><?php $meta_key = 'email_admin_login'; $id = get_the_id(); ?><a data-title="Email Admin Login" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td></tr>
<tr>
 <th scope="row">Email Admin Password:</th> <td><?php $meta_key = 'email_admin_password'; $id = get_the_id(); ?><a data-title="Email Admin Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
         	</tr>
 <tr>
 <th scope="row">Link To Email Provider:</th><td><?php $meta_key = 'link_to_email_provider'; $id = get_the_id(); ?><a data-title="Link To Email Provider" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
          

<tr>
  <th scope="row">Email Setup Guide:</th> <td><?php $meta_key = 'email_setup_guide'; $id = get_the_id(); ?><a data-title="Email Setup Guide" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
	</tr>
 </tbody>
																	</table>
				</div>
				
			</div>
		</div>
	</div>
</div>