<?php
$jqxPrefix = '_metting';
$saveUrl = asset($constant['secretRoute'].'/meeting/save');
$getOfficerForJoinByOfficeId = asset($constant['secretRoute'].'/meeting/officer-for-join');
?>
<div class="container-fluid">
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
		    <div class="col-sm-9">
			    <input type="hidden" class="form-control" placeholder="{{trans('schedule.meeting_type')}}" id="mef_meeting_type_id" name="mef_meeting_type_id" value="{{isset($row->mef_meeting_type_id) ? $row->mef_meeting_type_id:''}}">
			    <div id="div_mef_meeting_type_id"></div>
		    </div>
		    <div class="col-sm-1">
			    <button type="button" id="btn_more_meeting_type" class="btn btn-default" data-toggle="modal" data-target="#myModalMeetingType">+</button>
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
                <input type="hidden" class="form-control" id="meeting_location" name="meeting_location_id" value="{{isset($row->meeting_location_id) ? $row->meeting_location_id:''}}">
	            <div id="div_meeting_location"></div>
            </div>
        </div>
		{{--<div class="form-group">--}}
            {{--<div class="col-sm-2 text-right">ឯកសារយោង</div>--}}
            {{--<div class="col-sm-10">--}}
				{{--<div id="warp_reference_document">--}}
					{{--<div id="warp_reference_document_content">--}}
						{{--@foreach($mef_meeting_to_file as $key=>$val)--}}
							{{--<div class="sub_more">--}}
								{{--<div class="col-md-5"><input type="text" class="form-control attachment_name" placeholder="ឈ្មោះឯកសារ"  name="attachment_name[]" value="{{$val->name}}"></div>--}}
								{{--<div class="col-md-5"><input type="email" class="form-control attachment_link" placeholder="ឯកសារយោង"  name="attachment_link[]" value="{{$val->mef_file_path}}"></div>--}}
								{{--<div class="col-md-2"><button type="button" class="btn btn-default btn_remove">-</button></div>--}}
							{{--</div>--}}
						{{--@endforeach--}}
					{{--</div>--}}
					{{--<button type="button" class="btn btn-default" id="btn_more_reference">+</button>--}}
				{{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="form-group">
			<div class="col-sm-2 text-right"></div>
			<div class="col-sm-4">
				<div name="send_email" id="send_email_checkbox"> {{trans('schedule.send_email')}}</div>
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
			<div class="col-sm-12 text-right">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
			</div>
		</div>

    </form>
</div>
<!-- Modal Leader Meeting -->
  <div class="modal fade" id="myModalLeader" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button id="btn_close_myModalLeader" type="button" class="close" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{trans('schedule.meeting_leader')}}</h4>
        </div>
        <div class="modal-body">
			<input class="form-control validation-custom" type="text" id="leader_name" placeHolder="{{trans('schedule.meeting_leader')}}" />
			<input class="form-control validation-custom1" type="email" id="leader_email" placeHolder="{{trans('schedule.email')}}" />
			<input class="form-control validation-custom" type="number" id="leader_order_number" placeHolder="{{trans('news.order')}}" />
        </div>
        <div class="modal-footer">
			<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
			<button style="width: 90px; height: 30px;" type="button" class="jqx-primary pull-right" id="button_input_leader"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
        </div>
      </div>

    </div>
  </div>
<!-- End Modal Leader Meeting -->
<!-- Modal Meeting Type -->
  <div class="modal fade" id="myModalMeetingType" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button id="btn_close_myModalMeetingType" type="button" class="close" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{trans('schedule.meeting_type')}}</h4>
        </div>
        <div class="modal-body">
			<input class="form-control validation-meeting-type" type="text" id="meeting_type_name" placeHolder="{{trans('schedule.meeting_type')}}" />
			<input class="form-control validation-meeting-type" type="number" id="meeting_type_order_number" placeHolder="{{trans('news.order')}}" />
        </div>
        <div class="modal-footer">
			<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
			<button style="width: 90px; height: 30px;" type="button" class="jqx-primary pull-right" id="bnt_meeting_type"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
        </div>
      </div>

    </div>
  </div>
<?php
//foreach($holiday as $key => $val){
//	var_dump($val);die();
// }
?>

<!-- End Modal Meeting Type -->
<script type="text/javascript" src="{{asset('js/tag.js')}}"></script>
<script>

	<?php
		$year = date('Y');
		$month = date('m');
		$month = $month - 1 ;
		$day = date('d');
	?>

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

		initDropDownList(jqxTheme, 803,30, '#div_meeting_location', <?php echo $meetingLocation;?>, 'text', 'value', false, '', '0', "#meeting_location","{{$constant['buttonSearch']}}",250);
		// div_mef_meeting_leader_id
        initDropDownList(jqxTheme, '100%',30, '#div_mef_meeting_leader_id', <?php echo $list_meeting_leader;?>, 'text', 'value', false, '', '0', "#mef_meeting_leader_id","{{$constant['buttonSearch']}}",250);

		// div_mef_office_id
        initDropDownList(jqxTheme, 803,30, '#div_mef_office_id', <?php echo json_encode($list_office);?>, 'text', 'value', false, '', '0', "#mef_office_id","{{$constant['buttonSearch']}}",250);
		var arrOfficerId = new Array();

		var arrOffice = <?php echo json_encode($get_office_officer);?>;
		$.each(arrOffice, function( index, value ) {
			arrOfficerId.push(value.officeId);
		});
		//add checkbox
		$("#div_mef_office_id").jqxDropDownList({
			placeHolder: "",
			checkboxes: true
		});

		//merge office
		$("#div_mef_office_id").bind('select',function(event){
			if($(this).val() != 0){
				arrOfficerId.push($(this).val());
			}else{
				arrOfficerId =[];
			}

			var officeAtendenId = $('input[name=mef_meeting_atendee_join]').val();

			mefMeetingAtendeeJoin(arrOfficerId,officeAtendenId);
		});
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
        mefMeetingAtendeeJoin($("#mef_office_id").val(),'');

        $("#num_of_day").val(1);


		var buttons = ['jqx-save<?php echo $jqxPrefix;?>','button_input_leader','bnt_meeting_type'];
        initialButton(buttons,90,30);
//		alert($("#div_meeting_location").val() == "");
		$('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({

            hintType:'label',
            rules: [
				{input: '#meeting_objective', message: ' ', action: 'blur', rule: 'required'},
//	            {input: '#num_of_day', message: ' ', action: 'blur', rule: 'required'},
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

		// អ្នកខាងក្រៅ
		$('#guest_name').tagit({
			allowSpaces: true,
			removeConfirmation: true
		});
		$("#btn_more_outside").click(function(){
			var sub_more = '<div class="sub_more">' +
				'<div class="col-md-5"><input type="text" class="form-control guest_name" placeholder="ឈ្មោះ"  name="guest_name[]"></div>' +
				'<div class="col-md-5"><input type="email" class="form-control guest_email" placeholder="អ៊ីម៉ែល"  name="guest_email[]"></div>' +
				'<div class="col-md-2"><button type="button" class="btn btn-default btn_remove">-</button></div>' +
			'</div>';
			$("#warp_outside_participant_content").append(sub_more);
		});

		$("div#warp_outside_participant_content").on('click', 'button.btn_remove', function() {
			$(this).parent().parent().remove();
		});

		var status_checked = {{$all == 1 ? 'true' : 'false' }};

		enable_disable_join_all(status_checked);

		// អ្នកចូលរួម
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
//			'</div>';
//			$("#warp_reference_document_content").append(sub_more);
//		});

		$("div#warp_reference_document_content").on('click', 'button.btn_remove', function() {
			$(this).parent().parent().remove();
		});
		// បញ្ចូលឈ្មោះអ្នកដឹកនាំកិច្ចប្រជុំ
		$("#button_input_leader").click(function () {
			var leader_name = $("#leader_name").val();
			var leader_email = $("#leader_email").val();
			var leader_order_number = $("#leader_order_number").val();
			url = '{{asset($constant['secretRoute'].'/meeting-leader/save')}}';
			var validation = validationFormCreateLeader();
			if(validation > 0){
				return false;
			}
			create_leader(leader_name, leader_email,leader_order_number, url);
		});
		// បញ្ចូលប្រភេទកិច្ចប្រជុំ
		$("#bnt_meeting_type").click(function () {
			var meeting_type_name = $("#meeting_type_name").val();
			var meeting_type_order_number = $("#meeting_type_order_number").val();
			url = '{{asset($constant['secretRoute'].'/meeting-type/save')}}';
			var validation = validationFormCreateMeetingType();
			if(validation > 0){
				return false;
			}
			create_meeting_type(meeting_type_name, meeting_type_order_number , url);
		});
    });

	// Function Create Leader
	function create_leader(leader_name, leader_email,leader_order_number, url){
		$.ajax({
			type: 'post',
			url: url ,
			dataType: 'json',
			data:{
				Id : 0,
				Name : leader_name,
				email : leader_email,
				order_number : leader_order_number,
				_token : '{{ csrf_token() }}',
				ajaxRequestJson : 'true'
			},
			success: function (response) {
				if(response.code == 0){
					$('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning",autoClose: false }).html(response.message);
					$("#jqx-notification").jqxNotification("open");
					$("#leader_email").addClass('jqx-validator-error-element');
				}else{
					$('#jqx-notification').jqxNotification({ position: positionNotify,template: "success" }).html(response.message);
					$("#div_mef_meeting_leader_id").jqxDropDownList('insertAt', {"text":response.data.Name,"value":response.data.Id}, 0);
					$("#mef_meeting_leader_id").val(response.data.Id);
					$("#jqx-notification").jqxNotification("open");
					$("#btn_close_myModalLeader").click();
				}
			},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
		});
	}

	function validationFormCreateLeader(){
		var count_error = 0;
		$(".validation-custom").removeClass('jqx-validator-error-element');
		$( ".validation-custom" ).each(function() {
			if($(this).val() == ''){
				$( this ).addClass('jqx-validator-error-element');
				count_error = count_error + 1;
			}else{
				if($(this).attr("type") == 'email'){
					if (!ValidateEmail($( this ).val())) {
						$( this ).addClass('jqx-validator-error-element');
						count_error = count_error + 1;
					}
				}
			}
		});
		return count_error;
	}
	// Function Create Meeting Type
	function create_meeting_type(meeting_type_name, meeting_type_order_number , url){
		$.ajax({
			type: 'post',
			url: url ,
			dataType: 'json',
			data:{
				Id : 0,
				Name : meeting_type_name,
				order_number : meeting_type_order_number,
				_token : '{{ csrf_token() }}',
				ajaxRequestJson : 'true'
			},
			success: function (response) {
				if(response.code == 0){
					$('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning",autoClose: false }).html(response.message);
					$("#jqx-notification").jqxNotification("open");
				}else{
					$('#jqx-notification').jqxNotification({ position: positionNotify,template: "success" }).html(response.message);
					$("#div_mef_meeting_type_id").jqxDropDownList('insertAt', {"text":response.data.Name,"value":response.data.Id}, 0);
					$("#mef_meeting_type_id").val(response.data.Id);
					$("#jqx-notification").jqxNotification("open");
					$("#btn_close_myModalMeetingType").click();
				}
			},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
		});
	}

	function validationFormCreateMeetingType(){
		var count_error = 0;
		$(".validation-meeting-type").removeClass('jqx-validator-error-element');
		$( ".validation-meeting-type" ).each(function() {
			if($(this).val() == ''){
				$( this ).addClass('jqx-validator-error-element');
				count_error = count_error + 1;
			}
		});
		return count_error;
	}

	function mefMeetingAtendeeJoin(officeId,status_clear_select,leaderId){
		var source = {
				type: 'post',
                datatype: 'json',
                url: '<?php echo $getOfficerForJoinByOfficeId; ?>',
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
			width: 803,
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
		$( "#warp_reference_document_content .attachment_name" ).each(function( index ) {
			if($( this ).val() == '' ){
				$( this ).addClass('jqx-validator-error-element');
				count_error = count_error + 1;
			}
		});
		$( "#warp_reference_document_content .attachment_link" ).each(function( index ) {
			if($( this ).val() == '' ){
				$( this ).addClass('jqx-validator-error-element');
				count_error = count_error + 1;
			}
		});
		return count_error;
	}

	/* Save action */
	$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
		count_error = validationFormCustom();
		if(count_error > 0){
			return false;
		}
		saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
		apply_error_form();
	});
	// is_invite_guest
    $("#send_email_checkbox").jqxCheckBox({theme:jqxTheme, width: 120, height: 25});
</script>
<style>
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

	#leader_name, #leader_email{
		margin: 15px 0;
	}
	#myModalLeader .modal-dialog, #myModalMeetingType .modal-dialog{
		margin: 70px auto;
	}
	.form-control.validation-meeting-type{ margin: 15px 0; }
	#btn_more_meeting_type{
		position: absolute;
		right: 15px;
		top: -1px;
		z-index: 9;
	}
</style>