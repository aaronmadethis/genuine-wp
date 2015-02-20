<?php /* ---- index page template ---- */ ?>
<?php get_header(); ?>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>

		<div class="index">
			<?php the_content(); ?>
		</div>

		<?php endwhile; ?>
	<?php endif; /*have_posts*/ ?>

<?php get_footer(); ?>