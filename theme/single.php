<?php /* ---- single page template ---- */ ?>
<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<?php //** Do Hook Single content
			do_action('amt_interface_single_content'); 
		?>

	<?php endwhile; ?>
<?php endif; /*have_posts*/ ?>

<?php get_footer(); ?>