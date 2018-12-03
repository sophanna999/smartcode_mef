<div class="container-fluid">
	@if($attendee != 'all')
		<table class="table table-bordered table-hover">
			<thead>
			<tr class="danger">
				<td width="5%" class="text-center">ល.រ</td>
				<td width="20%">គោត្តនាម-នាម</td>
				<td width="5%">ភេទ</td>
				<td width="25%">លេខទូរស័ព្ទ</td>
				<td width="40%">អ៊ីម៉ែល</td>
			</tr>
			</thead>
			<tbody>

			@foreach($attendee as $key=>$row)
				<tr>
					<td width="5%" class="text-center">{{$key+1}}</td>
					<td width="20%">{{$row->full_name_kh}}</td>
					<td width="5%">{{$row->gender}}</td>
					<td width="25%">{{$row->phone_number_1}}</td>
					<td width="40%">{{$row->email}}</td>
				</tr>
			@endforeach
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