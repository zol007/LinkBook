app.controller('LinksController', ['$scope','$http','Data','Message','$location', function($scope, $http, Data, Message, $location) {

	$scope.message = Message;
     
    Data.get('links').then(function(result){
        console.log("Get links: "+result.message);
        
        if(result.hasOwnProperty('data'))
        {
            // have some items
            $scope.nodata = false; 
            $scope.links = result.data;
              
        }else{
            // no data
            $scope.nodata = true;
            $scope.links = null;
        } 
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

        Data.get('categories').then(function(result){
            $scope.categories = result.data; 
            
        });
        

    if($routeParams.linkId % 1 === 0 && $routeParams.linkId >= 0){
        $scope.editing = true;

        Data.get('links').then(function(result){
            $scope.newlink = result.data[$routeParams.linkId]; 
            // vypisujeme tagy
            if($scope.newlink.tags.length > 0){
                angular.forEach($scope.newlink.tags, function(value, key) {            
                $('input#tags').tagsinput('add', value.tagname);
            });
            }
            
            
        });       
        
    }else{
        $scope.editing = false;
    }
    

    $scope.saveLink = function(link) {
        if(link.ID_link > 0){
            console.log('Updating link');
            
            Data.put("link/"+link.ID_link, {
                link: link
            }).then(function (result) {
                console.log(result.message);
                Data.toast(result);
                $location.path('/');                
            });
           
        }else{
            console.log('Creating new link'); // $routeParams.linkId == "add"

            Data.post('link', {
                link: link
            }).then(function (result) {
                console.log("Status: "+result.status);
                console.log("Message:"+result.message);
                //Message.msg = "Link was saved.";
                Data.toast(result);
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
                    //Message.msg = "Link was deleted.";
                    Data.toast(result);
                    $location.path('/');                
                });
            }
        }
        
    };

}]);