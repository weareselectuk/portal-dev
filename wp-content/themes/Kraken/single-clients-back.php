<?php /*Template Name: helpdesk-landing*/ get_header('test'); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
    
  
      <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading" style="z-index:998;">
         <div class="affectedDiv">
         <?php /* Primary navigation */
wp_nav_menu( array(
  'menu' => 'Client_Menu',  
  'container' => false,
  'menu_class' => 'nav nav-tabs',
  'role' => 'tablist',
  'id' => 'myTab',
  //Process nav menu using our custom nav walker
  'walker' => new rc_scm_walker,))
?>
         
     
           
              <!--  <li><a href="#tab10faq" role="tab" data-toggle="tab"><i class="fa fa-question" style="color:#1DB2C8"></i> FAQ</a></li> -->
           <!-- Commented out for now <li><a href="#tab10migrations" role="tab" data-toggle="tab"><i class="fa fa-rocket" style="color:#2C98F0"></i> Migrations</a></li> -->
         
         </div>
        </div>
        
        <div class="panel-body" style="background-color: #EEEDED !important;">
          <div class="tab-content">
            <div class="tab-pane active" id="tab1overview">
              <div class="client-overview-container">
                <div class="client-overview-row-1" style="float:left;width:100%;">
                <div class="box-1-title-container" style="float: left;margin-right: 40px;">
                  <div class="box-title" style="color:#999;">
                  <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">CLIENT DETAILS</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
                <div class="box-1-container" >
              <div class="table-responsive">
                <table class="table">
                 <tbody>
                    <tr>
                      <th scope="row"><strong style="text-transform: none; color: #99999F;  font-size: 15px;">Client:</strong></th>
                      <td>
                      <?php echo get_the_title( $post_id ); ?>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row"><strong style="text-transform: none; color: #99999F;  font-size: 15px;">Main Tel:</strong></th>
                      <td>
                        <?php $meta_key = 'telephone'; $id = get_the_id(); ?>
                        <a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row"><strong style="text-transform: none; color: #99999F;  font-size: 15px;">Email:</strong></th>
                      <td>
                        <?php $meta_key = 'email'; $id = get_the_id(); ?>
                        <a data-title="Email" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row"><strong style="text-transform: none; color: #99999F;  font-size: 15px;">Website:</strong></th>
                      <td>
                        <?php $meta_key = 'client_website'; $id = get_the_id(); ?>
                        <a data-title="Website" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              </div>
              </div>
              <div class="box-2-title-container" style="float: left;margin-right: 40px;">
              <div class="box-title" style="color:#999">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">TICKET OVERVIEW</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
              <div class="box-2-container" >
              <div class="table-responsive">
                <table class="table">
                 <tbody>
                 <tr>
                      <th scope="row"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x" style="color: #8a9b9c;">
    </i><i class="fas fa-users fa-stack-1x" style="color: #ffffff;"></i></span></th>
                      <td>
                      <span style="text-transform: none; color: #8a9b9c"> Unassigned</span>
                        </a>
                      </td>
                      <td>
                      <?php $dlcount = $wpdb->get_var( "SELECT COUNT({$wpdb->prefix}wsdesk_ticketsmeta.meta_value) FROM {$wpdb->prefix}wsdesk_ticketsmeta WHERE meta_value = 'label_LV53'" ); 
     echo "{$dlcount}";?> new tickets
                        </a>
                      </td>
                    </tr> 
                    <tr>
                      <th scope="row"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x" style="color: #e2721f;">
    </i><i class="fas fa-spinner fa-stack-1x" style="color: #ffffff;"></i></span></th>
                      <td>
                      <span style="text-transform: none; color: #e2721f"> In Progress</span>
                        </a>
                      </td>
                      <td>
                      <?php $ipcount = $wpdb->get_var( "SELECT COUNT({$wpdb->prefix}wsdesk_ticketsmeta.meta_value) FROM {$wpdb->prefix}wsdesk_ticketsmeta WHERE meta_value = 'label_LL01'" ); 
     echo "{$ipcount}";?> tickets
                        </a>
                      </td>
                    </tr> 
                    <tr>
                    <th scope="row"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x" style="color: #e34235;">
    </i><i class="fas fa-reply-all fa-stack-1x" style="color: #ffffff;"></i></span></th> 
    
                      <td>
                      <span style="text-transform: none; color: #e34235"> Awaiting Reply</span>
                        </a>
                      </td>
                      <td>
                      <?php $arcount = $wpdb->get_var( "SELECT COUNT({$wpdb->prefix}wsdesk_ticketsmeta.meta_value) FROM {$wpdb->prefix}wsdesk_ticketsmeta WHERE meta_value = 'label_LL03'" ); 
     echo "{$arcount}";?> tickets
                        </a>
                      </td>
                    </tr> 
                    <tr>
                    <th scope="row"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x" style="color: #44bd32;">
    </i><i class="fas fa-check-double fa-stack-1x" style="color: #ffffff;"></i></span></th>
                      <td>
                      <span style="text-transform: none; color: #44bd32"> Completed</span>
                        </a>
                      </td>
                      <td>
                      <?php $compcount = $wpdb->get_var( "SELECT COUNT({$wpdb->prefix}wsdesk_ticketsmeta.meta_value) FROM {$wpdb->prefix}wsdesk_ticketsmeta WHERE meta_value = 'label_LL02'" ); 
     echo "{$compcount}";?> tickets
                        </a>
                      </td>
                    </tr>
                                        
                  </tbody>
                </table>
              </div>
              </div>
              </div>
              
              <div class="box-3-title-container" style="float: left;margin-right: 40px;">
              <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">CONVERSATIONS OVERVIEW</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
              <div class="box-3-container" >
              <?php
$current_client = $post->ID;
$querystr = "
SELECT {$wpdb->prefix}wsdesk_tickets.*
FROM {$wpdb->prefix}wsdesk_tickets, {$wpdb->prefix}wsdesk_ticketsmeta
WHERE {$wpdb->prefix}wsdesk_ticketsmeta.meta_value = '$current_client'
AND {$wpdb->prefix}wsdesk_ticketsmeta.ticket_id = {$wpdb->prefix}wsdesk_tickets.ticket_parent
AND {$wpdb->prefix}wsdesk_tickets.ticket_parent = {$wpdb->prefix}wsdesk_ticketsmeta.ticket_id
ORDER BY {$wpdb->prefix}wsdesk_tickets.ticket_updated DESC
";
$pageposts = $wpdb->get_results($querystr, OBJECT);
if ($pageposts) : ?>

              <div class="table-responsive">
                
                 <?php foreach ($pageposts as $key => $value) {
                   $current_user = get_userdata($value->ticket_author);
					 ?><div style="background-color: #FFF;color:#99999F; height: 30px; border-radius: 3px; padding-top: 4px; padding-left: 26px; width:300px;margin-top:10px"><a href="#helpdesk" style="color:#99999F;" data-toggle="modal" data-target="#ticket_<?php echo $value->ticket_id; 
					 ?>"> <?php echo $value->ticket_title; 
					 ?></a>by <?php get_userdata( $value->ticket_author ); echo $current_user->display_name;
					 ?></div>
					 <?php }; ?>
				 </div>
             
              
              <?php else : echo 'none'; ?> 
              </div> 
                 </div>       
              <?php endif; wp_reset_postdata();?>     
            
          
              </div>
                 </div>
<div class="client-overview-row-2" style="float:left;width:100%;">
              <div class="box-4-title-container" style="float: left;margin-right: 40px;">
              <div class="box-title" style="color:#999">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">IMPORTANT INFORMATION</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
              <div class="box-4-container" >
              <div class="table-responsive">
                <table class="table">
                 <tbody>
                    <tr>
                      <th scope="row"><strong style="text-transform: uppercase; color: ##7f8fa6;  font-size: 17px;"><i class="fas fa-exclamation-triangle" style="color:#932082"></i></strong></th>
                      <td>
                      <span style="text-transform: none; color: #7f8fa6"> Some important information to go here</span>
                        </a>
                      </td>
                      <td>
                      <strong style="text-transform: none; color: #7f8fa6">25/03/2019</strong>
                        </a>
                      </td>
                    </tr>          
                    <tr>
                      <th scope="row"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;"><i class="fas fa-exclamation-triangle" style="color:#932082"></i></strong></th>
                      <td>
                      <span style="text-transform: none; color: #7f8fa6"> Some important information to go here</span>
                        </a>
                      </td>
                      <td>
                      <strong style="text-transform: none; color: #7f8fa6">25/03/2019</strong>
                        </a>
                      </td>
                    </tr>        
                    <tr>
                      <th scope="row"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;"><i class="fas fa-exclamation-triangle" style="color:#932082"></i></strong></th>
                      <td>
                      <span style="text-transform: none; color: #7f8fa6"> Some important information to go here</span>
                        </a>
                      </td>
                      <td>
                      <strong style="text-transform: none; color: #7f8fa6">25/03/2019</strong>
                        </a>
                      </td>
                    </tr>        
                                    
                  </tbody>
                 
                </table>
              </div>
              </div>
              </div>
              <div class="box-5-title-container" style="float: left;margin-right: 40px;">
              <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">ACCOUNT REVIEW</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
              <div class="box-5-container" >
              <div class="table-responsive">
                <table class="table">
                 <tbody>
                    <tr>
                      <th scope="row"><span style="text-transform: none; color: #932082;  font-size: 15px;">Next account review date:</span> <strong style="text-transform: none; color: #932082;  font-size: 15px;">25th March 2019</strong></th>
                      <td>                      
                      </td>
                    </tr>
                    <tr>
                      
                    <td>
                      <span style="text-transform: none; color: #7f8fa6"> Some item to be reviewed</span>
                        </a>
                      </td>
                      <td>
       
                        </a>
                      </td>
                    </tr>   
                    <tr>
                      
                    <td>
                      <span style="text-transform: none; color: #7f8fa6"> Some item to be reviewed</span>
                        </a>
                      </td>
                      <td>
       
                        </a>
                      </td>
                    </tr>   
                    <tr>
                      
                    <td>
                      <span style="text-transform: none; color: #7f8fa6"> Some item to be reviewed</span>
                        </a>
                      </td>
                      <td>
       
                        </a>
                      </td>
                    </tr>      
                    </tr>                   
                  </tbody>
                </table>
              </div>
              </div>
              </div>
              <div class="box-6-title-container" style="float: left;margin-right: 40px;">
              <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">DIARY LOG OVERVIEW</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
              <div class="box-6-container" >
              <div class="table-responsive">
                <table class="table">
                 <tbody>
                 <tr>
                      <th scope="row"><span style="text-transform: none; color: #7f8fa6"> Some diary event log</span></th>
                      <td>
                      <img src="<?php echo get_template_directory_uri() . '/library/assets/img/default-avatar.png'; ?>" alt="Avatar" class="avatar">
                        </a>
                      </td>
                      <td>
                      <div class="hd_ticket_requester" style="float:right;margin-right:20px;">By: Mike Smith</div>
                     
                      </td>
                    </tr> 
                    <tr>
                      <th scope="row"><span style="text-transform: none; color: #7f8fa6"> Some diary event log</span></th>
                      <td>
                      <img src="<?php echo get_template_directory_uri() . '/library/assets/img/default-avatar.png'; ?>" alt="Avatar" class="avatar"> 
                      </td>
                     <td>
                      <div class="hd_ticket_requester" style="float:right;margin-right:20px;">By: Mike Smith</div>
                      </td>
                    </tr> 
                    <tr>
                    <th scope="row"><span style="text-transform: none; color: #7f8fa6" float: right;> Some diary event log</span></th>
                      <td>
                      <img src="<?php echo get_template_directory_uri() . '/library/assets/img/default-avatar.png'; ?>" alt="Avatar" class="avatar">
                        </a>
                      </td>
                      <td>
                      <div class="hd_ticket_requester" style="float:right;margin-right:20px;">By: Mike Smith</div>
                      </td>
                    </tr> 
                    
                  </tbody>
                </table>
              </div>
              </div>
              </div>
            </div>
            </div> 
            </div>
            </div>           
            <div class="tab-pane fade" id="tab2sites">
              <?php

// get all associated services associated with this client

 $args = array(
        'post_type' => 'sites',
        'posts_per_page' => 999,
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => array(
          array(
            'key'     => 'client',
            'value'   => get_the_id(),
            'compare' => '=',
    ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) :  ?>
<div class="filter-container">
  <div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">SITE STATUS</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
    <div class="filter-box">
      <div class="filter-count"><?php echo $the_query->found_posts; ?></div>
      <button class="filter-title btn-filter sites" type="button" data-target="all">TOTAL</button>
</div>
<div class="filter-box">
      <div class="filter-count-green"><?php $args = array(   'post_type' => 'sites',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),    array(       'key'     => 'site_status',       'value'   => 'Active',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-green btn-filter sites" type="button" data-target="Active">ACTIVE</button>
      </div>
      <div class="filter-box">
      <div class="filter-count-red"><?php $args = array(   'post_type' => 'sites',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),    array(       'key'     => 'site_status',       'value'   => 'Not Active',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-red btn-filter sites" type="button" data-target="Not Active">NOT ACTIVE</button>
      
</div>
</div>
<button class="box-title btn-filter sites" type="button" data-target="all" style="color:#999;float:right;border: none; background-color: #eeeded;">
             <i style="color:#932082; margin-left:10px;" class="fas fa-power-off"></i><span style="font-weight:bold;font-size:14px;"> RESET</span>FILTERS
                  
</button>
</div>
<div class="table-responsive">
                    <table class="table table-filter">
                    <tr>
                      
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Site Name</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Address Line 1</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Address Line 2</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Address Line 3</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Town</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">County</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Postcode</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Email</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Telephone</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Functions</strong></th>
                      <th width="equal-width"></th>
                      
                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <?php $meta_key = 'site_status'; $id = get_the_id(); ?>
                    <tr class="filterable sites" data-status="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>">
                     
                    <!--Quickview-->
                     
                     <!--Site Name-->
                     <td align="left">    <?php echo get_the_title( $post_id ); ?>  </td>
                    <!--Address line 1 -->
                    <td align="left"><?php $meta_key = 'address_line_1'; $id = get_the_id();?>
                        <a data-title="Address Line 1" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                        <!--Address line 2 -->
                    <td align="left"><?php $meta_key = 'address_line_2'; $id = get_the_id();?>
                        <a data-title="Address Line 2" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                        <!--Address line 3 -->
                    <td align="left"><?php $meta_key = 'address_line_3'; $id = get_the_id();?>
                        <a data-title="Address Line 3" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Town-->
                    <td align="left"><?php $meta_key = 'town'; $id = get_the_id();?>
                        <a data-title="Town" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--County-->
                    <td align="left"><?php $meta_key = 'county'; $id = get_the_id();?>
                        <a data-title="County" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                     <!--Postcode-->
                    <td align="left"><?php $meta_key = 'post_code'; $id = get_the_id();?>
                        <a data-title="Postcode" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Email Address-->
                    <td align="left"><?php $meta_key = 'email'; $id = get_the_id();?>
                        <a data-title="Email" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Telephone-->
                    <td align="left"><?php $meta_key = 'telephone'; $id = get_the_id();?>
                        <a data-title="Telephone" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Features-->
                     <td align="left"><a href="#sitestatus_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#sitestatus_<?php $post_id = get_the_ID(); echo $post_id;?>"> <span class="fa fa-check-circle fa-lg <?php if( empty( get_post_meta( $post_id, 'site_status', true ) ) ) : echo 'false'; endif; ?>" style="color:#50AE54" title="Site Status"></span></a>
                     <a data-toggle="modal" data-target="#sitemap"> <span class="fas fa-map-marker-alt fa-lg false" title="Site Map" ></span></a>
                     <a href="#config_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#config_<?php $post_id = get_the_ID(); echo $post_id;?>"><span class="fas fa-toolbox fa-lg <?php  $config_email = get_post_meta( $post_id, 'email_address', 'password', false ); if( empty( $config_email ) ) : echo 'false'; endif; ?>" title="Site Config Details"></span></a>
                     <a href="#sitenotes_<?php $post_id = get_the_ID(); echo $post_id;?>" data-toggle="modal" data-target="#sitenotes_<?php $post_id = get_the_ID(); echo $post_id;?>"> <span class="fas fa-sticky-note fa-lg <?php if( empty( get_post_meta( $post_id, 'site_notes', 'date_completed', false ) ) ) : echo 'false'; endif; ?>" title="Site Notes"></span></a>
                     
                    </td>
                     <td class="modalsloader"><?php
                     include get_template_directory() . '/sites-modal.php'; ?></td> 
                     </tr>
 
   


                    <?php endwhile; 
  
  echo '</table></div>
  <!-- Modal -->
  <div class="modal fade" id="sitemap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Sitemap</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 modal_body_content">
              <p>Some contents...</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 modal_body_map">
              <div class="location-map" id="location-map">
                <div style="width: 600px; height: 400px;" id="map_canvas"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 modal_body_end">
              <p>Else...</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>';
  /*
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbJbWvTXTgScvrpLlCDRg3iYnBZb3-9Kw&callback=initMap">
  </script>';*/
  
else :

  echo '<p>This Client has no sites</p>';
  
endif;

wp_reset_postdata();?>
                    <!-- Table -->
                

            </div>          
            <?php 
//start the buffer
ob_start();

get_template_part('dashboards/users');

//store out output buffer
$string = ob_get_contents();

//clear the buffer and close it
ob_end_clean(); ?>

<div class="tab-pane fade" id="tab3users">
<?php

echo do_shortcode( $string );?>
</div>
<div class="tab-pane fade" id="tab4assets">
             
              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'assets',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key'     => 'client',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>



<div class="filter-container">
  <div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">ASSET STATUS</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
    <div class="filter-box">
      <div class="filter-count"><?php echo $the_query->found_posts; ?></div>
      <button class="filter-title btn-filter assets" type="button" data-target="all">TOTAL</button>
</div>
<?php $args = array(
  'post_type' => 'assets',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),
    array(
      'key'     => 'asset_status',
      'value'   => 'Active',
      'compare' => '=',
    ),
  )
);

$inner_query = new WP_Query( $args ); ?>


      <div class="filter-box">
<div class="filter-count-green"><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?> 
<?php else :  echo '0' ?>
<?php endif; ?></div>
      <button class="filter-title-green btn-filter assets" type="button" data-target="Active">ACTIVE</button>
</div>
<?php $args = array(
  'post_type' => 'assets',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),
    array(
      'key'     => 'asset_status',
      'value'   => 'Not Active',
      'compare' => '=',
    ),
  )
);

$inner_query = new WP_Query( $args ); ?>
      <div class="filter-box">
      <div class="filter-count-red"><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?> 
<?php else :  echo '0' ?>
<?php endif; ?></div>
      <button class="filter-title-red btn-filter assets" type="button" data-target="Not Active">NOT ACTIVE</button>
</div>
</div>
<div class="filter-column" style="margin-left:83px;">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">GURU LICENSE</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
                  <?php $args = array(
  'post_type' => 'assets',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),
    array(
      'key'     => 'pro_license',
      'value'   => 'None',
      'compare' => '=',
    ),
  )
);

$inner_query = new WP_Query( $args ); ?>
<div class="filter-box">
      <div class="filter-count-blue"><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?> 
<?php else :  echo '0' ?>
<?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="None">NONE</button>
</div>
<?php $args = array(
  'post_type' => 'assets',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),
    array(
      'key'     => 'pro_license',
      'value'   => 'Essentials',
      'compare' => '=',
    ),
  )
);

$inner_query = new WP_Query( $args ); ?>
      <div class="filter-box">
      <div class="filter-count-blue"><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?> 
<?php else :  echo '0' ?>
<?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="Essentials">ESSENTIALS</button>
</div>
<?php $args = array(
  'post_type' => 'assets',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),
    array(
      'key'     => 'pro_license',
      'value'   => 'Pro',
      'compare' => '=',
    ),
  )
);

$inner_query = new WP_Query( $args ); ?>
      <div class="filter-box">
      <div class="filter-count-blue"><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?> 
<?php else :  echo '0' ?>
<?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="Pro">PRO</button>
</div>
</div>
<div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">DEVICE CLASS</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
<div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(
  'post_type' => 'assets',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),
    array(
      'key'     => 'device_class',
      'value'   => 'windows-workstation',
      'compare' => '=',
    ),
  )
);
$inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?> 
<?php else :  echo '0' ?>
<?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="windows-workstation">WORKSTATION PC</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'assets',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),     array(       'key'     => 'device_class',       'value'   => 'workstation-mac',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="workstation-mac">WORKSTATION MAC</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'assets',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),    array(       'key'     => 'device_class',       'value'   => 'laptop-mac',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="laptop-mac">LAPTOP MAC</button>
</div>
</div>
<div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;"></span><span style="font-weight:bold;font-size:14px;"></span>
                  </div>
<div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'assets',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),    array(       'key'     => 'device_class',       'value'   => 'laptop-windows',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="laptop-windows">LAPTOP PC</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'assets',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),    array(       'key'     => 'device_class',       'value'   => 'server',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="server">SERVER</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'assets',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),    array(       'key'     => 'device_class',       'value'   => 'storage',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="storage">STORAGE</button>
</div>
</div>
<div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;"></span><span style="font-weight:bold;font-size:14px;"></span>
                  </div>
<div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'assets',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),    array(       'key'     => 'device_class',       'value'   => 'switch',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="switch">SWITCH</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'assets',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),    array(       'key'     => 'device_class',       'value'   => 'router',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="router">ROUTER</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'assets',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),    array(       'key'     => 'device_class',       'value'   => 'firewall',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="firewall">FIREWALL</button>
</div>
</div>
<div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;"></span><span style="font-weight:bold;font-size:14px;"></span>
                  </div>
<div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'assets',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),    array(       'key'     => 'device_class',       'value'   => 'peripheral',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="peripheral">PERIPHERAL</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'assets',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),    array(       'key'     => 'device_class',       'value'   => 'printer',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="printer">PRINTER</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'assets',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
		),    array(       'key'     => 'device_class',       'value'   => 'access-point',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter assets" data-target="access-point">ACCESS POINT</button>
</div>
</div>
</div>
<button class="box-title btn-filter assets" type="button" data-target="all" style="color:#999;float:right;border: none; background-color: #eeeded;">
             <i style="color:#932082; margin-left:10px;" class="fas fa-power-off"></i><span style="font-weight:bold;font-size:14px;"> RESET</span>FILTERS
</button>
                <div class="table-responsive max-height" style="max-height: 475px;">
                    <table class="table table-filter">
                    <tr>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Asset ID</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Netbios Name</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Device Class</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">GURU License</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Lan IP</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">WAN IP</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Site Location</strong></th>
                      <th width="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Functions</strong></th>
                      <th width="equal-width"></th>
                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <?php $meta_key = 'asset_status'; $id = get_the_id(); ?>
                    <tr class="filterable assets" data-status="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>" 
                    <?php $meta_key = 'pro_license'; $id = get_the_id(); ?>data-guru-license="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>" 
                    <?php $meta_key = 'device_class'; $id = get_the_id(); ?>data-device-class="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>">
                     
                    <!--Quickview-->
                     
                    <!--Asset ID -->
                    <td align="left"><?php $meta_key = 'asset_id'; $id = get_the_id();?>
                        <a data-title="Asset ID" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Netbios Name-->
                    <td align="left"><?php $meta_key = 'netbios_name'; $id = get_the_id();?>
                        <a data-title="Netbios Name" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Device Class-->
                    <td align="left"><?php $meta_key = 'device_class'; $id = get_the_id(); ?><a data-title="Device Class" href="#" id="vpn" name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'windows-workstation',text:'Workstation PC'},{value:'windows-laptop',text:'Laptop PC'},{value:'laptop-mac',text:'Laptop Mac'},{value:'workstation-mac',text:'Workstation Mac'},{value:'server',text:'Server'},{value:'router',text:'Router'},{value:'printer',text:'Printer'},{value:'switch',text:'Switch'},{value:'storage',text:'Storage'},{value:'firewall',text:'Firewall'}, {value:'peripheral',text:'Peripheral'}, {value:'access-point',text:'Access Point'}]" data-pk="<?php echo $id;?>"   class="text-field"><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a></td>
                    <!--Guru License-->
                     <td align="left">
                     <?php $meta_key = 'pro_license'; $id = get_the_id(); ?><a data-title="Guru License" href="#" id="site-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'None',text:'None'},{value:'Pro',text:'Pro'},{value:'Essentials',text:'Essentials'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                
                  </td>
                    <!--Lan IP-->
                    <td align="left"><?php $meta_key = 'lan_ip'; $id = get_the_id();?>
                        <a data-title="Lan IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--WAN IP-->
                    <td align="left"><?php $meta_key = 'wan_ip'; $id = get_the_id();?>
                        <a data-title="Wan IP" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a></td>
                    <!--Site Location-->
                    <td align="left"><?php $meta_key = 'site'; $id = get_the_id();?>
                       
                          <?php echo get_the_title(get_post_meta($id, $meta_key, true ))?>
                        </td>
                    <!--Features-->
                     <td align="left"><a href="#assetstatus_<?php echo $id;?>" data-toggle="modal" data-target="#assetstatus_<?php echo $id;?>"> <span class="fa fa-check-circle fa-lg <?php if( empty( get_post_meta( $id, 'asset_status', true ) ) ) : echo 'false'; endif; ?>" style="color:#50AE54" title="Asset Status"></span></a>
                     <a href="#assetprolicense_<?php echo $id;?>" data-toggle="modal" data-target="#assetprolicense_<?php echo $id;?>"><span class="fab fa-product-hunt fa-lg <?php if( empty( get_post_meta( $id, 'pro_license', true ) ) ) : echo 'false'; endif; ?>" title="Guru License" ></span></a>
                     <a href="#assetbackup_<?php echo $id;?>" data-toggle="modal" data-target="#assetbackup_<?php echo $id;?>"><span class="fas fa-database fa-lg <?php if( empty( get_post_meta( $id, 'msp_backup_schedule', true ) ) ) : echo 'false'; endif; ?>" title="Backup"></span></a>
                     <a href="#assetpatchmanagement_<?php echo $id;?>" data-toggle="modal" data-target="#assetpatchmanagement_<?php echo $id;?>"> <span class="fas fa-tasks fa-lg <?php if( empty( get_post_meta( $id, 'patch_installed', true ) ) ) : echo 'false'; endif; ?>" title="Patch Management"></span></a>
                     <a href="#assetlogins_<?php echo $id;?>" data-toggle="modal" data-target="#assetlogins_<?php echo $id;?>"><span class="fas fa-sign-in-alt fa-lg <?php if( empty( get_post_meta( $id, 'local_admin_username', true ) ) ) : echo 'false'; endif; ?>" title="Asset Logins" ></span></a>
                     <a href="#assetex05_<?php echo $id;?>" data-toggle="modal" data-target="#assetex05_<?php echo $id;?>"> <span class="fas fa-lock fa-lg <?php if( empty( get_post_meta( $id, 'ex05_licence', true ) ) ) : echo 'false'; endif; ?>" title="Encryption"></span></a>
                     <a href="#assetsecurity_<?php echo $id;?>" data-toggle="modal" data-target="#assetsecurity_<?php echo $id;?>"> <span class="fas fa-key fa-lg <?php if( empty( get_post_meta( $id, 'av_installed', true ) ) ) : echo 'false'; endif; ?>" title="Security Manager"></span></a>
                     <a href="#assetspecs_<?php echo $id;?>" data-toggle="modal" data-target="#assetspecs_<?php echo $id;?>"><span class="fas fa-glasses fa-lg <?php if( empty( get_post_meta( $id, 'manufacturer', true ) ) ) : echo 'false'; endif; ?>" title="Specifications"></span></a>
                     <a href="#assetwarranty_<?php echo $id;?>" data-toggle="modal" data-target="#assetwarranty_<?php echo $id;?>"><span class="fas fa-pound-sign fa-lg <?php if( empty( get_post_meta( $id, 'purchase_order_no', true ) ) ) : echo 'false'; endif; ?>" title="Purchasing & Warranty Information"></span></a>
                     
                    </td>
                     <td class="modalsloader"><?php
                     include get_template_directory() . '/assets-modal.php'; ?></td> 
                     </tr>
                   
                    


                    
                    <?php
                    endwhile;
  
  echo '</table></div>';
 
  
else :

  echo '<p>This Client Has no Assets</p>';
  
endif;

wp_reset_postdata();?>
                    <!-- Table -->
                    
                
            </div>
              
            <div class="tab-pane fade" id="tab9email">
              <?php	
              
$args = array(
		'post_type' => 'services',
    'posts_per_page' => 999,
    'orderby' => 'title',
    'order' => 'ASC',
		'meta_query' => array(
			array(
				'key'     => 'client',
				'value' => get_the_id(),
				'compare' => '=',
      ),
      array(
        'key' => 'type',
            'value' => 'email' ,
          ),
		)
	);

	$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>
<div class="filter-container">
  <div class="filter-column" style="width:230px;">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">LICENSE STATUS</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
    <div class="filter-box">
      <div class="filter-count"><?php echo $the_query->found_posts; ?></div>
      <button class="filter-title btn-filter email" type="button" data-target="all">TOTAL</button>
</div>
      <div class="filter-box">
      <div class="filter-count-green"><?php $args = array(   'post_type' => 'services',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'email' ,
        ),    array(       'key'     => 'user_status',       'value'   => 'Active',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-green btn-filter email" type="button" data-target="Active">ACTIVE</button>
</div>
      <div class="filter-box">
      <div class="filter-count-red"><?php $args = array(   'post_type' => 'services',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'email' ,
        ),    array(       'key'     => 'user_status',       'value'   => 'Not Active',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-red btn-filter email" type="button" data-target="Not Active">NOT ACTIVE</button>
</div>
</div>
<div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span>PROVIDER<span style="font-weight:bold;font-size:14px;">TYPE</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
<div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'services',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'email' ,
        ),    array(       'key'     => 'license_type',       'value'   => 'Active',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="Office 365">OFFICE 365</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'services',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'email' ,
        ),    array(       'key'     => 'license_type',       'value'   => 'Gsuite',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="Gsuite">GSUITE</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php $args = array(   'post_type' => 'services',   'posts_per_page' => 9999,   'orderby' => 'title',   'order' => 'ASC',   'meta_query' => array( array(
			'key'     => 'client',
			'value'   => get_the_id(),
			'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'email' ,
        ),    array(       'key'     => 'license_type',       'value'   => 'Third Party',       'compare' => '=',     ),   ) ); $inner_query = new WP_Query( $args ); ?><?php if ($inner_query->have_posts()) : echo $inner_query->found_posts; ?>  <?php else :  echo '0' ?> <?php endif; ?></div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="Third Party">THIRD PARTY</button>
</div>
</div>
<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false" style="float:left;width:242px;height:201px;">
  <!-- Indicators -->
  <ol class="carousel-indicators" style="bottom: -23px; left:139px;">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="box-title" style="color:#999;margin-left:50px;">
      <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">OFFICE 365</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
          </div>
  <div class="carousel-inner">
    <div class="item active">
      <div class="filter-column">
<div class="filter-box">
      <div class="filter-count-blue"> <?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'office365',
            'value' => 'Business Premium',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="Business Premium" style="font-size:14px;">BUSINESS PREMIUM</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"> <?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'office365',
            'value' => 'Business Essentials',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="Business Essentials" style="font-size:14px;">BUSINESS ESSENTIALS</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"> <?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'office365',
            'value' => 'Business Premium',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="Business Premium" style="font-size:14px;">BUSINESS PREMIUM</button>
</div>
</div>
    </div>

    <div class="item">
      <div class="filter-column">
<div class="filter-box">
      <div class="filter-count-blue"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'office365',
            'value' => 'OWA1',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="OWA1">OWA PLAN 1</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'office365',
            'value' => 'OWA2',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="OWA2">OWA PLAN 2</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'office365',
            'value' => 'PowerBI',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="PowerBI">POWER BI PRO</button>
</div>
</div>
    </div>

    <div class="item">
      <div class="filter-column">
<div class="filter-box">
      <div class="filter-count-blue"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'office365',
            'value' => 'AD Basic',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="AD Basic">AD BASIC</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'office365',
            'value' => 'AD Premium',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="AD Premium">AD PREMIUM</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'office365',
            'value' => 'VOP2',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="VOP2" style="font-size:12px;">VISION ONLINE PLAN 2</button>
</div>
</div>
    </div>
    <div class="item">
      <div class="filter-column">
<div class="filter-box">
      <div class="filter-count-blue"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'office365',
            'value' => 'Enterprise E1',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="Enterprise E1">ENTERPRISE E1</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'office365',
            'value' => 'Enterprise E2',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="Enterprise E2">ENTERPRISE E2</button>
</div>
      
</div>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev" style="background:none; margin-left:-8px;">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next" style="background:none;margin-right:-15px;">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span>GSUITE<span style="font-weight:medium;font-size:14px;color:#2A317E;"></span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
<div class="filter-box">
      <div class="filter-count-blue"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'gsuite',
            'value' => 'NFP',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="NFP">NOT FOR PROFIT</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'gsuite',
            'value' => 'Basic',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="Basic">BASIC</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'gsuite',
            'value' => 'Business',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="Business">BUSINESS</button>
</div>
</div>
<div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span>MAILBOX<span style="font-weight:bold;font-size:14px;">TYPE</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
<div class="filter-box">
      <div class="filter-count-blue"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'mailbox_type',
            'value' => 'Alias',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="Alias">ALIAS</button>
</div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'email'
        ),
        array(
            'key' => 'mailbox_type',
            'value' => 'Shared Mailbox',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-blue btn-filter email" type="button" data-target="Shared Mailbox">SHARED MAILBOX</button>
</div>
      
</div>
</div>
<button class="box-title btn-filter email" type="button" data-target="all" style="color:#999;float:right;border: none; background-color: #eeeded;">
             <i style="color:#932082; margin-left:10px;" class="fas fa-power-off"></i><span style="font-weight:bold;font-size:14px;"> RESET</span>FILTERS
</button>
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th style="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Email Address</strong></th>
                      <th style="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Password</strong></th>
                      <th style="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Licence Type</strong></th>
                      <th style="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Notes</strong></th>
                      <th style="equal-width"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Functions</strong></th>
                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr class="filterable email" <?php $meta_key = 'user_status'; $id = get_the_id(); ?> data-status="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>"
                    <?php $meta_key = 'license_type'; $id = get_the_id();?>  data-provider-type="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>"
                    <?php $meta_key = 'office365'; $id = get_the_id(); ?> data-office-365="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>"
                    <?php $meta_key = 'gsuite'; $id = get_the_id(); ?> data-gsuite="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>"
                    <?php $meta_key = 'mailbox_type'; $id = get_the_id(); ?>  data-mailbox-type="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>">
                      <td>
                        <?php $meta_key = 'email_address'; $id = get_the_id();?>
                        <a data-title="Title" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                         <?php $meta_key = 'password'; $id = get_the_id();?>
                        <a data-title="Password" href="#" id="password" type="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        <i class="glyphicon glyphicon-eye-open"></i>
                      </td>
                      <td>
                        <?php $meta_key = 'license_type'; $id = get_the_id();?>
                        <a data-title="License Type" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td></td>
                      <td></td>
                    </tr>


                    <?php endwhile; wp_reset_postdata();
  
  echo '</table></div>'; ?>
					  <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#email">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add Email 
</button>

                    <!-- Modal -->
                    <div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="email">Add Email</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=16]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
					  <?php wp_reset_postdata();
  
else :

  echo '<p>Client Has No Email Services</p>'; ?>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#email">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add Email 
</button>

                    <!-- Modal -->
                    <div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="email">Add Email</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=16]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php endif; wp_reset_postdata();?>
                    <!-- Table -->
                


            </div>


            <div class="tab-pane fade" id="tab11internal">
              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'services',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key'     => 'client',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'internal' ,
        ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>
<div class="filter-container">
  <div class="filter-column">
  <div class="box-title" style="color:#999;width:210px;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">INTERNAL SERVICESTATUS</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
    <div class="filter-box">
      <div class="filter-count"><?php echo $the_query->found_posts; ?></div>
      <button class="filter-title btn-filter internal" type="button" data-target="all">TOTAL</button>
</div>
      <div class="filter-box">
      <div class="filter-count-green"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'internal'
        ),
        array(
            'key' => 'internal_status',
            'value' => 'Active',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-green btn-filter internal" type="button" data-target="Active">ACTIVE</button>
</div>
      <div class="filter-box">
      <div class="filter-count-red"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'internal'
        ),
        array(
            'key' => 'internal_status',
            'value' => 'Not Active',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-red btn-filter internal" type="button" data-target="Not Active">NOT ACTIVE</button>
</div>
</div>
</div>
<button class="box-title btn-filter internal" type="button" data-target="all" style="color:#999;float:right;border: none; background-color: #eeeded;">
             <i style="color:#932082; margin-left:10px;" class="fas fa-power-off"></i><span style="font-weight:bold;font-size:14px;"> RESET</span>FILTERS
</button>
                <div class="table-responsive max-height" style="max-height: 475px;">
                  <table class="table">
                    <tr>                    
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Service Name</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">URL</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Username</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Password</strong></th>
                      <th style="equal-width;"> <strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Status</strong></th>
                      <th style="equal-width;"> <strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Notes</strong></th>
                      <th style="equal-width;"> <strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Functions</strong></th>
                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr class="filterable internal" <?php $meta_key = 'internal_status'; $id = get_the_id();?>data-status="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>">                      
                      <td>
                        <?php $meta_key = 'internal_type'; $id = get_the_id();?>
                        <a data-title="Domain Registration" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'internal_url'; $id = get_the_id();?>
                        <a data-title="Nameservers" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'internal_username'; $id = get_the_id();?>
                        <a data-title="Domin Registra" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                      <i class="fas fa-paste" style="color:#932082"></i>
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <?php $meta_key = 'internal_password'; $id = get_the_id();?>
                        <a data-title="Domain Expiry Date" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      
                      </td>
                      <td>
                      <?php $meta_key = 'internal_status'; $id = get_the_id(); ?><a data-title="Internal Service Status" href="#" id="site-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active',text:'Active'},{value:'Not Active',text:'Not Active'},{value:'None',text:'None'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                      </td>
                      <td>
                        <?php $meta_key = 'internal_notes'; $id = get_the_id();?>
                        <a data-title="Registra Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                      <i class="far fa-trash-alt"></i>
                      </td>


                    </tr>


                    <?php endwhile; wp_reset_postdata();
  
  echo '</table></div>';?>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#internalservices">
  <span class="glyphicon glyphicon-plus-sign"></span>  Add Internal Services
</button>

                    <!-- Modal -->
                    <div class="modal fade" id="internalservices" tabindex="-1" role="dialog" aria-labelledby="internalservices" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="internalservicestitle">Create Internal Service</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=12]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
					   
					  <?php
  
else :

  echo '<p>This Client Has No Internal Services</p>'; ?>
					  
					  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#internalservices">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add Internal Services
</button>

                    <!-- Modal -->
                    <div class="modal fade" id="internalservices" tabindex="-1" role="dialog" aria-labelledby="internalservices" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="internalservicestitle">Create Internal Service</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                          </div>
                          <div class="modal-body">
                            <?php echo do_shortcode("[ninja_form id=12]"); ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
  
<?php endif; wp_reset_postdata();?>
                    <!-- Table -->
                    
                
                <!-- Button trigger modal -->
            </div>

            <div class="tab-pane fade" id="tab6webhosting">
              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'services',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key'     => 'client',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'hosting' ,
        ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>
<div class="filter-container">
  <div class="filter-column">
  <div class="box-title" style="color:#999;width:210px;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span><span style="font-weight:medium;font-size:14px;color:#2A317E;">WEBHOSTING STATUS</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
    <div class="filter-box">
      <div class="filter-count"><?php echo $the_query->found_posts; ?></div>
      <button class="filter-title btn-filter hosting" type="button" data-target="all">TOTAL</button>
</div>
      <div class="filter-box">
      <div class="filter-count-green"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'hosting'
        ),
        array(
            'key' => 'hosting_status',
            'value' => 'Active',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-green btn-filter hosting" type="button" data-target="Active">ACTIVE</button>
</div>
      <div class="filter-box">
      <div class="filter-count-red"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'hosting'
        ),
        array(
            'key' => 'hosting_status',
            'value' => 'Not Active',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-red btn-filter hosting" type="button" data-target="Not Active">NOT ACTIVE</button>
</div>
</div>
</div>
<button class="box-title btn-filter hosting" type="button" data-target="all" style="color:#999;float:right;border: none; background-color: #eeeded;">
             <i style="color:#932082; margin-left:10px;" class="fas fa-power-off"></i><span style="font-weight:bold;font-size:14px;"> RESET</span>FILTERS
</button>
                <div class="table-responsive">
                  <table class="table">
                    <tr>                     
                      <th style="width:8%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Domain</strong></th>
                      <th style="width:13%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Username</strong></th>
                      <th style="width:13%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Password</strong></th>
                      <th style="width:10%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Package</strong></th>
                      <th style="width:10%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Server</strong></th>
                      <th style="width:10%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Status</strong></th>
                      <th style="width:10%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">NOTES</strong></th>
                      <th style="width:13%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">FUNCTIONS</strong></th>
                    </tr>

                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr class="filterable hosting" <?php $meta_key = 'hosting_status'; $id = get_the_id();?>data-status="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>">                      
                      <td>
                        <?php $meta_key = 'hosting_host'; $id = get_the_id();?>
                        <a data-title="Host" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'cpanel_username'; $id = get_the_id();?>
                        <a data-title="cPanel Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                    
                      <i class="fas fa-paste" style="color:#932082"></i>
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <?php $meta_key = 'cpanel_password'; $id = get_the_id();?>
                        <a data-title="cPanel Password" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                        
                      </td>
                      <td>
                      <?php $meta_key = 'package'; $id = get_the_id(); ?><a data-title="Package" href="#" id="site-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Shared 1',text:'Shared 1'},{value:'Shared 2',text:'Shared 2'},{value:'Shared 3',text:'Shared 3'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                        </a>
                      </td>
                      <td>
                      <?php $meta_key = 'hosting_server'; $id = get_the_id(); ?><a data-title="Server" href="#" id="site-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Saturn',text:'Saturn'},{value:'External',text:'External'},{value:'None',text:'None'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                        </a>
                      </td>
                      <td> 
                      <?php $meta_key = 'hosting_status'; $id = get_the_id(); ?><a data-title="Hosting Status" href="#" id="site-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active',text:'Active'},{value:'Not Active',text:'Not Active'},{value:'None',text:'None'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                        </a>
                      </td>
                      <td>
                      <?php $meta_key = 'hosting_notes'; $id = get_the_id();?>
                        <a data-title="Hosting Notes" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                      <i class="far fa-trash-alt"></i>
                      </td>
                      
                    </tr>


                    <?php endwhile;
  
  echo '</table></div>'; ?>
					  <?php
  
else :

  echo '<p>This Client Has no Assets</p>';
  
endif;
					  wp_reset_postdata();?>
					 
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#hostingmodal">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add Web Hosting
</button>

                <!-- Modal -->
                <div class="modal fade" id="hostingmodal" tabindex="-1" role="dialog" aria-labelledby="hostingmodal" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="hostingmodal">Add Web Hosting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=9]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
  
<?php  wp_reset_postdata();?>
                
                
            </div>
            <div class="tab-pane fade" id="tab7domains">
              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'services',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key'     => 'client',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'domain' ,
        ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>
<div class="filter-container">
  <div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span>DOMAIN STATUS</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
    <div class="filter-box">
      <div class="filter-count"><?php echo $the_query->found_posts; ?></div>
      <button class="filter-title btn-filter domain" type="button" data-target="all">TOTAL</button>
</div>
      <div class="filter-box">
      <div class="filter-count-green"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'domain'
        ),
        array(
            'key' => 'domain_status',
            'value' => 'Active',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-green btn-filter domain" type="button" data-target="Active">ACTIVE</button>
</div>
      <div class="filter-box">
      <div class="filter-count-red"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'domain'
        ),
        array(
            'key' => 'domain_status',
            'value' => 'Expired',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-red btn-filter domain" type="button" data-target="Not Active">NOT ACTIVE</button>
</div>
</div>
</div>
<button class="box-title btn-filter domain" type="button" data-target="all" style="color:#999;float:right;border: none; background-color: #eeeded;">
             <i style="color:#932082; margin-left:10px;" class="fas fa-power-off"></i><span style="font-weight:bold;font-size:14px;"> RESET</span>FILTERS
</button>
                <div class="table-responsive">
                  <table class="table">
                    <tr>                      
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Domain</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Registra</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Expiry Date</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Renewal Price</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Status</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Notes</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">FUNCTIONS</strong></th>
                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr class="filterable domain" <?php $meta_key = 'domain_status'; $id = get_the_id();?>data-status="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>">                      
                      <td>
                        <?php $meta_key = 'domain_registration'; $id = get_the_id();?>
                        <a data-title="Domain Registration" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'domain_registra'; $id = get_the_id();?>
                        <a data-title="Domin Registra" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'domain_expiry'; $id = get_the_id();?>
                        <a data-title="Domain Expiry Date" href="#" id="date" name="<?php echo $meta_key;?>" data-type="date" data-format="dd/mm/yyyy" data-viewformat="dd/mm/yyyy" data-inputclass="date" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                      <?php $meta_key = 'domain_renewal_price'; $id = get_the_id();?>
                        <a data-title="Renewal Price" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        
                        <?php $meta_key = 'domain_status'; $id = get_the_id(); ?><a data-title="Site Status" href="#" id="site-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active',text:'Active'},{value:'Expired',text:'Expired'},{value:'None',text:'None'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'domain_notes'; $id = get_the_id();?>
                        <a data-title="Domain Notss" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <i class="far fa-trash-alt"></i>
                        
                      </td>

                    </tr>


                    <?php endwhile;
  
  echo '</table></div>'; wp_reset_postdata(); ?>
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#domainsmodal">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add Domains
</button>

                <!-- Modal -->
                <div class="modal fade" id="domainsmodal" tabindex="-1" role="dialog" aria-labelledby="domainsmodal" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="domainsmodal">Add Domain</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=10]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
					  <?php
  
else :

  echo '<p>This Client Has no Domains</p>'; ?>
					  
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#domainsmodal">
  Add Domains
</button>

                <!-- Modal -->
                <div class="modal fade" id="domainsmodal" tabindex="-1" role="dialog" aria-labelledby="domainsmodal" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="domainsmodal">Create Client Domain</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=10]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
  
<?php endif; wp_reset_postdata();?>
                    <!-- Table -->
                
                
            </div>
            <div class="tab-pane fade" id="tab8crushftp">
              <?php

	$args = array(
		'post_type' => 'services',
    'posts_per_page' => 999,
    'orderby' => 'title',
    'order' => 'ASC',
		'meta_query' => array(
			array(
				'key'     => 'client',
				'value'   => get_the_id(),
				'compare' => '=',
      ),
      array(
        'key' => 'type',
            'value' => 'crush' ,
          ),
		)
	);

	$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>
<div class="filter-container">
  <div class="filter-column" style="width:230px;">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span>SFTPSTATUS</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
    <div class="filter-box">
      <div class="filter-count"><?php echo $the_query->found_posts; ?></div>
      <button class="filter-title btn-filter crush" type="button" data-target="all">TOTAL</button>
</div>
      <div class="filter-box">
      <div class="filter-count-green"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'crush'
        ),
        array(
            'key' => 'sftp_status',
            'value' => 'Active',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-green btn-filter crush" type="button" data-target="Active">ACTIVE</button>
</div>
      <div class="filter-box">
      <div class="filter-count-red"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'crush'
        ),
        array(
            'key' => 'sftp_status',
            'value' => 'Not Active',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-red btn-filter crush" type="button" data-target="Not Active">NOT ACTIVE</button>
</div>
</div>
<div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span>PACKAGES<span style="font-weight:bold;font-size:14px;"></span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
</div>
</div>
<button class="box-title btn-filter crush" type="button" data-target="all" style="color:#999;float:right;border: none; background-color: #eeeded;">
             <i style="color:#932082; margin-left:10px;" class="fas fa-power-off"></i><span style="font-weight:bold;font-size:14px;"> RESET</span>FILTERS
</button>
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Host</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Username</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Password</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Package</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Status</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">notes</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">FUNCTIONS</strong></th>
                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr class="filterable crush" <?php $meta_key = 'sftp_status'; $id = get_the_id();?>data-status="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>">
                      <td>
                        <?php $meta_key = 'sftp_host'; $id = get_the_id();?>
                        <a data-title="Host" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'sftp_username'; $id = get_the_id();?>
                        <a data-title="Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                      <i class="fas fa-paste" style="color:#932082"></i>
                      <i class="glyphicon glyphicon-eye-open"></i>
                        <?php $meta_key = 'sftp_password'; $id = get_the_id();?>
                        <a data-title="Password" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      
                      </td>
                      <td>
                      <?php $meta_key = 'sftp_package'; $id = get_the_id(); ?><a data-title="SFTP Package" href="#" id="site-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'1',text:'1'},{value:'2',text:'2'},{value:'3',text:'3'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                      </td>
                      <td>
                      <?php $meta_key = 'sftp_status'; $id = get_the_id(); ?><a data-title="SFTP Status" href="#" id="site-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active',text:'Active'},{value:'Not Active',text:'Not Active'},{value:'None',text:'None'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                      </td>
                      <td>
                      <?php $meta_key = 'sftp_notes'; $id = get_the_id();?>
                        <a data-title="SFTP Notes" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                      <i class="far fa-trash-alt"></i>
                      </td>

                    </tr>


                    <?php endwhile;
  
  echo '</table></div>'; wp_reset_postdata(); ?>
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crushftp">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add SFTP
</button>

                <!-- Modal -->
                <div class="modal fade" id="crushftp" tabindex="-1" role="dialog" aria-labelledby="crushftp" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="crushftp">Add SFTP</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                      <?php echo do_shortcode("[ninja_form id=15]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
					  <?php
  
else :

  echo '<p>Client Has No SFTP Services</p>'; ?>
					  
					   <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crushftp">
  Add SFTP
</button>

                <!-- Modal -->
                <div class="modal fade" id="crushftp" tabindex="-1" role="dialog" aria-labelledby="crushftp" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="crushftp">Add SFTP</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=15]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
  
<?php endif; wp_reset_postdata();?>
                    <!-- Table -->
                
               

            </div>


            <div class="tab-pane fade" id="tab12external">
              <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'services',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key'     => 'client',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'external' ,
        ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>
<div class="filter-container">
  <div class="filter-column">
  <div class="box-title" style="color:#999;width:210px;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span>EXTERNALSERVICES</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
    <div class="filter-box">
      <div class="filter-count"><?php echo $the_query->found_posts; ?></div>
      <button class="filter-title btn-filter external" type="button" data-target="all">TOTAL</button>
</div>
      <div class="filter-box">
      <div class="filter-count-green"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'external'
        ),
        array(
            'key' => 'external_status',
            'value' => 'Active',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-green btn-filter external" type="button" data-target="Active">ACTIVE</button>
</div>
      <div class="filter-box">
      <div class="filter-count-red"><?php
$args        = array(
    'post_type' => 'services',
    'posts_per_page' => 9999,
    'orderby' => 'title',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'client',
            'value' => get_the_id(),
            'compare' => '='
        ),
        array(
            'key' => 'type',
            'value' => 'external'
        ),
        array(
            'key' => 'external_status',
            'value' => 'Not Active',
            'compare' => '='
        )
    )
);
$inner_query = new WP_Query($args);
?><?php
if ($inner_query->have_posts()):
    echo $inner_query->found_posts;
?>  <?php
else:
    echo '0';
?> <?php
endif;
?> </div>
      <button class="filter-title-red btn-filter external" type="button" data-target="Not Active">NOT ACTIVE</button>
</div>
</div>
</div>
<button class="box-title btn-filter external" type="button" data-target="all" style="color:#999;float:right;border: none; background-color: #eeeded;">
             <i style="color:#932082; margin-left:10px;" class="fas fa-power-off"></i><span style="font-weight:bold;font-size:14px;"> RESET</span>FILTERS
</button>
                <div class="table-responsive">
                  <table class="table">
                    <tr>                    
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Service Name</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">URL</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Username</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Password</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">STATUS</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Notes</strong></th>
                      <th style="equal-width;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">FUNCTIONS</strong></th>
                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr class="filterable external" <?php $meta_key = 'external_status'; $id = get_the_id();?>data-status="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>">                      
                      <td>
                        <?php $meta_key = 'external_type'; $id = get_the_id();?>
                        <a data-title="External Type" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'external_url'; $id = get_the_id();?>
                        <a data-title="External URL" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'external_username'; $id = get_the_id();?>
                        <a data-title="External Username" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                      <i class="fas fa-paste" style="color:#932082"></i>
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <?php $meta_key = 'external_password'; $id = get_the_id();?>
                        <a data-title="External Password" href="#" id="password" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field password">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                       
                      </td>
                      <td>
                    
                  <?php $meta_key = 'external_staus'; $id = get_the_id(); ?><a data-title="Site Status" href="#" id="site-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active',text:'Active'},{value:'Not Active',text:'Not Active'},{value:'None',text:'None'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                
                  </td>
                      </td>
                      <td>
                        <?php $meta_key = 'external_notes'; $id = get_the_id();?>
                        <a data-title="External Notes" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                      <i class="far fa-trash-alt"></i>
                        </a>
                      </td>
                    </tr>


                    <?php endwhile;
  
  echo '</table></div>';?>
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#externalservice">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add External Service
</button>

                <!-- Modal -->
                <div class="modal fade" id="externalservice" tabindex="-1" role="dialog" aria-labelledby="externalservice" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="externalservice">Add External Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                      <?php echo do_shortcode("[ninja_form id=11]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
					  <?php
  
else :

  echo '<p>This Client Has No External Services</p>'; ?>
					  
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#externalservice">
  Add External Service
</button>

                <!-- Modal -->
                <div class="modal fade" id="externalservice" tabindex="-1" role="dialog" aria-labelledby="externalservice" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="externalservice">Add External Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                      <?php echo do_shortcode("[ninja_form id=11]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
  
<?php endif; wp_reset_postdata();?>
                    <!-- Table -->
                
                
            </div>
                 <div class="tab-pane fade" id="tab10faq">
                 <?php
$current_client = $post->ID;
$querystr = "
SELECT {$wpdb->prefix}wsdesk_tickets.*,
(SELECT {$wpdb->prefix}wsdesk_ticketsmeta.meta_value
FROM {$wpdb->prefix}wsdesk_ticketsmeta WHERE meta_key ='ticket_label' AND {$wpdb->prefix}wsdesk_ticketsmeta.ticket_id = {$wpdb->prefix}wsdesk_tickets.ticket_id ) AS ticket_lb,
(SELECT {$wpdb->prefix}wsdesk_ticketsmeta.meta_value
FROM {$wpdb->prefix}wsdesk_ticketsmeta WHERE meta_key ='ticket_tags' AND {$wpdb->prefix}wsdesk_ticketsmeta.ticket_id = {$wpdb->prefix}wsdesk_tickets.ticket_id ) AS ticket_tgs,
(SELECT {$wpdb->prefix}wsdesk_ticketsmeta.meta_value
FROM {$wpdb->prefix}wsdesk_ticketsmeta WHERE meta_key ='ticket_assignee' AND {$wpdb->prefix}wsdesk_ticketsmeta.ticket_id = {$wpdb->prefix}wsdesk_tickets.ticket_id ) AS ticket_asn,
(SELECT {$wpdb->prefix}wsdesk_ticketsmeta.meta_value
FROM {$wpdb->prefix}wsdesk_ticketsmeta WHERE meta_key ='field_KQ13' AND {$wpdb->prefix}wsdesk_ticketsmeta.ticket_id = {$wpdb->prefix}wsdesk_tickets.ticket_id ) AS assetid,
(SELECT {$wpdb->prefix}wsdesk_ticketsmeta.meta_value
FROM {$wpdb->prefix}wsdesk_ticketsmeta WHERE meta_key ='field_HN27' AND {$wpdb->prefix}wsdesk_ticketsmeta.ticket_id = {$wpdb->prefix}wsdesk_tickets.ticket_id ) AS priority,
(SELECT {$wpdb->prefix}wsdesk_ticketsmeta.meta_value
FROM {$wpdb->prefix}wsdesk_ticketsmeta WHERE meta_key ='field_WC34' AND {$wpdb->prefix}wsdesk_ticketsmeta.ticket_id = {$wpdb->prefix}wsdesk_tickets.ticket_id ) AS clientid,
(SELECT {$wpdb->prefix}wsdesk_ticketsmeta.meta_value
FROM {$wpdb->prefix}wsdesk_ticketsmeta WHERE meta_key ='field_RI04' AND {$wpdb->prefix}wsdesk_ticketsmeta.ticket_id = {$wpdb->prefix}wsdesk_tickets.ticket_id ) AS userid,
(SELECT {$wpdb->prefix}wsdesk_ticketsmeta.meta_value
FROM {$wpdb->prefix}wsdesk_ticketsmeta WHERE meta_key ='field_MG53' AND {$wpdb->prefix}wsdesk_ticketsmeta.ticket_id = {$wpdb->prefix}wsdesk_tickets.ticket_id ) AS siteid,
(SELECT {$wpdb->prefix}wsdesk_ticketsmeta.meta_value
FROM {$wpdb->prefix}wsdesk_ticketsmeta WHERE meta_key ='field_KE81' AND {$wpdb->prefix}wsdesk_ticketsmeta.ticket_id = {$wpdb->prefix}wsdesk_tickets.ticket_id ) AS tag
FROM {$wpdb->prefix}wsdesk_tickets, {$wpdb->prefix}wsdesk_ticketsmeta
WHERE {$wpdb->prefix}wsdesk_ticketsmeta.meta_value = '$current_client'
AND {$wpdb->prefix}wsdesk_ticketsmeta.meta_key = 'field_WC34'
AND {$wpdb->prefix}wsdesk_ticketsmeta.ticket_id = {$wpdb->prefix}wsdesk_tickets.ticket_id
ORDER BY {$wpdb->prefix}wsdesk_tickets.ticket_updated DESC
";
$pageposts = $wpdb->get_results($querystr, OBJECT);




if ($pageposts) : ?>
<div class="filter-container" style="height:280px;">
  <div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span>SITE<span style="font-weight:bold;font-size:14px;">STATUS</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
    <div class="filter-box">
      <div class="filter-count"><?php echo "{$dlcount}"; ?></div>
      <div class="filter-title">UNASSIGNED</div>
</div>
<div class="filter-box">
      <div class="filter-count-orange"><?php echo "{$ipcount}"; ?></div>
      <div class="filter-title-orange">IN PROGRESS</div>
      </div>
      <div class="filter-box">
      <div class="filter-count-red"><?php echo "{$arcount}"; ?></div>
      <div class="filter-title-red">AWAITING REPLY</div>
      
</div>
<div class="filter-box">
      <div class="filter-count-green"><?php echo "{$compcount}"; ?></div>
      <div class="filter-title-green">COMPLETED</div>
      
</div>
</div>
<div class="filter-column" style="margin-left:70px;margin-right:50px;">
  <div class="box-title" style="color:#999;width:200px;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span>ENGINEER<span style="font-weight:bold;font-size:14px;">STATUS</span> TOTAL<i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
<div class="filter-box">
      <div class="filter-count-orange"><?php echo $the_query->found_posts; ?></div>
      <div class="filter-title-orange">IN PROGRESS</div>
      </div>
      <div class="filter-box">
      <div class="filter-count-red"><?php echo $the_query->found_posts; ?></div>
      <div class="filter-title-red">AWAITING REPLY</div>
      
</div>
<div class="filter-box">
      <div class="filter-count-green"><?php echo $the_query->found_posts; ?></div>
      <div class="filter-title-green">COMPLETED</div>
      
</div>
</div>
<div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span>BY<span style="font-weight:bold;font-size:14px;">TAG</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
<div class="filter-box">
      <div class="filter-count-blue"><?php echo $the_query->found_posts; ?></div>
      <div class="filter-title-blue">ADMIN</div>
      </div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php echo $the_query->found_posts; ?></div>
      <div class="filter-title-blue">ACCOUNTS</div>
      
</div>
<div class="filter-box">
      <div class="filter-count-blue"><?php echo $the_query->found_posts; ?></div>
      <div class="filter-title-blue">REACTIVE</div>
      
</div>
</div>
<div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span>BY<span style="font-weight:bold;font-size:14px;">PRIORITY</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
<div class="filter-box">
      <div class="filter-count-blue"><?php echo $the_query->found_posts; ?></div>
      <div class="filter-title-blue">LOW</div>
      </div>
      <div class="filter-box">
      <div class="filter-count-blue"><?php echo $the_query->found_posts; ?></div>
      <div class="filter-title-blue">MEDIUM</div>
      
</div>
<div class="filter-box">
      <div class="filter-count-blue"><?php echo $the_query->found_posts; ?></div>
      <div class="filter-title-blue">HIGH</div>
      
</div>
</div>
</div>
<div class="helpdesk_overview" style="background-color:white; padding-top:10px;max-height:475px;overflow-y:auto;">
<?php foreach ($pageposts as $key => $value) {
  $current_user = get_userdata($value->ticket_author);
					 ?>

<div class="ticket_container" style="height:70px;border-radius:5px;margin:25px;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);">

<div class="ticket_top_container" style="background-color:white;">
        <div class="ticket_title" style="font-size:25px; color:#99999F;font-weight:bold;margin-left:15px;padding-top:10px;"><?php echo $value->ticket_title; 
					 ?></div>
    </div>
    <div class="bottom_container <?php echo $value->ticket_lb;?>" style="color:white; background-color:#99999F;height:30%;margin-top:12px;border-radius:0px 0px 5px 5px">
        <div class="hd_ticket <?php echo $value->ticket_lb;?>" style="float:left;margin-right:20px;margin-left:10px;"><?php echo $value->ticket_id;?> |</div><div class="hd_ticket_date" style="float:left;margin-right:20px;"><?php echo $value->ticket_date;?> |</div><div class="hd_ticket_time" style="float:left;margin-right:20px;"><?php echo $value->ticket_updated;?> |</div><div class="hd_ticket_client" style="float:left;margin-right:20px;"> <?php echo get_the_title($value->clientid);?></div><div class="right_bottom" style="float:right;"><div class="hd_ticket_engineer" style="float:left;margin-right:20px;">Engineer: <?php $engineer = unserialize($value->ticket_asn); $engname = get_userdata($engineer[0]); echo $engname->display_name ?></div><div class="hd_ticket_requester" style="float:left;margin-right:20px;">Requester: <?php get_userdata( $value->ticket_author ); echo $current_user->display_name ?> </div></div></div>
        <a href="#" data-toggle="modal" data-target="#ticket_<?php echo $value->ticket_id;?>" style="height: 100%;width: 100%;display: block;margin-top:-80px;"></a>
    </div>
    <div class="modalsloader"><?php
                     include get_template_directory() . '/helpdesk-modal.php'; ?></div> 
                     
					 <?php }; ?>
</div>
					

                <!-- Modal -->
                <div class="modal fade" id="notes" tabindex="-1" role="dialog" aria-labelledby="notes" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="notes">Create Support Ticket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
					  <?php
  
else :

  echo '<p>Client Has No Notes</p>'; ?>
					  
					   <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crushftp">
  Create Support Tic
</button>

                <!-- Modal -->
                <div class="modal fade" id="crushftp" tabindex="-1" role="dialog" aria-labelledby="crushftp" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="notes">Create Notes</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
  
<?php endif; wp_reset_postdata();?>
                    <!-- Table -->
                
               

            </div>
            <div class="tab-pane fade" id="tab14ssl">
            <?php

// get all associated services associated with this client

$args = array(
  'post_type' => 'services',
  'posts_per_page' => 9999,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key'     => 'client',
      'value'   => get_the_id(),
      'compare' => '=',
    ),
    array(
      'key' => 'type',
          'value' => 'ssl' ,
        ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) : ?>
<div class="filter-container">
  <div class="filter-column">
  <div class="box-title" style="color:#999;">
              <span style="font-weight:bold;font-size:14px;color:#932082; margin-right:5px;">I</span>SSLSTATUS</span><i class="fas fa-question-circle" href="#" data-toggle="tooltip" title="Tooltip Text Goes Here" style="color:#932082; margin-left:10px;"></i>
                  </div>
    <div class="filter-box">
      <div class="filter-count"><?php echo $the_query->found_posts; ?></div>
      <button class="filter-title btn-filter ssl" type="button" data-target="all">TOTAL</button>
</div>
      <div class="filter-box">
      <div class="filter-count-green"><?php
        $args        = array(
            'post_type' => 'services',
            'posts_per_page' => 9999,
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'client',
                    'value' => get_the_id(),
                    'compare' => '='
                ),
                array(
                    'key' => 'type',
                    'value' => 'ssl'
                ),
                array(
                    'key' => 'ssl_status',
                    'value' => 'Active',
                    'compare' => '='
                )
            )
        );
        $inner_query = new WP_Query($args);
        ?><?php
        if ($inner_query->have_posts()):
            echo $inner_query->found_posts;
        ?>  <?php
        else:
            echo '0';
        ?> <?php
        endif;
        ?></div>
      <button class="filter-title-green btn-filter ssl" type="button" data-target="Active">ACTIVE</button>
</div>
      <div class="filter-box">
      <div class="filter-count-red"><?php
        $args        = array(
            'post_type' => 'services',
            'posts_per_page' => 9999,
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'client',
                    'value' => get_the_id(),
                    'compare' => '='
                ),
                array(
                    'key' => 'type',
                    'value' => 'ssl'
                ),
                array(
                    'key' => 'ssll_status',
                    'value' => 'Not Active',
                    'compare' => '='
                )
            )
        );
        $inner_query = new WP_Query($args);
        ?><?php
        if ($inner_query->have_posts()):
            echo $inner_query->found_posts;
        ?>  <?php
        else:
            echo '0';
        ?> <?php
        endif;
        ?></div>
      <button class="filter-title-red btn-filter ssl" type="button" data-target="Not Active">NOT ACTIVE</button>
</div>
</div>
</div>
<button class="box-title btn-filter ssl" type="button" data-target="all" style="color:#999;float:right;border: none; background-color: #eeeded;">
             <i style="color:#932082; margin-left:10px;" class="fas fa-power-off"></i><span style="font-weight:bold;font-size:14px;"> RESET</span>FILTERS
</button>
                <div class="table-responsive">
                  <table class="table">
                    <tr>                     
                      <th style="width:15%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Domain</strong></th>
                      <th style="width:10%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Cert Type</strong></th>
                      <th style="width:15%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Expiration Date</strong></th>
                      <th style="width:20%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Provider</strong></th>
                      <th style="width:20%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Status</strong></th>
                      <th style="width:20%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">Notes</strong></th>
                      <th style="width:20%;"><strong style="text-transform: uppercase; color: #99999F;  font-size: 17px;">FUNCTIONS</strong></th>
                    </tr>


                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <tr class="filterable ssl" <?php $meta_key = 'ssl_status'; $id = get_the_id();?>data-status="<?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>">                      
                      <td>
                        <?php $meta_key = 'ssl_domain'; $id = get_the_id();?>
                        <a data-title="SSL Domain" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'certificate_type'; $id = get_the_id();?>
                        <a data-title="Certificate Type" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                        <?php $meta_key = 'ssl_expiry'; $id = get_the_id();?>
                        <a data-title="SSL Cert Expire" href="#" id="date" name="<?php echo $meta_key;?>" data-type="date" data-format="dd/mm/yyyy" data-viewformat="dd/mm/yyyy" data-inputclass="date" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                      <?php $meta_key = 'ssl_provider'; $id = get_the_id(); ?><a data-title="SSL Provider" href="#" id="ssl-provider"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Namecheap',text:'Namecheap'},{value:'LCN',text:'LCN'},{value:'Other',text:'Other'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                      </td>
                      <td>
                      <?php $meta_key = 'ssll_status'; $id = get_the_id(); ?><a data-title="SSL Status" href="#" id="ssl-status"
                      name="<?php echo $meta_key;?>" data-type="select" data-value="" data-source="[{value:'Active',text:'Active'},{value:'Not Active',text:'Not Active'},{value:'None',text:'None'}]"
                      data-pk="<?php echo $id;?>" class="text-field">
                      <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></a>
                      </td>
                      <td>
                        <?php $meta_key = 'ssl_notes'; $id = get_the_id();?>
                        <a data-title="SSL Notes" href="#" id="text-field" name="<?php echo $meta_key;?>" data-type="text" data-inputclass="form-control" data-pk="<?php echo $id;?>" class="text-field">
                          <?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?>
                        </a>
                      </td>
                      <td>
                      <i class="far fa-trash-alt"></i>                  
                      </td>
                    </tr>


                    <?php endwhile;
  
  echo '</table></div>'; wp_reset_postdata(); ?><?php /*
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#domainsmodal">
  <span class="glyphicon glyphicon-plus-sign"></span>    Add SSL
</button>

                <!-- Modal -->
                <div class="modal fade" id="domainsmodal" tabindex="-1" role="dialog" aria-labelledby="domainsmodal" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="domainsmodal">Create SSL</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=37]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>*/?>
					  <?php
  
else :

  echo '<p>This Client Has no SSL Certificates</p>'; ?>
					  
					  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sslmodal">
  Add SSL
</button>
<?php /*
                <!-- Modal -->
                <div class="modal fade" id="sslmodal" tabindex="-1" role="dialog" aria-labelledby="domainsmodal" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="domainsmodal">Create SSL</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo do_shortcode("[ninja_form id=37]"); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
  */?>
<?php endif; wp_reset_postdata();?>
                    <!-- Table -->
                
                
            </div>
</div>


                    
            </div>
            </div>
            </div>
            </div>
          </div>
          </div>
        </div>      
     
        </div>
      


        
        <?php get_template_part('helpdesk', 'modal');?>



      



      <?php get_footer(); ?>




