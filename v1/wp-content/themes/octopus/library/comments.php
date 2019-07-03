<?php

/************* COMMENT LAYOUT *********************/
		
// Comment Layout
function bones_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class('twelve columns'); ?>>
		<article id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard row clearfix">
				<div class="avatar two columns">
					<?php echo get_avatar($comment,$size='75' ); ?>
				</div>
				<div class="ten columns">
					<?php printf(__('<h4>%s</h4>'), get_comment_author_link()) ?>
					<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time('F jS, Y'); ?> </a></time>
					
					<?php edit_comment_link(__('Edit'),'<span class="edit-comment button radius small blue nice">','</span>') ?>
                    
                    <?php if ($comment->comment_approved == '0') : ?>
       					<div class="alert-box success">
          					<?php _e('Your comment is awaiting moderation.') ?>
          				</div>
					<?php endif; ?>
                    
                    <?php comment_text() ?>
                    
                    <!-- removing reply link on each comment since we're not nesting them -->
					<?php //comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                </div>
			</div>
		</article>
    <!-- </li> is added by wordpress automatically -->
<?php
} // don't remove this bracket!

?>