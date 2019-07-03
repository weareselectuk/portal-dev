<?php /*Template Name: Filter*/ get_header(); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php
 
require_once( trailingslashit( get_template_directory() ). 'header-bar.php' );
 
?>

    <!-- Content area -->
    <div class="content">

      <div class="row">

        <div class="col-lg-12">

          <div class="panel panel-flat">

            <div class="container-fluid">

              <?php the_content();?>
 <input type="hidden" name="type" value="<?php echo $_GET['type'];?>"/>
                <input type="hidden" name="device" value="<?php echo $_GET['device'];?>"/>

                
       
              <?php

             if(isset($_GET['device']) && strpos($_GET['device'], '|') !== false) {
                // type paramter contains multiple devices
                $devices = explode("|",$_GET['device']);
                $compare = "IN";
              }
              else {
                $devices = $_GET['device'];
                $compare = "=";
              }

              //echo $devices;

              $args = array(
                'post_type' => $_GET['type'],
                'posts_per_page' => -1,
                // 'meta_query' => array(
                //   array(
                //     'key'     => 'device_class',
                //     'value'   => $devices,
                //     'compare' => $compare,
                //   ),
                // ),
              );

              $meta_array = array();

              if(isset($_GET['device']) && $_GET['device']!='') {
                $meta_device = array();
                $meta_device['key'] = 'device_class';
                $meta_device['compare'] = $compare;
                $meta_device['value'] = $devices;

                array_push($meta_array,$meta_device);
              }

              if(isset($_GET['client'])) {

                // if we have a client id, filter by that too

                $meta_client = array();
                $meta_client['key'] = 'client';
                $meta_client['compare'] = '=';
                $meta_client['value'] = $_GET['client'];
                
                array_push($meta_array,$meta_client);

              }

              $args['meta_query'] = $meta_array;

              $the_query = new WP_Query( $args );

              if ($the_query->have_posts()) : ?>

                  <p class="text-muted text-size-small">
                    <?php
                    global $wp_query;
                    echo 'About '.$the_query->found_posts.' results found.';?>
                  </p>

                  <hr>
<div class="table-responsive">
                <table class="table table-striped">
                <thead>
    <tr>
      <th></th>
      <th><strong>Asset ID</strong></th>
      <th><strong>Device Class</strong></th>
      <th><strong>Netbios Name</strong></th>
	  <th><strong>Asset Status</strong></th>
	  <th></th>
    </tr>
  </thead>

                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                
                  <?php
                  //You'll probably want to display different coloumns for different assets, so Im splitting out the "view" for each table 

                  if(isset($_GET['device']) && $_GET['device'] == 'workstation-windows') {
                    get_template_part('filters/workstation','windows');
                  }

                  elseif(isset($_GET['device']) && $_GET['device'] == 'workstation-mac') {
                    get_template_part('filters/workstation','mac');
                  }


                  elseif(isset($_GET['device']) && $_GET['device'] == 'laptop-windows') {
                    get_template_part('filters/laptop','windows');
                  }


                  elseif(isset($_GET['device']) && $_GET['device'] == 'laptop-mac') {
                    get_template_part('filters/laptop','mac');
                  }


                  elseif(isset($_GET['device']) && $_GET['device'] == 'firewall') {
                    get_template_part('filters/firewall');
                  }


                  elseif(isset($_GET['device']) && $_GET['device'] == 'router') {
                    get_template_part('filters/router');
                  }


                  elseif(isset($_GET['device']) && $_GET['device'] == 'switch') {
                    get_template_part('filters/switch');
                  }


                  elseif(isset($_GET['device']) && $_GET['device'] == 'printer') {
                    get_template_part('filters/printer');
                  }


                  elseif(isset($_GET['device']) && $_GET['device'] == 'storage') {
                    get_template_part('filters/storage');
                  }
                  
                   elseif(isset($_GET['device']) && $_GET['device'] == 'server') {
                    get_template_part('filters/server');
                  }
                  
                  elseif(isset($_GET['user']) && $_GET['user'] == 'users') {
                    get_template_part('filters/users');
                  }


                  else { ?>
<tbody>
                  <tr>
                    <td><a href="<?php the_permalink();?>"><?php the_title();?></a></h6></td>
                    <td><?php echo get_post_meta( get_the_id(), 'asset_id', true );?></td>
                    <td><?php echo get_post_meta( get_the_id(), 'device_class', true );?></td>
                    <td><?php echo get_post_meta( get_the_id(), 'netbios_name', true );?></td>
                    <td><?php echo get_post_meta( get_the_id(), 'asset_status', true );?></td>
                    <td><a href="<?php the_permalink();?>" class="btn btn-warning">View</a></td>
                  </tr>

                  <?php }

                endwhile; ?>
                
                </tbody>
                </table>
                
              <?php else : ?>

                <p>No results</p>
                
              <?php endif;

              wp_reset_postdata();


              ?>
                
</div>
            </div>

          </div>

        </div>


      </div>

      

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