<?php get_header(); ?>

  <div class="row" id="content">
    <div class="large-8 medium-8 small-12 columns" id="main">

      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" class="panel">

        <header><h2><?php the_title();?></h2></header>

        <?php the_post_thumbnail(); ?>

        <?php the_content('Read more &raquo;'); ?>

      </article>

      <?php comments_template(); ?>

      <?php endwhile; else : ?>
          
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