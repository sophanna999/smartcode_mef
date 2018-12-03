<div class="col-sm-12">
    <button id="add_survey" class="btn btn-primary btn-sm">{{ trans('general.create') }}</button>
    <br/>
    <br/>
    <div id="dataTable"></div>
    <br/>
</div>

<script type="text/javascript">
    $("#add_survey").on('click',function(){
        newJqxItem('', '{{ trans('general.create') }}',800,540, '{{ secret_route() }}/course/survey/'+{{ $course->id }}+'/create');
    });

    var source =
    {
        dataType: "json",
        dataFields: [
            { name: 'name', type: 'string' },
            { name: 'number_of_question', type: 'string' },
            { name: 'option', type: 'string' },
        ],
        id: 'id',
        url: '{{ secret_route() }}/course/survey/'+{{ $course->id }}+'/lists',
    };
    $(document).ready(function () {
        var dataAdapter = new $.jqx.dataAdapter(source);
        $("#dataTable").jqxDataTable(
        {
            width: '100%',
            source: dataAdapter,
            columns: [
              { text: '{{ trans('survey.name') }}', dataField: 'name', width: '60%' },
              { text: '{{ trans('survey.number_of_question') }}', dataField: 'number_of_question', width: '20%' },
              { text: '{{ trans('general.option') }}', dataField: 'option', width: '20%' },
          ]
        });
    });
</script>