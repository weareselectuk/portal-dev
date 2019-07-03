<?php

// get all associated services associated with this client

 $args = array(
        'post_type' => 'users',
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
                      <th><strong>Title</strong></th>
                      <th><strong>First Name</strong></th>
                      <th><strong>Last Name</strong></th>
                      <th><strong>DDI Telephone</strong></th>
                      <th><strong>Mobile</strong></th>
                      <th><strong>Email</strong></th>
                    
                      <th width="15%">Features</th>
                      
                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                     <!--Quickview-->
                     <td align="center">    <a href="<?php the_permalink();?>" target="_blank"><span class="fas fa-eye fa-lg" title="Fullview"></span></a></td>
                      <!--Title-->
                     <td></td>
                      <!--First Name-->
                     <td></td>
                      <!--Last Name-->
                     <td></td>
                      <!--DDI-->
                     <td></td>
                      <!--Mobile-->
                     <td></td>
                      <!--Email-->
                     <td></td>
                    
                     <!--Features-->
                      <td align="center"><a href="#sitestatus_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#sitestatus_<?php $post_id = get_the_ID(); echo $post_id;?>"> <span class="fa fa-check-circle fa-lg <?php if( empty( get_post_meta( $post_id, 'site_status', true ) ) ) : echo 'false'; endif; ?>" style="color:#50AE54" title="Site Status"></span></a>
                     <a href="#sitemap_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#sitemap_<?php $post_id = get_the_ID(); echo $post_id;?>"><span class="fas fa-map-marker-alt fa-lg <?php if( empty( get_post_meta( $id, 'msp_backup_schedule', true ) ) ) : echo 'false'; endif; ?>" title="Site Map" ></span></a>
                     <a href="#config_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#config_<?php $post_id = get_the_ID(); echo $post_id;?>"><span class="fas fa-toolbox fa-lg <?php if( empty( get_post_meta( $id, 'Config', true ) ) ) : echo 'false'; endif; ?>" title="Site Config Details"></span></a>
                     <a href="#configphotos_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#configphotos_<?php $post_id = get_the_ID(); echo $post_id;?>"><span class="fas fa-camera fa-lg <?php if( empty( get_post_meta( $id, 'Config', true ) ) ) : echo 'false'; endif; ?>" title="Site Config Photos"></span></a>
                     <a href="#sitenotes_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#sitenotes_<?php $post_id = get_the_ID(); echo $post_id;?>"> <span class="fas fa-sticky-note fa-lg <?php if( empty( get_post_meta( $id, 'local_admin_username', true ) ) ) : echo 'false'; endif; ?>" title="Site Notes"></span></a>
                    </td>
                     <td class="modalsloader"><?php
                     include get_template_directory() . '/users-modal.php'; ?></td> 
                     </tr>


              
                   
                    
 
   


                    <?php endwhile;
  
  echo '</table></div>';
  
else :

  echo '<p>This Client has no sites</p>';
  
endif;

wp_reset_postdata();?>
                    <!-- Table -->
                

            </div>






