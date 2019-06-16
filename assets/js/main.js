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
            selectedCategories  : DEFAULT_CATEGORIES,
            disableNavigation   : false,
            lockClick           : false,
            isLoading           : true,
        },
        
        // Application Methods
        methods: {

            // Request to get last post by categories
            getLatestPost : function () {
                // Show loading 
                this.isLoading = true;
                
                // OneViewer API to get the latest post by category
                let showLatestPostUrl = `${API_ENDPOINT}category/${this.selectedCategories}/latest`;

                axios.get(showLatestPostUrl).then(response => {
                    this.results            = response.data;
                    this.nextPost           = response.data.nextPostId;
                    this.previousPost       = response.data.prevPostId;
                    // If it a single post hide navigation
                    this.disableNavigation  = (this.nextPost == null & this.previousPost == null) ? true : false;
                    this.isLoading          = false;
                });
            },

            //Get post by id with on click (next/previous buttons)
            showPost: function (id) {
                // Show loading 
                this.isLoading = true;
                // Check if a request already on proccess
                if (this.lockClick)
                    return;
                //Disabled multiple click at once
                this.lockClick = true;
                
                // OneViewer API to get the latest post by id
                let PostByIdUrl = `${API_ENDPOINT}getpostbyid/${id}/category/${this.selectedCategories}`;

                axios.get(PostByIdUrl).then(response => {
                    this.results        = response.data;
                    this.nextPost       = response.data.nextPostId;
                    this.previousPost   = response.data.prevPostId;
                    this.lockClick      = false;
                    this.isLoading      = false;
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

            //Function to handle swipe on touch devices
            swipeHandler() {
                let _self = this;

                return function (direction, event) {

                    if (direction == 'left') {
                        console.log('Previous Swipe');
                        if (_self.previousPost != null)
                            _self.showPost(_self.previousPost);
                    }

                    if (direction == 'right') {
                        console.log('Next Swipe');
                        if (_self.nextPost != null)
                            _self.showPost(_self.nextPost);
                    }

                }
            }
        },

        mounted() {
            //save this to use THIS in innerFunctions
            let _self = this;
            
            //Bind keyup to application window
            window.addEventListener('keyup', function (ev) {
                _self.keyNavigation(ev);
            });

            this.getLatestPost();
        }
    });
})();