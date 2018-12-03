<?php
$registerUrl = asset('register/get-register');
$forget_pw  = asset('register/reset-password');
?>
@extends('layout.smart-module')

@section('content')
	<!--Content left-->
	<div class="wrapper" id="wrapper-propeller"></div>
	<div class="blg-left">
		@include('front-end.include.content-left-login')
	</div>
	<!-- Content center -->
	<input type="hidden" id="is_small_module" value="false" />
	<div class="blg-main">
	<div id="general-knowledge">
		<!--start innerhead-->
		<div class="inner-head">
			<div id="wrap-search">
				<form action="" autocomplete="on">
					<input id="search" name="search" type="text" placeholder="ស្វែងរក"><input id="search_submit" value="" type="submit">
				</form>
			</div>
			<nav aria-label="breadcrumb" >
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">ទំព័រដើម</a></li>
					<li class="breadcrumb-item active" aria-current="page">កាលវិភាគ</li>
				</ol>
			</nav>
			<div class=" header-title">{{trans('schedule.schedule_mgt')}}</div>
		</div>
		<!--end innerhead-->
		<!--start modal-->
		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title​ modal-custome" id="exampleModalLongTitle">លុបព័ត៌មានប្រជុំ</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				 <div class="modal-body">
					តើអ្នកចង់ធ្វើការលុប ព័ត៌មាននេះមែនទេ?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">បោះបង់</button>
					<button type="button" class="btn btn-primary">យល់ព្រម</button>
				</div>
				</div>
			</div>
		</div>
		<!--end modal-->
		<!--start inner content-->
		<div class="inner-content">
			<div class="row">
				<div class="wrap-head-container" style="">
					<div class="col-md-7 wrap-navbar" style="overflow:hidden">
						<div class="navbar-nav module-heading" >
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab1" data-toggle="tab">កិច្ចប្រជុំផ្ទាល់ខ្លួន</a></li>
								<li class=""><a href="#tab2" data-toggle="tab">កិច្ចប្រជុំទាំងអស់</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-5 pull-right">
						<div class="blg-button">
							<button type="button" class="btn btn-lg btn-success btn-box-save pull-right" data-toggle="modal" data-target="#exampleModalCenter">របៀប Alert</button>
							<button onclick="createMeeting(0)" type="submit" class="btn btn-lg btn-success btn-box-save pull-right"><i class="fa fa-plus"></i>&nbsp; បង្កើតកិច្ចប្រជុំ</button>
						</div>
					</div>
				</div>
			</div>
			<hr style="position:relative;z-index:3;width:96%;border-top: 3px solid #eee;">
				<div>
					<div class="tab-content">
						<!--start tab1default-->
						<div class="tab-pane fade in active" id="tab1">
							<!--start innter content page-->
							<div class="page">
							<table class="tblModule" data-role="listview">
								<thead>
								<tr>
									<th width="8%">កាលបរិច្ឆេទ1</th>
									<th width="30%">អំពីកិច្ចប្រជុំ</th>
									<th width="12%">អ្នកដឹកនាំ</th>
									<th width="25%">អ្នកចូលរួម</th>
									<th  width="8%">ទីកន្លែង</th>
									<th width="9%"></th>
								</tr>
								</thead>
								<tbody id="tbodyAllData">
								<tr>
									<td>២៦/07/២០១៨ </td>
									<td>ធ្វើបទបង្ហាញអំពីប្រព័ន្ធគ្រប់គ្រង NGOផ ម៉េងឡាយធ្វើបទបង្ហាញអំពីប្រព័ន្ធគ្រប់គ្រង NGOផ ម៉េងឡាយ</td>
									<td>ផ ម៉េងឡាយ</td>
									<td>ផ ម៉េងឡាយ/ ឡុង ចាន់សុខហេង/ ឡោ ម៉េងហ៊ាង...</td>
									<td class="text-center">បន្ទប់លេខ១</td>
									<td>
										<div class="menuDot" data-toggle="tooltip" data-placement="bottom" title="ចុចដើម្បីបង្ហាញប៊ូតុង"></div>
										<div class="wrap-button-swipe">
										<div class="swipeDelete"><button>លុប</button></div>
										<div class="swipeEdit"><button>កែប្រែ</button></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>២៦/07/២០១៨ </td>
									<td>ធ្វើបទបង្ហាញអំពីប្រព័ន្ធគ្រប់គ្រង NGOផ ម៉េងឡាយធ្វើ</td>
									<td>ផ ម៉េងឡាយ</td>
									<td>ផ ម៉េងឡាយ/ ឡុង ចាន់សុខហេង/ ឡោ ម៉េងហ៊ាង...</td>
									<td class="text-center">បន្ទប់លេខ១</td>
									<td>
										<div class="menuDot" data-toggle="tooltip" data-placement="bottom" title="ចុចដើម្បីបង្ហាញប៊ូតុង"></div>
										<div class="wrap-button-swipe">
										<div class="swipeDelete"><button>លុប</button></div>
										<div class="swipeEdit"><button>កែប្រែ</button></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>២៦/07/២០១៨ </td>
									<td>ធ្វើបទបង្ហាញអំពីប្រព័ន្ធគ្រប់គ្រង NGOផ ម៉េងឡាយធ្វើ</td>
									<td>ផ ម៉េងឡាយ</td>
									<td>ផ ម៉េងឡាយ/ ឡុង ចាន់សុខហេង/ ឡោ ម៉េងហ៊ាង...</td>
									<td class="text-center">បន្ទប់លេខ១</td>
									<td>
										<div class="menuDot" data-toggle="tooltip" data-placement="bottom" title="ចុចដើម្បីបង្ហាញប៊ូតុង"></div>
										<div class="wrap-button-swipe">
										<div class="swipeDelete"><button>លុប</button></div>
										<div class="swipeEdit"><button>កែប្រែ</button></div>
										</div>
									</td>
								</tr>
								<!-- ngRepeat: user in listTake -->
								</tbody>

							</table>
							</div>
							<!--finish innter content page-->
						</div>
						<!--finish tab1default-->

						<div class="tab-pane fade" id="tab2">
							<!--start innter content page-->
							<div class="page">
							<table class="tblModule" data-role="listview">
								<thead>
								<tr>
									<th width="8%">កាលបរិច្ឆេទ2</th>
									<th width="30%">អំពីកិច្ចប្រជុំ</th>
									<th width="12%">អ្នកដឹកនាំ</th>
									<th width="25%">អ្នកចូលរួម</th>
									<th  width="8%">ទីកន្លែង</th>
									<th width="9%"></th>
								</tr>
								</thead>
								<tbody id="tbodyAllData">
								<tr>
								<td>២៦/07/២០១៨ </td>
								<td>ធ្វើបទបង្ហាញអំពីប្រព័ន្ធគ្រប់គ្រង NGOផ ម៉េងឡាយធ្វើបទបង្ហាញអំពីប្រព័ន្ធគ្រប់គ្រង NGOផ ម៉េងឡាយ</td>
								<td>ផ ម៉េងឡាយ</td>
								<td>ផ ម៉េងឡាយ/ ឡុង ចាន់សុខហេង/ ឡោ ម៉េងហ៊ាង...</td>
								<td class="text-center">បន្ទប់លេខ១</td>
								<td>
								<div class="menuDot" data-toggle="tooltip" data-placement="bottom" title="ចុចដើម្បីបង្ហាញប៊ូតុង"></div>
								<div class="wrap-button-swipe">
								<div class="swipeDelete"><button>លុប</button></div>
								<div class="swipeEdit"><button>កែប្រែ</button></div>
								</div>
								</td>
								</tr>
								<tr>
								<td>២៦/07/២០១៨ </td>
								<td>ធ្វើបទបង្ហាញអំពីប្រព័ន្ធគ្រប់គ្រង NGOផ ម៉េងឡាយធ្វើ</td>
								<td>ផ ម៉េងឡាយ</td>
								<td>ផ ម៉េងឡាយ/ ឡុង ចាន់សុខហេង/ ឡោ ម៉េងហ៊ាង...</td>
								<td class="text-center">បន្ទប់លេខ១</td>
								<td>
								<div class="menuDot" data-toggle="tooltip" data-placement="bottom" title="ចុចដើម្បីបង្ហាញប៊ូតុង"></div>
								<div class="wrap-button-swipe">
								<div class="swipeDelete"><button>លុប</button></div>
								<div class="swipeEdit"><button>កែប្រែ</button></div>
								</div>
								</td>

								</tr>

								<!-- ngRepeat: user in listTake -->
								</tbody>

							</table>
							</div>
							<!--finish innter content page-->
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	</div>
	<!--Content right-->
	@include('front-end.include.notification')
	
	<script src="https://www.gstatic.com/firebasejs/5.2.0/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/5.2.0/firebase-messaging.js"></script>
	<script>


		function myFunction() {
			var input, filter, ul, li, a, i;
			input = document.getElementById("myInput");
			filter = input.value.toUpperCase();
			ul = document.getElementById("allMeetingView");
			li = ul.getElementsByTagName("li");
			for (i = 0; i < li.length; i++) {
				a = li[i].getElementsByTagName("p")[0];
				b = li[i].getElementsByTagName("p")[1];
				c = li[i].getElementsByTagName("p")[2];
				d = li[i].getElementsByTagName("p")[3];
				if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
					li[i].style.display = "";
				}else if (b.innerHTML.toUpperCase().indexOf(filter) > -1) {
					li[i].style.display = "";
				}else if (c.innerHTML.toUpperCase().indexOf(filter) > -1) {
					li[i].style.display = "";
				}else if (d.innerHTML.toUpperCase().indexOf(filter) > -1) {
					li[i].style.display = "";
				}else {
					li[i].style.display = "none";
				}
			}
		}
		$(document).ready(function() {
			$('#scheduler').fullCalendar({
				defaultView: 'agendaWeek',
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'agendaWeek,agendaDay'
				},
				events: 'https://fullcalendar.io/demo-events.json'
			});

			var index = 0;
			$("#btn_more_outside").click(function(){
				index= index+1;
				var sub_more = '<div class="sub_more guest">' +
					'<div class="col-md-5"><input type="text" class="form-control guest_name" placeholder="ឈ្មោះ" id="guest_name_'+index+'" ng-model="guest_name[]"></div>' +
					'<div class="col-md-5"><input type="email" class="form-control guest_email " placeholder="អ៊ីម៉ែល" id="guest_email_'+index+'" ng-model="guest_email[]"></div>' +
					'<div class="col-md-2"><button type="button" class="btn btn-default btn_remove">-</button></div>' +
					'</div>';
				$("#warp_outside_participant_content").append(sub_more);
			});

			$("div#warp_outside_participant_content").on('click', 'button.btn_remove', function() {
				$(this).parent().parent().remove();
			});

			var buttons = ['jqx-save'];

			initialButton(buttons,90,30);

			$('#mycalendar').monthly({
				mode: 'event',
				jsonUrl: '{{asset('schedule/events')}}',
				dataType:'json',
				dayNames : ["អាទិត្យ", "ចន្ទ", "អង្គារ", "ពុធ", "ព្រហស្បតិ៍", "សុក្រ", "សៅរ៍"],
				monthNames : ["មករា", "កុម្ភៈ", "មីនា", "មេសា", "ឧសភា", "មិថុនា", "កក្កដា", "សីហា", "កញ្ញា", "តុលា", "វិច្ឆិកា", "ធ្នូ"]
			});

			switch(window.location.protocol) {
				case 'http:':
				case 'https:':
					// running on a server, should be good.
					break;
				case 'file:':
					alert('Just a heads-up, events will not work when run locally.');
			}

		});
		var currSchedule = localStorage.getItem("currTab");
		// var currentTab = localStorage.getItem("cur_tab");
		// var currentShortHand = (currentTab) ? currentTab : "actives";
		// $(".sche-date ul li p.clpersonal").addClass(currentShortHand);
		// localStorage.setItem("cur_tab","actives");
		// $('ul li p.clpersonal').click(function(){

		//         $('ul li p.clpersonal').addClass(cur_tab);
		//         personal() ;
		// });
		// $('ul li p.clListAll').click(function(){

		//         $('ul li p.clListAll').addClass(cur_tab);
		//         listAll();


		// });
		function personal() {
			$("#personalForm").css('display','block');
			$("#listAllform").css('display','none');
			$("#newForm").css('display','none');
//	$("#roomCheckingForm").css('display','none');
			$(".clpersonal").addClass('actives');
			$(".clListAll").removeClass('actives');
			$(".clNew").removeClass('actives');
			$(".roomChecking").removeClass('actives');
		}

		function roomChecking() {
//	$("#roomCheckingForm").css('display','block');
			$("#personalForm").css('display','none');
			$("#listAllform").css('display','none');
			$("#newForm").css('display','none');
			$(".clpersonal").removeClass('actives');
			$(".clListAll").removeClass('actives');
			$(".clNew").removeClass('actives');
			$(".roomChecking").addClass('actives');
		}
		function update() {
			$('.clListAll').removeClass( "actives" );
			$('.clNew').addClass( "actives" );
		}
		function listAll() {

			$("#listAllform").css('display','block');
			$("#newForm").css('display','none');
			$("#personalForm").css('display','none');
//	$("#roomCheckingForm").css('display','none');
			$(".clpersonal").removeClass('actives');
			$(".clListAll").addClass('actives');
			$(".clNew").removeClass('actives');
			$(".roomChecking").removeClass('actives');

			$.ajax({
				type: "post",
				url: baseUrl + 'schedule/get-all-data',
				datatype: "json",
				data: {"_token": '{{ csrf_token() }}'},
				success: function (response) {
					console.log(response);
					$('.mission').remove();
					if (response != undefined) {
							<?php
							$user = session('sessionGuestUser')->Id;
							?>
						var userId = '{{$user}}';

						for (var key = 0; key < Object.keys(response).length; key++) {
							if(response[key]['create_by_user_id'] != userId){
								var displayNone = 'none';
//		                alert(displayNone);
							}else{
								var displayNone = '';
							}

							var listOfficer = response[key]['list_official'];
							var array = listOfficer.split(',');

							var strOfficer ='';
							for(var i=0;i<4;i++){
								if(array[i] !=undefined){
									strOfficer = array[i]+'/'+strOfficer;
								}

							}
							console.log('data',strOfficer);

							$(".listMeeting").remove();
							$("#allMeeting").addClass('allMeetingView');
							$("#tbodyAllData").append('<tr>' +
								'<td>'+response[key]['meeting_date_kh']+' <br /><span>'+response[key]['meeting_time']+'-'+response[key]['meeting_end_time']+'</span> </td>'+
								'<td>'+response[key]['objective']+'</td>'+
								'<td>'+response[key]['chaire_by']+'</td>'+
								'<td>'+strOfficer+'...</td>'+
								'<td>'+response[key]['location']+'</td>'+
								'<td>' +
								'<div class="menuDot" data-toggle="tooltip" data-placement="bottom" title="ចុចដើម្បីបង្ហាញប៊ូតុង" style="display:'+displayNone+'"></div>' +
								'<div class="wrap-button-swipe">' +
								'<div class="swipeDelete" onclick="confirmDelete('+key+','+response[key]['Id']+')"><button>លុប</button></div>' +
								'<div class="swipeEdit" onclick="createMeeting('+response[key]['Id']+')"><button>កែប្រែ</button></div>' +
								'</div>' +
								'</td>'+
								'</tr>');
//
						}


					}
					if(response == ''){
						$(".listMeeting").remove();
						$("#allMeeting").removeClass('allMeetingView');
						$("#allMeetingView").append('<li class="listMeeting" id="listMeeting">' +
							'<div class="col-md-10 line-left">'+
							'<div style="line-height: 29px;" class="">'+
							'<p class="col-md-12" style="text-align: center;">មិនមានកិច្ចប្រជុំ</p>'+
							'</div>'+
							'</div>'+
							'</li>');
					}

				}
			});
		}

		function createMeeting(Id) {
			$("#listAllform").css('display','none');
			$("#newForm").css('display','block');
			$("#personalForm").css('display','none');
//	$("#roomCheckingForm").css('display','none');
			$(".clpersonal").removeClass('actives');
			$(".clListAll").removeClass('actives');
			$(".clNew").addClass('actives');
			$(".roomChecking").removeClass('actives');

			$.ajax({
				type: "post",
				url: baseUrl + 'schedule/get-data-by-id',
				datatype: "json",
				data: {'Id':Id,"_token": '{{ csrf_token() }}'},
				success: function (response) {
					console.log(response);
					$('.mission').remove();
					if (response != undefined) {
						if(response.row != null){


							$("#id").val(response.row.Id);
							$("#div_meeting_date").jqxDateTimeInput('setDate', response.row.meeting_date);
							$("#num_of_day").val(response.row.num_of_day);
							$("#div_meeting_time").jqxDateTimeInput('setDate', response.row.meeting_time);
							$("#div_meeting_end_time").jqxDateTimeInput('setDate', response.row.meeting_end_time );
							$("#div_meeting_location").jqxDropDownList('val', response.row.meeting_location_id);
							$("#meeting_objective").val(response.row.meeting_objective);
							$("#div_mef_meeting_leader_id").jqxDropDownList('val', response.row.mef_meeting_leader_id);
							$("#div_mef_meeting_type_id").jqxDropDownList('val', response.row.mef_meeting_type_id);
							if(response.row.is_invite_guest == 1){
								$("#is_invite_guest_checkbox").jqxCheckBox({checked: true});
							}

						}else{
							var today = new Date();
							var dd = today.getDate();
							var mm = today.getMonth();
							var yyyy = today.getFullYear();

							$("#id").val(0);
							$("#div_meeting_date").jqxDateTimeInput('setDate', '');
							document.getElementById("num_of_day").value = "1";
							$("#div_meeting_time").jqxDateTimeInput('setDate', '');
							$("#div_meeting_end_time").jqxDateTimeInput('setDate', '');
							$("#div_meeting_location").jqxDropDownList('val', '');
							$("#meeting_objective").val('');
							$("#div_mef_meeting_leader_id").jqxDropDownList('val', '');
							$("#div_mef_meeting_type_id").jqxDropDownList('val',1);
							$("#is_invite_guest_checkbox").jqxCheckBox({checked: false});
							$("#div_mef_office_id").jqxDropDownList('val', '');
							$("#div_meeting_date").jqxDateTimeInput({
								width : "100%",
								value : new Date(),
								formatString : "dd-MM-yyyy"
							});
							$('#div_meeting_date').jqxDateTimeInput('setMinDate', new Date(yyyy, mm, dd));

						}

						if(response.officer.length !=0){
							$("#div_mef_meeting_atendee_join").jqxComboBox('clearSelection');
							$.each(response.officer, function( index, value ) {
								$("#div_mef_meeting_atendee_join").jqxComboBox('selectItem', value.mef_officer_id);
							});
						}else{
							$("#div_mef_meeting_atendee_join").jqxComboBox('clearSelection');
						}

						if(response.guest.length != 0){
							$(".sub_more").remove();
							$.each(response.guest, function( index, value ) {
								var sub_more = '<div class="sub_more guest">' +
									'<div class="col-md-5"><input type="text" class="form-control guest_name" placeholder="ឈ្មោះ" id="guest_name_'+index+'" ng-model="guest_name[]" value="'+value.name+'"></div>' +
									'<div class="col-md-5"><input type="email" class="form-control guest_email " placeholder="អ៊ីម៉ែល" id="guest_email_'+index+'" ng-model="guest_email[]" value="'+value.email+'"></div>' +
									'<div class="col-md-2"><button type="button" class="btn btn-default btn_remove">-</button></div>' +
									'</div>';
								$("#warp_outside_participant_content").append(sub_more);
							})
						}else{
							$(".sub_more").remove();
						}
					}

				}
			});
		}

		function confirmDelete(num,id) {
			$.confirm({
				icon: 'glyphicon glyphicon-trash',
				title: 'លុប',
				content: 'តើអ្នកពិតជាចង់លុបទិន្នន័យនេះឬ?',
				draggable: true,
				buttons: {
					danger: {
						text: 'លុប',
						btnClass: 'btn-blue',
						action: function(){

							$.ajax({
								type: "post",
								url: baseUrl + 'schedule/delete',
								datatype: "json",
								data: {'Id':id,"_token": '{{ csrf_token() }}'},
								success: function (response) {
									$("#listMeeting_"+num).remove();
									$("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});

									$("#jqx-notification").jqxNotification();
									$('#jqx-notification').jqxNotification({position: 'bottom-left',template: "success" });
									$('#jqx-notification').html(response.message);
									$("#jqx-notification").jqxNotification("open");
								}
							});

						}
					},
					warning: {
						text: 'បោះបង់',
						btnClass: 'btn-red any-other-class'
					}
				}
			});
		}

	</script>

@endsection
