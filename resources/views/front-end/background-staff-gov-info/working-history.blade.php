<div id="working-info" class="<?php echo $blgFadeEditClass; ?>" ng-controller="workHistoryController">
<form name="working-info">
{{--  <h2>{{trans('officer.work_history')}} ({{trans('officer.please_fill_order_by_old_to_new')}})</h2>--}}
  <br>
  <div class="block-32">
     
	
	<img src="images/help.png" title="" class="help-3 help">
  </div>
     <div class="tblSection tbl-xrepeat">
         <h3>{{trans('work_history.public_working')}}</h3>
  <table class="table table-bordered respon-tbl tbl-middle">
    <thead>
      <tr>
        <th colspan="3" class="text-center" style="vertical-align: middle;">{{trans('work_history.working_date')}}</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;"><span class="col-red">*</span>{{trans('officer.centralMinistry')}}</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;"><span class="col-red">*</span>{{trans('officer.working_place')}}</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;"><span class="col-red">*</span>{{trans('trans.position')}}</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">{{trans('officer.position_equal_to')}}</th>
		<th rowspan="2" class="text-center" style="vertical-align: middle;"></th>
      </tr>
      <tr>
        <th class="text-center"><span class="col-red">*</span>{{trans('work_history.start_work')}}</th>
        <th class="text-center" colspan="2"><span class="col-red">*</span>{{trans('work_history.end_work')}}</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="(key, value) in workHistoryObj">
        <td>
			<input type="hidden" id="START_WORKING_DATE_@{{key}}" value="" placeholder="">
			<div id="DIV_START_WORKING_DATE_@{{key}}"></div>
        </td>
		<td><input class="current_check" id="CURRENT_CHECK_@{{key}}" ng-click="currentCheck(key)" type="checkbox">{{trans('work_history.current')}}</td>
        <td>
			<input type="hidden" id="END_WORKING_DATE_@{{key}}" value="" placeholder="">
			<div id="DIV_END_WORKING_DATE_@{{key}}"></div>
        </td>
        <td>
			<input type="text" id="DEPARTMENT_@{{key}}" placeholder="{{trans('officer.centralMinistry')}}" ng-model="value.DEPARTMENT">
        </td>
        <td>
			<input id="INSTITUTION_@{{key}}" type="text" placeholder="{{trans('officer.working_place')}}" ng-model="value.INSTITUTION">
        </td>
        <td>
			<input type="text" id="POSITION_@{{key}}" placeholder="{{trans('trans.position')}}" ng-model="value.POSITION">
   
        </td>
        <td>
			<input id="POSITION_EQUAL_TO_@{{key}}" type="text" placeholder="{{trans('officer.position_equal_to')}}" ng-model="value.POSITION_EQUAL_TO">
        </td>
		<td class="text-center">
			<button ng-if="key >= 1" type="button" ng-click="removeworkHistory(key)">
				<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
			</button>
		</td>
      </tr>
	  <tr>
		<td colspan="7" class="text-right">
			<label>{{trans('work_history.more_public_working')}}</label>
		</td>
		<td class="text-center">
			<button type="button" ng-click="addMoreworkHistory()">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
			</button>
		</td>
	   </tr>
      
    </tbody>
  </table>
    </div>

<div class="tblSection tbl-xrepeat">
    <h3>{{trans('work_history.private')}}</h3>
    <div id="childDiv" class="group-form childDiv">

    <table class="table table-bordered respon-tbl tbl-middle">
    <thead>
      <tr>
        <th colspan="2" class="text-center" style="vertical-align: middle;">{{trans('work_history.working_date')}}</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">{{trans('work_history.private_working_place')}}</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">{{trans('work_history.role')}}</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">{{trans('work_history.skill')}}</th>
		<th rowspan="2" class="text-center" style="vertical-align: middle;"></th>
      </tr>
      <tr>
        <th class="text-center">{{trans('work_history.start_work')}}</th>
        <th class="text-center">{{trans('work_history.end_work')}}</th>
      </tr>
    </thead>
    <tbody>

      <tr ng-repeat="(key, value) in workHistoryObjPrivate">
        <td>
          <input type="hidden" id="PRIVATE_START_DATE_@{{key}}" class="PRIVATE_START_DATE" value="" placeholder="">
          <div id="DIV_PRIVATE_START_DATE_@{{key}}"></div>
        </td>
        <td>
          <input type="hidden" id="PRIVATE_END_DATE_@{{key}}" value="" placeholder="">
          <div id="DIV_PRIVATE_END_DATE_@{{key}}"></div>
        </td>
        <td>
          <input type="text" placeholder="{{trans('work_history.private_working_place')}}" id="PRIVATE_DEPARTMENT_@{{key}}" ng-model="value.PRIVATE_DEPARTMENT">
        </td>
        <td>
          <input type="text" placeholder="{{trans('work_history.role')}}" id="PRIVATE_ROLE_@{{key}}" ng-model="value.PRIVATE_ROLE">
        </td>
        <td>
          <input type="text" id="PRIVATE_SKILL_@{{key}}" ng-model="value.PRIVATE_SKILL"  placeholder="{{trans('work_history.skill')}}">
        </td>
		<td class="text-center">
			<button ng-if="key >= 1" type="button" ng-click="removeworkHistoryPrivate(key)">
				<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
			</button>
		</td>
      </tr>
	  <tr>
		<td colspan="5" class="text-right">
			<label>{{trans('work_history.more_private')}}</label>
		</td>
		<td class="text-center">
			<button type="button" ng-click="addMoreworkHistoryPrivate()">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
			</button>
		</td>
	  </tr>
    </tbody>
  </table>
  </form>
  
	<!-- Modal Confirmation ក្នុងមុខងារសាធារណៈ // ក្នុងវិស័យឯកជន -->
	<div class="modal-confirm modal fade" id="ModalConfirmWorkHistory" role="dialog">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-body">
			<h4>{{$constant['AreYouSure']}}</h4>
		  </div>
		  <div class="modal-footer">
			<button id="btnRemoveWorkHistory" ng-click="removeworkHistory()" type="button" class="btn btn-primary btn-confrim-ok">{{$constant['Ok']}}</button>
			<button id="btnRemoveWorkHistoryPrivate" ng-click="removeworkHistoryPrivate()" type="button" class="btn btn-primary btn-confrim-ok">{{$constant['Ok']}}</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">{{$constant['Cancel']}}</button>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>

<div class="row" style="margin-left: 0px;">
  <div class="btn-save">
	@if($viewControllerStatus == true)
    	<a href="#situation-public-info"  class="btn btn-primary btn-edit"><i class="fa fa-arrow-left"></i> {{trans('trans.buttonPrev')}}</a>
	@endif
    <a href="javascript:void(0)" ng-click="saveWorkingHistory()" class="btn btn-primary btn-edit">{{trans('trans.buttonSave')}} <i class="fa fa-save"></i></a>
	@if($viewControllerStatus == true)
		<a href="#award-sanction" class="btn btn-primary btn-edit">{{trans('trans.buttonNext')}} <i class="fa fa-arrow-right"></i></a>
	@endif
	@if($viewControllerStatus == false)
		<a href="javascript:void(0);" class="btn btn-primary btn-edit btn-close" ng-click="closeForm('FormWorkHistoryController')" dataFormId="FormWorkHistoryController">{{trans('trans.buttonclose')}}</a>
	@endif
  </div>
</div>

<div id="listDepartmentJson" class="display-none"><?php echo json_encode($listDepartment);?></div>
<div id="listPositionJson" class="display-none"><?php echo json_encode($listPosition);?></div>
</div>
<script>
    $(document).ready(function(){
		// Help hover
		$( ".help-3" ).tooltip({ content: '<img src="images/4.png"   class="tooltip-img" />' });        
    });
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