<?php
/**
 * Box schede didattiche della stessa scuola
 */
global $post, $related_type;
if(!$related_type)
    $related_type = "card-vertical-thumb";
$oldpost = $post;
//$argomenti = cdv_get_argomenti_of_post();
$schede_array = cdv_get_schede_didattiche_scuola();
if(count($schede_array)) { ?>
		<section class="section bg-gray-gradient py-5" id="art-par-correlati">
		<div class="container pt-3">

			<div class="row variable-gutters">
				<div class="col-lg-12">

					<h3 class="mb-5 text-center semi-bold text-gray-primary"><?php _e("Schede didattiche", "curricoli"); ?></h3>

					<div class="owl-carousel carousel-theme carousel-large">
						<?php
						foreach ( $schede_array as $post ) {
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
	$post = $oldpost;