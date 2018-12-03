app.controller("summaryAllFormController", function ($scope,$interval,$http,$compile) {
	var loading_time = 2000;
	// get Personal Info
	$scope.isShowGetPersonalInfo = true;
	$scope.showPersonalInfo = function(){
		if($scope.isShowGetPersonalInfo == true){
			var compiledeHTML = $compile("<div get-Personal-Info></div>")($scope);
			$("#getPersonalInfo").append(compiledeHTML);
			setTimeout(function(){
			  $("#getPersonalInfo .loading-waiting-template").remove();
			}, loading_time);
		}
		$scope.isShowGetPersonalInfo = false;
		};
    $scope.start_dt = new Date();
    $scope.start_dt.setDate($scope.start_dt.getDate() - 7);
    $scope.end_dt = new Date();
    $scope.end_dt.setDate($scope.end_dt.getDate() + 7);
    var dateTimeInput = null;
    $scope.settings = {
        width: 250, height: 25, selectionMode: 'range',
        created: function (args) {
            dateTimeInput = args.instance;

        },
        change: function (event) {

        }
    };
	// getSituationPublicInfo
	$scope.isShowSituationPublicInfo = true;
	$scope.showSituationPublicInfo = function(){
		if($scope.isShowSituationPublicInfo == true){
			var compiledeHTML = $compile("<div get-Situation-Public-Info></div>")($scope);
			$("#getSituationPublicInfo").append(compiledeHTML);
			setTimeout(function(){
			  $("#getSituationPublicInfo .loading-waiting-template").remove();
			}, loading_time);
		}
		$scope.isShowSituationPublicInfo = false;
    };
	// getWorkingHistroy
	$scope.isShowWorkingHistroy = true;
	$scope.showWorkingHistroy = function(){
		if($scope.isShowWorkingHistroy == true){
			var compiledeHTML = $compile("<div get-Working-Histroy></div>")($scope);
			$("#getWorkingHistroy").append(compiledeHTML);
			setTimeout(function(){
			  $("#getWorkingHistroy .loading-waiting-template").remove();
			}, loading_time);
		}
		$scope.isShowWorkingHistroy = false;
    };
	// getAwardSanction
	$scope.isShowAwardSanction = true;
	$scope.showAwardSanction = function(){
		if($scope.isShowAwardSanction == true){
			var compiledeHTML = $compile("<div get-Award-Sanction></div>")($scope);
			$("#getAwardSanction").append(compiledeHTML);
			setTimeout(function(){
			  $("#getAwardSanction .loading-waiting-template").remove();
			}, loading_time);
		}
		$scope.isShowAwardSanction = false;
    };
	// getGeneralKnowledge
	$scope.isShowGeneralKnowledge = true;
	$scope.showGeneralKnowledge = function(){
		if($scope.isShowGeneralKnowledge == true){
			var compiledeHTML = $compile("<div get-General-Knowledge></div>")($scope);
			$("#getGeneralKnowledge").append(compiledeHTML);
			setTimeout(function(){
			  $("#getGeneralKnowledge .loading-waiting-template").remove();
			}, loading_time);
		}
		$scope.isShowGeneralKnowledge = false;
    };
	// getAbilityForeignLanguage
	$scope.isShowAbilityForeignLanguage = true;
	$scope.showAbilityForeignLanguage = function(){
		if($scope.isShowAbilityForeignLanguage == true){
			var compiledeHTML = $compile("<div get-Ability-Foreign-Language></div>")($scope);
			$("#getAbilityForeignLanguage").append(compiledeHTML);
			setTimeout(function(){
			  $("#getAbilityForeignLanguage .loading-waiting-template").remove();
			}, loading_time);
		}
		$scope.isShowAbilityForeignLanguage = false;
    };
	// getFamilySituations
	$scope.isShowFamilySituations = true;
	$scope.showFamilySituations = function(){
		if($scope.isShowFamilySituations == true){
			var compiledeHTML = $compile("<div get-Family-Situations></div>")($scope);
			$("#getFamilySituations").append(compiledeHTML);
			setTimeout(function(){
			  $("#getFamilySituations .loading-waiting-template").remove();
			}, loading_time);
		}
		$scope.isShowFamilySituations = false;
    };
	// Close Form 
	$scope.closeForm = function(dataFormId){
		var scrollTo_int = $('#' + dataFormId).prop('scrollHeight') + 'px';
		$(".bg-transparent").fadeOut(200);			
		$("#" + dataFormId + " .btnEdit").show();
		$("#"  + dataFormId + " .sb-heading").css("z-index","99");
		$("#" + dataFormId + " .body-edit").css("z-index","99");
		$("#" + dataFormId + " .blg-fade-edit").css("display","none");
		$("#" + dataFormId + " .tbl-edit-cont").css("display","block");
		
	};
});