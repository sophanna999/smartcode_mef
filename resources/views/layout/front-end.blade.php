<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex" />
<link rel="shortcut icon" href="{{asset('icon/mef.ico')}}" />
<title>@yield('pageTitle', 'ការិយាល័យវៃឆ្លាត - ជំហានចាប់ផ្ដើមឆ្ពោះទៅកាន់រដ្ឋាភិបាលអេឡិកត្រូនិក')</title>
<script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery-ui.js')}}"></script>

<script type="text/javascript" src="{{asset('jqwidgets/jqx-all.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxcore.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxdatatable.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxdatetimeinput.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxcalendar.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxcombobox.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/globalize.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/global-front.css')}}" type="text/css" />
<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" type="text/css" />
	<style>
		input[type=password]
		{
			font-family: 'time new roman' !important;
		}
		::placeholder{
			font-family: 'KHMERMEF1';
			color: lightgrey !important;
		}
	</style>
</head>
<body>
	<input type="hidden" name="baseUrl" id="baseUrl" value="{{asset('')}}" />
	<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
	<input type="hidden" name="indexEdit" id="indexEdit" value="{{isset($indexEdit) ? $indexEdit:''}}" />
	<input type="hidden" name="defaultRouteAngularJs" id="defaultRouteAngularJs" value="{{isset($defaultRouteAngularJs) ? $defaultRouteAngularJs:''}}" />
	<div id="checkIsUrlSubmit" class="display-none"><?php echo json_encode(isset($checkIsUrlSubmit) ? $checkIsUrlSubmit:''); ?></div>
	<div id="jqx-notification"></div>
	<div id="jqx-loader"></div>
	<div id="div-header" ng-app="smartofficeApp" ng-controller="mainController">
		@yield('content')
	</div>
    
<div id="waiting-load" class="display-none">
	<img src="{{asset('jqwidgets/styles/images/loader.gif')}}" alt="" />
</div>
	<script type="text/javascript" src="{{asset('js/script.js')}}"></script>

	{{--angular lib--}}
	<script type="text/javascript" src="{{asset('js/jquery.Jcrop.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/jquery.PersonalInfoCropper.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/lib/angular/js/angular1.4.8.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/lib/angular/js/ng-file-upload.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/lib/angular/js/ng-file-upload-shim.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/lib/angular/js/angular-touch.js')}}" ></script>
	<script type="text/javascript" src="{{asset('app/lib/angular/js/angular-animate.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/lib/angular/js/angular-cookies.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/slick.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/lib/angular/js/angular-slick.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/lib/angular/js/slick.js')}}"></script>

	<script type="text/javascript" src="{{asset('js/angular-sanitize.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/code39.js')}}"></script>
	<script type="text/javascript" src="{{asset('jqwidgets/jqxangular.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/lib/angular/js/ui-grid.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/factory/angular-modal-service.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/app.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/lib/angular/js/angular-route.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/lib/angular/js/ngtimeago.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/factory/dirPagination.js')}}"></script>

	{{--angular controller--}}
	<script type="text/javascript" src="{{asset('app/directive/allFormDirective.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/directive/checklist.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/directive/verifyPassword.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/controllers/mainController.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/controllers/personalInfoController.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/controllers/situationPublicInfoController.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/controllers/workHistoryController.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/controllers/updateAccountController.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/controllers/awardSanctionController.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/controllers/generalKnowledgeController.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/controllers/abilityLanguageController.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/controllers/familySituationController.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/controllers/newNotificationController.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/controllers/newsController.js')}}"></script>
	<script type="text/javascript" src="{{asset('app/controllers/TakeLeaveController.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/jquery-confirm.min.js')}}"></script>
	<script>
		var positionNotify = "top-right";
		document.cookie = "firebaseToken=";
	</script>
	<script src="{{ asset('js/expandy.min.js') }}"></script>
	<script type="text/javascript">
        $('.col-md-9').makeExpander({
            toggleElement: 'h6',
            jqAnim: false,
            showFirst: false,
            accordion: false,
            speed: 1400,
            indicator: 'arrow'
        });
	</script>
</body>
</html>
