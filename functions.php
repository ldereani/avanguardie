<?php

/**
 * Utils functions
 */
//require get_stylesheet_directory_uri() . '/inc/utils.php';

/*
add_action( 'wp_enqueue_scripts','my_theme_style' );
function my_theme_style() 
{
   
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( 'parenthandle' ), 
        wp_get_theme()->get('Version') // this only works if you have Version in the style header
    );
}
*/
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles() {
   wp_enqueue_style('child-style', get_theme_file_uri('/style.css'));
}