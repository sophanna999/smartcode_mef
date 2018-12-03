<?php
$jqxPrefix = '_report';
$listUrl = asset($constant['secretRoute'].'/report/index');
$getSecreateByMinistryId = asset($constant['secretRoute'].'/report/get-secretary-by-ministry-id');
$getdepartmentBySecId = asset($constant['secretRoute'].'/report/get-department-by-secretary-id');
$getOfficeByDepartment = asset($constant['secretRoute'].'/report/get-office-by-department-id');

?>
@extends('layout.back-end')
@section('content')
<div class="content-container" id="scroll-bar-panel-content">
	<form class="form-horizontal" role="form" method="post" action="">
		<div id="mainSplitter">
			<div class="container-fluid">
				<br>
				<div class="form-group">
					<div class="col-xs-3 text-right">ក្រសួង/ស្ថាប័ន</div>
					<div class="col-xs-9">
						<input type="hidden" id="mef_ministry_id" name="mef_ministry_id" value="76">
						<div id="div_mef_ministry_id"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-3 text-right">
						អគ្គនាយកដ្ឋាន
					</div>
					<div class="col-xs-9">
						<input type="hidden" id="mef_secretariat_id" name="mef_secretariat_id">
						<div id="div_mef_secretariat_id"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-3 text-right">នាយកដ្ឋាន</div>
					<div class="col-xs-9">
						<input type="hidden" id="mef_department_id" name="mef_department_id">
						<div id="div_mef_department_id"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-3 text-right">
						ការិយាល័យ
					</div>
					<div class="col-xs-9">
						<input type="hidden" id="mef_office_id" name="mef_office_id">
						<div id="div_mef_office_id"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-3 text-right">មុខតំណែង</div>
					<div class="col-xs-9">
						<input type="hidden" id="mef_position_id" name="mef_position_id">
						<div id="div_mef_position_id"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-3 text-right">
						ឋានន្តរស័ក្តិ
					</div>
					<div class="col-xs-9">
						<input type="hidden" id="class_rank_id" name="class_rank_id">
						<div id="div_class_rank_id"></div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-xs-2 col-xs-offset-8">
						<button id="btn-search"><i class="glyphicon glyphicon-search"></i> {{$constant['buttonSearch']}}</button>
					</div>
				</div>
			</div>
			<div id="jqxExpander">
				<div>  របាយការណ៏ប្រវត្តិរូបមន្រ្តីរាជការ</div>
				<div>@include('back-end.report.chat')</div>
			</div>
		</div>
	</form>
</div>	
	
	
<script type="text/javascript">
function getSecretaratByMinistryId(object){
	var ministryId = $(object).val();
	$.ajax({
		type: "post",
		url : '{{$getSecreateByMinistryId}}',
		datatype : "json",
		data : {"ministryId":ministryId,"_token":'{{ csrf_token() }}'},
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

$(document).ready(function () {
	var buttons = ['btn-search'];
	initialButton(buttons,90,30);
	var windowHeight = $(window).height()-110;
	var fullHeight = $(window).height();
    $("#scroll-bar-panel-content").jqxPanel({width:'100%', height:windowHeight});
	$("#jqxExpander").jqxExpander({ width: '100%'});
    $("#mainSplitter").jqxSplitter({width: '100%', height: (fullHeight)-100,splitBarSize: 3 , panels: [{ size: 410 }]});
			
	/* Ministry */
	initDropDownList('bootstrap', 270,30, '#div_mef_ministry_id', <?php echo $listMinistry;?>, 'text', 'value', false, '', '0', "#mef_ministry_id","ក្រសួង/ស្ថាប័ន",150);
	getSecretaratByMinistryId();
	
	/* Secretariat */
	$('#div_mef_secretariat_id').bind('select', function (event) {
		getDepartmentBySecrateId(this);
	});
	
	/*Department*/
	initDropDownList('bootstrap', 270,30, '#div_mef_department_id',<?php echo $listDepartment;?>, 'text', 'value', false, '', '0', "#mef_department_id","នាយកដ្ឋាន",300);
	$('#div_mef_department_id').bind('select', function (event) {
		getOfficeByDepartmentId(this);	
	});
	
	initDropDownList('bootstrap', 270,30, '#div_mef_office_id',<?php echo $listOffice;?>, 'text', 'value', false, '', '0', "#mef_office_id","ការិយាល័យ",300);
		
	/*Position*/
	initDropDownList('bootstrap', 270,30, '#div_mef_position_id',<?php echo $listPosition;?>, 'text', 'value', false, '', '0', "#mef_position_id","ការិយាល័យ",400);
	
	/*Class rank*/
	initDropDownList('bootstrap', 270,30, '#div_class_rank_id',<?php echo $listClassRank;?>, 'text', 'value', false, '', '0', "#class_rank_id","ក្របខ័ណ្ឌឋានន្តរស័ក្តិ និងថ្នាក់",350);
	
});
</script>
@endsection