<?php
$jqxPrefix = '_metting';
$exportUrl = asset($constant['secretRoute'].'/meeting/export');
$checkExportUrl = asset($constant['secretRoute'].'/meeting/check-export');
?>
<div class="container-fluid">
    <form action="<?php echo $exportUrl; ?>" class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
		<div class="form-group">
			<div class="col-sm-5 text-right"><span class="red-star">*</span> កាលបរិច្ឆេទចាប់ផ្ដើម</div>
			<div class="col-sm-7">
				<input type="hidden" class="form-control" placeholder="កាលបរិច្ឆេទចាប់ផ្ដើម" id="start_date" name="start_date">
				<div id="div_start_date"></div>
			</div>
        </div>
		<div class="form-group">
			<div class="col-sm-5 text-right"><span class="red-star">*</span> កាលបរិច្ឆេទបញ្ចប់</div>
			<div class="col-sm-7">
				<input type="hidden" class="form-control" placeholder="កាលបរិច្ឆេទបញ្ចប់" id="end_date" name="end_date">
				<div id="div_end_date"></div>
			</div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8 text-right">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-download-alt"></span> ទាញរបាយការណ៏</button>
            </div>
        </div>
		<div class="form-group display-none">
            <div class="col-sm-offset-8 col-sm-4 text-right">
				<button id="btn_submit" type="submit"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
		// start_date
		getJqxCalendar('div_start_date','start_date',200,30,'កាលបរិច្ឆេទចាប់ផ្ដើម',$('#start_date').val());
		
		// start_date
		getJqxCalendar('div_end_date','end_date',200,30,'កាលបរិច្ឆេទបញ្ចប់',$('#end_date').val());
		
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,150,30);
		
		$('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
				{input: '#div_start_date', message: ' ', action: 'select',
                    rule: function () {
                        if($("#start_date").val() == ""){
                            return false;
                        }
                        return true;
                    }
                },
				{input: '#div_end_date', message: ' ', action: 'select',
                    rule: function () {
                        if($("#end_date").val() == ""){
                            return false;
                        }
                        return true;
                    }
                }
            ]
        });
		
		
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            checkExportData('{{$jqxPrefix}}', '{{$checkExportUrl}}', '{{ csrf_token() }}','#btn_submit');
        });
		
		function checkExportData(prefix, saveUrl, token,idButtonClick){
			var valid = $('#jqx-form'+prefix).jqxValidator('validate');
			if(valid || typeof(valid) === 'undefined'){
				var formData = new window.FormData($('#jqx-form'+prefix)[0]);
				$.ajax({
					type: "post",
					data: formData,
					contentType: false,
					cache: false,
					processData:false,
					dataType: "json",
					url: saveUrl,
					beforeSend: function( xhr ) {
						//$('#jqx-save'+prefix).replaceWith('កំពុងតំណើរការ...');
					},
					success: function (response) {
						$("#jqx-grid"+prefix).jqxTreeGrid('updateBoundData');
						$("#jqx-grid"+prefix).jqxGrid('updatebounddata');
						$("#jqx-grid"+prefix).jqxGrid('clearselection');
						$("#jqx-notification").jqxNotification();
						$("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:3000});
						
						if(response.code == 0){
							$('#jqx-notification').jqxNotification({ position: 'bottom-right',template: "warning",autoClose: false }).html(response.message);
							$("#jqx-notification").jqxNotification("open");
						}else{
							$('#jqx-save'+prefix).replaceWith('កំពុងតំណើរការ...');
							$('#jqx-notification').jqxNotification({ position: 'bottom-right',template: "success" }).html(response.message);
							$("#jqx-notification").jqxNotification("open");
							$(idButtonClick).trigger( "click" );
							closeJqxWindowId('jqxwindow'+prefix);
						}
					},
					error: function (request, textStatus, errorThrown) {
						console.log(errorThrown);
					}
				});
			}
		}
		
    });	
	
</script>
<style>
	#office_label{
		margin-top: 10px;
	}
	.label-margin-top10{
		margin-top: 10px;
	}
	#div_meeting_date, #div_meeting_time{ display: inline-block; }
	.jqx-validator-error-label{ display: none !important; width: 0 !important; }
</style>