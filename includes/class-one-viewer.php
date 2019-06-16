<?php

/**
 * OneViewer core plugin class.
 * - Import all styles and Script
 * - Manage plugin logic and templates
 *
 * @since      1.0.0
 * @package    OneViewer
 * @author     Soufiane <tr4him@gmail.com>
 */


class OneViewerCore {

	/**
	 * The unique identifier of this plugin.
	 */
	public $plugin_name;

	/**
	 * The current version of the plugin.
	 */
	public $version;

	/**
	 * Define the core functionality of the plugin.
	 */

	public function __construct() {
		$this->version 		= ONEVIEW_VERSION;
		$this->plugin_name 	= 'wp-one-viewer';
	}

	/**
	 * Register all of the hooks.
	 */
    public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name.'-cdn-vue','https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-main-styles',plugins_url( '../assets/css/main.css', __FILE__ ), array(), $this->version, 'all' );

    }
    
    public function enqueue_scripts() {

		// Import Wordpress Jquery
		wp_enqueue_script('jquery');
		wp_enqueue_script($this->plugin_name.'-main', plugins_url( '../assets/js/main.js', __FILE__ ), [], $this->version , true);

    }
    
	private function define_front_hooks() {

        add_action( 'wp_enqueue_scripts',array( $this, 'enqueue_styles') );
        add_action( 'wp_enqueue_scripts',array( $this, 'enqueue_scripts') );
	}

	/**
	 * Run execute all hooks
	 */
	
	public function init() {
		$this->define_front_hooks();
	}
}
