<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
	'lib/utils.php',                 // Utility functions
	'lib/init.php',                  // Initial theme setup and constants
	'lib/wrapper.php',               // Theme wrapper class
	'lib/conditional-tag-check.php', // ConditionalTagCheck class
	'lib/config.php',                // Configuration
	'lib/assets.php',                // Scripts and stylesheets
	'lib/titles.php',                // Page titles
	'lib/extras.php',                // Custom functions
	'lib/shortcodes/index.php',       //Want modules
	'lib/types.php',
	'lib/comments.php',
	'lib/options.php',
	'lib/simple_html_dom.php'
];

foreach ($sage_includes as $file) {
	if (!$filepath = locate_template($file)) {
		trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
	}
	require_once $filepath;
}
unset($file, $filepath);

function image_to_relative($html, $id, $caption, $title, $align, $url, $size, $alt) {
	$sp = strpos($html,"src=") + 5;
	$ep = strpos($html,"\"",$sp);

	$imageurl = substr($html,$sp,$ep-$sp);

	$relativeurl = str_replace("http://","",$imageurl);
	$sp = strpos($relativeurl,"/");
	$relativeurl = substr($relativeurl,$sp);

	$html = str_replace($imageurl,$relativeurl,$html);

	return $html;
}
add_filter('image_send_to_editor', 'image_to_relative', 5, 8);

/* remfils edits */

add_filter( 'vc_grid_item_shortcodes', 'my_module_add_grid_shortcodes' );
function my_module_add_grid_shortcodes( $shortcodes ) {
   $shortcodes['vc_say_hello'] = array(
     'name' => __( 'Say Hello', 'my-text-domain' ),
     'base' => 'vc_say_hello',
     'category' => __( 'Content', 'my-text-domain' ),
     'description' => __( 'Just outputs Hello World', 'my-text-domain' ),
     'post_type' => Vc_Grid_Item_Editor::postType(),
  );

   $shortcodes['vc_shorted_excerpt'] = array(
     'name' => __( 'Shorted Excerpt', 'my-text-domain' ),
     'base' => 'vc_shorted_excerpt',
     'category' => __( 'Content', 'my-text-domain' ),
     'description' => __( 'Just outputs Hello World', 'my-text-domain' ),
     'post_type' => Vc_Grid_Item_Editor::postType(),
  );
   return $shortcodes;
}
 
add_shortcode( 'vc_say_hello', 'vc_say_hello_render' );
function vc_say_hello_render($atts) {
    return "<div class='bild-wrapper'>" . apply_filters('excerpt_more', '{{post_data:post_date_gmt}}') . " Unhr</div>";
}
 
add_shortcode( 'vc_shorted_excerpt', 'vc_shorted_excerpt_render' );
function vc_shorted_excerpt_render($atts) {
    return "<div class='bild-wrapper'>" . apply_filters('excerpt_more', '{{post_data:post_excerpt}}') . " Unhr</div>";
}


/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function wpdocs_excerpt_more( $more ) {
    if (str_word_count($more, 0) > 20) {
        $words = str_word_count($more, 2);
        $pos = array_keys($words);
        $more = substr($more, 0, $pos[$limit]) . '...';
    }
    return $more;
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );