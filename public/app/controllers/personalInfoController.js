app.controller("personalInfoController", function ($rootScope,$scope,$interval,$http,$filter,$location) {
	$scope.$on("$locationChangeStart", function() {
		if(defaultRouteAngularJs != '/smart-office'){
			$scope.postPersonalInfo();
		}
	});
	$scope.getPersonalInfoByUserId = function(callback){
		loadingWaiting();
		var editId = $('#indexEdit').val();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/get-personal-info-by-user-id',
            dataType: "json",
            data:{'editId':editId,"_token":_token}
        }).success(function(response) {
			callback(response);
			endLoadingWaiting();
        });
    };
	$scope.IsMARRIEDAction	=	function(status){

		if(status == true){
			$scope.info.MARRIED = 1;
			$('#HaveMARRIED').prop('checked', true);
			$('#NoMARRIED').prop('checked', false);
			$("#HaveMARRIED").attr("disabled", true);
			$("#NoMARRIED").attr("disabled", false);
		}else{
			$scope.info.MARRIED = 0;
			$('#HaveMARRIED').prop('checked', false);
			$('#NoMARRIED').prop('checked', true);
			$("#HaveMARRIED").attr("disabled", false);
			$("#NoMARRIED").attr("disabled", true);
		}
	};
	$scope.address = { house : "", street : "", mef_province_id : "", mef_district_id : "", mef_commune_id : "", mef_village_id : ""  };
	$scope.getPersonalInfoByUserId(function(data){
		var dob = data.DATE_OF_BIRTH != '0000-00-00' ? $('#DATE_OF_BIRTH').val(data.DATE_OF_BIRTH):'';
		var khIDExp = data.NATION_ID_EXPIRED_DATE != '0000-00-00' ? $('#NATION_ID_EXPIRED_DATE').val(data.NATION_ID_EXPIRED_DATE):'';
		var passsport = data.PASSPORT_ID_EXPIRED_DATE != '0000-00-00' ? $('#PASSPORT_ID_EXPIRED_DATE_VALUE').val(data.PASSPORT_ID_EXPIRED_DATE):'';
		$scope.info = {
			"PERSONAL_INFORMATION":data.PERSONAL_INFORMATION,
			"OFFICIAL_ID":data.OFFICIAL_ID,
			"UNIT_CODE":data.UNIT_CODE,
			"TITLE_ID":data.TITLE_ID,
			"FULL_NAME_KH":data.FULL_NAME_KH,
			"FULL_NAME_EN":data.FULL_NAME_EN.toUpperCase(),
			"GENDER":data.GENDER,
			"PASSPORT_ID":data.PASSPORT_ID,
			"NATION_ID":data.NATION_ID,
			"PHONE_NUMBER_1":data.PHONE_NUMBER_1,
			"PHONE_NUMBER_2":data.PHONE_NUMBER_2,
			"EMAIL":data.EMAIL,
			// "CURRENT_ADDRESS":data.CURRENT_ADDRESS,
			"PLACE_OF_BIRTH":data.PLACE_OF_BIRTH,
			"NATIONALITY_1":data.NATIONALITY_1,
			"NATIONALITY_2":data.NATIONALITY_2,
			"MARRIED":data.MARRIED == 1 ? true:false,
			"NATION_ID_EXPIRED_DATE":khIDExp,
			"PASSPORT_ID_EXPIRED_DATE":passsport,
			"DATE_OF_BIRTH":dob,
			"AVATAR":data.AVATAR

		};
		

		$scope.address = data.CURRENT_ADDRESS;
		var district_obj = data.district_obj;
		var commune_obj = data.commune_obj;
		var village_obj = data.village_obj;
		var title_obj = data.title_obj;
		$scope.info.AVATAR == null ? $scope.info.AVATAR = (baseUrl + 'images/photo-default.jpg') : $scope.info.AVATAR = $scope.info.AVATAR;

		/* Jqwidgets */
		// Help hover
		$( ".block-1 .help" ).tooltip({ content: '<img src="images/1.png" " class="tooltip-img" />' });
		/*ថ្ងៃខែឆ្នាំកំណើត*/
		setTimeout(function(){
		  var dob = $('#DATE_OF_BIRTH').val() != null ? $('#DATE_OF_BIRTH').val():null;
		  getJqxCalendar('DIV_DATE_OF_BIRTH','DATE_OF_BIRTH','120px','32px','ថ្ងៃខែឆ្នាំកំណើត',dob);
		}, 2000);

		/*អត្តសញ្ញាណប័ណ្ណ*/
		setTimeout(function(){
			var khIdCard = $('#NATION_ID_EXPIRED_DATE').val() != null ? $('#NATION_ID_EXPIRED_DATE').val():null;
			getJqxCalendar('DIV_NATION_ID_EXPIRED_DATE','NATION_ID_EXPIRED_DATE','200px','32px','កាលបរិច្ឆេទផុតកំណត់',khIdCard);
		}, 2000);

		/*លិខិតឆ្លងដែន*/
		setTimeout(function(){
			var passsportExp = $('#PASSPORT_ID_EXPIRED_DATE_VALUE').val() != null ? $('#PASSPORT_ID_EXPIRED_DATE_VALUE').val():null;
			getJqxCalendar('DIV_PASSPORT_ID_EXPIRED_DATE','PASSPORT_ID_EXPIRED_DATE_VALUE','200px','32px','កាលបរិច្ឆេទផុតកំណត់',passsportExp);
		}, 2000);
		/* Jqwidgets End */
		/* SUMMERY FUNCTION */
		$scope.sumarryData();
		/* SUMMERY FUNCTION END */
		/* Is Marred */
		if($scope.info.MARRIED == 1){
			$scope.IsMARRIEDAction(true);
		}else{
			$scope.IsMARRIEDAction(false);
		}
		/* Is Marred End */
		var getDistrictUrl	=	baseUrl + 'background-staff-gov-info/get-district';
		var getCommuneUrl	=	baseUrl + 'background-staff-gov-info/get-commune';
		var getVillagesUrl	=	baseUrl + 'background-staff-gov-info/get-villages';
		/* div_mef_province_id */
		setTimeout(function(){
		  initDropDownList(jqxTheme,'100%',36, '#div_mef_title_id',title_obj, 'text', 'value', false, '', '0', "#mef_title_id","ស្វែងរក",350,$scope.info.TITLE_ID);
		  initDropDownList(jqxTheme,'100%',36, '#div_mef_province_id',angular.fromJson($("#listProvinceJson").text()), 'text', 'value', false, '', '0', "#mef_province_id","ខេត្ត",350,$scope.address.mef_province_id);
		  initDropDownList(jqxTheme,'100%',36, '#div_mef_district_id',district_obj, 'text', 'value', false, '', '0', "#mef_district_id","ស្វែងរក",350,$scope.address.mef_district_id);
		  initDropDownList(jqxTheme,'100%',36, '#div_mef_commune_id',commune_obj, 'text', 'value', false, '', '0', "#mef_commune_id","ស្វែងរក",350,$scope.address.mef_commune_id);
		  initDropDownList(jqxTheme,'100%',36, '#div_mef_village_id',village_obj, 'text', 'value', false, '', '0', "#mef_village_id","ស្វែងរក",350,$scope.address.mef_village_id);
		  // div_mef_province_id
		  $("#div_mef_province_id").bind('select',function(event){
			if($(this).val() != 0){
				$.ajax({
					type: "post",
					dataType: "json",
					url: getDistrictUrl,
					cache: false,
					data: {"Id":$(this).val(),"_token":_token,'ajaxRequestJson':'true'},
					success: function (response) {
						initDropDownList(jqxTheme,'100%',36, '#div_mef_district_id',response, 'text', 'value', false, '', '0', "#mef_district_id","ស្វែងរក",350,$scope.address.mef_district_id);
					},
					error: function (request, textStatus, errorThrown) {
						console.log(errorThrown);
					}
				});
			}else{
				initDropDownList(jqxTheme,'100%',36, '#div_mef_district_id',[{"text":"","value":""}], 'text', 'value', false, '', '0', "#mef_district_id","ស្វែងរក",350);
			}
		  });
		  // div_mef_district_id
		  $("#div_mef_district_id").bind('select',function(event){
			if($(this).val() != 0){
				$.ajax({
					type: "post",
					dataType: "json",
					url: getCommuneUrl,
					cache: false,
					data: {"Id":$(this).val(),"_token":_token,'ajaxRequestJson':'true'},
					success: function (response) {
						initDropDownList(jqxTheme,'100%',36, '#div_mef_commune_id',response, 'text', 'value', false, '', '0', "#mef_commune_id","ស្វែងរក",350,$scope.address.mef_commune_id);
					},
					error: function (request, textStatus, errorThrown) {
						console.log(errorThrown);
					}
				});
			}else{
				initDropDownList(jqxTheme,'100%',36, '#div_mef_commune_id',[{"text":"","value":""}], 'text', 'value', false, '', '0', "#mef_commune_id","ស្វែងរក",350);
			}
		  });
		  // div_mef_commune_id
		  $("#div_mef_commune_id").bind('select',function(event){
			if($(this).val() != 0){
				$.ajax({
					type: "post",
					dataType: "json",
					url: getVillagesUrl,
					cache: false,
					data: {"Id":$(this).val(),"_token":_token,'ajaxRequestJson':'true'},
					success: function (response) {
						initDropDownList(jqxTheme,'100%',36, '#div_mef_village_id',response, 'text', 'value', false, '', '0', "#mef_village_id","ស្វែងរក",350,$scope.address.mef_village_id);
					},
					error: function (request, textStatus, errorThrown) {
						console.log(errorThrown);
					}
				});
			}else{
				initDropDownList(jqxTheme,'100%',36, '#div_mef_village_id',[{"text":"","value":""}], 'text', 'value', false, '', '0', "#mef_village_id","ស្វែងរក",350);
			}
		  });

		}, 1000);
	});
	$scope.sumarryData = function(){
		/* SUMMERY DATA */
		$("#SUMMARY_FULL_NAME_KH").text($scope.info.FULL_NAME_KH);
		$("#SUMMARY_PERSONAL_INFORMATION").text($scope.info.PERSONAL_INFORMATION);
		$("#SUMMARY_OFFICIAL_ID").text($scope.info.OFFICIAL_ID);
		$("#SUMMARY_UNIT_CODE").text($scope.info.UNIT_CODE);
		$("#SUMMARY_EMAIL").text($scope.info.EMAIL);
		/* SUMMERY DATA END*/
	}
    $scope.postPersonalInfo = function(nextUrl){
		var image_crop = $("#imageProfileCrop").attr("src");
		is_image_crop = angular.isUndefined(image_crop);
		if(is_image_crop != true){
			$scope.info.AVATAR = image_crop;
		}
		$scope.address.mef_province_id = $("#mef_province_id").val();
		$scope.address.mef_district_id = $("#mef_district_id").val();
		$scope.address.mef_commune_id = $("#mef_commune_id").val();
		$scope.address.mef_village_id = $("#mef_village_id").val();
		$scope.info.TITLE_ID = $("#mef_title_id").val();
		var obj = {
			objInfo:$scope.info,
			DATE_OF_BIRTH:$('#DATE_OF_BIRTH').val(),
			NATION_ID_EXPIRED_DATE:$('#NATION_ID_EXPIRED_DATE').val(),
			PASSPORT_ID_EXPIRED_DATE:$('#PASSPORT_ID_EXPIRED_DATE_VALUE').val(),
			address : $scope.address
		};
		/* Call function validation */
		var dataValidation = {
			FULL_NAME_KH : obj.objInfo.FULL_NAME_KH ? obj.objInfo.FULL_NAME_KH : '',
			FULL_NAME_EN : obj.objInfo.FULL_NAME_EN ? obj.objInfo.FULL_NAME_EN : '',
			DATE_OF_BIRTH : obj.DATE_OF_BIRTH ? obj.DATE_OF_BIRTH : '',
			NATIONALITY_1 : obj.objInfo.NATIONALITY_1 ? obj.objInfo.NATIONALITY_1 : '',
			PLACE_OF_BIRTH : obj.objInfo.PLACE_OF_BIRTH ? obj.objInfo.PLACE_OF_BIRTH : '',
			// CURRENT_ADDRESS : obj.objInfo.CURRENT_ADDRESS ? obj.objInfo.CURRENT_ADDRESS : '',
			//EMAIL : obj.objInfo.EMAIL ? obj.objInfo.EMAIL : '',
			//PHONE_NUMBER_1 : obj.objInfo.PHONE_NUMBER_1 ? obj.objInfo.PHONE_NUMBER_1 : '',
			NATION_ID : obj.objInfo.NATION_ID ? obj.objInfo.NATION_ID : '',
			NATION_ID_EXPIRED_DATE : obj.NATION_ID_EXPIRED_DATE ? obj.NATION_ID_EXPIRED_DATE : '',
			GENDER_MALE : obj.objInfo.GENDER ? obj.objInfo.GENDER : '',
			GENDER_FEMALE : obj.objInfo.GENDER ? obj.objInfo.GENDER : '',
			AVATAR : obj.objInfo.AVATAR == baseUrl + 'images/photo-default.jpg' ? '' : obj.objInfo.AVATAR,
			mef_province_id : $scope.address.mef_province_id,
			mef_district_id : $scope.address.mef_district_id,
			mef_commune_id : $scope.address.mef_commune_id,
			mef_village_id : $scope.address.mef_village_id
		}
		var IS_REGISTER = 1;
		if($scope.validationObject(dataValidation) == false){
			var IS_REGISTER = 0;
		}
		/* End Call function validation */
		var editId = $('#indexEdit').val();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/save-personal-info',
            dataType: "json",
            data:{"data":obj,'editId':editId,"_token":_token,"IS_REGISTER" : IS_REGISTER}
        }).success(function(response) {
			$("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
			if(response.code == 1){
				$("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({position: positionNotify,template: "success"});
				$('#jqx-notification').html(response.message);
                $("#jqx-notification").jqxNotification("open");
				/* SUMMERY FUNCTION */
				$scope.sumarryData();
				/* SUMMERY FUNCTION END */
				if(IS_REGISTER == 1){
					addClassActiveMenu('menu-1');
				}else{
					removeClassActiveMenu('menu-1');
				}
			}else{
				// validationObjectServer
				if($scope.validationObjectServer(response.description) == false){
					return false;
				}
			}
			if(angular.isUndefined(nextUrl) == false){
				$location.path(nextUrl);
			}
        });
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
	$scope.validationObjectServer = function(data){
		$("#personal-info .jqx-validator-error-element").removeClass("jqx-validator-error-element");
		$(".lbl-error").remove();
		var countError	=	0;
		$.each(data, function( index, value ) {
			countError	=	countError + 1;
			$("#" + index).addClass("jqx-validator-error-element");
			$("#DIV_" + index).addClass("jqx-validator-error-element");
			$("#LBL_" + index).append('<span class="lbl-error">' + value + '</span>');
		});
		if(countError > 0){
			$("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
			$("#jqx-notification").jqxNotification();
			$('#jqx-notification').jqxNotification({position: positionNotify,template: "warning" });
			$('#jqx-notification').html("អ៊ីម៉ែលនេះបានប្រើប្រាស់រួចម្តងហើយ");
			$("#jqx-notification").jqxNotification("open");
			return false;
		}else{
			return true;
		}
    }
	$('.cropme').simpleCropper();
	// Hover Image
	$("#landscape").jqxTooltip({ content: 'ចុចនៅលើរូបភាពដើម្បីប្ដូររូបថ្មី', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});

});
