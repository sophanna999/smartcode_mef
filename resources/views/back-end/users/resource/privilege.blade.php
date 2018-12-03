<?php
$jqxPrefix = '_resource';
$saveUrl = asset($constant['secretRoute'].'/resource/save-previlege');
?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="Id" name="Id" value="{{$row->id}}">
        <input type="hidden" name="ajaxRequestJson" value="true" />
        
        <div class="form-group">
            <div class="col-sm-4">
				{{$row->name}}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-8 col-sm-4">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
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
		
		
    });
</script>