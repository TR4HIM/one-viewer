# One Viewer: A Single Page Application To Show Posts With VueJs.

One Viewer is a lightweight Wordpress plugin that pulls posts filtered by category from the Wordpress API. It shows the posts in a nice interface created with VueJs framework, and has a smooth animation when navigating through the posts by clicking next and previous buttons.

One Viewer allows the user to decide which posts should be added to the plugin's interface by selecting one or multiple categories from the settings page. 

**FEATURES**
* Easy to use without any configuration.
* Loading posts with AJAX.
* Navigation Buttons.
* Navigate using the keyboard ("j" and "k" keys).
* Support for swiping on touch-enabled devices.
* Responsive and mobile-friendly.
* "Settings" page to select categories.
* Easily integrated with any theme without affecting any existing styles.


## Requirements 

* WordPress >= 4.9

## Installation
1. Download the plugin from the [Releases](https://github.com/TR4HIM/one-viewer/releases) tab.
2. Install using the WordPress built-in Plugin installer, or Extract the .zip file and drop the contents in the `wp-content/plugins/` directory of your WordPress installation.
3. Activate the plugin through the `Plugins` menu in WordPress.
4. Navigate to `Dashboard` ▸ `Settings` ▸ `OneViewer` and select your categories.
5. Navigate to https://www.YOURURL.com/viewer to see your posts.

> This plugin will create a page at'/viewer', **please note** that if you already have a page with the same name you will not be able to access your old page, but **you will not lose** any data. To avoid this problem you will have to re-name your old page's slug name.
> Otherwise, if you disabled the plugin the old page will be back to work.

## Developer information

1. Clone this repo inside your plugins folder.
2. Open the folder on your preferable editor.
3. This plugin is lightweight and based on CDN libraries.
4. Nothing to compile or config.
5. Happy Hacking :)
 
**Folder Architecture**
    
    ├── assets                   
    │   ├── css                             # Custom styles.
    │   ├── js                              # VueJs Application.
    │  
    ├── includes                            # Core Files.
    │   ├── class-one-viewer.php            # Class to manage all the plugin's logic.
    │   ├── class-one-viewer-endpoints.php  # Class to manage the plugin's routes.
    │  
    ├── templates                           # Plugin Html templates.
    │   ├── page-one-viewer.php             # Front-end HTML tempalte.
    │   
    └── wp-one-viewer.php                   # Plugin bootstraping and plugin info.

 
## Contributing
All contributions are welcome.

## License
[MIT](https://choosealicense.com/licenses/mit/)