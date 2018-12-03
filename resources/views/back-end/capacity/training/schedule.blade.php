<link href='{{ asset('css/fullcalendar.css') }}' rel='stylesheet' />
<br>
<div class="col-md-10">
    <div id='calendar'></div>
    <div id='window-schedule-add'>
        <div></div>
        <div></div>
    </div>
</div>
<div class="col-md-2">
    <button class="add-schedule btn btn-success btn-block"><i class="fa fa-plus"></i> {{ trans('general.add_new',['attr' => trans('training.session')]) }}</button>
    <hr>
    <div id="trash" class="text-center padding-sm" style="border:1px solid #dddd; border-radius:5px;">
        <i class="fa fa-trash fa-4x text-danger"></i>
    </div>
    <hr>
    <div id='external-events'>
        <h5>{{trans('subject.subject')}} <span><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ trans('training.drag_drop_help',['attr' => trans('training.subject') ]) }}"></i></span></h5>
        @if($training->course->subject->count())
            @foreach($training->course->subject as $subject)
                <a module="subject" value="{{ $subject->id }}" class="btn btn-default event-item btn-block " style="overflow:hidden">{{ $subject->name }}</a>
            @endforeach
        @else 
            <div class="alert alert-info">{{ trans('general.no_data_yet') }}</div>
        @endif

        <hr/>
        <h5>{{trans('training.trainer')}} <span><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ trans('training.drag_drop_help',['attr' => trans('training.trainer') ]) }}"></i></span></h5>
        @if($training->member()->wherePivot('type','trainer')->get()->count())
            @foreach($training->member()->wherePivot('type','trainer')->get() as $trainer)
                <a module="participate" value="{{ $trainer->id }}" class="btn btn-default event-item btn-block" style="overflow:hidden">{{ $trainer->full_name }}</a>
            @endforeach
        @else 
            <div class="alert alert-info">{{ trans('general.no_data_yet') }}</div>
        @endif

        <hr/>
        <h5>{{trans('training.assistant')}} <span><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ trans('training.drag_drop_help',['attr' => trans('training.assistant') ]) }}"></i></span></h5>
        @if($training->member()->wherePivot('type','assistant')->get()->count())
            @foreach($training->member()->wherePivot('type','assistant')->get() as $assistant)
                <a module="participate" value="{{ $assistant->id }}" class="btn btn-default event-item btn-block" style="overflow:hidden">{{ $assistant->full_name }}</a>
            @endforeach
        @else 
            <div class="alert alert-info">{{ trans('general.no_data_yet') }}</div>
        @endif

        <hr/>
        <h5>{{trans('room.room')}} <span><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ trans('training.drag_drop_help',['attr' => trans('room.room') ]) }}"></i></span></h5>
        @if($rooms->count())
            @foreach($rooms as $room)
                <a module="room" value="{{ $room->id }}" class="btn btn-default event-item btn-block" style="overflow:hidden">{{ $room->name }}</a>
            @endforeach
        @else 
            <div class="alert alert-info">{{ trans('general.no_data_yet') }}</div>
        @endif
    </div>
</div>

<script>

    function scheduleAdd(start,end = null,subject = null,room = null,trainer = null,assistant = null){
        var url= '{{ secret_route() }}/schedule/{{ $training->id }}/create';
        var param = { _token:'{{ csrf_token() }}' };
        
        var start = start;
        var end = end;
        var subject = subject;
        var room = room;
        var trainer = trainer;
        var assistant = assistant;

        newJqxAjax('add_schedule', '{{ trans('general.create') }}',800, 400, url, param,function(data){
            $('#time_in').jqxDateTimeInput('setDate', new Date(start));
            $('#time_out').jqxDateTimeInput('setDate', new Date(start));

            if(room){
                $("#room").jqxDropDownList('selectItem', room); 
            }
            if(subject){
                $("#subject").jqxDropDownList('selectItem', subject); 
            }
            if(trainer){
                $("#trainer").jqxDropDownList('selectItem', trainer); 
            }
            if(assistant){
                $("#assistant").jqxDropDownList('selectItem', assistant); 
            }
        });
    }

    function scheduleEdit(event){
        var url= '{{ secret_route() }}/schedule/' + event.id + '/edit';
        var param = { _token:'{{ csrf_token() }}' };
        var event = event;
        newJqxAjax('edit_schedule', '{{ trans('general.edit') }}',800, 400, url, param,function(data){
            $('#time_in').jqxDateTimeInput('setDate', event.start.toDate());
            $('#time_out').jqxDateTimeInput('setDate', event.end.toDate());
            if(event.room){
                $("#room").jqxDropDownList('selectItem', event.room); 
            }else{
                $("#custom_room").val(event.custom_room); 
            } 
            $("#subject").jqxDropDownList('selectItem', event.subject); 
            $("#trainer").jqxDropDownList('selectItem', event.trainer); 
            $("#assistant").jqxDropDownList('selectItem', event.assistant); 
            $("#description").val(event.description); 
        });
    }

    function scheduleUpdate(event){
        var data = new FormData();

        data.append('time_in',event.start.format('YYYY-MM-DD H:mm:ss'));
        data.append('time_out',event.end.format('YYYY-MM-DD H:mm:ss'));
        data.append('subject',event.subject);
        data.append('room',event.room);
        data.append('custom_room',event.custom_room);
        data.append('trainer',event.trainer);
        data.append('assistant',(event.assistant? event.assistant : '') );
        data.append('description',event.description);
        data.append('_method','PATCH');
        data.append('_token','{{ csrf_token() }}');

        $.ajax({
            data: data,
            url: '{{ secret_route() }}/schedule/' + event.id,
            type: 'POST',
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response){
                loadSchedule();
            },
            error: function(request){		
                notification(JSON.parse(request.responseText).message,'warning');
                loadSchedule();
            }
        });
    }

    function scheduleDelete(event){
        var event = event;
        if (isElemOverDiv()) {
            confirmDelete('{{ trans('general.confirm_delete_title') }}','{{ trans('general.confirm_delete_content') }}',function(){
                
                var data = new FormData();
                data.append('_method','DELETE');
                data.append('_token','{{ csrf_token() }}');

                $.ajax({
                    data: data,
                    url: '{{ secret_route() }}/schedule/' + event.id,
                    type: 'POST',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response){
                        loadSchedule();
                    },
                    error: function(request){		
                        notification(JSON.parse(request.responseText).message,'warning');
                        loadSchedule();
                    }
                });
            });
        }
    }

    function loadSchedule(m,val){
        calendar();

        var params = { _token:'{{ csrf_token() }}' };
        $('#external-events .event-item').each(function() {
            if($(this).hasClass('btn-info')) {
                $(this).removeClass('btn-info');
            }
            
            if(m == $(this).attr('module') && val == $(this).attr('value')){
                params[$(this).attr('module')] = $(this).attr('value');
                $(this).addClass('btn-info');
            }
            
        });
  
        $.ajax({
            url: '{{ secret_route() }}/schedule/{{ $training->id }}',
            type: 'GET', 
            dataType:'JSON',
            data: params,
            async: false,
            success: function(response){
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('addEventSource', JSON.parse(response.schedules));      
                $('#calendar').fullCalendar('rerenderEvents' );
            }
        });
    }

    function calendar(){
        $('#calendar').fullCalendar({
            events:[],
            utc: true,
            header: {
                left: 'prev,next today',
                center: '',
                right: ''
            },
            slotDuration: '00:30:00',
            minTime: '06:00:00',
            maxTime: '19:00:00',
            validRange: {
                start: '{{ $training->start_date }}',
                end: '{{ date('Y-m-d',strtotime($training->end_date.' +1 days')) }}'
            },
            droppable: true, 
            editable: true,
            defaultView: 'agendaWeek',
            dayClick: function(date, jsEvent, view) {
                scheduleAdd(date.format());
            },
            eventClick: function(event, jsEvent, view) {
                scheduleEdit(event)
            },
            eventReceive: function(event){
                scheduleAdd(
                    event.start.format("YYYY-MM-DD[T]HH:mm:SS"),
                    event.start.format("YYYY-MM-DD[T]HH:mm:SS"),
                    event.subject,
                    event.room,
                    event.trainer,
                    event.assistant
                );
			},
            eventResize: function(event, delta, revertFunc) {
                scheduleUpdate(event);                
            },
            eventDrop: function(event, delta, revertFunc) {
		        scheduleUpdate(event);
            },
            eventDragStop: function (event, jsEvent, ui, view) {
			    scheduleDelete(event);
			}
        });
    }

    var currentMousePos = {
            x: -1,
            y: -1
        };
		jQuery(document).on("mousemove", function (event) {
        currentMousePos.x = event.pageX;
        currentMousePos.y = event.pageY;
    });

    function isElemOverDiv() {
        var trashEl = jQuery('#trash');

        var ofs = trashEl.offset();

        var x1 = ofs.left;
        var x2 = ofs.left + trashEl.outerWidth(true);
        var y1 = ofs.top;
        var y2 = ofs.top + trashEl.outerHeight(true);

        if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
            currentMousePos.y >= y1 && currentMousePos.y <= y2) {
            return true;
        }
        return false;
    }

    $('#external-events .event-item').each(function() {
        // store data so the calendar knows to render an event upon drop
        $(this).data('event', {
            subject: $.trim($(this).attr('value')), // use the element's text as the event title
            room: $.trim($(this).attr('value')), // use the element's text as the event title
            trainer: $.trim($(this).attr('value')), // use the element's text as the event title
            assistant: $.trim($(this).attr('value')), // use the element's text as the event title
            stick: true // maintain when user navigates (see docs on the renderEvent method)
        });

        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true,      // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
        });

    });
    
    $(document).ready(function() {

        loadSchedule();
        calendar();

        $(".add-schedule").click(function(){
            scheduleAdd(new Date());
        });

        function isElemOverDiv() {
            var trashEl = jQuery('#trash');
    
            var ofs = trashEl.offset();
    
            var x1 = ofs.left;
            var x2 = ofs.left + trashEl.outerWidth(true);
            var y1 = ofs.top;
            var y2 = ofs.top + trashEl.outerHeight(true);
    
            if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
                currentMousePos.y >= y1 && currentMousePos.y <= y2) {
                return true;
            }
            return false;
        }

        $('.event-item').click(function(){
            loadSchedule($(this).attr('module'),$(this).attr('value'));
        });
    
    });
    
    </script>

