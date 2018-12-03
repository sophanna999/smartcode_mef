<div id="award-sanctions" ng-controller="updateAccountController" class="container-fluid">

	
	<div class="block-21">
		<h2>កែសម្រួលគណនី</h2>
		
	</div>
	<div class="block-21" >
		<jqx-tabs jqx-settings="tabsSettings" jqx-width="'99%'" jqx-height="'50%'">
			<ul style='margin-left: 30px;'>
				<li>ផ្លាស់ប្តូរលេខសម្ងាត់</li>
				{{--<li>ឈ្មោះអ្នកទាញយកប្ររត្តិរូប</li>		--}}
			</ul>
			
			<div>
				<h3>ផ្លាស់ប្តូរលេខសម្ងាត់</h3>
				<div class="clear ws-2" style="padding-top:10px;">
					<form role="form" name="myForm" ng-submit="submit()">
						<div class="form-group row pd-lef-0 pd-right-2">
							<div class="col-xs-6 pd-lef-0 pd-right-2">
								<label class="jqx-input-content">ឈ្មោះអ្នកប្រើប្រាស់</label>
								<input type="text" ng-model="user" autocomplete="off" class="form-control file"  placeholder="ឈ្មោះអ្នកប្រើប្រាស់">
							</div>
							<div class="col-xs-6 pd-lef-0 pd-right-2">
								<label class="jqx-input-content">លេខសម្ងាត់ចាស់</label>
								<input type="password" autocomplete="off" ng-model="oldPass"  class="form-control file"  placeholder="លេខសម្ងាត់ចាស់">
							</div>
						</div>
						<div class="form-group row pd-lef-0 pd-right-2" >
							<div class="col-xs-6 pd-lef-0 pd-right-2" ng-class="{'has-error':!myForm.password.$valid}">
								<label class="jqx-input-content">លេខសម្ងាត់ថ្មី</label>
								<input class="form-control file" type="password" name="password" placeholder="លេខសម្ងាត់ថ្មី" required ng-model="password" />
								<span class="help-block jqx-input-content" ng-show="myForm.password.$error.required"></span>
							</div>
							<div class="col-xs-6 pd-lef-0 pd-right-2" ng-class="{'has-error':!myForm.passwordConfirmation.$valid}">
								<label class="jqx-input-content">បញ្ចាក់លេខសម្ងាត់</label>
								<input class="form-control file" type="password" name="passwordConfirmation" placeholder="បញ្ចាក់លេខសម្ងាត់" required ng-model="passwordConfirmation" password-confirm match-target="password" />
								<span class="help-block jqx-input-content" ng-show="myForm.passwordConfirmation.$error.required"></span>
							</div>
						</div>
						<div class="form-group row pd-lef-0 pd-right-0 pad-top-3">						
							<button ng-disabled="myForm.$invalid" type="button"​ ng-click="changePassword()" class="btn btn-primary btn-edit">ផ្លាស់ប្តូរលេខសម្ងាត់</button>
							<span class="help-block" ng-show="myForm.passwordConfirmation.$error.match">Passwords do not match.</span>							
						</div>
					</form>
				</div>
			</div>
			{{--<div>--}}
				{{--<h3>ឈ្មោះអ្នកទាញយកប្ររត្តិរូប</h3>--}}
				{{--<div class="clear ws-1"style="padding-bottom:15px;float:left;padding-top:10px;"​>--}}
					{{--<form role="form" name="addProfile" ng-submit="submit()">--}}
						{{--<div class="form-group row pd-lef-0 pd-right-2">--}}
							{{--<div class="col-xs-4">--}}
								{{--<label class="jqx-input-content"><span class="col-red">*</span>ឈ្មោះអ្នកប្រើប្រាស់</label>--}}
								{{--<input type="text" ng-model="app.user" required autocomplete="off" class="form-control file" placeholder="ឈ្មោះអ្នកប្រើប្រាស់">--}}
							{{--</div>--}}
							{{--<div class="col-xs-4">--}}
								{{--<label class="jqx-input-content"><span class="col-red">*</span>លេខសម្ងាត់</label>--}}
								{{--<input type="password" autocomplete="off" required ng-model="app.oldPass" placeholder="លេខសម្ងាត់" class="form-control file">--}}
							{{--</div>--}}
							{{--<div class="col-xs-4 pd-lef-0 pd-right-2" style="padding-top:18px;">--}}
								{{--<button ng-disabled="addProfile.$invalid" type="button"​ ng-click="addOfficerRequest()" class="btn btn-primary btn-edit">បញ្ចូលទិន្នន័យ</button>--}}
							{{--</div>--}}
						{{--</div>--}}
					{{--</form>--}}
				{{--</div>--}}
				{{--<div class="clear ws-1"style="padding-bottom:15px;float:left; width:97%"​>--}}
					 {{--<div ui-grid="gridOptions" class="grid"></div>--}}
				{{--</div>--}}
			{{--</div>--}}
		</jqx-tabs>
		  <!-- Modal -->
		  <div class="modal fade" id="myModalSMS" role="dialog">
			<div class="modal-dialog">
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove" style="font-size: 16px;"></span></button>
				  <h4 class="modal-title">@{{title}}</h4>
				</div>
				<div class="modal-body">
				  <p>@{{message}}</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">មិនយល់ព្រម</button>
					<button type="button" class="btn btn-primary btn-ok" data-record-id="@{{removeId}}" ng-click="agreeRemove(this)">យល់ព្រម</button>
			
				</div>
			  </div>
			  
			</div>
		  </div>
		  
	</div>
	
</div>

<style>
input[type="text"], input[type="email"], input[type="tel"], input[type="date"] {
    border: 1px solid #ccc;
	padding: 6px 12px;
}
.jqx-input-content{
	font-size: 16px;
}
.button-check{
	padding: 5px 25px;margin: 10px 10px;font-size: 12px;
}
.button-close{
	padding: 5px 25px;margin: 10px 10px;font-size: 13px;
}
</style>
