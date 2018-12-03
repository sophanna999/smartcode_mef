<?php
$jqxPrefix = '_province';
$saveUrl = asset($constant['secretRoute'].'/province/save');

?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="Id" name="Id" value="{{isset($row->id) ? $row->id:0}}">
        <div class="form-group">
            <div class="col-sm-3 text-right"><span class="red-star">*</span> ឈ្មោះអក្សរខ្មែរ</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="ឈ្មោះអក្សរខ្មែរ" id="name_kh" name="name_kh" value="{{isset($row->name_kh) ? $row->name_kh:''}}">
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-3 text-right"><span class="red-star">*</span> ឈ្មោះអក្សរឡាតាំង</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="ឈ្មោះអក្សរឡាតាំង" id="name_en" name="name_en" value="{{isset($row->name_en) ? $row->name_en:''}}">
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
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
        
		$('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#name_kh', message: ' ', action: 'blur', rule: 'required'},
				{input: '#name_en', message: ' ', action: 'blur', rule: 'required'}
            ]
        });
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
    });
</script>