app.controller("mainController", function ($scope,$rootScope,$location,$timeout,$http,$window,$route,ModalService) {
	
	$scope.getNotification = function(){
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/amount-notification',
            dataType: "json",
            data:{"_token":_token}
        }).success(function(response) {
			$scope.amount = response;
			$("#new_notifi").removeClass('display-none');
	   });
	};
	$scope.dayFormat = function(number){
		var words = '';
		var khmerNumber = ["០", "១", "២", "៣", "៤", "៥", "៦", "៧", "៨", "៩"];
		var stringData = number.toString();
		var ArraystringData = stringData.split('');
		angular.forEach(ArraystringData, function(value, key){
			var getConverted = khmerNumber[value];
			words += getConverted;
		});	
		return words;
    };
	
	// menuId is string Id Mnu <li>
	$scope.addClassActiveMenu = function(menuId){
		// $("#" + menuId).removeClass("active");
		$("#" + menuId).addClass("success");
	};

	$scope.disable = function(menuId){
		$("#" + menuId).addClass("events-none");
	};

	$scope.removeDisable = function(menuId){
		$("#" + menuId).removeClass("events-none");
	};

	$scope.checkIsUrlSubmit	= function(){
		$scope.checkIsUrlSubmitObj	=	angular.fromJson($("#checkIsUrlSubmit").text());

		if($scope.checkIsUrlSubmitObj.personalInfo	==	1){
			$scope.addClassActiveMenu('menu-1');
		}
		if($scope.checkIsUrlSubmitObj.situationPublicInfo	==	1){
			$scope.addClassActiveMenu('menu-2');
		}
		if($scope.checkIsUrlSubmitObj.workingHistroy	==	1){
			$scope.addClassActiveMenu('menu-3');
		}
		if($scope.checkIsUrlSubmitObj.awardSanction	==	1){
			$scope.addClassActiveMenu('menu-4');
		}
		if($scope.checkIsUrlSubmitObj.generalKnowledge	==	1){
			$scope.addClassActiveMenu('menu-5');
		}
		if($scope.checkIsUrlSubmitObj.abilityForeignLanguage	==	1){
			$scope.addClassActiveMenu('menu-6');
		}
		if($scope.checkIsUrlSubmitObj.familySituations	==	1){
			$scope.addClassActiveMenu('menu-7');
		}

		/*if($scope.checkIsUrlSubmitObj.familySituations	==	0 || $scope.checkIsUrlSubmitObj.personalInfo	==	0
			 || $scope.checkIsUrlSubmitObj.situationPublicInfo	==	0 || $scope.checkIsUrlSubmitObj.workingHistroy	==	0 || $scope.checkIsUrlSubmitObj.awardSanction	==	0 && $scope.checkIsUrlSubmitObj.generalKnowledge	==	0 || $scope.checkIsUrlSubmitObj.abilityForeignLanguage	==	0){

			$scope.disable('menu-8');
		}
		if($scope.checkIsUrlSubmitObj.familySituations	==	1 && $scope.checkIsUrlSubmitObj.personalInfo	==	1
			 && $scope.checkIsUrlSubmitObj.situationPublicInfo	==	1 && $scope.checkIsUrlSubmitObj.workingHistroy	==	1 && $scope.checkIsUrlSubmitObj.generalKnowledge	==	1 && $scope.checkIsUrlSubmitObj.abilityForeignLanguage	==	1){
			$scope.removeDisable('menu-8');
		}*/
	};
	
	$scope.checkIsUrlSubmit();
	
	$scope.submitToAdmin = function(){
		loadingWaiting();
		$http({
            method: 'post',
            url: baseUrl+'background-staff-gov-info/get-is-submit-all-form',
            dataType: "json",
            data:{"_token":_token}
        }).success(function(response) {
			$("#jqx-notification").jqxNotification({autoClose:false});
			if(response.code == 1){
				$("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({position: positionNotify,template: "success"});
				$('#jqx-notification').html(response.message);
                $("#jqx-notification").jqxNotification("open");
			}else{
				$("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({position: positionNotify,template: "warning",autoClose:false});
				$('#jqx-notification').html(response.message);
                $("#jqx-notification").jqxNotification("open");
			}
			endLoadingWaiting();
        });
	};
	setTimeout(function(){
	  if(defaultRouteAngularJs == '/smart-office'){
		$scope.$path = $location.path();
		if($scope.$path != '/smart-office'){
			$("#is_small_module").val("true");
			do_small_module(isRotation = true);
		}else{
			$("#is_small_module").val("false");
		}
	  }
	}, 500);
	
	$scope.$on("$locationChangeStart", function() {
		$scope.arrRouteDefault = [
			"/personal-info",
			"/situation-public-info",
			"/working-histroy",
			"/award-sanction",
			"/general-knowledge",
			"/ability-foreign-language",
			"/family-situations"
		];
		$scope.arrRouteFullPro = [
			"/all-form"
		];
		$scope.$path = $location.path();
		if(defaultRouteAngularJs == '/smart-office'){
			if ($scope.arrRouteDefault.indexOf($scope.$path) != -1) {
				$location.path('/smart-office');
			}
		}else{
			if ($scope.arrRouteFullPro.indexOf($scope.$path) != -1) {
				$location.path('/personal-info');
			}
		}
	});

    $rootScope.$on('$routeChangeSuccess', function () {
        var path = $location.path();
        if(path == '/personal-info'){
            $('#menu-1').addClass('active');
        }else{
            $('#menu-1').removeClass('active');
        }

        if(path == '/situation-public-info'){
            $('#menu-2').addClass('active');
        }else{
            $('#menu-2').removeClass('active');
        }

        if(path == '/working-histroy'){
            $('#menu-3').addClass('active');
        }else{
            $('#menu-3').removeClass('active');
        }

        if(path == '/award-sanction'){
            $('#menu-4').addClass('active');
        }else{
            $('#menu-4').removeClass('active');
        }
        if(path == '/general-knowledge'){
            $('#menu-5').addClass('active');
        }else{
            $('#menu-5').removeClass('active');
        }
        if(path == '/ability-foreign-language'){
            $('#menu-6').addClass('active');
        }else{
            $('#menu-6').removeClass('active');
        }
        if(path == '/family-situations'){
            $('#menu-7').addClass('active');
        }else{
            $('#menu-7').removeClass('active');
        }

        $scope.sessionAlive(path);
    });
    $rootScope.$on("$routeChangeError", function () {
        console.log("failed to change routes");
    });
    $scope.sessionAlive = function(path){
    	var session = baseUrl + 'session';
        $http.get(session)
		.success(function (response) {
			if (response == 'false' && path != ''){
                $scope.showSessionAliveModal();
                $location.path('/smart-office');
			}
		});
	};
    $scope.showSessionAliveModal = function() {
        ModalService.showModal({
            templateUrl: baseUrl + 'app/views/session.html',
            controller: "CustomModalController"
        }).then(function(modal) {
            modal.close.then(function(result) {
                $window.location = baseUrl + 'login';
            });
        });
    };
});
app.controller('CustomModalController', function($scope,close) {
    $scope.close = close;
});
function confirmDelete(title,content,callback,callbackcancel) {
    $.confirm({
        icon: 'glyphicon glyphicon-trash',
        title: title,
        content: content,
        draggable: true,
        buttons: {
            danger: {
                text: 'យល់ព្រម',
                btnClass: 'btn-blue',
                action: function(){
                    callback();
                }
            },
            warning: {
                text: 'បោះបង់',
                btnClass: 'btn-red any-other-class',
				action:function(){
					callbackcancel();
				}
            }
        }
    });
}