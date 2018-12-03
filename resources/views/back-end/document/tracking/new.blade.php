
<?php
    $jqxPrefix = '_documents';
    $saveUrl = asset($constant['secretRoute'].'/documents/save');
    $sessionUser = session('sessionUser');
    $SecretariatFilterUrl = asset($constant['secretRoute'].'/documents-unit/get-secretariat-filter');
    $DepartmentFilterUrl = asset($constant['secretRoute'].'/documents-unit/get-department-filter');
    $OfficeFilterUrl    = asset($constant['secretRoute'].'/documents-unit/get-office-filter');
    $delete = asset($constant['secretRoute'].'/student/delete-processing-doc');
    $id = 0;
?>

<style>
    table
    {
        font-family: 'KHMERMEF1';
    }
    .contain-color {
        background-color: #f1f1f1;
        padding: 2.01em 16px;
        margin: 20px 0;

        box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;
    }

    *, *:before, *:after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    section {
        display: none;
        padding: 20px 0 0;
        border-top: 1px solid #ddd;
    }


    label {
        display: inline-block;
        margin: 0 0 -1px;
        padding: 15px 25px;
        font-weight: 600;
        text-align: center;
        color: #bbb;
        border: 1px solid transparent;
    }

    label:before {
        font-family: fontawesome;
        font-weight: normal;
        margin-right: 10px;
    }
    label[for*='1']:before { content: '\f1cb'; }
    label[for*='2']:before { content: '\f17d'; }

    label:hover {
        color: #888;
        cursor: pointer;
    }

    input:checked + label {
        color: #555;
        border: 1px solid #ddd;
        border-top: 2px solid orange;
        border-bottom: 1px solid #fff;
    }
    #tab1:checked ~ #content1,
    #tab2:checked ~ #content2
   {
        display: block;
    }

</style>
<div class="container-fluid">
    <div id="file-uploader" style="margin-top: 10px;">
        <form class="form-horizontal" role="form" method="post" name="jqx-form" id="jqx-form" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="ajaxRequestJson" value="true" />
            <input type="hidden" id="id" name="id" value="{{isset($row->id) ? $row->id:0}}">

            <div class="contain-color">
                <h3 style="margin-top: -20px; border-bottom: 1px solid #e0e0e0; margin-bottom: 20px; color: #0a73a7; font-family: 'KHMERMEF2'">ឯកសារចេញ-ចូល</h3>

				<div class="row">
					<div class="col-sm-3">

						<div class="form-group">
							<div class="col-sm-6 text-right" for="source"><span class="red-star">*</span> {{trans('document.source')}} </div>
							<div class="col-sm-6">
								<div id="source" name="source"></div>
								<div class="clearfix"></div>
								<div class="help-block"></div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-6 text-right"><span class="red-star">*</span> {{trans('document.sender')}} </div>
							<div class="col-sm-6">
								<input class="form-control" name="sender" id="sender" value="">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-6 text-right"><span class="red-star">*</span> {{trans('document.contact_number')}} </div>
							<div class="col-sm-6">
								<input class="form-control" name="contact_number" id="contact_number" value="">
							</div>
						</div>
					</div>

                    <div class="col-sm-4">
                        <div class="form-group">
							<div class="col-sm-6 text-right"><span class="red-star">*</span>{{trans('document.flow')}} </div>
                            <div class="col-sm-6">
								<div id="flow" name="flow"></div>
								<div class="clearfix"></div>
								<div class="help-block"></div>
                            </div>
                        </div>	
                        <div class="form-group">
                            <div class="col-sm-6 text-right"><span class="red-star">*</span>{{trans('document.letter_in_serial')}} </div>
                            <div class="col-sm-6">
                                <input class="form-control" name="letter_in_serial" id="letter_in_serial" value="">
                            </div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-6 text-right" style="padding: 10px;">{{trans('document.document_type')}}</div>
							<div class=" col-sm-3" style="padding: 10px;">
								<input type="hidden" id="is_secret" name="is_secret" value="{{isset($row->is_secret) ? $row->is_urgent:0}}">
								<div id="is_secret-checkbox">{{trans('document.is_secret')}} </div>
							</div>
							
							<div class="col-sm-3" style="padding: 10px;">
								<input type="hidden" id="is_urgent" name="is_urgent" value="{{isset($row->is_urgent) ? $row->is_urgent:0}}">
								<div id="is_urgent-checkbox">{{trans('document.is_urgent')}} </div>
							</div>
						</div>
                    </div>
					<div class="col-sm-4">
						<div class="form-group">
							<div class="col-sm-6 text-right"><span class="red-star">*</span>{{trans('document.receiver')}}</div>
							<div class="col-sm-6">
								<input class="form-control" name="receiver" id="receiver">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-6 text-right"><span class="red-star">*</span>{{trans('document.serial_in')}}</div>
							<div class="col-sm-6">
								<input class="form-control" name="admin_serial_in" id="admin_serial_in" admin_serial_in="">
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-6 text-right"><span class="red-star">*</span>{{trans('document.date_in')}}</div>
							<div class="col-sm-6">
                             <input  type="date" id='admin_in_date' name="admin_in_date" />                              
								<div class="clearfix"></div>
								<div class="help-block"></div>
							</div>
						</div>
                    </div>
                    
				</div>              
                <div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-sm-6 text-right"><span class="red-star">*</span>{{trans('document.objective')}}</div>
							<div class="col-sm-6">
								<input class="form-control" name="objective" id="objective" value="">
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group">
							<div class="col-sm-6 text-right"><span class="red-star">*</span>{{trans('document.category')}} </div>
							<div class="col-sm-6">
								<div id="category" name="category"></div>
								<div class="clearfix"></div>
								<div class="help-block"></div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-6 text-right"><span class="red-star">*</span>{{trans('document.refernece_number')}}</div>
							<div class="col-sm-6">
								<input class="form-control" name="refernece_number" id="refernece_number" value="">
							</div>
						</div>	
						<div class="form-group">
							<div class="col-sm-6 text-right"><span class="red-star">*</span>{{trans('document.privacy')}}</div>
							<div class="col-sm-6">
								<div id="privacy" name="privacy"></div>
								<div class="clearfix"></div>
								<div class="help-block"></div>
							</div>
						</div>	
					</div>
					
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-2 text-right" style="padding: 10px;"><span class="red-star">*</span>ឯកសារ</div>
						<div class="col-sm-10">
							<input type="file" class="form-control" id="path_file" name="path_file[]" value="{{isset($row->path_file) ? $row->path_file:''}}" multiple="multiple">
						</div>
					</div>
					<div class="form-group" >
						<div class="col-sm-offset-9 col-sm-3">
							<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
						</div>
					</div>					
				</div>			
            </div>
						
           </div>

         </div>
            {{--END doc--}}
        </form>

    </div>
</div>
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $(document).ready(function(){
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
        // is_urgent checkbox
        var is_urgent = $('#is_urgent').val() == 1 ? true : false;
        $("#is_urgent-checkbox").jqxCheckBox({theme: jqxTheme, width: 120, height: 25, checked: is_urgent});
        $('#is_urgent-checkbox').on('change', function (event) {
            event.args.checked == true ? $('#is_urgent').val(1) : $('#is_urgent').val(0);
        });

		 // is_secret checkbox
		 var is_secret = $('#is_secret').val() == 1 ? true : false;
        $("#is_secret-checkbox").jqxCheckBox({theme: jqxTheme, width: 120, height: 25, checked: is_secret});
        $('#is_secret-checkbox').on('change', function (event) {
            event.args.checked == true ? $('#is_secret').val(1) : $('#is_secret').val(0);
        });

        // source select box
        initDropDown('source',{!! $source !!});
        initDropDown('flow',{!! $flow !!});
        initDropDown('category',{!! $category !!});
        initDropDown('privacy',{!! $privacy !!});
    
        $("#admin_in_date").jqxDateTimeInput({ width : 200, height : 25, formatString : "dd/MMM/yyyy" });
        $("#jqx-save").click(function(){
            saveJqxItem('', '{{ secret_route() }}/tracking', '{{ csrf_token() }}');
        });

        myUploadInput = $("input[type=file]").uploadPreviewer();
        
        $('#addbutton').click(function() {
            var lastId = $('#TProcessingDoc tr:last').attr("id");
            lastId = lastId.substr(16);
            // alert(lastId);
            addMore(lastId);
        });

    });

    //remove
    function removeProcessingDoc(id){
        // alert(id);

        var test = [];
        var sId = $('#sib_id_'+id).val();
        var name = $('#name'+id).val();
        // test.push(name,gender,order,valueSituation,levelTraining,job,organization,phone);
        if(name == ''){
            $('#processingDocTr_'+id).remove();
            return;
        }else{
            if(sId == ''){
                if(name != ''){
                    var txt = 'តើអ្នកពិតជាចង់លុប​?';
                    var status = confirmDialog(txt);
                    if(status == false){
                        return;
                    }else{
                        $('#processingDocTr_'+id).remove();
                    }
                }

            }else{
                var txt = 'តើអ្នកពិតជាចង់លុប​?';
                var status = confirmDialog(txt);
                if(status == false){
                    return;
                }else{
                    $.ajax({
                        type: 'POST',
                        url: "{{ $delete }}",
                        data: {sId : sId, _token : '{{ csrf_token() }}'},
                        dataType: "json",
                        success: function(response) {
                            $('#jqx-notification').jqxNotification({ position: 'top-right', template: "success" }).html(response.message);
                            $("#jqx-notification").jqxNotification("open");
                        }
                    });
                    $('#processingDocTr_'+id).remove();
                }
            }

        }
    }


    //add more
    function addMore(lastId){
        var info_id = parseInt(lastId) + 1;
        var No = info_id + 1;
        var str = '<tr id="processingDocTr_'+info_id+'">'
        str = str + '<td>'+No+'</td>'

        str = str + '<td>'
        str = str + '<input type="text" class="form-control" placeholder="មន្ត្រី" id="name_'+info_id+'" name="processingDoc['+info_id+'][name]" value="{{isset($sibling['+lastId+']->name) ? $sibling['+lastId+']->name:''}}">'
        str = str + '</td>'

        str = str + '<td>'
        str = str + '<button type="button" class="btn btn-primary jqx-primary" id="addbutton'+info_id+'" onclick="removeProcessingDoc('+info_id+');"><i class="fa fa-minus"></i></button>'
        str = str + '</td>'
        str = str+ '</tr>'
        $(str).insertAfter( "#processingDocTr_"+ lastId );

    }


 $('#lfm').filemanager('image');

</script>