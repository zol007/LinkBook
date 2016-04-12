var app = angular.module('LinkBookApp', ['ngRoute', 'toaster', 'bootstrap-tagsinput']);

app.config(['$routeProvider',
  function ($routeProvider) {
        $routeProvider
    .when('/login', {
            title: 'Login',
            templateUrl: 'views/login.html',
            controller: 'authCtrl'
    })
    .when('/logout', {
            title: 'Logout',
            templateUrl: 'views/login.html',
            controller: 'authCtrl'
    })
    .when('/signup', {
            title: 'Signup',
            templateUrl: 'views/signup.html',
            controller: 'authCtrl'
    })
  	.when('/links', {
  			controller: 'LinksController',
    		templateUrl: 'views/links.html'
  	})
  	.when('/links/:linkId', {
  		controller: 'LinkDetailController',
    	templateUrl: 'views/link-detail.html'
  	})
    .when('/about', {
    	templateUrl: 'views/about.html'
  	})    
  	.otherwise({
    	redirectTo: '/links'
  	});
}])
.run(function ($rootScope, $location, Data) {
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;
            Data.get('session').then(function (results) {
                if (results.uid) {
                    $rootScope.authenticated = true;
                    $rootScope.uid = results.uid;
                    $rootScope.name = results.name;
                    $rootScope.email = results.email;
                } else {
                    var nextUrl = next.$$route.originalPath;
                    if (nextUrl == '/signup' || nextUrl == '/login') {
 
                    } else {
                        $location.path("/login");
                    }
                }
            });
        });
    });
