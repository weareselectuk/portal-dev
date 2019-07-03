<?php /* Template Name: Search */ get_header(); ?>

<!-- Main content -->
      <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Search</span></h4>

              <ul class="breadcrumb position-right">
                <?php echo bcn_display_list(); ?>
              </ul>

            </div>

            <!--div class="heading-elements">
              <div class="heading-btn-group">
                <a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                <a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                <a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
              </div>
            </div-->
          </div>
        </div>
        <!-- /page header -->


        <!-- Content area -->
        <div class="content">

          <!-- Search field -->
          <div class="panel panel-flat">
            <div class="panel-heading">
              <h5 class="panel-title">Website search results</h5>
              <div class="heading-elements">
                <ul class="icons-list">
                          <li><a data-action="collapse"></a></li>
                          <li><a data-action="close"></a></li>
                        </ul>
                      </div>
            </div>

            <div class="panel-body">
              
              <form  method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="main-search">
                <div class="input-group content-group">
                  <div class="has-feedback has-feedback-left">
                    <input type="text" class="form-control input-xlg search-autocomplete" name="s" placeholder="Search..." <?php if(isset($_GET['s'])) { echo 'value="'.$_GET['s'].'"';} ?>>
                    <div class="form-control-feedback">
                      <i class="icon-search4 text-muted text-size-base"></i>
                    </div>
                  </div>

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-primary btn-xlg">Search</button>
                  </div>
                </div>
              </form>

            </div>
          </div>
          <!-- /search field -->




          <!-- Search results -->
          <div class="row">
            
              <div class="panel panel-body">

                  

              </div>
            </div>
          </div>

          <?php get_template_part('footer', 'simple');?>

        </div>
        <!-- /content area -->

<?php get_footer(); ?>