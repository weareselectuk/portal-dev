<div class="sidebar sidebar-main">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main" style="box-shadow: none;">
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
									<span class="media-heading text-muted"><?php global $current_user; wp_get_current_user(); echo '' . $current_user->user_firstname . "\n";echo '' . $current_user->user_lastname . "\n";?></span>
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
								<li class="navigation-header"><i class="icon-menu" title="Main pages"></i></li>
								<li><a href="/index.php"><i class="icon-home4"></i></a></li>
								
								
			
									
								
							
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
	

   
