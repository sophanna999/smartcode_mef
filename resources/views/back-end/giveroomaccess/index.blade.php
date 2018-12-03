<?php
$jqxPrefix = '_give_room_access';
$newUrl = asset($constant['secretRoute'].'/give-room-access/new');
$editUrl = asset($constant['secretRoute'].'/give-room-access/edit');
$listUrl = asset($constant['secretRoute'].'/give-room-access/index');
$deleteUrl = asset($constant['secretRoute'].'/give-room-access/delete');

?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
		<div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                        <div class="col-lg-12 col-xs-12">{{trans('users.userAuthorize')}} &raquo; {{trans('users.user')}}</div>
                    </div>
                    <div class="pull-right">
                        <div class="col-lg-12 col-xs-12">
                            <button id="btn-new"><i class="glyphicon glyphicon-plus"></i> {{trans('users.grandAccess')}}</button>
                            <button id="btn-edit"><i class="glyphicon glyphicon-edit"></i> {{$constant['buttonEdit']}}</button>
                            <button id="btn-delete"><i class="glyphicon glyphicon-trash"></i> {{trans('trans.buttonDelete')}}</button>
                        </div>
                    </div>
                </div>
                <div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
            </div>
        </div>
	</div>

<script type="text/javascript">
    var window_width = 1000;
    var window_height = 450;
    // prepare the data
    var source<?php echo $jqxPrefix;?> = {
        type: "post",
        dataType: "json",
        data:{"_token":'{{ csrf_token() }}'},
        dataFields: [
            { name: 'FULL_NAME_KH', type: 'string' },
            { name: 'name', type: 'string' }
        ],
        id: 'id',
        url: '<?php echo $listUrl;?>',
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
                        //Some items delete except the one in used
                        $('#jqx-notification').jqxNotification({position: positionNotify,template: "warning",autoClose: false}).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }else if(response.code == 1) {
                        //Item in used
                        $('#jqx-notification').jqxNotification({
                            position: positionNotify,
                            template: "warning"
                        }).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }else if(response.code == 3){
                        $('#jqx-notification').jqxNotification({position: positionNotify,template: "warning",autoClose: false}).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }else{
                        //Items delete success
                        closeJqxWindowId('jqxwindow<?php echo $jqxPrefix;?>');
                        $('#jqx-notification').jqxNotification({ position: positionNotify, template: "success" }).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }

                    $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('updatebounddata');
                    $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('clearselection');
                },
                error: function (request, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    };

    $(document).ready(function () {
		//Button action
		var buttons = ['btn-new','btn-edit','btn-delete'];
        initialButton(buttons,110,35);

        var dataAdapter = new $.jqx.dataAdapter(source<?php echo $jqxPrefix;?>);
        // create Tree Grid
        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid({
                theme:jqxTheme,
                width:'100%',
                height:gridHeight,
				rowsheight:50,
                source: dataAdapter,
                selectionmode: 'checkbox',
                sortable: true,
                pageable: true,
                pagerMode: 'advanced',
                showfilterrow: true,
                filterable: true,
				enabletooltips: true,
                pageSize: <?php echo $constant['pageSize'];?>,
                pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
                virtualmode: true,
                rendergridrows: function(obj) {
                    return obj.data;
                },
                columns: [
                    { text: 'ឈ្មោះបុគ្គលិក', dataField: 'FULL_NAME_KH', width: '18%' },
                    { text: 'បន្ទប់', dataField: 'name'}
                ],
                showgroupsheader: false,
                groupable:true,
                groupsexpandedbydefault: true,
                // groups: ['role']
        });

		/* New */
        $("#btn-new").on('click',function(){
            newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}',window_width,window_height, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
        });


        $("#btn-edit").on('click',function(){
            var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
            $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
            if(row.length == 0){
                $("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{$constant['editRow']}}');
                $("#jqx-notification").jqxNotification("open");
                return false;
            }else if(row.length > 1){
                $("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{$constant['selectOneRow']}}');
                $("#jqx-notification").jqxNotification("open");
                return false;
            }else{
                var jqxdatarow = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);

                newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonEdit']}}', window_width, window_height, '<?php echo $editUrl;?>', jqxdatarow.uid, '{{ csrf_token() }}');
            }

        });
		
		/* Delete */
        $("#btn-delete").click(function(){
            var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
            if(row.length == 0){
                $("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{$constant['deleteRow']}}');
                $("#jqx-notification").jqxNotification("open");
				$("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                return false;
            }
			var listId = [];            
			var title = '{{$constant['buttonDelete']}}';
			var content = '{{trans('trans.confirm_delete')}}';
			confirmDelete(title,content,function () {
				for(var index in row){
					var jqxdatarow = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row[index]);
					listId.push(jqxdatarow.uid);
				}
				$('#jqx-grid<?php echo $jqxPrefix;?>').jqxGrid('deleteRow', listId);
			});
        });


    });
</script>
@endsection