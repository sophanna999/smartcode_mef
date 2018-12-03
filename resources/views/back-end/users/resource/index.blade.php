<?php
$jqxPrefix = '_resource';
$listUrl = asset($constant['secretRoute'].'/resource/index');
$newUrl = asset($constant['secretRoute'].'/resource/new');
$editUrl = asset($constant['secretRoute'].'/resource/edit');
$deleteUrl = asset($constant['secretRoute'].'/resource/delete');
?>
@extends('layout.back-end')
@section('content')
<div id="content-container" class="content-container">
		<div class="panel">
          <div class="row panel-heading custome-panel-headering">
              <div class="form-group title-header-panel">
                  <div class="pull-left">
                      <div class="col-lg-12 col-xs-12">{{trans('users.userAuthorize')}} &raquo; RESOURCE</div>
                  </div>
                  <div class="pull-right">
                      <div class="col-lg-12 col-xs-12">
                          <button id="btn-new"><i class="glyphicon glyphicon-plus"></i> {{trans('trans.buttonNew')}}</button>
                          <button id="btn-edit"><i class="glyphicon glyphicon-edit"></i> {{trans('trans.buttonEdit')}}</button>
                          <button id="btn-delete"><i class="glyphicon glyphicon-trash"></i> {{trans('trans.buttonDelete')}}</button>
                      </div>
                  </div>
              </div>

                <div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
            </div>
        </div>
	</div>
    <script type="text/javascript">
		var window_widht = 900;
		var window_height = 600;
        // prepare the data
        var source<?php echo $jqxPrefix;?> =
        {
            type: "post",
            dataType: "json",
            data:{"_token":'{{ csrf_token() }}'},
            dataFields: [
                { name: 'id', type: 'number' },
                { name: 'name', type: 'string' },
                { name: 'url', type: 'string' },
				{ name: 'icon', type: 'string' },
                { name: 'description', type: 'string' },
                { name: 'parent_id', type: 'string' },
                { name: 'order', type: 'number' },
                { name: 'active', type: 'number' },
				{ name: 'privilege', type: 'number' },
				{ name: 'status', type: 'string' }
            ],
            id: 'id',
            url: '<?php echo $listUrl;?>',
            hierarchy:
            {
                keyDataField: { name: 'id' },
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
        var active<?php echo $jqxPrefix;?> = function (row, datafield, value) {
            return value == 0 ? '<div style="text-align: center; margin-top: 5px;"><i class="glyphicon glyphicon-remove"></i></div>':'<div style="text-align: center; margin-top: 5px;"><i class="glyphicon glyphicon-ok"></i></div>';
        };
		var icon<?php echo $jqxPrefix;?> = function (row, datafield, value) {
            var asset,icon;
			if(value == ''){
				asset = '<?php echo asset('/'); ?>icon/folder.png';
				icon = '';
            }else{
				asset = '<?php echo asset('/'); ?>/' + value;
				icon = '<img width="17" height="17"  src="' + asset + '" />';
			}
            return '<div style="text-align: center; margin-top:5px;">' + icon + '</div>';
        };

        $(document).ready(function () {
            //Button action
			var buttons = ['btn-new','btn-edit','btn-delete'];
            initialButton(buttons,90,30);
			
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
                        { text: '{{trans('users.resources')}}', dataField: 'name', width: '30%' },
                        { text: '{{trans('users.customControllers')}}', dataField: 'url', width: '26%' },
                        { text: '{{trans('trans.description')}}', dataField: 'description', width: '25%' },
						{ text: '{{trans('users.icon')}}', dataField: 'icon', width: '7%' ,cellsalign: 'center', align:'center',cellsrenderer: icon<?php echo $jqxPrefix;?>},
                        { text: '{{trans('news.order')}}', dataField: 'order', width: '7%',cellsalign: 'center', align:'center'},
                        { text: '{{trans('trans.active')}}', dataField: 'active', width: '5%', cellsrenderer: active<?php echo $jqxPrefix;?>, align:'center' }
                    ]
            });

            $("#btn-new").on('click',function(){
                newJqxItem('<?php echo $jqxPrefix;?>', '{{trans('trans.buttonNew')}}',window_widht,window_height, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
            });
            $("#btn-edit").on('click',function(){
                var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxTreeGrid('getSelection')[0];
                if(row == null){
                    $("#jqx-notification").jqxNotification();
                    $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{$constant['editRow']}}');
                    $("#jqx-notification").jqxNotification("open");
                    return false;
                }
                newJqxItem('<?php echo $jqxPrefix;?>', '{{trans('trans.buttonEdit')}}',window_widht,window_height, '<?php echo $editUrl;?>', row.id, '{{ csrf_token() }}');
            });
            $("#btn-delete").click(function(){
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
					$('#jqx-grid<?php echo $jqxPrefix;?>').jqxTreeGrid('deleteRow', row.id);
				});
            });
        });
    </script>
@endsection