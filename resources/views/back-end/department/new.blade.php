<?php
$jqxPrefix = '_department';
$saveUrl = asset($constant['secretRoute'].'/department/save');
$getSecreateByMinistryId = asset($constant['secretRoute'].'/department/get-secretary-by-ministry-id');
?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
		<div class="form-group">
            <div class="col-sm-4 text-right"><span class="red-star">*</span>ក្រសួង/ស្ថាប័ន</div>
            <div class="col-sm-8">
				<input type="hidden" name="mef_ministry_id" id="mef_ministry_id" value="{{isset($row->mef_ministry_id) ? $row->mef_ministry_id:''}}">
                <div id="div_mef_ministry_id"></div>
            </div>
        </div>
		
		<div class="form-group">
            <div class="col-sm-4 text-right"><span class="red-star">*</span>{{trans('officer.generalDepartment')}}</div>
            <div class="col-sm-8">
				<input type="hidden" name="mef_secretariat_id" id="mef_secretariat_id" value="{{isset($row->mef_secretariat_id) ? $row->mef_secretariat_id:''}}">
                <div id="div_mef_secretariat_id"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 text-right"><span class="red-star">*</span>{{trans('officer.department')}}</div>
            <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="{{trans('officer.department')}}" id="Name" name="Name" value="{{isset($row->Name) ? $row->Name:''}}">
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-4 text-right">{{$constant['abbreviation']}}</div>
            <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="{{$constant['abbreviation']}}" id="Abbr" name="Abbr" value="{{isset($row->Abbr) ? $row->Abbr:''}}">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-12 text-right">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
            </div>
        </div>
    </form>
</div>
<script>
	function getSecretaratByMinistryId(object){
		var ministryId = $(object).val();
        $.ajax({
            type: "post",
            url : '{{$getSecreateByMinistryId}}',
            datatype : "json",
            data : {"ministryId":ministryId,"_token":'{{ csrf_token() }}'},
            success : function(data){
               initDropDownList(jqxTheme, 330,30, '#div_mef_secretariat_id', data, 'text', 'value', false, '', '0', "#mef_secretariat_id","{{$constant['buttonSearch']}}",250);
            }
        });
	}
    $(document).ready(function(){
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
		
		
		/* Ministry */
        initDropDownList(jqxTheme, 360,30, '#div_mef_ministry_id', <?php echo $listMinistry;?>, 'text', 'value', false, '', '0', "#mef_ministry_id","{{$constant['buttonSearch']}}",250);
		initDropDownList(jqxTheme, 360,30, '#div_mef_secretariat_id', <?php echo $listSecretariat;?>, 'text', 'value', false, '', '0', "#mef_secretariat_id","{{$constant['buttonSearch']}}",250);
		$('#div_mef_ministry_id').bind('select', function (event) {
            getSecretaratByMinistryId(this);
        });
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
				{input: '#div_mef_secretariat_id', message: ' ', action: 'select',
                    rule: function () {
                        if($("#div_mef_secretariat_id").val() == ""){
                            return false;
                        }
                        return true;
                    }
                }
            ]
        });
		
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
    });
</script>