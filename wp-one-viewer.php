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
define( 'ONEVIEW_PLUGIN', dirname( __FILE__ ) );

 

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-viewer-per-category-activator.php
 */
function activate_one_viewer() {

    /**
     *  Add option field to save selected categories
     */
    add_option('oneviewer_categories',1);
    
    /**
     * Check if /viewer page already exist
     * 
     */
    $checkViewerPage = get_page_by_path('viewer');
    /**
     *  Create page viewer if it's not exist
     */
    if(empty($checkViewerPage)){
        $post_data = array(
            'post_title'    => wp_strip_all_tags( "Viewer" ),
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_author'   => get_current_user_id(),
        );
        wp_insert_post( $post_data);
    }
 
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





 