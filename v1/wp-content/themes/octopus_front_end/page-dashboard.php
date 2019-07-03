<?php /* Template Name: Dashboard */ get_header(); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <!-- Page header -->
    <div class="page-header page-header-default">
      <div class="page-header-content">
        <div class="page-title">
          <h4><i class="icon-arrow-left52 position-left"></i> <?php the_title();?></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group">
            <a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
            <a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
            <a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
          </div>
        </div>
      </div>

      <div class="breadcrumb-line">
        <ul class="breadcrumb">
          <?php echo bcn_display_list(); ?>
        </ul>
      </div>
    </div>
    <!-- /page header -->

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