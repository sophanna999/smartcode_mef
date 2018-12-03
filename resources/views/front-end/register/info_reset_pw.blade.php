@extends('layout.guest-login')
@section('login-content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-4 col-sm-4 login-wrapper ">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="alert alert-success" style="margin-bottom: 0;">
						<button type="button" class="close font-sans-serif" data-dismiss="alert" aria-hidden="true">&times;</button>
						{{ $info_reset_pw }}
					</div>
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
@endsection