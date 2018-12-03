<style>.layerPath{cursor:auto;}</style>
<script>
    $(document).ready(function() {
        var elements = document.getElementsByName("user_name");
        var elements1 = document.getElementsByName("password");
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity("សូមបំពេញឈ្មោះរបស់អ្នក");
				}
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }
        for (var i = 0; i < elements1.length; i++) {
            elements1[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity("សូមបំពេញាពាក្យសម្ងាត់របស់អ្នក");
				}
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }
	})
</script>
<?php
	$registerUrl = asset('register/get-register');
	$forget_pw  = asset('register/reset-password');
?>
<div class="top-left">
	<!-- <div id="small-circle"></div> -->
	<div class="menu-left-header">
		<div class="ministry-title">
			<p>ក្រសួងសេដ្ឋកិច្ច និងហិរញ្ញវត្ថុ<br /><span class="en">Ministry of economy and finance</span></p>
		</div>
		<div class="main-logo">
			<img src="{{asset('images/logo-circle.png')}}" alt="logo" class="logo-circle animated bounceIn">
			<img src="{{asset('images/smart-logo.png')}}" alt="ការិយាល័យវៃឆ្លាត">
		</div>
	</div>
	<div class="prf-info">
		<div class="loginWrap">
			<form role="form" method="POST" action="{{ url('/auth/guest-login') }}">
				<input type="hidden" id="mismatch" name="mismatch" value="false">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="input-group input-group-login">
					<span class="input-group-addon bg-green-login"><i class="glyphicon glyphicon-user"></i></span>
					<input class="form-control input-lg" type="text" name="user_name" id="txtName" placeholder="{{trans('users.userName')}}" required autofocus  />
				</div>
				@if(isset($login_page))
				@if (count($errors) > 0)
					<div class="alert  alert-custom">
						<!-- <button type="button" class="close font-sans-serif" data-dismiss="alert" aria-hidden="true">&times;</button> -->
						<ul style="padding-left: 5px;">
							@foreach ($errors->all() as $error)
								<li style="font-family: 'KHSiemreap';list-style: none;">{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				@if (Session::has('flash_notification.message'))
					<div class="alert alert-{{ Session::get('flash_notification.level') }} alert-custom">
						<!-- <button type="button" class="close font-sans-serif" data-dismiss="alert" aria-hidden="true">&times;</button> -->
						{{ Session::get('flash_notification.message') }}
					</div>
				@endif
			@endif
				<div class="input-group input-group-login">
					<span class="input-group-addon bg-green-login"><i class="glyphicon glyphicon-lock"></i></span>
					<input class="form-control input-lg" type="password" name="password" id="txtPwd" placeholder="{{trans('users.password')}}" required="" />
				</div>
				<p>មិនទាន់មានគណនីសូមមេត្តា <a href="{{$registerUrl}}" class="col-red">ចុះឈ្មោះ</a></p>
				
				<button type="submit" class="btn-box-sign">ចូលប្រព័ន្ធ</button>
				<a href="{{$forget_pw}}" style="display: block; margin-top: 6px; text-decoration: underline;" class="font12 col-red link-forget-pw">ភ្លេចពាក្យសម្ងាត់</a>
				<ul style="list-style-type:none;
				list-style-type: none;
				width: 110px;
				margin: 10px auto 10px ;
				padding: 0;">
					<li class="link-to-admin" style="margin-left:10px;"><a style="font-size:12px" href="{{ url('/auth') }}">{{ trans('general.admin_page') }}</a></li>
				</ul>
				
			</form>
			
		</div><!--loginWrap-->
	</div>
	<!--prf-info-->
</div>
<!--top-left-->
<div class="layer">
	<div class="wrap-layer">
		<div class="layer1 layerPath"></div>
		<div class="layer2 layerPath"></div>
		<div class="layer3 layerPath"></div>
		<div class="layer4 layerPath"></div>
		<div class="layer5 layerPath"></div>
		<div class="layer6 layerPath" ></div>
		<div class="layer7 layerPath" ></div>
		<div class="layer8 layerPath" ></div>
		<div class="layer9 layerPath" ></div>
		<div class="layer10 layerPath" ></div>
		<div class="layer11 layerPath" ></div>
		<div class="layer12 layerPath" ></div>
	</div>
</div>
<!--layer-->
<div class="prf-detail" >
	<div class="custom-container vertical">
		<div class="carousel">
			<!-- <ul class="bxslider">
				<li>
					<div class="detail">
						<img src="{{asset('images/icn-kbach.png')}}" alt="">
						<ul>
							<p>បេសកកម្មនៅខេត្តកណ្ដាលលើការ ស្រង់អចលនទ្រព្យ</p>
							<p>ជួបលោក សេង ហុក អគ្គ.ថវិកា ស្ដីពីការរៀបចំថវិកាកម្មវិធី 9:00 AM</p>
							<p>ចូលរួមវគ្គបណ្ដុះបណ្ដាលគណនេយ្យ</p>
						</ul>
					</div>
				</li>
				<li>
					<div class="detail">
						<img src="{{asset('images/icn-kbach.png')}}" alt="">
						<ul>
							<p>អាណត្តិទូទាត់ជូនក្រុមហ៊ុន ABC</p>
							<p>របាយការណ៍កិច្ចប្រជុំផ្ទៃក្នុងនាយកដ្ឋាននីតិកម្ម</p>
							<p>ប្រកាសលេខ ៦២២ សហវ.ប្រក ចុះថ្ងៃទី ៣១ ខែឧសភា ឆ្នាំ ២០១៦ ស្ដីពី​ការ​បែងចែក​ភារកិច្ច​របស់​អនុរដ្ឋលេខាធិការ​</p>
						</ul>
					</div>

				</li>
				<li>
					<div class="detail">
						<img src="{{asset('images/icn-kbach.png')}}" alt="">
						<ul>
							<p>ប្រាក់បៀវត្សប្រចាំខែ សីហា ២០១៦</p>
							<p>ប្រាក់បំណាច់មុខងារប្រចាំខែ កក្កដា</p>
							<p>វិក័យបត្រអគ្គិសនី</p>
							<p>វិក័យបត្រទឹក</p>
							<p>ន្ធលើមធ្យោបាយដឹកជញ្ជូន</p>
							<p>ពន្ធអចលនទ្រព្យ</p>
						</ul>
					</div>
				</li>
                <li>
					<div class="detail">
						<img src="{{asset('images/icn-kbach.png')}}" alt="">
						<ul>
							<p>អាណត្តិទូទាត់ជូនក្រុមហ៊ុន ABC</p>
							<p>របាយការណ៍កិច្ចប្រជុំផ្ទៃក្នុងនាយកដ្ឋាននីតិកម្ម</p>
							<p>ប្រកាសលេខ ៦២២ សហវ.ប្រក ចុះថ្ងៃទី ៣១ ខែឧសភា ឆ្នាំ ២០១៦ ស្ដីពី​ការ​បែងចែក​ភារកិច្ច​របស់​អនុរដ្ឋលេខាធិការ​</p>
						</ul>
					</div>
				</li>
			</ul> -->


		</div>
	</div>
</div>

<div class="copy-right">
	<p style="margin-bottom:0">&copy; ២០១៨ រក្សាសិទ្ធិដោយ៖ <br />នាយកដ្ឋានបច្ចេកវិទ្យាព័ត៌មាន នៃអគ្គលេខាធិការដ្ឋាន</p>
	
	<a style="font-style:italic;color:#C2DFD9;font-size:12px" href="{{asset('privacy-policy')}}" target="_blank">Privacy Policy</a>
</div>