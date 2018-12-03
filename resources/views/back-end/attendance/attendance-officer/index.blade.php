<?php
$jqxPrefix = '_attendance_officer';
$listUrl = asset($constant['secretRoute'].'/attendance-officer/index');
$newUrl = asset($constant['secretRoute'].'/attendance-officer/new');
$deleteUrl = asset($constant['secretRoute'].'/attendance-officer/delete');
$modalExport = asset($constant['secretRoute'].'/attendance-officer/modal-export');
$editUrl = asset($constant['secretRoute'].'/attendance-officer/edit');
?>
@extends('layout.back-end')
@section('content')
<div id="content-container" class="content-container">
    <div class="panel">
        <div class="row panel-heading custome-panel-headering">
            <div class="form-group title-header-panel">
                <div class="pull-left">
                    <div class="col-lg-12 col-xs-12">{{$constant['attendance-manager']}} &raquo; {{trans('attendance.add_officer_attendance')}} </div>
                </div>
                <div class="pull-right">
                    <div class="col-lg-4 col-xs-3">
                        <button id="btn-new<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-plus"></i> {{$constant['buttonNew']}}</button>
                    </div>
                    <div class="col-lg-4 col-xs-3">
                        <button id="btn-edit<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-edit"></i> {{$constant['buttonEdit']}}</button>
                    </div>
                    <div class="col-lg-4 col-xs-3">
                        <button id="btn-delete<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-trash"></i> {{$constant['buttonDelete']}}</button>
                    </div>
                </div>
            </div>
            <div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
        </div>
        
    </div>
</div>
<style>
    #detail-body{
        overflow-x: hidden;
        overflow-y:auto;
        font-family: 'KHMERMEF1';
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
    .labels-attendance-officer{
        top:10px;
    }
    .table > thead > tr > th{
        border-bottom: 1px solid #ddd;
    }
</style>
<script type="text/javascript">
    var width = ($( window ).width()*0.6);
    var height = $( window ).height()*0.8;
    // prepare the data
        var source<?php echo $jqxPrefix;?> =
        {
            type: "post",
            dataType: "json",
            data:{"_token":'{{ csrf_token() }}'},
            dataFields: [
                { name: 'Id', type: 'number' },
                { name: 'officer_name', type: 'string' },
                { name: 'date', type: 'date' },
                { name: 'section', type: 'string' },
                { name: 'office_name', type: 'office_name' },
                { name: 'detail', type: 'string' },
                
            ],
            cache: false,
            id: 'id',
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
                    data: {"Id":rowid,"_token":'{{ csrf_token() }}'},
                    success: function (response, status, xhr) {
                        console.log(response);
                        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('updatebounddata');
                        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('clearselection');
                        $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                        if(response.code == 0) {
                            //Some items delete execpt the one in used
                            $('#jqx-notification').jqxNotification({position: positionNotify}).html(response.message);
                            $("#jqx-notification").jqxNotification("open");
                        }else if(response.code == 1){
                            //Item in used
                            $('#jqx-notification').jqxNotification({position: positionNotify,template: "success"}).html(response.message);
                            $("#jqx-notification").jqxNotification("open");
                        }else{
                            //Items delete success
                            // closeJqxWindowId('jqxwindow<?php echo $jqxPrefix;?>');
                            $('#jqx-notification').jqxNotification({ position: positionNotify, template: "success" }).html(response.message);
                            $("#jqx-notification").jqxNotification("open");
                        }
                    },
                    error: function (request, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        };
    $(document).ready(function () {
        //Button action
        var buttons = ['btn-new<?php echo $jqxPrefix;?>','btn-edit<?php echo $jqxPrefix;?>','btn-delete<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
        
        // create Tree Grid
        var dataAdapter = new $.jqx.dataAdapter(source<?php echo $jqxPrefix;?>);
        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid({
            theme:jqxTheme,
            width:'100%',
            height:gridHeight,
            source: dataAdapter,
            selectionmode: 'checkbox',
            sortable: true,
            pageable: true,
            virtualmode: true,
            pagerMode: 'advanced',
            enabletooltips: true,
            rowsheight:rowsheight,
            showfilterrow: true,
            filterable: true,
            pageSize: <?php echo $constant['pageSize'];?>,
            pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
            rendergridrows: function(obj) {
                
                return obj.data;
            },
            columns: [
                { text: "{{trans('officer.full_name')}}", dataField: 'officer_name', width: '15%' },
                { text: "{{trans('officer.date')}}", dataField: 'date', width: '13%',filterable: true,filtertype: 'date',cellsformat: 'yyyy-MM-dd' },
                { text: "{{trans('attendance.section')}}", dataField: 'section', width: '7%',filtertype: 'list', filteritems:<?php echo $section;?>,createfilterwidget: function(column, columnElement, widget){
                    widget.jqxDropDownList({ dropDownWidth: 150 });
                }},

                { text: "{{trans('officer.office')}}", dataField: 'office_name', width: '26%',filterable:false },
                { text: "{{trans('officer.detail')}}", dataField: 'detail', width: '40%',filterable:false },
            ]
        });
        $("#btn-new<?php echo $jqxPrefix;?>").on('click',function(){
            newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}',width,height, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
        });
        /* Edit */
        $("#btn-edit<?php echo $jqxPrefix;?>").on('click',function(){
            var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
            $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
            if(row.length == 0){
                $("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{$constant['editRow']}}');
                $("#jqx-notification").jqxNotification("open");
                return false;
            }else if(row.length > 1){
                $("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{$constant['selectOneRow']}}');
                $("#jqx-notification").jqxNotification("open");
                return false;
            }else{
                var jqxdatarow = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
                newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonEdit']}}', width,height, '<?php echo $editUrl;?>', jqxdatarow.Id, '{{ csrf_token() }}');
            }
        });
        $("#btn-delete<?php echo $jqxPrefix;?>").click(function(){
            var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
            if(row.length == 0){
                $("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{$constant['deleteRow']}}');
                $("#jqx-notification").jqxNotification("open");
                $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                return false;
            }
            var listId = [];            
            var title = '{{$constant['buttonDelete']}}';
            var content = '{{trans('trans.confirm_delete')}}';
            confirmDelete(title,content,function () {
                for(var index in row){
                    var jqxdatarow = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row[index]);
                    listId.push(jqxdatarow.Id);
                }
                $('#jqx-grid<?php echo $jqxPrefix;?>').jqxGrid('deleteRow', listId);
            });
        });
    });
</script>
@endsection