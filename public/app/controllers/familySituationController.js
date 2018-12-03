app.controller("familySituationController", function ($scope,$interval,$http,$filter,$window,$location) {
	$scope.$on("$locationChangeStart", function() {
		if(defaultRouteAngularJs != '/smart-office'){
			$scope.saveFamilySituation();
		}
	});
	$scope.saveFamilySituation = function(url){
		var fLiveChecked = $("#fatherLive").is(":checked");
		var fDieChecked  = $("#fatherDie").is(":checked");
		var mLiveChecked  = $("#motherLive").is(":checked");
		var mDieChecked   = $("#motherDie").is(":checked");
		if (fLiveChecked || fDieChecked || mLiveChecked || mDieChecked) {
			$("#family-situation .jqx-validator-error-element").removeClass("jqx-validator-error-element");
			var count = 0;
			/* validate father fields */
			if($("#fatherNameKh").val() == ""){
				count = count + 1;
			}
			if($("#fatherNameEn").val() == ""){
				count = count + 1;
			}
			if($("#father-date-value").val() == ""){
				count = count + 1;
			} else if($("#father-date-value").val() == "undefined-undefined-") {
				count = count + 1;
			} else {
				count = count;
			}
			if($("#fatherNationality").val() == ""){
				count = count + 1;
			}
			if(fDieChecked == false){
			   	if($("#fatherAddress").val() == ""){
					count = count + 1;
				}
				if($("#fatherCareer").val() == ""){
					count = count + 1;
				}
			}
			/* validate mother fields */
			if($("#motherNameKh").val() == ""){
				count = count + 1;
			}
			if($("#motherNameEn").val() == ""){
				count = count + 1;
			}
			if($("#mother-date-value").val() == ""){
				count = count + 1;
			} else if($("#mother-date-value").val() == "undefined-undefined-") {
				count = count + 1;
			} else {
				count = count;
			}
			if($("#motherNationality").val() == ""){
				count = count + 1;
			}
			if(mDieChecked == false){
			    if($("#motherAddress").val() == ""){
					count = count + 1;
				}
				if($("#motherCareer").val() == ""){
					count = count + 1;
				}
			}
			$scope.countParent = count;
		}
		var spouseChecked = $("#spMarried").is(":checked");
		var spLiveChecked = $("#spStatusLive").is(":checked");
		var spDieChecked = $("#spStatusDie").is(":checked");
		if(spouseChecked){
			if(spLiveChecked || spDieChecked){
				$("#family-situation .jqx-validator-error-element").removeClass("jqx-validator-error-element");
				var count = 0;
				if($("#spNameKh").val() == ""){
					count = count + 1;
				}
				if($("#spNameEn").val() == ""){
					count = count + 1;
				}
				if($("#federation-date-value").val() == ""){
					count = count + 1;
				}
				if($("#spNationality").val() == ""){
					count = count + 1;
				}
				if(spDieChecked == false){
					if($("#spAddress").val() == ""){
						count = count + 1;
					}
					if($("#spCareer").val() == ""){
						count = count + 1;
					}
				}
			}
			$scope.countSpouse = count;
		}
		var fChildExistChecked = $("#fChildrenIdExist").is(":checked");
		if(fChildExistChecked){
			$("#family-situation .jqx-validator-error-element").removeClass("jqx-validator-error-element");
			var count = 0;
			if($("#childrenNameKh_0").val() == ""){
				count = count + 1;
			}
			if($("#childrenNameEn_0").val() == ""){
				count = count + 1;
			}
			if($("#children-date-value_0").val() == ""){
				count = count + 1;
			}
			if($("#childrenCareer_0").val() == ""){
				count = count + 1;
			}
			$scope.countChild = count;
		}
		var fChildrenIdNonChecked = $("#fChildrenIdNon").is(":checked");
		var isNonChildChecked = 0;
		if(fChildrenIdNonChecked == true){
			 isNonChildChecked = 1;
		}
		$scope.familyDate = {
			"FATHER_DOB" : $("#father-date-value").val() != "undefined-undefined-" ? $("#father-date-value").val() : null,
			"MOTHER_DOB" : $("#mother-date-value").val() != "undefined-undefined-" ? $("#mother-date-value").val() : null,
			"SPOUSE_DOB" : $("#federation-date-value").val() != "undefined-undefined-" ? $("#federation-date-value").val() : null,
		};

		angular.forEach($scope.family_sib, function(value, key){
			$scope.family_sib[key]['RELATIVES_NAME_KH'] = $("#siblingNameKh_" + key).val();
			$scope.family_sib[key]['RELATIVES_NAME_EN'] = $("#siblingNameEn_" + key).val();
			$scope.family_sib[key]['RELATIVES_NAME_GENDER'] = $("#siblingFemal_" + key).is(":checked") ? $("#siblingFemal_" + key).val() : $("#siblingMal_" + key).is(":checked") ? $("#siblingMal_" + key).val() : "";
			$scope.family_sib[key]['RELATIVES_NAME_DOB'] = $("#sibling-date-value_" + key).val() != "undefined-undefined-" ? $("#sibling-date-value_" + key).val() : "";
			$scope.family_sib[key]['RELATIVES_NAME_JOB'] = $("#siblingCareer_" + key).val();
		});

		angular.forEach($scope.family_c, function(value, key){
			$scope.family_c[key]['IsExistChild'] = isNonChildChecked;
			$scope.family_c[key]['CHILDRENS_NAME_KH'] = $("#childrenNameKh_" + key).val();
			$scope.family_c[key]['CHILDRENS_NAME_EN'] = $("#childrenNameEn_" + key).val();
			$scope.family_c[key]['CHILDRENS_NAME_GENDER'] = $("#childrenFemal_" + key).is(":checked") ? $("#childrenFemal_" + key).val() : $("#childrenMal_" + key).is(":checked") ? $("#childrenMal_" + key).val() : "";
			$scope.family_c[key]['CHILDRENS_NAME_DOB'] = $("#children-date-value_" + key).val() != "undefined-undefined-" ? $("#children-date-value_" + key).val() : "";
			$scope.family_c[key]['CHILDRENS_NAME_JOB'] = $("#childrenCareer_" + key).val();
			$scope.family_c[key]['CHILDRENS_NAME_SPONSOR'] = $("#childrenExistSpornsor_" + key).is(":checked") ? $("#childrenExistSpornsor_" + key).val() : $("#childrenNoneSpornsor_" + key).is(":checked") ? $("#childrenNoneSpornsor_" + key).val() : "";
		});
		var data = {
			objectFamilyDate: $scope.familyDate,
			objectFamily: $scope.family,
			objectFamilySibling: $scope.toObject($scope.family_sib),
			objectFamilyChildren: $scope.toObject($scope.family_c),
			objectPhoneNumber: $scope.family_p = {
				"0" : $scope.family_p_1 != undefined ? $scope.family_p_1.SPOUSE_PHONE_NUMBER : {},
				"1" : $scope.family_p_2 != undefined ? $scope.family_p_2.SPOUSE_PHONE_NUMBER : {},
				"2" : $scope.family_p_3 != undefined ? $scope.family_p_3.SPOUSE_PHONE_NUMBER : {},
			},
			COUNT_PARENT : $scope.countParent,
			COUNT_SPOUSE : $scope.countSpouse,
			COUNT_CHILD  : $scope.countChild
		};
		var editId = $('#indexEdit').val();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/family-situations',
            dataType: "json",
            data:{'editId':editId,"data":data}
        }).success(function(response) {
			if(response.code == 1){
				if(angular.isUndefined(url) == false){
					/*   ទៅមុខរឺថយក្រោយ */
					$location.path(url);
					$("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* sumarryDataGeneralKnowledge */
					$scope.sumarryDataFamilySituations();
					/* End sumarryDataGeneralKnowledge */
					addClassActiveMenu('menu-7');
				} else {
					/*  រក្សាទុក  */
					$("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
					$('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* sumarryDataGeneralKnowledge */
					$scope.sumarryDataFamilySituations();
					/* End sumarryDataGeneralKnowledge */
					addClassActiveMenu('menu-7');
				}
				$('#btn-forwoard').removeClass('display-none');
			} else if(response.code == 2) {
				if(angular.isUndefined(url) == false){
					/*   ទៅមុខរឺថយក្រោយ */
					$location.path(url);
					$("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* sumarryDataGeneralKnowledge */
					$scope.sumarryDataFamilySituations();
					/* End sumarryDataGeneralKnowledge */
					removeClassActiveMenu('menu-7');
				} else {
					/*  រក្សាទុក  */
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* sumarryDataGeneralKnowledge */
					$scope.sumarryDataFamilySituations();
					/* End sumarryDataGeneralKnowledge */
					removeClassActiveMenu('menu-7');
				}
			} else { // when empty fields
					/*  រក្សាទុក  */
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* sumarryDataGeneralKnowledge */
					$scope.sumarryDataFamilySituations();
					/* End sumarryDataGeneralKnowledge */
					$location.path(url);
			}
        });
	};
	$scope.getFamilySituationsById = function(callback){
		loadingWaiting();
		var editId = $('#indexEdit').val();
		$http({
			method: 'post',
			url: baseUrl+'background-staff-gov-info/get-family-situations-by-id',
			dataType: "json",
			data:{'editId':editId,"_token":_token}
		}).success(function(response) {
			callback(response);
		});
	};
	$scope.getFamilySituationsById(function(data){
		$scope.family_sib = data[0].sibling;
		$scope.family_c = data[0].children;
		var url = $location.url();
		var childrenUncheck = '';
		var childrenNameEn = '';
		var childrenNameKh = '';
		if(data[0].children.length > 0){
		   childrenUncheck = data[0].children[0].IsExistChild;
		   childrenNameEn = data[0].children[0].CHILDRENS_NAME_EN;
		   childrenNameKh = data[0].children[0].CHILDRENS_NAME_KH;
		}
		if(data[0].userData.FATHER_LIVE == "ស្លាប់"){
			$scope.fatherStatusIsDied();
		}
		if(data[0].userData.MOTHER_LIVE == "ស្លាប់"){
			$scope.motherStatusIsDied();
		}
		if(data[0].userData.SPOUSE_LIVE == "ស្លាប់"){
			$scope.spouseDied();
		}
		if(url == "/family-situations" || url == "/all-form"){
			console.log(data.userStatus.MARRIED);
			if(data.userStatus.MARRIED == 0){
				$('#spStatusLive').prop('checked',true);
				$('#spouseSponsor').prop('checked',true);
				$('#spNameKh').prop('disabled',true);
				$('#spNameEn').prop('disabled',true);
				$('.spStatus').prop('disabled',true);
				$("#federationBD").jqxDateTimeInput({ disabled: true,placeHolder: "ថ្ងៃខែឆ្នាំកំណើត" });
				$('.spNationality').prop('disabled',true);
				$('#spAddress').prop('disabled',true);
				$('#spCareer').prop('disabled',true);
				$('#spProcurement').prop('disabled',true);
				$('.isSpornsor').prop('disabled',true);
				$('.spNumber').prop('disabled',true);
				$('.spFamily').prop('disabled',true);
				$("#spNonMarried").prop('checked', true);
				$("#fChildrenIdExist").prop('disabled',true);
				$("#fChildrenIdNon").prop('disabled',true);
				/* children information */
				if(childrenNameEn == '' && childrenNameKh == '' || childrenUncheck == 1){
					$('#fChildrenIdNon').prop('checked', true);
					$('#nameKh-red').removeClass("col-red");
					$('#nameKh-red').addClass("col-black");
					$('#nameEn-red').removeClass("col-red");
					$('#nameEn-red').addClass("col-black");
					$('#gender-red').removeClass("col-red");
					$('#gender-red').addClass("col-black");
					$('#dob-red').removeClass("col-red");
					$('#dob-red').addClass("col-black");
					$('#career-red').removeClass("col-red");
					$('#career-red').addClass("col-black");
					$('#spornsor-red').removeClass("col-red");
					$('#spornsor-red').addClass("col-black");
					$('#button-add').prop('disabled',true);
				} else {
					$("#fChildrenIdExist").prop('checked', true);
					$('.childenSpornsor').prop('checked',true);
					$('#button-add').prop('disabled',false);
				}

			} else {
				/* Children Infomation */
				if(childrenUncheck == 1){
					$('#fChildrenIdNon').prop('checked', true);
					$('#nameKh-red').removeClass("col-red");
					$('#nameKh-red').addClass("col-black");
					$('#nameEn-red').removeClass("col-red");
					$('#nameEn-red').addClass("col-black");
					$('#gender-red').removeClass("col-red");
					$('#gender-red').addClass("col-black");
					$('#dob-red').removeClass("col-red");
					$('#dob-red').addClass("col-black");
					$('#career-red').removeClass("col-red");
					$('#career-red').addClass("col-black");
					$('#spornsor-red').removeClass("col-red");
					$('#spornsor-red').addClass("col-black");
					$('#button-add').prop('disabled',true);
				} else {
					$("#fChildrenIdExist").prop('checked', true);
					$('.childenSpornsor').prop('checked',true);
					$('#button-add').prop('disabled',false);
				}
				/* federation information */
				$('.spFamily').prop('disabled',true);
				$('#spMarried').prop('checked', true);
				$('#federationNameKh').removeClass('display-none');
				$('#federationNameEn').removeClass('display-none');
				$('#federationDOB').removeClass('display-none');
				$('#federationNationality').removeClass('display-none');
				$('#federationPOB').removeClass('display-none');
				$('#federationJOB').removeClass('display-none');
			}
		}
		var fDate = data[0].userData.FATHER_DOB != null ? $("#father-date-value").val(data[0].userData.FATHER_DOB) : '';
		var mDate = data[0].userData.MOTHER_DOB != null ? $("#mother-date-value").val(data[0].userData.MOTHER_DOB) : '';
		var sDate = data[0].userData.SPOUSE_DOB != null ? $("#federation-date-value").val(data[0].userData.SPOUSE_DOB) : '';
		$scope.family = {
			"FATHER_NAME_KH": data[0].userData.FATHER_NAME_KH,
			"FATHER_NAME_EN": data[0].userData.FATHER_NAME_EN,
			"FATHER_LIVE": data[0].userData.FATHER_LIVE != null ? data[0].userData.FATHER_LIVE : "រស់",
			"FATHER_JOB" : data[0].userData.FATHER_JOB,
			"FATHER_DOB" : fDate,
			"FATHER_NATIONALITY_1": data[0].userData.FATHER_NATIONALITY_1,
			"FATHER_NATIONALITY_2": data[0].userData.FATHER_NATIONALITY_2,
			"FATHER_UNIT": data[0].userData.FATHER_UNIT,
			"FATHER_ADDRESS": data[0].userData.FATHER_ADDRESS,
			"MOTHER_ADDRESS": data[0].userData.MOTHER_ADDRESS,
			"MOTHER_JOB": data[0].userData.MOTHER_JOB,
			"MOTHER_DOB" : mDate,
			"MOTHER_LIVE": data[0].userData.MOTHER_LIVE != null ? data[0].userData.MOTHER_LIVE : "រស់",
			"MOTHER_NAME_EN": data[0].userData.MOTHER_NAME_EN,
			"MOTHER_NAME_KH": data[0].userData.MOTHER_NAME_KH,
			"MOTHER_NATIONALITY_1": data[0].userData.MOTHER_NATIONALITY_1,
			"MOTHER_NATIONALITY_2": data[0].userData.MOTHER_NATIONALITY_2,
			"MOTHER_UNIT": data[0].userData.MOTHER_UNIT,
			"SPOUSE_JOB": data[0].userData.SPOUSE_JOB,
			"SPOUSE_DOB": sDate,
			"SPOUSE_LIVE": data[0].userData.SPOUSE_LIVE != null ? data[0].userData.SPOUSE_LIVE : "រស់",
			"SPOUSE_NAME_EN": data[0].userData.SPOUSE_NAME_EN,
			"SPOUSE_NAME_KH": data[0].userData.SPOUSE_NAME_KH,
			"SPOUSE_NATIONALITY_1": data[0].userData.SPOUSE_NATIONALITY_1,
			"SPOUSE_NATIONALITY_2": data[0].userData.SPOUSE_NATIONALITY_2,
			//"SPOUSE_PHONE_NUMBER": data[0].userData.SPOUSE_PHONE_NUMBER != undefined ? data[0].userData.SPOUSE_PHONE_NUMBER : '',
			"SPOUSE_POB": data[0].userData.SPOUSE_POB,
			"SPOUSE_SPONSOR": data[0].userData.SPOUSE_SPONSOR != null ? data[0].userData.SPOUSE_SPONSOR : "គ្មាន",
			"SPOUSE_UNIT": data[0].userData.SPOUSE_UNIT,
		};
		if(($scope.family_sib).length <= 0){
			$scope.family_sib	= [{}];
		}
		if(($scope.family_c).length <= 0){
			$scope.family_c	= [{}];
		}
		var dateSibling = [];
		var dateChildren = [];
		setTimeout(function(){
			var url = $location.url();
		    if(url == "/family-situations" || url == "/all-form"){
			    /*   ព័ត៌មានបងប្អូន   */
				angular.forEach($scope.family_sib, function(value, key){
					if(value.RELATIVES_NAME_GENDER == "ប្រុស"){
					   	$("#siblingMal_" + key).prop('checked', true);
					} else {
						$("#siblingMal_" + key).prop('checked', false);
					}
					if(value.RELATIVES_NAME_GENDER == "ស្រី"){
					   	$("#siblingFemal_" + key).prop('checked', true);
					} else {
						$("#siblingFemal_" + key).prop('checked', false);
					}
					dateSibling[key] = value.RELATIVES_NAME_DOB == '0000-00-00' ? '' : value.RELATIVES_NAME_DOB;
					getJqxCalendar('siblingBD_' + key,'sibling-date-value_' + key,'100px','32px','ថ្ងៃខែឆ្នាំកំណើត',dateSibling[key]);
					$("#sibling-date-value_" + key).val(value.RELATIVES_NAME_DOB);
					$("#siblingNameEn_" + key).val(value.RELATIVES_NAME_EN);
					$("#siblingNameKh_" + key).val(value.RELATIVES_NAME_KH);
					$("#siblingCareer_" + key).val(value.RELATIVES_NAME_JOB);
				});
				/*   ព័ត៌មានកូន​   */
				angular.forEach($scope.family_c, function(value, key){
					if(value.CHILDRENS_NAME_GENDER == "ប្រុស"){
					   	$("#childrenMal_" + key).prop('checked', true);
					} else {
						$("#childrenMal_" + key).prop('checked', false);
					}
					if(value.CHILDRENS_NAME_GENDER == "ស្រី"){
					   	$("#childrenFemal_" + key).prop('checked', true);
					} else {
						$("#childrenFemal_" + key).prop('checked', false);
					}
					
					if(value.CHILDRENS_NAME_SPONSOR == "មាន"){
					   	$("#childrenExistSpornsor_" + key).prop('checked', true);
					} else {
						$("#childrenExistSpornsor_" + key).prop('checked', false);
					}
					if(value.CHILDRENS_NAME_SPONSOR == "គ្មាន"){
					   	$("#childrenNoneSpornsor_" + key).prop('checked', true);
					} else {
						$("#childrenNoneSpornsor_" + key).prop('checked', false);
					}
					
					dateChildren[key] = value.CHILDRENS_NAME_DOB == '0000-00-00' ? '' : value.CHILDRENS_NAME_DOB;
					getJqxCalendar('childrenBD_' + key,'children-date-value_' + key,'100px','32px','ថ្ងៃខែឆ្នាំកំណើត',dateChildren[key]);
					$("#children-date-value_" + key).val(value.CHILDRENS_NAME_DOB);
					$("#childrenNameEn_" + key).val(value.CHILDRENS_NAME_EN);
					$("#childrenNameKh_" + key).val(value.CHILDRENS_NAME_KH);
					$("#childrenCareer_" + key).val(value.CHILDRENS_NAME_JOB);
					if(childrenUncheck == 1 || data.userStatus.MARRIED == 1){
						$("#childrenNameKh_" + key).prop('disabled', true);
						$("#childrenNameEn_" + key).prop('disabled', true);
						$('#childrenFemal_' + key).prop('disabled',true);
						$('#childrenMal_' + key).prop('disabled',true);
						$("#childrenBD_" + key).jqxDateTimeInput({ disabled: true,placeHolder: "ថ្ងៃខែឆ្នាំកំណើត" });
						$('#childrenCareer_' + key).prop('disabled',true);
						$('#childrenExistSpornsor_' + key).prop('disabled',true);
						$('#childrenNoneSpornsor_' + key).prop('disabled',true);
					} else {
						$('#childrenNoneSpornsor_' + key).prop('checked',true);
						$('#childrenFemal_' + key).prop('checked',true);
					}
				});
			}
			
			/* SUMMERY FUNCTION */
			$scope.sumarryDataFamilySituations();
			/* SUMMERY FUNCTION END */
			
		}, 2000);
		if(data[0].phone != null){
			$scope.family_p_1 = {
				"SPOUSE_PHONE_NUMBER" : data[0].phone[0] != '' ? data[0].phone[0] : ''
			};
			$scope.family_p_2 = {
				"SPOUSE_PHONE_NUMBER" : data[0].phone[1] != '' ? data[0].phone[1] : ''
			};
			$scope.family_p_3 = {
				"SPOUSE_PHONE_NUMBER" : data[0].phone[2] != '' ? data[0].phone[2] : ''
			};
		}
		if($location.url() == "/family-situations" || url == "/all-form"){
			/* father date of birth */
			var fDate = $('#father-date-value').val() != null ? $('#father-date-value').val():null;
			getJqxCalendar('fatherBD','father-date-value','140px','35px','ថ្ងៃខែឆ្នាំកំណើត',fDate);
			/* mother date of birth */
			var mDate = $('#mother-date-value').val() != null ? $('#mother-date-value').val():null;
			getJqxCalendar('motherBD','mother-date-value','140px','35px','ថ្ងៃខែឆ្នាំកំណើត',mDate);
			/* federation date of birth */
			var sDate = $('#federation-date-value').val() != null ? $('#federation-date-value').val():null;
			getJqxCalendar('federationBD','federation-date-value','140px','35px','ថ្ងៃខែឆ្នាំកំណើត',sDate);
		}
		setTimeout(function(){
			endLoadingWaiting();
		},2000);
	});
	/* $scope.getAutoCompleted = function(){
		loadingWaiting();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/get-auto-completed',
            dataType: "json",
            data:{"_token":_token,"formId":"07"}
        }).success(function(response) {
			var result_1 = {};
			var result_2 = {};
			var result_3 = {};
			var result_4 = {};
			var result_5 = {};
			var result_6 = {};
			var result_7 = {};
			var result_8 = {};
			var result_9 = {};
			
			var nationality_1 = response.NATIONALITY_1;
			var nationality_2 = response.NATIONALITY_2;
			var f_unit = response.FATHER_UNIT;
			var m_unit = response.MOTHER_UNIT;
			var f_career = response.FATHER_JOB;
			var m_career = response.MOTHER_JOB;
			var is_married = response.MARRIED[0];
			var spouse_job = response.SPOUSE_JOB;
			var spouse_unit = response.SPOUSE_UNIT;
			var children_job = response.CHILDRENS_NAME_JOB;
			
			for (var i = 0; i < nationality_1.length; i++) {
				result_1[i] = nationality_1[i]['NATIONALITY_1'];
			}
	 
			$("#fatherNationality").jqxInput({ placeHolder: "១.", height: 36, width: 150, minLength: 1, source: result_1 });
			$("#motherNationality").jqxInput({ placeHolder: "១.", height: 36, width: 150, minLength: 1, source: result_1 });
			
			for (var j = 0; j < nationality_2.length; j++){
				result_2[j] = nationality_2[j]['NATIONALITY_2'];
			}
			$("#fatherNationality_2").jqxInput({ placeHolder: "២.", height: 36, width: 90, minLength: 1, source: result_2 });
			$("#motherNationality_2").jqxInput({ placeHolder: "២.", height: 36, width: 90, minLength: 1, source: result_2 });
			
			if(is_married.MARRIED == "0"){
				$("#spNationality").jqxInput({ placeHolder: "១.", height: 36, width: '100%', minLength: 1, source: result_1 });
				$("#spNationality_2").jqxInput({ placeHolder: "២.", height: 36, width: '100%', minLength: 1, source: result_2 });
				
				for (var p = 0; p < spouse_job.length; p++){
					result_7[p] = spouse_job[p]['SPOUSE_JOB'];
				}
				$("#spCareer").jqxInput({ placeHolder: "មុខរបរ", height: 36, width: '100%', minLength: 1, source: result_7 });
				
				for (var q = 0; q < spouse_unit.length; q++){
					result_8[q] = spouse_unit[q]['SPOUSE_UNIT'];
				}
				$("#spProcurement").jqxInput({ placeHolder: "អង្គភាព", height: 36, width: '100%', minLength: 1, source: result_8 });
				
				for (var r = 0; r < children_job.length; r++){
					result_9[r] = children_job[r]['CHILDRENS_NAME_JOB'];
				}
				angular.forEach($scope.family_c, function(value, key){
					$("#childrenCareer_"+key).jqxInput({ placeHolder: "មុខរបរ", height: 36, width: '100%', minLength: 1, source: result_9 });
				});
			}
			
			for (var k = 0; k < f_unit.length; k++) {
				result_3[k] = f_unit[k]['FATHER_UNIT'];
			}
			$("#f_unit").jqxInput({ placeHolder: "ស្ថាប័ន/អង្គភាព", height: 36, width: "100%", minLength: 1, source: result_3 });
			
			for (var l = 0; l < m_unit.length; l++) {
				result_4[l] = m_unit[l]['MOTHER_UNIT'];
			}
			$("#m_unit").jqxInput({ placeHolder: "ស្ថាប័ន/អង្គភាព", height: 36, width: "100%", minLength: 1, source: result_4 });
			
			for (var m = 0; m < f_career.length; m++){
				result_5[m] = f_career[m]['FATHER_JOB'];
			}
			$("#fatherCareer").jqxInput({ placeHolder: "មុខរបរ", height: 36, width: "100%", minLength: 1, source: result_5 });
			
			for (var n = 0; n < m_career.length; n++){
				result_6[n] = m_career[n]['MOTHER_JOB'];
			}
			$("#motherCareer").jqxInput({ placeHolder: "មុខរបរ", height: 36, width: "100%", minLength: 1, source: result_6 });
			endLoadingWaiting();
        });
	}
	$scope.getAutoCompleted();
	*/
	$scope.sumarryDataFamilySituations = function(){
		/* SUMMERY DATA */
		$("#SUMMARY_FATHER_NAME_KH").text($scope.family.FATHER_NAME_KH ? $scope.family.FATHER_NAME_KH : '');
		$("#SUMMARY_FATHER_NAME_EN").text($scope.family.FATHER_NAME_KH ? $scope.family.FATHER_NAME_EN : '');
		$("#SUMMARY_DATE_OF_BIRTH").text($("#fatherBD").attr('aria-valuetext'));
		$("#SUMMARY_FATHER_ADDRESS").text($scope.family.FATHER_ADDRESS ? $scope.family.FATHER_ADDRESS : '');
		$("#SUMMARY_FATHER_JOB").text($scope.family.FATHER_JOB ? $scope.family.FATHER_JOB : '');
		/* SUMMERY DATA END*/
	};
	$scope.addMoreFamilySibling = function(){
		$scope.family_sib.push({});
		var dateSibling = [];
		setTimeout(function(){
			angular.forEach($scope.family_sib, function(value, key){
				dateSibling[key] = value.RELATIVES_NAME_DOB == '0000-00-00' ? '' : value.RELATIVES_NAME_DOB;
				getJqxCalendar('siblingBD_' + key,'sibling-date-value_' + key,'100px','32px','ថ្ងៃខែឆ្នាំកំណើត',dateSibling[key]);
				$("#sibling-date-value_" + key).val(value.RELATIVES_NAME_DOB);
			});
		}, 200);
	};
	$scope.removeMoreFamilySibling = function(keyIndex){
		if(angular.isUndefined(keyIndex) == true){
			$scope.family_sib.splice($scope.keyIndexObjCache,1);
			$('#ModalConfirm_sib').modal('hide');
		}else{
			if(
				$("#siblingNameKh_" + keyIndex).val() != "" ||
				$("#siblingNameEn_" + keyIndex).val() != "" ||
				$("#siblingFemal_"+keyIndex).is(":checked") != false ||
				$("#siblingMal_"+keyIndex).is(":checked") != false ||
				$("#sibling-date-value_" + keyIndex).val() != "" ||
				$("#siblingCareer_" + keyIndex).val() != ""
			){
				$(".btn-confrim-ok").addClass("display-none");
				$("#btnRemoveWorkHistory_sib").removeClass("display-none");
				$('#ModalConfirm_sib').modal('show');
				$scope.keyIndexObjCache	=	keyIndex;
			}else{
				$scope.family_sib.splice(keyIndex,1);  
			}
		} 
	};
	$scope.addMoreFamilyChildren = function(){
		$scope.family_c.push({});
		var dateChildren = [];
		setTimeout(function(){
			angular.forEach($scope.family_c, function(value, key){
				$http({
					method: 'post',
					url: baseUrl+'background-staff-gov-info/get-auto-completed',
					dataType: "json",
					data:{"_token":_token,"formId":"07"}
				}).success(function(response) {
					var result_9 = {};
					var is_married = response.MARRIED[0];
					var children_job = response.CHILDRENS_NAME_JOB;
					
					if(is_married.MARRIED == "0"){			
						for (var r = 0; r < children_job.length; r++){
							result_9[r] = children_job[r]['CHILDRENS_NAME_JOB'];
						}
						console.log(result_9);
						$("#childrenCareer_"+key).jqxInput({ placeHolder: "មុខរបរ", height: 36, width: '100%', minLength: 1, source: result_9 });
					}
				});
				if(key > 0){
					dateChildren[key] = value.CHILDRENS_NAME_DOB == '0000-00-00' ? '' : value.CHILDRENS_NAME_DOB;
					getJqxCalendar('childrenBD_' + key,'children-date-value_' + key,'100px','32px','ថ្ងៃខែឆ្នាំកំណើត',dateChildren[key]);
					$("#children-date-value_" + key).val(value.CHILDRENS_NAME_DOB);
				}
			});
		}, 200);
	};
	$scope.removeMoreFamilyChildren = function(keyIndex){
		if(angular.isUndefined(keyIndex) == true){
			$scope.family_c.splice($scope.keyIndexObjCache_c,1);
			$('#ModalConfirm_c').modal('hide');
		}else{
			if(
				$("#childrenNameKh_" + keyIndex).val() != "" ||
				$("#childrenNameEn_" + keyIndex).val() != "" ||
				$("#childrenFemal_"+keyIndex).is(":checked") != false ||
				$("#childrenMal_"+keyIndex).is(":checked") != false ||
				$("#children-date-value_" + keyIndex).val() != "" ||
				$("#childrenCareer_" + keyIndex).val() != "" ||
				$("#childrenExistSpornsor_"+keyIndex).is(":checked") != false ||
				$("#childrenNoneSpornsor_"+keyIndex).is(":checked") != false
			){
				$(".btn-confrim-ok").addClass("display-none");
				$("#btnRemoveWorkHistory_c").removeClass("display-none");
				$('#ModalConfirm_c').modal('show');
				$scope.keyIndexObjCache_c	=	keyIndex;
			}else{
				$scope.family_c.splice(keyIndex,1);
			}
		}   
	};
	$scope.disableChildrenTextFields = function(){
		$("#fChildrenIdNon").prop('checked', true);
		if($scope.family_c.length > 1){
			$scope.family_c = [{}];
			setTimeout(function(){
				getJqxCalendar('childrenBD_0','children-date-value_0','180px','32px','ថ្ងៃខែឆ្នាំកំណើត','');
				$("#children-date-value_0").val('');
				$("#childrenBD_0").jqxDateTimeInput({ disabled: true,placeHolder: "ថ្ងៃខែឆ្នាំកំណើត" });
				$('#childrenNameKh_0').prop('disabled',true);
				$('#childrenNameEn_0').prop('disabled',true);
				$('#childrenFemal_0').prop('disabled',true);
				$('#childrenMal_0').prop('disabled',true);
				$('#childrenFemal_0').prop('checked', false);
				$('#childrenMal_0').prop('checked', false);
				$('#childrenCareer_0').prop('disabled',true);
				$('#childrenExistSpornsor_0').prop('disabled',true);
				$('#childrenNoneSpornsor_0').prop('disabled',true);
				$('#childrenExistSpornsor_0').prop('checked', false);
				$('#childrenNoneSpornsor_0').prop('checked', false);
			}, 200);
		}
		$('#nameKh-red').removeClass("col-red");
		$('#childrenNameKh_0').prop('disabled',true);
		$('#childrenNameKh_0').val('');
		$('#nameKh-red').addClass("col-black");
		$('#nameEn-red').removeClass("col-red");
		$('#childrenNameEn_0').prop('disabled',true);
		$('#childrenNameEn_0').val('');
		$('#nameEn-red').addClass("col-black");
		$('#gender-red').removeClass("col-red");
		$('#gender-red').addClass("col-black");
		$('#childrenFemal_0').prop('disabled',true);
		$('#childrenMal_0').prop('disabled',true);
		$('#childrenFemal_0').prop('checked', false);
		$('#childrenMal_0').prop('checked', false);
		$('#dob-red').removeClass("col-red");
		$('#dob-red').addClass("col-black");
		$("#childrenBD_0").jqxDateTimeInput({ disabled: true,placeHolder: "ថ្ងៃខែឆ្នាំកំណើត" });
		$("#childrenBD_0").val('');
		$('#career-red').removeClass("col-red");
		$('#career-red').addClass("col-black");
		$('#childrenCareer_0').prop('disabled',true);
		$('#childrenCareer_0').val('');
		$('#spornsor-red').removeClass("col-red");
		$('#spornsor-red').addClass("col-black");
		$('#childrenExistSpornsor_0').prop('disabled',true);
		$('#childrenNoneSpornsor_0').prop('disabled',true);
		$('#childrenExistSpornsor_0').prop('checked', false);
		$('#childrenNoneSpornsor_0').prop('checked', false);
		$('#button-add').prop('disabled',true);
	};
	$scope.enableChildrenTextFields = function(){
		$("#fChildrenIdExist").prop('checked', true);
		$('#nameKh-red').removeClass("col-black");
		$('#childrenNameKh_0').prop('disabled',false);
		$('#nameKh-red').addClass("col-red");
		$('#nameEn-red').removeClass("col-black");
		$('#childrenNameEn_0').prop('disabled',false);
		$('#nameEn-red').addClass("col-red");
		$('#gender-red').removeClass("col-black");
		$('#gender-red').addClass("col-red");
		$('#childrenFemal_0').prop('disabled',false);
		$('#childrenMal_0').prop('disabled',false);
		$('#dob-red').removeClass("col-black");
		$('#dob-red').addClass("col-red");
		$("#childrenBD_0").jqxDateTimeInput({ disabled: false,placeHolder: "ថ្ងៃខែឆ្នាំកំណើត" });
		$('#career-red').removeClass("col-black");
		$('#career-red').addClass("col-red");
		$('#childrenCareer_0').prop('disabled',false);
		$('#spornsor-red').removeClass("col-black");
		$('#spornsor-red').addClass("col-red");
		$('#childrenExistSpornsor_0').prop('disabled',false);
		$('#childrenNoneSpornsor_0').prop('disabled',false);
		$('#button-add').prop('disabled',false);
		
	};
	$scope.toObject = function(arr) {
	  var rv = {};
	  if(arr != null){
		for (var i = 0; i < arr.length; ++i)
		rv[i] = arr[i];
	  }
	  return rv;
    };
	$scope.fatherStatusIsDied = function(){
		$('#fatherDied').removeClass("col-red");
		$('#fatherWorking').removeClass("col-red");
	};
	$scope.fatherStatusIsLived = function(){
		$('#fatherDied').addClass("col-red");
		$('#fatherWorking').addClass("col-red");
	};
	$scope.motherStatusIsDied = function(){
		$('#motherDied').removeClass("col-red");
		$('#motherWorking').removeClass("col-red");
	};
	$scope.motherStatusIsLived = function(){
		$('#motherDied').addClass("col-red");
		$('#motherWorking').addClass("col-red");
	};
	$scope.spouseDied = function(){
		$('#federationPOB').removeClass("col-red");
		$('#federationJOB').removeClass("col-red");
	}
	$scope.spouselived = function(){
		$('#federationPOB').addClass("col-red");
		$('#federationJOB').addClass("col-red");
	};
	
});