<?php get_header(); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
          <ul class="nav nav-tabs" role="tablist" id="myTab">

            <li class="active"><a href="#tab1overview" data-toggle="tab"><i class="fa fa-user-plus" style="color:#FC5830"></i> Users</a></li>
            <li><a href="#tab2assets" role="tab" data-toggle="tab"><i class="fa fa-desktop" style="color:#2C98F0"></i> Assets</a></li>
            <li><a href="#tab2logins" role="tab" data-toggle="tab"><i class="fa fa-wrench" style="color:#2C98F0"></i> Logins</a></li>


          </ul>
        </div>
        <div class="panel-body">
          <div class="tab-content">

            <div class="tab-pane fade in active" id="tab1overview">

              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col"><strong>Title</strong></th>
                      <th scope="col"><strong>First Name</strong></th>
                      <th scope="col"><strong>Last Name</strong></th>
                      <th scope="col"><strong>Job Title</strong></th>
                      <th scope="col"><strong>Department</strong></th>

                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">
                        <?php $meta_key = 'title'; $id = get_the_id(); ?>
                        <a data-title="Title" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </th>
                      <td>
                        <?php $meta_key = 'firstname'; $id = get_the_id(); ?>
                        <a data-title="First Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <th scope="row">
                        <?php $meta_key = 'lastname'; $id = get_the_id(); ?>
                        <a data-title="Last Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </th>
                      <th>
                        <?php $meta_key = 'job_title'; $id = get_the_id(); ?>
                        <a data-title="Job Title" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </th>
                      <th>
                        <?php $meta_key = 'department'; $id = get_the_id(); ?>
                        <a data-title="Department" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </th>
                    </tr>



                  </tbody>
                </table>



              </div>
            </div>

          <div class="tab-pane fade" id="tab2assets">
              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'assets',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
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
<div class="post_count"><?php echo $the_query->found_posts; ?> Assets</div>
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th><strong>Asset ID</strong></th>
                      <th><strong>Netbios Name</strong></th>
                      <th><strong>Device Class</strong></th>
                      <th><strong>Asset Status</strong></th>
                      <th><strong>Site Location</strong></th>
                      <th></th>


                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td><?php echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>'; ?></td>
                      <td><?php $meta_key = 'netbios_name'; $id = get_the_id();?><a data-title="Email Provider" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
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
                      <td>
                        <?php $site_id = get_post_meta( get_the_id(), 'site', true );?>
                        <a href="<?php echo get_permalink($site_id);?>" class="text-default">
                          <?php echo get_the_title($site_id);?>
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td><a href="<?php the_permalink();?>" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span>  View</a></td>
                    </tr>
                  
                  <?php endwhile;
  
  echo '</table></div>';
  
else :

  echo '<p>This user has no assets</p>';
  
endif;

wp_reset_postdata();


?>


            </div>
            <div class="tab-pane fade" id="tab2logins">


              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'logins',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
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
<div class="post_count"><?php echo $the_query->found_posts; ?> Logins</div>
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th><strong>Login Type</strong></th>
                      <th><strong>Username</strong></th>
                      <th><strong>Password</strong></th>
                      



                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>

                      <td align="center">
                        <?php $meta_key = 'login_type'; $id = get_the_id();?>
                        <a data-title="Login Type" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td align="center">
                        <?php $meta_key = 'login_username'; $id = get_the_id();?>
                        <a data-title="Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      
                      <td align="center">
                        <?php $meta_key = 'login_password'; $id = get_the_id();?>
                        <a data-title="Password" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        <i class="glyphicon glyphicon-eye-open"></i>
                      </td>
                     


                    </tr>
                    </table></div>

                    <?php endwhile;
  
  
  
else :

  echo '<p>This user has no logins</p>';
  
endif;


wp_reset_postdata();


?><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#logins">
<span class="glyphicon glyphicon-plus-sign"></span>  Add Login
</button>

                  <!-- Modal -->
                  <div class="modal fade" id="logins" tabindex="-1" role="dialog" aria-labelledby="logins" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="logins">Create Login</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
                        </div>
                        <div class="modal-body">
                          <?php echo do_shortcode("[ninja_form id=18]"); ?>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div></div>

                    <!-- Table -->
                </div>
            
          </div>
        </div>
     







    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-warning">
          <div class="panel-heading">
            <h5 class="panel-title">Key User Info</h5>
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
                    <th scope="row"><strong>Telephone:</strong></th>
                    <td>
                      <?php $meta_key = 'telephone'; $id = get_the_id(); ?>
                      <a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                  </tr>
                   <tr>
                    <th scope="row"><strong>DDI:</strong></th>
                    <td>
                      <?php $meta_key = 'di_telephone'; $id = get_the_id(); ?>
                      <a data-title="DDI Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row"><strong>Ext:</strong></th>
                    <td>
                      <?php $meta_key = 'ext'; $id = get_the_id(); ?>
                      <a data-title="Ext" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row"><strong>Mobile:</strong></th>
                    <td>
                      <?php $meta_key = 'mobile'; $id = get_the_id(); ?>
                      <a data-title="Mobile" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                  </tr>
                  <th scope="row"><strong>Email:</strong></th>
                  <td>
                    <?php $meta_key = 'email_address'; $id = get_the_id(); ?>
                    <a data-title="Email Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>

                  <tr>
                    <th scope="row"><strong>VPN Access:</strong></th>
                    <td>
                      <?php $meta_key = 'vpn_user'; $id = get_the_id(); ?>
                      <a data-title="VPN User" href="#" id="vpn" name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Yes',text:'Yes'},{value:'No',text:'No'},{value:'',text:'Empty'}]" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row"><strong>Notes:</strong></th>
                    <td>
                      <?php $meta_key = 'user_notes'; $id = get_the_id(); ?>
                      <a data-title="Notes" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
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
                  <thead>
                    <tr>
                      <th scope="col"><strong>Day of the week</strong></th>
                      <th scope="col"><strong>Time Worked</strong></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row"><strong>Monday</strong></th>
                      <td>
                        <?php $meta_key = 'day_mon'; $id = get_the_id(); ?>
                        <a data-title="Monday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                    </tr>
                    <tr>
                      <th scope="row"><strong>Tuesday</strong></th>
                      <td>
                        <?php $meta_key = 'day_tues'; $id = get_the_id(); ?>
                        <a data-title="Tuesday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                    </tr>
                    <tr>
                      <th scope="row"><strong>Wednesday</strong></th>
                      <td>
                        <?php $meta_key = 'day_wed'; $id = get_the_id(); ?>
                        <a data-title="Wednesday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                    </tr>
                    <tr>
                      <th scope="row"><strong>Thursday</strong></th>
                      <td>
                        <?php $meta_key = 'day_thurs'; $id = get_the_id(); ?>
                        <a data-title="Thursday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                    </tr>
                    <tr>
                      <th scope="row"><strong>Friday</strong></th>
                      <td>
                        <?php $meta_key = 'day_fri'; $id = get_the_id(); ?>
                        <a data-title="Friday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
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
  'orderby' => 'title',
  'order' => 'ASC',
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
                    <th><strong>AddressEmail </strong></th>
                    <th><strong>Password</strong></th>
                    <th><strong>License Type</strong></th>



                  </tr>


                  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                  <tr>

                    <td>
                      <?php $meta_key = 'email_address'; $id = get_the_id();?>
                      <a data-title="Email Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                    <td>
                      <?php $meta_key = 'password'; $id = get_the_id();?>
                        <a data-title="Email Password" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </td>
                    <td>
                     <?php $meta_key = 'license_type'; $id = get_the_id();?>
                        <a data-title="Last Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>


                  </tr>
                  

                  <?php endwhile;
  
echo '</table></div>';

else :

  echo '<p>This user has no services</p>';
  
endif;

wp_reset_postdata();


?>



                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#emailservice">
 <span class="glyphicon glyphicon-plus-sign"></span>  Add Email Services
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
</div>
  <?php get_template_part('footer', 'simple');?>



  <?php get_footer(); ?>
