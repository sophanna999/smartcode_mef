@extends('layout.admin-login')
@section('content')
   <div class="container">
        <div class="card card-container" id="accountLogin">
            <img id="profile-img" class="profile-img-card" src="{{asset('images/logo-circle.png')}}" />
			<h3 class="hdr-admin-login">{{trans('trans.project_name')}}<br /><span>{{trans('trans.institude_name_kh')}}</span></h3>
            <hr/>
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<button type="button" class="close font-sans-serif" data-dismiss="alert" aria-hidden="true">&times;</button>
					<ul>
						@foreach ($errors->all() as $error)
							<li style="list-style: none;font-family: KHMERMEF1;">{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			@if (Session::has('flash_notification.message'))
				<div class="alert alert-{{ Session::get('flash_notification.level') }}">
					<button type="button" class="close font-sans-serif" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{ Session::get('flash_notification.message') }}
				</div>
			@endif
            <form class="form-signin" autocomplete="off">
				<input type="hidden"  id="baseUrl" value="{{asset('')}}" />
				<input type="hidden" id="token" value="{{ csrf_token() }}">
				<input type="hidden" id="mismatch" name="mismatch" value="true">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text" id="user_name" name="user_name" class="form-control" placeholder="{{trans('users.userName')}}" required autofocus>
                <input type="password" id="password" name="password" class="form-control" placeholder="{{trans('users.password')}}" required>
				<label style="display: flex;color: #29748c;font-size: small; vertical-align: text-top;"><input class="checkbox" id="remember_me" type="checkbox" style="margin-top: 2px !important;"> {{trans('trans.remember_me')}}</label>
	            {{--<label><input type="checkbox" id="remember">ចងចាំពាក្យសម្ងាត់</label>--}}
                <button class="btn btn-lg btn-primary btn-block btn-signin" id="loginButton" type="submit">ចូលប្រព័ន្ធ</button>
            </form><!-- /form -->
            
        </div><!-- /card-container -->
    </div><!-- /container -->
	<style>
		/*
		 * Specific styles of signin component
		 */
		/*
		 * General styles
		 */
		body, html {
			height: 100%;
			background-repeat: no-repeat;
			background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));
		}

		.card-container.card {
			max-width: 350px;
			padding: 40px 40px;
		}

		.btn {
			font-weight: 700;
			height: 36px;
			-moz-user-select: none;
			-webkit-user-select: none;
			user-select: none;
			cursor: default;
		}

		/*
		 * Card component
		 */
		.card {
			background-color: #F7F7F7;
			/* just in case there no content*/
			padding: 20px 25px 30px;
			margin: 0 auto 25px;
			margin-top: 50px;
			/* shadows and rounded borders */
			-moz-border-radius: 2px;
			-webkit-border-radius: 2px;
			border-radius: 2px;
			-moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			-webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		}

		.profile-img-card {
			width: 96px;
			height: 96px;
			margin: 0 auto 10px;
			display: block;
			-moz-border-radius: 50%;
			-webkit-border-radius: 50%;
			border-radius: 50%;
		}

		/*
		 * Form styles
		 */
		.profile-name-card {
			font-size: 16px;
			font-weight: bold;
			text-align: center;
			margin: 10px 0 0;
			min-height: 1em;
		}

		.reauth-email {
			display: block;
			color: #404040;
			line-height: 2;
			margin-bottom: 10px;
			font-size: 14px;
			text-align: center;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
			-moz-box-sizing: border-box;
			-webkit-box-sizing: border-box;
			box-sizing: border-box;
		}

		.form-signin #inputEmail,
		.form-signin #inputPassword {
			direction: ltr;
			height: 44px;
			font-size: 16px;
		}

		.form-signin input[type=email],
		.form-signin input[type=password],
		.form-signin input[type=text],
		.form-signin button {
			width: 100%;
			display: block;
			margin-bottom: 10px;
			z-index: 1;
			position: relative;
			-moz-box-sizing: border-box;
			-webkit-box-sizing: border-box;
			box-sizing: border-box;
		}

		.form-signin .form-control:focus {
			border-color: rgb(104, 145, 162);
			outline: 0;
			-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
			box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
		}

		.btn.btn-signin {
			/*background-color: #4d90fe; */
			background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));
			padding: 0px;
			font-weight: 700;
			font-size: 14px;
			height: 36px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			border-radius: 3px;
			border: none;
			-o-transition: all 0.218s;
			-moz-transition: all 0.218s;
			-webkit-transition: all 0.218s;
			transition: all 0.218s;
		}
		input[type=password]
		{
			font-family: 'time new roman' !important;
		}
		::placeholder{
			font-family: 'KHMERMEF1';
		}

	</style>
	<script>
        $( document ).ready(function() {

			if(localStorage.getItem('tvusername') != '' || localStorage.getItem('tvusername') != 'undefined'){
                $('#remember_me').attr('checked', 'checked');
			}
        });
        $("#loginButton").on("click", function (e) {

            e.preventDefault();
            var accountLogin = $("#accountLogin");

            $(this).html("សូមរង់ចាំ ...").attr("disabled", "disabled");
            var data = {
                "_token":$.trim(accountLogin.find("#token").val()),
                "user_name": $.trim(accountLogin.find("#user_name").val()),
                "password": $.trim(accountLogin.find("#password").val())
            };
            var baseUrl = $.trim(accountLogin.find("#baseUrl").val());
            $.ajax({
                type: "POST",
				url: baseUrl + 'tv/login',
                dataType: "json",
                data: data,
                success: function(json) {
                    if(json.code == 1){
                        window.location.replace(baseUrl+'tv/schedule');
                        if ($('#remember_me').is(':checked')) {
                            // save username and password
                            localStorage.tvusername = $.trim(accountLogin.find("#user_name").val());
                        } else {
                            localStorage.tvusername = '';
                        }
					}
                },
                error: function(data) {
                    console.log(data);
                    document.getElementById("loginButton").disabled = false;
                    $("#loginButton").html("ចូលប្រព័ន្ធ");
                }
			})
        });


//		var username = $("#user_name").text();
//		var pass = $("#password").text();
//
//		$("#remember").click(function(){
//			document.cookie = "firebaseToken="+currentToken;
//		});
	</script>
	
@endsection
