@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
        <div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
						<div class="col-lg-12">{{trans('general.capacity_building')}} &raquo;{{trans('training.training')}}</div>            
					</div>
					<div class="pull-right" style="padding-right: 20px;">
						<button id="btn-detail"><i class="glyphicon glyphicon-"></i>{{ trans('general.detail') }}</button>
						<button id="btn-new"><i class="glyphicon glyphicon-plus"></i> {{ trans('general.create') }}</button>
						<button id="btn-edit"><i class="glyphicon glyphicon-edit"></i> {{ trans('general.edit') }}</button>
						<button id="btn-delete"><i class="glyphicon glyphicon-trash"></i> {{ trans('general.delete') }}</button>
					</div>
                <div id="jqx-grid"></div>
				</div>
			</div>
		</div> 

    <script type="text/javascript">
        var source =
        {
            type: "post",
            dataType: "json",
            data:{"_token":'{{ csrf_token() }}'},
            dataFields: [
                { name: 'id', type: 'number' },
                { name: 'status', type: 'number' },
                { name: 'prefix', type: 'string' },
                { name: 'code', type: 'string',},
                { name: 'course', type: 'string',map:'course>title'},
                { name: 'start_date', type: 'start_date' },
                { name: 'end_date', type: 'end_date' },
                { name: 'location', type: 'string',map:'location>name'},
                { name: 'custom_location', type: 'string'},
                ],
            cache: false,
            id: 'id',
            url: '{{ secret_route() }}/training/lists',
            beforeprocessing: function(data) {
                source.totalrecords = (data != null)? data.total:0;
            },
            sort: function(data) {
                $("#jqx-grid").jqxGrid('updatebounddata', 'sort');
            },
            filter: function() {
                $("#jqx-grid").jqxGrid('updatebounddata', 'filter');
            },
            deleteRow: function (rowid, commit) {
                ajaxPostRequest('{{ secret_route()}}/training/delete',{ _method:'DELETE',ids:rowid});
            }
        };
        var numberRenderer = function (row, column, value) {
            return '<div style="text-align: center; margin-top:10px;">' + (1 + value) + '</div>';
        };
        
        $(document).ready(function () {
            //Button action
            var buttons = ['btn-new','btn-edit','btn-delete','btn-detail'];
            initialButton(buttons,90,30);
            var dataAdapter = new $.jqx.dataAdapter(source);

            var cellsrenderer = function (row, columnfield, value, defaulthtml, columnproperties,rowdata) {
                                    if(columnfield == 'code'){
                                        if(rowdata.status == 0)
                                            return rowdata.prefix + rowdata.code +' <span class="badge">{{ trans('general.inactive') }}</span>';
                                        else 
                                            return rowdata.prefix + rowdata.code;
                                    }else if(columnfield == 'location'){
                                        if(rowdata.location_id)
                                            return rowdata.location.name;
                                        else
                                            return rowdata.custom_location;
                                    }
                                };
   
            // create Tree Grid
            $("#jqx-grid").jqxGrid({
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
                        { text: '{{ trans('training.code') }}', dataField: 'code',width:'10%',cellsrenderer:cellsrenderer},
                        { text: '{{ trans('training.course') }}', dataField: 'course',width:'20%'},
                        { text: '{{ trans('training.start_date') }}', dataField: 'start_date',width:'10%'},
                        { text: '{{ trans('training.end_date') }}', dataField: 'end_date',width:'10%'},
                        { text: '{{ trans('training.location') }}', dataField: 'location',cellsrenderer:cellsrenderer},
                    ]
            });

            $("#btn-new").on('click',function(){
                newJqxItem('', '{{$constant['buttonNew']}}',900,700, '{{ secret_route() }}/training/create');
            });

            $("#btn-edit").on('click',function(){
                var row = $("#jqx-grid").jqxGrid('getselectedrowindexes');
                if(!row.length){
                    notification('{{ trans('general.please_select_row') }}','warning');
                }else if(row.length > 1){
                    notification('{{ trans('general.please_select_only_one_row') }}','warning');
                }else{
                    var jqxdatarow = $("#jqx-grid").jqxGrid('getrowdata', row);
     
                    newJqxItem('edit_training', '{{$constant['buttonEdit']}}', 900, 700, '{{ secret_route() }}/training/edit/'+ jqxdatarow.uid);
                }
            });

            $("#btn-delete").click(function(){
                deleteJqxGrid('deleteRow');
            });

            $("#btn-detail").click(function(){
                var row = $("#jqx-grid").jqxGrid('getselectedrowindexes');
                if(!row.length){
                    notification('{{ trans('general.please_select_row') }}','warning');
                }else if(row.length > 1){
                    notification('{{ trans('general.please_select_only_one_row') }}','warning');
                }else{
                    var jqxdatarow = $("#jqx-grid").jqxGrid('getrowdata', row);
     
                    newJqxItem('detail_training', '{{ trans('general.detail') }}', 1200, 700, '{{ secret_route() }}/training/detail/'+ jqxdatarow.uid);
                }

            });

        });
    </script>
@endsection