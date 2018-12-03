<?php
$jqxPrefix = '_officer';
$avatar = $row->AVATAR != '' ? $row->AVATAR:'images/photo-default.jpg';
$saveUrl = asset($constant['secretRoute'].'/officer/save');
?>
<div class="container-fluid">
	<form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
		<input type="hidden" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
		<div id="login-content">
			<div style="padding:10px;margin:10px;">
				<table style="width:100%;">
					<tr>
						<td style="width:33.333333%;">

						</td>
						<td style="width:33.3333333333%;height: 50px;text-align:center;font-family:'KHMERMEF2';font-size:14px;">
							{{trans('trans.king_of_cambodia')}}<br /><br/>{{trans('trans.national_religion_king')}}
						</td>
						<td style="width:33.33333333333%;position:relative;">
							<table style="font-style:italic;font-family: 'KHMERMEF1';position:absolute;right:5px;top:10px;font-size:10px"><tr><td></td></tr></table>
						</td>
					</tr>
				</table>
				<table style="width:100%;position:relative">
					<tr>
						<td style="width:17%;text-align:center">
							<img src="{{asset('images/logo.png')}}" width="90px;font-family:'KHMERMEF2';">
							<div style="font-family:'KHMERMEF2';font-size:12px;padding-top:5px;">{{trans('trans.institude_name_kh')}}<br/><br/> {{trans('officer.working_place')}}: {{isset($row->SecretariatName) ? $row->SecretariatName:''}} </div>
						</td>
						<td style="width:50%;position:relative">
							<table style="font-family:'KHMERMEF1';font-size:9px;text-align:center" >
								<tr style="border:1px solid #000">
									<td style="width:92px;height:118px;border: 0px solid #585353;;position:absolute;right:22px;top:2px;padding-top:0px;">
									<img src="{{asset('/').$avatar}}" width="92" height="118">
									</td><br /><br />
									<td style="position:absolute;right:0;top:125px;">
										<div id="barcode">{!! $row->Id !!}</div>
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
							<tr><td>{{trans('officer.officer_hisotry')}}<br /><br />{{trans('trans.institude_name_kh')}}</td></tr>
						</table>
					</tr>
				</table>

				<table style="width:100%;margin: 20px;">

					<tr>
						<td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;text-align:right;font-size:12px;">
						   {{trans('officer.full_name')}}
						</td>
						<td style="width:35%;"><table style="display:inline-block;margin-left:10px;border: 1px solid #585353;padding-left:6px;padding-top: 5px;vertical-align:middle;width:90%;height: 30px ;font-size:12px;line-height:1.8"><tr><td>{{isset($row->FULL_NAME_KH) ? $row->FULL_NAME_KH:''}}</td></tr></table></td>
						<td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right">
						   {{trans('officer.english_name')}}
						</td>
						<td style="width:35%;"><table style="display:inline-block;margin-left:10px;border: 1px solid #585353;padding-left:6px;padding-top: 5px;vertical-align:middle;width:93%;height: 30px;font-size:12px;line-height:1.8"><tr><td>{{isset($row->FULL_NAME_EN) ? $row->FULL_NAME_EN:''}}</td></tr></table></td>
					</tr>

				</table>
				<table style="width:100%;margin: 20px">
				<tr>
						<td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;text-align:right">
						   {{trans('officer.email')}}
						</td>
						<td style="width:35%;"><table style="display:inline-block;margin-left:10px;border: 1px solid #585353;padding-left:6px;padding-top: 5px;vertical-align:middle;width:90%;height: 30px ;font-size:12px;line-height:1.8"><tr><td>{{isset($row->EMAIL) ? $row->EMAIL:''}}</td></tr></table></td>
						<td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right">
						   {{trans('officer.phone_number')}}
						</td>
						<td style="width:35%;"><table style="display:inline-block;margin-left:10px;border: 1px solid #585353;padding-left:6px;padding-top: 5px;vertical-align:middle;width:93%;height: 30px;font-size:12px;line-height:1.8"><tr><td>{{isset($row->PHONE_NUMBER_1) ? $row->PHONE_NUMBER_1:''}}</td></tr></table></td>
					</tr>

			</table>
				<table style="width:100%;margin: 20px;">
					<tr>
						<td style="width:20%;text-align:right;">
							<table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';text-align:right;"><tr><td>{{trans('officer.date_of_birth')}}</td></tr></table>
						</td>
						<td style="width:80%">
						<?php 
                    		$DOB = isset($row->date_of_birth) ? $row->date_of_birth:'';
                		?>
							<table style="display:inline-block;margin-left:10px;border:1px solid #585353;padding-left:6px;padding-top: 5px;vertical-align:middle;width:98%;height: 30px;font-size:12px;box-sizing:border-box;line-height:1.8"><tr><td>{{$DOB !=null && $DOB !='0000-00-00' && $DOB != '' ? $tool->dateformate($DOB) : "​ "}}</td></tr></table>
						</td>

					</tr>
				</table>

				<table style="width:100%;margin: 20px;">
					<tr>
						<td style="width:20%;text-align:right">
							<table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';"><tr><td>{{trans('officer.address')}}</td></tr></table>
						</td>
						<td style="width:80%">
							<table style="display:inline-block;margin-left:10px;padding-left:6px;padding-top: 5px;border: 1px solid #585353;;vertical-align:middle;width:98%;height: 30px;font-size:12px;box-sizing:border-box;line-height:1.8"><tr><td>
										​ផ្ទះលេខ {{isset($currentAddress->house) ? $currentAddress->house : "​"}}
										​ផ្លូវលេខ {{isset($currentAddress->street) ? $currentAddress->street : "​"}}
										​{{isset($currentAddress->villages) ? $currentAddress->villages : "​"}}
										{{isset($currentAddress->commune) ? $currentAddress->commune : ""}}
										{{isset($currentAddress->districts) ? $currentAddress->districts : "​"}}
										{{isset($currentAddress->province) ? $currentAddress->province : ""}}
										{{isset($currentAddress->province) ? $currentAddress->province : "​"}}
							</td></tr></table>
						</td>

					</tr>
				</table>

				<div class="form-group">
					<div class="col-xs-offset-10 col-xs-2">
						<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-ok-sign"></span> {{trans('officer.approve')}}</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
    function get_object(id) {
        var object = null;
        if (document.layers) {
            object = document.layers[id];
        } else if (document.all) {
            object = document.all[id];
        } else if (document.getElementById) {
            object = document.getElementById(id);
        }
        return object;
    }
    $(document).ready(function(){
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,100,30);


		var bar_size=3;
		if(get_object("barcode").innerHTML <6){
			bar_size = 8;
		}
		if(get_object("barcode").innerHTML <3){
			bar_size = 15;
		}

		get_object("barcode").innerHTML=DrawHTMLBarcode_Code39(get_object("barcode").innerHTML,0,"no","on",0,2,0.5,bar_size,"bottom","right","","black","white");


		/* APPROVE */
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
    });
</script>