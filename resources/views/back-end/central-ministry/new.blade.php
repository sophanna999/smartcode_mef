<?php
$jqxPrefix = '_central';
$saveUrl = asset($constant['secretRoute'].'/central-ministry/save');
?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data" accept-charset="utf-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
		<input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
        <div class="form-group">
            <div class="col-sm-4 text-right"><span class="red-star">*</span>{{trans('officer.centralMinistry')}}</div>
            <div class="col-sm-8">
				<input type="text" class="form-control" placeholder="{{trans('officer.centralMinistry')}}" id="Name" name="Name" value="{{isset($row->Name) ? $row->Name:''}}">
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-4 text-right">{{$constant['abbreviation']}}</div>
            <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="{{$constant['abbreviation']}}" id="Abbr" name="Abbr" value="{{ isset($row->Abbr) ? $row->Abbr : '' }}">
            </div>
        </div>
		<div class="form-group">
			<div class="col-sm-offset-9 col-sm-3">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
			</div>
		</div>
    </form>
</div>
<script>
    $(document).ready(function(){
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);

        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType: 'label',
            rules: [{
                input: '#Name',
                message: ' ',
                action: 'blur',
                rule: 'required'

            }]
        });
		
		//Save action
		$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
});         
</script>