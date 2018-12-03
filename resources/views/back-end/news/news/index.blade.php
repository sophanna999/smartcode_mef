<?php
$jqxPrefix = '_news';
$newUrl = asset($constant['secretRoute'].'/news/new');
$editUrl = asset($constant['secretRoute'].'/news/edit');
$listUrl = asset($constant['secretRoute'].'/news/index');
$deleteUrl = asset($constant['secretRoute'].'/news/delete');
?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
		<div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                    <div class="col-lg-12">{{trans('news.news_management')}} &raquo; {{trans('news.define_news')}}</div>
                </div>
                <div class="pull-right">
                    <div class="col-xs-12">
                        <button id="btn-new<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-plus"></i> {{$constant['buttonNew']}}</button>
                        <button id="btn-edit<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-edit"></i> {{$constant['buttonEdit']}}</button>
                        <button id="btn-delete<?php echo $jqxPrefix;?>"><i class="glyphicon glyphicon-trash"></i> {{$constant['buttonDelete']}}</button>
                    </div>
                </div>
                </div>
                <div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
            </div>
        </div>
	</div>
	
<script type="text/javascript">
        
        // prepare the data
        var source<?php echo $jqxPrefix;?> =
        {
            type: "post",
            dataType: "json",
            data:{"_token":'{{ csrf_token() }}'},
            dataFields: [
                { name: 'Id', type: 'number' },
	            { name: 'create_date', type: 'date' },
                { name: 'title', type: 'string' },
				{ name: 'short_description', type: 'string' },
				{ name: 'latest_news', type: 'string' },
				{ name: 'is_publish', type: 'number' },
                { name: 'create_by_user_id', type: 'number'},
                { name: 'image', type: 'string'},
	            { name: 'news_category', type: 'string'}
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
                        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('updatebounddata');
                        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('clearselection');
                        $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                        if(response.code == 0) {
                            //Some items delete execpt the one in used
                            $('#jqx-notification').jqxNotification({position: positionNotify}).html(response.message);
                            $("#jqx-notification").jqxNotification("open");
                        }else if(response.code == 1){
                            //Item in used
                            $('#jqx-notification').jqxNotification({position: positionNotify,template: "warning"}).html(response.message);
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
        var numberRenderer<?php echo $jqxPrefix;?> = function (row, column, value) {
            return '<div style="text-align: center; margin-top: 5px;">' + (1 + value) + '</div>';
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
        $(document).ready(function () {
			//Button action
			var buttons = ['btn-new<?php echo $jqxPrefix;?>','btn-edit<?php echo $jqxPrefix;?>','btn-delete<?php echo $jqxPrefix;?>'];
            initialButton(buttons,90,30);
	        var active<?php echo $jqxPrefix;?> = function (row, datafield, value) {
		        return value == 0 ? '<div style="text-align: center; margin-top: 10px;"><i class="glyphicon glyphicon-remove"></i></div>':'<div style="text-align: center; margin-top:10px;"><i class="glyphicon glyphicon-ok"></i></div>';
	        };
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
						{ text: '{{ trans('news.image') }}', filterable:false,enabletooltips:false,dataField: 'image', width: '5%',align:'center',cellsrenderer: avatar<?php echo $jqxPrefix;?>},
	                    { text: '{{trans('news.date_create_news')}}', dataField: 'create_date', width: '9%', filtertype: 'date',cellsformat: 'dd/MM/yyyy'},
                        { text: '{{trans('news.title')}}', dataField: 'title', width: '24%',filterable:true },
						{ text: '{{trans('news.short_description')}}', dataField: 'short_description', width: '29%' },
	                    { text: '{{trans('news.news_category')}}', dataField: 'news_category', width: '10%',filterable:true },
						{ text: '{{trans('news.latest_news')}}', dataField: 'latest_news', width: '6%', filterable:false, cellsrenderer: active<?php echo $jqxPrefix;?>, align:'center'},
						{ text: '{{trans('news.is_publish')}}', dataField: 'is_publish', width: '6%', filterable:false, cellsrenderer: active<?php echo $jqxPrefix;?>, align:'center'},
                        { text: '{{trans('news.create_by')}}', dataField: 'create_by_user_id', width: '9%'}
                    ]
            });

           
            $("#btn-new<?php echo $jqxPrefix;?>").on('click',function(){
                newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}','100%',700, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
            });

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
                    newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonEdit']}}','100%', 700, '<?php echo $editUrl;?>', jqxdatarow.Id, '{{ csrf_token() }}');
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