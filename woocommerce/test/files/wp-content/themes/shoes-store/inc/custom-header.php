<?php
/**
 * @package Shoes Store 
 * Setup the WordPress core custom header feature.
 *
 * @uses shoes_store_header_style()
*/
function shoes_store_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'shoes_store_custom_header_args', array(
		'header-text' 			 =>	false,
		'width'                  => 1200,
		'height'                 => 70,
		'flex-width'    		 => true,
		'flex-height'    		 => true,
		'wp-head-callback'       => 'shoes_store_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'shoes_store_custom_header_setup' );

if ( ! function_exists( 'shoes_store_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see shoes_store_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'shoes_store_header_style' );

function shoes_store_header_style() {
	if ( get_header_image() ) :
	$custom_css = "
        .home-page-header .menu-header{
			background-image:url('".esc_url(get_header_image())."') !important;
			background-position: center top;
		    background-size: cover;
		}";
	   	wp_add_inline_style( 'shoes-store-basic-style', $custom_css );
	endif;
}
endif;