<?php
$jqxPrefix = '_general_department';
$saveUrl = asset($constant['secretRoute'].'/general-department/save');

?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
		<div class="form-group">
            <div class="col-sm-3 text-right"><span class="red-star">*</span>ក្រសួង/ស្ថាប័ន</div>
            <div class="col-sm-9">
				<input type="hidden" name="mef_ministry_id" id="mef_ministry_id" value="{{isset($row->mef_ministry_id) ? $row->mef_ministry_id:''}}">
                <div id="div_mef_ministry_id"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-3 text-right"><span class="red-star">*</span>អគ្គនាយកដ្ឋាន</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="អគ្គនាយកដ្ឋាន" id="Name" name="Name" value="{{isset($row->Name) ? $row->Name:''}}">
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-3 text-right">{{$constant['abbreviation']}}</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="{{$constant['abbreviation']}}" id="Abbr" name="Abbr" value="{{isset($row->Abbr) ? $row->Abbr:''}}">
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
		
		/* Ministry */
        initDropDownList(jqxTheme, 330,30, '#div_mef_ministry_id', <?php echo $listMinistry;?>, 'text', 'value', false, '', '0', "#mef_ministry_id","{{$constant['buttonSearch']}}",250);
        
		$('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#Name', message: ' ', action: 'blur', rule: 'required'},
				{input: '#div_mef_ministry_id', message: ' ', action: 'select',
                    rule: function () {
                        if($("#div_mef_ministry_id").val() == ""){
                            return false;
                        }
                        return true;
                    }
                },
            ]
        });
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
    });
</script>