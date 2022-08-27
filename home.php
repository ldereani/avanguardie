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
        <?php
        
           
            $messages = av_get_option( "messages", "home_messages" );
            if($messages && !empty($messages)) {
                get_template_part("template-parts/home/messages");
            }
 //           get_template_part("template-parts/home/hero");
            get_template_part("template-parts/hero/home");

            get_template_part("template-parts/home/citazione");
       
            $home_is_selezione_automatica = av_get_option("home_is_selezione_automatica", "homepage");
            if($home_is_selezione_automatica == "false"){
                get_template_part("template-parts/home/articoli", "manuali");
            }else{
                get_template_part("template-parts/home/articoli", "eventi");
            }
 
			get_template_part("template-parts/home/chi-siamo");


 //           get_template_part("template-parts/home/activities");          
 //           get_template_part("template-parts/home/rsvp");          
            get_template_part("template-parts/home/banner");

            ?>
            <?php

//            get_template_part("template-parts/luogo/map");

        
        ?>
    </main>
<?php
get_footer();
