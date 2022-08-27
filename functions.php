<?php

/**
 * Define
 */
require get_template_directory() . '/inc/define.php';

/**
 * Extend User Taxonomy
 */
require get_template_directory() . '/inc/extend-tax-to-user.php';

/**
 * Implement Plugin Activations Rules
 */
require get_template_directory() . '/inc/theme-dependencies.php';


/**
 * header menu walker
 */
require get_template_directory() . '/walkers/header-walker.php';

/**
 * footer menu walker
 */
require get_template_directory() . '/walkers/footer-walker.php';

/**
 * Implement CMB2 Custom Field Manager
 */
if ( ! function_exists ( 'av_get_tipologia_articoli_options' ) ) {
	require get_template_directory() . '/inc/cmb2.php';
	require get_template_directory() . '/inc/backend-template.php';
}

/**
 * Utils functions
 */
require get_template_directory() . '/inc/utils.php';


/**
 * Breadcrumb class
 */
require get_template_directory() . '/inc/breadcrumb.php';

/**
 * Activation Hooks
 */
require get_template_directory() . '/inc/activation.php';

/**
 * Actions & Hooks
 */
require get_template_directory() . '/inc/actions.php';

/**
 * Gutenberg editor rules
 */
require get_template_directory() . '/inc/gutenberg.php';



/**
 * TCPDF
 */
require get_template_directory() . '/inc/dompdf.php';




if ( ! function_exists( 'av_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function av_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Design Scuole Italia, use a find and replace
		 * to change 'avanguardie' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'avanguardie', get_template_directory() . '/languages' );


        load_theme_textdomain( 'easy-appointments', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

        // image size
        if ( function_exists( 'add_image_size' ) ) {
            add_image_size( 'article-simple-thumb', 500, 384 , true);
            add_image_size( 'item-thumb', 280, 280 , true);
            add_image_size( 'item-gallery', 730, 485 , true);
            add_image_size( 'vertical-card', 190, 290 , true);

            add_image_size( 'banner', 600, 250 , false);
        }

        // This theme uses wp_nav_menu()
		register_nav_menus( array(
			'menu-topleft' => esc_html__( 'Menu principale (in alto a sinistra)"', 'avanguardie' ),
			/*'menu-classe' => esc_html__( 'Sottovoci del menu principale, voce "La mia classe"', 'avanguardie' ),*/
			'menu-topright' => esc_html__( 'Menu secondario (in alto a destra)', 'avanguardie' ),
			'menu-footer' => esc_html__( 'Menu a piè di pagina', 'avanguardie' ),
		) );

	}
endif;
add_action( 'after_setup_theme', 'av_setup' );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function av_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Footer - colonna 1', 'avanguardie' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Prima colonna a più di pagina.', 'avanguardie' ),
		'before_widget' => '<div class="footer-list">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="h3">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer - colonna 2', 'avanguardie' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Seconda colonna a più di pagina.', 'avanguardie' ),
		'before_widget' => '<div class="footer-list">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="h3">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer - colonna 3', 'avanguardie' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Terza colonna a più di pagina.', 'avanguardie' ),
		'before_widget' => '<div class="footer-list">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="h3">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer - colonna 4', 'avanguardie' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Quarta colonna a più di pagina.', 'avanguardie' ),
		'before_widget' => '<div class="footer-list">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="h3">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'av_widgets_init' );

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


/**
 * Enqueue scripts and styles.
 */
function av_scripts() {
	wp_enqueue_style('child-style', get_theme_file_uri('/style.css'));

    //wp_deregister_script('jquery');
	wp_enqueue_style( 'av-boostrap-italia', get_stylesheet_directory_uri() . '/assets/css/bootstrap-italia.css');
	wp_enqueue_style( 'av-overrides', get_stylesheet_directory_uri() . '/assets/css/overrides.css');
	wp_enqueue_style( 'av-carousel-style', get_stylesheet_directory_uri() . '/assets/css/carousel-style-double.css');
	wp_enqueue_style( 'av-splide-min', get_stylesheet_directory_uri() . '/assets/css/splide.min.css');
	wp_enqueue_script( 'av-modernizr', get_template_directory_uri() . '/assets/js/modernizr.custom.js');
	// print css
    wp_enqueue_style('av-print-style',get_stylesheet_directory_uri() . '/print.css', array(),'20190912','print' );
	wp_enqueue_style( 'av-avanguardie', get_stylesheet_directory_uri() . '/assets/css/avanguardie.css');

/*	wp_enqueue_style( 'dsi-wp-style', get_stylesheet_uri() );
	wp_enqueue_style( 'dsi-font', get_stylesheet_directory_uri() . '/assets/css/fonts.css');
	
	*/
	// footer
	wp_enqueue_script( 'av-boostrap-italia-js', get_template_directory_uri() . '/assets/js/bootstrap-italia.js', array(), false, true);

	wp_enqueue_script( 'av-splide-min', get_template_directory_uri() . '/assets/js/splide.min.js', array(), null, true);
	wp_enqueue_script( 'av-jquery-easing', get_template_directory_uri() . '/assets/js/components/jquery-easing/jquery.easing.js', array(), false, true);
	wp_enqueue_script( 'av-jquery-scrollto', get_template_directory_uri() . '/assets/js/components/jquery.scrollto/jquery.scrollTo.js', array(), false, true);
	wp_enqueue_script( 'av-jquery-responsive-dom', get_template_directory_uri() . '/assets/js/components/ResponsiveDom/js/jquery.responsive-dom.js', array(), false, true);
	wp_enqueue_script( 'av-jpushmenu', get_template_directory_uri() . '/assets/js/components/jPushMenu/jpushmenu.js', array(), false, true);
	wp_enqueue_script( 'av-perfect-scrollbar', get_template_directory_uri() . '/assets/js/components/perfect-scrollbar-master/perfect-scrollbar/js/perfect-scrollbar.jquery.js', array(), false, true);
	wp_enqueue_script( 'av-vallento', get_template_directory_uri() . '/assets/js/components/vallenato.js-master/vallenato.js', array(), false, true);
	wp_enqueue_script( 'av-jquery-responsive-tabs', get_template_directory_uri() . '/assets/js/components/responsive-tabs/js/jquery.responsiveTabs.js', array(), false, true);
	wp_enqueue_script( 'av-fitvids', get_template_directory_uri() . '/assets/js/components/fitvids/jquery.fitvids.js', array(), false, true);
	wp_enqueue_script( 'av-sticky-kit', get_template_directory_uri() . '/assets/js/components/sticky-kit-master/dist/sticky-kit.js', array(), false, true);
	wp_enqueue_script( 'av-jquery-match-height', get_template_directory_uri() . '/assets/js/components/jquery-match-height/dist/jquery.matchHeight.js', array(), false, true);
	wp_enqueue_script( 'av-avanguardie-js', get_template_directory_uri() . '/assets/js/avanguardie.js', array(), false, true);

	if(is_singular(array("luogo", "evento", "post", "indirizzo")) || is_archive() || is_search() || is_post_type_archive("luogo")) {
		wp_enqueue_script( 'av-leaflet-js', get_template_directory_uri() . '/assets/js/components/leaflet/leaflet.js', array(), false, true);
    }
    /*TODO: da definire se minifizzare*/
	/*
	*/
/*
	if(is_singular(array("servizio", "struttura", "luogo", "evento", "scheda_progetto", "post", "circolare", "indirizzo")) || is_archive() || is_search() || is_post_type_archive("luogo")) {
		wp_enqueue_script( 'dsi-leaflet-js', get_template_directory_uri() . '/assets/js/components/leaflet/leaflet.js', array(), false, true);
    }
	*/
/*
	if(is_singular()){
        wp_enqueue_style( 'basictable-css', get_stylesheet_directory_uri() . '/assets/components/basictable/basictable.css');
        wp_enqueue_script( 'basictable-js', get_template_directory_uri() . '/assets/components/basictable/jquery.basictable.js');

    }*/


/*
	if(is_singular(array("evento","scheda_progetto")) || is_home() || is_archive() ){
		wp_enqueue_script( 'dsi-clndr-json2', get_template_directory_uri() . '/assets/js/components/clndr/json2.js', array(), false, false);
		wp_enqueue_script( 'dsi-clndr-moment', get_template_directory_uri() . '/assets/js/components/clndr/moment-2.8.3.js', array(), false, false);
		wp_enqueue_script( 'dsi-clndr-underscore', get_template_directory_uri() . '/assets/js/components/clndr/underscore.js', array(), false, false);
		wp_enqueue_script( 'dsi-clndr-clndr', get_template_directory_uri() . '/assets/js/components/clndr/clndr.js', array(), false, false);
		wp_enqueue_script( 'dsi-clndr-it', get_template_directory_uri() . '/assets/js/components/clndr/it.js', array(), false, false);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	*/
}
add_action( 'wp_enqueue_scripts', 'av_scripts' );






/*
 * Set post views count using post meta
 */
function set_views($post_ID) {
	$key = 'views';
	$count = get_post_meta($post_ID, $key, true); //retrieves the count

	if($count == ''){ //check if the post has ever been seen

		//set count to 0
		$count = 0;

		//just in case
		delete_post_meta($post_ID, $key);

		//set number of views to zero
		add_post_meta($post_ID, $key, '0');

	} else{ //increment number of views
		$count++;
		update_post_meta($post_ID, $key, $count);
	}
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

/**
 * Event date start/stop
 * @param $post
 *
 */
function av_get_date_evento($post){
	if($post->post_type == "evento")
		$prefix = '_av_evento_';

	$ret = "";
	$timestamp_inizio = av_get_meta("timestamp_inizio", $prefix, $post->ID);
	$timestamp_fine= av_get_meta("timestamp_fine", $prefix, $post->ID);
	if($timestamp_inizio >= $timestamp_fine){
		$ret .=  date_i18n("j F Y", $timestamp_inizio);
		//$ret .= __(" alle ", "avanguardie");
		//$ret .=  date_i18n("H:i", $timestamp_inizio);
		return $ret;
	}

	$data_inizio = date_i18n("j F Y", $timestamp_inizio);
	$data_fine = date_i18n("j F Y", $timestamp_fine);
	$ora_inizio = date_i18n("H:i", $timestamp_inizio);
	$ora_fine = date_i18n("H:i", $timestamp_fine);
	if($data_inizio == $data_fine){
		$ret .= __("Il ", "avanguardie");
		$ret .= $data_inizio;
		/*
		if($post->post_type == "evento"){
			$ret .= __(" dalle ", "avanguardie");
			$ret .= $ora_inizio;
			$ret .= __(" alle ", "avanguardie");
			$ret .= $ora_fine;

		}*/

	}else{
		$ret .= __("dal ", "avanguardie");
		$ret .= $data_inizio;
		/*
		if($post->post_type == "evento") {
			$ret .= __( " alle ", "avanguardie" );
			$ret .= $ora_inizio;
		}*/
		$ret .= __(" al ", "avanguardie");
		$ret .= $data_fine;
		/*
		if($post->post_type == "evento") {
			$ret .= __( " alle ", "avanguardie" );
			$ret .= $ora_fine;
		}*/
	}

	return $ret;

}
