<div id="award-sanctions" ng-controller="updateAccountController" class="container-fluid">
	<div class="block-21">
		<h2>{{trans('attendance.attendance')}}</h2>
	</div>
	<div class="block-21" >
		<jqx-tabs jqx-settings="tabsSettings" jqx-width="'99%'" jqx-height="'50%'">
			<ul style='margin-left: 30px;'>	
				<li>{{trans('attendance.take_leave')}}</li>	
			</ul>
			
			<div ng-controller="TakeLeaveController">
				<h3>{{trans('attendance.take_leave')}}</h3>				
				<div class="clear ws-1"style="padding-bottom:15px;margin-left:18px;float:left; width:97%"​>
					<div class="row">
						<div class="col-md-2 col-lg-2">
							<button  type="button"​ ng-click="showCustom()" class="btn btn-primary btn-edit khmermef-1">{{trans('attendance.take_request')}}</button>
						</div>
					
						<div class="col-md-10 col-lg-10 text-right" style="padding-right:20px;">
							<div class="btn-group btn-group-justified" role="group">
								
								<div class="input-group khmermef-1">
									<div style="padding:15px; float:left; background:#8c9ab4;">@{{num_take}} {{trans('attendance.day')}}</div>
									<label style="float:left;display:block; padding:10px 24px 0px 15px; text-align:left;">{{trans('attendance.attendance_number')}} <br> {{trans('attendance.18days')}}</label>
									<div style="padding:15px; float:left; background:#f9a743;">@{{num_allow}} {{trans('attendance.time')}}</div>
									<label style="float:left;display:block; padding:10px 24px 0px 15px; text-align:left;">{{trans('attendance.aprove')}} </label>
									
								</div>
								
							</div>
							
						</div>
					</div>
					
				</div>
				
				<div class="clear ws-1" style="padding-bottom:15px;float:left; width:96%"​>
					<div ui-grid="gridOptions" class="grid"></div>	
				</div>
			</div>
		</jqx-tabs>
		<!-- Modal -->
		<div class="modal fade" id="myModalSMS" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove" style="font-size: 16px;"></span></button>
					  <h4 class="modal-title khmermef-1">@{{title}}</h4>
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
.jqx-tabs-content-element{
	overflow:hidden;
}
.jqx-widget-content,.khmermef-1{
	font-family: 'KHMERMEF1';
}
.jqx-combobox-multi-item a:link, .jqx-combobox-multi-item a:visited{
	font-family: 'KHMERMEF1';
}
</style>
