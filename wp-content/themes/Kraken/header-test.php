<!DOCTYPE html>
<html lang="en" style="overflow-y:hidden">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<title>Select | Portal |
		<?php wp_title('', true, 'right'); ?>
	</title>

	<!-- wordpress head functions -->
	<?php wp_head(); ?>
	<!-- end of wordpress head -->




</head>

<body class="navbar-top sidebar-xs">

	<!-- Main navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top" style="background-color: rgba(42, 49, 126);">
		<div class="navbar-header" style="background-color:#932082;height:52px;">
			<ul class="nav navbar-nav visible-xs-block">
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-tree5"></i></a></li>
			</ul>
			<ul class="nav navbar-nav" style="float: inherit;font-weight:light">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i
						 class="fa fa-building" style="color:#ffffff"></i>
						<?php
			if ( 'clients' == get_post_type() ) {
		   echo the_title();
		   }
		   if ( 'users' == get_post_type() ) {
			echo get_the_title( $my_meta = get_post_meta( $post->ID, 'client', true ) );
			}
			if ( 'sites' == get_post_type() ) {
				echo get_the_title( $my_meta = get_post_meta( $post->ID, 'client', true ) );
				}
			if ( 'assets' == get_post_type() ) {
			echo get_the_title( $my_meta = get_post_meta( $post->ID, 'client', true ) );
			}		
        ?>
						<span class="caret"></span></a>
					<ul class="dropdown-menu scrollable-menu" role="menu">
						<li>
							<?php

          $args = array(
                            'post_type' => 'clients',
                            'posts_per_page' => 99,
                            'orderby' => 'title',
                            'order' => 'ASC'
                          );

          $the_query = new WP_Query( $args );

          if ($the_query->have_posts()) : while ( $the_query->have_posts() ) : $the_query->the_post();
             
              echo '<a href="'.get_permalink().'">'.get_the_title().'</a>';
          endwhile; endif;

          wp_reset_postdata();


        ?>
						</li>

					</ul>
				</li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile" style="z-index:1025;">
			
			<?php /* Primary navigation */
wp_nav_menu( array(
  'menu' => '4',  
  'container' => false,
  'menu_class' => 'nav navbar-nav',
  //Process nav menu using our custom nav walker
  'walker' => new rc_scm_walker,))
?>
			
		</div>
	</div>

	<!-- /main navbar -->
	

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<?php get_sidebar( 'left' ); ?>

			<!-- /panel heading placement -->




		</div>
	</div>
	<!-- /main sidebar -->


	<!-- Main content -->
	<div class="content-wrapper">