<div class="home-full_bleed">
	<div class="seal"></div>

	<div class="home-layout">
		<?php
			$img_link = get_sub_field('image_link');
			$image_id = get_sub_field('image');
			$full_size = wp_get_attachment_image_src($image_id, 'fullscreen');
		?>
		<div class="image-wrap p-wrap">
			<a href="<?php echo $img_link ?>"><img class="center crop" src="<?php echo $full_size[0]; ?>" alt="<?php echo $image['alt']; ?>" data-image-id="<?php echo $image['id']; ?>" data-width="<?php echo $full_size[1]; ?>" data-height="<?php echo $full_size[2]; ?>" /></a>
		</div>
	</div>
</div>