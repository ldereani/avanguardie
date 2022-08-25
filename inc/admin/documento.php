<?php
/**
 * Definisce post type e tassonomie relative ai documenti
 */
add_action( 'init', 'av_register_documento_post_type');
function av_register_documento_post_type() {

    /** documenti **/
    $labels = array(
        'name'          => _x( 'Documenti', 'Post Type General Name', 'avanguardie' ),
        'singular_name' => _x( 'Documento', 'Post Type Singular Name', 'avanguardie' ),
        'add_new'       => _x( 'Aggiungi un Documento', 'Post Type Singular Name', 'avanguardie' ),
        'add_new_item'  => _x( 'Aggiungi un Documento', 'Post Type Singular Name', 'avanguardie' ),
        'edit_item'       => _x( 'Modifica il Documento', 'Post Type Singular Name', 'avanguardie' ),
    );
    $args   = array(
        'label'         => __( 'Documento', 'avanguardie' ),
        'labels'        => $labels,
        'supports'      => array( 'title', 'editor' , 'thumbnail' ),
        'taxonomies'    => array( 'tipologia' ),
        'hierarchical'  => false,
        'public'        => true,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-portfolio',
        'has_archive'   => true,
        'capability_type' => array('documento', 'documenti'),
        'map_meta_cap'    => true,
    );
    register_post_type( 'documento', $args );

    $labels = array(
        'name'              => _x( 'Tipologia Documento', 'taxonomy general name', 'avanguardie' ),
        'singular_name'     => _x( 'Tipologia Documento', 'taxonomy singular name', 'avanguardie' ),
        'search_items'      => __( 'Cerca Tipologia', 'avanguardie' ),
        'all_items'         => __( 'Tutte le tipologie', 'avanguardie' ),
        'edit_item'         => __( 'Modifica la Tipologia', 'avanguardie' ),
        'update_item'       => __( 'Aggiorna la Tipologia', 'avanguardie' ),
        'add_new_item'      => __( 'Aggiungi una Tipologia', 'avanguardie' ),
        'new_item_name'     => __( 'Nuova Tipologia', 'avanguardie' ),
        'menu_name'         => __( 'Tipologia', 'avanguardie' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'tipologia-documento' ),
        'capabilities'      => array(
            'manage_terms'  => 'manage_tipologia_documenti',
            'edit_terms'    => 'edit_tipologia_documenti',
            'delete_terms'  => 'delete_tipologia_documenti',
            'assign_terms'  => 'assign_tipologia_documenti'
        )
    );

    register_taxonomy( 'tipologia-documento', array( 'documento' ), $args );


    register_taxonomy_for_object_type( 'post_tag', 'documento' );

}

/**
 * Crea i metabox del post type eventi
 */
add_action( 'cmb2_init', 'av_add_documento_metaboxes' );
function av_add_documento_metaboxes() {

    $prefix = '_av_documento_';



    $cmb_tipologia = new_cmb2_box( array(
        'id'           => $prefix . 'box_tipologia',
        'title'        => __( 'Tipologia', 'avanguardie' ),
        'object_types' => array( 'documento' ),
        'context'      => 'side',
        'priority'     => 'high',
    ) );


    $cmb_tipologia->add_field( array(
        'id' => $prefix . 'tipologia',
        'type'             => 'taxonomy_radio_hierarchical',
        'taxonomy'       => 'tipologia-documento',
        'show_option_none' => false,
        'remove_default' => 'true',
        'default'          => 'documento-generico',
        'attributes' => array(
            'required'  => 'required'
        ),
    ) );


    $cmb_sottotitolo = new_cmb2_box( array(
        'id'           => $prefix . 'box_sottotitolo',
//		'title'        => __( 'Sottotitolo', 'avanguardie' ),
        'object_types' => array( 'documento' ),
        'context'      => 'after_title',
        'priority'     => 'high',
    ) );


    $cmb_sottotitolo->add_field( array(
        'id'         => $prefix . 'descrizione',
        'name'       => __( 'Descrizione *', 'avanguardie' ),
        'desc'       => __( 'Indicare una sintetica descrizione del Documento. Vincoli: 160 caratteri spazi inclusi.', 'avanguardie' ),
        'type'       => 'textarea',
        'attributes' => array(
            'maxlength' => '160',
            'required'  => 'required'
        ),
    ) );

 

    $cmb_aftercontent = new_cmb2_box( array(
        'id'           => $prefix . 'box_elementi_dati',
        'title'        => __( 'Dati Pubblici', 'avanguardie' ),
        'object_types' => array( 'documento' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );


    $cmb_aftercontent->add_field( array(
        'id' => $prefix . 'file_documenti',
        'name'    => __( 'Carica file', 'avanguardie' ),
        'desc' => __( 'Lista di documenti allegati' , 'avanguardie' ),
        'type' => 'file_list',
        // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
        // 'query_args' => array( 'type' => 'image' ), // Only images attachment
        // Optional, override default text strings
        'text' => array(
            'add_upload_files_text' => __('Aggiungi un nuovo allegato', 'avanguardie' ), // default: "Add or Upload Files"
            'remove_image_text' => __('Rimuovi allegato', 'avanguardie' ), // default: "Remove Image"
            'remove_text' => __('Rimuovi', 'avanguardie' ), // default: "Remove"
        ),
    ) );



    $cmb_aftercontent->add_field( array(
        'id'         => $prefix . 'gallery',
        'name'       => __( 'Galleria', 'avanguardie' ),
        'desc'       => __( 'Galleria di immagini  significative relative a un documento, corredate da didascalia', 'avanguardie' ),
        'type' => 'file_list',
        // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
        'query_args' => array( 'type' => 'image' ), // Only images attachment
    ) );








}




/**
 * Aggiungo label sotto il titolo
 */
add_action( 'edit_form_after_title', 'sdi_documento_add_content_after_title' );
function sdi_documento_add_content_after_title($post) {
    if($post->post_type == "documento")
        _e('<span><i>il <b>Titolo</b> è il <b>Nome del Documento</b></span><br><br>', 'avanguardie' );
}


/**
 * Aggiungo testo dopo l'editor
 */
add_action( 'edit_form_after_editor', 'sdi_documento_add_content_after_editor', 100 );
function sdi_documento_add_content_after_editor($post) {
    if($post->post_type == "documento")
        _e('<br>Se si desidera inserire un video di YouTube è necessaria l\'opzione "Enable privacy-enhanced mode" che permette di pubblicare il video in modalità youtube-nocookie.<br><br>', 'avanguardie' );
}


/**
 * Aggiungo testo prima del content
 */
add_action( 'edit_form_after_title', 'sdi_documento_add_content_before_editor', 100 );
function sdi_documento_add_content_before_editor($post) {
    if($post->post_type == "documento")
        _e('<h1>Descrizione Estesa del Documento</h1>', 'avanguardie' );
}
