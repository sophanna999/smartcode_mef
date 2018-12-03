<div id="custom-modal"​​>
  <div id="overlay"> 		
		<button type="button" class="close" ng-click="close()" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" style="padding-bottom: 10px;">@{{title}}</h4>
		<form role="form" name="tran_right" ng-submit="rightTran()">
			<div class="form-group row">							
				<div class="col-sm-6 col-md-6 col-lg-8">
					<label class="jqx-input-content"><span class="col-red">*</span>{{trans('attendance.transfer_to')}}</label>
					<jqx-combo-box  name="mef_officer" ng-model="app.officer_id" required jqx-settings="comboboxSettingsOfficer"></jqx-combo-box>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 text-right" style="padding-top: 30px;">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
			<div class="form-group row">						
			</div>
		</form>
		
  </div>
  <div id="fade"></div>
</div>

<style type="text/css">
	.jqx-calendar-cell-weekend
    {
        color: #5583c8;
    }
</style>
