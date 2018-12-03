<?php
	$jqxPrefix = '_attendance_report';
	$exportUrl = asset($constant['secretRoute'].'/takeleave-report/export');
?>
<div class="container-fluid">
	<div class="row">
		<div class="form-group">
			<div class="col-xs-12 text-right">
				<form action="<?php echo $exportUrl; ?>" class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" value="{{isset($data['mef_department_id']) ? $data['mef_department_id']: ''}}" name="mef_department_id" id="mef_department_id">
					<input type="hidden" value="{{isset($data['mef_office_id'])? $data['mef_office_id']: ''}}" name="mef_office_id" id="mef_office_id">
					<input type="hidden" value="{{isset($data['mef_officer_id'])? $data['mef_officer_id']:''}}" name="mef_officer_id" id="mef_officer_id">
					<input type="hidden" value="{{isset($data['div_mef_phone_id'])? $data['div_mef_phone_id']:''}}" name="div_mef_phone_id" id="div_mef_phone_id">
					<input type="hidden" value="{{isset($data['started_dt'])?$data['started_dt']: ''}}" name="started_dt" id="started_dt">
					<input type="hidden" value="{{isset($data['end_dt']) ? $data['end_dt']: ''}}" name="end_dt" id="end_dt">
					<button id="btn_submit" type="submit"><span class="glyphicon glyphicon-download-alt"></span> {{$constant['export']}}</button>
				</form>
			</div>
		</div>
	</div>
	<div class="form-group"></div>
	<div class="row">
		<table class="table table-bordered table-hover">
			<thead>
				<?php 
					$title_dt = 'ចំនួនថ្ងៃឈប់';
					if($is_group == '' ){ 
						$title_dt = 'ថ្ងៃឈប់';
					}
				?>
				<tr class="success">
					<th width="5%" class="text-center">{{trans('trans.autoNumber')}}</th>
					<th width="15%">{{trans('officer.full_name')}}</th>
					<th width="15%">{{trans('officer.english_name')}}</th>
					<th width="10%">{{trans('officer.phone_number')}}</th>
					<th >{{trans('officer.office')}}</th>
					<th width="11%">{{$title_dt}}</th>
					
				</tr>
			</thead>
			<tbody>
				@foreach($array as $key=>$value)
                <?php
				$dob = $value->take_date != NULL ? date('d/m/Y',strtotime($value->take_date)):'';
				$total_dt = isset($value->total_dt)?$value->total_dt:1;
				?>
				<tr>
					<td class="text-center">{{$key + 1}}</td>
					<td >{{$value->FULL_NAME_KH}}</td>
					<td >{{$value->FULL_NAME_EN}}</td>
					<td >{{$value->PHONE_NUMBER_1}}</td>
					<td >{{$value->mef_office}}</td>
					<td >{{$total_dt }} ថ្ងៃ</td>					
					
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		var buttons = ['btn_submit'];
        initialButton(buttons,120,30);
		
		/* Export Excel */
		$("#btn_submit").on('click',function(){
			// closeJqxWindowId('jqxwindow_takeleave_report');
		});
	});
</script>