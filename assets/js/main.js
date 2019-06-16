(function () {

    //Get and Save API ENDPOINT for Axios requests
    const API_ENDPOINT          = jQuery('#one-viewer-app').data('api-endpoint');
    const DEFAULT_CATEGORIES    = jQuery('#one-viewer-app').data('app-categories');

    //OneViewer VueJs Init
    var app = new Vue({

        // Application Container ID
        el: '#one-viewer-app',

        // Application Data
        data: {
            results             : [],
            nextPost            : null,
            previousPost        : null,
            selectedCategories  : DEFAULT_CATEGORIES
        },
        
        // Application Methods
        methods: {

            // Request to get last post by categories
            getLatestPost : function () {
                // OneViewer API to get the latest post by category
                let showLatestPostUrl = `${API_ENDPOINT}category/${this.selectedCategories}/latest`;

                axios.get(showLatestPostUrl).then(response => {
                    this.results        = response.data;
                    this.nextPost       = response.data.nextPostId;
                    this.previousPost   = response.data.prevPostId;
                });
            },

            //Get post by id with on click (next/previous buttons)
            showPost: function (id) {
                // OneViewer API to get the latest post by id
                let PostByIdUrl = `${API_ENDPOINT}getpostbyid/${id}/category/${this.selectedCategories}`;

                axios.get(PostByIdUrl).then(response => {
                    this.results        = response.data;
                    this.nextPost       = response.data.nextPostId;
                    this.previousPost   = response.data.prevPostId;
                })
            },

            //Next/Previous with keys
            // j : Previous
            // k : Next
            keyNavigation: function (event) {
                //check if Keycode is for J
                if (event.keyCode == 74) {
                    console.log('Previous');
                    if (this.previousPost != null)
                        this.showPost(this.previousPost);
                }

                //check if Keycode is for K
                if (event.keyCode == 75) {
                    console.log('Next');
                    if (this.nextPost != null)
                        this.showPost(this.nextPost);
                }
            },
        },

        mounted() {
            //save this to use THIS in innerFunctions
            let _self = this;
            //Bind keyup to application window
            window.addEventListener('keyup', function (ev) {
                _self.keyNavigation(ev);
            });

            console.log(this.selectedCategories);
            this.getLatestPost();
        }
    });
})();