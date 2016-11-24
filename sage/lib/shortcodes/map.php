<?php
function want_map_shortcode($atts) {
	extract(shortcode_atts(
		array(
			'latitude'=> False,
			'longitude'=> False,
			),
		$atts)
	);

	$uid = "mapdiv-".uniqid();
	ob_start();
	?>
	<div data-map-id="<?php echo $uid;?>" class="map">
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<div class="map-canvas" id="map-<?php echo $uid?>"></div>
		<script type="text/javascript">
			function init_map(){
				var opts = {
					zoom:19,
					overviewMapControl :true,
					streetViewControl:true,
					center:new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>),
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				map = new google.maps.Map(document.getElementById("map-<?php echo $uid;?>"), opts);
				marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>)});
			}
			if(google){ google.maps.event.addDomListener(window, 'load', init_map);}
		</script>
  	</div>
  	<?php
  	return ob_get_clean();
}

add_shortcode('want_map', 'want_map_shortcode');
add_action( 'vc_before_init', 'want_add_map_shortcode' );
function want_add_map_shortcode(){
	vc_map(
		array(
			"name"=>"Map",
			"base"=>"want_map",
			'icon' => 'icon-wpb-map-pin',
			'category' => __( 'Want', 'js_composer' ),
			"js_view" => 'VcColumnView',
			"params" =>array(
				array(
					"type" => "textfield",
					"heading" => __("Latitude: "),
					"param_name" => "latitude"
				),
				array(
					"type" => "textfield",
					"heading" => __("Longitude: "),
					"param_name" => "longitude"
				),
			)
		)
	);
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Want_Map extends WPBakeryShortCodesContainer {
	}
}
