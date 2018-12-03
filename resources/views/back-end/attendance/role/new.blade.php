<?php 
$jqxPrefix = '_mef_takeleave_user';
$saveUrl = asset($constant['secretRoute'].'/takeleave-role/save');
$userUrl = asset($constant['secretRoute'].'/takeleave-role/offcer-take-role');
?>

<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:10px;"></div>
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
        
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{$constant['officer-name']}}</label>
				<div id='officer_id' name='officer_id'></div>
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
				<label><span class="red-star">*</span> មន្រ្តីដែលអាចឲ្យអ្នកស្នើរសុំច្បាប់ជំនួសបាន</label>
				<div id='to_officer_id' name='to_officer_id'></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
</div>
<style type="text/css">
    .jqx-combobox-content-disabled{
        color: #000 !important;;
    }
</style>
<script>
	
    $(document).ready(function(){
		var def_off = '<?php echo isset($row->officer_Id)? $row->officer_Id: '';?>';
		var def_viewer = '<?php echo isset($row->to_officer_id)? $row->to_officer_id: '';?>';
		var _token= '{{ csrf_token() }}';
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
        
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
		var width_form = 600;
		var data =  <?php echo $attendanceViewer; ?>;
		console.log(data);
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'text' },
				{ name: 'value' }
			],
			localdata: data
		};
		
		var dataAdapter = new $.jqx.dataAdapter(source);
		var thems= { 
			source: dataAdapter,
			searchMode: 'contains', 
			displayMember: "text", 
			valueMember: "value", 
			width: width_form-50, 
			height: '35px',
			multiSelect: false,
		}
		$("#officer_id").jqxComboBox(thems);
		
		
		$('#officer_id').on('select', function (event) 
		{
			var args = event.args;
			if (args) {
			// index represents the item's index.                       
			var index = args.index;
			var item = args.item;
			// get item's label and value.
			var label = item.label;
			var value = item.value;
			var type = args.type; // keyboard, mouse or null depending on how the item was selected.
			console.log(value);
			if(def_off ==''){
				
				fun_viewer(value,function(response){
					var obj = JSON.parse(response);
					console.log(obj);
					var officer_viewer = def_viewer.split(",");
					officer_viewer.forEach(function(element) {
						$.each(obj,function(key,values){
							if(element == values.value){
								// console.log(values.value);
								$("#to_officer_id").jqxComboBox('selectItem', element);
							}						
						});
					});
				});
			}
		}
		}); 
		
		var fun_viewer = function(mef_id,callback){
			
			$.ajax({
                type: 'post',
                url: '{{$userUrl}}',
                data:{"_token":_token,"mef_id":mef_id},
                success: function (response) {
					var dataAdapter = new $.jqx.dataAdapter(JSON.parse(response));
					$("#to_officer_id").jqxComboBox(
						{ 
							selectedIndex: 0
							,multiSelect: true
							, source: dataAdapter
							, displayMember: "text"
							, valueMember: "value"
							, width: 550
							, height: 35
							
						});
					if(callback){
						callback(response);
					}
                },
                error: function (request, status, error) {
                    console.log(request.responseText);
                }
            });
		};
		
		if(def_off !=''){
			$("#officer_id").jqxComboBox('selectItem', def_off ); 
			$("#officer_id").jqxComboBox({ disabled: true }); 
			
			fun_viewer(def_off,function(response){
				var obj = JSON.parse(response);
				console.log(obj);
				var officer_viewer = def_viewer.split(",");
				officer_viewer.forEach(function(element) {
					$.each(obj,function(key,values){
						if(element == values.value){
							// console.log(values.value);
							$("#to_officer_id").jqxComboBox('selectItem', element);
						}						
					});
				});
			});

		}else{
			fun_viewer('');
		}
    });
</script>