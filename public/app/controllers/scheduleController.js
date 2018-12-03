app.controller("scheduleController", function ($scope,$interval,$filter,$http,$rootScope) {

	$scope.getSituationPublicInfoByUserId = function (callback) {
		loadingWaiting();
		var editId = $('#indexEdit').val();
		var dataDefault	=	[{}];
		$scope.Guest	=  dataDefault;
		$http({
			method: 'post',
			url: baseUrl + 'schedule/get-situation-public-info-by-user-id',
			dataType: "json",
			data: {'editId': editId, "_token": _token}
		}).success(function (response) {
			callback(response);
		});
	}

	$scope.holiday = [];
	var arrOfficerId = new Array();
	$scope.getSituationPublicInfoByUserId(function (response) {
		var data = response.main;
		$scope.framework = response.framework;
		$scope.frameworkFree = response.frameworkFree;

		endLoadingWaiting();
	});
	console.log(1);
	getJqxCalendar('div_DateSearch','dateSearch','100%','32px','','');




});