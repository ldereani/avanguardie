<!-- Access Modal -->
<div class="modal fade" id="access-modal" tabindex="-1" role="dialog" aria-labelledby="access-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content perfect-scrollbar">
            <div class="modal-body">
                <form id="access-form" class="access-main-wrapper" name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
                    <div class="container">
                        <div class="row variable-gutters mb-0 mb-lg-4 mb-xl-5">
                            <div class="col">
                                <div class="h2"><?php _e("Accedi ai servizi", "curricoli"); ?>
                                    <button type="button" class="close dismiss" data-dismiss="modal" aria-label="Close">
                                        <svg class="svg-cancel-large"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-cancel-large"></use></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row variable-gutters justify-content-center pt-4 pt-xl-5">
                            <div class="col-lg-4">
                                <p class="text-intro"><?php echo cdv_get_option("login_messaggio", "login"); ?></p>
                                <div class="access-buttons">
                                    <?php
                                    $link_esterni = cdv_get_option("link_esterni", "login");
                                    if(isset($link_esterni) && is_array($link_esterni) && count($link_esterni)>0) {
                                        foreach ($link_esterni as $item) {
                                            ?>
                                            <a class="btn btn-petrol btn-block btn-lg rounded mb-3"
                                               href="<?php echo $item["url_link"]; ?>"><?php echo $item["nome_link"]; ?></a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4 offset-lg-2 access-mobile-bg">
                                <div class="access-login">
                                    <h3><?php _e("Personale scolastico", "curricoli"); ?></h3>
                                    <p class="text-large"><?php _e("Entra nel sito della scuola con le tue credenziali per gestire contenuti e altre funzionalità.", "curricoli"); ?></p>
                                    <div class="access-login-form">
                                        <div class="form-group">
                                            <label for="user_login">Email address</label>
                                            <input type="text" name="log" id="user_login" class="input" value="" size="20" autocapitalize="off" aria-describedby="access-form" placeholder="Nome utente o indirizzo email">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="user_pass">Password</label>
                                            <input type="password" name="pwd" id="user_pass" class="form-control" value="" size="20" aria-describedby="access-form" placeholder="Password">
                                        </div>

                                        <div class="row variable-gutters mb-4">
                                            <div class="col text-right">
                                                <p><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?' ); ?></a></p>
                                            </div>
                                        </div>

                                        <div class="row variable-gutters">
                                            <div class="col-lg-6 mb-4">
                                                <div class="form-check form-check-inline">
                                                    <input name="rememberme" type="checkbox" id="rememberme" value="forever" />
                                                    <label for="rememberme"><?php esc_html_e( 'Remember Me' ); ?></label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-4">
                                                <button type="submit" class="btn btn-white btn-block rounded" name="login" value="Accedi"><?php _e("Accedi", "curricoli"); ?></button>
                                            </div>
                                        </div>
                                        <!--
                                        <div class="row variable-gutters">
                                            <div class="col text-center">
                                                <p>Non hai un account? <a href="#">Iscriviti</a></p>
                                            </div>
                                        </div>
                                        //-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Access Modal -->