<?php
$jqxPrefix = '_central';
$newUrl = asset($constant['secretRoute'].'/central-ministry/new');
$editUrl = asset($constant['secretRoute'].'/central-ministry/edit');
$listUrl = asset($constant['secretRoute'].'/central-ministry/index');
$deleteUrl = asset($constant['secretRoute'].'/central-ministry/delete');

?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
		<div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                    <div class="col-lg-6 col-xs-12">{{trans('users.systemSetting')}} &raquo; {{trans('officer.centralMinistry')}}</div>
                           
                </div>
                <div class="pull-right">
                    <div class="col-xs-12">
                        <button id="btn-new<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-plus"></i> {{$constant['buttonNew']}}</button>
                        <button id="btn-edit<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-edit"></i> {{$constant['buttonEdit']}}</button>
                        <button id="btn-delete<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-trash"></i> {{$constant['buttonDelete']}}</button>
                    </div>
                </div>
                </div>
				
            </div>
			<div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
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
			{ name: 'Name', type: 'string' },
			{ name: 'Abbr', type: 'string' }
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
                    if(response.code == 1) {
                        closeJqxWindowId('jqxwindow<?php echo $jqxPrefix;?>');
                        $('#jqx-notification').jqxNotification({position: positionNotify,template: "warning"}).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }else{
                        $('#jqx-notification').jqxNotification({position: positionNotify,template: "warning",autoClose: false}).html(response.message);
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
    var numberRenderer<?php echo $jqxPrefix;?> = function (row, column, value) {
        return '<div style="text-align: center; margin-top: 5px;">' + (1 + value) + '</div>';
    };
    var active<?php echo $jqxPrefix;?> = function (row, datafield, value) {
        return value == 0 ? '<div style="text-align: center; margin-top:5px;"><i class="glyphicon glyphicon-remove"></i></div>':'<div style="text-align: center; margin-top:5px;"><i class="glyphicon glyphicon-ok"></i></div>';
    };
    var status<?php echo $jqxPrefix;?> = function (row, datafield, value) {
        return value == 0 ? '<div style="text-align: center; margin-top:5px;"><i class="glyphicon glyphicon-remove"></i></div>':'<div style="text-align: center; margin-top:5px;"><i class="glyphicon glyphicon-ok"></i></div>';
    };
	
    $(document).ready(function () {
		//Button action
		var buttons = ['btn-new<?php echo $jqxPrefix;?>','btn-edit<?php echo $jqxPrefix;?>','btn-delete<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);

        var dataAdapter = new $.jqx.dataAdapter(source<?php echo $jqxPrefix;?>);
        // create Tree Grid
        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid({
                theme:jqxTheme,
                width:'100%',
                height:gridHeight,
                source: dataAdapter,
                selectionmode: 'checkbox',
                sortable: true,
                pageable: true,
                pagerMode: 'advanced',
				enabletooltips: true,
				rowsheight:rowsheight,
                pageSize: <?php echo $constant['pageSize'];?>,
                pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
                virtualmode: true,
                rendergridrows: function(obj) {
                    return obj.data;
                },
                columns: [
                    { text: '{{trans('officer.centralMinistry')}}', dataField: 'Name', width: '83%' },
					{ text: '{{$constant['abbreviation']}}', dataField: 'Abbr', width: '15%' },
                ]
        });

       
        $("#btn-new<?php echo $jqxPrefix;?>").on('click',function(){
            newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}',500,220, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
        });

        $("#btn-edit<?php echo $jqxPrefix;?>").on('click',function(){
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
                newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonEdit']}}', 500,200, '<?php echo $editUrl;?>', jqxdatarow.Id, '{{ csrf_token() }}');
            }

        });
        $("#btn-delete<?php echo $jqxPrefix;?>").click(function(){
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