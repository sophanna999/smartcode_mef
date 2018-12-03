@extends('layout.smart-module-login')
@section('content')
    <!--Content left-->
	<div class="blg-left">
        @include('front-end.include.content-left-login')
    </div>

	<!-- Content center -->
	<input type="hidden" id="is_small_module" value="false" />
	<div class="blg-main">
		<div class="container-fluid">
			<div class="row" style="margin-top: 20%;">
				<div class="col-sm-offset-3 col-sm-6 login-wrapper ">
					<div class="panel panel-default bg-forget-pwd">
						<div class="panel-body">
							@if (count($errors) > 0)
								<div class="alert alert-danger">
									<button type="button" class="close font-sans-serif" data-dismiss="alert" aria-hidden="true">&times;</button>
									<ul>
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
							<form role="form" method="POST" action="{{ url('register/reset-password-action') }}">
								<input type="hidden" id="hashkey" name="hashkey" value="{{$hashkey}}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group mb30">
									<label for="input-email">ពាក្យសម្ងាត់</label>
									<div class="input-group">
										<span class="input-group-addon bg-green"><i class="glyphicon glyphicon-lock"></i></span>
										<input type="password" name="password" id="password" required="" class="form-control input-lg " placeholder="ពាក្យសម្ងាត់" autofocus />
									</div>
								</div>
								<div class="form-group">
									<label for="input-email">បញ្ជាក់ពាក្យសម្ងាត់ម្ដងទៀត</label>
									<div class="input-group">
										<span class="input-group-addon bg-green"><i class="glyphicon glyphicon-lock"></i></span>
										<input type="password" name="confirm_password" id="confirm_password" required="" class="form-control input-lg" placeholder="បញ្ជាក់ពាក្យសម្ងាត់ម្ដងទៀត" autofocus />
									</div>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary pull-right ff">រក្សាទុកពាក្យសម្ងាត់ថ្មី</button>
								</div>
							</form>
						</div>
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
    </style>
    <!--Content right-->
	@include('front-end.include.notification')

@endsection