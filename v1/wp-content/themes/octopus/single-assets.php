<?php get_header(); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>



<?php

// much as with the filter page, you're probably going to want to show different values/fields depending on the asset, so I've split out some views

$device_class = get_post_meta( get_the_id(), 'device_class', true );

if($device_class == 'workstation-windows') {
get_template_part('dashboards/workstation');
}

elseif($device_class == 'workstation-mac') {
get_template_part('dashboards/mac');
}


elseif($device_class == 'laptop-windows') {
get_template_part('dashboards/laptop');
}


elseif($device_class == 'laptop-mac') {
get_template_part('dashboards/laptop-mac');
}


elseif($device_class == 'firewall') {
get_template_part('dashboards/firewall');
}


elseif($device_class == 'router') {
get_template_part('dashboards/router');
}


elseif($device_class == 'switch') {
get_template_part('dashboards/switch');
}


elseif($device_class == 'printer') {
get_template_part('dashboards/printer');
}


elseif($device_class == 'storage') {
get_template_part('dashboards/storage');
}

elseif($device_class == 'peripheral') {
get_template_part('dashboards/peripheral');
}

elseif($device_class == 'server') {
get_template_part('dashboards/server');
}

elseif($device_class == 'scanner-camera') {
get_template_part('dashboards/peripheral');
}

elseif($device_class == 'access-point') {
get_template_part('dashboards/access-point');
}

else { ?>

</div>


<?php } ?>

			</div>
			<!-- /main content -->

      

      <?php get_template_part('footer', 'simple');?>

    </div>
    <!-- /content area -->

    <?php endwhile; else : ?>

        <!-- Content area -->
        <div class="content">

          <!-- Error title -->
          
        
        
          <!-- /error wrapper -->

          <?php get_template_part('footer', 'simple');?>


        </div>
        <!-- /content area -->

          
    <?php endif; ?>


<?php get_footer(); ?>