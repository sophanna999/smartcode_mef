<div class="col-md-9">
    <h4>{{ trans('training.attendance') }}</h4>
    <div class="row">

        <img class="center-block" src='{{ asset('icon/ComingSoon.gif') }}' />
        <!-- <div class="col-sm-5">
            <dl class="dl-horizontal" style="margin-bottom:0">
                <dt>{{ trans('training.code') }}</dt>
                <dd>{{ $training->prefix.$training->code }}</dd>
                <dt>{{ trans('course.course') }}</dt>
                <dd>{{ $training->course->title_with_code }}</dd>
                <dt>{{ trans('general.date') }}</dt>
                <dd>{{ showDate($training->start_date)  }} - {{ showDate($training->end_date)  }}</dd>
                <dt>{{ trans('location.location') }}</dt>
                <dd>{{ $training->location->name }}</dd>
                <dt>{{ trans('general.status') }}</dt>
                <dd>{!! prettyStatus($training->status) !!}</dd>
                <div class="address-manual" style="display: none;">
                    <dt>{{ trans('general.created_date') }}</dt>
                    <dd>{{ $training->prefix.$training->code }}</dd>
                    <dt>{{ trans('general.updated_date') }}</dt>
                    <dd>{{ $training->course->title_with_code }}</dd>
                    <dt>{{ trans('general.created_by') }}</dt>
                    <dd>{{ showDate($training->start_date)  }} - {{ showDate($training->end_date)  }}</dd>
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
        </div> -->
    </div>
</div>

