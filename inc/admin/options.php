<?php
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function av_register_main_options_metabox() {
	$prefix = '';

	$args = array(
		'id'           => 'av_options_header',
		'title'        => esc_html__( 'Configurazione', 'avanguardie' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'av_options',
		'tab_group'    => 'av_options',
		'tab_title'    => __('Opzioni di base', "avanguardie"),
        'capability'    => 'manage_options',
		'position'        => 2, // Menu position. Only applicable if 'parent_slug' is left empty.
		'icon_url'        => 'dashicons-admin-tools', // Menu icon. Only applicable if 'parent_slug' is left empty.
	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'av_options_display_with_tabs';
	}

	$header_options = new_cmb2_box( $args );

    $header_options->add_field( array(
        'id' => $prefix . 'home_istruzioni',
        'name'        => __( 'Configurazione Sito', 'avanguardie' ),
        'desc' => __( 'Area di configurazione delle informazioni di base' , 'avanguardie' ),
        'type' => 'title',
    ) );

    $header_options->add_field( array(
		'id' => $prefix . 'sottotitolo',
		'name'        => __( 'Sottotitolo ', 'avanguardie' ),
		'desc' => __( 'Sottotitolo del progetto.' , 'avanguardie' ),
		'type' => 'text',
		'attributes'    => array(
			'required'    => 'required'
		),
	) );

	$header_options->add_field( array(
		'id' => $prefix . 'nome_progetto',
		'name'        => __( 'Nome Progetto *', 'avanguardie' ),
		'desc' => __( 'Il Nome del Progetto' , 'avanguardie' ),
		'type' => 'text',
		'attributes'    => array(
			'required'    => 'required'
		),
	) );

	$header_options->add_field( array(
		'id' => $prefix . 'motto',
		'name'        => __( 'Motto', 'avanguardie' ),
		'desc' => __( 'Breve descrizione' , 'avanguardie' ),
		'type' => 'text',
		'attributes'    => array(
			'required'    => 'required'
		),
	) );
    /**
     * Registers options page "Alerts".
     */

    $args = array(
        'id'           => 'av_options_messages',
        'title'        => esc_html__( 'Messaggi', 'avanguardie' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'home_messages',
        'capability'    => 'manage_options',
        'parent_slug'  => 'av_options',
        'tab_group'    => 'av_options',
        'tab_title'    => __('Avvisi in Home', "avanguardie"),	);

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'av_options_display_with_tabs';
    }

    $alerts_options = new_cmb2_box( $args );

    $alerts_options->add_field( array(
        'id' => $prefix . 'messages_istruzioni',
        'name'        => __( 'Avvisi di allerta in home page', 'avanguardie' ),
        'desc' => __( 'Inserisci messaggi che saranno visualizzati nella homepage.' , 'avanguardie' ),
        'type' => 'title',
    ) );

    $alerts_group_id = $alerts_options->add_field( array(
        'id'           => $prefix . 'messages',
        'type'        => 'group',
        'desc' => __( 'Ogni messaggio è costruito attraverso descrizione breve (max 140 caratteri) e data di scadenza (opzionale).' , 'avanguardie' ),
        'repeatable'  => true,
        'options'     => array(
            'group_title'   => __( 'Messaggio {#}', 'avanguardie' ),
            'add_button'    => __( 'Aggiungi un messaggio', 'avanguardie' ),
            'remove_button' => __( 'Rimuovi il messaggio', 'avanguardie' ),
            'sortable'      => true,  // Allow changing the order of repeated groups.
        ),
    ) );

    $alerts_options->add_group_field( $alerts_group_id, array(
        'name'    => 'Selezione colore del messaggio',
        'id'      => 'colore_message',
        'type'    => 'radio_inline',
        'options' => array(
            'red'   => __( '<span class="radio-color red"></span>Rosso', 'avanguardie' ),
            'yellow' => __( '<span class="radio-color yellow"></span>Giallo', 'avanguardie' ),
            'green'     => __( '<span class="radio-color green"></span>Verde', 'avanguardie' ),
            'blue'     => __( '<span class="radio-color blue"></span>Blu', 'avanguardie' ),
            'purple'     => __( '<span class="radio-color purple"></span>Viola', 'avanguardie' ),
        ),
        'default' => 'yellow',
    ) );

    $alerts_options->add_group_field( $alerts_group_id, array(
        'name' => 'Visualizza icona',
        'id'   => 'icona_message',
        'type' => 'checkbox',
    ) );

    $alerts_options->add_group_field( $alerts_group_id, array(
        'id' => $prefix . 'data_message',
        'name'        => __( 'Data fine', 'avanguardie' ),
        'type' => 'text_date',
        'date_format' => 'd-m-Y',
        'data-datepicker' => json_encode( array(
            'yearRange' => '-100:+0',
        ) ),
    ) );

    $alerts_options->add_group_field( $alerts_group_id, array(
        'id' => $prefix . 'testo_message',
        'name'        => __( 'Testo', 'avanguardie' ),
        'desc' => __( 'Massimo 140 caratteri' , 'avanguardie' ),
        'type' => 'textarea_small',
        'attributes'    => array(
            'rows'  => 3,
            'maxlength'  => '140',
        ),
    ) );

    $alerts_options->add_group_field( $alerts_group_id, array(
        'id' => $prefix . 'link_message',
        'name'        => __( 'Collegamento', 'avanguardie' ),
        'desc' => __( 'Link al una pagina di approfondimento anche esterna al sito' , 'avanguardie' ),
        'type' => 'text_url',
    ) );


    /**
     * Registers options page "Home".
     */

    $args = array(
        'id'           => 'av_options_home',
        'title'        => esc_html__( 'Home Page', 'avanguardie' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'homepage',
        'capability'    => 'manage_options',
        'parent_slug'  => 'av_options',
        'tab_group'    => 'av_options',
        'tab_title'    => __('Home', "avanguardie"),	);

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'av_options_display_with_tabs';
    }

    $home_options = new_cmb2_box( $args );

/*
    $home_options->add_field( array(
        'id' => $prefix . 'home_istruzioni_0',
        'name'        => __( 'La Scuola', 'avanguardie' ),
        'type' => 'title',
    ) );


    $home_options->add_field(  array(
        'id' => $prefix.'scuola_principale',
        'name'    => __( 'Seleziona la scuola da linkare in home page', 'avanguardie' ),
        'desc' => __( 'NB: La scuola è una <a href="edit.php?post_type=struttura">Struttura organizzativa</a> di tipologia "Scuola. Se non esiste creala prima <a href="edit.php?post_type=struttura">qui</a>"' , 'avanguardie' ),
        'type'    => 'pw_select',
        'options' => av_get_strutture_scuole_options(),
    ) );
*/


    $home_options->add_field( array(
        'id' => $prefix . 'home_istruzioni_1',
        'name'        => __( 'Sezione Notizie', 'avanguardie' ),
        'desc' => __( 'Gestione Notizie / Articoli / Eventi mostrati in home page' , 'avanguardie' ),
        'type' => 'title',
    ) );

    $home_options->add_field(array(
        'id' => $prefix . 'home_is_selezione_automatica',
        'name' => __('Selezione Automatica', 'avanguardie'),
        'desc' => __('Seleziona <b>Si</b> per mostrare automaticamente gli articoli in home page. Le colonne mostreranno l\'ultimo articolo delle tipologie selezionate nella <a href="admin.php?page=notizie">configurazione della Pagina "Novità"</a>,', 'avanguardie'),
        'type' => 'radio_inline',
        'default' => 'true',
        'options' => array(
            'true' => __('Si', 'avanguardie'),
            'false' => __('No', 'avanguardie'),
        ),
    ));

    $home_options->add_field(array(
            'name' => __('Selezione articoli ', 'avanguardie'),
            'desc' => __('Seleziona gli articoli da mostrare in Home Page. NB: Selezionane 3 o multipli di 3 per evitare buchi nell\'impaginazione.  ', 'avanguardie'),
            'id' => $prefix . 'home_articoli_manuali',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => false, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => -1,
                    'post_type'      => array('post', 'page', 'evento', 'circolare'),
                ), // override the get_posts args
            ),
            'attributes' => array(
                'data-conditional-id' => $prefix . 'home_is_selezione_automatica',
                'data-conditional-value' => "false",
            ),
        )
    );

    $home_options->add_field(array(
        'id' => $prefix . 'home_show_events',
        'name' => __('Mostra gli eventi in Home', 'avanguardie'),
        'desc' => __('Abilita gli eventi in Home e decidi come mostrarli', 'avanguardie'),
        'type' => 'radio_inline',
        'default' => 'false',
        'options' => array(
            'false' => __('No', 'avanguardie'),
            'true_event' => __('Si, mostra il prossimo evento', 'avanguardie'),
            // 'true_calendar' => __('Si, mostra il calendario', 'avanguardie'),
        ),
        'attributes' => array(
            'data-conditional-id' => $prefix . 'home_is_selezione_automatica',
            'data-conditional-value' => "true",
        ),
    ));

    $home_options->add_field( array(
        'id' => $prefix . 'home_istruzioni_banner',
        'name'        => __( 'Sezione Banner', 'avanguardie' ),
        'desc' => __( 'Gestione sezione Banner (opzionale) mostrata in home page' , 'avanguardie' ),
        'type' => 'title',
    ) );

    $home_options->add_field(  array(
        'id' => $prefix.'visualizza_banner',
        'name'    => __( 'Visualizza la fascia banner', 'avanguardie' ),
        'type'    => 'radio_inline',
        'options' => array(
            'si' => __( 'Si', 'avanguardie' ),
            'no'   => __( 'No', 'avanguardie' ),
        ),
        'default' => "no"
    ) );


    $bsnner_group_id = $home_options->add_field( array(
        'id'          =>  $prefix . 'banner_group',
        'type'        => 'group',
        'repeatable'  => true,
        'options'     => array(
            'group_title'   => 'Banner {#}',
            'add_button'    => 'Aggiungi un nuovo banner',
            'remove_button' => 'Rimuovi Banner',
            'closed'        => true,  // Repeater fields closed by default - neat & compact.
            'sortable'      => true,  // Allow changing the order of repeated groups.
        ),
    ) );

    $home_options->add_group_field( $bsnner_group_id, array(
        'name' => 'Banner',
        'id'   => 'banner',
        'type'    => 'file',
        'options' => array(
            'url' => false, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Aggiungi file' // Change upload button text. Default: "Add or Upload File"
        ),
        'query_args' => array(
             'type' => array(
             	'image/gif',
             	'image/jpeg',
             	'image/png',
             ),
        ),
        'preview_size' => 'banner',
    ) );

    $home_options->add_group_field( $bsnner_group_id, array(
        'name' => 'Url di destinazione',
        'desc' => 'Url di destinazione (lasciare vuoto se non necessario)',
        'id'   => 'url',
        'type' => 'text_url',
    ) );

    
    /**
	 * Registers Notizie option page.
	 */

	$args = array(
		'id'           => 'av_options_notizie',
		'title'        => esc_html__( 'Le Novità', 'avanguardie' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'notizie',
        'capability'    => 'manage_options',
        'parent_slug'  => 'av_options',
		'tab_group'    => 'av_options',
		'tab_title'    => __('Novità', "avanguardie"),	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'av_options_display_with_tabs';
	}

	$notizie_options = new_cmb2_box( $args );

    $notizie_landing_url = av_get_template_page_url("page-templates/notizie.php");
    $notizie_options->add_field( array(
        'id' => $prefix . 'notizie_istruzioni',
        'name'        => __( 'Sezione Le Novità', 'avanguardie' ),
        'desc' => __( 'Inserisci qui le informazioni utili a popolare <a href="'.$notizie_landing_url.'">la pagina di panoramica delle Novità</a>.' , 'avanguardie' ),
        'type' => 'title',
    ) );

    $notizie_options->add_field( array(
		'id' => $prefix . 'testo_notizie',
		'name'        => __( 'Descrizione Sezione', 'avanguardie' ),
		'desc' => __( 'es: "Le notizie del progetto AvanguardieVerdi"' , 'avanguardie' ),
		'type' => 'textarea',
		'attributes'    => array(
			'maxlength'  => '140'
		),
	) );

	$notizie_options->add_field( array(
			'name'       => __('Tipologie Articoli', 'avanguardie' ),
			'desc' => __( 'Articoli aggregati per tipologie (es: articoli, notizie), . Seleziona le tipologie da mostrare. ', 'avanguardie' ),
			'id' => $prefix . 'tipologie_notizie',
			'type'    => 'pw_multiselect',
			'options' => av_get_tipologia_articoli_options(),
			'attributes' => array(
				'placeholder' =>  __( 'Seleziona e ordina le tipologie di articoli da mostrare nella HomePage di sezione', 'avanguardie' ),
			),
		)
	);


    

    /**
     * Registers options page "Socials".
     */

    $args = array(
        'id'           => 'av_options_socials',
        'title'        => esc_html__( 'Socialmedia', 'avanguardie' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'socials',
        'capability'    => 'manage_options',
        'parent_slug'  => 'av_options',
        'tab_group'    => 'av_options',
        'tab_title'    => __('Socialmedia', "avanguardie"),	);

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'av_options_display_with_tabs';
    }

    $social_options = new_cmb2_box( $args );

    $social_options->add_field( array(
        'id' => $prefix . 'socials_istruzioni',
        'name'        => __( 'Sezione socialmedia', 'avanguardie' ),
        'desc' => __( 'Inserisci qui i link ai tuoi socialmedia.' , 'avanguardie' ),
        'type' => 'title',
    ) );

    $social_options->add_field(array(
        'id' => $prefix . 'show_socials',
        'name' => __('Mostra le icone social', 'avanguardie'),
        'desc' => __('Abilita la visualizzazione dei socialmedia nell\'header e nel footer della pagina.', 'avanguardie'),
        'type' => 'radio_inline',
        'default' => 'false',
        'options' => array(
            'true' => __('Si', 'avanguardie'),
            'false' => __('No', 'avanguardie'),
        ),
        'attributes' => array(
            'data-conditional-value' => "false",
        ),
    ));

    $social_options->add_field( array(
        'id' => $prefix . 'facebook',
        'name' => 'Facebook',
        'type' => 'text_url',
    ) );

    $social_options->add_field( array(
        'id' => $prefix . 'youtube',
        'name' => 'Youtube',
        'type' => 'text_url',
    ) );
    
    $social_options->add_field( array(
        'id' => $prefix . 'instagram',
        'name' => 'Instagram',
        'type' => 'text_url',
    ) );

    $social_options->add_field( array(
        'id' => $prefix . 'twitter',
        'name' => 'Twitter',
        'type' => 'text_url',
    ) );

    $social_options->add_field( array(
        'id' => $prefix . 'linkedin',
        'name' => 'Linkedin',
        'type' => 'text_url',
    ) );


    // pagina opzioni
	/**
	 * Registers main options page menu item and form.
	 */
	$args = array(
		'id'           => 'av_setup_menu',
		'title'        => esc_html__( 'Altro', 'avanguardie' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'setup',
		'tab_title'    => __('Altro', "avanguardie"),
		'parent_slug'  => 'av_options',
		'tab_group'    => 'av_options',
        'capability'    => 'manage_options',
    );

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'av_options_display_with_tabs';
	}

	$setup_options = new_cmb2_box( $args );

    $setup_options->add_field( array(
        'id' => $prefix . 'footer_options',
        'name'        => __( 'Footer', 'avanguardie' ),
        'desc' => __( 'Area di configurazione del testo da inserire nel footer delle scuole.' , 'avanguardie' ),
        'type' => 'title',
    ) );

    $setup_options->add_field( array(
        'id' => $prefix . 'footer_text',
        'name' => 'Testo Footer',
        'desc' => __( 'Inserisci nel footer l\'indirizzo, il codice meccanografico, il codice IPA, il codice Fiscale e il CUF ', 'avanguardie' ),
        'type' => 'textarea'
    ) );

    $setup_options->add_field( array(
        'id' => $prefix . 'altro_istruzioni',
        'name'        => __( 'Altre Informazioni', 'avanguardie' ),
        'desc' => __( 'Area di configurazione delle opzioni generali del tema.' , 'avanguardie' ),
        'type' => 'title',
    ) );

	$setup_options->add_field( array(
		'id' => $prefix . 'mapbox_key',
		'name' => 'Access Token MapBox',
		'desc' => __( 'Inserisci l\'access token mapbox per l\'erogazione delle mappe. Puoi crearlo <a target="_blank" href="https://www.mapbox.com/studio/account/tokens/">da qui</a>', 'avanguardie' ),
		'type' => 'text'
    ) );







    

}
add_action( 'cmb2_admin_init', 'av_register_main_options_metabox' );

/**
 * A CMB2 options-page display callback override which adds tab navigation among
 * CMB2 options pages which share this same display callback.
 *
 * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
 */
function av_options_display_with_tabs( $cmb_options ) {
	$tabs = av_options_page_tabs( $cmb_options );
	?>
	<div class="wrap cmb2-options-page option-<?php echo $cmb_options->option_key; ?>">
		<?php if ( get_admin_page_title() ) : ?>
			<h2><?php echo wp_kses_post( get_admin_page_title() ); ?></h2>
		<?php endif; ?>

        <div class="cmb2-options-box">
            <div class="nav-tab-wrapper">
                <?php foreach ( $tabs as $option_key => $tab_title ) : ?>
                    <a class="nav-tab<?php if ( isset( $_GET['page'] ) && $option_key === $_GET['page'] ) : ?> nav-tab-active<?php endif; ?>" href="<?php menu_page_url( $option_key ); ?>"><?php echo wp_kses_post( $tab_title ); ?></a>
                <?php endforeach; ?>
            </div>

            <form class="cmb-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST" id="<?php echo $cmb_options->cmb->cmb_id; ?>" enctype="multipart/form-data" encoding="multipart/form-data">
                <fieldset class="form-content">
                    <input type="hidden" name="action" value="<?php echo esc_attr( $cmb_options->option_key ); ?>">
                    <?php $cmb_options->options_page_metabox(); ?>
                </fieldset>

                <fieldset class="form-footer">
                    <div class="submit-box"><?php submit_button( esc_attr( $cmb_options->cmb->prop( 'save_button' ) ), 'primary', 'submit-cmb', false ); ?></div>
                </fieldset>
            </form>

            <div class="clear-form"></div>
        </div>
	</div>
	<?php
}

/**
 * Gets navigation tabs array for CMB2 options pages which share the given
 * display_cb param.
 *
 * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
 *
 * @return array Array of tab information.
 */
function av_options_page_tabs( $cmb_options ) {
	$tab_group = $cmb_options->cmb->prop( 'tab_group' );
	$tabs      = array();

	foreach ( CMB2_Boxes::get_all() as $cmb_id => $cmb ) {
		if ( $tab_group === $cmb->prop( 'tab_group' ) ) {
			$tabs[ $cmb->options_page_keys()[0] ] = $cmb->prop( 'tab_title' )
				? $cmb->prop( 'tab_title' )
				: $cmb->prop( 'title' );
		}
	}

	return $tabs;
}


function av_options_assets() {
    $current_screen = get_current_screen();

    if(strpos($current_screen->id, 'configurazione_page_') !== false || $current_screen->id === 'toplevel_page_av_options') {
        wp_enqueue_style( 'av_options_dialog', get_stylesheet_directory_uri() . '/inc/admin-css/jquery-ui.css' );
        wp_enqueue_script( 'av_options_dialog', get_stylesheet_directory_uri() . '/inc/admin-js/options.js', array('jquery', 'jquery-ui-core', 'jquery-ui-dialog'), '1.0', true );
    }
}
add_action( 'admin_enqueue_scripts', 'av_options_assets' );

if (! wp_next_scheduled ( 'av_cron_options' )) {
    wp_schedule_event(time(), 'daily', 'av_cron_options');
}
add_action('av_cron_options', 'av_check_cron_options');

function av_check_cron_options() {
    $update = false;
    $messages = av_get_option( "messages", "home_messages" );

    foreach ($messages as $key => $message) {
        $message_date = strtotime($message['data_message']);
        $now = strtotime("now");
        if($message_date <= $now) {
            $update = true;
            unset($messages[$key]);
        }
    }

    if($update) {
        $to_update['messages'] = array_values($messages);
        update_option('home_messages', $to_update, true);
    }
}
