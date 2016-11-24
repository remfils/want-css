<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class('single news'); ?>>
		<?php
			$stretch = get_field("news_header_full_width");

			$klasses = array();
			if($stretch){$klasses[]='full-width';}
			if(!has_post_thumbnail()){$klasses[]='empty';}
			$klasses = implode(" ",$klasses);

			$style = '';
			$bg_color 	= get_field('news_header_background_color');
			$bg_image 	= get_field('news_header_background_image');
			$bg_repeat 	= get_field("news_header_background_image_repeat");
			$bg_pos		= get_field("news_header_background_image_position");
			$bg_size 	= get_field("news_header_background_image_size");

			$bg_image = isset($bg_image)?wp_get_attachment_url($bg_image):FALSE;
			$bg_image = isset($bg_image)?esc_url(home_url( '/' )).$bg_image:FALSE;

			$bg_repeat = isset($bg_repeat)?$bg_repeat:'no-repeat';
			$bg_pos	 = isset($bg_pos)?$bg_pos:'center center';
			$bg_size = isset($bg_size)?$bg_size:'auto';
			if($bg_color){
				$style.="background-color:$bg_color;";
			}
			if(!$stretch && $bg_image){
				$style.="background-image:url($bg_image);";
				if($bg_repeat){
					$style.="background-repeat:$bg_repeat;";
					if($bg_repeat == 'no-repeat'){
						if($bg_pos){
							$style.="background-position:$bg_pos;";
						}
						if($bg_size){
							$style.="background-size:$bg_size;";
						}
					}
				}
			}
		?>
		<header class="news-header <?php echo $klasses;?>" <?php if(!empty($style)){?>style="<?php echo $style;?>"<?php } ?> >
			<?php the_post_thumbnail("full"); ?>
		</header>
		<div class="news-pagination">
		</div>
		<div class="news-body container">

			<a href="<?php echo get_page_link(2881); ?>" class="exit-cross-container" >
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/news-cross.png" alt="">
			</a>

			<div class="news-title"><?php the_title(); ?></div>
			<div class="news-subheader">
				<?php the_field('subheader');?>
			</div>
			<div class="news-time">
				<?php the_date('d.M.Y / H:i'); ?>
			</div>
			<div class="news-content">
				<?php  echo the_content(); ?>
			</div>

			<div class="news-links">
				<?php
					$prev = get_previous_post();
					$next = get_next_post();
				?>
				<a <?php echo !$prev?'class="disabled"':'';?> href="<?php echo get_permalink($prev); ?>" rel="prev" style="float:left">&lt; Neuerer Eintrag</a>
				<a <?php echo !$next?'class="disabled"':'';?> href="<?php echo get_permalink($next); ?>" rel="next" style="float:right">Älterer Eintrag &gt;</a>
			</div>
		</div>
	</article>
<?php endwhile; wp_reset_query(); ?>

<style>
	body, .single.news {
		background-color: #F4F4F4;
	}

	.news-header {
		max-height: 100%;
	}

	.news-body {
		background-color: white;
		margin-top: 50px;
		margin-bottom: 50px;
		padding: 50px 80px;
		position: relative;
		width: 798px;
	}

	.news-title {
		color: #B47846;
		font-size: 41px;
		margin-bottom: 25px;
		font-family: MuseoSlab;
		font-weight: 100;
	}

	.news-subheader {
		color: black;
		font-size: 21px;
		margin-bottom: 25px;
		line-height: 100%;
		font-style: italic;
		font-weight: 600;
		line-height: 25px;
	}

	.news-title,
	.news-content {
		text-align: left;
		line-height: 100%;
	}

	.news-time {
		color: #868686;
		font-size: 10px;
		margin-bottom: 30px;
		font-style: italic;
	}

	.news-content p {
		color: black;
		font-size: 17px;
		line-height: 25px;
	}

	.news-content p:last-child {
		margin-bottom: 0;
	}

	.news-links a {
		color: #B47846;
		font-size: 17px;
	}

	.exit-cross-container {
		position: absolute;
		right: -60px;
		top: 0;
	}

	@media screen and (max-width: 950px) {
		.news-body {
			width: auto;
			margin-left: 15px;
			margin-right: 15px;
		}

		.exit-cross-container {
			right: 30px;
			top: 15px;
		}
	}

	@media screen and (max-width: 640px) {
		.news-body {
			padding: 35px;
		}
	}
</style>

<script type="text/javascript">
	var $ = jQuery;
	var $title = $('.news-header');

	var resizePostTitleListerer = function() {
		//$title.height(window.innerHeight * 0.78);
	}

	resizePostTitleListerer();

	$(window).on('resize', resizePostTitleListerer);

</script>