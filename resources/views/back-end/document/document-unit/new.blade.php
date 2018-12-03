<?php
$jqxPrefix = '_documents_unit';
$saveUrl = asset($constant['secretRoute'].'/documents-unit/save');

?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="id" name="id" value="{{isset($row->id) ? $row->id:0}}">


        <div class="form-group">
            <div class="col-sm-2 text-right" style="padding: 10px;"><span class="red-star">*</span>ឈ្មោះអង្គភាព/ក្រុមហ៊ុន</div>
            <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="ឈ្មោះអង្គភាព/ក្រុមហ៊ុន" id="unit_name" name="unit_name" value="{{isset($row->unit_name) ? $row->unit_name:''}}">
            </div>

            <div class="col-sm-2 text-right" style="padding: 10px;">សារអេឡិកត្រូនិក</div>
            <div class="col-sm-4">
                <input type="email" placeholder="សារអេឡិកត្រូនិក" class="form-control" id="email" name="email" value="{{isset($row->email) ? $row->email:''}}">
            </div>

        </div>

        <div class="form-group">
            <div class="col-sm-2 text-right" style="padding: 10px;"><span class="red-star">*</span>អាស័យដ្ឋាន</div>
            <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="អាស័យដ្ឋាន" id="address" name="address" value="{{isset($row->address) ? $row->address:''}}">
            </div>

            <div class="col-sm-2 text-right" style="padding: 10px;">គេហទំព័រ</div>
            <div class="col-sm-4">
                <input type="text" placeholder="គេហទមព័រ" class="form-control" id="website" name="website" value="{{isset($row->website) ? $row->website:''}}">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2 text-right" style="padding: 10px;">លេខរៀង</div>
            <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="លេខរៀង" id="order_number" name="order_number" value="{{isset($row->order_number) ? $row->order_number:''}}">
            </div>

            <div class="col-sm-2 text-right" style="padding: 10px;">សកម្មភាព</div>
            <div class="col-sm-4" style="padding: 10px;">
                <input type="hidden" id="active" name="active" value="{{isset($row->active) ? $row->active:0}}">
                <div id="active-checkbox"> @lang('news.is_publish')</div>
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

        // active checkbox
        var isActive = $('#acive').val() == 1 ? true : false;
        $("#active-checkbox").jqxCheckBox({theme: jqxTheme, width: 120, height: 25, checked: isActive});
        $('#active-checkbox').on('change', function (event) {
            event.args.checked == true ? $('#active').val(1) : $('#active').val(0);
        });

        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#unit_name', message: ' ', action: 'blur', rule: 'required'},
                {input: '#address', message: ' ', action: 'blur', rule: 'required'}

            ]
        });
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            //alert(1);
            saveJqxItem('<?php echo $jqxPrefix;?>', '{{$saveUrl}}', '{{ csrf_token() }}',1,function (respone) {
                //display combo unit
                // var id=respone.data.id;
                // var text=respone.data.text;
                // $("#div_unit").jqxDropDownList('insertAt', text,1);
                // $("#unit_id").val(id);
            });
        });
    });
</script>