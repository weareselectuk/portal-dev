<?php get_header(); ?>

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