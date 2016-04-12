app.controller('logOutCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    //initially set those objects to null to avoid undefined error
    $scope.logout = function () {
        Data.get('logout').then(function (results) {
            console.log(results);
            Data.toast(results);
            //$route.reload();
            $scope.userisLogIn = false;
            $location.path('login');
            
        });
    }
});