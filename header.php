<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Avanguardie
 */

/** Header_Mobile_Menu class */
require_once get_template_directory() . '/walkers/mobile-header-walker.php';

$theme_locations = get_nav_menu_locations();
?>
<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php 
    $active_page = av_get_current_group();
    get_template_part("template-parts/common/svg"); 
?>

<!-- Right menu element-->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right perfect-scrollbar">
    <div class="menu-user-mobile menu-user-blue">
    </div>
</nav>
<!-- End Right menu element-->

<?php

if(is_search() || is_archive())
    get_template_part("template-parts/header/search-filters");
?>


<?php $active_page = av_get_current_group(); ?>

<div id="main-wrapper" class="push_container" id="page_top">
    <?php get_template_part("template-parts/common/skiplink"); ?>
    <header id="main-header" class="bg-white">
        <?php // get_template_part("template-parts/header/slimheader"); ?>
        <div class="container header-top">
            <div class="row variable-gutters">
                <div class="col-8 d-flex align-items-center">
                    <button class="hamburger hamburger--spin-r toggle-menu menu-left push-body d-xl-none" type="button" aria-label="apri chiudi navigazione">
                        <span class="hamburger-box">
                          <span class="hamburger-inner"></span>
                        </span>
                    </button>
                    <!-- Left menu element-->
                    <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left perfect-scrollbar">
                        <div class="logo-header">
                            <?php get_template_part("template-parts/common/logo"); ?>
                            <div class="h1">
                                <a href="<?php echo home_url(); ?>">
                                    <span><?php echo "AVANGUARDIE"; ?></span>
                                    <span><strong><?php echo "VERDI"; ?></strong></span>
                                    <span class="d-none d-lg-block"><?php echo "ARTE MATERICA E SOSTENIBILE"; ?></span>
                                </a>
                            </div>
                        </div><!-- /logo-header -->
                        <div class="nav-list-mobile dl-menuwrapper">
                        <?php $location = "menu-topleft";
                            if ( has_nav_menu( $location ) ) {
                                echo '<nav aria-label="Principale">';
                                wp_nav_menu(array("theme_location" => $location, "depth" => 1,  "menu_class" => "nav-list nav-list-primary", "container" => ""));
                                echo '</nav>';
                            }
                            ?>
                           
                            <?php
                            $location = "menu-topright";
                            if ( has_nav_menu( $location ) ) {
                                echo '<nav aria-label="Argomenti">';
                                wp_nav_menu(array("theme_location" => $location, "depth" => 1,  "menu_class" => "nav-list nav-list-secondary", "container" => ""));
                                echo '</nav>';
                            }
                            ?>
                        </div>
                    </div>
                    <!-- End Left menu element-->
                    <div class="logo-header">
						<?php get_template_part("template-parts/common/logo"); ?>
                        <div class="h1 font-titoli">
                            <a href="<?php echo home_url(); ?>" aria-label="Vai alla homepage" title="vai alla homepage" >
                                <span class="colore-primario"><?php echo "AVANGUARDIE"; ?></span>
                                <span class="colore-secondario"><strong><?php echo "VERDI"; ?></strong></span>
                                <span class="colore-secondario d-none d-lg-block"><?php "ARTE MATERICA E SOSTENIBILE"; ?></span>
                            </a>
                        </div>
                    </div><!-- /logo-header -->
                    <div class="sticky-main-nav">

                    </div><!-- /sticky-main-nav -->

                </div><!-- /col -->
                <div class="col-4 d-flex align-items-center justify-content-end">
                    <div class="header-search d-flex align-items-center">
                        <button type="button" class="d-flex align-items-center search-btn" data-toggle="modal" data-target="#search-modal" aria-label="Cerca nel sito" data-element="search-modal-button">
                            <span class="d-none d-lg-block mr-2"><strong>Cerca</strong></span>
                            <svg class="svg-search">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-search"></use>
                            </svg>
                        </button>
                    </div><!-- /header-search -->
                    <div class="header-utils-sticky">

                    </div>

					<?php
                    /*
					if(!is_user_logged_in()) {
						get_template_part("template-parts/header/header-anon");
					}else{
						get_template_part("template-parts/header/header-logged");
					}
                    */
					?>
                    <?php
                    $show_socials = av_get_option( "show_socials", "socials" );
                    if($show_socials == "true") : ?>
                    <div class="header-social">
                        <span>Seguici su:</span>
                        <div class="header-social-wrapper">
                        <?php if($facebook = av_get_option( "facebook", "socials" )) :?><a href="<?php echo $facebook; ?>" aria-label="facebook" title="vai alla pagina facebook"><svg class="icon it-social-facebook"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-facebook"></use></svg></a><?php endif; ?>
                            <?php if($youtube = av_get_option( "youtube", "socials" )) :?><a href="<?php echo $youtube; ?>" aria-label="youtube" title="vai alla pagina youtube"><svg class="icon it-social-youtube"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-youtube"></use></svg></a><?php endif; ?>
                            <?php if($instagram = av_get_option( "instagram", "socials" )) :?><a href="<?php echo $instagram; ?>" aria-label="instagram" title="vai alla pagina instagram"><svg class="icon it-social-instagram"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-instagram"></use></svg></a><?php endif; ?>
                            <?php if($twitter = av_get_option( "twitter", "socials" )) :?><a href="<?php echo $twitter; ?>" aria-label="twitter" title="vai alla pagina twitter"><svg class="icon it-social-twitter"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-twitter"></use></svg></a><?php endif; ?>
                            <?php if($linkedin = av_get_option( "linkedin", "socials" )) :?><a href="<?php echo $linkedin; ?>" aria-label="linkedin" title="vai alla pagina linkedin"><svg class="icon it-social-linkedin"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-linkedin"></use></svg></a><?php endif; ?>
                        </div><!-- /header-social-wrapper -->
                    </div><!-- /header-social -->
                    <?php endif ?>
                </div><!-- /col -->
            </div><!-- /row -->
        </div><!-- /container -->

        <div class="bg-white d-none d-xl-block header-bottom" id="sub-nav">
            <div class="container">
                <div class="row variable-gutters">
                    <div class="col nav-container">
                    <?php $location = "menu-topleft";
                            if ( has_nav_menu( $location ) ) {
                                echo '<nav aria-label="Principale" class="main-nav" id="menu-principale">';
                                wp_nav_menu(array("theme_location" => $location, "depth" => 1,  "menu_class" => "dl-menu nav-list nav-list-primary", "container" => ""));
                                echo '</nav>';
                            }
                            ?>
                        <!--<nav aria-label="Principale" class="main-nav" id="menu-principale">
                            <ul class="dl-menu nav-list nav-list-primary" data-element="menu"> -->
                                
	                    <?php
	                    $location = "menu-topright";
                        if ( has_nav_menu( $location ) ) {
                            echo '<nav aria-label="Argomenti">';
                            wp_nav_menu(array("theme_location" => $location, "depth" => 1,  "menu_class" => "nav-list nav-list-secondary", "container" => ""));
                            echo '</nav>';
                        }
                        ?>

                    </div><!-- /col nav-container -->
                </div><!-- /row -->
            </div><!-- /container -->
        </div><!-- /sub-nav -->


    </header><!-- /header -->

	<?php get_template_part("template-parts/common/search-modal"); ?>
    <?php
    if(!is_user_logged_in())
        get_template_part("template-parts/common/access-modal");
    ?>

