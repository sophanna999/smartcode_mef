<?php
$jqxPrefix = '_documents';
$saveUrl = asset($constant['secretRoute'].'/documents/save');
$SecretariatFilterUrl = asset($constant['secretRoute'].'/documents/get-secretariat-filter');
$DepartmentFilterUrl = asset($constant['secretRoute'].'/documents/get-department-filter');
$OfficeFilterUrl    = asset($constant['secretRoute'].'/documents/get-office-filter');
$delete = asset($constant['secretRoute'].'/documents/delete-processing-doc');
$id = 0;
?>
<style>
    table
    {
        font-family: 'KHMERMEF1';
    }
    .contain-color {
        background-color: #f1f1f1;
        padding: 2.01em 16px;
        margin: 20px 0;

        box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;
    }

    *, *:before, *:after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    section {
        display: none;
        padding: 20px 0 0;
        border-top: 1px solid #ddd;
    }

    input {
        display: none;
    }

    label {
        display: inline-block;
        margin: 0 0 -1px;
        padding: 15px 25px;
        font-weight: 600;
        text-align: center;
        color: #bbb;
        border: 1px solid transparent;
    }

    label:before {
        font-family: fontawesome;
        font-weight: normal;
        margin-right: 10px;
    }

    label:hover {
        color: #888;
        cursor: pointer;
    }

    input:checked + label {
        color: #555;
        border: 1px solid #ddd;
        border-top: 2px solid darkcyan;
        border-bottom: 1px solid #fff;
    }
    #tab1:checked ~ #content1,
    #tab2:checked ~ #content2
    {
        display: block;
    }

    #dropdownlistArrowdiv_unit{
        width: 4% !important;
    }
    #dropdownlistContentdiv_unit{
        width: 96% !important;
    }

    #jqxgrid
    {
        z-index: 0;
    }

</style>

<div class="container-fluid">
    <div id="file-uploader" style="margin-top: 10px;">
        <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="ajaxRequestJson" value="true" />
            <input type="hidden" id="id" name="id" value="{{isset($row->id) ? $row->id:0}}">
             <div class="contain-color">
                <h3 style="margin-top: -20px; border-bottom: 1px solid #e0e0e0; margin-bottom: 20px; color: #0a73a7; font-family: 'KHMERMEF2'">ដំណើរការឯកសារ</h3>
                <input id="tab1" type="radio" name="tabs" checked>
                <label for="tab1"><i class="fa fa-home fa-3x"></i> ស្ថាប័នរដ្ឋ</label>
                <input id="tab2" type="radio" name="tabs">
                <label for="tab2"><i class="fa fa-bank fa-2x"></i> ស្ថាប័នឯកជន</label>
                <section id="content1">
                    <div class="table-responsive">
                        <table class="table table-striped table-condensed table-hover" style="width: 100%">
                            <thead>
                            <tr>
                                <th>ល.រ</th>
                                <th>ក្រសួង/ស្ថាប័​ន</th>
                                <th style="width: 25%;">អគ្គលេខាធិការដ្ឋាន / អគ្គនាយកដ្ឋាន</th>
                                <th>នាយកដ្ឋាន</th>
                                <th>ការិយាល័យ</th>
                                <th>មន្ត្រី</th>
                                <th colspan="2">សកម្មភាព</th>
                            </tr>
                            </thead>
                            <tbody id="TProcessingDoc">
                            <?php
                            $processingDoc = isset($sibling)?$processingDoc: array('');
                            ?>
                            @foreach($processingDoc as $key=>$val)
                                <?php
                                $No = $key +1;
                                ?>
                            <tr id="processingDocTr_{{$key}}">
                                <td style="text-align:center; padding:15px; font-weight: bold">
                                    {{$No}}
                                </td>
                                <td>
                                    <input type="hidden" id="sib_id_{{$key}}" value="{{isset($val->id) ? $val->id:''}}">
                                    <input type="hidden" class="form-control" id="ministry_id_{{isset($key)? $key: 0}}" name="processingDoc[{{$key}}][ministry_id]" value="{{isset($val->ministry_id) ? $val->ministry_id:''}}">
                                    <div id="div_listMinistryFilter_{{isset($key)? $key: 0}}"></div>
                                </td>

                                <td>
                                    <input type="hidden" class="form-control" id="secretariat_id_{{isset($key)? $key: 0}}" name="processingDoc[{{$key}}][secretariat_id]" value="{{isset($val->secretariat_id) ? $val->secretariat_id:''}}">
                                    <div id="div_listSecretariatFilter_{{isset($key)? $key: 0}}"></div>
                                </td>

                                <td>
                                    <input type="hidden" class="form-control" id="department_id_{{isset($key)? $key: 0}}" name="processingDoc[{{$key}}][department_id]" value="{{isset($val->department_id) ? $val->department_id:''}}">
                                    <div id="div_listDepartmentFilter_{{isset($key)? $key: 0}}"></div>
                                </td>

                                <td>
                                    <input type="hidden" class="form-control" id="office_id_{{isset($key)? $key: 0}}" name="processingDoc[{{$key}}][office_id]" value="{{isset($val->office_id) ? $val->office_id:''}}">
                                    <div id="div_listOfficeFilter_{{isset($key)? $key: 0}}"></div>
                                </td>

                                <td style="width: 20%;">
                                    <input type="hidden" class="form-control" id="officer_id_{{isset($key)? $key: 0}}" name="processingDoc[{{$key}}][officer_id]" value="{{isset($row->officer_id) ? $row->officer_id:''}}">
                                    <div id="div_officer_{{isset($key)? $key: 0}}"></div>
                                </td>

                                {{--button add--}}
                                <?php
                                if($id ==''){
                                ?>
                                    <td style="width: 10%;">
                                        <button id="addSave" class="btn btn-primary" type="button" style="float: left !important;"><i class="glyphicon glyphicon-edit"></i> </button>
                                    </td>
                                    <td style="width: 10%;">
                                        <button id="addbutton" class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i></button>
                                    </td>
                                <?php
                                }
                                ?>

                                <?php
                                    if($id >0){
                                    if($key >0){
                                ?>
                                    <td style="width: 10%;">
                                        <button id="addSave_{{$key}}" class="btn btn-primary pull-left" type="button" onclick="saveProcessingDoc({{$key}})"><i class="glyphicon glyphicon-edit"></i> </button>

                                    </td>
                                    <td style="width: 10%;">
                                        <button  id="minus-button_{{$key}}" type="button" class="btn btn-primary jqx-primary" onclick="removeProcessingDoc({{$key}})" ><i class="fa fa-minus"></i></button>
                                    </td>
                                <?Php
                                    }elseif($key== 0){
                                ?>
                                     <td style="width: 10%;">
                                         <button id="addSave" class="btn btn-primary pull-left" type="button"><i class="glyphicon glyphicon-edit"></i> </button>

                                     </td>
                                     <td style="width: 10%;">
                                         <button  id="addbutton" type="button" class="btn btn-danger jqx-danger"><i class="fa fa-plus"></i></button>
                                     </td>
                                <?php
                                 }
                                }
                                ?>
                                <!-- end button add-->

                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </section>

                <section id="content2">
                    2
                </section>

                <div class="form-group">
                    <div class="col-sm-offset-10 col-sm-2">
                        <button class="btn btn-primary" id="jqx-save<?php echo $jqxPrefix;?>"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
                    </div>
                </div>

            </div>


        </form>
    </div>
</div>

<script>
    function getSecretariatFilter(ministry_id,info_id){
        //alert(ministry_id);
        $.ajax({
            type: "post",
            url : '{{ $SecretariatFilterUrl }}',
            datatype : "json",
            data : {"ministry_id":ministry_id,"_token":'{{ csrf_token() }}'},
            success : function(data){
                initDropDownList(jqxTheme, 250,32, '#div_listSecretariatFilter_'+info_id, data, 'text', 'value', false, '', '0', "#secretariat_id_"+info_id,"{{$constant['buttonSearch']}}",250);
                $('#div_listSecretariatFilter_'+info_id).jqxDropDownList({dropDownWidth:370});
            }
        });
    }
    function getDepartmentFilter(secretariat_id,info_id){
        $.ajax({
            type: "post",
            url : '{{ $DepartmentFilterUrl }}',
            datatype : "json",
            data : {"secretariat_id":secretariat_id,"_token":'{{ csrf_token() }}'},
            success : function(data){
                initDropDownList(jqxTheme, 250,32, '#div_listDepartmentFilter_'+info_id, data, 'text', 'value', false, '', '0', "#department_id_"+info_id,"{{$constant['buttonSearch']}}",250);
            }
        });
    }
    function getOfficeFilter(department_id,info_id){
        $.ajax({
            type: "post",
            url : '{{ $OfficeFilterUrl }}',
            datatype : "json",
            data : {"department_id":department_id,"_token":'{{ csrf_token() }}'},
            success : function(data){
                initDropDownList(jqxTheme, 250,32, '#div_listOfficeFilter_'+info_id, data, 'text', 'value', false, '', '0', "#office_id_"+info_id,"{{$constant['buttonSearch']}}",250);
            }
        });
    }

    $(document).ready(function(){
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
        //filter
        // Ministry select box
        initDropDownList(jqxTheme, 250,30, '#div_listMinistryFilter_0', <?php echo $list_MinistryFilter?>, 'text', 'value', false, '', '0', "#ministry_id_0","{{$constant['buttonSearch']}}",200);
        $('#div_listMinistryFilter_0').jqxDropDownList('selectItem', "{{isset($row->ministry_id)?$row->ministry_id:''}}");
        $('#div_listMinistryFilter_0').bind('select', function (event) {
            getSecretariatFilter($(this).val(),0);
        });

        // Secretariat select box
        initDropDownList(jqxTheme, 250,30, '#div_listSecretariatFilter_0',<?php echo $list_SecretariatFilter?>, 'text', 'value', false, '', '0', "#secretariat_id_0","{{$constant['buttonSearch']}}",200);
        $('#div_listSecretariatFilter_0').jqxDropDownList('selectItem', "{{isset($row->secretariat_id)?$row->secretariat_id:''}}");
        $('#div_listSecretariatFilter_0').bind('select', function (event) {
            getDepartmentFilter($(this).val(),0);
        });

        // Department select box
        initDropDownList(jqxTheme, 250,30, '#div_listDepartmentFilter_0', <?php echo $list_DepartmentFilter?>, 'text', 'value', false, '', '0', "#department_id_0","{{$constant['buttonSearch']}}",200);
        $('#div_listDepartmentFilter_0').jqxDropDownList('selectItem', "{{isset($row->department_id)?$row->department_id:''}}");
        $('#div_listDepartmentFilter_0').bind('select', function (event) {
            getOfficeFilter($(this).val(),0);
        });

        // Office select box
        initDropDownList(jqxTheme, 250,30, '#div_listOfficeFilter_0', <?php echo $list_OfficeFilter?>, 'text', 'value', false, '', '0', "#office_id_0","{{$constant['buttonSearch']}}",200);
        $('#div_listOfficeFilter_0').jqxDropDownList('selectItem', "{{isset($row->office_id)?$row->office_id:''}}");

        // Officer select box
        initDropDownList(jqxTheme, 250,30, '#div_officer_0',<?php echo $list_Officer?>, 'text', 'value', false, '', '0', "#officer_id_0","{{$constant['buttonSearch']}}",200);

        $('#div_officer_0').jqxDropDownList('selectItem', "{{isset($row->officer_id)?$row->officer_id:''}}");


        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}','{{$saveUrl}}', '{{ csrf_token() }}');
        });

        $('#addbutton').click(function() {
            var lastId = $('#TProcessingDoc tr:last').attr("id");
            lastId = lastId.substr(16);
             //alert(lastId);
            addMore(lastId);
        });
    });

    //remove
    function removeProcessingDoc(id){
         //alert(id);
        var sId = $('#sib_id_'+id).val();
        var Ministry = $('#div_listMinistryFilter_'+id).val();
        var Secretariat = $('#div_listSecretariatFilter_'+id).val();
        var Department = $('#div_listDepartmentFilter_'+id).val();
        var Office = $('#div_listOfficeFilter_'+id).val();
        var Officer = $('#div_officer_'+id).val();

        if(Ministry == '' && Secretariat == '' && Department == '' && Office == '' && Officer == ''){
            $('#processingDocTr_'+id).remove();
            return;

        }else{
            if(sId == ''){
                if(Ministry != '' || Secretariat != '' || Department != '' || Office != '' || Officer != ''){

                    var title = '{{$constant['buttonDelete']}}';
                    var content = '{{trans('trans.confirm_delete')}}';
                    confirmDelete(title,content,function () {
                        $.ajax({
                            type: 'POST',
                            url: "{{ $delete }}",
                            data: {sId : sId, _token : '{{ csrf_token() }}'},
                            dataType: "json",
                            success: function(response) {
                                $('#jqx-notification').jqxNotification({ position: 'top-right', template: "success" }).html(response.message);
                                $("#jqx-notification").jqxNotification("open");
                            }
                        });

                        $("#processingDocTr_"+id).remove();

                    });
                }
            }
        }
    }
    //add more
    function addMore(lastId){
        var info_id = parseInt(lastId) + 1;
        //alert(info_id);
        var No = info_id + 1;
        var str = '<tr id="processingDocTr_'+info_id+'">'
        str +='<td style="text-align:center; padding:15px;font-weight: bold">'+No+'</td>'

        str += '<td>'
        str += '<input type="hidden" id="sib_id_'+info_id+'" value="">'
        str += '<input type="hidden" class="form-control" id="ministry_id_'+info_id+'" name="processingDoc['+info_id+'][ministry_id]" value="{{isset($sibling['+lastId+']->ministry_id) ? $sibling['+lastId+']->ministry_id:''}}">'
        str += '<div id="div_listMinistryFilter_'+info_id+'"></div>'
        str += '</td>'

        str += '<td>'
        str += '<input type="hidden" class="form-control" id="secretariat_id_'+info_id+'" name="processingDoc['+info_id+'][secretariat_id]" value="{{isset($sibling['+lastId+']->secretariat_id) ? $sibling['+lastId+']->secretariat_id:''}}">'
        str += '<div id="div_listSecretariatFilter_'+info_id+'"></div>'
        str += '</td>'

        str += '<td>'
        str += '<input type="hidden" class="form-control" id="department_id_'+info_id+'" name="processingDoc['+info_id+'][department_id]" value="{{isset($sibling['+lastId+']->department_id) ? $sibling['+lastId+']->department_id:''}}">'
        str += '<div id="div_listDepartmentFilter_'+info_id+'"></div>'
        str += '</td>'

        str += '<td>'
        str += '<input type="hidden" class="form-control" id="office_id_'+info_id+'" name="processingDoc['+info_id+'][office_id]" value="{{isset($sibling['+lastId+']->office_id) ? $sibling['+lastId+']->office_id:''}}">'
        str += '<div id="div_listOfficeFilter_'+info_id+'"></div>'
        str += '</td>'

        str += '<td style="width: 20%;">'
        str += '<input type="hidden" class="form-control" id="officer_id_'+info_id+'" name="processingDoc['+info_id+'][officer_id]" value="{{isset($row->officer_id) ? $row->officer_id:''}}">'
        str += '<div id="div_officer_'+info_id+'"></div>'
        str += '</td>'

        str += '<td style="width: 10%">'
        str += '<button type="button" class="btn btn-primary jqx-primary" id="addbutton'+info_id+'" onclick="SaveProcessingDoc('+info_id+');"><i class="fa fa-edit"></i></button>'
        str += '</td>'

        str += '<td style="width:10%">'
        str += '<button type="button" class="btn btn-danger jqx-danger" id="addbutton'+info_id+'" onclick="removeProcessingDoc('+info_id+');"><i class="fa fa-minus"></i></button>'
        str += '</td>'



        str += '</tr>'


        $(str).insertAfter( "#processingDocTr_"+ lastId );

        //Ministry
        initDropDownList(jqxTheme, 250,30, '#div_listMinistryFilter_'+info_id, <?php echo $list_MinistryFilter?>, 'text', 'value', false, '', '0', "#ministry_id_"+info_id,"{{$constant['buttonSearch']}}",200);
        $('#div_listMinistryFilter_'+info_id).bind('select', function (event) {
            getSecretariatFilter($(this).val(),info_id);

        });
        //Secretariat
        initDropDownList(jqxTheme, 250,30, '#div_listSecretariatFilter_'+info_id,<?php echo $list_SecretariatFilter?>, 'text', 'value', false, '', '0', "#secretariat_id_"+info_id,"{{$constant['buttonSearch']}}",200);
        $('#div_listSecretariatFilter_'+info_id).bind('select', function (event) {
            getDepartmentFilter($(this).val(),info_id);
        });
        // Department
        initDropDownList(jqxTheme, 250,30, '#div_listDepartmentFilter_'+info_id, <?php echo $list_DepartmentFilter?>, 'text', 'value', false, '', '0', "#department_id_"+info_id,"{{$constant['buttonSearch']}}",200);
        $('#div_listDepartmentFilter_'+info_id).bind('select', function (event) {
            getOfficeFilter($(this).val(),info_id);

        });

        //Office
        initDropDownList(jqxTheme, 250,30, '#div_listOfficeFilter_'+info_id, <?php echo $list_OfficeFilter?>, 'text', 'value', false, '', '0', "#office_id_"+info_id,"{{$constant['buttonSearch']}}",200);
        // Officer select box
        initDropDownList(jqxTheme, 250,30, '#div_officer_'+info_id,<?php echo $list_Officer?>, 'text', 'value', false, '', '0', "#officer_id_"+info_id,"{{$constant['buttonSearch']}}",200);
    }

</script>