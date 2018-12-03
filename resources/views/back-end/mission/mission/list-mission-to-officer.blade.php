<div class="container-fluid">
	@if(isset($row))
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th scope="col" width="200px">{{trans('mission.mission_type')}}</th>
				<th scope="col">{!! $row->title !!}</th>
			<tr>
				<th scope="col">{{trans('schedule.meeting_leader')}}</th>
				<th>
					<ul style="list-style: none;margin-bottom: 0px;padding-left: 0px;">
					@if(isset($lead))
						@foreach($lead as $k =>$v)
							<li>{!! $v->full_name_kh !!}</li>
						@endforeach
					@endif
					</ul>
				</th>
			</tr>
			<tr>
				<th scope="col">{{trans('mission.mission_location')}}</th><th>{!! $row->mission_location!!}</th>
			</tr>
			<tr>
				<th scope="col">{{trans('mission.mission_objective')}}</th><th>{!! $row->mission_objective!!}</th>
			</tr>
		</tbody>
	</table>
	@endif
	@if($attendee != 'all')
		<table class="table table-bordered table-hover table-striped">
			<thead>
			<tr><th colspan="5">{{trans('mission.mef_mission_to_officer')}}</th></tr>
			<tr>
				<th width="5%" class="text-center">{{trans('trans.autoNumber')}}</th>
				<th width="5%">{{trans('officer.avatar')}}</th>
				<th width="20%">{{trans('officer.full_name')}}</th>
				<th width="40%">{{trans('officer.email')}}</th>
				<th width="30%">{{trans('officer.phone_number')}}</th>
			</tr>
			</thead>
			<tbody>

			@foreach($attendee as $key=>$row)
				<?php
                $avatar = $row->avatar != '' ? $row->avatar:'images/image-profile.jpg';
                $avatar = asset($avatar);
                ?>
				<tr>
					<td width="5%" class="text-center" style="vertical-align: middle;">{{$key+1}}</td>
					<td width="5%"><img src="{{$avatar}}" alt="" width="50" height="45" /></td>
					<td width="20%">{{$row->full_name_kh}}</td>
					<td width="40%">{{$row->email}}</td>
					<td width="30%">{{$row->phone_number_1}}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		<table class="table table-bordered table-hover table-notifi">
			<thead>
			<tr class="danger">
				<td width="100%" class="text-center">{{trans('attendance.meeting_all')}}</td>
			</tr>
			</thead>
		</table>
	@endif
</div>
<style>
	.table.table-notifi{ margin-bottom: 0; }
</style>