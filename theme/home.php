<?php /*
 ---- home page template ---- 
NOTE: WORDPRESS ALWAYS WANT THE HOME PAGE TO BE THE BLOG ROLL
SO EVEN THO THIS IS THE HOME PAGE TEMPLATE IT IS REALLY THE BLOG ROLL TEMPLATE
USE FRONT_PAGE TEMPLATE FOR THE TRUE HOME PAGE
*/
?>
<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class("clearfix"); ?> >
			<?php
			$post_id = get_the_ID();
			$img_size = 'post-thumbnail';
			$thumb = ap_better_thunbnails( $post_id, $img_size );
			?>
			<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			<img src="<?php echo $thumb[0]; ?>">
			<div class="home"><?php the_content(); ?></div>
		</article>
	<?php endwhile; ?>
<?php endif; /*have_posts*/ ?>

<?php get_footer(); ?>