<?php while ( have_posts() ) : the_post(); ?>
	<div class="reference-page">
		<?php
			$gif = get_stylesheet_directory_uri()."/assets/images/loading.gif";
			ob_start();
			the_content();
			$content = ob_get_clean();
			$html = str_get_html($content);
			foreach ($html->find('.wpb_single_image img') as $img) {
				$src=$img->src;
				$img->{'data-original'}=$src;
				$img->src=$gif;
				$img->class.=' lazy';
			}
			echo $html;
			?>
	</div>
	<div class="reference-pagination">
		<?php
			$prev = get_previous_post();
			$next = get_next_post();
		?>
		<a <?php echo !$prev?'class="disabled"':'';?> href="<?php echo get_permalink($prev); ?>" rel="prev"></a>
		<a <?php echo !$next?'class="disabled"':'';?> href="<?php echo get_permalink($next); ?>" rel="next"></a>
	</div>
<?php endwhile; wp_reset_query(); ?>
