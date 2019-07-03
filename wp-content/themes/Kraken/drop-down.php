<div class="btn-group btn-group-danger">
	  <button onclick="myFunction()" class="btn btn-danger">
        
        <?php 
        if (isset($_SESSION['selected_client']) && !empty($_SESSION['selected_client'])){
          echo get_the_title($_SESSION['selected_client']);
          
        }
        ?>
       </button>
  
	  <button data-toggle="dropdown" class="btn btn-danger dropdown-toggle" type="button"><span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
		  
		  <li class="divider"></li>
		  <li>

        <?php

          $args = array(
                            'post_type' => 'clients',
                            'posts_per_page' => 99,
                            'orderby' => 'modified',
                            'order' => 'desc'
                          );

          $the_query = new WP_Query( $args );

          if ($the_query->have_posts()) : while ( $the_query->have_posts() ) : $the_query->the_post();
              echo '<a href="'.get_home_url() .'/filters/?client=' . get_the_ID() . '&type=assets&topbar=' . get_the_ID() . '">'.get_the_title().'</a>';
          endwhile; endif;

          wp_reset_postdata();


        ?>
    	  
    </li>
	  </ul>
  </div>