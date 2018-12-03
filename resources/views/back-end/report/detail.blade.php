<?php 
	$jqxPrefix = '_report';
	$exportUrl = asset($constant['secretRoute'].'/report/detail-export');	
?>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 7px;">
		<div class="pull-left" style="height:20px;padding-top:7px;">{{$row->Name}}</div>
		<div class="pull-right">
			<form action="<?php echo $exportUrl; ?>" class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="Id" value="{{$request_post['Id']}}">
				<input type="hidden" name="type" value="{{$request_post['type']}}">
				<input type="hidden" name="mef_secretariat_id" value="{{$request_post['mef_secretariat_id']}}">
				<input type="hidden" name="mef_department_id" value="{{$request_post['mef_department_id']}}">
				<input type="hidden" name="mef_office_id" value="{{$request_post['mef_office_id']}}">
				<input type="hidden" name="mef_position_id" value="{{$request_post['mef_position_id']}}">
				<input type="hidden" name="class_rank_id" value="{{$request_post['class_rank_id']}}">
				<input type="hidden" name="from_dob" value="{{$request_post['from_dob']}}">
				<input type="hidden" name="to_dob" value="{{$request_post['to_dob']}}">
				<button type="submit" id="btn_export_report"><i class="glyphicon glyphicon-download-alt"></i> {{$constant['export']}}</button>
			</form>
		</div>
	</div>
	<div class="row">
		<table class="table table-bordered table-hover">
			<thead>
				<tr class="success">
					<th width="5%" class="text-center">ល.រ</th>
					<th width="17%">គោត្តនាម-នាម</th>
					<th width="17%">ជាអក្សរឡាតាំង</th>
					<th width="25%">លេខទូរស័ព្ទ</th>
					<th width="25%">អ៊ីម៉ែល</th>
					<th width="11%">ថ្ងៃខែឆ្នាំកំណើត</th>
				</tr>
			</thead>
			<tbody>
				@foreach($array as $key=>$value)
                <?php
				$dob = $value->DATE_OF_BIRTH != NULL ? date('d/m/Y',strtotime($value->DATE_OF_BIRTH)):'';
				?>
				<tr>
					<td width="5%"class="text-center">{{$key + 1}}</td>
					<td width="17%">{{$value->FULL_NAME_KH}}</td>
					<td width="17%">{{$value->FULL_NAME_EN}}</td>
					<td width="25%">{{$value->PHONE_NUMBER_1}}</td>
					<td width="25%">{{$value->EMAIL}}</td>
					<td width="11%">{{$dob}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<style>

</style>
<script>
	//Button action
	var buttons = ['btn_export_report'];
	initialButton(buttons,120,30);
</script>