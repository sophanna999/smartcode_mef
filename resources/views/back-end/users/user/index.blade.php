<?php
$jqxPrefix = '_user';
$newUrl = asset($constant['secretRoute'].'/user/new');
$editUrl = asset($constant['secretRoute'].'/user/edit');
$listUrl = asset($constant['secretRoute'].'/user/index');
$deleteUrl = asset($constant['secretRoute'].'/user/delete');
$approveUrl = asset($constant['secretRoute'].'/user/approve');
$resetPasswordUrl = asset($constant['secretRoute'].'/user/reset-password');
$currentUserId = session('sessionUser') !=null ? session('sessionUser')->id:'';
$detailUrl = asset($constant['secretRoute'].'/officer/detail');
?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
		<div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                        <div class="col-lg-12 col-xs-12">{{trans('users.userAuthorize')}} &raquo; {{trans('users.user')}}</div>
                    </div>
                    <div class="pull-right">
                        <div class="col-lg-12 col-xs-12">
                            <button id="btn-new"><i class="glyphicon glyphicon-plus"></i> {{trans('trans.buttonNew')}}</button>
                            <button id="btn-edit"><i class="glyphicon glyphicon-edit"></i> {{trans('trans.buttonEdit')}}</button>
                            <button id="btn-delete"><i class="glyphicon glyphicon-trash"></i> {{trans('trans.buttonDelete')}}</button>
                            <button id="btn-detail"><i class="glyphicon glyphicon-eye-open"></i> {{trans('trans.detailInfo')}}</button>
                            <button id="btn-reset-password"><i class="glyphicon glyphicon-pencil"></i> {{trans('users.changePassword')}} </button>
                        </div>
                    </div>
                </div>
                <div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
            </div>
        </div>
	</div>

<script type="text/javascript">
    var window_width = 1500;
    var window_height = 450;
    // prepare the data
    var source<?php echo $jqxPrefix;?> = {
        type: "post",
        dataType: "json",
        data:{"_token":'{{ csrf_token() }}'},
        dataFields: [
            { name: 'role', type: 'string' },
            { name: 'moef_role_id', type: 'number' },
            { name: 'mef_full_name', type: 'string' },
            { name: 'id', type: 'number' },
            { name: 'mef_user_name', type: 'string' },
            { name: 'mef_position_name', type: 'string' },
            { name: 'ministry_name', type: 'string' },
            { name: 'secretariat_name', type: 'string' },
            { name: 'department_name', type: 'string' },
            { name: 'office_name', type: 'string' },
            { name: 'avatar', type: 'string' },
            { name: 'email', type: 'string' },
            { name: 'active', type: 'number' }
        ],
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
                data: {"Id":rowid,"_token":'{{ csrf_token() }}','ajaxRequestJson':'true'},
                success: function (response, status, xhr) {
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    if(response.code == 0) {
                        //Some items delete except the one in used
                        $('#jqx-notification').jqxNotification({position: positionNotify,template: "warning",autoClose: false}).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }else if(response.code == 1) {
                        //Item in used
                        $('#jqx-notification').jqxNotification({
                            position: positionNotify,
                            template: "warning"
                        }).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }else if(response.code == 3){
                        $('#jqx-notification').jqxNotification({position: positionNotify,template: "warning",autoClose: false}).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }else{
                        //Items delete success
                        closeJqxWindowId('jqxwindow<?php echo $jqxPrefix;?>');
                        $('#jqx-notification').jqxNotification({ position: positionNotify, template: "success" }).html(response.message);
                        $("#jqx-notification").jqxNotification("open");
                    }

                    $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('updatebounddata');
                    $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('clearselection');
                },
                error: function (request, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    };
    var numberRenderer<?php echo $jqxPrefix;?> = function (row, column, value) {
        return '<div style="text-align: center; margin-top: 25px;">' + (1 + value) + '</div>';
    };
    var active<?php echo $jqxPrefix;?> = function (row, datafield, value) {
        return value == 0 ? '<div style="text-align: center; margin-top: 10px;"><i class="glyphicon glyphicon-remove"></i></div>':'<div style="text-align: center; margin-top:10px;"><i class="glyphicon glyphicon-ok"></i></div>';
    };
	var avatar<?php echo $jqxPrefix;?> = function (row, datafield, value) {
        var asset;
		if(value == ''){
			asset = '<?php echo asset('/'); ?>images/image-profile.jpg';
        }else{
			asset = '<?php echo asset('/'); ?>/' + value;
		}
        return '<div style="text-align: center; margin-top:1px;"><img width="50" height="48"  src="' + asset + '" class="img-circle" /></div>';
    };
    $(document).ready(function () {
		//Button action
		var buttons = ['btn-new','btn-edit','btn-delete','btn-reset-password','btn-detail'];
        initialButton(buttons,110,35);

        var dataAdapter = new $.jqx.dataAdapter(source<?php echo $jqxPrefix;?>);
        // create Tree Grid
        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid({
                theme:jqxTheme,
                width:'100%',
                height:gridHeight,
				rowsheight:50,
                source: dataAdapter,
                selectionmode: 'checkbox',
                sortable: true,
                pageable: true,
                pagerMode: 'advanced',
                showfilterrow: true,
                filterable: true,
				enabletooltips: true,
                pageSize: <?php echo $constant['pageSize'];?>,
                pageSizeOptions: <?php echo $constant['pageSizeOptions'];?>,
                virtualmode: true,
                rendergridrows: function(obj) {
                    return obj.data;
                },
                columns: [
                    { text: '{{trans('users.icon')}}', filterable:false,dataField: 'avatar', width: '5%',align:'center',cellsrenderer: avatar<?php echo $jqxPrefix;?>,enabletooltips:false},
					{ text: '{{trans('users.userRole')}}', dataField: 'role', width: '35%',filtertype:'list',filteritems:<?php echo $listRole;?>},
                    { text: '{{trans('officer.officer_name')}}', dataField: 'mef_full_name', width: '15%' },
                    { text: '{{trans('mef_user_id')}}', dataField: 'id', width: '7%', hidden:true },
                    { text: '{{trans('users.userName')}}', dataField: 'mef_user_name', width: '10%' },
                    { text: '{{trans('officer.position')}}', dataField: 'mef_position_name', width: '10%' },
                    { text: '{{trans('officer.centralMinistry')}}', dataField: 'ministry_name', width: '12%' },
                    { text: '{{trans('officer.generalDepartment')}}', dataField: 'secretariat_name', width: '18%' },
                    { text: '{{trans('officer.department')}}', dataField: 'department_name', width: '18%' },
                    { text: '{{trans('officer.office')}}', dataField: 'office_name', width: '25%' },
                    { text: '{{trans('officer.email')}}', dataField: 'email', width: '15%' },
                    { text: '{{trans('trans.active')}}', filtertype: 'list', filteritems: ['{{trans('trans.active')}}','{{trans('trans.closeStatus')}}'], dataField: 'active', width: '5%',cellsrenderer: active<?php echo $jqxPrefix;?>, align:'center'}
                ],
                showgroupsheader: false,
                groupable:true,
                groupsexpandedbydefault: true,
                groups: ['role']
        });

		/* New */
        $("#btn-new").on('click',function(){
            newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonNew']}}',window_width,window_height, '<?php echo $newUrl;?>', 0, '{{ csrf_token() }}');
        });

		/* Edit */
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
                newJqxItem('<?php echo $jqxPrefix;?>', '{{$constant['buttonEdit']}}', window_width,window_height - 50, '<?php echo $editUrl;?>', jqxdatarow.id, '{{ csrf_token() }}');
            }

        });
		
		/* Delete */
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
		
		/* Reset password */
		$("#btn-reset-password").click(function(){
            var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
			var jqxdatarow = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
			if(jqxdatarow == undefined){
                if(row.length == 0){
                    $("#jqx-notification").jqxNotification();
                    $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('សូមជ្រើសរើសទិន្នន័យដើម្បីប្តូរពាក្យសម្ងាត់');
                    $("#jqx-notification").jqxNotification("open");
                    $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                    return false;
                }
				return false;
			}
			if(jqxdatarow.id == '{{$currentUserId}}'){
				return false;
			}

			if(row.length == 0){
                $("#jqx-notification").jqxNotification();
                $('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{$constant['deleteRow']}}');
                $("#jqx-notification").jqxNotification("open");
				$("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                return false;
            }

            newJqxItem('<?php echo $jqxPrefix;?>', '{{trans('users.resetNewPassword')}}', 450,170, '<?php echo $resetPasswordUrl;?>', jqxdatarow.id, '{{ csrf_token() }}');
        });


        //Detail
        $("#btn-detail").on('click',function(){
            var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
            var rowData = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
            if(rowData.id == 3){
                return false;
            }
            if(rowData == undefined){
                $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                $('#jqx-notification').jqxNotification({
                    position: positionNotify,
                    template: "warning"
                }).html('សូមជ្រើសរើសជួរដេកណាមួយ');
                $("#jqx-notification").jqxNotification("open");
                return false;
            }
            var url ='{{$detailUrl}}/' + rowData.mef_officer_id;
            window.open(url, '_blank');
        });

    });
</script>
@endsection