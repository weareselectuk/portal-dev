

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>



<?php

// much as with the filter page, you're probably going to want to show different values/fields depending on the asset, so I've split out some views

$device_class = get_post_meta( get_the_id(), 'device_class', true );

if($device_class == 'workstation-windows') {
get_template_part('/quickview/dashboards/workstation');
}

elseif($device_class == 'workstation-mac') {
get_template_part('/quickview/dashboards/mac');
}


elseif($device_class == 'laptop-windows') {
get_template_part('/quickview/dashboards/laptop');
}


elseif($device_class == 'laptop-mac') {
get_template_part('/quickview/dashboards/laptop-mac');
}


elseif($device_class == 'firewall') {
get_template_part('/quickview/dashboards/firewall');
}


elseif($device_class == 'router') {
get_template_part('/quickview/dashboards/router');
}


elseif($device_class == 'switch') {
get_template_part('/quickview/dashboards/switch');
}


elseif($device_class == 'printer') {
get_template_part('/quickview/dashboards/printer');
}


elseif($device_class == 'storage') {
get_template_part('/quickview/dashboards/storage');
}

elseif($device_class == 'peripheral') {
get_template_part('/quickview/dashboards/peripheral');
}

elseif($device_class == 'server') {
get_template_part('/quickview/dashboards/server');
}

elseif($device_class == 'scanner-camera') {
get_template_part('/quickview/dashboards/peripheral');
}

elseif($device_class == 'access-point') {
get_template_part('/quickview/dashboards/access-point');
}

else { ?>



<?php } ?>

			
    <!-- /content area -->

    <?php endwhile; else : ?>

       
        <!-- /content area -->

          
    <?php endif; ?>


