<?php 
$jqxPrefix = '_officer_checkin_new';
$saveUrl = asset($constant['secretRoute'].'/officer-checkin/add-commend');
$searchNoteUrlDelete = asset($constant['secretRoute'].'/officer-checkin/delete-note');

?>

<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:10px;"></div>
        <div class="form-group">
            <div class="col-sm-6">
                <input type="hidden" id="officer_ids" value="{{isset($officer_id) ? $officer_id:''}}" name="officer_id">
                <label><span class="red-star">*</span> {{trans('attendance.officer_name')}}</label>
                <div id='dev_officer_id'></div>
            </div>
            <div class="col-sm-6">
                <label><span class="red-star">*</span> {{trans('officer.date')}}</label>
                <div id='jqxdatetimeinput' class="calendar"></div>
                <input type="hidden" name="date_dt" id="start_dt" value="{{$date_dt}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <label><span class="red-star">*</span> {{trans('attendance.check')}}</label>
                <fieldset>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="time" value="1" {{isset($time)?$time==1?'checked':'disabled':''}} >
                    {{trans('attendance.in')}}
                  </label>
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="time" value="2" {{isset($time)?$time==2?'checked':'disabled':''}}>
                    {{trans('attendance.out')}}
                  </label>
                </div>
              </fieldset>
            </div>
            <div class="col-sm-6">
                <label><span class="red-star">*</span> {{trans('attendance.turn')}}</label>
                <fieldset>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="section" value="1" {{isset($section)?$section==1?'checked':'disabled':''}}>
                    {{trans('attendance.morning')}}
                  </label>
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="section" value="2" {{isset($section)?$section==2?'checked':'disabled':''}}>
                    {{trans('attendance.evening')}}
                  </label>
                </div>
              </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span>{{trans('attendance.reason')}} </label>
                <textarea rows="4" cols="50" name="note"​ id="note" class="form-control">{{isset($row->detail) ? $row->detail:''}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
                <button id="jqx-delete<?php echo $jqxPrefix;?>" data-id="{{isset($row->id)?$row->id:''}}" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonDelete']}}</button>
            </div>
        </div>
    </form>
</div>
<style type="text/css">
    .checkbox-info{
        width: 15px;
        height:15px;
        position: absolute;
        top: -3px;
        left: 70px;
    }
    .jqx-combobox-input,.jqx-input-content,.jqx-dropdownlist-content{
        padding-left: 10px !important;
    }
</style>
<script>
    $(document).ready(function(){
        var def_type = '<?php echo isset($row->Id)? $row->Id: '';?>';
        var def_viewer = '<?php echo isset($row->mef_viewer)? $row->mef_viewer: '';?>';
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>','jqx-delete<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
        
        var width_form = 600;
        var data =  <?php echo $officer; ?>;
        var officer_id = <?php echo $officer_id; ?>;
        var date_dt = "{{$date_dt}}";
        
        // div_mef_office_id
        initDropDownList(jqxTheme, 400,35, '#dev_officer_id', <?php echo $officer;?>, 'text', 'value', false, '', '0', "#officer_ids","{{$constant['buttonSearch']}}",250);
        
        /*calendar*/
        $("#jqxdatetimeinput").jqxDateTimeInput({ width: '250px', height: '35px',formatString: "yyyy-MM-dd"});
        if(date_dt!=''){
            var date = new Date("{{$date_dt}}");
            $('#jqxdatetimeinput').jqxDateTimeInput('setDate', date);
            $("#jqxdatetimeinput").jqxDateTimeInput({ disabled: true });
            $("#dev_officer_id").jqxDropDownList({ disabled: true });
        }
        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#dev_officer_id', message: ' ', action: 'select',
                    rule: function () {                       
                        if($("#dev_officer_id").val() == 0){
                            return false;
                        }
                        return true;
                    }
                },
                {input: '#note', message: ' ', action: 'blur',
                    rule: function () {                       
                        if($("#note").val() == 0){
                            $('#note').addClass('jqx-validator-error-element');
                            return false;
                        }
                        $('#note').removeClass('jqx-validator-error-element');
                        return true;
                    }
                },

            ]
        });
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
        $("#jqx-delete<?php echo $jqxPrefix;?>").click(function(){
            var $id=$(this).attr('data-id');
            if($id>0){
                var title = '{{$constant['buttonDelete']}}';
                var content = '{{trans('trans.confirm_delete')}}';
                
                $.confirm({
                    icon: 'glyphicon glyphicon-trash',
                    title: title,
                    content: content,
                    draggable: true,
                    buttons: {
                        danger: {
                            text: 'លុប',
                            btnClass: 'btn-blue',
                            action: function(){
                                $.ajax({
                                    type: "POST",
                                    url: '{{$searchNoteUrlDelete}}',
                                    data:{'id':$id,'_token':'{{ csrf_token() }}'},
                                    success : function(response) {
                                        $("#jqx-notification").jqxNotification();
                                        $("#jqx-notification").jqxNotification({animationCloseDelay:1000,autoCloseDelay:3000});  
                                        closeJqxWindowId('jqxwindow'+'{{$jqxPrefix}}');                                          
                                        if(response.code==2){
                                            $('#jqx-notification').jqxNotification({ position: 'top-right',template: "success" }).html(response.message);
                                                $("#jqx-notification").jqxNotification("open");
                                        }else{
                                            $('#jqx-notification').jqxNotification({ position: 'top-right',template: "warning",autoClose: false }).html(response.message);
                                                $("#jqx-notification").jqxNotification("open");
                                            
                                        }
                                    }
                                });
                            }
                        },
                        warning: {
                            text: 'បោះបង់',
                            btnClass: 'btn-red any-other-class'
                        }
                    }
                });
            }
            // saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}',function(respone){
                // console.log($id);
            //     closeJqxWindowId('jqxwindow'+'{{$jqxPrefix}}');
            // });
        });
    });
</script>