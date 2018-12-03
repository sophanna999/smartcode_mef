
<div class="container-fluid">
    <br/>
    <form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-form">
        {{ csrf_field() }}
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">

        <label class="margin-bottom-xl"><input type="checkbox" id="member_type" name="type" value="1">{{ trans('profile.outsite_member') }}</label>

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

        {{-- <h5>{{ trans('profile.general_info') }}</h5>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="code"><span class="red-star">*</span>{{ trans('profile.code') }}:</label>
                    <div class="col-sm-8">
                        <input type="text" name="code" class="form-control" id="code" placeholder="{{ trans('general.enter',['attribute' => trans('profile.code') ]) }}">
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
                            <input type="text" name="full_name" class="form-control" id="full_name" placeholder="{{ trans('general.enter',['attribute' => trans('profile.full_name') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="latin_name"><span class="red-star">*</span>{{ trans('profile.latin_name') }}:</label>
                        <div class="col-sm-8">
                            <input type="text" name="latin_name" class="form-control" id="latin_name" placeholder="{{ trans('general.enter',['attribute' => trans('profile.latin_name') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="gender">{{ trans('profile.gender') }}:</label>
                        <div class="col-sm-8">
                            <div class="radio pull-left margin-right-md">
                                <label><input type="radio" name="gender" value="ប្រុស">{{ trans('profile.male') }}</label>
                            </div>
                            <div class="radio pull-left">
                                <label><input type="radio" name="gender" value="ស្រី">{{ trans('profile.female') }}</label>
                            </div>
                            <div class="clearfix"></div>
                            <div class="message"></div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="date_of_birth">{{ trans('profile.date_of_birth') }}:</label>
                        <div class="col-sm-8">
                            <div id="date_of_birth" name="date_of_birth" data-placeholder="{{ trans('general.enter',['attribute' => trans('profile.date_of_birth') ]) }}"></div>
                            <div class="clearfix"></div>
                            <div class="message"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="address">{{ trans('profile.address') }}:</label>
                        <div class="col-sm-8">
                            <textarea name="address" class="form-control" id="address" placeholder="{{ trans('general.enter',['attribute' => trans('profile.address') ]) }}"></textarea>
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
                            <input type="text" name="position" class="form-control" id="position" placeholder="{{ trans('general.enter',['attribute' => trans('profile.position') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="company">{{ trans('profile.company') }}:</label>
                        <div class="col-sm-8">
                            <input type="text" name="company" class="form-control" id="company" placeholder="{{ trans('general.enter',['attribute' => trans('profile.company') ]) }}">
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
                            <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="{{ trans('general.enter',['attribute' => trans('profile.phone_number') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="email"><span class="red-star">*</span> {{ trans('profile.email') }}:</label>
                        <div class="col-sm-8">
                            <input type="text" name="email" class="form-control" id="email" placeholder="{{ trans('general.enter',['attribute' => trans('profile.email') ]) }}">
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
                            <input type="text" name="username" class="form-control" id="username" placeholder="{{ trans('general.enter',['attribute' => trans('profile.username') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="password"><span class="red-star">*</span> {{ trans('profile.password') }}:</label>
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
                            <textarea name="remark" class="form-control" id="remark" placeholder="{{ trans('general.enter',['attribute' => trans('profile.remark') ]) }}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label><input type="checkbox" name="send_email" value="1">{{ trans('profile.send_welcome_email') }}</label>
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
        getJqxDatePicker('date_of_birth');
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

        initDropDown('officer',{!! $officers !!})

		$("#jqx-save").click(function(){
            saveJqxItem('', '{{ secret_route() }}/member', '{{ csrf_token() }}');
        });
        
		var buttons = ['jqx-save'];
		initialButton(buttons,90,30);

	});
</script>