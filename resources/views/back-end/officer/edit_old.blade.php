<?php
$jqxPrefix = '_officer';
$saveUrl = asset($constant['secretRoute'].'/officer/save-edit');

?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
        <div class="form-group">
            <div class="col-sm-4 text-right"><span class="red-star">*</span>{{trans('trans.position')}}</div>
            <div class="col-sm-8">
                <input type="hidden" class="form-control" placeholder="{{trans('trans.position')}}" id="CURRENT_POSITION" name="CURRENT_POSITION" value="{{isset($row->positionId) ? $row->positionId :''}}">
                <div id="div_CURRENT_POSITION"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 text-right"><span class="red-star">*</span>{{trans("trans.orderNumber")}}</div>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="ORDER_NUMBER" name="oderNumber" placeholder="{{trans('trans.orderNumber')}}" value="{{isset($row->orderNumber) ? $row->orderNumber:''}}">
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
				{input: '#ORDER_NUMBER', message: ' ', action: 'blur', rule: 'required'},
                {input: '#div_CURRENT_POSITION', message: ' ', action: 'select',
                    rule: function () {
                        if($("#div_CURRENT_POSITION").val() == ""){
                            return false;
                        }
                        return true;
                    }
                }
            ]
        });

        $("#ORDER_NUMBER").on("keypress keyup blur",function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
            $(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        initDropDownList(jqxTheme, 360,34, '#div_CURRENT_POSITION',<?php echo $position; ?>, 'text', 'value', false, '', '0', "#CURRENT_POSITION","",200);
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
    });
</script>