app.controller("newNotificationController", function ($scope,$location,Upload,$http,$timeout, $window) {
	
	$scope.getNewNotification = function(callback){
		loadingWaiting();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/new-notification',
            dataType: "json",
            data:{"_token":_token}
        }).success(function(response) {
			callback(response);
        });
	};
	
	$scope.getNewNotification(function(data){
		for(var i = 0; i < data.length; i++){
			var date = data[i]['CREATED_DATE'];
			var str = date.split(" ");
			var arr = str[0];
			var rel = arr.split("-");
		    data[i]['NEW_DATE'] = rel[2]+"-"+rel[1]+"-"+rel[0]+" "+str[1];
			delete data[i]['CREATED_DATE'];
		}
		$scope.NewNotification = data;
        endLoadingWaiting();
	});

});