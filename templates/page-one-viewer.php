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
        <div class = "row justify-content-md-center" >
            <div class="col-md-10" v-if="errorFound">
                <div class="alert alert-danger" role="alert">
                    <?= __('Unexpected error please try again') ?>
                </div>
            </div>
            <div class="col-md-10" v-if="!errorFound">
                <div class="card mb-3 onev-card" v-touch:swipe="swipeHandler()">
                    <div class="card-body onev-card-body text-center" v-if="postsNotFound">
                        <p class="lead">
                            <?= __('Posts not found on selected categories') ?>
                        </p>
                    </div>
                    <div class="card-body-container onev-post-card" v-if="!postsNotFound">
                        <div class="loader" v-if="isLoading">Loading...</div>
                        <transition name="fade" >
                            <div class="image-animation" v-if="!isLoading">
                                <div    class="onev-post-img" 
                                        v-if="results.thumbnail" 
                                        v-bind:style="{ backgroundImage: 'url(' + results.thumbnail + ')' }">
                                </div>
                            </div>
                        </transition>
                        <div class="card-body onev-card-body" >
                            <h1 class="card-title mt-3 mb-2" v-if="results.post_title">
                                <transition name="fade" >
                                    <strong v-if="!isLoading">
                                        {{ results.post_title }}
                                    </strong>
                                </transition>
                            </h1>
                            <transition name="fade" >
                                <div class="onev-post-date mb-4" v-if="!isLoading">
                                    <span>{{ results.post_date }}</span>
                                </div>
                            </transition>
                            <transition name="fade" >
                                <div class="one-viewer-content" v-if="!isLoading">
                                    <div class="card-text" v-if="results.post_content" v-html="results.post_content"></div>
                                </div>
                            </transition>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 onev-card onev-buttons" v-if="!disableNavigation">
                    <transition name="fade" >
                        <div class="card-body onev-card-body" v-if="!isLoading">
                            <div class="row">
                                <div class="col-md-6 onev-btn-left">
                                    <button type="button" class="btn btn-info" 
                                        v-if="results.prevPostId !== null"
                                        @click="showPost(results.prevPostId)">
                                        <?= __('Previous') ?>
                                    </button>
                                </div>
                                <div class="col-md-6 onev-btn-right">
                                    <button type="button" class="btn btn-primary" 
                                        v-if="results.nextPostId !== null"
                                        @click="showPost(results.nextPostId)">
                                        <?= __('Next') ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php
    get_footer();
?>