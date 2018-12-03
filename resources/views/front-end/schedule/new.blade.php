<?php
$jqxPrefix = '_metting';
$saveUrl = asset($constant['secretRoute'].'/schedule/save');
$getOfficerForJoinByOfficeId = asset($constant['secretRoute'].'/schedule/officer-for-join');
?>
<div class="container-fluid content-popup-new">
	<form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
		<input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
		<div class="form-group">
			<div class="col-sm-2 text-right">
				<div class="label-margin-top10">
					<span class="red-star">*</span> <label>{{trans('schedule.meeting_type')}}</label>
				</div>
			</div>
			<div class="col-sm-10">
				<input type="hidden" class="form-control" placeholder="{{trans('schedule.meeting_type')}}" id="mef_meeting_type_id" name="mef_meeting_type_id" value="{{isset($row->mef_meeting_type_id) ? $row->mef_meeting_type_id:''}}">
				<div id="div_mef_meeting_type_id"></div>
				{{--<button type="button" id="btn_more_meeting_type" class="btn btn-default" data-toggle="modal" data-target="#myModalMeetingType">+</button>--}}
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-2 text-right"><span class="red-star">*</span> <label class="label-margin-top10">{{trans('schedule.meeting_purpose')}}</label></div>
			<div class="col-sm-10" id="warp_meeting_objective">
				<textarea rows="3" placeHolder="{{trans('schedule.meeting_purpose')}}" class="form-control" id="meeting_objective" name="meeting_objective">{{isset($row->meeting_objective) ? $row->meeting_objective:''}}</textarea>
			</div>
		</div>
		<div class="group-form-new-meeting">		
			<div class="title-group-meeting">
				<label>{{trans('schedule.meeting_leader')}}</label>
			</div>
			<div class="form-group">
				<div class="col-sm-2 text-right">
					<div class="label-margin-top10">
						<span class="red-star">*</span> <label>{{trans('schedule.in_system')}}</label>
					</div>
				</div>
				<div class="col-sm-10">
					<input type="hidden" class="form-control" placeholder="{{trans('schedule.meeting_leader')}}" id="mef_meeting_leader_id" name="mef_meeting_leader_id" value="{{isset($row->mef_meeting_leader_id) ? $row->mef_meeting_leader_id:''}}">
					<div id="div_mef_meeting_leader_id"></div>
					{{--<button type="button" id="btn_more_leader" class="btn btn-default" data-toggle="modal" data-target="#myModalLeader">+</button>--}}
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2 text-right">
					<div class="label-margin-top10">
						<label>{{trans('schedule.out_system')}}</label>
					</div>
				</div>
				<div class="col-sm-10">
					<input type="text" class="form-control" disabled placeholder="" id="mef_meeting_leader_out" name="mef_leader_outside" value="{{isset($row->mef_leader_outside) ? $row->mef_leader_outside:''}}">
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-2 text-right"><label class="label-margin-top10"><span class="red-star">*</span> {{trans('schedule.meeting_date')}}</label></div>
			<div class="col-sm-3">
				<input type="hidden"  id="meeting_date" name="meeting_date" value="{{isset($row->meeting_date) ? $row->meeting_date:date('Y-m-d')}}">
				<div id="div_meeting_date"></div>
			</div>
			<div class="col-sm-2 text-right"><label class="label-margin-top10"><span class="red-star">*</span> {{trans('schedule.num_of_day')}}</label></div>
			<div class="col-sm-1">
				<input type="number" id="num_of_day" name="num_of_day" placeholder="ចំនួនថ្ងៃ" value="{{isset($row->num_of_day) ? $row->num_of_day:''}}" class="form-control">
			</div>
		<!-- <div class="col-sm-5">
				<?php $all = isset($row->all) ? $row->all : 0; ?>
				<input type="hidden" id="join_all" name="join_all" value="{{$all}}">
				<div id="join_all_checkbox"> {{trans('schedule.meeting_all_together')}}</div>
			</div>-->
		</div>
		<div class="form-group">
			<div class="col-sm-2 text-right"><label class="label-margin-top10"><span class="red-star">*</span> {{trans('schedule.time')}}</label></div>
			<div class="col-sm-2">
				<div id="div_meeting_time" name="meeting_time"></div>
			</div>
			<div class="col-sm-1"><label class="label-margin-top10">ដល់</label></div>
			<div class="col-sm-2">
				<div id="div_meeting_End_time" name="meeting_end_time"></div>
			</div>
		</div>
		<div class="group-form-new-meeting">
			<div class="title-group-meeting">
					<label>{{trans('schedule.meeting_participant')}}</label>
			</div>
			<div class="form-group join_all_class">
				<div class="col-sm-2 text-right">
					<div id="office_label"><label>{{trans('officer.search_office')}} </label></div>
				</div>
				<div class="col-sm-10">
					<input type="hidden" name="mef_office_id" id="mef_office_id" value="{{isset($row->mef_office_id) ? $row->mef_office_id:''}}" />
					<div id="div_mef_office_id"></div>
				</div>
			</div>
			<div class="form-group join_all_class">
				<div class="col-sm-2 text-right">
					<div class="label-margin-top10" id="office_meeting_atendee_join"><label><span class="red-star">*</span>{{trans('schedule.meeting_participant')}}</label></div>
				</div>
				<div class="col-sm-10">
					<div id="div_mef_meeting_atendee_join" name="mef_meeting_atendee_join"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2 text-right"></div>
				<div class="col-sm-10">
					<?php $is_invite_guest = isset($row->is_invite_guest) ? $row->is_invite_guest : 0; ?>
					<div>
						<input type="hidden" id="is_invite_guest" name="is_invite_guest" value="{{$is_invite_guest}}">
						<div id="is_invite_guest_checkbox"> {{trans('schedule.outside_participant')}}</div>
					</div>
					<div id="warp_outside_participant" style="background: #eee;">

						<div id="warp_outside_participant_content">
							@if(isset($row->mef_member_outside))
								<div class="col-md-12">
									<input type="text" id="guest_name" class="form-control guest_name" placeholder="ឈ្មោះ"  name="mef_member_outside" value="{{isset($row->mef_member_outside) ? $row->mef_member_outside : 0}}">
								</div>
							@endif
						</div>
						{{--<button type="button" class="btn btn-default" id="btn_more_outside" disabled>+</button>--}}
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-2 text-right"><span class="red-star">*</span> <label class="label-margin-top10">{{trans('schedule.meeting_location')}}</label></div>
			<div class="col-sm-10">
				<input type="hidden" class="form-control" placeholder="{{trans('schedule.meeting_location')}}" id="meeting_location" name="meeting_location_id" value="{{isset($row->meeting_location_id) ? $row->meeting_location_id:''}}">
				<div id="div_meeting_location"></div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-2 text-right"></div>
			<div class="col-sm-4">
				<input type="hidden" id="public" name="public" value="{{isset($row->public) ? $row->public : 1}}">
				<div id="div_public_checkbox"> {{trans('schedule.public')}}</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<button class="btn btn-lg btn-success btn-box-save pull-right" id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
			</div>
		</div>

	</form>
</div>

<script>

	<?php
	$year = date('Y');
	$month = date('m');
	$month = $month - 1 ;
	$day = date('d');
	?>
	function saveJqxItem(prefix, saveUrl, token,msg=1,callback){

		var valid = $('#jqx-form'+prefix).jqxValidator('validate');
		if(valid || typeof(valid) === 'undefined'){
			var formData = new window.FormData($('#jqx-form'+prefix)[0]);
			$.ajax({
				type: "post",
				data: formData,
				contentType: false,
				cache: false,
				processData:false,
				dataType: "json",
				url: saveUrl,
				beforeSend: function( xhr ) {
					if($("#jqx-save"+prefix).length){
						$('#jqx-save'+prefix).jqxButton({ disabled: true });
					}
				},
				success: function (response) {
					// console.log(response);
					// return;
					if($("#jqx-grid"+prefix).length){
						$("#jqx-grid"+prefix).jqxTreeGrid('updateBoundData');
						$("#jqx-grid"+prefix).jqxGrid('updatebounddata');
						$("#jqx-grid"+prefix).jqxGrid('clearselection');
					}
					$("#jqx-notification").jqxNotification();
					$("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:6000,autoClose: true});
					if(response.code == 0){
						$('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning",autoCloseDelay:6000,autoClose: true }).html(response.message);
						$("#jqx-notification").jqxNotification("open");
					}else{
						if(msg==1){
							$('#jqx-notification').jqxNotification({ position: positionNotify,template: "success"}).html(response.message);
							$("#jqx-notification").jqxNotification("open");
						}

						/* $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning",autoClose: false }).html(response.message);
						$("#jqx-notification").jqxNotification("open"); */

						if(callback){
							callback(response);
						}else{
							closeJqxWindowId('jqxwindow'+prefix);
						}

					}
				},
				complete: function(jqXHR, textStatus) {
					var responseText = JSON.parse(jqXHR.responseText);
					if(responseText.code == 1){
						closeJqxWindowId("jqxwindow"+prefix);
					}else{
						if($("#jqx-save"+prefix).length){
							$('#jqx-save'+prefix).jqxButton({ disabled: false });
						}
					}
				},
				error: function (request, textStatus, errorThrown) {
					$("#jqx-notification").jqxNotification();
					$("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:6000,autoClose: true});

					if(request.status == 422)
					{
						$('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning",autoCloseDelay:6000,autoClose: true }).html('ព័ត៌មានមិនត្រឹមត្រូវ');
						$("#jqx-notification").jqxNotification("open");

						var errors = JSON.parse(request.responseText);

						$.each($('input, select ,textarea', '#jqx-form'),function(k){

							var element = $(this).attr('name');

							if(errors[element])
							{
								if($(this).parents('div[class^="form-group"]').find('.help-block').length)
								{
									$(this).parents('div[class^="form-group"]').addClass('has-error').find('.help-block').html(errors[element]);
								}else
								{
									var msg = '<span class="help-block">' + errors[element] +'</span>';
									$(this).after(msg).parents('div[class^="form-group"]').addClass('has-error');
								}
							}else
							{
								if($(this).parents('div[class^="form-group"]').find('.help-block').length)
								{
									$(this).parents('div[class^="form-group"]').find('.help-block').remove();
									$(this).parents('div[class^="form-group"]').removeClass('has-error');
								}
							}
						});
					}

					if($("#jqx-save"+prefix).length){
						$('#jqx-save'+prefix).jqxButton({ disabled: false });
					}
				}
			});
		}
	}
	$(document).ready(function(){

		function days_of_a_year(year)
		{
			return isLeapYear(year) ? 366 : 365;
		}
		function isLeapYear(year) {
			return year % 400 === 0 || (year % 100 !== 0 && year % 4 === 0);
		}

		daysOfyear = days_of_a_year((new Date()).getFullYear());
		var d = new Date();
		var date2 = new Date();

		var sun = new Array();   //Declaring array for inserting Sundays

		for(var i=0;i<=daysOfyear;i++){    //looping through days in month
			var newDate = new Date(d.getFullYear(),d.getMonth(),i);
			if(newDate.getDay()==0){   //if Sunday
				date2.setHours(0,0,0);
				sun.push(newDate);
			}
			if(newDate.getDay()==6){   //if Saturday
				sun.push(newDate);
			}
		}

			<?php foreach($holiday as $val){ ?>
		var hol = '<?php echo $val; ?>';
		sun.push(new Date(hol));

			<?php } ?>


		var dateValue = $('#meeting_date').val();
		$("#div_meeting_date").jqxDateTimeInput({
			width: '100%',
			height: '30px',
			formatString: 'dd-MM-yyyy',
			theme: 'energyblue',
			value:dateValue,
			restrictedDates: sun
		});
		$('#div_meeting_date').on('change', function () {
			var dateVal = $(this).val().split('-');

			if (dateVal.length == 1){
				$('#meeting_date').val('');
			}
			else{
				$('#meeting_date').val(dateVal[2]+'-'+dateVal[1]+'-'+dateVal[0]);
			}
		});

		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth();
		var yyyy = today.getFullYear();
		$('#div_meeting_date').jqxDateTimeInput('setMinDate', new Date(yyyy, mm, dd));

		// meeting_time
		$('#div_meeting_time').jqxDateTimeInput({
			width: 86,
			height: 30,
			formatString: 't',
			animationType:'fade',
			showTimeButton: true,
			showCalendarButton: false
		});

		$('#div_meeting_End_time').jqxDateTimeInput({
			width: 86,
			height: 30,
			formatString: 't',
			animationType:'fade',
			showTimeButton: true,
			showCalendarButton: false
		});
		$('#div_meeting_time ').jqxDateTimeInput('setDate', new Date(<?php echo $year; ?>, <?php echo $month; ?>, <?php echo $day; ?>,<?php echo isset($row->meeting_time_24) ? str_replace(':',',',$row->meeting_time_24):'24,00'; ?>));
		$('#div_meeting_End_time ').jqxDateTimeInput('setDate', new Date(<?php echo $year; ?>, <?php echo $month; ?>, <?php echo $day; ?>,<?php echo isset($row->meeting_end_time24) ? str_replace(':',',',$row->meeting_end_time24):'24,00'; ?>));

		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth();
		var yyyy = today.getFullYear();

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

		// div_mef_meeting_type_id
		initDropDownList(jqxTheme, '100%',30, '#div_mef_meeting_type_id', <?php echo $list_meeting_type;?>, 'text', 'value', false, '', '0', "#mef_meeting_type_id","{{$constant['buttonSearch']}}",250);
		$("#div_mef_meeting_type_id").jqxDropDownList('val',1);

		$("#div_meeting_location").jqxDropDownList({
			placeHolder: ""
		});
		initDropDownList(jqxTheme, '100%',30, '#div_meeting_location', <?php echo $meetingLocation;?>, 'text', 'value', false, '', '0', "#meeting_location","{{$constant['buttonSearch']}}",250);
		// div_mef_meeting_leader_id
		initDropDownList(jqxTheme, '100%',30, '#div_mef_meeting_leader_id', <?php echo $list_meeting_leader;?>, 'text', 'value', false, '', '0', "#mef_meeting_leader_id","{{$constant['buttonSearch']}}",250);

		// div_mef_office_id
		initDropDownList(jqxTheme, '100%',30, '#div_mef_office_id', <?php echo json_encode($list_office);?>, 'text', 'value', false, '', '0', "#mef_office_id","{{$constant['buttonSearch']}}",250);
		var arrOfficerId = new Array();

		var arrOffice = <?php echo json_encode($get_office_officer);?>;
		$.each(arrOffice, function( index, value ) {
			arrOfficerId.push(value.officeId);
		});
		$("#div_mef_office_id").jqxDropDownList({
			placeHolder: "",
			checkboxes: true
		});
		//merge office
		$("#div_mef_office_id").bind('select',function(event){
			if($(this).val() != 0){
				var arrOfficeList = $(this).val().split(',');

				arrOfficerId= arrOfficeList;
			}else{
				arrOfficerId =[];
			}
			var leaderId = $("#div_mef_meeting_leader_id").val();

			var officeAtendenId = $('input[name=mef_meeting_atendee_join]').val();

			mefMeetingAtendeeJoin(arrOfficerId,officeAtendenId,leaderId);
		});
//onClik event on dropdown leader
		$("#div_mef_meeting_leader_id").bind('select',function(event){
			if($(this).val() == 0){
				$("#mef_meeting_leader_out").removeAttr("disabled");
			}else{
				$("#mef_meeting_leader_out").attr("disabled",'');
				$("#mef_meeting_leader_out").val('');
			}
		});

		if($("#Id").val() != 0){
			$("#mef_meeting_leader_out").removeAttr("disabled");
		}

		$("#div_mef_meeting_leader_id").bind('select',function(event){;
			mefMeetingAtendeeJoin('','',$(this).val());
		});

		// Create a jqxComboBox div_mef_meeting_atendee_join
		mefMeetingAtendeeJoin($("#mef_office_id").val(),0,'');

		$("#num_of_day").val(1);


		var buttons = ['jqx-save<?php echo $jqxPrefix;?>',];
		initialButton(buttons,90,30);
//		alert($("#div_meeting_location").val() == "");
		$('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({

			hintType:'label',
			rules: [
				{input: '#meeting_objective', message: ' ', action: 'blur', rule: 'required'},
				{input: '#num_of_day', message: ' ', action: 'select',
					rule: function () {
						if($("#num_of_day").val() == ""){
							return false;
						}
						return true;
					}
				},
				{input: '#div_meeting_location', message: ' ', action: 'select',
					rule: function () {
						if($("#div_meeting_location").val() == ""){
							var meetingType = $("#div_mef_meeting_type_id").val();
							if(meetingType == 2){
								return true
							}else{
								return false;
							}
						}
						return true;
					}
				},
				{input: '#div_mef_meeting_type_id', message: ' ', action: 'select',
					rule: function () {
						if($("#div_mef_meeting_type_id").val() == ""){
							return false;
						}
						return true;
					}
				},
				{input: '#div_meeting_date', message: ' ', action: 'select',
					rule: function () {
						if($("#div_meeting_date").val() == ""){
							return false;
						}
						return true;
					}
				},
				{input: '#div_mef_meeting_type_id', message: ' ', action: 'select',
					rule: function () {
						if($("#div_meeting_date").val() == ""){
							return false;
						}
						return true;
					}
				},
				{input: '#div_mef_meeting_leader_id', message: ' ', action: 'select',
					rule: function () {
						if($("#div_mef_meeting_leader_id").val() == ""){
							return false;
						}
						return true;
					}
				},
				{input: '#div_meeting_date', message: ' ', action: 'select',
					rule: function () {
						if($("#meeting_date").val() == ""){
							return false;
						}
						return true;
					}
				}
			]
		});


		var isActive = $('#is_invite_guest').val() == 1 ? true:false;
		$("#is_invite_guest_checkbox").jqxCheckBox({theme:jqxTheme, width: 120, height: 25, checked: isActive});
		$('#is_invite_guest_checkbox').on('change', function (event) {
			event.args.checked == true ? $('#is_invite_guest').val(1):$('#is_invite_guest').val(0);
			if(event.args.checked == true){
				$("#warp_outside_participant").css("background", "#fff");
				$('#btn_more_outside').prop("disabled", false);
				// $("#guest_description").prop('disabled', false);
				var sub_more = '<div class="sub_more">' +
					'<div class="col-md-12"><input type="text" id="guest_name" class="form-control guest_name" placeholder="ឈ្មោះ"  name="mef_member_outside"></div>' +
					'</div>';
				$("#warp_outside_participant_content").append(sub_more);
				$('#guest_name').tagit({
					allowSpaces: true,
					removeConfirmation: true
				});
			}else{
				$("#warp_outside_participant").css("background", "#eee");
				$('#btn_more_outside').prop("disabled", true);
				// $("#guest_description").prop('disabled', true);
				$("#warp_outside_participant_content").html("");
			}
		});
		if(isActive == true){
			$("#warp_outside_participant").css("background", "#fff");
			$('#btn_more_outside').prop("disabled", false);
		}else{
			$("#warp_outside_participant").css("background", "#eee");
			$('#btn_more_outside').prop("disabled", true);
		}

//		$("#btn_more_outside").click(function(){
//			var sub_more = '<div class="sub_more">' +
//				'<div class="col-md-5"><input type="text" class="form-control guest_name" placeholder="ឈ្មោះ"  name="guest_name[]"></div>' +
//				'<div class="col-md-5"><input type="email" class="form-control guest_email" placeholder="អ៊ីម៉ែល"  name="guest_email[]"></div>' +
//				'<div class="col-md-2"><button type="button" class="btn btn-default btn_remove">-</button></div>' +
//				'</div>';
//			$("#warp_outside_participant_content").append(sub_more);
//		});

		$("div#warp_outside_participant_content").on('click', 'button.btn_remove', function() {
			$(this).parent().parent().remove();
		});

		var status_checked = {{$all == 1 ? 'true' : 'false' }};

		enable_disable_join_all(status_checked);

		// member outside
		$('#guest_name').tagit({
			allowSpaces: true,
			removeConfirmation: true
		});
		/*var isActive = $('#join_all').val() == 1 ? true:false;
        $("#join_all_checkbox").jqxCheckBox({theme:jqxTheme, width: 120, height: 25, checked: isActive});
        $('#join_all_checkbox').on('change', function (event) {
            event.args.checked == true ? $('#join_all').val(1):$('#join_all').val(0);
			enable_disable_join_all(event.args.checked);
        });*/

		//Public
		var isPublic = $('#public').val() == 1 ? true:false;
		$("#div_public_checkbox").jqxCheckBox({theme:jqxTheme, width: 120, height: 25, checked: isPublic});
		$('#div_public_checkbox').on('change', function (event) {
			event.args.checked == true ? $('#public').val(1):$('#public').val(0);
		});


		var status_checked = {{$all == 1 ? 'true' : 'false' }};
		enable_disable_join_all(status_checked);


		$( "#meeting_objective" ).blur(function() {
			apply_error_form();
		});

		// ឯកសារយោង
//		$("#btn_more_reference").click(function(){
//			var sub_more = '<div class="sub_more">' +
//				'<div class="col-md-5"><input type="text" class="form-control attachment_name" placeholder="ឈ្មោះឯកសារ"  name="attachment_name[]"></div>' +
//				'<div class="col-md-5"><input type="text" class="form-control attachment_link" placeholder="ឯកសារយោង"  name="attachment_link[]"></div>' +
//				'<div class="col-md-2"><button type="button" class="btn btn-default btn_remove">-</button></div>' +
//				'</div>';
//			$("#warp_reference_document_content").append(sub_more);
//		});

//		$("div#warp_reference_document_content").on('click', 'button.btn_remove', function() {
//			$(this).parent().parent().remove();
//		});
	});

	function mefMeetingAtendeeJoin(officeId,status_clear_select,leaderId){

		var source = {
			type: 'post',
			datatype: 'json',
			url: baseUrl+'schedule/officer-for-join',
			data: {
				Id: officeId,
				leaderId:leaderId,
				_token : '{{ csrf_token() }}',
				ajaxRequestJson:'true'
			}
		};
		var dataAdapter = new $.jqx.dataAdapter(source,{
			beforeLoadComplete: function (records) {
				if(status_clear_select != ''){

					getSelectedItems(status_clear_select);
				}else{
					getSelectedItems('');
				}
			}
		});

		$("#div_mef_meeting_atendee_join").jqxComboBox({
			source: dataAdapter,
			multiSelect: true,
			theme: jqxTheme,
			// width: '100%',
			width: '100%',
			height: 35,
			displayMember: "displayMember",
			valueMember : "valueMember",
			placeHolder: " {{trans('schedule.meeting_participant')}}",
			enableBrowserBoundsDetection:true,
			autoComplete:true,
			searchMode:'contains',
			dropDownHeight:450,
			animationType: 'none'
		});

		/* jqxComboBox on focus action */
		$('#div_mef_meeting_atendee_join input').on('focus', function (event) {

			$("#div_mef_meeting_atendee_join").jqxComboBox('open');
		});

	}





	function getSelectedItems(str_join){

		if(str_join != ''){
			var res_join = str_join.split(',');

			setTimeout(function(){
				$.each(res_join, function( index, value ) {
					$("#div_mef_meeting_atendee_join").jqxComboBox('selectItem', value);
				});
			}, 100);
		}else{

			var offcerIdJoin = '{{$mef_meeting_atendee_join}}';
			if(offcerIdJoin !=''){
				var offcerIdJoin = offcerIdJoin.split(',');
				setTimeout(function(){
					$.each(offcerIdJoin, function( index, value ) {
						$("#div_mef_meeting_atendee_join").jqxComboBox('selectItem', value);
					});
				}, 300);
			}

		}
	}

	function enable_disable_join_all(status_checked){

		if(status_checked == false){
			$("#div_mef_office_id").jqxDropDownList({ disabled: false });
			$("#div_mef_meeting_atendee_join").jqxComboBox({ disabled: false });
		}else{
			$("#div_mef_office_id").jqxDropDownList({ disabled: true });
			$("#div_mef_meeting_atendee_join").jqxComboBox({ disabled: true });
		}
	}

	function apply_error_form(){
		var $aSelected = $('#warp_meeting_objective').find('label');
		if( $aSelected.hasClass('jqx-validator-error-label') ){
			$("#meeting_objective").addClass("jqx-validator-error-element");
		}else{
			$("#meeting_objective").removeClass("jqx-validator-error-element");
		}
	}
	function ValidateEmail(email) {
		var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		return expr.test(email);
	}
	// Validation Data Field Custom
	function validationFormCustom(){
		$(".form-control").removeClass('jqx-validator-error-element');
		$("#div_mef_meeting_leader_id, #div_mef_meeting_type_id").removeClass('jqx-validator-error-element');
		var count_error = 0;

		$( "#warp_outside_participant_content .guest_name" ).each(function( index ) {
			if($( this ).val() == '' ){
				$( this ).addClass('jqx-validator-error-element');
				count_error = count_error + 1;
			}
		});
		/*$( "#warp_outside_participant_content .guest_email" ).each(function( index ) {
			if($( this ).val() == '' ){
				$( this ).addClass('jqx-validator-error-element');
				count_error = count_error + 1;
			}else{
				if (!ValidateEmail($( this ).val())) {
					$( this ).addClass('jqx-validator-error-element');
					count_error = count_error + 1;
				}
			}
		});*/
//		$( "#warp_reference_document_content .attachment_name" ).each(function( index ) {
//			if($( this ).val() == '' ){
//				$( this ).addClass('jqx-validator-error-element');
//				count_error = count_error + 1;
//			}
//		});
//		$( "#warp_reference_document_content .attachment_link" ).each(function( index ) {
//			if($( this ).val() == '' ){
//				$( this ).addClass('jqx-validator-error-element');
//				count_error = count_error + 1;
//			}
//		});
		return count_error;
	}

	/* Save action */
	$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
		count_error = validationFormCustom();
		if(count_error > 0){
			return false;
		}
		saveJqxItem('{{$jqxPrefix}}', baseUrl+'schedule/save', '{{ csrf_token() }}');
		apply_error_form();
	});
</script>
<style>
	#office_label{
		margin-top: 10px;
	}
	.label-margin-top10{
		margin-top: 10px;
	}
	/*#div_meeting_date, #div_meeting_time{ display: inline-block; }*/
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

	#leader_name, #leader_email{
		margin: 15px 0;
	}
	#myModalLeader .modal-dialog, #myModalMeetingType .modal-dialog{
		margin: 70px auto;
	}
	.form-control.validation-meeting-type{ margin: 15px 0; }
</style>