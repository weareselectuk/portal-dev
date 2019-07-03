<?php get_header(); ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
							
							<li class="active"><a href="#tab1overview" data-toggle="tab"><i class="fa fa-user-plus" style="color:#FC5830"></i> Users</a></li>s
                           <li><a href="#tab2assets" data-toggle="tab"><i class="fa fa-desktop" style="color:#2C98F0"></i> Assets</a></li>
                           <li><a href="#tab3sftp" data-toggle="tab"><i class="fa fa-wrench" style="color:#2C98F0"></i> SFTP</a></li>
						 </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                          <div class="tab-pane fade in active" id="tab1overview">
							
							<div class="table-responsive">
							<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Title</th>
      <th scope="col">First Name
	  <th scope="col">Last Name</th>
      <th scope="col">Job Title</th>
	  <th scope="col">Deparment</th>
	  
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"><?php $meta_key = 'title'; $id = get_the_id(); ?><a data-title="Title" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></th>
      <td><?php $meta_key = 'firstname'; $id = get_the_id(); ?><a data-title="First Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
      <th scope="row"><?php $meta_key = 'lastname'; $id = get_the_id(); ?><a data-title="Last Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></th>
      <th><?php $meta_key = 'job_title'; $id = get_the_id(); ?><a data-title="Job Title" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></th>
	   <th><?php $meta_key = 'department'; $id = get_the_id(); ?><a data-title="Department" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></th>
	</tr>
     
    
	</tr>
  </tbody>
</table>
							
																							
</td>
	</div>
		</div>
																						 
                        <div class="tab-pane fade" id="tab2assets">
																								<?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'assets',
  'posts_per_page' => 9999,
  'meta_query' => array(
    array(
      'key'     => 'user',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>

  <div class="table-responsive">
	<table class="table">
    <tr>
      <th>Asset ID</th>
      <th>Netbios Name</th>
      <th>Device Class</th>
      <th>Asset Status</th>
	    <th>Site Location</th>
					<th></th>
      
      
    </tr>


  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

  <tr>
    <td><a href="<?php the_permalink();?>"><?php the_title();?></a></td>
    <td><?php $meta_key = 'netbios_name'; $id = get_the_id();?><a data-title="Email Provider" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
    <td><?php $meta_key = 'device_class'; $id = get_the_id();?><a data-title="Net Bios Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
    <td><?php $meta_key = 'asset_status'; $id = get_the_id();?><a data-title="Device Class" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
    <td><?php $site_id = get_post_meta( get_the_id(), 'site', true );?><a href="<?php echo get_permalink($site_id);?>" class="text-default"><?php echo get_the_title($site_id);?><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
		<td><a href="<?php the_permalink();?>" class="btn btn-primary">View</a>
  </tr>

    
  <?php endwhile;
  
  echo '</table>';
  
else :

  echo '<p>This user has no assets</p>';
  
endif;

wp_reset_postdata();


?>
        <!-- Table -->
         </div>
                     
         

        </div>
       
</div>
                </div>
</div>
                      
                    </div>
                    
            </div>
            
			<div class="row">
		<div class="col-md-4">
			<div class="panel panel-warning">
						<div class="panel-heading">
							<h5 class="panel-title">Key Contact Info</h5>
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
	<th scope="row">Telephone:</th>
	<td><?php $meta_key = 'telephone'; $id = get_the_id(); ?><a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
</tr>
<th scope="row">Ext:</th>
	<td><?php $meta_key = 'ext'; $id = get_the_id(); ?><a data-title="Ext" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
</tr>
<tr>
  <th scope="row">Mobile:</th> <td><?php $meta_key = 'mobile'; $id = get_the_id(); ?><a data-title="Mobile" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
<tr>
	<th scope="row">Email:</th>
	<td><?php $meta_key = 'email_address'; $id = get_the_id(); ?><a data-title="Email Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></a></td>
	<tr>
  <th scope="row">Notes:</th> <td><?php $meta_key = 'user_notes'; $id = get_the_id(); ?><a data-title="Notes" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
<tr>
	
 </tr>
 </tr>
 </tbody>
 
																	</table>
					</div>
				</div>
				
			</div>
		</div>
				<div class="col-md-4">
			<div class="panel panel-warning">
						<div class="panel-heading">
							<h5 class="panel-title">Days & Time Worked</h5>
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
  <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Day of the week</th>
      <th scope="col">Time Worked</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Monday</th>
      <td><?php $meta_key = 'day_mon'; $id = get_the_id(); ?><a data-title="Monday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
      
    </tr>
    <tr>
      <th scope="row">Tuesday</th>
      <td><?php $meta_key = 'day_tues'; $id = get_the_id(); ?><a data-title="Tuesday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
      
    </tr>
    <tr>
      <th scope="row">Wednesday</th>
      <td><?php $meta_key = 'day_wed'; $id = get_the_id(); ?><a data-title="Wednesday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
     
    </tr>
				 <tr>
      <th scope="row">Thursday</th>
      <td><?php $meta_key = 'day_thurs'; $id = get_the_id(); ?><a data-title="Thursday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
      
    </tr>
					 <tr>
      <th scope="row">Friday</th>
      <td><?php $meta_key = 'day_fri'; $id = get_the_id(); ?><a data-title="Friday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
     
    </tr>
  </tbody>
</table>
				</div>
				</div>
				
			</div>
		</div>
				<div class="col-md-4">
			<div class="panel panel-warning">
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
					
					<?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'services',
  'posts_per_page' => 9999,
  'meta_query' => array(
    array(
      'key'     => 'user',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>

  <div class="table-responsive">
	<table class="table">
    <tr>
      <th>Email Address</th>
      <th>Password</th>
      <th>License Type</th>
     
      
      
    </tr>


  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

  <tr>
    
    <td><?php $meta_key = 'email_address'; $id = get_the_id();?><a data-title="Email Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
    <td><?php $meta_key = 'password'; $id = get_the_id();?><a data-title="Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
    <td><?php $meta_key = 'license_type'; $id = get_the_id();?><a data-title="License Type" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
  
	
  </tr>

    
  <?php endwhile;
  
  echo '</table>';
  
else :

  echo '<p>This user has no services</p>';
  
endif;

wp_reset_postdata();


?>


				
  <!-- Button trigger modal -->
<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#emailservice">
  Add Email Services
</button>

<!-- Modal -->
<div class="modal fade" id="emailservice" tabindex="-1" role="dialog" aria-labelledby="emailservice" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="emailservice">Add Email Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     <?php echo do_shortcode("[ninja_form id=16]"); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
       </div>
    </div>
  </div>
</div>
  </div>
				</div>
			</div>
  
		</div>
			</div>
		</div>



<?php get_template_part('footer', 'simple');?>

     

<?php get_footer(); ?>