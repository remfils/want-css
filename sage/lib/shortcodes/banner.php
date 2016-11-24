<?php
function get_want_url($url){
	if($url) {
		return esc_url(home_url('/')). preg_replace('{^/}','',$url);
	}else{
		return false;
	}
}

function want_banner_video($id,$mp4,$webm,$ogg,$poster){
	$poster = get_want_url(wp_get_attachment_url( $poster ));
	$mp4 	= get_want_url($mp4);
	$webm 	= get_want_url($webm);
	$ogg 	= get_want_url($ogg);
	ob_start(); ?>
		<video id="banner-video-<?php echo $id; ?>" class="banner-video video-js vjs-default-skin WHAT" width="100%" height="100%" muted preload autoplay data-setup='{"loop":true}'
		 	<?php if($poster){ ?> poster="<?php echo $poster; ?>"<?php } ?> >
			<?php if($mp4){ ?><source src="<?php echo $mp4; ?>" type="video/mp4"/><?php } ?>
			<?php if($webm){ ?><source src="<?php echo $webm; ?>" type="video/webm"/><?php } ?>
			<?php if($ogg){ ?><source src="<?php echo $ogg; ?>" type="video/ogg"/><?php } ?>
		</video>
	<?php
	return ob_get_clean();
}

function want_banner_image($url){
	$url = get_want_url(wp_get_attachment_url( $url ));
	if(!$url){return '';}
	ob_start(); ?>
	<img class="banner-image" src="<?php echo $url?>" alt="WANT Banner" />
	<?php
	return ob_get_clean();
}
function want_banner_bg_position($id,$pos){
	ob_start();
	?>
	<style>
		#<?php echo $id; ?> .banner-video .vjs-tech,
		#<?php echo $id; ?> .banner-image
		{
			-moz-object-position: <?php echo $pos ?>;
			-webkit-object-position: <?php echo $pos ?>;
			object-position: <?php echo $pos ?>;
		}
	</style>
	<?php
	return ob_get_clean();
}

function want_banner_overlay($id,$bg,$alpha){
	ob_start();
	?>
	<style>
		#<?php echo $id; ?> .banner-bg:after{
			background-color:<?php echo $bg;?>;opacity: <?php echo $alpha; ?>;content:"";
		}
	</style>
	<?php
	return ob_get_clean();
}

function want_banner_arrow($type,$tg,$animated,$speed,$color){
	?>
	<a class="banner-arrow<?php echo $type=='reverse'?' '.$type:''; ?><?php echo ($type=='normal' && $animated) ?' animated':''; ?>" data-target="<?php echo $tg; ?>"
		data-speed="<?php echo $speed;?>" style="border-color:<?php echo $color;?>;" href="#"></a>
	<?php
}


function want_banner_shortcode($atts,$content=null) {
	extract(shortcode_atts(
		array(
			'bg_type'			=> 'image',
			'poster'			=> False,
			'mp4_url'			=> False,
			'webm_url'			=> False,
			'ogg_url'			=> False,
			'volume_ctrl'		=> False,
			'volume'			=> 50,
			'bg_image'			=> False,
			'bg_pos'			=> 'center center',
			'bg_ovrl'			=> False,
			'bg_ovr_color'		=> '#d8d8d8',
			'bg_ovrl_opacity'	=> 0.6,
			'width'				=> '',
			'height'			=> 'bg',
			'custom_height'		=> '100vh',
			'valign'			=> False,
			'arrow'				=> False,
			'arrow_tg'			=> 'footer',
			'arrow_speed'		=> 1200,
			'arrow_color'		=> '#fff',
			'arrow_anim'		=> False,
			'parallax'			=> False
			),
		$atts)
	);

	$content 	= isset($content)?wpb_js_remove_wpautop($content):false;
	$uid 		= uniqid();
	$buid 		= 'banner-'.$uid;
	ob_start(); ?>
	<script type="text/javascript">
		(function($){ $(function(){ window['Banner']?Banner($('#<?php echo $buid;?>')):false;});})(jQuery);
	</script>
	<?php echo want_banner_bg_position($buid,$bg_pos); ?>
	<?php if($bg_ovrl){ echo want_banner_overlay($buid,$bg_ovr_color,$bg_ovrl_opacity); }?>
	<div class="banner" id="<?php echo $buid;?>" data-id="<?php echo $uid; ?>"
		data-valign="<?php echo $valign; ?>" data-height="<?php echo $height;?>"
		data-bg-type="<?php echo $bg_type; ?>"
		<?php if($parallax){?>data-parallax="1"<?php }?>
		>
		<div class="banner-bg" <?php if($height=='custom'){ ?>style="height:<?php echo $custom_height;?>"<?php }?> >
			<?php
				if($bg_type == 'video'){
					echo want_banner_video($uid,$mp4_url,$webm_url,$ogg_url,$poster);
				}else if ($bg_type == 'image'){
					echo want_banner_image($bg_image);
				}
			?>
		</div>
		<div class="banner-container"><!--
		--><div class="banner-content <?php echo $width;?>"> <?php echo $content; ?></div><!--
		--></div>
		<?php if($bg_type == 'video' && $volume_ctrl) { ?>
			<div class="banner-volume">
				<span class="banner-volume-on">on</span>
				<input type="range" min="0" max="100" name="volume" data-orientation="vertical" value="<?php echo $volume?>"/>
				<span class="banner-volume-off">off</span>
			</div>
		<?php } ?>
		<?php if($arrow){ echo want_banner_arrow($arrow,$arrow_tg,$arrow_anim,$arrow_speed,$arrow_color); } ?>
	</div><?php
	return ob_get_clean();
}

add_shortcode('want_banner', 'want_banner_shortcode');
add_action( 'vc_before_init', 'want_add_banner_shortcode' );
function want_add_banner_shortcode(){
	$on_video = array(
		"element" => "bg_type",
		"value" => "video"
	);
	$on_image = array(
		"element" => "bg_type",
		"value" => "image"
	);
	vc_map(
		array(
			"name"				=> "Banner",
			"base"				=> "want_banner",
			'icon' 				=> 'icon-wpb-single-image',
			'category'		 	=> __( 'Want', 'js_composer' ),
			'content_element' 	=> true,
			"as_parent"			=> array('except'=>"vc_posts_grid"),
			"js_view" 			=> 'VcColumnView',
			"params" 			=> array(
				//Background
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __("Background Type"),
					"param_name" 	=> "bg_type",
					"value" 		=> array(
						'Image'   	=> 'image',
						'Video'   	=> 'video',
					),
					"group"			=> 'Background'
				),
				array(
					"type" 			=> "attach_image",
					"heading" 		=> __("Video Poster Image"),
					"param_name" 	=> "poster",
					"dependency" 	=> $on_video,
					"group"			=> 'Background'
				),
				array(
					"type"			=> "textfield",
					"holder" 		=> "div",
					"heading" 		=> __("Video *.mp4 URL"),
					"param_name" 	=> "mp4_url",
					"dependency" 	=> $on_video,
					"group"			=>'Background'
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Video *.webm URL"),
					"param_name" 	=> "webm_url",
					"dependency" 	=> $on_video,
					"group"			=>'Background'
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Video *.ogg URL"),
					"param_name" 	=> "ogg_url",
					"dependency" 	=> $on_video,
					"group"			=> 'Background'
				),
				array(
					"type" 			=> "checkbox",
					"heading" 		=> __("Show Video Volume Control ?"),
					"param_name" 	=> "volume_ctrl",
					'value' 		=> array( __( 'Yes', 'js_composer' ) => 'yes' ),
					"dependency" 	=> $on_video,
					"group" 		=> "Background"
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Initial Video volume"),
					"param_name" 	=> "volume",
					'value'			=> '50',
					"dependency" 	=> array(
						"element"	=> 'volume_ctrl',
						"value"		=> 'yes'
					),
					"group" 		=> "Background"
				),
				array(
					"type" 			=> "attach_image",
					"heading" 		=> __("Background Image"),
					"param_name" 	=> "bg_image",
					"dependency" 	=> $on_image,
					"group"			=> 'Background'
				),
				array(
					"type" 			=> "dropdown",
					"heading"		=>  __("Background Position"),
					"param_name"	=> "bg_pos",
					"value"			=> array(
						"center center" 	=> "center center",
						"left top" 			=> "left top",
						"left center" 		=> "left center",
						"left bottom" 		=> "left bottom",
						"right top" 		=> "right top",
						"right center" 		=> "right center",
						"right bottom" 		=> "right bottom",
						"center top"	 	=> "center top",
						"center bottom" 	=> "center bottom",
					),
					"group"			=> "Background"
				),
				array(
					"type" 			=> "checkbox",
					"heading" 		=> __("Background Overlay?"),
					"param_name" 	=> "bg_ovrl",
					'value' => array( __( 'Yes', 'js_composer' ) => 'yes' ),
					"group" 		=> "Background"
				),
				array(
					"type" 			=> "colorpicker",
					"heading" 		=> __("Background Overlay Color"),
					"param_name" 	=> "bg_ovr_color",
					"value"			=> "#d8d8d8",
					"dependency"	=>array(
						"element" 	=> "bg_ovrl",
						"value" 	=> "yes"
					),
					"group"			=> "Background"
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Background Overlay Opacity"),
					"param_name" 	=> "bg_ovrl_opacity",
					"value"			=> "0.6",
					"dependency"	=>array(
						"element" 	=> "bg_ovrl",
						"value" 	=> "yes"
					),
					"group"			=> "Background"
				),

				//Sizing & Content
				array(
					"type"			=> 'dropdown',
					"heading"		=> __('Width'),
					"param_name"	=> 'width',
					"value"			=> array(
						"Full Width"	=> "",
						"Grid width"	=> 'container',
					),
					"group"			=> "Sizing & Content"
				),
				array(
					"type" 			=> "dropdown",
					"heading"		=> __("Height"),
					"param_name"	=> 'height',
					"value"			=> array(
						"Background Height"		=>'bg',
						"Browser Height" 		=>'full',
						"Content Height" 		=>'content',
						__("Custom")			=>'custom'
					),
					"group" 		=> "Sizing & Content"
				),
				array(
					"type" 			=> "textfield",
					"heading"		=> __("Custom Height"),
					"param_name"	=> 'custom_height',
					"value"			=> '100vh',
					"dependency" 	=> array(
						"element" 	=> "height",
						"value" 	=> "custom"
					),
					"group" 		=> "Sizing & Content"
				),
				//Arrow
				array(
					"type" 			=> "dropdown",
					"heading"		=> __("Content Vertical Align"),
					"param_name"	=> 'valign',
					"value"			=> array(
						"Top"			=>'',
						"Middle" 		=>'middle',
						"Bottom" 		=>'bottom',
					),
					"dependency"	=>array(
						"element" 	=> "height",
						"value" 	=> array("bg","full","custom")
					),
					"group" 		=> "Sizing & Content"
				),
				array(
					"type" 			=> "dropdown",
					"heading"		=> __("Arrow"),
					"param_name"	=> 'arrow',
					"value"			=> array(
						"None"			=>'',
						"Normal" 		=>'normal',
						"Reverse" 		=>'reverse',
					),
					"group" 		=> "Arrow"
				),
				array(
					"type" 			=> "textfield",
					"heading"		=> __("Arrow Scroll Target"),
					"param_name" 	=> "arrow_tg",
					"value"			=> 'footer',
					"dependency" 	=> array(
						"element"	 => "arrow",
						"value" 	=> array("normal","reverse"),
					),
					"group" 		=> "Arrow"
				),
				array(
					"type" 			=> "textfield",
					"heading"		=> __("Arrow Scroll Speed"),
					"param_name" 	=> "arrow_speed",
					"value"			=> '1200',
					"dependency" 	=> array(
						"element"	 => "arrow",
						"value" 	=> array("normal","reverse"),
					),
					"group" 		=> "Arrow"
				),
				array(
					"type" 			=> "checkbox",
					"heading" 		=> __("Animate Arrow"),
					"param_name" 	=> "arrow_anim",
					"dependency" 	=> array(
						"element"	=> "arrow",
						"value" 	=> array("normal"),
					),
					'value' => array( __( 'Yes', 'js_composer' ) => 'yes' ),
					"group" 		=> "Arrow"
				),
				array(
					"type" 			=> "colorpicker",
					"heading" 		=> __("Arrow Color"),
					"param_name" 	=> "arrow_color",
					"dependency" 	=> array(
						"element"	=> "arrow",
						"value" 	=> array("normal","reverse"),
					),
					'value' => array( __( 'Yes', 'js_composer' ) => 'yes' ),
					"group" 		=> "Arrow"
				),

				//Animation
				array(
					"type" 			=> "checkbox",
					"heading" 		=> __("Parallax Scroll Animation?"),
					"param_name" 	=> "parallax",
					'value' => array( __( 'Yes', 'js_composer' ) => 'yes' ),
					"group"			=> "Animation"
				),
			)
		)
	);
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Want_Banner extends WPBakeryShortCodesContainer {
	}
}
