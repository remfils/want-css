<?php
$shortcodes = array(
	'video.php',	 //Video
	'banner.php', //Banner
	'accordion.php', //Accordion
	'map.php', //Map
	'arrow.php', //arrow
	'overview.php', //overview
	'slider.php', // slider(slick slider)
	'member.php', //team member
	'email.php'
);
foreach ($shortcodes as $file) {
	require_once dirname(__FILE__).'/'.$file;
}
