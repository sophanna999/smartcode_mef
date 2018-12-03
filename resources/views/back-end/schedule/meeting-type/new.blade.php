<?php 
$jqxPrefix = '_meeting_type';
$saveUrl = asset($constant['secretRoute'].'/meeting-type/save');
?>

<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:10px;"></div>
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
        <div class="form-group">
            <div class="col-sm-3 text-right" style="padding-top:5px;">
                <span class="red-star">*</span>{{trans('schedule.meeting_type')}}
            </div>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="{{trans('schedule.meeting_type')}}" id="Name" name="Name" value="{{isset($row->Name) ? $row->Name:''}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-3 text-right" style="top:10px;"><span class="red-star">*</span>{{trans('news.order')}}</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="{{trans('news.order')}}" id="order_number" name="order_number" value="{{isset($row->order_number) ? $row->order_number:''}}">
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
    $(document).ready(function(){
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#Name', message: ' ', action: 'blur', rule: 'required'},
				{input: '#order_number', message: ' ', action: 'blur', rule: 'number'},
				{input: '#order_number', message: ' ', action: 'blur', rule: 'required'}
            ]
        });
        
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
    });
</script>