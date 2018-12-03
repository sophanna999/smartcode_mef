 <?php
 $jqxPrefix = '_user';
 $avatar = $row->avatar != '' ? $row->avatar:'images/photo-default.jpg';
 $approveUrl = asset($constant['secretRoute'].'/user/save-approve');
 ?>
 <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="ajaxRequestJson" value="true" />
	<input type="hidden" value="{{isset($row->id) ? $row->id:0}}" name="Id" id="Id">
	<div id="login-content">
		
		<div style="padding:10px;margin:10px;">
		<table style="width:100%;">
			<tr>
				<td style="width:33.333333%;">
				
				</td>
				<td style="width:33.3333333333%;height: 50px;text-align:center;font-family:'KHMERMEF2';font-size:14px;">
					ព្រះរាជាណាចក្រកម្ពុជា<br /><br/>ជាតិ  សាសនា  ព្រះមហាក្សត្រ
				</td>
				<td style="width:33.33333333333%;position:relative;">
					<table style="font-style:italic;font-family: 'KHMERMEF1';position:absolute;right:5px;top:10px;font-size:10px"><tr><td></td></tr></table>
				</td>
			</tr>
		</table>
		<table style="width:100%;position:relative">
			<tr>
				<td style="width:10%;text-align:center">
					<img src="{{asset('images/logo.png')}}" width="90px;font-family:'KHMERMEF2';">
					<table><tr><td style="font-family:'KHMERMEF2';font-size:12px" >ក្រសួងសេដ្ឋកិច្ចនិងហិរញ្ញវត្ថុ<br/> {{isset($secretarait->Name) ? $secretarait->Name:''}} </td></tr></table>
				</td>
				<td style="width:50%;position:relative">
					<table style="font-family:'KHMERMEF1';font-size:9px;text-align:center" >
						<tr style="border:1px solid #000">
							<td style="width:92px;height:118px;border: 0px solid #585353;;position:absolute;right:22px;top:20px;padding-top:0px;">
							<img src="{{asset('/').$avatar}}" width="92" height="118">
							</td><br />
							<td style="position:absolute;right:0;top:165px;font-family:'automation';font-size:12px">
							 *0009395656*
							</td>
						</tr>
						
					</table>
				</td>
			</tr>
		</table>
		<br>
		<br>
		<table style="width:100%; ">
			<tr> 
				<table style="text-align:center;font-family:'KHMERMEF2';font-size:20px;position:relative;top:-40px;font-size:15px;width:100%">
					<tr><td>ប្រវត្តិរូបមន្ត្រីរាជការ<br /><br />ក្រសួងសេដ្ឋកិច្ចនិងហិរញ្ញវត្ថុ</td></tr>
				</table>
			</tr>
		</table>
		<table style="width:100%;margin: 20px;">
			<tr>
				<td>
					
				</td>
			
			</tr>
			<tr>
				<td style="font-family:'KHMERMEF1';width:40%;font-size:12px">អត្តសញ្ញាណប័ណ្ណមន្រ្តីរាជការ :
					<table style="display:inline-block;margin-left:10px;">{{isset($personalInfo->PERSONAL_INFORMATION) ? $personalInfo->PERSONAL_INFORMATION:''}}</table>
				</td>
				<td style="font-family:'KHMERMEF1';width:35%;font-size:12px">
					លេខប័ណ្ណសម្គាល់មន្រ្តីកសហវ :
					<table style="display:inline-block;margin-left:10px;">{{isset($personalInfo->OFFICIAL_ID) ? $personalInfo->OFFICIAL_ID:''}}</table>
				</td>
				<td style="font-family:'KHMERMEF1';width:25%;font-size:12px">
					លេខកូដអង្គភាព :
					<table style="display:inline-block;margin-left:10px;">{{isset($personalInfo->UNIT_CODE) ? $personalInfo->UNIT_CODE:''}}</table>
				</td>
			</tr>
		</table>
		<table style="width:100%;margin: 20px;">
		   
			<tr>
				<td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;">
				   គោត្តនាម-នាម
				</td>
				<td style="width:35%;"><table style="display:inline-block;margin-left:10px;border: 1px solid #585353;padding-left:6px;padding-top: 5px;vertical-align:middle;width:90%;height: 30px ;font-size:12px;line-height:1.8"><tr><td>{{isset($row->full_name_kh) ? $row->full_name_kh:''}}</td></tr></table></td>
				<td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right">
				   ជាអក្សរឡាតាំង
				</td>
				<td style="width:35%;"><table style="display:inline-block;margin-left:10px;border: 1px solid #585353;padding-left:6px;padding-top: 5px;vertical-align:middle;width:93%;height: 30px;font-size:12px;line-height:1.8"><tr><td>{{isset($row->full_name_en) ? $row->full_name_en:''}}</td></tr></table></td>
			</tr>
		   
		</table>
		<table style="width:100%;margin: 20px;">
			<tr>
				<td style="width:20%">
					<table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';"><tr><td>ទីកន្លែងកំណើត</td></tr></table>
				</td>
				<td style="width:80%">
					<table style="display:inline-block;margin-left:10px;border:1px solid #585353;padding-left:6px;padding-top: 5px;vertical-align:middle;width:98%;height: 30px;font-size:12px;box-sizing:border-box;line-height:1.8"><tr><td>{{isset($personalInfo->PLACE_OF_BIRTH) ? $personalInfo->PLACE_OF_BIRTH:''}}</td></tr></table>
				</td>
			
			</tr>
		</table>
		<table style="width:100%;margin: 20px;">
			<tr>
				<td style="width:20%">
					<table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';"><tr><td>អាសយដ្ឋានបច្ចុប្បន្ន</td></tr></table>
				</td>
				<td style="width:80%">
					<table style="display:inline-block;margin-left:10px;padding-left:6px;padding-top: 5px;border: 1px solid #585353;;vertical-align:middle;width:98%;height: 30px;font-size:12px;box-sizing:border-box;line-height:1.8"><tr><td>{{isset($personalInfo->CURRENT_ADDRESS) ? $personalInfo->CURRENT_ADDRESS:''}}</td></tr></table>
				</td>
			
			</tr>
		</table>
		<table style="width:100%;margin: 20px">
        <tr>
            <td style="width:30%">
                <table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';vertical-align:middle;"><tr><td>អ៊ីម៉ែល</td></tr></table>
                <table style="display:inline-block;margin-left:10px;border: 1px solid #585353;padding-left:6px;padding-top: 5px;vertical-align:middle;width:75%;height: 30px;font-size:12px;box-sizing:border-box;line-height:1.8"><tr><td>{{isset($row->email) ? $row->email:''}}</td></tr></table>
            </td>
            <td style="width:60%;text-align: right;">
                <table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';vertical-align:middle;"><tr><td>លេខទូរស័ព្ទ</td></tr></table>
                <table style="display:inline-block;border: 1px solid #585353;padding-left:6px;padding-top: 5px; vertical-align:middle;width:82%;height: 30px;font-size:12px;box-sizing:border-box;">
                    <tr>
                        <td style="line-height:1.8;">
                           {{isset($row->phone_number) ? $row->phone_number:''}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    
    </table>
	<div class="form-group">
            <div class="col-sm-offset-9 col-sm-3">
                <button id="jqx-approve" type="button"><span class="glyphicon glyphicon-check"></span> APPROVE</button>
            </div>
        </div>
	</div>
</div>	
<script>
    $(document).ready(function(){
        var buttons = ['jqx-approve'];
        initialButton(buttons,120,35);
		
		/* APPROVE */
        $("#jqx-approve").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$approveUrl}}', '{{ csrf_token() }}');
        });
    });
</script>