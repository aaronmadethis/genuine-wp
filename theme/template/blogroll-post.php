<?php
	$image_id = get_field('image');
	$full_size = wp_get_attachment_image_src($image_id, 'post-thumbnail');
?>
<div class="blogroll-post transition-2">
	<div class="wrap transition-2">
		<a href="<?php the_permalink(); ?>">
			<div class="thumb-image" style="background-image: url(<?php echo $full_size[0]; ?>);" data-image-id="<?php echo $image_id; ?>"></div>
			<h2><?php the_title(); ?> </h2>
		</a>
	</div>
</div>