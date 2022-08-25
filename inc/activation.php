<?php

/**
 * Action to add page templates used by theme
 */

add_action( 'after_switch_theme', 'av_create_pages_on_theme_activation' );

function av_create_pages_on_theme_activation() {
    // verifico se è una prima installazione
    $av_has_installed = get_option("av_has_installed");


    wp_insert_term( 'Notizie', 'tipologia-articolo' );
    wp_insert_term( 'Articoli', 'tipologia-articolo' );
    wp_insert_term( 'Rassegna Stampa', 'tipologia-articolo' );


    wp_insert_term( 'Documento Generico', 'tipologia-documento' );
    wp_insert_term( 'Modulistica', 'tipologia-documento' );


    /**
     * creo il menu Novità
     */
    
    $name = __('Novità', "avanguardie");

    wp_delete_nav_menu($name);
    $menu_object = wp_get_nav_menu_object( $name );
    if($menu_object) {
        $menu_notizie = $menu_object->term_id;
    }else {

        $menu_id = wp_create_nav_menu($name);
        $menu = get_term_by('id', $menu_id, 'nav_menu');
        $menu_notizie = $menu_id;

        $term = get_term_by("name", "Notizie", "tipologia-articolo");
        wp_update_nav_menu_item($menu->term_id, 0, array(
            'menu-item-title' => __('Le notizie', "avanguardie"),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'taxonomy',
            'menu-item-object' => 'tipologia-articolo',
            'menu-item-object-id' => $term->term_id,
            'menu-item-classes' => 'footer-link',
        ));


        wp_update_nav_menu_item($menu->term_id, 0, array(
            'menu-item-title' => __('Calendario eventi', "avanguardie"),
            'menu-item-status' => 'publish',
            'menu-item-object' => 'eventi',
            'menu-item-type' => 'post_type_archive',
            'menu-item-classes' => 'footer-link',
        ));


        $locations_primary_arr = get_theme_mod('nav_menu_locations');
        $locations_primary_arr["menu-notizie"] = $menu->term_id;
        set_theme_mod('nav_menu_locations', $locations_primary_arr);
        update_option('menu_check', true);
    }
  
    /**
     * creo il menu Footer
     */
    
    $name = __('Footer', "avanguardie");

    wp_delete_nav_menu($name);
    $menu_object = wp_get_nav_menu_object( $name );
    if($menu_object) {
        $menu_footer = $menu_object->term_id;
    }else {

        $menu_id = wp_create_nav_menu($name);
        $menu = get_term_by('id', $menu_id, 'nav_menu');
        $menu_footer = $menu_id;


        wp_update_nav_menu_item($menu->term_id, 0, array(
            'menu-item-title' => __('Privacy Policy', "avanguardie"),
            'menu-item-url' => get_privacy_policy_url(),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom', // optional
            'menu-item-classes' => 'footer-link',
        ));

		wp_update_nav_menu_item($menu->term_id, 0, array(
			'menu-item-title' => __('Dichiarazione di accessibilità', "avanguardie"),
			'menu-item-url' => "",
			'menu-item-status' => 'publish',
			'menu-item-type' => 'custom',
            'menu-item-classes' => 'footer-link',
		));

        $locations_primary_arr = get_theme_mod('nav_menu_locations');
        $locations_primary_arr["menu-footer"] = $menu->term_id;
        set_theme_mod('nav_menu_locations', $locations_primary_arr);
    }
    

    update_option("av_has_installed", true);
}


function av_add_update_theme_page() {
    add_theme_page( 'Ricarica i dati', 'Ricarica i dati', 'edit_theme_options', 'reload-data-theme-options', 'av_reload_theme_option_page' );
}
add_action( 'admin_menu', 'av_add_update_theme_page' );

function av_reload_theme_option_page() {
    if(isset($_GET["action"]) && $_GET["action"] == "reload"){
        av_create_pages_on_theme_activation();
    }

    echo "<div class='wrap'>";
    echo '<h1>Ricarica i dati di attivazione del tema</h1>';

    echo '<a href="themes.php?page=reload-data-theme-options&action=reload" class="button button-primary">Ricarica i dati di attivazione (menu, tipologie, etc)</a>';
    echo "</div>";
}