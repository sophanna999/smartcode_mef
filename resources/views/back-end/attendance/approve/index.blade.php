<?php
$jqxPrefix = '_takeleave_type';
$newUrl = asset($constant['secretRoute'].'/takeleave-approve/new');
$editUrl = asset($constant['secretRoute'].'/takeleave-approve/edit');
$listUrl = asset($constant['secretRoute'].'/takeleave-approve/index');
$deleteUrl = asset($constant['secretRoute'].'/takeleave-approve/delete');
$listAttendeeUrl = asset($constant['secretRoute'].'/takeleave-approve/list-attendee');
?>
@extends('layout.back-end')
@section('content')



    <div id="content-container" class="content-container">
		<div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                    <div class="col-lg-12">{{$constant['attendance-manager']}} &raquo; {{$constant['take-leave-type']}}</div>
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
<script type="text/javascript">

    var width_form = $(window).width()-200;
		var height_form = $(window).height()-200;
        // prepare the data
        var source<?php echo $jqxPrefix;?> =
        {
            type: "post",
            dataType: "json",
            data:{"_token":'{{ csrf_token() }}'},
            dataFields: [
                { name: 'Id', type: 'number' },
				{ name: 'title', type: 'string' },
				{ name: 'description', type: 'string' }
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
        var numberRenderer<?php echo $jqxPrefix;?> = function (row, column, value) {
            return '<div style="text-align: center; margin-top:10px;">' + (1 + value) + '</div>';
        };
        $(document).ready(function () {
			//Button action
			var buttons = ['btn-new<?php echo $jqxPrefix;?>','btn-edit<?php echo $jqxPrefix;?>','btn-delete<?php echo $jqxPrefix;?>'];
            initialButton(buttons,90,30);

            var dataAdapter = new $.jqx.dataAdapter(source<?php echo $jqxPrefix;?>);

            // create Tree Grid
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
                        { text: '{{$constant['take-leave-type']}}', dataField: 'title', width: '45%' },
                        { text: '{{$constant['description']}}', dataField: 'description', width: '53%' }
                        
                    ]
            });
            $("#btn-new<?php echo $jqxPrefix;?>").on('click',function(){
                newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}',width_form,height_form, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
            });

            $("#btn-edit<?php echo $jqxPrefix;?>").on('click',function(){
                var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
				$("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                if(row.length == 0){
                    $("#jqx-notification").jqxNotification();
                    $('#jqx-notification').jqxNotification({ position: 'bottom-right',template: "warning" }).html('{{$constant['editRow']}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }else if(row.length > 1){
                    $("#jqx-notification").jqxNotification();
                    $('#jqx-notification').jqxNotification({ position: 'bottom-right',template: "warning" }).html('{{$constant['selectOneRow']}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }else{
                    var jqxdatarow = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);

                    newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonEdit']}}', width_form, height_form, '<?php echo $editUrl;?>', jqxdatarow.Id, '{{ csrf_token() }}');
                }

            });
            $("#btn-delete<?php echo $jqxPrefix;?>").click(function(){
                var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
                if(row.length == 0){
                    $("#jqx-notification").jqxNotification();
                    $('#jqx-notification').jqxNotification({ position: 'bottom-right',template: "warning" }).html('{{$constant['deleteRow']}}');
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
