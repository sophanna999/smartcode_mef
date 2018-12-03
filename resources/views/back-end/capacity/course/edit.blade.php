
<div class="container-fluid">
    <br/>
    <form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-form">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        {{-- <h4>{{ trans('general.basic') }}</h4>
        <hr> --}}
        <div class="form-group">
            <label class="control-label col-sm-3" for="code">{{ trans('course.code') }}:</label>
            <div class="col-sm-5">
				<input type="text" name="code" value="{{ $course->code }}" class="form-control" id="code" placeholder="{{ trans('general.enter',['attribute' => trans('course.code') ]) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="title"><span class="red-star">*</span>{{ trans('course.title') }}:</label>
            <div class="col-sm-7">
                <input type="text" name="title" value="{{ $course->title }}" class="form-control" id="title" placeholder="{{ trans('general.enter',['attribute' => trans('course.title') ]) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="subject_id"><span class="red-star">*</span>{{ trans('subject.subject') }}: </label>
            <div class="col-sm-7">
                <div id="subjects" name="subjects"></div>
                <div class="clearfix"></div>
                <div class="message"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="member_id"><span class="red-star">*</span>{{ trans('training.trainer') }}:</label>
            <div class="col-sm-7">
                <div id="members" name="members"></div>
                <div class="clearfix"></div>
                <div class="message"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="description">{{ trans('course.description') }}:</label>
            <div class="col-sm-7">
                <textarea name="description" class="form-control" id="description" placeholder="{{ trans('general.enter',['attribute' => trans('course.description') ]) }}" cols="30" rows="10">{!! $course->description !!}</textarea>
            </div>
		</div>
		
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-7">
				<label for="status" class="control-label">
					<input type="checkbox" value="0" name="status" id="status" {{ ( !$course->status ? 'checked' : '' ) }}>{{ trans('general.inactive') }}
				</label>
                <button id="jqx-save" type="button"​​ class="pull-right"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        initDropDownMulti('subjects',{!! $subjects !!},{!! $subjects_selected !!})
        initDropDownMulti('members',{!! $members !!},{!! $members_selected !!})

		$("#jqx-save").click(function(){
			saveJqxItem('', '{{ secret_route() }}/course/' + {{ $course->id }}, '{{ csrf_token() }}');
		});
		
		var buttons = ['jqx-save'];
		initialButton(buttons,90,30);

	});
</script>