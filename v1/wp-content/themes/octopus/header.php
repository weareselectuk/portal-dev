<!DOCTYPE html>
<html lang="en">
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
<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<title>We Are Select | Portal | <?php wp_title('', true, 'right'); ?></title>
    
  <!-- wordpress head functions -->
  <?php wp_head(); ?>
  <!-- end of wordpress head -->

  


</head>

<body class="navbar-top">

	<!-- Main navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-header" style="background-color:#f68839;height:52px;">
			
			

			<ul class="nav navbar-nav visible-xs-block">
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-tree5"></i></a></li>
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
			<ul class="nav navbar-nav" style="float: inherit;font-weight:bold;">
			<li class="dropdown">
				 
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-building" style="color:#ffffff"></i> <?php
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
        ?> <span class="caret"></span></a>
              <ul class="dropdown-menu scrollable-menu" role="menu">
            <li><?php

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


        ?></li>
           
          </ul>
        </li>
		</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile" style="z-index:1025;">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

            
		
          </ul>
        </li>
				
			
          
  
					
					<div class="dropdown-menu dropdown-content">
						<div class="dropdown-content-heading">
							Git updates
							<ul class="icons-list">
								<li><a href="#"><i class="icon-sync"></i></a></li>
							</ul>
						</div>

						<ul class="media-list dropdown-content-body width-350">
							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
								</div>

								<div class="media-body">
									Drop the IE <a href="#">specific hacks</a> for temporal inputs
									<div class="media-annotation">4 minutes ago</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-warning text-warning btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-commit"></i></a>
								</div>
								
								<div class="media-body">
									Add full font overrides for popovers and tooltips
									<div class="media-annotation">36 minutes ago</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-info text-info btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-branch"></i></a>
								</div>
								
								<div class="media-body">
									<a href="#">Chris Arney</a> created a new <span class="text-semibold">Design</span> branch
									<div class="media-annotation">2 hours ago</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-success text-success btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-merge"></i></a>
								</div>
								
								<div class="media-body">
									<a href="#">Eugene Kopyov</a> merged <span class="text-semibold">Master</span> and <span class="text-semibold">Dev</span> branches
									<div class="media-annotation">Dec 18, 18:36</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
								</div>
								
								<div class="media-body">
									Have Carousel ignore keyboard events
									<div class="media-annotation">Dec 12, 05:46</div>
								</div>
							</li>
						</ul>

						<div class="dropdown-content-footer">
							<a href="#" data-popup="tooltip" title="All activity"><i class="icon-menu display-block"></i></a>
						</div>
					</div>
							</ul>

	

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown language-switch">
					
						
						<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-form" role="search">
        <div class="input-group">
              <input type="text" class="form-control input-lg search-autocomplete" name="s" placeholder="Search..." <?php if(isset($_GET['s'])) { echo 'value="'.$_GET['s'].'"';} ?>>
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fa fa-search fa-lg" style="color:#EBA124"></i></button>
            </div>
        </div>
					</form></li> 

				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user" style="color:#f68839"></i>
						<span><?php global $current_user; get_currentuserinfo(); echo ($current_user->user_login); ?></span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu">
            <li><a href="/account">Account Settings <span class="glyphicon glyphicon-cog pull-right"></span></a></li>
            <li class="divider"></li>
            <li><a href="/wp-admin">Admin Login <span class="glyphicon glyphicon-stats pull-right"></span></a></li>
            <li class="divider"></li>
           
        <li><a href="<?php echo wp_logout_url(); ?>">Sign Out <span class="glyphicon glyphicon-log-out pull-right"></span></a></li>
     </ul>
				</li>
        
			</ul>
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

				