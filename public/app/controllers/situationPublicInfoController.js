app.controller("situationPublicInfoController", function ($scope,$rootScope,$http,$location,$route) {
	$scope.$on("$locationChangeStart", function() {
		if(defaultRouteAngularJs != '/smart-office'){
			$scope.saveSituationPublicInfo();
		}
	});

	var getFirstUnitUrl	=	baseUrl + 'background-staff-gov-info/first-unit-list';
	var getFirstDepartmentUrl	=	baseUrl + 'background-staff-gov-info/first-department-list';
	var getFirstOfficeListUrl	=	baseUrl + 'background-staff-gov-info/first-office-list';

	/* ADD MORE ROW */
	$scope.objRow = [{id:'',INSTITUTION : "", START_DATE : "",END_DATE : ""}];
	$scope.add_row = function() {
		var newItemNo = ($scope.objRow.length + 1);
		$scope.objRow.push(newItemNo);
	};

	/* REMOVE ROW */
	$scope.remove_row = function() {
		var lastItem = ($scope.objRow.length - 1);console.log(lastItem);
		if(lastItem == 1){
			$('.minus-block').remove('');
		}
		$scope.objRow.splice(lastItem);
	};

	/*
	$scope.IsADDITINAL	=	true;

	$scope.IsADDITINALAction	=	function(status){
		if(status == true){
			$scope.IsADDITINAL	=	true;
			$('#HaveADDITINAL').prop('checked', true);
			$('#NoADDITINAL').prop('checked', false);
			$("#HaveADDITINAL").attr("disabled", true);
			$("#NoADDITINAL").attr("checked", false);
			$("#NoADDITINAL").removeAttr("disabled", true);
			$("#DIV_ADDITIONAL_WORKING_DATE_FOR_GOV").jqxDateTimeInput({ disabled: false,placeHolder: "កាលបរិច្ឆេទចូល" });
			$("#DIV_ADDITIONAL_POSITION").jqxDropDownList({ disabled: false,placeHolder: "" });
			$("#ADDITINAL_STATUS").attr("disabled",false);
			$("#ADDITINAL_UNIT").attr("disabled",false);
		}else{
			$scope.IsADDITINAL	=	false;
			$('#HaveADDITINAL').prop('checked', false);
			$('#NoADDITINAL').prop('checked', true);
			$("#NoADDITINAL").attr("disabled", true);
			$("#HaveADDITINAL").attr("checked", false);
			$("#HaveADDITINAL").removeAttr("disabled", true);
			$("#DIV_ADDITIONAL_WORKING_DATE_FOR_GOV").jqxDateTimeInput({ disabled: true,placeHolder: "កាលបរិច្ឆេទចូល",value: null });
			$("#DIV_ADDITIONAL_POSITION").jqxDropDownList({ disabled: true,placeHolder: "",selectedIndex: 0 });
			$("#ADDITIONAL_POSITION").val("");
			$("#ADDITINAL_STATUS").attr("disabled",true);
			$scope.publicInfo.ADDITINAL_STATUS = "";
			$("#ADDITINAL_UNIT").attr("disabled",true);
			$scope.publicInfo.ADDITINAL_UNIT = "";
		}
	}
	*/

	$scope.saveSituationPublicInfo = function(nextUrl){
		$scope.publicInfo.FIRST_START_WORKING_DATE_FOR_GOV = $('#FIRST_START_WORKING_DATE_FOR_GOV_VALUE').val();
		$scope.publicInfo.FIRST_GET_OFFICER_DATE = $('#FIRST_GET_OFFICER_DATE_VALUE').val();
		$scope.publicInfo.CURRETN_PROMOTE_OFFICER_DATE = $('#CURRETN_PROMOTE_OFFICER_DATE_VALUE').val();
		$scope.publicInfo.CURRENT_GET_OFFICER_DATE = $('#CURRENT_GET_OFFICER_DATE_VALUE').val();
		$scope.publicInfo.ADDITIONAL_WORKING_DATE_FOR_GOV = $('#ADDITIONAL_WORKING_DATE_FOR_GOV_VALUE').val();
		$scope.publicInfo.FIRST_POSITION = $('#FIRST_POSITION').val();
		$scope.publicInfo.FIRST_MINISTRY = $('#FIRST_MINISTRY').val();
		$scope.publicInfo.CURRENT_POSITION = $('#CURRENT_POSITION').val();
		$scope.publicInfo.ADDITIONAL_POSITION = $('#ADDITIONAL_POSITION').val();
		$scope.publicInfo.FIRST_UNIT = $('#FIRST_UNIT').val();
		$scope.publicInfo.FIRST_DEPARTMENT = $('#FIRST_DEPARTMENT').val();
		$scope.publicInfo.FIRST_OFFICE = $('#FIRST_OFFICE').val();
		$scope.publicInfo.CURRENT_POSITION = $('#CURRENT_POSITION').val();
		$scope.publicInfo.CURRENT_OFFICER_CLASS = $('#CURRENT_OFFICER_CLASS').val();
		$scope.publicInfo.FIRST_OFFICER_CLASS = $('#FIRST_OFFICER_CLASS').val();
		$scope.publicInfo.CURRENT_DEPARTMENT = $('#CURRENT_DEPARTMENT').val();
		$scope.publicInfo.CURRENT_OFFICE = $('#CURRENT_OFFICE').val();
		$scope.publicInfo.CURRENT_GENERAL_DEPARTMENT	=	$('#CURRENT_GENERAL_DEPARTMENT').val();
		$scope.publicInfo.CURRENT_MINISTRY	=	$('#CURRENT_MINISTRY').val();

		/* ស្ថានភាពស្ថិតនៅក្រៅក្របខ័ណ្ឌដើម  */
		angular.forEach($scope.framework, function(value, key){
			$scope.framework[key]['START_DATE'] = $("#START_DATE_VALUE_" + key).val();
			$scope.framework[key]['END_DATE'] = $("#END_DATE_VALUE_" + key).val();
		});
		$scope.publicInfo.framework	=	$scope.framework;

		/* ស្ថានភាពស្ថិតនៅភាពទំនេរគ្មានបៀវត្ស  */
		angular.forEach($scope.frameworkFree, function(value, key){
			$scope.frameworkFree[key]['START_DATE'] = $("#START_DATE_VALUE_FREE_" + key).val();
			$scope.frameworkFree[key]['END_DATE'] = $("#END_DATE_VALUE_FREE_" + key).val();
		});
		$scope.publicInfo.frameworkFree	=	$scope.frameworkFree;

		var objectValidation = {
			FIRST_START_WORKING_DATE_FOR_GOV : $scope.publicInfo.FIRST_START_WORKING_DATE_FOR_GOV ? $scope.publicInfo.FIRST_START_WORKING_DATE_FOR_GOV : '',
			// FIRST_GET_OFFICER_DATE : $scope.publicInfo.FIRST_GET_OFFICER_DATE,
			// CURRETN_PROMOTE_OFFICER_DATE : $scope.publicInfo.CURRETN_PROMOTE_OFFICER_DATE,
			CURRENT_GET_OFFICER_DATE : $scope.publicInfo.CURRENT_GET_OFFICER_DATE,
			FIRST_POSITION : $scope.publicInfo.FIRST_POSITION,
			FIRST_MINISTRY : $scope.publicInfo.FIRST_MINISTRY,
			CURRENT_POSITION : $scope.publicInfo.CURRENT_POSITION,
			FIRST_UNIT : $scope.publicInfo.FIRST_UNIT,
			FIRST_DEPARTMENT : $scope.publicInfo.FIRST_DEPARTMENT,
			FIRST_OFFICER_CLASS : $scope.publicInfo.FIRST_OFFICER_CLASS,
			//FIRST_OFFICE : $scope.publicInfo.FIRST_OFFICE,
			CURRENT_POSITION : $scope.publicInfo.CURRENT_POSITION,
			CURRENT_OFFICER_CLASS : $scope.publicInfo.CURRENT_OFFICER_CLASS,
			CURRENT_MINISTRY : $scope.publicInfo.CURRENT_MINISTRY,
			CURRENT_GENERAL_DEPARTMENT : $scope.publicInfo.CURRENT_GENERAL_DEPARTMENT,
            // CURRENT_DEPARTMENT : $scope.publicInfo.CURRENT_DEPARTMENT,
			//CURRENT_OFFICE : $scope.publicInfo.CURRENT_OFFICE,
			//INSTITUTION_0 : $scope.publicInfo.framework[0]["INSTITUTION"],
			//START_DATE_0 : $scope.publicInfo.framework[0]["START_DATE"],
			//END_DATE_0 : $scope.publicInfo.framework[0]["END_DATE"],

			/* ស្ថានភាពស្ថិតនៅក្រៅក្របខ័ណ្ឌដើម  Validation  */
		};

		/*
		if($scope.IsADDITINAL == true){
			objectValidation.ADDITIONAL_WORKING_DATE_FOR_GOV = $scope.publicInfo.ADDITIONAL_WORKING_DATE_FOR_GOV ? $scope.publicInfo.ADDITIONAL_WORKING_DATE_FOR_GOV : '';
			objectValidation.ADDITIONAL_POSITION = $scope.publicInfo.ADDITIONAL_POSITION ? $scope.publicInfo.ADDITIONAL_POSITION : '' ;
			objectValidation.ADDITINAL_STATUS =  $scope.publicInfo.ADDITINAL_STATUS ? $scope.publicInfo.ADDITINAL_STATUS : '' ;
			objectValidation.ADDITINAL_UNIT = $scope.publicInfo.ADDITINAL_UNIT ? $scope.publicInfo.ADDITINAL_UNIT : '' ;
		}
		*/
		/* Call function validation */
		var IS_REGISTER = 1;
		if($scope.validationObject(objectValidation) == false){
			var IS_REGISTER = 0;
		}
		/* End Call function validation */
		var object = {
			data : $scope.publicInfo
		};
		var editId = $('#indexEdit').val();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/save-situation-public-info',
            dataType: "json",
            data:{"data":object['data'],'editId':editId,"_token":_token, "IS_REGISTER":IS_REGISTER}
        }).success(function(response) {
			$("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
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
				if(IS_REGISTER == 1){
					addClassActiveMenu('menu-2');
				}else{
					removeClassActiveMenu('menu-2');
				}
			}
        });
	}
	$scope.getSituationPublicInfoByUserId = function(callback){
		loadingWaiting();
		var editId = $('#indexEdit').val();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/get-situation-public-info-by-user-id',
            dataType: "json",
            data:{'editId':editId,"_token":_token}
        }).success(function(response) {
			callback(response);
        });
    }


	$scope.getSituationPublicInfoByUserId(function(response){
		var data = response.main;
		console.log(response);
		$scope.framework = response.framework;
		$scope.frameworkFree = response.frameworkFree;
		var FIRST_START_WORKING_DATE_FOR_GOV = data.FIRST_START_WORKING_DATE_FOR_GOV != '0000-00-00' ? $('#FIRST_START_WORKING_DATE_FOR_GOV_VALUE').val(data.FIRST_START_WORKING_DATE_FOR_GOV):'';
		var FIRST_GET_OFFICER_DATE = data.FIRST_GET_OFFICER_DATE != '0000-00-00' ? $('#FIRST_GET_OFFICER_DATE_VALUE').val(data.FIRST_GET_OFFICER_DATE):'';
		var CURRETN_PROMOTE_OFFICER_DATE = data.CURRETN_PROMOTE_OFFICER_DATE != '0000-00-00' ? $('#CURRETN_PROMOTE_OFFICER_DATE_VALUE').val(data.CURRETN_PROMOTE_OFFICER_DATE):'';
		var CURRENT_GET_OFFICER_DATE = data.CURRENT_GET_OFFICER_DATE != '0000-00-00' ? $('#CURRENT_GET_OFFICER_DATE_VALUE').val(data.CURRENT_GET_OFFICER_DATE):'';
		var ADDITIONAL_WORKING_DATE_FOR_GOV = data.ADDITIONAL_WORKING_DATE_FOR_GOV != '0000-00-00' ? $('#ADDITIONAL_WORKING_DATE_FOR_GOV_VALUE').val(data.ADDITIONAL_WORKING_DATE_FOR_GOV):'';
		var FIRST_POSITION = $('#FIRST_POSITION').val(data.FIRST_POSITION);
		var CURRENT_POSITION = $('#CURRENT_POSITION').val(data.CURRENT_POSITION);
		var ADDITIONAL_POSITION = $('#ADDITIONAL_POSITION').val(data.ADDITIONAL_POSITION);
		var FIRST_MINISTRY = $('#FIRST_MINISTRY').val(data.FIRST_MINISTRY);
		/* Condition តួនាទីបន្ថែមលើមុខងារបច្ចុប្បន្ន (ឋានៈស្មើ) */
		/*
		setTimeout(function(){
			if($scope.checkIsUrlSubmitObj.situationPublicInfo == 1){
				if(data.ADDITINAL_STATUS == ""){
					$scope.IsADDITINAL	=	false;
					$scope.IsADDITINALAction(false);
				}else{
					$scope.IsADDITINAL	=	true;
					$scope.IsADDITINALAction(true);
				}
			}else{
				$scope.IsADDITINAL	=	false;
				$scope.IsADDITINALAction(false);
			}
		},2000);
		*/
		/* End Condition តួនាទីបន្ថែមលើមុខងារបច្ចុប្បន្ន (ឋានៈស្មើ) */
		var firstUnitList = response.firstUnitList;
		var firstDepartmentList = response.firstDepartmentList;
		var firstOfficeList = response.firstOfficeList;
		var currentDepartmentList = response.currentDepartmentList;
		var currentOfficeList = response.currentOfficeList;
		setTimeout(function(){
			initDropDownList(jqxTheme,300,36, '#DIV_FIRST_MINISTRY',angular.fromJson($("#listDepartmentsJson").text()), 'text', 'value', false, '', '0', "#FIRST_MINISTRY","ស្វែងរក",350);
			$("#DIV_FIRST_MINISTRY").bind('select',function(event){
				if($(this).val() != 0){
					$.ajax({
						type: "post",
						dataType: "json",
						url: getFirstUnitUrl,
						cache: false,
						data: {"Id":$(this).val(),"_token":_token,'ajaxRequestJson':'true'},
						success: function (response) {
							initDropDownList(jqxTheme,300,36, '#DIV_FIRST_UNIT',response, 'text', 'value', false, '', '0', "#FIRST_UNIT","ជ្រើសរើស",350);
							initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_GENERAL_DEPARTMENT',response, 'text', 'value', false, '', '0', "#CURRENT_GENERAL_DEPARTMENT","ស្វែងរក",350);
						},
						error: function (request, textStatus, errorThrown) {
							console.log(errorThrown);
						}
					});
				}else{
					initDropDownList(jqxTheme,300,36, '#DIV_FIRST_UNIT',[{"text":"","value":""}], 'text', 'value', false, '', '0', "#FIRST_UNIT","ស្វែងរក",350);
					initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_GENERAL_DEPARTMENT',[{"text":"","value":""}], 'text', 'value', false, '', '0', "#CURRENT_GENERAL_DEPARTMENT","ស្វែងរក",350);
				}
			});
			initDropDownList(jqxTheme,300,36, '#DIV_FIRST_UNIT',firstUnitList, 'text', 'value', false, '', '0', "#FIRST_UNIT","ស្វែងរក",350,data.FIRST_UNIT);
			$("#DIV_FIRST_UNIT").bind('select',function(event){
				if($(this).val() != 0){
					$.ajax({
						type: "post",
						dataType: "json",
						url: getFirstDepartmentUrl,
						cache: false,
						data: {"Id":$(this).val(),"_token":_token,'ajaxRequestJson':'true'},
						success: function (response) {
							initDropDownList(jqxTheme,300,36, '#DIV_FIRST_DEPARTMENT',response, 'text', 'value', false, '', '0', "#FIRST_DEPARTMENT","ស្វែងរក",350,data.FIRST_DEPARTMENT);
						},
						error: function (request, textStatus, errorThrown) {
							console.log(errorThrown);
						}
					});
				}else{
					initDropDownList(jqxTheme,300,36, '#DIV_FIRST_DEPARTMENT',[{"text":"","value":""}], 'text', 'value', false, '', '0', "#FIRST_DEPARTMENT","ស្វែងរក",350);
				}
			});
			initDropDownList(jqxTheme,300,36, '#DIV_FIRST_DEPARTMENT',firstDepartmentList, 'text', 'value', false, '', '0', "#FIRST_DEPARTMENT","ស្វែងរក",350,data.FIRST_DEPARTMENT);
			$("#DIV_FIRST_DEPARTMENT").bind('select',function(event){
				if($(this).val() != 0){
					$.ajax({
						type: "post",
						dataType: "json",
						url: getFirstOfficeListUrl,
						cache: false,
						data: {"Id":$(this).val(),"_token":_token,'ajaxRequestJson':'true'},
						success: function (response) {
							initDropDownList(jqxTheme,300,36, '#DIV_FIRST_OFFICE',response, 'text', 'value', false, '', '0', "#FIRST_OFFICE","ស្វែងរក",350,data.FIRST_OFFICE);
						},
						error: function (request, textStatus, errorThrown) {
							console.log(errorThrown);
						}
					});
				}else{
					initDropDownList(jqxTheme,300,36, '#DIV_FIRST_OFFICE',[{"text":"","value":""}], 'text', 'value', false, '', '0', "#FIRST_OFFICE","ស្វែងរក",350);
				}
			});
			initDropDownList(jqxTheme,300,36, '#DIV_FIRST_OFFICE',firstOfficeList, 'text', 'value', false, '', '0', "#FIRST_OFFICE","ស្វែងរក",350,data.FIRST_OFFICE);
			initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_GENERAL_DEPARTMENT',firstUnitList, 'text', 'value', false, '', '0', "#CURRENT_GENERAL_DEPARTMENT","ស្វែងរក",350,data.CURRENT_GENERAL_DEPARTMENT);
			$("#DIV_CURRENT_GENERAL_DEPARTMENT").bind('select',function(event){
				if($(this).val() != 0){
					$.ajax({
						type: "post",
						dataType: "json",
						url: getFirstDepartmentUrl,
						cache: false,
						data: {"Id":$(this).val(),"_token":_token,'ajaxRequestJson':'true'},
						success: function (response) {
							initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_DEPARTMENT',response, 'text', 'value', false, '', '0', "#CURRENT_DEPARTMENT","ស្វែងរក",350,data.CURRENT_DEPARTMENT);
						},
						error: function (request, textStatus, errorThrown) {
							console.log(errorThrown);
						}
					});
				}else{
					initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_DEPARTMENT',[{"text":"","value":""}], 'text', 'value', false, '', '0', "#CURRENT_DEPARTMENT","ស្វែងរក",350);
				}
			});

			initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_MINISTRY',angular.fromJson($("#listDepartmentsJson").text()), 'text', 'value', false, '', '0', "#CURRENT_MINISTRY","ស្វែងរក",350,data.CURRENT_MINISTRY);
			$("#DIV_CURRENT_MINISTRY").bind('select',function(event){
				if($(this).val() != 0){
					$.ajax({
						type: "post",
						dataType: "json",
						url: getFirstUnitUrl,
						cache: false,
						data: {"Id":$(this).val(),"_token":_token,'ajaxRequestJson':'true'},
						success: function (response) {
							console.log(response);
							initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_GENERAL_DEPARTMENT',response, 'text', 'value', false, '', '0', "#CURRENT_GENERAL_DEPARTMENT","ស្វែងរក",350);
						},
						error: function (request, textStatus, errorThrown) {
							console.log(errorThrown);
						}
					});
				}else{
					initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_MINISTRY',[{"text":"","value":""}], 'text', 'value', false, '', '0', "#CURRENT_MINISTRY","ស្វែងរក",350);
				}
			});

			initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_DEPARTMENT',currentDepartmentList, 'text', 'value', false, '', '0', "#CURRENT_DEPARTMENT","ស្វែងរក",350,data.CURRENT_DEPARTMENT);
			$("#DIV_CURRENT_DEPARTMENT").bind('select',function(event){
				if($(this).val() != 0){
					$.ajax({
						type: "post",
						dataType: "json",
						url: getFirstOfficeListUrl,
						cache: false,
						data: {"Id":$(this).val(),"_token":_token,'ajaxRequestJson':'true'},
						success: function (response) {
							initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_OFFICE',response, 'text', 'value', false, '', '0', "#CURRENT_OFFICE","ស្វែងរក",350,data.CURRENT_OFFICE);
						},
						error: function (request, textStatus, errorThrown) {
							console.log(errorThrown);
						}
					});
				}else{
					initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_OFFICE',[{"text":"","value":""}], 'text', 'value', false, '', '0', "#CURRENT_OFFICE","ស្វែងរក",350);
				}
			});
			initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_OFFICE',currentOfficeList, 'text', 'value', false, '', '0', "#CURRENT_OFFICE","ស្វែងរក",350,data.CURRENT_OFFICE);
		},1000);

		var FIRST_OFFICER_CLASS = $('#FIRST_OFFICER_CLASS').val(data.FIRST_OFFICER_CLASS);
		var CURRENT_OFFICER_CLASS = $('#CURRENT_OFFICER_CLASS').val(data.CURRENT_OFFICER_CLASS);
		var CURRENT_DEPARTMENT = $('#CURRENT_DEPARTMENT').val(data.CURRENT_DEPARTMENT);

		/*Outside Framework*/
		if(($scope.framework).length <= 0){
			$scope.framework	= [{INSTITUTION:"", START_DATE:"", END_DATE:""}];
		}
		var dateStartValue = [];
		var dateEndValue = [];
		setTimeout(function(){
			angular.forEach($scope.framework, function(value, key){
				dateStartValue[key] = value.START_DATE == '0000-00-00' ? '' : value.START_DATE;
				dateEndValue[key] = value.END_DATE == '0000-00-00' ? '' : value.END_DATE;
				getJqxCalendar('DIV_START_DATE_' + key,'START_DATE_VALUE_' + key,'150px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',dateStartValue[key]);
				getJqxCalendar('DIV_END_DATE_' + key,'END_DATE_VALUE_' + key,'150px','32px','កាលបរិច្ឆេទបញ្ចប់',dateEndValue[key]);
				$("#START_DATE_VALUE_" + key).val(value.START_DATE);
				$("#END_DATE_VALUE_" + key).val(value.END_DATE);
				/* validate between start date and end date Framework */
				$('#DIV_START_DATE_' + key).on('change',function(){
					var DIV_START_DATE = $('#START_DATE_VALUE_' + key).val();
					if(DIV_START_DATE != null){
						if(DIV_START_DATE == ""){
							$('#DIV_END_DATE_' + key).jqxDateTimeInput({ disabled: true });
							var START_DATE_VALUE =  DIV_START_DATE.split("-");
							$('#DIV_END_DATE_' + key).jqxDateTimeInput('min',new Date(parseInt(START_DATE_VALUE[0]), START_DATE_VALUE[1], 1));
							$('#DIV_END_DATE_' + key).jqxDateTimeInput('setDate', new Date(parseInt(START_DATE_VALUE[0]), START_DATE_VALUE[1], 1));
						} else {
							$('#DIV_END_DATE_' + key).jqxDateTimeInput({ disabled: false });
							var START_DATE_VALUE =  DIV_START_DATE.split("-");
							$('#DIV_END_DATE_' + key).jqxDateTimeInput('min',new Date(parseInt(START_DATE_VALUE[0]), START_DATE_VALUE[1], 1));
							// $('#DIV_END_DATE_' + key).jqxDateTimeInput('setDate', new Date(parseInt(START_DATE_VALUE[0]), START_DATE_VALUE[1], 1));
						}
					}
				});

				/* validate between start date and end date Framework loop */
				var DIV_START_DATE = $('#START_DATE_VALUE_' + key).val();
				var START_DATE_VALUE =  DIV_START_DATE.split("-");
				$('#DIV_END_DATE_' + key).jqxDateTimeInput('min',new Date(parseInt(START_DATE_VALUE[0]), START_DATE_VALUE[1], 1));
				/* validate between start date and end date Framework loop End */
			});
		}, 1000);

		/*Outside Framework Free*/
		if(($scope.frameworkFree).length <= 0){
			$scope.frameworkFree	= [{INSTITUTION:"", START_DATE:"", END_DATE:""}];
		}
		var dateStartValueFree = [];
		var dateEndValueFree = [];
		setTimeout(function(){
			angular.forEach($scope.frameworkFree, function(value, key){
				dateStartValueFree[key] = value.START_DATE == '0000-00-00' ? '' : value.START_DATE;
				dateEndValueFree[key] = value.END_DATE == '0000-00-00' ? '' : value.END_DATE;
				getJqxCalendar('DIV_START_DATE_FREE_' + key,'START_DATE_VALUE_FREE_' + key,'150px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',dateStartValueFree[key]);
				getJqxCalendar('DIV_END_DATE_FREE_' + key,'END_DATE_VALUE_FREE_' + key,'150px','32px','កាលបរិច្ឆេទបញ្ចប់',dateEndValueFree[key]);
				$("#START_DATE_VALUE_FREE_" + key).val(value.START_DATE);
				$("#END_DATE_VALUE_FREE_" + key).val(value.END_DATE);
				/* validate between start date and end date FrameworkFree */
				$('#DIV_START_DATE_FREE_' + key).on('change',function(){
					var DIV_START_DATE_FREE = $('#START_DATE_VALUE_FREE_' + key).val();
					if(DIV_START_DATE_FREE != null){
						if(DIV_START_DATE_FREE == ""){
							$('#DIV_END_DATE_FREE_' + key).jqxDateTimeInput({ disabled: true });
							var START_DATE_VALUE_FREE =  DIV_START_DATE_FREE.split("-");
							$('#DIV_END_DATE_FREE_' + key).jqxDateTimeInput('min',new Date(parseInt(START_DATE_VALUE_FREE[0]), START_DATE_VALUE_FREE[1], 1));
							$('#DIV_END_DATE_FREE_' + key).jqxDateTimeInput('setDate', new Date(parseInt(START_DATE_VALUE_FREE[0]), START_DATE_VALUE_FREE[1], 1));
						} else {
							$('#DIV_END_DATE_FREE_' + key).jqxDateTimeInput({ disabled: false });
							var START_DATE_VALUE_FREE =  DIV_START_DATE_FREE.split("-");
							$('#DIV_END_DATE_FREE_' + key).jqxDateTimeInput('min',new Date(parseInt(START_DATE_VALUE_FREE[0]), START_DATE_VALUE_FREE[1], 1));
							// $('#DIV_END_DATE_FREE_' + key).jqxDateTimeInput('setDate', new Date(parseInt(START_DATE_VALUE_FREE[0]), START_DATE_VALUE_FREE[1], 1));
						}
					}
				});

				/* validate between start date and end date FrameworkFree loop */
				var DIV_START_DATE_FREE = $('#START_DATE_VALUE_FREE_' + key).val();
				var START_DATE_VALUE_FREE =  DIV_START_DATE_FREE.split("-");
				$('#DIV_END_DATE_FREE_' + key).jqxDateTimeInput('min',new Date(parseInt(START_DATE_VALUE_FREE[0]), START_DATE_VALUE_FREE[1], 1));
				/* validate between start date and end date FrameworkFree loop End */
			});
		}, 1000);

		$scope.publicInfo = {
			"FIRST_OFFICER_CLASS":data.FIRST_OFFICER_CLASS,
			"FIRST_POSITION":FIRST_POSITION,
			"CURRENT_POSITION":CURRENT_POSITION,
			"ADDITIONAL_POSITION":ADDITIONAL_POSITION,
			"FIRST_MINISTRY":FIRST_MINISTRY,
			"ADDITINAL_STATUS":data.ADDITINAL_STATUS,
			"ADDITINAL_UNIT":data.ADDITINAL_UNIT,
			"CURRENT_MINISTRY":data.CURRENT_MINISTRY,
			"CURRENT_DEPARTMENT":data.CURRENT_DEPARTMENT,
			"CURRENT_GENERAL_DEPARTMENT":data.CURRENT_GENERAL_DEPARTMENT,
			"CURRENT_OFFICE":data.CURRENT_OFFICE,
			"CURRENT_OFFICER_CLASS":data.CURRENT_OFFICER_CLASS,
			"FIRST_DEPARTMENT":data.FIRST_DEPARTMENT,
			"FIRST_OFFICE":data.FIRST_OFFICE,
			"FIRST_OFFICER_CLASS":data.FIRST_OFFICER_CLASS,
			"FIRST_UNIT":data.FIRST_UNIT
		}

		/* Jqwidgets */
		// Help hover
		// Help hover
		$( ".block-21 .help" ).tooltip({ content: '<img src="' + baseUrl + 'images/2_.png"   class="tooltip-img""  />' });
		$( ".block-24 .help" ).tooltip({ content: '<img src="'+ baseUrl +'images/3.png"  class="tooltip-img""  />' });
		/*កាលបរិច្ឆេទប្រកាសចូលបម្រើការងាររដ្ឋដំបូង*/
		setTimeout(function(){
		  var dateValue = $('#FIRST_START_WORKING_DATE_FOR_GOV_VALUE').val() != null ? $('#FIRST_START_WORKING_DATE_FOR_GOV_VALUE').val():null;
		  getJqxCalendar('DIV_FIRST_START_WORKING_DATE_FOR_GOV','FIRST_START_WORKING_DATE_FOR_GOV_VALUE','200px','32px','កាលបរិច្ឆេទប្រកាសចូលបម្រើការងាររដ្ឋដំបូង',$('#FIRST_START_WORKING_DATE_FOR_GOV_VALUE').val());
		}, 1000);
		/*កាលបរិច្ឆេទតាំងស៊ប់*/
		setTimeout(function(){
		  var dateValue = $('#FIRST_GET_OFFICER_DATE_VALUE').val() != null ? $('#FIRST_GET_OFFICER_DATE_VALUE').val():null;
		  getJqxCalendar('DIV_FIRST_GET_OFFICER_DATE','FIRST_GET_OFFICER_DATE_VALUE','200px','32px','កាលបរិច្ឆេទតាំងស៊ប់',dateValue);
		}, 1000);
		/*កាលបរិច្ឆេទឡើងក្របខ័ណ្ឌ ឋានន្តរស័ក្តិ និងថ្នាក់ចុងក្រោយ*/
		setTimeout(function(){
		  var dateValue = $('#CURRETN_PROMOTE_OFFICER_DATE_VALUE').val() != null ? $('#CURRETN_PROMOTE_OFFICER_DATE_VALUE').val():null;
		  getJqxCalendar('DIV_CURRETN_PROMOTE_OFFICER_DATE','CURRETN_PROMOTE_OFFICER_DATE_VALUE','200px','32px','កាលបរិច្ឆេទឡើងក្របខ័ណ្ឌ ...',dateValue);
		}, 1000);
		/*កាលបរិច្ឆេទទទួលមុខតំណែងចុងក្រោយ*/
		setTimeout(function(){
		  var dateValue = $('#CURRENT_GET_OFFICER_DATE_VALUE').val() != null ? $('#CURRENT_GET_OFFICER_DATE_VALUE').val():null;
		  getJqxCalendar('DIV_CURRENT_GET_OFFICER_DATE','CURRENT_GET_OFFICER_DATE_VALUE','200px','32px','កាលបរិច្ឆេទទទួលមុខ...',dateValue);
		}, 1000);
		/*តួនាទីបន្ថែមលើមុខងារបច្ចុប្បន្ន (ឋានៈស្មើ)*/
		setTimeout(function(){
		  var dateValue = $('#ADDITIONAL_WORKING_DATE_FOR_GOV_VALUE').val() != null ? $('#ADDITIONAL_WORKING_DATE_FOR_GOV_VALUE').val():null;
		  getJqxCalendar('DIV_ADDITIONAL_WORKING_DATE_FOR_GOV','ADDITIONAL_WORKING_DATE_FOR_GOV_VALUE','200px','32px','កាលបរិច្ឆេទចូល',dateValue);
		}, 1000);
		/* FIRST_POSITION */
		setTimeout(function(){
		  initDropDownList(jqxTheme,300,36, '#DIV_FIRST_POSITION',angular.fromJson($("#listPositionsJson").text()), 'text', 'value', false, '', '0', "#FIRST_POSITION","ស្វែងរក",350);
		}, 1000);
		/* CURRENT_POSITION */
		setTimeout(function(){
		  initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_POSITION',angular.fromJson($("#listPositionsJson").text()), 'text', 'value', false, '', '0', "#CURRENT_POSITION","ស្វែងរក",350);
		}, 1000);
		/* ADDITIONAL_POSITION */
		setTimeout(function(){
		  initDropDownList(jqxTheme,300,36, '#DIV_ADDITIONAL_POSITION',angular.fromJson($("#listPositionsJson").text()), 'text', 'value', false, '', '0', "#ADDITIONAL_POSITION","ស្វែងរក",350);
		}, 1000);
		/* DIV_FIRST_OFFICE || getFirstOfficeListUrl By Department Id */
		setTimeout(function(){

		}, 1000);
		/* Jqwidgets End */
		/* FIRST_OFFICER_CLASS || listClassRanks */
		setTimeout(function(){
			initDropDownList(jqxTheme,300,36, '#DIV_FIRST_OFFICER_CLASS',angular.fromJson($("#listClassRanksJson").text()), 'text', 'value', false, '', '0', "#FIRST_OFFICER_CLASS","ស្វែងរក",350);
		}, 1000);
		/* CURRENT_OFFICER_CLASS */
		setTimeout(function(){
			initDropDownList(jqxTheme,300,36, '#DIV_CURRENT_OFFICER_CLASS',angular.fromJson($("#listClassRanksJson").text()), 'text', 'value', false, '', '0', "#CURRENT_OFFICER_CLASS","ស្វែងរក",350);
		}, 1000);
		setTimeout(function(){
			/* SUMMERY FUNCTION */
			$scope.sumarryData();
			/* SUMMERY FUNCTION END */
			endLoadingWaiting();
		}, 6000);
	});

	$scope.sumarryData = function(){
		/* SUMMERY DATA */
		$("#SUMMARY_FIRST_OFFICER_CLASS").text(($("#dropdownlistContentDIV_FIRST_OFFICER_CLASS").text()));
		$("#SUMMARY_FIRST_POSITION").text(($("#dropdownlistContentDIV_FIRST_POSITION").text()));
		$("#SUMMARY_FIRST_MINISTRY").text(($("#dropdownlistContentDIV_FIRST_MINISTRY").text()));
		$("#SUMMARY_FIRST_UNIT").text(($("#dropdownlistContentDIV_FIRST_UNIT").text()));
		$("#SUMMARY_FIRST_DEPARTMENT").text(($("#dropdownlistContentDIV_FIRST_DEPARTMENT").text()));
		/* SUMMERY DATA END*/
	}

	$scope.firstMinistryChange = function(){
		// console.log($("#FIRST_MINISTRY")value());
		/*
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/get-situation-public-info-by-user-id',
            dataType: "json",
            data:{"_token":_token}
        }).success(function(response) {
			callback(response);
        });
		*/
    }

	$scope.validationObject = function(data){
		var countError	=	0;
		$.each(data, function( index, value ) {
			if(value == "" || value == 0 || value == 'undefined-undefined-'){
				countError	=	countError + 1;
			}
		});
		if(countError > 0){
			return false;
		}else{
			return true;
		}
    }

	$scope.addMoreframework	=	function(){
		$scope.framework.push({INSTITUTION:"", START_DATE:"", END_DATE:""});
		var lastIndex	=	($scope.framework).length - 1;
		setTimeout(function(){

			$http({
				method: 'post',
				url: baseUrl+'background-staff-gov-info/get-auto-completed',
				dataType: "json",
				data:{"_token":_token,"formId":"02"}
			}).success(function(response) {
				var result_3 = {};
				var institution_framwork = response.INSTITUTION_FRAMWORK;
				for(var k = 0; k < institution_framwork.length; k++) {
					result_3[k] = institution_framwork[k]['INSTITUTION'];
				}
				$("#INSTITUTION_"+ lastIndex).jqxInput({ placeHolder: "ស្ថាប័ន/អង្គភាព", height: 36, width: '100%', minLength: 1, source: result_3 });
			});

			dateStartValueLast = $scope.framework[lastIndex].START_DATE;
			dateEndValueLast = $scope.framework[lastIndex].END_DATE;
			getJqxCalendar('DIV_START_DATE_' + lastIndex,'START_DATE_VALUE_' + lastIndex,'150px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',dateStartValueLast);
			getJqxCalendar('DIV_END_DATE_' + lastIndex,'END_DATE_VALUE_' + lastIndex,'150px','32px','កាលបរិច្ឆេទបញ្ចប់',dateEndValueLast);
			$("#START_DATE_VALUE_" + lastIndex).val(dateStartValueLast);
			$("#END_DATE_VALUE_" + lastIndex).val(dateEndValueLast);
			/* validate between start date and end date Framework */
			$('#DIV_START_DATE_' + lastIndex).on('change',function(){
				var DIV_START_DATE = $('#START_DATE_VALUE_' + lastIndex).val();
				if(DIV_START_DATE != null){
					if(DIV_START_DATE == ""){
						$('#DIV_END_DATE_' + lastIndex).jqxDateTimeInput({ disabled: true });
						var START_DATE_VALUE =  DIV_START_DATE.split("-");
						$('#DIV_END_DATE_' + lastIndex).jqxDateTimeInput('min',new Date(parseInt(START_DATE_VALUE[0]), START_DATE_VALUE[1], 1));
						$('#DIV_END_DATE_' + lastIndex).jqxDateTimeInput('setDate', new Date(parseInt(START_DATE_VALUE[0]), START_DATE_VALUE[1], 1));
					} else {
						$('#DIV_END_DATE_' + lastIndex).jqxDateTimeInput({ disabled: false });
						var START_DATE_VALUE =  DIV_START_DATE.split("-");
						$('#DIV_END_DATE_' + lastIndex).jqxDateTimeInput('min',new Date(parseInt(START_DATE_VALUE[0]), START_DATE_VALUE[1], 1));
						// $('#DIV_END_DATE_' + key).jqxDateTimeInput('setDate', new Date(parseInt(START_DATE_VALUE[0]), START_DATE_VALUE[1], 1));
					}
				}
			});

			/* validate between start date and end date Framework loop */
			var DIV_START_DATE = $('#START_DATE_VALUE_' + lastIndex).val();
			var START_DATE_VALUE =  DIV_START_DATE.split("-");
			$('#DIV_END_DATE_' + lastIndex).jqxDateTimeInput('min',new Date(parseInt(START_DATE_VALUE[0]), START_DATE_VALUE[1], 1));
			if(DIV_START_DATE == ''){
				$('#DIV_END_DATE_' + lastIndex).jqxDateTimeInput({ disabled: true });
			}
			/* validate between start date and end date Framework loop End */
		}, 200);
	}

	$scope.removeMoreframework	=	function(keyIndex){
		if(angular.isUndefined(keyIndex) == true){
			$scope.framework.splice($scope.keyIndexFrameworkCache,1);
			$('#ModalConfirmMoreframework').modal('hide');
		}else{
			if($scope.framework[keyIndex].INSTITUTION != "" || $("#START_DATE_VALUE_" + keyIndex).val() != "" || $("#END_DATE_VALUE_" + keyIndex).val() != ""){
				$(".btn-confrim-ok").addClass("display-none");
				$("#btnRemoveMoreframework").removeClass("display-none");
				$('#ModalConfirmMoreframework').modal('show');
				$scope.keyIndexFrameworkCache	=	keyIndex;
			}else{
				$scope.framework.splice(keyIndex,1);
			}
		}
	}

	$scope.addMoreframeworkFree	=	function(){
		$scope.frameworkFree.push({INSTITUTION:"", START_DATE:"", END_DATE:""});
		var lastIndex	=	($scope.frameworkFree).length - 1;
		setTimeout(function(){

			$http({
				method: 'post',
				url: baseUrl+'background-staff-gov-info/get-auto-completed',
				dataType: "json",
				data:{"_token":_token,"formId":"02"}
			}).success(function(response) {
				var result_4 = {};
				var institution_framwork_free = response.INSTITUTION_FRAMWORK_FREE;
				for(var l = 0; l < institution_framwork_free.length; l++) {
					result_4[l] = institution_framwork_free[l]['INSTITUTION'];
				}
				$("#INSTITUTION_FREE_"+ lastIndex).jqxInput({ placeHolder: "ស្ថាប័ន/អង្គភាព", height: 36, width: '100%', minLength: 1, source: result_4 });
			});

			dateStartValueFreeLast = $scope.frameworkFree[lastIndex].START_DATE;
			dateEndValueFreeLast = $scope.frameworkFree[lastIndex].END_DATE;
			getJqxCalendar('DIV_START_DATE_FREE_' + lastIndex,'START_DATE_VALUE_FREE_' + lastIndex,'150px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',dateStartValueFreeLast);
			getJqxCalendar('DIV_END_DATE_FREE_' + lastIndex,'END_DATE_VALUE_FREE_' + lastIndex,'150px','32px','កាលបរិច្ឆេទបញ្ចប់',dateEndValueFreeLast);
			$("#START_DATE_VALUE_FREE_" + lastIndex).val(dateStartValueFreeLast);
			$("#END_DATE_VALUE_FREE_" + lastIndex).val(dateEndValueFreeLast);
			/* validate between start date and end date FrameworkFree */
			$('#DIV_START_DATE_FREE_' + lastIndex).on('change',function(){
				var DIV_START_DATE_FREE = $('#START_DATE_VALUE_FREE_' + lastIndex).val();
				if(DIV_START_DATE_FREE != null){
					if(DIV_START_DATE_FREE == ""){
						$('#DIV_END_DATE_FREE_' + lastIndex).jqxDateTimeInput({ disabled: true });
						var START_DATE_VALUE_FREE =  DIV_START_DATE_FREE.split("-");
						$('#DIV_END_DATE_FREE_' + lastIndex).jqxDateTimeInput('min',new Date(parseInt(START_DATE_VALUE_FREE[0]), START_DATE_VALUE_FREE[1], 1));
						$('#DIV_END_DATE_FREE_' + lastIndex).jqxDateTimeInput('setDate', new Date(parseInt(START_DATE_VALUE_FREE[0]), START_DATE_VALUE_FREE[1], 1));
					} else {
						$('#DIV_END_DATE_FREE_' + lastIndex).jqxDateTimeInput({ disabled: false });
						var START_DATE_VALUE_FREE =  DIV_START_DATE_FREE.split("-");
						$('#DIV_END_DATE_FREE_' + lastIndex).jqxDateTimeInput('min',new Date(parseInt(START_DATE_VALUE_FREE[0]), START_DATE_VALUE_FREE[1], 1));
						// $('#DIV_END_DATE_FREE_' + lastIndex).jqxDateTimeInput('setDate', new Date(parseInt(START_DATE_VALUE_FREE[0]), START_DATE_VALUE_FREE[1], 1));
					}
				}
			});

			/* validate between start date and end date FrameworkFree loop */
			var DIV_START_DATE_FREE = $('#START_DATE_VALUE_FREE_' + lastIndex).val();
			var START_DATE_VALUE_FREE =  DIV_START_DATE_FREE.split("-");
			$('#DIV_END_DATE_FREE_' + lastIndex).jqxDateTimeInput('min',new Date(parseInt(START_DATE_VALUE_FREE[0]), START_DATE_VALUE_FREE[1], 1));
			if(DIV_START_DATE_FREE == ''){
				$('#DIV_END_DATE_FREE_' + lastIndex).jqxDateTimeInput({ disabled: true });
			}
			/* validate between start date and end date FrameworkFree loop End */
		}, 200);
	}

	$scope.removeMoreframeworkFree	=	function(keyIndex){
		if(angular.isUndefined(keyIndex) == true){
			$scope.frameworkFree.splice($scope.keyIndexFrameworkFreeCache,1);
			$('#ModalConfirmMoreframework').modal('hide');
		}else{
			if($scope.frameworkFree[keyIndex].INSTITUTION != "" || $("#START_DATE_VALUE_FREE_" + keyIndex).val() != "" || $("#END_DATE_VALUE_FREE_" + keyIndex).val() != ""){
				$(".btn-confrim-ok").addClass("display-none");
				$("#btnRemoveMoreframeworkFree").removeClass("display-none");
				$('#ModalConfirmMoreframework').modal('show');
				$scope.keyIndexFrameworkFreeCache	=	keyIndex;
			}else{
				$scope.frameworkFree.splice(keyIndex,1);
			}
		}
	}

});
