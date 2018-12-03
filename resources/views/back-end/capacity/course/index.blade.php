@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
        <div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                    <div class="col-lg-12">{{trans('general.capacity_building')}} &raquo;{{trans('course.course')}}</div>            
                </div>
                <div class="pull-right" style="padding-right: 20px;">
                    <button id="btn-detail"><i class="glyphicon glyphicon-info"></i>{{ trans('general.detail') }}</button>
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
                { name: 'title', type: 'string' },
                { name: 'subject', type: 'string' },
                { name: 'description', type: 'description' },
                { name: 'status', type: 'number' },
                ],
            cache: false,
            id: 'id',
            url: '{{ secret_route() }}/course/lists',
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
                ajaxPostRequest('{{ secret_route()}}/course',{ _method:'DELETE',id:rowid});
            }
        };
        var numberRenderer = function (row, column, value) {
            return '<div style="text-align: center; margin-top:10px;">' + (1 + value) + '</div>';
        };
        
        $(document).ready(function () {
            //Button action
            var buttons = ['btn-detail','btn-new','btn-edit','btn-delete'];
            initialButton(buttons,90,30);
            var dataAdapter = new $.jqx.dataAdapter(source);

            var cellsrenderer = function (row, columnfield, value, defaulthtml, columnproperties,rowdata) {
                                    if(columnfield == 'code'){
                                        if(rowdata.status == 0)
                                            return rowdata.code +' <span class="badge">{{ trans('general.inactive') }}</span>';
                                        else 
                                            return rowdata.code;
                                    }
                                    var subjects = '';
                                        for (let key in value) {
                                            subjects += value[key].name +',';
                                        }
                                    return subjects.substring(0,subjects.length -1);
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
                    autoheight: true,
                    autorowheight: true,
                    pageSize: <?php echo $constant['pageSize'];?>,
                    pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
                    rendergridrows: function(obj) {
                        return obj.data;
                    },
                    columns: [
                        { text: '{{ trans('course.code') }}', dataField: 'code',cellsrenderer: cellsrenderer},
                        { text: '{{ trans('course.title') }}', dataField: 'title'},
                        { text: '{{ trans('subject.subject') }}', datafield: 'subject', cellsrenderer: cellsrenderer},
                        { text: '{{ trans('course.description') }}', dataField: 'description'},
                    ]
            });

            $("#btn-new").on('click',function(){
                newJqxItem('', '{{$constant['buttonNew']}}',800,540, '{{ secret_route() }}/course/create');
            });

            $("#btn-edit").on('click',function(){
                var row = $("#jqx-grid").jqxGrid('getselectedrowindexes');
                if(!row.length){
                    notification('{{ trans('general.please_select_row') }}','warning');
                }else if(row.length > 1){
                    notification('{{ trans('general.please_select_only_one_row') }}','warning');
                }else{
                    var jqxdatarow = $("#jqx-grid").jqxGrid('getrowdata', row);
     
                    newJqxItem('', '{{$constant['buttonEdit']}}', 700, 540, '{{ secret_route() }}/course/edit/'+ jqxdatarow.uid);
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
     
                    newJqxItem('detail_course', '{{ trans('general.detail') }}', 1200, 700, '{{ secret_route() }}/course/show/'+ jqxdatarow.uid);
                }
            });

        });
    </script>
@endsection