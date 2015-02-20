<div class="layout-featured clearfix">
	<div class="layout-basic">
		<?php
			$featured = get_sub_field('featured_post');
			$image_id = get_field('image', $featured);

			$full_size = wp_get_attachment_image_src($image_id, 'fullscreen');
		?>
		<h2><?php echo get_the_title( $featured ); ?> </h2>
		<div class="featured_image">
			<img src="<?php echo $full_size[0]; ?>" alt="<?php echo $image['alt']; ?>" data-image-id="<?php echo $image['id']; ?>" data-width="<?php echo $full_size[1]; ?>" data-height="<?php echo $full_size[2]; ?>" />
		</div>
		<div>
			<?php the_field('wyswyg', $featured); ?>
		</div>
	</div>
</div>