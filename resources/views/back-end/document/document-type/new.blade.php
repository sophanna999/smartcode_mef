<?php
$jqxPrefix = '_documents_type';
$saveUrl = asset($constant['secretRoute'].'/documents-type/save');
?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="id" name="id" value="{{isset($row->id) ? $row->id:0}}">
        <div class="form-group">
            <div class="col-sm-3 text-right" style="padding: 10px;"><span class="red-star">*</span>ប្រភេទឯកសារ</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="ប្រភេទឯកសារ" id="document_type" name="document_type" value="{{isset($row->document_type) ? $row->document_type:''}}">
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
                {input: '#document_type', message: ' ', action: 'blur', rule: 'required'}

            ]
        });
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}',1,function (respone) {
                //display into combo box document-type
                // var id=respone.data.id;
                // var text=respone.data.text;
                // $("#div_document_type").jqxDropDownList('insertAt', text,1);
                // $("#document_type_id").val(id);
            });
        });


    });
</script>