<?php
$jqxPrefix = '_mission';
$saveUrl = asset($constant['secretRoute'].'/mission/save');
$deleteFileUrl = asset($constant['secretRoute'].'/mission/delete-files');
?>
<div class="container-fluid">
	<form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="ajaxRequestJson" value="true" />
			<input type="hidden" id="Id" name="id" value="{{isset($row->id) ? $row->id:0}}">
	<div id='jqxTabs' style="margin-bottom: 20px;">
	
		<ul style='margin-left: 20px;'>
			<li>{{trans('mission.letter').trans('mission.order').trans('mission.mission')}}</li>
			<li id="id_visa">{{trans('mission.visa')}}</li>
			<li>{{trans('mission.create_mission_direction')}}</li>
		</ul>
		<div style="padding: 20px;">
			<div class="form-group">
				<div class="col-sm-3 text-right">
					<div class="label-margin-top10">
						<label><span class="red-star">*</span> {{trans('mission.mission_type')}}</label>
					</div>
				</div>
				<div class="col-sm-9">
					<input type="hidden" class="form-control" placeholder="{{trans('mission.mission_type')}}" id="mef_mission_type_id" name="mef_mission_type_id" value="{{isset($row->mef_mission_type_id) ? $row->mef_mission_type_id:''}}">
					<div id="dev_mef_mission_type_id" name="mef_mission_type_id"></div>
					<button type="button" id="btn_more_mission_type" class="btn btn-default" data-toggle="modal" data-target="#myModalMissionType">+</button>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 text-right">
					<div class="label-margin-top10">
						<span class="red-star">*</span> <label>{{trans('schedule.meeting_leader')}}</label>
					</div>
				</div>
				<div class="col-sm-9">
					<input type="hidden" class="form-control" placeholder="{{trans('schedule.meeting_leader')}}" id="mef_meeting_leader_id" name="mef_meeting_leader_id" value="{{isset($row->mef_meeting_leader_id) ? $row->mef_meeting_leader_id:''}}">
					<div id="div_mef_meeting_leader_id" name="mef_meeting_leader_id"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 text-right">
					<div class="label-margin-top10" ><label><span class="red-star">*</span> {{trans('mission.mef_mission_to_officer')}}</label></div>
				</div>
				<div class="col-sm-9">
					<div id="div_mef_mission_to_officer" name="mef_mission_to_officer"></div>
					
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 text-right" style="padding-top: 9px;"><span class="red-star">*</span> {{trans('mission.mission_from_date')}}</div>
				<div class="col-sm-3">
					<input type="hidden" class="form-control" placeholder="{{trans('mission.mission_from_date')}}" id="mission_from_date" name="mission_from_date" value="{{isset($row->mission_from_date) ? $row->mission_from_date:''}}">
					<div id="div_mission_from_date"></div>
				</div>
				<div class="col-sm-3 text-right" style="padding-top: 9px;width: 162px;"><span class="red-star">*</span> {{trans('mission.mission_to_date')}}</div>
				<div class="col-sm-2">
					<input type="hidden" class="form-control" placeholder="{{trans('mission.mission_to_date')}}" id="mission_to_date" name="mission_to_date" value="{{isset($row->mission_to_date) ? $row->mission_to_date:''}}">
					<div id="div_mission_to_date"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 text-right"><span class="red-star">*</span> <label class="label-margin-top10">{{trans('mission.depart').trans('mission.from')}}</label></div>
				<div class="col-sm-9">
					<input type="hidden" class="form-control" placeholder="{{trans('mission.depart')}}" id="mission_location" name="mission_location_id" value="{{isset($row->mission_location_id) ? $row->mission_location_id:''}}">
					<div id="dev_mission_location" name="mission_location_id"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 text-right"><label class="label-margin-top10"><span class="red-star">*</span> {{trans('mission.mission_transportation')}}</label></div>
				<div class="col-sm-9">
					<input type="hidden" class="form-control" placeholder="{{trans('mission.mission_transportation')}}" id="mission_transportation" name="mission_transportation_id" value="{{isset($row->mission_transportation_id) ? $row->mission_transportation_id:''}}">
					<div id="dev_mission_transportation" name="mission_transportation_id"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 text-right"><label class="label-margin-top10"><span class="red-star">*</span> {{trans('mission.mission_task')}}</label></div>
				<div class="col-sm-9" id="warp_mission_objective">
					<textarea rows="3" placeHolder="{{trans('mission.mission_task')}}" class="form-control required-custom" id="mission_objective" name="mission_objective">{{isset($row->mission_objective) ? $row->mission_objective:''}}</textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 text-right"><label class="label-margin-top10"><span class="red-star">*</span> {{trans('mission.tag')}}</label></div>
				<div class="col-sm-9">
					<ul id="tags">
						@if($miss && $miss->missionTags())
							@foreach($miss->missionTags()->get() as $kt =>$vt)
								<li>{{$vt->tags}}</li>
							@endforeach
						@endif
					</ul>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 text-right"><label> {{trans('attendance.file_reference')}}</label></div>
				<div class="col-sm-9">
					<input type="file" name="file[]" id="file" class="form-control {{isset($mef_mission_attachment)?'':'required-custom'}}"​  accept="application/pdf" multiple>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 text-right"></div>
				<div class="col-sm-9">
					<ul class="list-group">
					@if(isset($mef_mission_attachment))
					@foreach($mef_mission_attachment as $kf =>$vf)
						<li class="list-group-item"><img src="{{asset('images/CancelRed.png')}}" style="width: 15px;" class="pointer del-img" data-id="{{ $vf->id}}" title="{{trans('attendance.delete')}}">
							<a href="{{$downUrl.'/'.$vf->id}}" target="_blank" title="{{trans('attendance.view')}}">{{$vf->file_rename}}</a>
						</li>
					@endforeach
					@endif
					</ul>
				</div>
			</div>
		</div>
		<div style="padding: 20px;">
			<div class="form-group">
				<div class="col-sm-3 text-right">
					<div class="label-margin-top10">
						<label><span class="red-star">*</span> {{trans('mission.reference').trans('mission.letter').trans('mission.mission').trans('mission.number')}}</label>
					</div>
				</div>
				<div class="col-sm-3">
					<input
						type="text"
						class="form-control"
						name="reference_no"
						value="{{isset($row->reference_no)?$row->reference_no:''}}"
						placeholder="{{trans('mission.reference').trans('mission.letter').trans('mission.mission').trans('mission.number')}}"
						id="reference_no">
				</div>
				<div class="col-sm-1 text-right">
					<div class="label-margin-top10">
						<label><span class="red-star">*</span> {{trans('mission.add_number').trans('general.day')}}</label>
					</div>
				</div>
				<div class="col-sm-3">
					<input type="hidden" class="form-control" id="reference_date" name="reference_date" value="{{isset($row->reference_date) ? $row->reference_date:''}}">
					<div id="div_reference_date" name="reference_date"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 text-right">
					<div class="label-margin-top10">
						<label><span class="red-star">*</span> {{trans('mission.approve_by')}}</label>
					</div>
				</div>
				<div class="col-sm-9">
					<input
						type="text"
						class="form-control"
						name="approve_by"
						value="{{isset($row->approve_by)?$row->approve_by:''}}"
						placeholder="{{trans('mission.approve_by')}}"
						id="approve_by">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 text-right">
					<div class="label-margin-top10">
						<label><span class="red-star">*</span> {{trans('mission.add_number').trans('mission.signature').trans('mission.by')}}</label>
					</div>
				</div>
				<div class="col-sm-3">
					<input
						type="text"
						class="form-control"
						name="signature_by"
						value="{{isset($row->signature_by)?$row->signature_by:''}}"
						placeholder="{{trans('mission.add_number').trans('mission.signature').trans('mission.by')}}"
						id="signature_by">
				</div>
				<div class="col-sm-2 text-right">
					<div class="label-margin-top10">
						<label><span class="red-star">*</span> {{trans('mission.postion')}}</label>
					</div>
				</div>
				<div class="col-sm-4">
					<input
						type="text"
						class="form-control"
						name="signature_position"
						value="{{isset($row->signature_position)?$row->signature_position:''}}"
						placeholder="{{trans('mission.postion')}}"
						id="signature_position">
				</div>
			</div>
		</div>
		<div style="padding: 20px;">
			@include('back-end.mission.mission.location')  
		</div>	

	</div>
		<div class="form-group">
			<div class="col-sm-12 text-right">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
			</div>
		</div>
    </form>
</div>
<!-- Modal Mission Type -->
  <div class="modal fade" id="myModalMissionType" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button id="btn_close_myModalMissionType" type="button" class="close" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{trans('mission.mission_type')}}</h4>
        </div>
        <div class="modal-body">
			<input class="form-control validation-mission-type" type="text" id="mission_type_name" placeHolder="{{trans('mission.mission_type')}}" />
			<input class="form-control validation-mission-type" type="number" id="mission_type_order_number" placeHolder="{{trans('news.order')}}" />
        </div>
        <div class="modal-footer">
			<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
			<button style="width: 90px; height: 30px;" type="button" class="jqx-primary pull-right" id="bnt_mission_type"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
        </div>
      </div>

    </div>
  </div>
<!-- End Modal Mission Type -->
<script>
	<?php
		$year = date('Y');
		$month = date('m');
		$month = $month - 1 ;
		$day = date('d');
	?>
    $(document).ready(function(){
        //Button action
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>','bnt_mission_type'];
        initialButton(buttons,105,30);

		$('#jqxTabs').jqxTabs({ 
            width: '100%',
            theme: jqxTheme,
            animationType: 'fade',
            selectedItem:0,
            selectionTracker:true,
            enableScrollAnimation:true,
            keyboardNavigation:true,
            scrollable: true
        });
  		$('#tags').tagit({
            allowSpaces: true,
            removeConfirmation: true
        });
        initDropDownList(jqxTheme, 500,30, '#dev_mission_transportation', <?php echo $list_tran;?>, 'text', 'value', false, '', '0', "#mission_transportation","{{$constant['buttonSearch']}}",250);
        initDropDownList(jqxTheme, 500,30, '#dev_mission_location', <?php echo $list_mission_location;?>, 'text', 'value', false, '', '0', "#mission_location","{{$constant['buttonSearch']}}",250);
		// dev_mef_mission_type_id
        initDropDownList(jqxTheme, 500,30, '#dev_mef_mission_type_id', <?php echo $list_mission_type;?>, 'text', 'value', false, '', '0', "#mef_mission_type_id","{{$constant['buttonSearch']}}",250);
        /* div_reference_date */
        getJqxCalendar('div_reference_date','reference_date',200,30,'{{trans('mission.mission_from_date')}}',$('#reference_date').val(),"yyyy-MM-dd");
		// div_mission_from_date
		getJqxCalendar('div_mission_from_date','mission_from_date',200,30,'{{trans('mission.mission_from_date')}}',$('#mission_from_date').val(),"yyyy-MM-dd");
		// $('#div_mission_from_date').jqxDateTimeInput({ min: new Date(<?php echo $year; ?>, <?php echo $month; ?>, <?php echo $day; ?>) });
		// div_mission_to_date
		getJqxCalendar('div_mission_to_date','mission_to_date',200,30,'{{trans('mission.mission_to_date')}}',$('#mission_to_date').val(),"yyyy-MM-dd");
		// $('#div_mission_to_date').jqxDateTimeInput({ min: new Date(<?php echo $year; ?>, <?php echo $month; ?>, <?php echo $day; ?>) });
		// validate div_mission_to_date
		var div_mission_from_date = $('#mission_from_date').val();
		var mission_from_date =  div_mission_from_date.split("/");
		// $('#div_mission_to_date').jqxDateTimeInput('min',new Date(mission_from_date[2], (mission_from_date[1] - 1), mission_from_date[0]));
		$('#div_mission_from_date').on('change',function(){
			var div_mission_from_date = $('#div_mission_from_date').val();
			if(div_mission_from_date != null){
				if(div_mission_from_date == ""){
					$('#div_mission_to_date' + key).jqxDateTimeInput({ disabled: true });
					var mission_from_date =  div_mission_from_date.split("/");
					// $('#div_mission_to_date').jqxDateTimeInput('min',new Date(parseInt(START_WORKING_DATE[0]), START_WORKING_DATE[1], 1));
				} else {
					var mission_from_date =  div_mission_from_date.split("/");
					// $('#div_mission_to_date').jqxDateTimeInput('min',new Date((mission_from_date[2]), (mission_from_date[1] - 1), mission_from_date[0]));
				}
			}
		});

		$("div#warp_outside_participant_content").on('click', 'button.btn_remove', function() {
			$(this).parent().parent().remove();
		});

		// Create a jqxComboBox mef_mission_to_officer
        mefMissionToOfficer();
		// កំណត់បេសកកម្ម
		$("#bnt_mission_type").click(function () {
			var mission_type_name = $("#mission_type_name").val();
			var mission_type_order_number = $("#mission_type_order_number").val();
			url = '{{asset($constant['secretRoute'].'/mission-type/save')}}';
			var validation = validationFormCreateMissionType();
			if(validation > 0){
				return false;
			}
			create_mission_type(mission_type_name, mission_type_order_number , url);
		});
		$('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({

            hintType:'label',
            rules: [
				{input: '#div_mef_meeting_leader_id', message: ' ', action: 'select',
                    rule: function () {                       
                        if($("#div_mef_meeting_leader_id").val() == 0 || $("#div_mef_meeting_leader_id").val()==''){
                            return false;
                        }
                        return true;
                    }
				}
				,{input: '#dev_mef_mission_type_id', message: ' ', action: 'select',
                    rule: function () {                       
                        if($("#dev_mef_mission_type_id").val() == 0 || $("#dev_mef_mission_type_id").val()==''){
                            return false;
                        }
                        return true;
                    }
				}
				,{input: '#div_mef_mission_to_officer', message: ' ', action: 'select',
                    rule: function () {                       
                        if($("#div_mef_mission_to_officer").val() == 0 || $("#div_mef_mission_to_officer").val()==''){
                            return false;
                        }
                        return true;
                    }
				}
				,{input: '#dev_mission_location', message: ' ', action: 'select',
                    rule: function () {                       
                        if($("#dev_mission_location").val() == 0 || $("#dev_mission_location").val()==''){
                            return false;
                        }
                        return true;
                    }
				}
				,{input: '#dev_mission_transportation', message: ' ', action: 'select',
                    rule: function () {                       
                        if($("#dev_mission_transportation").val() == 0 || $("#dev_mission_transportation").val()==''){
                            return false;
                        }
                        return true;
                    }
				}
				,{input: '#mission_objective', message: ' ', action: 'blur',
                    rule: function () {                       
                        if($("#mission_objective").val() == 0 || $("#mission_objective").val()==''){
							$("#description").addClass('error');
                            return false;
                        }
                        return true;
                    }
                }
       //          ,{input: '#reference_no', message: ' ', action: 'blur',
       //              rule: function () {                       
       //                  if($("#reference_no").val() == 0 || $("#reference_no").val()==''){
							// return false;
       //                  }
       //                  return true;
       //              }
       //          }
       //          ,{input: '#approve_by', message: ' ', action: 'blur',
       //              rule: function () {                       
       //                  if($("#approve_by").val() == 0 || $("#approve_by").val()==''){
							// return false;
       //                  }
       //                  return true;
       //              }
       //          }
            ]
		});
		
		/* Save action */
		$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
			count_error = validationFormCustom();
			if(count_error > 0){
				return false;
			}
			saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
			
		});
    });
	// Function Create Mission Type
	function create_mission_type(mission_type_name, mission_type_order_number , url){
		$.ajax({
			type: 'post',
			url: url ,
			dataType: 'json',
			data:{
				id : 0,
				name : mission_type_name,
				order_number : mission_type_order_number,
				_token : '{{ csrf_token() }}',
				ajaxRequestJson : 'true'
			},
			success: function (response) {
				if(response.code == 0){
					$('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning",autoClose: false }).html(response.message);
					$("#jqx-notification").jqxNotification("open");
				}else{
					$('#jqx-notification').jqxNotification({ position: positionNotify,template: "success" }).html(response.message);
					$("#dev_mef_mission_type_id").jqxDropDownList('insertAt', {"text":response.data.name,"value":response.data.id}, 0);
					$("#mef_mission_type_id").val(response.data.id);
					$("#jqx-notification").jqxNotification("open");
					$("#btn_close_myModalMissionType").click();
				}
			},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
		});
	}
	// Function Validation Mission Type
	function validationFormCreateMissionType(){
		var count_error = 0;
		$(".validation-mission-type").removeClass('jqx-validator-error-element');
		$( ".validation-mission-type" ).each(function() {
			if($(this).val() == ''){
				$( this ).addClass('jqx-validator-error-element');
				count_error = count_error + 1;
			}
		});
		return count_error;
	}
	// mef_mission_to_officer
	function mefMissionToOfficer(){		
		var source = <?php echo $mef_officer_department; ?>;
        var dataAdapter = new $.jqx.dataAdapter(source,{});
		
		/* init mission leader*/
		
		$("#div_mef_meeting_leader_id").jqxComboBox({
			source: dataAdapter,
			multiSelect: true,
			theme: jqxTheme,
			width: 546,
			height: 35,
			displayMember: "displayMember",
			valueMember : "valueMember",
			placeHolder: " {{trans('schedule.meeting_leader')}}",
			enableBrowserBoundsDetection:true,
			autoComplete:true,
			searchMode:'contains',
			dropDownHeight:450,
			animationType: 'none'
		});
		$('#div_mef_meeting_leader_id input').on('focus', function (event) {
			$("#div_mef_meeting_leader_id").jqxComboBox('open');
		});
		$('#div_mef_meeting_leader_id').on('select', function (event)
		{
			var args = event.args;
		    if (args) {
		    	var item = args.item;
			    var label = item.label;
			    var value = item.value;
				$("#div_mef_mission_to_officer").jqxComboBox('disableItem',value);
			} 
			
		});
		$('#div_mef_meeting_leader_id').on('unselect', function (event)
		{
			var args = event.args;
		    if (args) {
		    	var item = args.item;
			    var label = item.label;
			    var value = item.value;
				$("#div_mef_mission_to_officer").jqxComboBox('enableItem',value);
			} 			
		});
		/* init officer join mission*/
		$("#div_mef_mission_to_officer").jqxComboBox({
			source: dataAdapter,
			multiSelect: true,
			theme: jqxTheme,
			width: 546,
			height: 35,
			displayMember: "displayMember",
			valueMember : "valueMember",
			placeHolder: " {{trans('mission.mef_mission_to_officer')}}",
			enableBrowserBoundsDetection:true,
			autoComplete:true,
			searchMode:'contains',
			dropDownHeight:450,
			animationType: 'none'
		});

		/* jqxComboBox on focus action */
		$('#div_mef_mission_to_officer input').on('focus', function (event) {
			$("#div_mef_mission_to_officer").jqxComboBox('open');
		});
		$('#div_mef_mission_to_officer').on('select', function (event)
		{
			var args = event.args;
		    if (args) {
		    	var item = args.item;
			    var label = item.label;
			    var value = item.value;
				$("#div_mef_meeting_leader_id").jqxComboBox('disableItem',value);
			} 
			
		});
		$('#div_mef_mission_to_officer').on('unselect', function (event)
		{
			var args = event.args;
		    if (args) {
		    	var item = args.item;
			    var label = item.label;
			    var value = item.value;
				$("#div_mef_meeting_leader_id").jqxComboBox('enableItem',value);
			} 			
		});
		getSelectedItems();
	}
	function getSelectedItems(){
		var str_join = '{{$mef_mission_join}}';
		if(str_join != ''){
			var res_join = str_join.split(',');
			$.each(res_join, function( index, value ) {
				$("#div_mef_mission_to_officer").jqxComboBox('selectItem', value);
			});
		}
		var lead = '<?php echo $lead;?>';
		if(lead !=''){
			$.each(JSON.parse(lead), function( index, value ) {
				$("#div_mef_meeting_leader_id").jqxComboBox('selectItem', value.Id);
			});
		}
		
	}
	
	// Validation Data Field Custom
	function validationFormCustom(){
		$(".jqx-widget").removeClass('jqx-validator-error-element');
		$(".form-control").removeClass('jqx-validator-error-element');
		var count_error = 0;
		$( ".required-custom" ).each(function( index ) {
			if($( this ).val() == ''){
				count_error = count_error + 1;
				this_id = $(this).attr('id');
				$('#dev_' + this_id).addClass('jqx-validator-error-element');
				$('#' + this_id).addClass('jqx-validator-error-element');
			}
		});
		return count_error;
	}
	// is_invite_guest
    
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
	.form-control.validation-mission-type{ margin: 15px 0; }
	#myModalMissionType .modal-dialog{ margin: 170px auto; }
	#btn_more_mission_type{
		position: absolute;
		top: 0;
		right: 28px;
		z-index: 9;
	}
	#div_mission_from_date > div { z-index: 9; }
</style>
