<div class="container-fluid">
	@if($attendee != 'all')
		<table class="table table-bordered table-hover">
			<thead>
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
			@if(count($external_string) >0)
				<tr class="active">
					<td colspan="5">រាយនាមអ្នក{{trans('schedule.outside_participant')}}</td>
				</tr>
				@foreach($external_string as $key=>$row)
                    <?php
                    $avatar = asset('images/image-profile.jpg');
                    ?>
					<tr>
						<td width="5%" class="text-center" valign="middle" style="vertical-align: middle;">{{$key+1}}</td>
						<td width="5%"><img src="{{$avatar}}" alt="" width="50" height="45" /></td>
						<td width="20%">{{$row->name}}</td>
						<td width="40%">{{$row->email}}</td>
						<td width="30%"></td>
					</tr>
				@endforeach
			@endif
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