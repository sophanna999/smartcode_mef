<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="shortcut icon" href="{{asset('icon/mef.ico')}}" />

    <title>@yield('pageTitle', 'ការិយាល័យវៃឆ្លាត - ជំហានចាប់ផ្ដើមឆ្ពោះទៅកាន់រដ្ឋាភិបាលអេឡិកត្រូនិក')</title>
	<script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('jqwidgets/jqx-all.js')}}"></script>
	<script type="text/javascript" src="{{asset('jqwidgets/jqxcore.js')}}"></script>
	
	<link rel="stylesheet" href="{{asset('jqwidgets/styles/jqx.base.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('jqwidgets/styles/jqx.bootstrap.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/bootstrap-theme.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('css/normalize.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css" />
	
	<link href="{{ asset('/css/admin-login.css') }}" rel="stylesheet">

    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/script.js')}}"></script>
	
</head>
<body>

<input type="hidden" name="baseUrl" id="baseUrl" value="{{asset('')}}" />
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
<div id="jqx-loader"></div>
<div id="jqx-notification"></div>

<div id="login-content">
	@yield('login-content')
</div>	
</body>
</html>
