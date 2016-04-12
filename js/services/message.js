app.factory('Message', function(){

	var sharedMsg = {};

  	sharedMsg.msg = '';
  	sharedMsg.err = '';

	return sharedMsg;
    
	
});