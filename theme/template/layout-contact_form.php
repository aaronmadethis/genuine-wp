<div class="layout-contact clearfix">
	<div class="layout-basic">
		<div class="illustration-wrap float-left">
			<div class="illustration">
			</div>
		</div>
		<div class="contact-form float-left">
			<div class="wrap">
				<h2><?php the_title(); ?></h2>
				<?php $contact_shortcode = get_sub_field('contact_shortcode'); ?>
				<?php echo do_shortcode( $contact_shortcode ); ?>
			</div>
		</div>
		<div class="float-left info">
			<div class="wrap">
				<span><?php the_field('name', 'options'); ?></span>
				<span>Phone: <?php the_field('phone_number', 'options'); ?></span>
				<span>Email: <a href="mailto:<?php the_field('email', 'options'); ?>"><?php the_field('email', 'options'); ?></a></span>
				<span><a href="<?php the_field('instagram', 'options'); ?>" target="_blank">Instagram</a></span>
			</div>
		</div>
	</div>
</div>