<?php
$jqxPrefix = '_give_room_access';
$saveUrl = asset($constant['secretRoute'].'/give-room-access/save');
$selectRoomByOfficer = asset($constant['secretRoute'].'/give-room-access/selectroom');
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
    {{--<input type="hidden" id="Id" name="Id" value="{{isset($row->id) ? $row->id:0}}">--}}

    <div class="form-group">
        <div class="col-sm-2 text-right" style="padding:10px"><span class="red-star">*</span>បុគ្គលិក</div>
        <div class="col-sm-10">
            <input type="hidden" id="officer_id_div"  value="{{isset($edit_officer_id) ? $edit_officer_id:''}}" >
            <div id="officer_id" name="officer_id" class="pull-left"></div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 text-right" style="padding:10px"><span class="red-star">*</span>បន្ទប់</div>
        <div class="col-sm-10">
            <input type="hidden" id="room_id_div" name="room_id_div" value="{{isset($row->mef_member_id) ? $row->mef_member_id:''}}">
            <div id="div_room" name="room"></div>
        </div>
    </div>

	<div class="form-group">
		<div class="col-sm-offset-10 col-sm-2">
			<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}} </button>
		</div>

	</div>

</form>
</div>

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

    $(document).ready(function(){
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,150,35);

        //Form Validations
        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#div_room', message: ' ', action: 'select',
                    rule: function () {
                        var val = $("#div_room").val();
                        if(val == "" || val == 0){
                            return false;
                        }
                        return true;
                    }
                },
                {input: '#officer_id', message: ' ', action: 'select',
                    rule: function () {
                        var val = $("#officer_id").val();
                        if(val == "" || val == 0){
                            return false;
                        }
                        return true;
                    }
                }

            ]
        });

        // Officer List
        initDropDownList(jqxTheme, '100%',35, '#officer_id', <?php echo $listOfficer;?>, 'text', 'value', false, '', '0', "#officer_id_div","{{$constant['buttonSearch']}}",250);
        $('#officer_id').bind('select', function (event) {
            if($(this).val() !=0){
                loadSelectedRoom($(this).val());
            }
        });


        function loadSelectedRoom (officer_id){
            $.ajax({
                type:"post",
                url: '{{ $selectRoomByOfficer }}',
                datatype: "json",
                data: {"officer_id":officer_id,"_token":'{{ csrf_token() }}'},
                success : function(data){
                    $("#div_room").jqxDropDownList('uncheckAll');
                    if (data.room_selected.length) {
                        for (var i = 0; i < data.room_selected.length ; i++) {
                            $('#div_room').jqxDropDownList('checkItem', data.room_selected[i].meeting_room_id,{width: '500px'});
                        }
                        $("#div_room").jqxDropDownList('open');
                    }
                }
            });
        }

        //room droptdown
        initDropDownListCheckbox('#div_room',dropDownL,35,<?php echo $listRole;?>,<?php echo $listRoleCheck;?>,550,'{{trans('trans.buttonSearch')}}');

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



        if($('#officer_id_div').val() != null){
            loadSelectedRoom($('#officer_id_div').val());
        }
    });


</script>