<?php
/**
 * +++REPLACE_THEME_NAME+++ Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package +++REPLACE_CLIENT_NAME+++
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( '+++REPLACE_THEME_SELECTED+++_CHILD_THEME_VERSION', '1.0.1' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('+++REPLACE_THEME_SELECTED+++-theme-css'), +++REPLACE_THEME_SELECTED+++_CHILD_THEME_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

/**
 * Custom ACF Blocks
 */
add_action('acf/init', 'my_acf_init');
function my_acf_init()
{

    // check function exists
    if (function_exists('acf_register_block_type')) {
		// Insert new modules here
	}
}
