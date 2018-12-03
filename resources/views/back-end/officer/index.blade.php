<?php
$jqxPrefix = '_officer';
$listUrl = asset($constant['secretRoute'].'/officer/index');
$newUrl = asset($constant['secretRoute'].'/officer/new');
$editUrl = asset($constant['secretRoute'].'/officer/edit');
$deleteUrl = asset($constant['secretRoute'].'/officer/delete');
$resetPasswordUrl = asset($constant['secretRoute'].'/officer/reset-password');
$formChangeUrl = asset($constant['secretRoute'].'/officer/form-change');
$detailUrl = asset($constant['secretRoute'].'/officer/detail');
$pushBackUrl = asset($constant['secretRoute'].'/officer/push-back');
$exportUrl = asset($constant['secretRoute'].'/officer/export');
?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
        <div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                        <div class="col-lg-12 col-xs-12">{{trans('officer.officer_hisotry')}} &raquo; {{trans('officer.list_officer')}}</div>
                    </div>
                    <div class="pull-right warp-btn-top">
						<button id="btn-push-back"><i class="glyphicon glyphicon-comment"></i>ជូនដំណឹង</button>
						<button id="btn-approve"><i class="glyphicon glyphicon-ok-sign"></i> {{trans('officer.approve')}}</button>
						<button id="btn-detail"><i class="glyphicon glyphicon-eye-open"></i> {{trans('trans.detailInfo')}}</button>
						<button id="btn-delete"><i class="glyphicon glyphicon-trash"></i> {{trans('trans.buttonDelete')}}</button>
						<!-- <form action="<?php echo $exportUrl; ?>" class="form-horizontal" role="form" method="post" name="jqx-form_1<?php echo $jqxPrefix;?>" id="jqx-form_1<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" id="count_data_export" value="" />
							<input type="hidden" id="data_form_export" name="data_form_export" value="" />
							<button type="button" id="btn_export_report"><i class="glyphicon glyphicon-download-alt"></i> {{trans('officer.export')}}</button>
							<button type="submit" id="btn_export_report_hidden" class="display-none"><i class="glyphicon glyphicon-download-alt"></i> {{trans('officer.export')}}</button>
						</form>-->
                    </div>
                </div>
                <div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
            </div>
        </div>
    </div>
<style>
	.warp-btn-top > button { margin-right: 15px; }
	.warp-btn-top > form { display : inline-block; margin-right: 15px; }
</style>
<script type="text/javascript">
	/* Export Excel */
	$("#btn_export_report").click(function(){
		var count_data_export = $("#count_data_export").val();
		if(count_data_export > 0){
			$("#btn_export_report_hidden").click();
		}else{
			$('#jqx-notification').jqxNotification({position: positionNotify, template: "warning"}).html('{{trans('schedule.no_data')}}');
			$("#jqx-notification").jqxNotification("open");
		}
		return false;
	});
	/* End Export Excel */
    // prepare the data
    var source<?php echo $jqxPrefix;?> = {
        type: "post",
        dataType: "json",
        data:{"_token":'{{ csrf_token() }}'},
        dataFields: [
            { name: 'Id', type: 'number' },
            { name: 'full_name_kh', type: 'string' },
            { name: 'full_name_en', type: 'string' },
            { name: 'email', type: 'string' },
            { name: 'avatar', type: 'string' },
            { name: 'phone_number_1', type: 'string' },
			{ name: 'general_department_name', type: 'string' },
			{ name: 'department_name', type: 'string' },
            { name: 'is_register', type: 'number' },
			{ name: 'register_date', type: 'date' }

        ],
        id: 'Id',
        url: '<?php echo $listUrl;?>',
        beforeprocessing: function(data) {
            console.log(data)
			count_data_export 	= data.total;
			data_form_export 	= JSON.stringify(data.dataForm);
			$("#count_data_export").val(count_data_export);
			$("#data_form_export").val(data_form_export);
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
					$("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:5000});
					if(response.code == 1) {
						//Items delete success
						closeJqxWindowId('jqxwindow<?php echo $jqxPrefix;?>');
						$('#jqx-notification').jqxNotification({ position: positionNotify,template: "success"}).html(response.message);
						$("#jqx-notification").jqxNotification("open");
					}else{
						$('#jqx-notification').jqxNotification({ position: positionNotify,template: "success",autoClose: false }).html(response.message);
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

    var avatar<?php echo $jqxPrefix;?> = function (row, datafield, value) {
        var asset;
        if(value == ''){
            asset = '<?php echo asset('/'); ?>images/image-profile.jpg';
        }else{
            asset = '<?php echo asset('/'); ?>' + value;
        }
        return '<div style="text-align: center; margin-top:3px;"><img width="45" height="45"  src="' + asset + '" /></div>';
    };

    $(document).ready(function () {
        //Button action
        var buttons = ['btn-detail','btn-approve','btn-delete','btn-push-back'];
        initialButton(buttons,110,30);

        var dataAdapter = new $.jqx.dataAdapter(source<?php echo $jqxPrefix;?>);

        // create Tree Grid
        $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid({
                theme:jqxTheme,
                width:'100%',
                height:gridHeight,
                rowsheight:50,
                source: dataAdapter,
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
                    { text: '{{trans("officer.avatar")}}', filterable:false,enabletooltips:false,dataField: 'avatar', width: '4%',align:'center',cellsrenderer: avatar<?php echo $jqxPrefix;?>},
                    { text: '{{trans("officer.full_name")}}', dataField: 'full_name_kh', width: '10%'},
                    { text: '{{trans("officer.english_name")}}', dataField: 'full_name_en', width: '10%'},
					{ text: '{{trans("trans.status")}}',dataField: 'is_register', width: '8%',filtertype: 'list', filteritems:<?php echo $listStatus;?>,createfilterwidget: function(column, columnElement, widget){widget.jqxDropDownList({ dropDownWidth: 150 });}},
					{ text: '{{trans("officer.register_date")}}', dataField: 'register_date', width: '12%',filtertype: 'date',cellsformat: 'dd/MM/yyyy h:mm tt'},
                    { text: '{{trans("officer.phone_number")}}', dataField: 'phone_number_1', width: '15%'},
                    { text: '{{trans("officer.email")}}', dataField: 'email', width: '15%'},
					{ text: '{{trans("officer.generalDepartment")}}/អង្គភាព ', dataField: 'general_department_name', width: '13%'},
					{ text: '{{trans("officer.department")}}', dataField: 'department_name', width: '13%'}
                ]
        });

        //Approve
        $("#btn-approve").on('click',function(){
            var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
            var rowData = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
            console.log(rowData);
            if(rowData == undefined){
                $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                $('#jqx-notification').jqxNotification({
                    position: positionNotify,
                    template: "warning"
                }).html('{{trans("trans.eidt_row_msg")}}');
                $("#jqx-notification").jqxNotification("open");
                return false;
            }

            //Registerd
            if(rowData['is_register'] == '<?php echo $registered[0];?>'){
                var full_name_kh = rowData.full_name_kh;
                $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                $('#jqx-notification').jqxNotification({position: positionNotify, template: "warning"}).html(full_name_kh + ' {{trans("officer.approve_msg")}}');
                $("#jqx-notification").jqxNotification("open");
                return false;
            }

            //Already Approved
            if(rowData['is_register'] == '<?php echo $registered[2];?>'){
                var full_name_kh = rowData.full_name_kh;
                $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                $('#jqx-notification').jqxNotification({position: positionNotify, template: "warning"}).html(full_name_kh + ' {{trans("officer.already_approve_msg")}}');
                $("#jqx-notification").jqxNotification("open");
                return false;
            }

            if(rowData['is_register'] == '<?php echo $registered[1];?>' || rowData['is_register'] == '<?php echo $registered[3];?>'){
                newJqxItem('<?php echo $jqxPrefix;?>', '{{trans("officer.approve")}}',800,650, '{{$newUrl}}', rowData.Id, '{{ csrf_token() }}');
            }

        });

		//Push Back
		$("#btn-push-back").on('click',function(){
		var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
		var rowData = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
		if(rowData == undefined){
			$("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
			$('#jqx-notification').jqxNotification({
				position: positionNotify,
				template: "warning"
			}).html('{{trans("trans.eidt_row_msg")}}');
			$("#jqx-notification").jqxNotification("open");
			return false;
		}
			newJqxItem('<?php echo $jqxPrefix;?>', 'PUSH BACK',700,510, '{{$pushBackUrl}}', rowData.Id, '{{ csrf_token() }}');
        });

        //Detail
        $("#btn-detail").on('click',function(){
            var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
            var rowData = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
            if(rowData == undefined){
                $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
                $('#jqx-notification').jqxNotification({
                    position: positionNotify,
                    template: "warning"
                }).html('{{trans("trans.eidt_row_msg")}}');
                $("#jqx-notification").jqxNotification("open");
                return false;
            }
            var url ='{{$detailUrl}}/' + rowData.Id;
            window.open(url, '_blank');
        });

        $("#btn-delete").on('click',function(){
            var row = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getselectedrowindexes');
			var rowData = $("#jqx-grid<?php echo $jqxPrefix;?>").jqxGrid('getrowdata', row);
			if(row.length == 0){
				$("#jqx-notification").jqxNotification();
				$('#jqx-notification').jqxNotification({ position: positionNotify,template: "warning" }).html('{{trans("trans.deleteRow")}}');
				$("#jqx-notification").jqxNotification("open");
				$("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:8000});
				return false;
			}
			var title = '{{$constant['buttonDelete']}}';
			var content = '{{trans('trans.confirm_delete')}}';
			confirmDelete(title,content,function () {
				$('#jqx-grid<?php echo $jqxPrefix;?>').jqxGrid('deleteRow', rowData.Id);
			});
        });

    });
</script>
@endsection