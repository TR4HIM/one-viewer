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
            /**
             * Register route to get the latest post by category
             * @Return : Latest post , previous post and the next post in the same categories.
             * @Params : Category  : can take one category or multiple categories
             * -Examples :  
             *         -One Category        : http://URL/wp-json/wp/v2/category/1/latest
             *         -Multiple Categories : http://URL/wp-json/wp/v2/category/1,15,63/latest
             */

            register_rest_route( 'wp/v2', '/category/(?P<category>\S+)/latest', array(
                'methods'   => WP_REST_Server::READABLE,
                'callback'  => __CLASS__ .'::getLatesPost',
                'args' => [
                    'category'
                ]
            ));

            /**
             * Register route to get post by id
             * @Returns : Current post , previous post and the next post in the same categories.
             * @Params : ID : Post id
             * -Examples : http://URL/wp-json/wp/v2/getpostbyid/180
             */
            register_rest_route( 'wp/v2', '/getpostbyid/(?P<id>\d+)', array(
                'methods'   => WP_REST_Server::READABLE,
                'callback'  => __CLASS__ .'::getPostById',
                'args' => [
                    'id'
                ]
            ));
        });
    }
    /**
     * Function to get the latest post by categories
     */
    public function getLatesPost(WP_REST_Request $request){

        //Get categories ids from url
        $categoriesIds = $request['category'];

        //Default query arguments to get the latest post
        $defaultArgs = array(
            'posts_per_page'    => 1,
            'offset'            => 0,
            'category__and'     => array($categoriesIds),
            'orderby'           => 'date',
            'order'             => 'DESC',
            'post_type'         => 'post',
            'post_status'       => 'publish',
            'suppress_filters'  => true 
        );

        // Get the latest post
        $post       = get_posts( $defaultArgs ); 
        $latestPost = $post[0];
        wp_reset_postdata();
        
        //Next post arguments to get the next post
        $nextPostArgs = array(
            'date_query'     => array( 'after' => $latestPost->post_date ),
        );

        //Merge default arguments and next post arguments to get the next post in the same category
        $nextPostQuery = new WP_Query( array_merge($defaultArgs, $nextPostArgs) );
        $next_post  = $nextPostQuery->post;
        wp_reset_postdata();

        //Previous post arguments to get the previous post
        $prevPostQuery = array(
            'date_query'        => array( 'before' => $latestPost->post_date ),
        );

        //Merge default arguments and previous post arguments to get the previous post in the same category
        $prevPostQuery = new WP_Query( array_merge($defaultArgs, $prevPostQuery));
        $prev_post  = $prevPostQuery->post;
        wp_reset_postdata();

        //Check if the post have image and append it to data object.
        if ( has_post_thumbnail( $latestPost->ID ) ) {
            $latestPost->thumbnail = get_the_post_thumbnail_url($latestPost->ID);
        }else{
            $latestPost->thumbnail = null;
        }
        //Check if the next/previous post not null and append it to data object.
        $latestPost->prevPostId = ($prev_post != null) ? $prev_post->ID : null;
        $latestPost->nextPostId = ($next_post != null ) ? $next_post->ID : null;

        wp_reset_postdata();

        //Return Object data (json)
        return new WP_REST_Response($latestPost);
    }

    /**
     * Function to get post by Id
     */

    public function getPostById(WP_REST_Request $request){

        //Get post by ID
        $postObject       = get_post( $request['id'] ); 

        //Check if the post have image and append it to data object.
        if ( has_post_thumbnail( $postObject->ID ) ) {
            $postObject->thumbnail = get_the_post_thumbnail_url($postObject->ID);
        }else{
            $postObject->thumbnail = null;
        }

        //Get post categories ( to use it for next/previous posts)
        $postCategories = wp_get_post_categories($postObject->ID);
        $postObject->categories = $postCategories;

        //Default arguments for next/previous posts.
        $defaultArgs = array(
            'posts_per_page' => 1,
            'category__and'  => $postCategories,
            'order'          => 'ASC',
        );

        //Next post arguments 
        $nextPostArgs = array(
            'date_query'     => array( 'after' => $postObject->post_date ),
        );

        //Merge default arguments and Next post arguments to get the next post in the same category as the current post
        $nextPostQuery  = new WP_Query( array_merge($defaultArgs, $nextPostArgs) );
        $next_post      = $nextPostQuery->post;
        wp_reset_postdata();

        // Add next id to Data Object
        $postObject->nextPostId = ($next_post != null ) ? $next_post->ID : null;

        //Previous post arguments 
        $prevPostArgs = array(
            'date_query'     => array( 'before' => $postObject->post_date ),
        );

        //Merge default arguments and Previous post arguments to get the previous post in the same category as the current post.
        $prevPostQuery  = new WP_Query( array_merge($defaultArgs, $prevPostArgs) );
        $prev_post      = $prevPostQuery->post;
        wp_reset_postdata();

        $postObject->prevPostId = ($prev_post != null ) ? $prev_post->ID : null;

        //Return Object data (json)
        return new WP_REST_Response($postObject);
    }
    
}