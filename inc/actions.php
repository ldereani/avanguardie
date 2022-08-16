<?php



/**
 * Hide content editor for post types defined in settings
 */
add_action( 'admin_init', 'av_hide_editor' );

function av_hide_editor() {
    global $pagenow;
    if ( $pagenow == "post.php" ) {
        // Get the Post ID.
        if(isset($_GET['post']))
            $post_id = $_GET['post'];
        else if(isset($_POST['post_ID']))
            $post_id = $_POST['post_ID'];

        if ( ! isset( $post_id ) ) {
            return;
        }

        // Get the name of the Page Template file.
        $template_file = get_post_meta( $post_id, '_wp_page_template', true );

        if ( $template_file == 'page-templates/il-progetto.php' ) { // edit the template name
            remove_post_type_support( 'page', 'editor' );
        }

        if ( $template_file == 'page-templates/notizie.php' ) { // edit the template name
            remove_post_type_support( 'page', 'editor' );
        }

        if ( $template_file == 'page-templates/servizi.php' ) { // edit the template name
            remove_post_type_support( 'page', 'editor' );
        }

        if ( $template_file == 'page-templates/didattica.php' ) { // edit the template name
            remove_post_type_support( 'page', 'editor' );
        }

        if ( $template_file == 'page-templates/persone.php' ) { // edit the template name
            remove_post_type_support( 'page', 'editor' );
        }

        if ( $template_file == 'page-templates/numeri.php' ) { // edit the template name
            //  remove_post_type_support( 'page', 'editor' );
        }
        if ( $template_file == 'page-templates/storia.php' ) { // edit the template name
            //  remove_post_type_support( 'page', 'editor' );
        }
    }
}

/**
 * Add css admin style
 */

function av_admin_css_load() {
    wp_enqueue_style( 'style-admin-css', get_stylesheet_directory_uri() . '/inc/admin-css/style-admin.css' );
}

add_action( 'admin_enqueue_scripts', 'av_admin_css_load' );


/**
 * filter for search
 */
function av_search_filters( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_search ) {
        $allowed_types = array( "any", "school", "news", "education", "service" );
        if ( isset( $_GET["type"] ) && in_array( $_GET["type"], $allowed_types ) ) {
            $type = $_GET["type"];
            $post_types = cdv_get_post_types_grouped( $type );
            $query->set( 'post_type', $post_types );

        }

        if ( isset( $_GET["post_types"] ) ) {
            $query->set( 'post_type', $_GET["post_types"] );

        }
        if ( isset( $_GET["post_terms"] ) ) {
            $query->set( 'tag__in', $_GET["post_terms"]);
        }

        // associazione tra types e post_type

    }
}

add_action( 'pre_get_posts', 'av_search_filters' );

/**
 * customize excerpt
 * @param $length
 *
 * @return int
 */
function av_excerpt_length( $length ) {
    return 36;
}
add_filter( 'excerpt_length', 'av_excerpt_length', 999 );


/**
 * filter for events
 *  controllo le query sugli eventi e le modifico per estrarre gli eventi futuri
 */
function av_eventi_filters( $query ) {

    if ( ! is_admin() && $query->is_main_query() && is_post_type_archive("evento") ) {
        if(isset($_GET["date"]) && ($_GET["date"] != "")){

            $arrdate = explode("-", $_GET["date"]);

            if(count($arrdate) != 3) return;

            $newdate = $arrdate[1]."/".$arrdate[0]."/".$arrdate[2];

            $date = strtotime($newdate);

            $date_begin = strtotime($newdate ." 00:00:00" );
            $date_end = strtotime($newdate ." 23:59:59");
            $query->set( 'meta_query', array(
                array(
                    'key' => '_av_evento_timestamp_inizio',
                    'value' => $date_end,
                    'compare' => '<=',
                    'type' => 'numeric'
                ),
                array(
                    'key' => '_av_evento_timestamp_fine',
                    'value' => $date_begin,
                    'compare' => '>=',
                    'type' => 'numeric'
                )
            ));

        }else if(isset($_GET["archive"]) && ($_GET["archive"] == "true")){
            $query->set('meta_key', '_cdv_evento_timestamp_inizio' );
            $query->set('orderby', array('meta_value' => 'DESC', 'date' => 'DESC'));
            $query->set( 'meta_query', array(
                array(
                    'key' => '_av_evento_timestamp_inizio'
                ),
                array(
                    'key' => '_av_evento_timestamp_fine',
                    'value' => time(),
                    'compare' => '<=',
                    'type' => 'numeric'
                )
            ));
        }else{
            $query->set('meta_key', '_av_evento_timestamp_inizio' );
            $query->set('orderby', array('meta_value' => 'DESC', 'date' => 'DESC'));
            $query->set( 'meta_query', array(
                array(
                    'key' => '_cdv_evento_timestamp_inizio'
                ),
                array(
                    'key' => '_cdv_evento_timestamp_fine',
                    'value' => time(),
                    'compare' => '>=',
                    'type' => 'numeric'
                )
            ));

        }
    } /*else if(! is_admin() && ! $query->is_main_query()){

        if ($query->get("post_type") == "evento"){

            $query->set('meta_key', '_cdv_evento_timestamp_inizio' );
            $query->set('orderby', array('meta_value' => 'DESC', 'date' => 'DESC'));
            $query->set( 'meta_query', array(
                array(
                    'key' => '_cdv_evento_timestamp_inizio'
                ),
                array(
                    'key' => '_cdv_evento_timestamp_fine',
                    'value' => time(),
                    'compare' => '>=',
                    'type' => 'numeric'
                )
            ));
        }
    }*/

}

add_action( 'pre_get_posts', 'av_eventi_filters' );






/**
 * Personalizzo archive title
 */
add_filter( 'get_the_archive_title', function ($title) {
global $wp_query;
    if ( is_tag() ) {
        $title = __("Argomento", "curricoli").": ".single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_tax("tipologia-articolo") ) {

        $title = single_term_title('', false);
        /*    if($title == "Articoli"){
                $title = "Presentazione";
            }*/
    } elseif ( is_tax("tipologia-documento") ) {
        $title = single_term_title('', false);
    } elseif ( is_tax("tipologia-cittadinanza") ) {
        $title = single_term_title('', false);
    }elseif ( is_tax("tipologia-disciplina") ) {
        $title = single_term_title('', false);
    }elseif ( is_post_type_archive("servizio") ) {
        $title = __("Tutti i servizi", "curricoli");
    } elseif ( is_post_type_archive("evento") ) {
        $title = __("Calendario", "curricoli");
    } elseif ( is_tax("tipologia-servizio") ) {
        // $title = __("Servizi per ", "curricoli").": ".single_term_title('', false);
        $title = single_term_title('', false);
    } elseif ( is_tax("tipologia-luogo") ) {
        // $title = __("Servizi per ", "curricoli").": ".single_term_title('', false);
        $title = single_term_title('', false);
    } elseif ( is_tax("tipologia-progetto") ) {
        $title = single_term_title('', false);
    }elseif ( is_post_type_archive("luogo") ) {
        $title = __("I luoghi della scuola", "curricoli");
    } elseif ( is_post_type_archive("scuola") ) {
        $title = __("Organizzazione", "curricoli");
    } elseif ( is_post_type_archive("evento") ) {
        $title = __("Eventi", "curricoli");
        if(isset($_GET["date"]) && $_GET["date"] != ""){
            $title .= " del ".$_GET["date"];
        }
        if(isset($_GET["archive"]) && $_GET["archive"] == "true"){
            $title .= " archiviati  ";
        }
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title('', false);
    }

    $title = cdv_pluralize_string($title);
    return $title;

});


/** add responsive class to table **/

function cdv_bootstrap_responsive_table( $content ) {
    $content = str_replace( ['<table', '</table>'], ['<div class="table-responsive"><table class="table  table-striped table-bordered table-hover" ', '</table></div>'], $content );

    return $content;
}
add_filter( 'the_content', 'cdv_bootstrap_responsive_table' );




/**
 * Admin header customization
 *
 */
function cdv_admin_bar_customize_header() {
    global $wp_admin_bar;

    if ( current_user_can( 'read' ) ) {
        $about_url = self_admin_url( 'about.php' );
    } elseif ( is_multisite() ) {
        $about_url = get_dashboard_url( get_current_user_id(), 'about.php' );
    } else {
        $about_url = false;
    }
    
    $wp_admin_bar->add_group(
        array(
            'parent' => 'design-scuole',
            'id'     => 'design-scuole-external',
            'meta'   => array(
                'class' => 'ab-sub-secondary',
            ),
        )
    );

    $wp_admin_bar->add_menu(
        array(
            'parent' => 'design-scuole-external',
            'id'     => 'dsi-about-design',
            'title'  => __( 'About Design Scuole' ),
            'href'   => 'https://designers.italia.it/progetti/siti-web-scuole/',
            'meta'  => array( 'target' => '_blank')
        )
    );


    $wp_admin_bar->add_menu(
        array(
            'parent' => 'design-scuole',
            'id'     => 'dsi-about-wp',
            'title'  => __( 'About WordPress' ),
            'href'   => $about_url,
        )
    );


    $wp_admin_bar->add_menu(
        array(
            'parent' => 'design-scuole',
            'id'     => 'dsi-github',
            'title'  => __( 'Design su GitHub' ),
            'href'   => "https://github.com/italia/design-scuole-wordpress-theme",
            'meta'  => array( 'target' => '_blank')
        )
    );


    if(current_user_can("manage_options")){
        $wp_admin_bar->add_menu(
            array(
                'id'     => 'design-scuole-conf',
                'title' => __( '<div class="dashicons-before dashicons-admin-tools" style="float:left; padding-top: 6px; padding-right:4px;"> </div>Configurazione', "curricoli" ),
                'href'   => admin_url("admin.php?page=homepage")
            )
        );
    }


}
add_action( 'admin_bar_menu', 'cdv_admin_bar_customize_header', -10 );

add_action( 'wp_before_admin_bar_render', 'cdv_admin_bar_before_customize_header', -10 );

function cdv_admin_bar_before_customize_header(){
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu("wp-logo");
}

// rimuovo customizer
add_action( 'admin_menu', function () {
    global $submenu;
    if ( isset( $submenu[ 'themes.php' ] ) ) {
        foreach ( $submenu[ 'themes.php' ] as $index => $menu_item ) {
            foreach ($menu_item as $value) {
                if (strpos($value,'customize') !== false) {
                    unset( $submenu[ 'themes.php' ][ $index ] );
                }
            }
        }
    }
});

add_action( 'wp_before_admin_bar_render', 'cdv_before_admin_bar_render' );

function cdv_before_admin_bar_render()
{
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('customize');
}


/**
 * abilito edit utenti agli admin di un netork multisite
 */

function cdv_admin_users_caps( $caps, $cap, $user_id, $args ){

    foreach( $caps as $key => $capability ){

        if( $capability != 'do_not_allow' )
            continue;

        switch( $cap ) {
            case 'edit_user':
            case 'edit_users':
                $caps[$key] = 'edit_users';
                break;
            case 'delete_user':
            case 'delete_users':
                $caps[$key] = 'delete_users';
                break;
            case 'create_users':
                $caps[$key] = $cap;
                break;
        }
    }

    return $caps;
}
add_filter( 'map_meta_cap', 'cdv_admin_users_caps', 1, 4 );
remove_all_filters( 'enable_edit_any_user_configuration' );
add_filter( 'enable_edit_any_user_configuration', '__return_true');

/**
 * Checks that both the editing user and the user being edited are
 * members of the blog and prevents the super admin being edited.
 */
function cdv_edit_permission_check() {
    global $current_user, $profileuser;

    $screen = get_current_screen();

    $current_user = wp_get_current_user();

    if( ! is_super_admin( $current_user->ID ) && in_array( $screen->base, array( 'user-edit', 'user-edit-network' ) ) ) { // editing a user profile
        if ( is_super_admin( $profileuser->ID ) ) { // trying to edit a superadmin while less than a superadmin
            wp_die( __( 'You do not have permission to edit this user.' ) );
        } elseif ( ! ( is_user_member_of_blog( $profileuser->ID, get_current_blog_id() ) && is_user_member_of_blog( $current_user->ID, get_current_blog_id() ) )) { // editing user and edited user aren't members of the same blog
            wp_die( __( 'You do not have permission to edit this user.' ) );
        }
    }

}
add_filter( 'admin_head', 'cdv_edit_permission_check', 1, 4 );



