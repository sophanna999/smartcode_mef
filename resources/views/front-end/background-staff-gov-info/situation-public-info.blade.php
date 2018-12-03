<?php
	$getFirstUnitUrl	=	asset('background-staff-gov-info/first-unit-list');
	$getFirstDepartmentUrl	=	asset('background-staff-gov-info/first-department-list');
	$getFirstOfficeListUrl	=	asset('background-staff-gov-info/first-office-list');
?>
<div id="situation-public-info" class="<?php echo $blgFadeEditClass; ?>" ng-controller="situationPublicInfoController">
	<form name="situation-public-info">
		<section>
			<div class="block-21">
{{--				<h2>{{trans('situation_public_info.situation_public_info')}}</h2>--}}
				<img src="images/help.png" title="" class="help">
			</div>
		<section>
			<h3>{{trans('situation_public_info.first_start_working_gov')}}</h3>
			<div class="clear ws-2 pt20">
				<label><span class="col-red">*</span>{{trans('situation_public_info.first_start_working_date_gov')}}</label>
				<input type="hidden" id="FIRST_START_WORKING_DATE_FOR_GOV_VALUE" name="FIRST_START_WORKING_DATE_FOR_GOV" ng-model="publicInfo.FIRST_START_WORKING_DATE_FOR_GOV" value="">
				<div id="DIV_FIRST_START_WORKING_DATE_FOR_GOV"></div>
			</div>

			<div class="ws-2 pt20">
				<label>{{trans('situation_public_info.date_get_officer')}}</label>
				<input type="hidden" id="FIRST_GET_OFFICER_DATE_VALUE" ng-model="publicInfo.FIRST_GET_OFFICER_DATE" value="">
					<div id="DIV_FIRST_GET_OFFICER_DATE"></div>
			</div>


			<div class="ws-2 pt20">
				<label><span class="col-red">*</span>{{trans('officer.class_rank')}}</label>
				<input type="hidden" class="w100" placeholder="ក្របខ័ណ្ឌឋានន្តរស័ក្តិ និងថ្នាក់" id="FIRST_OFFICER_CLASS" ng-model="publicInfo.FIRST_OFFICER_CLASS">
				<div id="DIV_FIRST_OFFICER_CLASS"></div>
			</div>
			<div class="ws-2 pt20">
				<label><span class="col-red">*</span>{{trans('trans.position')}}</label>
				<input type="hidden" class="w100" id="FIRST_POSITION" name="FIRST_POSITION">
				<div id="DIV_FIRST_POSITION"></div>
			</div>
			<div class="clear ws-2 pt20">
				<label><span class="col-red">*</span>{{trans('officer.centralMinistry')}}</label>
				<input type="hidden" class="w100" ng-model="publicInfo.FIRST_MINISTRY" id="FIRST_MINISTRY" name="FIRST_MINISTRY">
				<div id="DIV_FIRST_MINISTRY"></div>
			</div>
			<div class="ws-2 pt20">
				<label><span class="col-red">*</span>{{trans('officer.working_place')}}</label>
				<input type="hidden" class="w100" placeholder="{{trans('officer.working_place')}}" ng-model="publicInfo.FIRST_UNIT" id="FIRST_UNIT">
				<div id="DIV_FIRST_UNIT"></div>
			</div>
			<div class="clear ws-2 pt20">
				<label><span class="col-red">*</span>{{trans('officer.department')}}</label>
				<input type="hidden" class="w100" placeholder="{{trans('officer.working_place')}}" ng-model="publicInfo.FIRST_DEPARTMENT" id="FIRST_DEPARTMENT">
				<div id="DIV_FIRST_DEPARTMENT"></div>
			</div>
			<div class="ws-2 pt20">
				<label>{{trans('officer.office')}}</label>
				<input type="hidden" class="w100" placeholder="{{trans('trans.officer')}}" ng-model="publicInfo.FIRST_OFFICE" id="FIRST_OFFICE">
				<div id="DIV_FIRST_OFFICE"></div>
			</div>
		</section>
		<section>
			<h3>{{trans('situation_public_info.current_job_situation')}}</h3>
			<div class="clear ws-2 pt20">
				<label><span class="col-red">*</span>{{trans('officer.class_rank')}}</label>
				<input type="hidden" id="CURRENT_OFFICER_CLASS" class="w100" placeholder="ក្របខ័ណ្ឌឋានន្តរស័ក្តិ និងថ្នាក់" ng-model="publicInfo.CURRENT_OFFICER_CLASS">
				<div id="DIV_CURRENT_OFFICER_CLASS"></div>
			</div>
			<div class="ws-2 pt20" style="width: 48%;">
				<label>{{trans('situation_public_info.last_date_promote_officer')}}</label>
				<div style="margin-top:5px;">
					<input type="hidden" id="CURRETN_PROMOTE_OFFICER_DATE_VALUE" value="" ng-model="publicInfo.CURRETN_PROMOTE_OFFICER_DATE">
					<div id="DIV_CURRETN_PROMOTE_OFFICER_DATE"></div>
				</div>
			</div>
			<div class="clear ws-2 pt20">
				<label><span class="col-red">*</span>{{trans('trans.position')}}</label>
				<input type="hidden" class="w100" ng-model="publicInfo.CURRENT_POSITION" id="CURRENT_POSITION" name="CURRENT_POSITION">
				<div id="DIV_CURRENT_POSITION"></div>
			</div>
			<div class="ws-2 pt20">
				<label>{{trans('situation_public_info.last_date_get_position')}}</label>
				<div style="margin-top:5px;">
					<input type="hidden" id="CURRENT_GET_OFFICER_DATE_VALUE" value="" ng-model="publicInfo.CURRENT_GET_OFFICER_DATE">
					<div id="DIV_CURRENT_GET_OFFICER_DATE"></div>
				</div>
			</div>
			<div class="clear ws-2 pt20">
				<label><span class="col-red">*</span>{{trans('officer.centralMinistry')}}</label>
				<input type="hidden" class="w100" placeholder="{{trans('situation_public_info.current_work_place')}}" ng-model="publicInfo.CURRENT_MINISTRY" id="CURRENT_MINISTRY">
				<div id="DIV_CURRENT_MINISTRY"></div>
			</div>
			<div class="clear ws-2 pt20">
				<label>{{trans('situation_public_info.current_work_place')}}</label>
				<input type="hidden" class="w100" placeholder="{{trans('situation_public_info.current_work_place')}}" ng-model="publicInfo.CURRENT_GENERAL_DEPARTMENT" id="CURRENT_GENERAL_DEPARTMENT">
				<div id="DIV_CURRENT_GENERAL_DEPARTMENT"></div>
			</div>
			<div class="ws-2 pt20">
				<label>{{trans('officer.department')}}</label>
				<input type="hidden" class="w100" placeholder="{{trans('officer.department')}}" ng-model="publicInfo.CURRENT_DEPARTMENT" id="CURRENT_DEPARTMENT">
				<div id="DIV_CURRENT_DEPARTMENT"></div>
			</div>
			<div class="ws-2 pt20">
				<label> {{trans('officer.office')}}</label>
				<input type="hidden" class="w100" placeholder="{{trans('officer.office')}}" ng-model="publicInfo.CURRENT_OFFICE" id="CURRENT_OFFICE">
				<div id="DIV_CURRENT_OFFICE"></div>
			</div>
		</section>
		<section>
			<h3>
				{{trans('situation_public_info.additional_position')}}
			</h3>

			<div class="clear ws-2 pt20">
					<label>{{trans('situation_public_info.working_date_gov')}}</label>
					<input type="hidden" id="ADDITIONAL_WORKING_DATE_FOR_GOV_VALUE" value="" ng-model="publicInfo.ADDITIONAL_WORKING_DATE_FOR_GOV">
					<div id="DIV_ADDITIONAL_WORKING_DATE_FOR_GOV"></div>


			</div>
			<div class="ws-2 pt20">
				<label>{{trans('trans.position')}}</label>
				<input type="hidden" class="w100" ng-model="publicInfo.ADDITIONAL_POSITION" id="ADDITIONAL_POSITION" name="ADDITIONAL_POSITION">
				<div id="DIV_ADDITIONAL_POSITION"></div>
			</div>
			<div class="clear ws-2 pt20">
				<label>{{trans('officer.position_equal_to')}}</label>
				<input id="ADDITINAL_STATUS" type="text" class="w100" placeholder="{{trans('officer.position_equal_to')}}" ng-model="publicInfo.ADDITINAL_STATUS">
			</div>
			<div class="ws-2 pt20">
				<label>{{trans('officer.working_place')}}</label>
					<input id="ADDITINAL_UNIT" type="text" class="w100" placeholder="{{trans('officer.working_place')}}" ng-model="publicInfo.ADDITINAL_UNIT">
			</div>
		</section>
			<section class="block-24">
				<h3>{{trans('situation_public_info.situation_outside')}}</h3>
				<table class="table table-bordered tbl-middle">
					<thead>
					  <tr>
						<th class="text-center">{{trans('trans.autoNumber')}}</th>
						<th class="col-sm-7 text-center">{{trans('situation_public_info.work_place')}}</th>
						<th class="col-sm-2 text-center">{{trans('situation_public_info.start')}}</th>
						<th class="col-sm-2 text-center">{{trans('situation_public_info.end')}}</th>
						<th class="col-sm-2 text-center"></th>
					  </tr>
					</thead>
					<tbody>
						<tr ng-repeat="(key, value) in framework">
							<td class="text-center">@{{dayFormat(key + 1)}}</td>
							<td class="text-center">
								<input type="text" class="w100" placeholder="{{trans('trans.autoNumber')}}" ng-model="value.INSTITUTION" id="INSTITUTION_@{{key}}">
							</td>
							<td class="text-center">
								<input type="hidden" id="START_DATE_VALUE_@{{key}}" ng-model="value.START_DATE">
								<div id="DIV_START_DATE_@{{key}}"></div>
							</td>
							<td class="text-center">
								<input type="hidden" id="END_DATE_VALUE_@{{key}}" ng-model="value.END_DATE">
								<div id="DIV_END_DATE_@{{key}}"></div>
							</td>
							<td class="text-center">
								<button ng-if="key >= 1" type="button" ng-click="removeMoreframework(key)">
									<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
								</button>
							</td>
						</tr>
						<tr>
							<td colspan="4" class="text-right">
								<label>{{trans('situation_public_info.more_info_work_place')}}</label>
							</td>
							<td class="text-center">
								<button type="button" ng-click="addMoreframework()">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
								</button>
							</td>
						</tr>
					</tbody>
				</table>
				<img src="{{ asset('images/help.png') }}" title="" class="help">
			</section>
			<section class="block-25">
				<h3>{{trans('situation_public_info.situation_free')}}</h3>
				<table class="table table-bordered tbl-middle">
					<thead>
					  <tr>
						<th class="text-center">{{trans('trans.autoNumber')}}</th>
						<th class="col-sm-7 text-center">{{trans('situation_public_info.work_place')}}</th>
						<th class="col-sm-2 text-center">{{trans('situation_public_info.start')}}</th>
						<th class="col-sm-2 text-center">{{trans('situation_public_info.end')}}</th>
						<th class="col-sm-2 text-center"></th>
					  </tr>
					</thead>
					<tbody>
						<tr ng-repeat="(key, value) in frameworkFree">
							<td class="text-center">@{{dayFormat(key + 1)}}</td>
							<td class="text-center">
								<input type="text" class="w100" placeholder="ស្ថាប័ន/អង្គភាព" ng-model="value.INSTITUTION" id="INSTITUTION_FREE_@{{key}}">
							</td>
							<td class="text-center">
								<input type="hidden" id="START_DATE_VALUE_FREE_@{{key}}" ng-model="value.START_DATE">
								<div id="DIV_START_DATE_FREE_@{{key}}"></div>
							</td>
							<td class="text-center">
								<input type="hidden" id="END_DATE_VALUE_FREE_@{{key}}" ng-model="value.END_DATE">
								<div id="DIV_END_DATE_FREE_@{{key}}"></div>
							</td>
							<td class="text-center">
								<button ng-if="key >= 1" type="button" ng-click="removeMoreframeworkFree(key)">
									<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
								</button>
							</td>
						</tr>
						<tr>
							<td colspan="4" class="text-right">
								<label>{{trans('situation_public_info.more_info_work_place')}}</label>
							</td>
							<td class="text-center">
								<button type="button" ng-click="addMoreframeworkFree()">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</section>
			<div class="btn-save">
				@if($viewControllerStatus == true)
					<a href="#personal-info" class="btn btn-primary btn-edit"><i class="fa fa-arrow-left"></i> {{trans('trans.buttonPrev')}}</a>
				@endif
                <a href="javascript:void(0)" ng-click="saveSituationPublicInfo()" class="btn btn-primary btn-edit">{{trans('trans.buttonSave')}} <i class="fa fa-save"></i></a>
				@if($viewControllerStatus == true)
                	<a href="#working-histroy"  class="btn btn-primary btn-edit">{{trans('trans.buttonNext')}} <i class="fa fa-arrow-right"></i></a>
				@endif
				@if($viewControllerStatus == false)
					<a href="javascript:void(0);" class="btn btn-primary btn-edit btn-close" ng-click="closeForm('FormSituationPublicInfoController')" dataFormId="FormSituationPublicInfoController">{{trans('trans.buttonclose')}}</a>
				@endif
			</div>
		</section>
	</form>

	<!-- Modal Confirmation ស្ថានភាពស្ថិតនៅក្រៅក្របខ័ណ្ឌដើម // ស្ថានភាពស្ថិតនៅភាពទំនេរគ្មានបៀវត្ស -->
	<div class="modal-confirm modal fade" id="ModalConfirmMoreframework" role="dialog">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-body">
			<h4>{{$constant['AreYouSure']}}</h4>
		  </div>
		  <div class="modal-footer">
			<button id="btnRemoveMoreframework" ng-click="removeMoreframework()" type="button" class="btn btn-primary btn-confrim-ok">{{$constant['Ok']}}</button>
			<button id="btnRemoveMoreframeworkFree" ng-click="removeMoreframeworkFree()" type="button" class="btn btn-primary btn-confrim-ok">{{$constant['Ok']}}</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">{{$constant['Cancel']}}</button>
		  </div>
		</div>
	  </div>
	</div>
	<div id="listPositionsJson" class="display-none"><?php echo $listPositions; ?></div>
	<div id="listDepartmentsJson" class="display-none"><?php echo $listDepartments;?></div>
	<div id="listDepartmentsOfficeJson" class="display-none"><?php echo $listDepartmentsOffice;?></div>
	<div id="listClassRanksJson" class="display-none"><?php echo $listClassRanks;?></div>
</div>
<style>
	.no-space{
		margin-left : 0px !important;
		padding-left : 0px !important;
	}
	.no-right{
		margin-right : 0px !important;
		padding-right : 0px !important;
	}
	input[type="checkbox"]{
	  width: 20px;
	  height: 20px;

	}
	.padding-right30{
		padding-right: 30px;
	}
</style>
