<?php
$jqxPrefix = '_officer';
$newUrl = asset($constant['secretRoute'].'/officer/new');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="{{asset('icon/mef.ico')}}" />
<title>ប្រវត្តិរូបមន្រ្តីរាជការ | ក្រសួងសេដ្ឋកិច្ច និងហិរញ្ញវត្ថុ</title>

<style>
    #btn-print{
        background:url({{asset('images/printer.png')}}) no-repeat center center;
        background-size: 20px;
        padding:5px 20px;
        border: 1px solid #6a6868 !important;
        border-radius: 5px 5px; 
        right: 565px;
        cursor: pointer;
        position: absolute;
        z-index: 99;
        display: inline-block;
    }
    @font-face {
      font-family: 'muollight';
      src:  url({{asset('fonts/KhmerOS_muollight.ttf')}}) format('truetype');
    }
    @font-face {
      font-family: 'C39FI';
      src:  url({{asset('fonts/C39FI.ttf')}}) format('truetype');
    }
    body{
        font-family: 'muollight','Khmer OS Content','Myriad pro';
        overflow: none;
    }
    .main-from {
        width: 650px; 
        margin: 0 auto;
    }
    
    table,td,tr,tbody{
         page-break-inside: avoid;  
         border-collapse: collapse;
         box-sizing:border-box;
    }
    @media print {
        *{
            margin:0;
            padding:0;  
        }
        td{
            padding:0;
            margin:0;
        }
        body {
          -webkit-print-color-adjust: exact;
        }
        .main-from {
            width: auto; 
        }
        @page {
            size: A4;
            margin:0;
        }
        #btn-print{
            display: none;
        }
    
    }
    
</style>
</head>
<body style="width:100%;height:100%">
<!--start-->
<div class="main-from">
    <table style="width:100%;page-break-after: always;display:inline-table; page-break-inside: avoid;">
    <input type="button" id='btn-print' value=" " onClick="window.print()" style="font-size:16px;color: currentColor;background-color: inherit;border-color: chartreuse;">

        <tbody style="display:block;box-sizing:border-box;width:100%;">
            <tr style="display:block;box-sizing:border-box;width:100%;">
            <td style="margin:0;padding:0;display:block;width:100%;">
                 <table style="border:1px solid #000;height:100%;width:100%;box-sizing:border-box;background-color:#006838;text-align:center;overflow:hidden;position:relative;display:block;"> 
                    <tbody style="width:100%;display:block;">
                        <tr style="display:block;margin-top:15px;">
                            <td style="font-size:17pt;display:block;color:#fff;">
                                លេខ : <span style="font-family : 'Khmer OS Content';font-size:19pt;">{{sprintf("%05d", $user->Id)}}</span>
                            </td>
                        </tr>
                        <tr style="display:block;">
                            <td style="text-align:center;display:block;">
                                <img src="{{url(asset($user->avatar))}}" height='489px'>
                            </td>
                        </tr>
                        <tr style="display:block;text-align:center;">
                            <td style="text-align:center;display:block;">
                                <table style="display:block;text-align:center;font-size:16pt;color:#fff;">
                                    <tbody style="display:block;">
                                        <tr style="width:80%;margin:0 auto;display:block;overflow:hidden;line-height:1.5;">
                                            <td style="width:39%;display:block;float:left;margin-top:8px;text-align:left;margin-right:1%;">គោត្តនាមនិងនាម<span style="float:right;">: </span></td>
                                            <td style="margin-top:5px;font-size:22pt;width:59%;text-align:left;display:block;float:right;">{{$user->full_name_kh}}</td>
                                        </tr>
                                        <tr style="width:80%;margin:0 auto;display:block;overflow:hidden;line-height:1.5;">
                                            <td style="width:39%;display:block;float:left;margin-top:8px;text-align:left;margin-right:1%;">ភេទ<span style="float:right;">: </span></td>
                                            <td style="margin-top:8px;width:59%;text-align:left;display:block;float:right;font-family:Khmer OS Content;font-size:17pt;">{{$user->gender}}</td>
                                        </tr>
                                         <tr style="width:80%;margin:0 auto;display:block;overflow:hidden;line-height:1.5;">
                                            <td style="width:39%;display:block;float:left;margin-top:8px;text-align:left;margin-right:1%;">អង្គភាព<span style="float:right;">: </span></td>
                                            <td style="margin-top:8px;width:59%;text-align:left;display:block;float:right;font-family:Khmer OS Content;font-size:17pt;">{{$user->general_department_name}}</td>
                                        </tr>
                                        <tr style="width:80%;margin:0 auto;display:block;overflow:hidden;line-height:1.5;">
                                            <td style="width:39%;display:block;float:left;margin-top:8px;text-align:left;margin-right:1%;">មុខងារ<span style="float:right;">: </span></td>
                                            <td style="margin-top:8px;width:59%;text-align:left;display:block;float:right;font-family:Khmer OS Content;font-size:17pt;">{{$user->position}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr style="display:block;margin-top:14px;height: 285px;box-sizing:border-box;background:url('{{url(asset('images/sign.png'))}}') no-repeat top 10px right 20px, #fff;">
                            <td style="display:block;float:right;margin-right:10px;">
                                <span><span style="font-family:Khmer OS Content;font-size:18pt;">ភ្នំពេញ ថ្ងៃទី <span>០១</span> ខែ <span>តុលា</span> ឆ្នាំ <span>២០១៦</span></span><br />
                                <span style="font-size:17pt;">រដ្ឋមន្ត្រីក្រសួងសេដ្ឋកិច្ចនិងហិរញ្ញវត្ថុ</span><br />
                                <span style="font-size:17pt;">រដ្ឋលេខាធិការ</span><br /></span>
                                <span style="position:absolute;bottom:10px;right:70px;font-size:17pt;width:40%;"><span style="font-family:Khmer OS Content;">បណ្ឌិត</span> ហ៊ាន សាហ៊ីប</span>
                            </td>
                           
                        </tr>
                        <tr style="display:block;position:absolute;left:15px;bottom:15px;">
                            <td style="font-family: 'C39FI';font-size:70pt;">
                                {{sprintf("%05d", $user->Id)}}

                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>

        </tr>
        </tbody>
    </table>
    <!--end-->
    <!--start-->
    <table style="width:100%;page-break-after: always;display:inline-table; page-break-inside: avoid;">
        <tbody style="display:block;box-sizing:border-box;width:100%;">
            <tr style="display:block;box-sizing:border-box;width:100%;">
             <td style="margin:0;padding:0;display:block;width:100%;">
                     <table style="border:1px solid #000;height:100%;width:100%;box-sizing:border-box;background-color:#fff;text-align:center;overflow:hidden;position:relative;display:block;">    
                        <tbody style="width:100%;display:block;">
                            <tr style="display:block;margin-top:15px;">
                                <td style="font-size:19pt;display:block;color:#000;">ព្រះរាជាណាចក្រកម្ពុជា</td>
                            </tr>
                            <tr style="display:block;">
                                <td style="font-size:19pt;display:block;color:#000;font-family :'Khmer OS Content';">ជាតិ សាសនា ព្រះមហាក្សត្រ</td>
                            </tr>
                            <tr style="display:block;text-align:center">
                                <td style="display:block;text-align:center;"><img src="{{url(asset('images/bar.png'))}}"></td>
                            </tr>
                            <tr style="display:block;text-align:center;margin-top:20px;">
                                <td style="display:block;text-align:center;"><img src="{{url(asset('images/mef.png'))}}"></td>
                            </tr>
                            <tr style="display:block;text-align:center">
                                <td style="display:block;text-align:center;font-size:20pt;">ក្រសួងសេដ្ឋកិច្ចនិងហិរញ្ញវត្ថុ</td>
                            </tr>
                            <tr style="display:block;text-align:center; margin-top:50px;">
                                <td style="display:block;text-align:center;color:#a98b37;font-size:55pt;" class="lineHeight">ប័ណ្ណចេញ-ចូល</td>
                            </tr>   
                            <tr style="display:block;text-align:center; ;">
                                
                                <td style="display:block;text-align:center;font-size:14pt;margin-top:65px"><span style="font-family :'Khmer OS Content';padding-right:20px;">ប័ណ្ណនេះផុតកំណត់នៅ</span><span style="color:#ed1c24;">ថ្ងៃទី ៣០ ខែ កញ្ញា ឆ្នាំ ២០១៧</span></td>
                            </tr>
                            <tr style="display:block;text-align:center;height:200px;background:#006838;color:#fff;height:100%;vertical-align:middle;margin-top:10px;">
                                
                                <td style="display:block;text-align:center;font-family :'Khmer OS Content';line-height:1.5;float:left;padding:28px 0 0;margin-left:15px;"><span style="font-size:11pt;">ប័ណ្ណនេះ ជាលិខិតមានតម្លៃប្រើប្រាស់សម្រាប់ចេញ-ចូល ទីស្ដីការក្រសួង <br />
                                    សេដ្ឋកិច្ចនិងហិរញ្ញវត្ថុ ក្នុងករណីបាត់បង់ ឬអន្តរាយ​ដោយប្រការណាមួយនោះ <br />
                                    អ្នកកាន់ប័ណ្ណសម្គាល់ខ្លួននេះ ត្រូវមករាយការណ៍ជាបន្ទាន់ដល់ក្រសួង។</span><br />
                                    <span style="font-size:15pt;">ទូរស័ព្ទ : (855) 11 480 777    អ៊ីម៉ែល : pd@mef.gov.kh<br /></span>
                                </td>
                                <td style="display:block;text-align:center;padding:25px 0;"><img src="{{url(asset('images/QR.png'))}}"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>

        </tr>
     </tbody>
    </table>
    <!--end-->
</div>

<script type="text/javascript">
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
    window.print();
</script>


</body>
</html>
