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
  <th scope="row"><strong>Client Status:</strong></th> <td> <?php $meta_key = 'client_status'; $id = get_the_id(); ?><a data-title="Client Status" href="#" id="client-status" name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active',text:'Active'},{value:'Not Active',text:'Not Active'},{value:'',text:'Empty'}]" data-pk="<?php echo $id;?>"   class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>	
	 </tr>
<tr>																		  
  
																		  </tr>
	<tr>
  <th scope="row"><strong>Key Sales Contact:</strong></th> <td><?php $meta_key = 'sales_contact'; $id = get_the_id(); ?><a data-title="Key Sales Contact" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
<tr>
	<th scope="row"><strong>Key Tech Contact:</strong></th> <td><?php $meta_key = 'tech_contact'; $id = get_the_id(); ?><a data-title="Key Technical Contact" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>

<tr>
 <th scope="row"><strong>Key Contact for Approval:</strong></th> <td><?php $meta_key = 'approval_contact'; $id = get_the_id(); ?><a data-title="Key Contact for Approval" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
 
 <tr>
 <th scope="row"><strong>Account Manager:</strong></th> <td><?php $meta_key = 'account_manager'; $id = get_the_id(); ?><a data-title="Account Manager" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
 
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
  <th scope="row"><strong>Domain Setup:</strong></th> <td><?php $meta_key = 'domain_setup'; $id = get_the_id(); ?><a data-title="Domain Setup" href="#" id="vpn" name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Yes',text:'Yes'},{value:'Not',text:'No'},{value:'',text:'Empty'}]" data-pk="<?php echo $id;?>"   class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>	
	<tr>
		<th scope="row"><strong>Primary Domain Suffix:</strong></th> <td><?php $meta_key = 'primary_domain_suffix'; $id = get_the_id(); ?><a data-title="Primary Domain Suffix" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td></tr>
<tr>
 <th scope="row"><strong>SSO Setup:</strong></th> <td> <?php $meta_key = 'sso_setup'; $id = get_the_id(); ?><a data-title="SSO Setup" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
            

	</tr>
 <tr>
 <th scope="row"><strong>DHCP Server:</strong></th><td><?php $meta_key = 'dhcp_server'; $id = get_the_id(); ?><a data-title="DHCP Server" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
  
	</tr>
 <tr>
  <th scope="row"><strong>Lan IP Address:</strong></th> <td><?php $meta_key = 'lan_ip'; $id = get_the_id(); ?><a data-title="Lan IP Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
 <tr>
  <th scope="row"><strong>Gateway IP Address:</strong></th> <td><?php $meta_key = 'gateway_ip_address'; $id = get_the_id(); ?><a data-title="gateway IP Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
 <tr>
  <th scope="row"><strong>Subnet Mask:</strong></th> <td><?php $meta_key = 'subnet_mask'; $id = get_the_id(); ?><a data-title="Subnet Mask" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
 <tr>
  <th scope="row"><strong>Primary DNS:</strong></th> <td><?php $meta_key = 'primary_dns'; $id = get_the_id(); ?><a data-title="Primary DNS" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
 <tr>
  <th scope="row"><strong>Secondary DNS:</strong></th> <td><?php $meta_key = 'secondary_dns'; $id = get_the_id(); ?><a data-title="Secondary DNS" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
 <tr>
  <th scope="row"><strong>WAN IP Address:</strong></th> <td><?php $meta_key = 'wan_ip_address'; $id = get_the_id(); ?><a data-title="WAN IP Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
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
  <th scope="row"><strong>Email Provider:</strong></th> <td><?php $meta_key = 'email_provider'; $id = get_the_id(); ?><a data-title="Email Provider" href="#" id="vpn" name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Gsuite',text:'GSuite'},{value:'Office 365',text:'Office 365'},{value:'Empty',text:'Empty'}]" data-pk="<?php echo $id;?>"   class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>	
																		  </tr>
	<tr>
		<th scope="row"><strong>Email Admin Login:</strong></th> <td><?php $meta_key = 'email_admin_login'; $id = get_the_id(); ?><a data-title="Email Admin Login" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td></tr>
<tr>
 <th scope="row"><strong>Email Admin Password:</strong></th> <td><?php $meta_key = 'email_admin_password'; $id = get_the_id(); ?><a data-title="Email Admin Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
         	</tr>
 <tr>
 <th scope="row"><strong>Link To Email Provider:</strong></th><td><?php $meta_key = 'link_to_email_provider'; $id = get_the_id(); ?><a data-title="Link To Email Provider" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																		  </tr>
          

<tr>
  <th scope="row"><strong>Email Setup Guide:</strong></th> <td><?php $meta_key = 'email_setup_guide'; $id = get_the_id(); ?><a data-title="Email Setup Guide" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
	</tr>
 </tbody>
																	</table>
				</div>
				
			</div>
		</div>
	</div>
</div>