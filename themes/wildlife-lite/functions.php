<?php
/**
 * Wildlife Lite functions and definitions
 *
 * @package Wildlife Lite
 */

if ( ! function_exists( 'wildlife_lite_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function wildlife_lite_setup() {
	
	if ( ! isset( $content_width ) )
		$content_width = 640; /* pixels */

	load_theme_textdomain( 'wildlife-lite', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );
	add_image_size('wildlife-lite-homepage-thumb',true);
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'wildlife-lite' ),		
	) );
	add_theme_support( 'custom-background', array(
		'default-color' => 'f1f1f1'
	) );
	add_editor_style( array( 'editor-style.css', wildlife_lite_font_url() ) );
}
endif; // wildlife_lite_setup
add_action( 'after_setup_theme', 'wildlife_lite_setup' );


function wildlife_lite_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'wildlife-lite' ),
		'description'   => __( 'Appears on blog page sidebar', 'wildlife-lite' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

}
add_action( 'widgets_init', 'wildlife_lite_widgets_init' );

function wildlife_lite_font_url(){
		$font_url = '';
		
		/* Translators: If there are any character that are
		* not supported by Raleway, translate this to off, do not
		* translate into your own language.
		*/
		$rale = _x('on', 'Raleway font:on or off','wildlife-lite');
		
		/* Translators: If there are any character that are
		* not supported by Open Sans, translate this to off, do not
		* translate into your own language.
		*/
		$opens = _x('on', 'Open Sans font:on or off','wildlife-lite');
		
		/* Translators: If there are any character that are
		* not supported by Lobster, translate this to off, do not
		* translate into your own language.
		*/
		$lob = _x('on', 'Lobster font:on or off','wildlife-lite');
		
		
		
		if('off' !== $rale || 'off' !== $opens || 'off' !== $lob){
			$font_family = array();
			
			if('off' !== $rale){
				$font_family[] = 'Raleway:400,700';
			}
			
			if('off' !== $opens){
				$font_family[] = 'Open Sans:400';
			}
			
			if('off' !== $lob){
				$font_family[] = 'Lobster:400';
			}
			
			$query_args = array(
				'family'	=> urlencode(implode('|',$font_family)),
			);
			
			$font_url = add_query_arg($query_args,'https://fonts.googleapis.com/css');
		}
		
	return $font_url;
	}

function wildlife_lite_scripts() {
	wp_enqueue_style( 'wildlife-lite-font', wildlife_lite_font_url(), array() );
	wp_enqueue_style( 'wildlife-lite-basic-style', get_stylesheet_uri() );
	wp_enqueue_style( 'wildlife-lite-responsive-style', get_template_directory_uri().'/css/theme-responsive.css' );
	wp_enqueue_style( 'nivo-style', get_template_directory_uri().'/css/nivo-slider.css');
	wp_enqueue_style( 'font-awesome-style', get_template_directory_uri().'/css/font-awesome.css' );	
	wp_enqueue_script( 'jquery-nivo-slider-js', get_template_directory_uri() . '/js/jquery.nivo.slider.js', array('jquery') );
	wp_enqueue_script( 'wildlife-lite-customscripts', get_template_directory_uri() . '/js/custom.js', array('jquery') );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wildlife_lite_scripts' );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function wildlife_lite_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'wildlife_lite_front_page_template' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/*
 * Load customize pro
 */
require_once( trailingslashit( get_template_directory() ) . 'customize-pro/class-customize.php' );

add_filter('use_block_editor_for_post', '__return_false');
