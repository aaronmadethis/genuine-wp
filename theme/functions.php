<?php

/* ================================================================================
ADD THUMBNAIL SUPPORT AND ADDITIONAL IMAGE SIZES
================================================================================ */
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 800, 800, true ); // default Post Thumbnail dimensions (cropped)
}	
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'fullscreen', 2880, 1800, false );
	add_image_size( 'blog-roll', 1520, 968, true );
	add_image_size( 'portrait', 636, 980, true );
	add_image_size( 'gallery_thumb', 800, 800, true );
	add_image_size( 'gallery_mason', 390, 9999, false);
}

/* ================================================================================
ADD MENUS AND POST FORMAT SUPPORT
================================================================================ */
if ( ! function_exists( 'amt_wp_setup' ) ) {

	function amt_wp_setup() {
		register_nav_menus( array( 'main' => 'Home Menu' ) );

		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat') );
	}

}

add_action( 'after_setup_theme', 'amt_wp_setup' );

/* ================================================================================
HELP WITH EMAIL FORM
================================================================================ */
add_filter( 'wp_mail_from', 'my_mail_from' );
function my_mail_from( $email ) {
    return "michael@makeitgenuine.nyc";
}

add_filter( 'wp_mail_from_name', 'my_mail_from_name' );
function my_mail_from_name( $name ){
    return "Make It Genuine";
}


/* ================================================================================
ADDING QUERY TO URL FOR IMAGES
================================================================================ */
function add_query_vars($aVars) {
	$aVars[] = "slideshow_img"; // represents the name of the product category as shown in the URL
	return $aVars;
}
 
// hook add_query_vars function into query_vars
add_filter('query_vars', 'add_query_vars');

function add_rewrite_rules($aRules) {
	//$aNewRules = array('(.?.+?)/slide-img/([^/]+)/?$' => 'index.php?pagename=$matches[1]&slideshow_img=$matches[2]');
	$aNewRules = array('(.?.+?)/slide-img/([^/]+)?$' => 'index.php?pagename=$matches[1]&slideshow_img=$matches[2]', '(.?.+?)/slide-img/?$' => 'index.php?pagename=$matches[1]&slideshow_img=0');
	$aRules = $aNewRules + $aRules;
	return $aRules;
}
 
// hook add_rewrite_rules function into rewrite_rules_array
add_filter('rewrite_rules_array', 'add_rewrite_rules');

/* ================================================================================
REMOVE POSTS AND COMMENTS FROM ADMIN
================================================================================ */
function remove_menus(){
	//remove_menu_page( 'edit.php' );                   //Posts
	remove_menu_page( 'edit-comments.php' );          //Comments
}
add_action( 'admin_menu', 'remove_menus' );


/* ================================================================================
ADD SITE OPTIONS PAGE
================================================================================ */
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page('Theme Options');
	
}

/* ================================================================================
CREATE A MULTI-COLUMN LIST OUT OF ONE LIST
================================================================================ */
function create_columns($html){
	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	foreach($dom->getElementsByTagName('p') as $node){
	    //$array[] = $dom->saveHTML($node);
	    $array[] = $node->nodeValue;
	}
	$result = count($array);
	$col_length = $result / 2;
	$col_length = ceil( $col_length );
	$html='<ul class="no_1">';

	$counter = 0;
	foreach ($array as $key => $value) {
		if($counter == $col_length ){
			$html .= '</ul>';
			$html .= '<ul class="no_2">';
			$counter = 0;
		}
		$html .= '<li>' . $value . '</li>';
		++$counter;
	}
	$html .= '</ul>';

	//print_r($array);
	return $html;
}

/* ================================================================================
HOME PAGE HEADER TITLE - HACK FOR CUSTOM HOME PAGE
================================================================================ */
add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );
function baw_hack_wp_title_for_home( $title )
{
  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
    return __( 'Home', 'theme_domain' ) . ' | ' . get_bloginfo( 'description' );
  }
  return $title;
}

/* ================================================================================
FACEBOOK SHARING FOR HEADER
================================================================================ */
function get_facebook_share_meta($post){
	$theme_dir_path = get_stylesheet_directory_uri();
	
	if( is_single($post) ){
		$fb_meta = array();
		$fb_meta['title'] = $post->post_title;
		$fb_meta['description'] = $post->post_excerpt;
		$fb_meta['type'] = 'website';
		$fb_meta['url'] = get_permalink( $post->ID );

		$image_id = get_post_thumbnail_id($post->ID);
		$share_img = wp_get_attachment_image_src($image_id, 'post-thumbnail');
		if(!$share_img){
			$fb_meta['image'] = $theme_dir_path . "/images/facebook-img.jpg";
		}else{
			$fb_meta['image'] = $share_img[0];
		}
		
	}else{
		$fb_meta = array();
		$fb_meta['title'] = "Ovation Chicago";
		$fb_meta['description'] = "Event space in Chicago Illinois. Tell only your closest friends.";
		$fb_meta['type'] = 'website';
		$fb_meta['url'] = 'http://ovationchicago.com/';
		$fb_meta['image'] = $theme_dir_path . "/images/facebook-img.jpg";
	}
	return $fb_meta;
}

/* ================================================================================
BETTER POST IMAGE THUMBNAIL
* checks for post featured image first
* if not featured image attempt to scrape the post for the first image
* if no image in the post then use a general placeholder image
================================================================================ */
function ap_better_thunbnails( $post_id, $img_size ){
	if( has_post_thumbnail( $post_id ) ){
		$image_id = get_post_thumbnail_id($post_id);
		$thumb = wp_get_attachment_image_src($image_id, $img_size);
		return $thumb;
	}else{
		$args = array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => $post_id
		);
		$attachments = get_posts( $args );
		if ( $attachments ) {
			$image_id = $attachments[0]->ID;
			$thumb = wp_get_attachment_image_src($image_id, $img_size);
			return $thumb;
		}else{
			$image_id = get_field('placeholder_image', 'options');
			$thumb = wp_get_attachment_image_src($image_id, $img_size);
			return $thumb;
		}
	}
}

/* ================================================================================
GET MEDIA/IMAGE DATA
================================================================================ */
function get_media_attachment( $attachment_id ) {

	$attachment = get_post( $attachment_id );
	return array(
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID ),
		'src' => $attachment->guid,
		'title' => $attachment->post_title
	);
}



/* ================================================================================
HOOKS AND ACTIONS - LAYOUTS
================================================================================ */
//Condition enable portfolio template
function amt_check_portfolio_template(){
	$switch = false;
	
	if(is_singular('post')){

		//** get portfolio template meta
		$portfolio = get_field('post_type', get_the_ID() );
		
		if($portfolio ){
			$switch = true;
		}
	}

	return $switch;
	
}

//Action Hook Single Content
add_action('amt_interface_single_content', 'amt_interface_single_portfolio', 10);

//Template Single portfolio
function amt_interface_single_portfolio(){
	if(amt_check_portfolio_template()){
		amt_get_template_part('single', 'portfolio');
	}else{
		amt_get_template_part('single', 'post');
	}
}

//UX Theme Get Template
function amt_get_template_part($key, $name){
	get_template_part('template/' . $key, $name);
}



/* ================================================================================
COUNTS THE NUMBER OF DATABASE HITS PER PAGE
================================================================================ 
add_action( 'wp_footer', 'tcb_note_server_side_page_speed' );
function tcb_note_server_side_page_speed() {
	date_default_timezone_set( get_option( 'timezone_string' ) );
	$content  = '[ ' . date( 'Y-m-d H:i:s T' ) . ' ] ';
	$content .= 'Page created in ';
	$content .= timer_stop( $display = 0, $precision = 2 );
	$content .= ' seconds from ';
	$content .= get_num_queries();
	$content .= ' queries';
	if( ! current_user_can( 'administrator' ) ) $content = "<!-- $content -->";
	echo $content;
}
*/

/* ================================================================================
FUNCTIONS FOR ADDING JAVASCRIPTS
================================================================================ */
add_action( 'template_redirect', 'my_script_enqueuer' );

function my_script_enqueuer() {
	$display_script_url = get_bloginfo('template_directory') . '/js/display-0.1.js';
	wp_register_script( 'display_script', $display_script_url  );
	$protocol = isset( $_SERVER["HTTPS"] ) ? 'https://' : 'http://';
	$params = array( 'ajaxurl' => admin_url( 'admin-ajax.php', $protocol ) );
	wp_localize_script( 'display_script', 'amt_gallery_img', $params );

	wp_enqueue_script('jquery');

	$modernizr_url = get_bloginfo('template_directory') . '/js/modernizr.custom.97178.js';
	wp_enqueue_script('modernizr', $modernizr_url);

	$bootstrap_url = get_bloginfo('template_directory') . '/js/bootstrap.min.js';
	wp_enqueue_script('bootstrap', $bootstrap_url, array('jquery', 'modernizr'), '', true);

	//$slicknav_url = get_bloginfo('template_directory') . '/js/jquery.slicknav.min.js';
	//wp_enqueue_script('slicknav', $slicknav_url, array('jquery', 'modernizr'), '', true);

	$plugins = get_bloginfo('template_directory') . '/js/plugins-0.1.js';
	wp_enqueue_script('plugins', $plugins, array('jquery', 'modernizr'), '', true);
	wp_enqueue_script('display_script', '', array('jquery', 'modernizr', 'plugins'), '', true);

	wp_enqueue_style( 'bootstrap_css', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'slicknav_css', get_template_directory_uri() . '/css/slicknav.css' );

}

?>