<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Avanguardie
 */
global $post, $autore, $luogo, $c, $badgeclass;
get_header();
?>
    <main id="main-container" class="main-container greendark">
        <?php 
        get_template_part("template-parts/home/navigation");

        get_template_part("template-parts/common/breadcrumb"); 
        ?>

        <?php while ( have_posts() ) :  the_post();


                get_template_part("template-parts/single/header-post");
            ?>
            <section class="section bg-crema py-5">
                <div class="container">
                    <div class="row variable-gutters">
                       
                        <div class="main-content col-lg-9 col-md-8 order-lg-1">
                            <article class="article-wrapper pt-4 testo-contenuto">
                                <div class="row variable-gutters">
                                    <div class="col-lg-8 wysiwig-text dim-testo-normale">
                                        <?php
                                        the_content();
                                        ?>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="row variable-gutters">
                                    <div class="col-lg-12">
                                        <?php
                                            if (comments_open() || get_comments_number()) :
                                                comments_template();
                                            endif;

                                        ?>
                                    </div>
                                </div>
                                <div class="row variable-gutters">
                                    <div class="col-lg-12">
                                        <?php get_template_part( "template-parts/single/bottom" ); ?>
                                    </div><!-- /col-lg-9 -->
                                </div><!-- /row -->
                            </article>
                        </div><!-- /col-lg-8 -->
                        <div class="col-lg-3 col-md-4 order-lg-0">
                            <?php get_template_part("template-parts/single/actions"); ?>
                            <?php
                            $badgeclass = "badge-outline-greendark";
                            get_template_part("template-parts/common/badges-argomenti"); ?>
                            
                        </div><!-- /col-lg-3 -->
                        
                    </div><!-- /row -->
                </div><!-- /container -->
            </section>


            <?php get_template_part("template-parts/single/more-posts"); ?>

        <?php  	endwhile; // End of the loop. ?>
    </main><!-- #main -->
<?php
get_footer();
