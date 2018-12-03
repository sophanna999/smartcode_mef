app.controller("workHistoryController", function ($scope,$interval,$http,$filter,$location) {
	$scope.$on("$locationChangeStart", function() {
		if(defaultRouteAngularJs != '/smart-office'){
			$scope.saveWorkingHistory();
		}
	});
	$scope.saveWorkingHistory = function(nextUrl){
		/* ក្នុងមុខងារសាធារណៈ */
		angular.forEach($scope.workHistoryObj, function(value, key){
			$scope.workHistoryObj[key]['START_WORKING_DATE'] = $("#START_WORKING_DATE_" + key).val();
			$scope.workHistoryObj[key]['END_WORKING_DATE'] = $("#END_WORKING_DATE_" + key).val();
			// $scope.workHistoryObj[key]['DEPARTMENT'] = $("#DEPARTMENT_" + key).val();
			// $scope.workHistoryObj[key]['POSITION'] = $("#POSITION_" + key).val();
		});	
		
		/* ក្នុងវិស័យឯកជន */
		angular.forEach($scope.workHistoryObjPrivate, function(value, key){
			$scope.workHistoryObjPrivate[key]['PRIVATE_START_DATE'] = $("#PRIVATE_START_DATE_" + key).val();
			$scope.workHistoryObjPrivate[key]['PRIVATE_END_DATE'] = $("#PRIVATE_END_DATE_" + key).val();
		});
		var data = {
			workHistoryObj : $scope.workHistoryObj,
			workHistoryObjPrivate : $scope.workHistoryObjPrivate
		};
		/* Object Validation */
		var objectValidation = {
			DEPARTMENT_0 : $scope.workHistoryObj[0].DEPARTMENT,
			END_WORKING_DATE_0 : $scope.workHistoryObj[0].END_WORKING_DATE,
			INSTITUTION_0 : $scope.workHistoryObj[0].INSTITUTION ? $scope.workHistoryObj[0].INSTITUTION : '',
			POSITION_0 : $scope.workHistoryObj[0].POSITION,
			// POSITION_EQUAL_TO_0 : $scope.workHistoryObj[0].POSITION_EQUAL_TO ? $scope.workHistoryObj[0].POSITION_EQUAL_TO : '',
			START_WORKING_DATE_0 : $scope.workHistoryObj[0].START_WORKING_DATE
		};
		if ($('input#CURRENT_CHECK_0').is(':checked')) {
			objectValidation.END_WORKING_DATE_0	=	'0000-00-00';
		}
		/* Call function validation */
		var IS_REGISTER = 1;
		if($scope.validationObject(objectValidation) == false){
			var IS_REGISTER = 0;
		}
		/* End Call function validation */
		var editId = $('#indexEdit').val();
        $http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/working-history',
            dataType: "json",
            data:{"data":data,'editId':editId,"_token":_token,"IS_REGISTER":IS_REGISTER}
        }).success(function(response) {
            $("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
			if(response.code == 1){
				$("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
				$('#jqx-notification').html(response.message);
                $("#jqx-notification").jqxNotification("open");
				if(IS_REGISTER == 1){
					addClassActiveMenu('menu-3');
				}else{
					removeClassActiveMenu('menu-3');
				}
				/* SUMMERY FUNCTION */
				$scope.sumarryData();
				/* SUMMERY FUNCTION END */
				if(angular.isUndefined(nextUrl) == false){
					$location.path(nextUrl);
				}
			}
        });
    };	
	
	$scope.validationObject = function(data){
		var countError	=	0;
		$.each(data, function( index, value ) {
			if(value == "" || value == 0){
				countError	=	countError + 1;
			}
		});
		if(countError > 0){
			return false;
		}else{
			return true;
		}
    }
	
	/* $scope.getAutoCompleted = function(){
		loadingWaiting();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/get-auto-completed',
            dataType: "json",
            data:{"_token":_token,"formId":"03"}
        }).success(function(response) {
			var result_1 = {};
			var result_2 = {};
			var result_3 = {};
			var result_4 = {};
			var result_5 = {};
			var result_6 = {};
			var result_7 = {};
			
			var department = response.DEPARTMENT;
			var institution = response.INSTITUTION;
			var position = response.POSITION;
			var position_equal = response.POSITION_EQUAL_TO;
			var private_department = response.PRIVATE_DEPARTMENT;
			var private_role = response.PRIVATE_ROLE;
			var private_skill = response.PRIVATE_SKILL;

			for (var i = 0; i < department.length; i++) {
				result_1[i] = department[i]['DEPARTMENT'];
			}
			angular.forEach($scope.workHistoryObj, function(value, key){
				$("#DEPARTMENT_" + key).jqxInput({ placeHolder: "ក្រសួង-ស្ថាប័ន", height: 36, width: 186, minLength: 1, source: result_1 });
			});
			
			for(var j = 0; j < institution.length; j++){
				result_2[j] = institution[j]['INSTITUTION'];
			}
			angular.forEach($scope.workHistoryObj, function(value, key){
				$("#INSTITUTION_" + key).jqxInput({ placeHolder: "អង្គភាព", height: 36, width: 186, minLength: 1, source: result_2 });
			});
			
			for(var k = 0; k < position.length; k++){
				result_3[k] = position[k]['POSITION'];
			}
			angular.forEach($scope.workHistoryObj, function(value, key){
				$("#POSITION_" + key).jqxInput({ placeHolder: "មុខតំណែង", height: 36, width: 186, minLength: 1, source: result_3 });
			});
			
			for(var l = 0; l < position_equal.length; l++){
				result_4[l] = position_equal[l]['POSITION_EQUAL_TO'];
			}
			angular.forEach($scope.workHistoryObj, function(value, key){
				$("#POSITION_EQUAL_TO_" + key).jqxInput({ placeHolder: "ឋានៈស្មើ", height: 36, width: 186, minLength: 1, source: result_4 });
			});
			
			for(var m = 0; m < private_department.length; m++){
				result_5[m] = private_department[m]['PRIVATE_DEPARTMENT'];
			}
			angular.forEach($scope.workHistoryObjPrivate, function(value, key){
				$("#PRIVATE_DEPARTMENT_" + key).jqxInput({ placeHolder: "គ្រឹះស្ថាន/អង្គភាព", height: 36, width: 186, minLength: 1, source: result_5 });
			});
			
			for(var n = 0; n < private_role.length; n++){
				result_6[n] = private_role[n]['PRIVATE_ROLE'];
			}
			angular.forEach($scope.workHistoryObjPrivate, function(value, key){
				$("#PRIVATE_ROLE_" + key).jqxInput({ placeHolder: "តួនាទី", height: 36, width: 186, minLength: 1, source: result_6 });
			});
			
			for(var p = 0; p < private_skill.length; p++){
				result_7[p] = private_skill[p]['PRIVATE_SKILL'];
			}
			angular.forEach($scope.workHistoryObjPrivate, function(value, key){
				$("#PRIVATE_SKILL_" + key).jqxInput({ placeHolder: "ជំនាញ/បច្ចេកទេស", height: 36, width: 186, minLength: 1, source: result_7 });
			});
			endLoadingWaiting();
        });
	}
	$scope.getAutoCompleted();
    */
    $scope.getWorkHistoryByUserId = function(callback){
		loadingWaiting();
		var editId = $('#indexEdit').val();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/get-work-history-by-id',
            dataType: "json",
            data:{'editId':editId,"_token":_token}
        }).success(function(response) {
			callback(response);
        });
    }
	
	$scope.getWorkHistoryByUserId(function(data){
		var dataDefault	=	[
			{ START_WORKING_DATE : "", END_WORKING_DATE : "", DEPARTMENT : "", INSTITUTION : "", POSITION_EQUAL_TO : "", POSITION : "" }
		];
		if(data.length <= 0){
			$scope.workHistoryObj	=  dataDefault; 
		}else{
			$scope.workHistoryObj	=  data;
		}
		var dateStartValue = [];
		var dateEndValue = [];
		var departerment = [];
		var position = [];
		setTimeout(function(){
			angular.forEach($scope.workHistoryObj, function(value, key){
				// 
				dateStartValue[key] = value.START_WORKING_DATE == '0000-00-00' ? '' : value.START_WORKING_DATE;
				getJqxCalendar('DIV_START_WORKING_DATE_' + key,'START_WORKING_DATE_' + key,'95px','32px','ចូល',dateStartValue[key]);
				$("#START_WORKING_DATE_" + key).val(dateStartValue[key]);
				// 
				dateEndValue[key] = value.END_WORKING_DATE == '0000-00-00' ? '' : value.END_WORKING_DATE;
				getJqxCalendar('DIV_END_WORKING_DATE_' + key,'END_WORKING_DATE_' + key,'95px','32px','បញ្ចប់',dateEndValue[key]);
				$("#END_WORKING_DATE_" + key).val(dateEndValue[key]);
				//
				/*				
				departerment[key] = value.DEPARTMENT;
				initDropDownList(jqxTheme,180,35, '#DIV_DEPARTMENT_' + key,angular.fromJson($("#listDepartmentJson").text()), 'text', 'value', false, '', '0', "#DEPARTMENT_" + key,"ស្វែងរក",200,departerment[key]);
				$("#DEPARTMENT_" + key).val(departerment[key]);
				//
				/*
				position[key] = value.POSITION;	
				initDropDownList(jqxTheme,150,35, '#DIV_POSITION_' + key,angular.fromJson($("#listPositionJson").text()), 'text', 'value', false, '', '0', "#POSITION_" + key,"ស្វែងរក",300,position[key]);
				$("#POSITION_" + key).val(position[key]);
				*/
				// Checked and Un checked
				if(dateEndValue[key] == ''){
					$('input#CURRENT_CHECK_' + key).attr('checked',true);
				}
				if ($('input#CURRENT_CHECK_' + key).is(':checked')) {
					$("#DIV_END_WORKING_DATE_" + key).jqxDateTimeInput({ disabled: true,placeHolder: "ចូល", value:null });
				}
				/* validate between start date and end date WorkHistory */
				$('#DIV_START_WORKING_DATE_' + key).on('change',function(){
					var DIV_START_WORKING_DATE = $('#START_WORKING_DATE_' + key).val();
					if(DIV_START_WORKING_DATE != null){
						if(DIV_START_WORKING_DATE == ""){
							$('#DIV_END_WORKING_DATE_' + key).jqxDateTimeInput({ disabled: true });
							var START_WORKING_DATE =  DIV_START_WORKING_DATE.split("-");
							$('#DIV_END_WORKING_DATE_' + key).jqxDateTimeInput('min',new Date(parseInt(START_WORKING_DATE[0]), START_WORKING_DATE[1], 1));
							// $('#DIV_END_WORKING_DATE_' + key).jqxDateTimeInput('setDate', new Date(parseInt(START_WORKING_DATE[0]), START_WORKING_DATE[1], 1));
						} else {
							// $('#DIV_END_WORKING_DATE_' + key).jqxDateTimeInput({ disabled: false });
							var START_WORKING_DATE =  DIV_START_WORKING_DATE.split("-");
							$('#DIV_END_WORKING_DATE_' + key).jqxDateTimeInput('min',new Date(parseInt(START_WORKING_DATE[0]), START_WORKING_DATE[1], 1));
							// $('#DIV_END_WORKING_DATE_' + key).jqxDateTimeInput('setDate', new Date(parseInt(START_WORKING_DATE[0]), START_WORKING_DATE[1], 1));
						}
					}
				});
				
				/* validate between start date and end date WorkHistory loop */
				var DIV_START_WORKING_DATE = $('#START_WORKING_DATE_' + key).val();
				var START_WORKING_DATE =  DIV_START_WORKING_DATE.split("-");
				$('#DIV_END_WORKING_DATE_' + key).jqxDateTimeInput('min',new Date(parseInt(START_WORKING_DATE[0]), START_WORKING_DATE[1], 1));
				/* validate between start date and end date WorkHistory loop End */
			});
			
			/* SUMMERY FUNCTION */
			$scope.sumarryData();
			/* SUMMERY FUNCTION END */
			
		}, 2000);
		setTimeout(function(){
			endLoadingWaiting();
		},2500);
	});
	
	$scope.sumarryData = function(){
		/* Summary Data */
		$("#SUMMARY_START_WORKING_DATE_0").text($("#DIV_START_WORKING_DATE_0").attr('aria-valuetext'));
		$("#SUMMARY_END_WORKING_DATE_0").text(($("#END_WORKING_DATE_0").val() == 'undefined-undefined-' ? 'បច្ចុប្បន្ន' : $("#END_WORKING_DATE_0").val()));
		$("#SUMMARY_DEPARTMENT_0").text($scope.workHistoryObj[0].DEPARTMENT ? $scope.workHistoryObj[0].DEPARTMENT : '');
		$("#SUMMARY_INSTITUTION_0").text($scope.workHistoryObj[0].INSTITUTION ? $scope.workHistoryObj[0].INSTITUTION : '');
		$("#SUMMARY_POSITION_0").text($scope.workHistoryObj[0].POSITION ? $scope.workHistoryObj[0].POSITION : '');
		$("#SUMMARY_POSITION_EQUAL_TO_0").text($scope.workHistoryObj[0].POSITION_EQUAL_TO ? $scope.workHistoryObj[0].POSITION_EQUAL_TO : '');
		/* Summary Data End */
	}
	
	 $scope.getWorkHistoryPrivateByUserId = function(callback){
		loadingWaiting();
		var editId = $('#indexEdit').val();
		$http({
             method: 'post',
             url: baseUrl+'background-staff-gov-info/get-work-history-private-by-id',
             dataType: "json",
             data:{'editId':editId,"_token":_token}
         }).success(function(response) {
	 		callback(response);
         });
     }
	 $scope.getWorkHistoryPrivateByUserId(function(data){
	 	var dataDefaultPrivate	=	[
			{ PRIVATE_START_DATE : "", PRIVATE_END_DATE : "", PRIVATE_DEPARTMENT : "", PRIVATE_ROLE : "", PRIVATE_SKILL : "" }
		];
		
		if(data.length <= 0){
			$scope.workHistoryObjPrivate	=  dataDefaultPrivate; 
		}else{
			$scope.workHistoryObjPrivate	=  data;
		}
		var dateStartValue = [];
		var dateEndValue = [];
		setTimeout(function(){
			angular.forEach($scope.workHistoryObjPrivate, function(value, key){
				dateStartValue[key] = value.PRIVATE_START_DATE == '0000-00-00' ? '' : value.PRIVATE_START_DATE;
				getJqxCalendar('DIV_PRIVATE_START_DATE_' + key,'PRIVATE_START_DATE_' + key,'100px','32px','ចូល',dateStartValue[key]);
				$("#PRIVATE_START_DATE_" + key).val(dateStartValue[key]);
				 
				dateEndValue[key] = value.PRIVATE_END_DATE == '0000-00-00' ? '' : value.PRIVATE_END_DATE;
				getJqxCalendar('DIV_PRIVATE_END_DATE_' + key,'PRIVATE_END_DATE_' + key,'100px','32px','បញ្ចប់',dateEndValue[key]);
				$("#PRIVATE_END_DATE_" + key).val(dateEndValue[key]);
				
				/* validate between start date and end date workHistoryObjPrivate loop */
				var DIV_PRIVATE_START_DATE = $('#PRIVATE_START_DATE_' + key).val();
				var START_WORKING_DATE =  DIV_PRIVATE_START_DATE.split("-");
				$('#DIV_PRIVATE_END_DATE_' + key).jqxDateTimeInput('min',new Date(parseInt(START_WORKING_DATE[0]), START_WORKING_DATE[1], 1));
				/* validate between start date and end date workHistoryObjPrivate loop End */
				
				/* validate between start date and end date FrameworkFree */
			
				$('#DIV_PRIVATE_START_DATE_' + key).on('change',function(){
					var DIV_PRIVATE_START_DATE = $('#PRIVATE_START_DATE_' + key).val();
					if(DIV_PRIVATE_START_DATE != null){
						if(DIV_PRIVATE_START_DATE == ""){
							$('#DIV_PRIVATE_END_DATE_' + key).jqxDateTimeInput({ disabled: true });
							var PRIVATE_START_DATE =  DIV_PRIVATE_START_DATE.split("-");
							$('#DIV_PRIVATE_END_DATE_' + key).jqxDateTimeInput('min',new Date(parseInt(PRIVATE_START_DATE[0]), PRIVATE_START_DATE[1], 1));
							$('#DIV_PRIVATE_END_DATE_' + key).jqxDateTimeInput('setDate', new Date(parseInt(PRIVATE_START_DATE[0]), PRIVATE_START_DATE[1], 1));
						} else {
							$('#DIV_PRIVATE_END_DATE_' + key).jqxDateTimeInput({ disabled: false });
							var PRIVATE_START_DATE =  DIV_PRIVATE_START_DATE.split("-");
							$('#DIV_PRIVATE_END_DATE_' + key).jqxDateTimeInput('min',new Date(parseInt(PRIVATE_START_DATE[0]), PRIVATE_START_DATE[1], 1));
							// $('#DIV_PRIVATE_END_DATE_' + key).jqxDateTimeInput('setDate', new Date(parseInt(PRIVATE_START_DATE[0]), PRIVATE_START_DATE[1], 1));
						}
					}
				});
				
			});
		}, 2000);
		
		setTimeout(function(){
			endLoadingWaiting();
		},2000);
	 });
	 
		$(document).on('change', '.PRIVATE_START_DATE', function() {
			console.log("change");
		});

	 $scope.toObject = function(arr) {
	  var rv = {};
	  if(arr != null){
		for (var i = 0; i < arr.length; ++i)
		rv[i] = arr[i];
	  }
	  return rv;
    };
	
	$scope.addMoreworkHistory	=	function(){
		$scope.workHistoryObj.push({ START_WORKING_DATE : "", END_WORKING_DATE : "", DEPARTMENT : "", INSTITUTION : "", POSITION_EQUAL_TO : "", POSITION : "" });
		var lastIndex	=	($scope.workHistoryObj).length - 1;
		setTimeout(function(){
			
			$http({
				method: 'post',
				url: baseUrl+'background-staff-gov-info/get-auto-completed',
				dataType: "json",
				data:{"_token":_token,"formId":"03"}
			}).success(function(response) {
				var result_1 = {};
				var result_2 = {};
				var result_3 = {};
				var result_4 = {};
				
				var department = response.DEPARTMENT;
				var institution = response.INSTITUTION;
				var position = response.POSITION;
				var position_equal = response.POSITION_EQUAL_TO;

				for (var i = 0; i < department.length; i++) {
					result_1[i] = department[i]['DEPARTMENT'];
				}
				$("#DEPARTMENT_" + lastIndex).jqxInput({ placeHolder: "ក្រសួង-ស្ថាប័ន", height: 36, width: 186, minLength: 1, source: result_1 });
				
				for(var j = 0; j < institution.length; j++){
					result_2[j] = institution[j]['INSTITUTION'];
				}
				$("#INSTITUTION_" + lastIndex).jqxInput({ placeHolder: "អង្គភាព", height: 36, width: 186, minLength: 1, source: result_2 });

				for(var k = 0; k < position.length; k++){
					result_3[k] = position[k]['POSITION'];
				}
				$("#POSITION_" + lastIndex).jqxInput({ placeHolder: "មុខតំណែង", height: 36, width: 186, minLength: 1, source: result_3 });

				for(var l = 0; l < position_equal.length; l++){
					result_4[l] = position_equal[l]['POSITION_EQUAL_TO'];
				}
				$("#POSITION_EQUAL_TO_" + lastIndex).jqxInput({ placeHolder: "ឋានៈស្មើ", height: 36, width: 186, minLength: 1, source: result_4 });
			});
			//
			dateStartValueLast	=	$scope.workHistoryObj[lastIndex].START_WORKING_DATE;
			getJqxCalendar('DIV_START_WORKING_DATE_' + lastIndex,'START_WORKING_DATE_' + lastIndex,'95px','32px','ចូល',dateStartValueLast);
			$("#START_WORKING_DATE_" + lastIndex).val(dateStartValueLast);
			// 
			dateEndValueLast = $scope.workHistoryObj[lastIndex].END_WORKING_DATE;
			getJqxCalendar('DIV_END_WORKING_DATE_' + lastIndex,'END_WORKING_DATE_' + lastIndex,'95px','32px','បញ្ចប់',dateEndValueLast);
			$("#END_WORKING_DATE_" + lastIndex).val(dateEndValueLast);
			// 
			/*
			departermentLast = $scope.workHistoryObj[lastIndex].DEPARTMENT;
			initDropDownList(jqxTheme,180,35, '#DIV_DEPARTMENT_' + lastIndex,angular.fromJson($("#listDepartmentJson").text()), 'text', 'value', false, '', '0', "#DEPARTMENT_" + lastIndex,"ស្វែងរក",200,departermentLast);
			$("#DEPARTMENT_" + lastIndex).val(departermentLast);
			*/
			//
			/*
			positionLast = $scope.workHistoryObj[lastIndex].POSITION;
			initDropDownList(jqxTheme,150,35, '#DIV_POSITION_' + lastIndex,angular.fromJson($("#listPositionJson").text()), 'text', 'value', false, '', '0', "#POSITION_" + lastIndex,"ស្វែងរក",300,positionLast);
			$("#POSITION_" + lastIndex).val(positionLast);
			*/
			//
			$('input#CURRENT_CHECK_' + lastIndex).attr('checked',true);
			$("#DIV_END_WORKING_DATE_" + lastIndex).jqxDateTimeInput({ disabled: true,placeHolder: "ចូល", value:null });
			/* validate between start date and end date WorkHistory */
			$('#DIV_START_WORKING_DATE_' + lastIndex).on('change',function(){
				var DIV_START_WORKING_DATE = $('#START_WORKING_DATE_' + lastIndex).val();
				if(DIV_START_WORKING_DATE != null){
					if(DIV_START_WORKING_DATE == ""){
						$('#DIV_END_WORKING_DATE_' + lastIndex).jqxDateTimeInput({ disabled: true });
						var START_WORKING_DATE =  DIV_START_WORKING_DATE.split("-");
						$('#DIV_END_WORKING_DATE_' + lastIndex).jqxDateTimeInput('min',new Date(parseInt(START_WORKING_DATE[0]), START_WORKING_DATE[1], 1));
						$('#DIV_END_WORKING_DATE_' + lastIndex).jqxDateTimeInput('setDate', new Date(parseInt(START_WORKING_DATE[0]), START_WORKING_DATE[1], 1));
					} else {
						$('#DIV_END_WORKING_DATE_' + lastIndex).jqxDateTimeInput({ disabled: false });
						var START_WORKING_DATE =  DIV_START_WORKING_DATE.split("-");
						$('#DIV_END_WORKING_DATE_' + lastIndex).jqxDateTimeInput('min',new Date(parseInt(START_WORKING_DATE[0]), START_WORKING_DATE[1], 1));
						// $('#DIV_END_WORKING_DATE_' + lastIndex).jqxDateTimeInput('setDate', new Date(parseInt(START_WORKING_DATE[0]), START_WORKING_DATE[1], 1));
					}
				}
			});
			
			/* validate between start date and end date WorkHistory loop */
			var DIV_START_WORKING_DATE = $('#START_WORKING_DATE_' + lastIndex).val();
			var START_WORKING_DATE =  DIV_START_WORKING_DATE.split("-");
			$('#DIV_END_WORKING_DATE_' + lastIndex).jqxDateTimeInput('min',new Date(parseInt(START_WORKING_DATE[0]), START_WORKING_DATE[1], 1));
			if(DIV_START_WORKING_DATE == ''){
				$('#DIV_END_WORKING_DATE_' + lastIndex).jqxDateTimeInput({ disabled: true });
			}
			/* validate between start date and end date WorkHistory loop End */
		}, 200);
	}
	
	$scope.removeworkHistory	=	function(keyIndex){		
		if(angular.isUndefined(keyIndex) == true){
			$scope.workHistoryObj.splice($scope.keyIndexworkHistoryObjCache,1);
			$('#ModalConfirmWorkHistory').modal('hide');
		}else{
			var END_WORKING_DATE = $("#END_WORKING_DATE_" + keyIndex).val();
			END_WORKING_DATE	=	END_WORKING_DATE == 'undefined-undefined-' ? '' : END_WORKING_DATE; 
			if(
				$("#START_WORKING_DATE_" + keyIndex).val() != "" || 
				END_WORKING_DATE != "" ||
				$scope.workHistoryObj[keyIndex].DEPARTMENT != "" || 
				$scope.workHistoryObj[keyIndex].INSTITUTION != "" || 
				$scope.workHistoryObj[keyIndex].POSITION != "" ||
				$scope.workHistoryObj[keyIndex].POSITION_EQUAL_TO != "" 
			){
				$(".btn-confrim-ok").addClass("display-none");
				$("#btnRemoveWorkHistory").removeClass("display-none");
				$('#ModalConfirmWorkHistory').modal('show');
				$scope.keyIndexworkHistoryObjCache	=	keyIndex;
			}else{
				$scope.workHistoryObj.splice(keyIndex,1); 
			}
		}
	}
	
	$scope.addMoreworkHistoryPrivate	=	function(){
		$scope.workHistoryObjPrivate.push({ PRIVATE_START_DATE : "", PRIVATE_END_DATE : "", PRIVATE_DEPARTMENT : "", PRIVATE_ROLE : "", PRIVATE_SKILL : "" });
		var lastIndex	=	($scope.workHistoryObjPrivate).length - 1;
		setTimeout(function(){
			
			$http({
				method: 'post',
				url: baseUrl+'background-staff-gov-info/get-auto-completed',
				dataType: "json",
				data:{"_token":_token,"formId":"03"}
			}).success(function(response) {
				var result_5 = {};
				var result_6 = {};
				var result_7 = {};

				var private_department = response.PRIVATE_DEPARTMENT;
				var private_role = response.PRIVATE_ROLE;
				var private_skill = response.PRIVATE_SKILL;
				
				for(var m = 0; m < private_department.length; m++){
					result_5[m] = private_department[m]['PRIVATE_DEPARTMENT'];
				}
				$("#PRIVATE_DEPARTMENT_" + lastIndex).jqxInput({ placeHolder: "គ្រឹះស្ថាន/អង្គភាព", height: 36, width: 186, minLength: 1, source: result_5 });
				
				for(var n = 0; n < private_role.length; n++){
					result_6[n] = private_role[n]['PRIVATE_ROLE'];
				}
				$("#PRIVATE_ROLE_" + lastIndex).jqxInput({ placeHolder: "តួនាទី", height: 36, width: 186, minLength: 1, source: result_6 });

				for(var p = 0; p < private_skill.length; p++){
					result_7[p] = private_skill[p]['PRIVATE_SKILL'];
				}
				$("#PRIVATE_SKILL_" + lastIndex).jqxInput({ placeHolder: "ជំនាញ/បច្ចេកទេស", height: 36, width: 186, minLength: 1, source: result_7 });
				endLoadingWaiting();
			});
			
			dateStartValueLast = $scope.workHistoryObjPrivate[lastIndex].PRIVATE_START_DATE;
			getJqxCalendar('DIV_PRIVATE_START_DATE_' + lastIndex,'PRIVATE_START_DATE_' + lastIndex,'100px','32px','ចូល',dateStartValueLast);
			$("#PRIVATE_START_DATE_" + lastIndex).val(dateStartValueLast);
			 
			dateEndValueLast = $scope.workHistoryObjPrivate[lastIndex].PRIVATE_END_DATE;
			getJqxCalendar('DIV_PRIVATE_END_DATE_' + lastIndex,'PRIVATE_END_DATE_' + lastIndex,'100px','32px','បញ្ចប់',dateEndValueLast);
			$("#PRIVATE_END_DATE_" + lastIndex).val(dateEndValueLast);
			
			/* validate between start date and end date workHistoryObjPrivate loop */
			var DIV_PRIVATE_START_DATE = $('#PRIVATE_START_DATE_' + lastIndex).val();
			var START_WORKING_DATE =  DIV_PRIVATE_START_DATE.split("-");
			$('#DIV_PRIVATE_END_DATE_' + lastIndex).jqxDateTimeInput('min',new Date(parseInt(START_WORKING_DATE[0]), START_WORKING_DATE[1], 1));
			/* validate between start date and end date workHistoryObjPrivate loop End */
				
			/* validate between start date and end date FrameworkFree */
		
			$('#DIV_PRIVATE_START_DATE_' + lastIndex).on('change',function(){
				var DIV_PRIVATE_START_DATE = $('#PRIVATE_START_DATE_' + lastIndex).val();
				if(DIV_PRIVATE_START_DATE != null){
					if(DIV_PRIVATE_START_DATE == ""){
						$('#DIV_PRIVATE_END_DATE_' + lastIndex).jqxDateTimeInput({ disabled: true });
						var PRIVATE_START_DATE =  DIV_PRIVATE_START_DATE.split("-");
						$('#DIV_PRIVATE_END_DATE_' + lastIndex).jqxDateTimeInput('min',new Date(parseInt(PRIVATE_START_DATE[0]), PRIVATE_START_DATE[1], 1));
						$('#DIV_PRIVATE_END_DATE_' + lastIndex).jqxDateTimeInput('setDate', new Date(parseInt(PRIVATE_START_DATE[0]), PRIVATE_START_DATE[1], 1));
					} else {
						$('#DIV_PRIVATE_END_DATE_' + lastIndex).jqxDateTimeInput({ disabled: false });
						var PRIVATE_START_DATE =  DIV_PRIVATE_START_DATE.split("-");
						$('#DIV_PRIVATE_END_DATE_' + lastIndex).jqxDateTimeInput('min',new Date(parseInt(PRIVATE_START_DATE[0]), PRIVATE_START_DATE[1], 1));
						// $('#DIV_PRIVATE_END_DATE_' + lastIndex).jqxDateTimeInput('setDate', new Date(parseInt(PRIVATE_START_DATE[0]), PRIVATE_START_DATE[1], 1));
					}
				}
			});
			
		}, 200);
	}
	
	$scope.removeworkHistoryPrivate	=	function(keyIndex){
		if(angular.isUndefined(keyIndex) == true){
			$scope.workHistoryObjPrivate.splice($scope.workHistoryObjPrivateCache,1);
			$('#ModalConfirmWorkHistory').modal('hide');
		}else{
			if(
				$("#PRIVATE_START_DATE_" + keyIndex).val() != "" || 
				$("#PRIVATE_END_DATE_" + keyIndex).val() != "" ||
				$scope.workHistoryObjPrivate[keyIndex].PRIVATE_DEPARTMENT != "" ||
				$scope.workHistoryObjPrivate[keyIndex].PRIVATE_ROLE != "" ||
				$scope.workHistoryObjPrivate[keyIndex].PRIVATE_SKILL != ""
			){
				$(".btn-confrim-ok").addClass("display-none");
				$("#btnRemoveWorkHistoryPrivate").removeClass("display-none");
				$('#ModalConfirmWorkHistory').modal('show');
				$scope.workHistoryObjPrivateCache	=	keyIndex;
			}else{
				$scope.workHistoryObjPrivate.splice(keyIndex,1); 
			}
		}		
	}
	
	$scope.currentCheck = function(indexKey){
		if ($('input#CURRENT_CHECK_' + indexKey).is(':checked')) {
			$("#DIV_END_WORKING_DATE_" + indexKey).jqxDateTimeInput({ disabled: true,placeHolder: "ចូល", value:null });
		}else{
			$("#DIV_END_WORKING_DATE_" + indexKey).jqxDateTimeInput({ disabled: false,placeHolder: "ចូល", value:null });
		}
	};
});