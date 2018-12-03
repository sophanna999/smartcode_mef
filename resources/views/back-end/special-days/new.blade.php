<?php 
$jqxPrefix = '_special_days';
$saveUrl = asset($constant['secretRoute'].'/special-day/save');
$getOfficeUrl = asset($constant['secretRoute'].'/special-day/get-office');
$getOfficerUrl = asset($constant['secretRoute'].'/special-day/get-officer');
?>

<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:10px;"></div>
        <input type="hidden" id="Id" name="Id" value="{{$Id=isset($row->Id) ? $row->Id:0}}">
        <div class="form-group">
            <div class="col-sm-12">
                <label><span class="red-star">*</span> {{trans('trans.type_dayoff')}}</label>
            </div>
            
            <div class="col-sm-4">
                <input type="radio" name="specialday[status]" checked="checked" class="status" id="department" value="0" <?php $status=isset($row->status)? $row->status:3;
                // var_dump($row->status);
                if($status == 0){ echo "checked";}
                ?>>{{trans('officer.department')}}</input>
            </div>
            <div class="col-sm-3">
                <input type="radio" name="specialday[status]" value="1" id="office" class="status" <?php $status=isset($row->status)? $row->status:'';
                if($status == 1){ echo "checked";}
                ?>>{{trans('officer.office')}}</input>
            </div>
            <div class="col-sm-2">
                <input type="radio" name="specialday[status]" value="2" id="personal" class="status" <?php $status=isset($row->status)? $row->status:'';
                // var_dump($row->status);
                if($status == 2){ echo "checked";}
                ?>>{{trans('trans.private')}}</input>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('officer.department')}}</label>
				<input type="hidden" class="form-control" id="departmentId" name="sub[departmentId]" value="{{isset($row->departmentId) ? $row->departmentId:''}}">
                <div id="div_departmentId"></div>
            </div>
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('officer.office')}}</label>
                <!-- <input type="hidden" class="form-control" id="officeId" name="officeId" value="{{isset($row->officeId) ? $row->officeId:''}}">
                <div id="div_officeId"></div> -->
                <div id="div_officeId" name="sub[officeId]" ></div>
            </div>
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('trans.officer')}}</label>
                <div id="div_officerId" name="sub[officerId]" ></div>
            </div>
            
        </div>
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('public_holiday.date')}}</label>
				<div id="div_date" name="specialday[date]"></div>
				<div id='log'></div>
            </div>
            <div class="col-sm-3">
            	<input type="radio" checked="checked" name="specialday[shift]" class="shift" value="0" <?php $shift=isset($row->shift)? $row->shift:4;
                if($shift == 0){ echo "checked";}
                ?>>{{trans('special_days.morning')}}</input>
            </div>
            <div class="col-sm-3">
            	<input type="radio" name="specialday[shift]" value="1" class="shift" <?php $shift=isset($row->shift)? $row->shift:4;
                if($shift == 1){ echo "checked";}
                ?>>{{trans('special_days.afternoon')}}</input>
            </div>
            <div class="col-sm-3">
                <input type="radio" name="specialday[shift]" value="2" class="shift" <?php $shift=isset($row->shift)? $row->shift:4;
                if($shift == 2){ echo "checked";}
                ?>>{{trans('special_days.morning')}} {{trans('special_days.afternoon')}}</input>
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('public_holiday.title-holiday')}}</label>
				<input type="text" class="form-control" placeholder="{{trans('public_holiday.title-holiday')}}" id="Name" name="specialday[reason]" value="{{isset($row->reason) ? $row->reason:''}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
</div>
<?php 
		$year = date('Y');
		$month = date('m');
		$month = $month -1 ;
		$day = date('d');
		if(isset($row)){
			$dt=explode('-',$row->date);
			$year =$dt[0];
			$month =$dt[1]-1;
			$day =$dt[2];
		}
	?>
<style type="text/css">
    .jqx-combobox-content-disabled{
        color: #000 !important;
    }
</style>
<script>

    $('#department').click(function() {
       if($('#department').is(':checked')) { 
            
            $("#div_officeId").jqxComboBox({ disabled: true }); 
            $("#div_officerId").jqxComboBox({ disabled: true }); 
        }
    });
    $('#office').click(function() {
        status = true;
       if($('#office').is(':checked')) { 
            $("#div_officeId").jqxComboBox({ disabled: false,multiSelect: true,width: '100%',height: 32,}); 
            $("#div_officerId").jqxComboBox({ disabled: true }); 
        }
    });
    $('#personal').click(function() {
        status = false;
        $("#div_officeId").jqxComboBox('clearSelection');
       if($('#personal').is(':checked')) { 
            // alert(1);
            
            $("#div_officeId").jqxComboBox({ disabled: false,multiSelect: false,}); 

            $("#div_officerId").jqxComboBox({ disabled: false }); 
        }
    });

    
    function getOffice(object){
        var departmentId = $(object).val();
        
        $.ajax({
            type: "post",
            url : '{{$getOfficeUrl}}',
            datatype : "json",
            data : {"departmentId":departmentId,"_token":'{{ csrf_token() }}'},
            success : function(data){

               if($('#personal').is(':checked')) {
                    // alert(status);
                    $("#div_officeId").jqxComboBox({
                        source: data,
                        multiSelect: false,
                        theme: jqxTheme,
                        width: '100%',
                        // width: 546,
                        height: 32,
                        displayMember: "displayMember",
                        valueMember : "valueMember",
                        placeHolder: "{{trans('officer.office')}}",
                        enableBrowserBoundsDetection:true,
                        autoComplete:true,
                        searchMode:'contains',
                        dropDownHeight:450,
                        animationType: 'none'
                    });
               }else{
                
                    $("#div_officeId").jqxComboBox({
                        source: data,
                        multiSelect: true,
                        theme: jqxTheme,
                        width: '100%',
                        // width: 546,
                        height: 32,
                        displayMember: "displayMember",
                        valueMember : "valueMember",
                        placeHolder: "{{trans('officer.office')}}",
                        enableBrowserBoundsDetection:true,
                        autoComplete:true,
                        searchMode:'contains',
                        dropDownHeight:450,
                        animationType: 'none'
                    });
               }
               
            }
        });
    }

    function getOfficer(object){
        console.log($(object).val());
        var officeId = $(object).val();
        
        $.ajax({
            type: "post",
            url : '{{$getOfficerUrl}}',
            datatype : "json",
            data : {"officeId":officeId,"_token":'{{ csrf_token() }}'},
            success : function(data){
               $("#div_officerId").jqxComboBox({
                    source: data,
                    multiSelect: true,
                    theme: jqxTheme,
                    width: '100%',
                    // width: 546,
                    height: 32,
                    displayMember: "displayMember",
                    valueMember : "valueMember",
                    placeHolder: " {{trans('trans.officer')}}",
                    enableBrowserBoundsDetection:true,
                    autoComplete:true,
                    searchMode:'contains',
                    dropDownHeight:450,
                    animationType: 'none'
                });
            }
        });
    }
    $(document).ready(function(){
        if($('#department').is(':checked')) { 
            $("#div_officeId").jqxComboBox({ disabled: true });
            $("#div_officerId").jqxComboBox({ disabled: true }); 
         }
         if($('#office').is(':checked')) { 
            $("#div_officeId").jqxComboBox({ disabled: false,}); 

            $("#div_officerId").jqxComboBox({ disabled: true,width: '100%',height: 32}); 
        }
        if($('#personal').is(':checked')) { 
            $("#div_officeId").jqxComboBox('clearSelection');
            $("#div_officeId").jqxComboBox({ disabled: false,width: '100%',height: 32}); 
            $("#div_officerId").jqxComboBox({ disabled: false,width: '100%',height: 32}); 
        }
		// start_date
		$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
            initialButton(buttons,90,30);

		$("#div_date").jqxDateTimeInput({
			width: '250px',
			height: '25px'
			// formatString: 'dd-MM-yyyy'
		 });

        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#Name', message: ' ', action: 'blur', rule: 'required'},
                {input: '#div_departmentId', message: ' ', action: 'select',
                    rule: function () {
                        if($("#div_departmentId").val() == ""){
                            return false;
                        }
                        return true;
                    }
                },
                {input: '#div_officeId', message: ' ', action: 'select',
                    rule: function () {
                        if($('#office').is(':checked') || $('#personal').is(':checked')) { 
                            if($("#div_officeId").val() == ""){
                                return false;
                            }
                        }else{
                            if($("#div_officeId").val() == ""){
                                return true;
                            }
                        }
                        return true;
                    }
                },
                {input: '#div_officerId', message: ' ', action: 'select',
                    rule: function () {
                        if($('#personal').is(':checked')) { 
                            if($("#div_officerId").val() == ""){
                                return false;
                            }
                        }else{
                            if($("#div_officerId").val() == ""){
                                return true;
                            }
                        }
                        return true;
                    }
                },
                {input: '#div_date', message: ' ', action: 'select',
                    rule: function () {
                        if($("#div_date").val() == ""){
                            return false;
                        }
                        return true;
                    }
                },
                {input: '.shift', message: ' ', action: 'select',
                    rule: function () {
                        if($(".shift").val() == ""){
                            return false;
                        }
                        return true;
                    }
                }
            ]
        });

		 // $('#div_date').jqxDateTimeInput({ formatString: "yyyy-MM-dd"});
		$('#div_date ').jqxDateTimeInput('setDate', new Date(<?php echo $year; ?>, <?php echo $month; ?>, <?php echo $day; ?>));
		
        initDropDownList(jqxTheme, 245,34, '#div_departmentId',<?php echo $department; ?>, 'text', 'value', false, '', '0', "#departmentId","",200);
        $('#div_departmentId').bind('select', function (event) {
            getOffice(this);
        });
		//$('#div_date ').jqxDateTimeInput('setDate', new Date(<?php echo $year; ?>, <?php echo $month; ?>, <?php echo $day; ?>));
		$('#div_date').bind('valuechanged', function (event) {
            var date = event.args.date;
            $("#log").text(date.toDateString());
        });
        mefOffice();
        mefOfficer();
        $('#div_officeId').bind('select', function (event) {
            getOfficer(this);
        });

	});
    
    function mefOffice(){
            var source = <?php echo $office; ?>;

            // var dataAdapter = new $.jqx.dataAdapter(source,{});
            // console.log(source);
            // alert(status);
            if($('#personal').is(':checked')) { 
                var status = false;
            }else{
                var status = true;
            }
            $("#div_officeId").jqxComboBox({
                source: source,
                multiSelect: status,
                theme: jqxTheme,
                width: '100%',
                // width: 546,
                height: 32,
                displayMember: "displayMember",
                valueMember : "valueMember",
                placeHolder: "{{trans('officer.office')}}",
                enableBrowserBoundsDetection:true,
                autoComplete:true,
                searchMode:'contains',
                dropDownHeight:450,
                animationType: 'none'
            });

            /* jqxComboBox on focus action */
            $('#div_officeId input').on('focus', function (event) {
                $("#div_officeId").jqxComboBox('open');
            });
            getSelectedOffice();
        }

        function getSelectedOffice(){
            var res_join = <?php echo $getOffice; ?>;
            $.each(res_join, function( index, value ) {   
                $("#div_officeId").jqxComboBox('selectItem', value);               
            });
        }

    function mefOfficer(){
            var source = <?php echo $list_officer; ?>;
            var dataAdapter = new $.jqx.dataAdapter(source,{});
            // console.log(dataAdapter);
            $("#div_officerId").jqxComboBox({
                source: source,
                multiSelect: true,
                theme: jqxTheme,
                width: '100%',
                // width: 546,
                height: 32,
                displayMember: "displayMember",
                valueMember : "valueMember",
                placeHolder: " {{trans('trans.officer')}}",
                enableBrowserBoundsDetection:true,
                autoComplete:true,
                searchMode:'contains',
                dropDownHeight:450,
                animationType: 'none'
            });

            /* jqxComboBox on focus action */
            $('#div_officerId input').on('focus', function (event) {
                $("#div_officerId").jqxComboBox('open');
            });
            getSelectedOfficer();
        }

        function getSelectedOfficer(){
            var res_join = <?php echo $getOfficer; ?>;
            $.each(res_join, function( index, value ) {
                $("#div_officerId").jqxComboBox('selectItem', value);
            });
        }
</script>