<?php
global $post, $autore;
$autore = get_user_by("ID", $post->post_author);

$image_url = get_the_post_thumbnail_url($post, "vertical-card");

?><div class="card card-bg card-vertical-thumb bg-white card-thumb-rounded">
	<div class="card-body">
		<div class="card-content">
			<h4 class="h5 font-titoli colore-secondario"><a href="<?php echo get_permalink($post); ?>"><?php echo get_the_title($post); ?></a></h4>
			<p class="font-corpo colore-primario"><?php echo get_the_excerpt($post); ?></p>
		</div>
		<?php if($image_url) { ?>
			<div class="card-thumb">
                <img src="<?php echo $image_url; ?>" alt="<?php echo esc_attr(get_the_title($post)); ?>">
			</div>
		<?php  } ?>
	</div><!-- /card-body -->
	<div class="card-comments-wrapper">
		<?php get_template_part("template-parts/autore/card"); ?>
	</div><!-- /card-comments-wrapper -->
</div><!-- /card --><?php
