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
    
    @foreach($attende as $k =>$val)   
    <div class="page-break" style="box-sizing:border-box;width:1000px;margin:300px auto 0;overflow: hidden;font-family:'KHMERMEF1';">
        <!--Title-->
        <table style="width:100%;clear:both;font-size:15.7pt;text-align:center;line-height:2;">
            <tr>
                <td style="font-family:'KHMERMEF2';font-size:15.7pt;text-decoration: underline;">ទិដ្ឋាការធ្វើដំណើរ</td>
            </tr>
        </table>
        <!--Title list-->
       
        <!--កម្មវត្ថុ-->
        <table style="line-height:41px;width:100%;clear:both;font-size:15.7pt;text-align:left;margin-top:17px;vertical-align:top">
            <tr>
                <td width="25%">ផ្តល់ជូន<span style="float:right">:</span></td>
                <td width="75%" style="font-family:'KHMERMEF2';padding-left:6px;"><span style="font-family:'KHMERMEF1'">{!! $val->title !!} </span>{!! $val->full_name_kh !!}</td>
            </tr>
            <tr>
                <td width="25%">ឋានៈ<span style="float:right">:</span></td>
                <td width="75%" style="padding-left:6px;"> {!! str_replace("រដ្ឋ","",str_replace("GSC","",$val->position)) !!}  </td>
            </tr>
            <tr>
                <td width="25%">អង្គភាព<span style="float:right">:</span></td>
                <td width="75%" style="padding-left:6px;">នាយកដ្ឋានបច្ចេកវិទ្យាព័ត៌មាន</td>
            </tr>
            <tr>
                <td width="25%">ត្រលប់មកវិញ<span style="float:right">:</span></td>
                <td width="75%" style="padding-left:6px;">ថ្ងៃទី     {!!$tool->dateformate($row->mission_to_date,'full') !!}</td>
            </tr>
        </table>
        <table style="line-height:41px;width:100%;clear:both;font-size:15.7pt;text-align:left;vertical-align:top">
            <tr><td>យោងលិខិតបញ្ជាបេសកកម្មលេខ {{$row->reference_no}}    ចុះថ្ងៃទី {!!$tool->dateformate($row->reference_date,'full') !!}</td></tr>
        </table>
        <table style="line-height:41px;width:100%;clear:both;font-size:15.7pt;text-align:left;vertical-align:top">
            <tr>
                <td width="25%">ចេញដោយ<span style="float:right">:</span></td>
                <td width="75%" style="padding-left:6px;">{{$row->approve_by}}</td>
            </tr>
            <tr>
                <td width="25%">ភារកិច្ច<span style="float:right">:</span></td>
                <td width="75%" style="padding-left:6px;word-break: break-all;">អ្នកសម្របសម្រួលក្នុងកិច្ចប្រជុំដើម្បីប្រមូលធាតុចូលសម្រាប់រៀបចំផែនការយុទ្ធសាស្រ្ដបញ្ជ្រាបយេនឌ័រក្នុងវិស័យសេដ្ឋកិច្ចនិងហិរញ្ញវត្ថុឆ្នាំ២០១៨-២០២២។</td>
            </tr>
        </table>
        <!--Signature-->
        <table style="font-size:15.7pt;float:right;text-align:center;margin-right:2px;margin-top:20px;margin-bottom: 10px;">
            <tr>
                <td><span style="padding-right:140px;">ថ្ងៃ</span><span style="padding-right:120px;">ខែ</span><span style="padding-right:120px;">ឆ្នាំ</span>  ព.ស.២៥៦២</td>
            </tr>
            <tr>
                <td><span style="padding-right:52px;">រាជធានីភ្នំពេញ ថ្ងៃទី</span><span style="padding-right:70px;">ខែ</span>ឆ្នាំ២០១៨</td>
            </tr>
            <tr><td style="font-family:'KHMERMEF2';">{{$miss->signature_position}}</td></tr>
            <tr><td style="padding-top:40px;font-family:'KHMERMEF2';">{{$miss->signature_by}}</td></tr>
        </table>
        <table border="1" style="line-height:41px;width:100%;clear:both;font-size:15.7pt;text-align:left;box-sizing: border-box;">
            <tr>
                <th width="28%" style="vertical-align:middle;padding:20px 0; font-family:'KHMERMEF2';font-weight: normal">កន្លែងចេញដំណើរនិងមកដល់</th>
                <th width="22%" style="vertical-align:middle;padding:20px 0;font-family:'KHMERMEF2';font-weight: normal">ថ្ងៃ  ខែ  ឆ្នាំ</th>
                <th width="22%" style="vertical-align:middle;padding:20px 0;font-family:'KHMERMEF2';font-weight: normal">មធ្យោបាយធ្វើដំណើរ</th>
                <th width="28%" style="vertical-align:middle;padding:20px 0;font-family:'KHMERMEF2';font-weight: normal">សេចក្តីបញ្ជាក់ហត្ថលេខា<br />និងត្រា</th>
            </tr>
            @if($row->mission_location_id)
                <tr>
                    <td width="28%" style="padding:30px 0;">{{trans('mission.mission_start')}}
                       <!--  @if($miss->missionProvinceId()->first())
                            {{$miss->missionProvinceId()->first()->name_kh}}
                        @endif -->
                    </td>
                    <td width="22%" style="padding:30px 0;"></td>
                    <td width="22%" style="padding:30px 0;" class="text-center">{!! $row->mission_transportation !!}</td>
                    <td width="28%" style="padding:30px 0;"></td>
                </tr>
            @endif
            @if(isset($miss))
                @foreach ($miss->missionProvince()->orderBy('order','asc')->get() as $p => $pro) 
                @if($p <=1)
                <tr class="{{$p==1?'single_record':''}}">
                    <td width="28%" style="padding:30px 0;">
                        {{trans('mission.arrive_place')}}
                       <!--  @if($pro->province()->first())
                            {{$pro->province()->first()->name_kh}}
                        @endif -->
                    </td>
                    <td width="22%" style="padding:30px 0;">
                        
                    </td>
                    <td width="22%" style="padding:30px 0;" class="text-center">{!! $row->mission_transportation !!}</td>
                    <td width="28%" style="padding:30px 0;"></td>
                </tr>
                @endif
                @if($miss->missionProvince()->count()>1 & $p >=1)
                    @if($p ==1)
                    </table>
                    </div>
                    <div class="page-break" style="box-sizing:border-box;width:1000px;margin:50px auto 0;overflow: hidden;font-family:'KHMERMEF1';">
                    <table  border="1" style="line-height:41px;width:100%;clear:both;font-size:15.7pt;text-align:left;box-sizing: border-box;">
                    @else
                    <tr class="">
                        <td width="28%" style="padding:30px 0;">
                            {{trans('mission.arrive_place')}}
                           <!--  @if($pro->province()->first())
                                {{$pro->province()->first()->name_kh}}
                            @endif -->
                        </td>
                        <td width="22%" style="padding:30px 0;">
                            
                        </td>
                        <td width="22%" style="padding:30px 0;" class="text-center">{!! $row->mission_transportation !!}</td>
                        <td width="28%" style="padding:30px 0;"></td>
                    </tr>
                    @endif
                    <tr>
                        <td width="28%" style="padding:30px 0;">{{trans('mission.mission_start')}} 
                           <!--  @if($pro->province()->first())
                                {{$pro->province()->first()->name_kh}}
                            @endif -->
                        </td>
                        <td width="22%" style="padding:30px 0;"></td>
                        <td width="22%" style="padding:30px 0;" class="text-center">{!! $row->mission_transportation !!}</td>
                        <td width="28%" style="padding:30px 0;"></td>
                    </tr>
                @else
                    <tr>
                        <td width="28%" style="padding:30px 0;">{{trans('mission.mission_start')}} 
                           <!--  @if($pro->province()->first())
                                {{$pro->province()->first()->name_kh}}
                            @endif -->
                        </td>
                        <td width="22%" style="padding:30px 0;"></td>
                        <td width="22%" style="padding:30px 0;" class="text-center">{!! $row->mission_transportation !!}</td>
                        <td width="28%" style="padding:30px 0;"></td>
                    </tr>
                    @endif
                @endforeach
            @endif
            @if($row->mission_location_id)
                <tr>
                    <td width="28%" style="padding:30px 0;">{{trans('mission.arrive_place')}}
                        @if($miss->missionProvinceId()->first())
                            <!-- {{$miss->missionProvinceId()->first()->name_kh}} -->
                        @endif
                    </td>
                    <td width="22%" style="padding:30px 0;"></td>
                    <td width="22%" style="padding:30px 0;" class="text-center">{!! $row->mission_transportation !!} 

                    </td>
                    <td width="28%" style="padding:30px 0;"></td>
                </tr>
            @endif
        </table>
    </div>
     @endforeach
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
