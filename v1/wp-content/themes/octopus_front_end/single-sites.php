<?php get_header(); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
          <ul class="nav nav-tabs">

            <li class="active"><a href="#tab1overview" data-toggle="tab"><i class="fa fa-sitemap" style="color:#1DB2C8"></i> Site Overview</a></li>
            <li><a href="#tab2users" data-toggle="tab"><i class="fa fa-users" style="color:#FC5830"></i> Users</a></li>
            <li><a href="#tab3assets" data-toggle="tab"><i class="fa fa-desktop" style="color:#2C98F0"></i> Assets</a></li>
          </ul>
        </div>
        <div class="panel-body">
          <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1overview">
              <div class="table-responsive">
                <table class="table table-striped">

                  <tbody>

                    <tr>
                      <th scope="row">Site:</th>
                      <td>
                        <?php $site_id = get_post_meta( get_the_id(), 'site', true );?>
                        <a href="<?php echo get_permalink($site_id);?>" class="text-default">
                          <?php echo get_the_title($site_id);?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Telephone:</th>
                      <td>
                        <?php $meta_key = 'site_telephone'; $id = get_the_id(); ?>
                        <a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>

                    <tr>
                      <th scope="row">Address</th>
                      <td>
                        <?php $meta_key = 'address'; $id = get_the_id(); ?>
                        <a data-title="Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">City / Town:</th>
                      <td>
                        <?php $meta_key = 'city'; $id = get_the_id(); ?>
                        <a data-title="City / Town" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">County: </th>
                      <td>
                        <?php $meta_key = 'county'; $id = get_the_id(); ?>
                        <a data-title="County" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Postcode:</th>
                      <td>
                        <?php $meta_key = 'post_code'; $id = get_the_id(); ?>
                        <a data-title="Post Code" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Site Notes:</th>
                      <td>
                        <?php $meta_key = 'notes'; $id = get_the_id(); ?>
                        <a data-title="Notes" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="tab2users">
              <?php

	$args = array(
		'post_type' => 'users',
		'posts_per_page' => 999,
		'meta_query' => array(
			array(
				'key'     => 'site',
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

                      <th>Title</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Telephone</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>User Status</th>
                      <th></th>

                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td>
                        <?php $meta_key = 'title'; $id = get_the_id();?>
                        <a data-title="Title" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'firstname'; $id = get_the_id();?>
                        <a data-title="First Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'lastname'; $id = get_the_id();?>
                        <a data-title="Last Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'telephone'; $id = get_the_id();?>
                        <a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'mobile'; $id = get_the_id();?>
                        <a data-title="Mobile" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'email_address'; $id = get_the_id();?>
                        <a data-title="Email" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'user_status'; $id = get_the_id();?>
                        <a data-title="User Status" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td><a href="<?php the_permalink();?>" class="btn btn-warning">View User</a></td>
                    </tr>


                    <?php endwhile;
  
  echo '</table></div>';
  
else :

  echo '<p>No users are located at this site</p>';
  
endif;

wp_reset_postdata();


?>
                    <!-- Table -->
                
            </div>
            <div class="tab-pane fade" id="tab3assets">
              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'assets',
  'posts_per_page' => 9999,
  'meta_query' => array(
    array(
      'key'     => 'site',
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
                      <th></th>


                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td>
                        <a href="<?php the_permalink();?>">
                          <?php the_title();?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'netbios_name'; $id = get_the_id();?>
                        <a data-title="Email Provider" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'device_class'; $id = get_the_id();?>
                        <a data-title="Net Bios Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'asset_status'; $id = get_the_id();?>
                        <a data-title="Device Class" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td><a href="<?php the_permalink();?>" class="btn btn-primary">View</a></td>
                    </tr>


                    <?php endwhile;
  
  echo '</table></div>';
  
else :

  echo '<p>No posts</p>';
  
endif;

wp_reset_postdata();


?>
                    <!-- Table -->
                
            </div>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h5 class="panel-title">Key Site Information</h5>
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
                      <th scope="row">Client:</th>
                      <td>
                        <?php $client_id = get_post_meta( get_the_id(), 'client', true );?>
                        <a href="<?php echo get_permalink($client_id);?>" class="text-default">
                          <?php echo get_the_title($client_id);?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Site Status:</th>
                      <td>
                        <?php $meta_key = 'site_status'; $id = get_the_id(); ?>
                        <a data-title="User Status" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h5 class="panel-title">Site Map</h5>
              <div class="heading-elements">
                <ul class="icons-list">
                  <li><a data-action="collapse"></a></li>
                  <li><a data-action="close"></a></li>
                 
                </ul>
              </div>
            </div>
            <div class="panel-body">
              
                  
    <?php echo do_shortcode('[wpgmza id="1"]'); ?>
                </div>

            </div>
          </div>
          <div class="col-md-4">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h5 class="panel-title">Email Details</h5>
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
                        <th scope="row">Email Provider</th>
                        <td>
                          <?php $client_id = get_post_meta( get_the_id(), 'client', true );?>
                          <a href="<?php echo get_permalink($client_id);?>" class="text-default">
                            <?php echo get_the_title($client_id);?>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Email Address:</th>
                        <td>
                          <?php $meta_key = 'email_address'; $id = get_the_id(); ?>
                          <a data-title="Email Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                            <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                          </a>
                        </td>
                      </tr>

                      <tr>
                        <th scope="row">Password</th>
                        <td>
                          <?php $meta_key = 'password'; $id = get_the_id(); ?>
                          <a data-title="Email Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                            <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                          </a>
                        </td>
                      </tr>








                    </tbody>
                  </table>
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