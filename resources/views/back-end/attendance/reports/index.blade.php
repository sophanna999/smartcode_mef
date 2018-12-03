<?php
$jqxPrefix = '_takeleave_report';
$newUrl = asset($constant['secretRoute'].'/takeleave-report/new');

$listUrl = asset($constant['secretRoute'].'/takeleave-report/index');
$getSecreateByMinistryId = asset($constant['secretRoute'].'/takeleave-report/get-secretary-by-ministry-id');
$getdepartmentBySecId = asset($constant['secretRoute'].'/takeleave-report/get-department-by-secretary-id');
$getOfficeByDepartment = asset($constant['secretRoute'].'/takeleave-report/get-office-by-department-id');
$getOfficerByOffice = asset($constant['secretRoute'].'/takeleave-report/get-office-by-office-id');

?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
		<div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                    <div class="col-lg-12">{{trans('attendance.attendance_management')}} &raquo;  {{trans('attendance.report')}}</div>            
                </div>
				<div class="col-lg-12">
					<form class="form-horizontal" role="form" method="post" action="">

							<div class="form-group">
								<div class="col-xs-2">អគ្គនាយកដ្ឋាន</div>
								<div class="col-xs-4">
									<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
									<div id="div_mef_secretariat_id" name="mef_secretariat_id"></div>
								</div>
								<div class="col-xs-2">នាយកដ្ឋាន</div>
								<div class="col-xs-4">
									<div id="div_mef_department_id" name="mef_department_id"></div>
								</div>
							</div>
							<div class="form-group">								
								<div class="col-xs-2">ការិយាល័យ</div>
								<div class="col-xs-4">
									<div  id="div_mef_office_id" name="mef_office_id"></div>
								</div>
								<div class="col-xs-2">មុខតំណែង</div>
								<div class="col-xs-4">
									<div id="div_mef_position_id" name="mef_position_id"></div>
								</div>
							</div>
							<div class="form-group">								
								<div class="col-xs-2">ឈ្មោះបុគ្គលិក</div>
								<div class="col-xs-4">
									<div id="div_mef_officer_id" name="mef_officer_id"></div>
								</div>
								<div class="col-xs-2">កាលបរិច្ឆេទ</div>
								<div class="col-xs-4">
									<div class="pull-left" id="div_from_dob" name="started_dt"></div>
									<div class="pull-left" id="div_to_dob" name="end_dt"></div>
								</div>
								<div class="col-xs-2">
									<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-search"></span> {{$constant['buttonSearch']}}</button>
								</div>
							</div>

					</form>

				</div>
            </div>
        </div>
	</div>	
<script type="text/javascript">
function getSecretaratByMinistryId(object){
	var ministryId = $(object).val();
	$.ajax({
		type: "post",
		url : '{{$getSecreateByMinistryId}}',
		datatype : "json",
		data : {"ministryId":ministryId,"_token":$('#_token').val()},
		success : function(data){
		   initDropDownList('bootstrap', 270,30, '#div_mef_secretariat_id', data, 'text', 'value', false, '', '0', "#mef_secretariat_id","អគ្គនាយកដ្ឋាន",300);
		   
		}
	});
}
function getDepartmentBySecrateId(object){
	var secretaryId = $(object).val();
	$.ajax({
		type: "post",
		url : '{{$getdepartmentBySecId}}',
		datatype : "json",
		data : {"secretaryId":secretaryId,"_token":'{{ csrf_token() }}'},
		success : function(data){
			initDropDownList('bootstrap', 270,30, '#div_mef_department_id', data, 'text', 'value', false, '', '0', "#mef_department_id","នាយកដ្ឋាន",300);
			
		}
	});
}
function getOfficeByDepartmentId(object){
	var departmentId = $(object).val();
	$.ajax({
		type: "post",
		url : '{{$getOfficeByDepartment}}',
		datatype : "json",
		data : {"departmentId":departmentId,"_token":'{{ csrf_token() }}'},
		success : function(data){
			initDropDownList('bootstrap', 270,30, '#div_mef_office_id', data, 'text', 'value', false, '', '0', "#mef_office_id","ការិយាល័យ",300);
		}
	});
}
function getOfficerByOfficeId(object){
	var officeId = $(object).val();
	$.ajax({
		type: "post",
		url : '{{$getOfficerByOffice}}',
		datatype : "json",
		data : {"officeId":officeId,"_token":'{{ csrf_token() }}'},
		success : function(data){
		   initDropDownList('bootstrap', 270,30, '#div_mef_officer_id', data, 'text', 'value', false, '', '0', "#mef_officer_id","បុគ្គលិក",300);
		}
	});
}
var width_form = 1024;
var height_form = 600;
// prepare the data

var numberRenderer<?php echo $jqxPrefix;?> = function (row, column, value) {
	return '<div style="text-align: center; margin-top:10px;">' + (1 + value) + '</div>';
};
$(document).ready(function () {
	var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
	initialButton(buttons,90,30);
	
	$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
		var objData = {
			'_token':'{{ csrf_token() }}',
		};
		
		if($('#div_mef_secretariat_id').val()){
			objData.mef_secretariat_id = $('#div_mef_secretariat_id').val();
		}
		if($('#div_mef_department_id').val()){
			objData.mef_department_id = $('#div_mef_department_id').val();
		}
		if($('#div_mef_position_id').val()){
			objData.mef_position_id = $('#div_mef_position_id').val();
		}
		
		if($('#div_from_dob').val()){
			objData.started_dt = $('#div_from_dob').val();
		}
		if($('#div_to_dob').val()){
			objData.end_dt = $('#div_to_dob').val();
		}
		if($('#div_mef_office_id').val()){
			objData.mef_office_id = $('#div_mef_office_id').val();
		}
		if($('#div_mef_officer_id').val()){
			objData.mef_officer_id = $('#div_mef_officer_id').val();
		}
		if($('#mef_phone_id').val()){
			objData.mef_phone_id = $('#div_mef_phone_id').val();
		}
		
		newJqxAjax('<?php echo $jqxPrefix;?>', '{{$constant['report']}}',width_form,height_form, '<?php echo $newUrl;?>',objData);
		
	});
	
	/* Export Excel End */
	getSecretaratByMinistryId();	
	/* Secretariat */
	
	$('#div_mef_secretariat_id').bind('select', function (event) {
		if($(this).val()>0){
			getDepartmentBySecrateId(this);
		}
		
	});
	/*Department*/
	initDropDownList('bootstrap', 270,30, '#div_mef_department_id',<?php echo $listDepartment;?>, 'text', 'value', false, '', '0', "#mef_department_id","នាយកដ្ឋាន",300);
	
	$('#div_mef_department_id').bind('select', function (event) {
		if($(this).val()>0){
			getOfficeByDepartmentId(this);	
		}
	});
	/*Office*/
	$('#div_mef_office_id').bind('select', function (event) {	
		if($(this).val()>0){
			getOfficerByOfficeId(this);
		}
	});
	
	/*office*/
	initDropDownList('bootstrap', 270,30, '#div_mef_office_id',<?php echo $listOffice;?>, 'text', 'value', false, '', '0', "#mef_office_id","ការិយាល័យ",300);
	/*Position*/
	initDropDownList('bootstrap', 270,30, '#div_mef_position_id',<?php echo $listPosition;?>, 'text', 'value', false, '', '0', "#mef_position_id","ការិយាល័យ",400);
	/*Officer*/
	initDropDownList('bootstrap', 270,30, '#div_mef_officer_id',<?php echo $listOfficer;?>, 'text', 'value', false, '', '0', "#mef_position_id","ការិយាល័យ",400);
	
	/*DoB*/
	getJqxCalendar('div_from_dob','from_dob',135,30,'ចាប់ពី',null);
	getJqxCalendar('div_to_dob','to_dob',135,30,'រហូតដល់',null);
	$('#div_to_dob').on('change',function(){
		var str = $(this).val();
		if(str == ''){
			$('#div_from_dob').jqxDateTimeInput({value:null});
		}
	});
	
});
</script>
@endsection