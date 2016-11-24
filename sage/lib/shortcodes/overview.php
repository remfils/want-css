<?php
function want_overview_shortcode($atts) {
  extract(shortcode_atts(
    array(
      'image' => False,
      'icon' => False,
      'has_icon'=>'',
      'title' =>False,
      'text' =>False,
      'link' =>False

      ),
    $atts
    )
  );
  global $post;
  ob_start(); ?>
	<?php
		$link = vc_build_link($link);
		$hasLink = isset($link) && isset($link['url']);
	?><div class="overview">
    	<?php if($hasLink) { ?><a href="<?php echo $link['url'];?>" target="<?php echo $link['target']; ?>"><?php } ?>
        <img class="overview-image" src="<?php  echo esc_url( home_url( '/' ) ).wp_get_attachment_url( $image ); ?>" alt="" />
        <div class="overview-overlay">
            <div class="overview-info">
                <?php if($has_icon != False){ ?>
                    <img class="overview-icon" src="<?php  echo esc_url( home_url( '/' ) ).wp_get_attachment_url( $icon ); ?>" alt="" />
                <?php } ?>
                <h2 class="overview-title"><?php echo wpb_js_remove_wpautop($title); ?></h2>
                <p class="overview-content"><?php echo wpb_js_remove_wpautop($text); ?></p>
                <span class="overview-link">mehr </span>
            </div>
        </div>
        <?php if($hasLink) { ?></a><?php } ?>
    </div><?php
    return ob_get_clean();
}
add_shortcode('want_overview', 'want_overview_shortcode');
add_action( 'vc_before_init', 'want_add_overview_shortcode' );
function want_add_overview_shortcode(){
    vc_map(
        array(
            "name"=>"Overview",
            "base"=>"want_overview",
            'icon' => 'icon-wpb-row',
            'category' => __( 'Want', 'js_composer' ),
            "js_view" => 'VcRowView',
            "params" =>array(
                array(
                    "type" => "textarea",
                    "heading" => __("Title"),
                    "param_name" => "title"
                ),
                array(
                    "type" => "textarea",
                    "heading" => __("Text"),
                    "param_name" => "text"
                ),
                array(
                    "type" => "vc_link",
                    "heading" => __("Link "),
                    "param_name" => "link"
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "js_composer"),
                    "param_name" => "image"
                    ),
                array(
                    "type" => "checkbox",
                    "heading" => __("Has icon"),
                    "param_name" => "has_icon",
                    'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
                  ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Icon", "js_composer"),
                    "param_name" => "icon",
                    "dependency" => array(
                        "element" => "has_icon",
                        "value" => "yes",
                        "not_empty" => true
                    )
                )
            )
        )
    );
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Want_Overview extends WPBakeryShortCodesContainer {
    }
}
