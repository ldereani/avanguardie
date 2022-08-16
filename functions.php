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

/**
 * Wrapper function for get_post_meta
 * @param string $key
 * @return mixed meta_value
 */
if(!function_exists("av_get_meta")){
	function av_get_meta( $key = '', $prefix = "", $post_id = "") {
 
		if($post_id == "")
			$post_id = get_the_ID();

		$post_type = get_post_type($post_id);

		if($prefix != "")
			return get_post_meta( $post_id, $prefix.$key, true );

        if (is_singular("post")  || (isset($post_type) && $post_type == "post")) {
			$prefix = '_av_articolo_';
			return get_post_meta( $post_id, $prefix . $key, true );
		}

		return get_post_meta( $post_id, $key, true );
	}

    if(!function_exists("av_get_term_meta")){
        function av_get_term_meta( $key , $prefix, $term_id) {
                return get_term_meta($term_id, $prefix.$key, true );
    
        }
    }
}

/**
 * Wrapper function for agomenti taxonomy list
 * @return array argomenti
 */
if(!function_exists("av_get_argomenti_of_post")) {
	function av_get_argomenti_of_post( $singular = false ) {
		global $post;

		if ( ! $singular) {
			$singular = $post;
		}

		$argomenti_terms = wp_get_object_terms( $singular->ID, 'post_tag' );
		return $argomenti_terms;
	}
}
