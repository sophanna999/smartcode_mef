<?php
$jqxPrefix = '_mission';
$saveUrl = asset($constant['secretRoute'].'/mission/save-reference');
?>
<div class="container-fluid">
	<form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="ajaxRequestJson" value="true" />
			<input type="hidden" id="Id" name="id" value="{{isset($row->id) ? $row->id:0}}">
		
		<div style="padding: 20px;">
			<div class="form-group">
				<div class="col-sm-4 text-right">
					<div class="label-margin-top10">
						<label><span class="red-star"></span> {{trans('mission.reference').trans('mission.letter').trans('mission.mission').trans('mission.number')}}</label>
					</div>
				</div>
				<div class="col-sm-8">
					<input
						type="text"
						class="form-control"
						name="input[reference_no]"
						value="{{isset($row->reference_no)?$row->reference_no:''}}"
						placeholder="{{trans('mission.reference').trans('mission.letter').trans('mission.mission').trans('mission.number')}}"
						id="reference_no">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-4 text-right">
					<div class="label-margin-top10">
						<label><span class="red-star"></span> {{trans('mission.add_number').trans('general.day')}}</label>
					</div>
				</div>
				<div class="col-sm-8">
					<input type="hidden" class="form-control" id="reference_date" name="input[reference_date]" value="{{isset($row->reference_date) ? $row->reference_date:''}}">
					<div id="div_reference_date" name="input[reference_date]"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-4 text-right">
					<div class="label-margin-top10">
						<label><span class="red-star"></span> {{trans('mission.approve_by')}}</label>
					</div>
				</div>
				<div class="col-sm-8">
					<input
						type="text"
						class="form-control"
						name="input[approve_by]"
						value="{{isset($row->approve_by)?$row->approve_by:''}}"
						placeholder="{{trans('mission.approve_by')}}"
						id="approve_by">
				</div>
			</div>
		</div>
		

	</div>
		<div class="form-group">
			<div class="col-sm-12 text-right">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
			</div>
		</div>
    </form>
</div>
<script type="text/javascript">
	<?php
		$year = date('Y');
		$month = date('m');
		$month = $month - 1 ;
		$day = date('d');
	?>
	$(document).ready(function(){
        //Button action
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,105,30);
        /* div_reference_date */
        getJqxCalendar('div_reference_date','reference_date',200,30,'{{trans('mission.mission_from_date')}}',$('#reference_date').val(),"yyyy-MM-dd");
		
		/* Save action */
		$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
			saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
			
		});
    });
</script>