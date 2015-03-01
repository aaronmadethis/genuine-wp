<div class="layout-about clearfix">
	<div class="portrait float-left">
		<?php 
		$image_id = get_sub_field('portrait');
		$full_size = wp_get_attachment_image_src($image_id, 'portrait');
		?>
		<img class="add-loader" src="<?php echo $full_size[0]; ?>" alt="Portrait of Michael Scalasis" data-image-id="<?php echo $image_id; ?>" data-width="<?php echo $full_size[1]; ?>" data-height="<?php echo $full_size[2]; ?>" />
	</div>
	<div class="about-text float-left">
		<div class="wrap">
			<div class="logo"></div>
			<h2><?php the_title(); ?></h2>
			<span class="wysiwyg"><?php the_sub_field('wysiwyg'); ?></span>
		</div>
	</div>
</div>