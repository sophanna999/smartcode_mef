<div id="award-sanctions" ng-controller="ScanHistoryController" class="container-fluid">
<!--start innerhead-->

<div class="inner-head">
	<div id="wrap-search">
		
	</div>
	<nav aria-label="breadcrumb" >
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">ទំព័រដើម</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{trans('attendance.list_scan_history')}}កាលវិភាគ</li>
		</ol>
	</nav>
	<div class=" header-title">{{trans('attendance.list_scan_history')}}</div>
</div>
<!--end innerhead-->
<div class="inner-content">
	<div class="col-md-12 pull-right">
			<a href="#/attendance-info">
				<div class="btn btn-lg btn-success btn-box-save pull-right">
				<p>{{trans('attendance.attendance')}}</p>
				</div>
			</a>
		</div>
	<table class="tblModule tblSchedule tblAttend table table-striped table-hover">
		<tr>
			<th>ល រ</th>
			<th>{{trans('attendance.date')}}</th>
			<th colspan="2">{{trans('attendance.morning')}}</th>
			<th colspan="2">{{trans('attendance.evening')}}</th>
		</tr>
		<tr>
			<th></th>
			<th style="padding: 5px 0px;"> <jqx-date-time-input jqx-on-change="change(event)" jqx-settings="settings"></jqx-date-time-input></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			
		</tr>
		<tr ng-repeat="data in datas | filter:data">
			<td>@{{ $index + 1}}</td>
			<td>@{{data.date}}</td>
			<td>@{{data.morning_checkin}}</td>
			<td>@{{data.morning_checkout}}</td>
			<td>@{{data.evening_checkin}}</td>
			<td>@{{data.evening_checkout}}</td>
			
		</tr>

	</table>
</div>
</div>
<br>
