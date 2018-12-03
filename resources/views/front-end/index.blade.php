@extends('layout.front-end')

@section('content')
    <div id="content-center">
		<header>
			<div class="wrapper">
				<div class="blg-logo">
					<img src="images/logo.png" alt="logo" width="80px" class="fl">
					<h1>ក្រសួងសេដ្ឋកិច្ចនិងហិរញ្ញវត្ថុ<br /><br />អង្គភាព...................</h1>
				</div>
				<div class="blg-motto">
					<p>ព្រះរាជាណាចក្រកម្ពុជា<br/> ជាតិ សាសនា ព្រះមហាក្សត្រ</p>
				</div>

				<p class="ttl">ប្រវត្តិរូបមន្ត្រីរាជការ<br/> ក្រសួងសេដ្ឋកិច្ច និងហិរញ្ញវត្ថុ <br /></p>
				<div class="content-notifi">
					<div class="col-lg-2 pull-right">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4 ">
							<!-- <a id="icn-tip01" href="javascript:void(0)" class="editProfile submitProfile" ng-click="submitToAdmin()" style="right:14%;"><i class="glyphicon glyphicon-send item-click" style="font-size:17px;"></i></a> -->
						</div>
						<div id="icn-tip02" class="col-lg-3 col-md-4 col-sm-4 col-xs-4"><a href="#update-info" class="editProfile" style="background:none;right:12%;"><i class="glyphicon glyphicon-edit item-click" style="font-size:17px;"></i></a></div>
						<div id="icn-tip03" class="col-lg-3 col-md-4 col-sm-4 col-xs-4"><a href="#new-notification" class="editProfile notifiPro "><i class="glyphicon glyphicon-globe item-click" style="font-size:18px;">
							<?php if($amount > 0){?><span id="notifi" class="notifi"><?php echo $amount; ?></span><?php } ?>
							<span id="new_notifi" class="notifi display-none" ng-if="amount > 0">@{{amount}}</span>
						</i></a></div>
					</div><!--pull-right-->
				</div>
			</div>
		</header>
		<div class="content wrapper">
			<aside>
				<!-- Left Menu -->
				@include('front-end.include.menu-left')
			</aside>
			<!-- Content -->
			<div id="primary" style="margin-bottom: 80px;">
			   <div ng-view></div>
			</div>
			
		</div>
		@include('front-end.include.footer')
	</div>

<script>

	$("#icn-tip03").click(function(){
		$.ajax({
			type: "post",
			url : baseUrl+'updateInfo/update-notification',
			datatype : "json",
			data : {"_token":'{{ csrf_token() }}'},
			success : function(data){
			   console.log(data);
			   $("#notifi").addClass('display-none');
			}
		});
	});
</script>
<style>
.notifi{
	position:absolute;
	top:-5px;
	right:-8px;
	background:#f5492c;
	font-size:10px;
	padding:1px 3px 4px;
	border-radius:2px 2px;
}
</style>
@endsection