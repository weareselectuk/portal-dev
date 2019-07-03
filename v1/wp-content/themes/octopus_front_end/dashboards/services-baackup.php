


				<!-- Content area -->
				<div class="content">

					<!-- User profile -->
					<div class="row">
						<div class="col-lg-9">
							<div class="tabbable">
								<div class="tab-content">
									<div class="tab-pane fade in active" id="activity">

										<!-- Timeline -->
										<div class="timeline timeline-left content-group">
											<div class="timeline-container">

												<!-- Asset info display -->
												<div class="timeline-row">
													<div class="timeline-icon">
														<div align="centre"><a href="#"><i class="fa fa-print" aria-hidden="true"></i></a></div>
													</div>

													<div class="panel panel-flat timeline-content">
														<div class="panel-heading">
															<h6 class="panel-title">Firewall Dashboard for asset: <strong><?php echo get_post_meta( get_the_id(), 'asset_id', true );?></strong></h6>
                             								<hr>
															
														</div>

														<div class="panel-body">
															<div class="chart-container">
																<div class="col-sm-12">
																	<div class="table-responsive">
          															<table class="table table-striped">
  
																	  <tbody>
																	  	

																	    <tr>
																	      <th scope="row">Manufacturer:</th>
																	      <td><?php $meta_key = 'manufacturer'; $id = get_the_id();?><a data-title="Manufacturer" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Local Admin Username:</td>
																	      <td><?php $meta_key = 'local_admin_username'; $id = get_the_id();?><a data-title="Local Admin Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Model:</th>
																	      <td><?php $meta_key = 'model'; $id = get_the_id();?><a data-title="Model" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Admin URL:</td>
																	      <td><?php $meta_key = 'admin_url'; $id = get_the_id();?><a data-title="Admin URL" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Serial No:</th>
																	      <td><?php $meta_key = 'serial_number'; $id = get_the_id();?><a data-title="Serial No" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Service Tag:</td>
																	      <td><?php $meta_key = 'service_tag_serial_number'; $id = get_the_id();?><a data-title="Service Tag" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    
																	    <tr>
																	      <th scope="row">LAN IP:</th>
																	  	<td><?php $meta_key = 'lan_ip'; $id = get_the_id();?><a data-title="LAN IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    <th scope="row">WAN IP:</th>
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
													</div>
												</div>
												</div>
												<!-- /Asset info display -->


												


												

												

											</div>
									    </div>
									    <!-- /timeline -->

									</div>




								</div>
							</div>
						</div>

						<div class="col-lg-3">

							<!-- Asset -->
							<div class="thumbnail">
								<div class="thumb thumb-rounded thumb-slide">
									<div align="center"> <i class="fa fa-sitemap" center-block style="font-size:100px;color:orange;"></i></div>
									
								</div>
                				<br>
								
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
					    	<!-- /asset -->


							<!-- user details -->
					    	<div class="panel panel-flat">
								
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
							<!-- /user details -->


						


						


							

						</div>
					</div>
					<!-- /user profile -->



				</div>
				<!-- /content area -->