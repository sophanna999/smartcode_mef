<style>
    h4{
        font-size: 17px;
        background: -webkit-linear-gradient(#eee, #333);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 35px !important;
    }

</style>
@extends('layout.admin-login')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-offset-4 col-sm-4 login-wrapper ">
            	<div class="text-center">
           			<img src="{{asset('images/logo-circle.png')}}" width="140px" >
                </div>
               <h3 class="hdr-admin-login">
                   ការិយាល័យវៃឆ្លាត
               </h3>
                <h4 style="text-align: center">
                    ជំហានចាប់ផ្ដើមឆ្ពោះទៅកាន់រដ្ឋាភិបាលអេឡិកត្រូនិក
                </h4>

               <hr/>
                <div class="panel panel-default no-border">
                    <div class="panel-body wrap-login">
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
                        <form role="form" method="POST" action="{{ url('/auth/login') }}" style="position: relative;">
							<input type="hidden" id="mismatch" name="mismatch" value="true">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <div class="input-group txt-box"><span class="input-group-addon icn-box no-border"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="text" name="user_name" id="user_name" value="" required="" class="form-control input-lg no-border" placeholder="{{trans('users.userName')}}" autofocus />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group txt-box"><span class="input-group-addon icn-box no-border"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" class="form-control input-lg no-border" name="password" id="password" required="" placeholder="{{trans('users.password')}}" />
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn-admin-login"><img src="{{asset('images/arrow-login.png')}}"></button>
                            </div>
                        </form>
                    </div>
                </div>
                <h5><span>ឬចូលទៅកាន់</span></h5>
                <div class="col-sm-12 text-center">
                    <a href="{{ url('/') }}" class="btn btn-primary"​>ការិយាល័យវៃឆ្នាត</a>
                </div>
            </div>
        </div>
    </div>
    <style>
        input[type=password]
        {
            font-family: 'time new roman' !important;
        }
        ::placeholder{
            font-family: 'KHMERMEF1';
        }
        h5 {
        width: 60%; 
        text-align: center; 
        border-bottom: 1px solid #dadada; 
        line-height: 0.1em;
        margin: 10px 20% 20px; 
        } 

        h5 span { 
            background:#fff; 
            padding:0 10px; 
        }
    </style>
@endsection
