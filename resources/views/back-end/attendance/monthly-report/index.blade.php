<?php
$jqxPrefix = '_monthly_report';
$searchUrl = asset($constant['secretRoute'].'/monthly-report/search');
$printUrl = asset($constant['secretRoute'].'/monthly-report/print');
$getOfficeByDepartmentUrl = asset($constant['secretRoute'].'/officer-checkin/get-office-by-department-id');
?>
@extends('layout.back-end')
@section('content')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<style>
#ContentPanel{
	overflow-y: scroll;
}
a{
    text-decoration:none !important;
}
a.previous:hover,a.next:hover {
    background-color: #ddd;
    color: black;
	cursor:pointer;
	text-decoration: none;
}

.previous {
    background-color: #f1f1f1;
    color: black;	
    display: inline-block;
    padding: 8px 16px;
}

.next {
    background-color: #4CAF50;
    color: white;
    display: inline-block;
    padding: 8px 16px;
}
.top-title{
	 vertical-align: middle !important;
}
.button-print {
	background-color: #0044cc;
    color: white;
    display: inline-block;
    padding: 6px 18px;
	border-radius: 3px;
	text-decoration: none;
}
a.button-print:hover {
	background-color: #0044cc;
	text-decoration: none;
	cursor:pointer;
	color :white; 
}
td {
	vertical-align: middle !important;
}

</style>
<?php $countTwodays = 0; ?>
@if(!empty($allOfficer))
	@foreach($allOfficer as $key => $value)
		@if(count($value->twoDays) > 0)
			<?php $countTwodays = count($value->twoDays); ?>
		@endif
		<?php $offices = $key; ?>
	@endforeach
	<?php $all = $offices + 1;?>
@endif
<div id="content-container" class="content-container">
    <div class="panel">
        <div class="row panel-heading custome-panel-headering">
            <div class="form-group title-header-panel">
                <div class="pull-left">
                    <div class="col-lg-12 col-xs-12">{{$constant['attendance-manager']}} &raquo; {{trans('officer.monthly_report')}} </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xs-12">
            <form class="form-horizontal" id="attendanceForm" role="form" method="put" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
               	<input type="hidden" name="start_dt" id="start_dt" value="">
                <input type="hidden" name="end_dt" id="end_dt" value="">
                <table class="table table-bordered">
                <thead>
                <tr>
                    <th>{{trans('officer.department')}}</th>
                    <!-- <th>{{trans('officer.office')}}</th> -->
                    <th>{{trans('officer.date')}}</th>                    
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="hidden" id="mef_department_id" name="mef_department_id" value="{{isset($mef_department_id)?$mef_department_id:''}}">
                        <div id="div_mef_department_id"></div>
                    </td>
                    <!-- <td>
                        <input type="hidden" id="mef_office_id" name="mef_office_id" value="{{isset($mef_office_id)?$mef_office_id:''}}">
                        <div id="div_mef_office_id"></div>
                    </td> -->
					<td>
                        <div id="div_jqxcalendar_id"></div>

                    </td>
                </tr>

                <tr>
                    <td colspan="6">
						<button id="btn-search<?php echo $jqxPrefix;?>" type="button"><i class="glyphicon glyphicon-search"></i> {{trans('trans.buttonSearch')}} {{trans('officer.attendance')}}</button>
						<?php
							$param='';
							if(isset($mef_department_id)){
								$param .= '&mef_department_id='.$mef_department_id;
							}
							if(isset($mef_office_id)){
								$param .= '&mef_office_id='.$mef_office_id;
							}
							if(isset($start_dt)){
								$param .= '&start_dt='.$start_dt;
							}
							if(isset($end_dt)){
								$param .= '&end_dt='.$end_dt;
							}
							// var_dump($param);
						?>
						<a href="{{ $printUrl.'?'.$param }}" target="_blank" class="button-print" id="button-print"><i class="glyphicon glyphicon-print"></i> {{trans('officer.print')}}</a>
                    </td>
                </tr>
                </tbody>
            </table>
            </form>
        </div>
    </div>
</div>
@if(!empty($allOfficer) && $countTwodays > 0)
<div class="text-right" style="padding-right:15px;">
		<a id="prev" class="previous">&#8249; {{trans('trans.buttonPrev')}}</a>
		<a id="next" class="next">{{trans('trans.buttonNext')}} &#8250;</a>
</div>
@endif
<?php 
	$listData = isset($listData) ? $listData:'';
?>
@if($listData != '')
	<div id="present-of-week" style="padding-left:15px;padding-right:15px;">
	<table class="table table-bordered">
		<thead>
			<tr>
			  <th rowspan="3" class="text-center top-title">ល.រ </th>
			  <th rowspan="3" class="text-center top-title">ឈ្មោះ</th>
			  <th rowspan="3" class="text-center top-title">ភេទ</th>
			  <th rowspan="3" class="text-center top-title">តួនាទី</th>
			  <th rowspan="3" class="text-center top-title">ចំនួនសរុបនៃអវត្ដមាន</th>
			  <th colspan="8" class="threeDays text-center">មូលហេតុអវត្ដមាន</th>
			  <th rowspan="3" class="text-center top-title">ចំនួនថ្ងៃឈប់សម្រាកដែលនៅសល់</th>
			</tr>
			<tr>
			  <th rowspan="2" class="text-center top-title">ឥតច្បាប់ </th>
			  <th colspan="5" class="text-center top-title">ច្បាប់ </th>
			  <th rowspan="2" class="text-center top-title">បេសកកម្ម </th>
			  <th rowspan="2" class="text-center top-title">សុំឈប់ឬស្លាប់ឬផ្លាស់ចេញ </th>
			</tr>
			<tr>
			  <th  class="text-center top-title">រយៈពេលខ្លី</th>
			  <th class="text-center top-title">ប្រចាំឆ្នាំ</th>
			  <th class="text-center top-title">មាតុភាព</th>
			  <th class="threeDays text-center">ព្យាបាលជម្ងឺ</th>
			  <th  class="threeDays text-center">កិច្ចការផ្ទាល់ខ្លួន</th>
			  
			</tr>
		</thead>

			<tbody class="threeDays">

				@foreach ( $listData as $key =>$val )

				<?PHP
					$totalAttendance = $val->totalAbsence + $val->shortPermission + $val->yearPermission + $val->pegent + $val->sick + $val->busy + $val->mission;

					if($val->LEVEL_STATUS == 1){
						$numOfDayOf = 30 - $totalAttendance;
					}elseif ($val->LEVEL_STATUS == 2 || $val->positionId == 19) {
						$numOfDayOf = 15 - $totalAttendance;
					}elseif ($val->LEVEL_STATUS == 0 && $val->positionId == 20) {
						$numOfDayOf = 18 - $totalAttendance;
					}
				?>
				<tr>
					<td class="text-center top-title">{{$key + 1}} </td>
					<td class="text-center top-title">{{$val->FULL_NAME_KH}} </td>
					<td class="text-center top-title">{{$val->gender}} </td>
					<td class="text-center top-title">{{$val->positionName}} </td>
					<td class="text-center top-title">{{$tool->khmerNumber($totalAttendance)}} ថ្ងៃ </td>
					<td class="text-center top-title">{{$tool->khmerNumber($val->totalAbsence)}} ថ្ងៃ </td>
					<td class="text-center top-title">{{$val->shortPermission !='' ? $tool->khmerNumber($val->shortPermission):''}} {{isset($val->shortPermission) ? 'ថ្ងៃ':''}} </td>
					<td class="text-center top-title">{{$val->yearPermission!='' ? $tool->khmerNumber($val->yearPermission):''}} {{isset($val->yearPermission) ? 'ថ្ងៃ':''}}</td>
					<td class="text-center top-title">{{$val->pegent !='' ? $tool->khmerNumber($val->pegent):''}} {{isset($val->pegent) ? 'ថ្ងៃ':''}}</td>
					<td class="text-center top-title">{{$val->sick!='' ? $tool->khmerNumber($val->sick):''}} {{isset($val->sick) ? 'ថ្ងៃ':''}}</td>
					<td class="text-center top-title">{{$val->busy!='' ? $tool->khmerNumber($val->busy):''}} {{isset($val->busy) ? 'ថ្ងៃ':''}}</td>
					<td class="text-center top-title">{{$val->mission!='' ? $tool->khmerNumber($val->mission):''}} {{isset($val->mission) ? 'ថ្ងៃ':''}}</td>
					<td class="text-center top-title"> </td>
					<td class="text-center top-title">{{isset($numOfDayOf) ? $tool->khmerNumber($numOfDayOf):''}} ថ្ងៃ</td>
				</tr>
				@endforeach
			</tbody>
	</table>
</div>
@endif



<script type="text/javascript">
	function validationFildInput(){
		var count = 0;
		var div_mef_department_id = $('#div_mef_department_id').val();
		if(div_mef_department_id == '' || div_mef_department_id == 0){
				$('#div_mef_department_id').addClass('jqx-validator-error-element');
				count = count + 1;
		} else {
				$('#div_mef_department_id').removeClass('jqx-validator-error-element');
		}
		var div_mef_office_id = $('#div_mef_office_id').val();
		if(div_mef_office_id == '' || div_mef_office_id == 0){
				$('#div_mef_office_id').addClass('jqx-validator-error-element');
				count = count + 1;
		} else {
				$('#div_mef_office_id').removeClass('jqx-validator-error-element');
		}
		return count;
	}
	
	$('#div_mef_department_id').on('change', function (event){ 
		$('#button-print').hide();
	});
	
	$('#div_mef_office_id').on('change', function (event){ 
		$('#button-print').hide();
	});
    
	// prepare the data
    $(document).ready(function () {
        initialButton(['btn-search<?php echo $jqxPrefix;?>'],150,30);
        /* Department */
        initDropDownList('bootstrap', 300,35, '#div_mef_department_id', <?php echo $listDepartment;?>, 'text', 'value', false, '', '0', "#mef_department_id","{{$constant['buttonSearch']}}",300);


        /*calendar*/
        $("#div_jqxcalendar_id").jqxDateTimeInput({ width: 300, height: 30,selectionMode: 'range',formatString: "yyyy-MM-dd" });
        
        
        // $("#div_jqxcalendar_id").jqxDateTimeInput('setRange', start_dt, end_dt);

		var departmentId = $('#mef_department_id').val();
		var start_dt = $('#start_dt').val();
		var end_dt = $('#end_dt').val();

		var departmentId = $('#mef_department_id').val();
		var officeId = $('#mef_office_id').val();
		if(departmentId != '' && departmentId != 0 && officeId != '' && officeId != 0){
			$('#button-print').show();
		} else {
			$('#button-print').hide();
		}
		
		var full_date = $("#div_jqxcalendar_id").val();
		console.log(full_date);
		$('#start_dt').val(full_date.substring(0, 10));
		$('#end_dt').val(full_date.substring(0, 10));
		
        $("#div_jqxcalendar_id").on('change', function (event) {
			$('#button-print').hide();
            var selection = $("#div_jqxcalendar_id").jqxDateTimeInput('getRange');
            if (selection.from != null) {
            	// console.log(selection.from.toJSON());
    //         	var startDate = selection.from.toJSON().split("T");
				// var endDate = selection.to.toJSON().split("T");
                $('#start_dt').val(selection.from.toJSON().split("T"));
                $('#end_dt').val(selection.to.toJSON());               
            }
        });

        $("#btn-search<?php echo $jqxPrefix;?>").click(function(){
			var count = validationFildInput();
			if(count > 0){
				return;
			}
            $('#attendanceForm').attr('action', "{{$searchUrl}}").submit();
			

        });
		
		$('.twoDays').hide();
		$("#next").click(function(){
			$('.threeDays').hide();
			$('.twoDays').show();
		});

		$("#prev").click(function(){
			$('.threeDays').show();
			$('.twoDays').hide();
		});	
	});
</script>
@endsection