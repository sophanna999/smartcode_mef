<?php
$jqxPrefix = '_meeting_new';
?>

<div class="container-fluid content-popup-meeting">
	<form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div style="margin-top:10px;"></div>
		<input type="hidden" id="Id" name="Id" value="">
		<div class="form-group">
			<label class="col-sm-2">{{trans('schedule.meeting_type')}}</label>
			<p class="col-sm-2">{{isset($allPersonalMeeting[0]->meetingTypeName) ? $allPersonalMeeting[0]->meetingTypeName:''}}</p>

		</div>
		<div class="form-group">
			<label class="col-sm-2">{{trans('schedule.objective')}}</label>
			<p class="col-sm-10">{{isset($allPersonalMeeting[0]->objective) ? $allPersonalMeeting[0]->objective:''}}</p>

		</div>
		<div class="form-group">
			<label class="col-sm-2">{{trans('schedule.meeting_leader')}}</label>
			<p class="col-sm-10">{{isset($allPersonalMeeting[0]->chaire_by) ? $allPersonalMeeting[0]->chaire_by:''}}</p>

		</div>
		<div class="form-group">
			<label class="col-sm-2">{{trans('schedule.meeting_participant')}}</label>
			<p class="col-sm-10">{{isset($allPersonalMeeting[0]->list_official) ? $allPersonalMeeting[0]->list_official:''}}</p>

		</div>

		<div class="form-group">
			<label class="col-sm-2">{{trans('schedule.meeting_date')}}</label>
			<p class="col-sm-5">{{isset($allPersonalMeeting[0]->meeting_date_kh) ? $allPersonalMeeting[0]->meeting_date_kh:''}}</p>

		</div>
		<div class="form-group">
			<label class="col-sm-2">{{trans('schedule.start_time')}}</label>
			<p class="col-sm-2">{{isset($allPersonalMeeting[0]->meeting_time) ? $allPersonalMeeting[0]->meeting_time:''}}</p>
			<label class="col-sm-2">{{trans('schedule.end_time')}}</label>
			<p class="col-sm-2">{{isset($allPersonalMeeting[0]->meeting_end_time) ? $allPersonalMeeting[0]->meeting_end_time:''}}</p>
		</div>
		<div class="form-group">

			<label class="col-sm-2">{{trans('schedule.meeting_location')}}</label>
			<p class="col-sm-10">{{isset($allPersonalMeeting[0]->location) ? $allPersonalMeeting[0]->location:''}}</p>

		</div>
	</form>
</div>

<script>
	$(document).ready(function(){

	});
</script>