<?php
$jqxPrefix = '_pushBack';
$listUrl = asset($constant['secretRoute'].'/push-back/index');
$newUrl = asset($constant['secretRoute'].'/push-back/new');
$viewUrl = asset($constant['secretRoute'].'/push-back/view');
?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
        <div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                        <div class="col-lg-12 col-xs-12">{{trans('officer.officer_hisotry')}} &raquo; {{trans('officer.alert')}}</div>
                    </div>
                    <div class="pull-right">
                        <div class="col-lg-6 col-md-2 col-xs-3">
                            <button id="btn-new"><i class="glyphicon glyphicon-comment"></i>ជូនដំណឹង</button>
                        </div>
                        <div class="col-lg-6 col-md-2 col-xs-3">
                            <button id="btn-view"><i class="glyphicon glyphicon-eye-open"></i> {{trans('trans.detailInfo')}}</button>
                        </div>
					</div>
				</div>
				<div class="form-group">
					<div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
				</div>
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
            { name: 'ID', type: 'number' },
            { name: 'FROM_USER_ID', type: 'string' },
            { name: 'TO_USER_ID', type: 'string' },
            { name: 'TITLE', type: 'string' },
            { name: 'COMMENT', type: 'string' },
            { name: 'METHOD_TYPE', type: 'number' },
            { name: 'STATUS', type: 'number' },
			{ name: 'CREATED_DATE', type: 'string' },
            { name: 'IS_READ', type: 'number' }
            
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
        }

    };
    var METHOD_TYPE<?php echo $jqxPrefix;?> = function (row, datafield, value) {     
        return value == 1 ? "<div style='vertical-align: middle;padding-top:7px'>PUSH BACK</div>":"<div style='vertical-align: middle;padding-top:7px'>TRANSFER ACCOUNT </div>";
    };
     var cellclassname = function (row, column, value, data) {
         if (value == 1) {
             return "<div style= 'vertical-align: middle;padding-top: 7px'>បានមើល</div>";
         }else{
             return "<div style= 'vertical-align: middle;padding-top: 7px'>មិនទាន់មើល </div>";
         }
     };

    $(document).ready(function () {
        //Button action
         var buttons = ['btn-new','btn-view'];
         initialButton(buttons,120,30);

        var dataAdapter = new $.jqx.dataAdapter(source<?php echo $jqxPrefix;?>);

        // create Tree Grid
        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid({
                theme:jqxTheme,
                width:'100%',
                height:gridHeight,
                rowsheight:rowsheight,
                source: dataAdapter,
                sortable: true,
                pageable: true,
                pagerMode: 'advanced',
                columnsresize: true,
                showfilterrow: false,
                filterable: false,
                enabletooltips: false,
                pageSize: <?php echo $constant['pageSize'];?>,
                pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
                virtualmode: true,
                rendergridrows: function(obj) {
                    return obj.data;
                },
                columns: [
                    { text: '', dataField: 'TO_USER_ID', width: '0%', hidden:true},
                    { text: 'អ្នកផ្ញើរ',dataField: 'FROM_USER_ID', width: '40%', hidden:true},
                    { text: 'អ្នកទទួល', dataField: 'METHOD_TYPE', width: '55%',filterable:false,cellsrenderer: METHOD_TYPE<?php echo $jqxPrefix;?>},
					{ text: 'កាលបរិច្ឆេទ', dataField: 'CREATED_DATE', width: '25%',filterable:false},
                    { text: 'STATUS', dataField: 'IS_READ', width: '20%',filterable:false,cellsrenderer: cellclassname}
                ],
                closeablegroups:false,
                showgroupsheader: false,
                groupable:true,
                groupsexpandedbydefault: true,
                groups: ['TO_USER_ID']
        });
        $("#btn-new").on('click',function(){
            newJqxItem('<?php echo $jqxPrefix;?>', 'PUSH BACK',560,550, '<?php echo $newUrl; ?>', 0, '{{ csrf_token() }}');
        });
       $("#btn-view").on('click',function(){
                var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
                $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                if(row.length == 0){
                    $("#jqx-notification").jqxNotification();
                    $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('សូមជ្រើសរើសទិន្នន័យដើម្បីមើលព័តមានលំអិត');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }else if(row.length > 1){
                    $("#jqx-notification").jqxNotification();
                    $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{$constant['selectOneRow']}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }else{
                    var jqxdatarow = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
                    newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonEdit']}}', 560,550, '<?php echo $viewUrl; ?>', jqxdatarow.ID, '{{ csrf_token() }}');
                }

            });
    });
</script>
@endsection