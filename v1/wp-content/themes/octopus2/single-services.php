<?php get_header(); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    

   <!-- Main content -->
			<div class="content-wrapper">
        
</div>
      
				<!-- /page header -->

<?php

// much as with the filter page, you're probably going to want to show different values/fields depending on the asset, so I've split out some views

$device_class = get_post_meta( get_the_id(), 'device_class', true );

if($device_class == 'workstation-windows') {
get_template_part('dashboards/workstation');
}

elseif($device_class == 'workstation-mac') {
get_template_part('dashboards/mac');
}


elseif($device_class == 'laptop-windows') {
get_template_part('dashboards/laptop');
}


elseif($device_class == 'laptop-mac') {
get_template_part('dashboards/laptop');
}


elseif($device_class == 'firewall') {
get_template_part('dashboards/firewall');
}


elseif($device_class == 'router') {
get_template_part('dashboards/router');
}


elseif($device_class == 'switch') {
get_template_part('dashboards/switch');
}


elseif($device_class == 'printer') {
get_template_part('dashboards/printer');
}


elseif($device_class == 'storage') {
get_template_part('dashboards/storage');
}

elseif($device_class == 'services') {
get_template_part('dashboards/services');
}

else { ?>


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

		<!-- Sales stats -->
		<div class="timeline-row">
			<div class="timeline-icon">
				<a href="#"><img src="assets/images/placeholder.jpg" alt=""></a>
			</div>

			<div class="panel panel-flat timeline-content">
				<div class="panel-heading">
					
				</div>

				<div class="panel-body">
															<div class="chart-container">
																<div class="col-sm-12">
          															<table class="table table-striped">
  
																	  <tbody>
																	    <tr>
																	      <th scope="row">Email Provider:</th>
																	      <td><?php $meta_key = 'email_provider'; $id = get_the_id();?><a data-title="Email Provider" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Username:</td>
																	      <td><?php $meta_key = 'username'; $id = get_the_id();?><a data-title="Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Password:</th>
																	      <td><?php $meta_key = 'password'; $id = get_the_id();?><a data-title="Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Local Admin Password:</td>
																	      <td><?php $meta_key = 'local_admin_password'; $id = get_the_id();?><a data-title="Local Admin Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Primary Domain:</th>
																	      <td><?php $meta_key = 'primary_domain'; $id = get_the_id();?><a data-title="Primary Domain" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Alias Domain:</td>
																	      <td><?php $meta_key = 'alias_domain'; $id = get_the_id();?><a data-title="Alias Domain" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    <tr>
																	      <th scope="row">Admin Username:</th>
																	   	  <td><?php $meta_key = 'admin_username'; $id = get_the_id();?><a data-title="Admin Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	      <th scope="row">Admin Password:</td>
																	      <td><?php $meta_key = 'admin_password'; $id = get_the_id();?><a data-title="Admin Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																	    
																	    
																	  </tbody>
																	</table>
          
        														</div>
															</div>
														</div>
													</div>
												</div>
												<!-- /sales stats -->


												


												

												

											</div>
									    </div>
									    <!-- /timeline -->

									</div>




								</div>
							</div>
						</div>

						<div class="col-lg-3">

							<!-- user -->
							<div class="thumbnail">
								<div class="thumb thumb-rounded thumb-slide">
									<div align="center"> <i class="fa fa-wrench" center-block style="font-size:100px;color:orange;"></i></div>
									
								</div>
                				<br>
								
								
								<table class="table table-striped">
  
																	  <tbody>		  	
<tr>
  <th scope="row">Client:</th>
	<td>
		<?php $user_id = get_the_id();?><a href="<?php echo get_permalink($user_id);?>" class="list-group-item"><?php echo get_the_title($user_id);?></a></td>
<tr>
	<th scope="row">Site:</th>
	<td>
		   <a>	<?php $meta_key = 'site'; $id = get_the_id();?><a data-title="site" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
</a></td>
<tr>
 <th scope="row">Address:</th>
   <td>
   	<?php $meta_key = 'address'; $id = get_the_id();?><a data-title="Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
   	
</td>
	</tr>
 <tr>
 <th scope="row">Town:</th>
	 <td><?php $meta_key = 'city'; $id = get_the_id();?><a data-title="Town" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
	 	
																	    </tr>
																		  <tr>
																	      <th scope="row">County:</th>
																	      <td><?php $meta_key = 'county'; $id = $user_id;?><a data-title="County" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		  <tr>
																	      <th scope="row">Postcode:</th>
																	      <td><?php $meta_key = 'post_code'; $id = $user_id;?><a data-title="Postcode" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
																	    </tr>
																		 </tbody>
																	</table>
									
						    	
					    	</div>
					    	<!-- /user -->


							<!-- user details -->
					    	<div class="panel panel-flat">
								
								
								<table class="table table-striped">
  
																	  <tbody>
																	  	

																	    
																	 <tr>
																	      <th scope="row">Email:</th>
																	      <td><?php $meta_key = 'email_address'; $id = $user_id;?><a data-title="Email Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $user_id, 'email_address', true );?></a></td>
																	    </tr>
																		 
																		  <tr>
																	      <th scope="row">Telephone:</th>
																	      <td><?php $meta_key = 'telephone'; $id = $user_id;?><a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $user_id, 'telephone', true );?></a></td>
																	    </tr>
																		 
																	    
																	  </tbody>
																	</table>
							</div>
							<!-- /user details -->


						


						


							

						</div>
					</div>
					<!-- /user profile -->



				</div>
				<!-- /content area -->

<?php } ?>

			</div>
			<!-- /main content -->

      

      <?php get_template_part('footer', 'simple');?>

    </div>
    <!-- /content area -->

    <?php endwhile; else : ?>

        <!-- Content area -->
        <div class="content">

          <!-- Error title -->
          <div class="text-center content-group">
            <h1 class="error-title"><?php _e( '404', 'honeypot' ) ?></h1>
            <h5><?php _e( 'Oops, an error has occurred. Page not found!', 'honeypot' ) ?></h5>
          </div>
          <!-- /error title -->


          <!-- Error content -->
          <div class="row">
            <div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
              <?php get_search_form();?>
            </div>
          </div>
          <!-- /error wrapper -->

          <?php get_template_part('footer', 'simple');?>


        </div>
        <!-- /content area -->

          
    <?php endif; ?>


<?php get_footer(); ?>