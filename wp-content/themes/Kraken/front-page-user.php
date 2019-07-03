<?php /* Template Name: Front-Page-User */ ?>
<?php get_header('front-end-user'); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>


	
	 <?php endwhile; else : ?>
	 
     

     <body style="background: url('<?php bloginfo( 'template_url' ); ?>/library/assets/img/bg/<?= rand(1, 13) ?>.png') no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;
  background-size: cover;"> 
			<div class="welcome_panel" style="position: absolute;top: 55%;left: 20%; color:white;text-shadow: 3px 5px 3px black;">
				<div class="panel-heading">
					<h3 class="panel-title" style="font-size:65px;"><strong><script type="text/javascript">
var JST = new Date('<?php date_default_timezone_set('Europe/London'); echo date("d M Y H:i:s") ?>');
setInterval(UpdateClock, 1000);

function UpdateClock()
{
	JST.setTime(JST.valueOf() + 1000); // advance the time
	document.getElementById('clock').innerHTML = JST.toLocaleString(); // update display
}
</script>
<div id="clock"></div></strong>
						Welcome, <?php global $current_user; get_currentuserinfo(); echo ($current_user->user_login); ?>! 
					</h3>
				</div>
				<div class="panel-body">
                <div id="rssincl-box-container-1179194"></div>
                <script type="text/javascript" src="https://www.brainyquote.com/link/quotebr.js"></script>
                

		
        </div>
				
			</div>
			

          <?php get_template_part('footer', 'simple');?>


        
        <!-- /content area -->

          
    <?php endif; ?>


<?php get_footer(); ?>
</body>