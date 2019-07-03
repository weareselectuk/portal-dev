<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>We Are Select | Portal <?php wp_title('', true, 'right'); ?></title>
    
  <!-- wordpress head functions -->
  <?php wp_head(); ?>
  <!-- end of wordpress head -->

  


</head>

<body class="navbar-top">

	<!-- Main navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-header">
			<a class="navbar-brand" href="/index.php"><img src="" alt=""></a>
			

			<ul class="nav navbar-nav visible-xs-block">
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-tree5"></i></a></li>
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile" style="z-index:1025;">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
<li><a href="/index.php"><i class="fa fa-tachometer" style="color:#EBA124"></i> Dashboard</a></li>
<li><a href="/support"><i class="fa fa-ambulance" style="color:#EBA124"></i> Helpdesk</a></li>
				<li class="dropdown">
				 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-arrow-right" style="color:#EBA124"></i> Actions <span class="caret"></span></a>
              <ul class="dropdown-menu">
            <li><a href="/add-client/"><i class="fa fa-building" style="color:#50AE54"></i> Add Client</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="/add-site/"><i class="fa fa-sitemap" style="color:#1DB2C8"></i> Add Site</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="/add-user/"><i class="fa fa-user-plus" style="color:#FC5830"></i> Add User</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="/add-asset/"><i class="fa fa-desktop" style="color:#2C98F0"></i> Add Asset</a></li>
            <li role="separator" class="divider"></li>
			<li class="dropdown-submenu">
        <a class="dropdown-toggle" tabindex="-1" href="#"><i class="fa fa-wrench" style="color:#333333"></i> Add Services</a>
        <ul class="dropdown-menu">
          <li><a tabindex="-1" href="/email/"><i class="fa fa-wrench" style="color:#333333"></i> Email</a></li>
		  <li><a tabindex="-1" href="/create-internal-service/"><i class="fa fa-wrench" style="color:#333333"></i> Internal Service</a></li>
          <li><a tabindex="-1" href="/create-external-service/"><i class="fa fa-wrench" style="color:#333333"></i> External Service</a></li>
		  <li><a tabindex="-1" href="/create-service-web-hosting/"><i class="fa fa-wrench" style="color:#333333"></i> Web Hosting</a></li>
		  <li><a tabindex="-1" href="/create-service-domains/"><i class="fa fa-wrench" style="color:#333333"></i> Domains</a></li>
		  <li><a tabindex="-1" href="/create-service-sftp"><i class="fa fa-wrench" style="color:#333333"></i> Crush FTP</a></li>
          
        </ul>
      </li>
            
		
          </ul>
        </li>
				
         
          <li class="dropdown">
				 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-eye" style="color:#EBA124"></i> Views <span class="caret"></span></a>
              <ul class="dropdown-menu">
            <li><a href="/filters/?type=assets&device=workstation-windows"><i class="fa fa-desktop" style="color:#2C98F0"></i>All Workstations PC</a></li>
            <li><a href="/filters/?type=assets&device=workstation-mac"><i class="fa fa-desktop" style="color:#2C98F0"></i>All Workstations MAC</a></li>
            <li><a href="/filters/?type=assets&device=laptop-windows"><i class="fa fa-laptop" style="color:#2C98F0"></i> All Laptops PC</a></li>
            <li><a href="/filters/?type=assets&device=laptop-mac"><i class="fa fa-laptop" style="color:#2C98F0"></i>All Laptops MAC</a></li>
			<li role="separator" class="divider"></li>
            <li><a href="/filters/?type=assets&device=server"><i class="fa fa-book" aria-hidden="true"></i>All Servers</a></li>
			<li><a href="/filters/?type=assets&device=firewall"><i class="fa fa-book" aria-hidden="true"></i>All Firewalls</a></li>
			<li><a href="/filters/?type=assets&device=router"><i class="fa fa-book" aria-hidden="true"></i>All Routers</a></li>
			<li><a href="/filters/?type=assets&device=switch"><i class="fa fa-book" aria-hidden="true"></i>All Switches</a></li>
			<li role="separator" class="divider"></li>
			<li><a href="/filters/?type=assets&device=printer"><i class="fa fa-print" style="color:#2C98F0"></i>All Printers</a></li>
			<li><a href="/filters/?type=assets&device=storage"><i class="fa fa-archive" style="color:#2C98F0"></i>All Storage</a></li>
			<li><a href="/filters/?type=assets&device=server-esxi|scanner-camera"><i class="fa fa-camera" style="color:#2C98F0"></i>All Peripherals</a></li>
   <li role="separator" class="divider"></li>
   <li><a href="/filters/?type=users"><i class="fa fa-users" style="color:#EBA124"></i>All Users</a></li>
          </ul>
        </li>
					
          <li class="dropdown">
				 
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-building" style="color:#EBA124"></i> <?php
			if ( 'clients' == get_post_type() ) {
		   echo the_title();
		   }
		   if (array( 'users', 'sites', 'assets' ) == get_post_type() ) {
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
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
					</form></li>
					
<li class="dropdown"> 
  <a id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html">
    <i class="glyphicon glyphicon-bell"></i>
  </a>
  
  <ul class="dropdown-menu notifications" role="menu" aria-labelledby="dLabel">
    
    <div class="notification-heading"><h4 class="menu-title">Notifications</h4>
    </div> 
   <div class="notifications-wrapper"> 
    
   
   <?php global $current_user;
      get_currentuserinfo(); ?>
	 <?php $args = array(
'post_type' => 'tasks',
'posts_per_page' => 999,
'meta_query' => array( array(
        'key' => 'engineer',
        'value' => $current_user->user_login ,
),
array(
		'key' => 'status',
        'value' => 'open',
      ),
    ),
    ); 
        $the_query = new WP_Query( $args );

if ($the_query->have_posts()) : {  ?>
	<div class="notification_count"> <?php
	$total = $query->found_posts; 'Open Tasks' ?> </div> <?php
 while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
 

     <a class="notification" href="task-list"> 
       <div class="notification-item">
       <img src="http://www.leapcms.com/images/100pixels1.gif" style="width:50px;float:left;">
        <div class="item-title" style="text-align: center;font-size: 17px;padding: 0px;color: black;">Task: </div>
        <div class="item-info" style="text-align:center;"><span class="title">
    <?php $meta_key = 'task_title'; $id = get_the_id();?>
          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = ''; ?>
</span></div><hr>
      </div>  
    </a>
		<?php endwhile ?>
<?php } else : echo 'notasks'; endif; 

wp_reset_query();

?>
   </div> 
  </ul>
  </li>  

				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user" style="color:#EBA124"></i>
						<span><?php global $current_user; get_currentuserinfo(); echo ($current_user->user_login); ?></span>
						<i class="caret"></i>
					</a>

					<ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Iasmani Pinazo <span class="glyphicon glyphicon-user pull-right"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Account Settings <span class="glyphicon glyphicon-cog pull-right"></span></a></li>
            <li class="divider"></li>
            <li><a href="#">User stats <span class="glyphicon glyphicon-stats pull-right"></span></a></li>
            <li class="divider"></li>
            <li><a href="#">Messages <span class="badge pull-right"> 42 </span></a></li>
            <li class="divider"></li>
            <li><a href="#">Favourites Snippets <span class="glyphicon glyphicon-heart pull-right"></span></a></li>
            <li class="divider"></li>
            <li><a href="#">Sign Out <span class="glyphicon glyphicon-log-out pull-right"></span></a></li>
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

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							 
						</div>

						<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="#" class="btn btn-link btn-float has-text"><i></i></a>
								<a href="#" class="btn btn-link btn-float has-text"><i></i> </a>
								<a href="#" class="btn btn-link btn-float has-text"><i></i> </a>
							</div>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.php"><i class="icon-home2 position-left"></i> <?php
    if(function_exists('bcn_display'))
    {
            bcn_display();
    }?></a></li>
						
						</ul>
						
					</div>
				</div>
				<!-- /page header -->