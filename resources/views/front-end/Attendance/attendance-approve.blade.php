<div id="custom-modal"​​>
  <div id="overlay">

		<button type="button" class="close" ng-click="close()" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" style="padding-bottom: 10px;">@{{title}}</h4>
		<form role="form" name="addProfile" ng-submit="takeLeave()">
			<div class="form-group row">
				<div class="col-xs-12">
					<br><p style="padding-left:60px">
					<span ng-if="profile.gender='ប្រុស'">ខ្ញុំបាទ ឈ្មោះ</span>
					<span ng-if="profile.gender!='ប្រុស'">នាងខ្ញុំ</span>
					<b>@{{profile.FULL_NAME_KH}} </b> ជា @{{profile.mef_position}} នៃ @{{profile.mef_department}} នៃ @{{profile.mef_secretariat}} 	ក្រសួងសេដ្ឋកិច្ច និង ហិរញ្ញវត្ថុ​

					</p><br>
				</div>
				<div class="col-xs-12">
					<label class="jqx-input-content">{{trans('attendance.reason')}} ៖</label>
					<p style="padding-left:60px">@{{profile.reason}} </p>
				</div>
				<div class="col-xs-12" style="padding:10px">
					<label class="red-star">
						<input type="radio" value="1" ng-model="app.approve" ng-click="changeApprove()" name="approve">
						{{trans('attendance.approve')}}
					</label>
					<label class="red-star">
						
						<input type="radio" id="approve" value="2" ng-model="app.approve" ng-click="changeApprove()" name="approve">
						{{trans('attendance.not_approve')}}
					</label>
				</div>
				
				<div class="col-xs-12" id="div_reson" style="display:none">
					<label class="jqx-input-content">{{trans('attendance.message')}}</label>
					<textarea id="comment" ng-model="app.reason" name="reason" style="width:100%; height:75px;" readonly>

					</textarea>

				</div>
			</div>
				<div class="col-xs-3 col-xs-offset-9 text-right">
					<button ng-disabled="addProfile.$invalid" type="submit"​ class="btn btn-primary btn-edit">អនុញ្ញាត</button>
				</div>
			</div>

		</form>
		<a href ng-click="close()">Close</a>

  </div>
  <div id="fade"></div>
</div>
