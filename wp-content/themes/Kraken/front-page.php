<?php /*Template Name: front-page*/ get_header(); ?>
	 
     

     <body style="background: url('<?php bloginfo( 'template_url' ); ?>/library/assets/img/bg/<?= rand(1, 10) ?>.png') no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;
  background-size: cover;"> 
			<div class="welcome_panel" style="position: absolute;top: 11%;left: 8%; color:white;text-shadow: 3px 5px 3px black; z-index: -1">
				<div class="panel-heading">
					<h3 class="panel-title" style="font-size:55px;">
						Welcome, <span style="font-weight:bold;"> <?php global $current_user; wp_get_current_user() ; echo ($current_user->user_login); ?>!</span> 
					</h3>
					</div>
				</div>
				<div class="panel-body">
			  <?php 
			  $current_user = wp_get_current_user();
			   $querystr = "
			   SELECT {$wpdb->prefix}wsdesk_tickets.*
			   FROM {$wpdb->prefix}wsdesk_tickets, {$wpdb->prefix}wsdesk_ticketsmeta
			   WHERE {$wpdb->prefix}wsdesk_ticketsmeta.meta_value LIKE '%$current_user->ID%'
			   AND {$wpdb->prefix}wsdesk_ticketsmeta.meta_key = 'ticket_assignee'
			   AND {$wpdb->prefix}wsdesk_ticketsmeta.ticket_id = {$wpdb->prefix}wsdesk_tickets.ticket_id
			   ORDER BY {$wpdb->prefix}wsdesk_tickets.ticket_updated DESC
			   ";
			   $pageposts = $wpdb->get_results($querystr, OBJECT);

			   
				

if ($pageposts) : ?>
<div style="float:right;position:absolute;left:74%;margin-top:6.5%">
				<div style="color:#932082;font-size:17px">TICKETS<span style="font-weight:bold;">OVERVIEW</span></div>
				 <?php foreach ($pageposts as $key => $value) {
					 ?><div style="background-color: #FFF;color:#99999F; height: 30px; border-radius: 3px; padding-top: 4px; padding-left: 26px; width:300px;margin-top:10px"><a href="#helpdesk" style="color:#99999F;" data-toggle="modal" data-target="#ticket_<?php echo $value->ticket_id; 
					 ?>"> <?php echo $value->ticket_title; 
					 ?></a></div> <div class="modalsloader"><?php
                     include get_template_directory() . '/helpdesk-modal.php'; ?></div> 
                     
					 <?php }; ?>
				 </div>
	
				 
			   
				
				 
				 <?php else : ?>
				   
				<?php endif; ?>
			   
			   
			   

		
        </div>
				
			
			

          


        </div>
        <!-- /content area -->

        


<?php get_footer(); ?>
</body>