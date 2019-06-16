(function () {

    //Get and Save API ENDPOINT for Axios requests
    const API_ENDPOINT = jQuery('#one-viewer-app').data('api-endpoint');

    //OneViewer VueJs Init
    var app = new Vue({

        // Application Container ID
        el: '#one-viewer-app',

        // Application Data
        data: {
            results         : [],
            nextPost        : null,
            previousPost    : null
        },
        
        // Application Methods
        methods: {

            // Request to get last post by categories
            getLatestPost : function () {
                // OneViewer API to get the latest post by category
                let showLatestPostUrl = `${API_ENDPOINT}category/1/latest`;
                console.log(showLatestPostUrl);

                axios.get(showLatestPostUrl).then(response => {
                    this.results        = response.data;
                    this.nextPost       = response.data.nextPostId;
                    this.previousPost   = response.data.prevPostId;
                });
            },
        },

        mounted() {
            this.getLatestPost();
        }
    });
})();