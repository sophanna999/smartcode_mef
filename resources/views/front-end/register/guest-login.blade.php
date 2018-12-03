@extends('layout.guest-login')
@section('title', 'Page Login')
@section('login-content')
<?php
$registerUrl = asset('register/get-register');
$forget_pw  = asset('register/reset-password');
?>
<div class="wrapper-guest-login">
<div class="container-fluid">
        <div class="row">
            <div class="login-wrapper login-mb login-pc">
            	
                <div class="panel panel-default bg-login-form">
                	<div class="img-login">
                    	<img src="images/bg-login.jpg">
                    </div>
                    <div class="panel-body bg-login">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <button type="button" class="close font-sans-serif" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <ul style="list-style: none !important;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
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
                        <form role="form" method="POST" action="{{ url('/auth/guest-login') }}">
							<input type="hidden" id="type" name="type" value="0">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <!--<label for="input-username">អ្នកប្រើប្រព័ន្ធ</label>-->
                                <div class="input-group col-lg-12 col-md-12 col-xs-12">
									<!--<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>-->
                                    <input type="text" name="user_name" value="" id="user_name" required="" class="form-control input-lg" placeholder="អ្នកប្រើប្រព័ន្ធ" autofocus />
                                </div>
                            </div>
                            <div class="form-group">
                                <!--<label for="input-password">ពាក្យសម្ងាត់</label>-->
                                <div class="input-group col-lg-12 col-md-12 col-xs-12" >
									<!--<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>-->
                                    <input type="password" class="form-control input-lg" value="" name="password" id="password" required="" placeholder="ពាក្យសម្ងាត់" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                           		<div class="row">
                                    <button type="submit" class="btn-custom"> ចូលប្រព័ន្ធ</button>
                            	</div>
                            </div>
                          
                    </div>
                </div>
                  <div class="col-lg-6 col-xs-12 bot-form pull-right">
                        <div class="">
                            <div class="form-group pull-right col-lg-8 col-xs-8 col-md-8">
                                <div class="row">
                                    <div class="pull-right">
                                        <p class="txt-login-form">មិនទាន់មានគណនេយ្យសូមមេត្តា <span><button type="button" class="btn-reg-custom" id="btn-register">ចុះឈ្មោះ</button></span>ត្រង់នេះ</p>
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xs-4 col-md-4 form-group from-group-forget-pw pull-left">
                                <div class="row">
                                    <a class="forget-pw lost-pwd" href="{{$forget_pw}}"> ភ្លេចពាក្យសម្ងាត់</a>
                                </div>
                            </div>
                    </div>
                   </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
	.btn {
		padding: 5px 10px !important;
		margin-left: 0px !important;
		font-family: 'KhmerOSBattambang';
	}
   #btn-register{
	  cursor: pointer;
	  font-family: 'KhmerOSBattambang';
   }
   #user_name{
	   padding:10px 16px;
   }
   .from-group-forget-pw{ margin-bottom: 0 }
</style>
<script>

    $(function(){
		$('#btn-register').on('click',function(){
			window.location = '{{$registerUrl}}';
		});
	});
    
</script>
@endsection