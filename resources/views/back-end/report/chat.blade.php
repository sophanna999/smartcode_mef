<?php
$jqxPrefix = '_report';
$searchUrl = asset($constant['secretRoute'].'/report/index');
$postDetailUrl = asset($constant['secretRoute'].'/report/detail');
$getDetailUrl = asset($constant['secretRoute'].'/report/get-detail');
?>
<div style="overflow:hidden;">
	<div class="form-group">
		<div class="col-xs-12" id="jqxChart" style="width:85%;"></div>
	</div>
</div>
<style>
.jqx-chart-axis-text, .jqx-chart-legend-text{
	font-size: 12px;
}
.jqx-chart-title-text{
	font-weight: normal;
    font-family: 'KHMERMEF1';
}
</style>
<script type="text/javascript">
	function initailPieChat(){
		var mef_ministry_id = $('#mef_ministry_id').val();
		var mef_secretariat_id = $('#mef_secretariat_id').val();
		var mef_department_id = $('#mef_department_id').val();
		var mef_office_id = $('#mef_office_id').val();
		var mef_position_id = $('#mef_position_id').val();
		var class_rank_id = $('#class_rank_id').val();
		var from_dob = $('#from_dob').val();
		var to_dob = $('#to_dob').val();
		var source = {
				datatype: "json",
				type: "post",
				url: '{{$searchUrl}}',
				data: {
					'_token': '{{ csrf_token() }}',
					'mef_ministry_id': mef_ministry_id,
					'mef_secretariat_id': mef_secretariat_id,
					'mef_department_id': mef_department_id,
					'mef_office_id': mef_office_id,
					'mef_position_id':mef_position_id,
					'class_rank_id':class_rank_id,
					'from_dob':from_dob,
					'to_dob':to_dob
				},
				dataFields: [
						{ name: 'displayText' },
						{ name: 'dataField' }
				]
		};
		var dataAdapter = new $.jqx.dataAdapter(source,{async:true,autoBind: true});	
		var settings = {
			title: "",
			description: "",
			enableAnimations: true,
			animationDuration:800,
			showLegend: true,
			showBorderLine: false,
			legendLayout: {left:5, top:0, width: 500, height:500, flow: 'vertical' },
			padding: { left: 5, top:0, right: 5, bottom: 5 },
            titlePadding: { left: 0, top: 0, right: 0, bottom: 10 },
			source: dataAdapter,
			colorScheme: 'scheme02',			
			seriesGroups:
				[
					{
						type: 'donut',
						offsetY: 250,
						showLabels:true,
						series:
							[
								{ 
									dataField: 'dataField',
									displayText: 'displayText',
									labelRadius:180,
									initialAngle: 150,
									radius: 150,
									centerOffset: 0,
									formatFunction: function (value) {
										if (isNaN(value))
											return value;
										return  value + 'នាក់';
									},
								}
							]	
					}
				]
		};
		$('#jqxChart').jqxChart('refresh');
		$('#jqxChart').jqxChart(settings);
	}
	
	$(function(){
		var height = $(window).height() - 140;
		$('#jqxChart').css("height", height);
		
		setTimeout(function(){ 
			initailPieChat();	
		}, 1000);
		/*setTimeout(function(){ 
			getPieChatDetail();	
		}, 2000);*/
		
		$('#btn-search').on('click',function (e) {
			e.preventDefault();
			setTimeout(function(){ 
				initailPieChat();	
			}, 900);
			/*setTimeout(function(){ 
				getPieChatDetail();
			}, 2000);*/
			
		});
		
	});
</script>