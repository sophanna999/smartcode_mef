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
        <table class="table table-responsive table-bordered table-hover">
            <thead>
            <tr>
                <td></td>
                <td width="5%">{{trans('attendance.from_date')}}</td>
                <td width="5%">{{trans('attendance.to_date')}}</td>
                <td width="20%" colspan="2">{{trans('attendance.OfficerName')}}</td>
                <td width="50%" colspan="3">{{trans('trans.condition_type')}}</td>
            </tr>
            <tr>
                <td style="padding: 15px;" width="5%">{{trans('trans.buttonSearch')}}</td>
                <td width="5%">
                    <input type="hidden" id="from_date_value" name="from_date_value" value="">
                    <div id="from_date"></div>
                </td>
                <td width="5%">
                    <input type="hidden" id="to_date_value" name="to_date_value" value="">
                    <div id="to_date"></div>
                </td>
                <td colspan="2">
                    <input type="hidden" id="report_officer_id" name="report_officer_id" value="">
                    <div id="report_mef_officer_id"></div>
                </td>
                <td colspan="2">
                    <input type="hidden" id="time_condition" name="time_condition" value="{{$defaultTime}}">
                    <div id="div_time_condition"></div>
                </td>
                <td width="5%"><button id="btn_search_report" type="button"><span class="glyphicon glyphicon-search"></span> {{trans('trans.buttonSearch')}}</button></td>
            </tr>
            <tr class="active">
                <th valign="middle" align="center" class="text-center" width="5%">{{trans('trans.autoNumber')}}</th>
                <th valign="middle" align="center" colspan="2" width="45%">{{trans('attendance.OfficerName')}}</th>
                <th valign="middle" align="center" width="10%">{{trans('attendance.permission_report')}}</th>
                <th valign="middle" align="center" width="10%">{{trans('attendance.absent')}}</th>
                <th valign="middle" align="center" width="10%">{{trans('attendance.mission')}}</th>
                <th valign="middle" align="center" width="10%">{{trans('attendance.late')}}</th>
                <th valign="middle" align="center" width="10%">{{trans('attendance.over_time')}}</th>
            </tr>
            </thead>
            <tbody id="report_result"></tbody>
        </table>
        <div class="pull-right">
            <a href="javascript:void(0)" id="jqx-save<?php echo $jqxPrefix;?>"><span class="glyphicon glyphicon-download-alt"></span> ទាញ{{trans('trans.report')}}</a>
        </div>
        <div class="form-group display-none">
            <button id="btn_submit" type="submit"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
        </div>
    </form>
</div>
<?php
$year = date('Y');
$month = date('m');
$month = $month - 1 ;
$day = date('d');
?>
<script>

    function search_report(){
        var from_date = $('#from_date_value').val();
        var to_date = $('#to_date_value').val();
        var officer_id = $('#report_officer_id').val();
        var time = $('#time_condition').val();
        var splits = time.split(',');
        var is_time_in = splits[2];
        $.ajax({
            url: '{{$searchReportUrl}}',
            type: "post",
            data: {
                "fromDate":from_date,
                "toDate":to_date,
				"officer_id":officer_id,
				"time":time,
				"_token": '{{ csrf_token() }}'
            },
            beforeSend: function () {
                $('#report_result').html('<tr><td colspan="8">{{trans('trans.please_wait')}}</td></tr>');
            },
            success: function (response) {
                var html_result = '';
                var items = response;
                if(items.length){
                    var is_late = '',is_ot = '';
                    $.each(items,function(index,row){
                        if (row.total>0){
							var total = row.total;
                            var take_leave = row.status == 1 ? total + 'ថ្ងៃ':'';
                            if(row.status == 2){
                                is_late = is_time_in == 'time_in' ? total + 'ដង':'';
                                is_ot = is_time_in == 'time_out' ? total + 'ដង':'';
                            }
                            html_result +='<tr>';
                            html_result +='<td class="text-center">' +(index+1)+ '</td>';
                            html_result +='<td colspan="2">'+row.officer_name+'</td>';
                            html_result +='<td class="text-right">'+ take_leave +'</td>';
                            html_result +='<td></td>';
                            html_result +='<td></td>';
                            html_result +='<td class="text-right">'+ is_late +'</td>';
                            html_result +='<td class="text-right">' + is_ot + '</td>';
                            html_result +='</tr>';
                        }
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
        getJqxCalendar('from_date','from_date_value',130,28,'{{trans('attendance.from_date')}}','');
        getJqxCalendar('to_date','to_date_value',130,28,'{{trans('attendance.to_date')}}','');
        $('#to_date').jqxDateTimeInput({ min: new Date('{{$year}}', '{{$month}}', '{{$day}}')});

        /*  From date select action */
        $('#from_date').on('change',function(){
            var from_date = $(this).val();
            var date_value =  from_date.split("/");
            $('#to_date').jqxDateTimeInput('min',new Date((date_value[2]), (date_value[1] - 1), date_value[0]));
        });

		/* All officer */
        initDropDownList(jqxTheme, '100%',28, '#report_mef_officer_id', <?php echo $allOfficer;?>, 'text', 'value', false, '', '0', '#report_officer_id','{{trans('attendance.OfficerName')}}',500);

		/* Condition type (time) */
        initDropDownList(jqxTheme, '100%',28, '#div_time_condition', <?php echo $timeCondition;?>, 'text', 'value', false, '', '0', '#time_condition','{{trans('trans.condition_type')}}',250);

    });
</script>