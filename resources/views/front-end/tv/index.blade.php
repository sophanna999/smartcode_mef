<?php
$getNewDataUrl = url('/tv/new-data');
$getAllDataUrl = url('/tv/all-data');
?>
@extends('layout.tv')
@section('content')
	<style>
		.badge {
			-vendor-animation-duration: 3s;
			animation-duration: 4s;
			-vendor-animation-delay: 3s;
			animation-delay: 3s;
			-vendor-animation-iteration-count: infinite;
		}

		.demo1 {
			 height: 394px !important; 
			overflow-y: hidden;
		}

		.demo2 {
			/*height: 660px !important;*/
			overflow-y: hidden;
		}
		.demo1 .news-item{
			 height:50%; 
			 overflow:hidden;
		}

	</style>
	<div class="container-fluid" style="padding-right: 0; padding-left: 0;">
		<div class="row">
			<div class="col-md-12 cover">
				<div class="row">
					<div class="col-md-8 ">
						<input type="hidden" id="lastid" value="{{isset($create_date->create_date) ? $create_date->create_date:''}}"></input>
						<input type="hidden" id="count" value="{{isset($count) ? $count:''}}"></input>
						<div class="panel" style="position:relative;z-index:10;">
							<div class="demo1-parent">
								<ul class="demo1">

								</ul>
							</div>
						</div>
						<div class="panel" style="margin-top:-11.5%;position:relative;z-index:1;">

									<div class="demo2-parent" style="padding:0">
										<ul class="demo2">

										</ul>
									</div>
								{{--</div>--}}
							{{--</div>--}}

						</div>

					</div>
					<!-- block big meeting 1-->
					<div class="col-md-4 left-meeting" id="">

						<div class="div_nearlyMeeting">
							<div class="my_meeting nearlyMeeting">

							</div>
						</div>

						<!-- block big meeting 2 -->
						<hr style="width: 70%;margin:0 0 0 0;margin:0 auto;border-top: 1px solid #389380;">
						<div class="div_meeting">
							<div class="my_meeting meeting">

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="footer_marquee wrap-footer">
		<div class="col-md-1" style="margin-top: 25px;">
			<span style="margin-left: 10px; font-family: KHMERMEF2;font-size:17px;text-shadow: 1px 1px 7px rgba(108, 110, 110, 0.77);">ថ្ងៃឈប់សម្រាក</span>
		</div>
		<div class="col-md-11 footer-ann" style="margin-top: 10px;line-height: 45px;font-size:20px;overflow:hidden;position:relative;left:80px;">
			<div class="marquee">
				<span> ០១ មករា	ទិវា​ចូល​ឆ្នាំ​សកល</span>
				<span> ០៧ មករា	ទិវា​ជ័យជំនះ​លើ​របប​ប្រល័យ​ពូជ​សាសន៍</span>
				<span>៣១ មករា	ពិធី​បុណ្យ​មាឃ​បូជា</span>
				<span>០៨ មីនា	ទិវា​នារី​អន្តរជាតិ</span>
				<span>១៤-១៥-១៦ មេសា	ពិធីបុណ្យ​ចូលឆ្នាំថ្មី ប្រពៃណីជាតិ ឆ្នាំច សំរិទ្ធិ​ស័ក</span>
				<span>២៩ មេសា	ពី​ធី​បុណ្យ​វិសាខបូជា</span>
				<span>០១ ឧសភា	ទិវា​ពលកម្ម​អន្តរជាតិ</span>
				<span>៣ ឧសភា	ព្រះរាជ​ពិធីច្រត់ព្រះនង្គ័ល</span>
				<span>១៣-១៤-១៥ ឧសភា	ព្រះ​រាជ​ពិធី​បុណ្យ​ចម្រើន​ព្រះ​ជន្ម ព្រះ​ករុណា​ព្រះ​បាទ​សម្តេច​ព្រះ​បរម​នាថ នរោត្តម សីហមុនី ព្រះ​មហាក្សត្រ​នៃ​ព្រះរាជាណាចក្រ​កម្ពុជា</span>
				<span>០១ មិថុនា	ទិវា​កុមារ​អន្តរ​ជាតិ</span>
				<span>១៨ មិថុនា	ព្រះ​រាជ​ពិធី​បុណ្យ​ចម្រើន​ព្រះ​ជន្ម សម្តេច​ព្រះ​មហាក្សត្រី ព្រះវររាជ​មាតា នរោត្តម មុនិនាថ សីហនុ</span>
				<span>២៤ កញ្ញា	ទិវា​ប្រកាស​រដ្ឋ​ធម្មនុញ្ញ</span>
				<span>០៨-០៩-១០ តុលា	ពិធី​បុណ្យ​ភ្ជុំ​បិណ្ឌ</span>
				<span>១៥ តុលា	ទិវា​ប្រារព្ធ​ពិធី​គោរព​ព្រះវិញ្ញាណក្ខន្ធ ព្រះករុណា​ព្រះបាទ​សម្តេច​ព្រះ នរោត្តម សីហនុ ព្រះមហាវីរក្សត្រ ព្រះ​វររាជ​បិតា​ឯករាជ្យ បូរណភាព​ទឹកដី និង​ឯកភាព​ជាតិ​ខ្មែរ ​«ព្រះបរមរតនកោដ្ឋ»</span>
				<span>២៣ តុលា	ទិវារំលឹក​ខួប​នៃ​កិច្ចព្រមព្រៀង​សន្តិភាព​ទីក្រុង​ប៉ារីស</span>
				<span>២៩ តុលា	ព្រះ​រាជ​ពិធី​គ្រង​ព្រះ​បរម​រាជ​សម្បត្តិ​របស់​ ព្រះ​ករុណា​ព្រះ​បាទ​សម្តេច​ព្រះ​បរមនាថ នរោត្តម សីហមុនី ព្រះ​មហាក្សត្រ​នៃ​ព្រះរាជាណាចក្រ​កម្ពុជា</span>
				<span>០៩ វិច្ឆិកា	ពិធី​បុណ្យ​ឯករាជ្យ​ជាតិ</span>
				<span>២១-២២-២៣ វិច្ឆិកា	ព្រះរាជ​ពិធីបុណ្យ​អុំទូក បណ្តែតប្រទីប និង​សំពះព្រះខែ អកអំបុក</span>
				<span>១០ ធ្នូ	ទិវា​សិទ្ធិ​មនុស្ស​អន្តរជាតិ</span>
			</div>
		</div>

	</div>
	</div>
	<script>

		var meetingList = {};
		var meetingOnTime = {};
		var lastRequestDate;
		var nearlyOnTime;
		var OnTime;
		var other;

		var currentDate = new Date();
		var dd = currentDate.getDate();
		var mm = currentDate.getMonth()+1; //January is 0!
		var yyyy = currentDate.getFullYear();
		if(dd<10) {
			dd = '0'+dd
		}

		if(mm<10) {
			mm = '0'+mm
		}
		currentDate = yyyy + '-' + mm + '-' +dd ;

		$(document).ready(function () {
			$(".demo1").off('hover');
			$(".demo2").off('hover');

//			$(".render").append(navigator.userAgent);

			getAllDate();
			lastRequestDate = $("#lastid").val();
			setInterval(function () {
				// meetingOnTime = {};
				$(".demo2").remove()
				$(".demo1").remove();

				$(".demo2-parent").append('<ul class="demo2"></ul>');
				$(".demo1-parent").append('<ul class="demo1"></ul>');

				var count = false;
				var countM = false;

				var todayInter = new Date();
				var dateInter = todayInter.getFullYear() + '-' + (todayInter.getMonth() + 1) + '-' + todayInter.getDate();
				var timeInter = todayInter.getHours() + ":" + todayInter.getMinutes() + ":" + todayInter.getSeconds();
				var dateTimeInter = dateInter + ' ' + timeInter;
				var currentTimeInter = Date.parse(dateTimeInter);
				var currentDateInter = new Date();
				var dd = currentDateInter.getDate();
				var mm = currentDateInter.getMonth()+1; //January is 0!
				var yyyy = currentDateInter.getFullYear();
				if(dd<10) {
					dd = '0'+dd
				}

				if(mm<10) {
					mm = '0'+mm
				}
				currentDateInter = yyyy + '-' + mm + '-' +dd ;

//				console.log('allObject',meetingList);
				for (var d = 0; d < Object.keys(meetingList).length; d++) {

					var nearlyTimeCheck_timeInter = Date.parse(meetingList[d]['meeting_date_en'] + ' ' + meetingList[d]['check_time']);
					var nearlyTimeMeeting_24Inter = Date.parse(meetingList[d]['meeting_date_en'] + ' ' + meetingList[d]['meeting_time_24']);
					var nearlyTimeFinishTimeInter = Date.parse(meetingList[d]['meeting_date_en'] + ' ' + meetingList[d]['finishTime']);

					var strObjectInterDiv1 = meetingList[d]['objective'];
					var fontSizeObjeInterDiv1;
					var demo2ObjectiveInterDiv1;
					if(strObjectInterDiv1.length > 100){
						fontSizeObjeInterDiv1 = '20px';
						demo2ObjectiveInterDiv1 = strObjectInterDiv1.substr(0,100)+'...';
					}else{
						fontSizeObjeInterDiv1 = '24px';
						demo2ObjectiveInterDiv1 = strObjectInterDiv1;
					}

					var listOfficerInter;
//					console.log('testing1',meetingList[d]['list_official']);
//					return;
					if(meetingList[d]['list_official'] ==null){
						listOfficerInter = ",";
					}else {
						listOfficerInter =meetingList[d]['list_official'];
					}
					var fieldsInter = listOfficerInter.split(',');

					var meetingRoomInter;
					if(meetingList[d]['location'] == null) {
						meetingRoomInter = 'ប្រជុំខាងក្រៅ';
					}else{
						meetingRoomInter = meetingList[d]['location'];
					}

					if (currentTimeInter >= nearlyTimeCheck_timeInter && currentTimeInter < nearlyTimeMeeting_24Inter) {
						meetingOnTime[0] = meetingList[d];
						nearlyOnTime = meetingList[d]['Id'];
//						 alert(nearlyTimeCheck_timeInter);
						$(".nearlyMeeting").remove();
						$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
						$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
							'<p>' +
							'<i class="fa fa-clock-o"></i> ' + meetingList[d]['meeting_date_kh'] +
							'<span class="pad-badge badge animated infinite flash meetingTime" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #ee984c; padding: 10px"><span>' + meetingList[d]['meeting_time'] +' - '+ meetingList[d]['meeting_end_time']+
							'</span></span>' +
							'<span class="pad-badge badge animated infinite flash test" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #ee984c; margin: 10px; padding: 10px;">ជិតប្រជុំ' +
							'</span>' +
							'</p>' +
							'<p ><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeInterDiv1+'"> ' + meetingList[d]['objective'] + '</span></p>' +
							'<p><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + meetingList[d]['chaire_by'] + '</span></p>' +
							'<p><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18 font18"> ' + meetingRoomInter + '</span></p>' +
							'<address style="text-align: justify; color: #ffffff; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
							'<ul class="listOfficer1"></ul>'+
							'</address>' +
							'</div>');
						count = true;

						$.each(fieldsInter,function (key,value) {
							//									alert(value);
							$('.listOfficer1').append(
								'<li class="pull-left text-meeting paticipant">' +
								'' + value+ '</li>'
							);
						});
						break;

					} else if (currentTimeInter >= nearlyTimeMeeting_24Inter && currentTimeInter <= nearlyTimeFinishTimeInter) {
						var OnTime1 = {};
						OnTime1[d] = meetingList[d];

						if (d == d) {
							meetingOnTime[0] = meetingList[d];
							OnTime = meetingList[d]['Id'];
							$(".nearlyMeeting").remove();
							$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
							$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
								'<p>' +
								'<i class="fa fa-clock-o"></i> ' + meetingList[d]['meeting_date_kh'] +
								'<span class="pad-badge badge animated infinite flash meetingTime" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #d65d51; padding: 10px">' + meetingList[d]['meeting_time'] +' - '+ meetingList[d]['meeting_end_time']+
								'</span>' +
								'<span class="pad-badge badge animated infinite flash test" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #d65d51; margin: 10px; padding: 10px;" id="nearlyMeeting">កំពុងប្រជុំ' +
								'</span>' +
								'</p>' +
								'<p ><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeInterDiv1+'"> ' + meetingList[d]['objective'] + '</span></p>' +
								'<p><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + meetingList[d]['chaire_by'] + '</span></p>' +
								'<p><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18 font18"> ' + meetingRoomInter + '</span></p>' +
								'<address style=" color: #ffffff; line-height: 30px; margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
								'<ul class="listOfficer1"></ul>'+
								'</address>' +
								'</div>');
							count = true;

							$.each(fieldsInter,function (key,value) {
								//									alert(value);
								$('.listOfficer1').append(
									'<li class="pull-left text-meeting paticipant">' +
									'' + value+ '</li>'
								);
							});
							break;
						}

					} else {
						if( Object.keys(meetingList).length > 2){
//							alert(currentDate);
							if (d == d && currentTimeInter < nearlyTimeMeeting_24Inter && meetingList[d]['meeting_date_en'] ==currentDateInter){
								meetingOnTime[0] = meetingList[d];
								other = meetingList[d]['Id'];
								var textColorInterNear;
								if (currentTimeInter > nearlyTimeFinishTimeInter) {
									textColorInterNear = '#8DC0B1';
									color = "cfe4e0";
								} else {
									textColorInterNear = '#ffffff';
									color = "bec661";
								}

								$(".nearlyMeeting").remove();
								$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
								$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
									'<p class = "meetingC" style="color:' + textColorInterNear + '">' +
									'<i class="fa fa-clock-o"></i> ' + meetingList[d]['meeting_date_kh'] +
									'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #' + color + '; padding: 10px">' + meetingList[d]['meeting_time'] +' - '+ meetingList[d]['meeting_end_time']+
									'</span>' +
									'</p>' +
									'<p style="color:' + textColorInterNear + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeInterDiv1+'"> ' + meetingList[d]['objective'] + '</span></p>' +
									'<p style="color:' + textColorInterNear + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + meetingList[d]['chaire_by'] + '</span></p>' +
									'<p style="color:' + textColorInterNear + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomInter + '</span></p>' +
									'<address style="color:' + textColorInterNear + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
									'<ul class="listOfficer1"></ul>'+
									'</address>' +
									'</div>');
								$.each(fieldsInter,function (key,value) {
									//									alert(value);
									$('.listOfficer1').append(
										'<li class="pull-left text-meeting paticipant">' +
										'' + value+ '</li>'
									);
								});
//								break;
							}else if (d == d && currentTimeInter < nearlyTimeMeeting_24Inter && meetingList[d]['meeting_date_en'] > currentDateInter) {

								meetingOnTime[0] = meetingList[d];
								other = meetingList[d]['Id'];
								var textColorInterNear;
								if (currentTimeInter > nearlyTimeFinishTimeInter) {
									textColorInterNear = '#8DC0B1';
									color = "cfe4e0";
								} else {
									textColorInterNear = '#ffffff';
									color = "bec661";
								}

								$(".nearlyMeeting").remove();
								$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
								$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
									'<p class = "meetingC" style="color:' + textColorInterNear + '">' +
									'<i class="fa fa-clock-o"></i> ' + meetingList[d]['meeting_date_kh'] +
									'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #' + color + '; padding: 10px">' + meetingList[d]['meeting_time'] +' - '+ meetingList[d]['meeting_end_time']+
									'</span>' +
									'</p>' +
									'<p style="color:' + textColorInterNear + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeInterDiv1+'"> ' + meetingList[d]['objective'] + '</span></p>' +
									'<p style="color:' + textColorInterNear + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + meetingList[d]['chaire_by'] + '</span></p>' +
									'<p style="color:' + textColorInterNear + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomInter + '</span></p>' +
									'<address style="color:' + textColorInterNear + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
									'<ul class="listOfficer1"></ul>' +
									'</address>' +
									'</div>');
								$.each(fieldsInter, function (key, value) {
									//									alert(value);
									$('.listOfficer1').append(
										'<li class="pull-left text-meeting paticipant">' +
										'' + value + '</li>'
									);
								});
								break;

							}else{
								$(".nearlyMeeting").remove();
							}
						}else{

							meetingOnTime[0] = meetingList[d];
							other = meetingList[d]['Id'];
							var textColorInterNear;
							if (currentTimeInter > nearlyTimeFinishTimeInter) {
								textColorInterNear = '#8DC0B1';
								color = "cfe4e0";

								$(".nearlyMeeting").remove();
								$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
								$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
									'<p class = "meetingC" style="color:' + textColorInterNear + '">' +
									'<i class="fa fa-clock-o"></i> ' + meetingList[d]['meeting_date_kh'] +
									'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #' + color + '; padding: 10px">' + meetingList[d]['meeting_time'] +' - '+ meetingList[d]['meeting_end_time']+
									'</span>' +
									'</p>' +
									'<p style="color:' + textColorInterNear + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeInterDiv1+'"> ' + meetingList[d]['objective'] + '</span></p>' +
									'<p style="color:' + textColorInterNear + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + meetingList[d]['chaire_by'] + '</span></p>' +
									'<p style="color:' + textColorInterNear + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomInter + '</span></p>' +
									'<address style="color:' + textColorInterNear + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
									'<ul class="listOfficer1"></ul>'+
									'</address>' +
									'</div>');
								$.each(fieldsInter,function (key,value) {
									//									alert(value);
									$('.listOfficer1').append(
										'<li class="pull-left text-meeting paticipant">' +
										'' + value+ '</li>'
									);
								});
								break;
							} else {
								textColorInterNear = '#ffffff';
								color = "bec661";

								$(".nearlyMeeting").remove();
								$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
								$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
									'<p class = "meetingC" style="color:' + textColorInterNear + '">' +
									'<i class="fa fa-clock-o"></i> ' + meetingList[d]['meeting_date_kh'] +
									'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #' + color + '; padding: 10px">' + meetingList[d]['meeting_time'] +' - '+ meetingList[d]['meeting_end_time']+
									'</span>' +
									'</p>' +
									'<p style="color:' + textColorInterNear + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeInterDiv1+'"> ' + meetingList[d]['objective'] + '</span></p>' +
									'<p style="color:' + textColorInterNear + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + meetingList[d]['chaire_by'] + '</span></p>' +
									'<p style="color:' + textColorInterNear + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomInter + '</span></p>' +
									'<address style="color:' + textColorInterNear + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
									'<ul class="listOfficer1"></ul>'+
									'</address>' +
									'</div>');
								$.each(fieldsInter,function (key,value) {
									//									alert(value);
									$('.listOfficer1').append(
										'<li class="pull-left text-meeting paticipant">' +
										'' + value+ '</li>'
									);
								});
								break;
							}

						}

					}
				}
				for (var e = 0; e < Object.keys(meetingList).length; e++) {

					var OnTimeCheck_timeInter = Date.parse(meetingList[e]['meeting_date_en'] + ' ' + meetingList[e]['check_time']);
					var OnTimeMeeting_24Inter = Date.parse(meetingList[e]['meeting_date_en'] + ' ' + meetingList[e]['meeting_time_24']);
					var OnTimeFinishTimeInter = Date.parse(meetingList[e]['meeting_date_en'] + ' ' + meetingList[e]['finishTime']);

					var strObjectInterDiv2 = meetingList[e]['objective'];
					var fontSizeObjeInterDiv2;
					var demo2ObjectiveInterDiv2;
					if(strObjectInterDiv2.length > 100){
						fontSizeObjeInterDiv2 = '20px';
						demo2ObjectiveInterDiv2 = strObjectInterDiv2.substr(0,100)+'...';
					}else{
						fontSizeObjeInterDiv2 = '24px';
						demo2ObjectiveInterDiv2 = strObjectInterDiv2;
					}

					var listOfficerInter;
					if(meetingList[e]['list_official'] ==null){
						listOfficerInter = ",";
					}else {
						listOfficerInter = meetingList[e]['list_official'];
					}
					var fieldsInter = listOfficerInter.split(',');

					var meetingRoomInter2;
					if(meetingList[e]['location'] == null) {
						meetingRoomInter2 = 'ប្រជុំខាងក្រៅ';
					}else{
						meetingRoomInter2 = meetingList[e]['location'];
					}

					if (currentTimeInter >= OnTimeMeeting_24Inter && currentTimeInter < OnTimeFinishTimeInter) {
						// alert(1);
						if (meetingList[e]['Id'] != OnTime) {
							meetingOnTime[1] = meetingList[e];
							$(".meeting").remove();
							$(".div_meeting").append('<div class="my_meeting meeting"></div>');
							$(".meeting").append('<div class="meeting">' +
								'<p>' +
								'<i class="fa fa-clock-o"></i>' + meetingList[e]['meeting_date_kh'] +
								'<span class="pad-badge badge animated infinite flash meetingTime" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #d65d51; padding: 10px">' + meetingList[e]['meeting_time'] +' - '+ meetingList[e]['meeting_end_time']+
								'</span>' +
								'<span class="pad-badge badge animated infinite flash test" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #d65d51; margin: 10px; padding: 10px;" id="nearlyMeeting">កំពុងប្រជុំ' +
								'</p>' +
								'<p ><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeInterDiv2+'"> ' + meetingList[e]['objective'] + '</span></p>' +
								'<p><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + meetingList[e]['chaire_by'] + '</span></p>' +
								'<p><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomInter2 + '</span></p>' +
								'<address style=" color: #ffffff; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
								'<ul class="listOfficer2"></ul>'+
								'</address>' +
								'</div>');
							countM = true;

							$.each(fieldsInter,function (key,value) {
//									alert(value);
								$('.listOfficer2').append(
									'<li class="pull-left text-meeting paticipant">' +
									'' + value+ '</li>'
								);
							});
							break;
						}
						// }

					} else if (currentTimeInter >= OnTimeCheck_timeInter && currentTimeInter < OnTimeMeeting_24Inter) {

						if (meetingList[e]['Id'] != nearlyOnTime && nearlyOnTime != 'undefined') {
							$(".meeting").remove();
							$(".div_meeting").append('<div class="my_meeting meeting"></div>');
							meetingOnTime[1] = meetingList[e];

							$(".meeting").append('<div class="meeting">' +
								'<p>' +
								'<i class="fa fa-clock-o"></i> ' + meetingList[e]['meeting_date_kh'] +
								'<span class="pad-badge badge animated infinite flash meetingTime" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #ee984c; padding: 10px">' + meetingList[e]['meeting_time'] +' - '+ meetingList[e]['meeting_end_time']+
								'</span>' +
								'<span class="pad-badge badge animated infinite flash test" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #ee984c; margin: 10px; padding: 10px;">ជិតប្រជុំ' +
								'</span>' +
								'</p>' +
								'<p ><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeInterDiv2+'"> ' + meetingList[e]['objective'] + '</span></p>' +
								'<p><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + meetingList[e]['chaire_by'] + '</span></p>' +
								'<p><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomInter2 + '</span></p>' +
								'<address style=" color: #ffffff; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
								'<ul class="listOfficer2"></ul>'+
								'</address>' +
								'</div>');
							count = true;

							$.each(fieldsInter,function (key,value) {
//									alert(value);
								$('.listOfficer2').append(
									'<li class="pull-left text-meeting paticipant">' +
									'' + value+ '</li>'
								);
							});
							break;
						}

					} else {
						if( Object.keys(meetingList).length == 2){

							if (meetingList[e]['Id'] != other  && meetingList[e]['meeting_date_en'] ==currentDateInter && currentTimeInter < OnTimeCheck_timeInter){
								$(".meeting").remove();
								$(".div_meeting").append('<div class="my_meeting meeting"></div>');
								meetingOnTime[1] = meetingList[e];
								var textColorInterOn;
								var color;
								if (currentTimeInter > OnTimeFinishTimeInter) {
									textColorInterOn = '#8DC0B1';
									color = "#cfe4e0";
								} else {
									textColorInterOn = '#ffffff';
									color = "#" +
										"";
								}

								$(".meeting").append('<div class="meeting">' +
									'<p class="meetingC" style="color:' + textColorInterOn + '">' +
									'<i class="fa fa-clock-o"></i>' + meetingList[e]['meeting_date_kh'] +
									'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + meetingList[e]['meeting_time'] +' - '+ meetingList[e]['meeting_end_time']+
									'</span>' +
									'</p>' +
									'<p style="color:' + textColorInterOn + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeInterDiv2+'">' + meetingList[e]['objective'] + '</span></p>' +
									'<p style="color:' + textColorInterOn + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + meetingList[e]['chaire_by'] + '</span></p>' +
									'<p style="color:' + textColorInterOn + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomInter2 + '</span></p>' +
									'<address style=" color:' + textColorInterOn + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
									'<ul class="listOfficer2"></ul>'+
									'</address>' +
									'</div>');

								$.each(fieldsInter,function (key,value) {
//									alert(value);
									$('.listOfficer2').append(
										'<li class="pull-left text-meeting paticipant">' +
										'' + value+ '</li>'
									);
								});
								break;
							}else if (meetingList[e]['Id'] != other  && meetingList[e]['meeting_date_en'] > currentDateInter && currentTimeInter < OnTimeCheck_timeInter){
								$(".meeting").remove();
								$(".div_meeting").append('<div class="my_meeting meeting"></div>');
								meetingOnTime[1] = meetingList[e];
								var textColorInterOn;
								var color;
								if (currentTimeInter > OnTimeFinishTimeInter) {
									textColorInterOn = '#8DC0B1';
									color = "#cfe4e0";
								} else {
									textColorInterOn = '#ffffff';
									color = "#bec661";
								}

								$(".meeting").append('<div class="meeting">' +
									'<p class="meetingC" style="color:' + textColorInterOn + '">' +
									'<i class="fa fa-clock-o"></i>' + meetingList[e]['meeting_date_kh'] +
									'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + meetingList[e]['meeting_time'] +' - '+ meetingList[e]['meeting_end_time']+
									'</span>' +
									'</p>' +
									'<p style="color:' + textColorInterOn + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeInterDiv2+'">' + meetingList[e]['objective'] + '</span></p>' +
									'<p style="color:' + textColorInterOn + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + meetingList[e]['chaire_by'] + '</span></p>' +
									'<p style="color:' + textColorInterOn + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomInter2 + '</span></p>' +
									'<address style=" color:' + textColorInterOn + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
									'<ul class="listOfficer2"></ul>'+
									'</address>' +
									'</div>');

								$.each(fieldsInter,function (key,value) {
//									alert(value);
									$('.listOfficer2').append(
										'<li class="pull-left text-meeting paticipant">' +
										'' + value+ '</li>'
									);
								});
								break;
							}else{
								$(".meeting").remove();
							}
						}else{
							if (meetingList[e]['Id'] != other ){
								$(".meeting").remove();
								$(".div_meeting").append('<div class="my_meeting meeting"></div>');
								meetingOnTime[1] = meetingList[e];
								var textColorInterOn;
								var color;
								if (currentTimeInter > OnTimeFinishTimeInter) {
									textColorInterOn = '#8DC0B1';
									color = "#cfe4e0";

									$(".meeting").append('<div class="meeting">' +
										'<p class="meetingC" style="color:' + textColorInterOn + '">' +
										'<i class="fa fa-clock-o"></i>' + meetingList[e]['meeting_date_kh'] +
										'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + meetingList[e]['meeting_time'] +' - '+ meetingList[e]['meeting_end_time']+
										'</span>' +
										'</p>' +
										'<p style="color:' + textColorInterOn + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeInterDiv2+'">' + meetingList[e]['objective'] + '</span></p>' +
										'<p style="color:' + textColorInterOn + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + meetingList[e]['chaire_by'] + '</span></p>' +
										'<p style="color:' + textColorInterOn + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomInter2 + '</span></p>' +
										'<address style=" color:' + textColorInterOn + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
										'<ul class="listOfficer2"></ul>'+
										'</address>' +
										'</div>');

									$.each(fieldsInter,function (key,value) {
//									alert(value);
										$('.listOfficer2').append(
											'<li class="pull-left text-meeting paticipant">' +
											'' + value+ '</li>'
										);
									});
								} else {
									textColorInterOn = '#ffffff';
									color = "#bec661";

									$(".meeting").append('<div class="meeting">' +
										'<p class="meetingC" style="color:' + textColorInterOn + '">' +
										'<i class="fa fa-clock-o"></i>' + meetingList[e]['meeting_date_kh'] +
										'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + meetingList[e]['meeting_time'] +' - '+ meetingList[e]['meeting_end_time']+
										'</span>' +
										'</p>' +
										'<p style="color:' + textColorInterOn + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeInterDiv2+'">' + meetingList[e]['objective'] + '</span></p>' +
										'<p style="color:' + textColorInterOn + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + meetingList[e]['chaire_by'] + '</span></p>' +
										'<p style="color:' + textColorInterOn + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomInter2 + '</span></p>' +
										'<address style=" color:' + textColorInterOn + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
										'<ul class="listOfficer2"></ul>'+
										'</address>' +
										'</div>');

									$.each(fieldsInter,function (key,value) {
//									alert(value);
										$('.listOfficer2').append(
											'<li class="pull-left text-meeting paticipant">' +
											'' + value+ '</li>'
										);
									});
									break;
								}

							}
						}
//						break;
					}
				}

				var objMeeting = meetingList;
				var objMeetingCountInter = Object.keys(objMeeting).length;
//				console.log('te', meetingOnTime);
					var endDateInter;
					var numOfMeetingTodayInter = 0;
					var numOfMeetingTotalInter = Object.keys(objMeeting).length;
					var totalNearlyMeetingInter = 0;
					var totalNotMeetingInter = 0;
					var birthdayInter = '';

					for (f = 0; f < Object.keys(objMeeting).length; f++) {
						meetingList[f] = objMeeting[f];

						var check_timeAddInter = Date.parse(objMeeting[f]['meeting_date_en'] + ' ' + objMeeting[f]['check_time']);
						var meeting_24AddInter = Date.parse(objMeeting[f]['meeting_date_en'] + ' ' + objMeeting[f]['meeting_time_24']);
						var finishTimeAddInter = Date.parse(objMeeting[f]['meeting_date_en'] + ' ' + objMeeting[f]['finishTime']);
						var listOfficerInter;
						if (objMeeting[f]['list_official'] == null) {
							listOfficerInter = ",";
						} else {
							listOfficerInter = objMeeting[f]['list_official'];
						}
						var nameInter = listOfficerInter.split(',');
						var colormeetingIn;
						var textColorIntre;
						var flash;
						if (currentTimeInter >= check_timeAddInter && currentTimeInter <= meeting_24AddInter) {
							flash = 'falsh';
							textColorIntre = '#ffffff';
							colormeetingIn = '#ee984c';
						} else if (currentTimeInter >= meeting_24AddInter && currentTimeInter <= finishTimeAddInter) {
							flash = 'falsh';
							textColorIntre = '#ffffff';
							colormeetingIn = '#d65d51';
						} else if (currentTimeInter > finishTimeAddInter) {
							flash = '';
							textColorIntre = '#8DC0B1';
							colormeetingIn = '#8DC0B1';
						} else {
							flash = '';
							textColorIntre = '#ffffff';
							colormeetingIn = '#bec661';

						}

						var meetingOnTimes;
						var meetingOnTimes2;
						if (typeof(meetingOnTime[0]) !== "undefined") {
							meetingOnTimes = meetingOnTime[0]['Id'];
						} else {
							meetingOnTimes = 0;
						}
						if (typeof(meetingOnTime[1]) !== "undefined") {
							meetingOnTimes2 = meetingOnTime[1]['Id'];
						} else {
							meetingOnTimes2 = 0;
						}

						if (objMeeting[f]['meeting_date_en'] == currentDate) {
							numOfMeetingTodayInter = numOfMeetingTodayInter + 1;
							if (objMeeting[f]['birth_day'] != null) {
								birthdayInter = objMeeting[f]['birth_day'];
							}
						}

						if (currentTimeInter >= check_timeAddInter && currentTimeInter <= meeting_24AddInter) {
							totalNearlyMeetingInter = totalNearlyMeetingInter + 1;
						}
						if (currentTimeInter < meeting_24AddInter) {
							totalNotMeetingInter = totalNotMeetingInter + 1;
						}
						endDateInter = objMeeting[f]['meeting_date_kh'];
						var strObjectInter = objMeeting[f]['objective'];
						var fontSizeObjectInter;
						var demo2ObjectiveInter;
						if(strObjectInter.length > 100){
							fontSizeObjectInter = '20px';
							demo2ObjectiveInter = strObjectInter.substr(0,100)+'...';
						}else{
							fontSizeObjectInter = '26px';
							demo2ObjectiveInter = strObjectInter;
						}

						var meetingRoomInterDemo;
						if(meetingList[f]['location'] == null) {
							meetingRoomInterDemo = 'ប្រជុំខាងក្រៅ';
						}else{
							meetingRoomInterDemo = meetingList[f]['location'];
						}

						// console.log('mId',meetingOnTimes);
						if (objMeeting[f]['Id'] != meetingOnTimes && objMeeting[f]['Id'] != meetingOnTimes2) {
							$(".demo1").append('<li class="news-item" data-id="2">' +
								'<div class="">' +
								'<div class="row testing3"  style=" ">' +
								'<div class="col-sm-2" style="border-right: 1px solid #44a28d;width: 13.666667%;">' +
								'<p class="date-block" style="color:' + textColorIntre + '">' + objMeeting[f]['meeting_date_kh'] + '</p>' +
								'<p><span class="badge badge-danger spanNearlyMeeting ' + flash + '" id="meeting" style="font-size: 20px;margin-top:-5px; margin-left: 25px;background-color: ' + colormeetingIn + '; color: #ffffff;padding: 5px">' + objMeeting[f]['meeting_time'] + '</span></p>' +
								'</div>' +
								'<input type="hidden" class="createDate" id="createDate_' + f + '" value="' + objMeeting[f]['create_date'] + '"></input>' +
								'<div class="col-md-6">' +
								'<div class="info-blog">' +
								'<div>' +
								'<i class="fa fa-file-text pull-left" style="color:' + textColorIntre + '"></i><span class="pull-left font-26" style="color:' + textColorIntre + ';font-size: '+fontSizeObjectInter+' !important;"> ' + objMeeting[f]['objective'] + '</span>' +
								'</div>' +
								'<div class="font-bold">' +
								'<i class="fa fa-user pull-left" style="color:' + textColorIntre + '"></i><span class="pull-left" style="color:' + textColorIntre + '">' + objMeeting[f]['chaire_by'] + '</span>' +
								'</div>' +
								'<div>' +
								'<i class="fa fa-map-marker pull-left" style="color:' + textColorIntre + '"></i><span class="pull-left font18" style="color:' + textColorIntre + '">' + meetingRoomInterDemo + '</span>' +
								'</div>' +
								'</div>' +

								'</div>' +
								'<div class="col-md-4">' +
								'<div class="col-md-2">' +
								'<p style=" color:' + textColorIntre + '"><i class="fa fa-users fa-lg"></i></p>' +
								'</div>' +

								'<div class="col-md-10">' +
								'<address style=" color: ' + textColorIntre + '; line-height: 30px; ">' +
								'<div id="listOfficers_' + f + '" class="listOfficer"></div>' +
								'</address>' +

								'</div>' +
								'</div>' +
								'</div>' +
								'</div>' +
								'</li>');

							$.each(nameInter, function (key, value) {
								if (key < 7) {
									$('#listOfficers_' + f).append(
										'<p class="listDemo1" style="color:'+textColorIntre+'">' +
										'' + value + '</p>'
									);
								}

							});
							if (Object.keys(nameInter).length > 7) {
								$('#listOfficers_' + f).append(
									'<p class="listDemo1" style="color:'+textColorIntre+'">.....</p>'
								);
							}

							if (objMeetingCountInter > 3) {
								$(".demo2").append('<li class="news-item"' +
									'<div >' +
									'<div >' +
									'<div class="row" style="padding: 0;">' +
									'<div class="col-md-12" style="padding-right: 0; padding-left: 0;">' +
									'<div class="col-md-2 md2-demo2" style="width:13.66667%;border-right: 1px solid #44a28d;">' +
									'<p class="date-block-small" style="color:' + textColorIntre + '">' + objMeeting[f]['meeting_date_kh'] + '</p>' +
									'<p><span class="badge badge-warning spanNearlyMeeting ' + flash + '" style="font-size: 16px;margin-top:-10px; margin-left: 38px; background-color: ' + colormeetingIn + '; color: #ffffff; padding: 5px">' + objMeeting[f]['meeting_time'] + '</span>' +
									'</p>' +
									'</div>' +

									'<div class="col-md-10 md10-demo2">' +
									'<p class="title-one-row" style="color:' + textColorIntre + '">' +
									'<i class="fa fa-file-text" style="color:' + textColorIntre + ';font-size: '+fontSizeObjectInter+' !important;"></i> ' + demo2ObjectiveInter +
									'</p>' +
									'</div>' +
									'</div>' +
									'</div>' +
									'</div>' +
									'</div>' +
									'</li>');

							}

						}

					}
					if (Object.keys(objMeeting).length >4){
						$(".demo1").append('<li class="news-item" data-id="2">' +
							'<div class="total-meeting total-meeting-demo2" style="background:#1a6a59 !important;">'+
							'<div class="row"  style=" ">' +
							'<div class="col-sm-2" style="border-right: 1px solid #44a28d;width: 13.666667%;">' +
							'<p class="date-block">'+objMeeting[0]['meeting_date_kh']+'</p>' + '<p class="toDate" style="text-align:center !important">ដល់</p>' +
							'<p class="date-block">'+endDateInter+'</p>' +

							'</div>' +
							'<input type="hidden" class="createDate" id="createDate" value="testing"></input>' +
							'<div class="col-md-6">' +
							'<div class="info-blog totalMeeting">' +
							'<div class="col-xs-6">' +
							'<i class="fa fa-users pull-left"></i><span class="pull-left "> មិនទាន់ប្រជុំ : '+totalNotMeetingInter+'</span>' +
							'</div>' +
							'<div class="col-xs-6">' +
							'<i class="fa fa-edit pull-left"></i><span class="pull-left "> ប្រជុំសរុបថ្ងៃនេះ : '+numOfMeetingTodayInter+'</span>' +
							'</div>' +
							'<div class="col-xs-6">' +
							'<i class="fa fa-bullhorn pull-left"></i><span class="pull-left "> ជិតប្រជុំ : '+totalNearlyMeetingInter+'</span>' +
							'</div>' +
							'<div class="col-xs-6">' +
							'<i class="fa fa-globe pull-left"></i><span class="pull-left ">កិច្ចប្រជុំសរុប : '+numOfMeetingTotalInter+'</span>' +
							'</div>' +
							'<div>' +

							'</div>' +
							'</div>' +

							'</div>' +

							'</div>' +
							'</div>'+
							'</li>');

						$(".demo2").append('<li class="news-item"' +
							'<div >'+
							'<div class="total-meeting total-meeting-demo2" style="background:#1a6a59 !important;">'+
							'<div class="row" style="padding: 0;">' +
							'<div class="col-md-12" style="padding-right: 0; padding-left: 0;">' +
							'<div class="col-md-2 md2-demo2" style="width:13.66667%;border-right: 1px solid #44a28d;">' +
							'<p class="date-block-small" style="color:#fffff">'+objMeeting[0]['meeting_date_kh']+'</p>' +
							'</p>' +
							'</div>' +

							'<div class="col-md-10 md10-demo2">' +
							'<p class="title-one-row" style="color:#ffffff">' +
							'<i class="fa fa-edit pull-left"></i><span class="pull-left total-meeting-demo2"> ប្រជុំសរុបថ្ងៃនេះ : '+numOfMeetingTodayInter+'</span>' +
							'<i class="fa fa-bullhorn pull-left"></i><span class="pull-left total-meeting-demo2"> ជិតប្រជុំ : '+totalNearlyMeetingInter+'</span>' +
							'<i class="fa fa-globe pull-left"></i><span class="pull-left total-meeting-demo2">កិច្ចប្រជុំសរុប : '+numOfMeetingTotalInter+'</span>' +
							'</p>' +
							'</div>' +
							'</div>' +
							'</div>' +
							'</div>' +
							'</div>' +
							'</li>');
					}

					for (var d = 0; d < $(".demo1 li").length; d++) {
						var addClass;
						if (d % 2 == 0) {
							addClass = 'tvFade';
						} else {
							addClass = 'tvNoFade';
						}
//								console.log(d);
						$(".demo1 li").eq(d).children("div").addClass(addClass);
						$(".demo2 li").eq(d).children("div div").addClass(addClass);
					}


				if(objMeeting != ''){
					if(objMeetingCountInter > 4){
						$(".demo2").bootstrapNews({
							newsPerPage: 9,
							autoplay: true,
							pauseOnHover: false,
							direction: 'up',
							newsTickerInterval: 10000,
							pauseOnHover: false,
							onStop: function () {
								console.log(1);
							},
						});
						$(".demo1").bootstrapNews({
							newsPerPage: 2,
							autoplay: true,
							pauseOnHover: false,
							direction: 'up',
							newsTickerInterval: 10000,
							pauseOnHover: false,
							onToDo: function () {
								//console.log(this);
							},

						});
					}
				}
				// console.log(meetingList);

			}, 60000);

		});

		function getAllDate() {
			$(".demo1").remove();
			$.ajax({
					type: "post",
					url: '{{$getAllDataUrl}}',
					datatype: "json",
					data: {"_token": '{{ csrf_token() }}'},
					error: function() { location.reload(); },
					success: function (response) {
						var create_date = $("#lastid").val();
						var count = $("#count").val();
						if (response.query != undefined) {

							$(".demo2").remove();
							$(".demo1").remove();

							$(".demo2-parent").append('<ul class="demo2"></ul>');
							$(".demo1-parent").append('<ul class="demo1"></ul>');

							var count = false;
							var countM = false;
							var today = new Date();
							var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
							var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
							var dateTime = date + ' ' + time;
							var currentTime = Date.parse(dateTime);

//						console.log('all', Object.keys(response.query).length);

							for (var a = 0; a < Object.keys(response.query).length; a++) {
								// var regex = new RegExp(':', 'g'),
								var nearlyMeetingTime = Date.parse(response.query[a]['meeting_date_en'] + ' ' + response.query[a]['meeting_time_24']);
								var nearlyCheckTime = Date.parse(response.query[a]['meeting_date_en'] + ' ' + response.query[a]['check_time']);
								var nearlyFinishTime = Date.parse(response.query[a]['meeting_date_en'] + ' ' + response.query[a]['finishTime']);
								var strObjectDiv1 = response.query[a]['objective'];
								var fontSizeObjectDiv1;
								var demo2ObjectiveDiv1;
								if(strObjectDiv1.length > 100){
									fontSizeObjectDiv1 = '20px';
									demo2ObjectiveDiv1 = strObjectDiv1.substr(0,100)+'...';
								}else{
									fontSizeObjectDiv1 = '24px';
									demo2ObjectiveDiv1 = strObjectDiv1;
								}

								var listOfficer;

								if(response.query[a]['list_official'] ==null){
									listOfficer = ",";
								}else {
									listOfficer = response.query[a]['list_official'];
								}
//
								var fields = listOfficer.split(',');

								var meetingRoom1;
								if(response.query[a]['location'] == null) {
									meetingRoom1 = 'ប្រជុំខាងក្រៅ';
								}else{
									meetingRoom1 = response.query[a]['location'];
								}

								if (currentTime >= nearlyCheckTime && currentTime <= nearlyMeetingTime) {
									$(".nearlyMeeting").remove();
									$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
									// if(count == false){
									meetingOnTime[0] = response.query[a];
									nearlyOnTime = response.query[a]['Id'];
									$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
										'<p>' +
										'<i class="fa fa-clock-o"></i> ' + response.query[a]['meeting_date_kh'] +
										'<span class="pad-badge badge animated infinite flash meetingTime" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #ee984c; padding: 10px"><span>' + response.query[a]['meeting_time'] +' - '+ response.query[a]['meeting_end_time']+
										'</span></span>' +
										'<span class="pad-badge badge animated infinite flash test" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #ee984c; margin: 10px; padding: 10px;">ជិតប្រជុំ' +
										'</span>' +
										'</p>' +
										'<p ><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjectDiv1+' !important;"> ' + response.query[a]['objective'] + '</span></p>' +
										'<p><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[a]['chaire_by'] + '</span></p>' +
										'<p><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoom1 + '</span></p>' +
										'<address style=" color: #ffffff; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
										'<ul class="listOfficer1"></ul>'+
										'</address>' +
										'</div>');
									count = true;

									$.each(fields,function (key,value) {
//									alert(value);
										$('.listOfficer1').append(
											'<li class="pull-left text-meeting paticipant">' +
											'' + value+ '</li>'
										);
									});
									break;
									// }


								} else if (currentTime >= nearlyMeetingTime && currentTime <= nearlyFinishTime) {
									if (a == a) {
										// alert(response.query[i]['objective']);
										meetingOnTime[0] = response.query[a];
										OnTime = response.query[a]['Id'];
										$(".nearlyMeeting").remove();
										$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
										$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
											'<p>' +
											'<i class="fa fa-clock-o"></i> ' + response.query[a]['meeting_date_kh'] +
											'<span class="pad-badge badge animated infinite flash meetingTime" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #d65d51; padding: 10px">' + response.query[a]['meeting_time'] +' - '+ response.query[a]['meeting_end_time']+
											'</span>' +
											//										'<span class="pad-badge badge animated infinite flash" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #d65d51; padding: 10px">' + response.query[a]['meeting_time_24'] +
											//										'</span>' +
											'<span class="pad-badge badge animated infinite flash test" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #d65d51; margin: 10px; padding: 10px;" id="nearlyMeeting">កំពុងប្រជុំ' +
											'</span>' +
											'</p>' +
											'<p ><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjectDiv1+' !important;"> ' + response.query[a]['objective'] + '</span></p>' +
											'<p><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[a]['chaire_by'] + '</span></p>' +
											'<p><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoom1 + '</span></p>' +
											'<address style=" color: #ffffff; line-height: 30px; margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
											'<ul class="listOfficer1"></ul>'+
											'</address>' +
											'</div>');
										count = true;

										$.each(fields,function (key,value) {
//									alert(value);
											$('.listOfficer1').append(
												'<li class="pull-left text-meeting paticipant">' +
												'' + value+ '</li>'
											);
										});
										break;
									}

								} else {
									if(response.query.length > 2){
//									alert(a);
										if (a == a && currentTime < nearlyFinishTime && response.query[a]['meeting_date_en'] ==currentDate){
											meetingOnTime[0] = response.query[a];
											other = response.query[a]['Id'];
											// alert(1);
											var textColorAddan;
											if (currentTime > nearlyFinishTime) {
												textColorAddan = '#8DC0B1';
												color = "cfe4e0";
											} else {
												textColorAddan = '#ffffff';
												color = "bec661";
											}

											// {
											$(".nearlyMeeting").remove();
											$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
											$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
												'<p class = "meetingC" style="color:' + textColorAddan + '">' +
												'<i class="fa fa-clock-o"></i> ' + response.query[a]['meeting_date_kh'] +
												'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #' + color + '; padding: 10px"><span class="time-animate">' + response.query[a]['meeting_time'] +' - '+ response.query[a]['meeting_end_time']+
												'</span></span>' +
												'</p>' +
												'<p style="color:' + textColorAddan + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjectDiv1+' !important;"> ' + response.query[a]['objective'] + '</span></p>' +
												'<p style="color:' + textColorAddan + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[a]['chaire_by'] + '</span></p>' +
												'<p style="color:' + textColorAddan + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoom1 + '</span></p>' +
												'<address id="testing" style=" color:' + textColorAddan + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting testing" style=" margin-left: -9px;"></i>' +
												'<ul class="listOfficer1"></ul>'+
												'</address>' +
												'</div>');

											$.each(fields,function (key,value) {
//									alert(value);
												$('.listOfficer1').append(
													'<li class="pull-left text-meeting paticipant">' +
													'' + value+ '</li>'
												);
											});
//										break;
										}else if(a == a && currentTime < nearlyFinishTime && response.query[a]['meeting_date_en'] >currentDate){
											meetingOnTime[0] = response.query[a];
											other = response.query[a]['Id'];
											// alert(1);
											var textColorAddan;
											if (currentTime > nearlyFinishTime) {
												textColorAddan = '#8DC0B1';
												color = "cfe4e0";
											} else {
												textColorAddan = '#ffffff';
												color = "bec661";
											}

											// {
											$(".nearlyMeeting").remove();
											$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
											$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
												'<p class = "meetingC" style="color:' + textColorAddan + '">' +
												'<i class="fa fa-clock-o"></i> ' + response.query[a]['meeting_date_kh'] +
												'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #' + color + '; padding: 10px"><span class="time-animate">' + response.query[a]['meeting_time'] +' - '+ response.query[a]['meeting_end_time']+
												'</span></span>' +
												'</p>' +
												'<p style="color:' + textColorAddan + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjectDiv1+' !important;"> ' + response.query[a]['objective'] + '</span></p>' +
												'<p style="color:' + textColorAddan + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[a]['chaire_by'] + '</span></p>' +
												'<p style="color:' + textColorAddan + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoom1 + '</span></p>' +
												'<address id="testing" style=" color:' + textColorAddan + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting testing" style=" margin-left: -9px;"></i>' +
												'<ul class="listOfficer1"></ul>'+
												'</address>' +
												'</div>');

											$.each(fields,function (key,value) {
//									alert(value);
												$('.listOfficer1').append(
													'<li class="pull-left text-meeting paticipant">' +
													'' + value+ '</li>'
												);
											});
											break;
										}
									}else{
										meetingOnTime[0] = response.query[a];
										other = response.query[a]['Id'];
										// alert(1);
										var textColorAddan;
										if (currentTime > nearlyFinishTime) {
											textColorAddan = '#c9eae4';
											color = "cfe4e0";
											$(".nearlyMeeting").remove();
											$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
											$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
												'<p class = "meetingC" style="color:' + textColorAddan + '">' +
												'<i class="fa fa-clock-o"></i> ' + response.query[a]['meeting_date_kh'] +
												'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #' + color + '; padding: 10px"><span class="time-animate">' + response.query[a]['meeting_time'] +' - '+ response.query[a]['meeting_end_time']+
												'</span></span>' +
												'</p>' +
												'<p style="color:' + textColorAddan + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjectDiv1+' !important;"> ' + response.query[a]['objective'] + '</span></p>' +
												'<p style="color:' + textColorAddan + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[a]['chaire_by'] + '</span></p>' +
												'<p style="color:' + textColorAddan + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoom1 + '</span></p>' +
												'<address id="testing" style=" color:' + textColorAddan + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting testing" style=" margin-left: -9px;"></i>' +
												'<ul class="listOfficer1"></ul>'+
												'</address>' +
												'</div>');

											$.each(fields,function (key,value) {
//									alert(value);
												$('.listOfficer1').append(
													'<li class="pull-left text-meeting paticipant">' +
													'' + value+ '</li>'
												);
											});
											break;
										} else {
											textColorAddan = '#ffffff';
											color = "bec661";
											$(".nearlyMeeting").remove();
											$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
											$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
												'<p class = "meetingC" style="color:' + textColorAddan + '">' +
												'<i class="fa fa-clock-o"></i> ' + response.query[a]['meeting_date_kh'] +
												'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #' + color + '; padding: 10px"><span class="time-animate">' + response.query[a]['meeting_time'] +' - '+ response.query[a]['meeting_end_time']+
												'</span></span>' +
												'</p>' +
												'<p style="color:' + textColorAddan + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjectDiv1+' !important;"> ' + response.query[a]['objective'] + '</span></p>' +
												'<p style="color:' + textColorAddan + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[a]['chaire_by'] + '</span></p>' +
												'<p style="color:' + textColorAddan + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoom1 + '</span></p>' +
												'<address id="testing" style=" color:' + textColorAddan + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting testing" style=" margin-left: -9px;"></i>' +
												'<ul class="listOfficer1"></ul>'+
												'</address>' +
												'</div>');

											$.each(fields,function (key,value) {
//									alert(value);
												$('.listOfficer1').append(
													'<li class="pull-left text-meeting paticipant">' +
													'' + value+ '</li>'
												);
											});
											break;
										}
										// {

									}

									// }

								}
							}
							for (var b = 0; b < response.query.length; b++) {

								var OnMeetingTime = Date.parse(response.query[b]['meeting_date_en'] + ' ' + response.query[b]['meeting_time_24']);
								var OnCheckTime = Date.parse(response.query[b]['meeting_date_en'] + ' ' + response.query[b]['check_time']);
								var OnFinishTime = Date.parse(response.query[b]['meeting_date_en'] + ' ' + response.query[b]['finishTime']);
								var listOfficer;
								var strObjectDiv2 = response.query[b]['objective'];
								var fontSizeObjectDiv2;
								var demo2ObjectiveDiv2;
								if(strObjectDiv2.length > 100){
									fontSizeObjectDiv2 = '20px';
									demo2ObjectiveDiv2 = strObjectDiv2.substr(0,100)+'...';
								}else{
									fontSizeObjectDiv2 = '24px';
									demo2ObjectiveDiv2 = strObjectDiv1;
								}

								if(response.query[b]['list_official'] ==null){
									listOfficer = ",";
								}else {
									listOfficer = response.query[b]['list_official'];
								}
//
								var fields = listOfficer.split(',');

								var meetingRoom2;
								if(response.query[b]['location'] == null) {
									meetingRoom2 = 'ប្រជុំខាងក្រៅ';
								}else{
									meetingRoom2 = response.query[b]['location'];
								}
//							alert(currentTime >= OnMeetingTime && currentTime <= OnFinishTime);
								if (currentTime >= OnMeetingTime && currentTime <= OnFinishTime) {
									if (response.query[b]['Id'] != OnTime) {

										$(".meeting").remove();
										$(".div_meeting").append('<div class="my_meeting meeting"></div>');
										meetingOnTime[1] = response.query[b];
										$(".meeting").append('<div class="meeting">' +
											'<p>' +
											'<i class="fa fa-clock-o"></i>' + response.query[b]['meeting_date_kh'] +
											'<span class="pad-badge badge animated infinite flash spanMeeting meetingTime" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #d65d51; padding: 10px">' + response.query[b]['meeting_time'] +' - '+ response.query[b]['meeting_end_time']+
											'</span>' +
											'<span class="pad-badge badge animated infinite flash test" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #d65d51; margin: 10px; padding: 10px;" id="nearlyMeeting">កំពុងប្រជុំ' +
											'</p>' +
											'<p ><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjectDiv2+' !important;"> ' + response.query[b]['objective'] + '</span></p>' +
											'<p><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting"> ' + response.query[b]['chaire_by'] + '</span></p>' +
											'<p><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoom2 + '</span></p>' +
											'<address style="color: #ffffff; line-height: 30px; margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
											'<ul class="listOfficer2"></ul>'+
											'</address>' +
											'</div>');
										countM = true;

										$.each(fields,function (key,value) {
//									alert(value);
											$('.listOfficer2').append(
												'<li class="pull-left text-meeting paticipant">' +
												'' + value+ '</li>'
											);
										});
										break;
									}

								} else if (currentTime >= OnCheckTime && currentTime < OnMeetingTime) {
//								 alert((response.query[b]['Id'] != nearlyOnTime));
									if (response.query[b]['Id'] != nearlyOnTime && nearlyOnTime!='undefined') {
										meetingOnTime[1] = response.query[b];
										$(".meeting").remove();
										$(".div_meeting").append('<div class="my_meeting meeting"></div>');
										$(".meeting").append('<div class="meeting">' +
											'<p>' +
											'<i class="fa fa-clock-o"></i> ' + response.query[b]['meeting_date_kh'] +
											'<span class="pad-badge badge animated infinite flash meetingTime" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #ee984c; padding: 10px">' + response.query[b]['meeting_time'] +' - '+ response.query[b]['meeting_end_time']+
											'</span>' +
											'<span class="pad-badge badge animated infinite flash test" style="font-weight:normal;font-size: 23px; margin-top: -2px; background-color: #ee984c; margin: 10px; padding: 10px;">ជិតប្រជុំ' +
											'</span>' +
											'</p>' +
											'<p ><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjectDiv2+' !important;"> ' + response.query[b]['objective'] + '</span></p>' +
											'<p><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[b]['chaire_by'] + '</span></p>' +
											'<p><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoom2 + '</span></p>' +
											'<address style=" color: #ffffff; line-height: 30px; margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
											'<ul class="listOfficer2"></ul>'+
											'</address>' +
											'</div>');
										count = true;

										$.each(fields,function (key,value) {
//									alert(value);
											$('.listOfficer2').append(
												'<li class="pull-left text-meeting paticipant">' +
												'' + value+ '</li>'
											);
										});
										break;
									}

								} else {
//								alert(response.query.length);
									if(response.query.length == 2){
//
										if(response.query[b]['Id'] != other && response.query[b]['meeting_date_en'] ==currentDate && currentTime <= OnCheckTime ){
											var textColorAdda;
											var color;
											if (currentTime > OnFinishTime) {
												textColorAdda = '#c9eae4';
												color = '#cfe4e0';
											} else {
												textColorAdda = '#ffffff';
												color = '#bec661';

											}
											meetingOnTime[1] = response.query[b];
											$(".meeting").remove();
											$(".div_meeting").append('<div class="my_meeting meeting"></div>');
											$(".meeting").append('<div class="meeting">' +
												'<p class="meetingC" style="color:' + textColorAdda + '">' +
												'<i class="fa fa-clock-o"></i>' + response.query[b]['meeting_date_kh'] +
												'<span class="pad-badge badge animated infinite  spanMeeting meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + response.query[b]['meeting_time'] +' - '+ response.query[b]['meeting_end_time']+
												'</span>' +
												'</p>' +
												'<p style="color:' + textColorAdda + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjectDiv2+' !important;"> ' + response.query[b]['objective'] + '</span></p>' +
												'<p style="color:' + textColorAdda + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[b]['chaire_by'] + '</span></p>' +
												'<p style="color:' + textColorAdda + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoom2 + '</span></p>' +
												'<address style="color:' + textColorAdda + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting testing" style=" margin-left: -9px;"></i>' +
												'<ul class="listOfficer2"></ul>'+
												'</address>' +
												'</div>');

											$.each(fields,function (key,value) {
//									alert(value);
												$('.listOfficer2').append(
													'<li class="pull-left text-meeting paticipant">' +
													'' + value+ '</li>'
												);
											});
											break;
										}else if(response.query[b]['Id'] != other && response.query[b]['meeting_date_en'] > currentDate && currentTime <= OnCheckTime ){
											var textColorAdda;
											var color;
//										alert(1);
											if (currentTime > OnFinishTime) {
												textColorAdda = '#c9eae4';
												color = '#cfe4e0';
											} else {
												textColorAdda = '#ffffff';
												color = '#bec661';

											}
											meetingOnTime[1] = response.query[b];
											$(".meeting").remove();
											$(".div_meeting").append('<div class="my_meeting meeting"></div>');
											$(".meeting").append('<div class="meeting">' +
												'<p class="meetingC" style="color:' + textColorAdda + '">' +
												'<i class="fa fa-clock-o"></i>' + response.query[b]['meeting_date_kh'] +
												'<span class="pad-badge badge animated infinite  spanMeeting meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + response.query[b]['meeting_time'] +' - '+ response.query[b]['meeting_end_time']+
												'</span>' +
												'</p>' +
												'<p style="color:' + textColorAdda + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjectDiv2+' !important;"> ' + response.query[b]['objective'] + '</span></p>' +
												'<p style="color:' + textColorAdda + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[b]['chaire_by'] + '</span></p>' +
												'<p style="color:' + textColorAdda + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoom2 + '</span></p>' +
												'<address style="color:' + textColorAdda + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting testing" style=" margin-left: -9px;"></i>' +
												'<ul class="listOfficer2"></ul>'+
												'</address>' +
												'</div>');

											$.each(fields,function (key,value) {
//									alert(value);
												$('.listOfficer2').append(
													'<li class="pull-left text-meeting paticipant">' +
													'' + value+ '</li>'
												);
											});
											break;
										}


									}else{
										if(response.query[b]['Id'] != other){
											var textColorAdda;
											var color;
											if (currentTime > OnFinishTime) {
												textColorAdda = '#c9eae4';
												color = '#cfe4e0';

												meetingOnTime[1] = response.query[b];
												$(".meeting").remove();
												$(".div_meeting").append('<div class="my_meeting meeting"></div>');
												$(".meeting").append('<div class="meeting">' +
													'<p class="meetingC" style="color:' + textColorAdda + '">' +
													'<i class="fa fa-clock-o"></i>' + response.query[b]['meeting_date_kh'] +
													'<span class="pad-badge badge animated infinite  spanMeeting meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + response.query[b]['meeting_time'] +' - '+ response.query[b]['meeting_end_time']+
													'</span>' +
													'</p>' +
													'<p style="color:' + textColorAdda + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjectDiv2+' !important;"> ' + response.query[b]['objective'] + '</span></p>' +
													'<p style="color:' + textColorAdda + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[b]['chaire_by'] + '</span></p>' +
													'<p style="color:' + textColorAdda + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoom2 + '</span></p>' +
													'<address style="color:' + textColorAdda + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting testing" style=" margin-left: -9px;"></i>' +
													'<ul class="listOfficer2"></ul>'+
													'</address>' +
													'</div>');

												$.each(fields,function (key,value) {
//									alert(value);
													$('.listOfficer2').append(
														'<li class="pull-left text-meeting paticipant">' +
														'' + value+ '</li>'
													);
												});
//											break;
											} else {
												textColorAdda = '#ffffff';
												color = '#bec661';

												meetingOnTime[1] = response.query[b];
												$(".meeting").remove();
												$(".div_meeting").append('<div class="my_meeting meeting"></div>');
												$(".meeting").append('<div class="meeting">' +
													'<p class="meetingC" style="color:' + textColorAdda + '">' +
													'<i class="fa fa-clock-o"></i>' + response.query[b]['meeting_date_kh'] +
													'<span class="pad-badge badge animated infinite  spanMeeting meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + response.query[b]['meeting_time'] + ' - '+ response.query[b]['meeting_end_time']+
													'</span>' +
													'</p>' +
													'<p style="color:' + textColorAdda + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjectDiv2+' !important;"> ' + response.query[b]['objective'] + '</span></p>' +
													'<p style="color:' + textColorAdda + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[b]['chaire_by'] + '</span></p>' +
													'<p style="color:' + textColorAdda + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoom2 + '</span></p>' +
													'<address style="color:' + textColorAdda + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting testing" style=" margin-left: -9px;"></i>' +
													'<ul class="listOfficer2"></ul>'+
													'</address>' +
													'</div>');

												$.each(fields,function (key,value) {
//									alert(value);
													$('.listOfficer2').append(
														'<li class="pull-left text-meeting paticipant">' +
														'' + value+ '</li>'
													);
												});
												break;
											}

										}
									}

//								isBreak;
//								 break;
								}
							}

							var objMeeting = response.query;
							var objMeetingCount = Object.keys(objMeeting).length;
							if (response.query != undefined) {
								var endDate;
								var numOfMeetingToday = 0;
								var numOfMeetingTotal = Object.keys(objMeeting).length;
								var totalNearlyMeeting = 0;
								var totalNotMeeting = 0;
								var birthday = '';

								for (var c = 0; c < Object.keys(objMeeting).length; c++) {
									if( response.query[c]['meeting_date_en'] ==currentDate){
										numOfMeetingToday = numOfMeetingToday + 1;
										if(response.query[c]['birth_day'] !=null){
											birthday = response.query[c]['birth_day'];
										}
									}
									meetingList[c] = objMeeting[c];
									var meetingOnTimes;
									var meetingOnTimes2;
									if (typeof(meetingOnTime[0]) !== "undefined") {
										meetingOnTimes = meetingOnTime[0]['Id'];
									} else {
										meetingOnTimes = 0;
									}
									if (typeof(meetingOnTime[1]) !== "undefined") {
										meetingOnTimes2 = meetingOnTime[1]['Id'];
									} else {
										meetingOnTimes2 = 0;
									}

									var addClass;
									if( c %2 ==0){
										addClass ='tvFade';
									}else{
										addClass ='tvNoFade';
									}

									var check_timeG = Date.parse(response.query[c]['meeting_date_en'] + ' ' + response.query[c]['check_time']);
									var meeting_24G = Date.parse(response.query[c]['meeting_date_en'] + ' ' + response.query[c]['meeting_time_24']);
									var finishTimeG = Date.parse(response.query[c]['meeting_date_en'] + ' ' + response.query[c]['finishTime']);
									var listOfficerG;

									if (currentTime >= check_timeG && currentTime <= meeting_24G) {
										totalNearlyMeeting = totalNearlyMeeting + 1;
									}
									if (currentTime < meeting_24G) {
										totalNotMeeting = totalNotMeeting + 1;
									}
									endDate = response.query[c]['meeting_date_kh'];
//

									if (objMeeting[c]['Id'] != meetingOnTimes && objMeeting[c]['Id'] != meetingOnTimes2) {

										//console.log(addClass);
										if(response.query[c]['list_official'] ==null){
											listOfficerG = ",";
										}else {
											listOfficerG = response.query[c]['list_official'];
										}

										var nameG = listOfficerG.split(',');
										// alert(response.query[c]['finishTime']);
										var colormeeting;
										var textColor;
										var flash;
										if (currentTime >= check_timeG && currentTime <= meeting_24G) {
											flash = 'flash';
											textColor = '#ffffff';
											colormeeting = '#ee984c';
										} else if (currentTime >= meeting_24G && currentTime <= finishTimeG) {
											flash = 'flash';
											textColor = '#ffffff';
											colormeeting = '#d65d51';
										} else if (currentTime > finishTimeG) {
											flash = '';
											textColor = '#8DC0B1';
											colormeeting = '#8DC0B1;';
										} else {
											flash = '';
											textColor = '#ffffff';
											colormeeting = '#bec661';

										}
										var strObject = objMeeting[c]['objective'];

										var fontSizeObject;
										var demo2Objective;
										if(strObject.length > 100){
											fontSizeObject = '20px';
											demo2Objective = strObject.substr(0,100)+'...';
										}else{
											fontSizeObject = '26px';
											demo2Objective = strObject;
										}

										var meetingRoomDemo;
										if(objMeeting[b]['location'] == null) {
											meetingRoomDemo = 'ប្រជុំខាងក្រៅ';
										}else{
											meetingRoomDemo = objMeeting[b]['location'];
										}
//									alert(demo2Object);
//									console.log(c);
										$(".demo1").append('<li class="news-item" data-id="2">' +
											'<div>'+
											'<div class="row"  style=" ">' +
											'<div class="col-sm-2" style="border-right: 1px solid #44a28d;width: 13.666667%;">' +
											'<p class="date-block" style="color:' + textColor + '">' + objMeeting[c]['meeting_date_kh'] + '</p>' +
											'<p><span class="badge badge-danger spanNearlyMeeting ' + flash + '" id="meeting_' + c + '" style="font-size: 20px;margin-top:-5px; margin-left:25px;background-color: ' + colormeeting + '; color: #ffffff;padding: 5px">' + objMeeting[c]['meeting_time'] + '</span></p>' +
											'</div>' +
											'<input type="hidden" class="createDate" id="createDate_' + c + '" value="' + objMeeting[c]['create_date'] + '"></input>' +
											'<div class="col-md-6">' +
											'<div class="info-blog">' +
											'<div>' +
											'<i class="fa fa-file-text pull-left" style=" color: ' + textColor + '"></i><span class="pull-left font-26 title" style=" color: ' + textColor + ';font-size: '+fontSizeObject+' !important;"> ' + objMeeting[c]['objective'] + '</span>' +
											'</div>' +
											'<div class="font-bold">' +
											'<i class="fa fa-user pull-left" style=" color: ' + textColor + '"></i><span class="pull-left" style=" color: ' + textColor + '">' + objMeeting[c]['chaire_by'] + '</span>' +
											'</div>' +
											'<div>' +
											'<i class="fa fa-map-marker pull-left" style=" color: ' + textColor + '"></i><span class="pull-left font18" style=" color: ' + textColor + '">' + meetingRoomDemo + '</span>' +
											'</div>' +
											'</div>' +

											'</div>' +
											'<div class="col-md-4">' +
											'<div class="col-md-2">' +
											'<p style="color:' + textColor + '"><i class="fa fa-users fa-lg"></i></p>' +
											'</div>' +

											'<div class="col-md-10 listOfficer2">' +
											'<address style=" color: ' + textColor + '; line-height: 30px;">' +
											'<div id="listOfficers_'+c+'" class="listOfficer"></div>'+
											'</address>' +

											'</div>' +
											'</div>' +
											'</div>' +
											'</div>'+
											'</li>');

										$.each(nameG,function (key,value) {
											if(key < 7){
												$('#listOfficers_'+c).append(
													'<p class="listDemo1" style="color:'+textColor+'">' +
													'' + value+ '</p>'
												);
											}

										});
										if( Object.keys(nameG).length >7){
											$('#listOfficers_'+c).append(
												'<p class="listDemo1" style="color:'+textColor+'">.....</p>'
											);
										}

										if (objMeetingCount > 3) {

											$(".demo2").append('<li class="news-item" data-id="2"> '+
												'<div class="">'+
												'<div>'+
												'<div class="row" >' +
												'<div class="col-md-12" style="padding-right: 0; padding-left: 0;">' +
												'<div class="col-md-2 md2-demo2" style="width:13.66667%;border-right: 1px solid #44a28d;">' +
												'<p class="date-block-small" style="color:' + textColor + '">' + objMeeting[c]['meeting_date_kh'] + '</p>' +
												'<p><span class="badge badge-warning spanNearlyMeeting ' + flash + '" style="font-size: 16px;margin-top:-10px; margin-left: 38px; background-color: ' + colormeeting + '; color: #ffffff; padding: 5px">' + objMeeting[c]['meeting_time'] + '</span>' +
												'</p>' +
												'</div>' +
												'<div class="col-md-10 md10-demo2">' +
												'<p class="title-one-row" id="objective" style=" color: ' + textColor + '">' +
												'<i class="fa fa-file-text" style=" color: ' + textColor + ';font-size: '+fontSizeObject+' !important;"></i> ' + demo2Objective +
												'</p>' +
												'</div>' +
												'</div>' +
												'</div>' +
												'</div>'+
												'</div>'+
												'</li>');
										}

									}

								}
								if (Object.keys(objMeeting).length >4){
									$(".demo1").append('<li class="news-item" data-id="2">' +
										'<div class="total-meeting" style="background:#1a6a59 !important;">'+
										'<div class="row"  style=" ">' +
										'<div class="col-sm-2" style="border-right: 1px solid #44a28d;width: 13.666667%;">' +
										'<p class="date-block">'+response.query[0]['meeting_date_kh']+'</p>' + '<p class="toDate" style="text-align:center !important">ដល់</p>' +
										'<p class="date-block">'+endDate+'</p>' +

										'</div>' +
										'<input type="hidden" class="createDate" id="createDate" value="testing"></input>' +
										'<div class="col-md-6">' +
										'<div class="info-blog totalMeeting">' +
										'<div class="col-xs-6">' +
										'<i class="fa fa-users pull-left"></i><span class="pull-left "> មិនទាន់ប្រជុំ : '+totalNotMeeting+'</span>' +
										'</div>' +
										'<div class="col-xs-6">' +
										'<i class="fa fa-edit pull-left"></i><span class="pull-left "> ប្រជុំសរុបថ្ងៃនេះ : '+numOfMeetingToday+'</span>' +
										'</div>' +
										'<div class="col-xs-6">' +
										'<i class="fa fa-bullhorn pull-left"></i><span class="pull-left "> ជិតប្រជុំ : '+totalNearlyMeeting+'</span>' +
										'</div>' +
										'<div class="col-xs-6">' +
										'<i class="fa fa-globe pull-left"></i><span class="pull-left ">កិច្ចប្រជុំសរុប : '+numOfMeetingTotal+'</span>' +
										'</div>' +
										'<div>' +

										'</div>' +
										'</div>' +

										'</div>' +

										'</div>' +
										'</div>'+
										'</li>');

									$(".demo2").append('<li class="news-item"' +
										'<div >'+
										'<div class="total-meeting" style="background:#1a6a59 !important;">'+
										'<div class="row" style="padding: 0;">' +
										'<div class="col-md-12" style="padding-right: 0; padding-left: 0;">' +
										'<div class="col-md-2 md2-demo2" style="width:13.66667%;border-right: 1px solid #44a28d;">' +
										'<p class="date-block-small" style="color:#fffff">'+response.query[0]['meeting_date_kh']+'</p>' +
										'</p>' +
										'</div>' +

										'<div class="col-md-10 md10-demo2">' +
										'<p class="title-one-row" style="color:#ffffff">' +
										'<i class="fa fa-edit pull-left "></i><span class="pull-left total-meeting-demo2" > ប្រជុំសរុបថ្ងៃនេះ : '+numOfMeetingToday+'</span>' +
										'<i class="fa fa-bullhorn pull-left"></i><span class="pull-left total-meeting-demo2"> ជិតប្រជុំ : '+totalNearlyMeeting+'</span>' +
										'<i class="fa fa-globe pull-left"></i><span class="pull-left total-meeting-demo2">កិច្ចប្រជុំសរុប : '+numOfMeetingTotal+'</span>' +
										'</p>' +
										'</div>' +
										'</div>' +
										'</div>' +
										'</div>' +
										'</div>' +
										'</li>');
								}

								for(var d=0;d<$(".demo1 li").length;d++){
									var addClass;
									if( d %2 ==0){
										addClass ='tvFade';
									}else{
										addClass ='tvNoFade';
									}
//								console.log(d);
									$(".demo1 li").eq(d).children("div").addClass(addClass);
									$(".demo2 li").eq(d).children("div div").addClass(addClass);
								}
								console.log("count " + $(".demo1 li").length);
								console.log("count 2 " + $(".demo2 li").length);

							}
						}
						if(response.query != undefined){
							if(objMeetingCount > 4 ){
								$(".demo1").bootstrapNews({
									newsPerPage: 2,
									autoplay: true,
									pauseOnHover: false,
									direction: 'up',
									newsTickerInterval: 10000,
									pauseOnHover: false,
									onToDo: function () {
										//console.log(this);
									},

								});
								$(".demo2").bootstrapNews({
									newsPerPage: 9,
									autoplay: true,
									pauseOnHover: false,
									direction: 'up',
									newsTickerInterval: 10000,
									pauseOnHover: false,
									onStop: function () {
										console.log(1);
									},
								});
							}
						}

					}
				});

//			endLoadingWaiting();
		}

		//Check new data, update and delete
		(function poll() {

			var create_date = $("#lastid").val();
			var count = $("#count").val();
			var createDate = [];
			var color;

			// console.log(meetingList);
			$(".createDate").each(function (index) {
				createDate.push($("#createDate_" + index).val());
			});

			setTimeout(function () {

				$.ajax({
					type: "get",
					url: '{{$getNewDataUrl}}',
					datatype: "json",
					data: {"create_date": create_date,"count":count, "_token": '{{ csrf_token() }}'},
					error: function() { location.reload(); },
					success: function (response) {

						$("#lastid").val(response.lastId);
						$("#count").val(response.count);

						console.log('test',response.query == '');
						if(response.query ==''){
							$(".nearlyMeeting").remove();
						}
						if (response.query != undefined) {

							$(".demo2").remove();
							$(".demo1").remove();

							$(".demo2-parent").append('<ul class="demo2"></ul>');
							$(".demo1-parent").append('<ul class="demo1"></ul>');

							var todayAdd = new Date();
							var dateAdd = todayAdd.getFullYear() + '-' + (todayAdd.getMonth() + 1) + '-' + todayAdd.getDate();
							var timeAdd = todayAdd.getHours() + ":" + todayAdd.getMinutes() + ":" + todayAdd.getSeconds();
							var dateTimeAdd = dateAdd + ' ' + timeAdd;
							var currentTimeAdd = Date.parse(dateTimeAdd);
							var count = false;
							var countM = false;
							for (i = 0; i < response.query.length; i++) {
								// alert(response.query[i]['meeting_time_24']);

								var check_timeAdd = Date.parse(response.query[i]['meeting_date_en'] + ' ' + response.query[i]['check_time']);
								var meeting_24Add = Date.parse(response.query[i]['meeting_date_en'] + ' ' + response.query[i]['meeting_time_24']);
								var finishTimeAdd = Date.parse(response.query[i]['meeting_date_en'] + ' ' + response.query[i]['finishTime']);
								var strObjectAddDiv1 = response.query[i]['objective'];
								var fontSizeObjeAddctDiv1;
								var demo2ObjectiveAddDiv1;
								if(strObjectAddDiv1.length > 100){
									fontSizeObjeAddctDiv1 = '20px';
									demo2ObjectiveAddDiv1 = strObjectAddDiv1.substr(0,100)+'...';
								}else{
									fontSizeObjeAddctDiv1 = '24px';
									demo2ObjectiveAddDiv1 = strObjectAddDiv1;
								}

								var listOfficerPulln;
								if(response.query[i]['list_official'] ==null){
									listOfficerPulln = ",";
								}else {
									listOfficerPulln = response.query[i]['list_official'];
								}
								var fieldsPulln = listOfficerPulln.split(',');

								var meetingRoomAdd1;
								if(response.query[i]['location'] == null) {
									meetingRoomAdd1 = 'ប្រជុំខាងក្រៅ';
								}else{
									meetingRoomAdd1 = response.query[i]['location'];
								}
								if (currentTimeAdd >= check_timeAdd && currentTimeAdd <= meeting_24Add) {

									meetingOnTime[0] = response.query[i];
									nearlyOnTime = response.query[i]['Id'];
									$(".nearlyMeeting").remove();
									$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
									$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
										'<p>' +
										'<i class="fa fa-clock-o"></i> ' + response.query[i]['meeting_date_kh'] +
										'<span class="pad-badge badge animated infinite flash meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #ee984c; padding: 10px">' + response.query[i]['meeting_time'] +' - '+ response.query[i]['meeting_end_time']+
										'</span>' +
										'<span class="pad-badge badge animated infinite flash test" style="font-size: 18px; margin-top: -2px; background-color: #ee984c; margin: 10px; padding: 10px;">ជិតប្រជុំ' +
										'</span>' +
										'</p>' +
										'<p><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeAddctDiv1+'"> ' + response.query[i]['objective'] + '</span></p>' +
										'<p><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[i]['chaire_by'] + '</span></p>' +
										'<p><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomAdd1 + '</span></p>' +
										'<address style=" color: #ffffff; line-height: 30px; margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
										'<ul class="listOfficer1"></ul>' +
										'</address>' +
										'</div>');
									count = true;
									$.each(fieldsPulln,function (key,value) {
//									alert(value);
										$('.listOfficer1').append(
											'<li class="pull-left text-meeting paticipant">' +
											'' + value+ '</li>'
										);
									});
									break;


								} else if (currentTimeAdd >= meeting_24Add && currentTimeAdd <= finishTimeAdd) {
									// alert(1);
									if (i == i) {
										meetingOnTime[0] = response.query[i];
										OnTime = response.query[i]['Id'];
										$(".nearlyMeeting").remove();
										$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
										$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
											'<p>' +
											'<i class="fa fa-clock-o"></i> ' + response.query[i]['meeting_date_kh'] +
											'<span class="pad-badge badge animated infinite flash meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #d65d51; padding: 10px">' + response.query[i]['meeting_time'] +' - '+ response.query[i]['meeting_end_time']+
											'</span>' +
											'<span class="pad-badge badge animated infinite flash test" style="font-size: 18px; margin-top: -2px; background-color: #d65d51; margin: 10px; padding: 10px;" id="nearlyMeeting">កំពុងប្រជុំ' +
											'</span>' +
											'</p>' +
											'<p><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeAddctDiv1+'"> ' + response.query[i]['objective'] + '</span></p>' +
											'<p><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[i]['chaire_by'] + '</span></p>' +
											'<p><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomAdd1 + '</span></p>' +
											'<address style=" color: #ffffff; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
											'<ul class="listOfficer1"></ul>' +
											'</address>' +
											'</div>');
										count = true;

										$.each(fieldsPulln,function (key,value) {
//
											$('.listOfficer1').append(
												'<li class="pull-left text-meeting paticipant">' +
												'' + value+ '</li>'
											);
										});
										break;
									}

								} else {
									if(response.query.length == 2){
										if (i == i && currentTimeAdd < meeting_24Add && response.query[i]['meeting_date_en'] ==currentDate){

											meetingOnTime[0] = response.query[i];
											other = response.query[i]['Id'];
											var textColorAddn;
											if (currentTimeAdd > finishTimeAdd) {
												textColorAddn = '#c9eae4';
												color = "#cfe4e0";
											} else {
												textColorAddn = '#ffffff';
												color = "#bec661";
											}
											// {
											$(".nearlyMeeting").remove();
											$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
											$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
												'<p class = meetingC>' +
												'<i class="fa fa-clock-o" style="' + textColorAddn + '"></i> ' + response.query[i]['meeting_date_kh'] +
												'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + response.query[i]['meeting_time'] +' - '+ response.query[i]['meeting_end_time']+
												'</span>' +
												'</p>' +
												'<p style="color:' + textColorAddn + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeAddctDiv1+'"> ' + response.query[i]['objective'] + '</span></p>' +
												'<p style="color:' + textColorAddn + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[i]['chaire_by'] + '</span></p>' +
												'<p style="color:' + textColorAddn + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomAdd1 + '</span></p>' +
												'<address style="color: ' + textColorAddn + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
												'<ul class="listOfficer1"></ul>' +
												'</address>' +
												'</div>');

											$.each(fieldsPulln,function (key,value) {
//
												$('.listOfficer1').append(
													'<li class="pull-left text-meeting paticipant">' +
													'' + value+ '</li>'
												);
											});
//											 break;
										}else if (i == i && currentTimeAdd < meeting_24Add && response.query[i]['meeting_date_en'] >currentDate){
											meetingOnTime[0] = response.query[i];
											other = response.query[i]['Id'];
											var textColorAddn;
											if (currentTimeAdd > finishTimeAdd) {
												textColorAddn = '#c9eae4';
												color = "#cfe4e0";
											} else {
												textColorAddn = '#ffffff';
												color = "#bec661";
											}
											// {
											$(".nearlyMeeting").remove();
											$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
											$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
												'<p class = meetingC>' +
												'<i class="fa fa-clock-o" style="' + textColorAddn + '"></i> ' + response.query[i]['meeting_date_kh'] +
												'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + response.query[i]['meeting_time'] +' - '+ response.query[i]['meeting_end_time']+
												'</span>' +
												'</p>' +
												'<p style="color:' + textColorAddn + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeAddctDiv1+'"> ' + response.query[i]['objective'] + '</span></p>' +
												'<p style="color:' + textColorAddn + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[i]['chaire_by'] + '</span></p>' +
												'<p style="color:' + textColorAddn + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomAdd1 + '</span></p>' +
												'<address style="color: ' + textColorAddn + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
												'<ul class="listOfficer1"></ul>' +
												'</address>' +
												'</div>');

											$.each(fieldsPulln,function (key,value) {
//
												$('.listOfficer1').append(
													'<li class="pull-left text-meeting paticipant">' +
													'' + value+ '</li>'
												);
											});
											break;
										}
									}else{

										meetingOnTime[0] = response.query[i];
										other = response.query[i]['Id'];
										var textColorAddn;
										if (currentTimeAdd > finishTimeAdd) {
											textColorAddn = '#c9eae4';
											color = "cfe4e0";

											$(".nearlyMeeting").remove();
											$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
											$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
												'<p class = meetingC>' +
												'<i class="fa fa-clock-o" style="' + textColorAddn + '"></i> ' + response.query[i]['meeting_date_kh'] +
												'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #' + color + '; padding: 10px">' + response.query[i]['meeting_time'] +' - '+ response.query[i]['meeting_end_time']+
												'</span>' +
												'</p>' +
												'<p style="color:' + textColorAddn + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeAddctDiv1+'"> ' + response.query[i]['objective'] + '</span></p>' +
												'<p style="color:' + textColorAddn + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[i]['chaire_by'] + '</span></p>' +
												'<p style="color:' + textColorAddn + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomAdd1['location'] + '</span></p>' +
												'<address style="color: ' + textColorAddn + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
												'<ul class="listOfficer1"></ul>' +
												'</address>' +
												'</div>');
											$.each(fieldsPulln,function (key,value) {
//
												$('.listOfficer1').append(
													'<li class="pull-left text-meeting paticipant">' +
													'' + value+ '</li>'
												);
											});
//											break;
										} else {
											textColorAddn = '#ffffff';
											color = "bec661";

											$(".nearlyMeeting").remove();
											$(".div_nearlyMeeting").append('<div class="my_meeting nearlyMeeting"></div>');
											$(".nearlyMeeting").append('<div class="nearlyMeeting">' +
												'<p class = meetingC>' +
												'<i class="fa fa-clock-o" style="' + textColorAddn + '"></i> ' + response.query[i]['meeting_date_kh'] +
												'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #' + color + '; padding: 10px">' + response.query[i]['meeting_time'] +' - '+ response.query[i]['meeting_end_time']+
												'</span>' +
												'</p>' +
												'<p style="color:' + textColorAddn + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeAddctDiv1+'"> ' + response.query[i]['objective'] + '</span></p>' +
												'<p style="color:' + textColorAddn + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[i]['chaire_by'] + '</span></p>' +
												'<p style="color:' + textColorAddn + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomAdd1 + '</span></p>' +
												'<address style="color: ' + textColorAddn + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
												'<ul class="listOfficer1"></ul>' +
												'</address>' +
												'</div>');
											$.each(fieldsPulln,function (key,value) {
//
												$('.listOfficer1').append(
													'<li class="pull-left text-meeting paticipant">' +
													'' + value+ '</li>'
												);
											});
											break;
										}
										// break;
									}
								}
							}
							// alert(response.query);
							for (j = 0; j < response.query.length; j++) {

								var OnTimeCheckingAdd = Date.parse(response.query[j]['meeting_date_en'] + ' ' + response.query[j]['check_time']);
								var OnTimeMeetingAdd = Date.parse(response.query[j]['meeting_date_en'] + ' ' + response.query[j]['meeting_time_24']);
								var OnTimeFinishTimeAdd = Date.parse(response.query[j]['meeting_date_en'] + ' ' + response.query[j]['finishTime']);

								var strObjectAddDiv2 = response.query[j]['objective'];
								var fontSizeObjeAddctDiv2;
								var demo2ObjectiveAddDiv2;
								if(strObjectAddDiv2.length > 100){
									fontSizeObjeAddctDiv2 = '20px';
									demo2ObjectiveAddDiv2 = strObjectAddDiv2.substr(0,100)+'...';
								}else{
									fontSizeObjeAddctDiv2 = '24px';
									demo2ObjectiveAddDiv2 = strObjectAddDiv2;
								}

								var listOfficerPull;
								if(response.query[j]['list_official'] ==null){
									listOfficerPull = ",";
								}else {
									listOfficerPull = response.query[j]['list_official'];
								}
								var fieldsPull = listOfficerPull.split(',');

								var meetingRoomAdd2;
								if(response.query[j]['location'] == null) {
									meetingRoomAdd2 = 'ប្រជុំខាងក្រៅ';
								}else{
									meetingRoomAdd2 = response.query[j]['location'];
								}

								if (currentTimeAdd >= OnTimeMeetingAdd && currentTimeAdd <= OnTimeFinishTimeAdd) {
									if (response.query[j]['Id'] != OnTime || OnTime =='' ) {
										meetingOnTime[1] = response.query[j];
										$(".meeting").remove();
										$(".div_meeting").append('<div class="my_meeting meeting"></div>');
										$(".meeting").append('<div class="meeting">' +
											'<p>' +
											'<i class="fa fa-clock-o"></i>' + response.query[j]['meeting_date_kh'] +
											'<span class="pad-badge badge animated infinite flash meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #d65d51; padding: 10px">' + response.query[j]['meeting_time'] +' - '+ response.query[j]['meeting_end_time']+
											'</span>' +
											'<span class="pad-badge badge animated infinite flash test" style="font-size: 18px; margin-top: -2px; background-color: #d65d51; margin: 10px; padding: 10px;" id="nearlyMeeting">កំពុងប្រជុំ' +
											'</p>' +
											'<p ><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeAddctDiv2+'"> ' + response.query[j]['objective'] + '</span></p>' +
											'<p><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[j]['chaire_by'] + '</span></p>' +
											'<p><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomAdd2 + '</span></p>' +
											'<address style="color: #ffffff; line-height: 30px; margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
											'<ul class="listOfficer2"></ul>' +
											'</address>' +
											'</div>');
										countM = true;
										$.each(fieldsPull,function (key,value) {
//
											$('.listOfficer2').append(
												'<li class="pull-left text-meeting paticipant">' +
												'' + value+ '</li>'
											);
										});
										break;
									}

								} else if (currentTimeAdd >= OnTimeCheckingAdd && currentTimeAdd < OnTimeMeetingAdd) {
									if (response.query[j]['Id'] != nearlyOnTime && nearlyOnTime != 'undefined') {
										meetingOnTime[1] = response.query[j];
										$(".meeting").remove();
										$(".div_meeting").append('<div class="my_meeting meeting"></div>');
										$(".meeting").append('<div class="meeting">' +
											'<p>' +
											'<i class="fa fa-clock-o"></i> ' + response.query[j]['meeting_date_kh'] +
											'<span class="pad-badge badge animated infinite flash meetingTime" style="font-size: 18px; margin-top: -2px; background-color: #ee984c; padding: 10px">' + response.query[j]['meeting_time'] +' - '+ response.query[j]['meeting_end_time']+
											'</span>' +
											'<span class="pad-badge badge animated infinite flash test" style="font-size: 18px; margin-top: -2px; background-color: #ee984c; margin: 10px; padding: 10px;">ជិតប្រជុំ' +
											'</span>' +
											'</p>' +
											'<p><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeAddctDiv2+'"> ' + response.query[j]['objective'] + '</span></p>' +
											'<p><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[j]['chaire_by'] + '</span></p>' +
											'<p><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomAdd2 + '</span></p>' +
											'<address style="color: #ffffff; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
											'<ul class="listOfficer2"></ul>' +
											'</address>' +
											'</div>');
										count = true;
										$.each(fieldsPull,function (key,value) {
//
											$('.listOfficer2').append(
												'<li class="pull-left text-meeting paticipant">' +
												'' + value+ '</li>'
											);
										});
										break;
									}

								} else {

									if(response.query.length > 2){
										if (response.query[j]['Id'] != other && response.query[j]['meeting_date_en'] ==currentDate && currentTimeAdd < OnTimeMeetingAdd){
											meetingOnTime[1] = response.query[j];
											var textColorAdds;
											if (currentTimeAdd > OnTimeFinishTimeAdd) {
												color = "#cfe4e0";
												textColorAdds = '#c9eae4';
											} else {
												textColorAdds = '#ffffff';
												color = "#bec661";
											}
											$(".meeting").remove();
											$(".div_meeting").append('<div class="my_meeting meeting"></div>');
											$(".meeting").append('<div class="meeting">' +
												'<p class="meetingC">' +
												'<i class="fa fa-clock-o" style="color:' + textColorAdds + '"></i>' + response.query[j]['meeting_date_kh'] +
												'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + response.query[j]['meeting_time'] +' - '+ response.query[j]['meeting_end_time']+
												'</span>' +
												'</p>' +
												'<p style="color:' + textColorAdds + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle"style="font-size: '+fontSizeObjeAddctDiv2+'"> ' + response.query[j]['objective'] + '</span></p>' +
												'<p style="color:' + textColorAdds + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[j]['chaire_by'] + '</span></p>' +
												'<p style="color:' + textColorAdds + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomAdd2 + '</span></p>' +
												'<address style=" color: ' + textColorAdds + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
												'<ul class="listOfficer2"></ul>' +
												'</address>' +
												'</div>');

											$.each(fieldsPull,function (key,value) {
//
												$('.listOfficer2').append(
													'<li class="pull-left text-meeting paticipant">' +
													'' + value+ '</li>'
												);
											});
											break;
										}else if (response.query[j]['Id'] != other && response.query[j]['meeting_date_en'] > currentDate && currentTimeAdd < OnTimeMeetingAdd){
											meetingOnTime[1] = response.query[j];
											var textColorAdds;
											if (currentTimeAdd > OnTimeFinishTimeAdd) {
												color = "#cfe4e0";
												textColorAdds = '#c9eae4';
											} else {
												textColorAdds = '#ffffff';
												color = "#bec661";
											}
											$(".meeting").remove();
											$(".div_meeting").append('<div class="my_meeting meeting"></div>');
											$(".meeting").append('<div class="meeting">' +
												'<p class="meetingC">' +
												'<i class="fa fa-clock-o" style="color:' + textColorAdds + '"></i>' + response.query[j]['meeting_date_kh'] +
												'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + response.query[j]['meeting_time'] +' - '+ response.query[j]['meeting_end_time']+
												'</span>' +
												'</p>' +
												'<p style="color:' + textColorAdds + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeAddctDiv2+'"> ' + response.query[j]['objective'] + '</span></p>' +
												'<p style="color:' + textColorAdds + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[j]['chaire_by'] + '</span></p>' +
												'<p style="color:' + textColorAdds + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomAdd2 + '</span></p>' +
												'<address style=" color: ' + textColorAdds + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
												'<ul class="listOfficer2"></ul>' +
												'</address>' +
												'</div>');

											$.each(fieldsPull,function (key,value) {
//
												$('.listOfficer2').append(
													'<li class="pull-left text-meeting paticipant">' +
													'' + value+ '</li>'
												);
											});
											break;
										}
									}else{

										if (response.query[j]['Id'] != other ){
											meetingOnTime[1] = response.query[j];
											var textColorAdds;
											if (currentTimeAdd > OnTimeFinishTimeAdd) {
												color = "#cfe4e0";
												textColorAdds = '#c9eae4';

												$(".meeting").remove();
												$(".div_meeting").append('<div class="my_meeting meeting"></div>');
												$(".meeting").append('<div class="meeting">' +
													'<p class="meetingC">' +
													'<i class="fa fa-clock-o" style="color:' + textColorAdds + '"></i>' + response.query[j]['meeting_date_kh'] +
													'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + response.query[j]['meeting_time'] +' - '+ response.query[j]['meeting_end_time']+
													'</span>' +
													'</p>' +
													'<p style="color:' + textColorAdds + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeAddctDiv2+'"> ' + response.query[j]['objective'] + '</span></p>' +
													'<p style="color:' + textColorAdds + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[j]['chaire_by'] + '</span></p>' +
													'<p style="color:' + textColorAdds + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomAdd2 + '</span></p>' +
													'<address style=" color: ' + textColorAdds + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
													'<ul class="listOfficer2"></ul>' +
													'</address>' +
													'</div>');
												$.each(fieldsPull,function (key,value) {
//
													$('.listOfficer2').append(
														'<li class="pull-left text-meeting paticipant">' +
														'' + value+ '</li>'
													);
												});
											} else {
												textColorAdds = '#ffffff';
												color = "#bec661";

												$(".meeting").remove();
												$(".div_meeting").append('<div class="my_meeting meeting"></div>');
												$(".meeting").append('<div class="meeting">' +
													'<p class="meetingC">' +
													'<i class="fa fa-clock-o" style="color:' + textColorAdds + '"></i>' + response.query[j]['meeting_date_kh'] +
													'<span class="pad-badge badge animated infinite meetingTime" style="font-size: 18px; margin-top: -2px; background-color: ' + color + '; padding: 10px">' + response.query[j]['meeting_time'] +' - '+ response.query[j]['meeting_end_time']+
													'</span>' +
													'</p>' +
													'<p style="color:' + textColorAdds + '"><i class="fa fa-file-text pull-left icon-meeting"></i><span class="pull-left text-meeting fontTitle" style="font-size: '+fontSizeObjeAddctDiv2+'"> ' + response.query[j]['objective'] + '</span></p>' +
													'<p style="color:' + textColorAdds + '"><i class="fa fa-user pull-left icon-meeting"></i><span class="pull-left font-bold text-meeting font22"> ' + response.query[j]['chaire_by'] + '</span></p>' +
													'<p style="color:' + textColorAdds + '"><i class="fa fa-map-marker pull-left icon-meeting"></i><span class="pull-left text-meeting font18"> ' + meetingRoomAdd2 + '</span></p>' +
													'<address style=" color: ' + textColorAdds + '; line-height: 30px;  margin-left: 7px;"> <i class="fa fa-users pull-left icon-meeting" style=" margin-left: -9px;"></i>' +
													'<ul class="listOfficer2"></ul>' +
													'</address>' +
													'</div>');
												$.each(fieldsPull,function (key,value) {
//
													$('.listOfficer2').append(
														'<li class="pull-left text-meeting paticipant">' +
														'' + value+ '</li>'
													);
												});
												break;
											}

										}
//									 break;
									}

								}
							}

							var objMeetings = response.query;
							var objMeetingCountPull = Object.keys(objMeetings).length;
							if (response.query != undefined) {
								var endDateAdd;
								var numOfMeetingTodayAdd = 0;
								var numOfMeetingTotalAdd = Object.keys(objMeetings).length;
								var totalNearlyMeetingAdd = 0;
								var totalNotMeetingAdd = 0;
								var birthdayAdd = '';
								meetingList = {};
								for (h = 0; h < objMeetings.length; h++) {

									meetingList[h] = objMeetings[h];

									var check_timeAddLis = Date.parse(response.query[h]['meeting_date_en'] + ' ' + response.query[h]['check_time']);
									var meeting_24AddLis = Date.parse(response.query[h]['meeting_date_en'] + ' ' + response.query[h]['meeting_time_24']);
									var finishTimeAddLis = Date.parse(response.query[h]['meeting_date_en'] + ' ' + response.query[h]['finishTime']);
									var colormeetingAdd;
									var textColorAdd;
									var flash;
									var listOfficerAdd;
									if(response.query[h]['list_official'] ==null){
										listOfficerAdd = ",";
									}else {
										listOfficerAdd = response.query[h]['list_official'];
									}
									var nameAdd = listOfficerAdd.split(',');

									if (currentTimeAdd >= check_timeAddLis && currentTimeAdd <= meeting_24AddLis) {
										flash = 'flash';
										textColorAdd = '#ffffff';
										colormeetingAdd = '#ee984c';
									} else if (currentTimeAdd >= meeting_24AddLis && currentTimeAdd <= finishTimeAddLis) {
										flash = 'flash';
										textColorAdd = '#ffffff';
										colormeetingAdd = '#d65d51';
									} else if (currentTimeAdd > finishTimeAddLis) {
										flash = '';
										textColorAdd = '#8DC0B1';
										colormeetingAdd = '#cfe4e0';
									} else {
										flash = '';
										textColorAdd = '#ffffff';
										colormeetingAdd = '#bec661';

									}

									var meetingOnTimes;
									var meetingOnTimes2;
									if (typeof(meetingOnTime[0]) !== "undefined") {
										meetingOnTimes = meetingOnTime[0]['Id'];
									} else {
										meetingOnTimes = 0;
									}
									if (typeof(meetingOnTime[1]) !== "undefined") {
										meetingOnTimes2 = meetingOnTime[1]['Id'];
									} else {
										meetingOnTimes2 = 0;
									}

									if( response.query[h]['meeting_date_en'] ==currentDate){
										numOfMeetingTodayAdd = numOfMeetingTodayAdd + 1;
										if(response.query[h]['birth_day'] !=null){
											birthdayAdd = response.query[h                                                                                                                                                                      ]['birth_day'];
										}
									}
									if (currentTimeAdd >= check_timeAddLis && currentTimeAdd <= meeting_24AddLis) {
										totalNearlyMeetingAdd = totalNearlyMeetingAdd + 1;
									}
									if (currentTimeAdd < meeting_24AddLis) {
										totalNotMeetingAdd = totalNotMeetingAdd + 1;
									}
									endDateAdd = response.query[h]['meeting_date_kh'];

									var strObjectAdd = objMeetings[h]['objective'];
									var fontSizeObjectAdd;
									var demo2ObjectiveAdd;
									if(strObjectAdd.length > 100){
										fontSizeObjectAdd = '20px';
										demo2ObjectiveAdd = strObjectAdd.substr(0,100)+'...';
									}else{
										fontSizeObjectAdd = '26px';
										demo2ObjectiveAdd = strObjectAdd;
									}

									var meetingRoomAddDemo;
									if(response.query[h]['location'] == null) {
										meetingRoomAddDemo = 'ប្រជុំខាងក្រៅ';
									}else{
										meetingRoomAddDemo = response.query[h]['location'];
									}


									if (objMeetings[h]['Id'] != meetingOnTimes && objMeetings[h]['Id'] != meetingOnTimes2) {
										$(".demo1").append('<li class="news-item" data-id="2" >' +
											'<div class="">'+
											'<div class="row"  style=" color:' + textColorAdd + '">' +
											'<div class="col-sm-2" style="border-right: 1px solid #44a28d;width: 13.666667%;">' +
											'<p class="date-block" style=" color:' + textColorAdd + '">' + objMeetings[h]['meeting_date_kh'] + '</p>' +
											'<p><span class="badge badge-danger spanNearlyMeeting ' + flash + '" style="font-size: 20px;margin-top:-5px; margin-left: 25px;background-color: ' + colormeetingAdd + '; color: #ffffff;padding: 5px">' + objMeetings[h]['meeting_time'] + '</span></p>' +
											'</div>' +
											'<input type="hidden" class="createDate" id="createDate_' + i + '" value="' + objMeetings[h]['create_date'] + '"></input>' +
											'<div class="col-md-6">' +
											'<div class="info-blog">' +
											'<div>' +
											'<i class="fa fa-file-text pull-left" style="color:' + textColorAdd + '"></i><span class="pull-left font-26" style="color:' + textColorAdd + ';font-size: '+fontSizeObjectAdd+' !important;""> ' + objMeetings[h]['objective'] + '</span>' +
											'</div>' +
											'<div class="font-bold">' +
											'<i class="fa fa-user pull-left" style="color:' + textColorAdd + '"></i><span class="pull-left" style="color:' + textColorAdd + ';>' + objMeetings[h]['chaire_by'] + '</span>' +
											'</div>' +
											'<div>' +
											'<i class="fa fa-map-marker pull-left" style="color:' + textColorAdd + '"></i><span class="pull-left font18" style="color:' + textColorAdd + '">' + meetingRoomAddDemo + '</span>' +
											'</div>' +
											'</div>' +

											'</div>' +
											'<div class="col-md-4">' +
											'<div class="col-md-2">' +
											'<p style="color:' + textColorAdd + '"><i class="fa fa-users fa-lg" style="color:' + textColorAdd + '"></i></p>' +
											'</div>' +

											'<div class="col-md-10">' +
											'<address style="color: ' + textColorAdd + '; line-height: 30px; ">' +
											'<div id="listOfficers_'+h+'" class="listOfficer"></div>'+
											'</address>' +

											'</div>' +
											'</div>' +
											'</div>' +
											'</div>'+
											'</li>');

										$.each(nameAdd,function (key,value) {
											if(key < 7){
												$('#listOfficers_'+h).append(
													'<p class="listDemo1" style="color:'+textColorAdd+'">' +
													'' + value+ '</p>'
												);
											}

										});
										if( Object.keys(nameAdd).length >7){
											$('#listOfficers_'+h).append(
												'<p class="listDemo1" style="color:'+textColorAdd+'">.....</p>'
											);
										}
										if (objMeetingCountPull > 3) {
											$(".demo2").append('<li class="news-item"' +
												'<div>'+
												'<div class="">'+
												'<div class="row" style="padding: 0;">' +
												'<div class="col-md-12" style="padding-right: 0; padding-left: 0;">' +
												'<div class="col-md-2 md2-demo2" style="width:13.66667%;border-right: 1px solid #44a28d;">' +
												'<p class="date-block-small" style="color:' + textColorAdd + '">' + objMeetings[h]['meeting_date_kh'] + '</p>' +
												'<p><span class="badge badge-warning spanNearlyMeeting ' + flash + '" style="font-size: 16px;margin-top:-10px; margin-left: 38px; background-color: ' + colormeetingAdd + '; color: #ffffff; padding: 5px">' + objMeetings[h]['meeting_time'] + '</span>' +
												'</p>' +
												'</div>' +

												'<div class="col-md-10 md10-demo2">' +
												'<p class="title-one-row" style="color:' + textColorAdd + '">' +
												'<i class="fa fa-file-text" style="color:' + textColorAdd + ';font-size: '+fontSizeObjectAdd+' !important;"></i> ' + demo2ObjectiveAdd +
												'</p>' +
												'</div>' +
												'</div>' +
												'</div>' +
												'</div>'+
												'</div>'+
												'</li>');

										} else {
											$(".demo2").remove();
											$(".demo2-parent").append('<ul class="demo2"></ul>');
										}

									}

								}

								if (Object.keys(objMeetings).length >4){
									$(".demo1").append('<li class="news-item" data-id="2">' +
										'<div class="total-meeting" style="background:#1a6a59 !important;">'+
										'<div class="row"  style=" ">' +
										'<div class="col-sm-2" style="border-right: 1px solid #44a28d;width: 13.666667%;">' +
										'<p class="date-block">'+response.query[0]['meeting_date_kh']+'</p>' + '<p class="toDate" style="text-align:center !important">ដល់</p>' +
										'<p class="date-block">'+endDateAdd+'</p>' +

										'</div>' +
										'<input type="hidden" class="createDate" id="createDate" value="testing"></input>' +
										'<div class="col-md-6">' +
										'<div class="info-blog totalMeeting">' +
										'<div class="col-xs-6">' +
										'<i class="fa fa-users pull-left"></i><span class="pull-left "> មិនទាន់ប្រជុំ : '+totalNotMeetingAdd+'</span>' +
										'</div>' +
										'<div class="col-xs-6">' +
										'<i class="fa fa-edit pull-left"></i><span class="pull-left "> ប្រជុំសរុបថ្ងៃនេះ : '+numOfMeetingTodayAdd+'</span>' +
										'</div>' +
										'<div class="col-xs-6">' +
										'<i class="fa fa-bullhorn pull-left"></i><span class="pull-left "> ជិតប្រជុំ : '+totalNearlyMeetingAdd+'</span>' +
										'</div>' +
										'<div class="col-xs-6">' +
										'<i class="fa fa-globe pull-left"></i><span class="pull-left ">កិច្ចប្រជុំសរុប : '+numOfMeetingTotalAdd+'</span>' +
										'</div>' +
										'<div>' +

										'</div>' +
										'</div>' +

										'</div>' +

										'</div>' +
										'</div>'+
										'</li>');

									$(".demo2").append('<li class="news-item"' +
										'<div >'+
										'<div class="total-meeting total-meeting-demo2" style="background:#1a6a59 !important;">'+
										'<div class="row" style="padding: 0;">' +
										'<div class="col-md-12" style="padding-right: 0; padding-left: 0;">' +
										'<div class="col-md-2 md2-demo2" style="width:13.66667%;border-right: 1px solid #44a28d;">' +
										'<p class="date-block-small" style="color:#fffff">'+response.query[0]['meeting_date_kh']+'</p>' +
										'</p>' +
										'</div>' +

										'<div class="col-md-10 md10-demo2">' +
										'<p class="title-one-row" style="color:#ffffff">' +
										'<i class="fa fa-edit pull-left"></i><span class="pull-left total-meeting-demo2"> ប្រជុំសរុបថ្ងៃនេះ : '+numOfMeetingTodayAdd+'</span>' +
										'<i class="fa fa-bullhorn pull-left"></i><span class="pull-left total-meeting-demo2"> ជិតប្រជុំ : '+totalNearlyMeetingAdd+'</span>' +
										'<i class="fa fa-globe pull-left"></i><span class="pull-left total-meeting-demo2">កិច្ចប្រជុំសរុប : '+numOfMeetingTotalAdd+'</span>' +
										'</p>' +
										'</div>' +
										'</div>' +
										'</div>' +
										'</div>' +
										'</div>' +
										'</li>');
								}

								for(var d=0;d<$(".demo1 li").length;d++){
									var addClass;
									if( d %2 ==0){
										addClass ='tvFade';
									}else{
										addClass ='tvNoFade';
									}
//								console.log(d);
									$(".demo1 li").eq(d).children("div").addClass(addClass);
									$(".demo2 li").eq(d).children("div div").addClass(addClass);
								}
							} else {
								$(".demo2").remove()
								$(".demo1").remove();

								$(".demo2-parent").append('<ul class="demo2"></ul>');
								$(".demo1-parent").append('<ul class="demo1"></ul>');
							}

							if(response.query != undefined){
								if(objMeetingCountPull > 4){
									if(objMeetingCountPull !=4){
										$(".demo2").bootstrapNews({
											newsPerPage: 9,
											autoplay: true,
											pauseOnHover: false,
											direction: 'up',
											newsTickerInterval: 10000,
											pauseOnHover: false,
											onStop: function () {
												console.log(1);
											},

										});
									}
									$(".demo1").bootstrapNews({
										newsPerPage: 2,
										autoplay: true,
										pauseOnHover: false,
										direction: 'up',
										newsTickerInterval: 10000,
										pauseOnHover: false,
										onToDo: function () {
											//console.log(this);
										},

									});


								}
							}

						}
					},
					timeout: 60000,
					complete: poll
				});
			}, 9000);

		})();


	</script>

@endsection