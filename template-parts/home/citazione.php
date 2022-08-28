<?php
global $post;

$citazione = av_get_option("citazione", "av_options");
$citazione_descrizione = av_get_option("citazione_descrizione", "av_options");
$img_logo = get_stylesheet_directory_uri(). "/assets/images/logoAV.png";

if(trim($citazione) != ""){
	?>
	<section class="section py-4 bg-verde1 big-quote-wrapper">
		
		<div class="container">
			<div class="row variable-gutters justify-content-center">
				<div class="col-md-10">
					<div class="media">
						<div class="media-body">
							<h3 class="mt-0 font-titoli colore-primario h2"><?php echo $citazione; ?></h3>
							<div class="mb-0 font-corpo colore-terziario font-weight-normal h4"><?php echo $citazione_descrizione; ?></div>
						</div>
						
					</div>
				</div><!-- /col-md-10 -->
			</div><!-- /row -->
		</div><!-- /container -->
	</section><!-- /section -->
	<?php
}