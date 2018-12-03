<?php
$jqxPrefix = '_officer';
$jqxPrefix_appro = '__officer_appro';
$saveUrl = asset($constant['secretRoute'].'/officer/save');
$pushBackUrl = asset($constant['secretRoute'].'/officer/push-back');
$backDashboard = asset($constant['secretRoute'].'/officer');
$newUrl = asset($constant['secretRoute'].'/officer/new');
?>
        <!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{asset('icon/mef.ico')}}" />
    <title>ប្រវត្តិរូបមន្រ្តីរាជការ | ក្រសួងសេដ្ឋកិច្ច និងហិរញ្ញវត្ថុ</title>
    <link rel="stylesheet" href="{{asset('tooltip_modal_only/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('jqwidgets/styles/jqx.base.css')}}">
    <script src="{{asset('jqwidgets/jquery-1.11.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/code39.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/detector.js')}}"></script>
    <!-- Optionally use Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.0.0/animate.min.css">
    <link rel="stylesheet" href="{{asset('css/liquid-slider.css')}}" />
</head>
<style>
    body{ font-family: 'KHMERMEF1'; }
    .tooltip {font-family: 'KHMERMEF1'; }
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
    @page {
        size: auto;
        margin:20px 30px 20px 30px;
        size: A4;
    }
    @media print {
        table{page-break-inside: avoid;}
    }
    .border-black{ border:1px solid #000; }
    .border-red{ color:red }
    .jqx-notification-mail, .jqx-primary {
        color: #ffffff !important;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25) !important;
        background-color: #006dcc !important;
        background-repeat: repeat-x !important;
        background-image: linear-gradient(to bottom, #0088cc, #0044cc) !important;
        border-left-color: #0044cc !important;
        border-right-color: #0044cc !important;
        border-top-color: #0044cc !important;
        border-bottom-color: #002a80 !important;
        cursor: pointer;
    }
    button.close {
        -webkit-appearance: none;
        padding: 0;
        cursor: pointer;
        background: 0 0;
        border: 0;
    }
    .close {
        float: right;
        font-size: 21px;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        filter: alpha(opacity=20);
        opacity: .2;
        font-family: sans-serif;
    }
    .jqx-notification-warning, .jqx-warning,.jqx-notification-success, .jqx-success{
        font-family: 'KHMERMEF1';
        font-size:20px;
        z-index: 999 !important;
    }
    button.jqx-button, input[type=button].jqx-button, input[type=submit].jqx-button {
        font-family: 'KHMERMEF1';
    }
    #main-slider-wrapper
    {
        width: 100% !important;
        max-width: 100% !important;
    }
    table
        {
            min-height: 30px;
        }
</style>
<body>
<input type="hidden" id="baseUrl" value="{{asset('')}}" />
<div id="jqx-notification"></div>
<div id="jqxLoader"></div>
<div id="main-slider" class="liquid-slider">
    <div>
        <h2 class="title">ស្នើកែប្រែប្រវត្តិរូប</h2>
        <div class="wrapper" style="max-width:960px;width:100%;margin:0 auto;">
            <table style="width:100%;margin-top:20px;">
                <tr>
                    <td style="width:33.333333%;">
                    </td>
                    <td style="width:33.3333333333%;text-align:center;font-family:'KHMERMEF2';font-size:13px;">
                        {{trans('trans.king_of_cambodia')}}<br />{{trans('trans.national_religion_king')}}
                    </td>
                    <td style="width:33.33333333333%;position:relative;">
                        <table style="font-style:italic;font-family: 'KHMERMEF1';position:absolute;right:5px;top:10px;font-size:10px"><tr><td></td></tr></table>
                    </td>
                </tr>
            </table>
            <table style="width:100%;position:relative;margin-top:-30px;">
                <tr>
                    <td style="width:20%;">
                        <img src="{{asset('images/mef-logo.png')}}" width="43%" style="font-family:'KHMERMEF2';position:relative;left:35px;">
                        <table><tr><td style="font-family:'KHMERMEF2';font-size:13px" >{{trans('trans.institude_name_kh')}} <br/>{{trans('officer.working_place')}}:{{isset($serviceStatusCurrentId->CURRENT_GENERAL_DEPARTMENTED) ? $serviceStatusCurrentId->CURRENT_GENERAL_DEPARTMENTED : "​ "}}</td></tr></table>
                    </td>
                    <td style="width:50%;position:relative">
                        <table style="font-family:'KHMERMEF1';font-size:9px;text-align:center" >
                            <tr style="border:1px solid #000">
                                <td style="width:92px;height:118px;position:absolute;right:15px;top:20px;padding-top:5px;">
                                    <?php
                                    $avatar = $row->AVATAR !="" ? '<img src="'.asset('/').$row->AVATAR.'" width="90px;">' : '<img src="'.asset('images/photo-default.jpg').'" width="90px;">';
                                    echo $avatar;
                                    ?>
                                </td><br />
                                <td {{ (isset($personalInfo->ID) ? $personalInfo->ID : "​ ") <> (isset($personalInfoApprove->ID) ? $personalInfoApprove->ID : "​ ") ? "class=border-red" : "​" }} style="position:absolute;right:-10px;top:165px;font-family:'automation';font-size:12px">
                                    <div id="barcode">{!! $personalInfo->ID !!}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style="width:100%;">
                <tr>
                    <table style="text-align:center;font-family:'KHMERMEF2';position:relative;top:-50px;font-size:13px;width:100%">
                        <tr><td>{{trans('officer.hisotry')}}<br />{{trans('trans.institude_name_kh')}}</td></tr>
                    </table>
                </tr>
            </table>
            <table style="width:100%;margin: 15px 0 0 0;">
                <tr>
                    <td>
                        <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-bottom:10px;font-size:12px;">១-{{trans('personal_info.persional_info')}}</h5>
                    </td>
                </tr>
                <tr>
                    <td style="font-family:'KHMERMEF1';width:19.8%;font-size:12px">
                        {{trans('personal_info.official_id')}}
                    </td>
                    <td style="width: 33%">
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'; width: 92%; margin-left: 27px">
                            <tr>
                                <td {{ (isset($row->PERSONAL_INFORMATION) ? $row->PERSONAL_INFORMATION : "​ ") <> (isset($rowApprove->PERSONAL_INFORMATION) ? $rowApprove->PERSONAL_INFORMATION : "​ ") ? "class=border-red" : "​" }} style="font-size:12px;padding:0 5px;letter-spacing:2px;height:25px;min-width: 288px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1';">{{isset($row->PERSONAL_INFORMATION) ? $row->PERSONAL_INFORMATION : "​ "}}</td>
                            </tr>
                        </table>
                    </td>

                    <td style="font-family:'KHMERMEF1';width:22.8%;font-size:12px;text-align:right; padding-right: 14px">
                        {{trans('personal_info.official_id_card_of_mef')}}
                    </td>
                    <td>
                        <table  style="display:inline-block; border: 1px solid #000;vertical-align:middle;font-size:12px;line-height:1.8;padding-left:2px;font-family:'KHMERMEF1'; width: 220%">
                            <tr>
                                <td {{ (isset($row->OFFICIAL_ID) ? $row->OFFICIAL_ID : "​ ") <> (isset($rowApprove->OFFICIAL_ID) ? $rowApprove->OFFICIAL_ID : "​ ") ? "class=border-red" : "​" }} style="padding:0 5px;letter-spacing:2px;height:25px;min-width:50px;">{{isset($row->OFFICIAL_ID) ? $row->OFFICIAL_ID : "​ "}}</td></tr></table></td>
                    <td style="font-family:'KHMERMEF1';width:35%;font-size:12px;text-align:right;">
                        {{trans('personal_info.unit_id')}}
                    </td>
                    <td><table style="display:inline-block; border: 1px solid #000;vertical-align:middle;font-size:12px;line-height:1.8;padding-left:2px;font-family:'KHMERMEF1';"><tr><td {{ (isset($row->UNIT_CODE) ? $row->UNIT_CODE : "​ ") <> (isset($rowApprove->UNIT_CODE) ? $rowApprove->UNIT_CODE : "​ ") ? "class=border-red" : "​" }} style="padding:0 5px;letter-spacing:2px;height:25px;min-width:50px;">{{ isset($row->UNIT_CODE) ? $row->UNIT_CODE : "​ "}}</td></tr></table></td>
                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;">
                        {{trans('officer.full_name')}}
                    </td>
                    <td style="width:35%;">
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:90.8%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($row->FULL_NAME_KH) ? $row->FULL_NAME_KH : "​ ") <> (isset($rowApprove->FULL_NAME_KH) ? $rowApprove->FULL_NAME_KH : "​ ") ? "class=border-red" : "​" }} style="font-size:12px;padding:0 5px;letter-spacing:2px;height:25px;min-width: 288px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1';">{{isset($row->FULL_NAME_KH) ? $row->FULL_NAME_KH : "​ "}}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right;padding-right:5px;">
                        {{trans('officer.english_name')}}
                    </td>
                    <td style="width:35%;">
                        <table style="display:inline-block;border: 1px solid #000;vertical-align:middle;width:97%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1';float: right;">
                            <tr>
                                <td {{ (isset($row->FULL_NAME_EN) ? $row->FULL_NAME_EN : "​ ") <> (isset($rowApprove->FULL_NAME_EN) ? $rowApprove->FULL_NAME_EN : "​ ") ? "class=border-red" : "​" }} style="font-size:12px;padding:0 5px;letter-spacing:2px;height:25px;min-width: 282px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1';">{{ isset($row->FULL_NAME_EN) ? $row->FULL_NAME_EN : "​ "}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-family:'KHMERMEF1';width:18%;vertical-align:middle;">
                        <table style="display:inline-block;font-size:12px;border-collapse:collapse;margin-top:-12px;" cellpadding="0" cellspacing="0">
                            <tr>
                                <?php
                                $gender = isset($row->GENDER) ? $row->GENDER:'';
                                ?>
                                <td>{{trans('personal_info.gender')}}</td>
                                <td {{ (isset($row->GENDER) ? $row->GENDER : "​ ") <> (isset($rowApprove->GENDER) ? $rowApprove->GENDER : "​ ") ? "class=border-red" : "​" }} style="display:inline-block;vertical-align:middle;vertical-align:middle;font-size:11px;" ><input type="checkbox" name="gender" disabled style="vertical-align:middle;" <?php echo ($gender =='ប្រុស' ? 'checked' :''); ?> >{{trans('personal_info.man')}}</td>
                                <td {{ (isset($row->GENDER) ? $row->GENDER : "​ ") <> (isset($rowApprove->GENDER) ? $rowApprove->GENDER : "​ ") ? "class=border-red" : "​" }} style="display:inline-block;font-size:11px;"><input type="checkbox" name="gender" disabled style="vertical-align:middle;" <?php echo ($gender  =='ស្រី' ? 'checked' :''); ?> >{{trans('personal_info.woman')}}</td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php
                        $DOB = isset($row->DATE_OF_BIRTH) ? $row->DATE_OF_BIRTH:'';
                        ?>
                        <table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';vertical-align:middle;"><tr><td>{{trans('personal_info.date_of_birth')}}</td></tr></table>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:66%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'"><tr><td {{ (isset($row->DATE_OF_BIRTH) ? $row->DATE_OF_BIRTH : "​ ") <> (isset($rowApprove->DATE_OF_BIRTH) ? $rowApprove->DATE_OF_BIRTH : "​ ") ? "class=border-red" : "​" }} style="font-size:12px;padding:0 5px;letter-spacing:2px;height:25px;min-width: 206px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1';">{{$DOB !=null && $DOB !='0000-00-00' && $DOB != '' ? $tool->dateformate($DOB) : "​ "}}</td>
                            </tr></table>
                    </td>
                    <td style="font-size:12px;font-family:'KHMERMEF1';">
                        <?php
                        $MARRIED = isset($row->MARRIED) ? $row->MARRIED:'';
                        ?>
                        <table style="display:inline-block;vertical-align:middle;text-align:right;width:190%;">
                            <tr>
                                <td {{ (isset($row->MARRIED) ? $row->MARRIED : "​ ") <> (isset($rowApprove->MARRIED) ? $rowApprove->MARRIED : "​ ") ? "class=border-red" : "​" }} style="font-size:12px;right:-15%;line-height:1.5;position:relative;left:-20px; padding-right:47px">
                                    <input type="checkbox" style="vertical-align:middle;float:left;" disabled value="" <?php echo ($MARRIED<> 1 ? 'checked': '') ?> >{{trans('personal_info.singal')}}
                                </td>
                                <td>{{trans('personal_info.nationaley')}}</td></tr></table>
                    </td>
                    <td style="width:35%;font-family:'KHMERMEF1'">
                        <table style="display:inline-block;border: 1px solid #000;vertical-align:middle;width:97%;font-size:12px;line-height:1.8;padding-left:5px;float: right;"><tr>
                                <?php
                                $NATIONALITY_1 = isset($row->NATIONALITY_1) ? $row->NATIONALITY_1:'';
                                $NATIONALITY_2 = isset($row->NATIONALITY_2) ? $row->NATIONALITY_2:'';
                                ?>
                                <td {{ (isset($row->$NATIONALITY_1) ? $row->$NATIONALITY_1 : "​ ") <> (isset($rowApprove->$NATIONALITY_1) ? $rowApprove->$NATIONALITY_1 : "​ ") ? "class=border-red" : "​" }} style="font-size:12px;padding:0 5px;letter-spacing:2px;height:25px;min-width: 136px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1'; margin-right: 5px;">1. {{$NATIONALITY_1 !=null ? $NATIONALITY_1 : "​ "}}</td>
                                <td {{ (isset($row->$NATIONALITY_2) ? $row->$NATIONALITY_2 : "​ ") <> (isset($rowApprove->$NATIONALITY_2) ? $rowApprove->$NATIONALITY_2 : "​ ") ? "class=border-red" : "​" }} style="font-size:12px;padding:0 5px;letter-spacing:2px;height:25px;min-width: 140px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1';">2. {{$NATIONALITY_2 !=null ? $NATIONALITY_2 : "​ "}}</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <?php
                    $POB = isset($row->PLACE_OF_BIRTH) ? $row->PLACE_OF_BIRTH:'';
                    ?>
                    <td style="width:18%;font-size:12px;font-family:'KHMERMEF1';">
                        {{trans('personal_info.place_of_birth')}}
                    </td>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($row->PLACE_OF_BIRTH) ? $row->PLACE_OF_BIRTH : "​ ") <> (isset($rowApprove->PLACE_OF_BIRTH) ? $rowApprove->PLACE_OF_BIRTH : "​ ") ? "class=border-red" : "​" }} style="width:1%;margin-left:10px;vertical-align:middle;font-size:12px;box-sizing:border-box;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                    {{$POB != null ? $POB : "​​ "}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table  style="width:100%">
                <tr>
                    <td style="width:18%;font-size:12px;font-family:'KHMERMEF1';">
                        {{trans('officer.address')}}
                    </td>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($currentAddress->province) ? $currentAddress->province : "​ ") <> (isset($currentAddressApprove->province) ? $currentAddressApprove->province : "​ ") ? "class=border-red" : "​" }} style="width:1%;margin-left:10px;vertical-align:middle;font-size:12px;box-sizing:border-box;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                    ​ផ្ទះលេខ {{isset($currentAddress->house) ? $currentAddress->house : "​"}}
                                    ​ផ្លូវលេខ {{isset($currentAddress->street) ? $currentAddress->street : "​"}}
                                    ​{{isset($currentAddress->villages) ? $currentAddress->villages : "​"}}
                                    {{isset($currentAddress->commune) ? $currentAddress->commune : ""}}
                                    {{isset($currentAddress->districts) ? $currentAddress->districts : "​"}}
                                    {{isset($currentAddress->province) ? $currentAddress->province : ""}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td style="width:45.3%">
                        <table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';vertical-align:middle;width:29%;margin-left:-2px;"><tr><td>{{trans('officer.email')}}</td></tr></table>
                        <table style="float:right;display:inline-block;border: 1px solid #000; vertical-align:middle;width:63.2%;font-size:12px;box-sizing:border-box;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'"><tr><td {{ (isset($row->EMAIL) ? $row->EMAIL : "​ ") <> (isset($rowApprove->EMAIL) ? $rowApprove->EMAIL : "​ ") ? "class=border-red" : "​" }} style="width:1%;margin-left:10px;vertical-align:middle;font-size:12px;box-sizing:border-box;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">{{ isset($row->EMAIL) ? $row->EMAIL : "​ "}}</td></tr></table>
                    </td>
                    <td style="width:46%;text-align: right;">
                        <table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';vertical-align:middle;"><tr><td>{{trans('officer.phone_number')}}</td></tr></table>
                        <table style="display:inline-block;border: 1px solid #000; vertical-align:middle;width:82%;font-size:12px;box-sizing:border-box;padding-left:5px;">
                            <tr>
                                <td {{ (isset($row->PHONE_NUMBER_1) ? $row->PHONE_NUMBER_1 : "​ ") <> (isset($rowApprove->PHONE_NUMBER_1) ? $rowApprove->PHONE_NUMBER_1 : "​ ") ? "class=border-red" : "​" }} style="line-height:1.8;width:8%;text-align:left;">
                                    1. {{ isset($row->PHONE_NUMBER_1) ? $row->PHONE_NUMBER_1 : "​ " }}
                                </td>
                                <td {{ (isset($row->PHONE_NUMBER_2) ? $row->PHONE_NUMBER_2 : "​ ") <> (isset($rowApprove->PHONE_NUMBER_2) ? $rowApprove->PHONE_NUMBER_2 : "​ ") ? "class=border-red" : "​" }} style="padding-left:3%;width:8%;text-align:left;">
                                    2. {{ isset($row->PHONE_NUMBER_2) ? $row->PHONE_NUMBER_2 : " " }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style="width:100%;margin-top:-2px;">
                <tr>
                    <td style="font-family:'KHMERMEF1';width:18%;vertical-align:middle;font-size:12px;vertical-align:middle;">{{trans('personal_info.identity_card')}}
                    </td>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:140.3%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($row->NATION_ID) ? $row->NATION_ID : "​ ") <> (isset($rowApprove->NATION_ID) ? $rowApprove->NATION_ID : "​ ") ? "class=border-red" : "​" }} style="width:21%;font-size:12px;padding-left:5px;font-family:'KHMERMEF1'">{{ isset($row->NATION_ID) ? $row->NATION_ID : "​ "}}</td>
                            </tr>
                        </table>
                    </td>

                    <td style="font-family:'KHMERMEF1';width:28%;vertical-align:middle;font-size:12px;text-align:right;padding-right:16px;">
                        {{trans('personal_info.deadline')}}
                    </td>
                    <?php
                    $NATION_ID_EXPIRED_DATE = isset($row->NATION_ID_EXPIRED_DATE) ? $row->NATION_ID_EXPIRED_DATE: '';
                    ?>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($row->NATION_ID_EXPIRED_DATE) ? $row->NATION_ID_EXPIRED_DATE : "​ ") <> (isset($rowApprove->NATION_ID_EXPIRED_DATE) ? $rowApprove->NATION_ID_EXPIRED_DATE : "​ ") ? "class=border-red" : "​" }} style="font-size:12px;line-height:2;padding-left:5px;text-align:center;font-family:'KHMERMEF1'; width: 21%">{{$NATION_ID_EXPIRED_DATE !=null && $NATION_ID_EXPIRED_DATE !='0000-00-00' && $NATION_ID_EXPIRED_DATE !='' ? $tool->dateformate($NATION_ID_EXPIRED_DATE) : "​ "}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style="width:100%;margin-top:1px;">
                <tr>
                    <td style="font-family:'KHMERMEF1';width:18%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                        {{trans('personal_info.passport')}}
                    </td>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:133.4%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($row->PASSPORT_ID) ? $row->PASSPORT_ID : "​ ") <> (isset($rowApprove->PASSPORT_ID) ? $rowApprove->PASSPORT_ID : "​ ") ? "class=border-red" : "​" }} style="width:21%;font-size:12px;line-height:2;padding-left:2px;padding-left:5px;font-family:'KHMERMEF1'">{{ isset($row->PASSPORT_ID) ? $row->PASSPORT_ID : "​ "}}</td>
                            </tr>
                        </table>
                    </td>

                    <td style="font-family:'KHMERMEF1';width:27%;vertical-align:middle;font-size:12px;text-align:right;padding-right:16px;">
                        {{trans('personal_info.deadline')}}
                    </td>
                    <?php
                    $PASSPORT_ID_EXPIRED_DATE = isset($row->PASSPORT_ID_EXPIRED_DATE) ? $row->PASSPORT_ID_EXPIRED_DATE:'';
                    ?>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($row->PASSPORT_ID_EXPIRED_DATE) ? $row->PASSPORT_ID_EXPIRED_DATE : "​ ") <> (isset($rowApprove->PASSPORT_ID_EXPIRED_DATE) ? $rowApprove->PASSPORT_ID_EXPIRED_DATE : "​ ") ? "class=border-red" : "​" }} style="width:21%;font-size:12px;line-height:2;padding-left:2px;padding-left:5px;text-align:center;font-family:'KHMERMEF1'">{{$PASSPORT_ID_EXPIRED_DATE !=null && $PASSPORT_ID_EXPIRED_DATE != '0000-00-00' && $PASSPORT_ID_EXPIRED_DATE !='' ? $tool->dateformate($PASSPORT_ID_EXPIRED_DATE) : "​ "}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td>
                        <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-bottom:0;font-size:12px;">២-{{trans('officer.work_situation')}}</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;margin-bottom:0;font-size:12px;">ក.ចូលបម្រើការងាររដ្ឋដំបូង</h5>
                    </td>
                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td style="font-family:'KHMERMEF1';width:25%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                        កាលបរិច្ឆេទប្រកាសចូលបម្រើការងាររដ្ឋដំបូង
                    </td>
                    <td style="width: 32%">
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:78%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusInfoId->FIRST_START_WORKING_DATE_FOR_GOV) ? $serviceStatusInfoId->FIRST_START_WORKING_DATE_FOR_GOV : "​ ") <> (isset($serviceStatusInfoIdApprove->FIRST_START_WORKING_DATE_FOR_GOV) ? $serviceStatusInfoIdApprove->FIRST_START_WORKING_DATE_FOR_GOV : "​ ") ? "class=border-red" : "​" }} style="width:22%;font-size:12px;line-height:2;padding-left:5px;text-align:left;font-family:'KHMERMEF1'">{{isset($serviceStatusInfoId->FIRST_START_WORKING_DATE_FOR_GOV) && $serviceStatusInfoId->FIRST_START_WORKING_DATE_FOR_GOV != '0000-00-00' && $serviceStatusInfoId->FIRST_START_WORKING_DATE_FOR_GOV !='' ? $tool->dateformate($serviceStatusInfoId->FIRST_START_WORKING_DATE_FOR_GOV)  : "​ "}}</td>
                            </tr>
                        </table>
                    </td>

                    <td style="font-family:'KHMERMEF1';width:11.9%;vertical-align:middle;font-size:12px;text-align:right;padding-right:17px;">
                        កាលបរិច្ឆេទតាំងស៊ប់
                    </td>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusInfoId->FIRST_GET_OFFICER_DATE) ? $serviceStatusInfoId->FIRST_GET_OFFICER_DATE : "​ ") <> (isset($serviceStatusInfoIdApprove->FIRST_GET_OFFICER_DATE) ? $serviceStatusInfoIdApprove->FIRST_GET_OFFICER_DATE : "​ ") ? "class=border-red" : "​" }} style="width:33%;font-size:12px;line-height:2;padding-left:5px;text-align:center;font-family:'KHMERMEF1'">{{isset($serviceStatusInfoId->FIRST_GET_OFFICER_DATE) && $serviceStatusInfoId->FIRST_GET_OFFICER_DATE != '0000-00-00' && $serviceStatusInfoId->FIRST_GET_OFFICER_DATE != ''? $tool->dateformate($serviceStatusInfoId->FIRST_GET_OFFICER_DATE) : "​ "}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td style="font-family:'KHMERMEF1';width:25%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                        ក្របខ័ណ្ឌឋានន្តរស័ក្តិ និងថ្នាក់
                    </td>
                    <td style="width: 22.5%">
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:111.5%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusInfoId->className) ? $serviceStatusInfoId->className : "​ ") <> (isset($serviceStatusInfoIdApprove->className) ? $serviceStatusInfoIdApprove->className : "​ ") ? "class=border-red" : "​" }} style="width:23%;font-size:12px;line-height:2;padding-left:5px;padding:0 5px;letter-spacing:2px;font-family:'KHMERMEF1'">{{isset($serviceStatusInfoId->className) ? $serviceStatusInfoId->className : "​ "}}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="font-family:'KHMERMEF1';width:21.6%;vertical-align:middle;font-size:12px;text-align:right;padding-right:17px;">
                        មុខតំណែង
                    </td>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusInfoId->positionName) ? $serviceStatusInfoId->positionName : "​ ") <> (isset($serviceStatusInfoIdApprove->positionName) ? $serviceStatusInfoIdApprove->positionName : "​ ") ? "class=border-red" : "​" }} style="width:28%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                    {{isset($serviceStatusInfoId->positionName) ? $serviceStatusInfoId->positionName : "​ "}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td style="font-family:'KHMERMEF1';width:25%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                        ក្រសួង/ស្ថាប័ន
                    </td>
                    <td style="width: 27.2%;">
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:91%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusInfoId->ministryName) ? $serviceStatusInfoId->ministryName : "​ ") <> (isset($serviceStatusInfoIdApprove->ministryName) ? $serviceStatusInfoIdApprove->ministryName : "​ ") ? "class=border-red" : "​" }} style="width:27%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                    {{isset($serviceStatusInfoId->ministryName) ? $serviceStatusInfoId->ministryName : "​ "}}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="font-family:'KHMERMEF1';vertical-align:middle;font-size:12px;text-align:right;padding-right:17px; width: 16.9%;">
                        អង្គភាព
                    </td>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusInfoId->secretariteName) ? $serviceStatusInfoId->secretariteName : "​ ") <> (isset($serviceStatusInfoIdApprove->secretariteName) ? $serviceStatusInfoIdApprove->secretariteName : "​ ") ? "class=border-red" : "​" }} style="width:28%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                    {{isset($serviceStatusInfoId->secretariteName) ? $serviceStatusInfoId->secretariteName : "​ "}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td style="font-family:'KHMERMEF1';width:25%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                        នាយកដ្ឋាន/អង្គភាព/មន្ទីរ
                    </td>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;min-width: 87%;width:87%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusInfoId->departmentName) ? $serviceStatusInfoId->departmentName : "​ ") <> (isset($serviceStatusInfoIdApprove->departmentName) ? $serviceStatusInfoIdApprove->departmentName : "​ ") ? "class=border-red" : "​" }} style="width:27%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                    {{isset($serviceStatusInfoId->departmentName) ? $serviceStatusInfoId->departmentName : "​ "}}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="font-family:'KHMERMEF1';width:15.7%;vertical-align:middle;font-size:12px;text-align:right;padding-right:17px;">
                        ការិយាល័យ
                    </td>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusInfoId->OfficeName) ? $serviceStatusInfoId->OfficeName : "​ ") <> (isset($serviceStatusInfoIdApprove->OfficeName) ? $serviceStatusInfoIdApprove->OfficeName : "​ ") ? "class=border-red" : "​" }} style="width:35%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                    {{isset($serviceStatusInfoId->OfficeName) ? $serviceStatusInfoId->OfficeName : "​ "}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td>
                        <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;margin-bottom:0;font-size:12px;">ខ.ស្ថានភាពការងារបច្ចុប្បន្ន</h5>
                    </td>
                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td style="font-family:'KHMERMEF1';width:16%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                        ក្របខ័ណ្ឌ ឋានន្តរស័ក្តិ និងថ្នាក់
                    </td>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusCurrentId->CURRENT_OFFICER_CLASSED) ? $serviceStatusCurrentId->CURRENT_OFFICER_CLASSED : "​ ") <> (isset($serviceStatusCurrentIdApprove->CURRENT_OFFICER_CLASSED) ? $serviceStatusCurrentIdApprove->CURRENT_OFFICER_CLASSED : "​ ") ? "class=border-red" : "​" }} style="width:8.5%;font-size:12px;line-height:2;padding-left:5px;letter-spacing:2px;font-family:'KHMERMEF1'">
                                    {{isset($serviceStatusCurrentId->CURRENT_OFFICER_CLASSED) ? $serviceStatusCurrentId->CURRENT_OFFICER_CLASSED : "​ "}}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="font-family:'KHMERMEF1';width:35%;vertical-align:middle;font-size:12px;text-align:right;padding-right:17px;">
                        កាលបរិច្ឆេទប្តូរក្របខ័ណ្ឌ ឋានន្តរស័ក្តិ និងថ្នាក់  ចុងក្រោយ
                    </td>
                    <td style="width: 30.8%">
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusCurrentId->CURRETN_PROMOTE_OFFICER_DATE) ? $serviceStatusCurrentId->CURRETN_PROMOTE_OFFICER_DATE : "​ ") <> (isset($serviceStatusCurrentIdApprove->CURRETN_PROMOTE_OFFICER_DATE) ? $serviceStatusCurrentIdApprove->CURRETN_PROMOTE_OFFICER_DATE : "​ ") ? "class=border-red" : "​" }} style="width:12%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'; text-align: center">
                                    {{isset($serviceStatusCurrentId->CURRETN_PROMOTE_OFFICER_DATE) && $serviceStatusCurrentId->CURRETN_PROMOTE_OFFICER_DATE != '0000-00-00' && $serviceStatusCurrentId->CURRETN_PROMOTE_OFFICER_DATE != '' ? $tool->dateformate($serviceStatusCurrentId->CURRETN_PROMOTE_OFFICER_DATE) : "​ "}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td style="font-family:'KHMERMEF1';width:16%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                        មុខតំណែង
                    </td>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:162%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusCurrentId->CURRENT_POSITIONED) ? $serviceStatusCurrentId->CURRENT_POSITIONED : "​ ") <> (isset($serviceStatusCurrentIdApprove->CURRENT_POSITIONED) ? $serviceStatusCurrentIdApprove->CURRENT_POSITIONED : "​ ") ? "class=border-red" : "​" }} style="width:17%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                    {{isset($serviceStatusCurrentId->CURRENT_POSITIONED) ? $serviceStatusCurrentId->CURRENT_POSITIONED : "​ "}}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="font-family:'KHMERMEF1';width:41.8%;vertical-align:middle;font-size:12px;text-align:right;padding-right:17px;">
                        កាលបរិច្ឆេទទទួលមុខតំណែងចុងក្រោយ
                    </td>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusCurrentId->CURRENT_GET_OFFICER_DATE) ? $serviceStatusCurrentId->CURRENT_GET_OFFICER_DATE : "​ ") <> (isset($serviceStatusCurrentIdApprove->CURRENT_GET_OFFICER_DATE) ? $serviceStatusCurrentIdApprove->CURRENT_GET_OFFICER_DATE : "​ ") ? "class=border-red" : "​" }} style="width:15%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'; text-align:center;">
                                    {{isset($serviceStatusCurrentId->CURRENT_GET_OFFICER_DATE) && $serviceStatusCurrentId->CURRENT_GET_OFFICER_DATE != '0000-00-00' && $serviceStatusCurrentId->CURRENT_GET_OFFICER_DATE != '' ? $tool->dateformate($serviceStatusCurrentId->CURRENT_GET_OFFICER_DATE) : "​ "}}
                                </td>
                            </tr>
                        </table>
                    </td>

                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td style="width:30%;font-size:12px;font-family:'KHMERMEF1';">
                        អគ្គលេខាធិការដ្ឋាន/អគ្គនាយកដ្ឋាន/អគ្គាធិការដ្ឋាន/វិទ្យាស្ថាន
                    </td>
                    <td>
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusCurrentId->CURRENT_GENERAL_DEPARTMENTED) ? $serviceStatusCurrentId->CURRENT_GENERAL_DEPARTMENTED : "​ ") <> (isset($serviceStatusCurrentIdApprove->CURRENT_GENERAL_DEPARTMENTED) ? $serviceStatusCurrentIdApprove->CURRENT_GENERAL_DEPARTMENTED : "​ ") ? "class=border-red" : "​" }} style="width:1%;margin-left:10px;vertical-align:middle;font-size:12px;box-sizing:border-box;line-height:1.8;padding:3px 0 3px 5px;font-family:'KHMERMEF1'">
                                    {{isset($serviceStatusCurrentId->CURRENT_GENERAL_DEPARTMENTED) && $serviceStatusCurrentId->CURRENT_GENERAL_DEPARTMENTED !="" ? $serviceStatusCurrentId->CURRENT_GENERAL_DEPARTMENTED : "​ "}}
                                </td>
                            </tr>
                        </table>
                    </td>

                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td style="font-family:'KHMERMEF1';width:16%;vertical-align:middle;font-size:12px;">
                        នាយកដ្ឋាន/អង្គភាព/មន្ទីរ
                    </td>
                    <td style="width:38%">
                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusCurrentId->CURRENT_DEPARTMENTED) ? $serviceStatusCurrentId->CURRENT_DEPARTMENTED : "​ ") <> (isset($serviceStatusCurrentIdApprove->CURRENT_DEPARTMENTED) ? $serviceStatusCurrentIdApprove->CURRENT_DEPARTMENTED : "​ ") ? "class=border-red" : "​" }} style="width:30%;margin-left:10px;vertical-align:middle;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">{{isset($serviceStatusCurrentId->CURRENT_DEPARTMENTED) ? $serviceStatusCurrentId->CURRENT_DEPARTMENTED : "​ "}}
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td style="font-family:'KHMERMEF1';width:12%;vertical-align:middle;font-size:12px;text-align:right">
                        ការិយាល័យ
                    </td>
                    <td style="width:35%;">
                        <table style="display:inline-block;margin-left:10px; border: 1px solid #000;vertical-align:middle;width:97%;font-size:12px;line-height:1.8;padding-left:2px;font-family:'KHMERMEF1'">
                            <tr>
                                <td {{ (isset($serviceStatusCurrentId->CURRENT_OFFICED) ? $serviceStatusCurrentId->CURRENT_OFFICED : "​ ") <> (isset($serviceStatusCurrentIdApprove->CURRENT_OFFICED) ? $serviceStatusCurrentIdApprove->CURRENT_OFFICED : "​ ") ? "class=border-red" : "​" }} >
                                    {{isset($serviceStatusCurrentId->CURRENT_OFFICED) ? $serviceStatusCurrentId->CURRENT_OFFICED : "​ "}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div style="line-break: loose;page-break-before: always">
                <table style="width:100%">
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;margin-bottom:0;font-size:12px;">គ.តួនាទីបន្ថែមលើមុខងារបច្ចុប្បន្ន (ឋានៈស្មើ)</h5>
                        </td>
                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td style="font-family:'KHMERMEF1';width:16%;font-size:12px">
                            កាលបរិច្ឆេទចូល
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($serviceStatusAdditioanlId->ADDITIONAL_WORKING_DATE_FOR_GOV) ? $serviceStatusAdditioanlId->ADDITIONAL_WORKING_DATE_FOR_GOV : "​ ") <> (isset($serviceStatusAdditioanlIdApprove->ADDITIONAL_WORKING_DATE_FOR_GOV) ? $serviceStatusAdditioanlIdApprove->ADDITIONAL_WORKING_DATE_FOR_GOV : "​ ") ? "class=border-red" : "​" }} style="vertical-align:middle;width:20%;font-size:12px;line-height:2;font-family:'KHMERMEF1';padding-left:5px">
                                        {{isset($serviceStatusAdditioanlId->ADDITIONAL_WORKING_DATE_FOR_GOV) && $serviceStatusAdditioanlId->ADDITIONAL_WORKING_DATE_FOR_GOV !='0000-00-00' && $serviceStatusAdditioanlId->ADDITIONAL_WORKING_DATE_FOR_GOV !='' ? $tool->dateformate($serviceStatusAdditioanlId->ADDITIONAL_WORKING_DATE_FOR_GOV) : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="font-family:'KHMERMEF1';width:10%;font-size:12px;text-align:right;padding-right:10px;">
                            មុខតំណែង
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($serviceStatusCurrentId->additionalPosition) ? $serviceStatusCurrentId->additionalPosition : "​ ") <> (isset($serviceStatusCurrentIdApprove->additionalPosition) ? $serviceStatusCurrentIdApprove->additionalPosition : "​ ") ? "class=border-red" : "​" }} style="vertical-align:middle;width:25%;font-size:12px;line-height:2;font-family:'KHMERMEF1';padding-left:5px">
                                        {{isset($serviceStatusAdditioanlId->additionalPosition) ? $serviceStatusAdditioanlId->additionalPosition : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="font-family:'KHMERMEF1';width:10%;font-size:12px;text-align:right;padding-right:10px;">
                            ឋានៈស្មើ
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($serviceStatusCurrentId->ADDITINAL_STATUS) ? $serviceStatusCurrentId->ADDITINAL_STATUS : "​ ") <> (isset($serviceStatusCurrentIdApprove->ADDITINAL_STATUS) ? $serviceStatusCurrentIdApprove->ADDITINAL_STATUS : "​ ") ? "class=border-red" : "​" }} style="vertical-align:middle;width:20%;font-size:12px;line-height:2;font-family:'KHMERMEF1';padding-left:5px">
                                        {{isset($serviceStatusAdditioanlId->ADDITINAL_STATUS) ? $serviceStatusAdditioanlId->ADDITINAL_STATUS : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>

                </table>
                <table style="width:100%">
                    <tr>
                        <td style="width:16%;font-size:12px;font-family:'KHMERMEF1';">
                            អង្គភាព
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($serviceStatusCurrentId->ADDITINAL_UNIT) ? $serviceStatusCurrentId->ADDITINAL_UNIT : "​ ") <> (isset($serviceStatusCurrentIdApprove->ADDITINAL_UNIT) ? $serviceStatusCurrentIdApprove->ADDITINAL_UNIT : "​ ") ? "class=border-red" : "​" }} style="width:1%;margin-left:10px;vertical-align:middle;font-size:12px;box-sizing:border-box;line-height:2;padding-left:3px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusAdditioanlId->ADDITINAL_UNIT) && $serviceStatusAdditioanlId->ADDITINAL_UNIT !="" ? $serviceStatusAdditioanlId->ADDITINAL_UNIT : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                </table>
                <table>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:0;font-size:12px;line-break: loose;"> ឃ.ស្ថានភាពស្ថិតនៅក្រៅក្របខ័ណ្ឌដើម</h5>
                        </td>
                    </tr>
                </table>
                <table  width="100%" border="1px" cellpadding="0" cellspacing="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;">
                    <tr>
                        <th style="font-weight:normal">ល.រ</th>
                        <th style="font-weight:normal;width:60%;">ស្ថាប័ន/អង្គភាព</th>
                        <th style="font-weight:normal">កាលបរិច្ឆេទចាប់ផ្តើម</th>
                        <th style="font-weight:normal">កាលបរិច្ឆេទបញ្ចប់</th>
                    </tr>
                    <tbody>
                    @if(count($situationOutsideId) == 0)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach($situationOutsideId as $key => $value)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td id="situationOutsideId{{ $key }}" style="text-align:center">{{$tool->dayFormat($key+1)}}</td>
                            <td id="situationOutsideInstitution{{ $key }}">{{isset($value->INSTITUTION) ? $value->INSTITUTION : ''}}</td>
                            <td id="situationOutsideStart{{ $key }}">{{isset($value->START_DATE) && $value->START_DATE != '0000-00-00' && $value->START_DATE != '' ?  $tool->dateformate($value->START_DATE) : ''}}</td>
                            <td id="situationOutsideEnd{{ $key }}">{{isset($value->END_DATE) && $value->END_DATE != '0000-00-00' && $value->END_DATE != '' ? $tool->dateformate($value->END_DATE) : ''}}</td>
                            @foreach($situationOutsideIdApprove as $key_approve => $valueApprove)
                                @if((isset($value->START_DATE) && $value->START_DATE != '0000-00-00' && $value->START_DATE != '' ?  $tool->dateformate($value->START_DATE) : '') <> (isset($valueApprove->START_DATE) && $valueApprove->START_DATE != '0000-00-00' && $valueApprove->START_DATE != '' ?  $tool->dateformate($valueApprove->START_DATE) : '') &&
                                      (isset($value->END_DATE) && $value->END_DATE != '0000-00-00' && $value->END_DATE != '' ? $tool->dateformate($value->END_DATE) : '') <> (isset($valueApprove->END_DATE) && $valueApprove->END_DATE != '0000-00-00' && $valueApprove->END_DATE != '' ? $tool->dateformate($valueApprove->END_DATE) : ''))
                                    {{--<script>--}}
                                    {{--$(document).ready(function(){--}}
                                    {{--var element{{ $key }} = document.getElementById("situationOutsideId{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("situationOutsideInstitution{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("situationOutsideStart{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("situationOutsideEnd{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--});--}}
                                    {{--</script>--}}
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!--end table 1-->
                <table>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:0;font-size:12px;"> ង.ស្ថានភាពស្ថិតនៅតាមភាពទំនេរគ្មានបៀវត្ស</h5>
                        </td>
                    </tr>
                </table>
                <table  width="100%" border="1" cellpadding="0" cellspacing="5" style="font-family: 'KHMERMEF1';font-size:12px;border-collapse: collapse;text-align:center;">
                    <tr>
                        <th style="font-weight:normal">ល.រ</th>
                        <th style="font-weight:normal;width:60%;">ស្ថាប័ន/អង្គភាព</th>
                        <th style="font-weight:normal">កាលបរិច្ឆេទចាប់ផ្តើម</th>
                        <th style="font-weight:normal">កាលបរិច្ឆេទបញ្ចប់</th>
                    </tr>
                    <tbody>
                    @if(count($situationFreeId) == 0)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach($situationFreeId as $key => $value)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td id="situationFreeId{{ $key }}" style="text-align:center">{{$tool->dayFormat($key+1)}}</td>
                            <td id="situationFreeInstitution{{ $key }}">{{isset($value->INSTITUTION) ? $value->INSTITUTION : ''}}</td>
                            <td id="situationFreeStart{{ $key }}">{{isset($value->START_DATE) && $value->START_DATE != '0000-00-00' && $value->START_DATE != '' ?  $tool->dateformate($value->START_DATE) : ''}}</td>
                            <td id="situationFreeEnd{{ $key }}">{{isset($value->END_DATE) && $value->END_DATE != '0000-00-00' && $value->END_DATE != '' ? $tool->dateformate($value->END_DATE) : ''}}</td>
                            @foreach($situationFreeIdApprove as $key_approve => $valueApprove)
                                @if((isset($value->START_DATE) && $value->START_DATE != '0000-00-00' && $value->START_DATE != '' ?  $tool->dateformate($value->START_DATE) : '') <> (isset($valueApprove->START_DATE) && $valueApprove->START_DATE != '0000-00-00' && $valueApprove->START_DATE != '' ?  $tool->dateformate($valueApprove->START_DATE) : '') &&
                                     (isset($value->END_DATE) && $value->END_DATE != '0000-00-00' && $value->END_DATE != '' ? $tool->dateformate($value->END_DATE) : '') <> (isset($valueApprove->END_DATE) && $valueApprove->END_DATE != '0000-00-00' && $valueApprove->END_DATE != '' ? $tool->dateformate($valueApprove->END_DATE) : ''))
                                    {{--<script>--}}
                                    {{--$(document).ready(function(){--}}
                                    {{--var element{{ $key }} = document.getElementById("situationFreeId{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("situationFreeInstitution{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("situationFreeStart{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("situationFreeEnd{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--});--}}
                                    {{--</script>--}}
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!--end of table 2-->
                <table>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;margin-bottom:2px;font-size:12px;">៣.ប្រវត្តិការងារ (សូមបំពេញតាមលំដាប់ ពីថ្មីទៅចាស់)</h5>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;margin-bottom:15px;font-size:12px;">ក.ក្នុងមុខងារសាធារណៈ</h5>
                        </td>
                    </tr>
                </table>
                <table width="100%" border="1" cellpadding="0" cellspacing="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;">
                    <tr>
                        <th colspan="2" style="font-weight:normal;width:20%;">ថ្ងៃ ខែ ឆ្នាំ បំពេញការងារ</th>
                        <th rowspan="2" style="font-weight:normal;width:18%;">ក្រសួង-ស្ថាប័ន</th>
                        <th rowspan="2" style="font-weight:normal;width:18%;">អង្គភាព</th>
                        <th rowspan="2" style="font-weight:normal;width:18%;">មុខតំណែង</th>
                        <th rowspan="2" style="font-weight:normal;width:18%;">ឋានៈស្មើ</th>
                    </tr>
                    <tr>
                        <th style="font-weight:normal;font-weight:normal;width:14%;">ចូល</th>
                        <th style="font-weight:normal;font-weight:normal;width:14%;">បញ្ចប់</th>
                    </tr>
                    <tbody>
                    @if(count($workingHistoryId)==0)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach($workingHistoryId as $key => $value)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td id="workingHistoryStart{{ $key }}" style="height: 30px">{{isset($value->START_WORKING_DATE) && $value->START_WORKING_DATE !='0000-00-00' && $value->START_WORKING_DATE != '' ? $tool->dateformate($value->START_WORKING_DATE) : ''}}</td>
                            <td id="workingHistoryEnd{{ $key }}"><?php if(isset($value->END_WORKING_DATE) && $value->END_WORKING_DATE != '' && $value->END_WORKING_DATE != '0000-00-00'){ echo $tool->dateformate($value->END_WORKING_DATE); }elseif ($value->END_WORKING_DATE =='0000-00-00'){ echo "បច្ចុប្បន្ន"; }else{ echo ""; }?></td>
                            <td id="workingHistoryDepartment{{ $key }}">{{isset($value->DEPARTMENT) ? $value->DEPARTMENT : ''}}</td>
                            <td id="workingHistoryInstitution{{ $key }}">{{isset($value->INSTITUTION) ? $value->INSTITUTION : ''}}</td>
                            <td id="workingHistoryPosition{{ $key }}">{{isset($value->POSITION) ? $value->POSITION : ''}}</td>
                            <td id="workingHistoryPositionEqual{{ $key }}">{{isset($value->POSITION_EQUAL_TO) ? $value->POSITION_EQUAL_TO : ''}}</td>
                            @foreach($workingHistoryIdApprove as $key_approve => $valueApprove)
                                @if((isset($value->START_WORKING_DATE) && $value->START_WORKING_DATE !='0000-00-00' && $value->START_WORKING_DATE != '' ? $tool->dateformate($value->START_WORKING_DATE) : '') <> (isset($valueApprove->START_WORKING_DATE) && $valueApprove->START_WORKING_DATE !='0000-00-00' && $valueApprove->START_WORKING_DATE != '' ? $tool->dateformate($valueApprove->START_WORKING_DATE) : '') &&
                                    (isset($value->END_WORKING_DATE) && $value->END_WORKING_DATE !='0000-00-00' && $value->END_WORKING_DATE != '' ? $tool->dateformate($value->END_WORKING_DATE) : '') <> (isset($valueApprove->END_WORKING_DATE) && $valueApprove->END_WORKING_DATE !='0000-00-00' && $valueApprove->END_WORKING_DATE != '' ? $tool->dateformate($valueApprove->END_WORKING_DATE) : ''))
                                    {{--<script>--}}
                                    {{--$(document).ready(function(){--}}
                                    {{--var element{{ $key }} = document.getElementById("workingHistoryStart{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("workingHistoryEnd{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("workingHistoryDepartment{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("workingHistoryInstitution{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("workingHistoryPosition{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("workingHistoryPositionEqual{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--});--}}
                                    {{--</script>--}}
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!--end of table 3-->
                <table>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:15pxa;font-size:12px;">ខ.ក្នុងវិស័យឯកជន</h5>
                        </td>
                    </tr>
                </table>
                <table width="100%" border="1" cellpadding="0" cellspacing="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;">
                    <tr>
                        <th colspan="2" style="font-weight:normal;width:20%;">ថ្ងៃ ខែ ឆ្នាំ បំពេញការងារ</th>
                        <th rowspan="2" style="font-weight:normal;width:26%;">គ្រឹះស្ថាន-អង្គភាព</th>
                        <th rowspan="2" style="font-weight:normal;width:22%;">តួនាទី</th>
                        <th rowspan="2" style="font-weight:normal;width:18%;">ជំនាញ/បច្ចេកទេស</th>
                    </tr>
                    <tr>
                        <th style="font-weight:normal;font-weight:normal;width:14%;">ចូល</th>
                        <th style="font-weight:normal;font-weight:normal;width:14%;">បញ្ចប់</th>
                    </tr>
                    <tbody>
                    @if(count($workingHistoryPrivateId) == 0)
                        <tr style="height: 30px; font-family:'KHMERMEF1';">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach($workingHistoryPrivateId as $key => $value)
                        <tr style="height: 30px; font-family:'KHMERMEF1';text-align:center">
                            <td id="workingHistoryPrivateStart{{ $key }}" style="height:25px;">{{isset($value->PRIVATE_START_DATE) && $value->PRIVATE_START_DATE !='' && $value->PRIVATE_START_DATE != '0000-00-00' ? $tool->dateformate($value->PRIVATE_START_DATE) : ''}}</td>
                            <td id="workingHistoryPrivateEnd{{ $key }}">{{isset($value->PRIVATE_END_DATE) && $value->PRIVATE_END_DATE !='0000-00-00' && $value->PRIVATE_END_DATE != '' ? $tool->dateformate($value->PRIVATE_END_DATE) : ''}}</td>
                            <td id="workingHistoryPrivateDepartment{{ $key }}">{{isset($value->PRIVATE_DEPARTMENT) ? $value->PRIVATE_DEPARTMENT : ''}}</td>
                            <td id="workingHistoryPrivateRole{{ $key }}">{{isset($value->PRIVATE_ROLE) ? $value->PRIVATE_ROLE : ''}}</td>
                            <td id="workingHistoryPrivateSkill{{ $key }}">{{isset($value->PRIVATE_SKILL) ? $value->PRIVATE_SKILL : ''}}</td>
                            @foreach($workingHistoryPrivateIdApprove as $key_approve => $valueApprove)
                                @if((isset($value->PRIVATE_START_DATE) && $value->PRIVATE_START_DATE !='0000-00-00' && $value->PRIVATE_START_DATE != '' ? $tool->dateformate($value->PRIVATE_START_DATE) : '') <> (isset($valueApprove->PRIVATE_START_DATE) && $valueApprove->PRIVATE_START_DATE !='0000-00-00' && $valueApprove->PRIVATE_START_DATE != '' ? $tool->dateformate($valueApprove->PRIVATE_START_DATE) : '') &&
                                    (isset($value->PRIVATE_END_DATE) && $value->PRIVATE_END_DATE !='0000-00-00' && $value->PRIVATE_END_DATE != '' ? $tool->dateformate($value->PRIVATE_END_DATE) : '') <> (isset($valueApprove->PRIVATE_END_DATE) && $valueApprove->PRIVATE_END_DATE !='0000-00-00' && $valueApprove->PRIVATE_END_DATE != '' ? $tool->dateformate($valueApprove->PRIVATE_END_DATE) : ''))
                                    {{--<script>--}}
                                    {{--$(document).ready(function(){--}}
                                    {{--var element{{ $key }} = document.getElementById("workingHistoryPrivateStart{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("workingHistoryPrivateEnd{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("workingHistoryPrivateDepartment{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("workingHistoryPrivateRole{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("workingHistoryPrivateSkill{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--});--}}
                                    {{--</script>--}}
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!--end of table 4-->
                <table>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;margin-bottom:15px;font-size:12px;">៤.គ្រឿងឥស្សរិយយស ប័ណ្ណសរសើរ ឬទណ្ឌកម្មវិន័យ</h5>
                        </td>
                    </tr>
                </table>
                <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;">
                    <tr>
                        <th style="font-weight:normal;font-weight:normal">លេខឯកសារ</th>
                        <th style="font-weight:norma;font-weight:normal">កាលបរិច្ឆេទ</th>
                        <th style="font-weight:normal;font-weight:normal">ស្ថាប័ន/អង្គភាព (ស្នើរសុំ)</th>
                        <th style="font-weight:normal;font-weight:normal">ខ្លឹមសារ</th>
                        <th style="font-weight:normal;font-weight:normal">ប្រភេទ</th>
                    </tr>
                    <tbody>
                    <tr>
                        <td colspan="5" style="padding-left:5px;text-align:left;">គ្រឿងឥស្សរិយយស</td>

                    </tr>
                    @if(count($AppreciationAwardsId) == 0)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach($AppreciationAwardsId as $key => $value)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td id="AppreciationAwardsNum{{ $key }}" style="height:25px;">{{isset($value->AWARD_NUMBER) ? $value->AWARD_NUMBER : ''}}</td>
                            <td id="AppreciationAwardsDate{{ $key }}">{{isset($value->AWARD_DATE) && $value->AWARD_DATE != '0000-00-00' && $value->AWARD_DATE != '' ? $tool->dateformate($value->AWARD_DATE) : ''}}</td>
                            <td id="AppreciationAwardsDepartment{{ $key }}">{{isset($value->DEPARTMENT) ? $value->DEPARTMENT : ''}}</td>
                            <td id="AppreciationAwardsDescription{{ $key }}">{{isset($value->AWARD_DESCRIPTION) ? $value->AWARD_DESCRIPTION : ''}}</td>
                            <td id="AppreciationAwardsDind{{ $key }}">{{isset($value->AWARD_KIND) ? $value->AWARD_KIND : ''}}</td>
                            @foreach($AppreciationAwardsIdApprove as $key_approve => $valueApprove)
                                @if((isset($value->AWARD_NUMBER) ? $value->AWARD_NUMBER : '') <> (isset($valueApprove->AWARD_NUMBER) ? $valueApprove->AWARD_NUMBER : '') &&
                                    (isset($value->AWARD_DATE) && $value->AWARD_DATE !='0000-00-00' && $value->AWARD_DATE != '' ? $tool->dateformate($value->AWARD_DATE) : '') <> (isset($valueApprove->AWARD_DATE) && $valueApprove->AWARD_DATE !='0000-00-00' && $valueApprove->AWARD_DATE != '' ? $tool->dateformate($valueApprove->AWARD_DATE) : ''))
                                    {{--<script>--}}
                                    {{--$(document).ready(function(){--}}
                                    {{--var element{{ $key }} = document.getElementById("AppreciationAwardsNum{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("AppreciationAwardsDate{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("AppreciationAwardsDepartment{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("AppreciationAwardsDescription{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--var element{{ $key }} = document.getElementById("AppreciationAwardsDind{{ $key }}");--}}
                                    {{--element{{ $key }}.classList.add("border-red");--}}
                                    {{--});--}}
                                    {{--</script>--}}
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" style="padding-left:5px;text-align:left;">ទណ្ឌកម្មវិន័យ</td>
                    </tr>
                    @if(count($appreciationSanctionId) == 0)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach($appreciationSanctionId as $key => $value)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td id="appreciationSanction_num{{ $key }}" style="height:25px;">{{isset($value->AWARD_NUMBER) ? $value->AWARD_NUMBER : ''}}</td>
                            <td id="appreciationSanction_date{{ $key }}">{{isset($value->AWARD_DATE) && $value->AWARD_DATE != '0000-00-00' && $value->AWARD_DATE != '' ? $tool->dateformate($value->AWARD_DATE) : ''}}</td>
                            <td id="appreciationSanction_Department{{ $key }}">{{isset($value->DEPARTMENT) ? $value->DEPARTMENT : ''}}</td>
                            <td id="appreciationSanctionDescription{{ $key }}">{{isset($value->AWARD_DESCRIPTION) ? $value->AWARD_DESCRIPTION : ''}}</td>
                            <td id="appreciationSanctionDind{{ $key }}">{{isset($value->AWARD_KIND) ? $value->AWARD_KIND : ''}}</td>
                            @foreach($appreciationSanctionIdApprove as $key_approve => $valueApprove)
                                @if((isset($value->AWARD_NUMBER) ? $value->AWARD_NUMBER : '') <> (isset($valueApprove->AWARD_NUMBER) ? $valueApprove->AWARD_NUMBER : '') &&
                                    (isset($value->AWARD_DATE) && $value->AWARD_DATE !='0000-00-00' && $value->AWARD_DATE != '' ? $tool->dateformate($value->AWARD_DATE) : '') <> (isset($valueApprove->AWARD_DATE) && $valueApprove->AWARD_DATE !='0000-00-00' && $valueApprove->AWARD_DATE != '' ? $tool->dateformate($valueApprove->AWARD_DATE) : ''))
                                    <script>
                                        $(document).ready(function(){
                                            var element{{ $key }} = document.getElementById("appreciationSanction_num{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("appreciationSanction_date{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("appreciationSanction_Department{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("appreciationSanctionDescription{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("appreciationSanctionDind{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                        });
                                    </script>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!--break-->
            <div style="line-break: loose;page-break-before: always">
                <table>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;margin-bottom:15px;font-size:12px;">៥.កំរិតវប្បធម៌ទូទៅ ការបណ្តុះបណ្តាលបន្ត</h5>
                        </td>
                    </tr>
                </table>
                <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;">
                    <tr>
                        <th rowspan="2" style="font-weight:normal">វគ្គ ឬ កម្រិតសិក្សា</th>
                        <th rowspan="2" style="font-weight:normal;width:34%;">គ្រឹះស្ថាន និងទីកន្លែង (ប្រទេស)</th>
                        <th rowspan="2" style="font-weight:normal">សញ្ញាបត្រទទួលបាន (ជំនាញឯកទេស)</th>
                        <th colspan="2" style="font-weight:normal;width:30%;">ថ្ងៃ ខែ ឆ្នាំ សិក្សា</th>
                    </tr>
                    <tr>
                        <th style="font-weight:normal;width:14%;">ចូល</th>
                        <th style="font-weight:normal;width:14%;">បញ្ចប់</th>
                    </tr>
                    <tbody>
                    <tr>
                        <td colspan="5" style="padding-left:5px;text-align:left;">កំរិតវប្បធម៌ទូទៅ</td>
                    </tr>
                    <tr style="height:25px;">
                        <td {{ (isset($generalQualificationsId->LEAVED) ? $generalQualificationsId->LEAVED : "​ ") <> (isset($generalQualificationsIdApprove->LEAVED) ? $generalQualificationsIdApprove->LEAVED : "​ ") ? "class=border-red" : "​" }}>{{isset($generalQualificationsId->LEAVED) ? $generalQualificationsId->LEAVED : '' }}</td>
                        <td {{ (isset($generalQualificationsId->PLACE) ? $generalQualificationsId->PLACE : "​ ") <> (isset($generalQualificationsIdApprove->PLACE) ? $generalQualificationsIdApprove->PLACE : "​ ") ? "class=border-red" : "​" }}>{{isset($generalQualificationsId->PLACE) ? $generalQualificationsId->PLACE : ''}}</td>
                        <td {{ (isset($generalQualificationsId->GRADUATION_MAJORED) ? $generalQualificationsId->GRADUATION_MAJORED : "​ ") <> (isset($generalQualificationsIdApprove->GRADUATION_MAJORED) ? $generalQualificationsIdApprove->GRADUATION_MAJORED : "​ ") ? "class=border-red" : "​" }}>{{isset($generalQualificationsId->GRADUATION_MAJORED) ? $generalQualificationsId->GRADUATION_MAJORED : ''}}</td>
                        <td {{ (isset($generalQualificationsId->Q_START_DATE) ? $generalQualificationsId->Q_START_DATE : "​ ") <> (isset($generalQualificationsIdApprove->Q_START_DATE) ? $generalQualificationsIdApprove->Q_START_DATE : "​ ") ? "class=border-red" : "​" }}>{{isset($generalQualificationsId->Q_START_DATE) && $generalQualificationsId->Q_START_DATE != '0000-00-00' && $generalQualificationsId->Q_START_DATE != '' ? $tool->dateformate($generalQualificationsId->Q_START_DATE) : ''}}</td>
                        <td {{ (isset($generalQualificationsId->Q_END_DATE) ? $generalQualificationsId->Q_END_DATE : "​ ") <> (isset($generalQualificationsIdApprove->Q_END_DATE) ? $generalQualificationsIdApprove->Q_END_DATE : "​ ") ? "class=border-red" : "​" }}>{{isset($generalQualificationsId->Q_END_DATE) && $generalQualificationsId->Q_END_DATE != '0000-00-00' && $generalQualificationsId->Q_END_DATE != '' ? $tool->dateformate($generalQualificationsId->Q_END_DATE) : ''}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="padding-left:5px;text-align:left;">កំរិតសញ្ញាបត្រ/ជំនាញឯកទេស</td>
                    </tr>
                    @if(count($generalQualificationsSkillId) == 0)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif

                    @foreach($generalQualificationsSkillId as $key =>$value)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td id="generalQualificationsSkill_leaved{{ $key }}" style="height:25px;">{{isset($value->LEAVED) ? $value->LEAVED : ''}}</td>
                            <td id="generalQualificationsSkill_place{{ $key }}">{{isset($value->PLACE) ? $value->PLACE : ''}}</td>
                            <td id="generalQualificationsSkill_major{{ $key }}">{{isset($value->GRADUATION_MAJOR) ? $value->GRADUATION_MAJOR : ''}}</td>
                            <td id="generalQualificationsSkill_start{{ $key }}">{{isset($value->Q_START_DATE) && $value->Q_START_DATE != '0000-00-00' && $value->Q_START_DATE != '' ? $tool->dateformate($value->Q_START_DATE) : ''}}</td>
                            <td id="generalQualificationsSkill_end{{ $key }}">{{isset($value->Q_END_DATE) && $value->Q_END_DATE != '0000-00-00' && $value->Q_END_DATE != '' ? $tool->dateformate($value->Q_END_DATE) : ''}}</td>
                            @foreach($generalQualificationsSkillIdApprove as $key_approve => $valueApprove)
                                @if((isset($value->GRADUATION_MAJOR) ? $value->GRADUATION_MAJOR : '') <> (isset($valueApprove->GRADUATION_MAJOR) ? $valueApprove->GRADUATION_MAJOR : '') &&
                                    (isset($value->Q_START_DATE) && $value->Q_START_DATE !='0000-00-00' && $value->Q_START_DATE != '' ? $tool->dateformate($value->Q_START_DATE) : '') <> (isset($valueApprove->Q_START_DATE) && $valueApprove->Q_START_DATE !='0000-00-00' && $valueApprove->Q_START_DATE != '' ? $tool->dateformate($valueApprove->Q_START_DATE) : '') &&
                                    (isset($value->Q_END_DATE) && $value->Q_END_DATE !='0000-00-00' && $value->Q_END_DATE != '' ? $tool->dateformate($value->Q_END_DATE) : '') <> (isset($valueApprove->Q_END_DATE) && $valueApprove->Q_END_DATE !='0000-00-00' && $valueApprove->Q_END_DATE != '' ? $tool->dateformate($valueApprove->Q_END_DATE) : ''))
                                    <script>
                                        $(document).ready(function(){
                                            var element{{ $key }} = document.getElementById("generalQualificationsSkill_leaved{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("generalQualificationsSkill_place{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("generalQualificationsSkill_major{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("generalQualificationsSkill_start{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("generalQualificationsSkill_end{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                        });
                                    </script>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" style="padding-left:5px;text-align:left;">វគ្គបណ្តុះបណ្តាលវិជ្ជាជីវៈ (ក្រោម១២ខែ)</td>
                    </tr>
                    @if(count($generalQualificationsTrainingId) == 0)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach($generalQualificationsTrainingId as $key =>$value)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td id="generalQualificationsTraining_leaved{{ $key }}" style="height:25px;">{{isset($value->LEAVED) ? $value->LEAVED : ''}}</td>
                            <td id="generalQualificationsTraining_place{{ $key }}">{{isset($value->PLACE) ? $value->PLACE : ''}}</td>
                            <td id="generalQualificationsTraining_major{{ $key }}">{{isset($value->GRADUATION_MAJOR) ? $value->GRADUATION_MAJOR : ''}}</td>
                            <td id="generalQualificationsTraining_start{{ $key }}">{{isset($value->Q_START_DATE) && $value->Q_START_DATE !='0000-00-00' && $value->Q_START_DATE != '' ? $tool->dateformate($value->Q_START_DATE) : ''}}</td>
                            <td id="generalQualificationsTraining_end{{ $key }}">{{isset($value->Q_END_DATE) && $value->Q_END_DATE !='0000-00-00' && $value->Q_END_DATE != '' ? $tool->dateformate($value->Q_END_DATE) : ''}}</td>
                            @foreach($generalQualificationsTrainingIdApprove as $key_approve => $valueApprove)
                                @if((isset($value->GRADUATION_MAJOR) ? $value->GRADUATION_MAJOR : '') <> (isset($valueApprove->GRADUATION_MAJOR) ? $valueApprove->GRADUATION_MAJOR : '') &&
                                    (isset($value->Q_START_DATE) && $value->Q_START_DATE !='0000-00-00' && $value->Q_START_DATE != '' ? $tool->dateformate($value->Q_START_DATE) : '') <> (isset($valueApprove->Q_START_DATE) && $valueApprove->Q_START_DATE !='0000-00-00' && $valueApprove->Q_START_DATE != '' ? $tool->dateformate($valueApprove->Q_START_DATE) : '') &&
                                    (isset($value->Q_END_DATE) && $value->Q_END_DATE !='0000-00-00' && $value->Q_END_DATE != '' ? $tool->dateformate($value->Q_END_DATE) : '') <> (isset($valueApprove->Q_END_DATE) && $valueApprove->Q_END_DATE !='0000-00-00' && $valueApprove->Q_END_DATE != '' ? $tool->dateformate($valueApprove->Q_END_DATE) : ''))
                                    <script>
                                        $(document).ready(function(){
                                            var element{{ $key }} = document.getElementById("generalQualificationsTraining_leaved{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("generalQualificationsTraining_place{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("generalQualificationsTraining_major{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("generalQualificationsTraining_start{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("generalQualificationsTraining_end{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                        });
                                    </script>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!--end table 5-->
                <table>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;margin-bottom:10px;font-size:12px;">៦.សមត្ថភាពភាសាបរទេស (មធ្យម, ល្អបង្គួរ, ល្អ និង ល្អណាស់)</h5>
                        </td>
                    </tr>
                </table>

                <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;">
                    <tr>
                        <th style="font-weight:normal;width:5%;">ល.រ</th>
                        <th style="width:350px;font-weight:normal">ភាសា</th>
                        <th style="font-weight:normal;width:12%;">អាន</th>
                        <th style="font-weight:normal;width:12%;">សរសេរ</th>
                        <th style="font-weight:normal;width:12%;">និយាយ</th>
                        <th style="font-weight:normal;width:12%;">ស្តាប់</th>
                    </tr>
                    <tbody>
                    @if(count($foreignLanguagesOfficerId) == 0)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    <?php $i = 1; ?>
                    @foreach($foreignLanguagesOfficerId as $key =>$value)
                        <tr style="height: 30px; font-family:'KHMERMEF1'">
                            <td id="foreignLanguagesOfficerId_id{{ $key }}" style="text-align:center">{{$tool->dayFormat($i++)}}</td>
                            <td id="foreignLanguagesOfficerId_language{{ $key }}">{{isset($value->LANGUAGES) ? $value->LANGUAGES : ''}}</td>
                            <td id="foreignLanguagesOfficerId_read{{ $key }}">{{isset($value->READED) ? $value->READED : ''}}</td>
                            <td id="foreignLanguagesOfficerId_write{{ $key }}">{{isset($value->WRITES) ? $value->WRITES : ''}}</td>
                            <td id="foreignLanguagesOfficerId_speak{{ $key }}">{{isset($value->SPEAKS) ? $value->SPEAKS : ''}}</td>
                            <td id="foreignLanguagesOfficerId_listening{{ $key }}">{{isset($value->LISTENTS) ? $value->LISTENTS : ''}}</td>
                            @foreach($foreignLanguagesOfficerIdApprove as $key_approve => $valueApprove)
                                @if((isset($value->LANGUAGES) ? $value->LANGUAGES : '') <> (isset($valueApprove->LANGUAGES) ? $valueApprove->LANGUAGES : ''))
                                    <script>
                                        $(document).ready(function(){
                                            var element{{ $key }} = document.getElementById("foreignLanguagesOfficerId_id{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("foreignLanguagesOfficerId_language{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("foreignLanguagesOfficerId_read{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("foreignLanguagesOfficerId_write{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("foreignLanguagesOfficerId_speak{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("foreignLanguagesOfficerId_listening{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                        });
                                    </script>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!--end table 5-->
                <table>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;margin-bottom:0;font-size:12px;">៧.ស្ថានភាពគ្រួសារ</h5>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;margin-bottom:10px;font-size:12px;">ក.ព័ត៌មានឪពុកម្តាយ</h5>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellspacing="3px" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal; " >
                    <tbody>
                    <tr style="border:none">
                        <td style="width:15%;font-weight:normal;">ឈ្មោះឪពុក</td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->FATHER_NAME_KH) ? $familyStatusId->FATHER_NAME_KH : "​ ") <> (isset($familyStatusIdApprove->FATHER_NAME_KH) ? $familyStatusIdApprove->FATHER_NAME_KH : "​ ") ? "class=border-red" : "​" }} style="width:22%;">{{isset($familyStatusId->FATHER_NAME_KH) ? $familyStatusId->FATHER_NAME_KH : ''}}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:15%;font-weight:normal;text-align:right; padding-right: 17px">ជាអក្សរឡាតាំង</td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->FATHER_NAME_EN) ? $familyStatusId->FATHER_NAME_EN : "​ ") <> (isset($familyStatusIdApprove->FATHER_NAME_EN) ? $familyStatusIdApprove->FATHER_NAME_EN : "​ ") ? "class=border-red" : "​" }} style="width:25%;">{{isset($familyStatusId->FATHER_NAME_EN) ? $familyStatusId->FATHER_NAME_EN : ''}}</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:102.5%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->FATHER_LIVE) ? $familyStatusId->FATHER_LIVE : "​ ") <> (isset($familyStatusIdApprove->FATHER_LIVE) ? $familyStatusIdApprove->FATHER_LIVE : "​ ") ? "class=border-red" : "​" }} style="width:18%;font-weight:normal; text-align:center">
                                        <?php
                                        $FATHER_LIVE = isset($familyStatusId->FATHER_LIVE) ? $familyStatusId->FATHER_LIVE:'';
                                        ?>
                                        <input type="checkbox" name="father_live" disabled value="" <?php echo ($FATHER_LIVE =='ស្លាប់' ? 'checked' : ''); ?> >ស្លាប់
                                        <input type="checkbox" name="father_live" disabled value="" <?php echo ($FATHER_LIVE =='រស់' ? 'checked' : ''); ?> >រស់
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:150px;">ថ្ងៃខែឆ្នាំកំណើត</td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->FATHER_DOB) ? $familyStatusId->FATHER_DOB : "​ ") <> (isset($familyStatusIdApprove->FATHER_DOB) ? $familyStatusIdApprove->FATHER_DOB : "​ ") ? "class=border-red" : "​" }} style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">{{isset($familyStatusId->FATHER_DOB) && $familyStatusId->FATHER_DOB != '0000-00-00' &&  $familyStatusId->FATHER_DOB != '' ? $tool->dateformate($familyStatusId->FATHER_DOB) : ''}}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:150px;text-align:right; padding-right: 17px">សញ្ជាតិ</td>
                        <td colspan="5">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100.5%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->FATHER_NATIONALITY_1) ? $familyStatusId->FATHER_NATIONALITY_1 : "​ ") <> (isset($familyStatusIdApprove->FATHER_NATIONALITY_1) ? $familyStatusIdApprove->FATHER_NATIONALITY_1 : "​ ") ? "class=border-red" : "​" }} style="width: 105px !important;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">1. {{isset($familyStatusId->FATHER_NATIONALITY_1) ? $familyStatusId->FATHER_NATIONALITY_1 : ''}}</td>
                                    <td {{ (isset($familyStatusId->FATHER_NATIONALITY_2) ? $familyStatusId->FATHER_NATIONALITY_2 : "​ ") <> (isset($familyStatusIdApprove->FATHER_NATIONALITY_2) ? $familyStatusIdApprove->FATHER_NATIONALITY_2 : "​ ") ? "class=border-red" : "​" }} style="width: 115px !important;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">2. {{isset($familyStatusId->FATHER_NATIONALITY_2) ? $familyStatusId->FATHER_NATIONALITY_2 : ''}}</td>
                                </tr>
                            </table>
                        </td>



                    </tr>
                    <tr>
                        <td style="width:150px;">ទីលំនៅបច្ចុប្បន្ន</td>
                        <td colspan="7">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100.3%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->FATHER_ADDRESS) ? $familyStatusId->FATHER_ADDRESS : "​ ") <> (isset($familyStatusIdApprove->FATHER_ADDRESS) ? $familyStatusIdApprove->FATHER_ADDRESS : "​ ") ? "class=border-red" : "​" }} style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">{{isset($familyStatusId->FATHER_ADDRESS) ? $familyStatusId->FATHER_ADDRESS : ''}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:150px;">មុខរបរ</td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->FATHER_JOB) ? $familyStatusId->FATHER_JOB : "​ ") <> (isset($familyStatusIdApprove->FATHER_JOB) ? $familyStatusIdApprove->FATHER_JOB : "​ ") ? "class=border-red" : "​" }} style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">
                                        {{isset($familyStatusId->FATHER_JOB) ? $familyStatusId->FATHER_JOB : ''}}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:150px;text-align:right;padding-right: 17px">ស្ថាប័ន/អង្គភាព</td>

                        <td {{ ((isset($familyStatusId->FATHER_UNIT) ? $familyStatusId->FATHER_UNIT : "​") <> (isset($familyStatusIdApprove->FATHER_UNIT) ? $familyStatusIdApprove->FATHER_UNIT : "​") ? "class=border-red" : "​") }}  colspan="5" style="border:1px solid #000000">
                            {{isset($familyStatusId->FATHER_UNIT) ? $familyStatusId->FATHER_UNIT : ' '}}</td>
                    </tr>
                    <tr style="border:none">
                        <td style="width:15%;font-weight:normal;">ឈ្មោះម្តាយ</td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->MOTHER_NAME_KH) ? $familyStatusId->MOTHER_NAME_KH : "​ ") <> (isset($familyStatusIdApprove->MOTHER_NAME_KH) ? $familyStatusIdApprove->MOTHER_NAME_KH : "​ ") ? "class=border-red" : "​" }} style="width:22%;">
                                        {{isset($familyStatusId->MOTHER_NAME_KH) ? $familyStatusId->MOTHER_NAME_KH : ''}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:15%;font-weight:normal;text-align:right;">ជាអក្សរឡាតាំង</td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->MOTHER_NAME_EN) ? $familyStatusId->MOTHER_NAME_EN : "​ ") <> (isset($familyStatusIdApprove->MOTHER_NAME_EN) ? $familyStatusIdApprove->MOTHER_NAME_EN : "​ ") ? "class=border-red" : "​" }} style="width:25%;">
                                        {{isset($familyStatusId->MOTHER_NAME_EN) ? $familyStatusId->MOTHER_NAME_EN : ''}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:102%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->MOTHER_LIVE) ? $familyStatusId->MOTHER_LIVE : "​ ") <> (isset($familyStatusIdApprove->MOTHER_LIVE) ? $familyStatusIdApprove->MOTHER_LIVE : "​ ") ? "class=border-red" : "​" }} style="width:18%;font-weight:normal; text-align:center">
                                        <?php
                                        $MOTHER_LIVE = isset($familyStatusId->MOTHER_LIVE) ? $familyStatusId->MOTHER_LIVE :'';
                                        ?>
                                        <input type="checkbox" name="mother_live" disabled value="" <?php echo ($MOTHER_LIVE =='ស្លាប់' ? 'checked' : ''); ?> >ស្លាប់
                                        <input type="checkbox" name="mother_live" disabled value="" <?php echo ($MOTHER_LIVE =='រស់' ? 'checked' : ''); ?> >រស់
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:150px;">ថ្ងៃខែឆ្នាំកំណើត</td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->MOTHER_DOB) ? $familyStatusId->MOTHER_DOB : "​ ") <> (isset($familyStatusIdApprove->MOTHER_DOB) ? $familyStatusIdApprove->MOTHER_DOB : "​ ") ? "class=border-red" : "​" }} style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">{{isset($familyStatusId->MOTHER_DOB) && $familyStatusId->MOTHER_DOB != '0000-00-00' && $familyStatusId->MOTHER_DOB != ''? $tool->dateformate($familyStatusId->MOTHER_DOB) : ''}}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:150px;text-align:right;">សញ្ជាតិ</td>
                        <td colspan="5" style=" border: 1px solid #000">
                            <label {{ (isset($familyStatusId->MOTHER_NATIONALITY_1) ? $familyStatusId->MOTHER_NATIONALITY_1 : "​ ") <> (isset($familyStatusIdApprove->MOTHER_NATIONALITY_1) ? $familyStatusIdApprove->MOTHER_NATIONALITY_1 : "​ ") ? "class=border-red" : "​" }} style="padding-left: 10px">1. {{isset($familyStatusId->MOTHER_NATIONALITY_1) ? $familyStatusId->MOTHER_NATIONALITY_1 : ''}}</label>
                            <label {{ (isset($familyStatusId->MOTHER_NATIONALITY_2) ? $familyStatusId->MOTHER_NATIONALITY_2 : "​ ") <> (isset($familyStatusIdApprove->MOTHER_NATIONALITY_2) ? $familyStatusIdApprove->MOTHER_NATIONALITY_2 : "​ ") ? "class=border-red" : "​" }} style="padding-left: 150px">2. {{isset($familyStatusId->MOTHER_NATIONALITY_2) ? $familyStatusId->MOTHER_NATIONALITY_2 : ''}}</label>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:150px;">ទីលំនៅបច្ចុប្បន្ន</td>
                        <td colspan="7">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->MOTHER_ADDRESS) ? $familyStatusId->MOTHER_ADDRESS : "​ ") <> (isset($familyStatusIdApprove->MOTHER_ADDRESS) ? $familyStatusIdApprove->MOTHER_ADDRESS : "​ ") ? "class=border-red" : "​" }} style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">
                                        {{isset($familyStatusId->MOTHER_ADDRESS) ? $familyStatusId->MOTHER_ADDRESS : ''}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:150px;">មុខរបរ</td>
                        <td style="width: 30%">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->MOTHER_JOB) ? $familyStatusId->MOTHER_JOB : "​ ") <> (isset($familyStatusIdApprove->MOTHER_JOB) ? $familyStatusIdApprove->MOTHER_JOB : "​ ") ? "class=border-red" : "​" }} style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">
                                        {{isset($familyStatusId->MOTHER_JOB) ? $familyStatusId->MOTHER_JOB : ''}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:150px;text-align:right;">ស្ថាប័ន/អង្គភាព</td>
                        <td {{ ((isset($familyStatusId->MOTHER_UNIT) ? $familyStatusId->MOTHER_UNIT : "​ ") <> (isset($familyStatusIdApprove->MOTHER_UNIT) ? $familyStatusIdApprove->MOTHER_UNIT : "​ ") ? "class=border-red" : "​") }} colspan="5" style="border:1px solid #000000">
                            {{isset($familyStatusId->MOTHER_UNIT) ? $familyStatusId->MOTHER_UNIT : ''}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div><!--break-->
            <div style="line-break: loose;page-break-before: always">
                <table>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:10px;font-size:12px;">ខ.ព័ត៌មានបងប្អូន</h5>
                        </td>
                    </tr>
                </table>
                <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;">
                    <tr>
                        <th style="font-weight:normal; width: 5%">ល.រ</th>
                        <th style="width:20%;font-weight:normal">គោត្តនាម និងនាម</th>
                        <th style="font-weight:normal;width:20%;">អក្សរឡាតាំង</th>
                        <th style="font-weight:normal;width:5%;">ភេទ</th>
                        <th style="font-weight:normal;width:25%;">ថ្ងៃខែឆ្នាំកំណើត</th>
                        <th style="font-weight:normal;width:25%;">មុខរបរអង្គភាព</th>
                    </tr>
                    <tbody>
                    @if(count($relativesInformationId) == 0)
                        <tr style="height: 30px">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    <?php $i = 1; ?>
                    @foreach($relativesInformationId as $key =>$value)
                        <tr style="height: 30px">
                            <td id="relativesInformationId_id{{ $key }}" style="text-align:center">{{$tool->dayFormat($i++)}}</td>
                            <td id="relativesInformationId_name_kh{{ $key }}">{{isset($value->RELATIVES_NAME_KH) ? $value->RELATIVES_NAME_KH : ''}}</td>
                            <td id="relativesInformationId_name_en{{ $key }}">{{isset($value->RELATIVES_NAME_EN) ? $value->RELATIVES_NAME_EN : ''}}</td>
                            <td id="relativesInformationId_gender{{ $key }}">{{isset($value->RELATIVES_NAME_GENDER) ? $value->RELATIVES_NAME_GENDER : ''}}</td>
                            <td id="relativesInformationId_dob{{ $key }}">{{isset($value->RELATIVES_NAME_DOB) && $value->RELATIVES_NAME_DOB !='0000-00-00' && $value->RELATIVES_NAME_DOB !="" ? $tool->dateformate($value->RELATIVES_NAME_DOB) : ''}}</td>
                            <td id="relativesInformationId_job{{ $key }}">{{isset($value->RELATIVES_NAME_JOB) ? $value->RELATIVES_NAME_JOB : ''}}</td>
                            @foreach($relativesInformationIdApprove as $key_approve => $valueApprove)
                                @if((isset($value->RELATIVES_NAME_KH) ? $value->RELATIVES_NAME_KH : '') <> (isset($valueApprove->RELATIVES_NAME_KH) ? $valueApprove->RELATIVES_NAME_KH : ''))
                                    <script>
                                        $(document).ready(function(){
                                            var element{{ $key }} = document.getElementById("relativesInformationId_id{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("relativesInformationId_name_kh{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("relativesInformationId_name_en{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("relativesInformationId_gender{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("relativesInformationId_dob{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("relativesInformationId_job{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                        });
                                    </script>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <table>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:10px;font-size:12px;">គ.ព័ត៌មានសហព័ទ្ធ</h5>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellspacing="5px" cellpadding="3px" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal; height: 35px" >
                    <tr style="border:none">
                        <td style="width:15%;font-weight:normal;">ឈ្មោះប្តីឬប្រពន្ធ</td>
                        <td style="width: 21.8%">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'; height: 30px;">
                                <tr>
                                    <td {{ (isset($familyStatusId->SPOUSE_NAME_KH) ? $familyStatusId->SPOUSE_NAME_KH : "​ ") <> (isset($familyStatusIdApprove->SPOUSE_NAME_KH) ? $familyStatusIdApprove->SPOUSE_NAME_KH : "​ ") ? "class=border-red" : "​" }} style="width:22%;">{{isset($familyStatusId->SPOUSE_NAME_KH) ? $familyStatusId->SPOUSE_NAME_KH : ''}}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:16%;font-weight:normal;text-align:right; padding-right: 7px">ជាអក្សរឡាតាំង</td>
                        <td style="width: 31.8%">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'; height: 30px">
                                <tr>
                                    <td {{ (isset($familyStatusId->SPOUSE_NAME_EN) ? $familyStatusId->SPOUSE_NAME_EN : "​ ") <> (isset($familyStatusIdApprove->SPOUSE_NAME_EN) ? $familyStatusIdApprove->SPOUSE_NAME_EN : "​ ") ? "class=border-red" : "​" }} style="width:25%;">{{isset($familyStatusId->SPOUSE_NAME_EN) ? $familyStatusId->SPOUSE_NAME_EN : ''}}</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:108.3%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->SPOUSE_LIVE) ? $familyStatusId->SPOUSE_LIVE : "​ ") <> (isset($familyStatusIdApprove->SPOUSE_LIVE) ? $familyStatusIdApprove->SPOUSE_LIVE : "​ ") ? "class=border-red" : "​" }} style="width:18%;font-weight:normal; text-align:center">
                                        <?php
                                        $SPOUSE_LIVE = isset($familyStatusId->SPOUSE_LIVE) ? $familyStatusId->SPOUSE_LIVE:'';
                                        ?>
                                        <input type="checkbox" name="SPOUSE_LIVE" disabled value="" <?php echo ($SPOUSE_LIVE =='ស្លាប់' ? 'checked' : ''); ?> >ស្លាប់
                                        <input type="checkbox" name="SPOUSE_LIVE" disabled value="" <?php echo ($SPOUSE_LIVE =='រស់' ? 'checked' : ''); ?> >រស់
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%;">ថ្ងៃខែឆ្នាំកំណើត</td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->SPOUSE_DOB) ? $familyStatusId->SPOUSE_DOB : "​ ") <> (isset($familyStatusIdApprove->SPOUSE_DOB) ? $familyStatusIdApprove->SPOUSE_DOB : "​ ") ? "class=border-red" : "​" }} style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">
                                        {{isset($familyStatusId->SPOUSE_DOB) && $familyStatusId->SPOUSE_DOB != '0000-00-00' && $familyStatusId->SPOUSE_DOB != ''? $tool->dateformate($familyStatusId->SPOUSE_DOB) : ''}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:150px;text-align:right; padding-right: 7px">សញ្ជាតិ</td>
                        <td colspan="5">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:101.5%;font-size:12px;line-height:2.3;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td>
                                        <label {{ (isset($familyStatusId->SPOUSE_NATIONALITY_1) ? $familyStatusId->SPOUSE_NATIONALITY_1 : "​ ") <> (isset($familyStatusIdApprove->SPOUSE_NATIONALITY_1) ? $familyStatusIdApprove->SPOUSE_NATIONALITY_1 : "​ ") ? "class=border-red" : "​" }} style="padding-left: 10px">
                                            1. {{isset($familyStatusId->SPOUSE_NATIONALITY_1) ? $familyStatusId->SPOUSE_NATIONALITY_1 : ''}}</label>
                                        <label {{ (isset($familyStatusId->SPOUSE_NATIONALITY_2) ? $familyStatusId->SPOUSE_NATIONALITY_2 : "​ ") <> (isset($familyStatusIdApprove->SPOUSE_NATIONALITY_2) ? $familyStatusIdApprove->SPOUSE_NATIONALITY_2 : "​ ") ? "class=border-red" : "​" }} style="padding-left: 150px">
                                            2. {{isset($familyStatusId->SPOUSE_NATIONALITY_2) ? $familyStatusId->SPOUSE_NATIONALITY_2 : ''}}</label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%;">ទីកន្លែងកំណើត</td>
                        <td colspan="7">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100.8%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ (isset($familyStatusId->SPOUSE_POB) ? $familyStatusId->SPOUSE_POB : "​ ") <> (isset($familyStatusIdApprove->SPOUSE_POB) ? $familyStatusIdApprove->SPOUSE_POB : "​ ") ? "class=border-red" : "​" }} style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">
                                        {{isset($familyStatusId->SPOUSE_POB) ? $familyStatusId->SPOUSE_POB : ''}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellspacing="5px" cellpadding="3px" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin-top:-5px;" >
                    <tr style="border:none">
                        <td style="width:15%;font-weight:normal;">មុខរបរ</td>
                        <td style="width: 32.8%">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:66%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td {{ ((isset($familyStatusId->SPOUSE_JOB) ? $familyStatusId->SPOUSE_JOB : "​ ") <> (isset($familyStatusIdApprove->SPOUSE_JOB) ? $familyStatusIdApprove->SPOUSE_JOB : "​ ") ? "class=border-red" : "​") }} style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">
                                        {{isset($familyStatusId->SPOUSE_JOB) ? $familyStatusId->SPOUSE_JOB : ''}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:4.8%;font-weight:normal;text-align:right;">អង្គភាព</td>
                        <td style="width: 30%">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'; height: 34px">
                                <tr>
                                    <td {{ ((isset($familyStatusId->SPOUSE_UNIT) ? $familyStatusId->SPOUSE_UNIT : "​ ") <> (isset($familyStatusIdApprove->SPOUSE_UNIT) ? $familyStatusIdApprove->SPOUSE_UNIT : "​ ") ? "class=border-red" : "​") }}>
                                        {{isset($familyStatusId->SPOUSE_UNIT) ? $familyStatusId->SPOUSE_UNIT : ''}}
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 17%; ">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;font-size:12px;line-height:2.3;font-family:'KHMERMEF1'; width: 107.5%">
                                <tr>
                                    <td {{ (isset($familyStatusId->SPOUSE_SPONSOR) ? $familyStatusId->SPOUSE_SPONSOR : "​ ") <> (isset($familyStatusIdApprove->SPOUSE_SPONSOR) ? $familyStatusIdApprove->SPOUSE_SPONSOR : "​ ") ? "class=border-red" : "​" }} style="width:30%;font-weight:normal;text-align:center;">
                                        ប្រាក់ឧបត្ថម្ភ :
                                        <?php
                                        $SPOUSE_SPONSOR = isset($familyStatusId->SPOUSE_SPONSOR) ? $familyStatusId->SPOUSE_SPONSOR:'';
                                        ?>
                                        <input type="checkbox" name="SPOUSE_SPONSOR" disabled value="" <?php echo ($SPOUSE_SPONSOR =='មាន' ? 'checked' : ''); ?> >មាន
                                        <input type="checkbox" name="SPOUSE_SPONSOR" disabled value="" <?php echo ($SPOUSE_SPONSOR =='គ្មាន' ? 'checked' : ''); ?> >គ្មាន
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:150px;">លេខទូរស័ព្ទ</td>
                        <td colspan=7>
                            <table width="101.3%" style="margin-left: -2px">
                                <tr>
                                    <td  style=" border: 1px solid #000; margin-left: -2px">
                                        @foreach($phoneNumber as $key =>$value)
                                            <label style="padding-right: 20px">{{isset($value) ? $value : ''}}</label>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:10px;font-size:12px;">ឃ.ព័ត៌មានកូន</h5>
                        </td>
                    </tr>
                </table>
                <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;">
                    <tr>
                        <th style="font-weight:normal">ល.រ</th>
                        <th style="width:20%;font-weight:normal">គោត្តនាម និងនាម</th>
                        <th style="font-weight:normal;width:20%">អក្សរឡាតាំង</th>
                        <th style="font-weight:normal;width:5%;">ភេទ</th>
                        <th style="font-weight:normal">ថ្ងៃខែឆ្នាំកំណើត</th>
                        <th style="font-weight:normal;width:20%;">មុខរបរ</th>
                        <th style="font-weight:normal">ប្រាក់ឧបត្ថម្ភ</th>
                    </tr>
                    <tbody>
                    @if(count($childrenId) == 0)
                        <tr style="height: 30px">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    <?php $i = 1; ?>
                    @foreach($childrenId as $key =>$value)
                        <tr style="height: 30px">
                            <td id="childrenId_id{{ $key }}" style="text-align:center">{{$tool->dayFormat($i++)}}</td>
                            <td id="childrenId_name_kh{{ $key }}">{{isset($value->CHILDRENS_NAME_KH) ? $value->CHILDRENS_NAME_KH : ''}}</td>
                            <td id="childrenId_name_en{{ $key }}">{{isset($value->CHILDRENS_NAME_EN) ? $value->CHILDRENS_NAME_EN : ''}}</td>
                            <td id="childrenId_gender{{ $key }}">{{isset($value->CHILDRENS_NAME_GENDER) ? $value->CHILDRENS_NAME_GENDER : ''}}</td>
                            <td id="childrenId_dob{{ $key }}">{{isset($value->CHILDRENS_NAME_DOB) && $value->CHILDRENS_NAME_DOB !='0000-00-00' && $value->CHILDRENS_NAME_DOB !=''? $tool->dateformate($value->CHILDRENS_NAME_DOB) : ''}}</td>
                            <td id="childrenId_job{{ $key }}">{{isset($value->CHILDRENS_NAME_JOB) ? $value->CHILDRENS_NAME_JOB : ''}}</td>
                            <td id="childrenId_sponsor{{ $key }}" style="text-align:center"><input type="radio" name="gender_{{$key}}" value="" <?php if(isset($value->CHILDRENS_NAME_SPONSOR) ? $value->CHILDRENS_NAME_SPONSOR : 'គ្មាន' == 'មាន' ){ echo 'checked'; } ?> >មាន<input type="radio" name="gender_{{$key}}" value="" <?php if(isset($value->CHILDRENS_NAME_SPONSOR) ? $value->CHILDRENS_NAME_SPONSOR : 'គ្មាន' == 'គ្មាន' ){ echo "checked"; } ?> >គ្មាន</td>
                            @foreach($childrenIdApprove as $key_approve => $valueApprove)
                                @if((isset($value->CHILDRENS_NAME_KH) ? $value->CHILDRENS_NAME_KH : '') <> (isset($valueApprove->CHILDRENS_NAME_KH) ? $valueApprove->CHILDRENS_NAME_KH : ''))
                                    <script>
                                        $(document).ready(function(){
                                            var element{{ $key }} = document.getElementById("childrenId_id{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("childrenId_name_kh{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("childrenId_name_en{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("childrenId_gender{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("childrenId_dob{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("childrenId_job{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                            var element{{ $key }} = document.getElementById("childrenId_sponsor{{ $key }}");
                                            element{{ $key }}.classList.add("border-red");
                                        });
                                    </script>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <table width="100%" cellpadding="5" cellspacing="5" style="margin-top:20px">
                    <tr>
                        <td style=";font-family:'KHMERMEF1';font-size:12px;">ខ្ញុំសូមធានាអះអាង និងទទួលខុសត្រូវចំពោះមុខច្បាប់ថា ព័ត៌មានដែលបានបំពេញខាងលើនេះ ពិតជាត្រឹមត្រូវប្រាកដមែន ។</td>
                        <td></td>
                    </tr>
                </table>
                <table width="100%" cellpadding="5" cellspacing="5">
                    <tr>
                        <td></td>
                        <td style="text-align:right;font-family:'KHMERMEF1';font-size:12px;width:40%;" colspan="8">ធ្វើនៅ..............ថ្ងៃទី.........ខែ.........ឆ្នាំ............
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;font-family:'KHMERMEF1';font-size:12px;width: 30%;">

                        </td>
                        <td style="text-align:right">
                            <strong style="font-family:'KHMERMEF1';font-size:12px;padding-right:60px">ហត្ថលេខាសាមីខ្លួន</strong>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="5" cellspacing="5" style="margin-top:-40px;">
                    <tr>
                        <td style="text-align:center;font-family:'KHMERMEF1';font-size:12px;font-family:'KHMERMEF1';font-size:12px;width:10%;">
                            បានឃើញ និងបញ្ជាក់ថា ព័ត៌មានរបស់<br />
                            លោក/លោកស្រី..........................................................<br/>
                            ពិតជាដូចការអះអាងរបស់សាមីខ្លួនប្រាកដមែន ។<br/>
                            ធ្វើនៅ............ថ្ងៃទី........ខែ........ឆ្នាំ.........<br/>
                            <strong>ប្រធានអង្គភាព</strong>
                        </td>
                        <td style="text-align:center;font-family:'KHMERMEF1';font-size:12px;width:20%;">
                            <br/>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="5" cellspacing="5" style="margin-top:50px;">
                    <tr style="font-family:'KHMERMEF1';">
                        <td style="font-size:11px;">
                            បញ្ជាក់៖
                        </td>
                    </tr>
                    <tr style="font-family:'KHMERMEF1';font-size:9px;">
                        <td style="padding:0 0 0 10px;margin:0" >១.ភ្ជាប់មកជាមួយនូវច្បាប់ចម្លង(មានការបញ្ជាក់ពីអាជ្ញាធរមូលដ្ឋាន)</td>
                    </tr>
                    <tr style="font-family:'KHMERMEF1';font-size:9px;">
                        <td style="padding:0 0 0 10px;margin:0;">-សំបុត្រកំណើត ឬអត្តសញ្ញាណប័ណ្ណសញ្ញាតិខ្មែរ</td>
                    </tr>
                    <tr style="font-family:'KHMERMEF1';font-size:9px;">
                        <td style="padding:0 0 0 10px;margin:0;">-លិខិតបញ្ជាក់អាពាហ៏ពិពាហ៏ ឬប័ណ្ណគ្រួសារ</td>
                    </tr>
                    <tr style="font-family:'KHMERMEF1';font-size:9px;">
                        <td style="padding:0 0 0 10px;margin:0;">-លិខិតបញ្ជាក់ការសិក្សា</td>
                    </tr>
                    <tr style="font-family:'KHMERMEF1';font-size:9px;">
                        <td style="padding:0 0 0 10px;margin:0;">-លិខិតរដ្ឋបាលឯកត្តជនពាក់ព័ន្ធ</td>
                    </tr>
                    <tr style="font-family:'KHMERMEF1';font-size:9px;">
                        <td style="padding:0 0 0 10px;margin:0;">២.ករណីមានប្រែប្រួលព័ត៌មាន សាមីខ្លួនត្រូវជូនដំណឹងមកនាយកដ្ឋានបុគ្គលិកយ៉ាងយូរត្រឹម១ខែ</td>
                    </tr>
                    <tr style="font-family:'KHMERMEF1';font-size:9px;">
                        <td style="padding:0 0 0 10px;margin:0;">៣.ភ្ជាប់រូបថតថ្មីមិនលើសពី៦ខែ ទំហំ៤x៦ ផ្ទៃពណ៌ស ចំនួន២សន្លឹក(មន្ត្រីមានឯកសណ្ឋានផ្លូវការភ្ជាប់រូបថតគ្មានមួក)</td>
                    </tr>
                </table>
            </div><!--break-->
        </div>
    </div>
    @if($idApprove != null)
        <div>
            <h2 class="title">បោះពុម្ពប្រវត្តិរូប</h2>
            <div class="wrapper" style="max-width:960px;width:100%;margin:0 auto;">
                <table style="width:100%;margin-top:20px;">
                    <tr>
                        <td style="width:33.333333%;">
                        </td>
                        <td style="width:33.3333333333%;text-align:center;font-family:'KHMERMEF2';font-size:13px;">
                            {{trans('trans.king_of_cambodia')}}<br />{{trans('trans.national_religion_king')}}
                        </td>
                        <td style="width:33.33333333333%;position:relative;">
                            <table style="font-style:italic;font-family: 'KHMERMEF1';position:absolute;right:5px;top:10px;font-size:10px"><tr><td></td></tr></table>
                        </td>
                    </tr>
                </table>
                <table style="width:100%;position:relative;margin-top:-30px;">
                    <tr>
                        <td style="width:20%;">
                            <img src="{{asset('images/mef-logo.png')}}" width="43%" style="font-family:'KHMERMEF2';position:relative;left:35px;">
                            <table><tr><td style="font-family:'KHMERMEF2';font-size:13px" >{{trans('trans.institude_name_kh')}} <br/>{{trans('officer.working_place')}}:{{isset($serviceStatusCurrentIdApprove->CURRENT_GENERAL_DEPARTMENTED) ? $serviceStatusCurrentIdApprove->CURRENT_GENERAL_DEPARTMENTED : "​ "}}</td></tr></table>
                        </td>
                        <td style="width:50%;position:relative">
                            <table style="font-family:'KHMERMEF1';font-size:9px;text-align:center" >
                                <tr style="border:1px solid #000">
                                    <td style="width:92px;height:118px;position:absolute;right:15px;top:20px;padding-top:5px;">
                                        <?php
                                        $avatar = $rowApprove->AVATAR !="" ? '<img src="'.asset('/').$rowApprove->AVATAR.'" width="90px;">' : '<img src="'.asset('images/photo-default.jpg').'" width="90px;">';
                                        echo $avatar;
                                        ?>
                                    </td><br />
                                    <td style="position:absolute;right:-10px;top:165px;font-family:'automation';font-size:12px">
                                        <div id="barcode_approve">{!! $personalInfoApprove->ID !!}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="width:100%;">
                    <tr>
                        <table style="text-align:center;font-family:'KHMERMEF2';position:relative;top:-50px;font-size:13px;width:100%">
                            <tr><td>{{trans('officer.officer_hisotry')}}<br />{{trans('trans.institude_name_kh')}}</td></tr>
                        </table>
                    </tr>
                </table>
                <table style="width:100%;margin: 15px 0 0 0;">
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-bottom:10px;font-size:12px;">១-{{trans('personal_info.persional_info')}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:'KHMERMEF1';width:19.8%;font-size:12px">
                            {{trans('personal_info.official_id')}}
                        </td>
                        <td style="width: 33%">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'; width: 92%; margin-left: 27px">
                                <tr>
                                    <td style="font-size:12px;padding:0 5px;letter-spacing:2px;height:25px;min-width: 288px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1';">{{isset($rowApprove->PERSONAL_INFORMATION) ? $rowApprove->PERSONAL_INFORMATION : "​ "}}</td>
                                </tr>
                            </table>
                        </td>

                        <td style="font-family:'KHMERMEF1';width:22.8%;font-size:12px;text-align:right; padding-right: 14px">
                            {{trans('personal_info.official_id_card_of_mef')}}
                        </td>
                        <td>
                            <table  style="display:inline-block; border: 1px solid #000;vertical-align:middle;font-size:12px;line-height:1.8;padding-left:2px;font-family:'KHMERMEF1'; width: 220%">
                                <tr>
                                    <td style="padding:0 5px;letter-spacing:2px;height:25px;min-width:50px;">{{isset($rowApprove->OFFICIAL_ID) ? $rowApprove->OFFICIAL_ID : "​ "}}</td></tr></table></td>
                        <td style="font-family:'KHMERMEF1';width:35%;font-size:12px;text-align:right;">
                            {{trans('personal_info.unit_id')}}
                        </td>
                        <td><table style="display:inline-block; border: 1px solid #000;vertical-align:middle;font-size:12px;line-height:1.8;padding-left:2px;font-family:'KHMERMEF1';"><tr><td style="padding:0 5px;letter-spacing:2px;height:25px;min-width:50px;">{{ isset($rowApprove->UNIT_CODE) ? $rowApprove->UNIT_CODE : "​ "}}</td></tr></table></td>
                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;">
                            {{trans('officer.full_name')}}
                        </td>
                        <td style="width:35%;">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:90.8%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="font-size:12px;padding:0 5px;letter-spacing:2px;height:25px;min-width: 288px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1';">{{isset($rowApprove->FULL_NAME_KH) ? $rowApprove->FULL_NAME_KH : "​ "}}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right;padding-right:5px;">
                            {{trans('officer.english_name')}}
                        </td>
                        <td style="width:35%;">
                            <table style="display:inline-block;border: 1px solid #000;vertical-align:middle;width:97%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1';float: right;">
                                <tr>
                                    <td style="font-size:12px;padding:0 5px;letter-spacing:2px;height:25px;min-width: 282px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1';">{{ isset($rowApprove->FULL_NAME_EN) ? $rowApprove->FULL_NAME_EN : "​ "}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:'KHMERMEF1';width:18%;vertical-align:middle;">
                            <table style="display:inline-block;font-size:12px;border-collapse:collapse;margin-top:-12px;" cellpadding="0" cellspacing="0">
                                <tr>
                                    <?php
                                    $gender = isset($rowApprove->GENDER) ? $rowApprove->GENDER:'';
                                    ?>
                                    <td>{{trans('personal_info.gender')}}</td>
                                    <td style="display:inline-block;vertical-align:middle;vertical-align:middle;font-size:11px;" ><input type="checkbox" name="gender" disabled style="vertical-align:middle;" <?php echo ($gender =='ប្រុស' ? 'checked' :''); ?> >{{trans('personal_info.man')}}</td>
                                    <td style="display:inline-block;font-size:11px;"><input type="checkbox" name="gender" disabled style="vertical-align:middle;" <?php echo ($gender  =='ស្រី' ? 'checked' :''); ?> >{{trans('personal_info.woman')}}</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <?php
                            $DOB = isset($rowApprove->DATE_OF_BIRTH) ? $rowApprove->DATE_OF_BIRTH:'';
                            ?>
                            <table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';vertical-align:middle;"><tr><td>{{trans('personal_info.date_of_birth')}}</td></tr></table>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:66%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'"><tr><td style="font-size:12px;padding:0 5px;letter-spacing:2px;height:25px;min-width: 206px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1';">{{$DOB !=null && $DOB !='0000-00-00' && $DOB != '' ? $tool->dateformate($DOB) : "​ "}}</td>
                                </tr></table>
                        </td>
                        <td style="font-size:12px;font-family:'KHMERMEF1';">
                            <?php
                            $MARRIED = isset($rowApprove->MARRIED) ? $rowApprove->MARRIED:'';
                            ?>
                            <table style="display:inline-block;vertical-align:middle;text-align:right;width:190%;">
                                <tr>
                                    <td style="font-size:12px;right:-15%;line-height:1.5;position:relative;left:-20px; padding-right:47px">
                                        <input type="checkbox" style="vertical-align:middle;float:left;" disabled value="" <?php echo ($MARRIED<> 1 ? 'checked': '') ?> >{{trans('personal_info.singal')}}
                                    </td>
                                    <td>{{trans('personal_info.nationaley')}}</td></tr></table>
                        </td>
                        <td style="width:35%;font-family:'KHMERMEF1'">
                            <table style="display:inline-block;border: 1px solid #000;vertical-align:middle;width:97%;font-size:12px;line-height:1.8;padding-left:5px;float: right;"><tr>
                                    <?php
                                    $NATIONALITY_1 = isset($rowApprove->NATIONALITY_1) ? $rowApprove->NATIONALITY_1:'';
                                    $NATIONALITY_2 = isset($rowApprove->NATIONALITY_2) ? $rowApprove->NATIONALITY_2:'';
                                    ?>
                                    <td style="font-size:12px;padding:0 5px;letter-spacing:2px;height:25px;min-width: 136px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1'; margin-right: 5px;">1. {{$NATIONALITY_1 !=null ? $NATIONALITY_1 : "​ "}}</td>
                                    <td style="font-size:12px;padding:0 5px;letter-spacing:2px;height:25px;min-width: 140px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1';">2. {{$NATIONALITY_2 !=null ? $NATIONALITY_2 : "​ "}}</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <?php
                        $POB = isset($rowApprove->PLACE_OF_BIRTH) ? $rowApprove->PLACE_OF_BIRTH:'';
                        ?>
                        <td style="width:18%;font-size:12px;font-family:'KHMERMEF1';">
                            {{trans('personal_info.place_of_birth')}}
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:1%;margin-left:10px;vertical-align:middle;font-size:12px;box-sizing:border-box;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{$POB != null ? $POB : "​​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table  style="width:100%">
                    <tr>
                        <td style="width:18%;font-size:12px;font-family:'KHMERMEF1';">
                            {{trans('officer.address')}}
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:1%;margin-left:10px;vertical-align:middle;font-size:12px;box-sizing:border-box;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                        ​ផ្ទះលេខ {{isset($currentAddressApprove->house) ? $currentAddressApprove->house : "​"}}
                                        ​ផ្លូវលេខ {{isset($currentAddressApprove->street) ? $currentAddressApprove->street : "​"}}
                                        ​{{isset($currentAddressApprove->villages) ? $currentAddressApprove->villages : "​"}}
                                        {{isset($currentAddressApprove->commune) ? $currentAddressApprove->commune : ""}}
                                        {{isset($currentAddressApprove->districts) ? $currentAddressApprove->districts : "​"}}
                                        {{isset($currentAddressApprove->province) ? $currentAddressApprove->province : ""}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td style="width:45.3%">
                            <table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';vertical-align:middle;width:29%;margin-left:-2px;"><tr><td>{{trans('officer.email')}}</td></tr></table>
                            <table style="float:right;display:inline-block;border: 1px solid #000; vertical-align:middle;width:63.2%;font-size:12px;box-sizing:border-box;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'"><tr><td style="width:1%;margin-left:10px;vertical-align:middle;font-size:12px;box-sizing:border-box;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">{{ isset($rowApprove->EMAIL) ? $rowApprove->EMAIL : "​ "}}</td></tr></table>
                        </td>
                        <td style="width:46%;text-align: right;">
                            <table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';vertical-align:middle;"><tr><td>{{trans('officer.phone_number')}}</td></tr></table>
                            <table style="display:inline-block;border: 1px solid #000; vertical-align:middle;width:82%;font-size:12px;box-sizing:border-box;padding-left:5px;">
                                <tr>
                                    <td style="line-height:1.8;width:8%;text-align:left;">
                                        1. {{ isset($rowApprove->PHONE_NUMBER_1) ? $rowApprove->PHONE_NUMBER_1 : "​ " }}
                                    </td>
                                    <td style="padding-left:3%;width:8%;text-align:left;">
                                        2. {{ isset($rowApprove->PHONE_NUMBER_2) ? $rowApprove->PHONE_NUMBER_2 : " " }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="width:100%;margin-top:-2px;">
                    <tr>
                        <td style="font-family:'KHMERMEF1';width:18%;vertical-align:middle;font-size:12px;vertical-align:middle;">{{trans('personal_info.identity_card')}}
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:140.3%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:21%;font-size:12px;padding-left:5px;font-family:'KHMERMEF1'">{{ isset($rowApprove->NATION_ID) ? $rowApprove->NATION_ID : "​ "}}</td>
                                </tr>
                            </table>
                        </td>

                        <td style="font-family:'KHMERMEF1';width:28%;vertical-align:middle;font-size:12px;text-align:right;padding-right:16px;">
                            {{trans('personal_info.deadline')}}
                        </td>
                        <?php
                        $NATION_ID_EXPIRED_DATE = isset($rowApprove->NATION_ID_EXPIRED_DATE) ? $rowApprove->NATION_ID_EXPIRED_DATE: '';
                        ?>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="font-size:12px;line-height:2;padding-left:5px;text-align:center;font-family:'KHMERMEF1'; width: 21%">{{$NATION_ID_EXPIRED_DATE !=null && $NATION_ID_EXPIRED_DATE !='0000-00-00' && $NATION_ID_EXPIRED_DATE !='' ? $tool->dateformate($NATION_ID_EXPIRED_DATE) : "​ "}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="width:100%;margin-top:1px;">
                    <tr>
                        <td style="font-family:'KHMERMEF1';width:18%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                            {{trans('personal_info.passport')}}
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:133.4%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:21%;font-size:12px;line-height:2;padding-left:2px;padding-left:5px;font-family:'KHMERMEF1'">{{ isset($rowApprove->PASSPORT_ID) ? $rowApprove->PASSPORT_ID : "​ "}}</td>
                                </tr>
                            </table>
                        </td>

                        <td style="font-family:'KHMERMEF1';width:27%;vertical-align:middle;font-size:12px;text-align:right;padding-right:16px;">
                            {{trans('personal_info.deadline')}}
                        </td>
                        <?php
                        $PASSPORT_ID_EXPIRED_DATE = isset($rowApprove->PASSPORT_ID_EXPIRED_DATE) ? $rowApprove->PASSPORT_ID_EXPIRED_DATE:'';
                        ?>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:21%;font-size:12px;line-height:2;padding-left:2px;padding-left:5px;text-align:center;font-family:'KHMERMEF1'">{{$PASSPORT_ID_EXPIRED_DATE !=null && $PASSPORT_ID_EXPIRED_DATE != '0000-00-00' && $PASSPORT_ID_EXPIRED_DATE !='' ? $tool->dateformate($PASSPORT_ID_EXPIRED_DATE) : "​ "}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-bottom:0;font-size:12px;">២-{{trans('officer.work_situation')}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;margin-bottom:0;font-size:12px;">ក.ចូលបម្រើការងាររដ្ឋដំបូង</h5>
                        </td>
                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td style="font-family:'KHMERMEF1';width:25%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                            កាលបរិច្ឆេទប្រកាសចូលបម្រើការងាររដ្ឋដំបូង
                        </td>
                        <td style="width: 32%">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:78%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:22%;font-size:12px;line-height:2;padding-left:5px;text-align:left;font-family:'KHMERMEF1'">{{isset($serviceStatusInfoIdApprove->FIRST_START_WORKING_DATE_FOR_GOV) && $serviceStatusInfoIdApprove->FIRST_START_WORKING_DATE_FOR_GOV != '0000-00-00' && $serviceStatusInfoIdApprove->FIRST_START_WORKING_DATE_FOR_GOV !='' ? $tool->dateformate($serviceStatusInfoIdApprove->FIRST_START_WORKING_DATE_FOR_GOV)  : "​ "}}</td>
                                </tr>
                            </table>
                        </td>

                        <td style="font-family:'KHMERMEF1';width:11.9%;vertical-align:middle;font-size:12px;text-align:right;padding-right:17px;">
                            កាលបរិច្ឆេទតាំងស៊ប់
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:33%;font-size:12px;line-height:2;padding-left:5px;text-align:center;font-family:'KHMERMEF1'">{{isset($serviceStatusInfoIdApprove->FIRST_GET_OFFICER_DATE) && $serviceStatusInfoIdApprove->FIRST_GET_OFFICER_DATE != '0000-00-00' && $serviceStatusInfoIdApprove->FIRST_GET_OFFICER_DATE != ''? $tool->dateformate($serviceStatusInfoIdApprove->FIRST_GET_OFFICER_DATE) : "​ "}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td style="font-family:'KHMERMEF1';width:25%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                            ក្របខ័ណ្ឌឋានន្តរស័ក្តិ និងថ្នាក់
                        </td>
                        <td style="width: 22.5%">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:111.5%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:23%;font-size:12px;line-height:2;padding-left:5px;padding:0 5px;letter-spacing:2px;font-family:'KHMERMEF1'">{{isset($serviceStatusInfoIdApprove->className) ? $serviceStatusInfoIdApprove->className : "​ "}}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="font-family:'KHMERMEF1';width:21.6%;vertical-align:middle;font-size:12px;text-align:right;padding-right:17px;">
                            មុខតំណែង
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td  style="width:28%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusInfoIdApprove->positionName) ? $serviceStatusInfoIdApprove->positionName : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td style="font-family:'KHMERMEF1';width:25%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                            ក្រសួង/ស្ថាប័ន
                        </td>
                        <td style="width: 27.2%;">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:91%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:27%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusInfoIdApprove->ministryName) ? $serviceStatusInfoIdApprove->ministryName : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="font-family:'KHMERMEF1';vertical-align:middle;font-size:12px;text-align:right;padding-right:17px; width: 16.9%;">
                            អង្គភាព
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td  style="width:28%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusInfoIdApprove->secretariteName) ? $serviceStatusInfoIdApprove->secretariteName : "​ "}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td style="font-family:'KHMERMEF1';width:25%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                            នាយកដ្ឋាន/អង្គភាព/មន្ទីរ
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;min-width: 87%;width:87%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:27%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusInfoIdApprove->departmentName) ? $serviceStatusInfoIdApprove->departmentName : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="font-family:'KHMERMEF1';width:15.7%;vertical-align:middle;font-size:12px;text-align:right;padding-right:17px;">
                            ការិយាល័យ
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:35%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusInfoIdApprove->OfficeName) ? $serviceStatusInfoIdApprove->OfficeName : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td>
                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;margin-bottom:0;font-size:12px;">ខ.ស្ថានភាពការងារបច្ចុប្បន្ន</h5>
                        </td>
                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td style="font-family:'KHMERMEF1';width:16%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                            ក្របខ័ណ្ឌ ឋានន្តរស័ក្តិ និងថ្នាក់
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:8.5%;font-size:12px;line-height:2;padding-left:5px;letter-spacing:2px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusCurrentIdApprove->CURRENT_OFFICER_CLASSED) ? $serviceStatusCurrentIdApprove->CURRENT_OFFICER_CLASSED : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="font-family:'KHMERMEF1';width:35%;vertical-align:middle;font-size:12px;text-align:right;padding-right:17px;">
                            កាលបរិច្ឆេទប្តូរក្របខ័ណ្ឌ ឋានន្តរស័ក្តិ និងថ្នាក់  ចុងក្រោយ
                        </td>
                        <td style="width: 30.8%">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:12%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'; text-align: center">
                                        {{isset($serviceStatusCurrentIdApprove->CURRETN_PROMOTE_OFFICER_DATE) && $serviceStatusCurrentIdApprove->CURRETN_PROMOTE_OFFICER_DATE != '0000-00-00' && $serviceStatusCurrentIdApprove->CURRETN_PROMOTE_OFFICER_DATE != '' ? $tool->dateformate($serviceStatusCurrentIdApprove->CURRETN_PROMOTE_OFFICER_DATE) : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td style="font-family:'KHMERMEF1';width:16%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                            មុខតំណែង
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:162%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:17%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusCurrentIdApprove->CURRENT_POSITIONED) ? $serviceStatusCurrentIdApprove->CURRENT_POSITIONED : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="font-family:'KHMERMEF1';width:41.8%;vertical-align:middle;font-size:12px;text-align:right;padding-right:17px;">
                            កាលបរិច្ឆេទទទួលមុខតំណែងចុងក្រោយ
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:15%;font-size:12px;line-height:2;padding-left:5px;font-family:'KHMERMEF1'; text-align:center;">
                                        {{isset($serviceStatusCurrentIdApprove->CURRENT_GET_OFFICER_DATE) && $serviceStatusCurrentIdApprove->CURRENT_GET_OFFICER_DATE != '0000-00-00' && $serviceStatusCurrentIdApprove->CURRENT_GET_OFFICER_DATE != '' ? $tool->dateformate($serviceStatusCurrentIdApprove->CURRENT_GET_OFFICER_DATE) : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td style="width:30%;font-size:12px;font-family:'KHMERMEF1';">
                            អគ្គលេខាធិការដ្ឋាន/អគ្គនាយកដ្ឋាន/អគ្គាធិការដ្ឋាន/វិទ្យាស្ថាន
                        </td>
                        <td>
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:1%;margin-left:10px;vertical-align:middle;font-size:12px;box-sizing:border-box;line-height:1.8;padding:3px 0 3px 5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusCurrentIdApprove->CURRENT_GENERAL_DEPARTMENTED) && $serviceStatusCurrentIdApprove->CURRENT_GENERAL_DEPARTMENTED !="" ? $serviceStatusCurrentIdApprove->CURRENT_GENERAL_DEPARTMENTED : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td style="font-family:'KHMERMEF1';width:16%;vertical-align:middle;font-size:12px;">
                            នាយកដ្ឋាន/អង្គភាព/មន្ទីរ
                        </td>
                        <td style="width:38%">
                            <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td style="width:30%;margin-left:10px;vertical-align:middle;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">{{isset($serviceStatusCurrentIdApprove->CURRENT_DEPARTMENTED) ? $serviceStatusCurrentIdApprove->CURRENT_DEPARTMENTED : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="font-family:'KHMERMEF1';width:12%;vertical-align:middle;font-size:12px;text-align:right">
                            ការិយាល័យ
                        </td>
                        <td style="width:35%;">
                            <table style="display:inline-block;margin-left:10px; border: 1px solid #000;vertical-align:middle;width:97%;font-size:12px;line-height:1.8;padding-left:2px;font-family:'KHMERMEF1'">
                                <tr>
                                    <td >
                                        {{isset($serviceStatusCurrentIdApprove->CURRENT_OFFICED) ? $serviceStatusCurrentIdApprove->CURRENT_OFFICED : "​ "}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div style="line-break: loose;page-break-before: always">
                    <table style="width:100%">
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;margin-bottom:0;font-size:12px;">គ.តួនាទីបន្ថែមលើមុខងារបច្ចុប្បន្ន (ឋានៈស្មើ)</h5>
                            </td>
                        </tr>
                    </table>
                    <table style="width:100%">
                        <tr>
                            <td style="font-family:'KHMERMEF1';width:16%;font-size:12px">
                                កាលបរិច្ឆេទចូល
                            </td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="vertical-align:middle;width:20%;font-size:12px;line-height:2;font-family:'KHMERMEF1';padding-left:5px">
                                            {{isset($serviceStatusAdditioanlIdApprove->ADDITIONAL_WORKING_DATE_FOR_GOV) && $serviceStatusAdditioanlIdApprove->ADDITIONAL_WORKING_DATE_FOR_GOV !='0000-00-00' && $serviceStatusAdditioanlIdApprove->ADDITIONAL_WORKING_DATE_FOR_GOV !='' ? $tool->dateformate($serviceStatusAdditioanlIdApprove->ADDITIONAL_WORKING_DATE_FOR_GOV) : "​ "}}
                                        </td>
                                    </tr>
                                </table>
                            </td>

                            <td style="font-family:'KHMERMEF1';width:10%;font-size:12px;text-align:right;padding-right:10px;">
                                មុខតំណែង
                            </td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="vertical-align:middle;width:25%;font-size:12px;line-height:2;font-family:'KHMERMEF1';padding-left:5px">
                                            {{isset($serviceStatusAdditioanlIdApprove->additionalPosition) ? $serviceStatusAdditioanlIdApprove->additionalPosition : "​ "}}
                                        </td>
                                    </tr>
                                </table>
                            </td>

                            <td style="font-family:'KHMERMEF1';width:10%;font-size:12px;text-align:right;padding-right:10px;">
                                ឋានៈស្មើ
                            </td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="vertical-align:middle;width:20%;font-size:12px;line-height:2;font-family:'KHMERMEF1';padding-left:5px">
                                            {{isset($serviceStatusAdditioanlIdApprove->ADDITINAL_STATUS) ? $serviceStatusAdditioanlIdApprove->ADDITINAL_STATUS : "​ "}}
                                        </td>
                                    </tr>
                                </table>
                            </td>

                        </tr>

                    </table>
                    <table style="width:100%">
                        <tr>
                            <td style="width:16%;font-size:12px;font-family:'KHMERMEF1';">
                                អង្គភាព
                            </td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width:1%;margin-left:10px;vertical-align:middle;font-size:12px;box-sizing:border-box;line-height:2;padding-left:3px;font-family:'KHMERMEF1'">
                                            {{isset($serviceStatusAdditioanlIdApprove->ADDITINAL_UNIT) && $serviceStatusAdditioanlIdApprove->ADDITINAL_UNIT !="" ? $serviceStatusAdditioanlIdApprove->ADDITINAL_UNIT : "​ "}}
                                        </td>
                                    </tr>
                                </table>
                            </td>

                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:0;font-size:12px;line-break: loose;"> ឃ.ស្ថានភាពស្ថិតនៅក្រៅក្របខ័ណ្ឌដើម</h5>
                            </td>
                        </tr>
                    </table>
                    <table  width="100%" border="1px" cellpadding="0" cellspacing="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;">
                        <tr>
                            <th style="font-weight:normal">ល.រ</th>
                            <th style="font-weight:normal;width:60%;">ស្ថាប័ន/អង្គភាព</th>
                            <th style="font-weight:normal">កាលបរិច្ឆេទចាប់ផ្តើម</th>
                            <th style="font-weight:normal">កាលបរិច្ឆេទបញ្ចប់</th>
                        </tr>
                        <tbody>
                        @if(count($situationOutsideIdApprove) == 0)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        @foreach($situationOutsideIdApprove as $key => $value)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td id="situationOutsideId{{ $key }}" style="text-align:center">{{$tool->dayFormat($key+1)}}</td>
                                <td id="situationOutsideInstitution{{ $key }}">{{isset($value->INSTITUTION) ? $value->INSTITUTION : ''}}</td>
                                <td id="situationOutsideStart{{ $key }}">{{isset($value->START_DATE) && $value->START_DATE != '0000-00-00' && $value->START_DATE != '' ?  $tool->dateformate($value->START_DATE) : ''}}</td>
                                <td id="situationOutsideEnd{{ $key }}">{{isset($value->END_DATE) && $value->END_DATE != '0000-00-00' && $value->END_DATE != '' ? $tool->dateformate($value->END_DATE) : ''}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end table 1-->
                    <table>
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:0;font-size:12px;"> ង.ស្ថានភាពស្ថិតនៅតាមភាពទំនេរគ្មានបៀវត្ស</h5>
                            </td>
                        </tr>
                    </table>
                    <table  width="100%" border="1" cellpadding="0" cellspacing="5" style="font-family: 'KHMERMEF1';font-size:12px;border-collapse: collapse;text-align:center;">
                        <tr>
                            <th style="font-weight:normal">ល.រ</th>
                            <th style="font-weight:normal;width:60%;">ស្ថាប័ន/អង្គភាព</th>
                            <th style="font-weight:normal">កាលបរិច្ឆេទចាប់ផ្តើម</th>
                            <th style="font-weight:normal">កាលបរិច្ឆេទបញ្ចប់</th>
                        </tr>
                        <tbody>
                        @if(count($situationFreeIdApprove) == 0)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        @foreach($situationFreeIdApprove as $key => $value)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td id="situationFreeId{{ $key }}" style="text-align:center">{{$tool->dayFormat($key+1)}}</td>
                                <td id="situationFreeInstitution{{ $key }}">{{isset($value->INSTITUTION) ? $value->INSTITUTION : ''}}</td>
                                <td id="situationFreeStart{{ $key }}">{{isset($value->START_DATE) && $value->START_DATE != '0000-00-00' && $value->START_DATE != '' ?  $tool->dateformate($value->START_DATE) : ''}}</td>
                                <td id="situationFreeEnd{{ $key }}">{{isset($value->END_DATE) && $value->END_DATE != '0000-00-00' && $value->END_DATE != '' ? $tool->dateformate($value->END_DATE) : ''}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end of table 2-->
                    <table>
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;margin-bottom:2px;font-size:12px;">៣.ប្រវត្តិការងារ (សូមបំពេញតាមលំដាប់ ពីថ្មីទៅចាស់)</h5>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;margin-bottom:15px;font-size:12px;">ក.ក្នុងមុខងារសាធារណៈ</h5>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" border="1" cellpadding="0" cellspacing="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;">
                        <tr>
                            <th colspan="2" style="font-weight:normal;width:20%;">ថ្ងៃ ខែ ឆ្នាំ បំពេញការងារ</th>
                            <th rowspan="2" style="font-weight:normal;width:18%;">ក្រសួង-ស្ថាប័ន</th>
                            <th rowspan="2" style="font-weight:normal;width:18%;">អង្គភាព</th>
                            <th rowspan="2" style="font-weight:normal;width:18%;">មុខតំណែង</th>
                            <th rowspan="2" style="font-weight:normal;width:18%;">ឋានៈស្មើ</th>
                        </tr>
                        <tr>
                            <th style="font-weight:normal;font-weight:normal;width:14%;">ចូល</th>
                            <th style="font-weight:normal;font-weight:normal;width:14%;">បញ្ចប់</th>
                        </tr>
                        <tbody>
                        @if(count($workingHistoryIdApprove)==0)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        @foreach($workingHistoryIdApprove as $key => $value)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td id="workingHistoryStart{{ $key }}" style="height: 30px">{{isset($value->START_WORKING_DATE) && $value->START_WORKING_DATE !='0000-00-00' && $value->START_WORKING_DATE != '' ? $tool->dateformate($value->START_WORKING_DATE) : ''}}</td>
                                <td id="workingHistoryEnd{{ $key }}"><?php if(isset($value->END_WORKING_DATE) && $value->END_WORKING_DATE != '' && $value->END_WORKING_DATE != '0000-00-00'){ echo $tool->dateformate($value->END_WORKING_DATE); }elseif ($value->END_WORKING_DATE =='0000-00-00'){ echo "បច្ចុប្បន្ន"; }else{ echo ""; }?></td>
                                <td id="workingHistoryDepartment{{ $key }}">{{isset($value->DEPARTMENT) ? $value->DEPARTMENT : ''}}</td>
                                <td id="workingHistoryInstitution{{ $key }}">{{isset($value->INSTITUTION) ? $value->INSTITUTION : ''}}</td>
                                <td id="workingHistoryPosition{{ $key }}">{{isset($value->POSITION) ? $value->POSITION : ''}}</td>
                                <td id="workingHistoryPositionEqual{{ $key }}">{{isset($value->POSITION_EQUAL_TO) ? $value->POSITION_EQUAL_TO : ''}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end of table 3-->
                    <table>
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:15pxa;font-size:12px;">ខ.ក្នុងវិស័យឯកជន</h5>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" border="1" cellpadding="0" cellspacing="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;">
                        <tr>
                            <th colspan="2" style="font-weight:normal;width:20%;">ថ្ងៃ ខែ ឆ្នាំ បំពេញការងារ</th>
                            <th rowspan="2" style="font-weight:normal;width:26%;">គ្រឹះស្ថាន-អង្គភាព</th>
                            <th rowspan="2" style="font-weight:normal;width:22%;">តួនាទី</th>
                            <th rowspan="2" style="font-weight:normal;width:18%;">ជំនាញ/បច្ចេកទេស</th>
                        </tr>
                        <tr>
                            <th style="font-weight:normal;font-weight:normal;width:14%;">ចូល</th>
                            <th style="font-weight:normal;font-weight:normal;width:14%;">បញ្ចប់</th>
                        </tr>
                        <tbody>
                        @if(count($workingHistoryPrivateIdApprove) == 0)
                            <tr style="height: 30px; font-family:'KHMERMEF1';">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        @foreach($workingHistoryPrivateIdApprove as $key => $value)
                            <tr style="height: 30px; font-family:'KHMERMEF1';text-align:center">
                                <td id="workingHistoryPrivateStart{{ $key }}" style="height:25px;">{{isset($value->PRIVATE_START_DATE) && $value->PRIVATE_START_DATE !='' && $value->PRIVATE_START_DATE != '0000-00-00' ? $tool->dateformate($value->PRIVATE_START_DATE) : ''}}</td>
                                <td id="workingHistoryPrivateEnd{{ $key }}">{{isset($value->PRIVATE_END_DATE) && $value->PRIVATE_END_DATE !='0000-00-00' && $value->PRIVATE_END_DATE != '' ? $tool->dateformate($value->PRIVATE_END_DATE) : ''}}</td>
                                <td id="workingHistoryPrivateDepartment{{ $key }}">{{isset($value->PRIVATE_DEPARTMENT) ? $value->PRIVATE_DEPARTMENT : ''}}</td>
                                <td id="workingHistoryPrivateRole{{ $key }}">{{isset($value->PRIVATE_ROLE) ? $value->PRIVATE_ROLE : ''}}</td>
                                <td id="workingHistoryPrivateSkill{{ $key }}">{{isset($value->PRIVATE_SKILL) ? $value->PRIVATE_SKILL : ''}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end of table 4-->
                    <table>
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;margin-bottom:15px;font-size:12px;">៤.គ្រឿងឥស្សរិយយស ប័ណ្ណសរសើរ ឬទណ្ឌកម្មវិន័យ</h5>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;">
                        <tr>
                            <th style="font-weight:normal;font-weight:normal">លេខឯកសារ</th>
                            <th style="font-weight:norma;font-weight:normal">កាលបរិច្ឆេទ</th>
                            <th style="font-weight:normal;font-weight:normal">ស្ថាប័ន/អង្គភាព (ស្នើរសុំ)</th>
                            <th style="font-weight:normal;font-weight:normal">ខ្លឹមសារ</th>
                            <th style="font-weight:normal;font-weight:normal">ប្រភេទ</th>
                        </tr>
                        <tbody>
                        <tr>
                            <td colspan="5" style="padding-left:5px;text-align:left;">គ្រឿងឥស្សរិយយស</td>

                        </tr>
                        @if(count($AppreciationAwardsIdApprove) == 0)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        @foreach($AppreciationAwardsIdApprove as $key => $value)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td id="AppreciationAwardsNum{{ $key }}" style="height:25px;">{{isset($value->AWARD_NUMBER) ? $value->AWARD_NUMBER : ''}}</td>
                                <td id="AppreciationAwardsDate{{ $key }}">{{isset($value->AWARD_DATE) && $value->AWARD_DATE != '0000-00-00' && $value->AWARD_DATE != '' ? $tool->dateformate($value->AWARD_DATE) : ''}}</td>
                                <td id="AppreciationAwardsDepartment{{ $key }}">{{isset($value->DEPARTMENT) ? $value->DEPARTMENT : ''}}</td>
                                <td id="AppreciationAwardsDescription{{ $key }}">{{isset($value->AWARD_DESCRIPTION) ? $value->AWARD_DESCRIPTION : ''}}</td>
                                <td id="AppreciationAwardsDind{{ $key }}">{{isset($value->AWARD_KIND) ? $value->AWARD_KIND : ''}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" style="padding-left:5px;text-align:left;">ទណ្ឌកម្មវិន័យ</td>
                        </tr>
                        @if(count($appreciationSanctionIdApprove) == 0)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        @foreach($appreciationSanctionIdApprove as $key => $value)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td id="appreciationSanction_num{{ $key }}" style="height:25px;">{{isset($value->AWARD_NUMBER) ? $value->AWARD_NUMBER : ''}}</td>
                                <td id="appreciationSanction_date{{ $key }}">{{isset($value->AWARD_DATE) && $value->AWARD_DATE != '0000-00-00' && $value->AWARD_DATE != '' ? $tool->dateformate($value->AWARD_DATE) : ''}}</td>
                                <td id="appreciationSanction_Department{{ $key }}">{{isset($value->DEPARTMENT) ? $value->DEPARTMENT : ''}}</td>
                                <td id="appreciationSanctionDescription{{ $key }}">{{isset($value->AWARD_DESCRIPTION) ? $value->AWARD_DESCRIPTION : ''}}</td>
                                <td id="appreciationSanctionDind{{ $key }}">{{isset($value->AWARD_KIND) ? $value->AWARD_KIND : ''}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!--break-->
                <div style="line-break: loose;page-break-before: always">
                    <table>
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;margin-bottom:15px;font-size:12px;">៥.កំរិតវប្បធម៌ទូទៅ ការបណ្តុះបណ្តាលបន្ត</h5>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;">
                        <tr>
                            <th rowspan="2" style="font-weight:normal">វគ្គ ឬ កម្រិតសិក្សា</th>
                            <th rowspan="2" style="font-weight:normal;width:34%;">គ្រឹះស្ថាន និងទីកន្លែង (ប្រទេស)</th>
                            <th rowspan="2" style="font-weight:normal">សញ្ញាបត្រទទួលបាន (ជំនាញឯកទេស)</th>
                            <th colspan="2" style="font-weight:normal;width:30%;">ថ្ងៃ ខែ ឆ្នាំ សិក្សា</th>
                        </tr>
                        <tr>
                            <th style="font-weight:normal;width:14%;">ចូល</th>
                            <th style="font-weight:normal;width:14%;">បញ្ចប់</th>
                        </tr>
                        <tbody>
                        <tr>
                            <td colspan="5" style="padding-left:5px;text-align:left;">កំរិតវប្បធម៌ទូទៅ</td>
                        </tr>
                        <tr style="height:25px;">
                            <td>{{isset($generalQualificationsIdApprove->LEAVED) ? $generalQualificationsIdApprove->LEAVED : '' }}</td>
                            <td>{{isset($generalQualificationsIdApprove->PLACE) ? $generalQualificationsIdApprove->PLACE : ''}}</td>
                            <td>{{isset($generalQualificationsIdApprove->GRADUATION_MAJORED) ? $generalQualificationsIdApprove->GRADUATION_MAJORED : ''}}</td>
                            <td>{{isset($generalQualificationsIdApprove->Q_START_DATE) && $generalQualificationsIdApprove->Q_START_DATE != '0000-00-00' && $generalQualificationsIdApprove->Q_START_DATE != '' ? $tool->dateformate($generalQualificationsIdApprove->Q_START_DATE) : ''}}</td>
                            <td>{{isset($generalQualificationsIdApprove->Q_END_DATE) && $generalQualificationsIdApprove->Q_END_DATE != '0000-00-00' && $generalQualificationsIdApprove->Q_END_DATE != '' ? $tool->dateformate($generalQualificationsIdApprove->Q_END_DATE) : ''}}</td>
                        </tr>
                        <tr>
                            <td colspan="5" style="padding-left:5px;text-align:left;">កំរិតសញ្ញាបត្រ/ជំនាញឯកទេស</td>
                        </tr>
                        @if(count($generalQualificationsSkillIdApprove) == 0)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif

                        @foreach($generalQualificationsSkillIdApprove as $key =>$value)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td id="generalQualificationsSkill_leaved{{ $key }}" style="height:25px;">{{isset($value->LEAVED) ? $value->LEAVED : ''}}</td>
                                <td id="generalQualificationsSkill_place{{ $key }}">{{isset($value->PLACE) ? $value->PLACE : ''}}</td>
                                <td id="generalQualificationsSkill_major{{ $key }}">{{isset($value->GRADUATION_MAJOR) ? $value->GRADUATION_MAJOR : ''}}</td>
                                <td id="generalQualificationsSkill_start{{ $key }}">{{isset($value->Q_START_DATE) && $value->Q_START_DATE != '0000-00-00' && $value->Q_START_DATE != '' ? $tool->dateformate($value->Q_START_DATE) : ''}}</td>
                                <td id="generalQualificationsSkill_end{{ $key }}">{{isset($value->Q_END_DATE) && $value->Q_END_DATE != '0000-00-00' && $value->Q_END_DATE != '' ? $tool->dateformate($value->Q_END_DATE) : ''}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" style="padding-left:5px;text-align:left;">វគ្គបណ្តុះបណ្តាលវិជ្ជាជីវៈ (ក្រោម១២ខែ)</td>
                        </tr>
                        @if(count($generalQualificationsTrainingIdApprove) == 0)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        @foreach($generalQualificationsTrainingIdApprove as $key =>$value)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td id="generalQualificationsTraining_leaved{{ $key }}" style="height:25px;">{{isset($value->LEAVED) ? $value->LEAVED : ''}}</td>
                                <td id="generalQualificationsTraining_place{{ $key }}">{{isset($value->PLACE) ? $value->PLACE : ''}}</td>
                                <td id="generalQualificationsTraining_major{{ $key }}">{{isset($value->GRADUATION_MAJOR) ? $value->GRADUATION_MAJOR : ''}}</td>
                                <td id="generalQualificationsTraining_start{{ $key }}">{{isset($value->Q_START_DATE) && $value->Q_START_DATE !='0000-00-00' && $value->Q_START_DATE != '' ? $tool->dateformate($value->Q_START_DATE) : ''}}</td>
                                <td id="generalQualificationsTraining_end{{ $key }}">{{isset($value->Q_END_DATE) && $value->Q_END_DATE !='0000-00-00' && $value->Q_END_DATE != '' ? $tool->dateformate($value->Q_END_DATE) : ''}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end table 5-->
                    <table>
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;margin-bottom:10px;font-size:12px;">៦.សមត្ថភាពភាសាបរទេស (មធ្យម, ល្អបង្គួរ, ល្អ និង ល្អណាស់)</h5>
                            </td>
                        </tr>
                    </table>

                    <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;">
                        <tr>
                            <th style="font-weight:normal;width:5%;">ល.រ</th>
                            <th style="width:350px;font-weight:normal">ភាសា</th>
                            <th style="font-weight:normal;width:12%;">អាន</th>
                            <th style="font-weight:normal;width:12%;">សរសេរ</th>
                            <th style="font-weight:normal;width:12%;">និយាយ</th>
                            <th style="font-weight:normal;width:12%;">ស្តាប់</th>
                        </tr>
                        <tbody>
                        @if(count($foreignLanguagesOfficerIdApprove) == 0)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        <?php $i = 1; ?>
                        @foreach($foreignLanguagesOfficerIdApprove as $key =>$value)
                            <tr style="height: 30px; font-family:'KHMERMEF1'">
                                <td id="foreignLanguagesOfficerId_id{{ $key }}" style="text-align:center">{{$tool->dayFormat($i++)}}</td>
                                <td id="foreignLanguagesOfficerId_language{{ $key }}">{{isset($value->LANGUAGES) ? $value->LANGUAGES : ''}}</td>
                                <td id="foreignLanguagesOfficerId_read{{ $key }}">{{isset($value->READED) ? $value->READED : ''}}</td>
                                <td id="foreignLanguagesOfficerId_write{{ $key }}">{{isset($value->WRITES) ? $value->WRITES : ''}}</td>
                                <td id="foreignLanguagesOfficerId_speak{{ $key }}">{{isset($value->SPEAKS) ? $value->SPEAKS : ''}}</td>
                                <td id="foreignLanguagesOfficerId_listening{{ $key }}">{{isset($value->LISTENTS) ? $value->LISTENTS : ''}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end table 5-->
                    <table>
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;margin-bottom:0;font-size:12px;">៧.ស្ថានភាពគ្រួសារ</h5>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;margin-bottom:10px;font-size:12px;">ក.ព័ត៌មានឪពុកម្តាយ</h5>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" cellspacing="3px" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal; " >
                        <tbody>
                        <tr style="border:none">
                            <td style="width:15%;font-weight:normal;">ឈ្មោះឪពុក</td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width:22%;">{{isset($familyStatusIdApprove->FATHER_NAME_KH) ? $familyStatusIdApprove->FATHER_NAME_KH : ''}}</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:15%;font-weight:normal;text-align:right; padding-right: 17px">ជាអក្សរឡាតាំង</td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width:25%;">{{isset($familyStatusIdApprove->FATHER_NAME_EN) ? $familyStatusIdApprove->FATHER_NAME_EN : ''}}</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:102.5%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width:18%;font-weight:normal; text-align:center">
                                            <?php
                                            $FATHER_LIVE = isset($familyStatusIdApprove->FATHER_LIVE) ? $familyStatusIdApprove->FATHER_LIVE:'';
                                            ?>
                                            <input type="checkbox" name="father_live" disabled value="" <?php echo ($FATHER_LIVE =='ស្លាប់' ? 'checked' : ''); ?> >ស្លាប់
                                            <input type="checkbox" name="father_live" disabled value="" <?php echo ($FATHER_LIVE =='រស់' ? 'checked' : ''); ?> >រស់
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:150px;">ថ្ងៃខែឆ្នាំកំណើត</td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">{{isset($familyStatusIdApprove->FATHER_DOB) && $familyStatusIdApprove->FATHER_DOB != '0000-00-00' &&  $familyStatusIdApprove->FATHER_DOB != '' ? $tool->dateformate($familyStatusIdApprove->FATHER_DOB) : ''}}</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:150px;text-align:right; padding-right: 17px">សញ្ជាតិ</td>
                            <td colspan="5">
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100.5%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td  style="width: 105px !important;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">1. {{isset($familyStatusIdApprove->FATHER_NATIONALITY_1) ? $familyStatusIdApprove->FATHER_NATIONALITY_1 : ''}}</td>
                                        <td style="width: 115px !important;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">2. {{isset($familyStatusIdApprove->FATHER_NATIONALITY_2) ? $familyStatusIdApprove->FATHER_NATIONALITY_2 : ''}}</td>
                                    </tr>
                                </table>
                            </td>



                        </tr>
                        <tr>
                            <td style="width:150px;">ទីលំនៅបច្ចុប្បន្ន</td>
                            <td colspan="7">
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100.3%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">{{isset($familyStatusIdApprove->FATHER_ADDRESS) ? $familyStatusIdApprove->FATHER_ADDRESS : ''}}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:150px;">មុខរបរ</td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">
                                            {{isset($familyStatusIdApprove->FATHER_JOB) ? $familyStatusIdApprove->FATHER_JOB : ''}}</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:150px;text-align:right;padding-right: 17px">ស្ថាប័ន/អង្គភាព</td>

                            <td colspan="5" style="border:1px solid #000000">
                                {{isset($familyStatusIdApprove->FATHER_UNIT) ? $familyStatusIdApprove->FATHER_UNIT : ' '}}</td>
                        </tr>
                        <tr style="border:none">
                            <td style="width:15%;font-weight:normal;">ឈ្មោះម្តាយ</td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width:22%;">
                                            {{isset($familyStatusIdApprove->MOTHER_NAME_KH) ? $familyStatusIdApprove->MOTHER_NAME_KH : ''}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:15%;font-weight:normal;text-align:right;">ជាអក្សរឡាតាំង</td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width:25%;">
                                            {{isset($familyStatusIdApprove->MOTHER_NAME_EN) ? $familyStatusIdApprove->MOTHER_NAME_EN : ''}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:102%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width:18%;font-weight:normal; text-align:center">
                                            <?php
                                            $MOTHER_LIVE = isset($familyStatusIdApprove->MOTHER_LIVE) ? $familyStatusIdApprove->MOTHER_LIVE :'';
                                            ?>
                                            <input type="checkbox" name="mother_live" disabled value="" <?php echo ($MOTHER_LIVE =='ស្លាប់' ? 'checked' : ''); ?> >ស្លាប់
                                            <input type="checkbox" name="mother_live" disabled value="" <?php echo ($MOTHER_LIVE =='រស់' ? 'checked' : ''); ?> >រស់
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:150px;">ថ្ងៃខែឆ្នាំកំណើត</td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">{{isset($familyStatusIdApprove->MOTHER_DOB) && $familyStatusIdApprove->MOTHER_DOB != '0000-00-00' && $familyStatusIdApprove->MOTHER_DOB != ''? $tool->dateformate($familyStatusIdApprove->MOTHER_DOB) : ''}}</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:150px;text-align:right;">សញ្ជាតិ</td>
                            <td colspan="5" style=" border: 1px solid #000">
                                <label style="padding-left: 10px">1. {{isset($familyStatusIdApprove->MOTHER_NATIONALITY_1) ? $familyStatusIdApprove->MOTHER_NATIONALITY_1 : ''}}</label>
                                <label style="padding-left: 150px">2. {{isset($familyStatusIdApprove->MOTHER_NATIONALITY_2) ? $familyStatusIdApprove->MOTHER_NATIONALITY_2 : ''}}</label>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:150px;">ទីលំនៅបច្ចុប្បន្ន</td>
                            <td colspan="7">
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">
                                            {{isset($familyStatusIdApprove->MOTHER_ADDRESS) ? $familyStatusIdApprove->MOTHER_ADDRESS : ''}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:150px;">មុខរបរ</td>
                            <td style="width: 30%">
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">
                                            {{isset($familyStatusIdApprove->MOTHER_JOB) ? $familyStatusIdApprove->MOTHER_JOB : ''}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:150px;text-align:right;">ស្ថាប័ន/អង្គភាព</td>
                            <td colspan="5" style="border:1px solid #000000">
                                {{isset($familyStatusIdApprove->MOTHER_UNIT) ? $familyStatusIdApprove->MOTHER_UNIT : ''}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div><!--break-->
                <div style="line-break: loose;page-break-before: always">
                    <table>
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:10px;font-size:12px;">ខ.ព័ត៌មានបងប្អូន</h5>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;">
                        <tr>
                            <th style="font-weight:normal; width: 5%">ល.រ</th>
                            <th style="width:20%;font-weight:normal">គោត្តនាម និងនាម</th>
                            <th style="font-weight:normal;width:20%;">អក្សរឡាតាំង</th>
                            <th style="font-weight:normal;width:5%;">ភេទ</th>
                            <th style="font-weight:normal;width:25%;">ថ្ងៃខែឆ្នាំកំណើត</th>
                            <th style="font-weight:normal;width:25%;">មុខរបរអង្គភាព</th>
                        </tr>
                        <tbody>
                        @if(count($relativesInformationIdApprove) == 0)
                            <tr style="height: 30px">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        <?php $i = 1; ?>
                        @foreach($relativesInformationIdApprove as $key =>$value)
                            <tr style="height: 30px">
                                <td id="relativesInformationId_id{{ $key }}" style="text-align:center">{{$tool->dayFormat($i++)}}</td>
                                <td id="relativesInformationId_name_kh{{ $key }}">{{isset($value->RELATIVES_NAME_KH) ? $value->RELATIVES_NAME_KH : ''}}</td>
                                <td id="relativesInformationId_name_en{{ $key }}">{{isset($value->RELATIVES_NAME_EN) ? $value->RELATIVES_NAME_EN : ''}}</td>
                                <td id="relativesInformationId_gender{{ $key }}">{{isset($value->RELATIVES_NAME_GENDER) ? $value->RELATIVES_NAME_GENDER : ''}}</td>
                                <td id="relativesInformationId_dob{{ $key }}">{{isset($value->RELATIVES_NAME_DOB) && $value->RELATIVES_NAME_DOB !='0000-00-00' && $value->RELATIVES_NAME_DOB !="" ? $tool->dateformate($value->RELATIVES_NAME_DOB) : ''}}</td>
                                <td id="relativesInformationId_job{{ $key }}">{{isset($value->RELATIVES_NAME_JOB) ? $value->RELATIVES_NAME_JOB : ''}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:10px;font-size:12px;">គ.ព័ត៌មានសហព័ទ្ធ</h5>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" cellspacing="5px" cellpadding="3px" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal; height: 35px" >
                        <tr style="border:none">
                            <td style="width:15%;font-weight:normal;">ឈ្មោះប្តីឬប្រពន្ធ</td>
                            <td style="width: 21.8%">
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'; height: 30px;">
                                    <tr>
                                        <td style="width:22%;">{{isset($familyStatusIdApprove->SPOUSE_NAME_KH) ? $familyStatusIdApprove->SPOUSE_NAME_KH : ''}}</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:16%;font-weight:normal;text-align:right; padding-right: 7px">ជាអក្សរឡាតាំង</td>
                            <td style="width: 31.8%">
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'; height: 30px">
                                    <tr>
                                        <td style="width:25%;">{{isset($familyStatusIdApprove->SPOUSE_NAME_EN) ? $familyStatusIdApprove->SPOUSE_NAME_EN : ''}}</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:108.3%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width:18%;font-weight:normal; text-align:center">
                                            <?php
                                            $SPOUSE_LIVE = isset($familyStatusIdApprove->SPOUSE_LIVE) ? $familyStatusIdApprove->SPOUSE_LIVE:'';
                                            ?>
                                            <input type="checkbox" name="SPOUSE_LIVE" disabled value="" <?php echo ($SPOUSE_LIVE =='ស្លាប់' ? 'checked' : ''); ?> >ស្លាប់
                                            <input type="checkbox" name="SPOUSE_LIVE" disabled value="" <?php echo ($SPOUSE_LIVE =='រស់' ? 'checked' : ''); ?> >រស់
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:15%;">ថ្ងៃខែឆ្នាំកំណើត</td>
                            <td>
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">
                                            {{isset($familyStatusIdApprove->SPOUSE_DOB) && $familyStatusIdApprove->SPOUSE_DOB != '0000-00-00' && $familyStatusIdApprove->SPOUSE_DOB != ''? $tool->dateformate($familyStatusIdApprove->SPOUSE_DOB) : ''}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:150px;text-align:right; padding-right: 7px">សញ្ជាតិ</td>
                            <td colspan="5">
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:101.5%;font-size:12px;line-height:2.3;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td>
                                            <label style="padding-left: 10px">
                                                1. {{isset($familyStatusIdApprove->SPOUSE_NATIONALITY_1) ? $familyStatusIdApprove->SPOUSE_NATIONALITY_1 : ''}}</label>
                                            <label style="padding-left: 150px">
                                                2. {{isset($familyStatusIdApprove->SPOUSE_NATIONALITY_2) ? $familyStatusIdApprove->SPOUSE_NATIONALITY_2 : ''}}</label>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:15%;">ទីកន្លែងកំណើត</td>
                            <td colspan="7">
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100.8%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">
                                            {{isset($familyStatusIdApprove->SPOUSE_POB) ? $familyStatusIdApprove->SPOUSE_POB : ''}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" cellspacing="5px" cellpadding="3px" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin-top:-5px;" >
                        <tr style="border:none">
                            <td style="width:15%;font-weight:normal;">មុខរបរ</td>
                            <td style="width: 32.8%">
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:66%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">
                                    <tr>
                                        <td style="width: 1%;margin-left: 10px;vertical-align: middle;font-size: 12px;box-sizing: border-box;line-height: 1.8;padding: 3px 0 3px 5px;font-family: 'KHMERMEF1';">
                                            {{isset($familyStatusIdApprove->SPOUSE_JOB) ? $familyStatusIdApprove->SPOUSE_JOB : ''}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:4.8%;font-weight:normal;text-align:right;">អង្គភាព</td>
                            <td style="width: 30%">
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:100%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'; height: 34px">
                                    <tr>
                                        <td>
                                            {{isset($familyStatusIdApprove->SPOUSE_UNIT) ? $familyStatusIdApprove->SPOUSE_UNIT : ''}}
                                        </td>
                                    </tr>
                                </table>
                            </td>

                            <td style="width: 17%; ">
                                <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;font-size:12px;line-height:2.3;font-family:'KHMERMEF1'; width: 107.5%">
                                    <tr>
                                        <td style="width:30%;font-weight:normal;text-align:center;">
                                            ប្រាក់ឧបត្ថម្ភ :
                                            <?php
                                            $SPOUSE_SPONSOR = isset($familyStatusIdApprove->SPOUSE_SPONSOR) ? $familyStatusIdApprove->SPOUSE_SPONSOR:'';
                                            ?>
                                            <input type="checkbox" name="SPOUSE_SPONSOR" disabled value="" <?php echo ($SPOUSE_SPONSOR =='មាន' ? 'checked' : ''); ?> >មាន
                                            <input type="checkbox" name="SPOUSE_SPONSOR" disabled value="" <?php echo ($SPOUSE_SPONSOR =='គ្មាន' ? 'checked' : ''); ?> >គ្មាន
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:150px;">លេខទូរស័ព្ទ</td>
                            <td colspan=7>
                                <table width="101.3%" style="margin-left: -2px">
                                    <tr>
                                        <td  style=" border: 1px solid #000; margin-left: -2px">
                                            @foreach($phoneNumberApprove as $key =>$value)
                                                <label style="padding-right: 20px">{{isset($value) ? $value : ''}}</label>
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:10px;font-size:12px;">ឃ.ព័ត៌មានកូន</h5>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;">
                        <tr>
                            <th style="font-weight:normal">ល.រ</th>
                            <th style="width:20%;font-weight:normal">គោត្តនាម និងនាម</th>
                            <th style="font-weight:normal;width:20%">អក្សរឡាតាំង</th>
                            <th style="font-weight:normal;width:5%;">ភេទ</th>
                            <th style="font-weight:normal">ថ្ងៃខែឆ្នាំកំណើត</th>
                            <th style="font-weight:normal;width:20%;">មុខរបរ</th>
                            <th style="font-weight:normal">ប្រាក់ឧបត្ថម្ភ</th>
                        </tr>
                        <tbody>
                        @if(count($childrenIdApprove) == 0)
                            <tr style="height: 30px">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        <?php $i = 1; ?>
                        @foreach($childrenIdApprove as $key =>$value)
                            <tr style="height: 30px">
                                <td id="childrenId_id{{ $key }}" style="text-align:center">{{$tool->dayFormat($i++)}}</td>
                                <td id="childrenId_name_kh{{ $key }}">{{isset($value->CHILDRENS_NAME_KH) ? $value->CHILDRENS_NAME_KH : ''}}</td>
                                <td id="childrenId_name_en{{ $key }}">{{isset($value->CHILDRENS_NAME_EN) ? $value->CHILDRENS_NAME_EN : ''}}</td>
                                <td id="childrenId_gender{{ $key }}">{{isset($value->CHILDRENS_NAME_GENDER) ? $value->CHILDRENS_NAME_GENDER : ''}}</td>
                                <td id="childrenId_dob{{ $key }}">{{isset($value->CHILDRENS_NAME_DOB) && $value->CHILDRENS_NAME_DOB !='0000-00-00' && $value->CHILDRENS_NAME_DOB !=''? $tool->dateformate($value->CHILDRENS_NAME_DOB) : ''}}</td>
                                <td id="childrenId_job{{ $key }}">{{isset($value->CHILDRENS_NAME_JOB) ? $value->CHILDRENS_NAME_JOB : ''}}</td>
                                <td id="childrenId_sponsor{{ $key }}" style="text-align:center"><input type="radio" name="gender_{{$key}}" value="" <?php if(isset($value->CHILDRENS_NAME_SPONSOR) ? $value->CHILDRENS_NAME_SPONSOR : 'គ្មាន' == 'មាន' ){ echo 'checked'; } ?> >មាន<input type="radio" name="gender_{{$key}}" value="" <?php if(isset($value->CHILDRENS_NAME_SPONSOR) ? $value->CHILDRENS_NAME_SPONSOR : 'គ្មាន' == 'គ្មាន' ){ echo "checked"; } ?> >គ្មាន</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <table width="100%" cellpadding="5" cellspacing="5" style="margin-top:20px">
                        <tr>
                            <td style=";font-family:'KHMERMEF1';font-size:12px;">ខ្ញុំសូមធានាអះអាង និងទទួលខុសត្រូវចំពោះមុខច្បាប់ថា ព័ត៌មានដែលបានបំពេញខាងលើនេះ ពិតជាត្រឹមត្រូវប្រាកដមែន ។</td>
                            <td></td>
                        </tr>
                    </table>
                    <table width="100%" cellpadding="5" cellspacing="5">
                        <tr>
                            <td></td>
                            <td style="text-align:right;font-family:'KHMERMEF1';font-size:12px;width:40%;" colspan="8">ធ្វើនៅ..............ថ្ងៃទី.........ខែ.........ឆ្នាំ............
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;font-family:'KHMERMEF1';font-size:12px;width: 30%;">

                            </td>
                            <td style="text-align:right">
                                <strong style="font-family:'KHMERMEF1';font-size:12px;padding-right:60px">ហត្ថលេខាសាមីខ្លួន</strong>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" cellpadding="5" cellspacing="5" style="margin-top:-40px;">
                        <tr>
                            <td style="text-align:center;font-family:'KHMERMEF1';font-size:12px;font-family:'KHMERMEF1';font-size:12px;width:10%;">
                                បានឃើញ និងបញ្ជាក់ថា ព័ត៌មានរបស់<br />
                                លោក/លោកស្រី..........................................................<br/>
                                ពិតជាដូចការអះអាងរបស់សាមីខ្លួនប្រាកដមែន ។<br/>
                                ធ្វើនៅ............ថ្ងៃទី........ខែ........ឆ្នាំ.........<br/>
                                <strong>ប្រធានអង្គភាព</strong>
                            </td>
                            <td style="text-align:center;font-family:'KHMERMEF1';font-size:12px;width:20%;">
                                <br/>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" cellpadding="5" cellspacing="5" style="margin-top:50px;">
                        <tr style="font-family:'KHMERMEF1';">
                            <td style="font-size:11px;">
                                បញ្ជាក់៖
                            </td>
                        </tr>
                        <tr style="font-family:'KHMERMEF1';font-size:9px;">
                            <td style="padding:0 0 0 10px;margin:0" >១.ភ្ជាប់មកជាមួយនូវច្បាប់ចម្លង(មានការបញ្ជាក់ពីអាជ្ញាធរមូលដ្ឋាន)</td>
                        </tr>
                        <tr style="font-family:'KHMERMEF1';font-size:9px;">
                            <td style="padding:0 0 0 10px;margin:0;">-សំបុត្រកំណើត ឬអត្តសញ្ញាណប័ណ្ណសញ្ញាតិខ្មែរ</td>
                        </tr>
                        <tr style="font-family:'KHMERMEF1';font-size:9px;">
                            <td style="padding:0 0 0 10px;margin:0;">-លិខិតបញ្ជាក់អាពាហ៏ពិពាហ៏ ឬប័ណ្ណគ្រួសារ</td>
                        </tr>
                        <tr style="font-family:'KHMERMEF1';font-size:9px;">
                            <td style="padding:0 0 0 10px;margin:0;">-លិខិតបញ្ជាក់ការសិក្សា</td>
                        </tr>
                        <tr style="font-family:'KHMERMEF1';font-size:9px;">
                            <td style="padding:0 0 0 10px;margin:0;">-លិខិតរដ្ឋបាលឯកត្តជនពាក់ព័ន្ធ</td>
                        </tr>
                        <tr style="font-family:'KHMERMEF1';font-size:9px;">
                            <td style="padding:0 0 0 10px;margin:0;">២.ករណីមានប្រែប្រួលព័ត៌មាន សាមីខ្លួនត្រូវជូនដំណឹងមកនាយកដ្ឋានបុគ្គលិកយ៉ាងយូរត្រឹម១ខែ</td>
                        </tr>
                        <tr style="font-family:'KHMERMEF1';font-size:9px;">
                            <td style="padding:0 0 0 10px;margin:0;">៣.ភ្ជាប់រូបថតថ្មីមិនលើសពី៦ខែ ទំហំ៤x៦ ផ្ទៃពណ៌ស ចំនួន២សន្លឹក(មន្ត្រីមានឯកសណ្ឋានផ្លូវការភ្ជាប់រូបថតគ្មានមួក)</td>
                        </tr>
                    </table>
                </div><!--break-->
            </div>
        </div>
    @else
        <div>
            <h2 class="title" style="margin-left: 30px">ប្រវត្តិរូបមន្ត្រីរាជការមិនទាន់បានអនុម័ត</h2>
        </div>
    @endif
</div>
<?php // --- Block Approved -- ?>
<form style="display:none;" class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix_appro;?>" id="jqx-form<?php echo $jqxPrefix_appro;?>" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="ajaxRequestJson" value="true" />
    <input type="hidden" name="Id" value="{{$id}}">
</form>
<script src="{{asset('jqwidgets/jqx-all.js')}}"></script>
<script src="{{asset('jqwidgets/jqxcore.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/core-function.js')}}"></script>
<script>
    $(document).ready(function(){
        $('[ data-toggle="tooltip"]').tooltip();
    });
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
    var bar_size_approve=3;
    if(get_object("barcode_approve").innerHTML <6){
        bar_size_approve = 8;
    }
    if(get_object("barcode_approve").innerHTML <3){
        bar_size_approve = 15;
    }
    get_object("barcode_approve").innerHTML=DrawHTMLBarcode_Code39(get_object("barcode_approve").innerHTML,0,"no","on",0,2,0.5,bar_size_approve,"bottom","right","","black","white");
    //Push Back
    $("#btn-push-back").on('click',function(){
        newJqxItem('<?php echo $jqxPrefix;?>', 'PUSH BACK',700,510, '{{$pushBackUrl}}', {{$id}}, '{{ csrf_token() }}');
    });
    /* APPROVE */
    $("#btn-approve").click(function(){
        saveJqxItem('{{$jqxPrefix_appro}}', '{{$saveUrl}}', '{{ csrf_token() }}',function(response){

        });
    });
    /* Back to Dashborad */
    $("#btn-back").click(function(){
        window.location.href = '{{$backDashboard}}';
    });
</script>
<style>
    .tooltip-inner {
        text-align: left;
        background-color: #157bc3;
        max-width: 960px;
    }
    .title-audit{ text-align: center; margin-bottom: 10px; margin-top: 10px; font-size: 17px; }
    table.table-tooltip{
        width: 100%;
        max-width: 100%;
        margin-bottom: 10px;
    }
    table.table-tooltip {
        border-collapse: collapse;
    }
    table.table-tooltip, .table-tooltip td, .table-tooltip th {
        border: 1px solid #ffffff;
    }
    .table-tooltip td, .table-tooltip th {
        padding: 7px 15px;
    }
    .tooltip.in{ opacity: 1; }
    .warp-address span{ min-width: 100px; display: inline-block; }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="{{asset('js/jquery.liquid-slider.min.js')}}"></script>
<script>
    $('#main-slider').liquidSlider();
</script>
</body>
</html>

