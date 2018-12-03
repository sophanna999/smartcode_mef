<?php
$jqxPrefix = '_metting';
$newUrl = asset($constant['secretRoute'].'/schedule/new');

?>
<div id="general-knowledge">
<!--start innerhead-->

<div class="inner-head">

	<nav aria-label="breadcrumb" >
		<ol class="breadcrumb kbach-title">
			<li class="breadcrumb-item"><a href="#">ទំព័រដើម</a></li>
			<li class="breadcrumb-item header-title active" aria-current="page">{{trans('schedule.schedule_mgt')}}</li>
		</ol>
	</nav>
	<!-- <div class=" ">{{trans('schedule.schedule_mgt')}}</div> -->
	<div class="col-12 clear" style="overflow:hidden">
		<div id="jqx-notification"></div>
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

	</div>
</div>
<!--end innerhead-->
<!--start inner content-->
<div class="inner-content" ng-controller="scheduleController">
		<div class="row">
			<div class="wrap-head-container">
				<div class="col-md-7 wrap-navbar" style="overflow:hidden">
					<ul class="navbar-nav" style="margin-top:5px">
						<li onclick="calendar()" class="clCalendar nav-item actives"><a>{{trans('schedule.calendar')}}</a></li>
						<li onclick="listPersonalMeeting()" class="clpersonal nav-item"><a>{{trans('schedule.personal_meeting')}}</a></li>
						<li onclick="listAll()" id="listAll" class="clListAll nav-item "><a>{{trans('schedule.all_meeting')}}</a></li>
						<li onclick="listAllHistory()" id="listAllHistory" class="clListAllHistory nav-item "><a>{{trans('schedule.history_meeting')}}</a></li>
					</ul>
				</div>
				<div class="col-md-5 pull-right">

					<div style="position:relative;float:right" class="pull-right">
						<button onclick="getNew(0)" type="submit" class="btn btn-lg btn-success btn-box-save"><i class="fa fa-plus"></i>&nbsp; {{trans('schedule.create-meeting')}}</button>
					</div>
					<div id="wrap-search">
						<div id="formSearch" style="display: none">
							<input id="search" name="search" type="text" onkeyup="searchTable()" placeholder="ស្វែងរក"><input id="search_submit" value="" type="submit">
						</div>
					</div>
				</div>
			</div>
		</div>
	<hr style="position:relative;z-index:3;width:96%;
     border-top: 3px solid #eee;"/>
	<div class="wrap-calendar">
        <div class="page">
	        {{--Tap calendar--}}
	        <div style="width:96%; margin:0 auto;" id="personalCalendar">

		        <div class="monthly" id="mycalendar"></div>
	        </div>

	        {{--Tap List personal meeting--}}
	        <div id="listPersonalMeeting" style="display: none;">
		        <div role="main" class="personalMeetingView ui-content" id="personalMeeting" >
			        <table class="tblModule tblSwipe" id="tblMeeting" data-role="listview">
				        <thead>
				        <tr>
					        <th width="11%" id="th_schedule" onclick="sortfiledObjective($('#tblMeetingAll'),1)">
								<span class="sort-title">កាលបរិច្ឆេទ</span>
								<div class="sort-box">
									<span class="arrow-up" ></span>
									<span class="arrow-down"></span>
								</div>
							</th>
					        <th width="20%" id="th_objective" onclick="sortfiledObjective($('#tblMeetingAll'))">
								<span class="sort-title">អំពីកិច្ចប្រជុំ</span>
								<div class="sort-box">
									<span class="arrow-up" ></span>
									<span class="arrow-down"></span>
								</div>
							</th>
					        <th width="10%" id="th_leader" onclick="sortfiledLeader($('#tblMeetingAll'))">
								<span class="sort-title">អ្នកដឹកនាំ</span>
								<div class="sort-box">
									<span class="arrow-up"></span>
									<span class="arrow-down"></span>
								</div>
							</th>
					        <th width="25%" onclick="sortfiledMember($('#tblMeetingAll'))">
								<span class="sort-title">អ្នកចូលរួម</span>
								<div class="sort-box">
									<span class="arrow-up"></span>
									<span class="arrow-down"></span>
								</div>
							</th>
					        <th  width="9%" id="th_place" onclick="sortfiledObjective($('#tblMeetingAll'),5)">
								<span class="sort-title">ទីកន្លែង</span>
								<div class="sort-box">
									<span class="arrow-up" ></span>
									<span class="arrow-down"></span>
								</div>
							</th>
					        <th width="7%"></th>
				        </tr>
				        </thead>
				        <tbody id="tbodyPeraonalData">

				        <!-- ngRepeat: user in listTake -->
				        </tbody>

			        </table>
		        </div>
	        </div>
	       {{--Tap list all meeting--}}
            <div id="listAllform" style="display: none;">
                        <div role="main" class="allMeetingView ui-content" id="allMeeting" >
						<table class="tblModule tblSwipe tblMeeting" id="tblMeetingAll" data-role="listview">
							<thead>
								<tr>
									<th width="11%" id="th_schedule" onclick="sortfiledObjective($('#tblMeetingAll'),1)">
										<span class="sort-title">កាលបរិច្ឆេទ</span>
										<div class="sort-box">
											<span class="arrow-up" ></span>
											<span class="arrow-down"></span>
										</div>
									</th>
									<th width="20%" id="th_objective" onclick="sortfiledObjective($('#tblMeetingAll'))">
										<span class="sort-title">អំពីកិច្ចប្រជុំ</span>
										<div class="sort-box">
											<span class="arrow-up" ></span>
											<span class="arrow-down"></span>
										</div>
									</th>
									<th width="10%" id="th_leader" onclick="sortfiledLeader($('#tblMeetingAll'))">
										<span class="sort-title">អ្នកដឹកនាំ</span>
										<div class="sort-box">
											<span class="arrow-up"></span>
											<span class="arrow-down"></span>
										</div>
									</th>
									<th width="25%" onclick="sortfiledMember($('#tblMeetingAll'))">
										<span class="sort-title">អ្នកចូលរួម</span>
										<div class="sort-box">
											<span class="arrow-up"></span>
											<span class="arrow-down"></span>
										</div>
									</th>
									<th  width="9%" id="th_place" onclick="sortfiledObjective($('#tblMeetingAll'),5)">
										<span class="sort-title">ទីកន្លែង</span>
										<div class="sort-box">
											<span class="arrow-up" ></span>
											<span class="arrow-down"></span>
										</div>
									</th>
									<th width="7%"></th>
								</tr>
							</thead>
							<tbody id="tbodyAllData">
								<!-- ngRepeat: user in listTake -->
							</tbody>

						</table>
						</div>
            </div>
	        <div id="listAllHistoryForm" style="display: none;" >
		        <div role="main" class="allMeetingView ui-content" id="allHistoryMeeting" >
				<form class="form-horizontal" role="form"  style="padding:20px 20px 0;">
			        <div class="form-group">
				        <label class="col-sm-2 text-right" style="font-size:14px;padding-top:10px;">{{trans('schedule.search_date')}}</label>
						<div class="col-sm-3">
							<input type="hidden"  id="dateSearch" name="dateSearch" value="">
							<div class="" id="div_DateSearch"></div>
						</div>
			        </div>
				</form>
					<div id="noDataHistory" style="display: none">
						<label class="col-sm-2"></label>
						<div class="col-sm-8" style="padding:30px 20px;">
				        	<p>ថ្ងៃ<span id="spanNoHistoryMeeting" style="color:#3e8274">  </span>មិនមានកិច្ចប្រជុំ</p>
						</div>
			        </div>
			        <table class="tblModule tblSwipe tblHistroyMeeting" id="tblHistoryMeetingAll" data-role="listview" style="display: none;">
				        <thead>
				        <tr>
					        <th width="11%" class="text-center" onclick="sortfiledObjective($('#tblHistoryMeetingAll'),1)">
						        <span class="sort-title">កាលបរិច្ឆេទ</span>
						        <div class="sort-box">
							        <span class="arrow-up" ></span>
							        <span class="arrow-down"></span>
						        </div>
					        </th>
					        <th width="20%" id="th_objective" onclick="sortfiledObjective($('#tblHistoryMeetingAll'))">
						        <span class="sort-title">អំពីកិច្ចប្រជុំ</span>
						        <div class="sort-box">
							        <span class="arrow-up" ></span>
							        <span class="arrow-down"></span>
						        </div>
					        </th>
					        <th width="10%" id="th_leader" onclick="sortfiledLeader($('#tblHistoryMeetingAll'))">
						        <span class="sort-title">អ្នកដឹកនាំ</span>
						        <div class="sort-box">
							        <span class="arrow-up"></span>
							        <span class="arrow-down"></span>
						        </div>
					        </th>
					        <th width="25%" onclick="sortfiledMember($('#tblHistoryMeetingAll'))">
						        <span class="sort-title">អ្នកចូលរួម</span>
						        <div class="sort-box">
							        <span class="arrow-up"></span>
							        <span class="arrow-down"></span>
						        </div>
					        </th>
					        <th  width="9%" onclick="sortfiledObjective($('#tblHistoryMeetingAll'),5)">
						        <span class="sort-title">ទីកន្លែង</span>
						        <div class="sort-box">
							        <span class="arrow-up"></span>
							        <span class="arrow-down"></span>
						        </div>
					        </th>
					        <th width="7%"></th>
				        </tr>
				        </thead>
				        <tbody id="tbodyAllHistoryData">
				        <!-- ngRepeat: user in listTake -->
				        </tbody>

			        </table>
		        </div>
	        </div>
	        <div id="roomCheckingForm" style="display: none;">
		        <div id="scheduler"></div>
	        </div>
        </div>
		<div id="jqxLoader"></div>
    </div>
</div>
</div>
<!--end inner content-->
<script type="text/javascript" src="{{asset('jqwidgets/jqx-all.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxcore.js')}}"></script>
<script type="text/javascript">

	var table = $("#tblMeetingAll");
	var objectiveVal = 0;
	function sortfiledObjective(table,num) {
		var asc;
		if(objectiveVal ==0){
			asc   = 'asc';
			objectiveVal = 1;
		}else{
			asc   = 'desc';
			objectiveVal = 0;
		}

			tbody = table.find('tbody');

		tbody.find('tr').sort(function(a, b) {
			if (asc == 'asc') {
				return $('td:nth-child(2)', a).text().localeCompare($('td:nth-child(2)', b).text());
			} else {
				return $('td:nth-child(2)', b).text().localeCompare($('td:nth-child(2)', a).text());
			}
		}).appendTo(tbody);
	}

	var leaderVal = 0;
	function sortfiledLeader(table) {
		var asc;
		if(leaderVal ==0){
			asc   = 'asc';
			leaderVal = 1;
		}else{
			asc   = 'desc';
			leaderVal = 0;
		}

		tbody = table.find('tbody');

		tbody.find('tr').sort(function(a, b) {
			if (asc == 'asc') {
				return $('td:nth-child(3)', a).text().localeCompare($('td:nth-child(3)', b).text());
			} else {
				return $('td:nth-child(3)', b).text().localeCompare($('td:nth-child(3)', a).text());
			}
		}).appendTo(tbody);
	}

	var memberVal = 0;
	function sortfiledMember(table) {
		var asc;
		if(memberVal ==0){
			asc   = 'asc';
			memberVal = 1;
		}else{
			asc   = 'desc';
			memberVal = 0;
		}

		tbody = table.find('tbody');

		tbody.find('tr').sort(function(a, b) {
			if (asc == 'asc') {
				return $('td:nth-child(4)', a).text().localeCompare($('td:nth-child(4)', b).text());
			} else {
				return $('td:nth-child(4)', b).text().localeCompare($('td:nth-child(4)', a).text());
			}
		}).appendTo(tbody);
	}

function searchTable(tableId) {
	var input, filter, table, tr, td, span;
	input = document.getElementById("search");
	filter = input.value.toUpperCase();
	table = document.getElementById("tblMeetingAll");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[0];
		td1 = tr[i].getElementsByTagName("td")[1];
		td2 = tr[i].getElementsByTagName("td")[2];
		td3 = tr[i].getElementsByTagName("td")[3];
		td4 = tr[i].getElementsByTagName("td")[4];
		span = tr[i].getElementsByTagName("span")[0];

		if (td) {
			if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			}else if (td1.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			}else if (td2.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			}else if (td3.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			}else if (td3.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			}else if (td4.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			}else if (span.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			}else {
				tr[i].style.display = "none";
			}
		}
	}

}

$(document).ready(function() {

	$("#div_mef_meeting_type_id").bind('select',function(event){

		if($(this).val() == 2){

			$("#div_meeting_location").jqxDropDownList({
				disabled: true
			});
		}else{
			$("#div_meeting_location").jqxDropDownList({
				disabled: false
			});
		}
	});

    var index = 0;
	$("#btn_more_outside").click(function(){
		index= index+1;
		var sub_more = '<div class="row"><div class="sub_more guest ">' +
			'<div class="col-md-5"><input type="text" class="form-control guest_name" placeholder="ឈ្មោះ" id="guest_name_'+index+'" ng-model="guest_name[]"></div>' +
			'<div class="col-md-5"><input type="email" class="form-control guest_email " placeholder="អ៊ីម៉ែល" id="guest_email_'+index+'" ng-model="guest_email[]"></div>' +
			'<div class="col-md-2"><button type="button" class="btn btn-default btn_remove">-</button></div>' +
			'</div></div>';
		$("#warp_outside_participant_content").append(sub_more);
	});

	$("div#warp_outside_participant_content").on('click', 'button.btn_remove', function() {
		$(this).parent().parent().remove();
	});

	setTimeout(function(){
		initCalenda = null;
		$("#mycalendar").html('');
		$("#mycalendar").removeClass('monthly-locale-en monthly-locale-en-us');

		$(document.body).off("click","#mycalendar .monthly-reset");
		initCalenda = $('#mycalendar').monthly({
			mode: 'event',
			jsonUrl: '{{asset('schedule/events')}}',
			dataType:'json',
			dayNames : ["អាទិត្យ", "ចន្ទ", "អង្គារ", "ពុធ", "ព្រហស្បតិ៍", "សុក្រ", "សៅរ៍"],
			monthNames : ["មករា", "កុម្ភៈ", "មីនា", "មេសា", "ឧសភា", "មិថុនា", "កក្កដា", "សីហា", "កញ្ញា", "តុលា", "វិច្ឆិកា", "ធ្នូ"]
		})

	},200);

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

function calendar() {
	$("#personalCalendar").css('display','block');
	$("#listAllform").css('display','none');
	$("#newForm").css('display','none');
	$("#listPersonalMeeting").css('display','none');
	$("#listAllHistoryForm").css('display','none');
	$(".clCalendar").addClass('actives');
	$(".clListAll").removeClass('actives');
	$(".clpersonal").removeClass('actives');
	$(".clNew").removeClass('actives');
	$(".clListAllHistory").removeClass('actives');
	$(".roomChecking").removeClass('actives');
	$("#formSearch").css('display','none');
	setTimeout(function(){
		initCalenda = null;
		$("#mycalendar").html('');
		$("#mycalendar").removeClass('monthly-locale-en monthly-locale-en-us');

		$(document.body).off("click","#mycalendar .monthly-reset");
		initCalenda = $('#mycalendar').monthly({
			mode: 'event',
			jsonUrl: '{{asset('schedule/events')}}',
			dataType:'json',
			dayNames : ["អាទិត្យ", "ចន្ទ", "អង្គារ", "ពុធ", "ព្រហស្បតិ៍", "សុក្រ", "សៅរ៍"],
			monthNames : ["មករា", "កុម្ភៈ", "មីនា", "មេសា", "ឧសភា", "មិថុនា", "កក្កដា", "សីហា", "កញ្ញា", "តុលា", "វិច្ឆិកា", "ធ្នូ"]
		})

	},2000);
}

function update() {
	$('.clListAll').removeClass( "actives" );
	$('.clNew').addClass( "actives" );
}

function listPersonalMeeting() {
	$("#listPersonalMeeting").css('display', 'block');
	$("#listAllform").css('display', 'none');
	$("#newForm").css('display', 'none');
	$("#personalCalendar").css('display', 'none');
	$("#listAllHistoryForm").css('display','none');
	$(".clCalendar").removeClass('actives');
	$(".clpersonal").addClass('actives');
	$(".clListAll").removeClass('actives');
	$(".clNew").removeClass('actives');
	$(".clListAllHistory").removeClass('actives');
	$(".roomChecking").removeClass('actives');
	$("#formSearch").css('display','none');
	loadingWaiting();
	$.ajax({
		type: "post",
		url: baseUrl + 'schedule/get-all-personal-meeting',
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

					var todayInter = new Date();
					var dateInter = todayInter.getFullYear() + '-' + (todayInter.getMonth() + 1) + '-' + todayInter.getDate();
					var timeInter = todayInter.getHours() + ":" + todayInter.getMinutes() + ":" + todayInter.getSeconds();
					var dateTimeInter = dateInter + ' ' + timeInter;
					var currentTimeInter = Date.parse(dateTimeInter);
					var finishTime = Date.parse(response[key]['meeting_date_en'] + ' ' + response[key]['finishTime']);
					var color;
					if(finishTime <= currentTimeInter){

						color ='darkgray';
					}else{
						color ='';
					}
					var location;
					if(response[key]['location'] ==null){
						location ='ប្រជុំខាក្រៅ';
					}else{
						location = response[key]['location'];
					}

					$(".listPersonalMeeting").remove();
					$("#personalMeeting").removeClass('allMeetingView');
					$("#listPersoanlMeeting_"+key).remove();
//
					$("#tbodyPeraonalData").append('<tr id="listPersoanlMeeting_'+key+'" style="color:'+color+' ">' +
						'<td>'+response[key]['meeting_date_kh']+' <br /><span style="color:'+color+' ">'+response[key]['meeting_time']+'-'+response[key]['meeting_end_time']+'</span> </td>'+
						'<td style="cursor:pointer" onclick="detail('+response[key]['Id']+')">'+response[key]['objective']+'</td>'+
						'<td style="cursor:pointer" onclick="detail('+response[key]['Id']+')">'+response[key]['chaire_by']+'</td>'+
						'<td data-toggle="tooltip" style="cursor:pointer"  title="'+response[key]['list_official']+'" onclick="detail('+response[key]['Id']+')">'+strOfficer+'...'+
						'</td>'+
						'<td style="cursor:pointer" onclick="detail('+response[key]['Id']+')">'+location+'</td>'+
						'<td>' +
						'<div class="menuDot" data-toggle="tooltip" data-placement="bottom" title="ចុចដើម្បីបង្ហាញប៊ូតុង" style="display:'+displayNone+'"></div>' +
						'<div class="wrap-button-swipe">' +
						'<div class="swipeDelete" style="cursor:pointer" onclick="confirmDelete('+key+','+response[key]['Id']+')"><p>លុប</p></div>' +
						'<div class="swipeEdit" style="cursor:pointer" onclick="getNew('+response[key]['Id']+')"><p>កែប្រែ</p></div>' +
						'</div>' +
						'</td>'+
						'</tr>');

				}
				endLoadingWaiting();

			}
			if(response == ''){
				$(".listPersonalMeeting").remove();
				$("#personalMeeting").removeClass('allMeetingView');
				$("#listPersoanlMeeting_" + key).remove();
				$("#tbodyPeraonalData").append('<tr style="border-bottom:none" id="listPersoanlMeeting_'+key+'" style="color:'+color+' ">' +
					'<td colspan="6" style="text-align: center;">មិនមានកិច្ចប្រជុំ</td>'+
					'</tr>');
			}

		}
	});
}
function listAll() {
    $("#listAllform").css('display','block');
	$("#listPersonalMeeting").css('display', 'none');
	$("#newForm").css('display','none');
	$("#personalCalendar").css('display','none');
	$("#listAllHistoryForm").css('display','none');
	$(".clCalendar").removeClass('actives');
	$(".clpersonal").removeClass('actives');
	$(".clListAll").addClass('actives');
	$(".clNew").removeClass('actives');
	$(".clListAllHistory").removeClass('actives');
	$(".roomChecking").removeClass('actives');
	$("#formSearch").css('display','block');

	loadingWaiting();
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

	                var todayInter = new Date();
	                var dateInter = todayInter.getFullYear() + '-' + (todayInter.getMonth() + 1) + '-' + todayInter.getDate();
	                var timeInter = todayInter.getHours() + ":" + todayInter.getMinutes() + ":" + todayInter.getSeconds();
	                var dateTimeInter = dateInter + ' ' + timeInter;
	                var currentTimeInter = Date.parse(dateTimeInter);
	                var finishTime = Date.parse(response[key]['meeting_date_en'] + ' ' + response[key]['finishTime']);
	                var color;
	                if(finishTime <= currentTimeInter){

	                	color ='darkgray';
	                }else{
		                color ='';
	                }
	                var location;
	                if(response[key]['location'] ==null){
	                	location ='ប្រជុំខាក្រៅ';
	                }else{
		                location = response[key]['location'];
	                }

	                $(".listMeeting").remove();
	                $("#allMeeting").addClass('allMeetingView');
					$("#listMeeting_"+key).remove();
//
					$("#tbodyAllData").append('<tr id="listMeeting_'+key+'" style="color:'+color+';" class="detial">' +
		                '<td>'+response[key]['meeting_date_kh']+' <br /><span style="color:'+color+' ">'+response[key]['meeting_time']+'-'+response[key]['meeting_end_time']+'</span> </td>'+
		                '<td style="cursor:pointer" onclick="detail('+response[key]['Id']+')">'+response[key]['objective']+'</td>'+
		                '<td style="cursor:pointer" onclick="detail('+response[key]['Id']+')">'+response[key]['chaire_by']+'</td>'+
		                '<td style="cursor:pointer" data-toggle="tooltip" style="cursor:pointer"  title="'+response[key]['list_official']+'" onclick="detail('+response[key]['Id']+')">'+strOfficer+'...</td>'+
		                '<td style="cursor:pointer" onclick="detail('+response[key]['Id']+')">'+location+'</td>'+
		                '<td>' +
		                '<div class="menuDot" data-toggle="tooltip" data-placement="bottom" title="ចុចដើម្បីបង្ហាញប៊ូតុង" style="display:'+displayNone+'"></div>' +
		                '<div class="wrap-button-swipe">' +
		                '<div class="swipeDelete" style="cursor:pointer" onclick="confirmDelete('+key+','+response[key]['Id']+')"><p>លុប</p></div>' +
		                '<div class="swipeEdit" style="cursor:pointer" onclick="getNew('+response[key]['Id']+')"><p>កែប្រែ</p></div>' +
		                '</div>' +
		                '</td>'+
		                '</tr>');

                }
				endLoadingWaiting();

			}
			if(response == ''){
				$(".listMeeting").remove();
				$("#allMeeting").removeClass('allMeetingView');
				$("#listMeeting_"+key).remove();
				$("#tbodyAllData").append('<tr  style="border-bottom:none" id="listMeeting_'+key+'" style="color:'+color+';" class="detial"><td colspan="6" style="text-align:center;border-bottom:none">មិនមានកិច្ចប្រជុំ</td></tr>');
			}

		}
	});
}

function listAllHistory() {
	$("#listAllHistoryForm").css('display','block');
	$("#listAllform").css('display','none');
	$("#listPersonalMeeting").css('display', 'none');
	$("#newForm").css('display','none');
	$("#personalCalendar").css('display','none');
	$(".clListAllHistory").addClass('actives');
	$(".clCalendar").removeClass('actives');
	$(".clpersonal").removeClass('actives');
	$(".clListAll").removeClass('actives');
	$(".clNew").removeClass('actives');
	$(".roomChecking").removeClass('actives');
	$("#formSearch").css('display','none');
}

$('#div_DateSearch').on('change', function (event) {
	var date = $("#div_DateSearch").val();
	loadingWaiting();
	$.ajax({
		type: "post",
		url: baseUrl + 'schedule/get-all-history-meeting',
		datatype: "json",
		data: {'date':date,"_token": '{{ csrf_token() }}'},
		success: function (response) {

			$('.mission').remove();
			if (response != undefined) {
					<?php
					$user = session('sessionGuestUser')->Id;
					?>
				var userId = '{{$user}}';
				$(".historyMeeting").remove();
				for (var key = 0; key < Object.keys(response).length; key++) {
					if (response[key]['create_by_user_id'] != userId) {
						var displayNone = 'none';

					} else {
						var displayNone = '';
					}
					var listOfficer = response[key]['list_official'];
					var array = listOfficer.split(',');

					var strOfficer = '';
					for (var i = 0; i < 4; i++) {
						if (array[i] != undefined) {
							strOfficer = array[i] + '/' + strOfficer;
						}

					}

					var todayInter = new Date();
					var dateInter = todayInter.getFullYear() + '-' + (todayInter.getMonth() + 1) + '-' + todayInter.getDate();
					var timeInter = todayInter.getHours() + ":" + todayInter.getMinutes() + ":" + todayInter.getSeconds();
					var dateTimeInter = dateInter + ' ' + timeInter;
					var currentTimeInter = Date.parse(dateTimeInter);
					var finishTime = Date.parse(response[key]['meeting_date_en'] + ' ' + response[key]['finishTime']);
					var color;
					if (finishTime <= currentTimeInter) {

						color = 'darkgray';
					} else {
						color = '';
					}
					var location;
					if (response[key]['location'] == null) {
						location = 'ប្រជុំខាក្រៅ';
					} else {
						location = response[key]['location'];
					}

					$(".listMeeting").remove();
					$("#allHistoryMeeting").addClass('allMeetingView');
					$("#listHistoryMeeting_"+ key).remove();
//
					$("#tbodyAllHistoryData").append('<tr id="listHistoryMeeting_' + key + '" style="color:' + color + ';" class="historyMeeting">' +
						'<td>' + response[key]['meeting_date_kh'] + ' <br /><span style="color:' + color + ' ">' + response[key]['meeting_time'] + '-' + response[key]['meeting_end_time'] + '</span> </td>' +
						'<td>' + response[key]['objective'] + '</td>' +
						'<td>' + response[key]['chaire_by'] + '</td>' +
						'<td data-toggle="tooltip" style="cursor:pointer"  title="' + response[key]['list_official'] + '" onclick="detail(' + response[key]['Id'] + ')">' + strOfficer + '...</td>' +
						'<td>' + location + '</td>' +
						'</tr>');

				}

				endLoadingWaiting();
				$("#tblHistoryMeetingAll").css('display','table');
				$("#noDataHistory").css('display','none')
			}
			if(response ==''){
				$(".historyMeeting").remove();
				$("#tblHistoryMeetingAll").css('display','none');
				$("#noDataHistory").css('display','block');
				$("#spanNoHistoryMeeting").text(date);
			}

		}
	});
//	setTimeout(function(){
//
//	},2000);
});

//$.urlParamss = function(name){
//	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
//	if(results){
//		return results[1] || 0;
//	}else{
//		return 0;
//	}
//}
//
//if(window.location.href.indexOf("d") > -1) {
//	detail($.urlParamss('d'));
//}

//open form detail
function detail(meeting_id) {
	var url = baseUrl+'schedule/detail';
	var token = document.getElementById('token').value;
	var window_title = 'ព័ត៌មានលំអិត';
	var window_width = 700;
	var window_height = 600;
	var params = {
		'mission_id':meeting_id,
		'_token':token
	};
	newJqxItem(window_title,window_width,window_height,url,params);
}
//open form new
function getNew(meeting_id) {
	var title;
	if(meeting_id ==0){
		title = '{{trans('schedule.create-meeting')}}';
	}else{
		title = '{{trans('schedule.edit-meeting')}}';
	}
	var url = baseUrl+'schedule/new';
	var token = document.getElementById('token').value;
	var window_title = title;
	var window_width = 1000;
	var window_height = '100%';
	var params = {
		'meeting_id':meeting_id,
		'_token':token
	};
	newJqxItem(window_title,window_width,window_height,url,params);
}

function newJqxItem(windowTitle,windowWidth, windowHeight, url, params) {
	var prefix = '<?php echo $jqxPrefix ?>';
	var id = "jqxwindow"+prefix;
	createJqxWindowId(id);
	$('#'+id).jqxWindow({ theme: jqxTheme, width: windowWidth, height:windowHeight, resizable: true, isModal: true, modalOpacity: 0.7, animationType: 'slide',maxHeight:windowHeight,maxWidth:windowWidth,
		initContent: function(){
			$('#'+id).jqxWindow('setTitle',windowTitle);
			$.ajax({
				type: 'post',
				url: url,
				data:params,
				success: function (data) {
					$('#'+id).jqxWindow('setContent',data);
				},
				error: function (request, status, error) {
					console.log(request.responseText);
				}
			});
			$('#'+id).on('close',function(){
				closeJqxWindowId(id);
			});
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
							$('#jqx-notification').jqxNotification({position: 'top-right',template: "success" });
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