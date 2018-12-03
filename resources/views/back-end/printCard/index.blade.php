<?php
$jqxPrefix = '_officer';
$listUrl = asset($constant['secretRoute'].'/printCard/index');
$detailUrl = asset($constant['secretRoute'].'/printCard/print-card');
?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
        <div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                        <div class="col-lg-12 col-xs-12">{{trans('officer.officer_hisotry')}} &raquo; {{trans('officer.print_officer_card')}}</div>
                    </div>
                    <div class="pull-right warp-btn-top">
						<button id="btn-detail"><i class="glyphicon glyphicon-print"></i> {{trans('officer.print_officer_card')}}</button>
						
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
			
		}
    };
  
    var avatar<?php echo $jqxPrefix;?> = function (row, datafield, value) {
        var asset;
        if(value == ''){
            asset = '<?php echo asset('/'); ?>images/photo-default.jpg';
        }else{
            asset = '<?php echo asset('/'); ?>' + value;
        }
        return '<div style="text-align: center; margin-top:3px;"><img width="45" height="45"  src="' + asset + '" /></div>';
    };

    $(document).ready(function () {
        //Button action
        var buttons = ['btn-detail'];
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
                    { text: '{{trans("trans.status")}}',dataField: 'is_register', width: '8%',filtertype: 'list', filteritems:<?php echo $listStatus;?>,createfilterwidget: function(column, columnElement, widget){widget.jqxDropDownList({ dropDownWidth: 140,dropDownHeight:100,searchMode: 'contains',filterable:true,filterPlaceHolder:'{{trans('trans.buttonSearch')}}' });}},
					{ text: '{{trans("officer.register_date")}}', dataField: 'register_date', width: '12%',filtertype: 'date',cellsformat: 'dd/MM/yyyy h:mm tt'},
                    { text: '{{trans("officer.phone_number")}}', dataField: 'phone_number_1', width: '15%'},
                    { text: '{{trans("officer.email")}}', dataField: 'email', width: '16%'},
                    { text: '{{trans("officer.generalDepartment")}}/អង្គភាព ', dataField: 'general_department_name', width: '25%', filtertype:'list',filteritems:<?php echo $general_department;?>,createfilterwidget: function(column, columnElement, widget){widget.jqxDropDownList({dropDownHeight:400,searchMode: 'contains',filterable:true,filterPlaceHolder:'{{trans('trans.buttonSearch')}}'});}}
                ]
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

    });
</script>
@endsection