<div class="container-fluid">
    <br/>
    <form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-form">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="name"><span class="red-star">*</span>{{ trans('survey.name') }}:</label>
                    <div class="col-sm-7">
                        <input type="text" name="name" class="form-control" id="name" placeholder="{{ trans('general.enter',['attribute' => trans('survey.name') ]) }}">
                    </div>
                </div>
            </div>
            <br/>
            <br/>
            <hr/>
            <div class="col-sm-12">
                <h5 style="text-decoration:underline">{{ trans('survey.question_answer') }}</h5>
                <br/>
            </div>
            <div class="col-sm-6">
                <p>បង្កើតសំនួរទៅតាមទម្រង់</p>
                <br>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="location"><span class="red-star">*</span>{{ trans('survey.template') }}:</label>
                    <div class="col-sm-9">
                        <div id="question_template" name="question_template"></div>
                        <div class="clearfix"></div>
                        <div class="message"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <p>ជ្រើសរើសសំនួរដោយផ្ទាល់</p>
                <br>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="location"><span class="red-star">*</span>{{ trans('survey.question') }}:</label>
                    <div class="col-sm-7">
                        <div id="question" name="question_choose"></div>
                        <div class="clearfix"></div>
                        <div class="message"></div>
                        <br/>
                        <p>{{ trans('survey.no_question_help') }}<a href="javascript:void(0);" id="create_new">{{ trans('survey.create_new') }}</a></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <table class="table" id="question_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('survey.question') }}{{ trans('survey.answer') }}</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <p id="error_table_question" style="display:none" class="text-danger"></p>
                <br/>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-7">
                    <label for="status" class="control-label">
                        <input type="checkbox" name="status" id="status" value="0">{{ trans('general.inactive') }}
                    </label>
                    <button id="jqx-save" type="button"​​ class="pull-right"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#tabs').jqxTabs({ width: '100%', height: 'auto', position: 'top'});     
        
        initDropDown('question',{!! $questions !!});
        initDropDown('question_template',{!! $question_templates !!});

        $("#create_new").on('click',function(){
            newJqxItem('create_question', '{{ trans('survey.create_question') }}',600,380, '{{ secret_route() }}/question/create');
        });

        var types = {!! $answer_types !!};

        $('#question').on('change', function (event) { 
            ajaxPostRequest('{{secret_route()}}/question/' + $(this).val(),{},function (response){
                var html = '';
                if(response.type == 1 || response.type == 2 || response.type == 3){
                    var answer_text = '';
                    var split = response.option.split(',');
                    if(split.length){
                        answer_text += '<ul style="margin-bottom:0px">';
                        for(var answer in split){
                            answer_text += '<li>'+split[answer]+'</li>'
                        }
                        answer_text += '</ul>';
                    }
                }

                html += '<tr class="active" question-id="'+response.id+'"><td><input type="hidden" name="question[]" value="'+response.id+'"/></td>';
                    html +='<td>'+response.title+' <span class="label label-info pull-right">'+types[response.type]+'</span> '+ (answer_text ? answer_text : '') +'</td>';
                    html +='<td class="text-center"><a class="remove_question" href="javascript:void(0)"><i class="fa fa-remove text-danger"></i></a></td></tr>';
                
                $('#question_table tbody').append(html);

                $(".remove_question").click(function(){
                    $(this).closest('tr').remove();
                });

            });
        });

        $('#question_template').on('change', function (event) { 
            ajaxPostRequest('{{secret_route()}}/survey-template/' + $(this).val(),{},function (response){

                var html = '';
                for(var index in response.question){
                    var question = response.question[index];

                    if(question.type == 1 || question.type == 2 || question.type == 3){
                        var answer_text = '';
                        var split = question.option.split(',');
                        if(split.length){
                            answer_text += '<ul style="margin-bottom:0px" >';
                            for(var answer in split){
                                answer_text += '<li>'+split[answer]+'</li>'
                            }
                            answer_text += '</ul>';
                        }
                    }
                    
                    html += '<tr class="active" question-id="'+question.id+'"><td><input type="hidden" name="question[]" value="'+question.id+'"/></td>';
                        html +='<td>'+question.title+' <span class="label label-info pull-right">'+types[question.type]+'</span> '+ (answer_text ? answer_text : '') +'</td>';
                        html +='<td class="text-center"><a class="remove_question" href="javascript:void(0)"><i class="fa fa-remove text-danger"></i></a></td></tr>';
                        
                }
                $('#question_table tbody').append(html);

                removeQuestion();
            });
        });

        removeQuestion();
		
		function removeQuestion(){
			$(".remove_question").click(function(){
				$(this).closest('tr').remove();
			});
		}

        $("#jqx-save").click(function(){
            saveJqxItem('', '{{ secret_route() }}/course/survey/'+{{ $course->id }}+'/store', '{{ csrf_token() }}',1,function(request){
               
                $('#error_table_question').hide().html('');
                if(request.status == 422){
                    var response = JSON.parse(request.responseText);
                    $('#error_table_question').show().html(response.question);
                }

                if(request.message) {
                    $('#jqxwindow').jqxWindow('destroy');
                }

            });
        });
        
		var buttons = ['jqx-save'];
		initialButton(buttons,90,30);
    });
</script>