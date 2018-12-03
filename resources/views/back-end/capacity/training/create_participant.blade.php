<div class="container-fluid">
    <br/>
    <form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-formassign_participant">
        {{ csrf_field() }}
        <div class="col-sm-12">
            <div class="form-group">
                <label class="control-label">{{ trans('training.'.$type) }}</label>
                <div id="participants" name="participants"></div>
                <div class="clearfix"></div>
                <div class="message"></div>
            </div>
            <div class="margin-top-md">
                <label for="send_notification" class="control-label"><input type="checkbox" name="send_notification" id="send_notification" checked value="1">{{ trans('general.send_notification') }}</label>
                <button type="button"​​ id="jqx-save" class="pull-right"><span class="glyphicon glyphicon-check"></span> {{ trans('general.save') }}</button>
            </div>
        </div>
    </form>
</div>

<script>
    
    initDropDownMulti('participants',{!! $participants !!},{!! $training->member()->get()->filter(function($q) use ($type){
        return $q->pivot->type == $type;
    })->pluck('id')->toJson() !!});

    $(document).ready(function(){
 
		$("#jqx-save").click(function(){
            saveJqxItem('assign_participant', '{{ secret_route() }}/training/assign-store/{{ $training->id }}?type={{ $type }}', '{{ csrf_token() }}',1,function(){
                loadTab();
                $('#jqxwindowassign_participant').jqxWindow('destroy');
            });
        });
        
		var buttons = ['jqx-save'];
		initialButton(buttons,90,30);

	});
</script>