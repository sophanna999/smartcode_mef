
<div class="container-fluid">
        <br/>
        <form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-form-edit-schedule">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="time_in"><span class="red-star">*</span>{{ trans('training.time_in') }}:</label>
                        <div class="col-sm-8">
                            <div id="time_in" name="time_in" data-placeholder="{{ trans('general.enter',['attribute' => trans('training.time_in') ]) }}"></div>
                            <div class="clearfix"></div>
                            <div class="message"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="time_out"><span class="red-star">*</span>{{ trans('training.time_out') }}:</label>
                        <div class="col-sm-8">
                            <div id="time_out" name="time_out" data-placeholder="{{ trans('general.enter',['attribute' => trans('training.time_out') ]) }}"></div>
                            <div class="clearfix"></div>
                            <div class="message"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="subject"><span class="red-star">*</span>{{ trans('subject.subject') }}:</label>
                        <div class="col-sm-8">
                            <div id="subject" name="subject"></div>
                            <div class="clearfix"></div>
                            <div class="message"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="room"><span class="red-star">*</span>{{ trans('room.room') }}:</label>
                        <div class="col-sm-8">
                            @if($training->location_id)
                                <div id="room" name="room"></div>
                                <div class="clearfix"></div>
                                <div class="message"></div>
                            @else
                                <input type="text" name="custom_room" class="form-control" id="custom_room" placeholder="{{ trans('general.enter',['attribute' => trans('training.outside_room') ]) }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="trainer"><span class="red-star">*</span>{{ trans('training.trainer') }}:</label>
                        <div class="col-sm-8">
                            <div id="trainer" name="trainer"></div>
                            <div class="clearfix"></div>
                            <div class="message"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="assistant">{{ trans('training.assistant') }}:</label>
                        <div class="col-sm-8">
                            <div id="assistant" name="assistant"></div>
                            <div class="clearfix"></div>
                            <div class="message"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="description">{{ trans('room.description') }}:</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" id="description" placeholder="{{ trans('general.enter',['attribute' => trans('room.description') ]) }}" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button id="btn-copy-schedule" type="button"​​ class="btn btn-default"><span class="fa fa-copy"></span> {{ trans('general.copy') }}</button>
                        <div class="pull-right">
                            <button id="btn-save-schedule" type="button"​​ class=""><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <script>
        $(document).ready(function(){

            showDateTimePicker('time_in');
            showDateTimePicker('time_out');
            @if($schedule->room_id)
                initDropDown('room',{!! $rooms !!});
            @endif
            initDropDown('subject',{!! $subjects !!});
            initDropDown('trainer',{!! $trainers !!});
            initDropDown('assistant',{!! $assistants !!});

            $('#btn-copy-schedule').click(function(){
                $('#jqxwindowedit_schedule').jqxWindow('destroy');
                var url= '{{ secret_route() }}/schedule/{{ $schedule->id }}/copy';
                newJqxAjax('copy_schedule', '{{ trans('general.copy') }}',800, 400, url, { _token:'{{ csrf_token() }}' },function(data){
                });
            });
    
            $("#btn-save-schedule").click(function(){
                var formData = new window.FormData($('#jqx-form-edit-schedule')[0]);
                
                var stringStartDate = $('#time_in').jqxDateTimeInput('val');
                var stringEndDate = $('#time_out').jqxDateTimeInput('val');
                
                var from_date =  moment(stringStartDate, "DD-MM-YYYY h:mm A").format('YYYY-MM-DD H:mm:ss');
                var to_date = moment(stringEndDate, "DD-MM-YYYY h:mm A").format('YYYY-MM-DD H:mm:ss');

                formData.set('time_in',from_date);
                formData.set('time_out',to_date);

                $.ajax({
                    url: '{{ secret_route() }}/schedule/{{ $schedule->id }}',
                    type: 'post',
                    dataType: 'json',
                    processData: false,
                    data: formData,
                    contentType: false,
                    success: function(data){
                        $('#jqxwindowedit_schedule').jqxWindow('destroy');
                        loadSchedule();
                    },
                    error: function (request, textStatus, errorThrown) {
                        if(request.status == 422){
                            showErrors(JSON.parse(request.responseText),'jqx-form-add-schedule');
                        }else if(request.status == 400){
                            notification(JSON.parse(request.responseText).message,'warning');
                        }
                    }
                });
            });
            
            var buttons = ['btn-save-schedule'];
            initialButton(buttons,90,30);
    
        });
    </script>