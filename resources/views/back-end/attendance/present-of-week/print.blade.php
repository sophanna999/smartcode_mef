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
		@media  print {
			table{page-break-inside: avoid;}
		}
		@media print {
			table{page-break-inside: avoid;}

			.vendorListHeading {
				background-color: #white !important;
				-webkit-print-color-adjust: exact; 
			}

			#vendorListHeading {
				background-color: white !important;
				-webkit-print-color-adjust: exact;
				color:#000000 !important;
			} 
		}
		#vendorListHeading {
			background-color: white !important;
			-webkit-print-color-adjust: exact;
			color:#000000 !important; 
		} 
		@media print {
			body{zoom:98%}
			.vendorListHeading th {
			color: #000000 !important;
		}}	
		.print-landscape-a4 {
			@page {
			  size: A4 landscape;
			  margin: 0.3cm;
			  border:1px solid #000000;
			  transform: scale(.5);
			}
		}
		.vendorListHeading {
		    color: #000000;
		    -webkit-print-color-adjust: exact;
		    height: 28px; 
		}
		table {
			border: 1px solid #000000;
		}
    
</style>
</head>

<body>
<?php $countTwodays = 0; ?>
@if(!empty($allOfficer))
	@foreach($allOfficer as $key => $value)
		@if(count($value->twoDays) > 0)
			 <?php $countTwodays = count($value->twoDays); ?>
		@endif
		<?php $offices = $key;?>
	@endforeach
	<?php $all = $offices + 1;if($all > 23){ $over = 1;}else{ $over = 0;}if($offices > 14){ $middle = 1;}else{ $middle = 0;}?>
@endif
@if(isset($allOfficer) ? $allOfficer : array())
<div class="wrapper" style="max-width:1200px;width:100%;margin:0 auto;">

<table style="border:none;font-family: 'KHMERMEF1';position:fixed;right:25px;top:30px;font-size:11px;font-weight: bold;z-index:9999;"><tbody><tr><td><input type="button" id="btn-print" onclick="window.print()" style="font-size: 16px; color: currentcolor; background-color: inherit; border-color: chartreuse; display: inline-block;"></td></tr></tbody></table>

<div style="line-break: loose;page-break-before: always">
	
	<table style="margin-top:20px; border: 0; padding:5px">
		<tbody>
			<tr>
				<td style="width:15%; text-align:center"> <img src="{{asset('images/mef-logo.png')}}" style="width:50%; margin-left:7px"></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td style="width:25%; text-align:center;font-family:'KHMERMEF2';padding:4px;font-size:12px;">ក្រសួងសេដ្ឋកិច្ច និង ហិរញ្ញវត្ថុ</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td style="width:25%; text-align:center;font-family:'KHMERMEF2';padding:4px;font-size:12px;">អគ្គលេខាធិការដ្ឋាន</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td style="width:25%; text-align:center;font-family:'KHMERMEF2';padding:4px;font-size:12px;">{{isset($departement[0]->Name) ? $departement[0]->Name : ''}}</td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	 </table>
	 
	 
	<table style="border:none;position:absolute; top:1%; width:64%" id="bav">
		<tbody>
			<tr>
				<td style="text-align:center;font-family:'KHMERMEF2';font-size:14px;">ព្រះរាជាណាចក្រកម្ពុជា</td>
			</tr>
			<tr>
				<td style="text-align:center;font-family:'KHMERMEF2';font-size:14px;">ជាតិ សាសនា ព្រះមហាក្សត្រ</td>
			</tr>
			<tr>
				<td style="text-align:center"><img src="{{asset('icon/tacteng.png')}}" style="width: 11%;"></td>
			</tr>
		</tbody>
	</table>
	<table style="width:100%; border:0;">
		<tbody> 
			<tr>
				<td style="text-align:center;font-family:'KHMERMEF2';">បញ្ជីសម្រង់វត្តមានប្រចាំថ្ងៃរបស់មន្ដ្រីរាជការស៊ីវិល និង មន្រ្តីជាប់កិច្ចសន្យាក្នុង នាយកដ្ឋានព័ត៌មានវិទ្យា</td>
			</tr>
			<tr>
				<td style="text-align:center;font-family:'KHMERMEF2';">នៃ{{isset($office[0]->Name) ? $office[0]->Name : ''}}</td>
			</tr>
		</tbody>
	</table>
	
	<table style="width:100%;margin-top:15px;" border="1" cellpadding="0" cellspacing="0">
		<thead>
			<tr class="vendorListHeading">
			  <th rowspan="2" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ល.រ </th>
			  <th rowspan="2" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center;font-weight: normal;">គោត្តនាមនិងនាម</th>
			  <th rowspan="2" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">តួនាទី</th>
			  @foreach($allOfficer as $key => $value)
				@if($key == 0)
				@foreach($value->threeDays as $k => $v)
					<?php 
					     $dateSelect = explode('-',$k);
						 $date = $dateSelect[2];
						 $month = $dateSelect[1];
						 $year = $dateSelect[0];
					?>
			
					<th colspan="4" style="font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">ហត្ថលេខា (ថ្ងៃទី {{$converter->dayFormat($date)}} ខែ {{$converter->monthFormat($month)}} ឆ្នាំ {{$converter->dayFormat($year)}})</th>
				@endforeach
				@endif
			  @endforeach
			</tr>
			<tr class="vendorListHeading">
			  @foreach($allOfficer as $key => $value)
				@if($key == 0)
				@foreach($value->threeDays as $k => $v)
				@if(count($v) != 3)
					<th style="font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ព្រឹក</th>
					<th style="font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ល្ងាច</th>
					<th style="font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">មកយឺត</th>
					<th style="font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ចេញមុន</th>
				@else
					<th colspan="4" style="border-bottom: 0px !important;"></th>
				@endif
				@endforeach
				@endif
			  @endforeach
			</tr>
		</thead>
			<tbody style="line-break: loose;page-break-before: always">
				@foreach($allOfficer as $key => $value)
					@if($key < 14)
					<tr>
						<td style="text-align:center; font-family: 'KHMERMEF1';  padding: 2px">{{$key + 1}}</td>
						<td style="font-family: 'KHMERMEF1';">{{$value->name}}</td>
						<td style="font-family: 'KHMERMEF1';" >{{$value->position}}</td>
						@foreach($value->threeDays as $ke => $v)
						@if(count($v) != 3)
						<td style="text-align:center; font-family: 'KHMERMEF1'; " width="7%">{{isset($v['sectionOne']) ? $v['sectionOne'] : ''}}</td>							
						<td style="text-align:center; font-family: 'KHMERMEF1';  " width="7%">{{isset($v['sectionTwo']) ? $v['sectionTwo'] : ''}}</td>
						<td style="text-align:center; font-family: 'KHMERMEF1'; " width="5%">
							<span>{{isset($v['comeLate']['morning']) ? $v['comeLate']['morning'] : ''}}</span>
							<?php $come = isset($v['comeLate']['morning']) ? $v['comeLate']['morning'] : ''; ?>
							@if($come != '')
							<br>
							@endif
							<span>{{isset($v['comeLate']['afternoon']) ? $v['comeLate']['afternoon'] : ''}}</span>
						</td>
						<td style="text-align:center; font-family: 'KHMERMEF1';  " width="5%">
							<span>{{isset($v['leaveFirst']['morning']) ? $v['leaveFirst']['morning'] : ''}}</span>
							<?php $leave = isset($v['leaveFirst']['morning']) ? $v['leaveFirst']['morning'] : ''; ?>
							@if($leave != '')
							<br>
							@endif
							<span>{{isset($v['leaveFirst']['afternoon']) ? $v['leaveFirst']['afternoon'] : ''}}</span>
						</td>
						@else
							@if($key == 0)
							<td colspan="4" rowspan="{{$all}}" width="24%" style="font-family: 'KHMERMEF2';font-size: 16px;vertical-align: middle;text-align:center;border-top: 0px !important;">{{$v['val']}}</td>
							@endif
						@endif
						@endforeach
					</tr>
					@endif
				@endforeach
			</tbody>
	</table>
	@if($middle == 0)
	<table style="border:none; width:100%" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;" width="40.54%">សម្កាល់ៈ​ ទណ្ឌកម្មវិន័យអនុវត្តចំពោះអវត្តមានគ្មានច្បាប់អនុញ្ញាត៖</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;" width="18%"></td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;" width="41.46%">ប្រភេទច្បាប់ឈប់សម្រាករបស់មន្រ្តីរាជការស៊ីវិលរួមមាន៖</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">១ -មន្រ្តីរាជការស៊ីវិល</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">២- មន្រ្តីជាប់កិច្ចសន្យា</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">១- ច្បាប់ឈប់ប្រចាំឆ្នាំ មានរយៈពេល១៥ថ្ងៃនៃថ្ងៃធ្វើការក្នុង១ឆ្នាំ</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">​​​​​  - ការស្តីបន្ទោស</td>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ណែនាំលើកទី១</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">២- ច្បាប់ឈប់រយៈពេលខ្លី មានរយៈពេល១៥ថ្ងៃនៃថ្ងៃធ្វើការក្នុង១ឆ្នាំ</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ការស្តីបន្ទោសដោយមានចំណារក្នុងសំណុំលិខិតផ្ទាល់ខ្លួន</td>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ណែនាំចុងក្រោយ</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">៣- ច្បាប់ឈប់សម្រាកលំហែមាតុភាព មានរយៈពេល៣ខែ</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ការផ្លាស់ដោយបង្ខំតាមវិធានការខាងវិន័យឬការលុបឈ្មោះចេញពីតារាងដំឡើងឋានន្តរស័ក្តិឬថ្នាក់</td>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     - លុបឈ្មោះពីអង្គភាព</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">៤- ច្បាប់ឈប់សម្រាកព្យាបាលជំងឺ មានរយៈពេល១២ខែក្នុងអំឡុងពេលបម្រើការងារជាមន្រ្តី</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     - ការលុបឈ្មោះចេញពីក្របខណ្ឌ</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;"></td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">៥- ច្បាប់ឈប់សម្រាកដោយមានកិច្ចការផ្ទាល់ខ្លួន មានរយៈពេល៣ខែក្នុងអំឡុងពេលបម្រើការងារជាមន្រ្តី</td>
			</tr>
			@if($middle == 1)
			<tr>
				<td></td>
				<td></td>
				<td style="font-family: 'KHMERMEF2';font-size:11px;">
					<span>ធ្វើនៅរាជធានីភ្នំពេញ ថ្ងៃទី</span>
					<span style="padding-left:22%">ខែ</span>
					<span style="padding-left:22%">ឆ្នាំ <label style="padding-left:5%;color: black;font-weight: normal;">{{isset($year_dt) ? $converter->dayFormat($year_dt) : ''}}</label></span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td style="font-family: 'KHMERMEF2';text-align:center;font-size:11px;">អនុប្រធាននាយកដ្ឋានទទួលបន្ទុក</td>
			</tr>
			@endif
		</tbody>
	</table>
	@endif
</div>
<br/>
@if($middle == 1)
<div>
	
	<table style="width:100%" border="1" cellpadding="0" cellspacing="0">
		<thead>
			<tr class="vendorListHeading">
			  <th rowspan="2" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ល.រ </th>
			  <th rowspan="2" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center;font-weight: normal;">គោត្តនាមនិងនាម</th>
			  <th rowspan="2" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">តួនាទី</th>
			  @foreach($allOfficer as $key => $value)
				@if($key == 0)
				@foreach($value->threeDays as $k => $v)
					<?php 
					     $dateSelect = explode('-',$k);
						 $date = $dateSelect[2];
						 $month = $dateSelect[1];
						 $year = $dateSelect[0];
					?>
			
					<th colspan="4" style="font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">ហត្ថលេខា (ថ្ងៃទី {{$converter->dayFormat($date)}} ខែ {{$converter->monthFormat($month)}} ឆ្នាំ {{$converter->dayFormat($year)}})</th>
				@endforeach
				@endif
			  @endforeach
			</tr>
			<tr class="vendorListHeading">
			  @foreach($allOfficer as $key => $value)
				@if($key == 0)
				@foreach($value->threeDays as $k => $v)
				@if(count($v) != 3)
					<th style="font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ព្រឹក</th>
					<th style="font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ល្ងាច</th>
					<th style="font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">មកយឺត</th>
					<th style="font-family:'KHMERMEF2'; text-align: center; font-weight: normal;">ចេញមុន</th>
				@else
					<th colspan="4" style="border-bottom: 0px !important;"></th>
				@endif
				@endforeach
				@endif
			  @endforeach
			</tr>
		</thead>
			<tbody style="line-break: loose;page-break-before: always">
				@foreach($allOfficer as $key => $value)
					@if($key >= 14)
					<tr>
						<td style="text-align:center; font-family: 'KHMERMEF1';  padding: 2px">{{$key + 1}}</td>
						<td style="font-family: 'KHMERMEF1';">{{$value->name}}</td>
						<td style="font-family: 'KHMERMEF1';" >{{$value->position}}</td>
						@foreach($value->threeDays as $ke => $v)
						@if(count($v) != 3)
						<td style="text-align:center; font-family: 'KHMERMEF1'; " width="7%">{{isset($v['sectionOne']) ? $v['sectionOne'] : ''}}</td>							
						<td style="text-align:center; font-family: 'KHMERMEF1';  " width="7%">{{isset($v['sectionTwo']) ? $v['sectionTwo'] : ''}}</td>
						<td style="text-align:center; font-family: 'KHMERMEF1'; " width="5%">
							<span>{{isset($v['comeLate']['morning']) ? $v['comeLate']['morning'] : ''}}</span>
							<?php $come = isset($v['comeLate']['morning']) ? $v['comeLate']['morning'] : ''; ?>
							@if($come != '')
							<br>
							@endif
							<span>{{isset($v['comeLate']['afternoon']) ? $v['comeLate']['afternoon'] : ''}}</span>
						</td>
						<td style="text-align:center; font-family: 'KHMERMEF1';  " width="5%">
							<span>{{isset($v['leaveFirst']['morning']) ? $v['leaveFirst']['morning'] : ''}}</span>
							<?php $leave = isset($v['leaveFirst']['morning']) ? $v['leaveFirst']['morning'] : ''; ?>
							@if($leave != '')
							<br>
							@endif
							<span>{{isset($v['leaveFirst']['afternoon']) ? $v['leaveFirst']['afternoon'] : ''}}</span>
						</td>
						@else
							@if($key == 14)
							<td colspan="4" rowspan="{{$all}}" width="24%" style="font-family: 'KHMERMEF2';font-size: 16px;vertical-align: middle;text-align:center;border-top: 0px !important;">{{$v['val']}}</td>
							@endif
						@endif
						@endforeach
					</tr>
					@endif
				@endforeach
			</tbody>
	</table>
	<table style="border:none;width:100%" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;" width="40.54%">សម្កាល់ៈ​ ទណ្ឌកម្មវិន័យអនុវត្តចំពោះអវត្តមានគ្មានច្បាប់អនុញ្ញាត៖</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;" width="18%"></td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;" width="41.46%">ប្រភេទច្បាប់ឈប់សម្រាករបស់មន្រ្តីរាជការស៊ីវិលរួមមាន៖</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">១ -មន្រ្តីរាជការស៊ីវិល</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">២- មន្រ្តីជាប់កិច្ចសន្យា</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">១- ច្បាប់ឈប់ប្រចាំឆ្នាំ មានរយៈពេល១៥ថ្ងៃនៃថ្ងៃធ្វើការក្នុង១ឆ្នាំ</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">​​​​​  - ការស្តីបន្ទោស</td>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ណែនាំលើកទី១</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">២- ច្បាប់ឈប់រយៈពេលខ្លី មានរយៈពេល១៥ថ្ងៃនៃថ្ងៃធ្វើការក្នុង១ឆ្នាំ</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ការស្តីបន្ទោសដោយមានចំណារក្នុងសំណុំលិខិតផ្ទាល់ខ្លួន</td>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ណែនាំចុងក្រោយ</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">៣- ច្បាប់ឈប់សម្រាកលំហែមាតុភាព មានរយៈពេល៣ខែ</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ការផ្លាស់ដោយបង្ខំតាមវិធានការខាងវិន័យឬការលុបឈ្មោះចេញពីតារាងដំឡើងឋានន្តរស័ក្តិឬថ្នាក់</td>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     - លុបឈ្មោះពីអង្គភាព</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">៤- ច្បាប់ឈប់សម្រាកព្យាបាលជំងឺ មានរយៈពេល១២ខែក្នុងអំឡុងពេលបម្រើការងារជាមន្រ្តី</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     - ការលុបឈ្មោះចេញពីក្របខណ្ឌ</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;"></td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">៥- ច្បាប់ឈប់សម្រាកដោយមានកិច្ចការផ្ទាល់ខ្លួន មានរយៈពេល៣ខែក្នុងអំឡុងពេលបម្រើការងារជាមន្រ្តី</td>
			</tr>
			@if($middle == 1 && $countTwodays < 0)
			<tr>
				<td></td>
				<td></td>
				<td style="font-family: 'KHMERMEF2';font-size:11px;">
					<span>ធ្វើនៅរាជធានីភ្នំពេញ ថ្ងៃទី</span>
					<span style="padding-left:22%">ខែ</span>
					<span style="padding-left:22%">ឆ្នាំ <label style="padding-left:5%;color: black;font-weight: normal;">{{isset($year_dt) ? $converter->dayFormat($year_dt) : ''}}</label></span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td style="font-family: 'KHMERMEF2';text-align:center;font-size:11px;">អនុប្រធាននាយកដ្ឋានទទួលបន្ទុក</td>
			</tr>
			@endif
		</tbody>
	</table>
</div>
@endif
<br/>
@if($countTwodays > 0)
<div style="line-break: loose;page-break-before: always;" class="tableTwo">
	<table style="width:100%" border="1" cellpadding="0" cellspacing="0">
		<thead>
			<tr class="vendorListHeading">
			  <th rowspan="2" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">ល.រ </th>
			  <th rowspan="2" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">គោត្តនាមនិងនាម</th>
			  <th rowspan="2" style="vertical-align: middle; font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">តួនាទី</th>
			  @foreach($allOfficer as $key => $value)
				@if($key == 0)
				@foreach($value->twoDays as $k => $v)
					<?php 
					     $dateSelect = explode('-',$k);
						 $date = $dateSelect[2];
						 $month = $dateSelect[1];
						 $year = $dateSelect[0];
					?>
			
					<th colspan="4" style="font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">ហត្ថលេខា (ថ្ងៃទី {{$converter->dayFormat($date)}} ខែ {{$converter->monthFormat($month)}} ឆ្នាំ {{$converter->dayFormat($year)}})</th>
				@endforeach
				@endif
			  @endforeach
			</tr>
			<tr class="vendorListHeading">
			  @foreach($allOfficer as $key => $value)
				@if($key == 0)
				@foreach($value->twoDays as $k => $v)
				@if(count($v) != 3)
					<th style="font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">ព្រឹក</th>
					<th style="font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">ល្ងាច</th>
					<th style="font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">មកយឺត</th>
					<th style="font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">ចេញមុន</th>
				@else
					<th colspan="4" style="border-bottom: 0px !important;"></th>
				@endif
				@endforeach
				@endif
			  @endforeach
			</tr>
		</thead>
			<tbody>
				@foreach($allOfficer as $key => $value)
				@if(count($value->twoDays) > 0)
					@if($key < 26)
					<tr>
						<td style="text-align:center; font-family: 'KHMERMEF1';">{{$key + 1}}</td>
						<td style="font-family: 'KHMERMEF1';">{{$value->name}}</td>
						<td style="font-family: 'KHMERMEF1';">{{$value->position}}</td>
						@foreach($value->twoDays as $ke => $v)
						@if(count($v) != 3)
						<td style="text-align:center; font-family: 'KHMERMEF1';" width="7%">{{isset($v['sectionOne']) ? $v['sectionOne'] : ''}}</td>							
						<td style="text-align:center; font-family: 'KHMERMEF1';" width="7%">{{isset($v['sectionTwo']) ? $v['sectionTwo'] : ''}}</td>
						<td style="text-align:center; font-family: 'KHMERMEF1';" width="5%">
							<span>{{isset($v['comeLate']['morning']) ? $v['comeLate']['morning'] : ''}}</span>
							<?php $come = isset($v['comeLate']['morning']) ? $v['comeLate']['morning'] : ''; ?>
							@if($come != '')
							<br>
							@endif
							<span>{{isset($v['comeLate']['afternoon']) ? $v['comeLate']['afternoon'] : ''}}</span>
						</td>
						<td style="text-align:center; font-family: 'KHMERMEF1';" width="5%">
							<span>{{isset($v['leaveFirst']['morning']) ? $v['leaveFirst']['morning'] : ''}}</span>
							<?php $leave = isset($v['leaveFirst']['morning']) ? $v['leaveFirst']['morning'] : ''; ?>
							@if($leave != '')
							<br>
							@endif
							<span>{{isset($v['leaveFirst']['afternoon']) ? $v['leaveFirst']['afternoon'] : ''}}</span>
						</td>
						@else
							@if($key == 0)
							<td colspan="4" width="24%" rowspan="{{$all}}" style="font-family: 'KHMERMEF2';font-size: 16px;vertical-align: middle;text-align:center;border-top: 0px !important;">{{$v['val']}}</td>
							@endif
						@endif
						@endforeach
					</tr>
					@endif
				@endif
				@endforeach
			</tbody>
	</table>
	
	<table style="border:none;width:100%;" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;" width="40.54%">សម្កាល់ៈ​ ទណ្ឌកម្មវិន័យអនុវត្តចំពោះអវត្តមានគ្មានច្បាប់អនុញ្ញាត៖</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;" width="18%"></td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;" width="41.46%">ប្រភេទច្បាប់ឈប់សម្រាករបស់មន្រ្តីរាជការស៊ីវិលរួមមាន៖</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">១ -មន្រ្តីរាជការស៊ីវិល</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">២- មន្រ្តីជាប់កិច្ចសន្យា</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">១- ច្បាប់ឈប់ប្រចាំឆ្នាំ មានរយៈពេល១៥ថ្ងៃនៃថ្ងៃធ្វើការក្នុង១ឆ្នាំ</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">​​​​​  - ការស្តីបន្ទោស</td>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ណែនាំលើកទី១</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">២- ច្បាប់ឈប់រយៈពេលខ្លី មានរយៈពេល១៥ថ្ងៃនៃថ្ងៃធ្វើការក្នុង១ឆ្នាំ</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ការស្តីបន្ទោសដោយមានចំណារក្នុងសំណុំលិខិតផ្ទាល់ខ្លួន</td>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ណែនាំចុងក្រោយ</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">៣- ច្បាប់ឈប់សម្រាកលំហែមាតុភាព មានរយៈពេល៣ខែ</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ការផ្លាស់ដោយបង្ខំតាមវិធានការខាងវិន័យឬការលុបឈ្មោះចេញពីតារាងដំឡើងឋានន្តរស័ក្តិឬថ្នាក់</td>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     - លុបឈ្មោះពីអង្គភាព</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">៤- ច្បាប់ឈប់សម្រាកព្យាបាលជំងឺ មានរយៈពេល១២ខែក្នុងអំឡុងពេលបម្រើការងារជាមន្រ្តី</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     - ការលុបឈ្មោះចេញពីក្របខណ្ឌ</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;"></td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">៥- ច្បាប់ឈប់សម្រាកដោយមានកិច្ចការផ្ទាល់ខ្លួន មានរយៈពេល៣ខែក្នុងអំឡុងពេលបម្រើការងារជាមន្រ្តី</td>
			</tr>
			@if($over == 0)
			<tr>
				<td></td>
				<td></td>
				<td style="font-family: 'KHMERMEF2';font-size:11px;">
					<span>ធ្វើនៅរាជធានីភ្នំពេញ ថ្ងៃទី</span>
					<span style="padding-left:22%">ខែ</span>
					<span style="padding-left:22%">ឆ្នាំ <label style="padding-left:5%;color: black;font-weight: normal;">{{isset($year_dt) ? $converter->dayFormat($year_dt) : ''}}</label></span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td style="font-family: 'KHMERMEF2';text-align:center;font-size:11px;">អនុប្រធាននាយកដ្ឋានទទួលបន្ទុក</td>
			</tr>
			@endif
		</tbody>
	</table>
</div>
@endif
@if($over == 1)<?php echo $over;  ?>
	<div style="line-break: loose;page-break-before: always;" class="tableTwo">
	<table style="width:100%" border="1" cellpadding="0" cellspacing="0">
		<thead>
			<tr class="vendorListHeading">
			  <th rowspan="2" style="vertical-align: middle;font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">ល.រ </th>
			  <th rowspan="2" style="vertical-align: middle;font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">គោត្តនាមនិងនាម</th>
			  <th rowspan="2" style="vertical-align: middle;font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">តួនាទី</th>
			  @foreach($allOfficer as $key => $value)
				@if($key == 0)
				@foreach($value->twoDays as $k => $v)
					<?php 
					     $dateSelect = explode('-',$k);
						 $date = $dateSelect[2];
						 $month = $dateSelect[1];
						 $year = $dateSelect[0];
					?>
			
					<th colspan="4" style="font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">ហត្ថលេខា (ថ្ងៃទី {{$converter->dayFormat($date)}} ខែ {{$converter->monthFormat($month)}} ឆ្នាំ {{$converter->dayFormat($year)}})</th>
				@endforeach
				@endif
			  @endforeach
			</tr>
			<tr class="vendorListHeading">
			  @foreach($allOfficer as $key => $value)
				@if($key == 0)
				@foreach($value->twoDays as $k => $v)
				@if(count($v) != 3)
					<th style="font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">ព្រឹក</th>
					<th style="font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">ល្ងាច</th>
					<th style="font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">មកយឺត</th>
					<th style="font-family:'KHMERMEF2'; text-align: center;  font-weight: normal;">ចេញមុន</th>
				@else
					<th colspan="4" style="border-bottom: 0px !important;"></th>
				@endif
				@endforeach
				@endif
			  @endforeach
			</tr>
		</thead>
			<tbody>
				@foreach($allOfficer as $key => $value)
				@if(count($value->twoDays) > 0)
					@if($key >= 26)
					<tr>
						<td style="text-align:center; font-family: 'KHMERMEF1';">{{$key + 1}}</td>
						<td style="font-family: 'KHMERMEF1';">{{$value->name}}</td>
						<td style="font-family: 'KHMERMEF1';">{{$value->position}}</td>
						@foreach($value->twoDays as $ke => $v)
						@if(count($v) != 3)
						<td style="text-align:center; font-family: 'KHMERMEF1';" width="7%">{{isset($v['sectionOne']) ? $v['sectionOne'] : ''}}</td>							
						<td style="text-align:center; font-family: 'KHMERMEF1';" width="7%">{{isset($v['sectionTwo']) ? $v['sectionTwo'] : ''}}</td>
						<td style="text-align:center; font-family: 'KHMERMEF1';" width="5%">
							<span>{{isset($v['comeLate']['morning']) ? $v['comeLate']['morning'] : ''}}</span>
							<?php $come = isset($v['comeLate']['morning']) ? $v['comeLate']['morning'] : ''; ?>
							@if($come != '')
							<br>
							@endif
							<span>{{isset($v['comeLate']['afternoon']) ? $v['comeLate']['afternoon'] : ''}}</span>
						</td>
						<td style="text-align:center; font-family: 'KHMERMEF1';" width="5%">
							<span>{{isset($v['leaveFirst']['morning']) ? $v['leaveFirst']['morning'] : ''}}</span>
							<?php $leave = isset($v['leaveFirst']['morning']) ? $v['leaveFirst']['morning'] : ''; ?>
							@if($leave != '')
							<br>
							@endif
							<span>{{isset($v['leaveFirst']['afternoon']) ? $v['leaveFirst']['afternoon'] : ''}}</span>
						</td>
						@else
							@if($key == 26)
							<td colspan="4" width="24%" rowspan="{{$all}}" style="font-family: 'KHMERMEF2';font-size: 16px;vertical-align: middle;text-align:center;border-top: 0px !important;">{{$v['val']}}</td>
							@endif
						@endif
						@endforeach
					</tr>
					@endif
				@endif
				@endforeach
			</tbody>
	</table>
	
	<table style="border:none;width:100%;" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;" width="40.54%">សម្កាល់ៈ​ ទណ្ឌកម្មវិន័យអនុវត្តចំពោះអវត្តមានគ្មានច្បាប់អនុញ្ញាត៖</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;" width="18%"></td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;" width="41.46%">ប្រភេទច្បាប់ឈប់សម្រាករបស់មន្រ្តីរាជការស៊ីវិលរួមមាន៖</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">១ -មន្រ្តីរាជការស៊ីវិល</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">២- មន្រ្តីជាប់កិច្ចសន្យា</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">១- ច្បាប់ឈប់ប្រចាំឆ្នាំ មានរយៈពេល១៥ថ្ងៃនៃថ្ងៃធ្វើការក្នុង១ឆ្នាំ</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">​​​​​  - ការស្តីបន្ទោស</td>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ណែនាំលើកទី១</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">២- ច្បាប់ឈប់រយៈពេលខ្លី មានរយៈពេល១៥ថ្ងៃនៃថ្ងៃធ្វើការក្នុង១ឆ្នាំ</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ការស្តីបន្ទោសដោយមានចំណារក្នុងសំណុំលិខិតផ្ទាល់ខ្លួន</td>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ណែនាំចុងក្រោយ</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">៣- ច្បាប់ឈប់សម្រាកលំហែមាតុភាព មានរយៈពេល៣ខែ</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     -​​ ការផ្លាស់ដោយបង្ខំតាមវិធានការខាងវិន័យឬការលុបឈ្មោះចេញពីតារាងដំឡើងឋានន្តរស័ក្តិឬថ្នាក់</td>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     - លុបឈ្មោះពីអង្គភាព</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">៤- ច្បាប់ឈប់សម្រាកព្យាបាលជំងឺ មានរយៈពេល១២ខែក្នុងអំឡុងពេលបម្រើការងារជាមន្រ្តី</td>
			</tr>
			<tr>
				<td style="font-family: 'KHMERMEF1';padding-left:15px;font-size: 10px;">     - ការលុបឈ្មោះចេញពីក្របខណ្ឌ</td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;"></td>
				<td style="font-family: 'KHMERMEF1';font-size: 10px;">៥- ច្បាប់ឈប់សម្រាកដោយមានកិច្ចការផ្ទាល់ខ្លួន មានរយៈពេល៣ខែក្នុងអំឡុងពេលបម្រើការងារជាមន្រ្តី</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td style="font-family: 'KHMERMEF2';font-size:11px;">
					<span>ធ្វើនៅរាជធានីភ្នំពេញ ថ្ងៃទី</span>
					<span style="padding-left:22%">ខែ</span>
					<span style="padding-left:22%">ឆ្នាំ <label style="padding-left:5%;color: black;font-weight: normal;">{{isset($year_dt) ? $converter->dayFormat($year_dt) : ''}}</label></span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td style="font-family: 'KHMERMEF2';text-align:center;font-size:11px;">អនុប្រធាននាយកដ្ឋានទទួលបន្ទុក</td>
			</tr>	
		</tbody>
	</table>
</div>
@endif
<footer style="font-family: 'KHMERMEF1';font-size:9px;font-style: italic; padding-bottom:2px; font-weight: 600;" id="footerText"><u>បោះពុម្ពចេញពីប្រព័ន្ធសុវត្ថិភាព</u></footer>
</div>
@endif

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
			$("#bav").css("width","64%");
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
</body>
</html>