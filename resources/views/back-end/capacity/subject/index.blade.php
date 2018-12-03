@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
        <div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                    <div class="col-lg-12">{{trans('general.capacity_building')}} &raquo;{{trans('subject.subject')}}</div>            
                </div>
                <div class="pull-right" style="padding-right: 20px;">
                    <button id="btn-new"><i class="glyphicon glyphicon-plus"></i> {{$constant['buttonNew']}}</button>
                    <button id="btn-edit"><i class="glyphicon glyphicon-edit"></i> {{$constant['buttonEdit']}}</button>
                    <button id="btn-delete"><i class="glyphicon glyphicon-trash"></i> {{$constant['buttonDelete']}}</button>
                    </div>
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
                { name: 'code', type: 'string' },
                { name: 'name', type: 'string' },
                // { name: 'department', type: 'string',map:'department>Name' },
                { name: 'description', type: 'string' },
                ],
            cache: false,
            id: 'id',
            url: '{{ secret_route() }}/subject/lists',
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
                ajaxPostRequest('{{ secret_route()}}/subject',{ _method:'DELETE',id:rowid});
            }
        };
        var numberRenderer = function (row, column, value) {
            return '<div style="text-align: center; margin-top:10px;">' + (1 + value) + '</div>';
        };
        
        $(document).ready(function () {
            //Button action
            var buttons = ['btn-new','btn-edit','btn-delete'];
            initialButton(buttons,90,30);
            var dataAdapter = new $.jqx.dataAdapter(source);
   
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
                        { text: '{{ trans('subject.code') }}', dataField: 'code'},
                        { text: '{{ trans('subject.name') }}', dataField: 'name'},
                        // { text: '{{ trans('department.department') }}', dataField: 'department'},
                        { text: '{{ trans('subject.description') }}', dataField: 'description'},
                    ]
            });

            $("#btn-new").on('click',function(){
                newJqxItem('', '{{$constant['buttonNew']}}',700,360, '{{ secret_route() }}/subject/create');
            });

            $("#btn-edit").on('click',function(){
                var row = $("#jqx-grid").jqxGrid('getselectedrowindexes');
                if(!row.length){
                    notification('{{ trans('general.please_select_row') }}','warning');
                }else if(row.length > 1){
                    notification('{{ trans('general.please_select_only_one_row') }}','warning');
                }else{
                    var jqxdatarow = $("#jqx-grid").jqxGrid('getrowdata', row);
     
                    newJqxItem('', '{{$constant['buttonEdit']}}', 700, 360, '{{ secret_route() }}/subject/edit/'+ jqxdatarow.uid);
                }
            });

            $("#btn-delete").click(function(){
                deleteJqxGrid('deleteRow');
            });

        });
    </script>
@endsection