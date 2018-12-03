<?php 
$jqxPrefix = '_takeleave_user';
$saveUrl = asset($constant['secretRoute'].'/takeleave-user/save');
?>

<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:10px;"></div>
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{$constant['officer-name']}}</label>
				<div id='officer_id' name='officer_id'></div>
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{$constant['take-leave-type']}}</label>
				<div id='take_leave_type_id' name='take_leave_type_id'></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
</div>
<style type="text/css">
    .jqx-combobox-content-disabled{
        color: #000 !important;;
    }
</style>
<script>
	
    $(document).ready(function(){
		var def_off = '<?php echo isset($row->officer_id)? $row->officer_id: '';?>';
		var def_viewer = '<?php echo isset($row->take_leave_type_id)? $row->take_leave_type_id: '';?>';
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
        
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
		var width_form = 600;
		var data =  <?php echo $attendanceViewer; ?>;
		var data1 =  <?php echo $takeLeave; ?>;
		console.log(data);
		console.log(data1);
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
			width: width_form-50, 
			height: '35px',
			multiSelect: false,
		}
		$("#officer_id").jqxComboBox(thems);
		var source1 =
		{
			datatype: "json",
			datafields: [
				{ name: 'text' },
				{ name: 'value' }
			],
			localdata: data1
		};
		
		var dataAdapter1 = new $.jqx.dataAdapter(source1);
		var thems1= { 
			source: dataAdapter1,
			searchMode: 'contains', 
			displayMember: "text", 
			valueMember: "value", 
			width: width_form-50, 
			height: '35px',
			multiSelect: true,
		}
		$("#take_leave_type_id").jqxComboBox(thems1);
		
		if(def_off !=''){
			
			$("#officer_id").jqxComboBox('selectItem', def_off ); 
			$("#officer_id").jqxComboBox({ disabled: true }); 
			var officer_viewer = def_viewer.split(",");
			officer_viewer.forEach(function(element) {
				$("#take_leave_type_id").jqxComboBox('selectItem', element);
				
			});
		}
    });
</script>