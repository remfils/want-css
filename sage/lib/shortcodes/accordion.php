<?php
//Accordion Item Shortcode
function want_accordion_item_shortcode($atts,$content){
	extract(shortcode_atts(
			array(
				'title' 	=> false,
				'subtitle' 	=> false,
				'text' 		=> false
			),$atts
		)
	);
	ob_start();
	$id = uniqid();
	?>
	<div class="want-accordion-item<?php if(!$subtitle){ ?> no-subtitle<?php } ?>">
		<input class="want-accordion-input" id="accordion-<?php echo $id;?>" type="checkbox" name="accordion" value="accordion"/>
		<label for="accordion-<?php echo $id;?>" class="want-accordion-header">
			<div class="want-accordion-title"><?php echo wpb_js_remove_wpautop($title); ?></div>
			<?php if($subtitle) { ?><div class="want-accordion-subtitle"><?php echo wpb_js_remove_wpautop($subtitle); ?></div><?php } ?>
			<div class="want-accordion-arrow"></div>
		</label>
		<div class="want-accordion-content"><?php echo wpb_js_remove_wpautop($content); ?></div>
	</div>
	<?php
	return ob_get_clean();

}
add_shortcode('want_accordion_item', 'want_accordion_item_shortcode');

//Accordion Shortcode
function want_accordion_shortcode($atts,$content=null){
	extract(shortcode_atts(
			array(
				'title'=>''
			),$atts
		)
	);
	$content 	= isset($content)?wpb_js_remove_wpautop($content):false;
	ob_start();?>
	<div class="want-accordion">
		<div class="want-accordion-container container"><?php echo $content;?></div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('want_accordion', 'want_accordion_shortcode');


function want_add_accordion_shortcode(){
	//Accordion Item
	vc_map(
		array(
			'name' 				=> 'Accordion Item',
			'base' 				=> 'want_accordion_item',
			'icon' 				=> 'icon-wpb-single-image',
			'category'		 	=> __( 'Want', 'js_composer' ),
			'content_element' 	=> true,
			'as_child' 			=> array('only' => 'want_accordion'),
			'params'			=> array(
				array(
					'type' 			=> 'textarea',
					'heading' 		=> __('Title'),
					'param_name' 	=> 'title',
					'value' 		=>  'Title'
				),
				array(
					'type' 			=> 'textarea',
					'heading' 		=> __('Subtitle'),
					'param_name' 	=> 'subtitle',
					'value' 		=>  'Subtitle'
				),
				array(
					'type' 			=> 'textarea_html',
					'heading' 		=> __('Content'),
					'param_name' 	=> 'content',
					'value' 		=>  'Content'
				),
			)
		)
	);
	//Accordion
	vc_map(
		array(
			'name' 						=> 'Accordion',
			'base' 						=> 'want_accordion',
			'icon' 						=> 'icon-wpb-single-image',
			'category'		 			=> __( 'Want', 'js_composer' ),
			'show_settings_on_create' 	=> false,
			'content_element' 			=> true,
			'as_parent'					=> array('only'=>'want_accordion_item'),
			'js_view' 					=> 'VcColumnView',
			'params'					=> array(

			)
		)
	);
}
add_action( 'vc_before_init', 'want_add_accordion_shortcode' );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Want_Accordion extends WPBakeryShortCodesContainer {
	}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Want_Accordion_Item extends WPBakeryShortCode {
    }
}
