<?php
global $post;

$image_url = get_the_post_thumbnail_url($post, "vertical-card");

?>
<div class="card card-bg card-vertical-thumb bg-white card-thumb-rounded">
	<div class="card-body">
		<div class="card-content">
			<div class="date">	
				<span class="day"><?php echo date_i18n("d", strtotime($post->post_date)); ?></span>
				<span class="month"><?php echo date_i18n("M", strtotime($post->post_date)); ?></span>
				<span class="year"><?php echo date_i18n("Y", strtotime($post->post_date)); ?></span>
			</div>
			<h4 class="h5"><a href="<?php echo get_permalink($post); ?>"><?php echo get_the_title($post); ?></a></h4>
			<p><?php echo get_the_excerpt($post); ?></p>
			
		</div>
		<?php if($image_url) { ?>
			<div class="card-thumb">
                <img src="<?php echo $image_url; ?>" alt="<?php echo esc_attr(get_the_title($post)); ?>">
			</div>
		<?php  } ?>
	</div><!-- /card-body -->
</div><!-- /card -->