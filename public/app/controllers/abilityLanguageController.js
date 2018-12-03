app.controller("abilityLanguageController", function ($scope,$interval,$http,$filter,$window,$location) {
		$scope.$on("$locationChangeStart", function() {
			if(defaultRouteAngularJs != '/smart-office'){
				$scope.saveAbilityLanguage();
			}
		});
		
		$scope.getAbilityForeignLanguageById = function(callback){
		loadingWaiting();
		var editId = $('#indexEdit').val();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/get-ability-foreign-language-by-id',
            dataType: "json",
            data:{'editId':editId,"_token":_token}
        }).success(function(response) {
			callback(response);
        });
	};
	
	$scope.getAbilityForeignLanguageById(function(data){
		var dataDefault	=	[{}];
		if(data.length <= 0){
			$scope.AbilityForeignLanguage	=  dataDefault;
			 
		}else{
			$scope.AbilityForeignLanguage	=  data;
		}
		var reading = [];
		var writing = [];
		var speaking = [];
		var listening = [];
		var language = [];
		var url = $location.url();
		if(url == "/ability-foreign-language" || url == "/all-form"){
			setTimeout(function(){
				angular.forEach($scope.AbilityForeignLanguage, function(value, key){
					language[key] = value.LANGUAGE;
					initDropDownList(jqxTheme,100,30, '#div_language_'+ key, angular.fromJson($("#listlanguageJson").text()), 'text', 'value', false, '', '0', "#language_"+ key,"ស្វែងរក",300,language[key]);
					$("#language_" + key).val(language[key]);
					//
					reading[key] = value.RED;
					initDropDownList(jqxTheme,100,30, '#div_reading_level_'+ key, angular.fromJson($("#listTypeQualificationsJson").text()), 'text', 'value', false, '', '0', "#readingLevel_"+ key,"ស្វែងរក",200,reading[key]);
					$("#readingLevel_" + key).val(reading[key]);
					// 
					writing[key] = value.WRITE;
					initDropDownList(jqxTheme,100,30, '#div_writing_level_'+ key, angular.fromJson($("#listWritingJson").text()), 'text', 'value', false, '', '0', "#writingLevel_"+ key,"ស្វែងរក",200,writing[key]);
					$("#writingLevel_" + key).val(writing[key]);
					// 
					speaking[key] = value.SPEAK;
					initDropDownList(jqxTheme,100,30, '#div_speaking_level_'+ key, angular.fromJson($("#listSpeakingJson").text()), 'text', 'value', false, '', '0', "#speakingLevel_"+key,"ស្វែងរក",200,speaking[key]);
					$("#speakingLevel_" + key).val(speaking[key]);
					//
					listening[key] = value.LISTEN;	
					initDropDownList(jqxTheme,100,30, '#div_listening_level_'+key, angular.fromJson($("#listListeningJson").text()), 'text', 'value', false, '', '0', "#listeningLevel_"+key,"ស្វែងរក",200,listening[key]);
					$("#listeningLevel_" + key).val(listening[key]);
				});
				
				/* SUMMERY FUNCTION */
				$scope.sumarryDataAbilityForeignLanguage();
				/* SUMMERY FUNCTION END */
				
			}, 2000);
		}
		setTimeout(function(){
			endLoadingWaiting();
		},2000);
	});
	
	$scope.sumarryDataAbilityForeignLanguage = function(){
		/* SUMMERY DATA */
		$("#SUMMARY_LANGUAGE_0").text($("#dropdownlistContentdiv_language_0").text());
		$("#SUMMARY_READING_LEVEL_0").text($("#dropdownlistContentdiv_reading_level_0").text());
		$("#SUMMARY_WRITING_LEVEL_0").text($("#dropdownlistContentdiv_writing_level_0").text());
		$("#SUMMARY_SPEAKING_LEVEL_0").text($("#dropdownlistContentdiv_speaking_level_0").text());
		$("#SUMMARY_LISTENING_LEVEL_0").text($("#dropdownlistContentdiv_listening_level_0").text());
		/* SUMMERY DATA END*/
	};
	
	$scope.saveAbilityLanguage = function(url){
		angular.forEach($scope.AbilityForeignLanguage, function(value, key){
			$scope.AbilityForeignLanguage[key]['RED'] = $("#readingLevel_" + key).val();
			$scope.AbilityForeignLanguage[key]['WRITE'] = $("#writingLevel_" + key).val();
			$scope.AbilityForeignLanguage[key]['SPEAK'] = $("#speakingLevel_" + key).val();
			$scope.AbilityForeignLanguage[key]['LISTEN'] = $("#listeningLevel_" + key).val();
			$scope.AbilityForeignLanguage[key]['LANGUAGE'] = $("#language_" + key).val();
		});	
		var data = $scope.AbilityForeignLanguage;
		var editId = $('#indexEdit').val();
        $http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/ability-foreign',
            dataType: "json",
            data:{'editId':editId,"data":data}
        }).success(function(response) {
			if(angular.isUndefined(url) == false){
				$location.path(url);
					$("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* SUMMERY FUNCTION */
					$scope.sumarryDataAbilityForeignLanguage();
					/* SUMMERY FUNCTION END */
				addClassActiveMenu('menu-6');
			} else {
			    $("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
				if(response.code == 1){
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* SUMMERY FUNCTION */
					$scope.sumarryDataAbilityForeignLanguage();
					/* SUMMERY FUNCTION END */
				}
				addClassActiveMenu('menu-6');	
			}
        });
	};

	$scope.addMoreAbilityLanguage	=	function(){
		$scope.AbilityForeignLanguage.push({});
		var lastIndex	=	($scope.AbilityForeignLanguage).length - 1;
		setTimeout(function(){
				
				language = $scope.AbilityForeignLanguage[lastIndex].language;
				initDropDownList(jqxTheme,100,30, '#div_language_'+ lastIndex, angular.fromJson($("#listlanguageJson").text()), 'text', 'value', false, '', '0', "#language_"+ lastIndex,"ស្វែងរក",300,language);
				$("#language_" + lastIndex).val(language);

				// 
				reading = $scope.AbilityForeignLanguage[lastIndex].readingLevel;
				initDropDownList(jqxTheme,100,30, '#div_reading_level_'+ lastIndex, angular.fromJson($("#listTypeQualificationsJson").text()), 'text', 'value', false, '', '0', "#readingLevel_"+ lastIndex,"ស្វែងរក",200,reading);
				$("#readingLevel_" + lastIndex).val(reading);
				// 
				writing = $scope.AbilityForeignLanguage[lastIndex].writingLevel;
				initDropDownList(jqxTheme,100,30, '#div_writing_level_'+ lastIndex, angular.fromJson($("#listWritingJson").text()), 'text', 'value', false, '', '0', "#writingLevel_"+ lastIndex,"ស្វែងរក",200,writing);
				$("#writingLevel_" + lastIndex).val(writing);
				// 
				speaking = $scope.AbilityForeignLanguage[lastIndex].speakingLevel;
				initDropDownList(jqxTheme,100,30, '#div_speaking_level_'+ lastIndex, angular.fromJson($("#listSpeakingJson").text()), 'text', 'value', false, '', '0', "#speakingLevel_"+lastIndex,"ស្វែងរក",200,speaking);
				$("#speakingLevel_" + lastIndex).val(speaking);
				//
				listening = $scope.AbilityForeignLanguage[lastIndex].listeningLevel;	
				initDropDownList(jqxTheme,100,30, '#div_listening_level_'+lastIndex, angular.fromJson($("#listListeningJson").text()), 'text', 'value', false, '', '0', "#listeningLevel_"+lastIndex,"ស្វែងរក",200,listening);
				$("#speakingLevel_" + lastIndex).val(listening);
			
		}, 200);
	};
	
	$scope.removeAbilityLanguage	=	function(keyIndex){

		if(angular.isUndefined(keyIndex) == true){
			$scope.AbilityForeignLanguage.splice($scope.keyIndexAbilityLanguageObjCache,1);
			$('#ModalConfirmAbilityLanguage').modal('hide');
		}else{
			if(
				$("#readingLevel_" + keyIndex).val() != "" ||
				$("#writingLevel_" + keyIndex).val() != "" ||
				$("#speakingLevel_" + keyIndex).val() != "" ||
				$("#listeningLevel_" + keyIndex).val() != "" ||
				$("#language_" + keyIndex).val() != "" 

			){
				$(".btn-confrim-ok").addClass("display-none");
				$("#btnRemoveWorkHistory").removeClass("display-none");
				$('#ModalConfirmAbilityLanguage').modal('show');
				$scope.keyIndexAbilityLanguageObjCache	=	keyIndex;
			}else{
				$scope.AbilityForeignLanguage.splice(keyIndex,1); 
			}
		}    
	};
	
	$scope.notificationValidation = function(){
			$("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
			$("#jqx-notification").jqxNotification();
			$('#jqx-notification').jqxNotification({position: positionNotify,template: "warning" });
			$('#jqx-notification').html("សូមបំពេញទិន្នន័យអោយបានគ្រប់គ្រាន់");
			$("#jqx-notification").jqxNotification("open");
	}
	
});