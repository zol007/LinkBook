var app = angular.module('LinkBookApp', ['ngRoute', 'bootstrap-tagsinput']);

app.config(function($routeProvider){
	$routeProvider
  	.when('/links', {
  			controller: 'LinksController',
    		templateUrl: 'views/links.html'
  	})
  	.when('/links/:linkId', {
  		controller: 'LinkDetailController',
    	templateUrl: 'views/link-detail.html'
  	})
    /*
    .when('/links/new', {
      controller: 'LinkNewController',
      templateUrl: 'views/link-detail.html'
    })*/
  	.otherwise({
    	redirectTo: '/links'
  	});
});

