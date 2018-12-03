app.controller("backgroundStaffGovInfoController", function ($scope,$interval,$http,$filter,$window,$location) {
	$scope.saveGeneralKnowledge = function(url){
		$("#general-knowledge .jqx-validator-error-element").removeClass("jqx-validator-error-element");
		var count = 0;
		/* validate កម្រិតរប្បធម៌ទូទៅ fields */
		if($("#generalLevel").val() == ""){
			$("#div_generalLevel").addClass("jqx-validator-error-element");
			count = count + 1;
		} 
		if($("#generalPlace").val() == ""){
			$("#generalPlace").addClass("jqx-validator-error-element");
			count = count + 1;
		} 
		if($("#generalCertificate").val() == ""){
			$("#div_generalCertificate").addClass("jqx-validator-error-element");
			count = count + 1;
		} 
		if($("#start-date-value_g").val() == ""){
			$("#divStartDate_g").addClass("jqx-validator-error-element");
			count = count + 1;
		} 
		if($("#end-date-value_g").val() == ""){
			$("#divEndDate_g").addClass("jqx-validator-error-element");
			count = count + 1;
		} 
		/* validate កម្រិតសញ្ញាបត្រ/ជំនាញឯកទេស   fields */
		if($("#skillLevel_0").val() == ""){
			$("#skillLevel_0").addClass("jqx-validator-error-element");
			count = count + 1;
		} 
		if($("#skillPlace_0").val() == ""){
			$("#skillPlace_0").addClass("jqx-validator-error-element");
			count = count + 1;
		} 
		if($("#skillCertificate_0").val() == ""){
			$("#skillCertificate_0").addClass("jqx-validator-error-element");
			count = count + 1;
		} 
		if($("#start-date-value_sk_0").val() == ""){
			$("#divStartDate_sk_0").addClass("jqx-validator-error-element");
			count = count + 1;
		}
		if($("#end-date-value_sk_0").val() == ""){
			$("#divEndDate_sk_0").addClass("jqx-validator-error-element");
			count = count + 1;
		} 
		if(count > 0){
			$scope.notificationValidation();
			return;
		}
		/* កម្រិតរប្បធម៌ទូទៅ */
		$scope.knowledge_g['LEVEL']	= $('#generalLevel').val();
		$scope.knowledge_g['GRADUATION_MAJOR'] = $('#generalCertificate').val();
		$scope.knowledge_g['Q_START_DATE'] = $("#start-date-value_g").val();
		$scope.knowledge_g['Q_END_DATE']   = $("#end-date-value_g").val();
		/*  កម្រិតសញ្ញាបត្រ/ជំនាញឯកទេស  */
		angular.forEach($scope.knowledge_sk, function(value, key){
			$scope.knowledge_sk[key]['LEVEL'] = $("#skillLevel_" + key).val();
			$scope.knowledge_sk[key]['PLACE'] = $("#skillPlace_" + key).val();
			$scope.knowledge_sk[key]['GRADUATION_MAJOR'] = $("#skillCertificate_" + key).val();
			$scope.knowledge_sk[key]['Q_START_DATE'] = $("#start-date-value_sk_" + key).val();
			$scope.knowledge_sk[key]['Q_END_DATE'] = $("#end-date-value_sk_" + key).val();
		});
		/* វគ្គបណ្ដុះបណ្ដាលវិជ្ជាជីវៈ (ក្រោម ១២ ខែ) */
		angular.forEach($scope.knowledge_un, function(value, key){
			$scope.knowledge_un[key]['LEVEL'] = $("#studyCourseLevel_" + key).val();
			$scope.knowledge_un[key]['PLACE'] = $("#studyCoursePlace_" + key).val();
			$scope.knowledge_un[key]['GRADUATION_MAJOR'] = $("#studyCourseCertificate_" + key).val();
			$scope.knowledge_un[key]['Q_START_DATE'] = $("#start-date-value_un_" + key).val();
			$scope.knowledge_un[key]['Q_END_DATE'] = $("#end-date-value_un_" + key).val();
		});
		var data = {
			objectKnowledgeOne: $scope.knowledge_g,
		    objectKnowledgeTow: $scope.knowledge_sk,
			objectKnowledgeThree: $scope.knowledge_un,
		};
        $http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/general-knowledge',
            dataType: "json",
            data:{"data":data}
        }).success(function(response) {
			if(angular.isUndefined(url) == false){
				$location.path(url);
			} else {
				$("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
				if(response.code == 1){
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({position: 'top-right',template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* sumarryDataGeneralKnowledge */
					$scope.sumarryDataGeneralKnowledge();
					/* End sumarryDataGeneralKnowledge */
				}
				addClassActiveMenu('menu-5');
			}
        });
    };
	
	$scope.getGeneralKnowledgeById = function(callback){
		loadingWaiting();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/get-general-knowledge-by-id',
            dataType: "json",
            data:{"_token":_token}
        }).success(function(response) {
			callback(response);
        });
	}
	
	$scope.getGeneralKnowledgeById(function(data){
        $scope.knowledge_sk = data[2];
		$scope.knowledge_un = data[3] != undefined ? data[3] : [{}];
		$scope.knowledge_g = {
			"LEVEL": data[1] != undefined ? data[1].LEVEL : null,
			"PLACE": data[1] != undefined ? data[1].PLACE : null,
			"GRADUATION_MAJOR" : data[1] != undefined ? data[1].GRADUATION_MAJOR : null,
			"Q_END_DATE" : data[1] != undefined ? $("#start-date-value_g").val(data[1].Q_START_DATE) : null,
			"Q_START_DATE"   : data[1] != undefined ? $("#end-date-value_g").val(data[1].Q_END_DATE) : null,
		};
		/*   កម្រិតសញ្ញាបត្រ/ជំនាញឯកទេស   */
		if(($scope.knowledge_sk).length <= 0){
			$scope.knowledge_sk	= [{}];
		}
		/*    វគ្គបណ្ដុះបណ្ដាលវិជ្ជាជីវៈ (ក្រោម ១២ ខែ)    */
		if(($scope.knowledge_un).length <= 0){
			$scope.knowledge_un	= [{}];
		}
		var dateStartValue = [];
		var dateEndValue = [];
		setTimeout(function(){
			var url = $location.url();
		    if(url == "/general-knowledge" || "/all-form"){
				/*   កម្រិតរប្បធម៌ទូទៅ   */
				var degree_g = data[1] != undefined ? data[1].LEVEL : '';
				initDropDownList(jqxTheme,185,35, '#div_generalLevel', angular.fromJson($("#listUnderDegreeData").text()), 'text', 'value', false, '', '0', "#generalLevel","",200,degree_g);
				$("#generalLevel").val(degree_g);
				var skill_g = data[1] != undefined ? data[1].GRADUATION_MAJOR : '';
				initDropDownList(jqxTheme,185,35, '#div_generalCertificate', angular.fromJson($("#listUnderSkillData").text()), 'text', 'value', false, '', '0', "#generalCertificate","",200,skill_g);
				$("#generalCertificate").val(skill_g);
				
				var startData_g = $('#start-date-value_g').val() != null ? $('#start-date-value_g').val():null;
				getJqxCalendar('divStartDate_g','start-date-value_g','180px','35px','កាលបរិច្ឆេទចាប់ផ្តើម',startData_g);
				if(startData_g != null){
				   if(startData_g == "") {
					  getJqxCalendar('divEndDate_g','end-date-value_g','180px','35px','កាលបរិច្ឆេទបញ្ចប់','');
				      $("#divEndDate_g").jqxDateTimeInput({ disabled: true });
				   } else {
					   var endData_g = $('#end-date-value_g').val() != null ? $('#end-date-value_g').val():null;
					   getJqxCalendar('divEndDate_g','end-date-value_g','180px','35px','កាលបរិច្ឆេទបញ្ចប់',endData_g);
				   }
				} 
				/* validate between start date and end date general knowlegde */
				$('#divStartDate_g').on('change',function(){
					var knowledgeStart = $('#start-date-value_g').val();
					if(knowledgeStart != null){
						if(knowledgeStart == ""){
							var knowledgeStartDate =  knowledgeStart.split("-");
							$('#divEndDate_g').jqxDateTimeInput('min',new Date(parseInt(knowledgeStartDate[0])+3, 0, 1));
							$('#divEndDate_g').jqxDateTimeInput('setDate', new Date(parseInt(knowledgeStartDate[0])+3, 0, 1));
							$("#divEndDate_g").jqxDateTimeInput({ disabled: true });
						} else {
							$("#divEndDate_g").jqxDateTimeInput({ disabled: false });
							var knowledgeStartDate =  knowledgeStart.split("-");
							$('#divEndDate_g').jqxDateTimeInput('min',new Date(parseInt(knowledgeStartDate[0])+3, 0, 1));
							$('#divEndDate_g').jqxDateTimeInput('setDate', new Date(parseInt(knowledgeStartDate[0])+3, 0, 1));
						}
					}
				});
			    /*   កម្រិតសញ្ញាបត្រ/ជំនាញឯកទេស   */
				angular.forEach($scope.knowledge_sk, function(value, key){
					var degree_g = value.LEVEL != undefined ? value.LEVEL : '';
					initDropDownList(jqxTheme,185,35, '#div_skillLevel_' + key, angular.fromJson($("#listDegreeData").text()), 'text', 'value', false, '', '0', "#skillLevel_" + key,"",200,degree_g);
					$("#skillLevel_"+key).val(degree_g);
					var skill_g = value.GRADUATION_MAJOR != undefined ? value.GRADUATION_MAJOR : '';
					initDropDownList(jqxTheme,185,35, '#div_skillCertificate_' + key, angular.fromJson($("#listSkillData").text()), 'text', 'value', false, '', '0', "#skillCertificate_" + key,"",200,skill_g);
					$("#skillCertificate_"+key).val(skill_g);
					
					dateStartValue[key] = value.Q_START_DATE == '0000-00-00' ? '' : value.Q_START_DATE;
					getJqxCalendar('divStartDate_sk_' + key,'start-date-value_sk_' + key,'180px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',dateStartValue[key]);
					if(dateStartValue[key] != undefined){
						dateEndValue[key] = value.Q_END_DATE == '0000-00-00' ? '' : value.Q_END_DATE;
						getJqxCalendar('divEndDate_sk_' + key,'end-date-value_sk_' + key,'180px','32px','កាលបរិច្ឆេទបញ្ចប់',dateEndValue[key]);
					} else {
						getJqxCalendar('divEndDate_sk_' + key,'end-date-value_sk_' + key,'180px','32px','កាលបរិច្ឆេទបញ្ចប់','');
						$('#divEndDate_sk_' + key).jqxDateTimeInput({ disabled: true });
					}

					$("#start-date-value_sk_" + key).val(value.Q_START_DATE);
					$("#end-date-value_sk_" + key).val(value.Q_END_DATE);
					$("#skillLevel_" + key).val(value.LEVEL);
					$("#skillPlace_" + key).val(value.PLACE);
					$("#skillCertificate_" + key).val(value.GRADUATION_MAJOR);
					/* validate between start date and end date certificate */
					$('#divStartDate_sk_' + key).on('change',function(){
						var skillStart = $('#start-date-value_sk_' + key).val();
						if(skillStart != null){
							if(skillStart == ""){
								$('#divEndDate_sk_' + key).jqxDateTimeInput({ disabled: true });
								var skillStartDate =  skillStart.split("-");
								$('#divEndDate_sk_' + key).jqxDateTimeInput('min',new Date(parseInt(skillStartDate[0])+3, 0, 1));
								$('#divEndDate_sk_' + key).jqxDateTimeInput('setDate', new Date(parseInt(skillStartDate[0])+3, 0, 1));
							} else {
								$('#divEndDate_sk_' + key).jqxDateTimeInput({ disabled: false });
								var skillStartDate =  skillStart.split("-");
								$('#divEndDate_sk_' + key).jqxDateTimeInput('min',new Date(parseInt(skillStartDate[0])+3, 0, 1));
								$('#divEndDate_sk_' + key).jqxDateTimeInput('setDate', new Date(parseInt(skillStartDate[0])+3, 0, 1));
							}
						}
					});
				});
				/*    វគ្គបណ្ដុះបណ្ដាលវិជ្ជាជីវៈ (ក្រោម ១២ ខែ)    */
				angular.forEach($scope.knowledge_un, function(value, key){
					dateStartValue[key] = value.Q_START_DATE == '0000-00-00' ? '' : value.Q_START_DATE;
					getJqxCalendar('divStartDate_un_' + key,'start-date-value_un_' + key,'180px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',dateStartValue[key]);
					if(dateStartValue[key] != undefined){
						dateEndValue[key] = value.Q_END_DATE == '0000-00-00' ? '' : value.Q_END_DATE;
						getJqxCalendar('divEndDate_un_' + key,'end-date-value_un_' + key,'180px','32px','កាលបរិច្ឆេទបញ្ចប់',dateEndValue[key]);
					} else {
						getJqxCalendar('divEndDate_un_' + key,'end-date-value_un_' + key,'180px','32px','កាលបរិច្ឆេទបញ្ចប់','');
						$('#divEndDate_un_' + key).jqxDateTimeInput({ disabled: true });
					}
					$("#start-date-value_un_" + key).val(value.Q_START_DATE);
					$("#end-date-value_un_" + key).val(value.Q_END_DATE);
					$("#studyCourseLevel_" + key).val(value.LEVEL);
					$("#studyCoursePlace_" + key).val(value.PLACE);
					$("#studyCourseCertificate_" + key).val(value.GRADUATION_MAJOR);
					/* validate between start date and end date study course under 12 months*/
					$('#divStartDate_un_' + key).on('change',function(){
						var underStudyCourseStart = $('#start-date-value_un_' + key).val();
						if(underStudyCourseStart != null){
							if(underStudyCourseStart == "") {
								var underStudyCourseStartDate =  underStudyCourseStart.split("-");
								$('#divEndDate_un_' + key).jqxDateTimeInput('min',new Date(underStudyCourseStartDate[0], parseInt(underStudyCourseStartDate[1]) - 1, parseInt(underStudyCourseStartDate[2]) + 1));
								$('#divEndDate_un_' + key).jqxDateTimeInput('setDate', new Date(underStudyCourseStartDate[0], parseInt(underStudyCourseStartDate[1]) - 1, parseInt(underStudyCourseStartDate[2]) + 1));
								$('#divEndDate_un_' + key).jqxDateTimeInput({ disabled: true });
						    } else {
								$('#divEndDate_un_' + key).jqxDateTimeInput({ disabled: false });
								var underStudyCourseStartDate =  underStudyCourseStart.split("-");
							    $('#divEndDate_un_' + key).jqxDateTimeInput('min',new Date(underStudyCourseStartDate[0], parseInt(underStudyCourseStartDate[1]) - 1, parseInt(underStudyCourseStartDate[2]) + 1));
								$('#divEndDate_un_' + key).jqxDateTimeInput('setDate', new Date(underStudyCourseStartDate[0], parseInt(underStudyCourseStartDate[1]) - 1, parseInt(underStudyCourseStartDate[2]) + 1));
							}
						}
					});
				});
			}
			
			/* sumarryDataGeneralKnowledge */
			$scope.sumarryDataGeneralKnowledge();
			/* End sumarryDataGeneralKnowledge */
			
		}, 2000);
		setTimeout(function(){
			endLoadingWaiting();
		},2000);
	});
	
	$scope.sumarryDataGeneralKnowledge = function(){
		/* SUMMERY DATA */
		$("#SUMMARY_KNOWLEDGE_G_LEVEL").text($scope.knowledge_g.LEVEL ? $scope.knowledge_g.LEVEL : '');
		$("#SUMMARY_KNOWLEDGE_G_PLACE").text($scope.knowledge_g.PLACE ? $scope.knowledge_g.PLACE : '');
		$("#SUMMARY_KNOWLEDGE_G_GRADUATION_MAJOR").text($scope.knowledge_g.GRADUATION_MAJOR ? $scope.knowledge_g.GRADUATION_MAJOR : '');
		$("#SUMMARY_KNOWLEDGE_G_START_DATA").text($("#start-date-value_g").val());
		$("#SUMMARY_KNOWLEDGE_G_END_DATA").text($("#end-date-value_g").val());
		/* SUMMERY DATA END*/
	}
	
	$scope.removeMoreSkill	=	function(keyIndex){
		$scope.knowledge_sk.splice(keyIndex,1);    
	}
	
	$scope.addMoreSkill	=	function(){
		$scope.knowledge_sk.push({});
		var dateStartValue = [];
		var dateEndValue = [];
		setTimeout(function(){
			angular.forEach($scope.knowledge_sk, function(value, key){
				var degree_g = value.LEVEL != undefined ? value.LEVEL : '';
				initDropDownList(jqxTheme,185,35, '#div_skillLevel_' + key, angular.fromJson($("#listDegreeData").text()), 'text', 'value', false, '', '0', "#skillLevel_" + key,"",200,degree_g);
				$("#skillLevel_"+key).val(degree_g);
				var skill_g = value.GRADUATION_MAJOR != undefined ? value.GRADUATION_MAJOR : '';
				initDropDownList(jqxTheme,185,35, '#div_skillCertificate_' + key, angular.fromJson($("#listSkillData").text()), 'text', 'value', false, '', '0', "#skillCertificate_" + key,"",200,skill_g);
				$("#skillCertificate_"+key).val(skill_g);
				
				dateStartValue[key] = value.Q_START_DATE == '0000-00-00' ? '' : value.Q_START_DATE;
				dateEndValue[key] = value.Q_END_DATE == '0000-00-00' ? '' : value.Q_END_DATE;
				getJqxCalendar('divStartDate_sk_' + key,'start-date-value_sk_' + key,'180px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',dateStartValue[key]);
				getJqxCalendar('divEndDate_sk_' + key,'end-date-value_sk_' + key,'180px','32px','កាលបរិច្ឆេទបញ្ចប់',dateEndValue[key]);
				$("#start-date-value_sk_" + key).val(value.Q_START_DATE);
				$("#end-date-value_sk_" + key).val(value.Q_END_DATE);
				/* validate between start date and end date certificate */
				$('#divStartDate_sk_' + key).on('change',function(){
					var skillStart = $('#start-date-value_sk_' + key).val();
					if(skillStart != null){
						if(skillStart == ""){
							$('#divEndDate_sk_' + key).jqxDateTimeInput({ disabled: true });
							var skillStartDate =  skillStart.split("-");
							$('#divEndDate_sk_' + key).jqxDateTimeInput('min',new Date(parseInt(skillStartDate[0])+3, 0, 1));
							$('#divEndDate_sk_' + key).jqxDateTimeInput('setDate', new Date(parseInt(skillStartDate[0])+3, 0, 1));
						} else {
							$('#divEndDate_sk_' + key).jqxDateTimeInput({ disabled: false });
							var skillStartDate =  skillStart.split("-");
							$('#divEndDate_sk_' + key).jqxDateTimeInput('min',new Date(parseInt(skillStartDate[0])+3, 0, 1));
							$('#divEndDate_sk_' + key).jqxDateTimeInput('setDate', new Date(parseInt(skillStartDate[0])+3, 0, 1));
						}
					}
				});
			});
		}, 200);
	}
	
	$scope.removeMoreCertificate	=	function(keyIndex){
		$scope.knowledge_un.splice(keyIndex,1);    
	}
	
	$scope.addMoreCertificate	=	function(){
		$scope.knowledge_un.push({});
		var dateStartValue = [];
		var dateEndValue = [];
		setTimeout(function(){
			angular.forEach($scope.knowledge_un, function(value, key){
				dateStartValue[key] = value.Q_START_DATE == '0000-00-00' ? '' : value.Q_START_DATE;
				dateEndValue[key] = value.Q_END_DATE == '0000-00-00' ? '' : value.Q_END_DATE;
				getJqxCalendar('divStartDate_un_' + key,'start-date-value_un_' + key,'180px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',dateStartValue[key]);
				getJqxCalendar('divEndDate_un_' + key,'end-date-value_un_' + key,'180px','32px','កាលបរិច្ឆេទបញ្ចប់',dateEndValue[key]);
				$("#start-date-value_un_" + key).val(value.Q_START_DATE);
				$("#end-date-value_un_" + key).val(value.Q_END_DATE);
				/* validate between start date and end date study course under 12 months*/
				$('#divStartDate_un_' + key).on('change',function(){
					var underStudyCourseStart = $('#start-date-value_un_' + key).val();
					if(underStudyCourseStart != null){
						if(underStudyCourseStart == "") {
							var underStudyCourseStartDate =  underStudyCourseStart.split("-");
							$('#divEndDate_un_' + key).jqxDateTimeInput('min',new Date(underStudyCourseStartDate[0], parseInt(underStudyCourseStartDate[1]) - 1, parseInt(underStudyCourseStartDate[2]) + 1));
							$('#divEndDate_un_' + key).jqxDateTimeInput('setDate', new Date(underStudyCourseStartDate[0], parseInt(underStudyCourseStartDate[1]) - 1, parseInt(underStudyCourseStartDate[2]) + 1));
							$('#divEndDate_un_' + key).jqxDateTimeInput({ disabled: true });
						} else {
							$('#divEndDate_un_' + key).jqxDateTimeInput({ disabled: false });
							var underStudyCourseStartDate =  underStudyCourseStart.split("-");
							$('#divEndDate_un_' + key).jqxDateTimeInput('min',new Date(underStudyCourseStartDate[0], parseInt(underStudyCourseStartDate[1]) - 1, parseInt(underStudyCourseStartDate[2]) + 1));
							$('#divEndDate_un_' + key).jqxDateTimeInput('setDate', new Date(underStudyCourseStartDate[0], parseInt(underStudyCourseStartDate[1]) - 1, parseInt(underStudyCourseStartDate[2]) + 1));
						}
					}
				});
			});
		}, 200);
	}
	
	$scope.toObject = function(arr) {
	  var rv = {};
	  if(arr != null){
		for (var i = 0; i < arr.length; ++i)
		rv[i] = arr[i];
	  }
	  return rv;
    }
	
	$scope.getAbilityForeignLanguageById = function(callback){
		loadingWaiting();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/get-ability-foreign-language-by-id',
            dataType: "json",
            data:{"_token":_token}
        }).success(function(response) {
			callback(response);
        });
	}
	
	$scope.getAbilityForeignLanguageById(function(data){
		
		var dataDefault	=	[
			{language : "", readingLevel : "", writingLevel : "", speakingLevel : "", listeningLevel : ""}
		];

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
					initDropDownList(jqxTheme,180,35, '#div_language_'+ key, angular.fromJson($("#listlanguageJson").text()), 'text', 'value', false, '', '0', "#language_"+ key,"",200,language[key]);
					$("#language_" + key).val(language[key]);
					//
					reading[key] = value.RED;
					initDropDownList(jqxTheme,180,35, '#div_reading_level_'+ key, angular.fromJson($("#listTypeQualificationsJson").text()), 'text', 'value', false, '', '0', "#readingLevel_"+ key,"",200,reading[key]);
					$("#readingLevel_" + key).val(reading[key]);
					// 
					writing[key] = value.WRITE;
					initDropDownList(jqxTheme,180,35, '#div_writing_level_'+ key, angular.fromJson($("#listWritingJson").text()), 'text', 'value', false, '', '0', "#writingLevel_"+ key,"",200,writing[key]);
					$("#writingLevel_" + key).val(writing[key]);
					// 
					speaking[key] = value.SPEAK;
					initDropDownList(jqxTheme,180,35, '#div_speaking_level_'+ key, angular.fromJson($("#listSpeakingJson").text()), 'text', 'value', false, '', '0', "#speakingLevel_"+key,"",200,speaking[key]);
					$("#speakingLevel_" + key).val(speaking[key]);
					//
					listening[key] = value.LISTEN;	
					initDropDownList(jqxTheme,180,35, '#div_listening_level_'+key, angular.fromJson($("#listListeningJson").text()), 'text', 'value', false, '', '0', "#listeningLevel_"+key,"",200,listening[key]);
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
	}
	
	$scope.notificationValidation = function(){
			$("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
			$("#jqx-notification").jqxNotification();
			$('#jqx-notification').jqxNotification({position: 'top-right',template: "warning" });
			$('#jqx-notification').html("សូមបំពេញទិន្នន័យអោយបានគ្រប់គ្រាន់");
			$("#jqx-notification").jqxNotification("open");
	}
	
	$scope.saveAbilityLanguage = function(url){
		angular.forEach($scope.AbilityForeignLanguage, function(value, key){
			$scope.AbilityForeignLanguage[key]['RED'] = $("#readingLevel_" + key).val();
			$scope.AbilityForeignLanguage[key]['WRITE'] = $("#writingLevel_" + key).val();
			$scope.AbilityForeignLanguage[key]['SPEAK'] = $("#speakingLevel_" + key).val();
			$scope.AbilityForeignLanguage[key]['LISTEN'] = $("#listeningLevel_" + key).val();
			$scope.AbilityForeignLanguage[key]['LANGUAGE'] = $("#language_" + key).val();
		});	
		var data = {
			"0":$scope.AbilityForeignLanguage,
			
		};
		  // console.log(data);
		  // return;
        $http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/ability-foreign',
            dataType: "json",
            data:{"data":data}
        }).success(function(response) {
			if(angular.isUndefined(url) == false){
				$location.path(url);
			} else {
			    $("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
				if(response.code == 1){
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({position: 'top-right',template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* SUMMERY FUNCTION */
					$scope.sumarryDataAbilityForeignLanguage();
					/* SUMMERY FUNCTION END */
				}
				addClassActiveMenu('menu-6');	
			}
        });
	}

	$scope.addMoreAbilityLanguage	=	function(){
		$scope.AbilityForeignLanguage.push({});
		var lastIndex	=	($scope.AbilityForeignLanguage).length - 1;
		setTimeout(function(){
				
				language = $scope.AbilityForeignLanguage[lastIndex].language;
				initDropDownList(jqxTheme,180,35, '#div_language_'+ lastIndex, angular.fromJson($("#listlanguageJson").text()), 'text', 'value', false, '', '0', "#language_"+ lastIndex,"",200,language);
				$("#language_" + lastIndex).val(language);

				// 
				reading = $scope.AbilityForeignLanguage[lastIndex].readingLevel;
				initDropDownList(jqxTheme,180,35, '#div_reading_level_'+ lastIndex, angular.fromJson($("#listTypeQualificationsJson").text()), 'text', 'value', false, '', '0', "#readingLevel_"+ lastIndex,"",200,reading);
				$("#readingLevel_" + lastIndex).val(reading);
				// 
				writing = $scope.AbilityForeignLanguage[lastIndex].writingLevel;
				initDropDownList(jqxTheme,180,35, '#div_writing_level_'+ lastIndex, angular.fromJson($("#listWritingJson").text()), 'text', 'value', false, '', '0', "#writingLevel_"+ lastIndex,"",200,writing);
				$("#writingLevel_" + lastIndex).val(writing);
				// 
				speaking = $scope.AbilityForeignLanguage[lastIndex].speakingLevel;
				initDropDownList(jqxTheme,180,35, '#div_speaking_level_'+ lastIndex, angular.fromJson($("#listSpeakingJson").text()), 'text', 'value', false, '', '0', "#speakingLevel_"+lastIndex,"",200,speaking);
				$("#speakingLevel_" + lastIndex).val(speaking);
				//
				listening = $scope.AbilityForeignLanguage[lastIndex].listeningLevel;	
				initDropDownList(jqxTheme,180,35, '#div_listening_level_'+lastIndex, angular.fromJson($("#listListeningJson").text()), 'text', 'value', false, '', '0', "#listeningLevel_"+lastIndex,"",200,listening);
				$("#speakingLevel_" + lastIndex).val(listening);
			
		}, 200);
	}
	
	$scope.removeAbilityLanguage	=	function(keyIndex){

		if(angular.isUndefined(keyIndex) == true){
			$scope.AbilityForeignLanguage.splice($scope.keyIndexAbilityLanguageObjCache,1);
			$('#ModalConfirm').modal('hide');
		}else{
			if(
				$("#readingLevel_" + keyIndex).val() != "" ||
				$("#writingLevel_" + keyIndex).val() != "" ||
				$("#speakingLevel_" + keyIndex).val() != "" ||
				$("#listeningLevel_" + keyIndex).val() != "" 

			){
				$(".btn-confrim-ok").addClass("display-none");
				$("#btnRemoveWorkHistory").removeClass("display-none");
				$('#ModalConfirm').modal('show');
				$scope.keyIndexAbilityLanguageObjCache	=	keyIndex;
			}else{
				$scope.AbilityForeignLanguage.splice(keyIndex,1); 
			}
		}    
	}
	
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
				$("#fatherNameKh").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if($("#fatherNameEn").val() == ""){
				$("#fatherNameEn").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if($("#father-date-value").val() == ""){
				$("#fatherBD").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if($("#fatherNationality").val() == ""){
				$("#fatherNationality").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if(fDieChecked == false){
			   	if($("#fatherAddress").val() == ""){
				$("#fatherAddress").addClass("jqx-validator-error-element");
				count = count + 1;
				}
				if($("#fatherCareer").val() == ""){
					$("#fatherCareer").addClass("jqx-validator-error-element");
					count = count + 1;
				} 
			}
			/* validate mother fields */
			if($("#motherNameKh").val() == ""){
				$("#motherNameKh").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if($("#motherNameEn").val() == ""){
				$("#motherNameEn").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if($("#mother-date-value").val() == ""){
				$("#motherBD").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if($("#motherNationality").val() == ""){
				$("#motherNationality").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if(mDieChecked == false){
			    if($("#motherAddress").val() == ""){
				$("#motherAddress").addClass("jqx-validator-error-element");
				count = count + 1;
				} 
				if($("#motherCareer").val() == ""){
					$("#motherCareer").addClass("jqx-validator-error-element");
					count = count + 1;
				} 
			}
			if(count > 0){
				$scope.notificationValidation();
			    return;
			}
		}
		var spLiveChecked = $("#spStatusLive").is(":checked");
		var spDieChecked = $("#spStatusDie").is(":checked");
		if(spLiveChecked || spDieChecked){
			$("#family-situation .jqx-validator-error-element").removeClass("jqx-validator-error-element");
			var count = 0;
			if($("#spNameKh").val() == ""){
				$("#spNameKh").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if($("#spNameEn").val() == ""){
				$("#spNameEn").addClass("jqx-validator-error-element");
				count = count + 1;
			}
			if($("#federation-date-value").val() == ""){
				$("#federationBD").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if($("#spNationality").val() == ""){
				$("#spNationality").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if(spDieChecked == false){
			    if($("#spAddress").val() == ""){
				$("#spAddress").addClass("jqx-validator-error-element");
				count = count + 1;
				} 
				if($("#spCareer").val() == ""){
					$("#spCareer").addClass("jqx-validator-error-element");
					count = count + 1;
				}
			}
			if(count > 0){
				$scope.notificationValidation();
			    return;
			}
		}
		var fChildExistChecked = $("#fChildrenIdExist").is(":checked");
		if(fChildExistChecked){
			$("#family-situation .jqx-validator-error-element").removeClass("jqx-validator-error-element");
			var count = 0;
			if($("#childrenNameKh_0").val() == ""){
				$("#childrenNameKh_0").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if($("#childrenNameEn_0").val() == ""){
				$("#childrenNameEn_0").addClass("jqx-validator-error-element");
				count = count + 1;
			}
			if($("#children-date-value_0").val() == ""){
				$("#childrenBD_0").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if($("#childrenCareer_0").val() == ""){
				$("#childrenCareer_0").addClass("jqx-validator-error-element");
				count = count + 1;
			} 
			if(count > 0){
				$scope.notificationValidation();
			    return;
			}
		} else {
			$scope.family_c = {};
		}
		$scope.familyDate = {
			"FATHER_DOB" : $("#father-date-value").val(),
			"MOTHER_DOB" : $("#mother-date-value").val(),
			"SPOUSE_DOB" : $("#federation-date-value").val(),
		};
		angular.forEach($scope.family_sib, function(value, key){
			$scope.family_sib[key]['RELATIVES_NAME_KH'] = $("#siblingNameKh_" + key).val();
			$scope.family_sib[key]['RELATIVES_NAME_EN'] = $("#siblingNameEn_" + key).val();
			$scope.family_sib[key]['RELATIVES_NAME_GENDER'] = $("#siblingFemal_" + key).is(":checked") ? $("#siblingFemal_" + key).val() : $("#siblingMal_" + key).is(":checked") ? $("#siblingMal_" + key).val() : "";
			$scope.family_sib[key]['RELATIVES_NAME_DOB'] = $("#sibling-date-value_" + key).val();
			$scope.family_sib[key]['RELATIVES_NAME_JOB'] = $("#siblingCareer_" + key).val();
		});
		
		angular.forEach($scope.family_c, function(value, key){
			$scope.family_c[key]['CHILDRENS_NAME_KH'] = $("#childrenNameKh_" + key).val();
			$scope.family_c[key]['CHILDRENS_NAME_EN'] = $("#childrenNameEn_" + key).val();
			$scope.family_c[key]['CHILDRENS_NAME_GENDER'] = $("#childrenFemal_" + key).is(":checked") ? $("#childrenFemal_" + key).val() : $("#childrenMal_" + key).is(":checked") ? $("#childrenMal_" + key).val() : "";
			$scope.family_c[key]['CHILDRENS_NAME_DOB'] = $("#children-date-value_" + key).val();
			$scope.family_c[key]['CHILDRENS_NAME_JOB'] = $("#childrenCareer_" + key).val();
			$scope.family_c[key]['CHILDRENS_NAME_SPONSOR'] = $("#childrenExistSpornsor_" + key).is(":checked") ? $("#childrenExistSpornsor_" + key).val() : $("#childrenNoneSpornsor_" + key).is(":checked") ? $("#childrenNoneSpornsor_" + key).val() : "";
		});
		
		var data = {
			objectFamilyDate: $scope.familyDate,
			objectFamily: $scope.family,
			objectFamilySibling: $scope.toObject($scope.family_sib),
			objectFamilyChildren: $scope.toObject($scope.family_c),
			objectPhoneNumber: $scope.family_p = {
				"0" : $scope.family_p_1.SPOUSE_PHONE_NUMBER != undefined ? $scope.family_p_1.SPOUSE_PHONE_NUMBER : {},
				"1" : $scope.family_p_2.SPOUSE_PHONE_NUMBER != undefined ? $scope.family_p_2.SPOUSE_PHONE_NUMBER : {},
				"2" : $scope.family_p_3.SPOUSE_PHONE_NUMBER != undefined ? $scope.family_p_3.SPOUSE_PHONE_NUMBER : {},
			},
		};
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/family-situations',
            dataType: "json",
            data:{"data":data}
        }).success(function(response) {
			if(angular.isUndefined(url) == false){
			    
			} else {
				$("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
				if(response.code == 1){
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({position: 'top-right',template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* SUMMERY FUNCTION */
					$scope.sumarryDataFamilySituations();
					/* SUMMERY FUNCTION END */
				}
				addClassActiveMenu('menu-7');
			}
        });
	}
	
	$scope.getFamilySituationsById = function(callback){
		loadingWaiting();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/get-family-situations-by-id',
            dataType: "json",
            data:{"_token":_token}
        }).success(function(response) {
			callback(response);
        });
	}
	
	$scope.getFamilySituationsById(function(data){
		$scope.family_sib = data[0].sibling;
		$scope.family_c = data[0].children;
		var url = $location.url();
		if(url == "/family-situations" || url == "/all-form"){
			if(data.userStatus.MARRIED == 1){
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
		
				/* children information */
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

				
			} else {
				/* Children Infomation */
				$("#fChildrenIdExist").prop('checked', true);
				$('.childenSpornsor').prop('checked',true);
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
		
		var phone = $scope.toObject(data.phone);
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
			"SPOUSE_LIVE": data.userStatus.MARRIED == 1 ? data[0].userData.SPOUSE_LIVE : "រស់",
			"SPOUSE_NAME_EN": data[0].userData.SPOUSE_NAME_EN,
			"SPOUSE_NAME_KH": data[0].userData.SPOUSE_NAME_KH,
			"SPOUSE_NATIONALITY_1": data[0].userData.SPOUSE_NATIONALITY_1,
			"SPOUSE_NATIONALITY_2": data[0].userData.SPOUSE_NATIONALITY_2,
			"SPOUSE_PHONE_NUMBER": data[0].userData.SPOUSE_PHONE_NUMBER != undefined ? data[0].userData.SPOUSE_PHONE_NUMBER : '',
			"SPOUSE_POB": data[0].userData.SPOUSE_POB,
			"SPOUSE_SPONSOR": data.userStatus.MARRIED == 1 ? data[0].userData.SPOUSE_SPONSOR : "គ្មាន",
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
					getJqxCalendar('siblingBD_' + key,'sibling-date-value_' + key,'180px','32px','ថ្ងៃខែឆ្នាំកំណើត',dateSibling[key]);
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
					getJqxCalendar('childrenBD_' + key,'children-date-value_' + key,'180px','32px','ថ្ងៃខែឆ្នាំកំណើត',dateChildren[key]);
					$("#children-date-value_" + key).val(value.CHILDRENS_NAME_DOB);
					$("#childrenNameEn_" + key).val(value.CHILDRENS_NAME_EN);
					$("#childrenNameKh_" + key).val(value.CHILDRENS_NAME_KH);
					$("#childrenCareer_" + key).val(value.CHILDRENS_NAME_JOB);
				});
			}
			
			/* SUMMERY FUNCTION */
			$scope.sumarryDataFamilySituations();
			/* SUMMERY FUNCTION END */
			
		}, 2000);
		
		$scope.family_p_1 = {
			"SPOUSE_PHONE_NUMBER" : phone[0] != '' ? phone[0] : '',
		};
		$scope.family_p_2 = {
			"SPOUSE_PHONE_NUMBER" : phone[1] != '' ? phone[1] : '',
		};
		$scope.family_p_3 = {
			"SPOUSE_PHONE_NUMBER" : phone[2] != '' ? phone[2] : '',
		};
		if($location.url() == "/family-situations" || url == "/all-form"){
			/* father date of birth */
			var fDate = $('#father-date-value').val() != null ? $('#father-date-value').val():null;
			getJqxCalendar('fatherBD','father-date-value','200px','35px','ថ្ងៃខែឆ្នាំកំណើត',fDate);
			/* mother date of birth */
			var mDate = $('#mother-date-value').val() != null ? $('#mother-date-value').val():null;
			getJqxCalendar('motherBD','mother-date-value','200px','35px','ថ្ងៃខែឆ្នាំកំណើត',mDate);
			/* federation date of birth */
			var sDate = $('#federation-date-value').val() != null ? $('#federation-date-value').val():null;
			getJqxCalendar('federationBD','federation-date-value','200px','35px','ថ្ងៃខែឆ្នាំកំណើត',sDate);
		}
		setTimeout(function(){
			endLoadingWaiting();
		},2000);
	});
	
	$scope.sumarryDataFamilySituations = function(){
		/* SUMMERY DATA */
		$("#SUMMARY_FATHER_NAME_KH").text($scope.family.FATHER_NAME_KH ? $scope.family.FATHER_NAME_KH : '');
		$("#SUMMARY_FATHER_NAME_EN").text($scope.family.FATHER_NAME_KH ? $scope.family.FATHER_NAME_EN : '');
		$("#SUMMARY_DATE_OF_BIRTH").text($("#father-date-value").val());
		$("#SUMMARY_FATHER_ADDRESS").text($scope.family.FATHER_ADDRESS ? $scope.family.FATHER_ADDRESS : '');
		$("#SUMMARY_FATHER_JOB").text($scope.family.FATHER_JOB ? $scope.family.FATHER_JOB : '');
		/* SUMMERY DATA END*/
	}
	
	$scope.addMoreFamilySibling = function(){
		$scope.family_sib.push({});
		var dateSibling = [];
		setTimeout(function(){
			angular.forEach($scope.family_sib, function(value, key){
				dateSibling[key] = value.RELATIVES_NAME_DOB == '0000-00-00' ? '' : value.RELATIVES_NAME_DOB;
				getJqxCalendar('siblingBD_' + key,'sibling-date-value_' + key,'180px','32px','ថ្ងៃខែឆ្នាំកំណើត',dateSibling[key]);
				$("#sibling-date-value_" + key).val(value.RELATIVES_NAME_DOB);
			});
		}, 200);
	};

	$scope.removeMoreFamilySibling = function(keyIndex){
		$scope.family_sib.splice(keyIndex,1);  
	};
	
	$scope.addMoreFamilyChildren = function(){
		$scope.family_c.push({});
		var dateChildren = [];
		setTimeout(function(){
			angular.forEach($scope.family_c, function(value, key){
				dateChildren[key] = value.CHILDRENS_NAME_DOB == '0000-00-00' ? '' : value.CHILDRENS_NAME_DOB;
				getJqxCalendar('childrenBD_' + key,'children-date-value_' + key,'180px','32px','ថ្ងៃខែឆ្នាំកំណើត',dateChildren[key]);
				$("#children-date-value_" + key).val(value.CHILDRENS_NAME_DOB);
			});
		}, 200);
	};
	
	$scope.removeMoreFamilyChildren = function(keyIndex){
		$scope.family_c.splice(keyIndex,1);  
	};
	
	$scope.disableChildrenTextFields = function(){
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
	};
	
	$scope.enableChildrenTextFields = function(){
		$('#nameKh-red').removeClass("col-black");
		$('#nameKh-red').addClass("col-red");
		$('#nameEn-red').removeClass("col-black");
		$('#nameEn-red').addClass("col-red");
		$('#gender-red').removeClass("col-black");
		$('#gender-red').addClass("col-red");
		$('#dob-red').removeClass("col-black");
		$('#dob-red').addClass("col-red");
		$('#career-red').removeClass("col-black");
		$('#career-red').addClass("col-red");
		$('#spornsor-red').removeClass("col-black");
		$('#spornsor-red').addClass("col-red");
	};
});