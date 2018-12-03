<html>

    <!-- Headings -->
    <td><h1>Big title</h1></td>

    <!--  Bold -->
    <td><b>Bold cell</b></td>
    <td><strong>Bold cell</strong></td>

    <!-- Italic -->
    <td><i>Italic cell</i></td>

    <!-- Images -->
  	<table class="table table-bordered table-hover">
		<thead>
			<tr class="success">
				<th width="5%" class="text-center">{{trans('trans.autoNumber')}}</th>
				<th width="15%">{{trans('officer.full_name')}}</th>
				<th width="15%">{{trans('officer.english_name')}}</th>
				<th width="10%">{{trans('officer.phone_number')}}</th>
				<th >{{trans('officer.office')}}</th>
				<th width="11%">ចំនួនថ្ងៃឈប់</th>
				<?php if($is_group == '' ){ ?>
				<th width="11%">ថ្ងៃឈប់</th>
				<? }?>
			</tr>
		</thead>
		<tbody>
			@foreach($array as $key=>$value)
            <?php
			$dob = $value->started_dt != NULL ? date('d/m/Y',strtotime($value->started_dt)):'';
			$duration = $is_group == 'group' ? $value->total_duration : $value->duration;
			?>
			<tr>
				<td class="text-center">{{$key + 1}}</td>
				<td >{{$value->FULL_NAME_KH}}</td>
				<td >{{$value->FULL_NAME_EN}}</td>
				<td >{{$value->PHONE_NUMBER_1}}</td>
				<td >{{$value->mef_office}}</td>
				<td >{{$duration}} ថ្ងៃ</td>					
				<?php if($is_group == '' ){ ?>
				<td >{{$dob}}</td>
				<? }?>
			</tr>
			@endforeach
		</tbody>
	</table>
</html>
