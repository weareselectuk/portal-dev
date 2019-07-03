<?php /*Template Name: bugs-dashbaord*/ get_header(); ?>

<?php include get_template_directory() . '/changelog-menu.php';?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
         
            <?php

// get all bugs from custom post type

  $args = array(
        'post_type' => 'bugs',
        'posts_per_page' => 999,
        'orderby' => 'title',
        'order' => 'ASC',    
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) :  ?>
<a href="#" class="btn btn-xs btn-primary"><span class="fa fa-bug"></span> <?php echo $the_query->found_posts; ?> Bugs</a>
   <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th><strong>Ticket ID</strong></th>
                      <th><strong>Description</strong></th>
                      <th><strong>Milestone</strong></th>
                      <th><strong>Priority</strong></th>
                      <th><strong>Severity</strong></th>
                      <th><strong>Type</strong></th>
                      <th><strong>Area Effected</strong></th>
                      <th><strong>Status</strong></th>
                      <th><Strong>Workflow</Strong></th>
                      <th><strong>Date Modified</strong></th>
                      <th></th>
                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr>
                      <td>
                        
                        <?php $post_id = get_the_ID(); echo $post_id; ?>
                        <a data-title="Ticket ID" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        
                      </td>
                      <td>
                   <?php $meta_key = 'description'; $id = get_the_id();?>
                        <a data-title="Description" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        
                      </td>
                      <td>
                       <?php $meta_key = 'milestone'; $id = get_the_id();?>
                        <a data-title="Milestone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                       <?php $meta_key = 'priority'; $id = get_the_id();?>
                        <a data-title="Priority href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                       <?php $meta_key = 'severity'; $id = get_the_id();?>
                        <a data-title="Severity" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                       <?php $meta_key = 'type'; $id = get_the_id();?>
                        <a data-title="Type" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                       <?php $meta_key = 'area_affected'; $id = get_the_id();?>
                        <a data-title="Area Affected" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                         <?php $meta_key = 'status'; $id = get_the_id();?>
                        <a data-title="Status" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                         <?php $meta_key = 'workflow'; $id = get_the_id();?>
                        <a data-title="Workflow" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                       
                         <?php $meta_key = 'date_modified'; $id = get_the_id();?>
                        <a data-title="Date Modified" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      
                    </tr>


                    <?php endwhile;
  
  echo '</table></div>';
  
else :

  echo '<p>There are no active tickets</p>';
  
endif;

wp_reset_postdata();?>
                    <!-- Table -->
                

            </div>
        
        </div>

        
      </div>
    </div>
  </div>
</div>
<?php get_template_part('footer', 'simple');?>