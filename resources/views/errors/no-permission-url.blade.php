@extends('layout.back-end')
@section('content')
	<div class="container-fluid">
		<div class="form-group">
			<div class="col-lg-6 col-lg-offset-3">
				<div class="error-permission">{{$noPermission}}</div>
			</div>
		</div>
	</div>
<style>
	.error-permission{
		position: relative;
		margin-top: 20%;
		font-family: 'KHMERMEF1';
		font-size: 25px;
		line-height:60px;
		text-align: center;
		word-break: break-all;
		color: red;
	}
</style>
@endsection