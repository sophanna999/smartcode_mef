<div class="container-fluid">
	<table class="table table-responsive table-bordered" id="download-report-detail">
		<thead>
		<tr>
			<th valign="middle" align="center" class="text-center" colspan="4" style="font-family: 'Khmer MEF1';font-weight: normal;">{{trans('attendance.report_attendance')}} {{$date_string}}</th>
		</tr>
		<tr>
			<th valign="middle" align="center" class="text-center"  colspan="4" style="font-family: 'Khmer MEF1';font-weight: normal;">អង្គភាព ៖ {{$department_name->department_name}}</th>
		</tr>
		<tr>
			<th valign="middle" align="center" class="text-center"  colspan="4" style="font-family: 'Khmer MEF1';font-weight: normal;">{{trans('attendance.OfficerName')}} ៖ {{$officer_name->FULL_NAME_KH}}</th>
		</tr>
		<tr style="font-family: 'Khmer MEF1';">
			<th valign="middle" align="center" width="5%" class="text-center" style="background: #DFF0D8;">{{trans('trans.autoNumber')}}</th>
			<th valign="middle" align="center" width="10%" style="background: #DFF0D8;">{{trans('attendance.timeIn')}}</th>
			<th valign="middle" align="center" width="10%" style="background: #DFF0D8;">{{trans('attendance.timeOut')}}</th>
			<th valign="middle" align="center" width="75%" style="background: #DFF0D8;">{{trans('attendance.trackingDescription')}}</th>
		</tr>
		</thead>
		<tbody>
		@foreach($data as $key=>$row)
			<tr style="font-family: 'Khmer MEF1'">
				<td class="text-center" valign="middle" align="center">{{$key+1}}</td>
				<td>{{$row->time_in != null ? $row->time_in:''}}</td>
				<td>{{$row->time_out != null ? $row->time_out:''}}</td>
				<td>{{$row->detail != null ? $row->detail:''}}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="pull-right"><a type="button" class="btn btn-primary btn-sm" id="export-excel">{{trans('attendance.download_report')}}</a></div>
</div>
<script>
    $(document).ready(function () {
		/* Export data into Excel*/
        $("#export-excel").click(function () {
            var reportType = 'report';
            var blobURL = tableToExcel('download-report-detail', reportType);
            $(this).attr('download',reportType+'.xls');
            $(this).attr('href',blobURL);
        });
    });
</script>