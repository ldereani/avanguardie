<?php
/**
 * Box correlati per scheda didattica
 */
global $post, $related_type;
if(!$related_type)
    $related_type = "card-vertical";
$oldpost = $post;
//$tipologia = cdv_get_option("tipologia_diario", "notizie");

if(true) { //count($tipologia)) {
	// estraggo gli id
//	$arr_ids = array();
//	foreach ( $argomenti as $item ) {
//		$arr_ids[] = $item->term_id;
//	}
	// recupero articoli di tipo diario di sperimentazione collegati alla scheda didattica
	$posts_array = cdv_get_post_schede_didattica();

	if ( count( $posts_array ) ) { ?>
		<section class="section bg-gray-gradient py-5" id="art-par-correlati">
		<div class="container pt-3">

			<div class="row variable-gutters">
				<div class="col-lg-12">

					<h3 class="mb-5 text-center semi-bold text-gray-primary"><?php _e("Diario sperimentazione", "curricoli"); ?></h3>
					<div class="owl-carousel carousel-theme carousel-large">
						<?php
						foreach ( $posts_array as $post ) {
							
							?>
							<div class="item">
								<?php get_template_part( "template-parts/single/".$related_type, $post->post_type ); ?>
							</div><!-- /item -->
						<?php } ?>
					</div><!-- /carousel-large -->

				</div><!-- /col-lg-12 -->
			</div><!-- /row -->
		</div><!-- /container -->
		</section><?php
	}
}
	$post = $oldpost;