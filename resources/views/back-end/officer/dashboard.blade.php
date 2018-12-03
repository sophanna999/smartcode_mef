<?php
$jqxPrefix = '_officer';
$listUrl = asset($constant['secretRoute'].'/officer/index');
$newUrl = asset($constant['secretRoute'].'/officer/new');
$editUrl = asset($constant['secretRoute'].'/officer/edit');
$deleteUrl = asset($constant['secretRoute'].'/officer/delete');
$detailUrl = asset($constant['secretRoute'].'/officer/detail');
$pushBackUrl = asset($constant['secretRoute'].'/officer/push-back');
$viewPreApproveUrl = asset($constant['secretRoute'].'/officer/pre-approved');
$isCountUrl = asset($constant['secretRoute'].'/officer/is-count');
?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
        {{--<div class="blg-btn-dashboard">--}}
            {{--<ul id="filter_type" class="list-dashboard">--}}
                {{--<li data-id="0" data-text="{{$constant['registered']}}">{{$constant['registered']}}<span>{{$total_registered}}</span></li>--}}
                {{--<li data-id="1" data-text="{{$constant['completed']}}">{{$constant['completed']}}<span>{{$total_submitted}}</span></li>--}}
                {{--<li data-id="2" data-text="{{$constant['approved']}}">{{$constant['approved']}}<span>{{$total_approved}}</span></li>--}}
                {{--<li data-id="3" data-text="{{$constant['waitingApproval']}}">{{$constant['waitingApproval']}}<span>{{$total_waiting_approval}}</span></li>--}}
            {{--</ul>--}}
        {{--</div>--}}
        <!--blg-btn-dashboard-->
        <div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                        <div class="col-lg-12 col-xs-12">{{trans('officer.officer_hisotry')}} &raquo; <span id="text_status">{{trans('officer.list_officer')}}</span></div>
                    </div>
                    <div class="pull-right warp-btn-top">
                        <button style="display: none" id="btn-printcard"><i class="glyphicon glyphicon-print"></i> {{trans('officer.buttonPrintCard')}}</button>

                        <button id="btn-edit"><i class="glyphicon glyphicon-comment"></i> {{trans('trans.buttonEdit')}}</button>
                        <button id="btn-push-back"><i class="glyphicon glyphicon-comment"></i>ជូនដំណឹង</button>
                        <button id="btn-approve"><i class="glyphicon glyphicon-ok-sign"></i> {{trans('officer.approve')}}</button>
                        <button id="btn-preAprroInfo"><i class="glyphicon glyphicon-list-alt"></i> {{trans('officer.check_difference')}}</button>
                        <button id="btn-detail"><i class="glyphicon glyphicon-eye-open"></i> {{trans('trans.detailInfo')}}</button>
                        <button id="btn-delete"><i class="glyphicon glyphicon-trash"></i> {{trans('trans.buttonDelete')}}</button>

                    </div>
                </div>
                <div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        // prepare the data
        var source<?php echo $jqxPrefix;?> = {
            type: "post",
            dataType: "json",
            data:{"_token":'{{ csrf_token() }}'},
            dataFields: [
                { name: 'Id', type: 'number' },
                { name: 'full_name_kh', type: 'string' },
                { name: 'full_name_en', type: 'string' },
                { name: 'email', type: 'string' },
                { name: 'avatar', type: 'string' },
                { name: 'phone_number_1', type: 'string' },
                { name: 'general_department_name', type: 'string' },
                { name: 'department_name', type: 'string' },
                { name: 'is_register', type: 'number' },
                { name: 'register_date', type: 'date' },
                { name: 'is_approve', type: 'number'},
                { name: 'positionName', type: 'string' },
                { name: 'orderNumber', type: 'number'},
                { name: 'isCount', type: 'number'}

            ],
            id: 'Id',
            url: '<?php echo $listUrl;?>',
            beforeprocessing: function(data) {
                source<?php echo $jqxPrefix;?>.totalrecords = (data != null)? data.total:0;
            },
            sort: function(data) {
                // Short Data
                $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('updatebounddata', 'sort');
            },
            filter: function() {
                $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('updatebounddata', 'filter');
            },
            deleteRow: function (rowid, commit) {
                
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: "<?php echo $deleteUrl;?>",
                    cache: false,
                    data: {"Id":rowid,"_token":'{{ csrf_token() }}','ajaxRequestJson':'true'},
                    success: function (response, status, xhr) {
                        $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:5000});
                        if(response.code == 1) {
                            //Items delete success
                            closeJqxWindowId('jqxwindow<?php echo $jqxPrefix;?>');
                            $('#jqx-notification').jqxNotification({ position: positionNotify,template: "success"}).html(response.message);
                            $("#jqx-notification").jqxNotification("open");
                        }else{
                            $('#jqx-notification').jqxNotification({ position: positionNotify,template: "success",autoClose: false }).html(response.message);
                            $("#jqx-notification").jqxNotification("open");
                        }

                        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('updatebounddata');
                        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('clearselection');
                    },
                    error: function (request, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            updaterow: function (rowid, rowdata, commit) {
            var isCount = rowdata.isCount;
            $.ajax({
                type: "post",
                dataType: "json",
                url: "<?php echo $isCountUrl;?>",
                cache: false,
                data: {"Id":rowid,"isCount":isCount,"_token":'{{ csrf_token() }}','ajaxRequestJson':'true'},
                success: function (response, status, xhr) {
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    if(response.code == 0) {
                        //failed
                        $('#jqx-notification').jqxNotification({position: positionNotify,template: "warning",autoClose: false}).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }else{
                        //success
                        $('#jqx-notification').jqxNotification({ position: positionNotify, template: "success" }).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }
                },
                error: function (request, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
            commit(true);
        }
        };

        var avatar<?php echo $jqxPrefix;?> = function (row, datafield, value) {
            var asset;
            if(value == ''){
                asset = '<?php echo asset('/'); ?>images/photo-default.jpg';
            }else{
                asset = '<?php echo asset('/'); ?>/' + value;
            }
            return '<div style="text-align: center; margin-top:3px;"><img width="45" height="45"  src="' + asset + '" /></div>';
        };

        var active<?php echo $jqxPrefix;?> = function (row, datafield, value) {
            console.log(row);
            return value == 1 ? '<div style="text-align: center; margin-top: 5px;"><input id="checkBox" type="checkbox" checked></div>':'<div style="text-align: center; margin-top: 5px;"><input id="checkBox" type="checkbox"></div>';
        };

        $(document).ready(function () {
            //Button action
            var buttons = ['btn-printcard','btn-detail','btn-approve','btn-delete','btn-push-back','btn-preAprroInfo','btn-edit'];
            initialButton(buttons,130,30);

            var grid_height = $(window).height() - 220;

            var dataAdapter = new $.jqx.dataAdapter(source<?php echo $jqxPrefix;?>);

            // create Tree Grid
            $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid({
                theme:jqxTheme,
                width:'100%',
                height:grid_height,
                rowsheight:50,
                source: dataAdapter,
                sortable: true,
                pageable: true,
                editable: true,
                pagerMode: 'advanced',
                showfilterrow: true,
                filterable: true,
                enabletooltips: true,
                pageSize: <?php echo $constant['pageSize'];?>,
                pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
                virtualmode: true,
                rendergridrows: function(obj) {
                    return obj.data;
                },
                columns: [
                    { text: '{{trans("officer.avatar")}}', filterable:false,enabletooltips:false,editable:false,dataField: 'avatar', width: '4%',align:'center',cellsrenderer: avatar<?php echo $jqxPrefix;?>},
                    { text: '{{trans("officer.full_name")}}', dataField: 'full_name_kh',editable:false, width: '10%'},
                    { text: '{{trans("officer.english_name")}}', dataField: 'full_name_en',editable:false, width: '10%'},
                    { text: '{{trans("trans.status")}}',dataField: 'is_register', width: '8%',filtertype: 'list',editable:false, filteritems:<?php echo $listStatus;?>,createfilterwidget: function(column, columnElement, widget){widget.jqxDropDownList({ dropDownWidth: 140,dropDownHeight:100,searchMode: 'contains',filterable:true,filterPlaceHolder:'{{trans('trans.buttonSearch')}}' });}},
                    { text: '{{trans("officer.register_date")}}', dataField: 'register_date', width: '12%',editable:false,filtertype: 'date',cellsformat: 'dd/MM/yyyy h:mm tt'},
                    { text: '{{trans("trans.position")}}', dataField: 'positionName',editable:false, width: '10%'},
                    { text: '{{trans("officer.phone_number")}}', dataField: 'phone_number_1',editable:false, width: '15%'},
                    { text: '{{trans("officer.email")}}', dataField: 'email', width: '16%',editable:false},
                    { text: '{{trans("officer.generalDepartment")}}/អង្គភាព ', dataField: 'general_department_name',editable:false, width: '25%', filtertype:'list',filteritems:<?php echo $general_department;?>,createfilterwidget: function(column, columnElement, widget){widget.jqxDropDownList({dropDownHeight:400,searchMode: 'contains',filterable:true,filterPlaceHolder:'{{trans('trans.buttonSearch')}}'});}},
                    { text: '{{trans("trans.orderNumber")}}', dataField: 'orderNumber', width: '5%',editable:false,filterable: false},
                    { text: '{{trans("officer.is_count")}}', dataField: 'isCount', width: '10%',filterable: false,cellEdit:true,formatoptions: {disabled : false},editable: true,
                        cellsrenderer: function (row, datafield, value) {
                            
                        },columntype: 'checkbox',
                        buttonclick: function (row) {
                            console.log(value);
                            var dataRecord = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
                            $('#jqx-grid<?php echo $jqxPrefix;?>').jqxGrid('updaterow', rowData.Id);
                        }, align:'center'},
                    { text: ' ', dataField: 'is_approve',hidden:true}
                ]
            });
            //Approve
            $("#btn-approve").on('click',function(){
                var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
                var rowData = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
                if(rowData == undefined){
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    $('#jqx-notification').jqxNotification({
                        position: positionNotify,
                        template: "warning"
                    }).html('{{trans("trans.eidt_row_msg")}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }

                //Registerd
                if(rowData['is_register'] == '<?php echo $registered[0];?>'){
                    var full_name_kh = rowData.full_name_kh;
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    $('#jqx-notification').jqxNotification({position: positionNotify, template: "warning"}).html(full_name_kh + ' {{trans("officer.approve_msg")}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }

                //Already Approved
                if(rowData['is_register'] == '<?php echo $registered[2];?>'){
                    var full_name_kh = rowData.full_name_kh;
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    $('#jqx-notification').jqxNotification({position: positionNotify, template: "warning"}).html(full_name_kh + ' {{trans("officer.already_approve_msg")}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }

                if(rowData['is_register'] == '<?php echo $registered[1];?>' || rowData['is_register'] == '<?php echo $registered[3];?>'){
                    newJqxItem('<?php echo $jqxPrefix;?>', '{{trans("officer.approve")}}',800,650, '{{$newUrl}}', rowData.Id, '{{ csrf_token() }}');
                }

            });

            //Push Back
            $("#btn-push-back").on('click',function(){
                var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
                var rowData = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
                if(rowData == undefined){
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    $('#jqx-notification').jqxNotification({
                        position: positionNotify,
                        template: "warning"
                    }).html('{{trans("trans.eidt_row_msg")}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }
                newJqxItem('<?php echo $jqxPrefix;?>', 'PUSH BACK',700,510, '{{$pushBackUrl}}', rowData.Id, '{{ csrf_token() }}');
            });

            // This is old button edit
            $("#btn-edit").on('click',function(){
                var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
                var rowData = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
                if(rowData == undefined){
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    $('#jqx-notification').jqxNotification({
                        position: positionNotify,
                        template: "warning"
                    }).html('{{trans("trans.eidt_row_msg")}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }
                var url ='{{$editUrl}}/' + rowData.Id;
                window.open(url, '_blank');
            });

            //Detail
            $("#btn-detail").on('click',function(){
                var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
                var rowData = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
                if(rowData == undefined){
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    $('#jqx-notification').jqxNotification({
                        position: positionNotify,
                        template: "warning"
                    }).html('{{trans("trans.eidt_row_msg")}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }
                var url ='{{$detailUrl}}/' + rowData.Id;
                window.open(url, '_blank');
            });

            $("#btn-delete").on('click',function(){
                var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
                var rowData = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
                if(row.length == 0){
                    $("#jqx-notification").jqxNotification();
                    $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{trans("trans.deleteRow")}}');
                    $("#jqx-notification").jqxNotification("open");
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    return false;
                }
				var title = '{{$constant['buttonDelete']}}';
				var content = '{{trans('trans.confirm_delete')}}';
				confirmDelete(title,content,function () {
					$('#jqx-grid<?php echo $jqxPrefix;?>').jqxGrid('deleteRow', rowData.Id);
				});
            });

            /* Filter by 1=Register,2=Submit,3=Approve, 4=Waiting Approval */
            $("#filter_type li").on('click',function(){
                var filtervalue = ($(this).attr("data-id"));
                var filtertext = ($(this).attr("data-text"));
                if (filtervalue) {
                    var nameFilterGroup = new $.jqx.filter();
                    nameFilterGroup.operator = 'or';
                    filtercondition = 'EQUAL';
                    var nameFilter = nameFilterGroup.createfilter('stringfilter', filtervalue, filtercondition);
                    nameFilterGroup.addfilter(1, nameFilter);
                    $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('addfilter', 'is_approve', nameFilterGroup);

                    //apply filter
                    $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('applyfilters');
                }else {
                    $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('clearfilters');
                }

                /* Append filter text into span */
                $('#text_status').html(filtertext);
            });


            // btn-preAprroInfo
            $("#btn-preAprroInfo").on('click',function(){
                var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
                var rowData = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
                if(rowData == undefined){
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    $('#jqx-notification').jqxNotification({
                        position: positionNotify,
                        template: "warning"
                    }).html('{{trans("trans.eidt_row_msg")}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }

                //Registerd
                if(rowData['is_register'] == '<?php echo $registered[0];?>'){
                    var full_name_kh = rowData.full_name_kh;
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    $('#jqx-notification').jqxNotification({position: positionNotify, template: "warning"}).html(full_name_kh + ' {{trans("officer.approve_msg")}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }

                // Already Approved
                if(rowData['is_register'] == '<?php echo $registered[1];?>'){
                    var full_name_kh = rowData.full_name_kh;
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    $('#jqx-notification').jqxNotification({position: positionNotify, template: "warning"}).html(full_name_kh + ' {{trans("officer.no_wait_approv_msg")}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }
                if(rowData['is_register'] == '<?php echo $registered[3];?>' || rowData['is_register'] == '<?php echo $registered[2];?>' ){
                    var url ='{{$viewPreApproveUrl}}/' + rowData.Id;
                    window.open(url, '_blank');
                }
            });

        });
    </script>
@endsection