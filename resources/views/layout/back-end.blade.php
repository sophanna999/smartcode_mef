<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('icon/mef.ico')}}" />
    <title>{{trans('trans.html_title')}}</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/global.css')}}" type="text/css" />

     {{--OrgChat--}}
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('orgchat/css/jquery.orgchart.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('orgchat/css/style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/smart-module-style.css')}}" type="text/css" />
    {{--end OrgChat--}}

    {{--file--}}
    <link rel="stylesheet" href="{{asset('css/jquery.uploadPreviewer.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/jqueryscriptop.css')}}" type="text/css" />
    {{--end of file--}}
    <script type="text/javascript" src="{{asset('jqwidgets/jquery-1.11.1.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery-ui.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery-ui.multidatespicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    
    <style>
        input[type=password]
        {
            font-family: 'time new roman' !important;
        }
        ::placeholder{
            font-family: 'KHMERMEF1';
        }
        .jconfirm-title,.jconfirm-content,.jconfirm-buttons
        {
            font-family: 'KHMERMEF1' !important;
        }
        #profileOption{
            width: 96px !important;
        }
        #dropDownButtonPopupprofileOption{
            left: 1704px !important;
        }
        #jqxTreeProfile{
            width: 200px !important;
        }
    </style>
</head>
<body>
<input type="hidden" id="baseUrl" value="{{asset('')}}" />
<div id="jqx-notification"></div>
<div id="jqxLoader"></div>
<div class="wrapper">
    <?php
        $sessionUser = session('sessionUser');
        $avatar = $sessionUser->avatar !='' ? $sessionUser->avatar:'images/image-profile.jpg';
        $avatar = asset('/') . $avatar;
        $assetLogo = asset('images/logo-circle.png');
    ?>
    <div class="container-fluid" id="header-container">
        <div class="form-group khmer-font-header">
            <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12" style="margin-top: 5px;">
                <div class="pull-left"><img src="{{$assetLogo}}" height="60" alt="" class="img-circle"></div>
                <div class="pull-left title-admin">
                    <!-- <div class="title-kh">{{trans('trans.institude_name_kh')}}</div>
                    <h1 class="title-en">{{trans('trans.institude_name_en')}}</h1> -->
                   <h1>ការិយាល័យវៃឆ្លាត<br /><span>SMART OFFICE</span></h1>
                </div>
            </div>

          <!--   <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 text-center">
                <h2>{{trans('trans.project_name')}}</h2>
                <h4 style="line-height: 34px; font-family: 'KHMERMEF1'">ជំហានចាប់ផ្តើមឆ្ពោះទៅកាន់រដ្ឋាភិបាលអេឡិកត្រូនិក</h4>
            </div> -->
            <div class="col-lg-4 col-md-6 pull-right">
                <div class="col-lg-8 pull-left text-right" style="padding-top:16px;">
                    <a href="{{ url('/switch') }}" title="{{trans('general.switch_to_frontend')}}"  data-placement="right" data-toggle="tooltip"><i class="glyphicon glyphicon-transfer"></i> </a>
                </div>
                <div class="col-lg-4 col-md-3 col-sm-2 col-xs-8 pull-left text-right ptext-1" style="margin-top: 15px;"> 
                    <img src="{{$avatar}}" class="img-circle" width="35" height="35" alt=""> <strong>{{ucfirst($sessionUser->user_name != null ? $sessionUser->user_name:'administrator')}}</strong>
                    <a href="{{asset('auth/logout')}}" title="{{trans('trans.logout')}}" data-placement="bottom" data-toggle="tooltip"><i class="glyphicon glyphicon-log-out"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div id="splitter">
        <div>
            <div id="jqxTree"></div>
        </div>
        <div id="ContentPanel">
            @yield('content')
        </div>
    </div>
</div>
<div class="form-group text-center footer-developed">
    <p style="color: #fff">
        <i style="font-family: 'time new roman'">&copy;</i>
        <span>{{trans('trans.system_copy_right')}}</span>
    </p>
</div>

<div id="js-var" hidden 
    data-sth-went-wrong="{{ trans('general.something_went_wrong') }}" 
    data-please-select-row="{{ trans('general.please_select_row') }}" 
    data-confirm-delete-title="{{ trans('general.confirm_delete_title') }}" 
    data-confirm-delete-content="{{ trans('general.confirm_delete_content') }}" 
    data-base-url="{{ secret_route() }}" 
    data-dropdown-placeholder="{{ trans('general.chooses') }}" 
    data-dropdown-filter-placeholder="{{ trans('general.type_to_search') }}">
</div>

<script type="text/javascript" src="{{asset('jqwidgets/jqx-all.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxcore.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxdatetimeinput.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxcalendar.js')}}"></script>


{{--add more--}}
<script type="text/javascript" src="{{asset('jqwidgets/jqxpanel.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxtabs.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxradiobutton.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxwindow.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxcheckbox.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxdropdownlist.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxlistbox.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxscrollbar.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxbuttons.js')}}"></script>
<script type="text/javascript" src="{{asset('jqwidgets/jqxtabs.js')}}"></script>
<script type="text/javascript" src="{{asset('js/textAvatar.js')}}"></script>
<script type="text/javascript" src="{{asset('js/upload.js')}}"></script>
{{-- <script src="https://rawgithub.com/hayageek/jquery-upload-file/master/js/jquery.uploadfile.min.js"></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>

{{--end add more--}}
<script type="text/javascript" src="{{asset('js/core-function.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tableToExcel.js')}}"></script>
<script type="text/javascript" src="{{asset('js/highcharts.js')}}"></script>
<script type="text/javascript" src="{{asset('js/highcharts-3d.js')}}"></script>
<script type="text/javascript" src="{{asset('js/code39.js')}}"></script>
<script type="text/javascript" src="{{asset('js/detector.js')}}"></script>
<script type="text/javascript" src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('ckeditor/adapters/jquery.js')}}"></script>
<script src='{{ asset('js/fullcalendar.js') }}'></script>

{{--file--}}
<script src="{{asset('js/jquery.uploadPreviewer.js')}}"></script>
<script src="{{asset('js/humanize.min.js')}}"></script>
{{--end of file--}}

{{--confirm delete--}}
<script type="text/javascript" src="{{asset('js/jquery-confirm.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tag.js')}}"></script>

{{-- custom app js --}}
<script type="text/javascript" src="{{asset('js/custom.js')}}"></script>

@include('layout.notification')

<script>
    $(document).ready(function () {
        
        $('[data-toggle="tooltip"]').tooltip();
        var fullHeight = $(window).height();
        $("#splitter").jqxSplitter({width: '100%', height: (fullHeight)-130, panels: [{ size: 220 }],theme:jqxTheme,splitBarSize:5 });
        var currentPath = '<?php echo $segment['two'];?>';
        /*if(currentPath == 'report'){
            $('#splitter').jqxSplitter('collapse');
        }*/
        var jqxTreeData = <?php echo $treeMenu; ?>;
        // prepare the data
        var treeDataSource = {
            datatype: "json",
            datafields: [
                { name: 'id' },
                { name: 'parentid' },
                { name: 'text'},
                { name: 'value' },
                { name: 'icon' }
            ],
            id: 'id',
            localdata: jqxTreeData
        };
        // create data adapter.
        var dataAdapter = new $.jqx.dataAdapter(treeDataSource);

        // perform Data Binding.
        dataAdapter.dataBind();
        var records = dataAdapter.getRecordsHierarchy('id', 'parentid', 'items', [{ name: 'text', map: 'label'}]);
        $('#jqxTree').jqxTree({ source: records, height: '100%', width: '100%',theme:jqxTheme,allowDrag: false});

		//$('#jqxTree').jqxTree('expandAll');
        $('#jqxTree').on('select', function (event) {
            var args = event.args;
            var item = $('#jqxTree').jqxTree('getItem', args.element);
            if(item.level != 0 && item.hasItems == false){
                $(location).attr('href',basePath + '<?php echo $constant['secretRoute']; ?>/' + item.value);
            }else if(item.level == 0 && item.hasItems == false){
                $(location).attr('href',basePath + '<?php echo $constant['secretRoute']; ?>/' + item.value);
            }
        });
        $("#jqxTree").jqxTree('expandItem', $("#{{$treeMenuId}}")[0]);
        $('#jqxTree li#<?php echo $treeMenuId;?> div').addClass('jqx-rc-all jqx-rc-all-bootstrap jqx-tree-item jqx-tree-item-bootstrap jqx-item jqx-item-bootstrap jqx-tree-item-selected jqx-fill-state-pressed jqx-fill-state-pressed-bootstrap jqx-tree-item-selected-bootstrap');
    });
</script>
</body>
</html>
