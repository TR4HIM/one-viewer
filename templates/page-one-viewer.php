<?php 
    /* Template Name: Viewer Template */ 
    if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');}
    get_header();

    //Get default Wordpress Api Url
    $REST_API_ENDPOINT = rest_url("wp/v2/");
?>
<div class='viewer-container' id='one-viewer-app' 
        data-api-endpoint   ="<?= $REST_API_ENDPOINT; ?>" 
        data-app-categories ="<?= get_option( 'oneviewer_categories' ); ?>"
         >
    <div class="container">
        <div class = "row justify-content-md-center">
            <div class="col-md-10">
                <div class="card mb-3 oneviewer-post-card" v-touch:swipe="swipeHandler()">
                    <div class="loader" v-if="isLoading">Loading...</div>
                    <!-- Show image if thumbnail exist -->
                    <div    class="post-img" 
                            v-if="results.thumbnail" 
                            v-bind:style="{ backgroundImage: 'url(' + results.thumbnail + ')' }">
                    </div>
                    <div class="card-body" >
                        <h1 class="card-title" v-if="results.post_title">
                            <strong>
                                {{ results.post_title }}
                            </strong>
                        </h1>
                        <div class="card-text" v-if="results.post_content" v-html="results.post_content"></div>
                    </div>
                </div>

                <div class="card mb-3" v-if="!disableNavigation">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <!-- ADD TRANSLATE FUNCTION Later-->
                                <button type="button" class="btn btn-info" 
                                    v-if="results.prevPostId !== null"
                                    @click="showPost(results.prevPostId)">Previous</button>
                            </div>
                            <div class="col text-right">
                                <button type="button" class="btn btn-primary" 
                                    v-if="results.nextPostId !== null"
                                    @click="showPost(results.nextPostId)">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php
    get_footer();
?>