<div id="award-sanctions" class="<?php echo $blgFadeEditClass; ?>" ng-controller="awardSanctionController">
<form name="award-sanctions">
{{--	<h2>{{trans('officer.appreciation_award_sanctions')}}</h2><br>--}}
	<div class="row">
		<div class="block-4">
			<img src="images/help.png" title="" class="help">
		</div>
	</div>
    <div class="tblSection tbl-xrepeat" style="overflow-x:hidden;">
	<table class="table table-bordered respon-tbl tbl-middle">
	    <thead>
	      <tr>
	        <th class="text-center">{{trans('officer.document_number')}}</th>
	        <th class="text-center">{{trans('officer.date')}}</th>
	        <th class="text-center">{{trans('officer.appreciate_unit')}} ({{trans('officer.request')}})</th>
	        <th class="text-center">{{trans('officer.meaning')}}</th>
	        <th class="text-center">{{trans('officer.type')}}</th>
			<th class="text-center"></th>
	      </tr>
	      <tr><th colspan="6">{{trans('award_sanction.appreciate_award')}}</th></tr>
	    </thead>
	    <tbody>

		  <tr ng-repeat="(key, value) in awardSanctionType1">
	        <td class="text-center"><input type="text" placeholder="{{trans('officer.document_number')}}" ng-model="value.AWARD_NUMBER" class="w100"></td>
	        <td class="text-center">
				<input type="hidden" id="AWARD_DATE_TYPE_1_@{{key}}" value="" placeholder="">
				<div id="DIV_AWARD_DATE_TYPE_1_@{{key}}"></div>
			</td>
	        <td class="text-center">
				<input type="hidden" id="AWARD_REQUEST_DEPARTMENT_TYPE_1_@{{key}}" value="">
				<div id="DIV_AWARD_REQUEST_DEPARTMENT_TYPE_1_@{{key}}"></div>
			</td>
	        <td class="text-center">
				<input type="text" placeholder="{{trans('officer.meaning')}}" ng-model="value.AWARD_DESCRIPTION" class="w100">
			</td>
	        <td class="text-center">
				<input type="text" placeholder="{{trans('officer.type')}}" ng-model="value.AWARD_KIND" class="w100">
			</td>
			<td class="text-center">
				<button ng-if="key >= 1" type="button" ng-click="removeAwardSanctionType1(key)">
					<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
				</button>
			</td>
	      </tr>
	      <tr>
			<td colspan="5" class="text-right">
				<label>{{trans('award_sanction.more_appreciate_award')}}</label>
			</td>
			<td class="text-center">
				<button type="button" ng-click="addMoreAwardSanctionType1()">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				</button>
			</td>
		  </tr>
	      <thead>
	      	<tr><th colspan="6">{{trans('award_sanction.sanction')}}</th></tr>
	      </thead>
		  <tr ng-repeat="(key, value) in awardSanctionType2">
	        <td class="text-center"><input type="text" placeholder="{{trans('officer.document_number')}}" ng-model="value.AWARD_NUMBER" class="w100"></td>
	        <td class="text-center">
				<input type="hidden" id="AWARD_DATE_TYPE_2_@{{key}}" value="" placeholder="">
				<div id="DIV_AWARD_DATE_TYPE_2_@{{key}}"></div>
			</td>
	        <td class="text-center">
				<input type="hidden" id="AWARD_REQUEST_DEPARTMENT_TYPE_2_@{{key}}" value="">
				<div id="DIV_AWARD_REQUEST_DEPARTMENT_TYPE_2_@{{key}}"></div>
			</td>
	        <td class="text-center">
				<input type="text" placeholder="{{trans('officer.meaning')}}" ng-model="value.AWARD_DESCRIPTION" class="w100">
			</td>
	        <td class="text-center">
				<input type="text" placeholder="{{trans('officer.type')}}" ng-model="value.AWARD_KIND" class="w100">
			</td>
			<td class="text-center">
				<button ng-if="key >= 1" type="button" ng-click="removeAwardSanctionType2(key)">
					<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
				</button>
			</td>
	      </tr>
		  <tr>
			<td colspan="5" class="text-right">
				<label>{{trans('award_sanction.more_sanction')}}</label>
			</td>
			<td class="text-center">
				<button type="button" ng-click="addMoreAwardSanctionType2()">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				</button>
			</td>
		  </tr>
	    </tbody>
	</table>
    </div>
   <div class="row" style="margin-left: 0px;">
		<div class="btn-save">
			@if($viewControllerStatus == true)
				<a href="#working-histroy" class="btn btn-primary btn-edit"><i class="fa fa-arrow-left"></i> {{trans('trans.buttonPrev')}}</a>
			@endif
			<a href="javascript:void(0);" ng-click="saveAwardSanction()" class="btn btn-primary btn-edit">{{trans('trans.buttonSave')}} <i class="fa fa-save"></i></a>
			@if($viewControllerStatus == true)
				<a href="#general-knowledge" class="btn btn-primary btn-edit">{{trans('trans.buttonNext')}} <i class="fa fa-arrow-right"></i></a>
			@endif
			@if($viewControllerStatus == false)
				<a href="javascript:void(0);" class="btn btn-primary btn-edit btn-close" ng-click="closeForm('FormAwardSanctionController')" dataFormId="FormAwardSanctionController">{{trans('trans.buttonclose')}}</a>
			@endif
		</div>
   </div>  
</form>

<!-- Modal Confirmation គ្រឿងឥស្សរិយយស ប័ណ្ណសរសើរ // ទណ្ឌកម្មវិន័យ -->
<div class="modal-confirm modal fade" id="ModalConfirmAwardSanctionType" role="dialog">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-body">
		<h4>{{$constant['AreYouSure']}}</h4>
	  </div>
	  <div class="modal-footer">
		<button id="btnRemoveAwardSanctionType1" ng-click="removeAwardSanctionType1()" type="button" class="btn btn-primary btn-confrim-ok">{{$constant['Ok']}}</button>
		<button id="btnRemoveAwardSanctionType2" ng-click="removeAwardSanctionType2()" type="button" class="btn btn-primary btn-confrim-ok">{{$constant['Ok']}}</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">{{$constant['Cancel']}}</button>
	  </div>
	</div>
  </div>
</div>

<div class="display-none" id="listDepartmentJson"><?php echo json_encode($listDepartment);?></div>

</div>

<script type="text/javascript">
		// help hover
		$( ".block-4 .help" ).tooltip({ content: '<img src="images/5.png"  class="tooltip-img" />' });
</script>

<style>
	.btn-next,.btn-prev,.btn-summit,.btn-add:hover{
		cursor:pointer;
	}
	.btn-minus:hover{
		cursor:pointer;
	}
	.no-space{
		margin-left : 0px !important;
		padding-left : 0px !important;
	}
</style>