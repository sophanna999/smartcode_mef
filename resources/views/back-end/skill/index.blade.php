<?php
$jqxPrefix = '_skill';
$newUrl = asset($constant['secretRoute'].'/skill/new');
$listUrl = asset($constant['secretRoute'].'/skill/index');
$editUrl = asset($constant['secretRoute'].'/skill/edit');
$deleteUrl = asset($constant['secretRoute'].'/skill/delete');
?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
		<div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                        <div class="col-lg-12 col-xs-12">{{trans('users.systemSetting')}} &raquo; ជំនាញឯកទេស</div>
                    </div>
                    <div class="pull-right">
                        <div class="col-lg-6 col-xs-3">
                            <button id="btn-new<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-plus"></i> {{$constant['buttonNew']}}</button>
                        </div>
                        <div class="col-lg-6 col-xs-3">
                            <button id="btn-edit<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-edit"></i> {{$constant['buttonEdit']}}</button>
                        </div>
                        <!--<div class="col-lg-4 col-xs-3">
                            <button id="btn-delete<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-trash"></i> {{$constant['buttonDelete']}}</button>
                        </div>-->
                    </div>
                </div>

                <div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
            </div>
        </div>
	</div>
	
<script type="text/javascript">
        
	// prepare the data
	var source<?php echo $jqxPrefix;?> =
	{
		type: "post",
		dataType: "json",
		data:{"_token":'{{ csrf_token() }}'},
		dataFields: [
			{ name: 'Id', type: 'number' },
			{ name: 'Name', type:'string' },
			{ name: 'Type', type:'string' },
			{ name: 'Order', type:'number' }
		],
		cache: false,
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
						//Some items delete execpt the one in used
						$('#jqx-notification').jqxNotification({position: positionNotify}).html(response.message);
						$("#jqx-notification").jqxNotification("open");
					}else if(response.code == 1){
						//Item in used
						$('#jqx-notification').jqxNotification({position: positionNotify,template: "warning"}).html(response.message);
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
	var numberRenderer<?php echo $jqxPrefix;?> = function (row, column, value) {
		return '<div style="text-align: center; margin-top:5px;">' + (1 + value) + '</div>';
	};
	var Type<?php echo $jqxPrefix;?> = function (row, datafield, value) {
        return value == 0 ? '':'<div style="text-align: center; margin-top: 5px;"><i class="glyphicon glyphicon-ok"></i></div>';
    };
	$(document).ready(function () {
		//Button action
		var buttons = ['btn-new<?php echo $jqxPrefix;?>','btn-edit<?php echo $jqxPrefix;?>'];
		initialButton(buttons,90,35);
		
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
					{ text: 'ជំនាញឯកទេស', dataField: 'Name', width: '83%' },
					{text: 'លេខរៀង', dataField: 'Order', width: '5%' ,align:'center',cellsalign: 'center'},
					{text: 'កម្រិតរប្បធម៌ទូទៅ', dataField: 'Type', width: '10%' ,cellsrenderer: Type<?php echo $jqxPrefix;?>,cellsalign: 'center', align:'center'}
				]
		});

	   
		$("#btn-new<?php echo $jqxPrefix;?>").on('click',function(){
			newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}',500,250, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
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
				newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonEdit']}}',500,250, '<?php echo $editUrl;?>', jqxdatarow.Id, '{{ csrf_token() }}');
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
			var confirmMsg = confirm("{{$constant['confirmDelete']}}?");
			var listId = [];
			if(confirmMsg){
				for(var index in row){
					var jqxdatarow = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row[index]);
					listId.push(jqxdatarow.Id);
				}
				$('#jqx-grid<?php echo $jqxPrefix;?>').jqxGrid('deleteRow', listId);
			}
		});

	});
</script>
@endsection