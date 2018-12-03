<?php
$jqxPrefix = '_news_category';
$newUrl = asset($constant['secretRoute'].'/news-category/new');
$editUrl = asset($constant['secretRoute'].'/news-category/edit');
$listUrl = asset($constant['secretRoute'].'/news-category/index');
$deleteUrl = asset($constant['secretRoute'].'/news-category/delete');
?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
		<div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                    <div class="col-lg-12">{{trans('news.news_management')}} &raquo; {{trans('news.news_category')}}</div>
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
                { name: 'name', type: 'string' },
				{ name: 'order_number', type: 'number' },
	            { name: 'icon', type: 'string' },
	            { name: 'category_status', type: 'string' },
                { name: 'parent_id', type: 'string' },
                { name: 'user_name', type: 'string' }
            ],
			cache: false,
            id: 'Id',
            url: '<?php echo $listUrl;?>',
            hierarchy:
                {
                    keyDataField: { name: 'Id' },
                    parentDataField: { name: 'parent_id' }
                },
            deleteRow: function (rowid, commit) {
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: "<?php echo $deleteUrl;?>",
                    cache: false,
                    data: {"Id":rowid,"_token":'{{ csrf_token() }}','ajaxRequestJson':'true'},
                    success: function (response, status, xhr) {
                        $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                        if(response.code == 0){
                            $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning",autoClose: false }).html(response.message);
                            $("#jqx-notification").jqxNotification("open");
                        }else{
                            closeJqxWindowId('jqxwindow<?php echo $jqxPrefix;?>');
                            $('#jqx-notification').jqxNotification({ position: positionNotify,template: "success" }).html(response.message);
                            $("#jqx-notification").jqxNotification("open");
                        }

                        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxTreeGrid('updateBoundData');
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
        var icon<?php echo $jqxPrefix;?> = function (row, datafield, value) {
	        var asset;
	        if(value == ''){
		        asset = '<?php echo asset('/'); ?>images/default.png';
	        }else{
		        asset = '<?php echo asset('/'); ?>/' + value;
	        }
	        return '<div style="text-align: center; margin-top:1px;"><img width="40" height="40"  src="' + asset + '"  /></div>';
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
            $("#jqx-grid<?php echo $jqxPrefix;?>").jqxTreeGrid({
                theme:jqxTheme,
                width:'100%',
                height:gridHeight,
                source: dataAdapter,
                sortable: false,
                pageable: false,
                pagerMode: 'advanced',
                filterable: false,
                filterMode: 'advanced',
                selectionMode: 'singlerow',
                pageSize: <?php echo $constant['pageSize'];?>,
                pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
                    columns: [
                        { text: '{{trans('news.category_name')}}', dataField: 'name', width: '70%'},
	                    { text: '{{trans('news.image')}}', dataField: 'icon', width: '5%', filterable:false, align:'center',cellsrenderer: icon<?php echo $jqxPrefix;?>},
                        { text: '{{trans('trans.status')}}', dataField: 'category_status', width: '8%', filterable:false },
                        { text: '{{trans('news.create_by')}}', dataField: 'user_name', width: '10%', filterable:false },
                        { text: '{{trans('news.order_number')}}', dataField: 'order_number', width: '7%', filterable:false,cellsalign: 'center', align:'center' }
                    ]
            });

           
            $("#btn-new<?php echo $jqxPrefix;?>").on('click',function(){
                newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}',550,450, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
            });
            $("#btn-edit<?php echo $jqxPrefix;?>").on('click',function(){
                var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxTreeGrid('getSelection')[0];
                if(row == null){
                    $("#jqx-notification").jqxNotification();
                    $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{$constant['editRow']}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }
                newJqxItem('<?php echo $jqxPrefix;?>', '{{trans('trans.buttonEdit')}}',550,450, '<?php echo $editUrl;?>', row.Id, '{{ csrf_token() }}');
            });
            $("#btn-delete<?php echo $jqxPrefix;?>").click(function(){
                var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxTreeGrid('getSelection')[0];
                if(row == null){
                    $("#jqx-notification").jqxNotification();
                    $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{$constant['deleteRow']}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }       
				var title = '{{$constant['buttonDelete']}}';
				var content = '{{trans('trans.confirm_delete')}}';
				confirmDelete(title,content,function () {
					$('#jqx-grid<?php echo $jqxPrefix;?>').jqxTreeGrid('deleteRow', row.Id);
				});
            });

        });
    </script>
@endsection