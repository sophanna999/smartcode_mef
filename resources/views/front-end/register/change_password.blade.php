<style>
    .contain-color {
        background-color: #f1f1f1;
        padding: 2.01em 16px;
        margin: 20px 0;
        box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;
    }
</style>

@extends('layout.smart-module')
@section('content')
    <div class="clickLeft">
        <img src="{{asset('images/arrow-point-to-right.png')}}"  alt="">
    </div>
    <!--Content left-->
    <div class="clickLeft">
            <img src="{{asset('images/arrow-point-to-right.png')}}" alt="arrow">
        </div>
	<div class="blg-left">
        @include('front-end.include.content-left')
    </div>

	<!-- Content center -->
	<input type="hidden" id="is_small_module" value="false" />
	<div class="blg-main">
		<div class="container-fluid">
			<div class="row" style="margin-top: 10%;">

                    <div class="col-sm-offset-2 col-sm-8 login-wrapper">
                        <div class="contain-color">
                            <div class="panel panel-default bg-forget-pwd">
                            <div class="panel-title ttl-change-pwd">
                                <h3 class="text-center">
                                    ផ្លាស់ប្តូរពាក្យសម្ងាត់
                                </h3>
                                </panel>
                                <div class="panel-body">
                                    @if (Session::has('message'))
                                        <div class="alert alert-success }}">
                                            {{ Session::get('message') }}
                                        </div>
                                    @endif
                                    <form role="form" class="form-horizontal" method="POST" action="{{ url('profile/change-password') }}">
                                        <input type="hidden" id="type" name="type" value="0">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group @if($errors->has('old_password')) has-error  @endif">
                                            <label for="old_password" class="col-sm-5 text-right control-label col-form-label">ពាក្យសម្ងាត់បច្ចុប្បន្ន</label>
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon bg-green"><i class="glyphicon glyphicon-lock"></i></span>
                                                    <input placeholder="ពាក្យសម្ងាត់បច្ចុប្បន្ន" type="password" name="old_password" value="{{ old('old_password') }}" class="form-control input-lg" placeholder="" autofocus />
                                                </div>
                                                @if($errors->has('old_password'))
                                                    <div class="help-block">{{ $errors->first('old_password') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group @if($errors->has('new_password')) has-error  @endif">
                                            <label for="new_password" class="col-sm-5 text-right control-label col-form-label">ពាក្យសម្ងាត់ថ្មី</label>
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon bg-green"><i class="glyphicon glyphicon-lock"></i></span>
                                                    <input placeholder="ពាក្យសម្ងាត់ថ្មី" type="password" name="new_password" value="{{ old('new_password') }}"  class="form-control input-lg" placeholder="" />
                                                </div>
                                                @if($errors->has('new_password'))
                                                    <div class="help-block">{{ $errors->first('new_password') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group @if($errors->has('new_password_confirmation')) has-error  @endif">
                                            <label for="new_password_confirmation" class="col-sm-5 text-right control-label col-form-label">បញ្ជាក់ពាក្យសម្ងាត់ថ្មី</label>
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon bg-green"><i class="glyphicon glyphicon-lock"></i></span>
                                                    <input placeholder="បញ្ជាក់ពាក្យសម្ងាត់ថ្មី" type="password" name="new_password_confirmation" value="{{ old('new_password_confirmation') }}"  class="form-control input-lg" placeholder="" />
                                                </div>
                                                @if($errors->has('new_password_confirmation'))
                                                    <div class="help-block">{{ $errors->first('new_password_confirmation') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-6 col-sm-5">
                                                <button type="submit" class="btn btn-lg btn-success btn-box-save pull-right"><i class="fa fa-save"></i> រក្សាទុក</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>


		</div>
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
        .form-group{
	        margin-bottom:25px !important;
        }
    </style>
    
    <!--Content right-->
    @include('front-end.include.notification')

@endsection
