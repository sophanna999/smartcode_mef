<?php
$registerUrl = asset('register/get-register');
$forget_pw  = asset('register/reset-password');
?>
@extends('layout.smart-module-login')

@section('content')
    <!--Content left-->
    
	<div class="blg-left">
        @include('front-end.include.content-left-login')
    </div>
	<!-- Content center -->
	<input type="hidden" id="is_small_module" value="false" />
    <div class="blg-main">
        <div class="welcome-text">
            <h3 >សូមស្វាគមន៍ មកកាន់ការិយាល័យវៃឆ្លាត</h3>
            <p>សូមធ្វើការបំពេញព័ត៌មាននៅប្រអប់ខាងឆ្វេងដើម្បីប្រើប្រាស់ប្រព័ន្ធការិយាល័យវៃឆ្លាត<br />
            រឺធ្វើការ <span><a href="{{$registerUrl}}" class="col-red">ចុះឈ្មោះ</a></span>សម្រាប់អ្នកប្រើប្រាស់ថ្មី</p>
        </div>
        <div class="smart-logo-login">
            <img src="{{asset('images/smart-office-alpha.png')}}" alt="">
        </div>

        <div class="cssplay-menu" style="display:none">
          <!--   <div class="blg-logo-middle">
                <img src="images/middle.png" class="logo-middle">
           </div> -->
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
            <div class="blg-table">
                
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
		/* .blg-main{ pointer-events: none; } */
		.loginWrap button{ margin: 0px -9px 0; }
		a.link-forget-pw:hover{ color:#d43b29; }
        .cssplay-menu .segment label{opacity: 0.4;}
    </style>
    
    <?php
		$rootPath =$_SERVER['DOCUMENT_ROOT'].'/firebase-messaging-sw.js';
    ?>
    <script src="https://www.gstatic.com/firebasejs/5.2.0/firebase-app.js" defer></script>
    <script src="https://www.gstatic.com/firebasejs/5.2.0/firebase-messaging.js" defer></script>
    <script src="{{asset('js/loadfb.js')}}" defer>


    </script>

@endsection
