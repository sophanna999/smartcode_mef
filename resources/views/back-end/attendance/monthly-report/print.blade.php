<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>វត្តមានប្រចាំសប្តាហ៏</title>
<link rel="shortcut icon" href="{{asset('icon/mef.ico')}}" />
<title>@yield('title')</title>
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" type="text/css" />
<script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>

<style type="text/css">
		body{
			font-size:11px;
		}
		td, th
		{
			font-size:11px;
		}
		#btn-print {
			background:url('{{asset("images/printer.png")}}') no-repeat center center;
			background-size: 20px;
			padding:5px 20px;
			border-radius: 5px 5px; 
		}
		table tbody tr td	{
			padding:6px;
		}
		table tr td p {
			line-height:6px;	
		}
		
		@media print {
		  @page { margin: 0.5cm; }
		  
		}
		
			
		.print-landscape-a4 {
			@page {
			  size: A4 landscape;
			  margin: 0;
			  border:1px solid #ddd;
			}
		}
		
		table	{
			border:0 !important;
		}
    
</style>
</head>

<body>

<div class="wrapper" style="max-width:985px;width:100%;margin:0 auto;">

<table style="font-family: 'KHMERMEF1';position:fixed;right:25px;top:30px;font-size:11px;font-weight: bold;z-index:9999;"><tbody><tr><td><input type="button" id="btn-print" onclick="window.print()" style="font-size: 16px; color: currentcolor; background-color: inherit; display: inline-block;"></td></tr></tbody></table>
	
	<table style="margin-top:20px; border:0; padding:5px">
		<tbody>
			<tr>
				<td style="width:15%; text-align:center"> <img src="{{asset('images/mef-logo.png')}}" style="width:45%; margin-left:7px"></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td style="width:25%; text-align:center;font-family:'KHMERMEF2';padding:4px;">ក្រសួងសេដ្ឋកិច្ច និង ហិរញ្ញវត្ថុ</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td style="width:25%; text-align:center;font-family:'KHMERMEF2';padding:4px;">អគ្គលេខាធិការដ្ឋាន</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td style="width:25%; text-align:center;font-family:'KHMERMEF2';padding:4px;">{{$daptName}}</td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	 </table>
	 
	 
	<table style="position:absolute; top:1%; width:50%" id="bav">
		<tbody>
			<tr>
				<td style="text-align:right;font-family:'KHMERMEF2'; position: relative; right: 5%">ព្រះរាជាណាចក្រកម្ពុជា</td>
			</tr>
			<tr>
				<td style="text-align:right;font-family:'KHMERMEF2';position: relative; right: 4%">ជាតិ សាសនា ព្រះមហាក្សត្រ</td>
			</tr>
			<tr>
				<td style="text-align:right;position: relative; right: 5%"><img src="{{asset('icon/tacteng.png')}}" style="width: 11%;"></td>
			</tr>
		</tbody>
	</table>
	<table style="width:100%; border:0;">
		<tbody> 
			<tr>
				<td style="text-align:center;font-family:'KHMERMEF2';">បញ្ជីសម្រង់អវត្តមាន</td>
			</tr>
			<tr>
				<td style="text-align:center;font-family:'KHMERMEF2';">មន្រ្ដីរាជការ និងមន្រ្ដីជាប់កិច្ចសន្យាក្នុងខែ {{$tool->monthFormat($month)}} ឆ្នាំ {{$tool->khmerNumber($year)}}</td>
			</tr>
		</tbody>
	</table>

		<table style="width:100%;margin-top:15px;" border="1" >
		<thead>
			<tr>
			  <th rowspan="3" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ល.រ </th>
			  <th rowspan="3" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ឈ្មោះ</th>
			  <th rowspan="3" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ភេទ</th>
			  <th rowspan="3" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">តួនាទី</th>
			  <th rowspan="3" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ចំនួនសរុបនៃអវត្ដមាន</th>
			  <th colspan="8" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">មូលហេតុអវត្ដមាន</th>
			  <th rowspan="3" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ចំនួនថ្ងៃឈប់សម្រាកដែលនៅសល់</th>
			</tr>
			<tr>
			  <th rowspan="2" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ឥតច្បាប់ </th>
			  <th colspan="5" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ច្បាប់ </th>
			  <th rowspan="2" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">បេសកកម្ម </th>
			  <th rowspan="2" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">សុំឈប់ឬស្លាប់ឬផ្លាស់ចេញ </th>
			</tr>
			<tr>
			  <th style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">រយៈពេលខ្លី</th>
			  <th style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ប្រចាំឆ្នាំ</th>
			  <th style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">មាតុភាព</th>
			  <th style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ព្យាបាលជម្ងឺ</th>
			  <th style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">កិច្ចការផ្ទាល់ខ្លួន</th>
			  
			</tr>
		</thead>

			<tbody class="threeDays">

				@foreach ( $allData as $key =>$val )

				<?PHP
					$totalAttendance = $val->totalAbsence + $val->shortPermission + $val->yearPermission + $val->pegent + $val->sick + $val->busy + $val->mission;

					if($val->LEVEL_STATUS == 1){
						$numOfDayOf = 30 - $totalAttendance;
					}elseif ($val->LEVEL_STATUS == 2 || $val->positionId == 19) {
						$numOfDayOf = 15 - $totalAttendance;
					}elseif ($val->LEVEL_STATUS == 0 && $val->positionId == 20) {
						$numOfDayOf = 18 - $totalAttendance;
					}
				?>
				<tr>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">{{$key + 1}} </td>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">{{$val->FULL_NAME_KH}} </td>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">{{$val->gender}} </td>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">{{$val->positionName}} </td>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">{{$tool->khmerNumber($totalAttendance)}} ថ្ងៃ </td>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">{{$tool->khmerNumber($val->totalAbsence)}} ថ្ងៃ </td>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">{{$val->shortPermission !='' ? $tool->khmerNumber($val->shortPermission):''}} {{isset($val->shortPermission) ? 'ថ្ងៃ':''}} </td>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">{{$val->yearPermission!='' ? $tool->khmerNumber($val->yearPermission):''}} {{isset($val->yearPermission) ? 'ថ្ងៃ':''}}</td>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">{{$val->pegent !='' ? $tool->khmerNumber($val->pegent):''}} {{isset($val->pegent) ? 'ថ្ងៃ':''}}</td>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">{{$val->sick!='' ? $tool->khmerNumber($val->sick):''}} {{isset($val->sick) ? 'ថ្ងៃ':''}}</td>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">{{$val->busy!='' ? $tool->khmerNumber($val->busy):''}} {{isset($val->busy) ? 'ថ្ងៃ':''}}</td>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">{{$val->mission!='' ? $tool->khmerNumber($val->mission):''}} {{isset($val->mission) ? 'ថ្ងៃ':''}}</td>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;"> </td>
					<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">{{isset($numOfDayOf) ? $tool->khmerNumber($numOfDayOf):''}} ថ្ងៃ</td>
				</tr>
				@endforeach
			</tbody>
	</table>

	<table>
		<tr>
			<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;position: relative;left: 426%;">រាជធានីភ្នំពេញ, ថ្ងៃទី        ខែ តុលា ឆ្នាំ ២០១៧</td>
		</tr>
		<tr>
			<td style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;position: relative;left: 426%;">អ្នករៀបចំ</td>
		</tr>
		<tr>
			<td style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;position: relative;left: 426%;line-height: 65px;">ឃុត ម៉ាឡែន</td>
		</tr>
	</table>

	<table style="position: relative;top: -60px;">
		<tr>
			<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">បានឃើញ និងឯកភាព</td>
		</tr>
		<tr>
			<td style="vertical-align: middle; font-family:'KHMERMEF1'; text-align: center; font-weight: normal;">រាជធានីភ្នំពេញ, ថ្ងៃទី        ខែ តុលា ឆ្នាំ ២០១៧</td>
		</tr>
		<tr>
			<td style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ប្រធាននាយកដ្ឋានព័ត៌មានវិទ្យា </td>
		</tr>
		<tr>
			<td style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;line-height: 65px;">មន្ត ប្រាថ្នា </td>
		</tr>
	</table>





</div>
</body>


<script type="text/javascript">
	(function() {
		$("#footerText").hide();
		var beforePrint = function() {
			$('#btn-print').hide();
			$("#bav").css("width","98%");
			$(".tableTwo").css("margin-top","20px");
			$("#footerText").show();
		};

		var afterPrint = function() {
			$('#btn-print').show();
			$("#bav").css("width","50%");
			$(".tableTwo").css("margin-top","0px");
			$("#footerText").hide();
		};

		if (window.matchMedia) {
			var mediaQueryList = window.matchMedia('print');
			mediaQueryList.addListener(function(mql) {
				if (mql.matches) {
					beforePrint();
				} else {
					afterPrint();
				}
			});
		}

		window.onbeforeprint = beforePrint;
		window.onafterprint = afterPrint;

	}());	
</script>

</html>