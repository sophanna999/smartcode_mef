<?php
$jqxPrefix = '_role';
$newUrl = asset($constant['secretRoute'].'/role/new');
$editUrl = asset($constant['secretRoute'].'/role/edit');
$listUrl = asset($constant['secretRoute'].'/role/index');
$deleteUrl = asset($constant['secretRoute'].'/role/delete');

?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
		<div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                        <div class="col-lg-12 col-xs-12">{{trans('users.userAuthorize')}} &raquo; {{trans('users.userRole')}}</div>
                    </div>
                    <div class="pull-right">
                        <div class="col-lg-12 col-xs-12">
                            <button id="btn-new"><i class="glyphicon glyphicon-plus"></i> {{trans('trans.buttonNew')}}</button>
                            <button id="btn-edit"><i class="glyphicon glyphicon-edit"></i> {{trans('trans.buttonEdit')}}</button>
                            <button id="btn-delete"><i class="glyphicon glyphicon-trash"></i> {{trans('trans.buttonDelete')}}</button>
                        </div>
                    </div>
                </div>
                <div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
            </div>
        </div>
	</div>
	
<script type="text/javascript">

    var window_widht = 600;
    var window_height = $(window).height() - 100;
    // prepare the data
    var source<?php echo $jqxPrefix;?> = {
        type: "post",
        dataType: "json",
        data:{"_token":'{{ csrf_token() }}'},
        dataFields: [
            { name: 'id', type: 'number' },
            { name: 'role', type: 'string' },
            { name: 'description', type: 'string' },
            { name: 'active', type: 'number' },
            { name: 'parent_id', type: 'string' }
        ],
        id: 'id',
        url: '<?php echo $listUrl;?>',
        hierarchy: {
                keyDataField: { name: 'id' },
                parentDataField: { name: 'parent_id' }
        },
        beforeprocessing: function(data) {
            source<?php echo $jqxPrefix;?>.totalrecords = (data != null)? data.total:0;
        },
        sort: function(data) {
        // Short Data
        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('updatebounddata', 'sort');
        },
        filter: function() {
            $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('updatebounddata', 'filter');
        },
        deleteRow: function (rowid, commit) {
            $.ajax({
                type: "post",
                dataType: "json",
                url: "<?php echo $deleteUrl;?>",
                cache: false,
                data: {"Id":rowid,"_token":'{{ csrf_token() }}','ajaxRequestJson':'true'},
                success: function (response, status, xhr) {
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    if(response.code == 0) {
                        //Some items delete execpt the one in used
                        $('#jqx-notification').jqxNotification({position: positionNotify,template: "warning",autoClose: false}).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }else if(response.code == 1){
                        //Item in used
                        $('#jqx-notification').jqxNotification({position: positionNotify,template: "warning",autoClose: false}).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }else{
                        //Items delete success
                        closeJqxWindowId('jqxwindow<?php echo $jqxPrefix;?>');
                        $('#jqx-notification').jqxNotification({ position: positionNotify, template: "success" }).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }
                    $("#jqx-grid<?php echo $jqxPrefix;?>").jqxTreeGrid('updateBoundData');
                },
                error: function (request, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    };

    var active<?php echo $jqxPrefix;?> = function (row, datafield, value) {
        return value == 0 ? '<div style="text-align: center; margin-top: 5px;"><i class="glyphicon glyphicon-remove"></i></div>':'<div style="text-align: center; margin-top: 5px;"><i class="glyphicon glyphicon-ok"></i></div>';
    };

 
    $(document).ready(function () {
		//Button action
		var buttons = ['btn-new','btn-edit','btn-delete'];
        initialButton(buttons,90,30);

        var dataAdapter = new $.jqx.dataAdapter(source<?php echo $jqxPrefix;?>);
        // create Tree Grid

        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxTreeGrid({
            theme:jqxTheme,
            width:'100%',
            height:gridHeight,
            source: dataAdapter,
            sortable: false,
            pageable: false,
            pagerMode: 'advanced',
            filterable: false,
            filterMode: 'advanced',
            selectionMode: 'singlerow',
            pageSize: <?php echo $constant['pageSize'];?>,
            pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
            columns: [
                { text: '{{trans('users.userRole')}}', dataField: 'role', width: '40%' },
                { text: '{{trans('trans.description')}}', dataField: 'description', width: '55%',filterable:true },
                { text: '{{trans('trans.active')}}', dataField: 'active', width: '5%',filterable:false ,cellsrenderer: active<?php echo $jqxPrefix;?>, align:'center' }
            ],
            ready: function () {
                $("#jqx-grid<?php echo $jqxPrefix;?>").jqxTreeGrid('expandAll');
            },
        });

        $("#btn-new").on('click',function(){
            newJqxItem('<?php echo $jqxPrefix;?>', '{{trans('trans.buttonNew')}}',window_widht,window_height, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
        });
        $("#btn-edit").on('click',function(){
            var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxTreeGrid('getSelection')[0];
            if(row == null){
                $("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{$constant['editRow']}}');
                $("#jqx-notification").jqxNotification("open");
                return false;
            }
            newJqxItem('<?php echo $jqxPrefix;?>', '{{trans('trans.buttonEdit')}}',window_widht,window_height, '<?php echo $editUrl;?>', row.id, '{{ csrf_token() }}');
        });
        $("#btn-delete").click(function(){
            var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxTreeGrid('getSelection')[0];
            if(row == null){
                $("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{$constant['deleteRow']}}');
                $("#jqx-notification").jqxNotification("open");
                return false;
            }         
			var title = '{{$constant['buttonDelete']}}';
			var content = '{{trans('trans.confirm_delete')}}';
			confirmDelete(title,content,function () {
				$('#jqx-grid<?php echo $jqxPrefix;?>').jqxTreeGrid('deleteRow', row.id);
			});
        });
    });
</script>
@endsection