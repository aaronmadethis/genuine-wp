<?php /* ---- archive template ---- */ ?>
<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<article <?php post_class(); ?> >
			<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			<div class="home"><?php the_content(); ?></div>
		</article>
		
	<?php endwhile; ?>
<?php endif; /*have_posts*/ ?>

<?php get_footer(); ?>