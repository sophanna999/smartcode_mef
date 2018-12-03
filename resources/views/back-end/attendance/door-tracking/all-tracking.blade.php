<?php
$jqxPrefix = '_user';
$listUrl = asset($constant['secretRoute'].'/all-tracking/index');
?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
		<div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                        <div class="col-lg-2 col-md-2"> ប្រតិបត្តិការទាំងអស់</div>
                        <div class="col-lg-4 col-md-4">
							<input type="hidden" id="from-date-value" value="">
							<div id="jqx-from-date"></div>
						</div>
						<div class="col-lg-4 col-md-4">
							<input type="hidden" id="officer_id" value="">
							<div id="mef_officer_id"></div>
						</div>
                        <div class="col-lg-2 col-md-2">
                            <button id="btn-search"><i class="glyphicon glyphicon-search"></i> {{$constant['buttonSearch']}}</button>
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
            { name: 'id', type: 'number' },
            { name: 'officer_name', type: 'string' },
            { name: 'dates', type: 'string' },
			{ name: 'time_out', type: 'string' },
            { name: 'time_in', type: 'string' },
			{ name: 'mef_user_id', type: 'string' },
            { name: 'detail', type: 'string' }
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
        }
    };
    var numberRenderer<?php echo $jqxPrefix;?> = function (row, column, value) {
        return '<div style="text-align: center; margin-top:5px;">' + (1 + value) + '</div>';
    };
    var initialSearch = function () {
        var dateValue = $("#from-date-value").val();
		var string = dateValue.split('/');
		var date = string.length > 1 ? string[2]+'-'+string[1]+'-'+string[0]:'';
		var officer_id = $('#officer_id').val();
        if (date != '' || officer_id != '') {
			
			/* Filter by date*/
            var dateFilterGroup = new $.jqx.filter();
            dateFilterGroup.operator = 'or';
            var dateFilter = dateFilterGroup.createfilter('stringfilter', date, 'EQUAL');
            dateFilterGroup.addfilter(3, dateFilter);
            $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('addfilter', 'dates', dateFilterGroup);
			
			/* Filter by Officer*/
            var officerFilterGroup = new $.jqx.filter();
            officerFilterGroup.operator = 'or';
            var officerFilter = officerFilterGroup.createfilter('stringfilter', officer_id, 'EQUAL');
            officerFilterGroup.addfilter(3, officerFilter);
            $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('addfilter', 'mef_user_id', officerFilterGroup);
			
            //apply filter
            $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('applyfilters');
        }else {
            $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('clearfilters');
        }
    }
	var initialDate = function (divDateContainer,hiddenDate) {
		$('#'+divDateContainer).jqxDateTimeInput({
			theme: jqxTheme,
			width: '200px',
			height: '30px',
			formatString: 'dd/MM/yyyy',
			animationType: 'fade',
			todayString:'Today',
			showFooter:true
		});
		$('#'+hiddenDate).val($('#'+divDateContainer).val());
		$('#'+divDateContainer).on('change', function () {
			$('#'+hiddenDate).val($('#'+divDateContainer).val());
		});
	}
    $(document).ready(function () {
		//Button action
		var buttons = ['btn-search'];
        initialButton(buttons,80,30);
		
		/*Date*/
		initialDate('jqx-from-date','from-date-value');
		
		/* All officer */
		initDropDownList(jqxTheme, 200,30, '#mef_officer_id', <?php echo $allOfficer;?>, 'text', 'value', false, '', '0', '#officer_id','ឈ្មោះមន្រ្តី',500);
		
		
		//Search button & enter key
        $('#btn-search').on('click',function(){
            initialSearch();
        });
        var dataAdapter = new $.jqx.dataAdapter(source<?php echo $jqxPrefix;?>);
        // create Tree Grid
        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid({
                theme:jqxTheme,
                width:'100%',
                height:gridHeight,
				rowsheight:35,
                source: dataAdapter,
                sortable: false,
                pageable: true,
                pagerMode: 'advanced',
                columnsresize: true,
                filterable: false,
                enabletooltips: false,
                pageSize: <?php echo $constant['pageSize'];?>,
                pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
                virtualmode: true,
				closeablegroups:false,
                showgroupsheader: false,
                groupable:true,
                groupsexpandedbydefault: false,
                groups: ['officer_name'],
                rendergridrows: function(obj) {
                    return obj.data;
                },
                columns: [
					{ text: '', datafield: 'mef_user_id', hidden: true},
					{ text: '{{$constant['OfficerName']}} ', dataField: 'officer_name', width: '25%'},
					{ text: '{{$constant['dayMonthYear']}}', dataField: 'dates', width: '9%',groupable:false},
					{ text: '{{$constant['timeIn']}}', dataField: 'time_in', width: '8%',groupable:false},
					{ text: '{{$constant['timeOut']}}', dataField: 'time_out', width: '8%',groupable:false},
					{ text: '{{$constant['trackingDescription']}}', dataField: 'detail', width: '50%',groupable:false}
                ]
        });

    });
</script>
@endsection