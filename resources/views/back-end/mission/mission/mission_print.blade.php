<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>លិខិតបញ្ជាបេសកកម្ម</title>
<link rel="stylesheet" href="{{asset('css/normalize.css')}}" type="text/css" />
</head>
<style>

@font-face {
  font-family: 'KHMERMEF1';
  src:  url('{{asset('fonts/KHMERMEF1.ttf')}}') format('truetype');
}
@font-face {
  font-family: 'KHMERMEF2';
  src:  url('{{asset('fonts/KHMERMEF2.ttf')}}') format('truetype');
}
@font-face {
  font-family: 'WINGDNG';
  src:  url('{{asset('fonts/WINGDNG2.TTF')}}') format('truetype');
}
@media print 
{
    @page {
      size: A4; /* DIN A4 standard, Europe */
      margin:0 15mm;
    }
   
}
tr{vertical-align: top;}
</style>
<style>
    #btn-print{
        background:url({{asset('images/printer.png')}}) no-repeat center center;
        background-size: 20px;
        padding:5px 20px;
        border: 1px solid #6a6868 !important;
        border-radius: 5px 5px; 
        right: 150px;
        cursor: pointer;
        position: absolute;
        z-index: 99;
        display: inline-block;
        top: 70px;
    }
    @media print {
       
        #btn-print{
            display: none;
        }
        .page-break { display: block; page-break-before: always; }
        
    }
    table>tbody>tr>th{
        text-align: center;
    }
    table>tbody>tr>td{
        padding-left: 10px !important;
    }
    .text-center{
        text-align: center;
    }
</style>
<body>
     <input type="button" id='btn-print' value=" " onclick='window.print()' style="font-size:16px;color: currentColor;background-color: inherit;border-color: chartreuse;">
    <div id="DivIdToPrint" class="page-break" style="box-sizing:border-box;width:960px;margin:300px auto 0;overflow: hidden;font-family:'KHMERMEF1';">
        <!--Date-->
        <table style="font-size:15.7pt;font-style: italic;float:right;text-align:center;margin-right:2px;">
            <tr>
                <td><span style="padding-right:140px;">ថ្ងៃ</span><span style="padding-right:120px;">ខែ</span><span style="padding-right:120px;">ឆ្នាំ</span>  ព.ស.២៥៦២</td>
            </tr>
            <tr>
                <td><span style="padding-right:52px;">រាជធានីភ្នំពេញ ថ្ងៃទី</span><span style="padding-right:70px;">ខែ</span>ឆ្នាំ២០១៨</td>
            </tr>
        </table>
        <!--Title-->
        <table style="width:100%;clear:both;font-size:15.7pt;text-align:center;line-height:2;">
            <tr>
                <td style="font-family:'KHMERMEF2';font-size:15.7pt;">លិខិតបញ្ជាបេសកកម្ម</td>
            </tr>
            <tr>
                <td style="font-family: 'WINGDNG';line-height: 1.1;">ee&#128980;ff</td>
            </tr>
            <tr>
                <td style="font-family:'KHMERMEF2';font-size:15.7pt;line-height: 2.1;">ទេសរដ្ឋមន្ត្រី<br /> រដ្ឋមន្ដ្រីក្រសួងសេដ្ឋកិច្ចនិងហិរញ្ញវត្ថុ</td>
            </tr>
        </table>
        <!--Title list-->
        <table style="width:100%;clear:both;font-size:15.7pt;text-align:left;margin-top:15px;">
            <tr>
                <td>ឧទ្ទេសនាមមន្ដ្រីរាជការ ដូចមានរាយនាមខាងក្រោម៖</td>
            </tr>
        </table>
        <table style="line-height:44px;width:100%;clear:both;font-size:16pt;text-align:left;margin:10px 0 0 35px;">
            @foreach($attende as $k =>$val)
            <tr>
                <td width="25%"> {!!$tool->dayFormat($k+1) !!}.<span style="padding-left:5px;">
                    {!! $val->title !!}
                </span><span style="padding-left:6px;font-weight: bold">{!! $val->full_name_kh !!}</span></td>
                <td width="75%">
                @if($val->position=='មន្រ្តីកិច្ចសន្យារដ្ឋ')
                    មន្ត្រីកិច្ចសន្យា
                @elseif($val->position=='មន្រ្តីជាប់កិច្ចសន្យា GSC')
                មន្ត្រីកិច្ចសន្យា
                @else
                    {{$val->position}}
                @endif
                នៃនាយកដ្ឋានបច្ចេកវិទ្យាព័ត៌មាន នៃអគ្គលេខាធិការដ្ឋាន កសហវ </td>
            </tr>
            @endforeach
        </table>
        <!--កម្មវត្ថុ-->
        <table style="line-height:41px;width:100%;clear:both;font-size:15.7pt;text-align:left;margin-top:17px;vertical-align:top">
            <tr>
                <td width="25%" style="font-weight:bold">ធ្វើដំណើរទៅកាន់<span style="float:right">:</span></td>
                <td width="75%" style="font-family:'KHMERMEF2';padding-left:6px;">{!! $row->mission_location !!}</td>
            </tr>
            <tr>
                <td width="25%" style="font-weight:bold">មានភារកិច្ច<span style="float:right">:</span></td>
                <td width="75%" style="padding-left:6px;">{!! $row->mission_objective !!}</td>
            </tr>
            <tr>
                <td width="25%" style="font-weight:bold">ចេញដំណើរ<span style="float:right">:</span></td>
                <td width="75%" style="padding-left:6px;">ថ្ងៃទី      {!!$tool->dateformate($row->mission_from_date,'full') !!}</td>
            </tr>
            <tr>
                <td width="25%" style="font-weight:bold">ត្រលប់មកវិញ<span style="float:right">:</span></td>
                <td width="75%" style="padding-left:6px;">ថ្ងៃទី      {!!$tool->dateformate($row->mission_to_date,'full') !!}</td>
            </tr>
            <tr>
                <td width="25%" style="font-weight:bold">មធ្យោបាយធ្វើដំណើរ<span style="float:right">:</span></td>
                <td width="75%" style="padding-left:6px;">{!! $row->mission_transportation !!}</td>
            </tr>
        </table>
        <table style="width:100%;clear:both;font-size:15.7pt;text-align:left;margin-top:12px;vertical-align:top">
            <td><p style="margin:0;text-indent:60px">អាស្រ័យហេតុនេះ សូមឯកឧត្តម លោក លោកស្រី ដែលមានសមត្ថកិច្ចពាក់ព័ន្ធតាមក្រសួង ស្ថាប័ន រាជធានី-ខេត្ត មេត្តាជួយសម្រួលបេសកកម្មនេះ ឱ្យបានសម្រេចជោគជ័យ</p></td>
        </table>
        <!--Signature-->
        <table style="font-size:15.7pt;box-sizing:border-box;overflow: hidden;font-family:'KHMERMEF2';float:right;text-align:center;">
            <tr><td>ទេសរដ្ឋមន្ត្រី<br />រដ្ឋមន្ដ្រីក្រសួងសេដ្ឋកិច្ចនិងហិរញ្ញវត្ថុ</td></tr>
        </table>
        <!--Note-->
        <table style="margin-top:10px;font-style:italic;clear:both;box-sizing:border-box;font-family:'KHMERMEF1';overflow:hidden;float:left;text-align:left;">
            <tr><td style="font-size:12pts;font-family:'KHMERMEF2';text-decoration: underline;">ចម្លងជូន៖</td></tr>
            <tr>
                <td style="font-size:10pts;padding:0 15px;">-សាលាខេត្តពាក់ព័ន្ធ</td>
            </tr>
            <tr>
                <td style="font-size:10pts;padding:0 15px;">-មន្ទីរ សហវ</td>
            </tr>
            <tr>
                <td style="font-size:10pts;padding:0 15px;">-នាយកដ្ឋានបុគ្គលិក</td>
            </tr>
            <tr>
                <td style="font-size:10pts;padding:0 15px;">-សាមីខ្លួន ដើម្បីអនុវត្ត</td>
            </tr>
            <tr>
                <td style="font-size:10pts;padding:0 15px;">-ឯកសារ-កាលប្បវត្ដិ</td>
            </tr>
        </table>
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
