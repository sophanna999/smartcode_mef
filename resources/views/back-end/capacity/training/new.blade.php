
<div class="container-fluid">
    <br/>
    <form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-form" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-6" for="prefix"><span class="red-star">*</span>{{ trans('training.code') }}:</label>
                    <div class="col-sm-5">
                        <input value="{{ 'TRA'.date('dmy') }}" type="text" name="prefix" class="form-control" id="prefix" placeholder="{{ trans('general.enter',['attribute' => trans('training.prefix') ]) }}">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="col-sm-4 " style="padding-right:0px; padding-left:0px;">
                        <input type="text" name="code" class="form-control" id="code" placeholder="{{ trans('general.enter',['attribute' => trans('training.code') ]) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="course"><span class="red-star">*</span>{{ trans('training.course') }}:</label>
            <div class="col-sm-9">
                <div id="course" name="course"></div>
                {{-- <div class="clearfix"></div> --}}
                <div class="message"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="members"><span class="red-star">*</span>{{ trans('training.trainer') }}:</label>
            <div class="col-sm-9">
                <div id="members" name="members"></div>
                <div class="clearfix"></div>
                <div class="message"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="start_date"><span class="red-star">*</span>{{ trans('training.start_date') }}:</label>
                    <div class="col-sm-6">
                        <div id="start_date_picker" name="start_date" data-placeholder="{{ trans('general.enter',['attribute' => trans('training.start_date') ]) }}"></div>
                        <div class="clearfix"></div>
                        <div class="message"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="end_date"><span class="red-star">*</span>{{ trans('training.end_date') }}:</label>
                    <div class="col-sm-6">
                        <div id="end_date_picker" name="end_date" data-placeholder="{{ trans('general.enter',['attribute' => trans('training.end_date') ]) }}"></div>
                        <div class="clearfix"></div>
                        <div class="message"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="location"><span class="red-star">*</span>{{ trans('training.location') }}:</label>
                    <div class="col-sm-8">
                        <div id="location" name="location"></div>
                        <div class="clearfix"></div>
                        <div class="message"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label pull-left col-sm-9" for="location">{{ trans('training.outside_location') }} ? <input name="outside_location" value="1" class="show_hide" data-toggle="outside_location" type="checkbox"/></label>
                </div>
            </div>
        </div>

        <div class="form-group outside_location" style="display:none">
            <label class="control-label col-sm-2" for="description">{{ trans('training.name_of_outside_location') }}:</label>
            <div class="col-sm-9">
                <input type="text"​ name="name_of_outside_location" class="form-control" id="name_of_outside_location" placeholder="{{ trans('general.enter',['attribute' => trans('training.name_of_outside_location') ]) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="description">{{ trans('training.description') }}:</label>
            <div class="col-sm-9">
                <textarea name="description" id="description"></textarea>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-sm-2" for="attachments">{{ trans('training.attachment') }}: </label>
            <div class="col-sm-3">
                <input type="file" name="attachments[]" id="attachments" class="form-control"  accept="application/pdf">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <label for="status" class="control-label">
                    <input type="checkbox" name="status" id="status" value="0">{{ trans('general.inactive') }}
                </label>
                <button id="jqx-save" type="button"​​ class="pull-right"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
</div>

<script>


    function showHide()
    {
        var attr = $('.show_hide');
        
        if(attr.is(':checked'))
        {
            $('.outside_location').show();
            $("#location").jqxDropDownList({ disabled: true }); 
        }
        else
        {
            $('.outside_location').hide();
            $("#location").jqxDropDownList({ disabled: false }); 
        }
    }

    showHide();

    $(document).ready(function(){
        var editor = CKEDITOR.replace('description', {
         filebrowserImageBrowseUrl: '{{asset('/laravel-filemanager?type=Images')}}',
         filebrowserImageUploadUrl: '{{asset('/laravel-filemanager/upload?type=Images')}}&_token={{csrf_token()}}',
         filebrowserBrowseUrl: '{{asset('/laravel-filemanager?type=Files')}}',
         filebrowserUploadUrl: '{{asset('laravel-filemanager/upload?type=Files')}}&_token={{csrf_token()}}'
     });

        initDropDown('course',{!! $courses !!});
        initDropDown('location',{!! $locations !!});
        initDropDownMulti('members',{!! $members !!});
        getJqxDatePicker('start_date_picker');
        getJqxDatePicker('end_date_picker');
        
        $('.show_hide').on('change',function(){
            showHide();
        });

        $("#jqx-save").click(function(){
            saveJqxItem('', '{{ secret_route() }}/training/store', '{{ csrf_token() }}');
        });
        
        var buttons = ['jqx-save'];
        initialButton(buttons,90,30);

    });

    //Function auto select other dropdown

    $(function(){
        $("#course").change(function () {
            var course_id = $(this).val();
            $.ajax({
                type:"post",
                url: '{{ secret_route() }}/training/course-data',
                datatype: "json",
                data: {"course_id":course_id,"_token":'{{ csrf_token() }}'},
                success : function(data){
                    $("#members").jqxDropDownList('uncheckAll');
                    if (data.course_selected.length) {
                        for (var i = 0; i < data.course_selected.length ; i++) {
                            $('#members').jqxDropDownList('checkItem', data.course_selected[i],{width: '500px'});
                        }
                    }else{
                        $('#members').parents('div[class^="form-group"]').append('<input type="hidden" name="members[]" value="">');
                    }
                }
            });

        });
    });
</script>