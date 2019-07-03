<?php get_header(); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading" style="z-index:998;">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1overview" data-toggle="tab"><i class="fa fa-building" style="color:#50AE54"></i> Client Overview</a></li>
            <li><a href="#tab2sites" data-toggle="tab"><i class="fa fa-sitemap" style="color:#1DB2C8"></i> Sites</a></li>
            <li><a href="#tab3users" data-toggle="tab"><i class="fa fa-user-plus" style="color:#FC5830"></i> Users</a></li>
            <li><a href="#tab4assets" data-toggle="tab"><i class="fa fa-desktop" style="color:#2C98F0"></i> Assets</a></li>
            <li class="dropdown">
              <a href="#" data-toggle="dropdown"><i class="fa fa-wrench" style="color:#333333"></i> Services <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#tab11internal" data-toggle="tab"><i class="fa fa-wrench" style="color:#333333"></i> Internal Services</a></li>
                <li><a href="#tab12external" data-toggle="tab"><i class="fa fa-wrench" style="color:#333333"></i> External Services</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" data-toggle="dropdown"><i class="fa fa-wrench" style="color:#333333"></i> Web Services <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#tab6webhosting" data-toggle="tab"><i class="fa fa-wrench" style="color:#333333"></i> Web Hosting</a></li>
                <li><a href="#tab7domains" data-toggle="tab"><i class="fa fa-wrench" style="color:#333333"></i> Domains</a></li>
                <li><a href="#tab8crushftp" data-toggle="tab"><i class="fa fa-wrench" style="color:#333333"></i> Crush FTP</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" data-toggle="dropdown"><i class="fa fa-certificate" style="color:#333333"></i> Licenses <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#tab9email" data-toggle="tab"><i class="fa fa-certificate" style="color:#333333"></i> eMail</a></li>            
              </ul>
            </li>
           <!-- Commented out for now <li><a href="#tab10migrations" data-toggle="tab"><i class="fa fa-rocket" style="color:#2C98F0"></i> Migrations</a></li> -->
          </ul>
        </div>
        <div class="panel-body">
          <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1overview">
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
                      <th scope="row">Telephone:</th>
                      <td>
                        <?php $meta_key = 'telephone'; $id = get_the_id(); ?>
                        <a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Email:</th>
                      <td>
                        <?php $meta_key = 'email'; $id = get_the_id(); ?>
                        <a data-title="Email" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Website:</th>
                      <td>
                        <?php $meta_key = 'client_website'; $id = get_the_id(); ?>
                        <a data-title="Website" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="tab2sites">
              <?php

// get all associated services associated with this client

 $args = array(
        'post_type' => 'sites',
        'posts_per_page' => 999,
        'meta_query' => array(
          array(
            'key'     => 'client',
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
                      <th>Site Name</th>
                      <th>Address</th>
                      <th>Town</th>
                      <th>County</th>
                      <th>Postcode</th>
                      <th>Email</th>
                      <th>Telephone</th>
                      
                      <th>Notes</th>
                      <th></th>
                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td>
                        <?php $meta_key = 'site'; $id = get_the_id();?>
                        <a data-title="Site name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'address'; $id = get_the_id();?>
                        <a data-title="Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'city'; $id = get_the_id();?>
                        <a data-title="City" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'county'; $id = get_the_id();?>
                        <a data-title="County" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'post_code'; $id = get_the_id();?>
                        <a data-title="Postcode" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'site_email'; $id = get_the_id();?>
                        <a data-title="Site Email" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'site_telephone'; $id = get_the_id();?>
                        <a data-title="Site Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'site_notes'; $id = get_the_id();?>
                        <a data-title="Site Notes" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td><a href="<?php the_permalink();?>" class="btn btn-info">View</a></td>
                    </tr>


                    <?php endwhile;
  
  echo '</table></div>';
  
else :

  echo '<p>This Client has no sites</p>';
  
endif;

wp_reset_postdata();?>
                    <!-- Table -->
                

            </div>
            <div class="tab-pane fade" id="tab3users">
            <?php

	$args = array(
		"post_type" => "users",
		"posts_per_page" => 999,
		"meta_query" => array(
			array(
				"key"     => "client",
				"value"   => get_the_id(),
				"compare" => "=",
			),
		)
	);

  $the_query = new WP_Query( $args );
  
  

if ($the_query->have_posts()) : ?>
<?php echo do_shortcode('[ms-protect-content id="1570"]

                <div class="table-responsive">
                  <table class="table">
                    <tr>

                      <th>Title</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Telephone</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Employment Type</th>
                      <th>Employment Status</th>
                      
                      <th></th>

                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td>
                        <?php $meta_key = "title"; $id = get_the_id();?>
                        <a data-title="Title" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = "";?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = "firstname"; $id = get_the_id();?>
                        <a data-title="First Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = "";?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = "lastname"; $id = get_the_id();?>
                        <a data-title="Last Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = "";?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = "telephone"; $id = get_the_id();?>
                        <a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = "";?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = "mobile"; $id = get_the_id();?>
                        <a data-title="Mobile" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = "";?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = "email_address"; $id = get_the_id();?>
                        <a data-title="Email" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = "";?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = "employment_type"; $id = get_the_id();?>
                        <a data-title="Employment Type" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = "";?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = "user_status"; $id = get_the_id();?>
                        <a data-title="Employment Status" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = "";?>
                        </a>
                      </td>
                      <td><a href="<?php the_permalink();?>" class="btn btn-warning">View</a></td>
                    </tr>


                    <?php endwhile; echo "</table></div>"; [/ms-protect-content]');
  
else :

  echo '<p>This Client Has No Users</p>';
  
endif;
 
wp_reset_postdata();?>
                    <!-- Table -->
                
                    </div>
            <div class="tab-pane fade" id="tab4assets">
              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'assets',
  'posts_per_page' => 9999,
  'meta_query' => array(
    array(
      'key'     => 'client',
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
                   
                     <th>
                       <i class="fa fa-line-chart" title="Add asset to comparison" style="color:#EBA124"></a>
  </div>
                     
                     </th>
                      
                      <th>Asset ID</th>
                      <th>Netbios Name</th>
                      <th>Tools</th>
                      <th>Device Class</th>
                      <th>Asset Status</th>
                      <th>Site Location</th>
                      
                      <th></th>
                       
                      
                        </i>
                       </a>
                      
                      </th>


                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td>
                        <input type="checkbox" id="compare" name="compare" value="compare">
                      </td>
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
                       <div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
  <i class="fa fa-folder"></i>
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><a href="#" data-value="action">Action</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#" data-value="another action">Another action</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#" data-value="something else here">Something else here</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#" data-value="separated link">Separated link</a></li>
  </ul>
</div>
                        
                      </td>
                      <td>
                        <?php $meta_key = 'device_class'; $id = get_the_id();?>
                        <a data-title="Net Bios Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      
                      <td>
                        
                        <i class="fa fa-check-circle" title="Active" style="color:#27e833">
                       
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'site'; $id = get_the_id();?>
                        <a data-title="Site" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td><a href="<?php the_permalink();?>" class="btn btn-primary">View</a></td>
                      
                     </tr>


                    <?php endwhile;
  
  echo '</table></div>';
  
else :

  echo '<p>This Client Has no Assets</p>';
  
endif;

wp_reset_postdata();?>
                    <!-- Table -->
                
            </div>
                

            <div class="tab-pane fade" id="tab9email">
              <?php	$args = array(
		'post_type' => 'services',
		'posts_per_page' => 999,
		'meta_query' => array(
			array(
				'key'     => 'client',
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
                      <th>Licence Type</th>


                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td>
                        <?php $meta_key = 'email_address'; $id = get_the_id();?>
                        <a data-title="Title" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'password'; $id = get_the_id();?>
                        <a data-title="First Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'license_type'; $id = get_the_id();?>
                        <a data-title="Last Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>


                    </tr>


                    <?php endwhile;
  
  echo '</table></div>'; ?>
					  <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#email">
  Add Email 
</button>

                    <!-- Modal -->
                    <div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="hostingmodal">Add Email</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=16]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
					  <?php
  
else :

  echo '<p>Client Has No Email Services</p>'; ?>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#email">
  Add Email 
</button>

                    <!-- Modal -->
                    <div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="hostingmodal">Add Email</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=16]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php endif; wp_reset_postdata();?>
                    <!-- Table -->
                


            </div>


            <div class="tab-pane fade" id="tab11internal">
              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'services',
  'posts_per_page' => 9999,
  'meta_query' => array(
    array(
      'key'     => 'client',
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
                      <th></th>
                      <th>Service Name</th>
                      <th>URL</th>
                      <th>Username</th>
                      <th>Password</th>
                      <th>Notes</th>




                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td></td>
                      <td>
                        <?php $meta_key = 'internal_type'; $id = get_the_id();?>
                        <a data-title="Domain Registration" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'internal_url'; $id = get_the_id();?>
                        <a data-title="Nameservers" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'internal_username'; $id = get_the_id();?>
                        <a data-title="Domin Registra" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'internal_password'; $id = get_the_id();?>
                        <a data-title="Domain Expiry Date" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'internal_notes'; $id = get_the_id();?>
                        <a data-title="Registra Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>


                    </tr>


                    <?php endwhile;
  
  echo '</table></div>';?>
					   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#internalservices">
  Add Internal Services
</button>

                    <!-- Modal -->
                    <div class="modal fade" id="internalservices" tabindex="-1" role="dialog" aria-labelledby="internalservices" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="internalservices">Create Internal Service</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=12]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
					  <?php
  
else :

  echo '<p>This Client Has Internal Services</p>'; ?>
					  
					  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#internalservices">
  Add Internal Services
</button>

                    <!-- Modal -->
                    <div class="modal fade" id="internalservices" tabindex="-1" role="dialog" aria-labelledby="internalservices" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="internalservices">Create Internal Service</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=12]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
  
<?php endif; wp_reset_postdata();?>
                    <!-- Table -->
                    
                
                <!-- Button trigger modal -->
            </div>

            <div class="tab-pane fade" id="tab6webhosting">
              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'services',
  'posts_per_page' => 9999,
  'meta_query' => array(
    array(
      'key'     => 'client',
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
                      <th></th>
                      <th>Host</th>
                      <th>cPanel Username</th>
                      <th>cPanel Password</th>
                      <th>cPanel Login URL</th>
                      <th>FTP Port</th>
                      <th>Package</th>
                      <th>Server</th>
                      <th>Status</th>
                      <th>Login to hosting</th>



                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td></td>
                      <td>
                        <?php $meta_key = 'hosting_host'; $id = get_the_id();?>
                        <a data-title="Host" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'cpanel_username'; $id = get_the_id();?>
                        <a data-title="cPanel Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'cpanel_password'; $id = get_the_id();?>
                        <a data-title="cPanel Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'cpanel_login_url'; $id = get_the_id();?>
                        <a data-title="cPanel Login URL" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'ftp_port'; $id = get_the_id();?>
                        <a data-title="FTP Port" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'webhosting_package'; $id = get_the_id();?>
                        <a data-title="Web Hosting Package" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'webhosting_server'; $id = get_the_id();?>
                        <a data-title="Web Hosting Server" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'webhosting_status'; $id = get_the_id();?>
                        <a data-title="Web Hosting Status" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <th><a href="https://pluto.weareselect.uk:2083" target="_blank"><i class="fa fa-server"></i></a></th>
                    </tr>


                    <?php endwhile;
  
  echo '</table></div>'; ?>
<!--

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#hostingmodal">
  Add Web Hosting
</button>

                
                <div class="modal fade" id="hostingmodal" tabindex="-1" role="dialog" aria-labelledby="hostingmodal" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="hostingmodal">Create Web Hosting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <//?php echo do_shortcode("[ninja_form id=9]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
-->
					  <?php
  
else :

  echo '<p>This Client Has no Assets</p>';
  
endif;
					  wp_reset_postdata();?>
					 
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#hostingmodal">
  Add Web Hosting
</button>

                <!-- Modal -->
                <div class="modal fade" id="hostingmodal" tabindex="-1" role="dialog" aria-labelledby="hostingmodal" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="hostingmodal">Create Web Hosting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=9]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
  
<?php  wp_reset_postdata();?>
                
                
            </div>
            <div class="tab-pane fade" id="tab7domains">
              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'services',
  'posts_per_page' => 9999,
  'meta_query' => array(
    array(
      'key'     => 'client',
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
                      <th></th>
                      <th>Domain</th>
                      <th>Registra</th>
                      <th>Expires</th>
                      <th>Namservers</th>
                      <th>Registra Username</th>
                      <th>Registra Password</th>



                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td></td>
                      <td>
                        <?php $meta_key = 'domain_registration'; $id = get_the_id();?>
                        <a data-title="Domain Registration" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'domain_registra'; $id = get_the_id();?>
                        <a data-title="Domin Registra" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'domain_expiry'; $id = get_the_id();?>
                        <a data-title="Domain Expiry Date" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'nameservers'; $id = get_the_id();?>
                        <a data-title="Nameservers" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'registra_username'; $id = get_the_id();?>
                        <a data-title="Registra Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'registra_password'; $id = get_the_id();?>
                        <a data-title="Registra Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                    </tr>


                    <?php endwhile;
  
  echo '</table></div>'; ?>
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#domainsmodal">
  Add Domains
</button>

                <!-- Modal -->
                <div class="modal fade" id="domainsmodal" tabindex="-1" role="dialog" aria-labelledby="domainsmodal" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="hostingmodal">Create Web Hosting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=10]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
					  <?php
  
else :

  echo '<p>This Client Has no Domains</p>'; ?>
					  
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#domainsmodal">
  Add Domains
</button>

                <!-- Modal -->
                <div class="modal fade" id="domainsmodal" tabindex="-1" role="dialog" aria-labelledby="domainsmodal" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="hostingmodal">Create Web Hosting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=10]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
  
<?php endif; wp_reset_postdata();?>
                    <!-- Table -->
                
                
            </div>
            <div class="tab-pane fade" id="tab8crushftp">
              <?php

	$args = array(
		'post_type' => 'services',
		'posts_per_page' => 999,
		'meta_query' => array(
			array(
				'key'     => 'client',
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

                      <th>Host</th>
                      <th>Username</th>
                      <th>Password</th>
                      <th>Port</th>
                      <th>URL</th>
                      <th>Package</th>
                      <th>Status</th>


                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td>
                        <?php $meta_key = 'sftp_host'; $id = get_the_id();?>
                        <a data-title="Host" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'sftp_username'; $id = get_the_id();?>
                        <a data-title="Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'sftp_password'; $id = get_the_id();?>
                        <a data-title="Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'sftp_port'; $id = get_the_id();?>
                        <a data-title="Port" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'sftp_url'; $id = get_the_id();?>
                        <a data-title="URL" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'sftp_package'; $id = get_the_id();?>
                        <a data-title="Package" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'sftp_status'; $id = get_the_id();?>
                        <a data-title="Status" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                    </tr>


                    <?php endwhile;
  
  echo '</table></div>'; ?>
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crushftp">
  Add Crush FTP
</button>

                <!-- Modal -->
                <div class="modal fade" id="crushftp" tabindex="-1" role="dialog" aria-labelledby="crushftp" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="hostingmodal">Create Web Hosting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=15]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
					  <?php
  
else :

  echo '<p>Client Has No FTP Services</p>'; ?>
					  
					   <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crushftp">
  Add Crush FTP
</button>

                <!-- Modal -->
                <div class="modal fade" id="crushftp" tabindex="-1" role="dialog" aria-labelledby="crushftp" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="hostingmodal">Create Web Hosting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=15]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
  
<?php endif; wp_reset_postdata();?>
                    <!-- Table -->
                
               

            </div>


            <div class="tab-pane fade" id="tab12external">
              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'services',
  'posts_per_page' => 9999,
  'meta_query' => array(
    array(
      'key'     => 'client',
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
                      <th></th>
                      <th>Service Name</th>
                      <th>URL</th>
                      <th>Username</th>
                      <th>Password</th>

                      <th>Notes</th>




                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td></td>
                      <td>
                        <?php $meta_key = 'external_type'; $id = get_the_id();?>
                        <a data-title="External Type" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'external_url'; $id = get_the_id();?>
                        <a data-title="External URL" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'external_username'; $id = get_the_id();?>
                        <a data-title="External Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'external_password'; $id = get_the_id();?>
                        <a data-title="External Password" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                      <td>
                        <?php $meta_key = 'external_notes'; $id = get_the_id();?>
                        <a data-title="External Notes" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>


                    </tr>


                    <?php endwhile;
  
  echo '</table></div>';?>
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#externalservice">
  Add External Service
</button>

                <!-- Modal -->
                <div class="modal fade" id="externalservice" tabindex="-1" role="dialog" aria-labelledby="externalservice" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="hostingmodal">Add External Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=11]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
					  <?php
  
else :

  echo '<p>This Client Has No External Services</p>'; ?>
					  
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#externalservice">
  Add External Service
</button>

                <!-- Modal -->
                <div class="modal fade" id="externalservice" tabindex="-1" role="dialog" aria-labelledby="externalservice" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="hostingmodal">Add External Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=11]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
  
<?php endif; wp_reset_postdata();?>
                    <!-- Table -->
                
                
            </div>
                <div class="tab-pane fade" id="tab10migrations">
            <?php
             // get all associated services associated with this client

$args = array(
  'post_type' => 'migrations',
  'posts_per_page' => 9999,
  'meta_query' => array(
    array(
      'key'     => 'client',
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
                      <th></th>
                      <th>Service Migration</th>
                      <th>Date Created</th>
                      <th>User</th>
                      <th>Due Date</th>
                      <th>Engineer</th>
                      <th>Status</th>



                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td></td>
                      <td>
                        <?php $meta_key = 'task_title'; $id = get_the_id();?>
                        <a data-title="Service Migration" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'date_created'; $id = get_the_id();?>
                        <a data-title="Date Created" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'user'; $id = get_the_id();?>
                        <a data-title="User" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'due_date'; $id = get_the_id();?>
                        <a data-title="Due Date" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'engineer'; $id = get_the_id();?>
                        <a data-title="Engineers" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'status'; $id = get_the_id();?>
                        <a data-title="Status" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td><a href="<?php the_permalink();?>" class="btn btn-primary">View</a></td>
                    </tr>


                    <?php endwhile;
  
  echo '</table></div>'; ?>
             <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#migrations">
  Add Migration
</button>

                <!-- Modal -->
                <div class="modal fade" id="migrations" tabindex="-1" role="dialog" aria-labelledby="migrations" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="migrationmodal">Create Migration</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=19]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                else :

echo '<p>Client Has No Pending Migrations</p>'; ?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#migrations">
  Add Migration
</button>

                <!-- Modal -->
                <div class="modal fade" id="migrations" tabindex="-1" role="dialog" aria-labelledby="migrations" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="migrationmodal">Create Migration</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=19]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endif; wp_reset_postdata();?>
            </div>
          </div>
          </div>

        </div>
            
      </div>
      </div>



      <?php get_template_part('client', 'box');?>



      <?php get_template_part('footer', 'simple');?>



      <?php get_footer(); ?>
      </div>