<?php 
$jqxPrefix = '_officer_checkin_import';
$saveUrl = asset($constant['secretRoute'].'/officer-checkin/save');
?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:10px;"></div>        
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('attendance.select_fingure_data')}}</label>
				<input type="file" name="pholiday[]" id="pholiday" multiple class="form-control">
                <div style='margin-top: 10px;' id='jqxProgressBar4'></div> 
            </div>
        </div>
		
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
    <div class="table-responsive hide" id="tbl">
        <table class="table table-data">
            
        </table>
    </div>
</div>

<style type="text/css">
    .jqx-combobox-content-disabled{
        color: #000 !important;;
    }
    .hide{
        /*display: none;*/
    }
</style>
<script>
    $(document).ready(function(){
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
		/* Save action */
		$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            
			saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}',1,function(response){
                closeJqxWindowId('jqxwindow_officer_checkin_index');
            });
		});
        $("#pholiday").jqxFileUpload();
	});
</script>