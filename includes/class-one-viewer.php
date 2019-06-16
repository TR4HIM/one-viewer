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

if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');}

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
		//Import bootstrap
		wp_enqueue_style( $this->plugin_name.'-cdn-vue','https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), $this->version, 'all' );
		//OneViewer styles
		wp_enqueue_style( $this->plugin_name.'-main-styles',plugins_url( '../assets/css/main.css', __FILE__ ), array(), $this->version, 'all' );

    }
    
    public function enqueue_scripts() {

		// Import Wordpress Jquery
		wp_enqueue_script('jquery');
		//Import VueJs CDN
		wp_enqueue_script( $this->plugin_name.'-cdn-vue', 'https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js',[],'2.6.10' );
		// Import Axios to handle ajax requests
		wp_enqueue_script( $this->plugin_name.'-cdn-axios', 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js',[],'0.19.0' );
		// Import Vue Touch events
		wp_enqueue_script( $this->plugin_name.'-cdn-vue-touch', 'https://cdn.jsdelivr.net/npm/vue2-touch-events@2.0.0/index.min.js',[],'2.0.0' );
		//OneViewer VueJs Application
		wp_enqueue_script($this->plugin_name.'-main', plugins_url( '../assets/js/main.js', __FILE__ ), [], $this->version , true);

    }
	
	/**
	 * Register front end hooks.
	 */
	private function define_front_hooks() {

        add_action( 'wp_enqueue_scripts',array( $this, 'enqueue_styles') );
        add_action( 'wp_enqueue_scripts',array( $this, 'enqueue_scripts') );
	}

	/**
	 * Register all admin hooks.
	 */
	private function define_admin_hooks() {
		add_action('admin_menu', array( $this, 'one_viewer_register_menu_settings'));
		
	}

	public function one_viewer_register_menu_settings(){
		   add_options_page('One Viewer', 'One Viewer', 'manage_options','one-viewer-settings',array( $this, 'one_viewer_admin_template' ));
	}
	/**
	 * Function to get all categories and convert it to HTML template
	 */
	public function AllCategoriesTemplate(){

		//Get all categories
		$categories = get_categories();
		//Get selected categories
		$selectedCategories = get_option( 'oneviewer_categories' );
		//Turn selected categories to array
		$selectedCategoriesToArray = explode(',',$selectedCategories);


		$selectHtml = '<select name="wp-newiewer-select[]" multiple="multiple">';
		// Loop all categories
        foreach ($categories as $category) {
			// Add selected to existing categories on setting page
			if(in_array($category->cat_ID, $selectedCategoriesToArray) ){
				$selectHtml .= '<option value="'.$category->cat_ID.'" selected>';
			}else{
				$selectHtml .= '<option value="'.$category->cat_ID.'">';
			}
            $selectHtml .= $category->cat_name;
            $selectHtml .= '</option>';
		}
		$selectHtml .= '</select>';

		return $selectHtml;

	}

	/**
	 * Page settings template and logic
	 */
	public function one_viewer_admin_template(){
		/**
		 * Check if user clicked save on the settings page.
		 */
		if ( !empty($_POST)){

			//Get selected categories.
			$categories = $_POST['wp-newiewer-select'];

			//Turn selected categories to string
			$categoriesToString = trim(implode(',',$categories));

			//Update setting field with new selected categories
			update_option( 'oneviewer_categories', $categoriesToString);

			//Create Message tempalte
			$HTMLNotice = '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">';
			$HTMLNotice = '<p><strong>Settings saved.</strong></p>';
			$HTMLNotice = '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
			echo $HTMLNotice;
		}

		/**
		 * Page settings template HTML and Form
		 */
		$HTMLTemplate = "";
		$HTMLTemplate .= '<div class="oneviewer-container">';
		$HTMLTemplate .= '<h1>OneViewer Settings</h1>';
		$HTMLTemplate .= '<p>Please choose categories to show on viewer, You can select one or multiple categories</p>';
		$HTMLTemplate .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
		$HTMLTemplate .= '<p>';
		$HTMLTemplate .= $this->AllCategoriesTemplate();;
		$HTMLTemplate .= '</p>';
		$HTMLTemplate .= '<p><input name="Submit" type="submit" class="button-primary" value="Save Changes" /></p>';
		$HTMLTemplate .= '</form>';
		$HTMLTemplate .= '</div>';
		

		echo $HTMLTemplate;
	
	}
	/**
	 * Execute all hooks
	 */
	
	public function init() {
		$this->define_front_hooks();
		$this->define_admin_hooks();
	}
}
