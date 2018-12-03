<?php
$jqxPrefix = '_officer_checkin';
$listUrl = asset($constant['secretRoute'] . '/officer-checkin-report/index');
$detailUrl = asset($constant['secretRoute'] . '/officer-checkin-report/detail/'.$officer_id);
$importUrl = asset($constant['secretRoute'] . '/officer-checkin-report/detail');
?>
@extends('layout.back-end')
@section('content')
	<div id="content-container" class="content-container">
		<div class="panel">
			<div class="row panel-heading custome-panel-headering">
				<div class="form-group title-header-panel">
					<div class="pull-left">
						<div class="col-lg-12 col-xs-12">
							{{$constant['attendance-manager']}} &raquo; {{trans('officer.attendance')}} &raquo; {{$username}}
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
			data: {"_token": '{{ csrf_token() }}',"id":'{{$officer_id}}'},
			dataFields: [],
			id: 'Id',
			url: '{{url($detailUrl)}}',
			beforeprocessing: function (data) {
				count_data_export = data.total;
				data_form_export = JSON.stringify(data.dataForm);
				$("#count_data_export").val(count_data_export);
				$("#data_form_export").val(data_form_export);
				source<?php echo $jqxPrefix;?>.totalrecords = (data != null) ? data.total : 0;
			},
			filter: function () {
				$("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('updatebounddata', 'filter');
			},
			viewDetail: function (rowid, commit) {
				commit(true);
			}
		};

		var renderMonth = function (row, datafield, value) {
			return "TST"
		}

		$(document).ready(function () {
			//Button action
			var buttons = [];
			initialButton(buttons, 120, 30);
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
				source: dataAdapter,
				sortable: false,
				ready: function () {
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
				closeablegroups: true,
				showgroupsheader: false,
				groupable: true,
				groupsexpandedbydefault: true,
				columns: [
					{text: '{{trans("months.month")}}', dataField: 'month', hidden:true},
					{text: '{{trans("months.day")}}', filterable: false, dataField: 'day', width: '20%'},
					{text: '{{trans("attendance.morning_in")}}', filterable: false, dataField: 'morning_in', width: '20%'},
					{text: '{{trans("attendance.morning_out")}}', filterable: false, dataField: 'morning_out', width: '20%'},
					{text: '{{trans("attendance.evening_in")}}', filterable: false, dataField: 'evening_in', width: '20%'},
					{text: '{{trans("attendance.evening_out")}}', filterable: false, dataField: 'evening_out', width: '20%'}
				],
				groups: ['month']
			});
		});
	</script>
@endsection