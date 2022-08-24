<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Avanguardie
 */

get_header();
?>
    
    <main id="main-container" class="main-container">
    <?php
        get_template_part("template-parts/common/breadcrumb");
       
        while ( have_posts() ) :
            the_post();

            get_template_part("template-parts/hero/post");

            ?>


            <section class="section bg-crema">
                <div class="container">
                    <article class="article-wrapper testo-contenuto">


                        <div class="row variable-gutters">
                            <div class="col-lg-12 wrapper-content">
                                <?php
                                the_content();
                                ?>
                            </div>
                        </div>
                        <div class="row variable-gutters">
                            <div class="col-lg-12">
                                <?php
                                if ( comments_open() || get_comments_number() ) :
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
                </div>
            </section>
        <?php
        endwhile; // End of the loop.
        ?>
    </main><!-- #main -->


<?php
get_footer();

