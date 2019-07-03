<?php get_header(); ?>

  <div class="row" id="content">
    <div class="large-8 medium-8 small-12 columns" id="main">

    <h1>
  		<?php
  		if (is_category()) {
  			single_cat_title();
  		}
  		elseif (is_tag()) { 
  			_e("Posts tagged ", "honeypot") . single_tag_title();
  		}
  		elseif (is_author()) { 
  			_e("Posts by ", "honeypot") . get_the_author_meta('display_name');
  		}
  		elseif (is_day()) {
  			_e("Daily archives for ", "honeypot") . the_time('l, F j, Y');
  		}
  		elseif (is_month()) {
  			_e("Monthly archives for ", "honeypot") . the_time('F Y');
  		}
  		elseif (is_year()) {
  			_e("Yearly archives for ", "honeypot") . the_time('Y');
  		}
  		?>
    </h1>

      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

      <article class="panel">

        <header><h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3></header>

        <?php the_excerpt('Read more &raquo;'); ?>

      </article>

      <?php endwhile; ?>  
          
        <?php if (function_exists('page_navi')) {
          page_navi();
        } else { ?>
            <nav class="wp-prev-next">
              <ul class="clearfix">
                <li class="prev-link"><?php next_posts_link(_e('&laquo; Older Entries', 'honeypot')) ?></li>
                <li class="next-link"><?php previous_posts_link(_e('Newer Entries &raquo;', 'honeypot')) ?></li>
              </ul>
            </nav>
        <?php } ?>    
          
      <?php else : ?>
          
        <article id="post-not-found">
            <header><h3><?php _e( '404 Page Not Found', 'honeypot' ) ?></h3></header>
            <p><?php _e( 'The page you requested could not be found due to a site error.', 'honeypot' ) ?></p>
            <p><?php _e( 'It\'s not you, it\'s us. The page you requested is most likely being maintained and will reappear here shortly.', 'honeypot' ) ?></p>
            <p><a href="<?php the_permalink();?>"><?php _e( 'Refresh this page', 'honeypot' ) ?></a> <?php _e( 'to try again or try to reaccess it via', 'honeypot' ) ?> <a href="<?php echo get_bloginfo('url');?>"><?php _e( 'our homepage', 'honeypot' ) ?></a>.</p>
        </article>
          
      <?php endif; ?>
      
    </div>

    <?php get_sidebar(); ?>

  </div>

<?php get_footer(); ?>