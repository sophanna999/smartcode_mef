<?php 
$jqxPrefix = '_takeleave_type';
$saveUrl = asset($constant['secretRoute'].'/takeleave-type/save');
$getDepartmentBySecretariat = asset($constant['secretRoute'].'/takeleave-type/get-department-by-secretariat-id');
$url_viwer = asset($constant['secretRoute'].'/attendance-leader/get-attendance-viewer');
?>

<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:10px;"></div>
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
        <div class="form-group">
            <div class="col-sm-6" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('attendance.take_leave_type')}}</label>
				<input type="text" class="form-control" placeholder="{{trans('attendance.take_leave_type')}}" id="Name" name="input[attendance_type]" value="{{isset($row->attendance_type) ? $row->attendance_type:''}}">
            </div>
			<div class="col-sm-6" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('attendance.short_attendance_type')}}</label>
				<input type="text" class="form-control" placeholder="{{trans('attendance.short_attendance_type')}}" id="Name" name="input[short_attendance_type]" value="{{isset($row->short_attendance_type) ? $row->short_attendance_type:''}}">
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-4" style="padding-bottom:15px;">
				<div class="row">
					<label class="col-sm-6"><span class="red-star">*</span> {{trans('officer.department')}}</label>
					<div class="col-sm-12">
						<input type="hidden" id="mef_department_id" name="input[mef_department_id]" value="{{isset($row->mef_department_id) ? $row->mef_department_id:''}}">
                        <div id="div_mef_department_id" name="input[mef_department_id]"></div>
					</div>
				</div>
            </div>
			<div class="col-sm-4" style="padding-bottom:15px;">
				<div class="row">
					<label class="col-sm-6"><span class="red-star">*</span> {{trans('officer.office')}}</label>
					<div class="col-sm-12">
						<input type="hidden" id="mef_office_id" name="input[mef_office_id]" value="{{isset($row->mef_office_id) ? $row->mef_office_id:''}}">
                        <div id="div_mef_office_id" name="input[mef_office_id]"></div>
					</div>
				</div>
            </div>
			<div class="col-sm-4" style="padding-bottom:15px;">
				<div class="row">
					<label class="col-sm-12"><span class="red-star">*</span> {{trans('attendance.day_of_year')}}</label>
					<div class="col-sm-12">
					  <input type="text" id="day_of_year" class="form-control" name="input[day_of_year]" value="{{isset($row->day_of_year) ? $row->day_of_year:''}}">
					</div>
				</div>
            </div>
        </div>
		
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
				<div class="row">
					<label class="col-sm-12"><span class="red-star">*</span> {{$constant['position']}}</label>
					<div class="col-sm-12">
					  <div id='position' name='position'></div>
					</div>
				</div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label>
                    {{$constant['description']}}
                </label>
				<textarea class="form-control" rows="3" placeholder="{{$constant['description']}}" id="description" name="input[description]">{{ isset($row->description) ? $row->description:''}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label>
                    <input type="checkbox" name="input[is_priority]" value="{{isset($row->is_priority) ? $row->is_priority:''}}" {{ isset($row->is_priority) ? $row->is_priority==0?'':'checked':'checked'}} >
                    {{trans('attendance.is_priority')}}
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
</div>

<script>
	
    $(document).ready(function(){
		var width_form = $(window).width()* 0.6;
		var def_type = '<?php echo isset($row->Id)? $row->Id: '';?>';
		var mef_office_id = '<?php echo isset($row->mef_office_id)? $row->mef_office_id: '';?>';
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
		var position = '<?php echo isset($row->position)? $row->position: '';?>';
		var pos_ttype = '<?php echo isset($pos_ttype)? $pos_ttype: '';?>';
		
        initialButton(buttons,90,30);
        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#Name', message: ' ', action: 'blur', rule: 'required'}
                
            ]
        });
		/* Department */
		initDropDownList('bootstrap', 400,35, '#div_mef_department_id', <?php echo $listDepartment;?>, 'text', 'value', false, '', '0', "#mef_department_id","{{$constant['buttonSearch']}}",300);
		$('#div_mef_department_id').bind('select', function () {
			var department_id = $(this).val();
			getOfficeByDepartmentId(department_id);
		});
		/* Office */
		
		initDropDownList('bootstrap', 400,35, '#div_mef_office_id', <?php echo $listOffice;?>, 'text', 'value', false, '', '0', "#mef_office_id","{{$constant['buttonSearch']}}",300);
			// initDropDownList('bootstrap', 400,35, '#div_mef_office_id', <?php echo $listOffice;?>, 'text', 'value', false, '', '0', "#mef_office_id","{{$constant['buttonSearch']}}",300);
		$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
			saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}',function(respone){
				console.log(respone);
			});
		});
		var data =  <?php echo $pos; ?>;
		
		var source =
			{
				datatype: "json",
				datafields: [
					{ name: 'text' },
					{ name: 'value' }
				],
				localdata: data
			};

		var dataAdapter = new $.jqx.dataAdapter(source);

		var thems= {
			source: dataAdapter,
			searchMode: 'contains',
			displayMember: "text",
			valueMember: "value",
			width: width_form, 
			height: '35px',
			multiSelect: true,
		};
		setTimeout(function(){
			$("#position").jqxComboBox(thems);
			if(mef_office_id !=''){
				console.log(mef_office_id);
				$("#div_mef_office_id").jqxComboBox('selectItem', mef_office_id);
			}
			if(pos_ttype!=''){
				$.each(JSON.parse(pos_ttype), function( index, value ) {
				  
				  $("#position").jqxComboBox('selectItem', value.position_id);
				});
			}
		}, 100);
    });
</script>