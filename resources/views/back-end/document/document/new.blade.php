
<?php
$jqxPrefix = '_documents';
$saveUrl = asset($constant['secretRoute'].'/documents/save');
$sessionUser = session('sessionUser');
$SecretariatFilterUrl = asset($constant['secretRoute'].'/documents/get-secretariat-filter');
$DepartmentFilterUrl = asset($constant['secretRoute'].'/documents/get-department-filter');
$OfficeFilterUrl    = asset($constant['secretRoute'].'/documents/get-office-filter');
$newUrl = asset($constant['secretRoute'].'/documents/form-unit-new');
$newDocType = asset($constant['secretRoute'].'/documents/form-new-doc-type');
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
    label[for*='1']:before { content: '\f1cb'; }
    label[for*='2']:before { content: '\f17d'; }

    label:hover {
        color: #888;
        cursor: pointer;
    }

    input:checked + label {
        color: #555;
        border: 1px solid #ddd;
        border-top: 2px solid orange;
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
                <h3 style="margin-top: -20px; border-bottom: 1px solid #e0e0e0; margin-bottom: 20px; color: #0a73a7; font-family: 'KHMERMEF2'">ឯកសារចេញ-ចូល</h3>
                <div class="form-group">
                    <div class="col-sm-2 text-right" style="padding: 10px;">ប្រភេទ</div>
                    <div class="col-sm-10">
                        <input type="hidden" class="form-control">
                        <div id="div_type"></div>
                    </div>
                </div>

    <div id="ministry">
        <div class="form-group">
            <div class="col-sm-2 text-right" style="padding: 10px;">ក្រសួងស្ថាប័ន</div>
            <div class="col-sm-4">
                <input type="hidden" class="form-control" id="ministry_id" name="processing" value="{{isset($val->ministry_id) ? $val->ministry_id:''}}">
                <div id="div_listMinistryFilter"></div>
            </div>

            <div class="col-sm-2 text-right" style="padding: 10px;">អគ្គលេខាធិការដ្ឋាន</div>
            <div class="col-sm-4">
                <input type="hidden" class="form-control" id="secretariat_id" name="processing" value="{{isset($val->secretariat_id) ? $val->secretariat_id:''}}">
                <div id="div_listSecretariatFilter"></div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2 text-right" style="padding: 10px;">នាយកដ្ឋាន</div>
            <div class="col-sm-4">
                <input type="hidden" class="form-control" id="department_id" name="processing" value="{{isset($val->department_id) ? $val->department_id:''}}">
                <div id="div_listDepartmentFilter"></div>
            </div>

            <div class="col-sm-2 text-right" style="padding: 10px;">ការិយាល័យ</div>
            <div class="col-sm-4">
                <input type="hidden" class="form-control" id="office_id" name="processing" value="{{isset($val->office_id) ? $val->office_id:''}}">
                <div id="div_listOfficeFilter"></div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2 text-right" style="padding: 10px;">អ្នកមកដាក់ឯកសារ</div>
            <div class="col-sm-10">
                <input type="hidden" class="form-control" id="officer_id" name="officer_id" value="{{isset($row->officer_id) ? $row->officer_id:''}}">
                <div id="div_officer"></div>
            </div>
        </div>
    </div>
    {{--end ministry--}}

    <div id="company">
        <div class="form-group">
            <div class="col-sm-2 text-right" style="padding: 10px;">អង្គភាព</div>
            <div class="col-sm-8">
                <input type="hidden" class="form-control" id="unit_id" name="unit_id" value="{{isset($row->unit_id) ? $row->unit_id:''}}">
                <div id="div_unit"></div>
            </div>
            <div class="col-sm-2 pull-right">
                <button id="buttonAdd<?php echo $jqxPrefix;?>" class="btn btn-danger" style="width: 10px !important;"><i class="fa fa-plus"></i> Add</button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2 text-right" style="padding: 10px;">ឈ្មោះអ្នកដំណាង</div>
            <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="ឈ្មោះអ្នកដំណាង" id="represent_name" name="represent_name" value="{{isset($row->represent_name) ? $row->represent_name:''}}">
            </div>
            <div class="col-sm-2 text-right" style="padding: 10px;">លេខទូរស័ព្ទ</div>
            <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="លេខទូរស័ព្ទ" id="represent_name" name="represent_name" value="{{isset($row->represent_name) ? $row->represent_name:''}}">
            </div>

        </div>

    </div>

    <div class="form-group">
        <div class="col-sm-2 text-right" style="padding: 10px;">លេខឯកសារ</div>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="doc_id" name="doc_id" value="{{isset($row->doc_id) ? $row->doc_id:''}}">
        </div>

        <div class="col-sm-2 text-right" style="padding: 10px;">ចុះថ្ងៃទី</div>
        <div class="col-sm-4">
            <input type="date" class="form-control" id="doc_date" name="doc_date" value="{{isset($row->doc_date) ? $row->doc_date:''}}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 text-right">កម្មវត្ថុ</div>
        <div class="col-sm-10">
            <textarea name="objective" id="objective" cols="147" rows="3"></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 text-right" style="padding: 10px;">ប្រភេទឯកសារ</div>
        <div class="col-sm-4">
            <input type="hidden" class="form-control" id="document_type_id" name="document_type_id" value="{{isset($row->document_type_id) ? $row->document_type_id:''}}">
            <div id="div_document_type"></div>

        </div>
        <div class="col-sm-2">
            <button id="buttonAdd_Docx<?php echo $jqxPrefix;?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
        </div>

        <div class="col-sm-4" style="padding: 10px;">
            <input type="hidden" id="hurry" name="hurry" value="{{isset($row->hurry) ? $row->hurry:0}}">
            <div id="checkbox">ឯកសារប្រញាប់ </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 text-right" style="padding: 10px;">អ្នកទទួល</div>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="user_id" name="user_id" readonly value="{{ ucfirst($sessionUser->user_name != null ? $sessionUser->user_name:'administrator')}} ">
        </div>

        <div class="col-sm-2 text-right" style="padding: 10px;">ផ្ងើរជូនប្រធាននាយកដ្ឋាន</div>
        <div class="col-sm-4">
            <input type="hidden" class="form-control" id="div_officer" name="div_officer" readonly value="{{isset($row->div_officer) ? $row->div_officer:''}}">
            <div id="div_officer1"></div>
        </div>
    </div>

        <div class="form-group">
            <div class="col-sm-2 text-right" style="padding: 10px;"><span class="red-star">*</span>ឯកសារ</div>
            <div class="col-sm-10">
                <input type="file" class="form-control" id="path_file" name="path_file[]" value="{{isset($row->path_file) ? $row->path_file:''}}" multiple>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-10 col-sm-2">
                <button class="btn btn-primary" id="jqx-save<?php echo $jqxPrefix;?>"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </div>
    {{--END doc--}}


        </form>
    </div>
</div>

<script>
   $(document).ready(function(){
    $("#company").hide();
    $("#ministry").show();
    var buttons = ['jqx-save<?php echo $jqxPrefix;?>','buttonAdd<?php echo $jqxPrefix;?>'];
    initialButton(buttons,90,30);

    // active checkbox
    var isActive = $('#hurry').val() == 1 ? true : false;
    $("#checkbox").jqxCheckBox({theme: jqxTheme, width: 120, height: 25, checked: isActive});
    $('#checkbox').on('change', function (event) {
        event.args.checked == true ? $('#hurry').val(1) : $('#hurry').val(0);
    });

    function getSecretariatFilter(ministry_id){
        $.ajax({
            type: "post",
            url : '{{ $SecretariatFilterUrl }}',
            datatype : "json",
            data : {"ministry_id":ministry_id,"_token":'{{ csrf_token() }}'},
            success : function(data){
                initDropDownList(jqxTheme, '100%',32, '#div_listSecretariatFilter', data, 'text', 'value', false, '', '0', "#secretariat_id","{{$constant['buttonSearch']}}",250);
            }
        });
    }
    function getDepartmentFilter(secretariat_id){
        $.ajax({
            type: "post",
            url : '{{ $DepartmentFilterUrl }}',
            datatype : "json",
            data : {"secretariat_id":secretariat_id,"_token":'{{ csrf_token() }}'},
            success : function(data){
                initDropDownList(jqxTheme, '100%',32, '#div_listDepartmentFilter', data, 'text', 'value', false, '', '0', "#department_id","{{$constant['buttonSearch']}}",250);
            }
        });
    }
    function getOfficeFilter(department_id){
        $.ajax({
            type: "post",
            url : '{{ $OfficeFilterUrl }}',
            datatype : "json",
            data : {"department_id":department_id,"_token":'{{ csrf_token() }}'},
            success : function(data){
                initDropDownList(jqxTheme, '100%',32, '#div_listOfficeFilter', data, 'text', 'value', false, '', '0', "#office_id","{{$constant['buttonSearch']}}",250);
            }
        });
    }

    //type select box
    initDropDownList(jqxTheme, "100%",30, '#div_type', <?php echo $list_Type?>, 'text', 'value', false, '', '0', "#type","{{$constant['buttonSearch']}}",200);

    // Unit select box
    initDropDownList(jqxTheme, "100%",30, '#div_unit', <?php echo $list_Unit?>, 'text', 'value', false, '', '0', "#unit_id","{{$constant['buttonSearch']}}",200);
    $('#div_unit').jqxDropDownList('selectItem', "{{isset($row->unit_id)?$row->unit_id:''}}");

    // Officer select box
    initDropDownList(jqxTheme, "100%",30, '#div_officer', <?php echo $list_Officer?>, 'text', 'value', false, '', '0', "#officer_id","{{$constant['buttonSearch']}}",200);
    $('#div_officer').jqxDropDownList('selectItem', "{{isset($row->officer_id)?$row->officer_id:''}}");

    // Docx select box
    initDropDownList(jqxTheme, "100%",30, '#div_document_type', <?php echo $list_DocumentType?>, 'text', 'value', false, '', '0', "#document_type_id","{{$constant['buttonSearch']}}",200);
    $('#div_document_type').jqxDropDownList('selectItem', "{{isset($row->document_type_id)?$row->document_type_id:''}}");

    // Officer select box
    initDropDownList(jqxTheme, "100%",30, '#div_officer1', <?php echo $list_Officer?>, 'text', 'value', false, '', '0', "#officer_id","{{$constant['buttonSearch']}}",200);
    $('#div_officer1').jqxDropDownList('selectItem', "{{isset($row->officer_id)?$row->officer_id:''}}");

     //filter
    // Ministry select box
    initDropDownList(jqxTheme, "100%",30, '#div_listMinistryFilter', <?php echo $list_MinistryFilter?>, 'text', 'value', false, '', '0', "#ministry_id","{{$constant['buttonSearch']}}",200);
    $('#div_listMinistryFilter').jqxDropDownList('selectItem', "{{isset($row->ministry_id)?$row->ministry_id:''}}");

    $('#div_listMinistryFilter').bind('select', function (event) {
        getSecretariatFilter($(this).val());
    });

    // Secretariat select box
    initDropDownList(jqxTheme, "100%",30, '#div_listSecretariatFilter',<?php echo $list_SecretariatFilter?>, 'text', 'value', false, '', '0', "#secretariat_id","{{$constant['buttonSearch']}}",200);
    $('#div_listSecretariatFilter').jqxDropDownList('selectItem', "{{isset($row->secretariat_id)?$row->secretariat_id:''}}");

    $('#div_listSecretariatFilter').bind('select', function (event) {
        getDepartmentFilter($(this).val());
    });

    // Department select box
    initDropDownList(jqxTheme, "100%",30, '#div_listDepartmentFilter', <?php echo $list_DepartmentFilter?>, 'text', 'value', false, '', '0', "#department_id","",200);
    $('#div_listDepartmentFilter').jqxDropDownList('selectItem', "{{isset($row->department_id)?$row->department_id:''}}");
    $('#div_listDepartmentFilter').bind('select', function (event) {
        getOfficeFilter($(this).val());
    });

    // Office select box
    initDropDownList(jqxTheme, "100%",30, '#div_listOfficeFilter', <?php echo $list_OfficeFilter?>, 'text', 'value', false, '', '0', "#office_id","",200);
    $('#div_listOfficeFilter').jqxDropDownList('selectItem', "{{isset($row->office_id)?$row->office_id:''}}");


    myUploadInput = $("input[type=file]").uploadPreviewer();

    $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
        saveJqxItem('{{$jqxPrefix}}','{{$saveUrl}}', '{{ csrf_token() }}');
    });

       $("#buttonAdd<?php echo $jqxPrefix;?>").on('click',function(e){
           e.preventDefault();
           newJqxItem('_documents_unit', '{{$constant['buttonNew']}}',1000,350, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
       });

       $("#buttonAdd_Docx<?php echo $jqxPrefix;?>").on('click',function(e){
           e.preventDefault();
           newJqxItem('_documents_type', '{{$constant['buttonNew']}}',800,200, '<?php echo $newDocType;?>', 0, '{{ csrf_token() }}');
       });




    $('#div_type').on('change', function (event) {
        //alert('onChange');
        var args = event.args;
        if (args) {
            var index = args.index;
            var item = args.item;
            var label = item.label;
            var value = item.value;

            if(value=="ក្រសួងស្ថាប័ន") {
                $("#company").hide();
                $("#ministry").show();

            } else if(value=="ក្រុមហ៊ុនឯកជន") {
                $("#ministry").hide();
                $("#company").show();
            }
        }
    });

   });

</script>