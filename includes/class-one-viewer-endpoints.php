<?php 
/**
 * Define the Endpoints and API routes and functionalities.
 *
 *
 * @since      1.0.0
 * @package    OneViewer
 * @author     Soufiane <tr4him@gmail.com>
 */

class OneViewerEndPoint {
    
    /**
     *  Register API routes
     */
    public function Register_Endpoint() {
        
        add_action( 'rest_api_init', function () {

            register_rest_route( 'wp/v2', '/category/(?P<category>\S+)/latest', array(
                'methods'   => WP_REST_Server::READABLE,
                'callback'  => __CLASS__ .'::linkUrl',
                'args' => [
                    'category'
                ]
            ));
        });
    }

   
 
    public function linkUrl(WP_REST_Request $request){
        var_dump($request);
        die('TEST API');
    }
}