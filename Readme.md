# One Viewer: View Posts With VueJs.

One Viewer is a lightweight Wordpress plugin that pulls posts from Wordpress API filtered by category and shows posts in nice interface created with VueJs framework. 

   **FEATURES**
* Easy to use nothing to config.
* Loading posts with AJAX.
* Navigation Buttons.
* Navigate using the keyboard ("j" and "k" keys).
* Support for swiping on touch-enabled devices.
* Setting page to select categories.


## Requirments 

* WordPress >= 4.9

## Installation
1. Download plugin from the [Release](https://github.com/jquery/jquery) tab.
2. Install using the WordPress built-in Plugin installer, or Extract the zip file and drop the contents in the `wp-content/plugins/` directory of your WordPress installation.
3. Activate the plugin through the `Plugins` menu in WordPress.
4. Navigate to `Dashboard` ▸ `Settings` ▸ `OneViewer` and select your category.
5. Navigate to https://www.YOURURL.com/viewer to see your posts.

> This plugin will create a '/viewer' page, if you already have a page with the same name, you can't access your old page, but you will not lose any data.
> if you disabled the plugin the old page will work as usual.

## Developer information

1. Clone this repo inside your plugin folder.
2. Open the folder on your preferable editor.
3. This plugin is lightweight based on CDN library
4. Nothing to compile or config.
5. Happy Hacking :)

**Folder Architecture**
    
    ├── assets                   
    │   ├── css                             # Custom styles
    │   ├── js                              # VueJs Application
    │  
    ├── includes                            # Core Files.
    │   ├── class-one-viewer.php            # Class to manage all plugin logic.
    │   ├── class-one-viewer-endpoints.php  # Class to manage plugin routes.
    │  
    ├── templates                           # Plugin Html templates
    │   ├── page-one-viewer.php             # Front-end HTML tempalte.
    │   ├── class-one-viewer-endpoints.php  # Class to manage plugin routes.
    │   
    └── wp-one-viewer.php                   # Plugin bootstrap and plugin info.

 
## Contributing
All contributions are welcome.

## License
[MIT](https://choosealicense.com/licenses/mit/)