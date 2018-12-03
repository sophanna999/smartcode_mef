
<div class="container-fluid">
    <br/>
    <form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-form">
        {{ csrf_field() }}
        <input type="hidden" id="Id" name="Id" value="{{isset($row->id) ? $row->id:0}}">

        <div id="outside">
            <h5>{{ trans('profile.basic_info') }}</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="full_name"><span class="red-star">*</span>{{ trans('profile.full_name') }}:</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   value="{{isset($row)?$row->profile->full_name: ''}}"
                                   name="full_name" class="form-control" id="full_name" placeholder="{{ trans('general.enter',['attribute' => trans('profile.full_name') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="latin_name"><span class="red-star">*</span>{{ trans('profile.latin_name') }}:</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   value="{{isset($row)?$row->profile->latin_name: ''}}"
                                   name="latin_name" class="form-control" id="latin_name" placeholder="{{ trans('general.enter',['attribute' => trans('profile.latin_name') ]) }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="gender">{{ trans('profile.gender') }}:</label>
                        <div class="col-sm-8">
                            <div class="radio pull-left margin-right-md">
                                <label><input type="radio" name="gender" {{isset($row)? $row->profile->gender =='m'? 'checked': '':'checked'}} value="m" >{{ trans('profile.male') }}</label>
                            </div>
                            <div class="radio pull-left">
                                <label><input type="radio" name="gender" {{isset($row)? $row->profile->gender =='f'? 'checked': '':''}} value="f">{{ trans('profile.female') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="date_of_birth">{{ trans('profile.date_of_birth') }}:</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   value="{{isset($row)?date('d/m/Y', strtotime($row->profile->date_of_birth)):''}}"
                                   name="date_of_birth" class="form-control hide"
                                   id="date_of_birth"
                                   placeholder="{{ trans('general.enter',['attribute' => trans('profile.date_of_birth') ]) }}">
                            <div id="div_date_of_birth"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="date_of_birth">{{ trans('outside_staff.nationality') }}:</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   value="{{isset($row)?$row->nationality: ''}}"
                                   name="nationality" class="form-control" id="nationality" placeholder="{{ trans('general.enter',['attribute' => trans('outside_staff.nationality') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="date_of_birth">{{ trans('outside_staff.education') }}:</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   value="{{isset($row)?$row->education: ''}}"
                                   name="education" class="form-control" id="education" placeholder="{{ trans('general.enter',['attribute' => trans('outside_staff.education') ]) }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="address">{{ trans('profile.address') }}:</label>
                        <div class="col-sm-8">
                            <textarea name="address" class="form-control" id="address" placeholder="{{ trans('general.enter',['attribute' => trans('profile.address') ]) }}">{{isset($row)?$row->profile->address: ''}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="latin_name">@lang('news.image')</label>
                        <div class="col-sm-8">
                            <?php $avatar = isset($row) ? $row->profile->avatar : asset('images/default.png'); ?>
                            <input type="file" value="" class="form-control" id="icon" name="avatar_file" accept="image/*">
                            <div class="wrap-avatar" id="wrap-avatar">
                                <input type="hidden" name="statusRemovePicture" value="0" id="statusRemovePicture"/>
                                <img class="img-user" id="img-icon"
                                     src="{{$avatar == "" ? asset("images/default.png") : asset($avatar)}}" alt="">
                                <?php $statusRemoveAvatar = isset($row) ? $row->profile->avatar : ""; ?>
                                <span class="remove-avatar {{$statusRemoveAvatar == '' ? "display-none" : ''}}">
						<i class="glyphicon glyphicon-remove"></i></span>
                            </div>
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
                            <input type="text"
                                   value="{{isset($row)?$row->phone_number: ''}}"
                                   name="phone_number" class="form-control" id="phone_number" placeholder="{{ trans('general.enter',['attribute' => trans('profile.phone_number') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="email"><span class="red-star">*</span> {{ trans('profile.email') }}:</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   value="{{isset($row)?$row->email: ''}}"
                                   name="email" class="form-control" id="email" placeholder="{{ trans('general.enter',['attribute' => trans('profile.email') ]) }}">
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
                            <input type="text"
                                   value="{{isset($row)?$row->profile->position: ''}}"
                                   name="position" class="form-control" id="position" placeholder="{{ trans('general.enter',['attribute' => trans('profile.position') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="company">{{ trans('outside_staff.company_name') }}:</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   value="{{isset($row)?$row->profile->company: ''}}"
                                   name="company" class="form-control" id="company" placeholder="{{ trans('general.enter',['attribute' => trans('outside_staff.company_name') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="position">{{ trans('outside_staff.company_tel') }}:</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   value="{{isset($row)?$row->company_tel: ''}}"
                                   name="company_tel" class="form-control" id="company_tel" placeholder="{{ trans('general.enter',['attribute' => trans('outside_staff.company_tel') ]) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="company">{{ trans('outside_staff.company_email') }}:</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   value="{{isset($row)?$row->company_email: ''}}"
                                   name="company_email" class="form-control" id="company_email" placeholder="{{ trans('general.enter',['attribute' => trans('outside_staff.company_email') ]) }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="company">{{ trans('outside_staff.company_website') }}:</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   value="{{isset($row)?$row->company_website: ''}}"
                                   name="company_website" class="form-control" id="company_website" placeholder="{{ trans('general.enter',['attribute' => trans('outside_staff.company_website') ]) }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="address">{{ trans('outside_staff.company_address') }}:</label>
                        <div class="col-sm-8">
                            <textarea name="company_address" class="form-control" id="company_address" placeholder="{{ trans('general.enter',['attribute' => trans('outside_staff.company_address') ]) }}">{{isset($row)?$row->company_address: ''}}</textarea>
                        </div>
                    </div>
                </div>



            </div>

            {{--<h5>{{ trans('outside_staff.att_info') }}</h5>--}}
            {{--<hr>--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-6">--}}
                    {{--<div class="form-group">--}}
                        {{--<label class="control-label col-sm-4" for="position">{{ trans('outside_staff.att_type') }}:</label>--}}
                        {{--<div class="col-sm-8">--}}
                            {{--<input type="text"--}}
                                   {{--name="type" class="form-control" id="type" placeholder="{{ trans('general.enter',['attribute' => trans('outside_staff.att_type') ]) }}">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-6">--}}
                    {{--<div class="form-group">--}}
                        {{--<label class="control-label col-sm-4" for="company">{{ trans('outside_staff.att_no') }}:</label>--}}
                        {{--<div class="col-sm-8">--}}
                            {{--<input type="text"--}}
                                   {{--name="company" class="form-control" id="company" placeholder="{{ trans('general.enter',['attribute' => trans('outside_staff.att_no') ]) }}">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
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

        function days_of_a_year(year)
        {
            return isLeapYear(year) ? 366 : 365;
        }
        function isLeapYear(year) {
            return year % 400 === 0 || (year % 100 !== 0 && year % 4 === 0);
        }

        daysOfyear = days_of_a_year((new Date()).getFullYear());
        var d = new Date();
        var date2 = new Date();

        var sun = new Array();   //Declaring array for inserting Sundays

        for(var i=0;i<=daysOfyear;i++){    //looping through days in month
            var newDate = new Date(d.getFullYear(),d.getMonth(),i);
            if(newDate.getDay()==0){   //if Sunday
                date2.setHours(0,0,0);
                sun.push(newDate);
            }
            if(newDate.getDay()==6){   //if Saturday
                sun.push(newDate);
            }
        }

        $("#div_date_of_birth").jqxDateTimeInput({
            restrictedDates: sun
        });

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth();
        var yyyy = today.getFullYear();

        @if(isset($row->profile->date_of_birth))
        <?php
            $year = date('Y', strtotime($row->profile->date_of_birth));
            $month = date('m -1',strtotime($row->profile->date_of_birth));
            $day = date('d', strtotime($row->profile->date_of_birth));
        ?>
            $('#div_date_of_birth').jqxDateTimeInput( {formatString: 'dd/MM/yyyy',value: new Date({{$year}},{{$month}},{{$day}})});
        @else
            $('#div_date_of_birth').jqxDateTimeInput(new Date(yyyy, mm, dd));
        @endif

        $('#div_date_of_birth').on('change', function (event)
        {
            var newDOB = $('#inputdiv_date_of_birth').val();
            $('#date_of_birth').val(newDOB);
        });

		$("#jqx-save").click(function(){
            saveJqxItem('', '{{ secret_route() }}/outside-staff', '{{ csrf_token() }}');
        });

        //Form Validation
        $('#jqx-form').jqxValidator({
            hintType: 'label',
            rules: [
                {input: '#first_name', message: ' ', action: 'blur', rule: 'required'},
                {input: '#last_name', message: ' ', action: 'blur', rule: 'required'},
                {input: '#phone_number', message: ' ', action: 'blur', rule: 'required'},
                {input: '#email', message: ' ', action: 'blur', rule: 'required'},
                // {input: '#div_date_of_birth', message: ' ', action: 'select',
                //     rule: function () {
                //         if($("#date_of_birth").val() == ""){
                //             return false;
                //         }
                //         return true;
                //     }
                // }
            ]
        });

		var buttons = ['jqx-save'];
		initialButton(buttons,90,30);

        $("#icon").jqxFileUpload();
        $("#icon").change(function () {
            var input = this;
            var reader = new FileReader();
            var img = new Image();
            reader.onload = function (e) {
                img.src = e.target.result;
                $('#img-icon').attr('src', e.target.result);
                $('#statusRemovePicture').val(0);
                $('.remove-avatar').removeClass('display-none');
            };
            reader.readAsDataURL(input.files[0]);
        });
	});


</script>