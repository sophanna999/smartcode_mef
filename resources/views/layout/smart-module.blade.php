<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{asset('icon/mef.ico')}}" />
	<title>
		@yield('pageTitle', 'ការិយាល័យវៃឆ្លាត - ជំហានចាប់ផ្ដើមឆ្ពោះទៅកាន់រដ្ឋាភិបាលអេឡិកត្រូនិក')
	</title>
	<!--Jquery-->
	<script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>

	<!-- Library CSS -->
	<link rel="stylesheet" href="{{asset('css/global.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('css/animate.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('css/global-smart-module.css')}}" type="text/css" />
	<link href='{{asset('fullcalender/fullcalendar/dist/fullcalendar.css')}}' rel='stylesheet' />
	<link href='{{asset('fullcalender/fullcalendar-scheduler/dist/scheduler.css')}}' rel='stylesheet' />

	<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" type="text/css" />
	{{--Orgchat Structure--}}
	<link rel="stylesheet" href="{{asset('orgchat/css/jquery.orgchart.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('orgchat/css/style.css')}}" type="text/css" />
	{{--end OrgChat Structure--}}
	{{--chat--}}
	<link rel="stylesheet" type="text/css" href="{{ asset('css/chat/custom.css') }}">
	{{--end chat--}}
	{{--big chat--}}
	<meta name="robots" content="noindex">
	<link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" />
	<link rel="canonical" href="https://codepen.io/emilcarlsson/pen/ZOQZaV?limit=all&page=74&q=contact+" />
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>

	<link rel='stylesheet prefetch' href={{ asset('css/style.min.css') }}>
	<link rel='stylesheet prefetch' href={{ asset('css/chat.min.css') }}>
	{{--end big chat--}}

	<style>
		input[type=password]
		{
			font-family: 'time new roman' !important;
		}
		::placeholder{
			font-family: 'KHMERMEF1';
		}
		.detail ul{
			line-height: 23px;
		}
		.prf-status
		{
			line-height: 23px;
		}
	</style>
</head>

<body class="holdForm">
<!-- Main App -->
<input type="hidden" name="baseUrl" id="baseUrl" value="{{asset('')}}" />
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
<input type="hidden" name="defaultRouteAngularJs" id="defaultRouteAngularJs" value="{{isset($defaultRouteAngularJs) ? $defaultRouteAngularJs:''}}" />
<div id="checkIsUrlSubmit" class="display-none"><?php echo json_encode(isset($checkIsUrlSubmit) ? $checkIsUrlSubmit:''); ?></div>
<div id="jqx-notification"></div>
<div id="jqxLoader"></div>
<div id="div-header" ng-app="smartofficeApp" ng-controller="mainController">
	@yield('content')
	<div></div>
</div>

{{--http-request--}}
<script type="text/javascript" src="{{asset('js/axios.min.js')}}"></script>
{{--end http request--}}
<script type="text/javascript" src="{{asset('fullcalender/moment/moment.js')}}"></script>
<script type="text/javascript" src="{{asset('fullcalender/moment/min/moment.min.js')}}"></script>
<script type="text/javascript"src="{{asset('fullcalender/fullcalendar/dist/fullcalendar.js')}}"></script>
<script type="text/javascript"src="{{asset('fullcalender/fullcalendar-scheduler/dist/scheduler.js')}}"></script>
<!-- Library JS -->
<script type="text/javascript" src="{{asset('js/highcharts.js')}}"></script>
<script type="text/javascript" src="{{asset('js/highcharts-3d.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery-paginate.js')}}"></script>
<script type="text/javascript" src="{{asset('js/monthly.js')}}"></script>
<script type="text/javascript" src="{{asset('js/script.js')}}"></script>
<script type="text/javascript" src="{{asset('js/velocity.js')}}"></script>
<script type="text/javascript" src="{{asset('js/smart-module-script.js')}}"></script>
<script type="text/javascript" src="{{asset('js/propeller.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.slimscroll.js')}}"></script>
<script type="text/javascript" src="{{asset('js/attrchange.js')}}"></script>
<script type="text/javascript" src="{{asset('js/smart-custom-script.js')}}"></script>

<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery-ui.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqx-all.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxcore.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxdatatable.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxdatetimeinput.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxcalendar.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxcombobox.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/globalize.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tag.js')}}"></script>

{{--confirm delete--}}
<script type="text/javascript" src="{{asset('js/jquery-confirm.min.js')}}"></script>


<!-- Main App End -->

{{--confirm delete--}}
<script type="text/javascript" src="{{asset('js/jquery-confirm.min.js')}}"></script>


<div id="waiting-load" class="display-none">
	<img src="{{asset('jqwidgets/styles/images/loader.gif')}}" alt="" />
</div>
@if(session("is_visited_first") == true)
	<!-- First Visited user login complete -->
	<div class="modal fade" id="ModalUserFirstApproved" role="dialog">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<h4>គណនីរបស់អ្នកត្រូវបានអនុម័ត</h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">បិទ</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
//		var positionNotify = "top-right";
        $(window).load(function(){
            $('#ModalUserFirstApproved').modal('show');
        });
	</script>
@endif
{{--angular lib--}}

<script type="text/javascript" src="{{asset('js/code39.js')}}"></script>
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
<script type="text/javascript" src="{{asset('jqwidgets/jqxangular.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxdatetimeinput.js')}}"></script>
<script type="text/javascript" src="{{asset('app/lib/angular/js/ui-grid.js')}}"></script>
<script type="text/javascript" src="{{asset('app/factory/angular-modal-service.js')}}"></script>
<script type="text/javascript" src="{{asset('app/app.js')}}"></script>
<script type="text/javascript" src="{{asset('app/lib/angular/js/angular-route.min.js')}}"></script>
<script type="text/javascript" src="{{asset('app/lib/angular/js/ngtimeago.js')}}"></script>
<script type="text/javascript" src="{{asset('app/factory/dirPagination.js')}}"></script>

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
<script type="text/javascript" src="{{asset('app/controllers/takeLeaveController.js')}}"></script>
<script type="text/javascript" src="{{asset('app/controllers/summaryAllFormController.js')}}"></script>
<script type="text/javascript" src="{{asset('app/controllers/scheduleController.js')}}"></script>
<script src="{{ asset('js/expandy.min.js') }}"></script>
<script type="text/javascript">
    $('.col-md-9').makeExpander({
        toggleElement: 'h6',
        jqAnim: true,
        showFirst: false,
        accordion: false,
        speed: 300,
        indicator: 'arrow'
    });
</script>
<script>
	var positionNotify = "top-right";
	document.cookie = "firebaseToken=";
</script>
</body>

</html>