<?php
/**
 * The Header for my theme.
 */
global $post;
$share = get_facebook_share_meta($post);
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=11,chrome=1" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<meta name="description" content="<?php bloginfo( 'description' ); ?>">
<meta name="author" content="Aaron Made This">
<!-- Facebook -->
<meta property="og:site_name" content="Aaron Made This"/>
<meta property="og:title" content="<?php echo $share['title'];?>"/>
<meta property="og:url" content="<?php echo $share['url'];?>"/>
<meta property="og:description" content="<?php echo $share['description'];?>"/>
<meta property="og:image" content="<?php echo $share['image'];?>"/>
<meta property="og:type" content="<?php echo $share['type'];?>"/>
<!-- Facebook end -->
<title><?php bloginfo( $show='name' ); ?> | <?php wp_title(''); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.min.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class('transition-2'); ?> >
<div id='all-wrapper'>
	<?php get_template_part( 'nav' ); ?>	