<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Config;

/**
 * Add <body> classes
 */
function body_class($classes) {
    // Add page slug if it doesn't exist
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    // Add class if sidebar is active
    if (Config\display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

function sage_wrap_base_cpts($templates) {
    global $post;
    $post_obj = get_post($post);
    $slug = $post_obj->post_name;
    $type = $post_obj->post_type;
    if($slug == 'launchpage'){
        array_unshift($templates, 'base-launchpage.php');
    }
    if($slug == 'home' || $type == 'reference' || $slug == 'agentur'
    	|| $slug == 'arbeiten' || $slug == 'empathie'
    	|| $slug == 'kontakt' || $slug == 'jobs'
    	|| $type=="news"
    	|| $slug =="playground"
    	){
        array_unshift($templates, 'base-want.php');
    }
    return $templates; // Return our modified array with base-$cpt.php at the front of the queue
}
add_filter('sage/wrap_base', __NAMESPACE__ . '\\sage_wrap_base_cpts'); // Add our function to the sage_wrap_base filter
