
<div class="container-fluid">
    <br/>
    <form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-form">
        {{ csrf_field() }}
		{{ method_field('PATCH') }}
        <div class="form-group margin-bottom-xl">
            <label class="" data-toggle="tooltip" data-placement="top" title="{{ trans('profile.disabled_check_type') }}">
                <input type="hidden" name="type" value="{{ $member->type}}" >
                <input type="checkbox" id="member_type" {{ ($member->type ? 'checked' : '' ) }} disabled >{{ trans('profile.outsite_member') }}
            </label>
            <div class="message"></div>
        </div>

        <div id="internal" class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="officer">{{ trans('profile.officer') }}:</label>
                    <div class="col-sm-8">
                        <div id="officer" name="officer"></div>
                        <div class="clearfix"></div>
                        <div class="message"></div>
                    </div>
                </div>
            </div>
        </div>
{{-- 
        <h5>{{ trans('profile.general_info') }}</h5>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="code"><span class="red-star">*</span>{{ trans('profile.code') }}:</label>
                    <div class="col-sm-8">
                        <input value="{{ $member->code }}" type="text" name="code" class="form-control" id="code" placeholder="{{ trans('general.enter',['attribute' => trans('profile.code') ]) }}">
                    </div>
                </div>
            </div>
        </div> --}}

        <div id="outside">
            <h5>{{ trans('profile.basic_info') }}</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="full_name"><span class="red-star">*</span>{{ trans('profile.full_name') }}:</label>
                        <div class="col-sm-8">
                            <input type="text" value="{{ $member->Profile->full_name }}" name="full_name" class="form-control" id="full_name" placeholder="{{ trans('general.enter',['attribute' => trans('profile.full_name') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="latin_name"><span class="red-star">*</span>{{ trans('profile.latin_name') }}:</label>
                        <div class="col-sm-8">
                            <input type="text" value="{{ $member->Profile->latin_name }}" name="latin_name" class="form-control" id="latin_name" placeholder="{{ trans('general.enter',['attribute' => trans('profile.latin_name') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="gender">{{ trans('profile.gender') }}:</label>
                        <div class="col-sm-8">
                            <div class="radio pull-left margin-right-md">
                                <label><input {{ ($member->Profile->gender == 'm' ? 'checked' : '') }} type="radio" name="gender" value="m">{{ trans('profile.male') }}</label>
                            </div>
                            <div class="radio pull-left">
                                <label><input {{ ($member->Profile->gender == 'f' ? 'checked' : '') }} type="radio" name="gender" value="f">{{ trans('profile.female') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="date_of_birth">{{ trans('profile.date_of_birth') }}:</label>
                        <div class="col-sm-8">
							<input type="hidden" value="{{ $member->Profile->date_of_birth }}" name="date_of_birth" class="form-control" id="date_of_birth" placeholder="{{ trans('general.enter',['attribute' => trans('profile.date_of_birth') ]) }}">
                            <div id="datepicker"></div>
                            <div class="clearfix"></div>
                            <div class="message"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="address">{{ trans('profile.address') }}:</label>
                        <div class="col-sm-8">
						<textarea name="address" class="form-control" id="address" placeholder="{{ trans('general.enter',['attribute' => trans('profile.address') ]) }}">{{ $member->Profile->address }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <h5>{{ trans('profile.job_info') }}</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="position">{{ trans('profile.position') }}:</label>
                        <div class="col-sm-8">
                            <input type="text" value="{{ $member->Profile->position }}" name="position" class="form-control" id="position" placeholder="{{ trans('general.enter',['attribute' => trans('profile.position') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="company">{{ trans('profile.company') }}:</label>
                        <div class="col-sm-8">
                            <input type="text" value="{{ $member->Profile->company }}" name="company" class="form-control" id="company" placeholder="{{ trans('general.enter',['attribute' => trans('profile.company') ]) }}">
                        </div>
                    </div>
                </div>
            </div>
            <h5>{{ trans('profile.contact_info') }}</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="phone_number"><span class="red-star">*</span>{{ trans('profile.phone_number') }}:</label>
                        <div class="col-sm-8">
                            <input type="text" value="{{ $member->phone_number }}" name="phone_number" class="form-control" id="phone_number" placeholder="{{ trans('general.enter',['attribute' => trans('profile.phone_number') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="email"><span class="red-star">*</span> {{ trans('profile.email') }}:</label>
                        <div class="col-sm-8">
                            <input type="text" value="{{ $member->email }}" name="email" class="form-control" id="email" placeholder="{{ trans('general.enter',['attribute' => trans('profile.email') ]) }}">
                        </div>
                    </div>
                </div>
            </div>
            <h5>{{ trans('profile.login_info') }}</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="username"><span class="red-star">*</span>{{ trans('profile.username') }}:</label>
                        <div class="col-sm-8">
                            <input type="text" value="{{ $member->Officer->user_name }}" name="username" class="form-control" id="username" placeholder="{{ trans('general.enter',['attribute' => trans('profile.username') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="password"> {{ trans('profile.password') }}:</label>
                        <div class="col-sm-8">
                            <input type="text" name="password" class="form-control" id="password" placeholder="{{ trans('general.enter',['attribute' => trans('profile.password') ]) }}">
                        </div>
                    </div>
                </div>
            </div>
            <h5>{{ trans('profile.others') }}</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="remark">{{ trans('profile.remark') }}:</label>
                        <div class="col-sm-8">
                            <textarea name="remark" class="form-control" id="remark" placeholder="{{ trans('general.enter',['attribute' => trans('profile.remark') ]) }}">{{ $member->profile->remark }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <button id="jqx-save" type="button"​​ class="pull-right"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        
		getJqxDatePicker('date_of_birth', @if($member->profile->date_of_birth) '{{ $member->profile->date_of_birth }}' @else null @endif);
        function showHideMemberType()
        {
            member_type = $('#member_type');
            
            $('#outside').hide();
            if(member_type.is(':checked'))
            {
                $('#internal').hide();
                $('#outside').show();
            }
            else
            {
                $('#internal').show();
            }
        }

        showHideMemberType();
        
       
        $('#member_type').on('change',function(){
            showHideMemberType();
        });

        initDropDown('officer',{!! $officers !!},{{ $member->officer_id }});
		$("#jqx-save").click(function(){
            saveJqxItem('', '{{ secret_route() }}/member/{{ $member->id }}', '{{ csrf_token() }}');
        });
        
		var buttons = ['jqx-save'];
		initialButton(buttons,90,30);

	});
</script>