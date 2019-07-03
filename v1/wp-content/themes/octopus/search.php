<?php get_header('search'); ?>
<style>
	div.panel-footer-assets {
		background-color: #4CAF50;
		height:5px !important;


	}
	div.panel-footer-clients {
		background-color: #007bff;
		height:5px !important;
	}
	div.panel-footer-sites {
		background-color: #dc3545;
		height:5px !important;
	}
	div.panel-footer-users {
		background-color: #FF5722;
		height:5px !important;
		
	}
	div.panel-footer-services {
		background-color: #17a2b8;
		height:5px !important;
		
	}
	button.btn-info.active {           background-image: url(/wp-content/themes/octopus/library/assets/images/triangle-info.png);
    padding-bottom: 54px;
    background-color: transparent !important;
    background-repeat: no-repeat;
    background-size: 100% 90%;
    box-shadow: none;
    font-weight: bold;
    margin-bottom: -54px;
	}
	button.btn-primary.active{background-image: url(/wp-content/themes/octopus/library/assets/images/triangle-primary.png);
    padding-bottom: 54px;
    background-color: transparent !important;
    background-repeat: no-repeat;
    background-size: 100% 90%;
    box-shadow: none;
    font-weight: bold;
    margin-bottom: -54px;}
	
	button.btn-success.active{background-image: url(/wp-content/themes/octopus/library/assets/images/triangle-success.png);
    padding-bottom: 54px;
    background-color: transparent !important;
    background-repeat: no-repeat;
    background-size: 100% 90%;
    box-shadow: none;
    font-weight: bold;
    margin-bottom: -54px;}
	button.btn-danger.active{background-image: url(/wp-content/themes/octopus/library/assets/images/triangle-danger.png);
    padding-bottom: 54px;
    background-color: transparent !important;
    background-repeat: no-repeat;
    background-size: 100% 90%;
    box-shadow: none;
    font-weight: bold;
    margin-bottom: -54px;}
	button.btn-warning.active{background-image: url(/wp-content/themes/octopus/library/assets/images/triangle-warning.png);
    padding-bottom: 54px;
    background-color: transparent !important;
    background-repeat: no-repeat;
    background-size: 100% 90%;
    box-shadow: none;
    font-weight: bold;
    margin-bottom: -54px;}
	button.btn-default.active{background-image: url(/wp-content/themes/octopus/library/assets/images/triangle-default.png);
    padding-bottom: 54px;
    background-color: transparent !important;
    background-repeat: no-repeat;
    background-size: 100% 90%;
    box-shadow: none;
    font-weight: bold;
    margin-bottom: -54px;}
	</style>
<div class="container-fluid" style="margin-top:50px;">
	<div class="row">
		<div class="col-md-12">
		<div class="panel panel-search" style="background:#dddddd;max-height:718px;overflow-y:overlay !important;overflow-y:auto;">
		<div class="table-container" style="position: fixed;width: 100%;left: -37px;z-index: 100;padding-left: 308px;">
				   <div class="pull-left" style="width:100%; z-index: 1000;background-color: #dddddd;padding-top: 30px;padding-left: 20px;">
							<div class="btn-group" style="width:100%; padding: 15px; background:white;border-radius:3px;margin-bottom:20px;">
								<button type="button" class="btn btn-primary btn-filter" data-target="clients">Clients</button>
								<button type="button" class="btn btn-warning btn-filter" data-target="users">Users</button>
								<button type="button" class="btn btn-danger btn-filter" data-target="sites">Sites</button>
								<button type="button" class="btn btn-info btn-filter" data-target="services">Services</button>
								<button type="button" class="btn btn-success btn-filter" data-target="assets">Assets</button>
								<button type="button" class="btn btn-default btn-filter active" data-target="all">All</button>
							</div>
						</div>
						</div>
 <div class="table-container" style="margin-top:115px;padding-right:8px;">
							<table class="table table-filter">
								<tbody>
																		<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	
	<tr data-status="<?php $post_type = get_post_type( $post->ID ); echo $post_type;?>">
	<td style="padding:10px 20px;">
	<div class="panel panel-search" style="margin-bottom:0px;">
    <div class="panel-heading" style="padding-top:10px;padding-bottom:10px;">
         <h3 class="panel-title pull-left" style="text-transform:capitalize;font-size:15px;margin-top:9px;">
			<?php $post_type = get_post_type( $post->ID ); echo $post_type;   echo ': <a href="'.get_the_permalink().'">'.get_the_title().'</a>'; ?>
		 </h3>
<a href="<?php the_permalink();?>" class="btn btn-warning pull-right">View</a>
        <div class="clearfix"></div>
    </div>
  
	
	<div class="panel-footer-<?php $post_type = get_post_type( $post->ID ); echo $post_type;?>"></div>
</div></td>
</tr>


<?php endwhile; ?>
<?php else:
     echo '<h1 style="margin-left:50px;">No posts found, try something else </h1>'; endif; ?>
</tbody>
							</table>
						</div>
																		
															
		</div>
						
 
          
		</div>
	</div>
</div>

 <?php get_template_part('footer', 'simple');?>

     

<?php get_footer(); ?>