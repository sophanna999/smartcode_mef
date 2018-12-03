<?php
$jqxPrefix = '_role';
$saveUrl = asset($constant['secretRoute'].'/role/save');

?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="Id" name="Id" value="{{isset($row->id) ? $row->id:0}}">
        
         <div class="form-group">
            <div class="col-sm-3 text-right" style="padding-top:5px"><span class="red-star">*</span>Join Group</div>
            <div class="col-sm-9">
                <input type="hidden" class="form-control" id="join_group">
                <div id="div_join_group" name="join_group"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-3 text-right" style="padding-top:5px"><span class="red-star">*</span>{{trans('users.userRole')}}</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="{{trans('users.userRole')}}" id="role" name="role" value="{{isset($row->role) ? $row->role:''}}">
            </div>
        </div>
		<div class="form-group">
			<div class="col-sm-3 text-right"><span class="red-star">*</span>{{trans('users.grandAccess')}}</div>
            <div class="col-sm-9">
				<input type="hidden" id="authentication_id" name="authentication_id" value='<?php echo $selectedAuthentication; ?>'>
                <div id="div_authentication_id" name="authentication_resource"></div>
            </div>
		</div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-2">
                <div id="check_all"> {{trans('trans.all')}}</div>
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-3 text-right padding-top5">{{trans('trans.description')}}</div>
            <div class="col-sm-9">
                <textarea class="form-control" placeholder="{{$constant['description']}}" id="description" name="description" rows="2">{{isset($row->description) ? $row->description:''}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <input type="hidden" id="active" name="active" value="{{isset($row->active) ? $row->active:1}}">
                <div id="active-checkbox"> {{trans('trans.active')}}</div>
            </div>
            <div class="col-sm-4 text-right">
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
        initialButton(buttons,90,30);

        //Form Validations
        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
//                {input: '#div_join_group', message: ' ', action: 'select',
//                    rule: function () {
//                        var val = $("#div_join_group").val();
//                        if(val == "" || val == 0){
//                            return false;
//                        }
//                        return true;
//                    }
//                },
                {input: '#role', message: ' ', action: 'blur', rule: 'required'},
                {input: '#div_authentication_id', message: ' ', action: 'select',
                    rule: function () {
                        var val = $("#authentication_id").val();
                        if(val == "" || val == 0){
                            return false;
                        }
                        return true;
                    }
                }
            ]
        });

		//Save button
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
		
		//User Role
        initDropDownListCheckbox('#div_join_group',dropDownL,35,<?php echo $listJoinGroup;?>,<?php echo $listJoinGroupCheck;?>,550,'{{trans('trans.buttonSearch')}}');

        //Active checkbox
        var isActive = $('#active').val() == 1 ? true:false;
        $("#active-checkbox").jqxCheckBox({theme:jqxTheme,  width: 120, height: 25, checked: isActive});
        $('#active-checkbox').on('change', function (event) {
            event.args.checked == true ? $('#active').val(1):$('#active').val(0);
        });

        /* Check All Items */
        $("#check_all").jqxCheckBox({theme:jqxTheme});
        $('#check_all').on('change', function (event) {
            var string = '';
            var items = $('#div_authentication_id').jqxTree('getItems');
            if(event.args.checked == true){
                $('#div_authentication_id').jqxTree('checkAll');
                for (var i = 0; i < items.length; i++) {
                    var item = items[i];
                    string += item.id + ",";
                }
                string = string.slice(0,-1);
                $('#authentication_id').val(string);
            }else {
                $('#div_authentication_id').jqxTree('uncheckAll');
                $('#authentication_id').val('');
            }
        });
        /* End of Check all */


        /* Grand Access */
        initJqxTreeCheckbox(<?php echo $allAuthentication;?>,'div_authentication_id','authentication_id',405,350);

        //Get selected items
        var listItems = $('#authentication_id').val();
        listItems = listItems.split(',');
        if (listItems[0] != ''){
            $.each(listItems,function(index,value){
                var element = $('#div_authentication_id').find('#'+value)[0];
                $('#div_authentication_id').jqxTree('checkItem', element, true);
            });
        }
        /* End of Grand access */
    });
</script>