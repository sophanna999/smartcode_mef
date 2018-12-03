<?php 
$jqxPrefix = '_pushBack';
$pushBackUrl = asset($constant['secretRoute'].'/push-back/save-push-back');
?>

<div class="container-fluid">
	<form class="form-horizontal" action="{{$pushBackUrl}}" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true" />
		<input type="hidden" value="{{isset($listNotification->ID) ? $listNotification->ID:0}}" name="Id" id="Id">
		<div class="form-group">
			<label><span class="red-star">*</span>{{trans('officer.officer_name')}}</label>
			<input type="hidden" name="officer" id="officer" value="{{isset($listNotification->TO_USER_ID) ? $listNotification->TO_USER_ID:0}}">
			<div id="div_officer"></div>
        </div>

		<div class="form-group">
			  <label for="comment">{{trans('trans.description')}}</label>
			  <textarea id="comment" name="COMMENT">
			  	<?php echo isset($listNotification->COMMENT) ? $listNotification->COMMENT:""; ?>
			  </textarea>
		</div>
		<div class="form-group">
			<div class="col-lg-12 text-right">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button" class="btn btn-default {{isset($listNotification->ID) ? "display-none" : ""}} " ><span class="glyphicon glyphicon-comment"></span>ជូនដំណឹង</button>
			</div>
		</div>

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
						{input: '#div_officer', message: 'សូមជ្រើសរើសមន្រ្តី', action: 'select',rule: function () {
                        	if($("#div_officer").val() == ""){
                            return false;
                        	}
                        	return true;
                    		}
                		}
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
                height: "350px",
                tools: 'bold italic underline size font color background | left center right',
                width: '100%'
        });
        initDropDownList(jqxTheme, 450,30, '#div_officer', <?php echo $listOfficer;?>, 'text', 'value', false, '', '0', "#officer","{{$constant['buttonSearch']}}",400);
    });
</script>