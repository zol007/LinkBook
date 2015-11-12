//Define an angular module for our app
var myApp = angular.module('myApp', ['ngTagsInput']);

myApp.controller('linksController', function($scope, $http) {
  
  getLink(); // Load all available links 
  getCategory();
 
  function getLink(){  
    $http.post("ajax/getLink.php").success(function(data){
        $scope.links = data;
        console.log(data);
    });
  };
  
  
  /*
  $scope.$watch('newlink.url', function(val){
       console.log("url: "+val);
  });
    */
 
  $scope.addLink = function () {
     console.log("priority: "+$scope.newlink.priority);
     console.log("name: "+$scope.newlink.name);
     console.log("category: "+$scope.newlink.category);
     console.log("tags: "+$scope.newlink.tags);
     /*
     angular.forEach($scope.newlink.tags, function(value, key) {
         console.log("tag: "+value.text);
     
     });  */
     
    $http.post('ajax/addLink.php', $scope.newlink).success(function(data) {
        console.log(data);
        /*
        if (!data.success) {
          $scope.message = data;          
        }           */
        
        getLink();
        $scope.newlink.name = "";
        $scope.newlink.url = "";
        $scope.newlink.priority = false;
        $scope.newlink.tags = "";
      });
    
  };
  
  function getCategory(){  
    $http.post("ajax/getCategory.php").success(function(data){
        $scope.categories = data;
        //$scope.newlink.selectedcategory = $scope.categories[3].ID_category;
    });
    
  };
  
  
  /*
  $scope.tags = [
                    { text: 'just' },
                    { text: 'tags' }
  ];*/ 
  /*
  $scope.loadTags = function(query) {
      return $http.get('/tags?query=' + query);
  }; */
    


});
