
Vue.mixin({
    methods: {
        getUrl() {
            var online = navigator.onLine;
            if (!online) {
                this.infoMessage("No Internet Connection")
            }
            return "/"
        },
        getHTML: async function (url) {
            
            var result = [];

            await ajax
                    .get(this.getUrl() + url)
                    .then(function (response) {
                        console.log(response);

                        result = response;

                    });

            if (result.error) {
                // show message with close callback and options
                this.errorMessage(result.message)
            }

            
            return result;
        },
        get: async function (url) {
            
            var result = [];

            await ajax
                    .get(this.getUrl() + url)
                    .then(function (response) {

                        console.log(response);

                        try {
                            result = JSON.parse(response);
                        } catch (e) {
                            result = {error: true, message: "JSON ERROR"}
                        }


                    }
                    );

            if (result.error) {
                // show message with close callback and options
                this.errorMessage(result.message)
            }
            

            return result;
        },
        upload: async function (url, data) {
            
            var result = [];
            await ajax
                    .upload(this.getUrl() + url, data)
                    .then(function (response) {
                        console.log(response);
                        try {
                            result = JSON.parse(response);
                        } catch (e) {
                            result = {error: true, message: "JSON ERROR"}
                        }


                    }
                    );

            if (result.error) {
                // show message with close callback and options
                this.errorMessage(result.message)
            }
            
            return result;
        },
        post: async function (url, data) {
            
            var result = [];

            await ajax
                    .post(this.getUrl() + url, data)
                    .then(function (response) {
                        console.log(response);
                        try {
                            result = JSON.parse(response);
                        } catch (e) {
                            result = {error: true, message: "JSON ERROR"}
                        }


                    }
                    );

            if (result.error) {
                // show message with close callback and options
                this.errorMessage(result.message)
            }
            
            return result;
        },
        errorMessage: function (message) {
           
        },
        infoMessage: function (message) {
         
        },
        successMessage: function (message) {
        
        },
        popup: function (view, title, data) {

        }, redirect: function (url) {
            location.href = url;
        }
    }
})


    