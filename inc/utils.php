<?php
/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string $key     Options array key
 * @param  mixed  $default Optional default value
 * @return mixed           Option value
 */
if(!function_exists("av_get_option")) {
	function av_get_option( $key = '', $type = "av_options", $default = false ) {
        
		if ( function_exists( 'cmb2_get_option' ) ) {
			// Use cmb2_get_option as it passes through some key filters.
			return cmb2_get_option( $type, $key, $default );
		}

		// Fallback to get_option if CMB2 is not loaded yet.
		$opts = get_option( $type, $default );

		$val = $default;

		if ( 'all' == $key ) {
			$val = $opts;
		} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
			$val = $opts[ $key ];
		}

		return $val;
	}
}
/**
 * Define members check user function if not defined and return true
 * @param  int     $user_id
 * @param  int     $post_id
 * @return bool
 */
if(!function_exists("av_members_can_user_view_post")) {
    function av_members_can_user_view_post($user_id, $post_id) {
        if(!function_exists("members_can_user_view_post")) {
            return true;
        }else{
            return members_can_user_view_post($user_id, $post_id);
        }

    }
}

/**
 * Wrapper function for get_post_meta
 * @param string $key
 * @return mixed meta_value
 */
if(!function_exists("av_get_meta")){
	function av_get_meta( $key = '', $prefix = "", $post_id = "") {
        if ( ! av_members_can_user_view_post(get_current_user_id(), $post_id) ) return false;

		if($post_id == "")
			$post_id = get_the_ID();

		$post_type = get_post_type($post_id);

		if($prefix != "")
			return get_post_meta( $post_id, $prefix.$key, true );

        if (is_singular("evento")  || (isset($post_type) && $post_type == "evento")) {
			$prefix = '_av_evento_';
			return get_post_meta( $post_id, $prefix . $key, true );
		}else if (is_singular("documento")  || (isset($post_type) && $post_type == "documento")) {
			$prefix = '_av_documento_';
			return get_post_meta( $post_id, $prefix . $key, true );
		}else if (is_singular("post")  || (isset($post_type) && $post_type == "post")) {
			$prefix = '_av_articolo_';
			return get_post_meta( $post_id, $prefix . $key, true );
		}

		return get_post_meta( $post_id, $key, true );
	}
}


if(!function_exists("av_get_term_meta")){
    function av_get_term_meta( $key , $prefix, $term_id) {
            return get_term_meta($term_id, $prefix.$key, true );

    }
}
/**
 * Wrapper function for user avatar
 * @param object user
 * @return string url
 */
if(!function_exists("av_get_user_avatar")){
	function av_get_user_avatar( $user = false, $size=250 ) {
		if(!$user && is_user_logged_in()){
			$user = wp_get_current_user();
		}
        $foto_id = null;
		$foto_url = get_the_author_meta('_av_persona_foto', $user->ID);
		if($foto_url)
            $foto_id = attachment_url_to_postid($foto_url);

        if(isset($foto_id) && $foto_id)
            $avatar = wp_get_attachment_image_url($foto_id, "item-thumb");
		else
		    $avatar = get_avatar_url( $user->ID, array("size" => $size) );

		$avatar = apply_filters("av_avatar_url", $avatar, $user);
		return $avatar;
	}
}


add_filter( 'get_avatar' , 'av_custom_avatar' , 1 , 5 );

function av_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = false;

    if ( is_numeric( $id_or_email ) ) {

        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }

    } else {
        $user = get_user_by( 'email', $id_or_email );
    }

    if ( $user && is_object( $user ) ) {

        $foto_url = get_the_author_meta('_av_persona_foto', $user->ID);
        if($foto_url)
            $foto_id = attachment_url_to_postid($foto_url);

        if(isset($foto_id) && $foto_id) {
            $avatar = wp_get_attachment_image_url($foto_id, "item-thumb");
            $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }
    }

    return $avatar;
}



/**
 * Wrapper function for user role
 * @param object user
 * @return string role
 */
if(!function_exists("av_get_user_role")) {
	function av_get_user_role( $user = false ) {
		global $wp_roles;


		if ( ! $user && is_user_logged_in() ) {
			$user = wp_get_current_user();
		}

        $ruolo_scuola = get_the_author_meta('_dsi_persona_ruolo_scuola', $user->ID);
        $tipo_posto = get_the_author_meta('_dsi_persona_tipo_posto', $user->ID);
        $ruolo_non_docente = get_the_author_meta('_dsi_persona_ruolo_non_docente', $user->ID);

        $str_ruolo = "";
        if($ruolo_scuola == "dirigente"){
            $str_ruolo .= "Dirigente Scolastico ";
        }else if($ruolo_scuola == "docente"){
            $str_ruolo .= "Docente ";

            if($tipo_posto == "sostegno"){
                $str_ruolo .= "di sostegno ";
            }

        }else if($ruolo_scuola == "personaleata"){

            if($ruolo_non_docente == "direttore-amministrativo"){
                $str_ruolo .= "Direttore amministrativo ";
            }else if($ruolo_non_docente == "tecnico"){
                $str_ruolo .= "Personale tecnico ";
            }else if($ruolo_non_docente == "amministrativo"){
                $str_ruolo .= "Personale amministrativo ";
            }else if($ruolo_non_docente == "collaboratore"){
                $str_ruolo .= "Collaboratore scolastico";
            }else{
                $str_ruolo .= "Non docente ";
            }


        }

        return $str_ruolo;
	}
}





if(!function_exists("av_pluralize_string")) {
    function av_pluralize_string($string){
    switch ($string){
        
        case "Documento Generico":
            $string = "Documenti Generici";
            break;

        
        case "":
            $string = "";
            break;

    }

        return $string;
    }
}


/**
 * funzione per la gestione del nome autore
 */

function av_get_display_name($user_id){

    $display = get_the_author_meta('display_name', $user_id);
    $nome = get_the_author_meta('first_name', $user_id);
    $cognome = get_the_author_meta('last_name', $user_id);
    if(($nome != "") && ($cognome != ""))
        return $nome." ".$cognome;
    else
        return $display;

}


/**
 *  Funzione per la ricerca di un valore in un array multiplo
 *  * @since  0.1.0
 * @param  string $search_for  Value to search
 * @param  array  $search_in Array where to search
 * @param  mixed  $okey Previous value
 * @return mixed
 */
if(!function_exists("av_multi_array_search")) {
    function av_multi_array_search($search_for, $search_in, $okey = false) {
        foreach ($search_in as $key => $element) {
            $key = $okey ? $okey : $key;
            if (($element === $search_for) || (is_array($element) && $key = av_multi_array_search($search_for, $element, $key))) {
                return $key;
            }
        }
        return false;
    }
}







/**
 * @param WP_Query|null $wp_query
 * @param bool $echo
 *
 * @return string
 * Accepts a WP_Query instance to build pagination (for custom wp_query()),
 * or nothing to use the current global $wp_query (eg: taxonomy term page)
 * - Tested on WP 4.9.5
 * - Tested with Bootstrap 4.1
 * - Tested on Sage 9
 *
 * USAGE:
 *     <?php echo cdv_bootstrap_pagination(); ?> //uses global $wp_query
 * or with custom WP_Query():
 *     <?php
 *      $query = new \WP_Query($args);
 *       ... while(have_posts()), $query->posts stuff ...
 *       echo bootstrap_pagination($query);
 *     ?>
 */
function av_bootstrap_pagination( \WP_Query $wp_query = null, $echo = true ) {
	if ( null === $wp_query ) {
		global $wp_query;
	}
	$pages = paginate_links( [
			'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			'format'       => '?paged=%#%',
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'total'        => $wp_query->max_num_pages,
			'type'         => 'array',
			'show_all'     => false,
			'end_size'     => 3,
			'mid_size'     => 1,
			'prev_next'    => true,
			'prev_text'    => __( '« ' ),
			'next_text'    => __( ' »' ),
			'add_args'     => false,
			'add_fragment' => ''
		]
	);
	if ( is_array( $pages ) ) {
		//$paged = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
		$pagination = '<div class="pagination"><ul class="pagination">';
		foreach ($pages as $page) {
			$pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
		}
		$pagination .= '</ul></div>';
		if ( $echo ) {
			echo $pagination;
		} else {
			return $pagination;
		}
	}
	return null;
}


/**
 * Ritorna l'associazione tra i type ricercabili e i post_type wordpress
 * @param string $type
 *
 * @return array
 */
function av_get_post_types_grouped($type = "", $tag = false){
	if($type == "")
		$type = "any";
	if($type === "news")
		$post_types = array("evento", "post");
	else
		$post_types = array("evento", "post","documento", "page");

	// rimuovo post types che non hanno la categoria
	if($tag){
		if (($key = array_search("page", $post_types)) !== false) {
			unset($post_types[$key]);
		}

	}
	return $post_types;

}


/**
 * @param $post_type
 *
 * ritorna il gruppo di appartenenza del post type
 * @return string
 *
 */
function av_get_post_types_group($post_type){
	$group = "news";
	if(in_array($post_type, array("documento", "luogo", "scuola", "page"))) // todo: programma materia if(in_array($post_type, array("documento", "luogo", "programma_materia", "scuola", "page")))
		$group = "school";
	else if(in_array($post_type, array("programma", "scheda_didattica", "scheda_esperienza")))
		$group = "education";

	return $group;
}

/**
 * @param $post_type
 *
 * ritorna il suffisso della classe relativa al colore
 * @return string
 */
function av_get_post_types_color_class($post_type) {
	$class = "greendark";
	$group = cdv_get_post_types_group($post_type);
	if($group == "school")
		$class = "redbrown";
	else if($group == "education")
		$class = "bluelectric";
	else if($group == "service")
		$class = "purplelight";
	return $class;
}

/**
 * @param $post_type
 *
 * ritorna il nome dell'svg utilizzato per la preview del post type
 * @return string
 */
function av_get_post_types_icon_class($post_type) {
	$icon = "newspaper";
	$group = cdv_get_post_types_group($post_type);
	if($group == "school")
		$icon = "school-building";
	else if($group == "education")
		$icon = "school";
	else if($group == "service")
		$icon = "hand-point-up";

	if($post_type == "documento")
		$icon = "generic-document";
		return $icon;
}


/**
 *
 * Contatore dei post totali raggruppati in base al gruppo di ricerca di appartenenza
 *
 * @param $post_types
 *
 * @return bool|int
 */
function av_count_grouped_posts($post_types){
	if(!is_array($post_types))
		return false;
	$count = 0;
	foreach ($post_types as $post_type){
		$count_posts = wp_count_posts($post_type);
		if(isset($count_posts->publish))
			$count += $count_posts->publish;
	}
	return $count;

}

/**
 * recupera la url del template in base al nome
 * @param $TEMPLATE_NAME
 *
 * @return string|null
 */
function av_get_template_page_url($TEMPLATE_NAME){
	$pages = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => $TEMPLATE_NAME,
        'hierarchical' => 0
	));

    if($pages){
        foreach ($pages as $page){
            if($page->ID)
                return get_page_link($page->ID);
        }
    }
	return null;
}

/**
 * recupera id page template in base al nome
 * @param $TEMPLATE_NAME
 *
 * @return string|null
 */
function av_get_template_page_id($TEMPLATE_NAME){
    $url = null;
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => $TEMPLATE_NAME,
        'hierarchical' => 0
    ));
    if($pages){
        foreach ($pages as $page){
            if($page->ID)
                return $page->ID;
        }
    }

    return 0;
}






/**
 *  Tronca un testo in base ai valori specificati
 *  * @since 0.1.0
 * @param $string initial text
 * @param $limit truncate length
 * @param string $break
 * @param string $pad
 * @return string
 */
if(!function_exists("av_truncate")) {
    function av_truncate($string, $limit, $break = " ", $pad = "..."){
        $string = html_entity_decode($string, ENT_QUOTES, "UTF-8");

        $string = strip_tags($string);
        if (mb_strlen($string) <= $limit)
            return $string;

        // is $break present between $limit and the end of the string?
        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if ($breakpoint < mb_strlen($string) - 1) {
                $string = mb_substr($string, 0, $breakpoint) . $pad;
            }
        }

        return $string;
    }
}
/**
 * get group related to current page
 */
if(!function_exists("av_get_current_group")) {
    function av_get_current_group() {
        if (is_front_page()) {
            return null;
        }
        if (is_tax()) {
            $taxonomy = get_queried_object() -> taxonomy;
            $term = get_queried_object() -> slug;
            if ($taxonomy == 'tipologia-documento'){
                $tipo_post ='documento';
            }
            if ($taxonomy == 'tipologia-articolo'){
                $tipo_post = 'post';
            }
            
            return  av_get_post_types_group($tipo_post);
        }
        if (is_author()) {
            return 'avanguardie';
        }
        if ( is_archive()  ) {
            $tipo_post = get_queried_object() -> name;
            return  av_get_post_types_group($tipo_post);
        }
        if (is_page()) {
            $rel_url = wp_make_link_relative(get_permalink());
            $rel_url =  preg_replace('/^' . preg_quote('/', '/') . '/', '', $rel_url);
            $group_slug = strtok($rel_url, '/');
            switch($group_slug){
                case 'la-scuola':
                    return 'school';
                case 'didattica' :
                    return 'education';
                case 'novita': case 'evento': case 'circolare':
                    return 'news';
                case 'servizi':
                    return 'service';
            }
            return null;
        }
        $current_post_type = get_post_type();
        if ($current_post_type == 'documento') {
            $term = wp_get_post_terms(get_the_ID(),'tipologia-documento');
        }
        if ( ($current_post_type != false)) {
            return av_get_post_types_group(get_post_type());
        }
        return null;
    }
}