app.controller("TakeLeaveController", function ($rootScope,$scope,$routeParams,$location,Upload,$http,$timeout, $window,ModalService) {

	/* |-----------------------------------------------------------|
	   |  attendance function                                      |
	   |-----------------------------------------------------------|
	*/
	$scope.initDate = function(){

	}
	$scope.initDate();
	var url = baseUrl+'attendance/list-all-take-leave';
	$scope.yesNoResult = null;
	$scope.complexResult = null;
	$scope.customResult = null;
	$scope.currentPage = 1;
	$scope.pageSize = 10;
	$scope.not_allow =0;
	$scope.all_status =0;
	$scope.alltdays =18;
	$scope.mef_role_type =[];			
	$scope.section = [];
	$scope.mem_by_pos = [];	
	$rootScope.officer_id = '';
	var n = new Date();
	var d = n.getDay();
	var y = n.getFullYear();
	var m = n.getMonth();
	$scope.currentDt = {
                startDt: n,
				endDt: n
            };
    $scope.selectDay = function(){
		
	}
	$scope.fun_viewer = function(){

		$http({
            method: 'post',
            url: baseUrl+'attendance/take-leav-viewer',
            dataType: "json",
            data:{"_token":_token}
        }).success(function(response) {
			$scope.mef_role_type =response.mef_role_type;			
			$scope.section = response.section;
			
	   	});
	};
	$scope.fun_viewer();
	$scope.num_take =0;
	$scope.num_allow =0;
	$scope.num_not =0;
	$scope.fun_viewers = function(){
		$http.get(url)
		.success(function (data) {
			$.each(data.list, function( index, value ) {
				$scope.num_take +=value.day;
				if(value.status ==''){
					$scope.num_not +=1;
				}else{
					$scope.num_allow +=1;
				}
			});
			$rootScope.listTake = data.list;
			$rootScope.is_approver =data.is_approver;
			$rootScope.is_transfer =data.is_transfer;
			
			$scope.mem_by_pos = data.mem_by_pos;
			
			if(data.officer != null){
				$rootScope.officer_id =data.officer.to_officer_id
				
			}
			
			if(data.list.length>0){
				// $scope.not_allow = data.list[0].not_status;
				$scope.all_status = data.all_date;
				$scope.alltdays = 18 - $scope.all_status;

			}
			// Highcharts.chart('container', {
				// colors: ['#55acee', '#F19B2C'],
				// chart: {
					// type: 'pie',
					// options3d: {
						// enabled: true,
						// alpha: 45,
						// beta: 0
					// }
				// },
				// title: {
					// text: ''
				// },
				// tooltip: {
					// pointFormat: ''
				// },
				// plotOptions: {
					// pie: {
						// allowPointSelect: true,
						// cursor: 'pointer',
						// depth: 35,
						// dataLabels: {
						// enabled: true,
						// format: '{point.name}: {point.y}<b> ថ្ងៃ</b>'

						// }
					// }
				// },
				// series: [{
					// type: 'pie',

					// data: [
						// ['មានច្បាប់', $scope.all_status],
						// ['អាចឈប់បាន', $scope.alltdays],

					// ]
				// }]
			// });

		});
	};


	$scope.showCustom = function() {

		ModalService.showModal({
		  	templateUrl: baseUrl+"attendance",
		  	controller: "CustomController",
		  	inputs: {
				title: "សំនើរសុំអនុញ្ញាតច្បាប់ឈប់សម្រាក",
				currentDt:$scope.currentDt,
				mef_role_type:$scope.mef_role_type,
				pScope:$scope,
				section:$scope.section
			}
		}).then(function(modal) {
		  	modal.close.then(function(result) {
				$scope.customResult = "All good!";

		  	});
		});
	};
	$scope.showTransfer =  function(){
		ModalService.showModal({
		  	templateUrl: baseUrl+"attendance/transfer",
		  	controller: "CustomTransferController",
		  	inputs: {
				title: "ការផ្ទេរសិទ្ធ",
				currentDt:$scope.currentDt,
				mem_by_pos:$scope.mem_by_pos,
				pScope:$scope,
				officer_id:$rootScope.officer_id
			}
		}).then(function(modal) {
		  	modal.close.then(function(result) {
				$scope.customResult = "All good!";

		  	});
		});
	}
	/**
	 * show take leave status by approver
	 */
	$scope.showTakeStatus = function(event){

		$scope.checkApproval(this.user.tId,function(response){
			$scope.callData = response;
			
			ModalService.showModal({
				templateUrl: baseUrl+"attendance/take-leave-approval-view",
				controller: "ApproverTakeLeaveController",
				inputs: {
				title: "សំនើរសុំអនុញ្ញាតច្បាប់ឈប់សម្រាក",
				approveList:$scope.callData
			}
			  }).then(function(modal) {
				modal.close.then(function(result) {
				  $scope.customResult = "All good!";

				});
			  });
		});

	}

	$scope.checkApproval = function(id,callback){
		$scope.cid = id;
		loadingWaiting();
		$http({
            method: 'post',
            url: baseUrl+'attendance/take-leave-approval',
            dataType: "json",
            data:{"_token":_token,"id":$scope.cid}
        }).success(function(response) {
			callback(response);
			$("#new_notifi").removeClass('display-none');
			endLoadingWaiting();
	   });
	}
	//---------------------------------------date--------------
	$scope.getNotification = function(){
		loadingWaiting();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/amount-notification',
            dataType: "json",
            data:{"_token":_token}
        }).success(function(response) {
			$scope.amount = response;
			$("#new_notifi").removeClass('display-none');
			endLoadingWaiting();
	   });
	};

	//--------------------------------------take leave list------------------------------------------------------
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
			{ name: 'no_id',displayName: 'លរ',enableColumnMenu: false, width: '5%', cellTemplate: '<div class="ui-grid-cell-contents ng-binding ng-scope" style="text-align: center">{{ rowRenderIndex + 1 }}</div>' },
			{ name: '_detail', displayName: 'ពិនិត្យមើល',enableColumnMenu: false, width: '18%', cellTemplate: '<div class="ui-grid-cell-contents ng-binding ng-scope" style="text-align: center"><button class="btn btn-default btn-sm" ng-click="grid.appScope.delete($event, row)"><span class="glyphicon glyphicon-eye-open"></span>ព័ត៌មានលំអិត</button></div>' },
			{ name: 'viewer',displayName: 'ឈ្មោះអ្នកស្នើរសុំ',enableColumnMenu: false , width: '22%'},
			{ name: 'mef_viewers',displayName: 'ត្រួតពិនិត្យដោយ' ,enableColumnMenu: false, width: '20%'},
			{ name: 'status',displayName: 'អនុញ្ញាត' ,enableColumnMenu: false, width: '20%'},
			{ name: 'duration',displayName: 'រយៈពេល',enableColumnMenu: false, width: '10%'}

		];
	$scope.delete = function (event, row) {
		//$('#myModalSMS').modal('show');
		$scope.title ='តើអ្នកពិតជាចង់លុបទិន្នន័យនេះ?';
		$scope.message = '';
		$scope.removeId = row.entity.Id;
		window.location.assign(baseUrl+'attendance/view-form-leave/'+$scope.removeId);

	};
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

	$scope.fun_viewers();
});
app.controller('TestCont',function($rootScope,$scope,$routeParams,$location,Upload,$http,$timeout, $window,ModalService){
	console.log('i am here');
})
app.controller("ApproveTakeLeaveController", function ($rootScope,$scope,$routeParams,$location,Upload,$http,$timeout, $window,ModalService) {

	/* |-----------------------------------------------------------|
	   |  attendance function                                      |
	   |-----------------------------------------------------------|
	*/
	var url = baseUrl+'attendance/list-all-take-leave-by-user';
	$scope.yesNoResult = null;
	$scope.complexResult = null;
	$scope.customResult = null;
	var n = new Date();
	var d = n.getDay();
	var y = n.getFullYear();
	var m = n.getMonth();
	$scope.currentDt = {
                startDt: n,
				endDt: n
            };

	$scope.fun_viewers = function(callback){

		$http.get(url)
		.success(function (data) {
			$.each(data, function( index, value ) {console.log(value);
				$scope.num_take += value.day;
				if(value.status ==''){
					$scope.num_not +=1;
				}else{
					$scope.num_allow +=1;
				}
			});
			
			$rootScope.listTakeByUser= data.list;
			console.log(data);
			if(data.is_approver < 1){
				$location.path('/attendance-info')
			}else{
				if(callback){
					callback();
				}
			}

		});
	};

	$scope.fun_viewers(function(){
			if($routeParams.id >0){
				$.each($rootScope.listTakeByUser,function(key,value){
					if($routeParams.id==value.takeleave_id && value.status !=1){
						$scope.showApprove($routeParams.id);
					}
				});

			}
		}
	);
	$scope.showApprove = function(id) {
		$scope.tkid = this.user.tId;console.log($scope.tkid);
		$scope.UserData = this.user;
		if(this.user==undefined){
			$.each($rootScope.listTakeByUser,function(key,value){
				if($scope.tkid==value.takeleave_id){
					$scope.UserData = value;

				}
			});
		}
		ModalService.showModal({
		  	templateUrl: baseUrl+"attendance/approvement",
		  	controller: "ApprovementController",
		  	inputs: {
			title: "សំនើរសុំអនុញ្ញាតច្បាប់ឈប់សម្រាក",
			takeLaveId:$scope.tkid,
			item:$scope.UserData
		  }
		}).then(function(modal) {

		  	modal.close.then(function(result) {
				$scope.customResult = "All good!";

		  	});
		});
	};
	$scope.approve_status = [
		{"Id":'',"title":"ទាំងអស់"},
		{"Id":0,"title":"មិនទាន់ពិនិត្យ"},
		{"Id":1,"title":"អនុញ្ញាត"},
		{"Id":2,"title":"មិនអនុញ្ញាត"}
	]
	var source_approve =
	{
		datatype: "json",
		datafields: [
			{ name: 'Id' },
			{ name: 'title' }
		],
		localdata: $scope.approve_status
	};
	var data_approve =new $.jqx.dataAdapter(source_approve);
	$scope.cboApprove = {
		source: data_approve
		, displayMember: "title"
		, valueMember: "Id"
		, width: '100px'
		, height: 30
		};
});
app.controller('ApprovementController', function($rootScope,$scope, $http, $timeout, $interval, close,title,takeLaveId,item) {

	$scope.title = title;
	$scope.close = close;
	$scope.profile = item;
	if(!$scope.app){
		$scope.app ={
			reason:'',
			approve:1
		}
	}
	console.log($scope.profile);
	loadingWaiting();
	$scope.getTakeLeave = function(callback){
		$scope.apps = {
			takeleave_id : $scope.profile.tId,
			_token : _token
		}
		
		$http({
            method: 'post',
            url: baseUrl+'attendance/take-leave-by-id',
            dataType: "json",
            data:$scope.apps
        }).success(function(response) {
			$scope.takeList = response;
			if(callback){
				callback(response);
			}
			endLoadingWaiting();

	   });
	}

	var url = baseUrl+'attendance/list-all-take-leave-by-user';
	$scope.takeLeave= function(){
		
		if(!$scope.app){
			$scope.app ={
				reason:''
			}
		}
		$scope.app.Id =this.profile.tId;
		$scope.app._token = _token;
		
		var title = 'បញ្ជាក់';
		var content = 'សូមធ្វើការត្រួតពិនិត្យមុននិងបន្តរអនុញ្ញាតិច្បាប់ សូមចុចយល់ព្រម';
		
		confirmDelete(title,content,function () {
			loadingWaiting();
			$http({
				method: 'post',
				url: baseUrl+'attendance/approvement',
				dataType: "json",
				data:$scope.app
			}).success(function(response) {

				var tem_sms = "success";
				if(response.code==0){
					tem_sms = "warning";
				}
				$("#jqx-notification").jqxNotification();
				$('#jqx-notification').jqxNotification({position: positionNotify,template: tem_sms });
				$('#jqx-notification').html(response.message);
				$("#jqx-notification").jqxNotification("open");
				$http.get(url)
				.success(function (data) {
					$rootScope.listTake = data.list;				
					endLoadingWaiting();
					close();
				});

			});
		},function(){
			return false;
		});
		
	}

	/* check radio change*/
	$scope.changeApprove = function(){
		
		if($scope.app.approve==1){
			var title = 'បញ្ជាក់';
			var content = 'ប្រសិនបើអ្នកចុចលុបមូលហេតុនិងលុបដោយស្វ័យប្រវត្តិ';
			confirmDelete(title,content,function () {
				$('#comment').val('');
				$scope.app.reason = '';
				$scope.app.approve = 1;
				document.getElementById("comment").readOnly = true;
				$( "#div_reson" ).hide( "slow", function() {
					// Animation complete.
				});
			},function(){
				$("#approve").prop("checked", true);
			});
		}else{
			
			$( "#div_reson" ).show( "slow", function() {
				// Animation complete.
			  });
			document.getElementById("comment").readOnly = false;
		}
	}
	
	$scope.roles = [];
	$scope.user = {
		roles: []
	};

	$scope.checkAll = function() {
		$scope.user.roles = angular.copy($scope.roles);
	};
	$scope.uncheckAll = function() {
		$scope.user.roles = [];
	};
	$scope.getTakeLeave(function(response){
		$scope.roles = response;
		$scope.user = {
			roles: [$scope.roles[1]]
		};
	});
	$scope.addItem = function() {
		
		$scope.items.push({id: $scope.items.length, text: 'item '+$scope.items.length});
	};

	$scope.removeItem = function() {
		$scope.items.pop();
	};

  $scope.changeItems = function() {
    //$scope.items[0].id = 123;
    $scope.items[0].text = 'item 123';
    $scope.items1[0] = 'item 123';
  };

  $scope.reorder = function() {
    var t = $scope.items[2];
    $scope.items[2] = $scope.items[3];
    $scope.items[3] = t;
  };



});
app.controller('CustomController', function($rootScope,$scope, $http, $timeout, $interval, close,title,currentDt,mef_role_type,pScope,section) {
	$scope.title = title;
	$scope.close = close;
	$scope.app = currentDt;
	$scope.role_type = mef_role_type;
	$scope.section = section;
	$scope.app.num_day=1;
	$scope.pScope = pScope;
	$scope.app.reason ='';
	$scope.app.come_back = '';
	var currentDate = $( ".selector" ).datepicker( "getDate" );
	
	$scope.takeLeave = function(){
		$scope.app.take_leave_type_id =$('input:hidden[name=take_leave_type_id]').val();
		$scope.app.take_leave_role_id =$('input:hidden[name=take_leave_role]').val();
		$scope.app.take_date =$('#div_jqxcalendar_id').val();
		$scope.app._token = _token;
		
		if($scope.app.section =='' ||$scope.app.num_day =='' ){
			$("#jqx-notification").jqxNotification();
			$('#jqx-notification').jqxNotification({position: positionNotify,template: "warning" });
			$('#jqx-notification').html('សូមជ្រើសថ្ងៃណាមួយដែលអ្នចង់សុំច្បាប់');
			$("#jqx-notification").jqxNotification("open");
		}else{
			$http({
	            method: 'post',
	            url: baseUrl+'attendance/save',
	            dataType: "json",
	            data:$scope.app
	        }).success(function(response) {
	        	// loadingWaiting();

	        	// close();
	        	var tem_sms = "success";
	        	if(response.code==0){
					tem_sms = "warning";
				}
				$("#jqx-notification").jqxNotification();
				$('#jqx-notification').jqxNotification({position: positionNotify,template: tem_sms });
				$('#jqx-notification').html(response.message);
				$("#jqx-notification").jqxNotification("open");
				var url = baseUrl+'attendance/list-all-take-leave';
	        	$http.get(url)
				.success(function (data) {
					
					$.each(data.list, function( index, value ) {
						$scope.num_take +=value.day;
						if(value.status ==''){
							$scope.num_not +=1;
						}else{
							$scope.num_allow +=1;
						}
					});
					
					$rootScope.listTake = data.list;
					$rootScope.is_approver =data.is_approver;
					$rootScope.is_transfer =data.is_transfer;
					if(data.list.length>0){
						// $scope.not_allow = data.list[0].not_status;
						$scope.all_status = data.all_date;
						$scope.alltdays = 18 - $scope.all_status;

					}
					// Highcharts.chart('container', {
						// colors: ['#55acee', '#F19B2C'],
						// chart: {
							// type: 'pie',
							// options3d: {
								// enabled: true,
								// alpha: 45,
								// beta: 0
							// }
						// },
						// title: {
							// text: ''
						// },
						// tooltip: {
							// pointFormat: ''
						// },
						// plotOptions: {
							// pie: {
								// allowPointSelect: true,
								// cursor: 'pointer',
								// depth: 35,
								// dataLabels: {
								// enabled: true,
								// format: '{point.name}: {point.y}<b> ថ្ងៃ</b>'

								// }
							// }
						// },
						// series: [{
							// type: 'pie',

							// data: [
								// ['មានច្បាប់', $scope.all_status],
								// ['អាចឈប់បាន', $scope.alltdays],

							// ]
						// }]
					// });

				});

		   	});
		}

	};
	
	// prepare the data
	var sec_source =
	{
		datatype: "json",
		datafields: [
			{ name: 'Id' },
			{ name: 'title' }
		],
		localdata: $scope.role_type
	};
	var sectionAdapter = new $.jqx.dataAdapter(sec_source)
	$scope.comboboxSettingsRoleType = {
		source:sectionAdapter
		, displayMember: "title"
		, valueMember: "Id"
		, width: '100%'
		, height: 30,
		selectedIndex: 0
	};
	// prepare the data
	var sec_source =
	{
		datatype: "json",
		datafields: [
			{ name: 'Id' },
			{ name: 'title' }
		],
		localdata: $scope.section
	};
	var sectionAdapter = new $.jqx.dataAdapter(sec_source)
	$scope.comboboxSettingsSection = {
		source:sectionAdapter
		, displayMember: "title"
		, valueMember: "Id"
		, width: '100%'
		, height: 30,
	};
	
	$scope.checkDate = function(){
		if($scope.app.num_day <1){
			$scope.app.num_day=1;
		}
		// $request->officer_id && $request->take_date && $request->num_day && $request->section
		
		$scope.app.take_date =$('#div_jqxcalendar_id').val();
		// alert($scope.app.section);
		if($scope.app.section == undefined){
			
			return false;
		}
		$data = {
			"_token":_token,
			"section":$scope.app.section,
			"take_date":$scope.app.take_date,
			"num_day":$scope.app.num_day
			
		}
		
		$http({
            method: 'post',
            url: baseUrl+'attendance/check-date',
            dataType: "json",
            data:$data
        }).success(function(response) {
			
			if(response.length>0){
				$scope.app.come_back = response[response.length-1];
			}
			
	   	});
	}

});

app.controller('ApproverTakeLeaveController',function($rootScope,$scope, $http, $timeout, $interval, close,title,approveList){
	$scope.close = close;
	$scope.approveList = approveList;
});
app.controller('CustomTransferController',function($rootScope,$scope, $http, $timeout, $interval, close,title,currentDt,mem_by_pos,pScope,officer_id){
	$scope.close = close;
	$scope.title = title;
	$scope.mem_by_pos = mem_by_pos;
	
	if(!$rootScope.app && officer_id >1){
		
		$rootScope.app = {
			"officer_id" :officer_id
		}
	}
	
	/* function */
	$scope.rightTran = function(){
		
		$rootScope.app._token = _token;
		
		$http({
			method: 'post',
			url: baseUrl+'attendance/transfer',
			dataType: "json",
			data:$rootScope.app
		}).success(function(response) {
			// loadingWaiting();
			if(response.data.to_officer_id  !=undefined){
				$rootScope.app.officer_id= response.data.to_officer_id
			}else{
				$rootScope.app.to_officer_id = '';
			}
			console.log($rootScope.app);
			close();
			var tem_sms = "success";
			if(response.code==0){
				tem_sms = "warning";
			}
			$("#jqx-notification").jqxNotification();
			$('#jqx-notification').jqxNotification({position: positionNotify,template: tem_sms });
			$('#jqx-notification').html(response.message);
			$("#jqx-notification").jqxNotification("open");
		});
	}
	/* inin form */
	var source_officer =
	{
		datatype: "json",
		datafields: [
			{ name: 'Id' },
			{ name: 'full_name_kh' }
		],
		localdata: $scope.mem_by_pos
	};
	console.log($scope.mem_by_pos);
	var data_mef_officer =new $.jqx.dataAdapter(source_officer);
	$scope.comboboxSettingsOfficer = {
		source: data_mef_officer
		, displayMember: "full_name_kh"
		, valueMember: "Id"
		, width: '100%'
		, height: 30
		};
});
app.controller("ScanHistoryController", function ($rootScope,$scope,$routeParams,$location,Upload,$http,$timeout, $window,ModalService) {
	var url = baseUrl+'attendance/list-scan-history';
	$scope.datas = [];

	/**
	init date
	*/
	$scope.start_dt = new Date();
	$scope.start_dt.setDate($scope.start_dt.getDate() - 7);
	$scope.end_dt = new Date();
	$scope.end_dt.setDate($scope.end_dt.getDate() + 7);
	var dateTimeInput = null;
	$scope.settings = {
		width: 250, height: 25, selectionMode: 'range',
		created: function (args) {
			dateTimeInput = args.instance;
			
			dateTimeInput.setRange($scope.start_dt, $scope.end_dt);
		},
		change: function (event) {
			var selection = dateTimeInput.getRange();
			console.log(selection.to.toLocaleDateString());
			if (selection.from != null) {
				$scope.getScanList(selection.to.toLocaleDateString(),selection.from.toLocaleDateString());
			}
		}
	};
	
	$scope.getScanList = function($start,$end){
		$data = {
			"_token":_token,
			"end_dt":$start,
			"start_dt":$end
		}
		$http({
			method: 'post',
			url: url,
			dataType: "json",
			data:$data
		}).success(function(response) {
			if(response.code==1){
				$scope.datas =response.data;
			}
			
		});
	}
	
	$scope.getScanList($scope.start_dt,$scope.end_dt);
});
