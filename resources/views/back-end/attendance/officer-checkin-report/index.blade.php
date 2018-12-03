<?php
$jqxPrefix = '_officer_checkin';
$listUrl = asset($constant['secretRoute'] . '/officer-checkin-report/index');
$detailUrl = asset($constant['secretRoute'] . '/officer-checkin-report/detail');
$importUrl = asset($constant['secretRoute'] . '/officer-checkin-report/detail');
?>
@extends('layout.back-end')
@section('content')
	<div id="content-container" class="content-container">
		<div class="panel">
			<div class="row panel-heading custome-panel-headering">
				<div class="form-group title-header-panel">
					<div class="pull-left">
						<div class="col-lg-6 col-xs-12">
							{{$constant['attendance-manager']}} &raquo; {{trans('officer.attendance')}}
						</div>
						<div class="col-lg-6 col-xs-12">
							<div class="form-group">
								<input type="text" name="year" id="year" multiple class="form-control" placeholder="year">
							</div>
						</div>
					</div>
					<div class="pull-right">
	                    <div class="col-lg-6 col-xs-6">
	                        <!-- <button id="btn-export<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-edit"></i> {{trans('attendance.note')}}</button> -->
	                    </div>
	                </div>
				</div>
				<div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
			</div>
		</div>
	</div>
	<style>
		#detail-body {
			overflow-x: hidden;
			overflow-y: auto;
			font-family: 'KHMERMEF1';
		}

		.search-options {
			position: relative;
			top: 2px;
			height: 40px;
			border-bottom: 1px solid #E8E8E8;
			background: #f5f5f5;
			padding-top: 2px;
			margin-bottom: -14px;
		}

		.labels-officer-checkin {
			top: 10px;
		}

		.table > thead > tr > th {
			border-bottom: 1px solid #ddd;
		}
	</style>
	<script type="text/javascript">
		var width = $(window).width();
		var height = $(window).height();
		// prepare the data
		var source<?php echo $jqxPrefix;?> = {
			type: "post",
			dataType: "json",
			data: {"_token": '{{ csrf_token() }}'},
			dataFields: [],
			id: 'Id',
			url: '<?php echo $listUrl;?>',
			beforeprocessing: function (data) {
				count_data_export = data.total;
				data_form_export = JSON.stringify(data.dataForm);
				$("#count_data_export").val(count_data_export);
				$("#data_form_export").val(data_form_export);
				source<?php echo $jqxPrefix;?>.totalrecords = (data != null) ? data.total : 0;
			},
			sort: function (data) {
				// Short Data
				$("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('updatebounddata', 'sort');
			},
			filter: function () {
				$("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('updatebounddata', 'filter');
			},
			viewDetail: function (rowid, commit) {
//				console.log()
				commit(true);
			}
		};
		
		var avatar<?php echo $jqxPrefix;?> = function (row, datafield, value) {
			var asset;
			if (value == '') {
				asset = '{{asset("images/photo-default.jpg")}}';
			} else {
				asset = '<?php echo asset('/'); ?>' + value;
			}
			return '<div style="text-align: center; margin-top:3px;"><img width="45" height="45"  src="' + asset + '" /></div>';
		};

		var button = function (row, datafield, value) {
			console.log('row => '+row+', data => '+datafield+', val =>  '+value);
			return '<a href="{{url($detailUrl)}}/'+value+'" class="btn btn-default" style="margin-top: 10px; margin-left: 25px;">' +
				'<i class="glyphicon glyphicon-eye-open"></i></a>';
		}
		$(document).ready(function () {
			//Button action
			var buttons = ['btn-export{{$jqxPrefix}}'];
			// initialButton(buttons, 120, 30);
			var dataAdapter = new $.jqx.dataAdapter(source<?php echo $jqxPrefix;?>);
			var applyFilter = function (datafield) {
				var filtertype = 'numericfilter';
				var filtergroup = new $.jqx.filter();
				var filter_or_operator = 0;
				var filtervalue = datafield;
				var filtercondition = 'CONTAINS';
				var filter = filtergroup.createfilter(filtertype, filtervalue, filtercondition);
				filtergroup.addfilter(filter_or_operator, filter);
				$("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('addfilter', 'date', filtergroup);
				// apply the filters.
				$("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('applyfilters');
			}

			// create Tree Grid
			$("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid({
				theme: jqxTheme,
				width: '100%',
				height: gridHeight,
				rowsheight: 50,
				source: dataAdapter,
				sortable: true,
				ready: function () {
					$("#year").keypress(function (e) {
						dataField = $('#year').val();
						if (e.which == 13) {
							applyFilter(dataField);
						}
					});
				},
				pageable: true,
				pagerMode: 'advanced',
				showfilterrow: true,
				filterable: true,
				enabletooltips: true,
				pageSize: <?php echo $constant['pageSize'];?>,
				pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
				virtualmode: true,
				rendergridrows: function (obj) {
					return obj.data;
				},
				closeablegroups: false,
				showgroupsheader: false,
				groupable: true,
				groupsexpandedbydefault: true,
				columns: [
					{
						text: '{{trans("officer.avatar")}}',
						filterable: false,
						enabletooltips: false,
						dataField: 'avatar',
						width: '8%',
						align: 'center',
						cellsrenderer: avatar<?php echo $jqxPrefix;?>
					},
					{hidden: true, dataField: 'date'},
					{text: '{{trans("officer.full_name")}}', dataField: 'FULL_NAME_KH', width: '18%'},
					{text: '{{trans("months.jan")}}', filterable: false, dataField: '1', width: '4%'},
					{text: '{{trans("months.feb")}}', filterable: false, dataField: '2', width: '4%'},
					{text: '{{trans("months.mar")}}', filterable: false, dataField: '3', width: '4%'},
					{text: '{{trans("months.apr")}}', filterable: false, dataField: '4', width: '4%'},
					{text: '{{trans("months.may")}}', filterable: false, dataField: '5', width: '4%'},
					{text: '{{trans("months.jun")}}', filterable: false, dataField: '6', width: '4%'},
					{text: '{{trans("months.jul")}}', filterable: false, dataField: '7', width: '4%'},
					{text: '{{trans("months.aug")}}', filterable: false, dataField: '8', width: '4%'},
					{text: '{{trans("months.sep")}}', filterable: false, dataField: '9', width: '4%'},
					{text: '{{trans("months.oct")}}', filterable: false, dataField: '10', width: '4%'},
					{text: '{{trans("months.nov")}}', filterable: false, dataField: '11', width: '4%'},
					{text: '{{trans("months.dec")}}', filterable: false, dataField: '12', width: '4%'},
					{
						text: '{{trans("attendance.permission")}}',
						filterable: false,
						dataField: 'permission',
						align: 'center',
						width: '6%'
					},
					{
						text: '{{trans("attendance.no_permission")}}',
						filterable: false,
						dataField: 'no_permission',
						align: 'center',
						width: '6%'
					},
					{
						text: '{{trans("attendance.total_absence")}}',
						filterable: false,
						dataField: 'total_absence',
						align: 'center',
						width: '8%'
					},
					{
						text: '{{trans("attendance.late")}}',
						filterable: false,
						dataField: 'late',
						align: 'center',
						width: '6%'
					}
					// {
					// 	text: 'Detail',
					// 	filterable: false,
					// 	sortable:false,
					// 	dataField: 'Id',
					// 	width: '6%',
					// 	cellsrenderer: button,
					// 	align: 'center',
					// 	editable: false
					// }
				],
			});

			$("#btn-import<?php echo $jqxPrefix;?>").on('click', function () {
				var selectedrowindex = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindex');
				var rowscount = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getdatainformation').rowscount;
				if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
					var id = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowid', selectedrowindex);
				}
				newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}', width, height, '<?php echo $importUrl;?>', id, '{{ csrf_token() }}');
			});
			// $("#btn-export<?php echo $jqxPrefix;?>").click(function () {
	  //           var gridContent = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('exportdata', 'html');
   //              var newWindow = window.open('', '', 'width=800, height=500'),
   //              document = newWindow.document.open(),
   //              pageContent =
   //                  '<!DOCTYPE html>\n' +
   //                  '<html>\n' +
   //                  '<head>\n' +
   //                  '<meta charset="utf-8" />\n' +
   //                  '<title>jQWidgets Grid</title>\n' +
   //                  '</head>\n' +
   //                  '<body>\n' + gridContent + '\n</body>\n</html>';
   //              document.write(pageContent);
   //              document.close();
   //              newWindow.print();      
	  //       });
		});
	</script>
@endsection