<?php
$jqxPrefix = '_skill';
$saveUrl = asset($constant['secretRoute'].'/skill/save');

?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
        <div class="form-group">
            <div class="col-sm-3"><span class="red-star">*</span>ជំនាញឯកទេស</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="ជំនាញឯកទេស" id="Name" name="Name" value="{{isset($row->Name) ? $row->Name:''}}">
            </div>
        </div>
        <div class="form-group">
        	<div class="col-sm-3"><span class="red-star">*</span>លេខរៀង</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="Order" name="Order" placeholder="លេខរៀង" value="{{isset($row->Order) ? $row->Order:''}}">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <input type="hidden" id="Type" name="Type" value="{{isset($row->Type) ? $row->Type:0}}">
                <div id="active-checkbox"> កម្រិតរប្បធម៌ទូទៅ</div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-9 col-sm-3">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,35);

        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#Name', message: ' ', action: 'blur', rule: 'required'},
				{input: '#Order', message: ' ', action: 'blur', rule: 'required'}
            ]
        });
		
		var isType = $('#Type').val() == 1 ? true:false;
        $("#active-checkbox").jqxCheckBox({theme:jqxTheme, width: 120, height: 25, checked: isType});
        $('#active-checkbox').on('change', function (event) {
            event.args.checked == true ? $('#Type').val(1):$('#Type').val(0);
        });
		
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
    });
</script>