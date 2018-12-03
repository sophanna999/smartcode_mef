<?php
$jqxPrefix = '_resource';
$saveUrl = asset($constant['secretRoute'].'/front-end-resource/save-privilege');
$getPosition = asset($constant['secretRoute'].'/front-end-resource/position');
$privilegeToModule = asset($constant['secretRoute'].'/front-end-resource/privilege-by-id');
?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="Id" name="mef_authenticate_id" value="{{$row->id}}">
        
        <div class="form-group">
            <div class="col-sm-12">
				<span style="font-family: 'KHMERMEF1'">{{trans('users.userAuthorize')}}</span> <span style="font-family: cursive">&raquo;</span> <span style="font-family: 'KHMERMEF1'">{{$row->name}}</span>
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-12">
                <span class="red-star">*</span>{{trans('trans.position')}}
            </div>
        </div>
		<div class="form-group">
			<div class="col-sm-12">
			<div id='position_id' name='mef_position_id'></div>

		</div>
		</div>
        <div class="form-group">
            <div class="col-sm-12 text-right">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
		
		
		/* Save action */
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
		
		/* Select Combobox */
		var source = {
			type: 'post',
			datatype: 'json',
			url: '<?php echo $getPosition; ?>',
			data: {
				_token : '{{ csrf_token() }}'
			}
        };

        var dataAdapter = new $.jqx.dataAdapter(source,{
			beforeLoadComplete: function (records) {
				var positionValue = '';
				$.ajax({
					url: "<?php echo $privilegeToModule;?>",
					data: {
						_token : '{{ csrf_token() }}',
						Id: $('#Id').val()
					},
					type: 'post',
					success: function(result) {
					   if(JSON.parse(result) != ""){
						  positionValue = JSON.parse(result).mef_position_id;
					   }
					   getSelectedItems(positionValue);
					}
				});
			}
		});
		
		function getSelectedItems(positionValue){
			var str = positionValue;
			if(str != ''){
				var res = str.split(',');
				setTimeout(function(){
					$.each(res, function( index, value ) {
						$("#position_id").jqxComboBox('selectItem', value);
					});
				}, 100);
			}
		}

		$("#position_id").jqxComboBox({
			source: dataAdapter, 
			multiSelect: true,
			theme: jqxTheme,
			width: 558, 
			height: 32,
			displayMember: "displayMember",
			valueMember : "valueMember",
			placeHolder: " ជ្រើសរើសមុខតំណែង",
			enableBrowserBoundsDetection:true,
			autoComplete:true,
			searchMode:'contains',
			dropDownHeight:450,
			animationType: 'none'
		});

		/* jqxComboBox on focus action */
		$('#position_id input').on('focus', function (event) {
			$("#position_id").jqxComboBox('open');
		});
		
    });
</script>