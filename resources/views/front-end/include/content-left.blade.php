<div class="top-left">
	<!-- <div id="small-circle"></div> -->
	<div class="menu-left-header">
		<div class="ministry-title">
			<p>ក្រសួងសេដ្ឋកិច្ចនិងហិរញ្ញវត្ថុ<br /><span class="en">Ministry of economy and finance</span></p>
		</div>
		<div class="main-logo">
			<img src="{{asset('images/smart-logo.png')}}" data-src="{{asset('images/logo-circle.png')}}" alt="ការិយាល័យវៃឆ្លាត">
		</div>
	</div>
	<div class="prf-info pt10">
		<div class="photo">
			<img src="{{$getMyProfile->avatar != '' ? asset($getMyProfile->avatar) : asset('images/image-profile.jpg')}}">
		</div>
		<div class="prf-status">
			<div class="profile-info">
				<h5>{{$getMyProfile->full_name_kh}}</h5>
				<p>{{$getMyProfile->position}}</p>
				<p>{{$getMyProfile->department_name}}</p>
				<p>{{$getMyProfile->general_department_name}}</p>
			</div>
			<!-- <p>{{trans('trans.use_date')}}:  {{$last_login_date}}</p> -->
			<div class="link-feature" >
				@if(session('sessionGuestUser')->is_admin)
					<li class="link-to-admin"><a href="{{ url('/switch') }}" >{{ trans('general.admin_page') }}</a></li>
				@endif
				<li class="link-setting" style="margin-left: -2px"><a id="link-setting" href="{{ url('/profile/change-password') }}" >{{trans('trans.change_password')}}</a></li>
				<li class="link-logout"><a href="{{asset('register/guest-logout')}}" >{{trans('trans.logout')}}</a></li>
				
			</div>
		</div>
	</div>
	<!--prf-info-->
</div>
<!--top-left-->
<div class="layer">
<div class="wrap-layer">
		<div class="layer1 layerPath" data-page="">
			<p><img src="{{asset('images/white/builder.png')}}" alt="icon"><span>កសាងសមត្ថភាព</span></p>
		</div>
		<div class="layer2 layerPath" data-index="2">
			<p><img src="{{asset('images/white/fmis.png')}}" alt="icon" style="position:relative; top: 20px; width: 65px;"><span>ប្រព័ន្ធ FMIS</span></p>
		</div>
		<div class="layer3 layerPath" data-index="3">
			<p><img src="{{asset('images/white/briefcase.png')}}" alt="icon"><span>បេសកកម្ម</span></p>
		</div>
		<div class="layer4 layerPath" data-index="4">
			<p><img src="{{asset('images/white/book.png')}}" alt="icon"><span>ឯកសារ</span></p>
		</div>
		<div class="layer5 layerPath" data-page="#/schedule">
			<p><img src="{{asset('images/white/calendar.png')}}" alt="icon"><span>កាលវិភាគ</span></p>
		</div>
		<div class="layer6 layerPath" >
			<p><img src="{{asset('images/white/monitor-with-stats.png')}}" alt="icon"><span>ធនធាន</span></p>
		</div>
		<div class="layer7 layerPath" data-page="#/attendance-info">
			<p><img src="{{asset('images/white/hourglass-2.png')}}" alt="icon"><span>វត្តមាន</span></p>
		</div>
		<div class="layer8 layerPath" >
			<p><img src="{{asset('images/white/list-1.png')}}" alt="icon"><span>ការងារ</span></p>
		</div>
		<div class="layer9 layerPath" >
			<p><img src="{{asset('images/white/scheme-1.png')}}" alt="icon"><span>ចែករំលែក</span></p>
		</div>
		<div class="layer10 layerPath" data-page="#/all-form" >
			 <p><img src="{{asset('images/white/hierarchical-structure-3.png')}}" alt="icon"><span>ធនធានមនុស្ស</span></p>
		</div>
		<div class="layer11 layerPath" data-index="11" data-page="#/news">
			<p><img src="{{asset('images/white/smartphone-1.png')}}" alt="icon"><span>ដំណឹង</span></p>
		</div>
		<div class="layer12 layerPath" >
			<p><img src="{{asset('images/white/newspaper.png')}}" alt="icon"><span>របាយការណ៍</span></p>
		</div>
		<div class="layer13 layerPath" >
		</div>
	</div>
</div>
<!--layer-->
<div class="prf-detail" >
	<div class="custom-container vertical">
		<div class="carousel">
			<!-- <ul class="bxslider">
				<li>
					<div class="detail">
						<img src="images/icn-kbach.png" alt="">
						<ul>
							<p>បេសកកម្មនៅខេត្តកណ្ដាលលើការ ស្រង់អចលនទ្រព្យ</p>
							<p>ជួបលោក សេង ហុក អគ្គ.ថវិកា ស្ដីពីការរៀបចំថវិកាកម្មវិធី 9:00 AM</p>
							<p>ចូលរួមវគ្គបណ្ដុះបណ្ដាលគណនេយ្យ</p>
						</ul>
					</div>
				</li>
				<li>
					<div class="detail">
						<img src="images/icn-kbach.png" alt="">
						<ul>
							<p>អាណត្តិទូទាត់ជូនក្រុមហ៊ុន ABC</p>
							<p>របាយការណ៍កិច្ចប្រជុំផ្ទៃក្នុងនាយកដ្ឋាននីតិកម្ម</p>
							<p>ប្រកាសលេខ ៦២២ សហវ.ប្រក ចុះថ្ងៃទី ៣១ ខែឧសភា ឆ្នាំ ២០១៦ ស្ដីពី​ការ​បែងចែក​ភារកិច្ច​របស់​អនុរដ្ឋលេខាធិការ​</p>
						</ul>
					</div>

				</li>
				<li>
					<div class="detail">
						<img src="images/icn-kbach.png" alt="">
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
						<img src="images/icn-kbach.png" alt="">
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
	<p>&copy; ២០១៨ រក្សាសិទ្ធិដោយ៖ <br />នាយកដ្ឋានបច្ចេកវិទ្យាព័ត៌មាននៃអគ្គលេខាធិការដ្ឋាន</p>
	
</div>
<script>
	$(document).ready(function(){
		$("#link-setting").click(function(){
			sessionStorage.removeItem("click_index");
		});

		$(".link-logout").click(function(){
			sessionStorage.removeItem("click_index");
		});

	});
</script>