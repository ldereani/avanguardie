<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Curricoli
 */
global $post, $autore, $luogo, $c;
get_header();

$link_schede_luoghi = cdv_get_meta("link_schede_luoghi");
$nome_luogo_custom = cdv_get_meta("nome_luogo_custom");
$link_schede_documenti = cdv_get_meta("link_schede_documenti");
$file_documenti = cdv_get_meta("file_documenti");
$date = cdv_get_meta("date");

$user_can_view_post = cdv_members_can_user_view_post(get_current_user_id(), $post->ID);
?>
    <main id="main-container" class="main-container greendark">
		<?php get_template_part("template-parts/common/breadcrumb"); ?>

		<?php while ( have_posts() ) :  the_post();
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
                                <h1 class="h2"><?php the_title(); ?></h1>
                                <h2 class="d-none"><?php echo get_post_type(); ?></h2>

                                <h3 class="text-greendark mb-3"><?php echo cdv_get_date_evento($post); ?></h3>
                                <p class="mb-0"><?php echo cdv_get_meta("descrizione"); ?></p>
								<?php get_template_part("template-parts/common/badges-argomenti"); ?>
								<?php
								$link_schede_notizia = cdv_get_meta("link_schede_notizia");
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
                                <div class="aside-title">
                                    <a class="toggle-link-list" data-toggle="collapse" href="#lista-paragrafi" role="button" aria-expanded="true" aria-controls="lista-paragrafi">
                                        <span><?php _e("Indice dell'evento", "curricoli"); ?></span>
                                        <svg class="icon icon-toggle svg-arrow-down-small"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-down-small"></use></svg>
                                    </a>
                                </div>
                                <div id="lista-paragrafi" class="link-list-wrapper collapse show">
                                    <ul class="link-list">
                                        <li>
                                            <a class="list-item scroll-anchor-offset" href="#art-par-cosa" title="Vai al paragrafo <?php _e("Cos'è", "curricoli"); ?>"><?php _e("Cos'è", "curricoli"); ?></a>
                                        </li>
										<?php 	if(count($link_schede_luoghi) || ($nome_luogo_custom != "")) { ?>
                                            <li>
                                                <a class="list-item scroll-anchor-offset" href="#art-par-luogo" title="Vai al paragrafo <?php _e("Luogo", "curricoli"); ?>"><?php _e("Luogo", "curricoli"); ?></a>
                                            </li>
										<?php }
										if($date) {
                                            ?>
                                            <li>
                                                <a class="list-item scroll-anchor-offset" href="#art-par-date"
                                                   title="Vai al paragrafo <?php _e("Date e Orari", "curricoli"); ?>"><?php _e("Date e Orari", "curricoli"); ?></a>
                                            </li>
                                            <?php } ?>
                                        <li>
                                            <a class="list-item scroll-anchor-offset" href="#art-par-costi" title="Vai al paragrafo <?php _e("Costi", "curricoli"); ?>"><?php _e("Costi", "curricoli"); ?></a>
                                        </li>
                                        <li>
                                            <a class="list-item scroll-anchor-offset" href="#art-par-contatti" title="Vai al paragrafo <?php _e("Contatti", "curricoli"); ?>"><?php _e("Contatti", "curricoli"); ?></a>
                                        </li>
										<?php if((is_array($link_schede_documenti) && count($link_schede_documenti)>0) || (is_array($file_documenti) && count($file_documenti)>0)){ ?>
                                            <li>
                                                <a class="list-item scroll-anchor-offset" href="#art-par-altro" title="Vai al paragrafo <?php _e("Ulteriori informazioni", "curricoli"); ?>">Ulteriori informazioni<?php _e("", "curricoli"); ?></a>
                                            </li>
										<?php } ?>
                                     
                                    </ul>
                                </div>
                            </aside>

                        </div>
                        <div class="main-content col-lg-6">
                            <article class="article-wrapper pt-4 px-3">
                                <h4 id="art-par-cosa"><?php _e("Cos'è", "curricoli"); ?></h4>
                                <div class="col-lg-12 px-0 wysiwig-text">
                                <?php the_content(); ?>
                                </div>
								<?php
								global $gallery;
								$gallery = cdv_get_meta("gallery");
                            	if ( is_array( $gallery ) && count( $gallery ) > 0 ) {
                            	    ?>
                                <div class="row variable-gutters">
                                    <div class="col">
                                        <div class="owl-carousel carousel-theme carousel-simple">
                                    <?php get_template_part( "template-parts/single/gallery" , $post->post_type); ?>
                                        </div><!-- /carousel-large -->
                                    </div><!-- /col -->
                                </div><!-- /row -->
		                            <?php
	                            }

								$video = cdv_get_meta("video");
								if($video) { ?>
                                    <div class="video-container my-4">
										<?php echo wp_oembed_get ($video); ?>
                                    </div>
								<?php } ?>
                                <h5  class="h6"><?php _e("Destinatari", "curricoli"); ?></h5>
								<?php
								$descrizione_destinatari = cdv_get_meta("descrizione_destinatari");
								echo wpautop($descrizione_destinatari);
								?>

                                <?php
                                $persone_amministrazione = cdv_get_meta("persone_amministrazione");
                                if(is_array($persone_amministrazione)) {

                                    ?>
                                    <h5  class="h6"><?php _e("Parteciperanno", "curricoli"); ?></h6>

                                    <div class="card-deck card-deck-spaced mb-2">
                                        <?php
                                        foreach ($persone_amministrazione as $idutente) {
                                            $autore = get_user_by("ID", $idutente);
                                            ?>
                                            <div class="card card-bg card-avatar rounded">
                                                <a href="<?php echo get_author_posts_url($idutente); ?>">
                                                    <div class="card-body">
                                                        <?php get_template_part("template-parts/autore/card"); ?>
                                                    </div>
                                                </a>
                                            </div><!-- /card card-bg card-avatar rounded -->
                                            <?php
                                        }
                                        ?>
                                    </div><!-- /card-deck -->
                                    <?php
                                }

                                if((is_array($link_schede_luoghi) && count($link_schede_luoghi) > 0) || ($nome_luogo_custom != "" )) {
                                    ?>

                                    <h4 id="art-par-luogo"><?php _e("Luogo", "curricoli"); ?></h4>

                                    <?php
                                    $c = 0;
                                    if (is_array($link_schede_luoghi) && count($link_schede_luoghi) > 0) {
                                        foreach ($link_schede_luoghi as $idluogo) {
                                            $c++;
                                            $luogo = get_post($idluogo);
                                            get_template_part("template-parts/luogo/card", "large");
                                        }
                                    } else if ($nome_luogo_custom != "") {
                                        get_template_part("template-parts/luogo/card", "custom");

                                    }
                                }
								?>
                                <?php
                                if($date) {
                                    ?>
                                    <h4 id="art-par-date"><?php _e("Date e Orari", "curricoli"); ?></h4>
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
                                        /* else {

                                            $timestamp_inizio = cdv_get_meta("timestamp_inizio");
                                            $timestamp_fine = cdv_get_meta("timestamp_fine");
                                            $ora_inizio = date_i18n("H:i", $timestamp_inizio);
                                            $ora_fine = date_i18n("H:i", $timestamp_fine);

                                        ?>
                                        <div class="calendar-date">
                                            <div class="calendar-date-day">
                                                <small><?php echo date_i18n("Y", $timestamp_inizio); ?></small>
                                                <p><?php echo date_i18n("d", $timestamp_inizio); ?></p>
                                                <small><b><?php echo date_i18n("M", $timestamp_inizio); ?></b></small>

                                            </div><!-- /calendar-date-day -->
                                            <div class="calendar-date-description rounded">
                                                <div class="calendar-date-description-content">
                                                    <p><?php echo $ora_inizio; ?><?php if ($ora_fine != $ora_inizio) echo " - " . $ora_fine; ?></p>
                                                </div><!-- /calendar-date-description-content -->
                                            </div><!-- /calendar-date-description -->
                                        </div><!-- /calendar-date -->

                                            <div class="calendar-date">
                                                <div class="calendar-date-day">
                                                    <small><?php echo date_i18n("Y", $timestamp_fine); ?></small>
                                                    <p><?php echo date_i18n("d", $timestamp_fine); ?></p>
                                                    <small><b><?php echo date_i18n("M", $timestamp_fine); ?></b></small>

                                                </div><!-- /calendar-date-day -->
                                                <div class="calendar-date-description rounded">
                                                    <div class="calendar-date-description-content">
                                                        <p><?php echo $ora_inizio; ?><?php if ($ora_fine != $ora_inizio) echo " - " . $ora_fine; ?></p>
                                                    </div><!-- /calendar-date-description-content -->
                                                </div><!-- /calendar-date-description -->
                                            </div><!-- /calendar-date -->
                                        <?php
                                        } */ ?>

                                    </div><!-- /calendar-vertical -->
                                    <?php
                                }
								?>
                                <h4 id="art-par-costi"><?php _e("Costi", "curricoli"); ?></h4>
								<?php
								$tipo_evento = cdv_get_meta("tipo_evento");
								$prezzo = cdv_get_meta("prezzo");
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

                                <h4 id="art-par-contatti"><?php _e("Contatti", "curricoli"); ?></h4>
								<?php
								$organizzato_da_scuola = cdv_get_meta("organizzato_da_scuola");
								$link_scuola = cdv_get_meta("link_scuola_organizzativa");
								if($organizzato_da_scuola == "si") {
									?>
                                    <h5  class="h6"><?php _e( "Organizzato da", "curricoli" ); ?></h6>
                                    <div class="card-deck card-deck-spaced">
										<?php
										global $icon_color, $second_icon_color;
										$icon_color        = "greendark";
										$second_icon_color = "#c8edc3";
										if(is_array($link_scuola)) {
										    foreach ($link_scuola as $id_scuola){
                                                $scuola = get_post( $id_scuola );

                                                get_template_part( "template-parts/scuola/card" );
                                            }

										}
										?>
                                    </div><!-- /card-deck card-deck-spaced -->
									<?php
								} ?>
                                <?php if((($organizzato_da_scuola != "si") && ((cdv_get_meta("contatto_telefono") != "") || (cdv_get_meta("contatto_persona") != "") || (cdv_get_meta("contatto_email") != ""))) || ((cdv_get_meta("website") != "") ||  (cdv_get_meta("patrocinato") != "") || (cdv_get_meta("sponsor") != "") )) { ?>
                                    <div class="in-evidence mb-5 py-4 pl-2 pr-2">
                                        <ul class="mb-0">
                                            <?php if (cdv_get_meta("website") != "") { ?>
                                                <li><strong
                                                        class="mr-2"><?php _e("Sito web:", "curricoli"); ?></strong>
                                                <a href="<?php echo cdv_get_meta("website"); ?>"><?php echo cdv_get_meta("website"); ?></a>
                                                </li><?php } ?>
                                            <?php if (($organizzato_da_scuola != "si") && (cdv_get_meta("contatto_persona") != "")) { ?>
                                                <li><strong
                                                        class="mr-2"><?php _e("Referente:", "curricoli"); ?></strong> <?php echo cdv_get_meta("contatto_persona"); ?>
                                                </li><?php } ?>
                                            <?php if (($organizzato_da_scuola != "si") && (cdv_get_meta("contatto_telefono") != "")) { ?>
                                                <li><strong
                                                        class="mr-2"><?php _e("Telefono:", "curricoli"); ?></strong> <?php echo cdv_get_meta("contatto_telefono"); ?>
                                                </li><?php } ?>
                                            <?php if (($organizzato_da_scuola != "si") && (cdv_get_meta("contatto_email") != "")) { ?>
                                                <li><strong
                                                        class="mr-2"><?php _e("Email:", "curricoli"); ?></strong>
                                                <a href="mailto:<?php echo cdv_get_meta("contatto_email"); ?>"><?php echo cdv_get_meta("contatto_email"); ?></a>
                                                </li><?php } ?>
                                            <?php if (cdv_get_meta("patrocinato") != "") { ?>
                                                <li><strong
                                                        class="mr-2"><?php _e("Patrocinato da:", "curricoli"); ?></strong> <?php echo cdv_get_meta("patrocinato"); ?>
                                                </li><?php } ?>
                                            <?php if (cdv_get_meta("sponsor") != "") { ?>
                                                <li><strong
                                                        class="mr-2"><?php _e("Sponsor:", "curricoli"); ?></strong> <?php echo cdv_get_meta("sponsor"); ?>
                                                </li><?php } ?>
                                        </ul>
                                    </div>
                                <?php } ?>

								<?php if((is_array($link_schede_documenti) && count($link_schede_documenti)>0) || (is_array($file_documenti) && count($file_documenti)>0)){ ?>
                                    <h4 id="art-par-altro"><?php _e("Ulteriori informazioni", "curricoli"); ?></h4>
                                    <h5  class="h6"><?php _e("Documenti", "curricoli"); ?></>
                                    <div class="card-deck card-deck-spaced">
										<?php
										if(is_array($link_schede_documenti) && count($link_schede_documenti)>0) {
											global $documento;
											foreach ( $link_schede_documenti as $link_scheda_documento ) {
												$documento = get_post( $link_scheda_documento );
												get_template_part( "template-parts/documento/card" );
											}
										}

										global $idfile, $nomefile;
										if(is_array($file_documenti) && count($file_documenti)>0) {

											foreach ( $file_documenti as $idfile => $nomefile ) {
												get_template_part( "template-parts/documento/file" );
											}
										}

										?>
                                    </div><!-- /card-deck card-deck-spaced -->
								<?php } ?>
								<?php get_template_part("template-parts/single/bottom"); ?>
                            </article>
                        </div><!-- /col-lg-6 -->
                        <div class="col-lg-3 aside-border-left px-0">
                            <div class="aside-sticky">
                                <div class="d-flex justify-content-end pb-4">
                                    <?php
                                    $timestamp_inizio = cdv_get_meta("timestamp_inizio");
                                    $timestamp_fine= cdv_get_meta("timestamp_fine");
                                    $data_inizio = date_i18n("Ymd", $timestamp_inizio);
                                    $data_fine = date_i18n("Ymd", $timestamp_fine);
                                    ?>
                                    <div class="actions-wrapper actions-main">
                                        <p><a class="text-underline text-greendark" target="_blank" href="https://calendar.google.com/calendar/r/eventedit?text=<?php echo urlencode(get_the_title()); ?>&dates=<?php echo $data_inizio; ?>/<?php echo $data_fine; ?>&details=<?php echo urlencode(cdv_get_meta("descrizione")); ?>:+<?php echo urlencode(get_permalink()); ?>&location=<?php echo urlencode(cdv_get_option("luogo_scuola")); ?>"> + aggiungi a Google Calendar</a></p>
                                    </div>
                                </div>

                                <?php get_template_part("template-parts/evento/calendar"); ?>
                                <div class="d-flex justify-content-end pb-4">
                                    <?php get_template_part("template-parts/single/actions"); ?>
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

			<?php get_template_part("template-parts/single/more-posts"); ?>

		<?php  	endwhile; // End of the loop. ?>
    </main><!-- #main -->
<?php
get_footer();
