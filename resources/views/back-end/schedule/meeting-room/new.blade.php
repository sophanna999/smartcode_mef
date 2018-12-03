<?php
$jqxPrefix = '_meeting_room';
$saveUrl = asset($constant['secretRoute'].'/meeting-room/save');
?>

<div class="container-fluid">
	<form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div style="margin-top:10px;"></div>
		<input type="hidden" id="Id" name="Id" value="{{isset($row->id) ? $row->id:0}}">
		<div class="form-group">
			<div class="col-sm-3 text-right" style="padding-top:5px;">
				<span class="red-star">*</span>{{trans('schedule.meeting_room')}}
			</div>
			<div class="col-sm-9">
				<input type="text" class="form-control" placeholder="{{trans('schedule.meeting_room')}}" id="Name" name="name" value="{{isset($row->name) ? $row->name:''}}">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12 text-right">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
			</div>
		</div>
	</form>
</div>

<script>
	$(document).ready(function(){
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
		initialButton(buttons,90,30);
		$('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
			hintType:'label',
			rules: [
				{input: '#Name', message: ' ', action: 'blur', rule: 'required'},
			]
		});

		$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
			saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
		});
	});
</script>