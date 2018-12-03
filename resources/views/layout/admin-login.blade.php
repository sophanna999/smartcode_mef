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

    <title>ការិយាល័យវៃឆ្លាត</title>

    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/bootstrap-theme.css')}}" type="text/css" />
	<link href="{{ asset('/css/admin-login.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
</head>
<body>
<input type="hidden" name="base-url" id="baseUrl" value="{{asset('')}}" />

@yield('content')

</body>
</html>
