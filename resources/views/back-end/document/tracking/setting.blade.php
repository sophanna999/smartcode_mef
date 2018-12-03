@extends('layout.back-end')
@section('content')
<div id="content-container" class="content-container">
        {{--<div class="blg-btn-dashboard">--}}
            {{--<ul id="filter_type" class="list-dashboard">--}}
                {{--<li data-id="0" data-text="{{$constant['registered']}}">{{$constant['registered']}}<span>{{$total_registered}}</span></li>--}}
                {{--<li data-id="1" data-text="{{$constant['completed']}}">{{$constant['completed']}}<span>{{$total_submitted}}</span></li>--}}
                {{--<li data-id="2" data-text="{{$constant['approved']}}">{{$constant['approved']}}<span>{{$total_approved}}</span></li>--}}
                {{--<li data-id="3" data-text="{{$constant['waitingApproval']}}">{{$constant['waitingApproval']}}<span>{{$total_waiting_approval}}</span></li>--}}
            {{--</ul>--}}
        {{--</div>--}}
        <!--blg-btn-dashboard-->
        <div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                        <div class="col-lg-12 col-xs-12">{{trans('document.document_module')}} &raquo; <span id="text_status">{{trans('document.setting')}}</span></div>
                    </div>
                    <div class="pull-right warp-btn-top">
                        <button style="display: none" id="btn-printcard"><i class="glyphicon glyphicon-print"></i> {{trans('officer.buttonPrintCard')}}</button>

                        <button id="btn-edit"><i class="glyphicon glyphicon-comment"></i> {{trans('trans.buttonEdit')}}</button>
  
                        <button id="btn-detail"><i class="glyphicon glyphicon-eye-open"></i> {{trans('trans.detailInfo')}}</button>
                        <button id="btn-delete"><i class="glyphicon glyphicon-trash"></i> {{trans('trans.buttonDelete')}}</button>

                    </div>
                </div>
                <div id="jqx-grid"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
      var source = {
            type: "post",
            dataType: "json",
            data:{"_token":'{{ csrf_token() }}'},
            dataFields: [
                { name: 'id', type: 'number' },
                { name: 'parent_id', type: 'string'},
                { name: 'value', type: 'string'},
                { name: 'value_kh', type: 'string'},

            ],
            id: 'id',
            url: '/application/tracking/setting',
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
            },
            updaterow: function (rowid, rowdata, commit) {
           
            }
        };

             
        $(document).ready(function () {
            var buttons = ['btn-printcard','btn-detail','btn-delete','btn-edit'];
                    initialButton(buttons,130,30);
                    var grid_height = $(window).height() - 220;


                $("#jqx-grid").jqxGrid({
                    width:'100%',
                    height:gridHeight,
                    source: source,
                    selectionmode: 'checkbox',
                    sortable: true,
                    pageable: true,
					virtualmode: true,
					pagerMode: 'advanced',
					enabletooltips: true,
					rowsheight:rowsheight,
                    pageSize: <?php echo $constant['pageSize'];?>,
                    pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
                    rendergridrows: function(obj) {
                        return obj.data;
                    },
                    columns: [
                        { text: '{{trans('document.value')}}', dataField: 'value', width: '18%' },
                        { text: '{{trans('document.value_kh')}}', dataField: 'value_kh', width: '15%' },
						{text: '{{trans('document.parent')}}', dataField: 'parent_id', width: '8%' ,align:'center',cellsalign: 'center'}
                    ]
            });
        });

     
    </script>
@endsection