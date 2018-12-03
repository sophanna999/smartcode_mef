<?php
$jqxPrefix = '_documents';
$newUrl = asset($constant['secretRoute'].'/tracking/new');
$proUrl = asset($constant['secretRoute'].'/documents/documents-processing');
$listUrl = asset($constant['secretRoute'].'/documents/index');
$editUrl = asset($constant['secretRoute'].'/documents/edit');
$deleteUrl = asset($constant['secretRoute'].'/documents/delete');
?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
		<div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                        <div class="col-lg-12 col-xs-12">គ្រប់គ្រងឯកសារ &raquo; ដំណើរការឯកសារ</div>
                    </div>
                    <div class="pull-right">
                        <div class="col-xs-12">
                            <button id="btn-processing<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-file"></i> {{$constant['buttonDocumentOut']}}</button>
                            <button id="btn-new<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-plus"></i> {{$constant['buttonDocumentIn']}}</button>
                            <button style="display: none;" id="btn-edit<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-edit"></i> {{$constant['buttonEdit']}}</button>
                            <button id="btn-delete<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-trash"></i> {{$constant['buttonDelete']}}</button>
                        </div>
                    </div>
                </div>
                <div id="jqx-grid"></div>
            </div>
        </div>
	</div>
<script type="text/javascript">
        // prepare the data
        var source =
        {
            type: "post",
            dataType: "json",
            data:{"_token":'{{ csrf_token() }}'},
            dataFields: [
                { name: 'id', type: 'number' },
                { name: 'source', type:'string',map:'source>value_kh' },
                { name: 'sender', type:'string' },
                { name: 'flow', type: 'string',map:'flow>value_kh'  }
            ],
			cache: false,
            id: 'id',
            url: '{{ secret_route() }}/tracking/lists',

            beforeprocessing: function(data) {
                source.totalrecords = (data != null)? data.total:0;
            },
            sort: function(data) {
            // Short Data
            $("#jqx-grid").jqxGrid('updatebounddata', 'sort');
            },
            filter: function() {
                $("#jqx-grid").jqxGrid('updatebounddata', 'filter');
            },
            deleteRow: function (rowid, commit) {}
        };
        var numberRenderer = function (row, column, value) {
            return '<div style="text-align: center; margin-top:5px;">' + (1 + value) + '</div>';
        };
        $(document).ready(function () {
			//Button action
			var buttons = ['btn-new<?php echo $jqxPrefix;?>','btn-edit<?php echo $jqxPrefix;?>','btn-delete<?php echo $jqxPrefix;?>','btn-processing<?php echo $jqxPrefix;?>'];
            initialButton(buttons,115,30);

            var dataAdapter = new $.jqx.dataAdapter(source);
            // create Tree Grid
            $("#jqx-grid").jqxGrid({
                    theme:jqxTheme,
                    width:'100%',
                    height:gridHeight,
                    source: dataAdapter,
                    selectionmode: 'checkbox',
                    sortable: true,
                    pageable: true,
					virtualmode: true,
					pagerMode: 'advanced',
					enabletooltips: true,
					rowsheight:rowsheight,
                    pageSize: <?php echo $constant['pageSize'];?>,
                    pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
                    rendergridrows: function(obj) {
                        return obj.data;
                    },
                    columns: [
                        { text: '{{trans('document.source')}}', dataField: 'source', width: '8%' },
                        { text: '{{trans('document.sender')}}', dataField: 'sender', width: '15%' },
						{text: '{{trans('document.flow')}}', dataField: 'flow', width: '8%' ,align:'center',cellsalign: 'center'}
                    ]
            });

            $("#btn-processing<?php echo $jqxPrefix;?>").on('click',function(){
                newJqxItem('<?php echo $jqxPrefix;?>', 'ដំណើរការឯកសារ',1600,1500, '<?php echo $proUrl;?>', 0, '{{ csrf_token() }}');
            });

            $("#btn-new<?php echo $jqxPrefix;?>").on('click',function(){
                newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}',1160,730, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
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
                    newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonEdit']}}', 1500,450, '<?php echo $editUrl;?>', jqxdatarow.id, '{{ csrf_token() }}');
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
						listId.push(jqxdatarow.id);
					}
					$('#jqx-grid<?php echo $jqxPrefix;?>').jqxGrid('deleteRow', listId);
				});
            });
        });
    </script>
@endsection