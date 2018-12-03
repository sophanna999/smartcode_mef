<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{asset('icon/mef.ico')}}" />
	<title>@yield('pageTitle', 'ការិយាល័យវៃឆ្លាត - ជំហានចាប់ផ្ដើមឆ្ពោះទៅកាន់រដ្ឋាភិបាលអេឡិកត្រូនិក')</title>
	<!--Jquery-->
	<script type="text/javascript" src="{{asset('js/jquery-1.11.1.js')}}"></script>

	<!-- Library CSS -->
	<link rel="stylesheet" href="{{asset('css/global-smart-module.css')}}" type="text/css" />
	<style>
		input[type=password]
		{
			font-family: 'time new roman' !important;
		}
		::placeholder{
			font-family: 'KHMERMEF1';
		}
	</style>

</head>

<body>
<!-- Main App -->
<input type="hidden" name="is_form_login" id="is_form_login" value="true" />
<input type="hidden" name="baseUrl" id="baseUrl" value="{{asset('')}}" />
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
<input type="hidden" name="defaultRouteAngularJs" id="defaultRouteAngularJs" value="" />
<div id="checkIsUrlSubmit" class="display-none"><?php echo json_encode(array()); ?></div>
<div id="jqx-notification"></div>
<div id="jqxLoader"></div>
<div id="div-header" ng-app="smartofficeApp" ng-controller="mainController">
	@yield('content')
</div>

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
<script type="text/javascript" src="{{asset('js/jquery-confirm.min.js')}}"></script>
<!-- Main App End -->
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
        $(window).load(function(){
            $('#ModalUserFirstApproved').modal('show');
        });
	</script>
@endif
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
<script type="text/javascript" src="{{asset('jqwidgets/jqxangular.js')}}"></script>
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
</body>

</html>