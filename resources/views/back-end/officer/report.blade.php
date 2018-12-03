<?php
$getDepartmentBySecretaryIdUrl = asset($constant['secretRoute'].'/officer/get-department-by-general-department-id');
$getOfficeByDepartmentUrl = asset($constant['secretRoute'].'/officer/get-office-by-department-id');
$total_mef_officer_url = asset($constant['secretRoute'].'/officer/total-officer-report');
?>
@extends('layout.back-end')
@section('content')
	<div class="form-group" id="scroll_bar_panel_content">
		<div id="jqx_expander_content">
            <div>{{trans('trans.report')}}</div>
            <div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>{{trans('officer.centralMinistry')}}</th>
                        <th>{{trans('officer.generalDepartment')}}</th>
                        <th>{{trans('officer.department')}}</th>
                        <th>{{trans('officer.office')}}</th>
                        <th>{{trans('officer.position')}}</th>
                        <th>{{trans('officer.class_rank')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="hidden" id="mef_ministry_id" name="mef_ministry_id" value="76">
                            <div id="div_mef_ministry_id"></div>
                        </td>
                        <td>
                            <input type="hidden" id="mef_secretariat_id" name="mef_secretariat_id">
                            <div id="div_mef_secretariat_id"></div>
                        </td>
                        <td>
                            <input type="hidden" id="mef_department_id" name="mef_department_id">
                            <div id="div_mef_department_id"></div>
                        </td>
                        <td>
                            <input type="hidden" id="mef_office_id" name="mef_office_id">
                            <div id="div_mef_office_id"></div>
                        </td>
                        <td>
                            <input type="hidden" id="mef_position_id" name="mef_position_id">
                            <div id="div_mef_position_id"></div>
                        </td>
                        <td>
                            <input type="hidden" id="class_rank_id" name="class_rank_id">
                            <div id="div_class_rank_id"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"><button id="btn-search"><i class="glyphicon glyphicon-search"></i> {{trans('trans.buttonSearch')}}</button></td>
                    </tr>
                    </tbody>
                </table>
                <div id="chat_container"></div>
            </div>
        </div>
	</div>
<style>
	.highcharts-label,.highcharts-tooltip,.highcharts-color-1,.jqx-expander-header-content{
		font-family: 'KHMERMEF1' !important;
	}
</style>
<script type="text/javascript">
    function numberToWordKH(number){
        var words = '';
        var minus = '';
        var khmerNumber = ["០", "១", "២", "៣", "៤", "៥", "៦", "៧", "៨", "៩"];
        for (var getNumber in number){
            var getConverted = khmerNumber[number[getNumber]];
            words += getConverted;
        }
        var splitNumber =  words.split('undefined');
        var joinNumber = splitNumber.join(".");
        var getKhmerNumber = (splitNumber[0]!= '' ? joinNumber:joinNumber.replace('.','-'));

        return getKhmerNumber;
    }
    function getDepartmentByGeneralDepartmentId(general_department_id){
        $.ajax({
            type: "post",
            url : '{{$getDepartmentBySecretaryIdUrl}}',
            datatype : "json",
            data : {"general_department_id":general_department_id,"_token":'{{ csrf_token() }}'},
            success : function(data){
                initDropDownList('bootstrap', 200,35, '#div_mef_department_id', data, 'text', 'value', false, '', '0', "#mef_department_id","{{$constant['buttonSearch']}}",300);
            }
        });
    }
    function getOfficeByDepartmentId(department_id){
        $.ajax({
            type: "post",
            url : '{{$getOfficeByDepartmentUrl}}',
            datatype : "json",
            data : {"department_id":department_id,"_token":'{{ csrf_token() }}'},
            success : function(data){
                initDropDownList('bootstrap', 200,35, '#div_mef_office_id', data, 'text', 'value', false, '', '0', "#mef_office_id","{{$constant['buttonSearch']}}",300);
            }
        });
    }
	function getOfficerHighChat(){
        var mef_ministry_id = $('#mef_ministry_id').val();
        var mef_secretariat_id = $('#mef_secretariat_id').val();
        var mef_department_id = $('#mef_department_id').val();
        var mef_office_id = $('#mef_office_id').val();
        var mef_position_id = $('#mef_position_id').val();
        var class_rank_id = $('#class_rank_id').val();
        $.ajax({
            type: "post",
            url : '{{$total_mef_officer_url}}',
            datatype : "json",
            data : {
                "_token":'{{ csrf_token() }}',
                'mef_ministry_id': mef_ministry_id,
                'mef_secretariat_id': mef_secretariat_id,
                'mef_department_id': mef_department_id,
                'mef_office_id': mef_office_id,
                'mef_position_id':mef_position_id,
                'class_rank_id':class_rank_id
            },
            beforeSend: function () {
                $('#jqxLoader').jqxLoader('open');
            },
            success : function(response){
                var remain_officer = parseInt(response);
                Highcharts.chart('chat_container', {
                    colors: ['#55acee', '#F19B2C'],
                    chart: {
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0
                        }
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        pointFormat: '',
                        formatter: function() {
                            var yValue = Highcharts.numberFormat(this.y);
                            var getNumber = numberToWordKH(yValue);
                            var convertKhmer = getNumber.substr(0, getNumber.length-3);
                            var tooltip =  '<span style="color:' + this.series.color + '">'+ this.key + '</span>: ' + convertKhmer + ' នាក់</b><br/>';
                            return tooltip;
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            depth: 35,
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.y}<b> នាក់</b>'
                            }
                        }
                    },
                    series: [{
                        type: 'pie',
                        data: [
                            ['{{trans('officer.officer_number')}}', remain_officer],
                            ['{{trans('trans.html_title')}}', <?php echo $total_mef_officer;?>]
                        ]
                    }]
                });
                $('#jqxLoader').jqxLoader('close');
            }
        });
	}
	$(document).ready(function () {
        var buttons = ['btn-search'];
        initialButton(buttons,90,35);

        /* Scroll Panel */
        var windowHeight = $(window).height()-130;
        $("#scroll_bar_panel_content").jqxPanel({width:'100%', height:windowHeight});
        $("#jqx_expander_content").jqxExpander({ width: '100%', height: '100%',showArrow: false,toggleMode:'none'});

		/* Ministry */
        initDropDownList('bootstrap', 200,35, '#div_mef_ministry_id', <?php echo $listMinistry;?>, 'text', 'value', false, '', '0', "#mef_ministry_id","{{$constant['buttonSearch']}}",100);

        /* General Department */
        initDropDownList('bootstrap', 200,35, '#div_mef_secretariat_id', <?php echo $listSecretariat;?>, 'text', 'value', false, '', '0', "#mef_secretariat_id","{{$constant['buttonSearch']}}",300);
        $('#div_mef_secretariat_id').bind('select', function () {
            var general_department_id = $(this).val();
            getDepartmentByGeneralDepartmentId(general_department_id);
        });
        /* Department */
        initDropDownList('bootstrap', 200,35, '#div_mef_department_id', <?php echo $listDepartment;?>, 'text', 'value', false, '', '0', "#mef_department_id","{{$constant['buttonSearch']}}",300);
        $('#div_mef_department_id').bind('select', function () {
            var department_id = $(this).val();
            getOfficeByDepartmentId(department_id);
        });

        /* Office */
        initDropDownList('bootstrap', 200,35, '#div_mef_office_id', <?php echo $listOffice;?>, 'text', 'value', false, '', '0', "#mef_office_id","{{$constant['buttonSearch']}}",300);

        /*Position*/
        initDropDownList('bootstrap', 200,35, '#div_mef_position_id',<?php echo $listPosition;?>, 'text', 'value', false, '', '0', "#mef_position_id","{{$constant['buttonSearch']}}",400);

		/*Class rank*/
        initDropDownList('bootstrap', 200,35, '#div_class_rank_id',<?php echo $listClassRank;?>, 'text', 'value', false, '', '0', "#class_rank_id","{{$constant['buttonSearch']}}",350);

        /* Call Chat function */
        getOfficerHighChat();
        $('#btn-search').on('click',function (e) {
            e.preventDefault();
            getOfficerHighChat();
        });
	});
</script>
@endsection