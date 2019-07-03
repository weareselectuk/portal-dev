
<?php

$users1 = array(
    'post_type' => 'users',
'posts_per_page' => 999,
'orderby' => 'firstname',
'order' => 'ASC',
    'meta_query' => array(
        array(
            'key'     => 'client',
            'value'   => get_the_id(),
    'compare' => '=',
        ),
    )
);

$thee_query = new WP_Query( $users1 );

if ($thee_query->have_posts()) : ?>

            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th><p class="text-danger"><i class="fa fa-user-plus" title="Number of users"></i> <?php echo $thee_query->found_posts; ?> Users</p></th>
                  <th><strong>Title</strong></th>
                  <th><strong>First Name</strong></th>
                  <th><strong>Last Name</strong></th>
                  <th><strong>DDI Telephone</strong></th>
                  <th><strong>Mobile</strong></th>
                  <th><strong>Email</strong></th>
                
                  
                  <th></th>

                </tr>


                <?php while ( $thee_query->have_posts() ) : $thee_query->the_post(); ?>

                <tr>
                <td align="center">    <a href="<?php the_permalink();?>" target="_blank"><span class="fas fa-eye fa-lg" title="Fullview"></span></a></td>
                <td align="center">
                    <?php $meta_key = 'title'; $id = get_the_id();?>
                    <a data-title="Title" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                  <td>
                    <?php $meta_key = 'firstname'; $id = get_the_id();?>
                    <a data-title="First Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                  <td align="center">
                    <?php $meta_key = 'lastname'; $id = get_the_id();?>
                    <a data-title="Last Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                  <td align="center">
                    <?php $meta_key = 'ddi_telephone'; $id = get_the_id();?>
                    <a data-title="DDI Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                  <td align="center">
                    <?php $meta_key = 'mobile'; $id = get_the_id();?>
                    <a data-title="Mobile" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                   <td align="center">
                    <?php $meta_key = 'email_address'; $id = get_the_id();?>
                    <a data-title="Email" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                    </a>
                  </td>
                  <!--Features-->
                  <td align="center"><a href="#userstatus_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#userstatus_<?php $post_id = get_the_ID(); echo $post_id;?>"> <span class="fa fa-check-circle fa-lg <?php if( empty( get_post_meta( $post_id, 'user_status', true ) ) ) : echo 'false'; endif; ?>" style="color:#50AE54" title="User Status"></span></a>
                     <a href="#employmenttype_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#employmenttype_<?php $post_id = get_the_ID(); echo $post_id;?>"><span class="fas fa-user-tie fa-lg <?php if( empty( get_post_meta( $post_id, 'day_mon', 'day_tues', 'day_wed', 'day_thurs', 'day_fri', true ) ) ) : echo 'false'; endif; ?>" title="Employment Type" ></span></a>
                     <a href="#userlogins_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#userlogins_<?php $post_id = get_the_ID(); echo $post_id;?>"><span class="fas fa-sign-in-alt fa-lg <?php if( empty( get_post_meta( $post_id, 'login_type', 'login_username', 'login_password', true ) ) ) : echo 'false'; endif; ?>" title="User Logins"></span></a>
                     <a href="#emailconfig_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#emailconfig_<?php $post_id = get_the_ID(); echo $post_id;?>"><span class="fas fa-envelope fa-lg <?php if( empty( get_post_meta( $post_id, 'email_address', 'password', 'license_type', true ) ) ) : echo 'false'; endif; ?>" title="Email Configuration"></span></a>
                     
                     
                    </td>
                     <td class="modalsloader"><?php
                     include get_template_directory() . '/users-modal.php'; ?></td> 
                </tr>


                <?php endwhile;

echo '</table></div>';

else :

echo '<p>This Client Has No Users</p>';

endif;


wp_reset_postdata();?>