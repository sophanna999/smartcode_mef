<?php
$jqxPrefix = '_language';
$saveUrl = asset($constant['secretRoute'].'/language/save');

?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
        <div class="form-group">
            <div class="col-sm-3 text-right"><span class="red-star">*</span>សមត្ថភាពភាសា</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="សមត្ថភាពភាសា" id="Name" name="Name" value="{{isset($row->Name) ? $row->Name:''}}">
            </div>
        </div>
        <div class="form-group">
        	<div class="col-sm-3 text-right"><span class="red-star">*</span>លេខរៀង</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="Order" name="Order" placeholder="លេខរៀង" value="{{isset($row->Order) ? $row->Order:''}}">
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
        initialButton(buttons,90,30);

        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#Name', message: ' ', action: 'blur', rule: 'required'},
				{input: '#Order', message: ' ', action: 'blur', rule: 'required'}
            ]
        });
		
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
    });
</script>