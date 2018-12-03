<?php
$jqxPrefix = '_metting_pending';
$saveUrl = asset($constant['secretRoute'].'/meeting-pending/save');
$rejectUrl = asset($constant['secretRoute'].'/meeting-pending/reject');
?>

<div class="container-fluid content-popup-meeting">
	<form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="Id" value="{{isset($row[0]->Id) ? $row[0]->Id:''}}">
		<div style="margin-top:10px;"></div>
		<div class="form-group">
			<label class="col-sm-2">{{trans('schedule.meeting_type')}}</label>
			<p class="col-sm-2">{{isset($row[0]->meetingTypeName) ? $row[0]->meetingTypeName:''}}</p>

		</div>
		<div class="form-group">
			<label class="col-sm-2">{{trans('schedule.objective')}}</label>
			<p class="col-sm-10">{{isset($row[0]->objective) ? $row[0]->objective:''}}</p>

		</div>
		<div class="form-group">
			<label class="col-sm-2">{{trans('schedule.meeting_leader')}}</label>
			<p class="col-sm-10">{{isset($row[0]->chaire_by) ? $row[0]->chaire_by:''}}</p>

		</div>
		<div class="form-group">
			<label class="col-sm-2">{{trans('schedule.meeting_participant')}}</label>
			<p class="col-sm-10">{{isset($row[0]->list_official) ? $row[0]->list_official:''}}</p>

		</div>

		<div class="form-group">
			<label class="col-sm-2">{{trans('schedule.meeting_date')}}</label>
			<p class="col-sm-5">{{isset($row[0]->meeting_date_kh) ? $row[0]->meeting_date_kh:''}}</p>

		</div>
		<div class="form-group">
			<label class="col-sm-2">{{trans('schedule.start_time')}}</label>
			<p class="col-sm-2">{{isset($row[0]->meeting_time) ? $row[0]->meeting_time:''}}</p>
			<label class="col-sm-2">{{trans('schedule.end_time')}}</label>
			<p class="col-sm-2">{{isset($row[0]->meeting_end_time) ? $row[0]->meeting_end_time:''}}</p>
		</div>
		<div class="form-group">

			<label class="col-sm-2">{{trans('schedule.meeting_location')}}</label>
			<p class="col-sm-10">{{isset($row[0]->location) ? $row[0]->location:''}}</p>

		</div>
		<div class="pull-right">
			<button id="btn-approval" type="button">{{trans('officer.approve')}}</button>
			<button id="btn-not-approve" type="button">{{trans('officer.not-approve')}}</button>
		</div>
	</form>
</div>

<script>

	$(document).ready(function(){
		var buttons = ['btn-approval','btn-not-approve'];
		initialButton(buttons,105,30);

		$("#btn-approval").click(function(){
			saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
			
		});

		$("#btn-not-approve").click(function(){
			saveJqxItem('{{$jqxPrefix}}', '{{$rejectUrl}}', '{{ csrf_token() }}');
			
		});

	});
</script>