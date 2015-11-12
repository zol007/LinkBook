app.controller('LinksController', ['$scope','$http','Data','Message','$location', function($scope, $http, Data, Message, $location) {

	$scope.message = Message;
     
    Data.get('links').then(function(result){
        console.log("Get links: "+result.message);
        //console.log("Data: "+result.data);

        $scope.links = result.data;
        
    }); 

}]);

app.controller('LinkDetailController', ['$scope','$http','Data','Message','$routeParams','$location', function($scope, $http, Data, Message, $routeParams, $location) {

    var req = {
         method: 'POST',
         url: 'http://veronika.kasovsky.cz/',
         headers: {
           'Content-Type': undefined
         },
         data: { test: 'test' }
        }

/*
        $http(req).then(function(response){
            console.log('resopnseTest:'.response);
        }, function(response){
            console.log('responseErrorTest:'.response);
        });
*/
        Data.get('categories').then(function(result){
            $scope.categories = result.data; 
            
        });
        

    if($routeParams.linkId % 1 === 0 && $routeParams.linkId >= 0){
        $scope.actiontitle = "Edit";

        Data.get('links').then(function(result){
            $scope.newlink = result.data[$routeParams.linkId]; 

            // vypisujeme tagy
            angular.forEach($scope.newlink.tags, function(value, key) {            
                $('input#tags').tagsinput('add', value.tagname);
            });
            
        });       
        
    }else{
        $scope.actiontitle = "Add";
    }


    $scope.saveLink = function(newlink) {
        if(newlink.ID_link > 0){
            console.log('Updating link');
            
            Data.put("link/"+newlink.ID_link, newlink).then(function (result) {
                console.log(result.message);
                Message.msg = "Link was updated.";
                $location.path('/');                
            });
           
        }else{
            console.log('Creating new link'); // $routeParams.linkId == "add"

            Data.post('link', newlink).then(function (result) {
                console.log("Status: "+result.status);
                console.log("Message:"+result.message);
                Message.msg = "Link was saved.";
                $location.path('/');                
            });
        }
    };

    $scope.deleteLink = function(ID_link) {
        if(confirm("Are you sure to remove this item?")){
            if(ID_link > 0){
                console.log('Deleting link'+ID_link);
                
                Data.delete("link/"+ID_link).then(function (result) {
                    console.log(result.message);
                    Message.msg = "Link was deleted.";
                    $location.path('/');                
                });
            }
        }
        
    };

}]);