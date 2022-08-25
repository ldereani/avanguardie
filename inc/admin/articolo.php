<?php
add_action( 'init', 'av_register_articolo_post_tax', 0 );
function av_register_articolo_post_tax() {

	$labels = array(
		'name'              => _x( 'Tipologia Articolo ', 'taxonomy general name', 'avanguardie' ),
		'singular_name'     => _x( 'Tipologia Articolo', 'taxonomy singular name', 'avanguardie' ),
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
		'rewrite'           => array( 'slug' => 'tipologia-articolo' ),
        'capabilities'      => array(
            'manage_terms'  => 'manage_tipologia_articoli',
            'edit_terms'    => 'edit_tipologia_articoli',
            'delete_terms'  => 'delete_tipologia_articoli',
            'assign_terms'  => 'assign_tipologia_articoli'
        )
	);

	register_taxonomy( 'tipologia-articolo', array( 'post' ), $args );

}

/**
 * Crea i metabox del post type post
 */
add_action( 'cmb2_init', 'av_add_articolo_metaboxes' );
function av_add_articolo_metaboxes() {

	$prefix = '_av_articolo_';


    $cmb_abstrat = new_cmb2_box( array(
        'id'           => $prefix . 'box_abstract',
        'object_types' => array( 'post' ),
        'context'      => 'after_title',
        'priority'     => 'high',
    ) );

    $cmb_abstrat->add_field( array(
        'id' => $prefix . 'tipologia',
        'name'        => __( 'Tipologia articolo *', 'avanguardie' ),
        'type'             => 'taxonomy_radio_inline',
        'show_option_none' => false,
        'taxonomy'       => 'tipologia-articolo',
        'remove_default' => 'true',
        'default' => "notizie",
        'attributes' => array(
            'required' => 'required'
        ),
    ) );


    $cmb_abstrat->add_field( array(
        'id' => $prefix . 'descrizione',
        'name'        => __( 'Abstract', 'avanguardie' ),
        'desc' => __( 'Indicare un sintetico abstract (max 160 caratteri)' , 'avanguardie' ),
        'type' => 'textarea',
        'attributes'    => array(
            'maxlength'  => '160'
        ),
    ) );

    $cmb_undercontent = new_cmb2_box( array(
		'id'           => $prefix . 'box_elementi_articolo',
		'title'         => __( 'Dettagli Articolo', 'avanguardie' ),
		'object_types' => array( 'post' ),
		'context'      => 'normal',
		'priority'     => 'high',
	) );
	


	$cmb_undercontent->add_field( array(
		'id' => $prefix . 'link_schede_documenti',
		'name'    => __( 'Documenti', 'avanguardie' ),
		'desc' => __( 'Inserisci qui tutti i documenti che ritieni rilevanti. Se devi caricare il documento <a href="post-new.php?post_type=documento">puoi creare una breve scheda di presentazione</a> (soluzione consigliata e più efficace per gli utenti del sito) oppure caricarlo direttamente nei campi che seguono. ' , 'avanguardie' ),
		'type'    => 'custom_attached_posts',
		'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
		'options' => array(
			'show_thumbnails' => false, // Show thumbnails on the left
			'filter_boxes'    => true, // Show a text box for filtering the results
			'query_args'      => array(
				'posts_per_page' => 10,
				'post_type'      => 'documento',
			), // override the get_posts args
		),
	) );


	$cmb_undercontent->add_field( array(
		'id' => $prefix . 'file_documenti',
		'name'    => __( 'Carica documenti', 'avanguardie' ),
		'desc' => __( 'Se l\'allegato non è descritto da una scheda documento, link all\'allegato. ' , 'avanguardie' ),
		'type' => 'file_list',
		// 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
		// 'query_args' => array( 'type' => 'image' ), // Only images attachment
		// Optional, override default text strings
		'text' => array(
			'add_upload_files_text' => __('Aggiungi un nuovo Documento', 'avanguardie' ), // default: "Add or Upload Files"
			'remove_image_text' => __('Rimuovi Documento', 'avanguardie' ), // default: "Remove Image"
			'remove_text' => __('Rimuovi', 'avanguardie' ), // default: "Remove"
		),
	) );

}


/**
 * Aggiungo testo dopo l'editor
 */
add_action( 'edit_form_after_editor', 'sdi_articolo_add_content_after_editor', 100 );
function sdi_articolo_add_content_after_editor($post) {
    if($post->post_type == "post")
        _e('<br>Se si desidera inserire un video di YouTube è necessaria l\'opzione "Enable privacy-enhanced mode" che permette di pubblicare il video in modalità youtube-nocookie.<br><br>', 'avanguardie' );
}