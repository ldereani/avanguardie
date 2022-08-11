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
        /*
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
*/
		return $val;
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