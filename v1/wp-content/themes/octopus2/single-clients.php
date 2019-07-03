<?php get_header(); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
    
    <!-- Helpdesk Buttons - Not active
    <div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-primary">Open a Ticket</button>
    <button type="button" class="btn btn-primary">Something</button>
    <button type="button" class="btn btn-primary">Something</button>
  </div>
    -->
      <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading" style="z-index:998;">
         <div class="affectedDiv">
          <ul class="nav nav-tabs" role="tablist" id="myTab">
           <li class="active"><a role="tab" data-toggle="tab" href="#tab1overview"> <i class="fa fa-building" style="color:#50AE54"></i> Client Overview</a></li>
            <li><a href="#tab2sites" role="tab" data-toggle="tab"><i class="fa fa-sitemap" style="color:#1DB2C8"></i> Sites</a></li>
            <li><a href="#tab3users" role="tab" data-toggle="tab"><i class="fa fa-user-plus" style="color:#FC5830"></i> Users</a></li>
            <li><a href="#tab4assets" role="tab" data-toggle="tab"><i class="fa fa-desktop" style="color:#2C98F0"></i> Assets</a></li>
            <li class="dropdown">
              <a href="#" data-toggle="dropdown"><i class="fa fa-wrench" style="color:#333333"></i> Services <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#tab11internal" role="tab" data-toggle="tab"><i class="fa fa-wrench" style="color:#333333"></i> Internal Services</a></li>
                <li><a href="#tab12external" role="tab" data-toggle="tab"><i class="fa fa-wrench" style="color:#333333"></i> External Services</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" data-toggle="dropdown"><i class="fa fa-wrench" style="color:#333333"></i> Web Services <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#tab6webhosting" role="tab" data-toggle="tab"><i class="fa fa-wrench" style="color:#333333"></i> Web Hosting</a></li>
                <li><a href="#tab7domains" role="tab" data-toggle="tab"><i class="fa fa-wrench" style="color:#333333"></i> Domains</a></li>
                <li><a href="#tab8crushftp" role="tab" data-toggle="tab"><i class="fa fa-wrench" style="color:#333333"></i> SFTP</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" data-toggle="dropdown"><i class="fa fa-certificate" style="color:#333333"></i> Licenses <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#tab9email" role="tab" data-toggle="tab"><i class="fa fa-certificate" style="color:#333333"></i> eMail</a></li>            
              </ul>
            </li>
              <!--  <li><a href="#tab10faq" role="tab" data-toggle="tab"><i class="fa fa-question" style="color:#1DB2C8"></i> FAQ</a></li> -->
           <!-- Commented out for now <li><a href="#tab10migrations" role="tab" data-toggle="tab"><i class="fa fa-rocket" style="color:#2C98F0"></i> Migrations</a></li> -->
          </ul>
         </div>
        </div>
        
        <div class="panel-body">
          <div class="tab-content">
            <div class="tab-pane active" id="tab1overview">
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                 <tbody>
                    <tr>
                      <th scope="row"><strong>Client:</strong></th>
                      <td>
                        <?php $client_id = get_post_meta( get_the_id(), 'client', true );?>
                        <a href="<?php echo get_permalink($client_id);?>" class="text-default">
                          <?php echo get_the_title($client_id);?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row"><strong>Main Office Telephone:</strong></th>
                      <td>
                        <?php $meta_key = 'telephone'; $id = get_the_id(); ?>
                        <a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row"><strong>Email:</strong></th>
                      <td>
                        <?php $meta_key = 'email'; $id = get_the_id(); ?>
                        <a data-title="Email" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row"><strong>Website:</strong></th>
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
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => array(
          array(
            'key'     => 'client',
            'value'   => get_the_id(),
            'compare' => '=',
    ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) :  ?>
<div class="table-responsive">
                    <table class="table table-striped table-hover">
                    <tr>
                      <th width="10%"><p class="text-info"><i class="fa fa-sitemap" title="Number of sites"></i> <?php echo $the_query->found_posts; ?> Sites</p></th>
                      <th width="15%"><strong>Site Name</strong></th>
                      <th width="15%"><strong>Address</strong></th>
                      <th width="5%"><strong>Town</strong></th>
                      <th width="10%"><strong>County</strong></th>
                      <th width="10%"><strong>Postcode</strong></th>
                      <th width="5%"><strong>Email</strong></th>
                      <th width="15%"><strong>Telephone</strong></th>
                      <th width="15%"></th>
                      
                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                     
                    <!--Quickview-->
                     <td align="center">    <a href="<?php the_permalink();?>" target="_blank"><span class="fas fa-eye fa-lg" title="Fullview"></span></a></td>
                     <!--Site Name-->
                     <td align="center">    <?php echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>'; ?></td>
                    <!--Address -->
                    <td align="center"><?php $meta_key = 'address'; $id = get_the_id();?>
                        <a data-title="Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Town-->
                    <td align="left"><?php $meta_key = 'netbios_name'; $id = get_the_id();?>
                        <a data-title="Town" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--County-->
                    <td align="center"><?php $meta_key = 'County'; $id = get_the_id();?>
                        <a data-title="County" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                     <!--Postcode-->
                    <td align="center"><?php $meta_key = 'postcode'; $id = get_the_id();?>
                        <a data-title="Postcode" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Email Address-->
                    <td align="center"><?php $meta_key = 'email'; $id = get_the_id();?>
                        <a data-title="Email" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Telephone-->
                    <td align="center"><?php $meta_key = 'telephone'; $id = get_the_id();?>
                        <a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Features-->
                     <td align="center"><a href="#sitestatus_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#sitestatus_<?php $post_id = get_the_ID(); echo $post_id;?>"> <span class="fa fa-check-circle fa-lg <?php if( empty( get_post_meta( $post_id, 'site_status', true ) ) ) : echo 'false'; endif; ?>" style="color:#50AE54" title="Site Status"></span></a>
                     <a data-toggle="modal" data-target="#sitemap" data-lat='<?php echo get_post_meta($post->ID, 'latitude', true); ?>' data-lng='<?php echo get_post_meta($post->ID, 'longitude', true); ?>'><span class="fas fa-map-marker-alt fa-lg <?php if( empty( get_post_meta( $post_id, 'latitude', true ) ) ) : echo 'false'; endif; ?>" title="Site Map" ></span></a>
                     <a href="#config_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#config_<?php $post_id = get_the_ID(); echo $post_id;?>"><span class="fas fa-toolbox fa-lg <?php  $config_email = get_post_meta( $post_id, 'email_address', 'password', false ); if( empty( $config_email ) ) : echo 'false'; endif; ?>" title="Site Config Details"></span></a>
                     
                     <a href="#sitenotes_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#sitenotes_<?php $post_id = get_the_ID(); echo $post_id;?>"> <span class="fas fa-sticky-note fa-lg <?php if( empty( get_post_meta( $post_id, 'site_notes', 'date_completed', false ) ) ) : echo 'false'; endif; ?>" title="Site Notes"></span></a>
                     
                    </td>
                     <td class="modalsloader"><?php
                     include get_template_directory() . '/sites-modal.php'; ?></td> 
                     </tr>
 
   


                    <?php endwhile; 
  
  echo '</table></div>
  <!-- Modal -->
  <div class="modal fade" id="sitemap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Modal title</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 modal_body_content">
              <p>Some contents...</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 modal_body_map">
              <div class="location-map" id="location-map">
                <div style="width: 600px; height: 400px;" id="map_canvas"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 modal_body_end">
              <p>Else...</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbJbWvTXTgScvrpLlCDRg3iYnBZb3-9Kw&callback=initMap">
  </script>';
  
else :

  echo '<p>This Client has no sites</p>';
  
endif;

wp_reset_postdata();?>
                    <!-- Table -->
                

            </div>

            <?php 
//start the buffer
ob_start();

get_template_part('dashboards/users');

//store out output buffer
$string = ob_get_contents();

//clear the buffer and close it
ob_end_clean(); ?>

<div class="tab-pane fade" id="tab3users">
<?php

echo do_shortcode( '[ms-protect-content id="1570,1618"]' . $string . '[/ms-protect-content]' );?>
</div>
            <div class="tab-pane fade" id="tab4assets">
             
              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'assets',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
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
                    <table class="table table-striped table-hover">
                    <tr>
                      <th width="10%"><p class="text-success"><i class="fa fa-desktop" title="Number of assets"></i> <?php echo $the_query->found_posts; ?> Assets</p></th>
                      <th width="10%"><strong>Asset ID</strong></th>
                      <th width="15%"><strong>Netbios Name</strong></th>
                      <th width="10%"><strong>Device Class</strong></th>
                      <th width="10%"><strong>Lan IP</strong></th>
                      <th width="10%"><strong>WAN IP</strong></th>
                      <th width="15%"><strong>Site Location</strong></th>
                      <th width="25%"><strong>Features</strong></th>
                      
                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                     
                    <!--Quickview-->
                     <td align="center">    <a href="<?php the_permalink();?>" target="_blank"><span class="fas fa-eye fa-lg" title="Fullview"></span></a></td>
                    <!--Asset ID -->
                    <td align="center"><?php $meta_key = 'asset_id'; $id = get_the_id();?>
                        <a data-title="Asset ID" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Netbios Name-->
                    <td align="left"><?php $meta_key = 'netbios_name'; $id = get_the_id();?>
                        <a data-title="Netbios Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Device Class-->
                    <td align="left"><?php $meta_key = 'device_class'; $id = get_the_id(); ?><a data-title="Device Class" href="#" id="vpn" name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'windows-workstation',text:'Windows Workstation'},{value:'windows-laptop',text:'Windows Laptop'},{value:'laptop-mac',text:'Laptop Mac'},{value:'workstation-mac',text:'Workstation Mac'},{value:'server',text:'Server'},{value:'router',text:'Router'},{value:'printer',text:'Printer'},{value:'switch',text:'Switch'},{value:'storage',text:'Storage'},{value:'scanner-camera',text:'Scanner & Camera'}, {value:'peripheral',text:'Peripheral'}, {value:'access-point',text:'Access Point'}]" data-pk="<?php echo $id;?>"   class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
                     <!--Lan IP-->
                    <td align="center"><?php $meta_key = 'lan_ip'; $id = get_the_id();?>
                        <a data-title="Lan IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--WAN IP-->
                    <td align="center"><?php $meta_key = 'wan_ip'; $id = get_the_id();?>
                        <a data-title="Wan IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Site Location-->
                    <td align="center"><?php $meta_key = 'site'; $id = get_the_id();?>
                       <a href="<?php echo get_permalink($site_id);?>" class="text-default">
                          <?php echo get_the_title(get_post_meta($id, $meta_key, true ))?>
                        </a></td>
                    <!--Features-->
                     <td align="center"><a href="#assetstatus_<?php echo $id;?>" data-toggle="modal" data-target="#assetstatus_<?php echo $id;?>"> <span class="fa fa-check-circle fa-lg <?php if( empty( get_post_meta( $id, 'asset_status', true ) ) ) : echo 'false'; endif; ?>" style="color:#50AE54" title="Asset Status"></span></a>
                     <a href="#assetprolicense_<?php echo $id;?>" data-toggle="modal" data-target="#assetprolicense_<?php echo $id;?>"><span class="fab fa-product-hunt fa-lg <?php if( empty( get_post_meta( $id, 'pro_license', true ) ) ) : echo 'false'; endif; ?>" title="Guru License" ></span></a>
                     <a href="#assetbackup_<?php echo $id;?>" data-toggle="modal" data-target="#assetbackup_<?php echo $id;?>"><span class="fas fa-database fa-lg <?php if( empty( get_post_meta( $id, 'msp_backup_schedule', true ) ) ) : echo 'false'; endif; ?>" title="Backup"></span></a>
                     <a href="#assetpatchmanagement_<?php echo $id;?>" data-toggle="modal" data-target="#assetpatchmanagement_<?php echo $id;?>"> <span class="fas fa-tasks fa-lg <?php if( empty( get_post_meta( $id, 'patch_installed', true ) ) ) : echo 'false'; endif; ?>" title="Patch Management"></span></a>
                     <a href="#assetlogins_<?php echo $id;?>" data-toggle="modal" data-target="#assetlogins_<?php echo $id;?>"><span class="fas fa-sign-in-alt fa-lg <?php if( empty( get_post_meta( $id, 'local_admin_username', true ) ) ) : echo 'false'; endif; ?>" title="Asset Logins" ></span></a>
                     <a href="#assetex05_<?php echo $id;?>" data-toggle="modal" data-target="#assetex05_<?php echo $id;?>"> <span class="fas fa-lock fa-lg <?php if( empty( get_post_meta( $id, 'ex05_licence', true ) ) ) : echo 'false'; endif; ?>" title="Encryption"></span></a>
                     <a href="#assetsecurity_<?php echo $id;?>" data-toggle="modal" data-target="#assetsecurity_<?php echo $id;?>"> <span class="fas fa-key fa-lg <?php if( empty( get_post_meta( $id, 'av_installed', true ) ) ) : echo 'false'; endif; ?>" title="Security Manager"></span></a>
                     <a href="#assetspecs_<?php echo $id;?>" data-toggle="modal" data-target="#assetspecs_<?php echo $id;?>"><span class="fas fa-glasses fa-lg <?php if( empty( get_post_meta( $id, 'manufacturer', true ) ) ) : echo 'false'; endif; ?>" title="Specifications"></span></a>
                     <a href="#assetwarranty_<?php echo $id;?>" data-toggle="modal" data-target="#assetwarranty_<?php echo $id;?>"><span class="fas fa-pound-sign fa-lg <?php if( empty( get_post_meta( $id, 'purchase_order_no', true ) ) ) : echo 'false'; endif; ?>" title="Purchasing & Warranty Information"></span></a>
                     </td>
                     <td class="modalsloader"><?php
                     include get_template_directory() . '/assets-modal.php'; ?></td> 
                     </tr>
                   
                    


                    
                    <?php
                    endwhile;
  
  echo '</table></div>';
 
  
else :

  echo '<p>This Client Has no Assets</p>';
  
endif;

wp_reset_postdata();?>
                    <!-- Table -->
                    
                
            </div>
              
            <div class="tab-pane fade" id="tab9email">
              <?php	
              
$args = array(
		'post_type' => 'services',
    'posts_per_page' => 999,
    'orderby' => 'title',
    'order' => 'ASC',
		'meta_query' => array(
			array(
				'key'     => 'client',
				'value' => get_the_id(),
				'compare' => '=',
      ),
      array(
        'key' => 'type',
            'value' => 'email' ,
          ),
		)
	);

	$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>
<div class="post_count"><?php echo $the_query->found_posts; ?> Email Accounts</div>
                <div class="table-responsive">
                  <table class="table">
                    <tr>

                      <th><strong>Email Address</strong></th>
                      <th><strong>Password</strong></th>
                      <th><strong>Licence Type</strong></th>


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
                        <a data-title="Password" href="#" id="password" type="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        <i class="glyphicon glyphicon-eye-open"></i>
                      </td>
                      <td>
                        <?php $meta_key = 'license_type'; $id = get_the_id();?>
                        <a data-title="License Type" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>


                    </tr>


                    <?php endwhile; wp_reset_postdata();
  
  echo '</table></div>'; ?>
					  <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#email">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add Email 
</button>

                    <!-- Modal -->
                    <div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="email">Add Email</h5>
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
					  <?php wp_reset_postdata();
  
else :

  echo '<p>Client Has No Email Services</p>'; ?>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#email">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add Email 
</button>

                    <!-- Modal -->
                    <div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="email">Add Email</h5>
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
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key'     => 'client',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'internal' ,
        ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>
<div class="post_count"><?php echo $the_query->found_posts; ?> Internal Services</div>
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th></th>
                      <th><strong>Service Name</strong></th>
                      <th><strong>URL</strong></th>
                      <th><strong>Username</strong></th>
                      <th><strong>Password</strong></th>
                      <th><strong>Notes</strong></th>




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
                        <a data-title="Domain Expiry Date" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        <i class="glyphicon glyphicon-eye-open"></i>
                      </td>
                      <td>
                        <?php $meta_key = 'internal_notes'; $id = get_the_id();?>
                        <a data-title="Registra Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>


                    </tr>


                    <?php endwhile; wp_reset_postdata();
  
  echo '</table></div>';?>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#internalservices">
  <span class="glyphicon glyphicon-plus-sign"></span>  Add Internal Services
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

  echo '<p>This Client Has No Internal Services</p>'; ?>
					  
					  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#internalservices">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add Internal Services
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
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key'     => 'client',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'hosting' ,
        ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>
<div class="post_count"><?php echo $the_query->found_posts; ?> Web Hosting Accounts</div>
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th></th>
                      <th><strong>Host</strong></th>
                      <th><strong>cPanel Username</strong></th>
                      <th><strong>cPanel Password</strong></th>
                      <th><strong>cPanel Login URL</strong></th>
                      <th><strong>FTP Port</strong></th>
                      <th><strong>Package</strong></th>
                      <th><strong>Server</strong></th>
                      <th><strong>Status</strong></th>
                      <th><strong>Login to hosting</strong></th>



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
                        <a data-title="cPanel Password" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        <i class="glyphicon glyphicon-eye-open"></i>
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
					  <?php
  
else :

  echo '<p>This Client Has no Assets</p>';
  
endif;
					  wp_reset_postdata();?>
					 
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#hostingmodal">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add Web Hosting
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
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key'     => 'client',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'domain' ,
        ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>
<div class="post_count"><?php echo $the_query->found_posts; ?> Domains</div>
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th></th>
                      <th><strong>Domain</strong></th>
                      <th><strong>Registra</strong></th>
                      <th><strong>Expires</strong></th>
                      <th><strong>Namservers</strong></th>
                      <th><strong>Registra Username</strong></th>
                      <th><strong>Registra Password</strong></th>



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
                        <a data-title="Domain Expiry Date" href="#" id="date" name="<?php echo $meta_key;?>" data-type="date" data-format="dd/mm/yyyy" data-viewformat="dd/mm/yyyy" data-inputclass="date" data-pk="<?php echo $id;?>" class="text-field">
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
                        <a data-title="Registra Password" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        <i class="glyphicon glyphicon-eye-open"></i>
                      </td>

                    </tr>


                    <?php endwhile;
  
  echo '</table></div>'; wp_reset_postdata(); ?>
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#domainsmodal">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add Domains
</button>

                <!-- Modal -->
                <div class="modal fade" id="domainsmodal" tabindex="-1" role="dialog" aria-labelledby="domainsmodal" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="domainsmodal">Create Client Domain</h5>
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
                        <h5 class="modal-title" id="domainsmodal">Create Client Domain</h5>
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
    'orderby' => 'title',
    'order' => 'ASC',
		'meta_query' => array(
			array(
				'key'     => 'client',
				'value'   => get_the_id(),
				'compare' => '=',
      ),
      array(
        'key' => 'type',
            'value' => 'crush' ,
          ),
		)
	);

	$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>
<div class="post_count"><?php echo $the_query->found_posts; ?> SFTP Accounts</div>
                <div class="table-responsive">
                  <table class="table">
                    <tr>

                      <th><strong>Host</strong></th>
                      <th><strong>Username</strong></th>
                      <th><strong>Password</strong></th>
                      <th><strong>Port</strong></th>
                      <th><strong>URL</strong></th>
                      <th><strong>Package</strong></th>
                      <th><strong>Status</strong></th>


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
                        <a data-title="Password" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        <i class="glyphicon glyphicon-eye-open"></i>
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
  
  echo '</table></div>'; wp_reset_postdata(); ?>
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crushftp">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add SFTP
</button>

                <!-- Modal -->
                <div class="modal fade" id="crushftp" tabindex="-1" role="dialog" aria-labelledby="crushftp" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="crushftp">Add SFTP</h5>
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
  Add SFTP
</button>

                <!-- Modal -->
                <div class="modal fade" id="crushftp" tabindex="-1" role="dialog" aria-labelledby="crushftp" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="crushftp">Create Web Hosting</h5>
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
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key'     => 'client',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'external' ,
        ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>
<div class="post_count"><?php echo $the_query->found_posts; ?> External Services</div>
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th></th>
                      <th><strong>Service Name</strong></th>
                      <th><strong>URL</strong></th>
                      <th><strong>Username</strong></th>
                      <th><strong>Password</strong></th>

                      <th><strong>Notes</strong></th>




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
                        <a data-title="External Password" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        <i class="glyphicon glyphicon-eye-open"></i>
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
  <span class="glyphicon glyphicon-plus-sign"></span>    Add External Service
</button>

                <!-- Modal -->
                <div class="modal fade" id="externalservice" tabindex="-1" role="dialog" aria-labelledby="externalservice" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="externalservice">Add External Service</h5>
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
                        <h5 class="modal-title" id="externalservice">Add External Service</h5>
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
                 <div class="tab-pane fade" id="tab10faq">
                 <?php

	$args = array(
		'post_type' => 'notes',
    'posts_per_page' => 999,
    'orderby' => 'title',
    'order' => 'ASC',
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
<div class="post_count"><?php echo $the_query->found_posts; ?> Notes</div>
                <div class="table-responsive">
                  <table class="table">
                    <tr>

                      <th><strong>Notes</strong></th>
                     


                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td>
                        <?php $meta_key = 'faq_notes'; $id = get_the_id();?>
                        <a data-title="Host" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                     

                    </tr>


                    <?php endwhile;
  
  echo '</table></div>'; ?>
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#notes">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add Note
</button>

                <!-- Modal -->
                <div class="modal fade" id="notes" tabindex="-1" role="dialog" aria-labelledby="notes" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="notes">Create Notes</h5>
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

  echo '<p>Client Has No Notes</p>'; ?>
					  
					   <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crushftp">
  Add Note
</button>

                <!-- Modal -->
                <div class="modal fade" id="crushftp" tabindex="-1" role="dialog" aria-labelledby="crushftp" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="notes">Create Notes</h5>
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
            </div>
          </div>
          </div>

        </div>
            
     
        </div>
      


      <?php get_template_part('client', 'box');?>



      



      <?php get_footer(); ?>
      