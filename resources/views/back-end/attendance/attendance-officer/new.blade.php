<?php 
$jqxPrefix = '_attendance_officer';
$saveUrl = asset($constant['secretRoute'].'/attendance-officer/save');
$holidayUrl = asset($constant['secretRoute'].'/attendance-officer/holiday');
$takeLeaveUrl = asset($constant['secretRoute'].'/attendance-officer/take-leav-role');
$takeLeaveRoleUrl = asset($constant['secretRoute'].'/attendance-officer/take-leav-role-by-officer');
$validationAttendance = asset($constant['secretRoute'].'/attendance-officer/validation-attendance');
$chekDateUrl = asset($constant['secretRoute'].'/attendance-officer/check-date');
$deleteFileUrl = asset($constant['secretRoute'].'/attendance-officer/delete-files');
?>

<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:10px;"></div>
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
        <input type="hidden" id="adm" name="adm" value="0">
        <input type="hidden" id="message_adm" name="message_adm" value="">
		
		<div class="form-group">
            <div class="col-sm-6" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('attendance.officer_name')}}</label>
                <input type="hidden" id="officer_ids" value="{{isset($row->officer_id) ? $row->officer_id:''}}" name="officer_id">
				<div id='dev_officer_id'></div>
            </div>
            <div class="col-sm-6" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{$constant['take-leave-type']}}</label>
                <input type="hidden" id="attendance_role_type" value="{{isset($row->take_leave_role_type_id) ? $row->take_leave_role_type_id:''}}" name="attendance_role_type">
                <div id='dev_attendance_role_type'></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6"> 
				<label class="jqx-input-content"><span class="red-star">*</span>{{trans('attendance.from_date')}}</label>
				<div id="div_jqxcalendar_id" name="take_date"></div>
			</div>
			<div class="col-sm-2" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('attendance.number_of_takeleave')}}</label>
                <input type="hidden" id="half_day" value="{{isset($row->sect) ? $row->sect:''}}" name="section">
                <div id='dev_half_day' name="section"></div>
            </div>
			<div class="col-sm-2" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('attendance.number_of_takeleave')}}</label>
                <input id="number" name="num_day" type="number" value="{{isset($row->num_day) ? $row->num_day<1?1:$row->num_day:1}}" class="form-control noly_num">
            </div>
        </div>
        <div class="form-group">
			<div class="col-sm-4"> 
				<label ><span class="red-star">*</span>{{trans('attendance.takeleave_date_comeback')}}</label>
				<input type="text" class="form-control" id="come_back" name="come_back" readonly>
			</div>
		</div>
        <div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label> {{trans('attendance.file_reference')}}</label>
				<input type="file" name="file[]" id="file" class="form-control"  accept="application/pdf">
            </div>
            <div class="col-sm-12">
            	<ul class="list-group">
            	@if(isset($file))
            	@foreach($file as $kf =>$vf)
            		<li class="list-group-item"><img src="{{asset('images/CancelRed.png')}}" class="pointer del-img" style="width: 15px;" data-id="{{ $vf->id}}" title="{{trans('attendance.delete')}}">
            			<a href="{{$downUrl.'/'.$vf->id}}" target="_blank" title="{{trans('attendance.view')}}">{{$vf->original_name}}</a>
            		</li>
            	@endforeach
            	@endif
            	</ul>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span>{{trans('attendance.purpose')}}</label>
				<textarea class="form-control" rows="3" placeholder="{{trans('attendance.purpose')}}" id="description" name="description">{{ isset($row->detail) ? $row->detail:''}}</textarea>
            </div>
        </div>
        <div class="form-group">
        	<div class="col-sm-10 text-right">
        	<label><input type="checkbox" name="status" {{isset($row->status)?$row->status==1?"checked":"":"checked"}}> {{trans('attendance.approve')}}</label>
        	</div>
            <div class="col-sm-2 text-right">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
</div>
<style media="screen">
	.error {
		border: 1px solid #f40606 !important;
	}.no-error{
		border: 1px solid #ccc;
	}
</style>
<script>
	$(function () {
		var today = new Date();
		var date = new Date();
		var arr_data='';
		var $def_date = '{{$current_dt}}';		
		
		$('.del-img').click(function(event){
			var $id= $(this) .attr('data-id');
			var title = '{{$constant['buttonDelete']}}';
			var content = '{{trans('trans.confirm_delete')}}';
			var c_this = this;
            confirmDelete(title,content,function () {
                $.ajax({
					type: 'post',
					url: '{{$deleteFileUrl}}',
					data:{'Id':$id,'_token':'{{ csrf_token() }}','ajaxRequestHtml':'true'},
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
		var $officer_id = "{{isset($row->officer_id) ? $row->officer_id:''}}";
		
		validateFile();
    });
	
    $(document).ready(function(){
		/* init load initCombackDate()*/
		
		/*calendar*/
        $("#div_jqxcalendar_id").jqxDateTimeInput({ width: 400, height: 30,formatString: "yyyy-MM-dd" });
        var start_dt = new Date('{{$start_dt}}');
        var end_dt = new Date('{{$end_dt}}');
        
        $("#div_jqxcalendar_id").jqxDateTimeInput('setRange', start_dt, end_dt);
		$('#div_jqxcalendar_id').on('close', function (event) {
			var take_date= $('#div_jqxcalendar_id').jqxDateTimeInput('getText'); 
			var section= $("#dev_half_day").val();
			var number= $("#number").val();
			var ind = 2;
			$data = {
				"_token":'{{ csrf_token() }}',
				"section":section,
				"take_date":take_date,
				"num_day":number
			}
			
			checkDate($data,function(response){
				if(response.length>0){
					if(section==3){ind=1}
					$('#come_back').val(response[response.length-ind]);
				}
			});
		});
		$('#dev_half_day').on('close', function (event) {
			var take_date= $('#div_jqxcalendar_id').jqxDateTimeInput('getText'); 
			var section= $("#dev_half_day").val();
			var number= $("#number").val();
			var ind = 2;
			$data = {
				"_token":'{{ csrf_token() }}',
				"section":section,
				"take_date":take_date,
				"num_day":number
			}
			checkDate($data,function(response){
				if(response.length>0){
					if(section==3){ind=1}
						console.log(section);
					$('#come_back').val(response[response.length-ind]);
				}
			});
		});

		$( "#number" ).blur(function() {
			var take_date= $('#div_jqxcalendar_id').jqxDateTimeInput('getText'); 
			var section= $("#dev_half_day").val();
			var number= $("#number").val();
			var ind = 2;
			$data = {
				"_token":'{{ csrf_token() }}',
				"section":section,
				"take_date":take_date,
				"num_day":number
			}
			checkDate($data,function(response){
				if(response.length>0){
					if(section==3){ind=1}
					$('#come_back').val(response[response.length-ind]);
				}
			});
		});
		var def_type = '<?php echo isset($row->Id)? $row->Id: '';?>';
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        var $take_type='{{isset($row->attendance_type)?$row->attendance_type:""}}';
        initialButton(buttons,90,30);
        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#dev_officer_id', message: ' ', action: 'select',
                    rule: function () {                       
                        if($("#dev_officer_id").val() == 0 || $("#dev_officer_id").val()==''){
                            return false;
                        }
                        return true;
                    }
                },
                {input: '#dev_attendance_role_type', message: ' ', action: 'select',
                    rule: function () {                       
                        if($("#dev_attendance_role_type").val() == 0 || $("#dev_attendance_role_type").val()==''){
                            return false;
                        }
                        return true;
                    }
                },
                {input: '#description', message: ' ', action: 'select',
                    rule: function () {                       
                        if($("#description").val() == 0 || $("#description").val()==''){
							$("#description").addClass('error');
                            return false;
                        }
                        return true;
                    }
                }
            ]
        });
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
			var btn1='យល់ព្រម';
			var btn2='បោះបង់';
			var title='បញ្ជាក់'
			
			var officerId = $('#officer_ids').val();
			var officerName = $('#dropdownlistContentdev_officer_id').text();
			var value = $('#dev_attendance_role_type').val();
			var	take_id = $('#Id').val();
			
			validationAttendance(officerId,officerName,value);
			
	    	validateFile(function(extension){
	    		if(extension=='pdf' || extension==''){
					if($('#Id').val()>0){
						
						var content = '{{trans('trans.confirm_update')}}';
						confirmMessage(title,content,function () {							
							saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
						});
					}else{
						saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}',1,function(e){
							
							if(e.code==5){	
								var content = '<p>'+e.message+'</p><textarea class="form-control" rows="3" placeholder="{{trans('attendance.reason')}}" id="message" name="message"></textarea>';
								confirmMessage(title,content,function () {
										$('#adm').val(1);	
										$('#message_adm').val($('#message').val());	
										
										saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}'); 
									},function(){
										$('#adm').val(0);	
										$('#message_adm').val('');
									}
								);
							}
							if(e.code==1){	

							}
						}); 
					}
					
	    		}
	    	});    	
        });
		var width_form = 600;
		// div_mef_office_id
        initDropDownList(jqxTheme, 400,35, '#dev_officer_id', <?php echo $list_officer;?>, 'text', 'value', false, '', '0', "#officer_ids","{{$constant['buttonSearch']}}",250);
        $('#dev_officer_id').on('select', function (event)
		{
		    var args = event.args;
		    if (args) {
		    	var item = args.item;
			    var label = item.label;
			    var value = item.value;
				console.log(value);
			    initTakeRole(value,function(response){
					console.log(response);
					initDropDownList(jqxTheme, 400,35, '#dev_attendance_role_type', response, 'text', 'value', false, '', '0', "#attendance_role_type","{{$constant['buttonSearch']}}",250);
				});
			}                        
		});
		
        initDropDownList(jqxTheme, 400,35, '#dev_attendance_role_type', <?php echo $att_role_type;?>, 'text', 'value', false, '', '0', "#attendance_role_type","{{$constant['buttonSearch']}}",250);
        
        initDropDownList(jqxTheme, 100,35, '#dev_half_day', <?php echo $section;?>, 'text', 'value', false, '', '0', "#half_day","{{$constant['buttonSearch']}}",250);
		if(def_type!=''){
	        $("#dev_officer_id").jqxDropDownList({
				disabled: true
			});
		}
		
    	
		$('#dev_attendance_role_type').on('select', function (event)
		{
			var args = event.args;
		    if (args) {
		    	var item = args.item;
			    var label = item.label;
			    var value = item.value;
				var officerId = $('#officer_ids').val();
				var officerName = $('#dropdownlistContentdev_officer_id').text();
				if(value == 30){
					validationAttendance(officerId,officerName,value);
				}
			} 
			
		});
		/**/
		$(".noly_num").keydown(function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				// Allow: Ctrl/cmd+A
				(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
				// Allow: Ctrl/cmd+C
				(e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
				// Allow: Ctrl/cmd+X
				(e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
				// Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					// let it happen, don't do anything
					return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		initCombackDate();
	});
	function initCombackDate(){
		var take_date= $('#div_jqxcalendar_id').jqxDateTimeInput('getText'); 
		var section= $("#dev_half_day").val();
		var number= $("#number").val();
		var ind =2;
		$data = {
			"_token":'{{ csrf_token() }}',
			"section":section,
			"take_date":take_date,
			"num_day":number
		}
		checkDate($data,function(response){
			if(response.length>0){
				if(section==3){ind=1}
					$('#come_back').val(response[response.length-ind]);
			}
		});
	}
	function checkDate($data,callBack){
		$.ajax({
			type: "post",
			url : '{{$chekDateUrl}}',
			datatype : "json",
			data : $data,
			success : function(data){
				console.log(data);
				if(callBack){
					callBack(data);
				}

			}
	    });
	}
	function validationAttendance(officer_id,user_name,take_leave_id) {
		$.ajax({
	        type: "post",
	        url : '{{$validationAttendance}}',
	        datatype : "json",
	        data : {"userId":officer_id,"userName":user_name,"take_leave_id":take_leave_id,"_token":'{{ csrf_token() }}'},
	        success : function(data){
				if(data.msg != ''){
					var title = '';
					var content = data.msg;
					confirmAttendance(title,content,function (){});
				}
	        }
	    });
	}
    function convertTo24Hour(time12h) {
		
		var hours = Number(time12h.match(/^(\d+)/)[1]);
		var minutes = Number(time12h.match(/:(\d+)/)[1]);
		var AMPM = time12h.match(/\s(.*)$/)[1].toLowerCase();

		if (AMPM == "pm" && hours < 12) hours = hours + 12;
		if (AMPM == "am" && hours == 12) hours = hours - 12;
		var sHours = hours.toString();
		var sMinutes = minutes.toString();
		if (hours < 10) sHours = "0" + sHours;
		if (minutes < 10) sMinutes = "0" + sMinutes;
		return hours+':'+sMinutes+':00 ';
	}
	function timeToSeconds(time) {
	    time = time.split(/:/);
	    return time[0] * 3600 + time[1] * 60 + time[2];
	}
    
    function validateFile(callBack){
    	if(callBack){
    		var file = $("input:file").val();
    		var extension = file.substr((file.lastIndexOf('.') +1));
    		if(extension!='pdf' && extension!=''){
	       		$.alert({
				    title: 'សេចក្តីណែនាំ',
				    content: 'ប្រភេទឯកសារមិនត្រូវបានអនុញ្ញាតិឲ្យដាក់បញ្ចូលក្នុងប្រពន្ធ័ សូមប្តូពី '+extension+' ទៅជា PDF',
				});
				return false;
	       	}
       		callBack(extension);
       	}else{
       		$("input:file").change(function (){
		       	var file = $(this).val();
		       	var extension = file.substr((file.lastIndexOf('.') +1));
		       	if(extension!='pdf' && extension!=''){
		       		$.alert({
					    title: 'សេចក្តីណែនាំ',
					    content: 'ប្រភេទឯកសារមិនត្រូវបានអនុញ្ញាតិឲ្យដាក់បញ្ចូលក្នុងប្រពន្ធ័ សូមប្តូរពី '+extension+' ទៅជា PDF',
					});
					return false;
		       	}
		    });
       	}
    	
    }
	function initTakeRole(officer_id,callBack){
    	
    	$.ajax({
	        type: "post",
	        url : '{{$takeLeaveRoleUrl}}',
	        datatype : "json",
	        data : {"userId":officer_id,"_token":'{{ csrf_token() }}'},
	        success : function(data){
	        	
	           	if(callBack){
					callBack(data);
				}

	        }
	    });
	    
    }
</script>