<?php
$jqxPrefix = '_user';
$saveUrl = asset($constant['secretRoute'].'/user/save');
$getUnit = asset($constant['secretRoute'].'/user/get-unit');
?>

<style type="text/css">
    table tr td
    {
        border-top: none;
        border-bottom: none;
    }
    .table.no-border tr td, .table.no-border tr th {
        border-width: 0;
    }
</style>

<div class="container-fluid">
<form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="ajaxRequestJson" value="true" />
    <input type="hidden" id="Id" name="Id" value="{{isset($row->id) ? $row->id:0}}">

   	<div class="form-group">
		<div class="col-sm-2 text-left" style="padding-top:5px"><span class="red-star">*</span>តួនាទីអ្នកប្រើប្រាស់</div>
		<div class="col-sm-10">
			<input type="hidden" id="role_id_div" name="role_id_div" value="{{isset($row->mef_member_id) ? $row->mef_member_id:''}}">
            <div id="div_role" name="role"></div>
		</div>
	</div>

    <div class="form-group">
		<div class="col-sm-2 text-left" style="padding-top:5px"><span class="red-star">*</span>អ្នកចុះឈ្មោះ</div>
		<div class="col-sm-10">
			<input type="hidden" id="officer_id_div"  value="{{isset($row->mef_officer_id) ? $row->mef_officer_id:''}}" >
            <div id="officer_id" name="officer_id" class="pull-left" onload="disibledJqxDropDownList({{isset($row->mef_officer_id) ? $row->mef_officer_id:''}})"></div>
		</div>
	</div>

    <div class="form-group">
    	<div class="col-sm-2" style="padding-top: 10px;">ឈ្មោះអ្នកប្រើប្រាស់</div>
		<div class="col-sm-4">
			<input type="text" id="officer_name" name="officer_name" class="form-control" placeholder="អ្នកប្រើប្រាស់" autocomplete="off" readonly  value="{{isset($row->user_name) ? $row->user_name:''}}">
		</div>
		<div class="col-sm-2 text-right" style="padding-top: 10px;">តួនាទី</div>
		<div class="col-sm-4">
			<input type="text" id="position_name" name="position_name" class="form-control" placeholder="តួនាទី" autocomplete="off" readonly value="{{isset($row->mef_position) ? $row->mef_position:''}}">
		</div>
	</div>

    <div class="form-group">
    	<div class="col-sm-2" style="padding-top: 10px;">ក្រសួង-ស្ថាប័ន</div>
		<div class="col-sm-4">
			<input type="hidden" id="ministry_id_div" value="{{isset($row->mef_ministry_id) ? $row->mef_ministry_id:''}}">
            <div id="ministry_id" name="ministry_id"></div>
		</div>
		<div class="col-sm-2 text-right" style="padding-top: 10px;">អគ្គនាយកដ្ឋាន</div>
		<div class="col-sm-4">
			<input type="hidden" id="secretary_id_div" value="{{isset($row->mef_general_department_id) ? $row->mef_general_department_id:''}}">
            <div id="secretary_id" name="secretary_id"></div>
		</div>
	</div>

    <div class="form-group">
    	<div class="col-sm-2" style="padding-top: 10px;">នាយកដ្ឋានជំនាញ</div>
		<div class="col-sm-4">
			<input type="hidden" id="department_id_div" value="{{isset($row->mef_department_id) ? $row->mef_department_id:''}}">
            <div id="department_id" name="department_id"></div>
		</div>
		<div class="col-sm-2 text-right" style="padding-top: 10px;">ការិយាល័យ</div>
		<div class="col-sm-4">
			<input type="hidden" id="office_id_div" value="{{isset($row->mef_office_id) ? $row->mef_office_id:''}}">
            <div id="office_id" name="office_id"></div>
		</div>
	</div>

    <div class="form-group">
    	<div class="col-sm-2" style="padding-top: 10px;">មើលប្រតិបត្តិការអ្នកប្រើប្រាស់</div>
		<div class="col-sm-4">
			 <div id="user_id" name="user_id"></div>
		</div>
	    <div class="col-sm-2 text-right password" style="padding-top: 10px;display: none">ពាក្យសំងាត់</div>
		<div class=" col-sm-4 password" style="padding-top: 10px;">
			 <input type="password" id="password" style="display: none" class="form-control password " placeholder="ពាក្យសំងាត់" name="password" value="{{isset($user->password) ? $user->password:''}}">

		</div>
	</div>
	<div class="col-sm-offset-2 col-sm-4" style="padding-top: 10px;">
		<input type="hidden" id="active" name="active" value="{{isset($user->active) ? $user->active:1}}">
		<div id="active-checkbox"> បើកប្រើ</div>
	</div>

    <div class="form-group">
		<div class="col-sm-offset-10 col-sm-2">
			<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}} </button>
		</div>

	</div>

</form>
</div>
<style>
    .loadinggif {
        background:url('<?php echo asset('jqwidgets/styles/images/loader-small.gif');?>') no-repeat left center;
    }
    .remove-avatar {
        position: relative !important;
        top: -46px !important;
        right: 18px !important;
    }
    input[type="file"]{
        font-size:12px !important;
        position:absolute;
        width:10%;
        height:10%;
        opacity: 0;
        outline: none;
        background-color: #ffffff;
        cursor: pointer;
        display: block;
    }
    input[type=text].jqx-input, input[type=password].jqx-input {
        font-family: inherit !important;
    }

</style>
<script>
    var dropDownWidth = '100%';
    var dropDownL = '100%';
    //DropDownListCheckbox List
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

    //Filter Data Office Of Unit(Ministry,secretary,Department,Office)
    function getUnit(mef_officer_id){
            $.ajax({
                type: "post",
                url: '{{$getUnit}}',
                datatype: "json",
                data: {"mef_officer_id": mef_officer_id, "_token": '{{ csrf_token() }}'},
                success: function (data) {
//                    console.log(data);
                    if (jQuery.isEmptyObject(data) != true) {
                        $('#officer_name').val(data.officer_username);
                        $('#position_name').val(data.position_name);
                        // list ministry
                        initDropDownList(jqxTheme, '100%',35, '#ministry_id',  data.ministry, 'text', 'value', false, '', '0', "#ministry_id_div","{{$constant['buttonSearch']}}",250);
                        // list secretary
                        initDropDownList(jqxTheme, '100%',35, '#secretary_id',  data.secretarial, 'text', 'value', false, '', '0', "#secretary_id_div","{{$constant['buttonSearch']}}",250);
                        // list department
                        initDropDownList(jqxTheme, '100%',35, '#department_id', data.department, 'text', 'value', false, '', '0', "#department_id_div","{{$constant['buttonSearch']}}",250);
                        // list department
                        initDropDownList(jqxTheme, '100%',35, '#office_id', data.office, 'text', 'value', false, '', '0', "#office_id_div","{{$constant['buttonSearch']}}",250);
                        //User List
                        initDropDownListCheckbox('#user_id',dropDownL,35,data.user,data.user_check,550,'{{trans('trans.buttonSearch')}}');
                    }
                }
            });
    }

    function disibledJqxDropDownList($value){

        if($value != ''){
            alert('sa');
            $('#officer_id').jqxDropDownList({
                disabled: true
            });
        }
    }

    $(document).ready(function(){
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,150,35);

        //Form Validations
        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#div_role', message: ' ', action: 'select',
                    rule: function () {
                        var val = $("#div_role").val();
                        if(val == "" || val == 0){
                            return false;
                        }
                        return true;
                    }
                },
                {input: '#officer_id', message: ' ', action: 'select',
                    rule: function () {
                        var val = $("#officer_id").val();
                        if(val == "" ){
                            return false;
                        }
                        return true;
                    }
                },
                {input: '#ministry_id', message: ' ', action: 'select',
                    rule: function () {
                        var val = $("#ministry_id").val();
                        if(val == "" || val == 0){
                            return false;
                        }
                        return true;
                    }
                },
                {input: '#officer_name', message: ' ', action: 'blur', rule: 'required'},
                {input: '#position_name', message: ' ', action: 'blur', rule: 'required'}
            ]
        });

        // Officer List
        initDropDownList(jqxTheme, '100%',35, '#officer_id', <?php echo $listOfficer;?>, 'text', 'value', false, '', '0', "#officer_id_div","{{$constant['buttonSearch']}}",250);
        $('#officer_id').bind('change', function (event) {

            if($(this).val() !=0){
                getUnit($(this).val());
            }

            if($(this).val() == 0){

	            $("#officer_name").removeAttr('readonly');
	            $("#position_name").removeAttr('readonly');
	            $(".password").css('display','block');
	            $("#officer_name").val('');
	            $("#position_name").val('');
	            $("#ministry_id").jqxDropDownList('selectIndex', 0 );
	            $("#secretary_id").jqxDropDownList('selectIndex', 0 );
	            $("#department_id").jqxDropDownList('selectIndex', 0 );
	            $("#office_id").jqxDropDownList('selectIndex', 0 );
	            initDropDownList(jqxTheme, '100%',35, '#ministry_id',<?php echo $listAllMinistry;?> , 'text', 'value', false, '', '0', "#ministry_id_div","{{$constant['buttonSearch']}}",250);
	            initDropDownList(jqxTheme, '100%',35, '#secretary_id', <?php echo $listAllSecretial;?>, 'text', 'value', false, '', '0', "#secretary_id_div","{{$constant['buttonSearch']}}",250);
	            initDropDownList(jqxTheme, '100%',35, '#department_id', <?php echo $listAllDepartment;?>, 'text', 'value', false, '', '0', "#department_id_div","{{$constant['buttonSearch']}}",250);
	            initDropDownList(jqxTheme, '100%',35, '#office_id', <?php echo $listAllOffice;?>, 'text', 'value', false, '', '0', "#office_id_div","{{$constant['buttonSearch']}}",250);
            }else{

	            $("#officer_name").attr('readonly','');
	            $("#position_name").attr('readonly','');
	            $(".password").css('display','none');
            }
        });

        //User Role
        initDropDownListCheckbox('#div_role',dropDownL,35,<?php echo $listRole;?>,<?php echo $listRoleCheck;?>,550,'{{trans('trans.buttonSearch')}}');
        // list ministry

        initDropDownList(jqxTheme, '100%',35, '#ministry_id', <?php echo $listMinistry;?>, 'text', 'value', false, '', '0', "#ministry_id_div","{{$constant['buttonSearch']}}",250);
        // list secretary
        initDropDownList(jqxTheme, '100%',35, '#secretary_id', <?php echo $listSecretial;?>, 'text', 'value', false, '', '0', "#secretary_id_div","{{$constant['buttonSearch']}}",250);
        // list department
        initDropDownList(jqxTheme, '100%',35, '#department_id', <?php echo $listDepartment;?>, 'text', 'value', false, '', '0', "#department_id_div","{{$constant['buttonSearch']}}",250);
        // list department
        initDropDownList(jqxTheme, '100%',35, '#office_id', <?php echo $listOffice;?>, 'text', 'value', false, '', '0', "#office_id_div","{{$constant['buttonSearch']}}",250);
        //User List
        initDropDownListCheckbox('#user_id',dropDownL,35,<?php echo $listUser;?>,<?php echo $listUserCheck;?>,550,'{{trans('trans.buttonSearch')}}');

        //Active checkbox
        var isActive = $('#active').val() == 1 ? true:false;
        $("#active-checkbox").jqxCheckBox({theme:jqxTheme,  width: 120, height: 25, checked: isActive});
        $('#active-checkbox').on('change', function (event) {
            event.args.checked == true ? $('#active').val(1):$('#active').val(0);
        });

        /* Save action button */
        $('input[type=text]').on('keydown', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
            }
        });
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
    });
</script>