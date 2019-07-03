<?php /*Template Name: add_forms*/ get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

   
    
    <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
					
					</h3>
				</div>
				<div class="panel-body">
				
				</div>
				
			</div>
		</div>
	</div>
</div>

<?php get_template_part('footer', 'simple');?>

     

<?php get_footer(); ?>