@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
        <div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                    <div class="col-lg-12">{{trans('general.capacity_building')}} &raquo;{{trans('member.member')}}</div>            
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
        var width_form = 1000;
        var height_form = 600;
        // prepare the data
        var source =
        {
            type: "post",
            dataType: "json",
            data:{"_token":'{{ csrf_token() }}'},
            dataFields: [
                { name: 'id', type: 'number' },
                // { name: 'code', type: 'string' },
                { name: 'full_name', type: 'string' },
                { name: 'latin_name', type: 'string' },
                { name: 'phone_number', type: 'string' },
                { name: 'email', type: 'string' },
                { name: 'position', type: 'string' },
                { name: 'company', type: 'string' },
                ],
            cache: false,
            id: 'id',
            url: '{{ secret_route() }}/member/lists',
            beforeprocessing: function(data) {
                source.totalrecords = (data != null)? data.total:0;
            },
            sort: function(data) {
                // Short Data
                $("#jqx-grid").jqxGrid('updatebounddata', 'sort');
            },
            filter: function() {
                $("#jqx-grid").jqxGrid('updatebounddata', 'filter');
            },
            deleteRow: function (rowid, commit) {
                ajaxPostRequest('{{ secret_route()}}/member',{ _method:'DELETE',id:rowid});
            }
        };
        var numberRenderer = function (row, column, value) {
            return '<div style="text-align: center; margin-top:10px;">' + (1 + value) + '</div>';
        };
        
        $(document).ready(function () {
            var buttons = ['btn-new','btn-edit','btn-delete'];
            initialButton(buttons,90,30);
            var dataAdapter = new $.jqx.dataAdapter(source);
   
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
                        // { text: '{{ trans('profile.code') }}', dataField: 'code'},
                        { text: '{{ trans('profile.full_name') }}', dataField: 'full_name'},
                        { text: '{{ trans('profile.latin_name') }}', dataField: 'latin_name'},
                        { text: '{{ trans('profile.phone_number') }}', dataField: 'phone_number'},
                        { text: '{{ trans('profile.email') }}', dataField: 'email'},
                        { text: '{{ trans('profile.position') }}', dataField: 'position'},
                        { text: '{{ trans('profile.company') }}', dataField: 'company'},
                    ]
            });

            $("#btn-new").on('click',function(){
                newJqxItem('', '{{$constant['buttonNew']}}',width_form,height_form, '{{ secret_route() }}/member/create', 0, '{{ csrf_token() }}');
            });

            $("#btn-edit").on('click',function(){

                var row = $("#jqx-grid").jqxGrid('getselectedrowindexes');

                if(!row.length){
                    notification('{{ trans('general.please_select_row') }}','warning');
                }else if(row.length > 1){
                    notification('{{ trans('general.please_select_only_one_row') }}','warning');
                }else{
                    var jqxdatarow = $("#jqx-grid").jqxGrid('getrowdata', row);
     
                    newJqxItem('', '{{$constant['buttonEdit']}}', width_form, height_form, '{{ secret_route() }}/member/edit/'+ jqxdatarow.uid);
                }
            });

            $("#btn-delete").click(function(){
                deleteJqxGrid('deleteRow');
            });

        });
    </script>
@endsection