<?php
$jqxPrefix = '_position';
$saveUrl = asset($constant['secretRoute'].'/position/save');
?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="Id" name="Id" value="{{isset($row->ID) ? $row->ID:0}}">
        <div class="form-group">
            <div class="col-sm-3 text-right"><span class="red-star">*</span>{{trans('trans.position')}}</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="{{trans('trans.position')}}" id="NAME" name="NAME" value="{{isset($row->NAME) ? $row->NAME:''}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-3 text-right"><span class="red-star">*</span>គ្រប់គ្រងលើ</div>
            <div class="col-sm-9">
                <div id="div_position" name="position"></div>
            </div>

        </div>
        <div class="form-group">
            <div class="col-sm-3 text-right"><span class="red-star">*</span>លេខរៀង</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="ORDER_NUMBER" name="ORDER_NUMBER" placeholder="លេខរៀង" value="{{isset($row->ORDER_NUMBER) ? $row->ORDER_NUMBER:''}}">
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

    var dropDownWidth = '100%';
    var dropDownL = '100%';

    function initDropDownListCheckbox(div_jqxdropDownListId,width, height, source, selectItem,dropDownHeight,filterPlaceHolder){
        if(source==null || source.length <= 0){
            $(div_jqxdropDownListId).jqxDropDownList({
                selectedIndex: 0,
                source:[],
                width: width,
                height: '35px',
                dropDownHeight:10,
                theme: jqxTheme,
                placeHolder:''
            });
            return false;
        }
        var dataAdapter = new $.jqx.dataAdapter(source, {});
        dataAdapter.dataBind();
        $(div_jqxdropDownListId).jqxDropDownList({
            selectedIndex:0,
            source: dataAdapter,
            displayMember: 'text',
            valueMember: 'value',
            width: width,
            height:height,
            itemHeight:25,
            filterHeight:35,
            dropDownHeight: dropDownHeight,
            theme: jqxTheme,
            filterable: true,
            checkboxes:true,
            searchMode: 'contains',
            placeHolder:'',
            filterPlaceHolder: filterPlaceHolder,
            enableBrowserBoundsDetection:true,
            animationType:'fade'
        });
        if (selectItem.length) {
            $.each(selectItem,function(index,value){
                $(div_jqxdropDownListId).jqxDropDownList('checkItem', value);
            });
        }
    }

    $(document).ready(function(){
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);

        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#NAME', message: ' ', action: 'blur', rule: 'required'},
				{input: '#ORDER_NUMBER', message: ' ', action: 'blur', rule: 'required'}
            ]
        });
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });

        //User Role
        initDropDownListCheckbox('#div_position',dropDownL,35,<?php echo $listPosition;?>,<?php echo $listPositionCheck;?>,550,'{{trans('trans.buttonSearch')}}');
    });
</script>