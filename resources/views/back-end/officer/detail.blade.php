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
    @page {
        size: auto;
        margin: 0px 25px 0px 40px;
        size: A4;
    }
    @media print {

        table{page-break-inside: avoid;}
    }
</style>

<body>
      <table style="font-family: 'KHMERMEF1';position:absolute;right:25px;top:30px;font-size:10px;font-weight: bold;z-index:9999;"><tr><td><input type="button" id='btn-print' value=" " onClick="window.print()" style="font-size:16px;color: currentColor;background-color: inherit;border-color: chartreuse;"></td></tr></table>
      @if($idApprove != null)
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
                          <img src="{{asset('images/mef-logo.png')}}" width="80px;" style="font-family:'KHMERMEF2';position:relative;left:35px;">
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
                                  <td style="position:absolute;right:-10px;top:165px;font-family:'automation';font-size:12px">
                                      <div id="barcode">{!! isset($row->ID) ? $row->ID:0 !!}</div>
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
              <table style="width:100.7%;margin: 15px 0 0 0;">
                  <tr>
                      <td>
                          <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-bottom:10px;font-size:12px;">១-{{trans('personal_info.persional_info')}}</h5>
                      </td>

                  </tr>
                  <tr>
                      <td style="font-family:'KHMERMEF1';width:18%;font-size:12px">
                          {{trans('personal_info.official_id')}}
                      </td>

                      <td style="font-size:12px;margin-left:28px;border:1px solid #000;padding:0 5px;letter-spacing:2px;height:25px;min-width: 145px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1'; margin-top: 10px">{{isset($row->PERSONAL_INFORMATION) ? $row->PERSONAL_INFORMATION : "​ "}}</td>

                      <td style="font-family:'KHMERMEF1';width:45%;font-size:12px;text-align:right;">
                          {{trans('personal_info.official_id_card_of_mef')}}
                          <table style="display:inline-block;margin-left:10px;vertical-align:middle;text-align:left;"><tr><td style="border:1px solid #000;padding:0 5px;letter-spacing:2px;height:25px;min-width:50px;">{{isset($row->OFFICIAL_ID) ? $row->OFFICIAL_ID : "​ "}}</td></tr></table>
                      </td>
                      <td style="font-family:'KHMERMEF1';width:35%;font-size:12px;text-align:right;">
                          {{trans('personal_info.unit_id')}}
                          <table style="display:inline-block;margin-left:10px;vertical-align:middle;float:right;text-align:left;"><tr><td style="border:1px solid #000;padding:0 5px;letter-spacing:2px;height:25px;min-width:50px;">{{ isset($row->UNIT_CODE) ? $row->UNIT_CODE : "​ "}}</td></tr></table>
                      </td>
                  </tr>
              </table>

              <table style="width:100.8%; margin-left: -4px">

                  <tr>
                      <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;">
                          {{trans('officer.full_name')}}
                      </td>
                      <td style="width:35%;"><table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:89%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'"><tr><td>{{isset($row->FULL_NAME_KH) ? $row->FULL_NAME_KH : "​ "}}</td></tr></table></td>
                      <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right;padding-right:5px;">
                          {{trans('officer.english_name')}}
                      </td>
                      <td style="width:35%;"><table style="display:inline-block;border: 1px solid #000;vertical-align:middle;width:97%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1';float: right;"><tr><td>{{ isset($row->FULL_NAME_EN) ? $row->FULL_NAME_EN : "​ "}}</td></tr></table></td>
                  </tr>
                  <tr>
                      <td style="font-family:'KHMERMEF1';width:18%;vertical-align:middle;">

                          <table style="display:inline-block;font-size:12px;border-collapse:collapse;margin-top:-12px;" cellpadding="0" cellspacing="0">
                              <tr>
                                  <?php
                                  $gender = isset($row->GENDER) ? $row->GENDER:'';
                                  ?>
                                  <td>{{trans('personal_info.gender')}}</td>
                                  <td style="display:inline-block;vertical-align:middle;vertical-align:middle;font-size:11px;" ><input type="checkbox" name="gender" disabled style="vertical-align:middle;" <?php echo ($gender =='ប្រុស' ? 'checked' :''); ?> >{{trans('personal_info.man')}}</td>
                                  <td style="display:inline-block;font-size:11px;"><input type="checkbox" name="gender" disabled style="vertical-align:middle;" <?php echo ($gender  =='ស្រី' ? 'checked' :''); ?> >{{trans('personal_info.woman')}}</td>
                              </tr>
                          </table>
                      </td>
                      <td>
                          <?php
                          $DOB = isset($row->DATE_OF_BIRTH) ? $row->DATE_OF_BIRTH:'';
                          ?>
                          <table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';vertical-align:middle;"><tr><td>{{trans('personal_info.date_of_birth')}}</td></tr></table>
                          <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:56%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'"><tr><td>{{$DOB !=null && $DOB !='0000-00-00' && $DOB != '' ? $tool->dateformate($DOB) : "​ "}}</td>
                              </tr></table>
                      </td>
                      <td style="font-size:12px;font-family:'KHMERMEF1';">
                          <?php
                          $MARRIED = isset($row->MARRIED) ? $row->MARRIED:'';
                          ?>
                          <table style="display:inline-block;vertical-align:middle;text-align:right;width:190%;"><tr>
                                  <td style="font-size:12px;position:relative;right:3%;line-height:1.5;position:relative;left:-19px;"><input type="checkbox" style="vertical-align:middle;float:left;" disabled value="" <?php echo ($MARRIED== 1 ? 'checked': '') ?> >{{trans('personal_info.singal')}}</td>
                                  <td>{{trans('personal_info.nationaley')}}</td></tr></table>
                      </td>
                      <td style="width:35%;font-family:'KHMERMEF1'">
                          <table style="display:inline-block;border: 1px solid #000;vertical-align:middle;width:97%;font-size:12px;line-height:1.8;padding-left:5px;float: right;"><tr>
                                  <?php
                                  $NATIONALITY_1 = isset($row->NATIONALITY_1) ? $row->NATIONALITY_1:'';
                                  $NATIONALITY_2 = isset($row->NATIONALITY_2) ? $row->NATIONALITY_2:'';
                                  ?>
                                  <td>1. {{$NATIONALITY_1 !=null ? $NATIONALITY_1 : "​ "}}</td>
                                  <td style="padding-left:100px;">2. {{$NATIONALITY_2 !=null ? $NATIONALITY_2 : "​ "}}</td></tr>
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
                      <td style="width:80%;margin-left:10px; border: 1px solid #000;vertical-align:middle;width:98%;font-size:12px;box-sizing:border-box;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                          {{$POB != null ? $POB : "​​ "}}
                      </td>

                  </tr>
              </table>
              <table style="width:100%;margin-top:2px;">
                  <tr>
                      <td style="width:18%;font-size:12px;font-family:'KHMERMEF1';">
                          {{trans('officer.address')}}
                      </td>
                      <td style="width:80%;margin-left:10px; border: 1px solid #000;vertical-align:middle;width:98%;font-size:12px;box-sizing:border-box;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                          ​ផ្ទះលេខ {{isset($currentAddress->house) ? $currentAddress->house : "​"}}
                          ​ផ្លូវលេខ {{isset($currentAddress->street) ? $currentAddress->street : "​"}}
                          ​{{isset($currentAddress->villages) ? $currentAddress->villages : "​"}}
                          {{isset($currentAddress->commune) ? $currentAddress->commune : ""}}
                          {{isset($currentAddress->districts) ? $currentAddress->districts : "​"}}
                          {{isset($currentAddress->province) ? $currentAddress->province : ""}}
                      </td>

                  </tr>
              </table>
              <table style="width:100.2%">
                  <tr>
                      <td style="width:45.5%">
                          <table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';vertical-align:middle;width:29%;margin-left:-2px;"><tr><td>{{trans('officer.email')}}</td></tr></table>
                          <table style="float:right;display:inline-block;border: 1px solid #000; vertical-align:middle;width:66%;font-size:12px;box-sizing:border-box;line-height:1.8;padding-left:3px;font-family:'KHMERMEF1'"><tr><td>{{ isset($row->EMAIL) ? $row->EMAIL : "​ "}}</td></tr></table>
                      </td>
                      <td style="width:40%;text-align: right;">
                          <table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';vertical-align:middle;"><tr><td>{{trans('officer.phone_number')}}</td></tr></table>
                          <table style="display:inline-block;border: 1px solid #000; vertical-align:middle;width:78%;font-size:12px;box-sizing:border-box;padding-left:5px;">
                              <tr>
                                  <td style="line-height:1.8;width:8%;text-align:left;">
                                      1. {{ isset($row->PHONE_NUMBER_1) ? $row->PHONE_NUMBER_1 : "​ "}}
                                  </td>
                                  <td style="padding-left:3%;width:8%;text-align:left;">
                                      2. {{ isset($row->PHONE_NUMBER_2) ? $row->PHONE_NUMBER_2 : " "}}
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
                      <td style="width:35%;font-size:12px; border: 1px solid #000;padding-left:5px;font-family:'KHMERMEF1'">{{ isset($row->NATION_ID) ? $row->NATION_ID : "​ "}}</td>
                      <td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;text-align:right;padding-right:5px;">
                          {{trans('personal_info.deadline')}}
                      </td>
                      <?php
                      $NATION_ID_EXPIRED_DATE = isset($row->NATION_ID_EXPIRED_DATE) ? $row->NATION_ID_EXPIRED_DATE: '';
                      ?>
                      <td style="width:34%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;text-align:center;font-family:'KHMERMEF1'">{{$NATION_ID_EXPIRED_DATE !=null && $NATION_ID_EXPIRED_DATE !='0000-00-00' && $NATION_ID_EXPIRED_DATE !='' ? $tool->dateformate($NATION_ID_EXPIRED_DATE) : "​ "}}</td>
                  </tr>
              </table>
              <table style="width:100%;margin-top:1px;">
                  <tr>
                      <td style="font-family:'KHMERMEF1';width:18%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                          {{trans('personal_info.passport')}}
                      </td>
                      <td style="width:35%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:2px;padding-left:5px;font-family:'KHMERMEF1'">{{ isset($row->PASSPORT_ID) ? $row->PASSPORT_ID : "​ "}}</td>
                      <td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                          {{trans('personal_info.deadline')}}
                      </td>
                      <?php
                      $PASSPORT_ID_EXPIRED_DATE = isset($row->PASSPORT_ID_EXPIRED_DATE) ? $row->PASSPORT_ID_EXPIRED_DATE:'';
                      ?>
                      <td style="width:34%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:2px;padding-left:5px;text-align:center;font-family:'KHMERMEF1'">{{$PASSPORT_ID_EXPIRED_DATE !=null && $PASSPORT_ID_EXPIRED_DATE != '0000-00-00' && $PASSPORT_ID_EXPIRED_DATE !='' ? $tool->dateformate($PASSPORT_ID_EXPIRED_DATE) : "​ "}}</td>
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
                      <td style="font-family:'KHMERMEF1';width:33%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                          កាលបរិច្ឆេទប្រកាសចូលបម្រើការងាររដ្ឋដំបូង
                      </td>
                      <td style="width:18%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;text-align:center;font-family:'KHMERMEF1'">{{isset($serviceStatusInfoId->FIRST_START_WORKING_DATE_FOR_GOV) && $serviceStatusInfoId->FIRST_START_WORKING_DATE_FOR_GOV != '0000-00-00' && $serviceStatusInfoId->FIRST_START_WORKING_DATE_FOR_GOV !='' ? $tool->dateformate($serviceStatusInfoId->FIRST_START_WORKING_DATE_FOR_GOV)  : "​ "}}</td>
                      <td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                          កាលបរិច្ឆេទតាំងស៊ប់
                      </td>
                      <td style="width:35%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;text-align:center;font-family:'KHMERMEF1'">{{isset($serviceStatusInfoId->FIRST_GET_OFFICER_DATE) && $serviceStatusInfoId->FIRST_GET_OFFICER_DATE != '0000-00-00' && $serviceStatusInfoId->FIRST_GET_OFFICER_DATE != ''? $tool->dateformate($serviceStatusInfoId->FIRST_GET_OFFICER_DATE) : "​ "}}</td>
                  </tr>
              </table>
              <table style="width:100%">
                  <tr>
                      <td style="font-family:'KHMERMEF1';width:24%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                          ក្របខ័ណ្ឌឋានន្តរស័ក្តិ និងថ្នាក់
                      </td>
                      <td style="width:27%;font-size:12px;line-height:2;padding-left:5px;border:1px solid #000;padding:0 5px;letter-spacing:2px;font-family:'KHMERMEF1'">{{isset($serviceStatusInfoId->className) ? $serviceStatusInfoId->className : "​ "}}</td>
                      <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                          មុខតំណែង
                      </td>
                      <td style="width:35%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                          {{isset($serviceStatusInfoId->positionName) ? $serviceStatusInfoId->positionName : "​ "}}
                      </td>
                  </tr>
              </table>
              <table style="width:100%">
                  <tr>
                      <td style="font-family:'KHMERMEF1';width:24%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                          ក្រសួង/ស្ថាប័ន
                      </td>
                      <td style="width:27%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                          {{isset($serviceStatusInfoId->ministryName) ? $serviceStatusInfoId->ministryName : "​ "}}
                      </td>
                      <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                          អង្គភាព
                      </td>
                      <td style="width:35%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                          {{isset($serviceStatusInfoId->secretariteName) ? $serviceStatusInfoId->secretariteName : "​ "}}</td>
                  </tr>
              </table>
              <table style="width:100%">
                  <tr>
                      <td style="font-family:'KHMERMEF1';width:24%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                          នាយកដ្ឋាន/អង្គភាព/មន្ទីរ
                      </td>
                      <td style="width:27%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                          {{isset($serviceStatusInfoId->departmentName) ? $serviceStatusInfoId->departmentName : "​ "}}
                      </td>
                      <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                          ការិយាល័យ
                      </td>
                      <td style="width:35%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                          {{isset($serviceStatusInfoId->OfficeName) ? $serviceStatusInfoId->OfficeName : "​ "}}
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
                      <td style="width:8.5%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;letter-spacing:2px;font-family:'KHMERMEF1'">
                          {{isset($serviceStatusCurrentId->CURRENT_OFFICER_CLASSED) ? $serviceStatusCurrentId->CURRENT_OFFICER_CLASSED : "​ "}}
                      </td>
                      <td style="font-family:'KHMERMEF1';width:30%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                          កាលបរិច្ឆេទប្តូរក្របខ័ណ្ឌ ឋានន្តរស័ក្តិ និងថ្នាក់  ចុងក្រោយ
                      </td>
                      <td style="width:12%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'; text-align: center">
                          {{isset($serviceStatusCurrentId->CURRETN_PROMOTE_OFFICER_DATE) && $serviceStatusCurrentId->CURRETN_PROMOTE_OFFICER_DATE != '0000-00-00' && $serviceStatusCurrentId->CURRETN_PROMOTE_OFFICER_DATE != '' ? $tool->dateformate($serviceStatusCurrentId->CURRETN_PROMOTE_OFFICER_DATE) : "​ "}}
                      </td>
                  </tr>
              </table>

              <table style="width:100%">
                  <tr>
                      <td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                          មុខតំណែង
                      </td>
                      <td style="width:20%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                          {{isset($serviceStatusCurrentId->CURRENT_POSITIONED) ? $serviceStatusCurrentId->CURRENT_POSITIONED : "​ "}}
                      </td>
                      <td style="font-family:'KHMERMEF1';width:28%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                          កាលបរិច្ឆេទទទួលមុខតំណែងចុងក្រោយ
                      </td>
                      <td style="width:15%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'; text-align:center;">
                          {{isset($serviceStatusCurrentId->CURRENT_GET_OFFICER_DATE) && $serviceStatusCurrentId->CURRENT_GET_OFFICER_DATE != '0000-00-00' && $serviceStatusCurrentId->CURRENT_GET_OFFICER_DATE != '' ? $tool->dateformate($serviceStatusCurrentId->CURRENT_GET_OFFICER_DATE) : "​ "}}
                      </td>
                  </tr>
              </table>
              <table style="width:100%">
                  <tr>
                      <td style="width:45%;font-size:12px;font-family:'KHMERMEF1';">
                          អគ្គលេខាធិការដ្ឋាន/អគ្គនាយកដ្ឋាន/អគ្គាធិការដ្ឋាន/វិទ្យាស្ថាន
                      </td>
                      <td style="width:55%;margin-left:10px; border: 1px solid #000;vertical-align:middle;width:98%;font-size:12px;box-sizing:border-box;line-height:1.8;padding:3px 0 3px 5px;font-family:'KHMERMEF1'">
                          {{isset($serviceStatusCurrentId->CURRENT_GENERAL_DEPARTMENTED) && $serviceStatusCurrentId->CURRENT_GENERAL_DEPARTMENTED !="" ? $serviceStatusCurrentId->CURRENT_GENERAL_DEPARTMENTED : "​ "}}
                      </td>

                  </tr>
              </table>
              <table style="width:100%">
                  <tr>
                      <td style="font-family:'KHMERMEF1';width:24%;vertical-align:middle;font-size:12px;">
                          នាយកដ្ឋាន/អង្គភាព/មន្ទីរ
                      </td>
                      <td style="width:30%;margin-left:10px; border: 1px solid #000;vertical-align:middle;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">{{isset($serviceStatusCurrentId->CURRENT_DEPARTMENTED) ? $serviceStatusCurrentId->CURRENT_DEPARTMENTED : "​ "}}
                      </td>
                      <td style="font-family:'KHMERMEF1';width:12%;vertical-align:middle;font-size:12px;text-align:right">
                          ការិយាល័យ
                      </td>
                      <td style="width:35%;"><table style="display:inline-block;margin-left:10px; border: 1px solid #000;vertical-align:middle;width:95%;font-size:12px;line-height:1.8;padding-left:2px;font-family:'KHMERMEF1'">
                              <tr>
                                  <td>
                                      {{isset($serviceStatusCurrentId->CURRENT_OFFICED) ? $serviceStatusCurrentId->CURRENT_OFFICED : "​ "}}
                                  </td>
                              </tr>
                          </table></td>
                  </tr>
              </table>

              <div style="line-break: loose;page-break-before: always; margin-top: 10px">
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
                          <td style=" border: 1px solid #000;vertical-align:middle;width:20%;font-size:12px;line-height:2;font-family:'KHMERMEF1';padding-left:5px">
                              {{isset($serviceStatusAdditioanlId->ADDITIONAL_WORKING_DATE_FOR_GOV) && $serviceStatusAdditioanlId->ADDITIONAL_WORKING_DATE_FOR_GOV !='0000-00-00' && $serviceStatusAdditioanlId->ADDITIONAL_WORKING_DATE_FOR_GOV !='' ? $tool->dateformate($serviceStatusAdditioanlId->ADDITIONAL_WORKING_DATE_FOR_GOV) : "​ "}}
                          </td>
                          <td style="font-family:'KHMERMEF1';width:10%;font-size:12px;text-align:right;padding-right:10px;">
                              មុខតំណែង

                          </td>
                          <td style=" border: 1px solid #000;vertical-align:middle;width:25%;font-size:12px;line-height:2;font-family:'KHMERMEF1';padding-left:5px">
                              {{isset($serviceStatusAdditioanlId->additionalPosition) ? $serviceStatusAdditioanlId->additionalPosition : "​ "}}
                          </td>
                          <td style="font-family:'KHMERMEF1';width:10%;font-size:12px;text-align:right;padding-right:10px;">
                              ឋានៈស្មើ
                          </td>
                          <td style=" border: 1px solid #000;vertical-align:middle;width:20%;font-size:12px;line-height:2;font-family:'KHMERMEF1';padding-left:5px">
                              {{isset($serviceStatusAdditioanlId->ADDITINAL_STATUS) ? $serviceStatusAdditioanlId->ADDITINAL_STATUS : "​ "}}
                          </td>
                      </tr>

                  </table>
                  <table style="width:100%">
                      <tr>
                          <td style="width:16%;font-size:12px;font-family:'KHMERMEF1';">
                              អង្គភាព
                          </td>
                          <td style="width:80%;margin-left:10px; border: 1px solid #000;vertical-align:middle;width:98%;font-size:12px;box-sizing:border-box;line-height:2;padding-left:3px;font-family:'KHMERMEF1'">
                              {{isset($serviceStatusAdditioanlId->ADDITINAL_UNIT) && $serviceStatusAdditioanlId->ADDITINAL_UNIT !="" ? $serviceStatusAdditioanlId->ADDITINAL_UNIT : "​ "}}
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
                      <?php $i = 1 ?>
                      @foreach($situationOutsideId as $key => $value)
                          <tr style="height: 30px; font-family:'KHMERMEF1'">

                              <td style="text-align:center">{{$tool->dayFormat($i++)}}</td>
                              <td>{{isset($value->INSTITUTION) ? $value->INSTITUTION : ''}}</td>
                              <td>{{isset($value->START_DATE) && $value->START_DATE != '0000-00-00' && $value->START_DATE != '' ?  $tool->dateformate($value->START_DATE) : ''}}</td>
                              <td>{{isset($value->END_DATE) && $value->END_DATE != '0000-00-00' && $value->END_DATE != '' ? $tool->dateformate($value->END_DATE) : ''}}</td>
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

                      <?php $i = 1 ?>
                      @foreach($situationFreeId as $key => $value)

                          <tr style="height: 30px; font-family:'KHMERMEF1'">

                              <td style="text-align:center">{{$tool->dayFormat($i++)}}</td>
                              <td>{{isset($value->INSTITUTION) ? $value->INSTITUTION : ''}}</td>
                              <td>{{isset($value->START_DATE) && $value->START_DATE != '0000-00-00' && $value->START_DATE != '' ? $tool->dateformate($value->START_DATE) : ''}}</td>
                              <td>{{isset($value->END_DATE) && $value->END_DATE !='0000-00-00' && $value->END_DATE != '' ? $tool->dateformate($value->END_DATE) : ''}}</td>
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
                              <td style="height: 30px">{{isset($value->START_WORKING_DATE) && $value->START_WORKING_DATE !='0000-00-00' && $value->START_WORKING_DATE != '' ? $tool->dateformate($value->START_WORKING_DATE) : ''}}</td>
                              <td>
                                  <?php
                                  if(isset($value->END_WORKING_DATE) && $value->END_WORKING_DATE != '' && $value->END_WORKING_DATE != '0000-00-00'){
                                      echo $tool->dateformate($value->END_WORKING_DATE);
                                  }elseif ($value->END_WORKING_DATE =='0000-00-00'){
                                      echo "បច្ចុប្បន្ន";
                                  }else{
                                      echo "";
                                  }
                                  ?>
                              </td>
                              <td>{{isset($value->DEPARTMENT) ? $value->DEPARTMENT : ''}}</td>
                              <td>{{isset($value->INSTITUTION) ? $value->INSTITUTION : ''}}</td>
                              <td>{{isset($value->POSITION) ? $value->POSITION : ''}}</td>
                              <td>{{isset($value->POSITION_EQUAL_TO) ? $value->POSITION_EQUAL_TO : ''}}</td>
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
                              <td style="height:25px;"> {{isset($value->PRIVATE_START_DATE) && $value->PRIVATE_START_DATE !='' && $value->PRIVATE_START_DATE != '0000-00-00' ? $tool->dateformate($value->PRIVATE_START_DATE) : ''}}
                              </td>
                              <td>{{isset($value->PRIVATE_END_DATE) && $value->PRIVATE_END_DATE !='0000-00-00' && $value->PRIVATE_END_DATE != '' ? $tool->dateformate($value->PRIVATE_END_DATE) : ''}}
                              </td>
                              <td>{{isset($value->PRIVATE_DEPARTMENT) ? $value->PRIVATE_DEPARTMENT : ''}}</td>
                              <td>{{isset($value->PRIVATE_ROLE) ? $value->PRIVATE_ROLE : ''}}</td>
                              <td>{{isset($value->PRIVATE_SKILL) ? $value->PRIVATE_SKILL : ''}}</td>

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
                              <td style="height:25px;">{{isset($value->AWARD_NUMBER) ? $value->AWARD_NUMBER : ''}}</td>
                              <td>{{isset($value->AWARD_DATE) && $value->AWARD_DATE != '0000-00-00' && $value->AWARD_DATE != '' ? $tool->dateformate($value->AWARD_DATE) : ''}}</td>
                              <td>{{isset($value->DEPARTMENT) ? $value->DEPARTMENT : ''}}</td>
                              <td>{{isset($value->AWARD_DESCRIPTION) ? $value->AWARD_DESCRIPTION : ''}}</td>
                              <td>{{isset($value->AWARD_KIND) ? $value->AWARD_KIND : ''}}</td>
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
                              <td style="height:25px;">{{isset($value->AWARD_NUMBER) ? $value->AWARD_NUMBER : ''}}</td>
                              <td>{{isset($value->AWARD_DATE) && $value->AWARD_DATE != '0000-00-00' && $value->AWARD_DATE != '' ? $tool->dateformate($value->AWARD_DATE) : ''}}</td>
                              <td>{{isset($value->DEPARTMENT) ? $value->DEPARTMENT : ''}}</td>
                              <td>{{isset($value->AWARD_DESCRIPTION) ? $value->AWARD_DESCRIPTION : ''}}</td>
                              <td>{{isset($value->AWARD_KIND) ? $value->AWARD_KIND : ''}}</td>
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
                          <td>{{isset($generalQualificationsId->LEAVED) ? $generalQualificationsId->LEAVED : '' }}</td>
                          <td>{{isset($generalQualificationsId->PLACE) ? $generalQualificationsId->PLACE : ''}}</td>
                          <td>{{isset($generalQualificationsId->GRADUATION_MAJORED) ? $generalQualificationsId->GRADUATION_MAJORED : ''}}</td>
                          <td>{{isset($generalQualificationsId->Q_START_DATE) && $generalQualificationsId->Q_START_DATE != '0000-00-00' && $generalQualificationsId->Q_START_DATE != '' ? $tool->dateformate($generalQualificationsId->Q_START_DATE) : ''}}</td>
                          <td>{{isset($generalQualificationsId->Q_END_DATE) && $generalQualificationsId->Q_END_DATE != '0000-00-00' && $generalQualificationsId->Q_END_DATE != '' ? $tool->dateformate($generalQualificationsId->Q_END_DATE) : ''}}</td>
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
                              <td style="height:25px;">{{isset($value->LEAVED) ? $value->LEAVED : ''}}</td>
                              <td>{{isset($value->PLACE) ? $value->PLACE : ''}}</td>
                              <td>{{isset($value->GRADUATION_MAJOR) ? $value->GRADUATION_MAJOR : ''}}</td>
                              <td>{{isset($value->Q_START_DATE) && $value->Q_START_DATE != '0000-00-00' && $value->Q_START_DATE != '' ? $tool->dateformate($value->Q_START_DATE) : ''}}</td>
                              <td>{{isset($value->Q_END_DATE) && $value->Q_END_DATE != '0000-00-00' && $value->Q_END_DATE != '' ? $tool->dateformate($value->Q_END_DATE) : ''}}</td>
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
                              <td style="height:25px;">{{isset($value->LEAVED) ? $value->LEAVED : ''}}</td>
                              <td>{{isset($value->PLACE) ? $value->PLACE : ''}}</td>
                              <td>{{isset($value->GRADUATION_MAJOR) ? $value->GRADUATION_MAJOR : ''}}</td>
                              <td>{{isset($value->Q_START_DATE) && $value->Q_START_DATE !='0000-00-00' && $value->Q_START_DATE != '' ? $tool->dateformate($value->Q_START_DATE) : ''}}</td>
                              <td>{{isset($value->Q_END_DATE) && $value->Q_END_DATE !='0000-00-00' && $value->Q_END_DATE != '' ? $tool->dateformate($value->Q_END_DATE) : ''}}</td>
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
                              <td style="text-align:center">{{$tool->dayFormat($i++)}}</td>
                              <td>{{isset($value->LANGUAGES) ? $value->LANGUAGES : ''}}</td>
                              <td>{{isset($value->READED) ? $value->READED : ''}}</td>
                              <td>{{isset($value->WRITES) ? $value->WRITES : ''}}</td>
                              <td>{{isset($value->SPEAKS) ? $value->SPEAKS : ''}}</td>
                              <td>{{isset($value->LISTENTS) ? $value->LISTENTS : ''}}</td>
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
                  <table width="100%" cellspacing="5px" cellpadding="3px" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal; " >
                      <tbody>
                      <tr style="border:none">
                          <td style="width:15%;font-weight:normal;">ឈ្មោះឪពុក</td>
                          <td style="border: 1px solid #000;width:22%;">{{isset($familyStatusId->FATHER_NAME_KH) ? $familyStatusId->FATHER_NAME_KH : ''}}</td>
                          <td style="width:15%;font-weight:normal;text-align:right;">ជាអក្សរឡាតាំង</td>
                          <td style="border: 1px solid #000;width:25%;">{{isset($familyStatusId->FATHER_NAME_EN) ? $familyStatusId->FATHER_NAME_EN : ''}}</td>
                          <td style="width:18%;font-weight:normal">
                              <?php
                              $FATHER_LIVE = isset($familyStatusId->FATHER_LIVE) ? $familyStatusId->FATHER_LIVE:'';
                              ?>
                              <input type="checkbox" name="father_live" disabled value="" <?php echo ($FATHER_LIVE =='ស្លាប់' ? 'checked' : ''); ?> >ស្លាប់
                              <input type="checkbox" name="father_live" disabled value="" <?php echo ($FATHER_LIVE =='រស់' ? 'checked' : ''); ?> >រស់

                          </td>
                      </tr>
                      <tr>
                          <td style="width:150px;">ថ្ងៃខែឆ្នាំកំណើត</td>
                          <td style="border: 1px solid #000;">{{isset($familyStatusId->FATHER_DOB) && $familyStatusId->FATHER_DOB != '0000-00-00' &&  $familyStatusId->FATHER_DOB != '' ? $tool->dateformate($familyStatusId->FATHER_DOB) : ''}}</td>
                          <td style="width:150px;text-align:right;">សញ្ជាតិ</td>
                          <td colspan="5" style="border: 1px solid #000;">
                              <label style="padding-left: 10px">1. {{isset($familyStatusId->FATHER_NATIONALITY_1) ? $familyStatusId->FATHER_NATIONALITY_1 : ''}}</label>
                              <label style="padding-left: 150px">2. {{isset($familyStatusId->FATHER_NATIONALITY_2) ? $familyStatusId->FATHER_NATIONALITY_2 : ''}}</label>
                          </td>

                      </tr>
                      <tr>
                          <td style="width:150px;">ទីលំនៅបច្ចុប្បន្ន</td>
                          <td colspan="7" style=" border: 1px solid #000">{{isset($familyStatusId->FATHER_ADDRESS) ? $familyStatusId->FATHER_ADDRESS : ''}}</td>

                      </tr>
                      <tr>
                          <td style="width:150px;">មុខរបរ</td>
                          <td style=" border: 1px solid #000">
                              {{isset($familyStatusId->FATHER_JOB) ? $familyStatusId->FATHER_JOB : ''}}</td>
                          <td style="width:150px;text-align:right;">ស្ថាប័ន/អង្គភាព</td>
                          <td colspan="5" style=" border: 1px solid #000">
                              {{isset($familyStatusId->FATHER_UNIT) ? $familyStatusId->FATHER_UNIT : ''}}</td>

                      </tr>
                      <tr style="border:none">
                          <td style="width:15%;font-weight:normal;">ឈ្មោះម្តាយ</td>
                          <td style="border: 1px solid #000;width:22%;">
                              {{isset($familyStatusId->MOTHER_NAME_KH) ? $familyStatusId->MOTHER_NAME_KH : ''}}
                          </td>
                          <td style="width:15%;font-weight:normal;text-align:right;">ជាអក្សរឡាតាំង</td>
                          <td style="border: 1px solid #000;width:25%;">
                              {{isset($familyStatusId->MOTHER_NAME_EN) ? $familyStatusId->MOTHER_NAME_EN : ''}}
                          </td>
                          <td style="width:18%;font-weight:normal">
                              <?php
                              $MOTHER_LIVE = isset($familyStatusId->MOTHER_LIVE) ? $familyStatusId->MOTHER_LIVE :'';
                              ?>
                              <input type="checkbox" name="mother_live" disabled value="" <?php echo ($MOTHER_LIVE =='ស្លាប់' ? 'checked' : ''); ?> >ស្លាប់
                              <input type="checkbox" name="mother_live" disabled value="" <?php echo ($MOTHER_LIVE =='រស់' ? 'checked' : ''); ?> >រស់

                          </td>
                      </tr>

                      <tr>
                          <td style="width:150px;">ថ្ងៃខែឆ្នាំកំណើត</td>
                          <td style=" border: 1px solid #000">{{isset($familyStatusId->MOTHER_DOB) && $familyStatusId->MOTHER_DOB != '0000-00-00' && $familyStatusId->MOTHER_DOB != ''? $tool->dateformate($familyStatusId->MOTHER_DOB) : ''}}</td>
                          <td style="width:150px;text-align:right;">សញ្ជាតិ</td>
                          <td colspan="5" style=" border: 1px solid #000">
                              <label style="padding-left: 10px">1. {{isset($familyStatusId->MOTHER_NATIONALITY_1) ? $familyStatusId->MOTHER_NATIONALITY_1 : ''}}</label>
                              <label style="padding-left: 150px">2. {{isset($familyStatusId->MOTHER_NATIONALITY_2) ? $familyStatusId->MOTHER_NATIONALITY_2 : ''}}</label>
                          </td>

                      </tr>
                      <tr>
                          <td style="width:150px;">ទីលំនៅបច្ចុប្បន្ន</td>
                          <td colspan="7" style=" border: 1px solid #000">
                              {{isset($familyStatusId->MOTHER_ADDRESS) ? $familyStatusId->MOTHER_ADDRESS : ''}}
                          </td>

                      </tr>
                      <tr>
                          <td style="width:150px;">មុខរបរ</td>
                          <td style=" border: 1px solid #000">
                              {{isset($familyStatusId->MOTHER_JOB) ? $familyStatusId->MOTHER_JOB : ''}}
                          </td>
                          <td style="width:150px;text-align:right;">ស្ថាប័ន/អង្គភាព</td>
                          <td colspan="5" style=" border: 1px solid #000">
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
                              <td style="text-align:center">{{$tool->dayFormat($i++)}}</td>
                              <td>{{isset($value->RELATIVES_NAME_KH) ? $value->RELATIVES_NAME_KH : ''}}</td>
                              <td>{{isset($value->RELATIVES_NAME_EN) ? $value->RELATIVES_NAME_EN : ''}}</td>
                              <td>{{isset($value->RELATIVES_NAME_GENDER) ? $value->RELATIVES_NAME_GENDER : ''}}</td>
                              <td>{{isset($value->RELATIVES_NAME_DOB) && $value->RELATIVES_NAME_DOB !='0000-00-00' && $value->RELATIVES_NAME_DOB !="" ? $tool->dateformate($value->RELATIVES_NAME_DOB) : ''}}</td>
                              <td>{{isset($value->RELATIVES_NAME_JOB) ? $value->RELATIVES_NAME_JOB : ''}}</td>
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

                  <table width="100%" cellspacing="5px" cellpadding="3px" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;" >

                      <tr style="border:none">
                          <td style="width:15%;font-weight:normal;">ឈ្មោះប្តីឬប្រពន្ធ</td>
                          <td style="border: 1px solid #000;width:22%;">{{isset($familyStatusId->SPOUSE_NAME_KH) ? $familyStatusId->SPOUSE_NAME_KH : ''}}</td>
                          <td style="width:15%;font-weight:normal;text-align:right;">ជាអក្សរឡាតាំង</td>
                          <td style="border: 1px solid #000;width:25%;">{{isset($familyStatusId->SPOUSE_NAME_EN) ? $familyStatusId->SPOUSE_NAME_EN : ''}}</td>
                          <td style="width:18%;font-weight:normal">
                              <?php
                              $SPOUSE_LIVE = isset($familyStatusId->SPOUSE_LIVE) ? $familyStatusId->SPOUSE_LIVE:'';
                              ?>
                              <input type="checkbox" name="SPOUSE_LIVE" disabled value="" <?php echo ($SPOUSE_LIVE =='ស្លាប់' ? 'checked' : ''); ?> >ស្លាប់
                              <input type="checkbox" name="SPOUSE_LIVE" disabled value="" <?php echo ($SPOUSE_LIVE =='រស់' ? 'checked' : ''); ?> >រស់

                          </td>
                      </tr>
                      <tr>
                          <td style="width:15%;">ថ្ងៃខែឆ្នាំកំណើត</td>
                          <td style="border: 1px solid #000;">
                              {{isset($familyStatusId->SPOUSE_DOB) && $familyStatusId->SPOUSE_DOB != '0000-00-00' && $familyStatusId->SPOUSE_DOB != ''? $tool->dateformate($familyStatusId->SPOUSE_DOB) : ''}}
                          </td>
                          <td style="width:150px;text-align:right;">សញ្ជាតិ</td>
                          <td colspan="5" style="border: 1px solid #000;">
                              <label style="padding-left: 10px">
                                  1. {{isset($familyStatusId->SPOUSE_NATIONALITY_1) ? $familyStatusId->SPOUSE_NATIONALITY_1 : ''}}</label>
                              <label style="padding-left: 150px">
                                  2. {{isset($familyStatusId->SPOUSE_NATIONALITY_2) ? $familyStatusId->SPOUSE_NATIONALITY_2 : ''}}</label>
                          </td>

                      </tr>
                      <tr>
                          <td style="width:15%;">ទីកន្លែងកំណើត</td>
                          <td colspan="7" style=" border: 1px solid #000">
                              {{isset($familyStatusId->SPOUSE_POB) ? $familyStatusId->SPOUSE_POB : ''}}
                          </td>

                      </tr>

                  </table>
                  <table width="100%" cellspacing="5px" cellpadding="3px" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin-top:-5px;" >
                      <tr style="border:none">
                          <td style="width:15%;font-weight:normal;">មុខរបរ</td>
                          <td style="border: 1px solid #000;width:22%;text-align:left;">
                              {{isset($familyStatusId->SPOUSE_JOB) ? $familyStatusId->SPOUSE_JOB : ''}}
                          </td>
                          <td style="width:10%;font-weight:normal;text-align:right;">អង្គភាព</td>
                          <td style="border: 1px solid #000;width:25%;">
                              {{isset($familyStatusId->SPOUSE_UNIT) ? $familyStatusId->SPOUSE_UNIT : ''}}
                          </td>
                          <td style="width:30%;font-weight:normal;text-align:right;">
                              ប្រាក់ឧបត្ថម្ភ :
                              <?php
                              $SPOUSE_SPONSOR = isset($familyStatusId->SPOUSE_SPONSOR) ? $familyStatusId->SPOUSE_SPONSOR:'';
                              ?>
                              <input type="checkbox" name="SPOUSE_SPONSOR" disabled value="" <?php echo ($SPOUSE_SPONSOR =='មាន' ? 'checked' : ''); ?> >មាន
                              <input type="checkbox" name="SPOUSE_SPONSOR" disabled value="" <?php echo ($SPOUSE_SPONSOR =='គ្មាន' ? 'checked' : ''); ?> >គ្មាន
                          </td>
                      </tr>
                      <tr>
                          <td style="width:150px;">លេខទូរស័ព្ទ</td>
                          <td  colspan=7 style=" border: 1px solid #000">
                              @foreach($phoneNumber as $key =>$value)
                                  <label style="padding-right: 20px">{{isset($value) ? $value : ''}}</label>
                              @endforeach
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
                              <td style="text-align:center">{{$tool->dayFormat($i++)}}</td>
                              <td>{{isset($value->CHILDRENS_NAME_KH) ? $value->CHILDRENS_NAME_KH : ''}}</td>
                              <td>{{isset($value->CHILDRENS_NAME_EN) ? $value->CHILDRENS_NAME_EN : ''}}</td>
                              <td>{{isset($value->CHILDRENS_NAME_GENDER) ? $value->CHILDRENS_NAME_GENDER : ''}}</td>
                              <td>{{isset($value->CHILDRENS_NAME_DOB) && $value->CHILDRENS_NAME_DOB !='0000-00-00' && $value->CHILDRENS_NAME_DOB !=''? $tool->dateformate($value->CHILDRENS_NAME_DOB) : ''}}</td>
                              <td>{{isset($value->CHILDRENS_NAME_JOB) ? $value->CHILDRENS_NAME_JOB : ''}}</td>
                              <td style="text-align:center">
                                  <input type="radio" name="gender_{{$key}}" value="" <?php if(isset($value->CHILDRENS_NAME_SPONSOR) ? $value->CHILDRENS_NAME_SPONSOR : 'គ្មាន' == 'មាន' ){
                                      echo 'checked';
                                  } ?> >មាន
                                  <input type="radio" name="gender_{{$key}}" value="" <?php if(isset($value->CHILDRENS_NAME_SPONSOR) ? $value->CHILDRENS_NAME_SPONSOR : 'គ្មាន' == 'គ្មាន' ){
                                      echo "checked";
                                  } ?> >គ្មាន
                              </td>
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
      @else
          <p align="center" style="font-family: 'KHMERMEF2'; font-size: 60px;">ប្រវត្តិរូបមន្ត្រីរាជការមិនទាន់បានអនុម័ត</p>
      @endif
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

