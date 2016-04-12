app.factory("Data", ['$http','toaster','Message', function ($http, toaster, Message) {

        var serviceBase = 'api/v1/';

        var obj = {};

    
        obj.toast = function (data) {
            toaster.pop(data.status, "", data.message, 10000, 'trustedHtml');
        };
    
        obj.get = function (q) {
            return $http.get(serviceBase + q).then(function (results) {
                return results.data;
            })
            .catch(function(results) {
              console.error('Data error', results.status, results.data);
              Message.msg = results.status;
            });

        };
        obj.post = function (q, object) {
            return $http.post(serviceBase + q, object).then(function (results) {
                return results.data;
            })
            .catch(function(results) {
              console.error('Data error', results.status, results.data);
              Message.msg = results.status;
            });
        };
        obj.put = function (q, object) {
            return $http.put(serviceBase + q, object).then(function (results) {
                return results.data;
            })
            .catch(function(results) {
              console.error('Data error', results.status, results.data);
              Message.msg = results.status;
            });
        };
        obj.delete = function (q) {
            return $http.delete(serviceBase + q).then(function (results) {
                return results.data;
            })
            .catch(function(results) {
              console.error('Data error', results.status, results.data);
              Message.msg = results.status;
            });
        };
        return obj;
}]);

/*
app.factory('links', ['$http', function($http){

	return $http.get('api/v1/links')
	      	.success(function(data){
	    			return data;
	    	})
	    	.error(function(err){
	    			return err;
	    	});
	
}]);
*/