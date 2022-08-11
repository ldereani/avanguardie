<?php
/**
 * The template for displaying home
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Avanguardie
 */

get_header();

?>
<main id="main-container" class="main-container redbrown">
        <div id="root">
        <?php
        get_template_part("template-parts/home/navigation");
        get_template_part("template-parts/home/hero");
        get_template_part("template-parts/home/about");
        get_template_part("template-parts/home/motivation");
        get_template_part("template-parts/home/details");
        get_template_part("template-parts/home/activities");
        get_template_part("template-parts/home/rsvp");
/*        
            $messages = cdv_get_option( "messages", "home_messages" );
            if($messages && !empty($messages)) {
                get_template_part("template-parts/home/messages");
            }
            get_template_part("template-parts/hero/home");

            get_template_part("template-parts/home/banner");
        if ( have_posts() ) {
            $home_is_selezione_automatica = cdv_get_option("home_is_selezione_automatica", "homepage");
            if($home_is_selezione_automatica == "false"){
                get_template_part("template-parts/home/articoli", "manuali");
            }else{
                get_template_part("template-parts/home/articoli", "eventi");
            }
        }
*/
            ?>
        </div>
        <section class="section bg-white">
        <?php // get_template_part("template-parts/hero/servizi"); ?>
        <?php // get_template_part("template-parts/home/list", "servizi"); ?>
        </section>
            <?php
            /*
            $visualizzazione_didattica = cdv_get_option("visualizzazione_didattica", "didattica");
            if($visualizzazione_didattica == "scuole")
                get_template_part("template-parts/home/didattica", "cicli");
            else if($visualizzazione_didattica == "indirizzi")
                get_template_part("template-parts/home/didattica", "cicli-indirizzi");

              get_template_part("template-parts/home/didattica", "risorse");

//            get_template_part("template-parts/luogo/map");

        */
        ?>
    </main>
<?php
get_footer();