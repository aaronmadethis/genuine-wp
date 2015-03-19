<?php
$imageStart = false;
if(isset($wp_query->query_vars['slideshow_img'])) {
	$imageStart = urldecode($wp_query->query_vars['slideshow_img']);
}
$page_url = get_page_link();
?>

<div class="layout-project">
	<div class="seal"></div>
	<div class="myhide">
		<?php
			//echo $imageStart;
			print_r( get_option('rewrite_rules') );
		?>
	</div>
	<?php
		$images = get_sub_field('images');
		if( $images ):
			$icheck = array();
			foreach ($images as $image) {
				$icheck[] = $image['id'];
			}
			if (!in_array($imageStart, $icheck)) {
				$imageStart = false;
			}
	?>

		<div class="project-slideshow">
			<div class="project-viewport">
				<ul class="slides">

					<?php $loop_counter = 0; ?>
					<?php foreach( $images as $image ): ?>
						<?php
							$img_class;
							$parent_class = "";
							$full_size = wp_get_attachment_image_src($image['id'], 'fullscreen');
							$bg_color = get_field('background_color', $image['id']);
							$txt_color = get_field('text_color', $image['id']);
							$horz = 'horz';
							if( $full_size[2] > $full_size[1] ){
								$horz = 'vert';
							}
							if($imageStart){
								if($imageStart == $image['id']){
									$parent_class = "first";
								}
							}elseif($loop_counter == 0){
								$parent_class = "first";
							}
							if (get_field('crop_image', $image['id'] )) {
								$crop = 'crop';
							}else{
								$crop = 'no-crop';
							}
							$i_data = get_media_attachment($image['id']);
							if($i_data['description']){
								$img_class = $horz . " " . $crop  . " has-caption";
							}else{
								$img_class = $horz . " " . $crop;
							}
							$parent_class .= " " . $txt_color;
						?>

						<li class="image-wrap slideshow myhide <?php echo $parent_class; ?>" style="background-color:<?php echo $bg_color; ?>">
							<div class="preloader_png"></div>
							<div class="inner-image-wrap">
								<div class="inner-image-container p-wrap">
								<a class="img-next" href="#"><img class="<?php echo $img_class; ?> center myhide add-loader" src="<?php echo $full_size[0]; ?>" alt="<?php echo $image['alt']; ?>" data-url="<?php echo $page_url . 'slide-img/' . $image['id']; ?>" data-image-id="<?php echo $image['id']; ?>" data-width="<?php echo $full_size[1]; ?>" data-height="<?php echo $full_size[2]; ?>" /></a>
									<?php if($i_data['description']) : ?>
										<span class="myhide caption description"><?php echo $i_data['description']; ?></span>
									<?php endif; ?>
								</div>
							</div>
						</li>

						<?php ++$loop_counter ?>
					<?php endforeach; ?>

				</ul>
			</div>
		</div>
	<?php endif; ?>
</div>

<div  class="thumb-wrapper transition-2">
	<div class="thumb-grid grid-hide transition-2">
		<ul class="thumb-menu clearfix">
			<?php $loop_counter = 0; ?>
			<?php foreach( $images as $image ): ?>
				<?php
					$thumb_size = wp_get_attachment_image_src($image['id'], 'fullscreen');
					$parent_class = "";
					if($imageStart){
						if($imageStart == $image['id']){
							$parent_class = "active";
						}
					}elseif($loop_counter == 0) {
						$parent_class = "active";
					}
				?>
				<li class="<?php echo $parent_class; ?>">
					<a class="thumb" href="">
						<div class="thumb-image" style="background-image: url(<?php echo $thumb_size[0]; ?>);" data-image-id="<?php echo $image['id']; ?>"></div>
					</a>
				</li>

				<?php ++$loop_counter ?>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

