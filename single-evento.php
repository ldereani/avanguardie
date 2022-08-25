<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Avanguardie
 */
global $post, $autore, $luogo, $c;
get_template_part("template-parts/single/related-posts", "post"); 

get_header();

$date = av_get_meta("date");

$user_can_view_post = true;
?>
    <main id="main-container" class="main-container greendark">
		<?php get_template_part("template-parts/common/breadcrumb"); ?>

		<?php while ( have_posts() ) :  
            the_post();
            set_views($post->ID);
			$image_url = get_the_post_thumbnail_url($post, "item-gallery");
			$autore = get_user_by("ID", $post->post_author);
			?>

				<?php if(has_post_thumbnail($post)){ ?>
        <section class="section bg-white article-title">
                    <div class="title-img" style="background-image: url('<?php echo $image_url; ?>');"></div>
					<?php
					$colsize = 6;
				}else{
				?>
                <section class="section bg-white article-title article-title-small">
		            <?php
					$colsize = 12;
				} ?>
                <div class="container">
                    <div class="row variable-gutters">
                        <div class="col-md-<?php echo $colsize; ?> flex align-items-center">
                            <div class="title-content">
                                <h1 class="h2 font-titoli"><?php the_title(); ?></h1>
                                <h2 class="d-none"><?php echo get_post_type(); ?></h2>

                                <div class="h3 font-corpo text-greendark mb-3"><?php echo av_get_date_evento($post); ?></div>
                                <p class="mb-0 font-corpo"><?php echo av_get_meta("descrizione"); ?></p>
								<?php 
                                $badgeclass = "badge-outline-greendark";
                                get_template_part("template-parts/common/badges-argomenti"); ?>
								<?php
								$link_schede_notizia = av_get_meta("link_schede_notizia");
								if(is_array($link_schede_notizia) && count($link_schede_notizia) > 0){
									foreach ($link_schede_notizia as $id_notizia){
										$notizia = get_post($id_notizia);
										?>
                                        <div class="text-icon">
                                            <a href="<?php echo get_permalink($notizia); ?>">
                                                <svg class="icon svg-link"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-link"></use></svg>
                                                <p><?php echo $notizia->post_title; ?></p>
                                            </a>
                                        </div>
										<?php
									}
								}
								?>
                            </div><!-- /title-content -->
                        </div><!-- /col-md-6 -->
                    </div><!-- /row -->
                </div><!-- /container -->
            </section>
            <section class="section bg-white">
                <div class="container container-border-top">
                    <div class="row variable-gutters">
                        <?php if($user_can_view_post): ?>
                        <div class="col-lg-3 aside-border px-0">
                            <aside class="aside-main aside-sticky">
                                <div class="aside-title" id="event-legend">
                                    <a class="toggle-link-list" data-toggle="collapse" href="#lista-paragrafi" role="button" aria-expanded="true" aria-controls="lista-paragrafi" aria-label="apri/chiudi indice della pagina">
                                        <span class="font-corpo"><?php _e("Indice dell'evento", "avanguardie"); ?></span>
                                        <svg class="icon icon-toggle svg-arrow-down-small"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-down-small"></use></svg>
                                    </a>
                                </div>
                                <div id="lista-paragrafi" class="link-list-wrapper collapse show" role="region" aria-labelledby="event-legend">
                                    <ul class="link-list">
                                        <li>
                                            <a class="font-corpo list-item scroll-anchor-offset" href="#art-par-cosa" title="Vai al paragrafo <?php _e("Cos'è", "avanguardie"); ?>"><?php _e("Cos'è", "avanguardie"); ?></a>
                                        </li>
										<?php
										if($date) {
                                            ?>
                                            <li>
                                                <a class="font-corpo list-item scroll-anchor-offset" href="#art-par-date"
                                                   title="Vai al paragrafo <?php _e("Date e Orari", "avanguardie"); ?>"><?php _e("Date e Orari", "avanguardie"); ?></a>
                                            </li>
                                            <?php } ?>
                                        <li>
                                            <a class="font-corpo list-item scroll-anchor-offset" href="#art-par-costi" title="Vai al paragrafo <?php _e("Costi", "avanguardie"); ?>"><?php _e("Costi", "avanguardie"); ?></a>
                                        </li>
                                        <li>
                                            <a class="font-corpo list-item scroll-anchor-offset" href="#art-par-contatti" title="Vai al paragrafo <?php _e("Contatti", "avanguardie"); ?>"><?php _e("Contatti", "avanguardie"); ?></a>
                                        </li>
										
                                        <?php if ( is_array($posts_array) && count( $posts_array ) )  {   ?>
                                            <li>
                                                <a class="font-corpo list-item scroll-anchor-offset" href="#art-par-correlati"
                                                title="font-corpo Vai al paragrafo <?php _e("Notizie, eventi correlati", "avanguardie"); ?>"><?php _e("Notizie, eventi correlati", "avanguardie"); ?></a>
                                            </li>
                                        <?php } ?>
                                     
                                    </ul>
                                </div>
                            </aside>

                        </div>
                        <div class="main-content col-lg-6">
                            <article class="article-wrapper pt-4 px-3">
                                <h2 id="art-par-cosa" class="h4 font-titoli"><?php _e("Cos'è", "avanguardie"); ?></h2>
                                <div class="col-lg-12 px-0 wysiwig-text">
                                <?php the_content(); ?>
                                </div>
								<?php
								global $gallery;
								$gallery = av_get_meta("gallery");
                            	if ( is_array( $gallery ) && count( $gallery ) > 0 ) {
                            	    ?>
                                <div class="row variable-gutters">
                                    <div class="col">
                                        <div class="it-carousel-wrapper inside-carousel splide" data-bs-carousel-splide>
                                            <div class="splide__track">
                                                <ul class="splide__list">
                                                    <?php get_template_part( "template-parts/single/gallery", $post->post_type ); ?>
                                                </ul>
                                            </div><!-- /carousel-simple -->
                                        </div>
                                    </div><!-- /col -->
                                </div><!-- /row -->
		                            <?php
	                            }

								$video = av_get_meta("video");
								if($video) { ?>
                                    <div class="video-container my-4">
										<?php echo wp_oembed_get ($video); ?>
                                    </div>
								<?php } ?>

                                
                                <?php
                                if($date) {
                                    ?>
                                    <h2 class="h4 font-titoli"  id="art-par-date"><?php _e("Date e Orari", "avanguardie"); ?></h2>
                                    <div class="calendar-vertical mb-5">
                                        <?php

                                        $old_data = "";
                                        foreach ($date as $data) {

                                            ?>
                                            <div class="calendar-date">
                                                <div class="calendar-date-day">
                                                    <?php if ($old_data != date_i18n("dMY", $data["data"])) { ?>
                                                        <small><?php echo date_i18n("Y", $data["data"]); ?></small>
                                                        <p><?php echo date_i18n("d", $data["data"]); ?></p>
                                                        <small><b><?php echo date_i18n("M", $data["data"]); ?></b></small>

                                                    <?php } ?>
                                                </div><!-- /calendar-date-day -->
                                                <div class="calendar-date-description rounded">
                                                    <div class="calendar-date-description-content">
                                                        <p><?php echo date_i18n("H:i", $data["data"]); ?><?php if (isset($data["descrizione"])) echo " - " . $data["descrizione"]; ?></p>
                                                    </div><!-- /calendar-date-description-content -->
                                                </div><!-- /calendar-date-description -->
                                            </div><!-- /calendar-date -->
                                            <?php
                                            $old_data = date_i18n("dMY", $data["data"]);

                                        }
                  ?>

                                    </div><!-- /calendar-vertical -->
                                    <?php
                                }
								?>
                                <h2 class="h4 font-titoli" id="art-par-costi"><?php _e("Costi", "avanguardie"); ?></h2>
								<?php
								$tipo_evento = av_get_meta("tipo_evento");
								$prezzo = av_get_meta("prezzo");
								if($tipo_evento == "gratis"){
									echo "<p>Evento Gratuito</p>";
								}else {
									foreach ($prezzo as $biglietto) {
										?>
                                        <div class="text-border-left">
                                            <div class="text-icon">
                                                <svg class="icon svg-ticket">
                                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                         xlink:href="#svg-ticket"></use>
                                                </svg>
                                                <span><?php echo $biglietto["tipo_biglietto"]; ?></span>
                                            </div>
                                            <p class="price"><strong>€ <?php echo $biglietto["prezzo"]; ?></strong></p>
                                            <p><?php echo $biglietto["descrizione"]; ?></p>
                                        </div><!-- /text-border-left -->
										<?php
									}
								}
								?>

                                
								<?php get_template_part("template-parts/single/bottom"); ?>
                            </article>
                        </div><!-- /col-lg-6 -->
                        <div class="col-lg-3 aside-border-left px-0">
                            <div>
                                <div class="d-flex justify-content-end pb-4">
                                    <?php
                                    $timestamp_inizio = av_get_meta("timestamp_inizio");
                                    $timestamp_fine= av_get_meta("timestamp_fine");
                                    $data_inizio = date_i18n("Ymd", $timestamp_inizio);
                                    $data_fine = date_i18n("Ymd", $timestamp_fine);
                                    ?>
                                    <div class="actions-wrapper actions-main">
                                        <p><a class="text-underline text-greendark" target="_blank" href="https://calendar.google.com/calendar/r/eventedit?text=<?php echo urlencode(get_the_title()); ?>&dates=<?php echo $data_inizio; ?>/<?php echo $data_fine; ?>&details=<?php echo urlencode(av_get_meta("descrizione")); ?>:+<?php echo urlencode(get_permalink()); ?>&location=<?php echo urlencode(av_get_option("luogo_scuola")); ?>"> + aggiungi a Google Calendar</a></p>
                                    </div>
                                </div>

                                <?php
                                // get_template_part("template-parts/evento/calendar");
                                ?>
                                <div class="d-flex justify-content-end pb-4">
                                    <?php get_template_part("template-parts/single/actions"); ?>
                                </div>
                            </div>
                        </div><!-- /col-lg-3 -->
                        <?php else: ?>
                            <div class="col-lg-12 p-5 m-5 text-center font-weight-bold wysiwig-text">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                    </div><!-- /row -->
                </div><!-- /container -->
            </section>

            <section class="section bg-gray-light py-5" id="art-par-04">
                <div class="container py-4">
                    <div class="title-section text-center mb-5">
                        <h2 class="h4 font-titoli">Foto e video</h2>
                    </div><!-- /title-large -->
                    <div class="row variable-gutters">
                        <div class="col">
                        <?php if ( is_array( $gallery ) && count( $gallery ) > 0 ) { ?>
                            <div class="it-carousel-wrapper simple-two-carousel splide" data-bs-carousel-splide>
                                <div class="splide__track">
                                    <ul class="splide__list">
                                    <?php get_template_part( "template-parts/single/gallery", $post->post_type ); ?>
                                    </ul>
                                </div><!-- /carousel-simple -->
                            </div>
                        <?php } ?>
                        </div><!-- /col -->
                    </div><!-- /row -->
                </div><!-- /container -->
            </section>

			<?php get_template_part("template-parts/single/more-posts"); ?>

		<?php  	endwhile; // End of the loop. ?>
    </main><!-- #main -->
<?php
get_footer();
