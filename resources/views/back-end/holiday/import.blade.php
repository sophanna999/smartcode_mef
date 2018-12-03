<?php 
$jqxPrefix = '_public_holiday';
$saveUrl = asset($constant['secretRoute'].'/public-holiday/importexcel');
?>

<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:10px;"></div>
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('public_holiday.select_public_holiday_data')}}</label>
				<input type="file" name="pholiday" id="pholiday" class="form-control">
            </div>
        </div>
		
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
</div>

<style type="text/css">
    .jqx-combobox-content-disabled{
        color: #000 !important;;
    }
</style>
<script>
    $(document).ready(function(){
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
		/* Save action */
		$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
			// count_error = validationFormCustom();
			// if(count_error > 0){
				// return false;
			// }
			console.log('work');
			saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}',function(respone){
				alert('work');
			});

		});


        $("#pholiday").jqxFileUpload();
	});
</script>