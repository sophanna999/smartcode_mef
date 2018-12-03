
<div class="container-fluid">
        <br/>
        <form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-form-copy-schedule">
            {{ csrf_field() }}
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
                            <textarea name="description" class="form-control" id="description" placeholder="{{ trans('general.enter',['attribute' => trans('room.description') ]) }}" cols="30" rows="5">{{ $schedule->description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <button id="btn-save-schedule" type="button"​​ class="pull-right"><span class="glyphicon glyphicon-check"></span> {{ trans('general.save') }}</button>
                    <button id="btn-cancel-schedule" type="button"​​ class="pull-right btn btn-default margin-right-md"> {{ trans('general.cancel') }}</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function(){
            showDateTimePicker('time_in');
            showDateTimePicker('time_out');

            $('#time_in').jqxDateTimeInput('setDate',new Date('{{ $schedule->time_in }}'));
            $('#time_out').jqxDateTimeInput('setDate',new Date('{{ $schedule->time_out }}'));

            @if($training->location_id)
                initDropDown('room',{!! $rooms !!},{{ $schedule->room_id }});
            @endif
            
            initDropDown('subject',{!! $subjects !!},{{ $schedule->subject_id }});
            initDropDown('trainer',{!! $trainers !!},{{ $schedule->member()->wherePivot('type','primary_trainer')->first()->id }});
            initDropDown('assistant',{!! $assistants !!},{{ $schedule->member()->wherePivot('type','primary_assistant')->first() ? $schedule->member()->wherePivot('type','primary_assistant')->first()->id : null }});

            var rooms = JSON.parse('{!! $rooms !!}');
            var trainers = JSON.parse('{!! $trainers !!}');
            var assistants = JSON.parse('{!! $assistants !!}');

            getBusy();

            $("#time_in").on('change',function(){
                getBusy();
            });

            $("#time_out").on('change',function(){
                getBusy();
            });

            function getBusy(){
                var formData = new FormData();

                var stringStartDate = $('#time_in').jqxDateTimeInput('val');
                var stringEndDate = $('#time_out').jqxDateTimeInput('val');
                
                var from_date =  moment(stringStartDate, "DD-MM-YYYY h:mm A").format('YYYY-MM-DD H:mm:ss');
                var to_date = moment(stringEndDate, "DD-MM-YYYY h:mm A").format('YYYY-MM-DD H:mm:ss');

                formData.append('time_in',from_date);
                formData.append('time_out',to_date);
                formData.append('_token','{{ csrf_token() }}');

                $.ajax({
                    url: '{{ secret_route() }}/schedule/busy-coordinate',
                    type: 'post',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(data){
                        if(data.rooms){
                            var busy = data.rooms;
                            var i = 0;
                            for(let key in rooms){
                                $("#room").jqxDropDownList('enableAt', i);
                                for(let k in busy){
                                    if(busy[k] == key){
                                        $("#room").jqxDropDownList('disableAt', i);
                                    }
                                }
                                i++;
                            }
                        }
                        if(data.trainers){
                            var busy = data.trainers;
                            var i = 0;
                            for(let key in trainers){
                                $("#trainer").jqxDropDownList('enableAt', i);
                                for(let k in busy){
                                    if(busy[k] == key){
                                        $("#trainer").jqxDropDownList('disableAt', i);
                                    }
                                }
                                i++;
                            }
                        }

                        if(data.assistants){
                            var busy = data.assistants;
                            var i = 0;
                            for(let key in assistants){
                                $("#assistant").jqxDropDownList('enableAt', i);
                                for(let k in busy){
                                    if(busy[k] == key){
                                        $("#assistant").jqxDropDownList('disableAt', i);
                                    }
                                }
                                i++;
                            }
                        }
                    },
                    error: function (request, textStatus, errorThrown) {
                        if(request.status == 422){
                            notification(JSON.parse(request.responseText).message,'warning');
                        }
                    }
                });
            }

            $("#btn-cancel-schedule").click(function(){
                $('#jqxwindowcopy_schedule').jqxWindow('destroy');
                loadSchedule();
            });

            $("#jqxwindowcopy_schedule").on('close',function(){
                loadSchedule();
            });

            $("#btn-save-schedule").click(function(){
                var formData = new window.FormData($('#jqx-form-copy-schedule')[0]);
                
                var stringStartDate = $('#time_in').jqxDateTimeInput('val');
                var stringEndDate = $('#time_out').jqxDateTimeInput('val');
                
                var from_date =  moment(stringStartDate, "DD-MM-YYYY h:mm A").format('YYYY-MM-DD H:mm:ss');
                var to_date = moment(stringEndDate, "DD-MM-YYYY h:mm A").format('YYYY-MM-DD H:mm:ss');

                formData.set('time_in',from_date);
                formData.set('time_out',to_date);

                $.ajax({
                    url: '{{ secret_route() }}/schedule/{{ $training->id }}',
                    type: 'post',
                    dataType: 'json',
                    processData: false,
                    data: formData,
                    contentType: false,
                    success: function(data){
                        $('#jqxwindowcopy_schedule').jqxWindow('destroy');
                        loadSchedule();
                    },
                    error: function (request, textStatus, errorThrown) {
                        if(request.status == 422){
                            showErrors(JSON.parse(request.responseText),'jqx-form-copy-schedule');
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