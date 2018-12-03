<?php
$jqxPrefix = '_takeleave_type';
$saveUrl = asset($constant['secretRoute'].'/takeleave-approve/save');
$getDepartmentBySecretariat = asset($constant['secretRoute'].'/takeleave-approve/get-department-by-secretariat-id');
$getOfficeByDepartmentUrl = asset($constant['secretRoute'].'/takeleave-approve/get-office-by-department-id');
$url_viwer = asset($constant['secretRoute'].'/attendance-leader/get-attendance-viewer');
?>

<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:10px;"></div>
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
        <div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
				<div class="row">
					<label><span class="red-star">*</span> ចំណងជើង</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" id="title" name="input[title]" value="{{ isset($row->title) ? $row->title:''}}">
					</div>
				</div>
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
				<div class="row">
					<label><span class="red-star">*</span> {{$constant['take-leave-type']}}</label>
					<div class="col-sm-12">
					  <div id='take_leave_role' name='take_leave_role'></div>
					</div>
				</div>
            </div>
        </div>
        <div class="form-group">
			<div class="col-sm-12" style="padding-bottom:15px;">
				<label><span class="red-star">*</span> {{$constant['allow-by']}}</label>
			</div>
			<div id="warp_outside_participant">
				<div id="warp_outside_participant_content">
				  
					@if(isset($take_approved))
						@foreach($take_approved as $key=>$val)
							@if($key == 0)
								<div class="sub_more">
									<div class="col-md-2" style="padding-top: 10px;"><label><span class="red-star">*</span> {{$constant["allow-name"]}}</label></div>
									<div class="col-md-4"><div id="officer_id{{$key}}" name="officer_id[index{{$key}}]"></div></div>
									<div class="col-md-2"><div id="approve_order{{$key}}" name="approve_order[index{{$key}}]"></div></div>
								</div>
							@else
								<div class="sub_more">
									<div class="col-md-2" style="padding-top: 10px;"><label><span class="red-star">*</span> {{$constant["allow-name"]}}</label></div>
									<div class="col-md-4"><div id="officer_id{{$key}}" name="officer_id[index{{$key}}]"></div></div>
									<div class="col-md-2"><div id="approve_order{{$key}}" name="approve_order[index{{$key}}]"></div></div>
									<div class="col-md-2"><button type="button" class="btn btn-default btn_remove">-</button></div>
								</div>
							@endif
						@endforeach
					@else
					<div class="sub_more">
						<div class="col-md-2" style="padding-top: 10px;"><label><span class="red-star">*</span> {{$constant["allow-name"]}}</label></div>
						<div class="col-md-4"><div id="officer_id0" name="officer_id[index0]"></div></div>
						<div class="col-md-2"><div id="approve_order0" name="approve_order[index0]"></div></div>
					 </div>
					@endif
					
				</div>
				<div class="col-md-12">
				  <button type="button" class="btn btn-default" id="btn_more_outside">+</button>
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
            <div class="col-sm-12 text-right">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
</div>
<style media="screen">
  .sub_more{
    padding: 10px 0px;
    display: inline-block;
    width: 100%;
  }
</style>
<script>
	
$(document).ready(function(){
	var def_type = '<?php echo isset($row->Id)? $row->Id: '';?>';
	
	var take_leave_role = '<?php echo isset($take_leave_role)? $take_leave_role: '';?>';
	
	var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
	var take_approved = '<?php echo isset($take_approved)?json_encode($take_approved):'';?>';
	
	
	initialButton(buttons,90,30);
	$('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
		hintType:'label',
		rules: [
			{input: '#title', message: ' ', action: 'blur', rule: 'required'},
			
		]
	});
	$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
		saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
	});
	var width_form = $(window).width()* 0.6;
	var data =  <?php echo $pos; ?>;
    var data_position = <?php echo $approved;?>;
    var data_response = <?php echo $response;?>;
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
    var source_app =
		{
			datatype: "json",
			datafields: [
				{ name: 'text' },
				{ name: 'value' }
			],
			localdata: data_position
		};

	var dataAdapterApp = new $.jqx.dataAdapter(source_app);
    var thems_app= {
			source: dataAdapterApp,
			searchMode: 'contains',
			displayMember: "text",
			valueMember: "value",
			width:'350px',
			height: '35px'
		};
	
	var dataAdapterOrder = new $.jqx.dataAdapter(data_response);
	var thems_order= {
		source: dataAdapterOrder,
		searchMode: 'contains',
		displayMember: "text",
		valueMember: "value",
		width:'180px',
		height: '35px',
		disabled: true,
	};
    setTimeout(function(){
		$("#take_leave_role").jqxComboBox(thems);
		$('.sub_more').each(function(index){
			$("#officer_id"+index).jqxComboBox(thems_app);
			$("#approve_order"+index).jqxComboBox(thems_order);
			$("#approve_order"+index).jqxComboBox('selectItem', 1);
		});console.log(take_leave_role);
		if(take_leave_role!=''){
			// arr_take =take_leave_role.split(',');console.log(arr_take);
			$.each( JSON.parse(take_leave_role), function( k, v ) {				
				
				$("#take_leave_role").jqxComboBox('selectItem', v.take_leave_role_id);
			});
		}
		if(take_approved !=''){
			take_approved = JSON.parse(take_approved);console.log(take_approved);
		}
		if(take_approved !=''){			
			$.each( take_approved, function( key, value ) {				
				$("#officer_id"+key).jqxComboBox('selectItem', value.approver_id);
				$("#approve_order"+key).jqxComboBox('selectItem', value.approver_order);
				$("#approve_order"+key).jqxComboBox('disabled');
			});
		}
    }, 100);
	
	
    // អ្នកខាងក្រៅ
	$("#btn_more_outside").click(function(){
		var sub_lg = $('.sub_more').length;
		var title = 'អ្នកអនុញ្ញាតិទី' +(sub_lg+1);
		var sub_more = '<div class="sub_more">' +
			'<div class="col-md-2" style="padding-top: 10px;"><label><span class="red-star">*</span> {{$constant["allow-name"]}}</label></div>' +
			'<div class="col-md-4"><div id="officer_id'+sub_lg+'" name="officer_id[index'+sub_lg+']"></div></div>' +
			'<div class="col-md-2"><div id="approve_order'+sub_lg+'" name="approve_order[index'+sub_lg+']"></div></div>' +
			'<div class="col-md-2"><button type="button" class="btn btn-default btn_remove">-</button></div>' +
			'</div>';
		$("#warp_outside_participant_content").append(sub_more);
		setTimeout(function(){
			
  			$("#officer_id"+sub_lg).jqxComboBox(thems_app);
			$("#approve_order"+sub_lg).jqxComboBox(thems_order);
			$("#approve_order"+sub_lg).jqxComboBox('selectItem', 1);
			$("#approve_order"+sub_lg).jqxComboBox('disabled');
  		}, 100);

		});

		$("div#warp_outside_participant_content").on('click', 'button.btn_remove', function() {
			$(this).parent().parent().remove();
		});
});

</script>
<style>
.jqx-fill-state-disabled,.jqx-combobox-content-disabled{
	opacity: 1;
	color: #090000;
	background: blanchedalmond;
}
</style>