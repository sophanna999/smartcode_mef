app.controller("generalKnowledgeController", function ($scope,$interval,$http,$filter,$window,$location) {
	$scope.$on("$locationChangeStart", function() {
		if(defaultRouteAngularJs != '/smart-office'){
			$scope.saveGeneralKnowledge();
		}
	});
	$scope.saveGeneralKnowledge = function(url){
		$("#general-knowledge .jqx-validator-error-element").removeClass("jqx-validator-error-element");
		var count = 0;
		/* validate កម្រិតរប្បធម៌ទូទៅ fields */
		if($("#generalLevel").val() == ""){
			count = count + 1;
		}
		if($("#generalPlace").val() == ""){
			count = count + 1;
		}
		if($("#generalCertificate").val() == ""){
			count = count + 1;
		}

		if($("#start-date-value_g").val() == ""){
			count = count + 1;
		} else if($("#start-date-value_g").val() == "undefined-undefined-"){
			count = count + 1;
		} else {
			count = count;
		}

		if($("#end-date-value_g").val() == ""){
			count = count + 1;
		} else if($("#end-date-value_g").val() == "undefined-undefined-"){
			count = count + 1;
		} else {
			count = count;
		}

		/* validate កម្រិតសញ្ញាបត្រ/ជំនាញឯកទេស   fields */
		if($("#div_skillLevel_0").val() == ""){
			count = count + 1;
		}
		if($("#skillPlace_0").val() == ""){
			count = count + 1;
		}
		if($("#skillCertificate_0").val() == ""){
			count = count + 1;
		}

		if($("#start-date-value_sk_0").val() == ""){
			count = count + 1;
		} else if($("#start-date-value_sk_0").val() == "undefined-undefined-"){
			count = count + 1;
		} else {
			count = count;
		}

		if($("#end-date-value_sk_0").val() == ""){
			count = count + 1;
		} else if($("#end-date-value_sk_0").val() == "undefined-undefined-"){
			count = count + 1;
		} else {
			count = count;
		}

		/* កម្រិតរប្បធម៌ទូទៅ */
		$scope.knowledge_g['LEVEL']	= $('#generalLevel').val();
		$scope.knowledge_g['GRADUATION_MAJOR'] = $('#generalCertificate').val();
		$scope.knowledge_g['Q_START_DATE'] = $("#start-date-value_g").val() != "undefined-undefined-" ? $("#start-date-value_g").val() : "";
		$scope.knowledge_g['Q_END_DATE']   = $("#end-date-value_g").val() != "undefined-undefined-" ? $("#end-date-value_g").val() : "";
		/*  កម្រិតសញ្ញាបត្រ/ជំនាញឯកទេស  */

		angular.forEach($scope.knowledge_sk, function(value, key){
			$scope.knowledge_sk[key]['LEVEL'] = $("input[name="+"div_skillLevel_" + key+"]").val();
			$scope.knowledge_sk[key]['PLACE'] = $("#skillPlace_" + key).val();
			$scope.knowledge_sk[key]['GRADUATION_MAJOR'] = $("input[name="+"div_skillCertificate_" + key+"]").val();
			$scope.knowledge_sk[key]['Q_START_DATE'] = $("#start-date-value_sk_" + key).val() != "undefined-undefined-" ? $("#start-date-value_sk_" + key).val() : "";
			$scope.knowledge_sk[key]['Q_END_DATE'] = $("#end-date-value_sk_" + key).val() != "undefined-undefined-" ? $("#end-date-value_sk_" + key).val() : "";
		});
		/* វគ្គបណ្ដុះបណ្ដាលវិជ្ជាជីវៈ (ក្រោម ១២ ខែ) */
		angular.forEach($scope.knowledge_un, function(value, key){
			$scope.knowledge_un[key]['LEVEL'] = $("#studyCourseLevel_" + key).val();
			$scope.knowledge_un[key]['PLACE'] = $("#studyCoursePlace_" + key).val();
			$scope.knowledge_un[key]['GRADUATION_MAJOR'] = $("#studyCourseCertificate_" + key).val();
			$scope.knowledge_un[key]['Q_START_DATE'] = $("#start-date-value_un_" + key).val() != "undefined-undefined-" ? $("#start-date-value_un_" + key).val() : "";
			$scope.knowledge_un[key]['Q_END_DATE'] = $("#end-date-value_un_" + key).val() != "undefined-undefined-" ? $("#end-date-value_un_" + key).val() : "";
		});
		
		var data = {
			objectKnowledgeOne: $scope.knowledge_g,
		    objectKnowledgeTow: $scope.knowledge_sk,
			objectKnowledgeThree: $scope.knowledge_un,
			numFild: count,
		};
		var editId = $('#indexEdit').val();
        $http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/general-knowledge',
            dataType: "json",
            data:{'editId':editId,"data":data}
        }).success(function(response) {
			if(response.code == 1){ // when completed required fields
				if(angular.isUndefined(url) == false){
					/*   ទៅមុខរឺថយក្រោយ */
					$location.path(url);
					$("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* sumarryDataGeneralKnowledge */
					$scope.sumarryDataGeneralKnowledge();
					/* End sumarryDataGeneralKnowledge */
					addClassActiveMenu('menu-5');
				} else {
					/*  រក្សាទុក  */
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* sumarryDataGeneralKnowledge */
					$scope.sumarryDataGeneralKnowledge();
					/* End sumarryDataGeneralKnowledge */
					addClassActiveMenu('menu-5');
				}
			} else if(response.code == 2){ // some fields are fill in but not yet completed required
				if(angular.isUndefined(url) == false){
					/*   ទៅមុខរឺថយក្រោយ */
					$location.path(url);
					$("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* sumarryDataGeneralKnowledge */
					$scope.sumarryDataGeneralKnowledge();
					/* End sumarryDataGeneralKnowledge */
					removeClassActiveMenu('menu-5');
				} else {
					/*  រក្សាទុក  */
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
					$('#jqx-notification').html(response.message);
					$("#jqx-notification").jqxNotification("open");
					/* sumarryDataGeneralKnowledge */
					$scope.sumarryDataGeneralKnowledge();
					/* End sumarryDataGeneralKnowledge */
					removeClassActiveMenu('menu-5');
				}
			} else { // when empty fields
				$location.path(url);
			}
        });
    };

	$scope.getGeneralKnowledgeById = function(callback){
		loadingWaiting();
		var editId = $('#indexEdit').val();
		$http({
          method: 'post',
          url: baseUrl+'background-staff-gov-info/get-general-knowledge-by-id',
          dataType: "json",
          data:{'editId':editId,"_token":_token}
      }).success(function(response) {
				callback(response);
      });
	}

	$scope.getGeneralKnowledgeById(function(data){
    $scope.knowledge_sk = data['knowledge_sk'] != undefined ? data['knowledge_sk'] : [{}];
		$scope.knowledge_un = data['knowledge_un'] != undefined ? data['knowledge_un'] : [{}];
		$scope.knowledge_g = {
			"LEVEL": data['knowledge_g'] != undefined ? data['knowledge_g'].LEVEL : null,
			"PLACE": data['knowledge_g'] != undefined ? data['knowledge_g'].PLACE : null,
			"GRADUATION_MAJOR" : data['knowledge_g'] != undefined ? data['knowledge_g'].GRADUATION_MAJOR : null,
			"Q_END_DATE" : data['knowledge_g'] != undefined ? $("#start-date-value_g").val(data['knowledge_g'].Q_START_DATE) : null,
			"Q_START_DATE"   : data['knowledge_g'] != undefined ? $("#end-date-value_g").val(data['knowledge_g'].Q_END_DATE) : null,
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
				/*   កម្រិតរប្បធម៌ទូទៅ   */
				var degree_g = data['knowledge_g'] != undefined ? data['knowledge_g'].LEVEL : '';
				initDropDownList(jqxTheme,'100%',35, '#div_generalLevel', angular.fromJson($("#listUnderDegreeData").text()), 'text', 'value', false, '', '0', "#generalLevel","ស្វែងរក",130,degree_g);
				$("#generalLevel").val(degree_g);
				var skill_g = data['knowledge_g'] != undefined ? data['knowledge_g'].GRADUATION_MAJOR : '';
				initDropDownList(jqxTheme,'100%',35, '#div_generalCertificate', angular.fromJson($("#listUnderDegreeData").text()), 'text', 'value', false, '', '0', "#generalCertificate","ស្វែងរក",130,skill_g);
				$("#generalCertificate").val(skill_g);

				var startData_g = $('#start-date-value_g').val() != null ? $('#start-date-value_g').val():null;
				getJqxCalendar('divStartDate_g','start-date-value_g','110px','35px','កាលបរិច្ឆេទចាប់ផ្តើម',startData_g);
				if(startData_g != null){
				   if(startData_g == "") {
					  getJqxCalendar('divEndDate_g','end-date-value_g','110px','35px','កាលបរិច្ឆេទបញ្ចប់','');
				      $("#divEndDate_g").jqxDateTimeInput({ disabled: true });
				   } else {
					   var endData_g = $('#end-date-value_g').val() != null ? $('#end-date-value_g').val():null;
					   getJqxCalendar('divEndDate_g','end-date-value_g','110px','35px','កាលបរិច្ឆេទបញ្ចប់',endData_g);
				   }
				}
				/* validate between start date and end date general knowlegde */
				$('#divStartDate_g').on('change',function(){
					var knowledgeStart = $('#start-date-value_g').val();
					if(knowledgeStart != null){
						if(knowledgeStart == ""){
							var knowledgeStartDate =  knowledgeStart.split("-");
							$('#divEndDate_g').jqxDateTimeInput('min',new Date(knowledgeStartDate[0], parseInt(knowledgeStartDate[1])-1, parseInt(knowledgeStartDate[2])+1));
							$('#divEndDate_g').jqxDateTimeInput('setDate', new Date(knowledgeStartDate[0], parseInt(knowledgeStartDate[1])-1, parseInt(knowledgeStartDate[2])+1));
							$("#divEndDate_g").jqxDateTimeInput({ disabled: true });
						} else {
							$("#divEndDate_g").jqxDateTimeInput({ disabled: false });
							var knowledgeStartDate =  knowledgeStart.split("-");
							$('#divEndDate_g').jqxDateTimeInput('min',new Date(knowledgeStartDate[0], parseInt(knowledgeStartDate[1])-1, parseInt(knowledgeStartDate[2])+1));
							$('#divEndDate_g').jqxDateTimeInput('setDate', new Date(knowledgeStartDate[0], parseInt(knowledgeStartDate[1])-1, parseInt(knowledgeStartDate[2])+1));
						}
					}
				});
			    /*   កម្រិតសញ្ញាបត្រ/ជំនាញឯកទេស   */

				angular.forEach($scope.knowledge_sk, function(value, key){
					var degree_g = value.LEVEL != undefined ? value.LEVEL : '';
					initDropDownList(jqxTheme,'100%',35, '#div_skillLevel_' + key, angular.fromJson($("#listUnderSkillData").text()), 'text', 'value', false, '', '0', "#skillLevel_" + key,"ស្វែងរក",300,degree_g);
					$("#skillLevel_"+key).val(degree_g);
					var skill_g = value.GRADUATION_MAJOR != undefined ? value.GRADUATION_MAJOR : '';
					initDropDownList(jqxTheme,'100%',35, '#div_skillCertificate_' + key, angular.fromJson($("#listUnderSkillData").text()), 'text', 'value', false, '', '0', "#skillCertificate_" + key,"ស្វែងរក",300,skill_g);
					$("#skillCertificate_"+key).val(skill_g);

					dateStartValue[key] = value.Q_START_DATE == '0000-00-00' ? '' : value.Q_START_DATE;
					getJqxCalendar('divStartDate_sk_' + key,'start-date-value_sk_' + key,'110px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',dateStartValue[key]);
					if(dateStartValue[key] != undefined){
						dateEndValue[key] = value.Q_END_DATE == '0000-00-00' ? '' : value.Q_END_DATE;
						getJqxCalendar('divEndDate_sk_' + key,'end-date-value_sk_' + key,'110px','32px','កាលបរិច្ឆេទបញ្ចប់',dateEndValue[key]);
					} else {
						getJqxCalendar('divEndDate_sk_' + key,'end-date-value_sk_' + key,'110px','32px','កាលបរិច្ឆេទបញ្ចប់','');
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
								$('#divEndDate_sk_' + key).jqxDateTimeInput('min',new Date(skillStartDate[0], parseInt(skillStartDate[1])-1, parseInt(skillStartDate[2])+1));
								$('#divEndDate_sk_' + key).jqxDateTimeInput('setDate', new Date(skillStartDate[0], parseInt(skillStartDate[1])-1, parseInt(skillStartDate[2])+1));
							} else {
								$('#divEndDate_sk_' + key).jqxDateTimeInput({ disabled: false });
								var skillStartDate =  skillStart.split("-");
								$('#divEndDate_sk_' + key).jqxDateTimeInput('min',new Date(skillStartDate[0], parseInt(skillStartDate[1])-1, parseInt(skillStartDate[2])+1));
								$('#divEndDate_sk_' + key).jqxDateTimeInput('setDate', new Date(skillStartDate[0], parseInt(skillStartDate[1])-1, parseInt(skillStartDate[2])+1));
							}
						}
					});
				});
				/*    វគ្គបណ្ដុះបណ្ដាលវិជ្ជាជីវៈ (ក្រោម ១២ ខែ)    */
				angular.forEach($scope.knowledge_un, function(value, key){
					dateStartValue[key] = value.Q_START_DATE == '0000-00-00' ? '' : value.Q_START_DATE;
					getJqxCalendar('divStartDate_un_' + key,'start-date-value_un_' + key,'110px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',dateStartValue[key]);
					if(dateStartValue[key] != undefined){
						dateEndValue[key] = value.Q_END_DATE == '0000-00-00' ? '' : value.Q_END_DATE;
						getJqxCalendar('divEndDate_un_' + key,'end-date-value_un_' + key,'110px','32px','កាលបរិច្ឆេទបញ្ចប់',dateEndValue[key]);
					} else {
						getJqxCalendar('divEndDate_un_' + key,'end-date-value_un_' + key,'110px','32px','កាលបរិច្ឆេទបញ្ចប់','');
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
		$("#SUMMARY_KNOWLEDGE_G_LEVEL").text($("#dropdownlistContentdiv_generalLevel").text());
		$("#SUMMARY_KNOWLEDGE_G_PLACE").text($scope.knowledge_g.PLACE ? $scope.knowledge_g.PLACE : '');
		$("#SUMMARY_KNOWLEDGE_G_GRADUATION_MAJOR").text($("#dropdownlistContentdiv_generalCertificate").text());
		$("#SUMMARY_KNOWLEDGE_G_START_DATA").text($("#divStartDate_g").attr('aria-valuetext'));
		$("#SUMMARY_KNOWLEDGE_G_END_DATA").text($("#divEndDate_g").attr('aria-valuetext'));
		/* SUMMERY DATA END*/
	}

	$scope.removeMoreSkill	=	function(keyIndex){
		if(angular.isUndefined(keyIndex) == true){
			$scope.knowledge_sk.splice($scope.keyIndexObjCache,1);
			$('#ModalConfirm_sk').modal('hide');
		}else{
			if(
				$("#skillLevel_" + keyIndex).val() != "" ||
				$("#skillPlace_" + keyIndex).val() != "" ||
				$("#skillCertificate_" + keyIndex).val() != "" ||
				$("#start-date-value_sk_" + keyIndex).val() != "" ||
				$("#end-date-value_sk_" + keyIndex).val() != ""
			){
				$(".btn-confrim-ok").addClass("display-none");
				$("#btnRemoveWorkHistory_sk").removeClass("display-none");
				$('#ModalConfirm_sk').modal('show');
				$scope.keyIndexObjCache	=	keyIndex;
			}else{
				$scope.knowledge_sk.splice(keyIndex,1);
			}
		}
	}

	$scope.addMoreSkill	=	function(){

		$scope.knowledge_sk.push({ LEVEL : "",PLACE : "",GRADUATION_MAJOR : "",Q_START_DATE : "",Q_END_DATE : ""});
		var lastIndex	=	($scope.knowledge_sk).length - 1;
		setTimeout(function(){
			var degree_g = $scope.knowledge_sk[lastIndex].GRADUATION_MAJOR;
			initDropDownList(jqxTheme,'100%',35, '#div_skillLevel_' + lastIndex, angular.fromJson($("#listDegreeData").text()), 'text', 'value', false, '', '0', "#skillLevel_" + lastIndex,"ស្វែងរក",300,degree_g);
			$("#skillLevel_"+lastIndex).val(degree_g);

			initDropDownList(jqxTheme,'100%',35, '#div_skillCertificate_' + lastIndex, angular.fromJson($("#listUnderSkillData").text()), 'text', 'value', false, '', '0', "#skillLevel_" + lastIndex,"ស្វែងរក",300,degree_g);
			$("#skillCertificate_"+lastIndex).val(degree_g);
			$http({
				method: 'post',
				url: baseUrl+'background-staff-gov-info/get-auto-completed',
				dataType: "json",
				data:{"_token":_token,"formId":"05"}
			}).success(function(response) {
				var result_2 = {};
				var result_5 = {};
				var place_2 = response.PLACE_2;
				var major_2 = response.GRADUATION_MAJOR_2;
				for (var i = 0; i < place_2.length; i++){
					result_2[i] = place_2[i]['PLACE'];
				}
				for (var m = 0; m < major_2.length; m++){
					result_5[m] = major_2[m]['GRADUATION_MAJOR'];
				}
				$("#skillPlace_"+lastIndex).jqxInput({ placeHolder: "គ្រឹះស្ថាន/ទីកន្លែង(ប្រទេស)", height: 36, width: '98%', minLength: 1, source: result_2 });
				$("#skillCertificate_" +lastIndex).jqxInput({ placeHolder: "សញ្ញាបត្រទទួលបាន", height: 36, width: '98%', minLength: 1, source: result_5 });
			});

			dateStartValue = $scope.knowledge_sk[lastIndex].Q_START_DATE;
			dateEndValue   = $scope.knowledge_sk[lastIndex].Q_END_DATE;
			getJqxCalendar('divStartDate_sk_' + lastIndex,'start-date-value_sk_' + lastIndex,'110px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',dateStartValue);
			getJqxCalendar('divEndDate_sk_' + lastIndex,'end-date-value_sk_' + lastIndex,'110px','32px','កាលបរិច្ឆេទបញ្ចប់',dateEndValue);
			$("#start-date-value_sk_" + lastIndex).val(dateStartValue);
			$("#end-date-value_sk_" + lastIndex).val(dateEndValue);
			/* validate between start date and end date certificate */
			$('#divStartDate_sk_' + lastIndex).on('change',function(){
				var skillStart = $('#start-date-value_sk_' + lastIndex).val();
				if(skillStart != null){
					if(skillStart == ""){
						$('#divEndDate_sk_' + lastIndex).jqxDateTimeInput({ disabled: true });
						var skillStartDate =  skillStart.split("-");
						$('#divEndDate_sk_' + lastIndex).jqxDateTimeInput('min',new Date(skillStartDate[0], parseInt(skillStartDate[1])-1, parseInt(skillStartDate[2])+1));
						$('#divEndDate_sk_' + lastIndex).jqxDateTimeInput('setDate', new Date(skillStartDate[0], parseInt(skillStartDate[1])-1, parseInt(skillStartDate[2])+1));
					} else {
						$('#divEndDate_sk_' + lastIndex).jqxDateTimeInput({ disabled: false });
						var skillStartDate =  skillStart.split("-");
						$('#divEndDate_sk_' + lastIndex).jqxDateTimeInput('min',new Date(skillStartDate[0], parseInt(skillStartDate[1])-1, parseInt(skillStartDate[2])+1));
						$('#divEndDate_sk_' + lastIndex).jqxDateTimeInput('setDate', new Date(skillStartDate[0], parseInt(skillStartDate[1])-1, parseInt(skillStartDate[2])+1));
					}
				}
			});
		}, 200);
	}

	$scope.removeMoreCertificate	=	function(keyIndex){
		if(angular.isUndefined(keyIndex) == true){
			$scope.knowledge_un.splice($scope.keyIndexObjCacheCertificate,1);
			$('#ModalConfirm_un').modal('hide');
		} else {
			if(
				$("#studyCourseLevel_" + keyIndex).val() != "" ||
				$("#studyCoursePlace_" + keyIndex).val() != "" ||
				$("#studyCourseCertificate_" + keyIndex).val() != "" ||
				$("#start-date-value_un_" + keyIndex).val() != "" ||
				$("#end-date-value_un_" + keyIndex).val() != ""
			){
				$(".btn-confrim-ok").addClass("display-none");
				$("#btnRemoveWorkHistory_un").removeClass("display-none");
				$('#ModalConfirm_un').modal('show');
				$scope.keyIndexObjCacheCertificate	=	keyIndex;
			} else {
				$scope.knowledge_un.splice(keyIndex,1);
			}
		}
	}

	$scope.addMoreCertificate	=	function() {
		$scope.knowledge_un.push({});
		var dateStartValue = [];
		var dateEndValue = [];
		var lastIndex =	($scope.knowledge_un).length - 1;
		setTimeout(function() {
			$http({
				method: 'post',
				url: baseUrl+'background-staff-gov-info/get-auto-completed',
				dataType: "json",
				data:{"_token":_token,"formId":"05"}
			}).success(function(response) {
				var result_3 = {};
				var result_4 = {};
				var result_6 = {};
				var place_3 = response.PLACE_3;
				var level   = response.LEVEL;
				var major_3 = response.GRADUATION_MAJOR_3;
				for (var i = 0; i < place_3.length; i++){
					result_3[i] = place_3[i]['PLACE'];
				}
				for (var p = 0; p < level.length; p++){
					result_4[p] = level[p]['LEVEL'];
				}
				for (var n = 0; n < major_3.length; n++){
					result_6[n] = major_3[n]['GRADUATION_MAJOR'];
				}
				$("#studyCoursePlace_"+lastIndex).jqxInput({ placeHolder: "គ្រឹះស្ថាន/ទីកន្លែង(ប្រទេស)", height: 36, width: '98%', minLength: 1, source: result_3 });
				$("#studyCourseLevel_"+lastIndex).jqxInput({ placeHolder: "វគ្គ ឬកម្រិតសិក្សា", height: 36, width: '98%', minLength: 1, source: result_4 });
				$("#studyCourseCertificate_"+lastIndex).jqxInput({ placeHolder: "សញ្ញាបត្រទទួលបាន", height: 36, width: '98%', minLength: 1, source: result_6 });
			});

			angular.forEach($scope.knowledge_un, function(value, key) {
				dateStartValue[key] = value.Q_START_DATE == '0000-00-00' ? '' : value.Q_START_DATE;
				dateEndValue[key] = value.Q_END_DATE == '0000-00-00' ? '' : value.Q_END_DATE;
				getJqxCalendar('divStartDate_un_' + key,'start-date-value_un_' + key,'110px','32px','កាលបរិច្ឆេទចាប់ផ្តើម',dateStartValue[key]);
				getJqxCalendar('divEndDate_un_' + key,'end-date-value_un_' + key,'110px','32px','កាលបរិច្ឆេទបញ្ចប់',dateEndValue[key]);
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

});
