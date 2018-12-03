<?php
use App\libraries\Tool;
$tool = new Tool();


$getSecreateByMinistryId = asset('/register/get-secretary-by-ministry-id');
$getdepartmentBySecId = asset('/register/get-department-by-secretary-id');
$getOfficeByDepartment = asset('/register/get-office-by-department-id');

$getDegreeReport = asset('/summary-all-form/select-report');

?>
<div  id="general-knowledge" ng-controller="summaryAllFormController">
    <!--start innerhead-->
	<div class="inner-head">
		<div id="wrap-search">
		</div>
		<nav aria-label="breadcrumb" >
            <ol class="breadcrumb kbach-title">
                <li class="breadcrumb-item"><a href="#">ទំព័រដើម</a></li>
                <li class="breadcrumb-item header-title active" aria-current="page">{{trans('trans.humance_resource')}}</li>
            </ol>
        </nav>
		<!-- <div class=" header-title">{{trans('trans.humance_resource')}}</div> -->
	</div>
	<!--end innerhead-->
    <!-- start inner-conten-->
    <div class="inner-content">
        <div class="row">
            <div class="wrap-head-container" style="">
                <div class="col-md-7 wrap-navbar" style="overflow:hidden">
                    <div class="navbar-nav module-heading" >
                        <ul class="nav nav-tabs">
                            <li class="{{isset($tab)?$tab==1 ?'active':'':''}}"><a href="#/edit-personal">{{trans('personal_info.request_to_update').trans('personal_info.biography')}}</a></li>
                            <li class="{{isset($tab)?$tab==2 ?'active':'':''}}"><a href="#/print-personal">{{trans('officer.print').trans('personal_info.biography')}}</a></li>
                            <li class="{{isset($tab)?$tab==3 ?'active':'':''}}"><a href="#/personal-report">{{trans('officer.export')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr style="position:relative;z-index:3;width:96%;border-top: 3px solid #eee;">
    <!-- end inner-conten-->
    <div>
        <div class="tab-content">
            <!--start tab1default-->
            <div class="tab-pane fade {{isset($tab)?$tab==1 ?'in active':'':''}}" id="tab1">
                @if($tab==1)
                <!--start innter content page-->
                <div class="page">
                <div id="Open_Form_Info" class="wrap-tab">
                    <div class="row show-grid blg-edit" id="FormPersonalInfoController">
                        <div class="col-md-12 shade-box ">
                            <div class="hdr-edit col-md-12 row sb-heading">
                                <p class="pull-left ttl-each">{{trans('personal_info.persional_info')}}</p>
                                <button type="button" ng-click="showPersonalInfo()" class="btn btn-lg btn-success btn-box-save pull-right btn-edit btnEdit" data-index="1" dataFormId="FormPersonalInfoController"><i class="fa fa-pencil"></i> {{trans('trans.buttonEdit')}}</button>
                            </div>
                            <div class="row clear col-md-12 body-edit">
                                <table class="tbl-edit-cont">
                                    <tr>
                                        <td>{{trans('officer.name')}} </td>
                                        <td id="SUMMARY_FULL_NAME_KH">{{ isset($personal_info->FULL_NAME_KH) ? $personal_info->FULL_NAME_KH : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('personal_info.official_id')}}</td>
                                        <td id="SUMMARY_PERSONAL_INFORMATION">{{ isset($personal_info->PERSONAL_INFORMATION) ? $personal_info->PERSONAL_INFORMATION : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('personal_info.official_id_card_of_mef')}}</td>
                                        <td id="SUMMARY_OFFICIAL_ID">{{ isset($personal_info->OFFICIAL_ID) ? $personal_info->OFFICIAL_ID : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('personal_info.unit_id')}}</td>
                                        <td id="SUMMARY_UNIT_CODE">{{ isset($personal_info->UNIT_CODE) ? $personal_info->UNIT_CODE : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.email')}}</td>
                                        <td id="SUMMARY_EMAIL">{{ isset($personal_info->EMAIL) ? $personal_info->EMAIL : '' }}</td>
                                    </tr>
                                </table>
                                {{--@include('front-end.background-staff-gov-info.personal-info')--}}
                                <div id="getPersonalInfo" class="blg-fade-edit">
                                    <div class="loading-waiting-template text-center">
                                        <img src="{{asset('jqwidgets/styles/images/loader.gif')}}" alt="" />
                                    </div>
                                </div>
                                <?php // Block Include ?>
                            </div><!--body edit-->
                        </div><!--sade-box-->
                    </div><!--blg-edit-->
                    <div class="row show-grid blg-edit" id="FormSituationPublicInfoController">
                        <div class="col-md-12 shade-box ">
                            <div class="hdr-edit col-md-12 row sb-heading">
                                <p class="pull-left ttl-each">{{trans('officer.work_situation')}}</p>
                                <button type="button" ng-click="showSituationPublicInfo()" class="btn btn-lg btn-success btn-box-save pull-right btn-edit btnEdit" data-index="2" dataFormId="FormSituationPublicInfoController"><i class="fa fa-pencil"></i> {{trans('trans.buttonEdit')}}</button>
                            </div>
                            <div class="row clear col-md-12 body-edit">
                                <table class="tbl-edit-cont">
                                    <tr>
                                        <td>{{trans('officer.class_rank')}}</td>
                                        <td id="SUMMARY_FIRST_OFFICER_CLASS">{{ isset($service_status_info->CURRENT_OFFICER_CLASS) ? $service_status_info->CURRENT_OFFICER_CLASS : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('trans.position')}}</td>
                                        <td id="SUMMARY_FIRST_POSITION">{{ isset($service_status_info->CURRENT_POSITION) ? $service_status_info->CURRENT_POSITION : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.centralMinistry')}}</td>
                                        <td id="SUMMARY_FIRST_MINISTRY">{{ isset($service_status_info->CURRENT_MINISTRY) ? $service_status_info->CURRENT_MINISTRY : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.working_place')}}</td>
                                        <td id="SUMMARY_FIRST_UNIT">{{ isset($service_status_info->CURRENT_GENERAL_DEPARTMENT ) ? $service_status_info->CURRENT_GENERAL_DEPARTMENT : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.department')}}</td>
                                        <td id="SUMMARY_FIRST_DEPARTMENT">{{ isset($service_status_info->CURRENT_DEPARTMENT) ? $service_status_info->CURRENT_DEPARTMENT : '' }}</td>
                                    </tr>
                                </table>
                                {{--@include('front-end.background-staff-gov-info.situation-public-info')--}}
                                <div id="getSituationPublicInfo" class="blg-fade-edit">
                                    <div class="loading-waiting-template text-center">
                                        <img src="{{asset('jqwidgets/styles/images/loader.gif')}}" alt="" />
                                    </div>
                                </div>
                                <?php // block Include ?>
                            </div>

                        </div><!--shade-box-->
                    </div><!--blg-edit-->
                    <div class="row show-grid blg-edit" id="FormWorkHistoryController">
                        <div class="col-md-12 shade-box ">
                            <div class="hdr-edit col-md-12 row sb-heading">
                                <p class="pull-left ttl-each">{{trans('officer.work_history')}} ({{trans('officer.please_fill_order_by_old_to_new')}})</p>
                                <button type="button" ng-click="showWorkingHistroy()" class="btn btn-lg btn-success btn-box-save pull-right btn-edit btnEdit" data-index="3" dataFormId="FormWorkHistoryController"><i class="fa fa-pencil"></i> {{trans('trans.buttonEdit')}}</button>
                            </div>
                            <div class="row clear col-md-12 body-edit">
                                <table class="tbl-edit-cont">
                                    <tr>
                                        <td>{{trans('officer.start_working_date')}}</td>
                                        <td id="SUMMARY_START_WORKING_DATE_0">{{ isset($work_history->START_WORKING_DATE) ? $work_history->START_WORKING_DATE : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.end_working_date')}}</td>
                                        <td id="SUMMARY_END_WORKING_DATE_0">{{ isset($work_history->END_WORKING_DATE) ? $work_history->END_WORKING_DATE : 'បច្ចុប្បន្ន' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.centralMinistry')}}</td>
                                        <td id="SUMMARY_DEPARTMENT_0">{{ isset($work_history->MINISTRY) ? $work_history->MINISTRY : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.working_place')}}</td>
                                        <td id="SUMMARY_INSTITUTION_0">{{ isset($work_history->INSTITUTION) ? $work_history->INSTITUTION : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('trans.position')}}</td>
                                        <td id="SUMMARY_POSITION_0">{{ isset($work_history->POSITION) ? $work_history->POSITION : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.position_equal_to')}}</td>
                                        <td id="SUMMARY_POSITION_EQUAL_TO_0">{{ isset($work_history->POSITION_EQUAL_TO) ? $work_history->POSITION_EQUAL_TO : '' }}</td>
                                    </tr>

                                </table>
                                {{--@include('front-end.background-staff-gov-info.working-history')--}}
                                <div id="getWorkingHistroy" class="blg-fade-edit">
                                    <div class="loading-waiting-template text-center">
                                        <img src="{{asset('jqwidgets/styles/images/loader.gif')}}" alt="" />
                                    </div>
                                </div>
                                <?php // Block Include ?>
                            </div>
                        </div><!--shade-box-->
                    </div><!--blg-edit-->
                    <div class="row show-grid blg-edit" id="FormAwardSanctionController">
                        <div class="col-md-12 shade-box ">
                            <div class="hdr-edit col-md-12 row sb-heading">
                                <p class="pull-left ttl-each">{{trans('officer.appreciation_award_sanctions')}}</p>
                                <button type="button" ng-click="showAwardSanction()" class="btn btn-lg btn-success btn-box-save pull-right btn-edit btnEdit" data-index="4" dataFormId="FormAwardSanctionController"><i class="fa fa-pencil"></i> {{trans('trans.buttonEdit')}}</button>
                            </div>
                            <div class="row clear col-md-12 body-edit">

                                <table class="tbl-edit-cont">
                                    <tr>
                                        <td>{{trans('officer.document_number')}}</td>
                                        <td id="SUMMARY_AWARD_NUMBER">{{ isset($appreciation_award->AWARD_NUMBER) ? $appreciation_award->AWARD_NUMBER : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.date')}}</td>
                                        <td id="SUMMARY_AWARD_DATE_TYPE_1_0">{{ isset($appreciation_award->AWARD_DATE) ? $appreciation_award->AWARD_DATE : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.appreciate_unit')}} ({{trans('officer.request')}})</td>
                                        <td id="SUMMARY_AWARD_REQUEST_DEPARTMENT_TYPE_1_0">{{ isset($appreciation_award->AWARD_REQUEST_DEPARTMENT) ? $appreciation_award->AWARD_REQUEST_DEPARTMENT : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.meaning')}}</td>
                                        <td id="SUMMARY_AWARD_DESCRIPTION">{{ isset($appreciation_award->AWARD_DESCRIPTION) ? $appreciation_award->AWARD_DESCRIPTION : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.type')}}</td>
                                        <td id="SUMMARY_AWARD_KIND">{{ isset($appreciation_award->AWARD_KIND) ? $appreciation_award->AWARD_KIND : '' }}</td>
                                    </tr>
                                </table>
                                {{--@include('front-end.background-staff-gov-info.award-sanctions')--}}
                                <div id="getAwardSanction" class="blg-fade-edit">
                                    <div class="loading-waiting-template text-center">
                                        <img src="{{asset('jqwidgets/styles/images/loader.gif')}}" alt="" />
                                    </div>
                                </div>
                                <?php // Block Include ?>
                            </div>
                        </div><!--shade-box-->
                    </div><!--blg-edit-->
                    <div class="row show-grid blg-edit" id="FormGeneralKnowledge">
                        <div class="col-md-12 shade-box ">
                            <div class="hdr-edit col-md-12 row sb-heading">
                                <p class="pull-left ttl-each">{{trans('officer.general_knowlegde')}}</p>
                                <button ng-click="showGeneralKnowledge()" type="button" class="btn btn-lg btn-success btn-box-save pull-right btn-edit btnEdit" data-index="5" dataFormId="FormGeneralKnowledge"><i class="fa fa-pencil"></i> {{trans('trans.buttonEdit')}}</button>
                            </div>
                            <div class="row clear col-md-12 body-edit">
                                <table class="tbl-edit-cont">
                                    <tr>
                                        <td>{{trans('officer.level')}}</td>
                                        <td id="SUMMARY_KNOWLEDGE_G_LEVEL">{{ isset($general_qualification->LEVEL) ? $general_qualification->LEVEL : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.place')}}</td>
                                        <td id="SUMMARY_KNOWLEDGE_G_PLACE">{{ isset($general_qualification->PLACE) ? $general_qualification->PLACE : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.graduation_major')}}</td>
                                        <td id="SUMMARY_KNOWLEDGE_G_GRADUATION_MAJOR">{{ isset($general_qualification->LEVEL) ? $general_qualification->LEVEL : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.start_date_study')}}</td>
                                        <td id="SUMMARY_KNOWLEDGE_G_START_DATA">{{ isset($general_qualification->Q_START_DATE) ? $general_qualification->Q_START_DATE : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.end_date_study')}}</td>
                                        <td id="SUMMARY_KNOWLEDGE_G_END_DATA">{{ isset($general_qualification->Q_END_DATE) ? $general_qualification->Q_END_DATE : '' }}</td>
                                    </tr>
                                </table>
                                {{--@include('front-end.background-staff-gov-info.general-knowledge')--}}
                                <div id="getGeneralKnowledge" class="blg-fade-edit">
                                    <div class="loading-waiting-template text-center">
                                        <img src="{{asset('jqwidgets/styles/images/loader.gif')}}" alt="" />
                                    </div>
                                </div>
                                <?php // Block Include  ?>
                            </div>
                        </div><!--shade-box-->
                    </div><!--blg-edit-->
                    <div class="row show-grid blg-edit" id="FormAbilityForeign">
                        <div class="col-md-12 shade-box ">
                            <div class="hdr-edit col-md-12 row sb-heading">
                                <p class="pull-left ttl-each">{{trans('officer.ability_foreign_language')}}</p>
                                <button ng-click="showAbilityForeignLanguage()" type="button" class="btn btn-lg btn-success btn-box-save pull-right btn-edit btnEdit" data-index="6" dataFormId="FormAbilityForeign"><i class="fa fa-pencil"></i> {{trans('trans.buttonEdit')}}</button>
                            </div>
                            <div class="row clear col-md-12 body-edit">
                                <table class="tbl-edit-cont">
                                    <tr>
                                        <td>{{trans('officer.language')}}</td>
                                        <td id="SUMMARY_LANGUAGE_0">{{ isset($ability_foreign_language->LANGUAGE) ? $ability_foreign_language->LANGUAGE : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.read')}}</td>
                                        <td id="SUMMARY_READING_LEVEL_0">{{ isset($ability_foreign_language->RED) ? $ability_foreign_language->RED : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.write')}}</td>
                                        <td id="SUMMARY_WRITING_LEVEL_0">{{ isset($ability_foreign_language->WRITE) ? $ability_foreign_language->WRITE : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.speak')}}</td>
                                        <td id="SUMMARY_SPEAKING_LEVEL_0">{{ isset($ability_foreign_language->SPEAK) ? $ability_foreign_language->SPEAK : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.listen')}}</td>
                                        <td id="SUMMARY_LISTENING_LEVEL_0">{{ isset($ability_foreign_language->LISTEN) ? $ability_foreign_language->LISTEN : '' }}</td>
                                    </tr>
                                </table>
                                {{--@include('front-end.background-staff-gov-info.ability-foreign')--}}
                                <div id="getAbilityForeignLanguage" class="blg-fade-edit">
                                    <div class="loading-waiting-template text-center">
                                        <img src="{{asset('jqwidgets/styles/images/loader.gif')}}" alt="" />
                                    </div>
                                </div>
                                <?php // Block Include ?>
                            </div>
                        </div><!--shade-box-->
                    </div><!--blg-edit-->
                    <div class="row show-grid blg-edit" id="FormFamilySituation">
                        <div class="col-md-12 shade-box ">
                            <div class="hdr-edit col-md-12 row sb-heading">
                                <p class="pull-left ttl-each">{{trans('officer.family_situation')}}</p>
                                <button ng-click="showFamilySituations()" type="button" class="btn btn-lg btn-success btn-box-save pull-right btn-edit btnEdit" data-index="7" dataFormId="FormFamilySituation"><i class="fa fa-pencil"></i> {{trans('trans.buttonEdit')}}</button>
                            </div>
                            <div class="row clear col-md-12 body-edit">

                                <table class="tbl-edit-cont">
                                    <tr>
                                        <td>{{trans('officer.father_name_kh')}}</td>
                                        <td id="SUMMARY_FATHER_NAME_KH">{{ isset($family_situation->FATHER_NAME_KH) ? $family_situation->FATHER_NAME_KH : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.father_name_en')}}</td>
                                        <td id="SUMMARY_FATHER_NAME_EN">{{ isset($family_situation->FATHER_NAME_EN) ? $family_situation->FATHER_NAME_EN : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.father_dob')}}</td>
                                        <td id="SUMMARY_DATE_OF_BIRTH">{{ isset($family_situation->FATHER_DOB) ? $family_situation->FATHER_DOB : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.father_address')}}</td>
                                        <td id="SUMMARY_FATHER_ADDRESS">{{ isset($family_situation->FATHER_ADDRESS) ? $family_situation->FATHER_ADDRESS : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('officer.father_job')}}</td>
                                        <td id="SUMMARY_FATHER_JOB">{{ isset($family_situation->FATHER_JOB) ? $family_situation->FATHER_JOB : '' }}</td>
                                    </tr>
                                </table>
                                {{--@include('front-end.background-staff-gov-info.family-situation')--}}
                                <div id="getFamilySituations" class="blg-fade-edit">
                                    <div class="loading-waiting-template text-center">
                                        <img src="{{asset('jqwidgets/styles/images/loader.gif')}}" alt="" />
                                    </div>
                                </div>
                                <?php // Block Include ?>
                            </div>
                        </div><!--shade-box-->
                    </div><!--blg-edit-->
                </div>
                </div>
                <!--finish innter content page-->
                @endif
            </div>
            <!--finish tab1default-->
            <div class="tab-pane fade {{isset($tab)?$tab==2 ?' in active':'':''}}" id="tab2">
                <!--start innter content page-->

                @if($tab==2)
                <div class="page">
                    <div id="Past_Form_Info" class="tabcontent">
                    <div style="z-index:9;position: absolute; right: 2%;">
                        <a href="{{ url('summary-all-form/detail') }}"  class="btn btn-box-save btn-default">បោះពុម្ព</a>
                    </div>
                    <div>
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
                            <table style="width:100%;position:relative">
                                <tr>
                                    <td style="width:20%;">
                                        <img src="{{asset('images/mef-logo.png')}}" width="43%;" style="font-family:'KHMERMEF2';position:relative;left:25px;">
                                        <table><tr><td style="font-family:'KHMERMEF2';font-size:13px" >{{trans('trans.institude_name_kh')}} <br/>{{trans('officer.working_place')}}:{{isset($serviceStatusCurrentIdApprove->CURRENT_GENERAL_DEPARTMENTED) ? $serviceStatusCurrentIdApprove->CURRENT_GENERAL_DEPARTMENTED : "​ "}}</td></tr></table>
                                    </td>
                                    {{--show images--}}
                                    <td style="width:50%;position:relative">
                                        <table style="font-family:'KHMERMEF1';font-size:9px;text-align:center" >
                                            <tr>
                                                <td style="width:92px;height:118px;position:absolute;right:65px;top:20px;padding-top:5px;">
                                                    <div style="width: 125px; height: auto">
                                                        <img class="img-responsive" src="{{ asset($rowApprove->AVATAR) }}" >
                                                    </div>

                                                </td>
                                                <br />
                                                <td style="position:absolute;right:0px;top:165px;font-family:'automation';font-size:12px">
                                                    <div id="barcode">{!! isset($personalInfoApprove->ID) ? $personalInfoApprove->ID:0 !!}</div>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table style="width:100%;">
                                <tr>
                                    <table style="text-align:center;font-family:'KHMERMEF2';position:relative;font-size:13px;width:100%; top: -25px; background: none;">
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
                                    <td style="font-family:'KHMERMEF1';width:20%;font-size:12px">
                                        {{trans('personal_info.official_id')}}
                                    </td>
                                    <td style="font-size:12px;margin-left:42px;border:1px solid #000;padding:5px 5px;letter-spacing:2px;height:30px;min-width: 265px;display:inline-block;vertical-align:middle;font-family:'KHMERMEF1';">{{isset($rowApprove->PERSONAL_INFORMATION) ? $rowApprove->PERSONAL_INFORMATION : "​ "}}</td>
                                    <td style="font-family:'KHMERMEF1';width:43%;font-size:12px;text-align:right; position: relative; top: -5px;">
                                        {{trans('personal_info.official_id_card_of_mef')}}
                                        <table style="display:inline-block;margin-left:10px;vertical-align:middle;text-align:left;"><tr><td style="border:1px solid #000;padding:0 5px;letter-spacing:2px;height:25px;min-width:50px;">{{isset($rowApprove->OFFICIAL_ID) ? $rowApprove->OFFICIAL_ID : "​ "}}</td></tr></table>
                                    </td>
                                    <td style="font-family:'KHMERMEF1';width:35%;font-size:12px;text-align:right;">
                                        {{trans('personal_info.unit_id')}}
                                        <table style="display:inline-block;margin-left:10px;vertical-align:middle;float:right;text-align:left;position: relative; top: -5px;"><tr><td style="border:1px solid #000;padding:0 5px;letter-spacing:2px;height:25px;min-width:50px;">{{ isset($rowApprove->UNIT_CODE) ? $rowApprove->UNIT_CODE : "​ "}}</td></tr></table>
                                    </td>
                                </tr>
                            </table>
                            <table style="width:100%">
                                <tr>
                                    <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;">
                                        {{trans('officer.full_name')}}
                                    </td>
                                    <td style="width:35%;"><table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:79%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'"><tr><td>{{isset($rowApprove->FULL_NAME_KH) ? $rowApprove->FULL_NAME_KH : "​ "}}</td></tr></table></td>
                                    <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right;padding-right:5px;">
                                        {{trans('officer.english_name')}}
                                    </td>
                                    <td style="width:35%;"><table style="display:inline-block;border: 1px solid #000;vertical-align:middle;width:97%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1';float: right;"><tr><td>{{ isset($rowApprove->FULL_NAME_EN) ? $rowApprove->FULL_NAME_EN : "​ "}}</td></tr></table></td>
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
                                        <table style="display:inline-block; border: 1px solid #000;vertical-align:middle;width:54.5%;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'"><tr><td>{{$DOB !=null && $DOB !='0000-00-00' && $DOB != '' ? $tool->dateformate($DOB) : "​ "}}</td>
                                            </tr></table>
                                    </td>
                                    <td style="font-size:12px;font-family:'KHMERMEF1';">
                                        <?php
                                        $MARRIED = isset($rowApprove->MARRIED) ? $rowApprove->MARRIED:'';
                                        ?>
                                        <table style="display:inline-block;vertical-align:middle;text-align:right;width:103%"><tr>
                                                <td style="font-size:12px;position:relative;right:3%;line-height:1.5;position:relative;left:-19px;"><input type="checkbox" style="vertical-align:middle;float:left;" disabled value="" <?php echo ($MARRIED== 1 ? 'checked': '') ?> >{{trans('personal_info.singal')}}</td>
                                                <td>{{trans('personal_info.nationaley')}}</td></tr></table>
                                    </td>
                                    <td style="width:35%;font-family:'KHMERMEF1'">
                                        <table style="display:inline-block;border: 1px solid #000;vertical-align:middle;width:97%;font-size:12px;line-height:1.8;padding-left:5px;float: right;"><tr>
                                                <?php
                                                $NATIONALITY_1 = isset($rowApprove->NATIONALITY_1) ? $rowApprove->NATIONALITY_1:'';
                                                $NATIONALITY_2 = isset($rowApprove->NATIONALITY_2) ? $rowApprove->NATIONALITY_2:'';
                                                ?>
                                                <td>1. {{$NATIONALITY_1 !=null ? $NATIONALITY_1 : "​ "}}</td>
                                                <td style="padding-left:100px;">2. {{$NATIONALITY_2 !=null ? $NATIONALITY_2 : "​ "}}</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table style="width:99.8%">
                                <tr>
                                    <?php
                                    $POB = isset($rowApprove->PLACE_OF_BIRTH) ? $rowApprove->PLACE_OF_BIRTH:'';
                                    ?>
                                    <td style="width:18%;font-size:12px;font-family:'KHMERMEF1';">
                                        {{trans('personal_info.place_of_birth')}}
                                    </td>
                                    <td style="margin-left:10px; border: 1px solid #000;vertical-align:middle;width:82%;font-size:12px;box-sizing:border-box;line-height:2.5;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{$POB != null ? $POB : "​​ "}}
                                    </td>
                                </tr>
                            </table>
                            <table style="width:99.8%;margin-top:2px;">
                                <tr>
                                    <td style="width:18%;font-size:12px;font-family:'KHMERMEF1';">
                                        {{trans('officer.address')}}
                                    </td>
                                    <td style="width:80%;margin-left:10px; border: 1px solid #000;vertical-align:middle;width:98%;font-size:12px;box-sizing:border-box;line-height:2.5;padding-left:5px;font-family:'KHMERMEF1'">
                                        ​ផ្ទះលេខ {{isset($currentAddressApprove->house) ? $currentAddressApprove->house : "​"}}
                                        ​ផ្លូវលេខ {{isset($currentAddressApprove->street) ? $currentAddressApprove->street : "​"}}
                                        ​{{isset($currentAddressApprove->villages) ? $currentAddressApprove->villages : "​"}}
                                        {{isset($currentAddressApprove->commune) ? $currentAddressApprove->commune : ""}}
                                        {{isset($currentAddressApprove->districts) ? $currentAddressApprove->districts : "​"}}
                                        {{isset($currentAddressApprove->province) ? $currentAddressApprove->province : ""}}
                                    </td>
                                </tr>
                            </table>
                            <table style="width:100%">
                                <tr>
                                    <td style="width:45%">
                                        <table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';vertical-align:middle;width:29%;margin-left:-2px;"><tr><td>{{trans('officer.email')}}</td></tr></table>
                                        <table style="float:right;display:inline-block;border: 1px solid #000; vertical-align:middle;width:65.5%;font-size:12px;box-sizing:border-box;line-height:2.2;padding-left:3px;font-family:'KHMERMEF1'"><tr><td>{{ isset($rowApprove->EMAIL) ? $rowApprove->EMAIL : "​ "}}</td></tr></table>
                                    </td>
                                    <td style="width:40%;text-align: right;">
                                        <table style="display:inline-block;font-size:12px;font-family:'KHMERMEF1';vertical-align:middle;"><tr><td>{{trans('officer.phone_number')}}</td></tr></table>
                                        <table style="display:inline-block;border: 1px solid #000; vertical-align:middle;width:78%;font-size:12px;box-sizing:border-box;padding-left:5px;">
                                            <tr>
                                                <td style="line-height:1.8;width:8%;text-align:left;">
                                                    1. {{ isset($rowApprove->PHONE_NUMBER_1) ? $rowApprove->PHONE_NUMBER_1 : "​ "}}
                                                </td>
                                                <td style="padding-left:3%;width:8%;text-align:left;">
                                                    2. {{ isset($rowApprove->PHONE_NUMBER_2) ? $rowApprove->PHONE_NUMBER_2 : " "}}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table style="width:99.8%;margin-top:-2px;">
                                <tr>
                                    <td style="font-family:'KHMERMEF1';width:18%;vertical-align:middle;font-size:12px;vertical-align:middle;">{{trans('personal_info.identity_card')}}

                                    </td>
                                    <td style="width:34.6%;font-size:12px; border: 1px solid #000;padding-left:5px;font-family:'KHMERMEF1'">{{ isset($rowApprove->NATION_ID) ? $rowApprove->NATION_ID : "​ "}}</td>
                                    <td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;text-align:right;padding-right:5px;">
                                        {{trans('personal_info.deadline')}}
                                    </td>
                                    <?php
                                    $NATION_ID_EXPIRED_DATE = isset($rowApprove->NATION_ID_EXPIRED_DATE) ? $rowApprove->NATION_ID_EXPIRED_DATE: '';
                                    ?>
                                    <td style="width:34%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;text-align:center;font-family:'KHMERMEF1'">{{$NATION_ID_EXPIRED_DATE !=null && $NATION_ID_EXPIRED_DATE !='0000-00-00' && $NATION_ID_EXPIRED_DATE !='' ? $tool->dateformate($NATION_ID_EXPIRED_DATE) : "​ "}}</td>
                                </tr>
                            </table>
                            <table style="width:99.8%;margin-top:1px;">
                                <tr>
                                    <td style="font-family:'KHMERMEF1';width:18%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                                        {{trans('personal_info.passport')}}
                                    </td>
                                    <td style="width:34.6%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:2px;padding-left:5px;font-family:'KHMERMEF1'">{{ isset($rowApprove->PASSPORT_ID) ? $rowApprove->PASSPORT_ID : "​ "}}</td>
                                    <td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                                        {{trans('personal_info.deadline')}}
                                    </td>
                                    <?php
                                    $PASSPORT_ID_EXPIRED_DATE = isset($rowApprove->PASSPORT_ID_EXPIRED_DATE) ? $rowApprove->PASSPORT_ID_EXPIRED_DATE:'';
                                    ?>
                                    <td style="width:34%;font-size:12px; border: 1px solid #000;line-height:2.2;padding-left:2px;padding-left:5px;text-align:center;font-family:'KHMERMEF1'">{{$PASSPORT_ID_EXPIRED_DATE !=null && $PASSPORT_ID_EXPIRED_DATE != '0000-00-00' && $PASSPORT_ID_EXPIRED_DATE !='' ? $tool->dateformate($PASSPORT_ID_EXPIRED_DATE) : "​ "}}</td>
                                </tr>
                            </table>
                            <table style="width:99.8%">
                                <tr>
                                    <td>
                                        <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-bottom:0;font-size:12px;">២-{{trans('officer.work_situation')}}</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 style="margin-bottom: 7px;padding-top: 10px;font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;margin-bottom:0;font-size:12px;">ក.ចូលបម្រើការងាររដ្ឋដំបូង</h5>
                                    </td>
                                </tr>
                            </table>
                            <table style="width:99.8%">
                                <tr>
                                    <td style="font-family:'KHMERMEF1';width:25%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                                        កាលបរិច្ឆេទប្រកាសចូលបម្រើការងាររដ្ឋដំបូង

                                    </td>
                                    <td style="width:27.1%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;text-align:center;font-family:'KHMERMEF1'">{{isset($serviceStatusInfoIdApprove->FIRST_START_WORKING_DATE_FOR_GOV) && $serviceStatusInfoIdApprove->FIRST_START_WORKING_DATE_FOR_GOV != '0000-00-00' && $serviceStatusInfoIdApprove->FIRST_START_WORKING_DATE_FOR_GOV !='' ? $tool->dateformate($serviceStatusInfoIdApprove->FIRST_START_WORKING_DATE_FOR_GOV)  : "​ "}}</td>
                                    <td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                                        កាលបរិច្ឆេទតាំងស៊ប់
                                    </td>

                                    <td style="width:35%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;text-align:center;font-family:'KHMERMEF1'">{{isset($serviceStatusInfoIdApprove->FIRST_GET_OFFICER_DATE) && $serviceStatusInfoIdApprove->FIRST_GET_OFFICER_DATE != '0000-00-00' && $serviceStatusInfoIdApprove->FIRST_GET_OFFICER_DATE != ''? $tool->dateformate($serviceStatusInfoIdApprove->FIRST_GET_OFFICER_DATE) : "​ "}}</td>
                                </tr>
                            </table>
                            <table style="width:99.8%">
                                <tr>
                                    <td style="font-family:'KHMERMEF1';width:25%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                                        ក្របខ័ណ្ឌឋានន្តរស័ក្តិ និងថ្នាក់
                                    </td>
                                    <td style="width:27%;font-size:12px;line-height:2;padding-left:5px;border:1px solid #000;padding:0 5px;letter-spacing:2px;font-family:'KHMERMEF1'">{{isset($serviceStatusInfoIdApprove->className) ? $serviceStatusInfoIdApprove->className : "​ "}}</td>
                                    <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                                        មុខតំណែង
                                    </td>
                                    <td style="width:35%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusInfoIdApprove->positionName) ? $serviceStatusInfoIdApprove->positionName : "​ "}}
                                    </td>
                                </tr>
                            </table>
                            <table style="width:99.8%">
                                <tr>
                                    <td style="font-family:'KHMERMEF1';width:25%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                                        ក្រសួង/ស្ថាប័ន
                                    </td>
                                    <td style="width:27%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusInfoIdApprove->ministryName) ? $serviceStatusInfoIdApprove->ministryName : "​ "}}
                                    </td>
                                    <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                                        អង្គភាព
                                    </td>
                                    <td style="width:35%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusInfoIdApprove->secretariteName) ? $serviceStatusInfoIdApprove->secretariteName : "​ "}}</td>
                                </tr>
                            </table>
                            <table style="width:99.8%">
                                <tr>
                                    <td style="font-family:'KHMERMEF1';width:25%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                                        នាយកដ្ឋាន/អង្គភាព/មន្ទីរ
                                    </td>
                                    <td style="width:27%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusInfoIdApprove->departmentName) ? $serviceStatusInfoIdApprove->departmentName : "​ "}}
                                    </td>
                                    <td style="font-family:'KHMERMEF1';width:15%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                                        ការិយាល័យ
                                    </td>
                                    <td style="width:35%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusInfoIdApprove->OfficeName) ? $serviceStatusInfoIdApprove->OfficeName : "​ "}}
                                    </td>
                                </tr>
                            </table>
                            <table style="width:99.8%">
                                <tr>
                                    <td>
                                        <h5 style="padding-top: 10px;font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;margin-bottom:10px;font-size:12px;">ខ.ស្ថានភាពការងារបច្ចុប្បន្ន</h5>
                                    </td>
                                </tr>
                            </table>
                            <table style="width:99.8%">
                                <tr>
                                    <td style="font-family:'KHMERMEF1';width:17%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                                        ក្របខ័ណ្ឌ ឋានន្តរស័ក្តិ និងថ្នាក់
                                    </td>
                                    <td style="width:17.7%;font-size:12px; border: 1px solid #000;line-height:2.6;padding-left:5px;letter-spacing:2px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusCurrentIdApprove->CURRENT_OFFICER_CLASSED) ? $serviceStatusCurrentIdApprove->CURRENT_OFFICER_CLASSED : "​ "}}
                                    </td>
                                    <td style="font-family:'KHMERMEF1';width:20%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                                        កាលបរិច្ឆេទប្តូរក្របខ័ណ្ឌ ឋានន្តរស័ក្តិ និងថ្នាក់  ចុងក្រោយ
                                    </td>
                                    <td style="width:12%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'; text-align: center">
                                        {{isset($serviceStatusCurrentIdApprove->CURRETN_PROMOTE_OFFICER_DATE) && $serviceStatusCurrentIdApprove->CURRETN_PROMOTE_OFFICER_DATE != '0000-00-00' && $serviceStatusCurrentIdApprove->CURRETN_PROMOTE_OFFICER_DATE != '' ? $tool->dateformate($serviceStatusCurrentIdApprove->CURRETN_PROMOTE_OFFICER_DATE) : "​ "}}
                                    </td>
                                </tr>
                            </table>

                            <table style="width:99.8%">
                                <tr>
                                    <td style="font-family:'KHMERMEF1';width:25.3%;vertical-align:middle;font-size:12px;vertical-align:middle;">
                                        មុខតំណែង
                                    </td>
                                    <td style="width:26.6%;font-size:12px; border: 1px solid #000;line-height:2.5;padding-left:5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusCurrentIdApprove->CURRENT_POSITIONED) ? $serviceStatusCurrentIdApprove->CURRENT_POSITIONED : "​ "}}
                                    </td>
                                    <td style="font-family:'KHMERMEF1';width:30%;vertical-align:middle;font-size:12px;text-align:right;padding-right:3px;">
                                        កាលបរិច្ឆេទទទួលមុខតំណែងចុងក្រោយ
                                    </td>
                                    <td style="width:23%;font-size:12px; border: 1px solid #000;line-height:2;padding-left:5px;font-family:'KHMERMEF1'; text-align:center;">
                                        {{isset($serviceStatusCurrentIdApprove->CURRENT_GET_OFFICER_DATE) && $serviceStatusCurrentIdApprove->CURRENT_GET_OFFICER_DATE != '0000-00-00' && $serviceStatusCurrentIdApprove->CURRENT_GET_OFFICER_DATE != '' ? $tool->dateformate($serviceStatusCurrentIdApprove->CURRENT_GET_OFFICER_DATE) : "​ "}}
                                    </td>
                                </tr>
                            </table>
                            <table style="width:99.8%">
                                <tr>
                                    <td style="width:30%;font-size:12px;font-family:'KHMERMEF1';">
                                        អគ្គលេខាធិការដ្ឋាន/អគ្គនាយកដ្ឋាន/អគ្គាធិការដ្ឋាន/វិទ្យាស្ថាន
                                    </td>
                                    <td style="width:55%;margin-left:10px; border: 1px solid #000;vertical-align:middle;width:98%;font-size:12px;box-sizing:border-box;line-height:2.2;padding:3px 0 3px 5px;font-family:'KHMERMEF1'">
                                        {{isset($serviceStatusCurrentIdApprove->CURRENT_GENERAL_DEPARTMENTED) && $serviceStatusCurrentIdApprove->CURRENT_GENERAL_DEPARTMENTED !="" ? $serviceStatusCurrentIdApprove->CURRENT_GENERAL_DEPARTMENTED : "​ "}}
                                    </td>
                                </tr>
                            </table>
                            <table style="width:99.8%">
                                <tr>
                                    <td style="font-family:'KHMERMEF1';width:25%;vertical-align:middle;font-size:12px;">
                                        នាយកដ្ឋាន/អង្គភាព/មន្ទីរ
                                    </td>
                                    <td style="width:28%;margin-left:10px; border: 1px solid #000;vertical-align:middle;font-size:12px;line-height:1.8;padding-left:5px;font-family:'KHMERMEF1'">{{isset($serviceStatusCurrentIdApprove->CURRENT_DEPARTMENTED) ? $serviceStatusCurrentIdApprove->CURRENT_DEPARTMENTED : "​ "}}
                                    </td>
                                    <td style="font-family:'KHMERMEF1';width:12%;vertical-align:middle;font-size:12px;text-align:right">
                                        ការិយាល័យ
                                    </td>
                                    <td style="width:35%;"><table style="display:inline-block;margin-left:10px; border: 1px solid #000;vertical-align:middle;width: 97%;font-size:12px;line-height:1.8;padding-left:2px;font-family:'KHMERMEF1'">
                                            <tr>
                                                <td>
                                                    {{isset($serviceStatusCurrentIdApprove->CURRENT_OFFICED) ? $serviceStatusCurrentIdApprove->CURRENT_OFFICED : "​ "}}
                                                </td>
                                            </tr>
                                        </table></td>
                                </tr>
                            </table>

                            <div style="line-break: loose;page-break-before: always">
                                <table style="width:99.8%">
                                    <tr>
                                        <td>
                                            <h5 style="margin-bottom: 10px;padding-top: 10px;font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;font-size:12px;">គ.តួនាទីបន្ថែមលើមុខងារបច្ចុប្បន្ន (ឋានៈស្មើ)</h5>
                                        </td>
                                    </tr>
                                </table>
                                <table style="width:99.8%">
                                    <tr>
                                        <td style="font-family:'KHMERMEF1';width:16%;font-size:12px">
                                            កាលបរិច្ឆេទចូល
                                        </td>
                                        <td style=" border: 1px solid #000;vertical-align:middle;width:20%;font-size:12px;line-height:2.5;font-family:'KHMERMEF1';padding-left:5px">
                                            {{isset($serviceStatusAdditioanlIdApprove->ADDITIONAL_WORKING_DATE_FOR_GOV) && $serviceStatusAdditioanlIdApprove->ADDITIONAL_WORKING_DATE_FOR_GOV !='0000-00-00' && $serviceStatusAdditioanlIdApprove->ADDITIONAL_WORKING_DATE_FOR_GOV !='' ? $tool->dateformate($serviceStatusAdditioanlIdApprove->ADDITIONAL_WORKING_DATE_FOR_GOV) : "​ "}}
                                        </td>
                                        <td style="font-family:'KHMERMEF1';width:10%;font-size:12px;text-align:right;padding-right:10px;">
                                            មុខតំណែង
                                        </td>
                                        <td style=" border: 1px solid #000;vertical-align:middle;width:25%;font-size:12px;line-height:1.8;font-family:'KHMERMEF1';padding-left:5px">
                                            {{isset($serviceStatusAdditioanlIdApprove->additionalPosition) ? $serviceStatusAdditioanlIdApprove->additionalPosition : "​ "}}
                                        </td>
                                        <td style="font-family:'KHMERMEF1';width:10%;font-size:12px;text-align:right;padding-right:10px;">
                                            ឋានៈស្មើ
                                        </td>
                                        <td style=" border: 1px solid #000;vertical-align:middle;width:20%;font-size:12px;line-height:1.8;font-family:'KHMERMEF1';padding-left:5px">
                                            {{isset($serviceStatusAdditioanlIdApprove->ADDITINAL_STATUS) ? $serviceStatusAdditioanlIdApprove->ADDITINAL_STATUS : "​ "}}
                                        </td>
                                    </tr>

                                </table>
                                <table style="width:99.8%">
                                    <tr>
                                        <td style="width:16%;font-size:12px;font-family:'KHMERMEF1';">
                                            អង្គភាព
                                        </td>
                                        <td style="margin-left:10px; border: 1px solid #000;vertical-align:middle;width:98%;font-size:12px;box-sizing:border-box;line-height:2.4;padding-left:3px;font-family:'KHMERMEF1'">
                                            {{isset($serviceStatusAdditioanlIdApprove->ADDITINAL_UNIT) && $serviceStatusAdditioanlIdApprove->ADDITINAL_UNIT !="" ? $serviceStatusAdditioanlIdApprove->ADDITINAL_UNIT : "​ "}}
                                        </td>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <td>
                                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:10px;font-size:12px;line-break: loose;"> ឃ.ស្ថានភាពស្ថិតនៅក្រៅក្របខ័ណ្ឌដើម</h5>
                                        </td>
                                    </tr>
                                </table>
                                <table  width="99.8%" border="1" cellpadding="5" cellspacing="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center; border: 1px solid #000000">
                                    <tr style="padding: 5ppx;">
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
                                    <?php $i = 1 ?>
                                    @foreach($situationOutsideIdApprove as $key => $value)
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
                                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:15px;padding-left:35px;margin-bottom:10px;font-size:12px;"> ង.ស្ថានភាពស្ថិតនៅតាមភាពទំនេរគ្មានបៀវត្ស</h5>
                                        </td>
                                    </tr>
                                </table>
                                <table  width="99.8%" border="1" cellpadding="5" cellspacing="5" style="font-family: 'KHMERMEF1';font-size:12px;border-collapse: collapse;text-align:center;border: 1px solid #000000">
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
                                    <?php $i = 1 ?>
                                    @foreach($situationFreeIdApprove as $key => $value)
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
                                <table width="99.8%" border="1" cellpadding="0" cellspacing="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center; border: 1px solid #000000">
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
                                <table width="100%" border="1" cellpadding="0" cellspacing="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;border: 1px solid #000000">
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
                                <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;border: 1px solid #000000">
                                    <tr>
                                        <th style="font-weight:normal;font-weight:normal">លេខឯកសារ</th>
                                        <th style="font-weight:norma;font-weight:normal">កាលបរិច្ឆេទ</th>
                                        <th style="font-weight:normal;font-weight:normal">ស្ថាប័ន/អង្គភាព (ស្នើរសុំ)</th>
                                        <th style="font-weight:normal;font-weight:normal">ខ្លឹមសារ</th>
                                        <th style="font-weight:normal;font-weight:normal">ប្រភេទ</th>
                                    </tr>
                                    <tbody>
                                    <tr>
                                        <td colspan="5" style="padding-left:5px;text-align:left; line-height: 2.8">គ្រឿងឥស្សរិយយស</td>

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
                                            <td style="height:25px;">{{isset($value->AWARD_NUMBER) ? $value->AWARD_NUMBER : ''}}</td>
                                            <td>{{isset($value->AWARD_DATE) && $value->AWARD_DATE != '0000-00-00' && $value->AWARD_DATE != '' ? $tool->dateformate($value->AWARD_DATE) : ''}}</td>
                                            <td>{{isset($value->DEPARTMENT) ? $value->DEPARTMENT : ''}}</td>
                                            <td>{{isset($value->AWARD_DESCRIPTION) ? $value->AWARD_DESCRIPTION : ''}}</td>
                                            <td>{{isset($value->AWARD_KIND) ? $value->AWARD_KIND : ''}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" style="padding-left:5px;text-align:left; line-height: 2.8">ទណ្ឌកម្មវិន័យ</td>
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
                                <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center;border: 1px solid #000000">
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
                                        <td colspan="5" style="padding-left:5px;text-align:left; line-height: 2.8">កំរិតវប្បធម៌ទូទៅ</td>
                                    </tr>
                                    <tr style="height:25px;">
                                        <td>{{isset($generalQualificationsIdApprove->LEAVED) ? $generalQualificationsIdApprove->LEAVED : '' }}</td>
                                        <td>{{isset($generalQualificationsIdApprove->PLACE) ? $generalQualificationsIdApprove->PLACE : ''}}</td>
                                        <td>{{isset($generalQualificationsIdApprove->GRADUATION_MAJORED) ? $generalQualificationsIdApprove->GRADUATION_MAJORED : ''}}</td>
                                        <td>{{isset($generalQualificationsIdApprove->Q_START_DATE) && $generalQualificationsIdApprove->Q_START_DATE != '0000-00-00' && $generalQualificationsIdApprove->Q_START_DATE != '' ? $tool->dateformate($generalQualificationsIdApprove->Q_START_DATE) : ''}}</td>
                                        <td>{{isset($generalQualificationsIdApprove->Q_END_DATE) && $generalQualificationsIdApprove->Q_END_DATE != '0000-00-00' && $generalQualificationsIdApprove->Q_END_DATE != '' ? $tool->dateformate($generalQualificationsIdApprove->Q_END_DATE) : ''}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding-left:5px;text-align:left;line-height: 2.8">កំរិតសញ្ញាបត្រ/ជំនាញឯកទេស</td>
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
                                            <td style="height:25px;">{{isset($value->LEAVED) ? $value->LEAVED : ''}}</td>
                                            <td>{{isset($value->PLACE) ? $value->PLACE : ''}}</td>
                                            <td>{{isset($value->GRADUATION_MAJOR) ? $value->GRADUATION_MAJOR : ''}}</td>
                                            <td>{{isset($value->Q_START_DATE) && $value->Q_START_DATE != '0000-00-00' && $value->Q_START_DATE != '' ? $tool->dateformate($value->Q_START_DATE) : ''}}</td>
                                            <td>{{isset($value->Q_END_DATE) && $value->Q_END_DATE != '0000-00-00' && $value->Q_END_DATE != '' ? $tool->dateformate($value->Q_END_DATE) : ''}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" style="padding-left:5px;text-align:left;line-height: 2.8">វគ្គបណ្តុះបណ្តាលវិជ្ជាជីវៈ (ក្រោម១២ខែ)</td>
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

                                <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center; border: 1px solid #000000">
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
                                            <h5 style="font-family: 'KHMERMEF2';font-weight:normal;margin-top:0;padding-left:35px;margin-bottom:10px;font-size:12px;padding-top: 10px">ក.ព័ត៌មានឪពុកម្តាយ</h5>
                                        </td>
                                    </tr>
                                </table>
                                <table width="99.8%" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin: 5px 0 0 0;" >
                                    <tbody>
                                    <tr>
                                        <td style="width:15%;font-weight:normal;">ឈ្មោះឪពុក</td>
                                        <td style="border: 1px solid #000;width:22%;line-height: 2; padding: 3px">{{isset($familyStatusIdApprove->FATHER_NAME_KH) ? $familyStatusIdApprove->FATHER_NAME_KH : ''}}</td>
                                        <td style="width:15%;font-weight:normal;text-align:right;padding-right: 5px;">ជាអក្សរឡាតាំង</td>
                                        <td style="border: 1px solid #000;width:25%;line-height: 2;padding: 3px">{{isset($familyStatusIdApprove->FATHER_NAME_EN) ? $familyStatusIdApprove->FATHER_NAME_EN : ''}}</td>
                                        <td style="width:18%;font-weight:normal;border: 1px solid #000; text-align: center">
                                            <?php
                                            $FATHER_LIVE = isset($familyStatusIdApprove->FATHER_LIVE) ? $familyStatusIdApprove->FATHER_LIVE:'';
                                            ?>
                                            <input type="checkbox" name="father_live" disabled value="" <?php echo ($FATHER_LIVE =='ស្លាប់' ? 'checked' : ''); ?> >ស្លាប់
                                            <input type="checkbox" name="father_live" disabled value="" <?php echo ($FATHER_LIVE =='រស់' ? 'checked' : ''); ?> >រស់
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table width="99.8%" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin: 5px 0 0 0;" >
                                    <tr>
                                        <td style="width:150px;">ថ្ងៃខែឆ្នាំកំណើត</td>
                                        <td style="width: 23%;border: 1px solid #000;padding: 3px">{{isset($familyStatusIdApprove->FATHER_DOB) && $familyStatusIdApprove->FATHER_DOB != '0000-00-00' &&  $familyStatusIdApprove->FATHER_DOB != '' ? $tool->dateformate($familyStatusIdApprove->FATHER_DOB) : ''}}</td>
                                        <td style="width:150px;text-align:right;padding-right: 5px;">សញ្ជាតិ</td>
                                        <td colspan="5" style="width: 45.4%;border: 1px solid #000;padding: 1px; line-height: 2">
                                            <label style="padding-left: 10px">1. {{isset($familyStatusIdApprove->FATHER_NATIONALITY_1) ? $familyStatusIdApprove->FATHER_NATIONALITY_1 : ''}}</label>
                                            <label style="padding-left: 150px">2. {{isset($familyStatusIdApprove->FATHER_NATIONALITY_2) ? $familyStatusIdApprove->FATHER_NATIONALITY_2 : ''}}</label>
                                        </td>
                                    </tr>
                                </table>
                                <table width="99.8%" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin: 5px 0 0 0;" >
                                    <tr>
                                        <td style="width:150px;">ទីលំនៅបច្ចុប្បន្ន</td>
                                        <td colspan="7" style="line-height: 2; border: 1px solid #000;padding: 3px">{{isset($familyStatusIdApprove->FATHER_ADDRESS) ? $familyStatusIdApprove->FATHER_ADDRESS : ''}}</td>
                                    </tr>
                                </table>
                                <table width="99.8%" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin: 5px 0 0 0;" >
                                    <tr>
                                        <td style="width:150px;">មុខរបរ</td>
                                        <td style="width: 23%;border: 1px solid #000;padding: 3px; line-height: 2">
                                            {{isset($familyStatusIdApprove->FATHER_JOB) ? $familyStatusIdApprove->FATHER_JOB : ''}}</td>
                                        <td style="width:150px;text-align:right;padding-right: 5px;">ស្ថាប័ន/អង្គភាព</td>
                                        <td colspan="5" style="width: 45.5%;border: 1px solid #000;padding: 5px">
                                            {{isset($familyStatusIdApprove->FATHER_UNIT) ? $familyStatusIdApprove->FATHER_UNIT : ''}}</td>
                                    </tr>
                                </table>
                                <table width="99.8%"  style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin: 5px 0 0 0;" >
                                    <tr style="border:none">
                                        <td style="width:15%;font-weight:normal;">ឈ្មោះម្តាយ</td>
                                        <td style="border: 1px solid #000;width:22%;padding: 3px">
                                            {{isset($familyStatusIdApprove->MOTHER_NAME_KH) ? $familyStatusIdApprove->MOTHER_NAME_KH : ''}}
                                        </td>
                                        <td style="width:15%;font-weight:normal;text-align:right;padding-right: 5px;">ជាអក្សរឡាតាំង</td>
                                        <td style="border: 1px solid #000;width:25%;padding: 3px; padding-left: 5px">
                                            {{isset($familyStatusIdApprove->MOTHER_NAME_EN) ? $familyStatusIdApprove->MOTHER_NAME_EN : ''}}
                                        </td>
                                        <td style="width:18%;font-weight:normal;padding: 3px;border: 1px solid #000; text-align: center">
                                            <?php
                                            $MOTHER_LIVE = isset($familyStatusIdApprove->MOTHER_LIVE) ? $familyStatusIdApprove->MOTHER_LIVE :'';
                                            ?>
                                            <input type="checkbox" name="mother_live" disabled value="" <?php echo ($MOTHER_LIVE =='ស្លាប់' ? 'checked' : ''); ?> >ស្លាប់
                                            <input type="checkbox" name="mother_live" disabled value="" <?php echo ($MOTHER_LIVE =='រស់' ? 'checked' : ''); ?> >រស់
                                        </td>
                                    </tr>
                                </table>
                                <table width="99.8%"  style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin: 5px 0 0 0;" >
                                    <tr>
                                        <td style="width:150px;">ថ្ងៃខែឆ្នាំកំណើត</td>
                                        <td style="width: 23.1%; border: 1px solid #000;padding: 3px">{{isset($familyStatusIdApprove->MOTHER_DOB) && $familyStatusIdApprove->MOTHER_DOB != '0000-00-00' && $familyStatusIdApprove->MOTHER_DOB != ''? $tool->dateformate($familyStatusIdApprove->MOTHER_DOB) : ''}}</td>
                                        <td style="width:150px;text-align:right;padding-right: 5px;">សញ្ជាតិ</td>
                                        <td colspan="5" style=" border: 1px solid #000;padding: 3px">
                                            <label style="padding-left: 10px">1. {{isset($familyStatusIdApprove->MOTHER_NATIONALITY_1) ? $familyStatusIdApprove->MOTHER_NATIONALITY_1 : ''}}</label>
                                            <label style="padding-left: 150px">2. {{isset($familyStatusIdApprove->MOTHER_NATIONALITY_2) ? $familyStatusIdApprove->MOTHER_NATIONALITY_2 : ''}}</label>
                                        </td>
                                    </tr>
                                </table>
                                <table width="99.8%"  style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin: 5px 0 0 0;" >
                                    <tr>
                                        <td style="width:150px;">ទីលំនៅបច្ចុប្បន្ន</td>
                                        <td colspan="7" style=" border: 1px solid #000;padding: 3px;line-height: 2">
                                            {{isset($familyStatusIdApprove->MOTHER_ADDRESS) ? $familyStatusIdApprove->MOTHER_ADDRESS : ''}}
                                        </td>
                                    </tr>
                                </table>
                                <table width="99.8%" cellspacing="5" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin: 5px 0 0 0;" >
                                    <tr>
                                        <td style="width:150px;">មុខរបរ</td>
                                        <td style="width:23.1%;border: 1px solid #000;padding: 3px">
                                            {{isset($familyStatusIdApprove->MOTHER_JOB) ? $familyStatusIdApprove->MOTHER_JOB : ''}}
                                        </td>
                                        <td style="width:150px;text-align:right;padding-right: 5px;">ស្ថាប័ន/អង្គភាព</td>
                                        <td colspan="5" style=" border: 1px solid #000;padding: 3px">
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
                                <table width="99.8%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse; border:1px solid #000000">
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
                                <table width="99.8%"  style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal; margin-bottom: 5px;" >
                                    <tr style="border:none">
                                        <td style="width:15%;font-weight:normal;">ឈ្មោះប្តីឬប្រពន្ធ</td>
                                        <td style="border: 1px solid #000;padding: 14px;">{{isset($familyStatusIdApprove->SPOUSE_NAME_KH) ? $familyStatusIdApprove->SPOUSE_NAME_KH : ''}}</td>
                                        <td style="width:15%;font-weight:normal;text-align:right; ; padding-right: 10px">ជាអក្សរឡាតាំង</td>
                                        <td style="border: 1px solid #000;width:25%; padding-left: 5px">{{isset($familyStatusIdApprove->SPOUSE_NAME_EN) ? $familyStatusIdApprove->SPOUSE_NAME_EN : ''}}</td>
                                        <td style="width:18%;font-weight:normal; border: 1px solid #000000; padding-left: 5px">
                                            <?php
                                            $SPOUSE_LIVE = isset($familyStatusIdApprove->SPOUSE_LIVE) ? $familyStatusIdApprove->SPOUSE_LIVE:'';
                                            ?>
                                            <input type="checkbox" name="SPOUSE_LIVE" disabled value="" <?php echo ($SPOUSE_LIVE =='ស្លាប់' ? 'checked' : ''); ?> >ស្លាប់
                                            <input type="checkbox" name="SPOUSE_LIVE" disabled value="" <?php echo ($SPOUSE_LIVE =='រស់' ? 'checked' : ''); ?> >រស់
                                        </td>
                                    </tr>
                                </table>
                                <table width="99.8%"  style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal; margin-bottom: 5px;" >
                                    <tr>
                                        <td style="width:15%;">ថ្ងៃខែឆ្នាំកំណើត</td>
                                        <td style="border: 1px solid #000;padding: 3px; width: 27.2%;">
                                            {{isset($familyStatusIdApprove->SPOUSE_DOB) && $familyStatusIdApprove->SPOUSE_DOB != '0000-00-00' && $familyStatusIdApprove->SPOUSE_DOB != ''? $tool->dateformate($familyStatusIdApprove->SPOUSE_DOB) : ''}}
                                        </td>
                                        <td style="width:143px;text-align:right; padding-right: 10px">សញ្ជាតិ</td>
                                        <td colspan="5" style="border: 1px solid #000; line-height: 1.5; padding: 3px; text-align: center;">
                                            <label style="padding-left: 10px">
                                                1. {{isset($familyStatusIdApprove->SPOUSE_NATIONALITY_1) ? $familyStatusIdApprove->SPOUSE_NATIONALITY_1 : ''}}</label>
                                            <label style="padding-left: 150px">
                                                2. {{isset($familyStatusIdApprove->SPOUSE_NATIONALITY_2) ? $familyStatusIdApprove->SPOUSE_NATIONALITY_2 : ''}}</label>
                                        </td>
                                    </tr>
                                </table>
                                <table width="99.8%" cellspacing="5px" cellpadding="3px" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin-bottom: 5px" >
                                    <tr>
                                        <td style="width:15%;">ទីកន្លែងកំណើត</td>
                                        <td colspan="7" style=" border: 1px solid #000; padding: 5px; line-height: 1.8">
                                            {{isset($familyStatusIdApprove->SPOUSE_POB) ? $familyStatusIdApprove->SPOUSE_POB : ''}}
                                        </td>
                                    </tr>
                                </table>
                                <table width="99.8%" cellspacing="5px" cellpadding="3px" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin-bottom: 5px;" >
                                    <tr>
                                        <td style="width:15%;font-weight:normal;">មុខរបរ</td>
                                        <td style="border: 1px solid #000;width:27%;text-align:left; padding: 5px;">
                                            {{isset($familyStatusIdApprove->SPOUSE_JOB) ? $familyStatusIdApprove->SPOUSE_JOB : ''}}
                                        </td>

                                        <td style="width:15%;font-weight:normal;text-align:right; padding-right: 5px;">អង្គភាព</td>
                                        <td style="border: 1px solid #000;width:25%; padding: 5px;">
                                            {{isset($familyStatusIdApprove->SPOUSE_UNIT) ? $familyStatusIdApprove->SPOUSE_UNIT : ''}}
                                        </td>
                                        <td style="width:30%;font-weight:normal;text-align:right; border:1px solid #000000; padding: 5px;">
                                            ប្រាក់ឧបត្ថម្ភ :
                                            <?php
                                            $SPOUSE_SPONSOR = isset($familyStatusIdApprove->SPOUSE_SPONSOR) ? $familyStatusIdApprove->SPOUSE_SPONSOR:'';
                                            ?>
                                            <input type="checkbox" name="SPOUSE_SPONSOR" disabled value="" <?php echo ($SPOUSE_SPONSOR =='មាន' ? 'checked' : ''); ?> >មាន
                                            <input type="checkbox" name="SPOUSE_SPONSOR" disabled value="" <?php echo ($SPOUSE_SPONSOR =='គ្មាន' ? 'checked' : ''); ?> >គ្មាន
                                        </td>
                                    </tr>
                                </table>
                                <table width="99.8%" cellspacing="5px" cellpadding="3px" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;margin-bottom: 5px;" >
                                    <tr>
                                        <td style="width:144px;">លេខទូរស័ព្ទ</td>
                                        <td  colspan=7 style=" border: 1px solid #000; padding: 3px;">
                                            @foreach($phoneNumberApprove as $key =>$value)
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
                                <table width="99.8%" border="1" cellspacing="0" cellpadding="5" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:normal;border-collapse: collapse;text-align:center; border: 1px solid #000000">
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

                                <div style="line-break: loose;page-break-before: always">

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
                        var bar_size=3;
                        if(get_object("barcode").innerHTML <6){
                            bar_size = 8;
                        }
                        if(get_object("barcode").innerHTML <3){
                            bar_size = 15;
                        }
                        get_object("barcode").innerHTML=DrawHTMLBarcode_Code39(get_object("barcode").innerHTML,0,"no","on",0,2,0.5,bar_size,"bottom","right","","black","white");

                    </script>

                </div>
                <!--end tab2-->
                @endif
            </div>
            <div class="tab-pane fade {{isset($tab)?$tab==3 ?' in active':'':''}}" id="tab3">
                @if($tab==3)
                    <!--start innter content page-->
                    <div class="page">
                        <div class="row">
                            <div class="form-group" style="padding:20px">
                                <div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
                                    <label><span class="col-red">*</span>របាយការណ៍</label>
                                    <input type="hidden" class="form-control" id="report_type_id" name="report_type_id">
                                    <div id='report_type' class="gb-dropdown" onchange="choose_report_type()"></div>
                                </div>
                                <div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
                                    <label><span class="col-red">*</span>{{trans('officer.centralMinistry')}}</label>
                                    <input type="hidden" class="form-control" id="mef_ministry_id" name="mef_ministry_id" value="76">
                                    <div id="div_mef_ministry_id" class="gb-dropdown"></div>
                                </div>
                              </div>
                         </div>

                        <div class="row">
                        <div class="form-group" style="padding:20px">
                                <div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
                                    <label> <span class="col-red">*</span>{{trans('officer.generalDepartment')}}</label>
                                    <input type="hidden" id="mef_secretariat_id" name="mef_secretariat_id" value="2">
                                    <div id="div_mef_secretariat_id" class="gb-dropdown"></div>
                                </div>
                                <div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
                                    <label><span class="col-red">*</span>{{trans('officer.department')}}</label>
                                    <input type="hidden" id="mef_department_id" name="mef_department_id">
                                    <div id="div_mef_department_id" class="gb-dropdown"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="padding:20px">
                                <div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
                                    <label>{{trans('officer.office')}}</label>
                                    <input type="hidden" id="mef_office_id" name="mef_office_id">
                                    <div id="div_mef_office_id" class="gb-dropdown"></div>
                                </div>

                                <div id="divOfficerReportDetail">
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 mb30">
                                        <label>ថ្ងៃខែឆ្នាំកំណើត</label>
                                        <jqx-date-time-input jqx-on-change="change(event)" jqx-settings="settings"></jqx-date-time-input>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 mb30">
                                        <label>ថ្ងៃចូល​ជាមន្ត្រី​</label>
                                        <div id='jqxdateOfficerIn'></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mb30">
                                <button type="button" onclick="select_report()"  class="btn btn-lg btn-success btn-box-save "><i class="fa fa-search"></i> ស្វែងរក</button>
                            </div>
                        </div>



                        <div id="div_degree_report"></div> <!--select report-->
                    </div>
                    <!--end tab3-->
                @endif
            </div>

        </div>


@if($tab == 3)

    <script>
        $(function () {
            $("#jqxdateOfficerIn").jqxDateTimeInput({ width: '250px', height: '25px' });

            //report type select

            var source = [
                {"text":"របាយការណ៍ស្តីពីកម្រិតសញ្ញាបត្រ","value":1},
                {"text":"របាយការណ៍មន្រ្តីរាជការ","value":2},
                {"text":"របាយការណ៍មន្រ្តីរាជការលម្អិត","value":3},
                // {"text":"តារាងកម្រិតសញ្ញាបត្រមន្ត្រី","value":3}
                ];
            initDropDownList('bootstrap', '100%',35, '#report_type', source, 'text', 'value', true, 'ជ្រើសរើ​ស', '0', "#report_type_id","{{trans('trans.buttonSearch')}}",300);



            function getSecretaratByMinistryId(object){
                var ministryId = $(object).val();
                $.ajax({
                    type: "post",
                    url : '{{$getSecreateByMinistryId}}',
                    datatype : "json",
                    data : {"ministryId":ministryId,"_token":'{{ csrf_token() }}'},
                    success : function(data){
                        initDropDownList('bootstrap', '100%',35, '#div_mef_secretariat_id', data, 'text', 'value', false, '', '0', "#mef_secretariat_id","{{trans('trans.buttonSearch')}}",300);
                    }
                });
            }
            function getDepartmentBySecrateId(object){
                var secretaryId = $(object).val();
                $.ajax({
                    type: "post",
                    url : '{{$getdepartmentBySecId}}',
                    datatype : "json",
                    data : {"secretaryId":secretaryId,"_token":'{{ csrf_token() }}'},
                    success : function(data){
                        initDropDownList('bootstrap', '100%',35, '#div_mef_department_id', data, 'text', 'value', false, '', '0', "#mef_department_id","{{trans('trans.buttonSearch')}}",300);
                    }
                });
            }
            function getOfficeByDepartmentId(object){
                var departmentId = $(object).val();
                $.ajax({
                    type: "post",
                    url : '{{$getOfficeByDepartment}}',
                    datatype : "json",
                    data : {"departmentId":departmentId,"_token":'{{ csrf_token() }}'},
                    success : function(data){
                        initDropDownList('bootstrap', '100%',35, '#div_mef_office_id', data, 'text', 'value', false, '', '0', "#mef_office_id","{{trans('trans.buttonSearch')}}",300);
                    }
                });
            }




            /* Ministry */
            initDropDownList('bootstrap', '100%',35, '#div_mef_ministry_id', <?php echo $listMinistry;?>, 'text', 'value', false, '', '0', "#mef_ministry_id","{{trans('trans.buttonSearch')}}",150);
            $('#div_mef_ministry_id').bind('select', function (event) {
                if($(this).val() !=0){
                    getSecretaratByMinistryId(this);
                }
            });
            $("#div_mef_ministry_id").jqxDropDownList({ disabled: true });
            /* Secretariat */
            initDropDownList('bootstrap', '100%',35, '#div_mef_secretariat_id', <?php echo $listSecretariat;?>, 'text', 'value', false, '', '0', "#mef_secretariat_id","{{trans('trans.buttonSearch')}}",300);
            $('#div_mef_secretariat_id').bind('select', function (event) {
                if($(this).val() !=0){
                    getDepartmentBySecrateId(this);
                }
            });


            /*Department*/
            initDropDownList('bootstrap', '100%',35, '#div_mef_department_id',<?php echo $listDepartment;?>, 'text', 'value', false, '', '0', "#mef_department_id","{{trans('trans.buttonSearch')}}",400);
            initDropDownList('bootstrap', '100%',35, '#div_mef_office_id',<?php echo $listOffice;?>, 'text', 'value', true, '', '0', "#mef_office_id","{{trans('trans.buttonSearch')}}",400);
            $('#div_mef_department_id').bind('select', function (event) {
                if($(this).val() !=0){
                    getOfficeByDepartmentId(this);
                }
            });


            choose_report_type();//show hide date
        });

        function select_report() {
            var mef_ministry_id = $('#mef_ministry_id').val();
            var department_id = $('#mef_department_id').val();
            var mef_secretariat_id = $('#mef_secretariat_id').val();
            var mef_office_id = $('#mef_office_id').val();
            var report_type_id = $('#report_type_id').val();
            var date_rang = $('#inputjqxDateTimeInput0').val();
            var start_date = date_rang.toString().split("-")[0];// break string
            var end_date = date_rang.toString().split("-")[1];// break string
            var officerDateIn = $('#jqxdateOfficerIn').val();

            if(report_type_id == null || report_type_id == 0){
                $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning",autoCloseDelay:6000,autoClose: true }).html('សូម​ធ្វើ​ការ​ជ្រើសរើស​ប្រភេទ​របាយការណ៍');
                $("#jqx-notification").jqxNotification("open");
            }else{
                $.ajax({
                    type: 'post',
                    url : "{{$getDegreeReport}}",
                    data:{
                        "_token":'{{ csrf_token() }}',
                        "report_type":report_type_id,
                        "mef_ministry_id":mef_ministry_id,
                        "department_id":department_id,
                        "mef_secretariat_id":mef_secretariat_id,
                        "mef_office_id":mef_office_id,
                        "start_date":start_date,
                        "end_date":end_date,
                        "officerDateIn":officerDateIn,
                    },
                    success:function (data) {
                        $('#div_degree_report').empty().html(data);
                    }
                })
            }
        }

        function choose_report_type() {
            if($('#report_type_id').val() == 3){

                $("#divOfficerReportDetail").show();
            }else{
                $("#divOfficerReportDetail").hide();
            }
        }
    </script>

@endif

<style>
    .load-waiting-template{
        position: absolute;
        left: 50%;
        top: 0;
        z-index: 99;
        margin-left: -16px;
    }
</style>




<script>

    $(document).ready(function() {
        $(".btnEdit").click(function(){
            var dataFormId = $(this).attr("dataFormId");
            $(".bg-transparent").fadeIn(200);
            $(this).hide();
            $("#"  + dataFormId + " .sb-heading").css("z-index","999");
            $("#" + dataFormId + " .blg-fade-edit").css("display","block");
            $("#" + dataFormId + " .body-edit").css("z-index","999");
            $("#" + dataFormId + " .tbl-edit-cont").css("display","none");
            $(".ttl-each").css("color","#333");
        });


    });

        // function openPage(pageName,elmnt,color) {
        //     var i, tabcontent, tablinks;
        //     tabcontent = document.getElementsByClassName("tabcontent");
        //     for (i = 0; i < tabcontent.length; i++) {
        //         tabcontent[i].style.display = "none";
        //     }
        //     tablinks = document.getElementsByClassName("tablink");
        //     for (i = 0; i < tablinks.length; i++) {
        //         tablinks[i].style.backgroundColor = "";
        //     }
        //     document.getElementById(pageName).style.display = "block";
        //     elmnt.style.backgroundColor = color;
        // }
    // Get the element with id="defaultOpen" and click on it
    // document.getElementById("defaultOpen").click();
</script>



