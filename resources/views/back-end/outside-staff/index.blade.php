@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
        <div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                    <div class="col-lg-12">{{trans('public_holiday.holiday')}} &raquo;{{trans('public_holiday.insert-holiday')}}</div>            
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
                    { name: 'full_name', type: 'string' },
                    { name: 'latin_name', type: 'string' },
                    { name: 'phone_number', type: 'string' },
                    { name: 'avatar', type: 'string' },
                    { name: 'email', type: 'string' },
                ],
                cache: false,
                id: 'id',
                url: '{{ secret_route() }}/outside-staff/lists',
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
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: "{{ secret_route() }}/outside-staff/delete",
                        cache: false,
                        data: {"Id":rowid,"_token":'{{ csrf_token() }}'},
                        success: function (response, status, xhr) {
                            $("#jqx-grid").jqxGrid('updatebounddata');
                            $("#jqx-grid").jqxGrid('clearselection');
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
                                // closeJqxWindowId('jqxwindow');
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
        var numberRenderer = function (row, column, value) {
            return '<div style="text-align: center; margin-top:10px;">' + (1 + value) + '</div>';
        };

        var avatarImage = function (row, datafield, value) {
            console.log('avatar', value);
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
                    { text: '{{ trans('outside_staff.avatar')}}', dataField: 'avatar', width: '5%', filterable:false, align:'center', cellsrenderer: avatarImage},
                    { text: '{{ trans('profile.full_name') }}', dataField: 'full_name'},
                    { text: '{{ trans('profile.latin_name') }}', dataField: 'latin_name'},
                    { text: '{{ trans('profile.phone_number') }}', dataField: 'phone_number'},
                    { text: '{{ trans('profile.email') }}', dataField: 'email'}
                ]
            });
            $("#btn-new").on('click',function(){
                newJqxItem('', '{{$constant['buttonNew']}}',width_form,height_form, '{{ secret_route() }}/outside-staff/create', 0, '{{ csrf_token() }}');
            });
            $("#btn-edit").on('click',function(){
                var row = $("#jqx-grid").jqxGrid('getselectedrowindexes');
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
                    var jqxdatarow = $("#jqx-grid").jqxGrid('getrowdata', row);
                    console.log(jqxdatarow);

                    newJqxItem('', '{{$constant['buttonEdit']}}', width_form, height_form, '{{ secret_route() }}/outside-staff/edit', jqxdatarow.id, '{{ csrf_token() }}');
                }

            });
            $("#btn-delete").click(function(){
                var row = $("#jqx-grid").jqxGrid('getselectedrowindexes');
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
                        var jqxdatarow = $("#jqx-grid").jqxGrid('getrowdata', row[index]);
                        listId.push(jqxdatarow.id);
                    }
                    $('#jqx-grid').jqxGrid('deleteRow', listId);
                });
            });

        });
    </script>
@endsection