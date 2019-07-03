<?php
/*
This is the custom post type taxonomy template.
If you edit the custom taxonomy name, you've got
to change the name of this template to
reflect that name change.

i.e. if your custom taxonomy is called
register_taxonomy( 'shoes',
then your single template should be
taxonomy-shoes.php

*/
?>

<?php get_header(); ?>

  <div class="row" id="content">
    <div class="large-8 medium-8 small-12 columns" id="main">

    <h1><?php single_cat_title(); ?></h1>

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