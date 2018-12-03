@extends('layout.smart-module-login')
@section('content')

	<!--Content left-->

	<div class="blg-left">
		@include('front-end.include.content-left-login')
	</div>

	<!-- Content center -->
	<input type="hidden" id="is_small_module" value="false" />
	<div class="blg-main">
        <?php
        $postRegisterUrl = asset('register/do-register');
        $userAvailable = asset('register/user-available');
        $emailAvailable = asset('register/verify-email');
        $getSecreateByMinistryId = asset('/register/get-secretary-by-ministry-id');
        $getdepartmentBySecId = asset('/register/get-department-by-secretary-id');
        $getOfficeByDepartment = asset('/register/get-office-by-department-id');
        $loginUrl = asset('/login');//dd(1);
        ?>
		<style>
			#login-wrapper,.btn-edit{
				font-family: 'KHMERMEF1';
				font-size:14px;
			}
			.form-horizontal .has-feedback .form-control-feedback{
				top:24px;
			}
			.jqx-dropdownlist-content,.jqx-listitem-state-normal{
				font-family: KHMERMEF1 !important;
			}
			.contain-color {
				background-color: #f1f1f1;
				position: relative;
				left: 10%;
				padding: 2.01em 16px;
				margin: 20px 0;
				width: 80%;
				box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;
			}
		</style>

		@if (count($errors) > 0)
			<div class="col-xs-8 col-xs-offset-2">
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li style="font-family: KHMERMEF1;list-style: none;">{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			</div>
		@endif
		<div class="contain-color">

			<form onsubmit="return validateEmail()" action="{{$postRegisterUrl}}" class="form-horizontal form-register" method="post" id="jqx-form" name="jqx-form" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="confirmation_code" id="confirmation_code" value="{{str_random(150)}}">
				<div style="display:none;">
					<input type="file" value="" id="my-avatar" name="avatar" accept="image/*">
				</div>

				<p class="reg-ttl">{{trans('register.staff_register_form')}}<br>{{trans('register.staff_history')}}</p>

				<div class="form-group">
					<div class="col-lg-12 col-md-6 col-sm-12 col-xs-12 mb30">
						<label><span class="col-red">*</span>{{trans('users.userName')}}</label>
						<input type="text" class="form-control" id="USER_NAME" name="USER_NAME" placeholder="{{trans('users.userName')}}">
						<div id="isUserAvailable"></div>
					</div>
					<div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
						<label><span class="col-red">*</span>{{trans('users.password')}}</label>
						<input type="password" class="form-control" id="USER_PASSWORD" name="USER_PASSWORD" placeholder="{{trans('users.password')}}">
					</div>
					<div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
						<label><span class="col-red">*</span>{{trans('register.confirm_password')}}</label>
						<input type="password" class="form-control" id="USER_PASSWORD_CONFIRM" name="USER_PASSWORD_CONFIRM" placeholder="{{trans('register.confirm_password')}}">
					</div>
				</div>

				<div class="form-group">
					<div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
						<label><span class="col-red">*</span>{{trans('officer.full_name')}}</label>
						<input type="text" class="form-control" id="FULL_NAME_KH" name="FULL_NAME_KH" placeholder="{{trans('officer.full_name')}}">
					</div>
					<div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
						<label><span class="col-red">*</span>{{trans('officer.english_name')}}</label>
						<input type="text" class="form-control" id="FULL_NAME_EN" name="FULL_NAME_EN" placeholder="{{trans('officer.english_name')}}">
					</div>
					<div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
						<label><span class="col-red">*</span>{{trans('officer.phone_number')}}</label>
						<input class="form-control" type="text" id="PHONE_NUMBER_1" name="PHONE_NUMBER_1" placeholder="{{trans('officer.phone_number')}}">
					</div>
					<div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
						<label><span class="col-red">*</span>{{trans('officer.email')}}</label>
						<input type="text" class="form-control" id="EMAIL" name="EMAIL" placeholder="{{trans('officer.email')}}">
						<div id="isEmailAvailable"></div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
						<label><span class="col-red">*</span>{{trans('officer.centralMinistry')}}</label>
						<input type="hidden" class="form-control" id="mef_ministry_id" name="mef_ministry_id">
						<div id="div_mef_ministry_id" class="gb-dropdown"></div>
					</div>
					<div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
						<label> <span class="col-red">*</span>{{trans('officer.generalDepartment')}}</label>
						<input type="hidden" id="mef_secretariat_id" name="mef_secretariat_id">
						<div id="div_mef_secretariat_id" class="gb-dropdown"></div>
					</div>
					<div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
						<label><span class="col-red">*</span>{{trans('officer.department')}}</label>
						<input type="hidden" id="mef_department_id" name="mef_department_id">
						<div id="div_mef_department_id" class="gb-dropdown"></div>
					</div>
					<div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
						<label>{{trans('officer.office')}}</label>
						<input type="hidden" id="mef_office_id" name="mef_office_id">
						<div id="div_mef_office_id" class="gb-dropdown"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-3 col-md-2 col-sm-6 col-xs-6">
						<label><span>{{trans('register.secretary_code')}}</span></label>
						<span class="refereshrecapcha">{!! Captcha::img() !!}</span>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-6 col-xs-6 re-code">
						<a href="javascript:void(0)" onclick="refreshCaptcha()"><span id="captcha-reload" class="glyphicon glyphicon-refresh"></span></a>
					</div>
					<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 mb30">
						<label><span class="col-red">*</span>{{trans('register.fill_in_secretary_code')}}</label>
						<input type="text" class="form-control" id="CAPTCHA" name="captcha" placeholder="{{trans('register.fill_in_secretary_code')}}">
					</div>
					<div class="col-lg-12 col-md-6 col-sm-12 col-xs-12 text-right" style="top:18px;">
						<button type="button" id="jqx-save" class="btn btn-primary btn-edit " style="margin-left: 0px;"><i class="glyphicon glyphicon-pencil"></i> {{trans('register.register')}}</button>
						<button type="button" id="jqx-back" onClick="goToLoginUrl()" class="btn btn-primary" style="margin-left: 0px;"><i class="glyphicon glyphicon-chevron-left"></i>{{trans('register.go_back')}}</button>
					</div>

				</div>
			</form>
		</div>


		<script>

            function goToLoginUrl(){
                window.location = '{{$loginUrl}}';
            }
            function refreshCaptcha(){
                var baseUrl = document.getElementById('baseUrl').value;
                var _token = document.getElementById('token').value;
                $.ajax({
                    url: baseUrl + 'register/refresh-captcha',
                    type: 'post',
                    data:{"_token":_token},
                    dataType: 'html',
                    success: function(json) {
                        $('.refereshrecapcha').html(json);
                    },
                    error: function(data) {
                        alert('Try Again!');
                    }
                });
            }

            function getSecretaratByMinistryId(object){
                var ministryId = $(object).val();
                $.ajax({
                    type: "post",
                    url : '{{$getSecreateByMinistryId}}',
                    datatype : "json",
                    data : {"ministryId":ministryId,"_token":'{{ csrf_token() }}'},
                    success : function(data){
                        initDropDownList('bootstrap', '100%',35, '#div_mef_secretariat_id', data, 'text', 'value', false, '', '0', "#mef_secretariat_id","{{trans('trans.buttonSearch')}}",300);
                    }
                });
            }
            function getDepartmentBySecrateId(object){
                var secretaryId = $(object).val();
                $.ajax({
                    type: "post",
                    url : '{{$getdepartmentBySecId}}',
                    datatype : "json",
                    data : {"secretaryId":secretaryId,"_token":'{{ csrf_token() }}'},
                    success : function(data){
                        initDropDownList('bootstrap', '100%',35, '#div_mef_department_id', data, 'text', 'value', false, '', '0', "#mef_department_id","{{trans('trans.buttonSearch')}}",300);
                    }
                });
            }
            function getOfficeByDepartmentId(object){
                var departmentId = $(object).val();
                $.ajax({
                    type: "post",
                    url : '{{$getOfficeByDepartment}}',
                    datatype : "json",
                    data : {"departmentId":departmentId,"_token":'{{ csrf_token() }}'},
                    success : function(data){
                        initDropDownList('bootstrap', '100%',35, '#div_mef_office_id', data, 'text', 'value', false, '', '0', "#mef_office_id","{{trans('trans.buttonSearch')}}",300);
                    }
                });
            }
            function userAvailable(){
                var user_name = $('#USER_NAME').val();
                $.ajax({
                    type: "POST",
                    url: '{{$userAvailable}}',
                    data: {"user_name":user_name,"_token":'{{ csrf_token() }}'},
                    success: function(response){
                        var result = eval('('+response+')');
                        if(result.success==true){
                            $('#isUserAvailable').html('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
                            $("#jqx-save").jqxButton({ disabled: true });
                            $('#jqx-notification').jqxNotification({position: 'top-right',autoClose: false,template: "warning"}).html('{{trans('users.user_token')}}');
                            $("#jqx-notification").jqxNotification("open");
                        } else{
                            $('#isUserAvailable').html('<span class="glyphicon glyphicon-ok form-control-feedback"></span>');
                            $("#jqx-save").jqxButton({ disabled: false });
                        }
                    }
                });
            }
            function emailAvailable(){
                var email = $('#EMAIL').val();
                $.ajax({
                    type: "POST",
                    url: '{{$emailAvailable}}',
                    data: {"email":email,"_token":'{{ csrf_token() }}'},
                    success: function(response){
                        var result = eval('('+response+')');
                        $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                        if(result.code==0){
                            $('#isEmailAvailable').html('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
                            $("#jqx-save").jqxButton({ disabled: true });
                            $('#jqx-notification').jqxNotification({position: 'top-right',autoClose: false,template: "warning"}).html('{{trans('register.email_taken')}}');
                            $("#jqx-notification").jqxNotification("open");

                        }else{
                            $('#isEmailAvailable').html('<span class="glyphicon glyphicon-ok form-control-feedback"></span>');
                            $("#jqx-save").jqxButton({ disabled: false });
                        }
                    }
                });
            }

            $(function(){
				/* Jqx tooltip */
                $("#captcha-reload").jqxTooltip({ content: 'ប្តូរកូដសម្ងាត់', position: 'top', name: 'movieTooltip',enableBrowserBoundsDetection: true});
                $("#USER_PASSWORD").jqxPasswordInput();
                $("#USER_PASSWORD_CONFIRM").jqxPasswordInput();


				/* Check Username available or not*/
                $("#USER_NAME").bind('blur', function(event) {
                    userAvailable();
                });
                $("#USER_NAME").keydown(function(event) {
                    var key = event.keyCode;
                    if(key == 32){
                        $('#USER_NAME').bind('input', function(){
                            $(this).val(function(_, v){
                                return v.replace(/\s+/g, '');
                            });
                        });
                        event.preventDefault();
                        return false;
                    }
                });

				/* Check email invalid */
                $("#EMAIL").bind('blur', function(event) {
                    emailAvailable();
                });
                $("#EMAIL").keydown(function(event) {
                    var key = event.keyCode;
                    if(key == 32){
                        $('#EMAIL').bind('input', function(){
                            $(this).val(function(_, v){
                                return v.replace(/\s+/g, '');
                            });
                        });
                        event.preventDefault();
                        return false;
                    }
                });


				/* Ministry */
                initDropDownList('bootstrap', '100%',35, '#div_mef_ministry_id', <?php echo $listMinistry;?>, 'text', 'value', false, '', '0', "#mef_ministry_id","{{trans('trans.buttonSearch')}}",150);
                $('#div_mef_ministry_id').bind('select', function (event) {
                    if($(this).val() !=0){
                        getSecretaratByMinistryId(this);
                    }
                });

				/* Secretariat */
                initDropDownList('bootstrap', '100%',35, '#div_mef_secretariat_id', <?php echo $listSecretariat;?>, 'text', 'value', false, '', '0', "#mef_secretariat_id","{{trans('trans.buttonSearch')}}",300);
                $('#div_mef_secretariat_id').bind('select', function (event) {
                    if($(this).val() !=0){
                        getDepartmentBySecrateId(this);
                    }
                });

				/*Department*/
                initDropDownList('bootstrap', '100%',35, '#div_mef_department_id',<?php echo $listDepartment;?>, 'text', 'value', false, '', '0', "#mef_department_id","{{trans('trans.buttonSearch')}}",400);
                initDropDownList('bootstrap', '100%',35, '#div_mef_office_id',<?php echo $listOffice;?>, 'text', 'value', true, '', '0', "#mef_office_id","{{trans('trans.buttonSearch')}}",400);
                $('#div_mef_department_id').bind('select', function (event) {
                    if($(this).val() !=0){
                        getOfficeByDepartmentId(this);
                    }
                });


                //Form validation goes here...
                $('#jqx-form').jqxValidator({
                    hintType:'label',
                    rules: [
                        {input: '#div_mef_ministry_id', message: '{{trans('register.please_select_ministry')}}', action: 'select',
                            rule: function () {
                                if($("#div_mef_ministry_id").val() == ""){
                                    return false;
                                }
                                return true;
                            }
                        },
                        {input: '#div_mef_secretariat_id', message: '{{trans('register.please_select_gd')}}', action: 'select',
                            rule: function () {
                                if($("#div_mef_secretariat_id").val() == ""){
                                    return false;
                                }
                                return true;
                            }
                        },
                        {input: '#div_mef_department_id', message: '{{trans('register.please_select_department')}}', action: 'select',
                            rule: function () {
                                if($("#div_mef_department_id").val() == ""){
                                    return false;
                                }
                                return true;
                            }
                        },
                        { input: '#USER_NAME', message: '{{trans('register.input_user_name')}}', action: 'keyup, blur', rule: 'required'},
                        { input: '#USER_NAME', message: '{{trans('register.input_user_name_litmit_char')}}', action: 'keyup, blur', rule: 'length=2,20' },
                        { input: '#USER_PASSWORD', message: '{{trans('register.please_input_password')}}', action: 'keyup, blur', rule: 'required'},
                        { input: '#USER_PASSWORD_CONFIRM', message: '{{trans('register.please_input_confirm_password')}}', action: 'keyup, blur', rule: 'required'},
                        {input: '#USER_PASSWORD_CONFIRM', message: '{{trans('register.password_confirmPassword_invalid')}}', action: 'blur', rule: function (input, commit) {
                            if (input.val() === $('#USER_PASSWORD').val()) {
                                return true;
                            }
                            return false;

                        }},
                        { input: '#FULL_NAME_KH', message: '{{trans('register.input_full_name_kh')}}', action: 'blur', rule: 'required'},
                        { input: '#FULL_NAME_EN', message: '{{trans('register.input_full_name_en')}}', action: 'blur', rule: 'required'},
                        { input: '#PHONE_NUMBER_1', message: '{{trans('register.input_phone_number')}}', action: 'blur',rule: 'required'},
                        { input: '#EMAIL', message: '{{trans('register.invalid_email')}}', action: 'keyup, blur', rule: 'email' },
                        { input: '#EMAIL', message: '{{trans('register.input_email')}}', action: 'keyup, blur', rule: 'required'},
                        { input: '#CAPTCHA', message: '{{trans('register.input_code')}}', action: 'keyup, blur', rule: 'required'}
                    ],
                    onSuccess: function () {
                        var baseUrl = document.getElementById('baseUrl').value;
                        var _token = document.getElementById('token').value;
                        var captcha = document.getElementById('CAPTCHA').value;
                        var email = document.getElementById('EMAIL').value;
                        $.ajax({
                            url: baseUrl + 'register/verify-email',
                            type: 'post',
                            data:{"_token":_token,"email":email},
                            dataType: 'json',
                            beforeSend:function () {
                                $("#jqx-save").jqxButton({ disabled: true });
                            },
                            success: function(response) {
                                if(response.code == 0){
                                    $("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
                                    $("#jqx-notification").jqxNotification();
                                    $('#jqx-notification').jqxNotification({position: 'bottom-left',template: "warning" });
                                    $('#jqx-notification').html(response.message);
                                    $("#jqx-notification").jqxNotification("open");
                                    $("#EMAIL").addClass("jqx-validator-error-element");
                                } else {
                                    $("#EMAIL").removeClass("jqx-validator-error-element");
                                    $.ajax({
                                        url: baseUrl + 'register/verify-captcha',
                                        type: 'post',
                                        data:{"_token":_token,"captcha":captcha},
                                        dataType: 'html',
                                        success: function(response) {
                                            if(response == 'false'){
                                                $("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
                                                $("#jqx-notification").jqxNotification();
                                                $('#jqx-notification').jqxNotification({position: 'bottom-left',template: "warning" });
                                                $('#jqx-notification').html("{{trans('register.invalid_code')}}");
                                                $("#jqx-notification").jqxNotification("open");
                                                $("#jqx-save").jqxButton({ disabled: false });
                                                refreshCaptcha();
                                            } else {
                                                document.getElementById("jqx-form").submit();
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    }
                });

                $('#jqx-save').on('click',function (e) {
                    $('#jqx-form').jqxValidator('validate');
                });



            });

		</script>

		<style>
			.jqx-validator-hint
			{
				height: 30px;
				padding-top: 4px;
				font-family: 'KHMERMEF1';
			}
			#captcha-reload{
				background: white;
				font-size: x-large;
				border-radius: 5px;
			}
		</style>
	</div>


	<div class="blg-main" style="display: none;">
		<div class="cssplay-menu" >
			<div class="blg-logo-middle">
				<img src="{{asset('images/middle.png')}}" class="logo-middle">
			</div>
			<div class="wrapper" id="wrapper-propeller">
				<input type="radio" id="c1" name="segment" checked="checked">
				<input type="radio" id="c2" name="segment">
				<input type="radio" id="c3" name="segment">
				<input type="radio" id="c4" name="segment">
				<input type="radio" id="c5" name="segment">
				<input type="radio" id="c6" name="segment">
				<input type="radio" id="c7" name="segment">
				<input type="radio" id="c8" name="segment">
				<input type="radio" id="c9" name="segment">
				<input type="radio" id="c10" name="segment">
				<input type="radio" id="c11" name="segment">
				<input type="radio" id="c12" name="segment">
				<input type="checkbox" id="toggle" checked="checked">
				<div class="holder">
					<div class="segment">
						<label class="piece" for="c1" data-head="" data-page="#all-form"><span></span></label>
						<label class="piece" for="c2" data-head="" data-page="#news"><span></span></label>
						<label class="piece" for="c3"​ data-head="" data-page=""><span></span></label>
						<label class="piece" for="c4" data-head="" data-page=""><span></span></label>
						<label class="piece" for="c5" data-head="" data-page=""><span></span></label>
						<label class="piece" for="c6" data-head="" data-page=""><span></span></label>
						<label class="piece" for="c7" data-head="" data-page=""><span></span></label>
						<label class="piece" for="c8" data-head="" data-page="#schedule"><span></span></label>
						<label class="piece" for="c9" data-head="" data-page=""><span></span></label>
						<label class="piece" for="c10" data-head="" data-page="#attendance-info"><span></span></label>
						<label class="piece" for="c11" data-head="" data-page=""><span></span></label>
						<label class="piece" for="c12" data-head="" data-page=""><span></span></label>

					</div>
					<div class="curve-lower">
						<div class="curve"></div>
					</div>
					<div class="curve-upper"></div>
					<label for="toggle" class="center"></label>
				</div>
			</div>
		</div>
	</div>
	<style>
		.header-title{
			font-family: 'KHMERMEF2';
			font-weight:normal;
			color:#347fb5;
			text-shadow: 1px 2px 1px #C0C7CA;
			font-size:28px;
			padding:0 0 0 60px;
			margin:30px 0 30px;
			line-height:1.8;
		}
		a.icon-emoji{
			margin-left: 15px;
		}
		.cssplay-menu .segment label{opacity: 0.4;}
		.form-register{ padding-left: 15px; padding-right: 15px; }
	</style>

	<script type="text/javascript">
        $(document).ready(function(e){
            $('#jqx-save').click(function(){
                str = $('#EMAIL').val();
                str = str.split('@').slice(1);
				var allowEmail=['mef.gov.kh'];
				if($.inArray(str[0],allowEmail) !==-1){
				    return 0;
				}else{
                    $("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
                    $("#jqx-notification").jqxNotification();
                    $('#jqx-notification').jqxNotification({position: 'top-right',template: "warning" });
                    $('#jqx-notification').html("{{trans('register.MEF_Email')}}");
                    $("#jqx-notification").jqxNotification("open");
                    $("#jqx-save").jqxButton({ disabled: false });
                    return false;
				}

            });
        });
	</script>
	
@endsection
