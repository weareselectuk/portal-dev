<div class="sidebar sidebar-main">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<a href="#" class="media-left"><?php
$user = wp_get_current_user();
 
if ( $user ) :
    ?>
    <img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" />
<?php endif; ?></a>
								<div class="media-body">
									<span class="media-heading text-muted"><?php global $current_user; get_currentuserinfo();echo '' . $current_user->user_firstname . "\n";echo '' . $current_user->user_lastname . "\n";?></span>
									<div class="text-size-mini text-muted">
									<i class="fa fa-building" style="color:#50AE54"></i> 
									<?php $client_id = get_post_meta( get_the_id(), 'client', true );?>
                        <a href="<?php echo get_permalink($client_id);?>" class="text-default">
                          <?php echo get_the_title($client_id);?>
                        </a>
                       
									</div>
								</div>

								<div class="media-right media-middle">
									<ul class="icons-list">
										<li>
											<a href="/account"><i class="c"></i></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<!-- Main -->
								<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
								<li><a href="/index.php"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
								
								<li>
									<a href="#"><i class="icon-plus2"></i> <span>Actions </span></a>
									<ul>
									<li><a href="/add-client"><i class="fa fa-building" style="color:#50AE54"></i>Add Client</a></li>
            <li><a href="/add-site"><i class="fa fa-sitemap" style="color:#1DB2C8"></i>  Add Site</a></li>
            <li><a href="/add-user"><i class="fa fa-user-plus" style="color:#FC5830"></i> Add User</a></li>
            <li><a href="/add-asset"><i class="fa fa-desktop" style="color:#2C98F0"></i></i> Add Asset</a></li>
			<li><a href="/email"><i class="fa fa-wrench" style="color:#ffffff"></i> Add Email</a></li>
			<li><a href="/create-service-web-hosting"><i class="fa fa-wrench" style="color:#ffffff"></i> Add Web Hosting</a></li>
			<li><a href="/create-service-domains"><i class="fa fa-wrench" style="color:#ffffff"></i> Add Domains</a></li>
			<li><a href="/create-internal-service"><i class="fa fa-wrench" style="color:#ffffff"></i> Add Internal Service</a></li>
			<li><a href="/create-external-service"><i class="fa fa-wrench" style="color:#ffffff"></i> Add External Service</a></li>
			<li><a href="/create-service-sftp"><i class="fa fa-wrench" style="color:#ffffff"></i> Add SFTP</a></li>
			<li><a href="/create-site-notes/"><i class="fas fa-sticky-note " style="color:#ffffff"></i> Create Site Notes</a></li>
			
									</ul>
								</li>
			
									
								<li>
									<a href="#"><i class="icon-stack2"></i> <span>Views</span></a>
									<ul>
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
									</ul>
								</li>
								
								<li><a href="/changelog"><i class="icon-list-unordered"></i> <span>Changelog <span class="label bg-blue-400">1.5.15</span></span></a></li>
							
								<!-- /main -->

							</ul>
						</div>
					</div>
					<!-- /main navigation -->

  
 

				</div>
			</div>
			<!-- /main sidebar -->			

                                


<div class="panel panel-default" style="visibility:hidden;">
	
	<div class="panel-body">
      
    

</div>
	

   
