<!--

Modals for the client dashboard, under the users tab

Last updated: 04/09/2018

-->


<!-- User Status -->

<div class="modal fade" id="userstatus_<?php $post_id = get_the_ID();
   echo $post_id;?>" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">User Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <tbody>
                  <tr>
                    <th scope="row"><strong>User Status:</strong></th>
                    <td>
                    <?php $meta_key = 'user_status'; $id = get_the_id(); ?><a data-title="User Status" href="#" id="user-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active',text:'Active'},{value:'Not Active',text:'Not Active'},{value:'None',text:'None'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

<!--Employment Type -->
<div class="modal fade bd-example-modal-lg" id="employmenttype_<?php $post_id = get_the_ID();
   echo $post_id;?>"
  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Employment Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
        <div class="table-responsive">
              <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col"><strong>Day of the week</strong></th>
                      <th scope="col"><strong>Time Worked</strong></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row"><strong>Monday</strong></th>
                      <td align="left">
                        <?php $meta_key = 'day_mon'; $id = get_the_id(); ?>
                        <a data-title="Monday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                    </tr>
                    <tr>
                      <th scope="row"><strong>Tuesday</strong></th>
                      <td align="left">
                        <?php $meta_key = 'day_tues'; $id = get_the_id(); ?>
                        <a data-title="Tuesday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                    </tr>
                    <tr>
                      <th scope="row"><strong>Wednesday</strong></th>
                      <td align="left">
                        <?php $meta_key = 'day_wed'; $id = get_the_id(); ?>
                        <a data-title="Wednesday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                    </tr>
                    <tr>
                      <th scope="row"><strong>Thursday</strong></th>
                      <td align="left">
                        <?php $meta_key = 'day_thurs'; $id = get_the_id(); ?>
                        <a data-title="Thursday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                    </tr>
                    <tr>
                      <th scope="row"><strong>Friday</strong></th>
                      <td align="left">
                        <?php $meta_key = 'day_fri'; $id = get_the_id(); ?>
                        <a data-title="Friday" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>

                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

<!-- User Logins -->
<div class="modal fade" id="userlogins_<?php $post_id = get_the_ID();    echo $post_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <?php 
      $args = array(
  'post_type' => 'logins',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key'     => 'user',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
  )
);

$login_query = new WP_Query( $args );

if ($login_query->have_posts()) : ?>

        <h5 class="modal-title" id="exampleModalLongTitle"><div class="post_count"><?php echo $login_query->found_posts; ?></div> User Logins</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="panel panel-default">
          <div class="panel-body">
          
          <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>Login Type</th>
        <th>Username</th>
        <th>Password</th>
       
        
        
      </tr>
    </thead>
    <?php while ( $login_query->have_posts() ) : $login_query->the_post(); ?>
    <tbody>
          <tr>
      <td align="center">
        <?php $meta_key = 'login_type'; $id = get_the_id(); ?><a data-title="Login Type" href="#" id="asset-status" name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active Directory',text:'Active Directory'},{value:'Azure',text:'Azure'},{value:'Synology / Storage',text:'Synology / Storage'},{value:'Sonic Wall Net Extender',text:'Sonic Wall Net Extender'},{value:'Other',text:'Other'}]" data-pk="<?php echo $id;?>"   class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>	
                    <td align="center">
        <?php $meta_key = 'login_username'; $id = get_the_id();?>
                        <a data-title="Login Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
        </td>
      
        <td align="center">
        <?php $meta_key = 'login_password'; $id = get_the_id();?>
                        <a data-title="Login Password" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        <i class="glyphicon glyphicon-eye-open"></i>
        </td>
       
      </tr>
    </tbody>
    <?php endwhile;
    echo '</table></div>';
    
  else :

echo '<p>This user has no logins</p>';

endif;
$login_query->reset_postdata();
 ?>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>




<!--Email Config -->

<div class="modal fade bd-example-modal-lg" id="emailconfig_<?php $post_id = get_the_ID();    echo $post_id;?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Email Config</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
        <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'services',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key'     => 'user',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
  )
);

$inner_query = new WP_Query( $args );

if ($inner_query->have_posts()) : ?>

              <div class="table-responsive">
                <table class="table">
                  <tr>
                  <th width="equal-width"><strong>AddressEmail </strong></th>
                  <th width="equal-width"><strong>Password</strong></th>
                  <th width="equal-width"><strong>License Type</strong></th>



                  </tr>


                  <?php 

                  
                  while ( $inner_query->have_posts() ) : $inner_query->the_post(); ?>

                  <tr>

                  <td align="left">
                      <?php $meta_key = 'email_address'; $id = get_the_id();?>
                      <a data-title="Email Address" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                        <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>
                    <td align="left">
                      <?php $meta_key = 'password'; $id = get_the_id();?>
                        <a data-title="Email Password" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </td>
                    <td align="left">
                     <?php $meta_key = 'license_type'; $id = get_the_id();?>
                        <a data-title="Last Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                      </a>
                    </td>


                  </tr>
                  

                  <?php endwhile;
  
echo '</table></div>';

else :

  echo '<p>This user has no services</p>';
  
endif;



?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

