<?php
$jqxPrefix = '_metting_pending';
$newUrl = asset($constant['secretRoute'].'/meeting-pending/approve');
$listUrl = asset($constant['secretRoute'].'/meeting-pending/index');
$deleteUrl = asset($constant['secretRoute'].'/meeting/delete');
$listAttendeeUrl = asset($constant['secretRoute'].'/meeting/list-attendee');
$modalExport = asset($constant['secretRoute'].'/meeting/modal-export');
$editUrl = asset($constant['secretRoute'].'/meeting-pending/approve');
?>
@extends('layout.back-end')
@section('content')
	<div id="content-container" class="content-container">
		<div class="panel">
			<div class="row panel-heading custome-panel-headering">
				<div class="form-group title-header-panel">
					<div class="pull-left">
						<div class="col-lg-12">{{trans('schedule.schedule')}} &raquo;  {{trans('schedule.meeting_pending')}}</div>
					</div>
					<div class="pull-right">
						<div class="col-lg-12 col-xs-12">
							<button id="btn-approve"><i class="glyphicon glyphicon-ok-sign"></i> {{trans('officer.approve')}}</button>
						</div>
					</div>
				</div>
				<div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var width_form = 1000;
		var height_form = $(window).height() - 50;
		// prepare the data
		var source<?php echo $jqxPrefix;?> =
			{
				type: "post",
				dataType: "json",
				data:{"_token":'{{ csrf_token() }}'},
				dataFields: [
					{ name: 'Id', type: 'number' },
					{ name: 'meeting_date', type: 'date' },
					{ name: 'meeting_time', type: 'string' },
					{ name: 'meeting_objective', type: 'string' },
					{ name: 'meeting_location', type: 'string' },
					{ name: 'meeting_leader_name', type: 'string' },
					{ name: 'all', type: 'number'},
					{ name: 'create_by_user', type: 'string' },
					{ name: 'public', type: 'string' }
				],
				id: 'id',
				url: '{{$listUrl}}',
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
						data: {"Id":rowid,"_token":'{{ csrf_token() }}'},
						success: function (response, status, xhr) {
							$("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('updatebounddata');
							$("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('clearselection');
							$("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
							if(response.code == 0) {
								//Some items delete execpt the one in used
								$('#jqx-notification').jqxNotification({position:positionNotify}).html(response.message);
								$("#jqx-notification").jqxNotification("open");
							}else if(response.code == 1){
								//Item in used
								$('#jqx-notification').jqxNotification({position:positionNotify,template: "warning"}).html(response.message);
								$("#jqx-notification").jqxNotification("open");
							}else{
								//Items delete success
								closeJqxWindowId('jqxwindow<?php echo $jqxPrefix;?>');
								$('#jqx-notification').jqxNotification({ position:positionNotify, template: "success" }).html(response.message);
								$("#jqx-notification").jqxNotification("open");
							}
						},
						error: function (request, textStatus, errorThrown) {
							console.log(errorThrown);
						}
					});
				}
			};
		var isPublic = function (row, datafield, value) {
			return value == 0 ? '<div style="text-align: center; margin-top: 10px;"><i class="glyphicon glyphicon-remove"></i></div>':'<div style="text-align: center; margin-top:10px;"><i class="glyphicon glyphicon-ok"></i></div>';
		};
		$(document).ready(function () {
			//Button action
			var buttons = ['btn-approve'];
			initialButton(buttons,105,30);

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
				showfilterrow: true,
				filterable: true,
				pageSize: <?php echo $constant['pageSize'];?>,
				pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
				rendergridrows: function(obj) {
					return obj.data;
				},
				columns: [
					{ text: '{{trans('schedule.meeting_date')}}', dataField: 'meeting_date', width: '9%',filterable: true,filtertype: 'date',cellsformat: 'dd/MM/yyyy' },
					{ text: '{{trans('schedule.meeting_time')}}', dataField: 'meeting_time', width: '8%' },
					{ text: '{{trans('schedule.meeting_leader')}}', dataField: 'meeting_leader_name', width: '18%' },
					{ text: '{{trans('schedule.meeting_purpose')}}', dataField: 'meeting_objective', width: '42%' },
					{ text: '{{trans('schedule.meeting_location')}}', dataField: 'meeting_location', width: '15%' },
					{ text: '{{trans('news.create_by')}}', dataField: 'create_by_user', width: '10%' },
					{ text: '{{trans('schedule.public')}}', dataField: 'public', width: '5%',cellsrenderer: isPublic,enabletooltips: false,filtertype: 'list',filteritems:['{{trans('schedule.public')}}','{{trans('schedule.private')}}'],createfilterwidget: function(column, columnElement, widget){widget.jqxDropDownList({ dropDownWidth: 90 });},filterable: false },
					{text: '{{trans('schedule.meeting_participant')}}',filterable:false,sortable: false, dataField: 'atendee_id', width: '7%',editable: false,
						cellsrenderer: function (row, datafield, value) {
							return "{{trans('trans.detailInfo')}}";
						}, columntype: 'button',
						buttonclick: function (row) {
							var dataRecord = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
							var width = 1024;
							var height = 600;
							if(dataRecord.all == 1){
								width = 450;
								height = 80;
							}
							newJqxItem('{{$jqxPrefix}}', '{{trans('schedule.meeting_list_participant')}}',width,height, '{{$listAttendeeUrl}}', dataRecord.Id, '{{ csrf_token() }}');
						}
					}
				]
			});


			$("#btn-approve").on('click',function(){
				var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
				$("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
				if(row.length == 0){
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({ position:positionNotify,template: "warning" }).html('{{trans('schedule.not_select')}}');
					$("#jqx-notification").jqxNotification("open");
					return false;
				}else if(row.length > 1){
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({ position:positionNotify,template: "warning" }).html('{{$constant['selectOneRow']}}');
					$("#jqx-notification").jqxNotification("open");
					return false;
				}else{
					var jqxdatarow = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
					newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonEdit']}}', width_form, height_form, '<?php echo $editUrl;?>', jqxdatarow.Id, '{{ csrf_token() }}');
				}

			});
			$("#btn-delete").click(function(){
				var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
				if(row.length == 0){
					$("#jqx-notification").jqxNotification();
					$('#jqx-notification').jqxNotification({ position:positionNotify,template: "warning" }).html('{{$constant['deleteRow']}}');
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

			/* Export Excel */
			$("#btn-export").on('click',function(){
				newJqxItem('<?php echo $jqxPrefix;?>', '{{trans('trans.export')}}',410,250, '<?php echo $modalExport;?>', 0, '{{ csrf_token() }}');
			});
			/* Export Excel End */

		});
	</script>
@endsection