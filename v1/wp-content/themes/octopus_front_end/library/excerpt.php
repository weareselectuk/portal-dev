<?php

/***************
	CUSTOM EXCERPT LENGTH
***************/

function excerpt($limit) {
    return wp_trim_words(get_the_excerpt(), $limit);
}

function custom_read_more() {
    return '... <a class="read-more" href="'.get_permalink(get_the_ID()).'">more&nbsp;&raquo;</a>';
}

function excerpt_read_more($limit) {
    return wp_trim_words(get_the_excerpt(), $limit, custom_read_more());
}

?>