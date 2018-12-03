<div id="general-knowledge" >
<div class="container-fluid">
    <div id="jqx-notification"></div>
    <div class="h2-schedule header-title">{{trans('schedule.schedule_mgt')}}</div>

    <!-- <div class="sche-date">
    	<p class="sche-day">ថ្ងៃទី {{$today_khmer}}</p>
        <p class="sche-time">{{$current_time}}</p>
    </div> -->
    <div class="modal fade" id="myModal" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h4 class="modal-title">បង្កើតថ្មី</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                </div>
            </div>

        </div>
    </div>
	<div class="pull-left">
		<ul class="menu">
			<li onclick="personal()" class="actives clpersonal"><p>កិច្ចប្រជុំផ្ទាល់ខ្លួន</p></li>
			<li onclick="listAll()" id="listAll" class="clListAll"><p>កិច្ចប្រជុំទាំងអស់</p></li>
			{{--<li onclick="createMeeting(0)" id="new"class="clNew"><p>បង្កើតកិច្ចប្រជុំ</p></li>--}}
			{{--<li onclick="roomChecking()" id="roomChecking"class="roomChecking"><p>ពិនិត្យបន្ទប់ប្រជុំ</p></li>--}}
		</ul>
	</div>
	<div class="col-sm-6" style="margin-left: -16px;">
		<ul class="menu">

			<li onclick="createMeeting(0)" id="new"class="clNew"><p>បង្កើតកិច្ចប្រជុំ</p></li>
			{{--<li onclick="roomChecking()" id="roomChecking"class="roomChecking"><p>ពិនិត្យបន្ទប់ប្រជុំ</p></li>--}}
		</ul>
	</div>
    <div class="wrap-calendar col-sm-7" style="width: 64%;">
        <div class="page">

            <div id="listAllform" style="display: none;">
                        ស្វែងរក
                        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="" title="Type in a name">
                        <div class="allMeetingView" id="allMeeting" style="margin-bottom: 10px;margin-top: 26px;">

                            <ul id="allMeetingView">

                            </ul>
                        </div>
                    {{--</div>--}}

                {{--</div>--}}
            </div>
            <div style="width:100%;  display:inline-block;" id="personalForm">
	            {{--<div style="text-align: center;font-size: 27px;margin-top: -47px;">--}}
		            {{--<p>កិច្ចប្រជុំផ្ទាល់ខ្លួន</p>--}}
		            {{--<hr>--}}
	            {{--</div>--}}
                <div class="monthly" id="mycalendar"></div>
            </div>

	        <div id="newForm" style="display: none;">
		        <form name="schedule" class="form-horizontal" enctype="multipart/form-data" ng-controller="scheduleController">
					<input type="hidden" id="id" name="id" value="0">
			        <div class="form-group">
				        <div class="col-sm-3 text-right"><label class="label-margin-top10"><span class="red-star">*</span> {{trans('schedule.meeting_date')}}</label></div>
				        <div class="col-sm-3">
					        <input type="hidden" class="form-control" placeholder="{{trans('schedule.meeting_date')}}" id="meeting_date" ng-model="meeting_date" value="{{isset($row->meeting_date) ? $row->meeting_date:''}}">
					        <div id="div_meeting_date"></div>

				        </div>
				        <div class="col-sm-1 text-left">
					        <input type="number" class="form-control" id="num_of_day" value="" placeholder="ចំនួនថ្ងៃ">
				        </div>
				        <div class="col-sm-2">
					        <div id="div_meeting_time" name="meeting_time" ng-model="meeting_time"></div>
				        </div>
				        <div class="col-sm-1"><label class="label-margin-top10">ដល់</label></div>
				        <div class="col-sm-2​text-left">
					        <div id="div_meeting_end_time" name="meeting_end_time" ng-model="meeting_end_time"></div>
				        </div>

			        </div>
			        <div class="form-group">
				        <div class="col-sm-3 text-right">
					        <div id="office_label"><label>{{trans('officer.search_office')}} </label></div>
				        </div>
				        <div class="col-sm-9">
					        <input type="hidden" name="mef_office_id" id="mef_office_id" value="{{isset($row->mef_office_id) ? $row->mef_office_id:''}}" />
					        <div id="div_mef_office_id"></div>
				        </div>
			        </div>
			        <div class="form-group">
				        <div class="col-sm-3 text-right">
					        <div class="label-margin-top10" id="office_meeting_atendee_join"><label>{{trans('schedule.meeting_participant')}}</label></div>
				        </div>
				        <div class="col-sm-9">
					        <div id="div_mef_meeting_atendee_join" ng-model="mef_meeting_atendee_join" name="mef_meeting_atendee_join"></div>
				        </div>
			        </div>
			        <div class="form-group">
				        <div class="col-sm-3 text-right"><span class="red-star">*</span> <label class="label-margin-top10">{{trans('schedule.meeting_location')}}</label></div>
				        <div class="col-sm-9">

					        <input type="hidden" ng-model="meeting_location" id="meeting_location" value="{{isset($row->meeting_location) ? $row->meeting_location:''}}" />
					        <div id="div_meeting_location"></div>

				        </div>
			        </div>
			        <div class="form-group">
				        <div class="col-sm-3 text-right"><span class="red-star">*</span> <label class="label-margin-top10">{{trans('schedule.meeting_purpose')}}</label></div>
				        <div class="col-sm-8" id="warp_meeting_objective">
					        <textarea rows="3" placeHolder="{{trans('schedule.meeting_purpose')}}" class="form-control" id="meeting_objective" ng-model="meeting_objective">{{isset($row->meeting_objective) ? $row->meeting_objective:''}}</textarea>
				        </div>
			        </div>
			        <div class="form-group">
				        <div class="col-sm-3 text-right">
					        <div class="label-margin-top10">
						        <span class="red-star">*</span> <label>{{trans('schedule.meeting_leader')}}</label>
					        </div>
				        </div>
				        <div class="col-sm-5">
					        <input type="hidden" class="form-control" placeholder="{{trans('schedule.meeting_leader')}}" id="mef_meeting_leader_id" ng-model="mef_meeting_leader_id" value="{{isset($row->mef_meeting_leader_id) ? $row->mef_meeting_leader_id:''}}">
					        <div id="div_mef_meeting_leader_id"></div>
					        {{--<button type="button" id="btn_more_leader" class="btn btn-default" data-toggle="modal" data-target="#myModalLeader">+</button>--}}

				        </div>

			        </div>
			        <div class="form-group">
				        <div class="col-sm-3 text-right">
					        <div class="label-margin-top10">
						        <span class="red-star">*</span> <label>{{trans('schedule.meeting_type')}}</label>
					        </div>
				        </div>
				        <div class="col-sm-5">
					        <input type="hidden" class="form-control" placeholder="{{trans('schedule.meeting_type')}}" id="mef_meeting_type_id" ng-model="mef_meeting_type_id" value="{{isset($row->mef_meeting_type_id) ? $row->mef_meeting_type_id:''}}">
					        <div id="div_mef_meeting_type_id"></div>
					        {{--<button type="button" id="btn_more_meeting_type" class="btn btn-default" data-toggle="modal" data-target="#myModalMeetingType">+</button>--}}
				        </div>
			        </div>
			        <div class="form-group">
				        <div class="col-sm-3 text-right"></div>
				        <div class="col-sm-9">
					        <?php $is_invite_guest = isset($row->is_invite_guest) ? $row->is_invite_guest : 0; ?>
					        <div>
						        <input type="hidden" id="is_invite_guest" ng-model="is_invite_guest" value="0">
						        <div id="is_invite_guest_checkbox"> {{trans('schedule.outside_participant')}}</div>
					        </div>
					        <div id="warp_outside_participant" style="background: #eee;">
						        <div id="warp_outside_participant_content">

						        </div>
						        <button type="button" class="btn btn-default" id="btn_more_outside" disabled>+</button>
					        </div>
				        </div>
			        </div>

			        <div class="form-group">
				        <div class="col-sm-12 text-right">
					        <button id="jqx-save" type="button" ng-click="saveMeeting(url)"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
				        </div>
			        </div>
		        </form>
	        </div>
	        <div id="roomCheckingForm" style="display: none;">
		        <div id="scheduler"></div>
	        </div>
        </div>
    </div>

</div>

</div>
<style>
    .menu {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #fcfcfc;
        float: right;
        font-family: 'KHMERMEF1' !important;
        font-size: 16PX;
    }
    .menu li {
        float: left;
        padding:7px 0;
    }

    .menu li:last-child {
        border-right: none;
    }
    .menu li p {
        display: block;
        color: white;
        text-align: center;
        padding: 0 16px;
        text-decoration: none;
        color:#080101;
        cursor:pointer;
        margin:0;
        border-right:1px solid #f2f2f2;
    }
    .menu li:hover:not(.active){border-bottom:1px solid #3DAA95;}
    .menu li:hover:not(.active) > p{ color: #3DAA95 !important;}
    .actives {
        color: #3DAA95 !important;
        border-bottom:1px solid #3DAA95;
    }
    #office_label{
        margin-top: 10px;
    }
    .label-margin-top10{
        margin-top: 10px;
    }
    #div_meeting_date, #div_meeting_time{ display: inline-block; }
    .jqx-validator-error-label{ display: none !important; width: 0 !important; }
    #dropdownlistContentdiv_mef_meeting_atendee_join .jqx-combobox-input{
        line-height:20px !important;
    }
    #check_meeting_atendee_all{
        margin-top: 0px;
    }
    #join_all_checkbox{ padding-top: 8px; }
    #check_meeting_atendee_all_checkbox{ margin-top: 15px; }
    #warp_outside_participant, #warp_reference_document{
        border: 1px solid #ddd;
        padding: 10px 5px;
        position: relative;
        padding-bottom: 45px;
        float: left;
        width: 100%;
    }
    #btn_more_outside, #btn_more_reference{
        position: absolute;
        left: 20px;
        bottom: 10px;
    }
    .sub_more{
        float: left;
        width: 100%;
        margin-bottom: 6px;
    }
    .btn_remove{
        font-weight: bold;
        color: red;
    }
    #btn_more_leader{
        position: absolute;
        right: -30px;
        top: -1px;
        z-index: 9;
    }
    #leader_name, #leader_email{
        margin: 15px 0;
    }
    #myModalLeader .modal-dialog, #myModalMeetingType .modal-dialog{
        margin: 70px auto;
    }
    .form-control.validation-meeting-type{ margin: 15px 0; }
    #btn_more_meeting_type{
        position: absolute;
        right: -30px;
        top: -1px;
        z-index: 9;
    }
</style>

<script type="text/javascript">

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
	                $(".listMeeting").remove();
	                $("#allMeeting").addClass('allMeetingView');
                    $("#allMeetingView").append('<li class="mission" id="listMeeting_'+key+'">' +
                        '<p style="line-height: 29px;" class="day-time col-md-2">'+response[key]['meeting_date_kh']+'  <br />'+response[key]['meeting_time']+'-'+response[key]['meeting_end_time']+'</p>'+
                        '<div class="col-md-10 line-left">'+
                        '<div style="line-height: 29px;" class="each-blg-sche">'+
                        '<p class="col-md-12">'+response[key]['objective']+'</p>'+
                        '<p class="col-md-4 lead-sche">'+response[key]['chaire_by']+'</p>'+
                        '<p class="col-md-4 locate">'+response[key]['location']+'</p>'+
	                    '<input type="hidden" id="meetingId_'+key+'" value="'+response[key]['Id']+'"></input>'+
	                    '<button id="update_'+key+'" onclick="createMeeting('+response[key]['Id']+')" style="display:'+displayNone+'"><i class="fa fa-edit"></i></button>'+
                        '<button id="delete_'+key+'" onclick="confirmDelete('+key+','+response[key]['Id']+')" style="display:'+displayNone+'"><i class="fa fa-trash"></i></button>'+
                        '</div>'+
                        '</div>'+
                        '</li>');
	                var buttonsList = [ 'update_'+key,'delete_'+key];
	                initialButton(buttonsList,30,30);
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