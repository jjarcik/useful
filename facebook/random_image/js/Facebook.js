var Facebook = function (appId) {

    this.init = function (callbackafterlogin) {

        (function (d, s, id) {

            var js, fjs = d.getElementsByTagName(s)[0];
            
            if (d.getElementById(id)) {
                return;
            }

            js = d.createElement(s);
            js.id = id;
            js.src = "http://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        window.fbAsyncInit = function () {
           console.log("init facebook...");
           FB.init({
            appId: appId,
            xfbml: true,
            version: 'v2.2',
            status: true,
            cookie: true
        });


           FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                console.log('You are Logged in.');
                callbackafterlogin();
            } else {
                console.log("LOGIN");
                FB.login();
            }

        });

       };

   };

   this.getRandomImage = function (callback) {                     

            // Start Normal API
            FB.api('/me/photos', function (response)
            {
                if (response && !response.error) {
                    console.log(response);
                    var d = response.data;

                    console.log("you have " + d.length + " images");

                    var images = [];
                    for (var i = 0, l = d.length; i < l; i++) {
                                              
                         images.push(d[i].images[0].source);

                        // iteration on sizes
                        // for (var j = 0; j < d[i].images.length; j++) {
                        //    images.push(d[i].images[j].source);
                        // } 
                    }

                    callback(images[Math.floor((Math.random() * images.length) + 1)]);
                   
                }

            });


        };
    };