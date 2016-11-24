<?php
function want_slider_shortcode($atts,$content=null) {
	extract(shortcode_atts(
		array(
			'query'=>'post_type=teaser',
			'teaser_color_background'=>'#f0f0f0',
			'teaser_slides_show'=>'',
			'teaser_slides_scroll'=>'',
		),
		$atts)
	);
	ob_start();

	$content = isset($content)?wpb_js_remove_wpautop($content):false;
	?>
<section class="container-slider" style="background-color: <?php echo $teaser_color_background ?>">
	<div class="container slider">
		<?php echo $content; ?>
	</div>
</section>
	<script type="text/javascript">
		(function($){
			$(function(){
				if(!$.fn.slick) return
				$('.slider').slick({
					dots: false, // remove bullets
					infinite: true,
					speed: 600,
					slidesToShow: <?php echo $teaser_slides_show ?>,
					slidesToScroll: <?php echo $teaser_slides_scroll ?>,
					responsive: [
					{
						breakpoint: 1024,
						settings: {
						slidesToShow: 2,
						slidesToScroll: 2,
					}
					},
					{
						breakpoint: 768,
						settings: {
						slidesToShow: 1,
						slidesToScroll: 1
						}
					}
					// You can unslick at a given breakpoint now by adding:
					// settings: "unslick"
					// instead of a settings object
					]
				});
			})
		})(jQuery);

	</script>
<?php return ob_get_clean();
} // Teaser template shortcode
add_shortcode ( 'want_slider', 'want_slider_shortcode');

add_action( 'vc_before_init', 'want_add_teaser_shortcode' );
function want_add_teaser_shortcode() {
	vc_map( array(
		"name" => "Slider",
		"base" => "want_slider",
		"category" => "Want",
		"description" => "Slick slider",
		'content_element' => true,
			"as_parent"=>array('only'=>"want_overview"),
			"controls"=>'full',
			"js_view" => 'VcColumnView',
		'icon' => 'icon-wpb-slideshow',
		"params" => array(
			array(
				"type" => "colorpicker",
				"heading" => __("Color background", "js_composer"),
				"param_name" => "teaser_color_background",
				"value" => "#f0f0f0",
				"description" => __( "Set background color for teaser", 'my-text-domain' ),
			),
			array(
				"type" => "dropdown",
				"heading" => __("Teaser slide to show", "js_composer"),
				"param_name" => "teaser_slides_show",
				"value" => array(
						'1'=>'1',
						'2'=>'2',
						'3'=>'3',
						'4'=>'4',
					),
				"description" => __( "Number of article for view", 'my-text-domain' ),
			),
			array(
				"type" => "dropdown",
				"heading" => __("Teaser slide to scroll", "js_composer"),
				"param_name" => "teaser_slides_scroll",
				"value" => array(
						'1'=>'1',
						'2'=>'2',
						'3'=>'3',
						'4'=>'4',
					),
				"description" => __( "Number of article for scroll", 'my-text-domain' ),
			),
		),
	) );
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_want_slider extends WPBakeryShortCodesContainer {
	}
}

?>
