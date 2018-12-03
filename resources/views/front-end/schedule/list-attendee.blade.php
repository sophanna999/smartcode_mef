<div class="container-fluid">
	@if($attendee != 'all')
		<table class="table table-bordered table-hover">
			<thead>
			<tr>
				<th width="5%" class="text-center">{{trans('trans.autoNumber')}}</th>
				<th width="5%">{{trans('officer.avatar')}}</th>
				<th width="50%">{{trans('officer.full_name')}}</th>
				<th width="40%">{{trans('officer.email')}}</th>

			</tr>
			</thead>
			<tbody>
			@foreach($attendee as $key=>$row)
				<?php
                $avatar = $row->avatar != '' ? $row->avatar:'images/image-profile.jpg';
                $avatar = asset($avatar);
				?>
				<tr>
					<td width="5%" class="text-center" valign="middle">{{$key+1}}</td>
					<td width="5%"><img src="{{$avatar}}" alt="" width="35" height="35" class="img-circle" /></td>
					<td width="50%">{{$row->full_name_kh}}</td>
					<td width="40%">{{$row->email}}</td>

				</tr>
			@endforeach
			<?php
			$external_string = isset($external_string) ? $external_string:'';
			?>
			@if($external_string != '')
				<tr class="active">
					<td colspan="4">បញ្ជីរាយនាមអ្នក{{trans('schedule.outside_participant')}}</td>
				</tr>

				@foreach($external_string as $key=>$row)

					<tr>
						<td width="5%" class="text-center" valign="middle">{{$key+1}}</td>
						<td width="5%"><img src="" alt="" width="35" height="35" class="img-circle" /></td>
						<td width="50%">{{$row}}</td>
						<td width="40%"></td>
					</tr>
				@endforeach
			@endif
			</tbody>
		</table>
	@else
		<table class="table table-bordered table-hover table-notifi">
			<thead>
			<tr class="danger">
				<td width="100%" class="text-center">កិច្ចប្រជុំរួមគ្នា</td>
			</tr>
			</thead>
		</table>
	@endif
</div>
<style>
	.table.table-notifi{ margin-bottom: 0; }
</style>