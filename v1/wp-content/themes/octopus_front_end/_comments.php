<?php
/*
The comments page for Bones
*/

// Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

  if ( post_password_required() ) { ?>
  	<div class="alert-box">
    	This post is password protected. Enter the password to view comments.
  	</div>
  <?php
    return;
  }
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	
	<h4 id="comments"><?php comments_number('<span>No</span> Responses', '<span>One</span> Response', '<span>%</span> Responses' );?></h4>
	
	<ol class="commentlist row">
		<?php wp_list_comments('type=comment&callback=bones_comments'); ?>
	</ol>
  
	<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
    	<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed 
	?>

	<?php endif; ?>

<?php endif; ?>


<?php if ( comments_open() ) : ?>

<section id="respond" class="respond-form">

	<h5 id="comment-form-title"><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h5>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
  	<div class="alert-box alert">
  		<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
  	</div>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

	<?php if ( is_user_logged_in() ) : ?>

	<div class="alert-box secondary">
  		Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a>
  	</div>

	<?php else : ?>


	<div class="row">
		<div class="large-6 medium-6 small-12 columns">
			<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" placeholder="Your Name<?php if ($req) echo " (required)"; ?>" tabindex="1" />
		</div>
		<div class="large-6 medium-6 small-12 columns">
		 	<input type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="Your Email Address<?php if ($req) echo " (required)"; ?>" tabindex="2" />
		</div>
	</div>

	<input type="url" class="input-text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" placeholder="Your Website" tabindex="3" />

	<?php endif; ?>
	
	<textarea name="comment" id="comment" placeholder="Your Comment Here..."></textarea>
	
    <input class="button medium radius blue nice" name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
    <?php comment_id_fields(); ?>
	
	<?php do_action('comment_form', $post->ID); ?>
	
	</form>
	
	<?php endif; // If registration required and not logged in ?>
</section>

<?php endif; // if you delete this the sky will fall on your head ?>
