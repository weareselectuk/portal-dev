<?php

/***************
	IS CHILD/ANCESTOR
***************/

// Check if page is direct child
function is_child($page_id) { 
    global $post; 
    if( is_page() && ($post->post_parent == $page_id) ) {
       return true;
    } else { 
       return false; 
    }
}

// Check if page is an ancestor
function is_ancestor($post_id) {
    global $wp_query;
    $ancestors = $wp_query->post->ancestors;
    if ( in_array($post_id, $ancestors) ) {
        return true;
    } else {
        return false;
    }
}

?>