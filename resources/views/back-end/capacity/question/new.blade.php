
<div class="container-fluid">
        <br/>
        <form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-form_create_question">
            {{ csrf_field() }}

            <div class="form-group">
                <label class="control-label col-sm-3" for="title"><span class="red-star">*</span>{{ trans('survey.title') }}:</label>
                <div class="col-sm-7">
                    <input type="text" name="title" class="form-control" id="title" placeholder="{{ trans('general.enter',['attribute' => trans('survey.title') ]) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" for="location"><span class="red-star">*</span>{{ trans('survey.question') }}:</label>
                <div class="col-sm-7">
                    <div id="type" name="type"></div>
                    <div class="clearfix"></div>
                    <div class="message"></div>
                </div>
            </div>

             
            <div class="form-group" id="option">
                <label class="control-label col-sm-3" for="option"><span class="red-star">*</span>{{ trans('survey.option') }}:</label>
                <div class="col-sm-7">
                    <input type="text" data-role="tagsinput" name="option" class="form-control" id="option" placeholder="{{ trans('general.enter',['attribute' => trans('survey.option') ]) }}">
                </div>
            </div>
                
            <div class="form-group">
                <div class="col-sm-10">
                    <button id="jqx-save-question" type="button"​​ class="pull-right"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
                </div>
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="{{asset('css/bootstrap-tagsinput.css')}}" type="text/css" />
    <script src='{{ asset('js/bootstrap-tagsinput.js') }}' type="text/javascript"></script>

    <script>
        $(document).ready(function(){

            function showHideOption(){
                var type = $("#type").val(); 
                if(type == 1 || type == 2 || type == 3  )
                    $('#option').show();
                else
                    $('#option').hide();
            }

            showHideOption();
            $('#type').on('change', function (event) { 
                showHideOption();
            });

            initDropDown('type',{!! $answer_types !!});

            $("#jqx-save-question").click(function(){
                saveJqxItem('_create_question', '{{ secret_route() }}/question', '{{ csrf_token() }}',1,function(response){
                    var question = response.question;
                    $("#question").jqxDropDownList('addItem', { label: question.title,value: question.id } ); 
                    $("#question").jqxDropDownList('selectItem', { label: question.title,value: question.id }); 
                    $('#jqxwindowcreate_question').jqxWindow('destroy');

                });
            });
            
            var buttons = ['jqx-save-question'];
            initialButton(buttons,90,30);
    
        });
    </script>