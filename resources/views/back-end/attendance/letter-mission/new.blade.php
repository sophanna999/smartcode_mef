<?php
$jqxPrefix = '_letter_mission';
$saveUrl = asset($constant['secretRoute'].'/letter-mission/save');
$deleteFileUrl = asset($constant['secretRoute'].'/letter-mission/delete-files');
?>
<div class="container-fluid" style="padding-top:20px;">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
		<div class="form-group">
			<div class="col-sm-2 text-right"><label class="label-margin-top10"><span class="red-star">*</span> {{trans('schedule.meeting_date')}}</label></div>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" placeholder="{{trans('schedule.meeting_date')}}" id="meeting_date" name="meeting_date" value="{{isset($row->date_time) ? $row->date_time:''}}">
				<div id="div_meeting_date"></div>
            </div>
			<div class="col-sm-2">
				<div id="div_meeting_time" name="meeting_time"></div>
			</div>
			<div class="col-sm-1"><label class="label-margin-top10">ដល់</label></div>
			<div class="col-sm-2">
				<div id="div_meeting_End_time" name="meeting_end_time"></div>
			</div>
        </div>		
		<div class="form-group join_all_class">
			<div class="col-sm-2 text-right">
				<div class="label-margin-top10" id="office_meeting_atendee_join"><label>{{trans('schedule.meeting_participant')}}</label></div>
			</div>
			<div class="col-sm-10">
				<div id="div_mef_meeting_atendee_join" name="mef_meeting_atendee_join"></div>
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-2 text-right"><span class="red-star">*</span> <label class="label-margin-top10">{{trans('schedule.meeting_location')}}</label></div>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="{{trans('schedule.meeting_location')}}" id="meeting_location" name="meeting_location" value="{{isset($row->location) ? $row->location:''}}">
	            
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-2 text-right"><span class="red-star">*</span> <label class="label-margin-top10">{{trans('attendance.reason')}}</label></div>
            <div class="col-sm-10" id="warp_meeting_objective">
                <textarea rows="3" placeHolder="{{trans('attendance.reason')}}" class="form-control" id="meeting_objective" name="meeting_objective">{{isset($row->reason) ? $row->reason:''}}</textarea>
            </div>
		</div>
		<div class="form-group">
			<div class="col-sm-2 text-right"><span class="red-star">*</span> <label class="label-margin-top10">{{trans('attendance.file_reference')}}</label></div>
			<div class="col-sm-10">
				<input type="file" name="file[]" id="file" class="form-control"  accept="application/pdf">
            </div>
		</div>
		<div class="form-group">
          	<div class="col-sm-2 text-right"></div>
			<div class="col-sm-10">
				<ul class="list-group">
				@if(isset($mef_letter_file))
				@foreach($mef_letter_file as $k =>$file)
					<li class="list-group-item"><img src="{{asset('images/CancelRed.png')}}" style="width: 15px;" class="pointer del-img" data-id="{{ $file->id}}" title="{{trans('attendance.delete')}}">
						<a href="{{$downUrl.'/'.$file->id}}" target="_blank" title="{{trans('attendance.view')}}">{{$file->file_name}}</a>
					</li>
				@endforeach
				@endif
				</ul>
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
<!-- End Modal Meeting Type -->
<script>
	<?php
		$year = date('Y');
		$month = date('m');
		$month = $month - 1 ;
		$day = date('d');
	?>
    $(document).ready(function(){
		var mef_office_id = '<?php echo isset($row->officer_id)? $row->officer_id: '';?>';
		// meeting_date
		getJqxCalendar('div_meeting_date','meeting_date',200,30,'{{trans('schedule.meeting_date')}}',$('#meeting_date').val());
		// $('#div_meeting_date').jqxDateTimeInput({ min: new Date(<?php echo $year; ?>, <?php echo $month; ?>, <?php echo $day; ?>) });
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
		$('#div_meeting_time ').jqxDateTimeInput('setDate', new Date(<?php echo $year; ?>, <?php echo $month; ?>, <?php echo $day; ?>,<?php echo isset($row->start_time_24) ? str_replace(':',',',$row->start_time_24):'8,00'; ?>));
		$('#div_meeting_End_time ').jqxDateTimeInput('setDate', new Date(<?php echo $year; ?>, <?php echo $month; ?>, <?php echo $day; ?>,<?php echo isset($row->end_time_24) ? str_replace(':',',',$row->end_time_24):'12,00'; ?>));

		var buttons = ['jqx-save<?php echo $jqxPrefix;?>','button_input_leader','bnt_meeting_type'];
        initialButton(buttons,90,30);
//		alert($("#div_meeting_location").val() == "");
		// $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({

            // hintType:'label',
            // rules: [
				// {input: '#mef_meeting_atendee_join', message: ' ', action: 'blur', rule: 'required'},
	            
            // ]
        // });
		var source =
			{
				datatype: "json",
				datafields: [
					{ name: 'text' },
					{ name: 'value' }
				],
				localdata: <?php echo json_encode($list_office);?>
			};

		var dataAdapter = new $.jqx.dataAdapter(source);


		$("#div_mef_meeting_atendee_join").jqxComboBox({
			source: dataAdapter,
			multiSelect: true,
			theme: jqxTheme,
			// width: '100%',
			width: 803,
			height: 35,
			displayMember: "text",
			valueMember : "value",
			placeHolder: " {{trans('schedule.meeting_participant')}}",
			enableBrowserBoundsDetection:true,
			autoComplete:true,
			searchMode:'contains',
			dropDownHeight:450,
			animationType: 'none'
		});
		
		if(mef_office_id !=''){
			setTimeout(function(){
				$.each(mef_office_id.split(','), function( index, value ) {
					$("#div_mef_meeting_atendee_join").jqxComboBox('selectItem', value);
				});
			}, 100);
		}
		
		$('.del-img').on('click',function(e){
			var title = '{{$constant['buttonDelete']}}';
			var content = '{{trans('trans.confirm_delete')}}';
			var c_this = this;
			var curr_id = $(this).attr('data-id');
			confirmDelete(title,content,function () {
				
				$.ajax({
					type: 'post',
					url: '{{$deleteFileUrl}}',
					data:{'Id':curr_id,'_token':'{{ csrf_token() }}','ajaxRequestHtml':'true'},
					success: function (data) {
					$(c_this).parent().remove();
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({ position: positionNotify,template: "success" }).html('{{$constant['deleteRow']}}');
					$("#jqx-notification").jqxNotification("open");
					$("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
					},
					error: function (request, status, error) {
						checkSession();
					}
				});
			});
			});
    });
	
	/* Save action */
	$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
		if($('#Id').val()>0){
			var title = '{{$constant['buttonDelete']}}';
			var content = '{{trans('trans.confirm_update')}}';
			var btn1 = '{{trans('trans.buttonSave')}}';
			var btn2 = '{{trans('trans.buttonCacnel')}}';
			
			confirmMessage(title,content,function () {							
				saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}'); 
			});
		}else{
			saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}',function(e){
				//console.log(e);
			}); 
		}
		
		
	});
	// is_invite_guest
    
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