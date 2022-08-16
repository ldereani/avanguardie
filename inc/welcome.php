<?php
/**
 * parser readme.md
 */
require get_template_directory() . '/inc/vendor/parsedown.php';


/**
 * Welcome page
 */
remove_action('welcome_panel', 'wp_welcome_panel');
add_action( 'welcome_panel', 'cdv_welcome_panel' );

function cdv_welcome_panel(){
    ?>
    <div class="welcome-panel-content" style="padding-bottom:30px;">
        <h2><?php _e( 'Curricoli: il tema per curricoli scolastici basato sul tema di  Developers Italia per le Scuole Italiane', "curricoli" ); ?></h2>
    </div>
    <?php
}

function cdv_welcome_init() {
    global $wpdb;
    $wpdb->update($wpdb->usermeta,array('meta_value'=>1),array('meta_key'=>'show_welcome_panel'));
}

add_action('after_switch_theme','cdv_welcome_init');


/**
 * Gestione widget dashboard admin
 *
 */


add_action('wp_dashboard_setup', 'cdv_remove_all_dashboard_meta_boxes', 100 );


/**
 * Mostra solo i metabox del progetto
 */
function cdv_remove_all_dashboard_meta_boxes()
{
    global $wp_meta_boxes;

    $keep_boxes = array();
    foreach ($wp_meta_boxes['dashboard']['normal']['core'] as $wp_meta_box) {
        if (substr($wp_meta_box["id"], 0, 4) == "cdv_") {
            $keep_boxes[] = $wp_meta_box;
        }
    }
    $wp_meta_boxes['dashboard']['normal']['core'] = $keep_boxes;

    $keep_boxes = array();
    foreach ($wp_meta_boxes['dashboard']['side']['core'] as $wp_meta_box) {
        if (substr($wp_meta_box["id"], 0, 4) == "cdv_") {
            $keep_boxes[] = $wp_meta_box;
        }
    }
    $wp_meta_boxes['dashboard']['side']['core'] = $keep_boxes;
}

/**
 * Forzo a 2 colonne la dashboard admin
 * @param $columns
 * @return mixed
 */
function cdv_screen_layout_columns($columns) {
    $columns['dashboard'] = 2;
    return $columns;
}

add_filter('screen_layout_columns', 'cdv_screen_layout_columns');

function cdv_screen_layout_dashboard() {
    return 2;
}

add_filter('get_user_option_screen_layout_dashboard', 'cdv_screen_layout_dashboard');


add_action ('admin_menu', function () {
  //  add_management_page('Manuale Tema Scuole', 'Manuale Tema Scuole', 'read', 'manuale-scuole', 'cdv_readme_render_manual', '');
});

function cdv_readme_render_manual(){
echo '<div class="wrap manuale">';

    $response = wp_remote_get( 'https://raw.githubusercontent.com/italia/design-scuole-wordpress-theme/master/README.md?test=1' );

    if ( is_array( $response ) && ! is_wp_error( $response ) ) {

        $body    = $response['body']; // use the content
        $Parsedown = new Parsedown();
        echo $Parsedown->text($body);

    }

echo "</div>";
}

add_action('admin_bar_menu', 'cdv_add_toolbar_manual', 100);
function cdv_add_toolbar_manual($admin_bar)
{
    $admin_bar->add_menu(array(
        'id' => 'manuale',
        'title' => 'Manuale',
        'href' => 'https://docs.google.com/document/d/1naD7nk9R62tb2OyE25ofPpqUZolfbPjwtF_AwceSnQg/edit#heading=h.cavkdt8hpm8v',
        'meta' => array(
            'title' => __('Manuale'),
            'target' => '_blank'
        ),
    ));
}