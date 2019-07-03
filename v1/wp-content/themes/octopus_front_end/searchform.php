<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="main-search panel panel-body">
	<div class="form-group has-feedback">
	  <input type="text" class="form-control input-lg search-autocomplete" name="s" placeholder="Search..." <?php if(isset($_GET['s'])) { echo 'value="'.$_GET['s'].'"';} ?>>
	  <div class="form-control-feedback">
	    <i class="icon-search4 text-size-large text-muted"></i>
	  </div>
	</div>
	<?php if(is_404()) : ?>
	<div class="text-center">
	  <a href="<?php echo get_bloginfo('url');?>" class="btn bg-pink-400"><i class="icon-circle-left2 position-left"></i> <?php _e( 'Back to dashboard', 'honeypot' ) ?></a>
	</div>
	<?php endif; ?>
</form>