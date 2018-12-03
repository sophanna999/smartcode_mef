<?php
$jqxPrefix = '_tags';
$listUrl = asset($constant['secretRoute'].'/tags/index');
$newUrl = asset($constant['secretRoute'].'/tags/new');
$editUrl = asset($constant['secretRoute'].'/tags/edit');
$deleteUrl = asset($constant['secretRoute'].'/tags/delete');

?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
		<div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                        <div class="col-lg-12 col-xs-12">{{trans('news.news_management')}} &raquo; {{trans('news.tagName')}}</div>
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

    // prepare the data
    var source<?php echo $jqxPrefix;?> = {
        type: "post",
        dataType: "json",
        data:{"_token":'{{ csrf_token() }}'},
        dataFields: [
            { name: 'Id', type: 'number' },
			{ name: 'name', type: 'string' },
			{ name: 'icon', type: 'string' },
            { name: 'order_number', type: 'number' },
            { name: 'user_name', type: 'string' }
        ],
        id: 'Id',
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

	var icon<?php echo $jqxPrefix;?> = function (row, datafield, value) {
        var asset;
		if(value == ''){
			asset = '<?php echo asset('/'); ?>images/default.png';
        }else{
			asset = '<?php echo asset('/'); ?>/' + value;
		}
        return '<div style="text-align: center; margin-top:1px;"><img width="50" height="50"  src="' + asset + '" /></div>';
    };
    $(document).ready(function () {
		//Button action
		var buttons = ['btn-new','btn-edit','btn-delete'];
        initialButton(buttons,90,30);

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
                    { text: '{{trans('news.image')}}', filterable:false,dataField: 'icon', width: '5%',align:'center',cellsrenderer: icon<?php echo $jqxPrefix;?>,enabletooltips:false},
                    { text: '{{trans('news.tagName')}}', dataField: 'name', width: '78%' },
                    { text: '{{trans('news.create_by')}}', dataField: 'user_name', width: '10%' },
                    { text: '{{trans('news.order_number')}}', dataField: 'order_number', width: '5%',cellsalign: 'center', align:'center',filterable:false}
                ]
        });

		/* New */
        $("#btn-new").on('click',function(){
            newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}',500,380, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
        });

		/* Edit */
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
                newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonEdit']}}', 500,380, '<?php echo $editUrl;?>', jqxdatarow.Id, '{{ csrf_token() }}');
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
					listId.push(jqxdatarow.Id);
				}
				$('#jqx-grid<?php echo $jqxPrefix;?>').jqxGrid('deleteRow', listId);
			});
        });

    });
</script>
@endsection