<?php
function want_team_member_shortcode($atts) {
	extract(shortcode_atts(
		array(
			'image' 	  => False,
			'hover_image' => False,
			'name' 	 	  => False,
			'position'	  => False
		),$atts)
	);
	$hover_image = $hover_image?$hover_image: $image;
	global $post;
	ob_start(); ?>
	<div class="team-member">
		<div class="team-member-images">
			<img class="team-member-image" src="<?php  echo esc_url( home_url( '/' ) ).wp_get_attachment_url( $image ,array(300,300)); ?>" alt="<?php echo $name;?>"/>
			<img class="team-member-image-hover" src="<?php  echo esc_url( home_url( '/' ) ).wp_get_attachment_url( $hover_image ); ?>" alt="<?php echo $name;?>" />
		</div>
		<div class="team-member-info">
			<div class="team-member-name"><?php echo wpb_js_remove_wpautop($name); ?></div>
			<div class="team-member-position"><?php echo wpb_js_remove_wpautop($position); ?></div>
		</div>
	</div><?php return ob_get_clean();
}
add_shortcode('want_team_member', 'want_team_member_shortcode');
add_action( 'vc_before_init', 'want_add_member_shortcode');

function want_add_member_shortcode(){
	vc_map(
		array(
			"name"=>"Team Member",
			"base"=>"want_team_member",
			'icon' => 'icon-wpb-call-to-action',
			'category' => __( 'Want', 'js_composer' ),
			"js_view" => 'VcRowView',
			"params" =>array(
				array(
					"type" => "attach_image",
					"heading" => __("Image", "js_composer"),
					"param_name" => "image"
				),
				array(
					"type" => "attach_image",
					"heading" => __("Hover Image", "js_composer"),
					"param_name" => "hover_image"
				),
				array(
					"type" => "textarea",
					"heading" => __("Name"),
					"param_name" => "name"
				),
				array(
					"type" => "textarea",
					"heading" => __("Position"),
					"param_name" => "position"
				)
			)
		)
	);
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Want_Team_Member extends WPBakeryShortCodesContainer {

	}
}
