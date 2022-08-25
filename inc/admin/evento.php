<?php

/**
 * Definisce post type e tassonomie relative ad un evento
 */
add_action( 'init', 'av_register_evento_post_type', 0 );
function av_register_evento_post_type() {

	/** evento **/
	$labels = array(
		'name'                  => _x( 'Eventi', 'Post Type General Name', 'avanguardie' ),
		'singular_name'         => _x( 'Evento', 'Post Type Singular Name', 'avanguardie' ),
		'add_new'               => _x( 'Aggiungi un Evento', 'Post Type Singular Name', 'avanguardie' ),
		'add_new_item'               => _x( 'Aggiungi un Evento', 'Post Type Singular Name', 'avanguardie' ),
		'featured_image' => __( 'Immagine Identificativa del Evento', 'avanguardie' ),
		'edit_item'      => _x( 'Modifica Evento', 'Post Type Singular Name', 'avanguardie' ),
		'view_item'      => _x( 'Visualizza Evento', 'Post Type Singular Name', 'avanguardie' ),
		'set_featured_image' => __( 'Seleziona Immagine Evento' ),
		'remove_featured_image' => __( 'Rimuovi Immagine Evento' , 'avanguardie' ),
		'use_featured_image' => __( 'Usa come Immagine Evento' , 'avanguardie' ),
	);
	$args = array(
		'label'                 => __( 'Evento', 'avanguardie' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
//		'taxonomies'            => array( 'tipologia' ),
		'hierarchical'          => false,
		'public'                => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-calendar-alt',
		'has_archive'           => true,
        'capability_type' => array('evento', 'eventi'),
        'map_meta_cap'    => true,
        'description'    => __( "Il calendario degli eventi del progetto", 'avanguardie' ),

    );
	register_post_type( 'evento', $args );

	$labels = array(
		'name'              => _x( 'Tipologia Evento', 'taxonomy general name', 'avanguardie' ),
		'singular_name'     => _x( 'Tipologia Evento', 'taxonomy singular name', 'avanguardie' ),
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
		'rewrite'           => array( 'slug' => 'tipologia-evento' ),
        'capabilities'      => array(
            'manage_terms'  => 'manage_tipologia_eventi',
            'edit_terms'    => 'edit_tipologia_eventi',
            'delete_terms'  => 'delete_tipologia_eventi',
            'assign_terms'  => 'assign_tipologia_eventi'
        )
	);

	register_taxonomy( 'tipologia-evento', array( 'evento' ), $args );


}




/**
 * Crea i metabox del post type eventi
 */
add_action( 'cmb2_init', 'av_add_eventi_metaboxes' );
function av_add_eventi_metaboxes() {
	$prefix = '_av_evento_';

	$cmb_sottotitolo = new_cmb2_box( array(
		'id'           => $prefix . 'box_sottotitolo',
//		'title'        => __( 'Sottotitolo', 'avanguardie' ),
		'object_types' => array( 'evento' ),
		'context'      => 'after_title',
		'priority'     => 'high',
	) );


	$cmb_sottotitolo->add_field( array(
		'id' => $prefix . 'descrizione',
		'name'        => __( 'Descrizione *', 'avanguardie' ),
		'desc' => __( 'Indicare una sintetica descrizione del Evento. Vincoli: 160 caratteri spazi inclusi.' , 'avanguardie' ),
		'type' => 'textarea',
		'attributes'    => array(
			'maxlength'  => '160',
			'required' => 'required'
		),
	) );
	
	

	$cmb_sottotitolo->add_field( array(
		'id' =>  $prefix . 'nome_luogo_custom',
		'name'    => __( 'Nome del luogo ', 'avanguardie' ),
		'desc' => __( 'Inserisci il nome del luogo (lascia vuoto hai selezionato un Luogo della Scuola )' , 'avanguardie' ),
		'type'    => 'text',
        'attributes'    => array(
            'data-conditional-id'     => $prefix.'is_luogo_scuola',
            'data-conditional-value'  => "false",
        ),
	) );


	$cmb_sottotitolo->add_field( array(
		'id'         => $prefix . 'indirizzo_luogo_custom',
		'name'       => __( 'Indirizzo Completo ', 'avanguardie' ),
		'desc'       => __( 'Indirizzo completo del luogo: Via, civico, cap, città e Provincia (es: Via Vaglia, 6, 00139 - Roma RM) (lascia vuoto hai selezionato un Luogo della Scuola )', 'avanguardie' ),
		'type'       => 'text',
        'attributes'    => array(
            'data-conditional-id'     => $prefix.'is_luogo_scuola',
            'data-conditional-value'  => "false",
        ),
	) );


	$cmb_sottotitolo->add_field( array(
		'id'         => $prefix . 'posizione_gps_luogo_custom',
        'name'       => __( 'Posizione GPS <br><small>NB: clicca sulla lente di ingandimento e cerca l\'indirizzo, anche se lo hai già inserito nel campo precedente.<br>Questo permetterà una corretta georeferenziazione del luogo</small>', 'avanguardie' ),
		'desc'       => __( 'Georeferenziazione del luogo e link a posizione in mappa.  (lascia vuoto hai selezionato un Luogo della Scuola )', 'avanguardie' ),
		'type'       => 'leaflet_map',
		'attributes' => array(
//			'tilelayer'           => 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
			'searchbox_position'  => 'topleft', // topright, bottomright, topleft, bottomleft,
			'search'              => __( 'Digita l\'indirizzo del Luogo' , 'avanguardie' ),
			'not_found'           => __( 'Indirizzo non trovato' , 'avanguardie' ),
			'initial_coordinates' => [
				'lat' => 41.894802, // Go Italy!
				'lng' => 12.4853384  // Go Italy!
			],
			'initial_zoom'        => 5, // Zoomlevel when there's no coordinates set,
			'default_zoom'        => 12, // Zoomlevel after the coordinates have been set & page saved
			'required'    => 'required',
            'data-conditional-id'     => $prefix.'is_luogo_scuola',
            'data-conditional-value'  => "false",

		)
	) );


	$cmb_sottotitolo->add_field( array(
		'id'         => $prefix . 'quartiere_luogo_custom',
		'name'       => __( 'Quartiere ', 'avanguardie' ),
		'desc'       => __( 'Se il territorio è mappato in quartieri, riportare il Quartiere dove si svolge l\'evento (lascia vuoto hai selezionato un Luogo della Scuola )', 'avanguardie' ),
		'type'       => 'text',
        'attributes'    => array(
            'data-conditional-id'     => $prefix.'is_luogo_scuola',
            'data-conditional-value'  => "false",
        ),
	) );


	$cmb_sottotitolo->add_field( array(
		'id'         => $prefix . 'circoscrizione_luogo_custom',
		'name'       => __( 'Circoscrizione', 'avanguardie' ),
		'desc'       => __( 'Se il territorio è mappato in circoscrizioni, riportare la Circoscrizione dove si svolge l\'evento (lascia vuoto hai selezionato un Luogo della Scuola )', 'avanguardie' ),
		'type'       => 'text',
        'attributes'    => array(
            'data-conditional-id'     => $prefix.'is_luogo_scuola',
            'data-conditional-value'  => "false",
        ),
	) );



	$cmb_undercontent = new_cmb2_box( array(
		'id'           => $prefix . 'box_elementi_evento',
		'title'         => __( 'Dettagli Evento', 'avanguardie' ),
		'object_types' => array( 'evento' ),
		'context'      => 'normal',
		'priority'     => 'high',
	) );


    $group_field_id = $cmb_undercontent->add_field( array(
        'id'          => $prefix . 'date',
        'name'        => __('<h1>Date</h1>' , 'avanguardie' ),
        'type'        => 'group',
        'description' => __( 'Se l\'evento si svolge in più giorni o fasi indica qui di seguito i diversi appuntamenti. Es: inizo attività, pausa pranzo, seconda sessione, etc', 'avanguardie' ),
        'options'     => array(
            'group_title'    => __( 'Fase {#}', 'avanguardie' ), // {#} gets replaced by row number
            'add_button'     => __( 'Aggiungi una data evento', 'avanguardie' ),
            'remove_button'  => __( 'Rimuovi', 'avanguardie' ),
            'sortable'       => true,
            'closed'      => false, // true to have the groups closed by default
            //'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),

    ) );


    $cmb_undercontent->add_group_field( $group_field_id,  array(
        'id'      => 'data',
        'after'    => __( '<br>Data / orario ', 'avanguardie' ),
        'type' => 'text_datetime_timestamp',
        'date_format' => 'd-m-Y',
    ) );

    $cmb_undercontent->add_group_field( $group_field_id,  array(
        'id'      => 'descrizione',
        'desc'    => __( 'Descrizione', 'avanguardie' ),
        'type'             => 'textarea_small',
        'attributes'  => array(
            'rows'        => 3,
        ),

    ) );

    $cmb_undercontent->add_field( array(
        'id' => $prefix . 'link_schede_notizia',
        'name'    => __( 'Per approfondire', 'avanguardie' ),
        'description' => __( 'Link alla notizia' , 'avanguardie' ),
        'type'    => 'pw_multiselect',
        'options' =>  av_get_approfondimenti_options(),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona articoli di approfondimento', 'avanguardie' ),
        ),
    ) );

	$cmb_undercontent->add_field( array(
		'id'         => $prefix . 'gallery',
		'name'       => __( 'Galleria', 'avanguardie' ),
		'desc'       => __( 'Galleria di immagini', 'avanguardie' ),
		'type' => 'file_list',
		// 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
		'query_args' => array( 'type' => 'image' ), // Only images attachment
	) );

	$cmb_undercontent->add_field( array(
		'id'         => $prefix . 'video',
		'name'       => __( 'Video', 'avanguardie' ),
		'desc'       => __( 'Inserisci la url di un servizio di streaming video (es: youtube, vimeo) - Qui la lista: <a href="https://codex.wordpress.org/Embeds">https://codex.wordpress.org/Embeds</a>', 'avanguardie' ),
		'type' => 'oembed',

	) );


	


	$cmb_undercontent->add_field( array(
		'id'      => $prefix . 'tipo_evento',
		'name'    => __( 'Tipo evento *', 'avanguardie' ),
		'desc'    => __( 'Gratuito/ a pagamento', 'avanguardie' ),
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'gratis' => __( 'Gratuito', 'avanguardie' ),
			'pagamento'   => __( 'A Pagamento', 'avanguardie' )
		),
		'attributes' => array(
			'required' => 'required'
		),
	) );


	$group_field_id = $cmb_undercontent->add_field( array(
		'id'          => $prefix . 'prezzo',
		'name'        => __('<h1>Prezzo</h1>' , 'avanguardie' ),
		'type'        => 'group',
		'description' => __( 'Biglietto intero - prezzo - testo che spiega le condizioni / Biglietto ridotto - prezzo - testo che spiega le condizioni / Biglietto gratuito - gratis - testo che spiega le condizioni', 'avanguardie' ),
		'options'     => array(
			'group_title'    => __( 'Prezzo {#}', 'avanguardie' ), // {#} gets replaced by row number
			'add_button'     => __( 'Aggiungi una fascia di prezzo', 'avanguardie' ),
			'remove_button'  => __( 'Rimuovi', 'avanguardie' ),
			'sortable'       => true,
			'closed'      => false, // true to have the groups closed by default
			//'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
		),
		'attributes'    => array(
			'data-conditional-id'     => $prefix.'tipo_evento',
			'data-conditional-value'  => "pagamento",
		),
	) );


	$cmb_undercontent->add_group_field( $group_field_id,  array(
		'id'      => 'tipo_biglietto',
		'name'    => __( 'Nome della tipologia di biglietto (Intero, Ridotto)', 'avanguardie' ),
		'type'             => 'text',
	) );

	$cmb_undercontent->add_group_field( $group_field_id,  array(
		'id'      => 'prezzo',
		'name'    => __( 'Prezzo', 'avanguardie' ),
		'type'             => 'text_money',
		'before_field' => '&euro;',
	) );
	$cmb_undercontent->add_group_field( $group_field_id,  array(
		'id'      => 'descrizione',
		'name'    => __( 'Descrizione della tipologia di biglietto.<br>Se si desidera inserire un video di YouTube è necessaria l\'opzione "Enable privacy-enhanced mode" che permette di pubblicare il video in modalità youtube-nocookie. ', 'avanguardie' ),
		'type'    => 'wysiwyg',
		'options' => array(
			'media_buttons' => false, // show insert/upload button(s)
			'textarea_rows' => 4, // rows="..."
			'teeny' => true, // output the minimal editor config used in Press This
		),
	) );
	

	$cmb_undercontent->add_field( array(
			'id' => $prefix . 'contatto_telefono',
			'name'       => __('Contatto: telefono ', 'avanguardie' ),
			'desc' => __( 'Se non è un evento della scuola, inserire Numero di telefono per avere informazioni sull\'Evento', 'avanguardie' ),
			'type'    => 'text',
			'attributes'    => array(
				'data-conditional-id'     => $prefix.'organizzato_da_scuola',
				'data-conditional-value'  => "no",
			),
		)
	);
	$cmb_undercontent->add_field( array(
			'id' => $prefix . 'contatto_email',
			'name'       => __('Contatto: email ', 'avanguardie' ),
			'desc' => __( 'se non è un evento della scuola, Indirizzo email per avere informazioni sull\'Evento', 'avanguardie' ),
			'type'    => 'text_email',
			'attributes'    => array(
				'data-conditional-id'     => $prefix.'organizzato_da_scuola',
				'data-conditional-value'  => "no",
			),
		)
	);


	$cmb_undercontent->add_field( array(
			'id' => $prefix . 'website',
			'name'       => __('Sito web ', 'avanguardie' ),
			'desc' => __( 'Inserire il sito web dedicato all\'evento o della società che organizza l\'evento', 'avanguardie' ),
			'type'    => 'text_url'
		)
	);

	$cmb_undercontent->add_field( array(
			'id' => $prefix . 'patrocinato',
			'name'       => __('Patrocinato da ', 'avanguardie' ),
			'desc' => __( 'Soggetto che patrocinia l\'evento', 'avanguardie' ),
			'type'    => 'text'
		)
	);
	$cmb_undercontent->add_field( array(
			'id' => $prefix . 'sponsor',
			'name'       => __('Sponsor', 'avanguardie' ),
			'desc' => __( 'Sponsor dell\'evento', 'avanguardie' ),
			'type'    => 'text'
		)
	);

	$cmb_undercontent->add_field( array(
		'id' => $prefix . 'link_schede_documenti',
		'name'    => __( 'Documenti', 'avanguardie' ),
		'desc' => __( 'Inserisci qui tutti i documenti che ritieni rilevanti per l\'evento. Se devi caricare il documento <a href="post-new.php?post_type=documento">puoi creare una breve scheda di presentazione</a> (soluzione consigliata e più efficace per gli utenti del sito) oppure caricarlo direttamente nei campi che seguono. ' , 'avanguardie' ),
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
		'desc' => __( 'Se l\'allegato non è descritto da una scheda documento, link all\'allegato (es. link a una locandina). ' , 'avanguardie' ),
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



	$cmb_side = new_cmb2_box( array(
		'id'           => $prefix . 'box_side',
		'title'        => __( 'Data inizio e fine evento *', 'avanguardie' ),
        'object_types' => array( 'evento' ),
		'context'      => 'side',
		'priority'     => 'high',
	) );

    $timestamp_inizio = $timestamp_fine = "";
	if( ( isset($_GET) ) && array_key_exists('post',$_GET) &&  isset($_GET['post']) & is_numeric($_GET['post']) ) {
        $post_id = absint($_GET['post']);
        $timestamp_inizio = av_get_meta("timestamp_inizio", $prefix, $post_id);
        $timestamp_fine= av_get_meta("timestamp_fine", $prefix,$post_id);
    }

	$inizio = array(
        'id'         => $prefix . 'timestamp_inizio',
        'before' => 'Data Inizio Evento<br>',
        'type' => 'text_date_timestamp',
        'date_format' => 'd-m-Y',
        'attributes' => array(
            'required' => 'required',
            'autocomplete' => 'off'
        ),
        'column' => array(
            'position' => 2,
            'name'     => 'Inizio Evento',
        ),
    );

    if($timestamp_fine !== "") {
        $inizio['attributes']['data-datepicker'] = json_encode( array(
                'maxDate' => date("d-m-Y", $timestamp_fine),
            )
        );
    }

    $cmb_side->add_field( $inizio );

    $fine = array(
        'id'         => $prefix . 'timestamp_fine',
        'before' => 'Data Fine Evento<br>',
        'type' => 'text_date_timestamp',
        'date_format' => 'd-m-Y',
        'attributes' => array(
            'required' => 'required',
            'autocomplete' => 'off'
        ),
    ) ;

    if($timestamp_inizio !== "") {
        $fine['attributes']['data-datepicker'] = json_encode( array(
                'minDate' => date("d-m-Y", $timestamp_inizio),
            )
        );
    }

	$cmb_side->add_field( $fine );
}

/**
 * Aggiungo label sotto il titolo
 */
add_action( 'edit_form_after_title', 'sdi_evento_add_content_after_title' );
function sdi_evento_add_content_after_title($post) {
	if($post->post_type == "evento")
		_e('<span><i>il <b>Titolo</b> è il <b>Nome dell\'Evento</b></span><br><br>', 'avanguardie' );
}

/**
 * Aggiungo testo prima del content
 */
add_action( 'edit_form_after_title', 'sdi_evento_add_content_before_editor', 100 );
function sdi_evento_add_content_before_editor($post) {
	if($post->post_type == "evento")
		_e('<h1>Descrizione Estesa dell\'evento</h1>', 'avanguardie' );
}


/**
 * Aggiungo testo dopo l'editor
 */
add_action( 'edit_form_after_editor', 'sdi_evento_add_content_after_editor', 100 );
function sdi_evento_add_content_after_editor($post) {
    if($post->post_type == "evento")
        _e('<br>Se si desidera inserire un video di YouTube è necessaria l\'opzione "Enable privacy-enhanced mode" che permette di pubblicare il video in modalità youtube-nocookie.<br><br>', 'avanguardie' );
}

/**
 * aggiungo js per condizionale parent
 */
add_action( 'admin_print_scripts-post-new.php', 'av_evento_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'av_evento_admin_script', 11 );

function av_evento_admin_script() {
    global $post_type;
    if( 'evento' == $post_type )
        wp_enqueue_script( 'luogo-admin-script', get_stylesheet_directory_uri() . '/inc/admin-js/evento.js' );
}
