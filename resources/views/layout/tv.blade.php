<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="shortcut icon" href="{{asset('icon/mef.ico')}}" />
	<link href="{{asset('css/style-tv.css')}}" type="text/css" rel="stylesheet" />
	<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" type="text/css" media="screen">
	<link rel="stylesheet" href="{{asset('css/simple.min.css')}}" type="text/css" media="screen">
	<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/animate.css')}}" type="text/css">
    
	<title>ក្រសួងសេដ្ឋកិច្ច និងហិរញ្ញវត្ថុ</title>
	<script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
     <script type="text/javascript" src="{{asset('js/jquery.marquee.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.bootstrap.newsbox.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/jquery.cycle.all.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/jquery-dateFormat.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/jquery-blink.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/jquery.easing.min.js')}}"></script>
	{{--<script type="text/javascript" src="{{asset('app/app.js')}}"></script>--}}
   
	<script type="text/javascript" src="{{asset('js/script-tv.js')}}"></script>
   
   
	<style type="text/css">
		@font-face {
			font-family: 'KhmerOSBattambang';
			src: url({{asset('fonts/KhmerOSBattambang.ttf')}}') format('truetype');
		}
		@font-face {
		  font-family: 'KHMERMEF1';
		  src:  url({{asset('fonts/KHMERMEF1.woff')}}) format('truetype');
		}
		@font-face {
		  font-family: 'KHMERMEF2';
		  src:  url({{asset('fonts/KHMERMEF2.woff')}}) format('truetype');
		}
		body{
			color:#000000;
			margin:0;
			padding:0;
			font-family:KHMERMEF1;
			}
		.row{
				padding:0;
				background-color:none !important;
				font-family:KHMERMEF1;
				font-size:23px;
			}

		.date-expir
			{
				border-bottom:1px solid #F4F4F4;
				background-color:#f4f2f4;
				color:#CFC7C7;
				font-size:23px;
				margin:0 7px 7px 0;
				padding:20px;
				box-shadow:0 2px 0 1px #D9D5D5;
				border-radius:3px;

			}
		.date-meeting
			{

				border-bottom:1px solid #F4F4F4;
				font-size:23px;
				background-color:#dff0d8;
				margin:0 7px 7px 0;
				padding:20px;
				box-shadow:0 2px 0 1px #DCD1D1;
				border-radius:3px;

			}
		.date-urgent
			{
				border-bottom:1px solid #F4F4F4;
				margin:0 7px 7px 0;
				font-size:23px;
				background-color:#F0DFC6;
				padding:20px;
				box-shadow:0 2px 0 1px #DCD1D1;
				border-radius:3px;
			}
		.date-urgent p
			{
				line-height:35px;
				font-size:23px;
			}
		.date-meeting p
			{

				line-height:35px;
				font-size:23px;

			}
		.date-expir p
			{
				line-height:35px;
				font-size:23px;

			}
		.badge-expir{
				background-color:#CACBCA;
				padding:5px;
				font-size:23px;

			}
		.badge-meeting
			{
				background-color:#2DA81A;
				padding:5px;
				font-size:23px;

			}
		.badge-urgent
			{
				background-color:#F0B258;
				padding:5px;
				font-size:23px;


			}
		.meeting-group
			{
				font-size:20px;
				line-height:25px;
				margin-top:5px;


			}
		.urgent
			{
				color:#F71418;
				font-weight:bold;
				font-size:23px;
				margin-left:-0px;
			}
		.program
			{
				/*font-family:KHMERMEF2;*/
				margin-left:-150px;
				font-size:20px;
			}
		.leader
			{
				/*font-family:KHMERMEF2;*/
				margin-left:-0px;
				font-size:20px;
			}
		.place
			{

				margin-left:-130px;
				font-size:20px;
			}
		.pull-left
			{
				padding:5px;
			}

		div ul li
			{
				overflow:hidden;

			}
		.cover
			{
				background-image: url({{asset('images/cover.jpg')}});
				background-size: cover;
    			background-position: center center;
    			margin-top:-3px;
			}
		p {
			line-height: 40px;
			text-align: justify;
			color: #ffffff;
		}
		i {
			margin-top: 2px;
		}
		.col-md-5 ul li
			{
				color: #ffffff;
				line-height: 54px;
			}
		.footer_marquee
			{
				background: url({{asset('images/footer_marquee.png')}}) no-repeat bottom left;
				background-size: 300px 70px;
				background-color:#35A58E;
				color:#ffffff;
				height: 67px;
				margin-top:-19px;

			}
		.my_meeting
			{
				background-color: #1a6b5a;	

			}
		.meeting1 p
			{
				line-height: 10px;
			}
		.col-md-11 p
			{
				line-height: 10px;
				margin-top: 15px;
			}
		.glyphicon
			{
				margin-right:4px !important; /*override*/
			}
			
			.pagination .glyphicon
			{
				margin-right:0px !important; /*override*/
			}
			
			.pagination a
			{
				color:#555;
			}
			
			.panel ul
			{
				padding:0px;
				margin:0px;
				list-style:none;
			}
			
			.news-item
			{
			
				margin:0px;
				
			}
					
	</style>
	
</head>
<body>
<input type="hidden" name="baseUrl" id="baseUrl" value="{{asset('')}}" />
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
<div id="container">
	<div id="header">
		<div class="banner">
			<img class="logo" src="{{asset('images/mef-logo.png')}}" width="60" height="60" alt="ក្រសួងសេដ្ឋកិច្ច និង ហិរញ្ញវត្ថុ" />
			<h1 class="title-kh">ក្រសួងសេដ្ឋកិច្ច និង ហិរញ្ញវត្ថុ</h1>
			<h1 class="title-kh">អគ្គលេខាធិការដ្ឋាន</h1>
            <h1 class="title-kh" style="font-size:17px">នាយកដ្ឋានបច្ចេកវិទ្យាព័ត៌មាន</h1>
		</div>
		<h1 class="m-title">កម្មវិធីប្រចាំសប្ដាហ៍</h1>
		<div class="clock">
			<ul>
				<li id="hours"> </li>
				<li id="point">:</li>
				<li id="min"> </li>
				<li id="point">:</li>
				<li id="sec"> </li>
			</ul>
			<div id="Date"></div>
		</div>
	</div>
		 @yield('content')
			<!-- <div id="footer" style="margin-top: 40px">
				<p class="rp"><span style="font-family:'Khmer OS Battambang', Arial, Helvetica, sans-serif;'">©</span> រក្សាសិទ្ធ៖ នាយកដ្ឋានព័ត៌មានវិទ្យា នៃក្រសួងសេដ្ឋកិច្ច និងហិរញ្ញវត្ថុ</p>
			</div> -->
		

</div>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
		$('.marquee').marquee({
			duration: 40000,
			gap: 150,
			delayBeforeStart: 0,	
			direction: 'left',
			duplicated: true
		});
        $(".demo1").bootstrapNews({
            newsPerPage:2,
            autoplay: true,
			pauseOnHover:true,
            direction: 'up',
            newsTickerInterval: 5000,
			pauseOnHover: false,
            onToDo: function () {
               //console.log(this);
            },

        });
		 $(".demo2").bootstrapNews({
            newsPerPage:9,
            autoplay: true,
			pauseOnHover:true,
            direction: 'up',
            newsTickerInterval: 5000,
			pauseOnHover: false,
            onStop: function () {
                console.log(1);
            },

        });

		
    });
</script>

</body>
</html>