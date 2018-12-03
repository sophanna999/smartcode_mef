<?php
$jqxPrefix = '_mission';
$exportUrl = asset($constant['secretRoute'].'/mission/export');
$checkExportUrl = asset($constant['secretRoute'].'/mission/check-export');
?>
<div class="container-fluid">
    <form action="<?php echo $exportUrl; ?>" class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
		<div class="form-group">
			<div class="col-sm-5 text-right"><span class="red-star">*</span> {{trans('mission.mission_from_date')}}</div>
			<div class="col-sm-7">
				<input type="hidden" class="form-control" placeholder="{{trans('mission.mission_from_date')}}" id="start_date" name="start_date">
				<div id="div_start_date"></div>
			</div>
        </div>
		<div class="form-group">
			<div class="col-sm-5 text-right"><span class="red-star">*</span> {{trans('mission.mission_to_date')}}</div>
			<div class="col-sm-7">
				<input type="hidden" class="form-control" placeholder="{{trans('mission.mission_to_date')}}" id="end_date" name="end_date">
				<div id="div_end_date"></div>
			</div>
        </div>
		<div class="form-group">
			<div class="col-sm-5 text-right"><span class="red-star">*</span> {{trans('mission.mef_mission_to_officer')}}</div>
			<div class="col-sm-7">
				<input type="hidden" id="officer_name" name="officer_name" value="" />
				<div id="div_mef_mission_to_officer" name="mef_mission_to_officer"></div>
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
							$('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning",autoClose: false }).html(response.message);
							$("#jqx-notification").jqxNotification("open");
						}else{
							$('#jqx-save'+prefix).replaceWith('កំពុងតំណើរការ...');
							$('#jqx-notification').jqxNotification({ position: positionNotify,template: "success" }).html(response.message);
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
		
		// div_mef_mission_to_officer
		<?php
			$mef_officer_department = str_replace('displayMember','text',$mef_officer_department);
			$mef_officer_department = str_replace('valueMember','value',$mef_officer_department);
			$mef_officer_department = json_decode($mef_officer_department);
			array_unshift($mef_officer_department, (object)array("text"=>"","value"=>0));
			$mef_officer_department = json_encode($mef_officer_department);
		?>
		// div_mef_mission_to_officer
        initDropDownList(jqxTheme, 204,36, '#div_mef_mission_to_officer', <?php echo $mef_officer_department; ?>, 'text', 'value', false, '', '0', "#mef_mission_to_officer","{{$constant['buttonSearch']}}",250);
		//On dropdown select event
		$("#div_mef_mission_to_officer").bind('select', function (event) {
			var args = event.args;
			var item = $("#div_mef_mission_to_officer").jqxDropDownList('getItem', args.item);
			if(item == undefined){
				$('#officer_name').val('');
			}else{
				$('#officer_name').val(item.label);
			}
		});
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