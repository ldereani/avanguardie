<?php
global $post, $autore, $luogo, $c, $badgeclass;

$image_url = get_the_post_thumbnail_url($post, "item-gallery");
$autore = get_user_by("ID", $post->post_author);
?>
<?php if(has_post_thumbnail($post)){ ?>
<section class="section bg-verde">

    <div class="title-img" style="background-image: url('<?php echo $image_url; ?>');"></div>
    <?php
    $colsize = 6;
    }else{
    ?>
    <section class="section bg-verde article-title-small">
        <?php
        $colsize = 6;
        } ?>
        <div class="container">
            <div class="row variable-gutters">
                <div class="col-md-<?php echo $colsize; ?> article-title-author-container">
                    <div class="title-content">
                        <h1 class="testo-titolo"><?php the_title(); ?></h1>
                        <?php 
                        $descrizione = av_get_meta("descrizione");
                        if ($descrizione != "") { ?>
                        <p class="mb-0"><?php echo av_get_meta("descrizione"); ?></p>
                        <?php } ?>
                    </div><!-- /title-content -->
                </div><!-- /col-md-6 -->
            </div><!-- /row -->
        </div><!-- /container -->
    </section>