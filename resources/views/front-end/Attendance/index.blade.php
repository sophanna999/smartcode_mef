<div id="award-sanctions" ng-controller="TakeLeaveController" class="container-fluid">
	<!--start innerhead-->

	<div class="inner-head">
		<div id="wrap-search">
			
		</div>
		<nav aria-label="breadcrumb" >
			<ol class="breadcrumb kbach-title">
				<li class="breadcrumb-item"><a href="#">ទំព័រដើម</a></li>
				<li class="breadcrumb-item header-title active" aria-current="page">{{trans('attendance.attendance')}}</li>
			</ol>
		</nav>
		<!-- <div class=" header-title">{{trans('attendance.attendance')}}</div> -->
	</div>
	<!--end innerhead-->
	<div class="inner-content">

		<div class="">
			<div id="container" style=""></div>
		</div>
		<div class="group-btn-attend">
			<div class="btn-req-attend" ng-click="showCustom()" ng-if="is_approver ==10">
				<p>ស្នើរសុំច្បាប់</p>
			</div>
			<a href="#/attendance-info/approve" ng-if="is_approver ==10">
				<div class="btn-req-control">
					<p>ពិនិត្យច្បាប់</p>
				</div>
			</a>
			<div class="btn-req-attend" ng-if="is_transfer ==10" ng-click="showTransfer()">
				<p>ផ្ទេរសិទ្ធ</p>
			</div>
			<div class="col-md-5 pull-right">
				<a href="#/attendance-info/list-scan-history">
					<div class="btn btn-lg btn-success btn-box-save pull-right">
						<p>{{trans('attendance.list_scan_history')}}</p>
					</div>
				</a>
			</div>
			
		</div>

		<table class="tblModule tblSchedule tblAttend">

			<thead>
				<tr>
					<th>ល រ</th>
					<th>ឈ្មោះអ្នកស្នើសុំ</th>            
					<th>អនុញ្ញាតដោយ</th>
					<th>ថ្ងៃស្នើសុំច្បាប់</th>
					<th>ដំណើរការ</th>
					<th>រយៈពេល(ថ្ងៃ)</th>
				</tr>
			</thead>	
			<tbody>
				<tr ng-repeat="user in listTake">        	
					<td>@{{ $index + 1}}</td>
					<td>@{{user.full_name_kh}}</td>
					<td><label ng-click="showTakeStatus()" class="pointer">អ្នកអនុញ្ញាតិ</label></td>	
					<td>@{{user.start_dt}} - @{{user.end_dt}}</td>	
					
					<td  ng-if="user.status==0"><label class="col-red"> រង់ចាំ</label></td>
					<td  ng-if="user.status==2"><label class="col-red"> មិនអនុញ្ញាត</label></td>
					<td  ng-if="user.status==1"><label> អនុញ្ញាត </label></td>
					<td  ng-if="user.section==3"><label> @{{user.day}} ថ្ងៃ</label></td>
					<td  ng-if="user.section==1"><label> @{{user.day}} ព្រឹក</label></td>
					<td  ng-if="user.section==2"><label> @{{user.day}} រសៀល </label></td>
				</tr>
			</tbody>

		</table>
	</div>
</div>