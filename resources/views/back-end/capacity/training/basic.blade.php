<div class="col-md-9">
    <h4>{{ trans('general.basic') }}</h4>
    <div class="row">
        <div class="col-sm-5">
            <dl class="dl-horizontal" style="margin-bottom:0">
                <dt>{{ trans('training.code') }}</dt>
                <dd>{{ $training->prefix.$training->code }}</dd>
                <dt>{{ trans('course.course') }}</dt>
                <dd>{{ $training->course->title_with_code }}</dd>
                <dt>{{ trans('general.date') }}</dt>
                <dd>{{ showDate($training->start_date)  }} - {{ showDate($training->end_date)  }}</dd>
                <dt>{{ trans('location.location') }}</dt>
                <dd>{{ $training->location ? $training->location->name : $training->custom_location }}</dd>
                <dt>{{ trans('general.status') }}</dt>
                <dd>{!! prettyStatus($training->status) !!}</dd>
                <div class="address-manual" style="display: none;">
                    <dt>{{ trans('general.created_date') }}</dt>
                    <dd>{{ showDateTime($training->created_at) }}</dd>
                    <dt>{{ trans('general.updated_date') }}</dt>
                    <dd>{{  showDateTime($training->updated_at) }}</dd>
                    <dt>{{ trans('general.created_by') }}</dt>
                    <dd>{{ $training->user->full_name }}</dd>
                </div>
                <dt>
                    <a  data-toggle-class=".address-manual" data-show-less-text="<b>{{ trans('general.show_less') }}</b>" href="javascript:void(0);" class="show-more-options ">
                        <b>{{ trans('general.show_more') }}</b>
                    </a>
                </dt>
            </dl>
        </div>
        <div class="col-sm-6">
            {!! $training->description !!}
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left">{{ trans('training.trainee') }}
                <small>({{ $training->member()->get()->filter(function($t){
                        return $t->pivot->type == 'trainee';
                    })->count() 
                }})</small>
                </h4><a id="showWindow-assign" data-type="trainee" class="showWindow-assign pull-right margin-top-md" href="javascript:void(0)"><i class="fa fa-edit"></i> {{ trans('general.edit')}}</a>
            <div class="clearfix"></div>
            @if($trainees->count())
                @foreach($trainees as $participant)
                    @include('back-end.capacity.component.avatar',$participant)
                @endforeach
            @else 
                <div class="alert alert-info">{{ trans('general.no_data_yet') }}</div>
            @endif
        </div>
    </div>
 
    <div class="row margin-top-lg">
        <div class="col-sm-12">
            <h4 class="pull-left">{{ trans('training.trainer') }} 
                <small>({{ $training->member()->get()->filter(function($t){
                        return $t->pivot->type == 'trainer';
                    })->count() 
                }})</small>
            </h4><a id="showWindow-assign" data-type="trainer" class="showWindow-assign pull-right margin-top-md" href="javascript:void(0)"><i class="fa fa-edit"></i> {{ trans('general.edit')}}</a>
            <div class="clearfix"></div>
            @if($trainers->count())
                @foreach($trainers as $participant)
                    @include('back-end.capacity.component.avatar',$participant)
                @endforeach
            @else 
                <div class="alert alert-info">{{ trans('general.no_data_yet') }}</div>
            @endif
        </div>
    </div>
    <div class="row margin-top-lg">
        <div class="col-sm-12">
            <h4 class="pull-left">{{ trans('training.assistant') }} 
            <small>({{ $training->member()->get()->filter(function($t){
                    return $t->pivot->type == 'assistant';
                })->count() 
            }})</small>
            </h4><a id="showWindow-assign" data-type="assistant" class="showWindow-assign pull-right margin-top-md" href="javascript:void(0)"><i class="fa fa-edit"></i> {{ trans('general.edit')}}</a>
            <div class="clearfix"></div>
            @if($assistants->count())
                @foreach($assistants as $participant)
                    @include('back-end.capacity.component.avatar',$participant)
                @endforeach
            @else 
                <div class="alert alert-info">{{ trans('general.no_data_yet') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="col-md-8">
    <h4>{{ trans('general.attachment') }}
    <small>(០)</small></h4>
    <div class="alert alert-info col-sm-4">{{ trans('general.no_data_yet') }}</div>
</div>
<div class="clearfix"></div>
<hr>
<div class="col-md-12 margin-bottom-xl">
    <div class="pull-right">
        <button class="btn btn-default"><i class="fa fa-download"></i> {{ trans('general.export_all_data') }}</button>
        <button id="showWindow-edit" class="btn btn-info"><i class="fa fa-edit"></i> {{ trans('general.edit') }}</button>
        <button id="btn-delete-training" class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('general.delete') }}</button>
    </div>
</div>

<script type="text/javascript">
    $('.textAvatar').nameBadge();

    $(document).ready(function () {  

        $('.showWindow-assign').click(function () {
            newJqxItem('assign_participant', '{{ trans('general.edit') }}', 300, 200, '{{ secret_route() }}/training/assign/{{ $training->id }}?type=' + $(this).attr('data-type'));
        });

        $('#showWindow-edit').click(function () {
            newJqxItem('edit_training', '{{ trans('general.edit') }}', 900, 700, '{{ secret_route() }}/training/edit/{{ $training->id }}');
        });

        $("#btn-delete-training").click(function(){
            confirmDelete('{{ trans('general.confirm_delete_title') }}','{{ trans('general.confirm_delete_content') }}',function(){
                
                ajaxPostRequest('{{ secret_route() }}/training/delete',{_method:'DELETE',ids:[{{ $training->id }}]},function(){
                    $('#jqxwindowdetail_training').jqxWindow('destroy');
                    $("#jqx-grid").jqxGrid('updatebounddata');
                    $("#jqx-grid").jqxGrid('clearselection');
                    this.dialog("close");
                });
            })
        });

    });
</script>
