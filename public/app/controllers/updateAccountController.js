app.controller("updateAccountController", function ($scope,$location,Upload,$http,$timeout, $window) {
	$scope.removeId='';
	$scope.password = null;
	$scope.passwordConfirmation = null;
	$scope.listOfficerRequest =[];
	$scope.changePassword = function(){
		$scope.listOfficerRequest = [];
		loadingWaiting();
		$http({
            method: 'post',
            url: baseUrl+'register/change-password',
            dataType: "json",
            data:{'user':$scope.user,'oldPass':$scope.oldPass,'password':$scope.password,'passwordConfirmation':$scope.passwordConfirmation}
        }).success(function(response) {
			$("#jqx-notification").jqxNotification();
			$('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
			$('#jqx-notification').html(response.message);
			$("#jqx-notification").jqxNotification("open");
			
			endLoadingWaiting();
        });
	}
	
	$scope.removeMoreframework	=	function(keyIndex){
		if(angular.isUndefined(keyIndex) == true){
			$scope.framework.splice($scope.keyIndexFrameworkCache,1);
			$('#ModalConfirm').modal('hide');
		}else{
			if($scope.framework[keyIndex].INSTITUTION != "" || $("#START_DATE_VALUE_" + keyIndex).val() != "" || $("#END_DATE_VALUE_" + keyIndex).val() != ""){
				$(".btn-confrim-ok").addClass("display-none");
				$("#btnRemoveMoreframework").removeClass("display-none");
				$('#ModalConfirm').modal('show');
				$scope.keyIndexFrameworkCache	=	keyIndex;
			}else{
				$scope.framework.splice(keyIndex,1);
			}
		}
	}
	
	$scope.friend =[];
	$scope.getNewNotification = function(){
		var url = baseUrl+'updateInfo/all-notification';	
		$http.get(url)
		.success(function (data) {
			$scope.NewNotification = data;
		});
	}
	
	$scope.getListOfficerRequest = function(){
		$http({
            method: 'get',
            url: baseUrl+'updateInfo/all-officer-request',
            dataType: "json",
        }).success(function(response) {
			$scope.listOfficerRequest = response;
			
			endLoadingWaiting();
        });
	}
	var url = baseUrl+'updateInfo/all-officer-request';	
	
	$scope.addOfficerRequest = function(){
		
		$http({
            method: 'post',
            url: baseUrl+'updateInfo/all-officer-request',
            dataType: "json",
            data:$scope.app
        }).success(function(response) {
			$http.get(url)
			.success(function (data) {
				$scope.gridOptions.data = data;
				
			});
			var tem_sms = "success";
			if(response.code==0){
				tem_sms = "warning";
			}
			$("#jqx-notification").jqxNotification();
			$('#jqx-notification').jqxNotification({position: positionNotify,template: tem_sms });
			$('#jqx-notification').html(response.message);
			$("#jqx-notification").jqxNotification("open");
			// endLoadingWaiting();
        });
	}
	
	var initWidgets = function (tab) {
		switch (tab) {
			case 0:
				$scope.getNewNotification();
				break;
			case 1:
				$scope.refresh;
				break;
		}
	}
	$scope.tabsSettings = { width: '100%', initTabContent: initWidgets };
	$scope.gridOptions = {
		selectionRowHeaderWidth: 35,
		rowHeight: 35,
		enableColumnMenu: false,
		showFilter:false,
		showGroupPanel:false,
		enableSorting: true,
		showFooter:true
	  };
	$scope.gridOptions.columnDefs = [
			{ name: 'no_id',displayName: 'លរ',enableColumnMenu: false, width: '5%', cellTemplate: '<div class="ui-grid-cell-contents ng-binding ng-scope">{{ rowRenderIndex + 1 }}</div>' },
			{ name: '_delete', displayName: 'លុបទិន្នន័យ',enableColumnMenu: false, width: '8%', cellTemplate: '<div class="ui-grid-cell-contents ng-binding ng-scope"><button class="btn btn-danger btn-xs btn-block" ng-click="grid.appScope.delete($event, row)"><span class="glyphicon glyphicon-trash"></span></button></div>' },
			{ name: 'FULL_NAME_KH',displayName: 'គោត្តនាម-នាម' ,enableColumnMenu: false, width: '20%'},
			{ name: 'FULL_NAME_EN',displayName: 'ជាអក្សរឡាតាំង',enableColumnMenu: false , width: '20%'},
			{ name: 'PLACE_OF_BIRTH',displayName: 'កន្លែងកំណើត' ,enableColumnMenu: false, width: '37%'},
			{ name: 'is_status',displayName: 'សំគាល់',enableColumnMenu: false, width: '10%'}
		];
	$scope.delete = function (event, row) {
		$('#myModalSMS').modal('show');
		$scope.title ='តើអ្នកពិតជាចង់លុបទិន្នន័យនេះ?';
		$scope.message = '';
		$scope.removeId = row.entity.no_id;
	}
	$scope.agreeRemove = function(event){
		loadingWaiting();
		$http({
            method: 'post',
            url: baseUrl+'updateInfo/remove-notification',
            dataType: "json",
            data:{ID:event.removeId}
        }).success(function(response) {
			var tem_sms = "success";
			$http.get(url)
			.success(function (data) {
				$scope.gridOptions.data = data;
				
			});
			if(response.code==0){
				tem_sms = "warning";
			}
			$("#jqx-notification").jqxNotification();
			$('#jqx-notification').jqxNotification({position: positionNotify,template: tem_sms });
			$('#jqx-notification').html(response.message);
			$("#jqx-notification").jqxNotification("open");
			endLoadingWaiting();
			$('#myModalSMS').modal('hide');
        });
	}
	$http.get(url)
	.success(function (data) {
		$scope.gridOptions.data = data;
		
	});
	$scope.info = {};
 
	$scope.getSMSbyId = function(id){
		$http({
            method: 'post',
            url: baseUrl+'updateInfo/get-message-id',
            dataType: "json",
            data:{"Id":id}
        }).success(function(response) {
			$scope.message = response[0].COMMENT;
			$scope.title = response[0].TITLE;
			$scope.time = response[0].CREATED_DATE;
        });
	};
	
});

