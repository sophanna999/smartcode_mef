
<div class="container-fluid">
    <div id='tabs'>
        <ul>
            <li style="margin-left: 30px;">{{ trans('general.basic') }}</li>
            <li>{{ trans('survey.survey_question') }}</li>
            <li>{{ trans('general.attachment') }}</li>
            <li>{{ trans('general.other') }}</li>
        </ul>
        <br/>
        <div id="content1">
            <div class="col-sm-12">
                
            </div>
        </div>
        <div id="content2">
            
        </div>
        <div id="content3">
            <div class="col-sm-12">
            </div>
        </div>
        <div id="content4">
            <div class="col-sm-12">
                
            </div>
        </div>
    </div>   
</div>

<script>
    $(document).ready(function(){
        $('#tabs').jqxTabs({ width: '100%', height: 'auto', position: 'top'});   
        var loadPage = function (url, tabIndex) {
            $.get(url, function (data) {
                $('#content' + tabIndex).html(data);
            });
        }
        loadPage('{{ secret_route() }}/course/basic/{{ $course->id }}', 1);
        $('#tabs').on('selected', function (event) {
            var pageIndex = event.args.item + 1;
            if(pageIndex == 1)
                loadPage('{{ secret_route() }}/course/basic/' + {{ $course->id }}, pageIndex);
            else if(pageIndex == 2)
                loadPage('{{ secret_route() }}/course/survey/' + {{ $course->id }}, pageIndex);
            else if(pageIndex == 3)
                loadPage('{{ secret_route() }}/course/attendance/' + {{ $course->id }}, pageIndex);
            else if(pageIndex == 4)
                loadPage('{{ secret_route() }}/course/survey/' + {{ $course->id }}, pageIndex);
            else
                loadPage('{{ secret_route() }}/course/document/' + {{ $course->id }}, pageIndex);
        });  
	});
</script>