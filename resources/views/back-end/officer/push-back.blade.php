<?php 
$jqxPrefix = '_officer';
$pushBackUrl = asset($constant['secretRoute'].'/officer/save-push-back');
?>

<div class="container-fluid">
	<form class="form-horizontal" action="{{$pushBackUrl}}" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
		<input type="hidden" value="{{isset($row->Id) ? $row->Id:0}}" name="Id" id="Id">
		
		<div style="margin-top:5px; height:400px;">
			  <label for="comment">{{trans('trans.description')}}</label>
			  <textarea id="comment" name="COMMENT"></textarea>
		</div>
		<div style="margin-top:30px;"></div>
		<div class="pull-right"><button id="jqx-save<?php echo $jqxPrefix;?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-comment"></span>ជូនដំណឹង</button></div>
	</form>
</div>

<script>
    $(document).ready(function(){
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,120,30);
		
		$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
			if($("#comment").val() == "<div>​</div>" || $("#comment").val() == "<br>"){
				$('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
					rules: [
						{input: '#comment', message: 'សូមបំពេញទិន្ន័យ', action: 'blur', rule: 'required'},
					]
				});
			} else {
				$(".jqx-validator-hint.jqx-rc-all").remove();
				$('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
					rules: [
						{input: '#comment', message: '', action: '', rule: ''},
					]
				});
			}
		});
		
		/* PUSH BACK */
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
			saveJqxItem('{{$jqxPrefix}}', '{{$pushBackUrl}}', '{{ csrf_token() }}');
        });
		
		$('#comment').jqxEditor({
                height: "100%",
            tools: 'bold italic underline size font color background | left center right',
                width: '100%'
        });
    });
</script>