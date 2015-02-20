<div class="layout-contact clearfix">
	<div class="layout-basic">
		<div class="float-left">
			<?php $contact_shortcode = get_sub_field('contact_shortcode'); ?>
			<?php echo do_shortcode( $contact_shortcode ); ?>
		</div>
		<div class="float-left info">
			<span><?php the_field('name', 'options'); ?></span>
			<span>Phone: <?php the_field('phone_number', 'options'); ?></span>
			<span>Email <a hre="mailto:<?php the_field('email', 'options'); ?>"><?php the_field('email', 'options'); ?></a></span>
			<span><a hre="<?php the_field('instagram', 'options'); ?>">Instagram</a></span>
		</div>
	</div>
</div>