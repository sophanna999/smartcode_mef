<?php 
$jqxPrefix = '_public_holiday';
$saveUrl = asset($constant['secretRoute'].'/public-holiday/save');
?>

<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:10px;"></div>
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('public_holiday.date')}}</label>
				<div id="div_date" name="date"></div>
				<div id='log'></div>
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('public_holiday.title-holiday')}}</label>
				<input type="text" class="form-control" placeholder="{{trans('public_holiday.title-holiday')}}" id="Name" name="title" value="{{isset($row->title) ? $row->title:''}}">
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
        color: #000 !important;;
    }
</style>
<script>
    $(document).ready(function(){
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
		 // $('#div_date').jqxDateTimeInput({ formatString: "yyyy-MM-dd"});
		$('#div_date ').jqxDateTimeInput('setDate', new Date(<?php echo $year; ?>, <?php echo $month; ?>, <?php echo $day; ?>));
		//$('#div_date ').jqxDateTimeInput('setDate', new Date(<?php echo $year; ?>, <?php echo $month; ?>, <?php echo $day; ?>));
		$('#div_date').bind('valuechanged', function (event) {
            var date = event.args.date;
            $("#log").text(date.toDateString());
        });


	});
</script>