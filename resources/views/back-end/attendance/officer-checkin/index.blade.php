<?php
$jqxPrefix = '_officer_checkin_index';
$newUrl = asset($constant['secretRoute'].'/officer-checkin/new');
$searchUrl = asset($constant['secretRoute'].'/officer-checkin/search');
$searchNoteUrl = asset($constant['secretRoute'].'/officer-checkin/search-note');
$searchNoteUrlDelete = asset($constant['secretRoute'].'/officer-checkin/delete-note');

$importUrl = asset($constant['secretRoute'].'/officer-checkin/import');
$getOfficeByDepartmentUrl = asset($constant['secretRoute'].'/officer-checkin/get-office-by-department-id');
?>
@extends('layout.back-end')
@section('content')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<div id="content-container" class="content-container">
    <div class="panel">
        <div class="row panel-heading custome-panel-headering">
            <div class="form-group title-header-panel">
                <div class="pull-left">
                    <div class="col-lg-12 col-xs-12">{{$constant['attendance-manager']}} &raquo; {{trans('officer.attendance')}} </div>
                </div>
                <div class="pull-right">
                    <div class="col-lg-6 col-xs-6">
                        <button id="btn-add<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-edit"></i> {{trans('attendance.note')}}</button>
                    </div>
                    <div class="col-lg-6 col-xs-6">
                        <button id="btn-import<?php echo $jqxPrefix;?>" class=""><i class="glyphicon glyphicon-cloud-download"></i> {{$constant['import']}}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xs-12">
            <form class="form-horizontal" id="jqx-form<?php echo $jqxPrefix;?>" role="form" method="put" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="start_dt" id="start_dt" value="{{$start_dt}}">
                <input type="hidden" name="end_dt" id="end_dt" value="{{$end_dt}}">
                <input type="hidden" name="full_rang_day" id="full_rang_day" value="{{$start_dt}} - {{$end_dt}}">
                <table class="table table-bordered">
                <thead>
                <tr>
                    <th>{{trans('officer.department')}}</th>
                    <th>{{trans('officer.office')}}</th>
                    <th>{{trans('officer.position')}}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="hidden" id="mef_department_id" name="mef_department_id" value="{{isset($mef_department_id)?$mef_department_id:''}}">
                        <div id="div_mef_department_id"></div>
                    </td>
                    <td>
                        <input type="hidden" id="mef_office_id" name="mef_office_id" value="{{isset($mef_office_id)?$mef_office_id:''}}">
                        <div id="div_mef_office_id"></div>
                    </td>
                    <td>
                        <input type="hidden" id="mef_position_id" name="mef_position_id" value="{{isset($mef_position_id)?$mef_position_id:''}}">
                        <div id="div_mef_position_id"></div>
                    </td>
                </tr>
                <tr>
                    <th>{{trans('attendance.code')}}</th>
                    <th>{{trans('officer.full_name')}}</th>
                    <td>{{trans('officer.date')}}</td>
                </tr>
                <tr>
                    <th><input type="text" name="officer_id" id="officer_id" class="form-control wid-300" value="{{isset($officer_id)?$officer_id:''}}">
                    </th>
                    <th><input type="text" name="officer_name" id="officer_name" class="form-control wid-300" value="{{isset($officer_name)?$officer_name:''}}">
                    </th>
                    <td>
                        <div id="div_jqxcalendar_id"></div>

                    </td>
                </tr>
                <tr>
                    <td colspan="6"><button id="btn-search<?php echo $jqxPrefix;?>" type="button"><i class="glyphicon glyphicon-search"></i> {{trans('trans.buttonSearch')}} {{trans('officer.attendance')}}</button>
                    <button id="btn-search-note<?php echo $jqxPrefix;?>" type="button"><i class="glyphicon glyphicon-search"></i> {{trans('trans.buttonSearch')}} {{trans('attendance.note')}}</button>

                    </td>
                </tr>
                </tbody>
            </table>
            </form>
        </div>
        @if(isset($officer))
        <div class="col-lg-12 col-xs-12">
            <table class="table table-striped table-hover" id="dataTable" border="1">
                <thead class="thead-inverse">
                    <tr>
                        <th align="left">{{trans('attendance.code')}}</th>
                        <th align="left">{{trans('officer.full_name')}}</th>
                        <th align="left">{{trans('officer.date')}}</th>
                        <th colspan="2" style="text-align: center;">{{trans('attendance.morning')}}</th>
                        <th colspan="2" style="text-align: center;">{{trans('attendance.evening')}}</th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($officer))
                    <?php
                        // Number of links to show. Odd numbers work better
                        $doc =$officer;
                        $linkCount = $doc->perPage();
                        $pageCount = $doc->lastPage();
                        $currentPage = $doc->currentPage();
                        $startPage = 1;
                        $endPage = $pageCount;
                        $uri = str_replace(Request::url(), '', Request::fullUrl());
                        $uri = str_replace('?','',$uri);
                        $pos = strrpos($uri, "page");
                        $uri = substr($uri,0,$pos-1);
                    ?>
                    @foreach($officer as $key => $element)
                        @if($element->mef_user_id>0)
                        <tr>
                            <th>{{$element->mef_user_id}}</th>
                            <td>{{$element->FULL_NAME_KH}} </td>
                            <td>{{$element->date}} </td>
                            <?php

                                $insect='alert-info';
                                $outsect='alert-info';
                            ?>
                            <td class="{{$element->morning_checkin=='NA'?'danger':'alert-info'}}" data-id="{{$element->date}} 8:30:00|{{$element->mef_user_id}}|1|1">{{$element->morning_checkin}}</td>
                            <td class="{{$element->morning_checkout=='NA'?'danger':'alert-info'}}" data-id="{{$element->date}} 11:10:00|{{$element->mef_user_id}}|1|2">{{$element->morning_checkout}}</td>
                            <td class="{{$element->evening_checkin=='NA'?'danger':'alert-info'}}" data-id="{{$element->date}} 11:10:00|{{$element->mef_user_id}}|2|1">{{$element->evening_checkin}}</td>
                            <td class="{{$element->evening_checkout=='NA'?'danger':'alert-info'}}" data-id="{{$element->date}} 11:10:00|{{$element->mef_user_id}}|2|2">{{$element->evening_checkout}}</td>

                        </tr>
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- start nav pagination -->
            <nav class="text-center">
                @if($pageCount > 1)
                <?php
                    $param='';
                    if(isset($mef_department_id)){
                        $param .= '&mef_department_id='.$mef_department_id;
                    }
                    if(isset($mef_office_id)){
                        $param .= '&mef_office_id='.$mef_office_id;
                    }
                    if(isset($mef_position_id)){
                        $param .= '&mef_position_id='.$mef_position_id;
                    }
                    if(isset($officer_id)){
                        $param .= '&officer_id='.$officer_id;
                    }
                    if(isset($officer_name)){
                        $param .= '&officer_name='.$officer_name;
                    }
                    if(isset($start_dt)){
                        $param .= '&start_dt='.$start_dt;
                    }
                    if(isset($end_dt)){
                        $param .= '&end_dt='.$end_dt;
                    }
                ?>
                    <ul class="pagination">
                        <!-- first page -->
                        <li class="page-item {{ ($currentPage == 1 ? 'disabled' : '') }}">
                            @if($currentPage == 1)
                                <span class="page-link none_select" aria-label="Last">
                                <<
                            </span>
                            @else
                                <a class="page-link" href="{{ $doc->url(1).$param }}" aria-label="Last">
                                   <<
                                </a>
                            @endif
                        </li>

                        <!-- Previous item -->
                        <li class="page-item {{ ($currentPage == 1 ? 'disabled' : '') }}">
                            @if($currentPage == 1)
                                <span class="page-link none_select" aria-label="Previous">
                                <
                            </span>
                            @else
                                <a class="page-link" href="{{ $doc->url($currentPage - 1).$param }}" aria-label="Previous">
                                    <
                                </a>
                            @endif
                        </li>

                        <!-- Loop through and collect -->
                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <?php $disabledClass = $i == $currentPage ? 'active' : '';?>
                            <li class="page-item {{ $disabledClass }}">
                                <a class="page-link" href="{{ $doc->url($i).$param }}">{{ $i }}</a>
                            </li>
                            @endfor

                                    <!-- Next item -->
                            <li class="page-item {{ ($currentPage == $pageCount ? 'disabled' : '') }}">
                                @if($currentPage == $pageCount)
                                    <span class="page-link none_select" aria-label="Next">
                                >
                            </span>
                                @else
                                    <a class="page-link" href="{{ $doc->nextPageUrl().$param }}" aria-label="Next">
                                        >
                                    </a>
                                @endif
                            </li>

                            <!-- last page -->
                            <li class="page-item {{ ($currentPage == $pageCount ? 'disabled' : '') }}">
                                @if($currentPage == $pageCount)
                                    <span class="page-link none_select" aria-label="Last">
                                >>
                            </span>
                                @else
                                    <a class="page-link" href="{{ $doc->url($doc->lastPage()) }}" aria-label="Last">
                                        >>
                                    </a>
                                @endif
                            </li>
                    </ul>
                @endif
            </nav>
            <!-- end nav pagination -->
        </div>
        @endif
        @if(isset($note))
        <div class="col-lg-12 col-xs-12">
            <table class="table table-striped table-hover" id="dataTable" border="1">
                <thead class="thead-inverse">
                    <tr>
                        <th align="left">{{trans('attendance.code')}}</th>
                        <th align="left">{{trans('officer.full_name')}}</th>
                        <th align="left">{{trans('officer.date')}}</th>
                        <th style="text-align: center;">{{trans('attendance.note')}}</th>
                        <th style="text-align: center;">សក្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($note))
                    <?php
                        // Number of links to show. Odd numbers work better
                        $doc =$note;
                        $linkCount = $doc->perPage();
                        $pageCount = $doc->lastPage();
                        $currentPage = $doc->currentPage();
                        $startPage = 1;
                        $endPage = $pageCount;
                        $uri = str_replace(Request::url(), '', Request::fullUrl());
                        $uri = str_replace('?','',$uri);
                        $pos = strrpos($uri, "page");
                        $uri = substr($uri,0,$pos-1);
                    ?>
                    @foreach($note as $key => $element)
                        @if($element->value>0)
                        <tr>
                            <th>{{$element->value}}</th>
                            <td>{{$element->text}} </td>
                            <td>{{$element->date_dt}} </td>
                            <td>{{$element->detail}} </td>
                            <td><button class="btn-delete" data-id="{{$element->id}}" type="button"><i class="glyphicon glyphicon-trash"></i> {{trans('trans.buttonDelete')}}</button>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- start nav pagination -->
            <nav class="text-center">
                @if($pageCount > 1)
                <?php
                    $param='';
                    if(isset($mef_department_id)){
                        $param .= '&mef_department_id='.$mef_department_id;
                    }
                    if(isset($mef_office_id)){
                        $param .= '&mef_office_id?'.$mef_office_id;
                    }
                    if(isset($mef_position_id)){
                        $param .= '&mef_position_id='.$mef_position_id;
                    }
                    if(isset($officer_id)){
                        $param .= '&officer_id='.$officer_id;
                    }
                    if(isset($officer_name)){
                        $param .= '&officer_name='.$officer_name;
                    }
                    if(isset($start_dt)){
                        $param .= '&start_dt='.$start_dt;
                    }
                    if(isset($end_dt)){
                        $param .= '&end_dt='.$end_dt;
                    }
                ?>
                    <ul class="pagination">
                        <!-- first page -->
                        <li class="page-item {{ ($currentPage == 1 ? 'disabled' : '') }}">
                            @if($currentPage == 1)
                                <span class="page-link none_select" aria-label="Last">
                                <<
                            </span>
                            @else
                                <a class="page-link" href="{{ $doc->url(1).$param }}" aria-label="Last">
                                   <<
                                </a>
                            @endif
                        </li>

                        <!-- Previous item -->
                        <li class="page-item {{ ($currentPage == 1 ? 'disabled' : '') }}">
                            @if($currentPage == 1)
                                <span class="page-link none_select" aria-label="Previous">
                                <
                            </span>
                            @else
                                <a class="page-link" href="{{ $doc->url($currentPage - 1).$param }}" aria-label="Previous">
                                    <
                                </a>
                            @endif
                        </li>

                        <!-- Loop through and collect -->
                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <?php $disabledClass = $i == $currentPage ? 'active' : '';?>
                            <li class="page-item {{ $disabledClass }}">
                                <a class="page-link" href="{{ $doc->url($i).$param }}">{{ $i }}</a>
                            </li>
                            @endfor

                                    <!-- Next item -->
                            <li class="page-item {{ ($currentPage == $pageCount ? 'disabled' : '') }}">
                                @if($currentPage == $pageCount)
                                    <span class="page-link none_select" aria-label="Next">
                                >
                            </span>
                                @else
                                    <a class="page-link" href="{{ $doc->nextPageUrl().$param }}" aria-label="Next">
                                        >
                                    </a>
                                @endif
                            </li>

                            <!-- last page -->
                            <li class="page-item {{ ($currentPage == $pageCount ? 'disabled' : '') }}">
                                @if($currentPage == $pageCount)
                                    <span class="page-link none_select" aria-label="Last">
                                >>
                            </span>
                                @else
                                    <a class="page-link" href="{{ $doc->url($doc->lastPage()) }}" aria-label="Last">
                                        >>
                                    </a>
                                @endif
                            </li>
                    </ul>
                @endif
            </nav>
            <!-- end nav pagination -->
        </div>
        @endif
    </div>
</div>
<style>
    #ContentPanel{
        overflow-y: scroll;
    }
    #detail-body{
        overflow-x: hidden;
        overflow-y:auto;
        font-family: 'KHMERMEF1';
    }
    .danger{
        cursor: pointer;
    }
    .search-options{
        position: relative;
        top: 2px;
        height: 40px;
        border-bottom: 1px solid #E8E8E8;
        background: #f5f5f5;
        padding-top: 2px;
        margin-bottom: -14px;
    }
    .labels-officer-checkin{
        top:10px;
    }
    .table > thead > tr > th{
        border-bottom: 1px solid #ddd;
    }
    .wid-300{
        width: 300px;
    }

</style>
<script type="text/javascript">
    var width = $( window ).width()*0.4;
    var height = $( window ).height()*0.4;

    $(function(){
        $('.danger').click(function(event){
            var $date_dt=$(this).attr('data-id');
            newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}', 900, 380, '<?php echo $newUrl;?>', $date_dt, '{{ csrf_token() }}');
        });

    });

    function getOfficeByDepartmentId(department_id){

        $.ajax({
            type: "post",
            url : '{{$getOfficeByDepartmentUrl}}',
            datatype : "json",
            data : {"departmentId":department_id,"_token":'{{ csrf_token() }}'},
            success : function(data){
                console.log(data);
                initDropDownList('bootstrap', 300,35, '#div_mef_office_id', data, 'text', 'value', false, '', '0', "#mef_office_id","{{$constant['buttonSearch']}}",300);
            }
        });
    }
    // prepare the data
    $(document).ready(function () {
        //Button action
        var buttons = ['btn-add<?php echo $jqxPrefix;?>','btn-import<?php echo $jqxPrefix;?>'];
        initialButton(buttons,120,30);

        initialButton(['btn-search-note<?php echo $jqxPrefix;?>','btn-search<?php echo $jqxPrefix;?>'],150,30);
        // form validator
        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#div_mef_department_id', message: ' ', action: 'select',
                    rule: function () {

                        if($("#div_mef_department_id").val() == 0){

                            return false;
                        }
                        return true;
                    }
                }
            ]
        });
        /* Department */
        initDropDownList('bootstrap', 300,35, '#div_mef_department_id', <?php echo $listDepartment;?>, 'text', 'value', false, '', '0', "#mef_department_id","{{$constant['buttonSearch']}}",300);
        $('#div_mef_department_id').bind('select', function () {
            var department_id = $(this).val();
            getOfficeByDepartmentId(department_id);
        });

        /* Office */
        initDropDownList('bootstrap', 300,35, '#div_mef_office_id', <?php echo $listOffice;?>, 'text', 'value', false, '', '0', "#mef_office_id","{{$constant['buttonSearch']}}",300);

        /*Position*/
        initDropDownList('bootstrap', 300,35, '#div_mef_position_id',<?php echo $listPosition;?>, 'text', 'value', false, '', '0', "#mef_position_id","{{$constant['buttonSearch']}}",400);

        /*calendar*/
        $("#div_jqxcalendar_id").jqxDateTimeInput({ width: 300, height: 30,selectionMode: 'range',formatString: "yyyy-MM-dd" });

        var start_dt = new Date('{{$start_dt}}');
        var end_dt = new Date('{{$end_dt}}');

        $("#div_jqxcalendar_id").jqxDateTimeInput('setRange', start_dt, end_dt);

        $("#div_jqxcalendar_id").on('change', function (event) {
            var selection = $("#div_jqxcalendar_id").jqxDateTimeInput('getRange');
            var take_date= $('#div_jqxcalendar_id').jqxDateTimeInput('getText'); 
			$('#full_rang_day').val(take_date);
            if (selection.from != null) {
                $('#start_dt').val(selection.from.toJSON());
                $('#end_dt').val(selection.to.toJSON());
            }
        });
        /*btn-import*/
        $("#btn-import<?php echo $jqxPrefix;?>").on('click',function(){
            newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}',width,height, '<?php echo $importUrl;?>', 0, '{{ csrf_token() }}');
        });
        /*btn-add*/

        $("#btn-add<?php echo $jqxPrefix;?>").click(function(){
            newJqxItem('<?php echo $jqxPrefix;?>', "{{trans('attendance.note')}}", 900, 380, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
        });
        $("#btn-search<?php echo $jqxPrefix;?>").click(function(){

            $('#jqx-form<?php echo $jqxPrefix;?>').attr('action', "{{$searchUrl}}").submit();

        });
        $("#btn-search-note<?php echo $jqxPrefix;?>").click(function(){

            $('#jqx-form<?php echo $jqxPrefix;?>').attr('action', "{{$searchNoteUrl}}").submit();
        });


        $(".btn-delete").on('click',function(){
            var $id=$(this).attr('data-id');
            var title = '{{$constant['buttonDelete']}}';
            var content = '{{trans('trans.confirm_delete')}}';

            $.confirm({
                icon: 'glyphicon glyphicon-trash',
                title: title,
                content: content,
                draggable: true,
                buttons: {
                    danger: {
                        text: 'លុប',
                        btnClass: 'btn-blue',
                        action: function(){
                            $.ajax({
                                type: "POST",
                                url: '{{$searchNoteUrlDelete}}',
                                data:{'id':$id,'_token':'{{ csrf_token() }}'},
                                success : function(response) {
                                    $("#jqx-notification").jqxNotification();
                                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:3000});

                                    if(response.code==2){
                                        $('#jqx-notification').jqxNotification({ position: positionNotify,template: "success" }).html(response.message);
                                            $("#jqx-notification").jqxNotification("open");
                                        window.location.reload();
                                    }else{
                                        $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning",autoClose: false }).html(response.message);
                                            $("#jqx-notification").jqxNotification("open");

                                    }
                                }
                            });
                        }
                    },
                    warning: {
                        text: 'បោះបង់',
                        btnClass: 'btn-red any-other-class'
                    }
                }
            });
        });
    });
</script>
@endsection
