<div id="general-knowledge" class="<?php echo $blgFadeEditClass; ?>" ng-controller="generalKnowledgeController">
<form name="general-knowledge">
{{--	<h2>{{trans('officer.general_knowlegde')}}</h2><br>--}}
	<div class="row">
		<div class="block-5">
			<img src="images/help.png" title="" class="help">
		</div>
	</div>
      <div class="tblSection tbl-xrepeat">
	<table class="table table-bordered tbl-middle">
		<thead>
		  <tr>
			<th rowspan="2" class="text-center" style="vertical-align: middle;">{{trans('officer.level')}}</th>
			<th rowspan="2" class="text-center" style="vertical-align: middle;">{{trans('officer.place')}}</th>
			<th rowspan="2" class="text-center" style="vertical-align: middle;">{{trans('officer.graduation_major')}}</th>
			<th colspan="3" class="text-center">{{trans('officer.start_date_study')}}</th>
		  </tr>
		  <tr>
			<th class="text-center">{{trans('work_history.start_work')}}</th>
			<th colspan="2"  class="text-center">{{trans('work_history.end_work')}}</th>

		  </tr>
		</thead>
		<tbody>
		  <tr>
			<td colspan="6" style="font-weight: bold;"><span class="col-red">*</span>{{trans('general_knowlegde.general_knowledge_level')}}</td>
		  </tr>
		  <tr>
			<td class="text-center">
				<input type="hidden" id="generalLevel" class="w100">
				<div id="div_generalLevel"></div>
			</td>
			<td class="text-center">
				<input type="text" id="generalPlace" class="w100" ng-model="knowledge_g.PLACE">
			</td>
			<td class="text-center">
				<input type="hidden" id="generalCertificate" class="w100">
				<div id="div_generalCertificate"></div>
			</td>
			<td class="text-center">
				<input type="hidden" id="start-date-value_g" value="">
				<div id="divStartDate_g"></div>
			</td>
			<td colspan="2" class="text-center">
				<input type="hidden" id="end-date-value_g" value="">
				<div id="divEndDate_g"></div>
			</td>

		  </tr>
		  <tr>
			<td colspan="6" style="font-weight: bold;"><span class="col-red">*</span>{{trans('general_knowlegde.skill_level')}}</td>
		  </tr>

		  <tr ng-repeat="(key, value) in knowledge_sk">
			<td class="text-center">
				<input type="hidden" id="skillLevel_@{{key}}" class="w100">
				<div id="div_skillLevel_@{{key}}" name="div_skillLevel_@{{key}}"></div>
			</td>
			<td class="text-center">
				<input type="text" id="skillPlace_@{{key}}" class="w100">
			</td>
			<td class="text-center">
				<input type="hidden" id="skillCertificate_@{{key}}" class="w100">
				<div id="div_skillCertificate_@{{key}}" name="div_skillCertificate_@{{key}}"></div>
			</td>
			<td class="text-center">
				<input type="hidden" id="start-date-value_sk_@{{key}}" value="">
				<div id="divStartDate_sk_@{{key}}"></div>
			</td>
			<td colspan="2"  class="text-center">
				<input type="hidden" id="end-date-value_sk_@{{key}}" value="">
				<div id="divEndDate_sk_@{{key}}"></div>
			</td>
			{{--<td class="text-center">--}}
				{{--<button ng-if="key != 0" type="button" ng-click="removeMoreSkill(key)">--}}
					{{--<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>--}}
				{{--</button>--}}
			{{--</td>--}}
		  </tr>
		  <tr>
			<td colspan="5" class="text-right">
				<label>{{trans('general_knowlegde.more_skill_level')}}</label>
			</td>
			<td class="text-center">
				<button type="button" ng-click="addMoreSkill()">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				</button>
			</td>
		  </tr>

		  <tr>
			<td colspan="6" style="font-weight: bold;">{{trans('general_knowlegde.study_course_level')}}</td>
		  </tr>

		  <tr ng-repeat="(key, value) in knowledge_un">
			<td class="text-center">
				<input type="text" id="studyCourseLevel_@{{key}}" class="w100" placeholder="{{trans('officer.level')}}">
			</td>
			<td class="text-center">
				<input type="text" id="studyCoursePlace_@{{key}}" class="w100" placeholder="{{trans('officer.place')}}">
			</td>
			<td class="text-center">
				<input type="text" id="studyCourseCertificate_@{{key}}" class="w100" placeholder="{{trans('general_knowlegde.get_certificate')}}">
			</td>
			<td class="text-center">
				<input type="hidden" id="start-date-value_un_@{{key}}" value="">
				<div id="divStartDate_un_@{{key}}"></div>
			</td>
			<td class="text-center">
				<input type="hidden" id="end-date-value_un_@{{key}}" value="">
				<div id="divEndDate_un_@{{key}}"></div>
			</td>
		    <td class="text-center">
				<button type="button" ng-if="key != 0" ng-click="removeMoreCertificate(key)">
					<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
				</button>
			</td>
		  </tr>
		  <tr>
			<td colspan="5" class="text-right">
				<label>{{trans('general_knowlegde.more_study_course_level')}}</label>
			</td>
			<td class="text-center">
				<button type="button" ng-click="addMoreCertificate()">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				</button>
			</td>
		  </tr>
		</tbody>
	</table>

	<div class="modal-confirm modal fade" id="ModalConfirm_sk" role="dialog">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-body">
			<h4>{{$constant['AreYouSure']}}</h4>
		  </div>
		  <div class="modal-footer">
			<button id="btnRemoveWorkHistory_sk" ng-click="removeMoreSkill()" type="button" class="btn btn-primary btn-confrim-ok">{{$constant['Ok']}}</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">{{$constant['Cancel']}}</button>
		  </div>
		</div>
	  </div>
	</div>

	<div class="modal-confirm modal fade" id="ModalConfirm_un" role="dialog">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-body">
			<h4>{{$constant['AreYouSure']}}</h4>
		  </div>
		  <div class="modal-footer">
			<button id="btnRemoveWorkHistory_un" ng-click="removeMoreCertificate()" type="button" class="btn btn-primary btn-confrim-ok">{{$constant['Ok']}}</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">{{$constant['Cancel']}}</button>
		  </div>
		</div>
	  </div>
	</div>

    </div>
	<div class="row" style="margin-left: 0px;">
		<div class="btn-save">
			@if($viewControllerStatus == true)
            	<a href="#award-sanction"  class="btn btn-primary btn-edit"><i class="fa fa-arrow-left"></i> {{trans('trans.buttonPrev')}}</a>
			@endif
				<button type="button" class="btn btn-primary btn-edit" ng-click="saveGeneralKnowledge(url)">{{trans('trans.buttonSave')}} <i class="fa fa-save"></i></button>
			@if($viewControllerStatus == true)
            	<a href="#ability-foreign-language"  class="btn btn-primary btn-edit">{{trans('trans.buttonNext')}} <i class="fa fa-arrow-right"></i></a>
			@endif
			@if($viewControllerStatus == false)
				<a href="javascript:void(0);" class="btn btn-primary btn-edit btn-close" ng-click="closeForm('FormGeneralKnowledge')" dataFormId="FormGeneralKnowledge">{{trans('trans.buttonclose')}}</a>
			@endif
		</div>
	</div>
</form>
</div>
<div id="listDegreeData" class="display-none"><?php echo json_encode($listDegree);?></div>
<div id="listUnderDegreeData" class="display-none"><?php echo json_encode($listUnderDegree);?></div>
<div id="listUnderSkillData" class="display-none"><?php echo json_encode($listUnderSkill);?></div>
<script>
	// Help hover
	$( ".block-5 .help" ).tooltip({ content: '<img src="images/6.png" class="tooltip-img" />' });
</script>
