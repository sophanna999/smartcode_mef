<div id="custom-modal"​​>
  <div id="overlay"> 
		
		<button type="button" class="close" ng-click="close()" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" style="padding-bottom: 10px;">@{{title}}</h4>
		<form role="form" name="addProfile" ng-submit="takeLeave()">
			<div class="form-group row">
				<div class="col-sm-12 col-md-10 col-lg-10">
					<label class="jqx-input-content"><span class="col-red">*</span>{{trans('attendance.attendance_type')}}</label>
					<jqx-combo-box  name="take_leave_role"  ng-model="app.take_leave_role" jqx-settings="comboboxSettingsRoleType"></jqx-combo-box>
				</div>
			</div>
			<div class="form-group row">							
				
				<div class="col-sm-12 col-md-3 col-lg-3">
					<label class="jqx-input-content"><span class="col-red">*</span>{{trans('attendance.start_takeleave_date')}}</label>
					
					<div id="div_jqxcalendar_id" name="take_date"></div>
				</div>
				<div class="col-sm-12 col-md-2 col-lg-2">
					<label class="jqx-input-content"><span class="col-red">*</span>ចំនួន</label>
					<input type="text" id="num_day" ng-change="checkDate()" name="num_day" autocomplete="off"​  ng-model="app.num_day" placeholder="{{trans('attendance.duration')}}" class="form-control file">
				</div>
				<div class="col-sm-12 col-md-2 col-lg-2">
					<label class="jqx-input-content"><span class="col-red">*</span>{{trans('attendance.number_of_takeleave')}}</label>
					<jqx-combo-box  name="section" id="section" required ng-change="checkDate()" ng-model="app.section"   jqx-settings="comboboxSettingsSection"></jqx-combo-box>
				</div>
				<div class="col-sm-12 col-md-3 col-lg-3">
					<label class="jqx-input-content">{{trans('attendance.takeleave_date_comeback')}}</label>
					<input type="text" ng-model="app.come_back" id="come_back" name="come_back" readonly>
				</div>	
			</div>
			<div class="form-group row">
				<div class="col-sm-12 col-md-10 col-lg-10">
					<label class="jqx-input-content">{{trans('attendance.reason')}}</label>
					<textarea id="comment" required ng-model="app.reason" name="reason" placeholder="{{trans('attendance.reason')}}" style="width:100%; height:75px;" required></textarea>
				</div>	
							
				<div class="col-sm-12 col-md-2 col-lg-2 text-right">
					<button ng-disabled="addProfile.$invalid" type="submit"​ class="btn btn-primary btn-edit" style="margin-right:0px;">{{trans('attendance.permission')}}</button>
				</div>
			</div>
		</form>
		
  </div>
  <div id="fade"></div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
		
		/*calendar*/
        $("#div_jqxcalendar_id").jqxDateTimeInput({ width: 150, height: 30,formatString: "yyyy-MM-dd" });
        $('#div_jqxcalendar_id').on('change', function (event) 
		{  
			$data ={
				"section":$('#section').val(),
				"num_day":$('#num_day').val(),
				"take_date":$('#div_jqxcalendar_id').val(),
				"_token": _token
			}
			$.ajax({
                type: 'post',
				url: baseUrl+'attendance/check-date',
				dataType: "json",
				data:$data,
                success: function (response) {
                    console.log(response);
					$('#come_back').val(response[response.length-1]);
                },
                error: function (request, status, error) {
                    checkSession();
                }
            });
			var jsDate = event.args.date; 
			var type = event.args.type; // keyboard, mouse or null depending on how the date was selected.
			console.log(jsDate);
		}); 
		
    });
</script>
<style type="text/css">
	.jqx-calendar-cell-weekend
    {
        color: #5583c8;
    }
</style>

