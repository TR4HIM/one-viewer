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
		//OneViewer VueJs Application
		wp_enqueue_script($this->plugin_name.'-main', plugins_url( '../assets/js/main.js', __FILE__ ), [], $this->version , true);

    }
    
	private function define_front_hooks() {

        add_action( 'wp_enqueue_scripts',array( $this, 'enqueue_styles') );
        add_action( 'wp_enqueue_scripts',array( $this, 'enqueue_scripts') );
	}

	private function define_admin_hooks() {
		add_action('admin_init', array( $this, 'sampleoptions_init_fn') );
		add_action('admin_menu', array( $this, 'one_viewer_register_menu_settings'));
		
	}

	// Register our settings. Add the settings section, and settings fields
	public function sampleoptions_init_fn(){
		
	}

	public function one_viewer_register_menu_settings(){
		   add_options_page('One Viewer', 'One Viewer', 'manage_options','one-viewer-settings',array( $this, 'one_viewer_admin_template' ));
	}

	public function AllCategoriesTemplate(){

		$categories = get_categories();
		$selectHtml = '<select name="wp-newiewer-select">';
        foreach ($categories as $category) {
			if($category->cat_ID == get_option( 'oneviewer_categories' )){
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
	public function one_viewer_admin_template(){
		if ( !empty($_POST)){
			$categories = $_POST['wp-newiewer-select'];
			update_option( 'oneviewer_categories', $categories);
			$HTMLNotice = '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">';
			$HTMLNotice = '<p><strong>Settings saved.</strong></p>';
			$HTMLNotice = '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
			echo $HTMLNotice;
		}

		$HTMLTemplate = "";
		$HTMLTemplate .= '<div class="oneviewer-container">';
		$HTMLTemplate .= '<h2>OneViewer Settings</h2>';
		$HTMLTemplate .= '<p>Please choose categories to show on viewer.</p>';
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
