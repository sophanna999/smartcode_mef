app.controller("awardSanctionController", function ($scope,$interval,$http,$filter,$location) {
	$scope.$on("$locationChangeStart", function() {
		if(defaultRouteAngularJs != '/smart-office'){
			$scope.saveAwardSanction();
		}
	});
 	$scope.getAwardSanctionByUserId = function(callback){
		loadingWaiting();
		var editId = $('#indexEdit').val();
	 	$http({
             method: 'post',
             url: baseUrl+'background-staff-gov-info/get-award-sanction-by-id',
             dataType: "json",
             data:{'editId':editId,"_token":_token}
         }).success(function(response) {
	 		callback(response);
        });
     };
 	$scope.getAwardSanctionByUserId(function(data){
		//  គ្រឿងឥស្សរិយយស ប័ណ្ណសរសើរ
		$scope.awardSanctionType1 = data.awardSanctionType1;
		var dataDefault_1	=	[
			{ AWARD_NUMBER : "", AWARD_DATE : "", AWARD_REQUEST_DEPARTMENT : "", AWARD_DESCRIPTION : "", AWARD_KIND : "" }
		];
		if(($scope.awardSanctionType1).length <= 0){
			$scope.awardSanctionType1	=  dataDefault_1; 
		}		
		var AWARD_DATE_TYPE_1 = [];
		var AWARD_REQUEST_DEPARTMENT_TYPE_1 = [];
		setTimeout(function(){
			angular.forEach($scope.awardSanctionType1, function(value, key){
				// AWARD_DATE_TYPE_1
				AWARD_DATE_TYPE_1[key] = value.AWARD_DATE == '0000-00-00' ? '' : value.AWARD_DATE;
				getJqxCalendar('DIV_AWARD_DATE_TYPE_1_' + key,'AWARD_DATE_TYPE_1_' + key,'130px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',AWARD_DATE_TYPE_1[key]);
				$("#AWARD_DATE_TYPE_1_" + key).val(AWARD_DATE_TYPE_1[key]);
				// AWARD_REQUEST_DEPARTMENT_TYPE_1
				AWARD_REQUEST_DEPARTMENT_TYPE_1[key] = value.AWARD_REQUEST_DEPARTMENT;
				initDropDownList(jqxTheme,160,35, '#DIV_AWARD_REQUEST_DEPARTMENT_TYPE_1_' + key,angular.fromJson($("#listDepartmentJson").text()), 'text', 'value', false, '', '0', "#AWARD_REQUEST_DEPARTMENT_TYPE_1_" + key,"ស្វែងរក",200,AWARD_REQUEST_DEPARTMENT_TYPE_1[key]);
				$("#AWARD_REQUEST_DEPARTMENT_TYPE_1_" + key).val(AWARD_REQUEST_DEPARTMENT_TYPE_1[key]);
			});
			
			/* SUMMERY FUNCTION */
			$scope.sumarryData();
			/* SUMMERY FUNCTION END */
			
		}, 2000);
		
		//  ទណ្ឌកម្មវិន័យ
		$scope.awardSanctionType2 = data.awardSanctionType2;		
		var AWARD_DATE_TYPE_2 = [];
		var AWARD_REQUEST_DEPARTMENT_TYPE_2 = [];
		var dataDefault_2	=	[
			{ AWARD_NUMBER : "", AWARD_DATE : "", AWARD_REQUEST_DEPARTMENT : "", AWARD_DESCRIPTION : "", AWARD_KIND : "" }
		];
		if(($scope.awardSanctionType2).length <= 0){
			$scope.awardSanctionType2	=  dataDefault_2; 
		}
		setTimeout(function(){
			angular.forEach($scope.awardSanctionType2, function(value, key){
				// AWARD_DATE_TYPE_2
				AWARD_DATE_TYPE_2[key] = value.AWARD_DATE == '0000-00-00' || value.AWARD_DATE == null  ? '' : value.AWARD_DATE;
				getJqxCalendar('DIV_AWARD_DATE_TYPE_2_' + key,'AWARD_DATE_TYPE_2_' + key,'130px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',AWARD_DATE_TYPE_2[key]);
				$("#AWARD_DATE_TYPE_2_" + key).val(AWARD_DATE_TYPE_2[key]);
				// AWARD_REQUEST_DEPARTMENT_TYPE_2
				AWARD_REQUEST_DEPARTMENT_TYPE_2[key] = value.AWARD_REQUEST_DEPARTMENT;
				initDropDownList(jqxTheme,160,35, '#DIV_AWARD_REQUEST_DEPARTMENT_TYPE_2_' + key,angular.fromJson($("#listDepartmentJson").text()), 'text', 'value', false, '', '0', "#AWARD_REQUEST_DEPARTMENT_TYPE_2_" + key,"ស្វែងរក",200,AWARD_REQUEST_DEPARTMENT_TYPE_2[key]);
				$("#AWARD_REQUEST_DEPARTMENT_TYPE_2_" + key).val(AWARD_REQUEST_DEPARTMENT_TYPE_2[key]);
			});
		}, 2000);
		setTimeout(function(){
			endLoadingWaiting();
		}, 2500);
	});
	$scope.sumarryData = function(){
		/* SUMMERY DATA */
		$("#SUMMARY_AWARD_NUMBER").text($scope.awardSanctionType1[0].AWARD_NUMBER ? $scope.awardSanctionType1[0].AWARD_NUMBER : '');
		$("#SUMMARY_AWARD_DATE_TYPE_1_0").text($("#DIV_AWARD_DATE_TYPE_1_0").attr('aria-valuetext'));
		$("#SUMMARY_AWARD_REQUEST_DEPARTMENT_TYPE_1_0").text($("#dropdownlistContentDIV_AWARD_REQUEST_DEPARTMENT_TYPE_1_0").text());
		$("#SUMMARY_AWARD_DESCRIPTION").text($scope.awardSanctionType1[0].AWARD_DESCRIPTION ? $scope.awardSanctionType1[0].AWARD_DESCRIPTION : '');
		$("#SUMMARY_AWARD_KIND").text($scope.awardSanctionType1[0].AWARD_KIND ? $scope.awardSanctionType1[0].AWARD_KIND : '');
		/* SUMMERY DATA END*/
	};
	$scope.addMoreAwardSanctionType1	=	function(){
		$scope.awardSanctionType1.push({ AWARD_NUMBER : "", AWARD_DATE : "", AWARD_REQUEST_DEPARTMENT : "", AWARD_DESCRIPTION : "", AWARD_KIND : "" });
		var lastIndex	=	($scope.awardSanctionType1).length - 1;
		setTimeout(function(){
			// AWARD_DATE_TYPE_1
			AWARD_DATE_TYPE_1_LAST = $scope.awardSanctionType1[lastIndex].AWARD_DATE;
			getJqxCalendar('DIV_AWARD_DATE_TYPE_1_' + lastIndex,'AWARD_DATE_TYPE_1_' + lastIndex,'130px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',AWARD_DATE_TYPE_1_LAST);
			$("#AWARD_DATE_TYPE_1_" + lastIndex).val(AWARD_DATE_TYPE_1_LAST);
			// AWARD_REQUEST_DEPARTMENT_TYPE_1
			AWARD_REQUEST_DEPARTMENT_TYPE_1_LAST = $scope.awardSanctionType1[lastIndex].AWARD_REQUEST_DEPARTMENT;
			initDropDownList(jqxTheme,160,35, '#DIV_AWARD_REQUEST_DEPARTMENT_TYPE_1_' + lastIndex,angular.fromJson($("#listDepartmentJson").text()), 'text', 'value', false, '', '0', "#AWARD_REQUEST_DEPARTMENT_TYPE_1_" + lastIndex,"ស្វែងរក",200, AWARD_REQUEST_DEPARTMENT_TYPE_1_LAST);
			$("#AWARD_REQUEST_DEPARTMENT_TYPE_1_" + lastIndex).val(AWARD_REQUEST_DEPARTMENT_TYPE_1_LAST);
		}, 200);
	};
	$scope.removeAwardSanctionType1	=	function(keyIndex){
		if(angular.isUndefined(keyIndex) == true){
			$scope.awardSanctionType1.splice($scope.keyIndexAwardSanctionType1Cache,1);
			$('#ModalConfirmAwardSanctionType').modal('hide');
		}else{
			if(
				$scope.awardSanctionType1[keyIndex].AWARD_NUMBER != "" || 
				$("#AWARD_DATE_TYPE_1_" + keyIndex).val() != "" ||
				$("#AWARD_REQUEST_DEPARTMENT_TYPE_1_" + keyIndex).val() != "" ||
				$scope.awardSanctionType1[keyIndex].AWARD_DESCRIPTION != "" ||
				$scope.awardSanctionType1[keyIndex].AWARD_KIND != ""
			){
				$(".btn-confrim-ok").addClass("display-none");
				$("#btnRemoveAwardSanctionType1").removeClass("display-none");
				$('#ModalConfirmAwardSanctionType').modal('show');
				$scope.keyIndexAwardSanctionType1Cache	=	keyIndex;
			}else{
				$scope.awardSanctionType1.splice(keyIndex,1); 
			}
		}
	};
	$scope.addMoreAwardSanctionType2	=	function(){
		$scope.awardSanctionType2.push({ AWARD_NUMBER : "", AWARD_DATE : "", AWARD_REQUEST_DEPARTMENT : "", AWARD_DESCRIPTION : "", AWARD_KIND : "" });
		var lastIndex	=	($scope.awardSanctionType2).length - 1;
		setTimeout(function(){
			// AWARD_DATE_TYPE_2
			AWARD_DATE_TYPE_2_LAST = $scope.awardSanctionType2[lastIndex].AWARD_DATE;
			getJqxCalendar('DIV_AWARD_DATE_TYPE_2_' + lastIndex,'AWARD_DATE_TYPE_2_' + lastIndex,'130px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',AWARD_DATE_TYPE_2_LAST);
			$("#AWARD_DATE_TYPE_2_" + lastIndex).val(AWARD_DATE_TYPE_2_LAST);
			// AWARD_REQUEST_DEPARTMENT_TYPE_2
			AWARD_REQUEST_DEPARTMENT_TYPE_2_LAST = $scope.awardSanctionType2[lastIndex].AWARD_REQUEST_DEPARTMENT;
			initDropDownList(jqxTheme,160,35, '#DIV_AWARD_REQUEST_DEPARTMENT_TYPE_2_' + lastIndex,angular.fromJson($("#listDepartmentJson").text()), 'text', 'value', false, '', '0', "#AWARD_REQUEST_DEPARTMENT_TYPE_2_" + lastIndex,"ស្វែងរក",200,AWARD_REQUEST_DEPARTMENT_TYPE_2_LAST);
			$("#AWARD_REQUEST_DEPARTMENT_TYPE_2_" + lastIndex).val(AWARD_REQUEST_DEPARTMENT_TYPE_2_LAST);
		}, 200);
	};
	$scope.removeAwardSanctionType2	=	function(keyIndex){
		if(angular.isUndefined(keyIndex) == true){
			$scope.awardSanctionType2.splice($scope.keyIndexAwardSanctionType2Cache,1);
			$('#ModalConfirmAwardSanctionType').modal('hide');
		}else{
			if(
				$scope.awardSanctionType2[keyIndex].AWARD_NUMBER != "" || 
				$("#AWARD_DATE_TYPE_2_" + keyIndex).val() != "" ||
				$("#AWARD_REQUEST_DEPARTMENT_TYPE_2_" + keyIndex).val() != "" ||
				$scope.awardSanctionType2[keyIndex].AWARD_DESCRIPTION != "" ||
				$scope.awardSanctionType2[keyIndex].AWARD_KIND != ""
			){
				$(".btn-confrim-ok").addClass("display-none");
				$("#btnRemoveAwardSanctionType2").removeClass("display-none");
				$('#ModalConfirmAwardSanctionType').modal('show');
				$scope.keyIndexAwardSanctionType2Cache	=	keyIndex;
			}else{
				$scope.awardSanctionType2.splice(keyIndex,1);
			}
		}		
	};
	$scope.toObject = function(arr) {
	  var rv = {};
	  if(arr != null){
		for (var i = 0; i < arr.length; ++i)
		rv[i] = arr[i];
	  }
	  return rv;
    };
    $scope.saveAwardSanction = function(nextUrl){
		//  គ្រឿងឥស្សរិយយស ប័ណ្ណសរសើរ
		angular.forEach($scope.awardSanctionType1, function(value, key){
			$scope.awardSanctionType1[key]['AWARD_DATE'] = $("#AWARD_DATE_TYPE_1_" + key).val();
			$scope.awardSanctionType1[key]['AWARD_REQUEST_DEPARTMENT'] = $("#AWARD_REQUEST_DEPARTMENT_TYPE_1_" + key).val();
		});
		//  ទណ្ឌកម្មវិន័យ
		angular.forEach($scope.awardSanctionType2, function(value, key){
			$scope.awardSanctionType2[key]['AWARD_DATE'] = $("#AWARD_DATE_TYPE_2_" + key).val();
			$scope.awardSanctionType2[key]['AWARD_REQUEST_DEPARTMENT'] = $("#AWARD_REQUEST_DEPARTMENT_TYPE_2_" + key).val();
		});
		var data = {
			awardSanctionType1 : $scope.awardSanctionType1,
			awardSanctionType2 : $scope.awardSanctionType2
		};
		var editId = $('#indexEdit').val();
        $http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/award-sanctions',
            dataType: "json",
            data:{'editId':editId,"data":data,"_token":_token}
        }).success(function(response) {
            $("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
			if(response.code == 1){
				$("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
				$('#jqx-notification').html(response.message);
                $("#jqx-notification").jqxNotification("open");
				if(angular.isUndefined(nextUrl) == false){
					$location.path(nextUrl);
				}
				/* SUMMERY FUNCTION */
				$scope.sumarryData();
				/* SUMMERY FUNCTION END */
			}
			if(response.code == 0){
				$("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({position: positionNotify,template: "error" });
				$('#jqx-notification').html(response.message);
                $("#jqx-notification").jqxNotification("open");
			}
			addClassActiveMenu('menu-4');
        });
    };
});