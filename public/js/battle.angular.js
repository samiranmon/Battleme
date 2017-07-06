angular.module('battle', [])
  .controller('battleCtrl', ['$scope','$http', function($scope, $http) {
    //var battle = this;
    
    console.log('Battle Controller');
    $scope.user             = {};
    $scope.user.picture     = 'https://fbstatic-a.akamaihd.net/rsrc.php/v2/yo/r/UlIqmHJn-SK.gif';
    $scope.loggedIn         = false;
    $scope.profile          = {};
    $scope.profile.user     = {};
    //$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
  



    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
      console.log('statusChangeCallback');
      console.log('Status CHange:',response);
      // The response object is returned with a status field that lets the
      // app know the current login status of the person.
      // Full docs on the response object can be found in the documentation
      // for FB.getLoginStatus().
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        getMe();
        
        /*
        $http.post('/api', { action:'api', endpoint: 'auth', fbid: $scope.user.id }).
        success(function(data, status, headers, config) {
          console.log('Success Post Api',data,status,headers,config);
          $scope.loggedIn == true;
          // this callback will be called asynchronously
          // when the response is available
        }).
        error(function(data, status, headers, config) {
          console.log('Error Post Api');
          $scope.loggedIn == false;
          // called asynchronously if an error occurs
          // or server returns response with an error status.
        });
*/
        
        /*$.post("/api",
        {action:"api",endpoint:"login",age:"31"},
        function(data, textStatus, jqXHR)
        {
              //data: Received from server
        });*/

      } else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        console.log('Please log ' + 'into this app.');
      } else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        console.log('Please log ' + 'into Facebook.');
      }
    }

    // This function is called when someone finishes with the Login
    // Button.  See the onlogin handler attached to it in the sample
    // code below.
    function checkLoginState() {
      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    }

    // Here we run a very simple test of the Graph API after login is
    // successful.  See statusChangeCallback() for when this call is made.
    function getMe() {
      console.log('Welcome!  Fetching your information.... ');


      //FB.api('/'+$scope.user.id+'', function(response) {
      FB.api('/me', function(response) {
        console.log('TEST API:',response);
        //loggedIn();
        $scope.user = response;
        console.log('Id:',$scope.user.id);
        console.log('Successful login for: ' + response.name);
        console.log('Thanks for logging in, ' + response.name + '!');

        var xsrf = $.param({ 
          action: "api", 
          endpoint: 'fbauth', 
          fbid: $scope.user.id,
          fname: $scope.user.first_name,
          lname: $scope.user.last_name,
          email: $scope.user.email
        });
        $http({
            method: 'POST',
            url: "/api",
            data: xsrf,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(data, status, headers, config) {
          console.log('Success Post Api',data,status,headers,config);


          $scope.loggedIn = true;
          $scope.user = data;
          FB.api(
              "/"+$scope.user.id+"/picture",
              function (responseB) {
                if (responseB && !responseB.error) {
                  /* handle the result */
                  console.log('Picture',responseB);
                  $scope.user.picture = responseB.data.url;
                  console.log('Scope User Picture:', $scope.user.picture);
                }
              }
          );

          // this callback will be called asynchronously
          // when the response is available
        }).
        error(function(data, status, headers, config) {
          console.log('Error Post Api');
          $scope.loggedIn = false;
          // called asynchronously if an error occurs
          // or server returns response with an error status.
        });


      });
    }

    window.fbAsyncInit = function() {
      FB.init({
        appId      : '248878102151192',
        xfbml      : true,
        version    : 'v2.5'
      });

      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    };

    /*
    (function(d, s, id){
           var js, fjs = d.getElementsByTagName(s)[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement(s); js.id = id;
           js.src = "//connect.facebook.net/en_US/sdk.js";
           fjs.parentNode.insertBefore(js, fjs);
         }(document, 'script', 'facebook-jssdk'));*/
    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "//connect.facebook.net/en_US/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));


  }]);
