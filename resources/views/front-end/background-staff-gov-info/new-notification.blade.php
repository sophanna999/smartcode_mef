<div id="new-notification" ng-controller="newNotificationController" class="container-fluid">
	<div class="block-21">
		<div>
			<h3>ពត៍មានទទួលបាន</h3>
			<table class="table table-bordered table-striped">
				<thead>
					<tr class="title-notifi">
						<td width="5%">ល.រ</td>
						<td width="13%">ប្រភេទ</td>
						<td width="12%">ផ្តល់ដោយ</td>
						<td width="50%">បរិយាយ</td>
						<td width="12%">កាលបរិច្ឆេទ</td>
						<td width="8%">សេចក្តីលំអិត</td>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in NewNotification">
						<td width="5%" class="text-center" valign="middle">@{{$index + 1}}</td>
						<td width="13%">@{{item.TITLE}}</td>
						<td width="12%">@{{item.FROM_USER}}</td>
						<td width="50%"><div ng-bind-html="item.COMMENT"></div></td>
						<td width="12%">@{{item.NEW_DATE}}</td>
						<td ng-if="item.METHOD_TYPE ==2" width="5%">
							<a ng-if="item.STATUS==1" href="updateInfo/detail/@{{item.FROM_USER_ID}}" class="btn btn-primary btn-edit">ពិនិត្យមើល</a>
						</td>
						<td ng-if="item.METHOD_TYPE != 2" width="8%"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
</div>

<style>
input[type="text"], input[type="email"], input[type="tel"], input[type="date"] {
    border: 1px solid #ccc;
}
.button-check{
	padding: 5px 25px;margin: 10px 10px;font-size: 12px;
}
.button-close{
	padding: 5px 25px;margin: 10px 10px;font-size: 13px;
}
.title-notifi{
	font-weight:bold;background-color: lightgray;
}
</style>