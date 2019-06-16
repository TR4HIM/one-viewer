<?php
/*
    Plugin Name: One Viewer 
    Plugin URI: https://github.com/TR4HIM
    Description: Allows to show worpdress posts by categories using VueJs and Wordpress API
    Author: Soufiane Trahim
    Version: 1.0.0
    Author URI: https://github.com/TR4HIM
*/



/* Plugin Constans */

define( 'ONEVIEW_VERSION', '1.0.0' );
define( 'ONEVIEW_REQUIRED_WP_VERSION', '4.9' );
define( 'ONEVIEW_PLUGIN', __FILE__ );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-viewer-per-category-activator.php
 */
function activate_one_viewer() {
    add_option('oneview_categories',1);
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-viewer-per-category-deactivator.php
 */
function deactivate_one_viewer() {

}

register_activation_hook( __FILE__, 'activate_one_viewer' );
register_deactivation_hook( __FILE__, 'deactivate_one_viewer' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-one-viewer-endpoints.php';

require plugin_dir_path( __FILE__ ) . 'includes/class-one-viewer.php';



//  Overwrite the default tempalte for /viewer page
add_filter( 'template_include', 'oneviewer_page_template', 99 );

function oneviewer_page_template( $template ) {
    // Check if it's viewer page
    if ( is_page('viewer')  ) {
        $newtemplate = dirname( __FILE__ ) . '/templates/page-one-viewer.php';
        return $newtemplate ;
    }
    return $template;

}
/* 
    One Viewer Run
*/
function wp_one_viewer_run () {

    $urlsInit = new OneViewerEndPoint();
    $urlsInit->Register_Endpoint();

	$plugin = new OneViewerCore();
    $plugin->init();

}
wp_one_viewer_run ();





 