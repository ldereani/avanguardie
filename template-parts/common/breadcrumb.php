<section class="section py-2 bg-white d-none d-sm-block">
    <div class="container">
		<div class="row variable-gutters">
			<div class="col-12">
				<div class="breadcrumb">
                    <?php
                    if ( function_exists( 'breadcrumb_trail' ) ) {
	                    $args = array(
		                    'container'       => 'nav',
		                    'before'          => '',
		                    'after'           => '',
		                    'browse_tag'      => 'h2',
		                    'list_tag'        => 'ol',
		                    'item_tag'        => 'li',
		                    'show_on_front'   => true,
		                    'network'         => false,
		                    'show_title'      => true,
		                    'show_browse'     => false,
		                    'labels'          => array(
			                    'search'      => esc_html__( 'Risultati Ricerca: %s','curricoli' ),
                            ),
		                    'post_taxonomy' => array(
			                    'artisti'  => 'artisti', // 'post' post type and 'post_tag' taxonomy
                                'eventi'  => 'eventi',
			                     'news'  => 'news',
			                     'post'  =>     'tipologia-articolo',

                            ),
		                    'echo'            => true
	                    );
	                    breadcrumb_trail($args);
                    }
                    ?>
				</div><!-- /breadcrumbs -->
			</div><!-- /col-12 -->
		</div><!-- /row -->
	</div><!-- /container -->
</section><!-- /section --><?php
