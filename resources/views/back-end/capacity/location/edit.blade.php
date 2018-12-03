
<div class="container-fluid">
		<br/>
		<form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-form">

			{{ csrf_field() }}
			{{ method_field('PATCH') }}
	
			<div class="form-group">
				<label class="control-label col-sm-3" for="code">{{ trans('location.code') }}:</label>
				<div class="col-sm-7">
					<input type="text" name="code" value="{{ $location->code }}" class="form-control" id="code" placeholder="{{ trans('general.enter',['attribute' => trans('location.code') ]) }}">
				</div>
			</div>
	
			<div class="form-group">
				<label class="control-label col-sm-3" for="name"><span class="red-star">*</span>{{ trans('location.name') }}:</label>
				<div class="col-sm-7">
					<input type="text" name="name" value="{{ $location->name }}" class="form-control" id="name" placeholder="{{ trans('general.enter',['attribute' => trans('location.name') ]) }}">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-3" for="location">{{ trans('department.department') }}:</label>
				<div class="col-sm-7">
					<div id="department" name="department"></div>
					<div class="clearfix"></div>
					<div class="message"></div>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-3" for="description">{{ trans('location.description') }}:</label>
				<div class="col-sm-7">
					<textarea name="description" class="form-control" id="description" placeholder="{{ trans('general.enter',['attribute' => trans('location.description') ]) }}" cols="30" rows="5">{{ $location->description }}</textarea>
				</div>
			</div>

			@if(isAdmin())
				{{-- <div class="form-group">
					<label class="control-label col-sm-3" for="description">{{ trans('general.public') }} <span><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ trans('general.public_help') }}"></i></span>:</label>
					<div class="col-sm-7">
						<input name="public" {{ $location->public ? 'checked' : '' }} class="margin-top-lg" value="1" type="checkbox"/>
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
			initDropDown('department',{!! $departments !!},{{ $location->department_id }});
            $("#department").jqxDropDownList({ disabled: true });
			$("#jqx-save").click(function(){
				saveJqxItem('', '{{ secret_route() }}/location/' + {{ $location->id }}, '{{ csrf_token() }}');
			});
			
			var buttons = ['jqx-save'];
			initialButton(buttons,90,30);
	
		});
	</script>