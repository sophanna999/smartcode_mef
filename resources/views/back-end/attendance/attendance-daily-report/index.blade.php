<?php
$jqxPrefix = '_present_of_week';
$searchUrl = asset($constant['secretRoute'].'/present-of-week/search');
$printUrl = asset($constant['secretRoute'].'/present-of-week/print');
$weekUrl = asset($constant['secretRoute'].'/present-of-week/check-week');
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
                    <div class="col-lg-12 col-xs-12">{{$constant['attendance-manager']}} &raquo; {{trans('officer.present_of_week')}} </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xs-12">
            <form class="form-horizontal" id="attendanceForm" role="form" method="put" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="start_dt" id="start_dt" value="{{$start_dt}}">
				<input type="hidden" name="end_dt" id="end_dt" value="{{$end_dt}}">
				<input type="hidden" name="full_rang_day" id="full_rang_day" value="{{$start_dt}}-{{$end_dt}}">
				
                <table class="table table-bordered">
                <thead>
                <tr>
                    <th>{{trans('officer.department')}}</th>
                    <th>{{trans('officer.office')}}</th>
                    <th>{{trans('officer.date')}}</th>                    
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="hidden" id="mef_department_id" name="mef_department_id" value="{{isset($mef_department_id)?$mef_department_id:''}}">
                        <div id="div_mef_department_id"></div>
                    </td>
                    <td>
                        <input type="hidden" id="mef_office_id" name="mef_office_id" value="{{isset($mef_office_id)?$mef_office_id:''}}">
                        <div id="div_mef_office_id"></div>
                    </td>
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
						?>
						<a href="{{ $printUrl.'?'.$param }}" target="_blank" class="button-print" id="button-print"><i class="glyphicon glyphicon-print" style="color:#ffffff;"></i> <span style="color:#ffffff;">{{trans('officer.print')}}</span> </a>
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
<div id="present-of-week" style="padding-left:15px;padding-right:15px;">
	<table class="table table-bordered">
	@if(isset($allOfficer) ? $allOfficer : array())
		<thead>
			<tr>
			  <th rowspan="2" class="text-center top-title">ល.រ </th>
			  <th rowspan="2" class="text-center top-title">គោត្តនាមនិងនាម</th>
			  <th rowspan="2" class="text-center top-title">តួនាទី</th>
			  @foreach($allOfficer as $key => $value)
				@if($key == 0)
				@foreach($value->threeDays as $k => $v)
					<?php 
					     $dateSelect = explode('-',$k);
						 $date = $dateSelect[2];
						 $month = $dateSelect[1];
						 $year = $dateSelect[0];
					?>
			
					<th colspan="4" class="threeDays text-center" width="24%">ហត្ថលេខា (ថ្ងៃទី {{$converter->dayFormat($date)}} ខែ {{$converter->monthFormat($month)}} ឆ្នាំ {{$converter->dayFormat($year)}})</th>
				@endforeach
				@foreach($value->twoDays as $k => $v)
					<?php 
					     $dateSelect = explode('-',$k);
						 $date = $dateSelect[2];
						 $month = $dateSelect[1];
						 $year = $dateSelect[0];
					?>
					
					<th colspan="4" class="twoDays text-center" width="24%">ហត្ថលេខា (ថ្ងៃទី {{$converter->dayFormat($date)}} ខែ {{$converter->monthFormat($month)}} ឆ្នាំ {{$converter->dayFormat($year)}})</th>
				@endforeach
				@endif
			  @endforeach
			</tr>
			<tr>
			  @foreach($allOfficer as $key => $value)
				@if($key == 0)
					@foreach($value->threeDays as $k => $v)
						@if(count($v) != 3)
						<th class="threeDays text-center">ព្រឺក</th>
						<th class="threeDays text-center">ល្ងាច</th>
						<th class="threeDays text-center">មកយឺត</th>
						<th class="threeDays text-center">ចេញមុន</th>
						@else
							<th class="threeDays text-center" colspan="4"></th>
						@endif
					@endforeach
				    @foreach($value->twoDays as $k => $v)
						@if(count($v) != 3)
						<th class="twoDays text-center">ព្រឺក</th>
						<th class="twoDays text-center">ល្ងាច</th>
						<th class="twoDays text-center">មកយឺត</th>
						<th class="twoDays text-center">ចេញមុន</th>
						@else
							<th class="twoDays text-center" colspan="4"></th>
						@endif
					@endforeach
				@endif
			  @endforeach
			</tr>
		</thead>
			<tbody class="threeDays">
				@foreach($allOfficer as $key => $value)
					<tr>
						<td class="text-center">{{$key + 1}}</td>
						<td>{{$value->name}}</td>
						<td>{{$value->position}}</td>
						@foreach($value->threeDays as $k => $v)
						@if(count($v) != 3)
						<td class="text-center">{{isset($v['sectionOne']) ? $v['sectionOne'] : ''}}</td>							
						<td class="text-center">{{isset($v['sectionTwo']) ? $v['sectionTwo'] : ''}}</td>
						<td class="text-center">
							<span>{{isset($v['comeLate']['morning']) ? $v['comeLate']['morning'] : ''}}</span>
							<?php $come = isset($v['comeLate']['morning']) ? $v['comeLate']['morning'] : ''; ?>
							@if($come != '')
							<br>
							@endif
							<span>{{isset($v['comeLate']['afternoon']) ? $v['comeLate']['afternoon'] : ''}}</span>
						</td>
						<td class="text-center">
							<span>{{isset($v['leaveFirst']['morning']) ? $v['leaveFirst']['morning'] : ''}}</span>
							<?php $leave = isset($v['leaveFirst']['morning']) ? $v['leaveFirst']['morning'] : ''; ?>
							@if($leave != '')
							<br>
							@endif
							<span>{{isset($v['leaveFirst']['afternoon']) ? $v['leaveFirst']['afternoon'] : ''}}</span>
						</td>
						@else
							@if(count($v) == 3)
								@if($key == 0)
								<td class="text-center" colspan="4" rowspan="{{$all}}" style="border-top: 0px !important;vertical-align: middle;font-family: 'KHMERMEF2';font-size: 16px;">{{$v['val']}}</td>
								@endif
							@endif
						@endif
						@endforeach
					</tr>
				@endforeach
			</tbody>
			<tbody class="twoDays">
				@foreach($allOfficer as $key => $value)
				@if(count($value->twoDays) > 0)
				<tr>
					<td class="text-center">{{$key + 1}}</td>
					<td>{{$value->name}}</td>
					<td>{{$value->position}}</td>
					@foreach($value->twoDays as $ke => $v)
					@if(count($v) != 3)
						<td class="text-center">{{isset($v['sectionOne']) ? $v['sectionOne'] : ''}}</td>							
						<td class="text-center">{{isset($v['sectionTwo']) ? $v['sectionTwo'] : ''}}</td>
						<td class="text-center">
							<span>{{isset($v['comeLate']['morning']) ? $v['comeLate']['morning'] : ''}}</span>
							<?php $come = isset($v['comeLate']['morning']) ? $v['comeLate']['morning'] : ''; ?>
							@if($come != '')
							<br>
							@endif
							<span>{{isset($v['comeLate']['afternoon']) ? $v['comeLate']['afternoon'] : ''}}</span>
						</td>
						<td class="text-center">
							<span>{{isset($v['leaveFirst']['morning']) ? $v['leaveFirst']['morning'] : ''}}</span>
							<?php $leave = isset($v['leaveFirst']['morning']) ? $v['leaveFirst']['morning'] : ''; ?>
							@if($leave != '')
							<br>
							@endif
							<span>{{isset($v['leaveFirst']['afternoon']) ? $v['leaveFirst']['afternoon'] : ''}}</span>
						</td>
					@elseif(count($v) == 3)
						@if($key == 0)
						<td class="text-center" colspan="4" rowspan="{{$all}}" style="font-family: 'KHMERMEF2';border-top: 0px !important;vertical-align: middle;font-size: 16px;">{{$v['val']}}</td>
						@endif
					@endif
					@endforeach
				</tr>
				@endif
				@endforeach
			</tbody>
	@endif
	</table>
</div>

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
    
    function getOfficeByDepartmentId(department_id){
        $.ajax({
            type: "post",
            url : '{{$getOfficeByDepartmentUrl}}',
            datatype : "json",
            data : {"departmentId":department_id,"_token":'{{ csrf_token() }}'},
            success : function(data){
                console.log(data);
                initDropDownList('bootstrap', 300,35, '#div_mef_office_id', data, 'text', 'value', false, '', '0', "#mef_office_id","{{$constant['buttonSearch']}}",300);
            }
        });
    }
	// prepare the data
    $(document).ready(function () {
        initialButton(['btn-search<?php echo $jqxPrefix;?>'],150,30);
        /* Department */
        initDropDownList('bootstrap', 300,35, '#div_mef_department_id', <?php echo $listDepartment;?>, 'text', 'value', false, '', '0', "#mef_department_id","{{$constant['buttonSearch']}}",300);
		$('#div_mef_department_id').bind('select', function () {
            var department_id = $(this).val();
            getOfficeByDepartmentId(department_id);
        });

        /* Office */
        initDropDownList('bootstrap', 300,35, '#div_mef_office_id', <?php echo $listOffice;?>, 'text', 'value', false, '', '0', "#mef_office_id","{{$constant['buttonSearch']}}",300);


        /*calendar*/
        $("#div_jqxcalendar_id").jqxDateTimeInput({ width: 300, height: 30,selectionMode: 'range',formatString: "yyyy-MM-dd" });
        var start_dt = new Date('{{$start_dt}}');
        var end_dt = new Date('{{$end_dt}}');
        
        $("#div_jqxcalendar_id").jqxDateTimeInput('setRange', start_dt, end_dt);
        
		var departmentId = $('#mef_department_id').val();
		var officeId = $('#mef_office_id').val();
		if(departmentId != '' && departmentId != 0 && officeId != '' && officeId != 0){
			$('#button-print').show();
		} else {
			$('#button-print').hide();
		}
		
        $("#div_jqxcalendar_id").on('change', function (event) {
			$('#button-print').hide();
			var take_date= $('#div_jqxcalendar_id').jqxDateTimeInput('getText'); 
            var selection = $("#div_jqxcalendar_id").jqxDateTimeInput('getRange');
            if (selection.from != null) {
				$('#full_rang_day').val(take_date);
                $('#start_dt').val(selection.from.toJSON());
                $('#end_dt').val(selection.to.toJSON());       
				
				$.ajax({
					type: 'post',
					url: '{{$weekUrl}}',
					dataType: "json",
					data:{'full_rang_day':take_date,'_token':'{{ csrf_token() }}','ajaxRequestHtml':'true'},
					success: function (response) {
						console.log(response);
						if(response.code==0){
							alertMessage('បញ្ជាក់',response.message);
							$("#div_jqxcalendar_id").jqxDateTimeInput('setRange', start_dt, end_dt);
						}
						
					},
					error: function (request, status, error) {
						checkSession();
					}
				});
			}
        });
        $("#btn-search<?php echo $jqxPrefix;?>").click(function(){
			var count = validationFildInput();
			if(count > 0){
				return;
			}
            $('#attendanceForm').attr('action', "{{$searchUrl}}").submit();
			$('#button-print').show();
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