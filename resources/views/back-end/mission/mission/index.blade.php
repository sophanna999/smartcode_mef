<?php
$jqxPrefix = '_mission';
$newUrl = asset($constant['secretRoute'].'/mission/new');
$newUrlRef = asset($constant['secretRoute'].'/mission/new-reference');
$listUrl = asset($constant['secretRoute'].'/mission/index');
$deleteUrl = asset($constant['secretRoute'].'/mission/delete');
$list_mission_to_officer = asset($constant['secretRoute'].'/mission/list-mission-to-officer');
$modalExport = asset($constant['secretRoute'].'/mission/modal-export');
$printVisaUrl = asset($constant['secretRoute'].'/mission/print-visa');
$printMissionUrl = asset($constant['secretRoute'].'/mission/print-mission');
$editUrl = asset($constant['secretRoute'].'/mission/edit');
?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
		<div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                    <div class="col-lg-12">{{trans('mission.mission')}} &raquo;  {{trans('mission.mission_setting')}}</div>
                </div>
				<div class="pull-right">
                    <div class="col-lg-12 col-xs-12">
                        <button id="btn-new"><i class="glyphicon glyphicon-plus"></i> {{trans('trans.buttonNew')}}</button>
                        <button id="btn-edit"><i class="glyphicon glyphicon-edit"></i> {{trans('trans.buttonEdit')}}</button>
                        <button id="btn-delete"><i class="glyphicon glyphicon-trash"></i> {{trans('trans.buttonDelete')}}</button>
                        <button id="btn-export"><i class="glyphicon glyphicon-download-alt"></i> {{trans('trans.export')}}</button>
                    </div>
                </div>
                </div>
                <div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
            </div>
        </div>
	</div>
<script type="text/javascript">

		var width_form =  $( document ).width();
		var height_form = $( document ).height();
        // prepare the data
        var source<?php echo $jqxPrefix;?> =
        {
            type: "post",
            dataType: "json",
            data:{"_token":'{{ csrf_token() }}'},
            dataFields: [
                { name: 'id', type: 'number' },
				{ name: 'mission_type_name', type: 'string' },
                { name: 'mission_from_date', type: 'date' },
				{ name: 'mission_to_date', type: 'date' },
				{ name: 'mission_location', type: 'string' },
				{ name: 'mission_transportation', type: 'string' },
				{ name: 'mission_objective', type: 'string' },
				{ name: 'create_by_user', type: 'string' }
            ],
            id: 'id',
            url: '{{$listUrl}}',
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
                    data: {"id":rowid,"_token":'{{ csrf_token() }}'},
                    success: function (response, status, xhr) {
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
                            closeJqxWindowId('jqxwindow<?php echo $jqxPrefix;?>');
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
			var buttons = ['btn-new','btn-edit','btn-delete','btn-export'];
            initialButton(buttons,105,30);

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
                        { text: '{{trans('mission.mission_type')}}', dataField: 'mission_type_name', width: '9%' }
                        ,{ text: '{{trans('mission.mission_from_date')}}', dataField: 'mission_from_date', width: '8%', filtertype: 'date',cellsformat: 'dd/MM/yyyy' }
						,{ text: '{{trans('mission.mission_to_date')}}', dataField: 'mission_to_date', width: '8%', filtertype: 'date',cellsformat: 'dd/MM/yyyy' }
						,{ text: '{{trans('mission.mission_objective')}}', dataField: 'mission_objective', width: '40%' }
						,{ text: '{{trans('mission.mission_transportation')}}', dataField: 'mission_location', width: '10%' }
                        ,{ text: '{{trans('news.create_by')}}', dataField: 'create_by_user', width: '7%' }
						,{ text: '{{trans('mission.add_number').trans('mission.number')}}',filterable:false,sortable: false, dataField: 'refferen_no', width: '5%',editable: false,
                            cellsrenderer: function (row, datafield, value) {
                                return "{{trans('mission.add_number').trans('mission.number')}}";
                            }, columntype: 'button',
                            buttonclick: function (row) {
                                var dataRecord = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
                                var width = 800;
                                var height = 400;
                                if(dataRecord.all == 1){
                                    width = 450;
                                    height = 80;
                                }
                                newJqxItem('{{$jqxPrefix}}', '{{trans('mission.add_number').trans('mission.number')}}',width,height, '{{$newUrlRef}}', dataRecord.id, '{{ csrf_token() }}');
                            }
                        }
                        ,{ text: '{{trans('trans.detailInfo')}}',filterable:false,sortable: false, dataField: 'detailInfo', width: '10%',editable: false,
							cellsrenderer: function (row, datafield, value) {
								return "{{trans('trans.detailInfo')}}";
							}, columntype: 'button',
							buttonclick: function (row) {
								var dataRecord = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
								var width = 1024;
								var height = 600;
								if(dataRecord.all == 1){
									width = 450;
									height = 80;
								}
								newJqxItem('{{$jqxPrefix}}', '{{trans('trans.detailInfo')}}',width,height, '{{$list_mission_to_officer}}', dataRecord.id, '{{ csrf_token() }}');
							}
						}
                        ,{text: "{{trans('mission.letter').trans('mission.order').trans('mission.mission')}}",filterable:false, dataField: 'print', width: '7%',columngroup: 'print', align: 'center',
                            cellsrenderer: function (row, datafield, value) {
                                return "{{trans('family_situation.print')}}";
                            }, columntype: 'button',
                            buttonclick: function (row) {
                                var dataRecord = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
                                var width = 1024;
                                var height = 600;
                                if(dataRecord.all == 1){
                                    width = 450;
                                    height = 80;
                                }
                                var url ='{{$printMissionUrl}}/' + dataRecord.id;
                                window.open(url, '_blank');
                            }
                        },{text: '{{trans('mission.visa')}}',filterable:false, dataField: 'printMissionUrl', width: '10%',columngroup: 'print', align: 'center',
                            cellsrenderer: function (row, datafield, value) {
                                return "{{trans('family_situation.print')}}";
                            }, columntype: 'button',
                            buttonclick: function (row) {
                                var dataRecord = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
                                var width = 1024;
                                var height = 600;
                                if(dataRecord.all == 1){
                                    width = 450;
                                    height = 80;
                                }
                                var url ='{{$printVisaUrl}}/' + dataRecord.id;
                                window.open(url, '_blank');
                            }
                        }
                    ],
                    columngroups: [
                        { text: '{{trans('family_situation.print')}}', name: 'print',filterable: false, align: 'center' },
                    ]
            });


            $("#btn-new").on('click',function(){
                newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}',width_form,height_form, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
            });

            $("#btn-edit").on('click',function(){
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
                    newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonEdit']}}', width_form, height_form, '<?php echo $editUrl;?>', jqxdatarow.id, '{{ csrf_token() }}');
                }

            });
            $("#btn-delete").click(function(){
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
						listId.push(jqxdatarow.id);
					}
					$('#jqx-grid<?php echo $jqxPrefix;?>').jqxGrid('deleteRow', listId);
				});
            });

			/* Export Excel */
			$("#btn-export").on('click',function(){
                newJqxItem('<?php echo $jqxPrefix;?>', '{{trans('trans.export')}}',410,250, '<?php echo $modalExport;?>', 0, '{{ csrf_token() }}');
            });
			/* Export Excel End */

        });

    </script>
@endsection
