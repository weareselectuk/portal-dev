
<tr>
	<td><a href="<?php the_permalink();?>"><?php the_title();?></a></h6></td>
	<td><?php echo get_post_meta( get_the_id(), 'asset_id', true );?></td>
    <td><?php echo get_post_meta( get_the_id(), 'device_class', true );?></td>
    <td><?php echo get_post_meta( get_the_id(), 'netbios_name', true );?></td>
    <td><?php echo get_post_meta( get_the_id(), 'asset_status', true );?></td>
	<td><a href="<?php the_permalink();?>" class="btn btn-warning">View</a>
	</td>
</tr>