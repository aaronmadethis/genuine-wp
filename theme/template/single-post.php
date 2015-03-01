<div class="layout-featured single post clearfix">
	<div class="layout-basic transition-2">
		<?php
			$featured = get_sub_field('featured_post');
			$image_id = get_field('image', $featured);

			$full_size = wp_get_attachment_image_src($image_id, 'fullscreen');
		?>
		<div class="featured-image transition-2">
			<div class="wrap transition-2">
				<img src="<?php echo $full_size[0]; ?>" alt="<?php echo $image['alt']; ?>" data-image-id="<?php echo $image['id']; ?>" data-width="<?php echo $full_size[1]; ?>" data-height="<?php echo $full_size[2]; ?>" />
				<div class="myclose transition-2"><a href="#" alt="Enlarge Image">Shrink image</a></div>
			</div>
			<div class="enlarge transition-2"><a href="#" alt="Enlarge Image">Enlarge image</a></div>
		</div>
		<div class="featured-text">
			<div class="wrap">
				<h2><?php echo get_the_title( $featured ); ?> </h2>
				<span class="wysiwyg"><?php the_field('wyswyg', $featured); ?></span>
			</div>
			<div class="archives">
				<?php
				$page_id = 121;
				$uri = get_page_uri($page_id);
				?>
				<a href="<?php echo $uri; ?>"><span>View Archives</span></a>
			</div>
		</div>
	</div>
</div>