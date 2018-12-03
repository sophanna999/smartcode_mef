@extends('layout.front-end')
@section('content')
    <div id="content-center">
		<div class="bg-transparent"></div>
		<section class="edit-head">
			<p>កែសម្រួលគណនីរបស់អ្នក</p>
			<div class="content-notifi content-notifi-all-form">
				<div class="warp-notifi pull-right">
					<div id="icn-tip01" class="list"><a href="#all-form" class="editProfile" style="background:none;right:12%;"><i class="glyphicon glyphicon-home item-click" style="font-size:17px;"></i></a></div>
					<div id="icn-tip02" class="list"><a href="#update-info" class="editProfile" style="background:none;right:12%;"><i class="glyphicon glyphicon-edit item-click" style="font-size:17px;"></i></a></div>
					<div id="icn-tip03" class="list"><a href="#new-notification" class="editProfile notifiPro "><i class="glyphicon glyphicon-globe item-click" style="font-size:18px;">
						<?php if($amount > 0){?><span id="notifi" class="notifi"><?php echo $amount; ?></span><?php } ?>
						<span id="new_notifi" class="notifi display-none" ng-if="amount > 0">@{{amount}}</span>
						</i></a>
					</div>
					<div class="list" data-id="9">
						<a class="logout" href="{{asset('register/guest-logout')}}" title="ចេញពីប្រព័ន្ធ"><i class="glyphicon glyphicon-log-out item-click menu-9" data-id="9"></i> ចាកចេញ</a>
					</div>
				</div><!--pull-right-->
			</div>
		</section>
		<div class="content wrapper">
			<!-- Content All Form -->
			<div ng-view></div>
		</div>
		@if(session("is_visited_first") == true)
			<!-- First Visited user login complete -->
			<div class="modal fade" id="ModalUserFirstApproved" role="dialog">
			  <div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
				  <div class="modal-body">
					<h4>គណនីរបស់អ្នកត្រូវបានអនុម័ត</h4>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">បិទ</button>
				  </div>
				</div>
			  </div>
			</div>
			<script type="text/javascript">
				$(window).load(function(){
					$('#ModalUserFirstApproved').modal('show');
				});
			</script>
		@endif
		@include('front-end.include.footer')
	</div>
	<style>
		.modal-backdrop{
			z-index: 998;
		}
		.content-notifi-all-form .editProfile{ position: static; }
		.editProfile {color: #337ab7;}
		.editProfil:hover, .editProfil:focus { #23527c; }
		.warp-notifi .list { display: inline-block; font-size: 17px; }
		.logout{ padding-left: 17px; }
	</style>
	<script type="text/javascript">
		$(document).ready(function () {
			$("#icn-tip01").jqxTooltip({ content: 'ទំពរដើម', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
			$("#icn-tip02").jqxTooltip({ content: 'កែសម្រួលគណនីរបស់អ្នក', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
			$("#icn-tip03").jqxTooltip({ content: 'ដំណឹងថ្មីៗ', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
		});
	</script>
@endsection