var baseUrl = document.getElementById('baseUrl').value;
var _token = document.getElementById('token').value;
var jqxTheme = 'bootstrap';
var template = 'primary';
var defaultRouteAngularJs = document.getElementById('defaultRouteAngularJs').value;


/* Angular App name */
var app = angular.module("smartofficeApp",
        [
            'angularModalService',
            'ui.grid.selection',
            'ui.grid',
            'ui.grid.pagination',
            'jqwidgets',
            'jqwidgets-amd',
            'slickCarousel',
            'ngRoute',
            'ngAnimate',
            'ngFileUpload',
            'ngSanitize',
            'ngtimeago',
			'angularUtils.directives.dirPagination',
			'checklist-model'
        ]
);

app.run(['$rootScope','$location',function($rootScope,$location){
	$rootScope.search = {
		text:''
	};

	var oldURL,newURL;
	var base = -15;
	$rootScope.$on('$locationChangeSuccess', function($location) {
		if(window.location.href.indexOf("#/smart-office") !== -1) {

			for(var i=0;i<$(".layerPath").length;i++){
				var savedTop = $(".layerPath").eq(i).attr("data-top");
				$(".layerPath").eq(i).animate({top:savedTop},300);
			}
			sessionStorage.removeItem("click_index");
			$("#wrapper-propeller").css("display","block");
			$(".tab-content ").css("display","block");
			$(".cssplay-menu ").css("display","block");
			$(".slider-switch").css("display","block");
			$(".blg-table").css("height",'0vh');
			// $(".slider-switch").css("display","none");
		}else{
			$("#wrapper-propeller").css("display","none");
			$(".cssplay-menu").css("display","none");
			$(".slider-switch").css("display","none");

		}

		if(window.location.href.indexOf("#/schedule") !== -1) {

			for(var i=0;i<$(".layerPath").length;i++){
				var savedTop = $(".layerPath").eq(i).attr("data-top");
				$(".layerPath").eq(i).animate({top:savedTop},0);
			}
			animatedLayer(4,0);
		}
		if(window.location.href.indexOf("#/attendance-info") !== -1) {

			for(var i=0;i<$(".layerPath").length;i++){
				var savedTop = $(".layerPath").eq(i).attr("data-top");
				$(".layerPath").eq(i).animate({top:savedTop},0);
			}
			animatedLayer(6,0);
		}
		if(window.location.href.indexOf("#/all-form") !== -1) {

			for(var i=0;i<$(".layerPath").length;i++){
				var savedTop = $(".layerPath").eq(i).attr("data-top");
				$(".layerPath").eq(i).animate({top:savedTop},0);
			}
			animatedLayer(9,0);
		}
		// if(oldURL != window.location.href){
		// 	console.log("same ")
		// }
		// oldURL = window.location.href;
	});

	// $rootScope.$on('$locationChangeSuccess', function($location) {
	// 	console.log(window.location.href);
	//
	// 	if(window.location.href.indexOf("#/smart-office") !== -1){
	// 	//	window.location.href = "#/smart-office";
	// 	}
	//
	//
	// });
	angular.element('.carousel .bxslider').slick({
		vertical: true,
		autoplay: true,
		slidesToShow: 3,
		slidesToScroll: 1
	});
}]);
// app.run(function ($rootScope) {
//     $rootScope.search = {
//         text:''
//     };
// 	angular.element('.carousel .bxslider').slick({
// 		vertical: true,
// 		autoplay: true,
// 		slidesToShow: 3,
// 		slidesToScroll: 1
// 	});
//
// 	$rootScope.$on('$locationChangeSuccess', function($location) {
// 		console.log(window.location.href);
// 		if(window.location.href.indexOf("smart-office") !== -1){
// 			console.log("eter");
// 			window.location.href = "#/smart-office";
// 		}
// 	});
//
// });

// $rootScope.$on('$locationChangeSuccess', function($location) {
// 	console.log($location.path());
// 	$rootScope.actualLocation = $location.path();
// });
//
// $rootScope.$watch(function () {return $location.path()}, function (newLocation, oldLocation) {
// 	if($rootScope.actualLocation === newLocation) {
// 		alert('Why did you use history back?');
// 	}
// });

app.config(['slickCarouselConfig', function (slickCarouselConfig) {
	slickCarouselConfig.dots = true;
	slickCarouselConfig.autoplay = false;
}]);

app.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
            when('/personal-info', {
                templateUrl: baseUrl + 'background-staff-gov-info/get-personal-info'

            }).
			when('/situation-public-info', {
                templateUrl: baseUrl + 'background-staff-gov-info/get-situation-public-info'

            }).
			when('/general-knowledge', {
                templateUrl: baseUrl + 'background-staff-gov-info/general-knowledge'
            }).
			when('/ability-foreign-language', {
                templateUrl: baseUrl + 'background-staff-gov-info/ability-foreign-language'
            }).
			when('/family-situations', {
                templateUrl: baseUrl + 'background-staff-gov-info/family-situations'
            }).
			when('/reassured', {
                templateUrl: baseUrl + 'background-staff-gov-info/reassured'
            }).
            when('/working-histroy', {
                templateUrl: baseUrl + 'background-staff-gov-info/working-history'
            }).
            when('/award-sanction', {
                templateUrl: baseUrl + 'background-staff-gov-info/award-sanction'
            }).
            when('/ability-foreign-language', {
                templateUrl: baseUrl + 'background-staff-gov-info/ability-foreign-language'
            }).
			when('/update-info', {
                templateUrl: baseUrl + 'background-staff-gov-info/update-info'
            }).
			when('/new-notification', {
                templateUrl: baseUrl + 'background-staff-gov-info/new-notification'
            }).
			when('/all-form', {
                templateUrl: baseUrl + 'summary-all-form/index',
                title: 'ធនធានមនុស្ស'
            }).
            when('/edit-personal', {
                templateUrl: baseUrl + 'summary-all-form/edit-personal-info',
                title: "{{trans('personal_info.request_to_update').trans('personal_info.biography')}}"
            }).
            when('/print-personal', {
                templateUrl: baseUrl + 'summary-all-form/print-personal-info',
                title: "{{trans('officer.print').trans('personal_info.biography')}}"
            }).
            when('/personal-report', {
                templateUrl: baseUrl + 'summary-all-form/personal-report',
                title: "{{trans('officer.export')}}"
            }).
			when('/smart-office', {
                templateUrl: baseUrl + 'background-staff-gov-info/smart-office-module'
            }).
	        when('/smart-office-grid', {
		        templateUrl: baseUrl + 'app/views/session.html'
	        }).
			when('/attendance-info', {
                templateUrl: baseUrl + 'updateInfo/index'
            }).
			when('/attendance-info/approve', {
                templateUrl: baseUrl + 'updateInfo/approve'
            }).
			when('/attendance-info/approve/:id', {
                templateUrl: baseUrl + 'updateInfo/approve'
            }).
			when('/attendance-info/transfer', {
                templateUrl: baseUrl + 'updateInfo/transfer-from'
            }).
            when('/attendance-info/list-scan-history', {
                templateUrl: baseUrl + 'attendance/list-scan-history'
            }).
            /* Schedule */
            when('/schedule', {
                templateUrl: baseUrl + 'schedule/index'
            }).
            /* News */
            when('/news', {
                templateUrl: baseUrl + 'news/index'
            }).
            when('/news/detail/:id', {
                templateUrl: function (params) {
                    return baseUrl + 'news/detail/'+params.id
                }
            }).
            when('/news/category/:cate_id', {
                templateUrl: function (params) {
                    return baseUrl + 'news/listview/'+params.cate_id;
                }
            }).
            when('/news/search', {
                templateUrl:baseUrl + 'news/listview'
            }).
            when('/news/search-advance', {
                templateUrl:baseUrl + 'news/listview'
            }).
	        when('/chat', {
	            templateUrl:baseUrl + 'chat/index'
	        }).
            otherwise({
                redirectTo: defaultRouteAngularJs
            });

    }]);

app.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});

// menuId is string Id Mnu <li>
function addClassActiveMenu(menuId){
	$("#" + menuId).addClass("success");
}

function removeClassActiveMenu(menuId){
	$("#" + menuId).removeClass("success");
}

// Loading waiting
function loadingWaiting(){
	$("#waiting-load").removeClass("display-none");
	$("body").addClass("events-none");
}
// End Loading waiting
function endLoadingWaiting(){
	$("#waiting-load").addClass("display-none");
	$("body").removeClass("events-none");
}


