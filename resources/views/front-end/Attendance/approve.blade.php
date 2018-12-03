<div id="award-sanctions" ng-controller="ApproveTakeLeaveController" class="container-fluid">
	<div class="h2-schedule header-title">អនុញ្ញាតច្បាប់</div>
	<div class="group-btn-attend" style="margin:0px;">

		<a href="#/attendance-info">
			<div class="btn-req-control" style="padding:12px 30px 0px 42px">
				<p>ទៅកាន់ វត្តមាន</p>

			</div>
		</a>
    </div>
    <table class="tblModule tblSchedule tblAttend">
    	<tr>
        	<th>ល រ</th>
            <th>ឈ្មោះអ្នកស្នើសុំ</th>
            <th>រយៈពេល(ថ្ងៃ)</th>
						<th>ថ្ងៃស្នើសុំច្បាប់</th>
            <th>ពិនិត្យ</th>
            <th>សកម្មភាព</th>
        </tr>
				<tr>
					<th></th>
					<th><input ng-model="user.FULL_NAME_KH"></th>
					<th></th>
					<th></th>
					<th colspan="2"><jqx-combo-box  ng-model="user.own_app" required jqx-settings="cboApprove"></jqx-combo-box></th>
				</tr>
		<tr ng-repeat="user in listTakeByUser | filter:user">
        	<td>@{{ $index + 1}}</td>
            <td>@{{user.FULL_NAME_KH}}</td>
			<td>@{{user.day}} ថ្ងៃ</td>
			<td>@{{user.start_dt}} - @{{user.end_dt}}</td>

			<td  ng-if="user.own_app==0"><label class="col-red"> មិនទាន់ពិនិត្យ</label></td>
			<td  ng-if="user.own_app==1"><label> អនុញ្ញាត </label></td>
			<td  ng-if="user.own_app==2"><label class="col-red"> មិនអនុញ្ញាត</label></td>
            <th>
				<button type="button" class="btn btn-default" ng-click="showApprove()" ng-if="user.own_app ==0 && user.status <2">ពិនិត្យ</button>
			</th>
        </tr>

    </table>
</div>
 <br>
