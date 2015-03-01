<?php /*
 ---- home page template ---- 
NOTE: WORDPRESS ALWAYS WANT THE HOME PAGE TO BE THE BLOG ROLL
SO EVEN THO THIS IS THE HOME PAGE TEMPLATE IT IS REALLY THE BLOG ROLL TEMPLATE
USE FRONT_PAGE TEMPLATE FOR THE TRUE HOME PAGE
*/
?>
<?php get_header(); ?>

<div class="layout-blogroll">
	<div class="layout-basic">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				
			 	<?php amt_get_template_part('blogroll', 'post'); ?>

			<?php endwhile; ?>
		<?php endif; /*have_posts*/ ?>
	</div>
</div>


<?php get_footer(); ?>