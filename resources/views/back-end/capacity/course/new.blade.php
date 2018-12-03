
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-form">
        {{ csrf_field() }}
        <div id='tabs'>
            <ul>
                <li style="margin-left: 30px;">{{ trans('general.basic') }}</li>
                <li>{{ trans('survey.survey_question') }}</li>
                <li>{{ trans('general.attachment') }}</li>
                <li>{{ trans('general.other') }}</li>
            </ul>
            <br/>
            <div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="code">{{ trans('course.code') }}:</label>
                        <div class="col-sm-4">
                            <input type="text" name="code" class="form-control" id="code" placeholder="{{ trans('general.enter',['attribute' => trans('course.code') ]) }}">
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="title"><span class="red-star">*</span>{{ trans('course.title') }}:</label>
                        <div class="col-sm-7">
                            <input type="text" name="title" class="form-control" id="title" placeholder="{{ trans('general.enter',['attribute' => trans('course.title') ]) }}">
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="subject_id"><span class="red-star">*</span>{{ trans('subject.subject') }}:</label>
                        <div class="col-sm-7">
                            <div id="subjects" name="subjects"></div>
                            <div class="clearfix"></div>
                            <div class="message"></div>
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="member_id"><span class="red-star">*</span>{{ trans('training.trainer') }}:</label>
                        <div class="col-sm-7">
                            <div id="members" name="members"></div>
                            <div class="clearfix"></div>
                            <div class="message"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="col-sm-12">
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
                    <br/>
                </div>
            </div>
            <div>
                <div class="col-sm-12">
                </div>
            </div>
            <div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="description">{{ trans('course.description') }}:</label>
                        <div class="col-sm-7">
                            <textarea name="description" class="form-control" id="description" placeholder="{{ trans('general.enter',['attribute' => trans('course.description') ]) }}" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
        <br/>
        <br/>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-7">
                <label for="status" class="control-label">
                    <input type="checkbox" name="status" id="status" value="0">{{ trans('general.inactive') }}
                </label>
                <button id="jqx-save" type="button"​​ class="pull-right"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
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
                            answer_text += '<ul>';
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

        initDropDownMulti('subjects',{!! $subjects !!})
        initDropDownMulti('members',{!! $members !!})

		$("#jqx-save").click(function(){
            saveJqxItem('', '{{ secret_route() }}/course', '{{ csrf_token() }}',1,function(request){
               
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