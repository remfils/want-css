<?php
function want_arrow_shortcode($atts,$content=null) {
	extract(shortcode_atts(
		array(
			'background_color'=>False,
			'scroll_reverse'=>False,
			'scroll_target'=>False
			),
		$atts)
	);

	$content = isset($content)?wpb_js_remove_wpautop($content):false;
	$arrow_id = "arrow-id-".uniqid();
	ob_start();

	?>

	<div data-arrow-id="<?php echo $arrow_id;?>" class="arrow-div-wrapper">
		<a class="scroll-arrow <?php if($scroll_reverse != False){ ?> reverse-arrow <?php } ?>" href="#"></a>
	</div>
	<style>
		[data-arrow-id="<?php echo $arrow_id?>"] .scroll-arrow{
			border-left:4px solid <?php echo $background_color;?> !important;
			border-bottom:4px solid <?php echo $background_color;?> !important;
		}
	</style>
	<script type="text/javascript">
		(function($){
			$(function(){
				$("[data-arrow-id='<?php echo $arrow_id;?>']")
				.on("click touchstart",".scroll-arrow",function(e) {
					e.preventDefault();
					$('html, body').animate({
						scrollTop: $("<?php echo $scroll_target; ?>").offset().top
					}, 1200);
				});
			})
		})(jQuery)
	</script>
	<?php
	return ob_get_clean();
}

add_shortcode('want_arrow', 'want_arrow_shortcode');
add_action( 'vc_before_init', 'want_add_arrow_shortcode' );
function want_add_arrow_shortcode(){
	vc_map(
		array(
			"name"=>"Arrow",
			"base"=>"want_arrow",
			'icon' => 'icon-wpb-arrow',
			'category' => __( 'Want', 'js_composer' ),
			'content_element' => true,
			"as_parent"=>array('except'=>"vc_posts_grid"),
			"controls"=>'full',
			"js_view" => 'VcColumnView',
			"params" =>array(
			array(
				"type" => "textfield",
				"heading" => __("Background color: "),
				"param_name" => "background_color"
				),
				array(
				"type" => "checkbox",
				"heading" => __("Reverse Arrow: "),
				"param_name" => "scroll_reverse",
				'value' => array( __( 'Yes', 'js_composer' ) => true )
				),
			array(
				"type" => "textfield",
				"heading" => __("Scroll Target: "),
				"param_name" => "scroll_target"
				)
			)
		)
	);
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Want_Arrow extends WPBakeryShortCodesContainer {
	}
}
