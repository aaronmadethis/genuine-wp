<?php
	/* ----- Navigation Template ----- */
	$theme_dir_path = get_stylesheet_directory_uri();
	$nav_init = "side-nav-closed";
	if( is_front_page() ){ $nav_init = "side-nav"; }
?>
<header class="<?php echo $nav_init; ?> transition-2">
	<div class="nav-wrapper transition-2">
		<div class="nav-container transition-2">
			<a href="#" class="open-nav transition-2">MENU</a>
			<a href="<?php echo home_url(); ?>"><div class="logo"></div></a>

			<nav role="navigation" class="nav-menu transition-2">
				<?php wp_nav_menu( array( 'theme_location' => 'main', 'depth' => 1, 'container' => false ) ); ?>
			</nav>
		</div>
	</div>
</header>


