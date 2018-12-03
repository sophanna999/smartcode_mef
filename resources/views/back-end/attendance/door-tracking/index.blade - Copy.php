<?php
$jqxPrefix = '_doorTracking';
$listUrl = asset($constant['secretRoute'].'/door-tracking/index');
$searchUrl = asset($constant['secretRoute'].'/door-tracking/search');
?>
@extends('layout.back-end')
@section('content')
<div class="container-fluid">
	<div class="row search-options">
		<div class="col-lg-1 col-md-2 text-right labels-door-tracking">{{trans('attendance.dayMonthYear')}}</div>
		<div class="col-lg-2 col-md-2">
			<input type="hidden" id="from-date-value" value="">
			<div id="jqx-from-date"></div>
		</div>
		<div class="col-lg-1 col-md-2 text-right labels-door-tracking">{{trans('attendance.OfficerName')}}</div>
		<div class="col-lg-2 col-md-3">
			<input type="hidden" id="officer_id" value="">
			<div id="mef_officer_id"></div>
		</div>
		<div class="col-lg-1 col-md-1">
			<button id="jqx-search" type="button"><span class="glyphicon glyphicon-search"></span> {{trans('trans.buttonSearch')}}</button>
		</div>
		<div class="col-lg-1 col-md-1">
			<a type="button" class="btn btn-primary btn-md" id="export-excel">{{trans('trans.export')}}</a>
		</div>
	</div><br>
	<div class="clearfix"></div>
	<div id="search-result"></div>
</div>
<style>
#detail-body{
	overflow-x: hidden;
	overflow-y:auto;
	font-family: 'KHMERMEF1';
}

.search-options{
	position: relative;
    top: 2px;
    height: 40px;
    border-bottom: 1px solid #E8E8E8;
	background: #f5f5f5;
    padding-top: 2px;
    margin-bottom: -14px;
}
.labels-door-tracking{
	top:10px;
}
.table > thead > tr > th{
	border-bottom: 1px solid #ddd;
}
</style>
<script type="text/javascript">
	function initialDate(divDateContainer,hiddenDate) {
		$('#'+divDateContainer).jqxDateTimeInput({
			theme: jqxTheme,
			width: '140px',
			height: '30px',
			formatString: 'dd/MM/yyyy',
			animationType: 'fade',
			todayString:'Today',
			showFooter:false
		});
		$('#'+hiddenDate).val($('#'+divDateContainer).val());
		$('#'+divDateContainer).on('change', function () {
			$('#'+hiddenDate).val($('#'+divDateContainer).val());
		});
	}
	function initJqxWindow(date,officer_id) {
	    var url = '{{asset($constant['secretRoute'].'/door-tracking/detail')}}';
	    var param = {
	        _token:'{{csrf_token()}}',
            officer_id:officer_id,
			date:date
		};
        newJqxAjax('tracking', '{{trans('officer.detail')}}',1000, 600, url, param);
    }
	function getDetail(){
		var date = $('#from-date-value').val();
		var officer_id = $('#officer_id').val();
		$.ajax({
			url: '{{$searchUrl}}',
			type: "post",
			data: {"fromDate":date,officer_id:officer_id,"_token": '{{ csrf_token() }}'
			},
			beforeSend: function () {
				$('#jqxLoader').jqxLoader('open');
				$('#search-result').html('');
			},

			success: function (response) {
				var html = '';
				if(response){
					html +='<div class="row">';
					html +='<div id="detail-body">';
					html +='<table class="table table-hover table-bordered" border="1" style="font-family: KHMERMEF1;">';
					html +='<thead>';
					html +='<tr>';
					html +='<th valign="middle" align="center" width="5%" class="text-center">{{trans('trans.autoNumber')}}</th>';
					html +='<th valign="middle" align="center" width="15%">{{trans('attendance.OfficerName')}}</th>';
					html +='<th valign="middle" align="center" width="15%">{{trans('attendance.dayMonthYear')}}</th>';
					html +='<th valign="middle" align="center" width="8%">{{trans('attendance.timeIn')}}</th>';
					html +='<th valign="middle" align="center" width="8%">{{trans('attendance.timeOut')}}</th>';
					html +='<th valign="middle" align="center" width="64%">{{trans('attendance.trackingDescription')}}</th>';
					html +='</tr>';

					/*មន្រ្តីដែលចូលមុនម៉ោង (ពេលព្រឹក ០៨ : ០០)  comeBefore8AM*/
					html +='<thead>';
					html +='<tr valign="middle" align="center" ><th valign="middle" align="center" colspan="6" >{{trans('attendance.comeBefore8AM')}}</th></tr>';
					html +='<tbody>';
					$.each(response['comeBefore8AM'],function(index,row){
						var detail = row.detail != null ? row.detail:'';
                        var string = "'" + row.dates + "'";
						html +='<tr valign="middle" align="center">';
						html +='<td valign="middle" align="center" class="text-center">' +(index+1)+ '</td>';
						html +='<td valign="middle" style="text-align:left"><a href="javascript:void(0)" onclick="initJqxWindow('+ string +','+ row.mef_user_id+')">'+row.mef_user_name+'</a></td>';
						html +='<td valign="middle" style="text-align:left">'+row.dates+'</td>';
						html +='<td valign="middle" style="text-align:left">'+row.time_in+'</td>';
						html +='<td valign="middle" align="center"></td>';
                        html +='<td valign="middle" style="text-align:left">'+detail+'</td>';
						html +='</tr>';
					});
					html +='<tr valign="middle" align="center">';
					html +='<th valign="middle" align="center" colspan="5" class="text-right">{{trans('attendance.totalOfficers')}}</th>';
					html +='<th valign="middle" align="center" >'+response['comeBefore8AM'].length+'</th>';
					html +='</tr>';
					html +='</tbody>';
					html +='</thead>';

					// comeLateAfter8AM
					html +='<thead>';
					html +='<tr><th valign="middle" align="center" colspan="6" >{{trans('attendance.comeLateAfter8AM')}}</th></tr>';
					html +='</thead>';
					html +='<tbody>';
					$.each(response['lateMorning8AM'],function(index,row){
						var detail = row.detail != null ? row.detail:'';
                        var string = "'" + row.dates + "'";
						html +='<tr valign="middle" align="center" height="30">';
						html +='<td valign="middle" align="center" class="text-center">'+(index+1)+'</td>';
						html +='<td valign="middle" style="text-align:left"><a href="javascript:void(0)" onclick="initJqxWindow('+ string +','+ row.mef_user_id+')">'+row.mef_user_name+'</a></td>';
						html +='<td valign="middle" style="text-align:left">'+row.dates+'</td>';
						html +='<td valign="middle" style="text-align:left">'+row.time_in+'</td>';
						html +='<td valign="middle"></td>';
                        html +='<td valign="middle" style="text-align:left">'+detail+'</td>';
						html +='</tr>';
					});

					html +='<tr valign="middle" align="center">';
					html +='<th valign="middle" align="center" colspan="5" class="text-right">{{trans('attendance.totalOfficers')}}</th>';
					html +='<th valign="middle" align="center">'+response['lateMorning8AM'].length+'</th>';
					html +='</tr>';
					html +='</tbody>';

					// gofirstBefore12PM
					html +='<thead>';
					html +='<tr valign="middle" align="center"><th valign="middle" align="center" colspan="6">{{trans('attendance.gofirstBefore12PM')}}</th></tr>';
					html +='</thead>';
					html +='<tbody>';
					$.each(response['lateMorning12PM'],function(index,row){
						var detail = row.detail != null ? row.detail:'';
                        var string = "'" + row.dates + "'";
						html +='<tr valign="middle" align="center" >';
						html +='<td valign="middle" align="center" class="text-center">' +(index+1)+ '</td>';
						html +='<td valign="middle" style="text-align:left"><a href="javascript:void(0)" onclick="initJqxWindow('+ string +','+ row.mef_user_id+')">'+row.mef_user_name+'</a></td>';
						html +='<td valign="middle" style="text-align:left">'+row.dates+'</td>';
						html +='<td valign="middle" align="center"></td>';
						html +='<td valign="middle" style="text-align:left">'+row.time_out+'</td>';
                        html +='<td valign="middle" style="text-align:left">'+detail+'</td>';
						html +='</tr>';
					});
					html +='<tr valign="middle" align="center">';
					html +='<th valign="middle" colspan="5" class="text-right">{{trans('attendance.totalOfficers')}}</th>';
					html +='<th valign="middle" align="center" >'+response['lateMorning12PM'].length+'</th>';
					html +='</tr>';
					html +='</tbody>';


					// overtTime12PM
					html +='<thead>';
					html +='<tr><th valign="middle" align="center" colspan="6">{{trans('attendance.overtTime12PM')}}</th></tr>';
					html +='</thead>';
					html +='<tbody>';
					$.each(response['lateMorning1201AM'],function(index,row){
						var detail = row.detail != null ? row.detail:'';
                        var string = "'" + row.dates + "'";
						html +='<tr valign="middle" align="center" >';
						html +='<td valign="middle" align="center" class="text-center">' +(index+1)+ '</td>';
						html +='<td valign="middle" style="text-align:left"><a href="javascript:void(0)" onclick="initJqxWindow('+ string +','+ row.mef_user_id+')">'+row.mef_user_name+'</a></td>';
						html +='<td valign="middle" style="text-align:left">'+row.dates+'</td>';
						html +='<td valign="middle" align="center"></td>';
						html +='<td valign="middle" style="text-align:left">'+row.time_out+'</td>';
                        html +='<td valign="middle" style="text-align:left">'+detail+'</td>';
						html +='</tr>';
					});
					html +='<tr valign="middle" align="center">';
					html +='<th valign="middle" colspan="5" class="text-right" >{{trans('attendance.totalOfficers')}}</th>';
					html +='<th valign="middle" align="center" >'+response['lateMorning1201AM'].length+'</th>';
					html +='</tr>';
					html +='</tbody>';


					// comeLateAfter2PM
					html +='<thead>';
					html +='<tr valign="middle" align="center" ><th valign="middle" align="center" colspan="6">{{trans('attendance.comeLateAfter2PM')}}</th></tr>';
					html +='</thead>';
					html +='<tbody>';
					$.each(response['lateEvening0200PM'],function(index,row){
						var detail = row.detail != null ? row.detail:'';
                        var string = "'" + row.dates + "'";
						html +='<tr valign="middle" align="center">';
						html +='<td valign="middle" align="center" class="text-center">' +(index+1)+ '</td>';
						html +='<td valign="middle" style="text-align:left"><a href="javascript:void(0)" onclick="initJqxWindow('+ string +','+ row.mef_user_id+')">'+row.mef_user_name+'</a></td>';
						html +='<td valign="middle" style="text-align:left"'+row.dates+'</td>';
						html +='<td valign="middle" style="text-align:left">'+row.time_in+'</td>';
						html +='<td valign="middle" align="center"></td>';
                        html +='<td valign="middle" style="text-align:left">'+detail+'</td>';
						html +='</tr>';
					});
					html +='<tr valign="middle" align="center">';
					html +='<th valign="middle" align="center" colspan="5" class="text-right">{{trans('attendance.totalOfficers')}}</th>';
					html +='<th valign="middle" align="center" >'+response['lateEvening0200PM'].length+'</th>';
					html +='</tr>';
					html +='</tbody>';


					// gofirstBefore0530PM
					html +='<thead>';
					html +='<tr valign="middle" align="center"><th valign="middle" align="center" colspan="6">{{trans('attendance.gofirstBefore6PM')}}</th></tr>';
					html +='</thead>';
					html +='<tbody>';

					$.each(response['lateEvening0530AM'],function(index,row){
						var detail = row.detail != null ? row.detail:'';
                        var string = "'" + row.dates + "'";
						html +='<tr valign="middle" align="center">';
						html +='<td valign="middle" align="center" class="text-center">' +(index+1)+ '</td>';
						html +='<td valign="middle" style="text-align:left"><a href="javascript:void(0)" onclick="initJqxWindow('+ string +','+ row.mef_user_id+')">'+row.mef_user_name+'</a></td>';
						html +='<td valign="middle" style="text-align:left">'+row.dates+'</td>';
						html +='<td valign="middle" align="center"></td>';
						html +='<td valign="middle" style="text-align:left">'+row.time_out+'</td>';
                        html +='<td valign="middle" style="text-align:left">'+detail+'</td>';
						html +='</tr>';
					});
					html +='<tr valign="middle" align="center">';
					html +='<th valign="middle" align="center" colspan="5" class="text-right">{{trans('attendance.totalOfficers')}}</th>';
					html +='<th valign="middle" align="center">'+response['lateEvening0530AM'].length+'</th>';
					html +='</tr>';
					html +='</tbody>';

					// overTime6PM
					html +='<thead>';
					html +='<tr valign="middle" align="center"><th valign="middle" align="center" colspan="6">{{trans('attendance.overTime6PM')}}</th></tr>';
					html +='</thead>';
					html +='<tbody>';
					$.each(response['lateEvening0601AM'],function(index,row){
						var detail = row.detail != null ? row.detail:'';
						var string = "'" + row.dates + "'";
						html +='<tr valign="middle" align="center">';
						html +='<td valign="middle" align="center" class="text-center">' +(index+1)+ '</td>';
						html +='<td valign="middle" style="text-align:left"><a href="javascript:void(0)" onclick="initJqxWindow('+ string +','+ row.mef_user_id+')">'+row.mef_user_name+'</a></td>';
						html +='<td valign="middle" style="text-align:left">'+row.dates+'</td>';
						html +='<td valign="middle" align="center"></td>';
						html +='<td valign="middle" style="text-align:left">'+row.time_out+'</td>';
						html +='<td valign="middle" style="text-align:left">'+detail+'</td>';
						html +='</tr>';

					});
					html +='<tr valign="middle" align="center">';
					html +='<th valign="middle" align="center" colspan="5" class="text-right">{{trans('attendance.totalOfficers')}}</th>';
					html +='<th valign="middle" align="center">'+response['lateEvening0601AM'].length+'</th>';
					html +='</tr>';
					html +='</tbody>';

					html +='</table>';
					html +='</div>';
					html +='</div>';
				}
				$('#search-result').html(html);

				/* Set height of content */
                var height = $(window).height() - 160;
                $('#detail-body').css("height", height);

				/* Close jqxLoader */
				$('#jqxLoader').jqxLoader('close');
			}
		});
	}
	$(document).ready(function () {
		var buttons = ['jqx-search'];
		initialButton(buttons,90,35);
		/* Initial date */
		initialDate('jqx-from-date','from-date-value');
		getDetail();

		/* Initial search */
		$('#jqx-search').on('click',function(){
			getDetail();
		});

		/* All officer */
		initDropDownList(jqxTheme, 180,30, '#mef_officer_id', <?php echo $allOfficer;?>, 'text', 'value', false, '', '0', '#officer_id','{{trans('attendance.OfficerName')}}',500);

    });
	/* Export data into Excel*/
	$("#export-excel").click(function () {
		var reportType = 'report';
		var blobURL = tableToExcel('search-result', reportType);
		$(this).attr('download',reportType+'.xls');
		$(this).attr('href',blobURL);
	});
</script>
@endsection