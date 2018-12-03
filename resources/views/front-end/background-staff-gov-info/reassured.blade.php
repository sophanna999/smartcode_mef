<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="{{asset('icon/mef.ico')}}" />
<title>ប្រវត្តិរូបមន្រ្តីរាជការ | ក្រសួងសេដ្ឋកិច្ច និងហិរញ្ញវត្ថុ</title>
<meta name="chromesniffer" id="chromesniffer_meta" content="{}">
<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/code39.js')}}"></script>
<script type="text/javascript" src="{{asset('js/detector.js')}}"></script>
</head>
<style>

	#btn-print{
		background:url({{asset('images/printer.png')}}) no-repeat center center;
		background-size: 20px;
		padding:5px 20px;
		border: 1px solid #6a6868 !important;
		border-radius: 5px 5px;	
	}
     @font-face {
    font-family: 'KHMERMEF1';
    src:  url({{asset('fonts/KHMERMEF1.woff')}}) format('truetype');
    }
    @font-face {
    font-family: 'KHMERMEF2';
    src:  url({{asset('fonts/KHMERMEF2.woff')}}) format('truetype');
    }
   
</style>
<body>
<div class="wrapper" style="max-width:960px;width:100%;margin:0 auto;">
<div style="padding: 15px;margin: 15px;" class="wrap-print">
    <table style="width:100%;">
        <tr>
            <td style="width:33.333333%;">
            
            </td>
            <td style="width:33.3333333333%;height: 100px;text-align:center;font-family:'KHMERMEF2';font-size:14px;">
                ព្រះរាជាណាចក្រកម្ពុជា<br />ជាតិ  សាសនា  ព្រះមហាក្សត្រ
            </td>
            <td style="width:33.33333333333%;position:relative;">
                <table style="font-family: 'KHMERMEF1';position:absolute;right:25px;top:30px;font-size:10px;font-weight: bold;"><tr><td><input type="button" id='btn-print' value=" " onClick="window.print()" style="font-size:16px;color: currentColor;background-color: inherit;border-color: chartreuse;"></td></tr></table>
            </td>
        </tr>
    </table>
    <table style="width:100%;position:relative">
        <tr>
            <td style="width:20%;text-align:center">
                <img src="{{asset('images/logo.png')}}" width="90px;font-family:'KHMERMEF2';">
                <table style="width:100%;position:relative;top:0px;"><tr><td style="font-family:'KHMERMEF2';font-size:12px" >ក្រសួងសេដ្ឋកិច្ចនិងហិរញ្ញវត្ថុ<br/>អង្គភាព : {{ $userInfo->Name }}</td></tr></table>
            </td>
            <td style="width:50%;position:relative">
                <table style="font-family:'KHMERMEF1';font-size:9px;text-align:center;">
                    <tr>
                        <td style="width:92px;height:auto;position:absolute;right:22px;top:30px;">
                            <img src="{{ asset($userInfo->avatar != '' ? $userInfo->avatar : 'images/photo-default.jpg') }}" style="width: inherit;height: inherit;">
                        </td><br/>
                        <td style="position:absolute;right: -11px;top: 170px;font-family:'automation';font-size:12px;">
							<div id="barcode">{!! $userInfo->id !!}</div>
						</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <table style="width:100%;">
        <tr> 
            <table style="text-align:center;font-family:'KHMERMEF2';font-size:20px;position:relative;top:-40px;font-size:15px;width:100%">
                <tr><td>ប្រវត្តិរូបមន្ត្រីរាជការ<br/>ក្រសួងសេដ្ឋកិច្ចនិងហិរញ្ញវត្ថុ</td></tr>
            </table>
        </tr>
    </table>
    
    <table style="width:100%;margin:0px;">
       
        <tr>
            <td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;text-align:right">
               គោត្តនាម-នាម
            </td>
            <td style="width:30%;"><table style="display:inline-block;height:26px;margin-left:10px;border: 1px solid #585353;vertical-align:middle;width:100%;font-size:12px;line-height:1.8; font-family:'KHMERMEF1'; padding-top:4px;padding-left:3px;"><tr><td>{{ $userInfo->FULL_NAME_KH }}</td></tr></table></td>
            <td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;text-align:right">
               ជាអក្សរឡាតាំង
            </td>
            <td style="width:30%;"><table style="display:inline-block;height:26px;margin-left:10px;border: 1px solid #585353;;vertical-align:middle;width:100%;font-size:12px;line-height:1.8; font-family:'KHMERMEF1';padding-top:4px;padding-left:3px; "><tr><td>{{ $userInfo->FULL_NAME_EN }}</td></tr></table></td>
        </tr>
       <tr>
            <td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;text-align:right">
               អ៊ីម៉ែល
            </td>
            <td style="width:35%;"><table style="display:inline-block;height:26px;margin-left:10px;border: 1px solid #585353;vertical-align:middle;width:100%;font-size:12px;line-height:1.8; font-family:'KHMERMEF1'; padding-top:4px;padding-left:3px;"><tr><td>{{ $userInfo->EMAIL }}</td></tr></table></td>
            <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right">
               លេខទូរស័ព្ទ
            </td>
            <td style="width:35%;"><table style="display:inline-block;height:26px;margin-left:10px;border: 1px solid #585353;;vertical-align:middle;width:100%;font-size:12px;line-height:1.8; font-family:'KHMERMEF1';padding-top:4px;padding-left:3px; "><tr><td>{{ $userInfo->PHONE_NUMBER_1 }}</td></tr></table></td>
        </tr>
		
		<tr>
            <td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;text-align:right">
               ទីកន្លែងកំណើត
            </td>
            <td colspan="4"><table style="display:inline-block;height:26px;margin-left:10px;border: 1px solid #585353;vertical-align:middle;width:100%;font-size:12px;line-height:1.8; font-family:'KHMERMEF1'; padding-top:4px;padding-left:3px;"><tr><td>{{ $userInfo->PLACE_OF_BIRTH }}</td></tr></table></td>
        </tr>
		<tr>
			<td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right">
              អាសយដ្ឋានបច្ចុប្បន្ន
            </td>
            <td colspan="4"><table style="display:inline-block;margin-left:10px;height:26px;border: 1px solid #585353;;vertical-align:middle;width:100%;font-size:12px;line-height:1.8; font-family:'KHMERMEF1';padding-top:4px;padding-left:3px; "><tr><td>
                            {{isset($currentAddress->province) ? $currentAddress->province : "​ខេត្រ"}}
                            ស្រុក/ខ័ណ្ឌ​ {{isset($currentAddress->districts) ? $currentAddress->districts : "​"}}
                            ឃុំ/សង្កាត់​ {{isset($currentAddress->commune) ? $currentAddress->commune : ""}}
                            ​ភូមិ {{isset($currentAddress->villages) ? $currentAddress->villages : "​"}}
                            ​ផ្លូវលេខ {{isset($currentAddress->street) ? $currentAddress->street : "​"}}
                            ​ផ្ទះលេខ {{isset($currentAddress->house) ? $currentAddress->house : "​"}}
                        </td></tr></table></td>
        </tr>
    </table>
    
    <table width="100%" cellpadding="5" cellspacing="5">
	<tr>
    
    	<td style="text-align:center;font-family:'KHMERMEF1';font-size:12px;width:20%;">ខ្ញុំសូមធានាអះអាង និងទទួលខុសត្រូវចំពោះមុខច្បាប់ថា ព័ត៌មានដែលបានបំពេញនៅក្នុងប្រវត្តិរូប ពិតជាត្រឹមត្រូវប្រាកដមែន ។</td>
        <td></td>
    </tr>
    
    <tr>
    	<td></td>
    	<td style="text-align:right;font-family:'KHMERMEF1';font-size:12px;" colspan="8">ធ្វើនៅ..............ថ្ងៃទី.........ខែ.........ឆ្នាំ............
        
        </td>
    </tr>
    <tr>
    	<td style="text-align:center;font-family:'KHMERMEF1';font-size:12px;">
        	
        </td>
        <td style="text-align:center">
        	
        <strong style="font-family:'KHMERMEF1';font-size:12px">ហត្ថលេខាសាមីខ្លួន</strong>
        </td>
    </tr>
    <tr>
    	<td style="text-align:center;font-family:'KHMERMEF1';font-size:12px;font-family:'KHMERMEF1';font-size:12px"></td>
        <td style="text-align:center;font-family:'KHMERMEF1';font-size:12px;width:20%;">
        	<br/>
            <strong></strong>
        </td>
    </tr>
	
</table>
</div>
</div>
</body>
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
var bar_size=3;
if(get_object("barcode").innerHTML <6){
	bar_size = 8;
}
if(get_object("barcode").innerHTML <3){
	bar_size = 15;
}

get_object("barcode").innerHTML=DrawHTMLBarcode_Code39(get_object("barcode").innerHTML,0,"no","on",0,2,0.5,bar_size,"bottom","right","","black","white");

(function() {

    var beforePrint = function() {
		$('#btn-print').hide();
    };

    var afterPrint = function() {
		$('#btn-print').show();
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