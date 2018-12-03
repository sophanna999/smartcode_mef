<?php
$jqxPrefix = '_download_report';
$searchReportUrl = asset($constant['secretRoute'].'/door-tracking/search-report');
$downloadReportUrl = asset($constant['secretRoute'].'/door-tracking/get-export-data');
$exportUrl = asset($constant['secretRoute'].'/door-tracking/export');
?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" action="<?php echo $downloadReportUrl;?>" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="ajaxRequestJson" value="true" />
        <div class="form-group display-none">
            <button id="btn_submit" type="submit"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
        </div>
        <table class="table table-responsive table-bordered">

            <tr>
                <td style="padding: 15px;" width="5%">{{trans('trans.buttonSearch')}}</td>
                <td width="7%">
                    <input type="hidden" id="from_date_value" name="from_date_value" value="">
                    <div id="from_date"></div>
                </td>
                <td width="8%">
                    <input type="hidden" id="to_date_value" name="to_date_value" value="">
                    <div id="to_date"></div>
                </td>
                <td  width="15%">
                    <input type="hidden" id="report_officer_id" name="report_officer_id" value="">
                    <div id="report_mef_officer_id"></div>
                </td>
                <td colspan="2" width="30%">
                    <input type="hidden" id="time_condition" name="time_condition" value="">
                    <div id="div_time_condition"></div>
                </td>
                <td  width="15%">
                    <input type="hidden" id="string_id" name="string_id" value="">
                    <div id="report_string_id"></div>
                </td>
                <td width="4%"><button id="btn_search_report" type="button"><span class="glyphicon glyphicon-search"></span> {{trans('trans.buttonSearch')}}</button></td>
            </tr>
            <tr>
                <th valign="middle" align="center" width="5%" class="text-center">{{trans('trans.autoNumber')}}</th>
                <th valign="middle" align="center" width="15%">{{trans('attendance.OfficerName')}}</th>
                <th valign="middle" align="center" width="15%">{{trans('attendance.dayMonthYear')}}</th>
                <th valign="middle" align="center" width="8%">{{trans('attendance.timeIn')}}</th>
                <th valign="middle" align="center" width="8%">{{trans('attendance.timeOut')}}</th>
                <th valign="middle" align="center" colspan="3" width="64%">{{trans('attendance.trackingDescription')}}</th>
            </tr>
            <tbody id="report_result"></tbody>
            <tr id="row_export">
                <td id="msg_html" class="text-right" colspan="5"></td>
                <td colspan="4" align="right">
                    <a href="javascript:void(0)" id="jqx-save<?php echo $jqxPrefix;?>"><span class="glyphicon glyphicon-download-alt"></span> ទាញ{{trans('trans.report')}}</a>
                </td>
            </tr>
        </table>
    </form>
</div>
<script>

    function search_report(){
        var from_date = $('#from_date_value').val();
        var to_date = $('#to_date_value').val();
        var officer_id = $('#report_officer_id').val();
        var time = $('#time_condition').val();
        var status_string = $('#string_id').val();
        $.ajax({
            url: '{{$searchReportUrl}}',
            type: "post",
            data: {
                "fromDate":from_date,
                "toDate":to_date,
				"officer_id":officer_id,
				"time":time,
                "status_string":status_string,
				"_token": '{{ csrf_token() }}'
            },
            beforeSend: function () {
                $('#report_result').html('<tr><td colspan="9">{{trans('trans.please_wait')}}</td></tr>');
            },
            success: function (response) {
                var html_result = '';
                var items = response;
                console.log(items);

                /* Door tracking */
                if(items.attendance_data.length){
                    /* Attendance */
                    html_result +='<tr class="active">';
                    html_result +='<th colspan="9">{{trans('attendance.attendance')}}</th>';
                    html_result +='</tr>';
                    $.each(items.attendance_data,function(index,row){
                        var detail = row.detail != null ? row.detail:'';
                        var time_in = row.time_in != null ? row.time_in:'';
                        var time_out = row.time_out != null ? row.time_out:'';
                        html_result +='<tr valign="middle" align="center">';
                        html_result +='<td valign="middle" align="center" class="text-center">' +(index+1)+ '</td>';
                        html_result +='<td valign="middle" style="text-align:left">'+row.mef_user_name+'</td>';
                        html_result +='<td valign="middle" style="text-align:left">'+row.dates+'</td>';
                        html_result +='<td valign="middle" style="text-align:left">'+time_in+'</td>';
                        html_result +='<td valign="middle" align="left">'+time_out+'</td>';
                        html_result +='<td valign="middle" style="text-align:left" colspan="3">'+detail+'</td>';
                        html_result +='</tr>';
                    });
                }
                /* Meeting */
                if(items.meeting_data.length){
                    html_result +='<tr class="active">';
                    html_result +='<th colspan="9">{{trans('schedule.attend_meeting')}}</th>';
                    html_result +='</tr>';
                    $.each(items.meeting_data,function(index,row){
                        var detail = row.detail != null ? row.detail:'';
                        html_result +='<tr valign="middle" align="center">';
                        html_result +='<td valign="middle" align="center" class="text-center">' +(index+1)+ '</td>';
                        html_result +='<td valign="middle" style="text-align:left">'+row.mef_user_name+'</td>';
                        html_result +='<td valign="middle" style="text-align:left">'+row.dates+'</td>';
                        html_result +='<td valign="middle" style="text-align:left"></td>';
                        html_result +='<td valign="middle" align="left"></td>';
                        html_result +='<td valign="middle" style="text-align:left" colspan="3">'+detail+'</td>';
                        html_result +='</tr>';
                    });
                }

                /* Take leave */
                if(items.take_leave_data.length){
                    html_result +='<tr class="active">';
                    html_result +='<th colspan="9">{{trans('attendance.take_request')}}</th>';
                    html_result +='</tr>';
                    $.each(items.take_leave_data,function(index,row){
                        var detail = row.detail != null ? row.detail:'';
                        html_result +='<tr valign="middle" align="center">';
                        html_result +='<td valign="middle" align="center" class="text-center">' +(index+1)+ '</td>';
                        html_result +='<td valign="middle" style="text-align:left">'+row.mef_user_name+'</td>';
                        html_result +='<td valign="middle" style="text-align:left">'+row.dates+'</td>';
                        html_result +='<td valign="middle" style="text-align:left"></td>';
                        html_result +='<td valign="middle" align="left"></td>';
                        html_result +='<td valign="middle" style="text-align:left" colspan="3">'+detail+'</td>';
                        html_result +='</tr>';
                    });
                }

                $('#report_result').html(html_result);
            }
        });
    }
    function download_report(prefix, saveUrl, token,idButtonClick){
        var valid = $('#jqx-form'+prefix).jqxValidator('validate');
        if(valid || typeof(valid) === 'undefined') {
            var formData = new window.FormData($('#jqx-form'+prefix)[0]);
            $.ajax({
                type: "post",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                url: saveUrl,
                beforeSend: function (xhr) {
                },
                success: function (response) {
                    $("#jqx-notification").jqxNotification();
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:3000});
                    if(response.code == 0){
                        $('#jqx-notification').jqxNotification({ position: 'bottom-right',template: "warning",autoClose: false }).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }else{
                        $('#jqx-notification').jqxNotification({ position: 'bottom-right',template: "success" }).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                        $('#'+idButtonClick).trigger("click");
                    }
                },
                error: function (request, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }
    $(document).ready(function () {
        var array_btn = ['btn_search_report'];
        initialButton(array_btn,90,30);

        /* Search report */
        $('#btn_search_report').click(function (event) {
            event.preventDefault();
			search_report();
        });
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            download_report('{{$jqxPrefix}}', '{{$exportUrl}}', '{{ csrf_token() }}','btn_submit');
        });

        /* From date & To date*/
        getJqxCalendar('from_date','from_date_value',140,28,'{{trans('trans.from_date')}}','');
        getJqxCalendar('to_date','to_date_value',140,28,'{{trans('trans.to_date')}}','');

		/* All officer */
        initDropDownList(jqxTheme, '100%',28, '#report_mef_officer_id', <?php echo $allOfficer;?>, 'text', 'value', false, '', '0', '#report_officer_id','{{trans('attendance.OfficerName')}}',500);

		/* Condition type (time) */
        initDropDownList(jqxTheme, '100%',28, '#div_time_condition', <?php echo $timeCondition;?>, 'text', 'value', false, '', '0', '#time_condition','{{trans('trans.condition_type')}}',400);


        /* Optional Search Param */
        initDropDownList(jqxTheme, '100%',28, '#report_string_id', <?php echo $optionalSearchParam;?>, 'text', 'value', false, '', '0', '#string_id','{{trans('trans.buttonSearch')}}',200);

    });
</script>