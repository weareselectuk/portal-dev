<?php /*Template Name: roadmap*/ get_header(); ?>
<?php include get_template_directory() . '/changelog-menu.php';?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
         
            <?php the_content();?>
          
        </div>

        
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="createbug" tabindex="-1" role="dialog" aria-labelledby="createbug" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createbug">Create Bug </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     <?php echo do_shortcode("[ninja_form id=20]"); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
    </div>
  </div>
</div>
  
  
<?php get_template_part('footer', 'simple');?>