<?php
global $post;

$chi_siamo = av_get_option("chi_siamo", "av_options");
$img_logo = get_stylesheet_directory_uri(). "/assets/images/raggi.svg";
$landing_url = "/chi-siamo";

if(trim($chi_siamo) != ""){
	?>
	<section class="section py-4 bg-verde2 big-quote-wrapper">
		
		<div class="container">
			<div class="row variable-gutters justify-content-center">
				<div class="col-md-10">
					<div class="media">
						<img class="d-none d-md-block align-self-center mr-3 float-right" style="width: 30%" src="<?php echo $img_logo; ?>" alt="Logo">
						<div class="media-body">
							<h1 class="mt-0 font-titoli colore-terziario"><?php echo "Chi siamo"; ?></h1>
							<div class="mb-0 font-corpo colore-terziario font-weight-normal h4"><?php echo $chi_siamo; ?></div>
							<?php if($landing_url){ ?>
                        		<a class="btn btn-sm btn-outline-white mt-4" href="<?php echo $landing_url; ?>" aria-label="Vai a chi siamo"><?php _e("Vai a chi siamo", "avanguardie"); ?></a>
                    		<?php } ?>
						</div>
					</div>
				</div><!-- /col-md-10 -->
			</div><!-- /row -->
		</div><!-- /container -->
		</div>






		
	</section><!-- /section -->
	<?php
}