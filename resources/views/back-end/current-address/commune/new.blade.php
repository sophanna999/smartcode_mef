<?php
$jqxPrefix = '_commune';
$saveUrl = asset($constant['secretRoute'].'/commune/save');
$getDistrictByProId = asset($constant['secretRoute'].'/commune/get-district-by-pro-id');
?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="Id" name="Id" value="{{isset($row->id) ? $row->id:0}}">
		<div class="form-group">
            <div class="col-sm-3 text-right"><span class="red-star">*</span> {{trans('trans.province')}}</div>
            <div class="col-sm-9">
				<input type="hidden" name="mef_province_id" id="mef_province_id" value="{{isset($row->mef_province_id) ? $row->mef_province_id:''}}">
                <div id="div_mef_province_id"></div>
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-3 text-right"><span class="red-star">*</span> {{trans('trans.district')}}</div>
            <div class="col-sm-9">
				<input type="hidden" name="mef_district_id" id="mef_district_id" value="{{isset($row->mef_district_id) ? $row->mef_district_id:''}}">
                <div id="div_mef_district_id"></div>
            </div>
        </div>
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
	function getDistrictByProId(object){
		var mef_province_id = $(object).val();
        $.ajax({
            type: "post",
            url : '{{$getDistrictByProId}}',
            datatype : "json",
            data : {"mef_province_id":mef_province_id,"_token":'{{ csrf_token() }}'},
            success : function(data){
               initDropDownList(jqxTheme, 485,30, '#div_mef_district_id', data, 'text', 'value', false, '', '0', "#mef_district_id","{{$constant['buttonSearch']}}",250);
            }
        });
	}
    $(document).ready(function(){
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
        /* Province */
        initDropDownList(jqxTheme, 485,30, '#div_mef_province_id', <?php echo json_encode($listProvince); ?>, 'text', 'value', false, '', '0', "#mef_province_id","{{$constant['buttonSearch']}}",250);
		$('#div_mef_province_id').bind('select', function (event) {
            getDistrictByProId(this);
        });
		/* Districts */
        initDropDownList(jqxTheme, 485,30, '#div_mef_district_id', <?php echo json_encode($listDistricts); ?>, 'text', 'value', false, '', '0', "#mef_district_id","{{$constant['buttonSearch']}}",250);
		$('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#name_kh', message: ' ', action: 'blur', rule: 'required'},
				{input: '#name_en', message: ' ', action: 'blur', rule: 'required'},
				{input: '#div_mef_province_id', message: ' ', action: 'select',
                    rule: function () {
                        if($("#div_mef_province_id").val() == ""){
                            return false;
                        }
                        return true;
                    }
                },
				{input: '#div_mef_district_id', message: ' ', action: 'select',
                    rule: function () {
                        if($("#div_mef_district_id").val() == ""){
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