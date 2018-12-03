
<div class="container-fluid">
    <br/>
    <form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-form">
        {{ csrf_field() }}

        <div class="form-group">
            <label class="control-label col-sm-3" for="code">{{ trans('subject.code') }}:</label>
            <div class="col-sm-7">
                <input type="text" name="code" class="form-control" id="code" placeholder="{{ trans('general.enter',['attribute' => trans('subject.code') ]) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="name"><span class="red-star">*</span>{{ trans('subject.name') }}:</label>
            <div class="col-sm-7">
                <input type="text" name="name" class="form-control" id="name" placeholder="{{ trans('general.enter',['attribute' => trans('subject.name') ]) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="description">{{ trans('subject.description') }}:</label>
            <div class="col-sm-7">
                <textarea name="description" class="form-control" id="description" placeholder="{{ trans('general.enter',['attribute' => trans('subject.description') ]) }}" cols="30" rows="5"></textarea>
            </div>
        </div>

        @if(isAdmin())
            {{-- <div class="form-group">
                <label class="control-label col-sm-3" for="description">{{ trans('general.public') }} <span><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ trans('general.public_help') }}"></i></span> :</label>
                <div class="col-sm-7">
                    <input name="public" class="margin-top-lg" value="1" type="checkbox"/>
                </div>
            </div> --}}
        @endif
        
        <div class="form-group">
            <div class="col-sm-10">
                <button id="jqx-save" type="button"​​ class="pull-right"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        initDropDown('department',{!! $departments !!},{{ !isAdmin() ? session('sessionUser')->mef_department_id : null }});

        @if(!isAdmin())
            $("#department").jqxDropDownList({ disabled: true }); 
        @endif

		$("#jqx-save").click(function(){
            saveJqxItem('', '{{ secret_route() }}/subject', '{{ csrf_token() }}');
        });
        
		var buttons = ['jqx-save'];
		initialButton(buttons,90,30);

	});
</script>