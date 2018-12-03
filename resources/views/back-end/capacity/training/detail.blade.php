<div id='jqxWidget'>
    <div id='jqxTabs'>
        <ul>
            <li style="margin-left: 30px;">{{ trans('general.general') }}</li>
            <li>{{ trans('training.schedule') }}</li>
            <li>{{ trans('training.attendance') }}</li>
            <li>{{ trans('training.survey') }}</li>
            <li>{{ trans('training.document') }}</li>
        </ul>
        <div id="content1">
            <img class="center-block" src='{{ asset('icon/ajax-loader.gif') }}' />
        </div>
        <div id="content2">
            <img class="center-block" src='{{ asset('icon/ajax-loader.gif') }}' />
        </div>
        <div id="content3">
            <img class="center-block" src='{{ asset('icon/ajax-loader.gif') }}' />
        </div>
        <div id="content4">
            <img class="center-block" src='{{ asset('icon/ajax-loader.gif') }}' />
        </div>
        <div id="content5">
            <img class="center-block" src='{{ asset('icon/ajax-loader.gif') }}' />
        </div>
    </div>
</div>

<script type="text/javascript">
    function loadTab(){
        $('#jqxTabs').jqxTabs({height: 650});
        var loadPage = function (url, tabIndex) {
            $.get(url, function (data) {
                $('#content' + tabIndex).html(data);
            });
        }
        loadPage('{{ secret_route() }}/training/basic/{{ $training->id }}', 1);
        $('#jqxTabs').on('selected', function (event) {
            var pageIndex = event.args.item + 1;
            if(pageIndex == 1)
                loadPage('{{ secret_route() }}/training/basic/' + {{ $training->id }}, pageIndex);
            else if(pageIndex == 2)
                loadPage('{{ secret_route() }}/training/schedule/' + {{ $training->id }}, pageIndex);
            else if(pageIndex == 3)
                loadPage('{{ secret_route() }}/training/attendance/' + {{ $training->id }}, pageIndex);
            else if(pageIndex == 4)
                loadPage('{{ secret_route() }}/training/survey/' + {{ $training->id }}, pageIndex);
            else
                loadPage('{{ secret_route() }}/training/document/' + {{ $training->id }}, pageIndex);
        });
    }
    $(document).ready(function () {
        loadTab()

        $('#jqxwindow-detail').on('close',function(){
            if($('#window-schedule-add').length) $('#window-schedule-add').jqxWindow('destroy');
            if($('#window-assign-trainee').length) $('#window-assign-trainee').jqxWindow('destroy');
            if($('#window-assign-trainer').length) $('#window-assign-trainer').jqxWindow('destroy');
            if($('#window-assign-assistant').length) $('#window-assign-assistant').jqxWindow('destroy');
        });
    });
</script>