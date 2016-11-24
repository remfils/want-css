<?php
function want_video_shortcode($atts) {
    extract(shortcode_atts(
        array(
            'poster'			=> False,
            'mp4_url'			=> False,
            'webm_url'			=> False,
            'ogg_url'			=> False,
            'controls'          => False
        ),$atts)
    );
    $poster     = get_want_url(wp_get_attachment_url( $poster ));
	$mp4 	    = get_want_url($mp4_url);
	$webm 	= get_want_url($webm_url);
	$ogg 	= get_want_url($ogg_url);

    $id = uniqid();
    ob_start(); ?>
    <video id="want-video-<?php echo $id; ?>" class="want-video video-js vjs-default-skin" width="100%" height="100%" muted preload controls data-setup="{}"
        <?php if($poster){ ?> poster="<?php echo $poster; ?>"<?php } ?>>
        <?php if($mp4){ ?><source src="<?php echo $mp4; ?>" type="video/mp4"/><?php } ?>
        <?php if($webm){ ?><source src="<?php echo $webm; ?>" type="video/webm"/><?php } ?>
        <?php if($ogg){ ?><source src="<?php echo $ogg; ?>" type="video/ogg"/><?php } ?>

    </video>
    <div class="want-video-ovrl"></div>
    <div class="want-video-close"></div>
    <script type="text/javascript" charset="utf-8">
        jQuery(function(){
            var id = 'want-video-<?php echo $id?>';
            jQuery('#'+id+'+.want-video-ovrl,#'+id+'~.want-video-close').on('click',function(){
                var p = videojs(id).pause().currentTime(0).removeClass('vjs-has-started').one('play',function(){
                    p.addClass('vjs-has-started');
                });
            });
        });

    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('want_video', 'want_video_shortcode');
add_action( 'vc_before_init', 'want_add_video_shortcode' );

function want_add_video_shortcode(){
    vc_map(
        array(
            'name'      => 'Video',
            'base'      => 'want_video',
            'icon'      => 'icon-wpb-film-youtube',
            'category'  => __( 'Want', 'js_composer' ),
            'params'    => array(
                array(
                    'type' 			=> 'attach_image',
                    'heading' 		=> __('Video Poster Image'),
                    'param_name' 	=> 'poster',
                ),
                array(
					'type'			=> 'textfield',
					'holder' 		=> 'div',
					'heading' 		=> __('Video *.mp4 URL'),
					'param_name' 	=> 'mp4_url'
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> __('Video *.webm URL'),
					'param_name' 	=> 'webm_url',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> __('Video *.ogg URL'),
					'param_name' 	=> 'ogg_url'
				),
            )
        )
    );
}
